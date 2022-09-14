<script>
//Submit Add Update
$("#obtSRTModalRptGrpSubmit").click(function() {
    var tForm = 'ofmSRTAddEditReportGrp';
    var tRoute = 'SettingReportAddEditRptGrp';
    var aRules = {
        oetSRTRptGrpCode: {
            "required": {
                depends: function(oElement) {
                    if ($('#oetSRTRptGrpCode').is(':disabled')) {
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            "dublicateCode": {}
        },
        oetSRTReportGrpModuleName: {
            "required": {}
        },
        oetSRTRptGrpName: {
            "required": {}
        },
        oetSRTRptGrpSeq: {
            "required": {}
        }
    }
    var aMessages = {
        oetSRTRptGrpCode: {
            "required": $('#oetSRTRptGrpCode').attr('data-validate-required'),
            "dublicateCode": $('#oetSRTRptGrpCode').attr('data-validate-dublicateCode'),
        },
        oetSRTReportGrpModuleName: {
            "required": $('#oetSRTReportGrpModuleName').attr('data-validate-required'),
        },
        oetSRTRptGrpName: {
            "required": $('#oetSRTRptGrpName').attr('data-validate-required'),
        },
        oetSRTRptGrpSeq: {
            "required": $('#oetSRTRptGrpSeq').attr('data-validate-required'),
        },
    }
    var oOhdCheckDup = 'ohdCheckDuplicateRptGrpCode';
    if ($('#oetSRTRptGrpCode').is(':disabled') && $('#oetSRTRptGrpCode').val() == '') {
        tRptGrpCode = $('#oetSRTRptGrpCode').attr('data-RptGrpCode');
    } else {
        tRptGrpCode = $('#oetSRTRptGrpCode').val();
    }

    JSxSMUCheckDupSeq('TSysReportGrp','','',tRptGrpCode,$("#oetSRTRptGrpSeq").val(),'MenuGrpRpt',$('#oetSRTReportGrpModuleCode').val());

    if($('#ohdMenuGrpCodeRpt').val() != ''){
        tTableName = 'TSysReportGrp';
        tFieldWhere = 'FTGrpRptCode';
        tFieldSeqName = 'FNGrpRptShwSeq';
        tSeqAfter = $('#ohdSeqMenuGrpRpt').val();
        tCode = $("#ohdMenuGrpCodeRpt").val();
    }else{
        tTableName = '';
        tFieldWhere = '';
        tFieldSeqName = '';
        tSeqAfter = '';
        tCode = '';
    }

    var aData = {
        tModCode: $('#oetSRTReportGrpModuleCode').val(),
        tRptGrpCode: tRptGrpCode,
        tRptGrpName: $('#oetSRTRptGrpName').val(),
        tRptGrpShwSeq: $("#oetSRTRptGrpSeq").val(),

        tTableName: tTableName,
        tFieldWhere: tFieldWhere,
        tFieldSeqName: tFieldSeqName,
        tSeqAfter: tSeqAfter,
        tCode: tCode,
    }


    JSoSRTAddEditRpt(tForm, aRules, aMessages, oOhdCheckDup, tRoute, aData, function(tResult) {
        var aResult = JSON.parse(tResult);
        if (aResult["nStaEvent"] = 1) {
            $('#odvSRTModalAddEditReportGrp').modal("hide");
            JSxSMUSettingReportCallPage()
        }
    });
});


//Functionality: Call Modal edit Group Report
//Parameters: Function Parameter
//Creator: 18/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSRTCallModalEditRptGrp(tCode, tName) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: 'CallModalReportGrpEdit',
                data: {
                    tCode: tCode,
                },
                async: true,
                success: function(tResult) {
                    JSxCheckPinMenuClose()
                    JCNxCloseLoading();
                    var aResult = JSON.parse(tResult);
                    $('#odvSRTRptGrpCode').hide();
                    $('#odvSRTModalAddEditReportGrp').modal('show');
                    $('#oetSRTReportGrpModuleCode').val(aResult['raItems'][0]['FTGrpRptModCode']);
                    $('#oetSRTReportGrpModuleName').val(tName);
                    $('#oetSRTRptGrpCode').val(aResult['raItems'][0]['FTGrpRptCode']);
                    $('#oetSRTRptGrpName').val(aResult['raItems'][0]['FTGrpRptName']);
                    $('#oetSRTRptGrpSeq').val(aResult['raItems'][0]['FNGrpRptShwSeq']);
                    $('#ohdSeqMenuGrpRpt').val(aResult['raItems'][0]['FNGrpRptShwSeq']);
                    $('#oetSRTRptGrpCode').attr('data-RptGrpCode', 'edit');
                    $('#oetSRTRptGrpCode').prop('disabled', true);
                    $('#odvSRTRptGrpCode').hide();
                    $('#odvMenuList').val(3);
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

//Browse Module Report
var nLangEdits = '<?=$this->session->userdata("tLangEdit")?>';
var oBrowseModuleReport = function(poReturnInput) {
    let tInputReturnCode = poReturnInput.tReturnInputCode;
    let tInputReturnName = poReturnInput.tReturnInputName;
    let tModuleNextFunc = poReturnInput.tNextFuncName;
    let aModuleArgReturn = poReturnInput.aArgReturn;

    var oOptionReturn = {
        Title: ['settingconfig/settingmenu/settingmenu', 'tSettingReportModule'],
        Table: {
            Master: 'TSysReportModule',
            PK: 'FTGrpRptModCode'
        },
        Join: {
            Table: ['TSysReportModule_L'],
            On: ['TSysReportModule.FTGrpRptModCode = TSysReportModule_L.FTGrpRptModCode AND TSysReportModule_L.FNLngID =' +
                nLangEdits
            ]
        },
        Where: {
            Condition: ["AND TSysReportModule_L.FTGrpRptModCode IS NOT NULL"]
        },
        GrideView: {
            ColumnPathLang: 'settingconfig/settingmenu/settingmenu',
            ColumnKeyLang: ['tModalModuleRptCode', 'tModalModuleRptName'],
            ColumnsSize: ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TSysReportModule.FTGrpRptModCode', 'TSysReportModule_L.FNGrpRptModName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TSysReportModule.FNGrpRptModShwSeq ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TSysReportModule_L.FTGrpRptModCode"],
            Text: [tInputReturnName, "TSysReportModule_L.FNGrpRptModName"],
        },
        NextFunc: {
            FuncName: tModuleNextFunc,
            ArgReturn: aModuleArgReturn
        },
    }
    return oOptionReturn;
}

//open brows
$('#obtSRTBrowseModuleRpt').click(function() {
    $('#odvSRTModalAddEditReportGrp').modal("hide");
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) != 'undefined' && nStaSession == 1) {
        window.oBrowseModuleReportOption = oBrowseModuleReport({
            'tReturnInputCode': 'oetSRTReportGrpModuleCode',
            'tReturnInputName': 'oetSRTReportGrpModuleName',
            'tNextFuncName': 'FSxSRTSetMaxSequenceAndGenCode',
            'aArgReturn': ['FTGrpRptModCode'],
        });
        JCNxBrowseData('oBrowseModuleReportOption');

    } else {
        JCNxShowMsgSessionExpired();
    }
});

//close brows
$(document).on('click', '#myModal .xCNBTNDefult2Btn', function() {
    JSxCheckPinMenuClose()
    if ($('#odvMenuList').val() == 3) {
        $('#odvSRTModalAddEditReportGrp').modal("show");
    } else if ($('#odvMenuList').val() == 4) {
        $('#odvSRTModalAddEditReportMenu').modal("show");
    }
});

//เมื่อคลิก สร้างอัตโนมัติ input disable
$("#ocbSRTRptGrpCode").click(function() {
    if ($('#ocbSRTRptGrpCode').is(':checked')) {
        $('#oetSRTRptGrpCode').prop('disabled', true);
        $('#oetSRTRptGrpCode').val('');
        $('#oetSRTRptGrpCode').parents('.form-group').removeClass("has-error");
    } else {
        $('#oetSRTRptGrpCode').prop('disabled', false);
    }
});

//Functionality: Gen Sequence And GenCode
//Parameters: จากการ ฺBrowse Module
//Creator: 19/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function FSxSRTSetMaxSequenceAndGenCode(tGmnRptModCode) {
    JSxCheckPinMenuClose()
    if (tGmnRptModCode == 'NULL') {
        $('#odvSRTModalAddEditReportGrp').modal("show");
    } else {
        oGmnRptModCode = JSON.parse(tGmnRptModCode)
        FSxSRTMaxSequenceAndGenCode('CallMaxValueSequenceRpt','TSysReportGrp', 'FTGrpRptModCode', 'FNGrpRptShwSeq', oGmnRptModCode[0],
            'FTGrpRptCode',
            function(
                tResult) {
                var aResult = JSON.parse(tResult);
                var tPattern = "000";
                if (aResult['aData'][0]['FTGrpRptCode'] == null || aResult['aData'][0]['FTGrpRptCode'] == '') {
                    nFieldCode = 0 + 1;
                } else {
                    nFieldCode = parseInt(aResult['aData'][0]['FTGrpRptCode']) + 1;
                }
                if (aResult['aData'][0]['FNGrpRptShwSeq'] == null || aResult['aData'][0]['FNGrpRptShwSeq'] == '') {
                    nMaxSeq = 0 + 1;
                } else {
                    nMaxSeq = parseInt(aResult['aData'][0]['FNGrpRptShwSeq']) + 1;
                }
                var tNewnFieldCode = oGmnRptModCode[0].concat((tPattern + nFieldCode).slice(-3));
                $('#oetSRTRptGrpCode').attr('data-RptGrpCode', tNewnFieldCode);
                $('#oetSRTRptGrpSeq').val(nMaxSeq);
                $('#ohdSeqMenuGrpRpt').val(nMaxSeq);
                $('#odvSRTModalAddEditReportGrp').modal("show");
            });
    }
}

//blur
$('#oetSRTRptGrpCode').blur(function() {
    aData = {
        tTableName: "TSysReportGrp",
        tFieldName: "FTGrpRptCode",
        tCode: $('#oetSRTRptGrpCode').val(),
    }
    JSoSRTCheckRptDupInDB(aData, function(
        tResult) {
        var aResult = JSON.parse(tResult);
        $("#ohdCheckDuplicateRptGrpCode").val(aResult["rtCode"]);
        aRules = {
            oetSRTRptGrpCode: {
                "required": {},
                "dublicateCode": {}
            },
        }
        aMessages = {
            oetSRTRptGrpCode: {
                "required": $('#oetSRTRptGrpCode').attr('data-validate-required'),
                "dublicateCode": $('#oetSRTRptGrpCode').attr('data-validate-dublicateCode'),
            },
        }
        JSxSRTSetValidEventBlur('ofmSRTAddEditReportGrp', aRules, aMessages,
            'ohdCheckDuplicateRptGrpCode');
        $('#ofmSRTAddEditReportGrp').submit();
    });
});

//Functionality: Modal DeleteMenuRpt Confirm
//Parameters: มาจากการคลิกลบกลุ่มเมนู
//Creator: 19/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: 
function JSxSRTMenuGrpDel(tMenuListCode, tMenuListName, tYesOrNo) {
    JSxCheckPinMenuClose()
    $('#odvSRTModalDelModuleReport').modal('show');
    $('#odvSRTModalDelModuleReport #ospConfirmDelete').html('<p><strong>' + $('#oetTextComfirmDeleteSingle').val() +
        tMenuListCode +
        ' ( ' +
        tMenuListName + ' ) ' + '</strong></p>');
    $('#ohdSRTConfirmIDDelete').val('SettingReportDelRptGrp');
    $('#osmSRTConfirm').val(tMenuListCode);
}
</script>