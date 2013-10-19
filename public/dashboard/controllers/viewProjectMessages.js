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