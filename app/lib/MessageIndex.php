<?php

class MessageIndex{
	function index($message){
		// Create index

		$client = new \Elastica\Client();

		$index = $client->getIndex('feedback');

		if (!$index->exists()) $index->create();

		$type = $index->getType('message');

		
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

				// Info

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

		$type->addDocument($doc);

		// Create job for project filters
	}
}