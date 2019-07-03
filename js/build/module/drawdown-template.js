var links = "http://172.17.9.94/newservices/LBServices.svc/";
var pcisDrawDownTemplate = angular.module("pcisDrawDownTemplate", ["pcis-collection", "angular.filter", "checklist-model", "ui.mask"])
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
   
        	$(element).change(function() {
                scope.$apply();
        	});
        	
        	scope.$watch("data",function(n){
        		$(element).multipleSelect(scope.config).multipleSelect('refresh');
 
        	});
        	
        	scope.$watch("config",function(n){
        		$(element).multipleSelect(scope.config).multipleSelect('refresh');
        	});
        	
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
.directive('ddFileModel', function ($parse) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {

                element.bind("change", function () {
                    $parse(attrs.ddFileModel).assign(scope, element[0].files);
                    scope.$apply();
                    
                    scope.$eval(attrs.ddFileChange)(scope);
                });
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
				useYearNav: true
			});
		
		}
	}
})
.directive('numFormat',function($parse){
	return {
		restrict:'A',
	      require: 'ngModel',
	      link: function (scope, elem, attrs){ 

	    	  elem.number(true, attrs.numFormat);
	    	 
	    	  var model = $parse(attrs.ngModel);
	          var modelSetter = model.assign;
	    
	          elem.bind('blur', function(){
	        	  var numAmt = $(this).val(); 
	        	  scope.$apply(function() { modelSetter(scope, numAmt); });   	
	          });
 
	      }
	  };
})
.directive('webuiPopover', function($parse, $timeout) {
	return {
		restrict: 'A',
		scope: {
	       data: '=',
	       config: '='
	    },
		link: function (scope, element, attrs) {
			scope.$watch('data', function(n, o) {
				if(n) {
					scope.config.content = n;
					$(element).webuiPopover('destroy').webuiPopover(scope.config);	
				} else {
					$(element).webuiPopover(scope.config);	
				}
			})
				
		}
	}
})
.directive('autoHeight', function() {
	return {
		restrict: 'A',
		scope: {
	       data: '=',
	       config: '='
	    },
		link: function (scope, element, attrs) {
			
			$(element).each(function() { h(this); })
			.on('input', function () { h(this); });
		
		    function h(e) {
		    	$(e).css({'height':'auto','overflow-y':'hidden'}).height((e.scrollHeight) ? e.scrollHeight:20)
		    }
		    
		}
	}
})
.directive('fieldAutocompleted', function($parse) {
	return {
		restrict: 'A',
		require: 'ngModel',
		scope: {
			config: '='
		},
		link: function (scope, element, attrs) {
			
			var model = $parse(attrs.ngModel);
		    var modelSetter = model.assign;
		    
		    var source_master = [];
		    scope.$watch('config', function(n, o) {
		    	if(n && n.length > 0) {
		    		$.each(n, function(index, value) { source_master.push(value.NameTh); });
		    	} 
		    	
		    	$(element).autocomplete({ 
					source: source_master,
					select: function(event, ui) {
						if(ui.item.value) scope.$apply(function() { modelSetter(scope, ui.item.value); });
					}
				})

		    });
		        
		    

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
  	        jqgridFooterEnabled: '=',
  	        pagingInfo: '=',
  	        sortOrder: '=',
  	        grandTotalFooter: '='
        },
        link: function (scope, element, attrs) {
   
            angular.extend(scope.config, {
            	loadComplete: updateSize,
                gridComplete: function() {
                	$compile(angular.element('#' + scope.config.id))(scope);
                	$("[data-toggle=popover]").popover({ html:true, trigger: "manual" })
                	.on("mouseenter", function () {
					    var _this = this;
					    $(this).popover("show");
					    $(".popover").on("mouseleave", function () {
					        $(_this).popover('hide');
					    });
					}).on("mouseleave", function () {
					    var _this = this;
					    setTimeout(function () {
					        if (!$(".popover:hover").length) {
					            $(_this).popover("hide");
					        }
					    }, 300);
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
  	       
            });

            function updateSize() {
            	var paging_info = $('.ui-paging-info').text();
            	if(paging_info) scope.pagingInfo = paging_info + ' entries';  
            	
                var lines  = $("tr", this),
                    flines = $("tr", "#" + scope.config.id +"_frozen" );
               
                flines.each(function(i, item){
                    $(item).height( $(lines[i]).innerHeight() - (i%2?1:0) );
                });
                
                var $grid_table  	= $(this),
                	$grid_footer 	= $('.ui-jqgrid-ftable')
                	crline_sum   	= $grid_table.jqGrid("getCol", "CR_LINE", false, "sum");
                
                var $grid_footRight = $('#grid_pager_right');
                
                var $option_footer  = $('.option_footer').length;
                if($option_footer >= 1) $('.option_footer').remove();
  
                var crline_sum 		= (crline_sum > 0) ? crline_sum : 0;
                var grand_total		= (scope.grandTotalFooter > 0) ? scope.grandTotalFooter : 0
	            $grid_footRight.append(
	            	'<div class="option_footer pull-left">' +
	            		'<span class="" style="font-weight: normal; padding: 0 10px;"> Total: ' + formattedNumber(crline_sum) + '</span>' +
	            		'|<span class="text_bold" style="padding: 0 10px;">Grand Total: ' + formattedNumber(scope.grandTotalFooter) + '</span>' +
	            	'</div>'
	            );
	          
            }
            
            function formattedNumber(num, x = 0) {
            	var renum = parseFloat(num).toFixed(x);
            	return renum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            }
            
        }
    };
})
.directive('filePdfDivision', function($compile) {
	 return {
        restrict: 'E',
        scope: {
            config: '='
        },
        link: function (scope, element, attrs) {
        	element.children().empty();
        	
        	if(scope.length === undefined) element.append('<div class="file_notfound animated zoomIn text-center">File not found</div>');
        	scope.$watchCollection('config', function (newValue) {
        				
        		var i = 1;
        		angular.forEach(newValue, function(value, key) {
        			element.append(			    	    	
	           			'<div class="file_container animated fadeInLeft" style="margin-top: 3%; margin-left: 2% !important;">' +
	           				'<span style="position: absolute; margin-top: -30px; color: #000;">' + value.FileName + '</span>' +
	           				'<a id="pdf_link_' + i + '" href="' + value.FilePath + '" target="_blank">' +			
		           				'<div id="pdf_progress_' + i + '" class="progress-bar small"></div>' +  
		           				'<div class="file_wrapper">' +
									'<div id="pdf_' + i + '" class="thumbnail_file animated fadeInLeft"></div>' +
									'<span class="file_msg">View</span>' +
								'</div>' +
							'</a>' +
						'</div>'					
					);
        			
        			var pdf_viewer = $("#pdf_" + i);
        			var prop = {
						element: pdf_viewer,
					    source: value.FilePath,
					    scale: 0,
					    pageNum: 1,
				 	    maxHeight: 178,
					    maxWidth: 500,
					    onProgress: function (progress) {						   
					           
					    }
					};
        			
        			angular.element(document).find('.file_notfound').remove();
				
					CreateViewer(pdf_viewer, prop);
        			i++;
        			
    			});
        		  
        	});
        	
        	$("#pdf_thumbnail").mCustomScrollbar({
				axis:"x",
				theme: 'light-thin',
				advanced:{
					autoExpandHorizontalScroll:true
				}
			
			});
      
        	// Start PDF Thumbnails
        	function PaginationStatus(currentPage, totalPages) {
        	    var _currentPage = parseInt(currentPage, 10), _totalPages = parseInt(totalPages, 10);
        	    this.currentPage = function () {
        	        return _currentPage;
        	    };
        	    this.nextPage = function () {
        	        if (_currentPage >= _totalPages) {
        	            return;
        	        }
        	        _currentPage += 1;
        	    };
        	    this.previousPage = function () {
        	        if (_currentPage === 1) {
        	            return;
        	        }
        	        _currentPage -= 1;
        	    };
        	    return this;
        	}

        	function RenderViewport(height, width, scale, rotation) {
        	    var _height = height, _width = width, _scale = scale || 1, _rotation = rotation || 0;
        	    this.adjustCanvasDimensions = function (height, width, canvas) {
        	        var ratio = width / height;
        	        if (height > _height) {
        	            height = _height;
        	            width = height * ratio;
        	        }
        	        if (width > _width) {
        	            width = _width;
        	            height = width / ratio;
        	        }
        	        canvas.height = height;
        	        canvas.width = width;

        	    };
        	    this.rotateClockwise = function () {
        	        _rotation += 90;
        	    };
        	    this.rotateCounterClockwise = function () {
        	        _rotation -= 90;
        	    };
        	    this.getRotation = function () {
        	        return _rotation - 90;
        	    };

        	    return this;
        	}

        	function PdfRenderer(prop, canvas) {
        	    var pdfDoc = null, renderPage = function (pagination) {
        	        pdfDoc.getPage(pagination.currentPage()).then(function (page) {
        	            var viewport = page.getViewport(parseInt(prop.scale, 10) || 1, 0), renderContext = {}, targetViewport = new RenderViewport(prop.maxHeight || viewport.height, prop.maxWidth || viewport.width);
        	            targetViewport.adjustCanvasDimensions(viewport.height, viewport.width, canvas);
        	            page.render({
        	                canvasContext: canvas.getContext("2d"),
        	                viewport: page.getViewport(canvas.height / viewport.height, targetViewport.getRotation())
        	            });
        	        });
        	    };
        	    this.render = function () {
        	        if (!prop.source) {
        	            return;
        	        }
        	        PDFJS.disableWorker = true;
        	        PDFJS.getDocument(prop.source, null, null, prop.onProgress).then(function (_pdfDoc) {
        	            pdfDoc = _pdfDoc;
        	            renderPage(new PaginationStatus(prop.pageNum || 1, pdfDoc.numPages));
        	        }, function (error) {
        	            //console.log(error);
        	        });
        	    };
        	    return this;
        	}

        	function CreateViewer(container, prop) {
        	    var canvas = document.createElement("canvas"), renderer = null, renderFunc = function () {
        	        if (renderer) {
        	            renderer.render();
        	        }
        	    };
        	    container.empty().append(canvas);
        	    renderer = new PdfRenderer(prop, canvas);
        	    renderFunc();
        	}
        	// End PDF Thumbnails
        	
        }
	 }
	
})
.directive('date', function (dateFilter ,$filter) {
    return {
        require:'ngModel',
        link:function (scope, elm, attrs, ctrl) {
            var dateFormat = attrs['date'] || 'yyyy-MM-dd';
            ctrl.$formatters.unshift(function (modelValue) {
            	if(modelValue) {
            		return dateFilter(new Date(modelValue), dateFormat);
            	} else {
            		return '';
            	}
            });
        }
    };
})
.filter('currentdate',['$filter',  function($filter) {
    return function() {
        return $filter('date')(moment().format('DD/MM/YYYY HH:mm:ss'), 'dd/MM/yyyy HH:mm');
    };
}])
.filter('unique', function() {

	  return function (arr, field) {
	    var o = {}, i, l = arr.length, r = [];
	    for(i=0; i<l;i+=1) {
	      o[arr[i][field]] = arr[i];
	    }
	    for(i in o) {
	      r.push(o[i]);
	    }
	    return r;
	  };
})
.controller("ctrlPcisDrawDownTemplate", function($scope, socket, $filter, help, $uibModal, $log, $compile, $http) {
	
	socket.emit("register:ddtemplate_chanel",{});
	socket.on("reservations:dd",function(data){
		console.log(data);
		if(data.reload) { onLoadDataGrid(); }
	});
	
	var width  = $(document).width() - 30;
	var height = $(document).height() - 310;

	$('title').text('Drawdown Template');	
	
	// ROLE AUTHORUTY
	var cilent_id = $('div[ui-chat-client]').attr('ui-chat-client');
	var role_user = $('div[ng-controller="ctrlPcisDrawDownTemplate"]').attr('ui-role-cilent');
	
	$('.progress').show();
	if(role_user) {
		
		$scope.cilent_id = cilent_id;
		$scope.role_user = role_user; 
		
		$scope.adminrole 	= ['57251', '56225', '58141', '56679', '58385', '57568', '59440'];
		var lb_export_group = ['58360', '56680', '58080', '56465', '50072', '59389', '59414', '57151', '57017', '57249', '59692'];
		if(help.in_array($scope.cilent_id, $scope.adminrole)) {
			$scope.role_field = {
					'information': {
						'CustType': true,
						'PaymentType': true,						
						'KYC': true,
						'Cashy': true,
						'TotalNetAmt': true,
						'Complete': true,
						'RecieveFileDateTime': false,
						'AppraisalStatus': true,
						'saveForm': true,
						'BookBankFlag': true, // New
						'BookBankStatus': true,
						'BookBankFile': true,
						'ContactFile': true,
						'BorrowerAmount': true,
						'BorrowerBank': true,
						'BorrowerName': true,
						'BorrowerPayType': true,
						'BorrowerType': true,
						'CashyAmt': true,
						'BookbankNo': true,
						'ReProcess': true
					},
					'callateral': {
						'RefNo': true,
						'OwnerShipDoc': true,
						'FileInput': true,
						'FileStatus': true,
						'FileChecker': true,
						'FileUpload': true,
						'CollateralType': true,
						'ApproveValue': true,
						'Province': true,
						'Amphur': true,
						'Tambol': true,
						'AgencyMortgage': true,
						'PayType': true,
						'PaymentChannel': true,
						'BankPayment': true,
						'CollateralStatus': true,
						'Refinance': true,
						'Bank': true,
						'addCollateral': true,
						'removeCollateral': true,
						'ItemHidden': true,
						'saveForm': true,
						'OrtherNote': true, // New
						'Amount2': true,
						'Amount3': true,
						'Amount4': true,
						'Amount5': true,
						'Bank2': true,
						'Bank3': true,
						'Bank4': true,
						'Bank5': true,
						'PayType2': true,
						'PayType3': true,
						'PayType4': true,
						'PayType5': true
					},
					'partners': {
						'OnBehalfType': true,
						'PayeeName': true, 
						'PayType': true,
						'Bank': true,
						'PayAmount': true,
						'PatchFlag': true,
						'PatchStatus': true,
						'PatchFile': true,
						'PatchValid': true,
						'PatchRemove': true,
						'AddRows': true,
						'BookbankNo': true
					},
					'noteinfo': {
						'Note': true,
						'saveForm': true
					},
					'menu_icon': {
						'oper_report': true
					},
					'dashboard': { 
						'OperNotify': true,
						'exportFile': true
					}
				};
			
		} else {
		switch(role_user) {
			case 'CA_ROLE':
			default:
				$scope.role_field = {
					'information': {
						'CustType': false,
						'PaymentType': false,						
						'KYC': false,
						'Cashy': false,
						'TotalNetAmt': false,
						'Complete': false,
						'RecieveFileDateTime': false,
						'AppraisalStatus': false,
						'saveForm': false,
						'BookBankFlag': false, // New
						'BookBankStatus': false,
						'BookBankFile': false,
						'ContactFile': false,
						'BorrowerAmount': false,
						'BorrowerBank': false,
						'BorrowerName': false,
						'BorrowerPayType': false,
						'BorrowerType': false,
						'CashyAmt': false,
						'BookbankNo': false,
						'ReProcess': false
					},
					'callateral': {
						'RefNo': false,
						'OwnerShipDoc': false,
						'FileInput': false,
						'FileStatus': false,
						'FileChecker': false,
						'FileUpload': false,
						'CollateralType': false,
						'ApproveValue': false,
						'Province': false,
						'Amphur': false,
						'Tambol': false,
						'AgencyMortgage': false,
						'PaymentChannel': false,
						'PayType': false,
						'BankPayment': false,
						'CollateralStatus': false,
						'Refinance': false,
						'Bank': false,
						'addCollateral': false,
						'removeCollateral': false,
						'ItemHidden': false,
						'saveForm': false,
						'OrtherNote': false, // New
						'Amount2': false,
						'Amount3': false,
						'Amount4': false,
						'Amount5': false,
						'Bank2': false,
						'Bank3': false,
						'Bank4': false,
						'Bank5': false,
						'PayType2': false,
						'PayType3': false,
						'PayType4': false,
						'PayType5': false
					},
					'partners': {
						'OnBehalfType': false,
						'PayeeName': false, 
						'PayType': false,
						'Bank': false,
						'PayAmount': false,
						'PatchFlag': false,
						'PatchStatus': false,
						'PatchFile': false,
						'PatchValid': false,
						'PatchRemove': false,
						'AddRows': false,
						'BookbankNo': false
					},
					'noteinfo': {
						'Note': true,
						'saveForm': true
					},
					'menu_icon': {
						'oper_report': false
					},
					'dashboard': { 
						'OperNotify': false,
						'exportFile': true 
					}
				};
			break;
			case 'OPER_ROLE':
				$scope.role_field = {
					'information': {
						'CustType': false,
						'PaymentType': false,						
						'KYC': false,
						'Cashy': false,
						'TotalNetAmt': false,
						'Complete': false,
						'RecieveFileDateTime': false,
						'AppraisalStatus': true,
						'saveForm': true,
						'BookBankFlag': false, // New
						'BookBankStatus': true,
						'BookBankFile': false,
						'ContactFile': false,
						'BorrowerAmount': true,
						'BorrowerBank': true,
						'BorrowerName': true,
						'BorrowerPayType': true,
						'BorrowerType': true,
						'CashyAmt': false,
						'BookbankNo': true,
						'ReProcess': true
					},
					'callateral': {
						'RefNo': false,
						'OwnerShipDoc': false,
						'FileInput': false,
						'FileStatus': true,
						'FileChecker': true,
						'FileUpload': false,
						'CollateralType': false,
						'ApproveValue': false,
						'Province': false,
						'Amphur': false,
						'Tambol': false,
						'AgencyMortgage': true,
						'PaymentChannel': true,
						'PayType': true,
						'BankPayment': true,
						'CollateralStatus': false,
						'Refinance': true,
						'Bank': false,
						'addCollateral': false,
						'removeCollateral': false,
						'ItemHidden': false,
						'saveForm': true,
						'OrtherNote': false, // New
						'Amount2': false,
						'Amount3': false,
						'Amount4': false,
						'Amount5': false,
						'Bank2': false,
						'Bank3': false,
						'Bank4': false,
						'Bank5': false,
						'PayType2': false,
						'PayType3': false,
						'PayType4': false,
						'PayType5': false
					},
					'partners': {
						'OnBehalfType': false,
						'PayeeName': false, 
						'PayType': false,
						'Bank': false,
						'PayAmount': false,
						'PatchFlag': false,
						'PatchStatus': true,
						'PatchFile': false,
						'PatchValid': true,
						'PatchRemove': false,
						'AddRows': false,
						'BookbankNo': true
					},
					'noteinfo': {
						'Note': true,
						'saveForm': true
					},
					'menu_icon': {
						'oper_report': true
					},
					'dashboard': { 
						'OperNotify': true,
						'exportFile': true 
					}
				};
				break;
			case 'LB_ROLE':
				$scope.role_field = {
					'information': {
						'CustType': true,
						'PaymentType': true,						
						'KYC': true,
						'Cashy': true,
						'TotalNetAmt': true,
						'Complete': true,
						'RecieveFileDateTime': false,
						'AppraisalStatus': true,
						'saveForm': true,
						'BookBankFlag': false, // New
						'BookBankStatus': false,
						'BookBankFile': true,
						'ContactFile': true,
						'BorrowerAmount': true,
						'BorrowerBank': true,
						'BorrowerName': true,
						'BorrowerPayType': true,
						'BorrowerType': true,
						'CashyAmt': true,
						'BookbankNo': true,
						'ReProcess': true
					},
					'callateral': {
						'RefNo': true,
						'OwnerShipDoc': true,
						'FileInput': true,
						'FileStatus': false,
						'FileChecker': false,
						'FileUpload': true,
						'CollateralType': true,
						'ApproveValue': true,
						'Province': true,
						'Amphur': true,
						'Tambol': true,
						'AgencyMortgage': true,
						'PaymentChannel': false,
						'PayType': true,
						'BankPayment': true,
						'CollateralStatus': true,
						'Refinance': true,
						'Bank': true,
						'addCollateral': true,
						'removeCollateral': true,
						'ItemHidden': true,
						'saveForm': true,
						'OrtherNote': true, // New
						'Amount2': true,
						'Amount3': true,
						'Amount4': true,
						'Amount5': true,
						'Bank2': true,
						'Bank3': true,
						'Bank4': true,
						'Bank5': true,
						'PayType2': true,
						'PayType3': true,
						'PayType4': true,
						'PayType5': true
					},
					'partners': {
						'OnBehalfType': true,
						'PayeeName': true, 
						'PayType': true,
						'Bank': true,
						'PayAmount': true,
						'PatchFlag': true,
						'PatchStatus': true,
						'PatchFile': true,
						'PatchValid': false,
						'PatchRemove': true,
						'AddRows': true,
						'BookbankNo': true
					},
					'noteinfo': {
						'Note': true,
						'saveForm': true
					},
					'menu_icon': {
						'oper_report': false
					},
					'dashboard': { 
						'OperNotify': false,
						'exportFile': (help.in_array($scope.cilent_id, lb_export_group)) ? true:false 
					}
				};
			
			break;
		}
		
		} // End Scope Auth Spcecial;
		
		console.log([$scope.role_user, $scope]);

		var isAllowButton    = true;
		$scope.allow_change  = true;
		
		$scope.rangeDayAllow = getFirstDayInMonth(new Date(), 5);
		var firstDaysOfMonth = getFirstDayInMonth(new Date(), 5);
		var lastDaysOfMonth  = getLastDayInMonth(new Date(), 5);

		var system_allow	 = $.merge(firstDaysOfMonth, lastDaysOfMonth);
		if(help.in_array($scope.cilent_id, $scope.adminrole)) {
			$scope.role_handled = {
				'elements': {
					'customer_btn'  : false,
					'collateral_btn': false,
					'noteinfo_btn'	: false,
					'partners_btn'	: false
				}
			}
		} else {
			if(help.in_array(moment().format('DD'), system_allow)) {
				$scope.role_handled = {
					'elements': {
						'customer_btn'  : false,
						'collateral_btn': false,
						'noteinfo_btn'	: false,
						'partners_btn'	: false
					}
				}
			} else {
				$scope.role_handled = {
					'elements': {
						'customer_btn'  : true,
						'collateral_btn': true,
						'noteinfo_btn'	: true,
						'partners_btn'	: true
					}
				}
			}
		}
		
		if(isAllowButton) {
			$scope.role_handled = {
				'elements': {
					'customer_btn'  : false,
					'collateral_btn': false,
					'noteinfo_btn'	: false,
					'partners_btn'	: false
				}
			}
		}
		
		// Enable Actually
		/*
		if(!help.in_array(moment().format('DD'), lastDaysOfMonth)) {
			$scope.role_field.information.ReProcess = true;			
		}
		*/
		
		function getFirstDayInMonth(inputDate, splitLastDay) {
	        var cDate = new Date(inputDate);

	        var lastDateofMonth = new Date(cDate.getFullYear(), cDate.getMonth() + 1, 0);
	        var lastDayofMonth  = lastDateofMonth.getDate();
	    
	        var dayInMonth = [];
	        for (var i = 1; i <= lastDayofMonth; i++) {
	            var d = new Date(cDate.getFullYear(), cDate.getMonth(), i);
	            if (d.getDay() < 6 && d.getDay() > 0) {
	                dayInMonth.push(d.getDate());
	            }
	        }
	  
	        return dayInMonth.splice(0, splitLastDay);
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
		
	}

	// Function Formatter	
	var fnTruncateName = function(value, model, rowData) {
		if(value == 'Total:') {
			return value
		} else {
			
			if(value === null || value === '') {
				return '';
				
			} else {
				
				var str_name = value.split(' ')[0] + '...';
				var str_mobile   = '';
				
				var key		 = model.colModel.name + 'MOBILE';
				if(help.in_array(model.colModel.name, ['RM'])) {
					str_mobile	 = ' (' + rowData[key] + ')';
				}
				
				return '<span class="tooltip-right" data-tooltip="' + value + str_mobile + '" style="margin-top: 0px; margin-left: 0px;">' + str_name + '</span>';
				
			}
		}

	}
	
	var fnObjectHandled = function (value, model, rowData) {
		var icon_class = '';		
		if(rowData.PLAN_DRAWDOWN && rowData.PLAN_DRAWDOWN !== null) {
			if(rowData.PLAN_DRAWDOWN === moment().format('YYYY-MM-DD'))  {
				
				if(!help.in_array(rowData.COMPLETE_STATE, ['Y', 'N'])) {
					icon_class = 'fa fa-exclamation-circle icon_blink fg-red';
				} else {
					if(help.in_array(rowData.COMPLETE_STATE, ['Y', 'N'])) icon_class = '';
					else icon_class = 'fa fa-exclamation-circle icon_blink fg-red';
					
				}

			} else if(moment().format('YYYY-MM-DD') >= rowData.PLAN_DRAWDOWN && !help.in_array(rowData.COMPLETE_STATE, ['Y', 'N'])) {
				icon_class = 'fa fa-exclamation-circle icon_blink fg-red';
			} else  {
				icon_class = '';
			}
			
		}
		
		if(help.in_array(rowData.APPRAISAL_STATUS, ['Cancel', 'Completed'])) {
			icon_class = '';
		} 
		
		var icon =  
			"<span data-row-data='" + rowData.APP_NO + "' ng-click='config.modalDashboard($event)'>" +
		   		'<i class="fa fa-laptop" ng-click="config.modalEnabled(\'' + value + '\')" style="font-size: 1.3em; cursor: pointer; margin-left: 5px;"></i>' +
		   		'<i class="' + icon_class + '" style="font-size: 1.4em; position: absolute; margin-top: -8px; margin-left: -7px;"></i>' +
		  	'</span>';
		
		return (rowData.APP_NO) ? icon:'';
	} 
	
	var fnMissingHandled = function (value, model, rowData) {
		var attr = 'ng-click="config.modalMissingEnabled(\'' + rowData.DOC_ID + '\')"';
		var icon = '<span ' + attr + '>' +
	   		'<span class="icon-copy fg-steel" style="font-size: 1.3em; cursor: pointer; margin-left: 5px;"></span>' +
	   		'<span class="badge bg-amber" style="font-size: 0.8em; position: absolute; margin-top: -7px; margin-left: -13px;">' + value + '</span>' +
	   '</span>';
		
		return (rowData.DOC_ID) ? icon:'';
	}
	
	var fnPersonHandled = function (value, model, rowData) {
		var icon = '';
		if(value) icon = 'fa fa-user fg-green';
		else icon = 'fa fa-user-times fg-red';

		return '<span><span class="' + icon + '" style="font-size: 1.3em; cursor: pointer; margin-left: 5px;"></span></span>';
		
	}
	
	var fnProductHandled = function(value, model, rowData) {
		var icon = '';
		if(rowData.CONTRACTFILE) {
			icon = 'background-color: #dbd9d9; border: 1px dotted red; padding: 2px; font-weight: bold;';
		}
	
		return (rowData.PRODUCT_TYPE) ? '<span class="tooltip-right" data-tooltip="' + rowData.PRODUCT + '" style="margin-top: 0px; margin-left: -25px; ' + icon + '">' + rowData.PRODUCT_TYPE + '</span>':''; 
	}
	
	var fnStatusHandled = function(value, model, rowData) {
		var decision_date = (rowData._DecisionDate) ? 'Decision Date: ' + moment(rowData._DecisionDate).format('DD/MM/YYYY'):null;
		if(decision_date)
			return '<span class="tooltip-right text-center" data-tooltip="' + decision_date + '" style="width: 90px; margin-top: 0px; margin-left: -48px;">' + value + '</span>';
		else 
			return (value) ? value:'';
		
		/*
		if(rowData._RecieveFileDateTime) {
			return value;
		} else {
			
			var Dates = new Date(rowData._DecisionDate);
			var DateCompare = new Date(Dates.getFullYear(), Dates.getMonth(), Dates.getDate(), Dates.getHours() + 2, Dates.getMinutes(), 0);
			if(new Date() > DateCompare)
				return '<div class="fg-red icon_blink_slow">' + value + '</div>';
			else
				return value;
		}
		*/
		
	}
	
	var fnBranchHandled = function(value, model, rowData) { 
		var lb_tel = '';
		if(rowData.LBTEL && rowData.LBTEL !== null) lb_tel = ' (' + rowData.LBTEL + ')';
		
		return (rowData.LBDigit) ? '<span class="tooltip-right" data-tooltip="' + value + lb_tel + '" style="margin-top: 0px; margin-left: 7px;">' + rowData.LBDigit +  '/'  + rowData.LBCH + '</span>':'';  
	}
	
	var fnOperStateHandled = function(value, model, rowData) {
		var classes = '';
		var blink	= '';
		var events  = '';
		var tooltip = '';
	
		if(rowData.OPERCONF == "N") {
			if(help.in_array(value, ['Postpone', 'Re-Process', 'Cancel'])) blink = ' icon_blink_slow';
			
			if($scope.role_user == 'OPER_ROLE' || help.in_array($scope.cilent_id, $scope.adminrole))
			events  = "data-row-data='" + JSON.stringify(rowData.APP_NO) + "' ng-dblclick='config.fnOperConfirm($event)'";
		}
		
		if(help.in_array(rowData.PLAN_DD_WAITINGCONF, ['Y', 'N'])) {
			blink = '';
		}
		
		if(rowData.CREATE) {
			tooltip = (rowData.CREATE) ? 'Appraisal Date: ' + moment(rowData.CREATE).format('DD/MM/YYYY'):'';
		}
		
		switch(value) {
			//case 'Process':
			//classes = 'bg-thinTeal fg-white text_bold nav_icon';
			//break;
			case 'Postpone':
			case 'Re-Process':
				classes = 'bg-thinTeal fg-white text_bold nav_icon text-left';
			break;
			case 'Cancel':
				classes = 'bg-red fg-white text_bold nav_icon';
			break;
		}

		return (value) ? (
			'<span class="tooltip-right" data-tooltip="' + tooltip + '" style="margin-top: 0px; width: 90px; margin-left: -45px; text-align: center;">'+
				'<span ' + events + ' class="' + classes + blink + '" style="min-width: 75px; max-width: 130px; padding: 3px 5px; margin-top: -8px; margin-left: -5px; font-size: 14px;">' + value + '</span>' +
			'</span>'
		):'';
		
	}
	
	var fnReconcileOperDate = function(value, model, rowData) {
		if(value)
			return moment(value).format('DD/MM (HH:mm)');
		else
			return '';
	}
	
	var fnPlanDrawdownCommitState = function(value, model, rowData) {
		if(value && value !== '') {
			if(rowData.PLAN_DD_WAITINGCONF === 'N') {
				return '<span class="fg-red">' + moment(value).format('DD/MM/YYYY') + '</span>';
			} else { 
				return moment(value).format('DD/MM/YYYY'); 
			}		
		} else { return ''; }
		
	}	
	
	var fnFileBookbankState = function(value, model, rowData) {
		
		var str_text;
		if(rowData.BANKBOOK !== '') {
			if(rowData.BANKBOOKFLAG == 'N') {
				str_text = '';
			} else {
				if(rowData.BANKBOOK == 'W') str_text = 'C'; 
				else if(rowData.BANKBOOK == 'C') str_text = '<i class="fa fa-check fg-green padding_none"></i>';
				else if(rowData.BANKBOOK == 'I') str_text = '<i class="fa fa-close fg-red padding_none"></i>';
				else str_text = ''; 
			}

		} else {
			if(rowData.BANKBOOKFLAG == 'Y') str_text = 'Y';
			else str_text = '';
		}	
		
		return str_text;
		
	}
	
	var fnFieldHeight = function(value, model, rowData) {
		
		var height	  = 0;
		var style	  = '';
		var str_note  = '';
		var division  = '';
		var str_color = '';
		var str_blink = '';
		var str_name  = (rowData.CUST_NAME) ? rowData.CUST_NAME:'ไม่พบข้อมูล';
		var note_date = (rowData._NoteUpdateDate) ? moment(rowData._NoteUpdateDate).format('DD/MM (HH:mm)'):null;
		var item_list = (rowData.COLLATERAL) ? rowData.COLLATERAL.length:0;
		
		if(rowData._NoteUpdateDate && rowData._NoteUpdateDate !== '') {

			var noteAlert = moment(rowData._NoteUpdateDate).add(1, 'hours').format('YYYY-MM-DD HH:mm');
			
			if(noteAlert > moment().format('YYYY-MM-DD HH:mm')) str_blink = 'icon_blink_slow';
			else str_blink = '';
	
			if(help.in_array(rowData.NOTEFUNC, ['Operation', 'Cradit Analysis'])) str_color = 'fg-red';
			else str_color = 'fg-darkBlue';
			
			str_note = '<div class="' + str_color + ' ' + str_blink + ' text_bold" title="Latest Note : ' + rowData.NOTEFUNC + '">' +
			'Note: ' + note_date + 
			"<i data-row-data='" + rowData.APP_NO + "' ng-click='config.modalNoteInformation($event)' class='fa fa-commenting-o nav_icon marginLeft5' style='font-size: 1.2em !important;'></i>"
			'</div>';
		}

		if(rowData.COLLATERAL && rowData.COLLATERAL.length >= 1) {
			
			$.each(rowData.COLLATERAL, function(k, v) { 
				if(rowData.COLLATERAL[k]['IsVisible'] == 'A')
					if(item_list > 1) height += 26;
			});
			
			if(item_list > 1) {
				$('#grid_container tr[id="' + model.rowId + '"]').css('background', '#F4C6C6');
		
				height = height - 31;
				style = 'style="vertical-align: middle; min-height: ' + height + 'px; max-height: ' + height + 'px; display: block;"';
			}

		} 
		
		if(str_name && str_name !== '' && str_name.length >= 21) height = height + 15;
		
		division += '<div class="paddingTop5" ' + style + '>' + str_note + '</div>';
		return str_name + division;
	
	}
	
	var fnDivisionLayer = function(value, model, rowData) {
		var classes	  = '';
		var optional  = '';
		var division  = '';
		
		if(rowData.COLLATERAL && rowData.COLLATERAL[0] !== undefined) {
			
			var item_list = rowData.COLLATERAL.length;
			$.each(rowData.COLLATERAL, function(k, v) {
				
				if(rowData.COLLATERAL[k]['IsVisible'] == 'A') {
					
					if(value == 'DEP_LAND') {
						
						var str_text  = '';
						var str_attr  = '';
						
						if(rowData.COLLATERAL[k]['AgencyMortgage']) str_attr = 'class="tooltip-right text_underline" data-tooltip="' + rowData.COLLATERAL[k]['AgencyMortgage'] + '"';
						
						if(help.in_array(rowData.COLLATERAL[k]['Province'], ['กรุงเทพมหานคร', 'นครปฐม', 'นนทบุรี', 'ปทุมธานี', 'สมุทรปราการ', 'สมุทรสาคร']))
							str_text = '<span ' + str_attr + ' style="position: absolute; margin-top: 0px; margin-left: -15px;">BKK</span>';
						else
							str_text = '<span ' + str_attr + ' style="position: absolute; margin-top: 0px; margin-left: -15px;">UPC</span>';
						
						if(item_list > 1) classes = 'class="grid_layer"';
							else classes = 'class="paddingLeft5" style="margin-top: 7px;"';
								division += '<div ' + classes + '>' + str_text + '</div>';
						
					}				
					else if(value == 'FILESTATUS') {
						
						var str_text;
						if(rowData.COLLATERAL[k]['OwnershipBuilding'] == 'N') {
							str_text = '';
						} else {
							if(rowData.COLLATERAL[k]['FileStatus'] == 'W') {
								str_text = 'C';
							} else if(rowData.COLLATERAL[k]['FileStatus'] == 'C') {
								str_text = '<i class="fa fa-check fg-green padding_none"></i>';
							} else if(rowData.COLLATERAL[k]['FileStatus'] == 'I') {
								str_text = '<i class="fa fa-close fg-red padding_none"></i>';
							} else {
								if(rowData.COLLATERAL[k]['OwnershipBuilding'] == 'Y') str_text = 'Y';
								else str_text = '';
							}
						}
						
						
						if(item_list > 1) classes = 'class="grid_layer"';
							else classes = 'style="margin-top: 7px;"';
						
						division += '<div ' + classes + '>' + str_text + '</div>';
						
					}				
					else if(value == 'REFINANCE') {
						var str_text;
						if(rowData.COLLATERAL[k]['CollateralStatus'] == 'Refinance') str_text = 'Y';
							else if(rowData.COLLATERAL[k]['CollateralStatus'] == 'Non Refinance')  str_text = '';
								else str_text = '';
							
						if(item_list > 1) classes = 'class="grid_layer"';
							else classes = 'style="margin-top: 7px;"';
								division += '<div ' + classes + '>' + str_text + '</div>';
					
					} 
					/*
					else if(value == 'ASSET_DATE') {
						
						var str_text = '';;
						if(rowData.COLLATERAL[k]['_ReceiveDocumentDateTime']) { str_text = '<span style="color: #cccccc;">Completed</span>'; }
						else {
							if(rowData.COLLATERAL[k]['_AppointmentReceiveDate'])
								str_text = moment(rowData.COLLATERAL[k]['_AppointmentReceiveDate']).format('DD/MM/YYYY');
							else
								str_text = '';
						}			
						
						if(item_list > 1) classes = 'class="grid_layer"';
							else classes = 'class="paddingLeft5" style="margin-top: 7px;"';
						
						division += '<div ' + classes + '>' + str_text + '</div>';
						
					}  
					*/ 
					else if(value == 'ASSET_DATE') {
		
						var str_text = '';
						if(rowData.COLLATERAL[k]['AssetStatus'] === 'อนุมัติ') { str_text = '<span style="color: #cccccc;">Completed</span>'; }
						else {
							if(rowData.COLLATERAL[k]['_AppointmentReceiveDate'])
								str_text = moment(rowData.COLLATERAL[k]['_AppointmentReceiveDate']).format('DD/MM/YYYY');
							else
								str_text = '';
						}			
						
						if(item_list > 1) classes = 'class="grid_layer"';
							else classes = 'class="paddingLeft5" style="margin-top: 7px;"';
						
						division += '<div ' + classes + '>' + str_text + '</div>';
						
					} else {
						
						if(item_list > 1) classes = 'class="grid_layer"';
							else classes = 'class="paddingLeft5" style="margin-top: 7px;"';
								division += '<div ' + classes + ' ' + optional + '>' + nameTruncateLength(rowData.COLLATERAL[k][value], value) + '</div>';
					}
					
				}

			});

			return division;
			
		} else {
			
			if(value == 'FILESTATUS') {
				var str_text;
				if(rowData.COLLATERAL && rowData.COLLATERAL[0] !== undefined) {
					
					if(rowData.COLLATERAL[k]['OwnershipBuilding'] == 'N') {
						str_text = '';
						
					} else {
						if(rowData.COLLATERAL[0]['FileStatus'] == 'W') {
							str_text = 'C';
							
						} else if(rowData.COLLATERAL[0]['FileStatus'] == 'C') {
							str_text = '<i class="fa fa-check fg-green padding_none"></i>';
							
						} else if(rowData.COLLATERAL[0]['FileStatus'] == 'I') {
							str_text = '<i class="fa fa-close fg-red padding_none"></i>';
							
						} else {
							if(rowData.COLLATERAL[k]['OwnershipBuilding']) str_text = 'Y';
							else str_text = '';
						}
					}
										
				} else {
					if(rowData.OWNERDOC == 'Y') str_text = 'Y';
					else str_text = '';
				}
				
				classes = 'style="margin-top: 7px;"';				
				division += '<div ' + classes + '>' + str_text + '</div>';
			
			} else if(value == 'REFINANCE') {
				var str_text;
				if(rowData.COLLATERAL && rowData.COLLATERAL[0] !== undefined) {
					if(rowData.COLLATERAL[0]['CollateralStatus'] == 'Refinance') str_text = 'Y';
						else if(rowData.COLLATERAL[0]['CollateralStatus'] == 'Non Refinance')  str_text = '';
							else str_text = '';
				} else {
					str_text = '';
				}
				
				classes = 'style="margin-top: 7px;"';
				division += '<div ' + classes + '>' + str_text + '</div>';
			
			} else {
				
				if(rowData.COLLATERAL && rowData.COLLATERAL[0] !== undefined) {
					classes = 'class="paddingLeft5" style="margin-top: 7px;"';
					division += '<div ' + classes + ' ' + optional + '>' + nameTruncateLength(rowData.COLLATERAL[0][value], value) + '</div>';
					
				} else { division += ''; }
								
			}
			
			return division;
			
		}
		
		function  nameTruncateLength(str, field) {
			var str_name = '',
				classes  = '',
				absolute = '';
			
			if(str.length > 1) {
				str_name = str.substr(0, 13);
				if(str_name.length !== str.length) {
					str_name += '...';
					classes	= 'class="tooltip-right" data-tooltip="' + str + '"';
				}
				
				//if(!help.in_array(field, ['PaymentChannel'])) absolute = 'position: absolute;';
				//else if(help.in_array(field, ['PAYMENT'])) absolute = 'position: relative;"';
				
				return '<span ' + classes + ' style="' + absolute + ' min-width: 105px; margin-top: 0px; margin-left: 0px;">' + str_name + '</span>';
				
			} else {
				return str;
			}
			
		}
		
	}
	
	function fnRunnoHandled(value, model, rowData) {
		var link_p2menu = '#';
		var anchor_blank = false;
		if(rowData.DOC_ID && rowData.DOC_ID != '') {
			anchor_blank = true;
			link_p2menu = 'http://tc001pcis1p:8099/pcis/index.php/management/getDataVerifiedPreview?_=1470225638188&rel=' + rowData.DOC_ID + '&req=P2&live=1&wrap=1470225638189';
		}
		
		var collateral	= 'http://tc001orms1p/CollateralAppraisal/Default.aspx';
		var create_date = (rowData.CREATE && rowData.CREATE !== '') ? moment(rowData.CREATE).format('DD/MM/YYYY (HH:mm)'):'ไม่พบข้อมูล';		
		
		var anchor_style = (anchor_blank) ? 'target="_blank"':'';
		if($scope.role_user == 'LB_ROLE' || help.in_array($scope.cilent_id, $scope.adminrole)) {
			return '<a href="' + link_p2menu + '" ' + anchor_style + ' style="color: #000;">' +
				   '<span class="tooltip-right" data-tooltip="' + create_date + '" style="position: absolute; margin-left: 12px;">' + model.rowId + '</span>' +
				   '</a>';
			
		} else if($scope.role_user == 'OPER_ROLE') {
			return '<a href="#" style="color: #000;"><span class="tooltip-right" data-tooltip="' + create_date + '" style="position: absolute; margin-left: 12px;">' + model.rowId + '</span></a>';
			
		} else {
			return model.rowId;
		}		
	}	
	
	// Grid Description
	var colname = [
	    { label: '<i class="fa fa-external-link th_icon marginTop35"></i>', name: 'CREATE', title: false, width: 40, frozen: true, sortable: true, align: 'center', formatter:'date', formatoptions: { newformat:'d/m/Y' }, formatter: fnRunnoHandled },
	    { label: '<i class="fa fa-laptop th_icon"></i>', name: 'APP_NO', title: false, width: 40, frozen: true, sortable: false, align: 'left', formatter: fnObjectHandled },
	    { label: '<span class="icon-copy th_icon"></span>', name: 'MISS_DOC', title: false, width: 40, frozen: true, sortable: false, align: 'left', formatter: fnMissingHandled },
	    { label: '<i class="fa fa-user th_icon"></i>', name: 'PEO_REF', title: false, width: 40, frozen: true, sortable: false, align: 'left', formatter: fnPersonHandled },
	    { label: '<i class="fa fa-hourglass-half th_icon"></i>', name: 'SCORE', title: false, width: 40, frozen: true, sortable: true, align: 'center' },
	  
	    { label: 'TYPE', name: 'CUST_TYPE', title: false,  width: 50, frozen: true, sortable: true, align: 'center', classes: 'paddingLeft_none'},
	    { label: 'NAME', name: 'CUST_NAME', title: false, frozen: true, sortable: false, formatter: fnFieldHeight },
  		
	    { label: 'LOAN', name: 'PRODUCT_TYPE',  align: 'center', title: false, width: 60, sortable: true, formatter: fnProductHandled },
	    { label: 'LB', name: 'LBNAME', title: false, width: 90, align: 'left', sortable: true, formatter: fnBranchHandled },
	    { label: 'RM', name: 'RM',  width: 95, title: false, align: 'left', sortable: true, formatter: fnTruncateName },
	    
	    { label: 'CR_LINE', name: 'CR_LINE', width: 85, title: false, align: 'right', sortable: true, sorttype:'int', formatter: "integer" },
	    { label: 'STATUS', name: 'APP_STATE', width: 80, title: false, classes: 'text-capitalize paddingLR_none', sortable: true, formatter: fnStatusHandled },
	    { label: 'ANALYST', name: 'ANALYST', width: 90, title: false, align: 'left', sortable: true, formatter: fnTruncateName },
	    
	    { label: '<i class="icon-copy fg-white"></i></span>', name: 'BANKBOOK', width: 40, title: false, sortable: false, formatter: fnFileBookbankState },
	    { label: 'STATUS', name: 'APPRAISAL_STATUS', width: 100, title: false, sortable: true, formatter: fnOperStateHandled },
	    { label: 'PLAN DD', name: 'PLAN_DRAWDOWN', width: 90, title: false, sortable: true, formatter:'date', formatoptions: { newformat:'d/m/Y' }, formatter: fnPlanDrawdownCommitState },
	    { label: 'REC_DOC', name: 'OPER_FLAG',  width: 90, title: false, align: 'center', classes: 'paddingLeft_none', sortable: true, formatter: fnReconcileOperDate },
	   
	    { label: '<i class="icon-copy fg-white"></i>', name: 'FILESTATUS', width: 40, title: false, classes: 'padding_none', sortable: false, formatter: fnDivisionLayer },
	    { label: 'STATUS', name: 'ASSET_STATE', width: 90, title: false, align: 'left', classes: 'padding_none', sortable: true, formatter: fnDivisionLayer },
	    { label: 'EST_DUEDATE', name: 'ASSET_DATE', width: 110, title: false, classes: 'padding_none', sortable: false, formatter: fnDivisionLayer },
  		
  		{ label: 'ตำบล', name: 'DISTRICT', width: 105, title: false, align: 'left', classes: 'padding_none', sortable: false, formatter: fnDivisionLayer },
  		{ label: 'อำเภอ', name: 'AMPHUR', width: 105, title: false, align: 'left', classes: 'padding_none', sortable: false, formatter: fnDivisionLayer },
  		{ label: 'จังหวัด', name: 'PROVINCE', width: 105, title: false, align: 'left', classes: 'padding_none', sortable: false, formatter: fnDivisionLayer },
  		{ label: 'สนง.ที่ดิน', name: 'DEP_LAND', width: 70, title: false, align: 'center', classes: 'padding_none', sortable: false, formatter: fnDivisionLayer },
  		
  		{ label: 'ผู้รับมอบ <br> จดจำนอง', name: 'WHO', width: 90, title: false, align: 'center', classes: 'padding_none', sortable: true, formatter: fnDivisionLayer },
  		{ label: 'RE <br> FIN.', name: 'REFINANCE', width: 40, title: false, align: 'center', classes: 'padding_none', sortable: true, formatter: fnDivisionLayer },
  		{ label: 'PAYMENT <br> TYPE', name: 'PAYMENT', width: 80, title: false, align: 'center', classes: 'padding_none', sortable: true, formatter: fnDivisionLayer },
  	
  		{ label: 'KYC', name: 'KYC', title: false, width: 50, align: 'center', sortable: true },	
  		{ label: 'CASHY', name: 'CASHY_AMT', title: false, width: 60, align: 'center', sortable: true },
  		{ label: 'ID CARD', name: 'ID_CARD', title: false, width: 120, sortable: true },
  	    { label: 'CREATE', name: 'CREATE', width: 90, title: false, sortable: true, formatter:'date', formatoptions: { newformat:'d/m/Y' }, hidden: true  },
  	];
	
	// Grid Group Header
	$scope.thead_group = [
	    { "numberOfColumns": 4, "titleText": "<i class=\"fa fa-exclamation-circle\"></i> IMPORTANT", "startColumnName": 'APP_NO' },
	    { "numberOfColumns": 2, "titleText": "CUSTOMER", "startColumnName": 'CUST_TYPE' },
	    { "numberOfColumns": 3, "titleText": "LB INFORMATION", "startColumnName": 'PRODUCT_TYPE' },
	    { "numberOfColumns": 3, "titleText": "CREDIT INFORMATION", "startColumnName": 'CR_LINE' },
	    { "numberOfColumns": 4, "titleText": "OPERATION INFORMATION", "startColumnName": 'BANKBOOK' },
	    { "numberOfColumns": 3, "titleText": "APPRAISAL INFORMATION", "startColumnName": 'FILESTATUS' },
	    { "numberOfColumns": 4, "titleText": "COLLATERAL LOCATION INFO", "startColumnName": 'DISTRICT' },
	    { "numberOfColumns": 3, "titleText": "GENERAL INFORMATION", "startColumnName": 'KYC' }
	];
	
	// Pagination
	$scope.paging_info = null;
	
	// Filter Config
	$scope.multipleConfig = { width: '100%', filter: true, minimumCountSelected: 2, single: false }
	$scope.filter = {
		customer: null,
		applicationno: null,
		isActive: 'A',	
		score: null,
		regional: null,
		branchList: null,
		employeeCode: null,
		loanType: null,
		decision: null,
		operdecision: null,
		flagrecieveFile: null,
		ownershipBuilding: null,
		inputDateType: null,
		inputDateRange: null,
		ddPlanVol: false,
		operAcknowledge: false,
		operOption: null,
		optional: null
	};
	
	$scope.$watch('filter.ddPlanVol', function(n, o) {
		if(n) {
			$('#masterdecisionOper, #masterscoreRank').multipleSelect('disable');
			$('#mslist_masterdecisionOper').parent().css('width', '128px');
			$('#mslist_masterscoreRank').parent().css('width', '55px');
		} else {
			$('#masterdecisionOper, #masterscoreRank').multipleSelect('enable');
			$('#mslist_masterdecisionOper').parent().css('width', '128px');
			$('#mslist_masterscoreRank').parent().css('width', '55px');
		}
	
	})
	$scope.$watch('filter.operAcknowledge', function(n, o) {
		if(n) {
			$('#masterdecisionOper').multipleSelect('disable');
			$('#mslist_masterdecisionOper').parent().css('width', '128px');
		} else {
			$('#masterdecisionOper').multipleSelect('enable');
			$('#mslist_masterdecisionOper').parent().css('width', '128px');
		}
	});
	
	$scope.$watch('userinfo', function(n) {
		if(n) {
			var _region = $filter('filter')($scope.masterdata.region, { RegionCode: n[0].RegionCode })[0]
			if(_region) {
				$scope.filter.regional.push(_region.RegionID)
			}
		}				
	}, true);
	
	
	// Grid Result Set
	$scope.reloadGrid = onLoadDataGrid;
	onLoadDataGrid();

	// Grid configulation
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
    	shrinkToFit: false,    
    	viewrecords: true,
    	height: height,
    	width: width, 
    	pager: '#grid_pager',
    	sortname: 'CREATE',
    	sortorder: 'desc',
    	rowNum: 20,
        rowList: [20, 50, 100, 200, 300, 500],
        footerrow: false,
        onSortCol: function(index, colIndex, sortOrder) {
        	if(index == 'CREATE' && sortOrder == 'asc') {
        		$(this).jqGrid('sortGrid', index, false, 'desc');
        		return 'stop'
        	}
        	
        	$scope.sortOrder = [index, colIndex, sortOrder];
        },
        modalDashboard: function (event) {
	        var data = $(event.currentTarget).data("rowData");
	        $scope.enabled_model(data);
	    },
	    modalMissingEnabled: function(doc_id) {
	    	$scope.missingEnabled_model(doc_id)
	    }, 
	    modalNoteInformation: function() {
	    	var data = $(event.currentTarget).data("rowData");
	    	$scope.OpenNotePreview(data);
	    },
	    fnOperConfirm: function(event) {
	    	var data = $(event.currentTarget).data("rowData");
	    	$scope.operationConfirmStatus(data)
	    }
    };
	
	function onLoadDataGrid() {
		
		var data_collection = [];
		$scope.RowNum		= null;
		$scope.dataList		= [];
		$scope.totalCRLINE  = 0;

		var CompletedPlan	= [];
		var PayConditional	= [];
		var SourceTypes  	= null;
		var KYC_Source		= null;
		var Cashy_Source	= null;
		
		var CAGetFolder		= [];
		var PayCommand		= [];
		var DDResponed		= [];
		
		if($scope.filter.operOption && $scope.filter.operOption.length > 0) {
					
			$.each($scope.filter.operOption, function(index, value) {
				if(help.in_array($scope.filter.operOption[index], ['ReceivedFolderFromCA', 'NotReceivedFolderFromCA'])) {
					if($scope.filter.operOption[index] == 'ReceivedFolderFromCA') CAGetFolder.push('Y');
					else CAGetFolder.push('N');
					
				} else if(help.in_array($scope.filter.operOption[index], ['Outsource', 'RM'])) {
					DDResponed.push($scope.filter.operOption[index]);
					
				} else if(help.in_array($scope.filter.operOption[index], ['ComfirmPaid', 'NotComfirmPaid'])) {
					if($scope.filter.operOption[index] == 'ComfirmPaid') PayCommand.push('Y');
					else PayCommand.push('N');
				}
				
			});
			
		}
		
		if($scope.filter.optional && $scope.filter.optional.length > 0) {
			
			$.each($scope.filter.optional, function(index, value) {
				if(help.in_array($scope.filter.optional[index], ['NA', 'Completed Admin', 'Incompleted'])) {
					if($scope.filter.optional[index] == 'NA') CompletedPlan.push('E');
					else if($scope.filter.optional[index] == 'Completed Admin') CompletedPlan.push('Y');
					else if($scope.filter.optional[index] == 'Incompleted') CompletedPlan.push('N');
					
				} else if(help.in_array($scope.filter.optional[index], ['Term Loan', 'Top Up', 'เบิกงวดงาน'])) {
					PayConditional.push($scope.filter.optional[index]);
					
				} else if(help.in_array($scope.filter.optional[index], ['Refer: Thai Life', 'KYC', 'Cashy'])) {
					if($scope.filter.optional[index] == 'KYC') KYC_Source = 'N';
					else if($scope.filter.optional[index] == 'Cashy') Cashy_Source = 'N';
					else SourceTypes = $scope.filter.optional[index];
				}
				
			});
			
		}	
		
		var product_types = null;
		if($scope.filter.loanType && $scope.filter.loanType.length > 0) {
			var isRight = [];
			$.each($scope.filter.loanType, function(index, value) {
				if(help.in_array(value, ['Refinance', 'Non Refinance'])) {
					isRight.push('TRUE');
				} else {
					isRight.push('FALSE');
				}
				
			});			
			
			if(help.in_array('TRUE', isRight)) {
				var item = ['Secure'];
				product_types = $scope.filter.loanType.concat(item);
			} else {
				product_types = $scope.filter.loanType;
			}
			
		}
	
		var startDate	= null, 
			endDate		= null;
		
		var objectDate	= setDateRangeHandled($scope.filter.inputDateRange);
		
			startDate	= (objectDate) ? objectDate[0]:null;
			endDate		= (objectDate) ? objectDate[1]:null;
		
		$param = {
			'OwnerEmpCode'	: $scope.cilent_id,
			'AppNo'		: $scope.filter.applicationno,
			'CustName'	: $scope.filter.customer,
			'IsActive'	: ($scope.filter.isActive) ? $scope.filter.isActive:null,
			'Score'		: ($scope.filter.score && $scope.filter.score.length > 0) ? $scope.filter.score:null,
			'RegionID'	: ($scope.filter.regional && $scope.filter.regional.length > 0) ? $scope.filter.regional:null,
			'BranchCode': ($scope.filter.branchList && $scope.filter.branchList.length > 0) ? $scope.filter.branchList:null,
			'RMCode'	: ($scope.filter.employeeCode && $scope.filter.employeeCode.length > 0) ? $scope.filter.employeeCode:null,
			'LoanType'	: (product_types && product_types.length > 0) ? product_types:null, 
			'Status'	: ($scope.filter.decision && $scope.filter.decision.length > 0) ? $scope.filter.decision:null,
			'AppraisalStatus'	: ($scope.filter.operdecision && $scope.filter.operdecision.length > 0) ? $scope.filter.operdecision:null,
			'OwnershipBuilding'	: ($scope.filter.ownershipBuilding) ? 'Y':null,
			'PlanType'			: (help.in_array($scope.filter.inputDateType, ['N', 'O', 'A'])) ? $scope.filter.inputDateType:null,
			'PlanDDFrom'		: (help.in_array($scope.filter.inputDateType, ['N', 'O', 'A'])) ? startDate:null,
			'PlanDDTo'			: (help.in_array($scope.filter.inputDateType, ['N', 'O', 'A'])) ?  endDate:null,
			'DecisionDateFROM'	: ($scope.filter.inputDateType == 'Decision Date' && objectDate) ? startDate:null,
			'DecisionDateTO'	: ($scope.filter.inputDateType == 'Decision Date' && objectDate) ? endDate:null,
			'OperDecisionDateFROM': ($scope.filter.inputDateType == 'Oper Date' && objectDate) ? startDate:null,
			'OperDecisionDateTO': ($scope.filter.inputDateType == 'Oper Date' && objectDate) ? endDate:null,
			'FlagDDPlan'  		: ($scope.filter.ddPlanVol) ? 'Y':null,
			'OPerActk'	  		: ($scope.filter.operAcknowledge) ? 'Y':null,
			'Complete'    		: (CompletedPlan && CompletedPlan.length > 0) ? CompletedPlan:null,
			'PaymentType' 		: (PayConditional && PayConditional.length > 0) ? PayConditional:null,
			'SourceOfCustomer'  : (SourceTypes) ? SourceTypes:null,
			'Cashy' : (Cashy_Source) ? Cashy_Source:null,
			'Kyc' 	: (KYC_Source) ? KYC_Source:null,
			'FlagRecieveFile' : (CAGetFolder && CAGetFolder.length > 0) ? CAGetFolder:null,
			'FlagComfPaid' 	  : (PayCommand && PayCommand.length > 0) ? PayCommand:null,
			'PaymentChannel'  : (DDResponed && DDResponed.length > 0) ? DDResponed:null
		};
		
		help.ddTemplate_read($param).then(function(resp) {
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
				    	PLAN_DD_WAITINGCONF: (value.WaitOperFlagConfirm) ? value.WaitOperFlagConfirm:'',
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
			$('.progress').hide();
			
		});

	}	
		
	$scope.exportFileReport = function() {
		if(confirm('กรุณายืนยันการดาวน์โหลดไฟล์ ใช่ หรือ ไม่ใช่')) {
			
			var CompletedPlan	= [];
			var PayConditional	= [];
			var SourceTypes  	= null;
			var KYC_Source		= null;
			var Cashy_Source	= null;
			
			var CAGetFolder		= [];
			var PayCommand		= [];
			var DDResponed		= [];
			
			if($scope.filter.operOption && $scope.filter.operOption.length > 0) {
						
				$.each($scope.filter.operOption, function(index, value) {
					if(help.in_array($scope.filter.operOption[index], ['ReceivedFolderFromCA', 'NotReceivedFolderFromCA'])) {
						if($scope.filter.operOption[index] == 'ReceivedFolderFromCA') CAGetFolder.push('Y');
						else CAGetFolder.push('N');
						
					} else if(help.in_array($scope.filter.operOption[index], ['Outsource', 'RM'])) {
						DDResponed.push($scope.filter.operOption[index]);
						
					} else if(help.in_array($scope.filter.operOption[index], ['ComfirmPaid', 'NotComfirmPaid'])) {
						if($scope.filter.operOption[index] == 'ComfirmPaid') PayCommand.push('Y');
						else PayCommand.push('N');
					}
					
				});
				
			}
			
			if($scope.filter.optional && $scope.filter.optional.length > 0) {
				
				$.each($scope.filter.optional, function(index, value) {
					if(help.in_array($scope.filter.optional[index], ['NA', 'Completed Admin', 'Incompleted'])) {
						if($scope.filter.optional[index] == 'NA') CompletedPlan.push('E');
						else if($scope.filter.optional[index] == 'Completed Admin') CompletedPlan.push('Y');
						else if($scope.filter.optional[index] == 'Incompleted') CompletedPlan.push('N');
						
					} else if(help.in_array($scope.filter.optional[index], ['Term Loan', 'Top Up', 'เบิกงวดงาน'])) {
						PayConditional.push($scope.filter.optional[index]);
						
					} else if(help.in_array($scope.filter.optional[index], ['Refer: Thai Life', 'KYC', 'Cashy'])) {
						if($scope.filter.optional[index] == 'KYC') KYC_Source = 'N';
						else if($scope.filter.optional[index] == 'Cashy') Cashy_Source = 'N';
						else SourceTypes = $scope.filter.optional[index];
					}
					
				});
				
			}	
			
			var product_types = null;
			if($scope.filter.loanType && $scope.filter.loanType.length > 0) {
				var isRight = [];
				$.each($scope.filter.loanType, function(index, value) {
					if(help.in_array(value, ['Refinance', 'Non Refinance'])) {
						isRight.push('TRUE');
					} else {
						isRight.push('FALSE');
					}
					
				});			
				
				if(help.in_array('TRUE', isRight)) {
					var item = ['Secure'];
					product_types = $scope.filter.loanType.concat(item);
				} else {
					product_types = $scope.filter.loanType;
				}
				
			}
			
			var startDate	= null, 
				endDate		= null;
			
			var objectDate	= setDateRangeHandled($scope.filter.inputDateRange);
			
				startDate	= (objectDate) ? objectDate[0]:null;
				endDate		= (objectDate) ? objectDate[1]:null;
		
			$param = {
				'OwnerEmpCode'	: $scope.cilent_id,
				'AppNo'		: $scope.filter.applicationno,
				'CustName'	: $scope.filter.customer,
				'IsActive'	: ($scope.filter.isActive) ? $scope.filter.isActive:null,
				'Score'		: ($scope.filter.score && $scope.filter.score.length > 0) ? $scope.filter.score:null,
				'RegionID'	: ($scope.filter.regional && $scope.filter.regional.length > 0) ? $scope.filter.regional:null,
				'BranchCode': ($scope.filter.branchList && $scope.filter.branchList.length > 0) ? $scope.filter.branchList:null,
				'RMCode'	: ($scope.filter.employeeCode && $scope.filter.employeeCode.length > 0) ? $scope.filter.employeeCode:null,
				'LoanType'	: (product_types && product_types.length > 0) ? product_types:null, 
				'Status'	: ($scope.filter.decision && $scope.filter.decision.length > 0) ? $scope.filter.decision:null,
				'AppraisalStatus'	: ($scope.filter.operdecision && $scope.filter.operdecision.length > 0) ? $scope.filter.operdecision:null,
				'OwnershipBuilding'	: ($scope.filter.ownershipBuilding) ? 'Y':null,
				'PlanType'			: (help.in_array($scope.filter.inputDateType, ['N', 'O', 'A'])) ? $scope.filter.inputDateType:null,
				'PlanDDFrom'		: (help.in_array($scope.filter.inputDateType, ['N', 'O', 'A'])) ? startDate:null,
				'PlanDDTo'			: (help.in_array($scope.filter.inputDateType, ['N', 'O', 'A'])) ?  endDate:null,
				'DecisionDateFROM'	: ($scope.filter.inputDateType == 'Decision Date' && objectDate) ? startDate:null,
				'DecisionDateTO'	: ($scope.filter.inputDateType == 'Decision Date' && objectDate) ? endDate:null,
				'OperDecisionDateFROM': ($scope.filter.inputDateType == 'Oper Date' && objectDate) ? startDate:null,
				'OperDecisionDateTO': ($scope.filter.inputDateType == 'Oper Date' && objectDate) ? endDate:null,
				'FlagDDPlan'  		: ($scope.filter.ddPlanVol) ? 'Y':null,
				'OPerActk'	  		: ($scope.filter.operAcknowledge) ? 'Y':null,
				'Complete'    		: (CompletedPlan && CompletedPlan.length > 0) ? CompletedPlan:null,
				'PaymentType' 		: (PayConditional && PayConditional.length > 0) ? PayConditional:null,
				'SourceOfCustomer'  : (SourceTypes) ? SourceTypes:null,
				'Cashy' : (Cashy_Source) ? Cashy_Source:null,
				'Kyc' 	: (KYC_Source) ? KYC_Source:null,
				'FlagRecieveFile' : (CAGetFolder && CAGetFolder.length > 0) ? CAGetFolder:null,
				'FlagComfPaid' 	  : (PayCommand && PayCommand.length > 0) ? PayCommand:null,
				'PaymentChannel'  : (DDResponed && DDResponed.length > 0) ? DDResponed:null
			};
			
            $http.post("http://172.17.9.94/newservices/LBServices.svc/report/ymca/excel", $param).then(function (resp) {
            	console.log(resp);
                var blob = new Blob([resp.data], { type: "application/vnd.ms-excel" });
                console.log(blob);

                var objectUrl = URL.createObjectURL(blob);
                window.open(objectUrl);

            }).then(function (error) { console.log(error); });
			
			return false;
			
		}
		
		return false;
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

	// Get Profile Information
	help.executeServices('GetKPI00ProfileReport', { RMCode: $scope.cilent_id }).then(function(responsed) {
		$scope.userinfo = responsed.data.Data
		var result = responsed.data.Data;		
        if (result.length > 0) {
         
           var peried   = (result[0].WorkingYMD) ? ' (Period ' + result[0].WorkingYMD + ')':'';
     	 
     	   var mobile	= result[0].Mobile + ' (' + result[0].Nickname + ')';
     	   var probation = (result[0].PassProbation) ? '(' + result[0].PassProbation + ')' :'';
     	   
     	   var corp		= result[0].BranchNameEng + peried + probation;
     	   
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

	// Master Loader
	$scope.masterdata = {};
	var success_api	  = false;
	var master_apis   = ['postponereason', 'paymentchannel', 'productloantype', 'paymenttype', 'mortgagechannel', 'bank', 'province', 
	                     'collateraltype', 'departmentoflands', 'region', 'area', 'banknominee'];
	var apino		  = master_apis.length - 1;
	$.each(master_apis, function(index, value) {
		help.onLoadListMaster(value).then(function(responsed) {

			if(value == 'departmentoflands') {
				$.map(responsed.data, function(item) {				
					var str = item.Location.replace(/\u21b5|\u200b/g,'');
					item.Location = str;
					return item;
				});
			}
			
			$scope.masterdata[value] = responsed.data;
			if(index === apino) $scope.fnMulipleList();
			
		});
	});
		
	$scope.masterdata['loan_cashy']  = [{ 'CashyLabel': 'โปรดระบุ', 'cashyValue': 0 }, { 'CashyLabel': '8,500', 'cashyValue': 8500 }, { 'CashyLabel': '16,000', 'cashyValue': 16000 }];
	$scope.masterdata['borrower']	 = [{ 'BorrowerName':'ผู้กู้หลัก', 'BorrowerType':'101' }, { 'BorrowerName':'ผู้กู้ร่วม', 'BorrowerType':'102' }, { 'BorrowerName':'อื่นๆ', 'BorrowerType':'104' }];
	$scope.masterdata['case_score']  = [{ 'Score':'A', 'Label':'(Approved Only)' }, { 'Score':'B', 'Label':'(CA รับเล่มประเมิน)' }, { 'Score':'C', 'Label':'(AIP)' }, { 'Score':'D', 'Label':'(Pending > 15D)' }, { 'Score':'E', 'Label':'(Pending < 15D)' }, { 'Score':'Z', 'Label':'ยังไม่ส่งประเมิน' }];
	$scope.masterdata['loan_type']	 = [{ 'LoanType':'Secure Loan', 'LoanName':'Refinance'}, { 'LoanType':'Secure Loan', 'LoanName':'Non Refinance'}, { 'LoanType':'Clean Loan', 'LoanName':'Clean'}];
	$scope.masterdata['decisionca']  = [{ 'DecisionName':'Pending' }, { 'DecisionName':'Approved' }, { 'DecisionName':'Cancel' }, { 'DecisionName':'Reject' }];
	$scope.masterdata['decisionop']  = [{ 'DecisionName':'Completed' },{ 'DecisionName':'Process' },{ 'DecisionName':'Re-Process' },{ 'DecisionName':'Postpone' },{ 'DecisionName':'Cancel' }];
	$scope.masterdata['oper_option'] = [
		{ 'GroupLabel':'สถานะการรับแฟ้ม', 'FieldName':'รับแฟ้มจาก CA', 'FieldValue':'ReceivedFolderFromCA' }, 
		{ 'GroupLabel':'สถานะการรับแฟ้ม', 'FieldName':'ไม่ได้รับแฟ้มจาก CA', 'FieldValue':'NotReceivedFolderFromCA' },
		{ 'GroupLabel':'สถานะการสั่งจ่าย', 'FieldName':'ยืนยันการสั่งจ่าย', 'FieldValue':'ComfirmPaid' },
		{ 'GroupLabel':'สถานะการสั่งจ่าย', 'FieldName':'ไม่ยืนยันการสั่งจ่าย', 'FieldValue':'NotComfirmPaid' },
		{ 'GroupLabel':'ผู้รับมอบจดจำนอง', 'FieldName':'Outsource', 'FieldValue':'Outsource' },
		{ 'GroupLabel':'ผู้รับมอบจดจำนอง', 'FieldName':'RM', 'FieldValue':'RM' }
	];
	
	$scope.masterdata['optional']	= [
		{ 'GroupLabel':'สำเร็จตามแผน', 'FieldName':'Branch not confirm', 'FieldValue':'NA' }, 
		{ 'GroupLabel':'สำเร็จตามแผน', 'FieldName':'Completed Admin', 'FieldValue':'Completed Admin' },
		{ 'GroupLabel':'สำเร็จตามแผน', 'FieldName':'Incompleted', 'FieldValue':'Incompleted' },
		{ 'GroupLabel':'เงื่อนไขการจ่ายเงิน', 'FieldName':'Term Loan', 'FieldValue':'Term Loan' },
		{ 'GroupLabel':'เงื่อนไขการจ่ายเงิน', 'FieldName':'Top Up', 'FieldValue':'Top Up' },
		{ 'GroupLabel':'เงื่อนไขการจ่ายเงิน', 'FieldName':'เบิกงวดงาน', 'FieldValue':'เบิกงวดงาน' },
		{ 'GroupLabel':'Other', 'FieldName':'Refer: Thai Life', 'FieldValue':'Refer: Thai Life' },
		{ 'GroupLabel':'Other', 'FieldName':'KYC (N)', 'FieldValue':'KYC' },
		{ 'GroupLabel':'Other', 'FieldName':'Cashy (N)', 'FieldValue':'Cashy' }
	];
	
	
	onLoadEmployeeList();
	onLoadBranchList();
	
	// Filter Criteria
	$scope.onRegionChange = function() {
		var param  = {}, emp_param = {};		
		if($scope.filter.regional && $scope.filter.regional.length > 0) {
			param = { 'RegionID': $scope.filter.regional };
			emp_param = { 'Regional': $scope.filter.regional };
			
			onLoadBranchList(param);
			onLoadEmployeeList(emp_param);
		}
	}
	
	$scope.onBranchChange = function() {
		var param  = {};
		if($scope.filter.branchList.length > 0) param = { 'Branch': $scope.filter.branchList };
		onLoadEmployeeList(param);
	}
	
	$scope.onInputFilterDateChange = function() {
		if($scope.filter.inputDateType == '') $scope.filter.inputDateRange = null;
	}
	
	function onLoadEmployeeList(objects) {
		 var param = (objects) ? objects:{};
		 	
		 param['Position'] = ['BM', 'RM']; 
		 help.executeservice('post', links + 'master/ddtemplate/employee', param).then(function(resp) { 
			 $scope.masterdata['employee'] = resp.data; 
		    	
		 });
		 
	}
   
	function onLoadBranchList(objects) {
		 var param = (objects) ? objects:{};
		 help.executeservice('post', links + 'master/ddtemplate/branch', param).then(function(resp) { 
			 $scope.masterdata['branch'] = resp.data; 
			 
		 });
	}

	// Data Inquiry
	$scope.filterSearch = function() { 
		$('.progress').show();
		onLoadDataGrid(); 
		
		//$scope.$watch('config.data', function(n, o) {
		//	if(n.length !== o.length) {
		$scope.sortOrder = null;
		var $this = $('#panel_parent');
		if(!$this.hasClass('panel-collapsed')) {
			$this.parents('.panel').find('.panel-body').slideUp();
			$this.addClass('panel-collapsed');
			$this.find('i').removeClass('fa fa-chevron-circle-up').addClass('fa fa-chevron-circle-down');
		}
		//	}			
		//});
	
	}
	
	$scope.filterClear = function() {
		$scope.sortOrder = null;
		$scope.filter.customer 		= null;
		$scope.filter.applicationno = null;
		$scope.filter.isActive 		= 'A';	
		$scope.filter.score 		= null;
		$scope.filter.regional 		= null;
		$scope.filter.branchList 	= null;
		$scope.filter.employeeCode  = null;
		$scope.filter.loanType	    = null;
		$scope.filter.decision			= null;
		$scope.filter.operdecision		= null;
		$scope.filter.flagrecieveFile	= null;
		$scope.filter.ownershipBuilding = null;
		$scope.filter.inputDateType		= null;
		$scope.filter.inputDateRange	= null;
		$scope.filter.ddPlanVol			= null;
		$scope.filter.operAcknowledge	= null;
		$scope.filter.operOption		= null;
		$scope.filter.optional			= null;
	}
	
	// Modal Component
	$scope.modalItemSelect = false;	
	$scope.enabled_model   = function(value) {
		
	    var modalInstance = $uibModal.open({
	        animation: true,
	        templateUrl: 'modalCollection.html',
	        controller: 'ModalInstanceCtrl',
	        size: 'lg',
	        windowClass: 'modal-fullscreen animated zoomIn',
	        resolve: {
	        	items: function () { return value; },
	    		dataList: function() { return $scope.dataList; },
	    		masterList: function() { return $scope.masterdata; },
	    		userInfo: function() { return $scope.userinfo; },
	    		tableInstant: function() { return $scope.config.id; },
	    		fnScope: function() { return $scope; }
	        }
	    });
   		
		modalInstance.result.then(function(selectedItem) {
			//onLoadDataGrid();
		}, 
		function() {
			if($scope.modalItemSelect) onLoadDataGrid();
		
		});
	
	}; 
	
	$scope.operationConfirmStatus = function(app_no) {
		if(app_no) {
			if(confirm('กรุณายืนยันการรับทราบการเปลี่ยนสถานะการจดจำนอง')) {	
				var application = (app_no) ? app_no.replace(/['"]+/g, ''):null;
				$object_bundled = {
					FlagConfirm: 'Y',
					UpdateByEmpCode: $scope.userinfo[0].EmployeeCode,
					UpdateByEmpName: $scope.userinfo[0].FullNameTh
				}
				
				help.UpdateAppraisalConfirm(application, $object_bundled)
				.then(function(responsed) {
					if(responsed.status === 200) {
						setNotify('รับทราบการเปลี่ยนแปลงสถานะ...', 'error');
						onLoadDataGrid();
					} else {
						setNotify('เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ (3634/3694/3519)');
					}
				});
				
				return true;
				
			}
		
			return false
			
		} else { setNotify('เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ (3634/3694/3519)'); }
	}
	
	$scope.missingEnabled_model = function(doc_id) {
		
		var modalInstance = $uibModal.open({
	        animation: true,
	        templateUrl: 'modalMissing.html',
	        controller: 'ModalInstanceMissingCtrl',
	        size: 'md',
	        windowClass: 'modal-fullscreen animated zoomIn',
	        resolve: {
	        	items: function () { return doc_id; }
	        }
	    });
		
	};
	
	$scope.OpenNotePreview = function(object_note) {

		var modalInstance = $uibModal.open({
	        animation: true,
	        templateUrl: 'modalNoteInfo.html',
	        controller: 'PreviewNoteInfomationCtrl',
	        size: 'md',
	        windowClass: 'modal-fullscreen animated zoomIn',
	        resolve: {
	        	items: function () { return object_note; }
	        }
	    });
		
	};
	
	$scope.modalPDFOwnerShipDocEnabled = function(appno) {
		
		var modalInstance = $uibModal.open({
	        animation: true,
	        templateUrl: 'modalDocument.html',
	        controller: 'ModalInstancePDFCtrl',
	        size: 'md',
	        windowClass: 'modal-fullscreen animated zoomIn',
	        resolve: {
	        	items: function () { return appno; }
	        }
	    });
		
	};
	
	// Panel Filter
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
	
	// Set Multi-List
	$scope.fnMulipleList = function() {
		var elements	  = $('select[list-bundle]'),
			select_mode   = elements.attr('list-bundle'),
			select_filter = elements.attr('list-filter'),
			select_minim  = elements.attr('list-minimum');
		
		$config = {
			width: '100%', 
			filter: (select_filter === undefined) ? true:select_filter,
			minimumCountSelected: 2
		}
		
		if(select_mode === 'multiple') {
			elements.change(function() { console.log($(this).val()) }).multipleSelect($config).multipleSelect('refresh');
		} else {
	
			$config['single'] = true ;
			elements.change(function() { console.log($(this).val()) }).multipleSelect($config).multipleSelect('refresh');
		}
	
	};
	
	// Notification
	function setNotify(notify_msg, notify_type = "error", notify_position = "center", width = 300) {
		
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
.controller('PreviewNoteInfomationCtrl', function($scope, $filter, help, $uibModalInstance, $q, items) {

	$scope.itemList		= [],
	$scope.config		= [];
	
	help.ddTemplate_read({ AppNo: items }).then(function(resp) { 
		var data = resp.data;	
		$scope.itemList		= (data) ? data[0].NoteData:null;
	});

	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss('cancel');
	};
	
})
.controller('ModalInstancePDFCtrl', function($scope, $filter, help, $uibModalInstance, $q, items) {

	$scope.itemList		= [],
	$scope.config		= [];
	
	help.GetPDFOwnerShipDoc(items).then(function(responsed) {
		$scope.itemList = responsed.data;
		$scope.config   = responsed.data.Documents;
	});
	
	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss('cancel');
	};
	
})
.controller('ModalRefernanceItemCtrl', function($scope, $filter, help, $uibModalInstance, $q, index, collateral) {
	$scope.RefItems	  = null;	
	$scope.ReferValid = false;
	$scope.hasError   = false;
	$scope.hasSuccess = false;
	
	$scope.responsedData  = [];
	$scope.onCheckReferenceNumber = function() {
	
		var isValid = [];
		if($scope.RefItems) {
			
			$scope.ReferValid = false;
			if(collateral.length > 0) {
				$.each(collateral, function(index, value) {
					
					if(value.RefNo) value.RefNo = value.RefNo.trim();
					if($scope.RefItems.trim() === value.RefNo) { isValid.push('FALSE'); } 
					else { isValid.push('TRUE'); }
					
				});
				
			} else { isValid.push('TRUE'); }
			
			if(!help.in_array('FALSE', isValid)) {
				$scope.ReferValid = false;
				var urls = links + 'ddtemplate/collateral/check/' + $scope.RefItems;
				help.executeservice('get', urls, {}).then(function(resp) { 
					 if(!resp.data[0]) {
						 $scope.hasError   = true;
						 $scope.hasSuccess = false;
					 } else {
						 $scope.responsedData = resp.data;
						 $scope.hasError   = false;
						 $scope.hasSuccess = true;
					 }
		
				});	
				
			} else { 
				setNotify('ขออภัย! เลขทีส่งงานมีอยู่แล้วในระบบ'); 
				$scope.ReferValid = true;
			}
			
			console.log(isValid);
			
		} else { 
			setNotify('กรุณาระบุเลขที่ส่งงานประเมิน');
			$scope.ReferValid = true;
		}
		
	}
	
	$scope.confirmReferenceceValidation = function() {
		if(confirm('กรุณายืนยันความถูกต้องของเลขที่ส่งงานประเมิน ' + $scope.responsedData[0].RefNo)) {
			console.log($scope.responsedData);
			$uibModalInstance.close({
				'status': 'Success',
				'ObjectNo': index,
				'resp': { data: $scope.responsedData }
			});
		}
		
		return false;
		
	}
	
	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss('cancel');
	};
	
	function setNotify(notify_msg, notify_type = "error", notify_position = "center", width = 300) {
		
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
	
})
.controller('ModalPostponeReasonItemListCtrl', function($scope, $filter, help, $uibModalInstance, $q, appno, masterList, dataState, fnScope) {
	$scope.fieldLockOn		= false;
	$scope.fieldPlanNewDate	= null;
	$scope.postponeUnknown  = null;
	$scope.checkboxItemList	= { items: [] };
	$scope.postponeOther	= [];
	$scope.postponeOtherTmp	= [];
	$scope.masterdata		= masterList;
	$scope.avaliablePOfield = false;
	
	$scope.jqDateConfig = { 
		dateFormat: "dd/mm/yy",
		minDate: new Date(),
		maxDate: new Date(new Date().getFullYear() + 1, 11, 31),
		beforeShowDay: disabled
	};
	
	$scope.$watch('postponeUnknown', function(n) {
		if(n) {
			if(n == 'Y') {
				$scope.fieldPlanNewDate	= null;
				$scope.fieldLockOn = true;
			} else {
				$scope.fieldLockOn = false
			}
		}
		
	}, true);
	
	$scope.checkPostponeField = function() {
		var cloneObj = angular.copy($scope.postponeOther);

		$scope.$watch('checkboxItemList', function(n) {
			if(n) {
				if(help.in_array('PO999', n.items)) {
					$scope.avaliablePOfield = true;		

					if(!help.in_array('PO999', $scope.postponeOtherTmp)) {
						$scope.postponeOtherTmp.push('PO999');
						$scope.postponeOther.push({
							itemCode: 'PO999',
							itemNote: null
						});							
					}
					
					
				} else {
					$scope.avaliablePOfield = false;						
					if(!help.in_array('PO999', $scope.postponeOtherTmp)) {
						$scope.postponeOther.splice(0, 1);
						$scope.postponeOtherTmp.splice(0, 1);
					}
					
				}
			}		
		});
	}

	var result_status = checkDrawDownDateChange(dataState[0], dataState[1], dataState[2]);
	$scope.jqDateConfig.minDate = (result_status[0] < new Date()) ? new Date():result_status[0];
	$scope.jqDateConfig.maxDate = (result_status[1] < new Date()) ? new Date(new Date().getFullYear() + 1, 11, 31):result_status[1];
	
	$scope.confimItemList = function() {

		if(confirm('กรุณายืนยันการเลือกรายการ')) {
			
			var isValid 	= [];
			var reasonValid = [];

			if(!$scope.checkboxItemList.items[0]) {
				setNotify('กรุณาระบุเหตุผลในการเลือน Drawdown');
				isValid.push('FALSE');	
			} else { isValid.push('TRUE'); }
			
			if(!$scope.fieldPlanNewDate) {
				
				if($scope.postponeUnknown == 'Y') {
					reasonValid.push('TRUE');
				} else {
					reasonValid.push('FALSE');
				}
				
				if($scope.checkboxItemList.items.length >= 1) {
					if($scope.postponeUnknown == 'Y') { $scope.checkboxItemList.items.push('PO002'); }
					else {
						$.each($scope.checkboxItemList.items, function(index, value) {
							if(help.in_array($scope.checkboxItemList.items[index], ['PO002'])) {
								fnRemove($scope.checkboxItemList.items, 'PO002');
							}							
						});
					}
				}

				if(help.in_array('TRUE', reasonValid)) { isValid.push('TRUE'); } 
				else {
					setNotify('กรุณาระบุวันที่วางแผน Drawdown ใหม่');
					isValid.push('FALSE');
				}
				
			} else { if($scope.fieldPlanNewDate) isValid.push('TRUE'); }
			
			var other_reason = [];
			if($scope.postponeOther && $scope.postponeOther.length >= 1) {		
				$.each($scope.postponeOther, function(index, value) {
					if(value.itemNote && value.itemNote !== '') {
						other_reason.push(value.itemNote);
					}				
				});			
			}
				
			if(!help.in_array('FALSE', isValid)) {

				var fieldNewPlanDate  = help.in_array('TRUE', reasonValid) ? null:$scope.fieldPlanNewDate;
				var isComfirmPostpone = true;

				$uibModalInstance.close({
					'Status': 'Success',
					'Process': null,
					'DataItem': $scope.checkboxItemList.items,
					'PlanDD': fieldNewPlanDate,
					'PostponeDesc': ($scope.avaliablePOfield) ? other_reason:null,
					'isComfirmPostpone': isComfirmPostpone
				});
				
			}
			
			return true;
			
		}
		
		return false;
	}
	
	$scope.addOtherReason = function() {		
		var cloneObj = angular.copy($scope.postponeOther);
		$scope.postponeOther.push({
			itemCode: 'PO999',
			itemNote: null
		});		
	};
	
	$scope.removeOtherReason = function(index){
		if(confirm('กรุณายืนยันการลบข้อมูล')) {
			$scope.postponeOther.splice(index, 1);
			return true;
		}
		
		return false
		
	};
		
	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss('cancel');
	};
	
	function disabled(data) {
		if(data.getDay() == 6 || data.getDay() == 0)
			return [false, ''];
		else
			return [true, ''];
	}
	
	function checkDrawDownDateChange(status, ddDate, role) {
        var cDate = new Date(ddDate);

        var lastDateofMonth = new Date(cDate.getFullYear(), cDate.getMonth() + 1, 0);
        var lastDayofMonth = lastDateofMonth.getDate();
    	
        if (status == "Postpone") {

            var dayInMonth = [];
            var minDate, maxDate;

            for (var i = 1; i <= lastDayofMonth; i++) {
                var d = new Date(cDate.getFullYear(), cDate.getMonth(), i);
                if (d.getDay() < 6 && d.getDay() > 0) {
                    dayInMonth.push(d.getDate());
                }
            }

            minDate = dayInMonth[dayInMonth.length - 5];
            maxDate = dayInMonth[dayInMonth.length - 1];
    	
            console.log(fnScope.allow_change);
            if(fnScope.allow_change) { 
            	return [new Date(), lastDateofMonth];
            	
            } else {
            	if (role == 'OPER_ROLE' || help.in_array(fnScope.userinfo[0].EmployeeCode, fnScope.adminrole)) {
                    return [new Date(), lastDateofMonth];
                } else {
                    return [cDate, lastDateofMonth];
                }
            }
            
            
        }
        else {
        	var nextDayOfMonth = $('#lastDayOfMonth').val();
        	var DayConditional = (nextDayOfMonth) ? new Date(nextDayOfMonth):new Date();
            return [DayConditional, null];
        }
    }
	
	function setNotify(notify_msg, notify_type = "error", notify_position = "center", width = 300) {
		
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
	
	function fnRemove(arr, item) {
	      for(var i = arr.length; i--;) {
	          if(arr[i] === item) {
	              arr.splice(i, 1);
	          }
	      }
	}

})
.controller('ModalInstanceCtrl', function($scope, $filter,$timeout, help, $uibModal, $uibModalInstance, $q, $compile, items, dataList, masterList, userInfo, tableInstant, fnScope) {

	$scope.label_field = 1;
	$scope.label_zone  = 7;
	$scope.label_bg    = ['bg-teal', 'bg-steel', 'bg-darkMagenta', 'bg-crimson', 'bg-amber', 'bg-lightBlue', 'bg-cyan', 'bg-thinTeal'];
	$scope.font_color  = 'fg-white';

	$scope.DataList    = [],
	$scope.Collateral  = [],
	$scope.NoteList	   = [];
	$scope.Partners	   = [];
	$scope.logged 	   = {};
		
    $scope.selectOptions = { width: '100%', filter: true, minimumCountSelected: 2, single: true };
    
	$scope.renderDataReport = function(appno) {
		var url = links + 'ddtemplate/' + appno + '/paymentreport';
		if(appno) window.open(url);
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
  
	function onLoadDataModal(appno) {	
		
		help.ddTemplate_read({ AppNo:appno }).then(function(resp) { 
			var data = resp.data;	
			
			$scope.DataList 	 = data[0]; 
			$scope.Collateral	 = data[0].CollateralData
			$scope.NoteList		 = data[0].NoteData;
			$scope.Partners		 = data[0].PartnersData;
		
			$scope.FileBookBank  	= [];
			$scope.FileBookBankNew	= false;
			$scope.ContactFileItem  = [];
			
			if($scope.DataList.DiscountFee) {
				$scope.DataList.DiscountFee = 1;
			} else {
				$scope.DataList.DiscountFee = 0;
			}
			
			if($scope.DataList.DiscountInterest) {
				$scope.DataList.DiscountInterest = 1;
			} else {
				$scope.DataList.DiscountInterest = 0;
			}
		
			if($scope.DataList  && !_.isEmpty($scope.DataList )) {
				if(parseFloat($scope.DataList .BorrowerAmount) == 0.00 && parseFloat($scope.DataList.ApprovedLoan) > 0.00) {
					$scope.DataList .BorrowerAmount = $scope.DataList .ApprovedLoan;
				}
			}
						
			$scope.DataList.validation = { 
				'BorrowerName': false,
				'BorrowerBank': false,
				'BorrowerAmt' : false,
				'BorrowerPay' : false,
				'CashyAmount' : false,
				'BookbankFile': false,
				'TotalNetAmt' : false
			};
			
			$.each($scope.Collateral, function(index, value) { 
				value.isNew = false,
				value.UpdateByEmpCode   = userInfo[0].EmployeeCode,
				value.UpdateByEmpName   = userInfo[0].FullNameTh,
				value.Amount2 = (value.Amount2 == '') ? null:value.Amount2,
				value.Amount3 = (value.Amount3 == '') ? null:value.Amount3,
				value.Amount4 = (value.Amount4 == '') ? null:value.Amount4,
				value.Amount5 = (value.Amount5 == '') ? null:value.Amount5,
				value.Validation = { 
					'RefNumber': false,
					'BankRefin': false,
					'OtherName': false,
					'Bank'	   : false, 
					'Refinance': false,
					'Bank2'	   : false,
					'Amount2'  : false,
					'Bank3'	   : false,
					'Amount3'  : false
				},
				value.bankcategory = {
					null: [''], 
					'Draft': [
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KTB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "TBANK"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BAY"}, true)[0]
					],
					'Cheque': $filter('filter')(fnScope.masterdata.bank,{Bank_Digit: "TCRB"}, true),
					'Baht Net': fnScope.masterdata.bank,
					'Direct Credit': [
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KBANK"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BBL"}, true)[0]
					]
				},
				value.CampaignData = (value.CampaignData) ? value.CampaignData:[]
				value.CompaignList = ($scope.DataList.MaximumCampaignData) ? $.extend(true, [], $scope.DataList.MaximumCampaignData):[]
				
			});
			
			// Compaign Prepare
			$.each($scope.Collateral, function(index, value) { 
				if(value.CampaignData[0] !== undefined) {	
					$.each(value.CampaignData, function(n, v) {
						if(v.CampaignCode && value.CompaignList[0]) {
							if(v.CampaignCode === value.CompaignList[0].CampaignCode) {
								if(value.CompaignList[0] !== undefined) { removeByAttr(value.CompaignList, 'CampaignCode', v.CampaignCode);}	
							}
						}						
					});
					
				}
				
			});
						
			$.each($scope.Partners, function(index, value) { 
				value.isNew = false
				value.Validation = {
					'PartnerName': false,
					'PartnerPayType': false,
					'partnerBank': false,
					'partnerAmount': false
				},
				value.bankcategory = {
					null: [''], 
					'Draft': [
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KTB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "TBANK"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BAY"}, true)[0]
					],
					'Cheque': $filter('filter')(fnScope.masterdata.bank,{Bank_Digit: "TCRB"}, true),
					'Baht Net': fnScope.masterdata.bank,
					'Direct Credit': [
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KBANK"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BBL"}, true)[0]
					]
				}
	
			});
			
			$('.panel-body').addClass('animated fadeIn').removeClass('hide');
			
			// Check Panel Empty for closed automatic
			panelCollapseEnable('third_person_parent', $scope.Partners);
			panelCollapseEnable('note_parent', $scope.NoteList);
			panelCollapseEnable('security_parent', $scope.Collateral);
			panelCollapseEnable('third_person_edit_parent', $scope.Partners);
			panelCollapseEnable('note_edit_parent', $scope.NoteList);
			panelCollapseEnable('security_edit_parent', $scope.Collateral);
			
			setTimeout(function() {
				var collection_items = 1;
				var collection_array = [];
				var collection_list  = $('.collater_division').length;
				for(var i = 0; i < collection_list; i++) { 
					var collection_itemHeight = $('.collectionitem_preview_' + collection_items).height();
					collection_array.push(collection_itemHeight);
					collection_items++; 
				} 
				
				if(collection_array.length > 0) {
					var max_height = arrayMax(collection_array);
					$('.collectionitem_parent').css('min-height', max_height + 'px');
				}
							
			}, 4000);
			
			function arrayMax(array) { return array.reduce(function(a, b) { return Math.max(a, b); }); }
		
		});
	}	
	// Loader
	onLoadDataModal(items);

    $scope.fileBookBankChange = function (scope) {
    	
    	scope.FileBookBank.isUpLoading = true;

    	$timeout(function(){
        	var reader = new FileReader();    
        	var file   = $scope.FileBookBank.filePDFInput[0];

        	if(file) {
        		
        		if(file.type !== 'application/pdf') {
            		scope.FileBookBank.isUpLoading  = false;
            		setNotify('ขออภัย! File upload ต้องเป็นนามสกุล .pdf เท่านั้น');
            
            	} else {
            		
            		$scope.$watch('FileBookBank.isUpLoading', function(n, o) {
                		if(n !== o) setNotify('File Upload Successfully', 'success');    		
                	});
     
        	        var BookbankFile = {
                		FileName : file.name,
                		Size : file.size,
                		Type : file.name.replace(/^.*\./, ''),
                		ByteFile : null,
                		IsFileDelete : false,
                		OriginPath: URL.createObjectURL(file)
                	}
        	  
        	        reader.onload = function () {
        	        	BookbankFile.ByteFile = reader.result.split("base64,")[1];
        	        	scope.FileBookBank.BookbankFile = BookbankFile;
        	        	scope.DataList.BookBankStatus   = 'W';
        	        	scope.FileBookBank.isUpLoading  = false;
        	        	
        	        	$scope.FileBookBankNew = true;
        		    	$scope.DataList.validation.BookbankFile = false;
        		    	
        		    	console.log($scope);
        	        };
        	        
        	        reader.readAsDataURL(file);
            	}
        		
        	} else {
        		scope.DataList.BookBankStatus = '';
        		scope.FileBookBank.isUpLoading  = false;
        	}	
       	
    	});
    
        
    };

    $scope.fileContactChange = function (scope) {
    
    	scope.ContactFileItem.isUpLoading = true;

    	$timeout(function(){
        	var reader = new FileReader();    
        	var file = $scope.ContactFileItem.filePDFInput[0];
        	
        	if(file) {
        		
        		if(file.type !== 'application/pdf') {
            		scope.ContactFileItem.isUpLoading  = false;
            		setNotify('ขออภัย! File upload ต้องเป็นนามสกุล .pdf เท่านั้น');

            	} else {
            		
            		$scope.$watch('ContactFileItem.isUpLoading', function(n, o) {
                		if(n !== o) setNotify('File Upload Successfully', 'success');    		
                	});

        	        var ContactFile = {
                		FileName : file.name,
                		Size : file.size,
                		Type : file.name.replace(/^.*\./, ''),
                		ByteFile : null,
                		IsFileDelete : false,
                		OriginPath: URL.createObjectURL(file)
                	}
        	  
        	        reader.onload = function () {
        	        	ContactFile.ByteFile = reader.result.split("base64,")[1];
        	        	scope.ContactFileItem.ContactFiles   = ContactFile;
        	        	scope.ContactFileItem.FileStatus     = 'C';
        	        	scope.ContactFileItem.isUpLoading 	 = false;
        	        };
        	        
        	        reader.readAsDataURL(file);
            	}
        		
        	} else {
        		scope.ContactFileItem.FileStatus= '';
        		scope.ContactFileItem.isUpLoading  = false;
        	}

    	});
        
    };
        
    $scope.filePartnerChange = function (scope) {
    	console.log(scope.$index);
    	$scope.Partners[scope.$index].isUpLoading = true;
    	$timeout(function() {
        	var reader = new FileReader();    
        	var file   = $scope.Partners[scope.$index].objFileInput[0];
        	
        	if(file) {
        		
        		if(file.type !== 'application/pdf') {
            		$scope.Partners[scope.$index].isUpLoading  = false;
            		setNotify('ขออภัย! File upload ต้องเป็นนามสกุล .pdf เท่านั้น');
       
            	} else {
            		
            		$scope.$watch('Partners[' + scope.$index + '].isUpLoading', function(n, o) {
                		if(n !== o) setNotify('File Upload Successfully', 'success');    		
                	});

        	        var PartnersFile = {
                		FileName : file.name,
                		Size : file.size,
                		Type : file.name.replace(/^.*\./, ''),
                		ByteFile : null,
                		IsFileDelete : false,
                		OriginPath: URL.createObjectURL(file)
                	}

        	        reader.onload = function () {
        	        	PartnersFile.ByteFile = reader.result.split("base64,")[1];
        	        	$scope.Partners[scope.$index].BookBankFile = PartnersFile;
        	        	$scope.Partners[scope.$index].PatchStatus  = 'W';
        	        	$scope.Partners[scope.$index].isUpLoading = false;
        	        };
        	        
        	        reader.readAsDataURL(file);
        	        
            	}
        		
        	} else {
        		$scope.Partners[scope.$index].PatchStatus  = '';
        		$scope.Partners[scope.$index].isUpLoading  = false;
        	}

    	});
  
    };

    $scope.fileChange = function (scope) {

    	$scope.Collateral[scope.$index].isUpLoading = true;

    	$timeout(function() {
        	var reader = new FileReader();    
        	var file = $scope.Collateral[scope.$index].objFileInput[0];
        	
        	if(file) {
        		
        		if(file.type !== 'application/pdf') {
            		$scope.Collateral[scope.$index].isUpLoading  = false;
            		setNotify('ขออภัย! File upload ต้องเป็นนามสกุล .pdf เท่านั้น');
       
            	} else {
            		
            		$scope.$watch('Collateral[' + scope.$index + '].isUpLoading', function(n, o) {
                		if(n !== o) setNotify('File Upload Successfully', 'success');    		
                	});

        	        var CollateralFile = {
                		FileName : file.name,
                		Size : file.size,
                		Type : file.name.replace(/^.*\./, ''),
                		ByteFile : null,
                		IsFileDelete : false,
                		OriginPath: URL.createObjectURL(file)
                	}

        	        reader.onload = function () {
        	        	CollateralFile.ByteFile = reader.result.split("base64,")[1];
        	        	$scope.Collateral[scope.$index].CollateralFile = CollateralFile;
        	        	$scope.Collateral[scope.$index].FileStatus  = 'W';
        	        	$scope.Collateral[scope.$index].isUpLoading = false;
        	        };
        	        
        	        reader.readAsDataURL(file);
        	        
            	}
        		
        	} else {
        		scope.Collateral.FileStatus = '';
        		$scope.Collateral[scope.$index].isUpLoading  = false;
        	}

    	});

    };
    
    $scope.setSingleDropdown = function() {
    	$('select[list-bundle-single]')
    	.change(function() { $(this).val() })
    	.multipleSelect({ width: '100%', filter: true, minimumCountSelected: 2, single: true }).multipleSelect('refresh');
    }
    
    $scope.FileBookbankStatus  = function(responsed, status, file_temp) {
    	if(file_temp.BookbankFile) {
    		if(file_temp.BookbankFile) return 'Yes';
    		else return 'No';
    	} else {
    		if(responsed) return 'Yes';
    		else return 'No';
    	}
    }
    
    $scope.FileContactStatus  = function(responsed, file_upload, mode = 'E') {
    	if(file_upload) {
    		if(file_upload == 'C') return (mode == 'E') ? 'Yes':'Completed';
    		else return (mode == 'E') ? 'No':'No';
    	} else {
    		if(responsed) return (mode == 'E') ? 'Yes':'Completed';
    		else return (mode == 'E') ? 'No':'No';
    	}
    }
    
    $scope.setFilePartnerState = function(upload_state, file_detail, file_temp) {
    	if(help.in_array(upload_state, ['C', 'I', 'W']) && file_detail || file_temp) return 'Yes';
		else return 'No';
    }
    
    $scope.setFileDefaultState = function(upload_state, file_detail, file_temp) {
    	if(help.in_array(upload_state, ['C', 'I', 'W']) && file_detail || file_temp) return 'Yes';
		else return 'No';
    }
    
    $scope.getFileStatus = function(upload_state) {
    	if(upload_state == 'W') return 'Check';
    	else if(upload_state == 'C') return 'Completed';
		else if(upload_state == 'I') return 'Incompleted';
		else return '';
    }
    
    $scope.setCaseStatusText = function(status) {
    	if(status == 'Y') return 'Completed (Admin)';
    	//else if(status == 'P') return 'Confirm Paid (System)';
		else if(status == 'N') return 'Incompleted (System)';
		else return '';
    }
    
	$scope.datetime = function(value){
		if(value === null) return '';                                                                      
		else return $filter("date")(new Date(value),"dd/MM/yyyy (HH:mm)");
	};
	
	$scope.setDataChoice = function(OwnerShipBuilding) {
		if(OwnerShipBuilding  === '') { return 'No'; } 
		else {
			if(OwnerShipBuilding == 'Y') return 'Yes';
				else if(OwnerShipBuilding == 'N') return 'No';
					else return 'No';
		}
	}
	
	$scope.setPayTypeName = function(str_text) {
		if(str_text) {
			switch(str_text) {
				case 'Draft':
					return 'D';
					break;
				case 'Cheque':
					return 'C';
					break;
				case 'Transfer':
					return 'T';
					break;
				case 'Baht Net':
					return 'BN';
					break;
				case 'Direct Credit':
					return 'DC'
					break;
				default: 
					return str_text;
					break;
			}
		}
	}
	
	$scope.setAmountOfValue = function(paytype) {
		console.log(paytype);
	}
	
	// Variable Master
	$scope.masterdata   = masterList;
	
	// Role
	$scope.cilent_id	= fnScope.cilent_id;
	$scope.role_user	= fnScope.role_user;
	$scope.role_auth	= fnScope.role_field;
	$scope.role_handled = fnScope.role_handled;
	$scope.adminrole	= fnScope.adminrole;

	console.log($scope);
	console.log($scope.masterdata);	
	
	// Modal Configulation
	var isUpdate = false;
	$scope.dismiss_modal = function () {
		if(isUpdate)
			$uibModalInstance.close();
		else
			$uibModalInstance.dismiss('cancel');
	};
	
	$scope.isLoadComplete = false;
	$scope.isEdit = false;
	$scope.modalEditMode = function() {
		$scope.isLoadComplete= true;
		$scope.isEdit = !$scope.isEdit;
		
		var collection_items = 1;
		var collection_array = [];
		var collection_list  = $('.collater_division').length;
		for(var i = 0; i < collection_list; i++) { 
			var collection_itemHeight = $('.collateral_item_' + collection_items).height();
			collection_array.push(collection_itemHeight);
			collection_items++; 
		} 
		
		if(collection_array.length > 0) {
			var max_height = arrayMax(collection_array);
			$('.collater_division').css('min-height', max_height + 'px');
		}

		function arrayMax(array) { return array.reduce(function(a, b) { return Math.max(a, b); }); }
		
	}
	
	$scope.isBinding = false;
	$scope.collateralBinding = function() {
		$scope.isBinding = !$scope.isBinding;
	}
	
	$scope.modalMissingEnabledValid = function(doc_id, miss_amt) {
		fnScope.missingEnabled_model(doc_id);
	}
	
	$scope.modalOwnershipFileEnabled = function(appno, isUse) {
		if(isUse == 'Y') fnScope.modalPDFOwnerShipDocEnabled(appno);
	}
	
	/** Data Set **/
	$scope.oldValue = "";
	$scope.reciveFileFromCA = function(item){
		if($scope.DataList.FlagRecieveFile == 'Y') {
		
			var date = moment().format('YYYY-MM-DD HH:mm:ss');
			var sDate = $filter("date")(date, "dd/MM/yyyy HH:mm:ss");
			
			$scope.oldValue = item._RecieveFileDateTime;
			item._RecieveFileDateTime = sDate;
			
		} else { item._RecieveFileDateTime = $scope.oldValue; }
		
	};
	
	$scope.AppraisalStatusDraft  = null;
	$scope.$watch("DataList.AppraisalStatus", function(n, o) {
		$scope.AppraisalStatusDraft = (o) ? o:n;
		
	});
	
	$scope.cashyHandled = function() {
		if($scope.DataList.Cashy == 'N') $scope.DataList.CashyAmt = '0';
	}

	$scope.$watch("DataList._PlanDrawdownDate", function(n, o) {
		$scope.PlanDrawdownDraft	= (o) ? o:n;
	});
	
	if(help.in_array(moment().format('DD'), fnScope.rangeDayAllow)) {
		if(!help.in_array(fnScope.cilent_id, fnScope.adminrole)) {
			$scope.$watch('DataList.AppraisalStatus', function(n) {
				/*
				if(n && n == 'Cancel') {
					$scope.role_handled = {
						'elements': {
							'collateral_btn': true,
							'customer_btn'	: true,
							'noteinfo_btn'	: true,
							'partners_btn'	: true
						}
					}
				} else 
				*/
				
				if(n && n == 'Re-Process') {
					$scope.role_handled = {
						'elements': {
							'collateral_btn': false,
							'customer_btn'	: false,
							'noteinfo_btn'	: false,
							'partners_btn'	: false
						}
					}
				}
				
			});
		}
	}

	$scope.setTotalNetAmt = function() {
		if($scope.DataList.PaymentType == 'Term Loan') {
			$scope.DataList.TotalNetAmt  = $scope.DataList.ApprovedLoan;
		} else if(in_array($scope.DataList.PaymentType, ['Top up', 'เบิกงวดงาน'])) {
			$scope.DataList.TotalNetAmt	 = 0;
		}
	}
	
	$scope.setpaymentch = function(list, role, option) {
		if($scope.DataList.ProductType == 'Clean') {
			if(help.in_array(list, ['Draft'])) return true;
			else  return false;
			
		} 
	}
	
	$scope.appendCollateral = function() {

		if($scope.Collateral.length <= 0) {
			$scope.Collateral.push({
				ApplicationNo: $scope.DataList.ApplicationNo,
				AgencyMortgage: null,
				Amphur: null,
				Amount2: null,
				Amount3: null,
				Amount4: null,
				Amount5: null,
				Amphur: null,
				AppointmentReceiveDate: null,
				ApproveValue: null,
				ApprovedDateTime: null,
				AssetStatus: null,
				Bank: null,
				Bank2: null,
				Bank3: null,
				Bank4: null,
				Bank5: null,
				CollateralFileDetail: null,
				CollateralStatus: null,
				CollateralType: null,
				FileStatus: null,
				PatchFile: null,
				PayType: null,
				PayType2: null,
				PayType3: null,
				PayType4: null,
				PayType5: null,
				PaymentChannel: "Outsource",
				Province: null,
				ReceiveDocumentDateTime: null,
				RefNo: null,
				Refinance: null,
				SysNo: null,
				Tambol: null,
				IsActive: 'A',	
				IsVisible: 'A',
				OwnershipBuilding: null,
				UpdateByEmpCode: userInfo[0].EmployeeCode,
				UpdateByEmpName: userInfo[0].FullNameTh,
				_AppointmentReceiveDate: null,
				_ApprovedDateTime: null,
				_ReceiveDocumentDateTime: null,
				isNew: true,
				Validation: { 
						'RefNumber': false,
						'BankRefin': false,
						'OtherName': false,
						'Bank'	   : false, 
						'Refinance': false,
						'Bank2'	   : false,
						'Amount2'  : false,
						'Bank3'	   : false,
						'Amount3'  : false
				},
				bankcategory: {
					null: [''], 
					'Draft': [
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KTB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "TBANK"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BAY"}, true)[0]
					],
					'Cheque': $filter('filter')(fnScope.masterdata.bank,{Bank_Digit: "TCRB"}, true),
					'Baht Net': fnScope.masterdata.bank,
					'Direct Credit': [
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KBANK"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BBL"}, true)[0]
					]
				},
				CampaignData: [],
				CompaignList: $scope.DataList.MaximumCampaignData
			});
			
		} else {
			
			var cloneObj = angular.copy($scope.Collateral[0]);
			
			for (var prop in cloneObj) { cloneObj[prop] = null; }
			
			cloneObj.isNew = true;
			cloneObj.OwnershipBuilding 	= null;
			cloneObj.IsActive			= 'A';
			cloneObj.IsVisible			= 'A';
			cloneObj.PaymentChannel		= 'Outsource';
			cloneObj.ApplicationNo 		= $scope.Collateral[0].ApplicationNo;
			cloneObj.UpdateByEmpCode	= userInfo[0].EmployeeCode;
			cloneObj.UpdateByEmpName	= userInfo[0].FullNameTh;
			cloneObj.Validation 	    = { 
				'RefNumber': false,
				'BankRefin': false,
				'OtherName': false,
				'Bank'	   : false, 
				'Refinance': false,
				'Bank2'	   : false,
				'Amount2'  : false,
				'Bank3'	   : false,
				'Amount3'  : false
			},
			cloneObj.bankcategory		= {
				null: [''], 
				'Draft': [
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KTB"}, true)[0],
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "TBANK"}, true)[0],
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BAY"}, true)[0]
				],
				'Cheque': $filter('filter')(fnScope.masterdata.bank,{Bank_Digit: "TCRB"}, true),
				'Baht Net': fnScope.masterdata.bank,
				'Direct Credit': [
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KBANK"}, true)[0],
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BBL"}, true)[0]
				]
			},
			cloneObj.CampaignData = (cloneObj.CampaignData) ? cloneObj.CampaignData:[],
			cloneObj.CompaignList = $scope.DataList.MaximumCampaignData
			
			$scope.Collateral.push(cloneObj);
			
		}
	
	}
	
	$scope.appendPartners= function() {
		
		if($scope.Partners.length <= 0) {
			$scope.Partners.push({
				ApplicationNo: $scope.DataList.ApplicationNo,
				DocID: $scope.DataList.DocID,
				SysNO: null,
		        OnbehalfType: null,
		        PayeeName: null,
		        PayType: null,
		        Bank: null,
		        PayAmount: null,
		        PatchFile: null,
		        PatchFlag: null,
		        PatchStatus: null,
		        BookBankFile: null,
		        _UpdateDate: null,
		        IsActive: 'A',
				UpdateByEmpCode: userInfo[0].EmployeeCode,
				UpdateByEmpName: userInfo[0].FullNameTh,
				BookBankNo: null,
				isNew: true,
				Validation: {
					'PartnerName'	: false,
					'PartnerPayType': false,
					'partnerBank'	: false,
					'partnerAmount' : false
				},
				bankcategory: {
					null: [''], 
					'Draft': [
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KTB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "TBANK"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BAY"}, true)[0]
					],
					'Cheque': $filter('filter')(fnScope.masterdata.bank,{Bank_Digit: "TCRB"}, true),
					'Baht Net': fnScope.masterdata.bank,
					'Direct Credit': [
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KBANK"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
					     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BBL"}, true)[0]
					]
				}
			});
			
		} else {
		
			var cloneObj = angular.copy($scope.Partners[0]);
			
			for (var prop in cloneObj) { cloneObj[prop] = null; }

			cloneObj.ApplicationNo 		= $scope.Partners[0].ApplicationNo;
			cloneObj.UpdateByEmpCode	= userInfo[0].EmployeeCode;
			cloneObj.UpdateByEmpName	= userInfo[0].FullNameTh;
			cloneObj.IsActive			= 'A';
			cloneObj.isNew 				= true;
			cloneObj.Validation 	    = {
					'PartnerName'	: false,
					'PartnerPayType': false,
					'partnerBank'	: false,
					'partnerAmount' : false
			}
			
			cloneObj.bankcategory		= {
				null: [''], 
				'Draft': [
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KTB"}, true)[0],
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "TBANK"}, true)[0],
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BAY"}, true)[0]
				],
				'Cheque': $filter('filter')(fnScope.masterdata.bank,{Bank_Digit: "TCRB"}, true),
				'Baht Net': fnScope.masterdata.bank,
				'Direct Credit': [
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "KBANK"}, true)[0],
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "SCB"}, true)[0],
				     $filter('filter')(fnScope.masterdata.bank, { Bank_Digit: "BBL"}, true)[0]
				]
			}
					
			$scope.Partners.push(cloneObj);
			
		}
		
		console.log($scope.Partners);
		
	}
	
	$scope.addTableRecord = function() {
		var cloneObj = angular.copy($scope.NoteList);
				
		$scope.NoteList.push({
			ApplicationNo: $scope.DataList.ApplicationNo,
			Note: null,
			UpdateByEmpCode: userInfo[0].EmployeeCode,
			UpdateByEmpName: userInfo[0].FullNameTh,
			UpdateDate: moment().format('YYYY-MM-DD HH:mm:ss'),
			IsNew : true
		});
		
	}
	
	$scope.addCompaignList = function(item, compaign_code) {
		item.CampaignData.push({
			ApplicationNo: $scope.DataList.ApplicationNo,
			RefNo : item.RefNo,
			CampaignCode: compaign_code,
			PayType: null,
			Bank: null,
			Amount: null,
			TotalFinanceAmt: null
		});
		
		removeByAttr(item.CompaignList, 'CampaignCode', compaign_code);
		
	}
	
	$scope.jqDateConfig = { 
		dateFormat: "dd/mm/yy", 
		minDate: new Date(),
		maxDate: new Date(new Date().getFullYear() + 1, 11, 31),
		beforeShowDay: disabled
	};
	
	$scope.multiselect_config = {
		width: '100%', 
		filter: false,
		minimumCountSelected: 2
	};
	
	// Postpone Or Cancel Handled	
	$scope.postponeReset	= false;
	$scope.postponeReState	= null;
	$scope.postponeItemList = [];
	$scope.postponeOther	= [];
	$scope.postponeHandled  = function(value, oldStatus) {
	
		if(help.in_array(value, ['Postpone', 'Re-Process'])) {
			
			$('.postpone_area').removeClass('hide').addClass('animated fadeInDown');
			$('select[list-bundle]').change(function() { console.log($(this).val()) }).multipleSelect($scope.multiselect_config).multipleSelect('refresh');
			
			var result_status = checkDrawDownDateChange(value, $scope.DataList._PlanDrawdownDate, $scope.role_user);
			$scope.jqDateConfig.minDate = new Date(result_status[0]);
			$scope.jqDateConfig.maxDate = (result_status[1] <= new Date()) ? new Date(new Date().getFullYear() + 1, 11, 31):result_status[1];
		
		} else if(value == 'Cancel') {

			var modalInstance = $uibModal.open({
		        animation: true,
		        templateUrl: 'ModalPostponeReasonItemList.html',
		        controller: 'ModalPostponeReasonItemListCtrl',
		        size: 'md',
		        backdrop: 'static',
		        keyboard: false,
		        windowClass: 'modal-fullscreen animated zoomIn',
		        resolve: {
		        	appno: function () { return items; },
					masterList: function() { return $scope.masterdata; },
		        	dataState: function() { return [value, $scope.DataList._PlanDrawdownDate, $scope.role_user]; },
		        	fnScope: function() { return fnScope; }
		        }
		    });
									
			modalInstance.result.then(
				function(selectItem) {
					$scope.postponeItemList = selectItem.DataItem;
					$scope.DataList._PlanDrawdownDate = selectItem.PlanDD;
					$scope.postponeOther = selectItem.PostponeDesc;
					$scope.isConfirmPostpone = selectItem.isComfirmPostpone;
					$('.postpone_area').addClass('hide');
				}, 
				function(status) {
					$scope.DataList.AppraisalStatus = oldStatus;
					$('.postpone_area').addClass('hide');
				}
			);
						
		} else {
			$('.postpone_area').addClass('hide');
		}
	}
	
	$scope.resetPostponeHandled = function() {
		if(confirm('กรุณายืนยันการ reset เพื่อเลือน Drawdown ภ่ายในเดือน')) {
			if(help.in_array($scope.DataList.AppraisalStatus, ['Postpone'])) {
				
				$('.postpone_area').removeClass('hide').addClass('animated fadeInDown');
				$('select[list-bundle]').change(function() { console.log($(this).val()) }).multipleSelect($scope.multiselect_config).multipleSelect('refresh');
				
				$scope.postponeReset	 = true;
				$scope.postponeReState	 = 'Postpone';
				
			}
		}
	}
	
	$scope.checkRefNumberValidation = function(indexs) {
		
		var modalInstance = $uibModal.open({
	        animation: true,
	        templateUrl: 'modalReferanceValidation.html',
	        controller: 'ModalRefernanceItemCtrl',
	        size: 'sm',
	        backdrop: 'static',
	        keyboard: false,
	        windowClass: 'modal-fullscreen animated zoomIn',
	        resolve: {
	        	index: function () { return indexs; },
				collateral: function() { return $scope.Collateral; }
	        }
	    });
		
		modalInstance.result.then(
			function(selectItem) {
				var dataItem = selectItem.resp.data;
				console.log(selectItem.resp.data);
				$scope.Collateral[selectItem.ObjectNo].RefNo 		  = dataItem[0].RefNo;
				$scope.Collateral[selectItem.ObjectNo].CollateralType = dataItem[0].CollateralType;
				$scope.Collateral[selectItem.ObjectNo].AssetStatus 	  = dataItem[0].Status;
				$scope.Collateral[selectItem.ObjectNo].ApproveValue   = dataItem[0].ApproveValue;
				$scope.Collateral[selectItem.ObjectNo].Province 	  = dataItem[0].Province;
				$scope.Collateral[selectItem.ObjectNo].Amphur 		  = dataItem[0].Amphur;
				$scope.Collateral[selectItem.ObjectNo].Tambol 		  = dataItem[0].Tambol;
				
				$scope.Collateral[selectItem.ObjectNo].AppointmentReceiveDate   = dataItem[0]._AppointmentReceiveDate;
				$scope.Collateral[selectItem.ObjectNo].ReceiveDocumentDateTime  = dataItem[0]._ReceiveDocumentDateTime;
	
			}, 
			function() {
				
			}
		);
	}
	
	// Function

	function disabled(data) {
		if(data.getDay() == 6 || data.getDay() == 0)
			return [false, ''];
		else
			return [true, ''];
	}
	

	
	function checkDrawDownDateChange(status, ddDate, role) {
        var cDate = new Date(ddDate);

        var lastDateofMonth = new Date(cDate.getFullYear(), cDate.getMonth() + 1, 0);
        var lastDayofMonth = lastDateofMonth.getDate();
    
        if (status == "Postpone") {

            var dayInMonth = [];
            var minDate, maxDate;

            for (var i = 1; i <= lastDayofMonth; i++) {
                var d = new Date(cDate.getFullYear(), cDate.getMonth(), i);
                if (d.getDay() < 6 && d.getDay() > 0) {
                    dayInMonth.push(d.getDate());
                }
            }

            minDate = dayInMonth[dayInMonth.length - 5];
            maxDate = dayInMonth[dayInMonth.length - 1];

            console.log(fnScope.allow_change);
            if(fnScope.allow_change) {            	
            	return [new Date(), lastDateofMonth];
            	
            } else {
            	
            	if(role == "OPER_ROLE" || help.in_array($scope.cilent_id, $scope.adminrole)) {
                    return [new Date(), lastDateofMonth];
                } else {
                    return [cDate, lastDateofMonth];
                }
            	
            }
        
        }
        else {
            return [new Date(), null];
        }
    }
	
	$scope.isConfirmPostpone = false;
	$scope.postponeOK = function() {
		var onAccept = [];
		var obj_postpone = $('#objpostpone_reason').val();
			
		if($scope.DataList.AppraisalStatus == 'Cancel' && !obj_postpone) {
			setNotify('กรุณาระบุเหตุผลในการเลือน Drawdown');
			onAccept.push('FALSE');	
		} else { onAccept.push('TRUE');	}
		
		if(!$scope.dateSelect) {
			
			var reasonValid = [];
			if(obj_postpone && obj_postpone.length >= 0) {
				$.each(obj_postpone, function(index, value) {
					if(help.in_array(obj_postpone[index], ['เลื่อนไม่มีกำหนด'])) reasonValid.push('TRUE');
					else reasonValid.push('FALSE');
				});
				
			} 
			
			if(help.in_array('TRUE', reasonValid)) { onAccept.push('TRUE'); }
			else {
				setNotify('กรุณาระบุวันที่วางแผน Drawdown ใหม่');
				onAccept.push('FALSE');
			}
	
		}
		
		if(!help.in_array('FALSE', onAccept)) {
			$scope.DataList._PlanDrawdownDate = $scope.dateSelect;
			$('.postpone_area').addClass('hide');
			
			$scope.isConfirmPostpone = true;
			
		}
		
	}
	
	var appraisal_Status;
	$scope.$watch('DataList.AppraisalStatus', function(newValue, oldValue) { appraisal_Status = oldValue; });
	$scope.postponeDismiss = function() {
		$scope.dateSelect = null;
		if($scope.postponeReset) $scope.DataList.AppraisalStatus = $scope.postponeReState;
		else $scope.DataList.AppraisalStatus = appraisal_Status;
		
		if(appraisal_Status && !appraisal_Status) $scope.postponeReState = null;
		
		$('.postpone_area').addClass('hide');

	}
	
	$scope.openLinkContactFile = function(responsed, new_uploads) {
		console.log(responsed, new_uploads);
		if(new_uploads.ContactFiles || responsed) {
			if(new_uploads.ContactFiles) window.open(new_uploads.ContactFiles.OriginPath, '_blank');
			else window.open(responsed.FilePath, '_blank');
		}
	}
	
	$scope.openLinkBookbankFile = function(responsed, new_uploads) {
		if(new_uploads.BookbankFile || responsed) {
			if(new_uploads.BookbankFile) window.open(new_uploads.BookbankFile.OriginPath, '_blank');
			else window.open(responsed.FilePath, '_blank');
		}
	}
	
	$scope.openLinkPartnerFile = function(responsed, new_uploads) {
		if(new_uploads || responsed) {
			if(new_uploads) window.open(new_uploads.OriginPath, '_blank');
			else window.open(responsed.FilePath, '_blank');
		}
	}
	
	$scope.openLinkPdfFile = function(item) {
		if(item.CollateralFileDetail || item.CollateralFile) {
			if(item.CollateralFileDetail) window.open(item.CollateralFileDetail.FilePath, '_blank');
			else window.open(item.CollateralFile.OriginPath, '_blank');	
		}
	}
	
	$scope.removeCollaterItem = function(item, index) {
		if(item.SysNo) {
			
			if(confirm('กรุณายืนยันการลบข้อมูล')) {
				help.CollateralDelete(item.ApplicationNo, item.SysNo).then(function() {
					setNotify('Delete Successfully.', 'success');
					$scope.Collateral.splice(index, 1);
				});
	
			} 
		
		} else { $scope.Collateral.splice(index, 1); }
	
	};
	
	$scope.removePartnersListItem = function(item, index) {
		if(item.SysNO) {
			if(confirm('กรุณายืนยันการลบข้อมูล')) {
				help.partnersDelete(item.ApplicationNo, item.SysNO).then(function() {
					setNotify('Delete Successfully.', 'success');
					$scope.Partners.splice(index, 1);
				});
	
			} 
		
		} else { $scope.Partners.splice(index, 1); }
	
	};
	
	$scope.truncateText = function(str) {
		if(str && str !== '' && str.length >= 30) {
			var textSplit = str.substr(0, 29);
			return '<span class="tooltip-top paddingLR_none" data-tooltip="' + str + '">' + textSplit + '...</span>';
		} else {
			return str;
		}
	}
	
	$scope.removeNoteItem = function(index){
		$scope.NoteList.splice(index, 1);
	};
	
	$scope.removeCampaignItem = function(item, root, hint){
		console.log(item, root, hint);	
		var campaign = {
			ApplicationNo: item.ApplicationNo,
			CampaignCode: item.CampaignCode,
			TotalFinanceAmt: 0
		};
		
		$scope.Collateral[root].CompaignList.push(campaign);
		$scope.Collateral[root].CampaignData.splice(hint, 1)
		  
	}
	
	$scope.setFieldReadOnly = function(state) {
		if(!state) return 'readonly';
		else return '';
	}
	
	$scope.fieldComleteLock = function(planDate) {
		if((moment().format('YYYY-MM-DD')) >= (moment(planDate).format('YYYY-MM-DD')))
			return false;
		else
			return true;	
	};
	
	$scope.setFieldBorrowerName = function() {
		if($scope.DataList.BorrowerType == '101') {
			$scope.DataList.BorrowerName = $scope.DataList.CustName;
		} else {
			if($scope.DataList.BorrowerType == '') $scope.DataList.BorrowerType = '';			
			$scope.DataList.BorrowerName = '';
		}
	}
	
	/** Function: Data Bundled **/
	// General Information
	$scope.setCustInformation = function() {
				
		if(confirm('กรุณายืนยันการบันทึกข้อมูล (Information Only)')) {
			
			var isSave = [];
			if($scope.role_user == 'LB_ROLE') {
				
				if(!$scope.DataList.CustType || $scope.DataList.CustType.trim().length == 0) {		
					setNotify('กรุณาระบุประเภทลูกค้า "ลูกค้าเก่า" หรือ "ลูกค้าใหม่"');
					isSave.push('FALSE');		
					
				} else { isSave.push('TRUE'); }
				
				if(!$scope.DataList.KYC || $scope.DataList.KYC == 'N') {
					$scope.DataList.validation.CashyAmount = true;
					setNotify('กรุณาระบุ KYC');
					isSave.push('FALSE');	
					
				} else {
					isSave.push('TRUE');
				}

				if($scope.DataList.Cashy == 'Y' && $scope.DataList.CashyAmt <= 0) {
					$scope.DataList.validation.CashyAmount = true;
					setNotify('กรุณาระบุวงเงินของ Cashy');
					isSave.push('FALSE');	
					
				} else {
					isSave.push('TRUE');	
					$scope.DataList.validation.CashyAmount = false;
				}
				
				if($scope.DataList.BorrowerType && !$scope.DataList.BorrowerName) {
					$scope.DataList.validation.BorrowerName = true;
					setNotify('กรุณาระบุชื่อผู้กู้หรือข้อมูลที่จะสั่งจ่าย');
					isSave.push('FALSE');	
					
				} else {
					isSave.push('TRUE');	
					$scope.DataList.validation.BorrowerName = false;
				}
				
				if($scope.DataList.BorrowerName && $scope.DataList.BorrowerName !== '' && !$scope.DataList.BorrowerPayType) {
					$scope.DataList.validation.BorrowerPay = true;
					setNotify('กรุณาระบุวิธีการชำระ');
					isSave.push('FALSE');
				} else {
					$scope.DataList.validation.BorrowerPay = false;
					isSave.push('TRUE');
				}
				
				if($scope.DataList.BorrowerPayType && !$scope.DataList.BorrowerBank) {
					$scope.DataList.validation.BorrowerBank = true;
					setNotify('กรุณาระบุข้อมูลแบงค์ที่จะสั่งจ่าย');
					isSave.push('FALSE');	
					
				} else {
					isSave.push('TRUE');	
					$scope.DataList.validation.BorrowerBank = false;
				}
				
				if($scope.DataList.Complete == 'Y' && $scope.DataList.TotalNetAmt <= 0) {
					$scope.DataList.validation.TotalNetAmt = true;
					setNotify('กรุณาระบุวงเงินที่ลูกค้ารับจริง');
					isSave.push('FALSE');		
				} else { 
					isSave.push('TRUE');
					$scope.DataList.validation.TotalNetAmt = false;
				}
	
				/*
				if(in_array($scope.DataList.PaymentType, ['Top up', 'เบิกงวดงาน']) && !$scope.DataList.TotalNetAmt) {		
					setNotify('กรุณาระบุวงเงินที่ลูกค้ารับจริง');
					isSave.push('FALSE');			
					
				} else { isSave.push('TRUE'); }
				
				if($scope.DataList.PaymentType && $scope.DataList.TotalNetAmt <= 0) {
					setNotify('กรุณาตรวจสอบวงเงินที่ลูกค้ารับจริง');
					isSave.push('FALSE');	
				} else { isSave.push('TRUE'); }
				
				if($scope.DataList.BorrowerPayType && $scope.DataList.BorrowerBank && $scope.DataList.BorrowerAmount <= 0) {
					$scope.DataList.validation.BorrowerAmt = true;
					setNotify('กรุณาระบุวงเงินที่จะสั่งจ่าย');
					isSave.push('FALSE');	
					
				} else {
					isSave.push('TRUE');	
					$scope.DataList.validation.BorrowerAmt = false;
				}
							
				if($scope.DataList.BookBankFlag == 'Y' && $scope.FileBookBankNew == false) {
					$scope.DataList.validation.BookbankFile = true;
					setNotify('กรุณาอัพโหลดไฟล์ Book bank');
					isSave.push('FALSE');	
					
				} else {
					isSave.push('TRUE');	
					$scope.DataList.validation.BookbankFile = false;
				}
				*/
				
			} else { isSave.push('TRUE'); }
	
			if(!in_array('FALSE', isSave)) {
				
				var appraisal_status = null;
				var obj_postpone 	 = $('#objpostpone_reason').val();
				
				if($scope.postponeReset) {
					appraisal_status = 'N';
				} else {
					if($scope.AppraisalStatusDraft !== $scope.DataList.AppraisalStatus && $scope.PlanDrawdownDraft !== $scope.DataList._PlanDrawdownDate) {
						appraisal_status = 'N';
					}	
				}
				
				$object_bundled  = {
					ApplicationNo: ($scope.DataList.ApplicationNo !== '') ? $scope.DataList.ApplicationNo:null,
					CustType: ($scope.DataList.CustType !== '') ? $scope.DataList.CustType:null,
					PaymentType: ($scope.DataList.PaymentType !== '') ? $scope.DataList.PaymentType:null,
					Cashy: ($scope.DataList.Cashy !== '') ? $scope.DataList.Cashy:null,
					CashyAmt: ($scope.DataList.CashyAmt !== '') ? $scope.DataList.CashyAmt:0,
					KYC: ($scope.DataList.KYC) ? $scope.DataList.KYC:null,
					TotalNetAmt: ($scope.DataList.TotalNetAmt > 0) ? parseFloat($scope.DataList.TotalNetAmt):null,
					Postpone: ($scope.postponeItemList[0] !== undefined) ? $scope.postponeItemList:'',
					PostponeDesc: ($scope.postponeOther && $scope.postponeOther.length > 0) ? $scope.postponeOther:null,
					PlanDrawDownDate: ($scope.DataList._PlanDrawdownDate !== '' && $scope.DataList._PlanDrawdownDate) ? moment($scope.DataList._PlanDrawdownDate).format('YYYY-MM-DD'):null,
					Complete: ($scope.DataList.Complete !== '') ? $scope.DataList.Complete:null,
					AppraisalStatus: ($scope.DataList.AppraisalStatus !== '') ? $scope.DataList.AppraisalStatus:null,
					FlagRecieveFile: ($scope.DataList.FlagRecieveFile !== '') ? $scope.DataList.FlagRecieveFile:null,
					FlagConfirm: appraisal_status,
					BookBankNo: ($scope.DataList.BookBankNo !== '') ? $scope.DataList.BookBankNo:'',
					BorrowerType: ($scope.DataList.BorrowerType !== '') ? $scope.DataList.BorrowerType:'',
					BorrowerName: ($scope.DataList.BorrowerName !== '') ? $scope.DataList.BorrowerName:'',
					BorrowerPayType:($scope.DataList.BorrowerPayType !== '') ? $scope.DataList.BorrowerPayType:'',
					BorrowerBank: ($scope.DataList.BorrowerBank !== '') ? $scope.DataList.BorrowerBank:'',
					BorrowerAmount: ($scope.DataList.BorrowerAmount !== '') ? $scope.DataList.BorrowerAmount:0,
					BookBankFlag: ($scope.DataList.BookBankFlag) ? $scope.DataList.BookBankFlag:null,
					BookBankStatus: ($scope.DataList.BookBankStatus !== '') ? $scope.DataList.BookBankStatus:null,
					BookBankFile: $scope.FileBookBank.BookbankFile,
					ContactFile: $scope.ContactFileItem.ContactFiles,
					DiscountFee: ($scope.DataList.DiscountFee && $scope.DataList.DiscountFee > 0) ? parseInt($scope.DataList.DiscountFee):null,
					DiscountInterest: ($scope.DataList.DiscountInterest && $scope.DataList.DiscountInterest > 0) ? parseInt($scope.DataList.DiscountInterest):null,
					UpdateByEmpCode: (userInfo[0].EmployeeCode !== '') ? userInfo[0].EmployeeCode:null,
					UpdateByEmpName: (userInfo[0].FullNameTh !== '') ? userInfo[0].FullNameTh:null
				}; 
		
				help.UpdateCustInformation($scope.DataList.ApplicationNo, $object_bundled)
				.then(function(responsed) {
					fnScope.modalItemSelect = true;
					if(responsed.status === 200) {
						setNotify('<span class="fa fa-check fg-green marginLeftEasing20" style="font-size: 1.7em;"></span> Information: Saved Successfully', 'success');
					} else {
						setNotify('<span class="fa fa-exclamation-circle fg-white marginLeftEasing20" style="font-size: 1.7em;"></span> เกิดข้อผิพลาดในการอัพเดทข้อมูล กรุณาลองใหม่อีกครั้ง', 'error', 'right', 380);
					}
					
				});
				
			} 
		
		}
		
	}
	
	// Collateral Information
	$scope.setCollateralInformation = function() {
		
		if(confirm('กรุณายืนยันการบันทึกข้อมูล (Collateral Only)')) {

			var func = [];	
			var update_valid = [];
			var insert_valid = [];
						
			var param_update = $filter("filter")($scope.Collateral, { isNew: false });
			var param_insert = $filter("filter")($scope.Collateral, { isNew: true });
			
			var Campagin = [];
			var maximun_compaign = $scope.DataList.MaximumCampaignData;
			
			//console.log(param_update);			
			if(param_insert.length <= 0 && param_update.length <= 0) { setNotify('ขออภัย!! รุณาสร้างข้อมูลก่อนบันทึกข้อมูล...'); } 
			else {
								
				if(maximun_compaign.length > 0) {
					$.each(maximun_compaign, function(index, value) {
						Campagin.push({  
							CampaignCode: value.CampaignCode,
							CampaignAmount: 0
						});
					});
				}

				var Detail 	 = [];
				if(param_update.length > 0) {
					$.each(param_update, function(index, value) {
		
						// Check Status of collateral
						if(!value.RefNo && value.IsVisible == 'A') {
							value.Validation.RefNumber = true; 
							update_valid.push('FALSE'); 
							setNotify('กรุณาระบุข้อมูลหมายเลขส่งงาน');
							Detail.push({'Field':'RefNumber'});
							
						} else {
							value.Validation.RefNumber = false; 
							update_valid.push('TRUE'); 
						}
						
						if(value.CollateralStatus == 'Other' && !value.OrtherNote && value.IsVisible == 'A') {
							value.Validation.OtherName = true; 
							update_valid.push('FALSE'); 
							setNotify('กรุณาระบุข้อมูลเพิ่มเติมที่เกี่ยวข้อง');
							Detail.push({'Field':'Other'});
							
						} else {
							value.Validation.OtherName = false; 
							update_valid.push('TRUE'); 
						}
							
						if(value.CampaignData && value.IsVisible == 'A') {
							$.each(value.CampaignData, function(n, v) {
								var getIndex = objectFindByKey(Campagin, 'CampaignCode', v.CampaignCode);
								getIndex.CampaignAmount = getIndex.CampaignAmount + (v.Amount > 0) ? parseFloat(v.Amount):0;
							});
							
						}
												
					});
					
				}
			
				if(param_insert.length > 0) {
					$.each(param_insert, function(index, value) {
						
						if(!value.RefNo && value.IsVisible == 'A') {
							value.Validation.RefNumber = true; 
							update_valid.push('FALSE'); 
							setNotify('กรุณาระบุข้อมูลหมายเลขส่งงาน');
							Detail.push({'Field':'RefNumber'});
							
						} else {
							value.Validation.RefNumber = false; 
							update_valid.push('TRUE'); 
						}
						
						if(value.CollateralStatus == 'Other' && !value.OrtherNote && value.IsVisible == 'A') {
							value.Validation.OtherName = true; 
							update_valid.push('FALSE'); 
							setNotify('กรุณาระบุข้อมูลเพิ่มเติมที่เกี่ยวข้อง');
							Detail.push({'Field':'Other'});
							
						} else {
							value.Validation.OtherName = false; 
							update_valid.push('TRUE'); 
						}

					});
				}
				
				if(Campagin.length > 0 && maximun_compaign.length > 0) {
					$.each(Campagin, function(index, value) {
						var getIndex = objectFindByKey(maximun_compaign, 'CampaignCode', value.CampaignCode)
						if(value.CampaignAmount > getIndex.TotalFinanceAmt) {
							update_valid.push('FALSE'); 
							Detail.push({'Field':'Campaign'});
							setNotify('กรุณาตรวจสอบข้อมูล Campaign เนื่องจากวงเงินเกินกว่าที่ตั้งไว้ (วงเงินที่ตั้งไว้คือ ' + help.formattedNumber(getIndex.TotalFinanceAmt, 2) + ')',  'error', 'center', 700);
						} else {
							update_valid.push('TRUE'); 
						}
						console.log(value.CampaignAmount, getIndex.TotalFinanceAmt);
					});	
				
				}
						
				if($scope.isBinding) $scope.isBinding = false;

				//console.log(Detail);
				console.log([param_update, param_insert]);
		
				if(!help.in_array('FALSE', update_valid)) {
					
					if(param_insert.length > 0) {
		                var deffered = $q.defer();
		     
		                $.each(param_insert, function(index, value) { 
		    				value.Amount2 = (value.Amount2 == '') ? 0.00:value.Amount2,
		    				value.Amount3 = (value.Amount3 == '') ? 0.00:value.Amount3,
		    				value.Amount4 = (value.Amount4 == '') ? 0.00:value.Amount4,
		    				value.Amount5 = (value.Amount5 == '') ? 0.00:value.Amount5
		    			});
		                
		                help.CollateralInsert($scope.DataList.ApplicationNo, param_insert)
		                .then(function () { deffered.resolve(); })
		                .then(function () { deffered.reject(); });

		                func.push(deffered);
		                
					}
					
					if(param_update.length > 0) {
		                var deffered = $q.defer();
		                
		                $.each(param_update, function(index, value) { 
		    				value.Amount2 = (value.Amount2 == '') ? 0.00:value.Amount2,
		    				value.Amount3 = (value.Amount3 == '') ? 0.00:value.Amount3,
		    				value.Amount4 = (value.Amount4 == '') ? 0.00:value.Amount4,
		    				value.Amount5 = (value.Amount5 == '') ? 0.00:value.Amount5
		    			});
		                              
		                help.CollateralUpdate($scope.DataList.ApplicationNo, param_update)
		                .then(function () { deffered.resolve(); })
		                .then(function () { deffered.reject(); });

		                func.push(deffered);
		                
					}
					
					$q.all(func).then(function(resp){
						fnScope.modalItemSelect = true;
						setNotify('<span class="fa fa-check fg-green marginLeftEasing20" style="font-size: 1.7em;"></span> Collateral: Saved Successfully', 'success');
						
					}).then(function(error) {
						console.log(error);
					});
					
				} //else { setNotify('กรุณาตรวจสอบความถูกต้องใหม่อีกครั้ง'); }
							
			}
	
		}
		
	}
	
	// Partners Information Module
	$scope.setPartnersInformationBundled = function() {
		
		if(confirm('กรุณายืนยันการบันทึกข้อมูล (Partners Information Only)')) {

			var func = [];	
			var field_valid  = [];
			
			var param_update = $filter("filter")($scope.Partners, { isNew: false });
			var param_insert = $filter("filter")($scope.Partners, { isNew: true });
	
			if(param_insert.length <= 0 && param_update.length <= 0) { setNotify('ขออภัย!! กรุณาสร้างข้อมูลก่อนบันทึกข้อมูล...'); } 
			else {
				
				if(param_insert.length > 0) {
					$.each(param_insert, function(index, value) {
						
						if(value.OnbehalfType && value.OnbehalfType !== "" && !value.PayeeName) {
							value.Validation.PayeeName = true; 
							field_valid.push('FALSE'); 
							setNotify('กรุณาระบุข้อมูลชื่อที่จะสั่งจ่าย');
							
						} else {
							value.Validation.PayeeName = false; 
							field_valid.push('TRUE'); 
						}
						
						if(value.PayeeName && !value.PayType) {
							value.Validation.PartnerPayType = true; 
							field_valid.push('FALSE'); 
							setNotify('กรุณาระบุข้อมูลประเภทของการสั่งจ่าย');
							
						} else {
							value.Validation.PartnerPayType = false; 
							field_valid.push('TRUE'); 
						}
		
						if(value.PayType && !value.Bank) {
							value.Validation.partnerBank = true; 
							field_valid.push('FALSE'); 
							setNotify('กรุณาระบุข้อมูลแบงค์ที่จะสั่งจ่าย');
							
						} else {
							value.Validation.partnerBank = false; 
							field_valid.push('TRUE'); 
						}
					
					});
					
				}
				
				if(param_update.length > 0) {
					$.each(param_update, function(index, value) {
						
						if(value.OnbehalfType && value.OnbehalfType !== "" && !value.PayeeName) {
							value.Validation.PayeeName = true; 
							field_valid.push('FALSE'); 
							setNotify('กรุณาระบุข้อมูลชื่อที่จะสั่งจ่าย');
							
						} else {
							value.Validation.PayeeName = false; 
							field_valid.push('TRUE'); 
						}
						
						if(value.PayeeName && !value.PayType) {
							value.Validation.PartnerPayType = true; 
							field_valid.push('FALSE'); 
							setNotify('กรุณาระบุข้อมูลประเภทของการสั่งจ่าย');
							
						} else {
							value.Validation.PartnerPayType = false; 
							field_valid.push('TRUE'); 
						}
		
						if(value.PayType && !value.Bank) {
							value.Validation.partnerBank = true; 
							field_valid.push('FALSE'); 
							setNotify('กรุณาระบุข้อมูลแบงค์ที่จะสั่งจ่าย');
							
						} else {
							value.Validation.partnerBank = false; 
							field_valid.push('TRUE'); 
						}
					
					});
				}
				
				console.log([param_insert, param_update]);
		
				if(!help.in_array('FALSE', field_valid)) {
					if(param_insert.length > 0) {
		                var deffered = $q.defer();
		     
		                $.each(param_insert, function(index, value) { 
		    				value.PayAmount = (value.PayAmount == '') ? 0.00:value.PayAmount
		    			});
		                
		                help.partnersInsert($scope.DataList.ApplicationNo, param_insert)
		                .then(function (resp) { 
		                	
		                	if(resp.data) {
		                		$.each(resp.data, function(index, value) { 
		                			if(value.Status) {
		                				param_insert[index].isNew = false;
		                			}
		                		});
		                	}
		                	
		                	deffered.resolve(); 
		                	
		                })
		                .then(function () { deffered.reject(); });

		                func.push(deffered);
		                
					}
					
					if(param_update.length > 0) {
		                var deffered = $q.defer();
		                
		                $.each(param_update, function(index, value) { 
		    				value.PayAmount = (value.PayAmount == '') ? 0.00:value.PayAmount
		    			});
		                              
		                help.partnersUpdate($scope.DataList.ApplicationNo, param_update)
		                .then(function () { deffered.resolve(); })
		                .then(function () { deffered.reject(); });

		                func.push(deffered);
		                
					}
				
					$q.all(func).then(function(resp){
						fnScope.modalItemSelect = true;
						setNotify('<span class="fa fa-check fg-green marginLeftEasing20" style="font-size: 1.7em;"></span> Partners: Saved Successfully', 'success');
						
					}).then(function(error) {
						console.log(error);
					});
					
					
				} else { setNotify('กรุณาตรวจสอบความถูกต้องใหม่อีกครั้ง'); }
								
			}

		}
		
	}
	
	// Customer Information Module
	$scope.updateFileBookbankModule = function(item, type) {
		if(confirm('กรุณายืนยันการอัพเดทสถานะไฟล์')) {
			item.BookBankStatus 	= type;
			
			$object_bundled  = {
				ApplicationNo: ($scope.DataList.ApplicationNo !== '') ? $scope.DataList.ApplicationNo:null,
				BookBankStatus: ($scope.DataList.BookBankStatus !== '') ? $scope.DataList.BookBankStatus:null,
				UpdateByEmpCode: (userInfo[0].EmployeeCode !== '') ? userInfo[0].EmployeeCode:null,
				UpdateByEmpName: (userInfo[0].FullNameTh !== '') ? userInfo[0].FullNameTh:null
			}; 
			
			help.UpdateCustInformation($scope.DataList.ApplicationNo, $object_bundled)
			.then(function(responsed) {
				fnScope.modalItemSelect = true;
				if(responsed.status === 200) {
					setNotify('<span class="fa fa-check fg-green marginLeftEasing20" style="font-size: 1.7em;"></span> Informatin: Saved Successfully', 'success');
				} else {
					setNotify('<span class="fa fa-exclamation-circle fg-white marginLeftEasing20" style="font-size: 1.7em;"></span> เกิดข้อผิพลาดในการอัพเดทข้อมูล กรุณาลองใหม่อีกครั้ง', 'error', 'right', 380);
				}
				
			});
			
		}

	}
	
	// Collateral Information Module
	$scope.savePartnersModule = function(item, type) {
		if(confirm('กรุณายืนยันการอัพเดทสถานะไฟล์')) {
			item.PatchStatus 	= type;
			
			var param_update = $filter("filter")($scope.Partners, { isNew: false });
			help.partnersUpdate($scope.DataList.ApplicationNo, param_update).then(function () { 
				fnScope.modalItemSelect = true;
				setNotify('<span class="fa fa-check fg-green marginLeftEasing20" style="font-size: 1.7em;"></span>Update Successfully', 'success');
			});
			
		}
	}
	
	// Collateral Information Module
	$scope.saveCustomerInfoModule = function(item, type) {
		if(confirm('กรุณายืนยันการอัพเดทสถานะไฟล์')) {
			item.FileStatus 	= type;
			
			var param_update = $filter("filter")($scope.Collateral, { isNew: false });
			help.CollateralUpdate($scope.DataList.ApplicationNo, param_update).then(function () { 
				fnScope.modalItemSelect = true;
				setNotify('<span class="fa fa-check fg-green marginLeftEasing20" style="font-size: 1.7em;"></span>Update Successfully', 'success');
			});
			
		}

	}
	
	// Note Information
	$scope.setNoteInfo = function() {
		var param = $filter("filter")($scope.NoteList,{ IsNew:true });
		if(param[0]) {
			
			if(confirm('กรุณายืนยันการบันทึกข้อมูล ')) {

				var isCompleted = [];
				$.each(param, function(index, value) {
					
					if(!param[index].Note) isCompleted.push('FALSE');
					else isCompleted.push('TRUE');
					
				});
			
				if(!help.in_array('FALSE', isCompleted)) {
					
					help.NoteInfomartionInsert($scope.DataList.ApplicationNo, param)
					.then(function(responsed) {
						fnScope.modalItemSelect = true;
						if(responsed.status === 200) {
							setNotify('<span class="fa fa-check fg-green marginLeftEasing20" style="font-size: 1.7em;"></span> NOTE INFO: Saved Successfully', 'success');
						} else {
							setNotify('<span class="fa fa-exclamation-circle fg-white marginLeftEasing20" style="font-size: 1.7em;"></span> เกิดข้อผิพลาดในการอัพเดทข้อมูล กรุณาลองใหม่อีกครั้ง', 'error', 'right', 380);
						}
						
					});
					
				} else {
					setNotify('กรุณาตรวจสอบการกรอกข้อมูลให้ครบถ้วนอีกครั้ง');
				}
			
			}
			
		} else { setNotify('ขออภัย!! ไม่พบข้อความใหม่ที่ต้องการจะเพิ่ม...'); }

	}
	
	$scope.handlePaymentSummary = function(data, collectionData) {
		var approved_loan  = (data && data.ApprovedLoan > 0) ? checkNumVal(data.ApprovedLoan) : 0;
		
		var collection = (collectionData && collectionData[0]) ? collectionData[0] : null;
		var refinace_loan = (collection && collection) ? collection.Refinance : 0;
		var collection_loan = (collection && collection) ? collection.Amount2 : 0;
		var campain_loan = (collection && collection.CampaignData[0]) ? _.sumBy(collection.CampaignData, 'Amount') : 0;
		
		var total_campain = ( checkNumVal(refinace_loan) + checkNumVal(collection_loan) + checkNumVal(campain_loan) );
		var total_loan = (approved_loan - total_campain);
		
		data.BorrowerAmount = checkNumVal(total_loan);		
	}
	
	function checkNumVal(num) {
		if(num && (num > 0 || num > 0.00)) {
			return parseFloat(num);
		} else {
			return 0;
		}
	}
	
	/** END:  Function: Data Bundled **/
	
	// Load History Log
	$scope.insurance_data		= null;
	$scope.insurance_content	= '';
	$scope.appraisal_log		= '';
	$scope.operation_history 	= '';
	$scope.plandrawdown_log 	= null;
	$scope.refinace_log 		= {};

	onLoadInsurance(items);
	onLoadAppraisalLog(items);
	onLoadPlanDrawdownLog(items);
	onLoadOperationHistory(items);
	onLoadCollateralRefinanceLog();
	
	$scope.webuiConfig = {
		trigger:'click',
		title: '',
		content: '',
		width: 'auto',	
		placement: 'top',
		multi: false,						
		closeable: true,
		style: '',
		height: 150,
		delay:{ show: 150, hide:1000 },
		padding: true,
		animation:'pop',
		backdrop: false
	};
	
	function onLoadInsurance(appno) {
		
		$scope.insurance_data       = false;
		$scope.webuiInsuranceConfig = {
			trigger:'click',
			title: '',
			content: '',
			width: 'auto',	
			placement: 'right',
			multi: false,						
			closeable: true,
			style: '',
			height: 680,
			delay:{ show: 150, hide:1000 },
			padding: true,
			animation:'pop',
			backdrop: false
		}
		
		if(appno) {
			
			 var url = links + 'ddtemplate/insuranceinformation/' + appno;
			 var header     = '<h5 class="text_bold">Insurance Information</h5>';
			 var footer     = '<h6 class="text_bold">สอบถามรายละเอียดข้อมูลประกันเพิ่มเติม โทร 02-697-5300 ต่อ 1409</h6>';
			 var content    = '';
			 var updateDate = '';
			 help.executeservice('get', url).then(function(resp) { 
				 	
				 if(resp.data.MRTAInfo || resp.data.FIREInfo[0]) {
					 $scope.insurance_data = true;
					 
					 if(resp.data.MRTAInfo !== null && resp.data.FIREInfo.length > 0) {
						 $scope.webuiInsuranceConfig.height = 680;
					 } else {
						 $scope.webuiInsuranceConfig.height = 'auto';
					 }
			
					 var mrta_field    = ['บริษัท', 'ระยะเวลาทำประกัน', 'จำนวนเงินรวมในวงเงินกู้', 'ทุนประกัน', 'แผน'];
					 var mrta_content  = '';
					 var cashy_content = '';
					 
					 $.each(resp.data, function(index, value) { 
						
						 if(index == 'MRTAInfo') {
							 
							 if(value) {
								 var InsuranceCompany 	 = (value.CompanyName) ? value.CompanyName:'';
								 var InsurancePeriodYear = (value.InsurancePeriodYear) ? formattedNumber(value.InsurancePeriodYear):'';
								 var InsurancePremium	 = (value.InsurancePremium) ? formattedNumber(value.InsurancePremium):'';
								 var InsuranceCapitel	 = (value.InsuranceCapitel) ? formattedNumber(value.InsuranceCapitel):'';
								 var InsurancePlans	 	 = (value.Plans) ? value.Plans:'';
								 
								 mrta_content += '<tr><td>' + mrta_field[0] + '</td><td>' + InsuranceCompany + '</td></tr>';
								 mrta_content += '<tr><td>' + mrta_field[1] + '</td><td>' + InsurancePeriodYear + ' ปี</td></tr>';
								 mrta_content += '<tr><td>' + mrta_field[2] + '</td><td>' + InsurancePremium + '</td></tr>';
								 mrta_content += '<tr><td>' + mrta_field[3] + '</td><td>' + InsuranceCapitel + '</td></tr>';
								 mrta_content += '<tr><td>' + mrta_field[4] + '</td><td>' + InsurancePlans + '</td></tr>';
							 } else {
								 mrta_content += '<tr><td rowspan="2" class="text-center">ไม่พบข้อมูล</td></tr>';
							 }
							
						 }
						 
						 if(index == 'FIREInfo') {							
							 var fire_info = $filter('unique')(value, "TitleDeed");
							 if(fire_info) {
								 $.each(fire_info, function(i, v) { 
										
									 var effective_date = (v.EffectiveDate) ? moment(v.EffectiveDate).format('DD/MM/YYYY'):'';
									 var expired_date 	= (v.ExpiryDate) ? moment(v.ExpiryDate).format('DD/MM/YYYY'):'';
									 cashy_content +=
										 '<tr><td>โฉนดที่ดิน</td><td>' + v.TitleDeed + '</td></tr>' +
										 '<tr><td>บริษัทประกัน</td><td>' + v.CompanyName + '</td></tr>' +
										 '<tr><td>สถานที่ใช้</td><td>' + v.Description + '</td></tr>' +
										 '<tr><td>ทุนประกัน</td><td>' + formattedNumber(v.TotalInsuranceAmount) + '</td></tr>' +
										 '<tr><td>วันที่เริ่มประกัน</td><td>' + effective_date + '</td></tr>' +
										 '<tr><td>ระยะเวลาประกัน</td><td>' + v.TermOfInsurance + '</td></tr>' +
										 '<tr><td>วันที่สิ้นสุดประกัน</td><td>' + expired_date + '</td></tr>' +
										 '<tr><td>Total Premium</td><td>' + formattedNumber(v.TotalPremiumAmount) + '</td></tr>';
									 
								 });
							 } else {
								 cashy_content += '<tr><td rowspan="2" class="text-center">ไม่พบข้อมูล</td></tr>';
							 }
							 
						 }
						 
					 });
			
					 
					 var table_mrta   = '<table class="table table-bordered"><thead><tr><th colspan="2">ข้อมูลผู้ประกัน (MRTA)</th></tr></thead><tbody>' + mrta_content + '</tbody></table>';
					 var table_cashy  = '<table class="table table-bordered"><thead><tr><th colspan="2">ข้อมูลอัคคีภัย (Fire Insurance)</th></tr></thead><tbody>' + cashy_content + '</tbody></table>';
					 
					 $scope.insurance_content = header + table_mrta + table_cashy + footer;
					
				 }
			    
			 });
			 
		}
	
		function formattedNumber(num, x = 0) {
			 var renum = parseFloat(num).toFixed(x);
         	 return renum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        }
		
	}
	
	function onLoadOperationHistory(appno) {		
		if(appno) {
			
			 var header     = '<h5 class="text_bold">ข้อมูลประวัติทีม Operation</h5>';
			 var content   = '';
			 var dateItem  = '';
			 
			 var itemList  = [];
			 var functions = [];	
			 var deffered  = $q.defer();

			 functions.push(help.executeservice('get', links + 'ddtemplate/' + appno + '/confirm/history'));
			 functions.push(help.executeservice('get', links + 'ddtemplate/' + appno + '/recievefileca/history'));
			
			 $q.all(functions).then(function(resp){
				 if(resp[0]) {
					 var data = resp[0].data;
					 if(data.length > 0) {
						 $.each(data, function(index, value) {
							itemList.push({ '_UpdateDate': value._UpdateDate, 'UpdateByEmpName': value.UpdateByEmpName, 'Status': 'รับทราบ'  }); 
						 });
					 }
					
				 }
				 
				 /*
				 if(resp[1]) {
					 var data = resp[1].data;
					 if(data.length > 0) {						 
						 $.each(data, function(index, value) {
							itemList.push({ '_UpdateDate': value._UpdateDate, 'UpdateByEmpName': value.UpdateByEmpName, 'Status': (value.FlagRecieveFile == 'Y') ? 'รับแฟ้ม':'Reset'  }); 
						 });
					 }
				 }
				 */
				
				 if(itemList.length > 0) {	
					 var objectLog = $filter('orderBy')(itemList, '+_UpdateDate');
					 $.each(objectLog, function(index, value) {
						 if(value._UpdateDate) dateItem = $filter("date")(new Date(value._UpdateDate),"dd/MM/yyyy (HH:mm)");
						 content += (index + 1) + '. ' + dateItem + ' BY ' + value.UpdateByEmpName.split(" ")[0] + ' (' + value.Status + ')<br/>';
					
					 })
					 
					 $scope.operation_history = header + content;
					 
				 } 
	
			}).then(function(error) { /*console.log(error);*/ });
			
		}
		
	}

	function onLoadAppraisalLog(appno) {
		var url = links + 'ddtemplate/' + appno + '/appaisalstatus/history';
		if(appno) {
			 var header     = '<h5 class="text_bold">ข้อมูลประวัติผู้เปลี่ยนสถานะจดจำนอง</h5>';
			 var content    = '';
			 var updateDate = '';
			 help.executeservice('get', url).then(function(resp) { 
				 if(resp.data[0] !== undefined) {
					 $.each(resp.data, function(index, value) {
						 if(value._UpdateDate) updateDate = $filter("date")(new Date(value._UpdateDate),"dd/MM/yyyy (HH:mm)");
						 content += (index + 1) + '. ' + updateDate + ' BY ' + value.UpdateByEmpName.split(" ")[0] + ' (' + value.AppraisalStatus + ')<br/>';
					
					 })
					 
					 $scope.appraisal_log = header + content;
					
				 }
			    	
			 });
		}
	 
	}
	
	function onLoadPlanDrawdownLog(appno) {
		if(appno) {
			 var header    = '<h5 class="text_bold">ข้อมูลประวัติการเปลี่ยนแผนจดจำนอง</h5>';
			 var content    = '';
			 var plandate   = '';
			 var updatedate = '';
			 var title_date = '';
			 
			 help.executeservice('post', links + 'ddtemplate/plandd/history', { ApplicationNo: appno, FlagDDTemp: 'Y' }).then(function(resp) {
				 
				 if(resp.data[0] !== undefined) {
					 $.each(resp.data, function(index, value) {
						 //if(value._OriginalPlan) plandate = $filter("date")(new Date(value._OriginalPlan),"dd/MM/yyyy");
						 if(value._CreateDate) updatedate = $filter("date")(new Date(value._CreateDate),"dd/MM/yyyy (HH:mm)");
						 
						 if(value.Title == "dd confirm") {
							 title_date	= 'จอง';
						 } else {
							 
							 if(value._NewPlan) title_date = $filter("date")(new Date(value._NewPlan),"dd/MM/yyyy (HH:mm)");
							 //else if(value._CreateDate) title_date = $filter("date")(new Date(value._CreateDate),"dd/MM/yyyy (HH:mm)");
							 else title_date = 'เลือนไม่มีกำหนด'
						 }
						 
						 content += (index + 1) + '. DD PLAN ' + title_date + ' BY ' + value.CreateBy.split(" ")[0] + ' ' + updatedate + '<br/>';
						 
					 })
					 
					 $scope.plandrawdown_log = header + content;
				 }
			     
			 });
		}
	}
	
	/*
	function onLoadPlanDrawdownLog(appno) {
		if(appno) {
			 var header    = '<h5 class="text_bold">ข้อมูลประวัติการเปลี่ยนแผนจดจำนอง</h5>';
			 var content    = '';
			 var plandate   = '';
			 var updatedate = '';
			 help.executeservice('get', links + 'ddtemplate/' + appno + '/plandd/history').then(function(resp) { 
				 if(resp.data[0] !== undefined) {
					 $.each(resp.data, function(index, value) {
						 if(value._OriginalPlan) plandate = $filter("date")(new Date(value._OriginalPlan),"dd/MM/yyyy");
						 if(value._CreateDate) updatedate = $filter("date")(new Date(value._CreateDate),"dd/MM/yyyy (HH:mm)");
						 content += (index + 1) + '. DD PLAN ' + plandate + ' BY ' + value.CreateBy.split(" ")[0] + ' ' + updatedate + '<br/>';
						 
					 })
					 
					 $scope.plandrawdown_log = header + content;
				 }
			     
			 });
		}
	}
	*/
	
	function onLoadCollateralRefinanceLog() {
		 var header    = '<h5 class="text_bold">ข้อมูลประวัติการเปลี่ยนวงเงินรีไฟแนนซ์</h5>';
		 $scope.$watch('Collateral', function(n, o) {
			if(n[0] !== undefined) {
				$.each(n, function(index, value) {
					 if(value.ApplicationNo && value.RefNo) {						
						 help.executeservice('get', links + 'ddtemplate/' + value.ApplicationNo + '/refinance/history/' + value.RefNo.trim()).then(function(resp) {
							 if(resp.data[0] !== undefined) {
								 var updateDate   = '';
								 var content_text = '';
								 var concat_text  = '';
								 var refinance	  = '';
								 var payment_type = '';
								 var bank_type	  = '';
								 var pay_amount	  = '';
								 $.each(resp.data, function(i, v) {
									 refinance    = (v.Refinance && v.Refinance !== '') ? v.Refinance:'';
									 payment_type = (v.PayType && v.PayType != '') ? ', ' + v.PayType:'';
									 bank_type	  = (v.Bank && v.Bank !== '') ? ', ' + v.Bank.trim():'';
									 pay_amount	  = (v.RefinanceAmt&& v.RefinanceAmt !== '') ? ', ' + formattedNumber(v.RefinanceAmt, 0):'';
									 concat_text  = refinance + payment_type + bank_type + pay_amount;
									 
									 if(v._UpdateDate) updateDate = $filter("date")(new Date(v._UpdateDate),"dd/MM/yyyy (HH:mm)");
									 content_text += (i + 1) + '. ' + updateDate + ' BY ' + v.UpdateByEmpName.split(" ")[0] + ' (' + concat_text + ')' + '<br/>';
								 })
								 
								 value.collateral_log = header + content_text;

							 } else {
								 value.collateral_log = null;
							 }
						
						 });
					 } 
				})
			
			}

		 });
		 
		 function formattedNumber(num, x = 0) {
			 var renum = parseFloat(num).toFixed(x);
         	 return renum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
         }
		 
	}

	$scope.category = { typeA: ["KTB","SCB","TBANK","BAY"], typeB: ["TCRB"], typeC: ["KBANK", "SCB", "BBL"] };
	$scope.tempBank = fnScope.masterdata.bank;
	$scope.$watch("DataList.BorrowerPayType", function(n, o){
		if(n) {
			var matchObj;
			$scope.category = {
				typeA: ["KTB", "SCB", "TBANK", "BAY"],
				typeB: ["TCRB"], 
				typeC: ["KBANK", "SCB", "BBL"] 
			};
			
			if(n == "Draft") {
				matchObj = $scope.category.typeA;
				
				var result =  $.map(fnScope.masterdata.bank, function(value) {
					return $.inArray(value.Bank_Digit.trim(),matchObj) >= 0 ? value : null; 
				});

				$scope.tempBank = result;
				
			} else if(n == "Cheque") {
				matchObj = $scope.category.typeB;
				var result =  $.map(fnScope.masterdata.bank, function(value) {
					return $.inArray(value.Bank_Digit.trim(),matchObj) >= 0 ? value : null; 
				});
	
				$scope.tempBank = result;
				
			} else if(n == "Direct Credit") {				
				matchObj = $scope.category.typeC;
				var result =  $.map(fnScope.masterdata.bank, function(value) {
					return $.inArray(value.Bank_Digit.trim(),matchObj) >= 0 ? value : null; 
				});
	
				$scope.tempBank = result;
			}
			else { $scope.tempBank = fnScope.masterdata.bank; }
		}
	});
	
	$scope.setBorrowerNameLabel = function(type) {
		if(type) {
			switch(type) {
				case '101':
					return 'ผู้กู้หลัก';
					break;
				case '102':
					return 'ผู้กู้ร่วม';
					break;
				case '104':
					return 'อื่นๆ';
					break;
			}
		}
	}
	
	// Reset Field Combo
	$scope.resetField = function(item) {		
		if(item.PayType == '') { item.PayType == null; }
		item.BankPayType = ''; 
		item.Refinance 	 = '0.00'; 
	}
	
	$scope.resetField2 = function(item, approved_loan) {
		if(item.PayType2 == '') { item.PayType2 == null; } 
		item.Bank2 	 = ''; 
		item.Amount2 = '0.00'; 	
		
		if(item.PayType2 && item.PayType2 !== '' && item.Amount2 <= 0) {
			item.Amount2 = (approved_loan * 1) / 100;
		}
	}
	
	$scope.resetField3 = function(item) {
		if(item.PayType3 == '') { item.PayType3 == null; }
		item.Bank3 	 = ''; 
		item.Amount3 = '0.00'; 
		
	}
	
    $scope.checkPayTypeHandled = function() {
		if(help.in_array($scope.DataList.BorrowerPayType, ['Draft', 'Cheque', ''])) $scope.DataList.BookBankFlag = 'N';
		else $scope.DataList.BookBankFlag = 'Y';
		
		if($scope.DataList.BorrowerPayType == '') { $scope.DataList.BorrowerPayType  = ''; }
		$scope.DataList.BorrowerBank     = '';
		$scope.DataList.BorrowerAmount   = '0';
		
	}
    	
	$scope.collapsePanel = function(elem) {
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
	
	$scope.collapseTable = function(elem, pointer) {
		var $this 	 = $('#' + elem);
		var $pointer = $('#' + pointer);

		if(!$this.hasClass('table-collapsed')) {
			$this.find('.panel-body').slideUp();
			$this.addClass('table-collapsed');
			$pointer.html('<p>เพิ่มเติม</p> <i class="fa fa-caret-down"></i>');
			$this.removeAttr('style').css({ 'border-top': '0', 'border-left': '0', 'border-right': '0', 'border-bottom': '0' });
			
		} else {
			$this.find('.panel-body').slideDown();
			$this.removeClass('table-collapsed');
			$pointer.html('<i class="fa fa-caret-up"></i> <p>ซ่อน</p>');
			$this.removeAttr('style').css({ 'border-top': '0', 'border-left': '0', 'border-right': '0'});
			
		}	
		
	}

	function panelCollapseEnable(element, objectNote) {
		var $this = $('#' + element);
		if(objectNote && objectNote.length <= 0) {
			if(!$this.hasClass('panel-collapsed')) {
				$this.parents('.panel').find('.panel-body').slideUp();
				$this.addClass('panel-collapsed');
				$this.find('i').removeClass('fa fa-chevron-circle-up').addClass('fa fa-chevron-circle-down');
			} 
		}

	}
	
	function setNotify(notify_msg, notify_type = "error", notify_position = "center", width = 300) {
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
	
	// array = [{key:value},{key:value}]
	function objectFindByKey(array, key, value) {
	    for (var i = 0; i < array.length; i++) {
	        if (array[i][key] === value) {
	            return array[i];
	        }
	    }
	    return null;
	}
	
});
