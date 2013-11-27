app.controller('ProjectFilterMessagesCtrl', ['$scope', 'MessageFilterService', function($scope, MessageFilterService){
	$scope.$on('messageFilterInit', function(){
		$scope.toggle = true;

		$scope.filters = {
			browsers: MessageFilterService.params.browsers,
			q: '',
			lang: []
		}
	});	

	$scope.$on('messageFilterClose', function(){
		$scope.toggle = false;
	});

	$scope.toggle = false;
	
	$scope.options = {};

	// $scope.$watch('filters.browsers', function(){
	// 	if (MessageFilterService.started == true)
	// 		MessageFilterService.set('browsers', $scope.filters.browsers);
	// }, 1);	

	// $scope.$watch('filters.q', function(){
	// 	if (MessageFilterService.started == true)
	// 		MessageFilterService.set('q', $scope.filters.q);
	// });

	$scope.filter = function(){
		//MessageFilterService.set('browsers', );

		MessageFilterService.set({
			'browsers': $scope.filters.browsers,
			'q': $scope.filters.q
		});
		//MessageFilterService.set('q', $scope.filters.q);
	}
}]);