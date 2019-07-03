<style type="text/css">
	
	body { background-color: #FFF !important; }

	abbr { border:none; }
	
	input, select { 
		font-size: 0.9em;
		font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
 	}
 	
 	.metro .dropdown-toggle:after { visibility: hidden; }
	
	table#tbl_reconsiledoc tbody tr:hover  { color: red !important; }
	table#tbl_reconsiledoc th, td { font-size: 12px;  }	
	table#tbl_reconsiledoc tr td:first-child { text-align: center !important; display: none; }
	table#tbl_reconsiledoc tr td:nth-child(2) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(3) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(4) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(5) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(6) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(6) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(7) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(8) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(9) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(10) { text-align: center !important; }			
	table#tbl_reconsiledoc tr td:nth-child(11) { text-align: left !important; }
	table#tbl_reconsiledoc tr td:nth-child(12) { text-align: left !important; }
	table#tbl_reconsiledoc tr td:nth-child(13) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(14) { text-align: center !important; }
	
	.successes { background-color: #DFF0D8 !important; }
	.errors { background-color: #F2DEDE !important; }
	.waiting { background-color: #F2DEDE !important; }
	.brands { background-color: #4390DF; color: #FFF; }		
	.label-clear { background-color: #FFF !important; }
			
	#definded_status div, p { display: inline; }
	
	/* PROGRESS ICON: MODIFY STYLE */
	div#tbl_reconsiledoc_processing {
	    background-color: transparent;
	    margin-top: 10px;
	    margin-left: -250px !important;
	    width: 500px;
	}
	.metro .dataTables_wrapper .dataTables_processing {  box-shadow: none !important; }
	.dataTables_wrapper .dataTables_length select { height: auto !important; }
	th[class*="sort"]:after { content: "" !important; }
	.icon { cursor: pointer; }
		
	.modal-dialog:not(.modal-lg) {
		width: 80%;
		height: 100%;
  		margin: 0 auto;
		padding: 0;
	}
	
	.modal-content {
	  height: auto;
	  min-height: auto;
	  border-radius: 0;
	}
	
	.document_list {
	    width: 100%;
	    height: auto;
	    min-height: auto;
	    z-index: 150000;
	    position: absolute;
	    left: 0;
	    top: 0;
	    margin-left: 0px;
	    display: none;
	    min-height: 300px;
	    background-color: #FFF;
	    border: 1px solid #D1D1D1;
	    transition: 0.5s;
	}
		
</style>

<div id="contentation" style="margin-top: 70px;">

<header class="text-center">
	<h2>RECONCILE NCB CONSENT</h2>
	<div id="definded_status" class="row animated rubberBand">
	    <div><i class="fa fa-circle fg-yellow" style="font-size: 1.3em; cursor: pointer; margin-right: 5px;"></i></div> <p style="margin-left: 5px;">LB</p>
	    <div><i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.3em; cursor: pointer; margin-left: 10px; margin-right: 5px;"></i></div> <p style="margin-left: 5px;">HQ</p>
	    <div><i class="fa fa-circle" style="color: #60a917; font-size: 1.3em; cursor: pointer; margin-left: 10px; margin-right: 5px;"></i></div> <p style="margin-left: 5px;">OPER</p>
	    <div><i class="fa fa-circle fg-red" style="font-size: 1.3em; cursor: pointer;  margin-left: 10px;"></i></div> <p style="margin-left: 5px;">RETURN<p>
    </div>
</header>


<div class="grid">
<div id="application" class="row">

	<div id="tbl_content_reconsiledoc" class="table-responsive" style="padding: 0 20px;">

	<div id="element_hidden">
	
		<!-- Basic -->
	    <input id="inlineCheckbox_hidden" name="inlineCheckbox_hidden" type="hidden" value="">
	    <input id="views_hidden" name="views_hidden" type="hidden" value="">
	    <input id="startdate_hidden" name="startdate_hidden" type="hidden" value="">
	    <input id="enddate_hidden" name="enddate_hidden" type="hidden" value="">
	    <input id="hqdate_start_hidden" name="hqdate_start_hidden" type="hidden" value="">
	    <input id="hqdate_end_hidden" name="hqdate_end_hidden" type="hidden" value="">
	    
	    <input id="regions_hidden" name="regions_hidden" type="hidden" value="">
	    <input id="branchs_hidden" name="branchs_hidden" type="hidden" value="">
	    <input id="customer_hidden" name="customer_hidden" type="hidden" value="">
	    <input id="rmname_hidden" name="rmname_hidden" type="hidden" value="">

	</div>
	
	<div id="panel_reconsiledoc" class="panel" data-role="panel" style="width: 68%; float: right; margin-top: 10px; margin-bottom: 13px;">
		<div class="panel-header bg-lightBlue fg-white" style="font-size: 1.1em;"><i class="fa fa-search on-left"></i>FILTER CRITERIA</div>
		<div class="panel-content" style="display: none; float: right;">
		
			<div class="grid">
				<div class="row">
					 
					 <div class="place-right" style="margin-right: 20px;">
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
						   in_array('074006', $session_data['auth']) || in_array('074007', $session_data['auth']) || in_array('074008', $session_data['auth'])) {
							echo '<div class="input-control select size3" style="height: 34px; max-width: 170px;">
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
		
							echo '<div id="parent_select_group" class="input-control select size3" style="margin-left: 4px;">
		    					  <div id="select_group" class="form-group" style="height: 34px; max-width: 170px;">
				                  	<label class="label label-clear">BRANCH</label>
					              	<select id="branchs" name="branchs" multiple="multiple" style="width: 130px;  margin-right: 5px;" class="text-left">';
										
									foreach($AreaBoundary['data'] as $index => $values) { echo '<option value="'.$values['BranchDigit'].'">'.$values['BranchDigit'].' - '.$this->effective->get_chartypes($char_mode, $values['BranchName']).'</option>'; }
									
							echo	'</select>
								  </div>
								  </div>';
							
						}
						
						?>
						
						<div id="parent_select_rmlist" class="input-control select size3" data-role="input-control" style="height: 34px; max-width: 170px; margin-left: -50px;">
							<div id="rmselect_group" class="form-group text-left">
								<label class="label label-clear">EMP. NAME</label>
								<select id="rmname" name="rmname" multiple="multiple"></select>
							</div>
						</div>	

					 </div>
					 
					 <div class="row place-right" style="margin-right: 20px;">
					 				
						<div class="input-control text size3 text-left" id="datestarter" style="height: 34px; max-width: 170px;">
							<label class="label label-clear">NCB DATE</label>
							<input id="ncb_date" name="ncb_date" type="text" value="">
						</div>
	
						<div class="input-control text size3 text-left" id="hqdatestarter" style="height: 34px; max-width: 170px;">
							<label class="label label-clear">HQ RECEIVED DATE</label>
							<input id="hqreceived_date" name="hqreceived_date" type="text" value="">
						</div>
				
						<div class="input-control text size3 text-left" style="height: 34px; max-width: 170px;">
							<label class="label label-clear">CUSTOMER</label>
							<input id="customer" name="customer" type="text" value="">
						</div>						
									
			    	</div>
					
				</div>
				
				<div class="place-right" style="margin-top: 25px; margin-right: 20px; clear: both;">
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

	<section style="float: right; margin-top: 22px; margin-right: 10px;">	
	
		<span data-role="input-control" style="margin-right: 10px;" data-hint="กดเพื่อ refresh หน้า" data-hint-position="top" width="3%">
			<a id="refresh_pages" href="#" class="fg-lightBlue"><i class="fa fa-refresh on-left"></i> 
			<span>REFRESH</span></a>
		</span>
        
     </section>

	<div id="showNumRecord" style="position: absolute; float: left; margin-top: 40px; font-size: 0.9em;"></div>
	
	<input type="hidden" name="actor" id="actor" value="<?php echo !empty($session_data['thname'])? $session_data['thname']:""; ?>">
    <table id="tbl_reconsiledoc" class="table bordered hovered" style="width: 100%;">
            <thead>
            	<tr class="brands">
            		<th rowspan="2" width="3%" style="display: none;">DOC ID</th>
            		<th colspan="7" width="45%">NCB</th>
            		<th colspan="4" width="50%">INFORMATION</th>
            		<th rowspan="2" width="2%">UPDATE</th>
            		<th rowspan="2" width="2%">LINK</th>
            	</tr>
	            <tr class="brands">
	            	<th>DATE</th>
	            	<th><i class="fa fa-flag-o" style="font-size: 1.1em;"></i></th>
	            	<th width="5%;"><i class="fa fa-laptop"></i></th>
					<th>LB <i class="fa fa-arrow-right on-left on-right"></i> HQ</th>
					<th><i class="fa fa-inbox on-left"></i> HQ RECEIVED</th>
					<th>HQ <i class="fa fa-arrow-right on-left on-right"></i> OPER</th>
					<th width="5%;" data-hint="Document Return|มีการตีคืนเอกสาร (ถ้ามี ระบบจะแสดงสถานะไฟสีแดง)" data-hint-position="top"><i class="fa fa-retweet on-left on-left"></i>R</th>
					<th width="5%;">LB</th>
					<th width="5%;">TYPE</th>
	                <th width="15%;">CUSTOMER</th>
	                <th width="15%;">RM NAME</th>
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

<!-- Start Modal -->
<div id="myModal" class="modal fade nonprint" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: none;"><span aria-hidden="true">&times;</span></button>
                <h4 id="docModalLabel" class="modal-title">NCB CONSENT</h4>
            </div>
            <div class="modal-body">
          
                <section class="form_container" style="clear: both; padding-right: 30px;">                                  
                    <table id="ncbconsnet_modalmanagement" class="table bordered hovered" style="width: 100%; min-width: 100%;">
                        <thead>
                           <tr class="brands">
                           	  <th align="center" width="110px;">TYPE</th>
	                          <th align="center">NAME - SURNAME</th>
	                          <th align="center">NCB</th>
	                          <th align="center">CHECK NCB</th>
	                          <th align="center">LB <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
	                          <th align="center"><i class="fa fa-inbox on-left"></i> HO RECEIVED</th>
	                          <th align="center">HO <i class="fa fa-arrow-right on-right on-left"></i> OPER</th>
	                          <th align="center">OPER RETURN</th>
	                    	</tr>
                        </thead>
                        <tbody></tbody>
                    </table>    
                    <div id="ncbload_progress"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span>Loading...</span></div>
               </section>             		                             
            </div>
            <div class="modal-footer">    	
              	<button id="document_closeModal" type="button" class="btn btn-primary" onclick="$('#myModal').modal('hide'); ">CLOSE</button>                        	
	            <button id="document_AcceptModal" type="button" class="btn bg-lightBlue fg-white" style="margin-right: 30px;">SAVE</button>
            </div>
		</div>
	</div>
</div>
<!-- End Modal -->

<script type="text/javascript">

$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

    $('#fttab').remove();
	$('title').text('NCB Consent Management');
    
    new Kalendae.Input('ncb_date', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});

    new Kalendae.Input('hqreceived_date', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});
  
    var table = $('#tbl_reconsiledoc').dataTable({
    	"processing": true,
	    "serverSide": true,
	    "bFilter": false,
	    "oLanguage": {
	    	"sProcessing": '<img src="' + window.location.protocol + "//" + window.location.host + '/pcis/img/378_1.gif"' + '>'
        },
	    "ajax": {
	    	 "url": pathFixed + 'reconcile/getDataNCBConsent?_=' + new Date().getTime(),
	         "type": "POST",
	         "data": function(d) {	        	 	
		    
			        d.modes			= $('input[name="viewmode"]:checked').val();
			        d.ncb_start 	= $('#startdate_hidden').val();
			        d.ncb_end   	= $('#enddate_hidden').val();
			        d.hq_start 		= $('#hqdate_start_hidden').val();
			        d.hq_end   		= $('#hqdate_end_hidden').val();
		      	    
			        d.regions		= $('#regions_hidden').val();
			        d.branchs		= $('#branchs_hidden').val();
			        d.customer 		= $('#customer_hidden').val();
		         	d.rmname		= $('#rmname_hidden').val();
		         	d.views			= $('input[name="inlineCheckbox"]:checked').val();
		         	
	         },
	         "complete":function(data, callback) {
		         
		         $('#showNumRecord').text($('#tbl_reconsiledoc_info').text());
	             $('#tbl_reconsiledoc_info').css('visibility', 'hidden');

	             $('#tbl_reconsiledoc tbody tr').each(function(e) {
		             
	                	var objRow = $(this).find('td:nth-child(5), td:nth-child(6), td:nth-child(7)');
						if(objRow[0].innerHTML != ""  && objRow[1].innerHTML != '' && objRow[2].innerHTML != '') {
							$(this).addClass('successes');

						}	
						
	             });

	          	// UI Holding
                $('#panel_reconsiledoc > .panel-content').hide(500, function() {
                    $(this).css('display', 'none');
                });

                $('#tbl_reconsiledoc').find('tbody > tr').addClass('animated fadeIn');
		         
	         }
	    },
	    "columns": [
			{ "data": "DocID" },
			{ "data": "NCBCheckDate" },
			{ "data": "DAY" },
			{ "data": "NCBCheck" },
			{ "data": "SubmitToHQ" },
			{ "data": "HQReceivedFromLB" },
			{ "data": "HQSubmitToOper" },
			{ "data": "OperReturn" },
			{ "data": "BranchDigit" },
			{ "data": "BorrowerType" },
			{ "data": "BorrowerName" },
			{ "data": "RMName" },
			{ "data": "NCBTools" },
			{ "data": "Links" }
	     ],       
	     "columnDefs": [
	        { "visible": true, "targets": 2, 'bSortable': false},
	        { "visible": true, "targets": 3, 'bSortable': false},
	        { "visible": true, "targets": 7, 'bSortable': false},
	        { "visible": true, "targets": 12, 'bSortable': false}
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
			$('#parent_select_rmlist').html('<div id="rmselect_group" class="form-group text-left" style="height: 34px; max-width: 170px;"><label class="label label-clear">EMP. NAME</label><select id="rmname" name="rmname" multiple="multiple" class="text-left" style="width: 130px;"></select></div>');
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

    $('#regions').on('change', function () { 

  	   var rgnidx	= $("select[name='regions'] option:selected").val();
  	   if(rgnidx != undefined || rgnidx != '') {

  		   $.ajax({
  				url: pathFixed+'dataloads/branchBoundary?_=' + new Date().getTime(),
  				type: "POST",
  				data: { rgnidx:rgnidx },
  				success:function(responsed) {
  					
  					$('#parent_select_group').html('');//.first().append('<option value=""> -- ALL -- </option>');
  					$('#parent_select_group').html('<div id="select_group" class="form-group text-left" style="height: 34px; max-width: 170px;"><label class="label label-clear">BRANCH</label><select id="branchs" name="branchs" multiple="multiple" style="width: 130px;"></select></div>');
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
	fnLoadRMList();

    $('#branchs').change(function() { }).multipleSelect({ width: '100%', filter: true });
    $('#rmname').change(function() { }).multipleSelect({ width: '100%' });

    $('select[name="tbl_reconsiledoc_length"]').prepend('<option value="10">10</option>');

    
    $('#filterSubmit').click(function () { 
		
    	$('#inlineCheckbox_hidden').val('');
    	$('#views_hidden').val('');
    	$('#startdate_hidden').val('');
    	$('#enddate_hidden').val('');
    	$('#hqdate_start_hidden').val('');
    	$('#hqdate_end_hidden').val('');
 	    
    	$('#regions_hidden').val('');
    	$('#branchs_hidden').val('');
    	$('#customer_hidden').val('');
    	$('#rmname_hidden').val('');


    	var ncb_date	= $('#ncb_date').val();
		var hq_received = $('#hqreceived_date').val();
		
		var regions		= $('select[name="regions"] option:selected').val();
	    var branchs		= $('#branchs').val();
		var rmname		= $('#rmname').val();
        var customer 	= $('#customer').val();
        var views		= $('input[name="inlineCheckbox"]:checked').val();
        var modes		= $('input[name="viewmode"]:checked').val();

        var pattern 	= new RegExp("-");

 	   var objncb_date  = pattern.test(ncb_date);
 	   var objhq_date	= pattern.test(hq_received);

 	   var ncbstart_sdate   = '',
	   	   ncbend_edate 	= '',
	       hqreceived_sdate	= '',
	       hqreceived_edate	= '';

 	  if(objncb_date) {
		   var item   	    	 = ncb_date.split("-");
		   ncbstart_sdate    	 = item[0].trim();
		   ncbend_edate	   		 = item[1].trim();

	   } else { ncbstart_sdate   = ncb_date }

	   if(objhq_date) {
		   var item   	    	 = hq_received.split("-");
		   hqreceived_sdate 	 = item[0].trim();
		   hqreceived_edate		 = item[1].trim();

	   } else { hqreceived_sdate = hq_received }
		
    	$('#inlineCheckbox_hidden').val(views);
    	$('#views_hidden').val(modes);
    	$('#startdate_hidden').val(ncbstart_sdate);
    	$('#enddate_hidden').val(ncbend_edate);
    	$('#hqdate_start_hidden').val(hqreceived_sdate);
    	$('#hqdate_end_hidden').val(hqreceived_edate);
 	    
    	$('#regions_hidden').val(regions);
    	$('#branchs_hidden').val(branchs);
    	$('#customer_hidden').val(customer);
    	$('#rmname_hidden').val(rmname);
				
        table.fnFilter($(this).val()); 
        
    });
    
    $('#filterClear').click(function() {

    	$('#inlineCheckbox1').prop( "checked", true );
		$('input[name="inlineCheckbox"]:checked').val('Active');

    	$('#ncb_date').val("");
		$('#hqreceived_date').val("");
		$('#customer').val("");
		$('#rmname').val("");
		$('#regions').val('');
		$('#branchs').val('');
		$('.ms-choice > span').text('');
		$('input[name="selectItembranchs"]').prop('checked', false);

		fnLoadBranch();

	});

	function fnFilterClear() {
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
					$('#parent_select_rmlist').html('<div id="rmselect_group" class="form-group text-left" style="height: 34px; max-width: 170px;"><label class="label label-clear">EMP. NAME</label><select id="rmname" name="rmname" multiple="multiple" style="width: 130px;" class="text-left"></select></div>');
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
				$('#parent_select_group').html('<div id="select_group" class="form-group text-left" style="height: 34px; max-width: 170px;"><label class="label label-clear">BRANCH</label><select id="branchs" name="branchs" multiple="multiple" style="width: 130px;"></select></div>');
				for(var indexed in responsed['data']) {
					$('#branchs').append("<option value='"+responsed['data'][indexed]['BranchDigit']+"'>"+responsed['data'][indexed]['BranchDigit']+ ' - ' + responsed['data'][indexed]['BranchName']+"</option>");
				}

				$('#branchs').change(function() { console.log($(this).val()); }).multipleSelect({ width: '100%', filter: true });
				
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
	
    $('#refresh_pages').on('mouseover', function() { $('#refresh_pages i').addClass('fa-spin'); });
    $('#refresh_pages').on('mouseout', function() { $('#refresh_pages i').removeClass('fa-spin'); });
    $('#refresh_pages').click(function() { table.fnFilter($(this).val()); });
 	
});

function openModalComponent(_coderef) {
	var role = $('#emp_role').val();
	if(_coderef) {
		
		$.ajax({
		   	url: pathFixed + 'dataloads/getNCBConsentByPerson?_=' + new Date().getTime(),
		   	type: "POST",
		   	data: { idx: _coderef },
		   	beforeSend:function() {

		   		$('#ncbload_progress').show();
		   		$('#ncbconsnet_modalmanagement > tbody').empty();
		   		$('#myModal').modal({
			   		show: true,
			   		keyboard: false,
			   		backdrop: 'static'		                        		
			   	});
			   	
		   	},
		   	success:function(resp) {

				var data = (resp.data) ? resp.data:null;
				var template = ncbTemplate_Render(data);
				setTimeout(function() {
					$('#ncbconsnet_modalmanagement > tbody').html(template);
					$('#ncbload_progress').hide();

					if(in_array(role, ['dev_role', 'admin_role'])) {
						//$('#parent_ncbdate').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
						$('#parent_lb2hodate').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
				        $('#parent_horeceiveddate').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
						$('#parent_ho2cadate').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
					}
					
				}, 500);
				
		   	},
		   	complete:function() {},				
		   	cache: false,
		   	timeout: 10000,
		   	statusCode: {
		   		404: function() { console.log("page not found."); },
		   		407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); },
		   		500: function() { console.log("internal server error."); }
		   	}    	   	        
		});
		
	}
	
}

function ncbTemplate_Render(data) {
	var html = '';

	var objects = (data[0]) ? data[0]:null;
	
	var masterdata = {};
	masterdata['borrower'] = [
		{ id: '101', name: 'ผู้กู้หลัก' },
		{ id: '102', name: 'ผู้กู้ร่วม' },
		{ id: '103', name: 'อื่นๆ (Doc)' },
		{ id: '104', name: 'อื่นๆ' }
	];

	masterdata['ncbstate'] = [
		{ id: '1', name: 'ผ่าน' },
		{ id: '2', name: 'ไม่ผ่าน' },
		{ id: '3', name: 'Deviate' }
	]

	if(data) {

		var select_opt = '';
		var select_ncb = '';
		if(masterdata.borrower && masterdata.borrower.length > 0) {
			$.each(masterdata.borrower, function(index, value) {
				if(objects.BorrowerType == value.id) var select_optmatch = 'selected="selected"';
				else var select_optmatch = '';
				
				select_opt += '<option value="' + value.id + '" ' + select_optmatch + '>' + value.name + '</option>';
			})
		}

		if(masterdata.ncbstate && masterdata.ncbstate.length > 0) {
			$.each(masterdata.ncbstate, function(index, value) {
				if(objects.NCBCheck == value.id) var select_optmatch = 'selected="selected"';
				else var select_optmatch = '';
				
				select_ncb += '<option value="' + value.id + '">' + value.name + '</option>';
			})
		}

		var lock_field = '';
		var user_roles = $('#emp_role').val();
		if(in_array(user_roles, ['dev_role', 'admin_role'])) {
			lock_field = '';
		} else {
			lock_field = 'disabled';
			$('#document_AcceptModal').hide();
		}

		var check_ncbconsent = (objects.NCBCheckDate) ? objects.NCBCheckDate:'';
		var check_ncbmark 	 = (objects.NCBCheckDate) ? 'checked="checked"':'';

		var check_lb2ho		 = (objects.SubmitToHQ) ? objects.SubmitToHQ:'';
		var check_lb2homark  = (objects.SubmitToHQ) ? 'checked="checked"':'';

		var check_horeceieve = (objects.HQReceivedFromLB) ? objects.HQReceivedFromLB:'';
		var check_horecmark  = (objects.HQReceivedFromLB) ? 'checked="checked"':'';

		var check_ho2ca 	 = (objects.HQSubmitToOper) ? objects.HQSubmitToOper:'';
		var check_ho2camark  = (objects.HQSubmitToOper) ? 'checked="checked"':'';

		var check_returnlogs = (objects.OperReturnDate) ? objects.OperReturnDate:'';
		
		html = '<tr>' +
					'<td>'+
						'<div class="input-control select">' +
							'<select id="ncb_borrowertype" name="ncb_borrowertype" disabled style="background: #EBEBE4;">' + select_opt + '</select>' +
						'</div>' +
					'</td>'+
					'<td>'+
						'<div class="input-control text">' +
							'<input id="ncb_indexcode" name="ncb_indexcode" type="hidden" value="' + objects.NCS_ID + '">' +
							'<input id="ncb_docid" name="ncb_docid" type="hidden" value="' + objects.DocID + '">' +
							'<input id="ncb_verifyid" name="ncb_verifyid" type="hidden" value="' + objects.VerifyID + '" disabled>' +
							'<input id="ncb_isref" name="ncb_isref" type="hidden" value="' + objects.IsRef + '">' +
			            	'<input id="ncb_borrowername" name="ncb_borrowername" type="text" value="' + objects.BorrowerName + '" disabled>' +
				         '</div>' +
					'</td>'+
					'<td>'+
						'<div class="input-control select">' +
							'<select id="ncb_statetype" name="ncb_statetype" disabled style="background: #EBEBE4;">' + select_ncb + '</select>' +
						'</div>' +
					'</td>'+
					'<td>'+
						'<div class="input-control checkbox" data-role="input-control" style="position:absolute; margin-left: 5px; margin-top: 2px; z-index: 999;">' +
					        '<label>' +
					            '<input id="ncb_checkdate_checkbox" type="checkbox" ' + check_ncbmark + ' disabled>' +
					            '<span class="check"></span>' +
					        '</label>' +
				   	 	'</div>' +
				        '<div id="parent_ncbdate" class="input-control text" style="width: 120px;">' +
				            '<input id="ncb_checkdate" name="ncb_checkdate" type="text" value="' + check_ncbconsent + '" disabled style="padding-left: 30px;">' +
				        '</div>' +
					'</td>'+
					'<td>'+
						'<div class="input-control checkbox" data-role="input-control" style="position:absolute; margin-left: 5px; margin-top: 2px; z-index: 999;">' +
					        '<label>' +
					            '<input id="lb2ho_checkbox" type="checkbox" onclick="GenDateValidator(\'lb2ho_checkbox\', \'lb2ho_checkdate\');"  ' + check_lb2homark + ' ' + lock_field + '>' +
					            '<span class="check"></span>' +
					        '</label>' +
				   	 	'</div>' +
				        '<div id="parent_lb2hodate" class="input-control text" style="width: 120px;">' +
				            '<input id="lb2ho_checkdate" name="lb2ho_checkdate" type="text" value="' + check_lb2ho + '" ' + lock_field + ' style="padding-left: 30px;">' +
				        '</div>' +
					'</td>'+
					'<td>'+
						'<div class="input-control checkbox" data-role="input-control" style="position:absolute; margin-left: 5px; margin-top: 2px; z-index: 999;">' +
					        '<label>' +
					            '<input id="horeceived_checkbox" type="checkbox" onclick="GenDateValidator(\'horeceived_checkbox\', \'horeceived_checkdate\');" ' + check_horecmark + ' ' + lock_field + '>' +
					            '<span class="check"></span>' +
					        '</label>' +
				   	 	'</div>' +
				        '<div id="parent_horeceiveddate" class="input-control text" style="width: 120px;">' +
				            '<input id="horeceived_checkdate" name="horeceived_checkdate" type="text" value="' + check_horeceieve + '" ' + lock_field + ' style="padding-left: 30px;">' +
				        '</div>' +
					'</td>'+
					'<td>'+
						'<div class="input-control checkbox" data-role="input-control" style="position:absolute; margin-left: 5px; margin-top: 2px; z-index: 999;">' +
					        '<label>' +
					            '<input id="ho2ca_checkbox" type="checkbox" onclick="GenDateValidator(\'ho2ca_checkbox\', \'ho2ca_checkdate\')" ' + check_ho2camark + ' ' + lock_field + '>' +
					            '<span class="check"></span>' +
					        '</label>' +
				   	 	'</div>' +
				        '<div id="parent_ho2cadate" class="input-control text" style="width: 120px;">' +
				            '<input id="ho2ca_checkdate" name="ho2ca_checkdate" type="text" value="' + check_ho2ca + '" ' + lock_field + ' style="padding-left: 30px;">' +
				        '</div>' +
					'</td>'+
					'<td>'+
				        '<div class="text-center">' + check_returnlogs + '</div>' +
					'</td>'+
			   '</tr>';
		
	} else {
		html = '<tr><td colspan="7" class="text-center">ไม่พบข้อมูล</td></tr>';
	}

	return html;
	
}

$('#document_AcceptModal').on('click', function() {

	if(confirm('ยืนยันการบันทึกข้อมูล')) {
		
		var code_ref = $('#ncb_indexcode').val();
		var doc_id 	 = $('#ncb_docid').val();
		var bverify	 = $('#ncb_verifyid').val();
		var bname 	 = $('#ncb_borrowername').val();
		var btype 	 = $('#ncb_borrowertype option:selected').val();
		var ncb_type = $('#ncb_statetype option:selected').val();
		var ncbcheck = $('#ncb_checkdate').val();
		var lb2ho 	 = $('#lb2ho_checkdate').val();
		var hogetdoc = $('#horeceived_checkdate').val();
		var ho2ca 	 = $('#ho2ca_checkdate').val();
		var bisref 	 = $('#ncb_isref').val();

		$.ajax({
        	url: pathFixed + 'dataloads/setNCBConsentManagement?_=' + new Date().getTime(),
            type: 'POST',
			data: {
				ncsx: code_ref,
				docx: doc_id,
				verx: bverify,				
				bname: bname,
				btype: btype,
				bstate: ncb_type,
				ncbdate: (ncbcheck) ? ncbcheck:'',
				lb2ho: (lb2ho) ? lb2ho:'',
				hodoc: (hogetdoc) ? hogetdoc:'',
				ho2ca: (ho2ca) ? ho2ca:'',
				isref: (bisref) ? bisref:''
			},
            success:function(resp) {

				if(resp.status) {
					 var not = $.Notify({
						 content: "Save Successfully",
						 style: { background: 'green', color: 'white' },
						 timeout: 10000
					 });

					 not.close(3000);
					 
				} else {
					 var not = $.Notify({
						 content: "Save failed, Please try again or contact mis team",
						 style: { background: 'red', color: 'white' },
						 timeout: 10000
					 });

					 not.close(3000);					 
				}

				$('#myModal').modal('hide');
				
            },
            complete:function() {},
            cache: false,
            timeout: 5000,
            statusCode: {
            	404: function() { console.log('page not found.'); },
                407: function() { console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )'); },
                500: function() { console.log('internal server error.'); }
			}
		});

	}

	return false;
	
});

function GenDateValidator(id, bundled) {
	var str_date;
    var objDate = new Date();
    str_date = ('0' + objDate.getDate()).slice(-2) + '/' + ('0' + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
    var elements =  $('#' + id).is(':checked');
    if(elements) {
        $('#' + bundled).val(str_date);
    } else {
        $('#' + bundled).val('');
    }
}

function objectFindByKey(array, fieldname, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][fieldname] === value) {
            return array[i];
        }
    }
    return null;
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

</script>