$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }	
    
    var str_date;
    var objDate = new Date();
    str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear(); // Set Date format DD/MM/YYYY
  
    $('title').text('TL Sales dashboard');
	$('#fttab').parent().remove();

	//DEFAULT LOANDER	
	getMasterRegion('#lb_region', '');
	fnLoadRMList('#lb_emp', '#lb_branch', true);
	getBranchList('#lb_branch', '', true);
	getTLABelongToBranch('#tl_branch', true);
	getTLAPositionTitle('#tl_position', true);
	setFieldReferralAutoCompleted('#tl_code', true);
	getMasterTLAStatusList('#tl_status', 'Active,Active_DD', true);

	//##### FUNCTION ####

	function getMasterRegion(element, select_code) {
		
		 $.ajax({
	       url: pathFixed + 'dataloads/regionInfo?_=' + new Date().getTime(),
	       type: "GET",
	       success:function(responsed) {
	 
	       	var selected = '';
	       	$(element).empty().prepend('<option value=""></option>');
	       	for(var indexed in responsed['data']) {	        	
	       		$(element).append('<option value="' + responsed['data'][indexed]['RegionID'].trim() + '" ' + selected + '>' + responsed['data'][indexed]['RegionNameEng'] + '</option>');
	       	
	       	}
	         
	       },	
	       complete:function() {
	       	if(select_code != '') {
	   			$(element).find('option[value="' + select_code.trim() + '"]').prop('selected', true);	        		
	   		}
	       },
	       cache: true,
	       timeout: 5000,
	       statusCode: {
		        404: function() { alert( "page not found." ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied.)"); },
		        500: function() { console.log("internal server error."); }
	       }
	   })
		
	}

	function getBranchList(element, select_code, multi) {

		 $.ajax({
	       url: pathFixed + 'dataloads/getBranchListAll?_=' + new Date().getTime(),
	       type: "GET",
	       success:function(responsed) {
	   
	       	$(element).empty().prepend('<option value=""></option>');
	       	for(var indexed in responsed['data']) {
	       		$(element).append('<option value="' + responsed['data'][indexed]['BranchCode'].trim() + '" data-attr="' + responsed['data'][indexed]['RegionID'].trim() + '">' + responsed['data'][indexed]['BranchName'] + '</option>');
	       		if(select_code != '') {
	       			 $(element).find('option[value="' + select_code + '"]').prop('selected', true);
	       		}
	       	}
	       	
	       	if(multi == true) {
	       		$(element).find('option[value=""]').remove();
	       		$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
	       	}
	       		       
	       },
	       cache: true,
	       timeout: 5000,
	       statusCode: {
		        404: function() { alert( "page not found." ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied.)"); },
		        500: function() { console.log("internal server error."); }
	       }
	   });
		
	}
	function getTLABelongToBranch(element, multi) {
		$.ajax({
	        url: pathFixed + 'dataloads/getTLABelongToBranch?_=' + new Date().getTime(),
	        type: 'GET',
	        success:function(responsed) {
	        	
	        	if(responsed['status']) {
	        		
	        		for(var indexed in responsed['data']) {
						$(element).append('<option value="' + responsed['data'][indexed]['TLA_BranchName'].trim() + '">' + responsed['data'][indexed]['TLA_BranchName'] + '</option>');
					}
	        		
	        		if(multi == true) {
		        		$(element).find('option[value=""]').remove();
		        		$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
		        	}            		
	        		
	        	}

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
	}

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

	function getTLAPositionTitle(element, multi) {
		$.ajax({
	        url: pathFixed + 'dataloads/getTLAPositionTitle?_=' + new Date().getTime(),
	        type: 'GET',
	        success:function(responsed) {
	        	
	        	if(responsed['status']) {
	        		
	        		for(var indexed in responsed['data']) {
						$(element).append('<option value="' + responsed['data'][indexed]['TLA_Position'].trim() + '">' + responsed['data'][indexed]['TLA_Position'] + '</option>');
					}
	        		
	        		if(multi == true) {
		        		$(element).find('option[value=""]').remove();
		        		$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
		        	}
	        		
	        		
	        	}

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
	}

	function fnLoadRMList(element, elemValue, multi) {
		
		var branch_code = $(elemValue).val();
		$.ajax({
			url: pathFixed+'dataloads/getEmpListSpecify?_=' + new Date().getTime(),
			type: "POST",
			data: { branchcode:branch_code },
			success:function(responsed) {								

				$(element).empty();
		        for(var indexed in responsed['data']) {
			        if(responsed['data'][indexed]['FullNameTh'] == '') { continue; } 
			        else { 
				        $(element).append('<option value="' + responsed['data'][indexed]['EmployeeCode'] + '">' + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + ' (' + responsed['data'][indexed]['BranchDigit'] + ')' + '</option>');	    				
			        }
		        }
		        
				if(multi == true) {
					$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
				}
			
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

	function fnLoadRMListByRegion(element, dataValue, multi) {
		  
		 $.ajax({
			url: pathFixed+'dataloads/getRMListBoundaryByRegion?_=' + new Date().getTime(),
			type: "POST",
			data: { regioncode: dataValue },
			success:function(responsed) {				
	
				$(element).empty();
		        for(var indexed in responsed['data']) {
			        if(responsed['data'][indexed]['FullNameTh'] == '') { continue; } 
			        else { 
				        $(element).append('<option value="' + responsed['data'][indexed]['EmployeeCode'] + '">' + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + ' (' + responsed['data'][indexed]['BranchDigit'] + ')' + '</option>');	    				
			        }
		        }
		        
				if(multi == true) {
					$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
				}
	
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
	

	function getMasterTLAStatusList(element, data, multi) {
		$.ajax({
	        url: pathFixed + 'dataloads/getMasterTLAStatusList?_=' + new Date().getTime(),
	        type: 'POST',
	        data: {
	        	unstatus: (data !== '') ? data:''
	        },
	        success:function(responsed) {
	        	
	        	if(responsed['status']) {
	        		
	        		$(element).empty();
	        		for(var indexed in responsed['data']) {
						$(element).append('<option value="' + responsed['data'][indexed]['TL_Status'].trim() + '">' + responsed['data'][indexed]['TL_Status'] + '</option>');
						
					}
	        		
	        		if(multi == true) {
		        		$(element).find('option[value=""]').remove();
		        		$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
		        	}
	        		
	        		
	        	}

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
	}

	//############# EVENT HANDLED ############
	function setEmpReference(element, element_relation) {
		var data_name = $(element + ' option:selected').val();
		var data_code = $(element + ' option:selected').attr('data-attr');

		if(data_name != '' && data_code != '') {
			$(element_relation).val(data_code);
			$(element).find('option[value="' + data_name + '"]').prop('selected', true);
		} else {
			$(element_relation).val('');
			$(element).find('option[value=""]').prop('selected', false);
		}
			
	}
	 		 
	$('#lb_region').change(function() {
		
		 var select_region = $('#lb_region option:selected').val();			
		 if(select_region == "") {
			 getBranchList('#lb_branch', '');
			 fnLoadRMListByRegion('#lb_emp', '', true);
			 
		 } else {
			 
			 $.ajax({
				url: pathFixed+'dataloads/branchBoundary?_=' + new Date().getTime(),
				type: "POST",
				data: { rgnidx:select_region },
				success:function(responsed) {

					$('#lb_branch').empty();
					for(var indexed in responsed['data']) {
						$('#lb_branch').append('<option value="' + responsed['data'][indexed]['BranchCode'].trim() + '" data-attr="' + responsed['data'][indexed]['RegionID'].trim() + '">' + responsed['data'][indexed]['BranchName'] + '</option>');
					}

					$('#lb_branch').change(function() { }).multipleSelect({ width: '100%', filter: true }).multipleSelect("refresh");

				},
				complete: function() {
					fnLoadRMListByRegion('#lb_emp', select_region, true);
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

	$('#lb_branch').change(function() {	
		
		$.ajax({
			url: pathFixed+'dataloads/getEmpListSpecify?_=' + new Date().getTime(),
			type: "POST",
			data: { branchcode: $(this).val() },
			success:function(responsed) {								

				$('#lb_emp').empty();
		        for(var indexed in responsed['data']) {
			        if(responsed['data'][indexed]['FullNameTh'] == '') { continue; } 
			        else { 
			        	$('#lb_emp').append('<option value="' + responsed['data'][indexed]['EmployeeCode'] + '">' + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + ' (' + responsed['data'][indexed]['BranchDigit'] + ')' + '</option>');	    				
			        }
		        }
		    
		        $('#lb_emp').change(function() { }).multipleSelect({ width: '100%', filter: true }).multipleSelect("refresh");;
						
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
	})	

	$('#filterClear').click(function() {
		
		$('.ms-choice > span').text('');
		$('input[name^="selectAll"]').prop('checked', false);
		$('input[name^="selectGroup"]').prop('checked', false);
		
		$('input[name="selectItemtl_position"]').prop('checked', false);
		//$('input[name="selectItemtl_status"]').prop('checked', false);
		$('select[name="lb_region"]').find('option[value=""]').prop('selected', true);
		$('input[name="selectItemtl_branch"]').prop('checked', false);
		$('input[name="selectItemlb_branch"]').prop('checked', false);
		$('input[name="selectItemlb_lb"]').prop('checked', false);
		
		$('#register_date').val('');
		$('#tl_code').val('');
		$('#tl_name').val('');
		
		$('#status_main_2').prop('checked', false);
		$('#drawdown_check').prop('checked', false);
		$('#a2ca_check').prop('checked', false);
		$('#ncb_check').prop('checked', false);
		
		$('#filterField').removeClass('fg-red').find('option[value="JoinDate"]').prop('selected', true);

		getMasterRegion('#lb_region', '');
		fnLoadRMList('#lb_emp', '#lb_branch', true);
		getBranchList('#lb_branch', '', true);

	});

	$('#tl_status').change(function() { }).multipleSelect({ width: '100%', filter: true });
	
	$('#filterField').change(function() {
		var select = $('#filterField option:selected').val();
	
		if(select == 'DrawdownDate') {
			$('#filterField').addClass('fg-red').css('font-weight', 'bold');
			
		} else {
			$('#filterField').removeClass('fg-red').removeAttr('style');			
		}
	});

	$('#drawdown_check').click(function() { 		
		if($('#drawdown_check').is(':checked')) {
			$('#a2ca_check, #ncb_check').prop('checked', false);
		}		
	});
	
	$('#a2ca_check').click(function() { 		
		if($('#a2ca_check').is(':checked')) {
			$('#drawdown_check, #ncb_check').prop('checked', false);
		}		
	});
	
	$('#ncb_check').click(function() { 		
		if($('#ncb_check').is(':checked')) {
			$('#drawdown_check, #a2ca_check').prop('checked', false);
		}		
	});
	
	new Kalendae.Input('register_date', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});

	$('.kalendae').mouseleave(function () {
		$(this).hide();
		$(this).blur();
	})
	
});