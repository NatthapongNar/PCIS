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
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=RobotoDraft:300,400,500,700,400italic">
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/responsive.css'); ?>" />
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/core/css/jquery.mmenu.all.css'); ?>" />
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.themes.css'); ?>" />
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/extensions/css/jquery.mmenu.effects.css'); ?>" />
 	<link rel="stylesheet" href="<?php echo base_url('css/themify-icons.css'); ?>" />	
 	
 	<!-- jqGrid UI CSS -->
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap.css'); ?>" /> 	
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap-ui.css'); ?>" /> 	
 	
 	<link rel="stylesheet" href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>" >
 	<link rel="stylesheet" href="<?php echo base_url('css/focal-point.min.css'); ?>" > 	
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/mmenue_pattern.css'); ?>" />

 	<link href="<?php echo base_url('css/custom/wp.custom.css'); ?>" rel="stylesheet">
	<style type="text/css">
		
		#filterTable {
		    display:block;
		}

		/* CSS Overide */
		.mm-title { 
			color: #FFF !important;
			font-family: 'Raleway',sans-serif !important; 
			text-transform: uppercase;
		}		
		
		
		.mm-panel-wfix { width: 250px; }	
	
		@media all and (min-width: 250px) {
		 	html.mm-opening .mm-slideout {
			    -webkit-transform: translate(250px, 0);
			    -moz-transform: translate(250px, 0);
			    -ms-transform: translate(250px, 0);
			    -o-transform: translate(250px, 0);
			    transform: translate(250px, 0); 
		    } 
		 }
		 
		 #content { font-size: 0.8em; }
		 
		 .ui-jqgrid-titlebar {
		 	 height: 30px !important;
		 	 background: #4390df;
		 	 padding: 0;
		 	 margin-button: -10px;
		 }
			 
		 .ui-jqgrid { font-size: 0.9em; }
		 .ui-jqgrid tr.jqgrow td { font-size:0.9em; text-align: center; }
		 #grid_container_KPINO, #grid_container_KPILIST { height: 73px; }
		 
		 		
		 th.ui-th-column div {
		    white-space: normal !important;
		    height: auto !important;
		    padding: 2px;
		 }
			
		 div.frozen-bdiv .ui-jqgrid-bdiv { overflow: hidden; }    
		 .ui-pg-table, .navtable, .ui-common-table { border: 0 !important; }
		 
		 div.ui-jqgrid-caption { font-weight: bold !important; height: 30px !important; }
		 table tr th, .ui-jqgrid-caption { 
		 	color: #ffffff;
		 	background: #4390df;
		 }
		 
		 #grid_container_toppager { background: #4390df; }
		 #grid_container_toppager_left, #grid_container_toppager_right {
		 	color: #ffffff;
		 	background: #4390df;
		 	margin-top: -5px;
		 	padding: 0px;
		 	border-color: #4390df;
		 	
		 }
			 
		 table thead tr:hover th { 
		 	color: #ffffff !important;
		 	background: #4390df !important;
		 }
		 
		 .frozen-div{ overflow:hidden; }
		 
		 .trend_sparkline { width: 500px; } 
		 
		 #kpi_grid table, th { text-align: center; vertical-align: middle; }
		 #kpi_grid td:nth-child(2) { text-align: left; }
		 #kpi_grid td:nth-child(3) { background-color: #000; }
		 
		 i.compareState { 
		 	font-size: 1.5em; 
		 	margin-left: -5px !important;
		 }

		 /* Sparkline */
		 .jqstooltip {
		  	width: auto !important;
		  	height: auto !important;
		  }
		  
		  .frozen-bdiv {
		     height: 100px;
		     overflow-y: auto;
		  	 overflow-x: hidden !important; 
		  }
		  
		  .header { background: #4390df !important; }
		  
		  /*
		  .mm-next { width: 40px !important; }
		  .mm-next::after { margin-left: 5px !important; }
		  */
	</style>
</head>
<body>

<div id="element_session">
	<input id="profiler" name="profiler" type="hidden" value="<?php echo $session_data['emp_id']; ?>">
	<input id="emp_id" name="emp_id" type="hidden" value="<?php echo $session_data['emp_id']; ?>">
	<input id="branchCode" name="branchCode" type="hidden" value="<?php echo $session_data['branchcode']; ?>">
	<input id="areaCode" name="areaCode" type="hidden" value="">
	<input id="authCode" name="authCode" type="hidden" value="<?php echo $session_data['auth'] ?>">
</div>

<div id="page">
	<!-- Header Navigator -->
	<div class="header">
		<a href="#menu"></a> PCIS
		<span class="using_information"></span>		
		<span id="mm_navtool" class="pull-right">
			<span class="mm_itool">
				<span class="itool" onclick="javascript:window.location.href = '<?php echo site_url('report/onloadKPI'); ?>'">
					<i class="fa fa-pie-chart"></i>
					<div>Overview</div>
				</span>
			</span>				
		</span>				
	</div>
	<!-- Content Mangement -->
	<div class="content">
		
		<div class="row">		
			<table  id="grid_container"></table >			
			<div id="page_container"></div>		
		</div>
		
	</div>
	
	<!-- Sidebar Navigator -->
	<nav id="menu" class="mm-panel-wfix">
		<?php $this->load->view('frontend/content/report/kpi/sidebar_left'); ?>
	</nav>
</div>


<script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.mousewheel.js'); ?>"></script>
<script src="<?php echo base_url('js/plugin/mmenu/core/js/jquery.mmenu.min.all.js'); ?>"></script>
<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('js/treeView/jsontree.min.js'); ?>"></script>

<!-- jqGrid Library -->
<script type="text/ecmascript" src="<?php echo base_url('js/jqGrid/js/i18n/grid.locale-en.js'); ?>"></script>  
<script type="text/ecmascript" src="<?php echo base_url('js/jqGrid/js/jquery.jqGrid.min.js'); ?>"></script>

<!-- Sparkline Chart -->
<script src="<?php echo base_url('js/chart/sparkline/jquery.sparkline.min.js'); ?>"></script>
<script src="<?php echo base_url('js/build/chart/treeview_menu.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins.js'); ?>"></script>

<!-- Last loader: Google chart -->
<script src="<?php echo base_url('js/chart/google/jsapi.js'); ?>"></script>
<script type="text/javascript">

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

var urlGrid  	= "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPIWhiteBoardReport";
var urlProfile  = "http://172.17.9.68/LendingBranchServices/PCISService.svc/GetKPI00ProfileReport";
var emp_code 	= "57432"; 
	
loadProfile(urlProfile, $('#profiler').val()) // Load Profiler



$(function() {

	var d = new Date(), n = d.getMonth(); 

	var grid_main 	= "#grid_container";
	var grid_footer	= "#page_container";

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
    	monthNames  = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"                ];
    	month_name	= ['JanActual', 'FebActual', 'MarActual', 'AprActual', 'MayActual', 'JunActual', 'JulActual', 'AugActual', 'SepActual', 'OctActual', 'NovActual', 'DecActual'],
    	month_ach	= ['JanAchieve', 'FebAchieve', 'MarAchieve', 'AprAchieve', 'MayAchieve', 'JunAchieve', 'JulAchieve', 'AugAchieve', 'SepAchieve', 'OctAchieve', 'NovAchieve', 'DecAchieve'];

	var month_summ	= [	              		
   	    { label: 'NO', name: 'KPINO', width: 50, frozen: true },
   	    { label: 'KPI LIST', name: 'KPILIST', width: 250, align: 'left', frozen: true },
   	 	{ label:'GROUP', name: 'KPIGroupList', index: 'KPIGroupList' },
   	    { label: 'TREND', name: 'TREND', width: 80 },
    	{ label: 'REGION', name: 'Region', width: 80 },
   	    { label: 'LENDING', name: 'Lending', width: 80 },
   	    { label: 'TARGET', name: 'YTDTarget', formatter: getFormatTypes, width: 90 },
   	    { label: 'ACTUAL', name: 'YTDActual', width: 90 },
   	    { label: 'AVG', name: 'AVGActual', width: 90 },
   	    { label: 'SUCC (%)', name: 'Succ', formatter: getFormatPercentWithFontColors, width: 90 },
   	 	
	];
	
	var month_groupHD	= [];

    var month			= [],
    	month_active	= [],
    	month_theme		= [];

    // Current Month
    month_summ.push(    	
    	{ label: 'TARGET', name: 'CurTarget', width: 90 },
    	{ label: 'ACTUAL', name: month_name[d.getMonth()], width: 90 },
    	{ label: 'ACH (%)', name: month_name[d.getMonth()], formatter: getFormatPercentWithFontColors, width: 90 },
    	{ label: '&nbsp;', name: 'Comp', width: 30, align: 'center', formatter: dataFormatComparing }
    	
    );	
	
    month_groupHD.push(   
    	{ "numberOfColumns": 2, "titleText": "RANKING", "startColumnName": "Region" },
    	{ "numberOfColumns": 4, "titleText": "YTD", "startColumnName": "YTDTarget" },
    	{ "numberOfColumns": 3, "titleText": monthNames[d.getMonth()].toUpperCase(), "startColumnName": "CurTarget" }
    );

	for(var i = 0; i <= d.getMonth()-1; i ++) { month.push(formatMonth[i]);	}
	
	month.sort(function(a, b){return b-a});	
	for(var i = month[0]; i >= 0; i--) {
		month_summ.push(
			{ label:'ACTUAL', name: month_name[i], width: 70 },
			{ label:'ACH (%)', name: month_ach[i], formatter: getFormatPercentWithFontColors, width: 70 }
		);

		month_groupHD.push({ "numberOfColumns": 2, "titleText": monthNames[i].toUpperCase(), "startColumnName": month_name[i] });
	}

	// load data grid
	var grid = $(grid_main).jqGrid({
	        url: urlGrid,
	        mtype: "GET",
			styleUI : 'Bootstrap',
	        datatype: "jsonp",
	        postData: $.param({ KeyCode: $('#emp_id').val() }),
	        jsonReader: {
	            root: 'Data',
	            repeatitems: false
	        },     	  
	        colModel: month_summ,     		        
	        toppager: true,	    
	        shrinkToFit: false,    
			viewrecords: true,
	        height: 560, //'auto',   
	        width: 1410,    
	        rowNum: 250,
	        pager: grid_footer,
	        caption: "PERFORMANCE - GRID VIEWS",
	        grouping:true, 
	        groupingView : { 
	                    groupField : ['KPIGroupList'],
	                    groupColumnShow : [true], 
	                    //groupText : ['<b>GROUP LIST : {0} - {1} Transaction</b>'],
	                    groupCollapse : false,
	                    groupOrder: ['asc'], 
	                    groupDataSorted : true 
	        },
	        loadComplete: function (rowObject) {

	            var index = getColumnIndexByName('TREND');		
	            $('tr.jqgrow td:nth-child('+(index+1)+')').each(function(index, value) {
		   		
		            $(this).sparkline([
						rowObject['Data'][index].JanActual, rowObject['Data'][index].FebActual, rowObject['Data'][index].MarActual, 
						rowObject['Data'][index].AprActual, rowObject['Data'][index].MayActual, rowObject['Data'][index].JunActual, 
						rowObject['Data'][index].JulActual, rowObject['Data'][index].AugActual, rowObject['Data'][index].SepActual, 
						rowObject['Data'][index].OctActual, rowObject['Data'][index].NovActual, rowObject['Data'][index].DecActual
    			  	], {
		            		type: "line",
		            		width: '60',
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
	          
	        }	      	        
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
			refresh: false,
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
	 
	 /*
	 // Defaulf: Column Set
	 grid.jqGrid('hideCol', [
		'JanActual', 'JanAchieve', 'FebActual', 'FebAchieve', 'MarActual', 'MarAchieve',
        'AprActual', 'AprAchieve', 'MayActual', 'MayAchieve', 'JunActual', 'JunAchieve',
        'JulActual', 'JulAchieve', 'AugActual', 'AugAchieve', 'SepActual', 'SepAchieve',
        'OctActual', 'OctAchieve', 'NovActual', 'NovAchieve', 'DecActual', 'DecAchieve',
        'KPINO', 'KPIGroupList'
     ]); 
	 */

	 grid.jqGrid('hideCol', ['KPINO', 'KPIGroupList']); 

	 /*
	 // ADDING: Icon Custom
	 grid.jqGrid('navButtonAdd', grid_main + '_toppager_left', {
		caption: "&nbsp;SUMMARY",
		title: "SUMMARY",
		buttonicon: 'glyphicon glyphicon-chevron-right',
		onClickButton: function() {
			// 'YTDAchieve', 
			grid.jqGrid('showCol',[
				'YTDTarget', 'YTDActual', 'Succ', 'AVGActual', 'CurTarget', 'CurActual', 
				'CurAchieve', 'Comp', 'LastActual', 'LastAchieve'
       		]); 
   			
			grid.jqGrid('hideCol',[
				'JanActual', 'JanAchieve', 'FebActual', 'FebAchieve', 'MarActual', 'MarAchieve',
				'AprActual', 'AprAchieve', 'MayActual', 'MayAchieve', 'JunActual', 'JunAchieve',
				'JulActual', 'JulAchieve', 'AugActual', 'AugAchieve', 'SepActual', 'SepAchieve',
				'OctActual', 'OctAchieve', 'NovActual', 'NovAchieve', 'DecActual', 'DecAchieve'
			]);

			//resizeWidth(grid_main); 
		}
		
	 });
	 
	 grid.jqGrid('navButtonAdd', grid_main + '_toppager_left', {
		caption: "&nbsp;MONTHLY",
		title: "MONTHLY",
		buttonicon: 'glyphicon glyphicon-chevron-right',
		onClickButton: function() {
			// 'YTDAchieve', 
			grid.jqGrid('hideCol',[
				'YTDTarget', 'YTDActual', 'Succ', 'AVGActual', 'CurTarget', 'CurActual', 
				'CurAchieve', 'Comp', 'LastActual', 'LastAchieve'
       		]); 
   			
			grid.jqGrid('showCol',[
				'JanActual', 'JanAchieve', 'FebActual', 'FebAchieve', 'MarActual', 'MarAchieve',
				'AprActual', 'AprAchieve', 'MayActual', 'MayAchieve', 'JunActual', 'JunAchieve',
				'JulActual', 'JulAchieve', 'AugActual', 'AugAchieve', 'SepActual', 'SepAchieve',
				'OctActual', 'OctAchieve', 'NovActual', 'NovAchieve', 'DecActual', 'DecAchieve'
			]); 

		}
		
	 });
	 
	 grid.jqGrid('navButtonAdd', grid_main + '_toppager_left', {
		caption: "&nbsp;ALL",
		title: "ALL",
		buttonicon: 'glyphicon glyphicon-chevron-right',
		onClickButton: function() {
			// 'YTDAchieve',  'YTDAchieve', 		
			grid.jqGrid('showCol',[
				'YTDTarget', 'YTDActual', 'Succ', 'AVGActual', 'CurTarget', 'CurActual', 
				'CurAchieve', 'Comp', 'LastActual', 'LastAchieve',
				'JanActual', 'JanAchieve', 'FebActual', 'FebAchieve', 'MarActual', 'MarAchieve',
				'AprActual', 'AprAchieve', 'MayActual', 'MayAchieve', 'JunActual', 'JunAchieve',
				'JulActual', 'JulAchieve', 'AugActual', 'AugAchieve', 'SepActual', 'SepAchieve',
				'OctActual', 'OctAchieve', 'NovActual', 'NovAchieve', 'DecActual', 'DecAchieve'
			]); 

		}
		
	 }); 
	 
	 //resizeWidth(grid_main);
    */
});

function getFormatTypes(cellvalue, options, rowObject) {

	var percent = [13, 22,23, 24, 25],
		mb		= [17, 18, 19, 21];

	if(in_array(rowObject.KPINO, percent)) {
		return cellvalue + '%';
	} else if(in_array(rowObject.KPINO, mb)) {
		return cellvalue + 'MB';
	} else { return cellvalue; }
	
	
}


function fontColorFormat(cellvalue, options, rowObject) {
	
	var cellHtml = '';
	var color 	 = ["green", "red"];

	if(cellvalue >= 100) {
		cellHtml = "<span style='color:" + color[0] + "' originalValue='" + cellvalue + "'>" + cellvalue + "</span>";
	} else {
		cellHtml = "<span style='color:" + color[1] + "' originalValue='" + cellvalue + "'>" + cellvalue + "</span>";
	}

	return cellHtml;
	
}

function getFormatPercentWithFontColors(cellvalue, options, rowObject) {

	var cellHtml = '';
	var color 	 = ["green", "red"];

	if(cellvalue >= 100) {
		cellHtml = "<span style='color:" + color[0] + "' originalValue='" + cellvalue + "'>" + cellvalue + "%</span>";
	} else {
		cellHtml = "<span style='color:" + color[1] + "' originalValue='" + cellvalue + "'>" + cellvalue + "%</span>";
	}

	return cellHtml;
	
}


function dataFormatComparing(cellvalue, options, rowObject) {

	var color 	 = ["green", "red", "gray"];
	if(cellvalue != '') {
		//compareState
		switch(cellvalue) {
			case '+':
				return "<span style='color:" + color[0] + "' originalValue='" + cellvalue + ";'><i class=\"fa fa-sort-asc\" style=\"position: absolute; font-size: 1.5em; margin-left: 0.6em;\"></i></span>";
				break;
			case '-':
				return "<span style='color:" + color[1] + "' originalValue='" + cellvalue + "'><i class=\"fa fa-sort-desc\" style=\"position: absolute; font-size: 1.5em; margin-left: 0.6em;\"></i></span>";
				break;
			case '=':
			default:
				return "<span style='color:" + color[2] + "' originalValue='" + cellvalue + "'></span>";
				break;
		}

		
		
	} else {
		return '';
	}

}

function roundFixed(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}


</script>

</body>
</html>
