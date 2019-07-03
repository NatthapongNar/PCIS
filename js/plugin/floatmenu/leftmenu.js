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

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
var rootFixed = window.location.protocol + "//" + window.location.host + '/pcis';
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
var query  = getQueryParams(document.location.search);

var d = new Date();
var n = d.getTime();

var main_enabled 	= true;
var prev_enabled 	= true;
var edit_enabled 	= true;
var save_enabled 	= true;
var prev_additional	= '';
var edit_additional	= '';

var hint_main		= 'กลับหน้าหลัก';
var hint_prev		= 'แสดงรายละเอียดข้อมูล';
var hint_edit		= 'แก้ไขข้อมูล';
var hint_save		= 'บันทึกข้อมูล';

switch (pathArray[4]) {
	case 'getDataVerifiedManagement':
		
		main_enabled = true;
		prev_enabled = true;
		edit_enabled = false;
		save_enabled = true;
		
		prev_additional	= '';
		edit_additional	= ' fa-check fa-stack-2x';
		
	break;	

}


// Initialize Share-Buttons
$.contactButtons({
  effect  : 'slide-on-scroll',
  buttons : {
    'Main': { class: 'facebook fg-white', use: main_enabled, icon: 'home', hint: hint_main, link: pathFixed + 'metro/appProgress' },
    'Preview': { class: 'linkedin fg-white', use: prev_enabled, icon: 'eye', hint: hint_prev, iopt: prev_additional, link: pathFixed + 'management/getDataVerifiedPreview?_=' + n + '&rel=' + query['rel'] + '&req=P2&live=1&wrap=' + new Date().getTime() },
    'Edit': { class: 'gplus fg-white', use: edit_enabled, icon: 'check', hint: hint_edit, iopt: edit_additional, link: '#' },
    'Save':{ class: 'git fg-white', use: save_enabled, icon: 'save', hint: hint_save, link: '#', extras: 'id="submitVerificationForm"' }
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