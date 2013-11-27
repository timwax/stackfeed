@extends('layout.project')

@section('quick-access')
	<button type="button" class="btn btn-danger btn-xs">Delete</button> | open as issue
@stop

@section('project-title')
	{{$project->name}}
@stop

@section('content')
	<section class="info">
		<div class="row">
			<div class="col-sm-8">
				@if($message->stared == 1)
					<span class="glyphicon glyphicon-star"></span>
				@else
					<span class="glyphicon glyphicon-star-empty"></span>
				@endif
				&nbsp;
				<span class="icon-{{strtolower($message->data['browser'])}}" title="{{$message->data['browserFull']}}"></span>
			</div>
			<div class="col-sm-4">{{Carbon\Carbon::createFromTimestamp(strtotime($message->created_at))->diffForHumans()}}</div>
		</div>
	</section>


	<section class="message">{{$message->content}}</section>

	@if($message->meta != '')
	<section>
		<h4>Meta data</h4>
		
			<?php $meta = json_decode($message->meta); ?>
			
			<table class="table">
				@foreach($meta as $key=>$value)
					<tr>
						<td>{{ucwords(preg_replace("/(([a-z])([A-Z])|([A-Z])([A-Z][a-z]))/","\\2\\4 \\3\\5",$key))}}</td>
						<td>{{$value}}</td>
					</tr>
				@endforeach
			</table>
	</section>
	@endif
<!-- 	<section class="comments">
		<h4>Comments/Annotations (n)</h4>

		<ul>
			<li>This is an example of a comment. This feature will be implemented after before public launch of product &mdash;by <a href="#">admin</a> - 2 days ago</li>
			<li>
				<textarea placeholder="Leave a comment" class="form-control"></textarea>
				<button type="button" class="btn btn-sm btn-primary">Comment</button>
			</li>
		</ul>
	</section> -->

@stop