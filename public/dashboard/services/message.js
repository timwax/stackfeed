services.factory('Message', function($resource){
	return $resource('/api/v1/messages/:id', {id: '@id'});
});