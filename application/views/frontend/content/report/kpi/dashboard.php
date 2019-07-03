<!DOCTYPE html>
<html lang="en" ng-app="chat-client">
<head ng-app>
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
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/bootstrap-checkbox.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/metro/iconFont.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/core/css/jquery.mmenu.all.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.themes.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.effects.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.borderstyle.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap.css'); ?>"> 	
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap-ui.css'); ?>"> 	
 	<link rel="stylesheet" href="<?php echo base_url('css/multi-select/multiple-select.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>"> 
 	<link rel="stylesheet" href="<?php echo base_url('css/animate/animate.min.css'); ?>">  
 	<link rel="stylesheet" href="<?php echo base_url('css/notifIt/notifIt.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/themify-icons.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/flaticon/flaticon.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/focal-point.min.css'); ?>"> 
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/mmenu.css'); ?>">	
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/wp.custom.css'); ?>">	
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/tooltip_custom.css'); ?>">	
 	
 	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('js/kpi_present_filter/css/elements.css'); ?>"></link>
    <link rel="stylesheet" href="<?php echo base_url('js/kpi_present_filter/css/antd.min.css'); ?>"></link>
    <link rel="stylesheet" href="<?php echo base_url('js/kpi_present_filter/css/kpi_present_filter.min.css'); ?>"></link>
 	
 	<!-- Include for Chat -->
 	<link rel="stylesheet" href="<?php echo base_url('css/googlefont.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/clndr/material-design-iconic-font/css/material-design-iconic-font.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/notification/angular-ui-notification.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/angular_1.5/angular-material.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/clndr/snarl/snarl.min.css'); ?>">
   	<link rel="stylesheet" href="<?php echo base_url('js/clndr/chat-client.css'); ?>">
	<!-- End Chat Style -->
 	
 	<style type="text/css">

 		#bs-nav, #bs-nav a, #bs-nav span:not(.ng-scope), #bs-nav span:not(.ng-binding) { 
 			color: #FFF;
 			background: #4390df; 
 		}
 		
 		.navbar-toggle > span { color: #FFF !important; }
 	
	 	div.navbar a {
	    	display: inline-block;
	    	background: #4390df;
		}		
		
		.navbar li.divider-vertical {
			height: 30px;
			margin: 12px 5px;
			border-left: 1px solid #f2f2f2 !important;
			border-right: 1px solid #ffffff !important;
			opacity: 0.5;
		}
		
		.table > tbody > tr.active>td, 
		.table > tbody > tr.active>th, 
		.table > tbody > tr > td.active, 
		.table > tbody > tr > th.active { color: red !important; }
		 
		body {
			font-size: 1.2em !important;
			font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
		}
		
		@media screen and (-webkit-min-device-pixel-ratio:0) { 
		
			.icon_trend {
				position: absolute; 
				font-size: 1.5em; 
				margin-left: 0.1em !important;	
			}

		}
		
		span.fa { 
			font-family: FontAwesome !important; 
		}
		
		#ie_icon_trend {
			position: absolute; 
			font-size: 1.5em; 
			margin-left: 0;	
		}
		
		#grid_container { color: #666; }
		
		#grid_container table td:ntd-child(9) {
			background: #d6f9ff; /* Old browsers */
			background: -moz-linear-gradient(top,  #d6f9ff 0%, #9ee8fa 100%); /* FF3.6-15 */
			background: -webkit-linear-gradient(top,  #d6f9ff 0%,#9ee8fa 100%); /* Chrome10-25,Safari5.1-6 */
			background: linear-gradient(to bottom,  #d6f9ff 0%,#9ee8fa 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d6f9ff', endColorstr='#9ee8fa',GradientType=0 ); /* IE6-9 */
						  
		}

		#grid_containerghead_0_0 td, #grid_containerghead_0_1 td, #grid_containerghead_0_2 td, #grid_containerghead_0_3 td,
		#grid_containerghead_0_4 td, #grid_containerghead_0_5 td, #grid_containerghead_0_6 td, #grid_containerghead_0_7 td,
		#grid_containerghead_0_8 td, #grid_containerghead_0_9 td, #grid_containerghead_0_10 td, #grid_containerghead_0_11 td {
			padding-left: 0px !important;
 			background: #e2f1ff !important;
			font-weight: bold;
			text-transform: uppercase;
		}
		
		.grid_containerghead_0 { background: #e2f1ff; }

		table#grid_container td:nth-child(12), table#grid_container td:nth-child(13),
		table#grid_container td:nth-child(14), table#grid_container td:nth-child(15), table#grid_container td:nth-child(16),	 
		
		table#grid_container td:nth-child(22), table#grid_container td:nth-child(23), table#grid_container td:nth-child(24), 	
		table#grid_container td:nth-child(28), table#grid_container td:nth-child(29), table#grid_container td:nth-child(30),
		table#grid_container td:nth-child(34), table#grid_container td:nth-child(35), table#grid_container td:nth-child(36),
		table#grid_container td:nth-child(40), table#grid_container td:nth-child(41), table#grid_container td:nth-child(42),
		table#grid_container td:nth-child(46), table#grid_container td:nth-child(47), table#grid_container td:nth-child(48),
		table#grid_container td:nth-child(52), table#grid_container td:nth-child(53), table#grid_container td:nth-child(54),
		table#grid_container td:nth-child(58), table#grid_container td:nth-child(59), table#grid_container td:nth-child(60)  {
			background: #e2f1ff;	
			z-index: 1;							  
		}
		
		#grid_container_Region, #grid_container_Lending, #grid_container_YTDInfo,	
		#grid_container_YTDTarget, #grid_container_YTDActual,
		#grid_container_YTDAVGActual, #grid_container_YTDAchieve, 
		#grid_container_CM_Target, 
		#grid_container_DecActual, #grid_container_DecAchieve, #grid_container_DecInfo,
		#grid_container_NovActual, #grid_container_NovAchieve, #grid_container_NovInfo,
		#grid_container_OctActual, #grid_container_OctAchieve, #grid_container_OctInfo,
		#grid_container_SepActual, #grid_container_SepAchieve, #grid_container_SepInfo,
		#grid_container_AugActual, #grid_container_AugAchieve, #grid_container_AugInfo,
		#grid_container_JulActual, #grid_container_JulAchieve, #grid_container_JulInfo,
		#grid_container_JunActual, #grid_container_JunAchieve, #grid_container_JunInfo,
		#grid_container_MayActual, #grid_container_MayAchieve, #grid_container_MayInfo,
		#grid_container_AprActual, #grid_container_AprAchieve, #grid_container_AprInfo,
		#grid_container_MarActual, #grid_container_MarAchieve, #grid_container_MarInfo,
 		#grid_container_FebActual, #grid_container_FebAchieve, #grid_container_FebInfo,
		#grid_container_JanActual, #grid_container_JanAchieve, #grid_container_JanInfo {
			font-size: 0.9em !important; 
		}
		
		#grid_container_YTDTarget_LY, #grid_container_YTDActual_LY, #grid_container_YTDAVGActual_LY, #grid_container_YTDAchieve_LY, 
		#grid_container_DecActual_LY, #grid_container_DecAchieve_LY, #grid_container_DecInfo_LY,
		#grid_container_NovActual_LY, #grid_container_NovAchieve_LY, #grid_container_NovInfo_LY,
		#grid_container_OctActual_LY, #grid_container_OctAchieve_LY, #grid_container_OctInfo_LY,
		#grid_container_SepActual_LY, #grid_container_SepAchieve_LY, #grid_container_SepInfo_LY,
		#grid_container_AugActual_LY, #grid_container_AugAchieve_LY, #grid_container_AugInfo_LY,
		#grid_container_JulActual_LY, #grid_container_JulAchieve_LY, #grid_container_JulInfo_LY,
		#grid_container_JunActual_LY, #grid_container_JunAchieve_LY, #grid_container_JunInfo_LY,
		#grid_container_MayActual_LY, #grid_container_MayAchieve_LY, #grid_container_MayInfo_LY,
		#grid_container_AprActual_LY, #grid_container_AprAchieve_LY, #grid_container_AprInfo_LY,
		#grid_container_MarActual_LY, #grid_container_MarAchieve_LY, #grid_container_MarInfo_LY,
 		#grid_container_FebActual_LY, #grid_container_FebAchieve_LY, #grid_container_FebInfo_LY,
		#grid_container_JanActual_LY, #grid_container_JanAchieve_LY, #grid_container_JanInfo_LY {
			font-size: 0.9em !important; 
		}

		table#grid_container td:nth-child(22) { border-left: 0 }
	
		#grid_container_frozen table, tr, td { z-index: 999; background-color: #FFF; }
	
		#present { cursor: pointer; }
		
		.IRotate {
			-moz-transform: rotate(180deg);
			-ms-transform: rotate(180deg);
			-o-transform: rotate(180deg);
			-webkit-transform: rotate(180deg);
		}
		
		.ui-jqgrid .loading {
	        background: url(<?php echo base_url('img/378_1.gif'); ?>);
	        background-position: top 5px left 10px;
		    background-repeat: no-repeat;
		    border-style: none;	 
	        height: 130px;
	        width: 255px;
	      
    	}
   
   		#ui_notifIt p { font-size: 16px !important; font-weight: normal; }
    	#ui_notifIt.success { margin-top: -6px; }
    	    	
    	/* Override Chat style 
    	.chat-modal div, .chat-modal span, .chat-modal p, .chat-modal ul, .chat-modal ol {
		    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif !important;
		    font-weight: 400; 
		    line-height: normal;
		}
		*/
    	
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
		
		.nav_icon {
			cursor: pointer;			  
			margin-top: 17px;
			margin-right: 12px;
			margin-left: 12px;
			font-size: 1.8em !important;
		}
	
		a[class*="lv"] {
			color: #000 !important; 
			background-color: #FFF !important;
		}
		
		.chat-state {
		    position: absolute !important;
		    top: 13px;
		    left: 77px;
		    z-index: 1002;
		}
		
		.tmn-counts { padding-top: 2px !important; }
		
		img[icon-attr^="outlook"],		
		img[icon-attr^="yammer"] { opacity: 1 !important;  }
		div.submenu_hover:hover { background: #1B6EAE;}
		i[icon-attr^="people"] { position: absolute; z-index: 10008; margin-top: -20px; opacity: 1 !important; }
		
		.modal-icon {
			font-size: 2em; 
			margin-top: -5px;
			margin-right: 15px;
			padding-top: 5px;
			cursor: pointer;
		}
		
		.modal-content {
		   top: 0px !important;
		   width: 100%;
		   min-width: 800px !important;
		   margin: 0;
		   margin-right: auto;
		   margin-left: auto;
		   border-radius: 0px !important;
		   
		}
		
		.modal-body.modal-body-custom {
			padding: 10px 15px 3px 10px !important;
		}
		
		.tc { text-align: center !important; }
		
		.radio_handle .radio {
			margin-top: 0px !important;
			padding-left: 5px;
		}
		
		.modal-footer-customer {
			padding: 5px !important;
		}
					
 	</style>
 	<script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery-ui.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.mousewheel.js'); ?>"></script>
	<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/moment.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/plugin/mmenu/core/js/jquery.mmenu.min.all.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugin/mmenu/addons/js/jquery.mmenu.offcanvas.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugin/notifIt/notifIt.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.rotate.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/build/chart/treeview_menu.js'); ?>"></script>
	<script src="<?php echo base_url('js/jqGrid/js/i18n/grid.locale-en.js'); ?>" type="text/ecmascript" ></script>  
	<script src="<?php echo base_url('js/jqGrid/js/jquery.jqGrid.min.js'); ?>" type="text/ecmascript" ></script>
	<script src="<?php echo base_url('js/chart/sparkline/jquery.sparkline.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
	
	<!-- START INCLUDE CHAT SCRIPT -->
	<!-- START INCLUDE CHAT SCRIPT -->
	<script src="<?php echo base_url('js/angular/angular_1.5/angular.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-animate.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-aria.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-messages.min.js'); ?>"></script>
	
	<!-- Angular Material Library -->
    <script src="<?php echo base_url('js/clndr/angular-material.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/jquery.slimscroll.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/moment-with-locales.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/bundle/lodash.min.js'); ?>"></script>
    
	<script src="<?php echo base_url('js/angular/angular-sanitize.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/ui-bootstrap-tpls-1.1.2.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/notification/angular-ui-notification.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/readmore.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/ion.sound.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/socket.io.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/snarl/snarl.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/clndr/bootstrap-multiselect.js'); ?>"></script>	
	<script src="<?php echo base_url('js/vendor/jquery.multiple.select.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/chat-client.js?v=004'); ?>"></script>	
	<script src="<?php echo base_url('js/build/collection/collection_script.js?v=007'); ?>"></script>	
	<script src="<?php echo base_url('js/md5/md5.js'); ?>"></script>	
	<!-- END INCLUDE CHAT SCRIPT -->
	
</head>
<body data-page="kpi">

<div id="element_session">

	<?php 
	
		if($_GET['editor'] === md5('true') && $_GET['permission'] === md5('true')):
			$id_authority = !empty($_GET['rel']) ? $_GET['rel']:$session_data['emp_id'];
		else:
			$id_authority = !empty($session_data['emp_id']) ? $session_data['emp_id']:'';
		endif;
		
		$tempuser = '99999';
		$subuser  = '';
		if(!empty($_GET['relsub'])) {
			if($_GET['relsub'] !== $tempuser):
				$subuser = $id_authority;
			else:
				$subuser = '57251';
			endif;
		} else {
			$subuser = $id_authority;
		}
		
	?>
	
	<input id="profiler" name="profiler" type="hidden" value="<?php echo ($id_authority !== $tempuser) ? $id_authority:'57251'; ?>">
	<input id="emp_id" name="emp_id" type="hidden" value="<?php echo !empty($subuser) ? $subuser:$id_authority; ?>">
	<input id="branchCode" name="branchCode" type="hidden" value="<?php echo $session_data['branchcode']; ?>">
	<input id="areaCode" name="areaCode" type="hidden" value="">
	<input id="event_mode" name="event_mode" type="hidden" value="individual">
	<input id="authCode" name="authCode" type="hidden" value="<?php echo !empty($session_data['auth'][0]) ? implode(',', $session_data['auth']):''; ?>">
	
	<input id="position_title" name="position_title" type="hidden" value="">
</div>

<div id="bs-nav" class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mm-navbar-collapse" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </button>
	    	<a class="navbar-brand" href="#menu" style="margin-top: 2px !important;">
				<span id="mm-panels" class="tooltip-right" data-tooltip="Open Panel">
					<img id="sidebar_icon" src="<?php echo base_url('img/panel.png'); ?>" style="font-size: 1.2em; z-index: 999;">
				</span>
			</a>					
		</div>
		<div id="mm-navbar-collapse" class="collapse navbar-collapse">
			 <ul class="nav navbar-nav">
	        	<li class="divider-vertical"></li> 
	        	<li>
	        		<!-- target="_blank" <?php echo site_url('report/dashboardchart'); ?>?rel=<?php echo !empty($_GET['rel']) ? $_GET['rel']:$session_data['emp_id']; ?> -->
	        		<a id="chart_ref" href="#">
	        			<span class="tooltip-right" data-tooltip="Overview Chart (maintenance)">
	        				<i class="fa fa-bar-chart fa-2x"></i>
	        			</span>	        			
	        		</a>
	        		<span id="btnSwitcher"></span>		        		     	
	        	</li>
	        </ul>
	        <ul class="nav navbar-nav navbar-right">	  
	        	<li><div class="marginTop5" ui-chat-client="<?php echo $id_authority; ?>" direct-chat-click="direct_chat" direct-chat-to="<?php echo $id_authority; ?>" chat-dialog-position="right" chat-status="chat_state"></div></li>	        	
	        	<li class="divider-vertical" style="margin-right: -2px;"></li>       
		    	<li><span id="direct_chat" class="using_information"></span></li>
      		</ul>	
      	</div>		
	</div>
</div>

<div id="page">
	
	<div class="content">		
	
		<span id="show_ytd_lastyear" class="tooltip-top" data-tooltip="The previous year (open)" style="cursor: pointer; position: absolute; margin-top: 5px; margin-left: 357px; z-index: 800;">
 			<img id="icon_openYTDHistory" src="<?php echo base_url('img/panel.png'); ?>" style="font-size: 1.2em; transform: rotate(0deg); transform-origin: 50% 50% 0px; height: 20px;">
 		</span>
 		
 		<!-- Table Content  -->
		<table id="grid_container" class="table table-bordered"></table>			
		<div id="page_container"></div>
				
	</div>
	
	<nav id="menu" class="mm-panel-fix">
		<?php $this->load->view('frontend/content/report/kpi/sidebar_left'); ?>
	</nav>

</div>

<?php 
	$auth_test = $this->config->item('MISTeam');
	if(in_array($session_data['emp_id'], $auth_test)):
		$auth_block = "";
	else:
		$auth_block = 'disabled="disabled"';
	endif;
	
?>

<!-- Modal -->
<div class="modal fade" id="criteralModal" tabindex="-1" role="dialog" aria-labelledby="criteralModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">     
      <div class="modal-header" style="max-height: 50px; background: rgb(34, 185, 156); color: white; padding: 10px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	  <h4 class="modal-title" id="myModalLabel" style="font-size: 1em; color: #FFF;">FILTER CRITERIA</h4>
      </div>
      <div id="filter_modal_body" class="modal-body">

    	  <div class="row">
    	  	  <span class="col-md-12" style="position: absolute; margin-top: -10px; color: #286090;">
    	  	  	  <!-- <h4>KPI: Performance Summary</h4> -->
    	  	  	  <div class="col-md-6" style="height: 65px; padding-left: 0;">
    	  	  	  		<div class="radio radio-success">
	    	  	  	  		<input id="kpimode_1" name="kpimode" type="radio" value="kpi_summary" style="width: 17px; height: 17px;" onclick="kpiModeSwitch('kpi_summary')" checked>
						  	<label>KPI SUMMARY</label>
						</div>
						<div class="radio radio-success">						  
						    <input id="kpimode_2" name="kpimode" type="radio" value="kpi_present" style="width: 17px; height: 17px;" onclick="kpiModeSwitch('kpi_present')" <?php echo $auth_block; ?>>
						    <label>KPI FOR PRESENTATION
						  </label>
						</div>
    	  	  	  </div>
    	  	  	  <div class="col-md-2" style="height: 65px;"></div>
    	  	  	  <div class="col-md-4 tc" style="height: 65px;">
	    	  	  	  <div class="checkbox checkbox-success checkbox-inline" style="margin-top: 8px !important;">
			              <input id="graph_summary" name="graph_summary" type="checkbox" value="Y"> 
			              <label>Graph (All Month)</label>
			          </div>
			           <div class="form-group pull-right">
			              <!-- <label>Year</label> -->
			              <select id="filter_year" name="filter_year" class="form-control">
			              	<option value=""></option>
			              	<?php 
			              		$selected = '';
			              		for($i=(int)2016; $i <= (int)date('Y'); $i++) { 
			              			if($i == date('Y')) $selected = 'selected="selected"';
			              			echo '<option value="'. $i .'" ' . $selected . '>'. $i .'</option>';
			              		} 
			              	?>
			              </select> 
			          </div>
			       </div>
    	  	  </span>
    	  	  <div id="filter_kpisummary_content">
    	  	  	  <div class="col-md-2 marginTop50">
	    		  	  <div class="form-group" style="min-width: 140px;">
				      	 <label>Region</label>
				      	 <select id="filter_region" name="filter_region" multiple="multiple"></select>
				      </div>
	    		  </div>
				  <div class="col-md-2 marginTop50">
				      <div class="form-group" style="min-width: 140px; margin-left: 20px;">
				      	 <label>Area</label>
				      	 <select id="filter_area" name="filter_area" multiple="multiple"></select>
				      </div>
				  </div>
				  <div class="col-md-2 marginTop50">
				  	  <div class="form-group" style="min-width: 140px;  margin-left: 40px;">
				      	 <label>Branch</label>
				      	 <select id="filter_branch" name="filter_branch" multiple="multiple"></select>
				      </div>
				  </div>
				  <div class="col-md-2 marginTop50">
				  	<div class="form-group" style="min-width: 140px;  margin-left: 60px;">
				      	 <label>Employee</label>
				      	 <select id="filter_emp" name="filter_emp" multiple="multiple"></select>
				      </div>
				  </div>
				  <div class="col-md-2 marginTop50">
				  	  <div class="form-group" style="min-width: 140px;  margin-left: 80px;">
				      	 <label>Month</label>
				      	 <select id="filter_months" name="filter_months" class="form-control">
				      	 	<option value=""></option>
				      	 </select>
				      </div>
				  </div>
    	  	  </div>
    		  <div id="filter_kpipresent_content" style="margin-top: 50px; display: none;">
    		  	<div id="kpi_filter"></div>
    		  </div>			  
    	  </div> 
    	     
      </div>   
      <div id="filter_kpisummary_footer" class="modal-footer modal-footer-customer">
        <button type="button" class="btn btn-primary" onclick="getPDFPerformanceSummary()" style="color: #FFF; padding: 5px;"><i class="fa fa-search" style="font-size: 1.2em; margin-right: 5px;"></i>ACCEPT</button>
        <button type="button" class="btn btn-success" onclick="clearDataFilter()" style="min-width: 89px; padding: 5px; margin-left: 0;">CLEAR</button>
      </div>  
    </div>
  </div>
</div>

<script src="<?php echo base_url('js/build/chart/filter_masterload.js').'?v=002'; ?>"></script>
<script src="<?php echo base_url('js/kpi_present_filter/antd.min.js'); ?>"></script>
<script src="<?php echo base_url('js/kpi_present_filter/vendors.min.js'); ?>"></script>
<script src="<?php echo base_url('js/kpi_present_filter/kpi_present_filter.js?v=31052019'); ?>"></script>
	

<script type="text/javascript">

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
var pathRoot  = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
var query  = getQueryParams(document.location.search);

var url_path		= 'http://172.17.9.94/pcisservices/PCISService.svc/';
var urlGrid  		= url_path + "GetKPIWhiteBoardReport";
var urlProfile  	= url_path + "GetKPI00ProfileReport";

var limit_mth		= 3;
var url_site		= [pathArray[4]];
var jump_topic 		= [2, 4, 6, 7, 8, 9, 10, 12, 14, 15, 16, 17, 18, 20, 21, 22];
var less_is_good  	= [4, 8, 9, 10, 11, 15, 16, 21, 27, 28, 29, 30, 34]; //[4, 8, 11, 21, 27, 28, 29, 30];
var fixed_compare 	= [23, 24, 25, 26, 27, 28, 29, 30, 33, 34, 35, 36];
var target_acutal	= [12, 17];

var colorUnofficial = '#bfbfbf';
var unofficiallist  = 'tr#25, tr#26, tr#27, tr#28, tr#29, tr#30';

// CALL USER PROFILE
loadProfile(urlProfile, $('#profiler').val());

$(function() {

	var d = new Date(), n = d.getMonth(), y = d.getFullYear(), ly = d.getFullYear() -1; 
	
	var grid_main 		= "#grid_container";
	var grid_frozen		= "#grid_container_frozen";
	var grid_footer		= "#page_container";
	var current_month	= d.getMonth();
	var last_year		= 11;

	// Get Column Name
	getColumnIndexByName = function(columnName) {
        var cm = grid.jqGrid('getGridParam', 'colModel');
        for (var i=0,l=cm.length; i<l; i++) {
            if (cm[i].name===columnName) {
                return i; // return the index
            }
        }
        return -1;
        
    };

    var formatMonth = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
	monthNames   	= ["January " + y, "February " + y, "March " + y, "April " + y, "May " + y, "June " + y, "July " + y, "August " + y, "September " + y, "October " + y, "November " + y, "December " + y];
	month_name	 	= ['JanActual', 'FebActual', 'MarActual', 'AprActual', 'MayActual', 'JunActual', 'JulActual', 'AugActual', 'SepActual', 'OctActual', 'NovActual', 'DecActual'],
	month_ach	 	= ['JanAchieve', 'FebAchieve', 'MarAchieve', 'AprAchieve', 'MayAchieve', 'JunAchieve', 'JulAchieve', 'AugAchieve', 'SepAchieve', 'OctAchieve', 'NovAchieve', 'DecAchieve'],
	month_info	 	= ['JanInfo', 'FebInfo', 'MarInfo', 'AprInfo', 'MayInfo', 'JunInfo', 'JulInfo', 'AugInfo', 'SepInfo', 'OctInfo', 'NovInfo', 'DecInfo'],
	
	monthNameLYTD   = ["January " + ly, "February " + ly, "March " + ly, "April " + ly, "May " + ly, "June " + ly, "July " + ly, "August " + ly, "September " + ly, "October " + ly, "November " + ly, "December " + ly],
	month_nameLYTD	= ['JanActual_LY', 'FebActual_LY', 'MarActual_LY', 'AprActual_LY', 'MayActual_LY', 'JunActual_LY', 'JulActual_LY', 'AugActual_LY', 'SepActual_LY', 'OctActual_LY', 'NovActual_LY', 'DecActual_LY'],
	month_achLYTD	= ['JanAchieve_LY', 'FebAchieve_LY', 'MarAchieve_LY', 'AprAchieve_LY', 'MayAchieve_LY', 'JunAchieve_LY', 'JulAchieve_LY', 'AugAchieve_LY', 'SepAchieve_LY', 'OctAchieve_LY', 'NovAchieve_LY', 'DecAchieve_LY']
	month_infoLYTD	= ['JanInfo_LY', 'FebInfo_LY', 'MarInfo_LY', 'AprInfo_LY', 'MayInfo_LY', 'JunInfo_LY', 'JulInfo_LY', 'AugInfo_LY', 'SepInfo_LY', 'OctInfo_LY', 'NovInfo_LY', 'DecInfo_LY'];

	var month_summ	= [	              		
	    { label: 'NO', name: 'KPINO', title:false, width: 35, align: 'center', frozen: true, sortable: false, formatter: fnSetLinkToWb },
	    { label: 'KPI &nbsp; LIST', name: 'KPILIST',title:false,  width: 250, align: 'left', frozen: true, sortable: false, formatter: formatTarget },	 	
	    { label: 'TREND', name: 'TREND', title:false, width: 90, frozen: true, sortable: false },
	  
	    { label: 'GROUP', name: 'KPIGroupList', index: 'KPIGroupList', title: false, sortable: false },	 	
		{ label: 'REGION', name: 'Region', title:false, width: 70, align: 'center', sortable: false },
	    { label: 'LENDING', name: 'Lending', title:false, width: 70, align: 'center', sortable: false },
		
	    { label: 'TARGET', name: 'YTDTarget_LY', title:false, width: 70, align: 'center', sortable: false },
	    { label: 'ACTUAL', name: 'YTDActual_LY', title:false, width: 70, align: 'center', sortable: false },
	    { label: 'AVERAGE', name: 'YTDAVGActual_LY', title:false, width: 70, align: 'center', sortable: false, formatter: setEscapeToFixed },
	    { label: 'ACHIEVE', name: 'YTDAchieve_LY', title:false, width: 70, align: 'center', sortable: false, formatter: setFormatSpecifyPrevYear },
	    { label: 'INFO', name: 'YTDInfo_LY', title:false, width: 70, align: 'center', sortable: false },

		{ label: 'TARGET', name: 'YTDTarget', title:false, width: 70, align: 'center', sortable: false },
	    { label: 'ACTUAL', name: 'YTDActual', title:false, width: 70, align: 'center', sortable: false },
	    { label: 'AVERAGE', name: 'YTDAVGActual', title:false, width: 70, align: 'center', sortable: false, formatter: setEscapeToFixed },
	    { label: 'ACHIEVE', name: 'YTDAchieve', title:false, width: 70, align: 'center', sortable: false, formatter: setFormatSpecify },
	    { label: 'INFO', name: 'YTDInfo', title:false, width: 70, align: 'center', sortable: false },	 	
	];

	var month_groupHD	 = [],
		month_gpRollback = [];

    var month			 = [],
    	month_active	 = [],
    	month_theme		 = [];
	
    var month_rollback	 = [];

	// Current Month
    month_summ.push(    	
    	{ label: 'TARGET', name: 'CM_Target', title:false, width: 70, align: 'center', sortable: false },
    	{ label: 'ACTUAL', name: month_name[current_month], title:false, width: 70, align: 'center', sortable: false },
    	{ label: 'ACHIEVE', name: month_ach[current_month], title:false, width: 70, align: 'center', sortable: false, formatter: setCurrentMonthFormater },
    	{ label: 'INFO', name:  month_info[current_month], title:false, width: 70, align: 'center', sortable: false, formatter: setTooltipInfo },
    	{ label: '&nbsp;', name: 'Comp', title:false, width: 12, align: 'center', sortable: false, formatter: dataFormatComparing }
    	
    );
    
 	// implement icon enabled previous year
    month_groupHD.push(   
    	{ "numberOfColumns": 2, "titleText": "RANKING", "startColumnName": "Region" },
    	{ "numberOfColumns": 5, "titleText": "YTD " + ly, "startColumnName": "YTDTarget_LY" },
    	{ "numberOfColumns": 5, "titleText": "YTD " + y, "startColumnName": "YTDTarget" },
    	{ "numberOfColumns": 4, "titleText": monthNames[current_month].toUpperCase(), "startColumnName": "CM_Target" }
    );

	for(var i = 0; i <= current_month-1; i ++) { month.push(formatMonth[i]);	}
	
	month.sort(function(a, b){return b-a});	
	for(var i = month[0]; i >= 0; i--) {
	    month_summ.push(
	    	{ label:'ACTUAL', name: month_name[i], title:false, width: 70, align: 'center', sortable: false },
	    	{ label:'ACHIEVE', name: month_ach[i], title:false, width: 70, align: 'center', sortable: false, formatter: setFormatMonthly },
	    	{ label:'INFO', name: month_info[i], title:false, width: 70, align: 'center', sortable: false }
	    	
	    );

	    month_groupHD.push({ "numberOfColumns": 3, "titleText": monthNames[i].toUpperCase(), "startColumnName": month_name[i] });
	}

	// Last Year: Monthly
	// if(ly == '2015') {
	if(current_month <= 6) {
		for(var i = 0; i <= last_year; i ++) { month_rollback.push(formatMonth[i]);	}
		month_rollback.sort(function(a, b){return b-a});	
	}
	
	// Previous Year
	var rollback;
	if(ly == '2015') { rollback = 9; } 
	else { rollback = 9; }

	if(n <= limit_mth) {
		
		for(var i = month_rollback[0]; i >= rollback; i--) {
			
		    month_summ.push(
		    	{ label:'ACTUAL', name: month_nameLYTD[i], title:false, width: 70, align: 'center', sortable: false },
		    	{ label:'ACHIEVE', name: month_achLYTD[i], title:false, width: 70, align: 'center', sortable: false, formatter: setFormatMonthly },
		    	{ label:'INFO', name: month_infoLYTD[i], title:false, width: 70, align: 'center', sortable: false }
		    	
		    );

		    month_groupHD.push({ "numberOfColumns": 3, "titleText": monthNameLYTD[i].toUpperCase(), "startColumnName": month_nameLYTD[i] });
		    
		}

	}
		
	// load data grid
	var grid;
	var windowWidth = $(document).width() - 10;
	var windowHeight = $(document).height() - 170;

	// set reference from calendar.
	var data_ref;
	if(query['relsub'] != '') data_ref = query['relsub'];
	else data_ref = $('#emp_id').val();

	if(!data_ref) data_ref = $('#emp_id').val();

	grid = $(grid_main).jqGrid({
    	url: urlGrid,
    	mtype: "GET",
    	styleUI : 'Bootstrap',
    	datatype: "jsonp",
    	postData: $.param({ EMPCode: data_ref }),
    	jsonReader: {
    	    root: 'Data',
    	    repeatitems: false
    	},     	  
    	colModel: month_summ,     
    	rownumbers: true,		        
    	toppager: false,	   
    	shrinkToFit: false,    
    	viewrecords: true,
    	height: windowHeight, //'auto',   
    	width: windowWidth,    
    	rowNum: 500,
    	pager: false,//grid_footer,
    	caption: false,//"PERFORMANCE - GRID VIEWS",  
    	grouping:true, 
    	groupingView : { 
    		groupField : ['KPIGroupList'],
    	    groupColumnShow : [false], 
    	    groupCollapse : false,
    	    groupOrder: ['asc'], 
    	    groupDataSorted : true,
    	    isInTheSameGroup: function (x, y) {
    	   		return String(x).toLowerCase() === String(y).toLowerCase();
    	    }
    	},   	
    	loadComplete: function (rowObject) {

    	    var pointer = getColumnIndexByName('TREND');    				
    	    //grid_containerghead
    	    
    	    $('#grid_container_frozen tr.jqgrow td:nth-child('+(pointer+1)+')').each(function(index, value) { 

    	    	$(this).sparkline([
    				!isNaN(escape_keyword(rowObject['Data'][index].JanActual)) ? escape_keyword(rowObject['Data'][index].JanActual):0, 
    				!isNaN(escape_keyword(rowObject['Data'][index].FebActual)) ? escape_keyword(rowObject['Data'][index].FebActual):0, 
    				!isNaN(escape_keyword(rowObject['Data'][index].MarActual)) ? escape_keyword(rowObject['Data'][index].MarActual):0, 
    				!isNaN(escape_keyword(rowObject['Data'][index].AprActual)) ? escape_keyword(rowObject['Data'][index].AprActual):0, 
    				!isNaN(escape_keyword(rowObject['Data'][index].MayActual)) ? escape_keyword(rowObject['Data'][index].MayActual):0, 
    				!isNaN(escape_keyword(rowObject['Data'][index].JunActual)) ? escape_keyword(rowObject['Data'][index].JunActual):0, 
    				!isNaN(escape_keyword(rowObject['Data'][index].JulActual)) ? escape_keyword(rowObject['Data'][index].JulActual):0, 
    				!isNaN(escape_keyword(rowObject['Data'][index].AugActual)) ? escape_keyword(rowObject['Data'][index].AugActual):0, 
    				!isNaN(escape_keyword(rowObject['Data'][index].SepActual)) ? escape_keyword(rowObject['Data'][index].SepActual):0, 
    				!isNaN(escape_keyword(rowObject['Data'][index].OctActual)) ? escape_keyword(rowObject['Data'][index].OctActual):0, 
    				!isNaN(escape_keyword(rowObject['Data'][index].NovActual)) ? escape_keyword(rowObject['Data'][index].NovActual):0, 
    				!isNaN(escape_keyword(rowObject['Data'][index].DecActual)) ? escape_keyword(rowObject['Data'][index].DecActual):0
        		], {
    		            type: "line",
    		            width: '70',
    		            lineWidth: 1,	           	    
    		            tooltipFormat: '{{offset:offset}} {{y:val}}', //{{value}}
    		            tooltipValueLookups: {			            	    
    		            	'offset': {
    		            	    0:'Jan',
    		            	    1:'Feb',
    		            	    2:'Mar',
    		            	    3:'Apr',
    		            	    4:'May',
    		            	    5:'Jun',
    		            	    6:'Jul',
    		            	    7:'Aug',
    		            	    8:'Sep',
    		            	    9:'Oct',
    		            	    10:'Nov',
    		            	    11:'Dec'
    				        }  
    		            }  
    		    });
    	    		    
    		 
    	    });

    	    //$(grid_main).find('tbody > tr').addClass('animated fadeIn');
    	    //$(grid_frozen).find('tbody > tr').addClass('animated fadeIn');

    	    $(unofficiallist).find('td[aria-describedby="grid_container_CM_Target"]').css('color', colorUnofficial);
    	    $(unofficiallist).find('td[aria-describedby="grid_container_' + month_name[current_month] + '"]').css('color', colorUnofficial);
    	    $(unofficiallist).find('td[aria-describedby="grid_container_' + month_ach[current_month] + '"]').css('color', colorUnofficial);
    	    $(unofficiallist).find('td[aria-describedby="grid_container_' + month_info[current_month] + '"]').css('color', colorUnofficial);
			      
    	},   
    	loadError: function (jqXHR, textStatus, errorThrown) {
        	
            alert('HTTP status code: ' + jqXHR.status + '\n' +
                  'textStatus: ' + textStatus + '\n' +
                  'errorThrown: ' + errorThrown + '\n' +
                  'HTTP message body (jqXHR.responseText): ' + '\n' + jqXHR.responseText);
   
        },
    	loadui: "block",    	
    	loadtext: ""
    });

	// Column Group
	grid.setGroupHeaders({
		useColSpanStyle: true,
		groupHeaders: month_groupHD
	});
	         	
	grid.jqGrid('setFrozenColumns');

	// Set Pagina
	grid.jqGrid('navGrid', grid_footer, {
	    edit: false,
	    add: false,
	    del: false,
	    view: false,
	    search: false,
	    refresh: true,
	    closeOnEscape: true,
	    viewtext: "View",
	    edittext: "Edit",
	    refreshtext: "Refresh",
	    addtext: "Add",
	    deltext: "Delete",
	    searchtext: "Search",
	    cloneToTop: true
	}, {}, {}, {}, {}, {});

	// Remove paging on top, remove paging on bottom
	var topPagerDiv = $(grid_main + '_toppager')[0];         // "#list_toppager"
	$(grid_main + "_toppager_center", topPagerDiv).remove(); // "#list_toppager_center"
	$(".ui-paging-info", topPagerDiv).remove(); 
	    	 
	$(grid_footer + "_center", grid_footer).remove(); 
	$(".ui-paging-info", grid_footer).remove();

	

	// Hide field
	grid.jqGrid('hideCol', ['KPINO', 'Region', 'Lending', 'YTDTarget_LY', 'YTDActual_LY', 'YTDAVGActual_LY', 'YTDAchieve_LY', 'YTDInfo_LY',]); 
	
	// group collapse
	grid.jqGrid('groupingToggle','grid_containerghead_0_1');
		
	//$('#InfoModal div.modal-content, div.modal-body').css("min-width", windowWidth -50);
	$('.modal').css({
      	width: 'auto',
         'margin-left': function () {
         	return -($(this).width() / 6);
        }
 	});

	/*
 	// menu infomation implement
 	if(url_site == 'gridDataList') { 
		$('#span_information').html('<a href="\#"><span>KPI Help</span></a>');
		$('li#span_information').attr('onclick', 'openPopInfo();');
 	}
	*/
});	


//Event Show/Hidden	
(function($) {
    $.fn.clickToggle = function(func1, func2) {
        var funcs = [func1, func2];
        this.data('toggleclicked', 0);
        this.click(function() {
            var data = $(this).data();
            var tc = data.toggleclicked;
            $.proxy(funcs[tc], this)();
            data.toggleclicked = (tc + 1) % 2;
        });
        return this;
    };
}(jQuery));

$(function() {

	$('#show_ytd_lastyear').clickToggle(
	function() {   
		$("#grid_container").jqGrid('showCol', ['YTDTarget_LY', 'YTDActual_LY', 'YTDAVGActual_LY', 'YTDAchieve_LY', 'YTDInfo_LY']);
		$("#icon_openYTDHistory").rotate({ animateTo: 180, duration: 1000 });
		$(this).attr('data-tooltip', 'The previous year (close)');
	},
	function() {
		$("#grid_container").jqGrid('hideCol', ['YTDTarget_LY', 'YTDActual_LY', 'YTDAVGActual_LY', 'YTDAchieve_LY', 'YTDInfo_LY']);
		$("#icon_openYTDHistory").rotate({ animateTo: 0, duration: 1000 })
		$(this).attr('data-tooltip', 'The previous year (open)');
	}); 
	
});

function formatTarget(cellvalue, options, rowObject) {
	
	if(in_array(rowObject.KPINO, less_is_good)) {
		return cellvalue + '<i class="fa fa-sort-desc" style="color: green; margin-top: 1px; margin-left: 5px; font-size: 1.5em !important;"></i>'
	} else {
		return cellvalue;
	}
	
}


function dataFormatComparing(cellvalue, options, rowObject) {

	var margin		= 'margin-left: 3px !important; margin-top: 5px;';
	var fontSize	= 'font-size: 1em;';
	var color 	    = ["green", "red", "gray"];

	// In topic Outstanding with portfolio
	if(in_array(rowObject.KPINO, fixed_compare)) {
	
		var startDate 	  = new Date();
		var current_Date  = new Date(startDate.getFullYear(), startDate.getMonth() - 1, startDate.getDate()).getMonth();
		var previous_Date = new Date(startDate.getFullYear(), startDate.getMonth() - 2, startDate.getDate()).getMonth();

		var compares	  = '';
		var month_compare = '';
		if(in_array(rowObject.KPINO, target_acutal)) {
			
			var month_target  = month_name[current_Date];			
			if(current_Date >= 1) month_compare = month_name[previous_Date];
			else month_compare = month_nameLYTD[previous_Date];
			
		} else {
			
			var month_target  = month_ach[current_Date];			
			if(current_Date >= 1) month_compare = month_ach[previous_Date];
			else month_compare = month_achLYTD[previous_Date];
			
		}

		if(in_array(rowObject.KPINO, less_is_good)) {

			if(parseFloat(escape_keyword(rowObject[month_target])) > parseFloat(escape_keyword(rowObject[month_compare]))) compares = '-';
			else if(parseFloat(escape_keyword(rowObject[month_target])) < parseFloat(escape_keyword(rowObject[month_compare]))) compares = '+';
			else if(parseFloat(escape_keyword(rowObject[month_target])) == parseFloat(escape_keyword(rowObject[month_compare]))) compares = '=';

			/*			
			console.log('Fixed Compare : Less is good - Start');
			console.log([parseFloat(escape_keyword(rowObject[month_target])), parseFloat(escape_keyword(rowObject[month_compare])), compares]);
			console.log('Fixed Compare : Less is good - End');
			*/
			
			switch(compares) {
				case '-':
					return "<span style='color:" + color[1] + "' originalValue='" + compares + "'><i id=\"ie_icon_trend\" class=\"fa fa-caret-down icon_trend\" style=\"" + margin + " " + fontSize + "\"></i></span>";
					break;
				case '+':
					return "<span style='color:" + color[0] + "' originalValue='" + compares + "'><i id=\"ie_icon_trend\" class=\"fa fa-caret-up icon_trend\" style=\"" + margin + " " + fontSize + "\"></i></span>";
					break;
				case '=':
				default:
					return "<span style='color:" + color[2] + "' originalValue='" + compares + "'></span>";
					break;
			}

		} else {

			if(parseFloat(escape_keyword(rowObject[month_target])) > parseFloat(escape_keyword(rowObject[month_compare]))) compares = '+';
			else if(parseFloat(escape_keyword(rowObject[month_target])) < parseFloat(escape_keyword(rowObject[month_compare]))) compares = '-';
			else if(parseFloat(escape_keyword(rowObject[month_target])) == parseFloat(escape_keyword(rowObject[month_compare]))) compares = '=';

			/*
			console.log('Fixed Compare : Normal - Start');
			console.log([parseFloat(escape_keyword(rowObject[month_target])), parseFloat(escape_keyword(rowObject[month_compare])), compares]);
			console.log('Fixed Compare : Normal - End');
			*/
			
			switch(compares) {
				case '+': 
					return "<span style='color:" + color[0] + "' originalValue='" + compares + "'><i id=\"ie_icon_trend\" class=\"fa fa-caret-up icon_trend\" style=\"" + margin + " " + fontSize + "\"></i></span>";
					break;
				case '-':
	 				return "<span style='color:" + color[1] + "' originalValue='" + compares + "'><i id=\"ie_icon_trend\" class=\"fa fa-caret-down icon_trend\" style=\"" + margin + " " + fontSize + "\"></i></span>";
					break;
				case '=':
				default:
					return "<span style='color:" + color[2] + "' originalValue='" + compares + "'></span>";
					break;
			}
			
		}

		

	} else {
	// The general topic in kpi 
	
		var startDate 	  = new Date();
		var current_Date  = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate()).getMonth();
		var previous_Date = new Date(startDate.getFullYear(), startDate.getMonth() - 1, startDate.getDate()).getMonth();

		var compares	  = '';
		var month_compare = '';
		
		if(in_array(rowObject.KPINO, target_acutal)) {
			
			var month_target  = month_name[current_Date];			
			if(current_Date >= 1) month_compare = month_name[previous_Date];
			else month_compare = month_nameLYTD[previous_Date];
			
		} else {
			
			var month_target  = month_ach[current_Date];			
			if(current_Date >= 1) month_compare = month_ach[previous_Date];
			else month_compare = month_achLYTD[previous_Date];
			
		}
		
		if(in_array(rowObject.KPINO, less_is_good)) {

			if(parseFloat(escape_keyword(rowObject[month_target])) > parseFloat(escape_keyword(rowObject[month_compare]))) compares = '-';
			else if(parseFloat(escape_keyword(rowObject[month_target])) < parseFloat(escape_keyword(rowObject[month_compare]))) compares = '+';
			else if(parseFloat(escape_keyword(rowObject[month_target])) == parseFloat(escape_keyword(rowObject[month_compare]))) compares = '=';

			switch(compares) {
				case '-':
					return "<span style='color:" + color[1] + "' originalValue='" + compares + "'><i id=\"ie_icon_trend\" class=\"fa fa-caret-down icon_trend\" style=\"" + margin + " " + fontSize + "\"></i></span>";
					break;
				case '+':
					return "<span style='color:" + color[0] + "' originalValue='" + compares + "'><i id=\"ie_icon_trend\" class=\"fa fa-caret-up icon_trend\" style=\"" + margin + " " + fontSize + "\"></i></span>";
					break;
				case '=':
				default:
					return "<span style='color:" + color[2] + "' originalValue='" + compares + "'></span>";
					break;
			}

		} else {

			if(parseFloat(escape_keyword(rowObject[month_target])) > parseFloat(escape_keyword(rowObject[month_compare]))) compares = '+';
			else if(parseFloat(escape_keyword(rowObject[month_target])) < parseFloat(escape_keyword(rowObject[month_compare]))) compares = '-';
			else if(parseFloat(escape_keyword(rowObject[month_target])) == parseFloat(escape_keyword(rowObject[month_compare]))) compares = '=';

			switch(compares) {
				case '+': 
					return "<span style='color:" + color[0] + "' originalValue='" + compares + "'><i id=\"ie_icon_trend\" class=\"fa fa-caret-up icon_trend\" style=\"" + margin + " " + fontSize + "\"></i></span>";
					break;
				case '-':
	 				return "<span style='color:" + color[1] + "' originalValue='" + compares + "'><i id=\"ie_icon_trend\" class=\"fa fa-caret-down icon_trend\" style=\"" + margin + " " + fontSize + "\"></i></span>";
					break;
				case '=':
				default:
					return "<span style='color:" + color[2] + "' originalValue='" + compares + "'></span>";
					break;
			}
			
		}

	}
}


