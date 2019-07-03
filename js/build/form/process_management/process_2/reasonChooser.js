 $(document).ready(function () {
	 
	 var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
	 var pathFixed = window.location.protocol + "//" + window.location.host;
	 for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
	 for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
	 var query  = getQueryParams(document.location.search);

	 
	 // Object Date
     var str_date;
     var objDate = new Date();
     str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear(); // Set Date format DD/MM/YYYY

     // refresh spin icon
     $('#ca_refresh').on('mouseover', function() { $(this).addClass('fa-spin'); }).on('mouseout', function() { $(this).removeClass('fa-spin'); });
     
     // onload reason list and reload    
     $('#ca_refresh').click(function() { getCAReturnReasonList(); });   
     
     // Auto Increment List
     var max_fields      = 5; //maximum input boxes allowed
     var wrapper         = $(".input_cafields_wrap"); //Fields wrapper
     var add_button      = $(".add_cafield_button"); //Add button ID
     
     var x = 1;
     $(add_button).click(function(e){ 
         e.preventDefault();
         if(x < max_fields){ 
             x++; 
             
             $(wrapper).append(
             	'<div class="input-control text">' +
             		'<label class="label label-clear ">อื่นๆ : </label>' +
 					' <input name="careturn_topiclist[]" type="text" value="" class="size4">' +
             		'<i class="fa fa-close fg-red marginTop5 remove_cafield" style="font-size: 1.5em !important; position: absolute; margin-top: 5px; margin-left: 10px;"></i>' +    
             	'</div>'
             ); 
         }
     });
     
     $(wrapper).on("click",".remove_cafield", function(e){ //user click on remove text
         e.preventDefault(); $(this).parent('div').remove(); x--;
     })
     
     
	 $('#confirmReturnReason').on('click', function() {		
		
		var ca_fieldlist    = $('input[name$="careturn_fieldcode[]"]:checked').map(function() {return $(this).val();}).get();
		var ca_topiclist 	= $('input[name$="careturn_topiclist[]"]').map(function() {return $(this).val();}).get();
		var rec_elementid	= $('#reconcileBundledID').val();
		
		if(ca_fieldlist[0] == undefined && ca_topiclist == "") {
			var not = $.Notify({ content: 'กรุณาเลือกรายการอย่างน้อย 1 รายการ.', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
			not.close(7000); 
			
			return false;
			
		} else {
			
			$('#reconcile_id_bundled_' + rec_elementid).val(rec_elementid);
			$('#creditreturn_list_bundled_' + rec_elementid).val(ca_fieldlist);
			$('#creditreturn_otherlist_bundled_' + rec_elementid).val(ca_topiclist);
		
			$('#careturnReasonModal').modal('hide');	

		}		
		
	});
	
	$('#cancelReturnReason').on('click', function() {
		
		var id 				= $('#rollbackBundledID').val();
		var bundled 		= $('#rollbackElement').val();		
		var doc2ca			= $('#Relation_SubmitToCAHide_' + id).val();
		var rec_elementid	= $('#reconcileBundledID').val();
		var ca_fieldlist    = $('input[name^="creditreturn_list_bundle"]').map(function() {return $(this).val();}).get();
	
		// set credit return
		$('#reconcile_id_bundled_' + rec_elementid).val('');
		$('#creditreturn_list_bundled_' + rec_elementid).val('');
		$('#creditreturn_otherlist_bundled_' + rec_elementid).val('');
	
		$('#Relation_SubmitToCA_' + id).val(str_date);
		$('#Relation_SubmitToCAHide_' + id).val(str_date);
	
		var i = 0;
		var value_state = [];
		$('input[name^="creditreturn_list_bundle"]').each(function() {
			
			if(ca_fieldlist[i] != "") value_state.push('TRUE');
			else value_state.push('FALSE');
	
			i++;
			
		});
		
		if(in_array("TRUE", value_state)) $('#checkCreditReturn').val('Y');			
		else $('#checkCreditReturn').val('N');
				
		$('#careturnReasonModal').modal('hide');	
		
		// set document completion
		$('#RELLogistic_hidden_' + id).val('');
		$('#RELBorrowerType_hidden_' + id).val('');
		$('#RELBorrowerName_hidden_' + id).val('');
		$('#RELLBToHQ_hidden_' + id).val('');
		$('#RELHQReceived_hidden_' + id).val('');
		$('#RELCompletion_hidden_' + id).val('');
		$('#RELHQToCA_hidden_' + id).val('');
		$('#RELRETurn_hidden_' + id).val('');
		
		if(doc2ca !== '') $('#HCA_click_' + id).prop('checked', true);
		else $('#HCA_click_' + id).prop('checked', false);
		
		$('#Relation_SubmitToCA_' + id).val(doc2ca);
		$('#CAR_click_' + id).prop('checked', false);
		$('#Relation_CAReturn_' + id).val('');
		
		returnDateRecovery(id);
		      
	});
	
	function returnDateRecovery(id) {
		  var is_reset  = $('#Relation_CAReturn_' + id).val();
		  var temp_text = $('#Relation_CAReturnOrgin_' + id).val();
		  console.log([id, is_reset, temp_text, (is_reset === undefined)]);
	  	  if(is_reset === '') $('#remode_' + id).text(temp_text);
	
	}
	
	function getCAReturnReasonList() {
		
		$.ajax({
	    	  url: pathFixed+'dataloads/getDefendType?_=' + new Date().getTime(),
	    	  type: "POST",
	    	  data: { dftype: '' },
	          beforeSend:function() {
	        	
	          },
	          success:function(data) {
	              
		          $('div#careturn_content').html('');  	        	 
		          for(var indexed in data['data']) {
		        	  
		        	  var margin;
	  	        	  if(indexed == 0) margin = 'style="min-width: 1150px; margin-top: -20px !important;"';
		        	  
		        	  $('div#careturn_content').append(
		        			 '<div class="panel" ' + margin + '>' +
							   '<div class="panel-header panel-header-custom bg-lightBlue fg-white text-left" style="font-size: 1.2em; font-weight: bold; min-height: 37px !important; max-height: 37px !important; vetical-text: top; padding-bottom: 2px !important;">' +
							   		data['data'][indexed]['MDefendSubject'] +
							    '</div>' +
							    '<div class="row panel-content" data-core="' + data['data'][indexed]['MDefendCode'] + '"></div>' +
							'</div>'
		        	  );
		     
		          }
  
	          },
	          complete:function() {
	        	  
	        	$('div#careturn_content').find('div.panel-header').truncate({
	                width: '470',
	                token: '…',
	                side: 'right',
	                addtitle: true
	         	});
	        	
	        	
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
			            	  
			            	  $('div#careturn_content')
			            	  .find('div[data-core="' + data['data'][indexed]['DefendType'] + '"]')
			            	  .append(
			            			'<div class="careturn_sublist span3 text-left" ' + margin + '>' +
			            				'<div class="input-control checkbox">' +
			            					'<label>' +
			            						'<input id="careturn_code_' + indexed + '" name="careturn_fieldcode[]" type="checkbox" value="' + data['data'][indexed]['DefendCode'] + '">' +
			            						'<span class="check"></span>' +
			            						'<span class="careturnlist_text" style="font-weight: normal;">' + data['data'][indexed]['DefendReason'] + '</span>' +
			            					'</label>' +
			            				'</div>' +
			            			'</div>'
			            	  );
			            	  
			              }   
			              
			              $('input[name^="careturn_fieldcode"]').on('click', function() {
				            	
		  			       	   var other_field = $('input[name$="careturn_fieldcode[]"]:checked').map(function() {return $(this).val();}).get();
		  			       	   if(in_array("OT099", other_field)) {
		  			       		   $('#careturn_otherarea').show();
		  			       	   } else {
		  			       		   $('#careturn_otherarea').hide();		   
		  			       	   }
	 			       	   
	 			          });
				                
			                
		   	          },
		   	          complete:function() {
		   	        	
		   	        	$('div.careturn_sublist').find('span.careturnlist_text').truncate({
		                     width: '400',
		                     token: '…',
		                     side: 'right',
		                     addtitle: true
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