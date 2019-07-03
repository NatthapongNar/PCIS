<!DOCTYPE html>
<html>
<head ng-app>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KPI Viewer</title>
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
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap.css'); ?>"> 	
 	<link rel="stylesheet" href="<?php echo base_url('css/jqGrid/ui.jqgrid-bootstrap-ui.css'); ?>"> 	 	
 	<link rel="stylesheet" href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/themify-icons.css'); ?>">  	
 	<link rel="stylesheet" href="<?php echo base_url('css/focal-point.min.css'); ?>"> 
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/mmenu/mmenu.css'); ?>">	
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/wp.custom.css'); ?>">	
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/tooltip_custom.css'); ?>">	
 	<style type="text/css">
 		/*
 		body {
 			font-size: 0.9em;
 			font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
 		}
 		*/
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
			font-size: 1.2em !important;
		}
		
		@media screen and (-webkit-min-device-pixel-ratio:0) { 
		
			.icon_trend {
				position: absolute; 
				font-size: 1.5em; 
				margin-left: 0.5em !important;	
			}
					
		  
		}
		
		#ie_icon_trend {
			position: absolute; 
			font-size: 1.5em; 
			margin-left: 0.1em;	
		}
		
		#grid_container { color: #666; }
		
		#grid_container table td:ntd-child(9) {
			background: #d6f9ff; /* Old browsers */
			background: -moz-linear-gradient(top,  #d6f9ff 0%, #9ee8fa 100%); /* FF3.6-15 */
			background: -webkit-linear-gradient(top,  #d6f9ff 0%,#9ee8fa 100%); /* Chrome10-25,Safari5.1-6 */
			background: linear-gradient(to bottom,  #d6f9ff 0%,#9ee8fa 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d6f9ff', endColorstr='#9ee8fa',GradientType=0 ); /* IE6-9 */
						  
		}
		
		table#grid_container td:nth-child(5), 
		table#grid_container td:nth-child(6),
		table#grid_container td:nth-child(11), 
		table#grid_container td:nth-child(12), 
		table#grid_container td:nth-child(13) {
			background: #EBF5FF;	
			z-index: 1;							  
		}

		table#grid_container td:nth-child(7), table#grid_container td:nth-child(8), 
		table#grid_container td:nth-child(9), table#grid_container td:nth-child(10),
		table#grid_container td:nth-child(11), table#grid_container td:nth-child(12), 
		table#grid_container td:nth-child(13), table#grid_container td:nth-child(14), 
		table#grid_container td:nth-child(15), table#grid_container td:nth-child(16),
		table#grid_container td:nth-child(17), table#grid_container td:nth-child(18), 
		table#grid_container td:nth-child(19), table#grid_container td:nth-child(20), 
		table#grid_container td:nth-child(21), table#grid_container td:nth-child(22),
		table#grid_container td:nth-child(23), table#grid_container td:nth-child(24), 
		table#grid_container td:nth-child(25), table#grid_container td:nth-child(26), 
		table#grid_container td:nth-child(27), table#grid_container td:nth-child(28),
		table#grid_container td:nth-child(29), table#grid_container td:nth-child(30), 
		table#grid_container td:nth-child(31), table#grid_container td:nth-child(32), 
		table#grid_container td:nth-child(33), table#grid_container td:nth-child(34) {
			text-align: center !important;								  
		}
		
		#grid_container_Region, #grid_container_Lending,
		#grid_container_YTDTarget, #grid_container_YTDActual,
		#grid_container_AVGActual, #grid_container_YTDAchieve, 
		#grid_container_CurTarget, 
		#grid_container_DecActual, #grid_container_DecAchieve, 
		#grid_container_NovActual, #grid_container_NovAchieve, 
		#grid_container_OctActual, #grid_container_OctAchieve,
		#grid_container_SepActual, #grid_container_SepAchieve,
		#grid_container_AugActual, #grid_container_AugAchieve,
		#grid_container_JulActual, #grid_container_JulAchieve,
		#grid_container_JunActual, #grid_container_JunAchieve,
		#grid_container_MayActual, #grid_container_MayAchieve,
		#grid_container_AprActual, #grid_container_AprAchieve,
		#grid_container_MarActual, #grid_container_MarAchieve,
		#grid_container_FebActual, #grid_container_FebAchievem
		#grid_container_JanActual, #grid_container_JanAchieve {
			font-size: 0.9em !important; 
		}
		
		#grid_containerghead_0_0, #grid_containerghead_0_1, #grid_containerghead_0_2, #grid_containerghead_0_3,
		#grid_containerghead_0_4, #grid_containerghead_0_5, #grid_containerghead_0_6 {
			padding-left: 0px;
			background: #EBF5FF;
			font-weight: bold;
			text-transform: uppercase;
		}
	
		#present { cursor: pointer; }
		
		.IRotate {
			-moz-transform: rotate(180deg);
			-ms-transform: rotate(180deg);
			-o-transform: rotate(180deg);
			-webkit-transform: rotate(180deg);
		}
			
 	</style>
