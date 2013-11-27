<?php

class ProjectRepository{
	function find($id){
		$project = Project::where('id', '=', $id)->remember(3600, 'project_' . $id)->first();
		
		return $project;
	}
}