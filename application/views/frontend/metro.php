<!DOCTYPE html>
<html lang="en" ng-app="pcis-collection" style="background: #FFF;">
<head id="printHeader">
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $author.' - Menu'; ?></title>
    <meta name="description" content="<?php echo $desc; ?>">
    <meta name="viewport" content="<?php echo $viewport; ?>">
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/tcrbank.ico'); ?>">
    
    <!-- Metro UI CSS Plugins -->
    <?php echo $css_st; ?>
    <link href="<?php echo base_url('css/custom/wp.custom.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('css/animate/animate.min.css'); ?>" rel="stylesheet">
		
	<!-- Include for Chat -->
	<link rel="stylesheet" href="<?php echo base_url('css/googlefont.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('js/clndr/bootstrap_for_modal/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/clndr/material-design-iconic-font/css/material-design-iconic-font.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/angular_1.5/angular-material.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/scrollable-table/scrollable-table.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/angular/notification/angular-ui-notification.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/clndr/snarl/snarl.min.css'); ?>">
   	<link rel="stylesheet" href="<?php echo base_url('js/clndr/chat-client.css?v=002'); ?>">
   	
   	
	<!-- End Chat Style -->
	
	<style type="text/css">	
	
		.metro .dropdown-toggle:after { visibility: hidden; }
		span.fa { 
			font-family: FontAwesome !important; 
		}
		
		.dropdown > .dropdown-menu {
		    transform: scale(0);
		    opacity: 0;
			display: block !important;
		}
		
		.chat-state {
		    position: absolute !important;
		    top: 13px;
		    left: 47px;
		    z-index: 1002;
		}
		
		img[icon-attr^="outlook"],		
		img[icon-attr^="yammer"] { opacity: 1 !important; margin-left: -2.4em !important; }
		div.submenu_hover:hover { background: #1B6EAE;}
		i[icon-attr^="people"] { position: absolute; z-index: 10008; margin-top: -20px; opacity: 1 !important; }
		
	</style>
	<style type="text/css" media="print">	
	.nonprint { display: none !important; }	
	#contact-buttons-bar { display: none; }
	</style>
		
	<!-- Metro UI Javascript Plugins -->
	<?php echo $js_lib; ?>
		
	<?php $script_version		= $this->config->item('collection_version'); ?>
	<?php $chatscript_version	= $this->config->item('chatscript_version'); ?>	
	
	<!-- START INCLUDE CHAT SCRIPT -->
	<script src="<?php echo base_url('js/clndr/bootstrap_for_modal/js/bootstrap.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/angular_1.5/angular.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-animate.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-aria.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular_1.5/angular-messages.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-cookies.min.js'); ?>"></script>
	
	<script src="<?php echo base_url('js/angular/scrollable-table/angular-scrollable-table.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-sanitize.min.js'); ?>"></script>
	
	<script src="<?php echo base_url('js/angular/readmore.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/ui-bootstrap-tpls-1.1.2.min.js'); ?>"></script>	
	<script src="<?php echo base_url('js/angular/notification/angular-ui-notification.min.js'); ?>"></script>
	
	<!-- Angular Material Library -->
    <script src="<?php echo base_url('js/clndr/angular-material.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/jquery.slimscroll.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/moment-with-locales.js'); ?>"></script>
    <script src="<?php echo base_url('js/clndr/bundle/lodash.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/smtp.js'); ?>"></script>	
	
	<script src="<?php echo base_url('js/clndr/socket.io-1.3.3.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/ion.sound.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/socket.io.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/snarl/snarl.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/build/collection/collection_script.js') . $script_version; ?>"></script>
	<script src="<?php echo base_url('js/clndr/chat-client.js') . $chatscript_version; ?>"></script>	
	<script src="<?php echo base_url('js/build/module/drawdown-template.js?v=089'); ?>"></script>
	<script src="<?php echo base_url('js/build/metro-csm.js'); ?>"></script>
	<script src="<?php echo base_url('js/clndr/bootstrap-multiselect.js'); ?>"></script>	
	<script src="<?php echo base_url('js/md5/md5.js'); ?>"></script>	
	<!-- END INCLUDE CHAT SCRIPT -->
	
	<?php echo $op_lib; ?>

</head>
<body class="metro">
<!--[if lt IE 8]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<input id="empprofile_identity" type="hidden" value="<?php echo !empty($_GET['empcode_kpi']) ? $_GET['empcode_kpi']:$session_data["emp_id"]; ?>">
<input id="emp_role" type="hidden" value="<?php echo !empty($user_role) ? $user_role:''; ?>">

<div id="navigation" class="nonprint">
	<?php echo $nav; ?>
</div>

<div id="contentation" style="margin-top: 70px;">
	<?php echo $content; ?>
</div>

<div class="container nonprint">
	<?php echo $footer; ?>
</div>

</body>
</html>