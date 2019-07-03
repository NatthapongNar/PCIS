<!DOCTYPE html>
<html>
<head ng-app>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KPI Summary</title>
    <meta name="description" content="<?php echo $desc; ?>">    
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/logo.ico'); ?>">
        
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/core/css/jquery.mmenu.all.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.themes.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.effects.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.borderstyle.css'); ?>"> 	 	
 	<link rel="stylesheet" href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/themify-icons.css'); ?>">  	 	
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/mmenu.css'); ?>">	
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/wp.custom.css'); ?>">	
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/tooltip_custom.css'); ?>">	
 	<style type="text/css">
 	
 		#bs-nav, #bs-nav a, #bs-nav span { 
 			color: #FFF !important;
 			background: #4390df; 
 		}
 		
 		.navbar-toggle > span { color: #FFF !important; }
 	
	 	div.navbar a {
	    	display: inline-block;
	    	background: #4390df;
		}		
		
		.navbar .divider-vertical {
			height: 25px;
			margin: 15px 5px;
			border-left: 1px solid #f2f2f2;
			border-right: 1px solid #ffffff;
			opacity: 0.5;
		}
		
		body {
			background: #F9F9F9;	
			font-size: 1.2em !important;
		}
		 	 		
 		/* Chart Style */ 
 		@media only screen and (min-device-width: 1200px) and (max-device-width: 1380px) and (-webkit-min-device-pixel-ratio: 1)  {
 			.wrapper_chart { 		
	 			max-width: 360px !important; 
	 			min-height: 480px;
	 			max-height: 480px;
	 			padding: 0; 			
	 			background: #FFFFFF;	
	 			border: 1px solid #D4D4D4;		 		
 			}
 			
 			.wrapper_chart_fixed { 	 
 				max-width: 555px; 		
	 			padding: 0; 			
	 			background: #FFFFFF;	
	 			border: 1px solid #D4D4D4;		 		
	 		}	
 		
 		}
 		
 		.wrapper_chart { 		
 			max-width: 380px; 
 			min-height: 480px;
 			max-height: 480px;
 			padding: 0; 			
 			background: #FFFFFF;	
 			border: 1px solid #D4D4D4;		 		
 		}
 		
 		.wrapper_chart_customfixed { 
 			max-height: 300px; 	 	
 			padding: 0; 			
 			background: #FFFFFF;	
 			border: 1px solid #D4D4D4;		 		
 		}
 		
 		.wrapper_chart_fixed { 	 
 			max-width: 575px; 		
 			padding: 0; 			
 			background: #FFFFFF;	
 			border: 1px solid #D4D4D4;		 		
 		}	
 		
 		.wrapper_header {
 			color: #FFF;
 			padding: 10px;
 			font-size: 1.2em;
 			font-weight: bold;
 			background-color: #4390DF;
 		}
 		
 		.wrapper_title {
 			padding: 3px 0;
 			font-weight: bold;
 			background-color: #A2CFC5;
 		}
 		
 		.bgBlue { background-color: #7CBB00; }
 		
 		.devGagugeCustom { height: 265px; }
 		.dxg-title-custom {
			font-color: #FFFFFF !important;
			font-family: Arial;
			font-weight: 800;
			font-size: 16px;
			text-align: center;
		}
						
		.chart_hoding {
			color: gray !important;
			font-size: 18px;
			margin: 50% auto; 
			text-align: center;
			-webkit-transform: rotate(-40deg);
			-moz-transform: rotate(-40deg);
			-ms-transform: rotate(-40deg);
			-o-transform: rotate(-40deg);
			filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);	
		}
		
		#productivities_chart > svg.dxg.dxbg-bar-gauge {
	    	margin-left: -60px;
		}
		
		.progress { height: 40px; vertical-align: middle; }
		.progress-bar > span { margin-left: 10%; }
 	
 	</style>
 	
</head>
<body>

