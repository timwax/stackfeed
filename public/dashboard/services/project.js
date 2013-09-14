services.factory('Project', function($resource){
	return $resource('/api/v1/projects/:id', {id: '@id'}, {
		update: { method: 'PUT' }
	});
});