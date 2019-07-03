<!DOCTYPE html>
<html lang="en" ng-app="pcisDefendV2Module">
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
 	
 	<link rel="stylesheet" href="<?php echo base_url('css/googlefont.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/clndr/material-design-iconic-font/css/material-design-iconic-font.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/notification/angular-ui-notification.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/angular_1.5/angular-material.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/angular-switch/angular-ui-switch.min.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('js/angular/angular-confirm/angular-confirm.min.css'); ?>"/>
    
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
	<script src="<?php echo base_url('js/angular/angular-switch/angular-ui-switch.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-confirm/angular-confirm.min.js'); ?>"></script>

	<script src="<?php echo base_url('js/angular/notification/angular-ui-notification.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/readmore.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/ui-bootstrap-tpls-1.1.2.min.js'); ?>"></script>	
		<script src="<?php echo base_url('js/angular/angular-checklist-model.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/ion.sound.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/socket.io.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/snarl/snarl.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/vendor/jquery.multiple.select.js'); ?>"></script>	
	<script src="<?php echo base_url('js/clndr/bootstrap-multiselect.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/chat-client.js?v=003'); ?>"></script>	
	<script src="<?php echo base_url('js/build/collection/collection_script.js?v=007'); ?>"></script>	
	<script src="<?php echo base_url('js/build/defend/defend_dashboard_v2.js?v=012'); ?>"></script>	
	<script src="<?php echo base_url('js/md5/md5.js'); ?>"></script>
	<!-- END START INCLUDE SCRIPT -->
	
	<style type="text/css">
		.chat-status-online,.modal-icon{margin-top:-5px}#grid_container table tr>td{border:1px solid #D1D1D1}table#grid_container>thead th{padding-left:0!important;vertical-align:middle!important;text-align:center}.ui-jqgrid-htable th{padding-left:0!important}.frozen-div.ui-jqgrid-hdiv{height:7px!important;vertical-align:middle!important}.printable{display:none}div.grid_layer{width:100%;display:block;text-align:inherit;height:26px;border-bottom:1px solid #D1D1D1;padding:5px}span.s-ico{display:none!important}.mb-overflow-hide{overflow:hidden}.mb-overflow-show{overflow:visible}.modal-icon{font-size:2em;margin-right:15px;padding-top:5px;cursor:pointer}.modal-icon:hover{color:bisque}.modal-content{top:0!important;width:100%;margin:0 auto;border-radius:0}.modal-sm>.modal-content{max-width:600px}.iconcustom{font-size:1.5em;color:#000;cursor:pointer}.icondefend{font-size:1.3em}.fontNornmal{font-weight:400!important}.btn-save{border-bottom:2px solid #e36d6d;background-color:#fff}.ta-scroll-window>.ta-bind{height:auto;min-height:50px!important;padding:6px 12px}.ta-scroll-window>.ta-bind.ng-empty,.ta-scroll-window>.ta-bind.ta-readonly.ng-not-empty{background:#eee}.ta-scroll-window>.ta-bind.ng-not-empty{background:#fff}.ta-scroll-window.form-control{position:relative;padding:0;min-width:50px}.ta-editor.ta-html,.ta-scroll-window.form-control{min-height:150px!important;height:auto!important;overflow:auto;font-family:inherit;font-size:100%}.locked{background:#eee}hr{border-top:1px solid #D1D1D1!important}.drop-zone{min-height:300px;background:#fdfce7;border-radius:15px;font-size:3em;color:#dcdcdc;padding-top:22%;border:3px dotted #d3d3d3}.drop-zone:hover{background:#fcffd2;color:gray}.pdfmodel:hover{background:#faebd7}.icon_blink{animation:blink .9s ease-in infinite}@keyframes blink{from,to{opacity:1}50%{opacity:.4}}.hide{display:none}.show{display:block}.division-span{border-left:1px solid #D1D1D1;height:30px;display:inline;margin-left:-30px;position:absolute}.marginTop29{margin-top:29px}.tooltip:after,[data-tooltip]:after{z-index:1000;padding:8px;min-width:180px;background-color:#000;background-color:hsla(0,0%,20%,.9);color:#fff;content:attr(data-tooltip);font-size:14px;line-height:1.2}tr.fg-black>th{color:#000!important}
		td[role=gridcell]:nth-child(n+15):nth-child(-n+17){
			width:125px;
			max-width:125px;
			white-space:nowrap;
			text-overflow:ellipsis;
			overflow:hidden
		}
		.ta-editor.ta-html, .ta-scroll-window.form-control  {
		    min-height: 50px!important;
		    height: auto!important;
		    overflow: auto;
		    font-family: inherit;
		    font-size: 100%;
		    border-radius: 0px !important;
		}
		.box{color: #000 !important;}
		.text_actionnote {width:200px;max-width:200px;white-space:nowrap;text-overflow:ellipsis;overflow:hidden}
		.divide-left {border-left: 1px solid #FFF;}
		.divide-right {border-right: 1px solid #FFF;}
		.f1em {font-size: 1em;}
		.modal-icon:hover {color: #FFFFFF !important;}
		.badge{padding: 5px 7px !important;}
		.tooltip_text_left {text-align: left !important;}
		.dropdown-menu {z-index: 1001 !important;}
		#mslist_ms_employee { right: 0 !important; }
		.rating_container {font-size: 1.3em;}		
		.rating_container .glyphicon {top: 4px;}
		.rating_preset{padding: 0 2px;}
		.list_container { position: absolute; right: 0px; }
		.list_container ul { display: inline; list-style: none; padding: 0 10px 0 0; }
		.list_container ul li { float: left; margin: 0 5px; }
		.list_container ul li i { font-size: 1.2em; }		
			.progress_icon {
			position: absolute; 
			margin-top: 16.5%; 
			margin-left: 43.35%;  
			z-index: 2147483647;
		}
		.blackboard {
			position: absolute; 
			width: -webkit-fill-available; 
			height: -webkit-fill-available; 			
			background: #000; 
			opacity: 0.2; 
			z-index: 2147483647;
		}
		.reactivation_logs .on, .reactivation_logs .off { top: 4px; } /*add new 04/04/2018*/
		.reactivation_collapse {
			position: absolute;
		    right: 10px;
		    top: 12px;
		    cursor: pointer;
		    font-size: 1.3em;
		}

		.handleDefendForum {
		    top: 25px;
		    right: 16px;
		    max-width: 0;
		    max-height: 0;
		    color:#fff;
		    overflow: hidden;
		    background:#FFF;
		    opacityi: 0;
		     transition: all .5s ease-in-out;
		    -webkit-transition: all .5s ease-in-out;
		    display: none;
		}
		
		.handleDefendForum.open {
			top: 25px;
		    right: 16px;
		    z-index: 1;    
		    width: 350px;
		    max-width: 350px;
		    height: 300px;
		    min-height: 300px;
		    position: absolute;
		    border: 1px solid #D1D1D1;
		    padding: 8px;
		    display: block;
		}
		
		.handleDefendForum textarea.form-control {
			width: 100%;
			min-width: 335px;
			max-width: 335px;
			min-height: 135px;
			max-height: 135px;
		}
		
		.formDefendForum {
		    font-size: 14px;
		}
		
	</style>
	<style type="text/css" media="print">
		.nonprint{display:none}.printable{display:block!important}.btn,.note-toolbar{display:none!important}.btn{height:auto;min-height:100%;overflow-y:hidden;margin-top:-20px}@media print{#grid_pager,body.modal-open>#defend_container{display:none}.panel-danger>.panel-heading,.panel-primary>.panel-heading,.panel-success>.panel-heading,i.cacolor,i.compcolor,i.def1color,i.def2color,i.lbcolor,span.badge.bg-amber{-webkit-print-color-adjust:exact}body{font-size:12px!important}.flaticon-phone21{font-size:10px}body.modalprinter *{visibility:hidden}body.modalprinter .modal-dialog.focused{position:absolute;padding:0;margin:0;left:0;top:0}span.badge.bg-amber{background-color:#F0A30A!important;color:#FFF!important}i.lbcolor{color:#E3C800!important}i.def1color{color:#1BA1E2!important}i.cacolor{color:#60A917!important}i.def2color{color:#E51400!important}i.compcolor{color:#666!important}body.modalprinter .modal-dialog.focused .modal-content{border-width:0}body.modalprinter .modal-dialog.focused .modal-content .modal-body,body.modalprinter .modal-dialog.focused .modal-content .modal-body *,body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title{visibility:visible}body.modalprinter .modal-dialog.focused .modal-content .modal-body,body.modalprinter .modal-dialog.focused .modal-content .modal-header{padding:0}body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title{margin-bottom:20px}.print_notewidth{max-width:180px!important}.ui-jqgrid-bdiv{overflow:none;min-height:auto!important;height:100%!important}#panel_roothead_info{margin-top:0!important}.panel-primary>.panel-heading{background-color:#3070a9!important;color:#FFF}.panel-success>.panel-heading{background-color:#D7ECCE!important;color:#FFF}.panel-danger>.panel-heading{background-color:#EED5D5!important;color:#FFF}.actorTriggers{display:block;font-size:.9em;font-weight:400}}
	</style>
	
</head>

<?php $id_authority = !empty($session_data['emp_id']) ? $session_data['emp_id']:''; ?>
<?php $user_auth	= !empty($user_role) ? $user_role:''; ?>
<?php $icon_approve = !empty($approved_role['data'][0]['NEWBIE']) ? $approved_role['data'][0]['NEWBIE']:'N'; ?>
<?php $pilot_auth	= !empty($session_data['pilot']) ? implode($session_data['pilot'], ','):''; ?>

<body data-id="<?php echo $id_authority; ?>" data-role="<?php echo $user_auth; ?>" data-pilot="<?php echo (!empty($pilot_auth)) ? $pilot_auth:''; ?>" data-commit-approve="<?php echo $icon_approve; ?>">

<div id="status_detail" style="display: none;">
	<div><i class="fa fa-circle" style="color: #4390DF;"></i> Score-Pass (สามารถทำ RM Way ได้)</div>
	<div><i class="fa fa-circle" style="color: #199a11;"></i> ส่งประเมินแล้ว</div>
	<div><i class="fa fa-circle" style="color: #fa6800;"></i> รับเล่มประเมินแล้ว</div>
	<div><i class="fa fa-circle" style="color: red;"></i> หนังสือรับรองกรรมสิทธิสิ่งปลูกสร้างไม่สมบูรณ์</div>
</div>
	
<div id="defend_container" ng-controller="defendDashboard">

	<div class="progress_icon animated fadeIn" ng-class="{ 'hide' : !progress }">
		<img src="<?php echo base_url('img/378_1.gif'); ?>">
	</div>
	<div class="blackboard" ng-class="{ 'hide' : !progress }"></div>

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

	<div class="nonprint text-center"><h3>DEFEND DASHBOARD</h3></div>

	<div class="list_container">
		<ul>
			<li><i class="fa fa-circle" style="color: #555555;"></i> DRAFT</li>
			<li><i class="fa fa-circle" style="color: #E3C800;"></i> RM SUBMIT</li>
			<li><i class="fa fa-circle" style="color: #1BA1E2;"></i> MGR PRESCREEN</li>			
			<li><i class="fa fa-circle" style="color: #60A917;"></i> CA</li>
			<li><i class="fa fa-circle" style="color: #E51400;"></i> RETURN</li>
		</ul>
	</div>

	
	<div class="col-md-5 pull-left" style="position: absolute; margin-top: 40px;">
		<span id="paging_topper" class="nonprint">{{ pagingInfo }}</span>
		<span id="refresh_pages" ng-click="gridSearch()" class="nonprint fg-lightBlue" style="float: right; margin-top: -5px; margin-right: 25px; cursor: pointer;">
			<i class="fa fa-refresh on-left" style="font-size: 1.2em;"></i> 
			<span>REFRESH</span>
		</span>
	</div>
	
	<span class="dd_read_tool" style="margin-right: 120px;">
		<ul>
			<li class="collaspe">
				<a href="#" class="btn"><i class="ti-book" style="font-size: 1.4em;"></i></a>	
				<ul>
					<li>
						<a href="<?php echo base_url('PCIS Handbook/PCIS Defend Management.pdf'); ?>" target="_blank" style="line-height: 46px;">
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
	
	<div class="col-md-7 nonprint pull-right" style="position: absolute; z-index: 1000; right: 0; margin-top: 20px;">
		<div class="panel panel-lightBlue">
		
			<div id="panel_parent" class="panel-heading bg-lightBlue fg-white panel-collapsed" ng-click="panel_collapsed('panel_parent')">
				<h3 class="panel-title">FILTER CRITERIA</h3>
				<span class="pull-right clickable"><i class="fa fa-chevron-circle-down"></i></span>
			</div>
			
			<div class="panel-body fg-black" style="display: none; padding: 0 15px;">
				<div class="row">
				
					<div class="col-md-4" style="padding: 6px 0 0 25px;">
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
					</div>
					
					<div class="col-md-8 padding_none">
						<div class="col-md-3 pull-right" style="padding: 0 5px;">
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
						
						<div class="col-md-3 pull-right" style="padding: 0 5px;">
							<label>Branch</label>
							<select id="ms_branch" 									
                               		name="ms_branch"
                                	ng-model="param.branch_list"
                                	config="multi_config"
                                	data="masterdata.branch"
                                	ng-options="option.BranchCode as option.BranchName disable when option.BranchCode == '000' for option in masterdata.branch"
                                	ng-change="onBranchChange()"
                                	ng-disabled="branch_filter"
                                	multi-select multiple="multiple"
                                	style="width: 129.66px">
                        	</select>
						</div>
						
						<div class="col-md-3 pull-right" style="padding: 0 5px;">
							<label>Area</label>
							<select id="ms_area" 									
                               		name="ms_area"
                                	ng-model="param.area_list"
                                	config="multi_config"
                                	data="masterdata.area"
                                	ng-options="option.AreaName as option.AreaName disable when option.AreaName == 'HQ' for option in masterdata.area" 
                                	ng-change="onAreaChange()"
                                	ng-disabled="areaes_filter"
                                	multi-select 
                                	multiple="multiple"
                                	style="width: 129.66px">
                        	</select>
						</div>
											
						<div class="col-md-3 pull-right" style="padding: 0 5px;">
							<label>Region</label>
							<select id="ms_region" 									
                               		name="ms_region"
                                	ng-model="param.region_list"
                                	config="multi_config"
                                	data="masterdata.region"
                                	ng-options="option.RegionID as option.RegionNameEng for option in masterdata.region" 
                                	ng-change="onRegionChange()"
									ng-disabled="region_filter"
                                	multi-select 
                                	multiple="multiple"                                	
                                	style="width: 129.66px">
                        	</select>
						</div>
					</div>
										
				</div>
				<div class="row marginTop10">
					<div class="col-md-4">
						<label>Defend Date <small class="text-warning">(Range)</small></label>
						<input id="dateRange" name="dateRange" ng-model="param.defend_date" input-field-daterange type="text" value="" class="form-control">
					</div>	
					<div class="col-md-8 padding_none">
						<div class="col-md-3" style="padding: 0 5px;">
							<label>Status</label>
							<select id="ms_status" 									
                               		name="ms_status"
									ng-model="param.status"
									config="multi_config"
                                	data="masterdata.decisionca"
                                	ng-options="option.values as option.name for option in masterdata.decisionca"
                                	multi-select multiple="multiple">
									<option value=""></option>
							</select>
						</div>
						<div class="col-md-3" style="padding: 0 5px;">
							<label>CA Name</label>
							<input ng-model="param.ca_name" type="text" value="" class="form-control">
						</div>
						<div class="col-md-3" style="padding: 0 5px;">
							<label>App No</label>
							<input ng-model="param.app_no" type="text" value="" class="form-control">
						</div>		
						<div class="col-md-3" style="padding: 0 5px;">
							<label>Cust Name</label>
							<input ng-model="param.cust_name" type="text" value="" class="form-control">
						</div>							
					</div>		
				</div>
				<div class="row marginTop5 marginBottom10">				
					<div class="col-md-12 padding_none">
					
						<div class="col-md-4 pull-left">
							<label>Optional</label>
							<select id="ms_optional" 									
                               		name="ms_optional"
									ng-model="param.defend_list"
									config="multi_config"
                                	data="masterdata.optional"
                                	ng-options="option.values as option.name for option in masterdata.optional"
                                	multi-select multiple="multiple">
									<option value=""></option>
							</select>
						</div>
						
						<button class="btn btn-success pull-right marginTop25 marginRight5" ng-click="gridClear()">CLEAR</button>		
						<button class="btn btn-primary pull-right marginTop25 fg-white" ng-click="gridSearch()"><i class="fa fa-search" style="font-size: 1.3em;"></i> SEARCH</button>										
					</div>
					
				</div>				
			</div>
			
		</div>
	</div>
	
	<!-- sort-order="sortOrder" -->
	<ng-jq-grid config="config" jqgrid-group-header="thead_group" jqgrid-freeze-column="false" jqgrid-paging="pagingInfo"></ng-jq-grid>
	
	<!-- DOCUMENT MISSING MODAL -->
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
					<td>{{ item.LBSubmitDocDate.split(' ')[0] || 'รอส่งเอกสาร' | date:"dd/MM/yyyy"  }}</td>
					<td>
						{{ item.HQReceivedDocFromLBDate.split(' ')[0] || '' | date:"dd/MM/yyyy" }}
						<span ng-if="item.LBSubmitDocDate && !item.HQReceivedDocFromLBDate"}>รอรับเอกสาร</span>
					</td>
					<td>{{ item.SubmitDocToCADate.split(' ')[0] || '' | date:"dd/MM/yyyy" }}</td>
					<td><i class="fa fa-close fg-red"></i></td>
					<td><i class="fa fa-close fg-red"></i></td>
					<td><i class="fa fa-close fg-red"></i></td>
				</tr>
			</tbody>
		</table>      
		<div ng-if="progress">
			<i class="fa fa-spinner fa-pulse fa-2x fa-fw fg-darkCyan"></i><span>Loading...</span>
		</div>    
	</div>
	<div class="modal-footer nonprint marginBottom10"></div>
	</script>
	
	<!-- DEFEND MODAL -->
	<script id="modalDefendList.html" class="nonprint" type="text/ng-template">
	<div class="modal-header text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">

			<span ng-if="!issue_content.pilot" webui-tooltip-bundle config="webuiConfigBundle" data-content="Defend Forum" style="position: relative; display: inline-block;">
				<i ng-click="handleDefendForum()" class="fa fa-balance-scale modal-icon nonprint" style="font-size: 1.7em;" ng-class="{ 'hide': !forum_enable }"></i>
				<span class="badge badge_group bg-amber fg-white" ng-class="{ 'hide': !forum_enable }" style="position: absolute; margin-top: -38px;  margin-left: 15px; z-index: 10000;"> {{ forum_quenue || '0' }}</span>
				<div class="handleDefendForum {{ (forum_handle) ? 'open':'' }}">
					<div className="formDefendForum">
						<h4 class="fg-black">Defend Forum</h4>
						<div class="form-group"">				
							<label class="fg-black">กรุณากรอกข้อมูลรายละเอียด:</label>
							<textarea ng-model="forum_note" ng-disabled="(forum_accept == 'Y') ? true:false" ng-maxlength="4000" rows="6" class="form-control"></textarea>
						</div>
						<div class="checkbox checkbox-success checkbox-inline">
							<input type="checkbox" checklist-model="forum_accept" checklist-value="'Y'" ng-disabled="!forum_chkAcpt">							
                        	<label class="fg-black">ยืนยันการนำข้อมูลเข้า Defend Forum</label>							
                   		</div>
						<div class="marginTop20">	
							<button type="button" class="btn btn-danger btn-sm fg-white" ng-click="handleDeleteDefendForum(primarydata, issue_content)" ng-disabled="!forum_new || forum_submit">Delete Forum</button>
							<button type="button" class="btn btn-primary btn-sm fg-white pull-right" ng-click="handleSubmitDefendForum(primarydata, issue_content)" ng-disabled="!forum_submit">Confirm</button>						
  							<button type="button" class="btn btn-default btn-sm fg-black pull-right" ng-click="handleDefendForum()">Cancel</button>
						</div>
					</div>
				</div>
			</span>
			
			<span ng-if="!issue_content.pilot && icon_handle.MgrUnlockProcess" webui-tooltip-bundle config="webuiConfigHeader" data-content="<b>Defend Re-Process</b> - นำ Defend กลับมาแก้ไขใหม่">
				<i ng-click="re_process(primarydata)" class="fa fa-unlock modal-icon icon_blink nonprint" ng-class="{ 'hide' : !lock_handler }"></i>
			</span>

			<span ng-if="!issue_content.pilot" webui-tooltip-bundle config="webuiConfigHeader" data-content="<b>Defend Reactivation</b> - นำ Defend กลับมาทำใหม่">
				<i ng-click="unlock_process(primarydata)" class="fa fa-retweet modal-icon icon_blink nonprint" ng-class="{ 'hide' : !reactive_handler }"></i>
			</span>

			<span ng-if="!issue_content.pilot" webui-tooltip-bundle config="webuiConfigHeader" data-content="<b>RM Submit</b> - ส่งข้อมูลการ Defend ถึงหัวหน้าทีม">
				<span ng-if="icon_handle.RMRequestToMgr || icon_handle.MgrActionRequest" ng-click="requestSentApproveToManger(primarydata)" class="modal-icon nonprint" ng-class="{ 'hide' : lock_handler || reactive_handler }">	
					<i class="fa fa-user-circle" ng-class="{ 'wp-bind' : request_state }"></i>
					<span class="badge {{ (request_state) ? 'bg-green':'hide' }}" style="position: absolute; top: 25px; font-size: 0.4em; margin-left: -17px;">
						<i class="fa fa-share"></i>
					</span>
				</span> 
			</span>

			<span webui-tooltip-bundle config="webuiConfigHeader" data-content="<b>Manager Decision</b> - ส่วนบริหารจัดการข้อมูลของหัวหน้าทีม <br/>ประกอบด้วย: อนุมัติเคส/คืนงานกลับ RM/ยกเลิกการ Defend" ng-class="{ 'hide' : edit_enable }">
				<span ng-if="icon_handle.MgrSubmitToCA" ng-click="onDicisionConfirmDefend(issue_content, issue_content.header.SendAlreadyDefend)" class="modal-icon nonprint {{ (request_state && manager_handle) ? '':'hide' }}" ng-class="{ 'hide' : lock_handler || reactive_handler }">	
					<i class="fa fa-gavel"></i>
					<i class="fa fa-exclamation-circle fg-amber" ng-class="{ 'icon_blink_slow' : manager_handle }" style="position: absolute; top: 25px; font-size: 0.8em; margin-left: -17px;""></i>
				</span>
			</span>
			
			<a ng-href="{{ url_verify }}" target="_blank, _self">	
				<span webui-tooltip-bundle config="webuiConfigHeader" data-content="<b>P2</b> - หน้าแสดงรายละเอียดข้อมูลของลูกค้า">	
					<img src="<?php echo base_url('img/circle-icon-30.png'); ?>" class="modal-icon nonprint" style="height: 31px; margin-top: -18px;">
				</span>
			</a>

			<span ng-if="!issue_content.pilot" webui-tooltip-bundle config="webuiConfigLeft" data-content="<b>Print</b> - ปริ๊นเอกสารการ Defend">
				<i class="ti-printer modal-icon nonprint" ng-click="print_area('printHeader', 'issueContent', primarydata)"></i>
			</span>

			<span webui-tooltip-bundle config="webuiConfigLeft" data-content="<b>Close</b> - ปิดหน้าต่างข้อมูล">
				<i class="fa fa-close modal-icon nonprint" data-dismiss="modal" ng-click="dismiss_modal()"></i>
			</span>

		</div>

		<h4 id="modalLabel" class="modal-title">Defend Information :</h4>
		
	</div>
	<div id="issueContent" class="modal-body paddingLeft25 paddingRight25">

		<span class="place-right" style="position: absolute; right: 25px; top: 5px; font-size: 0.9em;">
			CREATE DATE: {{ issue_content.header.DefendDate | ddDate: "dd/MM/yyyy (HH:mm)" || ''  }}
	    </span>

		<!-- TITLE INFORMATION  -->
		<div id="panel_roothead_info" class="panel panel-primary marginTop10">
			<div class="panel-heading fg-white" style="position: relative;">
				INFORMATION
				<span class="fg-white" style="font-size: 90%;">(APP NO: {{ option_data.ApplicationNo || '' }})</span>	

				<span class="nonprint" webui-tooltip-bundle config="webuiConfigHeader" data-content="<b>Note Enabled</b> - เปิด/ปิด ข้อความการ Defend ที่ส่งให้กับทาง CA" style="position: absolute; top: 35px; margin-left: 10px;">
					<switch ng-model="defend_show_all" on="All" off="Hide" class="green"></switch>
				</span>
			
				<span class="pull-right nonprint" style="position: absolute; right: 15px; top: 27px;">

					<span class="fg-white nonprint" ng-class="{ 'hide' : lock_handler || reactive_handler }">
						ADD TOPIC : 
						<span webui-tooltip-bundle config="webuiConfigLeft" data-content="<b>Add Topic</b> - เพิ่มหัวข้อใหม่ที่ต้องการจะ Defend">
							<span class="badge nonprint" ng-class="{ 'bg-green' : !edit_enable, 'bg-red' : edit_enable }" ng-click="addNewTopic(issue_content, primarydata)" style="margin-top: -4px; cursor: pointer;">
								<i class="fa fg-white" ng-class="{ 'fa-plus' : !edit_enable, 'fa-close' : edit_enable }"></i>
							</span>
						</span>
					</span>
				</span>

			</div>
			<div class="panel-body" style="padding: 15px 15px 5px 15px;">
			
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
						<label class="col-xs-12 col-md-12">
							<i class="fa fa-university" style="margin-left: 0px; font-size: 1.2em;"></i>  
							<span class="fontNornmal" class="tooltip-right" data-tooltip="ธุรกิจ / กิจการเกี่ยวกับ {{ issue_content.header.Business || '' }}">ประเภทธุรกิจ: {{ issue_content.header.BusinessType  || '' }}</span>
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
							<i class="fa fa-file-pdf-o iconcustom marginLeft5" ng-class="{ 'hide' : !lock_handler }" ng-click="openFileItems(option_data.ApplicationNo)"></i>
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
		<!-- END TITLE INFORMATION  -->

		<!-- DEFEND ZONE -->
		<div ng-repeat="issueItem in issue_content.subscription track by $index">
			<div class="panel marginTopEasing10" ng-class="{ 'panel-primary': !issueItem.topic_default, 'panel-danger': issueItem.topic_default, 'hide': !issueItem.topic_active }" style="position: relative;">
				
				<div class="panel-heading" ng-class="{ 'fg-white': !issueItem.topic_default }">
					<span class="nonprint" ng-show="issueItem.subItems" webui-tooltip-bundle config="webuiConfigBundle" data-content="{{ issueItem.subItems }}">
						<i class="fa fa-language on-left on-right" style="font-size: 1.2em; cursor: pointer;"></i>
					</span>

					{{ issueItem.DefendReason }} {{ issueItem.DefendTitleOption || '' }} 
				
					<span ng-show="issueItem.DefendCode == 'SP002' && option_data.Remark !== ''" class="f1em">{{ ( option_data.Remark &&  option_data.Remark !== '') ? ' (Diviate Reason:' + option_data.Remark + ')' : '' }}</span>
					<span ng-show="business_desc && issueItem.DefendCode == 'SP001'" class="f1em">{{ business_desc }}</span>

					<span class="nonprint hide" webui-tooltip-bundle config="webuiConfigHeader" data-content="<b>Note Enabled</b> - เปิด/ปิด ข้อความการ Defend ที่ส่งให้กับทาง CA" style="position: absolute; top: 35px; margin-left: 10px;">
						<switch ng-model="issueItem.topic_logs" disabled="!defend_show_all" on="Show" off="Hide" class="green"></switch>
					</span>

					<div ng-if="!issue_content.pilot" class="btn-group btn-group-sm pull-right animated fadeIn nonprint" role="toolbar" style="margin-top: -7px;">

						<button type="button" class="btn btn-default" ng-click="rollback_topic(issueItem)" ng-class="{ 'animated fadeIn' : issueItem.isEditable, 'hide animated fadeOut' : !issueItem.isEditable }">
							<i class="fa fa-close fg-red iconcustom"></i>
						</button>

						<button ng-if="issueItem.topic_default" ng-disabled="lock_handler || reactive_handler || edit_enable" ng-class="{ 'hide' : lock_handler || reactive_handler }" ng-click="delete_topic(issueItem.DocID, [issueItem.DefendCode, issueItem.DefendReason], $index, primarydata)" type="button" class="btn btn-default marginRight5">
							<i class="fa fa-trash-o iconcustom"></i>
						</button>

						<button type="button" class="btn btn-default hide" ng-click="openDataHistory(issue_content.userinfo, issueItem);">
							<i class="fa fa-history iconcustom"></i>
						</button>

						<button type="button" ng-disabled="edit_enable" class="btn btn-default" ng-click="upload_model(issue_content.userinfo, issueItem)">
							<i class="fa fa-file-pdf-o iconcustom"></i>
							<span class="badge badge_group fg-white" ng-class="{ 'bg-amber' : (issueItem.NewFile == 0), 'bg-red' : (issueItem.NewFile > 0) }" style="position: absolute; margin-top: -10px; margin-left: -3px; z-index: 10000;"> {{ issueItem.NewFile || '0' }}</span>
						</button>

						<button type="button" class="btn btn-default" ng-click="save_enabled(issue_content.userinfo, issueItem)" ng-disabled="!issueItem.roleable[user_role]" ng-class="{ 'btn-save fg-white animated fadeIn' : issueItem.isEditable, 'hide animated fadeOut' : !issueItem.isEditable }">
							<i ng-class="{ 'fa fa-save iconcustom' : issueItem.roleable[user_role], 'fa fa-ban fg-crimson iconcustom' : !issueItem.roleable[user_role] }"></i>
						</button>

						<button type="button" class="btn btn-default" ng-click="edit_enabled(issue_content.userinfo, issueItem, ($index+1))" ng-disabled="lock_handler || reactive_handler || !issueItem.isTopicSpecified || !issueItem.roleable[user_role]"  ng-class="{ 'animated fadeIn' : !issueItem.isEditable, 'hide animated fadeOut' : issueItem.isEditable }">
							<i ng-class="{ 'fa fa-edit iconcustom' : issueItem.isTopicSpecified, 'fa fa-ban fg-crimson iconcustom' : lock_handler || reactive_handler || !issueItem.isTopicSpecified }"></i>
						</button>

					</div>
				</div>
				<!-- ng-keydown="setup_editor($event, issueItem.DefendNote)"  -->
				<div class="panel-body padding_none" ng-class="{ 'nonprint': !issueItem.DefendNote && !issueItem.DefendNoteLog }">
					<text-angular ng-model="issueItem.DefendNote" name="issue_itemnote_{{ $index+1 }}" ta-paste="strip_html_tags($html)"  ta-disabled="issueItem.isDisabled" ta-max-text="40000" ng-class="{ 'locked' : issueItem.isDisabled, 'nonprint': !issueItem.DefendNote }"></text-angular>
					<text-angular ng-model="issueItem.DefendNoteLog" ta-target-toolbars="false" ta-disabled="true" ng-class="{ 'hide' : !issueItem.dataLogsable || !defend_show_all, 'nonprint': !issueItem.DefendNoteLog }"></text-angular>
				</div>

			</div>
		</div>
		<!-- END DEFEND ZONE -->

		<!-- ZONE LOGS -->		
		<div class="reactivation_logs" ng-class="{ 'hide': !reactive_haslog }">
			<div style="position: relative; display: -webkit-inline-box;height: 50px;">	
				<h5 ng-class="{ 'nonprint' : !defend_reactive }">REACTIVATION HISTORY</h5>
				<span class="nonprint" webui-tooltip-bundle config="webuiConfigHeader" data-content="<b>Note Enabled</b> - เปิด/ปิด ประวัติข้อความการ Defend" style="position: absolute; top: 5px; left: 180px;">
					<switch ng-model="defend_reactive" on="All" off="Hide" class="green"></switch>
				</span>
			</div>
			<div style="position: relative;" ng-class="{ 'hide' : !defend_reactive }">				
				<div ng-repeat="items in issue_content.react_logs track by $index">
					<div class="panel panel-default marginTopEasing10" style="position: relative;">
						<div class="panel-heading" style="position: relative;" ng-click="handleReactivatedCollapse(items)">
							{{ items.DefendName }}
							<i class="fa fa-chevron-circle-down reactivation_collapse nonprint" ng-class="{ 'fa fa-chevron-circle-down': !items.DefendVisible, 'fa fa-chevron-circle-up': items.DefendVisible }" aria-hidden="true"></i>
						</div>
						<div class="panel-body padding_none" ng-class="{ 'hide': !items.DefendVisible }">
							<div ng-repeat="list in items.DefendList">
								<text-angular ng-model="list.DefendNote" ta-target-toolbars="false" ta-disabled="true"></text-angular>
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>

	</div>
	<div class="modal-footer nonprint marginBottom10"></div>
	</script>
	
	<!-- UPLOAD ITEMS -->
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

					<article class="marginTopEasing30" style="{{ (lock_handler || reactive_handler) ? 'margin-top: 0px !important':''; }}">	
						<div class="pull-right tooltip-left" data-tooltip="Upload Files" ng-class="{ 'hide' : lock_handler || reactive_handler }">
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
											<small class="col-md-12 padding_none">Upload date {{ files.CreateDate | ddDate: "dd/MM/yyyy (HH:mm)" || '' }}</small>
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
	
	<script id="modalDecisionConfirmDefendList.html" class="nonprint" type="text/ng-template">
	<div class="modal-header nonprint text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">Decision Management</h4>
	</div>
	<div class="modal-body nonprint paddingLeft25 paddingRight25">
		 <div class="row">
			<span class="rating_container" ng-class="{ 'hide' : topic_item !== decision_list.mgrCommit && topic_item !== decision_list.mgrReturn }">
				<span style="font-weight: bold; font-size: 0.7em !important;">โปรดเลือกคุณภาพ : </span>
				<span uib-rating 
					  ng-model="rate" 
					  max="max" 
                      read-only="isReadonly" 
					  on-hover="hoveringOver(value)" 
					  on-leave="overStar = null" 
					  titles="['1','2','3','4','5']" 
					  ng-class="{
						  'fg-red': percent < 30, 
					      'fg-amber': percent >= 30 && percent < 50, 
						  'fg-darkCyan': percent >= 50 && percent < 70, 
						  'fg-green': percent >= 70 && percent < 90, 
						  'fg-emerald': percent >= 90
					  }"
					  aria-labelledby="default-rating">
				</span>
				<span class="label" 
					  ng-class="{
						  'bg-red fg-white': percent < 30, 
					      'bg-amber fg-white': percent >= 30 && percent < 50, 
						  'bg-darkCyan fg-white': percent >= 50 && percent < 70, 
						  'bg-green fg-white': percent >= 70 && percent < 90, 
						  'bg-emerald': percent >= 90
					  }" 
					  ng-show="overStar && !isReadonly"> {{percent}}%</span>
			</span>
			<h6 style="font-weight: bold;">โปรดเลือกรายการ :</h6>
			
			<label class="radio-inline">
  				<input type="radio" ng-model="topic_item" value="{{ decision_list.mgrCommit }}"> ส่งข้อมูลถึงทีม CA
			</label>
			<label class="radio-inline">
  				<input type="radio" ng-model="topic_item" value="{{ decision_list.mgrReturn }}"> ส่งคืนเจ้าของเคส (ข้อมูลสนับสนุนไม่เพียงพอ)
			</label>
			<label class="radio-inline">
  				<input type="radio" ng-model="topic_item"  value="{{ decision_list.mgrCancel }}"> ยกเลิกรายการข้อมูล
			</label>

			<div class="col-md-8 paddingTop20 paddingLeft_none" ng-class="{ 'hide' : !topic_text_handle }">
				<label>โปรดระบุเหตุผล:</label>
				<textarea ng-model="topic_remark" class="form-control" rows="3"></textarea>
			</div>

  		</div>		
	</div>
	<div class="modal-footer nonprint marginBottom10 padding_none">		 
  		<button type="button" class="btn btn-default btn-sm marginTop10" ng-click="dismiss_modal()">ยกเลิก</button>
		<button type="button" class="btn btn-primary btn-sm marginTop10 marginRight10 fg-white" ng-click="onSubmit([topic_item, topic_remark], primarydata)" ng-disabled="$scope.rate == 0 || btnsave_enable">ตกลง</button>
	</div>
	</script>
	
	<script id="modalAddNewTopicList.html" class="nonprint" type="text/ng-template">
	<div class="modal-header nonprint text-uppercase bg-darkCyan fg-white" style="padding-right: 5px !important;">
		<div class="btn-toolbar pull-right" role="toolbar">
			<i class="fa fa-close modal-icon" data-dismiss="modal" ng-click="dismiss_modal()"></i>
		</div>
		<h4 id="modalLabel" class="modal-title">Defend Reason</h4>
	</div>
	<div class="modal-body nonprint paddingLeft25 paddingRight25">
		<div class="grid">
			<div id="defend_content">
				<div class="row">
					<div class="col-md-4" ng-repeat="items in master_defend.category track by $index">
						<div class="checkbox checkbox-success checkbox-inline padding5">
							<input type="checkbox" checklist-model="checkboxItemList.items" checklist-value="items.MainCode" ng-disabled="items.isDisabled">							
                        	<label>
								<span webui-tooltip-bundle config="webuiConfigBundle" data-content="{{ items.subItems }}">
									{{ ($index + 1) }}. {{ items.MainReason }}
								</span>
							</label>							
                   		</div>
					</div>
				</div>
			</div>
		</div>	   
	</div>
	<div class="modal-footer nonprint marginBottom10 padding_none" style="position: relative;">		 
		<div style="font-size: 0.9em; position: absolute; left: 25px; top: 15px;">
	    	หมายเหตุ: สามารถวางเมาส์บนหัวข้อที่ท่านต้องการเพื่อทราบความหมาย (กรณีรายการไม่แสดงให้นำเมาส์ออกและวางใหม่อีกครั้ง)
	    </div>
  		<button type="button" class="btn btn-default btn-sm marginTop10" ng-click="dismiss_modal()">ยกเลิก</button>
		<button type="button" class="btn btn-primary btn-sm marginTop10 marginRight10 fg-white" ng-click="onSubmit(checkboxItemList.items, primaryData)" ng-disabled="btnDisabled">ตกลง</button>
	</div>
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
			<span ng-if="headinfo.BorrowerName !== ''">Borrower Name :  {{ headinfo.BorrowerName }}</span>
			<span ng-if="headinfo.AppNo !== ''"> / App No : {{ headinfo.AppNo }}</span>
		)
		</span>
	</div>
	<div class="modal-body paddingLeft25 paddingRight25" style="{{ modalHeight }};">
		<div class="nonprint">
			<scrollable-table>
			<table class="table table-bordered">
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
						<td style="text-align: center;">{{ list.ActionDateTime | ddDate: "dd/MM/yyyy (HH:mm)" || '&nbsp;' }}</td>
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
</body>
</html>