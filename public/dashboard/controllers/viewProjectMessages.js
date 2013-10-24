app.controller('ViewProjectMessagesCtrl', ['$scope', 'Project','ProjectMessages', '$route', '$routeParams', 'Star', function($scope, Project, ProjectMessages, $route, $routeParams, Star){
	$scope.project = {};

	Project.get({id : $route.current.params.id }, function(project){
		$scope.project = project;
	});

	$scope.options = { maxlen: 80 };
	$scope.messages = ProjectMessages.query({ id: $route.current.params.id });

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