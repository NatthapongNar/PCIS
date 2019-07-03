// Configulation
var d = new Date(),
	n = d.getMonth(); 

var table_header = 'KPI';
var month_format = 2;

var fontSize	= 11;

var background  = '#303030';
var fontColor	= '#FFFFFF';
var fontName	= 'Arial';
var fontStyle	= 'bold';

var formatMonth = [
    ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    ['01','02','03','04','05','06','07','08','09','10','11','12'],
    ['J','F','M','A','M','J','J','A','S','O','N','D']
];

var cssClassNames = {
   	'headerRow': 'table-custom-header',
    'tableRow': 'table-custom-cell',
    'oddTableRow': 'table-custom-cell',
    'selectedTableRow': 'table-custom-select',
    'hoverTableRow': 'table-custom-select',
    'headerCell': 'table-custom-header',
    'tableCell': 'table-custom-cell'
};

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }	

// set progress
var app2ca_progress = $('#appquality_progress');

/** Loading: Content Chart Content **/
// Prospect And NCB Pass
function loadProspectTargetList(url, condition) {

	$.ajax({
      	url: url,
        data: { RMCode: condition },
        type: "GET",
        jsonpCallback: "prospect_data",
        dataType: "jsonp",
        crossDomain: true,
       	beforeSend:function() {
       		
        },
	    success: function (responsed) { 
	    	
	    	var month	= [],
	    		target	= [],
	    		cpldata = [],
	    		cplper	= [];
	   
	    	var target_point	= [100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100],
	    		data_point		= [responsed.Data[0].Jan, responsed.Data[0].Feb, responsed.Data[0].Mar, responsed.Data[0].Apr, responsed.Data[0].May, responsed.Data[0].Jun, responsed.Data[0].Jul, responsed.Data[0].Aug, responsed.Data[0].Sep, responsed.Data[0].Oct, responsed.Data[0].Nov, responsed.Data[0].Dec],
	    		percent_point	= [Math.round(roundFixed(responsed.Data[1].Jan, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Feb, 1))  + '%', Math.round(roundFixed(responsed.Data[1].Mar, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Apr, 1)) + '%', Math.round(roundFixed(responsed.Data[1].May, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Jun, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Jul, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Aug, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Sep, 1)) + '%', roundFixed(responsed.Data[1].Oct, 1) + '%', roundFixed(responsed.Data[1].Nov, 1) + '%', Math.round(roundFixed(responsed.Data[1].Dec, 1)) + '%'];
	    

        	for(var i = 0; i <= d.getMonth(); i ++) {
        		month.push(formatMonth[month_format][i]);
        		target.push(target_point[i]);
        		cpldata.push(data_point[i]);
        		cplper.push(percent_point[i]);
        	}
	    	
	    	var lineChartData = {	    		
	    		labels : month,
	    		datasets : [

					{	    				
						label: 'Target',
						fillColor : "rgba(0, 0, 0, .2)",
						strokeColor : "rgba(255, 0, 0, .3)",
						pointColor : "rgba(255, 0, 0, 1)",	  
						pointDotRadius : 0,
						data : target,
						myInGraphData : [,,,,,,,,,,,]
						
					},
					{	label: responsed.Data[0].Performance,
						fillColor : "rgba(30,87,153, .2)",
						strokeColor : "rgba(151, 187, 205, 1)",
						pointColor : "rgba(151, 187, 205, 1)",
						pointStrokeColor : "#fff",
						pointHighlightFill : "#fff",
						pointHighlightStroke : "rgba(220,220,220,1)",
						data : data_point,
						myInGraphData : cplper
					
					}
	    			
	    		]
	    	}

	    	var cntshapes=0;
	    	lineChartData.shapesInChart=[];	    	
	    	for(var i = 0; i < lineChartData.datasets.length; i++) {	    		
	    		
	    		for(var j = 0; j < lineChartData.datasets[i].data.length; j++) {	    
	    	
	    			if(typeof lineChartData.datasets[i].myInGraphData[j] == "string") {
	    				
	    				
	    				if(lineChartData.datasets[i].myInGraphData[j].toUpperCase().indexOf(".JPG")>=0 || lineChartData.datasets[i].myInGraphData[j].toUpperCase().indexOf(".GIF")>=0) {
	    					lineChartData.shapesInChart[cntshapes] = {
		    					position : "INCHART",
		    					shape: "IMAGE",
		    					imagesrc : "" + lineChartData.datasets[i].myInGraphData[j],
		    					x1:  j,
		    					y1:  lineChartData.datasets[i].data[j],
		    					paddingX1 : 1,
		    					paddingY1 : -1,
		    					imageAlign : "left",
		    					imageBaseline : "bottom",
		    					imageWidth : 50,
		    					imageHeight : 50,
		    					iter : "last"
		    				};
	    				} else {
	    					lineChartData.shapesInChart[cntshapes] = {
		    					position : "INCHART",
		    					shape: "Text",
		    					text : "" + lineChartData.datasets[i].myInGraphData[j],
		    					x1:  j,
		    					y1:  lineChartData.datasets[i].data[j],
		    					paddingX1 : -4,
		    					paddingY1 : -7,
		    					textAlign : "left",
		    					textBaseline : "bottom",
		    					fontColor : fontColor, 
		    					fontStyle : fontStyle,
		    					fontSize : 10,
		    					fontFamily : fontName,
		    					iter : "last"
	    					};
	    				}
	    				cntshapes++;

	    			} 
	    			
	    		}
	    		
	    	}
			
	    	
	    	var startWithDataset = 1;
	    	var startWithData 	 = 1;

			var ctx = document.getElementById('prospectchart_values').getContext("2d");
			var myLine = new Chart(ctx).Line(lineChartData, {
	    		responsive: true,
	    		legend : false,
	    		datasetFill : true,
	    		annotateDisplay : false, 
	    		inGraphDataShow : false,	    		
	    		endDrawDataFunction: drawShapes,
	    		scaleShowGridLines : true,
	    		scaleGridLineColor : "rgba(255, 255, 255, .05)",
	    		scaleLineColor: "rgba(255, 255, 255, .05)",	    
	    		scaleFontStyle: fontStyle,
	    		scaleFontColor: fontColor,
	    		scaleFontSize: fontSize,
	    		yAxisLeft : true,
	    		yAxisRight : false,
	    		xAxisBottom : true,
	    		xAxisTop : false
	    		//yAxisUnit : "Target"
	    	});
	    		
  			$("#prospectchart_custom_lagend").empty().append('<i class="fa fa-circle" style="margin-left: 5px; color: ' + lineChartData.datasets[1].pointColor + ';"></i> <span> Number of '+ responsed.Data[0].Performance +'</span> <span style="margin-left: 5px;"> (%) Interest</span>').hide().fadeIn("slow");		

	    },
	    complete:function() {
	    	$('.addChartText').fadeIn(3000).removeClass('hidden');
	    	
        },
	    error: function (error) {
	 	        
	    }
	        
	});
	
}

