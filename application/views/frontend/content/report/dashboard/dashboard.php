<div id="optional_css">
<style type="text/css">		

	body { margin: 2px; margin-top: 100px; }
	table#whiteboard, th { font-size: 0.85em !important; vertical-align: middle; }
	#whiteboard td { font-size: 0.9em !important; }

	table tbody tr:hover { color: red !important; }	
	
	table#whiteboard td:nth-child(1) { text-align: center; }
    table#whiteboard td:nth-child(2) { text-align: center; background: #EBF5FF; }
    table#whiteboard td:nth-child(4) { text-align: left; }
    table#whiteboard td:nth-child(5) { text-align: center; }
    table#whiteboard td:nth-child(6) { text-align: center;  }
    table#whiteboard td:nth-child(7) { text-align: right; }
    table#whiteboard td:nth-child(8) { text-align: center; background: #EBF5FF; }
    table#whiteboard td:nth-child(9) { text-align: center; }
    table#whiteboard td:nth-child(10) { text-align: left; }
    table#whiteboard td:nth-child(11) { text-align: center; }
    table#whiteboard td:nth-child(12) { text-align: center; }
    table#whiteboard td:nth-child(13) { text-align: right; }
    table#whiteboard td:nth-child(14) { text-align: center; background: #EBF5FF; }
    table#whiteboard td:nth-child(15) { text-align: center; }
    table#whiteboard td:nth-child(16) { text-align: center; }
    table#whiteboard td:nth-child(17) { text-align: right; }
    table#whiteboard td:nth-child(18) { text-align: center; background: #EBF5FF; }
    table#whiteboard td:nth-child(19) { text-align: left;  }
    table#whiteboard td:nth-child(20) { text-align: left; display: none; }
    table#whiteboard td:nth-child(21) { text-align: center; width: 15px; max-width: 15px !important; }
    table#whiteboard td:nth-child(22) { text-align: center; max-width: 15px !important; display: none; }
        
    table#whiteboard tfoot tr th { border-top: 1px solid #eaeaea; font-weight: normal; }
    table#whiteboard tfoot tr th:nth-child(1) { font-weight: 200; }
    table#whiteboard tfoot tr th:nth-child(2) { text-align: right; }
    table#whiteboard tfoot tr th:nth-child(8) { text-align: right; }
    table#whiteboard tfoot tr th:nth-child(12) { text-align: right; }
        
	.brands { background-color: #4390DF; color: #FFF; }
	.successes { background-color: #DFF0D8; }
	.errors { background-color: #F2DEDE; }
	.waiting { background-color: #F2DEDE; }
	.inactive { background-color: #eae8e8; }
	.re_active { background-color: #f9e5e5;/* #F2DEDE; */ }
		
	table#filterSearcher th, td { 
		font-size: 0.9em; 
		font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
	}
	
	#mslist_loantype ul > li label:not(.optgroup) input[data-group^='group'] {
	    margin-left: 0px !important;
	}
	
	.ms-drop ul > li label:not(.optgroup) input[data-group^='group'] {
	    margin-left: 15px !important;
	}
		
	.metro .dropdown-toggle:after { visibility: hidden; }
		
	label, input, select, button { font-size: 0.9em; }
	
	#filterSearcher ul li {
		width: auto;
		display:block;
		text-align: left;
		overflow: hidden; 
		font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
	}
		
	#search_div {
		position: absolute; 
		z-index: 15; 
		padding: 5px; 			
		background-color: #FFF; 
		border: 1px solid #D1D1D1; 
		margin-top: -40px;
	}
		
	div#search_div { 		
		margin-left: -460px; 
	}
		
	@media screen and (-webkit-min-device-pixel-ratio:0) {
		.wrapper_searchDiv { margin-left: -440px !important; }
		.open { margin-left: 0; }
	}
		
	#search_toggler {			
		color: #888; 
		padding: 3px;
		float: right; 
		cursor: pointer; 
		min-width: 25px; 
		margin-top: -6px;
		margin-right: -38px; 
		background-color: #FFF; 
		border: 1px solid #D1D1D1; 
		font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
	}
		
	.label-clear { background-color: #FFF !important; }
	#search_toggler i, #search_header h4 { 
		font-size: 1.3em !important; 
		font-weight: 700; 
		font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
	}
		
	.ui-tooltip {
		max-width: 350px;
		background-color: #FFF;
	}
		
	/* Overide Tooltip */
	.tooltip:after, [data-tooltip]:after {
		z-index: 1000;
		padding: 8px;
		display: block;
		min-width: 100%;
    	white-space:nowrap;
		background-color: #000;
		background-color: hsla(0, 0%, 20%, 0.9);
		color: #fff;
		content: attr(data-tooltip);
		font-size: 14px;
		line-height: 1.2;
	}
		
	th[class*="sort"]:after {
		content: "" !important;
	}
		
	div#whiteboard_processing {
		background-color: transparent;
		margin-top: 10px;
		margin-left: -280px !important;
		width: 500px;
	}
	
	.field_tablimitText {
		max-height: 25px;
		max-width: 125px;
	}
	
	button#ms_spanloantype,
	button#ms_spanproducts,
	button#ms_spanstatus,
	button#ms_spanstatusreason {
	    border: 1px solid #D9D9D9;
	    height: 25px;
	}
		
	.metro .dataTables_wrapper .dataTables_processing {  box-shadow: none !important;  }
		
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
		margin-top: 2px;
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
	
	#definded_status div { display: inline; }
	
	div#modalPersonInfo > div.modal-dialog {
		width: 45%;
		height: 100%;
		margin: 0 auto;
		padding: 0;
	}
	
	div#modalPersonInfo > div.modal-dialog > div.modal-content {
		height: auto;
		min-height: auto;
		border-radius: 0;
	}
	
	div#modalPersonInfo  > div.modal-dialog > div.modal-content > div.modal-header, div.modal-footer {
		background-color: #FFF;
	}
	
	div#modalPersonInfo  > div.modal-dialog > div.modal-content > div.modal-body {
		background-color: #9A165A;
		min-height: 250px;		
	}
		
	.file_container {
		border: 1px dotted #81003C;
		cursor: pointer;
		width: 160px;
		height: 200px;
		padding: 10px 0;
		background: rgba(0, 0, 0, 0.5);
		display: inline-block;
		float: left;
	}
	
	.file_container:hover {
		box-shadow: 0 5px 15px rgba(0,0,0,0.5);
	}
	
	.file_wrapper {
	    position: relative;
	    overflow: hidden;
	}
	
	.file_wrapper > span {
	    width: 100%;
	    background-color: rgba(0, 0, 0, 0.5);
	    position: absolute;
	    left: 0;
	    padding: 20px 0;
	    color: #FFF;
	    transition: 0.5s ease-in-out;
	}
	
	.file_wrapper:hover > span {
	    margin-top: -60px;	 
	}
	
	
	.file_container > .progress-bar {
		position: absolute;
		top: 0;
		min-width: 158px;
		max-width: 158px;
	}
	
	.thumbnail_file {
		width: 100%;
		height: 100%;
	}
	
	@media print {
	
		.print_clearTop { margin-top: -70px !important; }
    	.print_hold { display: none; }
    	.printable { display: block !important; }
    	
    	.dataTables_length, .dataTables_paginate, #showNumRecord { display: none; }
    	
		table#whiteboard { font-size: 0.85em !important; vertical-align: middle; border: 1px solid #666; }
	        
	}
			
</style>
</div>

<div id="overlay" class="print_hold" style="display: none;"></div>

<?php if(!empty($_GET['search_kpi'])) { ?>
	<div class="alert alert-danger animated fadeIn" role="alert">
	    <span class="icon-info on-left animated fadeInDown" aria-hidden="true"> Preview in KPI mode.</span>
	</div>
<?php } ?>

<header class="text-center marginBottom10 print_clearTop">
	<h2>WHITE BOARD</h2>
	<h4 id="timestemps" class="text-center text-muted"><?php echo date('d M Y'); ?></h4>
	<div id="definded_status" class="row animated rubberBand print_hold">
	    <div><span style="background: #c6eab6; padding: 0 10px; width: 100px; border: 1px dotted;">&nbsp;</span> Re-Activated</div>
	    <div><span style="background: #f4c6c6; padding: 0 10px; width: 100px; border: 1px dotted;"></span>&nbsp;Retrieved</div>
    </div>
</header>


<!-- SEARCH TOOLBAR -->
<div id="element_hidden" class="print_hold">

    <!-- Basic -->
    <input id="inlineCheckbox_hidden" name="inlineCheckbox_hidden" type="hidden" value="">
    <input id="refer_check_hidden" name="refer_check_hidden" type="hidden" value="">
    
    <input id="regions_hidden" name="regions_hidden" type="hidden" value="">
    <input id="branchs_hidden" name="branchs_hidden" type="hidden" value="">
    <input id="customer_hidden" name="customer_hidden" type="hidden" value="">
    <input id="rmname_hidden" name="rmname_hidden" type="hidden" value="">

    <!-- Multi -->
    <input id="ncb_start_hidden" name="ncb_start_hidden" type="hidden" value="">
    <input id="ncb_end_hidden" name="ncb_end_hidden" type="hidden" value="">
    <input id="loantype_hidden" name="loantype_hidden" type="hidden" value="">
    <input id="products_hidden" name="products_hidden" type="hidden" value="">
    <input id="requestloan_start_hidden" name="requestloan_start_hidden" type="hidden" value="">
    <input id="requestloan_end_hidden" name="requestloan_end_hidden" type="hidden" value="">
    <input id="appplanstart_date_hidde" name="appplanstart_date_hidde" type="hidden" value="">
    <input id="appplanend_date_hidde" name="appplanend_date_hidde" type="hidden" value="">
    <input id="apptoca_start_hidden" name="apptoca_start_hidden" type="hidden" value="">
    <input id="apptoca_end_hidden" name="apptoca_end_hidden" type="hidden" value="">
    <input id="caname_hidden" name="caname_hidden" type="hidden" value="">
    <input id="status_hidden" name="status_hidden" type="hidden" value="">
    <input id="status_hidden_reason" name="status_hidden_reason" type="hidden" value="">
    <input id="statusdate_start_hidden" name="statusdate_start_hidden" type="hidden" value="">
    <input id="statusdate_end_hidden" name="statusdate_end_hidden" type="hidden" value="">
    <input id="approved_start_hidden" name="approved_start_hidden" type="hidden" value="">
    <input id="approved_end_hidden" name="approved_end_hidden" type="hidden" value="">
    <input id="drawdown_startplan_hidden" name="drawdown_startplan_hidden" type="hidden" value="">
    <input id="drawdown_endplan_hidden" name="drawdown_endplan_hidden" type="hidden" value="">
    <input id="drawdown_startactual_hidden" name="drawdown_startactual_hidden" type="hidden" value="">
    <input id="drawdown_endactual_hidden" name="drawdown_endactual_hidden" type="hidden" value="">
    <input id="drawdown_start_hidden" name="drawdown_start_hidden" type="hidden" value="">
    <input id="drawdown_end_hidden" name="drawdown_end_hidden" type="hidden" value="">
    
    <!-- Special Field -->
    <!-- Relation With KPI Dashboard -->
    <input id="search_kpi" name="search_kpi" type="hidden" value="<?php echo !empty($_GET['search_kpi']) ? $this->input->get('search_kpi'):''; ?>">
    <input id="mode_kpi" name="mode_kpi" type="hidden" value="<?php echo !empty($_GET['mode']) ? $this->input->get('mode'):''; ?>">
    <input id="kpino" name="kpino" type="hidden" value="<?php echo !empty($_GET['kpino']) ? $this->input->get('kpino'):''; ?>">
    <input id="is_actived" name="is_actived" type="hidden" value="<?php echo !empty($_GET['is_actived']) ? $this->input->get('is_actived'):''; ?>">
    <input id="empcode_kpi" name="empcode_kpi" type="hidden" value="<?php echo !empty($_GET['empcode_kpi']) ? $this->input->get('empcode_kpi'):''; ?>">
    
     <input id="modestate_kpi" name="modestate_kpi" type="hidden" value="<?php echo !empty($_GET['modestate']) ? $this->input->get('modestate'):''; ?>">
    
    <!-- Special Condition -->
    <input id="use_ca" name="use_ca" type="hidden" value="<?php echo !empty($_GET['use_ca']) ? $this->input->get('use_ca'):''; ?>">

</div>

