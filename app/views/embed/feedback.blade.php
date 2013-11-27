<!DOCTYPE html>
<html lang="en_US">
<head>
	<title>Feedback</title>
	<meta name="viewpoint" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/packages/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<style type="text/css">
	body{
		background-color: #FFF;
		width: 100%;
		margin-top: 10px;
	}
	
	.alert{
		display: none;
	}

	.buttons{
		position: absolute;
		bottom:0;
		right: 0;
		height: 24px;
	}
	
	.buttons button{
		height: 24px;
		background-color:#CCC;
		border: none;
		width: 100%;
	}
	
	.help{ background-color: blue; color: #FFF; padding: 0 5px; font-weight: bold;}
	input[type=text], input[type=email]{
		width: 100%;
		padding: 0.3em;
		font-size: 1em;
	}
	
	textarea{
		width: 100%;
		min-height: 130px;
	}

	.br{
		display: block;
		height: 1px;
		margin: 0.5em 0;
	}

	.poweredby{
		margin-top: 1em;
	}
</style>
<!-- Begin feedback -->
<div class="container">
	<div class="alert alert-info">
		<h3 style="margin:0; padding:0;">Thank you for helping us out</h3>
		<p>Your feedback will be very helpfull in making the application as user friendly as possible</p>
	</div>
	<form id="feedback">
		<div class="row">
			<div class="col-sm-4">Name <span class="text-muted">( optional )</span></div>
			<div class="col-sm-8">
				<input type="text" id="name" />
			</div>
		</div>		
		<div class="br"></div>
		<div class="row">
			<div class="col-sm-4">Email <span class="text-muted">( optional )</span><span class="help" title="We all hate spam, plus we can say thanks if you are very helpful">?</span></div>
			<div class="col-sm-8">
				<input type="text" id="email" />
			</div>
		</div>		
		<div class="br"></div>
		<div class="row">
			<div class="col-sm-12">
				<textarea placeholder="Be a critic and help us out" autofocus id="message"></textarea>
			</div>
		</div>
		<hr style="margin:1em 0;" />
		<button class="btn btn-primary">Send</button>
		<button class="btn btn-secondary">Cancel</button>
	</form>
	<div class="poweredby">powered by <a href="http://{{Config::get('app.hostname')}}">stack feedback</a></div>
</div>
<!-- End feedback -->
<script type="text/javascript" src="/packages/jquery/jquery.min.js"></script>
<script type="text/javascript">
	var app = {
		master: "{{Input::get('origin')}}",
		event: function(type, message){
			window.parent.postMessage({type: type, message: message}, this.master);
		},
		meta: {}
	};

	$(document).ready(function(){

		$(window).on({
			message: function(e){
				// console.log('Yes', e);

				if (e.originalEvent.origin != app.master) return;

				// console.log('Its you master...');

				switch(e.originalEvent.data.type){
					case "refresh":
						document.location.reload();
					break;

					case "setup":
						app.meta = e.originalEvent.data.message;
						// console.log(app.meta);
					break;
				}
			}
		});

		app.event('init', 'data');

		function notify(){
			$('#feedback').hide();
			$('.alert').show();

			app.event('done', 'success');
		}

		function cancel(){
			app.event('hide');
		}

		function processForm(){
			var _d = {};

			_d.message = $('#message').val();
			_d.name = $('#name').val();
			_d.email = $('#email').val();
			_d.project = app.pid;
			_d.meta = app.meta;

			return _d;
		}

		$('body .btn-secondary').click(function(e){
			e.preventDefault();
			cancel();
		});

		$('body .btn-primary').click(function(e){
			e.preventDefault();

			var _d = processForm();

			// if (_d.message == '') return;

			$.post('/fb.php', _d, function(response, status, xhr){
				if (status == 'success'){
					// console.log(response);

					// Check message type and delegate

					if (response.type == 'ratelimit') {
						console.log('Hey lets verify u r human pal');
						window.location.reload();

						return;
					}

					notify();
				}
			}, 'JSON');
			
		});

		// notify();
		@if($status)
			app.event('active', '1');
		@endif;


	});
</script>
</body>
</html>