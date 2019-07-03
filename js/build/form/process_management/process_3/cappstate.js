$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    var query  = getQueryParams(document.location.search);
    
    $('title').html('AP-P3 : ' + $('#borrowername_title').val());
    
    $("#appProgress ul li:first-child").append('<div class="text-muted" style="min-width: 150px; margin-top: 2em; margin-left: -1em;">PROFILE</div>');
    $("#appProgress ul li:nth-child(2)").append('<div class="text-muted" style="min-width: 180px; margin-top: 2em; margin-left: -2.5em;">VERIFICATION</div>');
    $("#appProgress ul li:nth-child(3)").append('<div class="text-muted" style="min-width: 250px; margin-top: 2em; margin-left: -4.2em;">APPLICATION STATUS</div>');
    
    $("#appProgress ul li:first-child").on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P1&live=2&wrap=' + new Date().getTime(); });
    $("#appProgress ul li:nth-child(2)").on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P2&live=2&wrap=' + new Date().getTime(); });
    $("#appProgress ul li:nth-child(3)").on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P3&live=2&wrap=' + new Date().getTime(); });
    
    $("#appProgressHistory ul li:first-child").append('<div class="text-muted" style="min-width: 150px; margin-top: 2em; margin-left: -1em;">PROFILE</div>');
    $("#appProgressHistory ul li:nth-child(2)").append('<div class="text-muted" style="min-width: 180px; margin-top: 2em; margin-left: -2.5em;">VERIFICATION</div>');
    $("#appProgressHistory ul li:nth-child(3)").append('<div class="text-muted" style="min-width: 250px; margin-top: 2em; margin-left: -4.2em;">APPLICATION STATUS</div>');
    
    $("#appProgressHistory ul li:first-child").on('click', function() { document.location.href = pathFixed + 'metro/getProfileInRetrieve?mod=1' + '&rel=' + query['rel'] + '&req=P1&live=1&wrap=' + new Date().getTime(); });
    $("#appProgressHistory ul li:nth-child(2)").on('click', function() { document.location.href = pathFixed + 'management/getDataVerificationInRetrieve?mod=1' + '&rel=' + query['rel'] + '&req=P2&live=1&wrap=' + new Date().getTime(); });
    $("#appProgressHistory ul li:nth-child(3)").on('click', function() { document.location.href = pathFixed + 'metro/getApplicationDecisionInRetrieve?mod=1' + '&rel=' + query['rel'] + '&req=P3&live=1&wrap=' + new Date().getTime(); });
    
    // hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('#back-top').fadeIn();
		} else {
			$('#back-top').fadeOut();
		}
	});

	// scroll body to 0px on click
	$('#back-top a').click(function () {
		$('body, html').animate({
			scrollTop: 0
		}, 800);
		return true;
	});
	
	// Load list after approved reason
	getDecisionCancelApprovedLoan();
	$('#afterRefun').click(function() { getDecisionCancelApprovedLoan(); });
	
	getPendingCancelList();
	
	// Load list postpone plan drawdown reason
	getPostponeReasonLists();
	$('#postponeload').click(function() { getPostponeReasonLists(); });
	
	var pending_cancel_check 	= $('#pending_cancel_check').is(':checked');
	if(!pending_cancel_check) {
		$('#pending_cancel').multipleSelect('disable');
	}
	
	$('#pending_cancel_check').click(function() {
		var after_cancelreason = $(this).is(':checked');
		if(after_cancelreason) {
			$('#pending_cancel').multipleSelect('enable');
		} else {
			$('#pending_cancel').multipleSelect('disable');
		}
	});
	
	function getDecisionCancelApprovedLoan() {
		
		var list_reason = [];
		$.ajax({
	    	  url: pathFixed+'dataloads/getProcessCancelReason?_=' + new Date().getTime(),
	    	  type: "POST",
	          data: {
	        	 ctpye: 'NOTACCEPT'
	          },
	          beforeSend:function() {
	        	 
	          },
	          success:function(data) {	
	        	  
	        	  $('#cancel_reason').empty();
	              for(var indexed in data['data']) {
	            	  $('#cancel_reason').append("<option value='" + data['data'][indexed]['ProcessCode'] + "'>" + data['data'][indexed]['ProcessReason'] + "</option>");
	              }
	            	           
	          },
	          complete:function() {
	        	  
	        	  $.ajax({
	    	    	  url: pathFixed+'dataloads/getCancelReasonByCustomer?_=' + new Date().getTime(),
	    	    	  type: "POST",
	    	          data: { docx: query['rel'] },
	    	          success:function(responsed) {			        	  
	    	        	  
	    	        	  if(responsed['status']) {  	                    		
	                    		for(var index in responsed['data']) {
	                    			list_reason.push(responsed['data'][index]['ProcessCode']);  
	                    			
	                    		}  
	                    		
	                    	} else {
	                    		list_reason.push(0); 
	                    	}
	    	        	
	    	          },
	    	          complete:function() {
	    	        	  
	    	        	  if(list_reason[0] != "") {	  	   	        		
	  	   	        		 for(var index in list_reason) {
	  	   	        			$('#cancel_reason').find('option[value="' + list_reason[index] + '"]').attr('selected', 'selected');	
	  	   	        			console.log(list_reason[index]);
	  	   	        		 }	   	        		
	    	        	  }
	    	        	  

	    	          	  if( $('#cancel_reason').val() != null) $('#cancel_checker').prop('checked', true);
	    	          	  else $('#cancel_checker').prop('checked', false);    
	    	        	  
	    	        	  $('#cancel_reason').change(function() {}).multipleSelect({ width: '100%', filter: true, minimumCountSelected: 1 });
	    	        	  
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

	function getPendingCancelList() {		
		$.ajax({
	    	  url: pathFixed+'dataloads/getMasterPendingCancelReason?_=' + new Date().getTime(),
	    	  type: "POST",
	          data: {},
	          beforeSend:function() {},
	          success:function(resp) {	

	        	  if(resp && resp.data.length > 0) {
	        		  $('#pending_cancel').empty();
		        	  
		        	  var group_data = _.uniqWith(_.map(resp.data, (v) => { return v.ProcessGroup }), _.isEqual);
		              for(var indexed in group_data) {
		            	  $('#pending_cancel').append("<optgroup label='" + group_data[indexed] + "'></optgroup>");
		              }
		    
		              _.delay(function(){
			              for(var indexed in resp.data) {
			            	  var optgroup_tag = resp.data[indexed]['ProcessGroup']
			            	  if(optgroup_tag) {
			            		  $('#pending_cancel').find('optgroup[label="' + optgroup_tag + '"]').append("<option value='" + resp.data[indexed]['ProcessCode'] + "'>" + resp.data[indexed]['ProcessReason'] + "</option>");
			            	  }		            	 
			              }

			              $.ajax({
			    	    	  url: pathFixed+'dataloads/getPendingCancelReasonByCustomer?_=' + new Date().getTime(),
			    	    	  type: "POST",
			    	          data: { docx: query['rel'] },
			    	          success:function(responsed) {			        	  
			    	        	  
			    	        	  var list_reason = [];
			    	        	  if(responsed['status']) {  	                    		
			                    		for(var index in responsed['data']) {
			                    			list_reason.push(responsed['data'][index]['ProcessCode']);  
			                    			
			                    		}  
			                    		
			                      } else {
			                    		list_reason.push(0); 
			                      }
			    	        	  
			    	        	  $('#pending_cancel').multipleSelect({ 
					            	  multiple: true, 
					            	  selectAll: false,
					            	  multipleWidth: 350,
					              }).multipleSelect('setSelects', list_reason);		
			    	        	
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
			              			              
		              }, 200)
		              
	        	  }
           
	          },
	          complete:function() {},
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
	
	function getPostponeReasonLists() {
		
		$.ajax({
	    	  url: pathFixed+'dataloads/getPostponeReasonlist?_=' + new Date().getTime(),
	    	  type: "GET",
	          beforeSend:function() {
	        	 
	        	  
	          },
	          success:function(data) {			        	  
	        	  
	        	  $('#postpone_planreason').empty();
	              for(var indexed in data['data']) {
	            	  $('#postpone_planreason').append("<option value='" + data['data'][indexed]['PostponeCode'] + "'>" + data['data'][indexed]['PostponeReason'] + "</option>");
	              }
	              
	              $('#postpone_planreason').change(function() {}).multipleSelect({ width: '100%', filter: true, minimumCountSelected: 1 });
	        	
	          },
	          complete:function() {
	        	  
	        	  $.ajax({
	    	    	  url: pathFixed+'dataloads/getPostponeReasonForSpanText?_=' + new Date().getTime(),
	    	    	  type: "POST",
	    	    	  data: {
	    	    		  'docx': query['rel']
	    	    	  },
	    	          success:function(resp) {	
	    	        	  if(resp.status) $('#ms_spanpostpone_planreason > span').text(resp.text);
	    	        	  
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
    	
	   var key = '', strict = !! argStrict;
	   if (strict) {
		    for (key in haystack) {
		      if (haystack[key] === needle) { return true; }
		    }
		    
	   } else {
		    for (key in haystack) {
		      if (haystack[key] == needle) { return true; }
		      
		    }
	   }

	   return false;
	   
	}
    
    /*
    $('textarea').each(function () { 
		h(this); 
	}).on('input', function () { 
		console.log(h(this));
		h(this); 
		
	});

    // Function
    function h(e) {
    	$(e).css({'height':'auto','overflow-y':'hidden'}).height(e.scrollHeight);
    }
   	*/
    
	
});