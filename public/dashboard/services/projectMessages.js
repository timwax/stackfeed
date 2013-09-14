services.factory('ProjectMessages', function($resource){
	return $resource('/api/v1/projects/:id/messages', { id: '@id' });
});