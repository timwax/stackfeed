[github]: http://github.com/timwax/stackfeed "View project here & clone/fork"

#Welcome to stackfeed

This is a feedback application/service for developers wanting real input from their team or the clients who use there product. It is designed with debugging in mind thus each message is send with useful user's environment. This includes **URL**( which page the feedback is send from ), **Browser/userAgent**, **OS/platform** and more.

###Getting started

1. [Create account]('/accounts/create') or [login](/accounts/login) to your dashboard
2. [Register a project]('/home#/products/add') at your dashboard
3. Embed the snipplet genarated to your project &mdash;_preferably at the end of **body**_ e.g

		<script type="text/javascript">
			var _feedback = _feedback || {};

			_feedback.project = "xxxxxxx";
			_feedback.label = 'Feedback';
			_feedback.host = "feedback.stackvillage.com";
			_feedback.type = 'inline'; // Type can be either (inline, popup, docked|default)
			_feedback.trigger = document.getElementById('feedback_trigger');
			_feedback.preload = false;
			_feedback.position = 'bottom-left';
			_feedback.context = document.getElementById('stack-feedback');

			_feedback.init = function(){
				this.protocal = 'https:' == window.location.protocal ? 'https://' : 'http://';

				var fb = document.createElement('script'); 
				fb.type = 'text/javascript'; 
				fb.async = true; 
				fb.src = this.protocal + this.host +'/fb.js';
				document.body.appendChild(fb);
			}

			_feedback.init();
		</script>

4. And you are ready to receive __awesome__ feedback

---

Check us out on [Github][github]