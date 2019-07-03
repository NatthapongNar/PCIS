var links = "http://172.17.9.94/newservices/LBServices.svc/";
var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -3); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
var query  = getQueryParams(document.location.search);

angular.module('pcisDefendModule', ["pcis-collection", "angular.filter", "textAngular", "ui-notification", "angularFileUpload"])
.config(function($provide) {
	
	$provide.decorator('taOptions', ['$delegate', function(taTools){
		taTools.toolbar = [
			[],
			['bold', 'italics', 'underline', 'ul', 'ol', 'redo', 'undo', 'clear'],
			['justifyLeft','justifyCenter','justifyRight','justifyFull','indent','outdent'],
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
.directive('inputFieldDaterange', function() {
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			
			new Kalendae.Input(attrs.id, {
				months:2,
				mode:'range',
				format: 'DD/MM/YYYY',
				useYearNav: true,
				//direction: 'today-future'
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
            			type = option.match(regx)[0];
            			 
                 		var defaultValue = angular.isArray(n) ? n.map(function(item){return type+item;}) : [type+n];
                 		$(element).multipleSelect('setSelects', defaultValue);
                 	
            		}
            	
        		});

        	}, true);
        
        }
    };
    
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
.controller('defendDashboard', function($scope, $filter, help, Notification, $uibModal) {
	
	$scope.userinfo	 	= null;
	$scope.chain_record = false;	
	$scope.pagingInfo	= 'No records to view';
	$scope.cilent_id 	= angular.element('body').data('id');
	$scope.user_role 	= angular.element('body').data('role');
	$scope.defend_actor = getUserDefendList();
	$scope.defend_full	= getUserDefendListFull();
	
	$scope.open_inbox	= false;
	$scope.inbox_open_handler = function() {
		$scope.open_inbox = true;
	}
	
	$scope.inbox_close_handler = function() {
		$scope.open_inbox = false;
	}
	
	$scope.multi_config  = { width: '100%', filter: true, minimumCountSelected: 2, single: false }
	$scope.modalEditMode = function() {
		$scope.chain_record = !$scope.chain_record;
	};
	
	var width  = $(document).width() - 5;
	var height = $(document).height() - 310;
	
	var missingHandled = function (value, model, rowData) {
		var attr = 'ng-click="config.loadMissingList(\'' + rowData.itemHead.DocID + '\')"';	
		return '<span ' + attr + '>' +
			   		'<span class="icon-copy fg-steel" style="font-size: 1.3em; cursor: pointer; margin-right: 5px;"></span>' +
			   		'<span class="badge bg-amber" style="font-size: 0.8em; position: absolute; margin-top: -7px; margin-left: -15px;">' + rowData.itemHead.MissingDoc + '</span>' +
			   '</span>';
	}
	
	var NumOfColorState = function($nums) {
		if($nums <= 2) {
    		return '<div class="fg-emerald">' + $nums + '</div>';
    
    	} else if($nums >= 3 && $nums <= 4) {
    		return '<div class="fg-amber">' + $nums + '</div>';
    		 
    	} else if($nums >= 5) {
    		return '<div class="fg-red">' + $nums + '</div>';
    
    	}
	}
	
	var brnHandled = function(str_name, model, rowData) {

		var brn_name = (rowData.itemHead.BranchName) ? rowData.itemHead.BranchName:null;
		var brn_tels = (rowData.itemHead.BranchTel) ? rowData.itemHead.BranchTel:null;
		 
		var str_text = brn_name + ' (' + brn_tels + ')';
		
		var division	= '';
		division += 
		'<div style="margin-left: -22px;">' + 
			'<span class="tooltip-right" data-tooltip="' + str_text + '" style="position: absolute; margin-left: -7px; margin-top: 0px;">' +
				str_name +
			'</span>' +
		'</div>';
		
		return division;
	}
	
	var nameHandled = function(str_name, model, rowData) {
	
		var division	= '';
		var str_blink	= 'fg-darkBlue';
		
		var data_model	= (rowData.itemHead) ? rowData.itemHead:null;
		var data_logs	= (rowData.itemLogs) ? rowData.itemLogs:null; 
		var logs_list   = rowData.itemLogs.length;

		if(logs_list > 0) {
			
			str_blink 		= 'nav_icon icon_blink fg-red nonprint';
			var note_date	= (data_logs[0]) ? moment(data_logs[0].CreateDate).format('DD/MM (HH:mm)'):'';			
			var str_note 	= 
			"<div data-row-data='{ DocID: \"" + data_logs[0].DocID + "\", DefendRef: " + data_logs[0].DefendRef + ", DefendCode: \"" + data_logs[0].DefendCode + "\", UserInfo: " + JSON.stringify(rowData.userInfo[0]) + " }' ng-click='config.modalNoteIntervalTime($event)' class='" + str_blink + "'>" +
				'Note: ' + note_date + 
			'</div>';
			
		} else { var str_note = ''; }

		division += '<div style="display: inline-block; padding-top: 3px; text-align: left; font-size: 0.9em;">' + str_note + '</div>';
		return str_name + division;
		
	}
	
	var statuscharacter = function(value, model, rowData) {
		switch(value) {
			case 'PENDING': return 'P'; break;
			case 'APPROVED': return 'A'; break;
			case 'REJECT': return 'R'; break;
			case 'CANCEL': return 'C'; break;
			case 'CANCELBYRM':
			case 'CANCELBYCA':
			case 'CANCELBYCUS':
				return 'C';
				break;
			default: 
				return ''; 
			break;
		}
	}
	
	var statusresponed = function(value, model, rowData) {
		if(value !== '') return value;
		else return rowData.itemHead.Status;
	}
	
	var liveactionstate = function(value, model, rowData) {
		
		var tooltip	  = '';
		var classes	  = '';
		var styles	  = '';
		var strcolor  = '';
		var text_note = rowData.itemHead.ActionNote;
		var text_date = moment(rowData.itemHead.ActionNoteDate).format('DD/MM/YY');
		
		//if(model.rowId == '1') tooltip = 'tooltip-bottom';
		//else tooltip = 'tooltip-top';
		tooltip = 'tooltip-left';
		
		if(moment(rowData.itemHead.ActionNoteDate).format('DD/MM/YY') == moment().format('DD/MM/YY')) { strcolor  = 'fg-red'; }
		
		if(text_note !== '') {
			styles	  = 'style="padding-top: 10px; margin-left: 0px; min-width: 193px; max-width: 193px;"';	
			classes	  = 'class="' + tooltip + ' ' + strcolor + ' nonprint print_notewidth"'; // data-tooltip="' + text_note + '"
		} else {
			styles	  = 'style="padding-top: 10px; padding-left: 0px; min-width: 193px; max-width: 193px;"';
			classes	  = 'class="nonprint print_notewidth"';
		}
		
		var custname  = '';
		var text_string	  = '';
		if(value.length > 25) {
			var item_list = rowData.itemList.length;
			custname  = value.substring(0, 30) + '...';
		
			var result_string = splitEvery(text_note, 30);
			if(result_string[0] !== '' || result_string[0] !== undefined) {
				$.each(result_string, function(index, value) {
					text_string += value + '<br />';
				});				
			} 
			
		} else {
			custname  = value;
		}
		
		function splitEvery(str, n) {
		    var arr = new Array;
		    for (var i = 0; i < str.length; i += n) {
		        arr.push(str.substr(i, n));
		    }
		    return arr;
		}
		
		if(!text_string && text_string == "") {
			text_string  = value;
		}
		
		var strname_clean = '';
		if(custname && custname !== "") {
			var strclean  = custname.replace(/(?:\r\n|\r|\n)/g, '<br />');
			strname_clean = strclean.replace(/<\/?[^>]+(>|$)/g, "");
		}
	
		var str_icon = 
			'<span title="' + value + '" ' + classes + ' ' + styles + ' >' + 
				"<i data-row-data='{ DocID: \"" + rowData.DocID + "\", AppNo: \"" + rowData.itemHead.ApplicationNo + "\", BorrowerName: \"" + rowData.itemHead.BorrowerName + "\" }' ng-click='config.loadActionNoteList($event)' class=\"fa fa-commenting-o nav_icon marginRight5\" style=\"font-size: 1.2em !important; color: dodgerblue;\"></i>" + 
				strname_clean + 
			'</span>'+
			'<div class="printable">' + text_string + '</div>';
			
		return str_icon;
		
	}
	
	var divisionLayer = function(value, model, rowData) {

		var classes	  = '';
		var optional  = '';
		var division  = '';
		
		var item_list = rowData.itemList.length;
		var case_item = rowData.itemList.length - 1;
		if(item_list > 0) {
		
			$.each(rowData.itemList, function(k, v) {
				
				var assign_padding = ['DefendProgress'];	
				if(item_list > 1) {
					classes = 'class="grid_layer"';
				} else {
					if(help.in_array(value, assign_padding)) { classes = 'class="marginLeft5"'; };
					optional = 'style="padding-top: 7px;"';
				}
				
				switch (value) {
					case 'IssueList':
						
						var icon_warning = '';
						
						/*
					    if(!help.in_array(rowData.itemList[k].DefendProgress, ['Completed', 'Incompleted'])) {
							if(rowData.itemList[k].AssignmentDate && rowData.itemList[k].AssignmentDate !== '') {
								var date_latest  = new Date(); 
								var earliermonth = moment(rowData.itemList[k].AssignmentDate).format('MM')-1;
								var earlierdate  = new Date(moment(rowData.itemList[k].AssignmentDate).format('YYYY'), (earliermonth < 0) ? 0:earliermonth, moment(rowData.itemList[k].AssignmentDate).format('DD'));
								
								var differencedate 	= date_latest.getTime() - earlierdate.getTime();
								var hoursDifference = Math.floor(differencedate / 1000 / 60 / 60);
								
								if(hoursDifference > 24) {
									icon_warning = '<i class="fa fa-info-circle fg-red icon_blink" title="เกินระยะเวลา 24 ชม." style="font-size: 1.1em; cursor: pointer; margin-left: 16px; position: absolute; z-index: 2147483647; margin-top: -5px;"></i>';
								}
								
							}
					    }					
						*/
						
						division += '<div ' + classes + ' ' + optional + '>' +
							"<span data-row-data='{ DocID: \"" + rowData.itemList[k].DocID + "\", DefendRef: " + rowData.itemList[k].DefendRef + ", UserInfo: " + JSON.stringify(rowData.userInfo[0]) + " }' ng-click='config.loadIssueList($event)'>" +
								icon_warning +
								'<i class="fa fa-laptop" style="font-size: 1.3em; cursor: pointer; margin-left: 5px;"></i>' +
						  	'</span>' +
						'</div>';
						/*
						if(rowData.itemList[k].AssignmentConfirm !== 'Y') {
							division += '<div ' + classes + ' ' + optional + '><i class="fa fa-close fg-red" style="font-size: 1.3em; cursor: pointer; margin-left: 5px;"></i></div>';
						} else {
							division += '<div ' + classes + ' ' + optional + '>' +
								"<span data-row-data='{ DocID: \"" + rowData.itemList[k].DocID + "\", DefendRef: " + rowData.itemList[k].DefendRef + ", UserInfo: " + JSON.stringify(rowData.userInfo[0]) + " }' ng-click='config.loadIssueList($event)'>" +
									'<i class="fa fa-laptop" style="font-size: 1.3em; cursor: pointer; margin-left: 5px;"></i>' +
							  	'</span>' +
							'</div>';
						}
						*/
					break;
					case 'DefendProgress':
						
						var color_select = '';
						var progress_str = '';
						var progress_cl  = '';
						var progress_st	 = '';
						var progress_dig = '';
						var option_marg  = '';
						var option_class = '';
						var option_style = '';
											
						if(rowData.itemList[k][value] || rowData.itemList[k][value] !== '') {
							switch(rowData.itemList[k][value]) {
								case 'Submit': 
									progress_dig = 'LB';
									progress_str = 'LB Submit';
									color_select = 'color: #E3C800;';  
									option_class = 'lbcolor';									
								break;
								case 'Defend 1':
									progress_dig = 'D1';
									progress_str = 'DEF Received';
									color_select = 'color: #1BA1E2;';  
									option_class = 'def1color';
								break;
								case 'CA':
									progress_dig = 'CA';
									progress_str = 'Send to CA';
									color_select = 'color: #60A917;';
									option_class = 'cacolor';
								break;
								case 'Defend 2':
									progress_dig = 'D2';
									progress_str = 'Re-Process';
									color_select = 'color: #E51400;';  
									option_class = 'def2color';
								break;								
								case 'Completed':							
									progress_dig = 'CP';
									progress_str = 'Completed';
									color_select = 'color: #666666;';  
									option_class = 'compcolor';
								break;
								case 'Incompleted':						
								default:
									progress_dig = 'IC';
									progress_str = 'Incompleted';
									color_select = 'color: #666666;';  
									option_class = 'compcolor';
								break;
							}
						} else { color_select = 'color: #666666;'; }
						
						if(item_list > 1) {
							progress_cl = 'grid_layer';
							option_marg = '-20px';
						} else {
							progress_st = 'padding-top: 7px;'
							option_marg = '0px';
						}
						
						if(k === case_item) option_style = 'border-bottom: 0px;';
					    
						if(help.in_array($scope.cilent_id, $scope.defend_actor)) {
							division += 
								'<div class="' + progress_cl + ' nonprint" style="' + progress_st + ' ' + option_style + '">' +
									'<span class="tooltip-right nonprint" data-tooltip="' + progress_str + '" style="position: absolute; margin-left: -7px; margin-top: 0px;">' + 
										"<i data-row-data='{ DocID: \"" + rowData.itemList[k].DocID + "\", DefendRef: " + rowData.itemList[k].DefendRef + ", UserInfo: " + JSON.stringify(rowData.userInfo[0]) + " }' ng-click='config.requestVerify($event)' class=\"fa fa-circle " + option_class + "\" style=\"font-size: 1.4em; cursor: pointer; " + color_select + "\"></i>" + 
									'</span>' +									
								'</div>' +
								'<span class="' + progress_cl + ' printable" style="' + progress_st + ' ' + option_style + '">' +
									'<span style="position: absolute; margin-left: -7px; margin-top: ' + option_marg + ';">' + progress_dig + '</span>' +
								'</span>';
								
						} else {
							division +=  
								'<div class="' + progress_cl + ' nonprint" style="' + progress_st + ' ' + option_style + '">' + 
									'<span class="tooltip-right nonprint" data-tooltip="' + progress_str + '" style="position: absolute; margin-left: -7px; margin-top: 0px;">' +
										'<i class="fa fa-circle" style="font-size: 1.4em; cursor: pointer; ' + color_select + '"></i>' +
									'</span>' +									
								'</div>' + 
								'<span class="' + progress_cl + ' printable" style="' + progress_st + ' ' + option_style + '">' +
									'<span style="position: absolute; margin-left: -7px; margin-top: ' + option_marg + ';">' + progress_dig + '</span>' +
								'</span>';
						}
					
						break;
					case 'AssignmentConfirm':
						var color_select = '';
						if(rowData.itemList[k][value] == 'Y') color_select = 'color: #60a917;';
						else color_select = 'color: #666666;';
					    
						if(help.in_array($scope.cilent_id , $scope.defend_actor)) {
							division += 
							'<div ' + classes + ' ' + optional + '>' + 
								"<i data-row-data='{ DocID: \"" + rowData.itemList[k].DocID + "\", DefendRef: " + rowData.itemList[k].DefendRef + ", UserInfo: " + JSON.stringify(rowData.userInfo[0]) + " }' ng-click='config.requestVerify($event)' class=\"fa fa-circle\" style=\"font-size: 1.4em; cursor: pointer; " + color_select + "\"></i>" + 
							'</div>';
						} else {
							division += '<div ' + classes + ' ' + optional + '><i class="fa fa-circle" style="font-size: 1.4em; cursor: pointer; ' + color_select + '"></i></div>';
						}
								
					break;
					case 'DefendDate':			
					case 'AssignmentDate':
					
						division += 
							'<div ' + classes + ' ' + optional + '>' + 
								'<span class="tooltip-right" data-tooltip="' + moment(rowData.itemList[k][value]).format("DD/MM/YYYY (HH:mm)") + '" style="position: absolute; margin-left: -25px; margin-top: 0px;">' +  
									moment(rowData.itemList[k][value]).format("DD/MM/YY") +
								'</span>' +
							'</div>';
					break;
					case 'DefendSLA':
						division += '<div ' + classes + ' ' + optional + '>' + NumOfColorState(rowData.itemList[k][value]) + '</div>';
					break;
					case 'DefendProcess':						
						division += '<div ' + classes + ' ' + optional + '>' + 
							'<span class="tooltip-right" data-tooltip="' + rowData.itemList[k][value]  + '" style="position: absolute; margin-left: -3px;">' + rowData.itemList[k]['ProcessDigit'] + '</span>' + 
						'</div>';
					break;	
					default: 
						division += '<div ' + classes + ' ' + optional + '>' + rowData.itemList[k][value] + '</div>';
					break;
				
				}
				
			});

		}
		
		return division;

	}	
	
	/*
	var colname;
	if(!$scope.chain_record) {
		// Grid Model Description
		colname = [
		    { label: '<i class="fa fa fa-laptop" style="font-size: 1.2em;"></i>', name: 'Modal', title: false, frozen: false, width: 30, align: 'center', classes: 'padding_none', sortable: false, formatter: divisionLayer },
		    { label: 'DATE', name: 'DefendDate', title: false, frozen: false, sortable: false, width: 60, align: 'center', classes: 'padding_none', formatter: divisionLayer },
		    { label: '<i class="fa fa-flag-o" style="font-size: 1.2em;"></i>', name: 'DefendSLA', title: false, width: 30, frozen: false, align: 'center', classes: 'padding_none', sortable: false, formatter: divisionLayer },
		    { label: '<i class="fa fa-hashtag"></i>', name: 'DefendRef', title: false, frozen: false, width: 30, align: 'center', classes: 'padding_none', sortable: true, align: 'center', formatter: divisionLayer },
		    { label: '<i class="fa fa-shield" style="font-size: 1.2em;"></i>', name: 'DefendProcess', width: 30, title: false, classes: 'padding_none', align: 'center', sortable: true, formatter: divisionLayer },
		    { label: '<i class="fa fa-gavel" style="font-size: 1.2em;"></i>', name: 'DefendProgress', title: false, width: 30, frozen: false, align: 'center', classes: 'padding_none', sortable: false, formatter: divisionLayer },
		    { label: 'DATE', name: 'AssignmentDate', title: false, width: 60, align: 'center', classes: 'padding_none', sortable: true, formatter: divisionLayer },
		    { label: '<i class="fa fa-upload" style="font-size: 1.2em;"></i>', name: 'DefendFiles', title: false, width: 30, classes: 'padding_none', align: 'center', sortable: true, formatter: divisionLayer },
		    { label: '<i class="icon-copy" style="font-size: 1.2em;"></i>', name: 'MissingDoc', title: false, width: 40, align: 'center', sortable: true, formatter: missingHandled },
		    { label: 'LB', name: 'BranchDigit', title: false, width: 50, align: 'center', sortable: true, formatter: brnHandled },
		    { label: 'CUSTOMER', name: 'CustName', title: false, align: 'left', width: 135, sortable: true },
		    { label: 'RM NAME', name: 'RMName', title: false, align: 'left', width: 135, sortable: true },
		    { label: 'DEFEND NAME', name: 'AssignmentName', title: false, width: 135, sortable: true, formatter: nameHandled },	    
		    { label: 'CA NAME', name: 'CAName',title: false, align: 'left', width: 135, sortable: true},
		    { label: 'ST', name: 'Status', title: false, align: 'center', width: 40, sortable: true, formatter: statuscharacter},
		    { label: 'REASON', name: 'StatusReason',title: false, align: 'left', width: 120, sortable: true, formatter: statusresponed},
		    { label: 'ACTION NOTE', name: 'ActionNote',title: false, align: 'left', width: 180, sortable: true, formatter: liveactionstate}
		];
		
	} else {
		colname = [
		    { label: '<i class="fa fa fa-laptop" style="font-size: 1.2em;"></i>', name: 'Modal', title: false, frozen: false, width: 30, align: 'center', classes: 'padding_none', sortable: false },
		    { label: 'DATE', name: 'DefendDate', title: false, frozen: false, sortable: false, width: 60, align: 'center', classes: 'padding_none' },
		    { label: '<i class="fa fa-flag-o" style="font-size: 1.2em;"></i>', name: 'DefendSLA', title: false, width: 30, frozen: false, align: 'center', classes: 'padding_none', sortable: false },
		    { label: '<i class="fa fa-hashtag"></i>', name: 'DefendRef', title: false, frozen: false, width: 30, align: 'center', classes: 'padding_none', sortable: true, align: 'center' },
		    { label: '<i class="fa fa-shield" style="font-size: 1.2em;"></i>', name: 'DefendProcess', width: 30, title: false, classes: 'padding_none', align: 'center', sortable: true },
		    { label: '<i class="fa fa-gavel" style="font-size: 1.2em;"></i>', name: 'DefendProgress', title: false, width: 30, frozen: false, align: 'center', classes: 'padding_none', sortable: false },
		    { label: 'DATE', name: 'AssignmentDate', title: false, width: 60, align: 'center', classes: 'padding_none', sortable: true, formatter: divisionLayer },
		    { label: '<i class="fa fa-upload" style="font-size: 1.2em;"></i>', name: 'DefendFiles', title: false, width: 30, classes: 'padding_none', align: 'center', sortable: true },
		    { label: '<i class="icon-copy" style="font-size: 1.2em;"></i>', name: 'MissingDoc', title: false, width: 40, align: 'center', sortable: true, formatter: missingHandled },
		    { label: 'LB', name: 'BranchDigit', title: false, width: 50, align: 'center', sortable: true },
		    { label: 'CUSTOMER', name: 'CustName', title: false, align: 'left', width: 135, sortable: true },
		    { label: 'RM NAME', name: 'RMName', title: false, align: 'left', width: 135, sortable: true },
		    { label: 'DEFEND NAME', name: 'AssignmentName', title: false, width: 135, sortable: true, formatter: nameHandled },	    
		    { label: 'CA NAME', name: 'CAName',title: false, align: 'left', width: 135, sortable: true},
		    { label: 'ST', name: 'Status', title: false, align: 'center', width: 40, sortable: true, formatter: statuscharacter},
		    { label: 'REASON', name: 'StatusReason',title: false, align: 'left', width: 120, sortable: true, formatter: statusresponed},
		    { label: 'ACTION NOTE', name: 'ActionNote',title: false, align: 'left', width: 180, sortable: true, formatter: liveactionstate}
		];
		
	}
	*/
	
	var colname = [
	    { label: '<i class="fa fa fa-laptop" style="font-size: 1.2em;"></i>', name: 'Modal', title: false, frozen: false, width: 30, align: 'center', classes: 'padding_none', sortable: false, formatter: divisionLayer },
	    { label: 'DATE', name: 'DefendDate', title: false, frozen: false, sortable: false, width: 60, align: 'center', classes: 'padding_none', formatter: divisionLayer },
	    { label: '<i class="fa fa-flag-o" style="font-size: 1.2em;"></i>', name: 'DefendSLA', title: false, width: 30, frozen: false, align: 'center', classes: 'padding_none', sortable: false, formatter: divisionLayer },
	    { label: '<i class="fa fa-hashtag"></i>', name: 'DefendRef', title: false, frozen: false, width: 30, align: 'center', classes: 'padding_none', sortable: true, align: 'center', formatter: divisionLayer },
	    { label: '<i class="fa fa-shield" style="font-size: 1.2em;"></i>', name: 'DefendProcess', width: 30, title: false, classes: 'padding_none', align: 'center', sortable: true, formatter: divisionLayer },
	    { label: '<i class="fa fa-gavel" style="font-size: 1.2em;"></i>', name: 'DefendProgress', title: false, width: 30, frozen: false, align: 'center', classes: 'padding_none', sortable: false, formatter: divisionLayer },
	    { label: 'DATE', name: 'AssignmentDate', title: false, width: 60, align: 'center', classes: 'padding_none', sortable: true, formatter: divisionLayer },
	    { label: '<i class="fa fa-upload" style="font-size: 1.2em;"></i>', name: 'DefendFiles', title: false, width: 30, classes: 'padding_none', align: 'center', sortable: true, formatter: divisionLayer },
	    { label: '<i class="icon-copy" style="font-size: 1.2em;"></i>', name: 'MissingDoc', title: false, width: 40, align: 'center', sortable: true, formatter: missingHandled },
	    { label: 'LB', name: 'BranchDigit', title: false, width: 50, align: 'center', sortable: true, formatter: brnHandled },
	    { label: 'CUSTOMER', name: 'CustName', title: false, align: 'left', width: 135, sortable: true },
	    { label: 'RM NAME', name: 'RMName', title: false, align: 'left', width: 135, sortable: true },
	    { label: 'DEFEND NAME', name: 'AssignmentName', title: false, width: 135, sortable: true, formatter: nameHandled },	    
	    { label: 'CA NAME', name: 'CAName',title: false, align: 'left', width: 135, sortable: true},
	    { label: 'ST', name: 'Status', title: false, align: 'center', width: 40, sortable: true, formatter: statuscharacter},
	    { label: 'REASON', name: 'StatusReason',title: false, align: 'left', width: 100, sortable: true, formatter: statusresponed},
	    { label: 'ACTION NOTE', name: 'ActionNote',title: false, align: 'left', width: 200, sortable: true, formatter: liveactionstate}
	];
	
	// Grid Group Header
	$scope.thead_group = [
	    { "numberOfColumns": 5, "titleText": "DEFEND INFO.", "startColumnName": 'Modal' },
	    { "numberOfColumns": 3, "titleText": "PROGRESS", "startColumnName": 'DefendProgress' },
	    { "numberOfColumns": 9, "titleText": "GENERAL INFORMATION", "startColumnName": 'MissingDoc' }	  
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
        	
        	var str_page   = '';
        	var current_page   = parseInt($('input.ui-pg-input.form-control').val());
        	var page_selrows   = parseInt($('select.ui-pg-selbox.form-control option:selected').val());
        	var page_maxlength = parseInt($('#sp_1_grid_pager').text());
        	
        	var total_record   = $(this).getGridParam('records')
                	
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
        	$scope.defendlist_model(data.DocID, data.DefendRef);
        },
        loadMissingList: function(doc_id) {
        	$scope.missinglist_model(doc_id)
	    }, 
	    modalNoteIntervalTime: function(event) {
	    	var data = eval("(" + $(event.currentTarget).data("rowData") + ")");
	    	$scope.latestlogs_model(data, $scope.user_role, $scope.defend_actor);
	    },
	    requestVerify: function(event)  {
	    	var event_data = eval("(" + $(event.currentTarget).data("rowData") + ")");
	    	$scope.requestDefendVarify(
				{ 
				    items: event_data,
				    role: $scope.user_role, 
				    user_id: $scope.cilent_id, 
				    defendgroup: $scope.defend_actor, 
				    dashboard: $filter("filter")(this.data, {DocID: event_data.DocID}, true)[0]
				}
			);
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
	
	$scope.masterdata = {};
	var master_apis   = ['region', 'area']

	var apino		  = master_apis.length - 1;
	$.each(master_apis, function(index, value) {		
		help.onLoadListMaster(value).then(function(responsed) {
			$scope.masterdata[value] = responsed.data;
		});
		
	});
	
	$scope.masterdata['decisionca']  = [{ 'values':'Pending' },{ 'values':'Approved' },{ 'values':'Cancel' },{ 'values':'Reject' }];
	
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
		 help.executeservice('get', links + 'master/ddtemplate/area').then(function(resp) {
			 var result =  $.map(resp.data, function(value) {
				 if(help.in_array(value['RegionID'], param['RegionID'])) return value;
			 });
			 $scope.masterdata['area'] = (result.length > 0) ? result:resp.data;
		 });
	}
	
	function onLoadBranchList(objects) {
		 var param = (objects) ? objects:{};
		 help.executeservice('post', links + 'master/ddtemplate/branch', param).then(function(resp) { 
			 $scope.masterdata['branch'] = resp.data; 
		 });
	}

	function onLoadEmployeeList(objects) {
		 var param = (objects) ? objects:{};
		 var param_clone = {};
		 angular.copy(param, param_clone);

		 param_clone['Position'] = ['BM', 'RM']; 
		 help.executeservice('post', links + 'master/ddtemplate/employee', param_clone).then(function(resp) { 
			 $scope.masterdata['employee'] = resp.data;
		 });
	}

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
	
	// Click Searching
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

		var item_head = null;
		var data_item = [];
		var url_data = links + 'pcis/defenddashboard'
		var url_logs = links + 'pcis/defenddashboard/log';
		
		$scope.logs_item = [{}];
		help.executeservice('post', url_logs, {})
		.then(function(resp) { 
			if(resp.data) {			
				angular.copy(assingAuthToLogs(resp.data, $scope.user_role), $scope.logs_item);
			}
		});
	
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
			 //'IDCard'	: $scope.param.defend_type,
			'IDCard'	: (help.in_array($scope.user_role, ['rm_role', 'bm_role', 'am_role', 'rd_role', 'dev_role'])) ? null:'Y',
			'SDF_Date'	: start_date,
			'EDF_Date'	: end_date,
			'Status'	: ($scope.param.status && $scope.param.status.length > 0) ? $scope.param.status.join():null,
			'CAName' 	: $scope.param.ca_name,
			'DefendDepart': $scope.param.defend_list,
			'ActiveRow'	: ($scope.param.active_row) ? $scope.param.active_row:null			
		};
		
		var dataConfig	= [];
		help.executeservice('post', url_data, $param).then(function(resp) {
			for(var index in resp.data) {
				item_head  = resp.data[index].DocHeader;
				item_subs  = resp.data[index].DocItems;
			
				data_item.push({
					DocID: item_head.DocID,
					DefendDate: 'DefendDate',
					DefendSLA: 'DefendSLA',
					DefendRef: 'DefendRef',
					AssignmentConfirm: 'AssignmentConfirm',
					AssignmentDate: 'AssignmentDate',
					AssignmentName: item_head.AssignmentName,
					DefendProcess: 'DefendProcess',
					DefendProgress: 'DefendProgress',
					DefendFiles: 'File_Total',
					MissingDoc: item_head.MissingDoc,
					BranchDigit: item_head.BranchDigit,
					RMName: item_head.RMName,
					CustName: item_head.BorrowerName,
					CAName: item_head.CAName,		
					Status: item_head.Status,
					StatusReason: item_head.StatusReason, 
					ActionNote: item_head.ActionNote,		
					Modal: 'IssueList',
					itemHead: item_head,
					itemList: item_subs,
					itemLogs: $filter("filter")($scope.logs_item, {DocID: item_head.DocID, IsActive: 'A', IsView: true}, true),
					userInfo: $scope.userinfo
				});
							
			}
			
			$scope.config.data = data_item;
		
			if(query['pop']) {
				dataConfig = $filter("filter")(data_item, {DocID: query['rel']}, true);
				help.executeServices('GetKPI00ProfileReport', { RMCode: $scope.cilent_id }).then(function(responsed) {
					data_info = responsed.data.Data; 
					var modalInstance = $uibModal.open({
				        animation: true,
				        backdrop  : 'static',
				        keyboard  : false,
				        templateUrl: 'modalDefendList.html',
				        controller: 'modalDefendListCtrl',
				        size: 'md',
				        windowClass: 'modal-fullscreen animated zoomIn',
				        resolve: {
				        	items: function () { return [query['rel'], query['ref'], data_info, $scope.user_role, $scope.defend_actor]; },
							optionData: function() { return dataConfig; }
				        }
				    });
					
					modalInstance.result.then(
						function(selectedItem) { window.close(); }, 
						function(resp) { window.close(); }
					);
					
				});

			}
			
		});
		
	}

	$scope.$on("bindData", function (scope, elem, attrs) {
    	
    	$scope.table = elem.closest("table").dataTable($scope.tableOpt); 
    	
    	$('.number_length').text($('.dataTables_info').text());
    	$('.dataTables_info').css('visibility', 'hidden');	 
    	
    	// UI Hidden
    	$('#panel_criteria > .panel-content').hide(500, function() {
    	    $(this).css('display', 'none');
    	});
    
    });
	

	
	// FUNCTION CONFIG HANDLED
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
	        resolve: { items: function () { return { 'DocID': doc_id, 'Data': objects}; } }
	    });
	 
	};
	
	$scope.requestDefendVarify = function(objects) {
		
		if(help.in_array(objects.user_id, objects.defendgroup)) {
			if(objects.dashboard.itemHead.DefendProgress !== "Completed") {
				var modalInstance = $uibModal.open({
			        animation: true,
			        templateUrl: 'modalRequestDefendDialog.html',
			        controller: 'modalCheckDefendRequestCtrl',
			        size: 'md',
			        windowClass: 'nonprint animated zoomIn',
			        resolve: {
			        	objects: function () { return objects; }
			        }
			    });
				
				modalInstance.result.then(
					function(selectedItem) {}, 
					function(resp) {
						if(resp.state) { reloadGrid(); }
					}
				);
			} else { Notification.warning('คำร้องนี้เสร็จสมบูรณ์แล้ว ไม่สามารถแก้ไขได้ ...'); }

		} 
		
	};
	
	$scope.latestlogs_model = function(object_log, authen, defendActor) {
		
		var url   = links + 'pcis/defenddashboard/log';
		var param = {
			DocID: object_log.DocID,
			DefendRef: object_log.DefendRef,
		    DefendCode: object_log.DefendCode	
		}

		help.executeservice('post', url, param)
		.then(function(resp) {
			if(resp.status == 200) {
				
				var modalInstance = $uibModal.open({
					animation: true,
			        backdrop  : 'static',
			        keyboard  : false,
			        templateUrl: 'modaltransactionlogs.html',
			        controller: 'ModalTransactionLogsCtrl',
			        size: 'md',
			        windowClass: 'modal-fullscreen nonprint animated zoomIn',
			        resolve: {
			        	items: function () { return object_log; },
			        	authority: function () { return authen; },
			        	dataLogs: function() { return resp.data; },
			        	defendActor: function() { return defendActor; }
			        }
			    });
				
				modalInstance.result.then(
					function(selectedItem) {}, 
					function(resp) {
						if(resp.state) { reloadGrid(); }
					}
				);
		
			}
		});

	};
	
	$scope.defendlist_model = function(doc_id, defend_ref) {
	
		var modalInstance = $uibModal.open({
	        animation: true,
	        backdrop  : 'static',
	        keyboard  : false,
	        templateUrl: 'modalDefendList.html',
	        controller: 'modalDefendListCtrl',
	        size: 'md',
	        windowClass: 'modal-fullscreen animated zoomIn',
	        resolve: {
	        	items: function () { return [doc_id, defend_ref, $scope.userinfo, $scope.user_role, $scope.defend_actor]; },
				optionData: function() { return $filter("filter")($scope.config.data, {DocID: doc_id}, true); }
	        }
	    });
		
		modalInstance.result.then(
			function(selectedItem) {}, 
			function(resp) {
				if(resp.state) { reloadGrid(); }
			}
		);

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
	   		   		'<span><b class="tooltip-bottom" data-tooltip="' + mobile + '">' + result[0].FullNameEng.toUpperCase() + '</b> (' + nickname + ') </span> <br/>' +
	   				'<span class="sub-desc">' + corp + '</span>' +
	   		   '</div>';  

     	   $('#position_title').val(result[0].Position);
             	   
     	   $('.using_information').html('');
     	   $(html).hide().appendTo(".using_information").fadeIn(1000);
  
        }
            	
    	// CALL GRID
    	reloadGrid();
		
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
	
	function setDateRangeHandled(str_date) {
		if(str_date) {
			var pattern 	= new RegExp("-");
			var dateValid 	= pattern.test(str_date);
			
			var start_date	= '',
				end_date	= '';
			
			if(dateValid) {
			    var item   	= str_date.split("-");
			    start_date  = item[0].trim();
			    end_date	= item[1].trim();

			} else { 
			    start_date  = str_date;
			    end_date	= str_date;
			}
			
			return [moment(start_date, 'DD/MM/YYYY').format('YYYY-MM-DD'), moment(end_date, 'DD/MM/YYYY').format('YYYY-MM-DD')];
			
		} else { return null }
		
		
	}
	
	function getUserDefendList() {
		var result_set = [{}];
		$.ajax({
	      	url: pathFixed + 'index.php/dataloads/getDefendGroup?_=' + new Date().getTime(),
	        type: "GET",
	        cache: true,
		    success: function (responsed) { 
		    	if(responsed.status) {
		    		var emp_list = [];		    		
		    		if(responsed.data[0] !== undefined) {
		    			$.each(responsed.data, function(index, value) {
		    				if(value.EmployeeCode) {
		    					emp_list.push(value.EmployeeCode);
		    				}
		    				
		    			});
		    			
		    			angular.copy(emp_list, result_set);
		    			
		    		}
	
		    	}
		    
		    },
		    complete:function() {},
		    error: function (error) { console.log(error); }	        
		});
		
		return result_set;
		
	}
	
	function getUserDefendListFull() {
		var result_set	= [];
		$.ajax({
	      	url: pathFixed + 'index.php/dataloads/getDefendGroup?_=' + new Date().getTime(),
	        type: "GET",
	        cache: true,
		    success: function (responsed) { 
		    	var emp_list = [];	
		    	if(responsed.status) {
		    		$.each(responsed.data, function(index, value) {
		    			//, '57249'
	    				if(!help.in_array(value.EmployeeCode, ['57251', '56225', '58141', '57249'])) {
	    					emp_list.push(value);
	    				}
	    				
	    			});
	    			
		    		angular.copy(emp_list, result_set);
		    	}
		    
		    },
		    complete:function() {},
		    error: function (error) { console.log(error); }	        
		});
		
		return result_set;
		
	}
	
	function assingAuthToLogs(objects, role) {
		var result_set 	 = [{}];
		if(objects[0] !== undefined) {
			
			$.each(objects, function(index, value) {
				
				if(help.in_array(value.DefendCode, ['SP001', 'SP002'])) {
					if(!help.in_array(role, ['hq_role'])) value.IsView = true;
					else value.IsView = false;
				} else {
					if(help.in_array(role, ['hq_role', 'dev_role', 'admin_role'])) value.IsView = true;
					else value.IsView = false;
				}
				
			});
			
			angular.copy(objects, result_set);
			
		}
		
		return result_set;
		
	}
	
})
.controller('ModalInstanceMissingCtrl', function($scope, $filter, help, $uibModalInstance, $q, items) {
	
	$scope.itemList		= [];
	help.GetMissingDocItemList(items).then(function(responsed) {
		$scope.itemList = responsed.data;
	});
	
	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss('cancel');
	};
	
})
.controller('modalCheckDefendRequestCtrl', function($scope, $filter, help, $uibModalInstance, $q, Notification, objects) {
	$scope.issue_head 	 = objects.dashboard.itemHead;
	$scope.defendList 	 = getUserDefendList();
	$scope.assignDefend  = null;
	
	var url   = links + 'pcis/defenddashboard/issue'
	var param = {
		DocID: objects.items.DocID,
		DefendRef: objects.items.DefendRef
	};
	
	$scope.noitfyconfig = {
		positionY: 'top', 
		positionX: 'right' 	
	};

	$scope.multipleConfig = { width: '100%', filter: true, minimumCountSelected: 2, single: true }
		
	// Load Request Reason
	var issue_fixed	 = ['SP001', 'SP002', 'SP003', 'SP004'];
	help.executeservice('post', url, param).then(function(resp) {
		$scope.issueHeader  	= resp.data.Header[0];
		$scope.assignDefend 	= resp.data.Header[0].DefendCode;

		var issue_subscription  = resp.data.Subscription;
		
		var data_issuesub = [];
		if(issue_subscription[0] !== undefined) {
			$.each(issue_subscription, function(index, value) {
				 if(!help.in_array(value.DefendCode, issue_fixed)) {
					 data_issuesub.push(issue_subscription[index]);
				 }
			});
		}
		
		$scope.issueSubList = {
			data: data_issuesub,
			rows: (data_issuesub[0] !== undefined) ? data_issuesub.length:0
		};
	
	});
	
	$scope.confirmRequestDefend = function(objectItem, condition) {
		if(confirm('กรุณายืนยันการรับคำร้องข้อมูลการ Defend')) {
			
			var defendItem	=  $filter("filter")(condition[1], {EmployeeCode: parseInt(condition[0])}, true);
			
			$.ajax({
		      	url: pathFixed + 'index.php/dataloads/confirmDefend?_=' + new Date().getTime(),
		        data: { 
		        	relidx: objects.items.DocID,
		        	relnox: objects.items.DefendRef,
		        	defidx: defendItem[0].EmployeeCode,
		        	defnamex: defendItem[0].FullNameTh
		        },
		        type: "POST",
		        cache: false,
			    success: function (responsed) { 
			    	
			    	if(responsed['status']) {
			    		 $scope.grid_restate = true;
			    		 $scope.noitfyconfig.message = 'รับคำร้องการขอ Defend สำเร็จ';
		        		 Notification.success( $scope.noitfyconfig);
		        		 
		        		 $uibModalInstance.dismiss({ status: 'cancel', state: $scope.grid_restate });
                    	
			    	} else {
			    		 $scope.noitfyconfig.message = 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่';
		        		 Notification.error( $scope.noitfyconfig );
	
			    	}
			    	
			    },
			    complete:function() {},
			    error: function (error) { console.log(error); }	        
			});
			
			return true;
		
		}
		
		return false;
		
	}

	$scope.deleteRequestDefend = function(data) {
		$scope.grid_restate = false;
	
		if(confirm('กรุณายืนยันการลบข้อมูลการ Defend\n(กรุณาตรวจสอบข้อมูลก่อนทำการลบข้อมูล).')) {

			$.ajax({
		      	url: pathFixed + 'index.php/dataloads/deleteTrashDefendTransaction?_=' + new Date().getTime(),
		        data: { 
		        	relx: data.DocID,
		        	lnsx: data.DefendRef
		        },
		        type: "POST",
		        cache: false,
			    success: function (responsed) { 
			    	if(responsed['status']) {
			    		 $scope.grid_restate = true;
			    		 $scope.noitfyconfig.message = 'ลบข้อมูลคำร้องการขอ Defend สำเร็จ';
		        		 Notification.success( $scope.noitfyconfig);
		        		 
		        		 $uibModalInstance.dismiss({ status: 'cancel', state: $scope.grid_restate });
                    	
			    	} else {
			    		 $scope.noitfyconfig.message = 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่';
		        		 Notification.error( $scope.noitfyconfig );
	
			    	}

			    },
			    complete:function() {},
			    error: function (error) { console.log(error); }	        
			});
			
			return true;
			
		}
		
		return false;
		
	}
	
	function getUserDefendList() {
		var result_set = [{}];
		$.ajax({
	      	url: pathFixed + 'index.php/dataloads/getDefendGroup?_=' + new Date().getTime(),
	        type: "GET",
	        cache: true,
		    success: function (responsed) { 
		    	if(responsed.status) {
		    		var emp_list = [];		    		
		    		if(responsed.data[0] !== undefined) {
		    			var dataset = [];
		    			$.each(responsed.data, function(index, value) {
		    				if(!help.in_array(value.EmployeeCode, ['56225', '57251', '58141'])) {
		    					dataset.push(responsed.data[index]);
		    				}
		    			});
		    					    			
		    			angular.copy(dataset, result_set);
		    			
		    		}
	
		    	}
		    
		    },
		    complete:function() {},
		    error: function (error) { console.log(error); }	        
		});
		
		return result_set;
		
	}

	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss({ status: 'cancel', state: $scope.grid_restate });
	};
	
})
.controller('modalDefendListCtrl', function($scope, $document, $filter, help, $uibModal, $uibModalInstance, $q, $compile, Notification, items, optionData) {

	$scope.userinfo	 	 = null;
	$scope.issue_content = null;
	$scope.primarydata   = items;
	$scope.user_role	 = items[3];
	$scope.option_data	 = optionData[0].itemHead;
	$scope.appstatus	 = optionData[0].itemHead.Status;	
	
	$scope.sale_team 	 = !help.in_array($scope.user_role, ['rm_role', 'dev_role'])
	$scope.defend_team	 = !help.in_array(items[2][0].EmployeeCode, items[4]);
	
	$scope.request_status	= null;
	$scope.request_defend	= false;
	
	$scope.grid_restate  = false;
	$scope.issue_fixed	 = ['SP001', 'SP002', 'SP003', 'SP004'];
	$scope.linkToVerify	 = pathFixed + 'index.php/management/getDataVerifiedPreview?_=' + new Date().getTime() + '&P2&live=1&rel=' + items[0] + '&wrap=381031381638'

	var resp = loadIssueList();
	if(resp) {
		
		setTimeout(function() { 
			$('.ta-toolbar').find('div:nth-child(4)').addClass('pull-right animated fadeIn'); 
			$('.ta-toolbar').find('div:nth-child(4) > div').attr('ng-click', false);
			$('.badge_group').removeClass('hide').addClass('animated fadeIn');
			//$('.ta-toolbar').find('div:nth-child(4)').
			
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
			
		}, 500);

	}
	
	// Check field locked
	$scope.currentObject  	= $filter("filter")(optionData[0].itemList, {DefendRef: $scope.primarydata[1], DocID: $scope.primarydata[0]});
	$scope.btnStateDisabled = (help.in_array($scope.appstatus, ['APPROVED'])) ? true:false;
	$scope.btnDisabledOnHO  = (help.in_array($scope.currentObject[0].DefendProgress, ['DEF Received', 'Defend 1', 'Defend 2', 'Send to CA', 'CA'])) ? true:false;
	$scope.btnDisabled	  	= (help.in_array($scope.currentObject[0].DefendProgress, ['Send to CA', 'CA'])) ? true:false;
		
	// Check field when progress status live in ca.
	$scope.defend_completed = 'N';  
	$scope.field_completed  = false
	$scope.defendEndProcess	= ($scope.currentObject[0].DefendProgress === 'Completed') ? true:false;
	
	$scope.$watch('defend_completed', function(n, o) {	
		if(n) {
			if(help.in_array(n, ['Y', 'I'])) $scope.btnDefendAcccept = true;
			else  $scope.btnDefendAcccept = false;
		} else { $scope.btnDefendAcccept = false; }
	});	
	
	$scope.$watch('defendEndProcess', function(n, o) {		
		if(n == true) {
			if(help.in_array(items[2][0].EmployeeCode, ['57251'])) { $scope.field_completed = false; } 
			else { $scope.field_completed = true; }		
		}		
	});
	
	$scope.business_desc = null;
	function loadIssueOption() {
		var url   = pathFixed + '/index.php/dataloads/loadIssueOption'
		var param = {
			DocID: items[0],
			DefendRef: items[1]
		};
		
		$.ajax({
	      	url: url,
	        type: "POST",
	        data: param,
		    success: function (responsed) {	
		    	var data = (responsed.data) ? responsed.data[0]:null;
		    	if(data) {
		    		
		    		
		    		if($scope.issue_content) {
		    			$scope.issue_content.header.DefendName 	 = data.AssignBy;
			    		$scope.issue_content.header.DefendMobile = data.AssignMobile;
		    		}
		    		
		    		var str_business = '(ประเภทธุรกิจ: ' + data.BusinessType + '/' + data.BusinessDesc + ')';
		    		$scope.business_desc 	= str_business;
		    		$scope.request_status	= (data.ApprovedStatus && data.ApprovedStatus !== '') ? (data.ApprovedStatus) : null;
		    		$scope.request_defend	= (data.ApprovedStatus && data.ApprovedStatus !== '') ? true:false;
		    		console.log($scope.request_status, $scope.request_defend);
		    		
		    	}
		  		    	
		    },
		    error: function (error) { console.log(error); }	        
		});
			
	}
	
	function loadIssueList() {

		var url   = links + 'pcis/defenddashboard/issue'
		var param = {
			DocID: items[0],
			DefendRef: items[1]
		};
		
		help.executeservice('post', url, param).then(function(resp) {

			$scope.issue_content  = {
				header: resp.data.Header[0],
				subscription: resp.data.Subscription,
				userinfo: (items[2][0]) ? items[2][0]:null
			}
			//console.log($scope.issue_content);
			$.each($scope.issue_content.subscription, function(index, value) { 
				value.isEditable	= false;
				value.isDisabled 	= true;
				value.UpdateName	= null;
				value.UpdateDate	= null;
						
				if(help.in_array(value.DefendCode, $scope.issue_fixed)) value.isPanel = true;
				else value.isPanel  = false;
				
				if(help.in_array(value.DefendCode, $scope.issue_fixed)) {
					
					if(help.in_array(value.DefendCode, ['SP001', 'SP002'])) {
						value.role  = {
							'admin_role': true,
							'rm_role': false,
							'bm_role': false,
							'am_role': false,
							'rd_role': false,
							'hq_role': true,
							'dev_role': true
						};
					} else {
						value.role  = {
							'admin_role': true,
							'rm_role': true,
							'bm_role': true,
							'am_role': true,
							'rd_role': true,
							'hq_role': true,
							'dev_role': true
						}
					}
					
				} else {
					value.role  = {
						'admin_role': true,
						'rm_role': true,
						'bm_role': true,
						'am_role': true,
						'rd_role': true,
						'hq_role': true,
						'dev_role': true
					}
				}
		
			});			
			
		});
		
		return true;

	}
	
	$scope.noitfyconfig = {
		positionY: 'top', 
		positionX: 'right' 	
	}
	
	$scope.generatePDF = function(param) {
		
		var url   = links + 'pcis/defenddashboard/issue'
		var requests = {
			DocID: param.DocID
		};

		help.executeservice('post', url, requests).then(function(resp) {
			if(resp.status == 200) {
				
				var data = resp.data;
				var header = (data.Header[0]) ? data.Header[0]:null;
				var content = (data.Subscription && data.Subscription.length > 0) ? data.Subscription:null;
				
				var docid = (header) ? header.DocID:'';
				var appno = (header) ? header.ApplicationNo:'';
				
				// RESULT ROWS 2
				var lbname = (header) ? header.BranchName:'-';
				var custname = (header) ? header.BorrowerName:'-';
				var defname = (header) ? header.DefendName:'-';
				var caname = (header) ? header.CAName:'-';
				
				var lbname_tel = (header) ? 'โทร : ' + header.BranchTel:'';
				var custname_tel = (header) ? 'โทร : ' + header.AreaCode:'';
				var defname_tel = (header) ? 'โทร : ' + header.DefendMobile:'';
				var caname_tel = (header) ? 'โทร : ' + header.CAMobile:'';
				
				// RESULT ROWS 3
				var rm_name = (header) ? header.RMName:'-';
				var bm_name = (header) ? header.BMName:'-';
				var am_name = (header) ? header.AMName:'-';
				var rd_name = (header) ? header.RDName:'-';
				
				var rm_name_tel = (header) ? 'โทร : ' + header.RMMobile:'';
				var bm_name_tel = (header) ? 'โทร : ' + header.BMMobile:'';
				var am_name_tel = (header) ? 'โทร : ' + header.AMMobile:'';
				var rd_name_tel = (header) ? 'โทร : ' + header.RDMobile:'';
				
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
						var str_content = (item.DefendNote) ? removeTags(item.DefendNote):null;
						if(str_content) {
							docDefinition.content.push(
								{
									style: 'tablePanelStyle',
								    table: {
								        headerRows: 1,
								        widths: '*',
								        body: [
								          [
								        	  { text: '(ครั้งที่ ' + item.DefendRef + ') ' + 'หัวข้อ' + item.DefendReason, style: 'tableHeader', colSpan: 4, alignment: 'left' },
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
						} else{
							get_checklist.push('FALSE');
						}						
					});
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
					    		 $scope.noitfyconfig.message = 'ระบบสร้างใบชี้แจ้งรายละเอียดเพื่อขอแก้ไขผลพิจารณ์สินเชื่อ หมายเลข ' + appno + ' สำเร็จ';
				        		 Notification.success( $scope.noitfyconfig);
					    	 } else {
					    		 $scope.noitfyconfig.message = 'CA on process (Defend) ขณะนี้ไฟล์ PDF หมายเลข ' + appno + ' กำลังถูกเปิดใช้งาน  ไม่สามารถบันทึกได้ในขณะนี้ โปรดลองใหม่อีกครั้งในเวลาถัดไป (หรือรอระบบบันทึกให้อัตโนมัติในวันถัดไป 8.00 น.)';
				        		 Notification.error( $scope.noitfyconfig);
					    	 }
					     });
					};
					reader.readAsDataURL(blob);				
				});
				
			}
			
		});		
		
		function removeTags(string, array){
			  return array ? string.split("<").filter(function(val){ return f(array, val); }).map(function(val){ return f(array, val); }).join("") : string.split("<").map(function(d){ return d.split(">").pop(); }).join("");
			  function f(array, value){
				  return array.map(function(d){ return value.includes(d + ">"); }).indexOf(true) != -1 ? "<" + value : value.split(">")[1];
			  }
		}

	}
	
	$scope.confirmGeneratePDF = function() {	
		if(confirm('กรุณายืนยันความถูกต้อง เพื่อสร้างใบคำร้องขอ Defend และรวบรวมเอกสารเพิ่มเติมทั้งหมด (กรณีมีเอกสารเพิ่มเติม)')) {
			var param = {
				DocID 	   : $scope.option_data.DocID,
				DefendRef  : $scope.option_data.DefendRef,
		        CreateID   : $scope.primarydata[2][0].EmployeeCode,
		        CreateBy   : $scope.primarydata[2][0].FullNameTh				
			};
			
			$scope.generatePDF(param);
			
			return true;
		}
		
		return false;
		
	}
	
	
	$scope.requestSentApproveToManger = function(param) {
		if(!$scope.request_status) {
			if(confirm('กรุณากดยืนยันข้อมูล เพื่อส่งขออนุมัติจากหัวหน้าทีมในการส่งรายการถึงทีมเครดิต')) {
				
				var param = {
					DocID 	   : $scope.option_data.DocID,
					DefendRef  : $scope.option_data.DefendRef,
			        CreateID   : $scope.primarydata[2][0].EmployeeCode,
			        CreateBy   : $scope.primarydata[2][0].FullNameTh				
				};
				
				$.ajax({
			      	url: pathFixed + 'index.php/dataloads/sendAppToManager?_=' + new Date().getTime(),
			        data: param,
			        type: "POST",
			        cache: false,
				    success: function (resp) { 

				    	if(resp['status']) {
				    		 $scope.request_defend = resp.status;
				    		 $scope.request_status = 'N';
				    		 $scope.noitfyconfig.message = 'ระบบดำเนินการส่งรายการถึงหัวหน้าทีมสำเร็จ โปรดรอหัวหน้าทีมตรวจสอบและแจ้งสถานะกลับ';
			        		 Notification.success($scope.noitfyconfig);

				    	} else {
				    		 $scope.noitfyconfig.message = 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่';
			        		 Notification.error($scope.noitfyconfig );
		
				    	}
				    	
				    },
				    complete:function() {},
				    error: function (error) { console.log(error); }	        
				});

			}
			
		} else {
			 $scope.noitfyconfig.message = 'ขออภัย, ท่านมีการส่งข้อมูลถึงหัวหน้าทีมแล้ว กรุณารอการตรวจสอบจากหัวหน้าทีม';
    		 Notification.error($scope.noitfyconfig );
		}
		
	}
	
	$scope.save_enabled = function(user_profile, item) {	
		if(confirm('กรุณายืนบันการบันทึกข้อมูลหรือไม่')) {
			
			var url   = links + 'pcis/defenddashboard/issue';
			var param = {
				RowID	   : item.RowID,
				DocID 	   : item.DocID,
				DefendRef  : item.DefendRef,
				DefendCode : item.DefendCode,
				DefendNote : item.DefendNote,
		        CreateID   : user_profile.EmployeeCode,
		        CreateBy   : user_profile.FullNameTh				
			};
			
	    	help.executeservice('put', url, param).then(function(resp) {
				if(resp.status == 200) {
	
					item.isDisabled = true;
					item.isEditable = false;
					
					$scope.noitfyconfig.title   = 'หัวข้อ' + item.DefendReason + ' ' + item.DefendTitleOption;
					$scope.noitfyconfig.message = 'บันทึกข้อมูลสำเร็จ กรุณารอสักครู่เพื่อให้ระบบสร้างใบคำร้องสำหรับชี้แจ้งข้อมูลเกี่ยวกับลูกค้า';
					
					Notification.success($scope.noitfyconfig);
					
				}
				
			});
		}	
	}
	
	$scope.edit_enabled = function(user_profile, item, idx) {
		
		item.UpdateName = user_profile.FullNameTh;
		item.UpdateDate = moment().format('DD/MM/YYYY HH:mm');
		item.isDisabled = false;
		item.isEditable = true;
				
		var scope_str	= '';
		if(item.DefendNote.length > 0) scope_str = '<hr style="border-bottom: 1px solid #D1D1D1;"></hr>';
		
		var text_editor = moment().format('DD/MM/YYYY HH:mm') + ' ' + user_profile.FullNameTh;
		item.DefendNote	= '<p>' + text_editor + ':</p><p>&nbsp;</p>' + scope_str + item.DefendNote;
		
		$('text-angular[name="issue_itemnote_' + idx + '"]').find('div[text-angular-toolbar]').css({'display': 'block', 'transition': 'all 0.5s ease-in-out'});
		$('text-angular[name="issue_itemnote_' + idx + '"]').find('.ta-text.ta-editor').css({'display': 'block', 'transition': 'all 0.5s ease-in-out'});
		
		$scope.noitfyconfig.title   = 'หัวข้อ' + item.DefendReason + ' ' + item.DefendTitleOption;
		$scope.noitfyconfig.message = 'ท่านกำลังอยู่ในโหมดอัพเดทข้อมูล';

		Notification.info($scope.noitfyconfig);
	
	}
	
	$scope.unlock_process = function(user_profile, btnDisabled) {
		
		if(help.in_array(user_profile[2][0].EmployeeCode, user_profile[4])) {
			if(confirm('กรุณากดยืนยันการปลดล๊อค')) {
				$scope.defend_completed = 'Y';
				$.ajax({
			      	url: pathFixed + 'index.php/dataloads/unlockProcessDefend?_=' + new Date().getTime(),
			        data: {
						doc_id: user_profile[0],
						defendref: user_profile[1],
						userid: user_profile[2][0].EmployeeCode,
						username: user_profile[2][0].FullNameTh
					},
			        type: "POST",
			        cache: false,
				    success: function (responsed) { 
				    	
				    	if(responsed['status']) {
				    		 $scope.grid_restate = true;
				    		 $scope.noitfyconfig.message = 'ระบบดำเนินการเปลี่ยนแปลงสถานะใหม่สำเร็จ';
			        		 Notification.success( $scope.noitfyconfig);
			        		 
			        		 $uibModalInstance.dismiss({ status: 'cancel', state: $scope.grid_restate });
	                    	
				    	} else {
				    		 $scope.noitfyconfig.message = 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่';
			        		 Notification.error( $scope.noitfyconfig );
		
				    	}
				    	
				    },
				    complete:function() {},
				    error: function (error) { console.log(error); }	        
				});
								
				return true;
				
			}
			
			return false;
			
		}
	
	}
	
	$scope.rollback_process = function(user_profile) {

		if(help.in_array(user_profile[2][0].EmployeeCode, user_profile[4])) {
			if(confirm('กรุณากดยืนยันการปลดล๊อค')) {
				
				$.ajax({
			      	url: pathFixed + 'index.php/dataloads/rollbackProcessDefend?_=' + new Date().getTime(),
			        data: {
						doc_id: user_profile[0],
						defendref: user_profile[1],
						userid: user_profile[2][0].EmployeeCode,
						username: user_profile[2][0].FullNameTh
					},
			        type: "POST",
			        cache: false,
				    success: function (responsed) { 
				    	
				    	if(responsed['status']) {
				    		 $scope.grid_restate = true;
				    		 $scope.noitfyconfig.message = 'ระบบดำเนินการเปลี่ยนแปลงสถานะใหม่สำเร็จ';
			        		 Notification.success( $scope.noitfyconfig);
			        		 
			        		 $uibModalInstance.dismiss({ status: 'cancel', state: $scope.grid_restate });
	                    	
				    	} else {
				    		 $scope.noitfyconfig.message = 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่';
			        		 Notification.error( $scope.noitfyconfig );
		
				    	}
				    	
				    },
				    complete:function() {},
				    error: function (error) { console.log(error); }	        
				});
								
				return true;
				
			}
			
			return false;
			
		}
	
	}
	
	$scope.deleteRequestDefend = function(data) {
		if(confirm('กรุณายืนยันการลบข้อมูลการ Defend\n(กรุณาตรวจสอบข้อมูลก่อนทำการลบข้อมูล).')) {

			$.ajax({
		      	url: pathFixed + 'index.php/dataloads/deleteTrashDefendTransaction?_=' + new Date().getTime(),
		        data: { 
		        	relx: data[0],
		        	lnsx: data[1]
		        },
		        type: "POST",
		        cache: false,
			    success: function (responsed) { 
			    	if(responsed['status']) {
			    		 $scope.grid_restate = true;
			    		 $scope.noitfyconfig.message = 'ลบข้อมูลคำร้องการขอ Defend สำเร็จ';
		        		 Notification.success( $scope.noitfyconfig);
		        		 
		        		 $uibModalInstance.dismiss({ status: 'cancel', state: $scope.grid_restate });
                    	
			    	} else {
			    		 $scope.noitfyconfig.message = 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่';
		        		 Notification.error( $scope.noitfyconfig );
	
			    	}

			    },
			    complete:function() {},
			    error: function (error) { console.log(error); }	        
			});
			
			return true;
			
		}
		
		return false;
		
	}
	
	// MODAL CONFIG
	$scope.upload_model = function(user_profile, item) {
		
		$scope.result_set = null;
		var url   = links + 'pcis/defendfiles/info';
		var param = {
			DocID: item.DocID,
			DefendRef: item.DefendRef,
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
			        	items: function () { return [item.DocID, item.DefendRef, item.DefendCode, user_profile, items[4]]; },
						fileList: function() { return result_set; }
			        }
			    });
				
				modalInstance.result.then(
					function() {}, 
					function(resp) {
						if(resp.state) { 
							$scope.grid_restate = true;
							loadIssueList(); 
						}
					}
				);
	
			}
		
		});
	
	};
	
	// HISTORY MODAL
	$scope.openDataHistory = function(userInfo, defendItem) {
		
		var url   = links + 'pcis/defenddashboard/log';
		var param = {
			DocID: defendItem.DocID,
			DefendRef: defendItem.DefendRef,
		    DefendCode: defendItem.DefendCode	
		}

		help.executeservice('post', url, param)
		.then(function(resp) {
			if(resp.status == 200) {
				
				var modalInstance = $uibModal.open({
			        //animation: true,
			        //backdrop  : 'static',
			        keyboard  : true,
			        templateUrl: 'modalDefendHistoryList.html',
			        controller: 'ModalInstanceHistoryCtrl',
			        size: 'md',
			        windowClass: 'modal-fullscreen animated zoomIn',
			        resolve: {
			        	items: function () { return [defendItem, userInfo]; },
			        	datalogs: function() { return resp.data; }
			        }
			    });
		
			}
		});
		
	}
		
	$scope.print_area = function(divHeader, divName, primarydata) {
		if(help.in_array(primarydata[2][0].EmployeeCode, primarydata[4])) {
			
			if(confirm('การกดยืนการปริ๊นเอกสารจะเป็นการยืนยันสถานะการส่่งใบคำร้องการขอ Defend ถึง CA \nคุณต้องการปริ๊นเอกสารหรือไม่')) {
				
				$('#duplex-container > input.checkbox').prop('checked', false);
				$.ajax({
			      	url: pathFixed + 'index.php/dataloads/printDefend?_=' + new Date().getTime(),
			        data: {
						doc_id: primarydata[0],
						defendref: primarydata[1],
						userid: primarydata[2][0].EmployeeCode,
						username: primarydata[2][0].FullNameTh
					},
			        type: "POST",
			        cache: false,
				    success: function (responsed) { 
				    	
				    	if(responsed['status']) {
				    		 $scope.grid_restate = true;
				    		 $scope.noitfyconfig.message = 'ระบบดำเนินการเปลี่ยนแปลงสถานะเป็นจัดส่งเอกสารสำเร็จ';
			        		 Notification.success( $scope.noitfyconfig);
			        		 
			        		 $uibModalInstance.dismiss({ status: 'cancel', state: $scope.grid_restate });
	                    	
				    	} else {
				    		 $scope.noitfyconfig.message = 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่';
			        		 Notification.error( $scope.noitfyconfig );
		
				    	}
				    	
				    },
				    complete:function() {},
				    error: function (error) { console.log(error); }	        
				});
				
				var printHeaders  = document.getElementById(divHeader).innerHTML;
				var printContents = document.getElementById(divName).innerHTML;
				var popupWin = window.open('', '_blank', 'top=0,width=auto,height=auto,resizable=yes');
				  
				popupWin.document.open();
				popupWin.document.write('<html>' + printHeaders + '<body onload="window.print()">' +  printContents + '</body></html>');
				popupWin.document.close();
					
				return true;
			
			}
			
			return false;
			
		} else {
			
			var printHeaders  = document.getElementById(divHeader).innerHTML;
			var printContents = document.getElementById(divName).innerHTML;
			var popupWin = window.open('', '_blank', 'top=0,width=auto,height=auto,resizable=yes');
			  
			popupWin.document.open();
			popupWin.document.write('<html>' + printHeaders + '<body onload="window.print()">' +  printContents + '</body></html>');
			popupWin.document.close();
			
		}
		
	} 
	
	$scope.confirmEndOfDefend = function(primarydata) {
		var str_name = ($scope.defend_completed == 'Y') ? 'Completed':'Incompleted';
		if(confirm('คุณเลือกสถานะ ' + str_name + ' กรุณากดยืนยันการจบคำร้องขอ Defend ครั้งที่ ' + primarydata[1])) {
			$.ajax({
		      	url: pathFixed + 'index.php/dataloads/endOfProcessDefend?_=' + new Date().getTime(),
		        data: {
					doc_id: primarydata[0],
					defendref: primarydata[1],
					userid: primarydata[2][0].EmployeeCode,
					username: primarydata[2][0].FullNameTh,
					complete: str_name
				},
		        type: "POST",
		        cache: false,
			    success: function (responsed) { 
			    	
			    	if(responsed['status']) {
			    		 $scope.grid_restate = true;
			    		 $scope.noitfyconfig.message = 'ระบบดำเนินการเปลี่ยนแปลงสถานะเป็นจัดส่งเอกสารสำเร็จ';
		        		 Notification.success( $scope.noitfyconfig);
		        		 
		        		 $uibModalInstance.dismiss({ status: 'cancel', state: $scope.grid_restate });
                    	
			    	} else {
			    		 $scope.noitfyconfig.message = 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่';
		        		 Notification.error( $scope.noitfyconfig );
		        		 
			    	}
			    	
			    },
			    complete:function() {},
			    error: function (error) { console.log(error); }	        
			});
		}
		
		$scope.defend_completed = 'N';
		return false;
		
	}
	
	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss({ status: 'cancel', state: $scope.grid_restate });
	};
	
	var setTitleTab = function(objData) {			
		if(objData) {
			var status   = (objData.Status !== '') ? ' (' + objData.Status + ')':'';
			var str_name = objData.BorrowerName + status; 
			$('title').text(str_name); 
			
		} else { $('title').text('Defend Dashboard'); }
		
	}($scope.option_data);
	
	loadIssueOption();
	
})
.controller('ModalTransactionLogsCtrl', function($scope, $filter, help, $uibModalInstance, $q, Notification, items, authority, dataLogs, defendActor) {

	$scope.content = {
		data: items,
		logs: $filter("filter")(dataLogs, {DocID: items.DocID, IsActive: 'A'}, true),
		auth: (help.in_array(items.UserInfo.EmployeeCode, defendActor)) ? true : false
	};

	$scope.noitfyconfig = {
		positionY: 'top', 
		positionX: 'right' 	
	};
	
	$log_changestate = false;
	$scope.acknowlegdeLogs = function(item, info) {
		
		if(confirm('กรุณายืนยันการรับทราบข้อมูล')) {
			item.IsActive 	= 'N';
			console.log(item);
			$.ajax({
				  url: pathFixed + 'index.php/dataloads/acceptDefendLog?_=' + new Date().getTime(),
		    	  data: { 
		    		  relx: item.RowID,
		    		  actor_id: info.UserInfo.EmployeeCode,
		    		  actor_name: info.UserInfo.FullNameTh
		    	  },
		          type: "POST",
		          beforeSend:function() {},
		          success:function(responsed) {		
		        	  
		        	  if(responsed.status) {
		        		  $log_changestate = true;
		        		  $scope.noitfyconfig.message = 'รับทราบข้อมูล';
		        		  Notification.success( $scope.noitfyconfig );
		        		  
		        	  } else {
		        		  $scope.noitfyconfig.message = 'เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
		        		  Notification.success( $scope.noitfyconfig );
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
				
	}
	
	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss({ status: 'cancel', state: $log_changestate });
	};
	
})
.controller('ModalInstanceHistoryCtrl', function($scope, $filter, help, $uibModalInstance, $q, items, datalogs) {

	$scope.content = {
		data: items,
		logs: datalogs
	}
	
	$.each($scope.content.logs, function(index, value) { 
		value.CreateDate = moment(value.CreateDate).format('YYYY-MM-DD HH:mm:ss')
	});

	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss('cancel');
	};
	
})
.controller('modalUploadListCtrl', function($scope, $filter, help, FileUploader, Notification, $uibModalInstance, $q, items, fileList) {

	$scope.pdf_list = fileList; // PDF Details
	$scope.noitfyconfig = {
		positionY: 'top', 
		positionX: 'right' 	
	}
		
	var uploader = $scope.uploader = new FileUploader({
        url: pathFixed + 'index.php/file_upload/setFileUploader',
        formData: [{
        	rel: items[0],
        	ref: items[1],
    		cox: items[2]
        }]
    });

// 	  CALLBACKS
//    uploader.onWhenAddingFileFailed = function(item, filter, options) { console.info('onWhenAddingFileFailed', item, filter, options); };
//    uploader.onAfterAddingFile = function(fileItem) { console.info('onAfterAddingFile', fileItem); };
//    uploader.onAfterAddingAll = function(addedFileItems) { console.info('onAfterAddingAll', addedFileItems); };
//    uploader.onBeforeUploadItem = function(item) { console.info('onBeforeUploadItem', item); };
//    uploader.onProgressItem = function(fileItem, progress) { console.info('onProgressItem', fileItem, progress); };
//    uploader.onProgressAll = function(progress) { console.info('onProgressAll', progress); };
//    uploader.onSuccessItem = function(fileItem, response, status, headers) { console.info('onSuccessItem', fileItem, response, status, headers); };
//    uploader.onErrorItem = function(fileItem, response, status, headers) { console.info('onErrorItem', fileItem, response, status, headers); };
//    uploader.onCancelItem = function(fileItem, response, status, headers) { console.info('onCancelItem', fileItem, response, status, headers); };
//    uploader.onCompleteItem = function(fileItem, response, status, headers) { console.info('onCompleteItem', fileItem, response, status, headers); };
    
	uploader.onCompleteAll = function() { 
		
    	var url   = links + 'pcis/defendfiles/info';
		var param = {
			DocID : items[0],
			DefendRef : items[1],
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

    	console.info('onCompleteAll', $scope.itemList);

    };
    
    $scope.state_change = false;
    $scope.$watch('pdf_list.body', function(n, o) {
		if(n !== o) { 
			 $scope.state_change = true; 
		}
	}, true);   

	$scope.openedFile = function($files) {
	
		if($files.FileState === 'Y') {
			window.open(pathFixed + 'upload/' + $files.File_Reference, '_blank');
			
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
				        	  if(responsed.status) window.open(pathFixed + 'upload/' + $files.File_Reference, '_blank');	          	
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
				window.open(pathFixed + 'upload/' + $files.File_Reference, '_blank');
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
	
    // Discard Modal
	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss({ status: 'cancel', state: $scope.state_change });
	};
	
	// Collapse Panel
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
.controller('ctrlLoadActionNote', function($scope, $filter, help, $uibModalInstance, $q, items) { 

	$scope.itemList = null;
	$scope.progress = true;
	$scope.noteinfo	= false;
	
	$scope.headinfo = {
		custname  : null,
		appnumber : null,
		a2cadate  : null
	}
	console.log(pathFixed);
	$scope.modalHeight = '350px';
	if(items.DocID) {
	
		$.ajax({
	       url: pathFixed + 'index.php/dataloads/loadActionNoteJSONLog?_=' + new Date().getTime(),
	       type: "POST",
	       data: { docx: items.DocID },
	       success:function(responsed) {
	    	   console.log(responsed.data);
	    	   if(responsed.data) {
	    		   
	    		   $scope.itemList = responsed.data;
	    		   $scope.headinfo.custname  = (items.Data) ? items.Data.BorrowerName:'';
	    		   $scope.headinfo.appnumber = (items.Data) ? items.Data.ApplicationNo:'';
	    		   $scope.headinfo.a2cadate  = (items.Data.LatestAppProgress && items.Data.LatestAppProgress == 'A2CA') ? items.Data.LatestAppProgress + ' : ' + moment(items.Data.LatestAppProgressDate).format('DD/MM/YYYY'):'';
	    		   $scope.progress = false;	   
	    		   
	    		   setTimeout(function() {
	    			   $scope.noteinfo = true 
	    		   }, 200);
	    		   
	    	   }
	    		   
	    	   
	       },	
	       complete:function() {},
	       cache: true,
	       timeout: 15000,
	       statusCode: {
		        404: function() { console.log( "page not found." ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied.)"); },
		        500: function() { console.log("internal server error."); }
	       }
	   })
		
	}
	
	$scope.modalToggle = false;
	$scope.setModalHeight = function(height) {

		var height_table = $('.scrollArea > table').height();
		if(!height) {
			$scope.modalHeight = 'height: ' + height_table + ', -webkit-transition: all 0.5s ease-in-out, transition: all 0.5s ease-in-out';
			$('.scrollableContainer').css({ 'height': $('.scrollArea > table').height(), '-webkit-transition': 'all 0.5s ease-in-out', 'transition': 'all 0.5s ease-in-out' });
			$scope.modalToggle = true;
		} else {
			$scope.modalHeight = 'height: 350px, -webkit-transition: all 0.5s ease-in-out, transition: all 0.5s ease-in-out';
			$('.scrollableContainer').css({ 'min-height': '320px', 'height': '320px', '-webkit-transition': 'all 0.5s ease-in-out', 'transition': 'all 0.5s ease-in-out' });
			$scope.modalToggle = false;
		}
	}

	$scope.dismiss_modal = function () { $uibModalInstance.dismiss('cancel'); };
	
});

function parseBool(value) {
    if (typeof value === "boolean") return value;
    if (typeof value === "number") return value === 1 ? true : value === 0 ? false : undefined;
    if (typeof value != "string") return undefined;
    return value.toLowerCase() === 'true' ? true : false;
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