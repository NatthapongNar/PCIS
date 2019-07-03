Date.prototype.toMSJSON = function () {
    var date = '/Date(' + this.getTime() + ')/'; //CHANGED LINE
    return date;
};
String.prototype.isEmpty = function () {
    return (this.length === 0 || !this.trim());
};

angular.module("chat-client", [
    "ui.bootstrap",
    "ngMaterial"
])
    .config(function ($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette('blue')
            .accentPalette('red');
    })
    .constant("uiMultipleSelectConfig", {select: {}, scroll: []})
    .constant("uiChatClientConfig", {
        permission: ['57251', '56225', '55143', '58141', '56679', '58106', '59016', '58385', '57160', '58355', '56365']
    })
    .factory("socket", function ($rootScope) {
        //var socket = io.connect("http://tc001pcis1p", {path: '/node/pcischat/socket.io', "forceNew": true});
        //var socket = io.connect("http://localhost:1337", {"forceNew": true});
        var socket = io.connect("http://172.17.9.94:5558");
        // var socket = io.connect("http://localhost:5555");
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
    .directive('ngTabs', function () {
        return {
            scope: true,
            restrict: 'EAC',
            controller: function ($scope) {
                $scope.tabs = {
                    index: 0,
                    count: 0
                };

                this.headIndex = 0;
                this.bodyIndex = 0;

                this.getTabHeadIndex = function () {
                    return $scope.tabs.count = ++this.headIndex;
                };

                this.getTabBodyIndex = function () {
                    return ++this.bodyIndex;
                };
            }
        };
    })
    .directive('ngTabHead', function () {
        return {
            scope: false,
            restrict: 'EAC',
            require: '^ngTabs',
            link: function (scope, element, attributes, controller) {
                var index = controller.getTabHeadIndex();
                var value = attributes.ngTabHead;
                var active = /[-*\/%^=!<>&|]/.test(value) ? scope.$eval(value) : !!value;

                scope.tabs.index = scope.tabs.index || (active ? index : null);

                element.bind('click', function () {
                    scope.tabs.index = index;
                    scope.$$phase || scope.$apply();
                });

                scope.$watch('tabs.index', function () {
                    element.toggleClass('active', scope.tabs.index === index);
                });
            }
        };
    })
    .directive('ngTabBody', function () {
        return {
            scope: false,
            restrict: 'EAC',
            require: '^ngTabs',
            link: function (scope, element, attributes, controller) {
                var index = controller.getTabBodyIndex();

                scope.$watch('tabs.index', function () {
                    element.toggleClass(attributes.ngTabBody + ' ng-show', scope.tabs.index === index);
                });
            }
        };
    })
    .directive('modalDragable', function () {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs) {
                $(elem).closest(".modal-dialog").css('cursor', 'pointer');
                $(elem).closest(".modal-dialog").draggable({handle: ".lv-header-alt"});
            }
        };
    })
    .directive('fileModel', function ($parse) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {

                element.bind('change', scope.$eval(attrs.fileChange));
                element.bind("change", function () {
                    $parse(attrs.fileModel).assign(scope.$parent, element[0].files);
                    scope.$apply();
                });

                //var model = $parse(attrs.fileModel);
                //var modelSetter = model.assign;
                //
                //element.bind('change', function () {
                //    scope.$apply(function () {
                //        modelSetter(scope, element[0].files[0]);
                //    });
                //});
            }
        };
    })
    .directive('inputFileChange', function () {
        return {
            restrict: "A",
            scope: {
                inputFileChange: "&"
            },
            link: function (scope, elem, attrs) {
                if (angular.isFunction(scope.inputFileChange)) {
                    elem.on("change", function (event) {
                        scope.event = event;
                        scope.$apply(scope.inputFileChange());
                    });
                    scope.$on('destroy', function () {
                        elem.off();
                    });
                }
            }
        };
    })
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
    .factory("helper", function ($q, $http, $filter) {
        var fn = {};
        var link = "http://172.17.9.94/pcisservices/PCISService.svc/";
        //var link = "http://localhost:54379/PCISService.svc/";
        var links = "http://172.17.9.94/newservices/LBServices.svc/";
        // var links = "http://localhost:59392/LBServices.svc/";

        fn.links = function () {
            return links;
        };

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

        fn.file_upload = function (fileName, files) {
            var deferred = $q.defer();

            var url = links + "file";

            var reader = new FileReader();

            reader.onload = function () {
                var param = {
                    FileName: fileName,
                    Size: files.size,
                    Type: files.type,
                    ByteFile: reader.result.split("base64,")[1]
                };

                $http.post(url, param).then(function (resp) {
                    deferred.resolve(resp);
                }).then(function (error) {
                    deferred.reject(error);
                });
            };

            reader.readAsDataURL(files);

            return deferred.promise;
        };

        function executeservices(type, url, param) {
            var deferred = $q.defer();

            // $.ajax({
            //     url: url,
            //     type: type.toUpperCase(),
            //     dataType: "json",
            //     contentType: "application/json",
            //     success: function (responsed) {
            //         deferred.resolve(responsed);
            //     },
            //     error: function (error) {
            //         deferred.reject(error);
            //     }
            // });

            var options = {
                url: url,
                type: type.toUpperCase(),
                dataType: "json",
                contentType: "application/json",
                success: function (responsed) {
                    deferred.resolve({data: responsed});
                },
                error: function (error) {
                    deferred.reject(error);
                }
            };

            if (type.toUpperCase() != "GET") {
                options.data = JSON.stringify(param);
            }

            $.ajax(options);

            return deferred.promise;
        };

        fn.broadcasthistory_insert = function (BroadCastId, ObjBroadCastHistory) {
            var url = links + "broadcast/" + BroadCastId + "/history";
            return executeservice("post", url, ObjBroadCastHistory);
        };

        fn.notification_read = function (EmployeeCode) {
            var url = links + "notification/" + EmployeeCode;
            return executeservice("get", url);
        };

        fn.chathistory_insert = function (ObjChatHistory) {
            var url = links + "chat/history";
            return executeservice("post", url, ObjChatHistory);
        };

        fn.chatgroup_read = function (empcode, groupCode) {
            var url = links + 'chat/group/' + empcode + '/';
            if (groupCode)
                url += groupCode;
            return executeservice("get", url);
        };

        fn.chatgroup_update = function (groupId, objChatGroup) {
            var url = links + 'chat/group/' + groupId;
            return executeservice("put", url, objChatGroup);
        };

        fn.chatgroup_delete = function (groupId) {
            var url = links + 'chat/group/' + groupId;
            return executeservice("delete", url, null);
        };

        fn.chatgroup_leave = function (groupId, empcode) {
            var url = links + 'chat/group/' + groupId + '/leave/' + empcode;
            return executeservice("post", url, null);
        };

        fn.chatgroup_member_read = function (groupCode, empcode) {
            var url = links + 'chat/group/member/' + groupCode + '/' + empcode;
            return executeservice("get", url);
        };

        fn.chatgroup_member_insert = function (groupCode, objMember) {
            var url = links + 'chat/group/member/' + groupCode;
            return executeservice("post", url, objMember);
        };

        // New Chat -----------------------------------------
        fn.get_employee = function () {
            var url = links + 'pcis/chat/employee';
            return executeservices('get', url, null);
        };

        fn.get_chat_room = function (employeecode) {
            var url = links + 'pcis/chat/chatroom/' + employeecode;
            return executeservices('get', url, null);
        };

        fn.insert_chat_room = function (obj) {
            var url = links + 'pcis/chat/chatroom';
            return executeservices('post', url, obj);
        };

        fn.update_chat_room = function (obj) {
            var url = links + 'pcis/chat/chatroom';
            return executeservices('put', url, obj);
        };

        fn.get_chat_message = function (employeecode) {
            var url = links + 'pcis/chat/message/' + employeecode;
            return executeservices('get', url, null);
        };

        fn.insert_chat_message = function (obj) {
            var url = links + 'pcis/chat/message';
            return executeservices('post', url, obj);
        };

        fn.update_chat_message = function (obj) {
            var url = links + 'pcis/chat/message';
            return executeservices('put', url, obj);
        };

        fn.update_chat_message_transaction = function (obj) {
            var url = links + 'pcis/chat/message/transaction';
            return executeservices('put', url, obj);
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
                return '\n' + '<a href="' + url + '" style="color:white; text-decoration: underline;" target="_blank">' + url + '</a>'
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
                } else {
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
    .directive("enterForSubmit", function () {
        return {
            restrict: "A",
            scope: {
                enterForSubmit: "&",
                enterModel: "="
            },
            link: function (scope, elem, attrs) {
                var _ = window._;
                if (angular.isFunction(scope.enterForSubmit)) {
                    elem.bind("keydown", function (event) {
                        var code = event.keyCode || event.which;
                        if (code === 13 && !event.shiftKey) {
                            event.preventDefault();
                            if (!_.isEmpty(scope.enterModel))
                                scope.$apply(scope.enterForSubmit());
                        }
                    });
                }
            }
        };
    })
    .directive("dropFileChat", function () {
        return {
            restrict: "A",
            scope: {
                onOver: "&",
                onOut: "&",
                onDrop: "&"
            },
            link: function (scope, elem, attrs) {

                if (angular.isFunction(scope.onOver)) {
                    elem.on("dragover", onOver);
                }

                if (angular.isFunction(scope.onOut)) {
                    elem.on("dragleave", onOut);
                }

                if (angular.isFunction(scope.onDrop)) {
                    elem.on("drop", onDrop);
                }

                function onOver(e) {
                    stopEvent(e);
                    scope.$apply(scope.onOver(e));
                }

                function onOut(e) {
                    stopEvent(e);
                    scope.$apply(scope.onOut(e));
                }

                function onDrop(e) {
                    stopEvent(e);
                    scope.DropEvent = e;
                    scope.$apply(scope.onDrop(e));
                }

                function stopEvent(e) {
                    e.stopPropagation();
                    e.preventDefault();
                }
            }
        };
    })
    .directive("onLastRepeats", function () {
        return function (scope, elem, attrs) {
            if (scope.$last)
                setTimeout(function () {
                    scope.$emit(attrs.onLastRepeats, elem, attrs);
                }, 1);
        }
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
                } else {
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
                            if (raw.scrollTop <= 10)
                                if (angular.isFunction(scope.scrollLoadMore)) {
                                    scope.$apply(scope.scrollLoadMore(raw.scrollTop));
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
    .directive("disableClick", function () {
        return {
            restrict: "A",
            link: function (scope, elem, attrs) {
                elem.click(function (e) {
                    event.stopPropagation();
                });
            }
        };
    })
    .directive("showSubMenu", function () {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                var target = $("#" + attrs.showSubMenu);
                attrs.expanded = JSON.parse(attrs.isshow);

                element.bind('click', function (event) {
                    event.stopPropagation();
                    clickFunction();
                });

                function clickFunction() {
                    attrs.expanded = !attrs.expanded;

                    if (!attrs.expanded) {
                        $("#" + attrs.showSubMenu).css({opacity: 0, display: 'none'});
                        element.addClass("fa-chevron-circle-down");
                        element.removeClass("fa-chevron-circle-up");
                    } else {
                        $("#" + attrs.showSubMenu).css({opacity: 1, display: 'block'});
                        element.removeClass("fa-chevron-circle-down");
                        element.addClass("fa-chevron-circle-up");
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
                        } else {
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
                    } else if (element.find("[value*='number']").length > 0) {
                        element.multiselect('select', initializedDefaultValue(value, "number"), true);
                    } else {
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
                            } else {
                                var len = options.length == select.find("option").length ? 'All' : options.length;
                                return btnText + ' (' + len + ')';
                            }
                        };
                    }

                    config.onChange = function (optionElement, checked) {
                        var selectedValue = element.find("option:selected").map(function (a, item) {
                            if (/string/.test(item.value)) {
                                return item.value.replace(/string:/, " ").trim();
                            } else if (/number/.test(item.value)) {
                                return parseInt(item.value.replace(/number:/, " ").trim());
                            } else if (/boolean/.test(item.value)) {
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
                    } else {
                        return val;
                    }
                }
            }
        };
    })
    .directive("emojiPicker", function () {
        return {
            restrict: "A",
            replace: false,
            link: function (scope, elem, attrs) {
                $(elem).emojioneArea({
                    pickerPosition: "top",
                    events: {
                        keypress: function (editor, event) {
                            console.log('event:keypress');
                            console.log(editor, event);
                        },
                        change: function (editor, event) {
                            console.info("On Change : ", editor);
                            console.log('event:change');
                        },
                        emojibtn_click: function (button, event) {
                            console.log('event:emojibtn.click, emoji=' + button.children().data("name"));
                        }
                    }
                });
            }
        };
    })
    .directive("uiChatClient", function (uiChatClientConfig, socket, helper, $q, $timeout, $filter, $log, $uibModal) {
        var pathArray = window.location.pathname.split('/'),
            newPathname = window.location.protocol + "//" + window.location.host;
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
                directChatTo: "=",
                FuncTest: "&"
            },
            link: function (scope, elem, attrs) {

            	scope.nano_icon = false;
            	scope.layout_icon = false;
                scope.uriKpi = "";
                scope.uriCalendar = "";
                scope.imgPath = "../../img/announcement_icon.png";
                scope.imgChatPath = "../../img/chat-icon.png";
                scope.imgOutLookPath = "../../img/Outlook_icon.png";
                scope.imgGroupChat = "http://172.17.9.94/pciscalendar/images/logo-group-chat.jpg";
                scope.uriOutLook = "https://login.microsoftonline.com/login.srf?wa=wsignin1.0&rpsnv=4&ct=1461728916&rver=6.6.6556.0&wp=MBI_SSL&wreply=https%3a%2f%2foutlook.office.com%2fowa%2f%3frealm%3dtcrbank.com%26exch%3d1&id=260563&whr=tcrbank.com&CBCXT=out&msafed=0#";
                scope.nowdate = ("0" + new Date().getDate().toString()).slice(-2);
                scope.countAllNotification = 0;
                scope.notificationData = [];
                scope.showbutton = {
                    btn_calendar: $('body').is('.calendar'),
                    btn_kpi: $("[data-page=kpi]")[0] ? true : false,
                    btn_chat: "",
                    btn_boardcast: "",
                    btn_notification: ""
                };
                scope.data = {
                    from: null,
                    to: null,
                    message: null,
                    sendtime: null
                };

                function getLinkCalendar(newEmp) {
                    var uri = "";

                    if (!scope.showbutton.btn_calendar) {
                        if (newEmp) {
                            uri = "http://172.17.9.94/pciscalendar/index.html#/login/" + scope.uiChatClient + "/" + newEmp;
                        } else {
                            uri = "http://172.17.9.94/pciscalendar/index.html#/login/" + scope.uiChatClient + "/" + scope.directChatTo.toString();
                        }
                    }

                    return uri;
                }

                function getLinkKPI() {
                    var uri = "";
                    if (!scope.showbutton.btn_kpi && scope.directChatTo) {
                        var emp_auth = (scope.data.from) ? scope.data.from:scope.uiChatClient;
                    	if (in_array(emp_auth, uiChatClientConfig.permission))
                            uri = 'http://tc001pcis1p:8099/pcis/index.php/report/gridDataList?rel=' + scope.uiChatClient + '&relsub=' + scope.directChatTo.toString() + '&editor=' + helper.md5(true) + '&permission=' + helper.md5(true);
                        else
                            uri = 'http://tc001pcis1p:8099/pcis/index.php/report/gridDataList?rel=' + scope.uiChatClient + '&relsub=' + scope.directChatTo.toString() + '&editor=' + helper.md5(false) + '&permission=' + helper.md5(false);

                        function in_array(needle, haystack, argStrict) {

                            var key = '',
                                strict = !!argStrict;

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
                } else if ($('body').is('.calendar')) {
                    scope.imgPath = 'images/announcement_icon.png';
                    scope.imgChatPath = 'images/chat-icon.png';
                    scope.imgOutLookPath = 'images/Outlook_icon.png';
                } else {
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
                        scope.uiChatClient = n.toString();
                        
                        if(in_array(n.toString(), ['57251', '56225', '55143', '58141', '56679', '58106', '59016', '58385', '57160', '58355', '56365', '58202', '56381', '56367'])) {
                        	scope.nano_icon = true;
                        }
                        
                        if(in_array(n.toString(), ['57251', '56225', '58141', '56679', '58106', '59016', '58385', '57160', '58355', '56365', '58202', '56367', '59151'])) {
                        	scope.layout_icon = true;
                        }
                        
                        iniNotification();
                        iniDirectChat();
                    }
                });
                
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

                scope.$watch("directChatTo", function (n, o) {
                    if (n) {
                        scope.uriKpi = getLinkKPI();
                        scope.uriCalendar = getLinkCalendar();
                    }
                });

                scope.$watch(function () {
                    return $(elem).attr('direct-chat-to');
                }, function (empCode) {
                    if (empCode) {
                        scope.uriKpi = getLinkKPI();
                        scope.uriCalendar = getLinkCalendar(empCode);
                        scope.directChatTo = empCode;
                    }
                }, true);

                function iniDirectChat() {
                    var directChatUserObj = $("#" + attrs.directChatClick);
                    directChatUserObj.click(function (e) {
                        console.log("Open -----");
                        var element = angular.element(document.getElementById("sidenav")).scope();
                        function open()
                        {
                            return new Promise(function(resolve,reject){
                                setTimeout(function(){
                                    element.toggleRight();
                                    resolve('Open');
                                },100);
                            })
                        }
                        function openSearch()
                        {
                            return new Promise(function(resolve,reject){
                                setTimeout(function(){
                                    element.openAddChat();
                                    resolve('Open Search');
                                },100);
                            })
                        }

                        function setSearch()
                        {
                            return new Promise(function(resolve,reject){
                                setTimeout(function(){
                                    element.model.employeeSearchName = element.Chat_To;
                                    resolve('Set search employee code');
                                },100);
                            })
                        }

                        open()
                            .then(function(val){console.log(val); return openSearch();})
                            .then(function(val){console.log(val); return setSearch();})
                            .then(function(val){console.log(val); });
                    });
                }

                function iniNotification() {
                    helper.notification_read(scope.uiChatClient).then(function (resp) {
                        var data = resp.data;
                        scope.countAllNotification = data[0].CountAllNotification;
                        angular.copy(data, scope.notificationData);
                    });
                };

                scope.filterNotification = function (value, item) {

                    angular.forEach(helper.whereObject(item.RegionGroup, {isSelect: true}), function (item, key) {
                        item.isSelect = false;
                    });

                    value.isSelect = true;

                    if (value.text == "All") {
                        item.FilterBy = null;
                        item.CountTransaction = item.Data.length;
                    } else {
                        item.FilterBy = value.text;
                        item.CountTransaction = helper.whereObject(item.Data, {filterName: item.FilterBy}).length;
                    }
                };

                scope.jumpTo = function (event, item) {
                    var canClick = item.Color.indexOf('jumper') > -1;

                    if (canClick) {

                        var method = item.Color.split(",")[1];
                        var value = item.Color.split(",")[2];

                        switch (method) {
                            case "cafile":
                                window.open("http://tc001pcis1p:8099/pcis/index.php/management/getDataVerifiedManagement?_=e45&state=false&rel=" + value + "&req=P2&live=2&wrap=030919031603", "_blank");
                                break;
                            case "p3":
                                window.open("http://tc001pcis1p:8099/pcis/index.php/metro/routers?_=1487302137238&rel=" + value + "&req=P3&live=1&wrap=1487302137238", "_blank");
                                break;

                        }
                    }

                };

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
                    } else if (mousePosition.x < (Math.abs((centerX * 35 / 100) - centerX))) {
                        elem.addClass("mouse-down-left");
                    } else if (mousePosition.y >= centerY) {
                        elem.addClass("mouse-down-top");
                    } else if (mousePosition.y < centerY) {
                        elem.addClass("mouse-down-bottom");
                    }
                }
            }
        }
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
                            scope.ngModel = $filter("date")(nDate, scope.modelFormat);
                        } else {
                            ctrl.$modelValue = date;
                            scope.ngModel = date;
                        }

                        scope.$apply();
                    }
                });

                scope.$watchCollection('config', function (newValue) {
                    $(element).datepicker("destroy");
                    $(element).datepicker(newValue);
                });
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
    .directive("autoHideScrollbar", function (uiMultipleSelectConfig, $timeout) {
        return {
            restrict: "A",
            scope: {
                scrollProps: "=",
                scrollLoadmore: "&",
                scrollForChat: "="
            },
            link: function (scope, elem, attrs) {
                var _ = window._;
                uiMultipleSelectConfig.scroll.push({
                    name: attrs.autoHideScrollbar,
                    element: $(elem),
                    scroll: $(elem).slimScroll(scope.scrollProps)
                });

                if (angular.isFunction(scope.scrollLoadmore)) {
                    elem.bind("scroll", function () {
                        var raw = elem[0];
                        var scrollTo = attrs.scrollTo;

                        if (!_.isEmpty(scrollTo)) {
                            switch (scrollTo.toLowerCase()) {
                                case "bottom":
                                    if (raw.scrollTop + raw.offsetHeight + 5 >= raw.scrollHeight)
                                        scope.$apply(scope.scrollLoadmore());
                                    break;
                                case "top":
                                    if (raw.scrollTop <= 300)
                                        scope.$apply(scope.scrollLoadmore());
                                    break;
                            }
                        }
                    });
                }

                if (scope.scrollForChat) {
                    scope.$watch('scrollForChat', function (newValue, oldValue) {
                        if (!_.isEmpty(newValue)) {
                            $timeout(function () {
                                $(elem).slimScroll({scrollTo: $(elem).find("div:first-child").height() + 'px'});
                            }, 0);
                        }
                    }, true);
                }
            }
        };
    })
    .controller("testuplod", function ($scope, $http, $timeout) {

        $scope.testItem = [{
            SysNo: "206",
            ApplicationNo: "02-59-005869",
            RefNo: null,
            CollateralType: null,
            CollateralStatus: null,
            ReceiveDocumentDateTime: null,
            ApprovedDateTime: null,
            AssetStatus: null,
            ApproveValue: null,
            Tambol: null,
            Amphur: null,
            Province: null,
            AgencyMortgage: null,
            Bank: null,
            Refinance: null,
            PayType: null,
            PaymentChannel: null,
            UpdateByEmpCode: null,
            UpdateByEmpName: null,
            PatchFile: null,
            FileStatus: null,
            AppointmentReceiveDate: null,
            CollateralFile: {
                FileName: null,
                Size: null,
                Type: null,
                ByteFile: null,
                IsFileDelete: null
            }
        }];

        $scope.isLoading = false;
        $scope.setfile = function (scope) {

            $scope.isLoading = true;

            $timeout(function () {
                var reader = new FileReader();

                reader.onload = function () {
                    $scope.testItem[0].CollateralFile.FileName = $scope.fileObject[0].name;
                    $scope.testItem[0].CollateralFile.Size = $scope.fileObject[0].size;
                    $scope.testItem[0].CollateralFile.Type = $scope.fileObject[0].name.replace(/^.*\./, '');
                    $scope.testItem[0].CollateralFile.ByteFile = reader.result.split("base64,")[1];
                    $scope.testItem[0].CollateralFile.IsFileDelete = false;

                    $scope.isLoading = false;
                };

                reader.readAsDataURL($scope.fileObject[0]);
            });

        };
        var url = "http://localhost:59392/LBServices.svc/ddtemplate/" + $scope.testItem[0].ApplicationNo + "/collateral";
        $scope.uploadFile = function () {
            console.log($scope.testItem);
            $http.post(url, $scope.testItem).then(function (resp) {
                console.log(resp);
            });
        };

        $scope.updateFile = function () {
            console.log($scope.testItem);
            $http.put(url, $scope.testItem).then(function (resp) {
                console.log(resp);
            });
        };


        var myFormatter = function (cellvalue, options, rowObject) {
            var btn = "<button data-row-data='" + JSON.stringify(rowObject) + "' class='btn btn-xs btn-danger margin-left-5' ng-click='config.showData($event)'><i class='fa fa-remove'></i></button>";
            return btn;
        };

        $scope.jqDateConfig = {dateFormat: "dd/mm/yy", minDate: new Date()};

        $scope.ApplicationNo = "";

        $scope.config = {
            id: 'buildingsGrid',
            data: [],
            datatype: "local",
            url: $scope.dataTest,
            colModel: [
                {name: 'ApplicationNo', label: 'Application No'},
                {name: 'CustName', label: 'Cust Name'},
                {name: 'ProductProgram', label: 'Product Program'},
                {name: 'ApplicationNo', formatter: myFormatter, width: 75, fixed: true}
            ],
            pager: "#pager",
            viewrecords: true,
            rowNum: 5,
            rowList: [5, 10, 15, 20, 25, 30],
            altRows: true,
            autowidth: true,
            showData: function (event) {
                var data = $(event.currentTarget).data("rowData");
                $scope.ApplicationNo = data.ApplicationNo;
            }
        };

        $scope.reloadGrid = function () {
            $http.post('http://172.17.9.94/newservices/LBServices.svc/ddtemplate', null).then(function (resp) {
                $scope.config.data = resp.data
            });
        };

        $scope.reloadGrid();

        $scope.comname = "";
        $scope.ipaddress = "";
        $scope.macaddress = "";

        $scope.getInfo = function () {

            //var macAddress = "";
            //var ipAddress = "";
            //var computerName = "";
            //var wmi = GetObject("winmgmts:{impersonationLevel=impersonate}");
            //e = new Enumerator(wmi.ExecQuery("SELECT * FROM Win32_NetworkAdapterConfiguration WHERE IPEnabled = True"));
            //for (; !e.atEnd(); e.moveNext()) {
            //    var s = e.item();
            //    $scope.macaddress = s.MACAddress;
            //    $scope.ipaddress = s.IPAddress(0);
            //    $scope.comname  = s.DNSHostName;
            //}

            $http.get("http://172.17.9.94/newservices/LBServices.svc/ip").then(function (resp) {
                console.log(resp);
                var data = resp.data;
                $scope.ipaddress = data[0];
                $scope.macaddress = data;
            }).then(function (error) {
                console.log(error);
            });
        };

        $scope.insertRow = function () {
            $scope.dataTest.push({custname: "new", empno: "1", address: "yyyyy", isdelete: false});
        };

        $scope.deleteRow = function (item) {
            item.isdelete = true;
        };

        $scope.update = function () {
            console.log($scope.dataTest);
        };

        $scope.checkDate = function () {
            var value = checkDrawDownDateChange("Postpone", $scope.myDate);
            $scope.jqDateConfig.minDate = value[0];
            $scope.jqDateConfig.maxDate = value[1];
        };

        function checkDrawDownDateChange(status, ddDate) {
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

                minDate = dayInMonth[dayInMonth.length - 3];
                maxDate = dayInMonth[dayInMonth.length - 1];

                if (cDate.getDate() < minDate) {
                    return [new Date(), lastDateofMonth];
                } else {
                    return [cDate, lastDateofMonth];
                }
            } else {
                return [new Date(), null];
            }
        }

        $scope.callservice = function () {
            var backendUrl = "http://172.17.9.94/newservices/LBServices.svc/file";
            var reader = new FileReader();

            reader.onload = function () {

                var param = {
                    FileName: $scope.myFile[0].name,
                    Size: $scope.myFile[0].size,
                    Type: $scope.myFile[0].type,
                    ByteFile: reader.result.split("base64,")[1]
                };

                $http.post(backendUrl, param).then(function (resp) {
                    console.log(resp);
                }).then(function (error) {
                    console.log(error);
                });
            };

            reader.readAsDataURL($scope.myFile[0]);

        };


    })
    .controller("uiChatClientNew", function ($scope, $rootScope, $uibModal, $q, $mdSidenav, $mdDialog, $compile, $timeout, $templateCache, helper, socket, $mdToast) {

        /*------------------ Append Content to body ------------------*/
        $scope.iniFormChat = function () {
            $('html').append('<div id="sidenav"><div class="htmlToast" ng-show="showToast()"></div></div>');
            var container = $("#sidenav");
            var el = angular.element('<div ng-include="\'materialTemplate.html\'"></div>');
            container.append($compile(el)($scope));
            container.append($compile(container)($scope));
        };

        $scope.$parent.iniNewChat = $scope.iniFormChat;

        /*------------------ Initial Param ------------------*/
        var _ = window._;
        $scope.Chat_From_Profile = null;
        $scope.Chat_From = $scope.$parent.uiChatClient;
        $scope.Chat_To = $scope.$parent.directChatTo;
        $scope.Add_Chat = false;
        $scope.model = {};
        $scope.EmployeeOnline = [];
        $scope.RegisterChatRoom = "";
        $scope.ChatRoom = [];
        $scope.CurrentRoom = [];
        $scope.LimitEmployeePage = 30;
        $scope.howMoreMessageDialog = false;
        $scope.OnDragOver = 0;
        $scope.AddChatDisabled = false;
        $scope.EditGroupName = false;
        $scope.contentOpen = false;
        $scope.ScrollProps = {
            height: '100%',
            size: '7px',
            color: '#808080'
        };
        $scope.showToast = function () {
            return $(".htmlToast *").length > 0 ? true : false;
        };
        $scope.getFileTypeFromExtension = function (extension) {
            var type = "text";

            switch (extension.toLowerCase()) {
                //region Image
                case "jpeg":
                case "jpg":
                case "png":
                case "gif":
                    type = "image";
                    break;

                //region Zip File
                case "rar":
                case "zip":
                case "7z":
                case "iso":
                    type = "zip";
                    break;

                //region PDF
                case "pdf":
                    type = "pdf";
                    break;

                //region XML
                case "xml":
                    type = "xml";
                    break;

                //region Audio
                case "aac":
                case "m4a":
                case "mp1":
                case "mp2":
                case "mp3":
                case "mpg":
                case "mpeg":
                case "oga":
                case "ogg":
                case "wav":
                    type = "audio";
                    break;

                //region Video
                case "mp4":
                case "m4v":
                case "ogv":
                case "webm":
                    type = "video";
                    break;

                //region Word
                case "doc":
                case "dot":
                case "docx":
                case "dotx":
                case "docm":
                case "dotm":
                    type = "word";
                    break;

                //region Excel
                case "xls":
                case "xlt":
                case "xla":
                case "xlsx":
                case "xltx":
                case "xlsm":
                case "xltm":
                case "xlam":
                case "xlsb":
                    type = "excel";
                    break;

                //region Power Point
                case "ppt":
                case "pot":
                case "pps":
                case "ppa":
                case "pptx":
                case "potx":
                case "ppsx":
                case "ppam":
                case "pptm":
                case "potm":
                case "ppsm":
                    type = "powerpoint";
                    break;

                //region MS Access
                case "mdb":
                    type = "access";
                    break;

                //region Other
                case "js":
                case "json":
                case "css":
                case "html":
                case "sql":
                    type = "other";
                    break;
                case "txt":
                    type = "text";
                    break;
            }

            return type;
        }

        $scope.getChatClassFile = function (extension) {
            switch ($scope.getFileTypeFromExtension(extension)) {
                case "excel":
                    return "fa-file-excel-o excel";
                    break;
                case "word":
                    return "fa-file-word-o word";
                    break;
                case "powerpoint":
                    return "fa-file-powerpoint-o powerpoint";
                    break;
                case "pdf":
                    return "fa-file-pdf-o pdf";
                    break;
                case "text":
                    return "fa-file-text-o text";
                    break;
                case "zip":
                    return "fa-file-zip-o zip";
                    break;
                default:
                    return "fa-file-o normal";
                    break;
            }
        };

        $scope.convertByteToString = function humanFileSize(size) {
            var i = Math.floor(Math.log(size) / Math.log(1024));
            return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        };

        $scope.checkSize = function (size) {
            var _ref;
            var maxFileSize = 20;
            if (((_ref = maxFileSize) === (void 0) || _ref === '') || (size / 1024) / 1024 < maxFileSize) {
                return true;
            } else {
                alert("File must be smaller than " + maxFileSize + " MB");
                return false;
            }
        };

        var bodyHeight, bodyFooter, limitHeight;
        $scope.bodyChatMessageHeight = {
            body: null,
            footer: null
        };

        $scope.openToast = function () {
            $mdToast.show({
                hideDelay: 500000,
                position: 'top right',
                controller: 'ToastCtrl',
                templateUrl: 'toast.html',
                parent: $(".testtoast")
            });
        };

        $scope.autoGrowup = function (event) {

            var oField = event.target;

            if (!bodyHeight && !bodyFooter) {
                bodyHeight = $('.content-body.autogrow').height();
                bodyFooter = $('.content-footer.autogrow').height();
                limitHeight = (bodyHeight * 40) / 100;
            }

            // console.log({
            //     event: oField.clientHeight,
            //     event2: oField.scrollHeight,
            //     body: bodyHeight,
            //     footer: bodyFooter
            // });
            //
            // console.log({
            //     body: bodyHeight - Math.abs(bodyFooter - (oField.scrollHeight + 36)),
            //     footer: oField.scrollHeight + 36
            // });

            if (!oField.value.isEmpty()) {
                if (oField.scrollHeight > oField.clientHeight) {
                    if (bodyHeight - Math.abs(bodyFooter - (oField.scrollHeight + 37)) > 314) //Stop Grow up
                    {
                        $scope.bodyChatMessageHeight = {
                            body: bodyHeight - Math.abs(bodyFooter - (oField.scrollHeight + 37)),
                            footer: oField.scrollHeight + 37
                        }
                    }
                }
                // else if (oField.scrollHeight < oField.clientHeight) {
                //     console.info('client less than scroll height', {
                //         body: bodyHeight - Math.abs(bodyFooter - (oField.clientHeight + 37)),
                //         footer: oField.clientHeight + 37
                //     });
                //     $scope.bodyChatMessageHeight = {
                //         body: bodyHeight - Math.abs(bodyFooter - (oField.clientHeight + 37)),
                //         footer: oField.clientHeight + 37
                //     }
                // }
            } else {
                $scope.bodyChatMessageHeight = {
                    body: bodyHeight,
                    footer: bodyFooter
                };
            }
        };

        $scope.valueTest = function () {
            var value = [];
            for (var i = 0; i <= 10; i++) {
                value.push(i);
            }
            return value;
        };

        $scope.Employee = [];
        $scope.getEmployee = function () {
            if (!_.isEmpty(String($scope.Chat_From ? $scope.Chat_From : ''))) {
                helper.get_employee().then(function (resp) {
                    var chat_user = resp.data;
                    var data = _.filter(chat_user, function (o) {
                        o.IsSelect = false;
                        o.OnlineStatus = $scope.checkOnlineUser(o.EmployeeCode);
                        return o.EmployeeCode != $scope.Chat_From;
                    });

                    $scope.Chat_From_Profile = _.filter(chat_user, {EmployeeCode: String($scope.Chat_From)})[0];

                    angular.copy(data, $scope.Employee);
                });
            }
        };

        $scope.loadMoreEmployee = function () {
            $scope.LimitEmployeePage += 30;
        };

        $scope.loadMoreChatMessage = function (scroll) {
            // console.log(scroll);
            $scope.howMoreMessageDialog = !$scope.howMoreMessageDialog;
        };

        $scope.checkOnlineUser = function (EmployeeCode) {
            if (_.filter($scope.EmployeeOnline, {EmployeeCode: EmployeeCode}).length > 0)
                return true;
            else
                return false;
        };

        $scope.openAddChat = function () {
            $scope.Add_Chat = true;
            $scope.contentOpen = false;
            $('.add-user-text-input').focus();
        };

        $scope.searchChatFocus = false;
        $scope.openSearchChat = function () {
            $scope.contentOpen = true;
            $scope.searchChatFocus = true;
        };
        $scope.lostSearchFocus = function () {
            $scope.searchChatFocus = false;
        };

        $scope.closeAddChat = function () {
            $scope.Add_Chat = false;
            $scope.model.employeeSearchName = undefined;
            _.map($scope.Employee, function (item) {
                item.IsSelect = false;
                return item;
            });
        };

        $scope.AddChatSelect = function (empItem) {
            empItem.IsSelect = !empItem.IsSelect;
            if (_.filter($scope.Employee, {IsSelect: true}).length <= 0)
                $scope.model.IsFilter = undefined;
        };

        $scope.chatWindowIsOpen = false;
        $scope.toggleRight = buildToggler();

        function buildToggler() {
            return function () {
                if ($scope.ChatRoom.length <= 0)
                    $scope.openAddChat();
                else if ($scope.ChatRoom.length == 1) {
                    $scope.SelectChatRoom($scope.ChatRoom[0]);
                }

                $mdSidenav('right').toggle();
                $scope.chatWindowIsOpen = true;
            };
        }

        $scope.close = closeToggler();

        function closeToggler() {
            return function () {
                $mdSidenav('right').close();
                $scope.chatWindowIsOpen = false;
            }
        }

        $scope.slidechatlist = function (flag) {
            if (flag) {
                $scope.contentOpen = false;
            } else {
                $scope.contentOpen = !$scope.contentOpen;
            }
        };

        $scope.formatTimeChat = function (date) {
            date = new Date();
            return moment(date).format('HH:mm');
        };

        $scope.SelectChatRoom = function (room) {
            resetSelectChatRoom();
            checkUnReadMessage(room);
            $scope.closeAddChat();

            room.SelectRoom = true;
        };

        $scope.getFormatDateMessage = function (date) {
            var tDate = new Date(date);
            var now = new Date();
            if (tDate.getDate() == now.getDate()) {
                return 'วันนี้ HH:mm';
            } else if (tDate.getDate() == (now.getDate() - 1)) {
                return 'เมื่อวาน HH:mm';
            } else {
                return 'วันที่ dd-MM-yyyy HH:mm';
            }
        };

        $scope.getCurrentRoom = function (room) {
            if (room.ChatRoomType == "P") {
                return room.ChatRoomCreateBy == $scope.Chat_From ? room.ChatRoomToProfile : room.ChatRoomFromProfile;
            } else {
                return room;
            }
        };

        $scope.getSummaryUnreadMessage = function () {
            var sum = 0;
            sum = _.sum(_.map($scope.ChatRoom, function (o) {
                return _.filter(o.ChatMessage, {IsRead: false}).length;
            }));
            return sum;
        };

        $scope.getSelectMessageInRoom = function () {
            if (_.filter($scope.ChatRoom, {SelectRoom: true}).length > 0 && $scope.Chat_From_Profile) {
                var current_room = _.filter($scope.ChatRoom, {SelectRoom: true})[0];
                return _.map(current_room.ChatMessage, function (o) {

                    var senderMessage = _.filter($scope.Employee, {EmployeeCode: o.ChatMessageOwner});

                    if (o.ChatMessageOwner == $scope.Chat_From) {
                        o.SenderName = $scope.Chat_From_Profile.FullNameEng;
                    } else {
                        o.IsMessageOwner = false;
                        if (senderMessage.length > 0)
                            o.SenderName = _.filter($scope.Employee, {EmployeeCode: o.ChatMessageOwner})[0].FullNameEng;
                    }

                    return o;

                });
            } else {
                return [];
            }
        };
        $scope.onsave = false;
        $scope.onBlur = function (cProfile) {
            $scope.EditGroupName = false;
            if (!$scope.onsave)
                $scope.model.GroupNameChange = cProfile.FullNameEng || cProfile.ChatRoomName;
            else
                $scope.onsave = false;
            console.log($scope.EditGroupName);
        };
        $scope.editGroupName = function (current) {
            $scope.EditGroupName = true;
            console.log($scope.EditGroupName);
        };
        $scope.saveGroupName = function (current) {
            $scope.onsave = true;
            console.log("save");
            helper.update_chat_room({
                ChatRoomCode: current.ChatRoomCode,
                ChatRoomCreateBy: $scope.Chat_From,
                ChatRoomName: $scope.model.GroupNameChange
            }).then(function (resp) {
                var data = resp.data;
                var current_room = _.filter($scope.ChatRoom, {SelectRoom: true})[0];
                current_room.ChatRoomName = data.ChatRoomName;
                socket.emit('group:rename:to', data);
            });
        };

        $scope.CreateChatRoom = function () {

            $scope.AddChatDisabled = true;

            var selected = _.filter($scope.Employee, {IsSelect: true});
            var exitsChatRoom = _.filter($scope.ChatRoom, function (item) {
                if (item.ChatRoomToProfile)
                    return item.ChatRoomToProfile.EmployeeCode == selected[0].EmployeeCode
            });

            if (exitsChatRoom.length <= 0 || selected.length >= 2) {
                var member = _.map(selected, function (o) {
                    return o.EmployeeCode;
                });

                member.push(String($scope.Chat_From));

                var obj = {
                    ChatRoomName: null,
                    ChatRoomCreateBy: $scope.Chat_From,
                    ChatRoomTo: selected.length <= 1 ? selected[0].EmployeeCode : null,
                    ChatRoomMember: member.join(',')
                };

                helper.insert_chat_room(obj)
                    .then(function (resp) {
                        console.log(resp.data);

                        $scope.AddChatDisabled = false;

                        var newRoom = resp.data;

                        socket.emit('send:invite:to', newRoom);

                        resetSelectChatRoom();

                        newRoom.SelectRoom = true;
                        $scope.ChatRoom.push(newRoom);

                        $scope.closeAddChat();
                    });
            } else {
                $scope.SelectChatRoom(exitsChatRoom[0]);
            }
        };

        $scope.funcOnDrag = function (e) {
            // console.log(e);
            // $scope.OnDragOver = !$scope.OnDragOver;
        };

        $scope.funcOnDrop = function (e) {
            var files = e.event ? e.event.target.files : e.DropEvent.originalEvent.dataTransfer.files;
            var selected = _.filter($scope.ChatRoom, {SelectRoom: true})[0];
            var notmorethan = 10;

            var tempSendFile = {
                ChatSendStatus: undefined,
                IsMessageOwner: true,
                MessageTempIndex: undefined,
                MessageTempProgress: undefined,
                MessageTempPicture: undefined
            };

            if (files.length > notmorethan) {
                alert("Your select file more then " + notmorethan + " files.");
            } else {
                for (let i = 0; i < files.length; i++) {
                    if ($scope.checkSize(files[i].size)) {
                        $timeout(function () {

                            console.time("testDecrptfile");

                            let temp = $.extend({}, tempSendFile);
                            temp.ChatMessageFileName = files[i].name.substring(0, files[i].name.lastIndexOf('.')) + '_';
                            temp.ChatMessageFileSize = files[i].size;
                            temp.ChatMessageType = files[i].name.replace(/^.*\./, '').replace('.', '');
                            temp.FileExtension = files[i].name.replace(/^.*\./, '');
                            temp.MessageTempPicture = URL.createObjectURL(files[i])
                            temp.MessageTempPointer = 'file_' + i;

                            selected.ChatMessage.push(temp);

                            var itemprogress = _.filter(selected.ChatMessage, {MessageTempPointer: 'file_' + i})[0];

                            var fileItem = this;
                            var reader = new FileReader();

                            reader.onprogress = function (event) {
                                $timeout(function () {
                                    itemprogress.MessageTempProgress = (event.loaded / event.total) * 100;
                                });
                            };
                            reader.onload = function () {
                                $timeout(function () {
                                    $scope.SendChatMessage({
                                        FileName: fileItem.name.substring(0, fileItem.name.lastIndexOf('.')),
                                        FileSize: fileItem.size,
                                        FileType: fileItem.name.replace(/^.*\./, '').replace('.', ''),
                                        FileExtension: fileItem.name.replace(/^.*\./, ''),
                                        FileByte: reader.result.split("base64,")[1],
                                        MessageTempPointer: itemprogress.MessageTempPointer
                                    });
                                    console.timeEnd("testDecrptfile");
                                }, 500);
                            };

                            reader.readAsDataURL(fileItem);

                        }.bind(files[i]));
                    }
                }
            }
        };

        $scope.getViewImage = function (message) {
            if (message.MessageTempPicture) {
                return message.MessageTempPicture;
            } else {
                return helper.links() + "pcis/chat/image/" + message.ChatRoomCode + "/" + message.ChatMessageFileName + "/" + message.ChatMessageType
            }
        };

        $scope.downloadFile = function (message) {
            return helper.links() + "pcis/chat/files/" + message.ChatRoomCode + "/" + message.ChatMessageFileName + "/" + message.ChatMessageType
        };

        $scope.openViewImage = function (ev, message) {
            $mdDialog.show({
                controller: DialogController,
                templateUrl: 'viewimage.html',
                parent: $(".htmlToast"),
                targetEvent: ev,
                clickOutsideToClose: true,
                locals: {
                    picture: $scope.getViewImage(message),
                    room: _.filter($scope.ChatRoom, {SelectRoom: true})[0],
                    funcGetViewImage: $scope.getViewImage,
                    funcGetFileTypeFromExtension: $scope.getFileTypeFromExtension
                }
            })
                .then(function (answer) {
                    $scope.status = 'You said the information was "' + answer + '".';
                }, function () {
                    $scope.status = 'You cancelled the dialog.';
                });
        };

        function DialogController($scope, $mdDialog, picture, room, funcGetViewImage, funcGetFileTypeFromExtension) {
            $scope.pic = picture;
            $scope.listPicture = _.filter(room.ChatMessage, function (item) {
                return funcGetFileTypeFromExtension(item.ChatMessageType) == "image";
            });
            $scope.getlink = funcGetViewImage;
            $scope.switchImage = function (image) {
                $scope.pic = $scope.getlink(image);
            };

            $scope.hide = function () {
                $mdDialog.hide();
            };

            $scope.cancel = function () {
                $mdDialog.cancel();
            };

            $scope.answer = function (answer) {
                $mdDialog.hide(answer);
            };
        }

        $scope.SendChatMessage = function (obj_file) {
            console.log($scope.model.chat_message);
            var selected = _.filter($scope.ChatRoom, {SelectRoom: true})[0];
            var sendtime = new Date();
            var DeleteProgress = undefined;

            var obj = {
                ChatRoomCode: selected.ChatRoomCode,
                ChatMessageText: $scope.model.chat_message,
                ChatMessageSendTime: sendtime.toMSJSON(),
                ChatMessageRead: true,
                ChatMessageOwner: String($scope.Chat_From)
            };

            if (obj_file && obj_file.FileName) {
                obj.ChatFile = obj_file;
                DeleteProgress = _.filter(selected.ChatMessage, {MessageTempPointer: obj_file.MessageTempPointer})[0];
                console.info(DeleteProgress);
            }

            helper.insert_chat_message(obj)
                .then(function (resp) {
                    var message = resp.data;

                    if (selected.ChatMessage) {
                        if (DeleteProgress) {
                            delete DeleteProgress.MessageTempProgress;
                            delete DeleteProgress.MessageTempPointer;
                            delete DeleteProgress.MessageTempPicture;
                            angular.copy(message, DeleteProgress);
                        } else {
                            selected.ChatMessage.push(message);
                        }
                    } else {
                        if (DeleteProgress) {
                            delete DeleteProgress.MessageTempProgress;
                            delete DeleteProgress.MessageTempPointer;
                            delete DeleteProgress.MessageTempPicture;
                            angular.copy(message, DeleteProgress);
                        } else {
                            selected.ChatMessage = [message];
                        }
                    }

                    var newMessage = _.clone(message);
                    newMessage.IsRead = false;
                    if (newMessage.ChatMessageOwner != $scope.Chat_From) {
                        newMessage.IsMessageOwner = false;
                    }
                    socket.emit('send:message:to', newMessage);

                    $scope.model.chat_message = null;
                    $scope.bodyChatMessageHeight = {
                        body: bodyHeight,
                        footer: bodyFooter
                    };
                });

        };

        function resetSelectChatRoom() {
            _.map(_.filter($scope.ChatRoom, {SelectRoom: true}), function (room) {
                room.SelectRoom = false;
                return room;
            });
        }

        $scope.getTransactionMessageMemberRead = function (ChatMessageTransaction) {
            var word = "";

            var count = _.filter(ChatMessageTransaction, function (trans) {
                if (trans.IsRead == true && trans.ChatRoomMemberEmployee != $scope.Chat_From)
                    return trans;
            }).length;

            if (count > 0) {
                if (ChatMessageTransaction.length > 2) {
                    word = word + "Read by " + count;
                } else if (ChatMessageTransaction.length == 2) {
                    word = "Read " + count;
                } else {
                    word = "";
                }
            }

            return word;
        };

        function checkUnReadMessage(room) {

            var unread_in_room = _.filter(room.ChatMessage, {IsRead: false});

            if (unread_in_room.length > 0) {
                var read = {
                    ChatRoomCode: room.ChatRoomCode,
                    EmployeeCode: $scope.Chat_From,
                    SysNO: null,
                    IsActive: null,
                    IsRead: true
                };

                helper.update_chat_message_transaction(read).then(function (resp) {
                    socket.emit('read:message:to', {
                        ChatRoomCode: room.ChatRoomCode,
                        ChatRoomMemberEmployee: $scope.Chat_From
                    });
                    _.map(unread_in_room, function (message) {
                        message.IsRead = true;
                        return message;
                    });
                });
            }

        }

        /*------------------ Watch Attribute for change employee code ------------------*/
        $scope.$watch("Chat_From", function (n, o) {
            if (!_.isEmpty(n ? String(n) : null)) {

                helper.get_chat_room(String(n)).then(function (resp) {

                    $scope.ChatRoom = _.map(resp.data, function (o, i) {
                        if (i == 0)
                            o.SelectRoom = true;
                        else
                            o.SelectRoom = false;

                        return o;
                    });

                    $scope.iniFormChat();

                    if ($scope.Employee.length <= 0) {
                        $scope.getEmployee();
                    }

                    OpenListeningSocket(n);
                });
            }
        });

        $rootScope.$watch("ownEmpCode", function (n, o) {
            if (!_.isEmpty(n ? String(n) : null)) {
                $scope.Chat_From = n;
            }
        });

        function OpenListeningSocket(n) {

            socket.emit("register:channel", {
                EmployeeCode: String(n),
                Channel: _.map($scope.ChatRoom, function (o) {
                    return o.ChatRoomCode;
                })
            });

            socket.on("register:channel", function (data) {
                angular.copy(data, $scope.EmployeeOnline);

                MapEmployeeOnline();
            });

            socket.on("disconnect:channel", function (data) {
                angular.copy(data, $scope.EmployeeOnline);

                MapEmployeeOnline();
            });

            socket.on('send:message:to', function (data) {

                var exitsChatRoom = _.filter($scope.ChatRoom, {ChatRoomCode: data.ChatRoomCode});
                var roomSelect = _.filter($scope.ChatRoom, {SelectRoom: true, ChatRoomCode: data.ChatRoomCode});

                if (exitsChatRoom.length > 0) {
                    exitsChatRoom[0].ChatMessage.push(data);
                }

                if (roomSelect.length <= 0 || !$scope.chatWindowIsOpen) {
                    $mdToast.show({
                        hideDelay: 3000,
                        position: 'top right',
                        controller: 'ToastCtrl',
                        templateUrl: 'toast.html',
                        parent: $(".htmlToast"),
                        locals: {
                            Room: exitsChatRoom,
                            Message: data,
                            MyProfile: $scope.Chat_From_Profile,
                            GetRoomProfile: $scope.getCurrentRoom,
                            GetFileTypeFromExtension: $scope.getFileTypeFromExtension
                        }
                    });
                } else {
                    $scope.SelectChatRoom(roomSelect[0]);
                }
            });

            socket.on('read:message:to', function (data) {
                var exitsChatRoom = _.filter($scope.ChatRoom, {ChatRoomCode: data.ChatRoomCode});

                if (exitsChatRoom.length > 0) {
                    _.map(exitsChatRoom[0].ChatMessage, function (item) {
                        var transaction = _.filter(item.ChatMessageTransaction, {
                            ChatRoomMemberEmployee: String(data.ChatRoomMemberEmployee),
                            IsRead: false
                        });

                        if (transaction.length > 0) {
                            _.filter(item.ChatMessageTransaction, {TransSysNo: transaction[0].TransSysNo})[0].IsRead = true
                        }

                        return item;
                    });
                }
                console.info("Update Read : ", data);
            });

            socket.on('group:rename:to', function (data) {
                var exitsChatRoom = _.filter($scope.ChatRoom, {ChatRoomCode: data.ChatRoomCode});

                if (exitsChatRoom.length > 0) {
                    if (exitsChatRoom[0].SelectRoom == true) {
                        $scope.model.GroupNameChange = data.ChatRoomName;
                    }
                    exitsChatRoom[0].ChatRoomName = data.ChatRoomName;
                }
            });

            socket.on('send:invite:to', function (data) {
                $scope.ChatRoom.push(data);
                socket.emit("accept:invite", data);
            });

            socket.on("accept:invite", function (data) {

            });

            socket.on("denied:invite", function (data) {

            });
        }

        $scope.$parent.$watch("directChatTo", function (n, o) {
            if (n) {
                $scope.Chat_To = n;
                console.info("Chat Client New Controller change value is : ", n, o);
            }
        }, true);


        function MapEmployeeOnline() {
            if ($scope.Employee.length > 0) {
                _.map($scope.Employee, function (item) {
                    item.OnlineStatus = $scope.checkOnlineUser(item.EmployeeCode);
                    return item;
                });
            }

            if ($scope.ChatRoom.length > 0) {
                _.map($scope.ChatRoom, function (item) {
                    if (item.ChatRoomType == "G") {
                        item.OnlineStatus = false;
                    } else {
                    	var employee_code = (item.ChatRoomToProfile) ? item.ChatRoomToProfile.EmployeeCode:$scope.Employee
                        if (item.ChatRoomCreateBy == $scope.Chat_From) {
                            item.OnlineStatus = $scope.checkOnlineUser(employee_code)
                        } else {
                            item.OnlineStatus = $scope.checkOnlineUser(employee_code)
                        }
                    }

                    return item;
                });
            }
        }

    })
    .controller('ToastCtrl', function ($scope, $mdToast, Room, Message, MyProfile, GetRoomProfile, GetFileTypeFromExtension) {
        $scope.Room = Room[0];
        $scope.Message = Message;
        $scope.MessageText = function () {
            if ($scope.Message.ChatMessageType) {
                if (GetFileTypeFromExtension($scope.Message.ChatMessageType) == 'image') {
                    return "send image file.";
                } else {
                    return "send file.";
                }
            } else {
                return $scope.Message.ChatMessageText;
            }
        };

        $scope.getCurrentRoom = GetRoomProfile($scope.Room);
        $scope.closeToast = function () {
            $mdToast
                .hide()
                .then(function () {
                });
        };
    })
    .controller("broadCastNew", function ($scope, $rootScope, uiChatClientConfig, socket, helper, $q, $timeout, $filter, $log, $uibModal) {

        var _ = window._;
        var modalBroadCastIsOpen = false;

        $scope.Chat_From = $scope.$parent.uiChatClient;
        $scope.Chat_From_Profile = undefined;
        $scope.countUnreadBroadCast = 0;
        $scope.AuthToBroadCast = 0;
        $scope.broadCastHistoryData = [];

        function getBroadCastHistory(currentItem) {
            helper.executeServices(helper.servicesMethod.getBroadCastHistoryData, {OwnEmpCode: $scope.Chat_From}).then(function (resp) {
                var data = resp.data.Data;
                $scope.countUnreadBroadCast = data[0].CountUnreadAllType;
                $scope.AuthToBroadCast = data[0].AuthToBroadCast;

                data.map(function (item) {
                    var isSelect = false;

                    if (currentItem)
                        if (currentItem.BroadCast_Code == item.BroadCast_Code)
                            isSelect = true;

                    return $.extend(item, {
                        selected: isSelect
                    });
                });

                angular.copy(data, $scope.broadCastHistoryData);
            });
        }

        $scope.getEmployee = function () {
            if (!_.isEmpty(String($scope.Chat_From ? $scope.Chat_From : ''))) {
                helper.get_employee().then(function (resp) {
                    var chat_user = resp.data;
                    $scope.Chat_From_Profile = _.filter(chat_user, {EmployeeCode: String($scope.Chat_From)})[0];
                });
            }
        };

        $scope.$watch("Chat_From", function (n, o) {
            if (!_.isEmpty(n ? String(n) : null)) {
                getBroadCastHistory();
                $scope.getEmployee();
            }
        });

        $rootScope.$watch("ownEmpCode", function (n, o) {
            if (!_.isEmpty(n ? String(n) : null)) {
                $scope.Chat_From = n;
            }
        });

        $scope.openBroadCastDialog = function (value) {
            modalBroadCastIsOpen = true;

            var modalInstance = $uibModal.open({
                animation: true,
                windowClass: "animated zoomIn",
                templateUrl: 'modalBroadCast.html',
                size: "lg",
                controller: "broadCastModalCtrl",
                resolve: {
                    items: function () {
                        return {
                            selectedItem: value,
                            AuthToBroadCast: $scope.AuthToBroadCast,
                            Chat_From: $scope.Chat_From,
                            Chat_From_Profile: $scope.Chat_From_Profile,
                            broadCastHistoryData: $scope.broadCastHistoryData
                        };
                    }
                }
            });

            modalInstance.result.then(function (resp) {
            }, function () {
                console.log("close");
            });
        };

        socket.on("broadcast:to", function (data) {

            getBroadCastHistory();

            Snarl.addNotification({
                title: data.broadCastObj.BroadCast_Name,
                icon: '<i class="fa fa-feed m-r-5" style="transform: rotate(270deg);font-size: 35px; color: ' + data.broadCastObj.BroadCast_Color + '"></i>',
                text: data.message,
                timeout: 40000
            });

        });
    })
    .controller('broadCastModalCtrl', function ($scope, items, helper, socket) {
        var _ = window._;
        $scope.imgPath = "";
        $scope.broadCastHistoryData = items.broadCastHistoryData;
        $scope.Chat_From = items.Chat_From;
        $scope.Chat_From_Profile = items.Chat_From_Profile;
        $scope.broadCastSelectItem = undefined;
        $scope.AuthToBroadCast = items.AuthToBroadCast;
        $scope.hasBroadCast = false;
        $scope.model = {};
        $scope.defaultPositionValue = [];
        $scope.masterPosition = [];
        $scope.masterRegion = [];
        $scope.masterBranch = [];
        $scope.masterEmployee = [];
        $scope.selectModel = {
            positionSelectedData: [],
            regionSelectedData: [],
            branchSelectedData: [],
            employeeSelectedData: [],
            actionTypeSelectedData: [],
            eventsTypeSelectedData: [],
            locationTypeSelectedData: []
        };
        $scope.selectOptions = {
            buttonContainer: '<div class="dropdown"/>',
            buttonClass: 'btn-broadcast-multiselect',
            selectedClass: 'bg-success',
            includeSelectAllOption: true,
            buttonWidth: '100%',
            disableIfEmpty: true
        };

        var pathArray = window.location.pathname.split('/'),
            newPathname = window.location.protocol + "//" + window.location.host;
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

        if ($('body').is('.metro')) {
            $scope.imgPath = pathFixed + 'img/announcement_icon.png';
        } else if ($('body').is('.calendar')) {
            $scope.imgPath = 'images/announcement_icon.png';
        } else {
            $scope.imgPath = '../../img/announcement_icon.png';
        }

        //--------------------------------------------------------------------------------------------------------------

        $scope.openBroadCast = function () {
            $scope.hasBroadCast = !$scope.hasBroadCast;
        };

        $scope.broadCastSelect = function (item) {
            $scope.broadCastUnSelect();
            $scope.broadCastSelectItem = _.filter($scope.broadCastHistoryData, {BroadCast_Code: item.BroadCast_Code})[0];
            $scope.broadCastSelectItem.selected = true;
        };

        $scope.broadCastUnSelect = function () {
            _.map($scope.broadCastHistoryData, function (item) {
                item.selected = false;
                return item;
            });
        };

        if (items.selectedItem) {
            $scope.broadCastSelect(items.selectedItem);
        } else {
            var defaultItem = _.orderBy($scope.broadCastHistoryData, ['BroadCast_Priority'], ['desc'])[0];
            $scope.broadCastSelect(defaultItem);
        }

        if ($scope.AuthToBroadCast == 1) {
            iniPosition();

            if ($scope.Chat_From_Profile.AreaName == 'HQ')
                iniRegion();

            iniBranch();
            iniEmployee();

            if ($scope.Chat_From_Profile.AreaShortCode == 'HQ') {
                $scope.defaultPositionValue = ['RD', 'AM', 'BM', 'RM', 'Admin', 'DR'];
            } else {
                if ($scope.Chat_From_Profile.ShortPosition == 'RD') {
                    $scope.defaultPositionValue = ['AM', 'BM', 'RM', 'Admin'];
                } else {
                    $scope.defaultPositionValue = ['AM', 'BM', 'RM', 'Admin'];
                }
            }

        }

        function setParamMasterSelect() {
            return {
                Position: $scope.selectModel.positionSelectedData.length > 0 ? $scope.selectModel.positionSelectedData.join(",") : null,
                RegionID: $scope.selectModel.regionSelectedData.length > 0 ? $scope.selectModel.regionSelectedData.join(",") : null,
                BranchCode: $scope.selectModel.branchSelectedData.length > 0 ? $scope.selectModel.branchSelectedData.join(",") : null,
                OwnEmpCode: $scope.Chat_From ? $scope.Chat_From : null,
                SystemUse: 'c'
            };
        }

        function iniPosition() {
            helper.executeServices(helper.servicesMethod.getMasterPosition, {OwnEmpCode: $scope.Chat_From}).then(function (resp) {
                $scope.masterPosition = resp.data.Data;
            });
        }

        function iniRegion() {
            helper.executeServices(helper.servicesMethod.getMasterRegion, setParamMasterSelect()).then(function (resp) {
                $scope.masterRegion = resp.data.Data;
            });
        }

        function iniBranch() {
            helper.executeServices(helper.servicesMethod.getMasterBranch, setParamMasterSelect()).then(function (resp) {
                $scope.masterBranch = resp.data.Data;
            });
        }

        function iniEmployee() {
            helper.executeServices(helper.servicesMethod.getMasterEmployee, setParamMasterSelect()).then(function (resp) {
                if (resp.data.Code == "100") {
                    $scope.masterEmployee = [];
                } else {
                    $scope.masterEmployee = resp.data.Data;
                }
            });
        }

        $scope.$watch("selectModel.positionSelectedData", function (nValue, oValue) {
            if (nValue.length == 0) {
                $scope.defaultEmployeeValue = null;
                $scope.selectModel.employeeSelectedData = [];
            }
            iniEmployee();
        });

        $scope.$watch("selectModel.regionSelectedData", function (nValue, oValue) {
            if (nValue && !angular.equals(nValue, oValue)) {
                iniBranch();
                iniEmployee();
            }
        });

        $scope.$watch("selectModel.branchSelectedData", function (nValue, oValue) {
            if (nValue && !angular.equals(nValue, oValue)) {
                iniEmployee();
            }
        });

        $scope.formatChatDateTime = function (datetime) {
            return helper.convertDateFormat(datetime, helper.formatDateTime.formatForChat).toLowerCase();
        };

        function getBroadCastHistory(currentItem) {
            helper.executeServices(helper.servicesMethod.getBroadCastHistoryData, {OwnEmpCode: $scope.Chat_From}).then(function (resp) {
                var data = resp.data.Data;
                $scope.countUnreadBroadCast = data[0].CountUnreadAllType;
                $scope.AuthToBroadCast = data[0].AuthToBroadCast;

                data.map(function (item) {
                    var isSelect = false;

                    if (currentItem)
                        if (currentItem.BroadCast_Code == item.BroadCast_Code)
                            isSelect = true;

                    return $.extend(item, {
                        selected: isSelect
                    });
                });

                angular.copy(data, $scope.broadCastHistoryData);
            });
        }

        $scope.updateBroadCastItem = function (items) {
            updateReadBroadCast(items, items.BroadCastHistory_Id);
        };

        $scope.$on("focusLastChatHistory", function (scope, elem, attrs) {
            elem.parents().animate({scrollTop: elem.parent().prop("scrollHeight")}, 0);
        });

        function updateReadBroadCast(items, historyCode) {

            var broadCastCode = historyCode | items.BroadCast_Code;

            var obj = {
                BroadCast_Code: broadCastCode,
                BroadCastHistory_EmpCode: $scope.Chat_From
            };

            helper.executeServices(helper.servicesMethod.updateBroadCastHistory, obj).then(function (resp) {
                var data = resp.data.Data;
                getBroadCastHistory(items);
            });
        }

        $scope.sendBroadCast = function (message) {
            if (confirm("Confirm send broadcast message?")) {
                var criteria = setParamMasterSelect();

                var obj = {
                    BroadCast_Code: $scope.broadCastSelectItem.BroadCast_Code,
                    BroadCastHistory_EmpCode: null,
                    BroadCastHistory_Message: $scope.model.txtBroadCastMessage.replace(/\r\n?|\n/g, '<br />'),
                    Own_EmpCode: $scope.Chat_From
                };

                $.extend(obj, criteria);

                helper.broadcasthistory_insert(obj.BroadCast_Code, obj).then(function (resp) {
                    var data = resp.data;
                    console.log(data);

                    var objSocket = {};
                    objSocket.to = $scope.masterEmployee.map(function (n) {
                        return n.EmployeeCode;
                    });
                    objSocket.broadCastObj = $scope.broadCastSelectItem;
                    objSocket.message = message;

                    socket.emit("broadcast:to", objSocket);

                    getBroadCastHistory($scope.broadCastSelectItem);

                    $scope.model.txtBroadCastMessage = "";
                    $("#txtBroadCastMessage").css("height", 40);
                });
            }
        };

    });