function loadNCBOnloadList(url, condition) {
	
	$.ajax({
      	url: url,
        data: { RMCode: condition },
        type: "GET",
        jsonpCallback: "ncb_data",
        dataType: "jsonp",
        crossDomain: true,
       	beforeSend:function() {
       		
        },
	    success: function (responsed) {
	    	
	      	var month	= [],
    		ncbdata = [],
    		ncbper	= [];
   
	    	var data_point		= [responsed.Data[0].Jan, responsed.Data[0].Feb, responsed.Data[0].Mar, responsed.Data[0].Apr, responsed.Data[0].May, responsed.Data[0].Jun, responsed.Data[0].Jul, responsed.Data[0].Aug, responsed.Data[0].Sep, responsed.Data[0].Oct, responsed.Data[0].Nov, responsed.Data[0].Dec],
	    		percent_point	= [Math.round(roundFixed(responsed.Data[1].Jan, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Feb, 1))  + '%', Math.round(roundFixed(responsed.Data[1].Mar, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Apr, 1)) + '%', Math.round(roundFixed(responsed.Data[1].May, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Jun, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Jul, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Aug, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Sep, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Oct, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Nov, 1)) + '%', Math.round(roundFixed(responsed.Data[1].Dec, 1)) + '%'];
	    
	
	    	for(var i = 0; i <= d.getMonth(); i ++) {
	    		month.push(formatMonth[month_format][i]);
	    		ncbdata.push(data_point[i]);
	    		ncbper.push(percent_point[i]);
	    	}
	    	
	    	var lineChartData = {	    		
	    		labels : month,
	    		datasets : [				
	    			{
	    				label: responsed.Data[0].Performance,
	    				fillColor : "rgba(201, 222, 150, .2)",
						strokeColor : "rgba(141, 186, 138, 1)",
						pointColor : "rgba(141, 186, 138, 1)",
	    				pointStrokeColor : "#fff",
	    				pointHighlightFill : "#fff",
	    				pointHighlightStroke : "rgba(220, 220, 220, 1)",
	    				data : ncbdata,
	    				myInGraphData : ncbper	    				
	    			}
	    		]
	    	}

	    	var cntshapes=0;
	    	lineChartData.shapesInChart=[];	    	
	    	for(var i = 0; i < lineChartData.datasets.length; i++) {	    		
	    		
	    		for(var j = 0; j < lineChartData.datasets[i].data.length; j++) {	    
	    	
	    			if(typeof lineChartData.datasets[i].myInGraphData[j] == "string") {
	    				
	    				
	    				if(lineChartData.datasets[i].myInGraphData[j].toUpperCase().indexOf(".JPG")>=0 || lineChartData.datasets[i].myInGraphData[j].toUpperCase().indexOf(".GIF")>=0) {
	    					lineChartData.shapesInChart[cntshapes] = {
		    					position : "INCHART",
		    					shape: "IMAGE",
		    					imagesrc : "" + lineChartData.datasets[i].myInGraphData[j],
		    					x1:  j,
		    					y1:  lineChartData.datasets[i].data[j],
		    					paddingX1 : 1,
		    					paddingY1 : -1,
		    					imageAlign : "left",
		    					imageBaseline : "bottom",
		    					imageWidth : 50,
		    					imageHeight : 50,
		    					iter : "last"
	    					};
	    				} else {
	    					lineChartData.shapesInChart[cntshapes] = {
		    					position : "INCHART",
		    					shape: "Text",
		    					text : "" + lineChartData.datasets[i].myInGraphData[j],
		    					x1:  j,
		    					y1:  lineChartData.datasets[i].data[j],
		    					paddingX1 : -4,
		    					paddingY1 : -7,
		    					textAlign : "left",
		    					textBaseline : "bottom",
		    					fontColor : fontColor, 
		    					fontStyle : fontStyle,
		    					fontSize : 10,
		    					fontFamily : "'Arial'",
		    					iter : "last"
	    					};
	    				}
	    				cntshapes++;

	    			} 
	    			
	    		}
	    		
	    	}
	    	
	    	var startWithDataset = 1;
	    	var startWithData = 1;

			var ctx = document.getElementById('ncbchart_values').getContext("2d");
	    	window.myLine = new Chart(ctx).Line(lineChartData, {
	    		responsive: true,
	    		legend : false,
	    		datasetFill : true,
	    		annotateDisplay : false, 
	    		inGraphDataShow : false,
	    		endDrawDataFunction: drawShapes,
	    		scaleGridLineColor : "rgba(255, 255, 255, .05)",
	    		scaleLineColor: "rgba(255, 255, 255, .05)",	    
	    		scaleFontStyle: fontStyle,
	    		scaleFontColor: fontColor,
	    		scaleFontSize: fontSize,
	    		yAxisLeft : true,
	    		yAxisRight : false,
	    		xAxisBottom : true,
	    		xAxisTop : false,
	    		//yAxisUnit : "Target",
	    		scaleSteps : 10,
	    		scaleStepWidth : 20,
	    		scaleStartValue : 0	    			
	    	});

	    	$("#ncbchart_custom_lagend").empty().append('<i class="fa fa-circle" style="margin-left: 5px; color: ' + lineChartData.datasets[0].pointColor + ';"></i> <span> Total number of NCB checked</span><span style="margin-left: 5px;"> (%) NCB Pass</span>').hide().fadeIn("slow");
	  	    		    	
	    },
	    complete:function() {	    		    	
	    	$('.addChartText').fadeIn(3000).removeClass('hidden');
	    	
        },
	    error: function (error) {
	 	        
	    }
	        
	});
	
}


