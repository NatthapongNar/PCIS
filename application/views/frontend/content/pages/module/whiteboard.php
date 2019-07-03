<style>
	.webui-popover { margin-top: -70px; }
	h3.webui-popover-title { font-size: 1.1em; }
	#definded_status div { display: inline; }
	.modal-header.fixed { max-height: 50px; }
	.printonly { display: none; }
	
	.modal-dialog { margin-top: 0px; }	
	
	/** mini profiler **/
	@media projection {
	
	  .using_information {
		    position: absolute;
		    margin-top: -50px;
		    right: 45px !important;
		    padding-top: 0px !important;
		    min-width: 182px;
	   }
		
	   .crop_nav {
			margin-top: 5px;
		}
	}
	
	@media screen {	
	  	.using_information {
		    position: absolute;
		    margin-top: -40px;
		    right: 35px;
		    padding-top: 4px;
		    min-width: 182px;
		}
	}	
	
	div.crop_nav img {
		width: 45px;
	    height: 42px;
	    margin-left: 10px;
	    margin-top: -2px;
	    border-radius: 50% !important;
	}
	
	.crop_nav, .using_desc { 
		display: inline;
		float: left;
		cursor: pointer;
		margin-top: 7px;
	}
	
	.crop_nav { 
		margin-top: 7px;
		padding: 0 3px;
	} 

	.using_desc > span {
		color: #777777;
		font-size: 1em;
		vertical-align: middle;
		font-weight: normal;
		min-width: 182px;
	}
	
	@media print {
		.dataTables_length, .dataTables_paginate  { display: none !important; }
		.printonly { display: block; }
		.nonprint { display: none !important; }
	}
	
</style>
<div class="progress progress_icon animated fadeIn"><img src="<?php echo base_url('img/378_1.gif'); ?>"></div>
<div class="progress blackboard"></div>

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
	<div><i class="fa fa-circle" style="color: #199a11;"></i> อยู่ระหว่างการประเมิน</div>
	<div><i class="fa fa-circle" style="color: #fa6800;"></i> CA รับเล่มประเมินแล้ว</div>
	<div><i class="fa fa-circle" style="color: red;"></i> หนังสือรับรองกรรมสิทธิสิ่งปลูกสร้างไม่สมบูรณ์</div>
</div>

<div id="print_detail" style="display: none;">
	<div><h6>Column-Sorting Avaliable</h6></div>	
	<div><i class="fa fa-circle" style="color: #666; font-size: 0.8em;"></i> Start Date</div>	
	<div><i class="fa fa-circle" style="color: #666; font-size: 0.8em;"></i> Customer Name</div>	
	<div><i class="fa fa-circle" style="color: #666; font-size: 0.8em;"></i> RM Name</div>	
	<div><i class="fa fa-circle" style="color: #666; font-size: 0.8em;"></i> Branch Name</div>	
	<div><i class="fa fa-circle" style="color: #666; font-size: 0.8em;"></i> Product Code</div>	
	<div><i class="fa fa-circle" style="color: #666; font-size: 0.8em;"></i> A2CA Date</div>	
	<div><i class="fa fa-circle" style="color: #666; font-size: 0.8em;"></i> CA Name</div>	
	<div><i class="fa fa-circle" style="color: #666; font-size: 0.8em;"></i> Decision Status</div>	
	<div><i class="fa fa-circle" style="color: #666; font-size: 0.8em;"></i> Status Date</div>	
	<div><i class="fa fa-circle" style="color: #666; font-size: 0.8em;"></i> Plan Drawdown Date</div>	
	<div><i class="fa fa-circle" style="color: #666; font-size: 0.8em;"></i> Drawdown Date</div>	
</div>

<input id="branch_location" type="hidden" value="<?php echo !empty($session_data['branchcode']) ? $session_data['branchcode']:''; ?>">
<input id="is_pilot" type="hidden" value="<?php echo $is_pilot; ?>">

