/*!
 * Contact Buttons Plugin Demo 0.1.0
 * https://github.com/joege/contact-buttons-plugin
 *
 * Copyright 2015, José Gonçalves
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
 
// Google Fonts
(function() {
	  var wf = document.createElement('script');
	  wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
	  wf.type = 'text/javascript';
	  wf.async = 'true';
	  var s = document.getElementsByTagName('script')[0];
	  s.parentNode.insertBefore(wf, s);
})();

$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
	var pathFixed = window.location.protocol + "//" + window.location.host;
	var rootFixed = window.location.protocol + "//" + window.location.host + '/pcis';
	for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
	for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
	var query  = getQueryParams(document.location.search);

	var d = new Date();
	var n = d.getTime();

	var hint_main		= 'กลับหน้าหลัก';
	var hint_prev		= 'แสดงรายละเอียดข้อมูล';
	var hint_edit		= 'แก้ไขข้อมูล';
	var hint_save		= 'บันทึกข้อมูล';
	
	var saveable		= true;
	var check_denied	= $('#check_denied_role').length;
	if(check_denied && check_denied > 0) {
		saveable = false;
	}

	// Initialize Share-Buttons
	$.contactButtons({
	  effect  : 'slide-on-scroll',
	  buttons : {
		    'Main': { class: 'facebook fg-white', use: true, icon: 'home', hint: hint_main, link: pathFixed + 'metro/appProgress' },
		    'Preview': { class: 'linkedin fg-white', use: false, icon: 'ban', hint: hint_prev, iopt: 'fa-stack-2x', link: '#' },
		    'Edit': { class: 'gplus fg-white', use: saveable, icon: 'edit', hint: hint_edit, link: pathFixed + 'metro/routers?_=' + n + '&rel=' + query['rel'] + '&req=P3&live=2&wrap=' + new Date().getTime() },
		    'Save':{ class: 'git fg-white', use: false, icon: 'save', hint: hint_save, link: '#', extras: 'id="submitApplicationStatusForm"' }
	  }

	});

    var el = $("#contact-buttons-bar.slide-on-scroll");
    el.attr('data-top', el.css('top'));
    
    $(window).scroll(function() {
	      clearTimeout( $.data( this, "scrollCheck" ) );
	      $.data( this, "scrollCheck", setTimeout(function() {
	        var nTop = $(window).scrollTop() + parseInt(el.attr('data-top'));
	        el.animate({
	        	top : nTop
	        }, 500);
	      }, 250));
    });
    
    $.ajax({
    	url: pathFixed+'dataloads/getPostponeReasonForSpanText?_=' + new Date().getTime(),
    	  type: 'POST',
	    data: {
	    	'docx': query['rel']
	    },
	    success:function(resp) {	
	    	if(resp.status) {
	    		$('#postpone_txtreason').text(resp.text);
	    	}
	    	        	  
	    },
	    cache: true,
	    timeout: 5000,
	    statusCode: {
	    	404: function() {
	    		alert( 'page not found.' );
	    	},
	    	407: function() {
	    		console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
	    	},
	    	500: function() {
	    		console.log('internal server error.');
	    	}
	    }
    	 
    });

	// Function
	function getQueryParams(qs) {
	    qs = qs.split("+").join(" ");

	    var params = {}, tokens,
	        re = /[?&]?([^=]+)=([^&]*)/g;

	    while (tokens = re.exec(qs)) {
	        params[decodeURIComponent(tokens[1])]
	            = decodeURIComponent(tokens[2]);
	    }

	    return params;
	}
	
	
});

