#API

The sniplet for loading the feedback widget is customizable from how it loads and where its placed and finally what triggers the widget.

	var _feedback = _feedback || {};

	/*
	 * Project API key from your dashboard
	 */
	
	_feedback.project = "xxxxxxx";

	/*
	 * Feedback trigger label
	 *
	 * This is only used on default trigger element
	 */
	
	_feedback.label = 'Feedback';

	/*
	 * Feedback hosting service provider
	 *
	 * Due to the open nature of the project, many instances of feedback servers will exist. Without 
	 * this the widget will not load for it can find where its served from. A team can setup a 
	 * dedicated feedback server for there own projects. Its automatically setup in the script depending on where the sniplet is copied from 
	 */
	
	_feedback.host = "feedback.stackvillage.com";

	/*
	 * Feedback Type
	 *
	 * Depending on your kind of project one always requires flexibility on design. Docked feedback
	 * will appear on a fixed place in the window near the edges. This will not cover a large 
	 * portion on the user view on the webpage. Popup is the feeback body will appear in the center
	 * of the browser and grab full attention from the user. Inline feedback appears where its
	 * specified and pushes the dome to make space. This is desirable on portable devices
	 */

	_feedback.type = 'inline'; // Type can be either (inline, popup, docked|default)

	/*
	 * Feedback trigger
	 *
	 * This is the element responsible for toggling the feedback widget. It enables positioning of
	 * the trigger far from the actual widget and can be a simple link in the footer of the project.
	 * Or anywhere else in the page
	 */
	_feedback.trigger = document.getElementById('feedback_trigger');

	/*
	 * Feedback Preload
	 *
	 * This may slow down webpage load speed, determines whether the iframe is loaded when the page 
	 * loads or when the trigger button is clicked
	 */
	_feedback.preload = false;

	/*
	 * Feedback position
	 *
	 * Affects positioning of the feedback button on the browser window. This is only effective
	 * on popup and docked modes
	 */
	_feedback.position = 'bottom left'; // Where to position feedback widget

	/*
	 * Feedback context
	 *
	 * When the setup of the widget begins, this determines the positioning of the feedback widget
	 * in the DOM. This is essential in inline mode and favours small browsers
	 */
	
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