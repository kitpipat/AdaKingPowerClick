<script>
//เมื่อคลิก สร้างอัตโนมัติ input disable
$("#ocbSRTRptMenuCode").click(function() {
    if ($('#ocbSRTRptMenuCode').is(':checked')) {
        $('#oetSRTRptMenuCode').prop('disabled', true);
        $('#oetSRTRptMenuCode').val('');
        $('#oetSRTRptMenuCode').parents('.form-group').removeClass("has-error");
    } else {
        $('#oetSRTRptMenuCode').prop('disabled', false);
    }
})


//Browse MenuGrp
var oBrowseReportMenuGrp = function(poReturnInput) {
    let tInputReturnCode = poReturnInput.tReturnInputCode;
    let tInputReturnName = poReturnInput.tReturnInputName;
    var tInputModCode = poReturnInput.tReturnModCode;

    var oSRTBrowseReportMenuGrp = {
        Title: ['settingconfig/settingmenu/settingmenu', 'tSettingMenuGroup'],
        Table: {
            Master: 'TSysReportGrp',
            PK: 'FTGrpRptCode'
        },
        Join: {
            Table: ['TSysReportGrp_L'],
            On: ['TSysReportGrp.FTGrpRptCode = TSysReportGrp_L.FTGrpRptCode AND TSysReportGrp_L.FNLngID =' +
                nLangEdits
            ]
        },
        Where: {
            Condition: ["AND TSysReportGrp.FTGrpRptModCode = '" +
                tInputModCode + "'"
            ]
        },
        GrideView: {
            ColumnPathLang: 'settingconfig/settingmenu/settingmenu',
            ColumnKeyLang: ['tModalRptGrpCode', 'tModalRptGrpName'],
            ColumnsSize: ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TSysReportGrp.FTGrpRptCode', 'TSysReportGrp_L.FTGrpRptName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TSysReportGrp.FNGrpRptShwSeq ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TSysReportGrp_L.FTGrpRptCode"],
            Text: [tInputReturnName, "TSysReportGrp_L.FTGrpRptName"]
        },
        NextFunc: {
            FuncName: 'FSxSRTSetMaxSequenceAndGenCodeMenu',
            ArgReturn: ['FTGrpRptCode', 'FTGrpRptName']
        },
    };
    return oSRTBrowseReportMenuGrp;
}

//open browse module Rpt
$('#obtSRTBrowseModMenuRpt').click(function() {
    $('#odvSRTModalAddEditReportMenu').modal("hide");
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) != 'undefined' && nStaSession == 1) {
        window.oBrowseModuleMenuReportOption = oBrowseModuleReport({
            'tReturnInputCode': 'oetSRTReportGrpModMenuCode',
            'tReturnInputName': 'oetSRTReportGrpModMenuName',
            'tNextFuncName': 'FSxModalMenuRptShow',
        });
        JCNxBrowseData('oBrowseModuleMenuReportOption');

    } else {
        JCNxShowMsgSessionExpired();
    }
});


//open browse Group Rpt
$('#obtSRTBrowseGrpRpt').click(function() {
    $('#odvSRTModalAddEditReportMenu').modal("hide");
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) != 'undefined' && nStaSession == 1) {
        window.oBrowseReportMenuGrpOption = oBrowseReportMenuGrp({
            'tReturnInputCode': 'oetSRTReportMenuGrpCode',
            'tReturnInputName': 'oetSRTReportMenuGrpName',
            'tReturnModCode': $('#oetSRTReportGrpModMenuCode').val(),
        });
        JCNxBrowseData('oBrowseReportMenuGrpOption');

    } else {
        JCNxShowMsgSessionExpired();
    }
});


//Functionality: modal menu report open
//Parameters: จากการ ฺBrowse Module
//Creator: 17/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function FSxModalMenuRptShow() {
    JSxCheckPinMenuClose()
    $('#odvSRTModalAddEditReportMenu').modal("show");
    $('#oetSRTReportMenuGrpCode').val('');
    $('#oetSRTReportMenuGrpName').val('');
}