<div ng-controller="ctrlWhiteboard" class="grid" ng-class="{ 'nonprint' : !print_screen }">

	<!-- Sidebar Option Filter -->
	<div id="sidenav_container" class="sidenav close">
		<a href="javascript:void(0)" class="closebtn" ng-click="closesidebar()">&times;</a>
		
		<div class="content close marginTopEasing10 "><h6 class="fg-white"><i class="fa fa-search on-left"></i>OPTIONAL FILTER</h6></div>
		<div class="content close">
			<div class="label header bg-amber fg-white" style="line-height: 1.2;">Column-Target</div>
			<div class="field header bg-amber fg-white text-center" style="line-height: 1.2;">Field Conditional</div>
		</div>
		<div class="content close">
			<div class="label">Start Date</div>
			<div class="field padding_none">
				<div class="input-control text field_limitText margin_none fg-black">
					<input id="startdate_range" name="startdate_range" ng-model="filter.startdate" input-daterange-enable type="text" ng-change="changeFieldAllAuto(filter.startdate, 'startdate')">
				</div>
			</div>
		</div>
		<div class="content close marginTop10">
			<div class="label">Cashy</div>
			<div class="field padding_none">
				<div class="input-control checkbox">
				    <label class="margin_none">
				        <input id="cashy_field1" ng-model="filter.cashy_yesflag" type="checkbox" ng-click="filter.cashy_noflag = false">
				        <span class="check"></span> Yes
				    </label>
				</div>
				<div class="input-control checkbox marginLeft20">
				    <label class="margin_none">
				        <input id="cashy_field2" ng-model="filter.cashy_noflag" type="checkbox" ng-click="filter.cashy_yesflag = false">
				        <span class="check"></span> No
				    </label>
				</div>
			</div>
		</div>
		<div class="content close">
			<div class="label">Product Type</div>
			<div class="field padding_none">
				<select multiple="multiple" multi-select-list
						id="masterproduct_type"
                        name="objMasterProductType"
                        ng-model="filter.producttype"
                        config="multipleConfig"
                        data="masterdata.producttype"
                        ng-options="option.ProductTypeName as option.ProductTypeName group by option.ProductType for option in masterdata.producttype"
                        ng-change="changeFieldAllAuto(filter.producttype, 'product_type')">	        			
        		</select>	
			</div>
		</div>
		<div class="content close">
			<div class="label">Product Program</div>
			<div class="field padding_none">
				<select multiple="multiple" multi-select-list
					    id="masterproducts"
                      	name="objProducts"
                        ng-model="filter.products"
                        config="multipleConfig"
                        data="masterdata.products"
                        ng-options="option.ProductCode as (option.ProductName + ' (' + option.ProductShortCode + ')') group by option.ProductTypeName for option in masterdata.products"
                        ng-change="changeFieldAllAuto(filter.products, 'products')">        			
        		</select>	
			</div>
		</div>
		<div class="content close" style="background-color: #4A4C4E !important;">
			<div class="label">Request Loan</div>
			<div class="field padding_none fg-black">
				<div class="input-control text field_limitText margin_none fg-black">
					<input id="request_loan_1" ng-model="filter.requestloan_start" num-formatter="0" type="text" style="max-width: 107px !important;">
					<input id="request_loan_2" ng-model="filter.requestloan_end" num-formatter="0" type="text" style="max-width: 107px !important; float: right;">
				</div>
			</div>
		</div>
		<div class="content close">
			<div class="label">A2CA Plan Date</div>
			<div class="field padding_none">
				<div class="input-control text field_limitText margin_none fg-black">
					<input id="plana2ca_range" name="plana2ca_range" ng-model="filter.plana2cadate" input-daterange-enable type="text" ng-change="changeFieldAllAuto(filter.plana2cadate, 'plana2ca')">
				</div>
			</div>
		</div>
		<div class="content close">
			<div class="label">A2CA Date</div>
			<div class="field padding_none">
				<div class="input-control text field_limitText margin_none fg-black">
					<input id="a2ca_range" name="a2ca_range" ng-model="filter.a2cadate" input-daterange-enable type="text" ng-change="changeFieldAllAuto(filter.a2cadate, 'a2ca')">
				</div>
			</div>
		</div>
		<div class="content close">
			<div class="label">CA Name</div>
			<div class="field padding_none">
				<div class="input-control text field_limitText margin_none fg-black">
					<input id="caname" name="caname" type="text" ng-model="filter.caname" value="" ng-change="changeFieldAllAuto(filter.caname, 'caname')">
				</div>
			</div>
		</div>
		
		<div class="content close" style="margin-bottom: 4px;">
			<div class="label">Appraisal Status</div>
			<span class="field padding_none">
				<select
					multiple="multiple" multi-select-list
					id="master_pending_option"
	                name="objPendingOption"
	                ng-model="filter.pending_option"
	                config="singleConfig"
	                data="masterdata.pending_option"
	                ng-options="option.DecisionValue as option.DecisionName for option in masterdata.pending_option"
	            	ng-change="handleShowPendingOption(filter.pending_option)">            			
	        	</select>	
        	</span>
		</div>
		
		<div class="content close">
			<div class="label">Decision Date</div>
			<div class="field padding_none">
				<div class="input-control text field_limitText margin_none fg-black">
					<input id="decisiondate_range" name="decisiondate_range" ng-model="filter.decisiondate" input-daterange-enable type="text" ng-change="changeFieldAllAuto(filter.decisiondate, 'decisiondate')">
				</div>
			</div>
		</div>
		
		<div class="content close">
			<div class="label">Decision Status</div>
			<div class="field padding_none">
				<select multiple="multiple" multi-select-list
						id="masterdecisionstate"
                        name="objDecisionStatus"
                        ng-model="filter.decisionstatus"
                        config="multipleConfig"
                        data="masterdata.decisionstatus"
                        ng-options="option.DecisionValue as option.DecisionName group by option.DecisionType for option in masterdata.decisionstatus"
                        ng-change="changeFieldAllAuto(filter.decisionstatus, 'decision_status'); handleShowPendingOption(filter.pending_option)">             			
        		</select>	
			</div>
		</div>
		
		
		<div class="content close">
			<div class="label">Decision Reason</div>
			<span class="field padding_none">
				<select multiple="multiple" multi-select-list
						id="masterdecisionreason"
                        name="objDecisionReason"
                        ng-model="filter.decisionreason"
                        config="multipleConfig"
                        data="masterdata.decisionreason"
                        ng-options="option.DecisionReasonValue as option.DecisionReasonName for option in masterdata.decisionreason"
                        ng-change="changeFieldAllAuto(filter.decisionreason, 'decision_reason')">            			
        		</select>	
			</span>
		</div>
		
		<div class="content close">
			<div class="label">Approved Loan</div>
			<div class="field padding_none fg-black">
				<div class="input-control text field_limitText margin_none fg-black">
					<input id="approvedloan_1" ng-model="filter.approvedloan_start" num-formatter="0" type="text" style="max-width: 107px !important;">
					<input id="approvedloan_2" ng-model="filter.approvedloan_end" num-formatter="0" type="text" style="max-width: 107px !important; float: right;">
				</div>
			</div>
		</div>
		
		<div class="content close">
			<div class="label">Drawdown Plan Date</div>
			<div class="field padding_none">
				<div class="input-control text field_limitText margin_none fg-black">
					<input id="plandrawdown_range" name="plandrawdown_range" ng-model="filter.plandrawdown" input-daterange-enable type="text" ng-change="changeFieldAllAuto(filter.plandrawdown, 'plan_dd_date')">
				</div>
			</div>
		</div>
		
		<div class="content close">
			<div class="label">Drawdown Date</div>
			<div class="field padding_none">
				<div class="input-control text field_limitText margin_none fg-black">
					<input id="drawdowndate_range" name="drawdowndate_range" ng-model="filter.drawdowndate" input-daterange-enable type="text" ng-change="changeFieldAllAuto(filter.drawdowndate, 'drawdowndate')">
				</div>
			</div>
		</div>		
		
		<div class="content close">
			<div class="label">Drawdown Loan</div>
			<div class="field padding_none fg-black">
				<div class="input-control text field_limitText margin_none fg-black">
					<input id="drawdownloan_1" ng-model="filter.drawdownloan_start" num-formatter="0" type="text" style="max-width: 107px !important;">
					<input id="drawdownloan_2" ng-model="filter.drawdownloan_end" num-formatter="0" type="text" style="max-width: 107px !important; float: right;">
				</div>
			</div>
		</div>
		
		<div class="content close">
			<button ng-click="grid_fieldclear()" type="button" class="bg-green fg-white" style="height: 33px; float: left; margin-left: 5px;">CLEAR</button>
			<button ng-click="grid_fieldsearch()" type="button" class="bg-lightBlue fg-white" style="height: 33px; float: right; margin-right: 20px;">
				<i class="icon-search on-left"></i>SEARCH
			</button>
		</div>
		
	</div>

	<article id="grid_main" ng-dblclick="closesidebar()">

		<article><img id="sidebar_icon" class="closeside" src="http://tc001pcis1p:8099/pcis/img/panel.png" ng-click="opensidebar()"></article>
		 
		<header class="nonprint marginTopEasing10 marginBottom10 text-center ">		
			<h2 >SALE WHITEBOARD</h2>
			<h4 class="text-center text-muted animated rubberBand"><?php echo date('d M Y'); ?></h4>
			<div id="definded_status" class="row animated rubberBand print_hold">
			    <div><span style="background: #c6eab6; padding: 0 10px; width: 100px; border: 1px dotted;">&nbsp;</span> Re-Activated</div>
			    <div><span style="background: #f4c6c6; padding: 0 10px; width: 100px; border: 1px dotted;"></span>&nbsp;Retrieved</div>
		    </div>
		</header>
		
		<div id="panel_criteria" class="panel print_hold nonprint" data-role="panel" style="width: 634px; float: right; margin-bottom: 13px;">
			<div class="panel-header bg-lightBlue fg-white" style="font-size: 1em;">
				<span><i class="fa fa-search on-left"></i>FILTER CRITERIA</span>
				<div class="using_information nonprint"></div>
			</div>
			<div class="panel-content" style="display: none;">
				
				<div class="row margin_none place-right">
					<div class="place-left marginRight20">					
						<div class="input-control radio" data-role="input-control" style="margin-right: 5px;">
					        <label>
					            <input id="activestate_1" name="activestate" ng-model="filter.activestate" type="radio" value="Active" ng-click="inactiveChange()" ng-disabled="filter.drawdown_mth || filter.performnaces" checked>
					            <span class="check"></span>
					            <span class="label label-clear" style="background-color: #FFF !important;">Active</span>
					        </label>
					   	 </div>
					   	 
					   	 <div class="input-control radio" data-role="input-control" style="margin-right: 5px;">
					        <label>
					           <input id="activestate_2" name="activestate" ng-model="filter.activestate" type="radio" value="Inactive" ng-click="inactiveChange()" ng-disabled="filter.drawdown_mth || filter.performnaces || cr_readonly">
					           <span class="check"></span>
					           <span class="label label-clear" style="background-color: #FFF !important;">Inactive</span>
					        </label>
					     </div>
					     
					     <div class="input-control radio" data-role="input-control">
					        <label>
					            <input id="activestate_3" name="activestate" ng-model="filter.activestate" type="radio" value="All" ng-click="inactiveChange()"> 
					            <span class="check"></span>
					            <span class="label label-clear" style="background-color: #FFF !important;">All</span>
					        </label>
					    </div>
					</div>    
					
					<div class="place-left place-right" style="min-width: 290px; text-align: right; border-left: 1px dotted #D1D1D1; max-height: 31px; margin-bottom: 10px;">
						<div class="input-control checkbox text-left">
		    				<label>
		    					<input id="performance_cm" name="performance_cm" ng-model="filter.performnaces" type="checkbox" ng-disabled="filter.drawdown_mth || filter.cn_flag" ng-click="changePerformFieldFilter()">
		    					<span class="check"></span> CM Performance
		    				</label>
		    			</div>
						
						<div class="input-control checkbox text-left">
		    				<label>
		    					<input id="drawdown_cm" name="drawdown_cm" ng-model="filter.drawdown_mth" type="checkbox" ng-disabled="filter.performnaces  || filter.cn_flag" ng-click="changeDDFieldFilter()">
		    					<span class="check"></span> CM Drawdown
		    				</label>
		    			</div>
		    			
		    			<div class="input-control checkbox text-left marginLeft10">
		    				<label>
		    					<input id="filter_cncancel" name="filter_cncancel" ng-model="filter.cn_flag" type="checkbox" ng-disabled="filter.drawdown_mth || filter.performnaces">
		    					<span class="check"></span> CN003
		    				</label>
		    			</div>
	    			</div>
						
				</div>
				<div class="row margin_none place-right">				
					<div class="input-control select span2 marginRight10">
						<div class="span2">Region</div>
						<select multiple="multiple" multi-select-list
								id="masterregion"
                                name="objMasterRegion"
                                ng-model="filter.regional"
                                config="multipleConfig"
                                data="masterdata.region"
                                ng-options="option.RegionID as option.Info for option in masterdata.region"
                                ng-disabled="!region_filter"
                                ng-change="onRegionChange()">
                        </select>							
					</div>
					<div class="input-control select span2 marginRight10">
						<div class="span2">Area</div>
						<select multiple="multiple" multi-select-list
								id="masterareas"
                                name="objMasterAreas"
                                ng-model="filter.areas"
                                config="multipleConfig"
                                data="masterdata.area"
                                ng-options="option.AreaID as option.Info for option in masterdata.area" 
                                ng-disabled="!areas_filter"
                                ng-change="onAreaChange()">
                        </select>
					</div>
					<div class="input-control select span2 marginRight10">
						<div class="span2">Branch</div>
						<select multiple="multiple" multi-select-list
								id="masterbranch"
                               	name="objMasterBranch"
                                ng-model="filter.branch"
                                config="multipleConfig"
                                data="masterdata.branch"
                                ng-options="option.BranchCode as option.BranchName for option in masterdata.branch | filter: { BranchDigit: '!HQ' }"
                                ng-disabled="!branch_filter"
                                ng-change="onBranchChange()"></select>
					</div>
					<div class="input-control select span2">
						<div class="span2">Emp. Name</div>
						<select multiple="multiple" multi-select-list
								id="mastermultiemployee"
                               	name="objMasterEmployee"
                                ng-model="filter.employee"
                                config="multipleConfig"
                                data="masterdata.employee"
                                ng-disabled="!rmlist_filter"                                
                                ng-options="option.EmployeeCode as ('(' + option.Position + ') ' + option.FullNameTh + ' (' + option.BranchDigit + ')') for option in masterdata.employee | orderBy: ['BranchCode', 'Position']"
                                ng-change="loadEmpProfile()">
                        </select>
					</div>			
				</div>
				<div class="row margin_none">
					<div class="place-left" style="margin-left: 20px;">		
						<div class="input-control text span2 place-left marginRight10" style="margin-left: 4px;">
							<div class="span4">Application No</div>
							<input id="applicationno" name="applicationno" type="text" value="" ng-model="filter.application_no" class="span2 marginLeft_none">
						</div>	
						 <div class="input-control text span2 place-left marginRight10">
							<div class="span4">Customer</div>
							<input id="customer" name="customer" type="text" value="" ng-model="filter.borrowername" class="span2 marginLeft_none">
						</div>	
						<div class="input-control select span2 place-left padding_none">
					        <div class="span4">Optional</div>
					        <select multiple="multiple" multi-select-list
					        	id="masteroptional"
                               	name="objOptional"
                                ng-model="filter.optional"
                                config="multipleConfig"
                                data="masterdata.optional"
                                ng-change="onOptionVerify()"
                                ng-options="option.FieldValue as option.FieldName group by option.GroupID disable when option.disabled for option in masterdata.optional">
				        	</select>	       
					    </div>					   					
				    </div>	
				    <div class="place-right paddingTop20">
				    	<button ng-click="grid_fieldclear()" type="button" id="filterClear" class="bg-green fg-white" style="height: 33px; float: right; padding: 4px 7px;">CLEAR</button>
						<button ng-click="grid_fieldsearch()" type="button" id="filterSubmit" class="bg-lightBlue fg-white" style="height: 33px; float: right; margin-right: 5px; padding: 4px 7px;">SEARCH</button>
				    </div>				
				</div>
				
			</div>
		</div>
		
		<div class="OptionTool marginRight10 parent_print_detail nonprint" data-placement="left">
			<button ng-click="print_whiteboard" class="hide" type="button"><i class="fa fa-info-circle"></i></button>
			<button ng-show="print_handle" ng-click="print_whiteboard()" type="button"><i class="fa fa-print"></i></button>			
		</div>
		
		<nav class="read_tool nonprint">
			<ul class="clearfix">
				<li class="collaspe"><a href="#" class="btn"><i class="icon-book" style="font-size: 1.4em;"></i></span></a>	
					<ul>
						<li>
							<a href="<?php echo base_url('PCIS Handbook/PCIS SALE WHITEBOARD.pdf'); ?>" target="_blank">
								<i class="icon-book" style="font-size: 1.4em;"></i>
							</a>
						</li>
						<li>
							<a href="#">								
								<span class="fa-stack fa-lg">
								  <i class="fa fa-video-camera" aria-hidden="true"></i>
								  <i class="fa fa-ban fa-stack-2x text-danger" style="color: #fd6252;"></i>
								</span>
							</a>
						</li>
					</ul>	
				</li>	
			</ul>
		</nav>	
		
		<div class="number_length nonprint"></div>

		<article>
			<table id="grid_whiteboard" class="table bordered hovered">
				<thead>
				    <tr class="brands">
				        <th colspan="2" style="vertical-align: middle;">DATE</th>
				        <th colspan="3" class="text-center">NAME</th>
				        <th colspan="3" class="text-center">LOAN REQUEST</th>
				        <th colspan="2" class="text-center">APP TO CA</th>
				        <th colspan="4" class="text-center">STATUS ( P / A / R / C / CR / PC)   </th>
				        <th colspan="4" class="text-center">DRAWDOWN DATE</th>
				        <th style="border-bottom: 0; vertical-align: middle; min-width: 220px; max-width: 220px;"></th>
				        <th colspan="2" style="border-bottom: 0; vertical-align: middle; min-width: 20px; max-width: 20px; border-left: 0;"></th>
				    </tr>
				    <tr class="brands">
				        <th style="text-align: center; min-width: 40px !important; vertical-align: middle;">START</th>
				        <th style="text-align: center; min-width: 10px !important; vertical-align: middle;"><abbr title="DAY" style="border:none;"><i class="fa fa-flag-o print_hold nonprint"></i></abbr></th>
				        <th style="text-align: center; min-width: 110px !important; vertical-align: middle;">CUSTOMER</th>
				        <th style="text-align: center; min-width: 80px !important; vertical-align: middle;">RM</th>
				        <th style="text-align: center; min-width: 30px !important; vertical-align: middle;"><abbr title="Branch" style="border:none;">LB</abbr></th>
				        <th style="text-align: center; min-width: 50px !important; vertical-align: middle;"><abbr title="Product Program" style="border:none;">PG</abbr></th>
				        <th style="text-align: center; min-width: 50px !important; max-width: 50px !important; vertical-align: middle;"><abbr title="Amount" style="border:none;">AMT</abbr></th>
				        <th style="text-align: center; min-width: 10px !important; vertical-align: middle;"><abbr title="DAY" style="border:none;"><i class="fa fa-flag-o print_hold nonprint"></i></abbr></th>
				        <th style="text-align: center; min-width: 40px !important; vertical-align: middle;">
				        	<span id="parent_dateonhand" data-placement="right" style="font-weight: bolder;">DATE</span>
				        </th>
				        <th style="text-align: center; min-width: 75px !important; max-width: 75px !important; vertical-align: middle;">NAME</th>
				        <th style="text-align: center; min-width: 40px !important; vertical-align: middle;">
				        	<span id="parent_status_detail" data-placement="right" style="font-weight: bolder;">ST</span>
				        </th>
				        <th style="text-align: center; min-width: 40px !important; vertical-align: middle;">DATE</th>
				        <th style="text-align: center; min-width: 50px !important; vertical-align: middle;"><abbr title="Amount" style="border:none;">AMT</abbr></th>
				        <th style="text-align: center; min-width: 10px !important; vertical-align: middle;"><abbr title="DAY" style="border:none;"><i class="fa fa-flag-o print_hold nonprint"></i></abbr></th>
				        <th style="text-align: center; min-width: 40px !important; vertical-align: middle;">PLAN</th>
				        <th style="text-align: center; min-width: 65px !important; vertical-align: middle;">ACTUAL</th>
				        <th style="text-align: center; min-width: 50px !important; vertical-align: middle;"><abbr title="Amount" style="border:none;">AMT</abbr></th>
				        <th style="text-align: center; min-width: 10px !important; vertical-align: middle;"><abbr title="DAY" style="border:none;"><i class="fa fa-flag-o print_hold nonprint"></i></abbr></th>
				        <th style="vertical-align: middle; border-right: 0px; min-width: 220px">ACTION NOTE</th>
				        <th style="vertical-align: middle; border-right: 0px; border-left: 0; min-width: 20px; max-width: 20px;">&nbsp;</th>        
				    </tr>
			    </thead>
				<tbody>
					<tr ng-class="{ 'retrieve': item.ResetState == 'RET', 'reactive': item.ResetState == 'REA' }"  ng-repeat="item in data_item | orderBy: ['-StartDate']" on-last-repeat="bindData">
						<td>{{ item.StartDate }}</td>
						<td class="text-center"><span compile-html="item.OverallDay"></span></td>
						<td>
							{{ item.BorrowerName }}
							<div class="printonly" ng-class="{ 'nonprint' : AppNo }">{{item.AppNo}}</div>
						</td>
						<td>{{ item.RMName | setWordwise:true:12:'...' }}</td>
						<td><span compile-html="item.LBName"></span></td>
						<td class="text-center">
							<div class="printonly" ng-class="{ 'nonprint' : !item.Bank }">{{item.Bank}}</div>
							<span compile-html="item.Product"></span>
						</td>
						<td class="text-right">{{ item.RequestLoan | number: 0 }}</td>
						<td class="text-center"><span compile-html="item.RMOnhandCount"></span></td>
						<td class="text-center"><span compile-html="item.A2CADate"></span></td>
						<td>{{ item.CAName | setWordwise:true:10:'...' }}</td>						
						<td class="text-center">
							<span ng-if="item.StatusReason !== ''" webui-tooltip-bundle config="webuiConfigBundle" data-content="{{ item.StatusReason }}">
								<span class="iconCursor" compile-html="item.Status" ng-click="openFileOwnershipDoc(item.objectsItem)"></span>
							</span>							
							<span ng-if="item.StatusReason == ''" compile-html="item.Status" ng-click="openFileOwnershipDoc(item.objectsItem)"></span>
						</td>
						<td ng-if="item.Status !== 'CR'">{{ item.StatusDate }}</td>
						<td ng-if="item.Status == 'CR'">{{ item.CAReturnDateLog }}</td>
						<td class="text-right" ng-class="{ 'fg-retrieve': item.ResetState == 'RET', 'fg-reactive': item.ResetState == 'REA', 'fg-white': item.ApprovedLoan == 0 }">{{ item.ApprovedLoan | number: 0 }}</td>
						<td class="text-center"><span ng-show="item.LatestAppProgress == 'A2CA' || item.Status == 'CR'" compile-html="item.CAOnhandCount"></span></td>
						<td class="text-center">
							<span ng-if="!item.PlanDateUnknown">{{ item.PlanDrawdownDate }}</span>
							<span ng-if="item.PlanDateUnknown">00/00/0000</span>
						</td>
						<td class="text-center">
							<span ng-if="item.StatusDesc == 'A'" compile-html="item.DrawdownDate"></span>
							<span ng-if="item.StatusDesc !== 'A'">&nbsp;</span>
						</td>					
						<td class="text-right" data-volume="{{ (item.StatusDesc == 'A') ? item.DrawdownVolum : 0 }}" ng-class="{ 'fg-retrieve': item.ResetState == 'RET', 'fg-reactive': item.ResetState == 'REA', 'fg-white': item.DrawdownVolum == 0 }">
							<span ng-if="item.StatusDesc == 'A'">{{ item.DrawdownVolum | number: 0 }}</span>
							<span ng-if="item.StatusDesc !== 'A'">&nbsp;</span>
						</td>
						<td class="text-center"><span ng-show="item.StatusDesc == 'A'" compile-html="item.DrawdownCount"></span></td>
						<td>							
							<i ng-if="item.HasActionNote == 'Y'" ng-click="openActionNoteHistory(item.DocID, item.objectsItem)" class="fa fa-commenting-o nav_icon marginRight5 nonprint" style="font-size: 1.2em !important; color: dodgerblue; position: absolute;"></i>
							<div hm-read-more hm-text="{{ item.ActionNote }}" hm-limit="70" hm-more-text="เพิ่มเติม" hm-less-text="&#60;&#60;&#60;" hm-dots-class="dots" hm-link-class="" class="nonprint"></div>
							<div class="printonly">{{ item.ActionNoteNormal || '&nbsp;' }}</div>
						</td>
						<td class="text-center nonprint"><span compile-html="item.ProfileLink"></span></td>
					</tr>
				</tbody>
				<tfoot>	
					<tr class="fg-darkBlue text_bold">
						<th colspan="5" class="text-left">{{ grandTotal.current_page }}</th>
						<th></th>
						<th class="text-right"></th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th class="text-right"></th>
						<th></th>	
						<th></th>
						<th></th>	
						<th class="text-right"></th>
						<th></th>
						<th></th>
						<th></th>
			     	</tr>     	
			     	<tr class="brands fg-white text_bold">
						<th colspan="5" class="text-left">{{ grandTotal.grandtotal_page }}</th>
						<th></th>
						<th class="text-right">{{ grandTotal.requestloan_footer | number: 0 }}</th>
						<th></th>
						<th></th>
						<th></th>	
						<th></th>
						<th></th>
						<th class="text-right">{{ grandTotal.approvedloan_footer | number: 0 }}</th>
						<th></th>	
						<th></th>
						<th></th>	
						<th class="text-right">{{ grandTotal.drawdownloan_footer | number: 0 }}</th>
						<th></th>
						<th></th>
						<th></th>
			     	</tr>     	
				</tfoot>
			</table>
		</article>
	</article>
	
	<!-- PDF Ownership Doc. -->
	<script id="modalDocument.html" type="text/ng-template">
	<div class="modal-header text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<button type="button" class="bg-teal fg-white" ng-click="openMissingDocForPreview()" style="margin-top: -9px; border-radius: 5px;">
				<div class="icon_box" style="font-size: 2em;">
					<i class="icon-copy span-left modal-icon" style="margin: 0 auto;"></i>
					<span class="badge bg-amber" style="font-size: 0.4em !important; position: absolute; margin-top: 0px; margin-left: -13px;">{{ missing_count }}</span>
				</div>
				<div class="text_box">Missing Doc<div>
			</button>
			<button type="button" class="bg-olive fg-white" ng-disabled="!ownershipdoc" ng-click="openPDFFileRender(file_config.file_1)" style="margin-top: -9px; border-radius: 5px;">
				<div class="icon_box">
					<i class="fa fa-wpforms span-left modal-icon" style="margin: 0 auto; margin-left: 10px;"></i>
					<span class="badge bg-amber" style="font-size: 0.8em !important; position: absolute; margin-top: 0px; margin-left: -13px;">{{ ownership_str }}</span>
				</div>
				<div class="text_box text_bold" style="position: absolute; margin-top: -10px;">ตัวอย่าง</div>
				<div class="text_box">การขออนุโลม  กสปส<div>
			</button>
			<button type="button" class="bg-amber fg-white" ng-click="openPDFFileRender(file_config.file_2)" style="margin-top: -9px; border-radius: 5px;">
				<div class="icon_box"><i class="fa fa-file-text-o span-left modal-icon" style="margin: 0 auto;"></i></div>
				<div class="text_box">นส.ทดแทน กสปส<div>
			</button>
			<button type="button" class="bg-darkBlue fg-white" ng-click="openLinkCollateral()" style="margin-top: -9px; border-radius: 5px;">
				<div class="icon_box"><i class="fa fa-laptop span-left modal-icon" style="margin: 0 auto;"></i></div>
				<div class="text_box">Collateral<div>
			</button>
			<i class="fa fa-close modal-icon marginLeft10" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title fg-white">Document Information</h4>
	</div>
	<div class="modal-body paddingLeft25 paddingRight25">
		<div id="pdf_thumbnail" class="content mCS-light-thin mCS-autoHide">
			<pdf-file-list config="config" data="itemList"></pdf-file-list>
		</div>
	</div>
	<div class="modal-footer marginBottom10"></div>
	</script>
	
	<!-- Missing Modal -->
	<script id="modalMissing.html" type="text/ng-template">
	<div class="modal-header text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title fg-white">Missng Doc. Information</h4>
	</div>
	<div class="modal-body paddingLeft25 paddingRight25">
		 <table class="table bordered">
	     	<thead>
				<tr class="brands">
                    <th align="center" style="width: 5em;">TYPE</th>
					<th align="center" style="width: 31em;">DOCUMENT</th>
					<th align="center" style="width: 10em;">LB <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
					<th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> HO RECEIVED</th>
					<th align="center" style="width: 10em;">HO <i class="fa fa-arrow-right on-right on-left"></i> CA</th>
					<th align="center" style="width: 10em;">CA <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
					<th align="center" style="width: 10em;">HO <i class="fa fa-arrow-right on-right on-left"></i> LB</th>
					<th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> LB RECEIVED</th>                           
				</tr>
			</thead>
			<tbody>      
				<tr ng-repeat="item in itemList track by $index" class="text-center">
					<td>{{ item.DocStatus }}</td>
					<td class="text-left">
						<span ng-class="{ 'fg-red': item.DocIsLock == 'Y'}">{{ item.DocList }} </span>
						<span>{{ item.DocOther }}</span>
					</td>
					<td>{{ item._LBSubmitDocDate.split(' ')[0] || 'รอส่งเอกสาร' | date:"dd/MM/yyyy"  }}</td>
					<td>
						{{ item._HQReceivedDocFromLBDate.split(' ')[0] || '' | date:"dd/MM/yyyy" }}
						<span ng-if="item._LBSubmitDocDate && !item._HQReceivedDocFromLBDate"}>รอรับเอกสาร</span>
					</td>
					<td>{{ item._SubmitDocToCADate.split(' ')[0] || '' | date:"dd/MM/yyyy" }}</td>
					<td><i class="fa fa-close fg-red"></i></td>
					<td><i class="fa fa-close fg-red"></i></td>
					<td><i class="fa fa-close fg-red"></i></td>
				</tr>
			</tbody>
		</table>          
	</div>
	<div class="modal-footer marginBottom10"></div>
	</script>
	
	<script id="modalActionNote.html" type="text/ng-template">
	<div modal-draggle>
	<div class="modal-header fixed text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i id="fixcontent_log" class="modal-icon" ng-class="{ 'fa fa-chevron-circle-down' : !modalToggle, 'fa fa-chevron-circle-up' : modalToggle }" ng-click="setModalHeight(modalToggle)" style="font-size: 1.2em;"></i>
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()" style="font-size: 1.2em;"></i>
		</div>
		<span>Action Note Information</span>
		<span ng-show="noteinfo" class="animated fadeIn">
		(
			<span ng-if="headinfo.custname !== ''">{{ headinfo.custname }}</span>
			<span ng-if="headinfo.buz_type !== ''"> / ประเภทธุรกิจ {{ headinfo.buz_type }} - {{ headinfo.buz_desc }}</span>
			<span ng-if="headinfo.appnumber !== ''"> / App No : {{ headinfo.appnumber }}</span>
			<span ng-if="headinfo.a2cadate !== ''"> / {{ headinfo.a2cadate }}</span>
		)
		</span>
	</div>
	<div class="modal-body paddingLeft25 paddingRight25" style="{{ modalHeight }};">
		<div class="nonprint">
			<scrollable-table>
			<table id="parent_noteItemList" class="table bordered">
				<thead>
					<tr class="brands fg-black">	
	      				<th width="1%">#</th>
						<th width="12%">DATE</th>      	 			
	      				<th width="15%">NAME</th> 
						<th width="12%">FUNCTION</th>
	      				<th width="57%">NOTE DETAILS</th>   	 					      	 				
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="list in itemList | orderBy:'-UpdateDate' track by $index">	    
						<td style="text-align: center;">{{ ($index +1) }}</td>	
						<td style="text-align: center;">{{ list.ActionNoteDate + ' ' + list.ActionDateTime || '&nbsp;' }}</td>
						<td>{{ list.ActionName || '&nbsp;' }}</td>
						<td>{{ list.PositionShort || '&nbsp;' }}</td>
						<td>{{ list.ActionNote || '&nbsp;' }}</td>
					</tr>
				</tbody>
			</table>
			</scrollable-table>
			<span ng-if="progress"><i class="fa fa-circle-o-notch fa-spin"></i> Loading...</span>
		</div>
	</div>
	<div class="modal-footer">
		<i class="fa fa-clipboard modal-icon fg-steel" ng-click="selectTextAll('parent_noteItemList')" style="font-size: 1em; opacity: 0.8;"></i>
	</div>
	</div>
	</script>
	
	<script type="text/javascript">
		$('#parent_dateonhand').hover(function() {

			var html = $('#dateonhand').html();
	    	$(this).webuiPopover({
		    	title: 'Progress Date',
	    		trigger:'hover',	
	    		padding: true,
	    		content: html,
	    		backdrop: false
	    	});
	
	    });  
	
		$('#parent_status_detail').hover(function() {
			
			var html = $('#status_detail').html();
	    	$(this).webuiPopover({
				title: 'Decision Status',
	    		trigger:'hover',	
	    		padding: true,
 	    		content: html,
	    		backdrop: false
	    	});
	    	
	    });    

		$('.parent_print_detail').hover(function() {			
			var html = $('#print_detail').html();
	    	$(this).webuiPopover({
	    		trigger:'hover',	
	    		padding: true,
 	    		content: html,
	    		backdrop: false
	    	});
	    	
	    });  

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