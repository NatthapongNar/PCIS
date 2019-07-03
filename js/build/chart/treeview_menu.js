var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathFixed[i]; pathFixed += "/"; }
var query  = getQueryParams(document.location.search);

var path 			= [pathArray[4]];
var url_path 		= 'http://172.17.9.94/pcisservices/PCISService.svc/';
var path_link 		= "http://172.17.9.94/newservices/LBServices.svc/";
var urlProfile  	= url_path + "GetKPI00ProfileReport";

// Get Profiler
function loadProfile(url, condition) {
	
	// Profile
    $.ajax({
       url: url,
       data: { RMCode: condition },
       type: "GET",
       jsonpCallback: "my_profile",
       dataType: "jsonp",
       crossDomain: true,
	   beforeSend:function() {	  	
	   		
	   		if(query['relsub'] !== undefined) {
	   			miniProfile(url, query['relsub']);
	   			$('div[direct-chat-to]').attr('direct-chat-to', query['relsub']);
	   		} else { miniProfile(url, condition); } 
	   		
	   },
       success: function (responsed) {    	   
    	   //console.log(responsed.Data);
           
           var result = responsed.Data;
           if (result.length > 0) {
        	   
        	   var corp		= result[0].PositionNameEng + ' (' + result[0].Position + ')';
        	   var brn_info = result[0].BranchNameEng + ' (' + result[0].AreaCode + ')';
        	   var mobile	= result[0].Mobile + ' (' + result[0].Nickname + ')';

        	   $('#present').attr('onclick', 'reload(\'' + pathArray[4] + '\', ' + result[0].EmployeeCode + ', \'' + result[0].PositionRef + '\')');
        	   $('#branch_info').text(brn_info);
        	   $('#corperate_info').text(corp);
        	   $("#personal_code").text(result[0].EmployeeCode);
        	   $('#personal_phone').text(mobile);
        	   $(".wrapper_span").find('span').text(result[0].FullNameEng);
               $("#personal_name").text(result[0].FullNameEng);
               $(".profilePicture").attr("src", result[0].UserImagePath);                     
               $("#personal_exp .personal_text").text('Experience : ' + result[0].WorkingYMD + ' (Y M D)') ;
               $("#personal_startwork .personal_text").text('Start Work : ' + result[0].StartWork);      
    
           }

       },
       error: function (error) {
           
       }
       
   });
	
}

// individual
function reload(getPages, data, position) {

	$('#emp_id').val(data);	
  	switch(getPages) {
  		case 'gridDataList':
  			
  			$('#event_mode').val('individual');
  			var grid = $('#grid_container');		
  			
  			grid.setGridParam({postData: null});
  			if(position == 'RD') {
  				grid.jqGrid('setGridParam', { postData: { "EMPCode": data, 'BranchFlag': '1' } }).trigger('reloadGrid'); 
  			} else {
  				grid.jqGrid('setGridParam', { postData: { "EMPCode": data } }).trigger('reloadGrid');
  			}
  			 
  			
  			grid.jqGrid('hideCol', ['KPINO', 'Region', 'Lending']); 
  			
  			var urlProfile  	= url_path + "GetKPI00ProfileReport";
  			miniProfile(urlProfile, data); // Load mini profile
  		
  			$('div[direct-chat-to]').attr('direct-chat-to', data);

  			var panel = $("#menu").data( "mmenu" );  			
  			panel.close();
  			  	  			
  			break;
  		case 'onloadKPI': 
  		case 'dashboardchart':

  			//*** Loading: inside content chart	 ::::::::::::::::::::::::::::::::::::::::::::::::::::
  			var urlProfile  	= url_path + "GetKPI00ProfileReport";
  				// Function :
  				miniProfile(urlProfile, data);  


  			// Load Prospect and NCB 
  			var urlProspect 	= url_path + "GetKPI01ProspectListReport",
  				urlNCBConsent	= url_path + "GetKPI17NCBReport";
  				// Function :
  				loadProspectTargetList(urlProspect, data);
  				loadNCBOnloadList(urlNCBConsent, data);


  			var urlLoanGrid = url_path + "GetKPI08LoanMonitoringReport";
  				// Function :
  				loadLoanMonitoring(urlLoanGrid, data);	
  			
  			

  			//*** Loading: inside right chart	::::::::::::::::::::::::::::::::::::::::::::::::::::::
  			var urlAvgAppToCA	= url_path + "GetKPIKPI12AppToCAReport",
  				urlAvgApproval	= url_path + "GetKPI13AppvRateReport",
  				urlAvgDrawdown	= url_path + "GetKPI11DrawdownReport",
  				urlAvgTicket	= url_path + "GetKPI14TicketSizeReport";

  			var urlGetInsurance	= url_path + "GetKPI15MRTACashyReport";
  				// Function :
  				loadGaugeAverage([urlAvgAppToCA, urlAvgApproval, urlAvgDrawdown, urlAvgTicket], data); // Average
  				loadGaugeInsurance(urlGetInsurance, data, true); // Insurance

  			var urlAppQuality   = url_path + "GetKPI16A2CAQualityAppReport";
  				loadApp2CAWithQuality(urlAppQuality, data); 

  			var urlTarget		= url_path + "GetKPI05ActualDrawdownReport";  		
  				loadActualTarget(urlTarget, data);

  			var urlApprovedRate	= url_path + "GetKPI03StatusReport";
  				loadApprovelRate(urlApprovedRate, data);
  			

  			break;

	}

}

