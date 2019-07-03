var pcis_api = "http://localhost/pcis_api/index.php/api";
var whiteboard_module = angular.module("pcis-whiteboard", ["chat-client", "ui-notification"]);
whiteboard_module.factory("help", function($q, $http) {
	var fn = {};
	
	fn.whiteboard_read = function(param){
    	var url = links + 'collection';
    	return executeservice('post', url, param);
    }

	fn.in_array=function(r,n,f){var i="";if(!!f){for(i in n)if(n[i]===r)return!0}else for(i in n)if(n[i]==r)return!0;return!1};
	fn.number_format=function(n,r,e,i){var t=n,a=r,o=function(n,r){var e=Math.pow(10,r);return(Math.round(n*e)/e).toString()};t=isFinite(+t)?+t:0;var h,l,s=void 0===i?",":i,u=void 0===e?".":e,c=o((a=isFinite(+a)?Math.abs(a):0)>0?t:Math.round(t),a),d=o(Math.abs(t),a);d>=1e3?(l=(h=d.split(/\D/))[0].length%3||3,h[0]=c.slice(0,l+(t<0))+h[0].slice(l).replace(/(\d{3})/g,s+"$1"),c=h.join(u)):c=c.replace(".",u);var v=c.indexOf(u);return a>=1&&-1!==v&&c.length-v-1<a?c+=new Array(a-(c.length-v-1)).join(0)+"0":a>=1&&-1===v&&(c+=u+new Array(a).join(0)+"0"),c};
	
    function executeservice(e,t,n){var r=$q.defer();return $http[e](t,n).then(function(e){r.resolve(e)}).then(function(e){r.reject(e)}),r.promise}
          	
	return fn;
	
})
.controller("whiteboard_ctrl", function($scope, $filter, help, Notification, $log, $compile, $uibModal) {
	
	$scope.auth_code  	= $('#empprofile_identity').val();
	$scope.auth_role  	= $('#emp_role').val();
	
		
	$scope.table 	= null;
	console.log('test');
	
	$('#fttab').remove();
	
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
]);