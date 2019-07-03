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
	<link href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstarp.css'); ?>" rel="stylesheet" media="screen">
	<link href="<?php echo base_url('css/jqGrid/addons/ui.multiselect.css'); ?>" rel="stylesheet" media="screen">
	<style type="text/css">
		
		.bg-org-gradient { background: #f7b64a; }
		.ui-jqgrid-titlebar { background: #4390df; }
		.ui-jqdialog-titlebar { background: #4390df; }
	
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
	<script src="<?php echo base_url('js/build/jqgrid/jqgrid_ncbtrack_err.js'); ?>"></script>
		
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
	<h4 id="timestemps" class="text-center text-muted">ERROR TRACKING </h4>
</header>

<div class="grid">
	<div id="application" class="row">
	
		<!-- jqGrid Boundary -->
		<div style="margin-left: 10%; margin-top: 30px;">
		
			<div class="panel" data-role="panel" style="width: 1250px; margin-bottom: 10px;">
				<div class="panel-header bg-lightBlue fg-white" style="font-size: 0.9em;"><i class="icon-user-3 on-left"></i> INFORMATION</div>
				<div class="panel-content" style="display: none;">
					
					<div class="row" style="margin-top: -10px;">
					
						<div class="span6 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลลูกค้า</label></div>
						<div class="span6 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลพนักงาน</label></div>
						
						<div class="span6">
							<label class="label span2 text-left">ชื่อ - นามสกุล</label>							
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['BorrowerName']) ? $getCustInfo['BorrowerName']:"";  ?></div>
						</div>
						
						<div class="span6">
							<label class="label span2 text-left">ชื่อ - นามสกุล</label>							
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['RMName']) ? $getCustInfo['RMName']:""; ?></div>
						</div>
						
						<div class="span6">
							<label class="label span2 text-left">ประเภทผู้กู้</label>	
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['BorrowerDesc']) ? $getCustInfo['BorrowerDesc']:"";  ?></div>
						</div>
						
						<div class="span6">
							<label class="label span2 text-left">รหัสพนักงาน</label>								
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['RMCode']) ? $getCustInfo['RMCode']:""; ?></div>
						</div>
						
						<div class="span6">
							<label class="span2 text-left"></label>	
							<div class="span4 text-left"></div>
						</div>
						
						<div class="span6">
							<label class="label span2 text-left">รหัสสาขา</label>							
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['BranchCode']) ? $getCustInfo['BranchCode']:""; ?></div>
						</div>
						
						<div class="span6">
							<label class="span2 text-left"></label>	
							<div class="span4 text-left"></div>
						</div>
						<div class="span6">
							<label class="label span2 text-left">เบอร์โทรศัพท์</label>							
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['RMMobile']) ? $getCustInfo['RMMobile']:""; ?></div>
						</div>

						<div class="span6">
							<label class="span2 text-left"></label>	
							<div class="span4 text-left"></div>
						</div>
						
						<div class="span6">
							<label class="label span2 text-left">สาขา</label>								
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['BranchName']) ? $getCustInfo['BranchName']:""; ?></div>
						</div>
					
						<div class="span6">
							<label class="span2 text-left"></label>													
							<div class="span4 text-left"></div>
						</div>
						<div class="span6">
							<label class="label span2 text-left">เบอร์ติดต่อสาขา</label>							
							<div class="label span4 text-left">&nbsp;</div>
						</div>
					
					</div>
					
				</div>
			</div>
		
			<table id="table_ncb_track"></table>
			<div id="paging"></div>
			
		</div>
		
	</div>
</div>

</div>

<div class="container" style="margin-top: 30px; margin-left: 20px;">
	<?php $this->load->view('frontend/implement/footer'); ?>
</div>