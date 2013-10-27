services.factory('MessageFilterService', function($rootScope){
	return {
		params: {},
		init: function(data){
			this.params.pid = data.pid;
			$rootScope.$broadcast('messageFilterInit');
		},
		set: function(key, value){
			// Brodcast
			this.params[key] = value;

			//console.log(this.params);
			$rootScope.$broadcast('messageFilterUpdate');
		}
	};
});