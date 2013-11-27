var stack_directive = angular.module('stack.feedback.directives', ['ngResource']); 

stack_directive.directive('stackDeleteMessage', function($rootScope){
	return {
		restrict: 'A',

		link: function(scope, element, attr){
			
			element.bind('click', function(e){
				e.preventDefault();

				var msg = element.scope().message;
				bootbox.confirm('Are you sure?', function(result){
					if(result){
						element.scope().message.$delete(function(response){
							$rootScope.notify('Message deleted successfuly', 'success', '/projects/' + msg.project.id + '/messages');
						});
					}
				});
			});
		}
	}
});

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

stack_directive.directive('stackPopup', function($rootScope){
	return {
		restrict: 'A',
		link: function(scope, element, attr){

			$rootScope.deleteMessage = function(message){
				
				if(confirm('Delete message: ' + message.content.substr(0, 30))){
					message.$delete(function(response){
						console.log('Deleted message');
					});
				}
			}
		}
	}
})