<div id="element_session">
	<input id="profiler" name="profiler" type="hidden" value="<?php echo !empty($_GET['rel']) ? $_GET['rel']:$session_data['emp_id']; ?>">
	<input id="emp_id" name="emp_id" type="hidden" value="<?php echo !empty($_GET['rel']) ? $_GET['rel']:$session_data['emp_id']; ?>">
	<input id="branchCode" name="branchCode" type="hidden" value="<?php echo $session_data['branchcode']; ?>">
	<input id="areaCode" name="areaCode" type="hidden" value="">
	<input id="authCode" name="authCode" type="hidden" value="<?php echo $session_data['auth'] ?>">
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
	        		<?php $param = !empty($_GET['rel']) ? $_GET['rel']:$session_data['emp_id']; ?>
	        		<a href="<?php echo site_url('report/gridDataList').'?rel='.$param; ?>">
	        			<span class="tooltip-right" data-tooltip="Dashboard">
	        				<i class="fa fa-home fa-2x"></i>
	        			</span>
	        		</a>
	        		<span id="btnInfoModal" class="tooltip-right marginLeft15" data-tooltip="Infomation">
	        			<i class="ti-info-alt fa-2x"></i>
	        		</span>
	        	</li>
	        </ul>
	        <ul class="nav navbar-nav navbar-right">	        
		    	<li><span class="using_information"></span></li>
      		</ul>	
      	</div>		
	</div>
</div>

