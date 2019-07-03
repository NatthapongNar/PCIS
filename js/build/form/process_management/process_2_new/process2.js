var pcis_api = "http://localhost/pcis_api/index.php/api";
angular.module("pcis-verify", ["pcis-collection", "angular.filter", "checklist-model", 'cp.ngConfirm', "ui-notification", "ui.bootstrap"]);
verification_module.factory("help", function($q, $http) {
	var fn = {};
	
	fn.ncbconsent_read = function(param) {}

	fn.in_array=function(r,n,f){var i="";if(!!f){for(i in n)if(n[i]===r)return!0}else for(i in n)if(n[i]==r)return!0;return!1};
	fn.number_format=function(n,r,e,i){var t=n,a=r,o=function(n,r){var e=Math.pow(10,r);return(Math.round(n*e)/e).toString()};t=isFinite(+t)?+t:0;var h,l,s=void 0===i?",":i,u=void 0===e?".":e,c=o((a=isFinite(+a)?Math.abs(a):0)>0?t:Math.round(t),a),d=o(Math.abs(t),a);d>=1e3?(l=(h=d.split(/\D/))[0].length%3||3,h[0]=c.slice(0,l+(t<0))+h[0].slice(l).replace(/(\d{3})/g,s+"$1"),c=h.join(u)):c=c.replace(".",u);var v=c.indexOf(u);return a>=1&&-1!==v&&c.length-v-1<a?c+=new Array(a-(c.length-v-1)).join(0)+"0":a>=1&&-1===v&&(c+=u+new Array(a).join(0)+"0"),c};
	
    function executeservice(e,t,n){var r=$q.defer();return $http[e](t,n).then(function(e){r.resolve(e)}).then(function(e){r.reject(e)}),r.promise}
          	
	return fn;
	
})
.directive('compileHtml', function ($compile) {
    return function (scope, element, attrs) {
       scope.$watch(
           function(scope) {
               return scope.$eval(attrs.compileHtml);
           },
           function(value) {
              element.html(value);
              $compile(element.contents())(scope);
           }
       );
    };
})
.controller("verify_ctrl", function($scope, $filter, help, Notification, $log, $compile, $uibModal) {
	
//	$scope.auth_code  	= $('#empprofile_identity').val();
//	$scope.auth_role  	= $('#emp_role').val();

//	$scope.table 		= null;
	
	console.log('test');
	
	
	
	$('#fttab').remove();
	
})