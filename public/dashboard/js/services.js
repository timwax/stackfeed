var services = angular.module('stack.feedback.services', ['ngResource']); 

services.factory('UI', function(){
	return {
		isAndroidBrowser : function(msg){
			console.log('Here');
			if(!msg.info) return false;
			return /android/ig.test(msg.info.browserFull);
		},

		isAndroid : function(msg){
			if (!msg.info) return false;
			return /android/ig.test(msg.info.osFull);
		},

		isLinux : function(msg){
			if (!msg.info) return false;
			return /ubuntu|linux/ig.test(msg.info.osFull);
		},	

		isOpera : function(msg){
			if (!msg.info) return false;
			return /opera/ig.test(msg.info.browserFull);
		},	

		isChromium : function(msg){
			if (!msg.info) return false;
			return /chromium/ig.test(msg.info.browserFull);
		},	

		isFirefox : function(msg){
			if (!msg.info) return false;
			return /firefox/ig.test(msg.info.browserFull);
		}
	}
});

services.factory('Message', function($resource){
	return $resource('/api/v1/messages/:id', {id: '@id'});
});

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

services.factory('Project', function($resource){
	return $resource('/api/v1/projects/:id', {id: '@id'}, {
		update: { method: 'PUT' }
	});
});

services.factory('ProjectMessages', function($resource){
	return $resource('/api/v1/projects/:id/messages', { id: '@id' });
});

services.factory('Star', function($resource){
	return $resource('/api/v1/messages/:id/star', {id: '@id'}, 
		{ 
			star: {method: 'POST', params: { star: true }}
		}
	);
});