function setEscapeToFixed(cellvalue, options, rowObject) {
	var escape = [1];
	if(in_array(rowObject.KPINO, escape)) {
		return Math.round(escape_keyword(cellvalue)).toFixed(0) + ' Time';
	} else {
		return cellvalue;
	}
}

function setTooltipInfo(cellvalue, options, rowObject) {
	var gap = [5]
	if(in_array(rowObject.KPINO, gap)) {
		
		if(escape_keyword(cellvalue) >= 1) {
			return '<div class="tooltip-top" data-tooltip="อยู่ระหว่าง CA พิจารณารับเข้าระบบ" style="position: absolute; margin-left: 15px; color: red;">' + cellvalue + '</div>';
		} else {

			if(cellvalue.length >= 4) {
				return '<div class="tooltip-top" data-tooltip="อยู่ระหว่าง CA พิจารณารับเข้าระบบ" style="position: absolute; margin-left: 15px;">' + cellvalue + '</div>';
			} else {
				return '<div class="tooltip-top" data-tooltip="อยู่ระหว่าง CA พิจารณารับเข้าระบบ" style="position: absolute; margin-left: 25px;">' + cellvalue + '</div>';
			}

		}
		
	} else {
		return cellvalue;
	}	
}

function setFormatSpecify(cellvalue, options, rowObject) {
	var target = [14, 31, 32];
	if(in_array(rowObject.KPINO, target)) {

		var YTD_Taget;
		if(escape_keyword(rowObject.YTDTarget) == "-") YTD_Target = 0;
		else YTD_Target = escape_keyword(rowObject.YTDTarget);
		
		var approval_rate	= (escape_keyword(rowObject.YTDAchieve) * YTD_Target) / 100;
		if(roundFixed(approval_rate, 2) == '0.00') {
			return '<span class="tooltip-top" data-tooltip="Achieve: ' + parseFloat(cellvalue).toFixed(2) +'%" style="position: absolute; margin-left: -15px !important; text-decoration: underline;">' + roundFixed(approval_rate, 2) + '%</span>';
		} else {
			return '<div class="tooltip-top" data-tooltip="Achieve : ' + parseFloat(cellvalue).toFixed(2) + '%" style="position: absolute; margin-left: 5px; text-decoration: underline;">' + roundFixed(approval_rate, 2) + '%</div>';			
		}

		
	} else {
		
		// Non Quality
		if(in_array(rowObject.KPINO, [8])) {
			
			if(escape_keyword(rowObject.YTDTarget) == "-") YTD_Target = 0;
			else YTD_Target = escape_keyword(rowObject.YTDTarget);

			var achieve_rate, margin_layout;
			var approval_rate	= (parseFloat(escape_keyword(rowObject.YTDAchieve)) / YTD_Target) * 100;
			
			if(isNaN(approval_rate)) achieve_rate = '0.00%';
			else achieve_rate = roundFixed(approval_rate, 2) + '%';
			
			if(roundFixed(approval_rate, 2) == '0.00' || roundFixed(approval_rate, 2) == 0) {				
				return '<span class="tooltip-top" data-tooltip="Achieve: ' + achieve_rate +'" style="position: absolute; margin-left: -18px; !important; text-decoration: underline;">' + parseFloat(cellvalue).toFixed(2) + '%</span>';
			} else {	
				if(cellvalue.length >= 5) margin_layout = '5px';
				if(cellvalue.length <= 4) margin_layout = '15px';
				
				return '<div class="tooltip-top" data-tooltip="Achieve : ' + achieve_rate + '" style="position: absolute; margin-left: ' + margin_layout + '; text-decoration: underline;">' +  parseFloat(cellvalue).toFixed(2) + '%</div>';			
			}

		// Normally Values
		} else {			
			return cellvalue; 
		}
		
	}
	
}

