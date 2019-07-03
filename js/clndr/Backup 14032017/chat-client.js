angular.module("chat-client", [
    "ui.bootstrap"
])
    .constant("uiMultipleSelectConfig", {select: {}})
    .constant("uiChatClientConfig", {
        permission: ['57251', '56225', '58141', '56679', '58106', '59016', '58385', '57160', '58355', '56365', '59440']
    })
    .factory("socket", function ($rootScope) {
        //var socket = io.connect("http://tc001pcis1p", {path: '/node/pcischat/socket.io', "forceNew": true});
        //var socket = io.connect("http://localhost:1337", {"forceNew": true});
        var socket = io.connect("http://172.17.9.94:5555");
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

                scope.tabs.index = scope.tabs.index || ( active ? index : null );

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
        //var links = "http://localhost:59392/LBServices.svc/";

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
    .directive("uiChatClient", function (uiChatClientConfig, socket, helper, $q, $timeout, $filter, $log, $uibModal) {

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
                scope.chatgroupslist = [];
                scope.chatgroupsSelect = [];
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
                scope.helper = helper;

                scope.linksEmployee = helper.links() + 'employee/image/';
                scope.profileImage = "";
                scope.newGroupImage = "";
                scope.pictureFile = null;
                scope.chatGroupMemberData = [];
                scope.deleteMemberList = [];
                scope.savingConfig = false;
                scope.isConfig = false;
                scope.isShowMember = false;
                scope.isShowInvite = false;
                scope.rename = false;
                scope.oldGroupName = null;
                scope.userChatGroup = [];
                scope.inviteUserChatGroup = [];
                scope.inviteUserlimit = 10;
                scope.inviteCheckall = {value: false};
                scope.inviteResult = [];
                scope.setFileUpload = function (event) {
                    var reader = new FileReader();
                    reader.onload = function () {
                        scope.profileImage = reader.result;
                    };
                    scope.pictureFile = event.target.files[0];
                    reader.readAsDataURL(scope.pictureFile);
                };
                scope.setNewGroupPicture = function (event) {
                    var reader = new FileReader();
                    reader.onload = function () {
                        scope.newGroupImage = reader.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                };
                scope.leaveGroup = function () {
                    if (confirm("Are you sure to leave from group " + scope.currentChatInformation.Group_Name)) {
                        helper.chatgroup_leave(
                            scope.currentChatInformation.Group_Code,
                            scope.data.from
                        ).then(function (resp) {
                                scope.clearSearch();
                                scope.userlimit = 10;
                                modalIsOpen = false;
                                scope.isOpenSearch = false;
                                scope.currentChatInformation = null;

                                scope.profileImage = "";
                                scope.newGroupImage = "";
                                scope.newGroupProfilePicture = null;
                                scope.pictureFile = null;
                                scope.chatGroupMemberData = [];
                                scope.deleteMemberList = [];
                                scope.savingConfig = false;
                                scope.isConfig = false;
                                scope.isShowMember = false;
                                scope.isShowInvite = false;
                                scope.rename = false;
                                scope.oldGroupName = null;
                                iniChatHistory("view");
                            });
                    }
                };
                scope.deleteGroupConfig = function () {
                    if (confirm("Are you sure to delete this group.")) {
                        helper.chatgroup_delete(scope.currentChatInformation.Group_Code).then(function (resp) {
                            scope.clearSearch();
                            scope.userlimit = 10;
                            modalIsOpen = false;
                            scope.isOpenSearch = false;
                            scope.currentChatInformation = null;

                            scope.profileImage = "";
                            scope.newGroupImage = "";
                            scope.newGroupProfilePicture = null;
                            scope.pictureFile = null;
                            scope.chatGroupMemberData = [];
                            scope.deleteMemberList = [];
                            scope.savingConfig = false;
                            scope.isConfig = false;
                            scope.isShowMember = false;
                            scope.isShowInvite = false;
                            scope.rename = false;
                            scope.oldGroupName = null;
                            iniChatHistory("view");
                        });
                    }
                };
                scope.updateGroupConfig = function () {

                    scope.savingConfig = true;

                    if (scope.groupProfilePicture) {

                        var date = new Date();
                        var format = helper.convertDateFormat(date, "mm_ss");
                        var groupPicture = scope.groupProfilePicture[0];
                        var extension = groupPicture.name56u76hjg45hy54yygfrtftr
                        var groupFilePictureName = scope.currentChatInformation.Group_Code + format + "." + extension;

                        helper.file_upload(groupFilePictureName, groupPicture).then(function (resp) {
                            var param = {
                                Group_Id: scope.currentChatInformation.Group_Id,
                                Group_Code: scope.currentChatInformation.Group_Code,
                                Group_Name: scope.currentChatInformation.Group_Name,
                                Group_Image: helper.links() + "chat/group/image/" + groupFilePictureName
                            };

                            helper.chatgroup_update(scope.currentChatInformation.Group_Id, param).then(function (resp) {
                                scope.savingConfig = false;
                                scope.rename = false;
                                scope.deleteMemberList = [];
                                scope.oldGroupName = scope.currentChatInformation.Group_Name;
                                scope.currentChatInformation.Group_Image = param.Group_Image;
                                scope.getListChatUser(scope.data.from);
                            }).then(function (error) {
                                console.log(error);
                            });
                        });
                    }
                    else {
                        var param = {
                            Group_Id: scope.currentChatInformation.Group_Id,
                            Group_Code: scope.currentChatInformation.Group_Code,
                            Group_Name: scope.currentChatInformation.Group_Name
                        };

                        helper.chatgroup_update(scope.currentChatInformation.Group_Id, param).then(function (resp) {
                            scope.savingConfig = false;
                            scope.rename = false;
                            scope.deleteMemberList = [];
                            scope.oldGroupName = scope.currentChatInformation.Group_Name;
                            scope.currentChatInformation.Group_Image = param.Group_Image;
                            scope.getListChatUser(scope.data.from);
                        }).then(function (error) {
                            console.log(error);
                        });
                    }

                };
                scope.getGroupChatMember = function (groupCode) {
                    helper.chatgroup_member_read(groupCode).then(function (resp) {
                        scope.chatGroupMemberData = resp.data;
                    });
                };
                scope.recoverMember = function () {
                    angular.forEach(scope.deleteMemberList, function (value, key) {
                        scope.chatGroupMemberData.push(value);
                    });
                    scope.deleteMemberList = [];
                };
                scope.deleteMember = function (member) {
                    var index = scope.chatGroupMemberData.indexOf(member);
                    var itemMember = scope.chatGroupMemberData.splice(index, 1);
                    scope.deleteMemberList.push(itemMember[0]);
                };
                scope.deleteGroupAdmin = function (member) {
                    member.IsAdmin = false;
                };

                scope.showConfig = function () {
                    scope.isConfig = !scope.isConfig;
                    scope.isShowMember = false;
                    scope.isShowInvite = false;

                    if (!scope.isConfig) {
                        scope.rename = false;
                        scope.deleteMemberList = [];
                        if (scope.oldGroupName) {
                            scope.currentChatInformation.Group_Name = scope.oldGroupName;
                        }
                    }
                };

                scope.showMember = function () {
                    scope.isShowMember = !scope.isShowMember;
                    scope.isConfig = false;
                    scope.isShowInvite = false;
                    scope.deleteMemberList = [];
                    if (scope.isShowMember) {
                        scope.getGroupChatMember(scope.currentChatInformation.Group_Code);
                    }
                };

                scope.showInvite = function () {
                    scope.isShowMember = false;
                    scope.isConfig = false;
                    scope.isShowInvite = !scope.isShowInvite;
                };

                scope.groupRename = function () {
                    scope.rename = !scope.rename;

                    if (!scope.rename) {
                        scope.currentChatInformation.Group_Name = scope.oldGroupName;
                    }
                    else
                        scope.oldGroupName = scope.currentChatInformation.Group_Name;
                };

                scope.notInGroupMember = function (item) {
                    var result = true;
                    var item = whereObject(scope.chatGroupMemberData, {EmployeeCode: item.EmployeeCode})[0];

                    if (item)
                        result = false;

                    return result;
                };

                scope.inviteMember = function () {

                    var objParam = [];
                    $.each(scope.inviteUserChatGroup.map(function (n) {
                        return n.EmployeeCode;
                    }), function (index, empcode) {
                        objParam.push({
                            Group_Code: scope.currentChatInformation.Group_Code,
                            Group_EmployeeCode: empcode,
                            Group_Subscribe: null,
                            Group_Leave: null,
                            Group_Admin: null
                        });
                    });

                    helper.chatgroup_member_insert(scope.currentChatInformation.Group_Code, objParam).then(function (resp) {
                        console.log(resp);
                    });
                };

                scope.checkedInviteChatUser = function (item) {
                };

                scope.inviteLoadMoreUser = function () {
                    if (scope.inviteUserlimit < scope.chatusers.length)
                        scope.inviteUserlimit += 10;
                };

                scope.$watch("userChatGroup", function (n, o) {
                    scope.inviteUserChatGroup = whereObject(n, {selected: true});
                }, true);

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
                    scope.newGroupImage = "";
                    scope.newGroupProfilePicture = null;
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
                    scope.getListChatGroups(username);
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

                scope.filterNotification = function (value, item) {

                    angular.forEach(helper.whereObject(item.RegionGroup, {isSelect: true}), function (item, key) {
                        item.isSelect = false;
                    });

                    value.isSelect = true;

                    if (value.text == "All") {
                        item.FilterBy = null;
                        item.CountTransaction = item.Data.length;
                    }
                    else {
                        item.FilterBy = value.text;
                        item.CountTransaction = helper.whereObject(item.Data, {filterName: item.FilterBy}).length;
                    }
                };

                function iniNotification() {
                    helper.notification_read(scope.data.from).then(function (resp) {
                        var data = resp.data;
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

                scope.$watch("chatgroupslist", function (n, o) {
                    if (n) {
                        scope.chatgroupsSelect = helper.whereObject(n, {selected: true});
                    }
                }, true);

                function clearSelectGroups() {
                    scope.chatgroupsSelect = [];
                    angular.forEach(scope.chatgroupslist, function (item, index) {
                        item.selected = false;
                    });
                }

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
                        angular.copy(data, scope.userChatGroup);
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

                scope.getListChatGroups = function (empcode, groupCode) {
                    helper.chatgroup_read(empcode, groupCode).then(function (resp) {
                        var data = resp.data;
                        data.map(function (item) {
                            return $.extend(item, {
                                selected: false
                            });
                        });
                        angular.copy(data, scope.chatgroupslist);
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

                        scope.profileImage = "";
                        scope.newGroupImage = "";
                        scope.newGroupProfilePicture = null;
                        scope.pictureFile = null;
                        scope.chatGroupMemberData = [];
                        scope.deleteMemberList = [];
                        scope.savingConfig = false;
                        scope.isConfig = false;
                        scope.isShowMember = false;
                        scope.isShowInvite = false;
                        scope.rename = false;
                        scope.oldGroupName = null;
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

                scope.openNotificationInfoDialog = function () {
                    var modalInstance = $uibModal.open({
                        animation: true,
                        windowClass: "animated zoomIn",
                        templateUrl: 'modalNotificationInfo.html',
                        size: "lg",
                        scope: scope
                    });

                    modalInstance.result.then(function (resp) {
                    }, function () {
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
                        angular.forEach(scope.chatusers, function (item, index) {
                            if (whereObject(scope.onlineUser, item.EmployeeCode).length > 0) {
                                item.onlineStatus = true;
                            }
                            else {
                                item.onlineStatus = false;
                            }
                        });

                        angular.forEach(scope.chatuserslist, function (item, index) {
                            if (whereObject(scope.onlineUser, item.EmployeeCode).length > 0) {
                                item.onlineStatus = true;
                            }
                            else {
                                item.onlineStatus = false;
                            }
                        });

                        //whereObject(scope.chatusers, {EmployeeCode: empCode}).map(function (item) {
                        //    item.onlineStatus = status;
                        //    return item;
                        //});
                        //whereObject(scope.chatuserslist, {EmployeeCode: empCode}).map(function (item) {
                        //    item.onlineStatus = status;
                        //    return item;
                        //});
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

                    scope.profileImage = "";
                    scope.newGroupImage = "";
                    scope.newGroupProfilePicture = null;
                    scope.pictureFile = null;
                    scope.chatGroupMemberData = [];
                    scope.deleteMemberList = [];
                    scope.savingConfig = false;
                    scope.isConfig = false;
                    scope.isShowMember = false;
                    scope.isShowInvite = false;
                    scope.rename = false;
                    scope.oldGroupName = null;

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

                    if (scope.chatgroupsSelect) {
                        angular.forEach(scope.chatgroupsSelect, function (item, index) {
                            var memberCode = item.Group_Member.map(function (member) {
                                return member.EmployeeCode;
                            });
                            $.merge(data.to, memberCode);
                        });

                        data.to = $.unique(data.to);
                    }

                    if (scope.newGroupProfilePicture) {

                        var date = new Date();
                        var format = helper.convertDateFormat(date, "mm_ss");
                        var groupPicture = scope.newGroupProfilePicture[0];
                        var extension = groupPicture.name.replace(/^.*\./, '');
                        var groupFilePictureName = data.groupid + format + "." + extension;

                        helper.file_upload(groupFilePictureName, groupPicture).then(function (resp) {

                            helper.executeServices(helper.servicesMethod.createGroupChat, {
                                Group_Code: data.groupid,
                                Group_Name: data.groupname,
                                Group_Image: helper.links() + "chat/group/image/" + groupFilePictureName,
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
                                scope.newGroupProfilePicture = null;
                                scope.newGroupImage = "";

                                clearAllChecBox();
                                clearSelectGroups();
                            });

                        });
                    }
                    else {
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
                            scope.newGroupProfilePicture = null;
                            scope.newGroupImage = "";

                            clearAllChecBox();
                            clearSelectGroups();
                        });
                    }

                    scope.getGroupChatMember(data.groupcode);
                };

                scope.select = function (items) {
                    scope.chatuserslist.map(function (item) {
                        return item.isSelected = false;
                    });

                    scope.newGroupImage = "";
                    scope.newGroupProfilePicture = null;
                    items.isSelected = true;
                    scope.showNewGroup = false;
                    scope.rename = false;
                    scope.isConfig = false;
                    scope.isShowMember = false;
                    scope.isShowInvite = false;
                    scope.deleteMemberList = [];
                    doUpdateChatHistory(items);

                    if (items.Group_Code) {
                        scope.getGroupChatMember(scope.currentChatInformation.Group_Code);
                    }
                };

                scope.sendMessage = function (message) {

                    if (message) {

                        if (scope.isOpenSearch && !scope.newChatUser.checked)
                            return false;

                        var submitData = [];

                        if (scope.isOpenSearch) {
                            if (scope.newChatUser.checked.length > 0) {
                                scope.currentChatInformation = scope.newChatUser.checked[0];
                                scope.data.to = scope.newChatUser.checked.map(function (item) {
                                    return item.EmployeeCode;
                                }).join(",");
                            }
                            else {
                                scope.data.to = null;
                                //if (scope.currentChatInformation) {
                                //    scope.data.to = scope.currentChatInformation.EmployeeCode;
                                //}
                                //else {
                                //    var item = whereObject(scope.chatusers, {EmployeeCode: scope.txtSearchUsers});
                                //    scope.currentChatInformation = item[0];
                                //    scope.data.to = scope.currentChatInformation.EmployeeCode;
                                //}
                            }
                        }

                        var cInfomation = null;
                        var date = new Date();
                        var servertime = helper.convertDateFormat(date, helper.formatDateTime.formatToServer);

                        if (scope.data.to) {

                            var param = {
                                Chat_From: scope.data.from,
                                Chat_To: scope.data.to,
                                Chat_Message: $("#txtChatMessage").val().replace(/\r\n?|\n/g, '<br />'),
                                Chat_DateTime: servertime,
                                Chat_Type: scope.currentChatInformation.Group_Id ? "G" : "P",
                                Chat_Room: scope.currentChatInformation.Group_Id ? scope.currentChatInformation.Group_Code : null,
                                Chat_Status: "U",
                                Chat_Active: true
                            };

                            var deffered = $q.defer();

                            helper.chathistory_insert(param)
                                .then(function () {
                                    deffered.resolve();
                                }).then(function () {
                                    deffered.reject();
                                });

                            submitData.push(deffered);

                            cInfomation = scope.ownuser;
                        }

                        if (scope.chatgroupsSelect) {

                            angular.forEach(scope.chatgroupsSelect, function (item, index) {
                                var param = {
                                    Chat_From: scope.data.from,
                                    Chat_To: item.Group_Code,
                                    Chat_Message: $("#txtChatMessage").val().replace(/\r\n?|\n/g, '<br />'),
                                    Chat_DateTime: servertime,
                                    Chat_Type: "G",
                                    Chat_Room: item.Group_Code,
                                    Chat_Status: "U",
                                    Chat_Active: true
                                };

                                var deffered = $q.defer();

                                helper.chathistory_insert(param)
                                    .then(function () {
                                        deffered.resolve();
                                    }).then(function () {
                                        deffered.reject();
                                    });

                                submitData.push(deffered);
                            });

                            if (!cInfomation) {
                                cInfomation = scope.chatgroupsSelect[0];
                                cInfomation.Chat_UserInGroup = cInfomation.Group_Member.map(function (member) {
                                    return member.EmployeeCode;
                                }).join(",");
                                scope.currentChatInformation = cInfomation;
                            }
                        }

                        scope.data.message = message;
                        scope.data.sendtime = helper.convertDateFormat(date, helper.formatDateTime.formatForChat).toLowerCase();
                        scope.data.information = cInfomation;
                        //scope.data.information = scope.currentChatInformation.Group_Id ? scope.currentChatInformation : scope.ownuser;

                        if (submitData.length > 0) {

                            $q.all(submitData)
                                .then(function (resp) {

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
                                    scope.getListChatGroups(scope.data.from);

                                    scope.isOpenSearch = false;
                                    scope.clearSearch();
                                    clearSelectGroups();

                                    $("#txtChatMessage").val("");
                                    $("#txtChatMessage").css("height", 40);

                                });

                            //helper.chathistory_insert({
                            //    Chat_From: scope.data.from,
                            //    Chat_To: scope.data.to,
                            //    Chat_Message: $("#txtChatMessage").val().replace(/\r\n?|\n/g, '<br />'),
                            //    Chat_DateTime: servertime,
                            //    Chat_Type: scope.currentChatInformation.Group_Id ? "G" : "P",
                            //    Chat_Room: scope.currentChatInformation.Group_Id ? scope.currentChatInformation.Group_Code : null,
                            //    Chat_Status: "U",
                            //    Chat_Active: true
                            //}).then(function (resp) {
                            //
                            //    if (scope.currentChatInformation.Chat_UserInGroup) {
                            //        scope.data.to = scope.currentChatInformation.Chat_UserInGroup.split(",");
                            //    }
                            //    else {
                            //        scope.data.to = scope.data.to.split(",");
                            //    }
                            //
                            //    socket.emit("chat:to", scope.data);
                            //
                            //    scope.getChatRoomHistory();
                            //    scope.getChatRecentMessage(scope.data.from);
                            //    scope.getListChatUser(scope.data.from);
                            //    scope.getListChatGroups(scope.data.from);
                            //
                            //    scope.isOpenSearch = false;
                            //    scope.clearSearch();
                            //    clearSelectGroups();
                            //
                            //    $("#txtChatMessage").val("");
                            //    $("#txtChatMessage").css("height", 40);
                            //});
                        }
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

                    $timeout(function () {
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
                    }, 1000);

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
                        }
                        else {
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
                }
                else {
                    return [cDate, lastDateofMonth];
                }
            }
            else {
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


    });

