<?php

class ProjectIndex{
	function __construct($pid){

		$this->client = new \Elastica\Client();

		$this->index = $this->client->getIndex('feedback');

		$this->query = new \Elastica\Query\Bool();

		$term = new \Elastica\Query\Term();
		$term->setTerm('project_id', $pid);

		$this->query->addMust($term);
	}

	function get(){
		// All messages and facets
		$query = new \Elastica\Query($this->query);
		$query->setLimit(0);

		$facet = new \Elastica\Facet\Terms('browsers');

		$facet->setField('browser');
		
		//$facet->setScript("term + \"_\"+ _source.browser_version");

		$query->addFacet($facet);

		$results = $this->index->search($query);

		return $results;
	}
}