function loadApp2CAWithQuality(url, condition) {
	
	$.ajax({
        url: url,
        data: { RMCode: condition },
        type: "GET",
        jsonpCallback: "app_quality",
        dataType: "jsonp",
        crossDomain: true,
        beforeSend:function() {
        	app2ca_progress.show();
        },
        success: function (responsed) {

        	var objData    = [],
        		bgColor = ['#ba4d51', 'rgba(241,218,54,1)', 'rgba(157,213,58, .8)'];

        	var non_quality = [responsed.Data[1].Jan, responsed.Data[1].Feb, responsed.Data[1].Mar, responsed.Data[1].Apr, responsed.Data[1].May, responsed.Data[1].Jun, responsed.Data[1].Jul, responsed.Data[1].Aug, responsed.Data[1].Sep, responsed.Data[1].Oct, responsed.Data[1].Nov, responsed.Data[1].Dec];
        	var a2ca_t2		= [responsed.Data[5].Jan, responsed.Data[5].Feb, responsed.Data[5].Mar, responsed.Data[5].Apr, responsed.Data[5].May, responsed.Data[5].Jun, responsed.Data[5].Jul, responsed.Data[5].Aug, responsed.Data[5].Sep, responsed.Data[5].Oct, responsed.Data[5].Nov, responsed.Data[5].Dec];
        	var a2ca_t1		= [responsed.Data[4].Jan, responsed.Data[4].Feb, responsed.Data[4].Mar, responsed.Data[4].Apr, responsed.Data[4].May, responsed.Data[4].Jun, responsed.Data[4].Jul, responsed.Data[4].Aug, responsed.Data[4].Sep, responsed.Data[4].Oct, responsed.Data[4].Nov, responsed.Data[4].Dec];
        	
        	var month 		= [], 
        		nonQulify	= [],
        		a2caT1		= [],
        		a2caT2		= [];
        	
        	for(var i = 0; i <= d.getMonth(); i ++) {
        		month.push(formatMonth[month_format][i]);
        		nonQulify.push(non_quality[i]);
        		a2caT1.push(a2ca_t1[i]);
        		a2caT2.push(a2ca_t2[i]);
        	}
        	        
        	objData.push(
    			{
        			'name': 'Not Qualify',
        			'data': nonQulify
        		},
        		{
        			'name': (responsed.Data[5].Performance == 'A2CA Type 2') ? 'A2CA-2':responsed.Data[5].Performance,
        			'data': a2caT2
        		},
        		{
        			'name': (responsed.Data[4].Performance == 'A2CA Type 1') ? 'A2CA-1':responsed.Data[4].Performance,	
        			'data': a2caT1
        		}        		
        	);
        	
        	$('#appqualitychart_values').highcharts({
        		title: false,
        		chart: {
                    type: 'column',
                    backgroundColor: background      
                },                
                xAxis: {
                    categories: month,
                    labels: {
 	                   style: {
 	                      color: fontColor,
 	                      fontWeight: fontStyle,
 	                      fontFamily: fontName
 	                   }
 	                }
                },
                yAxis: {
                    min: 0,
                    gridLineWidth: .3,
                    gridLineDashStyle: 'LongDash',
                    gridLineColor: '#FFF',
                    title: { enabled: false },
                    labels: {
	                   style: {
	                      color: fontColor,
	                      fontWeight: fontStyle,
	                      fontFamily: fontName
	                   }
	                }
                },
                legend: {
                	enabled: true,    
                	reversed: true,
                	verticalAlign: 'top',
                	align: 'right',
                	itemStyle: {
                        color: (Highcharts.theme && Highcharts.theme.textColor) || fontColor,
                        fontWeight: fontName,
                        fontSize: fontSize
                    }

                },
                exporting: {
	                enabled: false
	            },
	            credits: {
	                enabled: false
	            },
                tooltip: {                	
                     shared: true
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: false,
                            shadow: false,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || fontColor,
                            style: {
                            	fontWeight: fontStyle,
    		                    fontFamily: fontName,
    		                    fontSize: '10px',
                            }
                        }
                        
                    }
                },
                series: objData,
                colors: bgColor
            });
        	
       	 	// Load Data table
            loadDataTableAppQuality(responsed.Data, bgColor);
           
         },
         complete:function() {       	
        	         	
         },
         error: function (error) {
            console.log(JSON.stringify(error));
         }

	});
	
}

function loadActualTarget(url, condition) {
	
	$.ajax({
      	url: url,
        data: { RMCode: condition },
        type: "GET",
        jsonpCallback: "result_actualTarget",
        dataType: "jsonp",
        crossDomain: true,
       	beforeSend:function() {
       	
        },
	    success: function (responsed) {
	    		    	
	    	var objData     = [],
    			bgColor	    = ['rgba(238, 238, 238, .7)', '#5f8b95', 'rgba(157,213,58, .8)', "rgba(255, 2, 2, .6)"];

        	var actual_dd 	= [Math.round(responsed.Data[0].Jan), Math.round(responsed.Data[0].Feb), Math.round(responsed.Data[0].Mar), Math.round(responsed.Data[0].Apr), Math.round(responsed.Data[0].May), Math.round(responsed.Data[0].Jun), Math.round(responsed.Data[0].Jul), Math.round(responsed.Data[0].Aug), Math.round(responsed.Data[0].Sep), Math.round(responsed.Data[0].Oct), Math.round(responsed.Data[0].Nov), Math.round(responsed.Data[0].Dec)],
        		referral  	= [Math.round(responsed.Data[2].Jan), Math.round(responsed.Data[2].Feb), Math.round(responsed.Data[2].Mar), Math.round(responsed.Data[2].Apr), Math.round(responsed.Data[2].May), Math.round(responsed.Data[2].Jun), Math.round(responsed.Data[2].Jul), Math.round(responsed.Data[2].Aug), Math.round(responsed.Data[2].Sep), Math.round(responsed.Data[2].Oct), Math.round(responsed.Data[2].Nov), Math.round(responsed.Data[2].Dec)],
        		pending_dd	= [Math.round(responsed.Data[1].Jan), Math.round(responsed.Data[1].Feb), Math.round(responsed.Data[1].Mar), Math.round(responsed.Data[1].Apr), Math.round(responsed.Data[1].May), Math.round(responsed.Data[1].Jun), Math.round(responsed.Data[1].Jul), Math.round(responsed.Data[1].Aug), Math.round(responsed.Data[1].Sep), Math.round(responsed.Data[1].Oct), Math.round(responsed.Data[1].Nov), Math.round(responsed.Data[1].Dec)],
        		target		= [Math.round(responsed.Data[4].Jan), Math.round(responsed.Data[4].Feb), Math.round(responsed.Data[4].Mar), Math.round(responsed.Data[4].Apr), Math.round(responsed.Data[4].May), Math.round(responsed.Data[4].Jun), Math.round(responsed.Data[4].Jul), Math.round(responsed.Data[4].Aug), Math.round(responsed.Data[4].Sep), Math.round(responsed.Data[4].Oct), Math.round(responsed.Data[4].Nov), Math.round(responsed.Data[4].Dec)];
        	
        	var month 		= [], 
        		actualData	= [],
        		referData	= [],
        		pendingData = [],
        		targetData	= [];
        	        	
        	for(var i = 0; i <= d.getMonth(); i ++) {
        		month.push(formatMonth[month_format][i]);
        		actualData.push(actual_dd[i]);
        		referData.push(referral[i]);
        		pendingData.push(pending_dd[i]);
        		targetData.push(target[i]);
        	}

	    	objData.push(    			
    		
	    		{
	    			'name': responsed.Data[1].Performance,
	    			'type': 'column',
	    			'data': pendingData
	    		},
	    		{
	    			'name': responsed.Data[2].Performance,
	    			'type': 'column',
	    			'data': referData
	    		},
	    		{
	    			'name': responsed.Data[0].Performance,	
	    			'type': 'column',
	    			'data': actualData
	    		},	
	    		
	    		{
	    			'name': responsed.Data[4].Performance,
	    			'type': 'line',
	    			'showInLegend': false,
	    			'lineWidth': 1.8,
	    			'pointWidth': 10,
	    			'cursor': 'pointer',
	    			'marker': {
	    				'enabled': false
	    			},
	    			'data': targetData
	    		}
	    		
	    	);
	    	
	    	$('#targetchart_values').highcharts({
	    		title: false,
	    		chart: {
	                type: 'column',
	                backgroundColor: background      
	            },                
	            xAxis: {
	                categories: formatMonth[month_format],
	                labels: {
		                   style: {
		                      color: fontColor,
		                      fontWeight: fontStyle,
		                      fontFamily: fontName
		                   }
		                }
	            },
	            yAxis: {
	                min: 0,
	                gridLineWidth: .3,
	                gridLineDashStyle: 'LongDash',
	                gridLineColor: '#FFF',
	                title: { enabled: false },
	                labels: {
	                   style: {
	                      color: fontColor,
	                      fontWeight: fontStyle,
	                      fontFamily: fontName
	                   }
	                }	                
	            },
	            legend: {
	            	enabled: true,    
	            	reversed: true,
	            	verticalAlign: 'top',
	            	align: 'right',
	            	itemStyle: {
	                    color: (Highcharts.theme && Highcharts.theme.textColor) || fontColor,
	                    fontWeight: fontName,
	                    fontSize: fontSize
	                }
	
	            },
	            exporting: {
	                enabled: false
	            },
	            credits: {
	                enabled: false
	            },
	            tooltip: {                	
	                 shared: true
	            },
	            plotOptions: {
	                column: {
	                    stacking: 'normal',
	                    dataLabels: {
	                        enabled: false,
	                        shadow: false,
	                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || fontColor,
	                        style: {
	                        	fontWeight: fontStyle,
			                    fontFamily: fontName,
			                    fontSize: '10px',
	                        }
	                    }
	                    
	                }
	            },
	            series: objData,
	            colors: bgColor
	        });			
	    	
	        loadTableActualDataRecord(responsed, bgColor);
	    	
	    },
	    complete:function() {

	    	
        },
	    error: function (error) {
	 	        
	    }
	        
	});
	
}


