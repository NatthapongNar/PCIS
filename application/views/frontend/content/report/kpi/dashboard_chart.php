<!DOCTYPE html>
<html>
<head ng-app>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $author; ?></title>
    <meta name="description" content="<?php echo $desc; ?>">    
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/logo.ico'); ?>">
    
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/responsive.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/core/css/jquery.mmenu.all.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.themes.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.effects.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.borderstyle.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/themify-icons.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/mmenu.css'); ?>">	
 	<link  rel="stylesheet" href="<?php echo base_url('css/custom/wp.custom.css'); ?>">
 	<style type="text/css">
 	
	 	div.navbar a {
	    	display: inline-block;
		}
		
		ul li:after {
		    content: "|";
		}
		
		ul li:last-child:after {
		    content: "";
		}
		
		#loanmonitorchart_values {
			width		: 100%;
			height		: 430px;
			font-weight : bold;
		}
		.clearLayout { clear: both; }
		
		/** Override Style **/
		body, .content { 
 			background-color: #303030; 
 		}
 		
		.panel-heading { 
			color: gray !important;
			font-weight: bold;
			font-family: Arial !important; 
		}
		
		.panel-body { 
			background: #303030; 
		}
		
		/** Gauge custom **/
		.dxg-title-custom {
			font-color: #FFFFFF !important;
			font-family: Arial;
			font-weight: 800;
			font-size: 16px;
			text-align: center;
		}
		
		.dx-gauge-widthfixed { height: 180px; }
		
		.dx-gauge-redcolor { color: #e15258;  }
		.dx-gauge-greencolor { color: #a6c567 }
		.dxg-cusom-text { padding-top: 20px !important; }
		
	
		
		/** Optional Style **/
		.hidden { display: none; }
		.show { display: block; }
		
		.bl1 { 
			min-height: 475px !important; 
			max-height: 475px !important; 
		}
		
		.bl2 { 
			min-height: 465px !important; 
			max-height: 465px !important; 
		}
		
		.bl3 {
			min-height: 350px !important; 
			max-height: 350px !important; 			
		}
		
		/** Custom Text **/
		.lagend_custom > span { 
			color: #FFF; 
			font-family: Arial;
			font-size: 12px;
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
		
		.iconChart {
		 	cursor: pointer;
		 	margin-left: 10px;
		}
		
		/** Table Style **/
		.table-custom-header { 
		 	color: #FFF;
		 	font-family: 'Arial';
		 	background: #1ba1e2 !important; 
		 	border: 1px solid #FFF;
		 }	 
		 
		 .table-custom-cell {
		 	color: #FFF;
		 	text-align: center;
		 	font-family: 'Arial';
		 } 
		 
		 .table-custom-select { 
		 	color: #000;
		 	font-family: 'Arial';  
		 }
		 
		  .table-custom-hover { 
		 	color: #000;
		 	font-family: 'Arial'; 
		 }
		
 	</style>
</head>
<body>

<div id="element_session">
	<input id="profiler" name="profiler" type="hidden" value="<?php echo $session_data['emp_id']; ?>">
	<input id="emp_id" name="emp_id" type="hidden" value="57432">
	<input id="branchCode" name="branchCode" type="hidden" value="<?php echo $session_data['branchcode']; ?>">
	<input id="areaCode" name="areaCode" type="hidden" value="">
	<input id="authCode" name="authCode" type="hidden" value="<?php echo $session_data['auth'] ?>">
</div>

<div class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">		
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mm-navbar-collapse" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </button>
			<a class="navbar-brand" href="#menu"><i class="fa fa-sign-in fa-2x marginTopEasing10"></i></a>
			<a class="navbar-brand active" href="#">PCIS</a>			
		</div>	
		<div id="mm-navbar-collapse" class="collapse navbar-collapse">
		<ul class="nav navbar-nav navbar-right">
	        <li><a href="<?php echo site_url('report/gridDataList'); ?>"><i class="fa fa-home"></i> Home</a></li>
		    <li><span class="using_information"></span></li>
      	</ul>	
      	</div>
	</div>
</div>

<div id="page">

	<div class="content">		
		<div class="row">	
			<!-- WRAPPER CONTENT -->
			<div class="col-md-10">	
			
				<!-- BLOCK 1 -->
				<div class="row">	
					
					<div class="col-md-4">						
						<div class="panel panel-default">
							<div class="panel-heading">
								Prospect List & NCB
								<i class="iconChart fa fa-info pull-right"></i>
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
							</div>						
						  	<div class="panel-body bl1" style="padding: 0 12px 0 0;">						  		
								<span id="prospect_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>
								
								<div id="prospectchart_custom_lagend" class="lagend_custom"></div>										 
								<canvas id="prospectchart_values" style="height: 210px; min-height: 210px;"></canvas>	
								
								<div id="ncbchart_custom_lagend" class="lagend_custom"></div>
								<canvas id="ncbchart_values" style="height: 210px; min-height: 210px;"></canvas>	  	
						  	</div>
						</div>						 					  					
					</div>
				
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								A2CA & Quality App		
								<i class="iconChart fa fa-info pull-right"></i>
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
								<span id="appquality_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>							
							</div>						
						  	<div class="panel-body bl1">						  		
								<section id="appqualitychart_values" style="height: 302px;"></section>		
								<section id="appquality_info" class="marginTop10 marginBottom5"></section>				  	
						  	</div>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								Target & Actual DD
								<i class="iconChart fa fa-info pull-right"></i>
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
							</div>						
						  	<div class="panel-body bl1">
								<span id="target_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>		
								<section id="targetchart_values" style="height: 302px;"></section>			
								<section id="target_info" class="marginTop10 marginBottom5"></section>		  	
						  	</div>
						</div>
					</div>	
				
				</div>
				
				<!-- BLOCK 2 -->
				<div class="row clearLayout">	
				
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								Out Standing
								<i class="iconChart fa fa-info pull-right"></i>
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
							</div>						
						  	<div class="panel-body bl1">
						  		<div class="chart_hoding">Coming Soon!</div>
								<section id="os_chart"></section>
							</div>							
						</div>
					</div>					
										
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								Loan Monitor
								<i class="iconChart fa fa-info pull-right"></i>
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
							</div>						
						  	<div class="panel-body bl1">						
								<div id="loanmonitorchart_values"></div>										
							</div>							
						</div>
					</div>
					
					<div class="col-md-4">	
					<div class="panel panel-default">                     
						<div class="panel-heading">
							Approval Rate 
							<i class="iconChart fa fa-info pull-right"></i>
							<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
						</div>	
						<div class="panel-body bl1">					
							<span id="approval_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>									
							<section id="approvalrate_chart" style="height: 300px;"></section>					
							<div id="approvalrate_info"></div>							
						</div>				
					</div>	
					</div>	
				
				</div>
				
				<!-- BLOCK 3 -->
				<div class="row clearLayout">
				
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								Non Qualify Reason
								<i class="iconChart fa fa-chevron-circle-down pull-right"></i>				
								<i class="iconChart fa fa-info pull-right marginRight5"></i>								
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>	
							</div>						
						  	<div class="panel-body bl3">	
						  		<div class="chart_hoding">Coming Soon!</div>				
						  		<section id="nonqualify_chart_values"></section>						  	
							</div>							
						</div>
					</div>	
					
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								Reject Reason
								<i class="iconChart fa fa-chevron-circle-down pull-right"></i>				
								<i class="iconChart fa fa-info pull-right marginRight5"></i>								
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>				
							</div>						
						  	<div class="panel-body bl3">
							  	<div class="chart_hoding">Coming Soon!</div>
								<section id="rejectreason_chart_values"></section>					  			
							</div>							
						</div>
					</div>	
							
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								Cancel Reason								
								<i class="iconChart fa fa-chevron-circle-down pull-right"></i>				
								<i class="iconChart fa fa-info pull-right marginRight5"></i>								
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>	
							</div>						
						  	<div class="panel-body bl3">
						  		<div class="chart_hoding">Coming Soon!</div>
								<section id="cancelreason_chart_values"></section>		
							</div>							
						</div>
					</div>	
				
				</div>
				
				<!-- BLOCK 4 -->
			
			</div>
			<!-- END WRAPPER CONTENT -->
			<!-- RIGHT BAR -->
			<div class="col-md-2">						
			
				<!-- AVERAGE -->
				<div class="panel panel-default">
				  <div class="panel-heading text-center">
				  	<span class="marginRightEasing35">Average</span>
				  	<i class="iconChart fa fa-info pull-right"></i>
					<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
				  </div>							
				  <div class="panel-body">		
				  
						<span id="average_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>	
						
				  		<div id="gauge_a2cachart_values" class="dx-gauge-widthfixed"></div>		
				  		<footer class="dxg-title-custom" style="color: #FFF;">A2CA</footer>		 		
				  		
				  		<hr />
				  		
				  		<section id="gauge_drawdownchart_values" class="dx-gauge-widthfixed"></section>	
				  		<footer class="dxg-title-custom" style="color: #FFF;">Actual DD</footer>
				  
				  </div>
				</div>
				
				
				<div class="panel panel-default">
				<div class="panel-body" style="min-height: 515px; max-height: 515px;">
					<section id="gauge_ticketsizechart_values" class="dx-gauge-widthfixed"></section>	
				  	<footer class="dxg-title-custom" style="color: #FFF; margin-top: 15px;">Ticket Size</footer>
				  	
					<hr />	
				  		
				  	<section id="gauge_approvalchart_values" style="width: 190px; margin-top: -80px;"></section>	
				  	<footer class="dxg-title-custom" style="color: #FFF; margin-top: -40px;"">Approval Rate</footer>
				 
				</div>
				</div>
				<!-- END AVERAGE -->
				
				<!-- INSURANCE -->
				<div class="panel panel-default">
				  <div class="panel-heading text-center">
				  	Insurance
				  	<i class="iconChart fa fa-info pull-right"></i>
					<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
				  </div>				
				  <div class="panel-body text-center" style="min-height: 350px; max-height: 350px;">	  	  		
				  		<div id="mrta_chart_values" style="height: 175px;"></div>
				  		<div id="cashy_chart_values" style="height: 175px;"></div>				  	
				  </div>
				</div>
				<!-- END INSURANCE -->
				
			</div>
			<!-- END RIGHT BAR -->			
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

<script src="<?php echo base_url('js/plugin/mmenu/core/js/jquery.mmenu.min.all.js'); ?>"></script>
<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>

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

<script src="<?php echo base_url('js/build/chart/dashboard_chart.js'); ?>"></script>
<script src="<?php echo base_url('js/build/chart/treeview_menu.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
<!-- Last loader: Google chart -->
<script src="<?php echo base_url('js/chart/google/jsapi.js'); ?>"></script>
<script type="text/javascript">

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

var employee_code 	= $('#emp_id').val(); 
var url_path		= "http://172.17.9.65/WsLendingBranchServices/PCISService.svc/";
//var url_path		= 'http://172.17.9.68/LendingBranchServices/PCISService.svc/'; // UAT

$(function() {

	//Cancel & Reject Reaon
	var urlCancel   = url_path + "GetKPI09CancelReasonReport";
	var urlReject   = url_path + "GetKPI10RejectReasonReport";


	//*** Loading: inside content chart	 ::::::::::::::::::::::::::::::::::::::::::::::::::::
	var urlProfile  	= url_path + "GetKPI00ProfileReport";
		// Function :
		loadProfile(urlProfile, $('#profiler').val());  


	// Load Prospect and NCB 
	var urlProspect 	= url_path + "GetKPI01ProspectListReport",
		urlNCBConsent	= url_path + "GetKPI17NCBReport";
		// Function :
		loadProspectTargetList(urlProspect, employee_code);
		loadNCBOnloadList(urlNCBConsent, employee_code);


	var urlLoanGrid = url_path + "GetKPI08LoanMonitoringReport";
		// Function :
		loadLoanMonitoring(urlLoanGrid, employee_code);	
	
	

	//*** Loading: inside right chart	::::::::::::::::::::::::::::::::::::::::::::::::::::::
	var urlAvgAppToCA	= url_path + "GetKPIKPI12AppToCAReport",
		urlAvgApproval	= url_path + "GetKPI13AppvRateReport",
		urlAvgDrawdown	= url_path + "GetKPI11DrawdownReport",
		urlAvgTicket	= url_path + "GetKPI14TicketSizeReport";

	var urlGetInsurance	= url_path + "GetKPI15MRTACashyReport";
		// Function :
		loadGaugeAverage([urlAvgAppToCA, urlAvgApproval, urlAvgDrawdown, urlAvgTicket], employee_code); // Average
		loadGaugeInsurance(urlGetInsurance, employee_code, false); // Insurance

	
	
});

//Google Table - Option Loading: 
google.load("visualization", "1.1", { packages:['corechart', 'table'] });
google.setOnLoadCallback(drawChart);
function drawChart() {

	var urlAppQuality   = url_path + "GetKPI16A2CAQualityAppReport";
		loadApp2CAWithQuality(urlAppQuality, employee_code); 

	var urlTarget		= url_path + "GetKPI05ActualDrawdownReport";  		
		loadActualTarget(urlTarget, '56513');

	var urlApprovedRate	= url_path + "GetKPI03StatusReport";
		loadApprovelRate(urlApprovedRate, employee_code);

		
}

</script>

</body>
</html>