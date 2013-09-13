@if(count($errors->all()))
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $key => $value)
			<li>{{$value}}</li>
		@endforeach
	</ul>
</div>
@endif
<form method="POST" action="/accounts/signup">
	<p>
		<label>Username</label>
		<input type="text" name="username" value="{{Input::old('username')}}">
	</p>
	<p>
		<label>Email</label>
		<input type="text" name="email" value="{{Input::old('email')}}">
	</p>
	<p>
		<label>Password</label>
		<input type="password" name="password">
	</p>
	<p>
		<label>Confirm Password</label>
		<input type="password" name="password_confirmation">
	</p>
	<p>
		<input type="checkbox" name="agree"> Agree to terms and conditions
	</p>
	<p>
		<input type="submit" value="Register" class="btn btn-primary">
	</p>
</form>