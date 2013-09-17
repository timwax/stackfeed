<?php

class ProjectJobs{
	public function onadd($job, $data){
		Log::debug('Starting onaddproject: ', $data);
		// Create project stats with defaults
		
		// Create project search index
		$job->delete();
	}
	
	public function ondelete($job, $data){
		Log::debug('Starting ondeleteproject: ', $data);
		// Remove project stats
		
		// Clear project search index
		
		// Remove/Archive all projects messages
		
		$job->delete();
		
	}
	
	public function onedit($job, $data){
		Log::debug('Starting oneditproject: ', $data);
		// Update project search index
		
		$job->delete();
	}
}
