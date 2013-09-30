_feedback.hide = function(){
	var _b = $('.feedback-body');

	_b.hide();
	_b.removeClass('open');
	$('.buttons').addClass('rounded');
}

_feedback.toggle = function(){

	var _b = $('.feedback-body');

	if (_feedback.status == 'closed'){
		// Reset to default state
		
		$('.feedback-body').removeClass('note');
		$('.feedback-frame').attr({ height: '380'});
	}
	if(_b.is(':visible')){
		// True
		_b.hide();
		_b.removeClass('open');
		$('.buttons').addClass('rounded');
	}else{
		// Check if iframe is loaded
		if(!_feedback.loaded) _feedback.load();

		$('.buttons').removeClass('rounded');
		_b.addClass('open');
		_b.show();
	}
};

_feedback.load = function(){
	console.log('Loading feedback iframe');

	var x = $('<iframe>');
	x.addClass('feedback-frame');
	x.attr({'src': _feedback.protocal + _feedback.host + '/embed/feedback.php?pid=' + _feedback.project + '&origin=' + _feedback.protocal + window.location.host});
	x.attr({'width': '100%', 'frameborder': '0', height: '380'});

	// Append iframe to feedback body

	$('.feedback-body').append(x);

	// Setup loaded flag
	_feedback.loaded = true;
}

var b = $('<div>'); // Body
b.addClass('feedback-body');
b.css({border: '#EEE 1px solid', display: 'none'});

var c = $('<div>'); // Container

c.addClass('feedback-cont');

if (!_feedback.trigger || _feedback.trigger == 'default')
	c.html('<div class="buttons rounded"><button class="btn btn-block btn-primary">'+ _feedback.label +'</button></div>');

c.append(b);

if (_feedback.context){
	// Append widget to context area

	$(_feedback.context).append(c);
}else{
	$(document.body).append(c);
}

// Feedback trigger handles events

if(_feedback.trigger){

	console.log('Setting up feedback trigger binding')
	$(_feedback.trigger).bind('click', function(e){
		e.preventDefault();

		_feedback.toggle();
	});
}else{
	$('.feedback-cont .buttons button').bind('click', _feedback.toggle);
}



// Setup receive messages using postMessage API

var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = window.eventMethod == "attachEvent" ? "onmessage" : "message";

eventer(messageEvent, function(e){
	if(e.origin !== _feedback.protocal + _feedback.host ){
		console.log('Bullshit');
		return;
	}

	// console.log(e.data);

	if (e.data.type == 'done'){
		$('.feedback-body').addClass('note');
		$('.feedback-frame').attr({ height: '150'});
		
		_feedback.t = setTimeout(function(){
			var _b = $('.feedback-body');
			_b.hide();
			_b.removeClass('open');
			$('.buttons').addClass('rounded');
			_feedback.status = 'closed';

			e.source.postMessage({type: 'refresh'}, _feedback.protocal + _feedback.host);
		}, 4000);
	}

	if(e.data.type == 'active'){
		$('.feedback-cont').css({display: 'block'});
	}

	if (e.data.type == 'hide'){
		_feedback.hide();
	}

	if(e.data.type == 'init'){
		// console.log('Ok leta go feedback');

		e.source.postMessage({
			type: "setup", 
			message: {
				uri: window.location.href,
				screenWidth: window.screen.availWidth,
				screenHeight: window.screen.availHeight,
				docWidth: document.width, 
				docHeight: document.height,
				windowWidth: window.innerWidth > 0 ? window.innerWidth : screen.width,
				windowHeight: window.innerHeight > 0 ? window.innerHeight : screen.height,

				// Platform

				platform: window.navigator.platform,
				appCodeName: window.navigator.appCodeName,
				appName: window.navigator.appName,
				cookieEnabled: window.navigator.cookieEnabled,
				language: window.navigator.language,
				product: window.navigator.product,
				vendor: window.navigator.vendor,
				userAgent: window.navigator.userAgent
			}
		}, _feedback.protocal + _feedback.host);
	}
}, false);

// Check for preload and init iframe

if(_feedback.preload) _feedback.load();