<div id="panel_reconsiledoc" class="panel print_hold" data-role="panel" style="width: 42%; float: right; margin-bottom: 13px;">
	<div class="panel-header bg-lightBlue fg-white" style="font-size: 1em;"><i class="fa fa-search on-left"></i>FILTER CRITERIA</div>
	<div class="panel-content" style="display: none;">
		
		<div class="row place-right">
		    <div class="input-control radio" data-role="input-control" style="margin-right: 5px;">
		        <label>
		            <input type="radio" id="inlineCheckbox1" name="inlineCheckbox" value="Active" checked>
		            <span class="check"></span>
		            <span class="label label-clear" style="background-color: #FFF !important;">ACTIVE</span>
		        </label>
		   	 </div>
		   	 
		   	 <div class="input-control radio" data-role="input-control" style="margin-right: 5px;">
		        <label>
		           <input type="radio" id="inlineCheckbox2" name="inlineCheckbox" value="InActive">
		           <span class="check"></span>
		           <span class="label label-clear" style="background-color: #FFF !important;">INACTIVE</span>
		        </label>
		     </div>
		     
		     <div class="input-control radio" data-role="input-control">
		        <label>
		            <input type="radio" id="inlineCheckbox3" name="inlineCheckbox" value="All"> 
		            <span class="check"></span>
		            <span class="label label-clear" style="background-color: #FFF !important;">ALL</span>
		        </label>
		    </div>
		    
		    <div class="input-control select span3" data-role="input-control" style="margin-left: 5px;">
		        <span class="label label-clear">OPTION :</span>
		        <select id="refer_check" name="refer_check" multiple="multiple" class="span2">
		        	<option value="Refer: Thai Life">Refer by Thai Life</option>
	        		<option value="Refer: Full Branch">Refer by  Full Branch</option>
	        		<option value="Refer: Call Center">Refer by Call Center</option>
	                <option value="Tcrb: Facebook">Refer by TCRB FB</option>
	                <option value="Refer: RM">Refer by RM</option>
	                <option value="Refer: Customer">Refer by Cust-Suplier</option>
	        		<option value="Defend">Defend View</option>
	        		<option value="CR">Credit Return (CR)</option>
	        		<option value="ReActivate">Re-Activated Transaction</option>
	        		<option value="Retrieved">Retrieved Transaction</option>
	        	</select>	       
		    </div>		   
		</div>
	
		<div class="row place-right" style="margin-top: 10px; margin-bottom: 20px;">
			<?php
		    	
		    	if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' || 
				   in_array('074006', $session_data['auth']) || 
		    	   in_array('074007', $session_data['auth']) || 
				   in_array('074008', $session_data['auth'])) {
				   	
					echo '<div class="input-control select span2" data-role="input-control" style="margin-right: -7px;">
			                <label class="label label-clear">REGION</label>
			                	<select id="regions" name="regions" style="width: 130px; height: 34px;">
									<option value="" selected></option>';
		
										foreach($AreaRegion['data'] as $index => $values) {
											echo '<option value="'.trim($values['RegionID']).'">'.strtoupper($values['RegionNameEng']).'</option>';
										
										}
										
					echo	'</select>
					</div>';
				}
				
				// <option value="" selected> -- ALL -- </option>
				if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' ||
				   in_array('074004', $session_data['auth']) ||
				   in_array('074005', $session_data['auth']) ||
			       in_array('074006', $session_data['auth']) ||
				   in_array('074007', $session_data['auth']) ||
				   in_array('074008', $session_data['auth'])) {
				
					echo '<div id="parent_select_group" class="input-control select span2" data-role="input-control" style="margin-right: -6px;">
						  <div id="select_group" class="form-group">
			                 <label class="label label-clear">BRANCH</label>
							 <select id="branchs" name="branchs" multiple="multiple" style="width: 130px;  margin-right: 5px;">';

								foreach($AreaBoundary['data'] as $index => $values) {
									echo '<option value="'.$values['BranchDigit'].'">'.$values['BranchDigit'].' - '.$this->effective->get_chartypes($char_mode, $values['BranchName']).'</option>';
								
								}
	 		
					echo '</select>
        			</div>
        			</div>';
				}

			?>
			
			<div id="parent_select_rmlist" class="input-control select span2" data-role="input-control" style="height: 34px; margin-left: 5px;">
				<div id="rmselect_group" class="form-group">
					<label class="label label-clear">EMP. NAME</label>
					<select id="rmname" name="rmname" multiple="multiple"></select>
				</div>
			</div>
			
			<div class="input-control text span2" data-role="input-control" style="height: 34px;">
				<label class="label label-clear">CUSTOMER</label>
				<input id="customer" name="customer" type="text" value="">
			</div>

		</div>
		
		<div class="input-control text span7" style="clear: both; float: right; min-width: 560px;">
			<div class="place-left">
			
				<div class="input-control checkbox">
    				<label>
    					<input id="drawdown_cm" name="drawdown_cm" type="checkbox" value="Drawdown_CM">
    					<span class="check"></span> Drawdown Current Month
    				</label>
    			</div>
    			
    			<div class="input-control checkbox marginLeft10">
    				<label>
    					<input id="filter_cncancel" name="filter_cncancel" type="checkbox" value="CN003">
    					<span class="check"></span> CN003
    				</label>
    			</div>
    			
			</div>
		
			<button type="button" id="filterClear" class="bg-green fg-white" style="height: 33px; float: right;">CLEAR</button>
			<button type="button" id="filterSubmit" class="bg-lightBlue fg-white" style="height: 33px; float: right; margin-right: 5px;">
				<i class="icon-search on-left"></i>SEARCH
			</button>
			
			<button type="button" onclick="print_area('printHeader', 'tagscript_option', 'table_content_print');" class="bg-teal fg-white" style="height: 33px; float: right; margin-right: 5px;">
				<i class="fa fa-print on-left"></i>PRINT
			</button>
			
		</div>
		
	</div>
</div>

<div id="search_div" class="wrapper_searchDiv print_hold">
    <div id="search_toggler">
    	<i class="icon-arrow-right-2 fg-lightBlue on-right" data-hint="Search Tools" data-hint-position="right"></i>
    </div> 
    <div id="search_header">
        <h4 class="subheader" style="padding-left: 3px;"><i class="icon-filter on-left"></i> Filter Criteria</h4>
    </div>
    
    <table id="filterSearcher" style="margin: 0px 0 2em; width: 100;" border="0" cellspacing="0" cellpadding="3">
        <thead>
	        <tr>
	            <th class="text-left">Column - Target</th>
	            <th class="text-left">Search text</th>
	        </tr>
        </thead>
        <tbody>
        
	        <tr id="filter_col1" data-column="0">
	            <td>Start Date</td>
	            <td><div class="input-control text field_tablimitText"><input id="ncbcheck_date" type="text" value=""></div></td>
	        </tr>
	        
	         <tr id="filter_col1" data-column="0">
	            <td>Cashy</td>
	            <td>
	            	<div class="input-control checkbox">
					    <label>
					        <input id="cashy_field1" name="cashy_field" type="checkbox" value="Y">
					        <span class="check"></span> Yes
					    </label>
					</div>
					<div class="input-control checkbox">
					    <label>
					        <input id="cashy_field2" name="cashy_field" type="checkbox" value="N">
					        <span class="check"></span> No
					    </label>
					</div>
	            </td>
	        </tr>
	        
	        <tr height="30">
	        	<td>Loan Type</td>
	        	<td>
	        		<select id="loantype" name="loantype" multiple="multiple" style="width: 130px important!; padding: 2px 0;">
	        			<option value="Clean Loan"> Clean Loan</option>
	        			<optgroup label="Secure Loan">
	        				<option value="Refinance">Refinance</option>
	        				<option value="Non Refinance">Non Refinance</option>
	        			</optgroup>	        			
	        		</select>	        	
	        	</td>
	        </tr>
	        
	        <tr id="filter_col6" height="40" data-column="5">
	            <td>Product Program</td>
	            <td align="left">
	            	<div>
						<select id="products" name="products[]" multiple="multiple" style="width: 130px; padding: 2px 0;"></select>	         
	            	</div>
	            </td>
	        </tr>
	        
	        <tr id="filter_col7" height="30" data-column="6">
	            <td>Request Loan</td>
	            <td id="filter_col7_rq" align="center">
	          		<span class="input-control text field_tablimitText"><input id="col6_filter_start" type="text" value=""></span>
		            <span class="input-control text field_tablimitText"><input id="col6_filter_end" type="text" value=""></span>
	            </td>
	        </tr>
	        
	        <tr id="filter_col8" data-column="7">
	            <td>A2CA Plan Date</td>
	            <td><div class="input-control text field_tablimitText"><input id="app2caplan_date" type="text" value=""></div></td>
	        </tr>
	        
	        <tr id="filter_col8" data-column="7">
	            <td>A2CA Date</td>
	            <td><div class="input-control text field_tablimitText"><input id="app2ca_date" type="text" value=""></div></td>
	        </tr>
	        
	        <tr id="filter_col9" data-column="8">
	            <td>CA Name</td>
	            <td align="left">
	            	<div class="input-control text field_tablimitText"><input class="column_filter" id="caname" type="text" value=""></div>
	            </td>
	        </tr>
	        
	        <tr id="filter_col10" data-column="9">
	            <td>Status</td>
	            <td id="table_status_select" align="left">
	                <select id="status" name="status[]" multiple="multiple" style="width: 130px; padding: 2px 0;">
	                	<optgroup label="CA Decision Status">
		                	<option value="PENDING">P - Pending</option>
		                    <option value="APPROVED">A - Approved</option>
		                    <option value="REJECT">R - Reject</option> 
	                    </optgroup>
	                    <optgroup label="C - Cancel">
		                    <option value="CANCEL_BP" style="margin-left: 15px;">Cancel Before Process</option>
		                    <option value="CANCEL_AP" style="margin-left: 15px;">Cancel After Process</option>	
	                    </optgroup>                    	                
	                </select>
	            </td>
	        </tr>
	        
	        <tr id="filter_col18" height="40" data-column="14">
	            <td>Status Reason</td>
	            <td id="filter_col15_dm" align="center">
	            	<select id="statusreason" name="statusreason[]" multiple="multiple" style="width: 130px; padding: 2px 0;">
	            		<option value="AIP">AIP</option>
	            		<option value="CANCEL CN003">CANCEL CN003</option>
	            		<option value="ReceivedEstimated">รับเล่มประเมินแล้ว</option>
	            		<option value="Authorized Escalated">Authorized Escalated</option>
	            		<option value="Defend Process">Defend Process</option>
	            		<option value="DOC">DOC</option>
	            		<option value="DOC_FieldcheckDone">DOC_FieldcheckDone</option>
	            		<option value="DOC_Incomplete">DOC_Incomplete</option>
	            		<option value="Field Check">Field Check</option>
	            		<option value="Pending Approver">Pending Approver</option>
	            		<option value="Sendback">Sendback</option>
	            	</select>
	            </td>
	        </tr>
	        
	        <tr id="filter_col11" data-column="10">
	            <td>Status Date</td>
	            <td>
	            	<div class="input-control text field_tablimitText">
	            		<input id="status_date" type="text" value="">
	            	</div>
	            </td>
	        </tr>
	        
	        <tr id="filter_col12" data-column="11">
	            <td>Approved Amount</td>
	            <td id="filter_col12_am" align="center">	            	
		            <span class="input-control text field_tablimitText"><input id="col11_filter_start" type="text" value=""></span>
		            <span class="input-control text field_tablimitText"><input id="col11_filter_end" type="text" value=""></span>     	
	           	</td>
	        </tr>
	        
	        <tr id="filter_col13" data-column="12">
	            <td>Drawdown Plan Date</td>
	            <td><div class="input-control text field_tablimitText"><input id="plandrawdown_date" type="text" value=""></div></td>
	        </tr>
	        
	        <tr id="filter_col14" data-column="13">
	            <td>Actual Drawdown Date</td>
	            <td><div class="input-control text field_tablimitText"><input id="actualdrawdown_date" type="text" value=""></div></td>
	        </tr>
	        
	        <tr id="filter_col15" data-column="14">
	            <td>Drawdown Amount</td>
	            <td id="filter_col15_dm" align="center">	            	
	            	<span class="input-control text field_tablimitText"><input id="col14_filter_start" type="text" value=""></span>
	            	<span class="input-control text field_tablimitText"><input id="col14_filter_end" type="text" value=""></span>
	            </td>
	        </tr>
	                     
	        <tr id="filter_col17" data-column="16">
	            <td style="visibility: hidden">Column - Drawdown Amount</td>
	        </tr>
	        
	        <tr>
	        	<td></td>
	        	<td>	   
	        		<div class="input-control" style="float: right;">
	        			<button type="button" id="filterClear_table" class="bg-amber fg-white" style="height: 33px; float: right;">RESET</button>
						<button id="filterSubmit_table"  type="button" class="bg-lightBlue fg-white" style="height: 33px; float: right; margin-right: 5px;">
							<i class="icon-search on-left"></i>SEARCH
						</button>				
					</div>			
				</td>
	        </tr>
	        
        </tbody>
    </table>
</div>

<section class="print_hold" style="float: right; margin-top: 25px; margin-right: 10px;">
	<span data-role="input-control" style="margin-right: 10px;" data-hint="Refresh Page" data-hint-position="top" width="3%">
		<a id="refresh_pages" href="#" class="fg-lightBlue"><i class="fa fa-refresh on-left"></i> 
		<span>REFRESH</span></a>
	</span>        
</section>

<?php 
if(!empty($_GET['search_kpi'])) { 
	$kpi = !empty($_GET['kpino']) ? $this->input->get('kpino'):'';
	if($kpi == '6') {
?>
	<div id="showModeKPIState" style="position: absolute; float: left; margin-top: 5px; margin-left: 180px; font-size: 0.9em;">
		<div class="input-control radio">
			<label>
				<input id="ac2ca_checkbox1" name="a2ca_kpi" type="radio" value="A2CA_CRAC" checked="checked">
				<span class="check"></span> A2CA <small>(Current Month)</small>
			</label>
		</div>
		<div class="input-control radio marginLeft5">
			<label>
				<input id="ac2ca_checkbox2" name="a2ca_kpi" type="radio" value="A2CA_AC">
				<span class="check"></span> A2CA <small>(Total Active)</small>
			</label>
		</div>
	</div>
<?php } ?>
<?php } ?>

<div id="showNumRecord" style="position: absolute; float: left; margin-top: 38px; font-size: 0.9em;"></div>

<!-- position: absolute; float: left; margin-left: 9.5em; margin-top: 7px; -->

<div id="dateonhand" style="display: none;">
	<div style="background-color: #D1D1D1; border: 1px dotted red; padding: 2px; font-weight: bold; margin: 3px 0;">Plan A2CA (ปกติ)</div>	
	<div style="background-color: #E3C800; border: 1px dotted red; padding: 2px; font-weight: bold; margin: 3px 0;">Plan A2CA (เลื่อนครั้งที่ 2)</div>
	<div style="background-color: #f16464; color: #000; border: 1px dotted #000; padding: 2px; font-weight: bold; margin: 3px 0;">Plan A2CA (เลื่อนครั้งที่ 3 หรือมากกว่า)</div>
	<div><i class="fa fa-circle fg-black"></i> HQ Received</div>
	<div><i class="fa fa-circle fg-blue"></i> HO2CA</div>		
	<div><i class="fa fa-circle fg-green"></i> A2CA</div>
</div>

<div id="status_detail" style="display: none;">
	<div><i class="fa fa-circle" style="color: #4390DF;"></i> Score-Pass (สามารถทำ RM Way ได้)</div>
	<div><i class="fa fa-circle" style="color: #199a11;"></i> ส่งประเมินแล้ว</div>
	<div><i class="fa fa-circle" style="color: #fa6800;"></i> รับเล่มประเมินแล้ว</div>
	<div><i class="fa fa-circle" style="color: red;"></i> หนังสือรับรองกรรมสิทธิสิ่งปลูกสร้างไม่สมบูรณ์</div>
</div>

<div id="table_content_print">
<div class="table-responsive">

<input id="AuthCode" name="AuthCode" type="hidden" value="<?php echo implode(',', $session_data['auth']); ?>">
<input id="Emp_ID" name="Emp_ID" type="hidden" value="<?php echo $session_data['emp_id']; ?>">
<input id="Region_ID" name="Region_ID" type="hidden" value="<?php echo $session_data['region_id']; ?>">
<input id="BranchCode" name="BranchCode" type="hidden" value="<?php echo $session_data['branchcode']; ?>">

