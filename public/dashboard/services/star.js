services.factory('Star', function($resource){
	return $resource('/api/v1/messages/:id/star', {id: '@id'}, 
		{ 
			star: {method: 'POST', params: { star: true }}
		}
	);
});