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
			return Redirect::to('accounts/login')->with('message', 'Invalid username/password combination, try again');
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