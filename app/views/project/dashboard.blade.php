@extends('layout.project')

@section('quick-access')
	
@endsection

@section('content')
<div class="row">
	<div class="col-sm-8">
		<p class="project-summary">Quick project message like <a htef="/">dev4</a></p>

		<section><!-- Project stats -->
			<div class="panel panel-info">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3">status: <strong>in progress</strong></div>
						<div class="col-sm-3">tasks: <strong>in progress</strong></div>
						<div class="col-sm-3">collaborators: <strong>5</strong></div>
						<div class="col-sm-3">due: <strong>15th Dec 2013</strong></div>
					</div>
				</div>
			</div>
		</section>

		<section class="latest-posts"><!-- Latest posts -->
			<h4 style="margin:0; padding:0;">Latest Posts</h4>
			<hr />

			<ul>
				<li>
					<h5>This is a title for a post</h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud...</p>
				</li>			
				<li>
					<div class="row">
						<div class="col-sm-4">
							<img src="http://placehold.it/150">
						</div>

						<div class="col-sm-8">
							<h5>This is a title for a post with image</h5>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud...</p>
						</div>
					</div>
					
				</li>

				<li>
					<div class="alert alert-info">
					No posts found, <a href="#" class="alert-link">create one</a>
					</div>
				</li>
			</ul>
		</section>

		<section><!-- Current tasks -->
			<h4>Current tasks</h4>

			<hr />
			<ul class="project-tasks">
				<li>Homepage Draft</li>						
				<li>Services Draft</li>						
				<li>About Us Draft</li>						
				<li>Contacts Us Draft</li>
			</ul>
		</section>

	</div>
	<div class="col-sm-4">
		<h4>Latest feedback</h4>
		<hr style="margin-bottom: 0" />
		<div class="latest-feedback">
			<ul>
				@foreach($feedback as $key => $message)
					<li>
						<p class="feedback-message-summary">{{$message->content}}</p>
						<div class="feedback-url"><a href="{{isset($message->link)? $message->link: 'not set'}}">{{isset($message->link)? $message->link: 'not set'}}</a></div>
						<div class="">
							<span><span class="icon-{{strtolower($message->browser)}}" title="{{$message->browserFull}}"></span></span>
							<span><span class="glyphicon glyphicon-picture"></span></span>
							<span>{{Carbon\Carbon::createFromTimestamp(strtotime($message->created_at))->diffForHumans()}}</span>
						</div>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection