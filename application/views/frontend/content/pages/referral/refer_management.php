<style>
	
	
	table th, td { font-size: 0.95em !important; }
	table tbody tr:hover { color: red !important; }	
	table#referral_management th {
		color: #FFF;
		font-weight: 700; 
		text-align: center;
		background-color: #4390DF; 		
		border: 1px solid #D1D1D1;		
	}
	
	table#referral_management tr td:nth-child(1),
	td:nth-child(2), td:nth-child(3), td:nth-child(4), td:nth-child(6), td:nth-child(10), 
	td:nth-child(12), td:nth-child(13) { text-align: center !important; }
	
	table#referral_management tr td:nth-child(2) { background: #EBF5FF; }
	
	table#referral_management tr td:nth-child(5),
	td:nth-child(7), td:nth-child(8), td:nth-child(9), td:nth-child(11)  { text-align: left !important; }
	
	th[class*="sort"]:after {
		content: "" !important;
	}
	
	.field_scale { 
		width: 400px;
		margin-top: 10px; 
		margin-bottom: 10px; 
	}
	
	.window.shadow {
		top: 5px !important;  
		max-width: 700px; 
	}
	.label { 
		width: 150px !important; 
		background-color: #FFF !important;
	}
	
	#ui_notifIt.success, #ui_notifIt.error { margin-top: -8px; }		
	#ui_notifIt.success > p, #ui_notifIt.error > p { color: #FFF !important; font-weight: bold; }	
	
	/* PROGRESS ICON: MODIFY STYLE */
	div#referral_management_processing {
	    background-color: transparent;
	    margin-top: 10px;
	    margin-left: -200px !important;
	    width: 500px;
	}
	
	.icon_set { cursor: pointer; }	
	/*.ms_autoClose { position: fixed; background-color: #FFF; z-index: 1055; width: auto; }*/
	.metro .dataTables_wrapper .dataTables_processing {  box-shadow: none !important; }
	
	.ms-parent.size5 { max-width: 365px;}

	div#mslist_edit_bank > .ms_autoClose {
	    width: 140px;
	}
	
	textarea { max-height: 50px !important; }

