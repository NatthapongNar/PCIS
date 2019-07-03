var links = "http://172.17.9.94/newservices/LBServices.svc/";
var pcisWhiteboardModule = angular.module('whiteboardSaleModule', ["pcis-collection", "pcisDrawDownTemplate", "angular.filter", "checklist-model", "ui.mask"])
.controller("pcisCtrlWhiteobard", function($scope, socket, $filter, help, $uibModal, $log, $compile, $http) {
	
	var cilent_id = $('div[ui-chat-client]').attr('ui-chat-client');
	var width  	  = $(document).width() - 10;
	var height    = $(document).height() - 310;
	
	if(cilent_id) {
		
		$scope.cilent_id = cilent_id;
		
		// Filter Config
    	$scope.multiple_config  = { width: '100%', filter: true, minimumCountSelected: 2, single: false }
    	$scope.condition_filter = {};
		
    	// Model Config
		var icon_time = '<i class="fa fa fa-flag-o print_hold">';
		var colname = [
       	    { label: 'START', name: 'StartDate', title: false, frozen: false, sortable: false },
       	    { label: icon_time, name: 'TotalOnProcessCount', title: false, frozen: false, sortable: false },
       	    { label: 'CUSTOMER', name: 'BorrowerName', title: false, frozen: false, sortable: false },
       	    { label: 'RM', name: 'RMName', title: false, frozen: false, sortable: false },
       	    { label: 'LB', name: 'BranchDigit', title: false, frozen: false, sortable: false },
       	    { label: 'PG', name: 'Product', title: false, frozen: false, sortable: false },
       	    { label: 'AMT', name: 'RequestAmount', title: false, frozen: false, sortable: false },
       	    { label: icon_time, name: 'RMOnhandCount', title: false, frozen: false, sortable: false },
       	    { label: 'DATE', name: 'A2CADate', title: false, frozen: false, sortable: false },
       	    { label: 'CA', name: 'CAName', title: false, frozen: false, sortable: false },
       	    { label: 'ST', name: 'Status', title: false, frozen: false, sortable: false },
       	    { label: 'DATE', name: 'StatusDate', title: false, frozen: false, sortable: false },
       	    { label: 'AMT', name: 'ApprovedLoan', title: false, frozen: false, sortable: false },
       	    { label: icon_time, name: 'CAOnhandCount', title: false, frozen: false, sortable: false },
       	    { label: 'PLAN', name: 'PlanDrawdown', title: false, frozen: false, sortable: false },
       	    { label: 'ACTUAL', name: 'DrawdownDate', title: false, frozen: false, sortable: false },
       	    { label: 'AMT', name: 'ApprovedLoan', title: false, frozen: false, sortable: false },
       	    { label: icon_time, name: 'DrawdownCount', title: false, frozen: false, sortable: false },
       	    { label: 'ACTION NOTE', name: 'ActionNote', title: false, frozen: false, sortable: false }
     	];
       	
       	// Grid Group Header
       	$scope.thead_group = [
       	    { "numberOfColumns": 2, "titleText": "DATE", "startColumnName": 'StartDate' },
       	    { "numberOfColumns": 3, "titleText": "CUSTOMER", "startColumnName": 'BorrowerName' },
       	    { "numberOfColumns": 3, "titleText": "LOAN REQUEST", "startColumnName": 'Product' },
       	    { "numberOfColumns": 2, "titleText": "A2CA", "startColumnName": 'A2CADate' },
       	    { "numberOfColumns": 4, "titleText": "STATUS ( P / A / R / C ) & CR", "startColumnName": 'Status' },
       	    { "numberOfColumns": 4, "titleText": "DRAWDOWN DATE", "startColumnName": 'PlanDrawdown' },
       	    { "numberOfColumns": 1, "titleText": "ACTION NOTE", "startColumnName": 'ActionNote' }
       	];
       	
       	// Grid Configulation
    	$scope.config = {
    		id: 'grid_container',
    		data: [],
    		datatype: "local",
    		colModel: colname,
        	styleUI : 'Bootstrap',
        	loadui: "block",    	
        	loadtext: "", 
        	rownumbers: false,		        
        	toppager: false,	   
        	shrinkToFit: true,    
        	viewrecords: true,
        	height: height,
        	width: width, 
        	pager: '#grid_pager',
        	sortname: 'CREATE',
        	sortorder: 'desc',
        	rowNum: 200,
            rowList: [20, 50, 100, 200, 300, 500],
            footerrow: false,
            onSortCol: function(index, colIndex, sortOrder) {}
        };
			
       	// Pagination
    	$scope.paging_info = null;
    	$scope.sort_order  = null;
    	$scope.total_loan  = null;
    	    	
    	function loadGridWhiteboard() {
    		
    		var $param = {};
    		help.loadGridWhiteboard($param).then(function(resp) {
    			console.log(resp);
    			/*
    			$scope.dataList = resp.data;
    			$.each(resp.data, function(index, value) {
    				data_collection.push(
    					{   
    						RUNNO: [value.ApplicationNo, value.DocID],
    						CREATE: (value._CreateDate !== null) ? value._CreateDate:null,
    						DOC_ID: value.DocID,
    						APP_NO: value.ApplicationNo,
    						MISS_DOC: value.MissingDoc,
    						PEO_REF: value.FlagReference,
    						SCORE: value.EndScore,
    						CUST_NAME: value.CustName,
    				    	CUST_TYPE: value.CustType,
    				    	ID_CARD: value.CitizenID, 
    				    	RM: value.RMName,
    				    	RMMOBILE: value.RMMobile,
    				    	LBNAME: value.Branch,
    				    	LBCH: value.Channel,
    				    	LBDigit: value.BranchDigit,
    				    	LBTEL: value.BranchTel,
    				    	PRODUCT: value.ProductProgram,
    				    	PRODUCT_TYPE: value.ProductType,
    				    	ANALYST: value.CAName, 
    				    	APP_STATE: value.Status, 
    				    	BANKBOOK: (value.BookBankStatus !== "") ? value.BookBankStatus:'',
    				    	BANKBOOKFLAG: (value.BookBankFlag !== "") ? value.BookBankFlag:'',
    				    	CONTRACTFILE: value.ContactFileDetail,
    				    	CR_LINE: (value.ApprovedLoan > 0) ? value.ApprovedLoan:'',
    				    	OPER_FLAG: value._RecieveFileDateTime,
    				    	OWNERDOC: value.OwnershipDoc,
    				    	FILESTATUS: 'FILESTATUS',
    				    	APPRAISAL_STATUS: value.AppraisalStatus,
    				    	PLAN_DRAWDOWN: (value._PlanDrawdownDate !== null) ? moment(value._PlanDrawdownDate).format('YYYY-MM-DD'):null,
    				    	ASSET_STATE: 'AssetStatus',
    				    	ASSET_DATE: 'ASSET_DATE',		
    				    	COLLATERAL: value.CollateralData,
    				    	DISTRICT: 'Tambol',
    				    	AMPHUR: 'Amphur',
    				    	PROVINCE: 'Province',
    				    	DEP_LAND: 'DEP_LAND',
    				    	WHO: 'PaymentChannel',
    				    	REFINANCE: 'REFINANCE',
    				    	PAYMENT: 'PayType',
    				    	OPERCONF: value.FlagConfirm,
    				    	KYC: (value.KYC == 'Y') ? value.KYC:'',
    				    	CASHY: value.Cashy,
    				    	CASHY_AMT: ( value.Cashy == 'Y' && value.CashyAmt > 0) ? value.CashyAmt:'',
    				    	NOTE: value.NoteData,
    				    	NOTEFUNC: value.Team,
    				    	COMPLETE_STATE: value.Complete,
    				    	COMPLETE_DATE: (value._CompleteDate !== null) ? help.formattedDate(value._CompleteDate):null,
    				    	_PlanDrawdown: value._PlanDrawdownDate,
    				    	_DecisionDate: value._DecisionDate,
    				    	_RecieveFileDateTime: value._RecieveFileDateTime,
    				    	_NoteUpdateDate: value.NoteUpdateDate,
    				    	_CompletedDate: value._CompleteDate
    				    	
    			        }
    				);
    				
    				$scope.totalCRLINE += (value.ApprovedLoan !== '') ?  parseInt(value.ApprovedLoan):0

    			});

    			$scope.config.data = data_collection;
    			*/
    			
    		});
    		
    	}
		
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
		   		   		'<span><b class="tooltip-bottom" data-tooltip="' + mobile + '">' + result[0].FullNameEng.toUpperCase() + '</b> (' + nickname + ') </span> <br/>' +
		   				'<span class="sub-desc">' + corp + '</span>' +
		   		   '</div>';  

	     	   $('#position_title').val(result[0].Position);
	             	   
	     	   $('.using_information').html('');
	     	   $(html).hide().appendTo(".using_information").fadeIn(1000);
	  
	        }
			
		});
		
	}
	
});