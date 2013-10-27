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

app.controller('ProjectFilterMessagesCtrl', ['$scope', 'MessageFilterService', function($scope, MessageFilterService){
	$scope.$on('messageFilterInit', function(){
		$scope.toggle = true;
	});

	$scope.toggle = false;

	$scope.filters = {
		browser: [
			{
				title: 'Firefox',
				items: 200,
				icon: 'icon-firefox',
				selected: 0
			},
			{
				title: 'Chromium',
				items: 100,
				icon: 'icon-chromium',
				selected: 0
			},
			{
				title: 'Chrome',
				items: 100,
				icon: 'icon-chrome',
				selected: 0
			},
			{
				title: 'Internet Explorer',
				items: 100,
				icon: 'icon-ie',
				selected: 0
			},
			{
				title: 'Opera',
				items: 100,
				icon: 'icon-opera',
				selected: 0
			}
		],
		q: '',
		lang: []
	}
	
	$scope.options = {};

	$scope.$watch('filters.browser', function(){
		MessageFilterService.set('browser', $scope.filters.browser);
	}, 1);	

	$scope.$watch('filters.q', function(){
		MessageFilterService.set('q', $scope.filters.q);
	});
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

app.controller('ViewProjectMessagesCtrl', ['$scope', 'Project','ProjectMessages', '$route', '$routeParams', 'Star', 'MessageFilterService', '$http', function($scope, Project, ProjectMessages, $route, $routeParams, Star, MessageFilterService, $http){
	$scope.project = {};

	Project.get({id : $route.current.params.id }, function(project){
		$scope.project = project;
		MessageFilterService.init({ pid: project.id });
	});

	$scope.options = { maxlen: 80 };

	$scope.messages = ProjectMessages.query({ id: $route.current.params.id });

	$scope.$on('messageFilterUpdate', function(){
		//console.log(MessageFilterService.params)

		var count = 0;

		var params = MessageFilterService.params;

		var _params = { pid: params.pid };

		
		// process browsers
		var browsers = [];

		angular.forEach(MessageFilterService.params.browser, function(value, key){
			if (value.selected){
				browsers.push(value.title);
			}
		});

		if (browsers.length > 0){
			_params.browser = browsers.join(',');
			count++;
		}

		if (params.q != '' || params.q.length > 0){
			_params.q = params.q;
			count++;
		} 

		if (count == 0){
			// No filter just load from database
			$scope.messages = ProjectMessages.query({ id: $route.current.params.id });
		}else{
			$http.get('/api/v1/search/messages', {params: _params}).success(function(response){
				$scope.messages = response;
			});
		}
		
	});

	$scope.selected = {};

	$scope.star = function(i){
		var msg = $scope.messages[i];
		var star = new Star({ id: msg.id });

		if ($scope.messages[i].stared == 1){
			// Update server: edit star
			star.$star({ star: 0 }, function(response){
				$scope.messages[i].stared = response.stared;
			});
		}else{
			// Update server: create star
			star.$star({ star: 1 }, function(response){
				$scope.messages[i].stared = response.stared;
			});
			
		}
	}

	$scope.$watch('selected', function(val, newValue){
		//console.log($scope.selected);
	}, true);

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