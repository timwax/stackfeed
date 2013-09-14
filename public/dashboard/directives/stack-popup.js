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