</style>
<div class="grid">
    <div class="row">
    
    	<header class="text-center animated rubberBand ">
			<h2>TL MANAGEMENT</h2>
		</header>
		
		<span style="position: absolute; right: 10px; margin-top: -27px;">
			<span class="text-bold">Expired of definition : </span>
			<span class="fg-amber text-bold">ID Card Expired,</span>
			<span class="fg-darkBlue text-bold">TL Card Expired,</span>
			<span class="fg-red text-bold">Both Expired</span>
		</span>
    	
    	<input id="AuthCode" name="AuthCode" type="hidden" value="<?php echo implode(',', $session_data['auth']); ?>">
		<input id="Emp_ID" name="Emp_ID" type="hidden" value="<?php echo $session_data['emp_id']; ?>">
		<input id="Region_ID" name="Region_ID" type="hidden" value="<?php echo $session_data['region_id']; ?>">
		<input id="BranchCode" name="BranchCode" type="hidden" value="<?php echo $session_data['branchcode']; ?>">
		
		<div id="panel_criteria" class="panel" data-role="panel" style="width: 60%; float: right; margin-bottom: 13px; margin-top: 10px;">
			<div class="panel-header fg-white" style="font-size: 1.1em; background-color: #4390DF;"><i class="fa fa-search"></i> FILTER CRITERIA</div>
			<div class="panel-content" style="display: none;">
			
				<div class="grid">
					<div class="row" style="padding-left: 4%;">      
						<div class="input-control text span2"> 
	         				<label class="label">JOIN DATE</label> 
	         				<input id="register_date" name="register_date" type="text" value="" class="size2"> 
	         				<input id="start_date" name="start_date" type="hidden" value="" class="size2">
	         				<input id="end_date" name="end_date" type="hidden" value="" class="size2">
	         			</div> 	       	
		                <div class="input-control text span2" style="margin-left: 10px;"> 
		             	    <label class="label">REF CODE</label> 
		             	    <input id="tl_code" name="tl_code" type="text" value="" class="size2" onkeypress="validate(event)" maxlength="8"> 
		             	</div> 		                    		
		             	<div class="input-control text span2" style="margin-left: 10px;"> 
		             		<label class="label">NAME-SURNAME</label> 
		             		<input id="tl_name" name="tl_name" type="text" value="" class="size2"> 
		             	</div> 
		             	<div class="input-control select span2" style="margin-left: 10px;"> 
		         			<label class="label">TL POSITION</label> 
		         			<select id="tl_position" name="tl_position" multiple="multiple" class="size2" style="height: 34px;"></select> 
	         			</div> 	
	         			
	         			<div class="input-control select span2" style="margin-left: 10px;"> 
		         			<label class="label">TL BRANCH</label> 
		         			<select id="tl_branch" name="tl_branch" multiple="multiple" class="size2" style="height: 34px;"></select> 
	         			</div>
	         					             	             		   
	             	</div>         		
	            	<div class="row" style="padding-left: 4%;">      
	            	    
	            	    <div class="input-control select span2" style="margin-right: 10px;"> 
	             			<label class="label">SPECIAL STATUS</label> 
	             			<select id="tl_status" name="tl_status" multiple="multiple" class="size2" style="height: 34px;"> 	             				
	             				<option value="New">New</option> 
	             				<option value="Pending">Pending</option> 
	             				<option value="Cancel by TL">Cancel by TL</option> 
	             				<option value="Terminate">Terminate</option> 
	             			</select> 
	             		</div>  
	                  	
	            	    <?php  
	            	    if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' ||
	            	    		in_array('074006', $session_data['auth']) ||
	            	    		in_array('074007', $session_data['auth']) ||
	            	    		in_array('074008', $session_data['auth'])) {
	            		?>
		            	<div class="input-control select span2"> 
			     			<label class="label">REGION</label> 
			     			<select id="lb_region" name="lb_region" class="size2" style="height: 34px;"></select> 
			     		</div> 	
			     		
			     		<?php } ?>
			     	
			     		<?php 
			     		
			     		if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' ||
			     		   in_array('074004', $session_data['auth']) ||
			     		   in_array('074005', $session_data['auth']) ||
			     		   in_array('074006', $session_data['auth']) ||
			     		   in_array('074007', $session_data['auth']) ||
			     		   in_array('074008', $session_data['auth'])) {
			     		
			     		?>
			       		<div class="input-control select span2" style="margin-left: 10px;"> 
			       			<label class="label">LENDING BRANCH</label> 
			       			<select id="lb_branch" name="lb_branch" multiple="multiple" class="size2" style="height: 34px;"></select> 
						</div> 	
								       
		            	<div class="input-control select span2" style="margin-left: 10px;"> 
		        			<label class="label">ASSIGNMENT</label> 
		        			<select id="lb_bm" name="lb_bm" multiple="multiple"  class="size2" style="height: 34px;"></select> 
		    			</div> 	
		    			<?php } ?>
		    			<!-- 
		    			<div class="input-control select span2" style="margin-left: 10px;"> 
		        			<label class="label">RM</label> 
		        			<select id="lb_rm" name="lb_rm" multiple="multiple" class="size2" style="height: 34px;"></select>
		    			</div> 
		    			 -->         		
		        	</div> 
		        	
		        	<div class="place-left">
	    				<div class="input-control checkbox marginLeft30">
	    					<label>
	    						<input id="status_main_1" name="status" type="checkbox" value="Active">
	    						<span class="check"></span> Active
	    					</label>
	    				</div>
	    				<div class="input-control checkbox marginLeft10">
	    					<label>
	    						<input id="status_main_3" name="status" type="checkbox" value="Active_DD">
	    						<span class="check"></span> Active (DD)
	    					</label>
	    				</div>
	    				<!-- 
	    				<div class="input-control checkbox marginLeft10">
	    					<label>
	    						<input id="status_main_2" name="status" type="checkbox" value="Inactive">
	    						<span class="check"></span> Inactive
	    					</label>
	    				</div>
	    				-->
	    			</div>
		    		
		    		<div class="place-right" style="margin-right: 4.5%; margin-bottom: 10px;"> 
		    			
			    		<button class="bg-lightBlue fg-white" style="padding: 7px;" onclick="reloadDataGrid();"> 
			    	    	<i class="fa fa-search on-left"></i> 
			    	    	SEARCH 
		    	    	</button> 	  
		    	    	<button type="button" id="filterClear" class="bg-green fg-white" style="height: 33px;">CLEAR</button>  	
		    	    		
		    		</div>
				
				</div> 

			</div>			
		</div>

		<?php 
		$authoriy_tl = $this->config->item('TLAgentTeam');
		if(in_array($session_data['emp_id'], $authoriy_tl)) {
		?>		
		<section class="animated fadeInRight" style="float: right; margin-top: 15px; margin-right: 10px;">	
			<span><i id="add_employee" class="fa fa-user-plus fa-2x fg-green on-left icon_set"></i></span>		        
		</section>
		<?php } ?>
		 
		<div id="showNumRecord" style="position: absolute; float: left; margin-top: 40px; font-size: 0.9em;"></div>
		
		<section style="float: right; margin-top: 25px; margin-right: 10px;">	

			<span data-role="input-control" style="margin-right: 10px;" data-hint="Refresh Page" data-hint-position="top" width="3%">
				<a id="refresh_pages" href="#" class="fg-lightBlue"><i class="fa fa-refresh on-left"></i> 
				<span>REFRESH</span></a>
			</span>
		        
		</section>
				
    	<div class="table-responsive">
    		<table id="referral_management" class="table bordered hovered sthiped">
    			<thead>
    				<tr>
    					<th colspan="8">THAI LIFE AGENT INFOMATION</th>
    					<th colspan="4">LENDING BRANCH</th>
    					<th rowspan="2">EDIT</th>
    				</tr>
    				<tr>
    					<!-- TLA -->
    					<th>JOIN DATE</th>
    					<th>PERIOD</th>
    					<th>STATUS</th>
	    				<th>REF CODE</th>
	    				<th>NAME-SURNAME</th>
	    				<th>MOBILE</th>
	    				<th>TITLE</th>
	    				<th>BRANCH</th>
	    				<!-- LB -->
	    				<th>REGION</th>
	    				<th>LB</th>
	    				<th width="180">ASSIGNMENT</th> 	
	    				<th>LAST UPDATE</th>	
	    			</tr>
    			</thead>
    			<tbody>
    			
    			</tbody>
    		</table>
		</div>
	</div>

	<div class="bottom-menu-wrapper marginTop20">
		<?php echo $footer; ?>
	</div>
	
