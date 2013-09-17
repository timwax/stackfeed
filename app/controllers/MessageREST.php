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

			if ($project->user_id == Auth::user()->id){
				$response = $message->toArray();
				$response['meta'] = json_decode($response['meta']);
				$response['project'] = $project->toArray();
				
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
	
				Queue::job('MessageJobs@ondelete', array('message' => $message->toArray(), 'project' => $project->toArray()));
				
				return Response::json([]);
			}
		}

		return Response::make('', 403);
	}

}
