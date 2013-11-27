<script type="text/javascript">
	var _feedback = _feedback || {};
	_feedback.project = "{{Config::get('app.pid')}}";
	_feedback.label = 'Feedback';
	_feedback.host = "{{Config::get('app.hostname')}}";
	_feedback.type = 'docked'; // Type can be either (inline, popup, docked|default)
	_feedback.trigger = document.getElementById('feedback_trigger');
	_feedback.preload = false;
	_feedback.position = 'bottom left'; // Where to position feedback widget
	_feedback.context = document.getElementById('stack-feedback');

	_feedback.init = function(){
		this.protocal = 'https:' == window.location.protocal ? 'https://' : 'http://';

		var fb = document.createElement('script'); 
		fb.type = 'text/javascript'; 
		fb.async = true; 
		fb.src = this.protocal + this.host +'/fbv0.2.js';
		document.body.appendChild(fb);
	}

	_feedback.init();
</script>