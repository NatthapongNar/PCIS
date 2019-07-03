$.extend(jQuery.fn.dataTableExt.oSort, {
    "date-eu-pre": function (date) {
	    if(date != null) {
        date = date.replace(" ", "");
        var eu_date, year;
         
        if (date == '') { return 0; }
 
        if (date.indexOf('.') > 0) { eu_date = date.split('.'); }  
        else { eu_date = date.split('/'); }

        if (eu_date[2]) { year = eu_date[2]; } 
        else { year = 0; }
 
        var month = eu_date[1];
        if (month.length == 1) { month = 0+month; }
 
        var day = eu_date[0];
        if (day.length == 1) { day = 0 + day; }
 
        return (year + month + day) * 1;
	    }
    },
 	"date-eu-asc": function ( a, b ) { 
	 	return ((a < b) ? -1 : ((a > b) ? 1 : 0)); 
	},
 	"date-eu-desc": function ( a, b ) { 
	 	return ((a < b) ? 1 : ((a > b) ? -1 : 0)); 
	}
	
});

$(function() {

		var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
	    var pathFixed = window.location.protocol + "//" + window.location.host;
	    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
	    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }	
	    var query  = getQueryParams(document.location.search);
	    
	    var search_kpi = $('#search_kpi').val();
	    var kpino	   = $('#kpino').val();
	    var emp_kpi	   = $('#empcode_kpi').val();
	    var is_actived = $('#is_actived').val();
	    var mode_kpi   = $('#mode_kpi').val();
	
	    $('title').text('Application Progress');
		$('#requestloan_start').number(true, 0);
		$('#requestloan_end').number(true, 0);
		
		$('#panel_criteria').addClass('animated fadeInDown');
		$('#btnChart').addClass('animated bounceInRight');

		var tbl_progress = $('#tbl_content_progress');
		var table = tbl_progress.dataTable({
			"processing": true, 
		    "serverSide": true,
            "oLanguage": {
                //"sProcessing": '<img src="' + window.location.protocol + "//" + window.location.host + '/pcis/img/progress-loader.gif"' + ' style="margin-top: -20px; margin-left: -60px;"> <div  style="margin-top: -27px; margin-right: -60px;">Loading...</div>'
            	"sProcessing": '<img src="' + window.location.protocol + "//" + window.location.host + '/pcis/img/378_1.gif"' + ' style="z-index: 1002; background: #FFF;">'
            },
            "bFilter": false,
            "ajax": {
	            "url": pathFixed + 'progress/appComponents',
	            "type": "POST",
	            "data": function(d) {
		            
		            d.relx		       = query['rel'];		            
		            if(search_kpi) {
	                    // # Passive
	                	d.search_kpi	= search_kpi;
	                	d.mode_kpi		= mode_kpi;
						d.kpino			= kpino;	
						d.emp_auth		= emp_kpi;
						d.activerecords = is_actived;
		
	                } else {
	                	d.activerecords = $('input[name="inlineCheckbox"]:checked').val();
	                }
		      
					d.appno		       = $('#appno_hidden').val();
					d.id_card	   	   = $('#id_card_hidden').val();
					d.createdate_start = $('#startdate_hidden').val();
					d.createdate_end   = $('#enddate_hidden').val();
					d.appoint_start    = $('#appointment_startdate_hidden').val();
					d.appoint_end      = $('#appointment_enddate_hidden').val();
					d.loan_start 	   = $('#requestloan_hidden_start').val();
					d.loan_end   	   = $('#requestloan_hidden_end').val();
					//d.loan_data	   	   = $('#requestloan_hidden').val();
					d.custname   	   = $('#customer_hidden').val();
					d.rmname		   = $('#rmname_hidden').val();
					d.region		   = $('#regions_hidden').val();
					d.branchs		   = $('#branchs_hidden').val();
					d.source_cust	   = $('#source_hidden').val();
					d.location		   = $('#business_location_hidden').val();
					//d.activerecords    = $('input[name="inlineCheckbox"]:checked').val(); 
				    
	            },
	            "complete":function(data, callback) {
	       
	            	$('#overlay').hide();
	            	$('#showNumRecord').text($('#tbl_content_progress_info').text());
	                $('#tbl_content_progress_info').css('visibility', 'hidden');

	            	// UI Holding
	                $('#panel_criteria > .panel-content').hide(500, function() {
	                    $(this).css('display', 'none');
	                });
	        
	                $('#tbl_content_progress').find('td:nth-child(5), td:nth-child(7), td:nth-child(8), td:nth-child(11)').truncate({
	                    width: '200',
	                    token: '…',
	                    side: 'right',
	                    addtitle: true
	                });
	                
	                //$('#tbl_content_progress').find('tbody > tr').addClass('animated fadeIn');
				
	            },
	            'timeout': 15000,
        	},
            "columns": [
                { "data": "CreateDate" },
                { "data": "SourceOfCustomer" },
                { "data": "Interest" },
                { "data": "CSPotential" },
                { "data": "LoanGroup" },
                { "data": "OwnerName" },
                { "data": "DueDate" },
             	{ "data": "Downtown" },
             	{ "data": "Business" },
                { "data": "RequestLoan" },
                { "data": "BranchDigit" },
                { "data": "RMName" },
                { "data": "AppProcess" },
                { "data": "VerifyProcess" },
                { "data": "AStateProcess" }
             ],         
            "columnDefs": [           	   
           	    { "visible": true, "targets": 12, 'bSortable': false },
        	    { "visible": true, "targets": 13, 'bSortable': false },
        		{ "visible": true, "targets": 14, 'bSortable': false }
           	],
            "lengthMenu": [10, 20, 50, 100, 150],
            "aaSorting": [[0,'desc']],
            "pagingType": "full_numbers"
			
		}); 
		
		$.ajax({
			url: pathFixed+'management/getRMListBoundaryDefault?_=' + new Date().getTime(),
			type: "GET",
			success:function(responsed) {								
				//console.log(responsed);
				
				$('#parent_select_rmlist').html('');
				$('#parent_select_rmlist').html('<div id="rmselect_group" class="form-group text-left"><label class="label label-clear">EMP. NAME</label><select id="rmname" name="rmname" multiple="multiple" style="width: 130px;" class="text-left"></select></div>');
				for(var indexed in responsed['data']) {
					$('#rmname').append("<option value='" + responsed['data'][indexed]['EmployeeCode'] + "'>" + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + "</option>");
				}

				$('#rmname').change(function() { console.log($(this).val()); }).multipleSelect({ width: '100%', filter: true });
				
				
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

		$('#region').on('change', function () { 

			   var rgnidx	= $("select[name='region'] option:selected").val();
			   if(rgnidx != undefined || rgnidx != '') {
		
				   $.ajax({
						url: pathFixed+'dataloads/branchBoundary?_=' + new Date().getTime(),
						type: "POST",
						data: { rgnidx:rgnidx },
						success:function(responsed) {
							
							$('#parent_select_group').html('<div id="select_group" class="form-group text-left"><label class="label label-clear">BRANCH</label><select id="branchs" name="branchs" multiple="multiple" style="height: 34px;"></select></div>');
							for(var indexed in responsed['data']) {
								$('#branchs').append("<option value='"+responsed['data'][indexed]['BranchCode']+"'>"+responsed['data'][indexed]['BranchDigit']+ ' - ' + responsed['data'][indexed]['BranchName']+"</option>");
							}

							$('#branchs').change(function() {}).multipleSelect({ width: '100%', filter: true });

							fnLoadRMList();
							
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
		
		$.ajax({
	        url: pathFixed+'dataloads/loadDowntown',
	        type: "GET",	   
	        success:function(data) {

	            var objData = [];
	            for(var indexed in data['data']) {
	                objData.push(data['data'][indexed]['Downtown']);
	            }

	            $('#business_location').tagEditor({ autocomplete: { 'source': objData }, maxTags: 3, placeholder: '<i class="icon-location" style="color: rgb(255,48,25);"></i> Business Location...' });

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

		// Event: Change Branch
		fnLoadRMListByRegion();
		fnLoadRMList();		

		$('#refresh_pages').on('mouseover', function() { $('#refresh_pages i').addClass('fa-spin'); });
		$('#refresh_pages').on('mouseout', function() { $('#refresh_pages i').removeClass('fa-spin'); });
		$('#refresh_pages').click(function() { table.fnFilter($(this).val()); });
		
				
		$('#branchs').change(function() { 
			
			var branchCode = $(this).val();					
			if(branchCode != '' && branchCode != null) {
								
			} else {
				fnLoadRMListInRegion();
			}
			
		}).multipleSelect({ width: '100%', filter: true });
		
		$('#rmname').change(function() { }).multipleSelect({ width: '100%', filter: true });
		$('#sourceofcustomer').change(function() { }).multipleSelect({ width: '100%' });
		$('#requestloan').change(function() { }).multipleSelect({ width: '100%' });
			

		$('#btnSearch').click(function () { 
			
		    $('#inlineCheckbox_hidden').val('');
		    $('#startdate_hidden').val('');
		    $('#enddate_hidden').val('');
		    
		    $('#appointment_startdate_hidden').val('');
		    $('#appointment_enddate_hidden').val('');
		   // $('#requestloan_hidden').val('');
		    
		    $('#requestloan_hidden_start').val('');
		    $('#requestloan_hidden_end').val('');
		    
		    $('#regions_hidden').val('');
		    $('#branchs_hidden').val('');
		    $('#source_hidden').val('');
		    $('#appno_hidden').val('');
		    $('#id_card_hidden').val('');
		    $('#customer_hidden').val('');
		    $('#rmname_hidden').val('');
		    $('#business_location_hidden').val('');
			    
		    //var createdate_start 	= $('#startdate').val();
			//var createdate_end   	= $('#enddate').val();
		    //var loan_start 	   		= $('#requestloan_start').val();
			//var loan_end   	   		= $('#requestloan_end').val();		
		    
		    var objStartDate   		= $('#date_range').val();
		   // var objAppointmentDate	= $('#appointment_range').val();
		    var objLoanData			= $('#request_loan').val();
		    
			var region		   		= $('select[name="region"] option:selected').val();
			var branchs		   		= $('#branchs').val();
			var source_cust	   		= $('#sourceofcustomer').val();//$('select[name="sourceofcustomer"] option:selected').val();
			var appno		        = $('#appno').val();
			var id_card	   	   		= $('#id_card').val();
			var custname   	   		= $('#customers').val();
			var rmname		   		= $('#rmname').val();
			var business_location	= $('#business_location').val();
		    var activerecords    	= $('input[name="inlineCheckbox"]:checked').val();

			//if($('#branchs').val() == null || $('#branchs').val() == '') { $('#ms_spanbranchs > span').text(''); }
			
	        var pattern 	   = new RegExp("-");
	        var res 		   = pattern.test(objStartDate);
	        //var appoint		   = pattern.test(objAppointmentDate);
	        var loan_checker   = pattern.test(objLoanData);
	      
            var start_date	   = '',   
            	end_date 	   = '',
            	//appoint_start  = '',
            	//appoint_end	   = '',
            	start_loanreq  = '',
            	end_loanreq	   = '';	
            
            if(res) {		            	
            	var item   	   = objStartDate.split("-");
            	start_date     = item[0].trim();
            	end_date	   = item[1].trim();

            } else {		            	
            	start_date	   = objStartDate		            
	        }
            /*
            if(appoint) {
            	var item   	   = objAppointmentDate.split("-");
            	appoint_start  = item[0].trim();
            	appoint_end	   = item[1].trim();

            } else {
            	appoint_start  = objAppointmentDate;
            }
            */
            if(loan_checker) {
            	var item   	   = objLoanData.split("-");
            	start_loanreq  = item[0].trim();
            	end_loanreq	   = item[1].trim();

            } else {
            	start_loanreq  = objLoanData;
            }
            

		    $('#inlineCheckbox_hidden').val(activerecords);
		    
		    $('#startdate_hidden').val(start_date);
		    $('#enddate_hidden').val(end_date);
		    // $('#appointment_startdate_hidden').val(appoint_start);
		    //$('#appointment_enddate_hidden').val(appoint_end);
		    
		    //$('#requestloan_hidden').val(objLoanData);
		    $('#requestloan_hidden_start').val(start_loanreq);
		    $('#requestloan_hidden_end').val(end_loanreq);
		    
		    $('#regions_hidden').val(region);
		    $('#branchs_hidden').val(branchs);
		    $('#source_hidden').val(source_cust);
		    $('#appno_hidden').val(appno);
		    $('#id_card_hidden').val(id_card);
		    $('#customer_hidden').val(custname);
		    $('#rmname_hidden').val(rmname);
		    $('#business_location_hidden').val(business_location);
		
			table.fnFilter($(this).val()); // Reload	

			//fnClearFilter();
			
		});

		$('#btnClear').click(function() {

			// Clear Hidden
			$('#inlineCheckbox_hidden').val('');
		    $('#startdate_hidden').val('');
		    $('#enddate_hidden').val('');
		    $('#appointment_startdate_hidden').val('');
		    $('#appointment_enddate_hidden').val('');
		    
		    //$('#requestloan_hidden').val('');
		    $('#requestloan_start').val('');
			$('#requestloan_end').val('');
			
		    $('#regions_hidden').val('');
		    $('#branchs_hidden').val('');
		    $('#source_hidden').val('');
		    $('#appno_hidden').val('');
		    $('#id_card_hidden').val('');
		    $('#customer_hidden').val('');
		    $('#rmname_hidden').val('');

			// Clear Field Display
		    $('#inlineCheckbox1').prop( "checked", true );
			$('input[name="inlineCheckbox"]:checked').val('Active');
			
			$('#appno').val("");
			$('#id_card').val("");
			$('#date_range').val("");
			//$('#requestloan').val("");
			$('#customers').val("");
			$('#rmname').val("");
			$('#region').val('');
			$('#branchs').val('');
			
			$('.ms-choice > span').text('');
			$('input[name="selectItembranchs"]').prop('checked', false);
			$('input[name="selectItemrmname"]').prop('checked', false);
			$('input[name="selectItemsourceofcustomer"]').prop('checked', false);
			$('input[name="selectItemrequestloan"]').prop('checked', false);
			
			$('#sourceofcustomer').val('');
			
			
			$('input[name^="selectAll"]').prop('checked', false);
			$('input[name^="selectGroup"]').prop('checked', false);

			fnLoadBranchList();
			//table.fnFilter($(this).val());
			
		});	

		function fnLoadBranchList() {

			var rgnidx		= $("select[name='region'] option:selected").val();
			var regionSel;
			if(rgnidx == undefined) { regionSel  = null; }
			else { regionSel  = $("select[name='region'] option:selected").val(); }
				
			$.ajax({
				url: pathFixed+'dataloads/branchBoundary?_=' + new Date().getTime(),
				type: "POST",
				data: { rgnidx:regionSel },
				success:function(responsed) {

					$('#parent_select_group').html('<div id="select_group" class="form-group text-left"><label class="label label-clear">BRANCH</label><select id="branchs" name="branchs" multiple="multiple" style="height: 34px;"></select></div>');
					for(var indexed in responsed['data']) {
						$('#branchs').append("<option value='"+responsed['data'][indexed]['BranchCode']+"'>"+responsed['data'][indexed]['BranchDigit']+ ' - ' + responsed['data'][indexed]['BranchName']+"</option>");
					}

					$('#branchs').change(function() { }).multipleSelect({ width: '100%', filter: true });
										
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

		function fnLoadRMList() {
			
			$('#branchs').on('change', function () { 
				
			  	var branch_code	= $("#branchs").val();					  

				 $.ajax({
					url: pathFixed+'dataloads/getRMListBoundaryByCode?_=' + new Date().getTime(),
					type: "POST",
					data: { branchcode:branch_code },
					success:function(responsed) {								
						
						$('#parent_select_rmlist').html('');
						$('#parent_select_rmlist').html('<div id="rmselect_group" class="form-group text-left"><label class="label label-clear">EMP. NAME</label><select id="rmname" name="rmname" multiple="multiple" style="width: 130px;" class="text-left"></select></div>');
						for(var indexed in responsed['data']) {
							$('#rmname').append("<option value='" + responsed['data'][indexed]['EmployeeCode'] + "'>" + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + "</option>");
						}
			
						$('#rmname').change(function() {}).multipleSelect({ width: '100%', filter: true });
						
						
					},
					complete:function() {
			            
			            
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

		   });
			   
		}

		function fnLoadRMListByRegion() {
			
			$('#region').on('change', function () { 
				
			  	var regionCode	= $("select[name='region'] option:selected").val();					  

				 $.ajax({
					url: pathFixed+'dataloads/getRMListBoundaryByRegion?_=' + new Date().getTime(),
					type: "POST",
					data: { regioncode: regionCode },
					success:function(responsed) {				
						
						$('#parent_select_rmlist').html('');
						$('#parent_select_rmlist').html('<div id="rmselect_group" class="form-group text-left"><label class="label label-clear">EMP. NAME</label><select id="rmname" name="rmname" multiple="multiple" style="width: 130px;" class="text-left"></select></div>');
						for(var indexed in responsed['data']) {
							$('#rmname').append("<option value='" + responsed['data'][indexed]['EmployeeCode'] + "'>" + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + "</option>");
						}
			
						$('#rmname').change(function() { console.log($(this).val()); }).multipleSelect({ width: '100%', filter: true });
			
					},
					complete:function() {
			            
			            
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

		   });
			   
		}
		
		function fnLoadRMListInRegion() {
		  
			 var rgnidx	= $("select[name='region'] option:selected").val();
			 
			 $.ajax({
				url: pathFixed+'dataloads/getRMListBoundaryByRegion?_=' + new Date().getTime(),
				type: "POST",
				data: { regioncode: rgnidx },
				success:function(responsed) {				
					
					$('#parent_select_rmlist').html('');
					$('#parent_select_rmlist').html('<div id="rmselect_group" class="form-group text-left"><label class="label label-clear">EMP. NAME</label><select id="rmname" name="rmname" multiple="multiple" style="width: 130px;" class="text-left"></select></div>');
					for(var indexed in responsed['data']) {
						$('#rmname').append("<option value='" + responsed['data'][indexed]['EmployeeCode'] + "'>" + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + "</option>");
					}
		
					$('#rmname').change(function() { console.log($(this).val()); }).multipleSelect({ width: '100%', filter: true });
		
				},
				complete:function() {
		            
		            
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


function fnClearFilter() {
	/*
	$('.ms-choice > span').text('');
	$('#branchs').val('');
	$('input[name="selectItembranchs"]').prop('checked', false);
	*/
	
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

function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9\-]|/;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}