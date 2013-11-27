
/* Main script */
$(document).ready(function(){

	XD.receiveMessage(function(message){
		console.log('Widget listening', message.data);

		switch(message.data.type){
			case 'setup':
				console.log('Seting up metadata', message.data.message);

				app.meta = message.data.message;
			break;

			case "highlight":
				if (message.data.message == 'started'){
					console.log('Roger captain, changing highlight button state to cancel');
				}else if(message.data.message == 'stopped'){
					console.log('Roger captain, changing highlight button state to highlight');
				}
				
			break;

			case 'selected':
				app.highlight = message.data.message;

				$('.highlight').html('re-highlight');
				$('.highlight').addClass('btn-info');

				console.log(message.data.message);

				// Change wigget to highlighting state 
			break;
		}
	}, app.master);

	// $(window).on({
	// 	message: function(e){
	// 		// console.log('Yes', e);

	// 		if (e.originalEvent.origin != app.master) return;

	// 		// console.log('Its you master...');

	// 		switch(e.originalEvent.data.type){
	// 			case "refresh":
	// 				document.location.reload();
	// 			break;

	// 			case "setup":
	// 				console.log('Setup OK');

	// 				app.meta = e.originalEvent.data.message;
	// 				// console.log(app.meta);
	// 			break;
	// 		}
	// 	}
	// });

	app.event('init', 'data');

	function notify(){
		app.event('done', 'success');
	}

	function cancel(){
		app.event('cancel');
	}

	function processForm(){
		var _d = {};

		_d.message = $('#message').val();
		// _d.name = $('#name').val();
		// _d.email = $('#email').val();
		_d.project = app.pid;
		_d.highlight = app.highlight;
		_d.meta = app.meta;

		return _d;
	}

	$('.highlight').on('click', function(e){
		if ($(this).hasClass('active')){
			app.event('cancelHighlight', '');
			$(this).removeClass('active');
		}else{
			app.event('startHighlight', '');
			$(this).addClass('active');
		}
	});	

	$('body .btn-cancel').click(function(e){
		e.preventDefault();

		cancel();
	});

	$('body .btn-submit').click(function(e){
		e.preventDefault();

		var _d = processForm();

		// if (_d.message == '') return;

		$.post('/fb.php', _d, function(response, status, xhr){
			if (status == 'success'){
				// console.log(response);

				// Check message type and delegate

				notify();
			}
		}, 'JSON');
		
	});

	// notify();
	// @if($status)
	// 	app.event('active', '1');
	// @endif;
});