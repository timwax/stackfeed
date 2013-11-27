<!DOCTYPE html>
<html>
<head>
	<title>Project X</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="/packages/bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/project.css">
	<!-- <script type="text/javascript" src="//use.typekit.net/zcw1tle.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script> -->
</head>
<body>
	<header>
		<nav role="navigation" class="navbar navbar-default">
			<div class="navbar-header">
				<a class="navbar-brand">Stacksuite</a>
			</div>

			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="#">Home</a></li>
					<li><a href="#">Projects</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li class="navbar-text">{{Auth::user()->username}}</li>
					<li><a href="{{URL::route('logout')}}">Logout</a></li>
				</ul>
			</div>
		</nav>
	</header>

	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<ul class="nav project-nav">
					<li class="{{Request::is('ui/project') ? 'active' : ''}}">
						<a href="{{URL::route('project-dashboard')}}"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a>
					</li>
					<li><a href="#"><span class="glyphicon glyphicon-tasks"></span> Tasks</a></li>
					<li class="{{Request::is('ui/project/feedback') ? 'active' : 'no'}}"><a href="{{URL::route('project-feedback')}}"><span class="glyphicon glyphicon-bullhorn"></span> Feedback <span class="badge badge-info pull-right">12</span></a></li>
					<li><a href="#"><span class="glyphicon glyphicon-user"></span> Collaborators</a></li>
					<li><a href="{{URL::route('project-settings-basic')}}"><span class="glyphicon glyphicon-cog"></span> Settings</a>
						<ul class="subnav nav">
							<li class="{{Request::is('ui/project/settings/basic') ? 'active' : 'no'}}"><a href="{{URL::route('project-settings-basic')}}">Project basic</a></li>
							<li><a href="#">Feedback</a></li>
						</ul>
					</li>
					<li class="{{Request::is('ui/project/embed') ? 'active': ''}}"><a href="{{URL::route('project-embed')}}"><span class="glyphicon glyphicon-link"></span> Embed</a></li>
				</ul>
			</div>

			<div class="col-sm-9">
				<div class="row">
					<div class="col-sm-8">
						<h2 class="project-title">
							@section('project-title')
								Project name
							@show
						</h2>
					</div>

					<div class="col-sm-4">
						@yield('quick-access')
					</div>
				</div>
				

				<hr style="margin:0; padding:0;" />

				<div class="project-content">
					@yield('content')
				</div>
			</div>
		</div>
	</div>
</body>
</html>