<table id="whiteboard" class="table bordered hovered">
	<thead>
	    <tr class="brands">
	        <th colspan="2" style="vertical-align: middle;">DATE</th>
	        <th colspan="4" class="text-center">NAME</th>
	        <th colspan="3" class="text-center">LOAN REQUEST</th>
	        <th colspan="2" class="text-center">APP TO CA</th>
	        <th colspan="4" class="text-center">STATUS ( P / A / R / C ) & CR  </th>
	        <th colspan="4" class="text-center">DRAWDOWN DATE</th>
	        <th width="110px" style="border-bottom: 0; vertical-align: middle;"></th>
	        <th rowspan="2" style="border-bottom: 0; border-left: 0px; display: none;"></th>
	        <th style="vertical-align: middle; border-bottom: 0px; border-left: 0px; visibility: visible;">&nbsp;</th>
	        <th rowspan="2" style="vertical-align: middle; border-bottom: 0px; border-left: 0px; display: none;">&nbsp;</th>
	    </tr>
	    <tr class="brands">
	        <th style="text-align: center; min-width: 40px !important; vertical-align: middle;">START</th>
	        <th style="text-align: center; min-width: 10px !important; vertical-align: middle;"><abbr title="DAY" style="border:none;"><i class="fa fa-flag-o print_hold"></i></abbr></th>
	        <th style="text-align: center; min-width: 80px !important; vertical-align: middle;">
	        	<abbr title="Customer" style="border:none;">CUSTOMER</abbr>
	        </th>
	        <th style="text-align: center; min-width: 80px !important; vertical-align: middle;">RM</th>
	        <th style="text-align: center; min-width: 10px !important; vertical-align: middle;">REGION</th>
	        <th style="text-align: center; min-width: 30px !important; vertical-align: middle;">
	        	<abbr title="Branch" style="border:none;">LB</abbr>
	        </th>
	        <th style="text-align: center; min-width: 50px !important; vertical-align: middle;">
	        	<abbr title="Product Program" style="border:none;">PG</abbr>
	        </th>
	        <th style="text-align: center; min-width: 50px !important; max-width: 50px !important; vertical-align: middle;">
	        	<abbr title="Amount" style="border:none;">AMT</abbr>
	        </th>
	        <th style="text-align: center; min-width: 10px !important; vertical-align: middle;"><abbr title="DAY" style="border:none;"><i class="fa fa-flag-o print_hold"></i></abbr></th>
	        <th style="text-align: center; min-width: 40px !important; vertical-align: middle;">
	        	<span id="parent_dateonhand" class="show-pop" data-placement="top-right" style="font-weight: bold;">DATE <i class="fa fa-info-circle print_hold"></i></span>
	        </th>
	        <th style="text-align: center; min-width: 80px !important; vertical-align: middle;">NAME</th>
	        <th style="text-align: center; min-width: 40px !important; vertical-align: middle;">
	        	<span id="parent_status_detail" class="show-pop" data-placement="top-right"><abbr title="Status" style="border:none;">ST</abbr> <i class="fa fa-info-circle print_hold"></i></span>
	        </th>
	        <th style="text-align: center; min-width: 40px !important; vertical-align: middle;">DATE</th>
	        <th style="text-align: center; min-width: 50px !important; vertical-align: middle;">
	        	<abbr title="Amount" style="border:none;">AMT</abbr>
	        </th>
	        <th style="text-align: center; min-width: 10px !important; vertical-align: middle;"><abbr title="DAY" style="border:none;"><i class="fa fa-flag-o print_hold"></i></abbr></th>
	        <th style="text-align: center; min-width: 40px !important; vertical-align: middle;">PLAN</th>
	        <th style="text-align: center; min-width: 65px !important; vertical-align: middle;">ACTUAL</th>
	        <th style="text-align: center; min-width: 50px !important; vertical-align: middle;">
	        	<abbr title="Amount" style="border:none;">AMT</abbr>
	        </th>
	        <th style="text-align: center; min-width: 10px !important; vertical-align: middle;">
	        	<abbr title="DAY" style="border:none;"><i class="fa fa-flag-o print_hold"></i></abbr>
	        </th>
	        <th style="vertical-align: middle; border-right: 0px;">ACTION NOTE</th>
	        <th style="vertical-align: middle; display: none;">*</th>
	        <th style="vertical-align: middle; border-left: 0px; border-top: 0px; visibility: visible; max-width: 25px;">&nbsp;</th>	        
	    </tr>
    </thead>
	<tbody></tbody>
	<tfoot style="font-size: 1.1em;">
    	<tr style="color: #0000FF; font-weight: bold;">
			<th colspan="7" class="text-left">TOTAL <span id="whiteboard_footer_total"></span> : </th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>	
			<th></th>
			<th></th>
			<th></th>
			<th></th>	
			<th></th>
			<th></th>	
			<th></th>	
			<th></th>				
			<th></th>	
     	</tr>     	
    </tfoot>
	</table>
</div>
</div>

<!-- Start Modal -->
<div id="modalPersonInfo" class="modal fade print_hold" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button id="document_support" type="button" class="bg-teal place-left fg-white" disabled="disabled">
				   	<i class="fa fa-sticky-note "></i> แบบฟอร์ม
				</button>
				<button id="documentoption_support" type="button" class="bg-darkBlue place-left fg-white" onclick="genLinkDefaultPDF('<?php echo base_url('template/เอกสารทดแทน.pdf'); ?>');" style="margin-left: 10px;">
				   	<i class="fa fa-sticky-note "></i> เอกสารทดแทนหนังสือรับรองกรรมสิทธ์ สปส.
				</button>
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: none;"><span aria-hidden="true">&times;</span></button>
            	<?php $collecteral_uri  = $this->config->item('collateral_uri'); ?>
            	<div class="button-set place-right">
				    <a href="<?php echo $collecteral_uri . '?UserID=' . $session_data['xuser']; ?>" target="_blank">
				    	<button class="bg-darkBlue fg-white tooltip-bottom" data-tooltip="Link: Collateral Appraisal System"><i class="fa fa-laptop"></i> Collateral</button>
				    </a>
				    <button id="document_closeModal" type="button" class="bg-amber fg-white tooltip-bottom" data-tooltip="Close Popup" onclick="$('#modalPersonInfo').modal('hide');">
				    	<i class="fa fa-close"></i> Close
				    </button>
				</div>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
	       	<div class="modal-body">
	       	   <!-- <embed src="http://172.17.9.94/newservices/LBServices.svc/pcis/document/file/02-59-005333/25590620_2.pdf" type="application/pdf" width="100%" height="300px" internalinstanceid="46" style="overflow-x: none;"> -->	      
	           <div class="grid fluid text-center">
	           		<div id="pdf_thumbnail" class="content mCS-light-thin mCS-autoHide"></div>	         
	           </div>
	       	</div>
	       	<div class="modal-footer">
	       		                        	
			</div>
		</div>
	</div>
</div>
<!-- End Modal -->

<div class="container" style="margin-top: 30px; margin-left: -1px;">
	<?php echo $footer; ?>
</div>

<div id="tagscript_option">
<script type="text/javascript">

