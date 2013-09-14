var services = angular.module('stack.feedback.services', ['ngResource']); 

services.factory('Message', function($resource){
	return $resource('/api/v1/messages/:id', {id: '@id'});
});

services.factory('Project', function($resource){
	return $resource('/api/v1/projects/:id', {id: '@id'}, {
		update: { method: 'PUT' }
	});
});

services.factory('ProjectMessages', function($resource){
	return $resource('/api/v1/projects/:id/messages', { id: '@id' });
});