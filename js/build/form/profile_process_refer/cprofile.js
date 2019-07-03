$(document).ready(function() {

	var pathRoot  = window.location.protocol + "//" + window.location.host;
    var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    
    $('title').html('PCIS - ' + pathArray[4].toUpperCase());
    $('#fttab').css('margin-left', '60px');
	
    $(".stepper ul li:first-child").append('<a href="'+pathFixed+'metro/createprofile"><div class="text-info" style="min-width: 150px; margin-top: 2em; margin-left: -1em;">PROFILE</div></a>');
    $(".stepper ul li:nth-child(2)").append('<div class="text-muted" style="min-width: 180px; margin-top: 2em; margin-left: -2.5em;">VERIFICATION</div>');
    $(".stepper ul li:nth-child(3)").append('<div class="text-muted" style="min-width: 250px; margin-top: 2em; margin-left: -4.2em;">APPLICATION STATUS</div>');
    
    $(".stepper ul li:first-child").on('click', function() { document.location.href = pathFixed+'metro/createprofile'; });
    $(".stepper ul li:nth-child(2)").on('click', function() { 
    	
    	 var not = $.Notify({
    		 content: "ท่านยังไม่สามารถทำกระบวนการถัดไปได้ โปรดสร้างข้อมูลในกระบวนการนี้ให้สมบูรณ์",
    		 timeout: 10000
    	 });
    	
    	not.close(7000);
    	
    });
    
    $(".stepper ul li:nth-child(3)").on('click', function() { 
    	
    	 var not = $.Notify({
    		 content: "ท่านยังไม่สามารถทำกระบวนการถัดไปได้ โปรดสร้างข้อมูลในกระบวนการนี้ให้สมบูรณ์",
    		 timeout: 10000
    	 });
    	
    	not.close(7000);
    	
    });
    
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
    
    // Object Element
    var objbranch = $('#branchcode');
    var rmcode	  = $("#rmcode");
    var province  = $('#province');
    var district  = $('#district');
    var sel_group = $('#channelmode');
    var subgroup  = $('#channelmodule');
    var findemp   = $('#findEmp');
    var cri_reas  = $('#criteria_reason');
    
    // Element div progressive
    var bn_progress = $('#bn_progress');
    var rm_progress	= $('#rmcode-progress');
    var bm_progress = $("#bm_progress");
    var dt_progress = $("#dt_progress");
    var pv_progress = $('#pv_progress');
    var ds_progress = $('#ds_progress');
    var ch_header_progress = $('#ch_header_progress');
    var ch_progress = $('#ch_progress');
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
    
 
    // AUTOMATIC FILL
    var fill_branchcode = $('#fill_branchcode').val();
    if(fill_branchcode) {
    	_.delay(function() {
    		$('#branchcode').find('option[value="' + fill_branchcode + '"]').prop('selected', 'selected').after(function() { callBranchRelation(fill_branchcode) });
    		
    	}, 500);
    }
    
    var fill_is_owner = $('#fill_is_owner').val();
    if(fill_is_owner) {
    	_.delay(function() {
    		var data = (fill_is_owner && fill_is_owner == 'Y') ? 0 : 1;    	
    		$('input[name="ownertype"]').find('input[name="ownertype"][value="' + data + '"]').click();
    		
    	}, 500);
    }
    
    var fill_empcode = $('#rmcode').val();
    if(fill_empcode) {
    	_.delay(function() {
    		$('#findEmp').click();
    	}, 500)
    	
    }
    	
    var fill_source_field = $('#fill_source_field').val();
    if(fill_source_field) {
    	_.delay(function() {
    		$('#sourceofcustomer').find('option[value="' + fill_source_field + '"]').prop('selected', 'selected');
    	}, 500)
    }
        
    // Autoload 
    var BMTemp_list = [];
    var bmData  = [];
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
    
    $.ajax({
        url: pathFixed+'dataloads/dueCustomStatus',
        type: "GET",
        beforeSend:function() {
        	dt_progress.show();
        },
        success:function(responsed) {
        	var objDue = $('select[name="duedatestatus"]');
        	objDue.empty().first().append('<option value="N/A">-- โปรดเลือก --</option>');
        	
            for(var indexed in responsed['data']) {
            	objDue.append("<option value='"+responsed['data'][indexed]['DueID']+"'>"+responsed['data'][indexed]['DueReason']+"</option>");
            	
            }
            
            objDue.last().append('<option value="0">อื่นๆ</option>');

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
    
    objbranch.on('change', function() {
    	var branchcode = $('select[name="branchcode"] option:selected').val();
		if(branchcode) {
			callBranchRelation(branchcode);
		}    	
		
	});
    
    function callBranchRelation(branchcode) {
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
    }
    
    province.combobox({ 
		select: function (event, ui) { 
			
			var prnmap	= $("select[name='province'] option:selected").val();
			if(prnmap == 'N/A') {
				$('input.custom-combobox-input').val('');
				$('#district').find('option[value="N/A"]').attr('selected', 'selected');
				$('#postcode').val('');
				
			} else {
				
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
	
		}
	});
	
    district.combobox({
    	select: function( event, ui ) {
    		
    		var district_map = $('select[name="district"] option:selected').val();
			if(district_map == '' || district_map == undefined) {
				$('#postcode').val('');
				
			} else {
				
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
	
			}
			
    	}    	
    });
    
    $.ajax({
        url: pathFixed+'dataloads/channeltypes',
        type: "GET",
        beforeSend:function() {
        	ch_header_progress.show();
        },
        success:function(data) {
        	sel_group.first().append('<option value="" selected>-- ช่องทาง --</option>');
            for(var indexed in data['data']) {
            	sel_group.append("<option value='"+data['data'][indexed]['Channel']+"'>"+data['data'][indexed]['Channel']+"</option>");
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
	    		  url: pathFixed+'dataloads/channels?_=' + new Date().getTime(),
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
    });   
    
    /*
    $.ajax({
        url: pathFixed+'dataloads/channels',
        type: "GET",
        beforeSend:function() {
        	ch_progress.show();
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
                        $("#rmhidden").val(result[0]['FullnameTh']);
                        $("#rmmobile").val(result[0]['Mobile']);
                        
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
            
        },
        complete:function() {
        	cr_processs.after(function() {
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
   
    // NEW SCRIPT 21/01/2015
    $('input[name="register"]').on('click', function() {
    	var cust_types =  $('input[name="register"]:checked').val();
    	if(cust_types == "A") {
    		
	        $.Dialog({
	        	shadow: true,
	        	overlay: true,
	        	draggable: true,
		        icon: '<i class="icon-user-3"></i>',
		        title: 'Re-Visitor',
		        content: '',
		        padding: 10,
		        width: 350,
		        onShow: function(_dialog){
		        	var content = 
		        	'<p>Please enter your customer id card number.</p>'+
			        '<label class="label">ID Card</label>' +
			        '<div class="input-control text">' +
				        '<input type="text" id="id_card" name="id_card" maxlength="13">' +
				        '<button class="btn-clear"></button>' +
			        '</div>' +
			        '<div class="form-actions">' +
				        '<button class="button primary" id="people_search">search</button> '+
				        '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
			        '</div>';
			         
			        $.Dialog.content(content);
		        }
	        });
    		
	        $('#people_search').on('click', function() {
	        	
	        	var person = $('#id_card').val(); //prompt("โปรดใส่เลขบัตรประชาชนของลูกค้า.", "");
	    		if(person.length < 13) {
	    			alert("คุณกรอกเลขบัตรประชาชนไม่ครบ 13 หลัก");
	    			
	    		} else {
	    			
					$.ajax({
	    		        url: pathFixed+'dataloads/loadInformation?_=' + new Date().getTime(),
	    		        type: "POST",
	    		        data: { keys: person },
	    		        beforeSend:function() {
	    		        	$('#bg_firstload').css('display', 'block');
	    		        },
	    		        success:function(data) {
	    		        	
	    		        	if(data['status'] == false) {
	    		        		alert(data['msg']);
	    		        		
	    		        	} else {
	    		        		    		        		
	    		        		$('select[name="sourceofcustomer"]').find('option[value="' + data['data'][0]['SourceOfCustomer'] + '"]').attr('selected', 'selected');
	    		        		$('#sourceoption').val(data['data'][0]['SourceOption']);
	    		        		$('input[name="interest"][value="' + data['data'][0]['Interest'] + '"]').attr('checked', 'checked');
	    		        		$('input[name="potential"][value="' + data['data'][0]['CSPotential'] + '"]').attr('checked', 'checked');
	    		        		$('input[name="ownertype"][value="' + data['data'][0]['OwnerType'] + '"').attr('checked', 'checked');
	    		        		$('input[name="prefixname"]').find('option[value="' + data['data'][0]['PrefixName'] + '"]').attr('selected', 'selected');
	    		        		$('#owner').val(data['data'][0]['OwnerName']);
	    		        		$('input[name="prefixcorp"]').find('option[value="' + data['data'][0]['PrefixName'] + '"]').attr('selected', 'selected');
	    		        		$('#company').val(data['data'][0]['Company']);
	    		        		$('select[name="businesstype"]').find('option[value="' + data['data'][0]['BusinessType'] + '"]').attr('selected', 'selected');
	    		        		$('#business').val(data['data'][0]['Business']);
	    		        		$('#telephone').val(data['data'][0]['Telephone']);
	    		        		$('#mobile').val(data['data'][0]['Mobile']);
	    		        		$('#downtown').val(data['data'][0]['Downtown']);
	    		        		$('#address').val(data['data'][0]['Address']);
	    		        		$('input.custom-combobox-input').val(data['data'][0]['Province']);
	    		        		$('select[name="district"]').append('<option value="'+data['data'][0]['District']+'">'+data['data'][0]['District']+'</option>');
	    		        		$('#postcode').val(data['data'][0]['Postcode']);
	    		        		$('select[name="channelmodule"]').find('option[value="' + data['data'][0]['SubChannel'] + '"]').attr('selected', 'selected');
	    		        		$('#channelmode').val(data['data'][0]['Channel']);
	    		        		$('#loanrequest').val(data['data'][0]['RequestLoan']);
	    		        		$('select[name="criteria_reason"]').find('option[value="' + data['data'][0]['CriteriaRemark'] + '"]').attr('selected', 'selected');
	    		        		$('#referralcode').val(data['data'][0]['ReferralCode']);
	    		        		$('#remark').val(data['data'][0]['Remark']);
	    		        
	    		        		
	    		        	}
	    		            
	    		        },
	    		        complete:function() {
	    		        	$('#bg_firstload').after(function() {
	    		        		$('#bg_firstload').css('display', 'none');
	    		        		
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
	        	
	        });
    		
    		
    	} 

    });
    
    /*
    $( "#dialog" ).dialog({
        autoOpen: true,
        show: {
            effect: "blind",
            duration: 1000
        },
        height: 450,
        width: 470,
        modal: true,
        open: function(event, ui) {
            $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
        }

    });
    */
    
    var progress_valid = $('#progress_valid');
    progress_valid.hide();
    $('#objCheckInfo').click(function() {
    	
    	var cust_name = $('#name_valid').val();
        var comp_name = $('#company_valid').val();
        var cust_mob  = $('#mobile_valid').val();
        var cust_tel  = $('#tel_valid').val();
        
        var is_checkname;
        var is_checkcomp;
        var is_checkmobile;
        
        $('#msg_alert_valid').css('font-size', '0.8em')
		if(cust_name == '' && comp_name == '') {
			$('#msg_alert_valid').text('กรุณาระบุชื่อ - นามสกุลลูกค้า / ชื่อสถานที่ประกอบการ อย่างน้อย 1 รายชื่อ');
			is_checkname = false;
		}  else {
			is_checkname = true;
		}
        /*
		if(comp_name == '') {
			$('#msg_alert_valid').text('กรุณาระบุชื่อสถานประกอบการ');
			is_checkcomp = false;
		} else {
			is_checkcomp = true;
		}
		*/
		if(cust_mob == '' && cust_tel == '') {
			$('#msg_alert_valid').text('กรุณาระบุเบอร์ติดต่อ อย่างน้อย 1 เบอร์');
			is_checkmobile = false;
		} else {
			is_checkmobile = true;
		}
    	    	
       
    	if(is_checkname == true && is_checkmobile == true) {
    		
    		$('#msg_alert_valid').text('');
    		
    		$.ajax({
                url: pathFixed+'dataloads/checkCustomValid?_=' + new Date().getTime(),
                type: "POST",
                data: {
                    name_valid: $('#name_valid').val(),
                    comp_valid: $('#company_valid').val(),
                    mob_valid: $('#mobile_valid').val(),
                    tel_valid: $('#tel_valid').val()
                },
                beforeSend:function() {
                    progress_valid.show();
                },
                success:function(data) {
        
                    if(data['status'] == true) {

                    	$('#msg_alert_valid').css('font-size', '0.8em')
                    	$('#msg_alert_valid').text('ขออภัย!! มีข้อมูลอยู่ในระบบแล้ว กรุณาตรวจสอบอีกครั้ง หรือหากคุณยืนยันจะสร้างเพิ่มกรุณา กดยืนยัน.');
                    	$('#msg_alert_valid').append('<div class="place-right" style="margin-right: 10px;"><button onclick="closeDialogBox();" type="button">ยืนยัน</button></div>');
                    	
                    	$('#owner').val(cust_name);
                    	$('#company').val(comp_name);
                    	$('#mobile').val(cust_mob);
                    	$('#telephone').val(cust_tel);
                    	
     
                    } else {
                    	
                    	if(data['event'] == 'not_found') {
                    		
                    		$('#msg_alert_valid').css('font-size', '0.8em')
                    		
                    		$('#owner').val(cust_name);
                        	$('#company').val(comp_name);
                        	$('#mobile').val(cust_mob);
                        	$('#telephone').val(cust_tel);
                        	
                            $("#dialog" ).dialog('close');

        					var not = $.Notify({ content: "คุณสามารถสร้างลูกค้าได้.", style: { background: '#a4c400', color: '#FFFFFF' }, timeout: 10000 });
        					not.close(7000);
                    		
                    	} 
                    	
                    	if(data['event'] == 'failed') {
                    		$('#msg_alert_valid').css('font-size', '0.8em')
                    		$('#msg_alert_valid').text('กรุณาระบุข้อมูลให้ครบถ้วน');
  
                    	}

                    }
					

                },
                complete:function() {
                    progress_valid.hide();
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

    });
    
    $('#loadDistrict').bind('click', function() {
    	
    	var prnmap	= $("select[name='province'] option:selected").val();
		if(prnmap == 'N/A') {
			$('input.custom-combobox-input').val('');
			$('#district').find('option[value="N/A"]').attr('selected', 'selected');
			$('#postcode').val('');
			
		} else {
			
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
    
    $('#loadPostCode').bind('click', function() {
    	
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
    
    $('#loadAppointment').bind('click', function() {
    	
    	$.ajax({
            url: pathFixed+'dataloads/dueCustomStatus',
            type: "GET",
            beforeSend:function() {
            	dt_progress.show();
            },
            success:function(responsed) {
            	var objDue = $('select[name="duedatestatus"]');
            	objDue.empty().first().append('<option value="N/A">-- โปรดเลือก --</option>');
            	
                for(var indexed in responsed['data']) {
                	objDue.append("<option value='"+responsed['data'][indexed]['DueID']+"'>"+responsed['data'][indexed]['DueReason']+"</option>");
                	
                }
                
                objDue.last().append('<option value="0">อื่นๆ</option>');

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
    	
    });
    
    $('#mobile_valid').mask('9999999999');
    
    //############# NEW HANDLED #############
    
    $('#sourceofcustomer').change(function() {
    	    	
    	var select_source = $(this).val();    	
    	if(select_source == 'Refer: Thai Life') {
    		
    		$('#submit').attr('disabled', 'disabled');
    		setFieldReferralAutoCompleted('#referralcode', true);
    	
    	} else {
    	
    		$('#submit').removeAttr('disabled');
    		setFieldReferralAutoCompleted('#referralcode', false);
    		
    	}
    	
    });

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
    		$(element).val("");
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
            			
            		} 
            		
            	} 
            	            	
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