function switchModeGrid(getPages, data) {
	
	$('#emp_id').val(data);	
  	switch(getPages) {
		case 'gridDataList':
			
			$('div[direct-chat-to]').attr('direct-chat-to', data);
			$('#btnSwitch').removeAttr('onclick').attr('onclick', '')
						
			var grid = $('#grid_container');
			grid.setGridParam({postData: null});
  			grid.jqGrid('setGridParam', { postData: { "EMPCode": data, 'BranchFlag': '1' } }).trigger('reloadGrid'); 
  			
  			grid.jqGrid('hideCol', ['KPINO', 'Region', 'Lending']); 
  			
  			var navSwitchMode = //'<a href="#" style="text-decoration: none;" onclick="getRestructGridmode(\'' + getPages + '\', ' + data + ');"><i class="flaticon flaticon-banking2 fa-2x" style="color: #FFF; position: absolute; margin-top: -26.5px;"></i></a>'; //color: #8CBF26
  			'<a href="#" id="btnSwitch" style="text-decoration: none;" onclick="getRestructGridmode(\'' + getPages + '\', ' + data + ');">' +
			'<div>' +
				'<i class="flaticon flaticon-banking2 fa-2x"></i>' +
				'<span class="using_branchInfo" style="float: right; margin-left: 10px;">' +
					'<div class="using_branchname" style="font-weight: bold;"></div>' +
					'<div class="using_branchperiod"></div>' +
				'</span>' +
			'</div>' +				
			'</a>';
  			
  			$("#btnSwitcher").html(navSwitchMode);
 		    $("#btnSwitcher").addClass('tooltip-right marginLeftEasing10 marginRight10').attr('data-tooltip', 'Overview Summary');
 		    
 		    notif({
 		    	msg: "Overview Summary",
 		    	type: "success",
 		    	position: "center",
 		    	opacity: 1,
 		    	width: 300,
 		    	height: 50,
 		    	autohide: false
 			});
 		  
 		    var recheck = setInterval(function(e) {
 		    	if($('#load_grid_container').attr('style') == 'display: none;') {
 		    		stoprecheck_interval();
 		    	}
 		    	
 		    }, 1000);
 		    
 		    function stoprecheck_interval() {
 			   setTimeout(function(){
 	 			  $('#ui_notifIt').fadeOut('fast');
 				  
 			   }, 1000);
 			   clearInterval(recheck);
 		    }
 		  
 		    reloadMiniProfile(urlProfile, data)
 		    displayBranchProfile(urlProfile, data);
 		    
  			//$('#chart_ref').attr('href', pathFixed + 'report/dashboardchart?rel=' + data);
 		    
 		    // Set event mode
 		    $('#event_mode').val('branchs');
  			  			
  			var panel = $("#menu").data( "mmenu" );  			
  			panel.close();

  			break;
  	
  	
  	}	
	
}

