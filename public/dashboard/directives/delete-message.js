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