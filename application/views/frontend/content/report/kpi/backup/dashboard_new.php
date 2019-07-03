<!DOCTYPE html>
<html>
<head ng-app>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $author; ?></title>
    <meta name="description" content="<?php echo $desc; ?>">    
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/logo.ico'); ?>">
    
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/responsive.css'); ?>" />
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/core/css/jquery.mmenu.all.css'); ?>" />
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.themes.css'); ?>" />
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.effects.css'); ?>" />
 	<link rel="stylesheet" href="<?php echo base_url('css/themify-icons.css'); ?>" />
 	<link rel="stylesheet" href="<?php echo base_url('css/themify-icons.css'); ?>" />
 	<link rel="stylesheet" href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>" >
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/mmenue_pattern.css'); ?>" />
 	
 	<link href="<?php echo base_url('css/custom/wp.custom.css'); ?>" rel="stylesheet">
	<style type="text/css">
			
		body { 			
			font-family: "Arial",Helvetica Neue,Helvetica,sans-serif !important;
 		}
 		
 		.content { 
 			background-color: #000; 
 		}
		
		.panel-heading { 
			color: gray !important;
			font-weight: bold;
			font-family: Arial !important; 
		}
		
		.panel-body { 
			background: #000; 
		}
		
		/* CSS Overide */
		
		.mm-title { 
			color: #FFF !important;
			font-family: 'Raleway',sans-serif !important; 
			text-transform: uppercase;
		}		
		
		/*
		.mm-navbar { background: #777777 !important; border-right: 1px solid gray !important; }
		*/
		.mm-panel-wfix { 
			width: 250px; 
			/*background: #303030;*/ 
		}	
		
		.dxg-title text { 
			color: #000 !important;	
		}
		
		.dxg-title-custom {
			font-color: #FFFFFF !important;
			font-family: Arial;
			font-weight: 800;
			font-size: 16px;
			text-align: center;
		}
		
		#loanmonitorchart_values {
			width		: 100%;
			height		: 430px;
			font-weight : bold;
		}
		
		.border_horizon { border-color: gray; }
		
		.mm-custom-nav {		
			cursor: pointer; 
			float: right; 
			font-size: 1em;
		}
		
		table.table, tr, th, td { text-align: center; }
		
		.gauge_container {
	        text-align: left;
	        height: 450px;
	        display: inline-block;
/* 	        border: 1px solid #ccc; */
	        margin: 40px 5px 0 5px;
/* 	    } */
	
	    .gauge {
	        width: 300px;
	        height: 200px;
	        display: inline-block;
	        -webkit-transform: translate3d(0, 0, 0);
	    }

	    .wrapper_span {
	    	color: #FFF;
	    	cursor: pointer;
	    	margin-bottom: 5px; 
	    }

	    .hidden { display: none; }
		.show { display: block; }
	    		
		.dx-gauge-themefixed { height: 180px; }
		.dx-gauge-style {
			
			font-weight: 800; 
			font-size: 0.9em !important;
		}
		
		.dx-gauge-redcolor { color: #e15258;  }
		.dx-gauge-greencolor { color: #a6c567 }
		.dxg-cusom-text { padding-top: 20px !important; }
			 
		@media all and (min-width: 250px) {
		 	html.mm-opening .mm-slideout {
			    -webkit-transform: translate(250px, 0);
			    -moz-transform: translate(250px, 0);
			    -ms-transform: translate(250px, 0);
			    -o-transform: translate(250px, 0);
			    transform: translate(250px, 0); 
		    } 
		 }
		 
		 .iconChart {
		 	cursor: pointer;
		 	margin-left: 10px;
		 }

		 .lagend_custom > span { color: #FFF; }
		 
		 .modal-content { width: 1300px; }		
		 
		 .table-custom-header { 
		 	color: #FFF;
		 	font-family: 'Arial';
		 	background: #303030 !important; 
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
		 
		 table tbody tr:hover td { 
		 	color: #000 !important;
		 	font-family: 'Arial';  
		 }
				
		.table-striped tbody tr.highlight td { background-color: red !important; } 	
		 				 
		 .lagend_custom { 
		 	font-family: Arial; 
		 	font-size: 12px; 
		 	text-align: right; 
		 }
		 
		 #data_marker { 
		 	background: #000;
		 	position: relative;
		 	display: inline-block; 
		 	font-family: Arial; 
		 	font-size: 16px; 
		 	font-weight: 800;
		 	text-align: center;
		 	min-width: 220px; 
		 	border-bottom: 1px solid #000;
		 }
		 
		 .data_MTD { 
			color: white;
			padding: 0 35px;
		 	background-color: #a6c540;
		 	margin-left: -5px; 
		 }
		 .data_YTD { 
		 	color: white;
		    padding: 0 35px;
		 	background-color: #e15258; 
		 	margin-right: -5px; 
		 }
				
	</style>
</head>
<body>

<!--  -->
<div id="element_session">
	<input id="profiler" name="profiler" type="hidden" value="<?php echo $session_data['emp_id']; ?>">
	<input id="emp_id" name="emp_id" type="hidden" value="57432">
	<input id="branchCode" name="branchCode" type="hidden" value="<?php echo $session_data['branchcode']; ?>">
	<input id="areaCode" name="areaCode" type="hidden" value="">
	<input id="authCode" name="authCode" type="hidden" value="<?php echo $session_data['auth'] ?>">
</div>

<div id="page">
	<!-- Header Navigator -->
	<div class="header">
		<a href="#menu"></a>
		PCIS
		<span class="using_information">			
			
		</span>		
		<span id="mm_navtool" class="pull-right">
			<span class="mm_itool">
				<span class="itool" onclick="javascript:window.history.back();">
					<i class="glyphicon glyphicon-blackboard"></i>
					<div>Dashboard</div>
				</span>
			</span>				
		</span>				
	</div>
	<!-- Content Mangement -->
	<div class="content">
		
		<div class="row">	
			<div class="col-md-10">				
				<div class="row">		
						
					<div class="col-md-4" style="min-height: 420px;">						
						<div class="panel panel-default">
							<div class="panel-heading">
								Prospect List & NCB
								<i class="iconChart fa fa-info pull-right"></i>
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
							</div>						
						  	<div class="panel-body" style="padding: 0 12px 0 0;">						  		
								<span id="prospect_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>
								
								<div id="prospectchart_custom_lagend" class="lagend_custom"></div>										 
								<canvas id="prospectchart_values" style="height: 210px; min-height: 210px;"></canvas>	
								
								<div id="ncbchart_custom_lagend" class="lagend_custom"></div>
								<canvas id="ncbchart_values" style="height: 210px; min-height: 210px;"></canvas>	  	
						  	</div>
						</div>						 					  					
					</div>
				
					<div class="col-md-4" style="max-height: 420px;">
						<div class="panel panel-default">
							<div class="panel-heading">
								A2CA & Quality App		
								<i class="iconChart fa fa-info pull-right"></i>
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>							
							</div>						
						  	<div class="panel-body">						  		
								<span id="appquality_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>
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
						  	<div class="panel-body">
								<span id="target_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>		
								<section id="targetchart_values" style="height: 302px;"></section>			
								<section id="target_info" class="marginTop10 marginBottom5"></section>		  	
						  	</div>
						</div>
					</div>	
					
				
				</div>
				
				<div class="row" style="clear: both;">				
					
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								Out Standing
								<i class="iconChart fa fa-info pull-right"></i>
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
							</div>						
						  	<div class="panel-body" style="height: 460px;">
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
						  	<div class="panel-body">
								<span id="loanmonitor_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>
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
						<div class="panel-body">					
							<span id="approval_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>									
							<section id="approvalrate_chart" style="height: 300px;"></section>					
							<div id="approvalrate_info"></div>							
						</div>				
					</div>	
					</div>							

				</div>
				
				<div class="row">
				
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								Non Qualify
								<i class="iconChart fa fa-bars pull-right"></i>				
								<i class="iconChart fa fa-info pull-right marginRight5"></i>								
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>	
							</div>						
						  	<div class="panel-body" style="max-height: 350px;">					
						  		<section id="nonqualify_chart_values"></section>						  	
							</div>							
						</div>
					</div>	
					
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								Reject Reason
								<i class="iconChart fa fa-bars pull-right"></i>				
								<i class="iconChart fa fa-info pull-right marginRight5"></i>								
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>				
							</div>						
						  	<div class="panel-body" style="min-height: 350px;">
						  		<span id="rejectreason_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>
								<section id="rejectreason_chart_values" style="min-height: 250px;"></section>					  			
							</div>							
						</div>
					</div>	
							
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								Cancel Reason								
								<i class="iconChart fa fa-bars pull-right"></i>				
								<i class="iconChart fa fa-info pull-right marginRight5"></i>								
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>	
							</div>						
						  	<div class="panel-body" style="min-height: 350px;">
								<span id="cancelreason_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>
								<section id="cancelreason_chart_values" style="min-height: 250px;"></section>		
							</div>							
						</div>
					</div>	
							
				</div>		
				
				<div class="row">
				
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								Product Program					
								<i class="iconChart fa fa-bars pull-right"></i>				
								<i class="iconChart fa fa-info pull-right marginRight5"></i>								
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>													
							</div>						
						  	<div class="panel-body" style="min-height: 500px;">
						  		<section id="productchart_values"></section>
							</div>							
						</div>
					</div>	
				
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								SB Portfolio								
								<i class="iconChart fa fa-bars pull-right"></i>				
								<i class="iconChart fa fa-info pull-right marginRight5"></i>								
								<i class="iconChart fa fa-refresh pull-right marginRight5"></i>	
							</div>
													
						  	<div class="panel-body" style="min-height: 500px;">
						  		<section id="npl_chart"></section>							  		
						  		<section id="nplpanel_chart"></section>							  			  		
							</div>							
						</div>
					</div>	

				</div>	
				
			
							
			</div>
			
			<!-- Right bar -->
			<div class="col-md-2">						
				<div class="panel panel-default">
				  <div class="panel-heading text-center">
				  	<span class="marginRightEasing35">Average</span>
				  	<i class="iconChart fa fa-info pull-right"></i>
					<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
				  </div>							
				  <div class="panel-body">		
				
				  		<div id="gauge_a2cachart_values" class="dx-gauge-themefixed"></div>		
				  		<footer class="dxg-title-custom" style="color: #FFF;">A2CA</footer>		  		
				  		
				  		<hr />
				  		
				  		<section id="gauge_drawdownchart_values" class="dx-gauge-themefixed"></section>	
				  		<footer class="dxg-title-custom" style="color: #FFF;">Actual DD</footer>
				  
				  </div>
				</div>
			
				<div class="panel panel-default">
				<div class="panel-body">
					<section id="gauge_ticketsizechart_values" class="dx-gauge-themefixed"></section>	
				  	<footer class="dxg-title-custom" style="color: #FFF; margin-top: 15px;">Ticket Size</footer>
				  	
					<hr />	
				  		
				  	<section id="gauge_approvalchart_values" class="dx-gauge-themefixed"></section>	
				  	<footer class="dxg-title-custom" style="color: #FFF; margin-top: 15px;">Approval Rate</footer>
				 
				</div>
				</div>
				
				<div class="panel panel-default">
				  <div class="panel-heading text-center">
				  	Insurance
				  	<i class="iconChart fa fa-info pull-right"></i>
					<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
				  </div>				
				  <div class="panel-body text-center" style="min-height: 350px; max-height: 350px;">	
				  		<span id="insurance_progress" class="hidden"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>		  	  		
				  		<div id="mrta_chart_values" style="height: 175px;"></div>
				  		<div id="cashy_chart_values" style="height: 175px;"></div>				  	
				  </div>
				</div>
			
				<div class="panel panel-default">
				  	<div class="panel-heading text-center">
				  		<span>Productivity</span>
				  		<i class="iconChart fa fa-info pull-right"></i>
						<i class="iconChart fa fa-refresh pull-right marginRight5"></i>
				  	</div>				
				  	<div class="panel-body" style="min-height: 190px; max-height: 190px;">		
				  		<div id="productivity_chart" class="dx-gauge-themefixed"></div>				  		
				  	</div>
				</div>
				
				<div class="panel panel-default">
				  	<div class="panel-heading text-center">
				  		<span>SB Portfolio</span>
				  		<i class="iconChart fa fa-info pull-right"></i>
						<i class="iconChart fa fa-refresh pull-right marginRight5 "></i>
				  	</div>				
				  	<div class="panel-body" style="min-height: 245px; max-height: 245px;">	
				  
				  		<div class="col-md-12 text-right">				  		
				  			<!-- <div id="npl_info_chart1" style="height: 40px; width: 240px; margin-left: -20px;"></div> -->
				
				  			<div id="npl_info_chart2" style="height: 40px; width: 240px; margin-left: -20px;"></div>
				  			<div id="npl_info_chart2_sparkline" style="height: 30px; width: 190px; margin-left: -20px; margin-top: -5px;"></div>				  		
							  							  			
				  			<div id="npl_info_chart3" style="height: 40px; width: 240px; margin-left: -20px;"></div>
				  			<div id="npl_info_chart3_sparkline" style="height: 30px; width: 190px; max-width: 190px; margin-left: -20px;"></div>
				  	
				  			<!--  -->
				  			<div id="npl_info_chart4" style="height: 40px; width: 240px; margin-left: -20px;"></div>
				  			<!--  -->
				  			<div id="npl_info_chart5" style="height: 40px; width: 240px; margin-left: -20px;"></div>
	
				  		</div>	
				  	</div>
				</div>
	
	
			</div>
				
		</div>
		
		
				
	</div>
	
	<!-- Sidebar Navigator -->
	<nav id="menu" class="mm-panel-wfix" style="color: #FFF !important;">
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

<script src="<?php echo base_url('js/build/chart/load_chart.js'); ?>"></script>
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

// Profiler
var urlProfile  	= "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI00ProfileReport";

// Prospect List & NCB
var urlProspect 	= "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI01ProspectListReport";
var urlNCBConsent	= "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI17NCBReport";

// Average			
var urlAvgAppToCA	= "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPIKPI12AppToCAReport";
var urlAvgApproval	= "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI13AppvRateReport";
var urlAvgDrawdown	= "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI11DrawdownReport";
var urlAvgTicket	= "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI14TicketSizeReport";

// Average Supplement
var urlGetInsurance	= "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI15MRTACashyReport";

// App2ca and quality
var urlAppQuality   = "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI16A2CAQualityAppReport";

// Target & Actual
var urlTarget	= "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI05ActualDrawdownReport";    

// Approval Rate
var urlApprovedRate	= "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI03StatusReport";

// Product
var urlProduct  = "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI06ProductReport";

// Cancel & Reject Reaon
var urlCancel   = "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI09CancelReasonReport";
var urlReject   = "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI10RejectReasonReport";


var urlLoanGrid = "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI08LoanMonitoringReport";
var urlStatus   = "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI03StatusReport";

var prospect_progress 	 = $('#prospect_progress');  
var average_progress	 = $('#average_progress');
var insurance_progress	 = $('#insurance_progress');

var appquality_progress	 = $('#appquality_progress');


var product_progress  	 = $('#product_progress');
var approval_progress 	 = $('#approval_progress');
var refer_progress	  	 = $('#refer_progress');
var loanmonitor_progress = $('#loanmonitor_progress');
var avggauge_progress	 = $('#avggauge_progress');


//Load Profiler
loadProfile(urlProfile, $('#profiler').val())

// Chart Mainance
loadProductivity(urlProduct, employee_code);
loadCancelReason(urlCancel, employee_code);  
loadRejectReason(urlReject, employee_code);
loadReasonNonQualifier(urlReject, employee_code);

// OutStanding Chat
loadChartOSWithPaid(urlLoanGrid, employee_code);

// Loan Monitoring
loadLoanMonitoring(urlLoanGrid, employee_code);

// Load Prospect and NCB 
loadProspectTargetList(urlProspect, $('#prospectchart_values').attr('id'), employee_code);
loadNCBOnloadList(urlNCBConsent, $('#ncbchart_values').attr('id'), employee_code);

//Onload Function
loadGaugeAverage([urlAvgAppToCA, urlAvgApproval, urlAvgDrawdown, urlAvgTicket], employee_code); // YTD Average
loadGaugeInsurance(urlGetInsurance, employee_code, false); // YTD Insurance'56513'

//NPL Data Pie
loadNPLSummaryData(); 


//Google Chart
google.load("visualization", "1.1", { packages:['corechart', 'bar', 'table', 'gauge'] });
google.setOnLoadCallback(drawChart);

function drawChart() {

	// App2CA Report
	loadApp2CAWithQuality(urlAppQuality, $('#targetchart_values').attr('id'), '56513');

    // Acutal and target chart
    loadActualTarget(urlTarget, employee_code);
	
	// Approval Rate
	loadApprovelRate(urlApprovedRate, employee_code);  
  
}

function onDialogIsEnabled(chartName) {
	$('#myModal').modal().draggable();

	// Loading Chart Enabled 
	loadCharts(chartName);

}

$('.modal').css({
    width: 'auto',
   'margin-left': function () {
   		return -($(this).width() / 2.5);
   }
});

</script>
	
</body>
</html>
