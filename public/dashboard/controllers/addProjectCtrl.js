app.controller('AddProjectCtrl', ['$scope', '$location', 'Project', function ($scope, $location, Project){
	$scope.project = new Project({ active: true });

	$scope.save = function(){
		$scope.project.$save(function(project){
			$location.path = '/projects/' + project.id;
		});
	}
}]);