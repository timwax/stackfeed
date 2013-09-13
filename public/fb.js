_feedback.inline = '';
if (_feedback.maxWidth < 600) { _feedback.inline + '-inline'};

var x = $('<iframe>');
x.attr({'src': ('https:' == document.location.protocal ? 'https://': 'http://') + _feedback.host + '/embed/feedback.php'});
console.log(x);
x.attr({'width': '100%', 'frameborder': '0', height: '380px'});

var b = $('<div>'); // Body
b.addClass('feedback-body');
b.append(x);

var c = $('<div>'); // Container

c.addClass('feedback-cont');
c.html('<div class="buttons"><button>'+ _feedback.label +'</button></div>');
c.append(b);



$(document.body).append(c);

$('.feedback-cont .buttons button').bind('click', function(){
	var _b = $('.feedback-body');

	if(_b.is(':visible')){
		// True
		_b.hide();
	}else{
		_b.show();
	}

	console.log('wasup');
});