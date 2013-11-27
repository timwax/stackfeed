services.factory('MessageFilterService', function($rootScope, $http){
	return {
		params: {},
		init: function(data){
			var self = this;
			
			this.params.pid = data.pid;

			// Load filters

			$http.get('/api/v1/projects/' + this.params.pid + '/filters').success(function(response){
				self.params.browsers = response.browsers;
				$rootScope.$broadcast('messageFilterInit');

				self.started = true;
			});

		},
		set: function(){
			// Brodcast
			if (arguments.length == 2){
				this.params[arguments[0]] = arguments[1];

				$rootScope.$broadcast('messageFilterUpdate');
			}

			if (arguments.length == 1){
				$.extend(this.params, arguments);

				$rootScope.$broadcast('messageFilterUpdate');
			}
			

			//console.log(this.params);
			
		},
		close: function(){
			// Clear params
			this.params = {};
			$rootScope.$broadcast('messageFilterClose');
		}
	};
});