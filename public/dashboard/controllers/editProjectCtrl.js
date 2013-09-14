app.controller('EditProjectCtrl', ['$scope', 'Project','$route', function($scope, Project, $route){
	$scope.project = {};

	Project.get({ id: $route.current.params.id }, function(project){
		project.active = project.active == 1 ? true: false;
		$scope.project = project;
	});

	$scope.save = function(){
		$scope.project.$update(function(project){
			$scope.project = project;
		});
	}
}]);