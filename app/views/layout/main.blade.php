<!DOCTYPE html>
<html>
<head>
	<title>
	@if(isset($title) && $title != '')
		{{ucfirst($title)}} - 
	@endif
	Stack feedback</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/packages/bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/app.css">

	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
<header>
	<div class="navbar navbar-default">
		<div class="navbar-brand" style="padding: 3px 0 3px 1em;">
			<a href="/">
				<img src="/img/logo.png" style="width: 48px;"> 
				<span>
					<h1 style="font-size: 1em; margin:0; padding:0; font-weight: bold; display: inline;"><span style="font-weight: normal;">stack</span> Feedback</h1>
				</span>
			</a>
		</div>
		<div class="navbar-collapse collapse navbar-top-collapse">
			<ul class="nav navbar-nav">
				<li><a href="/p/download">Download</a></li>
				<li><a href="/p/documentation">Documentation</a></li>
				<li><a href="/p/about">About</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="{{ URL::to('accounts/login') }}">login</a></li>
				<li style="height: 20px; background-color:#CCC; width: 1px; margin-top: 1em;"></li>
				<li><a href="{{ URL::to('accounts/signup') }}">sign up</a></li>
			</ul>
		</div>
	</div>
</header>
	<div class="container">
		@yield('content')

		<footer>
			<div class="row">
				<div class="col-md-4">feedback.stackvillage.com &copy; 2013</div>
				<div class="col-md-8"><div id="stack-feedback"></div></div>
			</div>
			
		</footer>
	</div>

<style type="text/css">
</style>
<script type="text/javascript" src="/packages/jquery/jquery.min.js"></script>
<script type="text/javascript">
	var _feedback = _feedback || {};
	_feedback.project = "{{Config::get('app.pid')}}";
	_feedback.widgets = ['feedback'];
	_feedback.host = "{{Config::get('app.hostname')}}";
	_feedback.protocal = 'https:' == window.location.protocal ? 'https://' : 'http://';
	_feedback.label = 'Feedback';
	_feedback.inline = '#stack-feedback';

	{
		var fb = document.createElement('script'); 
		fb.type = 'text/javascript'; 
		fb.async = true; 
		fb.src = _feedback.protocal + _feedback.host +'/fb.js';
		document.body.appendChild(fb);
	}
</script>
</body>
</html>