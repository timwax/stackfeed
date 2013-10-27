app.controller('ViewProjectMessagesCtrl', [
	'$scope', 
	'Project',
	'ProjectMessages', 
	'$route', 
	'$routeParams', 
	'Star', 
	'MessageFilterService', 
	'$http', 
	'UI',
	function($scope, Project, ProjectMessages, $route, $routeParams, Star, MessageFilterService, $http, UI){
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

	// UI attachment

	$scope.UI = UI;
	
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