services.factory('UI', function(){
	return {
		isAndroidBrowser : function(msg){
			//console.log('Here');
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