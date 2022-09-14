$("document").ready(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose();
    JSxSMUSettingMenuCallPage();
    JSxSMUSettingReportCallPage();
} else {
    JCNxShowMsgSessionExpired();
}
});


// //Functionality : เรียกหน้าจอการตั้งค่าเมนูมาแสดง
// //Parameters : -
// //Creator : 21/08/2020 Sooksanti(Non)
// //Last Update:
// //Return : 
// //Return Type :
function JSxSMUSettingMenuCallPage() {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type: "POST",
                url: "SettingMenuGetPage",
                data: {},
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    $("#odvSMUContentPageSettingMenu").html(tResult);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSxSMUSettingMenuCallPage Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}


// //Functionality : เรียกหน้าจอการตั้งค่าเมนูมาแสดง
// //Parameters : -
// //Creator : 16/09/2020 Sooksanti(Non)
// //Last Update:
// //Return : 
// //Return Type :
function JSxSMUSettingReportCallPage() {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type: "POST",
                url: "SettingReportGetPage",
                data: {},
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    $("#odvSMUContentPageSettingReport").html(tResult);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSxSMUSettingMenuCallPage1 Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// //Functionality : (event) Add/Edit Module
// //Parameters : Rout เป็นค่าที่ได้จาก value obtSMPModalSubmit
// //Creator : 21/08/2020 Sooksanti(Non)
// //Last Update:
// //Return : 
// //Return Type :
function JSxSMUAddEditModule() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmSMPAddEditModule').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if ($("#ohdCheckDuplicateModuleCode").val() == 1) {
                return false;
            } else {
                return true;
            }
        }, '');


        // From Summit Validate
        $('#ofmSMPAddEditModule').validate({
            rules: {
                oetSMPModuleCode: {
                    "required": {},
                    "dublicateCode": {}
                },
                oetSMPModuleName: {
                    "required": {}
                },
                oetSMPModuleSeq: {
                    "required": {}
                }
            },
            messages: {
                oetSMPModuleCode: {
                    "required": $('#oetSMPModuleCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetSMPModuleCode').attr('data-validate-dublicateCode'),
                },
                oetSMPModuleName: {
                    "required": $('#oetSMPModuleName').attr('data-validate-required'),
                },
                oetSMPModuleSeq: {
                    "required": $('#oetSMPModuleSeq').attr('data-validate-required'),
                },
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').removeClass("has-error");
                }
            },
            submitHandler: function(form) {
                //if ($('#upload').val() == '') {
                    //JSxSMUAddEditModule($('#obtSMPModalSubmit').val());
               // } else {
                   // $('#obtSMPModalSubmit').click();
                    //if (nStaEvent = 1) {
                        //JSxSMUAddEditModule($('#obtSMPModalSubmit').val());
                   // }
                //}

                JSxSMUCheckDupSeq('TSysMenuGrpModule','FNGmnModShwSeq','FTGmnModCode',$('#oetSMPModuleCode').val(),$("#oetSMPModuleSeq").val(),'Module');
                if($('#ohdModuleCode').val() != ''){
                    tTableName = 'TSysMenuGrpModule';
                    tFieldWhere = 'FTGmnModCode';
                    tFieldSeqName = 'FNGmnModShwSeq';
                    tSeqAfter = $('#ohdSeqModule').val();
                    tCode = $("#ohdModuleCode").val();
                }else{
                    tTableName = '';
                    tFieldWhere = '';
                    tFieldSeqName = '';
                    tSeqAfter = '';
                    tCode = '';
                }

                //เป็นการเพิ่มข้อมูลแต่ถ้า Sequence ซ้ำของเดิมจะทำการสลับ Seq ให้
                    $.ajax({
                        type: "POST",
                        url: 'SettingMenuAddEditModule',
                        data: {
                            tModCode: $('#oetSMPModuleCode').val(),
                            tModName: $('#oetSMPModuleName').val(),
                            tModSeq: $("#oetSMPModuleSeq").val(),
                            tModPathIcon: $("#oetSMPModulePathIcon").val(),

                            tTableName: tTableName,
                            tFieldWhere: tFieldWhere,
                            tFieldSeqName: tFieldSeqName,
                            tSeqAfter: tSeqAfter ,
                            tCode:tCode,
                        },
                        async: false,
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            var aResult = JSON.parse(tResult);
                            if (aResult["nStaEvent"] = 1) {
                                $('#odvSMPModalAddEditModule').modal("hide");
                                JSxSMUSettingMenuCallPage()
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}


function JSxSMUCheckDupSeq(tTableName,tSeqTableName,tFieldWhere,tCode,tSeq,tType,tCode1,tCode2){
    $.ajax({
        type: "POST",
        url: 'CheckDupSeq',
        data: {
            tTableName: tTableName,
            tSeqTableName: tSeqTableName,
            tFieldWhere: tFieldWhere,
            tCode:tCode,
            tSeq: tSeq,
            tType:tType,
            tCode1:tCode1,
            tCode2:tCode2
        },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var aResult = JSON.parse(tResult);
            if(aResult['rtCode'] == 1){
                switch(tType) {
                    case 'Module':
                        $("#ohdModuleCode").val(aResult['raItems'][0]['FTGmnModCode']);
                      break;
                    case 'MenuGrp':
                        $("#ohdMenuGrpCode").val(aResult['raItems'][0]['FTGmnCode']);
                      break;
                    case 'Menulist':
                        $("#ohdMenuListCode").val(aResult['raItems'][0]['FTMnuCode']);
                      break;
                    case 'RptMod':
                        $("#ohdModuleCodeRpt").val(aResult['raItems'][0]['FTGrpRptModCode']);
                      break;
                    case 'MenuGrpRpt':
                        $("#ohdMenuGrpCodeRpt").val(aResult['raItems'][0]['FTGrpRptCode']);
                      break;
                    case 'MenulistRpt':
                        $("#ohdRptListCode").val(aResult['raItems'][0]['FTRptCode']);
                      break;
                  }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    }); 
}

//Functionality : (event) Add/Edit MenuGrp
//Parameters : -
//Creator : 21/08/2020 Sooksanti(Non)
//Last Update:
//Return : 
//Return Type :
function JSxSMUAddEditMenuGrp() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmSMPAddEditMenuGrp').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if ($("#ohdCheckDuplicateMenuGrpCode").val() == 1) {
                return false;
            } else {
                return true;
            }
        }, '');


        // From Summit Validate
        $('#ofmSMPAddEditMenuGrp').validate({
            rules: {
                oetSMPMenuGrpCode: {
                    "required": {},
                    "dublicateCode": {}
                },
                oetSMPMenuGrpName: {
                    "required": {}
                },
                oetSMPMenuGrpSeq: {
                    "required": {}
                },
                oetSMPMenuGrpModuleName: {
                    "required": {}
                }
            },
            messages: {
                oetSMPMenuGrpCode: {
                    "required": $('#oetSMPMenuGrpCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetSMPMenuGrpCode').attr('data-validate-dublicateCode'),
                },
                oetSMPMenuGrpName: {
                    "required": $('#oetSMPMenuGrpName').attr('data-validate-required'),
                },
                oetSMPMenuGrpSeq: {
                    "required": $('#oetSMPMenuGrpSeq').attr('data-validate-required'),
                },
                oetSMPMenuGrpModuleName: {
                    "required": $('#oetSMPMenuGrpModuleName').attr('data-validate-required'),
                },
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').removeClass("has-error");
                }
            },
            submitHandler: function(form) {
                JSxSMUCheckDupSeq('TSysMenuGrp','','',$('#oetSMPMenuGrpCode').val(),$("#oetSMPMenuGrpSeq").val(),'MenuGrp',$('#oetSMPMenuGrpModuleCode').val());

                if($('#ohdMenuGrpCode').val() != ''){
                    tTableName = 'TSysMenuGrp';
                    tFieldWhere = 'FTGmnCode';
                    tFieldSeqName = 'FNGmnShwSeq';
                    tSeqAfter = $('#ohdSeqMenuGrp').val();
                    tCode = $("#ohdMenuGrpCode").val();
                }else{
                    tTableName = '';
                    tFieldWhere = '';
                    tFieldSeqName = '';
                    tSeqAfter = '';
                    tCode = '';
                }

                $.ajax({
                    type: "POST",
                    url: 'SettingMenuAddEditMenuGrp',
                    data: {
                        tMenuGrpCode: $('#oetSMPMenuGrpCode').val(),
                        tMenuGrpName: $('#oetSMPMenuGrpName').val(),
                        tModCode: $('#oetSMPMenuGrpModuleCode').val(),
                        tMenuGrpSeq: $("#oetSMPMenuGrpSeq").val(),

                        tTableName: tTableName,
                        tFieldWhere: tFieldWhere,
                        tFieldSeqName: tFieldSeqName,
                        tSeqAfter: tSeqAfter ,
                        tCode:tCode,
                    },
                    async: false,
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        var aResult = JSON.parse(tResult);
                        if (aResult["nStaEvent"] = 1) {
                            $('#odvSMPModalAddEditMenuGrp').modal("hide");
                            JSxSMUSettingMenuCallPage()
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}


// //Functionality : (event) Add/Edit Menu/List
// //Parameters : -
// //Creator : 21/08/2020 Sooksanti(Non)
// //Last Update:
// //Return : 
// //Return Type :
function JSxSMUAddEditMenuList(tRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmSMPAddEditMenuList').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if ($("#ohdCheckDuplicateMenuListCode").val() == 1) {
                return false;
            } else {
                return true;
            }
        }, '');
        // From Summit Validate
        $('#ofmSMPAddEditMenuList').validate({
            rules: {
                oetSMPListName: {
                    "required": {},
                },
                oetSMPMenuListMenuGrpName: {
                    "required": {},
                },
                oetSMPMenuListModuleName: {
                    "required": {},
                },
                oetSMPMenuListName: {
                    "required": {}
                },
                oetSMPMenuListSeq: {
                    "required": {}
                }
            },
            messages: {
                oetSMPListName: {
                    "required": $('#oetSMPListName').attr('data-validate-required'),
                    "dublicateCode": $('#oetSMPListName').attr('data-validate-dublicateCode'),
                },
                oetSMPMenuListMenuGrpName: {
                    "required": $('#oetSMPMenuListMenuGrpName').attr('data-validate-required'),
                },
                oetSMPMenuListModuleName: {
                    "required": $('#oetSMPMenuListModuleName').attr('data-validate-required'),
                    "dublicateCode": $('#oetSMPMenuListModuleName').attr('data-validate-dublicateCode'),
                },
                oetSMPMenuListName: {
                    "required": $('#oetSMPMenuListName').attr('data-validate-required'),
                },
                oetSMPMenuListSeq: {
                    "required": $('#oetSMPMenuListSeq').attr('data-validate-required'),
                },
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').removeClass("has-error");
                }
            },
            submitHandler: function(form) {
                JSxSMUCheckDupSeq('TSysMenuList','','',$('#oetSMPMenuListCode').val(),$("#oetSMPMenuListSeq").val(),'Menulist',$('#oetSMPMenuListModuleCode').val(),$('#oetSMPMenuListMenuGrpCode').val());

                if($('#ohdMenuListCode').val() != ''){
                    tTableName = 'TSysMenuList';
                    tFieldWhere = 'FTMnuCode';
                    tFieldSeqName = 'FNMnuSeq';
                    tSeqAfter = $('#ohdSeqMenuList').val();
                    tCode = $("#ohdMenuListCode").val();
                }else{
                    tTableName = '';
                    tFieldWhere = '';
                    tFieldSeqName = '';
                    tSeqAfter = '';
                    tCode = '';
                }

                var nAutStaRead = $('#ocbSMPAutStaRead').is(':checked') ? 1 : 0;
                var nAutStaAdd = $('#ocbSMPAutStaAdd').is(':checked') ? 1 : 0;
                var nAutStaDelete = $('#ocbSMPAutStaDelete').is(':checked') ? 1 : 0;
                var nAutStaEdit = $('#ocbSMPAutStaEdit').is(':checked') ? 1 : 0;
                var nAutStaCancel = $('#ocbSMPAutStaCancel').is(':checked') ? 1 : 0;
                var nAutStaAppv = $('#ocbSMPAutStaAppv').is(':checked') ? 1 : 0;
                var nAutStaPrint = $('#ocbSMPAutStaPrint').is(':checked') ? 1 : 0;
                var nAutStaPrintMore = $('#ocbSMPAutStaPrintMore ').is(':checked') ? 1 : 0;
                var nMnuLevel = 0;
                if ($("#oetSMPMenuListMenuGrpCode").val() != '') {
                    nMnuLevel = 1;
                }
                $.ajax({
                    type: "POST",
                    url: 'SettingMenuAddEditMenuList',
                    data: {
                        tMnuCode: $('#oetSMPMenuListCode').val(),
                        tMnuName: $('#oetSMPMenuListName').val(),
                        tModCode: $('#oetSMPMenuListModuleCode').val(),
                        tMnuRmk: $('#oetSMPMenuListRemark').text(),
                        tGmnCode: $("#oetSMPMenuListMenuGrpCode").val(),
                        tMnuCtlName: $("#oetSMPMenuListControllerName").val(),
                        tMnuSeq: $("#oetSMPMenuListSeq").val(),
                        nMnuLevel: nMnuLevel,
                        nAutStaRead: nAutStaRead,
                        nAutStaAdd: nAutStaAdd,
                        nAutStaDelete: nAutStaDelete,
                        nAutStaEdit: nAutStaEdit,
                        nAutStaCancel: nAutStaCancel,
                        nAutStaAppv: nAutStaAppv,
                        nAutStaPrint: nAutStaPrint,
                        nAutStaPrintMore: nAutStaPrintMore,
                        tTypeURL: $('#oetSMPTypeURL').val(),


                        tTableName: tTableName,
                        tFieldWhere: tFieldWhere,
                        tFieldSeqName: tFieldSeqName,
                        tSeqAfter: tSeqAfter ,
                        tCode:tCode,
                    },
                    async: false,
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        var aResult = JSON.parse(tResult);
                        if (aResult["nStaEvent"] = 1) {
                            $('#odvSMPModalAddEditMenuList').modal("hide");
                            JSxSMUSettingMenuCallPage()
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}