</div>

<script type="text/javascript">

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }	

var str_date;
var objDate = new Date();
str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear(); // Set Date format DD/MM/YYYY

// BINDING EVENT
new Kalendae.Input('register_date', {
	months:2,
	mode:'range',
	format: 'DD/MM/YYYY',
	useYearNav: true
});

var tla_progress = $('#referral_management');
var table = tla_progress.dataTable({
	"processing": true, 
    "serverSide": true,
    "oLanguage": {
        "sProcessing": '<img src="' + window.location.protocol + "//" + window.location.host + '/pcis/img/378_1.gif"' + '>'
    },
    "bFilter": false,
    "ajax": {
        "url": pathFixed + 'referral_control/getTLADataComponent',
        "type": "POST",
        "data": function(d) {
        	d.start_date  	= $('#start_date').val();
        	d.end_date    	= $('#end_date').val();        	
        	d.tl_code 	  	= $('#tl_code').val();
        	d.tl_name 	  	= $('#tl_name').val();
        	d.tl_branch   	= $('#tl_branch').val();         	
        	d.tl_status   	= $('#tl_status').val(); 
        	d.tl_state_main	= $('input[name^="status"]:checked').map(function(){ return this.value; }).get();
        	d.tl_position 	= $('#tl_position').val();
        	d.lb_region   	= $('#lb_region').val(); 
        	d.lb_branch   	= $('#lb_branch').val();
			//d.lb_rm 	  	= $('#lb_rm').val();
			d.lb_bm		  	= $('#lb_bm').val();
        },
        "complete":function(data, callback) {
        	//cloneToTop('referral_management_info', 'showNumRecord')
        	$('#showNumRecord').text($('#referral_management_info').text()); //.toLowerCase()
        	$('#referral_management_info').css('visibility', 'hidden');

        	// UI Hidden
        	$('#panel_criteria > .panel-content').hide(500, function() {
        	    $(this).css('display', 'none');
        	});

        	//$('#referral_management').find('tbody > tr').addClass('animated fadeIn');
		
        },
        'timeout': 15000,
	},
    "columns": [
        { "data": "JoinDate" },
        { "data": "Period" },
        { "data": "Seq" },
        { "data": "TLA_Code" },
        { "data": "TLA_Name" },
        { "data": "TLA_Mobile" },
        { "data": "TLA_Position" },
        { "data": "TLA_Branch" },
        { "data": "RegionNameEng" },         	
        { "data": "BranchDigit" },
        { "data": "BMName" },
        { "data": "LastUpdate" },
        { "data": "Editor" }
     ],         
    "columnDefs": [
        { "visible": true, "targets": 1, 'bSortable': false },      
        { "visible": true, "targets": 12, 'bSortable': false }                 	  
   	],
    "lengthMenu": [20, 50, 100, 150],
    "aaSorting": [[2, 'asc']],
    "pagingType": "full_numbers"
	
}); 