//Functionality: Gen Sequence And GenCode
//Parameters: จากการ ฺBrowse Module
//Creator: 17/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function FSxSRTSetMaxSequenceAndGenCodeMenu(tGmnRptGrpCode) {
    JSxCheckPinMenuClose()
    if (tGmnRptGrpCode == 'NULL') {
        $('#odvSRTModalAddEditReportMenu').modal("show");
    } else {
        oGmnRptGrpCode = JSON.parse(tGmnRptGrpCode)
        FSxSRTMaxSequenceAndGenCode('CallMaxValueSequenceRpt','TSysReport', 'FTGrpRptCode', 'FTRptSeqNo', oGmnRptGrpCode[0], 'FTRptCode',
            function(
                tResult) {
                var aResult = JSON.parse(tResult);
                if (aResult['aData'][0]['FTRptSeqNo'] == null || aResult['aData'][0]['FTRptSeqNo'] == '') {
                    nMaxSeq = 0 + 1;
                } else {
                    nMaxSeq = parseInt(aResult['aData'][0]['FTRptSeqNo']) + 1;
                }
                $('#oetSRTRptMenuSeq').val(nMaxSeq);
                $('#ohdSeqRptList').val(nMaxSeq);
            });

            FSxSRTMaxSequenceAndGenCode('GenCodeRpt','TSysReport', 'FTRptCode', '', oGmnRptGrpCode[0], 'FTRptCode',
            function(
                tResult) {
                var aResult = JSON.parse(tResult);
                var tPattern = "000";
                if (aResult['aData'][0]['FTRptCode'] == null || aResult['aData'][0]['FTRptCode'] == '') {
                    nFieldCode = 0 + 1;
                } else {
                    nFieldCode = parseInt(aResult['aData'][0]['FTRptCode']) + 1;
                }
                var tNewnFieldCode = oGmnRptGrpCode[0].concat((tPattern + nFieldCode).slice(-3));
                $('#oetSRTRptMenuCode').attr('data-RptMenuCode', tNewnFieldCode);
                $('#odvSRTModalAddEditReportMenu').modal("show");
            });
    }
}

var oBrowseFilterReport = function(poReturnInput) {
    let tInputReturnCode = poReturnInput.tReturnInputCode;
    let tInputReturnName = poReturnInput.tReturnInputName;
    let tFilterNextFunc = poReturnInput.tNextFuncName;
    let aFilterArgReturn = poReturnInput.aArgReturn;

    var oOptionReturn = {
        Title: ['settingconfig/settingmenu/settingmenu', 'tSettingReportModule'],
        Table: {
            Master: 'TSysReportFilter',
            PK: 'FTRptFltCode'
        },
        Join: {
            Table: ['TSysReportFilter_L'],
            On: ['TSysReportFilter.FTRptFltCode = TSysReportFilter_L.FTRptFltCode AND TSysReportFilter_L.FNLngID =' +
                nLangEdits
            ]
        },
        Where: {
            Condition: ["AND TSysReportFilter_L.FTRptFltCode IS NOT NULL"]
        },
        GrideView: {
            ColumnPathLang: 'settingconfig/settingmenu/settingmenu',
            ColumnKeyLang: ['tValidRptFilterCode', 'tValidRptFilterName'],
            ColumnsSize: ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TSysReportFilter.FTRptFltCode', 'TSysReportFilter_L.FTRptFltName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TSysReportFilter.FTRptFltCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TSysReportFilter_L.FTRptFltCode"],
            Text: [tInputReturnName, "TSysReportFilter_L.FTRptFltCode"],
        },
        NextFunc: {
            FuncName: tFilterNextFunc,
            ArgReturn: aFilterArgReturn
        },
    }
    return oOptionReturn;
}

//open browse filter
$('#obtSRTBrowseFilterRpt').click(function() {
    $('#odvSRTModalAddEditReportMenu').modal("hide");
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) != 'undefined' && nStaSession == 1) {
        window.oBrowseFilterReportOption = oBrowseFilterReport({
            'tReturnInputCode': 'oetSRTReportMenuFilterCode',
            'tReturnInputName': 'oetSRTReportMenuFilterName',
            'tNextFuncName': 'JSxConsNextFuncBrowseFilter',
            'aArgReturn': ['FTRptFltCode', 'FTRptFltName']
        });
        JCNxBrowseMultiSelect('oBrowseFilterReportOption');

    } else {
        JCNxShowMsgSessionExpired();
    }
});


//Functionality: Show filter 
//Parameters: Function Parameter
//Creator: 19/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxConsNextFuncBrowseFilter(poDataNextFunc) {
    JSxCheckPinMenuClose()
    $('#odvFilterShow').html('');
    if (typeof(poDataNextFunc[0]) != 'undefined' && poDataNextFunc[0] != null) { //poDataNextFunc[0] != "NULL"
        var tHtml = '';
        for ($i = 0; $i < poDataNextFunc.length; $i++) {
            var aText = JSON.parse(poDataNextFunc[$i]);
            tHtml += '<span class="label label-info m-r-5">' + aText[1] + '</span>';

        }
    }
    $('#odvFilterShow').html(tHtml);
    $('#odvSRTModalAddEditReportMenu').modal("show");
}

