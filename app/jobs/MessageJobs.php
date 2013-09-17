<?php

class MessageJobs{
	
	public function onadd($job, $data){
		Log::debug('Starting onaddmessage: ', $data);
		
		// Increment project stats count(new messages, total)
		
		// Add message to project messages cache
		
		// Add message to project search index
		
		$job->delete();
	}
	
	public function ondelete($job, $data){
		Log::debug('Starting ondeletemessage: ', $data);
		
		// Update project stats
		
		// Update cache
		
		// Update search index
		
		$job->delete();
	}
	
/*

	public function onedit($job, $data){
		Log::debug('Starting oneditmessage: ', $data);
		// Sub Jobs
			// Mark as read
			
			// Mark as spam
			
			// Update message cache and search index
		
		$job->delete();
	}

*/
	
	public function onread($job, $data){
		// Check read status
		
		// Update project new stats
		
		// Mark project as read
	}
}