function loadLoanMonitoring(url, condition) {

	$.ajax({
      	url: url,
        data: { RMCode: condition },
        type: "GET",
        jsonpCallback: "result_loanmonitor",
        dataType: "jsonp",
        crossDomain: true,
       	beforeSend:function() {
       		       		
        },
	    success: function (responsed) {	   
	    	
	    	var dataProvider = null;
	    	var data = [
	        	{
	                "title": 'Request Loan',	            
	                "value": responsed.Data[0].LoanRequest
	            }
	            , 
	            {
	            	"title": 'Approved Loan',
	            	"value": responsed.Data[0].LoanApproved
	            }, 	             
	            {
	            	"title": 'Pending DD',
	            	"value": responsed.Data[0].LoanPlanDrawdown	        
	            },
	            {
	            	"title": 'Actual DD',
	            	"value": responsed.Data[0].LoanDrawdown	    
	            }
	    	];
	    	
	    	var chart = AmCharts.makeChart("loanmonitorchart_values", {
	    		  "type": "funnel",
	    		  "theme": "light",
	    		  "color": fontColor,
	    		  "fontFamily": fontName,
	    		  "fontSize": fontSize,
	    		  "dataProvider": [
		   	        	{
			                "title": 'Request Loan',	            
			                "value": responsed.Data[0].LoanRequest
			            }
			            , 
			            {
			            	"title": 'Approved Loan',
			            	"value": responsed.Data[0].LoanApproved
			            }, 	             
			            {
			            	"title": 'Pending DD',
			            	"value": responsed.Data[0].LoanPlanDrawdown	        
			            },
			            {
			            	"title": 'Actual DD',
			            	"value": responsed.Data[0].LoanDrawdown	    
			            }
		          ],
	    		  "balloon": {
	    			  "fixedPosition": true
	    		  },
	    		  "valueField": "value",
	    		  "titleField": "title",	    		 
	    		  "startX": -500,
	    		  "rotate": true,
	    		  "startAlpha": 0,
	    		  "depth3D": 100,
	    		  "angle": 30,
	    		  "outlineAlpha": 1,
	    		  "outlineThickness": 2,
	    		  "outlineColor": background,
	    		  "colors": ['#5f8b95', '#7e688c', '#e1bc85', '#ba4d51'],
	    		  "export": {
	    			  "enabled": false
	    		  }
	    		} 
	    	);
			
	    },
	    cache: false,
	    complete:function() {
	    
        },
	    error: function (error) {
	 	        
	    }
	        
	});
	
}



function loadApprovelRate(url, condition) {
	
	$.ajax({
      	url: url,
        data: { RMCode: condition },
        type: "GET",
        jsonpCallback: "result_approvedRate",
        dataType: "jsonp",
        crossDomain: true,
       	beforeSend:function() {},
	    success: function (responsed) { 

	    	var approval = [
	    	     { y:Math.round(responsed.Data[1].Jan), myData: Math.round(responsed.Data[1].Jan)+'%' }, 
	    	     { y:Math.round(responsed.Data[1].Feb), myData: Math.round(responsed.Data[1].Feb)+'%' }, 
	    	     { y:Math.round(responsed.Data[1].Mar), myData: Math.round(responsed.Data[1].Mar)+'%' },
	    	     { y:Math.round(responsed.Data[1].Apr), myData: Math.round(responsed.Data[1].Apr)+'%' },
	    	     { y:Math.round(responsed.Data[1].May), myData: Math.round(responsed.Data[1].May)+'%' },
	    	     { y:Math.round(responsed.Data[1].Jun), myData: Math.round(responsed.Data[1].Jun)+'%' }, 
	    	     { y:Math.round(responsed.Data[1].Jul), myData: Math.round(responsed.Data[1].Jul)+'%' }, 
	    	     { y:Math.round(responsed.Data[1].Aug), myData: Math.round(responsed.Data[1].Aug)+'%' }, 
	    	     { y:Math.round(responsed.Data[1].Sep), myData: Math.round(responsed.Data[1].Sep)+'%' }, 
	    	     { y:Math.round(responsed.Data[1].Oct), myData: Math.round(responsed.Data[1].Oct)+'%' }, 
	    	     { y:Math.round(responsed.Data[1].Nov), myData: Math.round(responsed.Data[1].Nov)+'%' }, 
	    	     { y:Math.round(responsed.Data[1].Dec), myData: Math.round(responsed.Data[1].Dec)+'%' }
	    	];
	    	
	    	var cancel 	 = [
    	        Math.round(responsed.Data[3].Jan), 
    			Math.round(responsed.Data[3].Feb), 
    			Math.round(responsed.Data[3].Mar), 	    							
    			Math.round(responsed.Data[3].Apr), 
    			Math.round(responsed.Data[3].May), 
    			Math.round(responsed.Data[3].Jun), 
    			Math.round(responsed.Data[3].Jul), 
    			Math.round(responsed.Data[3].Aug), 
    			Math.round(responsed.Data[3].Sep), 
    			Math.round(responsed.Data[3].Oct), 
    			Math.round(responsed.Data[3].Nov), 
    			Math.round(responsed.Data[3].Dec)
    		];
	    	
	    	var pull 	 = [
	    	    Math.round(responsed.Data[6].Jan), 
	    	    Math.round(responsed.Data[6].Feb), 
	    	    Math.round(responsed.Data[6].Mar), 
	    	    Math.round(responsed.Data[6].Apr), 
	    	    Math.round(responsed.Data[6].May), 
	    	    Math.round(responsed.Data[6].Jun), 
	    	    Math.round(responsed.Data[6].Jul), 
	    	    Math.round(responsed.Data[6].Aug), 
	    	    Math.round(responsed.Data[6].Sep), 
	    	    Math.round(responsed.Data[6].Oct), 
	    	    Math.round(responsed.Data[6].Nov), 
	    	    Math.round(responsed.Data[6].Dec)
	    	];
	    	
	    	
	    	var month 	= [], 
    		actualData	= [],
    		cancelData 	= [],
    		pullData	= [];
    	        	
	    	for(var i = 0; i <= d.getMonth(); i ++) {
	    		month.push(formatMonth[month_format][i]);
	    		actualData.push(approval[i]);
	    		cancelData.push(cancel[i]);
	    		pullData.push(pull[i]);
	    	}

	    	var bgColor 	 = ['rgba(0,110,46, 1.2)', '#e15258', 'rgba(241,218,54,1)'];
	    	$('#approvalrate_chart').highcharts({
	            chart: {
	                type: 'line',
	                backgroundColor: background,
	                style: {
	                    fontFamily: fontName,
	                    color: fontColor
	                }
	            },
	            title: false,
	            xAxis: {
	            	categories: month,
	            	gridLine: false,
	                lineColor: fontColor,
	                tickColor: fontColor,
	                labels: {
	                   style: {
	                      color: fontColor,
	                      fontWeight: fontStyle,
	                      fontFamily: fontName
	                   }
	                },
	                title: {
	                   style: {
	                	   color: fontColor,
		                   fontWeight: fontStyle,
		                   fontFamily: fontName
	                   }            
	                }

	            },
	            yAxis: {
	            	gridLineWidth: .3,
		            gridLineDashStyle: 'LongDash',
		            gridLineColor: '#FFF',
	            	labels: {
	                   style: {
	                      color: fontColor,
	                      fontWeight: fontStyle,
	                      fontFamily: fontName
	                   }
	                },
	                title: {
	                	enabled: false       
	                }	            
	            },
	            legend: {
	                enabled: true,
	                reversed: false,
	            	verticalAlign: 'top',
	            	align: 'right',
	            	itemStyle: {
	                    color: (Highcharts.theme && Highcharts.theme.textColor) || fontColor,
	                    fontWeight: fontName,
	                    fontSize: fontSize
	                }	                
	            },
	            tooltip: {
	            	 crosshairs: true,
	                 shared: true
	            },
	            plotOptions: {	            	
	            	line: {	 
	                	dataLabels: {
	                		enabled: false,
	                		color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || fontColor
		            	},
	                	fillOpacity: 0.2	                    
	                },
	                style: {
	                    fontFamily: fontName,
	                    color: fontColor
	                }
	            }, 
	            colors: bgColor,
	            exporting: {
	                enabled: false
	            },
	            credits: {
	                enabled: false
	            },
	            series: [
	            {
	                name: 'Approved',
	                'dataLabels': {
	                	enabled: true,
	                	fontWeight: fontName,
		                fontSize: fontSize,
	                	color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || fontColor,
	                	formatter: function () {
	                        return '<b>' + this.point.myData + '</b>';
	                    }
	                },
	                data: actualData,
	                zIndex: 3
	            }
	            , 
	            {
	                name: 'Cancel',
	                data: cancelData,
	                zIndex: 1
	            }, 	             
	            {
	                name: 'Pull Through',
	                data: pullData,
	                zIndex: 2
	            }
	            ]
	        });
	    		    	
	    	// red    = '#e15258', 
	    	// gray   = 'rgba(238, 238, 238, .8)',  dash
	    	// blue   = '#5f8b95',
	    	// green  = 'rgba(157,213,58, .8)',
	    	// yellow = 'rgba(241,218,54,1)'
	    	
	    	loadTableApprovalRateDataRecord(responsed, bgColor);
	    	 	
	    },
	    complete:function() {
	    		    	
        },
	    error: function (error) {
	 	        
	    }
	        
	});
	
}