function setFormatSpecifyPrevYear(cellvalue, options, rowObject) {
	var target = [14, 31, 32];
	if(in_array(rowObject.KPINO, target)) {

		var YTD_Taget;
		if(escape_keyword(rowObject.YTDTarget_LY) == "-") YTD_Target = 0; 
		else YTD_Target = escape_keyword(rowObject.YTDTarget_LY); 
		
		var approval_rate	= (escape_keyword(rowObject.YTDAchieve_LY) * YTD_Target) / 100;
		if(roundFixed(approval_rate, 2) == '0.00') {
			return '<span class="tooltip-top" data-tooltip="Achieve: ' + cellvalue +'" style="position: absolute; margin-left: -18px !important; text-decoration: underline;">' + roundFixed(approval_rate, 2) + '%</span>';
		} else {
			return '<div class="tooltip-top" data-tooltip="Achieve : ' + cellvalue + '" style="position: absolute; margin-left: 5px; text-decoration: underline;">' + roundFixed(approval_rate, 2) + '%</div>';			
		}

		
	} else {
		
		// Non Quality
		if(in_array(rowObject.KPINO, [8])) {
			// set target
			if(escape_keyword(rowObject.YTDTarget_LY) == "-") YTD_Target = 0;
			else YTD_Target = escape_keyword(rowObject.YTDTarget_LY);
			
			var approval_rate	= (escape_keyword(rowObject.YTDAchieve_LY) / YTD_Target) * 100;
			if(roundFixed(approval_rate, 2) == '0.00' || roundFixed(approval_rate, 2) == '0') {
				return '<span class="tooltip-top" data-tooltip="Achieve: ' + roundFixed(approval_rate, 2) +'%" style="position: absolute; margin-left: -18px !important; text-decoration: underline;">' + cellvalue + '</span>';
			} else {
				return '<div class="tooltip-top" data-tooltip="Achieve : ' + roundFixed(approval_rate, 2) + '%" style="position: absolute; margin-left: 5px; text-decoration: underline;">' + cellvalue + '</div>';			
			}

		// Normally Values
		} else {			
			return cellvalue;
		}
		
	}
	
}

