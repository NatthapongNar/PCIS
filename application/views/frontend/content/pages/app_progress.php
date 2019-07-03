<style type="text/css">

	input, select { 
		font-size: 0.9em;
		font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
	}
	
	table tbody tr:hover { color: red !important; }
	table#tbl_content_progress th, td { font-size: 12px; }	
	table#tbl_content_progress tr td:nth-child(5) { text-align: left !important; }
	table#tbl_content_progress tr td:nth-child(6) { text-align: left !important; }
	table#tbl_content_progress tr td:nth-child(7) { text-align: center !important; }
	table#tbl_content_progress tr td:nth-child(8) { text-align: left !important; }
	table#tbl_content_progress tr td:nth-child(9) { text-align: left !important; }
	table#tbl_content_progress tr td:nth-child(10) { text-align: right !important; }
	table#tbl_content_progress tr td:nth-child(11) { text-align: center !important; }
	table#tbl_content_progress tr td:nth-child(12) { text-align: left !important; }
	.brands { background-color: #4390DF; color: #FFF; }
	
	th[class*="sort"]:after {
		content: "" !important;
	}
	
	.ms-drop ul li, label, input { z-index: 999; }
	input[name="selectItembranchs"] { z-index: 999; }
	
	.ms-drop ul > li label:not(.optgroup) input[data-group^='group'] {
	    margin-left: 15px !important;
	}
	
	.ui-autocomplete {
	    max-height: 350px;
	    overflow-y: auto;   /* prevent horizontal scrollbar */
	    overflow-x: hidden; /* add padding to account for vertical scrollbar */
	    z-index: 1000 !important;
	}
	
	.label-clear { background-color: #FFF !important; }
	.metro .dropdown-toggle:after { visibility: hidden; }
	
	/* PROGRESS ICON: MODIFY STYLE */
	div#tbl_content_progress_processing {
	    background-color: transparent;
	    margin-top: 10px;
	    margin-left: -200px !important;
	    width: 500px;
	}
	.metro .dataTables_wrapper .dataTables_processing {  box-shadow: none !important; }
	.dataTables_length select { height: auto !important; }
	#overlay { 
		position: fixed;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		z-index: 1001;
		background-color: rgba(33, 33,33, 0.3);
	}
	
	.alert {
		margin-top: 70px;
		position: absolute;
	    right: 0;
	    padding: 15px 20px;
	    margin-right: 22%;
	    margin-bottom: 20px;
	    border: 1px solid transparent;
	    border-radius: 4px;

	}
	
	.alert-danger {			
	    color: #a94442;
	    font-size: 1.1em;
	    background-color: #f2dede;
	    border-color: #ebccd1;
	}

</style>
<script type="text/javascript">

$(document).ready(function() {

	new Kalendae.Input('date_range', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});
	/*
	new Kalendae.Input('appointment_range', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});
	*/
	$('.kalendae').mouseleave(function () {
    	 $(this).hide();
    	 $(this).blur();
    })

    var search_kpi = $('#search_kpi').val();
    if(search_kpi) {
        
    	// Enabeld off;
    	$('title').text('KPI - Prospect List');
    	$('.panel-content').remove();
    	$('.link_jumper').removeAttr('href').removeAttr('target');
    	
    }

	$('#fttab').remove();

});


</script>

<div id="contentation" style="margin-top: 70px;">

<header class="text-center">
	<h2>APPLICATION PROGRESS</h2>
	<h4 id="timestemps" class="text-center text-muted animated rubberBand"><?php echo date('d M Y'); ?></h4>
</header>
	
