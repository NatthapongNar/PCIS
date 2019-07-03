$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
	var pathFixed = window.location.protocol + "//" + window.location.host;
	for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
	for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathFixed[i]; pathFixed += "/"; }	
	var query  = getQueryParams(document.location.search);

	var url_path 		= 'http://172.17.9.94/pcisservices/PCISService.svc/';
	var urlProfile  	= url_path + "GetKPI00ProfileReport";

	miniProfile(urlProfile, $('#empprofile_identity').val());

	function miniProfile(url, condition) {
		
		$.ajax({
	       url: url,
	       data: { RMCode: condition },
	       jsonpCallback: "my_miniprofiles_" + Math.floor((Math.random()* 10) + 1),
	       dataType: "jsonp",
	       crossDomain: true,
	       success: function (responsed) {
	    	
	           var result = responsed.Data;
	           if (result.length > 0) {
	        	   
	        	   var corp		 = result[0].BranchNameEng + ' (Period ' + result[0].WorkingYMD + ')';
	        	   var mobile	 = result[0].Mobile + ' (' + result[0].Nickname + ')';
	        	   var probation = (result[0].PassProbation) ? '(' + result[0].PassProbation + ')' :'';
	        	   
	        	   $('#Profiles')
	        	   .html('')
	        	   .append(
	        			'<span style="margin-left: 3px;"><b class="tooltip-bottom" data-tooltip="' + mobile + '">' + result[0].FullNameEng.toUpperCase() + '</b> (' + result[0].Position + ') </span> <br/>' +
	        			'<span style="margin-left: 3px; font-size: 13px !important;">' + corp + ' ' + probation + '</span>' +
	        			'<div>' +
		        			'<span id="chat_state" class="chat-state"></span>' +
		        			'<img id="img_profile" src="' + result[0].UserImagePath + '" style="background-color: #4390DF; margin-top: 3.5px; margin-left: -13px; width: 55px; height: 55px; border-radius: 50%;">' +
	        			'</div>'	        			
	        	   ).parent().addClass('animated fadeIn');	   
	        	 	        	           	   
	           }
			   
	       },
	       error: function (error) {
	           
	       }
	       
	   });
		
	}

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

