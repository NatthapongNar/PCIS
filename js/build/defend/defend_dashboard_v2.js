var pathArray = window.location.pathname.split( '/'), 
	newPathname = window.location.protocol + "//" + window.location.host;

var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -2); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -3); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

var query  = getQueryParams(document.location.search);
var path_uri = window.location.protocol + "//" + window.location.host + '/pcis_api/index.php/api';
//var path_uri = 'http://172.17.9.94:8099/pcis_api/index.php/api';

//var pro_serivce = "http://172.17.9.94/newservices/LBServices.svc/";
var url_serivce = "http://172.17.9.94/testreportservices/LBServices.svc/";
var profile_enable = 0;

var role_config = {
	'admin_ho': 'admin_role',
	'admin_lb': 'adminbr_role',
	'rm': 'rm_role',
	'bm': 'bm_role',
	'am': 'am_role',
	'rd': 'rd_role',
	'ho': 'hq_role',
	'dev': 'dev_role',
};

var state_config = {
	appDraft: 'Draft',
	mgrHandle: 'DEF Received',
	mgrCommit: 'Send to CA',
	mgrReturn: 'Re-Process',
	mgrCancel: 'Incompleted',
	appComplete: 'Completed'
};

var msg_config = {
	save: 'โปรดยืนยันความถูกต้องของข้อมูล\n\rกรณีข้อมูลถูกต้องคลิก OK หรือ กด Cancel เพื่อตรวจสอบข้อมูลใหม่อีกครั้ง'
};

var ROLE_TESTER = [role_config.admin_ho, role_config.ho];
var USER_MONITOR = []; // '55143','56225','57017','57151','57249','57251','58252','58360','59414','59692'

