var app = angular.module('app', ['stack.feedback.services']);

app.config(function($routeProvider){
	$routeProvider
	.when('/', { templateUrl: '/dashboard/views/index.html', controller: 'IndexCtrl' })
	.when('/projects', { templateUrl: '/dashboard/views/projects.html', controller: 'ProjectsCtrl' })
	.when('/projects/add', { templateUrl: '/dashboard/views/projects/add.html', controller: 'AddProjectCtrl' })
	.when('/projects/:id', { templateUrl: '/dashboard/views/projects/view.html', controller: 'ViewProjectCtrl' })
	.when('/projects/:id/edit', { templateUrl: '/dashboard/views/projects/add.html', controller: 'EditProjectCtrl' })
	.when('/projects/:id/messages', { templateUrl: '/dashboard/views/projects/messages.html', controller: 'ViewProjectMessagesCtrl' })
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

app.controller('IndexCtrl', [function($scope){

}]);

app.controller('ProjectsCtrl', ['$scope', 'Project', function($scope, Project){
	$scope.projects = Project.query();
}]);

app.controller('ViewProjectCtrl', ['$scope', 'Project', function($scope, Project){
	Project.get({id: '1'}, function(project){
		$scope.project = project;
	});
}])

app.controller('ViewProjectMessagesCtrl', ['$scope', 'Project','ProjectMessages', '$route', function($scope, Project, ProjectMessages, $route){
	$scope.project = {};

	Project.get({id : $route.current.params.id }, function(project){
		$scope.project = project;
	});

	$scope.messages = ProjectMessages.query({ id: $route.current.params.id });
}]);