<?php

class MessageJobs{
	
	public function onadd($job, $data){
		Log::debug('Starting onaddmessage: ', $data);
		
		// Increment project stats count(new messages, total)
		$project = Project::where('id', '=', $data['project']['id'])->update(array('new_messages' => DB::raw('projects.new_messages + 1'), 'total_messages' => DB::raw('projects.total_messages + 1')));

		// Add message to project messages cache
		
		// Add message to project search index
		$this->indexMessage($data['message']);
		
		$job->delete();
	}
	
	public function ondelete($job, $data){
		Log::debug('Starting ondeletemessage: ', $data);
		
		// Update project stats
		
		// Update cache
		
		// Update search index
		$this->indexMessage($data['message']);
		
		$job->delete();
	}
	

	public function onedit($job, $data){
		Log::debug('Starting oneditmessage: ', $data);
		// Sub Jobs
			// Mark as read
			
			// Mark as spam
			
			// Update message cache and search index
		$this->indexMessage($data['message']);
		
		$job->delete();
	}
	
	public function onread($job, $data){
		Log::debug('Starting onreadmessage: ', $data);
		// Check read status
		
		if (!$data['message']['read']){
			$job->delete();
		}

		Log::debug('Job continues');
		// Update project new stats
		
		Project::where('id', '=', $data['project']['id'])->update(array('new_messages' => DB::raw('projects.new_messages - 1')));
		// Mark project as read

		Message::where('id', '=', $data['message']['id'])
		->update(array('read' => DB::raw('NOW()'), 'read_by' => Auth::user()->id));

		$job->delete();
	}

	function indexMessage($message){
		$elasticaClient = new Elastica\Client();

		$elasticaIndex = $elasticaClient->getIndex('feedback');

		if(!$elasticaIndex->exists())
			$elasticaIndex->create();

		$elasticaType = $elasticaIndex->getType('message');

		// Format indexed fields

		$msg = array(
			'content' => $message['content'],
			'project_id' => $message['project_id'],
			'ip' => $message['ip'],
			'deleted' => $message['deleted_at'],
			'read' => $message['read'],
			'stared' => $message['stared'],
			'created_at' => date('c', strtotime($message['created_at']))
		);

		if ($message['meta'] != ''){
			// Parse UA

			$meta = json_decode($message['meta']);

			if (isset($meta->userAgent)){
				$parser = new UA();

				$result = $parser->parse($meta->userAgent);

				$msg['browser'] = strtolower($result->ua->family);
				$msg['browser_version'] = $result->ua->toVersionString;						

				$msg['os'] = strtolower($result->os->family);
				$msg['os_version'] = $result->os->toVersionString;

				$msg['info'] = array(
					"browser" => $msg['browser'],
					"browserFull" => $msg['browser'] . ' ' . $msg['browser_version'],
					"browserVersion" => $msg['browser_version'],
					"os" => $msg['os'],
					"osFull" => $msg['os'] . ' ' . $msg['os_version'],
					"osVersion" => $msg['os_version'],
				);
			}

			if(isset($meta->uri)) $msg['uri'] = $meta->uri;
		}

		$doc = new Elastica\Document($message['id'], $msg);

		$elasticaType->addDocument($doc);
	}
}
