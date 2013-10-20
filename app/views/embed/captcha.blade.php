<html>
	<head>
		<title>Are you human??</title>
	</head>
	<body>

		@if(Session::has('msg'))
			<div class="error" style="background-color: red; color: white; font-weight: bold; padding: 1em">{{Session::get('msg')}}</div>
		@endif

		<div style="max-width: 250px; padding: 10px; margin: 10px auto;">
			<h3 style="margin-top: 0.5em">Security check</h3>
			<p>We all hate spam. Enter the letters below to verify you are human and not a bot/malware. They are not case sensitive</p>
			<p>Cant read this? <a style="color: blue" onclick="window.location.reload()">try another</a></p>
			<form method="post">
				<img src="{{$builder->inline()}}" />
				<input type="text" name="captcha" style="display: block; width: 100%; padding: 5px; margin: 5px 0;" autofocus />
				<input type="submit" value="Send" style="display:block; max-width: 100px; margin: 5px auto;" />
			</form>

		</div>
	</body>
</html>