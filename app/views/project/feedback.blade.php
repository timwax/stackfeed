@extends('layout.project')

@section('quick-access')
	<div class="showing pull-right"><strong>{{$paginate['from']}}</strong> - <strong>{{$paginate['to']}}</strong> of {{$paginate['total']}}</div>
@endsection

@section('content')

	<table class="table feedback-messages">
		@foreach ($messages as $key => $message)
			<tr class="{{$message['read'] == '' ? 'unread': ''}}">
				<td class="star">
					@if($message['stared'] == 1)
						<span class="glyphicon glyphicon-star"></span>
					@else
						<span class="glyphicon glyphicon-star-empty"></span>
					@endif
				</td>
				@if(strlen($message['content']) > 70)
					<td><a href="{{URL::route('project-feedback-message')}}" class="summary">{{substr($message['content'], 0, 70)}}...</a></td>
				@else
					<td><a href="{{URL::route('project-feedback-message')}}" class="summary">{{$message['content']}}</a></td>
				@endif
				<td>
					<!-- <span class="icon-firefox"></span>&nbsp; -->
					@if(isset($message['browser']))
						<span class="icon-{{strtolower($message['browser'])}}" title="{{$message['browserFull']}}"></span>
					@endif

					@if($message['read'] == '')
						<a href="#" title="Mark as read" class="eye"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;
					@endif
					<a href="#" class="flag" title="Report message"><span class="glyphicon glyphicon-flag"></span></a>
				</td>
				<td class="posted">{{\Carbon\Carbon::createFromTimestamp(strtotime($message['created_at']))->diffForHumans()}}</td>
			</tr>
		@endforeach		
	</table>

	{{$links}}
@endsection