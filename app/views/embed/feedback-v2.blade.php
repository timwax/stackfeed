<!DOCTYPE html>
<html lang="en_US">
<head>
	<title>Feedback</title>
	<meta name="viewpoint" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/packages/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/feedback.css">
</head>
<body>

<!-- Start feedback form -->
<div class="container" id="feedback">
	<div class="brand">
		<span class="pull-right">{{Lang::get('feedback.powered_by')}} 
			<a href="#">Stackfeed <span style="color: red;">(Beta)</span></a>
		</span>
	</div>
	
	<div class="clearfix"></div>
	<p class="message">{{Lang::get('feedback.banner')}}</p>

	<div class="controls">
		<div class="row">
			<div class="col-xs-6">
				<button type="button" class="btn btn-secondary btn-block btn-xs highlight" title="Select the issue on the page">{{Lang::get('feedback.highlight')}}</button>

				
			</div>
			<div class="col-xs-6">
				<!-- <button type="button" class="btn btn-secondary btn-block btn-xs" title="Remove private data">{{Lang::get('feedback.blackout')}}</button> -->
			</div>
		</div>
	</div>

	<div>
		<textarea col="5" placeholder="{{Lang::get('feedback.textarea_placeholder')}}" class="msg" id="message"></textarea>
	</div>
</div>

<div class="actions">
	<table border="0" width="100%">
		<tr>
			<td><button type="button" class="btn btn-sm btn-primary btn-submit">{{Lang::get('feedback.send')}}</button></td>
			<td><button type="button" class="btn btn-sm btn-link btn-cancel">{{Lang::get('feedback.cancel')}}</button></td>
		</tr>
	</table>
</div>

<!-- End feedback -->
<script type="text/javascript" src="/packages/jquery/jquery.min.js"></script>
<script type="text/javascript">
	var app = {
		master: "{{Input::get('origin')}}",
		event: function(type, message){
			XD.postMessage({type: type, message: message}, this.master, window.parent);
		},
		pid: "{{Input::get('pid')}}",
		meta: {}
	};
</script>
<script type="text/javascript" src="/packages/postmessage/postmessage.min.js"></script>
<script type="text/javascript" src="/js/feedback.js"></script>

{{--@include('include.analytics')--}}
</body>
</html>