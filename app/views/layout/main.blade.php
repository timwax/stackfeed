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
	jQuery.fn.extend({
		getPath: function( path ) {
			// The first time this function is called, path won't be defined.
			if ( typeof path == 'undefined' ) path = '';

			// If this element is <html> we've reached the end of the path.
			if ( this.is('html') )
				return 'html' + path;

			// Add the element name.
			var cur = this.get(0).nodeName.toLowerCase();

			// Determine the IDs and path.
			var id    = this.attr('id'),
			    eclass = this.attr('class');


			// Add the #id if there is one.
			if ( typeof id != 'undefined' )
				cur += '#' + id;

			// Add any classes.
			if ( typeof eclass != 'undefined' )
				cur += '.' + eclass.split(/[\s\n]+/).join('.');

			// Recurse up the DOM.
			return this.parent().getPath( ' > ' + cur + path );
		}
	});

</script>
@include('include.feedback')
</body>
</html>