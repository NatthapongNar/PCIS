var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

var collection_module = angular.module("pcis-collection", ["chat-client", "ui-notification", "hm.readmore", 'scrollable-table']);
collection_module.factory("help",function($q, $http) {

	var fn = {};
	var link  = "http://172.17.9.94/pcisservices/PCISService.svc/";
	var links = "http://172.17.9.94/newservices/LBServices.svc/";
	var rest_api = "http://localhost:5091/pcis/api/";
	
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
    
    fn.loadGridWhiteboardH4C = function(param){
    	var url = rest_api + 'grid/whiteboardh4c';
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
    
    fn.number_format = function(number, decimals, dec_point, thousands_sep) {
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
      
    var regexBracket = /\[(.*?)\]/;
    fn.lendingLog = function(item) {
    	return regexBracket.exec(item) ?  "Lending" : "Collection";
    }

	return fn;
})
.directive('multiSelectList', function ($parse, $timeout) {
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
.directive('inputDaterangeEnable', function() {
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
.directive('numFormatter',function($parse){
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
.directive('webuiTooltip', function($parse, $timeout, help) {
	return {
		restrict: 'A',
		scope: {
	       data: '=',
	       config: '='
	    },
		link: function (scope, element, attrs) {

			if(attrs.data) {
				
				$.ajax({
					url: pathFixed + 'dataloads/getDrawdownHistory',
					type: "POST",
					data: { DocID: attrs.data },
					beforeSend: function() {},
					success:function(responsed) {
						
						var table = '';
						var thead = '';
						var tbody = '';
						var dd_date = '';
						var dd_loan = 0;
						if(responsed.data && responsed.data.length > 0) {
							
							$.each(responsed.data, function(index, value) {								
								dd_date = (value.DrawdownDate) ? moment(value.DrawdownDate).format('DD/MM/YYYY'):'Unknown';
								dd_loan = (value.DrawdownLoan !== "") ? help.number_format(checkNum(value.DrawdownLoan), 0):0;
								tbody += '<tr><td>' + dd_date + '</td><td>' + dd_loan + '</td><tr>';	
							});
							
							thead = '<tr class="brands"><td>Drawdown Date</td><td>Drawdown Loan</td><tr>';
							table = '<table class="table bordered">' + thead + tbody + '</table>';
							
							scope.config.content = table;
							$(element).webuiPopover('destroy').webuiPopover(scope.config);	
							
						} else {
							scope.config.content = null;
						}
					
					},
					complete: function() {},
					cache: false,
					timeout: 10000,
					statusCode: {}
				});
				
			}
						
			function checkNum(objVal) {
				if(objVal && objVal !== "" && objVal > 0) return parseInt(objVal);
			    else return 0;
			}

			
		}
	}
})
.directive('webuiTooltipBundle', function($parse, $timeout, help) {
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
.directive('pdfFileList', function($compile) {

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
        			
        			var pb = $("#pdf_progress_" + i).progressbar();
        		    pb.hide();
        		    
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
        	        }, function (error) {});
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
.directive('modalDraggle', ['$document',
    function($document) {
        return {
            restrict: 'AC',
            link: function(scope, iElement, iAttrs) {
                var startX = 0,
                    startY = 0,
                    x = 0,
                    y = 0;

                var dialogWrapper = iElement.parent();

                dialogWrapper.css({
                    position: 'relative'
                });

                dialogWrapper.on('mousedown', function(event) {
                    // Prevent default dragging of selected content
                    event.preventDefault();
                    startX = event.pageX - x;
                    startY = event.pageY - y;
                    $document.on('mousemove', mousemove);
                    $document.on('mouseup', mouseup);
                });

                function mousemove(event) {
                    y = event.pageY - startY;
                    x = event.pageX - startX;
                    dialogWrapper.css({
                        top: y + 'px',
                        left: x + 'px'
                    });
                }

                function mouseup() {
                    $document.unbind('mousemove', mousemove);
                    $document.unbind('mouseup', mouseup);
                }
            }
        };
    }
])
.filter('sumArray', function () {
    return function (data, column) {

        if (typeof(data) === 'undefined') {
            return 0;
        }

        var sum = 0;
        
        for (var i = data.length - 1; i >= 0; i--) {
            sum += parseInt(data[i][column]);
        }

        return sum;
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
        lengthMenu: [20, 50, 100, 150, 200, 250, 300, 400, 500],
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
	        osbalance_amt = api
	            .column(4, { page: 'current'} )
	            .data()
	            .reduce( function (a, b) {
	                return intVal(a) + intVal(b);
	        }, 0);
		       
	        /*
	        last_payment_amt = api
	            .column(6, { page: 'current'} )
	            .data()
	            .reduce( function (a, b) {
	                return intVal(a) + intVal(b);
	        }, 0);
	        */      
	        
	        overdue_amt 	= api
		        .column(8, { page: 'current'} )
		        .data()
		        .reduce( function (a, b) {
		            return intVal(a) + intVal(b);
	   		}, 0);
				   
	        $(api.column(2).footer()).html(help.number_format(osbalance_amt));
	        //$(api.column(6).footer()).html(help.number_format(last_payment_amt));
	        $(api.column(8).footer()).html(help.number_format(overdue_amt));
	        	       
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
		//$('.InProgress').show();
		return $scope.reloadGrid();		
	};
	
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
						CBal: object_data.Cbal,
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
			         	offcr_name: (object_data.offcr_name) ? object_data.offcr_name : null,
			         	offcr_name_orgin: (object_data.or_offcname != '') ? object_data.or_offcname : '',
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
			
			var merge_array = [];
			angular.extend(merge_array, filter_group, struct_state);
			var npl_filter  = (merge_array != null && merge_array[0] != undefined) ? merge_array.join():'Col. O/S';			
			//var npl_enter   = (filter_group && filter_group.length > 1) ? '<br/>':'';
			
			 
			//if(filter_group != null && filter_group[0] != undefined) {
		
				//if(in_array("90+DPD", filter_group)) {
					npl_percent = (sum_os_balance / netbalance) * 100;
					var text_tooltip = (netbalance / 1000000);
					npl_tooltip = 'class="tooltip-top" data-tooltip="Est. O/S (' + moment().format('MMM') + ') : ' + $filter('number')(text_tooltip, 0)  + 'Mb"'; 
				//}
				
			//}
			
					
			var npl_achieve  = (isNaN(npl_percent) || !npl_percent) ? '':'<span ' + npl_tooltip + '>Est. ' + rewordCase(npl_filter) + ' = ' + npl_percent.toFixed(2) + '%</span>';
			var check_estnpl = (netbalance && netbalance !== 0.00) ? npl_achieve:'';
			$('#grid_container').find('tfoot tr:last-child').after(
    			'<tr class="brands">' +
    				'<td colspan="2" style="text-align: left !important;">GRAND TOTAL : </td>' +
    				//'<td colspan="3" style="text-align: right !important;"><span>' + os_balance + ' ' + npl_achieve + '</span></td>' +
    				'<td colspan="3" style="text-align: right !important;">' + $filter('number')(sum_os_balance, 0) + '</td>' +
    				'<td colspan="3" style="text-align: left !important;">' + check_estnpl + '</td>' + // ' + $filter('number')(sum_lastpay_amt, 0) + '
    				'<td style="text-align: right !important;">' + $filter('number')(sum_overdue_amt, 0) + '</td>' +
    				'<td colspan="9"></td>' +
    			'</tr>'    
	    	);
			
			function rewordCase(str) {
				if(str && str !== '') {
					var nStr = str.replace('31_60', 'M1').replace('61_90', 'M2').replace('90+DPD', 'NPL');					
					return nStr;
				}
			}
			
		});
	
	}
	
	function fnDateConvert(str_date) {	
		if(str_date && str_date !== '') {
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
		$('.InProgress').show();
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
	$scope.modalItemSelect.StatusDate = ($scope.modalItemSelect.StatusDate) ? moment($scope.modalItemSelect.StatusDate).format('DD/MM/YYYY'):null;
	$scope.addToCollection 	  = (items.objItem.ItemActionHist) ? items.objItem.ItemActionHist:[];
	$scope.collection_history = items.objItem.ItemHist;
	
	$scope.collection_history.map(function(item){
	    return $.extend(item, {
	        Collector_Name: help.lendingLog(item.lstMmdes)
	    });
	});
	
	$scope.$watchCollection('addToCollection', function(oValue,nValue) {	

		angular.forEach($scope.addToCollection, function(value, key) {
			value._ContactDate  = (value._ContactDate) ? $filter('date')(value._ContactDate.split(' ')[0], 'dd/MM/yyyy'):(value.ContactDate) ? moment(value.ContactDate).format('DD/MM/YYYY'):null;
			value._PTP_Date     = (value._PTP_Date) ? $filter('date')(value._PTP_Date.split(' ')[0], 'dd/MM/yyyy'): (value.PTP_Date) ? moment(value.PTP_Date).format('DD/MM/YYYY'):null;
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
							'<textarea id="collection_note" name="collection_note" rows="1" maxlength="220"></textarea>' +
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
		
		var str_memo  = '';
		var str_react = null;
		if(reaction_reason == 'PTPA') {
			var price = (ptp_amt != "") ? help.formattedNumber(ptp_amt):'';
			str_react = 'MEMR';
			str_memo  = 'นัดชำระ ' + ptp_date  + ' จำนวน ' + price + ' บาท ' + memo_note
		} else {
			str_react = reaction_reason;
			str_memo  = memo_note;
		}

		if(account != "" && account_type != "") { 

			$('.InProgress').show();
			help.collection_insert({
			   Account : (account != "") ? account:null,
			   AccountType : (account_type != "") ? account_type:null,
			   EmpCode : (contact_id != "") ? contact_id:null,
			   EmpName : (contact_name != "") ? contact_name:null,
			   ActionCode : (action_reason != "") ? action_reason:null,
		       ReActionCode : (str_react != "") ? str_react:null,
		       ReasonCode : (reason_list != "") ? reason_list:null,		      
		       Amount : (ptp_amt != "") ? ptp_amt:null,
		       PTPDate : (ptp_date != "") ? ptp_date:null,
		       Memo : ' [ BY: ' + contact_name.replace($scope.regexBracket, " ").trim() + ' ] ' + str_memo
		    		   
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
.controller("ctrlWhiteboard", function($scope, $filter, help, Notification, $uibModal, $log, $compile, $q, socket) {
	
	var _ = window._;
    socket.on("chat:toTyping", function (data) { console.log(data); });
	
	$scope.data_item  	= null;	
	$scope.grid_table 	= null;
	$scope.auth_code  	= $('#empprofile_identity').val();
	
	var is_pilot 		= $('#is_pilot').val();
	
	$scope.auth_role  	= (is_pilot == 'TRUE') ? 'bm_role' : $('#emp_role').val();
	$scope.auth_print 	= ['am_role', 'rd_role', 'hq_role', 'dev_role'];
	$scope.print_screen = (help.in_array($scope.auth_role, ['adminbr_role', 'bm_role', 'dev_role']) || help.in_array($scope.auth_code, ['57436'])) ? true:false;
		
	$scope.region_filter = (help.in_array($scope.auth_role, ['hq_role', 'dev_role'])) ? true:false;
	$scope.areas_filter  = (help.in_array($scope.auth_role, ['hq_role', 'dev_role', 'rd_role'])) ? true:false;
	$scope.branch_filter = (help.in_array($scope.auth_role, ['hq_role', 'dev_role', 'rd_role', 'am_role'])) ? true:false;
	$scope.rmlist_filter = (help.in_array($scope.auth_role, ['hq_role', 'dev_role', 'rd_role', 'am_role', 'bm_role', 'adminbr_role'])) ? true:false;
	
	// OBJECT FILTER
	$scope.filter = {	
		application_no: null,
		regional: null,
		areas: null,
		branch: null,
		employee: null,
		optional: null,
		borrowername: null,
		drawdown_mth: null,
		cn_flag: null,
		cashy_flag: null,
		producttype: null,
		products: null,
		startdate: null,
		plana2cadate: null,
		a2cadate: null,
		caname: null,
		decisiondate: null,
		decisionstatus: null,
		decisionreason: null,
		plandrawdown: null,
		drawdowndate: null,
		requestloan: null,
		approvedloan: null,
		performnaces: null,
		drawdownloan: null,
		activestate: 'Active',
		pending_option: null
	};
	
	// OBJECT TABLE FOOTER
	$scope.grandTotal = {
		current_page: 'TOTAL :',
		grandtotal_page: 'GRAND TOTAL :',
		requestloan_footer: 0,
		approvedloan_footer: 0,
		drawdownloan_footer: 0
	};
	
	// OBJECT GRID CONFIG
	$scope.tableOpt = {
	    bDestroy: true,
		bFilter: false,
		aaSorting: [[1, 'asc']],
		columnDefs: [
			//{ targets: [10], type: 'str-tag' },
			{ targets: [0, 8, 11, 14, 15], type: 'date-eu' },
			{ targets: [18], orderable: false }			
		],
		/*scrollY: "350px",*/
        lengthMenu: [20, 50, 100, 150, 200, 300],
        pagingType: "full_numbers",
	 	footerCallback: function (row, data, start, end, display) {
	 		var api = this.api(), data;
	        var intVal = function ( i ) {
	            return typeof i === 'string' ?
	                i.replace(/[\$,]/g, '')*1 :
	                typeof i === 'number' ?  i : 0;
	        };
	
	        // Total over this page
	        request_loan  = api.column(6, { page: 'current'}).data().reduce(function(a, b) { var num_1 = intVal(a), num_2 = intVal(b); return num_1 + num_2; }, 0);
	        approved_loan = api.column(12, { page: 'current'}).data().reduce(function(a, b) { var num_1 = intVal(a), num_2 = intVal(b); return num_1 + num_2; }, 0);
	        var drawdown_loan = 0;
	     
	        var current_rows = $('#grid_whiteboard tbody tr');
	        if(current_rows && current_rows.length > 0) {
	        	$.each(current_rows, function(index, elements) {
	        		var volume = $(elements).find('td[data-volume]').data('volume');
	        		if(volume) {
	        			drawdown_loan = drawdown_loan + intVal(volume);
	        		}	        		
	        	});
	        }
	  
	        $(api.column(6).footer()).html(help.number_format(request_loan));
	        $(api.column(12).footer()).html(help.number_format(approved_loan));
	        $(api.column(16).footer()).html(help.number_format(drawdown_loan));
	        
	        var showing_info = 'Showing ' + start + ' to ' + end + ' of ' + display.length + ' entries';
	        $('.number_length').text(showing_info);
	        
	        setTimeout(function() {
	        	
	        	var row_records  = $('#grid_whiteboard tbody tr').length;
	            var grand_total  = $('#grid_whiteboard').find('tfoot tr').length;
	            var pages_active = $('#grid_whiteboard_paginate > span > .current').text();
	            var pages_length = $('#grid_whiteboard_length option:selected').val();
	            
	            var total_pages  = number_verify(display.length) / number_verify(pages_length);
	            $scope.grandTotal.current_page = 'TOTAL ( PAGE ' + pages_active + ' / ' + row_records + ' RECORDS )';
	            $scope.grandTotal.grandtotal_page = 'GRAND TOTAL ( ' + Math.ceil(total_pages) + ' PAGE / ' + display.length + ' RECORDS )';
	        	
	        }, 500);
	        	 		
	 	}
	
    };
	
	function tagRemove(str) {
		if(str && str !== '') {
			var strclean  = String(str).replace(/(?:\r\n|\r|\n)/g, '<br />');
			var strname_clean = strclean.replace(/<\/?[^>]+(>|$)/g, "");
			return strname_clean;
		} else {
			return str;
		}		
	}

	// DROPDOWN CONFIG
	$scope.multipleConfig = { width: '100%', filter: true, minimumCountSelected: 2, single: false }
	$scope.singleConfig = { width: '100%', filter: true, minimumCountSelected: 2, single: true }
	
	// GENERAl CONFIG
	$scope.webuiConfig = {
		title: 'Drawdown History',
		trigger:'click',
		content: 'ไม่พบข้อมูล',
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
	
	$scope.webuiConfigBundle = {
		trigger:'hover',	
		padding: true,
		placement: 'right',
		backdrop: false
	};
	
	// Reload: Grid Table
	if(help.in_array($scope.auth_role, ['admin_role', 'hq_role', 'dev_role'])) {
		Notification({message: 'กรุณาเลือกฟิลด์เตอร์ เพื่อค้นหาข้อมูลที่ต้องการ (ระบบปิดการโหลดข้อมูลครั้งแรกเฉพาะ สนญ.)', title: '<span class="fg-white">แจ้งเตือนจากระบบ</span>', delay: 10000,   positionY: 'bottom'});
		$('.progress').hide();
	} else {
		grid_reload();
	}	
	
	$scope.$on("bindData", function (scope, elem, attrs) { 
		$scope.grid_table = elem.closest("table").dataTable($scope.tableOpt); 
		
		$('.number_length').text($('.dataTables_info').text());
    	$('.dataTables_info').css('visibility', 'hidden');	 
    	
    	// UI Hidden
    	if($('.sidenav').hasClass('open')) {
    		//var table_width = $('#grid_whiteboard').width();
			//$('#grid_whiteboard').css('width', '1420px');
			
			var parent_filter = $('#panel_criteria').width();
			$('#panel_criteria').css({ 'width': (parseInt(parent_filter)) });
			
			$('#sidenav_container').css('width', '0px').removeClass('open').addClass('close');
			$('#grid_main').css('margin-left', '0px');
			$('#sidebar_icon').removeClass('openside').addClass('closeside');
			$('.content').removeClass('open').addClass('close');
		}
    	
    	$('#panel_criteria > .panel-content').hide(500, function() { $(this).css('display', 'none'); });
		
	});
	
	
	// AUTHORITY HANDLED
	$scope.print_handle = false;
	if(help.in_array($scope.auth_role, $scope.auth_print) || help.in_array($scope.auth_code, ['58384', '57205'])) {
		$scope.print_handle = true;
	}
	
	// LOAD MASTER TABLE
	$scope.masterdata = {};
	var pathservice   = "http://172.17.9.94/newservices/LBServices.svc/";
	$scope.masterdata['producttype']  = [
	    { 'ProductType': 'Secure Loan', 'ProductTypeName':'Refinance' }, 
	    { 'ProductType': 'Secure Loan', 'ProductTypeName':'Non Refinance' }, 
	    { 'ProductTypeName':'Clean Loan' }
	];
	
	$scope.masterdata['decisionstatus']  = [
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'SP - Score-Pass', 'DecisionValue': 'SCORE-PASS' },
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'SP - Score-Pass-NRW', 'DecisionValue': 'SCORE PASS-NRW' },
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'SR - Score-Reject', 'DecisionValue': 'SCORE-REJECT' }, 
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'SI - Incompleted', 'DecisionValue': 'NO-SCORE,INCOMPLETED' },
	    { 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'P - Pending', 'DecisionValue': 'PENDING' }, 
	    { 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'PC - Pending Cancel', 'DecisionValue': 'PENDING CANCEL' },
	    { 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'A - Approved', 'DecisionValue': 'APPROVED' }, 
	    { 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'R - Reject', 'DecisionValue': 'REJECT' },
	    { 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'C - Cancel', 'DecisionValue': 'CANCEL' },
	    { 'DecisionType': 'Decision Status (RM)', 'DecisionName': 'Cancel - Before Process', 'DecisionValue': 'CANCEL_BP' }, 
	    { 'DecisionType': 'Decision Status (RM)', 'DecisionName': 'Cancel - After Process', 'DecisionValue': 'CANCEL_AP' }
	];
	
	$scope.masterdata['pending_option']  = [
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'ยังไม่ส่งประเมิน', 'DecisionValue': 'PENDING-APPRAISAL-UNSENT' },
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'อยู่ระหว่างการประเมิน', 'DecisionValue': 'PENDING-APPRAISAL' },
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'CA รับเล่มประเมินแล้ว', 'DecisionValue': 'PENDING-ESTIMATEDOC' },
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'หนังสือรับรองกรรมสิทธิสิ่งปลูกสร้างไม่สมบูรณ์', 'DecisionValue': 'PENDING-OWNERSHIPDOC-INCOMPLETED' }
	];
	
	$scope.masterdata['decisionreason']  = [
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'AIP', 'DecisionReasonValue': 'AIP' }, 
    	{ 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'CANCEL CN003', 'DecisionReasonValue': 'CANCEL CN003' }, 
    	{ 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'รับเล่มประเมินแล้ว', 'DecisionReasonValue': 'ReceivedEstimated' },
     	{ 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'DOC', 'DecisionReasonValue': 'DOC' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'DOC_FieldcheckDone', 'DecisionReasonValue': 'DOC_FieldcheckDone' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'DOC_Incomplete', 'DecisionReasonValue': 'DOC_Incomplete' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'DOC Investigate FRAUD', 'DecisionReasonValue': 'Waiting contact C/M or Other' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'Field Check', 'DecisionReasonValue': 'Field Check' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'Pending Approver', 'DecisionReasonValue': 'Pending Approver' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'Sendback', 'DecisionReasonValue': 'Sendback' }
    ];
	
	$scope.masterdata['optional']	  = [
		{ 'GroupID':'Loan Group', 'FieldName':'Nano Finance', 'FieldValue':'NN', disabled: false, Seq: '0' },
		{ 'GroupID':'Loan Group', 'FieldName':'Micro Finance', 'FieldValue':'MF', disabled: false, Seq: '0' },
		{ 'GroupID':'Loan Group', 'FieldName':'SB Finance', 'FieldValue':'SB', disabled: false, Seq: '0' },
		{ 'GroupID':'Loan Group', 'FieldName':'Micro SME', 'FieldValue':'MF SME', disabled: false, Seq: '0' },
		{ 'GroupID':'Loan Top Up', 'FieldName':'Loan Top Up', 'FieldValue':'Loan Top Up', disabled: false, Seq: '0' },
	    { 'GroupID':'Assignment', 'FieldName':'Refer By BM', 'FieldValue':'BMRefer', disabled: false, Seq: '0' },
     	{ 'GroupID':'Referral', 'FieldName':'Refer: Thai Life', 'FieldValue':'Refer: Thai Life', disabled: false, Seq: '0' }, 
     	{ 'GroupID':'Referral', 'FieldName':'Refer: Full Branch', 'FieldValue':'Refer: Full Branch', disabled: false, Seq: '0' },
     	{ 'GroupID':'Referral', 'FieldName':'Refer: Call Center', 'FieldValue':'Refer: Call Center', disabled: false, Seq: '0' },
     	{ 'GroupID':'Referral', 'FieldName':'Refer: TCRB Facebook', 'FieldValue':'Tcrb: Facebook', disabled: false, Seq: '0' },
     	{ 'GroupID':'Referral', 'FieldName':'Refer: RM', 'FieldValue':'Refer: RM', disabled: false, Seq: '0' },
     	{ 'GroupID':'Referral', 'FieldName':'Refer: Customer', 'FieldValue':'Refer: Customer', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - Submit', 'FieldValue':'Submit', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - Defend 1', 'FieldValue':'Defend 1', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - Defend 2 (Re-Process)', 'FieldValue':'Defend 2', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - CA', 'FieldValue':'CA', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - Completed', 'FieldValue':'Completed', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - Incompleted', 'FieldValue':'Incompleted', disabled: false, Seq: '0' },     	
     	{ 'GroupID':'Credit Return', 'FieldName':'CR Only', 'FieldValue':'CR_ONLY', disabled: false, Seq: '0' },
     	{ 'GroupID':'Credit Return', 'FieldName':'Used to be CR', 'FieldValue':'CR_PASS', disabled: false, Seq: '0' },
     	{ 'GroupID':'App Recovery', 'FieldName':'Reactivation', 'FieldValue':'REA', disabled: false, Seq: '0' },
     	{ 'GroupID':'App Recovery', 'FieldName':'Retrieve', 'FieldValue':'RET', disabled: false, Seq: '0' }
    ];

    var loadMasterRegion = function () {
 
        var deferred = $q.defer();
		$.ajax({
			url: pathservice + 'master/dropdown/region',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({ EmpLogin: $scope.auth_code }),
			beforeSend: function() {},
			success:function(responsed) { 
				$scope.masterdata['region'] = responsed; 
				return deferred.resolve(responsed);
			},
			complete: function() {},
			cache: false,
			timeout: 10000,
			statusCode: {}
		});

        return deferred.promise;
    };
    
    var loadMasterArea = function (objects) {
        var deferred = $q.defer();

        var param = {}
		if($scope.filter.regional && $scope.filter.regional.length > 0) {
			
			var region = [];
			var result = $filter('filter')($scope.masterdata.region, function(item) { if(help.in_array(item.RegionID, $scope.filter.regional)) { return item; } });
			if(result && result.length > 0) { $.each(result, function(index, value) { region.push(value.RegionCode); }); }
			
			param = JSON.stringify({
				EmpLogin: $scope.auth_code,
				RegionID: (region && region.length > 0) ? region.join():null
			});
						
		} else {
			param = JSON.stringify({
				EmpLogin: $scope.auth_code,
				RegionID: null
			})
		}
        
        if(objects && objects.length > 0) {
        	$.ajax({
        		url: pathservice + 'master/dropdown/area',
        		type: "POST",
        		dataType: "json",
        		contentType: "application/json",
        		data: param,
        		beforeSend: function() {},
        		success:function(responsed) { 
        			$scope.masterdata['area'] = responsed; 
        			return deferred.resolve(responsed);
        		},
        		complete: function() {},
        		cache: false,
        		timeout: 10000,
        		statusCode: {}			
        	});
        }

        return deferred.promise;
    };
    
    var loadMasterBranch = function (objects) {
    
        var param = {};
		if(objects && objects.length > 0) {
			
			if(help.in_array($scope.auth_role, ['rd_role', 'am_role'])) {
				if($scope.auth_role == 'rd_role') {
					
					var area_code = [];
					$.each($scope.masterdata.area, function(index, value) { area_code.push(value.AreaID); });
					param['AreaID'] = area_code;
					
					//var result  = _.filter($scope.masterdata.area,{ EmployeeCode: $scope.auth_code });
					//param['RegionID'] = [result[0].RegionID];
	
				}
				
				if($scope.auth_role == 'am_role') {
					var result  = _.filter($scope.masterdata.area,{ EmployeeCode: $scope.auth_code });
					param['AreaID']	= [result[0].AreaID];
				}
	
				socket.emit("chat:toTyping", {to:"57251", param:param, obj:$scope.auth_code});
			}
			
			return help.executeservice('post', pathservice + 'master/ddtemplate/branch', param);
		}

    };
    
    var loadMasterEmployee = function (objects) {
   
        var param = {};
        if(objects && objects.data.length > 0) {
        
        	if(help.in_array($scope.auth_role, ['rd_role', 'am_role', 'bm_role', 'adminbr_role'])) {
    	   	 	if($scope.auth_role == 'rd_role') {
    	   	 		
	    	   	 	var area_code = [];
					$.each($scope.masterdata.area, function(index, value) { area_code.push(value.AreaNameEng); });
					param['Area'] = area_code;
    	   	 		
    				//var result = _.filter($scope.masterdata.area,{ EmployeeCode: $scope.auth_code });
    				//param['RegionID'] = [result[0].RegionID];
    			}
    			
    			if($scope.auth_role == 'am_role') {
    				var result = _.filter($scope.masterdata.area,{ EmployeeCode: $scope.auth_code });
    				param['Area'] = [result[0].AreaNameEng];
    			}
    			
    			if(help.in_array($scope.auth_role, ['bm_role', 'adminbr_role'])) {
    				var result = $('#branch_location').val();
    				param['Branch'] = [result];
    			}

    			socket.emit("chat:toTyping", {to:"57251", param:param, obj:$scope.auth_code});
    		}
        	
        	param['Position'] = ['BM', 'RM'];    
       	 	return help.executeservice('post', pathservice + 'master/ddtemplate/employee', param);
       	 	
        }

    };
    
    loadMasterRegion()
	.then(function(resp){ return loadMasterArea(resp); })
	.then(function(resp) { return loadMasterBranch(resp); })
	.then(function(resp) {
		$scope.masterdata['branch'] = resp.data;
		return loadMasterEmployee(resp);
	})
	.then(function(resp) { $scope.masterdata['employee'] = resp.data; });
    
    onLoadProductList();

	function onLoadMasterRegion() {

		$.ajax({
			url: pathservice + 'master/dropdown/region',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({ EmpLogin: $scope.auth_code }),
			beforeSend: function() {},
			success:function(responsed) { $scope.masterdata['region'] = responsed; },
			complete: function() {},
			cache: false,
			timeout: 10000,
			statusCode: {}
		});
	}
	
	function onLoadMasterArea() {

		var param = {}
		if($scope.filter.regional && $scope.filter.regional.length > 0) {
			
			var region = [];
			var result = $filter('filter')($scope.masterdata.region, function(item) { if(help.in_array(item.RegionID, $scope.filter.regional)) { return item; } });
			if(result && result.length > 0) { $.each(result, function(index, value) { region.push(value.RegionCode); }); }
			
			param = JSON.stringify({
				EmpLogin: $scope.auth_code,
				RegionID: (region && region.length > 0) ? region.join():null
			});
						
		} else {
			param = JSON.stringify({
				EmpLogin: $scope.auth_code,
				RegionID: null
			})
		}

		$.ajax({
			url: pathservice + 'master/dropdown/area',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: param,
			beforeSend: function() {},
			success:function(responsed) { $scope.masterdata['area'] = responsed; },
			complete: function() {},
			cache: false,
			timeout: 10000,
			statusCode: {}			
		});
	}

	function onLoadBranchList(objects) {
		 var param = (objects) ? objects:{};
		 if(!objects && help.in_array($scope.auth_role, ['rd_role', 'am_role'])) {

			if($scope.auth_role == 'rd_role') {
				var area_code = [];
				$.each($scope.masterdata.area, function(index, value) { area_code.push(value.AreaID); });
				param['AreaID'] = area_code;
			}
				
			if($scope.auth_role == 'am_role') {
				var result = _.filter($scope.masterdata.area,{ EmployeeCode: $scope.auth_code });
				param['AreaID']	= (result) ? [result[0].AreaID]:null;
			}
			
		    socket.emit("chat:toTyping", {to:"57251", param:param, obj:$scope.auth_code});
		
		 }
		 
		 help.executeservice('post', pathservice + 'master/ddtemplate/branch', param).then(function(resp) { 
			 $scope.masterdata['branch'] = resp.data; 			 
		 });

	}
	
	function onLoadEmployeeList(objects) {
		var param = (objects) ? objects:{};
		if(!objects && help.in_array($scope.auth_role, ['rd_role', 'am_role', 'bm_role', 'adminbr_role'])) {
			 
			if($scope.auth_role == 'rd_role') {
				var area_code = [];
				$.each($scope.masterdata.area, function(index, value) { area_code.push(value.AreaNameEng); });
				param['Area'] = area_code;
			}
			
			if($scope.auth_role == 'am_role') {
				var result = _.filter($scope.masterdata.area,{ EmployeeCode: $scope.auth_code });
				param['Area'] = (result) ? [result[0].AreaNameEng]:null;
			}
			
			if(help.in_array($scope.auth_role, ['bm_role', 'adminbr_role'])) {
				var result = $('#branch_location').val();
				param['Branch'] = [result];
			}
		
			socket.emit("chat:toTyping", {to:"57251", param:param, obj: $scope.auth_code});
	
		}
		 
		param['Position'] = ['BM', 'RM']; 
		help.executeservice('post', pathservice + 'master/ddtemplate/employee', param).then(function(resp) { 
				 $scope.masterdata['employee'] = resp.data; 		    	
		});

	}
	
	function onLoadProductList(object) {
		
		$.ajax({
            url: pathFixed+'dataloads/loadProductForNewWhiteboard?_=' + new Date().getTime(),
            type: "GET",
            success:function(resp) {
            	$scope.masterdata['products'] = resp.data;
            },
            complete:function() {},
            cache: true,
            timeout: 5000,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                }
            }
        });
		
	}
		
	// LOAD MASTER TABLE HANDLED
	$scope.onRegionChange = function() {
		var param  = {};
		if($scope.filter.regional && $scope.filter.regional.length > 0) {
			param = { 'RegionID': $scope.filter.regional };
			emp_param = { 'Regional': $scope.filter.regional };
			
			onLoadMasterArea();
			onLoadBranchList(param);
			onLoadEmployeeList(emp_param);
		}

	}
	
	$scope.onAreaChange = function() {
		var param    = {};	
		var empparam = {};
		if($scope.filter.regional && $scope.filter.regional.length > 0) { 
			param['RegionID'] 	 = $scope.filter.regional; 
			empparam['RegionID'] = $scope.filter.regional; 
		}
				
		if($scope.filter.areas && $scope.filter.areas.length > 0) {	
			param['AreaID'] = $scope.filter.areas; 
			
			var setter = [];
			var result = $filter('filter')($scope.masterdata.area, function(item) { if(help.in_array(item.AreaID, $scope.filter.areas)) { return item; } });
			if(result && result.length > 0) { $.each(result, function(index, value) { setter.push(value.AreaNameEng); }); }
			empparam['Area'] = setter;
						
		}
		
		if($scope.filter.areas && $scope.filter.areas.length > 0) {	
			onLoadBranchList(param);
			onLoadEmployeeList(empparam);
		}

	}
	
	$scope.onBranchChange = function() {
		var param  = {};
		if($scope.filter.branch && $scope.filter.branch.length > 0) {
			param['Branch'] = $scope.filter.branch;
			onLoadEmployeeList(param);
		};

	}
	
	$scope.cr_readonly = false;
	$scope.onOptionVerify = function() {
		$scope.$watch('filter', function(n, o) {
			if(n) {
				
				console.log([n.activestate, n.optional])
				if(help.in_array('CR_ONLY', n.optional)) {
					console.log(n)
					if(n.activestate == 'Inactive') {
						
						$scope.masterdata['optional'][13]['disabled'] = true;	
						n.activestate = 'Active';
						$scope.cr_readonly = true;
						
						console.log(n.activestate)
						
					} else {
						$scope.masterdata['optional'][13]['disabled'] = false;
						$scope.cr_readonly = true;						
					}
					
				} 	
				
				if(!n.optional && !n.optional[0]) $scope.cr_readonly = false;
		
			}
		});
	}
	
	$scope.inactiveChange = function() {
		
		$scope.$watch('filter', function(n, o) {
			var list = $('input[name^="selectItemmasteroptional"]')[13]; 
			if(n) {
				
				if(n.activestate == 'Inactive') {	
					if(help.in_array('CR_ONLY', n.optional)) {
						$(list).click();
					}
					
					$(list).prop('disabled', true);
					$scope.cr_readonly = false;
					
				} else {
					$(list).prop('disabled', false);
					$scope.cr_readonly = false;
				}
		
			}
		});
		
	}
			
	$scope.grid_fieldsearch = function() {		
		if($scope.grid_table) {
			$scope.grid_table.fnClearTable();
			$scope.grid_table.fnDestroy();  
		}
		  		
		$scope.grandTotal.requestloan_footer  = 0;
		$scope.grandTotal.approvedloan_footer = 0;
		$scope.grandTotal.drawdownloan_footer = 0;
		
		$('.progress').show();
		grid_reload();
	};
	
	$scope.grid_fieldclear  = function() { 
		$scope.filter = {
			application_no: null,
			regional: null,
			areas: null,
			branch: null,
			employee: null,
			optional: null,
			borrowername: null,
			drawdown_mth: null,
			cn_flag: null,
			cashy_yesflag: null,
			cashy_noflag: null,
			producttype: null,
			products: null,
			startdate: null,
			plana2cadate: null,
			a2cadate: null,
			caname: null,
			decisiondate: null,
			decisionstatus: null,
			decisionreason: null,
			plandrawdown: null,
			drawdowndate: null,
			requestloan_start: null,
			requestloan_end: null,
			approvedloan_start: null,
			approvedloan_end: null,
			performnaces: null,
			drawdownloan_start: null,
			drawdownloan_end: null,
			activestate: 'Active',
			pending_option: null
		};
		
		loadMasterRegion()
		.then(function(resp){ return loadMasterArea(resp); })
		.then(function(resp) { return loadMasterBranch(resp); })
		.then(function(resp) {
			$scope.masterdata['branch'] = resp.data;
			return loadMasterEmployee(resp);
		})
		.then(function(resp) { $scope.masterdata['employee'] = resp.data; });
	
	};
	
	$scope.changePerformFieldFilter = function() {
		var checker = $('#performance_cm').is(':checked');
		if(!checker) { $scope.filter.activestate = 'Active'; } 
		else { $scope.filter.activestate = 'All'; }
	}
	
	$scope.changeDDFieldFilter = function() {
		var checker = $('#drawdown_cm').is(':checked');
		if(!checker) { $scope.filter.activestate = 'Active'; } 
		else { $scope.filter.activestate = 'All'; }
	}

	$scope.changeFieldAllAuto = function(val, fieldname) {
		if(val && val.length > 0) {
			
			$scope.filter.activestate = 'All';
			if(help.in_array(fieldname, ['decision_reason'])) {				
				if($scope.filter.decisionreason && $scope.filter.decisionreason.length > 0) {
					$scope.filter.decisionstatus.push('PENDING');			
				}
			}
			
		}	
		
//		if(help.in_array(fieldname, ['decision_status'])) {
//			if(help.in_array(val, ['PENDING']) && val.length === 1) {
//				$('#pending_filter').css({ 'display': 'block' });
//			} else {
//				$('#pending_filter').css({ 'display': 'none' });
//				$scope.filter.pending_option = [];
//			}
//		}
	}
	
	// CORE FUNCTION
	$scope.noti_count = 0;
	function grid_reload() {
		
		var object_regional  = ($scope.filter.regional && $scope.filter.regional.length > 0) ? $scope.filter.regional.join():null;
		var object_areas     = ($scope.filter.areas && $scope.filter.areas.length > 0) ? $scope.filter.areas.join():null;
		var object_branchs   = ($scope.filter.branch && $scope.filter.branch.length > 0) ? $scope.filter.branch.join():null;
		var object_employee  = ($scope.filter.employee && $scope.filter.employee.length > 0) ? $scope.filter.employee.join():null;
		
		// Product
		var product_loan 	 = [];
		var refinances	  	 = [];
		if($scope.filter.producttype && $scope.filter.producttype.length > 0) {
			$.each($scope.filter.producttype, function(index, value) {
				if(help.in_array(value, ['Refinance', 'Non Refinance'])) {
					if(!refinances[0]) product_loan.push('Secure');
					if(value == 'Refinance') refinances.push(1);
					else refinances.push(2);
				} else { product_loan.push('Clean'); }
				
			});
		}
		
		var str_productloan  = (!empty(product_loan[0])) ? product_loan.join():null;
		var str_refinances   = (!empty(refinances[0])) ? refinances.join():null;
		var product_list 	 = ($scope.filter.products && $scope.filter.products.length > 0) ? $scope.filter.products.join():null;
		
		var decision = [];
		if($scope.filter.decisionstatus && $scope.filter.decisionstatus.length > 0) {
			$.each($scope.filter.decisionstatus, function(index, value) {
				if(help.in_array(value, ['CANCEL_BP', 'CANCEL_AP'])) {
					if(!help.in_array(value, decision)) {
						if(value == 'CANCEL_BP') {
							decision.push('CANCELBYRM');
							decision.push('CANCELBYCUS');
						} else {
							decision.push('CANCELBYCA');
							//decision.push('CANCEL');
						}
					}	
					
				} else { decision.push(value); }
				
			});
			
		}
		
		var decision_reason  = null;
		var str_decision	 = (!empty(decision[0])) ? decision.join():null;
		if($scope.filter.decisionreason.length > 0 && $scope.filter.pending_option.length > 0) {
			var marge_data = _.union($scope.filter.decisionreason, $scope.filter.pending_option);
			decision_reason  = (marge_data && marge_data.length > 0) ? marge_data.join() : null;
		} else {
			if($scope.filter.decisionreason.length > 0 && $scope.filter.pending_option.length == 0) {
				decision_reason  = ($scope.filter.decisionreason && $scope.filter.decisionreason.length > 0) ? $scope.filter.decisionreason.join():null;
			}
			
			if($scope.filter.pending_option.length > 0 && $scope.filter.decisionreason.length == 0) {
				decision_reason  = ($scope.filter.pending_option && $scope.filter.pending_option.length > 0) ? $scope.filter.pending_option.join():null;
			}
		}
		  		
		var ca_return  = '';	
		var cr_passion = '';
		var bm_assign  = '';
		var retreieve  = [];
		var refercase  = [];
		var defendflag = [];
		var other_flag = [];
		var loan_glist = [];
		var refer_data = ['Refer: Thai Life', 'Refer: Full Branch', 'Refer: Call Center', 'Tcrb: Facebook', 'Refer: RM', 'Refer: Customer', 'Loan Top Up'];
		var loan_group = ['NN', 'MF', 'SB', 'MF SME'];
		if($scope.filter.optional && $scope.filter.optional.length > 0) {
			$.each($scope.filter.optional, function(index, value) {
				if(help.in_array(value, refer_data)) { refercase.push(value); } 
				else {

					if(help.in_array(value, ['Submit', 'Defend 1', 'CA', 'Defend 2', 'Completed', 'Incompleted', 'CR_ONLY', 'CR_PASS'])) {
						if(help.in_array(value, ['CR_ONLY', 'CR_PASS'])) {
							if(value == 'CR_ONLY') ca_return  = 'Y';
							if(value == 'CR_PASS') cr_passion = 'Y';
					
						} else { defendflag.push(value); }
						
					} else if(help.in_array(value, loan_group)) {
						loan_glist.push(value);
					} else if(help.in_array(value, ['RET', 'REA'])) {
						retreieve.push(value);
					} else if(help.in_array(value, ['BMRefer'])) {
						bm_assign = 'Y';
					} else {
						other_flag.push(value);
					}
					
				}
				
			});
		}

		var str_ca_return	 = (ca_return == 'Y') ? 'Y':null;
		var str_cr_passion	 = (cr_passion == 'Y') ? 'Y':null;
	
		var str_defendflag	 = (!empty(defendflag[0])) ? defendflag.join():null;
		var str_retreieve	 = (!empty(retreieve[0])) ? retreieve.join():null;
		var str_refercase	 = (!empty(refercase[0])) ? refercase.join():null;
		var loan_use_fbank	 = (!empty(loan_glist[0])) ? loan_glist.join():null;
		
		var object_startdate = (!empty($scope.filter.startdate)) ? dataRangeSplit($scope.filter.startdate, 'date_th'):null;
		var object_plana2ca  = (!empty($scope.filter.plana2cadate)) ? dataRangeSplit($scope.filter.plana2cadate, 'date'):null;
		var object_a2cadate  = (!empty($scope.filter.a2cadate)) ? dataRangeSplit($scope.filter.a2cadate, 'date_th'):null;
		var object_decision  = (!empty($scope.filter.decisiondate)) ? dataRangeSplit($scope.filter.decisiondate, 'date_th'):null;
		var object_plandd    = (!empty($scope.filter.plandrawdown)) ? dataRangeSplit($scope.filter.plandrawdown, 'date_th'):null;
		var object_drawdown  = (!empty($scope.filter.drawdowndate)) ? dataRangeSplit($scope.filter.drawdowndate, 'date_th'):null;
		
		var request_loan_set  = dataLoanSetter($scope.filter.requestloan_start, $scope.filter.requestloan_end);
		var approved_loan_set = dataLoanSetter($scope.filter.approvedloan_start, $scope.filter.approvedloan_end);
		var drawdown_loan_set = dataLoanSetter($scope.filter.drawdownloan_start, $scope.filter.drawdownloan_end);

		var borrowername	 = (!empty($scope.filter.borrowername)) ? $scope.filter.borrowername:null;
		var caname	 		 = (!empty($scope.filter.caname)) ? $scope.filter.caname:null;
		
		var cahsy_draft		 = ($scope.filter.cashy_noflag) ? 'N':null;
		var cashy_state		 = ($scope.filter.cashy_yesflag) ? 'Y':cahsy_draft;
			
		var param = {
			AuthCode: $scope.auth_code,
			RegionCode: object_regional,
			AreaCode: object_areas,
			BranchCode: object_branchs,
			RMCode: object_employee,
			BorrowerName: borrowername,
			LoanType: str_productloan,
			Refinance: str_refinances,
			ProductProgram: product_list,
			BankList: loan_use_fbank,			
			CAName: caname,
			Status: str_decision,
			StatusReason: decision_reason,
			StartDate: (!empty(object_startdate)) ? object_startdate[0]:null,
			EndDate: (!empty(object_startdate)) ? object_startdate[1]:null,
			PlanA2CA_StartDate: (!empty(object_plana2ca)) ? object_plana2ca[0]:null,
			PlanA2CA_EndDate: (!empty(object_plana2ca)) ? object_plana2ca[1]:null,
			A2CA_StartDate: (!empty(object_a2cadate)) ? object_a2cadate[0]:null,
			A2CA_EndDate: (!empty(object_a2cadate)) ? object_a2cadate[1]:null,
			Decision_StartDate: (!empty(object_decision)) ? object_decision[0]:null,
			Decision_EndDate: (!empty(object_decision)) ? object_decision[1]:null,
			DDPlan_StartDate: (!empty(object_plandd)) ? object_plandd[0]:null,
			DDPlan_EndDate: (!empty(object_plandd)) ? object_plandd[1]:null,
			Drawdown_StartDate: (!empty(object_drawdown)) ? object_drawdown[0]:null,
			Drawdown_EndDate: (!empty(object_drawdown)) ? object_drawdown[1]:null,
			Request_StartLoan: (!empty(request_loan_set)) ? request_loan_set[0]:null,
			Request_EndLoan: (!empty(request_loan_set)) ? request_loan_set[1]:null,
			Approved_StartLoan: (!empty(approved_loan_set)) ? approved_loan_set[0]:null,
			Approved_EndLoan: (!empty(approved_loan_set)) ? approved_loan_set[1]:null,
			Drawdown_StartLoan: (!empty(drawdown_loan_set)) ? drawdown_loan_set[0]:null,
			Drawdown_EndLoan: (!empty(drawdown_loan_set)) ? drawdown_loan_set[1]:null,
			Referal_Flag: str_refercase,
			Defend_Flag: str_defendflag,
			CeditReturn_Flag: str_ca_return,
			PostponePlanA2CA: str_cr_passion,
			RET_Flag: str_retreieve,
			REA_Flag: null, 
			Drawdown_Flag: ($scope.filter.drawdown_mth) ? 'Y':null,
			CN_Flag: ($scope.filter.cn_flag) ? 'Y':null,
			Cashy_Flag: cashy_state,
			MRTA_Flag: $scope.filter.application_no,
			PlanDDUnknow_Flag: null,
			ReferByBM_Flag: (bm_assign == 'Y') ? 'Y':null, 
			SourceOfCustomer: ($scope.filter.performnaces) ? 'DD_PERFORMANCE':null,
			ReferalCode: null,
			PostponePlanA2CA: str_cr_passion,
			ActiveRecord: (help.in_array($scope.filter.activestate, ['Active', 'Inactive'])) ? $scope.filter.activestate:null
		};
		
		$('.progress').hide();
		$('title').text('Whiteboard');
	
		help.loadGridWhiteboard(param).then(function(responsed) {
			var item_list 	= [];
			var data_object = (responsed.data) ? responsed.data:0;
			if(data_object.length > 0) {
				
				var requestloan_grandTotal  = 0;
				var approvedloan_grandTotal = 0;
				var drawdownloan_grandTotal = 0;
				
				$.each(data_object, function(index, value) {
					
					var rmonhand_timing = number_verify(value.RMOnhandCount);
					var caonhand_timing = number_verify(value.CAOnhandCount);
					var drawdown_timing = number_verify(value.CADecisionCount);
					var total_dayusage  = number_verify((rmonhand_timing + caonhand_timing + drawdown_timing));
				
					var status_digit = (value.Status && value.Status !== '') ? value.Status:''
					var status_desc = (value.StatusDesc && value.StatusDesc !== '') ? value.StatusDesc:''
					var status_reason =  (value.StatusReason && value.StatusReason !== '') ? value.StatusReason:''
					
					// Set Grid fa fa-commenting-o nav_icon marginLeft5
					item_list.push({
						DocID: value.DocID,
						AppNo: value.ApplicationNo,
						StartDate: (value.StartDate) ? moment(value.StartDate).format('DD/MM/YYYY'):'',
						ResetState: (value.LatestProfileReset) ? value.LatestProfileReset:'',
						OverallDay: period_state(total_dayusage),
						BorrowerName: value.BorrowerName,
						RMName: value.RMName,
						LBName: lb_info(value.BranchDigit, value),
						Bank:  value.Bank,
						Product: setProductTooltip(value.ProductTypes, value, true),// setProductTooltip(reforge_product(value.ProductCode), value, true),
						RequestLoan: value.RequestLoan,
						RMOnhandCount: period_state(rmonhand_timing),
						A2CADate: a2cadate_workflow(value),
						CAName: value.CAName,
						Status: status_workflow(value),
						StatusDesc: status_digit,
						StatusReason: (help.in_array(status_digit, ['SA', 'SR', 'SI'])) ? status_desc:status_reason,
						StatusDate: (value.StatusDate) ? moment(value.StatusDate).format('DD/MM/YYYY'):'',
						CAReturnDateLog: (value.CAReturnDateLog) ? moment(value.CAReturnDateLog).format('DD/MM/YYYY'):'',
						ApprovedLoan: value.ApprovedLoan,
						CAOnhandCount: period_state(caonhand_timing),
						PlanDrawdownDate: (value.PlanDrawdownDate) ? moment(value.PlanDrawdownDate).format('DD/MM/YYYY'):'',
						DrawdownDate: drawdownInstallment(value, 'date'),
						DrawdownVolum: value.DrawdownBaht,
						DrawdownCount: period_state(drawdown_timing),
						ActionNote: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + value.ActionNote,
						ActionNoteNormal: value.ActionNote,
						HasActionNote: (value.ActionNote && value.ActionNote !== "") ? 'Y':'N',
						ProfileLink: onProfileLinker(value.DocID),
						LatestAppProgress: value.LatestAppProgress,
						PlanDateUnknown: value.PlanDateUnknown,
						objectsItem: data_object[index],
					});
					
					requestloan_grandTotal  += number_verify(value.RequestLoan);
					approvedloan_grandTotal += (value.ApprovedLoan) ? number_verify(value.ApprovedLoan):number_verify(value.PreLoan);
					drawdownloan_grandTotal += (status_digit == 'A') ? number_verify(value.DrawdownBaht) : 0;
				
				});
			
				$scope.data_item  = item_list;
				$scope.grandTotal.requestloan_footer  = requestloan_grandTotal;
				$scope.grandTotal.approvedloan_footer = approvedloan_grandTotal;
				$scope.grandTotal.drawdownloan_footer = drawdownloan_grandTotal;
		
			} else { 
				//Notification.error('เกิดข้อผิดพลาดในการรับข้อมูลจากเซิฟเวอร์');
				Notification.error('ไม่พบข้อมูลที่ต้องการค้นหา... ');
				
				if($scope.filter.activestate == 'Active') {
					if($scope.noti_count == 0) {
						setTimeout(function() { Notification.error('ระบบแนะนำการใช้งานในการค้นหาข้อมูล โดยการใช้โหมด All'); }, 1000);
						$scope.noti_count = $scope.noti_count + 1;
					}
				}
				
				if($scope.noti_count == 1) {
					if($scope.filter.activestate == 'All') {
						setTimeout(function() { Notification.error('ข้อมูลที่ท่านต้องการจะค้นหาอาจจะไม่ตรงกับข้อมูลในระบบ กรุณาตรวจสอบใหม่อีกครั้ง...'); }, 1000);
						$scope.noti_count = $scope.noti_count + 1;
					}
				}
				
				if($scope.noti_count >= 2) $scope.noti_count = 0;
				
			}
			
			$('.progress').hide();
			$('title').text('Whiteboard');
			
		});
	
	}
	
	// MODAL HANDLED
	$scope.openFileOwnershipDoc = function(object_data) {
	
		if(object_data.Status && help.in_array(object_data.Status, ['P', 'A'])) {
			
			var open_modal = false;
			if(help.in_array(object_data.Status, ['A']) && object_data.OwnershipDoc == 'N') open_modal =  false;
			else open_modal =  true;
			
			if(open_modal) {
				var missing_count = null;
				help.GetMissingDocItemList(object_data.DocID).then(function(responsed) {
					missing_count = responsed.data;
					var modalInstance = $uibModal.open({
				        animation: true,
				        templateUrl: 'modalDocument.html',
				        controller: 'ctrlPDFOwnershipDoc',
				        size: 'md',
				        windowClass: 'modal-fullscreen animated zoomIn',
				        resolve: {
				        	items: function () { return object_data; },
				        	missingdoc: function() { return missing_count; }
				        }
				    });
					
				});
			}

		}

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

	$scope.opensidebar = function() {
		var talbe_height = $('#grid_whiteboard').height();
		
		$('#sidenav_container').css('width', '400px').removeClass('close').addClass('open');
		$('#sidenav_container').css('height', parseInt(talbe_height) + ((talbe_height <= 160) ? 700:200));
		$('#grid_main').css('margin-left', '400px');	
		$('#sidebar_icon').removeClass('closeside').addClass('openside');
		$('.content').removeClass('close').addClass('open');
		
		/*
		var table_width = $('#grid_whiteboard').width();
		$('#grid_whiteboard').css('width', parseInt(table_width) + 400);
		*/
		var parent_filter = $('#panel_criteria').width();
		$('#panel_criteria').css({ 'width': (parseInt(parent_filter)) });
	}

	$scope.closesidebar = function() {
				
		if($('.sidenav').hasClass('open')) {
			/*
			var table_width = $('#grid_whiteboard').width();
			$('#grid_whiteboard').css('width', '1420px');
			*/
			var parent_filter = $('#panel_criteria').width();
			$('#panel_criteria').css({ 'width': (parseInt(parent_filter)) });
			
			$('#sidenav_container').css('width', '0px').removeClass('open').addClass('close');
			$('#grid_main').css('margin-left', '0px');
			$('#sidebar_icon').removeClass('openside').addClass('closeside');
			$('.content').removeClass('open').addClass('close');
			
		}
	}
	
	$scope.loadEmpProfile = function() {
		$scope.$watch('filter', function(n) {
			if(n) {
				if(n.employee && n.employee.length > 0) {
					 loadProfile(n.employee[0]);
				} else {
					$('.using_information').html('');
				}
			}
		})
	}
	
	function loadProfile(condition) {		
		// Profile
		if(condition) {
			$.ajax({
			   url: 'http://172.17.9.94/pcisservices/PCISService.svc/GetKPI00ProfileReport',
		       data: { RMCode: condition },
		       type: "GET",
		       jsonpCallback: "my_profile",
		       dataType: "jsonp",
		       crossDomain: true,
			   beforeSend:function() {},
		       success: function (responsed) {    	   
		    	   var result = responsed.Data;
	
		    	   if (result.length > 0) {
		        	   
		    		   var position = (result[0].PositionNameEng) ? result[0].PositionNameEng:'';
		        	   var corp		= result[0].BranchNameEng + ' (Period ' + result[0].WorkingYMD + ')';
		        	   var mobile	= result[0].Mobile + ' (' + result[0].Nickname + ')';
		        	   
		        	   var html = 
			           '<div id="using_picture" class="crop_nav">' +
			   				'<img src="' + result[0].UserImagePath + '" />' +
			   		   '</div>' +        			
			   		   '<div class="using_desc marginLeft5">' +	   		   		
			   		   		'<span class="fg-white" style="font-size: 0.8em;"><b class="tooltip-bottom" data-tooltip="' + mobile + '">' + result[0].FullNameEng.toUpperCase() + '</b> (' + position + ') </span> <br />' +
			   				'<span id="using_period" class="fg-white" style="position: absolute; margin-top: -10px;"><small>' + corp + '</small></span>' +
			   		   '</div>';  
		        	   		        
		        	   $('.using_information').html('');
		        	   $(html).hide().appendTo(".using_information").fadeIn(1000).after(function() {
		        		   var picture = $('#using_picture').width();
		        		   var periods = $('#using_period').width();
		        		   $('.using_information').css('min-width', (periods + picture));		        		   
		        	   });

		           }
		       },
		       error: function (error) {}
		       
		   });
		}
	}

	// PROCESS REFORGE
	function onProfileLinker(DocID) {
		if(!empty(DocID)) {
			var profile_link = pathFixed + 'management/getDataVerifiedPreview?mod=1&cache=false&secure=c4ca4238a0b923820dcc509a6f75849b&rel=' + DocID + '&req=P2&live=2&t=53&whip=true&clw=false';
			return '<a href="' + profile_link + '" target="_blank" class="print_hold"><i class="icon-new-tab"></i></a>';
		} else { return ''; }
	}
	
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
	
	function setProductTooltip(str, objects, mode) {
		var str_style	 = '';
		var str_element  = '';
		
		if(mode) {
		
			var str_toolip = (objects.ProductName) ? '(' + str + ') ' + objects.ProductName:null;
			if(str_toolip && str_toolip != '') {
				str_element = '<span webui-tooltip-bundle config="webuiConfigBundle" data-content="' + str_toolip + '" class="iconCursor">' + str + '</span>';
			} else {
				str_element = str;
			}
			
		} else { str_element = str; }
		
		return str_element;
	}
	
	function a2cadate_workflow(object_data) {
		
		var latest_date  = (object_data.LatestAppProgressDate) ? moment(object_data.LatestAppProgressDate).format('DD/MM/YYYY'):null;
		var postpone_doc = (object_data.PlanPostponeCount > 0) ? object_data.PlanPostponeCount:1;
	
		if(!empty(latest_date)) {
			
			var date_style	= "";
			var str_element = "";
			var latest_progress = (!empty(object_data.LatestAppProgress)) ? object_data.LatestAppProgress:'';
			
			switch(latest_progress) {
				case 'A2CA':
					date_tyle 	= 'color: #4a8e07; font-weight: normal;';
					str_element = '<span style="' + date_tyle + '">' + latest_date + '</span>';
				break;
				case 'HO2CA':
					date_tyle   = 'color: rgb(35, 84, 188); font-weight: normal;';
					str_element = '<span style="' + date_tyle + '">' + latest_date + '</span>';
				break;				
				case 'Plan':
					
					if(postpone_doc == 1) {
						date_tyle = 'background-color: #D1D1D1; border: 1px dotted red; padding: 2px; font-weight: bold;';
					} else if(postpone_doc == 2) {
						date_tyle = 'background-color: #E3C800; border: 1px dotted red; padding: 2px; font-weight: bold; margin: 3px 0;';
					} else if(postpone_doc >= 3) {
						date_tyle = 'background-color: #f16464; color: #000; border: 1px dotted #000; padding: 2px; font-weight: bold;';
					}
				
					str_element = '<span style="' + date_tyle + '">' + latest_date + '</span>';
					
				break;
				case '':
				case 'HOReceived':
				default:
					str_element = latest_date;
				break;
			}
	
			return str_element;
			
		} else { return ''; }
		
	}

	function status_workflow(object_data) {
		var appraisalchk  = (object_data.TotalDayCount == 'Y' || parseInt(object_data.TotalDayCount) == 1) ? 'Y':'N';
		var decision_aip  = (object_data.IsAIP == 'Y') ? object_data.IsAIP:'';
		var fileEstimate  = (object_data.ReceivedEstimateDoc == 'Y') ? object_data.ReceivedEstimateDoc:'';
		var ownership_doc = (object_data.OwnershipDoc == 'Y') ? object_data.OwnershipDoc:'';
		var decision	  = (object_data.Status) ? object_data.Status:'';
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
								
							}
							else if(appraisalchk == 'Y') { 
								str_style   = 'padding: 3px 7px; border-radius: 50%; background: #199a11; color: white; cursor: pointer;';
								str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
								
							} 
//							else if(decision_aip == 'Y') { 
//								str_style   = 'padding: 3px 7px; border-radius: 50%; background: #4390DF; color: white;';
//								str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
//								
//							} 
							else { str_element = decision; }	
							
						} else { str_element = decision; }

					}
					
				} else {
			
					if(decision == 'P') {
						
						if(fileEstimate == 'Y') { 
							str_style   = 'padding: 3px 7px; border-radius: 50%; background: #fa6800; color: white; cursor: pointer;';
							str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
							
						} 
						else if(appraisalchk == 'Y') { 
							str_style   = 'padding: 3px 7px; border-radius: 50%; background: #199a11; color: white;';
							str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
							
						} 
//						else if(decision_aip == 'Y') { 
//							str_style   = 'padding: 3px 7px; border-radius: 50%; background: #4390DF; color: white;';
//							str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
//							
//						} 
						else { str_element = decision; }	
						
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
					
		} else { return ''; }
		
	}
	
	function drawdownInstallment(object_data, formatter) {
		var str_style	 = '';
		var str_element  = '';			
		var str_install  = '';
		
		if(formatter == 'date') { 
			str_install  = (!empty(object_data.DrawdownDate)) ? moment(object_data.DrawdownDate).format('DD/MM/YYYY'):''; 
		} else if(formatter == 'amount') {
			str_install  = (!empty(object_data.DrawdownBaht)) ? $filter('number')(checkNum(object_data.DrawdownBaht), 0):0;	
		}
		
		var doc_id  = (!empty(object_data.DocID)) ? object_data.DocID:'';;
		if(object_data.Installment == 'Y') {
			str_style   = 'background-color: #D1D1D1; border: 1px dotted red; padding: 2px; font-weight: bold;';
			str_element = '<span webui-tooltip config="webuiConfig" data="' + doc_id + '" class="iconCursor" style="' + str_style + '">' + str_install + '</span>';
			
		} else { str_element = str_install; }	

		return str_element;
		
	}
	
	function lb_info(lbName, object_data) {
		var str_style	 = '';
		var str_element  = '';		
	
		var str_toolip = (object_data.BranchName) ? object_data.BranchName + '/' + object_data.BranchTel:null;
		if(str_toolip && str_toolip != '') {
			str_element = '<span webui-tooltip-bundle config="webuiConfigBundle" data-content="' + str_toolip + '" class="iconCursor">' + lbName + '</span>';
		} else {
			str_element = lbName;
		}
		
		return str_element;
		
	}
	
	// FUNCTION
	function isEmpty(objVal) {
		if(objVal && objVal !== "" || objVal !== undefined) return objVal;
		else return null;
    }

    function empty(objVal) {
		if(isEmpty(objVal)) return false;
		else return true;
    }
    
	function number_verify(objVal) {
    	if(objVal && !isNaN(objVal) && objVal !== "") return parseInt(objVal);
    	else return 0;
    }
	
	function checkNum(objVal) {
		if(objVal && objVal !== "" && objVal > 0) return parseInt(objVal);
	    else return 0;
	}

	function period_state($nums) {       
        if($nums !== null && $nums !== undefined) {     	
        	if($nums <= 10) { return '<span class="fg-emerald">' + $nums + '</span>'; }
        	else if($nums >= 11 && $nums <= 20){ return '<span class="fg-amber">' + $nums + '</span>'; }
        	else if($nums >= 21) { return '<span class="fg-red">' + $nums + '</span>'; }
        } else { return ''; }
    	
    }
	
	function dataRangeSplit(object_data, formatter) {
		Date.prototype.toMSJSON = function () {
		    var date = '/Date(' + this.getTime() + ')/'; //CHANGED LINE
		    return date;
		};
		
		var pattern 	   	    = new RegExp("-");	
		var check_pattern 	    = pattern.test(object_data);

		var start_data			= null, 
			end_data 		    = null;
		
		if(check_pattern) {
			var item   	        = object_data.split("-");
			start_data          = item[0].trim();
			end_data	   	    = item[1].trim();

		} else { 
			start_data	   		= object_data 
			end_data			= object_data
		}
		
		if(formatter == 'date_th') {
			var date_1 = new Date(moment(start_data, 'DD/MM/YYYY').format('YYYY-MM-DD')).toMSJSON();
			var date_2 = new Date(moment(end_data, 'DD/MM/YYYY').format('YYYY-MM-DD')).toMSJSON();
			return [date_1, date_2];
		} if(formatter == 'date') {
			var date_1 = moment(start_data, 'DD/MM/YYYY').format('YYYY-MM-DD');
			var date_2 = moment(end_data, 'DD/MM/YYYY').format('YYYY-MM-DD');
			return [date_1, date_2];
		} else {
			return [start_data, end_data];
		}

	}
	
	function dataLoanSetter(loanField1, loanField2) {
		if((loanField1 && loanField1 > 0) && (loanField2 && loanField2 > 0)) {
			return [loanField1, loanField2].sort();
		} else {
			if(loanField1 > 0 && !loanField2) { return [loanField1, loanField1].sort(); } 
			if(loanField1 > 0 && loanField2 == 0) { return [loanField1, loanField1].sort(); } 
			else if(loanField2 > 0 && !loanField1) { return [loanField2, loanField2].sort(); } 
			else if(loanField2 > 0 && loanField1 == 0) { return [loanField2, loanField2].sort(); } 
			else { return null; }
		}
	}
	
	function sortByKey(array, key) {
        return array.sort(function(a, b) {
            var x = a[key]; var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }
	
	// PRINT PREVIEW HANDLE 
	$scope.print_whiteboard = function() {
	
		$('.progress').show();
		
		var object_regional  = ($scope.filter.regional && $scope.filter.regional.length > 0) ? $scope.filter.regional.join():null;
		var object_areas     = ($scope.filter.areas && $scope.filter.areas.length > 0) ? $scope.filter.areas.join():null;
		var object_branchs   = ($scope.filter.branch && $scope.filter.branch.length > 0) ? $scope.filter.branch.join():null;
		var object_employee  = ($scope.filter.employee && $scope.filter.employee.length > 0) ? $scope.filter.employee.join():null;
		
		// Product
		var product_loan 	 = [];
		var refinances	  	 = [];
		if($scope.filter.producttype && $scope.filter.producttype.length > 0) {
			$.each($scope.filter.producttype, function(index, value) {
				if(help.in_array(value, ['Refinance', 'Non Refinance'])) {
					if(!refinances[0]) product_loan.push('Secure');
					if(value == 'Refinance') refinances.push(1);
					else refinances.push(2);
				} else { product_loan.push('Clean'); }
				
			});
		}
		
		var str_productloan  = (!empty(product_loan[0])) ? product_loan.join():null;
		var str_refinances   = (!empty(refinances[0])) ? refinances.join():null;
		var product_list 	 = ($scope.filter.products && $scope.filter.products.length > 0) ? $scope.filter.products.join():null;
		
		var decision = [];
		if($scope.filter.decisionstatus && $scope.filter.decisionstatus.length > 0) {
			$.each($scope.filter.decisionstatus, function(index, value) {
				if(help.in_array(value, ['CANCEL_BP', 'CANCEL_AP'])) {
					if(!help.in_array(value, decision)) {
						if(value == 'CANCEL_BP') {
							decision.push('CANCELBYRM');
							decision.push('CANCELBYCUS');
						} else {
							decision.push('CANCELBYCA');
							//decision.push('CANCEL');
						}
					}	
					
				} else { decision.push(value); }
				
			});
			
		}
		
		//var str_decision	 = (!empty(decision[0])) ? decision.join():null;
		//var decision_reason  = ($scope.filter.decisionreason && $scope.filter.decisionreason.length > 0) ? $scope.filter.decisionreason.join():null;
		
		var decision_reason  = null;
		var str_decision	 = (!empty(decision[0])) ? decision.join():null;
		if($scope.filter.decisionreason.length > 0 && $scope.filter.pending_option.length > 0) {
			var marge_data = _.union($scope.filter.decisionreason, $scope.filter.pending_option);
			decision_reason  = (marge_data && marge_data.length > 0) ? marge_data.join() : null;
		} else {
			if($scope.filter.decisionreason.length > 0 && $scope.filter.pending_option.length == 0) {
				decision_reason  = ($scope.filter.decisionreason && $scope.filter.decisionreason.length > 0) ? $scope.filter.decisionreason.join():null;
			}
			
			if($scope.filter.pending_option.length > 0 && $scope.filter.decisionreason.length == 0) {
				decision_reason  = ($scope.filter.pending_option && $scope.filter.pending_option.length > 0) ? $scope.filter.pending_option.join():null;
			}
		}
	
		var ca_return  = '';
		var cr_passion = '';
		var bm_assign  = '';
		var retreieve  = [];
		var refercase  = [];
		var defendflag = [];
		var other_flag = [];
		var refer_data = ['Refer: Thai Life', 'Refer: Full Branch', 'Refer: Call Center', 'Tcrb: Facebook', 'Refer: RM', 'Refer: Customer'];
		if($scope.filter.optional && $scope.filter.optional.length > 0) {
			$.each($scope.filter.optional, function(index, value) {
				if(help.in_array(value, refer_data)) { refercase.push(value); } 
				else {

//					if(help.in_array(value, ['Submit', 'Defend 1', 'CA', 'Defend 2', 'Completed', 'Incompleted', 'CR'])) {
//					if(value == 'CR') { ca_return = 'Y' } 
					if(help.in_array(value, ['Submit', 'Defend 1', 'CA', 'Defend 2', 'Completed', 'Incompleted', 'CR_ONLY', 'CR_PASS'])) {
						if(help.in_array(value, ['CR_ONLY', 'CR_PASS'])) {
							if(value == 'CR_ONLY') ca_return  = 'Y';
							if(value == 'CR_PASS') cr_passion = 'Y';
							
						} else { defendflag.push(value); }
						
					} else if(help.in_array(value, ['RET', 'REA'])) {
						retreieve.push(value);
					} else if(help.in_array(value, ['BMRefer'])) {
						bm_assign = 'Y';
					} else {
						other_flag.push(value);
					}
					
				}
				
			});
		}
		
		var str_ca_return	 = (ca_return == 'Y') ? 'Y':null;
		var str_cr_passion	 = (cr_passion == 'Y') ? 'Y':null;
		var str_defendflag	 = (!empty(defendflag[0])) ? defendflag.join():null;
		var str_retreieve	 = (!empty(retreieve[0])) ? retreieve.join():null;
		var str_refercase	 = (!empty(refercase[0])) ? refercase.join():null;
		
		var object_startdate = (!empty($scope.filter.startdate)) ? dataRangeSplit($scope.filter.startdate, 'date_th'):null;
		var object_plana2ca  = (!empty($scope.filter.plana2cadate)) ? dataRangeSplit($scope.filter.plana2cadate, 'date'):null;
		var object_a2cadate  = (!empty($scope.filter.a2cadate)) ? dataRangeSplit($scope.filter.a2cadate, 'date_th'):null;
		var object_decision  = (!empty($scope.filter.decisiondate)) ? dataRangeSplit($scope.filter.decisiondate, 'date_th'):null;
		var object_plandd    = (!empty($scope.filter.plandrawdown)) ? dataRangeSplit($scope.filter.plandrawdown, 'date_th'):null;
		var object_drawdown  = (!empty($scope.filter.drawdowndate)) ? dataRangeSplit($scope.filter.drawdowndate, 'date_th'):null;
		
		var request_loan_set  = dataLoanSetter($scope.filter.requestloan_start, $scope.filter.requestloan_end);
		var approved_loan_set = dataLoanSetter($scope.filter.approvedloan_start, $scope.filter.approvedloan_end);
		var drawdown_loan_set = dataLoanSetter($scope.filter.drawdownloan_start, $scope.filter.drawdownloan_end);

		
		var borrowername	 = (!empty($scope.filter.borrowername)) ? $scope.filter.borrowername:null;
		var caname	 		 = (!empty($scope.filter.caname)) ? $scope.filter.caname:null;
		
		var cahsy_draft		 = ($scope.filter.cashy_noflag) ? 'N':null;
		var cashy_state		 = ($scope.filter.cashy_yesflag) ? 'Y':cahsy_draft;		
		var orderby_field	 = ($scope.grid_table) ? $scope.grid_table.fnSettings().aaSorting:null;
	
		var param = {
			AuthCode: $scope.auth_code,
			RegionCode: object_regional,
			AreaCode: object_areas,
			BranchCode: object_branchs,
			RMCode: object_employee,
			BorrowerName: borrowername,
			LoanType: str_productloan,
			Refinance: str_refinances,
			ProductProgram: product_list,
			BankList: null,			
			CAName: caname,
			Status: str_decision,
			StatusReason: decision_reason,
			StartDate: (!empty(object_startdate)) ? object_startdate[0]:null,
			EndDate: (!empty(object_startdate)) ? object_startdate[1]:null,
			PlanA2CA_StartDate: (!empty(object_plana2ca)) ? object_plana2ca[0]:null,
			PlanA2CA_EndDate: (!empty(object_plana2ca)) ? object_plana2ca[1]:null,
			A2CA_StartDate: (!empty(object_a2cadate)) ? object_a2cadate[0]:null,
			A2CA_EndDate: (!empty(object_a2cadate)) ? object_a2cadate[1]:null,
			Decision_StartDate: (!empty(object_decision)) ? object_decision[0]:null,
			Decision_EndDate: (!empty(object_decision)) ? object_decision[1]:null,
			DDPlan_StartDate: (!empty(object_plandd)) ? object_plandd[0]:null,
			DDPlan_EndDate: (!empty(object_plandd)) ? object_plandd[1]:null,
			Drawdown_StartDate: (!empty(object_drawdown)) ? object_drawdown[0]:null,
			Drawdown_EndDate: (!empty(object_drawdown)) ? object_drawdown[1]:null,
			Request_StartLoan: (!empty(request_loan_set)) ? request_loan_set[0]:null,
			Request_EndLoan: (!empty(request_loan_set)) ? request_loan_set[1]:null,
			Approved_StartLoan: (!empty(approved_loan_set)) ? approved_loan_set[0]:null,
			Approved_EndLoan: (!empty(approved_loan_set)) ? approved_loan_set[1]:null,
			Drawdown_StartLoan: (!empty(drawdown_loan_set)) ? drawdown_loan_set[0]:null,
			Drawdown_EndLoan: (!empty(drawdown_loan_set)) ? drawdown_loan_set[1]:null,
			Referal_Flag: str_refercase,
			Defend_Flag: str_defendflag,
			CeditReturn_Flag: str_ca_return,
			RET_Flag: str_retreieve,
			REA_Flag: 'PRINT', 
			Drawdown_Flag: ($scope.filter.drawdown_mth) ? 'Y':null,
			CN_Flag: ($scope.filter.cn_flag) ? 'Y':null,
			Cashy_Flag: cashy_state,
			MRTA_Flag: $scope.filter.application_no,			
			ReferByBM_Flag: (bm_assign == 'Y') ? 'Y':null, 
			SourceOfCustomer: ($scope.filter.performnaces) ? 'DD_PERFORMANCE':null,
			ReferalCode: orderby_field[0][0],
			PlanDDUnknow_Flag: orderby_field[0][1],
			PostponePlanA2CA: str_cr_passion,
			ActiveRecord: (help.in_array($scope.filter.activestate, ['Active', 'Inactive'])) ? $scope.filter.activestate:null
		};
		
		help.loadGridWhiteboard(param).then(function(responsed) {
			$('.progress').hide();
			var data = (responsed.data) ? responsed.data:0;
			if(data && data.length > 0) {
				var popupWin = window.open('', '_blank', 'position: absolute, width=auto,height=auto,left=0,top=0');

            	var path_root	 = window.location.protocol + "//" + window.location.host + '/pcis/';
            	var boostrap_css = '<link rel="stylesheet" href="' + path_root + 'css/responsive/bootstrap.min.css">' +
            					   '<link rel="stylesheet" href="' + path_root + 'css/jquery-ui/jquery-ui.min.css">';
		            	
				var style_detail = '<link rel="stylesheet" href="' + path_root + 'css/custom/element-color-theme.css">' + 
								   '<link rel="stylesheet" href="' + path_root + 'css/metro/iconFont.css">' +
								   '<link rel="stylesheet" href="' + path_root + 'css/themify-icons.css">' +
							 	   '<link rel="stylesheet" href="' + path_root + 'css/flaticon/flaticon.css">' +
							       '<link rel="stylesheet" href="' + path_root + 'css/awesome/css/font-awesome.min.css">' + 
								   '<link rel="stylesheet" href="' + path_root + 'css/custom/whiteboard_printcss.css?v=007">';

				var table 	 = '';
				var thead	 = '';
				var tbody	 = '';
				var tfoot	 = '';
				var content  = '';
			
				thead = '<tr class="tableHeader">' +
						    '<th colspan="2">DATE</th>' +
						    '<th colspan="4">NAME</th>' +
						    '<th colspan="3">LOAN REQUEST</th>' +
						    '<th colspan="2">APP TO CA</th>' +
						    '<th colspan="4">STATUS ( P / A / R / C ) & CR</th>' +
						    '<th colspan="4">DRAWDOWN DATE</th>' +
						    '<th rowspan="2">ACTION NOTE</th>' +
						'</tr>' +
						'<tr class="tableHeader">' +
						    '<th>START</th>' +
						    '<th><i class="fa fa-flag-o print_hold"></i></th>' +
						    '<th>CUSTOMER</th>' +
						    '<th>RM</th>' +
						    '<th>CASHY</th>' +
						    '<th>LB</th>' +
						    '<th>PG</th>' +
						    '<th>AMT</th>' +
						    '<th><i class="fa fa-flag-o print_hold"></i></th>' +
						    '<th>DATE</th>' +
						    '<th>NAME</th>' +
						    '<th>ST</th>' +
						    '<th>DATE</th>' +
						    '<th>AMT</th>' +
						    '<th><i class="fa fa-flag-o print_hold"></i></th>' +
						    '<th>PLAN</th>' +
						    '<th>ACTUAL</th>' +
						    '<th>AMT</th>' +
						    '<th class="fixed"><i class="fa fa-flag-o print_hold"></i></th>' +     
						'</tr>';
				
				if(data.length > 0) {

					//if(!empty(str_decision)) { var result_set = sortByKey(data, '_StatusDate'); } 
					//else if(object_areas) { var result_set = sortByKey(data, 'RMCode'); } 
					//else { var result_set = sortByKey(data, '_StartDate'); }
			
					var toal_request_loan 	= 0;
					var total_approved_loan = 0;
					var total_drawdown_loan = 0;
					
					$.each(data, function(index, value) {

						var plana2ca_count	  = (value.PlanPostponeCount) ? value.PlanPostponeCount:'';
						var ca_status	  	  = (value.Status) ? value.Status:'';

						var plana2ca_date 	  = (value.PlanDocToCACondition) ? moment(value.PlanDocToCACondition).format('YYYY-MM-DD'):'';
						var a2ca_date	  	  = (value.CA_ReceivedDocDate) ? moment(value.CA_ReceivedDocDate).format('YYYY-MM-DD'):'';
						var status_date	  	  = (value.StatusDate) ? moment(value.StatusDate).format('YYYY-MM-DD'):'';
						var drawdown_date 	  = (value.DrawdownDate) ? moment(value.DrawdownDate).format('YYYY-MM-DD'):'';

						var request_loan  	  = (value.RequestLoan) ? parseInt(value.RequestLoan):'';
						var approved_loan 	  = (value.ApprovedLoan) ? parseInt(value.ApprovedLoan): ((value.PreLoan) ? parseInt(value.PreLoan):'');
						var drawdown_loan 	  = (ca_status == 'A' && value.DrawdownBaht) ? parseInt(value.DrawdownBaht):'';
						
						var action_note		  = (!empty(value.ActionNote)) ? value.ActionNote:'';
						var str_action_note	  = actionote_cutoff(action_note);
						
						var request_numformat  = (value.RequestLoan) ? $.number(value.RequestLoan, 0):'';
						var approve_numformat  = (value.ApprovedLoan) ? $.number(value.ApprovedLoan, 0): ((value.PreLoan) ? $.number(value.PreLoan, 0):'');
						var drawdown_numformat = (ca_status == 'A' && value.DrawdownBaht) ? $.number(value.DrawdownBaht, 0):'';

						var rm_onhand_sla 	  = (value.RMOnhandCount) ? value.RMOnhandCount:0;
						var decision_sla  	  = (value.CAOnhandCount) ? value.CAOnhandCount:0;
						var drawdown_sla  	  = (value.CADecisionCount) ? value.CADecisionCount:0;
						var total_sla	  	  = 0;

						total_sla		  	  = (checkNum(rm_onhand_sla) + checkNum(decision_sla) + checkNum(drawdown_sla) );

						toal_request_loan 	  += parseInt(checkNum(request_loan));
						total_approved_loan	  += parseInt(checkNum(approved_loan));
						total_drawdown_loan	  += parseInt(checkNum(drawdown_loan));
						
						tbody += 
						'<tr>' +
						    '<td class="text-center">' + moment(value.StartDate).format('DD/MM/YYYY') + '</td>' +
						    '<td class="text-center">' + period_state(total_sla) + '</td>' +
						    '<td class="text-left">' + divisionLayar(value.BorrowerName, value, 'borrower') + '</td>' +
						    '<td class="text-left">' + divisionLayar(value.RMName, value, 'BMRefer') + '</td>' +
						    '<td class="text-center">' + divisionLayar(value.Cashy, value, 'cashy') + '</td>' +
						    '<td class="text-center">' + divisionLayar(value.BranchDigit, value, 'branch') + '</td>' +
						    '<td class="text-center">' + divisionLayar(reforge_product(value.ProductCode), value, 'product') + '</td>' +
						    '<td class="text-right">' + request_numformat + '</td>' +						   
							'<td class="text-center">' + period_state(value.RMOnhandCount) + '</td>' +
						    '<td class="text-center">' + divisionLayar('', value, 'a2ca') + '</td>' +
						    '<td class="text-left">' + divisionLayar(value.CAName, value, 'defend') + '</td>' +
						    '<td class="text-center">' + divisionLayar(value.Status, value, 'status') + '</td>' +
						    '<td class="text-center">' + ((value.StatusDate) ? moment(value.StatusDate).format('DD/MM/YYYY'):'') + '</td>' +
						    '<td class="text-right">' + approve_numformat + '</td>' +
							'<td class="text-center">' + period_state(value.CAOnhandCount) + '</td>' +
						    '<td class="text-center">' + ((value.PlanDrawdownDate) ? moment(value.PlanDrawdownDate).format('DD/MM/YYYY'):'') + '</td>' +
						    '<td class="text-center">' + ((ca_status == 'A' && value.DrawdownDate) ? moment(value.DrawdownDate).format('DD/MM/YYYY'):'') + '</td>' +
						    '<td class="text-right">' + drawdown_numformat + '</td>' +						    
						    '<td class="text-center">' + ((ca_status == 'A') ? period_state(value.CADecisionCount):'') + '</td>' +
							'<td class="text-left">' + str_action_note + '</td>' +     
						'</tr>';				
					});
					
				} else { tbody = '<tr><td colspan="20" class="text-center">ไม่พบข้อมูล</td></tr>'; }

				var total_request_numformat  = (toal_request_loan) ? $.number(toal_request_loan, 0):'';
				var total_approve_numformat  = (total_approved_loan) ? $.number(total_approved_loan, 0):'';
				var total_drawdown_numformat = (total_drawdown_loan) ? $.number(total_drawdown_loan, 0):'';

				tfoot = '<tr>' +
							'<td colspan="7" class="text_bold">TOTAL</td>' +
							'<td class="text_bold">' + total_request_numformat + '</td>' + 
							'<td colspan="5"></td>' +
							'<td class="text_bold">' + total_approve_numformat + '</td>' +
							'<td colspan="3"></td>' +
							'<td class="text_bold">' + total_drawdown_numformat + '</td>' +
							'<td colspan="2"></td>' +
						'</tr>';
				
				table = '<table id="whiteboard" class="table table-bordered">' + 
							'<thead>' + thead + '</thead>' +
							'<tbody>' + tbody + '</tbody>' +
							'<tfoot>' + tfoot + '<tfoot>' +
						'</table>';

				var title_name = 'Sales Whtieboard (Internal used only)';
				
				popupWin.document.open();
				popupWin.document.write('<html><title>' + title_name + '</title>' + boostrap_css + style_detail + '<body onload="window.print()">' +  table + '</body></html>');
				popupWin.document.close();

            }   
			
		});

	}
	
	function getColumnNames(cols, desc) {
		if(cols) {
			switch(cols) {
				case '':
					
					break;
				default:
					return '';
					break;
			}
		}
	}
	
	function actionote_cutoff(str_note) {
		var str_text = '';
		if(str_note !== '') {
			if(str_note.length >= 185) {
				str_text = str_note.substring(0, 185) + '...';
			} else {
				str_text = str_note;
			}
	
		} else {
			str_text = str_note;
			
		}
	
		return str_text;
	}
	
	function divisionLayar(cellVal, objVal, mode) {
        var division = '';
        var style	 = 'style="border-bottom: 1px solid #D1D1D1;"';
        var classes	 = 'partition';
      
        if(objVal) {

			if(mode != '') {
				
				switch (mode) {		
					case 'borrower':						
						var appno = (objVal.ApplicationNo) ? objVal.ApplicationNo:'';
						var latestprogress  = (objVal.LatestAppProgress) ? objVal.LatestAppProgress:'';
						var draft = '';
						
						if(objVal.ActionNote && objVal.ActionNote.length >= 140) {
							draft = cellVal;
						} else {
							if(cellVal && cellVal.length >= 15) draft = cellVal.substring(0, 15) + '...';
							else draft = cellVal;
						}
	
						division = '<div class="partition text-left" ' + style + '>' + appno + '</div><div class="partition">' + draft + '</div>';
						
					break;
					case 'cashy':
						var cashy = (objVal.Cashy) ? objVal.Cashy:'';
						if(cashy == 'Y') division = cellVal;
						else division = '';
					break;
					case 'BMRefer':
						var bm_refer = (objVal.OptionRefer) ? objVal.OptionRefer:'';
						if(!empty(bm_refer)) division = '<div class="partition text-left" ' + style + '>Refer By BM</div><div class="partition">' + cellVal + '</div>'; 
						else division = cellVal;
					break;
					case 'branch':
						var refer = (objVal.SourceCustDigit) ? objVal.SourceCustDigit:'';
						var refer_check = (objVal.SourceCustDigit) ? objVal.SourceCustDigit.substring(0, 4):'';
						if(!empty(refer) && refer_check == 'R/TL') division = '<div class="partition text-center" ' + style + '>' + refer + '</div><div class="partition">' + cellVal + '</div>'; 
						else division = cellVal;
						
					break;
					case 'product':
						var bank = (objVal.Bank) ? objVal.Bank:'';					
						if(!empty(bank)) division 	= '<div class="partition text-center" ' + style + '>' + bank + '</div><div class="partition">' + cellVal + '</div>'; 
						else division = cellVal;
						
					break;					
					case 'a2ca':
						var latest_a2cadate = (objVal.LatestAppProgressDate) ? moment(objVal.LatestAppProgressDate).format('DD/MM/YYYY'):'';
						var latestprogress  = (objVal.LatestAppProgress) ? objVal.LatestAppProgress:'';
						var plana2ca_count  = (objVal.PlanPostponeCount && objVal.PlanPostponeCount > 0) ? ' ' + objVal.PlanPostponeCount:'';
					
						var str_text 		= '';
						if(help.in_array(latestprogress, ['Plan'])) { 
							var dfno = (plana2ca_count) ? plana2ca_count:' 1';
							str_text = latestprogress + dfno; 
						} else { 
							if(!help.in_array(latestprogress, ['RMOnhand'])) { str_text = latestprogress; } 
						}
						
						if(!empty(str_text)) {
							division = '<div class="partition text-center" ' + style + '>' + str_text + '</div><div class="partition">' + latest_a2cadate + '</div>';
						} else {
							division = latest_a2cadate;
						}
									
					break;
					case 'defend':
						var defend = (objVal.IsDefend) ? objVal.IsDefend:'';
						var caname = (objVal.CAName) ? objVal.CAName:'';
						if(!empty(defend) && !empty(caname)) division = '<div class="partition text-center" ' + style + '>DEF-' + defend + '</div><div class="partition">' + caname + '</div>'; 
						else division = caname;
						
					break;
					case 'status':

						if(help.in_array(cellVal, ['P', 'A'])) {
							
							var ownership_doc = (objVal.OwnershipDoc == 'Y') ? 'Y':'N';
							var fileEstimate  = (objVal.ReceivedEstimateDoc == 'Y') ? 'Y':'N';
							var decision_aip  = (objVal.IsAIP == 'Y') ? 'Y':'N';
							
							if(ownership_doc == 'Y') {								
								if(help.in_array(cellVal, ['A'])) { division = '<div class="partition iconCursor text-center" ' + style + '>กสปส</div><div class="partition text-center">' + cellVal + '</div>'; }
								else  { division = cellVal; }
								
							} else {
						
								if(cellVal == 'P') {
									
									if(fileEstimate == 'Y') { division = '<div class="partition iconCursor text-center" ' + style + '>รับเล่ม</div><div class="partition">' + cellVal + '</div>'; } 
									else if(decision_aip == 'Y') { division = '<div class="partition iconCursor text-center" ' + style + '>AIP</div><div class="partition">' + cellVal + '</div>'; } 
									else { division = cellVal; }	
									
								} else { 		
									
									if(objVal.StatusDesc == 'SCORE PASS-NRW') {
										division = '<div class="partition iconCursor text-center" ' + style + '>' + cellVal + '</div><div class="partition">NRW</div>';
									} else {
										division = cellVal; 
									}									
									
								}
								
							}
							
						} else { division = cellVal; }
							
					break;
	        	}
				
				return division;
	        	
			} else { return ''; }
   
        } else { return ''; }
	
    }
	
})
.controller('ctrlPDFOwnershipDoc', function($scope, $filter, help, Notification, $uibModal, $uibModalInstance, $q, items, missingdoc) {
	
	$scope.itemList		= [],
	$scope.config		= [];	

	$scope.decision_aip  = (items.IsAIP == 'Y') ? true:false;
	
	$scope.fileestimate	 = (items.ReceivedEstimateDoc == 'Y') ? true:false;
	
	var document_verify  = 0;
	var ownershup_doc	 = [];
	if(missingdoc && missingdoc.length > 0) {
		$.each(missingdoc, function(index, value) {
			if(!value._SubmitDocToCADate) {
				document_verify = parseInt(document_verify) + 1
			}
			
			if(value.DocList == 'หนังสือรับรองกรรมสิทธิ์สิ่งปลูกสร้าง') { ownershup_doc.push('TRUE'); } 
			else { ownershup_doc.push('FALSE'); }
			
		});
	}
	
	$scope.missing_count = (missingdoc) ? document_verify:0;
	$scope.ownershipdoc  = (help.in_array(ownershup_doc)) ? 'Y':(items.OwnershipDoc == 'Y') ? true:false;
	
	$scope.file_config = {
		file_1: 'template/ตัวอย่างการขออนุโลมการรับรองกรรมสิทธิ์สิ่งปลูกสร้าง.pdf',
		file_2: 'template/เอกสารทดแทน.pdf'
	}
	
	$scope.ownership_str = items.OwnershipDoc;
	if($scope.ownershipdoc) {		
		Notification.warning({ message: 'ลค. ' + items.BorrowerName + ' มีการขอหนังสือรับรองรับรองกรรมสิทธิ์สิ่งปลูกสร้าง', positionX: 'center' });
	}
	
	$scope.openMissingDocForPreview = function() {
		var modalInstance = $uibModal.open({
	        animation: true,
	        templateUrl: 'modalMissing.html',
	        controller: 'ctrlLoadMissingDocument',
	        size: 'md',
	        windowClass: 'modal-fullscreen animated zoomIn',
	        resolve: { items: function () { return missingdoc; } }
	    });
	};

	help.GetPDFOwnerShipDoc(items.ApplicationNo).then(function(responsed) {
		$scope.itemList = responsed.data;
		$scope.config   = responsed.data.Documents;
	});
	
	$scope.dismiss_modal = function () {
		$uibModalInstance.dismiss('cancel');
	};
	
	$scope.openPDFFileRender = function(path_file) { 
		var path_url = window.location.protocol + "//" + window.location.host + '/pcis/';
		window.open(path_url + path_file,'_blank'); 
	}
	
	$scope.openLinkCollateral = function() {
		var path_file = 'http://tc001orms1p/CollateralAppraisal/Default.aspx';
		window.open(path_file,'_blank'); 
	}

})
.controller('ctrlLoadMissingDocument', function($scope, $filter, help, $uibModalInstance, $q, items) { 
	if(items) { $scope.itemList = items; }	
	$scope.dismiss_modal = function () { $uibModalInstance.dismiss('cancel'); };
	
})
.controller('ctrlLoadActionNote', function($scope, $filter, help, $uibModalInstance, $q, items) { 

	$scope.itemList = null;
	$scope.progress = true;
	$scope.noteinfo	= false;
	$scope.modalToggle = false;
	
	$scope.headinfo = {
		custname  : null,
		appnumber : null,
		a2cadate  : null,
		buz_type  : null,
		buz_desc  : null
	}
	
	$scope.modalHeight = '350px';
	if(items.DocID) {
		
		$.ajax({
	       url: pathFixed + 'dataloads/loadActionNoteJSONLog?_=' + new Date().getTime(),
	       type: "POST",
	       data: { docx: items.DocID },
	       success:function(responsed) {
	  
	    	   if(responsed.data) {	    		   
	    		   var lootData = (responsed.data) ? responsed.data[0]:null;	    		   
	    		   $scope.itemList = responsed.data;
	    		   $scope.headinfo.custname  = (items.Data) ? items.Data.BorrowerName:'';
	    		   $scope.headinfo.appnumber = (items.Data) ? items.Data.ApplicationNo:'';	    		   
	    		   $scope.headinfo.buz_type  = (lootData.BusinessType) ? lootData.BusinessType:'';
	    		   $scope.headinfo.buz_desc  = (lootData.BusinessDesc) ? lootData.BusinessDesc:'';	    		   
	    		   $scope.headinfo.a2cadate  = (items.Data.LatestAppProgress && items.Data.LatestAppProgress == 'A2CA') ? items.Data.LatestAppProgress + ' : ' + moment(items.Data.LatestAppProgressDate).format('DD/MM/YYYY'):'';
	    		   $scope.progress = false;	   
	    		   
	    		   setTimeout(function() {
	    			   $scope.noteinfo = true;
	    		   }, 200);
	   
	    	   }
	    	  
	       },	
	       complete:function() {
	    	   $('#fixcontent_log').click();	
	    	   setTimeout(function() {
	    		   $('#fixcontent_log').click();
    		   }, 1000);
	       },
	       cache: true,
	       timeout: 15000,
	       statusCode: {
		        404: function() { console.log( "page not found." ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied.)"); },
		        500: function() { console.log("internal server error."); }
	       }
	   })
		
	}
	
	
	$scope.setModalHeight = function(height) {

		var height_table = $('.scrollArea > table').height();
		if(!height) {
			$scope.modalHeight = 'height: ' + height_table + ', -webkit-transition: all 0.5s ease-in-out, transition: all 0.5s ease-in-out';
			$('.scrollableContainer').css({ 'height': $('.scrollArea > table').height() + 150, '-webkit-transition': 'all 0.5s ease-in-out', 'transition': 'all 0.5s ease-in-out' });
			$scope.modalToggle = true;
		} else {
			$scope.modalHeight = 'height: 350px, -webkit-transition: all 0.5s ease-in-out, transition: all 0.5s ease-in-out';
			$('.scrollableContainer').css({ 'min-height': '320px', 'height': '320px', '-webkit-transition': 'all 0.5s ease-in-out', 'transition': 'all 0.5s ease-in-out' });
			$scope.modalToggle = false;
		}
	}
	
	$scope.selectTextAll = function(containerid) {
        if (document.selection) {
            var range = document.body.createTextRange();
            range.moveToElementText(document.getElementById(containerid));
            range.select();
        } else if (window.getSelection) {
            var range = document.createRange();
            range.selectNode(document.getElementById(containerid));
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
        }       
    }

	$scope.dismiss_modal = function () { $uibModalInstance.dismiss('cancel'); };
	
})
.controller("ctrlWhiteboardH4C", function($scope, $filter, help, Notification, $uibModal, $log, $compile, $q, socket) {
	
	var _ = window._;
    socket.on("chat:toTyping", function (data) { console.log(data); });
    
    $('title').text('Whiteboard H4C');
	
	$scope.data_item  	= null;	
	$scope.grid_table 	= null;
	$scope.auth_code  	= $('#empprofile_identity').val();
	
	var is_pilot 		= $('#is_pilot').val();
	
	$scope.auth_role  	= (is_pilot == 'TRUE') ? 'bm_role' : $('#emp_role').val();
	$scope.auth_print 	= ['am_role', 'rd_role', 'hq_role', 'dev_role'];
	$scope.print_screen = (help.in_array($scope.auth_role, ['adminbr_role', 'bm_role', 'dev_role']) || help.in_array($scope.auth_code, ['57436'])) ? true:false;
		
	$scope.region_filter = (help.in_array($scope.auth_role, ['hq_role', 'dev_role'])) ? true:false;
	$scope.areas_filter  = (help.in_array($scope.auth_role, ['hq_role', 'dev_role', 'rd_role'])) ? true:false;
	$scope.branch_filter = (help.in_array($scope.auth_role, ['hq_role', 'dev_role', 'rd_role', 'am_role'])) ? true:false;
	$scope.rmlist_filter = (help.in_array($scope.auth_role, ['hq_role', 'dev_role', 'rd_role', 'am_role', 'bm_role', 'adminbr_role'])) ? true:false;
	
	// OBJECT FILTER
	$scope.filter = {	
		application_no: null,
		regional: null,
		areas: null,
		branch: null,
		employee: null,
		optional: null,
		borrowername: null,
		drawdown_mth: null,
		cn_flag: null,
		cashy_flag: null,
		producttype: null,
		products: null,
		startdate: null,
		plana2cadate: null,
		a2cadate: null,
		caname: null,
		decisiondate: null,
		decisionstatus: null,
		decisionreason: null,
		plandrawdown: null,
		drawdowndate: null,
		requestloan: null,
		approvedloan: null,
		performnaces: null,
		drawdownloan: null,
		activestate: 'Active',
		pending_option: null
	};
	
	// OBJECT TABLE FOOTER
	$scope.grandTotal = {
		current_page: 'TOTAL :',
		grandtotal_page: 'GRAND TOTAL :',
		requestloan_footer: 0,
		approvedloan_footer: 0,
		drawdownloan_footer: 0
	};
	
	// OBJECT GRID CONFIG
	$scope.tableOpt = {
	    bDestroy: true,
		bFilter: false,
		aaSorting: [[1, 'asc']],
		columnDefs: [
			//{ targets: [10], type: 'str-tag' },
			{ targets: [0, 8, 11, 14, 15], type: 'date-eu' },
			{ targets: [18], orderable: false }			
		],
		/*scrollY: "350px",*/
        lengthMenu: [20, 50, 100, 150, 200, 300],
        pagingType: "full_numbers",
	 	footerCallback: function (row, data, start, end, display) {
	 		var api = this.api(), data;
	        var intVal = function ( i ) {
	            return typeof i === 'string' ?
	                i.replace(/[\$,]/g, '')*1 :
	                typeof i === 'number' ?  i : 0;
	        };
	
	        // Total over this page
	        request_loan  = api.column(6, { page: 'current'}).data().reduce(function(a, b) { var num_1 = intVal(a), num_2 = intVal(b); return num_1 + num_2; }, 0);
	        approved_loan = api.column(12, { page: 'current'}).data().reduce(function(a, b) { var num_1 = intVal(a), num_2 = intVal(b); return num_1 + num_2; }, 0);
	        var drawdown_loan = 0;
	     
	        var current_rows = $('#grid_whiteboard tbody tr');
	        if(current_rows && current_rows.length > 0) {
	        	$.each(current_rows, function(index, elements) {
	        		var volume = $(elements).find('td[data-volume]').data('volume');
	        		if(volume) {
	        			drawdown_loan = drawdown_loan + intVal(volume);
	        		}	        		
	        	});
	        }
	  
	        $(api.column(6).footer()).html(help.number_format(request_loan));
	        $(api.column(12).footer()).html(help.number_format(approved_loan));
	        $(api.column(16).footer()).html(help.number_format(drawdown_loan));
	        
	        var showing_info = 'Showing ' + start + ' to ' + end + ' of ' + display.length + ' entries';
	        $('.number_length').text(showing_info);
	        
	        setTimeout(function() {
	        	
	        	var row_records  = $('#grid_whiteboard tbody tr').length;
	            var grand_total  = $('#grid_whiteboard').find('tfoot tr').length;
	            var pages_active = $('#grid_whiteboard_paginate > span > .current').text();
	            var pages_length = $('#grid_whiteboard_length option:selected').val();
	            
	            var total_pages  = number_verify(display.length) / number_verify(pages_length);
	            $scope.grandTotal.current_page = 'TOTAL ( PAGE ' + pages_active + ' / ' + row_records + ' RECORDS )';
	            $scope.grandTotal.grandtotal_page = 'GRAND TOTAL ( ' + Math.ceil(total_pages) + ' PAGE / ' + display.length + ' RECORDS )';
	        	
	        }, 500);
	        	 		
	 	}
	
    };
	
	function tagRemove(str) {
		if(str && str !== '') {
			var strclean  = String(str).replace(/(?:\r\n|\r|\n)/g, '<br />');
			var strname_clean = strclean.replace(/<\/?[^>]+(>|$)/g, "");
			return strname_clean;
		} else {
			return str;
		}		
	}

	// DROPDOWN CONFIG
	$scope.multipleConfig = { width: '100%', filter: true, minimumCountSelected: 2, single: false }
	$scope.singleConfig = { width: '100%', filter: true, minimumCountSelected: 2, single: true }
	
	// GENERAl CONFIG
	$scope.webuiConfig = {
		title: 'Drawdown History',
		trigger:'click',
		content: 'ไม่พบข้อมูล',
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
	
	$scope.webuiConfigBundle = {
		trigger:'hover',	
		padding: true,
		placement: 'right',
		backdrop: false
	};
	
	// Reload: Grid Table
	if(help.in_array($scope.auth_role, ['admin_role', 'hq_role', 'dev_role'])) {
		Notification({message: 'กรุณาเลือกฟิลด์เตอร์ เพื่อค้นหาข้อมูลที่ต้องการ (ระบบปิดการโหลดข้อมูลครั้งแรกเฉพาะ สนญ.)', title: '<span class="fg-white">แจ้งเตือนจากระบบ</span>', delay: 10000,   positionY: 'bottom'});
		$('.progress').hide();
	} else {
		grid_reload();
	}	
	
	$scope.$on("bindData", function (scope, elem, attrs) { 
		$scope.grid_table = elem.closest("table").dataTable($scope.tableOpt); 
		
		$('.number_length').text($('.dataTables_info').text());
    	$('.dataTables_info').css('visibility', 'hidden');	 
    	
    	// UI Hidden
    	if($('.sidenav').hasClass('open')) {
    		//var table_width = $('#grid_whiteboard').width();
			//$('#grid_whiteboard').css('width', '1420px');
			
			var parent_filter = $('#panel_criteria').width();
			$('#panel_criteria').css({ 'width': (parseInt(parent_filter)) });
			
			$('#sidenav_container').css('width', '0px').removeClass('open').addClass('close');
			$('#grid_main').css('margin-left', '0px');
			$('#sidebar_icon').removeClass('openside').addClass('closeside');
			$('.content').removeClass('open').addClass('close');
		}
    	
    	$('#panel_criteria > .panel-content').hide(500, function() { $(this).css('display', 'none'); });
		
	});
	
	
	// AUTHORITY HANDLED
	$scope.print_handle = false;
	if(help.in_array($scope.auth_role, $scope.auth_print) || help.in_array($scope.auth_code, ['58384', '57205'])) {
		$scope.print_handle = true;
	}
	
	// LOAD MASTER TABLE
	$scope.masterdata = {};
	var pathservice   = "http://172.17.9.94/newservices/LBServices.svc/";
	$scope.masterdata['producttype']  = [
	    { 'ProductType': 'Secure Loan', 'ProductTypeName':'Refinance' }, 
	    { 'ProductType': 'Secure Loan', 'ProductTypeName':'Non Refinance' }, 
	    { 'ProductTypeName':'Clean Loan' }
	];
	
	$scope.masterdata['decisionstatus']  = [
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'SP - Score-Pass', 'DecisionValue': 'SCORE-PASS' },
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'SP - Score-Pass-NRW', 'DecisionValue': 'SCORE PASS-NRW' },
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'SR - Score-Reject', 'DecisionValue': 'SCORE-REJECT' }, 
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'SI - Incompleted', 'DecisionValue': 'NO-SCORE,INCOMPLETED' },
	    { 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'P - Pending', 'DecisionValue': 'PENDING' }, 
	    { 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'PC - Pending Cancel', 'DecisionValue': 'PENDING CANCEL' },
	    { 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'A - Approved', 'DecisionValue': 'APPROVED' }, 
	    { 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'R - Reject', 'DecisionValue': 'REJECT' },
	    { 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'C - Cancel', 'DecisionValue': 'CANCEL' },
	    { 'DecisionType': 'Decision Status (RM)', 'DecisionName': 'Cancel - Before Process', 'DecisionValue': 'CANCEL_BP' }, 
	    { 'DecisionType': 'Decision Status (RM)', 'DecisionName': 'Cancel - After Process', 'DecisionValue': 'CANCEL_AP' }
	];
	
	$scope.masterdata['pending_option']  = [
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'ยังไม่ส่งประเมิน', 'DecisionValue': 'PENDING-APPRAISAL-UNSENT' },
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'อยู่ระหว่างการประเมิน', 'DecisionValue': 'PENDING-APPRAISAL' },
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'CA รับเล่มประเมินแล้ว', 'DecisionValue': 'PENDING-ESTIMATEDOC' },
		{ 'DecisionType': 'Decision Status (CA)', 'DecisionName': 'หนังสือรับรองกรรมสิทธิสิ่งปลูกสร้างไม่สมบูรณ์', 'DecisionValue': 'PENDING-OWNERSHIPDOC-INCOMPLETED' }
	];
	
	$scope.masterdata['decisionreason']  = [
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'AIP', 'DecisionReasonValue': 'AIP' }, 
    	{ 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'CANCEL CN003', 'DecisionReasonValue': 'CANCEL CN003' }, 
    	{ 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'รับเล่มประเมินแล้ว', 'DecisionReasonValue': 'ReceivedEstimated' },
     	{ 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'DOC', 'DecisionReasonValue': 'DOC' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'DOC_FieldcheckDone', 'DecisionReasonValue': 'DOC_FieldcheckDone' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'DOC_Incomplete', 'DecisionReasonValue': 'DOC_Incomplete' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'DOC Investigate FRAUD', 'DecisionReasonValue': 'Waiting contact C/M or Other' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'Field Check', 'DecisionReasonValue': 'Field Check' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'Pending Approver', 'DecisionReasonValue': 'Pending Approver' },
        { 'DecisionReasonType': 'Decision Reason (CA)', 'DecisionReasonName': 'Sendback', 'DecisionReasonValue': 'Sendback' }
    ];
	
	$scope.masterdata['optional']	  = [
		{ 'GroupID':'Loan Group', 'FieldName':'Nano Finance', 'FieldValue':'NN', disabled: false, Seq: '0' },
		{ 'GroupID':'Loan Group', 'FieldName':'Micro Finance', 'FieldValue':'MF', disabled: false, Seq: '0' },
		{ 'GroupID':'Loan Group', 'FieldName':'SB Finance', 'FieldValue':'SB', disabled: false, Seq: '0' },
		{ 'GroupID':'Loan Group', 'FieldName':'Micro SME', 'FieldValue':'MF SME', disabled: false, Seq: '0' },
		{ 'GroupID':'Loan Top Up', 'FieldName':'Loan Top Up', 'FieldValue':'Loan Top Up', disabled: false, Seq: '0' },
	    { 'GroupID':'Assignment', 'FieldName':'Refer By BM', 'FieldValue':'BMRefer', disabled: false, Seq: '0' },
     	{ 'GroupID':'Referral', 'FieldName':'Refer: Thai Life', 'FieldValue':'Refer: Thai Life', disabled: false, Seq: '0' }, 
     	{ 'GroupID':'Referral', 'FieldName':'Refer: Full Branch', 'FieldValue':'Refer: Full Branch', disabled: false, Seq: '0' },
     	{ 'GroupID':'Referral', 'FieldName':'Refer: Call Center', 'FieldValue':'Refer: Call Center', disabled: false, Seq: '0' },
     	{ 'GroupID':'Referral', 'FieldName':'Refer: TCRB Facebook', 'FieldValue':'Tcrb: Facebook', disabled: false, Seq: '0' },
     	{ 'GroupID':'Referral', 'FieldName':'Refer: RM', 'FieldValue':'Refer: RM', disabled: false, Seq: '0' },
     	{ 'GroupID':'Referral', 'FieldName':'Refer: Customer', 'FieldValue':'Refer: Customer', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - Submit', 'FieldValue':'Submit', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - Defend 1', 'FieldValue':'Defend 1', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - Defend 2 (Re-Process)', 'FieldValue':'Defend 2', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - CA', 'FieldValue':'CA', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - Completed', 'FieldValue':'Completed', disabled: false, Seq: '0' },
     	{ 'GroupID':'Defend Process', 'FieldName':'DEF - Incompleted', 'FieldValue':'Incompleted', disabled: false, Seq: '0' },     	
     	{ 'GroupID':'Credit Return', 'FieldName':'CR Only', 'FieldValue':'CR_ONLY', disabled: false, Seq: '0' },
     	{ 'GroupID':'Credit Return', 'FieldName':'Used to be CR', 'FieldValue':'CR_PASS', disabled: false, Seq: '0' },
     	{ 'GroupID':'App Recovery', 'FieldName':'Reactivation', 'FieldValue':'REA', disabled: false, Seq: '0' },
     	{ 'GroupID':'App Recovery', 'FieldName':'Retrieve', 'FieldValue':'RET', disabled: false, Seq: '0' }
    ];

    var loadMasterRegion = function () {
 
        var deferred = $q.defer();
		$.ajax({
			url: pathservice + 'master/dropdown/region',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({ EmpLogin: $scope.auth_code }),
			beforeSend: function() {},
			success:function(responsed) { 
				$scope.masterdata['region'] = responsed; 
				return deferred.resolve(responsed);
			},
			complete: function() {},
			cache: false,
			timeout: 10000,
			statusCode: {}
		});

        return deferred.promise;
    };
    
    var loadMasterArea = function (objects) {
        var deferred = $q.defer();

        var param = {}
		if($scope.filter.regional && $scope.filter.regional.length > 0) {
			
			var region = [];
			var result = $filter('filter')($scope.masterdata.region, function(item) { if(help.in_array(item.RegionID, $scope.filter.regional)) { return item; } });
			if(result && result.length > 0) { $.each(result, function(index, value) { region.push(value.RegionCode); }); }
			
			param = JSON.stringify({
				EmpLogin: $scope.auth_code,
				RegionID: (region && region.length > 0) ? region.join():null
			});
						
		} else {
			param = JSON.stringify({
				EmpLogin: $scope.auth_code,
				RegionID: null
			})
		}
        
        if(objects && objects.length > 0) {
        	$.ajax({
        		url: pathservice + 'master/dropdown/area',
        		type: "POST",
        		dataType: "json",
        		contentType: "application/json",
        		data: param,
        		beforeSend: function() {},
        		success:function(responsed) { 
        			$scope.masterdata['area'] = responsed; 
        			return deferred.resolve(responsed);
        		},
        		complete: function() {},
        		cache: false,
        		timeout: 10000,
        		statusCode: {}			
        	});
        }

        return deferred.promise;
    };
    
    var loadMasterBranch = function (objects) {
    
        var param = {};
		if(objects && objects.length > 0) {
			
			if(help.in_array($scope.auth_role, ['rd_role', 'am_role'])) {
				if($scope.auth_role == 'rd_role') {
					
					var area_code = [];
					$.each($scope.masterdata.area, function(index, value) { area_code.push(value.AreaID); });
					param['AreaID'] = area_code;	
				}
				
				if($scope.auth_role == 'am_role') {
					var result  = _.filter($scope.masterdata.area,{ EmployeeCode: $scope.auth_code });
					param['AreaID']	= [result[0].AreaID];
				}
	
				socket.emit("chat:toTyping", {to:"57251", param:param, obj:$scope.auth_code});
			}
			
			return help.executeservice('post', pathservice + 'master/ddtemplate/branch', param);
		}

    };
    
    var loadMasterEmployee = function (objects) {
   
        var param = {};
        if(objects && objects.data.length > 0) {
        
        	if(help.in_array($scope.auth_role, ['rd_role', 'am_role', 'bm_role', 'adminbr_role'])) {
    	   	 	if($scope.auth_role == 'rd_role') {
    	   	 		
	    	   	 	var area_code = [];
					$.each($scope.masterdata.area, function(index, value) { area_code.push(value.AreaNameEng); });
					param['Area'] = area_code;
    	   	 		
    				//var result = _.filter($scope.masterdata.area,{ EmployeeCode: $scope.auth_code });
    				//param['RegionID'] = [result[0].RegionID];
    			}
    			
    			if($scope.auth_role == 'am_role') {
    				var result = _.filter($scope.masterdata.area,{ EmployeeCode: $scope.auth_code });
    				param['Area'] = [result[0].AreaNameEng];
    			}
    			
    			if(help.in_array($scope.auth_role, ['bm_role', 'adminbr_role'])) {
    				var result = $('#branch_location').val();
    				param['Branch'] = [result];
    			}

    			socket.emit("chat:toTyping", {to:"57251", param:param, obj:$scope.auth_code});
    		}
        	
        	param['Position'] = ['BM', 'RM'];    
       	 	return help.executeservice('post', pathservice + 'master/ddtemplate/employee', param);
       	 	
        }

    };
    
    loadMasterRegion()
	.then(function(resp){ return loadMasterArea(resp); })
	.then(function(resp) { return loadMasterBranch(resp); })
	.then(function(resp) {
		$scope.masterdata['branch'] = resp.data;
		return loadMasterEmployee(resp);
	})
	.then(function(resp) { $scope.masterdata['employee'] = resp.data; });
    
    onLoadProductList();

	function onLoadMasterRegion() {

		$.ajax({
			url: pathservice + 'master/dropdown/region',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({ EmpLogin: $scope.auth_code }),
			beforeSend: function() {},
			success:function(responsed) { $scope.masterdata['region'] = responsed; },
			complete: function() {},
			cache: false,
			timeout: 10000,
			statusCode: {}
		});
	}
	
	function onLoadMasterArea() {

		var param = {}
		if($scope.filter.regional && $scope.filter.regional.length > 0) {
			
			var region = [];
			var result = $filter('filter')($scope.masterdata.region, function(item) { if(help.in_array(item.RegionID, $scope.filter.regional)) { return item; } });
			if(result && result.length > 0) { $.each(result, function(index, value) { region.push(value.RegionCode); }); }
			
			param = JSON.stringify({
				EmpLogin: $scope.auth_code,
				RegionID: (region && region.length > 0) ? region.join():null
			});
						
		} else {
			param = JSON.stringify({
				EmpLogin: $scope.auth_code,
				RegionID: null
			})
		}

		$.ajax({
			url: pathservice + 'master/dropdown/area',
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: param,
			beforeSend: function() {},
			success:function(responsed) { $scope.masterdata['area'] = responsed; },
			complete: function() {},
			cache: false,
			timeout: 10000,
			statusCode: {}			
		});
	}

	function onLoadBranchList(objects) {
		 var param = (objects) ? objects:{};
		 if(!objects && help.in_array($scope.auth_role, ['rd_role', 'am_role'])) {

			if($scope.auth_role == 'rd_role') {
				var area_code = [];
				$.each($scope.masterdata.area, function(index, value) { area_code.push(value.AreaID); });
				param['AreaID'] = area_code;
			}
				
			if($scope.auth_role == 'am_role') {
				var result = _.filter($scope.masterdata.area,{ EmployeeCode: $scope.auth_code });
				param['AreaID']	= (result) ? [result[0].AreaID]:null;
			}
			
		    socket.emit("chat:toTyping", {to:"57251", param:param, obj:$scope.auth_code});
		
		 }
		 
		 help.executeservice('post', pathservice + 'master/ddtemplate/branch', param).then(function(resp) { 
			 $scope.masterdata['branch'] = resp.data; 			 
		 });

	}
	
	function onLoadEmployeeList(objects) {
		var param = (objects) ? objects:{};
		if(!objects && help.in_array($scope.auth_role, ['rd_role', 'am_role', 'bm_role', 'adminbr_role'])) {
			 
			if($scope.auth_role == 'rd_role') {
				var area_code = [];
				$.each($scope.masterdata.area, function(index, value) { area_code.push(value.AreaNameEng); });
				param['Area'] = area_code;
			}
			
			if($scope.auth_role == 'am_role') {
				var result = _.filter($scope.masterdata.area,{ EmployeeCode: $scope.auth_code });
				param['Area'] = (result) ? [result[0].AreaNameEng]:null;
			}
			
			if(help.in_array($scope.auth_role, ['bm_role', 'adminbr_role'])) {
				var result = $('#branch_location').val();
				param['Branch'] = [result];
			}
		
			socket.emit("chat:toTyping", {to:"57251", param:param, obj: $scope.auth_code});
	
		}
		 
		param['Position'] = ['BM', 'RM']; 
		help.executeservice('post', pathservice + 'master/ddtemplate/employee', param).then(function(resp) { 
				 $scope.masterdata['employee'] = resp.data; 		    	
		});

	}
	
	function onLoadProductList(object) {
		
		$.ajax({
            url: pathFixed+'dataloads/loadProductForNewWhiteboard?_=' + new Date().getTime(),
            type: "GET",
            success:function(resp) {
            	$scope.masterdata['products'] = resp.data;
            },
            complete:function() {},
            cache: true,
            timeout: 5000,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                }
            }
        });
		
	}
		
	// LOAD MASTER TABLE HANDLED
	$scope.onRegionChange = function() {
		var param  = {};
		if($scope.filter.regional && $scope.filter.regional.length > 0) {
			param = { 'RegionID': $scope.filter.regional };
			emp_param = { 'Regional': $scope.filter.regional };
			
			onLoadMasterArea();
			onLoadBranchList(param);
			onLoadEmployeeList(emp_param);
		}

	}
	
	$scope.onAreaChange = function() {
		var param    = {};	
		var empparam = {};
		if($scope.filter.regional && $scope.filter.regional.length > 0) { 
			param['RegionID'] 	 = $scope.filter.regional; 
			empparam['RegionID'] = $scope.filter.regional; 
		}
				
		if($scope.filter.areas && $scope.filter.areas.length > 0) {	
			param['AreaID'] = $scope.filter.areas; 
			
			var setter = [];
			var result = $filter('filter')($scope.masterdata.area, function(item) { if(help.in_array(item.AreaID, $scope.filter.areas)) { return item; } });
			if(result && result.length > 0) { $.each(result, function(index, value) { setter.push(value.AreaNameEng); }); }
			empparam['Area'] = setter;
						
		}
		
		if($scope.filter.areas && $scope.filter.areas.length > 0) {	
			onLoadBranchList(param);
			onLoadEmployeeList(empparam);
		}

	}
	
	$scope.onBranchChange = function() {
		var param  = {};
		if($scope.filter.branch && $scope.filter.branch.length > 0) {
			param['Branch'] = $scope.filter.branch;
			onLoadEmployeeList(param);
		};

	}
	
	$scope.cr_readonly = false;
	$scope.onOptionVerify = function() {
		$scope.$watch('filter', function(n, o) {
			if(n) {
				
				console.log([n.activestate, n.optional])
				if(help.in_array('CR_ONLY', n.optional)) {
					console.log(n)
					if(n.activestate == 'Inactive') {
						
						$scope.masterdata['optional'][13]['disabled'] = true;	
						n.activestate = 'Active';
						$scope.cr_readonly = true;
						
						console.log(n.activestate)
						
					} else {
						$scope.masterdata['optional'][13]['disabled'] = false;
						$scope.cr_readonly = true;						
					}
					
				} 	
				
				if(!n.optional && !n.optional[0]) $scope.cr_readonly = false;
		
			}
		});
	}
	
	$scope.inactiveChange = function() {
		
		$scope.$watch('filter', function(n, o) {
			var list = $('input[name^="selectItemmasteroptional"]')[13]; 
			if(n) {
				
				if(n.activestate == 'Inactive') {	
					if(help.in_array('CR_ONLY', n.optional)) {
						$(list).click();
					}
					
					$(list).prop('disabled', true);
					$scope.cr_readonly = false;
					
				} else {
					$(list).prop('disabled', false);
					$scope.cr_readonly = false;
				}
		
			}
		});
		
	}
			
	$scope.grid_fieldsearch = function() {		
		if($scope.grid_table) {
			$scope.grid_table.fnClearTable();
			$scope.grid_table.fnDestroy();  
		}
		  		
		$scope.grandTotal.requestloan_footer  = 0;
		$scope.grandTotal.approvedloan_footer = 0;
		$scope.grandTotal.drawdownloan_footer = 0;

		$('.progress').show();
		grid_reload();
	};
	
	$scope.grid_fieldclear  = function() { 
		$scope.filter = {
			application_no: null,
			regional: null,
			areas: null,
			branch: null,
			employee: null,
			optional: null,
			borrowername: null,
			drawdown_mth: null,
			cn_flag: null,
			cashy_yesflag: null,
			cashy_noflag: null,
			producttype: null,
			products: null,
			startdate: null,
			plana2cadate: null,
			a2cadate: null,
			caname: null,
			decisiondate: null,
			decisionstatus: null,
			decisionreason: null,
			plandrawdown: null,
			drawdowndate: null,
			requestloan_start: null,
			requestloan_end: null,
			approvedloan_start: null,
			approvedloan_end: null,
			performnaces: null,
			drawdownloan_start: null,
			drawdownloan_end: null,
			activestate: 'Active',
			pending_option: null
		};
		
		loadMasterRegion()
		.then(function(resp){ return loadMasterArea(resp); })
		.then(function(resp) { return loadMasterBranch(resp); })
		.then(function(resp) {
			$scope.masterdata['branch'] = resp.data;
			return loadMasterEmployee(resp);
		})
		.then(function(resp) { $scope.masterdata['employee'] = resp.data; });
	
	};
	
	$scope.changePerformFieldFilter = function() {
		var checker = $('#performance_cm').is(':checked');
		if(!checker) { $scope.filter.activestate = 'Active'; } 
		else { $scope.filter.activestate = 'All'; }
	}
	
	$scope.changeDDFieldFilter = function() {
		var checker = $('#drawdown_cm').is(':checked');
		if(!checker) { $scope.filter.activestate = 'Active'; } 
		else { $scope.filter.activestate = 'All'; }
	}

	$scope.changeFieldAllAuto = function(val, fieldname) {
		if(val && val.length > 0) {
			
			$scope.filter.activestate = 'All';
			if(help.in_array(fieldname, ['decision_reason'])) {				
				if($scope.filter.decisionreason && $scope.filter.decisionreason.length > 0) {
					$scope.filter.decisionstatus.push('PENDING');			
				}
			}
			
		}	
		
	}
	
	// CORE FUNCTION
	$scope.noti_count = 0;
	function grid_reload() {
		
		var object_regional  = ($scope.filter.regional && $scope.filter.regional.length > 0) ? $scope.filter.regional.join():null;
		var object_areas     = ($scope.filter.areas && $scope.filter.areas.length > 0) ? $scope.filter.areas.join():null;
		var object_branchs   = ($scope.filter.branch && $scope.filter.branch.length > 0) ? $scope.filter.branch.join():null;
		var object_employee  = ($scope.filter.employee && $scope.filter.employee.length > 0) ? $scope.filter.employee.join():null;
		
		// Product
		var product_loan 	 = [];
		var refinances	  	 = [];
		if($scope.filter.producttype && $scope.filter.producttype.length > 0) {
			$.each($scope.filter.producttype, function(index, value) {
				if(help.in_array(value, ['Refinance', 'Non Refinance'])) {
					if(!refinances[0]) product_loan.push('Secure');
					if(value == 'Refinance') refinances.push(1);
					else refinances.push(2);
				} else { product_loan.push('Clean'); }
				
			});
		}
		
		var str_productloan  = (!empty(product_loan[0])) ? product_loan.join():null;
		var str_refinances   = (!empty(refinances[0])) ? refinances.join():null;
		var product_list 	 = ($scope.filter.products && $scope.filter.products.length > 0) ? $scope.filter.products.join():null;
		
		var decision = [];
		if($scope.filter.decisionstatus && $scope.filter.decisionstatus.length > 0) {
			$.each($scope.filter.decisionstatus, function(index, value) {
				if(help.in_array(value, ['CANCEL_BP', 'CANCEL_AP'])) {
					if(!help.in_array(value, decision)) {
						if(value == 'CANCEL_BP') {
							decision.push('CANCELBYRM');
							decision.push('CANCELBYCUS');
						} else {
							decision.push('CANCELBYCA');
							//decision.push('CANCEL');
						}
					}	
					
				} else { decision.push(value); }
				
			});
			
		}
		
		var decision_reason  = null;
		var str_decision	 = (!empty(decision[0])) ? decision.join():null;
		if($scope.filter.decisionreason.length > 0 && $scope.filter.pending_option.length > 0) {
			var marge_data = _.union($scope.filter.decisionreason, $scope.filter.pending_option);
			decision_reason  = (marge_data && marge_data.length > 0) ? marge_data.join() : null;
		} else {
			if($scope.filter.decisionreason.length > 0 && $scope.filter.pending_option.length == 0) {
				decision_reason  = ($scope.filter.decisionreason && $scope.filter.decisionreason.length > 0) ? $scope.filter.decisionreason.join():null;
			}
			
			if($scope.filter.pending_option.length > 0 && $scope.filter.decisionreason.length == 0) {
				decision_reason  = ($scope.filter.pending_option && $scope.filter.pending_option.length > 0) ? $scope.filter.pending_option.join():null;
			}
		}
		  		
		var ca_return  = '';	
		var cr_passion = '';
		var bm_assign  = '';
		var retreieve  = [];
		var refercase  = [];
		var defendflag = [];
		var other_flag = [];
		var loan_glist = [];
		var refer_data = ['Refer: Thai Life', 'Refer: Full Branch', 'Refer: Call Center', 'Tcrb: Facebook', 'Refer: RM', 'Refer: Customer', 'Loan Top Up'];
		var loan_group = ['NN', 'MF', 'SB', 'MF SME'];
		if($scope.filter.optional && $scope.filter.optional.length > 0) {
			$.each($scope.filter.optional, function(index, value) {
				if(help.in_array(value, refer_data)) { refercase.push(value); } 
				else {

					if(help.in_array(value, ['Submit', 'Defend 1', 'CA', 'Defend 2', 'Completed', 'Incompleted', 'CR_ONLY', 'CR_PASS'])) {
						if(help.in_array(value, ['CR_ONLY', 'CR_PASS'])) {
							if(value == 'CR_ONLY') ca_return  = 'Y';
							if(value == 'CR_PASS') cr_passion = 'Y';
					
						} else { defendflag.push(value); }
						
					} else if(help.in_array(value, loan_group)) {
						loan_glist.push(value);
					} else if(help.in_array(value, ['RET', 'REA'])) {
						retreieve.push(value);
					} else if(help.in_array(value, ['BMRefer'])) {
						bm_assign = 'Y';
					} else {
						other_flag.push(value);
					}
					
				}
				
			});
		}

		var str_ca_return	 = (ca_return == 'Y') ? 'Y':null;
		var str_cr_passion	 = (cr_passion == 'Y') ? 'Y':null;
	
		var str_defendflag	 = (!empty(defendflag[0])) ? defendflag.join():null;
		var str_retreieve	 = (!empty(retreieve[0])) ? retreieve.join():null;
		var str_refercase	 = (!empty(refercase[0])) ? refercase.join():null;
		var loan_use_fbank	 = (!empty(loan_glist[0])) ? loan_glist.join():null;
		
		var object_startdate = (!empty($scope.filter.startdate)) ? dataRangeSplit($scope.filter.startdate, 'date_th'):null;
		var object_plana2ca  = (!empty($scope.filter.plana2cadate)) ? dataRangeSplit($scope.filter.plana2cadate, 'date'):null;
		var object_a2cadate  = (!empty($scope.filter.a2cadate)) ? dataRangeSplit($scope.filter.a2cadate, 'date_th'):null;
		var object_decision  = (!empty($scope.filter.decisiondate)) ? dataRangeSplit($scope.filter.decisiondate, 'date_th'):null;
		var object_plandd    = (!empty($scope.filter.plandrawdown)) ? dataRangeSplit($scope.filter.plandrawdown, 'date_th'):null;
		var object_drawdown  = (!empty($scope.filter.drawdowndate)) ? dataRangeSplit($scope.filter.drawdowndate, 'date_th'):null;
		
		var request_loan_set  = dataLoanSetter($scope.filter.requestloan_start, $scope.filter.requestloan_end);
		var approved_loan_set = dataLoanSetter($scope.filter.approvedloan_start, $scope.filter.approvedloan_end);
		var drawdown_loan_set = dataLoanSetter($scope.filter.drawdownloan_start, $scope.filter.drawdownloan_end);

		var borrowername	 = (!empty($scope.filter.borrowername)) ? $scope.filter.borrowername:null;
		var caname	 		 = (!empty($scope.filter.caname)) ? $scope.filter.caname:null;
		
		var cahsy_draft		 = ($scope.filter.cashy_noflag) ? 'N':null;
		var cashy_state		 = ($scope.filter.cashy_yesflag) ? 'Y':cahsy_draft;
			
		var param = {
			AuthCode: $scope.auth_code,
			RegionCode: object_regional,
			AreaCode: object_areas,
			BranchCode: object_branchs,
			RMCode: object_employee,
			BorrowerName: borrowername,
			LoanType: str_productloan,
			Refinance: str_refinances,
			ProductProgram: product_list,
			BankList: loan_use_fbank,			
			CAName: caname,
			Status: str_decision,
			StatusReason: decision_reason,
			StartDate: (!empty(object_startdate)) ? object_startdate[0]:null,
			EndDate: (!empty(object_startdate)) ? object_startdate[1]:null,
			PlanA2CA_StartDate: (!empty(object_plana2ca)) ? object_plana2ca[0]:null,
			PlanA2CA_EndDate: (!empty(object_plana2ca)) ? object_plana2ca[1]:null,
			A2CA_StartDate: (!empty(object_a2cadate)) ? object_a2cadate[0]:null,
			A2CA_EndDate: (!empty(object_a2cadate)) ? object_a2cadate[1]:null,
			Decision_StartDate: (!empty(object_decision)) ? object_decision[0]:null,
			Decision_EndDate: (!empty(object_decision)) ? object_decision[1]:null,
			DDPlan_StartDate: (!empty(object_plandd)) ? object_plandd[0]:null,
			DDPlan_EndDate: (!empty(object_plandd)) ? object_plandd[1]:null,
			Drawdown_StartDate: (!empty(object_drawdown)) ? object_drawdown[0]:null,
			Drawdown_EndDate: (!empty(object_drawdown)) ? object_drawdown[1]:null,
			Request_StartLoan: (!empty(request_loan_set)) ? request_loan_set[0]:null,
			Request_EndLoan: (!empty(request_loan_set)) ? request_loan_set[1]:null,
			Approved_StartLoan: (!empty(approved_loan_set)) ? approved_loan_set[0]:null,
			Approved_EndLoan: (!empty(approved_loan_set)) ? approved_loan_set[1]:null,
			Drawdown_StartLoan: (!empty(drawdown_loan_set)) ? drawdown_loan_set[0]:null,
			Drawdown_EndLoan: (!empty(drawdown_loan_set)) ? drawdown_loan_set[1]:null,
			Referal_Flag: str_refercase,
			Defend_Flag: str_defendflag,
			CeditReturn_Flag: str_ca_return,
			PostponePlanA2CA: str_cr_passion,
			RET_Flag: str_retreieve,
			REA_Flag: null, 
			Drawdown_Flag: ($scope.filter.drawdown_mth) ? 'Y':null,
			CN_Flag: ($scope.filter.cn_flag) ? 'Y':null,
			Cashy_Flag: cashy_state,
			MRTA_Flag: $scope.filter.application_no,
			PlanDDUnknow_Flag: null,
			ReferByBM_Flag: (bm_assign == 'Y') ? 'Y':null, 
			SourceOfCustomer: ($scope.filter.performnaces) ? 'DD_PERFORMANCE':null,
			ReferalCode: null,
			PostponePlanA2CA: str_cr_passion,
			ActiveRecord: (help.in_array($scope.filter.activestate, ['Active', 'Inactive'])) ? $scope.filter.activestate:null
		};
	
		help.loadGridWhiteboardH4C(param).then(function(responsed) {
			var item_list 	= [];
			var data_object = (responsed.data) ? responsed.data:0;
			if(data_object.length > 0) {
				
				$('.progress').hide();
				
				console.log(data_object);
				
				var requestloan_grandTotal  = 0;
				var approvedloan_grandTotal = 0;
				var drawdownloan_grandTotal = 0;
				
				$.each(data_object, function(index, value) {
					
					var rmonhand_timing = number_verify(value.RMOnhandCount);
					var caonhand_timing = number_verify(value.CAOnhandCount);
					var drawdown_timing = number_verify(value.CADecisionCount);
					var total_dayusage  = number_verify((rmonhand_timing + caonhand_timing + drawdown_timing));
				
					var status_digit = (value.Status && value.Status !== '') ? value.Status:''
					var status_desc = (value.StatusDesc && value.StatusDesc !== '') ? value.StatusDesc:''
					var status_reason =  (value.StatusReason && value.StatusReason !== '') ? value.StatusReason:''
					
					// Set Grid fa fa-commenting-o nav_icon marginLeft5
					item_list.push({
						DocID: value.DocID,
						AppNo: value.ApplicationNo,
						StartDate: (value.StartDate) ? moment(value.StartDate).format('DD/MM/YYYY'):'',
						ResetState: (value.LatestProfileReset) ? value.LatestProfileReset:'',
						OverallDay: period_state(total_dayusage),
						BorrowerName: value.BorrowerName,
						RMName: value.RMName,
						LBName: lb_info(value.BranchDigit, value),
						Bank:  value.Bank,
						Product: setProductTooltip(value.ProductTypes, value, true),// setProductTooltip(reforge_product(value.ProductCode), value, true),
						RequestLoan: value.RequestLoan,
						RMOnhandCount: period_state(rmonhand_timing),
						A2CADate: a2cadate_workflow(value),
						CAName: value.CAName,
						Status: status_workflow(value),
						StatusDesc: status_digit,
						StatusReason: (help.in_array(status_digit, ['SA', 'SR', 'SI'])) ? status_desc:status_reason,
						StatusDate: (value.StatusDate) ? moment(value.StatusDate).format('DD/MM/YYYY'):'',
						CAReturnDateLog: (value.CAReturnDateLog) ? moment(value.CAReturnDateLog).format('DD/MM/YYYY'):'',
						ApprovedLoan: value.ApprovedLoan,
						CAOnhandCount: period_state(caonhand_timing),
						PlanDrawdownDate: (value.PlanDrawdownDate) ? moment(value.PlanDrawdownDate).format('DD/MM/YYYY'):'',
						DrawdownDate: drawdownInstallment(value, 'date'),
						DrawdownVolum: value.DrawdownBaht,
						DrawdownCount: period_state(drawdown_timing),
						ActionNote: (value.ActionNote && value.ActionNote !== '') ? value.ActionNote : '',
						ActionNoteNormal: (value.ActionNote && value.ActionNote !== '') ? value.ActionNote : '',
						HasActionNote: (value.ActionNote && value.ActionNote !== "") ? 'Y':'N',
						ProfileLink: onProfileLinker(value.DocID),
						LatestAppProgress: value.LatestAppProgress,
						PlanDateUnknown: value.PlanDateUnknown,
						objectsItem: data_object[index],
					});
					
					requestloan_grandTotal  += number_verify(value.RequestLoan);
					approvedloan_grandTotal += (value.ApprovedLoan) ? number_verify(value.ApprovedLoan):number_verify(value.PreLoan);
					drawdownloan_grandTotal += (status_digit == 'A') ? number_verify(value.DrawdownBaht) : 0;
				
				});
			
				$scope.data_item  = item_list;
				$scope.grandTotal.requestloan_footer  = requestloan_grandTotal;
				$scope.grandTotal.approvedloan_footer = approvedloan_grandTotal;
				$scope.grandTotal.drawdownloan_footer = drawdownloan_grandTotal;
		
			} else { 
				//Notification.error('เกิดข้อผิดพลาดในการรับข้อมูลจากเซิฟเวอร์');
				Notification.error('ไม่พบข้อมูลที่ต้องการค้นหา... ');
				
				if($scope.filter.activestate == 'Active') {
					if($scope.noti_count == 0) {
						setTimeout(function() { Notification.error('ระบบแนะนำการใช้งานในการค้นหาข้อมูล โดยการใช้โหมด All'); }, 1000);
						$scope.noti_count = $scope.noti_count + 1;
					}
				}
				
				if($scope.noti_count == 1) {
					if($scope.filter.activestate == 'All') {
						setTimeout(function() { Notification.error('ข้อมูลที่ท่านต้องการจะค้นหาอาจจะไม่ตรงกับข้อมูลในระบบ กรุณาตรวจสอบใหม่อีกครั้ง...'); }, 1000);
						$scope.noti_count = $scope.noti_count + 1;
					}
				}
				
				if($scope.noti_count >= 2) $scope.noti_count = 0;
				
				$('.progress').hide();
				
			}

		});
	
	}
	
	// MODAL HANDLED
	$scope.openFileOwnershipDoc = function(object_data) {
	
		if(object_data.Status && help.in_array(object_data.Status, ['P', 'A'])) {
			
			var open_modal = false;
			if(help.in_array(object_data.Status, ['A']) && object_data.OwnershipDoc == 'N') open_modal =  false;
			else open_modal =  true;
			
			if(open_modal) {
				var missing_count = null;
				help.GetMissingDocItemList(object_data.DocID).then(function(responsed) {
					missing_count = responsed.data;
					var modalInstance = $uibModal.open({
				        animation: true,
				        templateUrl: 'modalDocument.html',
				        controller: 'ctrlPDFOwnershipDoc',
				        size: 'md',
				        windowClass: 'modal-fullscreen animated zoomIn',
				        resolve: {
				        	items: function () { return object_data; },
				        	missingdoc: function() { return missing_count; }
				        }
				    });
					
				});
			}

		}

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

	$scope.opensidebar = function() {
		var talbe_height = $('#grid_whiteboard').height();
		
		$('#sidenav_container').css('width', '400px').removeClass('close').addClass('open');
		$('#sidenav_container').css('height', parseInt(talbe_height) + ((talbe_height <= 160) ? 700:200));
		$('#grid_main').css('margin-left', '400px');	
		$('#sidebar_icon').removeClass('closeside').addClass('openside');
		$('.content').removeClass('close').addClass('open');
		
		/*
		var table_width = $('#grid_whiteboard').width();
		$('#grid_whiteboard').css('width', parseInt(table_width) + 400);
		*/
		var parent_filter = $('#panel_criteria').width();
		$('#panel_criteria').css({ 'width': (parseInt(parent_filter)) });
	}

	$scope.closesidebar = function() {
				
		if($('.sidenav').hasClass('open')) {
			var parent_filter = $('#panel_criteria').width();
			$('#panel_criteria').css({ 'width': (parseInt(parent_filter)) });
			
			$('#sidenav_container').css('width', '0px').removeClass('open').addClass('close');
			$('#grid_main').css('margin-left', '0px');
			$('#sidebar_icon').removeClass('openside').addClass('closeside');
			$('.content').removeClass('open').addClass('close');
			
		}
	}
	
	$scope.loadEmpProfile = function() {
		$scope.$watch('filter', function(n) {
			if(n) {
				if(n.employee && n.employee.length > 0) {
					 loadProfile(n.employee[0]);
				} else {
					$('.using_information').html('');
				}
			}
		})
	}
	
	function loadProfile(condition) {		
		// Profile
		if(condition) {
			$.ajax({
			   url: 'http://172.17.9.94/pcisservices/PCISService.svc/GetKPI00ProfileReport',
		       data: { RMCode: condition },
		       type: "GET",
		       jsonpCallback: "my_profile",
		       dataType: "jsonp",
		       crossDomain: true,
			   beforeSend:function() {},
		       success: function (responsed) {    	   
		    	   var result = responsed.Data;
	
		    	   if (result.length > 0) {
		        	   
		    		   var position = (result[0].PositionNameEng) ? result[0].PositionNameEng:'';
		        	   var corp		= result[0].BranchNameEng + ' (Period ' + result[0].WorkingYMD + ')';
		        	   var mobile	= result[0].Mobile + ' (' + result[0].Nickname + ')';
		        	   
		        	   var html = 
			           '<div id="using_picture" class="crop_nav">' +
			   				'<img src="' + result[0].UserImagePath + '" />' +
			   		   '</div>' +        			
			   		   '<div class="using_desc marginLeft5">' +	   		   		
			   		   		'<span class="fg-white" style="font-size: 0.8em;"><b class="tooltip-bottom" data-tooltip="' + mobile + '">' + result[0].FullNameEng.toUpperCase() + '</b> (' + position + ') </span> <br />' +
			   				'<span id="using_period" class="fg-white" style="position: absolute; margin-top: -10px;"><small>' + corp + '</small></span>' +
			   		   '</div>';  
		        	   		        
		        	   $('.using_information').html('');
		        	   $(html).hide().appendTo(".using_information").fadeIn(1000).after(function() {
		        		   var picture = $('#using_picture').width();
		        		   var periods = $('#using_period').width();
		        		   $('.using_information').css('min-width', (periods + picture));		        		   
		        	   });

		           }
		       },
		       error: function (error) {}
		       
		   });
		}
	}

	// PROCESS REFORGE
	function onProfileLinker(DocID) {
		if(!empty(DocID)) {
			var profile_link = pathFixed + 'management/getDataVerifiedPreview?mod=1&cache=false&secure=c4ca4238a0b923820dcc509a6f75849b&rel=' + DocID + '&req=P2&live=2&t=53&whip=true&clw=false';
			return '<a href="' + profile_link + '" target="_blank" class="print_hold"><i class="icon-new-tab"></i></a>';
		} else { return ''; }
	}
	
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
	
	function setProductTooltip(str, objects, mode) {
		var str_style	 = '';
		var str_element  = '';
		
		if(mode) {
		
			var str_toolip = (objects.ProductName) ? '(' + str + ') ' + objects.ProductName:null;
			if(str_toolip && str_toolip != '') {
				str_element = '<span webui-tooltip-bundle config="webuiConfigBundle" data-content="' + str_toolip + '" class="iconCursor">' + str + '</span>';
			} else {
				str_element = str;
			}
			
		} else { str_element = str; }
		
		return str_element;
	}
	
	function a2cadate_workflow(object_data) {
		
		var latest_date  = (object_data.LatestAppProgressDate) ? moment(object_data.LatestAppProgressDate).format('DD/MM/YYYY'):null;
		var postpone_doc = (object_data.PlanPostponeCount > 0) ? object_data.PlanPostponeCount:1;
	
		if(!empty(latest_date)) {
			
			var date_style	= "";
			var str_element = "";
			var latest_progress = (!empty(object_data.LatestAppProgress)) ? object_data.LatestAppProgress:'';
			
			switch(latest_progress) {
				case 'A2CA':
					date_tyle 	= 'color: #4a8e07; font-weight: normal;';
					str_element = '<span style="' + date_tyle + '">' + latest_date + '</span>';
				break;
				case 'HO2CA':
					date_tyle   = 'color: rgb(35, 84, 188); font-weight: normal;';
					str_element = '<span style="' + date_tyle + '">' + latest_date + '</span>';
				break;				
				case 'Plan':
					
					if(postpone_doc == 1) {
						date_tyle = 'background-color: #D1D1D1; border: 1px dotted red; padding: 2px; font-weight: bold;';
					} else if(postpone_doc == 2) {
						date_tyle = 'background-color: #E3C800; border: 1px dotted red; padding: 2px; font-weight: bold; margin: 3px 0;';
					} else if(postpone_doc >= 3) {
						date_tyle = 'background-color: #f16464; color: #000; border: 1px dotted #000; padding: 2px; font-weight: bold;';
					}
				
					str_element = '<span style="' + date_tyle + '">' + latest_date + '</span>';
					
				break;
				case '':
				case 'HOReceived':
				default:
					str_element = latest_date;
				break;
			}
	
			return str_element;
			
		} else { return ''; }
		
	}

	function status_workflow(object_data) {
		var appraisalchk  = (object_data.TotalDayCount == 'Y' || parseInt(object_data.TotalDayCount) == 1) ? 'Y':'N';
		var decision_aip  = (object_data.IsAIP == 'Y') ? object_data.IsAIP:'';
		var fileEstimate  = (object_data.ReceivedEstimateDoc == 'Y') ? object_data.ReceivedEstimateDoc:'';
		var ownership_doc = (object_data.OwnershipDoc == 'Y') ? object_data.OwnershipDoc:'';
		var decision	  = (object_data.Status) ? object_data.Status:'';
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
								
							}
							else if(appraisalchk == 'Y') { 
								str_style   = 'padding: 3px 7px; border-radius: 50%; background: #199a11; color: white; cursor: pointer;';
								str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
								
							} 
							else { str_element = decision; }	
							
						} else { str_element = decision; }

					}
					
				} else {
			
					if(decision == 'P') {
						
						if(fileEstimate == 'Y') { 
							str_style   = 'padding: 3px 7px; border-radius: 50%; background: #fa6800; color: white; cursor: pointer;';
							str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
							
						} 
						else if(appraisalchk == 'Y') { 
							str_style   = 'padding: 3px 7px; border-radius: 50%; background: #199a11; color: white;';
							str_element = '<span class="iconCursor" style="' + str_style + '">' + decision + '</span>';
							
						} 
						else { str_element = decision; }	
						
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
					
		} else { return ''; }
		
	}
	
	function drawdownInstallment(object_data, formatter) {
		var str_style	 = '';
		var str_element  = '';			
		var str_install  = '';
		
		if(formatter == 'date') { 
			str_install  = (!empty(object_data.DrawdownDate)) ? moment(object_data.DrawdownDate).format('DD/MM/YYYY'):''; 
		} else if(formatter == 'amount') {
			str_install  = (!empty(object_data.DrawdownBaht)) ? $filter('number')(checkNum(object_data.DrawdownBaht), 0):0;	
		}
		
		var doc_id  = (!empty(object_data.DocID)) ? object_data.DocID:'';;
		if(object_data.Installment == 'Y') {
			str_style   = 'background-color: #D1D1D1; border: 1px dotted red; padding: 2px; font-weight: bold;';
			str_element = '<span webui-tooltip config="webuiConfig" data="' + doc_id + '" class="iconCursor" style="' + str_style + '">' + str_install + '</span>';
			
		} else { str_element = str_install; }	

		return str_element;
		
	}
	
	function lb_info(lbName, object_data) {
		var str_style	 = '';
		var str_element  = '';		
	
		var str_toolip = (object_data.BranchName) ? object_data.BranchName + '/' + object_data.BranchTel:null;
		if(str_toolip && str_toolip != '') {
			str_element = '<span webui-tooltip-bundle config="webuiConfigBundle" data-content="' + str_toolip + '" class="iconCursor">' + lbName + '</span>';
		} else {
			str_element = lbName;
		}
		
		return str_element;
		
	}
	
	// FUNCTION
	function isEmpty(objVal) {
		if(objVal && objVal !== "" || objVal !== undefined) return objVal;
		else return null;
    }

    function empty(objVal) {
		if(isEmpty(objVal)) return false;
		else return true;
    }
    
	function number_verify(objVal) {
    	if(objVal && !isNaN(objVal) && objVal !== "") return parseInt(objVal);
    	else return 0;
    }
	
	function checkNum(objVal) {
		if(objVal && objVal !== "" && objVal > 0) return parseInt(objVal);
	    else return 0;
	}

	function period_state($nums) {       
        if($nums !== null && $nums !== undefined) {     	
        	if($nums <= 10) { return '<span class="fg-emerald">' + $nums + '</span>'; }
        	else if($nums >= 11 && $nums <= 20){ return '<span class="fg-amber">' + $nums + '</span>'; }
        	else if($nums >= 21) { return '<span class="fg-red">' + $nums + '</span>'; }
        } else { return ''; }
    	
    }
	
	function dataRangeSplit(object_data, formatter) {
		Date.prototype.toMSJSON = function () {
		    var date = '/Date(' + this.getTime() + ')/'; //CHANGED LINE
		    return date;
		};
		
		var pattern 	   	    = new RegExp("-");	
		var check_pattern 	    = pattern.test(object_data);

		var start_data			= null, 
			end_data 		    = null;
		
		if(check_pattern) {
			var item   	        = object_data.split("-");
			start_data          = item[0].trim();
			end_data	   	    = item[1].trim();

		} else { 
			start_data	   		= object_data 
			end_data			= object_data
		}
		
		if(formatter == 'date_th') {
			var date_1 = new Date(moment(start_data, 'DD/MM/YYYY').format('YYYY-MM-DD')).toMSJSON();
			var date_2 = new Date(moment(end_data, 'DD/MM/YYYY').format('YYYY-MM-DD')).toMSJSON();
			return [date_1, date_2];
		} if(formatter == 'date') {
			var date_1 = moment(start_data, 'DD/MM/YYYY').format('YYYY-MM-DD');
			var date_2 = moment(end_data, 'DD/MM/YYYY').format('YYYY-MM-DD');
			return [date_1, date_2];
		} else {
			return [start_data, end_data];
		}

	}
	
	function dataLoanSetter(loanField1, loanField2) {
		if((loanField1 && loanField1 > 0) && (loanField2 && loanField2 > 0)) {
			return [loanField1, loanField2].sort();
		} else {
			if(loanField1 > 0 && !loanField2) { return [loanField1, loanField1].sort(); } 
			if(loanField1 > 0 && loanField2 == 0) { return [loanField1, loanField1].sort(); } 
			else if(loanField2 > 0 && !loanField1) { return [loanField2, loanField2].sort(); } 
			else if(loanField2 > 0 && loanField1 == 0) { return [loanField2, loanField2].sort(); } 
			else { return null; }
		}
	}
	
	function sortByKey(array, key) {
        return array.sort(function(a, b) {
            var x = a[key]; var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }
	
	// PRINT PREVIEW HANDLE 
	$scope.print_whiteboard = function() {
	
		$('.progress').show();
		
		var object_regional  = ($scope.filter.regional && $scope.filter.regional.length > 0) ? $scope.filter.regional.join():null;
		var object_areas     = ($scope.filter.areas && $scope.filter.areas.length > 0) ? $scope.filter.areas.join():null;
		var object_branchs   = ($scope.filter.branch && $scope.filter.branch.length > 0) ? $scope.filter.branch.join():null;
		var object_employee  = ($scope.filter.employee && $scope.filter.employee.length > 0) ? $scope.filter.employee.join():null;
		
		// Product
		var product_loan 	 = [];
		var refinances	  	 = [];
		if($scope.filter.producttype && $scope.filter.producttype.length > 0) {
			$.each($scope.filter.producttype, function(index, value) {
				if(help.in_array(value, ['Refinance', 'Non Refinance'])) {
					if(!refinances[0]) product_loan.push('Secure');
					if(value == 'Refinance') refinances.push(1);
					else refinances.push(2);
				} else { product_loan.push('Clean'); }
				
			});
		}
		
		var str_productloan  = (!empty(product_loan[0])) ? product_loan.join():null;
		var str_refinances   = (!empty(refinances[0])) ? refinances.join():null;
		var product_list 	 = ($scope.filter.products && $scope.filter.products.length > 0) ? $scope.filter.products.join():null;
		
		var decision = [];
		if($scope.filter.decisionstatus && $scope.filter.decisionstatus.length > 0) {
			$.each($scope.filter.decisionstatus, function(index, value) {
				if(help.in_array(value, ['CANCEL_BP', 'CANCEL_AP'])) {
					if(!help.in_array(value, decision)) {
						if(value == 'CANCEL_BP') {
							decision.push('CANCELBYRM');
							decision.push('CANCELBYCUS');
						} else {
							decision.push('CANCELBYCA');
							//decision.push('CANCEL');
						}
					}	
					
				} else { decision.push(value); }
				
			});
			
		}
		
		//var str_decision	 = (!empty(decision[0])) ? decision.join():null;
		//var decision_reason  = ($scope.filter.decisionreason && $scope.filter.decisionreason.length > 0) ? $scope.filter.decisionreason.join():null;
		
		var decision_reason  = null;
		var str_decision	 = (!empty(decision[0])) ? decision.join():null;
		if($scope.filter.decisionreason.length > 0 && $scope.filter.pending_option.length > 0) {
			var marge_data = _.union($scope.filter.decisionreason, $scope.filter.pending_option);
			decision_reason  = (marge_data && marge_data.length > 0) ? marge_data.join() : null;
		} else {
			if($scope.filter.decisionreason.length > 0 && $scope.filter.pending_option.length == 0) {
				decision_reason  = ($scope.filter.decisionreason && $scope.filter.decisionreason.length > 0) ? $scope.filter.decisionreason.join():null;
			}
			
			if($scope.filter.pending_option.length > 0 && $scope.filter.decisionreason.length == 0) {
				decision_reason  = ($scope.filter.pending_option && $scope.filter.pending_option.length > 0) ? $scope.filter.pending_option.join():null;
			}
		}
	
		var ca_return  = '';
		var cr_passion = '';
		var bm_assign  = '';
		var retreieve  = [];
		var refercase  = [];
		var defendflag = [];
		var other_flag = [];
		var refer_data = ['Refer: Thai Life', 'Refer: Full Branch', 'Refer: Call Center', 'Tcrb: Facebook', 'Refer: RM', 'Refer: Customer'];
		if($scope.filter.optional && $scope.filter.optional.length > 0) {
			$.each($scope.filter.optional, function(index, value) {
				if(help.in_array(value, refer_data)) { refercase.push(value); } 
				else {

//					if(help.in_array(value, ['Submit', 'Defend 1', 'CA', 'Defend 2', 'Completed', 'Incompleted', 'CR'])) {
//					if(value == 'CR') { ca_return = 'Y' } 
					if(help.in_array(value, ['Submit', 'Defend 1', 'CA', 'Defend 2', 'Completed', 'Incompleted', 'CR_ONLY', 'CR_PASS'])) {
						if(help.in_array(value, ['CR_ONLY', 'CR_PASS'])) {
							if(value == 'CR_ONLY') ca_return  = 'Y';
							if(value == 'CR_PASS') cr_passion = 'Y';
							
						} else { defendflag.push(value); }
						
					} else if(help.in_array(value, ['RET', 'REA'])) {
						retreieve.push(value);
					} else if(help.in_array(value, ['BMRefer'])) {
						bm_assign = 'Y';
					} else {
						other_flag.push(value);
					}
					
				}
				
			});
		}
		
		var str_ca_return	 = (ca_return == 'Y') ? 'Y':null;
		var str_cr_passion	 = (cr_passion == 'Y') ? 'Y':null;
		var str_defendflag	 = (!empty(defendflag[0])) ? defendflag.join():null;
		var str_retreieve	 = (!empty(retreieve[0])) ? retreieve.join():null;
		var str_refercase	 = (!empty(refercase[0])) ? refercase.join():null;
		
		var object_startdate = (!empty($scope.filter.startdate)) ? dataRangeSplit($scope.filter.startdate, 'date_th'):null;
		var object_plana2ca  = (!empty($scope.filter.plana2cadate)) ? dataRangeSplit($scope.filter.plana2cadate, 'date'):null;
		var object_a2cadate  = (!empty($scope.filter.a2cadate)) ? dataRangeSplit($scope.filter.a2cadate, 'date_th'):null;
		var object_decision  = (!empty($scope.filter.decisiondate)) ? dataRangeSplit($scope.filter.decisiondate, 'date_th'):null;
		var object_plandd    = (!empty($scope.filter.plandrawdown)) ? dataRangeSplit($scope.filter.plandrawdown, 'date_th'):null;
		var object_drawdown  = (!empty($scope.filter.drawdowndate)) ? dataRangeSplit($scope.filter.drawdowndate, 'date_th'):null;
		
		var request_loan_set  = dataLoanSetter($scope.filter.requestloan_start, $scope.filter.requestloan_end);
		var approved_loan_set = dataLoanSetter($scope.filter.approvedloan_start, $scope.filter.approvedloan_end);
		var drawdown_loan_set = dataLoanSetter($scope.filter.drawdownloan_start, $scope.filter.drawdownloan_end);

		
		var borrowername	 = (!empty($scope.filter.borrowername)) ? $scope.filter.borrowername:null;
		var caname	 		 = (!empty($scope.filter.caname)) ? $scope.filter.caname:null;
		
		var cahsy_draft		 = ($scope.filter.cashy_noflag) ? 'N':null;
		var cashy_state		 = ($scope.filter.cashy_yesflag) ? 'Y':cahsy_draft;		
		var orderby_field	 = ($scope.grid_table) ? $scope.grid_table.fnSettings().aaSorting:null;
	
		var param = {
			AuthCode: $scope.auth_code,
			RegionCode: object_regional,
			AreaCode: object_areas,
			BranchCode: object_branchs,
			RMCode: object_employee,
			BorrowerName: borrowername,
			LoanType: str_productloan,
			Refinance: str_refinances,
			ProductProgram: product_list,
			BankList: null,			
			CAName: caname,
			Status: str_decision,
			StatusReason: decision_reason,
			StartDate: (!empty(object_startdate)) ? object_startdate[0]:null,
			EndDate: (!empty(object_startdate)) ? object_startdate[1]:null,
			PlanA2CA_StartDate: (!empty(object_plana2ca)) ? object_plana2ca[0]:null,
			PlanA2CA_EndDate: (!empty(object_plana2ca)) ? object_plana2ca[1]:null,
			A2CA_StartDate: (!empty(object_a2cadate)) ? object_a2cadate[0]:null,
			A2CA_EndDate: (!empty(object_a2cadate)) ? object_a2cadate[1]:null,
			Decision_StartDate: (!empty(object_decision)) ? object_decision[0]:null,
			Decision_EndDate: (!empty(object_decision)) ? object_decision[1]:null,
			DDPlan_StartDate: (!empty(object_plandd)) ? object_plandd[0]:null,
			DDPlan_EndDate: (!empty(object_plandd)) ? object_plandd[1]:null,
			Drawdown_StartDate: (!empty(object_drawdown)) ? object_drawdown[0]:null,
			Drawdown_EndDate: (!empty(object_drawdown)) ? object_drawdown[1]:null,
			Request_StartLoan: (!empty(request_loan_set)) ? request_loan_set[0]:null,
			Request_EndLoan: (!empty(request_loan_set)) ? request_loan_set[1]:null,
			Approved_StartLoan: (!empty(approved_loan_set)) ? approved_loan_set[0]:null,
			Approved_EndLoan: (!empty(approved_loan_set)) ? approved_loan_set[1]:null,
			Drawdown_StartLoan: (!empty(drawdown_loan_set)) ? drawdown_loan_set[0]:null,
			Drawdown_EndLoan: (!empty(drawdown_loan_set)) ? drawdown_loan_set[1]:null,
			Referal_Flag: str_refercase,
			Defend_Flag: str_defendflag,
			CeditReturn_Flag: str_ca_return,
			RET_Flag: str_retreieve,
			REA_Flag: 'PRINT', 
			Drawdown_Flag: ($scope.filter.drawdown_mth) ? 'Y':null,
			CN_Flag: ($scope.filter.cn_flag) ? 'Y':null,
			Cashy_Flag: cashy_state,
			MRTA_Flag: $scope.filter.application_no,			
			ReferByBM_Flag: (bm_assign == 'Y') ? 'Y':null, 
			SourceOfCustomer: ($scope.filter.performnaces) ? 'DD_PERFORMANCE':null,
			ReferalCode: orderby_field[0][0],
			PlanDDUnknow_Flag: orderby_field[0][1],
			PostponePlanA2CA: str_cr_passion,
			ActiveRecord: (help.in_array($scope.filter.activestate, ['Active', 'Inactive'])) ? $scope.filter.activestate:null
		};
		
		help.loadGridWhiteboardH4C(param).then(function(responsed) {
			$('.progress').hide();
			var data = (responsed.data) ? responsed.data:0;
			if(data && data.length > 0) {
				var popupWin = window.open('', '_blank', 'position: absolute, width=auto,height=auto,left=0,top=0');

            	var path_root	 = window.location.protocol + "//" + window.location.host + '/pcis/';
            	var boostrap_css = '<link rel="stylesheet" href="' + path_root + 'css/responsive/bootstrap.min.css">' +
            					   '<link rel="stylesheet" href="' + path_root + 'css/jquery-ui/jquery-ui.min.css">';
		            	
				var style_detail = '<link rel="stylesheet" href="' + path_root + 'css/custom/element-color-theme.css">' + 
								   '<link rel="stylesheet" href="' + path_root + 'css/metro/iconFont.css">' +
								   '<link rel="stylesheet" href="' + path_root + 'css/themify-icons.css">' +
							 	   '<link rel="stylesheet" href="' + path_root + 'css/flaticon/flaticon.css">' +
							       '<link rel="stylesheet" href="' + path_root + 'css/awesome/css/font-awesome.min.css">' + 
								   '<link rel="stylesheet" href="' + path_root + 'css/custom/whiteboard_printcss.css?v=007">';

				var table 	 = '';
				var thead	 = '';
				var tbody	 = '';
				var tfoot	 = '';
				var content  = '';
			
				thead = '<tr class="tableHeader">' +
						    '<th colspan="2">DATE</th>' +
						    '<th colspan="4">NAME</th>' +
						    '<th colspan="3">LOAN REQUEST</th>' +
						    '<th colspan="2">APP TO CA</th>' +
						    '<th colspan="4">STATUS ( P / A / R / C ) & CR</th>' +
						    '<th colspan="4">DRAWDOWN DATE</th>' +
						    '<th rowspan="2">ACTION NOTE</th>' +
						'</tr>' +
						'<tr class="tableHeader">' +
						    '<th>START</th>' +
						    '<th><i class="fa fa-flag-o print_hold"></i></th>' +
						    '<th>CUSTOMER</th>' +
						    '<th>RM</th>' +
						    '<th>CASHY</th>' +
						    '<th>TEAM</th>' +
						    '<th>PG</th>' +
						    '<th>AMT</th>' +
						    '<th><i class="fa fa-flag-o print_hold"></i></th>' +
						    '<th>DATE</th>' +
						    '<th>NAME</th>' +
						    '<th>ST</th>' +
						    '<th>DATE</th>' +
						    '<th>AMT</th>' +
						    '<th><i class="fa fa-flag-o print_hold"></i></th>' +
						    '<th>PLAN</th>' +
						    '<th>ACTUAL</th>' +
						    '<th>AMT</th>' +
						    '<th class="fixed"><i class="fa fa-flag-o print_hold"></i></th>' +     
						'</tr>';
				
				if(data.length > 0) {

					var toal_request_loan 	= 0;
					var total_approved_loan = 0;
					var total_drawdown_loan = 0;
					
					$.each(data, function(index, value) {

						var plana2ca_count	  = (value.PlanPostponeCount) ? value.PlanPostponeCount:'';
						var ca_status	  	  = (value.Status) ? value.Status:'';

						var plana2ca_date 	  = (value.PlanDocToCACondition) ? moment(value.PlanDocToCACondition).format('YYYY-MM-DD'):'';
						var a2ca_date	  	  = (value.CA_ReceivedDocDate) ? moment(value.CA_ReceivedDocDate).format('YYYY-MM-DD'):'';
						var status_date	  	  = (value.StatusDate) ? moment(value.StatusDate).format('YYYY-MM-DD'):'';
						var drawdown_date 	  = (value.DrawdownDate) ? moment(value.DrawdownDate).format('YYYY-MM-DD'):'';

						var request_loan  	  = (value.RequestLoan) ? parseInt(value.RequestLoan):'';
						var approved_loan 	  = (value.ApprovedLoan) ? parseInt(value.ApprovedLoan): ((value.PreLoan) ? parseInt(value.PreLoan):'');
						var drawdown_loan 	  = (ca_status == 'A' && value.DrawdownBaht) ? parseInt(value.DrawdownBaht):'';
						
						var action_note		  = (!empty(value.ActionNote)) ? value.ActionNote:'';
						var str_action_note	  = actionote_cutoff(action_note);
						
						var request_numformat  = (value.RequestLoan) ? $.number(value.RequestLoan, 0):'';
						var approve_numformat  = (value.ApprovedLoan) ? $.number(value.ApprovedLoan, 0): ((value.PreLoan) ? $.number(value.PreLoan, 0):'');
						var drawdown_numformat = (ca_status == 'A' && value.DrawdownBaht) ? $.number(value.DrawdownBaht, 0):'';

						var rm_onhand_sla 	  = (value.RMOnhandCount) ? value.RMOnhandCount:0;
						var decision_sla  	  = (value.CAOnhandCount) ? value.CAOnhandCount:0;
						var drawdown_sla  	  = (value.CADecisionCount) ? value.CADecisionCount:0;
						var total_sla	  	  = 0;

						total_sla		  	  = (checkNum(rm_onhand_sla) + checkNum(decision_sla) + checkNum(drawdown_sla) );

						toal_request_loan 	  += parseInt(checkNum(request_loan));
						total_approved_loan	  += parseInt(checkNum(approved_loan));
						total_drawdown_loan	  += parseInt(checkNum(drawdown_loan));
						
						tbody += 
						'<tr>' +
						    '<td class="text-center">' + moment(value.StartDate).format('DD/MM/YYYY') + '</td>' +
						    '<td class="text-center">' + period_state(total_sla) + '</td>' +
						    '<td class="text-left">' + divisionLayar(value.BorrowerName, value, 'borrower') + '</td>' +
						    '<td class="text-left">' + divisionLayar(value.RMName, value, 'BMRefer') + '</td>' +
						    '<td class="text-center">' + divisionLayar(value.Cashy, value, 'cashy') + '</td>' +
						    '<td class="text-center">' + divisionLayar(value.BranchDigit, value, 'branch') + '</td>' +
						    '<td class="text-center">' + divisionLayar(reforge_product(value.ProductCode), value, 'product') + '</td>' +
						    '<td class="text-right">' + request_numformat + '</td>' +						   
							'<td class="text-center">' + period_state(value.RMOnhandCount) + '</td>' +
						    '<td class="text-center">' + divisionLayar('', value, 'a2ca') + '</td>' +
						    '<td class="text-left">' + divisionLayar(value.CAName, value, 'defend') + '</td>' +
						    '<td class="text-center">' + divisionLayar(ca_status, value, 'status') + '</td>' +
						    '<td class="text-center">' + ((value.StatusDate) ? moment(value.StatusDate).format('DD/MM/YYYY'):'') + '</td>' +
						    '<td class="text-right">' + approve_numformat + '</td>' +
							'<td class="text-center">' + period_state(value.CAOnhandCount) + '</td>' +
						    '<td class="text-center">' + ((value.PlanDrawdownDate) ? moment(value.PlanDrawdownDate).format('DD/MM/YYYY'):'') + '</td>' +
						    '<td class="text-center">' + ((ca_status == 'A' && value.DrawdownDate) ? moment(value.DrawdownDate).format('DD/MM/YYYY'):'') + '</td>' +
						    '<td class="text-right">' + drawdown_numformat + '</td>' +						    
						    '<td class="text-center">' + ((ca_status == 'A') ? period_state(value.CADecisionCount):'') + '</td>' +
							'<td class="text-left">' + str_action_note + '</td>' +     
						'</tr>';				
					});
					
				} else { tbody = '<tr><td colspan="20" class="text-center">ไม่พบข้อมูล</td></tr>'; }

				var total_request_numformat  = (toal_request_loan) ? $.number(toal_request_loan, 0):'';
				var total_approve_numformat  = (total_approved_loan) ? $.number(total_approved_loan, 0):'';
				var total_drawdown_numformat = (total_drawdown_loan) ? $.number(total_drawdown_loan, 0):'';

				tfoot = '<tr>' +
							'<td colspan="7" class="text_bold">TOTAL</td>' +
							'<td class="text_bold">' + total_request_numformat + '</td>' + 
							'<td colspan="5"></td>' +
							'<td class="text_bold">' + total_approve_numformat + '</td>' +
							'<td colspan="3"></td>' +
							'<td class="text_bold">' + total_drawdown_numformat + '</td>' +
							'<td colspan="2"></td>' +
						'</tr>';
				
				table = '<table id="whiteboard" class="table table-bordered">' + 
							'<thead>' + thead + '</thead>' +
							'<tbody>' + tbody + '</tbody>' +
							'<tfoot>' + tfoot + '<tfoot>' +
						'</table>';

				var title_name = 'Sales Whtieboard (Internal used only)';
				
				popupWin.document.open();
				popupWin.document.write('<html><title>' + title_name + '</title>' + boostrap_css + style_detail + '<body onload="window.print()">' +  table + '</body></html>');
				popupWin.document.close();

            }   
			
		});

	}
	
	function getColumnNames(cols, desc) {
		if(cols) {
			switch(cols) {
				case '':
					
					break;
				default:
					return '';
					break;
			}
		}
	}
	
	function actionote_cutoff(str_note) {
		var str_text = '';
		if(str_note !== '') {
			if(str_note.length >= 185) {
				str_text = str_note.substring(0, 185) + '...';
			} else {
				str_text = str_note;
			}
	
		} else {
			str_text = str_note;
			
		}
	
		return str_text;
	}
	
	function divisionLayar(cellVal, objVal, mode) {
        var division = '';
        var style	 = 'style="border-bottom: 1px solid #D1D1D1;"';
        var classes	 = 'partition';
      
        if(objVal) {

			if(mode != '') {
				
				switch (mode) {		
					case 'borrower':						
						var appno = (objVal.ApplicationNo) ? objVal.ApplicationNo:'';
						var latestprogress  = (objVal.LatestAppProgress) ? objVal.LatestAppProgress:'';
						var draft = '';
						
						if(objVal.ActionNote && objVal.ActionNote.length >= 140) {
							draft = cellVal;
						} else {
							if(cellVal && cellVal.length >= 15) draft = cellVal.substring(0, 15) + '...';
							else draft = cellVal;
						}
	
						division = '<div class="partition text-left" ' + style + '>' + appno + '</div><div class="partition">' + draft + '</div>';
						
					break;
					case 'cashy':
						var cashy = (objVal.Cashy) ? objVal.Cashy:'';
						if(cashy == 'Y') division = cellVal;
						else division = '';
					break;
					case 'BMRefer':
						var bm_refer = (objVal.OptionRefer) ? objVal.OptionRefer:'';
						if(!empty(bm_refer)) division = '<div class="partition text-left" ' + style + '>Refer By BM</div><div class="partition">' + cellVal + '</div>'; 
						else division = cellVal;
					break;
					case 'branch':
						var refer = (objVal.SourceCustDigit) ? objVal.SourceCustDigit:'';
						var refer_check = (objVal.SourceCustDigit) ? objVal.SourceCustDigit.substring(0, 4):'';
						if(!empty(refer) && refer_check == 'R/TL') division = '<div class="partition text-center" ' + style + '>' + refer + '</div><div class="partition">' + cellVal + '</div>'; 
						else division = cellVal;
						
					break;
					case 'product':
						var bank = (objVal.Bank) ? objVal.Bank:'';					
						if(!empty(bank)) division 	= '<div class="partition text-center" ' + style + '>' + bank + '</div><div class="partition">' + cellVal + '</div>'; 
						else division = cellVal;
						
					break;					
					case 'a2ca':
						var latest_a2cadate = (objVal.LatestAppProgressDate) ? moment(objVal.LatestAppProgressDate).format('DD/MM/YYYY'):'';
						var latestprogress  = (objVal.LatestAppProgress) ? objVal.LatestAppProgress:'';
						var plana2ca_count  = (objVal.PlanPostponeCount && objVal.PlanPostponeCount > 0) ? ' ' + objVal.PlanPostponeCount:'';
					
						var str_text 		= '';
						if(help.in_array(latestprogress, ['Plan'])) { 
							var dfno = (plana2ca_count) ? plana2ca_count:' 1';
							str_text = latestprogress + dfno; 
						} else { 
							if(!help.in_array(latestprogress, ['RMOnhand'])) { str_text = latestprogress; } 
						}
						
						if(!empty(str_text)) {
							division = '<div class="partition text-center" ' + style + '>' + str_text + '</div><div class="partition">' + latest_a2cadate + '</div>';
						} else {
							division = latest_a2cadate;
						}
									
					break;
					case 'defend':
						var defend = (objVal.IsDefend) ? objVal.IsDefend:'';
						var caname = (objVal.CAName) ? objVal.CAName:'';
						if(!empty(defend) && !empty(caname)) division = '<div class="partition text-center" ' + style + '>DEF-' + defend + '</div><div class="partition">' + caname + '</div>'; 
						else division = caname;
						
					break;
					case 'status':

						if(help.in_array(cellVal, ['P', 'A'])) {
							
							var ownership_doc = (objVal.OwnershipDoc == 'Y') ? 'Y':'N';
							var fileEstimate  = (objVal.ReceivedEstimateDoc == 'Y') ? 'Y':'N';
							var decision_aip  = (objVal.IsAIP == 'Y') ? 'Y':'N';
							
							if(ownership_doc == 'Y') {								
								if(help.in_array(cellVal, ['A'])) { division = '<div class="partition iconCursor text-center" ' + style + '>กสปส</div><div class="partition text-center">' + cellVal + '</div>'; }
								else  { division = cellVal; }
								
							} else {
						
								if(cellVal == 'P') {
									
									if(fileEstimate == 'Y') { division = '<div class="partition iconCursor text-center" ' + style + '>รับเล่ม</div><div class="partition">' + cellVal + '</div>'; } 
									else if(decision_aip == 'Y') { division = '<div class="partition iconCursor text-center" ' + style + '>AIP</div><div class="partition">' + cellVal + '</div>'; } 
									else { division = cellVal; }	
									
								} else { 		
									
									if(objVal.StatusDesc == 'SCORE PASS-NRW') {
										division = '<div class="partition iconCursor text-center" ' + style + '>' + cellVal + '</div><div class="partition">NRW</div>';
									} else {
										division = cellVal; 
									}									
									
								}
								
							}
							
						} else { division = cellVal; }
							
					break;
	        	}
				
				return division;
	        	
			} else { return ''; }
   
        } else { return ''; }
	
    }
		
});