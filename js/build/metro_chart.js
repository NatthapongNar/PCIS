// #Configulation
var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }	

var instantDate = new Date(),
	day   = instantDate.getDay(),
	month = instantDate.getMonth(),
	year  = instantDate.getFullYear();

var employeecode = $('#empprofile_identity').val();

var month_format = 0;
var fontSize	 = 9;
var background   = '#FFF';
var fontColor	 = '#FFF';
var fontName	 = 'Arial';
var fontStyle	 = 'bold';

var formatMonth = [
   ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   ['01','02','03','04','05','06','07','08','09','10','11','12'],
   ['1','2','3','4','5','6','7','8','9','10','11','12'],
   ['J','F','M','A','M','J','J','A','S','O','N','D']
];

var formatRegion 	 = ['E', 'C', 'N', 'S', 'I'];
var formatRegionFull = ['East', 'Central', 'North', 'South', 'Northeast'];

// #Statement Initialyze
$(function() {
	
	$('#tile_lb').click(function() {
		$('#tile_bkk').removeClass('active').after(function() {
			$('#tile_lb').addClass('active');
		});	
	})
	
	// # Referral
	$.queue($('div[id="referal_parent"]'), function(element) {
		var empcode = $('#empprofile_identity').val();
		$.ajax({
	        url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/referral/' + empcode,
	        type: "GET",
	        success: function (resp) {
	        	getTLDashboardOverview({ 'OverviewTLHeader': resp.OverviewTLHeader, 'OverviewTLDescription': resp.OverviewTLDescription });
	        	getTLDashboardVolumeSummary({ 'TLVolumeHeader': resp.TLVolumeHeader, 'TLVolumeDescription': resp.TLVolumeDescription });
	        	getTLDashboardAgenteSummary({ 'TLAgentSummaryHeader': resp.TLAgentSummaryHeader, 'TLAgentSummaryDescription': resp.TLAgentSummaryDescription });	        	
	        	
	        },
	        complete: function() {
	        	$.dequeue(this);
	        },
	        error: function (error) { 
	      	  console.log(error); 
	        }
		});
		
		// Table Dashboard
		function getTLDashboardOverview(data) {
			$('#tl_subbrannerMTD > small').text(moment().format('MMM').toUpperCase() + ' VOL.');
			if(data.OverviewTLHeader[0] !== undefined) {
				$('#tl_totalAgentYTD').text('Total Agent : ' + checkValue(data.OverviewTLHeader[0].OverallActiveAgent)).fadeIn();
				$('#tl_activePercentage').text('Active : ' + roundFixed(checkValue(data.OverviewTLHeader[0].ActivePercentage), 0) + '%').fadeIn();	
			} else {
				$('#tl_totalAgentYTD').text('Total Agent : 0');
				$('#tl_activePercentage').text('Active : 0');
			}
			
			if(data.OverviewTLDescription[0] !== undefined) {
				var i = 1;
				setTimeout(function() {
					$.each(data.OverviewTLDescription, function(index, value) {
						$('.tlagent_cell' + i).text(
							checkValue(value.StatusDigit) +
							checkValue(value.StatusAmt) + 
							' (' + roundFixed(checkValue(value.Percentage), 0) + '%)'
						).addClass('animated fadeIn');	
						i++;					
					});
					
				}, 1000);
								
			}
		
		}

		// TL Volume
		function getTLDashboardVolumeSummary(data) {			
			// Logo Subheader
			var target_year = 400;
			var target_avg  = roundFixed(checkValue(((target_year / 12) * parseInt(moment().format('M')))), 0);
			var target_ach  = (roundFixed(checkValue(data.TLVolumeHeader[0].YTDVol), 0) / target_avg) * 100;
			if(data.TLVolumeHeader[0] !== undefined) {		
				setTimeout(function() {
					$('#tl_brannerMTD').text(roundFixed(checkValue(data.TLVolumeHeader[0].MTDVol), 0) + 'Mb').addClass('animated rubberBand');
					$('#tl_subbrannerMTD').removeClass('marginTop10');
					$('#tl_subbrannerMTD > small').text(checkValue(data.TLVolumeHeader[0].Target) + 'Mb (Ach. ' + roundFixed(checkValue(data.TLVolumeHeader[0].Achieve), 0) + '%' + ')').addClass('animated fadeIn');
								
				}, 2000);
				
				setTimeout(function() {
					$('#tl_brannerYTD').text(roundFixed(checkValue(data.TLVolumeHeader[0].YTDVol), 0) + 'Mb').addClass('animated rubberBand');	
					$('#tl_subbrannerYTD').removeClass('marginTop10');
					$('#tl_subbrannerYTD > small').text(target_avg + 'Mb (Ach. ' + roundFixed(checkValue(target_ach), 0) + '%' + ')').addClass('animated fadeIn');
				}, 4700);
			
			} else {
				setTimeout(function() {
					$('#tl_brannerMTD').text('0Mb').addClass('animated rubberBand');
					$('#tl_subbrannerMTD, #tl_subbrannerYTD').removeClass('marginTop10');
					$('#tl_subbrannerMTD > small').text(checkValue(data.TLVolumeHeader[0].Target) + 'Mb (Ach. 0%)').addClass('animated fadeIn');
					
				}, 2000);
				
				setTimeout(function() {
					$('#tl_brannerYTD').text('0Mb').addClass('animated rubberBand');	
					$('#tl_subbrannerYTD').removeClass('marginTop10');
					$('#tl_subbrannerYTD > small').text(target_year + 'Mb (Ach. 0%)').addClass('animated fadeIn');
					
				}, 4700);
			
			}
		
			if(data.TLVolumeDescription[0] !== undefined) {
				var dataset   = [];
				var max_value = [];
				var regionset = [];
				
				var i = 1;
				$.each(data.TLVolumeDescription, function(index, value) {
					// Throw value for compare data  maximun
					max_value.push(roundFixed(checkValue(value.MTDVol), 0));
					max_value.push(roundFixed(checkValue(value.YTDVol), 0));
					
					dataset.push([roundFixed(checkValue(value.MTDVol), 0), roundFixed(checkValue(value.YTDVol), 0)]);
					regionset.push(value.RegionCode);
					
					$('#tlvol_header' + i).text(roundFixed(checkValue(value.YTDVol), 0));
					i++;
					
				});
							
				$('#ytd_sb_tlvolume').sparkline(dataset, { 
					type: 'bar',
					height: '70',
					barWidth: '12px',
					barSpacing: '8px',
					chartRangeMin: 0,
					chartRangeMax: setMaxValues(max_value),
					stackedBarColor: ['#FFFFFF', 'rgba(255, 255, 255, .2)'],
					myPrefixes: ['YTD', moment().format('MMM').toUpperCase()],
					tooltipFormatter: function(sp, options, fields) {
		
						var format =  $.spformat('<div class="jqsfield"><span style="color: {{color}}">&#9679;</span> {{myprefix}} : {{value}} Mb</div>');
						var result = '';
		                $.each(fields, function(i, field) {
		                    field.myprefix = options.get('myPrefixes')[i];
		                    result += format.render(field, options.get('tooltipValueLookups'), options);
		                })
		                
		                return result;
		                
		            }
				});
				
				setTimeout(function() { $('#ytdlabel_sb_tlvolume').removeClass('hide').addClass('animated fadeIn'); }, 200);
		
			}
						
		}
	
		function getTLDashboardAgenteSummary(data) {
			
			if(data.TLAgentSummaryHeader[0] !== undefined) {
				$('#tlagent_label > small').text('MTH'); //moment().format('MMM').toUpperCase()
				$('#tlagent_newagent > small').text(checkValue(data.TLAgentSummaryHeader[0].NewAgent));
				$('#tlagent_newagent').attr('title', 'Target : ' + checkValue(data.TLAgentSummaryHeader[0].Target));
				$('#tlagent_achieve > small').text('(' + roundFixed(checkValue(data.TLAgentSummaryHeader[0].Achieve), 0) + '%)');
				$('#tlagent_option > small').text('Active');
			} else {		
				$('#tlagent_label > small').text('New');
				$('#tlagent_new_agent > small').text('0');
				$('#tlagent_achieve > small').text('(0%)');
				$('#tlagent_option > small').text('Active');
			}
			
			if(data.TLAgentSummaryDescription[0] !== undefined) {

				var i = 1;
				var result = [{'CM': [], 'YTD': [], 'labels': [] }];
				$.each(data.TLAgentSummaryDescription, function(index, value) {
					result[0].CM.push(value.MTDAgent);
					result[0].YTD.push(value.YTDAgent);
					result[0].labels.push(value.RegionDigit);
			
					$('.tlagent_atlabel' + i + ' > small').text(value.RegionDigit);
					$('.tlagent_atPercent' + i).text(roundFixed(checkValue(value.ActivePercentage), 0) + '%').attr('title', 'Active Agent : ' + value.ActiveAgent);					
					
					i++;
					
				});
				
				var chartData = {
					labels: result[0].labels,
			  		datasets : [
			  			{
			  				label: moment().format('MMM').toUpperCase(),
			  		        backgroundColor: "#FFFFFF",
			  				data : result[0].CM
			  			},
			  			{
			  				label: 'YTD',
			  				backgroundColor : 'rgba(255, 255, 255, .2)',
			  				data : result[0].YTD
			  			}
			  		]
			  	};
				
				var instant = document.getElementById('agent_accu');
				var bar_horizontal = new Chart(instant, {
				    type: 'horizontalBar',
				    data: chartData,
				    options: {
				    	legend: { display: false },				    
				    	tooltips: {
			            	enabled: true,
			            	titleFontSize: 10,
			                bodyFontSize: 10,
			                //xPadding: 5,
			                //yPadding: 5,
			                caretSize: 5,
			                cornerRadius: 0,
			                backgroundColor: 'rgba(0, 0, 0, .6)',
			                callbacks: {     
			                	title: function (tooltipItems, data) { return null },			                    
			                    label: function (tooltipItems, data) {
			                         return data.datasets[tooltipItems.datasetIndex].label + ' : ' + roundFixed(checkValue(data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index]), 0);
			                    }			                    
		                    }
			            },
				    	scales: {	
		                    xAxes: [{     
		                        display: false,		                 
		                        scaleLabel: {}		                    
		                        
		                    }],
		                    yAxes: [{
		                    	categoryPercentage: 0.75,
		                    	ticks: { 
		                    		beginAtZero: true, 
		                            fontColor: '#FA6800'
		                    	},                    		
		                        display: false,
		                        stacked: true,
		                        scaleLabel: {
		                        	fontColor: fontColor,
		                        	fontSize: '9px'
		                        },
		                        gridLines: { display: false },
		                        
		                    }]
		                }
				    }
				});
			
			}

		}

	}('referal_parent'));

	// # Collection
	$.queue($('span[id="collection_chart"]'), function(element) { loadCollectinDashboard(element, $('#empprofile_identity').val(), 1); }('#collection_chart'));
	$('#collection_filter').change(function() { loadCollectinDashboard('#collection_chart', $('#collection_filter').val(), 2); });
	
	function loadCollectinDashboard(element, emp_code, flag) {
		
		var flag_load = (flag == 2) ? '/' + flag:'';
		
		//var emp_code  = $('#empprofile_identity').val();
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/collection/' + emp_code + flag_load,
	        type: "GET",
	        beforeSend: function() { $('#filter_connect_collection > i').removeClass('fg-green').addClass('fg-red'); },
		    success: function (responsed) {
		    	
		      	var monthly	= [],
	    		target		= [],
	    		values  	= [],
	    		percent		= [];
		   			      	
		      	var _month  = [],
		      	_target 	= [],
		      	_values 	= [],
		      	_percent	= [];
		 
		      	var offprevious = 3;
		      	if(responsed.NPLgraph.length > 0) {
		      		//for(var i = 0; i < responsed.NPLgraph.length; i ++) {
		      		for(var i = 0; i < responsed.NPLgraph.length; i ++) {
		        		if(parseInt(responsed.NPLgraph[i].Year) !== parseInt(moment().format('YYYY'))) {
		        			if(parseInt(moment().format('M')) <= offprevious) {			        				
		        				_month.push(responsed.NPLgraph[i].Month);		        		
		        				_target.push(parseFloat(escape_keyword(checkValue(responsed.NPLgraph[i].Target))));
		        				_values.push(parseFloat(escape_keyword(checkValue(responsed.NPLgraph[i].Achieve))));
		        			}
		        						        			
		        		} else {
		        			monthly.push(formatMonth[month_format][i]);		        		
		        			target.push(parseFloat(escape_keyword(checkValue(responsed.NPLgraph[i].Target))));
		        			values.push(parseFloat(escape_keyword(checkValue(responsed.NPLgraph[i].Achieve))));
		        		}
		        		
		        	}
		      	}
	        	
	        	if(values.length < 11) {
	        		if(parseInt(moment().format('M')) <= offprevious) {	
	        			for(var i = values.length; i <= 6; i++) {
		        			monthly.push(formatMonth[month_format][i]);		
		        			target.push(0);
		        			values.push(0);
		        		}
	        		} else {
	        			for(var i = values.length; i <= 11; i++) {
		        			monthly.push(formatMonth[month_format][i]);		
		        			target.push(0);
		        			values.push(0);
		        		}
	        		}
	        		
	        	}

	        	var useTemp = false;
	        	var nplTemp = [];
	        	
	        	if(useTemp) {
	        		var mIndex = new Date().getMonth() - 1;
	        		if(!monthly[mIndex]) {
	        			monthly.push(formatMonth[month_format][mIndex]);
	        		}
		        		
	        		//target[mIndex] = 1.50;
	        		//values[mIndex] = 1.64;
	        		
	        		nplTemp.push(
	        			{Acc: "93", Class: "NPL", Compare: "P", Percent: "1.83%", Volume: "141.92Mb"},
	        			{Acc: "189", Class: "M", Compare: "N", Percent: "4.39%", Volume: "340.36Mb"}
	        		);
	        		
	        	}
	        	
	        	var max_range = 3;
	        	if(_values.length > 0) {
	        		
	        		$('#collection_chart_pass').removeClass('hide').css('margin-left', '-5px;');
	        		$('span#collection_chart').css({ 'width': '85px !important', 'max-width': '85px !important' }); //, 'position': 'absolute'
	        		
	        		$('#collection_chart_pass').sparkline(_values, { 
						type: 'bar', 
						barWidth: '9px',
						height: '40',
						chartRangeMin: 0,
						chartRangeMax: max_range,
						barColor: 'rgba(255, 255, 255, 0.2)',
						tooltipSuffix: '%',
						tooltipFormat: '{{prefix}}{{offset:offset}} ' + (moment().format('YYYY') -1) + ' : {{value}}{{suffix}}',						
			            tooltipValueLookups: {			            	    
			            	'offset': _month 
			            }  
					});
	  
	        	}
	        	
	        	if(moment().format('YYYY') == '2017') {
	        		values[5] = 2.03;
	        	}
	        	
		    	$(element).sparkline(values, { 
					type: 'bar', 
					barWidth: '9px',
					height: '40',
					chartRangeMin: 0,
					chartRangeMax: max_range,
					barColor: 'white',
					tooltipSuffix: '%',
					tooltipFormat: '{{prefix}}{{offset:offset}} : {{value}}{{suffix}}',						
		            tooltipValueLookups: {			            	    
		            	'offset': {
		            	    0: 'Jan',
		            	    1: 'Feb',
		            	    2: 'Mar',
		            	    3: 'Apr',
		            	    4: 'May',
		            	    5: 'Jun',
		            	    6: 'Jul',
		            	    7: 'Aug',
		            	    8: 'Sep',
		            	    9: 'Oct',
		            	    10: 'Nov',
		            	    11: 'Dec'
				        }  
		            }  
				});
				
				$(element).sparkline(target, { 
					composite: true, 
					fillColor: false, 
					chartRangeMax: max_range,
					lineColor: "rgba(255, 45, 25, 1)",
					tooltipPrefix: 'Target: ',
					tooltipSuffix: '%',
					tooltipFormat: '{{prefix}}{{offset:offset}} : {{y}}{{suffix}}',
					tooltipValueLookups: {			            	    
		            	'offset': {
		            	    0: 'Jan',
		            	    1: 'Feb',
		            	    2: 'Mar',
		            	    3: 'Apr',
		            	    4: 'May',
		            	    5: 'Jun',
		            	    6: 'Jul',
		            	    7: 'Aug',
		            	    8: 'Sep',
		            	    9: 'Oct',
		            	    10: 'Nov',
		            	    11: 'Dec'
				        }  
		            }  
				});
						
				var font_color = ['fg-red', 'fg-green'];
				var emotion	   = ['fa-frown-o ', 'fa-smile-o'];
				var colSwitch  = (useTemp) ? nplTemp:responsed.CollectionClass;
				if(colSwitch[0] != undefined || responsed.CollectionClass[0] != undefined) {
					
					if(responsed.CollectionFlag[0].Collection != undefined) {
						
						$('#collect_flag > tbody').empty().remove();					
						$.each(responsed.CollectionFlag, function(index, value) {
					
							colSwitch.push({
								Acc: value.nTotal,
								Class: "FLAG",
								Compare: value.Compare,
								Percent: value.Diff,
								Volume: value.Volume
							});
							
						});
						
					}
				
					var coverview
					$('#collectionclass_overview > tbody').empty();
					$.each(colSwitch, function(index, value) {
						
						if(value.Class !== 'FLAG') {
							
							var icon_color = '';
							var icon_feel  = '';
							if(value.Compare == 'P') {
								icon_color = font_color[0];
								icon_feel  = emotion[0];
							} else  {
								icon_color = font_color[1];
								icon_feel  = emotion[1];
							}
							
							$('#collectionclass_overview > tbody').append(
								'<tr>' +
									'<td style="min-width: 53px; max-width: 53px;" class="fixed ">' + value.Class + '</td>' +
									'<td style="min-width: 60px; max-width: 60px;" class="fixed paddingLR_none text-right">' + roundFixed(escape_keyword(checkValue(value.Volume)), 0) + 'Mb</td>' +
									'<td style="min-width: 40px; max-width: 40px;" class="fixed paddingLR_none text-right">' + value.Acc + '</td>' +
									'<td style="min-width: 48px; max-width: 48px;" class="fixed paddingLR_none text-right">' + roundFixed(escape_keyword(checkValue(value.Percent)), 1).toFixed(1) + '%</td>' +
									'<td style="min-width: 42px; max-width: 42px;" class="fixed text-center"><span class="fa ' + icon_feel + ' ' + icon_color + '" aria-hidden="true" style="font-size: 1.3em;"></span></td>' +
								'</tr>'	
							);
							
						} else {
							
							var icon_feel  	 = '';
							var icon_bgcolor = ['bg-red', 'bg-green',];
							if(value.Compare == 'P') {
								icon_feel  = '<span class="badge ' + icon_bgcolor[0] + '">+' + value.Percent + '</span>';
							} else {
								icon_feel  = '<span class="badge ' + icon_bgcolor[1] + '">-' + value.Percent + '</span>';
							}
							
							$('#collectionclass_overview > tbody').append(
								'<tr style="border-top: 1px solid #D1D1D1;">' +
									'<td style="min-width: 53px; max-width: 53px;" class="fixed">' + value.Class + '</td>' +						
									'<td style="min-width: 60px; max-width: 60px;" class="fixed paddingLR_none text-right">' + roundFixed(escape_keyword(checkValue(value.Volume)), 1) + 'Mb</td>' +
									'<td style="min-width: 40px; max-width: 40px;" class="fixed paddingLR_none text-right">' + value.Acc + '</td>' +
									'<td style="min-width: 48px; max-width: 48px;" class="fixed paddingLR_none text-right">&nbsp;</td>' +
									'<td style="min-width: 50px; max-width: 50px;" class="fixed text-right">' + icon_feel + '</td>' +					
								'</tr>'	
							);
							
						}

					});
					
				
					$('#collectionclass_overview > tbody td').addClass('animated fadeIn');
					
				}
				
				if(responsed.CollectionIndividual[0].Yesterday != undefined) {
					$('#yesterday_span').text(responsed.CollectionIndividual[0].Yesterday);
					$('#today_span').text(responsed.CollectionIndividual[0].Today);
				}
		    	
		    },
		    complete:function() {	    		    	
		    	$.dequeue(this);
		    	$('#filter_connect_collection > i').removeClass('fg-red').addClass('fg-green');
	        },
		    error: function (error) {
		 	    console.log(error);   
		    }	        
		});
		
	}
	
	// #Whiteboard
	$.queue($('span[id="balanace_values"]'), function(sb_element, a2ca_element, value) {	
		
		var role_flag = null;
		var emp_code  = value;
		var role_auth = $('#emp_role').val();
		
		if(in_array(role_auth, ['adminbr_role'])) { role_flag = 1; } 
		else { role_flag = 2;}

    	var sort_by = function(field, reverse, primer) {
		    var key = primer ? 
		       function(x) {return primer(x[field])} : 
		       function(x) {return x[field]};

		    reverse = !reverse ? 1 : -1;

		    return function (a, b) {
		       return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
		    } 
    	}
    				    	
    	var removeByAttr = function(arr, attr, value){
    	    var i = arr.length;
    	    while(i--){
    	       if( arr[i] 
    	           && arr[i].hasOwnProperty(attr) 
    	           && (arguments.length > 2 && arr[i][attr] === value ) ){ 

    	           arr.splice(i,1);

    	       }
    	    }
    	    return arr;
    	}
		 
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/whiteboard/' + emp_code + '/' + role_flag,
	        type: "GET",
	        beforeSend: function() {
	        	$('#sb_progress, #a2ca_progress').show();
	        	
	        	if(!in_array(role_auth, ['hq_role'])) { 
	        		$('.sb_vollabel_auth_1').text('');
					$('.sb_vollabel_auth_2').text('');
					$('.sb_vollabel_auth_3').text('');
					$('.sb_vollabel_auth_4').text('');
					$('.sb_vollabel_auth_5').text('');
					
					$('.a2ca_labelauth_1').text('');
					$('.a2ca_labelauth_2' ).text('');
					$('.a2ca_labelauth_3' ).text('');
					$('.a2ca_labelauth_4' ).text('');
					$('.a2ca_labelauth_5' ).text('');
	        		
	        	}	        	
	        	        	
	        },
		    success: function (resp) {	
		    	var responsed  = resp[0];
		    	var individual = (resp[1]) ? resp[1]:null;
		    	// #######  SB Volume #######
		    				    	
		    	// ** Pending DD
		    	if(responsed.Approved[0].List !== undefined) {
		    		$('#pending_dd_amt').empty().text(roundFixed(escape_keyword(responsed.Approved[0].PreLoan), 0) + 'Mb').addClass('animated fadeInUp');
		    		//$('#pending_dd_app').empty().text(escape_keyword(responsed.Approved[0].Actual)).addClass('animated fadeIn');
		    	}
		    	
		    	// SB Vol
		    	if(responsed.SBDrawDownOverview[0] !== undefined) {				  
		    		$('#label_sb_name > small').empty().text('SB Vol. (Mb)').addClass('animated fadeIn');
		    		
		    		$('#sb_volume').text(roundFixed(responsed.SBDrawDownOverview[0].ActualBK, 0)).addClass('animated fadeIn');
		    		$('#sb_tartget').text(responsed.SBDrawDownOverview[0].Target + ' ' + ' (Ach. ' + roundFixed(escape_keyword(responsed.SBDrawDownOverview[0].Achieve), 0) + '%)').addClass('animated fadeIn');
		    		$('#sb_vol_topic').parent().addClass('animated fadeOut');
	
		    	} else {
		    		$('#label_sb_name > small').empty().text('SB Vol. (Mb)').addClass('animated fadeIn');
		    		
		    		$('#sb_volume').text(0).addClass('animated fadeIn');
		    		$('#sb_tartget').text('0' + ' ' + ' (Ach. ' + '0' + '%)').addClass('animated fadeIn');
		    		$('#sb_vol_topic').parent().addClass('animated fadeOut');
		    	}
		    	
		    	// A2CA Vol
		    	if(responsed.A2CAOverview[0].List !== undefined) {						
		    		$('#label_a2ca_name > small').empty().text('A2CA (Unit)').addClass('animated fadeIn');
				    		
		    		$('#a2ca_volume').text(responsed.A2CAOverview[0].ActualBK).addClass('animated fadeIn');
		    		$('#a2ca_tartget').text(escape_keyword(responsed.A2CAOverview[0].Target) + 'App ' + ' (Ach. ' + roundFixed(escape_keyword(responsed.A2CAOverview[0].Achieve), 0) + '%)').addClass('animated fadeIn');
		    		$('#a2ca_tartget_topic').parent().addClass('animated fadeOut');
		    		
		    	}
		    	
		    	// ** RM On Hand
		    	if(responsed.RMonHand[0].List !== undefined) {
		    		
		    		var today_app	= (responsed.RMonHand[0].RMOnHand === undefined) ? 0 : responsed.RMonHand[0].RMOnHand;
		    		var compare_app	= (responsed.RMonHand[0].Compare === undefined) ? 0 : responsed.RMonHand[0].Compare;
		    		
		    		var rm_rate 	= (responsed.RMonHand[0].Achieve !== undefined) ? roundFixed(escape_keyword(responsed.RMonHand[0].Achieve), 0): '-';
		
		    		$('#rm_onhand_app').empty().text(escape_keyword(responsed.RMonHand[0].OnHand)).addClass('animated zoomIn');
		    		$('#rm_onhand_loan').empty().text(roundFixed(escape_keyword(responsed.RMonHand[0].RequestLoan), 0) + 'Mb' + ' (' + rm_rate + '%)').addClass('animated fadeIn').parent().removeClass('marginTop25');
		    		
		    		$('#rm_onhand_today > small').empty().html(compareData(today_app, compare_app, 'html')).addClass('animated fadeIn');
		    		$('#rm_onhand_today').addClass('marginTop10');
		    		
		    	}
		    	
		     	// ** CA Pending
		    	if(responsed.Pending[0].List !== undefined) {
		    		var today_app	= (responsed.Pending[0].Actual_CM === undefined) ? 0 : escape_keyword(responsed.Pending[0].Actual_CM);
		    		var volume  	= (responsed.Pending[0].Info === undefined) ? 0 : roundFixed(escape_keyword(responsed.Pending[0].Info), 0) + 'Mb';
		    		var achieve 	= (responsed.Pending[0].Achieve === undefined) ? 0 : ' (' + roundFixed(escape_keyword(responsed.Pending[0].Achieve), 0) + '%' + ')';
		    		
		    		var compare_app	= (responsed.Pending[0].Compare === undefined) ? 0 : responsed.Pending[0].Compare;
		    		
		    		$('#ca_decision_app').empty().text(escape_keyword(responsed.Pending[0].Actual)).addClass('animated zoomIn');
		    		$('#ca_pending_loan').empty().text(volume + ' ' + achieve).addClass('animated fadeIn').parent().removeClass('marginTop25');
		    		
		    		$('#ca_pending_today > small').html(compareData(today_app, compare_app, 'html')).addClass('animated fadeIn');
		    		$('#ca_pending_today').addClass('marginTop10');
		    		
		    	}
		    	
		    	// Check SBDrawDownOverview is null
		    	if(responsed.SBDrawDownOverview[0] === undefined) {
		    		responsed.SBDrawDownOverview.push(
		    			{ 
		    				Achieve: "0.00%", 
		    				Actual: "0Mb", 
		    				ActualBK: "0", 
		    				Info: "0Mb", 
		    				List: "SB",			    				
		    				Target: "0Mb", 
		    				Year: year,
		    				Month: formatMonth[month_format][month]
		    			}
		    		);
		    	}			    		
		   
		    	var index = 1;
		    	for(var i = 0; i < daysInMonth(moment().format('MM'), moment().format('YYYY')); i++)
	    		{
	    	
		    		var full_date = new Date(year, month, index.toString());
	    			var length = $.grep(responsed.SBDrawDownDairy, function(item) {
		    			return item.Day == index.toString();
		    			
		    		}).length;
		    		
		    		if(length <= 0)
		    		{			    			
		    			var obj = $.extend({},responsed.SBDrawDownDairy[0]);
		    			obj.Day = index.toString();
		    			obj.DD  = "0.00";
		    			obj.DayName = full_date.toString().substring(0, 3);
		    			responsed.SBDrawDownDairy.push(obj);
		    		}
		    
		    		index++;
		    		
	    		}

		    	// Day Sorting
		    	responsed.SBDrawDownDairy.sort(sort_by('Day', false, parseInt));
		    	
		    	// Delete Weekend
		    	removeByAttr(responsed.SBDrawDownDairy, 'DayName', 'Sat');
		    	removeByAttr(responsed.SBDrawDownDairy, 'DayName', 'Sun');
		    				    	
		    	var line_values  = [];
		    	var daily_offset = {};			    	
		    	if(responsed.SBDrawDownDairy.length >= 1) {	
		   
	        		$.each(responsed.SBDrawDownDairy, function(index, value) {		        			
	        			line_values.push(roundFixed(escape_keyword(checkValue(value.DD)), 1));
		        		daily_offset[index] =  value.Day + ' ' + value.DayName;
		        					        		
	        		});	
	        		
	        	}		
		  	
		    	// Check SBRegionModel Value
		    	if(responsed.SBRegionModel[0] === undefined){
		    		responsed.SBRegionModel.push(
		    			{ "DD": "0", "List": "RegionDD", "Month": formatMonth[month_format][month], "Year": year, "Name":"East" },
		    			{ "DD": "0", "List": "RegionDD", "Month": formatMonth[month_format][month], "Year": year, "Name":"Central" },
		    			{ "DD": "0", "List": "RegionDD", "Month": formatMonth[month_format][month], "Year": year, "Name":"North" },
		    			{ "DD": "0", "List": "RegionDD", "Month": formatMonth[month_format][month], "Year": year, "Name":"South" },
		    			{ "DD": "0", "List": "RegionDD", "Month": formatMonth[month_format][month], "Year": year, "Name":"I" }
		    		);
		    	}
		  
		    	var sb_bar_index  = 1;
		    	var sb_bar_value  = [];
		    	var sb_bar_offset = {};
		    	if(responsed.SBRegionModel.length >= 1) {
		    		
		    		$.each(responsed.SBRegionModel, function(index, value) {	
		    			
		    			sb_bar_value.push(roundFixed(escape_keyword(checkValue(value.DD)), 1));
		    			sb_bar_offset[index] = value.Name;
		    			
		    			$('.sb_volspan_' + sb_bar_index).text(roundFixed(escape_keyword(checkValue(value.DD)), 0)).addClass('animated fadeInDown');			        		
		    			sb_bar_index++;		        
	        
	        		});	
		    	}
					    	
				$(sb_element).sparkline(sb_bar_value, {						
					type: 'bar', 				
					height: '70',
					barWidth: '12px',
					barSpacing: '8px',
					barColor: 'rgba(0,0,0,0.2)',						
					chartRangeMin: 0,
					chartRangeMax: setMaxValues(sb_bar_value),
					//tooltipChartTitle: 'SB Volume',
					tooltipSuffix: ' Mb',
					tooltipFormat: '<span style="color: #1B6EAE">&#9679;</span> {{prefix}}{{offset:offset}} : {{value}}{{suffix}}',						
		            tooltipValueLookups: {			            	    
		            	'offset': sb_bar_offset  
		            },
		            // If remove tooltipFormatter chart will render tooltip.
		            tooltipFormatter: function (sparkline, options, fields) {
		            	return '';
						//return 'SB Volume';		            	
					}
					
				});

		    	$(sb_element).sparkline(line_values, { 
		    		composite: true, 
					type: 'line',
					height: '4em', 
					width: '8em',
					fillColor: false,
					lineColor: '#FFF',
					chartRangeMin: 0,
					chartRangeMax: 100,
					spotColor: false,
					minSpotColor: '#ff0000',
					maxSpotColor: '#ff0000',
					tooltipSuffix: ' Mb',						
					tooltipFormat: '{{prefix}}{{offset:offset}} : {{y}}{{suffix}}',	
					tooltipValueLookups: {		
						'offset': daily_offset 
					 }	
		    	
				});
		    	
		    	if(responsed.SBMonthly[0] !== undefined) {
		    		var max_length = responsed.SBMonthly.length - 1;
		    		$("#sb_slider").slider({
		    			min: 0,
		    			max: max_length,
		    			position: max_length,
		    			markerColor: '#01ABA9',
		    			colors: '#01ABA9',
		    			showHint: true,
		    			change: function(value, slider) {
		    				var index	   = parseInt(value);
		    				var data_model = responsed.SBMonthly;
		    				var actual	   = (roundFixed(escape_keyword(data_model[index].DD), 0)) ? roundFixed(escape_keyword(data_model[index].DD), 0):'0';
		    				var achieve	   = (roundFixed(escape_keyword(data_model[index].Ach), 0)) ? roundFixed(escape_keyword(data_model[index].Ach), 0):'0';
		    				$("#sb_slider > .hint").html(data_model[index].Month + '<br/> ' + actual + 'Mb<br/>Ach.' + achieve + '%')
		    				.css({'margin-top':'-15px'});
		    			},
		    			changed: function(value, slider){
		    				if(value < max_length) $("#sb_slider").slider('value', max_length);
		    			}
		    	    });
		    		
		    		$("#sb_slider > .marker").addClass('icon-arrow-left-4 fg-darkBlue').css('font-size', '1.1em');
		    			    		 
		    				    		
		    	}
		 
				$('#legend_sb_bar').css('visibility', 'visible').addClass('animated fadeIn');
				
				// #####################  A2CA #####################	
				
		    	if(responsed.A2CAOverview[0] === undefined) {
		    		responsed.A2CAOverview.push(
		    			{ 
		    				Achieve: "0.00%", 
		    				Actual: "0 App", 
		    				ActualBK: "0", 
		    				Info: "0 App", 
		    				List: "A2CA", 			    				
		    				Target: "0 App", 
		    				Year: year,
		    				Month: formatMonth[month_format][month]
		    			}
		    		);
		    	}	
			
				var day_index = 1;
		    	for(var i = 0; i < daysInMonth(moment().format('MM'), moment().format('YYYY')); i++) {
		    		
		    		var full_date = new Date(year, month, day_index.toString());
		    		var length = $.grep(responsed.A2CADairy, function(item){
		    			return item.Day == day_index.toString();
		    		}).length;
		    		
		    		if(length <= 0) {
		    			var obj = $.extend({}, responsed.A2CADairy[0]);
		    			obj.Day = day_index.toString();
		    			obj.A2CA = "0";
		    			obj.DayName = full_date.toString().substring(0, 3);
		    			responsed.A2CADairy.push(obj);
		    		}
		    		
		    		day_index++;	
		    		
	    		}
		 
		    	// Day Sorting
		    	responsed.A2CADairy.sort(sort_by('Day', false, parseInt));
		    	
		    	removeByAttr(responsed.A2CADairy, 'DayName', 'Sat');
		    	removeByAttr(responsed.A2CADairy, 'DayName', 'Sun');
		    	
		    	var line_a2ca_values  = [];
		    	var a2ca_daily_offset = {};
		    	if(responsed.A2CADairy.length >= 1) {				    		
	        		$.each(responsed.A2CADairy, function(index, value) {
	        			line_a2ca_values.push(parseFloat(escape_keyword(checkValue(value.A2CA))));
	        			a2ca_daily_offset[index] =  value.Day + ' ' + value.DayName;

	        		});		        		
	        	}
		    	
		    	// Check RegionA2CAModel Value
		    	if(responsed.RegionA2CAModel[0] === undefined){
		    		responsed.RegionA2CAModel.push(
		    			{ "A2CA": "0", "List": "RegionDD", "Month": formatMonth[month_format][month], "Year": year, "Name":"East" },
		    			{ "A2CA": "0", "List": "RegionDD", "Month": formatMonth[month_format][month], "Year": year, "Name":"Central" },
		    			{ "A2CA": "0", "List": "RegionDD", "Month": formatMonth[month_format][month], "Year": year, "Name":"North" },
		    			{ "A2CA": "0", "List": "RegionDD", "Month": formatMonth[month_format][month], "Year": year, "Name":"South" },
		    			{ "A2CA": "0", "List": "RegionDD", "Month": formatMonth[month_format][month], "Year": year, "Name":"I" }
		    		);
		    	}
		    	
		    	var a2ca_bar_index  = 1;
		    	var a2ca_bar_value  = [];
		    	var a2ca_bar_offset = {};
		    	if(responsed.RegionA2CAModel.length >= 1) {
		    		$.each(responsed.RegionA2CAModel, function(index, value) {		        						
		    			a2ca_bar_value.push(escape_keyword(checkValue(value.A2CA)));
		    			a2ca_bar_offset[index] = value.Name;
		    			
		    			$('.a2ca_volspan_' + a2ca_bar_index).text(roundFixed(escape_keyword(checkValue(value.A2CA)), 0)).addClass('animated fadeInDown');			        		
		    			a2ca_bar_index++;	
	        
	        		});	
		    	}
		    	
		    	if(line_a2ca_values.length >= 1) {
		    		
		    		var bar_values = [50, 120, 80, 60, 90];
					$(a2ca_element).sparkline(a2ca_bar_value, { 							
						type: 'bar', 				
						height: '70',
						barWidth: '12px',
						barSpacing: '8px',
						barColor: 'rgba(0,0,0,0.2)',
						chartRangeMin: 0,
						chartRangeMax: setMaxValues(a2ca_bar_value),
						//tooltipChartTitle: 'A2CA',
						tooltipSuffix: ' App',
						tooltipFormat: '<span style="color: #1B6EAE">&#9679;</span> {{prefix}}{{offset:offset}} : {{value}}{{suffix}}',						
			            tooltipValueLookups: {			            	    
			            	'offset': a2ca_bar_offset 
			            },				            
			            tooltipFormatter: function (sparkline, options, fields) {
			            	return '';
							//return 'A2CA';		            	
						}
						
					});
					
					$(a2ca_element).sparkline(line_a2ca_values, { 
		    			composite: true, 
						type: 'line',
						height: '4em', 
						width: '8em',
						fillColor: false,
						lineColor: '#FFF',							
						chartRangeMin: 0,
						chartRangeMax: 130,
						spotColor: false,
						minSpotColor: '#ff0000',
						maxSpotColor: '#ff0000',
						tooltipSuffix: ' App',
						tooltipFormat: '{{prefix}}{{offset:offset}} : {{y}}{{suffix}}',	
						tooltipValueLookups: {		
							'offset': a2ca_daily_offset 
						 }							
						
					});
					
					
					if(responsed.A2CAMonthly[0] !== undefined) {
						var max_length = responsed.A2CAMonthly.length - 1;
						$("#a2ca_slider").slider({
			    			min: 0,
			    			max: max_length,
			    			position: max_length,
			    			markerColor: '#F0A30A',
			    			colors: 'rgba(0, 0, 0, 1)',
			    			showHint: true,
			    			change: function(value, slider) {
			    				var index	   = parseInt(value);
			    				var data_model = responsed.A2CAMonthly;
			    				var actual	   = (roundFixed(escape_keyword(data_model[index].A2CA), 0)) ? roundFixed(escape_keyword(data_model[index].A2CA), 0):'0';
			    				var achieve	   = (roundFixed(escape_keyword(data_model[index].Ach), 0)) ? roundFixed(escape_keyword(data_model[index].Ach), 0):'0';
			    				$("#a2ca_slider > .hint").html(data_model[index].Month + '<br/> ' + actual + 'App<br/>Ach.' + achieve + '%')
			    				.css({'margin-top':'-15px', 'margin-left':'-40px'});
			    				
			    			},
			    			changed: function(value, slider){
			    				if(value < max_length) $("#a2ca_slider").slider('value', max_length);
			    			}
			    	    });
						
						$("#a2ca_slider > .marker").addClass('icon-arrow-left-4 fg-darkBlue').css('font-size', '1.1em');
			    				    		
			    	}
					
					$('#legend_a2ca_bar').css('visibility', 'visible').addClass('animated fadeIn');
					
		    	}
		    	
		    	// #Whiteboard Part 2
				if(individual) {
				
					// Pending DD && Approved
			    	if(individual.Approved[0].List !== undefined) {
			    		$('#pending_dd_auth').empty().text(roundFixed(escape_keyword(individual.Approved[0].PreLoan), 0) + 'Mb').addClass('animated zoomIn');
			    		$('#approved_auth .app').empty().text(escape_keyword(individual.TotalApproved[0].TotalApproved)).addClass('animated zoomIn');
			    		$('#approved_auth .rate').empty().text(roundFixed(escape_keyword(individual.TotalApproved[0].ApprovedRate), 0) + '%').addClass('animated zoomIn');
			    	}
			    	
			    	// SB Vol
			    	if(individual.SBDrawDownOverview[0] !== undefined) {				  
			    		$('#label_sb_name_auth > small').empty().text('SB Vol. (Mb)').addClass('animated fadeIn');
			    		
			    		$('#sb_volume_auth').html(roundFixed(individual.SBDrawDownOverview[0].ActualBK, 0)).addClass('animated fadeIn');
			    		$('#sb_tartget_auth').text(roundFixed(escape_keyword(individual.SBDrawDownOverview[0].Target), 0) + 'Mb ' + ' (Ach. ' + roundFixed(escape_keyword(individual.SBDrawDownOverview[0].Achieve), 0) + '%)').addClass('animated fadeIn');
			    		$('#sb_vol_topic_auth').parent().addClass('animated fadeOut');
		
			    	} else {
			    		$('#label_sb_name_auth > small').empty().text('SB Vol. (Mb)').addClass('animated fadeIn');
			    		
			    		$('#sb_volume_auth').html(0).addClass('animated fadeIn');
			    		$('#sb_tartget_auth').text('0' + ' ' + ' (Ach. ' + '0' + '%)').addClass('animated fadeIn');
			    		$('#sb_vol_topic_auth').parent().addClass('animated fadeOut');
			    	}
			    	
			    	// A2CA Vol
			    	if(individual.A2CAOverview[0].List !== undefined) {						
			    		$('#label_a2ca_name_auth > small').empty().text('A2CA (Unit)').addClass('animated fadeIn');
					    		
			    		$('#a2ca_volume_auth').text(individual.A2CAOverview[0].ActualBK).addClass('animated fadeIn');
			    		$('#a2ca_tartget_auth').text(roundFixed(escape_keyword(individual.A2CAOverview[0].Target), 0) + 'App ' + ' (Ach. ' + roundFixed(escape_keyword(individual.A2CAOverview[0].Achieve), 0) + '%)').addClass('animated fadeIn');
			    		$('#a2ca_tartget_topic_auth').parent().addClass('animated fadeOut');
			    		
			    	}
			    	
			    	// SB Chart
			    	// Check SBDrawDownOverview is null
			    	if(individual.SBDrawDownOverview[0] === undefined) {
			    		individual.SBDrawDownOverview.push(
			    			{ 
			    				Achieve: "0.00%", 
			    				Actual: "0Mb", 
			    				ActualBK: "0", 
			    				Info: "0Mb", 
			    				List: "SB",			    				
			    				Target: "0Mb", 
			    				Year: year,
			    				Month: formatMonth[month_format][month]
			    			}
			    		);
			    	}
			    	
			    	var sbauth_index = 1;
			    	for(var i = 0; i < daysInMonth(moment().format('MM'), moment().format('YYYY')); i++)
		    		{
		    	
			    		var full_date = new Date(year, month, sbauth_index.toString());
		    			var length = $.grep(individual.SBDrawDownDairy, function(item) {
			    			return item.Day == sbauth_index.toString();
			    			
			    		}).length;
			    		
			    		if(length <= 0) {			    			
			    			var obj = $.extend({}, individual.SBDrawDownDairy[0]);
			    			obj.Day = sbauth_index.toString();
			    			obj.DD  = "0.00";
			    			obj.DayName = full_date.toString().substring(0, 3);
			    			individual.SBDrawDownDairy.push(obj);
			    		}
			    
			    		sbauth_index++;
			    		
		    		}

			    	// Day Sorting
			    	individual.SBDrawDownDairy.sort(sort_by('Day', false, parseInt));
			    	
			    	// Delete Weekend
			    	removeByAttr(individual.SBDrawDownDairy, 'DayName', 'Sat');
			    	removeByAttr(individual.SBDrawDownDairy, 'DayName', 'Sun');
			    				    	
			    	var line_values_auth  = [];
			    	var daily_offset_auth = {};			    	
			    	if(individual.SBDrawDownDairy.length >= 1) {	
			   
		        		$.each(individual.SBDrawDownDairy, function(index, value) {		        			
		        			line_values_auth.push(roundFixed(escape_keyword(checkValue(value.DD)), 1));
			        		daily_offset_auth[index] = value.Day + ' ' + value.DayName;
			        					        		
		        		});	
		        		
		        	}		
			    	
			    	// ### SB VOLUME
			    	var sb_bar_index_auth  = 1;
			    	var sb_bar_value_auth  = [];
			    	var sb_bar_offset_auth = {};
			    	if(individual.SBRegionModel.length >= 1) {
			    		var pattern 	   = new RegExp("-");
			    		var objectList	   = individual.SBRegionModel;
			    		var str_text	   = '';
			    		var str_tooltip	   = '';
			    		
			    		$.each(individual.SBRegionModel, function(index, value) {	
			    	
			    			sb_bar_value_auth.push(roundFixed(escape_keyword(checkValue(value.DD)), 1));
			    			sb_bar_offset_auth[index] = value.Name;
			    			
			    			var str_pattern 		  = pattern.test(value.Name);
			    			if(str_pattern) {
			    				var string_text		  = value.Name.split("-");
			    					str_text		  = string_text[0];
			    					str_tooltip		  = string_text[1];
			    			} else {
			    				str_text		  = value.Name;
		    					str_tooltip		  = value.Name;
			    			}
			    			
			    			$('.sb_volspanauth_' + sb_bar_index_auth).text(chartLabelTopResponsive(objectList, roundFixed(escape_keyword(checkValue(value.DD)), 0), sb_bar_index_auth, 'sb_volspanauth'));
			    			$('.sb_volspanauth_' + sb_bar_index_auth).addClass('animated fadeInDown'); //.text(roundFixed(escape_keyword(checkValue(value.DD)), 0)).addClass('animated fadeInDown');
			    			
			    			
			    			//$('.sb_volspanauth_' + sb_bar_index_auth).text(roundFixed(escape_keyword(checkValue(value.DD)), 0)).addClass('animated fadeInDown');
			    			$('.sb_vollabel_auth_' + sb_bar_index_auth).text(charLabelResponsive(objectList, str_text, sb_bar_index_auth)).addClass('animated fadeIn');
			    		
			    			$('.sb_vollabel_auth_' + sb_bar_index_auth)
			    			.tooltipster(
			    			{
			    			    animation: 'fade',
			    			    delay: 200,
			    			    theme: 'tooltipster-borderless'
			    			}).tooltipster('content', str_tooltip);
			    			
			    			sb_bar_index_auth++;		        
		        
		        		});	
			    		
			    	}
			    				    	
			    	var sbauth_element = '#balanace_values_auth';
					$(sbauth_element).sparkline(sb_bar_value_auth, {						
						type: 'bar', 				
						height: '70',
						barWidth: '12px',
						barSpacing: '8px',
						barColor: 'rgba(0,0,0,0.2)',						
						chartRangeMin: 0,
						chartRangeMax: setMaxValues(sb_bar_value_auth),
						tooltipSuffix: ' Mb',
						tooltipFormat: '<span style="color: #1B6EAE">&#9679;</span> {{prefix}}{{offset:offset}} : {{value}}{{suffix}}',						
			            tooltipValueLookups: {			            	    
			            	'offset': sb_bar_offset_auth  
			            },
			            tooltipFormatter: function (sparkline, options, fields) {
			            	return '';		            	
						}
						
					});
					
			    	$(sbauth_element).sparkline(line_values_auth, { 
			    		composite: true, 
						type: 'line',
						height: '4em', 
						width: '8em',
						fillColor: false,
						lineColor: '#FFF',
						chartRangeMin: 0,
						chartRangeMax: 100,
						spotColor: false,
						minSpotColor: '#ff0000',
						maxSpotColor: '#ff0000',
						tooltipSuffix: ' Mb',						
						tooltipFormat: '{{prefix}}{{offset:offset}} : {{y}}{{suffix}}',	
						tooltipValueLookups: {		
							'offset': daily_offset_auth 
						 }						 
					});
			    	
			    	if(individual.SBMonthly[0] !== undefined) {
			    		var max_length = individual.SBMonthly.length - 1;
			    		$("#sb_slider_auth").slider({
			    			min: 0,
			    			max: max_length,
			    			position: max_length,
			    			markerColor: '#01ABA9',
			    			colors: '#000',
			    			showHint: true,
			    			change: function(value, slider) {
			    				var index	   = parseInt(value);
			    				var data_model = individual.SBMonthly;
			    				var actual	   = (roundFixed(escape_keyword(data_model[index].DD), 0)) ? roundFixed(escape_keyword(data_model[index].DD), 0):'0';
			    				var achieve	   = (roundFixed(escape_keyword(data_model[index].Ach), 0)) ? roundFixed(escape_keyword(data_model[index].Ach), 0):'0';
			    				$("#sb_slider_auth > .hint").html(data_model[index].Month + '<br/> ' + actual + 'Mb<br/>Ach.' + achieve + '%')
			    				.css({'margin-top':'-15px'});
			    			},
			    			changed: function(value, slider){
			    				if(value < max_length) $("#sb_slider_auth").slider('value', max_length);
			    			}
			    	    });
			    		
			    		$("#sb_slider_auth > .marker").addClass('icon-arrow-left-4 fg-darkBlue').css('font-size', '1.1em');
			    		
			    	}
			    	
					$('#legend_sb_bar_auth').css('visibility', 'visible').addClass('animated fadeIn');
											
					// #### A2CA
			    	if(individual.A2CAOverview[0] === undefined) {
			    	   individual.A2CAOverview.push(
			    			{ 
			    				Achieve: "0.00%", 
			    				Actual: "0 App", 
			    				ActualBK: "0", 
			    				Info: "0 App", 
			    				List: "A2CA", 			    				
			    				Target: "0 App", 
			    				Year: year,
			    				Month: formatMonth[month_format][month]
			    			}
			    		);
			    	}	
				
					var a2ca_index_auth = 1;
			    	for(var i = 0; i < daysInMonth(moment().format('MM'), moment().format('YYYY')); i++) {
			    		
			    		var full_date = new Date(year, month, a2ca_index_auth.toString());
			    		var length = $.grep(individual.A2CADairy, function(item){
			    			return item.Day == a2ca_index_auth.toString();
			    		}).length;
			    		
			    		if(length <= 0) {
			    			var obj = $.extend({}, individual.A2CADairy[0]);
			    			obj.Day = a2ca_index_auth.toString();
			    			obj.A2CA = "0";
			    			obj.DayName = full_date.toString().substring(0, 3);
			    			individual.A2CADairy.push(obj);
			    		}
			    		
			    		a2ca_index_auth++;	
			    		
		    		}
			 
			    	// Day Sorting
			    	individual.A2CADairy.sort(sort_by('Day', false, parseInt));
			    	
			    	removeByAttr(individual.A2CADairy, 'DayName', 'Sat');
			    	removeByAttr(individual.A2CADairy, 'DayName', 'Sun');
			    	
			    	var line_a2ca_values_auth  = [];
			    	var a2ca_daily_offset_auth = {};
			    	if(individual.A2CADairy.length >= 1) {				    		
		        		$.each(individual.A2CADairy, function(index, value) {
		        			line_a2ca_values_auth.push(parseFloat(escape_keyword(checkValue(value.A2CA))));
		        			a2ca_daily_offset_auth[index] = value.Day + ' ' + value.DayName;
	
		        		});		        		
		        	}
			    	
			    	var a2ca_bar_index_auth  = 1;
			    	var a2ca_bar_value_auth  = [];
			    	var a2ca_bar_offset_auth = {};
			    	
			    	if(individual.RegionA2CAModel.length >= 1) {
			    		var pattern 	   = new RegExp("-");
			    		var objectList		 = individual.RegionA2CAModel;
			    		var str_text	   = '';
			    		var str_tooltip	   = '';
			    		$.each(individual.RegionA2CAModel, function(index, value) {		        						
			    			a2ca_bar_value_auth.push(escape_keyword(checkValue(value.A2CA)));
			    			a2ca_bar_offset_auth[index] = value.Name;
			    			
			    			var str_pattern 		  = pattern.test(value.Name);
			    			if(str_pattern) {
			    				var string_text		  = value.Name.split("-");
			    					str_text		  = string_text[0];
			    					str_tooltip		  = string_text[1];
			    			} else {
			    				str_text		  = value.Name;
		    					str_tooltip		  = value.Name;
			    			}
			    			
			    			$('.a2ca_volspanauth_' + a2ca_bar_index_auth).text(chartLabelTopResponsive(objectList, roundFixed(escape_keyword(checkValue(value.A2CA)), 0), a2ca_bar_index_auth, 'a2ca_volspanauth'));
			    			$('.a2ca_volspanauth_' + a2ca_bar_index_auth).addClass('animated fadeInDown');
			    	
			    			//$('.a2ca_volspanauth_' + a2ca_bar_index_auth).text(roundFixed(escape_keyword(checkValue(value.A2CA)), 0)).addClass('animated fadeInDown');
			    			$('.a2ca_labelauth_' + a2ca_bar_index_auth).text(charLabelResponsive(objectList, str_text, a2ca_bar_index_auth)).addClass('animated fadeIn');
			    			$('.a2ca_labelauth_' + a2ca_bar_index_auth)
			    			.tooltipster(
			    			{
			    				animation: 'fade',
			    			    delay: 200,			    			
			    			    theme: 'tooltipster-borderless'
			    			}).tooltipster('content', str_tooltip);
			    			
			    			a2ca_bar_index_auth++;	
		        
		        		});	
			    	}
			    	
			    	if(line_a2ca_values_auth.length >= 1) {
			    		
			    		var a2caauth_element = '#a2ca_values_auth';
						$(a2caauth_element).sparkline(a2ca_bar_value_auth, { 							
							type: 'bar', 				
							height: '70',
							barWidth: '12px',
							barSpacing: '8px',
							barColor: 'rgba(0,0,0,0.2)',
							chartRangeMin: 0,
							chartRangeMax: setMaxValues(a2ca_bar_value_auth),
							tooltipSuffix: ' App',
							tooltipFormat: '<span style="color: #1B6EAE">&#9679;</span> {{prefix}}{{offset:offset}} : {{value}}{{suffix}}',						
				            tooltipValueLookups: {			            	    
				            	'offset': a2ca_bar_offset_auth 
				            },				            
				            tooltipFormatter: function (sparkline, options, fields) {
				            	return '';	            	
							}
							
						});
						
						$(a2caauth_element).sparkline(line_a2ca_values_auth, { 
			    			composite: true, 
							type: 'line',
							height: '4em', 
							width: '8em',
							fillColor: false,
							lineColor: '#FFF',							
							chartRangeMin: 0,
							chartRangeMax: 130,
							spotColor: false,
							minSpotColor: '#ff0000',
							maxSpotColor: '#ff0000',
							tooltipSuffix: ' App',
							tooltipFormat: '{{prefix}}{{offset:offset}} : {{y}}{{suffix}}',	
							tooltipValueLookups: {		
								'offset': a2ca_bar_offset_auth 
							 }					
						});
						
						if(individual.A2CAMonthly[0] !== undefined) {
							var max_length = individual.A2CAMonthly.length - 1;
							$("#a2ca_slider_auth").slider({
				    			min: 0,
				    			max: max_length,
				    			position: max_length,
				    			markerColor: '#F0A30A',
				    			colors: '#000',
				    			showHint: true,
				    			change: function(value, slider) {
				    				var index	   = parseInt(value);
				    				var data_model = individual.A2CAMonthly;
				    				var actual	   = (roundFixed(escape_keyword(data_model[index].A2CA), 0)) ? roundFixed(escape_keyword(data_model[index].A2CA), 0):'0';
				    				var achieve	   = (roundFixed(escape_keyword(data_model[index].Ach), 0)) ? roundFixed(escape_keyword(data_model[index].Ach), 0):'0';
				    				$("#a2ca_slider_auth > .hint").html(data_model[index].Month + '<br/> ' + actual + 'App<br/>Ach.' + achieve + '%)')
				    				.css({'margin-top':'-15px', 'margin-left':'-40px'});
				    				
				    			},
				    			changed: function(value, slider){
				    				if(value < max_length) $("#a2ca_slider_auth").slider('value', max_length);
				    			}
				    	    });
							
							$("#a2ca_slider_auth > .marker").addClass('icon-arrow-left-4 fg-darkBlue').css('font-size', '1.1em');
				    				    		
				    	}
						
						$('#legend_a2ca_bar_auth').css('visibility', 'visible').addClass('animated fadeIn');
						
			    	}
	
				}
		    	
		    	function daysInMonth(month,year) {
		    	    return new Date(year, month, 0).getDate();
		    	}
		  
		    },	   
		    complete:function() {
		    	$('#filter_connect > i').removeClass('fg-red').addClass('fg-green');
		    	$('#sb_progress, #a2ca_progress, #sb_progress_auth, #a2ca_progress_auth').hide();
		    	$('#pending_header, #pending_divider, #ca_decision_label, #rm_onhand_label').removeClass('hidden').addClass('animated fadeIn');
		    	$.dequeue(this);
		    	
		    },
		    error: function (error) {
		 	    console.log(error);   
		    }	
		    
		});
				
	}('#balanace_values', '#a2ca_values', $('#empprofile_identity').val()));
	
	$.queue($(document), function() {	
		
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/kpi/',
	        type: "GET",
		    success: function (responsed) {	
		 
		    	// APPROVED INFOMATION
		    	if(responsed.Approved[0].Actual !== undefined) {
		    		
		    		$('#approved_topic, #approvedrate_topic').parent().addClass('animated fadeOut');
		    		
		    		var target_approved = (responsed.Approved[0].Target === undefined) ? 0 : responsed.Approved[0].Target;
		    		var apprved_app		= (responsed.Approved[0].Actual === undefined) ? 0 : escape_keyword(responsed.Approved[0].Actual);
		    		var reject_app		= (responsed.Approved[0].ActualBK === undefined) ? 0 : responsed.Approved[0].ActualBK;
		    		
		    		var total_app		= parseInt(apprved_app) + parseInt(reject_app);
		    		var approved_rate	= (parseInt(apprved_app) / total_app) * 100;
		    		
		    		drawApprovedApp = function(element_approved_volume, element_approved_rate) {
		    			
				   		 var gauge = new JustGage({
				   	        id: element_approved_volume,
				   	        value: apprved_app,
				   	        min: 0,
				   	        max: total_app,
				   	        title: "APPROVED APP",	    		       
				   	        label: 'MTH', //moment().format('MMM').toUpperCase(),	
				   	        titleFontColor: '#FFF',
				   	        labelFontColor: '#FFF',
				   	        valueFontColor: '#FFF', 
				   	        humanFriendly: true,
				   	        startAnimationTime: 10000,
				   	        refreshAnimationTime: 10000,
				   	        gaugeWidthScale: 0.4,
				   	        gaugeColor: 'rgba(0, 0, 0, 0.2)',
				   	        customSectors: [
					   	        {
					   	             color : "#A4C400",
					   	             lo: 0,
					   	             hi: 1000
					   	        }
				   	        ],
				   	        counter: false
				   	    });				   		 
				   					   		
				   		var gauge = new JustGage({
					        id: element_approved_rate,
					        value: (approved_rate === undefined || isNaN(approved_rate)) ? 0 : roundFixed(approved_rate, 0),
					        min: 0,
					        max: (target_approved === undefined) ? 0 : escape_keyword(target_approved),					        
					        title: "APPROVED RATE",	    		       
					        label: 'MTH', //moment().format('MMM').toUpperCase(),	
					        titleFontColor: '#FFF',
					        labelFontColor: '#FFF',
					        valueFontColor: '#FFF', 
					        humanFriendly: true,
					        startAnimationTime: 10000,
					        refreshAnimationTime: 10000,
					        gaugeWidthScale: 0.4,
					        gaugeColor: 'rgba(0, 0, 0, 0.2)',
					        customSectors: [
					          {
					             color : "rgba(255, 45, 25, 1)",
					             lo : 0,
					             hi : 50
					          },{
					             color : "#FA6801",
					             lo : 50,
					             hi : 75
					          }, {
					             color : "#01ABA9",
					             lo : 75,
					             hi : 100
					          }
					        ],
					        counter: false,
					        symbol: '%'
					    });
				   		
				   		$($('text[x="104.4"][y="98.58823529411765"]')[1]).find('tspan').text(target_approved);
								   		 
				   	}('ApprovedRate_App', 'ApprovedRate_Per');
				    		
		    	}
		    	
		    	// TICKET SIZE INFO
		    	$('#ticksetsize_topic, #ticksetsize_ach_topic').parent().addClass('animated fadeOut');
		    	drawTicketSize = function(element_ticketsize, element_ticketsize_ach) {
		    		
		    	  	if(responsed.AverageTicketSize[0] !== undefined) {				    	
			    		var TS_Target	= (responsed.AverageTicketSize[0].Target === undefined) ? 0 : responsed.AverageTicketSize[0].Target;
				    	var TS_Actual 	= (responsed.AverageTicketSize[0].Actual === undefined) ? 0 : responsed.AverageTicketSize[0].Actual;
			    		var TS_Achieve	= (responsed.AverageTicketSize[0].Achieve === undefined) ? 0 : responsed.AverageTicketSize[0].Achieve;
			    		
			    	} else {			    		
			    		var TS_Target	= 0 + 'MB';
				    	var TS_Actual 	= 0 + 'MB';
			    		var TS_Achieve	= 0 + 'MB';
			    		
			    	}
		    	  
			   		 var gauge = new JustGage({
			   	        id: element_ticketsize,
			   	        value: (isNaN(escape_keyword(TS_Actual))) ? 0 : (TS_Actual === undefined) ? 0 : escape_keyword(TS_Actual),
			   	        min: 0,
			   	        max: (isNaN(escape_keyword(TS_Target))) ? 0 : (TS_Target === undefined) ? 0 : escape_keyword(TS_Target),
			   	        symbol: 'Mb',
			   	        title: "TICKET SIZE",	    		       
			   	        label: 'MTH', //moment().format('MMM').toUpperCase(),	
			   	        titleFontColor: fontColor,
			   	        labelFontColor: fontColor,
			   	        valueFontColor: fontColor, 
			   	        humanFriendly: true,
			   	        startAnimationTime: 10000,
			   	        refreshAnimationTime: 10000,
			   	        gaugeWidthScale: 0.4,
			   	        gaugeColor: 'rgba(0, 0, 0, 0.2)',
			   	        customSectors: [
			   	          {
			   	            color : "#FFF",
			   	            lo : 0,
			   	            hi : 50
			   	          },{
			   	            color : "#FA6801",
			   	            lo : 50,
			   	            hi : 80
			   	          }, {
			   	            color : "#01ABA9",
			   	            lo : 80,
			   	            hi : 100
			   	          }
			   	        ],
			   	        counter: false,
			   	        pointer: false,
			   	        textRenderer: function() { return  (isNaN(escape_keyword(TS_Actual))) ? 0 : roundFixed(escape_keyword(TS_Actual), 1) + 'Mb'; }
			   	    
			   	    });
			   		 
			   		 var gauge = new JustGage({
			   	        id: element_ticketsize_ach,
			   	        value: (isNaN(escape_keyword(TS_Achieve))) ? 0 : (TS_Achieve === undefined) ? 0 : roundFixed(escape_keyword(TS_Achieve), 0),
			   	        min: 0,
			   	        max: 100,
			   	        symbol: '%',
			   	        donut: true, 
			   	        hideMinMax: true,
			   	        title: 'TICKET SIZE',
			   	        label: 'Achieve',
			   	        titleFontColor: fontColor,
			   	        labelFontColor: fontColor,
			   	        valueFontColor: fontColor, 
			   	        humanFriendly: true,
			   	        startAnimationTime: 10000,
			   	        refreshAnimationTime: 10000,
			   	        gaugeWidthScale: 0.3,
			   	        gaugeColor: 'rgba(0, 0, 0, 0.2)',
			   	        customSectors: [
			   	          {
			   	            color : "rgba(255, 45, 25, 1)",
			   	            lo : 0,
			   	            hi : 50
			   	          },{
			   	            color : "#FA6801",
			   	            lo : 50,
			   	            hi : 80
			   	          }, {
			   	            color : "#9cea4d",
			   	            lo : 80,
			   	            hi : 100
			   	          }
			   	        ],
			   	        counter: false
			   	    });
			   		 
			   	}('ticket_size', 'ticket_size_ach');
				   	
			   	// RM PRODUCTIVITY INFO
			   	onLoadRMProductivity = function(element_gauge, element_montly) {
			
			   	  	if(responsed.RMProductivity[0] !== undefined) {				   		
				   		var target	= (typeof responsed.RMProductivity[0].Target === undefined) ? 0 : responsed.RMProductivity[0].Target;
				    	var actual 	= (typeof responsed.RMProductivity[0].Actual === undefined) ? 0 : responsed.RMProductivity[0].Actual;
				    	var avg_ytd	= (typeof responsed.RMProductivity[0].YTD === undefined) ? 0 : roundFixed(responsed.RMProductivity[0].YTD, 1);
			    		var achieve	= (parseFloat(roundFixed(escape_keyword(actual), 1)) / 5) * 100;
				   		
				   	} else {
				   		var target	= 0;
				    	var actual 	= 0;
			    		var achieve	= 0;
				   	}
		    		
		    		var gauge = new JustGage({
		    	        id: element_gauge,
		    	        value: isNaN(achieve) ? 0:roundFixed(achieve, 0),
		    	        min: 0,
		    	        max: 100,
		    	        symbol: '%',
		    	        donut: true, 
		    	        titleFontColor: fontColor,
		    	        labelFontColor: false,
		    	        valueFontColor: fontColor, 
		    	        humanFriendly: true,
		    	        startAnimationTime: 10000,
		    	        refreshAnimationTime: 10000,
		    	        gaugeWidthScale: 0.3,
		    	        gaugeColor: 'rgba(0, 0, 0, 0.2)',
		    	        customSectors: [{ color : "#FFF", lo : 0, hi : 100 }],
		    	        counter: false,
		    	        hideMinMax: true,
		    	        pointer: false,
		    	        pointerOptions: {
		    	            toplength: 8,
		    	            bottomlength: -20,
		    	            bottomwidth: 6,
		    	            color: '#FFF'
		    	        }
		    	    });		    		
		  
		    		// Monthly			    	
			    	var monthly_values  = [];					    	
			    	if(responsed.RMProductivityMonthly.length >= 1) {					    		
		        		$.each(responsed.RMProductivityMonthly, function(index, value) {
		        			monthly_values.push(roundFixed(escape_keyword(checkValue(value.Actual)), 1));				   
		        		});
		        		
		        	} 
			    	
			    	if(responsed.RMProductivityMonthly.length < 11) {
		        		for(var i = monthly_values.length; i <= 11; i ++) {
		        			monthly_values.push(0);
		        		}
		        	}

			    	$('#rm_productive_vol').text(roundFixed(escape_keyword(actual), 1) + 'Mb').addClass('animated fadeIn');					    	
			    	$('#rm_productive_target > small').text('of Target 4Mb').addClass('animated fadeIn');
			    	$('#rm_productive_avg > small').text('AVG YTD ' + avg_ytd + 'Mb').addClass('animated fadeIn');
		
			    	if(actual !== '' && responsed.RMProductivityMonthly.length >= 1) {
			    		
			    		var last_index  = getIndex(formatMonth[2], responsed.RMProductivityMonthly.length) - 1;
			    		var check_index = (last_index <= 0) ? 0 : last_index;
			    		
			    		var current_val = (actual === undefined || actual == '') ? 0 : roundFixed(escape_keyword(actual), 1);
			    		var last_val	= (responsed.RMProductivityMonthly[check_index].Actual === undefined) ? 0 : roundFixed(escape_keyword(responsed.RMProductivityMonthly[check_index].Actual), 1);
			    		
			    		$('#rm_productive_compare').addClass(compareData(current_val, last_val));
			    		
			    	}
		        	
		    		$(element_montly).sparkline(monthly_values, { 
		    			type: 'bar', 
		    			barWidth: '9px',
		    			height: '40',
		    			barColor: 'white',
		    			chartRangeMin: 0,
		    			chartRangeMax: 5,
		    			//tooltipChartTitle: 'RM Productivity',
		    			//tooltipPrefix: 'Actual: ',
		    			tooltipSuffix: 'Mb',
		    			tooltipFormat: '{{prefix}}{{offset:offset}} : {{value}}{{suffix}}',						
		                tooltipValueLookups: {			            	    
		                	'offset': {
		                	    0: 'Jan',
		                	    1: 'Feb',
		                	    2: 'Mar',
		                	    3: 'Apr',
		                	    4: 'May',
		                	    5: 'Jun',
		                	    6: 'Jul',
		                	    7: 'Aug',
		                	    8: 'Sep',
		                	    9: 'Oct',
		                	    10: 'Nov',
		                	    11: 'Dec'
		    		        }  
		                }  
		    		});
		    		
		    	}('rm_productity_chart', '#rm_trend');	
			 			   	
				// BM PRODUCTIVITY INFO
		    	onLoadLBProductivity = function(element_gauge, element_montly) {
		    		
		    		if(responsed.BranchProductivity[0].Actual !== undefined) {
				 		var target	= (responsed.BranchProductivity[0].Target === undefined) ? 0 : responsed.BranchProductivity[0].Target;
				    	var actual 	= (responsed.BranchProductivity[0].Actual === undefined) ? 0 : responsed.BranchProductivity[0].Actual;
				    	var avg_ytd	= (responsed.BranchProductivity[0].YTD === undefined) ? 0 : roundFixed(responsed.BranchProductivity[0].YTD, 1);
			    		var achieve = (parseFloat(escape_keyword(actual)) / 10) * 100;	

				 	} else {
				 		var target	= 0;
				    	var actual 	= 0;
			    		var achieve = 0;	
				 	}
	    			
	    			var gauge = new JustGage({
	    		        id: element_gauge,
	    		        value: isNaN(achieve) ? 0:roundFixed(achieve, 0),
	    		        min: 0,
	    		        max: 100,
	    		        symbol: '%',
	    		        donut: true, 
	    		        titleFontColor: fontColor,
	    		        labelFontColor: false,
	    		        valueFontColor: fontColor, 
	    		        humanFriendly: true,
	    		        startAnimationTime: 10000,
	    		        refreshAnimationTime: 10000,
	    		        gaugeWidthScale: 0.3,
	    		        gaugeColor: 'rgba(0, 0, 0, 0.2)',
	    		        customSectors: [{ color : "#FFF", lo : 0, hi : 100 }],
	    		        counter: false,
	    		        hideMinMax: true,
	    		        pointer: false,
	    		        pointerOptions: {
	    		            toplength: 8,
	    		            bottomlength: -20,
	    		            bottomwidth: 6,
	    		            color: '#FFF'
	    		        }
	    		    });
	    				    			
	    			// Monthly
			    	var monthly_values  = [];					    	
			    	if(responsed.BranchProductivityMonthly.length >= 1) {	
			    		
		        		$.each(responsed.BranchProductivityMonthly, function(index, value) {
		        			monthly_values.push(roundFixed(escape_keyword(checkValue(value.Actual)), 1));				   
		        		});
		        		
		        	} 
			    	
			    	if(responsed.BranchProductivityMonthly.length < 11) {
		        		for(var i = monthly_values.length; i <= 11; i ++) {
		        			monthly_values.push(0);
		        		}
		        	}
			    	
			    	
			    	$('#lb_productive_vol').text(roundFixed(escape_keyword(actual), 1) + 'Mb').addClass('animated fadeIn');
			    	$('#lb_productive_target > small').text('of Target 10Mb').addClass('animated fadeIn');
			    	$('#lb_productive_avg > small').text('AVG YTD ' + avg_ytd + 'Mb').addClass('animated fadeIn');
			    	
			    	if(actual !== '' && responsed.BranchProductivityMonthly.length >= 1) {
			    		
			    		var last_index  = getIndex(formatMonth[2], responsed.BranchProductivityMonthly.length) - 1;
			    		var check_index = (last_index <= 0) ? 0 : last_index;
			    		
			    		var current_val = (actual === undefined || actual == '') ? 0 : roundFixed(escape_keyword(actual), 1);
			    		var last_val	= (responsed.BranchProductivityMonthly[check_index].Actual === undefined) ? 0 : roundFixed(escape_keyword(responsed.BranchProductivityMonthly[check_index].Actual), 1);

			    		$('#lb_productive_compare').addClass(compareData(current_val, last_val));
			    		
			    	}
	    			
	    			$(element_montly).sparkline(monthly_values, { 
	    				type: 'bar', 
	    				barWidth: '9px',
	    				height: '40',
	    				barColor: 'white',
	    				chartRangeMin: 0,
	    				chartRangeMax: 10,
	    				//tooltipChartTitle: 'LB Productivity',
	    				//tooltipPrefix: 'Actual: ',
	    				tooltipSuffix: 'Mb',
	    				tooltipFormat: '{{prefix}}{{offset:offset}} : {{value}}{{suffix}}',						
	    	            tooltipValueLookups: {			            	    
	    	            	'offset': {
	    	            	    0: 'Jan',
	    	            	    1: 'Feb',
	    	            	    2: 'Mar',
	    	            	    3: 'Apr',
	    	            	    4: 'May',
	    	            	    5: 'Jun',
	    	            	    6: 'Jul',
	    	            	    7: 'Aug',
	    	            	    8: 'Sep',
	    	            	    9: 'Oct',
	    	            	    10: 'Nov',
	    	            	    11: 'Dec'
	    			        }  
	    	            }  
	    			});

	    		}('lb_productity_chart', '#lb_trend');

		    },	   
		    complete:function() {		    	
		    	$.dequeue(this);
		    	
		    },
		    error: function (error) {
		 	    console.log(error);   
		    }	        
		});
		
	}());
	

	// DD Template
    (function LoadDataReportDDTemplate() {
        $.ajax({
            url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/ddtemplate/',
            type: "GET",
            success: function (responsed) {
                var PlanType 	  = responsed.PlanType;
                var PlanCountDown = responsed.PlanCountDown;
                var AppAmount 	  = responsed.AppAmount;
                var DDP_Remaining = responsed.DDP_Remaining;
                
                RenderDDTemplatePlanType(PlanType);
                RenderDDTemplatePlanCountDown(PlanCountDown, DDP_Remaining);
                RenderDDTemplateAppAmount(AppAmount);
            },
            error: function (error) {
                console.log(error);
            }
        });
    })();

    function RenderDDTemplatePlanType(result) {
        Chart.defaults.groupableBar = Chart.helpers.clone(Chart.defaults.bar);

        var helpers = Chart.helpers;
        Chart.controllers.groupableBar = Chart.controllers.bar.extend({

            calculateBarX: function (index, datasetIndex) {
                // position the bars based on the stack index
                var stackIndex = this.getMeta().stackIndex;
                return Chart.controllers.bar.prototype.calculateBarX.apply(this, [index, stackIndex]);
            },

            hideOtherStacks: function (datasetIndex) {
                var meta = this.getMeta();
                var stackIndex = meta.stackIndex;

                this.hiddens = [];
                for (var i = 0; i < datasetIndex; i++) {
                    var dsMeta = this.chart.getDatasetMeta(i);
                    if (dsMeta.stackIndex !== stackIndex) {
                        this.hiddens.push(dsMeta.hidden);
                        dsMeta.hidden = true;
                    }
                } 
            },

            unhideOtherStacks: function (datasetIndex) {
                var meta = this.getMeta();
                var stackIndex = meta.stackIndex;

                for (var i = 0; i < datasetIndex; i++) {
                    var dsMeta = this.chart.getDatasetMeta(i);
                    if (dsMeta.stackIndex !== stackIndex) {
                        dsMeta.hidden = this.hiddens.unshift();
                    }
                }
            },

            calculateBarY: function (index, datasetIndex) {
                this.hideOtherStacks(datasetIndex);
                var barY = Chart.controllers.bar.prototype.calculateBarY.apply(this, [index, datasetIndex]);
                this.unhideOtherStacks(datasetIndex);
                return barY;
            },

            calculateBarBase: function (datasetIndex, index) {
                this.hideOtherStacks(datasetIndex);
                var barBase = Chart.controllers.bar.prototype.calculateBarBase.apply(this, [datasetIndex, index]);
                this.unhideOtherStacks(datasetIndex);
                return barBase;
            },

            getBarCount: function () {
                var stacks = [];
                // put the stack index in the dataset meta
                Chart.helpers.each(this.chart.data.datasets, function (dataset, datasetIndex) {
                    var meta = this.chart.getDatasetMeta(datasetIndex);
                    if (meta.bar && this.chart.isDatasetVisible(datasetIndex)) {
                        var stackIndex = stacks.indexOf(dataset.stack);
                        if (stackIndex === -1) {
                            stackIndex = stacks.length;
                            stacks.push(dataset.stack);
                        }
                        meta.stackIndex = stackIndex;
                    }
                }, this);

                this.getMeta().stacks = stacks;
                return stacks.length;
            }

        });

        var data = {
            labels: ["E", "C", "N", "S", "I"],
            datasets: []
        };

        result.BodyType.forEach(function (item) {
            if (item.Issue == "Secure") {
                data.datasets.push({
                    label: item.Issue,
                    backgroundColor: "rgba(0, 0, 0, .2)",
                    borderColor: '#76608A',
                    data: [roundFixed(checkValue(item.E), 0), roundFixed(checkValue(item.C), 0), roundFixed(checkValue(item.N), 0), roundFixed(checkValue(item.S), 0), roundFixed(checkValue(item.I), 0)],
                    stack: 1
                });
            }
            else {
                data.datasets.push({
                    label: item.Issue,
                    backgroundColor: "#FFF",
                    borderColor: '#76608A',
                    borderWidth: 0,
                    data: [roundFixed(checkValue(item.E), 0), roundFixed(checkValue(item.C), 0), roundFixed(checkValue(item.N), 0), roundFixed(checkValue(item.S), 0), roundFixed(checkValue(item.I), 0)],
                    stack: 1
                });
            }
        });

        result.BodyScore.forEach(function (item) {
            switch (item.Score.toLowerCase()) {
                case "a":
                    data.datasets.push({
                        label: item.Score.toUpperCase(),
                        backgroundColor: "#62d185",
                        borderColor: '#FFF',
                        data: [roundFixed(checkValue(item.E), 0), roundFixed(checkValue(item.C), 0), roundFixed(checkValue(item.N), 0), roundFixed(checkValue(item.S), 0), roundFixed(checkValue(item.I), 0)],
                        stack: 2
                    });
                    break;
                case "b":
                    data.datasets.push({
                        label: item.Score.toUpperCase(),
                        backgroundColor: "#f1ed64",
                        borderColor: '#FFF',
                        data: [roundFixed(checkValue(item.E), 0), roundFixed(checkValue(item.C), 0), roundFixed(checkValue(item.N), 0), roundFixed(checkValue(item.S), 0), roundFixed(checkValue(item.I), 0)],
                        stack: 2
                    });
                    break;
                case "c":
                    data.datasets.push({
                        label: item.Score.toUpperCase(),
                        backgroundColor: "#f1ed64",
                        borderColor: '#FFF',
                        data: [roundFixed(checkValue(item.E), 0), roundFixed(checkValue(item.C), 0), roundFixed(checkValue(item.N), 0), roundFixed(checkValue(item.S), 0), roundFixed(checkValue(item.I), 0)],
                        stack: 2
                    });
                    break;
                case "d":
                    data.datasets.push({
                        label: item.Score.toUpperCase(),
                        backgroundColor: "#ed8885",
                        borderColor: '#FFF',
                        data: [roundFixed(checkValue(item.E), 0), roundFixed(checkValue(item.C), 0), roundFixed(checkValue(item.N), 0), roundFixed(checkValue(item.S), 0), roundFixed(checkValue(item.I), 0)],
                        stack: 2
                    });
                    break;
                case "e":
                    data.datasets.push({
                        label: item.Score.toUpperCase(),
                        backgroundColor: "#ed8885",
                        borderColor: '#FFF',
                        data: [roundFixed(checkValue(item.E), 0), roundFixed(checkValue(item.C), 0), roundFixed(checkValue(item.N), 0), roundFixed(checkValue(item.S), 0), roundFixed(checkValue(item.I), 0)],
                        stack: 2
                    });
                    break;
                case "z":
                    data.datasets.push({
                        label: item.Score.toUpperCase(),
                        backgroundColor: "#2ec0d2",
                        borderWidth: 0,
                        borderColor: "#1BA1E2",
                        data: [roundFixed(checkValue(item.E), 0), roundFixed(checkValue(item.C), 0), roundFixed(checkValue(item.N), 0), roundFixed(checkValue(item.S), 0), roundFixed(checkValue(item.I), 0)],
                        stack: 2
                    });
                    break;
            }
        });

        var ctx = document.getElementById("myGroupChart").getContext("2d");
        new Chart(ctx, {
            type: 'groupableBar',
            data: data,
            options: {
                legend: {
                    display: false
                },
                tooltips: {
                	titleFontSize: 12,
	                bodyFontSize: 12,
	                xPadding: 4,
	                yPadding: 4,
	                caretSize: 4,
	                cornerRadius: 0,
	                backgroundColor: 'rgba(0, 0, 0, .5)',
                	callbacks: {
                        title: function (tooltipItems, data) {
                            switch (tooltipItems[0].xLabel.toLowerCase()){
                                case "e":
                                    return "East";
                                    break;
                                case "c":
                                    return "Central";
                                    break;
                                case "n":
                                    return "North";
                                    break;
                                case "s":
                                    return "South";
                                    break;
                                case "i":
                                    return "North East";
                                    break;
                            }
                        }
                    }
                },
                scales: {
                    xAxes: [{
                    	categoryPercentage: .8,
                    	barPercentage: .65,
                    	ticks: {    
                    		display: false,
                    		fontColor: '#FFF',
                            fontSize: 8
                     	},
                    	gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        display: false,
                        ticks: {
                        	max: result.Footer[0].MaxAmt,
                            fontColor: '#FFF',
                            fontSize: 8
                        },
                        stacked: true
                    }]
                }
            }
        });
        
        if(result.Header[0] !== undefined) {
        	$.each(result.Header, function(index, value) {
        		if(value.Issue == 'Plan') {
        			$('.ddp_groupamt5').text( roundFixed(checkValue(value.E), 0) + 'Mb');
        			$('.ddp_groupamt4').text( roundFixed(checkValue(value.C), 0) + 'Mb');
        			$('.ddp_groupamt3').text( roundFixed(checkValue(value.N), 0) + 'Mb');
        			$('.ddp_groupamt2').text( roundFixed(checkValue(value.S), 0) + 'Mb');
        			$('.ddp_groupamt1').text( roundFixed(checkValue(value.I), 0) + 'Mb');
        			      			
        		} else if(value.Issue == 'Ach') {
        			$('.ddp_group5').text( roundFixed(checkValue(value.E), 0) + '%');
        			$('.ddp_group4').text( roundFixed(checkValue(value.C), 0) + '%');
        			$('.ddp_group3').text( roundFixed(checkValue(value.N), 0) + '%');
        			$('.ddp_group2').text( roundFixed(checkValue(value.S), 0) + '%');
        			$('.ddp_group1').text( roundFixed(checkValue(value.I), 0) + '%');  
        		}
        	});
        }
       
        if(result.Footer[0] !== undefined) {
        	 $('#ddp_apprValume').text(roundFixed(checkValue(result.Footer[0].FiveDay), 0))
        	 .removeClass('hide')
        	 .addClass('animated rubberBand');
        	
        	 $('#ddp_apprDetails').html(roundFixed(checkValue(result.Footer[0].AllMonth), 0) + 'Mb (Appr. ' + roundFixed(checkValue(result.Footer[0].Ach), 0) + '%)')
        	 .removeClass('hide')
        	 .addClass('animated fadeIn');
        	
        	 $('#ddpt_apprFooter').addClass('animated fadeOut');
        	
        }
        
    }
    
    function RenderDDTemplateAppAmount(result) {
    	
        var data = {
            labels: ["Process", "Re-Process", "Postpone", "Cancel"],
            datasets: []
        };

        result.Body.forEach(function (item) {
            if (item.Issue == "TotalAmt") {
                data.datasets.push({
                    label: item.Issue,
                    backgroundColor: [
                        'rgba(255, 255, 255, .3)',
                        '#FFC107', // '#f1ed64',
                        '#008A00', // '#62d185',
                        'red',     // '#ed8885'                        
                    ], 
                    data: [roundFixed(checkValue(item.Process), 0), roundFixed(checkValue(item.Re_Process), 0), roundFixed(checkValue(item.Postpone), 0), roundFixed(checkValue(item.Cancel), 0)]
                });
            }
            else {
                data.datasets.push({
                    label: item.Issue,
                    backgroundColor: [
                        'rgba(0, 0, 0, 0.2)',
                        'rgba(0, 0, 0, 0.2)',
                        'rgba(0, 0, 0, 0.2)',
                        'rgba(0, 0, 0, 0.2)'
                    ],
                	data: [roundFixed(checkValue(item.Process), 0), roundFixed(checkValue(item.Re_Process), 0), roundFixed(checkValue(item.Postpone), 0), roundFixed(checkValue(item.Cancel), 0)]
                });
            }
        });

        var dataValid 	 = []; 
        if(data.datasets[0] !== undefined) {
        	$.each(data.datasets[0].data, function(index, value) {
        		if(value > 0) dataValid.push('TRUE');
        		else dataValid.push('FALSE');
        		//if(data.datasets[0].data[index] == 0) data.datasets[0].data[index] = -0; 
        	});
        	
        }
        
        if(data.datasets[1] !== undefined) {
        	$.each(data.datasets[1].data, function(index, value) {
        		if(value > 0) dataValid.push('TRUE');
        		else dataValid.push('FALSE');
        	});
        	
       }
      
       var myBubbleChart = document.getElementById("myBubbleChart").getContext("2d");
       var chart = new Chart(myBubbleChart, {
            type: 'horizontalBar',
            data: data,
            options: {
            	 responsive: false,
                legend: {
                    display: false
                },
                tooltips: { 
                	enabled: true,
                	titleFontSize: 10,
	                bodyFontSize: 10,
                	xPadding: 4,
	                yPadding: 4,
	                caretSize: 4,
	                cornerRadius: 0,
	                backgroundColor: 'rgba(0, 0, 0, .5)',
                	callbacks: {      
                		title: function(tooltipItem, data) { return tooltipItem[0].yLabel; },
                		label: function (tooltipItem, data) { return; }
//                		label: function (tooltipItem, data) {
//                            var value = tooltipItem.xLabel;// data.datasets[0].data[tooltipItem.index];
//                            var label = data.labels[tooltipItem.index];
//
//                            if (value == 0)
//                                return null;
//                            else if (value < 0) {
//                                return Math.abs(value) + ' Mb';
//                            }
//                            else {
//                                return Math.abs(value) + ' App';
//                            }
//                        }
                    }
                },         
                scales: {
                    xAxes: [
                    {
                        display: true,
                        ticks: {
                        	min: roundFixed(checkValue(Math.abs(result.Footer.MaxAmt)), 0),
                        	max: roundFixed(checkValue(result.Footer.MaxAmt), 0),
                        	fontColor: '#803F69'                 
                        },
                        gridLines: {
                        	color: '#803F69'
                        }
                        
                    }],
                    yAxes: [{
                        display: false,
                        stacked: true,
                        categoryPercentage: .6,                    
                    }]
                },
                animation: {             
                    onComplete: function (obj) {

                        var ctx = this.chart.ctx;
                        ctx.font 		 = "9px 'Helvetica Neue', Helvetica, Arial, sans-serif";
                        ctx.textAlign 	 = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillStyle 	 = "#FFFFFF";
                        
                        if(in_array('TRUE', dataValid)) ctx.fillStyle = "#FFFFFF";
                        else ctx.fillStyle = "#803F69";
                          
                        var Footer = result.Footer;
                        this.data.datasets.forEach(function (dataset) {
                            var point = {x: 0, y: 0};
                            for (var i = 0; i < dataset.data.length; i++) {

                                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                var cValue = dataset.data[i];

                                point.y = model.y + 4.5;
                              
                                if (cValue < 0) {
                                    var AvgAmt = parseInt((Math.abs(checkValue(cValue)) / Math.abs(Footer.MaxAmt)) * 100);
                                    point.x = 15;
                                } else {
                                    var AvgApp = parseInt((Math.abs(checkValue(cValue)) / Math.abs(Footer.MaxApp)) * 100);
                                    point.x = 110;
                                }

                                ctx.fillText(Math.abs(dataset.data[i]), point.x, point.y);

                            }

                        });
                    }
                }
               
            }
        });
 
    }

    function RenderDDTemplatePlanCountDown(result, remaining) {
    	        
        var lastDaysOfMonth  = getLastDayInMonth(new Date(), 5);
        if(!in_array(moment().format('DD'), lastDaysOfMonth) && moment().format('DD') !== '01') {
        	
        	var data = {
        		labels: ["Mo", "Tu", "We", "Th", "Fr"],
                datasets: [{}]
            };
        	
        	var decimal_fix = 1;
            result.BodyDetail.forEach(function (item) {
                switch (item.Issue.toLowerCase()) {
                    case "plandd":
                        data.datasets[0] = {
                            label: "Weekly",
                            type: 'bar',
                            data: [roundFixed(checkValue(item.D5), 0), roundFixed(checkValue(item.D4), decimal_fix), roundFixed(checkValue(item.D3), decimal_fix), roundFixed(checkValue(item.D2), decimal_fix), roundFixed(checkValue(item.D1), decimal_fix)],
                            backgroundColor: '#FFF'
                        };
                    break;                        
                }
            });
            
            if(data.labels && data.labels.length > 0) {
            	var i = 1;
            	$.each(data.labels, function(index, label) {
            		$('.countdown_label' + i + ' > small').text(label);
            		i++;
            	});
            }

            var ctxLine = document.getElementById("myLineChart").getContext("2d");
            var myLineChart = new Chart(ctxLine, {
                type: 'bar',
                data: data,
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                    	enabled: true,
                    	titleFontSize: 10,
    	                bodyFontSize: 10,
    	                xPadding: 4,
    	                yPadding: 4,
    	                caretSize: 4,
    	                cornerRadius: 0,
    	                backgroundColor: 'rgba(0, 0, 0, .5)',
                        callbacks: {      
                          title: function (tooltipItems, data) {
                              return  data.datasets[tooltipItems[0].datasetIndex].label;
                          },
                          label: function (tooltipItems, data) {
                        	
                        	  var date = "" + result.BodyDetail[5]["D" + (5 - tooltipItems.index)];
                              var tooltipDate = new Date(moment().format('YYYY'), moment().format('MM') -1, date);
                           
                              var formatDate = "";
                              var cutoff = tooltipDate.toString().substring(0, 3);
                              formatDate = tooltipDate.getDate() + ' ' + cutoff;
                              
                              return formatDate + ' : ' + roundFixed(checkValue(tooltipItems.yLabel), 1) + 'Mb';
                                                       
                          	}
                        }                    
                    },
                    scales: {
                        xAxes: [{
                        	categoryPercentage: 0.60,
                        	ticks: {    
                        		display: false,
                                fontColor: '#FFF',
                                fontSize: 9
                         	},
                        	stacked: true,
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                         	ticks: {    
                         		beginAtZero: true,
                         		min: 0,
                         		max: checkValue(arrayMax(data.datasets[0].data))
                         	}, 
                            display: false,
                            type: "linear",
                            gridLines: {
                                display: false
                            }
                        }]
                    }
                }
            });
            
        } else {
        	
        	var data = {
                    labels: ["5", "4", "3", "2", "1"],
                    datasets: [{}, {}]
            };
           
            var bodytype_valid = [];
            result.BodyDetail.forEach(function (item) {
                switch (item.Issue.toLowerCase()) {
                    case "clean":
                    	bodytype_valid.push(item.Issue);
                        data.datasets[0] = {
                            label: "Clean",
                            type: 'bar',
                            data: [roundFixed(checkValue(item.D5), 0), roundFixed(checkValue(item.D4), 0), roundFixed(checkValue(item.D3), 0), roundFixed(checkValue(item.D2), 0), roundFixed(checkValue(item.D1), 0)],
                            backgroundColor: '#FFF'
                        };
                    break;
                    case "secure":
                    	bodytype_valid.push(item.Issue);
                        data.datasets[1] = {
                            label: "Secure",
                            type: 'bar',
                            data: [roundFixed(checkValue(item.D5), 0), roundFixed(checkValue(item.D4), 0), roundFixed(checkValue(item.D3), 0), roundFixed(checkValue(item.D2), 0), roundFixed(checkValue(item.D1), 0)],
                            backgroundColor: 'rgba(0, 0, 0, 0.2)'
                        };
                    break;

                }
            });

            var ctxLine = document.getElementById("myLineChart").getContext("2d");
            var myLineChart = new Chart(ctxLine, {
                type: 'bar',
                data: data,
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                    	enabled: true,
                    	titleFontSize: 10,
    	                bodyFontSize: 10,
    	                xPadding: 4,
    	                yPadding: 4,
    	                caretSize: 4,
    	                cornerRadius: 0,
    	                backgroundColor: 'rgba(0, 0, 0, .5)',
                        callbacks: {      
                          title: function (tooltipItems, data) {
                              return  data.datasets[tooltipItems[0].datasetIndex].label;
                          },
                          label: function (tooltipItems, data) {
                        	
                        	  var date = "" + result.BodyDetail[3]["D" + (5 - tooltipItems.index)];
                              var tooltipDate = new Date(date.substring(0, 4), date.substring(4, 6) - 1, date.substring(6, 8));

                              var formatDate = "";

                              switch (tooltipDate.getDay()) {
                                  case 1 :
                                      formatDate = tooltipDate.getDate() + " " + "Mon";
                                      break;
                                  case 2 :
                                      formatDate = tooltipDate.getDate() + " " + "Tue";
                                      break;
                                  case 3 :
                                      formatDate = tooltipDate.getDate() + " " + "Wed";
                                      break;
                                  case 4 :
                                      formatDate = tooltipDate.getDate() + " " + "Thu";
                                      break;
                                  case 5 :
                                      formatDate = tooltipDate.getDate() + " " + "Fri";
                                      break;
                              }

                              return formatDate + ' : ' + roundFixed(checkValue(tooltipItems.yLabel), 1) + 'Mb';
                                                       
                          	}
                        }                    
                    },
                    scales: {
                        xAxes: [{
                        	categoryPercentage: 0.60,
                        	ticks: {    
                        		display: false,
                                fontColor: '#FFF',
                                fontSize: 9
                         	},
                        	stacked: true,
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                         	ticks: {    
                         		beginAtZero: true,
                         		min: 0,
                         		max: checkValue(arrayMax(data.datasets[1].data))
                         	}, 
                            display: false,
                            type: "linear",
                            gridLines: {
                                display: false
                            }
                        }]
                    }
                }
            });
          
        }
        
        if(result.BodyPercent[0] !== undefined) {
        	$.each(result.BodyPercent, function(index, value) {
        		if(value.Issue == 'Plan') {
        			$('.ddp_amt5').text( roundFixed(checkValue(value.D5), 0) );
        			$('.ddp_amt4').text( roundFixed(checkValue(value.D4), 0) );
        			$('.ddp_amt3').text( roundFixed(checkValue(value.D3), 0) );
        			$('.ddp_amt2').text( roundFixed(checkValue(value.D2), 0) );
        			$('.ddp_amt1').text( roundFixed(checkValue(value.D1), 0) );			
        		} 
        		else if(value.Issue == 'Ach') {
        			$('.ddp_per5').text( roundFixed(checkValue(value.D5), 0) );
        			$('.ddp_per4').text( roundFixed(checkValue(value.D4), 0) );
        			$('.ddp_per3').text( roundFixed(checkValue(value.D3), 0) );
        			$('.ddp_per2').text( roundFixed(checkValue(value.D2), 0) );
        			$('.ddp_per1').text( roundFixed(checkValue(value.D1), 0) );     
        	
        		}
        	});
        }
        
        if(result.Header[0] !== undefined) {
        	$('#ddt_Remaining').text(roundFixed(checkValue(remaining), 0) + 'Mb').addClass('animated rubberBand');
        	$('#ddt_amt').text(roundFixed(checkValue(result.Header[0].Today), 0) + 'Mb').addClass('animated rubberBand');
        }
        
        if(result.Footer[0] !== undefined) {
        	
        	$('#ddt_cancelvolume').text(roundFixed(checkValue(result.Footer[0].TotalCancel), 0))
        	.removeClass('hide')
        	.addClass('animated rubberBand');
        	
        	$('#ddp_canceldetails').html('DDP ' + roundFixed(checkValue(result.Footer[0].TotalPlan), 0) + 'Mb (CC ' + roundFixed(checkValue(result.Footer[0].AchCancel), 0) + '%)')
        	.removeClass('hide')
        	.addClass('animated fadeIn');
        	
        	$('#cancel_ddpfooter').addClass('animated fadeOut');
        	
        }
    
    }
    
    function getLastDayInMonth(inputDate,splitLastDay) {
        var cDate = new Date(inputDate);

        var lastDateofMonth = new Date(cDate.getFullYear(), cDate.getMonth() + 1, 0);
        var lastDayofMonth = lastDateofMonth.getDate();
        
        var dayInMonth = [];
        for (var i = 1; i <= lastDayofMonth; i++) {
            var d = new Date(cDate.getFullYear(), cDate.getMonth(), i);
            if (d.getDay() < 6 && d.getDay() > 0) {
                dayInMonth.push(d.getDate());
            }
        }
        
        return dayInMonth.splice(dayInMonth.length-splitLastDay,splitLastDay);
	}
	
	/*
	$.queue($('span[id="balanace_values"]'), function() {	
		
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/kpi/',
	        type: "GET",
		    success: function (responsed) {	
		    		    	
		    	
		    },	   
		    complete:function() {		    	
		    	$.dequeue(this);
		    	
		    },
		    error: function (error) {
		 	    console.log(error);   
		    }	        
		});
		
	}());
	*/	
    
    function loadWhiteboard(value) {	
		
		var role_flag = null;
		var emp_code  = value;
		var role_auth = $('#emp_role').val();
		
		if(in_array(role_auth, ['adminbr_role'])) { role_flag = 1; } 
		else { role_flag = 2;}

    	var sort_by = function(field, reverse, primer) {
		    var key = primer ? 
		       function(x) {return primer(x[field])} : 
		       function(x) {return x[field]};

		    reverse = !reverse ? 1 : -1;

		    return function (a, b) {
		       return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
		    } 
    	}
    				    	
    	var removeByAttr = function(arr, attr, value){
    	    var i = arr.length;
    	    while(i--){
    	       if( arr[i] 
    	           && arr[i].hasOwnProperty(attr) 
    	           && (arguments.length > 2 && arr[i][attr] === value ) ){ 

    	           arr.splice(i,1);

    	       }
    	    }
    	    return arr;
    	}
		 
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/whiteboard/' + emp_code + '/' + role_flag,
	        type: "GET",
	        beforeSend: function() {
	        	$('#sb_progress_auth, #a2ca_progress_auth').show();
	        	
	        	var instances = $.tooltipster.instances();
			
				if(instances) {
					$.each(instances, function(i, instance){
					    instance.close();
					})
				}
	        	
	        	var index = 1;
	        	for(i = 0; i < 6; i++) {
	    
	        		$('.sb_volspanauth_' + index).text('');
	        		$('.a2ca_volspanauth_' + index).text('');
	        		
	        		$('.sb_vollabel_auth_' + index + ', .a2ca_labelauth_' + index).text('');
	        		
	        		index++;
	        	}
	        	
	        	var instances = $.tooltipster.instancesLatest();
	        	
	        	$('#pending_dd_auth').text('0Mb');
	        	$('#sb_volume_auth').html('0');
	        	$('#sb_tartget_auth').text('0Mb  (Ach. 0%)'); 
	        	$('#a2ca_volume_auth').text('0');
	        	$('#a2ca_tartget_auth').text('0App  (Ach. 0%)'); 
	        	$('#approved_auth > app').text('0');
	        	$('#approved_auth > rate').text('0%');
	        	
	        	$('.sb_volspanauth_1').css({ 'margin-left': '28px', 'margin-top': '0px' });
				$('.sb_volspanauth_2').css({ 'margin-left': '2px', 'margin-top': '0px' });
				$('.sb_volspanauth_3').css({ 'margin-left': '0px', 'margin-top': '0px' });
				$('.sb_volspanauth_4').css({ 'margin-left': '0px', 'margin-top': '0px' });
				$('.sb_volspanauth_5').css({ 'margin-left': '0px', 'margin-top': '0px' });
				$('.sb_volspanauth_6').css({ 'margin-left': '0px', 'margin-top': '0px' });
				
				$('.a2ca_volspanauth_1').css({ 'margin-left': '23px', 'margin-top': '0px' });
				$('.a2ca_volspanauth_2' ).css({ 'margin-left': '2px', 'margin-top': '0px' });
				$('.a2ca_volspanauth_3' ).css({ 'margin-left': '0px', 'margin-top': '0px' });
				$('.a2ca_volspanauth_4' ).css({ 'margin-left': '0px', 'margin-top': '0px' });
				$('.a2ca_volspanauth_5' ).css({ 'margin-left': '0px', 'margin-top': '0px' });
				$('.a2ca_volspanauth_6').css({ 'margin-left': '0px', 'margin-top': '0px' });
				
				$('.sb_vollabel_auth_1').css({ 'margin-left': '27px', 'margin-top': '3px' });
				$('.sb_vollabel_auth_2').css({ 'margin-left': '2px', 'margin-top': '3px' });
				$('.sb_vollabel_auth_3').css({ 'margin-left': '0px', 'margin-top': '3px' });
				$('.sb_vollabel_auth_4').css({ 'margin-left': '1px', 'margin-top': '3px' });
				$('.sb_vollabel_auth_5').css({ 'margin-left': '1px', 'margin-top': '3px' });
				$('.sb_vollabel_auth_6').css({ 'margin-left': '1px', 'margin-top': '3px' });
				
				$('.a2ca_labelauth_1').css({ 'margin-left': '24px', 'margin-top': '3px' });
				$('.a2ca_labelauth_2' ).css({ 'margin-left': '2px', 'margin-top': '3px' });
				$('.a2ca_labelauth_3' ).css({ 'margin-left': '0px', 'margin-top': '3px' });
				$('.a2ca_labelauth_4' ).css({ 'margin-left': '1px', 'margin-top': '3px' });
				$('.a2ca_labelauth_5' ).css({ 'margin-left': '1px', 'margin-top': '3px' });
				$('.a2ca_labelauth_6' ).css({ 'margin-left': '1px', 'margin-top': '3px' });
	        	
				$('#filter_connect > i').removeClass('fg-green').addClass('fg-red');
				
				$("#sb_slider_auth, #a2ca_slider_auth").slider( "destroy" );
							
	        },
		    success: function (resp) {	
		    	var individual = (resp[1]) ? resp[1]:null;
		
		    	// #Whiteboard Part 2
				if(individual) {
					
					// Pending DD && Approved
			    	if(individual.Approved[0].List !== undefined) {
			    		$('#pending_dd_auth').empty().text(roundFixed(escape_keyword(individual.Approved[0].PreLoan), 0) + 'Mb').addClass('animated zoomIn');
			    		$('#approved_auth .app').empty().text(escape_keyword(individual.TotalApproved[0].TotalApproved)).addClass('animated zoomIn');
			    		$('#approved_auth .rate').empty().text(roundFixed(escape_keyword(individual.TotalApproved[0].ApprovedRate), 0) + '%').addClass('animated zoomIn');
			    	}
			    	
			    	// SB Vol
			    	if(individual.SBDrawDownOverview[0] !== undefined) {				  
			    		$('#label_sb_name_auth > small').empty().text('SB Vol. (Mb)').addClass('animated fadeIn');
			    		
			    		$('#sb_volume_auth').html(roundFixed(individual.SBDrawDownOverview[0].ActualBK, 0)).addClass('animated fadeIn');
			    		$('#sb_tartget_auth').text(roundFixed(escape_keyword(individual.SBDrawDownOverview[0].Target), 0) + 'Mb ' + ' (Ach. ' + roundFixed(escape_keyword(individual.SBDrawDownOverview[0].Achieve), 0) + '%)').addClass('animated fadeIn');
			    		$('#sb_vol_topic_auth').parent().addClass('animated fadeOut');
		
			    	} else {
			    		$('#label_sb_name_auth > small').empty().text('SB Vol. (Mb)').addClass('animated fadeIn');
			    		
			    		$('#sb_volume_auth').html('0').addClass('animated fadeIn');
			    		$('#sb_tartget_auth').text('0' + ' ' + ' (Ach. ' + '0' + '%)').addClass('animated fadeIn');
			    		$('#sb_vol_topic_auth').parent().addClass('animated fadeOut');
			    	}
			    	
			    	// A2CA Vol
			    	if(individual.A2CAOverview[0].List !== undefined) {						
			    		$('#label_a2ca_name_auth > small').empty().text('A2CA (Unit)').addClass('animated fadeIn');
					    		
			    		$('#a2ca_volume_auth').text(individual.A2CAOverview[0].ActualBK).addClass('animated fadeIn');
			    		$('#a2ca_tartget_auth').text(roundFixed(escape_keyword(individual.A2CAOverview[0].Target), 0) + 'App ' + ' (Ach. ' + roundFixed(escape_keyword(individual.A2CAOverview[0].Achieve), 0) + '%)').addClass('animated fadeIn');
			    		$('#a2ca_tartget_topic_auth').parent().addClass('animated fadeOut');
			    		
			    	}
			    	
			    	// SB Chart
			    	// Check SBDrawDownOverview is null
			    	if(individual.SBDrawDownOverview[0] === undefined) {
			    		individual.SBDrawDownOverview.push(
			    			{ 
			    				Achieve: "0.00%", 
			    				Actual: "0Mb", 
			    				ActualBK: "0", 
			    				Info: "0Mb", 
			    				List: "SB",			    				
			    				Target: "0Mb", 
			    				Year: year,
			    				Month: formatMonth[month_format][month]
			    			}
			    		);
			    	}
			    	
			    	var sbauth_index = 1;
			    	for(var i = 0; i < daysInMonth(moment().format('MM'), moment().format('YYYY')); i++)
		    		{
		    	
			    		var full_date = new Date(year, month, sbauth_index.toString());
		    			var length = $.grep(individual.SBDrawDownDairy, function(item) {
			    			return item.Day == sbauth_index.toString();
			    			
			    		}).length;
			    		
			    		if(length <= 0) {			    			
			    			var obj = $.extend({}, individual.SBDrawDownDairy[0]);
			    			obj.Day = sbauth_index.toString();
			    			obj.DD  = "0.00";
			    			obj.DayName = full_date.toString().substring(0, 3);
			    			individual.SBDrawDownDairy.push(obj);
			    		}
			    
			    		sbauth_index++;
			    		
		    		}

			    	// Day Sorting
			    	individual.SBDrawDownDairy.sort(sort_by('Day', false, parseInt));
			    	
			    	// Delete Weekend
			    	removeByAttr(individual.SBDrawDownDairy, 'DayName', 'Sat');
			    	removeByAttr(individual.SBDrawDownDairy, 'DayName', 'Sun');
			    				    	
			    	var line_values_auth  = [];
			    	var daily_offset_auth = {};			    	
			    	if(individual.SBDrawDownDairy.length >= 1) {	
			   
		        		$.each(individual.SBDrawDownDairy, function(index, value) {		        			
		        			line_values_auth.push(roundFixed(escape_keyword(checkValue(value.DD)), 1));
			        		daily_offset_auth[index] = value.Day + ' ' + value.DayName;
			        					        		
		        		});	
		        		
		        	}		
			    	
			    	// ### SB VOLUME
			    	var sb_bar_index_auth  = 1;
			    	var sb_bar_value_auth  = [];
			    	var sb_bar_offset_auth = {};
			    	if(individual.SBRegionModel.length >= 1) {
			    		var pattern 	   = new RegExp("-");
			    		var objectList	   = individual.SBRegionModel;
			    		var str_text	   = '';
			    		var str_tooltip	   = '';
		
			    		$.each(individual.SBRegionModel, function(index, value) {	

			    			sb_bar_value_auth.push(roundFixed(escape_keyword(checkValue(value.DD)), 1));
			    			sb_bar_offset_auth[index] = value.Name;
			    			
			    			var str_pattern 		  = pattern.test(value.Name);
			    			if(str_pattern) {
			    				var string_text		  = value.Name.split("-");
			    					str_text		  = string_text[0];
			    					str_tooltip		  = string_text[1];
			    			} else {
			    				str_text		  = value.Name;
		    					str_tooltip		  = value.Name;
			    			}
			    			
			    			$('.sb_volspanauth_' + sb_bar_index_auth).text(chartLabelTopResponsive(objectList, roundFixed(escape_keyword(checkValue(value.DD)), 0), sb_bar_index_auth, 'sb_volspanauth'));
			    			$('.sb_volspanauth_' + sb_bar_index_auth).addClass('animated fadeInDown'); //.text(roundFixed(escape_keyword(checkValue(value.DD)), 0)).addClass('animated fadeInDown');
			    			
			    			$('.sb_vollabel_auth_' + sb_bar_index_auth).text(charLabelResponsive(objectList, str_text, sb_bar_index_auth)).addClass('animated fadeIn');
			    			$('.sb_vollabel_auth_' + sb_bar_index_auth)
			    			.tooltipster(
			    			{
			    			    animation: 'fade',
			    			    delay: 200,
			    			    theme: 'tooltipster-borderless'
			    			}).tooltipster('content', str_tooltip);
			    			
			    			sb_bar_index_auth++;		        
		        
		        		});	
			    		
			    		
			    	}
			    			    	
			    	var sbauth_element = '#balanace_values_auth';			    	
					$(sbauth_element).sparkline(sb_bar_value_auth, {						
						type: 'bar', 				
						height: '70',
						barWidth: chartBarWidthResponsive(sb_bar_value_auth),
						barSpacing: chartBarSpectResponsive(sb_bar_value_auth),
						barColor: 'rgba(0,0,0,0.2)',						
						chartRangeMin: 0,
						chartRangeMax: setMaxValues(sb_bar_value_auth),
						tooltipSuffix: ' Mb',
						tooltipFormat: '<span style="color: #1B6EAE">&#9679;</span> {{prefix}}{{offset:offset}} : {{value}}{{suffix}}',						
			            tooltipValueLookups: {			            	    
			            	'offset': sb_bar_offset_auth  
			            },
			            tooltipFormatter: function (sparkline, options, fields) {
			            	return '';		            	
						}
						
					});
					
					var sb_config_auth = chartFrequencyResponsive(sb_bar_value_auth);	
					setTimeout(function() {
						$(sbauth_element).sparkline(line_values_auth, { 
				    		composite: true, 
							type: 'line',
							height: sb_config_auth[0], 
							width: '8em',
							fillColor: false,
							lineColor: '#FFF',
							chartRangeMin: 0,
							chartRangeMax: sb_config_auth[1],
							spotColor: false,
							minSpotColor: '#ff0000',
							maxSpotColor: '#ff0000',
							tooltipSuffix: ' Mb',						
							tooltipFormat: '{{prefix}}{{offset:offset}} : {{y}}{{suffix}}',	
							tooltipValueLookups: {		
								'offset': daily_offset_auth 
							 }						 
						});
						
					}, 500)
			    	
			    	
			    	if(individual.SBMonthly[0] !== undefined) {
			    		var max_length = individual.SBMonthly.length - 1;
			    		$("#sb_slider_auth").slider({
			    			min: 0,
			    			max: max_length,
			    			position: max_length,
			    			markerColor: '#01ABA9',
			    			colors: '#000',
			    			showHint: true,
			    			change: function(value, slider) {
			    				var index	   = parseInt(value);
			    				var data_model = individual.SBMonthly;
			    				var actual	   = (roundFixed(escape_keyword(data_model[index].DD), 0)) ? roundFixed(escape_keyword(data_model[index].DD), 0):'0';
			    				var achieve	   = (roundFixed(escape_keyword(data_model[index].Ach), 0)) ? roundFixed(escape_keyword(data_model[index].Ach), 0):'0';
			    				$("#sb_slider_auth > .hint").html(data_model[index].Month + '<br/> ' + actual + 'Mb<br/>Ach.' + achieve + '%')
			    				.css({'margin-top':'-15px'});
			    			},
			    			changed: function(value, slider){
			    				if(value < max_length) $("#sb_slider_auth").slider('value', max_length);
			    			}
			    	    });
			    		
			    		$("#sb_slider_auth > .marker").addClass('icon-arrow-left-4 fg-darkBlue').css('font-size', '1.1em');
			    				    		
			    	}
			    	
					$('#legend_sb_bar_auth').css('visibility', 'visible').addClass('animated fadeIn');
											
					// #### A2CA
			    	if(individual.A2CAOverview[0] === undefined) {
			    	   individual.A2CAOverview.push(
			    			{ 
			    				Achieve: "0.00%", 
			    				Actual: "0 App", 
			    				ActualBK: "0", 
			    				Info: "0 App", 
			    				List: "A2CA", 			    				
			    				Target: "0 App", 
			    				Year: year,
			    				Month: formatMonth[month_format][month]
			    			}
			    		);
			    	}	
				
					var a2ca_index_auth = 1;
			    	for(var i = 0; i < daysInMonth(moment().format('MM'), moment().format('YYYY')); i++) {
			    		
			    		var full_date = new Date(year, month, a2ca_index_auth.toString());
			    		var length = $.grep(individual.A2CADairy, function(item){
			    			return item.Day == a2ca_index_auth.toString();
			    		}).length;
			    		
			    		if(length <= 0) {
			    			var obj = $.extend({}, individual.A2CADairy[0]);
			    			obj.Day = a2ca_index_auth.toString();
			    			obj.A2CA = "0";
			    			obj.DayName = full_date.toString().substring(0, 3);
			    			individual.A2CADairy.push(obj);
			    		}
			    		
			    		a2ca_index_auth++;	
			    		
		    		}
			 
			    	// Day Sorting
			    	individual.A2CADairy.sort(sort_by('Day', false, parseInt));
			    	
			    	removeByAttr(individual.A2CADairy, 'DayName', 'Sat');
			    	removeByAttr(individual.A2CADairy, 'DayName', 'Sun');
			    	
			    	var line_a2ca_values_auth  = [];
			    	var a2ca_daily_offset_auth = {};
			    	if(individual.A2CADairy.length >= 1) {				    		
		        		$.each(individual.A2CADairy, function(index, value) {
		        			line_a2ca_values_auth.push(parseFloat(escape_keyword(checkValue(value.A2CA))));
		        			a2ca_daily_offset_auth[index] = value.Day + ' ' + value.DayName;
	
		        		});		        		
		        	}
			    	
			    	var a2ca_bar_index_auth  = 1;
			    	var a2ca_bar_value_auth  = [];
			    	var a2ca_bar_offset_auth = {};
			    	
			    	if(individual.RegionA2CAModel.length >= 1) {
			    		var pattern 	   = new RegExp("-");
			    		var objectList		 = individual.RegionA2CAModel;
			    		var str_text	   = '';
			    		var str_tooltip	   = '';
			    		$.each(individual.RegionA2CAModel, function(index, value) {		        						
			    			a2ca_bar_value_auth.push(escape_keyword(checkValue(value.A2CA)));
			    			a2ca_bar_offset_auth[index] = value.Name;
			    			
			    			var str_pattern 		  = pattern.test(value.Name);
			    			if(str_pattern) {
			    				var string_text		  = value.Name.split("-");
			    					str_text		  = string_text[0];
			    					str_tooltip		  = string_text[1];
			    			} else {
			    				str_text		  = value.Name;
		    					str_tooltip		  = value.Name;
			    			}
			    			
			    			$('.a2ca_volspanauth_' + a2ca_bar_index_auth).text(chartLabelTopResponsive(objectList, roundFixed(escape_keyword(checkValue(value.A2CA)), 0), a2ca_bar_index_auth, 'a2ca_volspanauth'));
			    			$('.a2ca_volspanauth_' + a2ca_bar_index_auth).addClass('animated fadeInDown'); 
			    							
			    			//$('.a2ca_volspanauth_' + a2ca_bar_index_auth).text(chartLabelTopResponsive(objectList, roundFixed(escape_keyword(checkValue(value.A2CA)), 0), a2ca_bar_index_auth)).addClass('animated fadeInDown');
			    			$('.a2ca_labelauth_' + a2ca_bar_index_auth).text(charLabelResponsive(objectList, str_text, a2ca_bar_index_auth)).addClass('animated fadeIn');
			    			$('.a2ca_labelauth_' + a2ca_bar_index_auth)
			    			.tooltipster(
			    			{
			    				animation: 'fade',
			    			    delay: 200,			    			
			    			    theme: 'tooltipster-borderless'
			    			}).tooltipster('content', str_tooltip);
			    			//.addClass('tooltip-right').attr('data-tooltip', value.Name);
			    			a2ca_bar_index_auth++;	
		        
		        		});	
			    	}
			    	
			    	if(line_a2ca_values_auth.length >= 1) {
			    		
			    		var a2caauth_element = '#a2ca_values_auth';
						$(a2caauth_element).sparkline(a2ca_bar_value_auth, { 							
							type: 'bar', 				
							height: '70',
							barWidth: chartBarWidthResponsive(a2ca_bar_value_auth),
							barSpacing: chartBarSpectResponsive(a2ca_bar_value_auth),
							barColor: 'rgba(0,0,0,0.2)',
							chartRangeMin: 0,
							chartRangeMax: setMaxValues(a2ca_bar_value_auth),
							tooltipSuffix: ' App',
							tooltipFormat: '<span style="color: #1B6EAE">&#9679;</span> {{prefix}}{{offset:offset}} : {{value}}{{suffix}}',						
				            tooltipValueLookups: {			            	    
				            	'offset': a2ca_bar_offset_auth 
				            },				            
				            tooltipFormatter: function (sparkline, options, fields) {
				            	return '';	            	
							}
							
						});
						
						var a2ca_config_auth = chartFrequencyResponsive(a2ca_bar_value_auth);
						setTimeout(function() {
							$(a2caauth_element).sparkline(line_a2ca_values_auth, { 
				    			composite: true, 
								type: 'line',
								height: a2ca_config_auth[0], 
								width: '8em',
								fillColor: false,
								lineColor: '#FFF',							
								chartRangeMin: 0,
								chartRangeMax: a2ca_config_auth[1],
								spotColor: false,
								minSpotColor: '#ff0000',
								maxSpotColor: '#ff0000',
								tooltipSuffix: ' App',
								tooltipFormat: '{{prefix}}{{offset:offset}} : {{y}}{{suffix}}',	
								tooltipValueLookups: {		
									'offset': a2ca_daily_offset_auth 
								 }					
							});
							
						}, 500)
						
						
						if(individual.A2CAMonthly[0] !== undefined) {
							var max_length = individual.A2CAMonthly.length - 1;
							$("#a2ca_slider_auth").slider({
				    			min: 0,
				    			max: max_length,
				    			position: max_length,
				    			markerColor: '#F0A30A',
				    			colors: '#000',
				    			showHint: true,
				    			change: function(value, slider) {
				    				var index	   = parseInt(value);
				    				var data_model = individual.A2CAMonthly;
				    				var actual	   = (roundFixed(escape_keyword(data_model[index].A2CA), 0)) ? roundFixed(escape_keyword(data_model[index].A2CA), 0):'0';
				    				var achieve	   = (roundFixed(escape_keyword(data_model[index].Ach), 0)) ? roundFixed(escape_keyword(data_model[index].Ach), 0):'0';
				    				$("#a2ca_slider_auth > .hint").html(data_model[index].Month + '<br/> ' + actual + 'App<br/>Ach.' + achieve + '%)')
				    				.css({'margin-top':'-15px', 'margin-left':'-40px'});
				    				
				    			},
				    			changed: function(value, slider){
				    				if(value < max_length) $("#a2ca_slider_auth").slider('value', max_length);
				    			}
				    	    });
							
							$("#a2ca_slider_auth > .marker").addClass('icon-arrow-left-4 fg-darkBlue').css('font-size', '1.1em');
				    				    		
				    	}
						
						$('#legend_a2ca_bar_auth').css('visibility', 'visible').addClass('animated fadeIn');
						$('#filter_connect > i').removeClass('fg-red').addClass('fg-green');
						
			    	}
	
				}
		    	
		    	function daysInMonth(month,year) {
		    	    return new Date(year, month, 0).getDate();
		    	}
		  
		    },	   
		    complete:function() {
		    	$('#sb_progress_auth, #a2ca_progress_auth').hide();		 
		    },
		    timeout: 500000,
		    error: function (error) {
		 	    console.log(error);   
		    }	        
		});

	}
    
	$.queue($('span[id="app_progress_container"]'), function() {	
		var empcode = $('#empprofile_identity').val();
		var sort_by = function(field, reverse, primer) {
		    var key = primer ? 
		       function(x) {return primer(x[field])} : 
		       function(x) {return x[field]};

		    reverse = !reverse ? 1 : -1;

		    return function (a, b) {
		       return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
		    } 
    	}
		
		var removeByAttr = function(arr, attr, value){
    	    var i = arr.length;
    	    while(i--){
    	       if( arr[i] 
    	           && arr[i].hasOwnProperty(attr) 
    	           && (arguments.length > 2 && arr[i][attr] === value ) ){ 

    	           arr.splice(i,1);

    	       }
    	    }
    	    return arr;
    	}
		
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/appprogress/' + empcode,
	        type: "GET",
		    success: function (responsed) {	
		    	
		    	// Part 1: Application Progress
		    	var interest_per = (responsed.ApprogressCurrentMonth[0].Interest) ? roundFixed(responsed.ApprogressCurrentMonth[0].Interest, 0):'';
		    	var highpro_per  = (responsed.ApprogressCurrentMonth[0].High) ? roundFixed(responsed.ApprogressCurrentMonth[0].High, 0):'';
		    	
		    	$('#icon_pci, #icon_apppro').removeClass('hide').addClass('paddingTop10 animated fadeIn');
		    	$('#pci_label, #apppro_label').css('margin-top', '0px');
		    	$('.interest_per').text(interest_per + '%').addClass('animated fadeIn');
		    	$('.hightpro_per').text(highpro_per + '%').addClass('animated fadeIn');
		    	
		    	var field_visit  = (responsed.ApprogressYearToDate[0].FieldVisit) ? roundFixed(responsed.ApprogressYearToDate[0].FieldVisit, 0):'';
		    	var field_refer  = (responsed.ApprogressYearToDate[0].Refer) ? roundFixed(responsed.ApprogressYearToDate[0].Refer, 1):'';
		    	var field_total  = (responsed.ApprogressYearToDate[0].Total) ? roundFixed(responsed.ApprogressYearToDate[0].Total, 0):0;
		    			    	
		    	$('#field_visit').text('FV ' + field_visit + '% & REFER ' + field_refer + '%').addClass('animated fadeInDown');
		    	//$('#field_refer').text('Referral Share ' + field_refer + '%').addClass('animated fadeInDown');
		    	$('#field_total').text(currencyFormat(field_total, 0)).addClass('animated fadeInLeft');
		    	
		    	var field_target  = (responsed.ApprogressProspectList[0].Target) ? roundFixed(responsed.ApprogressProspectList[0].Target, 0):'';
		    	var field_achieve = (responsed.ApprogressProspectList[0].Achieve) ? roundFixed(responsed.ApprogressProspectList[0].Achieve, 0):'';
		    	var field_actual  = (responsed.ApprogressProspectList[0].Actual) ? roundFixed(responsed.ApprogressProspectList[0].Actual, 0):0;
		    	
		    	$('#field_target').text('FV ' + field_target + ' (Ach. ' + field_achieve + '%)').addClass('animated fadeInDown');
		    	//$('#field_achieve').text('Acheive ' + field_achieve + '%').addClass('animated fadeInDown');
		    	$('#field_actual').text(currencyFormat(field_actual, 0)).addClass('animated fadeInRight');
		    	
		    	// Part 2: NCB Consent
		    	var ncbdata_consent = (responsed.TotalNCBData[0].TotalNCBConsent) ? roundFixed(responsed.TotalNCBData[0].TotalNCBConsent, 0):0;
		    	var ncbdata_operval = (responsed.TotalNCBData[0].TotalOperReturn) ? roundFixed(responsed.TotalNCBData[0].TotalOperReturn, 0):0;
		    	var ncbdata_operach = (responsed.TotalNCBData[0].TotalOperReturnAch) ? roundFixed(responsed.TotalNCBData[0].TotalOperReturnAch, 0):0;
		    	
		    	$('.ncb_labels').removeClass('hide').addClass('animated fadeIn');
		    	$('#ncbconsent_total').css({'border-left': '1px solid #FFF'}).text(ncbdata_consent).addClass('animated fadeIn bg-orange');
		    	$('#ncbconsent_incompleted').text('Oper. Return ' + ncbdata_operval + ' (' + ncbdata_operach + '%)').addClass('animated fadeIn');
		    	
		    	// Part 3: Reconcile
		    	var reconcile_incompleted = (responsed.ReceivedDocData[0].Incomplete) ? roundFixed(responsed.ReceivedDocData[0].Incomplete, 0):0;
		    	var reconcile_cprated 	  = (responsed.ReceivedDocData[0].Incompleted) ? roundFixed(responsed.ReceivedDocData[0].Incompleted, 0):0;
		    	var reconcile_receivedDoc = (responsed.ReceivedDocData[0].ReceivedDoc) ? roundFixed(responsed.ReceivedDocData[0].ReceivedDoc, 0):0;
		    	
		    	// NCB Aging Data
		    	var ncb_aging_actual = [];
		    	var ncb_aging_total	 = [];
		    	var ncb_aging_data	 = (responsed.NCBAgingData[0]) ? responsed.NCBAgingData:[];
		    	if(ncb_aging_data.length > 0) {
		    		$.each(ncb_aging_data, function(index, value) {
		    			ncb_aging_total.push(value.TotalNCBAging);
			    		ncb_aging_actual.push(value.NCBAging);
		    		});
		    	} 
		    	
		    	if(ncb_aging_data.length < 5) {		    		
		    		for(var i=ncb_aging_total.length; i <= 4; i++) {
		    			ncb_aging_total.push(0);
			    		ncb_aging_actual.push(0);
		    		}
		    	}
		 
		    	var ncb_aging_label = ['1D-3D', '4D-5D', '6D-7D', '8D-9D', '10D+'];
		    	$('#ncb_consent_chart').sparkline(ncb_aging_total, { 							
		    		type: 'bar', 				
		    		height: '50',
					barWidth: '12px',
					barSpacing: '8px',
					zeroColor: '#F0A30A',
		    		barColor: 'rgba(0,0,0,0.2)',
		    		tooltipSuffix: 'Set',
		    		tooltipFormat: '{{offset:offset}} : {{value}} {{suffix}}',	
					tooltipValueLookups: {		
						'offset': ncb_aging_label 
					 }	
		    	});
		    	
		    	// Reconcile Chart
		    	var rowno		   = 1;
		    	var index 		   = 1;
		    	var reconcile_data = (responsed.ReceivedDocListData) ? responsed.ReceivedDocListData:0;
		    	for(var i = 0; i < reconcile_data.length; i++) { 
		    		var full_date  = new Date(year, month, rowno.toString());
		    		reconcile_data[i].DayName = full_date.toString().substring(0, 3); 
		    		rowno++;
		    	}
		    	
		    	/*	    	
		    	for(var i = 0; i < daysInMonth(moment().format('MM'), moment().format('YYYY')); i++) {
	    	
		    		var full_date 	   = new Date(year, month, index.toString());
	    			var length = $.grep(reconcile_data, function(item) {
		    			return item.Day == index.toString();
		    			
		    		}).length;
		    		
		    		if(length <= 0) {			    			
		    			var obj = $.extend({}, reconcile_data[0]);
		    			obj.Day 			 = index.toString();
		    			obj.NewReceivedDoc   = 0;
		    			obj.TotalA2CA 		 = 0;
		    			obj.TotalReceivedDoc = 0;
		    			obj.DayName 		 = full_date.toString().substring(0, 3);
		    			responsed.ReceivedDocListData.push(obj);
		    		}
		    
		    		index++;
		    		
	    		}
		        */
		    	
		    	reconcile_data.sort(sort_by('Day', false, parseInt));
		    	removeByAttr(reconcile_data, 'DayName', 'Sat');
		    	removeByAttr(reconcile_data, 'DayName', 'Sun');
		    	
		    	var reconcile_bar_days	 = []; 
		    	var reconcile_bar_newapp = [];
		    	var reconcile_bar_total	 = [];
		    	var reconcile_bar_a2ca	 = [];
		    	
		    	for(var i = 0; i < reconcile_data.length; i++) { 
		    		var sendnew_app  = (reconcile_data[i].NewReceivedDoc) ? parseInt(reconcile_data[i].NewReceivedDoc):0;
		    		var total_a2ca   = (reconcile_data[i].TotalA2CA) ?  parseInt(reconcile_data[i].TotalA2CA):0;
		    		var total_reconcile = (reconcile_data[i].TotalReceivedDoc) ?  parseInt(reconcile_data[i].TotalReceivedDoc):0;
		    				    	
		    		var day_name = new Date(year, month, reconcile_data[i].Day);
		    		reconcile_bar_days.push(reconcile_data[i].Day + ' ' + day_name.toString().substring(0, 3));
		    		reconcile_bar_newapp.push(sendnew_app);
		    		reconcile_bar_total.push(total_reconcile);
		    		reconcile_bar_a2ca.push(total_a2ca);
		    		
		    	}
		    	
		    	var daily_offset 		 = {}		    	
		    	if(reconcile_bar_total.length >= 1) { $.each(reconcile_data, function(index, value) { daily_offset[index] = value.Day + ' ' + value.DayName; }); }
		    	
		    	// Reconcile Doc		    	
		    	var chartjs_data = {
		           labels: reconcile_bar_days,
		           datasets: [{}, {}]
		    	};
		    	
		    	chartjs_data.datasets[0] = {
	                label: "New",
	                type: 'line',
	                data: reconcile_bar_newapp,
	                backgroundColor: 'rgba(75, 192, 192, 0.5)',
	                pointBackgroundColor: 'rgba(75, 192, 192, 0)',
	                pointBorderWidth: 0, 
	                pointRadius: 0,
	            };
	    		
		    	chartjs_data.datasets[1] = {
		    		label: "Accumulate",
	                type: 'line',
	                data: reconcile_bar_total,
	                backgroundColor: 'rgba(255, 255, 255, 0.7)',
	                pointBackgroundColor: 'rgba(255, 255, 255, 1)',
	                pointBorderColor: 'rgba(0, 0, 0, 0.5)',
	                pointStyle: 'circle',
	                pointBorderWidth: 1,
	                pointRadius: 1,
	            };
		    	
		    	var arr_merge = $.merge( reconcile_bar_newapp, reconcile_bar_total );
		    	if($('#reconcile_consent_chart').length > 0) {
		    		var ctxLine = document.getElementById('reconcile_consent_chart').getContext("2d");
			        var gridChart = new Chart(ctxLine, {
			             type: 'line',
			             data: chartjs_data,
			             options: {
			            	 responsive: true,			            	
			            	 tooltips: {
			            		 enabled: true,
			            		 mode: 'label',
			            		 titleFontSize: 9,
			  	                 bodyFontSize: 9,
			  	                 xPadding: 2,
			  	                 yPadding: 2,
			  	                 caretSize: 2,
			  	                 cornerRadius: 0,
			  	                 backgroundColor: 'rgba(0, 0, 0, 0.7)',
			  	                 callbacks: {
			  	                	 title: function (tooltipItems, data) { return null; },
			  	                	 label: function (tooltipItems, data) {
			  	                		console.log(tooltipItems, data);
			  	                		 var str_label = '';
			  	                		 var label = data.datasets[tooltipItems.datasetIndex].label;
			  	                	
			  	                		 if(label == 'New') {  str_label = '(' + tooltipItems.xLabel + ') ' + data.datasets[tooltipItems.datasetIndex].label; }
			  	                		 else { str_label = data.datasets[tooltipItems.datasetIndex].label; }
			  	                			 
			  	                		 return str_label + ' : ' + roundFixed(checkValue(data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index]), 0);
			  	                		 
			  	                	 }			  	                	
			  	              	                	
			                     }
			            	 },
			            	 legend: { display: false },
			            	 scales: {
			            		 xAxes: [{
			            			 display: false,
			            			 min: 0,
			                      	 max: (checkValue(arrayMax(arr_merge)) + 10)
			            		 }],
			            		 yAxes: [{
			            			 display: false
			            		 }]
			            	 }
			             }
			        });	
		    		
		    	}
		    		       
		    	
		    	$('#reconcile_total').css({'border-left': '1px solid #FFF'}).text(reconcile_receivedDoc).addClass('animated fadeIn bg-orange');
		    	$('#incompleted_perate').text('Incompleted ' + reconcile_incompleted + ' (' + reconcile_cprated + '%)').addClass('animated fadeIn');
		    	
		    	function daysInMonth(month,year) {
		    	    return new Date(year, month, 0).getDate();
		    	}
		    			    	
		    },	   
		    complete:function() {		    	
		    	$.dequeue(this);
		    	
		    },
		    error: function (error) {
		 	    console.log(error);   
		    }	        
		});
		
	}());
	
	$.queue($(document), function() {	
		var emp_code = $('#empprofile_identity').val();
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/document/' + emp_code,
	        type: "GET",
		    success: function (responsed) {	
		    	// Doc. Missing
		    	var doc_missval  = (responsed.MissingDocumentData[0].MissingDoc) ? roundFixed(responsed.MissingDocumentData[0].MissingDoc, 0):0;
		    	var doc_returnca = (responsed.MissingDocumentData[0].ReturnDoc) ? roundFixed(responsed.MissingDocumentData[0].ReturnDoc, 0):0;
		    	$('#from_boxload, #return_boxload').addClass('hide');
		    	$('#ho2lb_label').removeClass('hide').addClass('animated fadeIn');
		    	$('#missing_total').css({'border-left': '1px solid #FFF'}).text(doc_missval).addClass('animated fadeIn bg-orange');
		    	$('#return_total').css({'border-left': '1px solid #FFF'}).text(doc_returnca).addClass('animated fadeIn bg-orange');
		    	
		    	var doc_from_rm  = (responsed.MissingDocumentData[0].FromRM) ? roundFixed(responsed.MissingDocumentData[0].FromRM, 0):0;
		    	var doc_from_ca  = (responsed.MissingDocumentData[0].FromCA) ? roundFixed(responsed.MissingDocumentData[0].FromCA, 0):0;
		    	
		    	var doc_ach_rm   = (responsed.MissingDocumentData[0].FromRMAch) ? roundFixed(responsed.MissingDocumentData[0].FromRMAch, 0):0;
		    	var doc_ach_ca   = (responsed.MissingDocumentData[0].FromCAAch) ? roundFixed(responsed.MissingDocumentData[0].FromCAAch, 0):0;
		    	
		    	var main_vol_rm   = (responsed.MissingDocumentData[0] && responsed.MissingDocumentData[0].RMBorrower) ? roundFixed(responsed.MissingDocumentData[0].RMBorrower, 0):0;
		    	var main_vol_ca   = (responsed.MissingDocumentData[0] && responsed.MissingDocumentData[0].CABorrower) ? roundFixed(responsed.MissingDocumentData[0].CABorrower, 0):0;
		    	//var main_ach_rm   = (responsed.MissingDocumentData[0] && responsed.MissingDocumentData[0].RMBorrowerAch) ? roundFixed(responsed.MissingDocumentData[0].RMBorrowerAch, 1):0;
		    	//var main_ach_ca   = (responsed.MissingDocumentData[0] && responsed.MissingDocumentData[0].CABorrowerAch) ? roundFixed(responsed.MissingDocumentData[0].CABorrowerAch, 1):0;
		    	
		    	var borrower_rmrate = (main_vol_rm && main_vol_rm > 0) ? (main_vol_rm / doc_from_rm) * 100 : 0;
		    	var borrower_carate = (main_vol_ca && doc_from_ca > 0) ? (main_vol_rm / doc_from_rm) * 100 : 0;
		
		    	$('#fromrm_val').removeClass('hide').text(doc_from_rm).addClass('animated fadeIn');
		    	$('#fromca_val').removeClass('hide').text(doc_from_ca).addClass('animated fadeIn');
		    	
		    	$('#fromrm_ach').removeClass('hide').text('Borrower ' + roundFixed(borrower_rmrate, 0) + '% (RM)').attr('title', 'มีจำนวนผู้กู้หลัก ' + main_vol_rm + ' รายการ').addClass('animated fadeIn');
		    	$('#fromca_ach').removeClass('hide').text('Borrower ' + roundFixed(borrower_carate, 0) + '% (CA)').attr('title', 'มีจำนวนผู้กู้หลัก ' + main_vol_ca + ' รายการ').addClass('animated fadeIn');
		    	
		    	//$('#fromrm_ach').removeClass('hide').text('FROM RM (' + doc_ach_rm + '%)').addClass('animated fadeIn');
		    	//$('#fromca_ach').removeClass('hide').text('FROM CA (' + doc_ach_ca + '%)').addClass('animated fadeIn');
		    	
		    	//$('#fromrm_mainborrower').removeClass('hide').text('BORROWER ' + main_vol_rm + ' (' + main_ach_rm + '%)').addClass('animated fadeIn');
		    	//$('#fromca_mainborrower').removeClass('hide').text('BORROWER ' + main_vol_ca + ' (' + main_ach_ca + '%)').addClass('animated fadeIn');
		    	
		    	$('#fromca_container').css('border-top', '1px solid #FFF');
		    	
		    	// Doc. Return
		    	var hqtolb_agign   	  = [];
		    	var returndoc_aging	  = [];
		    	var returndoc_potion  = [];
		    	
		    	var row_id = 1;
		    	var return_objectdata = (responsed.MissingDocumentAgingData) ? responsed.MissingDocumentAgingData:[];
		    	var total_returndoc	  = 0;
		    	if(return_objectdata && return_objectdata.length > 0) {
		    		for(var i = 0; i < return_objectdata.length; i++) { 
			    		if(return_objectdata[i].Aging !== "") {
			    			hqtolb_agign.push(return_objectdata[i].HQ2LB);
				    		returndoc_aging.push(return_objectdata[i].TotalAging);
				    		returndoc_potion.push(roundFixed(return_objectdata[i].AgingAch, 0));
				    		
				    		total_returndoc = roundFixed(total_returndoc, 0) + roundFixed(return_objectdata[i].HQ2LB, 0);
				    		
				    		$('.returndoc_labelach_' + row_id).text(roundFixed(return_objectdata[i].AgingAch, 0) + '%').addClass('animated fadeIn');
				    		$('.returndoc_potion_' + row_id).text(return_objectdata[i].TotalAging).addClass('animated fadeIn');
				    		
			    		}
		    			
			    		row_id++;
			    		
		    		}
		    		
		    		var sendback_percent = ((total_returndoc / doc_returnca) * 100);
		    		$('#ho2lb_label').text('Mth HO2LB ' + total_returndoc + ' (' + roundFixed(sendback_percent, 0) + '%)').addClass('animated fadeIn');
		    		
		    	} else {
		    		for(var i = 0; i <= 4; i++) { 
		    			hqtolb_agign.push(0);
			    		returndoc_aging.push(0);
			    		returndoc_potion.push(0);
		    		}
		    	}
		    
		    	$('#returndoc_consent_chart').sparkline(returndoc_aging, { 							
		    		type: 'bar', 				
		    		height: '55',
		    		barWidth: '12px',
		    		barSpacing: '8px',
		    		barColor: 'rgba(0,0,0,0.2)',
		    		tooltipPrefix: 'Pending',
		    		tooltipSuffix: 'Acc',		    	
		    		tooltipFormat: '<i class="fa fa-bar-chart fg-white"></i>  {{prefix}} : {{value}} {{suffix}}'
		    	
		    	});

		    	$('#returndoc_consent_chart').sparkline(hqtolb_agign, { 
		    		composite: true, 
		    		type: 'line', 	
		    		fillColor: false,
		    		lineColor: '#FFF',
		    		height: '50',
		    		tooltipPrefix: 'HO2LB',
		    		tooltipSuffix: 'Acc',
					tooltipFormat: '<i class="fa fa-line-chart fg-white"></i> {{prefix}} : {{y}} {{suffix}}'			
		    	});
		    	
		    	$('.returndoc_mth').removeClass('hide').addClass('animated fadeIn');
	
		    },	   
		    complete:function() {		    	
		    	$.dequeue(this);
		    },
		    error: function (error) {
		 	    console.log(error);   
		    }	        
		});
		
	}());
	
	// NEW ZONE OF NANO AND MICRO
	function nanomicro_chart_render(element, volume) {

        var day_launch  = 1;
        var day_offset  = [];
        var object_data = [];
        var daysInMonth = function(month,year) { return new Date(year, month, 0).getDate(); }

        window.randomScalingFactor = function() { return parseInt(Math.random() * 5); }
        for(var i = 0; i < daysInMonth(moment().format('MM'), moment().format('YYYY')); i++) {

            var full_date = new Date(year, month, day_launch.toString());
            var length = $.grep(object_data, function(item) { return item.Day == day_launch.toString(); }).length;

            //object_data.push(randomScalingFactor());
            object_data.push(0);
            day_offset.push(day_launch.toString() + ' ' + full_date.toString().substring(0, 3));

            day_launch++;

        }

        if(volume.RegionalVol.Volume && volume.RegionalVol.Volume.length > 0) {
            var i = 1;
            $.each(volume.RegionalVol.Volume, function (index, value) {
                var achieve = volume.RegionalVol.Achieve[index];
                $('.nanomicro_ach_vol' + i).text(achieve).addClass('animated fadeIn');
                $('.nanomicro_vol' + i).text(value).addClass('animated fadeIn');
                i++;
            })

        }

        var data = [[10, 5], [15, 10], [5, 3], [5, 10], [8, 0]];
        var getDataOverrall = [15, 10, 5, 3, 8, 0]
        $('#' + element).sparkline(volume.RegionalVol.VolMulti, {
            type: 'bar',
            height: '70',
            barWidth: '12px',
            barSpacing: '8px',
            chartRangeMin: 0,
            chartRangeMax: setMaxValues(volume.RegionalVol.Target),
            zeroColor: 'rgba(255, 255, 255, 1)',
            stackedBarColor: ['rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, .2)'],
            myPrefixes: ['Nano', 'Micro'],
            tooltipFormatter: function(sp, options, fields) {

                var format =  $.spformat('<div class="jqsfield"><span style="color: {{color}}">&#9679;</span> {{myprefix}} : {{value}} Mb</div>');
                var result = '';
                $.each(fields, function(i, field) {
                    field.myprefix = options.get('myPrefixes')[i];
                    result += format.render(field, options.get('tooltipValueLookups'), options);
                });
                
                return result;

            }
        });

        /*
        $('#' + element).sparkline(object_data, {
            composite: true,
            type: 'line',
            height: setMaxValues(getDataOverrall),
            width: '8em',
            fillColor: false,
            lineColor: '#ff0000',
            chartRangeMin: 0,
            chartRangeMax: setMaxValues(getDataOverrall),
            spotColor: false,
            minSpotColor: '#ff0000',
            maxSpotColor: '#ff0000',
            tooltipSuffix: ' Mb',
            tooltipFormat: '{{prefix}}{{offset:offset}} : {{y}}{{suffix}}',
            tooltipValueLookups: {
                'offset': day_offset
            }
        });
        */

    }

    function nanomicro_appinchart_render(element, volume) {

        var day_launch  = 1;
        var day_offset  = [];
        var object_data = [];
        var daysInMonth = function(month,year) { return new Date(year, month, 0).getDate(); }

        window.randomScalingFactor = function() { return parseInt(Math.random() * 5); }
        for(var i = 0; i < daysInMonth(moment().format('MM'), moment().format('YYYY')); i++) {

            var full_date = new Date(year, month, day_launch.toString());
            var length = $.grep(object_data, function(item) { return item.Day == day_launch.toString(); }).length;

            object_data.push(0);
            day_offset.push(day_launch.toString() + ' ' + full_date.toString().substring(0, 3));

            day_launch++;

        }

        if(volume.RegionalApp.Volume && volume.RegionalApp.Volume.length > 0) {
             var i = 1;
             $.each(volume.RegionalApp.Volume, function (index, value) {
                 var achieve = volume.RegionalApp.Achieve[index];
                 $('.appin_nanomicro_ach_vol' + i).text(achieve).addClass('animated fadeIn');
                 $('.appin_nanomicro_vol' + i).text(checkValue(value)).addClass('animated fadeIn');
                 i++;
            });
        }
        
        function absoluteNumber(value) {
        	if(value >= 10000) {
        		var d = roundFixed(checkValue((value / 1000000) * 100), 1);
        	} else if(value >= 100 && value <= 9999) {
        		var d = roundFixed(checkValue((value / 100000) * 100), 1);
        	} else {
        		var d = value;
        	}
        	  	
        	return d;
        	
        }

        var data = [[randomScalingFactor(), randomScalingFactor()], [randomScalingFactor(), randomScalingFactor()], [randomScalingFactor(), randomScalingFactor()], [randomScalingFactor(), randomScalingFactor()], [randomScalingFactor(), randomScalingFactor()]];
        var getDataOverrall = [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), 3, 8, 20, 0];
        
        $('#' + element).sparkline(volume.RegionalApp.VolMulti, {
            type: 'bar',
            height: '70',
            barWidth: '12px',
            barSpacing: '8px',
            chartRangeMin: 0,
            chartRangeMax: (parseInt(setMaxValues(volume.RegionalApp.Target)) + 200),
            zeroColor: '#1B6EAE',
            stackedBarColor: ['rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, .2)'],
            myPrefixes: ['Nano', 'Micro'],
            tooltipFormatter: function(sp, options, fields) {

                var format =  $.spformat('<div class="jqsfield"><span style="color: {{color}}">&#9679;</span> {{myprefix}} : {{value}} App</div>');
                var result = '';
                $.each(fields, function(i, field) {
                    field.myprefix = options.get('myPrefixes')[i];
                    result += format.render(field, options.get('tooltipValueLookups'), options);
                })

                return result;

            }
        });

    }
    
    function nano_onload() {
    	var emp_code = $('#empprofile_identity').val();
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/nano',
	        type: "GET",
		    success: function (responsed) {	
		    	var use_templorary = false;
		        if(use_templorary) {
		            var objectData = {
		                Overview: {
		                    NanoData: {
		                        YTD: { Target: '150', Actual: '144', Ach: '95%' },
		                        MTD: { Target: '100', Actual: '85', Ach: '85%' }
		                    },
		                    MicroData: {
		                        YTD: { Target: '65', Actual: '17', Ach: '27%' },
		                        MTD: { Target: '43', Actual: '9', Ach: '22%'  }
		                    },
		                    TotalData: {
		                        TotalTarget: '143',
		                        TotalActual: '95',
		                        TotalAchieve: '66',
		                        ApprovedRate: '69%'
		                    }
		                },
		                RegionalVol: {
		                    Region: formatRegion,
		                    Volume: [28, 38, 25, 27, 42],
		                    Target: [50, 47, 36, 41, 42],
		                    Achieve: [57, 81, 70, 66, 100],
		                    VolMulti: [[28, 0], [38, 0], [25, 0], [27, 0], [42, 0]]
		                },
		                RegionalApp: {
		                    Region: formatRegion,
		                    Volume: [662, 972, 754, 611, 909],
		                    Target: [1146, 1088, 821, 949, 972],
		                    Achieve: [58, 89, 92, 64, 93],
		                    VolMulti: [[662, 1146], [972, 1088], [754, 821], [611, 949], [909, 972]],
		                    Daily: []
		                }
		            }		            
		            
		        } else {
		        	
		        	var NanoAppin   = (responsed.NanoAppin && responsed.NanoAppin.length > 0) ? responsed.NanoAppin:null;
		        	var NanoDPD     = (responsed.NanoDPD && responsed.NanoDPD.length > 0) ? responsed.NanoDPD:null;
		        	var NanoMarket  = (responsed.NanoMarket && responsed.NanoMarket.length > 0) ? responsed.NanoMarket:null;
		        	var NanoPayment = (responsed.NanoPayment && responsed.NanoPayment.length > 0) ? responsed.NanoPayment:null;
		        	var NanoSetup 	= (responsed.NanoSetup && responsed.NanoSetup.length > 0) ? responsed.NanoSetup:null;
		        	var NanoDashboard  = (responsed.NanoDashboard && responsed.NanoDashboard.length > 0) ? responsed.NanoDashboard:null;
		        	var NanoCollection = (responsed.NanoCollection && responsed.NanoCollection.length > 0) ? responsed.NanoCollection:null;
		   
		        	var decimal_fix = 1;
		        	var objectData = {
		        		Overview: {
		        			 NanoData: {
		        				 YTD: { Target: roundFixed(checkValue('0'), 0), Actual: roundFixed(checkValue('0'), 0), Ach: roundFixed(checkValue('0'), 0) },
			                     MTD: { Target: roundFixed(checkValue(NanoSetup[3].Total), 0), Actual:  roundFixed(checkValue(NanoSetup[4].Total), 0), Ach:  roundFixed(checkValue(NanoSetup[5].Total), 0) + '%' }
			                 },
			                 MicroData: {
			                	 YTD: { Target: roundFixed(checkValue('0'), 0), Actual: roundFixed(checkValue('0'), 0), Ach: roundFixed(checkValue('0'), 0) },
			                     MTD: { Target: roundFixed(checkValue(NanoSetup[6].Total), 0), Actual:  roundFixed(checkValue(NanoSetup[7].Total), 0), Ach:  roundFixed(checkValue(NanoSetup[8].Total), 0) + '%'  }
			                 },
			                 TotalData: {
			                  	 TotalTarget: ( roundFixed(checkValue(NanoSetup[0].Total), 0) ),
			                     TotalActual: ( roundFixed(checkValue(NanoSetup[1].Total), 0) ),
			                     init: function() {
			                         this.TotalAchieve = checkValue(roundFixed(checkValue((this.TotalActual / this.TotalTarget) * 100), 0)) + '%';
			                         return this;
			                     },
			                     ApprovedRate: roundFixed(checkValue(NanoDashboard[3].Total), 0) + '%'
			                 }.init()
		        		},
		        		RegionalVol: {
		        			Region: formatRegion,
		        			Target: (NanoSetup[0]) ? [
		        				roundFixed(checkValue(NanoSetup[0].E), 0),
		        				roundFixed(checkValue(NanoSetup[0].C), 0),
		        				roundFixed(checkValue(NanoSetup[0].N), 0),
		        				roundFixed(checkValue(NanoSetup[0].S), 0),
		        				roundFixed(checkValue(NanoSetup[0].I), 0)
		        			] : [0, 0, 0, 0, 0],
		        			Volume: (NanoSetup[1]) ? [
		        				roundFixed(checkValue(NanoSetup[1].E), 0),
		        				roundFixed(checkValue(NanoSetup[1].C), 0),
		        				roundFixed(checkValue(NanoSetup[1].N), 0),
		        				roundFixed(checkValue(NanoSetup[1].S), 0),
		        				roundFixed(checkValue(NanoSetup[1].I), 0)
		        			] : [0, 0, 0, 0, 0],
		                    Achieve: (NanoSetup[2]) ? [
		                    	roundFixed(checkValue(NanoSetup[2].E), 0),
		        				roundFixed(checkValue(NanoSetup[2].C), 0),
		        				roundFixed(checkValue(NanoSetup[2].N), 0),
		        				roundFixed(checkValue(NanoSetup[2].S), 0),
		        				roundFixed(checkValue(NanoSetup[2].I), 0)
		                    ] : [0, 0, 0, 0, 0],
		                    VolMulti: (NanoSetup[7]) ? [
		                    	[roundFixed(checkValue(NanoSetup[7].E), decimal_fix), roundFixed(checkValue(NanoSetup[4].E), decimal_fix)], 
		                    	[roundFixed(checkValue(NanoSetup[7].C), decimal_fix), roundFixed(checkValue(NanoSetup[4].C), decimal_fix)], 
		                    	[roundFixed(checkValue(NanoSetup[7].N), decimal_fix), roundFixed(checkValue(NanoSetup[4].N), decimal_fix)],
		                    	[roundFixed(checkValue(NanoSetup[7].S), decimal_fix), roundFixed(checkValue(NanoSetup[4].S), decimal_fix)], 
		                    	[roundFixed(checkValue(NanoSetup[7].I), decimal_fix), roundFixed(checkValue(NanoSetup[4].I), decimal_fix)]
		                    ] : [0, 0, 0, 0, 0]
		        		},
		        		RegionalApp: {
		                    Region: formatRegion,
		                    Target: (NanoAppin) ? [
		                    	roundFixed(checkValue(NanoAppin[0].E), 0),
		        				roundFixed(checkValue(NanoAppin[0].C), 0),
		        				roundFixed(checkValue(NanoAppin[0].N), 0),
		        				roundFixed(checkValue(NanoAppin[0].S), 0),
		        				roundFixed(checkValue(NanoAppin[0].I), 0)
		                    ] : [0, 0, 0, 0, 0],
		                    Volume: (NanoAppin) ? [
		                    	setMaxValue(roundFixed(checkValue(NanoAppin[1].E), 0)),
		                    	setMaxValue(roundFixed(checkValue(NanoAppin[1].C), 0)),
		                    	setMaxValue(roundFixed(checkValue(NanoAppin[1].N), 0)),
		                    	setMaxValue(roundFixed(checkValue(NanoAppin[1].S), 0)),
		                    	setMaxValue(roundFixed(checkValue(NanoAppin[1].I), 0))
		                    ] : [0, 0, 0, 0, 0],
		                    Achieve: (NanoAppin) ? [
		                    	roundFixed(checkValue(NanoAppin[2].E), 0),
		        				roundFixed(checkValue(NanoAppin[2].C), 0),
		        				roundFixed(checkValue(NanoAppin[2].N), 0),
		        				roundFixed(checkValue(NanoAppin[2].S), 0),
		        				roundFixed(checkValue(NanoAppin[2].I), 0)
		                    ] : [0, 0, 0, 0, 0],
		                    VolMulti: (NanoAppin) ? [
		                    	[roundFixed(checkValue(NanoAppin[7].E), 0), roundFixed(checkValue(NanoAppin[4].E), 0)], 
		                    	[roundFixed(checkValue(NanoAppin[7].C), 0), roundFixed(checkValue(NanoAppin[4].C), 0)], 
		                    	[roundFixed(checkValue(NanoAppin[7].N), 0), roundFixed(checkValue(NanoAppin[4].N), 0)], 
		                    	[roundFixed(checkValue(NanoAppin[7].S), 0), roundFixed(checkValue(NanoAppin[4].S), 0)], 
		                    	[roundFixed(checkValue(NanoAppin[7].I), 0), roundFixed(checkValue(NanoAppin[4].I), 0)]
		                    ]  : [0, 0, 0, 0, 0],
		                    Daily: []
		                }
		        	}
		        	
		        }
		        
		        var objectNPLWeekly  = {};
		        var weekly_handforce = false;
		        if(weekly_handforce) {
		        	objectNPLWeekly = {
		                Target: {
		                	Week1: 2.0,
			                Week2: 1,
			                Week3: 1,
			                Week3Temp: 0.5,
			                Week4Temp: 0.5,		          	               
			                XClass: 3,		                
			                MClass1: 1,
			                MClass2: 1,
			                MClass: 2,
			                NPLClass: 4
		                },
		                Account: {
		                	Week1: 863,
			                Week2: 47,
			                Week3: 16,
			                Week3Temp: 5,
			                Week4Temp: 11,		          	               
			                XClass: 195,		                
			                MClass1: 70,
			                MClass2: 50,
			                MClass: 120,
			                NPLClass: 47
		                },
		        		Volume: {
		                	Week1: [restnumber(51.9, 'Mb'), restnumber(6.6, '%')],
			                Week2: [restnumber(2.5, 'Mb'), restnumber(0.3, '%')],
			                Week3: [restnumber(1, 'Mb'), restnumber(0.1, '%')],
			                Week3Temp: [restnumber(0.7, 'Mb'), restnumber(0.1, '%')],
			                Week4Temp: [restnumber(0.3, 'Mb'), restnumber(0.0, '%')],		          	               
			                XClass: [restnumber(11.2, 'Mb'), restnumber(1.4, '%')],		                
			                MClass1: [restnumber(3.7, 'Mb'), restnumber(0.5, '%')],
			                MClass2: [restnumber(2.6, 'Mb'), restnumber(0.3, '%')],
			                MClass: [restnumber(6.3, 'Mb'), restnumber(0.8, '%')],
			                NPLClass: [restnumber(2.6, 'Mb'), restnumber(0.3, '%')]
		                }
		        		
		            };
		        	
		        } else {
		        	
		        	objectNPLWeekly = {
	        			Target: {
	        				Week1: 2,
			                Week2: 1,
			                Week3: 1,
			                Week3Temp: 0.5,
			                Week4Temp: 0.5,		          	               
			                XClass: 3,		                
			                MClass1: 1,
			                MClass2: 1,
			                MClass: 2,
			                NPLClass: 4
		                },
		                Account: {
		                	Week1: checkValue(NanoDPD[11].Total),
			                Week2: checkValue(NanoDPD[12].Total),
			                Week3: ( roundFixed(checkValue(NanoDPD[13].Total), 0) + roundFixed(checkValue(NanoDPD[14].Total), 0) ),
			                Week3Temp: checkValue(NanoDPD[13].Total),
			                Week4Temp: checkValue(NanoDPD[14].Total),		          	               
			                XClass: checkValue(NanoDPD[15].Total),		                
			                MClass1: checkValue(0),
			                MClass2: checkValue(0),
			                MClass: ( roundFixed(checkValue(NanoDPD[16].Total), 0) + roundFixed(checkValue(NanoDPD[17].Total), 0) ),
			                NPLClass: checkValue(NanoDPD[18].Total)
		                },
		        		Volume: {
		        			Week1: [ restnumber(checkValue(NanoDPD[1].Total), 'Mb'), restnumber(checkValue(NanoDPD[21].Total), '%') ],
			                Week2: [ restnumber(checkValue(NanoDPD[2].Total), 'Mb'), restnumber(checkValue(NanoDPD[22].Total), '%') ],
			                Week3: [ 
			                	restnumber( (roundFixed(checkValue(NanoDPD[3].Total), 0) + roundFixed(checkValue(NanoDPD[4].Total), 0)) , 'Mb'), 
			                	restnumber( (roundFixed(checkValue(NanoDPD[23].Total), 1) + roundFixed(checkValue(NanoDPD[24].Total), 1)), '%')
			                ],
			                Week3Temp: [restnumber(0, 'Mb'), restnumber(0, '%')],
			                Week4Temp: [restnumber(0, 'Mb'), restnumber(0, '%')],		   
			                XClass: [ restnumber(checkValue(NanoDPD[5].Total), 'Mb'), restnumber(checkValue(NanoDPD[25].Total), '%') ],
			                MClass1: [restnumber(0, 'Mb'), restnumber(0, '%')],
			                MClass2: [restnumber(0, 'Mb'), restnumber(0, '%')],
			                MClass: [ 
			                	restnumber( (roundFixed(checkValue(NanoDPD[6].Total), 0) + roundFixed(checkValue(NanoDPD[7].Total), 0)), 'Mb'), 
			                	restnumber( (roundFixed(checkValue(NanoDPD[26].Total), 1) + roundFixed(checkValue(NanoDPD[27].Total), 1)), '%') 
			                ],
			                NPLClass: [ restnumber(checkValue(NanoDPD[8].Total), 'Mb'), restnumber(checkValue(NanoDPD[28].Total), '%') ]
		        		}		        		
		            };
		        	
		        }
		        
	            var distribution = {
	                Region: formatRegion,
	                Weekly : {
	                    Mon: [
	                    	roundFixed(checkValue(NanoPayment[0].E), 0),
	        				roundFixed(checkValue(NanoPayment[1].E), 0),
	        				roundFixed(checkValue(NanoPayment[2].E), 0),
	        				roundFixed(checkValue(NanoPayment[3].E), 0),
	        				roundFixed(checkValue(NanoPayment[4].E), 0)
	                    ],
	                    Tue: [
	                    	roundFixed(checkValue(NanoPayment[0].C), 0),
	        				roundFixed(checkValue(NanoPayment[1].C), 0),
	        				roundFixed(checkValue(NanoPayment[2].C), 0),
	        				roundFixed(checkValue(NanoPayment[3].C), 0),
	        				roundFixed(checkValue(NanoPayment[4].C), 0)
	                    ],
	                    Wed: [
	                    	roundFixed(checkValue(NanoPayment[0].N), 0),
	        				roundFixed(checkValue(NanoPayment[1].N), 0),
	        				roundFixed(checkValue(NanoPayment[2].N), 0),
	        				roundFixed(checkValue(NanoPayment[3].N), 0),
	        				roundFixed(checkValue(NanoPayment[4].N), 0)
	                    ],
	                    Thu: [
	                    	roundFixed(checkValue(NanoPayment[0].S), 0),
	        				roundFixed(checkValue(NanoPayment[1].S), 0),
	        				roundFixed(checkValue(NanoPayment[2].S), 0),
	        				roundFixed(checkValue(NanoPayment[3].S), 0),
	        				roundFixed(checkValue(NanoPayment[4].S), 0)
	                    ],
	                    Fri: [
	                    	roundFixed(checkValue(NanoPayment[0].I), 0),
	        				roundFixed(checkValue(NanoPayment[1].I), 0),
	        				roundFixed(checkValue(NanoPayment[2].I), 0),
	        				roundFixed(checkValue(NanoPayment[3].I), 0),
	        				roundFixed(checkValue(NanoPayment[4].I), 0)
	                    ]
	                }
	                /*
	                Weekly : {
	                    Mon: [
	                    	roundFixed(checkValue(NanoPayment[0].E), 0),
	        				roundFixed(checkValue(NanoPayment[0].C), 0),
	        				roundFixed(checkValue(NanoPayment[0].N), 0),
	        				roundFixed(checkValue(NanoPayment[0].S), 0),
	        				roundFixed(checkValue(NanoPayment[0].I), 0)
	                    ],
	                    Tue: [
	                    	roundFixed(checkValue(NanoPayment[1].E), 0),
	        				roundFixed(checkValue(NanoPayment[1].C), 0),
	        				roundFixed(checkValue(NanoPayment[1].N), 0),
	        				roundFixed(checkValue(NanoPayment[1].S), 0),
	        				roundFixed(checkValue(NanoPayment[1].I), 0)
	                    ],
	                    Wed: [
	                    	roundFixed(checkValue(NanoPayment[2].E), 0),
	        				roundFixed(checkValue(NanoPayment[2].C), 0),
	        				roundFixed(checkValue(NanoPayment[2].N), 0),
	        				roundFixed(checkValue(NanoPayment[2].S), 0),
	        				roundFixed(checkValue(NanoPayment[2].I), 0)
	                    ],
	                    Thu: [
	                    	roundFixed(checkValue(NanoPayment[3].E), 0),
	        				roundFixed(checkValue(NanoPayment[3].C), 0),
	        				roundFixed(checkValue(NanoPayment[3].N), 0),
	        				roundFixed(checkValue(NanoPayment[3].S), 0),
	        				roundFixed(checkValue(NanoPayment[3].I), 0)
	                    ],
	                    Fri: [
	                    	roundFixed(checkValue(NanoPayment[4].E), 0),
	        				roundFixed(checkValue(NanoPayment[4].C), 0),
	        				roundFixed(checkValue(NanoPayment[4].N), 0),
	        				roundFixed(checkValue(NanoPayment[4].S), 0),
	        				roundFixed(checkValue(NanoPayment[4].I), 0)
	                    ]
	                }
					*/
	            }
	            
	            var collection_handled = false;
	            var collection_success_list = {} 
	            if(collection_handled) {
	            	collection_success_list = {
	            		collection_region: formatRegion,
	            		collection_target: [166, 149, 85, 151, 187],	            		
	            		collection_list: [
	            			[15, 151],
			    			[1, 148],
			    			[0, 85],
			    			[0, 151],
			    			[2, 185]
	            		],
	            		collection_success: [91, 99, 100, 100, 99]
	            	}
	            	
	            	'collection_list = failed vs success' 
	
	            } else {

	            	collection_success_list = {
	            		collection_region: formatRegion,
	            		collection_target: [
	            			roundFixed(checkValue(NanoCollection[0].E), 0),
	        				roundFixed(checkValue(NanoCollection[0].C), 0),
	        				roundFixed(checkValue(NanoCollection[0].N), 0),
	        				roundFixed(checkValue(NanoCollection[0].S), 0),
	        				roundFixed(checkValue(NanoCollection[0].I), 0)
	            		],	            		
	            		collection_list: [
	            			[roundFixed(checkValue(NanoCollection[2].E), 0), roundFixed(checkValue(NanoCollection[1].E), 0)],
	        				[roundFixed(checkValue(NanoCollection[2].C), 0), roundFixed(checkValue(NanoCollection[1].C), 0)],
	        				[roundFixed(checkValue(NanoCollection[2].N), 0), roundFixed(checkValue(NanoCollection[1].N), 0)],
	        				[roundFixed(checkValue(NanoCollection[2].S), 0), roundFixed(checkValue(NanoCollection[1].S), 0)],
	        				[roundFixed(checkValue(NanoCollection[2].I), 0), roundFixed(checkValue(NanoCollection[1].I), 0)]
	            		],
	            		collection_success: [
	            			roundFixed(checkValue(NanoCollection[3].E), 0),
	        				roundFixed(checkValue(NanoCollection[3].C), 0),
	        				roundFixed(checkValue(NanoCollection[3].N), 0),
	        				roundFixed(checkValue(NanoCollection[3].S), 0),
	        				roundFixed(checkValue(NanoCollection[3].I), 0)
	            		]
	            	}

	            }
	            
	            
	            // สลับ แกน NANO - MICRO
		        nanomicro_chart_render('nanomicro_chart', objectData);
		        nanomicro_appinchart_render('appin_nanomicro_chart', objectData);
		        distribuetion_payment(distribution);
	            setOverviewNanoMicroFixed(objectData);
	            setNPLWeeklyFixed(objectNPLWeekly);		 
	 
	            nplchart_render('npldata_chart', collection_success_list);
	            
	            if(NanoMarket && NanoMarket.length > 0) { 
	            	loadMarketPenetrationChart(NanoMarket); 
	            }
	            
	            h4cchart_render('h4c_mtdchart', 'h4c_ytdchart');
		    	
		    },	   
		    complete:function() {},
		    error: function (error) { console.log(error); }	        
		});
		
		function setMaxValue(value) {
			if(value >= 1000) {
				return 999;
			} else {
				return value;
			}
		}
		
    }
    
    nano_onload();
    
	function h4cchart_render(element1, element2) {
		var emp_code = $('#empprofile_identity').val();
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/h4c/' + emp_code,
	        type: "GET",
		    success: function (responsed) {	
		    	var h4c_mtd   = (responsed.H4CMonth) ? responsed.H4CMonth[0]:null;
		    	var h4c_rate  = (h4c_mtd) ? roundFixed(checkValue(h4c_mtd.ApvRate), 0):0;
		    	var h4c_app   = (h4c_mtd) ? h4c_mtd.ApvApp:0;
		    	var vol_mtd   = (h4c_mtd) ? roundFixed(checkValue(h4c_mtd.DDAmtMTD), 0):0;
		    	var vol_ytd   = (h4c_mtd) ? roundFixed(checkValue(h4c_mtd.DDAmtYTD), 0):0;
		    	var ach_mtd   = (h4c_mtd) ? roundFixed(checkValue(h4c_mtd.AchMTD), 0):0;
		    	var ach_ytd   = (h4c_mtd) ? roundFixed(checkValue(h4c_mtd.AchYTD), 0):0;
		    	var target_mtd = (h4c_mtd) ? h4c_mtd.TargetMTD:0;
		    	var target_ytd = (h4c_mtd) ? h4c_mtd.TargetYTD:0;
		    	
		    	var sumacutual = (vol_ytd + vol_mtd);
		    	
		    	var target_year = 300;
				var target_avg  = roundFixed(checkValue(((target_year / 12) * parseInt(moment().format('M')))), 0);
				var target_ach  = (roundFixed(checkValue(sumacutual), 0) / target_avg) * 100;
			    	
		    	$('#h4c_rate').text(h4c_rate + '%').addClass('animated fadeIn');
		    	$('#h4c_app').text(h4c_app).addClass('animated fadeIn');
		    	
		    	$('#h4c_actual_mtd').text(vol_mtd + 'Mb').addClass('animated fadeIn');
		    	$('#h4c_actual_ytd').text(sumacutual + 'Mb').addClass('animated fadeIn');
		    	
		    	var text_mtd = target_mtd + 'Mb (Ach. ' + ach_mtd + '%)';
		    	var text_ytd = target_avg + 'Mb (Ach. ' + roundFixed(checkValue(target_ach), 0) + '%)';
		    	$('#h4c_actual_mtddetails > small').text(text_mtd).addClass('animated fadeIn');
		    	$('#h4c_actual_ytddetails > small').text(text_ytd).addClass('animated fadeIn');		    			    	
		    
		    	var h4capp_data = [];
		    	var h4cvol_data = [];
		    	
		    	var h4capp_total = [];
		    	var h4cvol_total = [];
		    	
		    	var H4CCurrentMth  = 0;		    	
		    	var H4CRegionYear  = (responsed.H4CRegionYear) ? responsed.H4CRegionYear:null;
		    	var H4CRegionMonth = (responsed.H4CRegionMonth) ? responsed.H4CRegionMonth:null;
		    	
		    	if(H4CRegionMonth && H4CRegionMonth.length > 0) {		
		    		$.each(H4CRegionMonth, function(index, value) {
		    			h4capp_data.push([roundFixed(checkValue(value.Acc), 0)]);
		    			h4cvol_data.push([roundFixed(checkValue(value.DD), 0)]);
		    			
		    			h4capp_total.push(roundFixed(checkValue(value.Acc), 0));
		    			h4cvol_total.push(roundFixed(checkValue(value.DD), 0));
		    		 
		    		});
		    	}
		  		    	
		    	if(H4CRegionYear && H4CRegionYear.length > 0) {		
		    		$.each(H4CRegionYear, function(index, value) {
		    			if(h4capp_data[index]) {
		    				h4capp_data[index].push(roundFixed(checkValue(value.Acc), 0));
			    			h4cvol_data[index].push(roundFixed(checkValue(value.DD), 0));
			    			
			    			h4capp_total[index] = h4capp_total[index] + roundFixed(checkValue(value.Acc), 0);
			    			h4cvol_total[index] = h4cvol_total[index] + roundFixed(checkValue(value.DD), 0);
	
		    			}
		    			
		    		});
		    	}
		    	
		    	if(h4capp_total && h4capp_total.length > 0) {	
		    		var pointer = 1;
		    		$.each(h4capp_total, function(index, value) {		    			
		    			$('.h4c_ytdchart_ach' + pointer).text(checkValue(h4cvol_total[index])).addClass('animated fadeIn');
				    	$('.h4c_mtdchart_ach' + pointer).text(checkValue(h4capp_total[index])).addClass('animated fadeIn');
				    	pointer++;
		    		 
		    		});
		    	}
	
		    	$('.h4c_mtdchart_vol0, .h4c_ytdchart_vol0').text(moment().format('MMM').toUpperCase());	    	
		    	$('#' + element1).sparkline(h4capp_data, { 
					type: 'bar',
					height: '70',
					barWidth: '12px',
					barSpacing: '8px',
					chartRangeMin: 0,
					chartRangeMax: setMaxValues(h4capp_data),
					zeroColor: 'rgba(255, 255, 255, .2)',
					stackedBarColor: ['rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, .2)'],
					myPrefixes: ['YTD', moment().format('MMM').toUpperCase()],
					tooltipFormatter: function(sp, options, fields) {
				
						var format =  $.spformat('<div class="jqsfield"><span style="color: {{color}}">&#9679;</span> {{myprefix}} : {{value}} App</div>');
						var result = '';
		                $.each(fields, function(i, field) {
		                    field.myprefix = options.get('myPrefixes')[i];
		                    result += format.render(field, options.get('tooltipValueLookups'), options);
		                })
		                
		                return result;
		              	
						
		            }
				});
	
		    	$('#' + element2).sparkline(h4cvol_data, { 
					type: 'bar',
					height: '70',
					barWidth: '12px',
					barSpacing: '8px',
					chartRangeMin: 0,
					chartRangeMax: setMaxValues(h4cvol_data),
					zeroColor: 'rgba(255, 255, 255, .2)',
					stackedBarColor: ['rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, .2)'],
					myPrefixes: ['YTD', moment().format('MMM').toUpperCase()],
					tooltipFormatter: function(sp, options, fields) {
				
						var format =  $.spformat('<div class="jqsfield"><span style="color: {{color}}">&#9679;</span> {{myprefix}} : {{value}} Mb</div>');
						var result = '';
		                $.each(fields, function(i, field) {
		                    field.myprefix = options.get('myPrefixes')[i];
		                    result += format.render(field, options.get('tooltipValueLookups'), options);
		                })
		                
		                return result;
		              	
						
		            }
				});
		    
		    },	   
		    complete:function() {
		    	$('#h4c_mtdlabel, #h4c_mtdfooter, #h4c_ytdlabel, #h4c_ytdfooter')
		    	.removeClass('hide')
		    	.addClass('animated fadeIn');
		    	
		    		    	
		    },
		    error: function (error) { console.log(error); }	        
		});
		
		/*
		var day_launch  = 1;
		var day_offset  = [];
		var object_data = [];
		var data_draft  = [0, 0, 0, 0, 0];
		var daysInMonth = function(month,year) { return new Date(year, month, 0).getDate(); }		
		
		//window.randomScalingFactor = function() { return parseInt(Math.random() * 5); }
		//var data = [[randomScalingFactor(), randomScalingFactor()], [randomScalingFactor(), randomScalingFactor()], [randomScalingFactor(), randomScalingFactor()], [randomScalingFactor(), randomScalingFactor()], [randomScalingFactor(), randomScalingFactor()]];
		//var getDataOverrall = [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), 3, 8, 20, 0];

		$('#' + element).sparkline(data_draft, { 
			type: 'bar',
			height: '70',
			barWidth: '12px',
			barSpacing: '8px',
			chartRangeMin: 0,
			chartRangeMax: [], //setMaxValues(getDataOverrall),
			zeroColor: '#FFFFFF',
			stackedBarColor: ['rgba(255, 255, 255, .8)', 'rgba(0, 0, 0, .2)'],
			myPrefixes: ['Vol', 'Target'],
			tooltipFormatter: function(sp, options, fields) {
		
				var format =  $.spformat('<div class="jqsfield"><span style="color: {{color}}">&#9679;</span> {{myprefix}} : {{value}} Mb</div>');
				var result = '';
                $.each(fields, function(i, field) {
                    field.myprefix = options.get('myPrefixes')[i];
                    result += format.render(field, options.get('tooltipValueLookups'), options);
                })
                
                return result;
              	
				
            }
		});
		*/
		
	}
	
	function nplchart_render(element, objVolume) {

		if(objVolume.collection_success && objVolume.collection_success.length > 0) {
			var pointer = 1;
			$.each(objVolume.collection_success, function(index, value) {
				$('.nplos_label' + pointer).text(value).addClass('animated fadeIn');
				pointer++;
			});
		}

		$('#' + element).sparkline(objVolume.collection_list, { 
			type: 'bar',
			height: '70',
			barWidth: '12px',
			barSpacing: '8px',
			chartRangeMin: 0,
			chartRangeMax: setMaxValues(objVolume.collection_target),
			zeroColor: 'rgba(228, 19, 1, 1)',
			stackedBarColor: ['rgba(228, 19, 1, 1)', 'rgba(0, 0, 0, .2)'],
			myPrefixes: ['Success', 'Fail'],
			tooltipFormatter: function(sp, options, fields) {
		
				var format =  $.spformat('<div class="jqsfield"><div class="jqs jqstitle">Target &gt; 90%</div><span style="color: {{color}}">&#9679;</span> {{myprefix}} : {{value}} Acc</div>');
				var result = '';
				var tpText = '';
                $.each(fields, function(i, field) {
                    field.myprefix = options.get('myPrefixes')[i];                  
                 
                    result += format.render(field, options.get('tooltipValueLookups'), options);    
                              
                    if(field.myprefix == 'Success') {
                    	var element_text = $(result)[0];   
                    	tpText += $(element_text).html();
                    } else {
                    	var element_text   = $(result)[1];  
                    	var text_container = $(element_text).text();
                    	var result_text	   = text_container.replace('Target > 90%● ', '');
                     	tpText += '<div class="jqsfield"><span style="color: rgba(228, 19, 1, 1);">&#9679;</span> ' + result_text + '</div>';
                    }
          
                })
                
                return tpText;
              
            }
		});
				
	}

    function distribuetion_payment(object_data) {
        if(object_data.Weekly) {
            $.each(object_data.Weekly, function(index, value) {
                var elements = $('tr[data-attr-day="' + index + '"]');
                $.each(value, function(i, v) {
                    var str_title = 'value is ' + v;
                    $(elements).find('td[data-attr="' + formatRegionFull[i] + '"] > span').removeClass('fg-white').css('color', traffic_color(v)).attr('title', str_title);
                });
            });

        }
    }

    function traffic_color(data_value) {
        var range_value = roundFixed(checkValue(data_value), 0);
        if(range_value) {
            // green #2b8900
            if(range_value >= 51) {
                //return '#E41301 !important';
            	return 'red';
            } else if(range_value >= 31 && range_value <= 50) {
                //return '#F0A30A !important';
            	return 'yellow';
            } else if(range_value <= 30) {
                return '#FFFFFF !important';
            } else {
                return '#FFFFFF !important';
            }

        } else { return '#FFFFFF !important'; }
    }

    function setOverviewNanoMicroFixed(object_data) {
        if(object_data) {

            var MicroActual = (object_data.Overview.MicroData.MTD.Actual) ? object_data.Overview.MicroData.MTD.Actual:0;
            var MicroTarget = (object_data.Overview.MicroData.MTD.Target) ? object_data.Overview.MicroData.MTD.Target:0;
            var MicroAch    = (object_data.Overview.MicroData.MTD.Ach) ? object_data.Overview.MicroData.MTD.Ach:0;

            $('#micro_actual').text(MicroActual).addClass('animated fadeIn');
            $('#micro_datainfo  > small').text(MicroTarget + 'Mb (Ach. ' + MicroAch + ')').addClass('animated fadeIn');

            var NanoActual = (object_data.Overview.NanoData.MTD.Actual) ? object_data.Overview.NanoData.MTD.Actual:0;
            var NanoTarget = (object_data.Overview.NanoData.MTD.Target) ? object_data.Overview.NanoData.MTD.Target:0;
            var NanoAch    = (object_data.Overview.NanoData.MTD.Ach) ? object_data.Overview.NanoData.MTD.Ach:0;

            $('#nano_actual').text(NanoActual).addClass('animated fadeIn');
            $('#nano_datainfo  > small').text(NanoTarget + 'Mb (Ach. ' + NanoAch + ')').addClass('animated fadeIn');

            var MTDActual  = (object_data.Overview.TotalData.TotalActual) ? object_data.Overview.TotalData.TotalActual:0;
            var MTDTarget  = (object_data.Overview.TotalData.TotalTarget) ? object_data.Overview.TotalData.TotalTarget:0;
            var MTDAchieve = (object_data.Overview.TotalData.TotalAchieve) ? object_data.Overview.TotalData.TotalAchieve:0;
            var MTDAppRate = (object_data.Overview.TotalData.ApprovedRate) ? object_data.Overview.TotalData.ApprovedRate:0;

            $('#nanomicro_actual_mtd').text(MTDActual).addClass('animated fadeIn');
            $('#nanomicro_datainfo_mtd > small').text(MTDTarget + 'Mb (Ach. ' + MTDAchieve + ')').addClass('animated fadeIn');
            $('#nanomicro_appr_rate').text(MTDAppRate).addClass('animated fadeIn');

        }

    }

    function setNPLWeeklyFixed(object_data) {
        if(object_data) {
        	
        	var tooltip_week_1 = 'Target < ' + restnumber(object_data.Target.Week1, '%') + '|' + 'Week1: ' + restnumber(object_data.Account.Week1, ' Acc');
            var tooltip_week_2 = 'Target < ' + restnumber(object_data.Target.Week2, '%') + '|' + 'Week2: ' + restnumber(object_data.Account.Week2, ' Acc');
            var tooltip_week_3 = 'Target < ' + restnumber(object_data.Target.Week3, '%') + '|' + 'Week3-4: ' + restnumber(object_data.Account.Week3, ' Acc');
            var tooltip_week_x = 'Target < ' + restnumber(object_data.Target.XClass, '%') + '|' + 'X: ' + restnumber(object_data.Account.XClass, ' Acc');
            var tooltip_week_m = 'Target < ' + restnumber(object_data.Target.MClass, '%') + '|' + 'M: ' + restnumber(object_data.Account.MClass, ' Acc');
            var tooltip_week_npl = 'Target < ' + restnumber(object_data.Target.NPLClass, '%') + '|' + 'NPL : ' + restnumber(object_data.Account.NPLClass, ' Acc');
        
            $('#nplacc_week1').text(object_data.Volume.Week1[0]).addClass('animated fadeIn').after(function() {  $(this).parent().attr("data-hint", tooltip_week_1); });
            $('#nplrate_week1').text(object_data.Volume.Week1[1] ).addClass('animated fadeIn');
            
            $('#nplacc_week2').text(object_data.Volume.Week2[0]).addClass('animated fadeIn').after(function() {  $(this).parent().attr("data-hint", tooltip_week_2); });
            $('#nplrate_week2').text(object_data.Volume.Week2[1]).addClass('animated fadeIn');
            
            $('#nplacc_week3').text(object_data.Volume.Week3[0]).addClass('animated fadeIn').after(function() {  $(this).parent().attr("data-hint", tooltip_week_3); });
            $('#nplrate_week3').text(object_data.Volume.Week3[1]).addClass('animated fadeIn');
            
            $('#nplacc_xclass').text(object_data.Volume.XClass[0]).addClass('animated fadeIn').after(function() {  $(this).parent().attr("data-hint", tooltip_week_x); });
            $('#nplrate_xclass').text(object_data.Volume.XClass[1]).addClass('animated fadeIn')
            
            $('#nplacc_mclass').text(object_data.Volume.MClass[0]).addClass('animated fadeIn').after(function() {  $(this).parent().attr("data-hint", tooltip_week_m); });
            $('#nplrate_mclass').text(object_data.Volume.MClass[1]).addClass('animated fadeIn');
            
            $('#nplacc_class').text(object_data.Volume.NPLClass[0]).addClass('animated fadeIn').after(function() {  $(this).parent().attr("data-hint", tooltip_week_npl); });
            $('#nplrate_class').text(object_data.Volume.NPLClass[1]).addClass('animated fadeIn');
           
        }
      
    }

	function loadNanoData() {
	
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/nano',
	        type: "GET",
		    success: function (responsed) {	
		    	
		    	//var NanoDashboard = (responsed.NanoDashboard) ? responsed.NanoDashboard:null;
		    	//var NanoDPD 	  = (responsed.NanoDPD) ? responsed.NanoDPD:null;
		    	//var NanoAppin 	  = (responsed.NanoAppin) ? responsed.NanoAppin:null;
		    	//var NanoSetup 	  = (responsed.NanoSetup) ? responsed.NanoSetup:null;
		    	//var NanoPayment   = (responsed.NanoPayment) ? responsed.NanoPayment:null;
		    	var NanoMarket    = (responsed.NanoMarket) ? responsed.NanoMarket:null;
		    	
		    	//var appr_rate 	  = (NanoDashboard[0]) ? roundFixed(checkValue(NanoDashboard[3].Total), 0) + '%':0 + '%';
		    	//var dpd_rate  	  = (NanoDPD[4]) ? roundFixed(checkValue(NanoDPD[4].Total), 2) + '%':0 + '%';
		    	/*
	    		$('#nano_approved_perrate').text(appr_rate).addClass('animated fadeIn');
	    		$('#nano_dpd_perrate').text(dpd_rate).addClass('animated fadeIn');
	    			    		
	    		if(NanoSetup && NanoSetup.length > 0) {
	    			
	    			var target_setup = [];
	    			var actual_setup = [];
	
	    			var total_setup  = [];
	    			
	    			if(NanoSetup[0] !== undefined) {
	    				
	    				target_setup.push(
	    					[
	    					 	roundFixed(checkValue(NanoSetup[0].E), 0), 
	    					 	roundFixed(checkValue(NanoSetup[0].C), 0), 
	    					 	roundFixed(checkValue(NanoSetup[0].N), 0), 
	    					 	roundFixed(checkValue(NanoSetup[0].S), 0), 
	    					 	roundFixed(checkValue(NanoSetup[0].I), 0)
	    					 ]
	    				);
	    				
	    				actual_setup.push(
	    					[
	    					 	roundFixed(checkValue(NanoSetup[1].E), 0), 
	    					 	roundFixed(checkValue(NanoSetup[1].C), 0), 
	    					 	roundFixed(checkValue(NanoSetup[1].N), 0), 
	    					 	roundFixed(checkValue(NanoSetup[1].S), 0), 
	    					 	roundFixed(checkValue(NanoSetup[1].I), 0)
	    					 ]
	    				);
	    				
	    			} else {
	    				for(var i = 0; i <= 4; i++) { 
	    					target_setup.push(0);
	    					actual_setup.push(0);
			    		}
	    			}
	    			
	    			$.each(NanoSetup, function(index, value) { total_setup.push({ field: value.Appin_Unit, data: value.Total }); });
	    			
	    			// TOTAl PART	   			
		    		$('#nano_setup_actual').text(roundFixed(checkValue(total_setup[1].data), 0) + 'Mb').addClass('animated fadeIn');
		    		$('#nano_setup_target').text('Target ' + checkValue(total_setup[0].data) + 'Mb').addClass('animated fadeIn');
		    		$('#nano_setup_achieve').text('Ach. ' + checkValue(total_setup[2].data) + '%').addClass('animated fadeIn');
	    			
	    			
	    			// CHART PART 
		    		$('#nano_setup_chart').sparkline(target_setup[0], { 							
		    			type: 'bar', 				
		    			height: '60',
		    			barWidth: 10,
		    			barSpacing: 8,
		    			barColor: 'rgba(0, 0, 0, 0.2)',
		    			chartRangeMin: 0,
		    			tooltipPrefix: 'Target',
		    			tooltipSuffix: 'Mb',
		    			tooltipFormat: '{{prefix}} : {{value}} {{suffix}}'		
		    		});
		    	
		    		setTimeout(function() {
		    		
		    			$('#nano_setup_chart').sparkline(actual_setup[0], {
			    			composite: true,
			    			type: 'bar', 				
			    			height: '60',
			    			barWidth: 10,
			    			barSpacing: 8,
			    			barColor: 'rgba(255, 255, 255, 1)',
			    			chartRangeMin: 0,
			    			tooltipPrefix: 'Actual',
			    			tooltipSuffix: 'Mb',
			    			tooltipFormat: '{{prefix}} : {{value}} {{suffix}}'	
			    		});
		    			
		    			$('.nano_setup_val1').text(roundFixed(checkValue(NanoSetup[1].E), 0)).addClass('animated fadeIn');
	    				$('.nano_setup_val2').text(roundFixed(checkValue(NanoSetup[1].C), 0)).addClass('animated fadeIn');
	    				$('.nano_setup_val3').text(roundFixed(checkValue(NanoSetup[1].N), 0)).addClass('animated fadeIn');
	    				$('.nano_setup_val4').text(roundFixed(checkValue(NanoSetup[1].S), 0)).addClass('animated fadeIn');
	    				$('.nano_setup_val5').text(roundFixed(checkValue(NanoSetup[1].I), 0)).addClass('animated fadeIn');
		    			
		    		}, 4000);

	    		}
	    		
	    		if(NanoAppin && NanoAppin.length > 0) {
	    			
	    			var target_appin = [];
	    			var actual_appin = [];
	
	    			var total_appin  = [];
	    			
	    			if(NanoAppin[0] !== undefined) {
	    				
	    				target_appin.push(
	    					[
	    					 	roundFixed(checkValue(NanoAppin[0].E), 0), 
	    					 	roundFixed(checkValue(NanoAppin[0].C), 0), 
	    					 	roundFixed(checkValue(NanoAppin[0].N), 0), 
	    					 	roundFixed(checkValue(NanoAppin[0].S), 0), 
	    					 	roundFixed(checkValue(NanoAppin[0].I), 0)
	    					 ]
	    				);
	    				
	    				actual_appin.push(
	    					[
	    					 	roundFixed(checkValue(NanoAppin[1].E), 0), 
	    					 	roundFixed(checkValue(NanoAppin[1].C), 0), 
	    					 	roundFixed(checkValue(NanoAppin[1].N), 0), 
	    					 	roundFixed(checkValue(NanoAppin[1].S), 0), 
	    					 	roundFixed(checkValue(NanoAppin[1].I), 0)
	    					 ]
	    				);
	    				
	    			} else {
	    				for(var i = 0; i <= 4; i++) { 
	    					target_appin.push(0);
	    					actual_appin.push(0);
			    		}
	    			}
	    			
	    			$.each(NanoAppin, function(index, value) { total_appin.push({ field: value.Appin_Unit, data: value.Total }); });
	    			
	    			// TOTAl PART	   			
		    		$('#nano_appin_actual').text(roundFixed(checkValue(total_appin[1].data), 0)).addClass('animated fadeIn');
		    		$('#nano_appin_target').text('Target ' + checkValue(total_appin[0].data)).addClass('animated fadeIn');
		    		$('#nano_appin_achieve').text('Ach. ' + checkValue(total_appin[2].data) + '%').addClass('animated fadeIn');
	    			
	    			
	    			// CHART PART 
		    		$('#nano_appin_chart').sparkline(target_appin[0], { 							
		    			type: 'bar', 				
		    			height: '60',
		    			barWidth: 10,
		    			barSpacing: 8,
		    			barColor: 'rgba(0, 0, 0, 0.2)',
		    			chartRangeMin: 0,
		    			tooltipPrefix: 'Target',
		    			tooltipSuffix: 'App',
		    			tooltipFormat: '{{prefix}} : {{value}} {{suffix}}'		
		    		});
		    	
		    		setTimeout(function() {
		    		
		    			$('#nano_appin_chart').sparkline(actual_appin[0], {
			    			composite: true,
			    			type: 'bar', 				
			    			height: '60',
			    			barWidth: 10,
			    			barSpacing: 8,
			    			barColor: 'rgba(255, 255, 255, 1)',
			    			chartRangeMin: 0,
			    			tooltipPrefix: 'Actual',
			    			tooltipSuffix: 'App',
			    			tooltipFormat: '{{prefix}} : {{value}} {{suffix}}'	
			    		});
		    			
		    			$('.nano_appin_val1').text(roundFixed(checkValue(NanoAppin[1].E), 0)).addClass('animated fadeIn');
	    				$('.nano_appin_val2').text(roundFixed(checkValue(NanoAppin[1].C), 0)).addClass('animated fadeIn');
	    				$('.nano_appin_val3').text(roundFixed(checkValue(NanoAppin[1].N), 0)).addClass('animated fadeIn');
	    				$('.nano_appin_val4').text(roundFixed(checkValue(NanoAppin[1].S), 0)).addClass('animated fadeIn');
	    				$('.nano_appin_val5').text(roundFixed(checkValue(NanoAppin[1].I), 0)).addClass('animated fadeIn');
		    			
		    		}, 4000);
		    	
		    		if(NanoPayment && NanoPayment.length > 0) { nano_traffic_chart(NanoPayment); }
		    		*/
		    	
		    		//if(NanoMarket && NanoMarket.length > 0) { loadMarketPenetrationChart(NanoMarket); }
		    		
	    		//}
	 
		    },
		    complete:function() {		    	
		    	$.dequeue(this);
		    },
		    error: function (error) {
		 	    console.log(error);   
		    }
		});
		
	}

	loadNanoData();
		
	function loadMarketPenetrationChart(market_data) {

		var setup  = [];
		var fail   = [];
		var penper = [];
		
		if(market_data[0] !== undefined) {
			
			setup.push(
				[
				 	roundFixed(checkValue(market_data[1].E), 0), 
				 	roundFixed(checkValue(market_data[1].C), 0), 
				 	roundFixed(checkValue(market_data[1].N), 0), 
				 	roundFixed(checkValue(market_data[1].S), 0), 
				 	roundFixed(checkValue(market_data[1].I), 0)
				 ]
			);
			
			fail.push(
				[
				 	roundFixed(checkValue(market_data[2].E), 0), 
				 	roundFixed(checkValue(market_data[2].C), 0), 
				 	roundFixed(checkValue(market_data[2].N), 0), 
				 	roundFixed(checkValue(market_data[2].S), 0), 
				 	roundFixed(checkValue(market_data[2].I), 0)
				 ]
			);
			
			penper.push(
				[
				 	roundFixed(checkValue(market_data[3].E), 1), 
				 	roundFixed(checkValue(market_data[3].C), 1), 
				 	roundFixed(checkValue(market_data[3].N), 1), 
				 	roundFixed(checkValue(market_data[3].S), 1), 
				 	roundFixed(checkValue(market_data[3].I), 1)
				 ]
			);
			
		} else {
		
			for(var i = 0; i <= 4; i++) { 
				setup.push(0);
				fail.push(0);
				penper.push(0);
    		}
			
		}
		
		$('#MarketShop').text(currencyFormat(roundFixed(checkValue(market_data[0].Total), 0), 0)).addClass('animated fadeIn');
		$('#MKTPenRate').text(roundFixed(checkValue(market_data[3].Total), 1) + '%').addClass('animated fadeIn');
	
		if(setup[0] !== undefined) {

			var i = 1;
			if(penper[0] !== undefined) {
				$.each(penper[0], function(index, value) {
					$('.nano_atlabel' + i + ' > small').text(formatRegion[index]);		
					$('.nano_atPercent' + i).text(penper[0][index] + '%');					
					i++;
				});
			}
			
			// + moment().format('MMM').toUpperCase(),
			var chartData = {
				labels: formatRegion,
		  		datasets : [
		  			{
		  				label: 'Set up', 
		  		        backgroundColor: "rgba(255, 255, 255, 1)",
		  				data : fail[0]
		  			},
		  			{
		  				label: 'แผลตลาดทั้งหมด',
		  				backgroundColor : "rgba(0, 0, 0, .2)",
		  				data : setup[0]
		  			}
		  		]
		  	};
			
			var instant = document.getElementById('nano_market_penetrationchart');
			var bar_horizontal = new Chart(instant, {
			    type: 'horizontalBar',
			    data: chartData,
			    options: {
			    	legend: { display: false },				    
			    	tooltips: {
		            	enabled: true,
		            	titleFontSize: 8,
		                bodyFontSize: 8,
		                caretSize: 5,
		                cornerRadius: 0,
		                backgroundColor: 'rgba(0, 0, 0, .6)',
		                callbacks: {     
		                	title: function (tooltipItems, data) { return null },			                    
		                    label: function (tooltipItems, data) {
		                         return data.datasets[tooltipItems.datasetIndex].label + ' : ' + roundFixed(checkValue(data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index]), 0);
		                    }			                    
	                    }
		            },
			    	scales: {	
	                    xAxes: [{     
	                        display: false,		                 
	                        scaleLabel: {}          
	                    }],
	                    yAxes: [{
	                    	categoryPercentage: 0.75,
	                    	ticks: { 
	                    		beginAtZero: true, 
	                            fontColor: '#FA6800'
	                    	},                    		
	                        display: false,
	                        stacked: true,
	                        scaleLabel: {
	                        	fontColor: fontColor,
	                        	fontSize: '9px'
	                        },
	                        gridLines: { display: false },
	                        
	                    }]
	                }
			    }
			});

		}
		
	}
    
    // END NEW ZONE
   
    loadMocklist('empoption_list', 'whiteboard');
    loadMocklist('collection_filter', 'collection');

    $.queue($('span[id="app_progress_container"]'), function() {	
    	var emp_code = $('#empprofile_identity').val();
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/pcis/defenddashboard/' + emp_code,
	        type: "GET",
		    success: function (resp) {
		    	var DefendInformation		= (resp && resp.Information[0] !== undefined) ? resp.Information[0]:null;
		    	var ProgressInfoByRegion	= (resp && resp.ProgressInfoByRegion !== undefined) ? resp.ProgressInfoByRegion:null;
		    	
		    	if(DefendInformation) {		    		
		    		$('.def_newVal1').text( parseInt(checkValue(DefendInformation.Draft)) );
		    		$('.def_newVal2').text( parseInt(checkValue(DefendInformation.MgrReturn)) );
		    		
		    		$('#defend_completedActual').text( parseInt(checkValue(DefendInformation.CA)) );
		    		$('#defend_completedPercent').text('CA PROCESS (' + roundFixed(checkValue(DefendInformation.CAPercent), 0) + '%)');
		    		
		    		$('#defend_usageActual').text( parseInt(checkValue(DefendInformation.RM)) );
		    		$('#defend_usagedPercent').text('RM PROCESS (' + roundFixed(checkValue(DefendInformation.RMPercent), 0) + '%)');		    		
		    	}

		    	if(ProgressInfoByRegion && ProgressInfoByRegion.length > 0) {
		    		defendCAChartRender('defend_consent_chartline', ProgressInfoByRegion);
		    		defendRMChartRender('defend_countanda2ca_chart', ProgressInfoByRegion);
		    	}
	
		    },
		    complete:function() { $.dequeue(this); },
		    error: function (error) { console.log(error); }	        
		});
	
	}());
    
    function defendCAChartRender(element, objVal) {
    	var getDataOverrall  = [];
    	var objectDefendData = [];
    	if(objVal.length > 0) {
    		var i = 1;
    		$.each(objVal, function(index, value) {
    			objectDefendData.push([parseInt(checkValue(value.CA)), parseInt(checkValue(value.SaleOnhand))]);
    			getDataOverrall.push(parseInt(checkValue(value.CA)));
    			getDataOverrall.push(parseInt(checkValue(value.SaleOnhand)));
    			
    			$('.cmpt_label' + i).text( roundFixed(checkValue(value.CAPercent), 0) );
	    		$('.cmpt_accu_label' + i).text( parseInt(checkValue(value.CA)) );
    			i++;
    			
    		});
    		
    	} else {
    		for(var i = 0; i < 4; i++) {
    			objectDefendData.push([0, 0]);
    			getDataOverrall.push(0);
    		}
    		
    	}
    
    	$('#' + element).sparkline(objectDefendData, { 
			type: 'bar',
			height: '60',
			barWidth: '12px',
			barSpacing: '8px',
			chartRangeMin: 0,
			chartRangeMax: setMaxValues(getDataOverrall),
			zeroColor: '#803F69',
			stackedBarColor: ['#FFFFFF', 'rgba(0, 0, 0, 0.1)'],
			myPrefixes: ['RM/MGR', 'CA'],
			tooltipFormatter: function(sp, options, fields) {

				var format =  $.spformat('<div class="jqsfield"><span style="color: {{color}}">&#9679;</span> {{myprefix}} : {{value}} Acc</div>');
				var result = '';
                $.each(fields, function(i, field) {
                    field.myprefix = options.get('myPrefixes')[i];
                    result += format.render(field, options.get('tooltipValueLookups'), options);
                })
                
                return result;
                
            }
		});

    }
    
    function defendRMChartRender(element, objVal) {
    	var getDataOverrall  = [];
    	var objectDefendData = [];
    	if(objVal.length > 0) {
    		var i = 1;
    		$.each(objVal, function(index, value) {
    			objectDefendData.push([parseInt(checkValue(value.RM)), parseInt(checkValue(value.MGR))]);
    			getDataOverrall.push(parseInt(checkValue(value.RM)));
    			getDataOverrall.push(parseInt(checkValue(value.MGR)));
    			
    			$('.defendLabelAt_' + i).text( roundFixed(checkValue(value.RMPercent), 0) );
	    		$('.defendActualLabel' + i).text( parseInt(checkValue(value.RM)) );
    			i++;
    			
    		});
    		
    	} else {
    		for(var i = 0; i < 4; i++) {
    			objectDefendData.push([0, 0]);
    			getDataOverrall.push(0);
    		}
    		
    	}
    
    	$('#' + element).sparkline(objectDefendData, { 
			type: 'bar',
			height: '60',
			barWidth: '12px',
			barSpacing: '8px',
			chartRangeMin: 0,
			chartRangeMax: setMaxValues(getDataOverrall),
			zeroColor: '#60a917',
			stackedBarColor: ['#FFFFFF', 'rgba(0, 0, 0, 0.1)'],
			myPrefixes: ['MGR', 'RM'],
			tooltipFormatter: function(sp, options, fields) {

				var format =  $.spformat('<div class="jqsfield"><span style="color: {{color}}">&#9679;</span> {{myprefix}} : {{value}} Acc</div>');
				var result = '';
                $.each(fields, function(i, field) {
                    field.myprefix = options.get('myPrefixes')[i];
                    result += format.render(field, options.get('tooltipValueLookups'), options);
                })
                
                return result;
                
            }
		});

    }
    
    /*
    $.queue($('span[id="app_progress_container"]'), function() {	
    	var emp_code = $('#empprofile_identity').val();
		$.ajax({
	      	url: 'http://172.17.9.94/newservices/LBServices.svc/reports/menu/defend/' + emp_code,
	        type: "GET",
		    success: function (responsed) {	

		    	var DefendDashboard		= (responsed.DefendDashboard[0] !== undefined) ? responsed.DefendDashboard:null;
		    	var CompleteDashboard	= (responsed.DefendComplete[0] !== undefined) ? responsed.DefendComplete[0]:null;
		    	var DefendCountRegion	= (responsed.DefendCountRegion[0] !== undefined) ? responsed.DefendCountRegion:null;
		    	var PercentCompleted	= (responsed.DefendCompletedPercentage[0] !== undefined) ? responsed.DefendCompletedPercentage:null;
		    	var DefendSubmitDaily	= (responsed.DefendSubmitDaily[0] !== undefined) ? responsed.DefendSubmitDaily:null;
		    	var DefendUsage			= (responsed.DefendCountVSA2CA[0] !== undefined) ? responsed.DefendCountVSA2CA:null;
		    	
		    	if(DefendDashboard) {
		    		$('.def_newVal').text( parseInt(checkValue(DefendDashboard[0].TotalNewApp)) );
		    	}
		    	
		    	if(CompleteDashboard) {
		    		$('#defend_completedActual').text(parseInt(checkValue(CompleteDashboard.TotalActiveApp)));
		    		$('#defend_completedPercent').text('CA PROCCESS (' + roundFixed(checkValue(CompleteDashboard.CompletedPercents), 0) + '%)');
		    	}
		    	
		    	defendChartRender('defend_consent_chart', PercentCompleted, DefendSubmitDaily);
		    	defendCountA2CARender('defend_countanda2ca_chart', DefendCountRegion, DefendUsage);		    	
		    
		    },
		    complete:function() { $.dequeue(this); },
		    error: function (error) { console.log(error); }	        
		});
	
	}());
	
	function defendChartRender(element, objVal, objDaily) {
  
    	var sort_by = function(field, reverse, primer) {
		    var key = primer ? 
		       function(x) {return primer(x[field])} : 
		       function(x) {return x[field]};

		    reverse = !reverse ? 1 : -1;

		    return function (a, b) {
		       return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
		    } 
    	}
    				    	
    	var removeByAttr = function(arr, attr, value){
    	    var i = arr.length;
    	    while(i--){
    	       if( arr[i] 
    	           && arr[i].hasOwnProperty(attr) 
    	           && (arguments.length > 2 && arr[i][attr] === value ) ){ 

    	           arr.splice(i,1);

    	       }
    	    }
    	    return arr;
    	}
    	
    	var daysInMonth = function(month,year) {
    	    return new Date(year, month, 0).getDate();
    	}
   	
    	var pending_data = [];
    	var approve_data = [];
    	var reject_data  = [];
    	var accumulate	 = [];
    	var incpmt_data  = [];
    	var daily_data	 = { label: [], data:[] };
    	
    	if(objVal && objVal.length > 0) {       
    		var i = 1; 
         	$.each(objVal, function(index, value) {  

         		$('span.cmpt_label' + i).text(roundFixed(value.CompletedPercentage, 0));
         		$('span.cmpt_accu_label' + i).text(value.Accumulate);    
         	         		         		
         		accumulate.push(checkValue(value.Accumulate));
         		incpmt_data.push(checkValue(value.CompletedMth));	
         		
         	 	i++;

         	});

        }
    	
    	var day_index  = 1;
		var Data_Daily = { label: [], data: [] };
    	for(var i = 0; i < daysInMonth(moment().format('MM'), moment().format('YYYY')); i++) {

    		var full_date    = new Date(year, month, day_index);
    		var objLabel 	 = $.extend({}, daily_data.label);
    		var objData 	 = $.extend({}, daily_data.data);
    		
			objLabel.Day 	 = day_index.toString();
			objLabel.DayName = full_date.toString().substring(0, 3);
			
			objData.Day		 = day_index.toString();
			objData.Val		 = 0;
			
			Data_Daily.label.push(objLabel);
			Data_Daily.data.push(objData);
    		
    		day_index++;	
    	
		}
    	
    	if(objDaily && objDaily.length > 0) {
         	$.each(objDaily, function(index, value) {
         		var result = $.grep(Data_Daily.data, function(item){ return item.Day == value.DD; });
         		if(result[0]) {
         			result[0].Val = parseInt(checkValue(value.Entries));        
         		}      
         	});
 	    	
        }
    	
    	var getDataOverrall  = [];
    	var objectDefendData = [];
    	if(objVal.length > 0) {

    		$.each(objVal, function(index, value) {
    			objectDefendData.push([parseInt(checkValue(value.CompletedMth)), parseInt(checkValue(value.Accumulate))]);
    			getDataOverrall.push(parseInt(checkValue(value.CompletedMth)));
    			getDataOverrall.push(parseInt(checkValue(value.Accumulate)));   
    		});
    		
    	} else {
    		
    		for(var i = 0; i < 4; i++) {
    			objectDefendData.push([0, 0]);
    			getDataOverrall.push(0);
    		}
    		
    	}
    	
    	$('#defend_consent_chartline').sparkline(objectDefendData, { 
			type: 'bar',
			height: '60',
			barWidth: '12px',
			barSpacing: '8px',
			chartRangeMin: 0,
			chartRangeMax: setMaxValues(getDataOverrall),
			zeroColor: '#803F69',
			stackedBarColor: ['#FFFFFF', 'rgba(0, 0, 0, 0.1)'],
			myPrefixes: ['Active', 'Inactive'],
			tooltipFormatter: function(sp, options, fields) {

				var format =  $.spformat('<div class="jqsfield"><span style="color: {{color}}">&#9679;</span> {{myprefix}} : {{value}} Acc</div>');
				var result = '';
                $.each(fields, function(i, field) {
                    field.myprefix = options.get('myPrefixes')[i];
                    result += format.render(field, options.get('tooltipValueLookups'), options);
                })
                
                return result;
                
            }
		});
    	
    	
    	$('.defend_consent_label').html('On CA Proccess');
    
    }
    
    function defendCountA2CARender(element, data_list, data_usage) {
    	
    	var overall_data = [];
    	var object_usage = [];
    	if(data_list.length > 0) {

    		var $i = 1;
    		$.each(data_list, function(index, value) {
    			object_usage.push([parseInt(checkValue(value.DefendCount)), parseInt(checkValue(value.A2CA))]);    			
    			overall_data.push( parseInt(checkValue(value.DefendCount)) );
    			overall_data.push( parseInt(checkValue(value.A2CA)) );
    		
    			$('.defendLabelAt_' + $i).text(roundFixed(value.Achieve, 0)).addClass('animated fadeInDown');
    			$('.defendActualLabel' + $i).text(checkValue(value.DefendCount)).addClass('animated fadeInDown');
    			
    			$i++;
    			
    		});
    		    		
    		if(data_usage.length > 0) {
    			var usage_temp = (( parseInt(checkValue(data_usage[0].DefendCount)) / parseInt(checkValue(data_usage[0].A2CA)) ) * 100);    
    			var usage_percentage = checkValue(usage_temp) ? roundFixed(usage_temp, 0):0;
    			
    			$('#defend_usageActual').text( parseInt(checkValue(data_usage[0].DefendCount)) ).addClass('animated fadeInDown');
    			$('#defend_usagedPercent').text('RM PROCCESS (' + usage_percentage + '%)').addClass('animated fadeInDown');
    			
    		}
    		
    	} else {
    		
    		for(var i = 0; i < 4; i++) {
    			object_usage.push([0, 0]); 
        		overall_data.push(0);
    		}
    		
    	}
    	
    	$('#' + element).sparkline(object_usage, { 
			type: 'bar',
			height: '60',
			barWidth: '12px',
			barSpacing: '8px',
			chartRangeMin: 0,
			chartRangeMax: setMaxValues(overall_data),
			zeroColor: '#60A917',
			stackedBarColor: ['#FFFFFF', 'rgba(0, 0, 0, 0.1)'],
			myPrefixes: ['A2CA', 'DEFEND'],
			tooltipFormatter: function(sp, options, fields) {

				var format =  $.spformat('<div class="jqsfield"><span style="color: {{color}}">&#9679;</span> {{myprefix}} : {{value}} Acc</div>');
				var result = '';
                $.each(fields, function(i, field) {
                    field.myprefix = options.get('myPrefixes')[i];
                    result += format.render(field, options.get('tooltipValueLookups'), options);
                })
                
                return result;
                
            }
		});

    	$('.defend_countanda2ca_label').html('On RM Proccess');
    	
    }
	*/
    
	$('#empoption_list').change(function() { loadWhiteboard( $('#empoption_list').val()); });
    
	// #### FUNCTION 
	function chartBarWidthResponsive(resp) {
		var length = resp.length;
		switch(length) {
			case 6:		
				return '10px';
			break;
			case 5:		
				return '12px';
				break;
			case 4:
				return '14px';
				break;
			case 3:
				return '18px';
				break;
			case 2:
				return '30x';
			break;
				
		}
	}
	
	function chartBarSpectResponsive(resp) {
		var length = resp.length;
		switch(length) {
			case 6:
				return '6px';
			break;
			case 5:
				return '8px';
				break;
			case 4:
				return '12px';
				break;
			case 3:
				return '18px';
				break;
			case 2:
				return '25px';
				break;
				
		}
	}
	
	function chartLabelTopResponsive(resp, value, index, mode) {
		var length = resp.length;
		switch(length) {
			case 6:
				if(index == 1) $('.' + mode + '_' + index).css({ 'margin-left': '31px' });
				if(index == 2) $('.' + mode + '_' + index).css('margin-left', '-5px');
				if(index >= 3) $('.' + mode + '_' + index).css('margin-left', '-4px');	
				return value;
			break;
			case 4:
				if(index == 1) $('.' + mode + '_' + index).css({ 'margin-left': '31px' });
				if(index >= 2) $('.' + mode + '_' + index).css('margin-left', '5px');	
				return value;
				break;
			case 3:
				if(index == 1) $('.' + mode + '_' + index).css({ 'margin-left': '33px' });
				if(index >= 2) $('.' + mode + '_' + index).css({ 'margin-left': '15px' });
				return value;
				break;
			case 2:
				$('.' + index).css('margin-left', '40px');
				if(index >= 2) $('.' + mode + '_' + index).css({ 'margin-top': '-10px', 'margin-left': '88px' });
				
				return value;
				break;
			default:
				return value;				
				break;
		}
	}
			
	function charLabelResponsive(resp, name, index) {
		var length 		   = resp.length;
		var pattern 	   = new RegExp("[\.]$");
		var str_pattern    = pattern.test(name);
		var str_text	   = '';
		
		if(str_pattern) {
			var string_text	  = name.split(" ");
			str_text		  = string_text[0].substr(0, 1) + string_text[1].substr(0, 1);
		} else {
			str_text		  = name;
		}
		
		switch(length) { 
			case 6:
				if(index == 1) $('.sb_vollabel_auth_' + index + ', .a2ca_labelauth_' + index).css('margin-left', '26px');
				if(index >= 2 && index <= 4) $('.sb_vollabel_auth_' + index + ', .a2ca_labelauth_' + index).css('margin-left', '-3px');								
				if(index >= 5) $('.sb_vollabel_auth_' + index + ', .a2ca_labelauth_' + index).css('margin-left', '-2px');
				if(index == 5) $('.sb_vollabel_auth_' + index + ', .a2ca_labelauth_' + index).css('margin-left', '-5px');
				if(str_pattern) {	
					return str_text;					
				} else {					
					return name.substr(0, 2);
				}	
			break;
			case 4:	
				if(index >= 2) $('.sb_vollabel_auth_' + index + ', .a2ca_labelauth_' + index).css('margin-left', '7px');	
				if(str_pattern) {	
					return str_text;					
				} else {					
					return name.substr(0, 3);
				}				
								
			break;
			case 3:
				if(str_pattern) {
					if(index >= 2) $('.sb_vollabel_auth_' + index + ', .a2ca_labelauth_' + index).css('margin-left', '18px');	
					return str_text;					
				} else {
					if(index >= 2) $('.sb_vollabel_auth_' + index + ', .a2ca_labelauth_' + index).css('margin-left', '15px');	
					return name.substr(0, 5);	
				}
							
			break;
			case 2:				
				if(index >= 2) $('.sb_vollabel_auth_' + index + ', .a2ca_labelauth_' + index).css('margin-left', '40px');
				if(str_pattern) {
					var name_verify = '';
					if(in_array(str_text, ['PK'])) {
						name_verify = str_text + index;
					} else {
						name_verify = str_text;
					}					
					return name_verify;	
				} else {									
					return name;
				}
				
			break;			
			default:
				if(str_pattern) {
					return str_text;					
				} else {
					if(in_array(name, ['East', 'Central', 'North', 'South', 'N/E'])) {
						if(name == 'N/E') return 'I';
						else return name.substr(0, 1);
					} else {
						return name.substr(0, 3);
					}
				}
			break;
				
		}
		
	}
	
	function chartFrequencyResponsive(resp) {
		if(resp && resp.length > 0) {
			var length = resp.length;
			switch(length) {		
				case 5:
					return ['4em', 100];
					break;	
				case 4:
					return ['3em', 80];
					break;
				case 3:
					return ['2em', 50];
					break;
				case 2:
					return ['1em', 25];
					break;				
				default: 
					return ['4em', 100];
				break;	
					
			}
		
		}		
	}
	
	function checkValue(values) {
		if(!values) return 0;
		else return values;
	}
	
	function escape_keyword(text) {

		if(!text) {
			return 0;
		} else {
			return text.replace('Time', '')
			.replace('App', '')
			.replace('List', '')
			.replace('%', '')
			.replace('Kb', '')	
			.replace('KB', '')		
			.replace('Mb', '')
			.replace('Acc', '').trim();
		}
		
	}
	
	function currencyFormat (num, format) {
	    return num.toFixed(format).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	
	function roundFixed(value, decimals) {
	    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
	}
	
	function restnumber(value, type) {
		var mock = '';
		if(type !== '') {
			if(in_array(type, ['Mb', 'App', 'Acc', ' Acc', 'Set', '%'])) {
				mock = type
			}
		}
			
    	if(value) {
    		
    		if(value >= 100.00) {
    			return roundFixed(value, 0) + mock;
    		} else {
    			return roundFixed(value, 1) + mock;
    		}
    		
    	} else {
    		return 0 + mock;
    	}
    }
	
	function getIndex(arr, val) {
	    for (var i = 0; i < arr.length; i++) {
	        if (arr[i] === String(val)) {
	            return i;
	        }
	    }
	}
	
	function in_array(needle, haystack, argStrict) {

		var key = '', strict = !! argStrict;

		  if (strict) {
		    for (key in haystack) {
		      if (haystack[key] === needle) {
		        return true;
		      }
		    }
		  } else {
		    for (key in haystack) {
		      if (haystack[key] == needle) {
		        return true;
		      }
		    }
		}
		
		return false;
	}
	
	function setMaxValues(values) {

		if(values[0] === undefined) {
			return 20;
			
		} else {
			
			var max = arrayMax(values);
			
			if(max >= 100) return values + 20;
			else if(max >= 80) return 100;
			else if(max >= 60) return 80;
			else if(max >= 40) return 60;
			else if(max >= 20) return 40;
			else return 20;

		}

	}
	
	function compareData(current, last, mode = '') {

		if(current == '' || last == '') {
			return '';
			
		} else {
			
			if(mode == 'html') {
				
				if(last == 'P') 
					return 'Today : <span style="font-weight: bold;">' + current + ' <span class="fa fa-caret-up fg-green" style="font-size: 1.5em !important; margin-top: 1px; margin-left: 3px;"></span></span>';
				else if(last = 'N')
					return 'Today : <span style="font-weight: bold;">' + current + ' <span class="fa fa-caret-down fg-lightRed" style="font-size: 1.5em !important; margin-left: 3px;"></span></span>'
				else
					return '-';
				

			} else {
				
				if(current > last)
					return 'fa fa-caret-up fg-emerald animated bounceInRight';
				else if(last > current)
					return 'fa fa-caret-down fg-red animated bounceInRight'
				else
					return '';
				
				
			}
			
			
			
		}
		
	}
	
	function arrayMax(array) {
	    return array.reduce(function(a, b) {
	       return Math.max(a, b);
	    });
	}
	
	function arrayMin(array) {
	    return array.reduce(function(a, b) {
	       return Math.min(a, b);
	    });
	}
	
	$.datepicker.regional['en'] = {
	    days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
	    daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
	    daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
	    months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
	    monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
	    today: "Today",
	    clear: "Clear",
	    format: "mm/dd/yyyy",
	    titleFormat: "MM yyyy",
	    weekStart: 0
	};
	
	function loadMocklist(element, mode) {
		
		$(function() {
			var config	= {
				single: true, 
				width: '100%', 
				filter: true,
				position: 'top'
			}
			
			var emps_code = ($('#' + element).val() !== null) ? $('#' + element).val():$('#empprofile_identity').val();
			var role_auth = $('#emp_role').val();
			var urls = (mode == 'whiteboard') ? 'index.php/dataloads/getNewEmployeeDrawdownList':'index.php/dataloads/getEmployeeDrawdownList';
			
			$.ajax({
		      	url: pathFixed + urls + '?_=' + new Date().getTime(),
		        type: "POST",
		        data: { 
		        	empcode: emps_code,
		        	role: role_auth,
		        	viewmode: mode
		        },
			    success: function (responsed) {				    	
					if(responsed['data']) {
						
						if(in_array(mode, ['collection'])) {
							var fix_data = (responsed['overview']) ? responsed['overview']:null;
							if(fix_data) {
								$('#' + element).prepend('<option value="' + fix_data.EmployeeCode + '">' + fix_data.FullNameTh + '</option>');
							}							
						}
						
						$.each(responsed['data'], function(index, value) {
							$('#' + element).append('<option value="' + value['EmployeeCode'] + '">' + checkNameRender(value, role_auth) + '</option>');
						});
					
						$('#' + element).change(function() { }).multipleSelect(config).multipleSelect('refresh');
						$('#ms_span' + element).parent().css('max-width', '250px')
					}
					
					function checkNameRender(value, role_auth) {
						if(role_auth == 'bm_role') {
							return value['FullNameTh'] + ' (' + value['PositionShort'] + ')';
						} else {
							if(in_array(value.PositionShort, ['BM'])) {
								return value['BranchName']  + ' (' + value['AreaName'] + ')';
							} else {
								return value['FullNameTh'] + ' (' + value['PositionShort'] + ')';
							}
						}
		
					}
			    	
			    },	   
			    complete:function() {},
			    error: function (error) { console.log(error); }	        
			});
		});
		
	}
	
});



setTimeout(function() { 
	$('#fttab').css('margin-left', '-70px'); 
	$('body').css('background', 'transparent');
}, 500);

