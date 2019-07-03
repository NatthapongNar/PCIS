<!DOCTYPE html>
<html lang="en" ng-app="pcisKpiDashboard">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KPI Module</title>
    <meta name="description" content="<?php echo $desc; ?>">    
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/logo.ico'); ?>">
        
    <!-- Include Style -->
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/jquery-ui/jquery-ui.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/bootstrap-checkbox.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/metro/iconFont.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap.css'); ?>"> 	
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap-ui.css'); ?>"> 
 		
 	<link rel="stylesheet" href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>"> 
 	<link rel="stylesheet" href="<?php echo base_url('css/animate/animate.min.css'); ?>">  
 	<link rel="stylesheet" href="<?php echo base_url('css/notifIt/notifIt.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/themify-icons.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/flaticon/flaticon.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/wp.custom.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/element-color-theme.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/tooltip_custom.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/webui-popover/jquery.webui-popover.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/multi-select/multiple-select.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/kalendea/kalendae.css'); ?>">
 	
 	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=RobotoDraft:300,400,500,700,400italic">
    <link rel="stylesheet" href="<?php echo base_url('js/clndr/material-design-iconic-font/css/material-design-iconic-font.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/clndr/snarl/snarl.min.css'); ?>">
   	<link rel="stylesheet" href="<?php echo base_url('js/clndr/chat-client.css'); ?>">
	<!-- END Include Style -->
	
	<!-- START INCLUDE SCRIPT -->
	<script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery-ui.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.mousewheel.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.number.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.mask.min.js'); ?>">></script>
	<script src="<?php echo base_url('js/kalendea/kalendae.standalone.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/moment.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugin/notifIt/notifIt.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugin/webui-popover/jquery.webui-popover.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/vendor/jquery.rotate.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/jqGrid/js/i18n/grid.locale-en.js'); ?>" type="text/ecmascript" ></script>  
	<script src="<?php echo base_url('js/jqGrid/js/jquery.jqGrid.min.js'); ?>" type="text/ecmascript" ></script>
	<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
	
	<script src="<?php echo base_url('js/angular/angular.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-animate.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-sanitize.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-filter.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/readmore.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/ui-bootstrap-tpls-1.1.2.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/ion.sound.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/socket.io.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/snarl/snarl.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/vendor/jquery.multiple.select.js'); ?>"></script>	
	<script src="<?php echo base_url('js/clndr/bootstrap-multiselect.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/chat-client.js'); ?>"></script>	
	<script src="<?php echo base_url('js/build/collection/collection_script.js?v=004'); ?>"></script>	
	<script src="<?php echo base_url('js/build/report/kpidashboard_table.js?v=001'); ?>"></script>	
	<script src="<?php echo base_url('js/md5/md5.js'); ?>"></script>
	<!-- END START INCLUDE SCRIPT -->
	
</head>
<body>

<?php $id_authority = !empty($session_data['emp_id']) ? $session_data['emp_id']:''; ?>
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
	        	<li><div class="marginTop5" ui-chat-client="<?php echo $id_authority; ?>" direct-chat-click="direct_chat" direct-chat-to="<?php echo $id_authority; ?>" chat-dialog-position="right" chat-status="chat_state"></div></li>	        	
	        	<li class="divider-vertical" style="margin-right: -2px;"></li>       
		    	<li><span id="direct_chat" class="using_information"></span></li>
      		</ul>	
      	</div>		
	</div>
</div>
	
	
</body>
</html>