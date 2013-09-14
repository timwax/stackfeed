app.controller('ViewMessageCtrl', ['$scope', 'Message', '$route', function($scope, Message, $route){
	$scope.message = {};

	Message.get({id: $route.current.params.id }, function(message){
		$scope.message = message;
	})
}]);