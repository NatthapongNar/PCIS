$(function() {
	
    var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    
    $('title').html('Document Management');
	
	// Define Instance
	var pro_progress = $('#load_progresses');
    
    // Animate
    $('#sub_reconsile_ncb').addClass('animated flipInX');
   	$('#sub_reconsile_doc').addClass('animated flipInX');
	$('#sub_doc_completion').addClass('animated flipInX');
	$('#sub_doc_return').addClass('animated flipInX');
	$('#sub_defend_management').addClass('animated flipInX');
	$('#sub_defend_viewer').addClass('animated flipInX');
	
	// Load record entrie total
	$.ajax({
        url: pathFixed+'metro/loadRowEntries?_=' + new Date().getTime(),
        type: "POST",
        data: { "sl":'1' },
        beforeSend:function() {
        	pro_progress.show();
        },
        success:function(data) {
        	//$('#reconsile_ncb_badge').html(data);

        },
        complete:function() {
        	pro_progress.after(function() {
            	$(this).hide();
            });
        },
        cache: true,
        timeout: 5000,
        statusCode: {
	        404: function() {
	            alert( "page not found." );
	        },
	        407: function() {
	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
	        },
	        500: function() {
	        	console.log("internal server error.");
	        }
        }
    });
	
	$.ajax({
        url: pathFixed+'metro/loadRowEntries?_=' + new Date().getTime(),
        type: "POST",
        data: { "sl":'2' },
        beforeSend:function() {
        	pro_progress.show();
        },
        success:function(data) {
        	//$('#reconsile_doc_badge').html(data);

        },
        complete:function() {
        	pro_progress.after(function() {
            	$(this).hide();
            });
        },
        cache: true,
        timeout: 5000,
        statusCode: {
	        404: function() {
	            alert( "page not found." );
	        },
	        407: function() {
	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
	        },
	        500: function() {
	        	console.log("internal server error.");
	        }
        }
	});


	
});