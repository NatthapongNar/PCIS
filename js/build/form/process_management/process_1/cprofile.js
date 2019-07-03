$(document).ready(function() {

    var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    var query  = getQueryParams(document.location.search);
    
    $('title').html('AP-P1 : ' + $('#owner').val());
       
    $.ajax({
    	
    	 url: pathFixed+'dataloads/stepper',
         type: "POST",
         data: {
        	 doc: query['rel']
         },
         success:function(data) {
        	 console.log(JSON.stringify(data));
 
         },
         cache: false,
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
    
    $("#back-top").hide();
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
    
    // Object Element
    var objbranch = $('#branchcode');
    var rmcode	  = $("#rmcode");
    var province  = $('#province');
    var district  = $('#district');
    var sel_group = $('#channelmode');
    var subgroup  = $('#channelmodule');
    var findemp   = $('#findEmp');
    var cri_reas  = $('#criteria_reason');
    var objCr_hid = $('#criteriareas_hidden');
    
    // Element div progressive
    var bn_progress = $('#bn_progress');
    var rm_progress	= $('#rmcode-progress');
    var bm_progress = $("#bm_progress");
    var dt_progress = $("#dt_progress");
    var pv_progress = $('#pv_progress');
    var ds_progress = $('#ds_progress');
    var ch_progress = $('#ch_progress');
    var ch_header_progress = $('#ch_header_progress');
    var cr_processs = $('#criteriareason_progress');
    
    bn_progress.hide();
    rm_progress.hide();
    bm_progress.hide();
    dt_progress.hide();
    pv_progress.hide();
    ds_progress.hide();
    ch_progress.hide();
    ch_header_progress.hide();
    cr_processs.hide();

    
    // Autoload 
    var bmData  = [];
    var BMTemp_list = [];
    $.ajax({
        //url: pathFixed+'dataloads/findEmployee',
    	url: pathFixed + 'dataloads/getBMList',
        type: "GET",
        beforeSend:function() { bm_progress.show(); },
        success:function(data) {

            var objData = [];
           
            for(var indexed in data['data']) {
                objData.push(data['data'][indexed]['FullNameTh']);
                BMTemp_list.push(data['data'][indexed]['FullNameTh']);
                
                var manager = data['data'][indexed]['EmployeeCode'] + ' (' + data['data'][indexed]['FullNameTh'] + ' - สาขา' + data['data'][indexed]['BranchName'] +')';
                bmData.push({ 'label': manager, 'value': data['data'][indexed]['EmployeeCode'] });
                
            }

            $('#bm').autocomplete({ source: objData });
            $('#assignname').autocomplete({ source: bmData });
   
        },
        complete:function() {
            bm_progress.after(function() {
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
        url: pathFixed+'dataloads/loadDowntown',
        type: "GET",
        beforeSend:function() {
        	dt_progress.show();
        },
        success:function(data) {

            var objData = [];
            for(var indexed in data['data']) {
                objData.push(data['data'][indexed]['Downtown']);
            }

            $('#downtown').autocomplete({ source: objData });

        },
        complete:function() {
        	dt_progress.after(function() {
                $(this).hide();
            });
        },
        cache: true,
        timeout: 50000,
        statusCode: {
	        404: function() {
	            alert( "page not found" );
	        },
	        407: function() {
	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
	        }
        }
    });
    
    $.ajax({
        url: pathFixed+'dataloads/dueCustomStatus',
        type: "GET",
        beforeSend:function() {
        	dt_progress.show();
        },
        success:function(responsed) {
        	var objDue 	 = $('select[name="duedatestatus"]');
        	var reasonid = $('#hide_reasonid').val();
        	var reason	 = $('#hide_reason');
        	
        	objDue.empty().first().append('<option value="N/A"> -- โปรดเลือก -- </option>');
            for(var indexed in responsed['data']) {
            	objDue.append("<option value='"+responsed['data'][indexed]['DueID']+"'>"+responsed['data'][indexed]['DueReason']+"</option>");
            	
            }
            
            objDue.last().append('<option value="0">อื่นๆ</option>');
            
            $('#duedatestatus').find('option[value="'+reasonid+'"]').attr('selected', "selected");

        },
        complete:function() {
        	dt_progress.after(function() {
                $(this).hide();
            });
        },
        cache: true,
        timeout: 5000,
        statusCode: {
	        404: function() {
	            alert( "page not found" );
	        },
	        407: function() {
	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
	        }
        }
    });
    
    // Combo AutoComplete
    objbranch.on('change', function() {

    	var branchcode = $('select[name="branchcode"] option:selected').val();
		
		$.ajax({
			url: pathFixed+'dataloads/areaInfo',
			type: "POST",
			data: { brn: branchcode },
	        beforeSend:function() {
	        	bn_progress.show();
	        },
	        success:function(data) {
	        	var region = $('#region');
	        	var branch = $('#branch');

	        	region.val(data['data'][0]['RegionNameEng']);
	        	branch.val(data['data'][0]['BranchName']);
   	
	        },
	        complete:function() {
	        	
	        	$.ajax({
	    			url: pathFixed+'dataloads/branchInfo',
	    			type: "POST",
	    			data: { brn: branchcode },
	    	        success:function(data) {

	    	        	var bmname = $('#bm');
	    	        	bmname.val(data['data']['BMName']);
	    	        	
	    	        },
	    	        complete:function() {
	    	        	bn_progress.after(function() {
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
    
    province.combobox({ 
		select: function (event, ui) { 
			
			var prnmap	= $("select[name='province'] option:selected").val();
			$.ajax({
				url: pathFixed+'dataloads/province?_=' + new Date().getTime(),
				type: "POST",
				data: { prn:prnmap },
				beforeSend:function() {
			        pv_progress.show();
			    },
				success:function(responsed) {
					district.empty().first().append('<option value="N/A"> -- โปรดเลือก -- </option>');
					for(var indexed in responsed['data']) {
						district.append("<option value='"+responsed['data'][indexed]['district']+"'>"+responsed['data'][indexed]['district']+"</option>");
					}
					
				},
				complete:function() {
					pv_progress.after(function() {
	                    $(this).hide();
	                });
			    },
				cache: false,
				timeout: 5000,
				statusCode: {
					404: function() {
						alert( "page not found" );
					},
			        407: function() {
			        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
			        }
				}
				
			});			
			
		}
	});
	
    district.on('change', function() {
		var district_map = $('select[name="district"] option:selected').val();
		$.ajax({
			url: pathFixed+'dataloads/country?_=' + new Date().getTime(),
			type: "POST",
			data: { dist:district_map },
			beforeSend:function() {
	        	ds_progress.show();
	        	
		    },
			success:function(responsed) {
				$('#postcode').val(responsed['data'][0]['postcode']);		
			},
			complete:function() {
				ds_progress.after(function() {
                    $(this).hide();
                });
				
		    },
			cache: true,
			timeout: 5000,
			statusCode: {
				404: function() {
					alert( "page not found" );
				},
		        407: function() {
		        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
		        }
			}
				
		});
	});
    
    var create_data = $('#createdate').val();
    var ch_url = (create_data > '17/01/2019') ? 'channeltypes' : 'channeltypesAll';
    var chsub_url = (create_data > '17/01/2019') ? 'channels' : 'channelsAll';
    
    $.ajax({
        url: pathFixed+'dataloads/' + ch_url,
        type: "GET",
        beforeSend:function() {
        	ch_header_progress.show();
        },
        success:function(data) {
        	sel_group.first().append('<option value="" selected>-- ช่องทาง --</option>');
            for(var indexed in data['data']) {
            	sel_group.append("<option value='"+data['data'][indexed]['Channel']+"'>"+data['data'][indexed]['Channel']+"</option>");
            }
            
            var chanel_group = $('#chanel_group').val();
            if(chanel_group && chanel_group !== '') {
            	sel_group.find('option[value="'+ chanel_group +'"]').attr('selected', 'selected');
            	
            	 $.ajax({
	   	    		  url: pathFixed+'dataloads/' + chsub_url + '?_=' + new Date().getTime(),
	   	    		  type: "POST",
	   	    		  data: { channeltypes: chanel_group },
	   	    		  beforeSend:function() {
	   	    			  ch_progress.show();
	   	    			  subgroup.empty();
	   	    		  },
	   	    		  success:function(data) {
	   	    			  	subgroup.first().append('<option value="" selected>-- ช่องทาง --</option>');
	   	    	          	for(var indexed in data['data']) {
	   	    	          		subgroup.append("<option value='"+data['data'][indexed]['SubChannel']+"'>"+data['data'][indexed]['SubChannel']+"</option>");
	   	    	          	}
	   	    	          
		   	    	        var chanel_sublist = $('#chanel_sublist').val();
			   	    	    if(chanel_sublist && chanel_sublist !== '') {
			   	    	    	subgroup.find('option[value="'+ chanel_sublist +'"]').attr('selected', 'selected');
			   	    	    }
	   	    	          
	   	    		  },
	   	    		  complete:function() {
	   						ch_progress.after(function() {
	   						     $(this).hide();
	   							 subgroup.prop('disabled', false);
	   							 subgroup.removeAttr('style');
	   						});
	   	    		  },
	   	    		  cache: true,
	   	    		  timeout: 5000,
	   	    		  statusCode: {
	   	    		      404: function() {console( "page not found" );},
	   	    		      407: function() {console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");}
	   	    		  }
	       		});
            	
            }

        },
        complete:function() {
        	ch_header_progress.after(function() { $(this).hide(); });
	    },
		cache: true,
        timeout: 5000,
        statusCode: {
            404: function() {
                alert( "page not found" );
            },
            407: function() {
            	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
	        }
        }
    });
    
    sel_group.on('change', function() {
    	 var selects = sel_group.val();
    	 if(selects && selects !== '') {
    	
			  $.ajax({
	    		  url: pathFixed+'dataloads/' + chsub_url + '?_=' + new Date().getTime(),
	    		  type: "POST",
	    		  data: { channeltypes: selects },
	    		  beforeSend:function() {
	    			  ch_progress.show();
	    			  subgroup.empty();
	    		  },
	    		  success:function(data) {
	    			  subgroup.first().append('<option value="" selected>-- ช่องทาง --</option>');
	    	          for(var indexed in data['data']) {
	    	        	  subgroup.append("<option value='"+data['data'][indexed]['SubChannel']+"'>"+data['data'][indexed]['SubChannel']+"</option>");
	    	          }
	    		  },
	    		  complete:function() {
						ch_progress.after(function() {
						     $(this).hide();
							 subgroup.prop('disabled', false);
							 subgroup.removeAttr('style');
						});
	    		  },
	    		  cache: true,
	    		  timeout: 5000,
	    		  statusCode: {
	    		      404: function() {console( "page not found" );},
	    		      407: function() {console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");}
	    		  }
    		});
    		 
    	 } else {
    		 subgroup.prop('disabled', true);
    		 subgroup.css({ 'background-color': '#EBEBE4', 'cursor': 'no-drop' });
    	 }
    })
   
    
    /*
    $.ajax({
        url: pathFixed+'dataloads/channels',
        type: "GET",
        beforeSend:function() {
        	ch_progress.show();
        },
        success:function(data) {
            for(var indexed in data['data']) {
                subgroup.append("<option value='"+data['data'][indexed]['SubChannel']+"'>"+data['data'][indexed]['SubChannel']+"</option>");
            }

        },
        complete:function() {
        	ch_progress.after(function() {
                $(this).hide();
            });
	    },
		cache: true,
        timeout: 5000,
        statusCode: {
            404: function() {
                alert( "page not found" );
            },
            407: function() {
            	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
	        }
        }
    });
    
    subgroup.on('change', function() {
        var selects = subgroup.val();
        if(selects != "") {

            $.ajax({
                url: pathFixed+'dataloads/channeltypes?_=' + new Date().getTime(),
                type: "POST",
                data: { channeltypes:selects },
                beforeSend:function() {
                	ch_progress.show();
                	
                },
                success:function(data) {
					$("#channel").val(data['data'][0]['Channel']);
					$("#channelmode").val(data['data'][0]['Channel']);

                },
                complete:function() {
                	ch_progress.after(function() {
                        $(this).hide();
                    });
        	    },
        		cache: true,
                timeout: 5000,
                statusCode: {
                    404: function() {
                        alert( "page not found" );
                    },
                    407: function() {
        	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
        	        }
                }
            });

        } else {
        	$("#channel").empty().val("").addClass('span4');
        }

    });
    */

    findemp.on('click', function() {
        $.ajax({
            url: pathFixed+'dataloads/empInfoInitialyze?_=' + new Date().getTime(),
            type: 'POST',
            data: {
                eidx: rmcode.val(),
                chc: true
            },
            beforeSend:function() {
                rm_progress.show();
            },
            success:function(data) {
            	var result = data['data'];
            	if(!data['status'] && data['oper'] == 'edit') {
            		$("#empname").val("");
					$("#rmmobile").val("");
            		//$("#rmvalidate").html(data['msg']).addClass("text-alert").fadeIn('slow');
					
					var not = $.Notify({ content: data['msg'], style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
            		
            	} else {
            		
            		if(data['status'] && data['oper'] == 'view') {
                        $("#rmvalidate").html('');
                        $('input[name="rmname"]').val(result[0]['FullnameTh']).slideDown();
                        $('#empname').val(result[0]['FullnameTh']);
						$("#rmmobile").val(result[0]['Mobile']);
                        $("#rmhidden").val(result[0]['FullnameTh']);
                        
            		} else {
            			$("#empname").val("");
						$("#rmmobile").val("");
            			//$("#rmvalidate").html(data['msg']).addClass("text-alert").fadeIn('slow');
						
						var not = $.Notify({ content: data['msg'], style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        				not.close(7000);
                        
                    }
            		
            	}
            	
            },
            complete:function() {
                rm_progress.after(function() {
                	var brncode = $('#branchcode').val();
                	callBMName(brncode);
                    $(this).hide();
                });
            },
            cache: true,
            timeout:5000,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                },
                407: function() {
    	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
    	        }
            }
        });
    
    });
    
    function callBMName(branchcode) {
    	console.log(branchcode);
    	if(branchcode) {
    		$.ajax({
    			url: pathFixed+'dataloads/branchInfo',
    			type: "POST",
    			data: { brn: branchcode },
    	        success:function(data) {
    	        	var bmname = $('#bm');
    	        	bmname.val(data['data']['BMName']);
    	        	
    	        },
    	        complete:function() {
    	        	bn_progress.after(function() {
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
    	}
    }
    
    // NEW Script 07/01/2015
    $.ajax({
        url: pathFixed+'dataloads/criteriaReasonList?_=' + new Date().getTime(),
        type: "GET",
        beforeSend:function() {
        	cr_processs.show();
        },
        success:function(data) {

        	 cri_reas.first().append('<option value="" selected>-- โปรดเลือก --</option>');
             for(var indexed in data['data']) {
            	 cri_reas.append("<option value='"+data['data'][indexed]['CriteriaReasonID']+"'>" + data['data'][indexed]['CriteriaReason']+ "</option>");
             }

             cri_reas.find('option[value="'+ objCr_hid.val() +'"]').attr('selected', 'selected');
            
        },
        complete:function() {
        	cr_processs.after(function() { $(this).hide(); });
        	
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
    
    if($('#sourceofcustomer').val() == 'Refer: Thai Life') {
    	setFieldReferralAutoCompleted('#referralcode', true);
    } else {
    	$('#referralcode').val("");
		$('#referralcode').attr('readonly', 'readonly').attr('style', 'background-color: #EBEBE4;');
    }
    

    //############# NEW HANDLED #############
    $('#sourceofcustomer').change(function() {
    	var select_source = $(this).val();    	
    	if(select_source == 'Refer: Thai Life') {
    		setFieldReferralAutoCompleted('#referralcode', true);
    	} else {
    		setFieldReferralAutoCompleted('#referralcode', false);
    	}
    	
    });
    
    var ref_source =  $('#sourceofcustomer').find('option:selected').val(); 
    if(ref_source == 'Refer: Thai Life') {
    	setFieldReferralAutoCompleted('#referralcode', true);
    }
        
    var ref_source =  $('#sourceofcustomer').find('option:selected').val(); 
    if(ref_source == 'Refer: Thai Life') {
    	setFieldReferralAutoCompleted('#referralcode', true);
    }
    
    //############# NEW IMPLEMENT ###########
    function setFieldReferralAutoCompleted(element, enabled) {
    	
    	if(enabled) {
    		
    		$.ajax({
                url: pathFixed + 'dataloads/getTLADataDetail',
                type: "GET",
                success:function(data) {
                	
                    var objData = [];
                    for(var indexed in data['data']) {
                    	var concat_name = data['data'][indexed]['TLA_Code'] + ' (' + data['data'][indexed]['TLA_Name'] + ' - ' + data['data'][indexed]['TLA_BranchName'] +')';
                        objData.push({ 'label': concat_name, 'value': data['data'][indexed]['TLA_Code'] });
                    }

                    $(element).autocomplete({ source: objData });
      
					
                },
                complete:function() {
                	$(element).removeAttr('readonly').removeAttr('style');
                },
                cache: true,
                timeout: 5000,
                statusCode: {
        	        404: function() {
        	            alert( "page not found" );
        	        },
        	        407: function() {
        	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
        	        }
                }
            });
    		
    	} else {
    		$(element).va("");
    		$(element).attr('readonly', 'readonly').attr('style', 'background-color: #EBEBE4;');
    	}
    	
    }
    
    // Combo AutoComplete
	$('#assign_case').on('click', function() {
		var assign_case = $(this).is(':checked');
		if(assign_case) {
			var branch_code = $('#branchcode').val();
			$('#assignname').prop('disabled', false).css('background', '#FFFFFF');
			loadBranchManagerInfo('#assignname', branch_code, 'BM');
		} else {
			$('#assignname').prop('disabled', true).css('background', '#EBEBE4');
			$('#assignname').val('');
			$('#assignname_label').text('');
		}
		
	});
    
    $('#assignname').on('change', function () {
    	console.log(bmData);
    	var empcode = parseInt(this.value);
    	var name = $.map(bmData, function(data) {
    		if(data.value === empcode) { return data.label; }
    		else { return null; }
		});
    
    	var strname = (name[0]) ? (name[0].substring(5)).replace('สาขา',''):'';
    	$('#assignname_label').text(strname);	
    	
    });
    
    $('#assignname').on('blur', function() {
    	var empcode = parseInt(this.value);
    	var varify  = [];
    	var name = $.map(bmData, function(data) {
    		if(data.value === empcode) { varify.push('TRUE');}
    		else { varify.push('FALSE'); }
		});
    	
    	if(!in_array('TRUE', varify)) {
    		$('#assign_case').prop('checked', false);
    		$('#assignname').val('');
    		$('#assignname_label').text('');	
    		
    		var not = $.Notify({ content: "didn't match any item", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);
    		
    	}
    	
    });
    
    setTimeout(function() {
    	var assignname = $('#assignname').val();
	    if(assignname !== "") {
	    	
	   	   $('#assignname').prop('disabled', false).css('background', '#FFFFFF');
	   	   var name = $.map(bmData, function(data) {
	   		  if(data.value ===  parseInt(assignname)) { return data.label; }
	   		  else { return null; }
		   });

	   	   var strname = (name[0]) ? (name[0].substring(5)).replace('สาขา',''):'';
	   	   $('#assignname_label').text(strname);	
	    }
    }, 3000);
   
       
    function loadBranchManagerInfo(element, branchcode, source_channel) {
    	var module  = (source_channel == 'BM') ? 'loadBranchManagerList':'getRMListBoundaryOnly';    	
    	var path 	= pathFixed + 'dataloads/' + module;
    	
    	$.ajax({
            url: path,
            type: "POST",
            data: { 
            	brnx: $('#branchcode').val(),
            	branchcode: [$('#branchcode').val()],
            	source: source_channel
            },    	
            success:function(responsed) {

            	if(responsed.manager) {
            	
            		if(source_channel == 'BM') {            		
            			var branch_name = (responsed.manager.BMName !== '') ? ($('#branch').val()).replace('สาขา',''):'';
            			$('#assignname').val(responsed.manager.BMCode);
            			$('#assignname_label').text('(' + responsed.manager.BMName + ' - ' + branch_name + ')');
            			/*
            			$('#refer_bm').val(responsed.manager.BMName);
                		$('#refer_bmcode').val(responsed.manager.BMCode);  
                		$('#refer_emp').text('Refer by BM');
                		
                		if($('#refer_bm').hasClass('ui-autocomplete-input')) {
           			       $('#refer_bm').autocomplete("destroy");
           			       $('#refer_bm').autocomplete({ source: BMTemp_list });
                       	}
                		*/
            		} 
            		/*
            		else {
            			var rmcode = $('#rmcode').val();
            			var rmname = $('#empname').val();
            			$('#refer_bm').val(rmname);
                		$('#refer_bmcode').val(rmcode);  
                		$('#refer_emp').text('Refer by RM');                		
            		}
            		*/
            	} 
            	/*
            	else {
            		
            		if(responsed.data[0] !== undefined && responsed.data.length > 0) {
            			
            			var objData = [];
        	            for(var indexed in responsed.data) {
        	                objData.push(responsed.data[indexed]['FullNameTh']);
        	            }
            			
        			    if($('#refer_bm').hasClass('ui-autocomplete-input')) {
        			       $('#refer_bm').autocomplete("destroy");
        			       $('#refer_bm').autocomplete({ source: objData });
                    	}
            			            			
            			var rmcode = $('#rmcode').val();
            			var rmname = $('#empname').val();
            			$('#refer_bm').val(rmname);
                		$('#refer_bmcode').val(rmcode);  
                		$('#refer_emp').text('Refer by RM');    
                		
            		} else {
            			$('#refer_bm').val('');
                		$('#refer_bmcode').val('');   
                		//$('#refer_bm_alert').text('');
            		}
            	           		
            	}
				*/
            	
            },
            complete:function() {},
            cache: true,
            timeout: 10000,
            statusCode: {
    	        404: function() { console.log( "page not found" ); }
            }
        });
    	
    }
    
    function switchSourceType(sourceData) {
    	if(sourceData) {
    		switch(sourceData) {
	    		case 'Refer: RM':
	    			return 'RM'
	    		break;
	    		case 'Refer: BM':
	    		default:
	    			return 'BM'
	    		break;
	    	}
    	}
    	
    }
    
    function in_array(needle, haystack, argStrict) {

		var key = '', strict = !! argStrict;

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