function setCurrentMonthFormater(cellvalue, options, rowObject) {
	var target = [14, 31, 32],
		portfolio = [26, 27, 28, 29, 30],
		monthly,
		approval_rate;

	monthly 	  = options.colModel.name; 
	if(in_array(rowObject.KPINO, target)) {		
	
		if(escape_keyword(rowObject.CM_Target) == "-") YTD_Target = 0;
		else YTD_Target = escape_keyword(rowObject.CM_Target);	
		
	    approval_rate = escape_keyword(rowObject[monthly]) * YTD_Target / 100;

		var int_valid;
		if(isNaN(roundFixed(approval_rate, 2))) int_valid = '0.00';
		else int_valid = roundFixed(approval_rate, 2);
					
		if(in_array(rowObject.KPINO, [target[1], target[2]])) {
			
			if(int_valid == '0.00' || int_valid == '0') {
				return '<span class="tooltip-top" data-tooltip="Achieve: ' +  parseFloat(cellvalue).toFixed(2) +'%" style="position: absolute; margin-left: -15px !important; text-decoration: underline;">' + int_valid  + '%</span>';
			} else {
				return '<div class="tooltip-top" data-tooltip="Achieve : ' +  parseFloat(cellvalue).toFixed(2) + '%" style="position: absolute; margin-left: 15px; text-decoration: underline;">' + int_valid + '%</div>';			
			}
			
		} else {
			
			if(int_valid == '0.00') {
				return '<span class="tooltip-top" data-tooltip="Achieve: ' + parseFloat(cellvalue).toFixed(2) +'%" style="position: absolute; margin-left: -18px !important; text-decoration: underline;">' + int_valid + '%</span>';
			} else {
				return '<div class="tooltip-top" data-tooltip="Achieve : ' + parseFloat(cellvalue).toFixed(2) + '%" style="position: absolute; margin-left: 5px; text-decoration: underline;">' + int_valid + '%</div>';			
			}
			
		}

	} else {
		
		// Non Quality
		if(in_array(rowObject.KPINO, [8])) {
			
			if(escape_keyword(rowObject.CM_Target) == "-") YTD_Target = 0;
			else YTD_Target = escape_keyword(rowObject.CM_Target);			

			var margin_layout = '';
			var approval_rate	= (escape_keyword(rowObject[monthly]) / YTD_Target) * 100;
			
			if(roundFixed(approval_rate, 2) == '0.00') {
				
				if(cellvalue.length >= 6) margin_layout = '0px';
				if(cellvalue.length == 5) margin_layout = '-18px';
				if(cellvalue.length == 1) margin_layout = '0px';
				
				// month_ach month_achLYTD				
				return '<span class="tooltip-top" data-tooltip="Achieve: ' + roundFixed(approval_rate, 2) +'%" style="position: absolute; margin-left: '+ margin_layout + ' !important; text-decoration: underline;">' + cellvalue + '</span>';
				
			} else {
				return '<div class="tooltip-top" data-tooltip="Achieve : ' + roundFixed(approval_rate, 2) + '%" style="position: absolute; margin-left: 5px; text-decoration: underline;">' + cellvalue + '</div>';			
			}

		// Normally Values
		} else if(in_array(rowObject.KPINO, portfolio)) {

			var pos_title	= $('#position_title').val();
			
			if(escape_keyword(rowObject.CM_Target) == "-") YTD_Target_port = 0;
			else YTD_Target_port = escape_keyword(rowObject.CM_Target);			

			var portfolio_achieve = (escape_keyword(rowObject[monthly]) / YTD_Target_port) * 100;
		
			var int_valid;
			var margin_layout = '';
			if(isNaN(roundFixed(portfolio_achieve, 2))) int_valid = '0.00';
			else int_valid = roundFixed(portfolio_achieve, 2);
		
			if(int_valid == '0.00') {	
			
				if(cellvalue.length >= 6) margin_layout = '-18px';
				if(cellvalue.length == 5) margin_layout = '-20px';
				if(cellvalue.length == 1) margin_layout = '0px';
				/*
				if(in_array(pos_title, ['RM', 'BM'])) {
					if(cellvalue.length == 1) margin_layout = '0px';
				} else {					
					if(cellvalue.length == 1) margin_layout = '25px';
				}
				*/
				return '<span class="tooltip-top" data-tooltip="Achieve: ' + int_valid +'%" style="position: absolute; margin-left: ' + margin_layout + '; !important; text-decoration: underline;">' + cellvalue + '</span>';
			} else {
				if(cellvalue.length >= 6) margin_layout = '5px';
				if(cellvalue.length == 5) margin_layout = '10px';
				if(cellvalue.length == 1) margin_layout = '25px';
				
				return '<div class="tooltip-top" data-tooltip="Achieve : ' + int_valid + '%" style="position: absolute; margin-left: ' + margin_layout + '; text-decoration: underline;">' + cellvalue + '</div>';
							
			}
						
		} else {			
			return cellvalue;
		}
		
	}
	
}

