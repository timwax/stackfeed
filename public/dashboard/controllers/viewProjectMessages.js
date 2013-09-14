app.controller('ViewProjectMessagesCtrl', ['$scope', 'Project','ProjectMessages', '$route', function($scope, Project, ProjectMessages, $route){
	$scope.project = {};

	Project.get({id : $route.current.params.id }, function(project){
		$scope.project = project;
	});

	$scope.messages = ProjectMessages.query({ id: $route.current.params.id });
}]);