<div class="grid">
<div id="application" class="row">

	<?php $this->load->library('form_validation'); ?>
	<input id="empprofile_identity" type="hidden" value="<?php echo $session_data["emp_id"]; ?>">

	<div id="element_hidden">
	
		<!-- Basic -->
	    <input id="inlineCheckbox_hidden" name="inlineCheckbox_hidden" type="hidden" value="">
	    <input id="startdate_hidden" name="startdate_hidden" type="hidden" value="">
	    <input id="enddate_hidden" name="enddate_hidden" type="hidden" value="">
	    <input id="appointment_startdate_hidden" name="startdate_hidden" type="hidden" value="">
	    <input id="appointment_enddate_hidden" name="enddate_hidden" type="hidden" value="">
	    <input id="requestloan_hidden_start" name="requestloan_start" type="hidden" value="">
		<input id="requestloan_hidden_end" name="requestloan_end" type="hidden" value="">
	    <!-- <input id="requestloan_hidden" name="requestloan_hidden" type="hidden" value=""> -->
	    
	    <input id="regions_hidden" name="regions_hidden" type="hidden" value="">
	    <input id="branchs_hidden" name="branchs_hidden" type="hidden" value="">
	    <input id="source_hidden" name="source_hidden" type="hidden" value="">
	    <input id="appno_hidden" name="appno_hidden" type="hidden" value="">
	    <input id="id_card_hidden" name="id_card_hidden" type="hidden" value="">
	    <input id="customer_hidden" name="customer_hidden" type="hidden" value="">
	    <input id="rmname_hidden" name="rmname_hidden" type="hidden" value="">
	    <input id="business_location_hidden" name="business_location_hidden" type="hidden" value="">
	    
	    <!-- Special Field -->
	    <!-- Relation With KPI Dashboard -->
	    <input id="search_kpi" name="search_kpi" type="hidden" value="<?php echo !empty($_GET['search_kpi']) ? $this->input->get('search_kpi'):''; ?>">
	    <input id="mode_kpi" name="mode_kpi" type="hidden" value="<?php echo !empty($_GET['mode']) ? $this->input->get('mode'):''; ?>">
	    <input id="kpino" name="kpino" type="hidden" value="<?php echo !empty($_GET['kpino']) ? $this->input->get('kpino'):''; ?>">
	    <input id="is_actived" name="is_actived" type="hidden" value="<?php echo !empty($_GET['is_actived']) ? $this->input->get('is_actived'):''; ?>">
	    <input id="empcode_kpi" name="empcode_kpi" type="hidden" value="<?php echo !empty($_GET['empcode_kpi']) ? $this->input->get('empcode_kpi'):''; ?>">
	    
	</div>
	
	
	<div id="panel_criteria" class="panel" data-role="panel" style="width: 55%; float: right; margin-bottom: 13px;">
		<div class="panel-header bg-lightBlue fg-white" style="font-size: 1.1em;"><i class="fa fa-search"></i> FILTER CRITERIA</div>
		<div class="panel-content" style="display: none;">

			<div class="row place-right marginRight20">
			
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
			</div>
			
			<div class="row place-right marginRight20" style="clear: both; margin-top: -5px;">
				<div class="input-control text size2 text-left" id="datestarter">
					<label class="label label-clear">START DATE</label>
					<input id="date_range" name="date_range" type="text" value="" class="date_ranges">
				</div>
				<!-- 
				<div class="input-control text size2 text-left" id="datestarter">
					<label class="label label-clear">APPOINTMENT</label>
					<input id="appointment_range" name="appointment_range" type="text" value="" class="date_ranges">
				</div>
				 -->
			
				<!-- 
				<div class="input-control select size2 text-left">
		            <label class="label label-clear">LOAN REQUEST</label>
		            <select id="requestloan" name="requestloan" multiple="multiple">
		           		<option value="1-1000000">0 - 1MB</option>
		           		<option value="1000000-3000000">1MB - 3MB</option>
		           		<option value="3000000-5000000">3MB - 5MB</option>
		           		<option value="5000000-8000000">5MB - 8MB</option>
		           		<option value="8000000-1000000000">8MB ขึ้นไป</option>
		            </select>
	        	</div>
				-->					
					
				<div class="input-control text size2 text-left" style="max-width: 285px;">
					<label class="label label-clear">LOAN REQUEST</label><br/>
					<input type="text" name="request_loan" id="request_loan" value="" class="size2" onkeypress="validate(event)">
					<!--
					<input type="text" name="requestloan_start" id="requestloan_start" value="" class="size2">
					<input type="text" name="requestloan_end" id="requestloan_end" value="" class="size2">
					-->
				</div>
				
				
				<div class="input-control text size2 text-left">
					<label class="label label-clear">APP NO.</label>
					<input type="text" name="appno" id="appno" value="" maxlength="15">
				</div>
				
				<div class="input-control text size2 text-left">
					<label class="label label-clear">ID CARD</label>
					<input type="text" name="id_card" id="id_card" value="" maxlength="13">
				</div>	
				
				<div class="input-control select size2 text-left">
		            <label class="label label-clear">OPTIONAL</label>
		            <select id="sourceofcustomer" name="sourceofcustomer" multiple="multiple">
		            	<optgroup label="Loan Type">
		            		<option value="NN">Nano Finance</option>
		            		<option value="MF">Micro Finance</option>
		            		<option value="SB">SB Finance</option>
		            		<option value="MF SME">Micro SME</option>
		            	</optgroup>
		            	<optgroup label="Source Of Customer">
		            	<?php 
		            		
		            	foreach($SourceField as $index => $values) {
		            		echo ' <option value="'.$values['SourceField'].'">'.$values['SourceLabel'].'</option>';
		            	
		            	}			            	
		            	
		            	?>	
		            	</optgroup>
		            	<optgroup label="Interest Or Not">
		            		<option value="Y">สนใจ</option>
		            		<option value="N">ไม่่สนใจ</option>
		            	</optgroup>	               
		            	<optgroup label="Potential Customer">
		            		<option value="H">High</option>
		            		<option value="M">Medium</option>
		            		<option value="L">Low</option>
		            	</optgroup>
		            </select>
	        	</div>
							
			</div>

			<div class="row place-right marginRight20">
	
				<!-- Region & Branch -->

				<?php 

				if(in_array('074006', $session_data['auth']) || in_array('074007', $session_data['auth']) || in_array('074008', $session_data['auth']) || in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000') {
					echo '<div id="parent_region" class="input-control select size2 text-left">
			                <label class="label label-clear">REGION</label>
			                	<select id="region" name="region" style="height: 34px;">
									<option value="" selected></option>';
	
									foreach($AreaRegion['data'] as $index => $values) {
										echo '<option value="'.$values['RegionID'].'">'.strtoupper($values['RegionNameEng']).'</option>';
									
									}
								
					echo	'</select>
			              </div>';
				}
				
				if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' ||
				   in_array('074004', $session_data['auth']) || in_array('074005', $session_data['auth']) ||
 				   in_array('074006', $session_data['auth']) || in_array('074007', $session_data['auth']) ||
				   in_array('074008', $session_data['auth'])) {

				   echo '<div id="parent_select_group" class="input-control select size2 text-left" style="margin-left: 4px; z-index: 999;">
						  <div id="select_group" class="form-group">
		                  	<label class="label label-clear">BRANCH</label>
			              	<select id="branchs" name="branchs" multiple="multiple" style="height: 34px;">';
	
								foreach($AreaBoundary['data'] as $index => $values) {
									echo '<option value="'.$values['BranchCode'].'">'.$values['BranchDigit'].' - '.$this->effective->get_chartypes($char_mode, $values['BranchName']).'</option>';
								
								}
						
					echo	'</select>
						  </div>
		               </div>';
				}
				
				if(!in_array('074002', $session_data['auth'])) {
					echo '
    					<div id="parent_select_rmlist" class="input-control select size2 text-left" data-role="input-control" style="height: 34px;">
							<div id="rmselect_group" class="form-group">
								<label class="label label-clear">EMP. NAME</label>
								<select id="rmname" name="rmname" multiple="multiple"></select>
							</div>
						</div>';
				}

			
				?>				
			
				<div class="input-control text size2 text-left">
					<label class="label label-clear">CUSTOMER NAME</label>
					<input type="text" name="customers" id="customers" value="">
					
				</div>	
				
			</div>
			
			<div class="rows place-right marginRight15" style="margin-top: 10px; clear: both;">				
				<?php 
				 
				if(in_array('074002', $session_data['auth']) || in_array('074001', $session_data['auth']) && !$session_data['branchcode'] == '000') {
					
				} else {
					
					echo '
    				<div class="input-control text size8 ui-widget text-left marginRight5" style="max-width: 564px; padding: 0 5px;">
					<!-- <div class="label">BUSINESS LOCATION</div> -->	
					<input id="business_location" name="business_location" type="text" value="">						
					</div>';
					
				}
								
				?>

				<div class="input-control place-right" style="padding: 0 0 10px 0;">	
						
					<button type="button" id="btnSearch" class="bg-lightBlue fg-white" style="height: 34px;">
						<i class="icon-search on-left"></i>SEARCH
					</button>
					<button type="button" id="btnClear" class="bg-green fg-white" style="height: 34px;">CLEAR</button>
				</div>
			</div>

		</div>
	</div>
	
	<section style="float: right; margin-top: 12px; margin-right: 5px;">	

		<span data-role="input-control" style="margin-right: 10px;" data-hint="กดเพื่อ refresh หน้า" data-hint-position="top" width="3%">
			<a id="refresh_pages" href="#" class="fg-lightBlue"><i class="fa fa-refresh on-left"></i> 
			<span>REFRESH</span></a>
		</span>
		
		<nav class="read_tool" style="margin-top: -25px; margin-right: 5px;">
			<ul class="clearfix">
				<li class="collaspe"><a href="#" class="btn"><i class="icon-book" style="font-size: 1.4em; margin-top: 9px;"></i></span></a>	
					<ul>
						<li>
							<a href="<?php echo base_url('PCIS Handbook/PCIS Progress Port Management.pdf'); ?>" target="_blank">
								<i class="icon-book" style="font-size: 1.4em; margin-top: 12px;"></i>
							</a>
						</li>
						<li>
							<a href="#">								
								<span class="fa-stack fa-lg">
								  <i class="fa fa-video-camera" aria-hidden="true" style="margin-top: 9px;"></i>
								  <i class="fa fa-ban fa-stack-2x text-danger" style="color: #fd6252;"></i>
								</span>
							</a>
						</li>
					</ul>	
				</li>	
			</ul>
		</nav>
        
    </section>
   

	<div id="showNumRecord" style="position: absolute; float: left; margin-top: 40px; font-size: 0.9em;"></div>

    <div id="tbl_progress" class="table-responsive">
    <table id="tbl_content_progress" class="table bordered hovered" style="width: 100%; margin: 10px auto 0;">
            <thead>
	            <tr class="brands">
	                <th rowspan="2" style="vertical-align: middle;" width="9%">START DATE</th>
	                <th colspan="4" style="vertical-align: middle;" width="9%">CUST CHARACTER</th>
	                <th rowspan="2" style="vertical-align: middle;" width="12%">NAME / CONTACT</th>
	                <th rowspan="2" style="vertical-align: middle;" width="9%">APPOINTMENT</th>
	                <th rowspan="2" style="vertical-align: middle;" width="15%">BUSINESS LOCATION</th>
	                <th rowspan="2" style="vertical-align: middle;" width="15%">BUSINESS DESC</th>
	                <th rowspan="2" style="vertical-align: middle;" width="8%">LOAN RQ.</th>
	                <th rowspan="2" style="vertical-align: middle;" width="6%">BRN</th>
	                <th rowspan="2" style="vertical-align: middle;" width="10%">RM</th>
	                <th colspan="3" style="vertical-align: middle;" width="13%">PROGRESS STATUS</th>
	            </tr>
	            <tr class="brands">
	                <th width="1%" data-hint="Source Of Customer| แหล่งที่มาของลูกค้า" data-hint-position="top"><i class="fa fa-bullhorn"></i></th>
	                <th width="1%" data-hint="Interest Or Not|ลูกค้าสนใจสินเชื่อหรือไม่" data-hint-position="top"><i class="fa fa-smile-o"></i></th>
	                <th width="1%" data-hint="Prospect Potential Customer|โอกาสการเป็นลูกค้า" data-hint-position="top"><i class="fa fa-sliders" style="display: inline-block;"></i></th>
	                <th width="1%" data-hint="Loan Type|ประเภทสินเชื่อที่นำเสนอ" data-hint-position="top"><i class="fa fa-group"></i></th>
	                <th width="1%" data-hint-position="top">P1</th>
	                <th width="1%" data-hint-position="top">P2</th>
	                <th width="1%" data-hint-position="top">P3</th>
	            </tr>
            </thead>
            <tbody>
    
            </tbody>
      </table>
      </div>
      
      <script type="text/javascript">

		$('nav.read_tool .collaspe').on('click', function() {
			var el_target = $(this).find('ul')
			var getClass = el_target.attr('class');
			if(!getClass) {
				el_target.addClass('open');
			} else {
				el_target.removeClass('open');
			}
		});
	    
	</script>

</div>
</div>

<div class="bottom-menu-wrapper">
	<ul class="horizontal-menu compact">
    	<?php echo $footer; ?>
    </ul>
</div>

</div>