function getRestructGridmode(getPages, data) {
	
	$('#emp_id').val(data);	
  	switch(getPages) {
  		case 'gridDataList':
  		
  			var grid = $('#grid_container');		
  			grid.setGridParam({postData: null});
  			grid.jqGrid('setGridParam', { postData: { "EMPCode": data } }).trigger('reloadGrid'); 
		
			$('div[direct-chat-to]').attr('direct-chat-to', data);
		
  			var navSwitchMode = '<a href="#" style="text-decoration: none;" onclick="switchModeGrid(\'' + getPages + '\', ' + data + ');"><i class="flaticon flaticon-banking2 fa-2x" style="color: #FFF; position: absolute; margin-top: -26.5px;"></i></a>';
  			$("#btnSwitcher").html(navSwitchMode);
  			$("#btnSwitcher").addClass('tooltip-right marginLeft10 marginRight10').attr('data-tooltip', 'Individual Mode');
  			 
  			notif({
  		    	msg: "Individual Mode",
  		    	type: "success",
  		    	position: "center",
  		    	opacity: 1,
  		    	width: 300,
  		    	height: 50,
  		    	autohide: false
  			});
  			 
  		 	var recheck = setInterval(function(e) {
		    	if($('#load_grid_container').attr('style') == 'display: none;') {
		    		stoprecheck_interval();
		    	}
		    	
		    }, 1000);
		    
		    function stoprecheck_interval() {
			   setTimeout(function(){
	 			  $('#ui_notifIt').fadeOut('fast');
				  
			   }, 1000);
			   clearInterval(recheck);
		    }
		  
		    reloadMiniProfile(urlProfile, data)
			//$('#chart_ref').attr('href', pathFixed + 'report/dashboardchart?rel=' + data);
		    
  			$('.using_branchname').empty();
  	    	$('.using_branchperiod').empty();

				
  	    	$('#event_mode').val('individual');
			var panel = $("#menu").data( "mmenu" );  			
			panel.close();
  	
  		break;
  	
  	
  	}
	
}

