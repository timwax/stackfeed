<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('startpage');
});

Route::group(['prefix' => 'accounts'], function(){
	Route::get('signup', function(){
		return View::make('accounts.signup');
	});

	Route::get('registration/success', function(){
		return View::make('accounts.sucess');
	});

	Route::get('logout', function(){
		Auth::logout();

		return Redirect::to('/');
	});

	Route::get('login', function(){
		return View::make('accounts.login');
	});

	Route::post('login', function(){
		$rules = ['username' => ['required'], 'password' => 'required'];

		$v = Validator::make(Input::all(), $rules);

		if($v->fails()){
			return Redirect::to('accounts/login')->withErrors($v)->withInput();
		}

		// Valid stuff

		$credentials = ['username' => Input::get('username'), 'password' => Input::get('password')];

		if(Auth::attempt($credentials)){
			return Redirect::intended('home');
		}else{
			return Redirect::to('accounts/login')->withErrors('Invalid username/password combination, try again');
		}
	});

	Route::post('signup', function(){
		$rules = [
			'username' => [
				'required',
				'min:5',
				'alpha-dash',
				'unique:users'
			],
			'email' => [
				'required',
				'email',
				'unique:users'
			],
			'password' => [
				'required',
				'confirmed',
				'min:5'
			],
			'agree' => ['accepted']
		];

		$v = Validator::make(Input::all(), $rules);

		if ($v->fails()){
			return Redirect::to('accounts/signup')->withErrors($v)->withInput(Input::flashExcept('password', 'password_confirmation'));
		}

		// Save user credentials

		$user = new User();

		$user->username = Input::get('username');
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));
		$user->activated = 1;

		if ($user->save()){
			// Create a verification job
			Queue::push('UserJobs@onregister', array('user' => $user->toArray()));
			
			return Redirect::to('accounts/registration/success')->with($user->toArray());
		}

		Log::warning('Failed to create account', json_encode($user->toArray()));
		return Redirect::to('accounts/signup')->withErrors(['system' => 'Something went wrong, try again later'])->with($user->toArray());

	});
});

Route::get('home', ['before' => 'auth' , function(){
	$response = [];

	return View::make('dashboard.home', $response);
}]);

Route::group(['prefix' => 'embed'], function(){
	Route::get('feedback.php', function(){

		$limit = Config::get('app.ratelimit') ? Config::get('app.ratelimit') : 3;

		if (Cache::get('ratelimit_' . $_SERVER['REMOTE_ADDR']) >= $limit) {
			Session::set('caller', urldecode(Request::fullUrl()));

			return Redirect::to('embed/captcha.php');
		}

		$project = Project::where('public_id', '=', Input::get('pid'))->first();

		if (!isset($project->id) || !$project->active ) return Response::make('');

		return View::make('embed.feedback', ['status' => '1']);
	});

	// Catcha route
	Route::get('captcha.php', function(){
		$builder = new Gregwar\Captcha\CaptchaBuilder();

		$builder->build(200, 50);

		Session::set('captcha', $builder->getPhrase());

		return View::make('embed.captcha', array('builder' => $builder));
	});

	Route::post('captcha.php', function(){
		Log::debug('Validated captcha: '. Session::get('captcha'), Input::all());

		if(Input::has('captcha') && strtolower(Input::get('captcha')) == strtolower(Session::get('captcha'))){
			// We are good

			// Reset ratelimit
			Cache::put('ratelimit_' . $_SERVER['REMOTE_ADDR'], 0, 60);

			// Redirect to requested

			Log::info('Awesome dude');

			return Redirect::to(Session::get('caller'));
		}

		return Redirect::to('embed/captcha.php')->with('msg', 'Invalid captcha entered');
	});
});


