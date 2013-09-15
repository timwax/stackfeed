_feedback.hide = function(){
	var _b = $('.feedback-body');

	_b.hide();
	_b.removeClass('open');
	$('.buttons').addClass('rounded');
}

var x = $('<iframe>');
x.addClass('feedback-frame');
x.attr({'src': ('https:' == document.location.protocal ? 'https://': 'http://') + _feedback.host + '/embed/feedback.php?pid=' + _feedback.project + '&origin=' + document.location.origin});
x.attr({'width': '100%', 'frameborder': '0', height: '380'});

var b = $('<div>'); // Body
b.addClass('feedback-body');
b.append(x);

var c = $('<div>'); // Container

c.addClass('feedback-cont');
c.html('<div class="buttons rounded"><button class="btn btn-block btn-primary">'+ _feedback.label +'</button></div>');
c.append(b);

if (_feedback.inline != ''){
	$(_feedback.inline).append(c);
	// console.log(_feedback.inline);
}else{
	$(document.body).append(c);
}


$('.feedback-cont .buttons button').bind('click', function(){
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
		$('.buttons').removeClass('rounded');
		_b.addClass('open');
		_b.show();
	}
});

// Setup receive messages using postMessage API

window.addEventListener("message", function(e){
	if(e.origin !== ('https:' == document.location.protocal ? 'https://' : 'http://') + _feedback.host ){
		console.log('Bullshit');
		return;
	}

	console.log(e.data);

	if (e.data.type == 'done'){
		$('.feedback-body').addClass('note');
		$('.feedback-frame').attr({ height: '150'});
		
		_feedback.t = setTimeout(function(){
			var _b = $('.feedback-body');
			_b.hide();
			_b.removeClass('open');
			$('.buttons').addClass('rounded');
			_feedback.status = 'closed';

			e.source.postMessage({type: 'refresh'}, 'http://' + _feedback.host);
		}, 4000);
	}

	if(e.data.type == 'active'){
		$('.feedback-cont').css({display: 'block'});
	}

	if (e.data.type == 'hide'){
		_feedback.hide();
	}
}, false);