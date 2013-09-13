app.controller('ProjectsCtrl', ['$scope', 'Project', function($scope, Project){
	$scope.projects = Project.query();
}]);