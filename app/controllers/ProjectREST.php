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

		if($project->save())
			return Response::json($project->toArray());

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Response::json(Project::find($id));
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
		//
	}

}