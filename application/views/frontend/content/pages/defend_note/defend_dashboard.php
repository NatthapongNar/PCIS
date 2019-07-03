<!DOCTYPE html>
<html lang="en" ng-app="pcisDefendModule">
<head id="printHeader">
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Defend Dashboard</title>
    <meta name="description" content="<?php echo $desc; ?>">    
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/tcrbank.ico'); ?>" type="image/x-icon">
        
    <!-- INCLUDE STYLE -->
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/jquery-ui/jquery-ui.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/bootstrap-checkbox.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/metro/iconFont.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap.css'); ?>"> 	
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap-ui.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/angular/textangular/textAngular.css'); ?>"> 
 	<link rel="stylesheet" href="<?php echo base_url('js/angular/notification/angular-ui-notification.min.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/angular/scrollable-table/scrollable-table.css'); ?>">
 		
 	<link rel="stylesheet" href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>"> 
 	<link rel="stylesheet" href="<?php echo base_url('css/animate/animate.min.css'); ?>">  

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
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/index_box.css'); ?>">
 	
 	<link rel="stylesheet" href="<?php echo base_url('css/googlefont.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/clndr/material-design-iconic-font/css/material-design-iconic-font.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/notification/angular-ui-notification.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/angular_1.5/angular-material.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/clndr/snarl/snarl.min.css'); ?>">
   	<link rel="stylesheet" href="<?php echo base_url('js/clndr/chat-client.css'); ?>">
	<!-- END INCLUDE STYLE -->
	
	<!-- START INCLUDE SCRIPT -->
	<script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery-ui.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.mousewheel.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.number.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.mask.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/lodash.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/kalendea/kalendae.standalone.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/moment.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugin/webui-popover/jquery.webui-popover.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/vendor/jquery.rotate.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/jqGrid/js/i18n/grid.locale-en.js'); ?>" type="text/ecmascript" ></script>  
	<script src="<?php echo base_url('js/jqGrid/js/jquery.jqGrid.min.js'); ?>" type="text/ecmascript" ></script>
	<script src="<?php echo base_url('js/pdfmake/pdfmake.custom.js'); ?>"></script>
	<script src="<?php echo base_url('js/pdfmake/vfs_fonts.js'); ?>"></script>	
	<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
	
	<!-- START INCLUDE CHAT SCRIPT -->
	<script src="<?php echo base_url('js/angular/angular_1.5/angular.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-animate.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-aria.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-messages.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/scrollable-table/angular-scrollable-table.js'); ?>"></script>
	
	<!-- Angular Material Library -->
    <script src="<?php echo base_url('js/clndr/angular-material.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/jquery.slimscroll.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/moment-with-locales.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/bundle/lodash.min.js'); ?>"></script>
    
	<script src="<?php echo base_url('js/angular/angular-sanitize.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-filter.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/textangular/textAngular-rangy.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/textangular/textAngular-sanitize.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/textangular/textAngular.min.js'); ?>"></script>
	
	<script src="<?php echo base_url('js/angular/file-upload/es5-sham.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/file-upload/es5-shim.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/file-upload/angular-file-upload.min.js'); ?>"></script>

	<script src="<?php echo base_url('js/angular/notification/angular-ui-notification.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/readmore.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/ui-bootstrap-tpls-1.1.2.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/ion.sound.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/socket.io.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/snarl/snarl.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/vendor/jquery.multiple.select.js'); ?>"></script>	
	<script src="<?php echo base_url('js/clndr/bootstrap-multiselect.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/chat-client.js?v=003'); ?>"></script>	
	<script src="<?php echo base_url('js/build/collection/collection_script.js?v=007'); ?>"></script>	
	<script src="<?php echo base_url('js/build/defend/defend_dashboard.js?v=012'); ?>"></script>	
	<script src="<?php echo base_url('js/md5/md5.js'); ?>"></script>
	<!-- END START INCLUDE SCRIPT -->
	
	<style type="text/css">
	
		.chat-status-online { margin-top: -5px; }
		#grid_container table tr > td { border: 1px solid #D1D1D1; }
		table#grid_container > thead th {
		    vertical-align: middle !important;
		    text-align: center;
		}
		
		.frozen-div.ui-jqgrid-hdiv { 
			height: 7px !important; 
			vertical-align: middle !important;
		}
		
		.printable { display: none; }
		div.grid_layer {
			width: 100%;
			display: block;
			text-align: inherit;
			height: 26px;
			border-bottom: 1px solid #D1D1D1;
			padding: 5px 5px 5px 5px;
		}
		
		/* icon sort hidden */
		span.s-ico { display: none !important; }
		
				
		/* .modal-fullscreen size: we use Bootstrap media query breakpoints */	
		.mb-overflow-hide { overflow: hidden; }
		.mb-overflow-show { overflow: visible; }
		
		.modal-icon {
			font-size: 2em; 
			margin-top: -5px;
			margin-right: 15px;
			padding-top: 5px;
			cursor: pointer;
		}
		
		.modal-icon:hover { color: bisque; }
		
		.modal-content {
		   top: 0px !important;
		   width: 100%;
		   margin: 0;
		   margin-right: auto;
		   margin-left: auto;
		   border-radius: 0px;
		   
		}
		
		.modal-sm > .modal-content {
			max-width: 600px;
		} 
		
		.iconcustom {		
		    font-size: 1.5em;
		    color: #000;
		    cursor: pointer;				   
		}
		
		.icondefend { font-size: 1.3em; }
				
		.fontNornmal { font-weight: normal !important; } 
		.btn-save {
			border-bottom: 2px solid #e36d6d;
    		background-color: white;
		}
		
		.ta-scroll-window > .ta-bind {
		    height: auto;
		    min-height: 150px !important;
		    padding: 6px 12px;
		}
		
		.ta-scroll-window > .ta-bind.ng-empty,
		.ta-scroll-window > .ta-bind.ta-readonly.ng-not-empty {
		    background: #eee;
		}

		.ta-scroll-window > .ta-bind.ng-not-empty {
		    background: #fff;
		}
		
		.ta-scroll-window.form-control {
		    position: relative;
		    padding: 0;
		    height: auto;
		    min-width: 150px;
		}
		
		.ta-editor.ta-html, .ta-scroll-window.form-control {
			min-height: 150px !important;
			height: auto !important;
			overflow: auto;
			font-family: inherit;
			font-size: 100%;
		
		}
		
		.locked { background: #eee; }
		
		hr { border-top: 1px solid #D1D1D1 !important; }
		
		.drop-zone { 
			min-height: 300px;
			background: rgb(253, 252, 231);
			border-radius: 15px;
			font-size: 3em;
		    color: gainsboro;
		    padding-top: 22%;
			border: dotted 3px lightgray; 
		}
		
		.drop-zone:hover {
		    background: rgb(252, 255, 210);
		    color: gray;
		}
		
		.pdfmodel:hover { background: antiquewhite; }
		.icon_blink {  animation: blink .9s ease-in infinite; }
		@keyframes blink {
		  from, to { opacity: 1 }
		  50% { opacity: .4 }
		}
				
		.hide { display: none; }
		.show { display: block; }
		
		.division-span {
			border-left: 1px solid #D1D1D1;
		    height: 30px;
		    display: inline;
		    margin-left: -30px;
		    position: absolute;
		}
		
		.marginTop29 { margin-top: 29px; }
		
		.tooltip:after, [data-tooltip]:after {
		  z-index: 1000;
		  padding: 8px;
		  min-width: 180px;
		  background-color: #000;
		  background-color: hsla(0, 0%, 20%, 0.9);
		  color: #fff;
		  content: attr(data-tooltip);
		  font-size: 14px;
		  line-height: 1.2;
		}
		
		tr.fg-black > th { color: #000 !important; }

	</style>
	<style type="text/css" media="print">
	
		.nonprint { display: none; }	
		.printable { display: block !important; }
		.btn { 
			display: none !important;
			height: auto;
			min-height: 100%;
			overflow-y: hidden;
			margin-top: -20px;
		}
				
		.note-toolbar { display: none !important; }

			
		@media print {
		
			body { font-size: 12px !important; }
			.flaticon-phone21 { font-size: 10px; }
			
		    body.modalprinter * {
		        visibility: hidden;
		    }
		    
		    body.modal-open > #defend_container { display: none; }
				
		    body.modalprinter .modal-dialog.focused {
		        position: absolute;
		        padding: 0;
		        margin: 0;
		        left: 0;
		        top: 0;
		    }
		    
		    span.badge.bg-amber { 
		    	background-color: #F0A30A !important; 
		    	color: #FFFFFF !important;
		    	-webkit-print-color-adjust: exact;  
		    }
		    
		    i.lbcolor { color: #E3C800 !important; -webkit-print-color-adjust: exact; } 
		    i.def1color { color: #1BA1E2 !important; -webkit-print-color-adjust: exact; }	
			i.cacolor { color: #60A917 !important; -webkit-print-color-adjust: exact; } 
			i.def2color { color: #E51400 !important; -webkit-print-color-adjust: exact; }
			i.compcolor { color: #666666 !important; -webkit-print-color-adjust: exact; }
		
		    body.modalprinter .modal-dialog.focused .modal-content {
		        border-width: 0;
		    }
		
		    body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title,
		    body.modalprinter .modal-dialog.focused .modal-content .modal-body,
		    body.modalprinter .modal-dialog.focused .modal-content .modal-body * {
		        visibility: visible;
		    }
		
		    body.modalprinter .modal-dialog.focused .modal-content .modal-header,
		    body.modalprinter .modal-dialog.focused .modal-content .modal-body {
		        padding: 0;
		    }
		
		    body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title {
		        margin-bottom: 20px;
		    }
		    
		    #grid_pager { display: none; }
		    .print_notewidth { max-width: 180px !important; }
		    .ui-jqgrid-bdiv {
		    	overflow: none;
		    	min-height: auto !important;
		    	height: 100% !important;
		    }
		    
		    #panel_roothead_info { margin-top: 0 !important; }
		    .panel-primary > .panel-heading {
			    background-color: #3070a9 !important;
			    color: #FFF;
			    -webkit-print-color-adjust: exact; 
			}
			
			.panel-success > .panel-heading {
			    background-color: #D7ECCE !important;
			    color: #FFF;
			    -webkit-print-color-adjust: exact; 
			}
			
			.panel-danger > .panel-heading {
			    background-color: #EED5D5 !important;
			    color: #FFF;
			    -webkit-print-color-adjust: exact; 
			}
			
			.actorTriggers { 
				display: block; 
				font-size: 0.9em;
				font-weight: normal;
			}
			
		}
	</style>
</head>

<?php $id_authority = !empty($session_data['emp_id']) ? $session_data['emp_id']:''; ?>
<?php $user_auth	= !empty($user_role) ? $user_role:''; ?>
<?php $icon_approve = !empty($approved_role['data'][0]['NEWBIE']) ? $approved_role['data'][0]['NEWBIE']:''; ?>
<body data-id="<?php echo $id_authority; ?>" data-role="<?php echo $user_auth; ?>" data-pdf-lock-approved="<?php echo $icon_approve; ?>">

<div id="bs-nav" class="navbar navbar-default nonprint">
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
			 <ul class="nav navbar-nav navbar-left">	  	        	
	        	<li class="divider-vertical" style="margin-left: -10px;"></li>       
		    	<li><a href="<?php echo site_url('authen/loggedPass'); ?>"><i class="icon-home" style="font-size: 1.9em; margin-left: -8px; margin-top: 2px;"></i></a></li>
      		</ul>	
	        <ul class="nav navbar-nav navbar-right">	  
	        	<li><div class="marginTop5" ui-chat-client="<?php echo $id_authority; ?>" direct-chat-click="direct_chat" direct-chat-to="<?php echo $id_authority; ?>" chat-dialog-position="right" chat-status="chat_state"></div></li>	        	
	        	<li class="divider-vertical" style="margin-right: -2px;"></li>       
		    	<li><span id="direct_chat" class="using_information"></span></li>
      		</ul>	
      	</div>		
	</div>
</div>
	
<div id="defend_container" ng-controller="defendDashboard">

	<div class="nonprint text-center"><h3>DEFEND DASHBOARD</h3></div>
	<img src="<?php echo base_url('img/defend_progress.png'); ?>" class="nonprint" style="position: absolute; height: 40px; right: 5px; margin-top: -45px;">
	
	<div class="col-md-5 pull-left" style="position: absolute; margin-top: 40px;">
		<span id="paging_topper" class="nonprint">{{ pagingInfo }}</span>
		<!-- 
		<span ng-click="modalEditMode()" style="float: right; margin-left: 10px; margin-top: -7px; cursor: pointer;">
			<i class="fa fa-list on-left" ng-class="{ 'fa fa-table':!chain_record, 'fa fa-rotate-left':chain_record }" style="opacity: 0.7; font-size: 1.5em; "></i>
			<span ng-if="!chain_record">UNCOMBINE</span>
			<span ng-if="chain_record">COMBINE ROWS</span>
		</span>		
		-->
		<span id="refresh_pages" ng-click="gridSearch()" class="nonprint fg-lightBlue" style="float: right; margin-top: -5px; cursor: pointer;">
			<i class="fa fa-refresh on-left" style="font-size: 1.2em;"></i> 
			<span>REFRESH</span>
		</span>
	</div>

	<div class="col-md-7 nonprint pull-right" style="position: absolute; z-index: 1000; right: 0; margin-top: 20px;">
		<div class="panel panel-lightBlue">
		
			<div id="panel_parent" class="panel-heading bg-lightBlue fg-white panel-collapsed" ng-click="panel_collapsed('panel_parent')">
				<h3 class="panel-title">FILTER CRITERIA</h3>
				<span class="pull-right clickable"><i class="fa fa-chevron-circle-down"></i></span>
			</div>
			
			<div class="panel-body fg-black" style="display: none;">
				<div class="row">
				
					<div class="col-md-12">
						<span>
							<div class="radio radio-primary radio-inline" style="margin-top: 25px;">
								<input name="active_row" ng-model="param.active_row" type="radio" value="Active">
								<label class="fg-darkBlue">Active</label>
							</div>
							<div class="radio radio-primary radio-inline" style="margin-top: 25px;">
								<input name="active_row" ng-model="param.active_row" type="radio" value="Inactive">
								<label class="fg-darkBlue">Inactive</label>
							</div>
							<div class="radio radio-primary radio-inline" style="margin-top: 25px;">
								<input name="active_row" ng-model="param.active_row" type="radio" value="">
								<label class="fg-darkBlue">All</label>
							</div>
						</span>
						
						<div class="col-md-2 pull-right padding_none">
							<label>Employee</label>
							<select id="ms_employee" 									
                               		name="ms_employee"
                                	ng-model="param.emp_list"
                                	config="multi_config"
                                	data="masterdata.employee"
                                	ng-options="option.EmployeeCode as ('(' + option.Position + ') ' + option.FullNameTh) for option in masterdata.employee | orderBy: 'Position' "
                                	multi-select multiple="multiple"
                                	style="width: 125px" >
                        	</select>
						</div>
						
						<div class="col-md-2 pull-right padding_none marginRight5">
							<label>Branch</label>
							<select id="ms_branch" 									
                               		name="ms_branch"
                                	ng-model="param.branch_list"
                                	config="multi_config"
                                	data="masterdata.branch"
                                	ng-options="option.BranchCode as option.BranchName disable when option.BranchCode == '000' for option in masterdata.branch"
                                	ng-change="onBranchChange()"
                                	multi-select multiple="multiple"
                                	style="width: 129.66px">
                        	</select>
						</div>
						
						<div class="col-md-2 pull-right padding_none marginRight5">
							<label>Area</label>
							<select id="ms_area" 									
                               		name="ms_area"
                                	ng-model="param.area_list"
                                	config="multi_config"
                                	data="masterdata.area"
                                	ng-options="option.AreaName as option.AreaName disable when option.AreaName == 'HQ' for option in masterdata.area" 
                                	ng-change="onAreaChange()"
                                	multi-select multiple="multiple"
                                	style="width: 129.66px">
                        	</select>
						</div>
											
						<div class="col-md-2 pull-right padding_none marginRight5">
							<label>Region</label>
							<select id="ms_region" 									
                               		name="ms_region"
                                	ng-model="param.region_list"
                                	config="multi_config"
                                	data="masterdata.region"
                                	ng-options="option.RegionID as option.RegionNameEng for option in masterdata.region" 
                                	ng-change="onRegionChange()" 
                                	multi-select multiple="multiple"
                                	style="width: 129.66px">
                        	</select>
						</div>					
					</div>
					
					<div class="col-md-12 marginTop10">
						<!-- 
						<div class="col-md-2 padding_none" style="max-width: 125px; margin-right: 5px;">
							<label>Defend Type</label>
							<select ng-model="param.defend_type" class="form-control padding_none">
								<option value=""></option>								
								<option value="LBSubmit">LB Submit</option>
								<option value="Defend1">Defend 1</option>
								<option value="CA">Send to CA</option>
								<option value="Defend2">Defend 2</option>
								<option value="Completed">Completed</option>
							</select>
						</div>
						 -->
						<div class="col-md-2 padding_none" style="max-width: 125px; margin-right: 5px;">
							<label>Defend Date <small class="text-warning">(Range)</small></label>
							<input id="dateRange" name="dateRange" ng-model="param.defend_date" input-field-daterange type="text" value="" class="form-control">
						</div>
						<div class="col-md-2 padding_none" style="max-width: 125px; margin-right: 5px;">
							<label>Defend Name</label>
							<select ng-model="param.defend_list" 
								    config="multi_config"
                                	data="defend_full"
                                	ng-options="option.EmployeeCode as option.FullNameTh for option in defend_full"
									class="form-control padding_none">
									<option value=""></option>
							</select>
						</div>
						<div class="col-md-2 padding_none" style="min-width: 120px; max-width: 120px; margin-right: 5px;">
							<label>Status</label>
							<select id="ms_status" 									
                               		name="ms_status"
									ng-model="param.status"
									config="multi_config"
                                	data="masterdata.decisionca"
                                	ng-options="option.values as option.values for option in masterdata.decisionca"
                                	multi-select multiple="multiple">
									<option value=""></option>
							</select>
						</div>
						<div class="col-md-2 padding_none" style="max-width: 125px; margin-right: 5px;">
							<label>CA Name</label>
							<input ng-model="param.ca_name" type="text" value="" class="form-control">
						</div>
						<div class="col-md-2 padding_none" style="max-width: 125px; margin-right: 5px;">
							<label>Application No</label>
							<input ng-model="param.app_no" type="text" value="" class="form-control">
						</div>		
						<div class="col-md-4 padding_none" style="max-width: 125px; margin-right: 5px;">
							<label>Cust. Name</label>
							<input ng-model="param.cust_name" type="text" value="" class="form-control">
						</div>				
					</div>
					
					<div class="col-md-12 marginTop10">
					
						<div class="col-md-2 padding_none pull-left hide">
							<label>Optional</label>
							<select id="ms_optional" ng-model="param.optional" multi-select multiple="multiple" style="min-width: 125px; max-width: 125px;">
								<option value=""></option>
								<optgroup label="Referral">
									<option value="Refer: Thai Life">Refer: Thai Life</option>
								</optgroup>
								<optgroup label="Defend Process">
									<option value="Before Process">Before Process</option>
									<option value="After Process">After Process</option>
								</optgroup>
								<optgroup label="Defend Depart">
									<option value="LB">LB</option>
									<option value="HO">HO</option>
								</optgroup>
							</select>
						</div>
						<button class="btn btn-success pull-right marginTop25 marginRight5" ng-click="gridClear()">CLEAR</button>		
						<button class="btn btn-primary pull-right marginTop25 fg-white" ng-click="gridSearch()"><i class="fa fa-search" style="font-size: 1.3em;"></i> SEARCH</button>										
					</div>
					
				</div>				
			</div>
			
		</div>
	</div>
	
	<ng-jq-grid config="config" jqgrid-group-header="thead_group" jqgrid-freeze-column="false" sort-order="sortOrder" jqgrid-paging="pagingInfo"></ng-jq-grid>
	
	<div id="inbox" ng-click="inbox_open_handler()">
		<span class="badge bg-amber pull-right">1</span>
        <div class="open-inbox-area">
         	<i class="fa fa-gavel "></i>
        </div>
    </div>
    
    <div class="inbox-container animated {{ (open_inbox) ? ' fadeIn active':'' }}">
		<div class="heading" draggable="true">
			Defend: Request List
			<span class="pull-right" ng-click="inbox_close_handler()">
				<i class="fa fa-close inbox-close"></i>
			</span>
		</div>
		<div class="content" style="overflow: hidden; width: auto; height: 350px;">
			<ul class="list-group">
               <li class="list-group-item fist-item">
               	  <div class="row">
					  <div class="col-md-1 content-line pa3 text-center"><span class="label label-success">1</span></div>
					  <div class="col-md-5 content-line pa3 name_ellipsis">Customer name 1</div>
					  <div class="col-md-1 content-line pa3 content-icon">
					  	  <span class="badge bg-amber">W</span>
					  </div>
					  <div class="col-md-4 content-line pa3">
					  	 <a href="#" data-toggle="tooltip" data-placement="bottom" title="Test">
					  	 	19/03/2018 10:01
					  	 </a>
					  </div>
					  <div class="col-md-1 content-line pa3 content-icon">
					  	 <i class="fa fa-laptop" aria-hidden="true"></i>
					  </div>
				  </div>               
               </li>                    
           </ul>
		</div>
    </div>
	
	<!-- Missing Modal -->
	<script id="modalDefendMissingList.html" class="nonprint" type="text/ng-template">
	<div class="modal-header nonprint text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">Missng Doc. Information</h4>
	</div>
	<div class="modal-body nonprint paddingLeft25 paddingRight25">
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
	<div class="modal-footer nonprint marginBottom10"></div>
	</script>
	

	<!-- History Modal -->
	<script id="modaltransactionlogs.html" class="nonprint" type="text/ng-template">
	<div class="modal-header nonprint text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">History Information</h4>
	</div>
	<div class="modal-body nonprint paddingLeft25 paddingRight25">
		 <table class="table table-bordered">
	     	<thead>
				<tr>
					<th align="center" width="30px">#</th>
 					<th align="center" width="250px">DEFEND TOPIC</th>
					<th align="center" width="60px">NO</th>
					<th align="center" width="130px">DATE</th>
					<th align="center" width="180px">NAME</th>
					<th align="center">NOTE INFO</th>  
  					
					<th align="center" width="50px">EVENT</th>                       
				</tr>
			</thead>
			<tbody>      
				<tr ng-repeat="item in content.logs | orderBy: 'CreateDate' track by $index" ng-if="item.IsActive == 'A'">
					<td class="text-center">{{ ($index + 1) }}</td>
					<td class="text-left">เรื่อง{{ item.DefendEvent }}</td>
					<td class="text-center">ครั้งที่ {{  item.DefendRef }}</td>
					<td class="text-center">{{ item.CreateDate | ddDate: "dd/MM/yyyy (HH:mm)" }}</td>
					<td class="text-left">{{ item.CreateBy }}</td>
					<td class="text-left">{{ item.DefendNote }}</td>
					<td class="text-center">
						<i ng-click="acknowlegdeLogs(item, content.data)" class="fa fa-check nav_icon icon_blink fg-green" style="font-size: 1.5em;"></i>
					</td>
				</tr>
			</tbody>
		</table>          
	</div>
	<div class="modal-footer nonprint marginBottom10"></div>
	</script>
	
	<!-- History Modal -->
	<script id="modalDefendHistoryList.html" class="nonprint" type="text/ng-template">
	<div class="modal-header nonprint text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">History Information</h4>
	</div>
	<div class="modal-body nonprint paddingLeft25 paddingRight25">
		 <table class="table table-bordered">
	     	<thead>
				<tr>
					<th align="center" width="30px">#</th>
                    <th align="center" width="150px">DATE</th>
					<th align="center" width="250px">NAME</th>
					<th align="center">NOTE INFO</th>                        
				</tr>
			</thead>
			<tbody>      
				<tr ng-repeat="item in content.logs track by $index" ng-class="{ 'fg-crimson' : $index == 0 }">
					<td class="text-center">{{ ($index + 1) }}</td>
					<td class="text-center">{{ item.CreateDate | ddDate: "dd/MM/yyyy (HH:mm)" }}</td>
					<td class="text-left">{{ item.CreateBy }}</td>
					<td class="text-left">{{ item.DefendNote }}</td>
				</tr>
			</tbody>
		</table>          
	</div>
	<div class="modal-footer nonprint marginBottom10"></div>
	</script>
	
	<!-- Request Defend Verify -->
	<script id="modalRequestDefendDialog.html" class="nonprint" type="text/ng-template">
	<div class="modal-header nonprint text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">DEFEND MANAGEMENT</h4>
	</div>
	<div class="modal-body nonprint paddingLeft25 paddingRight25">
		<div class="row">
			<header class="col-md-12 text-right">
				<h6><span class="fg-gray text_bold">Defend Date</span> {{ issue_head.CreateDate | ddDate: "dd/MM/yyyy" }}</h6>
				<h6><span class="fg-gray text_bold">Defend By</span> {{ issue_head.CreateBy }}</h6>
			</header>
			<article class="col-md-12 marginTop10">
				<header class="text_bold">{{ issue_head.DefendDepart }} ({{ issue_head.BranchName }}) สร้างคำร้องขอ Defend เคสจำนวน  {{ issueSubList.rows }} หัวข้อ โดย มีรายละเอียดดังนี้</header>
				<div ng-repeat="item in issueSubList.data track by $index">
					<span>{{ ($index + 1) }}. {{ item.DefendReason || '' }} {{ item.DefendTitleOption  || '' }}</span><br/>
				</div>
			</article>

			<article class="col-md-12 marginTop10">
				<div>LB {{ issue_head.BranchName }} ({{ issueHeader.BranchTel }})</div>
				<div>RM เจ้าของเคสคือ {{ issueHeader.RMName }} ({{ issueHeader.RMMobile }})</div>
				<div class="text_bold marginTop10">
					<span class="pull-left marginRight5" style="padding-top: 9px;">ผู้ดูแลคำร้องการ Defend คือ</span> 
					<span class="pull-left marginRight5">
						<select ng-model="assignDefend" class="form-control" style="min-width: 180px; max-width: 180px; display: inline;">
							<option value=""></option>
							<option ng-repeat="option in defendList" value="{{ option.EmployeeCode }}">{{ option.FullNameTh }}</option>
						</select>
					</span> 
					<span class="pull-left" style="padding-top: 9px;">({{ issueHeader.DefendMobile }})</span>
				</div>
			</article>

		</div>
		
	</div>
	<div class="modal-footer nonprint marginBottom10">
		<button ng-dblclick="deleteRequestDefend(issue_head)" class="btn btn-danger pull-left fg-white">DELETE REQUEST</button>	
		<button ng-click="confirmRequestDefend(issue_head, [assignDefend, defendList])" class="btn btn-primary pull-right fg-white">ACCEPT REQUEST</button>
	</div>
	</script>

	<!-- Defend List Modal -->
	<script id="modalDefendList.html" class="nonprint" type="text/ng-template">
	<div class="modal-header text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">

			<span ng-if="!sale_team" ng-click="requestSentApproveToManger(primarydata)" class="modal-icon nonprint" style="margin-right: 30px;" title="ส่งถึงหัวหน้าทีมเพื่อขออนุมัติข้อมูลถึงทีม CA">
				<span class="badge {{ (request_defend) ? 'bg-green':'bg-amber' }}" style="position: absolute; top: 29px; font-size: 0.4em; margin-left: -25px;">
					<i class="fa fa-share"></i>
				</span> 
				<i class="fa fa-user-circle {{ (request_defend) ? 'wp-bind':''}}" style="font-size: 0.9em;"></i>
			</span> 

			<span class="modal-icon nonprint" style="margin-right: 20px;" title="ส่งถึงหัวหน้าทีมเพื่อขออนุมัติข้อมูลถึงทีม CA">
				<span class="badge bg-red" style="position: absolute; top: 29px; font-size: 0.4em; margin-left: -15px;">
					<i class="fa fa-close fg-white"></i>
				</span> 
				<i class="fa fa-address-book-o" style="font-size: 0.9em;"></i>
			</span> 

			<i ng-if="!defend_team && !defendEndProcess && !btnDisabled" class="fa fa-laptop modal-icon nonprint" ng-click="confirmGeneratePDF()" style="margin-right: 35px;">
				<span class="badge bg-green" style="position: absolute; top: 26px; font-size: 0.3em; margin-left: 10px;">
					<i class="fa fa-check"></i>
				</span>
			</i>
	
			<div class="division-span nonprint"></div>

			<i ng-show="user_role == 'dev_role' && defendEndProcess" ng-click="rollback_process(primarydata)" class="fa fa-wrench modal-icon nonprint" style="margin-right: 35px;"></i>
			
			<!-- ng-show="btnDisabled" -->
			<i ng-click="unlock_process(primarydata, btnDisabled)" class="fa fa-unlock modal-icon icon_blink nonprint" style="margin-right: 25px;"></i>

			<div class="division-span nonprint"></div>
			
			<!-- ng-if="!defend_team && !defendEndProcess && !btnDisabled"  -->
			<i class="fa fa-trash-o modal-icon nonprint" ng-dblclick="deleteRequestDefend(primarydata)" style="margin-right: 40px; margin-left: -15px"></i>
			<div class="division-span nonprint"></div>

			<a ng-href="{{ linkToVerify }}" target="_blank, _self"><img src="<?php echo base_url('img/circle-icon-30.png'); ?>" class="modal-icon nonprint" style="height: 30px; margin-top: -20px; margin-left: -15px;"></a>
			<i class="ti-printer modal-icon nonprint" ng-click="print_area('printHeader', 'issueContent', primarydata)"></i>
			<i class="fa fa-close modal-icon nonprint" data-dismiss="modal" ng-click="dismiss_modal()"></i>

		</div>
		<h4 id="modalLabel" class="modal-title">Defend Information :</h4>
	</div>
	<div id="issueContent" class="modal-body paddingLeft25 paddingRight25">

		<!-- GENERAL INFORMATION  -->
		<div id="panel_roothead_info" class="panel panel-primary marginTop10">
			<div class="panel-heading">
				INFORMATION 
				<small class="fg-white">(DEF. #{{ primarydata[1] }}, APPNO: {{ issue_content.header.ApplicationNo }})</small>
				<div ng-show="btnDefendAcccept" class="pull-right marginLeft10 nonprint" style="margin-top: -8px;">
					<button type="button" class="btn btn-success" ng-click="confirmEndOfDefend(primarydata)" >Accept</button>
				</div>
				<div class="pull-right marginTopEasing10 nonprint">
					<div class="checkbox checkbox-success">
						<input ng-model="defend_completed" type="checkbox" ng-true-value="'I'" ng-false-value="'N'" ng-disabled="defend_team || !btnDisabledOnHO">
						<label class="fg-white">Incompleted</small></label>
					</div>
				</div>
				<!-- || !btnStateDisabled -->
				<div class="pull-right marginTopEasing10 nonprint marginRight10">
					<div class="checkbox checkbox-success">
						<input ng-model="defend_completed" type="checkbox" ng-true-value="'Y'" ng-false-value="'N'" ng-disabled="defend_team || !btnDisabled">
						<label class="fg-white">Completed</label>
					</div>					
				</div>				
			</div>
			<div class="panel-body">

				<div class="col-md-12 marginBottom5">
					<div class="col-xs-3 col-md-3 text-left padding_none">
						<label class="col-xs-12 col-md-12">LB :
							<span class="fontNornmal">{{ issue_content.header.BranchName }}</span>
						</label> 
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i>  
							<span class="fontNornmal">{{ issue_content.header.BranchTel }}</span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left padding_none">
						<label class="col-xs-12 col-md-12">CUS : 
							<span id="borrower_nametext" class="fontNornmal">{{ issue_content.header.BorrowerName }}</span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i>  
							<span class="fontNornmal">{{ issue_content.header.AreaCode }}</span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left padding_none">
						<label class="col-xs-12 col-md-12">DEF :
							<span class="fontNornmal">{{ issue_content.header.DefendName }}</span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i> 
							<span class="fontNornmal">{{ issue_content.header.DefendMobile }}</span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left padding_none">
						<label class="col-xs-12 col-md-12">CA : 
							<span class="fontNornmal">{{ issue_content.header.CAName }}</span>
						</label> 
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i>  
							<span class="fontNornmal">{{ issue_content.header.CAMobile }}</span>
						</label>
					</div>
				</div>
				
				<hr style="width: 100%;"></hr>
				
				<div class="col-md-12 marginTopEasing10">
					<div class="col-xs-3 col-md-3 text-left padding_none">
						<label class="col-xs-12 col-md-12"">RM : 
							<span class="fontNornmal">{{ issue_content.header.RMName }}</span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i>  
							<span class="fontNornmal">{{ issue_content.header.RMMobile }}</span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left padding_none">
						<label class="col-xs-12 col-md-12">BM : 
							<span id="label_bm" class="fontNornmal">{{ issue_content.header.BMName }}</span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i> 
							<span id="bmmobile" class="fontNornmal">{{ issue_content.header.BMMobile }}</span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left padding_none">
						<label class="col-xs-12 col-md-12">AM : 
							<span class="fontNornmal">{{ issue_content.header.AMName }}</span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i> 
							<span class="fontNornmal">{{ issue_content.header.AMMobile }}</span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left padding_none">
						<label class="col-xs-12 col-md-12">RD : 
							<span class="fontNornmal">{{ issue_content.header.RDName }}</span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i>  
							<span class="fontNornmal">{{ issue_content.header.RDMobile }}</span>
						</label>
					</div>
				</div>
				
			</div> 
		</div>

		<!-- DEFEND ZONE -->
		<article ng-repeat="issueItem in issue_content.subscription track by $index">
		<div class="panel marginTopEasing10" ng-class="{ 'panel-success': issueItem.isPanel, 'panel-danger': !issueItem.isPanel }">
			<div class="panel-heading">
				{{ issueItem.DefendReason }} {{ issueItem.DefendTitleOption || '&nbsp;' }}
				<span ng-show="issueItem.DefendCode == 'SP002' && option_data.Remark !== ''" style="font-size: 1em;">{{ ' (Diviate Reason:' + option_data.Remark + ')' }}</span>
				<span ng-show="business_desc && issueItem.DefendCode == 'SP001'" style="font-size: 1em;">{{ business_desc }}</span>

				<div class="btn-group btn-group-sm pull-right animated fadeIn nonprint" role="toolbar" style="margin-top: -7px;">
					<button ng-if="isPanel" type="button" class="btn btn-default">
						<i class="fa fa-trash-o iconcustom"></i>
					</button>

  					<!--<button type="button" class="btn btn-default" ng-click="openDataHistory(issue_content.userinfo, issueItem);"><i class="fa fa-history iconcustom"></i></button>-->
					<button type="button" class="btn btn-default" ng-click="upload_model(issue_content.userinfo, issueItem)">
						<i class="fa fa-file-pdf-o iconcustom"></i>
						<span class="badge badge_group hide" style="position: absolute; margin-top: -10px; margin-left: -3px; z-index: 10000;"> {{ issueItem.NewFile || '0' }}</span>
					</button>

  					<button type="button" class="btn btn-default" ng-click="save_enabled(issue_content.userinfo, issueItem)" ng-disabled="field_completed || btnDisabled || !issueItem.role[user_role]" ng-class="{ 'btn-save fg-white animated fadeIn' : issueItem.isEditable, 'hide animated fadeOut' : !issueItem.isEditable }">
						<i ng-class="{ 'fa fa-save iconcustom' : issueItem.role[user_role], 'fa fa-ban fg-crimson iconcustom' : field_completed || btnDisabled || !issueItem.role[user_role] }"></i>
					</button>

  					<button type="button" class="btn btn-default" ng-click="edit_enabled(issue_content.userinfo, issueItem, ($index+1))" ng-disabled="field_completed || btnDisabled || !issueItem.role[user_role]" ng-class="{ 'animated fadeIn' : !issueItem.isEditable, 'hide animated fadeOut' : issueItem.isEditable }">
						<i ng-class="{ 'fa fa-edit iconcustom' : issueItem.role[user_role], 'fa fa-ban fg-crimson iconcustom' : field_completed || btnDisabled || !issueItem.role[user_role] }"></i>
					</button>
				</div>
				
				<!--
				<div ng-if="issueItem.UpdateDate" class="pull-right marginRight10" style="font-size: 90%;">
					Latest Updated {{ issueItem.UpdateDate }} {{ issueItem.UpdateName }}
				</div>
				-->

			</div>
			<div class="panel-body padding_none" ng-class="{ 'nonprint': !issueItem.DefendNote && issueItem.DefendCode !== 'SP002', 'printable': issueItem.DefendCode == 'SP002' }">
				<text-angular ng-model="issueItem.DefendNote" name="issue_itemnote_{{ $index+1 }}" ta-disabled="issueItem.isDisabled" ng-class="{ 'locked' : issueItem.isDisabled }"></text-angular>
			</div> 
		</div>
		</article>

		<div class="nonprint text-warning">หมายเหตุ: ข้อความในฟิลด์สามารถรับได้สูงสุด 40,000 ตัวอักษร...</div>

	</div>
	<div class="modal-footer nonprint marginBottom10"></div>
	</script>
	
	<!-- Upload Item Modal -->
	<script id="modalUploadList.html" class="nonprint" type="text/ng-template">
	<div class="modal-header nonprint text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">Files Management</h4>
	</div>
	<div class="modal-body nonprint paddingLeft25 paddingRight25">

		<div class="row">

			  <div class="col-md-12 marginTopEasing10">
					
					<header>
						<h3>Upload queue</h3>
                    	<p>Queue length: {{ uploader.queue.length }}</p>
					</header>

					<article class="marginTopEasing30">	
						<div class="pull-right tooltip-left" data-tooltip="Upload Files">
							<label class="nav_icon" for="fileInput">				
                       			<i class="fa fa-plus-square fa-2x fg-green "></i>
					   			<input id="fileInput" class="hide" type="file" nv-file-select="" uploader="uploader" multiple accept="application/pdf">
				   			</label>
						</div>
						<table class="table">
							<thead>
								<tr>
									<th width="40%">Name</th>
									<th ng-show="uploader.isHTML5">Size</th>
									<th ng-show="uploader.isHTML5">Progress</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="item in uploader.queue track by $index">
									<td><strong>{{ ($index +1) }}. {{ item.file.name }}</strong></td>
									<td ng-show="uploader.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
									<td ng-show="uploader.isHTML5">
										<div class="progress" style="margin-bottom: 0;">
											<div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
										</div>
									</td>
									<td class="text-center">
										<span ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
										<span ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
										<span ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
									</td>
									<td nowrap class="text-center">
										<button type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
											<span class="glyphicon glyphicon-upload"></span> Upload
										</button>
										<button type="button" class="btn btn-warning btn-xs" ng-click="item.cancel()" ng-disabled="!item.isUploading">
											<span class="glyphicon glyphicon-ban-circle"></span> Cancel
										</button>
										<button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
											<span class="glyphicon glyphicon-trash"></span> Remove
										</button>
									</td>
								</tr>
							</tbody>
						</table>
					</article>

                    <div>
                        <div>
                            Queue progress:
                            <div class="progress" style="">
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-s" ng-click="uploader.uploadAll()" ng-disabled="!uploader.getNotUploadedItems().length">
                            <span class="glyphicon glyphicon-upload"></span> Upload all
                        </button>
                        <button type="button" class="btn btn-warning btn-s" ng-click="uploader.cancelAll()" ng-disabled="!uploader.isUploading">
                            <span class="glyphicon glyphicon-ban-circle"></span> Cancel all
                        </button>
                        <button type="button" class="btn btn-danger btn-s" ng-click="uploader.clearQueue()" ng-disabled="!uploader.queue.length">
                            <span class="glyphicon glyphicon-trash"></span> Remove all
                        </button>
                    </div>
			
			  </div> 

		</div>
		<div class="row">

			<div class="col-md-12 marginTop20">
			  	  <div class="panel panel-primary" style="border-left: 0; border-right: 0;">
			  	  	   <div id="panel_fileinfo" class="panel-heading" ng-click="panel_collapsed('panel_fileinfo')">
							<span>FILES INFORMATION</span>
							<span class="pull-right clickable"><i class="fa fa-chevron-circle-down marginTop20"></i></span>
						</div>
				  	   <div class="panel-body">
							<div class="row">
								<div class="col-md-12 text-center" ng-class="{ 'hide' : pdf_list.progress }">
									<img src="<?php echo base_url('img/hex-loader2.gif'); ?>"><br/>
									<small style="position: absolute; margin-top: -105px; margin-left: -18px;">Loading...</small>
								</div>
								<div class="col-md-12" ng-class="{ 'animated fadeIn' : pdf_list.progress, 'hide' : !pdf_list.progress }">

									<div ng-show="files.Extension == 'A'" class="col-md-2 padding_none pdfmodel nav_icon animated zoomIn text-center" ng-class="{ 'marginTop29' : files.FileState == 'Y' }" ng-repeat="files in pdf_list.body track by $index">
										
										<i ng-if="files.FileState != 'Y'" class="fa fa-minus-circle fa-lg fg-crimson nav_icon marginLeft70" ng-click="deleteFile(files)"></i>
										<span class="col-md-12 padding_none" ng-class="{ 'marginTop10' : files.FileState != 'Y' }" ng-click="openedFile(files)">
											<i class="fa fa-file-pdf-o fa-4x fg-crimson"></i>
											<i ng-show="files.FileState == 'Y'" class="fa fa-check fg-green fa-2x" style="position: absolute; margin-top: 30px; margin-left: -15px;"></i>
										</span>
										<span class="col-md-12 padding_none marginTop20">{{ files.File_Name }}</span>
										<span class="col-md-12 padding_none marginBottom10">
											<small class="col-md-12 padding_none">Upload date {{ files.CreateDate | ddDate: "dd/MM/yyyy (HH:mm)"  }}</small>
											<small class="col-md-12 padding_none">{{ files.CreateBy  }}</small>
										</span>
									</div>
									
								</div>
							</div>
				 	   </div> 
			  	  </div>
			</div>
		</div>
	</div>
	<div class="modal-footer nonprint marginBottom10"></div>
	</script>
	
	<script id="modalActionNote.html" class="nonprint" type="text/ng-template">
	<div modal-draggle>
	<div class="modal-header text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="modal-icon" ng-class="{ 'fa fa-chevron-circle-down' : !modalToggle, 'fa fa-chevron-circle-up' : modalToggle }" ng-click="setModalHeight(modalToggle)" style="font-size: 1.2em;"></i>
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()" style="font-size: 1.2em;"></i>
		</div>
		<span>Action Note Information</span>
		<span ng-show="noteinfo" class="animated fadeIn">
		(
			<span ng-if="headinfo.custname !== ''">คุณ{{ headinfo.custname }}</span>
			<span ng-if="headinfo.appnumber !== ''"> / App No : {{ headinfo.appnumber }}</span>
			<span ng-if="headinfo.a2cadate !== ''"> / {{ headinfo.a2cadate }}</span>
		)
		</span>
	</div>
	<div class="modal-body paddingLeft25 paddingRight25" style="{{ modalHeight }};">
		<div class="nonprint">
			<scrollable-table>
			<table class="table bordered">
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
	<div class="modal-footer"></div>
	</div>
	</script>
</div>
<script type="text/javascript">
	$(function() {
		$('#mslist_ms_status, #mslist_ms_optional').parent().css('min-width', '120px');
		$('#refresh_pages').on('mouseover', function() { $('#refresh_pages i').addClass('fa-spin'); });
		$('#refresh_pages').on('mouseout', function() { $('#refresh_pages i').removeClass('fa-spin'); });
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
</body>
</html>