<div id="page">

	<div class="content">	
	
		<div class="container-fluid">
			<div class="row">
			
				<div class="col-sm-10 col-md-10">
					
					<div class="row">
						
						<div class="wrapper_chart col-sm-4 col-md-4 marginRight10">
							<div class="wrapper_header">Prospect List & NCB</div>
							<div id="prospect_header" class="wrapper_title addChartText"></div>
							<div class="wrapper_content">								
								<canvas id="prospect_chart" style="min-height: 195px;"></canvas>					
							</div>
							<div id="ncb_header" class="wrapper_title addChartText"></div>
							<div class="wrapper_content">								
								<canvas id="ncbconsent_chart" style="min-height: 195px;"></canvas>						
							</div>							
						</div>
						
						<div class="wrapper_chart col-sm-4 col-md-4 marginRight10">
							<div class="wrapper_header">A2CA & Quality App</div>
							<div class="wrapper_content">		
								<section id="appqualitychart_values" style="height: 302px;"></section>		
								<section id="appquality_info" class="marginTop10 marginBottom5"></section>		
							</div>
						</div>
						
						<div class="wrapper_chart col-sm-4 col-md-4">
							<div class="wrapper_header">Target & Actual DD</div>
							<div class="wrapper_content">
								<section id="targetchart_values" style="height: 302px;"></section>			
								<section id="target_info" class="marginTop10 marginBottom5"></section>						
							</div>
						</div>
											
					</div>
			
					<div class="row marginTop15">
					
						<div class="wrapper_chart col-sm-4 col-md-4 marginRight10">
							<div class="wrapper_header">Out Standing</div>
							<div class="wrapper_content">
								<section id="os_chart"></section>				
							</div>
						</div>
						
						<div class="wrapper_chart col-sm-4 col-md-4 marginRight10">
							<div class="wrapper_header">Loan Monitor</div>
							<div class="wrapper_content">
								<div id="loanmonitorchart_values" style="height: 400px;"></div>				
							</div>
						</div>
						
						<div class="wrapper_chart col-sm-4 col-md-4">
							<div class="wrapper_header">Approval Rate</div>
							<div class="wrapper_content">
								<section id="approvalrate_chart" style="height: 302px;"></section>					
								<div id="approvalrate_info"></div>						
							</div>
						</div>
					
					</div>
					
					<div class="row marginTop15">
					
						<div class="wrapper_chart col-sm-4 col-md-4 marginRight10">
							<div class="wrapper_header">Non Quality Reason</div>
							<div class="wrapper_content">
								<div class="chart_hoding">Coming Soon!</div>		
							</div>
						</div>
					
						
						<div class="wrapper_chart col-sm-4 col-md-4 marginRight10">
							<div class="wrapper_header">Reject Reason</div>
							<div class="wrapper_content">
								<section id="rejectreason_chart"></section>						
							</div>
						</div>
						
						<div class="wrapper_chart col-md-4">
							<div class="wrapper_header">Cancel Reason</div>
							<div class="wrapper_content">
								<section id="cancelreason_chart" ></section>						
							</div>
						</div>
			
					</div>
					
						<div class="row marginTop15">
					
						<div class="wrapper_chart_fixed col-sm-6 col-md-6">
							<div class="wrapper_header">Product Program</div>
							<div class="wrapper_content">
								<div class="chart_hoding">Coming Soon!</div>		
							</div>
						</div>
					
						
						<div class="wrapper_chart_fixed col-sm-6 col-md-6 marginLeft10">
							<div class="wrapper_header">SB Portfolio</div>
							<div class="wrapper_content">
								<div class="chart_hoding">Coming Soon!</div>						
							</div>
						</div>
					
			
					</div>				
				
				</div>
				<div class=" col-sm-2 col-md-2">
					<div class="row">
					
						<div class="wrapper_chart col-sm1-2 col-md-12">
							<div class="wrapper_header text-center">Average</div>
							<div class="wrapper_content">							
								<div id="gauge_a2cachart_values" class="devGagugeCustom marginTopEasing40"></div>
								<div id="a2ca_lagend" class="dxg-title-custom marginTopEasing30 legendDisplay"></div>										
							</div>
							<div class="wrapper_content">
								<section id="gauge_drawdownchart_values" class="devGagugeCustom marginTopEasing40"></section>
								<div id="actual_dd_lagend" class="dxg-title-custom marginTopEasing30 marginBottom10 legendDisplay"></div>							
							</div>
						</div>		
					
					</div>
					<div class="row marginTop15">
						<div class="wrapper_chart col-sm-12 col-md-12">			
							<div class="wrapper_content">				
								<section id="gauge_ticketsizechart_values" class="devGagugeCustom marginTopEasing40"></section>
								<div id="ticket_legend" class="dxg-title-custom marginTopEasing15 legendDisplay"></div>
							</div>
							<div class="wrapper_content">
								<section id="gauge_approvalchart_values" class="devGagugeCustom marginTopEasing40"></section>
								<div id="appr_legend" class="dxg-title-custom marginTopEasing15 marginBottom10 legendDisplay"></div>												
							</div>
						</div>					
					</div>					
					<div class="row marginTop15">						
						<div class="wrapper_chart col-sm-12 col-md-12">
							<div class="wrapper_header text-center">Insurance</div>
							<div class="wrapper_content">
								<div id="mrta_chart_values" class="marginTop20"></div>
				  				<div id="cashy_chart_values" class="marginTop40"></div>													
							</div>
						</div>					
					</div>
					<div class="row marginTop15">

						<div class="wrapper_chart_customfixed col-sm-12 col-md-12">
							<div class="wrapper_header text-center">Productivity</div>
							<div class="wrapper_content">
								<div id="productivities_chart" class="marginTopEasing30 marginRight20" style="min-height: 400px; min-width: 280px;"></div>								
							</div>
						</div>
						
						<div class="wrapper_chart col-sm-12 col-md-12 marginTop10">
							<div class="wrapper_header text-center">SB Portfolio</div>
							<div class="wrapper_content">
								<header style="font-weight: bold;">Class A</header>
								<div class="progress">								
								  <div class="progress-bar progress-bar-success" style="width: 50%">
								    <span>50%</span>
								  </div>
								  <div class="progress-bar progress-bar-warning" style="width: 25%">
								    <span>25%</span>
								  </div>
								  <div class="progress-bar progress-bar-danger" style="width: 25%">
								    <span>25%</span>
								  </div>
								</div>		
								<span></span>															
							</div>
							<div class="wrapper_content">
								<header style="font-weight: bold;">Class M</header>
								<div class="progress">								
								  <div class="progress-bar progress-bar-success" style="width: 60%">
								    <span>60%</span>
								  </div>
								  <div class="progress-bar progress-bar-warning" style="width: 40%">
								    <span>40%</span>
								  </div>
								</div>
								<span></span>									
							</div>
							<div class="wrapper_content">
								<header style="font-weight: bold;">NPL</header>
								<div class="progress">								
								  <div class="progress-bar progress-bar-success" style="width: 20%">
								      <span>10%</span>
								  </div>
								  <div class="progress-bar progress-bar-warning" style="width: 25%">
								      <span>10%</span>
								  </div>
								  <div class="progress-bar progress-bar-warning" style="width: 25%">
								  	  <span>25%</span>
								  </div> 
								  <div class="progress-bar progress-bar-warning" style="width: 30%">
								  	  <span>40%</span>
								  </div>
								</div>									
							</div>
							<div class="wrapper_content">
								<header style="font-weight: bold;">TDR/Releif</header>
								<div class="progress">								
									  <div class="progress-bar progress-bar-success" style="width: 50%">
									      <span>50%</span>
									  </div>
									  <div class="progress-bar progress-bar-warning" style="width: 50%">
									      <span>50%</span>
									  </div>
								</div>																
							</div>							
						</div>
					
					</div>
				</div>	

  			</div>			
		</div>
		
	</div>
	
	<nav id="menu" class="mm-panel-fix">
		<?php $this->load->view('frontend/content/report/kpi/sidebar_left'); ?>
	</nav>

