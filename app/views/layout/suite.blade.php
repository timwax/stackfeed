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
				<img src="/img/logo-suite.png" style="width: 48px;"> 
			</a>
		</div>
		<div class="navbar-collapse collapse navbar-top-collapse">
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
@include('include.feedback')
</body>
</html>