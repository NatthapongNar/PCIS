$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    var rootFixed = window.location.protocol + "//" + window.location.host + '/pcis';
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    var query  = getQueryParams(document.location.search);
    
    $("#rmprocess").change(function() {
       var actionsel = '#' + moment().format('DDMM');
 	   var selected  = $(this).find('option:selected').val();
 	   var str_text  = $('#actionnote').val();
 	   
 	   var patterns  = actionsel + ' ' + selected + ';';
 	   var pattRegEx = new RegExp(patterns);
 	   var validate  = pattRegEx.test(str_text);
 
 	   var str_concat = '';
 	   if(!empty(selected)) { 		   
 		  str_concat = actionsel + ' ' + selected + '; ' + str_text; 	 	
 	   } else {
 		   str_concat = str_text;
 	   }
 	  
 	   if(!validate) {
 		  $('#actionnote').val(str_concat);
 	   }
 	   
    });
    
    function empty(str) {
    	if(str && str.trim() !== '') {
    		return false;
    	} else {
    		return true;
    	}
    }
    
    
});

       