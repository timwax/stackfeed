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
	<link rel="stylesheet" type="text/css" href="/packages/prismjs/prism.css">

	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body class="language-javascript">
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
				<li><a href="/p/api">API</a></li>
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
				<div class="col-md-4">feedback.stackvillage.com &copy; 2013 | <a id="feedback_trigger">send feedback</a></div>
				<div class="col-md-8"></div>
			</div>
			<div id="stack-feedback"></div>
		</footer>
	</div>

<script type="text/javascript" src="/packages/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/packages/prismjs/prism.js"></script>

<script type="text/javascript">
	var _feedback = _feedback || {};
	_feedback.project = "{{Config::get('app.pid')}}";
	_feedback.label = 'Feedback';
	_feedback.host = "{{Config::get('app.hostname')}}";

	// Added options

	_feedback.type = 'inline'; // Type can be either (inline, popup, docked|default)

	/*
	 * Feedback trigger
	 *
	 * This is the element responsible for toggling the feedback form
	 */
	_feedback.trigger = document.getElementById('feedback_trigger');

	/*
	 * Feedback Preload
	 *
	 * This may slow down webpage load speed, determines whether the iframe is loaded when the page 
	 * loads or when the trigger button is clicked
	 */
	_feedback.preload = false;

	/*
	 * Feedback position
	 *
	 * Affects positioning of the feedback button on the browser window. This is only effective
	 * on popup and docked modes
	 */
	_feedback.position = 'bottom left'; // Where to position feedback widget

	/*
	 * Feedback context
	 *
	 * When the setup of the widget begins, this determines the positioning of the feedback widget
	 * in the DOM. This is essential in inline mode and favours small browsers
	 */
	
	_feedback.context = document.getElementById('stack-feedback');

	_feedback.init = function(){
		this.protocal = 'https:' == window.location.protocal ? 'https://' : 'http://';

		var fb = document.createElement('script'); 
		fb.type = 'text/javascript'; 
		fb.async = true; 
		fb.src = this.protocal + this.host +'/fb.js';
		document.body.appendChild(fb);
	}

	_feedback.init();
</script>
</body>
</html>