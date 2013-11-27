@extends('layout.project')

@section('quick-access')
	
@endsection

@section('content')
	@if(isset($denied))
		<div class="alert alert-warning">{{$denied}}</div>
	@endif
	{{Form::open(array('route'=> ['save.project.settings.basic', '1']))}}
		<table class="table">
			<tr>
				<td>{{Form::label('Name')}}</td>
				<td>{{Form::text('name', $project->name)}}</td>
			</tr>			

			<tr>
				<td>{{Form::label('Description')}}</td>
				<td><textarea name="description" class="form-control">{{$project->description}}</textarea></td>
			</tr>			

			<tr>
				<td>{{Form::label('Domain')}}</td>
				<td><textarea class="form-control" name="domain">{{$project->domain}}</textarea></td>
			</tr>
			<tr>
				<td>{{Form::label('Status')}}</td>
				<td>
					{{Form::select('status', ['in-progress', 'inactive', 'canceled'])}}
				</td>
			</tr>			
			<tr>
				<td></td>
				<td><input type="submit" value="Save" class="btn btn-primary" /></td>
			</tr>
		</table>
		
	{{Form::close()}}
@endsection