/** Loading: Right Chart Content **/
// Average : DevExtreme js
function loadGaugeAverage(url, condition) {
	
	var mtd_font   = '#a6c567';
	var gauge_a2ca = function() {
	
	$.ajax({
      	url: url[0],
        data: { RMCode: condition },
        type: "GET",
        jsonpCallback: "result_apptoca",
        dataType: "jsonp",
        crossDomain: true,
        beforeSend:function() {
	       	
        },
	    success: function (responsed) {  
	    	
	    	var options = {
    		    geometry: {
    		        startAngle: 180, endAngle: 0
    		    },
    		    scale: {
    		        startValue: 0, endValue: 10,
    		        majorTick: { tickInterval: 1 }
    		    }
    		};
    	
	    	$("#gauge_a2cachart_values").dxCircularGauge({
				subtitle: '<span style="color: ' + background + '"> | </span>',						
	            scale: {
	                startValue: 0,
	                endValue: 120,
	                majorTick: {
	                    color: fontColor,
	                    tickInterval: 20,
	                    useTicksAutoArrangement: false
	                },
	                
	                minorTick: {
	                	 visible: true,
	                	 color: '#d1d1d1',
	                	 tickInterval: 10            	
	                },		                
	                label: {
	                    indentFromTick: 5, 
	                    customizeText: function (arg) {		                    	
	                        return arg.valueText + ' %';
	                    },
	                    font: {
	                    	color: fontColor,
	                    	weight: fontStyle,
	                    	family: fontName,
	                    	size: fontSize
	                    }

	                }
	               
	            },
	            tooltip: {
	            	enabled: true
	            },
	            rangeContainer: {
	                width: 4,
	                backgroundColor: 'none',
	                ranges: [
	                    {
	                        startValue: 0,
	                        endValue: 60,
	                        color: '#e15258'
	                    },
	                    
	                    {
	                        startValue: 60,
	                        endValue: 100,
	                        color: '#FCBB69'
	                    },		              
	                    {
	                        startValue: 100,
	                        endValue: 120,
	                        color: '#A6C567'
	                    }
	                ]
	            },
	            animationDuration: 200,
	            animationEnabled: true,
	            needles: [{
	                offset: 5,
	                indentFromCenter: 7		                       
	            }],	
	            value: responsed.Data[0].Percentage,
	            valueIndicator: {
	            	type: 'rectangleNeedle',
                    color: '#e15258',
                    secondColor: '#e15258'
                },
	            spindle: {
	            	 color: '#e15258'
	            },
	            subvalues: [responsed.Data[0].AvgA2CPerMonth],
	            subvalueIndicator: {
	            	scale: {
		            	startValue: 0,
		                endValue: 120
	            	}, 
	            	type: 'rectangleNeedle',
	                color: '#8FBC8F'
	            }
	        });
	    	
	    	

	    },
	    complete:function() {	   	
	    	
	    	
        },
	    error: function (error) {
	 	   
	    }
	        
	});

}();

var gauge_appr = function() {
	
	$.ajax({
      	url: url[1],
        data: { RMCode: condition },
        type: "GET",
        jsonpCallback: "result_appr_rate",
        dataType: "jsonp",
        crossDomain: true,
        beforeSend:function() {
	       	
        },
	    success: function (responsed) {   
	    			    	
	    	$("#gauge_approvalchart_values").dxCircularGauge({		   
				subtitle: '<span style="color: ' + background + '"> | </span>',			
	            scale: {
	                startValue: 0,
	                endValue: 100,
	                majorTick: {
	                    color: fontColor,
	                    tickInterval: 25,
	                    useTicksAutoArrangement: false
	                },
	                minorTick: {
	                	 visible: true,
	                	 color: '#D1D1D1',
	                	 tickInterval: 5           	
	                },	
	                label: {
	                    indentFromTick: 5, 
	                    customizeText: function (arg) {
	                        return arg.valueText + ' %';
	                    },
	                    font: {
	                    	color: fontColor,
	                    	weight: fontStyle,
	                    	family: fontName
	                    }
	                }
	            },
	            rangeContainer: {
	                width: 4,
	                backgroundColor: 'none',
	                ranges: [
	                    {
	                        startValue: 0,
	                        endValue: 50,
	                        color: '#e15258'
	                    },		                    
	                    {
	                        startValue: 50,
	                        endValue: 75,
	                        color: '#FCBB69'
	                    },		              
	                    {
	                        startValue: 75,
	                        endValue: 100,
	                        color: '#A6C567'
	                    }
	                ]
	            },
	            tooltip: {
	            	enabled: true
	            },
	            animationDuration: 200,
	            animationEnabled: true,
	            needles: [{
	                offset: 5,
	                indentFromCenter: 7,		                              
	                color: '#43474b'
	            }],
	            value: responsed.Data[0].AppvRate,  
	            valueIndicator: {
	            	type: 'rectangleNeedle',
                    color: '#e15258',
                    secondColor: '#e15258'
                },
	            spindle: {
	                color: '#43474b'
	            },
	            //subvalues: [9],
	            subvalueIndicator: {
	            	type: 'rectangleNeedle',
	                color: '#8FBC8F'
	            }
	            
	        });
	    		
	    	
	    },
	    complete:function() {	    	
	    	
	    	
        },
	    error: function (error) {
	 	        
	    }
	        
	});

}();

var gauge_dd = function() {
	
	$.ajax({
      	url: url[2],
        data: { RMCode: condition },
        type: "GET",
        jsonpCallback: "result_drawdown",
        dataType: "jsonp",
        crossDomain: true,
       	beforeSend:function() {
       	
        },
	    success: function (responsed) { 
	

	    	$("#gauge_drawdownchart_values").dxCircularGauge({			
				subtitle: '<span style="color: ' + background + '"> | </span>',							
	            scale: {
	                startValue: 0,
	                endValue: 120,
	                majorTick: {
	                    color: fontColor,
	                    tickInterval: 20,
	                    useTicksAutoArrangement: false
	                },
	                
	                minorTick: {
	                	 visible: true,
	                	 color: '#D1D1D1',
	                	 tickInterval: 10            	
	                },		                
	                label: {
	                    indentFromTick: 5, 
	                    customizeText: function (arg) {		                    	
	                        return arg.valueText + ' %';
	                    },
	                    font: {
	                    	color: fontColor,
	                    	weight: fontStyle,
	                    	family: fontName,
	                    	size: fontSize
	                    }

	                }
	               
	            },
	            rangeContainer: {
	                width: 4,
	                backgroundColor: 'none',
	                ranges: [
	                    {
	                        startValue: 0,
	                        endValue: 60,
	                        color: '#e15258'
	                    },
	                    
	                    {
	                        startValue: 60,
	                        endValue: 100,
	                        color: '#FCBB69'
	                    },		              
	                    {
	                        startValue: 100,
	                        endValue: 120,
	                        color: '#A6C567'
	                    }
	                ]
	            },
	            tooltip: {
	            	enabled: true
	            },
	            animationDuration: 200,
	            animationEnabled: true,
	            needles: [{
	                offset: 5,
	                indentFromCenter: 7,		                           
	                color: '#43474b'
	            }],
	            value: responsed.Data[0].Percentage,    
	            valueIndicator: {	                    
	            	type: 'rectangleNeedle',
                    color: '#e15258',
                    secondColor: '#e15258'
                },
	            spindle: {
	                color: '#43474b'
	            },
	            subvalues: [responsed.Data[0].AbgDDPerMonth],
	            subvalueIndicator: {
	            	type: 'rectangleNeedle',
	                color: '#8FBC8F'
		            }
		        });
		    		
		    	
		    },
		    complete:function() {		    	
		    	
		    	
		    	
	        },
		    error: function (error) {
		 	        
		    }
		        
		});

	}();
	
var gauge_ticketsize = function() {
	
		$.ajax({
	      	url: url[3],
	        data: { RMCode: condition },
	        type: "GET",
        jsonpCallback: "result_ticketsize",
        dataType: "jsonp",
        crossDomain: true,
       	beforeSend:function() {
       	
        },
	    success: function (responsed) {   

	    	$("#gauge_ticketsizechart_values").dxCircularGauge({

				subtitle: '<span style="color: ' + background + '"> | </span>',			
	            scale: {
	                startValue: 0,
	                endValue: 10,
	                majorTick: {
	                	color: '#FFF',
	                	tickInterval: 1,
	                	useTicksAutoArrangement: false
	                },
	                label: {
	                    indentFromTick: 5, 		                    
	                    customizeText: function (arg) {
	                        return arg.valueText + 'MB';
	                    },		                    
	                    font: {		   
	                    	size: fontSize,
	                    	color: fontColor,
	                    	weight: fontStyle,
	                    	family: fontName
	                    }
	                }

	            },
	            rangeContainer: {
	                width: 4,
	                backgroundColor: 'none',
	                ranges: [
						{
						    startValue: 0,
						    endValue: 1,
						    color: '#e15258'
						},
						
						{
						    startValue: 1,
						    endValue: 5,
						    color: '#FCBB69'
						},		              
						{
						    startValue: 5,
						    endValue: 10,
						    color: '#A6C567'
						}
	                ]
	            },
	            tooltip: {
	            	enabled: true
	            },
	            animationDuration: 200,
	            animationEnabled: true,
	            needles: [{
	                offset: 5,
	                indentFromCenter: 7,		               
	                color: '#43474b'
	            }],
	            value: responsed.Data[0].TicketSize,                
	            valueIndicator: {
	            	type: 'rectangleNeedle',
	            	 color: '#e15258',
	                 secondColor: '#e15258'
                },
	            spindle: {
	                color: '#43474b'
	            },
	            subvalues: [9],
	            subvalueIndicator: {
	            	type: 'rectangleNeedle',
	                color: '#8FBC8F'
		            }
		        });
		    		
		    	
		    },
		    complete:function() {		    	
		    			    	
		    	
	        },
		    error: function (error) {
		 	        
		    }
		        
		});
		
	}();
	
}