</head>
<body>

<!-- 56511 -->
<div id="element_session">
	<input id="profiler" name="profiler" type="hidden" value="<?php echo $session_data['emp_id']; ?>">
	<input id="emp_id" name="emp_id" type="hidden" value="<?php echo $session_data['emp_id']; ?>">
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
				<img id="sidebar_icon" src="<?php echo base_url('img/panel.png'); ?>" style="font-size: 1.2em; z-index: 999;">
			</a>			
		</div>
		<div id="mm-navbar-collapse" class="collapse navbar-collapse">
			 <ul class="nav navbar-nav">
	        	<li class="divider-vertical"></li> 
	        	<li>
	        		<a href="<?php echo site_url('report/onloadKPI'); ?>"><!--  -->
	        			<span class="tooltip-right" data-tooltip="Overview Chart (maintenance)">
	        				<i class="fa fa-bar-chart fa-2x"></i>
	        			</span>
	        		</a>
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
		<table id="grid_container"></table>			
		<div id="page_container"></div>
	</div>
	
	<nav id="menu" class="mm-panel-fix">
		<?php $this->load->view('frontend/content/report/kpi/sidebar_left'); ?>
	</nav>

</div>



<script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.mousewheel.js'); ?>"></script>
<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugin/mmenu/core/js/jquery.mmenu.min.all.js'); ?>"></script>
<script src="<?php echo base_url('js/plugin/mmenu/addons/js/jquery.mmenu.offcanvas.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.rotate.min.js'); ?>"></script>
<script src="<?php echo base_url('js/build/chart/treeview_menu.js'); ?>"></script>
<script src="<?php echo base_url('js/jqGrid/js/i18n/grid.locale-en.js'); ?>" type="text/ecmascript" ></script>  
<script src="<?php echo base_url('js/jqGrid/js/jquery.jqGrid.min.js'); ?>" type="text/ecmascript" ></script>
<script src="<?php echo base_url('js/chart/sparkline/jquery.sparkline.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
<script type="text/javascript">

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

var url_path	= 'http://172.17.9.65/WsLendingBranchServices/PCISService.svc/';
//var url_path		= 'http://172.17.9.68/LendingBranchServices/PCISService.svc/'; // UAT

var urlGrid  	= url_path + "GetKPIWhiteBoardReport";
var urlProfile  = url_path + "GetKPI00ProfileReport";

var percent  = [8, 11, 14, 23,24, 25, 26, 32, 33],
	percent2 = [11, 14],
	actual	 = [11, 14, 23, 24, 25, 26],
	mb		 = [18, 19, 20, 22],
	kpi_list = [2, 5, 6, 8, 14, 18, 20, 32, 33];		
	target	 = [1, 3, 4, 7, 9, 12, 13, 15, 16, 17, 21, 23],	
		
	per_succ = [1, 7, 9, 12, 21],
	symbol	 = '<span class="text-muted">-</span>';