Route::post('fb.php', function(){
	$rules = [
		'message' => 'required',
		'project' => 'required|exists:projects,public_id'
	];

	Log::debug('Request', Input::all());

	$v = Validator::make(Input::all(), $rules);

	if ($v->fails()){
		return Response::json([ 'message' => 'Sending feedback failed, try again later'], 449);
	}

	// Check rate limit
	
	$limit = Config::get('app.ratelimit') ? Config::get('app.ratelimit') : 3;

	$ip = $_SERVER['REMOTE_ADDR'];

	Log::debug($ip);

	if (Cache::has( 'ratelimit_' . $ip )){
		$_limit = Cache::get('ratelimit_' . $ip);
	}else{
		Cache::put('ratelimit_' . $ip, 0, 60);
		$_limit = 0;
	}

	Log::debug('Current rate limit: ' . $_limit);
	// Get project
	$project = Project::where('public_id', '=', Input::get('project'))->first();

	// Check rate limit

	if (Auth::check() && Auth::user()->id == $project->user_id){
		// Accept user rate limiting 30/hr
		Log::debug('Hey', Auth::user()->username);

	}else{
		Log::debug('Rate limiting as anonymous ');

		if ( $_limit >= $limit ){
			return Response::json(array('type' => 'ratelimit', 'message' => 'Check if you are human'));
		} 
	}
	

	$message = new Message();

	$message->content = Input::get('message');
	$message->email = Input::get('email');
	$message->fullName = Input::get('name');
	$message->project_id = $project->id;
	$message->ip = $_SERVER['REMOTE_ADDR'];
	$message->meta = json_encode(Input::get('meta'));

	Log::debug('Message', $message->toArray());
	if($message->save()){
		// Increment ratelimit
		Cache::increment('ratelimit_' . $ip);
		
		// Saved OK
		Queue::push('MessageJobs@onadd', array('message' => $message->toArray(), 'project' => $project->toArray()));
		
		return Response::json(['message' => 'Message sent to team']);
	}else{
		return Response::json([ 'message' => 'Sending feedback failed, try again later'] , 500);
	}
});

Route::group(['before' => 'auth', 'prefix' => 'api/v1'], function(){
	Route::resource('projects', 'ProjectREST');
	Route::resource('messages', 'MessageREST');
	Route::get('projects/{id}/messages', ['uses' => 'MessageREST@index']);
	Route::post('messages/{id}/star', ['uses' => 'MessageREST@star']);

	// Search entry point
	Route::post('messages/{id}/star', ['uses' => 'MessageREST@star']);

	// Index messages
	Route::get('index/messages', function(){

		$messages = Message::all();

		if (count($messages) > 0){
			foreach($messages as $message){
				// Format indexed fields

				$index = new MessageIndex();
				$index->index($message->toArray());
			}
		}

	});

	Route::get('search/messages', function(){
		$response = array();

		$client = new \Elastica\Client();

		$index = $client->getIndex('feedback');

		if (!Input::has('pid')) return Response::make('{"status": "1", "message": "Project not specified"}');

		// Check if account has privileges on project

		$boolQuery = new Elastica\Query\Bool();

		if(Input::has('q') && Input::get('q') != ''){
			$content = new Elastica\Query\Text();
			$content->setField('content', Input::get('q'));
			$boolQuery->must($content);
		}
		

		$project = new Elastica\Query\Term();
		$project->setTerm('project_id', Input::get('pid'));	
		$boolQuery->addMust($project);	

		if (Input::has('stared')){
			$stared = new Elastica\Query\Term();
			$stared->setTerm('stared', Input::get('stared'));

			$boolQuery->addMust($stared);
		}
		
		if (Input::has('browser')){
			if (substr_count(Input::get('browser'), ',') > 0){
				// Multiple browsers
				$terms = new Elastica\Query\Terms('browser', preg_split('/,/', strtolower(Input::get('browser'))));
				$terms->addParam('minimum_should_match', 1);
				$boolQuery->addShould($terms);
			}else{
				// Single browser

				$browser = new Elastica\Query\Term();
				$browser->setTerm('browser', strtolower(Input::get('browser')));

				$boolQuery->addMust($browser);
			}
			
		}		

		if (Input::has('os')){
			$os = new Elastica\Query\Term();
			$os->setTerm('os', strtolower(Input::get('os')));

			$boolQuery->addMust($os);
		}
		

		$query = new Elastica\Query($boolQuery);

		//print_r($query->getParams());
		$query->setLimit(25);

		$rs = $index->search($query);

		if ($rs->count() > 0){
			foreach($rs->getResults() as $result){
				$response[] = $result->getData();
			}
		}

		return Response::json($response);
	});
});

Route::get('test', function(){
	$p = new ProjectIndex(1);

	$p->get();

	return Response::make('');
});

Route::get('/p/{page}', function($page){
	return View::make('pages.index', [ 'content' => Markdown::make($page), 'title' => $page ]);
});