// Insurance
function loadGaugeInsurance(url, condition, reload) {
	
	$.ajax({
      	url: url,
        data: { RMCode: condition },
        type: "GET",
        jsonpCallback: "result_insurance",
        dataType: "jsonp",
        crossDomain: true,
       	beforeSend:function() {       	
       		$('#mrta_chart_values').empty();
       		$('#cashy_chart_values').empty();
       		
        },
	    success: function (responsed) {   
	    		    	
		    var ggmrta = new JustGage({
		        id: "mrta_chart_values",
		        value: responsed.Data[0].CM_MRTA,
		        min: 0,
		        max: 100,
		        title: "MRTA",	    		       
		        label: "YTD",	
		        titleFontColor: '#FFF',
		        labelFontColor: '#FFF',
		        valueFontColor: '#FFF', 
		        humanFriendly: true,
		        startAnimationTime: 10000,
		        refreshAnimationTime: 10000,
		        gaugeWidthScale: 0.4,
		        customSectors: [
		          {
		            color : "#e15258",
		            lo : 0,
		            hi : 60
		          },{
		            color : "#fcbb69",
		            lo : 60,
		            hi : 99
		          }, {
		            color : "#a6c567",
		            lo : 99,
		            hi : 100
		          }
		        ],
		        counter: true,
		        textRenderer: function() { return responsed.Data[0].YTD_MRTA + '%'; }
		    
		    });
	    	
		    var ggcashy = new JustGage({
		        id: "cashy_chart_values",
		        value: responsed.Data[0].CM_Cashy,	    		 
		        min: 0,
		        max: 100,
		        title: "CASHY",
		        label: "YTD",
		        titleFontColor: '#FFF',
		        labelFontColor: '#FFF',
		        valueFontColor: '#FFF', 
		        humanFriendly: true,
		        startAnimationTime: 10000,
		        refreshAnimationTime: 10000,
		        gaugeWidthScale: 0.4,
		        customSectors: [
		          {
		            color : "#e15258",
		            lo : 0,
		            hi : 60
		          },{
		            color : "#fcbb69",
		            lo : 60,
		            hi : 99
		          }, {
		            color : "#a6c567",
		            lo : 99,
		            hi : 100
		          }
		        ],
		        counter: true,
		        textRenderer: function() { return responsed.Data[0].YTD_Cashy + '%'; }
		    });

	    		    
	        if(reload) {
	        	ggmrta.refresh(responsed.Data[0].CM_MRTA);
	        	ggcashy.refresh(responsed.Data[0].CM_Cashy);
	        	
	        }

	    },
	    cache: false,
	    complete:function() {
	    	
        },
	    error: function (error) {
	 	        
	    }
	        
	});	

}


