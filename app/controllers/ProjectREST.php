<?php

class ProjectREST extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::json(Project::where('user_id', '=', Auth::user()->id)->get());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
			'name' => 'required|min:5'
		];

		$v = Validator::make(Input::all(), $rules);

		if ($v->fails()){
			return Response::json($v->messages(), 500);
		}

		// Save project

		$project = new Project();

		$project->name = Input::get('name');
		$project->public_id = Str::random('12');
		$project->description = Input::get('description', '');
		$project->domain = Input::get('domain', '');
		$project->active = Input::get('active');

		$project->user_id = Auth::user()->id;

		Log::debug('Create project', $project->toArray());

		if($project->save()){
			// Call job
			Queue::push('ProjectJobs@onadd', ['project' => $project->toArray()]);
			
			return Response::json($project->toArray());
				
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$messages = Message::where('project_id', '=', $id)
		->whereRaw('messages.read is null')
		->count(); // Cache this

		$project = Project::find($id);

		$response = $project->toArray();
		$response['messages'] = $messages;
		$response['host'] = Config::get('app.hostname');

		return Response::json($response);
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
		$project = Project::find($id);

		// Validate

		$project->name = Input::get('name');
		$project->description = Input::get('description');
		$project->domain = Input::get('domain');
		$project->active = Input::get('active');

		if($project->save()){
			Queue::push('ProjectJobs@onedit', ['project' => $project->toArray()]);
			return Response::json($project->toArray());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$project = Project::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->first();
		
		if (!isset($project->id)) return Response::json([]);
		
		if($project->delete()){
			Queue::push('ProjectJobs@ondelete', ['project' => $project->toArray()]);
			
			return Response::json([]);
		}
	}

}
