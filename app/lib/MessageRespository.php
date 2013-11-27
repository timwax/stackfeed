<?php

class MessageRepository{
	/*
	 * Get projects feedback messages
	 *
	 * Return feedback from a project. This needs authentication that the user is granted or is owner
	 * 
	 * @param int project The project to get feedback from
	 * @param int limit
	 * 
	 * @return Eloquent\Collection
	 */
	
	function feedback($project = 1, $limit = 25){
		$messages = Message::where('project_id', '=', 1)->orderBy('created_at', 'DESC')->paginate($limit);

		$links = $messages->links();

		$paginate = array(
			'from' => $messages->getFrom(), 
			'to' => $messages->getTo(), 
			'total' => $messages->getTotal()
		);

		$items = array();

		$parse = new UA();

		foreach ($messages as $key => $value) {

			$item = $value->toArray();

			if ($value->meta != ''){
				$meta = json_decode($value->meta);

				if (isset($meta->userAgent)){
					$userAgent = $meta->userAgent;

					$results = $parse->parse($userAgent);

					$item['browser'] = $results->ua->family;
					$item['browserFull'] = $results->ua->toString;

					$messages[$key]->browser = $results->ua->family;
					$messages[$key]->browserFull = $results->ua->toString;
				}

				if (isset($meta->uri)) $messages[$key]->link = $meta->uri;
				
			}
		}

		return $messages;
	}

	function get($id){
		$message = Message::where('id', '=', $id)->remember(3600, 'feedback_'.$id)->first();

		if (!isset($message->id)) return false;

		$message->data = $this->meta($message->meta);

		return $message;
	}

	/*
	 * Parse feedback metadata(userAgent, uri)
	 *
	 * @return array
	 * 
	 */
	function meta($data){
		$item = array();

		$parse = new UA();

		if ($data != ''){
			$meta = json_decode($data);

			if (isset($meta->userAgent)){
				$userAgent = $meta->userAgent;

				$results = $parse->parse($userAgent);

				$item['browser'] = $results->ua->family;
				$item['browserFull'] = $results->ua->toString;
			}

			if (isset($meta->uri)) $item['link'] = $meta->uri;
			
		}

		return $item;
	}
}