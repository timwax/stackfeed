var services = angular.module('stack.feedback.services', ['ngResource']); 

services.factory('Project', function($resource){
	return $resource('/api/v1/projects/:id', {id: '@id'});
});