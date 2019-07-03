var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

var query  		= getQueryParams(document.location.search);
var path_link	= "http://172.17.9.94/newservices/LBServices.svc/";

var region_element 	= '#filter_region';
var area_element 	= '#filter_area';
var branch_element 	= '#filter_branch';
var emp_element 	= '#filter_emp';
var year_element    = '#filter_year';
var useremp_code	= $('#profiler').val();

var config	= {
	single: false, 
	width: '100%', 
	filter: true
}

var region_value	= null;
var area_value		= null;
var branch_value	= null;
var emp_value		= null;

$(region_element).change(function() {
	region_value	= $(region_element).val();
	loadMasterArea();
	loadMasterBranch();
	loadMasterEmployee();
});

$(area_element).change(function() {
	area_value		= $(area_element).val();
	loadMasterBranch();
	loadMasterEmployee();
});

$(branch_element).change(function() {
	branch_value		= $(branch_element).val();
	loadMasterEmployee();
});

$(year_element).change(function() {
	var yearVal = $(this).val();
	fnLoadRangeOfMonth('#filter_months', null, yearVal);
});

/*

var event_change	= 0;
$('#filter_region, #filter_area, #filter_branch, #filter_emp').change(function() { 
	region_value	= $(region_element).val();
	area_value		= $(area_element).val();
	branch_value	= $(branch_element).val();
	emp_value		= $(emp_element).val();
	
	loadMasterFilter(); 
	
});

$(region_element).change(function() {
	if($(this).val()) {
		$(area_element).multipleSelect('disable');
		$(branch_element).multipleSelect('disable');
	} else {
		$(area_element).multipleSelect('enable');
		$(branch_element).multipleSelect('enable');
	}
});

$(area_element).change(function() {
	if($(this).val()) {
		$(region_element).multipleSelect('disable');
		$(branch_element).multipleSelect('disable');
	} else {
		$(region_element).multipleSelect('enable');
		$(branch_element).multipleSelect('enable');
	}
});

$(branch_element).change(function() {
	if($(this).val()) {
		$(region_element).multipleSelect('disable');
		$(area_element).multipleSelect('disable');
	} else {
		$(region_element).multipleSelect('enable');
		$(area_element).multipleSelect('enable');
	}
});
*/

// FUNCTION ENABLED
//loadMasterFilter();
loadMasterRegion();
loadMasterArea();
loadMasterBranch();
loadMasterEmployee();
fnLoadRangeOfMonth('#filter_months', null, $(year_element).val());

//fnLoadRegionList('#filter_region', null);
//fnLoadAreaList('#filter_area', null);
//fnLoadBranchList('#filter_branch', null)


// FUNCTIION AREA
function getPDFPerformanceSummary() {
	if(query['rel']) {
		var monthstr  = ''; 
		var modestr	  = '';
		var filterstr = '';
		var condition = useremp_code;
		
		var itemList = [];
		
		// GET DROPDOWN FILTER & OPTIONAL FILTER
		var region	 = $('#filter_region').find("option:selected").map(function(index,elem){ return $(elem).data("value"); });
		var area	 = $('#filter_area').find("option:selected").map(function(index,elem){ return $(elem).data("value"); });
		var branch	 = $(branch_element).val(); //$('#filter_branch').find("option:selected").map(function(index,elem){ return $(elem).data("value"); });
		var employee = $(emp_element).val();
		var month_no = $('#filter_months option:selected').val();
		var yearVal  = $('#filter_year option:selected').val();
		var mode	 = $('input[name="modeOptions"]:checked').val();
		var graphAll = $('#graph_summary').is(':checked');
		
		
		// FILTER STRING TO ARRAY
		var object_region = (region) ? region.toArray():[];
		var object_area   = (area) ? area.toArray():[];
		var object_branch = (branch) ? branch.map(Number):[]; //branch.toArray():[];
		var object_emp	  = (employee) ? employee.map(Number):[];
		var graph_summary = (graphAll) ? '.Y':'.N';
		
		// GET KPI MODE
		var kpi_mode	 = $('input[name="kpimode"]:checked').val();
		
		//  FOR KPI SUMMARY MODE
		if(kpi_mode == 'kpi_summary') {
			var object_filter = $.merge($.merge($.merge(object_region, object_area), object_branch), object_emp);
			
			if(object_filter) filterstr = unique(object_filter).join();
			if(month_no !== '') monthstr = '|' + month_no + '|' + yearVal;
			
			var criteria = (filterstr !== '') ? filterstr:condition;

			var url   = path_link + 'reports/kpisummary/' + criteria + monthstr + '/' + graph_summary;
			window.open(url,'_blank, _self');
			
			$('#graph_summary').prop('checked', false);
			
		} else { // FOR KPI PRESENTATION
			
			
				
			/* UAT */
			var url   = 'http://tc001pcis1p/testreportservices/LBServices.svc/reports/kpipresent/';
			window.open(url,'_blank, _self');
				
			/* PROPDUCTION 
			var url   = path_link + 'reports/kpipresent/';
			window.open(url,'_blank, _self');
			*/
		}
		
		console.log(kpi_mode);
		
		
	}

}