/** Loading: Table Strcture-Relation **/
// A2CA
function loadDataTableAppQuality(data_stack, theme) {
	
	var data = new google.visualization.DataTable();
	data.addColumn('string', table_header);	
	
	var combine = [
	    '<span style="background: ' + theme[2] + '; height: 10px; width: 12.5px; padding: 0 0 0 8px; margin: 0 auto; text-align: right;">#</span>' +
		'<span style="background: ' + theme[1] + '; height: 10px; width: 12.5px; padding: 0 8px 0 0; margin: 0 auto; text-align: left;">#</span>',
		Math.round(data_stack[4].Jan + data_stack[5].Jan),
		Math.round(data_stack[4].Feb + data_stack[5].Feb),
		Math.round(data_stack[4].Mar + data_stack[5].Mar),
		Math.round(data_stack[4].Apr + data_stack[5].Apr),
		Math.round(data_stack[4].May + data_stack[5].May),
		Math.round(data_stack[4].Jun + data_stack[5].Jun),
		Math.round(data_stack[4].Jul + data_stack[5].Jul),
		Math.round(data_stack[4].Aug + data_stack[5].Aug),
		Math.round(data_stack[4].Sep + data_stack[5].Sep),
		Math.round(data_stack[4].Oct + data_stack[5].Oct),
		Math.round(data_stack[4].Nov + data_stack[5].Nov),
		Math.round(data_stack[4].Dec + data_stack[5].Dec)             
	];
	
	var a2ca_t2	= [	
	    '<span style="background: ' + theme[0] + '; height: 10px; padding: 0 8px; margin: 0 auto; text-align: left;">##</span>',
		Math.round(data_stack[1].Jan),
		Math.round(data_stack[1].Feb),
		Math.round(data_stack[1].Mar),
		Math.round(data_stack[1].Apr),
		Math.round(data_stack[1].May),
		Math.round(data_stack[1].Jun),
		Math.round(data_stack[1].Jul),
		Math.round(data_stack[1].Aug),
		Math.round(data_stack[1].Sep),
		Math.round(data_stack[1].Oct),
		Math.round(data_stack[1].Nov),
		Math.round(data_stack[1].Dec)
	];
	
	var total	= [
	    '<span style="background: ' + theme[0] + '; height: 10px; padding: 0 5px; margin: 0 auto; text-align: left;">%%</span>',
		Math.round(data_stack[2].Jan),
		Math.round(data_stack[2].Feb),
		Math.round(data_stack[2].Mar),
		Math.round(data_stack[2].Apr),
		Math.round(data_stack[2].May),
		Math.round(data_stack[2].Jun),
		Math.round(data_stack[2].Jul),
		Math.round(data_stack[2].Aug),
		Math.round(data_stack[2].Sep),
		Math.round(data_stack[2].Oct),
		Math.round(data_stack[2].Nov),
		Math.round(data_stack[2].Dec)     	   
	];
	
	for(var i = 0; i <= d.getMonth(); i ++) {
		data.addColumn('number', formatMonth[month_format][i]);
	}
	
	var objData1 = [], objData2 = [], objData3 = [];	
	for(var i = 0; i <= d.getMonth() + 1; i ++) {
		objData1.push(combine[i]);
		objData2.push(a2ca_t2[i]);
		objData3.push(total[i]);
	}
	
	data.addRows([objData1, objData2, objData3]);	

    var applyStyling = function() {
    	
        $(".google-visualization-table-table").find('*').each(function (i, e) {
            var classList = e.className ? e.className.split(/\s+/) : [];
            $.each(classList, function (index, item) {
                if (item.indexOf("google-visualization") === 0) {
                    $(e).removeClass(item);
                }
            });
        });
        
        $(".google-visualization-table-table")
            .removeClass('google-visualization-table-table')
            .addClass('table table-bordered table-condensed')
            .css("width", "100%")
            .css("height:", "100%")
            .css("min-height:", "auto")
            .css('font-size', fontSize)
            .css('font-color', fontColor)
            .css('font-family', fontName)
            .css('font-weight', fontStyle);
            
    }
	
	var table = new google.visualization.Table(document.getElementById('appquality_info'));
		table.draw(data, {allowHtml: true, showRowNumber: false, sort: 'disable', width: '100%', height: '100%', 'cssClassNames': cssClassNames });
	
    	google.visualization.events.addListener(table, 'sort', applyStyling);
    	applyStyling();	 

}

