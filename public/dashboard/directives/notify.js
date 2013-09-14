stack_directive.directive('stackNotify', function($rootScope, $location){
	return {
		link: function(scope, element, attr){
			$rootScope.notify = function(message, type, redirect){
				console.log(message, type);

				if (redirect && redirect != ''){
					console.log(redirect);
					$location.path(redirect);
				}
			}
		}
	}
})