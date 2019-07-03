<!DOCTYPE html>
<html lang="en" ng-app="pcisDrawDownTemplate">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KPI Viewer</title>
    <meta name="description" content="<?php echo $desc; ?>">    
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/tcrbank.ico'); ?>" type="image/x-icon">
        
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/jquery-ui/jquery-ui.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/bootstrap-checkbox.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/plugin/malihuscrollbar/jquery.mCustomScrollbar.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/metro/iconFont.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap.css'); ?>"> 	
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap-ui.css'); ?>"> 
 		
 	<link rel="stylesheet" href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>"> 
 	<link rel="stylesheet" href="<?php echo base_url('css/animate/animate.min.css'); ?>">  
 	<link rel="stylesheet" href="<?php echo base_url('css/notifIt/notifIt.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/themify-icons.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/flaticon/flaticon.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/mmenu.css'); ?>">	
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/wp.custom.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/element-color-theme.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/tooltip_custom.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/webui-popover/jquery.webui-popover.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/multi-select/multiple-select.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/kalendea/kalendae.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/drawdown_template.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/lightbox/css/lightbox.min.css'); ?>">
 	
 	<!-- Include for Chat -->
 	<link rel="stylesheet" href="<?php echo base_url('css/googlefont.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/clndr/material-design-iconic-font/css/material-design-iconic-font.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/angular_1.5/angular-material.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/scrollable-table/scrollable-table.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/clndr/snarl/snarl.min.css'); ?>">
   	<link rel="stylesheet" href="<?php echo base_url('js/clndr/chat-client.css'); ?>">
	<!-- End Chat Style -->
	
	<script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery-ui.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.mousewheel.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.number.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.mask.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/kalendea/kalendae.standalone.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugin/malihuscrollbar/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/moment.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugin/notifIt/notifIt.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugin/webui-popover/jquery.webui-popover.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/vendor/jquery.rotate.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/jqGrid/js/i18n/grid.locale-en.js'); ?>" type="text/ecmascript" ></script>  
	<script src="<?php echo base_url('js/jqGrid/js/jquery.jqGrid.min.js'); ?>" type="text/ecmascript" ></script>
	<script src="<?php echo base_url('js/plugin/pdf_thumbnails/pdf.worker.js'); ?>"></script>  
	<script src="<?php echo base_url('js/plugin/pdf_thumbnails/pdf.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
	
	<!-- START INCLUDE CHAT SCRIPT -->
	<script src="<?php echo base_url('js/angular/angular_1.5/angular.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-animate.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-aria.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-messages.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/scrollable-table/angular-scrollable-table.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-sanitize.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-filter.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/ui-bootstrap-tpls-1.1.2.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-checklist-model.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/angular.ui.mask.min.js'); ?>"></script>
	
	<!-- Angular Material Library -->
    <script src="<?php echo base_url('js/clndr/angular-material.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/jquery.slimscroll.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/moment-with-locales.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/bundle/lodash.min.js'); ?>"></script>

	<script src="<?php echo base_url('js/angular/notification/angular-ui-notification.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/readmore.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/ion.sound.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/socket.io.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/snarl/snarl.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/vendor/jquery.multiple.select.js'); ?>"></script>	
	<script src="<?php echo base_url('js/clndr/bootstrap-multiselect.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/chat-client.js?v=004'); ?>"></script>	
	<script src="<?php echo base_url('js/build/collection/collection_script.js?v=007'); ?>"></script>	
	<script src="<?php echo base_url('js/build/module/drawdown-template.js?v=091'); ?>"></script>	
	<script src="<?php echo base_url('js/md5/md5.js'); ?>"></script>
	<script>
		$(function() {
			$('.kalendae').mouseleave(function () {
		    	 $(this).hide();
		    	 $(this).blur();
		    })
		});
	</script>
	<style type="text/css">
		
		.binding2 { opacity: .2; }
		#ui_notifIt { margin-top: 20px; }
		
		table#grid_container > tbody td:nth-child(14) { background: #E2F1FF; }
		table#grid_container > tbody td:nth-child(15) { background: #E2F1FF; }
		table#grid_container > tbody td:nth-child(16) { background: #E2F1FF; }
		table#grid_container > tbody td:nth-child(17) { background: #E2F1FF; }
		
		span.pagingation_info {
		    font-size: 1em;
		    padding: 3px;
		    position: absolute;
		    top: 170px;
		    margin-left: 3px;
		}
		
		.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
		    border: 1px solid red !important;
		}

		.ui-jqgrid tr.jqgrow td{
		    height: auto;
		    white-space: normal;
		    vertical-align: top !important;
		}
		
		table#grid_container > tbody td {
		    vertical-align: top !important;
		    text-align: center;
		}
		
		.chat-client .dropdown.open .dropdown-menu { z-index: 2000000; }  
		span.s-ico { display: none !important; }
		
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
	
		.file_container:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.5); }
		
		.file_wrapper {
		    position: relative;
		    overflow: hidden;
		}
		
		.file_wrapper > span {
		    width: 100%;
		    background-color: rgba(0, 0, 0, 0.5);
		    position: absolute;
		    text-align: center;
		    left: 0;
		    padding: 20px 0;
		    color: #FFF;
		    transition: 0.5s ease-in-out;
		}
		
	
		.file_wrapper:hover > span { margin-top: -60px; }
		
		.file_container > .progress-bar {
			top: 0;
			position: absolute;
			min-width: 158px;
			max-width: 158px;
		}
		
		.thumbnail_file {
			width: 100%;
			height: 100%;
		}
		
		.divider_preview {
		    width: 100%;
		    padding-bottom: 10px;
		    margin-bottom: 10px;
		    border-bottom: 1px solid #E3E3E3;
		}
		
		.popover-title { width: 180px; !important; }
		.popover[role="tooltip"] {
			top: -5px;
		    left: 33.5px;
			display: block;
    	  	white-space:nowrap;
		    width: -webkit-fit-content !important; 

		}
		
		.popover-modal {  min-width: 510px !important; }
			
		.ms-choice { padding: 0 5px; }
		.label-disable { color: #959595; }
		.has-elemError { border: 1px solid #A94442; border-radius: 3px; }
		
		.frozen-sdiv.ui-jqgrid-sdiv { position: fixed !important; }
		#grid_container tbody tr > td[aria-describedby="grid_container_CR_LINE"] { padding-right: 5px; }
		
		/** multi **/
		#mslist_status_multiple { width: 160px !important; }
		#mslist_optional_multiple { width: 210px !important; right: 0px !important; }
		
		/** Overide MultiList Chat **/
		.chat-client .dropdown-menu:not([class*=bgm-]) > li > a {
		    padding-left: 25px !important;
		}
		
		.chat-modal .multiselect-container .checkbox .input-helper:after {
		    left: -20px !important;
		    top: -5px !important;
		}
		
		.chat-modal .multiselect-container .checkbox .input-helper:before, .radio .input-helper:before { border: 0 !important; }
		.kalendae.k-floating { left: 920px !important; }
		
		.progress_icon {
			position: absolute; 
			margin-top: 16.5%; 
			margin-left: 43.35%;  
			z-index: 2147483647;
		}
		
		.blackboard {
			width: 100%; 
			height: 1400px; 
			position: absolute; 
			background: #000; 
			opacity: 0.2; 
			margin-top: -100px;
			z-index: 2147483647;
		}
		
		.vshow { visibility: visible; }
		.vhidden { visibility: hidden; } 
		
	</style>
	<style type="text/css" media="print">	
 	
		.nonprint { display: none; }		
		@media print {
			body { font-size: 12px; }
	
		}			
		
	</style>	
</head>
<body>

<?php $id_authority = !empty($session_data['emp_id']) ? $session_data['emp_id']:''; ?>
<?php $role_authority = !empty($role_department) ? $role_department:''; ?>
<input id="lastDayOfMonth" name="lastDayOfMonth" type="hidden" value="<?php echo date('Y-m-d', strtotime(date('Y-m-t') . "+1 days")); ?>">

<div id="bs-nav" class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mm-navbar-collapse" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </button>
	    	<a class="navbar-brand" href="#" style="margin-top: 2px !important;">
				<span id="mm-panels">
					<div class="element" style="text-align: center; cursor: pointer;">
			            <img src="<?php echo base_url('img/PCIS_log_icon.png'); ?>" style="height: 57px; margin-top: -20px;" class="animated fadeInDown">
			        </div>
				</span>
			</a>					
		</div>
		<div id="mm-navbar-collapse" class="collapse navbar-collapse">
	        <ul class="nav navbar-nav navbar-right">	  
	        	<li><div class="marginTop5 <?php echo ($role_authority !== 'LB_ROLE') ? 'hide':''; ?>" ui-chat-client="<?php echo $id_authority; ?>" direct-chat-click="direct_chat" direct-chat-to="<?php echo $id_authority; ?>" chat-dialog-position="right" chat-status="chat_state"></div></li>	        	
	        	<li class="divider-vertical" style="margin-right: -2px;"></li>       
		    	<li><span id="direct_chat" class="using_information"></span></li>
		    	<li class="divider-vertical" style="margin-left: 10px;"></li>   
		    	<li class="animated fadeIn" style="margin-left: -5px; margin-right: -15px;">
		    		<a href="<?php echo site_url("authen/logout"); ?>"><i class="icon-switch on-left" style="font-size: 1.6em !important; color: #FFF;"></i></a>
		    	</li>
      		</ul>	
      	</div>		
	</div>
</div>

<div ng-controller="ctrlPcisDrawDownTemplate" ui-role-cilent="<?php echo $role_authority; ?>" class="nonprint">

	<div class="progress progress_icon animated fadeIn"><img src="<?php echo base_url('img/378_1.gif'); ?>"></div>
	<div class="progress blackboard"></div>
	
	<div class="text-center">
		<h3>DRAWDOWN DASHBOARD</h3>
	</div>

	<div style="position: absolute; float: left; margin-top: 25px; margin-left: 5px;">
		<a href="<?php echo base_url('img/LB_PCIS DDTemplate_Help_20160913.jpg'); ?>" data-lightbox="image-1" data-title="Drawdown Template Information"><span><button type="button" class="btn btn-primary btn-xs fg-white"><i class="fa fa-info-circle"></i> Help</button></span></a>
		<a href="http://172.17.9.94/newservices/LBServices.svc/file/refinancemanual" target='_blank'><span><button type="button" class="btn btn-primary btn-xs fg-white"><i class="fa fa-info-circle"></i> Refinance Info</button></span></a>
		<a href="http://tc001orms1p/CollateralAppraisal/Default.aspx" target='_blank'>
			<button  type='button' class='btn btn-success btn-xs fg-white'><i class="fa fa-laptop"></i> Collateral</button>
		</a>
		<span>
			<button type="button" class="btn bg-teal btn-xs fg-white" ng-click="exportFileReport()" ng-disabled="!role_field.dashboard.exportFile">
				<i class="fa fa-download"></i> &nbsp;Export
			</button>
		</span>
		<span>
			<button type="button" class="btn bg-blue btn-xs fg-white" ng-click="reloadGrid()">
				<i class="fa fa-refresh"></i> &nbsp;Refresh
			</button>
		</span>
	</div>
	
	<span class="dd_read_tool" style="z-index: 1;">
		<ul>
			<li class="collaspe">
				<a href="#" class="btn"><i class="ti-book" style="font-size: 1.4em;"></i></a>	
				<ul>
					<li>
						<a href="<?php echo base_url('PCIS Handbook/PCIS Drawdown Template.pdf'); ?>" target="_blank" style="line-height: 46px;">
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
	</span>  
	
	<div class="col-md-6 marginTop20 pull-right" style="position: absolute;z-index: 1000; right: 0; margin-top: 20px;">
		<div class="panel panel-lightBlue">
		
			<div id="panel_parent" class="panel-heading bg-lightBlue fg-white panel-collapsed" ng-click="panel_collapsed('panel_parent')">
				<h3 class="panel-title">FILTER CRITERIA</h3>
				<span class="pull-right clickable"><i class="fa fa-chevron-circle-down"></i></span>
			</div>
			<div class="panel-body" style="display: none; padding: 5px !important;">
			
				<div class="col-md-12 padding_none">
					<div class="form-group col-md-5 paddingLR_none paddingTop20" style="max-width: 260px !important;">
						<div class="radio radio-danger radio-inline">
                        	<input name="isActive" ng-model="filter.isActive" type="radio" value="A">
                            <label for="">Active</label>
                        </div>
                        
                        <div class="radio radio-danger radio-inline">
                        	<input name="isActive" ng-model="filter.isActive" type="radio" value="N">
                            <label>Inactive</label>
                        </div>
                        
                        <div class="radio radio-danger radio-inline">
	                        <input name="isActive" ng-model="filter.isActive" type="radio" value="">
	                        <label>All</label>
	                    </div>
					</div>	
					
					<div class="col-md-2 padding_none minWidth128 marginLeft10">
						<label class="col-md-12 text-warning padding_none">Filter Date</label>
						<div class="has-warning padding_none">
							<select ng-model="filter.inputDateType" ng-change="onInputFilterDateChange()" class="form-control paddingLR_none">
								<option value=""></option>
								<option value="N">Plan DD (ใหม่)</option>
								<option value="O">Plan DD (เก่า)</option>
								<option value="A">Plan DD (N+O)</option>
								<option value="Decision Date">CA Decision Date</option>
								<option value="Oper Date">Oper. Decision Date</option>
							</select>
						</div>						
					</div>
					<div class="col-md-2 padding_none minWidth128 has-warning marginLeft10">
						<label class="padding_none">&nbsp;</label>
						<input id="inputDateRange" name="inputDateRange" ng-model="filter.inputDateRange" type="text" input-field-daterange class="form-control" ng-disabled="!filter.inputDateType">
					</div>
	
					<div class="col-md-2 padding_none marginLeft10">
						<label class="padding_none" ng-class="{ 'label-disable' : filter.ddPlanVol }">Score</label>
						<div class="padding_none">
							<select id="masterscoreRank" multiple="multiple" multi-select class="minWidth128"
                               	name="objMasterCaseScore"
                                ng-model="filter.score"
                                config="multipleConfig"
                                data="masterdata.case_score"
                                ng-options="option.Score as option.Score + ' ' + option.Label for option in masterdata.case_score">
                        	</select>
						</div>
					</div>
									
				</div>
			
				<div class="col-md-12 marginTop5 padding_none">
					<div class="form-group">
						
						<div class="col-md-2 padding_none minWidth128 marginLeft10">
							<label>Region</label>
							<select id="masterregion" multiple="multiple" multi-select
                               		name="objMasterRegion"
                                	ng-model="filter.regional"
                                	config="multipleConfig"
                                	data="masterdata.region"
                                	ng-options="option.RegionID as option.RegionNameEng for option in masterdata.region" 
                                	ng-change="onRegionChange()">
                        	</select>							
						</div>
						<div class="col-md-2 padding_none minWidth128 marginLeft10">
							<label>Branch</label>
							<select id="masterbranch" multiple="multiple" multi-select
                               		name="objMasterBranch"
                                	ng-model="filter.branchList"
                                	config="multipleConfig"
                                	data="masterdata.branch"
                                	ng-options="option.BranchCode as option.BranchName for option in masterdata.branch"
                                	ng-change="onBranchChange()">
                        	</select>
						</div>
						<div class="col-md-2 padding_none minWidth128 marginLeft10">
							<label>Emp. Name</label>
							<select id="masterbranch" multiple="multiple" multi-select
                               		name="objMasterEmployee"
                                	ng-model="filter.employeeCode"
                                	config="multipleConfig"
                                	data="masterdata.employee"
                                	ng-options="option.EmployeeCode as ('(' + option.Position + ') ' + option.FullNameTh) for option in masterdata.employee | orderBy: option.Position">
                        	</select>
						</div>
						
						<div class="col-md-2 padding_none minWidth128 marginLeft10">
							<label class="padding_none">App No / ID Card</label>
							<input ng-model="filter.applicationno" type="text" class="form-control">
						</div>
						<div class="col-md-2 padding_none minWidth128 marginLeft10">
							<label>Cust. Name</label>
							<input ng-model="filter.customer" type="text" class="form-control">
						</div>
						
					</div>
				</div>
				
				<div class="col-md-12 padding_none">
					<div class="form-group">
								
						<div class="col-md-2 padding_none minWidth128 marginTop10 marginLeft10">
							<label>Loan Type</label>
							<select id="masterloan_type" multiple="multiple" multi-select
                               	name="objMasterLoanType"
                                ng-model="filter.loanType"
                                config="multipleConfig"
                                data="masterdata.loan_type"
                                ng-options="option.LoanName as option.LoanName group by option.LoanType for option in masterdata.loan_type">
                        	</select>					
						</div>
						<div class="col-md-2 padding_none minWidth128 marginTop10 marginLeft10">
							<label>CA Decision</label>
							<select id="masterdecisionCA" multiple="multiple" multi-select
                               	name="objMasterDecisionCA"
                                ng-model="filter.decision"
                                config="multipleConfig"
                                data="masterdata.decisionca"
                                ng-options="option.DecisionName as option.DecisionName for option in masterdata.decisionca">
                        	</select>
						</div>
						
						<div class="col-md-2 padding_none minWidth128 marginTop10 marginLeft10 ">
							<label class="col-md-12 padding_none">Optional</label>
							<div class="padding_none">
								<select id="masterOptional" multiple="multiple" multi-select
		                           	name="objMasterOptional"
		                            ng-model="filter.optional"
		                            config="multipleConfig"
		                         	data="masterdata.optional"
		                            ng-options="option.FieldValue as option.FieldName group by option.GroupLabel for option in masterdata.optional">
								</select>
							</div>						
						</div>
						
						<div class="col-md-2 padding_none minWidth128 marginTop10 marginLeft10">
							<label class="col-md-12 padding_none">Oper. Filter</label>
							<div class="padding_none">
								<select id="masterOperOption" multiple="multiple" multi-select
		                           	name="objMasterOperOption"
		                            ng-model="filter.operOption"
		                            config="multipleConfig"
		                         	data="masterdata.oper_option"
		                            ng-options="option.FieldValue as option.FieldName group by option.GroupLabel for option in masterdata.oper_option">
								</select>
							</div>						
						</div>
						
						<div class="col-md-2 padding_none minWidth128 marginTop10 marginLeft10">
							<label class="padding_none" ng-class="{ 'label-disable' : filter.ddPlanVol || filter.operAcknowledge }">Oper. Decision</label>
							<select id="masterdecisionOper" multiple="multiple" multi-select
	                           	name="objMasterDecisionOper"
	                            ng-model="filter.operdecision"
	                            config="multipleConfig"
	                         	data="masterdata.decisionop"
	                            ng-options="option.DecisionName as option.DecisionName for option in masterdata.decisionop">
	                        </select>
						</div>
						
					</div>
				</div>
				
				<div class="col-md-12 marginTop5 padding_none">
					<span class="pull-left marginTop15 marginLeftEasing15 padding_none">
	     				<div class="checkbox-inline fg-darkBlue"><b>Shortcut :</b></div>
						<div class="checkbox checkbox-primary checkbox-inline">
							<input ng-model="filter.ddPlanVol" ng-disabled="filter.operAcknowledge" type="checkbox" value="Y">
							<label class="fg-darkBlue">DDP Remaining</label>
						</div>
						<div class="checkbox checkbox-primary checkbox-inline tooltip-top" data-tooltip="แสดงเฉพาะข้อมูลที่ทาง Oper ยังไม่ได้ยืนยันสถานะการรับทราบ" style="margin-left: 22px;">
							<input ng-model="filter.operAcknowledge" ng-disabled="filter.ddPlanVol" type="checkbox" value="Y">
							<label class="fg-darkBlue">Oper Acknowledge Flash</label>
						</div>
                    </span>
			
					<div class="pull-right marginTop10 paddingRight5">
						<button type="button" class="btn bg-lightBlue fg-white text-uppercase" ng-click="filterSearch()"><i class="icon-search on-left"></i> Search</button>
  						<button type="button" class="btn bg-green fg-white text-uppercase" ng-click="filterClear()">Clear</button>
					</div>
					
					<span class="pull-left marginLeftEasing15 padding_none">
						<!-- 
						<div class="checkbox checkbox-primary checkbox-inline">
							<input ng-model="filter.flagrecieveFile" type="checkbox" value="Y">
							<label class="fg-darkBlue">รับแฟ้มจาก CA</label>
						</div>
						 -->
						<div class="checkbox-inline fg-darkBlue" style="width: 71px;"></div>
						<div class="checkbox checkbox-primary checkbox-inline" style="margin-left: 20px;">
							<input ng-model="filter.ownershipBuilding" type="checkbox" value="Y">
							<label class="fg-darkBlue">หนังสือรับรองกรรมสิทธิ์สิ่งปลูกสร้าง</label>
						</div>
                    </span>
             				
				</div>
				
			</div>
		</div>
	</div>
	
	<span class="pagingation_info marginTopEasing10">{{ paging_info || '&nbsp;' }}</span>
	<ng-jq-grid config="config" jqgrid-group-header="thead_group" jqgrid-freeze-column="true" jqgrid-footer-enabled="true" sort-order="sortOrder" paging-info="paging_info" grand-total-footer="totalCRLINE"></ng-jq-grid>
	
	<!-- Missing Modal -->
	<script id="modalMissing.html" type="text/ng-template">
	<div class="modal-header text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">Missng Doc. Information</h4>
	</div>
	<div class="modal-body paddingLeft25 paddingRight25">
		 <table class="table table-bordered">
	     	<thead>
				<tr>
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
	
	<!-- Information Modal -->
	<script id="modalCollection.html" type="text/ng-template">
	<div class="text-left" ng-class="{ 'hide' : DataList.ApplicationNo && DataList.ApplicationNo !== '' }">
		<div class="progress progress_icon animated fadeIn">
			<img src="<?php echo base_url('img/378_1.gif'); ?>">
		</div>
		<div class="progress blackboard"></div>
	</div>

	<div class="modal-header text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">

		<div class="btn-toolbar pull-right" role="toolbar">
			<?php if(!empty($user_role) && !in_array($user_role, array('adminbr_role'))) { ?>
				<i class="fa fa-edit" ng-class="{ 'fa fa-eye modal-icon' : isEdit, 'fa fa-edit modal-icon' : !isEdit }" ng-click="modalEditMode()"></i>
			<?php } ?>	
			<i class="ti-id-badge modal-icon" ng-if="role_auth.menu_icon.oper_report" ng-click="renderDataReport(DataList.ApplicationNo)"></i>
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		
		<h4 id="modalLabel" class="modal-title">Drawdown Information</h4>
	</div>
	<div class="modal-body paddingLeft25 paddingRight25" ng-class="{ 'mb-overflow-show' : isEdit, 'mb-overflow-hide' : !isEdit }">
		<div class="panel_preview" ng-class="{ 'animated':isLoadComplete, 'fadeOutLeft': isEdit , 'fadeInLeft' : !isEdit }">
		<div class="row marginTopEasing10">

			<div class="panel panel-{{ label_bg[0].substr(3) }}" style="border-left: 0; border-right: 0;">
				<div id="information_parent" class="panel-heading text-uppercase {{ label_bg[0] }} {{ font_color }}" ng-click="collapsePanel('information_parent')">
					<h5 class="panel-title">Information</h5>
					<span class="pull-right clickable"><i class="fa fa-chevron-circle-up"></i></span>
				</div>
				<div class="panel-body hide">

					<div class="col-md-12 marginTopEasing15 marginBottomEasing10">
						<div class="col-md-4 fg-darkBlue text-uppercase paddingTB5"><h5><strong>Customer</strong></h5></div>
						<div class="col-md-4 fg-darkBlue text-uppercase paddingTB5">
							<h5>
								<strong>Lending Branch</strong>
								<span> ({{ DataList.RegionNameEng }}) </span>
							</h5>
						</div>
						<div class="col-md-4 fg-darkBlue text-uppercase paddingTB5"><h5><strong>Credit Analyst</strong></h5></div>
					</div>

					<!-- Area Of Loan Information -->		
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Application No</div>
							<div class="col-md-8 paddingTB5 paddingLR_none" style="max-height: 27px;">
								{{ DataList.ApplicationNo }}
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Branch Name</div>
							<div class="col-md-8 paddingTB5 paddingLR_none text-uppercase">
								{{ DataList.Branch }}
								<span ng-if="DataList.RMMobile != ''"> ({{ DataList.BranchTel || '&nbsp;' }})</span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">A2CA Date</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">{{ DataList._A2CADate.split(' ')[0] | date:"dd/MM/yyyy" }}</div>
						</div>

						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Customer Name</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								<span class="text_bold">{{ DataList.CustName }}</span>
								<span ng-if="DataList.CustType != ''"> ({{ DataList.CustType }})</span>
								
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">RM Name</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								<span class="text_bold">{{ DataList.RMName }}</span>
								<span ng-if="DataList.RMMobile != ''"> ({{ DataList.RMMobile || '&nbsp;' }})</span>
					 		</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">CA Name</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">{{ DataList.CAName }}</div>
						</div>

						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">ID Card</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">{{ DataList.CitizenID }}</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">BM Name</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								{{ DataList.BM_Name }} 
								<span ng-if="DataList.BM_Mobile != ''"> ({{ DataList.BM_Mobile || '&nbsp;' }})</span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Approver Name</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">{{ DataList.ApproverName }}</div>
						</div>

						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Phone</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								<span phone-formatter>{{ DataList.CustMobile }}</span> 
								<span ng-if="DataList.CustTel != ''"> / <span phone-formatter>{{ DataList.CustTel || '&nbsp;'  }}</span></span>
							</div>
						</div>

						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Area Manager</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								{{ DataList.AM_Name }} 
								<span ng-if="DataList.AM_Mobile != ''"> ({{ DataList.AM_Mobile || '&nbsp;' }})</span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text-capitalize text_bold">App Status</div>
							<div class="col-md-8 paddingTB5 paddingLR_none text-capitalize text_bold">{{ DataList.Status }}</div>
						</div>

						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Product Program</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								{{ DataList.ProductType || '&nbsp;' }}
								<span ng-if="DataList.ProductType == 'Clean'" class="bg-darkCyan fg-white" style="padding: 3px 10px; margin-left: 15px; font-size: 12px;">Attach Contract</span>	
								<span ng-if="DataList.ProductType == 'Clean' && DataList.ContactFileDetail || ContactFileItem.FileStatus == 'C'" ng-click="openLinkContactFile(DataList.ContactFileDetail, ContactFileItem)" ng-bind="FileContactStatus(DataList.ContactFileDetail, ContactFileItem.FileStatus, 'P')" ng-class="{ 'bg-green fg-white nav_icon' : DataList.ContactFileDetail || ContactFileItem.FileStatus == 'C' }" style="padding: 3px 10px; margin-left: -5px; font-size: 12px;"></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Regional Director</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								{{ DataList.RD_Name }} 
								<span ng-if="DataList.RD_Mobile != ''"> ({{ DataList.RD_Mobile || '&nbsp;' }})</span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Decision Date</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">{{ datetime(DataList._DecisionDate) }}</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Request Doc Date</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								<span>{{ DataList._RequstDOCDate.split(' ')[0] | date:"dd/MM/yyyy" || '&nbsp;' }}</span>
								<span ng-if="DataList._RequstDOCDate != ''" class="nav_icon marginLeft10" ng-click="modalMissingEnabledValid(DataList.DocID, DataList.MissingDoc)">
									<span class="icon-copy fg-steel" style="font-size: 1em;"></span>
									<span class="badge bg-amber" style="font-size: 0.8em; position: absolute; margin-top: -7px; margin-left: -10px;">{{ DataList.MissingDoc }}</span>
								</span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Defend Name</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								{{ DataList.DefendEmpName || '&nbsp;' }}
								<span ng-if="DataList.DefendMobile != ''"> ({{ DataList.DefendMobile || '&nbsp;' }})</span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Approval Amt.</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">{{ DataList.ApprovedLoan | number:0 || '&nbsp;' }}</div>
						</div>

					</div>

					<!-- Area Of Asessment -->
					<div class="col-md-12">
						<div class="col-md-4 text-uppercase paddingTB5">
							<div class="col-md-4 paddingLR_none fg-darkBlue text-uppercase">
								<h5 style="float: left;"><strong>LTV = {{ DataList.LTV }}</strong></h5>
							</div>
							<div class="col-md-8 paddingTop10 paddingLR_none">
								<div class="col-md-4  text_bold paddingLR_none">
									<span class="text_bold">KYC</span> 
									<span>({{ (DataList.KYC == 'Y') ? DataList.KYC:'N'; }})</span>
								</div>
								<div class="col-md-8 text_bold paddingLR_none">
									<span class="text_bold">Cashy</span>
									<span>({{ (DataList.Cashy == 'Y') ? DataList.Cashy:'N'; }}) </span>
									<span ng-if="DataList.CashyAmt > 0">{{ DataList.CashyAmt | number: 0 || '&nbsp;' }}</span>
								</div>
							</div>
						</div>
						<div class="col-md-4 fg-darkBlue paddingTB5 text-uppercase" style="display: inline;">
							<h5 style="float: left;"><strong>Achievement Score = {{ DataList.EndScore || '&nbsp;' }} <span class="marginLeft5">(S1 = {{ DataList.Score || '&nbsp;' }})</span></strong></h5>
							
							<span ng-if="!insurance_data" class="place-right" style="margin-left: 20px; height: 30px;">
								<img src="<?php echo base_url('img/insurance-icon-man.png'); ?>" class="nav_icon" ng-class="{ 'binding2' : !insurance_data }"  style="height:30px; max-height: 25px; margin-top: 0px;">
							</span>	

							<span ng-if="insurance_data" webui-popover data="insurance_content" config="webuiInsuranceConfig" class="place-right" style="margin-left: 20px; height: 30px;">
								<img src="<?php echo base_url('img/insurance-icon-man.png'); ?>" class="nav_icon" style="height:30px; max-height: 25px; margin-top: 0px;">
							</span>	

							<a ng-if="DataList.FlagComfPaid == 'Y'" href="http://172.17.9.94/newservices/LBServices.svc/ddtemplate/report/loansummary/{{ DataList.ApplicationNo }}" target="_blank">
								<span class="place-right tooltip-right" data-tooltip="{{ (DataList.FlagComfPaid == 'Y') ? 'Oper ยืนยันการสั่งจ่ายเรียบร้อย (คลิกเพื่อดูรายละเอียด)':'ไม่พบข้อมูลการสั่งจ่าย' }}">
									<img src="<?php echo base_url('img/approved_money.png'); ?>" class="nav_icon" style="height:30px; max-height: 20px; margin-left: 5px; margin-top: 0px;">
								</span>
							</a>

							<span ng-if="DataList.FlagComfPaid !== 'Y'" class="place-right tooltip-right" data-tooltip="{{ (DataList.FlagComfPaid == 'Y') ? 'Oper ยืนยันการสั่งจ่ายเรียบร้อย  (คลิกเพื่อดูรายละเอียด)':'ไม่พบข้อมูลการสั่งจ่าย' }}">
								<img src="<?php echo base_url('img/approved_money.png'); ?>" class="nav_icon" ng-class="{ 'binding2' : DataList.FlagComfPaid !== 'Y' }" style="height:30px; max-height: 20px; margin-left: 5px; margin-top: 0px;">
							</span>

						</div>
						<div class="col-md-4 fg-darkBlue paddingTB5">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold"><h5><strong>รับแฟ้มจาก CA</strong></h5></div>
							<div class="col-md-8 paddingTB5 paddingLR_none" style="margin-top: 8px;">
								<span ng-if="DataList._RecieveFileDateTime">{{ datetime(DataList._RecieveFileDateTime) }}</span>
								<span ng-if="!DataList._RecieveFileDateTime" style="padding: 0px 53px;">&nbsp;</span>
								<i ng-if="operation_history" id="OperationHistory" webui-popover data="operation_history" config="webuiConfig" class="fa fa-history pull-right" style="font-size: 1.3em !important; color: #000; margin-left: 20px; cursor: pointer; position: absolute; top: 4px;"></i>
							</div>
						</div>
					</div>
					<div class="col-md-12 marginTopEasing10">
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">เงือนไขการจ่ายเงิน</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								{{ DataList.PaymentType || 'ไม่ระบุ' }} 
								<span ng-if="DataList.BookBankNo && DataList.BookBankNo !== ''"> 
									<span class="text_bold tooltip-right" data-tooltip="หมายเลขบัญชี ">| BB. No</span> 
									{{ DataList.BookBankNo }}
								</span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 text_bold paddingLR_none {{ label_bg[label_zone] }} {{ font_color }}">วันที่วางแผน DD</div>
							<div class="col-md-7 paddingLR_none">
								<div class="paddingTB5 {{ label_bg[label_zone] }} {{ font_color }}" style="width: 190px; height: 28px;">
									{{ DataList._PlanDrawdownDate.split(' ')[0] | date: 'dd/MM/yyyy' || '&nbsp;' }}
								</div>
							</div>
							<i ng-if="plandrawdown_log" id="ddPlanHistory" webui-popover data="plandrawdown_log" config="webuiConfig" class="fa fa-history pull-right" style="font-size: 1.3em !important; cursor: pointer; position: absolute; top: 4px; margin-left: -25px;"></i>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">สถานะจดจำนอง</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								<div ng-class="{ 'bg-red fg-white nav_icon' : DataList.AppraisalStatus == 'Cancel', 'bg-thinTeal fg-white text_bold nav_icon' : DataList.AppraisalStatus == 'Postpone', 'bg-thinTeal fg-white text_bold nav_icon' : DataList.AppraisalStatus == 'Re-Process' }" style="padding: 3px 7px; margin-top: -6px; max-width: 120px;  font-size: 1em;">{{ DataList.AppraisalStatus || '&nbsp;' }}</div>
								<i ng-if="appraisal_log" id="appraisalListHistory" webui-popover data="appraisal_log" config="webuiConfig" class="fa fa-history pull-right" class="fa fa-history pull-right" style="font-size: 1.3em !important; cursor: pointer; position: absolute; top: 4px; left: 125px;"></i>
							</div>
						</div>

						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">สั่งจ่ายเงินกู้คงเหลือ</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								<div class="col-md-3 paddingLR_none">{{ setBorrowerNameLabel(DataList.BorrowerType) }}</div>
								<div class="col-md-9 paddingLR_none" compile-html="truncateText(DataList.BorrowerName)"></div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 {{ label_bg[label_zone] }} {{ font_color }} text_bold paddingLR_none">วงเงินสินเชื่อที่รับจริง</div>
							<div class="col-md-8 paddingLR_none">
								<div ng-if="DataList.TotalNetAmt >= 1" class="paddingTB5 {{ label_bg[label_zone] }} {{ font_color }}" style="width: 190px; height: 28px;">
									{{ DataList.TotalNetAmt | number:2 || '&nbsp;' }}
								</div>
								<div ng-if="DataList.TotalNetAmt <= 0" class="paddingTB5 {{ label_bg[label_zone] }} {{ font_color }}" style="width: 190px; height: 28px;"></div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Updated Name</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">{{ DataList.UpdateByEmpName }}</div>
						</div>
			
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold" style="font-size: 95%;">วิธีชำระ/ธนาคาร/วงเงิน</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">
								<span class="paddingLR_none">{{ DataList.BorrowerPayType }}</span>
								<span ng-if="DataList.BorrowerBank" class="paddingLR_none">| {{ DataList.BorrowerBank }}<span>
								<span class="paddingLR_none">
									<span ng-if="DataList.BorrowerAmount > 0">| {{ DataList.BorrowerAmount | number:2 || '&nbsp;' }}</span>
									<span ng-if="!DataList.BorrowerAmount <= 0">&nbsp;</span>
								</span>
							</div>
						</div> 

						<div class="col-md-4 ">
							<div class="col-md-4 {{ label_bg[label_zone] }} {{ font_color }} paddingTB5 text_bold paddingLR_none">สำเร็จตามแผน</div>
							<div class="col-md-8 paddingLR_none">
								<div class="paddingTB5 {{ label_bg[label_zone] }} {{ font_color }}" style="width: 190px; height: 28px;" on-bind="">
									{{ setCaseStatusText(DataList.Complete) }}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-4 paddingTB5 paddingLR_none text_bold">Latest Updated</div>
							<div class="col-md-8 paddingTB5 paddingLR_none">{{ datetime(DataList._UpdateDate) }}</div>
						</div>

						<div class="col-md-12">
							<div class="col-md-4 paddingLR_none">
								<!--<div class="col-md-4 paddingLR_none text_bold paddingTB5">Book bank</div>-->
								<div class="col-md-8 paddingLR_none paddingTB5">
									<div class="col-md-12 padding_none">
										<span ng-if="DataList.BookBankFlag == 'Y'" class="bg-darkCyan fg-white" style="padding: 3px 10px; margin-left: -5px; font-size: 12px;">Attach Book bank</span>	
										<span ng-if="DataList.BookBankFlag == 'Y'" style="padding: 3px 10px; margin-left: -5px; font-size: 12px;" ng-click="openLinkBookbankFile(DataList.BookBankFileDetail, FileBookBank)"  ng-class="{ 'bg-red fg-white nav_icon icon_blink' : DataList.BookBankStatus == 'I', 'bg-green fg-white nav_icon' : DataList.BookBankStatus == 'C', 'bg-yellow fg-white nav_icon' : DataList.BookBankStatus == 'W' }" compile-html="getFileStatus(DataList.BookBankStatus)"></span>
										<span ng-if="DataList.BookBankFlag == 'Y' && DataList.BookBankStatus == 'W' && role_auth.callateral.FileChecker" class="text-center" style="margin-top: 2px !important;">
											<i ng-click="updateFileBookbankModule(DataList, 'C')" class="fa fa-check fg-green nav_icon" style="border: 1px solid #D1D1D1; border-radius: 2px; width: 21px; height: 21px; padding: 3px;"></i>
											<i ng-click="updateFileBookbankModule(DataList, 'I')" class="fa fa-close fg-red nav_icon" style="border: 1px solid #D1D1D1; border-radius: 2px; width: 21px; height: 21px; padding: 3px;"></i>
										</span>
									</div>									
								</div>
							</div> 
							<div class="col-md-4 paddingLR_none">
								<div class="col-md-6 paddingLR_none">
									<div class="col-md-9 paddingLeft10 text_bold">ขอลดค่าธรรมเนียม</div>
									<div class="col-md-2 paddingLR_none">{{ (DataList.DiscountFee && DataList.DiscountFee == 1) ? 'Yes':'No'  || '&nbsp;' }}</div>
								</div>
								<div class="col-md-6 paddingLR_none">
									<div class="col-md-6 paddingLR_none text_bold">ขอลดดอกเบี้ย</div>
									<div class="col-md-2 paddingLR_none">{{ (DataList.DiscountInterest && DataList.DiscountInterest == 1) ? 'Yes':'No' || '&nbsp;' }}</div>
								</div>
							</div> 
							<div class="col-md-4 paddingLR_none"></div> 
						</div>

					</div>
			
				</div>
			</div>
		</div>

		<div id="parent_thirdPerson" class="panel panel-lightBlue table-collapsed marginTopEasing10" style="margin-left: -15px; margin-right: -15px; border-left: 0; border-right: 0;" ng-class="{ 'animated':isLoadComplete, 'fadeOutLeft': isEdit , 'fadeInLeft' : !isEdit }">
			<div id="third_person_parent" class="panel-heading text-uppercase {{ label_bg[0] }} {{ font_color }}" ng-click="collapsePanel('third_person_parent')">
				<h5 class="panel-title">Pay to partners information</h5>
				<span class="pull-right clickable"><i class="fa fa-chevron-circle-up"></i></span>
			</div>
			<div class="panel-body padding_none">
				<div class="nonprint">
					<table class="table table-bordered label_bg[0]">
						<thead>
							<tr>	
	      						<th width="10%" style="background-color: #00ABA9 !important;">ON BEHALF OF</th>      	 			
	      						<th width="18%" style="background-color: #00ABA9 !important;">NAME</th> 
								<th width="12%" style="background-color: #00ABA9 !important;">PAY TYPE</th>   	 	
	      						<th width="12%" style="background-color: #00ABA9 !important;">BANK</th>
								<th width="12%" style="background-color: #00ABA9 !important;">AMOUNT</th>
								<th width="14%" style="background-color: #00ABA9 !important;">BOOKBANK NO</th>
								<th width="28%" style="background-color: #00ABA9 !important;">FILE ATTACHED</th>	 					      	 				
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="partners in Partners track by $index">	    
								<td class="text-center">{{ partners.OnbehalfType }}</td>
								<td>{{ partners.PayeeName  }}</td>
								<td class="text-center">{{ partners.PayType }}</td> 
								<td class="text-center">{{ partners.Bank  }}</td>
								<td class="text-right">
									<span ng-if="partners.PayAmount > 0">{{ partners.PayAmount | number: 2 }}</span>
									<span ng-if="partners.PayAmount <= 0">&nbsp;</span>
								</td>
								<td class="text-center">{{ partners.BookBankNo }}</td>
								<td style="padding-left: 45px;">
									<span ng-if="partners.PatchFlag == 'Y'" class="bg-darkCyan fg-white" style="padding: 3px 10px; margin-left: -5px; font-size: 12px;">Attach Book bank</span>	
									<span ng-if="partners.PatchFlag == 'Y'" style="padding: 3px 10px; margin-left: -5px; font-size: 12px;" ng-click="openLinkPartnerFile(partners.BookBankFileDetail, partners.BookBankFile)" ng-class="{ 'bg-red fg-white nav_icon icon_blink' : partners.PatchStatus == 'I', 'bg-green fg-white nav_icon' : partners.PatchStatus == 'C', 'bg-yellow fg-white nav_icon' : partners.PatchStatus == 'W' }" compile-html="getFileStatus(partners.PatchStatus)"></span>
									<span ng-if="partners.PatchFlag == 'Y' && partners.PatchStatus == 'W' && partners.BookBankFileDetail" class="text-center" style="margin-top: 2px !important;" ng-class="{ 'hide' : !role_auth.partners.PatchValid }">
										<i ng-click="savePartnersModule(partners, 'C')" class="fa fa-check fg-green nav_icon" style="border: 1px solid #D1D1D1; border-radius: 2px; width: 21px; height: 21px; padding: 3px;"></i>
										<i ng-click="savePartnersModule(partners, 'I')" class="fa fa-close fg-red nav_icon" style="border: 1px solid #D1D1D1; border-radius: 2px; width: 21px; height: 21px; padding: 3px;"></i>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div id="parent_tableHistory" class="panel panel-lightBlue table-collapsed marginTopEasing10" style="margin-left: -15px; margin-right: -15px; border-left: 0; border-right: 0;" ng-class="{ 'animated':isLoadComplete, 'fadeOutLeft': isEdit , 'fadeInLeft' : !isEdit }">
			<div id="note_parent" class="panel-heading text-uppercase {{ label_bg[5] }} {{ font_color }}" ng-click="collapsePanel('note_parent')">
				<h5 class="panel-title">Note Information</h5>
				<span class="pull-right clickable"><i class="fa fa-chevron-circle-up"></i></span>
			</div>
			<div class="panel-body padding_none">
				<div class="nonprint">
					<table class="table table-bordered">
						<thead>
							<tr>	
	      						<th width="10%">DATE</th>      	 			
	      						<th width="20%">NAME</th> 
								<th width="20%">FUNCTION</th>   	 	
	      						<th width="50%">NOTE DETAILS</th>   	 					      	 				
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="list in NoteList | orderBy:'-_UpdateDate' track by $index">
								<td>{{ list._UpdateDate || list.UpdateDate | ddDate:"dd/MM/yyyy (HH:mm)"  }}</td>
								<td>{{ list.UpdateByEmpName || '' }}</td>
								<td class="text-center">{{ list.Team || '' }}</td>
								<td>{{ list.Note || '' }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="row marginTopEasing10" ng-class="{ 'animated':isLoadComplete, 'fadeOutLeft': isEdit , 'fadeInLeft' : !isEdit }">

			<div class="panel panel-{{ label_bg[2].substr(3) }}" style="border-left: 0; border-right: 0;">
				<div id="security_parent" class="panel-heading text-uppercase {{ label_bg[2] }} {{ font_color }}" ng-click="collapsePanel('security_parent')">
					<h5 class="panel-title">Collateral Information</h5>
					<span class="pull-right clickable"><i class="fa fa-chevron-circle-up"></i></span>
				</div>
				<div class="panel-body hide">
	
					<div class="col-md-12  marginTopEasing5">
	
						<div ng-if="isBinding || item.IsVisible == 'A'" class="col-md-4 collectionitem_parent collectionitem_preview_{{ $index+1 }} paddingLR_none" ng-repeat="item in Collateral track by $index">
							<div class="col-md-12">
								<div class="col-md-5 paddingLR_none text_bold paddingTB5">
									เลขที่ส่งงานประเมิน 
									<span ng-if="item.CollateralBy == 'System'">{{ (item.CollateralBy == 'System') ? '(S)':'(M)' }}</span>
								</div>
								<div class="col-md-7 paddingLR_none paddingTB5 text_bold">
									<div class="col-md-4 paddingLR_none">{{ item.RefNo }}</div>
									<div ng-if="item.BoardName" class="col-md-8 paddingLR_none">
										<div ng-if="item.Description" class="tooltopl-top" data-tooltip="{{ item.Description }}">{{ item.BoardName }} ({{ item.BoardCommitteeNo }})</div> 
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-5 paddingLR_none text_bold paddingTB5">หลักทรัพย์ที่  {{ $index+1 }}</div>
								<div class="col-md-7 paddingLR_none paddingTB5">{{ item.CollateralType }}</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-5 paddingLR_none text_bold paddingTB5">นส.รับรองสิทธิ์สิ่งปลูกสร้าง</div>
								<div class="col-md-7 paddingLR_none paddingTB5">
									<div class="col-md-12 padding_none">
										<span ng-class="{ 'bg-green fg-white text_bold nav_icon' : item.OwnershipBuilding == 'Y' }" ng-bind="setDataChoice(item.OwnershipBuilding)" style="padding: 3px 7px; font-size: 12px;" ng-click="modalOwnershipFileEnabled(DataList.ApplicationNo, item.OwnershipBuilding);"></span>
										<span ng-if="item.OwnershipBuilding == 'Y'" class="bg-darkCyan fg-white" style="padding: 3px 10px; margin-left: -5px; font-size: 12px;">File Attached</span>	
										<span ng-if="item.OwnershipBuilding == 'Y'" style="padding: 3px 10px; margin-left: -5px; font-size: 12px;" ng-click="openLinkPdfFile(item)"  ng-class="{ 'bg-red fg-white nav_icon icon_blink' : item.FileStatus == 'I', 'bg-green fg-white nav_icon' : item.FileStatus == 'C', 'bg-yellow fg-white nav_icon' : item.FileStatus == 'W' }" compile-html="getFileStatus(item.FileStatus)"></span>
										<span ng-if="item.OwnershipBuilding == 'Y' && item.FileStatus == 'W' && role_auth.callateral.FileChecker" class="text-center" style="margin-top: 2px !important;">
											<i ng-click="saveCustomerInfoModule(item, 'C')" class="fa fa-check fg-green nav_icon" style="border: 1px solid #D1D1D1; border-radius: 2px; width: 21px; height: 21px; padding: 3px;"></i>
											<i ng-click="saveCustomerInfoModule(item, 'I')" class="fa fa-close fg-red nav_icon" style="border: 1px solid #D1D1D1; border-radius: 2px; width: 21px; height: 21px; padding: 3px;"></i>
										</span>
									</div>									
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-5 paddingLR_none text_bold paddingTB5">สถานะการประเมิน</div>
								<div class="col-md-7 paddingLR_none paddingTB5 text_bold">{{ item.AssetStatus }}</div>
							</div>
														
							<div class="col-md-12">
								<div class="col-md-5 paddingLR_none text_bold paddingTB5">มูลค่าหลักทรัพย์</div>
								<div ng-if="item.ApproveValue > 0" class="col-md-7 paddingLR_none paddingTB5">{{ item.ApproveValue | number:2 || '&nbsp;' }}</div>
								<div ng-if="item.ApproveValue <= 0" class="col-md-7 paddingLR_none paddingTB5">&nbsp;</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-5 paddingLR_none text_bold paddingTB5">สถานที่ตั้งหลักทรัพย์</div>
								<div ng-if="item.Tambol" class="col-md-7 paddingLR_none paddingTB5">
									ต.{{ item.Tambol }} อ.{{ item.Amphur }} จ.{{ item.Province }}
								</div>
								<div ng-if="!item.Tambol" class="col-md-7 paddingLR_none paddingTB5">&nbsp;</div>
							</div>	
				
							<div class="col-md-12 paddingLR_none" style="border: 1px solid #81003C;">
								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5">สนง.เขตที่ดินจดจำนอง</div>
									<div class="col-md-7 paddingLR_none paddingTB5">{{ (item.AgencyMortgage) ? item.AgencyMortgage.replace('สำนักงานที่ดิน', ''):'' }}</div>
								</div>		
								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5">ผู้รับมอบจดจำนอง</div>
									<div class="col-md-7 paddingLR_none paddingTB5">{{ item.PaymentChannel }}</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-5 paddingLR_none text_bold paddingTB5">สถานะหลักทรัพย์</div>
								<div class="col-md-7 paddingLR_none paddingTB5">
									<span class="paddingLR_none">{{ item.CollateralStatus }}</span>
									<span class="paddingLR_none" ng-if="item.CollateralStatus == 'Refinance' && item.Bank">, {{ item.Bank }}</span>
									<span class="paddingLR_none" ng-if="item.CollateralStatus == 'Other'">: {{ item.OrtherNote }}</span>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-5 paddingLR_none text_bold paddingTB5">วิธีชำระ/ธนาคาร/วงเงิน</div>
								<div class="col-md-7 paddingLR_none paddingTB5">
									<span class="paddingLR_none">{{ item.PayType || '&nbsp;' }}</span>
									<span ng-if="item.BankPayType" class="paddingLR_none">| {{ item.BankPayType }}</span>
									<span ng-if="item.Refinance" class="paddingLR_none">
										<span ng-if="item.Refinance > 0">| {{ item.Refinance | number:2 || '&nbsp;' }}</span>
										<span ng-if="item.Refinance <= 0">&nbsp;</span>
									</span>
									<i ng-if="item.collateral_log" id="refinanceHistory" webui-popover data="item.collateral_log" config="webuiConfig" class="fa fa-history pull-right" style="font-size: 1.3em !important; color: #000; margin-left: 20px; cursor: pointer; position: absolute; top: 4px;"></i>
								</div>
							</div>
							
							<div class="col-md-12">
								<div class="col-md-5 paddingLR_none text_bold paddingTB5">คชจ.การจดจำนอง</div>
								<div class="col-md-7 paddingLR_none paddingTB5">
							
									<span ng-if="item.PayType2 == 'Cash'" class="paddingLR_none fg-red">
										ลูกค้าสำรองเงินค่าจดจำนองเอง
										<span ng-if="item.Amount2 > 0">{{ item.Amount2 | number:2 || '&nbsp;' }} บาท</span>
									</span>

									<span ng-if="item.PayType2 !== 'Cash'" class="paddingLR_none">{{ item.PayType2 || '&nbsp;' }}</span>
									<span ng-if="item.PayType2 !== 'Cash' && item.Bank2" class="paddingLR_none">| {{ item.Bank2 || '&nbsp;' }}</span>
									<span ng-if="item.PayType2 !== 'Cash' && item.Amount2" class="paddingLR_none">
										<span ng-if="item.Amount2 > 0">| {{ item.Amount2 | number:2 || '&nbsp;' }}</span>
										<span ng-if="item.Amount2 <= 0">&nbsp;</span>
									</span>
								
								</div>
							</div>

							<div class="col-md-12">
								<div class="col-md-5 paddingLR_none text_bold paddingTB5">คชจ.อื่นๆ</div>
								<div class="col-md-7 paddingLR_none paddingTB5">
									<span ng-if="item.PayType3" class="paddingLR_none">{{ item.PayType3 || '&nbsp;' }}</span>
									<span ng-if="item.Bank3" class="paddingLR_none">| <span class="paddingLR_none">{{ item.Bank3 }}</span></span>
									<span ng-if="item.Amount3" class="paddingLR_none">
										<span ng-if="item.Amount3 > 0">| {{ item.Amount3 | number:2 || '&nbsp;' }}</span>
										<span ng-if="item.Amount3 <= 0">&nbsp;</span>
									</span>
								</div>
							</div>

							<div class="col-md-12 divider_preview" ng-repeat="compagign in item.CampaignData">
								<div class="col-md-5 paddingLR_none text_bold paddingTB5">Campaign</div>
								<div class="col-md-7 paddingLR_none paddingTB5">
									<span ng-if="compagign.CampaignCode">{{ compagign.CampaignCode.substring(0, 2) }}</span>
									<span ng-if="compagign.PayType">| {{ compagign.PayType }}</span>
									<span ng-if="compagign.Bank">| {{ compagign.Bank }}</span>
									<span ng-if="compagign.Amount">| {{ compagign.Amount | number:2 || '&nbsp;'  }}</span>
								</div>								
							</div>

						</div>
						</div>
				
					</div>
					
				</div>
			</div>
		</div>

      	</div>


		<!-- #Edit Mode# -->

		<div class="modalEditMode marginTop55 paddingLeft10 paddingRight10 animated" ng-class="{'hidden' : !isLoadComplete, 'fadeInRight left-0': isEdit , 'fadeOutRight' : !isEdit}">

			<div class="marginTop5">
				<div class="panel panel-{{ label_bg[0].substr(3) }}" style="border-left: 0; border-right: 0;">
					<div id="information_edit_parent" class="panel-heading text-uppercase {{ label_bg[0] }} {{ font_color }}" ng-click="collapsePanel('information_edit_parent')">
						<h5 class="panel-title">Information</h5>
						<span class="pull-right clickable"><i class="fa fa-chevron-circle-up"></i></span>
					</div>
					<div class="panel-body">

						<div class="col-md-12 marginTopEasing15 marginBottomEasing10">
							<div class="col-md-4 fg-darkBlue text-uppercase paddingTB5"><h5><strong>Customer</strong></h5></div>
							<div class="col-md-4 fg-darkBlue text-uppercase paddingTB5"><h5><strong>Lending Branch ({{ DataList.RegionNameEng }}) </strong></h5></div>
							<div class="col-md-4 fg-darkBlue text-uppercase paddingTB5"><h5><strong>Credit Analyst</strong></h5></div>
						</div>
						
						<!-- Area Of Loan Information -->		
						<div class="col-md-12">
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Application No</div>
								<div class="col-md-8 paddingTB5 paddingLR_none" style="max-height: 27px;">
									<input ng-model="DataList.ApplicationNo" class="form-control" readonly="readonly">
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Branch Name</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList.Branch" class="form-control" readonly="readonly">
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">A2CA Date</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList._A2CADate" date="dd/MM/yyyy" class="form-control" readonly="readonly">
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold" ng-class="{ 'fg-red' : role_auth.information.CustType }">Customer Name</div>
								<div class="col-md-8 paddingTB5 paddingLR_none" style="max-height: 44px;">
									<div class="form_group col-md-4	padding_none">
										<select class="form-control" ng-model="DataList.CustType" ng-disabled="!role_auth.information.CustType" style="padding-left: 6px !important;">
											<option value=" ">โปรดระบุ</option>
  											<option value="Old">ลค.เก่า</option>
											<option value="New">ลค.ใหม่</option>
										</select>
									</div>
									<div class="form-group col-md-8 padding_none">
										<input ng-model="DataList.CustName" class="form-control" readonly="readonly">
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Branch Tel.</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList.BranchTel" class="form-control" readonly="readonly">
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">CA Name</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList.CAName" class="form-control" readonly="readonly">
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">ID Card</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList.CitizenID" class="form-control" readonly="readonly">
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">RM Name</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList.RMName" class="form-control" readonly="readonly">
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Approver Name</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList.ApproverName" class="form-control" readonly="readonly">
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Mobile</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList.CustMobile" class="form-control" readonly="readonly">
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">RM Mobile</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList.RMMobile" class="form-control" readonly="readonly">
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">App Status</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList.Status" class="form-control text-capitalize" readonly="readonly">	
								</div>
							</div>

							<div class="col-md-4">
						
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Product Program</div>
								<div class="paddingTB5 paddingLR_none" ng-class="{ 'col-md-6' : DataList.ProductType == 'Clean', 'col-md-8' : DataList.ProductType == 'Secure' }">
									<input ng-model="DataList.ProductType" class="form-control" readonly="readonly">
								</div>

								<div ng-if="DataList.ProductType == 'Clean'" class="col-md-2 paddingTB5 paddingLR_none" ng-class="{ 'hide' : !role_auth.information.ContactFile  }">
									<label class="attach-file tooltip-top" data-tooltip="อัพโหลดไฟล์คอนแท็ค (Copy Contract)" for="attachContact">
										<span>
											<i class="fa fa-upload fg-red marginLeft10 marginRight5 marginTop5 nav_icon" ng-class="{ 'icon_blink ' : ContactFileItem.isUpLoading }" style="font-size: 1.4em;"></i>
											<input id="attachContact" type="file" type="file" class="nav_icon" dd-file-model="ContactFileItem.filePDFInput" dd-file-change="fileContactChange" accept="application/pdf">
										</span>	
									</label>
									<span class="attachstate nav_icon" ng-bind="FileContactStatus(DataList.ContactFileDetail, ContactFileItem.FileStatus)" ng-click="openLinkContactFile(DataList.ContactFileDetail, ContactFileItem)"></span>
								</div>

								<div ng-if="DataList.ProductType == 'Clean' && !role_auth.information.ContactFile" class="col-md-2 paddingTB5 paddingLR_none">
									<span class="fa-stack fa-md" style="margin-top: 4px; margin-left: 5px;">
  										<i class="fa fa-upload fa-stack-1x"></i>
  										<i class="fa fa-ban fa-stack-2x text-danger"></i>
									</span>
									<span ng-if="!role_auth.information.ContactFile" class="attachstate nav_icon" style="margin-top: 7px; float: right;" ng-bind="FileContactStatus(DataList.ContactFileDetail, ContactFileItem.FileStatus)" ng-click="openLinkContactFile(DataList.ContactFileDetail, ContactFileItem)"></span>
								</div>

							</div>

							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Defend Name</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList.DefendEmpName" class="form-control" readonly="readonly">
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Decision Date</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList._DecisionDate" date="dd/MM/yyyy (HH:mm)" class="form-control" readonly="readonly">
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Request Doc Date</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList._RequstDOCDate" date="dd/MM/yyyy" class="form-control" readonly="readonly">
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Defend Tel.</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList.DefendMobile" class="form-control" readonly="readonly">
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Approval Amt.</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input value="{{ DataList.ApprovedLoan | number:0 }}" class="form-control" readonly="readonly">
								</div>
							</div>

						</div>

						<!-- Area Of Asessment -->
						<div class="col-md-12">
							<div class="col-md-4 h44 text-uppercase paddingTB5">
								<div class="col-md-4 h44 paddingTB5 fg-darkBlue paddingLR_none text_bold">LTV = {{ DataList.LTV }}</div>
								<div class="col-md-8 h44 paddingTB5 paddingLeft20 paddingRight_none">
									<div class="col-md-3 paddingLR_none">
										<div class="checkbox checkbox-success checkbox-inline paddingLeft_none paddingTop5">
                        					<input type="checkbox" ng-model="DataList.KYC" ng-true-value="'Y'" ng-false-value="'N'" ng-disabled="!role_auth.information.KYC">
                        					<label ng-class="{ 'fg-red text_bold' : role_auth.information.KYC }">KYC</label>
                    					</div>
									</div>
									<div class="col-md-3 paddingLR_none">
										<div class="checkbox checkbox-success checkbox-inline paddingLeft_none paddingTop5 marginLeft20">
                        					<input ng-model="DataList.Cashy" ng-change="cashyHandled()" type="checkbox" ng-true-value="'Y'" ng-false-value="'N'" ng-disabled="!role_auth.information.Cashy">
                        					<label ng-class="{ 'fg-red text_bold' : role_auth.information.Cashy }">CASHY</label>
                    					</div>
									</div>
									<div ng-if="DataList.Cashy == 'Y'" class="col-md-3 paddingLR_none" ng-class="{ 'has-error' :DataList.validation.CashyAmount }" style="margin-top: -5px; margin-left: 20px; min-width: 100px;">
										<select ng-model="DataList.CashyAmt" ng-disabled="!role_auth.information.CashyAmt" class="form-control paddingLR_none">
											<option ng-repeat="option in masterdata.loan_cashy track by $index" value="{{ option.cashyValue }}">{{ option.CashyLabel }}</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-4 h44 fg-darkBlue paddingTB5 text-uppercase" style="display: inline;">
								<h5 style="float: left;"><strong>Achievement Score = {{ DataList.EndScore || '&nbsp;' }}  <span class="marginLeft5">(S1 = {{ DataList.Score || '&nbsp;' }})</span></strong></h5>
						
								<a ng-if="DataList.FlagComfPaid == 'Y'" href="http://172.17.9.94/newservices/LBServices.svc/ddtemplate/report/loansummary/{{ DataList.ApplicationNo }}" target="_blank">
									<span class="tooltip-right" data-tooltip="{{ (DataList.FlagComfPaid == 'Y') ? 'Oper ยืนยันการสั่งจ่ายเรียบร้อย':'ไม่พบข้อมูลการสั่งจ่าย' }}" style="float: right;">
										<img src="<?php echo base_url('img/approved_money.png'); ?>" class="nav_icon" style="height:30px; max-height: 20px; margin-top: 5px; float: right;">
									</span>
								</a>

								<span  ng-if="DataList.FlagComfPaid !== 'Y'" class="tooltip-right" data-tooltip="{{ (DataList.FlagComfPaid == 'Y') ? 'Oper ยืนยันการสั่งจ่ายเรียบร้อย':'ไม่พบข้อมูลการสั่งจ่าย' }}" style="float: right;">
									<img src="<?php echo base_url('img/approved_money.png'); ?>" class="nav_icon" ng-class="{ 'binding2' : DataList.FlagComfPaid !== 'Y' }" style="height:30px; max-height: 20px; margin-top: 5px; float: right;">
								</span>

								<span ng-if="!insurance_data" style="float: right;">
									<img src="<?php echo base_url('img/insurance-icon-man.png'); ?>" class="nav_icon" ng-class="{ 'binding2' : !insurance_data }" style="height:30px; max-height: 25px; margin-top: 0px; margin-right: 10px; float: right;">
								</span>

								<span ng-if="insurance_data" webui-popover data="insurance_content" config="webuiInsuranceConfig"  style="float: right;">
									<img src="<?php echo base_url('img/insurance-icon-man.png'); ?>" class="nav_icon" style="height:30px; max-height: 25px; margin-top: 0px; margin-right: 10px; float: right;">
								</span>

							</div>
							<div class="col-md-4 h44 fg-darkBlue paddingTB5">
								<div class="col-md-4 paddingTB5 paddingLR_none text_bold" ng-class="{ 'fg-red' : role_auth.information.RecieveFileDateTime }">
									<h5><strong>รับแฟ้มจาก CA</strong></h5>
								</div>
								<div class="col-md-8 h44 paddingTB5 padding_none">
									<div class="form_group col-md-1 marginLeftEasing10 marginTop10">
										<div class="checkbox checkbox-inline checkbox-success">
                        					<input type="checkbox" ng-model="DataList.FlagRecieveFile" ng-click="reciveFileFromCA(DataList)" ng-true-value="'Y'" ng-false-value="'N'" ng-disabled="!role_auth.information.RecieveFileDateTime">
											<label></label>
                    					</div>
									</div>
									<div class="form_group marginLeft30">
										<input class="form-control" readonly="readonly" ng-model="DataList._RecieveFileDateTime" date="dd/MM/yyyy (HH:mm)">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 marginTopEasing10">
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold" ng-class="{ 'fg-red' : role_auth.information.PaymentType }">เงือนไขการจ่ายเงิน</div>
								<div class="col-md-8 paddingTB5 paddingLR_none" ng-class="{ 'col-md-4' : DataList.BorrowerPayType == 'Baht Net' }">
									<select class="form-control" ng-model="DataList.PaymentType" ng-change="setTotalNetAmt()" ng-disabled="!role_auth.information.PaymentType || DataList.Status !== 'approved'">
										<option value="">โปรดระบุ</option>
  										<option value="Term Loan">Term Loan</option>
										<option value="Top up">Top up</option>
										<option value="เบิกงวดงาน">เบิกงวดงาน</option>
									</select>
								</div>
								<div ng-if="DataList.BorrowerPayType == 'Baht Net'" class="col-md-4 paddingTB5 paddingLR_none">
									<input ng-model="DataList.BookBankNo" class="form-control" placeholder="หมายเลขบัญชี" ng-disabled="!role_auth.information.BookbankNo">
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 text_bold paddingLR_none">วันที่วางแผน DD</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList._PlanDrawdownDate" date="dd/MM/yyyy" class="form-control" readonly="readonly">
									<input type="hidden" class="form-control" readonly="readonly">
								</div>
								<!--<i class="fa fa-history pull-right" style="font-size: 1.3em !important; cursor: pointer; position: absolute; top: 7px; right: 7px;"></i>-->
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold" ng-class="{ 'fg-red' : role_auth.information.AppraisalStatus }">สถานะจดจำนอง</div>
								<div class="col-md-8 paddingTB5 paddingLR_none" ng-class="{ 'col-md-7' : DataList.AppraisalStatus == 'Postpone' }">
									<select class="form-control" ng-model="DataList.AppraisalStatus" ng-change="postponeHandled(DataList.AppraisalStatus, AppraisalStatusDraft);" ng-disabled="!role_auth.information.AppraisalStatus || isConfirmPostpone || DataList.AppraisalStatus == 'Completed'">
										<option value="" disabled></option>										
										<option value="Cancel" ng-disabled="DataList.AppraisalStatus == 'Cancel'">Cancel (ยกเลิกการจอง)</option>
										<option value="Postpone" ng-disabled="DataList.AppraisalStatus == 'Cancel'">Postpone (เลือนภายในเดือน)</option>
										<option value="Re-Process" ng-disabled="!role_auth.information.ReProcess || DataList.AppraisalStatus !== 'Cancel'">Re-Process (นำเคสกลับมาทำใหม่)</option>
										<option value="Process" disabled>Process</option>
										<option value="Completed" disabled>Completed (System)</option>
									</select>									
									<div class="postpone_area hide">
										<div class="paddingTB5 paddingLR_none" ng-class="{ 'hide' : DataList.AppraisalStatus != 'Cancel'  }">
											<label>Cancel Reason</label>
											<select id="objpostpone_reason" list-bundle="multiple" multiple="multiple" style="max-width: 230px;">
												<option ng-repeat="option in masterdata.postponereason track by $index" value="{{ option.PostponeReason }}">{{ option.PostponeReason }}</option>
											</select>
										</div>
										<div class="paddingTB5 paddingLR_none">
											<label>วันที่วางแผน DD ใหม่</label>
											<input ng-date-picker config="jqDateConfig" model-format="yyyy-MM-dd HH:mm:ss" ng-model="dateSelect" readonly="readonly" class="form-control">
										</div>
										<div class="pull-right">
											<button ng-click="postponeDismiss()" type="button" class="bg-amber fg-white">CANCEL</button>
											<button ng-click="postponeOK()" type="button" class="bg-teal fg-white">OK</button>
										</div>
									</div>
								</div>
								<span id="resetPostpone" ng-if="DataList.AppraisalStatus == 'Postpone'" class="col-md-1 paddingLR_none tooltip-left" data-tooltip="Reset เพื่อเลือน  Drawdown ภายในเดือน กด ''Double-Click''" style="font-size: 1.3em !important; text-align: center; margin-top: 10px;">
									<i class="fa fa-refresh fg-red nav_icon" ng-dblclick="resetPostponeHandled(DataList.AppraisalStatus)" ng-class="{ 'fa-spin' : spin }" ng-mouseover="spin = true" ng-mouseleave="spin = false" ng-init="spin = false"></i>
								</span>
							</div>

							<div class="col-md-4" style="max-height: 44px !important;">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold" ng-class="{ 'fg-red' : role_auth.information.BorrowerType }">สั่งจ่ายเงินกู้คงเหลือ</div>
								<div class="col-md-8 paddingTB5 paddingLR_none" style="max-height: 44px;">
									<div class="form_group col-md-4	padding_none">
										<select ng-model="DataList.BorrowerType" ng-change="setFieldBorrowerName()" ng-disabled="!role_auth.information.BorrowerType" class="form-control paddingLR_none" style="padding-left: 6px !important;">
											<option value=""></option>
											<option title="{{ option.BorrowerType }}" ng-repeat="option in masterdata.borrower track by $index" value="{{ option.BorrowerType }}">{{ option.BorrowerName }}</option>
										</select>
									</div>
									<div class="form-group col-md-8 padding_none" ng-class="{ 'has-error' : DataList.validation.BorrowerName }">
										<input ng-model="DataList.BorrowerName" class="form-control" ng-disabled="!role_auth.information.BorrowerName || !DataList.BorrowerType">
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 text_bold paddingLR_none" ng-class="{ 'fg-red' : role_auth.information.TotalNetAmt  }">วงเงินสินเชื่อที่รับจริง</div>
								<div class="col-md-8 paddingTB5 paddingLR_none" ng-class="{ 'has-error' : DataList.validation.TotalNetAmt }">
									<input ng-model="DataList.TotalNetAmt" num-format="2" ng-readonly="!role_auth.information.TotalNetAmt" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Updated Name</div>
								<div class="col-md-8 paddingTB5 paddingLR_none"> 
									<input ng-model="DataList.UpdateByEmpName" class="form-control" readonly="readonly">
								</div>
							</div>

							<div class="col-md-4" style="max-height: 44px !important;">
								<div class="col-md-4 paddingLR_none paddingTB5 text_bold" ng-class="{ 'fg-red' : role_auth.information.BorrowerPayType }" style="font-size: 95%;">วิธีชำระ/ธนาคาร/วงเงิน</div>
								<div class="col-md-3 paddingLR_none paddingTB5" ng-class="{ 'has-error' : DataList.validation.BorrowerPayType }">
									<select ng-model="DataList.BorrowerPayType" ng-change="checkPayTypeHandled();" ng-disabled="!role_auth.information.BorrowerPayType || !DataList.BorrowerType" class="form-control paddingRight_none" style="max-width: 87px; padding-left: 6px !important;">
										<option value=""></option>
										<option title="{{ option.ChannelName }}" ng-repeat="option in masterdata.paymentchannel track by $index" ng-value="option.ChannelName" ng-disabled="setpaymentch(option.ChannelName, role_user, adminrole)" ng-if="option.ChannelName !== 'Cash'">{{ option.ChannelName }}</option>
									</select>
								</div>
								<div class="col-md-2 paddingLR_none paddingTB5" ng-class="{ 'has-error' : DataList.validation.BorrowerBank }"  style="margin-left: -11px;">
									<select ng-model="DataList.BorrowerBank" class="form-control paddingLR_none" ng-disabled="!role_auth.information.BorrowerBank || !DataList.BorrowerType">
										<option value=""></option>
										<option title="{{ option.Bank_NameTh }}" ng-repeat="option in tempBank track by $index" value="{{ option.Bank_Digit }}">{{ option.Bank_Digit }}</option>
									</select>
								</div>
								<div class="col-md-3 paddingLR_none paddingTB5" ng-class="{ 'has-error' : DataList.validation.BorrowerAmt }" style="min-width: 108px;">
									<input ng-model="DataList.BorrowerAmount" num-format="2" class="form-control" readonly="readonly">
									<!-- ng-disabled="!role_auth.information.BorrowerAmount || !DataList.BorrowerType" -->
								</div>
							</div> 

							<div class="col-md-4 ">
								<div class="col-md-4 h44 paddingTB5 text_bold paddingLR_none" ng-class="{ 'fg-red' : role_auth.information.Complete }">สำเร็จตามแผน</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<select class="form-control" ng-model="DataList.Complete" ng-disabled="!role_auth.information.Complete || fieldComleteLock(DataList._PlanDrawdownDate) || DataList.AppraisalStatus == 'Completed'">
										<option value="">โปรดระบุ</option>
  										<option value="Y">Completed (Admin)</option>
										<!--<option value="P" disabled>Confirm Paid (System)</option>-->
  										<option value="N" disabled>Incompleted (System)</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold">Latest Updated</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">
									<input ng-model="DataList._UpdateDate" date="dd/MM/yyyy (HH:mm)" class="form-control" readonly="readonly">
								</div>
							</div>
						</div>
						<div class="col-md-12 marginTop10">

							<div class="col-md-4" ng-class="{ 'vshow': (DataList.BorrowerPayType == 'Baht Net' || DataList.BorrowerPayType == 'Direct Credit'), 'vhidden': (DataList.BorrowerPayType != 'Baht Net' && DataList.BorrowerPayType != 'Direct Credit') }">
								<div class="col-md-4 h44 paddingTB5 paddingLR_none text_bold" ng-class="{ 'fg-red' : role_auth.information.BookBankFile }">Attach Book bank</div>
								<div class="col-md-8 paddingTB5 paddingLR_none">

									<div class="col-md-12 paddingRight_none">

										<div class="checkbox checkbox-success checkbox-inline paddingLeft5" >
                        					<input ng-model="DataList.BookBankFlag" type="checkbox"  ng-true-value="'Y'" ng-false-value="'N'" ng-disabled="!role_auth.information.BookBankFlag || DataList.BorrowerPayType == 'Baht Net'">
                        					<label ng-bind="setDataChoice(DataList.BookBankFlag)"></label>
                    					</div>

										<label ng-if="DataList.BookBankFlag == 'Y'" class="attach-file paddingTop5 tooltip-top" ng-class="{ 'hide' : !role_auth.information.BookBankFile, 'has-elemError' : DataList.validation.BookbankFile }" data-tooltip="อัพโหลดไฟล์สมุดบัญชีหน้าแรก (Bank book)" for="attachBookbank">
											<span>
												<i class="fa fa-upload fg-red marginLeft5 marginRight5 nav_icon" ng-class="{ 'icon_blink ' : FileBookBank.isUpLoading }" style="font-size: 1.4em;"></i>
												<input id="attachBookbank" type="file" type="file" class="nav_icon" dd-file-model="FileBookBank.filePDFInput" dd-file-change="fileBookBankChange" accept="application/pdf">
											</span>	
										</label>

										<span ng-if="DataList.BookBankFlag == 'Y'" class="attachstate nav_icon" ng-class="{ 'hide' : !role_auth.information.BookBankFile }" ng-bind="FileBookbankStatus(DataList.BookBankFileDetail, DataList.BookBankStatus, FileBookBank)" ng-click="openLinkBookbankFile(DataList.BookBankFileDetail, FileBookBank)"></span>
							
										<div ng-if="DataList.BookBankFlag == 'Y'" class="pull-right marginLeft10" style="max-width: 130px;">
											<select ng-model="DataList.BookBankStatus" class="form-control" ng-disabled="!role_auth.information.BookBankStatus" ng-class="{ 'fg-red': DataList.BookBankStatus == 'I' }" style="min-width: 130px; display: inline;">
												<option value="W"></option>
												<option value="C" style="color: #000 !important;">Completed</option>
												<option value="I" class="fg-red">Incompleted</option>
											</select>
										</div>

										<div ng-if="!role_auth.information.BookBankFile" class="col-md-2 paddingLR_none text-center pull-right" style="min-width: 70px;">
											<span class="fa-stack fa-md" style="margin-left: 5px;">
  												<i class="fa fa-upload fa-stack-1x"></i>
  												<i class="fa fa-ban fa-stack-2x text-danger"></i>
											</span>
											<span class="attachstate nav_icon" ng-bind="FileBookbankStatus(DataList.BookBankFileDetail, DataList.BookBankStatus, FileBookBank)" ng-click="openLinkBookbankFile(DataList.BookBankFileDetail, FileBookBank)"></span>
										</div>

									</div>

								</div>
							</div>	

							<div class="col-md-4">
								<div class="col-md-12 paddingLR_none">
									<div class="col-md-4 paddingLR_none text_bold">
										<div class="checkbox checkbox-success checkbox-inline">
                        					<input ng-model="DataList.DiscountFee" type="checkbox" ng-true-value="1" ng-false-value="0">
                        					<label class="fg-red">ขอลดค่าธรรมเนียม</label>
                    					</div>										
									</div>
									<div class="col-md-4 paddingLR_none text_bold">
										<div class="checkbox checkbox-success checkbox-inline">
                        					<input ng-model="DataList.DiscountInterest" type="checkbox" ng-true-value="1" ng-false-value="0">
                        					<label class="fg-red">ขอลดดอกเบี้ย</label>
                    					</div>										
									</div>
								</div>								
							</div>

							<div class="col-md-4">
								<button ng-disabled="role_handled.elements.customer_btn" type="button" class="btn bg-{{ label_bg[0].substr(3) }} fg-white pull-right" ng-class="{ 'hide' : !role_auth.information.saveForm }" ng-click="setCustInformation();" style="bottom: 0; right: 0;">
									<i class="fa fa-save"></i> SAVE
								</button>
							</div>
		
						</div>

					</div>
				</div>
			</div>

			<div id="parent_edit_thirdPerson" class="panel panel-lightBlue marginTopEasing10" style="border-left: 0; border-right: 0;">
				<div id="third_person_edit_parent" class="panel-heading text-uppercase {{ label_bg[0] }} {{ font_color }}" ng-click="collapsePanel('third_person_edit_parent')">
					<h5 class="panel-title">Pay to partners information</h5>
					<span class="pull-right clickable"><i class="fa fa-chevron-circle-up"></i></span>
				</div>
				<div class="panel-body padding_none">

					<div class="nonprint">
						<table class="table table-bordered">
							<thead>
								<tr>	
	      							<th width="10%" style="background-color: #00ABA9 !important;">ON BEHALF OF</th>      	 			
	      							<th width="18%" style="background-color: #00ABA9 !important;">NAME</th> 
									<th width="10%" style="background-color: #00ABA9 !important;">PAY TYPE</th>   	 	
	      							<th width="10%" style="background-color: #00ABA9 !important;">BANK</th>
									<th width="10%" style="background-color: #00ABA9 !important;">AMOUNT</th>
									<th width="15%" style="background-color: #00ABA9 !important;">BOOKBANK NO</th>
									<th width="24%" style="background-color: #00ABA9 !important;">FILE ATTACHED</th>
									<th width="1%"  style="background-color: #00ABA9 !important;">
										<i ng-if="role_auth.partners.AddRows" class="fa fa-plus-circle fg-lightGreen" style="cursor: pointer; font-size: 1.6em;" ng-click="appendPartners(this)"></i>
									</th>	 					      	 				
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="partners in Partners track by $index">	    
									<td>
										<select ng-model="partners.OnbehalfType" class="form-control" ng-disabled="!role_auth.partners.OnBehalfType" ng-class="{ 'fg-red': DataList.BookBankStatus == 'I' }" style="min-width: 130px; display: inline;">
											<option value=""></option>
											<option value="บุคคลธรรมดา">บุคคลธรรมดา</option>
											<option value="นิติบุคคล">นิติบุคคล</option>
										</select>
									</td>
									<td>
										<div class="paddingLR_none" ng-class="{ 'has-error' : partners.Validation.PayeeName }">
											<input ng-model="partners.PayeeName" ng-disabled="!role_auth.partners.PayeeName" type="text" class="form-control">
										</div>
									</td>
									<td>
										<div class="paddingLR_none" ng-class="{ 'has-error' : partners.Validation.PartnerPayType }">
											<select ng-model="partners.PayType" ng-disabled="!role_auth.partners.PayType" class="form-control paddingLR_none" ng-class="{ 'has-error' : partners.validation.PartnerPayType }">
												<option value=""></option>
												<option title="{{ option.ChannelName }}" ng-repeat="option in masterdata.paymentchannel" ng-value="option.ChannelName" ng-if="option.ChannelName !== 'Cash'">{{ option.ChannelName }}</option>
											</select>
										</div>
									</td>
									<td>
										<div class="paddingLR_none" ng-class="{ 'has-error' : partners.Validation.partnerBank }">
											<select ng-model="partners.Bank" ng-disabled="!role_auth.partners.Bank" class="form-control paddingLR_none">
												<option value=""></option>
												<option title="{{ option.Bank_NameTh }}" ng-repeat="option in partners.bankcategory[partners.PayType] track by $index" value="{{ option.Bank_Digit }}">{{ option.Bank_Digit }}</option>
											</select>
										</div>
									</td>
									<td><input ng-model="partners.PayAmount" ng-disabled="!role_auth.partners.PayAmount" num-format="2" class="form-control"></td>
									<td><input ng-model="partners.BookBankNo" class="form-control" ng-disabled="!role_auth.partners.BookbankNo || partners.PayType !== 'Baht Net' || !partners.PayType"></td>
									<td>
										<div class="col-md-12 paddingRight_none">

											<div class="checkbox checkbox-success checkbox-inline paddingLeft5" ng-class="{ 'paddingTop5' : partners.PatchFlag == 'N' || !partners.PatchFlag, 'paddingTop5 pull-left' : !role_auth.partners.PatchFile }">
                        						<input ng-model="partners.PatchFlag" ng-disabled="!role_auth.partners.PatchFlag" type="checkbox" ng-true-value="'Y'" ng-false-value="'N'">
                        						<label ng-bind="setDataChoice(partners.PatchFlag)"></label>
                    						</div>

											<div ng-if="!role_auth.partners.PatchFile" class="paddingLR_none pull-left">
												<span class="fa-stack fa-md" style="margin-left: 8px;">
  													<i class="fa fa-upload fa-stack-1x"></i>
  													<i class="fa fa-ban fa-stack-2x text-danger"></i>
												</span>
												<span class="attachstate nav_icon" ng-bind="setFilePartnerState(partners.PatchStatus, partners.BookBankFileDetail, partners.BookBankFile)" ng-click="openLinkPartnerFile(partners.BookBankFileDetail, partners.BookBankFile)"></span>
											</div>
			
											<label ng-if="partners.PatchFlag == 'Y'" class="attach-file paddingTop5 tooltip-top" ng-class="{ 'hide' : !role_auth.partners.PatchFile }" data-tooltip="อัพโหลดไฟล์สมุดบัญชีหน้าแรก (Bank book)" for="attachPartnerBookbank_{{$index}}">
												<span>
													<i class="fa fa-upload fg-red marginLeft5 marginRight5 nav_icon" ng-class="{ 'icon_blink ' : partners.isUpLoading }" style="font-size: 1.4em;"></i>
													<input id="attachPartnerBookbank_{{$index}}" type="file" type="file" class="nav_icon" dd-file-model="partners.objFileInput" dd-file-change="filePartnerChange" accept="application/pdf">
												</span>	
											</label>
											
											<span ng-if="partners.PatchFlag == 'Y'" class="attachstate nav_icon" ng-class="{ 'hide' : !role_auth.partners.PatchFile }" ng-bind="setFilePartnerState(partners.PatchStatus, partners.BookBankFileDetail, partners.BookBankFile)" ng-click="openLinkPartnerFile(partners.BookBankFileDetail, partners.BookBankFile)"></span>
											
											<div ng-if="partners.PatchFlag == 'Y'" class="pull-right marginLeft10">
												<select ng-model="partners.PatchStatus" ng-disabled="!role_auth.partners.PatchStatus" class="form-control" ng-class="{ 'fg-red': partners.PatchStatus == 'I' }" style="min-width: 180px; display: inline;">
													<option value="W"></option>
													<option value="C" style="color: #000 !important;">Completed</option>
													<option value="I" class="fg-red">Incompleted</option>
												</select>
											</div>

										</div>
									</td>
									<td><i ng-if="!partners.BookBankFileDetail && role_auth.partners.PatchRemove" ng-click="removePartnersListItem(partners, $index)" class="fa fa-minus-circle fg-red nav_icon" style="font-size: 1.5em; margin-top: 8px; cursor: pointer margin: 0 auto;"></i></td>
								</tr>
							</tbody>
						</table>
					</div>

					<button ng-disabled="role_handled.elements.partners_btn" type="button" class="btn bg-{{ label_bg[0].substr(3) }} fg-white pull-right marginRight35 marginBottom20" ng-class="{ 'hide' : !role_auth.information.saveForm }" ng-click="setPartnersInformationBundled();">
						<i class="fa fa-save"></i> SAVE
					</button>

				</div>
			</div>

			<div id="parent_edit_tableHistory" class="panel panel-lightBlue table-collapsed" style="border-left: 0; border-right: 0;">
				<div id="note_edit_parent" class="panel-heading text-uppercase {{ label_bg[5] }} {{ font_color }}" ng-click="collapsePanel('note_edit_parent')">
					<h5 class="panel-title">Note Information</h5>
					<span class="pull-right clickable"><i class="fa fa-chevron-circle-up"></i></span>
				</div>
				
				<div class="panel-body padding_none">
					<div class="nonprint">
						<table class="table table-bordered">
							<thead>							
								<tr>	
	      							<th width="20%">DATE</th>      	 			
	      							<th width="20%">NAME</th> 
	      							<th width="59%">NOTE DETAILS</th>
									<th width="1%">
										<i class="fa fa-plus-circle fg-lightGreen" style="cursor: pointer; font-size: 1.6em;" ng-click="addTableRecord(this)"></i>
									</th>   	 					      	 				
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="list in NoteList | orderBy: '-_UpdateDate' track by $index">	    
									<td>
										<input class="form-control" ng-if="list._UpdateDate" ng-model="list._UpdateDate" date="dd/MM/yyyy (HH:mm)" readonly="readonly">
										<input class="form-control" ng-if="!list._UpdateDate" ng-model="list.UpdateDate" date="dd/MM/yyyy (HH:mm)" readonly="readonly">
									</td>
									<td> 
										<input class="form-control" ng-model="list.UpdateByEmpName" type="text" readonly="readonly">
									</td>
									<td><textarea auto-height rows="1" class="form-control" ng-model="list.Note" ng-disabled="!role_auth.noteinfo.Note || list._UpdateDate"></textarea></td>
									<td><i ng-if="!list._UpdateDate" ng-click="removeNoteItem($index)" class="fa fa-minus-circle fg-red" style="font-size: 1.5em; margin-top: 8px; cursor: pointer margin: 0 auto;"></i></td>
								</tr>
							</tbody>
						</table>
					
						<div class="col-md-12 marginTop10 marginBottom15">
							<button ng-disabled="role_handled.elements.noteinfo_btn_btn" type="button" class="btn bg-lightBlue fg-white pull-right marginRight15" ng-class="{ 'hide' : !role_auth.noteinfo.saveForm }" ng-click="setNoteInfo()">
								<i class="fa fa-save"></i> SAVE
							</button>
						</div>

					</div>
				</div>
			</div>

			<div class="marginTopEasing5">
				 
				<div class="panel panel-{{ label_bg[2].substr(3) }}" style="border-left: 0; border-right: 0;">
					<span ng-class="{ 'hide' : !role_auth.callateral.ItemHidden }" ng-click="collateralBinding()">
						<i ng-class="{ 'fa fa-eye-slash fg-white': isBinding , 'fa fa-eye fg-white' : !isBinding }" style="position: absolute; margin-top: 9px; left: 250px; cursor: pointer; font-size: 1.4em;"></i>
					</span>
					<div id="security_edit_parent" class="panel-heading text-uppercase {{ label_bg[2] }} {{ font_color }}" ng-click="collapsePanel('security_edit_parent')">
						<h5 class="panel-title">Collateral Information</h5>
						<span class="pull-right clickable"><i class="fa fa-chevron-circle-up"></i></span>
					</div>
					<div class="panel-body">

						<div id="collater_box" class="col-md-12 marginTopEasing5">
						
							<div ng-if="isBinding || item.IsVisible == 'A'" class="col-md-4 collater_division collateral_item_{{$index+1}} paddingLR_none" ng-repeat="item in Collateral track by $index">
								<i ng-if="!item.RefNo" ng-click="removeCollaterItem(item, $index);" class="fa fa-minus-circle fg-red" ng-class="{ 'hide' : !role_auth.callateral.removeCollateral }" style="font-size: 1.5em; position: absolute; top: -5px; right: -8px; cursor: pointer; margin-right: 15px; z-index: 2000083647;"></i>
								<div ng-class="{ 'animated fadeIn' : isBinding, 'hide' : !isBinding }" class="col-md-12">
									<div class="checkbox">
                        				<input type="checkbox" ng-model="item.IsVisible" ng-true-value="'N'" ng-false-value="'A'">
                        				<label>คลิกเครื่องหมายถูก เพื่อซ่อนรายละเอียด</label>
                    				</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5">
										เลขที่ส่งงานประเมิน
										<span ng-if="item.CollateralBy == 'System'">{{ (item.CollateralBy == 'System') ? '(S)':'(M)' }}</span>
									</div>
									<div class="input-group col-md-7 paddingLR_none paddingTB5" ng-class="{ 'has-error' : item.Validation.RefNumber }">
										<input ng-value="item.RefNo" class="form-control" disabled>
										<div ng-click="checkRefNumberValidation($index)" class="input-group-addon nav_icon bg-white" ng-class="{ 'hide' : !role_auth.callateral.RefNo }">
											<i class="fa fa-search"></i>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5" ng-class="{ 'fg-red' : role_auth.callateral.CollateralType && !item.RefNo }">หลักทรัพย์ที่ {{$index+1}}</div>
									<div id="CollateralName_{{$index+1}}" class="col-md-7 paddingLR_none paddingTB5">
										<select class="form-control" ng-model="item.CollateralType" ng-disabled="!role_auth.callateral.CollateralType || item.RefNo">
											<option value=""></option>
											<option ng-repeat="option in masterdata.collateraltype track by $index" ng-value="option.NameEn">{{option.NameEn}}</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5">นส.รับรองสิทธิ์สิ่งปลูกสร้าง</div>
									<div class="col-md-7 h44 paddingLR_none paddingTB5">
										
										<div class="col-md-12 paddingRight_none">
											<div class="checkbox checkbox-success checkbox-inline paddingLeft5" ng-class="{ 'pull-left paddingTop5' : !role_auth.callateral.FileUpload }">
                        						<input type="checkbox" ng-model="item.OwnershipBuilding" ng-true-value="'Y'" ng-false-value="'N'" ng-disabled="!role_auth.callateral.OwnerShipDoc">
                        						<label ng-bind="setDataChoice(item.OwnershipBuilding)" ng-click="modalOwnershipFileEnabled(DataList.ApplicationNo, item.OwnershipBuilding);"></label>
                    						</div>

											<div ng-if="!role_auth.callateral.FileUpload" class="paddingLR_none pull-left">
												<span class="fa-stack fa-md" style="margin-left: 8px;">
  													<i class="fa fa-upload fa-stack-1x"></i>
  													<i class="fa fa-ban fa-stack-2x text-danger"></i>
												</span>
												<span class="attachstate nav_icon" ng-bind="setFileDefaultState(item.FileStatus, item.CollateralFileDetail, item.CollateralFile)" ng-click="openLinkPdfFile(item)"></span>
											</div>
			

											<label ng-if="item.OwnershipBuilding == 'Y'" class="attach-file paddingTop5 tooltip-top" ng-class="{ 'hide' : !role_auth.callateral.FileUpload }" data-tooltip="อัพโหลดไฟล์หนังสือรับรองกรรมสิทธิสิ่งปลูกสร้าง" for="fileInput_{{$index}}">
												<span>
													<i class="fa fa-upload fg-red marginLeft10 marginRight5 nav_icon" ng-class="{ 'icon_blink ' : item.isUpLoading }" style="font-size: 1.4em;"></i>
													<input id="fileInput_{{$index}}" type="file" class="nav_icon" dd-file-model="item.objFileInput" dd-file-change="fileChange" accept="application/pdf">
												</span>	
											</label>

											<span ng-if="item.OwnershipBuilding == 'Y'" class="attachstate nav_icon" ng-class="{ 'hide' : !role_auth.callateral.FileUpload }" ng-bind="setFileDefaultState(item.FileStatus, item.CollateralFileDetail, item.CollateralFile)" ng-click="openLinkPdfFile(item)"></span>
	
											<div ng-if="item.OwnershipBuilding == 'Y'" class="pull-right marginLeft10" style="max-width: 105px;">
												<select ng-model="item.FileStatus" class="form-control" ng-disabled="!role_auth.callateral.FileStatus || item.isUpLoading" ng-class="{ 'fg-red': item.FileStatus == 'I' }" style="max-width: 110px; display: inline;">
													<option value="W"></option>
													<option value="C" style="color: #000 !important;">Completed</option>
													<option value="I" class="fg-red">Incompleted</option>
												</select>
											</div>
										</div>

									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5">สถานะการประเมิน</div>
									<div class="col-md-7 paddingLR_none paddingTB5">
										<input ng-model="item.AssetStatus" class="form-control" readonly="readonly">

										<input ng-model="item.AppointmentReceiveDate" date="dd/MM/yyyy" type="hidden" class="form-control">
										<input ng-model="item.ReceiveDocumentDateTime" date="dd/MM/yyyy" type="hidden" class="form-control">

									</div>
								</div>								
								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5" ng-class="{ 'fg-red' : role_auth.callateral.ApproveValue && !item.RefNo }">มูลค่าหลักทรัพย์</div>
									<div class="col-md-7 paddingLR_none paddingTB5">
										<input ng-model="item.ApproveValue" num-format="2" class="form-control" ng-readonly="!role_auth.callateral.ApproveValue || item.RefNo">
									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5" ng-class="{ 'fg-red' : role_auth.callateral.Province && !item.RefNo }">สถานที่ตั้งหลักทรัพย์</div>
									<div class="col-md-7 paddingLR_none paddingTB5" style="max-height: 44px;">
										<div class="form-group col-md-4 padding_none">
											<select class="form-control" ng-options="option.Province as option.Province for option in masterdata.province | orderBy: option.Province | unique:'Province' " ng-model="item.Province" ng-disabled="!role_auth.callateral.Province || item.RefNo">
												<option value=""></option>
											</select>
										</div>
										<div class="form-group col-md-4 padding_none">
											<select class="form-control" ng-options="option.Amphur as option.Amphur for option in masterdata.province | filter : { Province: item.Province }" ng-model="item.Amphur" ng-disabled="!role_auth.callateral.Amphur || item.RefNo">
												<option value=""></option>
											</select>
										</div>
										<div class="form-group col-md-4 padding_none">
											<input ng-model="item.Tambol" class="form-control" placeholder="ตำบล" ng-readonly="!role_auth.callateral.Tambol || item.RefNo">
										</div>
									</div>
								</div>		
								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5" ng-class="{ 'fg-red' : role_auth.callateral.AgencyMortgage }">สนง.เขตที่ดินจดจำนอง</div>
									<div class="col-md-7 paddingLR_none paddingTB5">
                        				<select id="agency_land_{{$index}}" ng-disabled="!role_auth.callateral.AgencyMortgage" multi-select
                               				name="objMasterPosition"
                                			ng-model="item.AgencyMortgage"
                                			config="selectOptions"
                                			data="masterdata.departmentoflands"
                                			ng-options="option.Location as option.Location for option in masterdata.departmentoflands">
											<option value="">โปรดระบุ</option>
                        				</select>
									</div>
								</div>	

								<!--  ng-init="option.MortgageName = item.PaymentChannel || item.PaymentChannel = masterdata.mortgagechannel[0].MortgageName"  -->
								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5" ng-class="{ 'fg-red' : role_auth.callateral.PaymentChannel }">ผู้รับมอบจดจำนอง</div>
									<div class="col-md-7 paddingLR_none paddingTB5">
										<select class="form-control" ng-model="item.PaymentChannel" ng-options="option.MortgageName as option.MortgageName for option in masterdata.mortgagechannel" ng-disabled="!role_auth.callateral.PaymentChannel"></select>
									</div>									
								</div>

								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5" ng-class="{ 'fg-red' : role_auth.callateral.CollateralStatus }">สถานะหลักทรัพย์</div>
									<div class="col-md-7 paddingLR_none paddingTB5" ng-class="{ 'col-md-4' : item.CollateralStatus == 'Refinance', 'col-md-2' : item.CollateralStatus == 'Other', 'col-md-7' : item.CollateralStatus == 'Non Refinance', 'col-md-7' : item.CollateralStatus == '' }">
										<select class="form-control" ng-class="{ 'paddingLR_none' : item.CollateralStatus == 'Other' }" ng-model="item.CollateralStatus" ng-disabled="!role_auth.callateral.CollateralStatus" class="form-control">
											<option value=""></option>
											<option value="Refinance">Refinance</option>
											<option value="Non Refinance">Non Refinance</option>
											<option value="Other">Other</option>
										</select>
									</div>
									
									<div ng-if="item.CollateralStatus == 'Refinance'" class="col-md-3 paddingLR_none paddingTB5" ng-class="{ 'has-elemError' : item.Validation.BankRefin }">
										<select multi-select ng-disabled="!role_auth.callateral.Bank"
                               				name="objBankOfRefinance"
                                			ng-model="item.Bank"
                                			config="selectOptions"
                                			data=" masterdata.bank"
                                			ng-options="option.Bank_Digit as option.Bank_Digit for option in masterdata.bank">
                        				</select>
									</div>

									<div ng-if="item.CollateralStatus == 'Other'" class="col-md-5 paddingLR_none paddingTB5" ng-class="{ 'has-error' : item.Validation.OtherName }">
										<input field-autocompleted config="masterdata.banknominee" ng-model="item.OrtherNote" ng-disabled="!role_auth.callateral.OrtherNote" class="form-control">
									</div>
								</div>				
			
								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5" ng-class="{ 'fg-red' : role_auth.callateral.PayType }">วิธีชำระ/ธนาคาร/วงเงิน</div>
									<div class="col-md-2 paddingLR_none paddingTB5">
										<select ng-model="item.PayType" ng-change="resetField(item)" ng-disabled="!role_auth.callateral.PayType || item.CollateralStatus == 'Non Refinance'" class="form-control paddingLR_none" >
											<option value=""></option>
											<option title="{{ option.ChannelName }}" ng-repeat="option in masterdata.paymentchannel track by $index" ng-value="option.ChannelName" ng-disabled="setpaymentch(option.ChannelName, role_user, adminrole)" ng-if="option.ChannelName !== 'Baht Net' && option.ChannelName !== 'Cash' && option.ChannelName !== 'Direct Credit'">{{ option.ChannelName }}</option>
										</select>
									</div>
									<div class="col-md-2 paddingLR_none paddingTB5" ng-class="{ 'has-error' : item.Validation.Bank }">
										<select ng-model="item.BankPayType" class="form-control paddingLR_none" ng-disabled="!role_auth.callateral.BankPayment || item.CollateralStatus == 'Non Refinance' || !item.PayType">
											<option value=""></option>
											<option title="ธนาคารไทยพาณิชย์จำกัด (มหาชน)" value="SCB" ng-if="item.PayType == 'Draft'">SCB</option>
											<option title="ธนาคารธนชาติจำกัด (มหาชน)" value="TBANK" ng-if="item.PayType == 'Draft'">TBANK</option>
											<option title="ธนาคารกรุงไทยจำกัด (มหาชน)" value="KTB" ng-if="item.PayType == 'Draft'">KTB</option>
											<option title="ธนาคารไทยเครดิตเพื่อรายย่อย" value="TCRB" ng-if="item.PayType == 'Cheque'">TCRB</option>
										</select>
									</div>
									<div class="col-md-3 paddingLR_none paddingTB5" ng-class="{ 'has-error' : item.Validation.Refinance }">
										<input ng-model="item.Refinance" num-format="2" ng-class="handlePaymentSummary(DataList, Collateral);" class="form-control" ng-disabled="!role_auth.callateral.Refinance || item.CollateralStatus == 'Non Refinance' || !item.PayType">
									</div>
								</div>

								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5" ng-class="{ 'fg-red' : role_auth.callateral.PayType }">คชจ.การจดจำนอง</div>
									<div class="col-md-2 paddingLR_none paddingTB5">
										<select ng-model="item.PayType2" ng-change="resetField2(item, DataList.ApprovedLoan)" class="form-control paddingLR_none" ng-disabled="!role_auth.callateral.PayType2 || !item.CollateralStatus">
											<option value=""></option>
											<option title="{{ option.ChannelName }}" ng-repeat="option in masterdata.paymentchannel track by $index" ng-value="option.ChannelName" ng-disabled="setpaymentch(option.ChannelName, role_user, adminrole)"  ng-if="option.ChannelName !== 'Baht Net' && option.ChannelName !== 'Direct Credit'">{{ option.ChannelName }}</option>
										</select>
									</div>
									<div class="col-md-2 paddingLR_none paddingTB5" ng-class="{ 'has-error' : item.Validation.Bank2 }">
										<select ng-model="item.Bank2" class="form-control paddingLR_none" ng-disabled="!role_auth.callateral.PayType2 || !item.PayType2 || item.PayType2 == 'Cash'">
											<option value=""></option>
											<option ng-if="item.PayType2 == 'Draft'" title="ธนาคารไทยพาณิชย์จำกัด (มหาชน)" value="SCB">SCB</option>
											<option ng-if="item.PayType2 == 'Draft'"  title="ธนาคารธนชาติจำกัด (มหาชน)" value="TBANK">TBANK</option>
											<option ng-if="item.PayType2 == 'Draft'"  title="ธนาคารกรุงไทยจำกัด (มหาชน)" value="KTB">KTB</option>
											<option ng-if="item.PayType2 == 'Cheque'" title="ธนาคารไทยเครดิตเพื่อรายย่อย" value="TCRB">TCRB</option>
										</select>
									</div>
									<div class="col-md-3 paddingLR_none paddingTB5" ng-class="{ 'has-error' : item.Validation.Amount2 }">
										<input ng-model="item.Amount2" num-format="2" ng-class="handlePaymentSummary(DataList, Collateral);" ng-disabled="!role_auth.callateral.Amount2 || item.CollateralStatus == 'Non Refinance' || !item.PayType2" class="form-control">
									</div>
								</div>

								<div class="col-md-12">
									<div class="col-md-5 paddingLR_none text_bold paddingTB5" ng-class="{ 'fg-red' : role_auth.callateral.PayType }">คชจ.อื่นๆ</div>
									<div class="col-md-2 paddingLR_none paddingTB5">
										<select ng-model="item.PayType3" ng-change="resetField3(item)" ng-disabled="!role_auth.callateral.PayType3" class="form-control paddingLR_none">
											<option value=""></option>
											<option title="{{ option.ChannelName }}" ng-repeat="option in masterdata.paymentchannel track by $index" ng-value="option.ChannelName" ng-disabled="setpaymentch(option.ChannelName, role_user, adminrole)"  ng-if="option.ChannelName !== 'Baht Net' && option.ChannelName !== 'Direct Credit'">{{ option.ChannelName }}</option>
										</select>
									</div>
									<div class="col-md-2 paddingLR_none paddingTB5" ng-class="{ 'has-error' : item.Validation.Bank3 }">
										<select ng-model="item.Bank3" class="form-control paddingLR_none" ng-disabled="!role_auth.callateral.Bank3 || !item.PayType3 || item.PayType3 == 'Cash'">
											<option value=""></option>
											<option ng-if="item.PayType3 == 'Draft'" title="ธนาคารไทยพาณิชย์จำกัด (มหาชน)" value="SCB">SCB</option>
											<option ng-if="item.PayType3 == 'Draft'"  title="ธนาคารธนชาติจำกัด (มหาชน)" value="TBANK">TBANK</option>
											<option ng-if="item.PayType3 == 'Draft'"  title="ธนาคารกรุงไทยจำกัด (มหาชน)" value="KTB">KTB</option>
											<option ng-if="item.PayType3 == 'Cheque'" title="ธนาคารไทยเครดิตเพื่อรายย่อย" value="TCRB">TCRB</option>
										</select>
									</div>
									<div class="col-md-3 paddingLR_none paddingTB5" ng-class="{ 'has-error' : item.Validation.Amount3 }">
										<input ng-model="item.Amount3" num-format="2" ng-disabled="!role_auth.callateral.Amount3 || !item.PayType3" class="form-control">
									</div>								
								</div>

								<div class="col-md-12" ng-repeat="campaign in item.CampaignData">
									<div class="col-md-4 paddingLR_none text_bold paddingTB5" ng-class="{ 'fg-red' : role_auth.callateral.PayType }">Campaign {{ item.CampaignList.length }}</div>
									<div class="col-md-1 paddingLR_none paddingTB5" style="min-width: 45px; margin-left: -13px;">
										<select ng-model="campaign.CampaignCode" ng-disabled="campaign.CampaignCode" class="form-control paddingLR_none">
											<option value=""></option>
											<option ng-repeat="campaign_list in DataList.MaximumCampaignData" value="{{ campaign_list.CampaignCode }}">{{ campaign_list.CampaignCode.substring(0, 2) }}</option>
										</select>
									</div>
									<div class="col-md-2 paddingLR_none paddingTB5">
										<select ng-model="campaign.PayType" ng-disabled="!role_auth.callateral.PayType4" class="form-control paddingLR_none">
											<option value=""></option>
											<option title="{{ option.ChannelName }}" ng-repeat="option in masterdata.paymentchannel" ng-value="option.ChannelName" ng-disabled="setpaymentch(option.ChannelName, role_user, adminrole)"  ng-if="option.ChannelName !== 'Cash'">{{ option.ChannelName }}</option>
										</select>
									</div>
									<div class="col-md-2 paddingLR_none paddingTB5">
										<select ng-model="campaign.Bank" ng-disabled="!role_auth.callateral.Bank4 || !campaign.PayType" class="form-control paddingLR_none">
											<option value=""></option>
											<option ng-repeat="banklist in item.bankcategory[campaign.PayType]" title="{{ banklist.Bank_NameTh }}" value="{{ banklist.Bank_Digit }}">{{ banklist.Bank_Digit }}</option>
										</select>
									</div>
									<div class="col-md-3 paddingLR_none paddingTB5">
										<input ng-model="campaign.Amount" num-format="2" ng-class="handlePaymentSummary(DataList, Collateral);" ng-disabled="!role_auth.callateral.Amount4 || !campaign.PayType" class="form-control">
									</div>
									<span ng-click="removeCampaignItem(campaign, $index, $hint)" style="position: absolute; margin-top: 12px; cursor: pointer;"><i class="fa fa-close fg-red"></i></span>
								</div>		
								
								<div class="col-md-12" ng-if="item.CompaignList.length > 0">
									<div class="dropup pull-right">
										<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-plus-circle fg-green"></i> ADD CAMPAIGN
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
											<li ng-repeat="campaign_list in item.CompaignList" class="nav_icon text-center" ng-click="addCompaignList(item, campaign_list.CampaignCode)">{{ campaign_list.CampaignCode }}</li>											
										</ul>
									</div>	
								</div>	

								<div class="divider col-md-12"></div>	
				
							</div>
	
							<div class="collateral_plusbox col-md-4 tooltip-top" ng-class="{ 'hide' : !role_auth.callateral.addCollateral }" data-tooltip="กรณีต้องการเพิ่มหลักประกัน กด ''Double-Click''" ng-dblclick="appendCollateral()">
								<i class="fa fa-plus-circle"></i>
							</div>

						</div>

						<div class="col-md-12 marginTop10">
							<button ng-disabled="role_handled.elements.collateral_btn" type="button" class="btn bg-{{ label_bg[2].substr(3) }} fg-white pull-right marginRight10" ng-class="{ 'hide' : !role_auth.callateral.saveForm }" ng-click="setCollateralInformation()">
								<i class="fa fa-save"></i> SAVE
							</button>
						</div>

					</div>
				</div>
			</div>

		</div> 

	</div> <!-- END MODAL -->
	<div class="modal-footer marginBottom10">
		<!-- <div class="text-left" ng-class="{ 'hide' : DataList.ApplicationNo && DataList.ApplicationNo !== '' }"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span>Loading...</span></div> -->
	</div>
	</script>
	
	<!-- PDF Note Infomarion. -->
	<script id="modalNoteInfo.html" type="text/ng-template">
	<div class="text-left" ng-class="{ 'hide' : itemList[0] }">
		<div class="progress progress_icon animated fadeIn" style="margin-top: 11%;">
			<img src="<?php echo base_url('img/378_1.gif'); ?>">
		</div>
		<div class="progress blackboard"></div>
	</div>

	<div class="modal-header text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">Preview: Note Information</h4>
	</div>
	<div class="modal-body paddingLeft25 paddingRight25">
		<div class="nonprint">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th colspan="4 class="text-uppercase">NOTE INFORMATION</th>
					</tr>
					<tr>	
	      				<th width="10%">DATE</th>      	 			
	      				<th width="20%">NAME</th> 
						<th width="20%">FUNCTION</th>
	      				<th width="50%">NOTE DETAILS</th>   	 					      	 				
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="list in itemList | orderBy:'-UpdateDate' track by $index">	    	
						<td>{{ list._UpdateDate || list.UpdateDate | ddDate:"dd/MM/yyyy (HH:mm)"  }}</td>
						<td>{{ list.UpdateByEmpName || '' }}</td>
						<td class="text-center">{{ list.Team || '' }}</td>
						<td>{{ list.Note || '' }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="modal-footer marginBottom10">		
	</div>
	</script>
	
	<!-- PDF Ownership Doc. -->
	<script id="modalDocument.html" type="text/ng-template">
	<div class="modal-header text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">Document Information</h4>
	</div>
	<div class="modal-body paddingLeft25 paddingRight25">
		<div id="pdf_thumbnail" class="content mCS-light-thin mCS-autoHide">
			<file-pdf-division config="config" data="itemList"></file-pdf-division>
		</div>
	</div>
	<div class="modal-footer marginBottom10"></div>
	</script>
	
	<!-- Modal Referance number -->
	<script id="modalReferanceValidation.html" type="text/ng-template" style="max-width: 500px;">
	<div class="modal-header text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">Collateral Information</h4>
	</div>
	<div class="modal-body paddingLeft25 paddingRight25">
		<div class="row">
		<div class="col-md-12">
			<h5 class="marginLeft40 marginTopEasing5 text_bold">Field Validation</h5>
			<div class="col-md-12 marginLeft25 paddingTop10">
				<div class="col-md-3 paddingLR_none">
					<span>เลขที่ส่งงานประเมิน</span>
				</div>
				<div class="input-group col-md-8 paddingLR_none" ng-class="{ 'has-error' : ReferValid }">
					<input ng-model="RefItems" class="form-control" ng-class="{ 'fg-green' : hasSuccess, 'fg-red' : hasError }" max-length="10">
					<div ng-click="onCheckReferenceNumber()" class="input-group-addon nav_icon bg-white">
						<i class="fa fa-search"></i>
					</div>
				</div>
			</div>
			<div class="col-md-12 marginLeft25 marginTop5">
				<div class="col-md-3 paddingLR_none">&nbsp;</div>
				<div ng-if="hasError" class="col-md-8 paddingLR_none text-danger">ไม่พบข้อมูล! เลขที่ส่งงานประเมินไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง</div>
				<div ng-if="hasSuccess" class="col-md-8 paddingLR_none text-success">
					เลขที่ส่งงานเป็นของลูกค้า  {{ responsedData[0].NameEn }} กรุณาตรวจสอบและยืนยันความถูกต้อง
				</div>
			</div>
		</div>
		</div>
	</div>
	<div class="modal-footer">
		<button ng-if="hasSuccess" type="button" class="btn bg-darkCyan fg-white pull-right marginRight40" ng-click="confirmReferenceceValidation()">
			<i class="fa fa-check marginRight5"></i> OK
		</button>
	</div>
	</script>
	
	<!-- Postpone Item -->
	<script id="ModalPostponeReasonItemList.html" type="text/ng-template">
	<div class="modal-header text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">Cancel Reason Information</h4>
	</div>
	<div class="modal-body paddingLeft25 paddingRight25">

		<div class="row">
			<div class="col-md-12 marginLeft15">
				<div class="col-md-2 h44 paddingTB5 paddingLR_none text_bold" style="max-width: 185px;">
					DDP Remaining <span class="badge bg-red">New</span>
				</div>
				<div class="col-md-4 paddingTB5 paddingLR_none text-left">
					<input ng-date-picker config="jqDateConfig" model-format="yyyy-MM-dd HH:mm:ss" ng-model="fieldPlanNewDate" ng-disabled="fieldLockOn" readonly="readonly" class="form-control">
					<span class="col-md-12 paddingLR_none  text-warning"><small>หมายเหตุ: ในกรณีเลื่อนไม่มีกำหนด สามารถข้ามการวางแผนวันที่จดจำนองได้</small></span>
				</div>
				<div class="col-md-4">
					<div class="checkbox checkbox-success checkbox-inline" style="padding-top: 13px;">
						<input type="checkbox" ng-model="postponeUnknown" ng-value="item.PostponeCode" ng-true-value="'Y'" ng-false-value="'N'">
                        <label>เลือนไม่มีกำหนด</label>
                    </div>
				</div>
			</div>
			<hr class="col-md-12 marginLeft30" style="max-width: 90%; color: #D1D1D1;" />
			<div class="col-md-12">
				<div class="col-md-4" ng-repeat="item in masterdata.postponereason track by $index" ng-class="{ 'hide' : item.PostponeCode == 'PO002' }">
					<div class="checkbox checkbox-success checkbox-inline padding5">
						<input type="checkbox" checklist-model="checkboxItemList.items" checklist-value="item.PostponeCode" ng-click="checkPostponeField()">
                        <label>{{ item.PostponeReason }}</label>
                    </div>
				</div>
			</div>
		</div>

		<div class="row marginLeft10" ng-class="{ 'show' : avaliablePOfield, 'hide' : !avaliablePOfield }">
			
			<div class="col-md-4 paddingTB5 paddingLR_none">
				<span class="h44 text_bold">กรุณาระบุเหตุผลเพิ่มเติม</span>
				<span ng-click="addOtherReason()" class="hide" style="float: right; margin-right: 35px;">
					<i class="fa fa-plus-circle fg-green marginTop5" style="font-size: 1.5em !important; cursor: pointer;"></i>
					เพิ่มรายการ
				</span> 
			</div>			
			<div class="col-md-12" ng-repeat="item in postponeOther track by $index">
				<div ng-if="item.itemCode" class="col-md-8">
					<div class="col-md-1 h44 paddingTB5 paddingLR_none text_bold">อื่นๆ </div>
					<div class="col-md-4 paddingTB5 paddingLR_none">
						<input ng-model="item.itemNote" type="text" class="form-control">						
					</div>
					<div class="col-md-1 hide" ng-click="removeOtherReason($index)">
						<i class="fa fa-close fg-steel" style="font-size: 1.5em !important; cursor: pointer; margin-top: 11px;"></i>
					</div>
				</div>
			</div>

		</div>
		
	</div>
	<div class="modal-footer marginBottom10">
		<button type="button" class="btn bg-darkCyan fg-white pull-right marginRight10" ng-click="confimItemList()">
			<i class="fa fa-check marginRight5"></i> ACCEPT
		</button>
	</div>
	</script>
	
	<script src="<?php echo base_url('js/lightbox/lightbox.min.js'); ?>"></script>	
	<script type="text/javascript">
		$(function() {
			$('#refresh_pages').on('mouseover', function() { $('#refresh_pages i').addClass('fa-spin'); });
			$('#refresh_pages').on('mouseout', function() { $('#refresh_pages i').removeClass('fa-spin'); });

			$('#ms_spanmasterdecisionOper').parent().css('max-width', '120px');

			$('.dd_read_tool .collaspe').on('click', function() {
				var el_target = $(this).find('ul')
				var getClass = el_target.attr('class');
				if(!getClass) {
					el_target.addClass('open');
				} else {
					el_target.removeClass('open');
				}
			});
		}); 
	</script>
</div>

