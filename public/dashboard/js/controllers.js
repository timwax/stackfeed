var app = angular.module('app', ['stack.feedback.services', 'stack.feedback.directives']);

app.config(function($routeProvider){
	$routeProvider
	.when('/', { templateUrl: '/dashboard/views/index.html', controller: 'IndexCtrl' })
	.when('/projects', { templateUrl: '/dashboard/views/projects.html', controller: 'ProjectsCtrl' })
	.when('/projects/add', { templateUrl: '/dashboard/views/projects/add.html', controller: 'AddProjectCtrl' })
	.when('/projects/:id', { templateUrl: '/dashboard/views/projects/view.html', controller: 'ViewProjectCtrl' })
	.when('/projects/:id/edit', { templateUrl: '/dashboard/views/projects/add.html', controller: 'EditProjectCtrl' })
	.when('/projects/:id/messages', { templateUrl: '/dashboard/views/projects/messages.html', controller: 'ViewProjectMessagesCtrl' })
	.when('/messages/:id', {templateUrl: '/dashboard/views/messages/view.html', controller: 'ViewMessageCtrl'})
	.otherwise({redirectTo: '/'});
});

app.controller('AddProjectCtrl', ['$scope', '$location', 'Project', function ($scope, $location, Project){
	$scope.project = new Project({ active: true });

	$scope.save = function(){
		$scope.project.$save(function(project){
			$location.path('/projects/' + project.id);
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

app.controller('ViewMessageCtrl', ['$scope', 'Message', '$route', function($scope, Message, $route){
	$scope.message = {};

	Message.get({id: $route.current.params.id }, function(message){
		$scope.message = message;
	});

	$scope.isAndroid = function(){
		if (!$scope.message.info) return false;
		return /android/ig.test($scope.message.info.osFull);
	}	

	$scope.isAndroid = function(){
		if (!$scope.message.info) return false;
		return /android/ig.test($scope.message.info.osFull);
	}	

	$scope.isOpera = function(msg){
		if (!msg.info) return false;
		return /opera/ig.test(msg.info.browserFull);
	}
}]);

app.controller('ViewProjectCtrl', ['$scope', 'Project', '$routeParams', function($scope, Project, $routeParams){
	Project.get({id: $routeParams.id}, function(project){
		$scope.project = project;
	});
}])

app.controller('ViewProjectMessagesCtrl', ['$scope', 'Project','ProjectMessages', '$route', '$routeParams', function($scope, Project, ProjectMessages, $route, $routeParams){
	$scope.project = {};

	Project.get({id : $route.current.params.id }, function(project){
		$scope.project = project;
	});

	$scope.options = { maxlen: 80 };
	$scope.messages = ProjectMessages.query({ id: $route.current.params.id });

	$scope.isAndroid = function(msg){
		if (!msg.info) return false;
		return /android/ig.test(msg.info.osFull);
	}	

	$scope.isLinux = function(msg){
		if (!msg.info) return false;
		return /ubuntu|linux/ig.test(msg.info.osFull);
	}	

	$scope.isOpera = function(msg){
		if (!msg.info) return false;
		return /opera/ig.test(msg.info.browserFull);
	}	

	$scope.isChromium = function(msg){
		if (!msg.info) return false;
		return /chromium/ig.test(msg.info.browserFull);
	}	

	$scope.isFirefox = function(msg){
		if (!msg.info) return false;
		return /firefox/ig.test(msg.info.browserFull);
	}
}]);