@extends('layout.main')

@section('content')

@if(count($errors->all()))
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $key => $value)
			<li>{{$value}}</li>
		@endforeach
	</ul>
</div>
@endif

<form method="POST" action="/accounts/login">
	<p>
		<label>Username</label>
		<input type="text" name="username" autofocus value="{{Input::old('username')}}">
	</p>
	<p>
		<label>Password</label>
		<input type="password" name="password">
	</p>
	<p><input type="checkbox" name="remember" /> Remember me</p>
	<p>
		<input type="submit" value="Login" class="btn btn-primary">
	</p>
</form>

@endsection