$('select[name="referral_management_length"]').prepend('<option value="10">10</option>');

$('#refresh_pages').on('mouseover', function() { $('#refresh_pages i').addClass('fa-spin'); });
$('#refresh_pages').on('mouseout', function() { $('#refresh_pages i').removeClass('fa-spin'); });
$('#refresh_pages').click(function() { table.fnFilter($(this).val()); });

// Default Data Load
//getBMDataList('#lb_bm', '');
//loadRMListInBranchBoundary('#lb_rm', '');
fnLoadRMList('#lb_bm', '', true);
getMasterTLAStatusList('', false);
setFieldReferralAutoCompleted('#tl_code', true);

// Field Validation
function field_validation(element) {

	 $('#check_icon').hide();
	 var tl_code = $(element).val();
	 if(tl_code == '') {
		 
		 notif({
 		    msg: "Please enter TLA Code.",
 		    type: "error",
 		    position: "center",
 		    opacity: 1,
 		    width: 300,
 		    height: 50,
 		    color: '#FFF',
 		    autohide: true
 		});

		 $('#check_icon').show();
	 		
	 } else {

		 if(tl_code.length < 5) {
			 notif({
	 		    msg: "The data is less than 8 characters..",
	 		    type: "error",
	 		    position: "center",
	 		    opacity: 1,
	 		    width: 300,
	 		    height: 50,
	 		    color: '#FFF',
	 		    autohide: true
		 	});

			 $('#check_icon').show();
			 
		 } else {

			 if(tl_code === '99999999') {
					notif({
	  	  		    	msg: "This code available.",
	  	  		    	type: "success",
	  	  		    	position: "center",
	  	  		    	opacity: 1,
	  	  		    	width: 300,
	  	  		    	height: 50,
	  	  		    	color: '#FFF',
	  	  		    	autohide: true
	  	  			});

					$('#check_icon').css('display', 'none');
					$('.check_fields').css('display', 'block'); 

				    getBankList('#add_bank', '', true, true);
					fnLoadRMList('#add_tl_ref1_selected', '', true, true);

					$('#label_refname').text('REF CODE / TL NAME');
					$('#add_tl_code').parent().removeClass('size5').addClass('size2');
					$('#add_tl_name').parent().removeClass('hidden');
					
					$(element).css({ 'background': '#EBEBE7' }).attr('readonly', 'readonly');
					
			 } else {
					
				 $.ajax({
					url: pathFixed + 'dataloads/checkTLAUnique?_=' + new Date().getTime(),
					type: "POST",
					data: { cox: $(element).val() },
					success:function(responsed) {
			
						if(responsed['status']) {
							
							notif({
			  	  		    	msg: "This code available.",
			  	  		    	type: "success",
			  	  		    	position: "center",
			  	  		    	opacity: 1,
			  	  		    	width: 300,
			  	  		    	height: 50,
			  	  		    	color: '#FFF',
			  	  		    	autohide: true
			  	  			});

							$('#check_icon').css('display', 'none');
							$('.check_fields').css('display', 'block'); 

						    getBankList('#add_bank', '', true, true);
							fnLoadRMList('#add_tl_ref1_selected', '', true, true);

							$('#label_refname').text('REF CODE / TL NAME');
							$('#add_tl_code').parent().removeClass('size5').addClass('size2');
							$('#add_tl_name').parent().removeClass('hidden');
							
							$(element).css({ 'background': '#EBEBE7' }).attr('readonly', 'readonly');
			  	  			
						} else {
							
							notif({
			  	  		    	msg: "Sorry, this TLA Code is already in the system.",
			  	  		    	type: "error",
			  	  		    	position: "center",
			  	  		    	opacity: 1,
			  	  		    	width: 350,
			  	  		    	height: 50,
			  	  		    	color: '#FFF',
			  	  		    	autohide: true
			  	  			});

						}
						
					},
					cache: false,
					timeout: 5000,
					statusCode: {
						404: function() { alert( "page not found" ); },
				        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); }
					}
					
				});
				
			 }
 
		 } 

	 }

}