function loadTableActualDataRecord(responsed, theme) {
	
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'KPI');
	
	var combine = [
   	    '<span style="background: ' + theme[2] + '; height: 10px; width: 12.5px; padding: 0 0 0 10px; margin: 0 auto; text-align: right;">#</span>' +
		'<span style="background: ' + theme[1] + '; height: 10px; width: 12.5px; padding: 0 10px 0 0; margin: 0 auto; text-align: left;">#</span>',
		Math.round(responsed.Data[0].Jan) + Math.round(responsed.Data[2].Jan), 
		Math.round(responsed.Data[0].Feb) + Math.round(responsed.Data[2].Feb), 
		Math.round(responsed.Data[0].Mar) + Math.round(responsed.Data[2].Mar), 
		Math.round(responsed.Data[0].Apr) + Math.round(responsed.Data[2].Apr), 
		Math.round(responsed.Data[0].May) + Math.round(responsed.Data[2].May),
		Math.round(responsed.Data[0].Jun) + Math.round(responsed.Data[2].Jun), 
		Math.round(responsed.Data[0].Jul) + Math.round(responsed.Data[2].Jul), 
		Math.round(responsed.Data[0].Aug) + Math.round(responsed.Data[2].Aug),
		Math.round(responsed.Data[0].Sep) + Math.round(responsed.Data[2].Sep),
		Math.round(responsed.Data[0].Oct) + Math.round(responsed.Data[2].Oct), 
		Math.round(responsed.Data[0].Nov) + Math.round(responsed.Data[2].Nov), 
		Math.round(responsed.Data[0].Dec) + Math.round(responsed.Data[2].Dec)
   	];
   	
   	var referral	= [	
		'<span style="background: ' + theme[0] + '; height: 10px; padding: 0 10px; margin: 0 auto; text-align: left;">##</span>',
		Math.round(responsed.Data[1].Jan), 
		Math.round(responsed.Data[1].Feb), 
		Math.round(responsed.Data[1].Mar), 
		Math.round(responsed.Data[1].Apr), 
		Math.round(responsed.Data[1].May),
		Math.round(responsed.Data[1].Jun), 
		Math.round(responsed.Data[1].Jul), 
		Math.round(responsed.Data[1].Aug),
		Math.round(responsed.Data[1].Sep),
		Math.round(responsed.Data[1].Oct), 
		Math.round(responsed.Data[1].Nov), 
		Math.round(responsed.Data[1].Dec)
   	];
   	
   	var actualDD	= [
   	    '<span style="background: ' + theme[2] + '; height: 10px; padding: 0 6px; margin: 0 auto; text-align: left;">%%</span>', 
		Math.round(responsed.Data[3].Jan), 
		Math.round(responsed.Data[3].Feb), 
		Math.round(responsed.Data[3].Mar), 
		Math.round(responsed.Data[3].Apr), 
		Math.round(responsed.Data[3].May), 
		Math.round(responsed.Data[3].Jun), 
		Math.round(responsed.Data[3].Jul), 
		Math.round(responsed.Data[3].Aug), 
		Math.round(responsed.Data[3].Sep), 
		Math.round(responsed.Data[3].Oct), 
		Math.round(responsed.Data[3].Nov), 
		Math.round(responsed.Data[3].Dec)
   	];
   	
   	for(var i = 0; i <= d.getMonth(); i ++) {
   		data.addColumn('number', formatMonth[month_format][i]);
   	}
   	
   	var objData1 = [], objData2 = [], objData3 = [];	
   	for(var i = 0; i <= d.getMonth() + 1; i ++) {
   		objData1.push(combine[i]);
   		objData2.push(referral[i]);
   		objData3.push(actualDD[i]);
   	}
   	
   	data.addRows([objData1, objData2, objData3]);
   	
    var applyStyling = function() {
    	
        // some restyling code:
        $(".google-visualization-table-table").find('*').each(function (i, e) {
            var classList = e.className ? e.className.split(/\s+/) : [];
            $.each(classList, function (index, item) {
                if (item.indexOf("google-visualization") === 0) {
                    $(e).removeClass(item);
                }
            });
        });
        
        $(".google-visualization-table-table")
            .removeClass('google-visualization-table-table')
            .addClass('table table-bordered table-condensed')
            .css("width", "100%")
            .css("height:", "100%")
            .css("min-height:", "auto")
            .css('font-size', fontSize)
            .css('font-color', fontColor)
            .css('font-family', fontName)
            .css('font-weight', fontStyle);
            
    }
	
	
	var table = new google.visualization.Table(document.getElementById('target_info'));
    var formatter = new google.visualization.NumberFormat({ negativeParens: true, fractionDigits: 0 });
    	formatter.format(data, 1);
    	table.draw(data, {allowHtml: true, showRowNumber: false, sort: 'disable', width: '100%', height: '100%', 'cssClassNames': cssClassNames }); 
    	applyStyling();
}

function loadTableApprovalRateDataRecord(responsed, theme) {
	
	var data = new google.visualization.DataTable();
		data.addColumn('string', 'KPI');
	
	var approved = [
      	'<span style="background: '+ theme[0] + '; height: 10px; padding: 0 9px; margin: 0 auto; text-align: left;">##</span>', 
  		Math.round(responsed.Data[0].Jan),
		Math.round(responsed.Data[0].Feb),
		Math.round(responsed.Data[0].Mar),
		Math.round(responsed.Data[0].Apr),
		Math.round(responsed.Data[0].May),
		Math.round(responsed.Data[0].Jun),
		Math.round(responsed.Data[0].Jul),
		Math.round(responsed.Data[0].Aug),
		Math.round(responsed.Data[0].Sep),
		Math.round(responsed.Data[0].Oct),
		Math.round(responsed.Data[0].Nov),
		Math.round(responsed.Data[0].Dec)
  	];
      	
    var cancel	= [	
		'<span style="background: ' + theme[1] + '; height: 10px; padding: 0 6px; margin: 0 auto; text-align: left;">%%</span>',
		Math.round(responsed.Data[3].Jan), 
		Math.round(responsed.Data[3].Feb), 
		Math.round(responsed.Data[3].Mar), 
		Math.round(responsed.Data[3].Apr), 
		Math.round(responsed.Data[3].May), 
		Math.round(responsed.Data[3].Jun), 
		Math.round(responsed.Data[3].Jul), 
		Math.round(responsed.Data[3].Aug), 
		Math.round(responsed.Data[3].Sep), 
		Math.round(responsed.Data[3].Oct), 
		Math.round(responsed.Data[3].Nov), 
		Math.round(responsed.Data[3].Dec)
    ];
      	
    var pullthrought = [
		'<span style="background: ' + theme[2] + '; color: gray; height: 10px; padding: 0 6px; margin: 0 auto; text-align: left;">%%</span>', 
		Math.round(responsed.Data[6].Jan), 
		Math.round(responsed.Data[6].Feb), 
		Math.round(responsed.Data[6].Mar), 
		Math.round(responsed.Data[6].Apr), 
		Math.round(responsed.Data[6].May), 
		Math.round(responsed.Data[6].Jun), 
		Math.round(responsed.Data[6].Jul), 
		Math.round(responsed.Data[6].Aug), 
		Math.round(responsed.Data[6].Sep), 
		Math.round(responsed.Data[6].Oct), 
		Math.round(responsed.Data[6].Nov), 
		Math.round(responsed.Data[6].Dec)
    ];
      	
    for(var i = 0; i <= d.getMonth(); i ++) {
      	data.addColumn('number', formatMonth[month_format][i]);
    }
  	
   
  	var objData1 = [], objData2 = [], objData3 = [];	
  	for(var i = 0; i <= d.getMonth() + 1; i ++) {
  		objData1.push(approved[i]);
  		objData2.push(cancel[i]);
  		objData3.push(pullthrought[i]);
  	}
  	
  	data.addRows([objData1, objData2, objData3]);
  	
  	var applyStyling = function() {

        $(".google-visualization-table-table").find('*').each(function (i, e) {
            var classList = e.className ? e.className.split(/\s+/) : [];
            $.each(classList, function (index, item) {
                if (item.indexOf("google-visualization") === 0) {
                    $(e).removeClass(item);
                }
            });
        });
        
        $(".google-visualization-table-table")
            .removeClass('google-visualization-table-table')
            .addClass('table table-bordered table-condensed')
            .css("width", "100%")
            .css("height:", "100%")
            .css("min-height:", "auto")
            .css('font-size', fontSize)
            .css('font-color', fontColor)
            .css('font-family', fontName)
            .css('font-weight', fontStyle);
            
    }
	

	var table = new google.visualization.Table(document.getElementById('approvalrate_info'));
	var formatter = new google.visualization.NumberFormat({ negativeParens: true, fractionDigits: 0 });
	    formatter.format(data, 1);
	    
	table.draw(data, {allowHtml: true, showRowNumber: false, sort: 'disable', width: '100%', height: '100%',  'cssClassNames': cssClassNames });
	applyStyling();

}




//************* # FUNCTION # ***************
function roundFixed(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

function numberWithCommas(num){
	
    var n = num.toString(), p = n.indexOf('.');
    var fortmatter = n.replace(/\d(?=(?:\d{3})+(?:\.|$))/g, function($0, i){
        return p<0 || i<p ? ($0+',') : $0;
    });
     
     return fortmatter;
}