function setFormatMonthly(cellvalue, options, rowObject) {
	
	var target 	  = [14, 31, 32];
	var portfolio = [26, 27, 28, 29, 30];
	var monthly;
	var approval_rate;

	var position_title	= $('#position_title').val(),
		monthly    		= options.colModel.name;	

	if(in_array(rowObject.KPINO, target)) {

		if(escape_keyword(rowObject.CM_Target) == "-") YTD_Target = 0;
		else YTD_Target = escape_keyword(rowObject.CM_Target);		
				
		approval_rate = escape_keyword(rowObject[monthly]) * YTD_Target / 100;
		
		if(in_array(rowObject.KPINO, [target[1], target[2]])) {

			var int_valid;
			if(isNaN(roundFixed(approval_rate, 2))) int_valid = '0.00';
			else int_valid = roundFixed(approval_rate, 2);
		
			if(int_valid == '0.00' || int_valid == '0') {
				return '<span class="tooltip-top" data-tooltip="Achieve: ' + parseFloat(cellvalue).toFixed(2) +'%" style="position: absolute; margin-left: -15px !important; text-decoration: underline;">' + int_valid + '%</span>';
			} else {
				return '<div class="tooltip-top" data-tooltip="Achieve : ' +  parseFloat(cellvalue).toFixed(2) + '%" style="position: absolute; margin-left: 5px; text-decoration: underline;">' + int_valid + '%</div>';			
			}
						
		} else {

			if(roundFixed(approval_rate, 2) == '0.00') {
				return '<span class="tooltip-top" data-tooltip="Achieve: ' + cellvalue +'" style="position: absolute; margin-left: -18px !important; text-decoration: underline;">' + roundFixed(approval_rate, 2) + '%</span>';
			} else {
				return '<div class="tooltip-top" data-tooltip="Achieve : ' + cellvalue + '" style="position: absolute; margin-left: 5px; text-decoration: underline;">' + roundFixed(approval_rate, 2) + '%</div>';			
			}
			
		}

	} else {
		
		// Non Quality
		if(in_array(rowObject.KPINO, [8])) {

			if(escape_keyword(rowObject.CM_Target) == "-") YTD_Target = 0;
			else YTD_Target = escape_keyword(rowObject.CM_Target);		

			var data_val = '';
			if(cellvalue) data_val = cellvalue;

			var margin_layout	= '';
			var approval_rate	= (escape_keyword(rowObject[monthly]) / YTD_Target) * 100;
			if(roundFixed(approval_rate, 2) == '0.00') {
				if(cellvalue) {
					if(cellvalue.length >= 6) margin_layout = '0px';
					if(cellvalue.length == 5) margin_layout = '-18px';
					if(cellvalue.length == 1) margin_layout = '0px';
				} else {
					margin_layout = '0px'
				}
				
				return '<span class="tooltip-top" data-tooltip="Achieve: ' + roundFixed(approval_rate, 2) +'%" style="position: absolute; margin-left: ' + margin_layout + ' !important; text-decoration: underline;">' + data_val + '</span>';
			} else {
				return '<div class="tooltip-top" data-tooltip="Achieve : ' + roundFixed(approval_rate, 2) + '%" style="position: absolute; margin-left: 5px; text-decoration: underline;">' + data_val + '</div>';			
			}

		// Normally Values
		} else if(in_array(rowObject.KPINO, portfolio)) {
			
			var YTD_Target  = '';	
			if(in_array(position_title, ['BM', 'RM'])) {
				if(escape_keyword(rowObject.CM_Target) == "-") YTD_Target = 0;
				else YTD_Target = escape_keyword(rowObject.CM_Target);	
			} else {
				if(escape_keyword(rowObject.YTDTarget) == "-") YTD_Target = 0;
				else YTD_Target = escape_keyword(rowObject.YTDTarget);	
			}
	
			var portfolio_checked;
			var portfolio_achieve = (escape_keyword(rowObject[monthly]) / YTD_Target) * 100;

			if(isNaN(portfolio_achieve)) portfolio_checked = 0.00;
			else portfolio_checked = portfolio_achieve;

			var data_val = '';
			if(cellvalue) data_val = cellvalue;
			
		
			var margin_layout = '';					
			if(roundFixed(portfolio_checked, 2) == '0.00') {
				if(cellvalue) {
					if(cellvalue.length >= 6) margin_layout = '-18px';
					if(cellvalue.length == 5) margin_layout = '-20px';
				} else {
					margin_layout = '0px'
				}
				
				return '<span class="tooltip-top" data-tooltip="Achieve: ' + portfolio_checked.toFixed(2) +'%" style="position: absolute; margin-left: ' + margin_layout + '; !important; text-decoration: underline;">' + data_val + '</span>';
			} else {
				if(cellvalue) {
					if(cellvalue.length >= 6) margin_layout = '5px';
					if(cellvalue.length == 5) margin_layout = '10px';
				} else {
					margin_layout = '0px'
				}
				
				return '<div class="tooltip-top" data-tooltip="Achieve : ' + portfolio_checked.toFixed(2) + '%" style="position: absolute; margin-left: ' + margin_layout + '; text-decoration: underline;">' + data_val + '</div>';
							
			}
			
		} else {	
			if(cellvalue) return cellvalue;
			else return '';
			
		}

		
	}

}

