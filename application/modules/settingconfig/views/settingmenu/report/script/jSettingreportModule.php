<script>
//Functionality: Call Modal edit Module Report
//Parameters: Function Parameter
//Creator: 18/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSRTCallModalEditModulRpt(tCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: 'SettingReportCallEditModuleRpt',
                data: {
                    tCode: tCode,
                },
                async: true,
                success: function(tResult) {
                    JSxCheckPinMenuClose()
                    JCNxCloseLoading();
                    var aResult = JSON.parse(tResult);
                    $('#odvSRTRptModCode').hide();
                    $('#odvSRTModalAddEditModuleReport').modal('show');
                    $('#oetSRTModuleRptCode').val(aResult['raItems'][0]['FTGrpRptModCode']);
                    $('#oetSRTModuleName').val(aResult['raItems'][0]['FNGrpRptModName']);
                    $('#oetSRTModuleUrl').val(aResult['raItems'][0]['FTGrpRptModRoute']);
                    $('#oetSRTModuleSeq').val(aResult['raItems'][0]['FNGrpRptModShwSeq']);
                    $('#ohdSeqModuleRpt').val(aResult['raItems'][0]['FNGrpRptModShwSeq']);
                    $('#oetSRTModuleRptCode').prop('disabled', true);
                    $('#ocbSRTRptModCode').attr('data-RptModCode', aResult['raItems'][0][
                        'FTGrpRptModCode'
                    ]);
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

//Submit Add Update
$("#obtSRTModalSubmit").click(function() {
    var tForm = 'ofmSRTAddEditModuleReport';
    var tRoute = 'SettingReportAddUpdateModule';
    var aRules = {
        oetSRTModuleRptCode: {
            "required": {
                depends: function(oElement) {
                    if ($('#oetSRTModuleRptCode').is(':disabled')) {
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            "dublicateCode": {}
        },
        oetSRTModuleName: {
            "required": {}
        },
        oetSRTModuleSeq: {
            "required": {}
        }
    }
    var aMessages = {
        oetSRTModuleRptCode: {
            "required": $('#oetSRTModuleRptCode').attr('data-validate-required'),
            "dublicateCode": $('#oetSRTModuleRptCode').attr('data-validate-dublicateCode'),
        },
        oetSRTModuleName: {
            "required": $('#oetSRTModuleName').attr('data-validate-required'),
        },
        oetSRTModuleSeq: {
            "required": $('#oetSRTModuleName').attr('data-validate-required'),
        },
    }
    var oOhdCheckDup = 'ohdCheckDuplicateModuleRptCode';
    if ($('#ocbSRTRptModCode').is(':checked')) {
        tRptModCode = $('#ocbSRTRptModCode').attr('data-RptModCode');
    } else {
        tRptModCode = $('#ocbSRTRptModCode').val();
    }

    JSxSMUCheckDupSeq('TSysReportModule', '', '',tRptModCode, 
        $("#oetSRTModuleSeq").val(), 'RptMod');

    if ($('#ohdModuleCodeRpt').val() != '') {
        tTableName = 'TSysReportModule';
        tFieldWhere = 'FTGrpRptModCode';
        tFieldSeqName = 'FNGrpRptModShwSeq';
        tSeqAfter = $('#ohdSeqModuleRpt').val();
        tCode = $("#ohdModuleCodeRpt").val();
    } else {
        tTableName = '';
        tFieldWhere = '';
        tFieldSeqName = '';
        tSeqAfter = '';
        tCode = '';
    }

    var aData = {
        tRptModCode: tRptModCode,
        tRptModName: $('#oetSRTModuleName').val(),
        tRptModShwSeq: $("#oetSRTModuleSeq").val(),
        tRptModUrl: $("#oetSRTModuleUrl").val(),

        tTableName: tTableName,
        tFieldWhere: tFieldWhere,
        tFieldSeqName: tFieldSeqName,
        tSeqAfter: tSeqAfter,
        tCode: tCode,
    }


    JSoSRTAddEditRpt(tForm, aRules, aMessages, oOhdCheckDup, tRoute, aData, function(tResult) {

        var aResult = JSON.parse(tResult);
        if (aResult["nStaEvent"] = 1) {
            $('#odvSRTModalAddEditModuleReport').modal("hide");
            JSxSMUSettingReportCallPage();
            JSxSMUSettingMenuCallPage();
        }
    });
});

//เมื่อคลิก สร้างอัตโนมัติ input disable
$("#odvSRTRptModCode").click(function() {
    if ($('#ocbSRTRptModCode').is(':checked')) {
        $('#oetSRTModuleRptCode').prop('disabled', true);
        $('#oetSRTModuleRptCode').val('');
        $('#oetSRTModuleRptCode').parents('.form-group').removeClass("has-error");
    } else {
        $('#oetSRTModuleRptCode').prop('disabled', false);
    }
});

//Functionality: Event Check ModuleReport Duplicate
//Parameters:-
//Creator: 16/09/2020  Sooksanti(Non)
//Return: -
//ReturnType: -
function JSoSRTCheckRptDupInDB(aData, oCallBack) {
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: aData,
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            return oCallBack(tResult);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//blur เช็ค รหัสโมดูลซ้ำหรือไม่
$('#oetSRTModuleRptCode').blur(function() {
    aData = {
        tTableName: "TSysReportModule",
        tFieldName: "FTGrpRptModCode",
        tCode: $('#oetSRTModuleRptCode').val(),
    }
    JSoSRTCheckRptDupInDB(aData, function(
        tResult) {
        var aResult = JSON.parse(tResult);
        $("#ohdCheckDuplicateModuleRptCode").val(aResult["rtCode"]);
        aRules = {
            oetSRTModuleRptCode: {
                "required": {},
                "dublicateCode": {}
            },
        }
        aMessages = {
            oetSRTModuleRptCode: {
                "required": $('#oetSRTModuleRptCode').attr('data-validate-required'),
                "dublicateCode": $('#oetSRTModuleRptCode').attr('data-validate-dublicateCode'),
            },
        }
        JSxSRTSetValidEventBlur('ofmSRTAddEditModuleReport', aRules, aMessages,
            'ohdCheckDuplicateModuleRptCode');
        $('#ofmSRTAddEditModuleReport').submit();
    });
});

//Functionality: Set Validate Event Blur
//Parameters: Validate Event Blur
//Creator: 16/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSRTSetValidEventBlur(tForm, aRules, aMessages, oOhdCheckDup) {
    $('#' + tForm).validate().destroy();
    $.validator.addMethod('dublicateCode', function(value, element) {
        if ($('#' + oOhdCheckDup).val() == 1) {
            return false;
        } else {
            return true;
        }
    }, '');

    // From Summit Validate
    $('#' + tForm).validate({
        rules: aRules,
        messages: aMessages,
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
        submitHandler: function(form) {}
    });
}

//Functionality: Modal DeleteMenuRpt Confirm
//Parameters: มาจากการคลิกลบกลุ่มเมนู
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: 
function JSxSRTModuleDel(tMenuListCode, tMenuListName, tYesOrNo) {
    JSxCheckPinMenuClose()
    $('#odvSRTModalDelModuleReport').modal('show');
    $('#odvSRTModalDelModuleReport #ospConfirmDelete').html('<p><strong>' + $('#oetTextComfirmDeleteSingle').val() +
        tMenuListCode +
        ' ( ' +
        tMenuListName + ' ) ' + '</strong></p>');
    $('#ohdSRTConfirmIDDelete').val('SettingReportDelModule');
    $('#osmSRTConfirm').val(tMenuListCode);
}

//confirm delete
$('#osmSRTConfirm').click(function() {
    JSxSRTDelChoose($('#ohdSRTConfirmIDDelete').val())
});
</script>