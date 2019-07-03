$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    var query  = getQueryParams(document.location.search);
    
    // Object Date
    var str_date;
    var objDate = new Date();
    str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();   // Set Date format DD/MM/YYYY
    
    // Object Element
    var objrmprocess   = $("#rmprocess");
    var objrmprocdate  = $("#rmprocessdate");
    
    // RM Modal
    var divRMModal	   = $('#RMProcessListModal');
    
 // Auto Increment List
    var max_fields      = 5; //maximum input boxes allowed
    var wrapper         = $(".input_rmfields_wrap"); //Fields wrapper
    var add_button      = $(".add_rmfield_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            
            $(wrapper).append(
            	'<div class="input-control text">' +
            		'<label class="label label-clear ">อื่นๆ : </label>' +
					' <input name="rmprocess_topiclist[]" type="text" value="" class="size4">' +
            		'<i class="fa fa-close fg-red marginTop5 remove_rmfield" style="font-size: 1.5em !important; position: absolute; margin-top: 5px; margin-left: 10px;"></i>' +    
            	'</div>'
            ); 
        }
    });
    
    $(wrapper).on("click",".remove_rmfield", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
    
    
    // RM Combo
    var parent_rmprocess_reason = $('#parent_rmprocess_reason');
	var rmm_otherreason	  = $('#parent_rmprocess_otherreason');
	
	$('#confirmRMProcessList').on('click', function() {
		
		var rmprocess_fieldlist    = $('input[name$="rmprocess_fieldlist[]"]:checked').map(function() {return $(this).val();}).get();
		var rmprocess_topiclist 	= $('input[name$="rmprocess_topiclist[]"]').map(function() {return $(this).val();}).get();
		
		if(rmprocess_fieldlist[0] == undefined && rmprocess_topiclist == "") {
			var not = $.Notify({ content: 'กรุณาเลือกรายการอย่างน้อย 1 รายการ.', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
				not.close(7000); 
				
		} else {
			$('#rmprocess_list_bundled').val(rmprocess_fieldlist);
			$('#rmprocess_otherlist_bundled').val(rmprocess_topiclist);
		
			$('#RMProcessListModal').modal('hide');			
			
		}
		
	});
	
	$('#cancelRMProcessList').on('click', function() { 
		$('#RMProcessListModal').modal('hide'); 
		
		var rmprocess_draft = $('#rmprocess_rollback').val();
		var rmdate_draft	= $('#rmprocessdate_draft').val();
		$('#rmprocess').find('option[value="' + rmprocess_draft + '"]').prop('selected', true);
		$('#rmprocessdate, #rmprocessdate_fake').val(rmdate_draft);
		
	});

    objrmprocess.on('change', function() {
        var process = $('select[name="rmprocess"] option:selected');
        if(process.val() == '' || process.val() == undefined){ $('#rmprocessdate').val(''); $('#rmprocessdate_fake').val(''); } 
        else { $('#rmprocessdate').val(str_date); $('#rmprocessdate_fake').val(str_date); }
    });
    
	rmm_otherreason.hide(); // other list from cancel reason list.
    parent_rmprocess_reason.hide();    
    objrmprocess.on('change', function() {
    	
    	  var process = $('select[name="rmprocess"] option:selected');
    	  if(process.val() == 'CANCELBYRM' || process.val() == 'CANCELBYCUS' || process.val() == 'CANCELBYCA') { 
    		  
    		  if(process.val() == 'CANCELBYRM' || process.val() == 'CANCELBYCA') {
    			  loadDefendReasonList();
    		  }
    		  
    		  if(process.val() == 'CANCELBYCUS') {
    			  getListCancelbyCustomer();    			  
    			  
    		  }

    	  } else {
    		  $('#RMProcessListModal').modal('hide');
    		  
    	  }    	  
    });
    
    
    function getListCancelbyCustomer() {

    	$('#rmprocess_content').html('').append(
		    '<div class="panel grid" style="min-width: 1150px; margin-top: -10px;">'+
			    '<div class="panel-header panel-header-custom bg-lightBlue fg-white text-left" style="font-size: 1.2em; font-weight: bold; min-height: 37px !important; max-height: 37px !important; vetical-text: top; padding-bottom: 2px !important;">Cancel Reason By Customer</div>'+
			    '<div id="rmprocess_contentlist" class="row panel-content" style="margin-top: -10px !important;"></div>'+
		    '</div>'
     	);
    	
    	$.ajax({
	    	  url: pathFixed+'dataloads/getProcessCancelReason?_=' + new Date().getTime(),
	    	  type: "POST",
	          data: {
	          	 ctpye: $('select[name="rmprocess"] option:selected').val()
	          },
	          beforeSend:function() {
	        	  
	        	  $('#RMProcessListModal').modal({
			   			 show: true,
			   			 keyboard: false,
			   			 backdrop: 'static'
			      }).draggable();	
	        	  
	         
	        	
	          },
	          success:function(data) {			
	        	 	        	
	        	  for(var indexed in data['data']) {
	        		  	        		  
	        		  var margin;
	 	              if(indexed == 0) margin = 'style="margin-left: 10px !important;"';
	
	            	  $('div#rmprocess_contentlist')
	            	  .append(
	            			'<div class="rmprocess_sublist span4 text-left" ' + margin + '>' +
	            				'<div class="input-control checkbox">' +
	            					'<label>' +
	            						'<input id="rmprocess_fieldlist_' + indexed + '" name="rmprocess_fieldlist[]" type="checkbox" value="' + data['data'][indexed]['ProcessCode'] + '">' +
	            						'<span class="check"></span>' +
	            						'<span class="rmprocess_fieldtext" style="font-weight: normal;">' + data['data'][indexed]['ProcessReason'] + '</span>' +
	            					'</label>' +
	            				'</div>' +
	            			'</div>'
	            	  );
            	  
	              }   
	        	  
	        	  
	              $('input[name^="rmprocess_fieldlist"]').on('click', function() {
	            	
		       	   var other_field = $('input[name$="rmprocess_fieldlist[]"]:checked').map(function() {return $(this).val();}).get();
		       	   if(in_array("CM999", other_field)) {
		       		   $('#rmprocess_otherlist').show();
		       		   $('#rmprocess_otherlist').css({ "clear":"both", 'margin-top': '10px', 'margin-left': '-10px' });
		       	   } else {
		       		   $('#rmprocess_otherlist').hide();		   
		       	   }
		       	   
		          });
              
	              
	          },
	          complete:function() {
	        	  
	        	
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
    	
    	
    }
    
    function loadDefendReasonList() {
  		
  		$.ajax({
	    	  url: pathFixed+'dataloads/getDefendType?_=' + new Date().getTime(),
	    	  type: "POST",
	    	  data: { dftype: '' },
	          beforeSend:function() {
	        	  
  	        	$('#RMProcessListModal').modal({
		   			 show: true,
		   			 keyboard: false,
		   			 backdrop: 'static'
		    	}).draggable();	
  	        	
	          },
	          success:function(data) {
	        	     	        	 
	  	          $('div#rmprocess_content').html('');  	        	 
	  	          for(var indexed in data['data']) {
	  	        	  
	  	        	  var margin;
	  	        	  if(indexed == 0) margin = 'style="min-width: 1150px; margin-top: 0px;"';
	  	        	  else margin = 'style="min-width: 1150px; margin-top: -20px;"';
	  	        	
	  	        	  $('div#rmprocess_content').append(
	  	        			'<div class="panel" ' + margin + '>' +
	  						   '<div class="panel-header panel-header-custom bg-lightBlue fg-white text-left" style="font-size: 1.2em; font-weight: bold; min-height: 37px !important; max-height: 37px !important; vetical-text: top; padding-bottom: 2px !important;">' +
	  						   		data['data'][indexed]['MDefendSubject'] +
	  						    '</div>' +
	  						    '<div class="row panel-content" data-core="' + data['data'][indexed]['MDefendCode'] + '" style="margin-top: 0px !important;"></div>' +
	  						'</div>'
	  	        	  );
	  	        	  
	  	          }
	        	  
	          },
	          complete:function() {
	  
  	        	$.ajax({
  		   	    	  url: pathFixed+'dataloads/getDefendReason?_=' + new Date().getTime(),
  		   	    	  type: "POST",
  		   	          data: { dftype: '' },
  		   	          beforeSend:function() {
  		   	        
  		   	          },
  		   	          success:function(data) {
  			   	        	  
  			   	          var margin;
  		 	              if(indexed != 0) { 	            		 
  		 	            	 margin = 'style="margin-left: 10px !important; margin-top: -10px !important; margin-bottom: -5px !important; min-width: 350px !important;"';
  		 	            		 
  		 	              }
  		 	             
  			              for(var indexed in data['data']) {
  			            	  
  			            	  $('div#rmprocess_content')
  			            	  .find('div[data-core="' + data['data'][indexed]['DefendType'] + '"]')
  			            	  .append(
  			            			'<div class="defend_sublist span3 text-left" ' + margin + '>' +
  			            				'<div class="input-control checkbox">' +
  			            					'<label>' +
  			            						'<input id="rmprocess_fieldlist_' + indexed + '" name="rmprocess_fieldlist[]" type="checkbox" value="' + data['data'][indexed]['DefendCode'] + '">' +
  			            						'<span class="check"></span>' +
  			            						'<span class="rmprocess_fieldtext" style="font-weight: normal;">' + data['data'][indexed]['DefendReason'] + '</span>' +
  			            					'</label>' +
  			            				'</div>' +
  			            			'</div>'
  			            	  );
  			            	  
  			              }   
  			              
  			              $('input[name^="rmprocess_fieldlist"]').on('click', function() {
  			            	
		  			       	   var other_field = $('input[name$="rmprocess_fieldlist[]"]:checked').map(function() {return $(this).val();}).get();
		  			       	   if(in_array("OT099", other_field)) {
		  			       		   $('#rmprocess_otherlist').show();
		  			       	   } else {
		  			       		   $('#rmprocess_otherlist').hide();		   
		  			       	   }
	  			       	   
	  			          });
  			                
  		   	          },
  		   	          complete:function() {
  		   	        	
    		   	
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
    
    function in_array(needle, haystack, argStrict) {

	  var key = '',
	    strict = !! argStrict;

	  if (strict) {
	    for (key in haystack) {
	      if (haystack[key] === needle) {
	        return true;
	      }
	    }
	  } else {
	    for (key in haystack) {
	      if (haystack[key] == needle) {
	        return true;
	      }
	    }
	  }

	  return false;
	} 
    
});