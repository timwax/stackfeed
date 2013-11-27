stack_directive.directive('stackNotify', function($rootScope, $location){
	return {
		/*
		 * Notify user
		 *
		 * This handles the notification of the executed action and can redirect the user to the next step
		 *
		 * @param string message
		 * @param type string
		 * @param string redirect
		 */
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