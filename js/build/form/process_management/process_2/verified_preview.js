$(function() {
	
		var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
		var pathFixed = window.location.protocol + "//" + window.location.host;
		var rootFixed = window.location.protocol + "//" + window.location.host + '/pcis';
		for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
		for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
		var query  = getQueryParams(document.location.search);
		
		$('title').html('AP-P2 : ' + $('#borrowername_title').val());
		
		// set default zoom	
		switch (getZoom()) {
		case '1.0':
			$('body').css('zoom', '0.9');
			break;
		case '0.9':
			$('body').css('zoom', '1.0');
			break;
		case '0.8':
			$('body').css('zoom', '1.1');
			break;
		case '0.7':
			$('body').css('zoom', '1.33');
			break;
		default:
			break;
		}

 	    $("#appProgress ul li:first-child").append('<div class="text-muted" style="min-width: 150px; margin-top: 2em; margin-left: -1em;">PROFILE</div>');
	    $("#appProgress ul li:nth-child(2)").append('<div class="text-muted" style="min-width: 180px; margin-top: 2em; margin-left: -2.5em;">VERIFICATION</div>');
	    $("#appProgress ul li:nth-child(3)").append('<div class="text-muted" style="min-width: 250px; margin-top: 2em; margin-left: -4.2em;">APPLICATION STATUS</div>');
		    
	    $("#appProgress ul li:first-child").on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P1&live=2&wrap=' + new Date().getTime(); });
	    $("#appProgress ul li:nth-child(2)").on('click', function() { document.location.href = pathFixed + 'management/getDataVerifiedManagement?mod=1' + '&rel=' + query['rel'] + '&req=P2&live=2&wrap=' + new Date().getTime(); });
	    $("#appProgress ul li:nth-child(3)").on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P3&live=2&wrap=' + new Date().getTime(); });
	    
	    $("#appProgressHistory ul li:first-child").append('<div class="text-muted" style="min-width: 150px; margin-top: 2em; margin-left: -1em;">PROFILE</div>');
	    $("#appProgressHistory ul li:nth-child(2)").append('<div class="text-muted" style="min-width: 180px; margin-top: 2em; margin-left: -2.5em;">VERIFICATION</div>');
	    $("#appProgressHistory ul li:nth-child(3)").append('<div class="text-muted" style="min-width: 250px; margin-top: 2em; margin-left: -4.2em;">APPLICATION STATUS</div>');
	    
	    $("#appProgressHistory ul li:first-child").on('click', function() { document.location.href = pathFixed + 'metro/getProfileInRetrieve?mod=1' + '&rel=' + query['rel'] + '&req=P1&live=1&wrap=' + new Date().getTime(); });
	    $("#appProgressHistory ul li:nth-child(2)").on('click', function() { document.location.href = pathFixed + 'management/getDataVerificationInRetrieve?mod=1' + '&rel=' + query['rel'] + '&req=P2&live=1&wrap=' + new Date().getTime(); });
	    $("#appProgressHistory ul li:nth-child(3)").on('click', function() { document.location.href = pathFixed + 'metro/getApplicationDecisionInRetrieve?mod=1' + '&rel=' + query['rel'] + '&req=P3&live=1&wrap=' + new Date().getTime(); });
	   
	    var not = $.Notify({ content: "Preview Mode.", style: { background: '#666666', color: '#FFFFFF' }, timeout: 10000 });
	    not.close(7000);
	   
	    // VIEWER LOGGER
	    $('#NCBConsentLogs').on('click', function() {
	    	 $.Dialog({
	    		 overlay: true,
	    		 shadow: true,
	    		 draggable: true,
	    		 icon: '<i class="fa fa-tablet"></i>',
	    		 content: '',
	    		 padding: 10,
	    		 width: 1300,
	    		 height: 570,
	    		 onShow: function(_dialog){
	    			 
	    			 var content = '<header class="span12" style="margin-top: 10px;"><h6>NCB Consent Logs</h6></header>';
	    			 content += '<div id="ncb_progress_logs"><img src="' + rootFixed + '/img/ajax-loader.gif"> Loading...</div>';
	    			 content += '<section class="form_container span12 text-center" style="height: 500px; min-width: 1300px; margin-top: -10px; font-size: 0.9em; display: block; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">'+
	                 '<table id="NCBConsentLogs_Modal" style="min-width: 1260px;">'+
		                 '<thead>'+
		                     '<tr>'+
		                     	 '<th align="center">TYPE</th>'+
			                     '<th align="center">NAME - SURNAME</th>'+
		                         '<th align="center">NCB</th>'+
		                         '<th align="center">NCB DATE</th>'+
		                         '<th align="center">LB <i class="fa fa-arrow-right on-right on-left"></i> HQ</th>'+
		                         '<th align="center"><i class="fa fa-inbox on-left"></i> HQ RECEIVED</th>'+
		                         '<th align="center" colspan="2">HQ <i class="fa fa-arrow-right on-right on-left"></i> OPER</th>'+
		                         '<th align="center" colspan="2"><i class="fa fa-arrow-left on-left"></i>OPER RETURN</th>'+	                  
		                     '</tr>'+
		                 '</thead>'+
		                 '<tbody></tbody>'+
		              '</table>'+
		             '</section>';
	    			
	    			 
	    			 $('#ncb_progress_logs').show();
	    			 $.ajax({
			   	    	  url: pathFixed+'dataloads/getNCBConsentLogs?_=' + new Date().getTime(),
			   	    	  type: "POST",
			   	          data: {
			   	          	 relx: query['rel']
			   	          },
			   	          beforeSend:function() {
			   	        	  $('#ncb_progress_logs').show();
			   	          },
			   	          success:function(data) {

			   	        	for(var indexed in data['data']) {
			   	        	
			   	        		$('#NCBConsentLogs_Modal').fadeIn("slow", function() {
				   	        		$('#NCBConsentLogs_Modal > tbody').append(
				   	        			'<tr '+ data['data'][indexed]['BDR'] +'>' + 
				   	        				'<td>'+ data['data'][indexed]['BRT'] +'</td>'+
				   	        				'<td>'+ data['data'][indexed]['BRN']  +'</td>'+
				   	        				'<td>'+ data['data'][indexed]['NCK'] +'</td>'+
				   	        				'<td>'+ data['data'][indexed]['NCD'] +'</td>'+
				   	        				'<td>'+ data['data'][indexed]['SHQ'] +'</td>'+
				   	        				'<td>'+ data['data'][indexed]['RLB'] +'</td>'+
				   	        				'<td>'+ data['data'][indexed]['STO'] +'</td>'+
				   	        				'<td style="text-align: left;">'+ '-' +'</td>'+		
				   	        				'<td>'+ data['data'][indexed]['ORD'] +'</td>'+
				   	        				'<td style="text-align: left;">'+ data['data'][indexed]['CRB']  +'</td>'+
				   	        			'</tr>'	
				   	        		);
				   	        	});
			   	        		
			   	            }
			   	        	  
			   	        	
			   	        	  
			   	          },
			   	          complete:function() {
			   	        	$('#ncb_progress_logs').hide();
			   	        	$('#NCBConsentLogs_Modal > tbody td').css('padding-left', '3px').css('padding-bottom', '7px');
			   	        	
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
	    					
	    			$.Dialog.title("NCB CONSENT LOGS");
	    			$.Dialog.content(content);
	    			
	    		 }
	    	 });
	    });
	    
	    $('#RelationLogs').on('click', function() {
	      	 $.Dialog({
	      		 overlay: true,
	      		 shadow: true,
	      		 draggable: true,
	      		 icon: '<i class="fa fa-tablet"></i>',
	      		 content: '',
	      		 padding: 10,
	      		 width: 1300,
	      		 height: 570,
	      		 onShow: function(_dialog){
	      			 
	      			 var content = '<header class="span12" style="margin-top: 10px;"><h6>Document Flow Logs</h6></header>';
	      			 content += '<div id="relation_progress_logs"><img src="' + rootFixed + '/img/ajax-loader.gif"> Loading...</div>'; 
	      			 content += '<section class="form_container span12" style="height: 500px; min-width: 1300px; margin-top: -10px; font-size: 0.9em; display: block; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">'+
	                '<table id="Reconcile_Modal" style="min-width: 1260px;" data-spy="scroll" data-target=".ncb_tbody">'+
	                    '<thead>'+
	                        '<tr>'+
	                            '<th align="left" style="width: 20em;">NAME - SURNAME</th>'+
	                            '<th align="center">TYPE</th>'+
	                            '<th align="left" style="width: 5em;">LOGISTICS</th>'+
	                            '<th>LB <i class="fa fa-arrow-right on-right on-left"></i> HQ</th>'+
	                            '<th align="left"><i class="fa fa-inbox on-left"></i> HQ RECEIVED</th>'+
	                            '<th align="left">COMPLETION</th>'+
	                            '<th align="left" colspan="2">HQ <i class="fa fa-arrow-right on-right on-left"></i> CA</th>'+
	                            '<th align="left" colspan="2"><i class="fa fa-arrow-left on-left"></i> CA RETRUN</th>'+
	                        '</tr>'+
	                    '</thead>'+
	                    '<tbody class="ncb_tbody"></tbody>'+
	                '</table>'+
	                '</section>';
	      			 
	      			$('#relation_progress_logs').show();
	      			$.ajax({
	   	   	    	  url: pathFixed+'dataloads/getReconcileDocLogs?_=' + new Date().getTime(),
	   	   	    	  type: "POST",
	   	   	          data: {
	   	   	          	 relx: query['rel']
	   	   	          },
	   	   	          beforeSend:function() {
	   	   	        	  $('#relation_progress_logs').show();
	   	   	          },
	   	   	          success:function(data) {

	   	   	        	for(var indexed in data['data']) {
	   	   	        	
	   	   	        		$('#Reconcile_Modal').fadeIn("slow", function() {
	   		   	        		$('#Reconcile_Modal > tbody').append(
	   		   	        			'<tr '+ data['data'][indexed]['BDR'] +'>' + 
	   		   	        				'<td style="text-align: left;">'+ data['data'][indexed]['BRN'] +'</td>'+
	   		   	        				'<td>'+ data['data'][indexed]['BRT'] +'</td>'+
	   		   	        				'<td>'+ data['data'][indexed]['LGC'] +'</td>'+
	   		   	        				'<td>'+ data['data'][indexed]['STH'] +'</td>'+
	   		   	        				'<td>'+ data['data'][indexed]['RFB'] +'</td>'+
	   		   	        				'<td>'+ data['data'][indexed]['CPL'] +'</td>'+
	   		   	        				'<td>'+ data['data'][indexed]['ATA'] +'</td>'+
	   		   	        				'<td style="text-align: left;">'+ ' - ' +'</td>'+
	   		   	        				'<td>'+ data['data'][indexed]['CAD'] +'</td>'+
	   		   	        				'<td style="text-align: left;">'+ data['data'][indexed]['CRB']  +'</td>'+		   	        				
	   		   	        			'</tr>'	
	   		   	        		);
	   		   	        	});
	   	   	        		
	   	   	            }
	   	   	        	  
 
	   	   	          },
	   	   	          complete:function() {
	   	   	        	$('#relation_progress_logs').hide();
	   	   	        	$('#Reconcile_Modal > tbody td').css('padding-left', '3px').css('padding-bottom', '7px');
	   	   	        	
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
	      			 
	      			 $.Dialog.title("DOCUMENT FLOW LOGS");
	      			 $.Dialog.content(content);
	      		 }
	      	 });
	    });
	    
	    var d = new Date();
	    var n = d.getTime();

	    var main_enabled = true;
	    var prev_enabled = true;
	    var edit_enabled = true;
	    var save_enabled = true;
	    
	    var prev_additional	= '';
	    var edit_additional	= '';
	    
		var hint_main		= 'กลับหน้าหลัก';
		var hint_prev		= 'แสดงรายละเอียดข้อมูล';
		var hint_edit		= 'แก้ไขข้อมูล';
		var hint_save		= 'บันทึกข้อมูล';

	    switch (pathArray[4]) {	
			case 'getDataVerifiedPreview':
				
				main_enabled = true;
				prev_enabled = false;
				edit_enabled = true;
				save_enabled = false;
				
				prev_additional	= 'fa-ban fa-stack-2x';
				edit_additional	= '';
				
			break;

	    }

	    // Initialize Share-Buttons
	    $.contactButtons({
		      effect  : 'slide-on-scroll',
		      buttons : {
		    	   'Main': { class: 'facebook fg-white', use: main_enabled, icon: 'home', hint: hint_main, link: pathFixed + 'metro/appProgress' },
		    	   'Preview': { class: 'linkedin fg-white', use: prev_enabled, icon: 'ban', hint: hint_prev, iopt: prev_additional, link: '#' },
		    	   'Edit': { class: 'gplus fg-white', use: edit_enabled, icon: 'edit', hint: hint_edit, iopt: edit_additional, link: pathFixed + 'management/getDataVerifiedManagement?_=' + n + '&rel=' + query['rel'] + '&req=P2&live=2&wrap=' + new Date().getTime(), extras: 'style="margin-top: 3px !important;"' },
		    	   'Save':{ class: 'git fg-white', use: save_enabled, icon: 'save', hint: hint_save, link: '#', extras: 'id="submitVerificationForm"' }
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
	    
	    //var defend_tooltip = $('#defend_icon_history');
	    var rmlist_tooltip = $('#RmProcessReasonLogs');
	    
	    //defend_tooltip.hide();
	    
	   // if($('#defend_date_disbled').val() != "") {
	   // 	defend_tooltip.show();
	   // }
	    
	    /*
	    defend_tooltip.hover(function() {
	    	var listContent = $('#objDefendReason').html();												
			$(this).webuiPopover({
				trigger:'click',	
				padding: true,
				content: listContent,
				backdrop: false
			});
	    });
	    */
	    
	    rmlist_tooltip.hover(function() {
	    	
	    	var listContent = $('#objRMProcessListBox').html();	    	
			$(this).webuiPopover({
				trigger:'click',	
				padding: true,
				content: listContent,
				backdrop: false
			});
			
	    });
	    
	    $('#retrieve_tooltip').hover(function() {
	    	
	    	var listContent = $('#retrieve_contents').html();	    	
			$(this).webuiPopover({
				trigger:'click',	
				padding: true,
				content: listContent,
				backdrop: false
			});
			
	    });	   
	    
	    $('#PlanA2CAReasonLogs').hover(function() {
	    	
	    	var listContent = $('#plan_a2ca_area').html();	    	
			$(this).webuiPopover({
				trigger:'click',	
				padding: true,
				content: listContent,
				backdrop: false
			});
			
	    });	 
	    
	    $('#ReActivatedReasonLogs').hover(function() {
	    	
	    	var listContent = $('#reactivate_parent_reason').html();	    	
			$(this).webuiPopover({
				trigger:'click',	
				padding: true,
				content: listContent,
				backdrop: false
			});
			
	    });	   
	    
	    /*
	    // Link to notepad for defend management (minimize)
	    $("#defense_OptionNote").on('click', function(){
	     	
	 		$.Dialog({
	 			overlay: true,
	 			shadow: true,
	 			flat: false,
	 			icon: '<i class="fa fa-comment"></a>',
	 			title: 'Defend Note',
	 			content: '',
	 			height: '600px',
	 			width: '90%',
	 			padding: 10,
	 			onShow: function(_dialog){
	 				//loadSFEOnDefendPages
	 				var html = '<iframe src="' + pathFixed + 'defend_control/getIssueReasonList?rel='+ query['rel'] +'&lnx='+ $('#defend_no').val() +'&whip=false&enable=false&editor=false" width="100%" style="height: 600px; border: 0px;"></iframe>';
	 				$.Dialog.content(html);
	 				
	 			}	 			
	 		});
	 		
	    });
	    */

	    // Function
	    loadDefendCreateHistory();
	    
	    $('#defend_icon_history').hover(function() {
	    	var listContent = $('#objDefendReasonPreview').html();	
	    	
			$(this).webuiPopover({
				trigger:'click',	
				padding: true,
				content: listContent,
				backdrop: false
			});
	    });
	    
	    function loadDefendCreateHistory() {
			var documnet_id	  = $('#DocID').val();
			$.ajax({
				url: pathFixed + 'dataloads/loadDefendList?_=' + new Date().getTime(),
				type: 'POST',
				data: { doc_id: documnet_id },
				success:function(resp) {				
					if(resp['status']) {  	  
						var responsed = resp.data;
				
						var date_list = [];
						_.each(responsed, function(data) { date_list.push(data.CreateDate); });
							
						var data_list = [];
						if(date_list && date_list.length > 0) {
							var uniq_content = _.uniq(date_list);	
							_.each(uniq_content,  function(data) {
								var findData = _.filter(responsed, { CreateDate: data });
								data_list.push({ CreateDate: data, List: findData });							
							});						
						}
						
						if(data_list && data_list.length > 0) {
							generateDefaultListLog(data_list);
						}					
							                    		
					}				
				},
				complete:function() {
					$('#defend_otherlist').hide();  	
				},
				cache: false,
				timeout: 5000,
				statusCode: {}
			});
		}
	    
	    function generateListLog(str_actor, str_date, list) {
			if(list && list.length > 0) {
				var topic_name = '';
				$.each(list, function(index, str) { topic_name += (index + 1) + '. ' + str + '<br />' });
			
				if(topic_name && topic_name !== '') {					
					$('#objDefendReasonPreview').find('tbody').append(
						'<tr>' + 
							'<td style="padding-top:0px !important;">' + str_date + '</td>' +
							'<td style="padding-top:0px !important;">' + str_actor + '</td>' +
							'<td style="padding-top:0px !important;text-align: left;">' + topic_name + '</td>' +
						'</tr>'
					);
				}

			}
			
		}
	    

		function generateDefaultListLog(list) {
			if(list && list.length > 0) {					
				_.each(list, function(data) { 
					var create_date = data.CreateDate;
					
					var listData = '';
					var nameData = '';
					if(data.List && data.List.length > 0) {
						listData = _.map(data.List, function(objData) { return (objData.DefendReason) ? objData.DefendReason:''; });
						nameData = _.map(data.List, function(objData) { return (objData.CreateName) ? objData.CreateName:''; })
					}
					
					if(listData && listData.length > 0) {
						var actor_name = (nameData && nameData.length > 0) ? _.uniq(nameData).toString():'-';
						var topic_reason = '';
						_.map(listData, function(str, index) { topic_reason += (index + 1) + '. ' + str + '<br/>' });
		
						if(topic_reason && topic_reason !== '') {
							$('#defend_logs > tbody').append(
								'<tr>' + 
									'<td>' + create_date + '</td>' +
									'<td style="text-align: left;">' + actor_name + '</td>' +
									'<td style="text-align: left;">' + topic_reason + '</td>' +
								'</tr>'
							);
						}
						
					}

				});
				
			}
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
	    
	    function getZoom(){ 

		    var ovflwTmp = $('html').css('overflow');
		    $('html').css('overflow','scroll');

		    var viewportwidth;  
		    // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight 
		    if (typeof window.innerWidth != 'undefined')  {
		        viewportwidth = window.innerWidth;
		    } else if (typeof(document.documentElement) != 'undefined'  && 
		        typeof document.documentElement.clientWidth != 'undefined' && 
		        document.documentElement.clientWidth != 0) {
		        // IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document) 
		        viewportwidth = document.documentElement.clientWidth; 
		    } else { 
		        // older versions of IE 
		        viewportwidth = document.getElementsByTagName('body')[0].clientWidth; 
		    }

		    var windW = $(window).width();  
		    var scrollBarW = viewportwidth - windW; 

		    if(!scrollBarW) return 1;

		    $('html').css('overflow',ovflwTmp);

		    return  (15 / scrollBarW).toFixed(1); 
		}
	   
});