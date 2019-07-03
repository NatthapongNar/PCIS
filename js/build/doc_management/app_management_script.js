$(function() {
	
	$('title').text('Reconcile Document Management');
	$('#fttab').remove();

	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

    var objrecon	= $('input[name="inlineCheckbox"]:checked').val();
    var objFrom     = $('#emsstartdate');
    var objTo       = $('#emsenddate');
    
    var objstate	= 2;
    var objsort		= 'asc';
 
    $('input[name="inlineCheckbox"]').click(function() {
    	
    	var mode = $('input[name="inlineCheckbox"]:checked').val();
    	switch(mode) {
		    case 'a2lx':	
				$('#objTextSpan').text('All');
				objstate = '2';   
		    	break;
			case 'm2cx':
				$('#objTextSpan').text('MISSING');
				objstate = '5';
		    	break;
			case 'r2cl':
				$('#objTextSpan').text('RETURN');
				objstate = '9';
		    	break;
			case 'd2cr':
				$('#objTextSpan').text('CA RETURN');
				objstate = '2';
		    	break;
			case 'r2cx':
		    default:
		    	$('#objTextSpan').text('RECONCILE');
		    	objstate = '2';   
		    	break;
    	}
    	
    });

    var table = $('#tbl_reconsiledoc').dataTable({
    	"processing": true,
	    "serverSide": true,
	    "bFilter": false,	   
	    "oLanguage": {
	    	"sProcessing": '<img src="' + window.location.protocol + "//" + window.location.host + '/pcis/img/378_1.gif"' + '>'
        },
	    "ajax": {
	    	 "url": pathFixed + 'reconcile/getAppController?_=' + new Date().getTime(),
	    	 "type": "POST",
	         "data": function(d) {
		         
				d.slmode 		  	= $('input[name="inlineCheckbox"]:checked').val();
				d.logistic_code	  	= $('#logistic_code').val();
				d.regionid		  	= $('select[name="regions"] option:selected').val();
				d.branchdigit	  	= $('#branchs_hidden').val();
				d.rmname		  	= $('#rmname_hidden').val();
		        d.ownerName 	  	= $('#customer').val();
		        d.aciverecord	  	= $('input[name="Activecheck"]:checked').val();
		        d.ddflag			= ($('#drawdown_flag').is(':checked')) ? $('#drawdown_flag:checked').val():'';
		        
		        d.recdate_from	  	= $('#reconciledoc_start_hidden').val();
		        d.recdate_to	  	= $('#reconciledoc_end_hidden').val();
		        
		        d.missdate_from	  	= $('#missing_start_hidden').val();
		        d.missdate_to	  	= $('#missing_end_hidden').val();
		        
		        d.returndate_from 	= $('#returndoc_start_hidden').val();
		        d.returndate_to	  	= $('#returndoc_end_hidden').val();
		        
		        d.careturndate_from = $('#careturn_start_hidden').val();
		        d.careturndate_to	= $('#careturn_end_hidden').val();
		        
	         },
	         "complete":function(data, callback) {
		         
	        	 table.find('td:nth-child(17), td:nth-child(18)').truncate({
	        		 width: '170',
	        		 token: '…',
	        		 side: 'right',
	        		 addtitle: true
	             });	

	        	 table.find('th:nth-child(3), th:nth-child(6)').css('width', '40px');
	        	 table.find('th:nth-child(5), th:nth-child(9)').css('width', '80px');
				
	        	 $('#showNumRecord').text($('#tbl_reconsiledoc_info').text()); //.toLowerCase()
	             $('#tbl_reconsiledoc_info').css('visibility', 'hidden');
	             
	             // UI Holding
	             $('#panel_reconsiledoc > .panel-content').hide(500, function() {
	            	 $(this).css('display', 'none');
	             });
	             
	             //$('#tbl_reconsiledoc').find('tbody > tr').addClass('animated fadeIn');
				
	         }
	         
	    },
	    "columns": [
	        	    
			{ "data": "DocID" },
			{ "data": "LogisticCode" },
			{ "data": "SubmitDocToHQ" },
			{ "data": "LogisticDay" },
			{ "data": "LogisticStatus" },
			
	        { "data": "AppToCA" },
	        { "data": "LackNums" },
	        { "data": "CompletionDay" },
	        { "data": "CompletionState" },
	        
	        { "data": "ReturnDate" },
	        { "data": "ReturnNum" },
	        { "data": "ReturnDay" },
	        { "data": "ReturnState" },

	        { "data": "BranchDigit" },
	        { "data": "NCBCheck" },
	        { "data": "BorrowerType" },
			{ "data": "BorrowerName" },
			{ "data": "RMName" },
			{ "data": "Links" }
            
	     ],       
	     "columnDefs": [
	        { "visible": true, "targets": 0},
	        { "visible": true, "targets": 2, type: 'date-eu'},
	        { "visible": true, "targets": 3, 'bSortable': false},
	        { "visible": true, "targets": 4, 'bSortable': false},
	        { "visible": true, "targets": 5, type: 'date-eu'},
	        { "visible": true, "targets": 6, 'bSortable': false},
	        { "visible": true, "targets": 7, 'bSortable': false},
	        { "visible": true, "targets": 8, type: 'date-eu', 'bSortable': false},
	        { "visible": true, "targets": 9, 'bSortable': false},
	        { "visible": true, "targets": 10, 'bSortable': false},
	        { "visible": true, "targets": 11, 'bSortable': false},
	        { "visible": true, "targets": 12, 'bSortable': false},
	        { "visible": true, "targets": 13, 'bSortable': true},
	        { "visible": true, "targets": 14, 'bSortable': false},
	        { "visible": true, "targets": 15, 'bSortable': true},
	        { "visible": true, "targets": 16},
	        { "visible": true, "targets": 18, 'bSortable': false}
	    ],
		
		"lengthMenu": [20, 50, 100],
        "aaSorting": [[objstate, objsort]],
        "pagingType": "full_numbers"
    });

    $('#regions').on('change', function () { 

  	   	var rgnidx	= $("select[name='regions'] option:selected").val();
        if(rgnidx != undefined || rgnidx != '') {

  		   $.ajax({
  				url: pathFixed+'dataloads/branchBoundary?_=' + new Date().getTime(),
  				type: "POST",
  				data: { rgnidx:rgnidx },
  				success:function(responsed) {
  					
  					$('#parent_select_group').html('');//.first().append('<option value=""> -- ALL -- </option>');
  					$('#parent_select_group').html('<div id="select_group" class="form-group text-left"><label class="label label-clear">BRANCH</label><select id="branchs" name="branchs" multiple="multiple" style="width: 130px;  margin-right: 5px;"></select></div>');
  					for(var indexed in responsed['data']) {
  						$('#branchs').append("<option value='"+responsed['data'][indexed]['BranchDigit']+"'>"+responsed['data'][indexed]['BranchDigit']+ ' - ' + responsed['data'][indexed]['BranchName']+"</option>");
  					}

  					$('#branchs').change(function() { console.log($(this).val()); }).multipleSelect({ width: '100%', filter: true });
  					
  					// Event: Change Branch
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
    
    // Event: Change Branch
    onLoadRMDefault();
	fnLoadRMList();

    $('#branchs').change(function() { }).multipleSelect({ width: '100%', filter: true });
    $('#rmname').change(function() { }).multipleSelect({ width: '100%' });

    $('#refresh_pages').on('mouseover', function() { $('#refresh_pages i').addClass('fa-spin'); });
    $('#refresh_pages').on('mouseout', function() { $('#refresh_pages i').removeClass('fa-spin'); });
    $('#refresh_pages').click(function() { table.fnFilter($(this).val()); }); 
    
    $('#filterSubmit').click(function () { 
    	
    	$('#views_hidden').val('');
        $('#reconciledoc_start_hidden').val('');
    	$('#reconciledoc_end_hidden').val('');
    	$('#missing_start_hidden').val('');
    	$('#missing_end_hidden').val('');
    	$('#returndoc_start_hidden').val('');
    	$('#returndoc_end_hidden').val('');
    	$('#careturn_start_hidden').val('');
    	$('#careturn_end_hidden').val('');
    	
    	
    	var branchs				= $('#branchs').val();
    	var rmname				= $('#rmname').val();
    	var reconcile_date		= $('#reconcile_date').val();
    	var missing_date		= $('#missing_date').val();
    	var returndoc_date		= $('#returndoc_date').val();
    	var careturn_date		= $('#creditreturn_date').val();

    	var reconcile_start 	= '';
    	var reconcile_end		= '';
    	var missing_start		= '';
    	var missing_end			= '';
    	var return_start		= '';
    	var return_end			= '';
    	var careturn_start		= '';
    	var careturn_end		= '';

    	var pattern 			= new RegExp("-");
        var objreconcile  		= pattern.test(reconcile_date);
        var objmissingdoc		= pattern.test(missing_date);
        var objreturndoc		= pattern.test(returndoc_date);
        var objcareturn			= pattern.test(careturn_date);
      
   	  	if(objreconcile) {
  		   var item   	    	 = reconcile_date.split("-");
  		   reconcile_start    	 = item[0].trim();
  		   reconcile_end	   	 = item[1].trim();

   	  	} else { reconcile_start   = reconcile_date }
   	  	
   	  	if(objmissingdoc) {
		   var item   	    	 = missing_date.split("-");
		   missing_start    	 = item[0].trim();
		   missing_end	   		 = item[1].trim();

 	  	} else { missing_start   = missing_date }
   	    	 
   	  	if(objreturndoc) {
		   var item   	    	 = returndoc_date.split("-");
		   return_start    	 	 = item[0].trim();
		   return_end	   		 = item[1].trim();

	  	} else { return_start    = returndoc_date }
   	
   	  	if(objcareturn) {
		   var item   	    	 = careturn_date.split("-");
		   careturn_start    	 = item[0].trim();
		   careturn_end	   		 = item[1].trim();

	  	} else { careturn_start  = careturn_date }
   	  	
    	$('#rmname_hidden').val(rmname);
    	$('#branchs_hidden').val(branchs);
    	
    	$('#reconciledoc_start_hidden').val(reconcile_start);
    	$('#reconciledoc_end_hidden').val(reconcile_end);
    	$('#missing_start_hidden').val(missing_start);
    	$('#missing_end_hidden').val(missing_end);
    	$('#returndoc_start_hidden').val(return_start);
    	$('#returndoc_end_hidden').val(return_end);
    	$('#careturn_start_hidden').val(careturn_start);
    	$('#careturn_end_hidden').val(careturn_end);
    	        
    	table.fnFilter(); 
    	
    });
    
    $('#filterClear').click(function() { 
    	
		$('#regions').val('');
		$('#logistic_code').val('');
		$('#rmname').val('');
		$('#customer').val('');
		
		$('#reconcile_date').val('');
    	$('#missing_date').val('');
    	$('#returndoc_date').val('');
    	$('#creditreturn_date').val('');
              
        $('#reconciledoc_start_hidden').val('');
    	$('#reconciledoc_end_hidden').val('');
    	$('#missing_start_hidden').val('');
    	$('#missing_end_hidden').val('');
    	$('#returndoc_start_hidden').val('');
    	$('#returndoc_end_hidden').val('');
    	$('#careturn_start_hidden').val('');
    	$('#careturn_end_hidden').val('');

		$('#inlineCheckbox1').prop( "checked", true );
		$('input[name="inlineCheckbox"][value="r2cx"]').prop( "checked", true );
		$('input[name="selectItembranchs"]').prop('checked', false);
		$('input[name="selectItemrmname"]').prop('checked', false);
		
		$('input[name^="selectAll"]').prop('checked', false);
		$('input[name^="selectGroup"]').prop('checked', false);
		$('#drawdown_flag').prop('checked', false);
		
		$('#branchs').val('');
		$('.ms-choice > span').text('');

		fnLoadBranch();
		onLoadRMDefault();
		

	});    
 
    function fnLoadRMList() {
		
		$('#branchs').on('change', function () { 
			
		  	 var branch_code	= $("#branchs").val();					  
	
			 $.ajax({
				url: pathFixed+'dataloads/getRMListBoundary?_=' + new Date().getTime(),
				type: "POST",
				data: { branchcode:branch_code },
				success:function(responsed) {
					
					console.log(responsed);
					
					$('#parent_select_rmlist').html('');
					$('#parent_select_rmlist').html('<div id="rmselect_group" class="form-group text-left"><label class="label label-clear">EMP. NAME</label><select id="rmname" name="rmname" multiple="multiple" style="width: 130px;" class="text-left"></select></div>');
					
					for(var indexed in responsed['data']) {
						$('#rmname').append("<option value='" + responsed['data'][indexed]['EmployeeCode'] + "'>" + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + "</option>");
					}
		
					$('#rmname').change(function() { }).multipleSelect({ width: '100%', filter: true }).multipleSelect("refresh");
					
					
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
    
    function fnLoadBranch() {

		var rgnidx	= $("select[name='regions'] option:selected").val();
		var regionSel;
		if(rgnidx == undefined) { regionSel  = null; }
		else { regionSel  = $("select[name='regions'] option:selected").val(); }
		
		$.ajax({
			url: pathFixed+'dataloads/branchBoundary?_=' + new Date().getTime(),
			type: "POST",
			data: { rgnidx:rgnidx },
			success:function(responsed) {
				
				$('#parent_select_group').html('');
				$('#parent_select_group').html('<div id="select_group" class="form-group text-left"><label class="label label-clear">BRANCH</label><select id="branchs" name="branchs" multiple="multiple" style="width: 130px;  margin-right: 5px;"></select></div>');
				for(var indexed in responsed['data']) {
					$('#branchs').append("<option value='"+responsed['data'][indexed]['BranchDigit']+"'>"+responsed['data'][indexed]['BranchDigit']+ ' - ' + responsed['data'][indexed]['BranchName']+"</option>");
				}

				$('#branchs').change(function() { console.log($(this).val()); }).multipleSelect({ width: '100%', filter: true });
				
			},
			complete: function() {
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
    
    function onLoadRMDefault() {
    	
    	  $.ajax({
			url: pathFixed+'management/getRMListBoundaryDefault?_=' + new Date().getTime(),
			type: "GET",
			success:function(responsed) {								

				$('#parent_select_rmlist').html('');
				$('#parent_select_rmlist').html('<div id="rmselect_group" class="form-group text-left"><label class="label label-clear">EMP. NAME</label><select id="rmname" name="rmname" multiple="multiple" class="text-left" style="width: 130px;"></select></div>');
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
		
    }
    
    // Event Handled 
    $('#objMode_1, #objMode_2, #objMode_3, #objMode_4, #objMode_5').click(function() {
    	$('#inlineCheckbox1').prop('checked', true);
    	
    });
    
    // Default Binding Event
    new Kalendae.Input('reconcile_date', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});
        
    $('#drawdown_flag').prop('checked', false);
    var mode = $('input[name="inlineCheckbox"]:checked').val();
	switch(mode) {    		
	    case 'a2lx':  // All
	    case 'r2cx':  // RECONCILE DOC
	    	
	    	$('#search_field').html(
	    		'<div class="input-control text span3" data-role="input-control" style="max-width: 210px; float: right;">' +
					'<label class="label label-clear">RECONCILE DATE </label>' +
					'<div class="input-control text">' +
					    '<input id="reconcile_date" name="reconcile_date" type="text" value="">' +
					'</div>' +
				'</div>'			
	    	);
	    	
	    	new Kalendae.Input('reconcile_date', {
    			months:2,
    			mode:'range',
    			format: 'DD/MM/YYYY',
    			useYearNav: true
    		});
	    	
	    	$('#parent_drawdown_flag').hide();
	    	$('#parent_submitform').removeClass('span5');
			
	    break;		   
		case 'm2cx':  // MISSING DOC
			
			$('#search_field').html(
	    		'<div class="input-control text span3" data-role="input-control" style="max-width: 210px; float: right;">' +
					'<label class="label label-clear">MISSING DATE </label>' +
					'<div class="input-control text">' +
					    '<input id="missing_date" name="missing_date" type="text" value="">' +
					'</div>' +
				'</div>'			
	    	);
			
			new Kalendae.Input('missing_date', {
    			months:2,
    			mode:'range',
    			format: 'DD/MM/YYYY',
    			useYearNav: true
    		});
			
			$('#parent_drawdown_flag').show();
			$('#parent_submitform').addClass('span5');
			
	    break;
		case 'r2cl':  // RETURN DOC
			
			$('#search_field').html(
	    		'<div class="input-control text span3" data-role="input-control" style="max-width: 210px; float: right;">' +
					'<label class="label label-clear">RETURN DATE </label>' +
					'<div class="input-control text">' +
					    '<input id="returndoc_date" name="returndoc_date" type="text" value="">' +
					'</div>' +
				'</div>'			
	    	);
			
			new Kalendae.Input('returndoc_date', {
    			months:2,
    			mode:'range',
    			format: 'DD/MM/YYYY',
    			useYearNav: true
    		});
			
			$('#parent_drawdown_flag').hide();
			$('#parent_submitform').removeClass('span5');
		
	    break;
		case 'd2cr':  // CREDIT RETURN
			
			$('#search_field').html(
	    		'<div class="input-control text span3" data-role="input-control" style="max-width: 210px; float: right;">' +
					'<label class="label label-clear">CREDIT RETURN DATE </label>' +
					'<div class="input-control text">' +
					    '<input id="creditreturn_date" name="creditreturn_date" type="text" value="">' +
					'</div>' +
				'</div>'			
	    	);
			
			new Kalendae.Input('creditreturn_date', {
    			months:2,
    			mode:'range',
    			format: 'DD/MM/YYYY',
    			useYearNav: true
    		});
			
			$('#parent_drawdown_flag').hide();
			$('#parent_submitform').removeClass('span5');
			
    	break;
	}
    
    // Bind Click Handled
    $('input[name="inlineCheckbox"]').click(function() {
    	$('#drawdown_flag').prop('checked', false);
    	var mode = $('input[name="inlineCheckbox"]:checked').val();
    	switch(mode) {    		
		    case 'a2lx':  // All
		    case 'r2cx':  // RECONCILE DOC
		    	
		    	$('#search_field').html(
		    		'<div class="input-control text span3" data-role="input-control" style="max-width: 210px; float: right;">' +
						'<label class="label label-clear">RECONCILE DATE </label>' +
						'<div class="input-control text">' +
						    '<input id="reconcile_date" name="reconcile_date" type="text" value="">' +
						'</div>' +
					'</div>'			
		    	);
		    	
		    	new Kalendae.Input('reconcile_date', {
	    			months:2,
	    			mode:'range',
	    			format: 'DD/MM/YYYY',
	    			useYearNav: true
	    		});
		    	
		    	$('#parent_drawdown_flag').hide();
		    	$('#parent_submitform').removeClass('span5');
				
		    break;		   
			case 'm2cx':  // MISSING DOC
				
				$('#search_field').html(
		    		'<div class="input-control text span3" data-role="input-control" style="max-width: 210px; float: right;">' +
						'<label class="label label-clear">MISSING DATE </label>' +
						'<div class="input-control text">' +
						    '<input id="missing_date" name="missing_date" type="text" value="">' +
						'</div>' +
					'</div>'			
		    	);
				
				new Kalendae.Input('missing_date', {
	    			months:2,
	    			mode:'range',
	    			format: 'DD/MM/YYYY',
	    			useYearNav: true
	    		});
				
				$('#parent_drawdown_flag').show();
				$('#parent_submitform').addClass('span5');
				
		    break;
			case 'r2cl':  // RETURN DOC
				
				$('#search_field').html(
		    		'<div class="input-control text span3" data-role="input-control" style="max-width: 210px; float: right;">' +
						'<label class="label label-clear">RETURN DATE </label>' +
						'<div class="input-control text">' +
						    '<input id="returndoc_date" name="returndoc_date" type="text" value="">' +
						'</div>' +
					'</div>'			
		    	);
				
				new Kalendae.Input('returndoc_date', {
	    			months:2,
	    			mode:'range',
	    			format: 'DD/MM/YYYY',
	    			useYearNav: true
	    		});
				
				$('#parent_drawdown_flag').hide();
				$('#parent_submitform').removeClass('span5');
			
		    break;
			case 'd2cr':  // CREDIT RETURN
				
				$('#search_field').html(
		    		'<div class="input-control text span3" data-role="input-control" style="max-width: 210px; float: right;">' +
						'<label class="label label-clear">CREDIT RETURN DATE </label>' +
						'<div class="input-control text">' +
						    '<input id="creditreturn_date" name="creditreturn_date" type="text" value="">' +
						'</div>' +
					'</div>'			
		    	);
				
				new Kalendae.Input('creditreturn_date', {
	    			months:2,
	    			mode:'range',
	    			format: 'DD/MM/YYYY',
	    			useYearNav: true
	    		});
				
				$('#parent_drawdown_flag').hide();
				$('#parent_submitform').removeClass('span5');
				
	    	break;
		}
    	
    });

	
});
