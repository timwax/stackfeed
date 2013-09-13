@extends('layout.main')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				@include('forms.signup') 
			</div>
			<div class="col-md-6"></div>
		</div>
	</div>
@endsection