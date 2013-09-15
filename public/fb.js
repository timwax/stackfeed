_feedback.inline = '';
if (_feedback.maxWidth < 600) { _feedback.inline + '-inline'};

var x = $('<iframe>');
x.addClass('feedback-frame');
x.attr({'src': ('https:' == document.location.protocal ? 'https://': 'http://') + _feedback.host + '/embed/feedback.php?pid=' + _feedback.project + '&origin=' + document.location.origin});
console.log(x);
x.attr({'width': '100%', 'frameborder': '0', height: '100%'});

var b = $('<div>'); // Body
b.addClass('feedback-body');
b.append(x);

var c = $('<div>'); // Container

c.addClass('feedback-cont');
c.html('<div class="buttons rounded"><button>'+ _feedback.label +'</button></div>');
c.append(b);

$(document.body).append(c);

$('.feedback-cont .buttons button').bind('click', function(){
	var _b = $('.feedback-body');

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

	console.log('wasup');
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
		$('.feedback-frame').attr({ height: '120'});
		console.log('Here');
	}

	if(e.data.type == 'active'){
		$('.feedback-cont').css({display: 'block'});
	}
}, false);