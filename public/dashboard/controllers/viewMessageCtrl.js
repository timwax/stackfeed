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