<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Stack Feedback</title>
	<link rel="stylesheet" type="text/css" href="/packages/bootstrap/dist/css/bootstrap.css">
</head>
<body>
<header>
	<div class="navbar navbar-default">
		<div class="navbar-brand">
			<h1 style="font-size: 1em; margin:0; padding:0; font-weight: bold">stackFeedback</h1>
		</div>
		<div class="navbar-collapse collapse navbar-top-collapse">
			<ul class="nav navbar-nav">
				<li><a href="#">Download</a></li>
				<li><a href="#">Documentation</a></li>
				<li><a href="#">About</a></li>
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
	</div>

<footer>
	<div class="row">
		<div class="col-md-4">feedback.stackvillage.com &copy; 2013</div>
	</div>
</footer>
</body>
</html>