// Call Profiler $('#profiler').val()
loadProfile(urlProfile, '57044');

$(function() {

	var d = new Date(), n = d.getMonth(), y = d.getFullYear(); 
	
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
	monthNames   = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	month_name	 = ['JanActual', 'FebActual', 'MarActual', 'AprActual', 'MayActual', 'JunActual', 'JulActual', 'AugActual', 'SepActual', 'OctActual', 'NovActual', 'DecActual'],
	month_ach	 = ['JanAchieve', 'FebAchieve', 'MarAchieve', 'AprAchieve', 'MayAchieve', 'JunAchieve', 'JulAchieve', 'AugAchieve', 'SepAchieve', 'OctAchieve', 'NovAchieve', 'DecAchieve'];

	var month_summ	= [	              		
	    { label: 'NO', name: 'KPINO', width: 35, align: 'center', frozen: true },
	    { label: 'KPI &nbsp; LIST', name: 'KPILIST', width: 250, align: 'left', frozen: true, formatter: setKPIListFormatters },
	 	{ label: 'GROUP', name: 'KPIGroupList', index: 'KPIGroupList' },
	    { label: 'TREND', name: 'TREND', width: 80 },
		{ label: 'REGION', name: 'Region', width: 70 },
	    { label: 'LENDING', name: 'Lending', width: 70 },
	    { label: 'TARGET', name: 'YTDTarget', formatter: getFormatTypes, width: 70 },
	    { label: 'ACTUAL', name: 'YTDActual', width: 70, formatter: getFormatTypes2 },
	    { label: 'AVG', name: 'AVGActual', width: 70, formatter: getFormatTypes2 },
	    { label: '% SUCC', name: 'YTDAchieve', formatter: getFormatPercentWithFontColors, width: 70 },
	 	
	];

	var month_groupHD	= [];

    var month			= [],
    	month_active	= [],
    	month_theme		= [];

	// Current Month
    month_summ.push(    	
    	{ label: 'TARGET', name: 'CurTarget', width: 70, formatter: setCellMonthlyFormatter },
    	{ label: 'ACTUAL', name: month_name[d.getMonth()], width: 70, formatter: setCellOptionalFormatter },
    	{ label: '% SUCC', name: month_ach[d.getMonth()], formatter: getFormatPercentWithFontColors, width: 70 },
    	{ label: '&nbsp;', name: 'Comp', width: 30, align: 'center', formatter: dataFormatComparing }
    	
    );

    month_groupHD.push(   
    	{ "numberOfColumns": 2, "titleText": "RANKING", "startColumnName": "Region" },
    	{ "numberOfColumns": 4, "titleText": "YTD " + y, "startColumnName": "YTDTarget" },
    	{ "numberOfColumns": 3, "titleText": monthNames[d.getMonth()].toUpperCase(), "startColumnName": "CurTarget" }
    );

	for(var i = 0; i <= d.getMonth()-1; i ++) { month.push(formatMonth[i]);	}
	
	month.sort(function(a, b){return b-a});	
	for(var i = month[0]; i >= 0; i--) {
	    month_summ.push(
	    	{ label:'ACTUAL', name: month_name[i], width: 70, formatter: setCellOptionalFormatter },
	    	{ label:'% SUCC', name: month_ach[i], formatter: getFormatPercentWithFontColors, width: 70 }
	    );

	    month_groupHD.push({ "numberOfColumns": 2, "titleText": monthNames[i].toUpperCase(), "startColumnName": month_name[i] });
	}

	// load data grid
	var grid;
	grid = $(grid_main).jqGrid({
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
    	toppager: false,	    
    	shrinkToFit: false,    
    	viewrecords: true,
    	height: 600, //'auto',   
    	width: 1420,    
    	rowNum: 500,
    	pager: grid_footer,
    	caption: false,//"PERFORMANCE - GRID VIEWS",  
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
	grid.jqGrid('hideCol', ['KPINO', 'KPIGroupList', 'Region', 'Lending']); 

	// group collapse
	grid.jqGrid('groupingToggle','grid_containerghead_0_1');
    			
});	


$(window).on("resize", function () {
    var $grid = $("#grid_container"), newWidth = $grid.closest(".ui-jqgrid").parent().width();
    $grid.jqGrid("setGridWidth", newWidth, true);
});

function setKPIListFormatters(cellvalue, options, rowObject) {
	
	if(in_array(rowObject.KPINO, kpi_list)) {
		return '<span style="color: blue;">' + cellvalue + '</span>';
	} else {
		return cellvalue;
	}
}

// YTD Fomatter
function getFormatTypes(cellvalue, options, rowObject) {

	if(in_array(rowObject.KPINO, target)) {
		return symbol;

	} else {

		if(in_array(rowObject.KPINO, percent)) {
			return cellvalue + '%';
			
		} else if(in_array(rowObject.KPINO, mb)) {
			return cellvalue + 'Mb';
			
		} else {	
			return cellvalue; 

		}

	}

}

function getFormatTypes2(cellvalue, options, rowObject) {
	if(in_array(rowObject.KPINO, percent2)) {
		return cellvalue + '%';
		
	} else if(in_array(rowObject.KPINO, mb)) {
		return cellvalue + 'Mb';
		
	} else {	
		return cellvalue; 

	}
}

// Monthly Formatter
function setCellMonthlyFormatter(cellvalue, options, rowObject) {

	if(in_array(rowObject.KPINO, target)) {
		return symbol;

	} else {

		if(in_array(rowObject.KPINO, percent)) {
			return cellvalue + '%';
			
		} else if(in_array(rowObject.KPINO, mb)) {
			return cellvalue + 'Mb';
			
		} else { 
			
			return cellvalue; 

		}
		
	}	
	
}

// Optional Rows
function setCellOptionalFormatter(cellvalue, options, rowObject) {

	var per_optional = [],
		mb_optional	 = [17, 18, 19, 20];

	if(in_array(rowObject.KPINO, actual)) {
		return cellvalue + '%';
		
	} else if(in_array(rowObject.KPINO, mb)) {
		return cellvalue + 'Mb';
		
	} else { 		
		return cellvalue; 

	}
	
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

	if(in_array(rowObject.KPINO, per_succ)) {
		return symbol;

	} else {
		
		if(cellvalue >= 100) {
			cellHtml = "<span style='color:" + color[0] + "' originalValue='" + cellvalue + "'>" + cellvalue + "%</span>";
		} else {
			cellHtml = "<span style='color:" + color[1] + "' originalValue='" + cellvalue + "'>" + cellvalue + "%</span>";
		}
		
	}	
	

	

	return cellHtml;
	
}

function dataFormatComparing(cellvalue, options, rowObject) {

	var color 	 = ["green", "red", "gray"];
	if(cellvalue != '') {
		//compareState
		switch(cellvalue) {
			case '+':
				return "<span style='color:" + color[0] + "' originalValue='" + cellvalue + ";'><i id=\"ie_icon_trend\" class=\"fa fa-sort-asc icon_trend\"></i></span>";
				break;
			case '-':
				return "<span style='color:" + color[1] + "' originalValue='" + cellvalue + "'><i id=\"ie_icon_trend\" class=\"fa fa-sort-desc icon_trend\"></i></span>";
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
	
	
	//console.log($('#mm-1').attr('class'));
	//console.log($('#mm-2').attr('class'));
	//console.log($('#mm-3').attr('class'));
	//console.log($('#subList').attr('class'));
	

	//$('div.mm-panel').not('#mm-1, #subList');
	
}

</script>

</body>
</html>
