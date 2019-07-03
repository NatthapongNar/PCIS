<style type="text/css">
	
	table tbody tr:hover { color: red !important; }
	table#tbl_defender th, td { font-size: 12px;  }	
	table#tbl_defender tr td:first-child { text-align: center !important; display: none; }
	table#tbl_defender tr td:nth-child(2) { text-align: center !important; }
	table#tbl_defender tr td:nth-child(3) { text-align: center !important; }
	table#tbl_defender tr td:nth-child(4) { text-align: center !important; }
	table#tbl_defender tr td:nth-child(5) { text-align: center !important; }
	table#tbl_defender tr td:nth-child(6) { text-align: center !important; }
	table#tbl_defender tr td:nth-child(7) { text-align: center !important; }
	table#tbl_defender tr td:nth-child(8) { text-align: left !important; }
	table#tbl_defender tr td:nth-child(9) { text-align: left !important; }
	table#tbl_defender tr td:nth-child(10) { text-align: left !important; }			
	table#tbl_defender tr td:nth-child(11) { text-align: left !important; }
	table#tbl_defender tr td:nth-child(12) { text-align: center !important; }
	table#tbl_defender tr td:nth-child(14) { text-align: left !important; }
	table#tbl_defender tr td:nth-child(16) { text-align: center !important; }
	
	abbr { border:none; }
	.successes { background-color: #DFF0D8 !important; }
	.errors { background-color: #F2DEDE !important; }
	.waiting { background-color: #F2DEDE !important; }
	.brands { background-color: #4390DF; color: #FFF; }
	.label-clear { background-color: #FFF !important; }
	
	input, select { 
		font-size: 0.9em;
		font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
	}
	
	#definded_status div, p { display: inline; }
	.metro .dropdown-toggle:after { visibility: hidden; }
	
	/* PROGRESS ICON: MODIFY STYLE */
	div#tbl_defender_processing {
	    background-color: transparent;
	    margin-top: 10px;
	    margin-left: -250px !important;
	    width: 500px;
	}
	
	.metro .dataTables_wrapper .dataTables_processing {  box-shadow: none !important; }
	
</style>

<style type="text/css" media="print">	
 	
	.nonprint { display: none; }
	.printable { display: block !important }
	.btn { 
		display: none !important;
		height: auto;
		min-height: 100%;
		overflow-y: hidden;
		margin-top: -20px;
	}
			
	.note-toolbar { display: none !important; }
	
	@media print {
	
		body { font-size: 12px; }
		.print_margin { 
			text-align: left;
			margin-left: -5px !important; 
		}
		
		#showNumRecord { margin-top: -30px !important; }
		
		.dataTables_length, .dataTables_paginate, .number_length { display: none; }
		table#tbl_defender tr td:nth-child(16) { display: none; }

		.navigation-bar .navigation-bar-content .element-divider, .metro .navbar .navigation-bar-content .element-divider, .link_jumper, .navigation-bar img,
		.metro .navigation-bar .navbar-content .element-divider, .metro .navbar .navbar-content .element-divider { display: none !important; }
		
	}			
		
</style>

<div id="contentation" style="margin-top: 70px;">

	<header class="text-center animated rubberBand">
		<h2>DEFEND MANAGEMENT</h2>
		<!-- <h4 id="timestemps" class="text-center text-muted"><?php echo date('d M Y'); ?></h4> -->
	</header>

	<input id="empprofile_identity" type="hidden" value="<?php echo $session_data["emp_id"]; ?>">

	<div class="grid">
	<div id="application" class="row">
	
	<div id="element_hidden">
		<input id="status_hidden" name="status_hidden" type="hidden" value="">
		<input id="branchs_hidden" name="branchs_hidden" type="hidden" value="">
		<input id="rmname_hidden" name="rmname_hidden" type="hidden" value="">
		<input id="defend_process_hidden" name="defend_process_hidden" type="hidden" value="">
		<input id="defend_type_hidden" name="defend_type_hidden" type="hidden" value="">
	</div>
	
	<!-- SEARCH TOOLBAR -->
	<div id="panel_reconsiledoc" class="panel nonprint" data-role="panel" style="width: 70%; float: right; margin-top: 10px; margin-bottom: 13px; margin-right: 1.5%;">
		<div class="panel-header bg-lightBlue fg-white" style="font-size: 1.1em;"><i class="fa fa-search on-left"></i>FILTER CRITERIA</div>
		<div class="panel-content" style="display: none; float: right;">
		
			<div class="row place-right">				 
				<div class="input-control radio" data-role="input-control">
			        <label>
			            <input type="radio" id="inlineCheckbox1" name="inlineCheckbox" value="Active" checked>
			            <span class="check"></span> 
			            <span class="label label-clear">ACTIVE</span>
			        </label>
			   	</div>
			   	<div class="input-control radio" data-role="input-control" style="margin-right: 5px;">
			        <label>
			            <input type="radio" id="inlineCheckbox2" name="inlineCheckbox" value="InActive">
			            <span class="check"></span> 
			            <span class="label label-clear">INACTIVE</span>
			        </label>
                </div>
			    <div class="input-control radio" data-role="input-control" style="margin-right: 15px;">
			        <label>
			            <input type="radio" id="inlineCheckbox3" name="inlineCheckbox" value="All"> 
			            <span class="check"></span> 
			            <span class="label label-clear">ALL</span>
			        </label>
			    </div>
			    
			    <?php 
				
				if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' || 
				   in_array('074006', $session_data['auth']) || 
				   in_array('074007', $session_data['auth']) || 
				   in_array('074008', $session_data['auth'])) {
				   	
					echo '<div class="input-control select size2">
			                <label class="label label-clear">REGION</label>
			                	<select id="regions" name="regions" style="height: 34px;">
									<option value="" selected></option>';
						
					foreach($AreaRegion['data'] as $index => $values) { echo '<option value="'.$values['RegionID'].'">'.strtoupper($values['RegionNameEng']).'</option>'; }
					echo '</select></div>';
					
				}
				
				if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' ||
				   in_array('074004', $session_data['auth']) || in_array('074005', $session_data['auth']) ||
 				   in_array('074006', $session_data['auth']) || in_array('074007', $session_data['auth']) ||
				   in_array('074008', $session_data['auth'])) {

					echo '<div id="parent_select_group" class="input-control select size2" style="margin-left: 4px;">
    					  <div id="select_group" class="form-group text-left">
		                  	<label class="label label-clear">BRANCH</label>
			              	<select id="branchs" name="branchs" multiple="multiple" style="width: 130px;  margin-right: 5px;" class="text-left">';
								
					foreach($AreaBoundary['data'] as $index => $values) { echo '<option value="'.$values['BranchDigit'].'">'.$values['BranchDigit'].' - '.$this->effective->get_chartypes($char_mode, $values['BranchName']).'</option>'; }
					echo	'</select>
						  </div>
						  </div>';
					
				}
				
				?>
				
				<div id="parent_select_rmlist" class="input-control select size2" data-role="input-control" style="margin-left: 3px; height: 34px;">
					<div id="rmselect_group" class="form-group text-left">
						<label class="label label-clear">EMP. NAME</label>
						<select id="rmname" name="rmname" multiple="multiple"></select>
					</div>
				</div>
				
				<div id="parent_select_rmlist" class="input-control select size2" data-role="input-control" style="margin-left: 3px; margin-right: 20px; height: 34px;">
					<div id="rmselect_group" class="form-group text-left">
						<label class="label label-clear">STATUS</label>
						<select id="status" name="status" multiple="multiple">
							<option value="P">P - Pending</option>
		                    <option value="A">A - Approved</option>
		                    <option value="R">R - Reject</option>
		                    <option value="C">C - Cancel</option>
		                    <option value="CR">CR - CA Return</option>	 
						</select>
					</div>
				</div>
				
			</div>
			
			<div class="row place-right" style="margin-right: 20px;">
				<div class="input-control text size2 text-left">
					<label class="label label-clear">DEFEND DATE</label>
					<input id="date_range" name="date_range" type="text" value="">
				</div>

				<div class="input-control select size2 text-left">
					<label class="label label-clear">DEF. PROCESS</label>
					<select id="defend_process" name="defend_process" multiple="multiple" style="height: 34px;">
						<option value="Before Process">Before Process</option>
						<option value="On Process">On Process</option>
						<option value="After Process">After Process</option>
					</select>
				</div>

				<div class="input-control select size2">
					<label class="label label-clear">DEF. OPTION</label>
					<select id="defend_type" name="defend_type"  multiple="multiple" style="height: 34px;">
						<option value="RM">LB</option>
						<option value="DF">HO</option>
					</select>
				</div>

				<div class="input-control text size2 text-left">
					<label class="label label-clear">DEFEND NAME</label>
					<input id="defend_name" name="defend_name" type="text" value="">
				</div>
				
				<div class="input-control text size2 text-left">
					<label class="label label-clear">CA NAME</label>
					<input id="caname" name="caname" type="text" value="">
				</div>

				<div class="input-control text size2 text-left">
					<label class="label label-clear">CUSTOMER</label>
					<input id="customer" name="customer" type="text" value="">
				</div>
	    	</div>
	    	
	    	<div class="row place-right text-right" style="margin-top: 25px; margin-right: 20px;">
	    		<div class="span12">
		    	<div class="input-control text">
					<button type="button" id="filterSubmit" class="bg-lightBlue fg-white" style="height: 33px;">
						<i class="icon-search on-left"></i>SEARCH
					</button>
					<button type="button" id="filterClear" class="bg-green fg-white" style="height: 33px;">CLEAR</button>
				</div>
				</div>
	    	</div>
	    	
			
		</div>		
	</div>

	<section class="nonprint" style="float: right; margin-top: 22px; margin-right: 10px;">	
	
		<span data-role="input-control" style="margin-right: 10px;" data-hint="กดเพื่อ refresh หน้า" data-hint-position="top" width="3%">
			<a id="refresh_pages" href="#" class="fg-lightBlue"><i class="fa fa-refresh on-left"></i> 
			<span>REFRESH</span></a>
		</span>
        
     </section>
	
	<div id="showNumRecord" style="position: absolute; float: left; margin-top: 40px; font-size: 0.9em; margin-left: 1.5%;"></div>
	
		<div id="tbl_defender_content" class="table-responsive" style="padding: 0 20px;">
		
			 <table id="tbl_defender" class="table bordered hovered" style="width: 100%; margin: 10px auto 0;">
	           	 <thead>
	            	<tr class="brands">
	            		<th rowspan="2" width="3%" style="display: none;">DOC ID</th>
	            		<th colspan="6" width="30%">DEFEND INFORMATION</th>
	            		<th colspan="8" width="70%">INFORMATION</th>
	            		<th class="nonprint" rowspan="2" width="2%">LINK</th>
	            	</tr>
		            <tr class="brands">
		            	<th width="7%">DATE</th>
		            	<th width="7%">UPDATE</th>
		            	<th width="5%"><i class="icon-diamond"></i></th>
		            	<th width="5%"><i class="fa fa-flag-o" style="font-size: 1.1em;"></i></th>
		            	<th width="5%"><i class="fa fa-comments"></i></th>		
						<th width="7%"><i class="fa fa-navicon on-left on-left"></i>LIST</th>
						<th width="7%">LB</th>
						<th width="8%">RM NAME</th>
						<th width="8%">CUSTOMER</th>
						<th width="8%">DEDEND BY</th>
		                <th width="8%">CA NAME</th>	          
		                <th width="5%">ST</th>
		                <th width="7%">DATE</th>
		                <th width="23%">REASON</th>
		            </tr>
	            </thead>
	            <tbody>
					
	            </tbody>
      		</table>

		
		</div>
	
	</div>
	</div>
	
</div>

<div class="container" style="margin-top: 30px; margin-left: 20px;">
	<?php echo $footer; ?>
</div>

<script type="text/javascript">

$(function() {

	$('#fttab').remove();
	$('title').text('Defend Management');
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

    new Kalendae.Input('date_range', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});

	$('.kalendae').mouseleave(function () {
		$(this).hide();
		$(this).blur();
	})

    
    var table = $('#tbl_defender').dataTable({
    	"processing": true,
	    "serverSide": true,
	    "bFilter": false,
	    "oLanguage": {
	    	"sProcessing": '<img src="' + window.location.protocol + "//" + window.location.host + '/pcis/img/378_1.gif"' + '>'
        },
	    "ajax": {
	    	 "url": pathFixed + 'reconcile/setDefnedListRecords?_=' + new Date().getTime(),
	         "type": "POST",
	         "data": function(d) {
		         
	        	 	var objStartDate   = $('#date_range').val();
					var pattern 	   = new RegExp("-");
					var res 		   = pattern.test(objStartDate);

					var start_date	   = '',
						 end_date 	   = '';

					if(res) {
						 var item      = objStartDate.split("-");
						 start_date    = item[0].trim();
						 end_date	   = item[1].trim();

					} else {
						 start_date	   = objStartDate
					}

					d.defend_start 	= start_date;
					d.defend_end   	= end_date;
					d.regions		= $('select[name="regions"] option:selected').val();
					d.def_process 	= $('#defend_process_hidden').val();
					d.def_type 		= $('#defend_type_hidden').val();
				    //d.branchs		= $('#branchs').val();
				    d.status 		= $('#status_hidden').val();
				    d.branchs		= $('#branchs_hidden').val();
					d.rmname		= $('#rmname_hidden').val();
			        d.customer 		= $('#customer').val();
			        d.defendname	= $('#defend_name').val();
			        d.caname		= $('#caname').val();
			        d.views			= $('input[name="inlineCheckbox"]:checked').val();
	         },
	         "complete":function(data, callback) {

	        	 $('#tbl_defender').find('tbody > tr').addClass('animated fadeIn');
		         
		         $('#showNumRecord').text($('#tbl_defender_info').text()); //.toLowerCase()
	             $('#tbl_defender_info').css('visibility', 'hidden');

	             $('#tbl_defender tbody tr').each(function(e) {
	                	var objRow = $(this).find('td:nth-child(12), td:nth-child(13)');
						if(objRow[0].innerHTML == "A"  && objRow[1].innerHTML != '' && objRow[1].innerHTML != '01/01/1900') {
							$(this).addClass('successes');

						} else if(objRow[0].innerHTML == "R" || objRow[0].innerHTML == "C") {
							$(this).addClass('successes');

						} else if(objRow[0].innerHTML == "A" || objRow[0].innerHTML == "R" || objRow[0].innerHTML == "C" && objRow[1].innerHTML == '' || objRow[1].innerHTML == '01/01/1900') {
							$(this).addClass('errors');
						}
						
	             }); 

	             $('#tbl_defender').find('td:nth-child(9), td:nth-child(10), td:nth-child(11), td:nth-child(12), td:nth-child(15)').truncate({
	                width: '100',
	                token: '…',
	                side: 'right',
	            	addtitle: true
	            });

	             $('#tbl_defender').find('td:nth-child(15)').truncate({
		                width: '180',
		                token: '…',
		                side: 'right',
		            	addtitle: true
		            });

	          	// UI Holding
            	$('#panel_reconsiledoc > .panel-content').hide(500, function() {
            		$(this).css('display', 'none');
             	});

	
	         }
	    },
	    "columns": [
			{ "data": "DocID" },
			{ "data": "DefendDate" },
			{ "data": "LatestUpdateItem" },
			{ "data": "DefendProcess" },
			{ "data": "FlagDay" },
			{ "data": "Times" },
			{ "data": "Fill_Item" },
			{ "data": "BranchDigit" },
			{ "data": "RMName" },
			{ "data": "BorrowerName" },
			{ "data": "DefendBy" },
			{ "data": "CAName" },			
			{ "data": "Status" },
			{ "data": "StatusDate" },
			{ "data": "StatusReason" },
			{ "data": "Links" }
	     ],
	     "columnDefs": [
        	{ "visible": true, "targets": 3, 'bSortable': false},
        	{ "visible": true, "targets": 13, 'bSortable': false},
        	{ "visible": true, "targets": 14, 'bSortable': false},
        ],
		"lengthMenu": [20, 50, 100],
        "aaSorting": [[1,'asc']],
        "pagingType": "full_numbers"
    });

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
    

    $('select[name="tbl_defender_length"]').prepend('<option value="10">10</option>');
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

    $('#filterSubmit').click(function () { 

		$('#views_hidden').val('');
    	
    	var branchs		= $('#branchs').val();
    	var status		= $('#status').val();
    	var rmname		= $('#rmname').val();
    	var df_process	= $('#defend_process').val();
		var df_type		= $('#defend_type').val();
    	
    	/*
    	if($('#branchs').val() == null || $('#branchs').val() == '') {
	    	$('#ms_spanbranchs > span').text('');
		}
		*/

		$('#status_hidden').val(status);
    	$('#rmname_hidden').val(rmname);
    	$('#branchs_hidden').val(branchs);
    	$('#defend_process_hidden').val(df_process);
		$('#defend_type_hidden').val(df_type);
        
        table.fnFilter($(this).val()); 
        //fnFilterClear();
    });
    
    $('#filterClear').click(function() {
		//$('#defendstartdate').val("");
		//$('#defendenddate').val("");
		
		$('#date_range').val("");		
		$('#customer').val("");
		$('#rmname').val("");
		$('#caname').val("");
		$('#defend_name').val("");
		$('#regions').val('');
		$('#branchs').val('');
		
		$('.ms-choice > span').text('');
		$('input[name="selectItemstatus"]').prop('checked', false);
		$('input[name="selectItemrmname"]').prop('checked', false);
		$('input[name="selectItembranchs"]').prop('checked', false);
		$('input[name="selectItemdefend_type"]').prop('checked', false);
		$('input[name="selectItemdefend_process"]').prop('checked', false);
		
		$('input[name^="selectAll"]').prop('checked', false);
		$('input[name^="selectGroup"]').prop('checked', false);

		fnLoadBranch();
		//table.fnFilter($(this).val());
	});

    $('#refresh_pages').on('mouseover', function() { $('#refresh_pages i').addClass('fa-spin'); });
    $('#refresh_pages').on('mouseout', function() { $('#refresh_pages i').removeClass('fa-spin'); });
    $('#refresh_pages').click(function() { table.fnFilter($(this).val()); });


    function fnFilterClear() {
		//$('#ncbstartdate').val("");
		//$('#ncbenddate').val("");
		//$('#customer').val("");
		//$('#rmname').val("");
		//$('#regions').val('');
		//$('.ms-choice > span').text('');
		
		$('#branchs').val('');
		$('input[name="selectItembranchs"]').prop('checked', false);
		
	}
	
 	function fnLoadRMList() {
		
		$('#branchs').on('change', function () { 
			
		  	var branch_code	= $("#branchs").val();					  

			 $.ajax({
				url: pathFixed+'dataloads/getRMListBoundary?_=' + new Date().getTime(),
				type: "POST",
				data: { branchcode:branch_code },
				success:function(responsed) {								
					
					$('#parent_select_rmlist').html('');
					$('#parent_select_rmlist').html('<div id="rmselect_group" class="form-group text-left"><label class="label label-clear">EMP. NAME</label><select id="rmname" name="rmname" multiple="multiple" style="width: 130px;" class="text-left"></select></div>');
					for(var indexed in responsed['data']) {
						$('#rmname').append("<option value='" + responsed['data'][indexed]['EmployeeCode'] + "'>" + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + "</option>");
					}
		
					$('#rmname').change(function() { }).multipleSelect({ width: '100%', filter: true });
					
					
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
				
				$('#parent_select_group').html('');//.first().append('<option value=""> -- ALL -- </option>');
				$('#parent_select_group').html('<div id="select_group" class="form-group text-left"><label class="label label-clear">BRANCH</label><select id="branchs" name="branchs" multiple="multiple" style="width: 130px;  margin-right: 5px;"></select></div>');
				for(var indexed in responsed['data']) {
					$('#branchs').append("<option value='"+responsed['data'][indexed]['BranchDigit']+"'>"+responsed['data'][indexed]['BranchDigit']+ ' - ' + responsed['data'][indexed]['BranchName']+"</option>");
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

    function fnLoadRMListByRegion() {
		
		$('#regions').on('change', function () { 

		  	var regionCode	= $("select[name='regions'] option:selected").val();			  
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
		
					$('#rmname').change(function() { }).multipleSelect({ width: '100%', filter: true });
		
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

    // Event: Change Branch
    fnLoadRMListByRegion();
	fnLoadRMList();

    $('#branchs').change(function() { }).multipleSelect({ width: '100%', filter: true });
    $('#rmname').change(function() { }).multipleSelect({ width: '100%' });
    $('#status').change(function() { }).multipleSelect({ width: '100%' });
    $('#defend_process').change(function() { }).multipleSelect({ width: '100%' });
    $('#defend_type').change(function() { }).multipleSelect({ width: '100%' });

});

</script>
