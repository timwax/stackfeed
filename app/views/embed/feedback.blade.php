<!DOCTYPE html>
<html lang="en_US">
<head>
	<title>Feedback</title>
</head>
<body>
<style type="text/css">
/*	body{
		margin: 0;
		padding: 1em;
		width: 100%;
	}*/
	
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
	label{ width: 25%; float: left; display: block;}
	label.full{ display: block; }
	
	input{ width: 74%}
	textarea{ width: 100%; min-height: 100px}
</style>
<!-- Begin feedback -->
<div style="width: 100%;">
	<div class="alert alert-sucess">
		<h3>Thank you for helping us out</h3>
		<p>Your feedback will be very helpfull in making the application as user friendly as possible</p>
	</div>
	<form id="feedback">
		Feedback
		<hr />
		<p><label>Name( <em>optional</em> ):</label>
			<input type="text" id="name" />
		</p>
		<p><label>Email( <em>optional</em> ) <span class="help" title="We all hate spam, plus we can say thanks if you are very helpful">?</span>:</label>
			<input type="text" id="email" />
		</p>
		<p><label class="full">Message:</label>
			<textarea placeholder="Be a critic and help us out" autofocus id="message">Testing message</textarea>
		</p>
		<hr />
		<button class="btn btn-primary">Send</button>
		<button>Cancel</button>
	</form>
</div>
<!-- End feedback -->
<script type="text/javascript" src="/packages/jquery/jquery.min.js"></script>
<script type="text/javascript">
	var app = {
		master: "{{Input::get('origin')}}",
		event: function(type, message){
			window.top.postMessage({type: type, message: message}, this.master);
		}
	};

	$(document).ready(function(){

		function notify(){
			$('#feedback').hide();
			$('.alert').show();

			app.event('done', 'success');
		}

		function processForm(){
			var _d = {};

			_d.message = $('#message').val();
			_d.name = $('#name').val();
			_d.email = $('#email').val();
			_d.project = "{{Input::get('pid')}}";

			return _d;
		}

		$('body .btn-primary').click(function(e){
			e.preventDefault();

			var _d = processForm();

			// if (_d.message == '') return;

			$.post('/fb.php', _d, function(response, status, xhr){
				if (status == 'success'){
					console.log(response);
					notify();
				}
			}, 'JSON');
			
		});

		//notify();
		@if($status)
			app.event('active', '1');
		@endif;
	});
</script>
</body>
</html>