// ############# DATA HANDLED ##############
function InitialForm() {

	var tl_code 	  = $('#add_tl_code').val();
	var tl_name 	  = $('#add_tl_name').val();
	var tl_position	  = $('#add_tl_position').val();
	var tl_pos_short  = $('#add_tl_position_short').val();	
	var tl_mobile_1   = $('#add_tl_mobile_1').val();
	var tl_mobile_2   = $('#add_tl_mobile_2').val();
	var tl_branch 	  = $('#add_tl_branch').val();
	var tl_branchtel  = $('#add_tl_branchtel').val();
	var region_id	  = $('#add_lb_region option:selected').val();
	var branch_code   = $('#add_lb_branch option:selected').val();	
	var ref1_code 	  = $('#add_tl_ref1_code').val();
	//var ref2_code 	  = $('#add_tl_ref2_code').val();	                   		
	var tl_ref1 	  = $('#add_tl_ref1').val();	
	var tl_ref2 	  = $('#add_tl_ref2').val();
	var register 	  = $('#add_register').val();
	var tl_status 	  = $('#add_tl_status').val(); 

	var bank_live	  = $('#add_bank').val();
	var bank_acct	  = $('#bank_acct').val();	
	var expired_date  = $('#add_expired').val();
	var idcardexpired = $('#add_id_cardno_expired').val();
	var remark_text	  = $('#add_tl_remark').val();

	var id_card		  = $('#add_id_card:checked').val();
	var tl_card		  = $('#add_tl_card:checked').val();

	var tl_address	  = $('#add_tl_address').val();
	var tl_envelope	  = $('#add_tl_sentenvelope:checked').val();
	var tl_channel	  = $('#add_tl_channel option:selected').val();

	if(register == '' || tl_code == '' || tl_name == '' || tl_branch == '' || tl_status == '' || tl_mobile_1 == '' ) {
		
		notif({
	    	msg: "Please check fields again..",
	    	type: "error",
	    	position: "center",
	    	opacity: 1,
	    	width: 300,
	    	height: 50,
	    	color: '#FFF',
	    	autohide: true
		});

		if(register == '') {
			var not = $.Notify({ content: "Please enter your join date", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

		if($('#add_id_card').is(':checked') && idcardexpired == '' || !idcardexpired) {
			var not = $.Notify({ content: "Please enter your id card are expired date", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);	
		}

		if($('#add_tl_card').is(':checked') && expired_date == '' || !expired_date) {
			var not = $.Notify({ content: "Please enter your TL license are expired date", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);	
		}

		if(tl_code == '') {
			var not = $.Notify({ content: "Please enter your referral code", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

		if(tl_name == '') {
			var not = $.Notify({ content: "Please enter your name-surname", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

		if(tl_branch == '') {
			var not = $.Notify({ content: "Please enter your TL branch", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

		if(tl_status == '') {
			var not = $.Notify({ content: "Please enter your status", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

		if(tl_mobile_1 == '') {
			var not = $.Notify({ content: "Please enter your mobile 1", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

	} else {

		console.log([bank_live, bank_acct]);

		if(bank_live != null && bank_acct == "" || bank_live == null && bank_acct != "") {
			var not = $.Notify({ content: "Please enter your bank and account number", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);
			
		} else {
			
			$.ajax({
				url: pathFixed + 'referral_control/setDataInitialize?_=' + new Date().getTime(),
				type: "POST",
				data: { 
					tl_code: tl_code,
					tl_name: tl_name,					
					tl_position: tl_position,
					tl_pos_short: tl_pos_short,
					tl_mobile_1: tl_mobile_1,
					tl_mobile_2: tl_mobile_2,	
					tl_branch: tl_branch, 
					tl_branch_tel: tl_branchtel,
					region_id: region_id,
					branch_code: branch_code,   
					ref1_code: ref1_code,
					//ref2_code: ref2_code,        		
					tl_ref1: tl_ref1,				
					tl_ref2: tl_ref2,
					registerdate: register,
					tl_status: tl_status,
					bank_name: bank_live,
					bank_acct: bank_acct,
					expired_date: (tl_card == 'Y') ? expired_date:null,
					expired_idcard: (id_card == 'Y') ? idcardexpired:null,
					remark_text: remark_text,
					id_card: (id_card == 'Y') ? id_card:null,
					tl_card: (tl_card == 'Y') ? tl_card:null,
				 	tl_address: tl_address,
				 	tl_envelope: (tl_envelope == 'Y') ? tl_envelope:null,
				 	tl_channel: (tl_channel !== '') ? tl_channel:null
				},
				success:function(responsed) {
					
					if(responsed['status']) {
						
						notif({
		  	  		    	msg: "Data bundled successfully.",
		  	  		    	type: "success",
		  	  		    	position: "center",
		  	  		    	opacity: 1,
		  	  		    	width: 300,
		  	  		    	height: 50,
		  	  		    	color: '#FFF',
		  	  		    	autohide: true
		  	  			});

						$.Dialog.close();
						table.fnFilter(); 
						  	  			
					} else {
						notif({
		  	  		    	msg: "The occurrence handled failed. Please try again..",
		  	  		    	type: "error",
		  	  		    	position: "center",
		  	  		    	opacity: 1,
		  	  		    	width: 400,
		  	  		    	height: 50,
		  	  		    	color: '#FFF',
		  	  		    	autohide: true
		  	  			});

					}
								
				},
				cache: false,
				timeout: 5000,
				statusCode: {
					404: function() { alert( "page not found" ); },
			        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); }
				}
				
			});
			
		}

	}

}

function InitialUpdateForm() {

	var tl_id		 = $('#edit_tl_id').val();
	var tl_code 	 = $('#edit_tl_code').val();
	var tl_name 	 = $('#edit_tl_name').val();
	var tl_position	 = $('#edit_tl_position').val();
	var tl_pos_short = $('#edit_tl_position_short').val();
	var tl_mobile_1  = $('#edit_tl_mobile_1').val();
	var tl_mobile_2  = $('#edit_tl_mobile_2').val();
	var tl_branch 	 = $('#edit_tl_branch').val();
	var tl_branchtel = $('#edit_tl_branchtel').val();
	var region_id	 = $('#edit_lb_region option:selected').val();
	var branch_code  = $('#edit_lb_branch option:selected').val();	
	var ref1_code 	 = $('#edit_tl_ref1_code').val();
	//var ref2_code 	 = $('#edit_tl_ref2_code').val();	                   		
	var tl_ref1 	 = $('#edit_tl_ref1').val();	
	//var tl_ref2 	 = $('#edit_tl_ref2').val();
	var register 	 = $('#edit_register').val();
	var tl_status 	 = $('#edit_tl_status option:selected').val();

	var bank_live	  = $('#edit_bank').val();
	var bank_acct	  = $('#edit_bank_acct').val();	 
	var expired_date  = $('#edit_expired').val();
	var remark_text	  = $('#edit_tl_remark').val();
	
	var id_card		  = $('#edit_id_card:checked').val();
	var tl_card		  = $('#edit_tl_card:checked').val();

	var tl_address	  = $('#add_tl_address').val();
	var tl_envelope	  = $('#add_tl_sentenvelope:checked').val();
	var tl_channel	  = $('#edit_tl_channel option:selected').val();
	
	if(register == '' || tl_code == '' || tl_name == '' || tl_branch == '' || tl_status == '' || tl_mobile_1 == '' ) {
		
		notif({
	    	msg: "Please check fields again..",
	    	type: "error",
	    	position: "center",
	    	opacity: 1,
	    	width: 300,
	    	height: 50,
	    	color: '#FFF',
	    	autohide: true
		});

		if(register == '') {
			var not = $.Notify({ content: "Please enter your join date", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

		if(tl_code == '') {
			var not = $.Notify({ content: "Please enter your referral code", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

		if(tl_name == '') {
			var not = $.Notify({ content: "Please enter your name-surname", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

		if(tl_branch == '') {
			var not = $.Notify({ content: "Please enter your TL branch", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

		if(tl_status == '') {
			var not = $.Notify({ content: "Please enter your status", style: { background: '#A20025', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

		if(tl_mobile_1 == '') {
			var not = $.Notify({ content: "Please enter your mobile 1", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);			
		}

	} else {	

		if(bank_live != null && bank_acct == "" || bank_live == null && bank_acct != "") {
			var not = $.Notify({ content: "Please enter your bank and account number", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);
			
		} else {

			$.ajax({
				url: pathFixed + 'referral_control/setUpdateInitializeData?_=' + new Date().getTime(),
				type: "POST",
				data: { 
					tl_id: tl_id,
					tl_code: tl_code,
					tl_name: tl_name,
					tl_position: tl_position,
					tl_pos_short: tl_pos_short,
					tl_mobile_1: tl_mobile_1,
					tl_mobile_2: tl_mobile_2,		
					tl_branch: tl_branch, 
					tl_branch_tel: tl_branchtel,
					region_id: region_id,
					branch_code: branch_code,   
					ref1_code: ref1_code,
					//ref2_code: ref2_code,        		
					tl_ref1: tl_ref1,				
					//tl_ref2: tl_ref2,
					registerdate: register,
					tl_status: tl_status,
					bank_name: bank_live,
					bank_acct: bank_acct,
					expired_date: expired_date, 
					remark_text: remark_text,
					id_card: (id_card == 'Y') ? id_card:null,
					tl_card: (tl_card == 'Y') ? tl_card:null,
					tl_address: tl_address,
					tl_envelope: (tl_envelope == 'Y') ? tl_envelope:null,	
					tl_channel: (tl_channel !== '') ? tl_channel:null
				},
				success:function(responsed) {
					
					if(responsed['status']) {
						
						notif({
		  	  		    	msg: "Data update successfully.",
		  	  		    	type: "success",
		  	  		    	position: "center",
		  	  		    	opacity: 1,
		  	  		    	width: 300,
		  	  		    	height: 50,
		  	  		    	color: '#FFF',
		  	  		    	autohide: true
		  	  			});

						$.Dialog.close();
						table.fnFilter(); 
						  	  			
					} else {
						
						notif({
		  	  		    	msg: "The occurrence handled failed. Please try again..",
		  	  		    	type: "error",
		  	  		    	position: "center",
		  	  		    	opacity: 1,
		  	  		    	width: 400,
		  	  		    	height: 50,
		  	  		    	color: '#FFF',
		  	  		    	autohide: true
		  	  			});

					}
								
				},
				cache: false,
				timeout: 5000,
				statusCode: {
					404: function() { alert( "page not found" ); },
			        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); }
				}
				
			});

		}

	}

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

$('#filterClear').click(function() {
	
	$('.ms-choice > span').text('');
	$('input[name^="selectAll"]').prop('checked', false);
	$('input[name^="selectGroup"]').prop('checked', false);
	
	$('input[name="selectItemtl_position"]').prop('checked', false);
	$('input[name="selectItemtl_status"]').prop('checked', false);
	$('select[name="lb_region"]').find('option[value=""]').prop('selected', true);
	$('input[name="selectItemtl_branch"]').prop('checked', false);
	$('input[name="selectItemlb_branch"]').prop('checked', false);
	$('input[name="selectItemlb_bm"]').prop('checked', false);
	$('input[name="selectItemlb_rm"]').prop('checked', false);
	
	$('#register_date').val('');
	$('#tl_code').val('');
	$('#tl_name').val('');

	getBranchList('#lb_branch', '', true);
	getBMDataList('#lb_bm', $(this).val());
	loadRMListInBranchBoundary('#lb_rm', $(this).val());

});

$('#lb_branch').change(function() {	
	//getBMDataList('#lb_bm', $(this).val());
	loadRMListInBranchBoundary('#lb_bm', $(this).val());
})

$('#tl_status').change(function() { }).multipleSelect({ width: '100%', filter: true });


// ##### FUNCTION ####
function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9\-]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

function reChoose() { 
	$('#add_bank, #edit_bank').val('');
	$('#add_bank, #edit_bank').multipleSelect("setSelects", '');
	$('#add_bank, #edit_bank').prop('selected', false);
	$('input[name="selectItemadd_bank"]').parent().parent().removeClass('selected')
	$('input[name="selectItemadd_bank"]').prop('checked', false); 
	$('input[name="selectItemedit_bank"]').parent().parent().removeClass('selected')
	$('input[name="selectItemedit_bank"]').prop('checked', false); 
	$('#ms_spanadd_bank > span').text(''); 
	$('#ms_spanedit_bank > span').text(''); 

	$('#bank_acct, #edit_bank_acct').val('');

	$('#add_tl_status').val('Pending');
	$('#edit_tl_status').find('option[value="Pending"]').prop('selected', true);
	
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

function loadRMListInBranchBoundary(element, branch_code) {

	 $.ajax({
       url: pathFixed + 'dataloads/getRMListBoundaryOnly?_=' + new Date().getTime(),
       type: "POST",
		data: {
			branchcode: branch_code,
			xr: new Date().getTime()
	   },
       success:function(responsed) {
			//getEmpListSpecify
    	   $(element).empty();
			for(var indexed in responsed['data']) {
				var user_role = '(' + responsed['data'][indexed]['User_Role'] + ') ';
				$(element).append('<option value="' + responsed['data'][indexed]['EmployeeCode'] + '" data-attr="' + responsed['data'][indexed]['FullNameTh'].trim() + '">' + user_role + responsed['data'][indexed]['FullNameTh'] + '</option>');
								
			}

			$(element).change(function() { }).multipleSelect({ width: '100%', filter: true }).multipleSelect("refresh");

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

function getBMDataList(element, branch_code) {
	
	$.ajax({
        url: pathFixed + 'dataloads/getBMList?_=' + new Date().getTime(),
        type: 'POST',
        data: {
        	 brnx: branch_code,
             chc: true          	
        },
        success:function(responsed) {
        	
        	if(responsed['status']) {

        		$(element).empty();
        		for(var indexed in responsed['data']) {
	        		if(responsed['data'][indexed]['FullNameTh'] == '') { continue; } 
	        		else { 
		        		$(element).append('<option value="' + responsed['data'][indexed]['EmployeeCode'] + '">(' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + ' (' + responsed['data'][indexed]['BranchName'] + ')' + '</option>');	    				
	        		}
        		}
    
        		$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });

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

function fnLoadRMList(element, elemValue, multi, option = false) {
	
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
				$(element).change(function() { }).multipleSelect({ width: '100%', filter: true, position: 'top', single: option });
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

function getBankList(element, bank_code, multi, option = false) {
	
	 $.ajax({
      url: pathFixed + 'dataloads/getBankList?_=' + new Date().getTime(),
      type: "GET",
      success:function(responsed) {
  
      	$(element).empty().prepend('<option value="">ไม่ระบุ</option>');
      	for(var indexed in responsed['data']) {
      		
      		$(element).append('<option value="' + responsed['data'][indexed]['Bank_Code'] + '" title="' + responsed['data'][indexed]['Bank_NameTh'] + '">' + responsed['data'][indexed]['Bank_Digit'] + '</option>');
      		
      		if(bank_code != '') {
      			 $(element).find('option[value="' + bank_code + '"]').prop('selected', true);
      		}
      	}
      	
      	if(multi == true) {
      		//$(element).find('option[value=""]').remove();
      		$(element).change(function() { }).multipleSelect({ width: '100%', filter: true, position: 'top', single: option });
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

function getMasterTLAStatusList(element, multi) {
	$.ajax({
        url: pathFixed + 'dataloads/getMasterTLAStatusList?_=' + new Date().getTime(),
        type: 'GET',
        success:function(responsed) {
        	
        	if(responsed['status']) {
        		
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

function reloadDataGrid() {

	var pattern 	   	   = new RegExp("-");
	var register_date	   = $('#register_date').val();
	var object_date 	   = pattern.test(register_date);

	var start_draftdate    = '',
	    end_draftdate 	   = '';

	if(object_date) {
	   var item   	      = register_date.split("-");
	   start_draftdate    = item[0].trim();
	   end_draftdate	  = item[1].trim();

   } else { start_draftdate	= register_date }

	$('#start_date').val(start_draftdate);
	$('#end_date').val(end_draftdate);
	
	table.fnFilter();
	
}
</script>


