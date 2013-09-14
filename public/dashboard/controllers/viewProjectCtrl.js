app.controller('ViewProjectCtrl', ['$scope', 'Project', '$routeParams', function($scope, Project, $routeParams){
	Project.get({id: $routeParams.id}, function(project){
		$scope.project = project;
	});
}])