angular.module('pcisDefendV2Module', ["pcis-collection", "angular.filter", "checklist-model", "textAngular", 'uiSwitch', 'cp.ngConfirm', "ui-notification", "ui.bootstrap", "angularFileUpload"])
.config(function($provide) {	
	$provide.decorator('taOptions', ['$delegate', function(taTools){
		taTools.toolbar = [
			[],
			['bold', 'italics', 'underline', 'redo', 'undo', 'clear'], // 'ul', 'ol', 
			[], // 'justifyLeft','justifyCenter','justifyRight','justifyFull','indent','outdent'
			['charcount']
		];
		
		return taTools;
		
	}]);
})
.filter('ddDate',function($filter){
	return function(sDate,format){
		if(sDate) {
			var date = moment(sDate).format('DD/MM/YYYY (HH:mm)')
			return $filter("date")(date, format);
		} else {
			return "";
		}
	};
})
.filter('htmlToPlaintext', function() {
    return function(text) {
    	return text ? '<p>' + String(text).replace(/<[^>]+>/gm, '') + '</p>' : '';
    };
})
.directive('inputFieldDaterange', function() {
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			
			new Kalendae.Input(attrs.id, {
				months:2,
				mode:'range',
				format: 'DD/MM/YYYY',
				useYearNav: true
			});
		
		}
	}
})
.directive('multiSelect', function ($parse, $timeout) {
    return {
        restrict: 'A',
        require: 'ngModel',
        scope: {
            ngModel: '=',
            data:'=',
            config: '='
        },
        link: function (scope, element, attrs, ctrl) {
        
        	$(element).change(function() { scope.$apply(); });
        	
        	scope.$watch("data",function(n) { $(element).multipleSelect(scope.config).multipleSelect('refresh'); });
        	scope.$watch("config",function(n) { $(element).multipleSelect(scope.config).multipleSelect('refresh'); });
        	
        	scope.$watch('ngModel', function(n, o) {
        		
        		$timeout(function(){
            		var regx = /(string|int|boolean):/g;
            		var option = element.find("option:first").val() ? element.find("option:first").val() : null;
            		var type;
            		
            		if(option && option != "?") {
            			type = (option.match(regx)) ? option.match(regx)[0] : null;
            			 
                 		var defaultValue = angular.isArray(n) ? n.map(function(item){return type+item;}) : [type+n];
                 		$(element).multipleSelect('setSelects', defaultValue);
                 	
            		}
            	
        		});

        	}, true);
        
        }
    };
    
})
.directive('webuiTooltipAttrBundle', function($parse, $timeout, help) {
	return {
		restrict: 'A',
		scope: {
	       data: '=',
	       config: '='
	    },
		link: function (scope, element, attrs) {
			var config = {
				'trigger': attrs.trigger,
				'padding': true,
				'backdrop': false
			};
			
			scope.$watch('data', function(n, o) {
				if(n) {
					scope.config.content = n;
					$(element).webuiPopover('destroy').webuiPopover(config);	
				} else {
					$(element).webuiPopover(config);	
				}
			})
			
		}
	}
})	
.directive('ngJqGrid', function ($compile) {
    return {
        restrict: 'E',
        scope: {
            config: '=',
            jqgridGroupHeader: '=',
  	        jqgridFreezeColumn: '=',
  	        sortOrder: '=',
  	        jqgridPaging: '='
        },
        link: function (scope, element, attrs) {
   
            angular.extend(scope.config, {
            	loadComplete: function () {
            		var paging_info    = $('.ui-paging-info').text();
            		scope.jqgridPaging = paging_info + ' entries';   
           	    },
                gridComplete: function() {
                	var paging_info    = $('.ui-paging-info').text();
                	scope.jqgridPaging = paging_info + ' entries'; 
                	scope.$watchCollection('jqgridPaging', function (newValue) {console.log(newValue); });
                	$compile(angular.element('#' + scope.config.id))(scope);
                	
                	$('#parent_status_detail').hover(function() {    					
    					var html = $('#status_detail').html();
    			    	$(this).webuiPopover({
    						title: 'Decision Status',
    			    		trigger:'hover',	
    			    		padding: true,
    		 	    		content: html,
    			    		backdrop: false
    			    	});    			    	
    			    }); 
                	                	
                }
            });

            scope.$watchCollection('config', function (newValue) {
                element.children().empty();
                var table = angular.element('<table id="' + newValue.id + '"></table>');
                element.append($compile(table)(scope));

                if (newValue.pager) {
                    var pager = angular.element('<div id="' + newValue.pager.replace("#", "") + '"></div>');
                    element.append($compile(pager)(scope));      
                }

                angular.element(table).jqGrid(newValue);
                      
                if(scope.jqgridGroupHeader) {
  			   	  table.setGroupHeaders({ useColSpanStyle: true, groupHeaders: scope.jqgridGroupHeader });
  		        }
  	        
  	            if(scope.jqgridFreezeColumn) {
  	        	   angular.element(table).jqGrid('setFrozenColumns');
  		        }
  	            
  	            if(scope.sortOrder) {
  	               angular.element(table).jqGrid('sortGrid', scope.sortOrder[0], true, scope.sortOrder[2]);
  	            }
  	           
  	            var paging_info    = $('.ui-paging-info').text();
  	            scope.jqgridPaging = paging_info + ' entries'; 
  	           
            });
          
        }
    };
})
.controller('defendDashboard', function($scope, $filter, help, Notification, $compile, $uibModal) {	
	var width  = $(document).width() - 5;
	var height = $(document).height() - 310;

	$scope.progress		= true;
	$scope.userinfo	 	= null;
	$scope.chain_record = false;	
	$scope.pagingInfo	= 'No records to view';
	$scope.cilent_id 	= angular.element('body').data('id');
	$scope.user_role 	= angular.element('body').data('role');
	
	$scope.region_filter = (help.in_array($scope.user_role, [role_config.admin_ho, role_config.ho, role_config.dev])) ? false:true;
	$scope.areaes_filter = (help.in_array($scope.user_role, [role_config.admin_ho, role_config.ho, role_config.dev, role_config.rd])) ? false:true;
	$scope.branch_filter = (help.in_array($scope.user_role, [role_config.admin_ho, role_config.ho, role_config.dev, role_config.rd, role_config.am])) ? false:true;

	$scope.param   = {
		auth: $scope.cilent_id,
		region_list: null,
		area_list: null,
		branch_list: null, 
		emp_list: null,
		app_no: null,
		status: null,
		defend_list: null,
		ca_name: null,
		cust_name: null,
		defend_type: null,
		defend_date: null,
		optional: null,
		active_row: 'Active'
	};
	
	$scope.multi_config  = { 
		width: '100%', 
		filter: true, 
		single: false,
		minimumCountSelected: 2			
	};
	
	$scope.masterdata = {};
	var master_apis   = ['region', 'area']

	var apino		  = master_apis.length - 1;
	$.each(master_apis, function(index, value) {		
		help.onLoadListMaster(value).then(function(responsed) {
			$scope.masterdata[value] = responsed.data;
		});
	});
	
	$scope.masterdata['decisionca']  = [
		{ 'name': 'SP - Score-Pass', 'values': 'SCORE-PASS' },
		{ 'name': 'SP - Score-Pass-NRW', 'values': 'SCORE PASS-NRW' },
		{ 'name': 'SR - Score-Reject', 'values': 'SCORE-REJECT' }, 
		{ 'name': 'SI - Incompleted', 'values': 'NO-SCORE,INCOMPLETED' },		
		{ 'name': 'P - Pending', 'values':'PENDING' },
		{ 'name': 'A - Approved', 'values':'APPROVED' },
		{ 'name': 'C - Cancel', 'values':'CANCEL' },
		{ 'name': 'R - Reject', 'values':'REJECT' }
	];
	
	$scope.masterdata['optional'] = [
		{ 'name': 'Draft', 'values':'Draft' },
		{ 'name': 'RM Submit', 'values':'RM' },
		{ 'name': 'Mgr. Prescreen', 'values':'Manager' },
		{ 'name': 'CA', 'values':'CA' },
		{ 'name': 'Mgr. Return', 'values':'Manager Return' }
	];
	
	onLoadEmployeeList();
	onLoadBranchList();
	
	// Filter Criteria
	$scope.onRegionChange = function() {
		var default_param  = {};
		var regional_param = {};
		if($scope.param.region_list.length > 0) {
			default_param  = { 'RegionID': $scope.param.region_list };
			regional_param = { 'Regional': $scope.param.region_list };
		}
	
		onLoadAreaList(default_param);
		onLoadBranchList(default_param);
		onLoadEmployeeList(regional_param);		
	}
	
	$scope.onAreaChange = function() {
		var default_param  = {};
		var regional_param = {};
		var region = [];
		var area   = [];
		
		angular.copy($scope.param.region_list, region);
		angular.copy($scope.param.area_list, area);
		
		if(region.length > 0) {
			default_param['RegionID']  = $.map(region, $.trim);
			regional_param['Regional'] = $.map(region, $.trim);
		}
		
		if(area.length > 0) {
			default_param['AreaID']  = $scope.param.area_list;
			regional_param['AreaID'] = $scope.param.area_list;
		}
		
		onLoadBranchList(default_param);
		onLoadEmployeeList(regional_param);
		
	}
	
	$scope.onBranchChange = function() {
		var param  = {};
		var region = [];
		var area   = [];
		var branch = [];
		
		angular.copy($scope.param.region_list, region);
		angular.copy($scope.param.area_list, area);
		angular.copy($scope.param.branch_list, branch);
		
		if(region.length > 0) param['RegionID'] = $.map(region, $.trim);
		if(area.length > 0) param['AreaID'] = area;
		if(branch.length > 0) param['Branch'] = branch;
		
		onLoadEmployeeList(param);
	}
	
	function onLoadAreaList(objects) {
		 var param 	   = (objects) ? objects:{};		 
		 help.executeservice('get', url_serivce + 'master/ddtemplate/area').then(function(resp) {	
			 var responsed = _.reject(resp.data, { RegionID: "" });
			 
			 if(param.RegionID && param.RegionID.length > 0) {
				 var area_list = []
					 _.each(responsed, function(data) {
					 if(data.RegionID && data.RegionID !== "") {
						 if(help.in_array(data.RegionID.trim(), param.RegionID)) {
							 area_list.push(data);
						 }
					 }					 
				 });
				 
				 $scope.masterdata['area'] = area_list;

			 } else {
				 $scope.masterdata['area'] = responsed;
			 }

		 });		 
	}
	
	function onLoadBranchList(objects) {
		 var param = (objects) ? objects:{};
		 help.executeservice('post', url_serivce + 'master/ddtemplate/branch', param).then(function(resp) { 
			 $scope.masterdata['branch'] = resp.data; 
		 });
	}

	function onLoadEmployeeList(objects) {
		 var param = (objects) ? objects:{};
		 var param_clone = {};
		 angular.copy(param, param_clone);

		 param_clone['Position'] = ['BM', 'RM']; 
		 help.executeservice('post', url_serivce + 'master/ddtemplate/employee', param_clone).then(function(resp) { 
			 $scope.masterdata['employee'] = resp.data;
		 });
	}

	
	var colname = [
	    { label: '<i class="fa fa fa-laptop" style="font-size: 1.2em;"></i>', name: 'HasForum', title: false, frozen: false, width: 30, align: 'center', classes: 'paddingLeft_none', sortable: true, formatter: defendDataOpen },
	    { label: 'START', name: 'DefendDate', title: false, frozen: false, sortable: false, width: 75, align: 'center', classes: 'paddingLeft_none', formatter: setDateStandartTH },
	    { label: '<i class="fa fa-flag-o" style="font-size: 1.2em;"></i>', name: 'DefendSLA', title: false, width: 30, frozen: false, align: 'center', classes: 'paddingLeft_none', sortable: false, formatter: setPeriodTimeColor },
	    //{ label: '<i class="fa fa-shield" style="font-size: 1.2em;"></i>', name: 'ProcessDigit', width: 30, title: false, align: 'center', classes: 'paddingLeft_none', sortable: true },
	    { label: '<i class="fa fa-gavel" style="font-size: 1.2em;"></i>', name: 'DefendNewProgress', title: false, width: 30, frozen: false, align: 'center', classes: 'paddingLeft_none', sortable: false, formatter: setProgressStatus },
	    { label: 'DATE', name: 'AssignmentDate', title: false, width: 75, align: 'center', classes: 'paddingLeft_none', sortable: true, formatter: setDateStandartTH },
	    { label: '<i class="fa fa-flag-o" style="font-size: 1.2em;"></i>', name: 'ProgressTiming', title: false, width: 30, frozen: false, align: 'center', classes: 'paddingLeft_none', sortable: false, formatter: setAssignTimeColor },
	    { label: '<i class="fa fa-upload" style="font-size: 1.2em;"></i>', name: 'DefendFiles', title: false, width: 30, align: 'center', classes: 'paddingLeft_none', sortable: true },
	    { label: 'PG', name: 'ProductDigit', title: false, align: 'left', width: 50, sortable: true, formatter: setProductProgram },
	    { label: 'AMT', name: 'RequestLoan', title: false, align: 'right', classes: 'paddingLeft_none', width: 70, sortable: true, formatter: 'number', formatoptions:{decimalSeparator:",",thousandsSeparator: ",",decimalPlaces:0} },
	    
	    { label: '<i class="icon-copy" style="font-size: 1.2em;"></i>', name: 'MissingDoc', title: false, width: 40, align: 'center', classes: 'paddingLeft_none', sortable: true, formatter: openRelationDocument },	   
	    { label: 'APP NO', name: 'ApplicationNo', title: false, align: 'left', width: 100, sortable: true },
	    { label: 'CUSTOMER', name: 'CustName', title: false, align: 'left', width: 130, sortable: true, formatter: setFormatName },
	    { label: 'SCORE', name: 'AVGRating', title: false, width: 100, sortable: true, formatter: setScoreRating },
	    { label: 'TEAM', name: 'BranchDigit', title: false, width: 50, align: 'center', classes: 'paddingLeft_none', sortable: true, formatter: setBranchDesc },
	   
	    { label: 'RM NAME', name: 'RMName', title: false, align: 'left', width: 130, sortable: true, formatter: setFormatRMName },	   
	    { label: 'MANAGER', name: 'ManagerName', title: false, align: 'left', width: 130, sortable: true, formatter: setFormatName },
	    { label: 'CA NAME', name: 'CAName', title: false, align: 'left', width: 130, sortable: true, formatter: setFormatName },
	    { label: '<span id="parent_status_detail" data-placement="left">ST</span>', name: 'Status', title: false, align: 'center', classes: 'paddingLeft_none', width: 40, sortable: true, formatter: setFullStatusToDigit },
	    { label: 'DATE', name: 'StatusDate', title: false, align: 'center', classes: 'paddingLeft_none', width: 75, sortable: true, formatter: setDateStandartTH },
	    { label: 'AMT', name: 'ApprovedLoan', title: false, align: 'right', width: 70, classes: 'paddingLeft_none', sortable: true, formatter: 'number', formatoptions:{decimalSeparator:",", thousandsSeparator: ",", decimalPlaces: 0 } }
	];
	
	$scope.thead_group = [
	    { "numberOfColumns": 3, "titleText": "CREATE INFO.", "startColumnName": 'Modal' },
	    { "numberOfColumns": 4, "titleText": "PROGRESS", "startColumnName": 'DefendNewProgress' },
	    { "numberOfColumns": 2, "titleText": "REQUEST LOAN", "startColumnName": 'ProductDigit' },
	    { "numberOfColumns": 3, "titleText": "CUSTOMER INFORMATION", "startColumnName": 'MissingDoc' },
	    { "numberOfColumns": 4, "titleText": "BRANCH INFORMATION", "startColumnName": 'AVGRating' },
	    { "numberOfColumns": 4, "titleText": "DECISION INFORMATION", "startColumnName": 'CAName' }
	];
	
	$scope.config = {
		id: 'grid_container',
		data: [],
		datatype: "local",
		colModel: colname,
    	styleUI : 'Bootstrap',
    	loadui: "block",    	
    	loadtext: "", 
    	rownumbers: true,		        
    	toppager: false,	   
    	shrinkToFit: true,    
    	viewrecords: true,
    	height: height,
    	width: width, 
    	pager: '#grid_pager',
    	sortname: 'DefendDate',
    	sortorder: 'desc',
    	rowNum: 20,
        rowList: [20, 50, 100, 200, 300, 500],
        footerrow: false,
        onPaging: function(pgButton) {
        	var str_page   = '',
        	current_page   = parseInt($('input.ui-pg-input.form-control').val());
        	page_selrows   = parseInt($('select.ui-pg-selbox.form-control option:selected').val());
        	page_maxlength = parseInt($('#sp_1_grid_pager').text())
        	total_record   = $(this).getGridParam('records');

        	if(help.in_array(pgButton, ['next', 'prev'])) {        		
        		if(pgButton == 'next') {
        			str_page = ((page_selrows * current_page) + 1) + ' - ' + (page_selrows * (current_page + 1)) + ' of ' + total_record;
        		} else {
        			str_page = (((page_selrows * (current_page - 1)) + 1) - page_selrows)  + ' - ' + ((page_selrows * current_page)  - page_selrows)  + ' of ' + total_record;
        		}
        	} else {
        		if(pgButton == 'last') {
        			str_page = (((page_selrows * page_maxlength) - page_selrows) + 1) + ' - ' + total_record + ' of ' + total_record;
        		} else {
        			str_page = '1 - ' + page_selrows + ' of ' + total_record;
        		}
        	}

        	$('#paging_topper').html('View ' + str_page + ' entries');
        },
        loadIssueList: function(event) {
        	var data = eval("(" + $(event.currentTarget).data("rowData") + ")");
        	$scope.defendlist_model(data.DocID);
        },
        loadMissingList: function(doc_id) {
        	$scope.missinglist_model(doc_id)
	    },
	    loadActionNoteList: function(event) {	    	
	    	var data = eval("(" + $(event.currentTarget).data("rowData") + ")");
	    	$scope.openActionNoteHistory(data.DocID, {
	    		BorrowerName: (data.BorrowerName) ? data.BorrowerName:null,
	    		ApplicationNo: (data.AppNo) ? data.AppNo:null,
	    		LatestAppProgress: null
	    	});
        }
	};
	
	$scope.gridSearch = function() { reloadGrid(); }
	$scope.gridClear  = function() {	
		$scope.param  = {
			auth: $scope.cilent_id,
			region_list: null,
			area_list: null,
			branch_list: null, 
			emp_list: null,
			app_no: null,
			status: null,
			defend_list: null,
			ca_name: null,
			cust_name: null,
			defend_type: null,
			defend_date: null,
			optional: null,
			active_row: 'Active'
		};
		
		$('#ms_spanms_status > span').text('');
		$('input[name="selectAllms_status"]').prop('checked', false);
		$('input[name="selectItemms_status"]').prop('checked', false);
		
	};

	function reloadGrid() {
		$scope.progress  = true;
		$scope.logs_item = [{}];

		var item_head 	= null;
		var data_item 	= [];
		var startDate	= null, endDate	= null;	
		var objectDate	= setDateRangeHandled($scope.param.defend_date);
	
		start_date		= (objectDate) ? objectDate[0]:null;
		end_date		= (objectDate) ? objectDate[1]:null;
		
		$param = {
			'EmpCode'	: $scope.param.auth,
			'AppNo'		: $scope.param.app_no,
			'CustName'	: $scope.param.cust_name,
			'RegionCode': ($scope.param.region_list && $scope.param.region_list.length > 0) ? $scope.param.region_list.join():null,
			'AreaCode'	: ($scope.param.area_list && $scope.param.area_list.length > 0) ? $scope.param.area_list.join():null,
			'BrnCode'	: ($scope.param.branch_list && $scope.param.branch_list.length > 0) ? $scope.param.branch_list.join():null,
			'RMCode'	: ($scope.param.emp_list && $scope.param.emp_list.length > 0) ? $scope.param.emp_list.join():null,		
			'IDCard'	: (help.in_array($scope.user_role, ['rm_role', 'bm_role', 'am_role', 'rd_role', 'dev_role'])) ? null:'Y',
			'SDF_Date'	: start_date,
			'EDF_Date'	: end_date,
			'Status'	: ($scope.param.status && $scope.param.status.length > 0) ? $scope.param.status.join():null,
			'CAName' 	: $scope.param.ca_name,
			'DefendProgress': ($scope.param.defend_list && $scope.param.defend_list.length > 0) ? $scope.param.defend_list.join():null,
			'ActiveRow'	: ($scope.param.active_row) ? $scope.param.active_row:null		
		};
		
		var dataConfig	= [];
		help.executeservice('post', (path_uri + '/defend'), $param).then(function(resp) {
			$scope.progress = false;
			var responsed = resp.data;
			if(responsed.data && responsed.data.length > 0) {
				for(var index in responsed.data) {
					
					item_head  = responsed.data[index];
					data_item.push({
						DocID: item_head.DocID,
						DefendDate: item_head.DefendDate,
						DefendSLA: item_head.DefendSLA,
						ApplicationNo: item_head.ApplicationNo,
						AssignmentConfirm: item_head.AssignmentConfirm,
						AssignmentDate: item_head.AssignmentDate,
						AssignmentName: item_head.AssignmentName,					
						ManagerName: item_head.ManagerName,
						ProcessDigit: item_head.ProcessDigit,
						ProgressTiming: (item_head.ProgressTiming && item_head.ProgressTiming > 0) ? item_head.ProgressTiming : 0,
						DefendProgress: item_head.DefendProgress,
						DefendScore: item_head.DefendScore,
						DefendNewProgress: item_head.DefendNewProgress,
						DefendFiles: item_head.File_Total,
						MissingDoc: (item_head.MissingDoc && item_head.MissingDoc > 0) ? item_head.MissingDoc : 0,
						BranchDigit: item_head.BranchDigit,
						BranchName: item_head.BranchName,
						BranchTel: item_head.BranchTel,
						RMName: item_head.RMName,
						ProductDigit: (item_head.ProductDigit) ? item_head.ProductDigit:'',
						ProductName: (item_head.ProductName) ? item_head.ProductName:'',
						CustName: item_head.BorrowerName,
						CAName: item_head.CAName,		
						Status: item_head.Status,
						StatusDate: (item_head.StatusDate && item_head.StatusDate !== '') ? item_head.StatusDate:'',
						StatusReason: item_head.StatusReason,
						RequestLoan: (item_head.RequestLoan && item_head.RequestLoan > 0) ? item_head.RequestLoan : 0,
						ApprovedLoan: (item_head.ApprovedLoan && item_head.ApprovedLoan > 0) ? item_head.ApprovedLoan : 0,
						AVGRating: (item_head.AVGRating && item_head.AVGRating > 0) ? item_head.AVGRating : 0,
						ActionNote: item_head.ActionNote,		
						Remark: (item_head.Remark && item_head.Remark !== '') ? item_head.Remark:null,
						Modal: item_head.DocID,
						HasForum: item_head.HasForum,
						itemLogs: $filter("filter")($scope.logs_item, {DocID: item_head.DocID, IsActive: 'A', IsView: true}, true),
						allInfo: item_head,
						Isactive: item_head.Isactive,
						userInfo: $scope.userinfo
					});		
					
				}
				
				$scope.config.data = data_item;
				
				if(query && query.ref) {
					if(profile_enable == 0) {
						$scope.defendlist_model(query.ref);
						profile_enable++;
					}
		    	}
							
			} else {
				$scope.config.data = responsed.data
			}
			
		});

	}
	
	$scope.$on("bindData", function (scope, elem, attrs) {
    	
    	$scope.table = elem.closest("table").dataTable($scope.tableOpt); 
    	
    	$('.number_length').text($('.dataTables_info').text());
    	$('.dataTables_info').css('visibility', 'hidden');	 

    	$('#panel_criteria > .panel-content').hide(500, function() {
    	    $(this).css('display', 'none');
    	});
    	    
    });
	
	// FUNCTION CONFIG HANDLED
	$scope.defendlist_model = function(doc_id) {
		
		var modalInstance = $uibModal.open({
	        animation: true,
	        backdrop  : 'static',
	        keyboard  : false,
	        templateUrl: 'modalDefendList.html',
	        controller: 'modalDefendListCtrl',
	        size: 'md',
	        windowClass: 'modal-fullscreen animated zoomIn',
	        resolve: {
	        	items: function () { return [doc_id, $scope.userinfo, $scope.user_role]; },
				optionData: function() { return $filter("filter")($scope.config.data, { DocID: doc_id }, true); }
	        }
	    });
		
		modalInstance.result.then(
			function(selectedItem) {}, 
			function(resp) {
				if(resp.state) { reloadGrid(); }
			}
		);
	
	};
	
	$scope.missinglist_model = function(doc_id) {		
		var modalInstance = $uibModal.open({
	        animation: true,
	        templateUrl: 'modalDefendMissingList.html',
	        controller: 'ModalInstanceMissingCtrl',
	        size: 'md',
	        windowClass: 'modal-fullscreen nonprint animated zoomIn',
	        resolve: {
	        	items: function () { return doc_id; }
	        }
	    });
		
	};
	
	$scope.openActionNoteHistory = function(doc_id, objects) {		
		var modalInstance = $uibModal.open({
	        animation: true,
	        templateUrl: 'modalActionNote.html',
	        controller: 'ctrlLoadActionNote',
	        size: 'md',
	        backdrop: 'static',
	        keyboard: true,
	        windowClass: 'modal-fullscreen animated zoomIn',
	        resolve: { items: function () { return { 'DocID': doc_id, 'Data': objects }; } }
	    });
	 
	};
	
	// Get Profile Information
	help.executeServices('GetKPI00ProfileReport', { RMCode: $scope.cilent_id }).then(function(responsed) {
		$scope.userinfo = responsed.data.Data
		var result = responsed.data.Data;		
        if (result.length > 0) {
         
           var peried   = (result[0].WorkingYMD) ? ' (Period ' + result[0].WorkingYMD + ')':'';
     	   var corp		= result[0].BranchNameEng + peried;
     	   var mobile	= result[0].Mobile + ' (' + result[0].Nickname + ')';
     	   
     	   var nickname = (result[0].Position) ? result[0].Position : result[0].OrganizationName;
     	   
     	   var html = 
	           '<div class="crop_nav">' +
	           		'<span id="chat_state" class="chat-state"></span>' +
	   				'<div><img src="' + result[0].UserImagePath + '"></div>' +
	   		   '</div>' +        			
	   		   '<div class="using_desc marginLeft5">' +
	   		   		'<span><b class="tooltip-bottom" data-tooltip="' + mobile + '">' + result[0].FullNameTh.toUpperCase() + '</b> (' + nickname + ') </span> <br/>' +
	   				'<span class="sub-desc">' + corp + '</span>' +
	   		   '</div>';  

     	   $('#position_title').val(result[0].Position);
             	   
     	   $('.using_information').html('');
     	   $(html).hide().appendTo(".using_information").fadeIn(1000);
     	   
	     	// CALL GRID
	       	reloadGrid();
  
        }

	});
	
	$scope.panel_collapsed = function(elem) {
		var $this = $('#' + elem);
		if(!$this.hasClass('panel-collapsed')) {
			$this.parents('.panel').find('.panel-body').slideUp();
			$this.addClass('panel-collapsed');
			$this.find('i').removeClass('fa fa-chevron-circle-up').addClass('fa fa-chevron-circle-down');
		} else {
			$this.parents('.panel').find('.panel-body').slideDown();
			$this.removeClass('panel-collapsed');
			$this.find('i').removeClass('fa fa-chevron-circle-down').addClass('fa fa-chevron-circle-up');
		}		
	}
	
	
	// FUNCTIONAL: FORMATTER CONFIG
	function defendDataOpen(val, model, rowData) {
		var doc_id = (rowData && rowData.DocID) ? rowData.DocID : rowData.allInfo.DocID
		var _icon = (rowData && rowData.allInfo.HasForum == 'Y') ? 'fa fa-balance-scale fg-red':'fa fa-laptop';	
		
		var icon_handle = '';
		if(rowData && rowData.DefendNewProgress == state_config.appDraft) {
			if(help.in_array($scope.user_role, _.union([role_config.rm, role_config.bm, role_config.dev], ROLE_TESTER)) || rowData.allInfo.RMCode == angular.element('body').data('id') || help.in_array(angular.element('body').data('id'), USER_MONITOR)) {
				icon_handle = (
					"<span data-row-data='{ DocID: \"" + doc_id + "\", UserInfo: " + JSON.stringify(rowData.userInfo[0]) + " }' ng-click='config.loadIssueList($event)'>" +
						'<i class="' + _icon + '" style="font-size: 1.3em; cursor: pointer; margin-left: 5px;"></i>' +
				  	'</span>'
				);
			} else {
				icon_handle = (
					'<span webui-tooltip-attr-bundle data-trigger="hover" data-content="รอ RM ส่งข้อมูล">' +
						'<i class="fa fa-close fg-red" style="font-size: 1.3em; cursor: pointer; margin-left: 5px;"></i>' +
					'</span>'
				);
			}			
		} else {
			icon_handle = (
				"<span data-row-data='{ DocID: \"" + doc_id + "\", UserInfo: " + JSON.stringify(rowData.userInfo[0]) + " }' ng-click='config.loadIssueList($event)'>" +
					'<i class="' + _icon + '" style="font-size: 1.3em; cursor: pointer; margin-left: 5px;"></i>' +
			  	'</span>'
			);
		}
		
		return icon_handle;
	}

	
	function setProductProgram(val, model, rowData) {
		if(rowData.ProductName && rowData.ProductName !== '') {			
			return ('<span webui-tooltip-attr-bundle data-trigger="hover" data-content="' + rowData.ProductName + '">' + val + '</span>');
		} else {
			return val;
		}
	}
	
	function setDateStandartTH(val) {
		if(val && val !== '') 
			return moment(val).format('DD/MM/YYYY');	
		else
			return '';
	}
	
	function setTimeColor($nums) {
		if($nums <= 2) return '<div class="fg-emerald">' + $nums + '</div>';    
    	else if($nums >= 3 && $nums <= 4) return '<div class="fg-amber">' + $nums + '</div>';    		 
    	else if($nums >= 5) return '<div class="fg-red">' + $nums + '</div>';
	}
	
	function setPeriodTimeColor($nums) {
		if($nums <= 10) { return '<div class="fg-emerald">' + $nums + '</div>'; }
    	else if($nums >= 11 && $nums <= 20){ return '<div class="fg-amber">' + $nums + '</div>'; }
    	else if($nums >= 21) { return '<div class="fg-red">' + $nums + '</div>'; }
	}
	
	function setAssignTimeColor($nums) {
		if($nums >= 0 && $nums <= 3) return '<div class="fg-emerald">' + $nums + '</div>';    
    	else if($nums > 3 && $nums <= 6) return '<div class="fg-amber">' + $nums + '</div>';    		 
    	else if($nums > 6) return '<div class="fg-red">' + $nums + '</div>';
	}
	
	function setFormatName(val, model, rowData) {	
		if(val && val !== '') {
			var str_name = '';		
			if(val && val.length >= 20) {
				str_name = val.substring(0, 20) + '...';
				return ('<span webui-tooltip-attr-bundle data-trigger="hover" data-content="' + val + '">' + str_name + '</span>');
			} else {
				return val;
			}
		} else {
			return '';
		}				
	}
	
	function setFormatRMName(val, model, rowData) {		
		var text_note = (rowData.ActionNote) ? rowData.ActionNote:'';
		
		var str_icon = '';
		var str_name = '';
		var spl_name = '';
		if(val && val.length >= 12) {
			spl_name = val.substring(0, 12) + '...';
			str_name = ('<span webui-tooltip-attr-bundle data-trigger="hover" data-content="' + val + '">' + spl_name + '</span>');
		} else {
			str_name = val;
		}
		
		if(text_note && text_note !== '') {
			str_icon = (
				'<span webui-tooltip-attr-bundle data-trigger="hover" placement="right" padding="true" backdrop="false" data-content="' + text_note + '">' + 
					"<i data-row-data='{ DocID: \"" + rowData.DocID + "\", AppNo: \"" + rowData.ApplicationNo + "\", BorrowerName: \"" + rowData.CustName + "\" }' ng-click='config.loadActionNoteList($event)' class=\"fa fa-commenting-o nav_icon marginRight5\" style=\"font-size: 1.2em !important; color: dodgerblue;\"></i>" +
				'</span>'
			);
		} 	
		return str_name + ' ' + str_icon;			
	}
	
	function setScoreRating(score, model, rowData) {
		var str_text = '';
		var get_score = getDefendScore(score, model, rowData);
		if(score > 0) str_text = 'คะแนนเฉลี่ย'; 
		else str_text = 'ไม่พบข้อมูลการประเมิน';
				
		return ('<span webui-tooltip-attr-bundle data-trigger="hover" data-content="' + str_text + ': ' + score + '">' + get_score + '</span>');
	}

	function getDefendScore(score, model, rowData) {
		var max = 5;	
		var score_integet = roundFixed(score, 0);
		if(score_integet && score_integet > 0) {
			var rating = '';
			_.each(generateArr(score_integet), function(data, index) { 
				var icon_name = '';
				if((index + 1) == score_integet) {
					if(isFloat(score)) icon_name = 'icon-star-2';
					else icon_name = 'icon-star-3';					
				} else {
					icon_name = 'icon-star-3';
				}
								
				rating += ('<span class="' + icon_name + ' rating_preset" style="color: #656464;"></span>'); 
			});
			
			if(score_integet < max) {
				for(var i = score_integet; i < max; i++) rating += ('<span class="icon-star rating_preset"></span>');
				return rating;
			} else {
				return rating;
			}	
			
		} else {
			var rating = '';
			_.each(generateArr(max), function(data, index) { rating += ('<span class="icon-star rating_preset"></span>'); });
			
			return rating;
		}
		
		function getColor(r,e){if(!(r&&r>0))return"";var f=100*(r/e);return f<30?"fg-red":f>=30&&f<50?"fg-amber":f>=50&&f<70?"fg-darkCyan":f>=70&&f<90?"fg-green":f>=90?"fg-emerald":void 0}
	}
	
	function setProgressStatus(str_val, model, rowData) {

		var progress	 = '';
		var color_select = '';
		var tooltip_cls	 = '';
		var remark_text	 = '';
		
		if(str_val && str_val !== '') {
			if(rowData.Isactive === 'Active') {
				switch(str_val) {
					case 'Draft':
						progress = 'Draft';
						color_select = 'color: #555555;';
						break;			
					case 'RM':
						progress = 'RM Submit';
						color_select = 'color: #E3C800;';
						break;
					case 'Manager':
						progress = 'Manager Onhand';
						color_select = 'color: #1BA1E2;';
						break;
					case 'CA':
						progress = 'CA Onhand';
						color_select = 'color: #60A917;';
						break;
					case 'Manager Return':					
						tooltip_cls = 'tooltip_text_left';
						color_select = 'color: #E51400;';
						remark_text = (rowData.Remark) ? 'เหตุผล : ' + rowData.Remark:'';
						progress = 'Manager Return - ' + remark_text;
						break;
					case 'Incompleted':
						tooltip_cls = 'tooltip_text_left';
						color_select = 'color: #555555;';
						remark_text = (rowData.Remark) ? 'เหตุผล : ' + rowData.Remark:'';
						progress = 'Manager Cancel - ' + remark_text;
						break;
					default:
						progress = 'Completed';
						color_select = 'color: #555555;';
					break;
				}
	
				return (
					'<span webui-tooltip-attr-bundle data-trigger="hover" data-content="' + progress + '">' +
						'<i class="fa fa-circle" style="font-size: 1.4em; cursor: pointer; ' + color_select + '"></i>' +	
					'</span>'
				);
			} else {
				return (
					'<span webui-tooltip-attr-bundle data-trigger="hover" data-content="Finished">' +
						'<i class="fa fa-circle" style="font-size: 1.4em; cursor: pointer; color: #555555;"></i>' +	
					'</span>'
				);
			}
			

		} else {
			return ('<i class="fa fa-circle" style="font-size: 1.4em; cursor: pointer; color: #555555;"></i>');
		}

	}
	
	function openRelationDocument(val, model, rowData) {
		var attr = 'ng-click="config.loadMissingList(\'' + rowData.DocID + '\')"';	
		return (
			'<span ' + attr + '>' +
		   		'<span class="icon-copy fg-steel" style="font-size: 1.3em; cursor: pointer; margin-right: 5px;"></span>' +
		   		'<span class="badge bg-amber" style="font-size: 0.8em; position: absolute; margin-top: -7px; margin-left: -15px;">' + rowData.MissingDoc + '</span>' +
		   '</span>'
		);
	}
	
	 function setBranchDesc(str_name, model, rowData) {
		var brn_name = (rowData.BranchName) ? rowData.BranchName:null;
		var brn_tels = (rowData.BranchTel) ? rowData.BranchTel:null;		 
		var str_text = brn_name + ' (' + brn_tels + ')';
		
		return ('<span webui-tooltip-attr-bundle data-trigger="hover" data-content="' + str_text + '">' + str_name + '</span>');
		
	}
	
	function setFullStatusToDigit(val, model, rowData) {
		var status_digit = '';
		switch(val) {
			case 'SCORE-PASS': status_digit = 'SP'; break;
			case 'SCORE PASS-NRW': status_digit = 'SP'; break;
			case 'SCORE-REJECT': status_digit = 'SR'; break;
			case 'NO-SCORE': status_digit = 'SI'; break;
			case 'INCOMPLETED': status_digit = 'SI'; break;
			case 'CREDIT RETURN': status_digit = 'CR'; break;
			case 'PENDING': status_digit = 'P'; break;
			case 'APPROVED': status_digit = 'A'; break;
			case 'REJECT': status_digit = 'R'; break;
			case 'CANCEL': status_digit = 'C'; break;
			case 'CANCELBYRM':
			case 'CANCELBYCA':
			case 'CANCELBYCUS':
				status_digit = 'C'; 
			break;
			default: 
				status_digit = ''; 
			break;
		}

		if(rowData.StatusReason && rowData.StatusReason !== '') {
			return ('<span webui-tooltip-attr-bundle data-trigger="hover" placement="right" padding="true" backdrop="false" data-content="' + rowData.StatusReason + '">' + setStatusWorkflow(status_digit, rowData) + '</span>');
		} else {
			return status_digit;
		}		
	}

	function setStatusWorkflow(status, object_data) {
		if(status && status !== '') {
			var object_data  = object_data.allInfo;
			var decision_aip  = (object_data.IsAIP == 'Y') ? object_data.IsAIP:'';
			var appraisalchk  = (object_data.AppraisalCheck == 'Y') ? object_data.AppraisalCheck:'';
			var fileEstimate  = (object_data.ReceivedEstimateDoc == 'Y') ? object_data.ReceivedEstimateDoc:'';
			var ownership_doc = (object_data.OwnershipDoc == 'Y') ? object_data.OwnershipDoc:'';
			var decision	  = status ? status:'';
			var decision_reas = (object_data.StatusDesc) ? object_data.StatusDesc:null;
			var drawdown	  = (object_data.DrawdownDate) ? object_data.DrawdownDate:'';
			
			if(!empty(decision)) {				
				var str_style	= '';
				var str_element = '';
				if(help.in_array(decision, ['P', 'A'])) {
					if(ownership_doc == 'Y') {			
						if(help.in_array(decision, ['A']) && !drawdown) { 						
							str_style   = 'padding: 3px 7px; border-radius: 50%; background: red; color: white; cursor: pointer;';
							str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
						} else  {
							if(decision == 'P') {
								if(fileEstimate == 'Y') { 
									str_style   = 'padding: 3px 7px; border-radius: 50%; background: #fa6800; color: white; cursor: pointer;';
									str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
								} else if(appraisalchk == 'Y') { 
									str_style   = 'padding: 3px 7px; border-radius: 50%; background: #199a11; color: white; cursor: pointer;';
									str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
								}  else { 
									str_element = decision;	
								}
							} else { 
								str_element = decision; 
							}
						}
					} else {						
						if(decision == 'P') {							
							if(fileEstimate == 'Y') { 
								str_style   = 'padding: 3px 7px; border-radius: 50%; background: #fa6800; color: white; cursor: pointer;';
								str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
							} else if(appraisalchk == 'Y') { 
								str_style   = 'padding: 3px 7px; border-radius: 50%; background: #199a11; color: white;';
								str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
								
							} else { str_element = decision; }	
							
						} else { str_element = decision; }						
					}					
				} else { 
					if(decision == 'SP' && decision_reas && help.in_array(decision_reas.toUpperCase(), ['SCORE-PASS'])) {
						str_style   = 'padding: 3px 7px; border-radius: 50%; background: #4390DF; color: white; cursor: pointer;';
						str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
					} else {
						str_element = decision; 
					}				
				}
				
				return str_element;				
				
			} else {
				return '';
			}			
		} else {
			return '';
		}
	}
	
	function actionNotePattern(value, model, rowData) {
		var tooltip	  = '';
		var classes	  = '';
		var styles	  = '';
		var strcolor  = '';
		var text_note = (rowData.ActionNote) ? rowData.ActionNote:'';

		var str_icon = 
			'<span webui-tooltip-attr-bundle data-trigger="hover" placement="right" padding="true" backdrop="false" data-content="' + text_note + '">' + 
				"<i data-row-data='{ DocID: \"" + rowData.DocID + "\", AppNo: \"" + rowData.ApplicationNo + "\", BorrowerName: \"" + rowData.BorrowerName + "\" }' ng-click='config.loadActionNoteList($event)' class=\"fa fa-commenting-o nav_icon marginRight5\" style=\"font-size: 1.2em !important; color: dodgerblue;\"></i>" + 
				text_note + 
			'</span>';
			
		return (rowData.ActionNote) ? str_icon:'';
	
	}

	function assingAuthToLogs(e,r){var a=[{}];return void 0!==e[0]&&($.each(e,function(e,a){help.in_array(a.DefendCode,["SP001","SP002"])?help.in_array(r,["hq_role"])?a.IsView=!1:a.IsView=!0:help.in_array(r,["hq_role","dev_role","admin_role"])?a.IsView=!0:a.IsView=!1}),angular.copy(e,a)),a}
	function setDateRangeHandled(Y){if(Y){var t="",e="";if(new RegExp("-").test(Y)){var n=Y.split("-");t=n[0].trim(),e=n[1].trim()}else t=Y,e=Y;return[moment(t,"DD/MM/YYYY").format("YYYY-MM-DD"),moment(e,"DD/MM/YYYY").format("YYYY-MM-DD")]}return null}
	
	
})
.controller('ModalInstanceMissingCtrl', function($scope, $filter, help, $uibModalInstance, $q, items) {	
	
	$scope.progress		= true;
	$scope.itemList		= [];
	help.executeservice('get', (path_uri + '/missingdoc/xid/' + items + '/missingdoc')).then(function(resp) {
		if(resp.status == 200) {			
		    $scope.itemList = resp.data;		    
		    $scope.progress = false;	
		}
	});
	
	$scope.dismiss_modal = function () { $uibModalInstance.dismiss('cancel'); };
	
})
.controller('modalDefendListCtrl', function($scope, $document, $filter, help, $uibModal, $uibModalInstance, $q, $compile, $ngConfirm, Notification, items, optionData) {

	$scope.userinfo	 	 = null;
	$scope.issue_content = null;
	$scope.primarydata   = items;
	$scope.user_role	 = items[2];
	$scope.option_data	 = (optionData[0]) ? optionData[0] : null;
	
	$scope.grid_restate  = false; // RESET GRID DAHSBOARD	
	$scope.defend_list_restart = false;
	$scope.defend_show_all = false;
	$scope.defend_reactive = false;
	$scope.reactive_haslog = false;

	$scope.request_state = false;
	$scope.manger_handle = false;
	$scope.edit_enable	 = false;
	
	$scope.forum_enable  = false;
	$scope.forum_new  	 = false;
	$scope.forum_handle  = false;
	$scope.forum_submit  = false;
	$scope.forum_chkAcpt = false;
	
	$scope.forum_note  	 = null;
	$scope.forum_accept  = null;
	$scope.forum_quenue  = 0;
		
	$scope.lock_handler	 = false;
	$scope.reactive_handler	 = false;

	// DEFAULT CONFIG	
	$scope.topic_default = ['SP001', 'SP002', 'SP003', 'SP004'];
	$scope.topic_disable = ['SP001', 'SP002'];
	$scope.noitfyconfig  = { positionY: 'top', positionX: 'right' };
	$scope.url_verify	 = newPathname + 'management/getDataVerifiedPreview?_=' + new Date().getTime() + '&P2&live=1&rel=' + items[0]
	
	$scope.webuiConfigLeft = { trigger:'hover', padding: true, placement: 'left', backdrop: false };	
	$scope.webuiConfigBundle = { trigger:'hover', padding: true, placement: 'right', backdrop: false };	
	$scope.webuiConfigHeader = { trigger:'hover', padding: true, placement: 'bottom', backdrop: false };
	
	var data_pilot 	= angular.element('body').data('pilot');			
	var commit_authen	 = $('body').data('commit-approve');
	var commit_status 	 = (commit_authen && commit_authen == 'Y') ? true:false;
	
	// ICON HANDLE AUTHORITY 
	$scope.icon_handle	 = {
		'RMRequestToMgr': (help.in_array($scope.user_role, _.union([role_config.rm, role_config.dev], ROLE_TESTER))) ? true:false,
		'MgrSubmitToCA': (commit_status || help.in_array($scope.user_role, _.union([role_config.dev], ROLE_TESTER))) ? true:false,
		'MgrDefendReturn': (commit_status || help.in_array($scope.user_role, _.union([role_config.dev], ROLE_TESTER))) ? true:false,
		'MgrUnlockProcess': (commit_status || help.in_array($scope.user_role, _.union([role_config.bm, role_config.am, role_config.dev], ROLE_TESTER))) ? true:false,
		'MgrActionRequest': false
	};

	$scope.$watch('issue_content.header', function(n, o) {
		if(n) {
			if(n.DefendProgress == state_config.mgrCommit) {
				$scope.lock_handler = true;
			}
			else if(n.DefendProgress == state_config.mgrReturn) {
				$scope.icon_handle.MgrActionRequest = (commit_status) ? true : false;
			}
			else if(help.in_array(n.DefendProgress, [state_config.mgrCancel, state_config.appComplete])) {
				$scope.reactive_handler = true;
			}	
			if(n.D2CA_Amt && n.D2CA_Amt > 0) {
				var item_auth = (items[1][0]) ? items[1][0].Branch:null;
				if(item_auth && item_auth == 'HQ') {
					$scope.forum_enable  = true;
				}				
			} 
			if(n.DefendForum_Note && n.DefendForum_Note !== '') {
				$scope.forum_new = true;
				$scope.forum_note = n.DefendForum_Note;
			}
			if(n.Total_ForumApp && n.Total_ForumApp > 0) {
				$scope.forum_quenue = n.Total_ForumApp;
			}	
		}
	});	
		
	// SCOPE METHOD FUNCTIONAL
	// DEFEND FORUM
	$scope.$watch('forum_note', function(n, o) {
		if(n && n !== '') {
			if(n.length >= 10) $scope.forum_chkAcpt = true;
			else $scope.forum_chkAcpt = false;					
		} else {
			$scope.forum_chkAcpt = false;
			$scope.forum_accept = null;
		}
	}, true);	
	
	$scope.$watch('forum_accept', function(n, o) {
		if(n) {
			if(n && n[0] == 'Y' && $scope.forum_note !== '') {				
				$scope.forum_submit = true;
				
				$scope.$watch('forum_note', function(n, o) {
					if(n && n !== '') {
						if(n.length >= 10) $scope.forum_chkAcpt = true;
						else $scope.forum_chkAcpt = false;	
					} else {
						$scope.forum_submit = false;
					}
				});	
				
			} else {
				$scope.forum_submit = false;				
			}
		} else {
			$scope.forum_submit = false;	
		}
	}, true);	
	
	$scope.handleDefendForum = function() {
		if($scope.forum_handle) $scope.forum_handle = false;
		else $scope.forum_handle = true;
	}
	
	$scope.handleSubmitDefendForum = function(param, content) {
		var header = content.header;
		var param = {
			DocID: param[0],
			ApplicationNo: header.ApplicationNo,
			DefendNote: $scope.forum_note,
	        RequestID: (param[1][0].EmployeeCode) ? param[1][0].EmployeeCode:null,
	        RequestBy: (param[1][0].FullNameTh) ? param[1][0].FullNameTh:null				
		};

		help.executeservice('post', (path_uri + '/defendforum'), param).then(function(resp) {					
			 $scope.noitfyconfig.title = 'แจ้งเตือนจากระบบ';
			 $scope.noitfyconfig.message = 'ระบบบันทึกข้อมูลเข้า Defend Forum สำเร็จ';
    		 Notification.success($scope.noitfyconfig );
    		 $scope.request_state = true;
    		 
    		 $uibModalInstance.dismiss({ status: 'cancel' }); 		    		 
		});
	}
	
	$scope.handleDeleteDefendForum = function(param, content) {
		if(confirm('กรุณากดยืนยันเพื่อลบข้อมูล กรณียืนยันการลบ คลิก OK หรือ Cancel เพื่อยกเลิก')) {
		var header = content.header;
			var param = {
				DocID: param[0],
				ApplicationNo: header.ApplicationNo,
				DefendNote: $scope.forum_note,
		        RequestID: (param[1][0].EmployeeCode) ? param[1][0].EmployeeCode:null, 
		        RequestBy: (param[1][0].FullNameTh) ? param[1][0].FullNameTh:null				
			};
	
			help.executeservice('post', (path_uri + '/defendforumDelete'), param).then(function(resp) {					
				 $scope.noitfyconfig.title = 'แจ้งเตือนจากระบบ';
				 $scope.noitfyconfig.message = 'ระบบดำเนินการลบข้อมูลใน Defend Forum ก่อนหน้าสำเร็จ';
	    		 Notification.success($scope.noitfyconfig );
	    		 $scope.request_state = true;
	    		 
	    		 $uibModalInstance.dismiss({ status: 'cancel' }); 		    		 
			});
			
			return true;
		}
		
		return false;
	}
	
	// SUBMIT DEFEND TO MANAGER
	$scope.requestSentApproveToManger = function(param) {	
		if(!$scope.request_state) {
			if(confirm('กรุณากดยืนยันข้อมูล เพื่อส่งขออนุมัติจากหัวหน้าทีมในการส่งรายการถึงทีมเครดิต')) {
				
				var param = {
					DocID: param[0],
			        RequestID: (param[1][0].EmployeeCode) ? param[1][0].EmployeeCode:null,
			        RequestBy: (param[1][0].FullNameTh) ? param[1][0].FullNameTh:null				
				};
	
				help.executeservice('post', (path_uri + '/defendSubmitToManager'), param).then(function(resp) {					
					 $scope.noitfyconfig.title = 'แจ้งเตือนจากระบบ';
					 $scope.noitfyconfig.message = 'ระบบได้ดำเนินการส่งข้อมูลถึงหัวหน้าทีมแล้ว กรุณารอการตรวจสอบจากหัวหน้าทีม';
		    		 Notification.success($scope.noitfyconfig );
		    		 $scope.request_state = true;
		    		 
		    		 $uibModalInstance.dismiss({ status: 'cancel', state: true }); 		    		 
				});
				
			}
			
		} else {
			 $scope.noitfyconfig.message = 'ขออภัย, ท่านมีการส่งข้อมูลถึงหัวหน้าทีมแล้ว กรุณารอการตรวจสอบจากหัวหน้าทีม';
    		 Notification.error($scope.noitfyconfig );
		}
		
	}
	
	// DECISION CONFIRM
	$scope.onDicisionConfirmDefend = function(item, checkAlreadyApp) {	
		var open_modal  = true;
		var user_role 	= angular.element('body').data('role');
		var isSendDefend = (checkAlreadyApp == 'Y') ? true:false; // ADD NEW ON 14 NOV 2018
		
		if(isSendDefend) {
			if(!help.in_array(user_role, ['dev_role'])) {
				open_modal = false;
			}
		}
		
		if(open_modal) {
			var data_header = item.header;	
			var modalInstance = $uibModal.open({
		        animation: true,
		        backdrop  : 'static',
		        keyboard  : false,
		        templateUrl: 'modalDecisionConfirmDefendList.html',
		        controller: 'modalDecisionConfirmDefendCtrl',
		        size: 'xs',
		        windowClass: 'animated zoomIn',
		        resolve: {
		        	items: function () { return [data_header.DocID, data_header.DefendRef, item.userinfo, { editRating: commit_status }] }
		        }
		    });
			
			modalInstance.result.then(
				function() {}, 
				function(resp) {
					if(resp.state) { 					
						$uibModalInstance.dismiss({ status: 'cancel', state: true });
					}
				}
			);	
		} else {
			// ADD NEW MESSAGE 14 NOV 2018
			Notification.error({
				title: 'แจ้งเตือนจากระบบ',
				message: 'ขออภัย, วันนี้คุณได้ใช้สิทธิในการส่งเคสเข้า Defend ไปแล้ว กรุณารอวันถัดไป เพื่อส่งเคสกลับเข้าไปใหม่',
				delay: 10000
			});
		}

	}
	
	// ADD NEW TOPIC
	$scope.addNewTopic = function(data, info) {	
		if($scope.edit_enable) {
			
			$scope.noitfyconfig.title = 'แจ้งเตือนจากระบบ';
			$scope.noitfyconfig.message = 'กรุณาบันทึกข้อมูลในหัวข้อให้ครบถ้วน เพื่อป้องกันข้อมูลศูนย์หาย (ระบบจะดำเนินการโหลดข้อมูลใหม่ในกรณีมีการสร้างหัวข้อเพิ่มเติม)';
			
			Notification.error($scope.noitfyconfig);		
			
		} else {
			var modalInstance = $uibModal.open({
		        animation: true,
		        templateUrl: 'modalAddNewTopicList.html',
		        controller: 'modalAddNewTopicCtrl',
		        size: 'md',
		        backdrop: 'static',
		        keyboard: true,
		        windowClass: 'modal-fullscreen animated zoomIn',
		        resolve: { 
		        	items: function () { return data; },
					optionData: function() { return info; }
		        }
		    });	   
			
			modalInstance.result.then(
				function() {}, 
				function(resp) {
					if(resp.state) { 			
						$scope.noitfyconfig.title = 'แจ้งเตือนจากระบบ';
						$scope.noitfyconfig.message = 'กรุณารอสักครู่.. ระบบกำลังโหลดหัวข้อเพิ่มเติมจากระบบ';	
						Notification.primary($scope.noitfyconfig);
						
						reloadDefendContent();					
					}
				}
			);	
		}
		
	};
	
	// SAVE NOTE
	$scope.save_enabled = function(user_profile, item) {	
		if(confirm(msg_config.save)) {
			
			var url_api    = url_serivce + 'pcis/defenddashboard/issue';
			var user_code  = (user_profile[0]) ? user_profile[0].EmployeeCode:null;
			var user_name  = (user_profile[0]) ? user_profile[0].FullNameTh:null;
			
			var defend_topic = (item.DefendReason && item.DefendReason !== '') ? item.DefendReason:'';
			var topic_option = (item.DefendTitleOption && item.DefendTitleOption !== '') ? item.DefendTitleOption:''; 
			
			var div = document.createElement("div"), nodes;
    		div.innerHTML = item.DefendNote;
    		nodes = [].slice.call(div.childNodes);
    		
			var content = '';
    		_.each(nodes, function(val) {
    			var data_content = (!_.isEmpty(val.outerHTML)) ? val.outerHTML : null;    		
    			if(data_content && data_content !== '<p>&nbsp;</p>' && data_content !== "undefined") {
    				if(data_content.match(/div/i)) {
    					var cutstr = data_content.replace(/<\/?div[^>]*>/g,"");
    					if(cutstr && cutstr.match(/blockquote/i)) { cutstr = cutstr.replace(/<\/?blockquote[^>]*>/g,""); }
    					content += '<p>' + cutstr + '</p>';
    				} 
    				else if(data_content.match(/text/i)) {
    					var cutstr = data_content.replace(/<\/?text[^>]*>/g,"");
    					if(cutstr && cutstr.match(/blockquote/i)) { cutstr = cutstr.replace(/<\/?blockquote[^>]*>/g,""); }
    					content += '<p>' + cutstr + '</p>';
    				} 
    				else if(data_content.match(/span/i)) {
    					var cutstr = data_content.replace(/<\/?span[^>]*>/g,"");
    					if(cutstr && cutstr.match(/blockquote/i)) { cutstr = cutstr.replace(/<\/?blockquote[^>]*>/g,""); }
    					content += '<p>' + cutstr + '</p>';
    				}  					
    				else {
    					content += val.outerHTML;
    				}   				
    			}
    			
    		});
    		
			$scope.noitfyconfig.title   = 'หัวข้อ' + defend_topic + ' ' + topic_option;

			var param = {
				RowID	   : item.RowID,
				DocID 	   : item.DocID,
				DefendRef  : item.DefendRef,
				DefendCode : item.DefendCode,
				DefendNote : (content) ? content.replace(/&nbsp;/gi, ' '):null, //(content && content.match(/style/i)) ? content.replace(/style="[^"]*"/g, ""):content,
		        CreateID   : user_code,
		        CreateBy   : user_name		
			};

			var text_editor  = (moment().format('DD/MM/YYYY HH:mm') + ' ' + item.UpdateName),
				text_default = '<p>' + text_editor + ':</p><p>&nbsp;</p>';
			
			var note_verify = [];
			if(param.DefendNote == text_default) {
				note_verify.push('FALSE');	
				$scope.noitfyconfig.message = 'กรุณากรอกรายละเอียดข้อมูลลงในฟอร์ม ก่อนบันทึกข้อมูล';				
				Notification.warning($scope.noitfyconfig);				
			} 

			if(!help.in_array('FALSE', note_verify)) {
	
		    	help.executeservice('put', url_api, param).then(function(resp) {
					if(resp.status == 200) {
		
						item.isDisabled = true;
						item.isEditable = false;
						
						item.DefendNote = content;
						
						$scope.noitfyconfig.title = $scope.noitfyconfig.title + ' (บันทึกสำเร็จ)';
						$scope.noitfyconfig.message = 'บันทึกข้อมูลสำเร็จ กรุณารอสักครู่เพื่อให้ระบบสร้างใบคำร้องสำหรับชี้แจ้งข้อมูลเกี่ยวกับลูกค้า';
						
						Notification.success($scope.noitfyconfig);						
					}
					
					$scope.edit_enable = false;
					
					localStorageClear();
					
					delete user_code;
					delete user_name;
					delete defend_topic;
					delete topic_option;
					delete note_verify;
					
				});
			}	
			
		}	
	}
	
	// NOTE ENABLE
	$scope.edit_enabled = function(user_profile, item, idx) {
		localStorageWrite('pcis', 'action_note_orginal', item);
				
		item.UpdateName = (user_profile[0]) ? user_profile[0].FullNameTh:'';
		item.UpdateDate = moment().format('DD/MM/YYYY HH:mm');

		// CLEAR STYLE IF HAS SPAN TAG
		if(item.DefendNote && item.DefendNote !== '') {
			if(item.DefendNote.match(/span/i)) {
				item.DefendNote = item.DefendNote.replace(/<\/?span[^>]*>/g,"");
			}
		}
			
		var divide_str	= '';
		var note_str	= (item.DefendNote) ? item.DefendNote:'';
		var title_str	= (item.DefendTitleOption) ? item.DefendTitleOption:'';
		
		if(note_str && note_str !== '') {
        	$scope.edit_enable = true;
    		item.isDisabled = false;
    		item.isEditable = true;
    	
    		var div = document.createElement("div"), nodes;
    		div.innerHTML = note_str;
    		nodes = [].slice.call(div.childNodes);
    		
    		var rootEl = nodes[0];                    		
    		if(rootEl) {
    			var hasEdit = note_str.match(/ปรับปรุง/i);
    			var oldEdit = rootEl.innerText.split('ปรับปรุง');
    	    			
    			var strTime = '';
    			var timeEdit = rootEl.innerText.split('(ครั้งที่');
    			if(timeEdit && timeEdit.length > 1) {
    				var addNew = parseInt(timeEdit[1].replace(')', ''));
    				strTime = '(ครั้งที่ ' + (addNew + 1) + ')';
    			} else {
    				strTime = '(ครั้งที่ 1)';
    			}
    			
    			if(!hasEdit) {
    				var updator = 'ปรับปรุง ' + strTime + ' ' + moment().format('DD/MM HH:mm') + ' ' + item.UpdateName;    
    				item.DefendNote	= '<p>' + updator + '</p>' + '<p>&nbsp;</p>' + note_str;
    			} else {    				
    				var rootEl = nodes[0];
    				var strOrigin = rootEl.innerText;    
    				
    				var updator = 'ปรับปรุง '  + strTime + ' ' + moment().format('DD/MM HH:mm') + ' ' + item.UpdateName ;  
    				var setText = strOrigin.replace(strOrigin, updator);
    				rootEl.innerHTML = setText + '<p>&nbsp;</p>';
    				
    				var str_note = '';
        			_.each(nodes, function(data, index) { str_note += data.outerHTML; });               
        			item.DefendNote	= str_note;  				
    			}

    		} else {
    			item.DefendNote	= note_str;
    		}
    		
        	$('text-angular[name="issue_itemnote_' + idx + '"]').find('div[text-angular-toolbar]').css({'display': 'block', 'transition': 'all 0.5s ease-in-out'});
			$('text-angular[name="issue_itemnote_' + idx + '"]').find('.ta-text.ta-editor').css({'display': 'block', 'transition': 'all 0.5s ease-in-out'});
			
			$scope.noitfyconfig.title   = 'หัวข้อ' + item.DefendReason + ' ' + title_str;
			$scope.noitfyconfig.message = 'ท่านกำลังอยู่ในโหมดแก้ไขข้อมูล';

			Notification.info($scope.noitfyconfig);   
			
		} else {
			$scope.edit_enable = true;
			item.isDisabled = false;
			item.isEditable = true;
			
			if(note_str && note_str.length > 0) 
    			divide_str  = '<hr/>';
    		
    		var text_editor = item.UpdateDate + ' ' + item.UpdateName;
    			item.DefendNote	= '<p>' + text_editor + ':</p><p>&nbsp;</p>' + divide_str + note_str;
			
			$('text-angular[name="issue_itemnote_' + idx + '"]').find('div[text-angular-toolbar]').css({'display': 'block', 'transition': 'all 0.5s ease-in-out'});
			$('text-angular[name="issue_itemnote_' + idx + '"]').find('.ta-text.ta-editor').css({'display': 'block', 'transition': 'all 0.5s ease-in-out'});
			
			$scope.noitfyconfig.title   = 'หัวข้อ' + item.DefendReason + ' ' + title_str;
			$scope.noitfyconfig.message = 'ท่านกำลังอยู่ในโหมดอัพเดทข้อมูล';

			Notification.info($scope.noitfyconfig);
			
		}
			
		delete divide_str;
		delete note_str;
		delete title_str;
		
	}
	
	$scope.strip_html_tags = function(str){
		return (str) ? str.replace(/<\/?[^>]+(>|$)/g, "").replace(/&nbsp;/gi, ' ') : str;
		//return $filter('htmlToPlaintext')($html);
	}
	
	$scope.setup_editor = function(event, textEditor) {	
		var hasEdit = textEditor.match(/ปรับปรุง/i);
		if(hasEdit) {			
			var BLOCKED_KEYS = /^(9|19|20|27|33|34|35|36|37|38|39|40|45|112|113|114|115|116|117|118|119|120|121|122|123|144|145)$/i;
			var UNDO_TRIGGER_KEYS = /^(8|13|32|46|59|61|107|109|173|186|187|188|189|190|191|192|219|220|221|222)$/i;

			var _lastKey;
			var triggerUndo = _lastKey !== event.keyCode && UNDO_TRIGGER_KEYS.test(event.keyCode);
			if(triggerUndo) {
				return true;
			} else {	
				event.preventDefault();
				if(!BLOCKED_KEYS.test(event.keyCode)) {				
					var keyword = event.key;
					if(!help.in_array(keyword, ['Control', 'Shift'])) {
						document.execCommand('insertHtml', false, ('<span style="color:red;">' + keyword + '</span>'));
						return true;
					}
					return false;
				}
			}
		}
	};

	$scope.rollback_topic = function(item) {		
		var note_text = localStorageRead('pcis', 'action_note_orginal');
		
		item.DefendNote = note_text.DefendNote
		item.UpdateName = note_text.UpdateName;
		item.UpdateDate = note_text.UpdateDate;
		
		item.isDisabled = true;
		item.isEditable = false;
		$scope.edit_enable = false;
		
		localStorageClear();
	}
	
	// DELETE TOPIC
	$scope.delete_topic = function(doc_id, topic, index, rowData) {
		if(confirm('กรุณายืนยันการลบข้อมูล\n\rข้อมูลที่ต้องการลบ คือ ' + topic[1] + '\n\rกรณีข้อมูลถูกต้อง โปรดคลิก OK หรือ Cancel เพื่อตรวจสอบข้อมูลใหม่อีกครั้ง')) {		
			var request_data = {
				DocID: doc_id,
				DefendCode: topic[0],
				CreateByID: (rowData[1][0].EmployeeCode) ? rowData[1][0].EmployeeCode:null,
				CreateByName: (rowData[1][0].FullNameTh) ? rowData[1][0].FullNameTh:null
			};
			
			help.executeservice('post', (path_uri + '/defend_deletetopic'), request_data).then(function(resp) {
				$scope.issue_content.subscription.splice(index, 1);
				
				$scope.noitfyconfig.title   = 'แจ้งเตือนจากระบบ';
				$scope.noitfyconfig.message = 'หัวข้อ' + topic[1] + 'ได้ถูกลบออกจากระบบสำเร็จ';
				$scope.noitfyconfig.delay	= 15000;

				Notification.success($scope.noitfyconfig);
			
			});
			
			return true;
		}
		
		return false;
	};
	
	$scope.re_process = function(info) {
		if(confirm('กรุณายืนยันข้อมูลการ Re-Proccess \n\rกรณีข้อมูลถูกต้องคลิก OK หรือ Cancel เพื่อยกเลิก')) {
			var request_data = {
				DocID: info[0],
				DefendProgress: state_config.mgrReturn,
				Remark: null,
				RequestID: (info[1][0].EmployeeCode) ? info[1][0].EmployeeCode:null,
				RequestBy: (info[1][0].FullNameTh) ? info[1][0].FullNameTh:null
			};
			
			help.executeservice('post', (path_uri + '/updateDefendProgress'), request_data).then(function(resp) {
				if(resp.status === 200) {					
					var data = resp.data;	
				
					$scope.noitfyconfig.title = 'แจ้งเตือนจากระบบ'
					$scope.noitfyconfig.message = 'ระบบดำเนินการเปลี่ยนสถานะใหม่สำเร็จ';		
					$scope.noitfyconfig.delay = 10000;				
					Notification.success($scope.noitfyconfig);

					$uibModalInstance.dismiss({ status: 'cancel', state: true });
					
					delete request_data;
					delete data; 
				}
				
			});
		
		}
		
		return false;
		
	}
	
	$scope.unlock_process = function(info) {
		if(confirm('กรุณายืนยันข้อมูลการ Reactivation\n\rหมายเหตุ: การ reactivation ระบบจะดำเนินการรีเซ็ตข้อมูลทั้งหมดและจัดเก็บเป็นประวัติข้อมูล\n\rกรณียืนยันการ Reactivation คลิก OK เพื่อดำเนินการ หรือ Cancel เพื่อยกเลิก')) {
			var request_data = {
				DocID: info[0],
				DefendProgress: state_config.appDraft,
				Remark: null,
				RequestID: (info[1][0].EmployeeCode) ? info[1][0].EmployeeCode:null,
				RequestBy: (info[1][0].FullNameTh) ? info[1][0].FullNameTh:null
			};
			
			help.executeservice('post', (path_uri + '/reactivation'), request_data).then(function(resp) {
				if(resp.status === 200) {					
					var data = resp.data;	
				
					$scope.noitfyconfig.title = 'แจ้งเตือนจากระบบ'
					$scope.noitfyconfig.message = 'ระบบดำเนินการเปลี่ยนสถานะใหม่สำเร็จ';		
					$scope.noitfyconfig.delay = 10000;				
					Notification.success($scope.noitfyconfig);

					$uibModalInstance.dismiss({ status: 'cancel', state: true });
					
					delete request_data;
					delete data; 
				}
				
			});
		
		}
		
		return false;
		
	}
	
	// UPLOAD FILES
	$scope.upload_model = function(user_profile, item) {
		
		$scope.result_set = null;
		var url   = url_serivce + 'pcis/defendfiles/info';
		var param = {
			DocID: item.DocID,
			DefendCode: item.DefendCode	
		};
			
		help.executeservice('post', url, param).then(function(resp) {
			if(resp.status == 200) {
				
				var result_set = null;
				if(resp.data.Body) {
					result_set = {
						header: resp.data.Header,
						body: resp.data.Body,
						progress: true,
						status: true
					};				
				} else {
					result_set = {
						header: null,
						body: null,
						progress: true,
						status: false
					};
				}
			
				var modalInstance = $uibModal.open({
			        animation: true,
			        backdrop  : 'static',
			        keyboard  : false,
			        templateUrl: 'modalUploadList.html',
			        controller: 'modalUploadListCtrl',
			        size: 'md',
			        windowClass: 'modal-fullscreen animated zoomIn',
			        resolve: {
			        	items: function() { return [item.DocID, 1, item.DefendCode, user_profile, items[4]]; },
						fileList: function() { return result_set; },
						handleIcon: function() { return [$scope.lock_handler, $scope.reactive_handler]; }
			        }
			    });
				
				modalInstance.result.then(
					function() {}, 
					function(resp) {
						if(resp.state) { 
							$scope.grid_restate = true;
							reloadDefendContent();
						}
					}
				);
			
			}
		
		});
	
	};
	
	// PRINT HANDLE
    $scope.print_area = function(divHeader, divName, primarydata) {
    	$.ajax({
	      	url: pathFixed + 'index.php/dataloads/printDefend?_=' + new Date().getTime(),
	        data: {
				doc_id: primarydata[0],
				defendref: 1,
				userid: (primarydata[1][0].EmployeeCode) ? primarydata[1][0].EmployeeCode:null,
				username: (primarydata[1][0].FullNameTh) ? primarydata[1][0].FullNameTh:null
			},
	        type: "POST",
	        cache: false,
		    success: function (responsed) {},
		    complete:function() {
		    	var printHeaders  = document.getElementById(divHeader).innerHTML;
				var printContents = document.getElementById(divName).innerHTML;
				var popupWin = window.open('', '_blank', 'top=0,width='+window.screen.availWidth+',height='+window.screen.availHeight+',resizable=yes');
				  
				popupWin.document.open();
				popupWin.document.write('<html>' + printHeaders + '<body onload="window.print()">' +  printContents + '</body></html>');
				popupWin.document.close();
		    },
		    error: function (error) { console.log(error); }	        
		});
		
	};

	$scope.openFileItems = function(appno) {		
		var url   = path_uri + '/fileviewer';
		var file  = "D:/PCIS_File_Uploads/application/" + appno + ".pdf";
		var param = { Files: file.toLowerCase() };
	
		if(appno) {
			help.executeservice('post', url, param).then(function(resp) {
				if(resp.status == 200) {	
					var base64str = getBase64(resp.data);
					if(base64str) window.open(base64str, '_blank');
				}				
	    	});
		}
		
		function getBase64(file) {
    		if(file) {
    			var base64str = file;
    			var binary = atob(base64str.replace(/\s/g, ''));
    			var len = binary.length;
    			var buffer = new ArrayBuffer(len);
    			var view = new Uint8Array(buffer);
    			for (var i = 0; i < len; i++) { view[i] = binary.charCodeAt(i); }
    			            
    			var blob = new Blob( [view], { type: "application/pdf" });
    			var url = URL.createObjectURL(blob);
    			return url;
    		} else {
    			return null;
    		}    		
		}   
		
	}
	
	$scope.dismiss_modal = function () { 
		$uibModalInstance.dismiss({ status: 'cancel', state: $scope.grid_restate }); 
	};
	
		
	function auto_change_progress(param) {	
		var param = {
			DocID: param[0],
			DefendProgress: state_config.mgrHandle,
			DefendScore: null,
			Remark: null,
	        RequestID: param[1][0].EmployeeCode,
	        RequestBy: param[1][0].FullNameTh				
		};
		
		if(!help.in_array(angular.element('body').data('id'), USER_MONITOR)) {
			help.executeservice('post', (path_uri + '/updateDefendProgress'), param).then(function(resp) {
				if(resp.status === 200) {
					var data = resp.data;				
					$scope.noitfyconfig.title = 'แจ้งเตือนจากระบบ';
					$scope.noitfyconfig.message = 'ระบบดำเนินการเปลี่ยนสถานะใหม่อัตโนมัติ <br />(สถานะปัจจุบัน คือ Manager Onhand)';		
					$scope.noitfyconfig.positionX = 'right';
					$scope.noitfyconfig.positionY = 'bottom';
					$scope.noitfyconfig.delay = 10000;				
					Notification.primary($scope.noitfyconfig);

					$scope.grid_restate = true;
					$scope.manager_handle = (data.AssignmentConfirm && data.AssignmentConfirm == 'Y') ? true:false
					
					delete param;
					delete data; 
				}
			});
		}

	}
	
	// Add new on 04/04/2018
	$scope.handleReactivatedCollapse = function(collapse) {

		collapse.DefendVisible = (collapse.DefendVisible) ? false : true;
		
		var docId = collapse.DocID;
		var state = (collapse.DefendVisible) ? 'Y' : 'N';
		var topic = collapse.DefendCode;
		
		help.executeservice('get', (path_uri + '/activeItems/xid/' + docId + '/topic/' + topic + '/state/' + state + '/reactivation')).then(function(resp) {});		
	}
	
	function checkReactivatedActiveLog(items) {
		if(items && items.length > 0) {
			if(items[0] && items[0].IsVisible == 'Y') {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	// Modify on 04/04/2018
	function loadDefendContent() {
		var doc_id = items[0];
			
		help.executeservice('get', (path_uri + '/defend_issue/xid/' + doc_id + '/pdf/N/defend_topic_issue')).then(function(resp) {
			var data = resp.data;
			var list = data.DefendReason;
			var react_log = data.DefendReactive;
			
			$scope.issue_content = {
				header: data.DefendHeader[0],
				subscription: data.DefendLists,
				logs: data.DefendLogs,
				react_logs: [],
				userinfo: (items[1]) ? items[1]:null,
				pilot: false
			}
			
			var pattern = new RegExp(",");
			var check_pattern = pattern.test(data_pilot);
			
			var pilot_list = []
			if(check_pattern) {
				pilot_list = data_pilot.split(',');
			} else {
				pilot_list = [String(data_pilot)];
			}
			
			if($scope.issue_content.header && $scope.issue_content.header.BranchCode) {
				if(help.in_array($scope.issue_content.header.BranchCode, pilot_list)) {
					$scope.issue_content.pilot = true;
				}
			}			
		
			// SET BM SUBMIT
			if($scope.issue_content.header && $scope.issue_content.header.RMCode) {
				if($scope.issue_content.header.RMCode == angular.element('body').data('id')) {
					$scope.icon_handle.RMRequestToMgr = true;
				}
			}
			
			// CHECK HAS NOTE DATA
			var note_checker = [];
				
			// INITIAL SETTING
			_.each($scope.issue_content.subscription, function(val, index) {
				var topic_specified = help.in_array(val.DefendCode, ['SP001', 'SP002']);
				
				val.isEditable		= false;
				val.isDisabled 		= true;
				val.UpdateName		= null;
				val.UpdateDate		= null;
				
				val.topic_active	= (help.in_array(val.DefendCode, $scope.topic_disable)) ? false:true;
				val.topic_default	= (help.in_array(val.DefendCode, $scope.topic_default)) ? false:true;				
				val.roleable 		= {
					'admin_role': (help.in_array($scope.user_role, ROLE_TESTER)) ? true:false,
					'adminbr_role': false,
					'rm_role': (topic_specified) ? false:true,
					'bm_role': (topic_specified) ? false:true,
					'am_role': (topic_specified) ? false:true,
					'rd_role': (topic_specified) ? false:true,
					'hq_role': (help.in_array($scope.user_role, ROLE_TESTER)) ? true:false,
					'dev_role': true
				};
				
				val.dataLogs		= _.filter(data.DefendLogs, { DefendCode: val.DefendCode })[0];
				val.dataLogsable	= (val.dataLogs && val.dataLogs.DefendNote !== '') ? true : false;
				val.DefendNoteLog	= (val.dataLogs && val.dataLogs.DefendNote !== '') ? val.dataLogs.DefendNote : null;
				val.topic_logs		= (val.dataLogs && val.dataLogs.DefendNote !== '') ? true : false;	
				
				if(val.dataLogsable) note_checker.push('true');
				else note_checker.push('false');
				
				var tooltip_text = '';
				var data_reasons = _.filter(list, { MainCode: val.DefendCode });
	
				if(data_reasons && data_reasons.length > 0) {
					var _underline = '';
					if(data_reasons.length > 1) {
						_underline = '<hr class="margin_none" />';
					}
					_.each(data_reasons, function(data) {
						tooltip_text += data.DeviateCode + ' - ' + data.DeviateReason + ' (' + data.Remark + ')' + _underline;
					});
				}
				
				val.subItems = tooltip_text;
				
				if(help.in_array(val.DefendCode, ['SP003', 'SP004'])) {
					if(val.DefendCode == 'SP003') {
						val.isTopicSpecified = commit_status || help.in_array($scope.user_role, [role_config.bm, role_config.am]);
					}					
					if(val.DefendCode == 'SP004') {
						val.isTopicSpecified = (help.in_array($scope.user_role, _.union([role_config.rm, role_config.bm, role_config.am, role_config.rd, role_config.dev], ROLE_TESTER))) ? true:false;
					}
				} else {
					val.isTopicSpecified = val.roleable[$scope.user_role];
				}
												
				$scope.request_state = (data.DefendHeader[0] && data.DefendHeader[0].RMPassRequest == 'Y') ? true:false;
				$scope.manager_handle = (data.DefendHeader[0] && data.DefendHeader[0].AssignmentConfirm == 'Y') ? true:false;
				
			});
		
			if(react_log && react_log.length > 0) {		
				var refer_code = [];
				var label_name = [];
				
				_.each(react_log, function(val, index) { 
					label_name.push(val.DefendReason); 
					refer_code.push(val.DefendCode); 
				});	
				
				var reactive_items = [];
				if(refer_code && refer_code.length > 0) {	
					refer_code = _.uniq(refer_code);
					label_name = _.uniq(label_name);
					_.each(refer_code, function(val, index) { 
						var findData = _.filter(react_log, { DefendCode: val });
						reactive_items.push({
							DocID: doc_id,
							DefendCode: val,
							DefendName: (label_name[index]) ? label_name[index]:null,
							DefendList: findData,
							DefendVisible: checkReactivatedActiveLog(findData)
						});
					});		
				} 
				
				$scope.issue_content.react_logs = reactive_items;
				$scope.reactive_haslog= true;
	
			} 
			
			// DETECT ACCESS TO DATA OF MANAGER
			if(commit_status) {
				if($scope.request_state) {
					if($scope.issue_content.header.AssignmentConfirm == 'N') {
						if(!help.in_array($scope.issue_content.header.DefendProgress, [state_config.mgrCancel, state_config.appComplete])) {
							auto_change_progress($scope.primarydata);
						}
					}
				}				
			}

			// NOTE VERIFICATION
			if(help.in_array('true', note_checker)) {
				$scope.defend_show_all = true;
			}
							
			delete data;
			delete topic_specified;
		
		});
		
	}	
	
	// Modify on 04/04/2018
	function reloadDefendContent() {
		var doc_id = items[0];
		
		help.executeservice('get', (path_uri + '/defend_issue/xid/' + doc_id + '/pdf/N/defend_topic_issue'))
		.then(function(resp) {
			
			var data = resp.data;	
			_.each(data.DefendLists, function(val, index) {
				var topic_specified = help.in_array(val.DefendCode, ['SP001', 'SP002']);
		
				val.isEditable		= false;
				val.isDisabled 		= true;
				val.UpdateName		= null;
				val.UpdateDate		= null;				
				val.topic_active	= (help.in_array(val.DefendCode, $scope.topic_disable)) ? false:true;
				val.topic_default	= (help.in_array(val.DefendCode, $scope.topic_default)) ? false:true;
				val.roleable 		= {
					'admin_role': (help.in_array($scope.user_role, ROLE_TESTER)) ? true:false,
					'adminbr_role': false,
					'rm_role': (topic_specified) ? false:true,
					'bm_role': (topic_specified) ? false:true,
					'am_role': (topic_specified) ? false:true,
					'rd_role': (topic_specified) ? false:true,
					'hq_role': (help.in_array($scope.user_role, ROLE_TESTER)) ? true:false,
					'dev_role': true
				}
				
				val.dataLogs		= _.filter(data.DefendLogs, { DefendCode: val.DefendCode })[0];
				val.dataLogsable	= (val.dataLogs && val.dataLogs.DefendNote !== '') ? true : false;
				val.DefendNoteLog	= (val.dataLogs && val.dataLogs.DefendNote !== '') ? val.dataLogs.DefendNote : null;
				val.topic_logs		= (val.dataLogs && val.dataLogs.DefendNote !== '') ? true : false;;
				
				var tooltip_text = '';
				var data_reasons = _.filter(data.DefendReason, { MainCode: data.DefendCode });
				
				if(data_reasons && data_reasons.length > 0) {
					var _underline = '';
					if(data_reasons.length > 1) {
						_underline = '<hr class="margin_none" />';
					}
					_.each(data_reasons, function(data) {
						tooltip_text += data.DeviateCode + ' - ' + data.DeviateReason + ' (' + data.Remark + ')' + _underline;
					});
				}
				
				val.subItems = tooltip_text;
				
				if(help.in_array(val.DefendCode, ['SP003', 'SP004'])) {
					if(val.DefendCode == 'SP003') {
						val.isTopicSpecified = commit_status || help.in_array($scope.user_role, [role_config.bm, role_config.am]);
					}					
					if(val.DefendCode == 'SP004') {
						val.isTopicSpecified = (help.in_array($scope.user_role, _.union([role_config.rm, role_config.bm, role_config.am, role_config.rd, role_config.dev], ROLE_TESTER))) ? true:false;
					}
				} else {
					val.isTopicSpecified = val.roleable[$scope.user_role];
				}
											
			});		
						
			angular.extend($scope.issue_content.subscription, data.DefendLists);
			
			delete doc_id;
			delete data;
		});
		
	}
	
	// INITIAL LOADING
	var response = loadDefendContent();
	if(response) {			
		_.delay(function() {
			$('.ta-toolbar').find('div:nth-child(4)').addClass('pull-right animated fadeIn'); 
			$('.ta-toolbar').find('div:nth-child(4) > div').attr('ng-click', false);
			$('.badge_group').removeClass('hide').addClass('animated fadeIn');
			
			$scope.$watch('issue_content.subscription', function(n) {
				if(n) {
					var runno = 1;
					$.each(n, function(index, value) {						
						if(!value.DefendNote && value.DefendNote == "") {
							$('text-angular[name="issue_itemnote_' + runno + '"]').find('div[text-angular-toolbar]').addClass('printable');//('display', 'none');
							$('text-angular[name="issue_itemnote_' + runno + '"]').find('.ta-text.ta-editor').addClass('printable');
						}
						runno++;		
					});		
				
				}
			});
			
		}, 300);		
	}

})
.controller('modalAddNewTopicCtrl', function($scope, $filter, help, $compile, Notification, $uibModalInstance, $q, items, optionData) {

	var topic_already = [];
	var topic_default = ['SP001', 'SP002', 'SP003', 'SP004'];
	
	if(items.subscription && items.subscription.length > 0) {
		_.each(items.subscription, function(data) {
			if(!help.in_array(data.DefendCode, topic_default)) {
				topic_already.push(data.DefendCode);
			}
		});
	}

	$scope.noitfyconfig  = {
		positionY: 'top', 
		positionX: 'right' 
	};	
	
	$scope.btnDisabled = true;
	$scope.primaryData = optionData;
	$scope.master_defend = { 
		category: [], 
		reason: []
	};
	
	$scope.checkboxItemList	= { 
		items: [] 
	};
	
	$scope.webuiConfigBundle = {
		trigger:'hover',	
		padding: true,
		placement: 'right',
		backdrop: false
	};
	
	$scope.onSubmit = function(items, info) {
		if(confirm('โปรดยืนยันความถูกต้องของข้อมูล\n\rกรณีข้อมูลถูกต้องคลิก OK หรือ กด Cancel เพื่อตรวจสอบข้อมูลใหม่อีกครั้ง')) {
			var request_data = {
				DocID: info[0],
				TopicList: items,
				CreateID: (info[1][0].EmployeeCode) ? info[1][0].EmployeeCode:null,
				CreateName: (info[1][0].FullNameTh) ? info[1][0].FullNameTh:null
			};
			
			help.executeservice('post', (path_uri + '/defend_addtopic'), request_data).then(function(resp) {
				if(resp.status == 200) {
					 $scope.grid_restate = true;
					 
					 $scope.noitfyconfig.title = 'แจ้งเตือนจากระบบ';
		    		 $scope.noitfyconfig.message = 'ระบบดำเนินการสร้างหัวข้อใหม่สำเร็จ';					 
	        		 Notification.success($scope.noitfyconfig);
	        		 
	        		 $uibModalInstance.dismiss({ status: 'cancel', state: true });
				}
					
			});
			
		}		
		
	};
	
	$scope.$watch('checkboxItemList', function(n, o) {
		if(n.items && n.items.length > 0)
			$scope.btnDisabled = false;
		else
			$scope.btnDisabled = true;	
	}, true);

	var loadMasterDefendReason = function() {
		help.executeservice('get', pathFixed + 'index.php/dataloads/getDefendTopicNewList').then(function(resp) {
			if(resp.status == 200) {
				var response = resp.data;				
				if(response.data && response.data.length > 0) {
					_.each(response.data, function(data) {
						
						var tooltip_text = '';
						var data_reasons = _.filter(response.dataList, { MainCode: data.MainCode });
						
						if(data_reasons && data_reasons.length > 0) {
							var _underline = '';
							if(data_reasons.length > 1) {
								_underline = '<hr class="margin_none" />';
							}
							_.each(data_reasons, function(data) {
								var remark = (data.Remark && data.Remark !== '' && data.Remark !== '-') ? ' (' + data.Remark + ')':'';
								tooltip_text += data.DeviateCode + ' - ' + data.DeviateReason + remark + _underline;
							});
						}
						
						data.subItems = tooltip_text;
						
						if(help.in_array(data.MainCode, topic_already)) {
							data.isDisabled = true;
						} else {
							data.isDisabled = false;
						}
					});
					
					$scope.master_defend['category'] = response.data;
					$scope.master_defend['reason'] = response.dataList;
					delete response;
				}
	
			}			
		});
	}();

	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss({ status: 'cancel' });
	};
	
})
.controller('modalUploadListCtrl', function($scope, $filter, help, FileUploader, Notification, $uibModalInstance, $q, items, fileList, handleIcon) {
	$scope.state_change = false;
	$scope.pdf_list = fileList; // PDF Details
	
	$scope.lock_handler = (handleIcon[0]) ? handleIcon:false
	$scope.reactive_handler = (handleIcon[1]) ? handleIcon:false
	
	var noitfyconfig = {
		positionY: 'top', 
		positionX: 'right' 	
	}

	var uploader = $scope.uploader = new FileUploader({
        url: pathFixed + 'index.php/file_upload/setFileUploader',     
        //extensions: ['pdf', 'jpg', 'jpeg', 'png', 'bmp' 'xlsx', 'docx', 'pptx'],
        formData: [{
        	rel: items[0],
        	ref: (items[1]) ? items[1]:1,
    		cox: items[2]
        }]
    });

	uploader.filters.push({
        name: 'customFilter',
        fn: function(item, options) {
        	if(item && item.type == "application/pdf") {
        		return true;
        	} else {
       		  	Notification.error('ระบบรองรับข้อมูงประเภท .pdf เท่านั้น กรุณาแปลงข้อมูลเป็น PDF ก่อนอัพโหลด ขออภัยในความไม่สะดวก');        		
        		return false;       	
        	}
        }
    });   
    
	uploader.onCompleteAll = function() { 
		
    	var url   = url_serivce + 'pcis/defendfiles/info';
		var param = {
			DocID : items[0],
			DefendRef : (items[1]) ? items[1]:1,
			DefendCode : items[2]
		};
		
    	help.executeservice('post', url, param).then(function(resp) {
			if(resp.status == 200) {
				
				var result_set = null;
				if(resp.data.Body) {
					result_set = {
						header: resp.data.Header,
						body: resp.data.Body,
						progress: true,
						status: true
					};				
				} else {
					result_set = {
						header: null,
						body: null,
						progress: true,
						status: false
					};
				}
				
				$scope.pdf_list = result_set;
				
			}
			
		});

    };

    $scope.$watch('pdf_list.body', function(n, o) {
		if(n !== o) { 
			 $scope.state_change = true; 
		}
	}, true);   
   
    $scope.openedFile = function($files) {
		var url   = path_uri + '/fileviewer';
		var param = $files;
		
    	help.executeservice('post', url, param).then(function(resp) {
			if(resp.status == 200) {				
				var base64str = getBase64(resp.data);
		
				if($files.FileState === 'Y') {
					if(base64str) window.open(base64str, '_blank');
					
				} else {
			
					if(help.in_array(items[3].EmployeeCode, items[4])) {
						
						if(confirm('คุณต้องการจะเปิดไฟล์หรือไม่')) {
							
							$files.FileState = 'Y';
							$.ajax({
								  url: pathFixed + 'index.php/file_upload/fileReadState?_=' + new Date().getTime(),
						    	  data: { refx: $files.RowNo },
						          type: "POST",
						          beforeSend:function() {},
						          success:function(responsed) {		
						        	  if(base64str) window.open(base64str, '_blank');	
						          },
						          cache: false,
						          timeout: 5000,
						          statusCode: {
							  	        404: function() { console.log("page not found" ); },
							  	        407: function() { console.log("Proxy Authentication Required"); },
							  	        500: function() { console.log("internal server error"); }
						          }				  		     
							});
					
						}
						
						return false;
						
					} else {
						if(base64str) window.open(base64str, '_blank');
					}
					
				}			
			
			}
			
		});
    	
    	function getBase64(file) {
    		if(file) {
    			var base64str = file;
    			var binary = atob(base64str.replace(/\s/g, ''));
    			var len = binary.length;
    			var buffer = new ArrayBuffer(len);
    			var view = new Uint8Array(buffer);
    			for (var i = 0; i < len; i++) { view[i] = binary.charCodeAt(i); }
    			            
    			var blob = new Blob( [view], { type: "application/pdf" });
    			var url = URL.createObjectURL(blob);
    			return url;
    		} else {
    			return null;
    		}    		
		}
	}
	
	$scope.deleteFile = function($files) {
	
		if(confirm('คุณต้องการจะลบไฟล์หรือไม่')) {
			
			$.ajax({
				  url: pathFixed + 'index.php/file_upload/fnDelete_files?_=' + new Date().getTime(),
		    	  data: { refx: $files.RowNo },
		          type: "POST",
		          beforeSend:function() {},
		          success:function(responsed) {				
		        	  if(responsed.status) {
		        		  $files.Extension = 'N';
		        		  $scope.noitfyconfig.message = 'ลบข้อมูลสำเร็จ';
		        		  Notification.success( $scope.noitfyconfig);
		        	  } else {
		        		  $scope.noitfyconfig.message = 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่';
		        		  Notification.error( $scope.noitfyconfig );
		        	  }
		          },
		          cache: false,
		          timeout: 5000,
		          statusCode: {
			  	        404: function() { console.log("page not found" ); },
			  	        407: function() { console.log("Proxy Authentication Required"); },
			  	        500: function() { console.log("internal server error"); }
		          }				  		     
			});
			
		}
		
		return false;
		
	}

	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss({ status: 'cancel', state: $scope.state_change });
	};

	$scope.panel_collapsed = function(elem) {
		var $this = $('#' + elem);
		if(!$this.hasClass('panel-collapsed')) {
			$this.parents('.panel').find('.panel-body').slideUp();
			$this.addClass('panel-collapsed');
			$this.find('i').removeClass('fa fa-chevron-circle-up').addClass('fa fa-chevron-circle-down');
		} else {
			$this.parents('.panel').find('.panel-body').slideDown();
			$this.removeClass('panel-collapsed');
			$this.find('i').removeClass('fa fa-chevron-circle-down').addClass('fa fa-chevron-circle-up');
		}		
	}

})
.controller('modalDecisionConfirmDefendCtrl', function($scope, $filter, help, Notification, $uibModalInstance, $q, items) {	
	
	$scope.primarydata = items;
	$scope.decision_list = state_config;
	
	$scope.topic_item = null;
	$scope.topic_remark = null;
	
	$scope.topic_text_handle = false;
	$scope.btnsave_enable = true;
	
	$scope.rate = 0;
	$scope.max = 5;
	$scope.isReadonly = (items[3] && items[3].editRating == true) ? false:true;
			
	
	$scope.hoveringOver = function(value) {
	    $scope.overStar = value;
	    $scope.percent = 100 * (value / $scope.max);
	};
	
	$scope.noitfyconfig  = { 
		positionY: 'top', 
		positionX: 'right' 
	};	
	
	$scope.onSubmit = function(param, info) {				
		if(param[0]) {			
			switch(param[0]) {
				case state_config.mgrCommit:
					// ADD NEW 14 NOV 2018
					if(confirm('กรุณาตรวจสอบข้อมูลให้ครบถ้วน เพื่อป้องกันข้อมูลผิดพลาด \n\rหมายเหตุ: ปัจจุบันสามารถส่งเคสการ Defend ได้วันละ 1 ครั้ง/วัน \n\rกรณียืนยันการส่งข้อมูลโปรคลิก OK')) {
						confirmDicisionManagement(param, info);
						return true;
					}
					
					return false;
								
				break;
				case state_config.mgrReturn:
				case state_config.mgrCancel:	
					confirmDicisionManagement(param, info);
				break;
			}
			
		}
	};

	$scope.$watch('topic_item', function(n, o) {	
		if(n) { //
			if(help.in_array(n, [state_config.mgrCancel])) {		
				$scope.rate = 0;
				$scope.topic_text_handle = true;
				
				$scope.$watch('topic_remark', function(str) {	
					if(str && str !== '') {
						$scope.btnsave_enable = false;
					} else {
						$scope.btnsave_enable = true;
					}
				});	
				
			} else {				
				
				if(help.in_array(n, [state_config.mgrReturn])) {
					$scope.topic_text_handle = true;										
				} else {
					$scope.topic_text_handle = false;	
					$scope.topic_remark = null;
				}
				
				$scope.$watch('rate', function(rate) {	
					if(rate) {			
						if(help.in_array(n, [state_config.mgrReturn])) {
							$scope.$watch('topic_remark', function(str) {	
								if(str && str !== '') {
									$scope.btnsave_enable = (rate > 0) ? false:true;
								} else {
									$scope.btnsave_enable = true;
								}
							});										
						} else {
							$scope.btnsave_enable = (rate > 0) ? false:true;				
						}
								
					}
					
				});
			}
			
			
		} else {
			$scope.btnsave_enable = true;			
		}
	});	
	
	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss({ status: 'cancel' });
	};
	
	function confirmDicisionManagement(param, info) {
		if(confirm(msg_config.save)) {
			var request_data = {
				DocID: info[0],
				DefendProgress: (param[0]) ? param[0]:null,
				DefendScore: $scope.rate,
				Remark: (param[1]) ? param[1]:null,
				RequestID: info[2][0].EmployeeCode,
				RequestBy: info[2][0].FullNameTh
			};
	
			help.executeservice('post', (path_uri + '/updateDefendProgress'), request_data).then(function(resp) {
				if(resp.status === 200) {					
					var data = resp.data;					
					$scope.noitfyconfig.title = 'แจ้งเตือนจากระบบ'
					$scope.noitfyconfig.message = 'ระบบดำเนินการเปลี่ยนสถานะใหม่สำเร็จ';		
					$scope.noitfyconfig.positionX = 'right';
					$scope.noitfyconfig.positionY = 'bottom';
					$scope.noitfyconfig.delay = 10000;				
					Notification.success($scope.noitfyconfig);
					
					if(param[0] === state_config.mgrCommit) {
						confirmGeneratePDF(info);
					}

					$uibModalInstance.dismiss({ status: 'cancel', state: true });
					
					delete param;
					delete data; 
				
				}
			});
			
		}
	}
	
	function confirmGeneratePDF(info) {	
		var param = {
			DocID 	   : info[0],
			DefendRef  : info[1],
	        CreateID   : info[2][0].EmployeeCode,
	        CreateBy   : info[2][0].FullNameTh
		};
		
		generatePDF(param);		
	}
	
	// MODIFY ON 04/04/2018
	function generatePDF(param) {
		
		var url_api    = (path_uri + '/defend_issue/xid/' + param.DocID + '/pdf/Y/defend_topic_issue');
		help.executeservice('get', url_api).then(function(resp) {			
			if(resp.status == 200) {
				
				var data = resp.data;
				var header = (data.DefendHeader[0]) ? data.DefendHeader[0]:null;				
				var objData = (data.DefendLogs && data.DefendLogs.length > 0) ? data.DefendLogs:null;
				var content = (objData && objData.length > 0) ? _.orderBy(objData, ['UpdateDate'], ['desc']) : null;
				var reactive = (data.DefendReactive && data.DefendReactive.length > 0) ? data.DefendReactive:null;
				
				var docid = (header && header.DocID) ? header.DocID:'';
				var appno = (header && header.ApplicationNo) ? header.ApplicationNo:'';
				
				// RESULT ROWS 2
				var lbname = (header && header.BranchName) ? header.BranchName:'-';
				var custname = (header && header.BorrowerName) ? header.BorrowerName:'-';
				var defname = (header && header.DefendName) ? header.DefendName:'-';
				var caname = (header && header.CAName) ? header.CAName:'-';
				
				var lbname_tel = (header && header.BranchTel) ? 'โทร : ' + header.BranchTel:'';
				var custname_tel = (header && header.BusinessType) ? 'ประเภทธุรกิจ : ' + header.BusinessType:'';
				var defname_tel = (header && header.DefendMobile) ? 'โทร : ' + header.DefendMobile:'';
				var caname_tel = (header && header.CAMobile) ? 'โทร : ' + header.CAMobile:'';
				
				// RESULT ROWS 3
				var rm_name = (header && header.RMName) ? header.RMName:'-';
				var bm_name = (header && header.BMName) ? header.BMName:'-';
				var am_name = (header && header.AMName) ? header.AMName:'-';
				var rd_name = (header && header.RDName) ? header.RDName:'-';
				
				var rm_name_tel = (header && header.RMMobile) ? 'โทร : ' + header.RMMobile:'';
				var bm_name_tel = (header && header.BMMobile) ? 'โทร : ' + header.BMMobile:'';
				var am_name_tel = (header && header.AMMobile) ? 'โทร : ' + header.AMMobile:'';
				var rd_name_tel = (header && header.RDMobile) ? 'โทร : ' + header.RDMobile:'';
				
				var col_root_header = 'INFORMATION (APPNO: ' + appno + ')';
				
				var col_second_lb = 'LB : ' + lbname;
				var col_second_cust = 'CUST : ' + custname;
				var col_second_defname = 'DEF : ' + defname;
				var col_second_ca = 'CA : ' + caname;
				
				var actor_name = (defname && defname !== '-') ? defname : param.CreateBy;
				
				var docDefinition = {
					info: {
						title: appno,
						author: actor_name,
						subject: 'ใบชี้แจ้งรายละเอียดเพื่อขอแก้ไขผลพิจารณ์สินเชื่อ' + ' (' + appno + ')',
						keywords: 'Request Defend',
					 },
					 header: {
						 columns: [
							 { text: 'Create Date: ' + moment().format('DD/MM/YYYY HH:mm'), style: 'header', alignment: 'left', margin: [ 40, 5, 0, 5 ] }, 
							 { text: 'Create Name: ' + actor_name, style: 'header', alignment: 'right', margin: [ 0, 5, 40, 0 ] }
						 ]
					 },
					 content: [
						 {
							 style: 'tableStyle',
						     table: {
						        headerRows: 1,
						        widths: '*',
						        body: [
						          [
						        	  { text: col_root_header, style: 'tableHeader', colSpan: 4, alignment: 'left' },
						        	  { text: '', style: 'tableHeader' },
						        	  { text: '', style: 'tableHeader' },
						        	  { text: '', style: 'tableHeader' }
						          ],
						          [ 
						        	  { stack: [{ text: col_second_lb, style: 'tableContent' }, { text: lbname_tel, style: 'tableContent' }] },
						        	  { stack: [{ text: col_second_cust, style: 'tableContent' }, { text: custname_tel, style: 'tableContent' }] },
						        	  { stack: [{ text: col_second_defname, style: 'tableContent' }, { text: defname_tel, style: 'tableContent' }] },
						        	  { stack: [{ text: col_second_ca, style: 'tableContent' }, { text: caname_tel, style: 'tableContent' }]  }						        				        	  
						          ],
						          [ 
						        	  { stack: [{ text: rm_name, style: 'tableContent' }, { text: rm_name_tel, style: 'tableContent' }] },
						        	  { stack: [{ text: bm_name, style: 'tableContent' }, { text: bm_name_tel, style: 'tableContent' }] },
						        	  { stack: [{ text: am_name, style: 'tableContent' }, { text: am_name_tel, style: 'tableContent' }] },
						        	  { stack: [{ text: rd_name, style: 'tableContent' }, { text: rd_name_tel, style: 'tableContent' }]  }
						          ]
						        ]
						      }
						 }						 
					],
					styles: {
						header: { fontSize: 10 },
						tableStyle: {
							fontSize: 9
						},
						tablePanelStyle: {
							fontSize: 9,
							margin: [0, 5, 0, 5]
						},
						tableHeader: {
							color: 'white',
							fillColor: '#4390df'
						},
						tableContent: {
							color: 'black'
						}
					},
					defaultStyle: { font: 'Kanit' }					 
				};

				var get_checklist = [];
				if(content && content.length > 0) {
					_.forEach(content, function(item, i) {
						if(!help.in_array(item.DefendCode, ['SP001', 'SP002'])) {
							var str_content = (item.DefendNote) ? splitHTML(item.DefendNote):'';					
							if(str_content && str_content !== '') {
								docDefinition.content.push(
									{
										style: 'tablePanelStyle',
									    table: {
									        headerRows: 1,
									        widths: '*',
									        body: [
									          [
									        	  { text: 'หัวข้อ' + item.DefendReason, style: 'tableHeader', colSpan: 4, alignment: 'left' },
									        	  { text: '', style: 'tableHeader' },
									        	  { text: '', style: 'tableHeader' },
									        	  { text: '', style: 'tableHeader' }
									          ],
									          [ 
									        	  { text: str_content, style: 'tableContent', colSpan: 4, alignment: 'left' },
									        	  { text: '', style: 'tableContent' },
									        	  { text: '', style: 'tableContent' },
									        	  { text: '', style: 'tableContent' }
									          ]
									       ]
									     }
									}
								);
								
								get_checklist.push('TRUE');
							}
						} else{
							get_checklist.push('FALSE');
						}						
					});
				} 
	
				if(reactive && reactive.length > 0) {		
					var refer_code = [];
					var label_name = [];
					
					_.each(reactive, function(val, index) { 
						if(val.IsVisible && val.IsVisible == 'Y') {
							label_name.push(val.DefendReason); 
							refer_code.push(val.DefendCode); 
						}					
					});						

					if(refer_code && refer_code.length > 0) {
						refer_code = _.uniq(refer_code);
						label_name = _.uniq(label_name);
	
						_.each(refer_code, function(val, index) { 
							var findData = _.filter(reactive, { DefendCode: val });							
							var reactive_data = {
								style: 'tablePanelStyle',
							    table: {
							        headerRows: 1,
							        widths: '*',
							        body: [
							          [
							        	  { text: 'Reactivation History: หัวข้อ' + label_name[index], style: 'tableHeader', colSpan: 4, alignment: 'left' },
							        	  { text: '', style: 'tableHeader' },
							        	  { text: '', style: 'tableHeader' },
							        	  { text: '', style: 'tableHeader' }
							          ]							         
							       ]
							     }
							}
		
							if(findData[0]) {			
								_.each(findData, function(val, index) { 
									var str_content = (val.DefendNote) ? splitHTML(val.DefendNote):'';		
									reactive_data.table.body.push(
										[ 
								        	  { text: str_content, style: 'tableContent', colSpan: 4, alignment: 'left' },
								        	  { text: '', style: 'tableContent' },
								        	  { text: '', style: 'tableContent' },
								        	  { text: '', style: 'tableContent' }
								        ]
									);
								});								
								docDefinition.content.push(reactive_data);							
							}	
						});
						
						get_checklist.push('TRUE');
						
					} else{
						get_checklist.push('FALSE');
					}									
				} 
				
				if(!help.in_array('TRUE', get_checklist)) {
					docDefinition.content.push(
						{
							style: 'tablePanelStyle',
						    table: {
						        widths: '*',
						        body: [
						          [
						        	  { text: 'ไม่พบข้อมูลในระบบ (หมายเหตุ: เจ้าของเคสอาจยังไม่ได้อัพเดทข้อมูลในระบบ)', style: 'tableHeader' , colSpan: 4, alignment: 'center' },
						        	  { text: '', style: 'tableHeader' },
						        	  { text: '', style: 'tableHeader' },
						        	  { text: '', style: 'tableHeader' }
						          ]
						       ]
						     }
						}
					);
				}

				$scope.noitfyconfig.title = 'แจ้งเตือนจากระบบ';
				$scope.noitfyconfig.delay = 15000;
				
				//pdfMake.createPdf(docDefinition).open();
				
				pdfMake.createPdf(docDefinition).getBuffer(function(buffer) {
					var blob = new Blob([buffer]);
					var reader = new FileReader(); 
		
					reader.onload = function(event) {
					var fd = new FormData();
					     fd.append('fname', 'test.pdf');
					     fd.append('data', event.target.result);		
					     $.ajax({
						      type: 'POST',
						      url: pathFixed + 'index.php/defend_control/savePDF?appx=' + appno + '&docx=' + docid, 
						      data: fd,
						      processData: false,
						      contentType: false
					     }).done(function(data) {					    	
					    	 var resp = JSON.parse(data);
					    	 if(parseBool(resp.status) || resp.status == 'true') {					    		 
					    		 $scope.noitfyconfig.message = 'ระบบสร้างเอกสาร หมายเลข ' + appno + ' สำเร็จ, ระบบดำเนินการจัดส่งไฟล์เอกสารถึง CA สำเร็จ';
				        		 Notification.success($scope.noitfyconfig);
					    	 } else {
					    		 $scope.noitfyconfig.message = 'CA on process (Defend) ขณะนี้ไฟล์ PDF หมายเลข ' + appno + ' กำลังถูกเปิดใช้งาน  ไม่สามารถบันทึกได้ในขณะนี้ โปรดลองใหม่อีกครั้งในเวลาถัดไป (หรือรอระบบส่งงานให้อัตโนมัติในวันถัดไปเวลา 8.00 น.)';
				        		 Notification.error($scope.noitfyconfig);
					    	 }
					    	 
					    	 $uibModalInstance.dismiss({ status: 'cancel', state: true });					    	
					     });
					};
					reader.readAsDataURL(blob);				
				});
					
			}
			
		});		
		
		function splitHTML(html) {
		    var div = document.createElement("div"), nodes;
		    div.innerHTML = html;
		    nodes = [].slice.call(div.childNodes);
		 
		    var str_note = _.map(nodes, function(data, index) {
		    	
		    	var lineBreak = '';
		    	var lineHorizon = '';
		    	
		    	if(data.tagName == 'P' && (index + 1) !== nodes.length) {
		    		lineBreak = '\n';
		    	}
		  
		    	var str_text = (data) ? elementRount(data) : '';
		    	return str_text + lineBreak;
		    	
		    });
		 
		    return str_note;
		}
		
		function elementRount(elemetns) {
			switch (elemetns.tagName) {
				case 'P':
				case 'DIV':
				case 'SPAN':
					return elemetns.innerText;
				case 'HR':
					return '------------------------------------------------------------------------------------------------------------------------\n';
				default:
					console.log('Tagname ' + elemetns.tagName + ', No specified');
					return '';
					break;
			}			
		}
	
		function removeTags(n,t){return t?n.split("<").filter(function(n){return i(t,n)}).map(function(n){return i(t,n)}).join(""):n.split("<").map(function(n){return n.split(">").pop()}).join("");function i(n,t){return-1!=n.map(function(n){return t.includes(n+">")}).indexOf(!0)?"<"+t:t.split(">")[1]}}
		
	}
	
})
.controller('ctrlLoadActionNote', function($scope, $filter, help, $uibModalInstance, $q, items) { 

	$scope.itemList = null;
	$scope.progress = true;
	$scope.noteinfo	= false;
	$scope.modalToggle = false;
	
	$scope.headinfo = {
		custname  : null,
		appnumber : null
	}

	$scope.modalHeight = '350px';
	if(items.DocID) {
		help.executeservice('get', (path_uri + '/defend_note/xid/' + items.DocID + '/action_note')).then(function(resp) {
			if(resp.status == 200) {
			    $scope.itemList = resp.data;
			    $scope.headinfo.BorrowerName  = (items.Data) ? items.Data.BorrowerName:'';
			    $scope.headinfo.AppNo = (items.Data) ? items.Data.ApplicationNo:'';
			    $scope.progress = false;	
		
				_.delay(function() { 
					$scope.noteinfo = true;
					$scope.setModalHeight($scope.modalToggle);	
				});
			}
		});

	}
	
	
	$scope.setModalHeight = function(height) {
		var height_table = $('.scrollArea > table').height();
		if(!height) {
			$scope.modalHeight = 'height: ' + (height_table + 37) + ', -webkit-transition: all 0.5s ease-in-out, transition: all 0.5s ease-in-out';
			$('.scrollableContainer').css({ 'min-height': '0px', 'height': (height_table + 37), '-webkit-transition': 'all 0.5s ease-in-out', 'transition': 'all 0.5s ease-in-out' });
			$scope.modalToggle = true;
		} else {
			$scope.modalHeight = 'height: 350px, -webkit-transition: all 0.5s ease-in-out, transition: all 0.5s ease-in-out';
			$('.scrollableContainer').css({ 'min-height': '350px', 'height': '350px', '-webkit-transition': 'all 0.5s ease-in-out', 'transition': 'all 0.5s ease-in-out' });
			$scope.modalToggle = false;
		}
	}

	$scope.dismiss_modal = function () { $uibModalInstance.dismiss('cancel'); };
	
});

