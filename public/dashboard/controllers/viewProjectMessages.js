app.controller('ViewProjectMessagesCtrl', ['$scope', 'Project','ProjectMessages', '$route', '$routeParams', function($scope, Project, ProjectMessages, $route, $routeParams){
	$scope.project = {};

	Project.get({id : $route.current.params.id }, function(project){
		$scope.project = project;
	});

	$scope.options = { maxlen: 80 };
	$scope.messages = ProjectMessages.query({ id: $route.current.params.id });
}]);