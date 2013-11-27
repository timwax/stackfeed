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

	Route::get('logout', array('as' => 'logout', function(){
		Auth::logout();

		return Redirect::to('/');
	}));

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

Route::group(array('prefix' => 'ui', 'before' => 'auth'), function(){

	/* Project dashboard */
	Route::get('project', array('as' => 'project-dashboard', function(){
		$messages = new MessageRepository();

		$feedback = $messages->feedback(1, 3);

		return View::make('project.dashboard', array('feedback' => $feedback));
	}));	

	/* Project feedback */
	Route::get('project/feedback', array('as' => 'project-feedback', function(){

		$messages = Message::orderBy('created_at', 'DESC')->paginate(25);

		$links = $messages->links();
		$paginate = array('from' => $messages->getFrom(), 'to' => $messages->getTo(), 'total' => $messages->getTotal());
		$items = array();

		$parse = new UA();

		foreach ($messages as $key => $value) {

			$item = $value->toArray();

			if ($value->meta != ''){
				$meta = json_decode($value->meta);

				if (isset($meta->userAgent)){
					$userAgent = $meta->userAgent;

					$results = $parse->parse($userAgent);

					$item['browser'] = $results->ua->family;
					$item['browserFull'] = $results->ua->toString;
				}
				
			}

			$items[] = $item;
		}

		return View::make('project.feedback', array('messages' => $items, 'links' => $links, 'paginate' => $paginate));
	}));

	/* Project setting */
	Route::get('project/settings/basic', array('as' => 'project-settings-basic', function(){
		$projectRepository = new ProjectRepository();

		return View::make('project.settings.basic', ['project' => $projectRepository->find(1)]);
	}));	

	/* Project setting */
	Route::get('project/embed', array('as' => 'project-embed', function(){
		return View::make('project.embed');
	}));	

	/* Project setting */
	Route::get('project/feedback/message', array('as' => 'project-feedback-message', function(){
		$feedback = new MessageRepository();
		$projectRepository = new ProjectRepository();

		$message = $feedback->get(59);
		$project = $projectRepository->find($message->project_id);

		return View::make('project.feedback-message', array('message' => $message, 'project' => $project));
	}));

	/*
	 * Actions
	 */
	
	Route::post('project/{project_id}/settings/basic', ['as' => 'save.project.settings.basic', function($project_id){
		$projectRepository = new ProjectRepository();

		$project = $projectRepository->find($project_id);

		if (!$project) return Redirect::route('project-settings-basic', array('project_id' => $project_id))->with('error', 'Project not found :D');
		// Check project ownership
		
		if ($project->user_id != Auth::user()->id) return Redirect::route('project-settings-basic', array('project_id' => $project_id))->with('error', 'You dont have permissions to edit this project :D');
		
		$project->name = Input::get('name');
		$project->description = Input::get('description');
		$project->domain = Input::get('domain');

		if($project->save())
			Cache::forget('project_'.$project_id);
		
			return Redirect::route('project-settings-basic', array('project_id' => $project_id));
	}]);
});

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

	Route::get('feedback-v0.2.php', function(){

		$limit = Config::get('app.ratelimit') ? Config::get('app.ratelimit') : 3;

		if (Cache::get('ratelimit_' . $_SERVER['REMOTE_ADDR']) >= $limit) {
			Session::set('caller', urldecode(Request::fullUrl()));

			return Redirect::to('embed/captcha.php');
		}

		$project = Project::where('public_id', '=', Input::get('pid'))->first();

		if (!isset($project->id) || !$project->active ) return Response::make('');

		return View::make('embed.feedback-v2', ['status' => '1']);
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

/*
 * Project routes
 */


Route::group(['prefix'=>'projects', 'before' => 'auth'], function(){
	Route::get('{project_id}', function($project_id){

		$projectRepository = new ProjectRepository();

		$project = $projectRepository->find($project_id);

		if (Cache::has('project_1')) print_r(Cache::get('project_1'));

		return Response::json($project->toArray());
	})->where('project_id', '[0-9]+');	

	Route::get('{project_id}/feedback', function($project_id){
		return $project_id . ' Feedback';
	})->where('project_id', '[0-9]+');	

	Route::get('{project_id}/feedback/{message_id}', function($project_id){
		return $project_id . ' Feedback Message';
	})->where(['project_id' => '[0-9]+', 'message_id' => '[\d]+']);
});



Route::post('fb.php', array('uses' => 'Feedback@store'));

Route::group(['before' => 'auth', 'prefix' => 'api/v1'], function(){
	Route::resource('projects', 'ProjectREST');
	Route::resource('messages', 'MessageREST');
	Route::get('projects/{id}/messages', ['uses' => 'MessageREST@index']);

	// Project filters
	Route::get('projects/{id}/filters', function($id){
		$p = new ProjectIndex($id);

		$results = $p->get();

		$response = array('browsers' => array(), 'os' => array(), 'language' => array());

		$facets = $results->getFacets();

		// Get browsers

		if (count($facets['browsers']['terms'])){
			foreach ($facets['browsers']['terms'] as $key => $value) {
				$response['browsers'][] = $value;
			}
		}

		return Response::json($response);
	});

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
	$messageRepository = new MessageRepository();

	$response = $messageRepository->get(59);

	return Response::json($response);
});

Route::get('/p/{page}', function($page){
	return View::make('pages.index', [ 'content' => Markdown::make($page), 'title' => $page ]);
});

Route::get('suite', function(){
	return View::make('homepage');
});