//blur เช็ค menucode ว่าซ้ำหรือไม่
$('#oetSRTRptMenuCode').blur(function() {
    aData = {
        tTableName: "TSysReport",
        tFieldName: "FTRptCode",
        tCode: $('#oetSRTRptMenuCode').val(),
    }
    JSoSRTCheckRptDupInDB(aData, function(
        tResult) {
        var aResult = JSON.parse(tResult);
        $("#ohdCheckDuplicateRptMenuCode").val(aResult["rtCode"]);
        aRules = {
            oetSRTRptMenuCode: {
                "required": {},
                "dublicateCode": {}
            },
        }
        aMessages = {
            oetSRTRptMenuCode: {
                "required": $('#oetSRTRptMenuCode').attr('data-validate-required'),
                "dublicateCode": $('#oetSRTRptMenuCode').attr('data-validate-dublicateCode'),
            },
        }
        JSxSRTSetValidEventBlur('ofmSRTAddEditReportMenu', aRules, aMessages,
            'ohdCheckDuplicateRptMenuCode');
        $('#ofmSRTAddEditReportMenu').submit();
    });
});


//Submit Add Update
$("#obtSRTModalRptMenuSubmit").click(function() {
    var tForm = 'ofmSRTAddEditReportMenu';
    var tRoute = 'SettingReportAddEditRptMenu';
    var aRules = {
        oetSRTRptMenuCode: {
            "required": {
                depends: function(oElement) {
                    if ($('#oetSRTRptMenuCode').is(':disabled')) {
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            "dublicateCode": {}
        },
        oetSRTReportGrpModMenuName: {
            "required": {}
        },
        oetSRTReportMenuGrpName: {
            "required": {}
        },
        oetSRTRptMenuName: {
            "required": {}
        },
        oetSRTRptMenuSeq: {
            "required": {}
        }
    }
    var aMessages = {
        oetSRTRptMenuCode: {
            "required": $('#oetSRTRptMenuCode').attr('data-validate-required'),
            "dublicateCode": $('#oetSRTRptMenuCode').attr('data-validate-dublicateCode'),
        },
        oetSRTReportGrpModMenuName: {
            "required": $('#oetSRTReportGrpModMenuName').attr('data-validate-required'),
        },
        oetSRTReportMenuGrpName: {
            "required": $('#oetSRTReportMenuGrpName').attr('data-validate-required'),
        },
        oetSRTRptMenuName: {
            "required": $('#oetSRTRptMenuName').attr('data-validate-required'),
        },
        oetSRTRptMenuSeq: {
            "required": $('#oetSRTRptMenuSeq').attr('data-validate-required'),
        },
    }
    var oOhdCheckDup = 'ohdCheckDuplicateRptMenuCode';
    if ($('#oetSRTRptMenuCode').is(':disabled') && $('#oetSRTRptMenuCode').val() == '') {
        tRptMenuCode = $('#oetSRTRptMenuCode').attr('data-RptMenuCode');
    } else {
        tRptMenuCode = $('#oetSRTRptMenuCode').val();
    }

    JSxSMUCheckDupSeq('TSysReport','','',tRptMenuCode,$("#oetSRTRptMenuSeq").val(),'MenulistRpt',$('#oetSRTReportGrpModMenuCode').val(),$('#oetSRTReportMenuGrpCode').val());

    if($('#ohdRptListCode').val() != ''){
        tTableName = 'TSysReport';
        tFieldWhere = 'FTRptCode';
        tFieldSeqName = 'FTRptSeqNo';
        tSeqAfter = $('#ohdSeqRptList').val();
        tCode = $("#ohdRptListCode").val();
    }else{
        tTableName = '';
        tFieldWhere = '';
        tFieldSeqName = '';
        tSeqAfter = '';
        tCode = '';
    }

    var aData = {
        tModCode: $('#oetSRTReportGrpModMenuCode').val(),
        tMenuGrpCode: $('#oetSRTReportMenuGrpCode').val(),
        tRptMenuCode: tRptMenuCode,
        tRptMenuName: $('#oetSRTRptMenuName').val(),
        tRptMenuUrl: $('#oetSRTRptMenuUrl').val(),
        tRptFilter: $('#oetSRTReportMenuFilterName').val(),
        tRptMenuSeq: $("#oetSRTRptMenuSeq").val(),

        tTableName: tTableName,
        tFieldWhere: tFieldWhere,
        tFieldSeqName: tFieldSeqName,
        tSeqAfter: tSeqAfter ,
        tCode:tCode,
    }

    JSoSRTAddEditRpt(tForm, aRules, aMessages, oOhdCheckDup, tRoute, aData, function(tResult) {
        var aResult = JSON.parse(tResult);
        if (aResult["nStaEvent"] = 1) {
            $('#odvSRTModalAddEditReportMenu').modal("hide");
            JSxSMUSettingReportCallPage()
        }
    });
});


//Functionality: Call Modal edit menu Report
//Parameters: Function Parameter
//Creator: 18/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSRTCallModalEditRptMenu(tCode, tName) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: 'CallModalReportMenuEdit',
                data: {
                    tCode: tCode,
                },
                async: true,
                success: function(tResult) {
                    JSxCheckPinMenuClose()
                    JCNxCloseLoading();
                    var aResult = JSON.parse(tResult);
                    console.log(aResult)
                    $('#odvMenuList').val(4);
                    $('#odvSRTRptMenuCode').hide();
                    $('#odvSRTModalAddEditReportMenu').modal('show');
                    $('#oetSRTReportGrpModMenuCode').val(aResult['oReport']['raItems'][0][
                        'FTGrpRptModCode'
                    ]);
                    $('#oetSRTReportGrpModMenuName').val(aResult['oReport']['raItems'][0][
                        'FNGrpRptModName'
                    ]);
                    $('#oetSRTReportMenuGrpCode').val(aResult['oReport']['raItems'][0]['FTGrpRptCode']);
                    $('#oetSRTReportMenuGrpName').val(aResult['oReport']['raItems'][0]['FTGrpRptName']);
                    $('#oetSRTRptMenuCode').val(tCode);
                    $('#oetSRTRptMenuCode').prop('disabled', true);
                    $('#oetSRTRptMenuName').val(tName);
                    $('#oetSRTRptMenuUrl').val(aResult['oReport']['raItems'][0]['FTRptRoute']);
                    $('#oetSRTReportMenuFilterCode').val(aResult['oReport']['raItems'][0][
                        'FTRptFilterCol'
                    ]);
                    $('#oetSRTReportMenuFilterName').val(aResult['oReport']['raItems'][0][
                        'FTRptFilterCol'
                    ]);
                    $('#oetSRTRptMenuSeq').val(aResult['oReport']['raItems'][0]['FTRptSeqNo']);
                    $('#ohdSeqRptList').val(aResult['oReport']['raItems'][0]['FTRptSeqNo']);

                    if (typeof(aResult['oReportFilter']['raItems']) != 'undefined' && aResult[
                            'oReportFilter']['raItems'] != null) {
                        var tHtml = '';
                        for ($i = 0; $i < (aResult['oReportFilter']['raItems']).length; $i++) {
                            var aText = aResult['oReportFilter']['raItems'][$i]['FTRptFltName'];
                            tHtml += '<span class="label label-info m-r-5">' + aText + '</span>';

                        }
                    }
                    $('#odvFilterShow').html(tHtml);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSxSRTCallModalEdit Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Modal DeleteMenuRpt Confirm
//Parameters: มาจากการคลิกลบกลุ่มเมนู
//Creator: 19/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: 
function JSxSTRRptMenuDel(tMenuListCode, tMenuListName, tYesOrNo) {
    JSxCheckPinMenuClose()
    $('#odvSRTModalDelModuleReport').modal('show');
    $('#odvSRTModalDelModuleReport #ospConfirmDelete').html('<p><strong>' + $('#oetTextComfirmDeleteSingle').val() +
        tMenuListCode +
        ' ( ' +
        tMenuListName + ' ) ' + '</strong></p>');
    $('#ohdSRTConfirmIDDelete').val('SettingReportDelMenu');
    $('#osmSRTConfirm').val(tMenuListCode);
}

//close Browse filter
$(document).on('click', '#odvModalBrowseMultiContent #obtMultiBrowseCancelSelect', function() {
    JSxCheckPinMenuClose()
    $('#odvSRTModalAddEditReportMenu').modal("show");
});
</script>