function isEmpty(n){return n&&""!==n||void 0!==n?n:null}
function empty(t){return!isEmpty(t)}
function parseBool(o){return"boolean"==typeof o?o:"number"==typeof o?1===o||0!==o&&void 0:"string"==typeof o?"true"===o.toLowerCase():void 0}
function setDateRangeHandled(Y){if(Y){var t="",e="";if(new RegExp("-").test(Y)){var n=Y.split("-");t=n[0].trim(),e=n[1].trim()}else t=Y,e=Y;return[moment(t,"DD/MM/YYYY").format("YYYY-MM-DD"),moment(e,"DD/MM/YYYY").format("YYYY-MM-DD")]}return null}
function getQueryParams(e){e=e.split("+").join(" ");for(var o,n={},r=/[?&]?([^=]+)=([^&]*)/g;o=r.exec(e);)n[decodeURIComponent(o[1])]=decodeURIComponent(o[2]);return n}
function roundFixed(n,r){return Number(Math.round(n+"e"+r)+"e-"+r)}
function numberWithCommas(n){var r=n.toString(),e=r.indexOf(".");return r.replace(/\d(?=(?:\d{3})+(?:\.|$))/g,function(n,r){return e<0||r<e?n+",":n})}
function generateArr(r){for(var e=1,n=[],t=0;t<r;t++)n.push(e),e++;return n}
function isFloat(x) { return !!(x % 1); }

function localStorageWrite(parent_key, key, value) {
    if (localStorage) {
        localStorage.setItem(parent_key, JSON.stringify({ [key]: value }));
    }
}

function localStorageRead(parent_key, key) {
    let ls = {};
    if (localStorage) {
        try { ls = JSON.parse(localStorage.getItem(parent_key)) || {} } 
        catch (e) {}
    }
    return ls[key];
}

function localStorageClear() {
	localStorage.clear();
}
