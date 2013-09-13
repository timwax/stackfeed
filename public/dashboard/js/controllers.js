var app = angular.module('app', ['stack.feedback.services']);

app.config(function($routeProvider){
	$routeProvider
	.when('/', { templateUrl: '/dashboard/views/index.html', controller: 'IndexCtrl' })
	.when('/projects', { templateUrl: '/dashboard/views/projects.html', controller: 'ProjectsCtrl' })
	.when('/projects/add', { templateUrl: '/dashboard/views/projects/add.html', controller: 'AddProjectCtrl' })
	.when('/projects/:id', { templateUrl: '/dashboard/views/projects/view.html', controller: 'ViewProjectCtrl' })
	.when('/projects/:id/edit', { templateUrl: '/dashboard/views/projects/edit.html', controller: 'EditProjectCtrl' })
	.otherwise({redirectTo: '/'});
});

app.controller('AddProjectCtrl', ['$scope', '$location', 'Project', function ($scope, $location, Project){
	$scope.project = new Project({ active: true });

	$scope.save = function(){
		$scope.project.$save(function(project){
			$location.path = '/projects/' + project.id;
		});
	}
}]);
function EditProjectCtrl($scope){
	console.log('Init');
};

EditProjectCtrl.$inject = ['$scope'];
function IndexCtrl($scope){
	console.log('Init');
};

IndexCtrl.$inject = ['$scope'];
app.controller('ProjectsCtrl', ['$scope', 'Project', function($scope, Project){
	$scope.projects = Project.query();
}]);
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