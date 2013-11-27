<?php

class Feedback extends BaseController{
	function store(){
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
		$message->email = Input::get('email', '');
		$message->fullName = Input::get('name', '');
		$message->project_id = $project->id;
		$message->ip = $_SERVER['REMOTE_ADDR'];
		$message->meta = json_encode(Input::get('meta'));
		$message->deleted_at = null;
		$message->read = null;
		$message->stared = 0;

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
	}
}