function unique(array) {
    return $.grep(array, function(el, index) {
        return index == $.inArray(el, array);
    });
}

function loadMasterRegion() {
	var region_object = null;
	
	if(query['rel']) {
		$.ajax({
			url: path_link + 'master/dropdown/region',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({
				EmpLogin: useremp_code
				// RegionID: ($(region_element).val() !== null) ? $(region_element).val().join():null
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
}

function loadMasterArea() {
	var area_object   = null;
	
	if(query['rel']) {
		$.ajax({
			url: path_link + 'master/dropdown/area',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({
				EmpLogin: useremp_code,
				RegionID: ($(region_element).val() !== null) ? $(region_element).val().join():null
				//AreaID:	($(area_element).val() !== null) ? $(area_element).val().join():null
			}),
			beforeSend: function() { $(area_element).empty(); },
			success:function(responsed) { area_object = responsed; },
			complete: function() {
				
				if(area_object) {
					$.each(area_object, function(index, value) {
						$(area_element).append('<option value="' + value['AreaCode'] + '" data-value="' + value['EmployeeCode'] + '">' + value['Info'] + '</option>');
					});
				
					$(area_element).change(function() { }).multipleSelect(config).multipleSelect('refresh');
			
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
}

function loadMasterBranch() {
	var branch_object = null;
		
	if(query['rel']) {
		$.ajax({
			url: path_link + 'master/dropdown/branch',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({
				EmpLogin: useremp_code,
				RegionID: ($(region_element).val() !== null) ? $(region_element).val().join():null,
				AreaID:	($(area_element).val() !== null) ? $(area_element).val().join():null,
				//BranchID: ($(branch_element).val() !== null) ? $(branch_element).val().join():null
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
}

function loadMasterEmployee() {
	var emp_object	  = null;
	
	if(query['rel']) {
		$.ajax({
			url: path_link + 'master/dropdown/employee',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({
				EmpLogin: useremp_code,
				RegionID: ($(region_element).val() !== null) ? $(region_element).val().join():null,
				AreaID:	($(area_element).val() !== null) ? $(area_element).val().join():null,
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

function clearDataFilter() {
	
	loadMasterRegion();
	loadMasterArea();
	loadMasterBranch();
	loadMasterEmployee();
	
	if(moment().format('M') < 3) { $('#filter_months').find('option[value="' + (moment().format('M') - 1) + '"]').prop('selected', true); }
	else { $('#filter_months').find('option[value="3"]').prop('selected', true); }
	
	$('#graph_summary').prop('checked', false);
	$('input[name="kpimode"][value="kpi_summary"]').prop('checked', true);
	
	//$("#filter_region, #filter_area, #filter_branch").multipleSelect("uncheckAll");	
}

function kpiModeSwitch(mode) {
	if(mode == 'kpi_present') {		
		
		$('#filter_kpisummary_content').css('display', 'none');
		$('#filter_kpisummary_footer').css('display', 'none');
		$('#filter_kpipresent_content').css('display', 'block');
		
		$('#filter_modal_body').addClass('modal-body-custom');
		
//		loadMasterRegion();
//		loadMasterArea();
//		loadMasterBranch();
//		loadMasterEmployee();

//		$(emp_element).multipleSelect('disable');
		$('#filter_months').prop('disabled', true);
		$('#graph_summary').prop('disabled', true);
		$('#filter_year').prop('disabled', true);
				
	} else {
		$('#filter_kpisummary_content').css('display', 'block');
		$('#filter_kpisummary_footer').css('display', 'block');
		$('#filter_kpipresent_content').css('display', 'none');
		
		$('#filter_modal_body').removeClass('modal-body-custom');
		
//		$(emp_element).multipleSelect('enable');
		$('#filter_months').prop('disabled', false);
		$('#graph_summary').prop('disabled', false);
		$('#filter_year').prop('disabled', false);
	}
	
	
}

/*
function loadMasterFilter() {
	
	var region_object = null;
	var area_object   = null;
	var branch_object = null;
	var emp_object	  = null;
	
	var config	= {
		single: false, 
		width: '100%', 
		filter: true
	}
	
	$.ajax({
		url: path_link + 'master/dropdown/authentication',
		type: "POST",
		dataType: "json",
		contentType: "application/json",
		data: JSON.stringify({
			EmpLogin: query['rel'],
			RegionID: ($(region_element).val() !== null) ? $(region_element).val().join():null,
			AreaID:	($(area_element).val() !== null) ? $(area_element).val().join():null,
			BranchID: ($(branch_element).val() !== null) ? $(branch_element).val().join():null
		}),
		beforeSend: function() {
			$(region_element).empty();
			$(area_element).empty();
			$(branch_element).empty();
			$(emp_element).empty();
		
		},
		success:function(responsed) {
			console.log(responsed);
			region_object = responsed.RegionData;
			area_object   = responsed.AreaData;
			branch_object = responsed.BranchData;	
			emp_object	  = responsed.EmployeeData;	
			
			event_change  = 1;
			
		},
		complete: function() {

			console.log([region_value, area_value, branch_value, emp_value]);

			if(region_object) {
				
				$.each(region_object, function(index, value) {
					$(region_element).append('<option value="' + value['RegionCode'] + '">' + value['RegionNameEng'] + '</option>');
				});
			
				$(region_element).change(function() { }).multipleSelect(config).multipleSelect('refresh');
			
			}  else { 
				$(region_element)
				.append('<option value=""></option>')
				.multipleSelect('disable');
				$('#mslist_filter_region').parent().css('min-width', '170px');
				
			}
			
			if(area_object) {
				$.each(area_object, function(index, value) {
					$(area_element).append('<option value="' + value['AreaCode'] + '">' + value['AreaNameEng'] + '</option>');
				});
			
				$(area_element).change(function() { }).multipleSelect(config).multipleSelect('refresh');
		
			}  else { 
				$(area_element)
				.append('<option value=""></option>')
				.multipleSelect('disable');
				$('#mslist_filter_area').parent().css('min-width', '170px');
				
			}
			
			if(branch_object) {
				$.each(branch_object, function(index, value) {
					$(branch_element).append('<option value="' + value['BranchCode'] + '">' + value['BranchNameTh'] + ' (' + value['BranchDigit'] + ')</option>');
				});
			
				$(branch_element).change(function() { }).multipleSelect(config).multipleSelect('refresh');
		
			}  else { 
				$(branch_element)
				.append('<option value=""></option>')
				.multipleSelect('disable');
				$('#filter_branch').parent().css('min-width', '170px');
				
			}
			
			if(emp_object) {
				$.each(emp_object, function(index, value) {
					$(emp_element).append('<option value="' + value['EmployeeCode'] + '">' + value['FirstNameTh'] + ' ' + value['LastNameTh'] + '</option>');
				});
			
				$(emp_element).change(function() { }).multipleSelect(config).multipleSelect('refresh');
		
			} else { 
				$(emp_element)
				.append('<option value=""></option>')
				.multipleSelect('disable');
				$('#filter_branch').parent().css('min-width', '170px');
				
			}

			if(region_value) $(region_element).multipleSelect("setSelects", region_value);
			if(area_value) $(area_element).multipleSelect("setSelects", area_value);
			if(branch_value) $(branch_element).multipleSelect("setSelects", branch_value);
			if(emp_value) $(emp_element).multipleSelect("setSelects", emp_value);
			
			event_change = 0;
			
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

function fnLoadRangeOfMonth(element, defaultValue, defaultYear) {
	
	var start = 1;
	var current_mth = (moment().format('M') > 1) ? moment().format('M') -1:1;
	
	$(element).empty();
	if(defaultYear == moment().format('YYYY')) {
		
//		if(moment().format('M') == 1) {
//			for(i = 0; i <= 11; i++) {		
//				$(element).append('<option value="' + start + '">ย้อนหลัง ' + start + '</option>');
//				if(start == 3) {
//					$(element).find('option[value="3"]').prop('selected', true);
//				}
//				start++;
//			}
//		} else {
			for(i = 0; i < current_mth; i++) {		
				$(element).append('<option value="' + start + '">ย้อนหลัง ' + start + '</option>');
				if(start == 3) {
					$(element).find('option[value="3"]').prop('selected', true);
				} else {
					$(element).find('option').last().prop('selected', true);
				}
				start++;
			}
//		}
		
	} else {
		
		if(defaultYear < moment().format('YYYY')) {
			
			for(i = 0; i <= 11; i++) {		
				$(element).append('<option value="' + start + '">ย้อนหลัง ' + start + '</option>');
				if(start == 3) {
					$(element).find('option[value="3"]').prop('selected', true);
				}
				start++;
			}
			
		} else {
			
			for(i = 0; i < current_mth; i++) {		
				$(element).append('<option value="' + start + '">ย้อนหลัง ' + start + '</option>');
				if(start == 3) {
					$(element).find('option[value="3"]').prop('selected', true);
				} else {
					$(element).find('option').last().prop('selected', true);
				}
				start++;
			}
			
		}
		
	}
	
	
	
}

function fnLoadRegionList(element, defaultValue) {

	$.ajax({
		url: pathFixed + 'dataloads/regionInfo?_=' + new Date().getTime(),
		type: "GET",
		success:function(responsed) {

			for(var indexed in responsed['data']) {
				$(element).append('<option value="' + responsed['data'][indexed]['RegionID'] + '">' + responsed['data'][indexed]['RegionNameEng'] + '</option>');
			}
		
			$(element).change(function() { }).multipleSelect({ width: '100%', filter: true }).multipleSelect('refresh');
			
			if(defaultValue) {
				$(element).multipleSelect('setSelects', defaultValue);
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

function fnLoadAreaList(element, defaultValue) {

	$.ajax({
		url: pathFixed + 'dataloads/getAreaInfo?_=' + new Date().getTime(),
		type: "GET",
		success:function(responsed) {
			console.log(responsed);
			for(var indexed in responsed['data']) {
				$(element).append('<option value="' + responsed['data'][indexed]['AreaName'] + '">' + responsed['data'][indexed]['AreaFullName'] + '</option>');
			}
		
			$(element).change(function() { }).multipleSelect({ width: '100%', filter: true }).multipleSelect('refresh');
			
			if(defaultValue) {
				$(element).multipleSelect('setSelects', defaultValue);
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

function fnLoadBranchList(element, defaultValue) {

	var regionsel;
	var rgnidx = $("select[name='region'] option:selected").val();
	if(rgnidx == undefined) { regionsel  = null; }
	else { regionsel  = $("select[name='region'] option:selected").val(); }
		
	$.ajax({
		url: pathFixed + 'dataloads/branchBoundary?_=' + new Date().getTime(),
		type: "POST",
		data: { rgnidx:regionsel },
		success:function(responsed) {

			for(var indexed in responsed['data']) {
				$(element).append("<option value='"+responsed['data'][indexed]['BranchCode']+"'>"+responsed['data'][indexed]['BranchDigit']+ ' - ' + responsed['data'][indexed]['BranchName']+"</option>");
			}
		
			$(element).change(function() { }).multipleSelect({ width: '100%', filter: true }).multipleSelect('refresh');
			
			if(defaultValue) {
				$(element).multipleSelect('setSelects', defaultValue);
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