function roundFixed(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals).toFixed(2);
}

function AnimateRotate(angle) {
    // caching the object for performance reasons
    var $elem = $('#sidebar_icon');

    // we use a pseudo object for the animation
    // (starts from `0` to `angle`), you can name it as you want
    $({deg: 0}).animate({deg: angle}, {
        duration: 2000,
        step: function(now) {
            // in the step-callback (that is fired each step of the animation),
            // you can use the `now` paramter which contains the current
            // animation-position (`0` up to `angle`)
            $elem.css({
                transform: 'rotate(' + now + 'deg)'
            });
        }
    });
}


function clearPanelMenu() {
	$('div.mm-panel').not('#mm-1, #subList').removeClass().addClass('mm-panel mm-hasnavbar mm-hidden').removeClass('mm-current mm-opened mm-subopened');
	$('#subList').removeClass().addClass('panel-categories mm-panel mm-hasnavbar mm-hidden').removeClass('mm-current mm-opened mm-subopened');
	$('#mm-1').removeClass().addClass('mm-panel mm-opened mm-current').removeClass('mm-subopened');
	
}

function escape_keyword(text) {
	
	if(text == undefined) {
		return 0;
	} else {
		return text.replace('Time', '')
		.replace('App', '')
		.replace('List', '')
		.replace('%', '')
		.replace('Kb', '')	
		.replace('KB', '')		
		.replace('Mb', '')
		.replace('Acc', '').trim();
	}
	
}


