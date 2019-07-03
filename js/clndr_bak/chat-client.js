angular.module("chat-client", [
    "ui.bootstrap"
])
    .constant("uiMultipleSelectConfig", {select: {}})
    .constant("uiChatClientConfig", {
        permission: ['57251', '56225', '58141', '56679', '58106', '59016', '58385', '57160', '58355', '56365']
    })
    .factory("socket", function ($rootScope) {
        var socket = io.connect("http://tc001pcis1p", {path: '/node/pcischat/socket.io', "forceNew": true});
        //var socket = io.connect("http://localhost:1337", {"forceNew": true});
        return {
            on: function (eventName, callback) {
                socket.on(eventName, function () {
                    var args = arguments;
                    $rootScope.$apply(function () {
                        callback.apply(socket, args);
                    });
                });
            },
            emit: function (eventName, data, callback) {
                socket.emit(eventName, data, function () {
                    var args = arguments;
                    $rootScope.$apply(function () {
                        if (callback) {
                            callback.apply(socket, args);
                        }
                    });
                });
            }
        };
    })
    .directive('fileModel', function ($parse) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                var model = $parse(attrs.fileModel);
                var modelSetter = model.assign;

                element.bind('change', function () {
                    scope.$apply(function () {
                        modelSetter(scope, element[0].files[0]);
                    });
                });
            }
        };
    })
    .service('fileUpload', function ($http) {
        this.uploadFileToUrl = function (file, uploadUrl) {
            var fd = new FormData();
            fd.append('file', file);

            $http.post(uploadUrl, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
            })

                .success(function () {
                })

                .error(function () {
                });
        }
    })
    .factory("helper", function ($q, $http, $filter, fileUpload) {
        var fn = {};
        var link = "http://172.17.9.94/pcisservices/PCISService.svc/";
        //var link = "http://localhost:54379/PCISService.svc/";
        var links = "http://172.17.9.94/newservices/LBServices.svc/";
        //var links = "http://localhost:59392/LBServices.svc/";

        fn.servicesMethod = {
            getChatUser: "GetChatUser",
            getChatHistory: "GetChatHistory",
            getListChatUser: "GetListChatUser",
            insertChatHistory: "InsertChatHistory",
            updateChatHistory: "UpdateChatHistory",
            deleteChatHistory: "DeleteChatHistory",
            getChatRecentMessage: "GetChatRecentMessage",
            createGroupChat: "CreateGroupChat",
            insertGroupUser: "InsertGroupUser",
            updateGroupUser: "UpdateGroupUser",
            updateGroupChat: "UpdateGroupChat",
            getListChatGroup: "GetListChatGroup",
            getBroadCastHistoryData: "GetBroadCastHistoryData",
            insertBroadCastHistory: "InsertBroadCastHistory",
            getBroadCastHistory: "GetBroadCastHistory",
            updateBroadCastHistory: "UpdateBroadCastHistory",
            getMasterPosition: "GetMasterPositionBroadcast",
            getMasterEmployee: "GetMasterEmployeeBroadcast",
            getMasterBranch: "GetMasterBranchBroadcast",
            getMasterRegion: "GetMasterRegion",
            getNotification: "GetNotification",
            updateNoContactPerson: "UpdateNoContactPerson"
        };

        fn.formatDateTime = {
            formatToServer: "yyyy-MM-dd HH:mm:ss.fff",
            formatNormal: "dd/MM/yyyy HH:mm:ss",
            formatForChat: "dd/MM/yyyy AT HH:mm"
        };

        fn.broadcasthistory_insert = function (BroadCastId, ObjBroadCastHistory) {
            var url = links + "broadcast/" + BroadCastId + "/history";
            return executeservice("post", url, ObjBroadCastHistory);
        };

        function executeservice(type, url, param) {
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

        fn.callservice = function (type, name, param) {
            var deferred = $q.defer();

            var url = "http://localhost:59392/LBServices.svc/" + name;


            //$.ajax({
            //    type: "GET",
            //    url: url + "/alsdfjk",
            //    contentType: "application/json; charset=utf-8",
            //    dataType: "json",
            //    success: function (msg) {
            //        console.log(msg);
            //    }
            //});

            //var config = {
            //    headers: {'Content-Type': 'application/json'},
            //    data: param
            //};

            /*------------  Upload File  -------------*/
            //var file = $("#files");
            //var fd = new FormData();
            //fd.append('file', file);
            //name = "file";
            //url += "/" + file[0].files[0].name;
            //
            //$http.post(url, fd, {
            //    transformRequest: angular.identity,
            //    headers: {'Content-Type': undefined}
            //}).success(function (resp) {
            //    console.log(resp);
            //}).error(function (error) {
            //    console.log(error);
            //});
            /*-----------------------------------------*/

            //$http({
            //    method: "POST",
            //    header: {'Content-Type': 'application/json'},
            //    url: url,
            //    data: param
            //}).then(function successCallback(resp) {
            //    deferred.resolve(resp);
            //}).then(function errorCallback(error) {
            //    deferred.reject(error);
            //});

            //$http.get(url).then(function (resp, error) {
            //    console.log(resp);
            //});

            var param = {
                BroadCastHistory_EmpCode: "fff",
                BroadCastHistory_Message: "ggg",
                BroadCastHistory_Status: "hh",
                BroadCastHistory_Active: "jj",
                Own_EmpCode: "lll",
                Position: "lllklklkl",
                RegionID: "mmm",
                BranchCode: "ooo"
            };

            url = "http://localhost:59392/LBServices.svc/broadcast/000001/history";
            $http.post(url, param).then(function (resp, error) {
                console.log(resp);
            });


            //$http(config).then(function (resp) {
            //    deferred.resolve(resp);
            //}, function (error) {
            //    deferred.reject(error);
            //});
            //$http.post(url, config).then(function (resp) {
            //    deferred.resolve(resp);
            //}, function (error) {
            //    deferred.reject(error);
            //});

            //$.ajax({
            //    url: url,
            //    data: JSON.stringify(param),
            //    type: "POST",
            //    contentType: "application/json",
            //    dataType: "json",
            //    //crossDomain:true,
            //    success: function(resp){
            //        deferred.resolve(resp);
            //    },
            //    error: function (error) {
            //        deferred.reject(error);
            //    }
            //});

            return deferred.promise;
        };

        fn.md5 = function (value) {
            return CryptoJS.MD5(value.toString()).toString();
        };

        fn.generateUUID = function () {
            var d = new Date().getTime();
            var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                var r = (d + Math.random() * 16) % 16 | 0;
                d = Math.floor(d / 16);
                return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
            });
            return uuid;
        };

        fn.urlText = function (html) {
            var tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            var urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
            return tmp.innerText.replace(urlRegex, function (url) {
                return '\n' + '<a href="' + url + '">' + url + '</a>'
            })
        };

        fn.convertDateFormat = function (date, format) {
            return $filter("date")(new Date(date), format);
        };

        fn.whereObject = function (objData, objSearch) {
            return $filter("filter")(objData, objSearch, true);
        };

        fn.executeServices = function (servicesMethod, objParam) {
            var deferred = $q.defer();

            var url = link + servicesMethod + "?callback=JSON_CALLBACK";

            var config = {params: objParam};

            $http.jsonp(url, config).then(function (resp) {
                deferred.resolve(resp);
            }, function (error) {
                deferred.reject(error);
            });

            return deferred.promise;
        };

        return fn;
    })
    .filter('trim', function () {
        return function (data, key) {

            return angular.forEach(data, function (item) {

                if (angular.isArray(key)) {
                    angular.forEach(key, function (itemKey) {
                        item[itemKey] = $.trim(item[itemKey]);
                    });
                }
                else {
                    item[key] = $.trim(item[key]);
                }

            });
        }
    })
    .directive("enterSubmit", function () {
        return {
            restrict: "A",
            link: function (scope, elem, attrs) {
                elem.bind("keydown", function (event) {
                    var code = event.keyCode || event.which;
                    if (code === 13 && !event.shiftKey) {
                        event.preventDefault();
                        scope.$apply(attrs.enterSubmit);
                    }
                });
            }
        };
    })
    .directive("onLastRepeat", function () {
        return function (scope, elem, attrs) {
            if (scope.$last)
                setTimeout(function () {
                    scope.$emit(attrs.onLastRepeat, elem, attrs);
                }, 1);
        }
    })
    .directive("disableAnimate", function ($animate) {
        return function (scope, element) {
            $animate.enabled(false, element);
        };
    })
    .directive("waves", function () {
        return {
            restrict: "A",
            scope: {
                wavesEffect: "="
            },
            link: function (scope, elem, attrs) {
                if (angular.isArray(scope.wavesEffect)) {
                    angular.forEach(scope.wavesEffect, function (item) {
                        elem.addClass(item);
                    });
                }
                else {
                    elem.addClass(scope.wavesEffect);
                }
                Waves.displayEffect();
            }
        };
    })
    .directive('compileHtml', function ($compile) {
        return function (scope, element, attrs) {
            scope.$watch(
                function (scope) {
                    return scope.$eval(attrs.compileHtml);
                },
                function (value) {
                    element.html(value);
                    $compile(element.contents())(scope);
                }
            );
        };
    })
    .directive('ngDatePicker', function ($filter) {
	    return {
	        restrict: 'A',
	        require: 'ngModel',
	        scope: {
	            ngModel: '=',
	            modelFormat: '@',
	            config: '='
	        },
	        link: function (scope, element, attrs, ctrl) {
	    
	            angular.extend(scope.config, {
	                onSelect: function (date) {
	
	                    ctrl.$viewValue = date;
	                    ctrl.$render();
	
	                    if (scope.modelFormat) {
	                        var nDate = element.datepicker('getDate');
	                        ctrl.$modelValue = $filter("date")(nDate, scope.modelFormat);
	                        scope.ngModel    = $filter("date")(nDate, scope.modelFormat);
	                        
	                    } else {
	                        ctrl.$modelValue = date;
	                        scope.ngModel    = date;
	                        
	                    }
	  
	                    scope.$apply();
	                }
	            });
	
	            scope.$watchCollection('config', function (newValue) {
	            	console.log(scope.config);
	                $(element).datepicker("destroy");
	                $(element).datepicker(newValue);
		        	
	            });
	        }
	    };
	})
    .directive('focus', function ($timeout) {
        return {
            scope: {
                trigger: '=focus'
            },
            link: function (scope, element) {
                scope.$watch('trigger', function (value) {
                    if (value === true) {
                        $timeout(function () {
                            element[0].focus();
                        });
                    }
                });
            }
        };
    })
    .directive("scrollLoadMore", function () {
        return {
            scope: {
                scrollLoadMore: "&"
            },
            link: function (scope, elem, attrs) {
                elem.bind("scroll", function () {
                    var raw = elem[0];
                    var scrollTo = attrs.scrollTo;

                    switch (scrollTo.toLowerCase()) {
                        case "bottom":
                            if (raw.scrollTop + raw.offsetHeight + 5 >= raw.scrollHeight)
                                if (angular.isFunction(scope.scrollLoadMore)) {
                                    scope.$apply(scope.scrollLoadMore());
                                }
                            break;
                        case "top":
                            if (raw.scrollTop <= 300)
                                if (angular.isFunction(scope.scrollLoadMore)) {
                                    scope.$apply(scope.scrollLoadMore());
                                }
                            break;
                    }
                });
            }
        };
    })
    .directive("autoGrow", function () {
        return {
            restrict: "A",
            link: function (scope, elem, attrs) {
                elem.keyup(function () {
                    if (elem.val())
                        elem.css("height", elem.prop("scrollHeight"));
                    else
                        elem.css("height", 40);
                });
            }
        };
    })
    .directive("showSubMenu", function () {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                var target = $("#" + attrs.showSubMenu);
                attrs.expanded = true;

                element.bind('click', function (event) {
                    event.stopPropagation();
                    clickFunction();
                });

                function clickFunction() {
                    attrs.expanded = !attrs.expanded;

                    if (!attrs.expanded) {
                        $("#" + attrs.showSubMenu).css({opacity: 0, display: 'none'});
                        element.find(".slide-icon").addClass("fa-chevron-circle-down");
                        element.find(".slide-icon").removeClass("fa-chevron-circle-up");
                    } else {
                        $("#" + attrs.showSubMenu).css({opacity: 1, display: 'block'});
                        element.find(".slide-icon").removeClass("fa-chevron-circle-down");
                        element.find(".slide-icon").addClass("fa-chevron-circle-up");
                    }
                };
            }
        }
    })
    .directive("ngMultiselect", function (uiMultipleSelectConfig, $timeout) {
        return {
            restrict: "A",
            scope: {
                model: '=ngModel',
                multiselectData: "=",
                multiselectDefaultValue: "=",
                multiselectConfig: "=",
                multiselectButtonText: "@",
                multiselectEnableFilter: "=",
                multiselectEnableOptionGroup: "="
            },
            link: function (scope, element, attrs) {

                var nameObjSelect = attrs.name ? attrs.name : attrs.multiselectData;
                uiMultipleSelectConfig.select[nameObjSelect] = element;

                scope.$watch("multiselectData", function () {

                    scope.$evalAsync(function () {
                        if (!angular.isDefined(scope.multiselectInitialized)) {
                            scope.multiselectInitialized = true;
                            var opt = setMultiSelectConfig();
                            element.multiselect(opt);
                        }
                        else {
                            element.multiselect('rebuild');
                        }

                        if (scope.multiselectDefaultValue)
                            if (scope.multiselectDefaultValue.length > 0 || scope.multiselectDefaultValue != "")
                                setDefaultValue(scope.multiselectDefaultValue);
                    });

                });

                scope.$watch("multiselectConfig", function (nValue, oValue) {
                    scope.$evalAsync(function () {
                        if (nValue && !angular.equals(nValue, oValue)) {
                            if (nValue.length > 0) {
                                element.multiselect("setOptions", nValue);
                                element.multiselect('rebuild');
                            }
                        }
                    });
                });

                scope.$watch("multiselectDefaultValue", function (nValue, oValue) {
                    if (nValue && !angular.equals(nValue, oValue)) {
                        //if (nValue.length > 0)
                        setDefaultValue(nValue);
                    }
                });

                function setDefaultValue(value) {

                    element.multiselect('deselectAll', false);

                    if (element.find("[value*='string']").length > 0) {
                        element.multiselect('select', initializedDefaultValue(value, "string"), true);
                    }
                    else if (element.find("[value*='number']").length > 0) {
                        element.multiselect('select', initializedDefaultValue(value, "number"), true);
                    }
                    else {
                        element.multiselect('select', initializedDefaultValue(value), true);
                    }

                    element.multiselect('refresh');
                    element.multiselect('updateButtonText');
                }

                function setMultiSelectConfig() {
                    var config = {};

                    var multiConfig = scope.multiselectConfig;
                    var btnText = scope.multiselectButtonText;
                    var enableFilter = scope.multiselectEnableFilter;

                    if (multiConfig)
                        angular.extend(config, angular.fromJson(multiConfig));

                    config.enableFiltering = !enableFilter && typeof(enableFilter) == 'boolean' ? false : true;

                    if (scope.multiselectEnableOptionGroup) {
                        config.enableCollapsibleOptGroups = true;
                    }

                    if (btnText) {
                        config.buttonText = function (options, select) {

                            if (options.length === 0) {
                                return btnText + ' (0)';
                            }
                            else {
                                var len = options.length == select.find("option").length ? 'All' : options.length;
                                return btnText + ' (' + len + ')';
                            }
                        };
                    }

                    config.onChange = function (optionElement, checked) {
                        var selectedValue = element.find("option:selected").map(function (a, item) {
                            if (/string/.test(item.value)) {
                                return item.value.replace(/string:/, " ").trim();
                            }
                            else if (/number/.test(item.value)) {
                                return parseInt(item.value.replace(/number:/, " ").trim());
                            }
                            else if (/boolean/.test(item.value)) {
                                return item.value.replace(/boolean:/, " ").trim() === "true";
                            }
                        });

                        $timeout(function () {
                            scope.$apply(function () {
                                scope.model = selectedValue.get();
                            });
                        });
                    };

                    return config;
                }

                function initializedDefaultValue(value, format) {
                    var val = [];
                    angular.isArray(value) ? val = value : (value ? val.push(value) : val = []);
                    if (val.length > 0) {
                        return $.map(val, function (item) {
                            return (format ? format + ":" + item : item);
                        });
                    }
                    else {
                        return val;
                    }
                }
            }
        };
    })
    .directive("uiChatClient", function (uiChatClientConfig, socket, helper, $q, $filter, $log, $uibModal) {

        var pathArray = window.location.pathname.split('/'), newPathname = window.location.protocol + "//" + window.location.host;
        for (var i = 0; i < (pathArray.length - 1); i++) {
            newPathname += pathArray[i];
            newPathname += "/";
        }

        var option = '';
        var pathFixed = window.location.protocol + "//" + window.location.host + '/pcis/';
        if (pathArray[1] == 'pcis')
            option = 'js/clndr/';
        //else if ($('body').is('.calendar'))
        else
            pathFixed = "";

        return {
            restrict: "A",
            templateUrl: pathFixed + option + "chat-client-template/chat-client-template.html",
            scope: {
                uiChatClient: "=",
                directChatTo: "="
            },
            link: function (scope, elem, attrs) {

                //ion.sound({
                //    sounds: [
                //        {name: "beer_can_opening"},
                //        {name: "bell_ring"},
                //        {name: "branch_break"},
                //        {name: "button_click"},
                //        {name: "button_click_on"},
                //        {name: "button_push"},
                //        {name: "button_tiny"},
                //        {name: "camera_flashing"}
                //    ],
                //    path: pathFixed + option + "sounds/",
                //    preload: true,
                //    multiplay: true
                //});

                var modalIsOpen = false;
                var modalBroadCastIsOpen = false;
                scope.hasBroadCast = false;
                scope.filterItems = null;
                scope.userlimit = 10;
                scope.showMoreChat = 50;
                scope.imgPath = "../../img/announcement_icon.png";
                scope.imgChatPath = "../../img/chat-icon.png";
                scope.imgOutLookPath = "../../img/Outlook_icon.png";
                scope.imgGroupChat = "http://172.17.9.94/pciscalendar/images/logo-group-chat.jpg";
                scope.uriOutLook = "https://login.microsoftonline.com/login.srf?wa=wsignin1.0&rpsnv=4&ct=1461728916&rver=6.6.6556.0&wp=MBI_SSL&wreply=https%3a%2f%2foutlook.office.com%2fowa%2f%3frealm%3dtcrbank.com%26exch%3d1&id=260563&whr=tcrbank.com&CBCXT=out&msafed=0#";
                scope.nowdate = ("0" + new Date().getDate().toString()).slice(-2);
                scope.dialogPosition = "pull-right";
                scope.ownuser = null;
                scope.unReadMessage = [];
                scope.chatusers = [];
                scope.chatuserslist = [];
                scope.onlineUser = [];
                scope.chatRoomData = [];
                scope.currentChatInformation = null;
                scope.uriKpi = "";
                scope.uriCalendar = "";
                scope.newChatUser = {};
                scope.checkall = {};
                scope.isOpenSearch = false;
                scope.newChatUser.checked = [];
                scope.data = {
                    from: null,
                    to: null,
                    message: null,
                    sendtime: null
                };
                scope.showbutton = {
                    btn_calendar: $('body').is('.calendar'),
                    btn_kpi: $("[data-page=kpi]")[0] ? true : false,
                    btn_chat: "",
                    btn_boardcast: "",
                    btn_notification: ""
                };

                scope.defaultPositionValue = [];
                scope.defaultRegionValue = [];
                scope.defaultBranchValue = [];

                scope.masterPosition = [];
                scope.masterRegion = [];
                scope.masterBranch = [];
                scope.masterEmployee = [];

                scope.selectModel = {
                    positionSelectedData: [],
                    regionSelectedData: [],
                    branchSelectedData: [],
                    employeeSelectedData: [],
                    actionTypeSelectedData: [],
                    eventsTypeSelectedData: [],
                    locationTypeSelectedData: []
                };
                scope.selectOptions = {
                    buttonContainer: '<div class="dropdown"/>',
                    buttonClass: 'btn-broadcast-multiselect',
                    selectedClass: 'bg-success',
                    includeSelectAllOption: true,
                    buttonWidth: '100%',
                    disableIfEmpty: true
                };

                scope.countUnreadBroadCast = 0;
                scope.AuthToBroadCast = 0;
                scope.broadCastHistoryData = [];

                scope.countAllNotification = 0;
                scope.notificationData = [];

                function getLinkCalendar(newEmp) {
                    var uri = "";

                    if (!scope.showbutton.btn_calendar) {
                        if (newEmp) {
                            uri = "http://172.17.9.94/pciscalendar/index.html#/login/" + scope.data.from + "/" + newEmp;
                        }
                        else {
                            uri = "http://172.17.9.94/pciscalendar/index.html#/login/" + scope.data.from + "/" + scope.directChatTo.toString();
                        }
                    }

                    return uri;
                }

                function getLinkKPI() {
                    var uri = "";
                    if (!scope.showbutton.btn_kpi && scope.directChatTo) {
                        if (in_array(scope.data.from, uiChatClientConfig.permission))
                            uri = 'http://tc001pcis1p:8099/pcis/index.php/report/gridDataList?rel=' + scope.data.from + '&relsub=' + scope.directChatTo.toString() + '&editor=' + helper.md5(true) + '&permission=' + helper.md5(true);
                        else
                            uri = 'http://tc001pcis1p:8099/pcis/index.php/report/gridDataList?rel=' + scope.data.from + '&relsub=' + scope.directChatTo.toString() + '&editor=' + helper.md5(false) + '&permission=' + helper.md5(false);

                        function in_array(needle, haystack, argStrict) {

                            var key = '', strict = !!argStrict;

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
                    }
                    return uri;
                }

                if ($('body').is('.metro')) {
                    scope.imgPath = pathFixed + 'img/announcement_icon.png';
                    scope.imgChatPath = pathFixed + 'img/chat-icon.png';
                    scope.imgOutLookPath = pathFixed + 'img/Outlook_icon.png';
                }
                else if ($('body').is('.calendar')) {
                    scope.imgPath = 'images/announcement_icon.png';
                    scope.imgChatPath = 'images/chat-icon.png';
                    scope.imgOutLookPath = 'images/Outlook_icon.png';
                }
                else {
                    scope.imgPath = '../../img/announcement_icon.png';
                    scope.imgChatPath = '../../img/chat-icon.png';
                    scope.imgOutLookPath = '../../img/Outlook_icon.png';
                }

                if (attrs.chatDialogPosition) {
                    var position = attrs.chatDialogPosition;
                    switch (position.toLowerCase()) {
                        case "left":
                            scope.dialogPosition = "pull-left";
                            break;
                        case "right":
                            scope.dialogPosition = "pull-right";
                            break;
                    }
                }

                scope.$watch("uiChatClient", function (n, o) {
                    if (n) {
                        helper.executeServices(helper.servicesMethod.getListChatGroup, {OwnUser: n}).then(function (resp) {
                            var data = resp.data.Data;
                            var room = [];

                            if (data.length > 0)
                                room = data.map(function (item) {
                                    return item.Group_Code;
                                });

                            socket.emit("register:online", {
                                username: n.toString(),
                                groupchat: room
                            });
                            iniChat(n.toString());
                        });
                    }
                });

                scope.$watch("directChatTo", function (n, o) {
                    if (n) {
                        addUserStatusIcon(n);
                        scope.uriKpi = getLinkKPI();
                        scope.uriCalendar = getLinkCalendar();
                    }
                });

                scope.$watchCollection("newChatUser.checked", function (n, o) {
                    if (n.length > 1)
                        scope.showbtnNewGroup = true;
                    else {
                        scope.showbtnNewGroup = false;
                        scope.showNewGroup = false
                    }
                });

                scope.openGroup = function () {
                    scope.showNewGroup = !scope.showNewGroup;
                };

                scope.$watch(function () {
                    return elem.attr('direct-chat-to');
                }, function (empCode) {
                    if (empCode) {
                        addUserStatusIcon(empCode);
                        scope.uriKpi = getLinkKPI();
                        scope.uriCalendar = getLinkCalendar(empCode);
                    }
                });

                function iniChat(username) {
                    scope.data.from = username;
                    uiChatClientConfig.username = scope.data.from;
                    scope.getChatUser(username);
                    scope.getChatRecentMessage(username);
                    scope.getListChatUser(username);
                    scope.uriKpi = getLinkKPI();
                    scope.uriCalendar = getLinkCalendar();

                    iniBroadCast();
                    iniNotification();

                    if ($("#" + attrs.directChatClick)) {
                        var directChatUserObj = $("#" + attrs.directChatClick);
                        directChatUserObj.addClass("direct-chatuser");
                        directChatUserObj.click(function (e) {
                            var directEmpCode = scope.showbutton.btn_calendar ? scope.directChatTo.toString() : $("[direct-chat-to]").attr("direct-chat-to");
                            if (directEmpCode) {
                                if (directEmpCode == scope.data.from) {
                                    scope.openChatDialog("new");
                                }
                                else {
                                    var item = whereObject(scope.chatuserslist, {EmployeeCode: directEmpCode});
                                    if (item.length > 0) {
                                        scope.openChatDialog(item[0]);
                                    }
                                    else {
                                        var item = whereObject(scope.chatusers, {EmployeeCode: directEmpCode});
                                        if (item.length > 0)
                                            item[0].selected = true;

                                        scope.txtSearchUsers = directEmpCode;
                                        scope.openChatDialog("new");
                                    }
                                }
                            }
                        });
                    }
                }

                function iniBroadCast() {
                    getBroadCastHistory();
                }

                function iniNotification() {
                    helper.executeServices(helper.servicesMethod.getNotification, {OwnEmpCode: scope.data.from}).then(function (resp) {
                        var data = resp.data.Data;
                        scope.countAllNotification = data[0].CountAllNotification;
                        angular.copy(data, scope.notificationData);
                    });
                }

                function getBroadCastHistory(currentItem) {
                    helper.executeServices(helper.servicesMethod.getBroadCastHistoryData, {OwnEmpCode: scope.data.from}).then(function (resp) {
                        var data = resp.data.Data;
                        scope.countUnreadBroadCast = data[0].CountUnreadAllType;
                        scope.AuthToBroadCast = data[0].AuthToBroadCast;

                        data.map(function (item) {
                            var isSelect = false;

                            if (currentItem)
                                if (currentItem.BroadCast_Code == item.BroadCast_Code)
                                    isSelect = true;

                            return $.extend(item, {
                                selected: isSelect
                            });
                        });

                        angular.copy(data, scope.broadCastHistoryData);
                    });
                }

                function iniPosition() {
                    helper.executeServices(helper.servicesMethod.getMasterPosition, {OwnEmpCode: scope.data.from}).then(function (resp) {
                        scope.masterPosition = resp.data.Data;
                    });
                }

                function iniRegion() {
                    helper.executeServices(helper.servicesMethod.getMasterRegion, setParamMasterSelect()).then(function (resp) {
                        scope.masterRegion = resp.data.Data;
                    });
                }

                function iniBranch() {
                    helper.executeServices(helper.servicesMethod.getMasterBranch, setParamMasterSelect()).then(function (resp) {
                        scope.masterBranch = resp.data.Data;
                    });
                }

                function iniEmployee() {
                    helper.executeServices(helper.servicesMethod.getMasterEmployee, setParamMasterSelect()).then(function (resp) {
                        if (resp.data.Code == "100") {
                            scope.masterEmployee = [];
                        }
                        else {
                            scope.masterEmployee = resp.data.Data;
                        }
                    });
                }

                function setParamMasterSelect() {
                    return {
                        Position: scope.selectModel.positionSelectedData.length > 0 ? scope.selectModel.positionSelectedData.join(",") : null,
                        RegionID: scope.selectModel.regionSelectedData.length > 0 ? scope.selectModel.regionSelectedData.join(",") : null,
                        BranchCode: scope.selectModel.branchSelectedData.length > 0 ? scope.selectModel.branchSelectedData.join(",") : null,
                        OwnEmpCode: scope.ownuser ? scope.ownuser.EmployeeCode : null,
                        SystemUse: 'c'
                    };
                }

                scope.$watch("selectModel.positionSelectedData", function (nValue, oValue) {
                    if (nValue.length == 0) {
                        scope.defaultEmployeeValue = null;
                        scope.selectModel.employeeSelectedData = [];
                    }
                    iniEmployee();
                });

                scope.$watch("selectModel.regionSelectedData", function (nValue, oValue) {
                    if (nValue && !angular.equals(nValue, oValue)) {
                        iniBranch();
                        iniEmployee();
                    }
                });

                scope.$watch("selectModel.branchSelectedData", function (nValue, oValue) {
                    if (nValue && !angular.equals(nValue, oValue)) {
                        iniEmployee();
                    }
                });

                var watchUserDirectChat = null;

                function addUserStatusIcon(empcode) {
                    var obj = $("#" + attrs.chatStatus);

                    if (empcode) {
                        if (scope.chatusers.length > 0) {
                            var user = whereObject(scope.chatusers, {EmployeeCode: empcode})[0];
                            if (obj) {
                                obj.addClass("p-relative");
                                obj.find("i")[0] ? obj.find("i").replaceWith("<i></i>") : obj.append("<i></i>");

                                if (empcode == scope.data.from) {
                                    obj.find("i").removeClass("chat-status-offline");
                                    obj.find("i").addClass("chat-status-online");
                                }
                                else if ((user ? user.onlineStatus : false)) {
                                    obj.find("i").removeClass("chat-status-offline");
                                    obj.find("i").addClass("chat-status-online");
                                }
                                else {
                                    obj.find("i").removeClass("chat-status-online");
                                    obj.find("i").addClass("chat-status-offline");
                                }
                            }
                        }
                        else {
                            watchUserDirectChat = scope.$watchCollection('chatusers', function (n, o) {
                                if (n.length > 0) {
                                    addUserStatusIcon(empcode);
                                    watchUserDirectChat();
                                }
                            });
                        }
                    }
                }

                scope.getChatRecentMessage = function (username, showtoast) {
                    helper.executeServices(helper.servicesMethod.getChatRecentMessage, {OwnUser: username}).then(function (resp) {
                        var data = resp.data.Data;
                        angular.copy(data, scope.unReadMessage);
                        if (showtoast) {
                            var img = {};
                            if (showtoast.groupid || showtoast.information.Group_Id) {
                                img.FullNameEng = showtoast.groupname || showtoast.information.Group_Name;
                                img.UserImagePath = showtoast.groupimage || showtoast.information.Group_Image;
                            }
                            else {
                                var img = whereObject(scope.chatusers, {EmployeeCode: showtoast.from})[0];
                            }

                            Snarl.addNotification({
                                title: img.FullNameEng,
                                icon: '<div class="lv-avatar"><img src="' + img.UserImagePath + '" ></div>',
                                text: showtoast.message,
                                action: function (id) {
                                    scope.openChatDialog(showtoast.information, true);
                                }
                            });
                        }
                    });
                };

                scope.getChatUser = function (username) {
                    helper.executeServices(helper.servicesMethod.getChatUser).then(function (resp) {
                        var data = resp.data.Data;
                        var index = data.indexOf(whereObject(data, {EmployeeCode: username})[0]);
                        scope.ownuser = data.splice(index, 1)[0];
                        data.map(function (item) {
                            return $.extend(item, {
                                selected: false,
                                onlineStatus: scope.onlineUser.indexOf(item.EmployeeCode) < 0 ? false : true
                            });
                        });
                        angular.copy(data, scope.chatusers);
                    });
                };

                scope.getListChatUser = function (username, groupCode) {

                    helper.executeServices(helper.servicesMethod.getListChatUser, {Chat_From: username}).then(function (resp) {
                        var data = resp.data.Data;
                        data.map(function (item) {
                            if ((item.EmployeeCode || item.Group_Code) == groupCode) {
                                scope.currentChatInformation = item;
                            }

                            var isSelected = false;
                            if (scope.currentChatInformation) {
                                isSelected = scope.currentChatInformation.Group_Id ? scope.currentChatInformation.Group_Code == item.Group_Code : scope.currentChatInformation.EmployeeCode == item.EmployeeCode;
                            }

                            return $.extend(item, {
                                selected: false,
                                onlineStatus: scope.onlineUser.indexOf(item.EmployeeCode) < 0 ? false : true,
                                isSelected: isSelected
                            });
                        });
                        angular.copy(data, scope.chatuserslist);
                    });
                };

                scope.getChatRoomHistory = function () {
                    if (angular.isArray(scope.data.to)) {
                        scope.data.to = scope.currentChatInformation.EmployeeCode;
                    }

                    if (scope.currentChatInformation) {
                        if (scope.currentChatInformation.Chat_UserInGroup) {
                            scope.data.to = scope.currentChatInformation.Group_Code;
                        }
                    }

                    helper.executeServices(helper.servicesMethod.getChatHistory, {
                        Chat_From: scope.data.to,
                        Chat_To: scope.data.from,
                        ViewBy: scope.showMoreChat
                    }).then(function (resp) {
                        var data = resp.data.Data;

                        var subItem = {};
                        subItem["roomName"] = scope.data.to;
                        subItem["roomData"] = data;

                        var exitData = whereObject(scope.chatRoomData, {"roomName": scope.data.to})[0];
                        var index = scope.chatRoomData.indexOf(exitData);

                        if (index >= 0) {
                            angular.copy(subItem, scope.chatRoomData[index]);
                        }
                        else {
                            scope.chatRoomData.push(subItem);
                        }
                    });
                };

                scope.openChatDialog = function (value, isupdate) {
                    modalIsOpen = true;

                    var modalInstance = $uibModal.open({
                        animation: true,
                        windowClass: "animated zoomIn",
                        templateUrl: 'modalChat.html',
                        size: "lg",
                        scope: scope
                    });

                    iniChatHistory(value, isupdate);

                    modalInstance.result.then(function (resp) {
                        modalIsOpen = false;
                    }, function () {
                        scope.clearSearch();
                        scope.userlimit = 10;
                        modalIsOpen = false;
                        scope.isOpenSearch = false;
                        scope.currentChatInformation = null;
                    });
                };

                scope.openBroadCastDialog = function (value) {
                    modalBroadCastIsOpen = true;

                    if (scope.AuthToBroadCast == 1) {
                        iniPosition();

                        if (scope.ownuser.RegionID.trim() == '01')
                            iniRegion();

                        iniBranch();
                        iniEmployee();

                        if (scope.ownuser.AreaShortCode == 'HQ') {
                            scope.defaultPositionValue = ['RD', 'AM', 'BM', 'RM', 'Admin', 'DR'];
                        }
                        else {
                            if (scope.ownuser.ShortPosition == 'RD') {
                                scope.defaultPositionValue = ['AM', 'BM', 'RM', 'Admin'];
                            }
                            else {
                                scope.defaultPositionValue = ['AM', 'BM', 'RM', 'Admin'];
                            }
                        }

                    }

                    if (value) {
                        if (value == 'new') {
                            if (scope.AuthToBroadCast == 1) {
                                scope.hasBroadCast = true;
                                scope.broadCastSelectItem = $filter("orderBy")(scope.broadCastHistoryData, "-BroadCast_Priority")[0];
                            }
                        }
                        else {
                            scope.broadCastSelectItem = value;
                        }
                    }
                    else {
                        scope.broadCastSelectItem = $filter("orderBy")(scope.broadCastHistoryData, "-BroadCast_Priority")[0];
                    }

                    scope.broadCastSelectItem.selected = true;

                    //if (scope.broadCastSelectItem.CountUnreadByType > 0)
                    //    updateReadBroadCast(scope.broadCastSelectItem);

                    var modalInstance = $uibModal.open({
                        animation: true,
                        windowClass: "animated zoomIn",
                        templateUrl: 'modalBroadCast.html',
                        size: "lg",
                        scope: scope
                    });

                    modalInstance.result.then(function (resp) {
                    }, function () {
                        $.each(scope.broadCastHistoryData, function (index, item) {
                            item.selected = false;
                        });
                        scope.broadCastSelectItem = null;
                        modalBroadCastIsOpen = false;
                        scope.hasBroadCast = false;
                    });
                };


                scope.formatChatDateTime = function (datetime) {
                    return helper.convertDateFormat(datetime, helper.formatDateTime.formatForChat).toLowerCase();
                };

                scope.loadMoreUser = function () {
                    if (scope.userlimit < scope.chatusers.length)
                        scope.userlimit += 10;
                };

                scope.loadMoreChatHistory = function () {
                    //scope.showMoreChat += 50;
                    //$log.log(scope.showMoreChat);
                };

                scope.urlText = function (html) {
                    return helper.urlText(html);
                };

                scope.clearSearch = function () {
                    scope.txtSearchUsers = "";
                    scope.checkall.value = false;
                    scope.chatusers.map(function (item) {
                        item.selected = false;
                        return item;
                    });
                    scope.newChatUser.checked = whereObject(scope.chatusers, {selected: true});
                };

                function whereObject(obj, coditions) {
                    return helper.whereObject(obj, coditions);
                }

                function addOnlineUser(data, empCode, status) {

                    if (empCode && !status) {
                        empCode = empCode.userName;
                    }

                    scope.onlineUser = $.unique($.map(data, function (value) {
                        return value.userName;
                    }));

                    var hasOnline = $.grep(scope.onlineUser, function (item) {
                        return item == empCode;
                    });

                    if (hasOnline.length > 0 && !status) {
                        status = true;
                    }

                    if (scope.chatusers.length > 0) {
                        whereObject(scope.chatusers, {EmployeeCode: empCode}).map(function (item) {
                            item.onlineStatus = status;
                            return item;
                        });
                        whereObject(scope.chatuserslist, {EmployeeCode: empCode}).map(function (item) {
                            item.onlineStatus = status;
                            return item;
                        });
                    }

                    if (scope.directChatTo)
                        if (empCode == (scope.showbutton.btn_calendar ? scope.directChatTo.toString() : $("[direct-chat-to]").attr("direct-chat-to")))
                            addUserStatusIcon(empCode);

                }

                function sendUpdateStatusReadMessage(data) {
                    var objData = $.extend({}, data);
                    objData.isReadMessage = true;
                    objData.to = data.from;
                    objData.from = scope.data.from;
                    socket.emit("chat:to", objData);
                }

                socket.on("register:online", function (data) {
                    addOnlineUser(data.clients, data.username, true);
                });

                socket.on("disconnect", function (data, empCode) {
                    addOnlineUser(data, empCode, false);
                });

                socket.on("chat:to", function (data) {

                    if (modalIsOpen) {
                        if (scope.currentChatInformation && !scope.isOpenSearch) {

                            var currentEmpCode = scope.currentChatInformation.Group_Id ? scope.currentChatInformation.Group_Code : scope.currentChatInformation.EmployeeCode;
                            var currentFrom = scope.currentChatInformation.Group_Id ? data.to : data.from;

                            if (currentEmpCode == currentFrom || (currentEmpCode.length > 5 && angular.isArray(currentFrom))) {

                                if (!data.isReadMessage) {
                                    helper.executeServices(helper.servicesMethod.updateChatHistory, {
                                        Chat_From: scope.currentChatInformation.Group_Id ? scope.currentChatInformation.Group_Code : data.from,
                                        Chat_To: scope.currentChatInformation.Group_Id ? scope.data.from : data.to,
                                        Chat_Status: 'R'
                                    })
                                        .then(function (resp) {
                                            sendUpdateStatusReadMessage(data);
                                            scope.getListChatUser(scope.data.from);
                                            scope.getChatRoomHistory();
                                        });
                                }
                                else {
                                    scope.getListChatUser(scope.data.from);
                                    scope.getChatRoomHistory();
                                }
                            }
                            else {
                                scope.getChatRecentMessage(scope.data.from);
                                scope.getListChatUser(scope.data.from);
                            }
                        }
                        else {
                            scope.getChatRecentMessage(scope.data.from);
                            scope.getListChatUser(scope.data.from);
                        }
                    }
                    else {
                        if (!data.isReadMessage)
                            scope.getChatRecentMessage(scope.data.from, data);
                    }

                    //ion.sound.play("button_tiny");
                });

                socket.on("chat:reload", function (data) {
                });

                socket.on("chat:toTyping", function (data) {
                    $log.log(data);
                });

                socket.on("broadcast:to", function (data) {
                    $log.log(data);
                    if (modalBroadCastIsOpen) {
                        if (scope.broadCastSelectItem.BroadCast_Code == data.broadCastObj.BroadCast_Code) {
                            //updateReadBroadCast(data.broadCastObj);
                        }
                        else {
                            getBroadCastHistory(scope.broadCastSelectItem);
                        }
                    }
                    else {
                        getBroadCastHistory();

                        Snarl.addNotification({
                            title: data.broadCastObj.BroadCast_Name,
                            icon: '<i class="fa fa-feed m-r-5" style="transform: rotate(270deg);font-size: 35px; color: ' + data.broadCastObj.BroadCast_Color + '"></i>',
                            text: data.message,
                            timeout: 40000
                        });
                    }

                });

                socket.on("broadcast:all", function (data) {
                    $log.log(data);
                });

                socket.on("create:group", function (data) {
                });

                socket.on("subscribe:group", function (data) {
                });

                socket.on("unsubscribe:group", function (data) {
                });

                /*------------------ Modal Popup ---------------------------*/
                scope.txtSearchUsersChange = function (query) {
                    checkbox(query);
                };

                scope.toggleAll = function (query) {
                    $filter("filter")(scope.chatusers, query).map(function (item) {
                        item.selected = scope.checkall.value;
                        return item;
                    });
                    scope.newChatUser.checked = whereObject(scope.chatusers, {selected: true});
                };

                scope.optionToggled = function (query) {
                    checkbox(query);
                };

                scope.newChat = function () {
                    scope.isOpenSearch = !scope.isOpenSearch;

                    if (!scope.isOpenSearch) {
                        clearAllChecBox();
                    }

                    if (!scope.isOpenSearch && !scope.currentChatInformation) {
                        if (scope.chatuserslist.length > 0) {
                            setDefaultUserChatSelection();
                            scope.select(scope.currentChatInformation);
                        }
                        else {
                            scope.isOpenSearch = true;
                        }
                    }
                    else if (!scope.isOpenSearch && scope.currentChatInformation) {
                        scope.select(scope.currentChatInformation);
                    }
                };

                scope.rename = false;
                scope.oldGroupName = null;
                scope.groupRename = function () {
                    scope.rename = !scope.rename;

                    if (!scope.rename)
                        scope.currentChatInformation.Group_Name = scope.oldGroupName;
                    else
                        scope.oldGroupName = scope.currentChatInformation.Group_Name;
                };

                scope.changeGroupName = function () {
                    scope.rename = false;
                    scope.oldGroupName = null;
                    console.log(scope.currentChatInformation);
                    scope.currentChatInformation.Group_Code;
                    scope.currentChatInformation.Group_Name;
                };

                scope.newGroup = function (groupName, groupCode) {
                    var data = {};
                    data.from = scope.data.from;
                    data.to = scope.newChatUser.checked.map(function (item) {
                        return item.EmployeeCode;
                    });
                    data.groupid = helper.generateUUID();
                    data.groupname = groupName;
                    data.groupcode = groupCode;
                    data.groupimage = scope.imgGroupChat;

                    helper.executeServices(helper.servicesMethod.createGroupChat, {
                        Group_Code: data.groupid,
                        Group_Name: data.groupname,
                        Group_Image: data.groupimage,
                        Group_EmployeeCode: data.from,
                        Invite_EmployeeCode: data.to.join(",")
                    }).then(function (resp) {
                        var res = resp.data.Data[0];

                        scope.data.to = data.groupid;
                        data.message = res.Group_Message;

                        socket.emit("create:group", data);

                        scope.getListChatUser(scope.data.from, data.groupid);
                        scope.getChatRoomHistory();

                        scope.isOpenSearch = false;

                        clearAllChecBox();
                    });
                };

                scope.select = function (items) {
                    scope.chatuserslist.map(function (item) {
                        return item.isSelected = false;
                    });
                    items.isSelected = true;
                    scope.showNewGroup = false;
                    doUpdateChatHistory(items);
                };

                scope.sendMessage = function (message) {

                    if (message) {

                        if (scope.rename) {
                            scope.rename = false;
                            scope.currentChatInformation.Group_Name = scope.oldGroupName;
                        }

                        if (scope.isOpenSearch && !scope.newChatUser.checked)
                            return false;

                        if (scope.isOpenSearch) {
                            scope.currentChatInformation = scope.newChatUser.checked[0];
                            if (scope.newChatUser.checked.length > 1) {
                                scope.data.to = scope.newChatUser.checked.map(function (item) {
                                    return item.EmployeeCode;
                                }).join(",");
                            }
                            else {
                                if (scope.currentChatInformation) {
                                    scope.data.to = scope.currentChatInformation.EmployeeCode;
                                }
                                else {
                                    var item = whereObject(scope.chatusers, {EmployeeCode: scope.txtSearchUsers});
                                    scope.currentChatInformation = item[0];
                                    scope.data.to = scope.currentChatInformation.EmployeeCode;
                                }
                            }
                        }

                        var date = new Date();
                        var servertime = helper.convertDateFormat(date, helper.formatDateTime.formatToServer);

                        scope.data.message = message;
                        scope.data.sendtime = helper.convertDateFormat(date, helper.formatDateTime.formatForChat).toLowerCase();
                        scope.data.information = scope.currentChatInformation.Group_Id ? scope.currentChatInformation : scope.ownuser;

                        helper.executeServices(helper.servicesMethod.insertChatHistory,
                            {
                                Chat_From: scope.data.from,
                                Chat_To: scope.data.to,
                                Chat_Message: scope.data.message,
                                Chat_DateTime: servertime,
                                Chat_Type: scope.currentChatInformation.Group_Id ? "G" : "P",
                                Chat_Room: scope.currentChatInformation.Group_Id ? scope.currentChatInformation.Group_Code : null,
                                Chat_Status: "U",
                                Chat_Active: true
                            }
                        ).then(function (resp) {

                                if (scope.currentChatInformation.Chat_UserInGroup) {
                                    scope.data.to = scope.currentChatInformation.Chat_UserInGroup.split(",");
                                }
                                else {
                                    scope.data.to = scope.data.to.split(",");
                                }

                                socket.emit("chat:to", scope.data);

                                scope.getChatRoomHistory();
                                scope.getChatRecentMessage(scope.data.from);
                                scope.getListChatUser(scope.data.from);

                                scope.isOpenSearch = false;
                                scope.clearSearch();
                            });

                    }

                };

                scope.$on("focusLastChatHistory", function (scope, elem, attrs) {
                    elem.parents().animate({scrollTop: elem.parent().prop("scrollHeight")}, 500);
                });

                function clearAllChecBox() {
                    scope.chatusers.map(function (item) {
                        item.selected = false;
                        return item;
                    });
                    scope.checkall.value = false;
                    scope.newChatUser.checked = [];
                }

                function checkbox(query) {
                    var data = $filter("filter")(scope.chatusers, query);
                    if (data.length > 0) {
                        scope.checkall.value = whereObject(data, {selected: false}).length > 0 ? false : true;
                        scope.newChatUser.checked = whereObject(scope.chatusers, {selected: true});
                    }
                }

                function iniChatHistory(items, isUpdate) {
                    scope.getChatRecentMessage(scope.data.from);
                    scope.getListChatUser(scope.data.from);

                    if (angular.isObject(items)) {
                        doUpdateChatHistory(items, isUpdate);
                    }
                    else {
                        switch (items.toLowerCase()) {
                            case"new":
                                scope.newChat();
                                break;
                            case "view":
                                setDefaultUserChatSelection();
                                break;
                        }
                    }
                }

                function setDefaultUserChatSelection() {
                    var firstUserofChat = $filter("orderBy")(scope.chatuserslist, "-LastMessageTime")[0];
                    scope.data.to = firstUserofChat.EmployeeCode;
                    scope.currentChatInformation = firstUserofChat;
                }

                function doUpdateChatHistory(items, isUpdate) {
                    scope.isOpenSearch = false;
                    scope.data.to = items.Group_Id || items.Chat_Room ? items.Group_Code || items.Chat_Room : items.EmployeeCode;
                    scope.currentChatInformation = items;

                    if (items.CountUnreadByPerson > 0 || isUpdate) {
                        helper.executeServices(helper.servicesMethod.updateChatHistory, {
                            Chat_From: scope.data.to,
                            Chat_To: scope.ownuser.EmployeeCode,
                            Chat_Status: 'R'
                        })
                            .then(function (resp) {
                                sendUpdateStatusReadMessage({
                                    from: items.Chat_UserInGroup ? items.Chat_UserInGroup.split(",") : items.EmployeeCode,
                                    to: scope.ownuser.EmployeeCode
                                });
                                scope.getChatRecentMessage(scope.data.from);
                                scope.getListChatUser(scope.data.from);
                            });
                    }

                    scope.getChatRoomHistory();
                }

                scope.broadCastSelectItem = null;

                scope.broadCastSelect = function (items) {
                    scope.broadCastHistoryData.map(function (item) {
                        return item.selected = false;
                    });
                    items.selected = true;
                    scope.broadCastSelectItem = items;

                    if (items.CountUnreadByType > 0) {
                        //updateReadBroadCast(items);
                    }
                };

                scope.openBroadCast = function () {
                    scope.hasBroadCast = !scope.hasBroadCast;
                };

                scope.sendBroadCast = function (message) {

                    if (message) {
                        if (confirm("Confirm send broadcast message?")) {
                            var criteria = setParamMasterSelect();

                            var obj = {
                                BroadCast_Code: scope.broadCastSelectItem.BroadCast_Code,
                                BroadCastHistory_EmpCode: null,
                                BroadCastHistory_Message: $("#txtBroadCastMessage").val().replace(/\r\n?|\n/g, '<br />'),
                                Own_EmpCode: scope.data.from
                            };

                            $.extend(obj, criteria);

                            helper.broadcasthistory_insert(obj.BroadCast_Code, obj).then(function (resp) {
                                var data = resp.data;
                                console.log(data);

                                var objSocket = {};
                                objSocket.to = scope.masterEmployee.map(function (n) {
                                    return n.EmployeeCode;
                                });
                                objSocket.broadCastObj = scope.broadCastSelectItem;
                                objSocket.message = message;

                                socket.emit("broadcast:to", objSocket);

                                getBroadCastHistory(scope.broadCastSelectItem);

                                $("#txtBroadCastMessage").val("");
                                $("#txtBroadCastMessage").css("height", 40);
                            });
                        }
                    }
                };

                scope.updateBroadCastItem = function (items) {
                    updateReadBroadCast(items, items.BroadCastHistory_Id);
                };

                function updateReadBroadCast(items, historyCode) {

                    var broadCastCode = historyCode | items.BroadCast_Code;

                    var obj = {
                        BroadCast_Code: broadCastCode,
                        BroadCastHistory_EmpCode: scope.data.from
                    };

                    helper.executeServices(helper.servicesMethod.updateBroadCastHistory, obj).then(function (resp) {
                        var data = resp.data.Data;
                        getBroadCastHistory(items);
                    });
                }

                scope.updateNoContactPerson = function (event, item) {
                    event.preventDefault();
                    event.stopPropagation();

                    var val = confirm("Confirm this transaction?");
                    if (val) {
                        helper.executeServices(helper.servicesMethod.updateNoContactPerson, {Code: item.Color.split(',')[1]}).then(function (resp) {
                            iniNotification();
                        });
                    }
                };

            }
        };
    })
    .directive("mouseClick", function ($timeout) {
        return {
            restrict: "EA",
            link: function (scope, elem, attrs) {

                var mousePosition = {x: 0, y: 0};

                $(elem)
                    .mousemove(function (event) {
                        mousePosition.x = event.pageX;
                        mousePosition.y = event.pageY;
                    })
                    .mouseup(function () {
                        $(this).removeClass("mouse-down-top mouse-down-bottom mouse-down-right mouse-down-left");
                    }).mousedown(function () {
                        $(this).removeClass("mouse-down-top mouse-down-bottom mouse-down-right mouse-down-left");
                        mouseposition();
                    });

                $(".container").append('<div style="clear: both;"></div>');

                $timeout(function () {
                    if (!$(".container").hasClass(".container-slide"))
                        $(".container").addClass("container-slide");
                    elem.addClass("mouse-show");
                }, parseInt(Math.random() * 4 + 5) * 100);


                function mouseposition() {
                    var offset = elem.offset();
                    var width = elem.width();
                    var height = elem.height();

                    var centerX = ((offset.left * 2) + width) / 2;
                    var centerY = offset.top + height / 2;

                    $("#markX").css({left: ((offset.left * 2) + width) / 2});
                    $("#markY").css({top: ((offset.top * 2) + height) / 2, left: ((offset.left * 2) + width) / 2});

                    if (mousePosition.x >= ((centerX * 35 / 100) + centerX)) {
                        elem.addClass("mouse-down-right");
                    }
                    else if (mousePosition.x < (Math.abs((centerX * 35 / 100) - centerX))) {
                        elem.addClass("mouse-down-left");
                    }
                    else if (mousePosition.y >= centerY) {
                        elem.addClass("mouse-down-top");
                    }
                    else if (mousePosition.y < centerY) {
                        elem.addClass("mouse-down-bottom");
                    }
                }
            }
        }
    });