$(function() {

	$('#fttab').remove();
	$('title').text('Whiteboard');
		
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

    $('#headers').addClass('animated rubberBand');
    $('#timestemps').addClass('animated rubberBand');
    $('#basicSearch').addClass('animated fadeInDown');

    /* ############ KPI ############ */
    
    var search_kpi = $('#search_kpi').val();
    var kpino	   = $('#kpino').val();
    var emp_kpi	   = $('#empcode_kpi').val();
    var is_actived = $('#is_actived').val();
    var use_ca	   = $('#use_ca').val();
    var mode_kpi   = $('#mode_kpi').val();
   
    if(search_kpi) {
     
        // Set Title
        switch(kpino) {
	    	case '4': $('title').text('KPI - App on RM hand'); break;
	    	case '6': $('title').text('KPI - A2CA'); break;
	    	case '7': $('title').text('KPI - Re-Activation'); break;
	    	case '8': $('title').text('KPI - Non Quality App'); break;
	    	case '9': $('title').text('KPI - Cancel Before CA Process'); break;
	    	case '10': $('title').text('KPI - Retrieve Case'); break;
	    	case '12': $('title').text('KPI - Total New App'); break;
	    	case '14': $('title').text('KPI - Approved App'); break;
	    	case '15': $('title').text('KPI - Rejection App'); break;
	    	case '16': $('title').text('KPI - Cancel App'); break;
	    	case '17': $('title').text('KPI - Pending App'); break;
	    	case '18': $('title').text('KPI - Referral Volume'); break;
	    	case '20': $('title').text('KPI - SB Volume'); break;
	    	case '21': $('title').text('KPI - Pending DD'); break;
	    	case '22': $('title').text('KPI - Secure Loan App'); break;
        }  
    
    }

    /* ############ END ############ */
	
    var selected   = '';
    var searchTool = $("#search_toggler");
    var dashboard  = $('#whiteboard');
    var table = dashboard.dataTable({
    	"processing": true,
	    "serverSide": true,
        "oLanguage": {
        	"sProcessing": '<div><img src="' + window.location.protocol + "//" + window.location.host + '/pcis/img/378_1.gif"' + '></div>'
        },
        "bFilter": false,
        "ajax": {
            "url": pathFixed + 'metro/dashboard_loader',
            "type": "POST",
			"beforeSend": function() {
				//$('#overlay').show();
			},
			//"dom": 'Bfrtip',
			//"buttons": ['pdf', 'print'],
            "data": function(d) {

                if(search_kpi) {
                    // # Passive
                	d.search_kpi	= search_kpi;
                	d.mode_kpi		= mode_kpi;
					d.kpino			= kpino;					
					d.activerecords = is_actived;
					d.modestate		= $('#modestate_kpi').val();
					
                    // # Active
					d.use_ca		= use_ca;
					d.emp_auth		= emp_kpi;
									
                } else {
                	d.activerecords = $('input[name="inlineCheckbox"]:checked').val();
                }
                   	
                d.refer_tlf     = $('#refer_check_hidden').val();
                d.regionid      = $('#regions_hidden').val();
                d.branchdigit	= $('#branchs_hidden').val();
                d.ownerName     = $('#customer_hidden').val();
                d.rmname 	    = $('#rmname_hidden').val();
                d.cashy_field	= $('input[name="cashy_field"]:checked').val();

                d.ncb_start 	= $('#ncb_start_hidden').val();
                d.ncb_end   	= $('#ncb_end_hidden').val();
                d.loantype		= $('#loantype_hidden').val();
                d.product		= $('#products_hidden').val();
                d.rqloan_start	= $('#request_start_hidden').val();
                d.rqloan_end	= $('#request_end_hidden').val();
                d.planapp_start	= $('#appplanstart_date_hidde').val();
                d.planapp_end	= $('#appplanend_date_hidde').val();
                d.dateca_start  = $('#apptoca_start_hidden').val();
                d.dateca_end 	= $('#apptoca_end_hidden').val();
                d.caname		= $('#caname_hidden').val();
                d.status 		= $('#status_hidden').val();
                d.status_reason	= $('#status_hidden_reason').val();
                d.stdate_start	= $('#statusdate_start_hidden').val();
                d.stdate_end	= $('#statusdate_end_hidden').val();
                d.appLoan_start = $('#approved_start_hidden').val();
                d.appLoan_end	= $('#approved_end_hidden').val();
                d.plandate_st	= $('#drawdown_startplan_hidden').val();
                d.plandate_ed	= $('#drawdown_endplan_hidden').val();
                d.dddate_start	= $('#drawdown_startactual_hidden').val();
                d.dddate_end	= $('#drawdown_endactual_hidden').val();
                d.actualbaht_st	= $('#drawdown_start_hidden').val();
                d.actualbaht_ed = $('#drawdown_end_hidden').val();	

                d.drawdown_cm	  = $('input[name="drawdown_cm"]:checked').val(); 
                d.filter_cncancel = $('input[name="filter_cncancel"]:checked').val();
                 
            },
            "complete":function(data, callback) {

            	//$('#whiteboard').find('tbody > tr').addClass('animated fadeIn');

				$('#overlay').hide();
                $('#whiteboard tbody tr').each(function(e) {
                    
                	var objRow = $(this).find('td:nth-child(11), td:nth-child(16), td:nth-child(22)');		
					if(removeTags(objRow[0].innerHTML) == "A" && objRow[1].innerHTML !== '' && objRow[1].innerHTML !== '01/01/1900') {
				
						if(objRow[2].innerHTML == "RT") {
							$(this).addClass('re_active');
						} 
						else if(objRow[2].innerHTML == "RA") {
							$(this).addClass('successes');
						} 
						else {
							//$(this).addClass('inactive');
						}
						

					} else if(removeTags(objRow[0].innerHTML) == "R" || removeTags(objRow[0].innerHTML) == "C") {
						
						if(objRow[2].innerHTML == "RT") {
							$(this).addClass('re_active');
						} 
						else if(objRow[2].innerHTML == "RA") {
							$(this).addClass('successes');
						} 
						else {
							//$(this).addClass('inactive');
						}

					} else {
						
						var setRow = $(this).find('td:nth-child(22)');	
						if(setRow[0].innerHTML == "RT") {
							$(this).addClass('re_active');

						} else if(setRow[0].innerHTML == "RA") {
							$(this).addClass('successes');

						}
			
					}
	
            	}); 
                
                //cloneToTop('whiteboard_info', 'showNumRecord')
                $('#showNumRecord').text($('#whiteboard_info').text()); //.toLowerCase()
                $('#whiteboard_info').css('visibility', 'hidden');

                // UI Holding
                $('#panel_reconsiledoc > .panel-content').hide(500, function() {
                    $(this).css('display', 'none');
                });
				
                $("#search_div").animate({ left: '10px' }, 1000 ).removeClass('open').addClass('wrapper_searchDiv');
              
                getSummaryLoanInDashboard(); // Loading Grand Loan
 
            }
        },
        "columns": [
        	{ "data": "StartDate" },
        	{ "data": "Days" },
        	{ "data": "OwnerName" },
            { "data": "RMName" },
            { "data": "Region" },
            { "data": "BranchDigit" },
            { "data": "ProductCode" },
			{ "data": "RequestLoan" },
			{ "data": "DayGate1" },
			{ "data": "CA_ReceivedDocDate" },
			{ "data": "CAName" },
			{ "data": "Status" },
			{ "data": "StatusDate" },
			{ "data": "ApprovedLoan" },
			{ "data": "DayGate2" },
			{ "data": "PlanDrawdownDate" },
			{ "data": "DrawdownDate" },
			{ "data": "DrawdownBaht" },
			{ "data": "DayGate3" },
			{ "data": "ActionNote" },
			{ "data": "DocID" },			
			{ "data": "Links" },
			{ "data": "Re_Record" }			
        ],         
        "columnDefs": [
       		{ "visible": true, "targets": 0, type: 'date-eu' },
       		{ "visible": true, "targets": 1, 'bSortable': false },
			{ "visible": false, "targets": 4 },
			{ "visible": true, "targets": 5 },
			{ "visible": true, "targets": 8, 'bSortable': false },
			{ "visible": true, "targets": 9, type: 'date-eu' },
			{ "visible": true, "targets": 10 },
			{ "visible": true, "targets": 12, type: 'date-eu' },
			{ "visible": true, "targets": 13, 'bSortable': true },
			{ "visible": true, "targets": 14, 'bSortable': false },
			{ "visible": true, "targets": 15, type: 'date-eu' },
			{ "visible": true, "targets": 16, type: 'date-eu' },
			{ "visible": true, "targets": 17, 'bSortable': true },
			{ "visible": true, "targets": 18, 'bSortable': false },
			{ "visible": true, "targets": 19, 'bSortable': false },
			{ "visible": true, "targets": 20, 'bSortable': false },
			{ "visible": true, "targets": 21, 'bSortable': false },
			{ "visible": true, "targets": 22, 'bSortable': false }
       	],
        "lengthMenu": [20, 50, 100],
        "aaSorting": [[0, 'desc']],
        "pagingType": "full_numbers",
        "footerCallback": function ( row, data, start, end, display ) {
		
            var api = this.api(), data;
            var intVal = function ( i ) {

                return typeof i === 'string' ?

                    i.replace(/[\$,]/g, '')*1 :

                    typeof i === 'number' ?

                        i : 0;

            };
            
            // Total over this page
            requestloan_total = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
            }, 0 );

            approvedloan_total = api
	            .column( 13, { page: 'current'} )
	            .data()
	            .reduce( function (a, b) {
	                return intVal(a) + intVal(b);
	        }, 0 );

            drawdownloan_total = api
	            .column( 17, { page: 'current'} )
	            .data()
	            .reduce( function (a, b) {
	                return intVal(a) + intVal(b);
	        }, 0 );


            
           
            // Update footer
            $(api.column(7).footer()).html(number_format(requestloan_total));
            $(api.column(13).footer()).html(number_format(approvedloan_total));
            $(api.column(17).footer()).html(number_format(drawdownloan_total));

        }
        
    });

    $('input[name="inlineCheckbox"]').click(function() { 
    	var mode = $('input[name="inlineCheckbox"]:checked').val()
    	if(mode == 'InActive') {    		
			table.fnSort([12, 'desc']);

			
    	} 
    });
	      
    $('#parent_dateonhand').hover(function() {
		var html = $('#dateonhand').html()
    	$(this).webuiPopover({
    		trigger:'hover',	
    		padding: true,
    		content: html,
    		backdrop: false
    	});

    });   

    $('#parent_status_detail').hover(function() {
		var html = $('#status_detail').html()
    	$(this).webuiPopover({
    		trigger:'hover',	
    		padding: true,
    		content: html,
    		backdrop: false
    	});

    });   

    searchTool.hover(function() { $(this).css('color', '#1ba1e2'); });
    searchTool.mouseout(function() { $(this).css('color', '#888'); });


    /** ###### VIEW IN KPI MODE **/
    if(search_kpi) {
        
    	// Enabeld off;
    	$('#search_div #search_toggler')
    	$('.panel-content').remove();
    	$('.link_jumper').removeAttr('href').removeAttr('target');

    	$('#ac2ca_checkbox1').click(function() {
    		$('#ac2ca_checkbox1').prop('checked', true);
    		$('#ac2ca_checkbox2').removeAttr('checked');

    		$('#modestate_kpi').val('');

    		var a2ca_kpi = $('input[name="a2ca_kpi"]:checked').val();
			$('#modestate_kpi').val(a2ca_kpi);

			table.fnFilter($(this).val());

    	});

    	$('#ac2ca_checkbox2').click(function() {
    		$('#ac2ca_checkbox2').prop('checked', true);
    		$('#ac2ca_checkbox1').removeAttr('checked');

    		$('#modestate_kpi').val('');

    		var a2ca_kpi = $('input[name="a2ca_kpi"]:checked').val();
			$('#modestate_kpi').val(a2ca_kpi);

			table.fnFilter($(this).val());
			
    	});
    	
    } else {

    	/** ###### NORMAL STATE ###### **/
        var state = true;
        searchTool.click(function() {
            
            if (state) {
                $("#search_div").animate({ left: '460px' }, 1000).removeClass('wrapper_searchDiv').addClass('open');
                
            } else {
                $("#search_div").animate({ left: '10px' }, 1000 ).removeClass('open').addClass('wrapper_searchDiv');
            }
            state = !state;
        });

    } 
    
    var product = $("#products");
    $.ajax({
        url: pathFixed+'dataloads/newproductionType?_=' + new Date().getTime(),
        type: "GET",
        success:function(data) {
            
            for(var indexed in data['data']) {
                product.prepend('<optgroup style="color: red;" label="' + data['data'][indexed]['ProductTypeName'] + '" data-core="nprd_' + data['data'][indexed]['ProductTypeID'] + '"></optgroup>');
            }

        },
        complete:function() {
            
        	$.ajax({
                url: pathFixed+'dataloads/productNewlist?_=' + new Date().getTime(),
                type: "GET",
                success:function(data) {

                    for(var indexed in data['data']) {
                        $("#products").find('optgroup[data-core="nprd_' + data['data'][indexed]['ProductTypeID'] + '"]').append("<option style=\"color: black;\" value='"+data['data'][indexed]['ProductCode']+"' data-toggle='tooltip' data-placement='right' title='"+data['data'][indexed]['ProductName']+"'>" + data['data'][indexed]['ProductTypes']+ '-' + data['data'][indexed]['ProductSub'] + ' ' + data['data'][indexed]['ProductName']+"</option>");
                    }                    

                },
                complete:function() {
                	//$('#products').change(function() {  }).multipleSelect({ width: '100%', minimumCountSelected: 1, filter: true });
                	//$('.ms-drop ul li').find('input[name^="selectItemproducts"]').css('margin-left', '20px');
                	//$('#ms_spanproducts').parent().css('max-width', '254px');
                	
                	$.ajax({
				        url: pathFixed+'dataloads/productionType?_=' + new Date().getTime(),
				        type: "GET",
				        success:function(data) {
				            
				            for(var indexed in data['data']) {
				                product.append('<optgroup class="fg-gray" label="' + data['data'][indexed]['ProductTypeName'] + '" data-core="prd_' + data['data'][indexed]['ProductTypeID'] + '"></optgroup>');
				            }
				
				
				        },
				        complete:function() {
				 
				        	$.ajax({
				                url: pathFixed+'dataloads/productlist?_=' + new Date().getTime(),
				                type: "GET",
				                success:function(data) {
				
				                    for(var indexed in data['data']) {
				                        $("#products").find('optgroup[data-core="prd_' + data['data'][indexed]['ProductTypeID'] + '"]').append("<option value='"+data['data'][indexed]['ProductCode']+"' data-toggle='tooltip' data-placement='right' title='"+data['data'][indexed]['ProductName']+"'>" + data['data'][indexed]['ProductTypes']+ '-' + data['data'][indexed]['ProductSub'] + ' ' + data['data'][indexed]['ProductName']+"</option>");
				                                  	
				                    }                    
				
				                },
				                complete:function() {
				                	$('#products').change(function() {  }).multipleSelect({ width: '100%', minimumCountSelected: 1, filter: true });
				                	$('.ms-drop ul li').find('input[name^="selectItemproducts"]').css('margin-left', '20px');
				                	$('#ms_spanproducts').parent().css('max-width', '254px');
				
				                	$('#mslist_products label[data-group="group_3"],' + 
				                      '#mslist_products label[data-group="group_4"],' +
				                      '#mslist_products label[data-group="group_5"],' +
				                      '#mslist_products label[data-group="group_6"],' +
				                      '#mslist_products label[data-group="group_7"],' +
				                      '#mslist_products label[data-group="group_8"]')
				                	.css({ 'color': 'gray' });

				                	$('#mslist_products label[data-group="group_0"], #mslist_products label[data-group="group_1"], #mslist_products label[data-group="group_2"]').css({ 'color': 'red', 'font-weight': 'bold' });
				                	$('#mslist_products label[data-group="group_0"] > option, #mslist_products label[data-group="group_1"] > option, #mslist_products label[data-group="group_2"] > option').css({ 'color': 'black' });
				                	
				                },
				                cache: true,
				                timeout: 5000,
				                statusCode: {
				                    404: function() {
				                        alert( "page not found" );
				                    }
				                }
				            });
				
				        },
				        cache: true,
				        timeout: 5000,
				        statusCode: {
				            404: function() {
				                alert( "page not found" );
				            }
				        }
				    });

                },
                cache: true,
                timeout: 5000,
                statusCode: {
                    404: function() {
                        alert( "page not found" );
                    }
                }
            });
          
            
        },
        cache: true,
        timeout: 5000,
        statusCode: {
            404: function() {
                alert( "page not found" );
            }
        }
    });
    
    

	/*
    var statusreason = $("#statusreason");
    $.ajax({
        url: pathFixed + 'dataloads/getRegisStatusReason?_=' + new Date().getTime(),
        type: "GET",
        success:function(data) {
            
            for(var indexed in data['data']) {
            	statusreason.append('<option value="' + data['data'][indexed]['PendingName'] + '">' + data['data'][indexed]['PendingName'] + '</option>');
            }


        },
        complete:function() {            
        	$('#statusreason').change(function() {  }).multipleSelect({ width: '100%', minimumCountSelected: 1 });
            
        },
        cache: true,
        timeout: 5000,
        statusCode: {
            404: function() {
                alert( "page not found" );
            }
        }
    });
	*/
	
	$('#statusreason').change(function() {  

		var select = $('#statusreason').val();
		if(select != null) {
			$('input[name="selectItemstatus"][value="PENDING"]').click();
		} else {
			$('input[name="selectItemstatus"]').prop('checked', false);
		}

	}).multipleSelect({ width: '100%', minimumCountSelected: 1 });
	
    new Kalendae.Input('ncbcheck_date', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});
    
    new Kalendae.Input('app2caplan_date', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});

	new Kalendae.Input('app2ca_date', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});

	new Kalendae.Input('status_date', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});

	new Kalendae.Input('plandrawdown_date', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});

	new Kalendae.Input('actualdrawdown_date', {
		months:2,
		mode:'range',
		format: 'DD/MM/YYYY',
		useYearNav: true
	});

	$('.kalendae').mouseleave(function () {
		$(this).hide();
		$(this).blur();
	})

   $('#col6_filter_start, #col6_filter_end, #col11_filter_start, #col11_filter_end, #col14_filter_start, #col14_filter_end').number(true, 0);

   $.ajax({
		url: pathFixed+'management/getRMListBoundaryDefault?_=' + new Date().getTime(),
		type: "GET",
		success:function(responsed) {								
			
			$('#parent_select_rmlist').html('');
			$('#parent_select_rmlist').html('<div id="rmselect_group" class="form-group"><label class="label label-clear">EMP. NAME</label><select id="rmname" name="rmname" multiple="multiple" style="width: 130px; margin-left: 5px;"></select></div>');
			for(var indexed in responsed['data']) {
				/*
				var default_kpi = '';
				if(search_kpi) {				
					if(mode_kpi === 'individual') {
						if(responsed['data'][indexed]['EmployeeCode'] == emp_kpi) { default_kpi = 'selected="selected"'; }
					}
				}
				' + default_kpi + '
				*/
		
				$('#rmname').append('<option value="' + responsed['data'][indexed]['EmployeeCode'] + '">' + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + '</option>');
				
			}

			$('#rmname').change(function() { }).multipleSelect({ width: '100%', filter: true });
						
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
					$('#parent_select_group').html('<div id="select_group" class="form-group"><label class="label label-clear">BRANCH</label><select id="branchs" name="branchs" multiple="multiple" style="width: 130px;"></select></div>');
					for(var indexed in responsed['data']) {
						$('#branchs').append("<option value='"+responsed['data'][indexed]['BranchDigit']+"'>"+ responsed['data'][indexed]['BranchDigit']+ ' - ' + responsed['data'][indexed]['BranchName']+"</option>");
					}

					$('#branchs').change(function() { console.log($(this).val()); }).multipleSelect({ width: '100%', filter: true });

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
   fnLoadRMListByRegion();
   setProductList();
   fnLoadRMList();

   $('select[name="whiteboard_length"]').prepend('<option value="10">10</option>');

   $('#filterSubmit, #filterSubmit_table').click(function () { 

	   $('#inlineCheckbox_hidden').val('');
       $('#refer_check_hidden').val('');
       //$('#defend_check_hidden').val('');
       $('#regions_hidden').val('');
       $('#branchs_hidden').val('');
       $('#customer_hidden').val('');
       $('#rmname_hidden').val('');

       $('#ncb_start_hidden').val('');
       $('#ncb_end_hidden').val('');
       $('#products_hidden').val('');
       $('#loantype_hidden').val('');
       $('#request_start_hidden').val('');
       $('#request_end_hidden').val('');
       $('#appplanstart_date_hidde').val('');
       $('#appplanend_date_hidde').val('');       
       $('#apptoca_start_hidden').val('');
       $('#apptoca_end_hidden').val('');
       $('#caname_hidden').val('');
       $('#status_hidden').val('');
       $('#status_hidden_reason').val();
       $('#statusdate_start_hidden').val('');
       $('#statusdate_end_hidden').val('');
       $('#approved_start_hidden').val('');
       $('#approved_end_hidden').val('');
       $('#drawdown_startplan_hidden').val('');
       $('#drawdown_endplan_hidden').val('');
       $('#drawdown_startactual_hidden').val('');
       $('#drawdown_endactual_hidden').val('');
       $('#drawdown_start_hidden').val('');
       $('#drawdown_end_hidden').val('');

       var objncb_date 		 = $('#ncbcheck_date').val();
       var objrmname		 = $('#rmname').val();
       var objownerName 	 = $('#customer').val();
       var objcaname		 = $('#caname').val();
       var objregionid		 = $('select[name="regions"] option:selected').val();
       var objbranchdigit	 = $('#branchs').val();
       var objloantype 		 = $('#loantype').val();
       var objproduct		 = $('#products').val(); //$('select[name="products"] option:selected').val();
       var objrqloan_start	 = $('#col6_filter_start').val();
       var objrqloan_end	 = $('#col6_filter_end').val();       
       var objplanca_date    = $('#app2caplan_date').val();
       var objdateca_date    = $('#app2ca_date').val();
       var objstatus 		 = $('#status').val(); //$('select[name="status"] option:selected').val();
       var objstatus_reason  = $('#statusreason').val();
       var objstdate_date	 = $('#status_date').val();
       var objappLoan_start  = $('#col11_filter_start').val();
       var objappLoan_end	 = $('#col11_filter_end').val();
       var objplandate  	 = $('#plandrawdown_date').val();
       var objdddate_start	 = $('#actualdrawdown_date').val();
       var objactualbaht_st	 = $('#col14_filter_start').val();
       var objactualbaht_ed  = $('#col14_filter_end').val();
       var objactiverecords  = $('input[name="inlineCheckbox"]:checked').val();
       var objrefer 		 = $('#refer_check').val();//$('input[name="refer_check"]:checked').val();

       var pattern 	   	     = new RegExp("-");

	   var ncb_res 		     = pattern.test(objncb_date);
	   var app2ca_planres    = pattern.test(objplanca_date);
	   var app2ca_res	     = pattern.test(objdateca_date);
	   var state_res	     = pattern.test(objstdate_date);
	   var plan_res 	     = pattern.test(objplandate);
	   var actual_res 	     = pattern.test(objdddate_start);

	   var ncbstart_date   	 = '',
		   ncbend_date 	   	 = '',
		   appplanstart_date = '',
		   appplanend_date 	 = '',
		   app2castart_date	 = '',
		   app2caend_date	 = '',
		   statestart_date	 = '',
		   stateend_date	 = '',
		   planstart_date	 = '',
		   planend_date		 = '',
		   actualstart_date	 = '',
		   actualend_date	 = '';

	   if(ncb_res) {
		   var item   	    = objncb_date.split("-");
		   ncbstart_date    = item[0].trim();
		   ncbend_date	   	= item[1].trim();

	   } else { ncbstart_date	    = objncb_date }
	   
	   if(app2ca_planres) {
		   var item   	     = objplanca_date.split("-");
		   appplanstart_date = item[0].trim();
		   appplanend_date	 = item[1].trim();

	   } else { appplanstart_date	= objplanca_date }

	   if(app2ca_res) {
		   var item   	    = objdateca_date.split("-");
		   app2castart_date = item[0].trim();
		   app2caend_date	= item[1].trim();

	   } else { app2castart_date	= objdateca_date }

	   if(state_res) {
		   var item   	    = objstdate_date.split("-");
		   statestart_date  = item[0].trim();
		   stateend_date	= item[1].trim();

	   } else { statestart_date	    = objstdate_date }

	   if(plan_res) {
		   var item   	    = objplandate.split("-");
		   planstart_date	= item[0].trim();
		   planend_date		= item[1].trim();

	   } else { planstart_date	    = objplandate }

	   if(actual_res) {
		   var item   	    = objdddate_start.split("-");
		   actualstart_date	= item[0].trim();
		   actualend_date	= item[1].trim();

	   } else { actualstart_date	= objdddate_start }

	   $('#inlineCheckbox_hidden').val(objactiverecords);
       $('#refer_check_hidden').val(objrefer);
       //$('#defend_check_hidden').val(objdefend);
       $('#regions_hidden').val(objregionid);
       $('#branchs_hidden').val(objbranchdigit);
       $('#customer_hidden').val(objownerName);
       $('#rmname_hidden').val(objrmname);

       $('#ncb_start_hidden').val(ncbstart_date);
       $('#ncb_end_hidden').val(ncbend_date);
       $('#products_hidden').val(objproduct);
       $('#loantype_hidden').val(objloantype);
       $('#request_start_hidden').val(objrqloan_start);
       $('#request_end_hidden').val(objrqloan_end);
       $('#appplanstart_date_hidde').val(appplanstart_date);
       $('#appplanend_date_hidde').val(appplanend_date);         
       $('#apptoca_start_hidden').val(app2castart_date);
       $('#apptoca_end_hidden').val(app2caend_date);
       $('#caname_hidden').val(objcaname);
       $('#status_hidden').val(objstatus);
       $('#status_hidden_reason').val(objstatus_reason);
       $('#statusdate_start_hidden').val(statestart_date);
       $('#statusdate_end_hidden').val(stateend_date);
       $('#approved_start_hidden').val(objappLoan_start);
       $('#approved_end_hidden').val(objappLoan_end);
       $('#drawdown_startplan_hidden').val(planstart_date);
       $('#drawdown_endplan_hidden').val(planend_date);
       $('#drawdown_startactual_hidden').val(actualstart_date);
       $('#drawdown_endactual_hidden').val(actualend_date);
       $('#drawdown_start_hidden').val(objactualbaht_st);
       $('#drawdown_end_hidden').val(objactualbaht_ed);

       table.fnFilter($(this).val()); 

   });

   $('#filterClear').click(function() { 

	    $('#regions').val('');	    
		$('#branchs').val('');			
		$('#statusreason').val('');	

		$('.ms-choice > span').text('');
		$('input[name="selectItembranchs"]').prop('checked', false);
		$('input[name="selectItemrefer_check"]').prop('checked', false);
		$('input[name="selectItemrmname"]').prop('checked', false);
		$('input[name="selectItemstatusreason"]').prop('checked', false);

		
		$('#products').val('');	
		$('input[name="selectItemloantype"]').prop('checked', false);	
		$('input[name="selectItemproducts"]').prop('checked', false);

		$('input[name^="selectAll"]').prop('checked', false);
		$('input[name^="selectGroup"]').prop('checked', false);

		$('#products').val('');
		$('#rmname').val('');
		$('#customer').val('');
		$('#caname').val('');

	    $('#ncbcheck_date').val("");
	    $('#app2caplan_date').val("");
	    $('#app2ca_date').val("");
	    $('#status_date').val("");
	    $('#plandrawdown_date').val("");
	    $('#actualdrawdown_date').val("");
	
		$('#inlineCheckbox1').prop( "checked", true );
		$('input[name="inlineCheckbox"]:checked').val('Active');
		
		$('#col0_filter_start, #col0_filter_end').val('');
		//$('#col1_filter_start, #col1_filter_end').val('');
		$('#col7_filter_start, #col7_filter_end').val('');
		$('#col10_filter_start, #col10_filter_end').val('');		
		$('#col12_filter_start, #col12_filter_end').val('');
		$('#col13_filter_start, #col13_filter_end').val('');
	
		
		$('#col6_filter_start').val('');
		$('#col6_filter_end').val('');
		$('#col11_filter_start').val('');
		$('#col11_filter_end').val('');
		$('#col14_filter_start').val('');
		$('#col14_filter_end').val('');
	   	
	   	$('#refer_check').prop('checked', false);

		$('#drawdown_cm').prop('checked', false); 
        $('#filter_cncancel').prop('checked', false);
    	$('input[name="cashy_field"]').prop('checked', false);
	   	
        //$('#defend_check').prop('checked', false);

        // Hidden Field
        $('#inlineCheckbox_hidden').val('');
        $('#refer_check_hidden').val('');
        //$('#defend_check_hidden').val('');
        $('#regions_hidden').val('');
        $('#branchs_hidden').val('');
        $('#customer_hidden').val('');
        $('#rmname_hidden').val('');

        $('#ncb_start_hidden').val('');
        $('#ncb_end_hidden').val('');
        $('#products_hidden').val('');
        $('#loantype_hidden').val('');
        $('#request_start_hidden').val('');
        $('#request_end_hidden').val('');
        $('#appplanstart_date_hidde').val('');
        $('#appplanend_date_hidde').val('');       
        $('#apptoca_start_hidden').val('');
        $('#apptoca_end_hidden').val('');
        $('#caname_hidden').val('');
        $('#status_hidden').val('');
        $('#statusdate_start_hidden').val('');
        $('#statusdate_end_hidden').val('');
        $('#approved_start_hidden').val('');
        $('#approved_end_hidden').val('');
        $('#drawdown_startplan_hidden').val('');
        $('#drawdown_endplan_hidden').val('');
        $('#drawdown_startactual_hidden').val('');
        $('#drawdown_endactual_hidden').val('');
        $('#drawdown_start_hidden').val('');
        $('#drawdown_end_hidden').val('');
     
        reloadStatus();
        reloadProducts();
        fnLoadBranchList();
		//table.fnFilter($(this).val());		
		
	});

	$('#filterClear_table').click(function() {
		
		$('#inlineCheckbox1').prop( "checked", true );
		$('input[name="inlineCheckbox"]:checked').val('Active');


		$('#ms_spanloantype > span').text('');
		$('#ms_spanproducts > span').text('');
		$('#ms_spanstatusreason > span').text('');

		$('input[name="selectItemloantype"]').prop('checked', false);	
		$('input[name="selectItemproducts"]').prop('checked', false);		
		$('input[name="selectItemstatusreason"]').prop('checked', false);

		$('input[name^="selectAllloantype"]').prop('checked', false);
		$('input[name^="selectGrouploantype"]').prop('checked', false);
		$('input[name^="selectAllproducts"]').prop('checked', false);
		$('input[name^="selectGroupproducts"]').prop('checked', false);
		$('input[name^="selectAllstatusreason"]').prop('checked', false);
		$('input[name^="selectGroupstatusreason"]').prop('checked', false);
		$('input[name="cashy_field"]').prop('checked', false);

		$('#caname').val('');		
		$('#ncbcheck_date').val("");
	    $('#app2caplan_date').val("");
		$('#app2ca_date').val("");
		$('#status_date').val("");
		$('#plandrawdown_date').val("");
		$('#actualdrawdown_date').val("");
		
		
		$('#col0_filter_start, #col0_filter_end').val('');
		$('#col7_filter_start, #col7_filter_end').val('');
		$('#col10_filter_start, #col10_filter_end').val('');		
		$('#col12_filter_start, #col12_filter_end').val('');
		$('#col13_filter_start, #col13_filter_end').val('');
	
		
		$('#col6_filter_start').val('');
		$('#col6_filter_end').val('');
		$('#col11_filter_start').val('');
		$('#col11_filter_end').val('');
		$('#col14_filter_start').val('');
		$('#col14_filter_end').val('');
	   	
        // Hidden Field
        $('#inlineCheckbox_hidden').val('');
 
        $('#ncb_start_hidden').val('');
        $('#ncb_end_hidden').val('');
        $('#products_hidden').val('');
        $('#request_start_hidden').val('');
        $('#request_end_hidden').val('');
        $('#appplanstart_date_hidde').val('');
        $('#appplanend_date_hidde').val('');       
        $('#apptoca_start_hidden').val('');
        $('#apptoca_end_hidden').val('');
        $('#caname_hidden').val('');
        $('#status_hidden').val('');
        $('#statusdate_start_hidden').val('');
        $('#statusdate_end_hidden').val('');
        $('#approved_start_hidden').val('');
        $('#approved_end_hidden').val('');
        $('#drawdown_startplan_hidden').val('');
        $('#drawdown_endplan_hidden').val('');
        $('#drawdown_startactual_hidden').val('');
        $('#drawdown_endactual_hidden').val('');
        $('#drawdown_start_hidden').val('');
        $('#drawdown_end_hidden').val('');


        reloadStatus();
        reloadProducts();
        			
   });

   $('#cashy_field1').click(function() {
		if($(this).is(':checked')) {
			 $('#cashy_field2').prop('checked', false);
		}
   });

   $('#cashy_field2').click(function() {
		if($(this).is(':checked')) {
			 $('#cashy_field1').prop('checked', false);
		}
  });

   function fnLoadRMList() {
		
		$('#branchs').on('change', function () { 
			
		  	var branch_code	= $("#branchs").val();					  

			 $.ajax({
				url: pathFixed+'dataloads/getRMListBoundary?_=' + new Date().getTime(),
				type: "POST",
				data: { branchcode:branch_code },
				success:function(responsed) {								
					
					$('#parent_select_rmlist').html('');
					$('#parent_select_rmlist').html('<div id="rmselect_group" class="form-group"><label class="label label-clear">EMP. NAME</label><select id="rmname" name="rmname" multiple="multiple" style="width: 130px; margin-left: 5px;"></select></div>');
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
		

	function getSummaryLoanInDashboard() {

		var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
	    var pathFixed = window.location.protocol + "//" + window.location.host;
	    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
	    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

		$.ajax({
	        url: pathFixed+'metro/getSummaryLoanDashboard?_=' + new Date().getTime(),
	        type: "POST",
	        data: { 
			
                search_kpi: (search_kpi) ? search_kpi:'',
				kpino: (search_kpi) ? kpino:'',					
				use_ca: (search_kpi) ? use_ca:'',
				emp_auth: (search_kpi) ? emp_kpi:'',
				mode_kpi: (search_kpi) ? mode_kpi:'',
				modestate: (search_kpi) ? $('#modestate_kpi').val():'',						
		
                activerecords: (search_kpi) ? is_actived:$('input[name="inlineCheckbox"]:checked').val(),
                		
	            refer_tlf     : $('#refer_check_hidden').val(),
	            regionid      : $('#regions_hidden').val(),
	            branchdigit	  : $('#branchs_hidden').val(),
	            ownerName     : $('#customer_hidden').val(),
	            rmname 	      : $('#rmname_hidden').val(),
	
	            ncb_start 	  : $('#ncb_start_hidden').val(),
	            ncb_end   	  : $('#ncb_end_hidden').val(),
	            product		  : $('#products_hidden').val(),
	            loantype	  : $('#loantype_hidden').val(),
	            rqloan_start  : $('#request_start_hidden').val(),
	            rqloan_end	  : $('#request_end_hidden').val(),
	            planapp_start : $('#appplanstart_date_hidde').val(),
                planapp_end	  : $('#appplanend_date_hidde').val(),
	            dateca_start  : $('#apptoca_start_hidden').val(),
	            dateca_end 	  : $('#apptoca_end_hidden').val(),
	            caname		  : $('#caname_hidden').val(),
	            status 		  : $('#status_hidden').val(),
	            status_reason : $('#status_hidden_reason').val(),
	            stdate_start  : $('#statusdate_start_hidden').val(),
	            stdate_end	  : $('#statusdate_end_hidden').val(),
	            appLoan_start : $('#approved_start_hidden').val(),
	            appLoan_end	  : $('#approved_end_hidden').val(),
	            plandate_st	  : $('#drawdown_startplan_hidden').val(),
	            plandate_ed	  : $('#drawdown_endplan_hidden').val(),
	            dddate_start  : $('#drawdown_startactual_hidden').val(),
	            dddate_end	  : $('#drawdown_endactual_hidden').val(),
	            actualbaht_st : $('#drawdown_start_hidden').val(),
	            actualbaht_ed : $('#drawdown_end_hidden').val(),
	            drawdown_cm	  : $('input[name="drawdown_cm"]:checked').val(),
                filter_cncancel : $('input[name="filter_cncancel"]:checked').val(),
                cashy_field	  :$('input[name="cashy_field"]:checked').val()
                
		    },
	        success:function(data) {	        
		
	        	var records  = data['data'][0]['RowRecord'];
				var request_load  = data['data'][0]['RequestLoan'];
	            var approved_load = data['data'][0]['ApprovedLoan'];
	            var drawdown_load = data['data'][0]['DrawdownBaht'];
	            
				var row_records = $('#whiteboard tbody tr').length;
	            var grand_total = $('#whiteboard').find('tfoot tr').length;
			
				if(grand_total > 1) {
					 $('#whiteboard').find('tfoot tr:last-child').remove();
				}				

				var pages_length = $('#whiteboard_length option:selected').val();

				var total_pages  = records / pages_length;
								
	            $('#whiteboard').find('tfoot tr:last-child').after(
                	'<tr class="brands">'+
            			'<th colspan="6" class="text-left">GRAND TOTAL ( ' + Math.ceil(total_pages) + ' PAGE / ' + records + ' RECORDS ) : </th>'+
            			'<th>' + number_format(request_load) + '</th>'+
            			'<th></th>'+
            			'<th></th>'+
            			'<th></th>'+
            			'<th></th>'+
            			'<th></th>'+
            			'<th>' + number_format(approved_load) + '</th>'+
            			'<th></th>'+
            			'<th></th>'+
            			'<th></th>'+
            			'<th>' + number_format(drawdown_load) + '</th>'+
            			'<th></th>'+
            			'<th></th>'+
            			'<th></th>'+		
                 	'</tr>' 
                );
	           	             
	            var pages_tfoot = $('#whiteboard_paginate > span > .current').text();
        		$('#whiteboard_footer_total').text('( PAGE ' + pages_tfoot + ' / ' + row_records + ' RECORDS )');
				
	        },
	        complete:function() {
	            
	        		            
	        },
	        cache: true,
	        timeout: 25000,
	        statusCode: {
	            404: function() {
	                alert( "page not found" );
	            }
	        }
	    });

	}

	function reloadStatus() {
	   	$('#table_status_select').html('<select id="status" name="status[]" multiple="multiple" style="width: 130px; padding: 2px 0;">' +
			'<optgroup label="CA Decision Status">' + 
		    	'<option value="PENDING">P - Pending</option>' +
	        	'<option value="APPROVED">A - Approved</option>' +
	       		'<option value="REJECT">R - Reject</option>' +
	        '</optgroup>' +    
	        '<optgroup label="C - Cancel">' +
		    	'<option value="CANCEL_BP" style="margin-left: 15px;">Cancel Before Process</option>' +
		    	'<option value="CANCEL_AP" style="margin-left: 15px;">Cancel After Process</option>' +
	        '</optgroup>' +                    
	    	'</select>');
		   	
	   	$('#selectItemstatus > span').text('');
	    $('#status').change(function() {}).multipleSelect({ width: '50%', height: '30px' });
	}

	function reloadProducts() {
		
		var product = $("#products");
		product.empty()
	    $.ajax({
	        url: pathFixed+'dataloads/productionType?_=' + new Date().getTime(),
	        type: "GET",
	        success:function(data) {
	            
	            for(var indexed in data['data']) {
	                product.append('<optgroup label="' + data['data'][indexed]['ProductTypeName'] + '" data-core="prd_' + data['data'][indexed]['ProductTypeID'] + '"></optgroup>');
	            }


	        },
	        complete:function() {
	            
	        	$.ajax({
	                url: pathFixed+'dataloads/productlist?_=' + new Date().getTime(),
	                type: "GET",
	                success:function(data) {

	                    for(var indexed in data['data']) {
	                        $("#products").find('optgroup[data-core="prd_' + data['data'][indexed]['ProductTypeID'] + '"]').append("<option value='"+data['data'][indexed]['ProductCode']+"' data-toggle='tooltip' data-placement='right' title='"+data['data'][indexed]['ProductName']+"'>" + data['data'][indexed]['ProductTypes']+ '-' + data['data'][indexed]['ProductSub'] + ' ' + data['data'][indexed]['ProductName']+"</option>");
	                                  	
	                    }                    

	                },
	                complete:function() {
	                	$('#products').change(function() {  }).multipleSelect({ width: '100%', minimumCountSelected: 1, filter: true });
	                	$('.ms-drop ul li').find('input[name^="selectItemproducts"]').css('margin-left', '20px');
	                },
	                cache: true,
	                timeout: 5000,
	                statusCode: {
	                    404: function() {
	                        alert( "page not found" );
	                    }
	                }
	            });
	          
	            
	        },
	        cache: true,
	        timeout: 5000,
	        statusCode: {
	            404: function() {
	                alert( "page not found" );
	            }
	        }
	    });
			

	}

   $(function() {
	   
       $('#branchs').change(function() { }).multipleSelect({ width: '100%', filter: true });
       $('#rmname').change(function() { }).multipleSelect({ width: '100%', filter: true });
       $('#status').change(function() { }).multipleSelect({ width: '50%', height: '30px' });
       $('#refer_check').change(function() { }).multipleSelect({ width: '50%', height: '30px' });
       $('#loantype').change(function() { }).multipleSelect({ width: '50%', height: '30px' });
       $('#mslist_loantype ul > li:nth-child(2) label ').css('font-weight', 'bold');
       $('#mslist_loantype ul > li:nth-child(4) label ').css('margin-left', '15px');
       $('#mslist_loantype ul > li:nth-child(5) label ').css('margin-left', '15px');

   });

   $('#refresh_pages').on('mouseover', function() { $('#refresh_pages i').addClass('fa-spin'); });
   $('#refresh_pages').on('mouseout', function() { $('#refresh_pages i').removeClass('fa-spin'); });
   $('#refresh_pages').click(function() { table.fnFilter($(this).val()); });

   $('#drawdown_cm').click(function() {
		var is_checked = $('#drawdown_cm').is(':checked');
		if(is_checked) {
			$('#inlineCheckbox3').prop('checked', true);
			
		} else {
			
			var cnchecked = $('#filter_cncancel').is(':checked');
			if(cnchecked) { } 
			else { $('#inlineCheckbox1').prop('checked', true); }
			
		}
   });

   $('#filter_cncancel').click(function() {
		var is_checked = $('#filter_cncancel').is(':checked');
		if(is_checked) {
			$('#inlineCheckbox1').prop('checked', true);
			
		} else {
			
			var dd_checked = $('#drawdown_cm').is(':checked');
			if(dd_checked) { } 
			else { $('#inlineCheckbox1').prop('checked', true); }
			
		}
  });

   function cloneToTop(element, toElement) {
		$('#'+element).clone().appendTo($('#'+toElement)); 
		e.preventDefault();
   }


   function number_format (number, decimals, dec_point, thousands_sep) {
	    var n = number, prec = decimals;

	    var toFixedFix = function (n,prec) {
	        var k = Math.pow(10,prec);
	        return (Math.round(n*k)/k).toString();
	    };

	    n = !isFinite(+n) ? 0 : +n;
	    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
	    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
	    var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

	    var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); 
	    //fix for IE parseFloat(0.55).toFixed(0) = 0;

	    var abs = toFixedFix(Math.abs(n), prec);
	    var _, i;

	    if (abs >= 1000) {
	        _ = abs.split(/\D/);
	        i = _[0].length % 3 || 3;

	        _[0] = s.slice(0,i + (n < 0)) +
	               _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
	        s = _.join(dec);
	    } else {
	        s = s.replace('.', dec);
	    }

	    var decPos = s.indexOf(dec);
	    if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
	        s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
	    }
	    else if (prec >= 1 && decPos === -1) {
	        s += dec+new Array(prec).join(0)+'0';
	    }
	    return s; 
	}
   
	function fnLoadBranchList() {

		var authority	= $('#AuthCode').val();
		var emp_id		= $('#Emp_ID').val();
		var region_id	= $('#Region_ID').val();
		var branchcode	= $('#BranchCode').val();

		$.ajax({
				url: pathFixed+'dataloads/appProgressBranch?_=' + new Date().getTime(),
				type: "POST",
				data: { 
					auth: authority,
					xemp: emp_id,
					xreg: region_id, 
					xbrn: branchcode
					
				},
				success:function(responsed) {
					
					$('#parent_select_group').html('');
					$('#parent_select_group').html('<div id="select_group" class="form-group"><label class="label label-clear">BRANCH</label><select id="branchs" name="branchs" multiple="multiple" style="width: 130px;"></select></div>');
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

	function setProductList() {

		$('#loantype').change(function() {
		
			if($('#loantype').val() == null) {
				reloadProducts();
				
			} else {

				$.ajax({
					url: pathFixed + 'dataloads/filterProductProgramList?_=' + new Date().getTime(),
					type: "POST",
					data: { productType: $('#loantype').val() },
					success:function(data) {

						$("#products").empty();
						$("#products").append('<optgroup label="Secure Loan" data-core="Secure Loan"></optgroup>');
						$("#products").append('<optgroup label="Clean Loan" data-core="Clean Loan"></optgroup>');			
						for(var indexed in data['data']) {
		                 	$("#products").find('optgroup[data-core="' + data['data'][indexed]['ProductType'] + '"]').append("<option value='"+data['data'][indexed]['ProductCode']+"' data-toggle='tooltip' data-placement='right' title='"+data['data'][indexed]['ProductName']+"'>" + data['data'][indexed]['ProductTypes']+ '-' + data['data'][indexed]['ProductSub'] + ' ' + data['data'][indexed]['ProductName']+"</option>");		                                  	
		                }                    

						$('#products').change(function() {  }).multipleSelect({ width: '100%', minimumCountSelected: 1, filter: true });
		                $('.ms-drop ul li').find('input[name^="selectItemproducts"]').css('margin-left', '20px');
						
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

	}

});

$('#ncbcheck_date,' +
  '#loantype,' +
  '#cashy_field1,' +
  '#cashy_field2,' +
  '#products,' +
  '#col6_filter_start,' +
  '#col6_filter_end,' +
  '#app2ca_date,' +
  '#caname,' +
  '#status,' +
  '#statusreason,' +
  '#status_date,' +
  '#col11_filter_start,' +
  '#col11_filter_end,' +
  '#plandrawdown_date,' +
  '#actualdrawdown_date,' +
  '#col14_filter_start,' +
  '#col14_filter_end,' +
  '#col14_filter_start,' +
  '#col14_filter_end').change(function() { $('input[name="inlineCheckbox"][value="All"]').prop('checked', true); });

function modalPropEnabled(appno, ownership) {

	var service_ip	= 'http://172.17.9.94/newservices/LBServices.svc/';
	$.ajax({
      	url: service_ip + 'pcis/document/' + appno,
        type: "GET",
        beforeSend:function() {
			$('#pdf_thumbnail').empty();
			$('#modalPersonInfo').modal({
	   			show: true,
	   			keyboard: false,
	   			backdrop: 'static'		                        		
	   		});
        },
	    success: function (data) {	
	   	
	   		if(data['Status'] == "Success") {
		   		
	   			var i = 1;
				for(var index in data['Documents']) {
				
					 $('#pdf_thumbnail').append(			    	    	
	           			'<div class="file_container animated fadeInLeft" style="margin-top: 3%; margin-left: 2% !important;">' +
	           				'<span style="position: absolute; margin-top: -30px; left: 0; color: #FFF;">' + data['Documents'][index]['FileName'] + '</span>' +
	           				//'<span onclick="fnFileDelete(\'' + service_ip + '\', \'' + appno + '\', \'' +  data['Documents'][index]['FileName'] + '\');" style="position: absolute; margin-top: -30px; right: 0; color: #FFF;">x</span>' +
	           				'<a id="pdf_link_' + i + '" href="' + data['Documents'][index]['FilePath'] + '" target="_blank">' +			
		           				'<div id="pdf_progress_' + i + '" class="progress-bar small"></div>' +  
		           				'<div class="file_wrapper">' +
									'<div id="pdf_' + i + '" class="thumbnail_file animated fadeInLeft"></div>' +
									'<span class="file_msg">View</span>' +
								'</div>' +
							'</a>' +
						'</div>'					
					);

					var pdf_viewer   = $("#pdf_" + i);	
					var pb = $('div[id^="pdf_progress"]').progressbar();
					pb.delay(800).after(function() {
						pb.progressbar('value', 10);
						pb.progressbar('value', 40);
						pb.progressbar('value', 75);
						pb.progressbar('value', 90);
					});				
					
					var prop = {
						element: pdf_viewer,
					    source: data['Documents'][index]['FilePath'],
					    scale: 0,
					    pageNum: 1,
				 	    maxHeight: 178,
					    maxWidth: 500,
					    onProgress: function (progress) {						   
					    	$('div[id^="pdf_progress_"]').delay(100).fadeOut('slow');		       
					    }
					};
				
					CreateViewer(pdf_viewer, prop);
					
					i++;

				}    	

				var addNum = $('.file_container').length;
				if($('.file_container').length <= addNum) {

					var style = '';
		    		for(var x = $('.file_container').length; x <= addNum; x++) {

						if(x === addNum)  {
							style = 'visibility: hidden;';
							$('#pdf_thumbnail').append('<div class="file_container animated zoomIn" style="max-height: 20px; margin-left: 2% !important; ' + style + '"></div>');
							
						} else {
							$('#pdf_thumbnail').append(			    	    	
		    					'<div class="file_container animated fadeInLeft" style="margin-top: 3%; margin-left: 2% !important; ' + style + '">' +
		    					    '<span style="position: absolute; margin-top: -30px; left: 0; color: #FFF;"></span>' +
		    					    //'<span style="position: absolute; margin-top: -30px; right: 0; color: #FFF;"></span>' +
		    					    '<a id="pdf_link_' + x + '" href="#">' +			
		    					    	'<div id="pdf_progress_' + x + '" class="progress-bar small"></div>' +  
		    					    	'<div class="file_wrapper">' +
		    					    		'<div id="pdf_' + x + '" class="thumbnail_file animated fadeInLeft"></div>' +
		    					    		'<span class="file_msg">View</span>' +
		    					    	'</div>' +
		    					    '</a>' +
		    					'</div>'					
		    				);
						}

		    		}

		    	}
	   		} else {
	   			$('div#modalPersonInfo  > div.modal-dialog > div.modal-content > div.modal-body').css('max-height', '75px');	 
	   			$('#pdf_thumbnail').append('<div class="animated zoomIn text-center fg-white" style="padding: 10px;">File not found</div>');
	   						
	   		}

	    },
	    complete:function() {

	    	$("#pdf_thumbnail").mCustomScrollbar({
				axis:"x",
				theme: 'light-thin',
				advanced:{
					autoExpandHorizontalScroll:true
				}
			
			});

	    	console.log(ownership);
			if(ownership == 'Y') {
				
				var link_path = window.location.protocol + "//" + window.location.host + '/pcis/template/ตัวอย่างการขออนุโลมการรับรองกรรมสิทธิ์สิ่งปลูกสร้าง.pdf';
				var link_opts = window.location.protocol + "//" + window.location.host + '/';
				
				$('#document_support').delay(2000).after(function() {
					$(this).removeAttr('disabled')
					.attr('onclick', 'genLinkDefaultPDF(\'' + link_path + '\')')
					.attr('data-tooltip', 'ตัวอย่างรูปแบบเอกสารกรรมสิทธิ์สิ่งปลูกสร้าง')
					.addClass('tooltip-bottom');

				});
				
			} else {
				$('#document_support').attr('disabled', 'disabled').removeAttr('onclick').removeAttr('data-tooltip').removeClass('tooltip-bottom');
			}
		
	    },
	    cache: false,   
	    error: function (error) {
	 	    console.log(error);   
	    }	        
	});
	
}

function genLinkDefaultPDF(url) { window.open(url,'_blank'); }
function fnFileDelete(api, appno, filename) {
	console.log([api, appno, filename]);

	/*
	$.ajax({
      	url: service_ip + 'pcis/document/' + appno,
        type: "DELETE",
        beforeSend:function() {
			$('#pdf_thumbnail').empty();
			$('#modalPersonInfo').modal({
	   			show: true,
	   			keyboard: false,
	   			backdrop: 'static'		                        		
	   		});
        },
	    success: function (data) {	

	    },	   
	    complete:function() {		    	
	    	
	    },
	    cache: false,
	    error: function (error) {
	 	    console.log(error);   
	    }	        
	});
	*/    
}

// Start PDF Thumbnails
function PaginationStatus(currentPage, totalPages) {
    var _currentPage = parseInt(currentPage, 10), _totalPages = parseInt(totalPages, 10);
    this.currentPage = function () {
        return _currentPage;
    };
    this.nextPage = function () {
        if (_currentPage >= _totalPages) {
            return;
        }
        _currentPage += 1;
    };
    this.previousPage = function () {
        if (_currentPage === 1) {
            return;
        }
        _currentPage -= 1;
    };
    return this;
}

function RenderViewport(height, width, scale, rotation) {
    var _height = height, _width = width, _scale = scale || 1, _rotation = rotation || 0;
    this.adjustCanvasDimensions = function (height, width, canvas) {
        var ratio = width / height;
        if (height > _height) {
            height = _height;
            width = height * ratio;
        }
        if (width > _width) {
            width = _width;
            height = width / ratio;
        }
        canvas.height = height;
        canvas.width = width;

    };
    this.rotateClockwise = function () {
        _rotation += 90;
    };
    this.rotateCounterClockwise = function () {
        _rotation -= 90;
    };
    this.getRotation = function () {
        return _rotation - 90;
    };

    console.log(this);
    return this;
}

function PdfRenderer(prop, canvas) {
    var pdfDoc = null, renderPage = function (pagination) {
        pdfDoc.getPage(pagination.currentPage()).then(function (page) {
            var viewport = page.getViewport(parseInt(prop.scale, 10) || 1, 0), renderContext = {}, targetViewport = new RenderViewport(prop.maxHeight || viewport.height, prop.maxWidth || viewport.width);
            targetViewport.adjustCanvasDimensions(viewport.height, viewport.width, canvas);
            page.render({
                canvasContext: canvas.getContext("2d"),
                viewport: page.getViewport(canvas.height / viewport.height, targetViewport.getRotation())
            });
        });
    };
    this.render = function () {
        if (!prop.source) {
            return;
        }
        PDFJS.disableWorker = true;
        PDFJS.getDocument(prop.source, null, null, prop.onProgress).then(function (_pdfDoc) {
            pdfDoc = _pdfDoc;
            renderPage(new PaginationStatus(prop.pageNum || 1, pdfDoc.numPages));
        }, function (error) {
            console.log(error);
        });
    };
    return this;
}

function CreateViewer(container, prop) {
    var canvas = document.createElement("canvas"), renderer = null, renderFunc = function () {
        if (renderer) {
            renderer.render();
        }
    };
    container.empty().append(canvas);
    renderer = new PdfRenderer(prop, canvas);
    renderFunc();
}
// End PDF Thumbnails

function reload(rowid, result) {	
	grid.trigger("reloadGrid"); 
}

function popover_areahistory(element, text_area) {
	var html = $(text_area).html()
	$(element).webuiPopover({
		trigger:'hover',	
		padding: true,
		content: html,
		backdrop: false
	});
}

function removeTags(str){
    var rex = /(<([^>]+)>)/ig;
    return str.replace(rex , "");
}

function print_area(scriptHeader, sciptOption, tag_content) {
		
	Date.prototype.toMSJSON = function () {
	    var date = '/Date(' + this.getTime() + ')/'; //CHANGED LINE
	    return date;
	};

	var emp_code	  = $('#Emp_ID').val();
	var region_list   = ($('#regions_hidden').val() !== "") ? $('#regions_hidden').val():null;
	var branch_list   = ($('#branchs_hidden').val() !== ""  && $('#branchs_hidden').val().length > 0) ? $('#branchs_hidden').val():null;
	var rmcode_list   = ($('#rmname_hidden').val() !== ""  && $('#rmname_hidden').val().length > 0) ? $('#rmname_hidden').val():null;
	var borrowername  = ($('#customer_hidden').val() !== "" ) ? $('#customer_hidden').val():null;
	var loan_list	  = ($('#loantype_hidden').val() !== ""  && $('#loantype_hidden').val().length > 0) ? $('#loantype_hidden').val():null;
	var product_list  = ($('#products_hidden').val() !== ""  && $('#products_hidden').val().length > 0) ? $('#products_hidden').val():null;
	var caname_list   = ($('#caname_hidden').val() !== "" ) ? $('#caname_hidden').val():null;
	var status_list	  = ($('#status_hidden').val() !== "" ) ? $('#status_hidden').val():null;
	var status_reason = ($('#status_hidden_reason').val() !== "" ) ? $('#status_hidden_reason').val():null;
	var active_list   = ($('input[name="inlineCheckbox"]:checked').val() !== "" ) ? $('input[name="inlineCheckbox"]:checked').val():null;

	var start_date    = ($('#ncb_start_hidden').val() !== "" ) ? converDate($('#ncb_start_hidden').val()):null;
	var end_date	  = ($('#ncb_end_hidden').val() !== "" ) ? converDate($('#ncb_end_hidden').val()):null;
	var plana2casdate = ($('#appplanstart_date_hidde').val() !== "" ) ? converDate($('#appplanstart_date_hidde').val()):null;
	var plana2caedate = ($('#appplanend_date_hidde').val() !== "" ) ? converDate($('#appplanend_date_hidde').val()):null;         
	var a2ca_sdate	  = ($('#apptoca_start_hidden').val() !== "" ) ? converDate($('#apptoca_start_hidden').val()):null;
	var a2ca_edate	  = ($('#apptoca_end_hidden').val() !== "" ) ? converDate($('#apptoca_end_hidden').val()):null;
	var decisionsdate = ($('#statusdate_start_hidden').val() !== "" ) ? converDate($('#statusdate_start_hidden').val()):null;
	var decisionedate = ($('#statusdate_end_hidden').val() !== "" ) ? converDate($('#statusdate_end_hidden').val()):null;
	var plandd_sdate  = ($('#drawdown_startplan_hidden').val() !== "" ) ? $converDate(('#drawdown_startplan_hidden').val()):null;
	var plandd_edate  = ($('#drawdown_endplan_hidden').val() !== "" ) ? converDate($('#drawdown_endplan_hidden').val()):null;
	var drawdownsdate = ($('#drawdown_startactual_hidden').val() !== "" ) ? converDate($('#drawdown_startactual_hidden').val()):null;
	var drawdownedate = ($('#drawdown_endactual_hidden').val() !== "" ) ? converDate($('#drawdown_endactual_hidden').val()):null;

	var request_sloan = ($('#request_start_hidden').val() !== "" ) ? $('#request_start_hidden').val():null
	var request_eloan = ($('#request_end_hidden').val() !== "" ) ? $('#request_end_hidden').val():null;
	var approvedsloan = ($('#approved_start_hidden').val() !== "" ) ? $('#approved_start_hidden').val():null;
	var approvedeloan = ($('#approved_end_hidden').val() !== "" ) ? $('#approved_end_hidden').val():null;
	var drawdwonsloan = ($('#drawdown_start_hidden').val() !== "" ) ? $('#drawdown_start_hidden').val():null
	var drawdwoneloan = ($('#drawdown_end_hidden').val() !== "" ) ? $('#drawdown_end_hidden').val():null
	var refer_flag	  = ($('#refer_check_hidden').val() !== "" ) ? $('#refer_check_hidden').val():null;

	var drawdown_cm	  = (!empty($('input[name="drawdown_cm"]:checked').val())) ? 'Y':null;
    var filter_cnflag = ($('input[name="filter_cncancel"]:checked').val() == 'CN003') ? 'Y':null;
    var cashy_field	  = $('input[name="cashy_field"]:checked').val();

	var product_loan  = [];
	var refinances	  = [];
	if(!empty(loan_list)) {
		var str_split = loan_list.split(",");
		$.each(str_split, function(index, value) {
			if(in_array(value, ['Refinance', 'Non Refinance'])) {
				if(!refinances[0]) product_loan.push('Secure');
				if(value == 'Refinance') refinances.push(1);
				else refinances.push(2);
			} else { 
				product_loan.push('Clean'); 
			}
			
		});
	}

	var retreieve  = [];
	var refercase  = [];
	var defendflag = '';
	var ca_return  = '';
	if(!empty(refer_flag)) {
		var str_split = refer_flag.split(",");
		$.each(str_split, function(index, value) {
			if(in_array(value, ['Refer: Thai Life', 'Refer: Full Branch', 'Refer: Call Center', 'Tcrb: Facebook', 'Refer: RM', 'Refer: Customer'])) {
				refercase.push(value);
			} else {

				if(in_array(value, ['Defend', 'CR'])) {
					if(value == 'Defend') defendflag = 'Y';
					else ca_return = 'Y'
					
				} else if(in_array(value, ['Retrieved', 'ReActivate'])) {
					if(value == 'Retrieved') retreieve.push('RET');
					else retreieve.push('REA');
				} 
				
			}
			
		});
	}

	var decision = [];
	if(!empty(status_list)) {
		var str_split = status_list.split(",");
		$.each(str_split, function(index, value) {
			if(in_array(value, ['CANCEL_BP', 'CANCEL_AP'])) {
				if(!in_array(value, [decision])) {
					if(value == 'CANCEL_BP') {
						decision.push('CANCELBYRM');
						decision.push('CANCELBYCUS');
					} else {
						decision.push('CANCELBYCA');
						decision.push('CANCEL');
					}
				}				
			} else {
				decision.push(value);				
			}
			
		});
	} 

	var str_productloan  = (!empty(product_loan[0])) ? product_loan.join():null;
	var str_refinances   = (!empty(refinances[0])) ? refinances.join():null;
	var str_retreieve	 = (!empty(retreieve[0])) ? retreieve.join():null;
	var str_refercase	 = (!empty(refercase[0])) ? refercase.join():null;
	var str_decision	 = (!empty(decision[0])) ? decision.join():null;
	var str_defendflag	 = (defendflag == 'Y') ? 'Y':null;
	var str_ca_return	 = (ca_return == 'Y') ? 'Y':null;
	
	var param = {
        	AuthCode		: emp_code,
        	RegionCode		: isEmpty(region_list), 
        	BranchCode		: isEmpty(branch_list), 
        	RMCode			: isEmpty(rmcode_list), 
        	BorrowerName	: isEmpty(borrowername), 
        	LoanType		: isEmpty(str_productloan), 
        	Refinance		: isEmpty(str_refinances),
        	ProductProgram	: isEmpty(product_list), 
        	CAName			: isEmpty(caname_list), 
        	Status			: isEmpty(str_decision), 
        	StatusReason	: isEmpty(status_reason), 
        	StartDate		: isEmpty(start_date),
        	EndDate			: isEmpty(end_date), 
        	A2CA_StartDate	: isEmpty(a2ca_sdate), 
        	A2CA_EndDate 	: isEmpty(a2ca_edate),
        	Decision_StartDate : isEmpty(decisionsdate),
        	Decision_EndDate   : isEmpty(decisionedate),
        	DDPlan_StartDate   : isEmpty(plandd_sdate),
        	DDPlan_EndDate 	   : isEmpty(plandd_edate),
        	Drawdown_StartDate : isEmpty(drawdownsdate),
        	Drawdown_EndDate   : isEmpty(drawdownedate),
        	Request_StartLoan  : isEmpty(request_sloan),
        	Request_EndLoan    : isEmpty(request_eloan),
        	Approved_StartLoan : isEmpty(approvedsloan),
        	Approved_EndLoan   : isEmpty(approvedeloan),
        	Drawdown_StartLoan : isEmpty(drawdwonsloan),
        	Drawdown_EndLoan   : isEmpty(drawdwoneloan),
        	Referal_Flag 	   : isEmpty(str_refercase),
        	Drawdown_Flag	   : isEmpty(drawdown_cm),
        	CN_Flag	   		   : isEmpty(filter_cnflag),
        	Defend_Flag		   : isEmpty(str_defendflag),
        	CeditReturn_Flag   : isEmpty(str_ca_return),
        	RET_Flag		   : isEmpty(str_retreieve),
        	REA_Flag		   : 'PRINT',
        	Cashy_Flag		   : isEmpty(cashy_field),
        	ActiveRecord	   : (active_list !== 'All') ? isEmpty(active_list):null,
    };
	 
	$.ajax({
        url: 'http://172.17.9.94/newservices/LBServices.svc/pcis/whiteboard',
        type: "POST",
        dataType: "json",
        contentType: 'application/json',
        data: JSON.stringify(param),
        beforeSend: function() {
			//var printHeader  = document.getElementById(scriptHeader).innerHTML;
        	//var printOption  = document.getElementById(sciptOption).innerHTML;
        	//var printContent = document.getElementById(tag_content).innerHTML;        	
        	//var printCSSOpt  = document.getElementById('optional_css').innerHTML
        },
        success:function(data) {	

            if(data && data.length > 0) {

            	var path_root	 = window.location.protocol + "//" + window.location.host + '/pcis/';
            	var boostrap_css = '<link rel="stylesheet" href="' + path_root + 'css/responsive/bootstrap.min.css">' +
            					   '<link rel="stylesheet" href="' + path_root + 'css/jquery-ui/jquery-ui.min.css">';
		            	
				var style_detail = '<link rel="stylesheet" href="' + path_root + 'css/custom/element-color-theme.css">' + 
								   '<link rel="stylesheet" href="' + path_root + 'css/metro/iconFont.css">' +
								   '<link rel="stylesheet" href="' + path_root + 'css/themify-icons.css">' +
							 	   '<link rel="stylesheet" href="' + path_root + 'css/flaticon/flaticon.css">' +
							       '<link rel="stylesheet" href="' + path_root + 'css/awesome/css/font-awesome.min.css">' + 
								   '<link rel="stylesheet" href="' + path_root + 'css/custom/whiteboard_printcss.css?v=006">';

            	var popupWin 	 = window.open('', '_blank', 'position: absolute, width=auto,height=auto,left=0,top=0');
                
				var table 	 = '';
				var thead	 = '';
				var tbody	 = '';
				var tfoot	 = '';
				var content  = '';
			
				thead = '<tr class="tableHeader">' +
						    '<th colspan="2">DATE</th>' +
						    '<th colspan="4">NAME</th>' +
						    '<th colspan="3">LOAN REQUEST</th>' +
						    '<th colspan="2">APP TO CA</th>' +
						    '<th colspan="4">STATUS ( P / A / R / C ) & CR</th>' +
						    '<th colspan="4">DRAWDOWN DATE</th>' +
						    '<th rowspan="2">ACTION NOTE</th>' +
						'</tr>' +
						'<tr class="tableHeader">' +
						    '<th>START</th>' +
						    '<th><i class="fa fa-flag-o print_hold"></i></th>' +
						    '<th>CUSTOMER</th>' +
						    '<th>RM</th>' +
						    '<th>CASHY</th>' +
						    '<th>LB</th>' +
						    '<th>PG</th>' +
						    '<th>AMT</th>' +
						    '<th><i class="fa fa-flag-o print_hold"></i></th>' +
						    '<th>DATE</th>' +
						    '<th>NAME</th>' +
						    '<th>ST</th>' +
						    '<th>DATE</th>' +
						    '<th>AMT</th>' +
						    '<th><i class="fa fa-flag-o print_hold"></i></th>' +
						    '<th>PLAN</th>' +
						    '<th>ACTUAL</th>' +
						    '<th>AMT</th>' +
						    '<th class="fixed"><i class="fa fa-flag-o print_hold"></i></th>' +     
						'</tr>';
				
				if(data.length > 0) {

					if(!empty(status_list)) { var result_set = sortByKey(data, '_StatusDate'); } 
					else { var result_set = sortByKey(data, '_StartDate'); }
			
					var toal_request_loan 	= 0;
					var total_approved_loan = 0;
					var total_drawdown_loan = 0;
					
					$.each(result_set, function(index, value) {

						var plana2ca_count	  = (value.PlanPostponeCount) ? value.PlanPostponeCount:'';
						var ca_status	  	  = (value.Status) ? value.Status:'';

						var plana2ca_date 	  = (value.PlanDocToCACondition) ? moment(value.PlanDocToCACondition).format('YYYY-MM-DD'):'';
						var a2ca_date	  	  = (value.CA_ReceivedDocDate) ? moment(value.CA_ReceivedDocDate).format('YYYY-MM-DD'):'';
						var status_date	  	  = (value.StatusDate) ? moment(value.StatusDate).format('YYYY-MM-DD'):'';
						var drawdown_date 	  = (value.DrawdownDate) ? moment(value.DrawdownDate).format('YYYY-MM-DD'):'';

						var request_loan  	  = (value.RequestLoan) ? parseInt(value.RequestLoan):'';
						var approved_loan 	  = (value.ApprovedLoan) ? parseInt(value.ApprovedLoan): ((value.PreLoan) ? parseInt(value.PreLoan):'');
						var drawdown_loan 	  = (value.DrawdownBaht) ? parseInt(value.DrawdownBaht):'';
						
						var request_numformat  = (value.RequestLoan) ? $.number(value.RequestLoan, 0):'';
						var approve_numformat  = (value.ApprovedLoan) ? $.number(value.ApprovedLoan, 0): ((value.PreLoan) ? $.number(value.PreLoan, 0):'');
						var drawdown_numformat = (ca_status == 'A' && value.DrawdownBaht) ? $.number(value.DrawdownBaht, 0):'';

						var rm_onhand_sla 	  = (value.RMOnhandCount) ? value.RMOnhandCount:0;
						var decision_sla  	  = (value.CAOnhandCount) ? value.CAOnhandCount:0;
						var drawdown_sla  	  = (value.CADecisionCount) ? value.CADecisionCount:0;
						var total_sla	  	  = 0;

						total_sla		  	  = (checkNum(rm_onhand_sla) + checkNum(decision_sla) + checkNum(drawdown_sla) );

						toal_request_loan 	  += parseInt(checkNum(request_loan));
						total_approved_loan	  += parseInt(checkNum(approved_loan));
						total_drawdown_loan	  += parseInt(checkNum(drawdown_loan));
						
						tbody += 
						'<tr>' +
						    '<td class="text-center">' + moment(value.StartDate).format('DD/MM/YYYY') + '</td>' +
						    '<td class="text-center">' + fontLightState(total_sla) + '</td>' +
						    '<td class="text-left">' + divisionLayar(value.BorrowerName, value, 'borrower') + '</td>' +
						    '<td class="text-left">' + divisionLayar(value.RMName, value, 'BMRefer') + '</td>' +
						    '<td class="text-center">' + divisionLayar(value.Cashy, value, 'cashy') + '</td>' +
						    '<td class="text-center">' + divisionLayar(value.BranchDigit, value, 'branch') + '</td>' +
						    '<td class="text-center">' + divisionLayar(reforge_product(value.ProductCode), value, 'product') + '</td>' +
						    '<td class="text-right">' + request_numformat + '</td>' +						   
							'<td class="text-center">' + fontLightState(value.RMOnhandCount) + '</td>' +
						    '<td class="text-center">' + divisionLayar('', value, 'a2ca') + '</td>' +
						    '<td class="text-left">' + divisionLayar(value.CAName, value, 'defend') + '</td>' +
						    '<td class="text-center">' + divisionLayar(value.Status, value, 'status') + '</td>' +
						    '<td class="text-center">' + ((value.StatusDate) ? moment(value.StatusDate).format('DD/MM/YYYY'):'') + '</td>' +
						    '<td class="text-right">' + approve_numformat + '</td>' +
							'<td class="text-center">' + fontLightState(value.CAOnhandCount) + '</td>' +
						    '<td class="text-center">' + ((ca_status == 'A' && value.PlanDrawdownDate) ? moment(value.PlanDrawdownDate).format('DD/MM/YYYY'):'') + '</td>' +
						    '<td class="text-center">' + ((ca_status == 'A' && value.DrawdownDate) ? moment(value.DrawdownDate).format('DD/MM/YYYY'):'') + '</td>' +
						    '<td class="text-right">' + drawdown_numformat + '</td>' +						    
						    '<td class="text-center">' + ((ca_status == 'A') ? fontLightState(value.CADecisionCount):'') + '</td>' +
							'<td class="text-left">' + ((value.ActionNote) ? value.ActionNote:'') + '</td>' +     
						'</tr>';				
					});
					
				} else { tbody = '<tr><td colspan="20" class="text-center">ไม่พบข้อมูล</td></tr>'; }

				var total_request_numformat  = (toal_request_loan) ? $.number(toal_request_loan, 0):'';
				var total_approve_numformat  = (total_approved_loan) ? $.number(total_approved_loan, 0):'';
				var total_drawdown_numformat = (total_drawdown_loan) ? $.number(total_drawdown_loan, 0):'';

				tfoot = '<tr>' +
							'<td colspan="7" class="text_bold">TOTAL</td>' +
							'<td class="text_bold">' + total_request_numformat + '</td>' + 
							'<td colspan="5"></td>' +
							'<td class="text_bold">' + total_approve_numformat + '</td>' +
							'<td colspan="3"></td>' +
							'<td class="text_bold">' + total_drawdown_numformat + '</td>' +
							'<td colspan="2"></td>' +
						'</tr>';
				
				table = '<table id="whiteboard" class="table table-bordered">' + 
							'<thead>' + thead + '</thead>' +
							'<tbody>' + tbody + '</tbody>' +
							'<tfoot>' + tfoot + '<tfoot>' +
						'</table>';

				popupWin.document.open();
				popupWin.document.write('<html>' + boostrap_css + style_detail + '<body onload="window.print()">' +  table + '</body></html>');
				//popupWin.document.close();

				//console.log(data);
				
            }   
                 
			
        	
        },
        complete:function() {
            
        		            
        },
        cache: true,
        timeout: 50000,
        statusCode: { 404: function() {console.log( "page not found" );} }
    });

	function reforge_product(productcode) {
		if(productcode) {
			var str_split = productcode.substring(0, 3);
			var str_code  = productcode.substring(0, 2);
			var str_digit = productcode.substr(productcode.length - 2);
			if(in_array(str_split, ['NCA','NCB','NCC','NOA','NPS'])) {
				var str_code = '';
				switch(str_split) {
					case 'NCA': str_code = 'CA'; break;
					case 'NCB': str_code = 'CB'; break;
					case 'NCC': str_code = 'CC'; break;
					case 'NOA': str_code = 'OA'; break;
					case 'NPS': str_code = 'PS'; break;
					default: str_code = 'CA'; break;
				}
				
				return str_code + '-' + str_digit;
				
			} else { return str_code + '-' + str_digit; }
			
		} else { return ''; }
	}

    function dateDiff(base_date, compare_date) {

    	if(base_date && compare_date) {
    		var now = moment(compare_date); 
        	var end = moment(base_date);
        	
        	if(now > end) {                 	   		
            	var duration = moment.duration(now.diff(end));
            	var days = duration.asDays();
            	return (days < 0) ? days * -1 : days;
            	
        	} else { return 0; }
    		        	
    	} else { return 0; }
    	    	
    }

    function isEmpty(objVal) {
		if(objVal && objVal !== "" || objVal !== undefined) return objVal;
		else return null;
    }

    function empty(objVal) {
		if(isEmpty(objVal)) return false;
		else return true;
    }

    function checkNum(objVal) {
    	if(objVal && objVal !== "" && objVal > 0) return parseInt(objVal);
    	else return 0;
    }

    function converDate(date_str) {
		if(isEmpty(date_str)) {
			return new Date(moment(date_str, 'DD/MM/YYYY').format('YYYY-MM-DD')).toMSJSON();
		} else return null;
    }

    function fontLightState($nums) {       
        if($nums !== null && $nums !== undefined) {     	
        	if($nums <= 10) { return '<span class="fg-emerald">' + $nums + '</span>'; }
        	else if($nums >= 11 && $nums <= 20){ return '<span class="fg-amber">' + $nums + '</span>'; }
        	else if($nums >= 21) { return '<span class="fg-red">' + $nums + '</span>'; }
        } else { return ''; }
    	
    }

    function sortByKey(array, key) {
        return array.sort(function(a, b) {
            var x = a[key]; var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }

    function divisionLayar(cellVal, objVal, mode) {
        var division = '';
        var style	 = 'style="border-bottom: 1px solid #D1D1D1;"';
        var classes	 = 'partition';
      
        if(objVal) {

			if(mode != '') {
				
				switch (mode) {		
					case 'borrower':
						//var cashy = (objVal.Cashy) ? objVal.Cashy:'';
						//if(!empty(cashy) && cashy == 'Y') division = '<div class="partition text-center" ' + style + '>Cashy</div><div class="partition">' + cellVal + '</div>'; 
						//else division = cellVal;
						var appno = (objVal.ApplicationNo) ? objVal.ApplicationNo:'';
						division = '<div class="partition text-left" ' + style + '>' + appno + '</div><div class="partition">' + cellVal + '</div>';
						
					break;
					case 'cashy':
						var cashy = (objVal.Cashy) ? objVal.Cashy:'';
						if(cashy == 'Y') division = cellVal;
						else division = '';
					break;
					case 'BMRefer':
						var bm_refer = (objVal.OptionRefer) ? objVal.OptionRefer:'';
						//var str_text = (bm_refer) ? bm_refer.split(" "):'';
						//var str_name = str_text[0] + ' (R/BM)';
						//if(!empty(bm_refer)) division = '<div class="partition text-left" ' + style + '>' + str_name + '</div><div class="partition">' + cellVal + '</div>';
						if(!empty(bm_refer)) division = '<div class="partition text-left" ' + style + '>Refer By BM</div><div class="partition">' + cellVal + '</div>'; 
						else division = cellVal;
					break;
					case 'branch':
						var refer = (objVal.SourceCustDigit) ? objVal.SourceCustDigit:'';
						//var refer_check = (objVal.SourceCustDigit) ? objVal.SourceCustDigit.substring(0, 2):'' // refer_check == 'R/';
						var refer_check = (objVal.SourceCustDigit) ? objVal.SourceCustDigit.substring(0, 4):'';
						if(!empty(refer) && refer_check == 'R/TL') division = '<div class="partition text-center" ' + style + '>' + refer + '</div><div class="partition">' + cellVal + '</div>'; 
						else division = cellVal;
						
					break;
					case 'product':
						var bank = (objVal.Bank) ? objVal.Bank:'';
						if(!empty(bank)) division 	= '<div class="partition text-center" ' + style + '>' + bank + '</div><div class="partition">' + cellVal + '</div>'; 
						else division = cellVal;
						
					break;					
					case 'a2ca':
						var latest_a2cadate = (objVal.LatestAppProgressDate) ? moment(objVal.LatestAppProgressDate).format('DD/MM/YYYY'):'';
						var latestprogress  = (objVal.LatestAppProgress) ? objVal.LatestAppProgress:'';
						var plana2ca_count  = (objVal.PlanPostponeCount && objVal.PlanPostponeCount > 0) ? ' ' + objVal.PlanPostponeCount:'';
					
						var str_text 		= ''; // ['RMOnhand', 'Plan A2CA', 'HOReceived', 'HO2CA', 'A2CA']
						if(in_array(latestprogress, ['Plan'])) { 
							var dfno = (plana2ca_count) ? plana2ca_count:' 1';
							str_text = latestprogress + dfno; 
						} else { 
							if(!in_array(latestprogress, ['RMOnhand'])) { str_text = latestprogress; } 
						}
						
						if(!empty(str_text)) {
							division = '<div class="partition text-center" ' + style + '>' + str_text + '</div><div class="partition">' + latest_a2cadate + '</div>';
						} else {
							division = latest_a2cadate;
						}
									
					break;
					case 'defend':
						var defend = (objVal.IsDefend) ? objVal.IsDefend:'';
						var caname = (objVal.CAName) ? objVal.CAName:'';
						if(!empty(defend) && !empty(caname)) division = '<div class="partition text-center" ' + style + '>DEF-' + defend + '</div><div class="partition">' + caname + '</div>'; 
						else division = caname;
						
					break;
					case 'status':
						var aipAllow 	 = (objVal.IsAIP) ? objVal.IsAIP:'';
						var fileEstimate = (objVal.ReceivedEstimateDoc) ? objVal.ReceivedEstimateDoc:'';
						var ownership	 = (objVal.OwnershipDoc) ? objVal.OwnershipDoc:'';

						if(in_array(cellVal, ['P', 'A'])) {

							if(!empty(ownership) && ownership == 'Y' && cellVal == 'A') {
								division 	 = '<div class="partition text-center" ' + style + '>กสปส</div><div class="partition text-center">' + cellVal + '</div>';
								
							} else {

								if(!empty(fileEstimate) && fileEstimate == 'Y') {
									division = '<div class="partition text-center" ' + style + '>รับเล่ม</div><div class="partition">' + cellVal + '</div>';
								} else if(!empty(aipAllow) && aipAllow == 'Y') {
									division = '<div class="partition text-center" ' + style + '>AIP</div><div class="partition">' + cellVal + '</div>';
								} else {
									division = cellVal;
								}								
									
							}
							
						} else { division = cellVal; }
							
					break;
	        	}
				
				return division;
	        	
			} else { return ''; }
   
        } else { return ''; }
	
    }
      
	//popupWin.document.open();
	//popupWin.document.write('<html>' + printHeader + printCSSOpt + '<body onload="window.print()">' +  printContent + '</body></html>');
	//popupWin.document.close();
	
	/*
	if(help.in_array(primarydata[2][0].EmployeeCode, primarydata[4])) {
		
		if(confirm('การกดยืนการปริ๊นเอกสารจะเป็นการยืนยันสถานะการส่่งใบคำร้องการขอ Defend ถึง CA \nคุณต้องการปริ๊นเอกสารหรือไม่')) {
			
			$.ajax({
		      	url: pathFixed + 'index.php/dataloads/printDefend?_=' + new Date().getTime(),
		        data: {
					doc_id: primarydata[0],
					defendref: primarydata[1],
					userid: primarydata[2][0].EmployeeCode,
					username: primarydata[2][0].FullNameTh
				},
		        type: "POST",
		        cache: false,
			    success: function (responsed) { 
			    	
			    	if(responsed['status']) {
			    		 $scope.grid_restate = true;
			    		 $scope.noitfyconfig.message = 'ระบบดำเนินการเปลี่ยนแปลงสถานะเป็นจัดส่งเอกสารสำเร็จ';
		        		 Notification.success( $scope.noitfyconfig);
		        		 
		        		 $uibModalInstance.dismiss({ status: 'cancel', state: $scope.grid_restate });
                    	
			    	} else {
			    		 $scope.noitfyconfig.message = 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่';
		        		 Notification.error( $scope.noitfyconfig );
	
			    	}
			    	
			    },
			    complete:function() {},
			    error: function (error) { console.log(error); }	        
			});
			
			var printHeaders  = document.getElementById(divHeader).innerHTML;
			var printContents = document.getElementById(divName).innerHTML;
			var popupWin = window.open('', '_blank', 'width=auto,height=auto');
			  
			popupWin.document.open();
			popupWin.document.write('<html>' + printHeaders + '<body onload="window.print()">' +  printContents + '</body></html>');
			popupWin.document.close();
				
			return true;
		
		}
		
		return false;
		
	} else {
		
		var printHeaders  = document.getElementById(divHeader).innerHTML;
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=auto,height=auto');
		  
		popupWin.document.open();
		popupWin.document.write('<html>' + printHeaders + '<body onload="window.print()">' +  printContents + '</body></html>');
		popupWin.document.close();
		
	}
	*/

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
	
} 

</script>
</div>