$(function() {
	
	var container = $('.panel-categories');	
	var mainList  = '';
	var subList	  = '';
	
	$.ajax({
		url: url_path + "GetUserRootTreeInformation", // UAT
	    data: { RMCode : $('#profiler').val() },
	    type: "GET",
	    jsonpCallback: "result_getAuthViews",
	    dataType: "jsonp",
	    crossDomain: true,
	   	beforeSend:function() {

	    },
	    progress: function(e) {
            //make sure we can compute the length
            
            if(e.lengthComputable) {
                //calculate the percentage loaded
                var pct = (e.loaded / e.total) * 100;

                //log percentage loaded
                //console.log(pct);
                $('#progress').html(pct.toPrecision(3) + '%');
            }
            //this usually happens when Content-Length isn't set
            else {
                console.warn('Content Length not reported!');
            }
        },
	    success: function (responsed) {    
	  
	    	  var elementRootTree = $("<ul></ul>"); // new script
	    	  if (responsed.Code == "200") {
	    		 
	    		  createNode(responsed.Data, "");
	    		  $('#subList').append(elementRootTree);
  
	          } else {
	              console.log(responsed.Message);
	          }
	    	  
	    	  function createNode(obj, elId) {
	    
	    		    var itemUl = elementRootTree;
	    		    var itemLi = null;
	   
	    		    if (elId != "") {
	    		        itemLi = elementRootTree.find("#" + elId);
	    		        
	    		        var position 	= (obj.PositionNameEng != null) ? obj.PositionNameEng:obj.Position;
	    		        var positionRef = (obj.PositionRef != null) ? ' (' + obj.PositionRef + ')':'';	    		        
	    		        var corp	 	=  position + positionRef;
	    		        
	    		        var baseoffice	= (obj.BranchNameEng != null) ? obj.BranchNameEng:obj.Ref01;
	    		        var shortcode	= (obj.AreaCode != null) ? ' - ' + obj.AreaCode:'';
	    	        	var brn_info 	= baseoffice + shortcode;
	    	        	
	    	        	var mobile	 	= (obj.Mobile != null) ? obj.Mobile:'' + (obj.Nickname != null) ? ' (' + obj.Nickname + ')':'';
	    	        	var exp		 	= (obj.WorkingYMD != null) ? 'Experience : ' + obj.WorkingYMD:'none';
	    	        	
	    	        	// condition expression
	    	        	var empcode 	= (obj.EmployeeCode != null) ? obj.EmployeeCode:'none';
	    	        	var empname 	= (obj.FullNameEng != null) ? obj.FullNameEng:obj.UserStatus;
	    	   
    	        		var supplement_mode;
	    	        	if(obj.PositionRef == 'BM' || obj.PositionRef == 'BM-Direct' || obj.Position == 'Branch Manager') {
	    	        		supplement_mode = '<a href="#" style="position: absolute; margin-top: -110px; margin-left: 110px;" onclick="switchModeGrid(\'' + pathArray[4] + '\', ' + obj.EmployeeCode + ', true);">' +
	    	        						  '<i class="flaticon flaticon-banking2" style="color: #ABABAB;" style="position: absolute; margin-top: -27px;"></i>' +
	    	        						  '</a>';
	    	        	} else {
	    	        		supplement_mode = '';
	    	        	}
	 
	    		        itemLi.append(	    		        	
	    		            '<a href="#/" style="text-decoration: none;" onclick="reload(\'' + pathArray[4] + '\', ' + obj.EmployeeCode + ', \'' + obj.PositionRef + '\');">' +
//		    		            '<span class="fa-stack fa-lg bg-black" style="position: absolute; margin-top: -5px; margin-left: 50px; font-size: 85%;">' +
//									'<i class="fa fa-circle bg-black fa-stack-2x" style="color: rgb(51, 188, 156); cursor: pointer;"></i>' +
//									'<i class="fa fa-line-chart fa-stack-1x"></i>' +
//								'</span>' +	
	    		            	'<div class="crop_li" style="border-radius: 50%; margin: 0 auto;">' +
		    		            	"<img src='" + obj.UserImagePath + "'>" +		
		    		            '</div>' +			    		           
		    		            '<small class="tooltip-top" data-tooltip="' + empcode + '"><b>' + empname + '</b></small>' +
		    		            "<br/>" +
		    		            '<small class="tooltip-top" data-tooltip="' + exp + '">' + corp + '</small>' +
		    		            "<br/>" +
		    		            '<small class="tooltip-top" data-tooltip="' + mobile + '">' + brn_info + '</small>' +
	    		            "</a>" +
	    		            supplement_mode + 
	    		            (obj.NodeItem.length > 0 ? "<div><ul></ul></div>" : "")
	    		        );
		    		 
	    		        itemUl = itemLi.find("ul");
	    		    }
	
	    		    if (obj.NodeItem.length > 0) {
	    		        $.each(obj.NodeItem, function (index, item) {
	    		            var rootId = elId + "" + (index + 1);
	    		            
	    		            itemUl.append("<li id='" + rootId + "' class=\"img text-center\"></li>");
	    		            createNode(item, rootId);
	    		            
	    		        });
	    		    }
	    		    else {
	    		        return false
	    		    }
	    	  };
    		  
	    	 
	    },
	    complete:function() {
	    	// load panel information
	    	loadPanelMenu();
	    	
	    },
	    error: function (error) {
	 	        
	    }
	        
	});
	
});

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

