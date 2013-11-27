var XD=function(){var e,t,n=1,r,i=this;return{postMessage:function(e,t,r){if(!t){return}r=r||parent;if(i["postMessage"]){r["postMessage"](e,t.replace(/([^:]+:\/\/[^\/]+).*/,"$1"))}else if(t){r.location=t.replace(/#.*$/,"")+"#"+ +(new Date)+n++ +"&"+e}},receiveMessage:function(n,s){if(i["postMessage"]){if(n){r=function(e){if(typeof s==="string"&&e.origin!==s||Object.prototype.toString.call(s)==="[object Function]"&&s(e.origin)===!1){return!1}n(e)}}if(i["addEventListener"]){i[n?"addEventListener":"removeEventListener"]("message",r,!1)}else{i[n?"attachEvent":"detachEvent"]("onmessage",r)}}else{e&&clearInterval(e);e=null;if(n){e=setInterval(function(){var e=document.location.hash,r=/^#?\d+&/;if(e!==t&&r.test(e)){t=e;n({data:e.replace(r,"")})}},100)}}}}}()

var DomOutline=function(e){function r(e){var t=document.createElement("style");t.type="text/css";document.getElementsByTagName("head")[0].appendChild(t);if(t.styleSheet){t.styleSheet.cssText=e}else{t.innerHTML=e}}function i(){if(n.initialized!==true){var e=""+"."+n.opts.namespace+" {"+"    background: #09c;"+"    position: absolute;"+"    z-index: 1000000;"+"}"+"."+n.opts.namespace+"_label {"+"    background: #09c;"+"    border-radius: 2px;"+"    color: #fff;"+"    font: bold 12px/12px Helvetica, sans-serif;"+"    padding: 4px 6px;"+"    position: absolute;"+"    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.25);"+"    z-index: 1000001;"+"}";r(e);n.initialized=true}}function s(){n.elements.label=jQuery("<div></div>").addClass(n.opts.namespace+"_label").appendTo("body");n.elements.top=jQuery("<div></div>").addClass(n.opts.namespace).appendTo("body");n.elements.bottom=jQuery("<div></div>").addClass(n.opts.namespace).appendTo("body");n.elements.left=jQuery("<div></div>").addClass(n.opts.namespace).appendTo("body");n.elements.right=jQuery("<div></div>").addClass(n.opts.namespace).appendTo("body")}function o(){jQuery.each(n.elements,function(e,t){t.remove()})}function u(e,t,n){var r=e.tagName.toLowerCase();if(e.id){r+="#"+e.id}if(e.className){r+=("."+jQuery.trim(e.className).replace(/ /g,".")).replace(/\.\.+/g,".")}return r+" ("+Math.round(t)+"x"+Math.round(n)+")"}function a(){if(!n.elements.window){n.elements.window=jQuery(window)}return n.elements.window.scrollTop()}function f(e){if(e.target.className.indexOf(n.opts.namespace)!==-1){return}t.element=e.target;var r=n.opts.borderWidth;var i=a();var s=t.element.getBoundingClientRect();var o=s.top+i;var f=u(t.element,s.width,s.height);var l=Math.max(0,o-20-r,i);var c=Math.max(0,s.left-r);n.elements.label.css({top:l,left:c}).text(f);n.elements.top.css({top:Math.max(0,o-r),left:s.left-r,width:s.width+r,height:r});n.elements.bottom.css({top:o+s.height,left:s.left-r,width:s.width+r,height:r});n.elements.left.css({top:o-r,left:Math.max(0,s.left-r),width:r,height:s.height+r});n.elements.right.css({top:o-r,left:s.left+s.width,width:r,height:s.height+r*2})}function l(e){if(e.keyCode===n.keyCodes.ESC||e.keyCode===n.keyCodes.BACKSPACE||e.keyCode===n.keyCodes.DELETE){t.stop()}return false}function c(e){t.stop();n.opts.onClick(t.element);return false}e=e||{};var t={};var n={opts:{namespace:e.namespace||"DomOutline",borderWidth:e.borderWidth||2,onClick:e.onClick||false},keyCodes:{BACKSPACE:8,ESC:27,DELETE:46},active:false,initialized:false,elements:{}};t.start=function(){i();if(n.active!==true){n.active=true;s();jQuery("body").bind("mousemove."+n.opts.namespace,f);jQuery("body").bind("keyup."+n.opts.namespace,l);if(n.opts.onClick){setTimeout(function(){jQuery("body").bind("click."+n.opts.namespace,c)},50)}}};t.stop=function(){n.active=false;o();jQuery("body").unbind("mousemove."+n.opts.namespace).unbind("keyup."+n.opts.namespace).unbind("click."+n.opts.namespace)};return t}

_feedback.domOutline = DomOutline({ onClick : function(element){
	console.log('Selected Item');

	var p = $(element).getPath();

	$(element).addClass('ss-issue-highlight');

	XD.postMessage({
		type: 'selected', 
		message: $(element).getPath()
	}, _feedback.widget.origin, _feedback.widget.source);

	_feedback.domOutline.stop();
}});

_feedback.widget = {};

_feedback.load = function(element){
	var x = $('<iframe>');
	x.addClass('feedback-frame');
	x.bind('load', function(){
		// Append iframe to feedback body

		// Setup loaded flag
		_feedback.loaded = true;

		console.log('iframe loaded');
		element.find('.loading').remove();
	});

	x.attr({'src': _feedback.protocal + _feedback.host + '/embed/feedback-v0.2.php?pid=' + _feedback.project + '&origin=' + _feedback.protocal + window.location.host});
	x.attr({'width': '100%', 'frameborder': '0', height: '380'});

	element.append(x);
}

_feedback.unload = function(){
	$('.st-feedback .widget iframe').remove();

	this.hide();
}

_feedback.toggle = function(e){
	if($(this).closest('.widget').find('.body').is(':visible')){
		$(this).closest('.widget').find('.body').hide();
		$(this).closest('.widget').find('.header .close ').hide();

		console.log('Hidden');
	}else{
		if (!_feedback.loaded) _feedback.load($(this).closest('.widget').find('.body'));

		$(this).closest('.widget').find('.body').show();
		$(this).closest('.widget').find('.header .close ').show();
		console.log('Visible');
	}
	
}

_feedback.hide = function(){
	/* Keeps widget loaded but hides body */

	$('.st-feedback .widget .body').hide();
}

var docked="";
docked += "<div class=\"st-feedback\">";
docked += "<div class=\"widget\">";
docked += "<div class=\"header\">";
docked += "<img src=\""+ _feedback.protocal + _feedback.host + "/icon2.png\"><span class=\"title\">Feedback<\/span><span class=\"close\">x<\/span><span class=\"hide\">_<\/span><\/div>";
docked += "<div class=\"body\"><span class=\"loading\">Loading...</span><\/div><\/div>";
docked += "<\/div>";

if (_feedback.type == 'docked'){
	// Append :docked to body
	if (_feedback.context != null){ // Check if DOM element
		$(_feedback.context).html(docked);

		$('.header', '.st-feedback').bind('click', _feedback.toggle);
	}
}

// Listen to widgets

XD.receiveMessage(function(message){
	console.log('Now we are talking');

	//console.dir(message)

	switch(message.data.type){
		case "init":
			if (_feedback.widget.source == undefined) _feedback.widget.source = message.source;
			if (_feedback.widget.origin == undefined) _feedback.widget.origin = message.origin;

			/* Send when the iframe loads */
			console.log('Hey, take this stuff before i post my message');

			XD.postMessage({
				type: "setup", 
				message: {
					uri: window.location.href,
					screenWidth: window.screen.availWidth,
					screenHeight: window.screen.availHeight,
					docWidth: document.width, 
					docHeight: document.height,
					windowWidth: window.innerWidth > 0 ? window.innerWidth : screen.width,
					windowHeight: window.innerHeight > 0 ? window.innerHeight : screen.height,

					// Platform

					platform: window.navigator.platform,
					appCodeName: window.navigator.appCodeName,
					appName: window.navigator.appName,
					cookieEnabled: window.navigator.cookieEnabled,
					language: window.navigator.language,
					product: window.navigator.product,
					vendor: window.navigator.vendor,
					userAgent: window.navigator.userAgent
				}
			}, message.origin, message.source);
		break;

		case 'done':
			console.log('Message has been sent, close this widget asap');
			_feedback.unload();
		break;

		case 'cancel':
			console.log('Feedback cancel link clicked');
			_feedback.hide();
		break;

		case 'startHighlight':
			_feedback.domOutline.start();

			// Signal widget that highlighting has started
			XD.postMessage({type: 'highlight', message: 'started'}, message.origin, message.source);
		break;

		case 'cancelHighlight':
			_feedback.domOutline.stop();

			XD.postMessage({type: 'highlight', message: 'stopped'}, message.origin, message.source);
		break;
	}
}, _feedback.protocal + _feedback.host )