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