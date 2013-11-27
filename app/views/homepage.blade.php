@extends('layout.suite')

@section('content')
<style type="text/css">
	.cont{
		display: block;
		margin: 0 auto;
		background-color: #EEE;
		width: 150px;
		padding: 2em 0;
	}

	img{
		display: block;
		margin: 0 auto;
	}
</style>
<div class="container">
<h1>Tools for web artisans</h1>
	<div class="row">
		<div class="col-sm-3">
			<div class="cont">
				<img src="/img/feedback.png" class="center" />
			</div>
			<h3 style="text-align: center">Feedback</h3>
		</div>
	</div>
</div>
@endsection