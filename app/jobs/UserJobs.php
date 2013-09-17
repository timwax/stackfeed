<?php

class UserJobs{
	public function onregister($job, $data){
		Log::debug('Starting onregisteruser: ', $data);
		
		// Send validation email
		
		// Create user storage folder
		
		$job->delete();
	}
}
