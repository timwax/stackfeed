<!DOCTYPE html>
<html ng-app="app">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome to Stack Feedback</title>
	<link rel="stylesheet" type="text/css" href="/packages/bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/dashboard.css">

	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
<header>
	<div class="navbar navbar-default">
		<div class="navbar-brand">
			<a href="#/"><h1 style="font-size: 1em; margin:0; padding:0; font-weight: bold">stackFeedback</h1></a>
		</div>

		<div class="navbar-toggle" data-toggle="collapse" data-target=".navbar-top-collapse">
			|||
		</div>
		<div class="navbar-collapse collapse navbar-top-collapse">
			<ul class="nav navbar-nav">
				<li><a href="#/">Dashboard</a></li>
				<li><a href="#/projects">Projects</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#">{{Auth::user()->username}}</a></li>
				<li style="height: 20px; background-color:#CCC; width: 1px; margin-top: 1em;" class="xs-hidden"></li>
				<li><a href="{{ URL::to('accounts/logout') }}">
				<span class="glyphicon glyphicon-logout"></span>logout</a></li>
			</ul>
		</div>
	</div>
</header>
	<div class="container">
		<div class="row">
		<div class="col-sm-3">
			@yield('sidebar')
		</div>
		<div class="col-sm-8 col-sm-push-1">
			<div ng-view>@yield('content')</div>
		</div>
		</div>
		
	</div>

<footer>
	<div class="row">
		<div class="col-md-4">feedback.stackvillage.com &copy; 2013</div>
	</div>
</footer>

<div stack-notify></div>
<script type="text/javascript" src="/packages/jquery/jquery.js"></script>
<script type="text/javascript" src="/packages/angular/angular.js"></script>
<script type="text/javascript" src="/packages/bootstrap/dist/js/bootstrap.js"></script>
<script type="text/javascript" src="/packages/bootbox/bootbox.js"></script>
<script type="text/javascript" src="/packages/angular-resource/angular-resource.js"></script>
<script type="text/javascript" src="/dashboard/js/services.js"></script>
<script type="text/javascript" src="/dashboard/js/filters.js"></script>
<script type="text/javascript" src="/dashboard/js/controllers.js"></script>
<script type="text/javascript" src="/dashboard/js/directives.js"></script>


</body>
</html>