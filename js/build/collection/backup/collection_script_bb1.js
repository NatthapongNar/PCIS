var collection_module = angular.module("pcis-collection", ["chat-client", "ui-notification", "hm.readmore"]);
collection_module.factory("help",function($q, $http){

	var fn = {};
	var link  = "http://172.17.9.94/pcisservices/PCISService.svc/";
	var links = "http://172.17.9.94/newservices/LBServices.svc/";
	
	$('#fttab').remove();

    fn.executeServices = function (servicesMethod, objParam) {
        var deferred = $q.defer();

        var url = link + servicesMethod + "?callback=JSON_CALLBACK";

        var config = { params: objParam };

        $http.jsonp(url, config).then(function (resp) {
            deferred.resolve(resp);
        }, function (error) {
            deferred.reject(error);
        });

        return deferred.promise;
    };
    
    /** Set Config of Drawdown Template  **/
    fn.collection_read = function(param){
    	var url = links + 'collection';
    	return executeservice('post', url, param);
    };
    
    fn.collection_insert = function(param){
    	var url = links + 'collection/action';
    	return executeservice('post', url, param);
    };
    
    fn.collection_master = function(){
    	var url = links + 'collection/master';
    	return executeservice('get', url);
    };
    
    fn.ddTemplate_read = function(param){
    	var url = links + 'ddtemplate';
    	return executeservice('post', url, param);
    };
    
    fn.ddTemplate_delete = function(appno){
    	var url = links + 'ddtemplate/' + appno;
    	return executeservice('delete', url);
    };
    
    fn.onLoadListMaster = function(mastername) {
    	var url = links + 'master/ddtemplate/' + mastername;
    	return executeservice('get', url, {});
    }
    
    fn.UpdateCustInformation = function(appno, param) {
    	var url = links + 'ddtemplate/' + appno;
    	return executeservice('put', url, param);
    }
    
    fn.UpdateAppraisalConfirm = function(appno, param) {
    	var url = links + 'ddtemplate/' + appno + '/confirm';
    	return executeservice('post', url, param);
    }
    
    // Partners 
    fn.partnersInsert = function(appno, param) {
    	var url = links + 'ddtemplate/' + appno + '/partners';
    	return executeservice('post', url, param);
    }
    
    fn.partnersUpdate = function(appno, param) {
    	var url = links + 'ddtemplate/' + appno + '/partners';
    	return executeservice('put', url, param);
    }
    
    fn.partnersDelete = function(appno, sysno) {
    	var url = links + 'ddtemplate/' + appno + '/partners/' + sysno;
    	return executeservice('delete', url, null);
    }
    
    // Collateral
    fn.CollateralInsert = function(appno, param) {
    	var url = links + 'ddtemplate/' + appno + '/collateral';
    	return executeservice('post', url, param);
    }
    
    fn.CollateralDelete = function(appno, SysNo) {
    	var url = links + 'ddtemplate/' + appno + '/collateral/' + SysNo;
    	return executeservice('delete', url);
    }
    
    fn.CollateralUpdate = function(appno, param) {
    	var url = links + 'ddtemplate/' + appno + '/collateral';
    	return executeservice('put', url, param);
    }
    
    fn.NoteInfomartionInsert = function(appno, param) {
    	var url = links + 'ddtemplate/' + appno + '/note';
    	return executeservice('post', url, param);
    }
    
    fn.GetMissingDocItemList = function(doc_id) {
    	var url = links + 'missingdoc/' + doc_id;
    	return executeservice('get', url);
    }
    
    fn.GetPDFOwnerShipDoc = function(appno) {
    	var url = links + 'pcis/document/' + appno;
    	return executeservice('get', url);
    	
    }
    
    // Whiteboard
    fn.loadGridWhiteboard = function(param){
    	var url = links + 'pcis/whiteboard';
    	return executeservice('post', url, param);
    };
    
    /** End Config of Drawdown Template  **/
        
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
    
    fn.executeservice = function(type, url, param) {
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

    fn.formattedDate = function(date) {
        var d = new Date(date || Date.now()),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        if(date)
        return [day, month, year].join('/');
        else
        	return '';
        
    }
    
    fn.formattedNumber = function(num, x = 0) {
    	var renum = parseFloat(num).toFixed(x);
    	return renum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
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
      
    var regexBracket = /\[(.*?)\]/;
    fn.lendingLog = function(item) {
    	return regexBracket.exec(item) ?  "Lending" : "Collection";
    }

	return fn;
})
.filter('sumArray', function () {
    return function (data, column) {

        if (typeof(data) === 'undefined') { return 0; }

        var sum = 0;
        for (var i = data.length - 1; i >= 0; i--) {
            sum += parseInt(data[i][column]);
        }

        return sum;
    };
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
.filter('setWordwise', function () {
    return function (value, wordwise, max, tail) {
        if (!value) return '';

        max = parseInt(max, 10);
        if (!max) return value;
        if (value.length <= max) return value;

        value = value.substr(0, max);
        if (wordwise) {
            var lastspace = value.lastIndexOf(' ');
            if (lastspace != -1) {
              //Also remove . and , so its gives a cleaner result.
              if (value.charAt(lastspace-1) == '.' || value.charAt(lastspace-1) == ',') {
                lastspace = lastspace - 1;
              }
              value = value.substr(0, lastspace);
            }
        }
        
        return value + (tail || ' …');
    };
})
.filter('number_check', function ($filter) {
    return function (input, fractionSize) {
    	var $num = $filter('number')(input, fractionSize);
        if(isNaN(num)) return null;
        else  return $num;
    };
})
.controller("collection_ctrl", function($scope, $filter, help, $uibModal ,$log, $compile) {
	
	$scope.DataList = null;	
	$scope.table 	= null;
	reload();
	
    $scope.$on("bindData", function (scope, elem, attrs) {
    	
    	$scope.table = elem.closest("table").dataTable($scope.tableOpt); 
    	
    	$('.number_length').text($('.dataTables_info').text());
    	$('.dataTables_info').css('visibility', 'hidden');	 
    	
    	// UI Hidden
    	$('#panel_criteria > .panel-content').hide(500, function() {
    	    $(this).css('display', 'none');
    	});
    	
    });

	$scope.tableOpt = {
	    bDestroy: true,
		bFilter: false,
        lengthMenu: [20, 50, 100, 150],
        pagingType: "full_numbers",
	 	footerCallback: function (row, data, start, end, display) {
	 		
	    	var api = this.api(), data;
	        var intVal = function ( i ) {

	            return typeof i === 'string' ?

	                i.replace(/[\$,]/g, '')*1 :

	                typeof i === 'number' ?

	                    i : 0;

	        };
	        
	        // Total over this page
	        last_payment_amt = api
	            .column(5, { page: 'current'} )
	            .data()
	            .reduce( function (a, b) {
	                return intVal(a) + intVal(b);
	        }, 0);
	        	      
	        overdue_amt 	= api
		        .column(7, { page: 'current'} )
		        .data()
		        .reduce( function (a, b) {
		            return intVal(a) + intVal(b);
	   		}, 0);
				        
	        $(api.column(5).footer()).html(number_format(last_payment_amt));
	        $(api.column(7).footer()).html(number_format(overdue_amt));
	        	       
	    }
	
    };
	
	$scope.modalItemSelect = null;	
	$scope.enabled_model   = function(value) {
		
	    var modalInstance = $uibModal.open({
	        animation: $scope.animationsEnabled,
	        templateUrl: 'modalCollection.html',
	        controller: 'ModalInstanceCtrl',
	        size: 'lg',
	        windowClass: 'modal-fullscreen',
	        resolve: {
	          items: function () {
	            return value;
	          }
	        }
	      });
   		
		modalInstance.result.then(function(selectedItem) {
			//$scope.reloadGrid();
		}, function() {

		});
		
	};
	
	$scope.btnReload = function() { 
		$('.InProgress').show();
		return $scope.reloadGrid();		
	};
	
	function number_format (number, decimals, dec_point, thousands_sep) {
	    var n = number, prec = decimals;

	    var toFixedFix = function (n,prec) {
	        var k = Math.pow(10,prec);
	        return (Math.round(n*k)/k).toString();
	    };

	    n = !isFinite(+n) ? 0 : +n;
	    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
	    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
	    var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

	    var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); 
	    //fix for IE parseFloat(0.55).toFixed(0) = 0;

	    var abs = toFixedFix(Math.abs(n), prec);
	    var _, i;

	    if (abs >= 1000) {
	        _ = abs.split(/\D/);
	        i = _[0].length % 3 || 3;

	        _[0] = s.slice(0,i + (n < 0)) +
	               _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
	        s = _.join(dec);
	    } else {
	        s = s.replace('.', dec);
	    }

	    var decPos = s.indexOf(dec);
	    if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
	        s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
	    }
	    else if (prec >= 1 && decPos === -1) {
	        s += dec+new Array(prec).join(0)+'0';
	    }
	    return s; 
	}
	
	function reload() {
		
		var pattern 	   	    = new RegExp("-");
		var object_date 	    = $('#filterRange').val();		
		var date_pattern 	    = pattern.test(object_date);

		var start_date			= null, 
			end_date 		    = null;
		
		if(date_pattern) {
			var item   	        = object_date.split("-");
			start_date          = item[0].trim();
			end_date	   	    = item[1].trim();

		} else { start_date	    = object_date }
		
		var region_id			= $('#region option:selected').val();
		var branch_code			= $('#branch').val();
		var employee_list		= $('#emplist').val();
		var type_identity		= $('#type_identity option:selected').val();
		var filter_type			= $('#filterType').val();
		var filter_field		= $('#filterField').val();
		var filter_range		= $('#filterRange').val();
		var filter_group		= $('#action_status').val();
		var filter_sourcech		= $('#sourceofcustomer').val();
		var filter_flag			= $('input[name="list_flag"]:checked').val();
		
		var auth_emp_id	 		= $('#emp_id').val();
		
		var start_compare 		= (filter_type == "Date") ? fnDateConvert(start_date):start_date;
		var end_compare 		= (filter_type == "Date") ? fnDateConvert(end_date):end_date;
		
		var count_digit			= ($scope.txtIdentity != undefined) ? $scope.txtIdentity.length:0;
	
		var struct_state		= [];		
		if(in_array('TDR', filter_group)) {
			struct_state.push('TDR');
			removeArrayItem(filter_group, 'TDR');
		}
		
		if(in_array('RR2', filter_group)) {
			struct_state.push('RR2');
			struct_state.push('RS2');
			
			removeArrayItem(filter_group, 'RR2');			
		}
		
		var branch_hack = [];
		if(region_id == '01') {
			region_id	= null;
			branch_hack = [201,202,203,207,240,245,252];
		}
		
		var param = {
			CifNo: (count_digit >= 13) ? 'ID':'ACC', 
			AcctNo: ($scope.txtIdentity != undefined) ? $scope.txtIdentity:null,
			BorrowerName: ($scope.txtCustName != undefined) ? $scope.txtCustName:null,
			RmCode: (employee_list != null) ? employee_list.join():null,
			BrnCode: (branch_hack[0]  != undefined) ? branch_hack.join():(branch_code != null) ? branch_code.join():null,
			RegionCode: (region_id != "") ? region_id:null,
			FilterType: (filter_type != "") ? filter_type:null,
			FilterField: (filter_type != "") ? filter_field:null,
			FilterFlag: (filter_flag != undefined) ? filter_flag:null,
			FilterGroup: (filter_group != null && filter_group[0] != undefined) ? filter_group.join():null,
			CustCursor: (struct_state[0] != undefined) ? struct_state.join():null,
			SDate: (start_date != "") ? start_compare:null,
			EDate: (end_date != "") ? end_compare:null,
			SourceChannel: (filter_sourcech && filter_sourcech[0] != undefined) ? filter_sourcech.join():null,
			AuthUser: (auth_emp_id != "") ? auth_emp_id:null
		}

		help.collection_read(param).then(function(responsed) {
			$('.InProgress').hide();
			
			var data 		 = [];
			var data_track	 = [];	
			
			var object_data;
			
			var sum_os_balance  = 0;
			var sum_lastpay_amt = 0;
			var sum_overdue_amt = 0;
			
			for(var index in responsed.data) {
				
				object_data	 = responsed.data[index].Item;
				object_track = responsed.data[index].ItemActionHist;	
				
				var is_flag = null;
				if(object_data.lst_actn === 'ขอความร่วมมือจากRM') {
					is_flag = 'Y';
				} else if(object_data.lst2actn === 'ขอความร่วมมือจากRM') {
					is_flag = 'Y';
				} else if(object_data.lst3actn === 'ขอความร่วมมือจากRM') {
					is_flag = 'Y';
				} else if(object_data.lst4actn === 'ขอความร่วมมือจากRM') {
					is_flag = 'Y';
				} else if(object_data.lst5actn === 'ขอความร่วมมือจากRM') {
					is_flag = 'Y';
				} else {
					is_flag = null;
				}
				
				sum_os_balance += (object_data.Cbal) ? parseFloat(object_data.Cbal):0;
				sum_lastpay_amt += (object_data.lspamt) ? parseFloat(object_data.lspamt):0;
				sum_overdue_amt += (object_data.TotPmtamt) ? parseFloat(object_data.TotPmtamt):0;
				
				data.push(
					{ 
						_Npdt: (object_data.Npdt != null) ? help.formattedDate(object_data.Npdt.substring(0, 10)):null,
						Custname: object_data.Custname,
						SourceChannel: (object_data.SourceDigit) ? object_data.SourceDigit:null,
						Prodtype: object_data.Prodtype,
			         	_Lpdt: (object_data.Lpdt != '') ? object_data.Lpdt:null,			         			
			         	lspamt: (object_data.lspamt != null) ? object_data.lspamt:null,
			         	DPD: object_data.DPD,
			         	odv: object_data.TotPmtamt,
			         	payacc: object_data.AccPmtNo + '/' + object_data.Paymno,
			         	lst_ptpdt: (object_data.TK_PTP_Date != '') ? object_data.TK_PTP_Date : (object_data.lst_ptpdt != '') ? help.formattedDate(object_data.lst_ptpdt.substring(0, 10)):null,
			         	pdp_timing: (object_data.pdp_timing >= 1) ? object_data.pdp_timing:null,
			         	BranchDigit: object_data.BranchDigit,
			         	BranchName: object_data.Brnname,
			         	offcr_name: object_data.offcr_name,
			         	_lst_contact: (object_data.TK_ContactDate != '') ? object_data.TK_ContactDate : (object_data.lst_contact != null) ? help.formattedDate(object_data.lst_contact.substring(0, 10)):null,
			         	lst_actn: (object_data.TK_Action != '') ? object_data.TK_Action : object_data.lst_actn,
			         	lst_reactn: (object_data.TK_ReAction != '') ? object_data.TK_ReAction : object_data.lst_reactn,
			         	link: '<i ng-click="enabled_model(' + object_data.Custid + ')" class="ti-id-badge table_icon"></i>',
			         	objItem: responsed.data[index],
			         	is_flag: is_flag,
			        	rm_log: (object_track[0]) ? 'Y':ActorResponsibility(responsed.data[index].ItemHist)			        	
			        }
				);
				
			}
	
			$scope.DataList  = data;	
			
			/*
			// Count total record
			var total_record = (responsed.data.Data.length >= 1) ? responsed.data.Data.length:0;
				
			// Get configulation
			var row_records  = $('#grid_container tbody tr').length;
			
			var pages_offset = $('select[name="grid_container_length"] option:selected').val();
			var page_length	 = (pages_offset !== undefined) ? parseInt(pages_offset):20;
			
			var total_pages  = total_record / page_length;
			*/
			
			var grand_total  = $('#grid_container').find('tfoot tr').length;	
			if(grand_total > 1) {
				 $('#grid_container').find('tfoot tr:last-child').remove();
			}
			
			var netbalance  = ($('#finalnet').val() > 0.00) ? $('#finalnet').val():0.00;
			var os_balance  = '(O/S Balance : ' + $filter('number')((sum_os_balance / 1000000), 0) + 'Mb)';
			 
			var npl_percent = '';
			var npl_tooltip = '';
			if(filter_group != null && filter_group[0] != undefined) {
				if(in_array("90+DPD", filter_group)) {
					npl_percent = (sum_os_balance / netbalance) * 100;
					var text_tooltip = (netbalance / 1000000);
					npl_tooltip = 'class="tooltip-top" data-tooltip="Est. O/S (' + moment().format('MMM') + ') : ' + $filter('number')(text_tooltip, 0)  + 'Mb"'; 
				}
		
			}
			
			var npl_achieve = (isNaN(npl_percent) || !npl_percent) ? '':'<span ' + npl_tooltip + '>Est. NPL = ' + npl_percent.toFixed(2) + '%</span>';
			$('#grid_container').find('tfoot tr:last-child').after(
    			'<tr class="brands">' +
    				'<td colspan="5" style="text-align: left !important;">GRAND TOTAL : <span>' + os_balance + ' ' + npl_achieve + '</span></td>' +
    				'<td style="text-align: right !important;">' + $filter('number')(sum_lastpay_amt, 0) + '</td>' +
    				'<td></td>' +
    				'<td style="text-align: right !important;">' + $filter('number')(sum_overdue_amt, 0) + '</td>' +
    				'<td colspan="9"></td>' +
    			'</tr>'    
	    	);
			
		});
	
	}
	
	function fnDateConvert(str_date) {	
		if(str_date != null) {
			var date_split = str_date.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
			return date_split[3] + "-" + date_split[2] + "-" + date_split[1];
		} else {
			return null;
		}		
		
	}
	
	function ActorResponsibility(itemList) {
		var objectLog = $filter('orderBy')(itemList,  'Seq');
		if(!objectLog[0]) {
			return null;
				
		} else {
				
			if(objectLog[0].lstActn == 'ขอความร่วมมือจากRM') {
				return null;
					
			} else {
					
				var prority = [];
				var logger  = [];
				$.each(objectLog, function(index, value) {
					if(value.lstActn == 'ขอความร่วมมือจากRM') { prority.push(setDataPrority(value.lstActn, value.lstContact)); } 
					else { 
						if(help.lendingLog(value.lstMmdes) == 'Lending')
						prority.push(setDataPrority(help.lendingLog(value.lstMmdes), value.lstContact)); 
					}
					
					if(help.lendingLog(value.lstMmdes) == 'Lending') logger.push('TRUE');
					else logger.push('FALSE');		
					
				});
							
				var prorityLog = $filter('orderBy')(prority, '-date');
				
				if(prorityLog[0] !== undefined) {
					if(prorityLog[0].action == 'ขอความร่วมมือจากRM') {
						return null;
					} else {
						if(in_array('TRUE', logger)) return 'Y';
						else return null;
					}
				}	
				
			}
			
		}

	}
	
	function setDataPrority(action, date) {
		if(action && in_array(action, ['ขอความร่วมมือจากRM', 'Lending'])) {
			if(action == 'ขอความร่วมมือจากRM')
				return { 'sement':'1', 'action':action, 'date':date };
			else
				return { 'sement':'2', 'action':action, 'date':date };			
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
	
	function removeArrayItem(array, itemToRemove) {
	    var removeCounter = 0;
	    for (var index = 0; index < array.length; index++) {

	        if (array[index] === itemToRemove) {
	            array.splice(index, 1);

	            removeCounter++;
	            index--;
	        }
	    }

	    return removeCounter;
	    
	}

	$scope.reloadGrid = function() {
		$scope.table.fnClearTable();
		$scope.table.fnDestroy();    	
		reload();
	};
	
})
.controller('ModalInstanceCtrl', function($scope,$filter, help, $uibModalInstance, items) {
	
	var isUpdate = false;
	var str_date;
    var objDate  = new Date();
    	str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
		
    var emp_id	 = $('#emp_id').val();
    var	emp_name = $('#emp_name').val();

	$scope.modalItemSelect    = items.objItem.Item;	
	$scope.addToCollection 	  = (items.objItem.ItemActionHist) ? items.objItem.ItemActionHist:[];
	$scope.collection_history = items.objItem.ItemHist;
	
	$scope.collection_history.map(function(item){
	    return $.extend(item, {
	        Collector_Name: help.lendingLog(item.lstMmdes)
	    });
	});
	
	$scope.$watchCollection('addToCollection', function(oValue,nValue) {	

		angular.forEach($scope.addToCollection, function(value, key) {
			value._ContactDate  = $filter('date')(value._ContactDate.split(' ')[0], 'dd/MM/yyyy');
			value._PTP_Date     = $filter('date')(value._PTP_Date.split(' ')[0], 'dd/MM/yyyy');
			value.PTP_Amt 		= $filter('number')(value.PTP_Amt, 2);
		});
		
	});

	$i = 0;	
	$scope.addTableRecord  = function(elem) {
		
		if($i >= 1) {
			
			notif({
  		    	msg: "ขออภัย!! ท่านสามารถสร้างข้อมูลได้ครั้งละหนึ่งรายการ.",
  		    	type: "error",
  		    	position: "right",
  		    	opacity: 1,
  		    	width: 300,
  		    	height: 50,
  		    	color: '#FFF !important',
  		    	autohide: true
  			});
			
		} else {

			var Account  = items.objItem.Item.AcctNo;
			var AcctType = items.objItem.Item.AcctType;
			
			$(customer_tracker).find('tbody').append(
				'<tr class="active_table">' +
					'<td class="noMargin">' +
						'<div class="input-control text noMargin">' +
							'<input id="contact_date" name="contact_date" type="text" value="' + str_date + '" readonly="readonly" style="cursor: no-drop;">' +
							'<input id="account" name="account" type="hidden" value="' + Account + '">' +
							'<input id="account_type" name="account_type" type="hidden" value="' + AcctType + '">' +
						'</div>' +					
					'</td>' +
					'<td class="noMargin">' +
						'<div class="input-control text noMargin">' +
							'<input id="emp_id_hide" name="emp_id_hide" type="hidden" value="' + emp_id + '">' +
							'<input id="emp_name_hide" name="emp_name_hide" type="text" value="' + emp_name + '" readonly="readonly" style="cursor: no-drop;">' +
						'</div>' +
					'</td>' +
					'<td class="noMargin">' +
						'<div class="input-control select noMargin">' +
							'<select id="action_reason" name="action_reason"></select>' +
						'</div>' +
					'</td>' +
					'<td class="noMargin">' +
						'<div class="input-control select noMargin">' +
							'<select id="reaction_reason" name="reaction_reason" onchange="enbled_field(this);"></select>' +
						'</div>' +
					'</td>' +
					'<td class="noMargin">' +
						'<div class="input-control select noMargin">' +
							'<select id="reason_list" name="reason_list"></select>' +
						'</div>' +
					'</td>' +
					'<td id="parent_pdpDate" class="noMargin">' +
						'<div class="input-control text noMargin objPTPDate">' +
							'<input id="ptp_date" name="ptp_date" type="text" value="" disabled="disabled">' +
						'</div>' +
					'</td>' +
					'<td class="noMargin">' +
						'<div id="parent_ptpamt" class="input-control text noMargin">' +
							'<input id="ptp_amt" name="ptp_amt" type="text" value="" disabled="disabled">' +
						'</div>' +
					'</td>' +
					'<td class="noMargin">' +
						'<div class="input-control textarea noMargin">' +
							'<textarea id="collection_note" name="collection_note" rows="1"></textarea>' +
						'</div>' +
					'</td>	 ' +     
					'<td class="noMargin text-center"></td>' +	 					
				'</tr>' +
				'<script>' + 
    				'function enbled_field(element) { '+
					'   var data_reason = $("#" + element.id + \' option:selected\').val();' +
					'   if(data_reason === "REA2" || data_reason === "PTPA") { $("#ptp_date, #ptp_amt").removeAttr("disabled"); enabledClndr(true); }' +
					'   else { enabledClndr(false); $("#ptp_date, #ptp_amt").attr("disabled", "disabled").val(""); }' +
					'}' +
					'function enabledClndr(enabled) {' +
					'  if(enabled == true) { $(".objPTPDate").attr("id", "objPTPDate"); $("#objPTPDate").Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "top" }); $("#ptp_amt").number(true, 0); }' +
					'  else { ' +
					'	  $("#parent_ptpamt").html(\'<input id="ptp_amt" name="ptp_amt" type="text" value="" disabled="disabled">\');' +
					'     $("#parent_pdpDate").html(\'<div class="input-control text noMargin objPTPDate"><input id="ptp_date" name="ptp_date" type="text" value="" disabled="disabled"></div>\'); '+
					'}' +
					'}' +
				'</script>'
			);
					
			help.collection_master().then(function(responsed) {
				getListGenerateToOption('#action_reason', responsed.data.ActionCodeObj);
				getListGenerateToOption('#reaction_reason', responsed.data.ReActionCodeObj);
				getListGenerateToOption('#reason_list', responsed.data.ReasonCodeObj);
			});
			
			var btn_show = $('button[data-show]').attr('data-show');
			if(btn_show == 'false') $('button[data-show]').removeClass('hidden').attr('data-show', true);
				
			$i++;
		}

	};
	
	function getListGenerateToOption(element, data) {

	     $(element).empty().prepend('<option value=""></option>');
	     for(var indexed in data) {
	    	$(element).append('<option value="' + data[indexed].ID + '">' + data[indexed].VALUES + '</option>');
	      
	     }
		 
	}
	
	$scope.getDataListBundled = function() {
		
		var account			= $('#account').val();
		var account_type	= $('#account_type').val();
		var contact_date 	= $('#contact_date').val();
		var contact_id 		= $('#emp_id_hide').val();
		var contact_name 	= $('#emp_name_hide').val();
		var action_reason 	= $('#action_reason option:selected').val();
		var reaction_reason = $('#reaction_reason option:selected').val();
		var reason_list 	= $('#reason_list option:selected').val();
		var ptp_date		= $('#ptp_date').val();
		var ptp_amt			= $('#ptp_amt').val();
		var memo_note 		= $('#collection_note').val();
		
		/*
		console.log([
		{ 
			account: (account != "") ? account:null, 
			account_type: (account_type != "") ? account_type:null, 
			contact_date:contact_date, 
			contact_id:(contact_id != "") ? contact_id:null, 
			contact_name: (contact_name != "") ? contact_name:null, 
			action_reason:action_reason,
			reaction_reason:reaction_reason,
			reason_list:reason_list,
			ptp_date:(ptp_date != "") ? ptp_date:null,
			ptp_amt:(ptp_amt != "") ? ptp_amt:null,
			memo_note: memo_note
		}]);
		*/
				
		if(account != "" && account_type != "") {
			
			$('.InProgress').show();
			help.collection_insert({
			   Account : (account != "") ? account:null,
			   AccountType : (account_type != "") ? account_type:null,
			   EmpCode : (contact_id != "") ? contact_id:null,
			   EmpName : (contact_name != "") ? contact_name:null,
			   ActionCode : (action_reason != "") ? action_reason:null,
		       ReActionCode : (reaction_reason != "") ? reaction_reason:null,
		       ReasonCode : (reason_list != "") ? reason_list:null,		      
		       Amount : (ptp_amt != "") ? ptp_amt:null,
		       PTPDate : (ptp_date != "") ? ptp_date:null,
		       Memo : ' [ BY: ' + contact_name.replace($scope.regexBracket, " ").trim() + ' ] ' + memo_note
		    		   
			}).then(function(responsed) {

				$('.InProgress').hide();	
				if(responsed.data.Code !== '000') {
					if(responsed.data.Status[0] == 'AA') {
						$scope.dismiss_modal();
						
						notif({
			  		    	msg: 'Saved Successfully',
			  		    	type: "success",
			  		    	position: "right",
			  		    	opacity: 1,
			  		    	width: 300,
			  		    	height: 50,
			  		    	color: '#FFF !important',
			  		    	autohide: true
			  			});
						
						isUpdate = true;
						$scope.reloadGrid();
						
					} else {
						
						notif({
			  		    	msg: responsed.data.Status[1],
			  		    	type: "error",
			  		    	position: "right",
			  		    	opacity: 1,
			  		    	width: 300,
			  		    	height: 50,
			  		    	color: '#FFF !important',
			  		    	autohide: true
			  			});
					}
				} else {
					
					notif({
		  		    	msg: responsed.data.Message,
		  		    	type: "error",
		  		    	position: "right",
		  		    	opacity: 1,
		  		    	width: 300,
		  		    	height: 50,
		  		    	color: '#FFF !important',
		  		    	autohide: true
		  			});
				}
				
				
			});
		
		} else {
			
			notif({
  		    	msg: "ขออภัย!! เกิดข้อผิดพลาดในการส่งข้อมูลกรุณาติดต่อผู้ดูแลระบบ.",
  		    	type: "error",
  		    	position: "right",
  		    	opacity: 1,
  		    	width: 300,
  		    	height: 50,
  		    	color: '#FFF !important',
  		    	autohide: true
  			});
			
			$('.InProgress').hide();
			
		}		
		
	}
	
	$scope.dismiss_modal = function () {
		if(isUpdate)
			$uibModalInstance.close();
		else
			$uibModalInstance.dismiss('cancel');
	};
	
	$scope.promPrdDetail = function(id) {	
		var html = $('#parent_prdHoldDetail').html();
		$('#' + id).webuiPopover({
			trigger:'hover',	
			padding: true,
			content: html,
			backdrop: false
		});
		
	}
	
	$scope.translationAcctState = function(words) {
		if(!words) {
			return null;
		} else {
			switch(words) {
				case 'TDR':
					return 'Trouble Debt Restructuring';
					break;
				case 'RR2':
				    return 'Reschedule Relief Y2015';
				    break;
				case 'RS2':
					return 'Normal Reschedule';
					break;
				case 'Normal':
					return 'Normal Account';
					break;
				default:
					return words;
					break;
			}
		}
	}
	
	$scope.swicthStatus = function(status, date) {
		if(status == '') {
			return null;
		} else {
			if(status == 'Y') return 'N';
			else if(status == 'N' && date != '') return 'Y'; 
		}
	}

})
.controller("ctrlWhiteboard", function($scope, $filter, help, Notification, $uibModal ,$log, $compile) {

	$('title').text('Whiteboard');
	
	$scope.data_item  = null;	
	$scope.grid_table = null;
	
	// Reload: Grid Table
	grid_reload();
	
	$scope.$on("bindData", function (scope, elem, attrs) { $scope.table = elem.closest("table").dataTable($scope.tableOpt); });
	 
	$scope.tableOpt = {
	    bDestroy: true,
		bFilter: false,
        lengthMenu: [20, 50, 100, 150],
        pagingType: "full_numbers",
	 	footerCallback: function (row, data, start, end, display) {
	 		var api = this.api(), data;
	        var intVal = function ( i ) {

	            return typeof i === 'string' ?

	                i.replace(/[\$,]/g, '')*1 :

	                typeof i === 'number' ?

	                    i : 0;

	        };
	        
	        // Total over this page
	        request_loan  = api.column(6, { page: 'current'} ).data().reduce( function (a, b) { return intVal(number_verify(a)) + intVal(number_verify(b)); }, 0);
	        approved_loan = api.column(15, { page: 'current'} ).data().reduce( function (a, b) { 
	        	var num_1 = number_verify(a);
	        	return intVal() + intVal(number_verify(b)); 
	        }, 0);
	        //drawdown_loan = api.column(19, { page: 'current'} ).data().reduce( function (a, b) { return intVal(number_verify(a)) + intVal(number_verify(b)); }, 0);
	       
	        console.log([request_loan, approved_loan]);
	        
	        //$(api.column(2).footer()).html(number_format(request_loan));
	        //$(api.column(15).footer()).html(number_format(overdue_amt));
	        //$(api.column(19).footer()).html(number_format(overdue_amt));
	        	 		
	 	}
	
    };
	 
	function grid_reload() {
		
		var param = {};
		help.loadGridWhiteboard(param).then(function(responsed) {
			var item_list 	= [];
			var data_object = (responsed.data) ? responsed.data:0;
			if(data_object.length > 0) {
				
				$.each(data_object, function(index, value) {
					
					var rmonhand_timing = number_verify(value.RMOnhandCount);
					var caonhand_timing = number_verify(value.CAOnhandCount);
					var drawdown_timing = number_verify(value.CADecisionCount);
					var total_dayusage  = number_verify((rmonhand_timing + caonhand_timing + drawdown_timing));
					
					item_list.push({
						StartDate: (value.StartDate) ? moment(value.StartDate).format('DD/MM/YYYY'):'',
						OverallDay: period_state(total_dayusage),
						BorrowerName: value.BorrowerName,
						RMName: value.RMName,
						LBName: value.BranchDigit,
						Product: reforge_product(value.ProductCode),
						RequestLoan: value.RequestLoan,
						RMOnhandCount: period_state(rmonhand_timing),
						A2CADate: a2cadate_workflow(value),
						CAName: value.CAName,
						Status: value.Status,
						StatusDate: (value.StatusDate) ? moment(value.StatusDate).format('DD/MM/YYYY'):'',
						ApprovedLoan: value.ApprovedLoan,
						CAOnhandCount: period_state(caonhand_timing),
						PlanDrawdownDate: (value.PlanDrawdownDate) ? moment(value.PlanDrawdownDate).format('DD/MM/YYYY'):'',
						DrawdownDate: (value.DrawdownDate) ? moment(value.DrawdownDate).format('DD/MM/YYYY'):'',
						DrawdownVolum: value.DrawdownBaht,
						DrawdownCount: period_state(drawdown_timing),
						ActionNote: value.ActionNote
					});
				
				});
			
				$scope.data_item  = item_list;

			} else { Notification.error('เกิดข้อผิดพลาดในการรับข้อมูลจากเซิฟเวอร์'); }
			
			$('.progress').hide();

		});
	
	}
	
	// PROCESS REFORGE
	function reforge_product(productcode) {
		if(productcode) {
			var str_split = productcode.substring(0, 3);
			var str_code  = productcode.substring(0, 2);
			var str_digit = productcode.substr(productcode.length - 2);
			if(help.in_array(str_split, ['NCA','NCB','NCC','NOA','NPS'])) {
				var str_code = '';
				switch(str_split) {
					case 'NCA': str_code = 'CA'; break;
					case 'NCB': str_code = 'CB'; break;
					case 'NCC': str_code = 'CC'; break;
					case 'NOA': str_code = 'OA'; break;
					case 'NPS': str_code = 'PS'; break;
					default: str_code = 'CA'; break;
				}
				
				return str_code + '-' + str_digit;
				
			} else { return str_code + '-' + str_digit; }
			
		} else { return ''; }
	}
	
	function a2cadate_workflow(object_data) {
		//console.info(object_data);
	}
	
	// FUNCTION
	function number_verify(objVal) {
    	if(objVal && !isNaN(objVal) && objVal !== "") return parseInt(objVal);
    	else return 0;
    }
	
	function period_state($nums) {       
        if($nums !== null && $nums !== undefined) {     	
        	if($nums <= 10) { return '<span class="fg-emerald">' + $nums + '</span>'; }
        	else if($nums >= 11 && $nums <= 20){ return '<span class="fg-amber">' + $nums + '</span>'; }
        	else if($nums >= 21) { return '<span class="fg-red">' + $nums + '</span>'; }
        } else { return ''; }
    	
    }
	
});