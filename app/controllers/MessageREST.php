<?php

class MessageREST extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($pid)
	{
		$messages = [];

		// Verify project ownership

		$project = Project::find($pid);

		if (isset($project->id) && $project->user_id == Auth::user()->id){
			$messages = Message::where('project_id', '=', $pid)->orderBy('created_at', 'DESC')->get();

			$parser = new UA();

			foreach ($messages as $key => $value) {

				$meta = json_decode($value->meta, 1);

				if (isset($meta['userAgent'])){
					$result = $parser->parse($meta['userAgent']);

					$ua = array();

					$ua['browser'] = $result->ua->family;
					$ua['browserVersion'] = $result->ua->toVersionString;
					$ua['browserFull'] = $result->ua->toString;

					$ua['os'] = $result->os->family;
					$ua['osFull'] = $result->os->toString;
					$ua['osVesion'] = $result->os->toVersionString;

					$messages[$key]->info = $ua;
				}

				if (!isset($value->stared))
					$messages[$key]->stared = 0;
			}
		}
		
		return Response::json($messages);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$message = Message::find($id);

		if ($message->id){
			// Load project

			$project = Project::find($message->project_id);

			// Check if one has access to project

			$parser = new UA();
			

			if ($project->user_id == Auth::user()->id){
				$response = $message->toArray();
				$response['meta'] = json_decode($response['meta']);
			
				$response['project'] = $project->toArray();

				if ($response['meta']->userAgent != ''){
					$result = $parser->parse($response['meta']->userAgent);

					$ua = array();

					$ua['browser'] = $result->ua->family;
					$ua['browserVersion'] = $result->ua->toVersionString;
					$ua['browserFull'] = $result->ua->toString;

					$ua['os'] = $result->os->family;
					$ua['osFull'] = $result->os->toString;
					$ua['osVesion'] = $result->os->toVersionString;

					$response['info'] = $ua;
				}
				
				Queue::push('MessageJobs@onread', array('message' => $message->toArray(), 'project' => $project->toArray()));
				
				return Response::json($response);
			}
		}

		return Response::make('', 403);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$message = Message::find($id);

		if ($message->id){
			// Load project

			$project = Project::find($message->project_id);

			// Check if one has access to project

			if ($project->user_id == Auth::user()->id){
				if (Input::has('type') && Input::get('type') == 'forever'){
					$message->forceDelete();
				}else{
					$message->delete();
				}
	
				Queue::push('MessageJobs@ondelete', array('message' => $message->toArray(), 'project' => $project->toArray()));
				
				return Response::json([]);
			}
		}

		return Response::make('', 403);
	}

	/*
	 * Star message
	 */
	
	public function star($id){
		$message = Message::find($id);

		if ($message->id){
			// Load project

			$project = Project::find($message->project_id);

			// Check if one has access to project

			if ($project->user_id == Auth::user()->id){
				$stared = Input::get('star') == 1 ? 1 : 0;
				
				$message->stared = $stared;

				$message->save();

				Queue::push('MessageJobs@onedit', array('message' => $message->toArray(), 'project' => $project->toArray()));
				
				return Response::json(['stared' => $message->stared]);
			}
		}
	}

}
