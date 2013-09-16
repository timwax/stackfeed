@extends('layout.main')

@section('content')
	
<div class="row">
	<div class="col-sm-12">
		{{Markdown::make('startpage')}}
	</div>
</div>
@endsection