</div>

<script src="<?php echo base_url('js/vendor/jquery.2.1.4.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.mousewheel.js'); ?>"></script>

<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugin/mmenu/core/js/jquery.mmenu.min.all.js'); ?>"></script>
<script src="<?php echo base_url('js/plugin/mmenu/addons/js/jquery.mmenu.offcanvas.min.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/sparkline/jquery.sparkline.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.rotate.min.js'); ?>"></script>

<script src="<?php echo base_url('js/chart/justgage/raphael-2.1.4.min.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/justgage/justgage.js'); ?>"></script>

<script src="<?php echo base_url('js/chart/chartJS/ChartNew.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/chartJS/Add-ins/shapesInChart.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/chartJS/Add-ins/stats.js'); ?>"></script>

<script src="<?php echo base_url('js/chart/highchart/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/highchart/funnel.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/highchart/highcharts-3d.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/highchart/highcharts-more.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/highchart/exporting.js'); ?>"></script>

<script src="<?php echo base_url('js/knockout-min.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/devExtream/globalize.min.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/devExtream/dx.chartjs.js'); ?>"></script>

<script src="<?php echo base_url('js/chart/amchart/amcharts/amcharts.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/amchart/amcharts/funnel.js'); ?>"></script>

<script src="<?php echo base_url('js/build/chart/treeview_menu.js'); ?>"></script>
<script src="<?php echo base_url('js/build/chart/chart_render.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
<script src="<?php echo base_url('js/chart/google/jsapi.js'); ?>"></script>
<script type="text/javascript">

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

var employee_code 	= $('#emp_id').val(); 
var service_path	= 'http://172.17.9.65/WsLendingBranchServices/PCISService.svc/';

$(function() {

	// Loan Profile
	var urlProfile  	= service_path + "GetKPI00ProfileReport";
	loadProfile(urlProfile, $('#profiler').val());

	// Get Prospect List & NCB
	var urlProspect 	= service_path + "GetKPI01ProspectListReport";
	loadProspectTargetList(urlProspect, employee_code);

	var urlNCBConsent	= service_path + "GetKPI17NCBReport";
	loadNCBOnloadList(urlProspect, employee_code);


	//*** Loading: inside right chart	::::::::::::::::::::::::::::::::::::::::::::::::::::::
	var urlAvgAppToCA	= service_path + "GetKPIKPI12AppToCAReport",
		urlAvgApproval	= service_path + "GetKPI13AppvRateReport",
		urlAvgDrawdown	= service_path + "GetKPI11DrawdownReport",
		urlAvgTicket	= service_path + "GetKPI14TicketSizeReport";

	var urlLoanGrid		= service_path + "GetKPI08LoanMonitoringReport";
		loadLoanMonitoring(urlLoanGrid, employee_code);	

	var urlCancel  		= service_path + "GetKPI09CancelReasonReport",
		urlReject   	= service_path + "GetKPI10RejectReasonReport";
		loadCancelReason(urlCancel, employee_code);  
		loadRejectReason(urlReject, employee_code);

	var urlGetInsurance	= service_path + "GetKPI15MRTACashyReport";
		// Function :
		loadGaugeAverage([urlAvgAppToCA, urlAvgApproval, urlAvgDrawdown, urlAvgTicket], employee_code); // Average
		loadGaugeInsurance(urlGetInsurance, employee_code, false); // Insurance

		loadProductivity();
		loadChartOSWithPaid('', employee_code);
		
});

//Google Table - Option Loading: 
google.load("visualization", "1.1", { packages:['corechart', 'table'] });
google.setOnLoadCallback(drawChart);
function drawChart() {

	var urlAppQuality   = service_path + "GetKPI16A2CAQualityAppReport";
		loadApp2CAWithQuality(urlAppQuality, employee_code); 

	var urlTarget		= service_path + "GetKPI05ActualDrawdownReport";  		
		loadActualTarget(urlTarget, '56513');
	
	var urlApprovedRate	= service_path + "GetKPI03StatusReport";
		loadApprovelRate(urlApprovedRate, employee_code);
	
		
}

</script>

</body>
</html>