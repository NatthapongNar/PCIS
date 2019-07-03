$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }	
    
    var query  		= getQueryParams(document.location.search);
    var path_link	= "http://172.17.9.94/newservices/LBServices.svc/";
    
    var str_date;
    var objDate = new Date();
    str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear(); // Set Date format DD/MM/YYYY
  
    $('title').text('Collection Dashboard');
	$('#fttab').parent().remove();
	
	$('#refresh_pages').on('mouseover', function() { $('#refresh_pages i').addClass('fa-spin'); });
	$('#refresh_pages').on('mouseout', function() { $('#refresh_pages i').removeClass('fa-spin'); });

	//DEFAULT LOANDER	
//	getMasterRegion('#region', '');
//	fnLoadRMList('#emplist', '#branch', true);
//	getBranchList('#branch', '', true);
	
	$('#action_status').multipleSelect({ width: '100%', filter: true });
	$('#sourceofcustomer').multipleSelect({ width: '100%', filter: true });
	
	var useremp_code	= $('#empprofile_identity').val();
	var region_element 	= '#region';	
	var branch_element 	= '#branch';
	var emp_element 	= '#emplist';
	
	var region_value	= null;
	var area_value		= null;
	var branch_value	= null;
	var emp_value		= null;
	
	var config	= {
		single: false, 
		width: '100%', 
		filter: true
	};

	$(region_element).change(function() {
		region_value	= $(region_element).val();
		//loadMasterArea();
		loadMasterBranch();
		loadMasterEmployee();
	});

	/*
	$(area_element).change(function() {
		area_value		= $(area_element).val();
		loadMasterBranch();
		loadMasterEmployee();
	});
	*/

	$(branch_element).change(function() {
		branch_value		= $(branch_element).val();
		loadMasterEmployee();
	});

	loadMasterRegion();
	//loadMasterArea();
	loadMasterBranch();
	loadMasterEmployee();

	function loadMasterRegion() {
		var region_object = null;
		$.ajax({
			url: path_link + 'master/dropdown/region',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({
				EmpLogin: useremp_code
			}),
			beforeSend: function() { $(region_element).empty(); },
			success:function(responsed) { region_object = responsed; },
			complete: function() {
			
				if(region_object) {					
					$.each(region_object, function(index, value) {
						var fieldCondition = (value['EmployeeCode'] && value['EmployeeCode'] !== '') ?  value['EmployeeCode']:value['RegionCode'];
						$(region_element).append('<option value="' + value['RegionCode'] + '" data-value="' + fieldCondition + '">' + value['RegionNameEng'] + '</option>');
					});
				
					$(region_element).change(function() { }).multipleSelect(config).multipleSelect('refresh');
				
				}  else { 
					$(region_element)
					.append('<option value=""></option>')
					.multipleSelect('disable');
					$('#mslist_filter_region').parent().css('min-width', '170px');
				}
				
			},
			cache: false,
			timeout: 5000,
			statusCode: {
				404: function() { console.log( "page not found" ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); }
			}
			
		});
	}
	/*
	function loadMasterArea() {
		var area_object   = null;
		$.ajax({
			url: path_link + 'master/dropdown/area',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({
				EmpLogin: useremp_code,
				RegionID: ($(region_element).val() !== null) ? $(region_element).val().join():null
			}),
			beforeSend: function() { $(area_element).empty(); },
			success:function(responsed) { area_object = responsed; },
			complete: function() {
				
				if(area_object) {
					$.each(area_object, function(index, value) {
						$(area_element).append('<option value="' + value['AreaCode'] + '" data-value="' + value['EmployeeCode'] + '">' + value['Info'] + '</option>');
					});
				
					$(area_element).change(function() {}).multipleSelect(config).multipleSelect('refresh');
			
				}  else { 
					$(area_element)
					.append('<option value=""></option>')
					.multipleSelect('disable');
					$('#mslist_filter_area').parent().css('min-width', '170px');
					
				}
				
			},
			cache: false,
			timeout: 5000,
			statusCode: {
				404: function() { console.log( "page not found" ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); }
			}
			
		});
	}
	*/
	function loadMasterBranch() {
		var branch_object = null;
		$.ajax({
			url: path_link + 'master/dropdown/branch',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({
				EmpLogin: useremp_code,
				RegionID: ($(region_element).val() !== null) ? $(region_element).val():null,
				//AreaID:	($(area_element).val() !== null) ? $(area_element).val():null,
			}),
			beforeSend: function() { $(branch_element).empty(); },
			success:function(responsed) { branch_object = responsed; },
			complete: function() {
				
				if(branch_object) {
					$.each(branch_object, function(index, value) {
						$(branch_element).append('<option value="' + value['BranchCode'] + '" data-value="' + value['EmployeeCode'] + '">' + value['BranchNameTh'] + ' (' + value['BranchDigit'] + ')</option>');
					});
				
					$(branch_element).change(function() { }).multipleSelect(config).multipleSelect('refresh');
			
				}  else { 
					$(branch_element)
					.append('<option value=""></option>')
					.multipleSelect('disable');
					$('#filter_branch').parent().css('min-width', '170px');
					
				}
				
			},
			cache: false,
			timeout: 5000,
			statusCode: {
				404: function() { console.log( "page not found" ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); }
			}
			
		});
	}

	function loadMasterEmployee() {
		var emp_object	  = null;		
		$.ajax({
			url: path_link + 'master/dropdown/employee',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({
				EmpLogin: useremp_code,
				RegionID: ($(region_element).val() !== null) ? $(region_element).val():null,
				//AreaID:	($(area_element).val() !== null) ? $(area_element).val().join():null,
				BranchID: ($(branch_element).val() !== null) ? $(branch_element).val().join():null
			}),
			beforeSend: function() { $(emp_element).empty(); },
			success:function(responsed) { emp_object = responsed;	},
			complete: function() {
				if(emp_object) {
					$.each(emp_object, function(index, value) {
						$(emp_element).append('<option value="' + value['EmployeeCode'] + '">' + value['FirstNameTh'] + ' ' + value['LastNameTh'] + ' ' + changePositionTitle(value['PositionCode']) + '</option>');
					});
				
					$(emp_element).change(function() { }).multipleSelect(config).multipleSelect('refresh');
					
			
				} else { 
					$(emp_element)
					.append('<option value=""></option>')
					.multipleSelect('disable');
					$('#filter_branch').parent().css('min-width', '170px');
					
				}
				
			},
			cache: false,
			timeout: 5000,
			statusCode: {
				404: function() { console.log( "page not found" ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); }
			}
			
		});
	}
	
	function changePositionTitle($position) {
		
		if($position) {
			switch($position) {
				case "Regional Director":
						return '(RD)';
					break;
				case "Area Manager":
						return '(AM)';
					break;
				case "Branch Manager":
						return '(BM)';
					break;
				case "Relationship Manager":
						return '(RM)';
					break;
				default:
						return '';
					break;
			}
			
		} else { return ''; }
		
	}
	
	/*
	//##### FUNCTION ####
	function getMasterRegion(element, select_code) {
		
		 $.ajax({
	       url: pathFixed + 'dataloads/regionInfo?_=' + new Date().getTime(),
	       type: "GET",
	       success:function(responsed) {
	 
	       	var selected = '';
	       	$(element).empty().prepend('<option value=""></option>').append('<option value="01">BKK</option>');
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
	*/
	
	/*
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
	 		 
	$('#region').change(function() {
		
		 var select_region = $('#region option:selected').val();			
		 if(select_region == "") {
			 getBranchList('#branch', '');
			 fnLoadRMListByRegion('#emplist', '', true);
			 
		 } else {
			 
			 $.ajax({
				url: pathFixed+'dataloads/branchBoundary?_=' + new Date().getTime(),
				type: "POST",
				data: { rgnidx:select_region },
				success:function(responsed) {

					$('#branch').empty();
					for(var indexed in responsed['data']) {
						$('#branch').append('<option value="' + responsed['data'][indexed]['BranchCode'].trim() + '" data-attr="' + responsed['data'][indexed]['RegionID'].trim() + '">' + responsed['data'][indexed]['BranchName'] + '</option>');
					}

					$('#branch').change(function() { }).multipleSelect({ width: '100%', filter: true }).multipleSelect("refresh");

				},
				complete: function() {
					fnLoadRMListByRegion('#emplist', select_region, true);
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

	$('#branch').change(function() {	
		
		$.ajax({
			url: pathFixed+'dataloads/getEmpListSpecify?_=' + new Date().getTime(),
			type: "POST",
			data: { branchcode: $(this).val() },
			success:function(responsed) {								
				console.log(responsed);
				$('#emplist').empty();
		        for(var indexed in responsed['data']) {
			        if(responsed['data'][indexed]['FullNameTh'] == '') { continue; } 
			        else { 
			        	$('#emplist').append('<option value="' + responsed['data'][indexed]['EmployeeCode'] + '">' + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + ' (' + responsed['data'][indexed]['BranchDigit'] + ')' + '</option>');	    				
			        }
		        }
		    
		        $('#emplist').change(function() { }).multipleSelect({ width: '100%', filter: true }).multipleSelect("refresh");;
						
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
	*/

	var FilterDate = [{ field: 'Npdt', label: 'Due Date' }, { field: 'Lpdt', label: 'Last Payment' }, { field: 'lstContact', label: 'Contact Date' }];
	var FilterAmt  = [{ field: 'lspamt', label: 'Last Payment Amt.' }, { field: 'TotPmtamt', label: 'Overdue Amt.' }];

	$('#filterClear').click(function() {
		
		$('.ms-choice > span').text('');
		$('input[name^="selectAll"]').prop('checked', false);
		$('input[name^="selectGroup"]').prop('checked', false);
				
		$('select[name="region"]').find('option[value=""]').prop('selected', true);
		$('input[name="selectItembranch"]').prop('checked', false);
		$('input[name="selectItememplist"]').prop('checked', false);		
		
		
		$('input[name="selectItemsourceofcustomer"]').prop('checked', false);
		$('input[name="selectItemaction_status"]').prop('checked', false);
		$('input[name="list_flag"]').prop('checked', false);
		
		$('#field_date').val('');
		$('#start_date').val('');
		$('#end_date').val('');
		
		$('#custname').val('');
		$('#cust_code').val('');
		
		$('#filterType, #filterField').find('option[value=""]').prop('selected', true);
		
		removeFieldRange();	
		setDropdownOption('#filterField', FilterDate);

		getMasterRegion('#region', '');
		fnLoadRMList('#emplist', '#branch', true);
		getBranchList('#branch', '', true);

	});
		
	setDropdownOption('#filterField', FilterDate);
	$('#filterType').change(function() {
		
		var field_field = $('#filterField option:selected').val();		
		if(field_field == '') {
			$('#filterField').find('option[value="Npdt"]').prop('selected', true);
			setDropdownOption('#filterField', FilterDate);
			bindClndr();
		}
				
		var field_type  = $('#filterType option:selected').val();		
		if(field_type == "") {
			$('#filterField').find('option[value=""]').prop('selected', true);
			setDropdownOption('#filterField', FilterDate);
			removeFieldRange();		
		} else if(field_type == 'Amount') {
			
			setDropdownOption('#filterField', FilterAmt);
			$('#filterField').find('option[value="lspamt"]').prop('selected', true);
			$('#Parent_filterRange').html('<input id="filterRange" name="filterRange" type="text" value="" class="size2" onkeypress="priceValidate(event)">');
			
		} else if(field_type == 'Date') {
			setDropdownOption('#filterField', FilterDate);
			$('#filterField').find('option[value="Npdt"]').prop('selected', true);
			removeFieldRange();	
			bindClndr();
		}
		
	});
	
	$('#filterField').change(function() {
		var field_type = $('#filterType option:selected').val();		
		if(field_type == '') {
			
			$('#filterType').find('option[value="Date"]').prop('selected', true);
			bindClndr();
			
		} else if(field_type == 'Amount') {
			$('#Parent_filterRange').html('<input id="filterRange" name="filterRange" type="text" value="" class="size2" onkeypress="priceValidate(event)">');		
		}
		
		if($('#filterField option:selected').val() == "") {
			$('#filterType').find('option[value=""]').prop('selected', true);
			removeFieldRange();
		}
		
	});
	
	function getOSBalance() {
		var emp = $('#empprofile_identity').val();	
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/pcis/collectionfooter/' + emp,
	        type: "GET",
		    success: function (responsed) {
		    	if(responsed[0] && responsed[0].FinalNetActual)
		    		$('#finalnet').val(responsed[0].FinalNetActual);
		    },	   
		    complete:function() {},
		    error: function (error) { console.log(error); }	
		});		
	}
	
	getOSBalance();
	
	function setDropdownOption(element, value) {
		$(element).empty().append('<option value=""></option>');
		$.each(value, function(index, value) {
			$(element).append('<option value="' + value.field + '">' + value.label + '</option>');
		})
	}
	
	function removeFieldRange() {
		$('#Parent_filterRange').html('<input id="filterRange" name="filterRange" type="text" value="" class="size2">');
	}
	
	function bindClndr() {
		new Kalendae.Input('filterRange', {
			months:2,
			mode:'range',
			format: 'DD/MM/YYYY',
			useYearNav: true,
			side: 'bottom'
		});
	}
	
	$('.kalendae').mouseleave(function () {
		$(this).hide();
		$(this).blur();
	})
	
	//#Screen Setting
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

	function getZoom() { 
	
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