function loadPanelMenu() {

	$('nav#menu').mmenu({
		iconPanels: false,
		navbar: { title: false },
		navbars: [
		{			
			position: "top",
            content: [
                '<a href="#mm-1" data-target="#mm-1">' +
                	'<i class="flaticon flaticon-home168" style="!important; font-size: 1.7em; color: #FFF; font-weight: bold;"></i>' +
                '</a>',
                '<a href="#/">' +
                	'<i class="fa fa-filter" style="font-size: 1.7em; font-weight: bold;"></i>' +
                '</a>'
             ]
		}
		],
		counters: false,
		slidingSubmenus: true,
		extensions: ["theme-dark", "effect-zoom-menu", "effect-slide-listitems",, "pagedim-black", "border-full"]
		
	});

	var panel = $("#menu").data( "mmenu" );
	panel.close();
	/*
	switch(pathArray[4]) {
		case 'gridDataList':
			panel.open();
			break;
		default:
			panel.close();
			break;
	
	}
	*/

	panel.bind('opened', function () {
		$("#sidebar_icon").attr('data-rotate', 'true').rotate({ animateTo: 180, duration: 1000 });  

	});
	
	panel.bind('closed', function () {
		$("#sidebar_icon").attr('data-rotate', 'true').rotate({ animateTo: 360, duration: 1000 });    

	});
	
}

function miniProfile(url, condition) {
	
	$.ajax({
       url: url,
       data: { RMCode: condition },
       type: "GET",
       jsonpCallback: "my_miniprofile",
       dataType: "jsonp",
       crossDomain: true,
       success: function (responsed) {
    	       	 
           var result = responsed.Data;
           if (result.length > 0) {
        	   //console.log(result);
        	   var corp		= result[0].BranchNameEng + ' (Period ' + result[0].WorkingYMD + ')';
        	   var mobile	= result[0].Mobile + ' (' + result[0].Nickname + ')';
        	   
        	   var html = 
	           '<div class="crop_nav">' +
	           		'<span id="chat_state" class="chat-state"></span>' +
	   				'<div><img src="' + result[0].UserImagePath + '"></div>' +
	   		   '</div>' +        			
	   		   '<div class="using_desc marginLeft5">' +
	   		   		'<span><b class="tooltip-bottom" data-tooltip="' + mobile + '">' + result[0].FullNameEng.toUpperCase() + '</b> (' + result[0].Position + ') </span> <br/>' +
	   				'<span>' + corp + '</span>' +
	   		   '</div>';  
        	   
        	   var fullname = result[0].FullNameEng;
        	   if(fullname != '') {
        		   var str_split = fullname.split(" ");
        		   var rename = str_split[0] + ' ' + str_split[1].substr(0, 1) + '.';
        		   $('title').text('KPI - ' + rename);
        		   
        	   } else {
        		   $('title').text('KPI - ' + result[0].FullNameEng);
        	   }
        	   
        	   $('#position_title').val(result[0].Position);
                	   
        	   $('.using_information').html('');
        	   $(html).hide().appendTo(".using_information").fadeIn(1000);
        	  
    		   $('#btnSwitcher').empty().removeClass('tooltip-right marginLeftEasing10 marginRight10').removeAttr('data-tooltip');
    		   
        	   if(in_array(result[0].Position, ['BM', 'AM', 'RD', 'Admin-SFE', 'AMD']) || result[0].Telephone == 'SP') {
        		   
        		   var navSwitchMode = 
        		   		'<a href="#" id="btnSwitch" style="text-decoration: none;" onclick="switchModeGrid(\'' + pathArray[4] + '\', ' + result[0].EmployeeCode + ', true);">' +
        				'<div>' +
        					'<i class="flaticon flaticon-banking2 fa-2x"></i>' +
	        				'<span class="using_branchInfo" style="float: right; margin-left: 10px;">' +
	        					'<div class="using_branchname" style="font-weight: bold;"></div>' +
	        					'<div class="using_branchperiod"></div>' +
	        				'</span>' +
        				'</div>' +				
        				'</a>';
        		   
        		   setTimeout(function(){
        			   $(navSwitchMode).hide().appendTo("#btnSwitcher").fadeIn(1000);
        			   $("#btnSwitcher").addClass('tooltip-right marginLeftEasing10 marginRight10').attr('data-tooltip', 'Overview Summary');
        		   }, 2000);
        		 
        	   }
        		  
           }

       },
       complete: function() {
    	   //var canlendar_uri = 'http://172.17.9.94/pciscalendar/index.html#/login/' + condition;
    	   //$('#canlendar_uri').attr('href', canlendar_uri);  
       },
       error: function (error) {
           
       }
       
   });
	
}

