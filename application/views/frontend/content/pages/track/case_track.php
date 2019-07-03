<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title><?php echo $author; ?></title>
    <meta name="description" content="<?php echo $desc; ?>">
    <meta name="viewport" content="<?php echo $viewport; ?>">
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">
    
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/logo.ico'); ?>">
    
    <!-- STYLESHEET -->
    <link href="<?php echo base_url('css/jquery-ui/ui-lightness/jquery-ui-1.8.20.custom.css'); ?>" rel="stylesheet">
    <!-- METRO UI -->
    <link href="<?php echo base_url('css/metro/metro-bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/metro/metro-bootstrap-responsive.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/metro/iconFont.min.css'); ?>" rel="stylesheet">
    <!-- AWESOME ICON  -->
    <link href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <!-- ANIMATE ANIMATION -->
    <link href="<?php echo base_url('css/animate/animate.min.css'); ?>" rel="stylesheet">
    <!-- JQGRID TEMPLATE STYLE -->
	<link href="<?php echo base_url('css/jqGrid/ui.jqgrid.css'); ?>" rel="stylesheet" media="screen">
	<link href="<?php echo base_url('css/jqGrid/addons/ui.multiselect.css'); ?>" rel="stylesheet" media="screen">
	<style type="text/css">
		
	
	</style>
	
	<!-- JAVASCRIPT -->
	<!-- JQUERY COMPONENT -->
	<script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery-ui.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.mousewheel.js'); ?>"></script>
	<!-- METRO UI COMPONENT -->
	<script src="<?php echo base_url('js/metro/metro.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
	<!-- MOMENT DELAY COMPONET -->
	<script src="<?php echo base_url('js/moment.min.js'); ?>"></script>
	<!-- JQGRID COMPONENT -->
	<script src="<?php echo base_url('js/jqGrid/i18n/grid.locale-en.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('js/jqGrid/minified/jquery.jqGrid.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/build/jqgrid/jqgrid_casetrack_err.js'); ?>"></script>

	
</head>
<body  class="metro">
<!--[if lt IE 8]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div id="navigation">
	<?php echo $this->load->view('frontend/implement/nav'); ?>
</div>


<div id="contentation" style="margin-top: 70px;">

<header class="text-center">
	<h2> CASE DOCUMENT </h2>
	<h4 id="timestemps" class="text-center text-muted">ERROR TRACKING </h4>
</header>

<div class="grid">
	<div id="application" class="row">
	
		<!-- jqGrid Boundary -->
		<div style="margin-left: 10%; margin-top: 50px;">
		<table id="table_case_track"></table>
		<div id="paging"></div>
		</div>
		
	</div>
</div>

</div>

<div class="container" style="margin-top: 30px; margin-left: 20px;">
	<?php $this->load->view('frontend/implement/footer'); ?>
</div>