function getQueryParams(qs) {
    qs = qs.split("+").join(" ");

    var params = {}, tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])]
            = decodeURIComponent(tokens[2]);
    }

    return params;
}

function openPopInfo() {
	
	$('#InfoModal').modal({
		 show: true,
		 keyboard: true,
		 backdrop: true
	}).draggable();	
	
}

function fnSetLinkToWb(cellvalue, options, rowObject) {

	 //delete jump_topic[0];
	 if(in_array(cellvalue, jump_topic)) {
	
		var emp_code  		= '';
		var brn_code  		= $('#branchCode').val();
		var auth_code 		= $('#authCode').val();
		var event_handled	= $('#event_mode').val();

		if(query.rel !== query.relsub) {
			emp_code = query.relsub;
		} else {
			emp_code = $('#emp_id').val();
		}

		if(escape_keyword(rowObject.CM_Actual) == "-") cm_actual = 0;
		else cm_actual = escape_keyword(rowObject.CM_Actual);			

		if(escape_keyword(rowObject.CM_Info) == "-") cm_info = 0;
		else cm_info = escape_keyword(rowObject.CM_Info);
		
		if(cm_actual != 0 && cm_actual != '0.00' || cm_info != 0 && cm_info != '0.00') {	

			var marginLeft = '';
			if(cellvalue.length >= 2) marginLeft = '-13px;'; 
			else marginLeft = '-10px;';	

			return '<span class="tooltip-right" data-tooltip="Jump to whiteboard." onclick="setConditionRounting(\'' + cellvalue +'\', \'' + emp_code + '\', \'' + event_handled + '\');" style="cursor: pointer; padding: 1px 5px; border-radius: 50%; background: #c0dff9; position: absolute; color: black; margin-top: -1px; margin-left: ' + marginLeft + ';">' + cellvalue + '</span>';
					
		} else {
			return cellvalue;
		}
		
	 } else {
		return cellvalue;
	 }
			
}