function reloadMiniProfile(url, condition) {
	
	$.ajax({
       url: url,
       data: { RMCode: condition },
       type: "GET",
       jsonpCallback: "my_miniprofiles",
       dataType: "jsonp",
       crossDomain: true,
       success: function (responsed) {
    	       	 
           var result = responsed.Data;
           if (result.length > 0) {
        	   
        	   var corp		= result[0].BranchNameEng + ' (Period ' + result[0].WorkingYMD + ')';
        	   var mobile	= result[0].Mobile + ' (' + result[0].Nickname + ')';
        	   
        	   var html = 
	           '<div class="crop_nav">' +
	           		'<span id="chat_state" class="chat-state"></span>' +
	   				'<div><img src="' + result[0].UserImagePath + '"></div>' +
	   		   '</div>' +        			
	   		   '<div class="using_desc marginLeft5">' +	   		   		
	   		   		'<span><b class="tooltip-bottom" data-tooltip="' + mobile + '">' + result[0].FullNameEng.toUpperCase() + '</b> (' + result[0].Position + ') </span> <br/>' +
	   				'<span>' + corp + '</span>' +
	   		   '</div>';  
        	   
        	   var fullname = result[0].FullNameEng;
        	   if(fullname != '') {
        		   var str_split = fullname.split(" ");
        		   var rename = str_split[0] + ' ' + str_split[1].substr(0, 1) + '.';
        		   $('title').text('KPI - ' + rename);
        		   
        	   } else {
        		   $('title').text('KPI - ' + result[0].FullNameEng);
        	   }
        	   
        	   $('#position_title').val(result[0].Position);
        		          	   
        	   $('.using_information').html('');
        	   $(html).hide().appendTo(".using_information").fadeIn(1000);

           }

       },
       complete: function() {
    	  
       },    	   
       error: function (error) {
           
       }
       
   });
	
}

function displayBranchProfile(url, condition) {
	
	$.ajax({
       url: url,
       data: { RMCode: condition },
       type: "GET",
       jsonpCallback: "mys_miniprofile",
       dataType: "jsonp",
       crossDomain: true,
       success: function (responsed) {
    	
    	  var result = responsed.Data;
          if (result.length > 0) {
        	          	  
        	  if(in_array(result[0].Position, ['AM', 'RD', 'AMD'])) {
        		  $('.using_branchname').animate({opacity:0},function(){
            		  $(this).text('ALL BRANCHES').animate({ opacity:1 }).css({ 'position': 'absolute', 'margin-top':'8px', 'width': '150px', 'font-size': '14px' } );
            	  });
        	  } else {
        		  $('.using_branchname').animate({opacity:0},function(){
            		  $(this).text(result[0].BranchNameEng.toUpperCase() + ' BRANCH').animate({opacity:1});
            	  });
            	  
            	  $('.using_branchperiod').animate({opacity:0},function(){
            		  var open_text = 'Opened ' + result[0].OpeningDate + ' (' + result[0].Opening + ')';
            		  $(this).text(open_text).animate({opacity:1});    	   
            	  });
        	  }
  
          }
           
           
       },
       error: function (error) {
           
       }
       
   });
	
}

function getQueryParams(qs) {
    qs = qs.split("+").join(" ");

    var params = {}, tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])]
            = decodeURIComponent(tokens[2]);
    }

    return params;
}
