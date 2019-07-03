$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
	var pathFixed = window.location.protocol + "//" + window.location.host;
	for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
	for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }	

	var service_path = 'http://172.17.9.94/newservices/LBServices.svc/';
	var employeecode = $('#empprofile_identity').val();
	var instantDate  = new Date(),
		day   = instantDate.getDay(),
		month = instantDate.getMonth(),
		year  = instantDate.getFullYear();

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

	var formatRegion 	 = [
		['E', 'C', 'N', 'S', 'I'],
		['East', 'Central', 'North', 'South', 'Northeast']
	];

	var loadManager = (function() {
	     var requests = [];

	     return {
	        addRequest: function(opt) {
	            requests.push(opt);
	        },
	        removeRequest: function(opt) {
	            if( $.inArray(opt, requests) > -1 ) 
	            	requests.splice($.inArray(opt, requests), 1);
	        },
	        run: function() {
	            var self = this,
	                oriSuc;    
	    
	            if( requests.length > 0) {
	                oriSuc = requests[0].complete;

	                requests[0].complete = function() {
	                     if( typeof(oriSuc) === 'function' ) oriSuc();
	                     requests.shift();
	                     self.run.apply(self, []);
	                };   

	                $.ajax(requests[0]);

	            } else {
	              self.tid = setTimeout(function() {
	                 self.run.apply(self, []);
	              }, 1000);
	              
	            }
	        },
	        stop: function() {
	            requests = [];
	            clearTimeout(this.tid);
	        }
	     };
	     
	}());	

	var api_result	 = [];
	var api_params 	 = { empcode: employeecode };
	var api_loadName = ['reports/menu/referral/', 'reports/menu/collection/', 'reports/menu/whiteboard/', 'reports/menu/kpi/', 'reports/menu/ddtemplate/', 'reports/menu/appprogress/', 'reports/menu/document/', 'reports/menu/nano', 'reports/menu/defend/'];
	var api_notParam = ['reports/menu/kpi/', 'reports/menu/ddtemplate/', 'reports/menu/nano'];
	var api_usedFlag = ['reports/menu/collection/', 'reports/menu/whiteboard/'];

	var api_namespac = ['referral', 'collection', 'whiteboard', 'kpi', 'ddtemplate', 'appprogress', 'document', 'nano', 'defend']; 
	if(api_loadName && api_loadName.length > 0) {
		
		var api_complete  = 0;
		var param_passing = api_params.empcode;
		var flag_passing  = '';		
		$.each(api_loadName, function(index, value) {
					
			if(in_array(value, api_notParam)) param_passing = '';
			if(in_array(value, api_usedFlag)) flag_passing  = '/' + 2;		
			else flag_passing = '';
			
			loadManager.addRequest({
		        type: 'GET',
		        url: service_path + value + param_passing + flag_passing,
		        data: api_params,
		        success: function(resp) { 
		        	api_result.push(resp);
		        	//api_result[api_namespac[index]] = (resp); 
		        }
		    });
			
		});

		//loadManager.run();
	
	}

	var responseManger = setInterval(function() {		
		if(api_loadName.length === api_result.length) {
			stopResponseManger();
			
			console.log(api_result);
			
		} 
		
    }, 2000);
	
	function stopResponseManger() { clearInterval(responseManger); }

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

});