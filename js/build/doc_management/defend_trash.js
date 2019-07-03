$(document).ready(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
	var query  = getQueryParams(document.location.search);
	
	
	$('#defend_remove').bind('click', function() {
		
		if(confirm('กรุณายืนยันการลบข้อมูลการ Defend\n(กรุณาตรวจสอบข้อมูลก่อนทำการลบข้อมูล).')) {

			var rel = query['rel'];
			var lnx = query['lnx'];
			
			$.ajax({
		      	url: pathFixed + 'dataloads/setTrashDefendTransaction',
		        data: { 
		        	relx: rel,
		        	lnsx: lnx
		        },
		        type: "POST",
			    success: function (responsed) { 
			    	
			    	if(responsed['status']) {
			    		
			    		notif({
			  		    	msg: "Remove Successfully. Please wait 2 second.",
			  		    	type: "success",
			  		    	position: "right",
			  		    	opacity: 1,
			  		    	width: 300,
			  		    	height: 50,
			  		    	autohide: false
			  			});
			    			    		
			    		setTimeout(window.close, 2000);
                    	
			    	} else {
			    		
			    		notif({
			  		    	msg: "Remove Failed, Please try again.",
			  		    	type: "error",
			  		    	position: "right",
			  		    	opacity: 1,
			  		    	width: 300,
			  		    	height: 50,
			  		    	autohide: false
			  			});
	
			    	}

			    },
			    complete:function() {
			    	
			    	
		        },
			    error: function (error) {
				    console.log(error);
			 	        
			    }	        
			});
			
			return true;
		}
		
		return false;
		
	});
	

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