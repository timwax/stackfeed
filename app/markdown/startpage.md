[github]: http://github.com/timwax/stackfeed "View project here & clone/fork"

#Welcome to stackfeed

This is a feedback application/service for developers wanting real input from their team or the clients who use there product. It is designed with debugging in mind thus each message is send with useful user's environment. This includes **URL**( which page the feedback is send from ), **Browser/userAgent**, **OS/platform** and more.

###Getting started

1. [Create account]('/accounts/create') or [login](/accounts/login) to your dashboard
2. [Register a project]('/home#/products/add') at your dashboard
3. Embed the snipplet genarated to your project &mdash;_preferably at the end of **body**_ e.g

		<script type="text/javascript">
			var _feedback = _feedback || {};
			_feedback.project = '__project_public_id__';
			_feedback.widgets = ['feedback'];
			_feedback.host = '192.168.0.104:8085';
			_feedback.protocal = 'https:' == window.location.protocal ? 'https://' : 'http://';
			_feedback.label = 'Feedback';
			_feedback.inline = ''

			{
				var fb = document.createElement('script'); 
				fb.type = 'text/javascript'; 
				fb.async = true; 
				fb.src = _feedback.protocal + _feedback.host +'/fb.js';
				document.body.appendChild(fb);
			}
		</script>

4. And you are ready to receive __awesome__ feedback

---

Comming soon to [Github][github]