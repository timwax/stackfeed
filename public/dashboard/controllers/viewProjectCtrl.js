// app.controller('ViewProjectCtrl', [function($scope, Project){
// 	Project.get({ id: 1 }, function(project){
// 		$scope.project = project;
// 	});
// }]);

app.controller('ViewProjectCtrl', ['$scope', 'Project', function($scope, Project){
	Project.get({id: '1'}, function(project){
		$scope.project = project;
	});
}])