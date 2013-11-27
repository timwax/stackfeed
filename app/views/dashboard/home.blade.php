@extends('layout.dashboard')

@section('content')
	Hello world
@endsection

@section('sidebar')
	<a href="#/projects/add" class="btn btn-sm btn-block btn-link" style="text-align: left"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New project</a>

	<div ng-include="'/dashboard/views/partials/message-filter.html'"></div>
@endsection