function setConditionRounting(cellvalue, primary_code, mode) {

	var url;
	var whiteboard_uri  = pathFixed + 'metro/dashboard_frame?_='  + new Date().getTime() + '&search_kpi=true&kpino=' + cellvalue + '&mode=' + mode;
	var appprogress_uri = pathFixed + 'metro/appProgress?_='  + new Date().getTime() + '&search_kpi=true&kpino=' + cellvalue + '&mode=' + mode;
	if(in_array(cellvalue, jump_topic)) {
		// Define Condition
		switch(cellvalue) {
			case '2': // Prospect
				url = appprogress_uri + '&is_actived=All&empcode_kpi=' + primary_code;								
				helper(url, true);				
			break;
			case '4':		
			case '6':								
				url = whiteboard_uri + '&is_actived=Active&use_ca=false&empcode_kpi=' + primary_code + '&modestate=A2CA_CRAC';								
				helper(url, true);								
			break;					
			case '17':	
			case '21':
				url = whiteboard_uri + '&is_actived=Active&use_ca=true&empcode_kpi=' + primary_code;								
				helper(url, true);								
			break;
			case '9':
				url = whiteboard_uri + '&is_actived=InActive&use_ca=false&empcode_kpi=' + primary_code;								
				helper(url, true);	
			break;
			case '14':	
				url = whiteboard_uri + '&is_actived=All&use_ca=true&empcode_kpi=' + primary_code;								
				helper(url, true);	
			break;
			case '15':
			case '16':
			case '18':
			case '20':
			case '22':
				url = whiteboard_uri + '&is_actived=InActive&use_ca=true&empcode_kpi=' + primary_code;								
				helper(url, true);	
			break;
			case '7':	
			case '8':
			case '10':
			case '12':				
				url = whiteboard_uri + '&is_actived=All&use_ca=unknowns&empcode_kpi=' + primary_code;								
				helper(url, true);	
			break;
			
		}
		
	}
	
}

function setrevoke(data) {
	if(escape_keyword(data) == "-") return  0;
	else return escape_keyword(data);	
}

function helper(url, tab) {
	if(tab) window.open(url, '_blank');
	else window.open(url);	
}

</script>

</body>
</html>
