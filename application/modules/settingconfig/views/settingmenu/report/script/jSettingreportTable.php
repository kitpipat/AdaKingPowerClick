<script>
// //Functionality : Show Subtable
// //Parameters : -
// //Creator : 16/09/2020 Sooksanti(Non)
// //Last Update:
// //Return : 
// //Return Type :
function FSxSRTTableTree(nStatus, tCode, tClass1, tClass2) {
    var nMenuKey = tCode;
    if ($('#odvSRTSettingReport .' + tClass1 + '[data-mgm=' + nMenuKey + ']').hasClass(
            'hidden')) {
        $('#odvSRTSettingReport .' + tClass1 + '[data-mgm=' + nMenuKey + ']').removeClass(
            'hidden').slideDown(500);
        $('#odvSRTSettingReport .' + tClass2 + '[data-mgm=' + nMenuKey + ']').removeClass(
            'fa fa-plus');
        $('#odvSRTSettingReport .' + tClass2 + '[data-mgm=' + nMenuKey + ']').addClass(
            'fa fa-minus');
    } else {
        $('#odvSRTSettingReport .' + tClass1 + '[data-mgm=' + nMenuKey + ']').slideUp(100,
            function() {
                $(this).addClass('hidden');
                if (nStatus === 1) {
                    $('#odvSRTSettingReport .xCNDataRole[data-mgm=' + nMenuKey + ']').addClass(
                        'hidden');
                    $('#odvSRTSettingReport .xCNDataRole[data-smc=' + nMenuKey + ']').addClass(
                        'hidden');
                    $('#odvSRTSettingReport .xCNPlusReportGrp[data-smc=' + nMenuKey + ']').removeClass(
                        'fa fa-minus');
                    $('#odvSRTSettingReport .xCNPlusReportGrp[data-smc=' + nMenuKey + ']').addClass(
                        'fa fa-plus');
                    $('#odvSRTSettingReport .xCNPlusReportGrp[data-mgm=' + nMenuKey + ']').removeClass(
                        'fa fa-minus');
                    $('#odvSRTSettingReport .xCNPlusReportGrp[data-mgm=' + nMenuKey + ']').addClass(
                        'fa fa-plus');
                }
                $('#odvSRTSettingReport .' + tClass2 + '[data-mgm=' + nMenuKey + ']')
                    .removeClass('fa fa-minus');
                $('#odvSRTSettingReport .' + tClass2 + '[data-mgm=' + nMenuKey + ']')
                    .addClass('fa fa-plus');
            });
    }
}

//Search MenuRpt
    $("#otbSRTModuleReport #oetRSTSearchAll").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#otbSRTDataBody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

//add modulereport modal
$('#othSRTAddModuleReport').click(function() {
    JSxCheckPinMenuClose()
    JSxSRTClearValidateModule();
    FSxSRTMaxSequenceAndGenCode('CallMaxValueSequenceRpt','TSysReportModule', '', 'FNGrpRptModShwSeq', '', 'FTGrpRptModCode', function(
        tResult) {
        var aResult = JSON.parse(tResult);
        var tPattern = "000";
        if(aResult['aData'][0]['FTGrpRptModCode'] == null || aResult['aData'][0]['FTGrpRptModCode'] == ''){
            nFieldCode = 0 + 1;
        }else{
            nFieldCode = parseInt(aResult['aData'][0]['FTGrpRptModCode']) + 1;
        }
        if(aResult['aData'][0]['FNGrpRptModShwSeq'] == null || aResult['aData'][0]['FNGrpRptModShwSeq'] == ''){
            nMaxSeq = 0 + 1;
        }else{
            nMaxSeq = parseInt(aResult['aData'][0]['FNGrpRptModShwSeq']) + 1;
        }
        var tNewnFieldCode = (tPattern + nFieldCode).slice(-3);
        $('#ocbSRTRptModCode').attr('data-RptModCode', tNewnFieldCode);
        $('#oetSRTModuleSeq').val(nMaxSeq);
        $('#ohdSeqModuleRpt').val(nMaxSeq);
        $('#odvSRTModalAddEditModuleReport').modal('show');
        $('#odvSRTRptModCode').show();
        $('#ocbSRTRptModCode').prop('checked', true)
        if ($('#ocbSRTRptModCode').is(':checked')) {
            $('#oetSRTModuleRptCode').prop('disabled', true);
        } else {
            $('#oetSRTModuleRptCode').prop('disabled', false);
        }
    });
});


//Functionality: Clear Validate Modal Module Report
//Parameters: -
//Creator: 16/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSRTClearValidateModule() {
    $('#oetSRTModuleRptCode').parents('.form-group').removeClass("has-error");
    $('#oetSRTModuleRptCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    
    $('#oetSRTModuleName').parents('.form-group').removeClass("has-error");
    $('#oetSRTModuleName').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    
    $('#oetSRTModuleSeq').parents('.form-group').removeClass("has-error");
    $('#oetSRTModuleSeq').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    $('#oetSRTModuleRptCode').val('');
    $('#oetSRTModuleName').val('');
    $('#oetSRTModuleUrl').val('');
}


//open add GrpReport modal
$('#othSRTAddReportGrp').click(function() {
    JSxCheckPinMenuClose()
    $('#odvSRTModalAddEditReportGrp').modal('show');
    $('#odvMenuList').val(3);
    $('#ocbSRTRptGrpCode').prop('checked', true)
    if ($('#ocbSRTRptGrpCode').is(':checked')) {
        $('#oetSRTRptGrpCode').prop('disabled', true);
    } else {
        $('#oetSRTRptGrpCode').prop('disabled', false);
    }
    JSxSRTClearValidateGrp();
    
    $('#odvSRTRptGrpCode').show();
});

//Functionality: Clear Validate Modal Module
//Parameters: -
//Creator: 16/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSRTClearValidateGrp() {
    
    $('#oetSRTReportGrpModuleCode').parents('.form-group').removeClass("has-error");
    $('#oetSRTReportGrpModuleCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    
    $('#oetSRTReportGrpModuleName').parents('.form-group').removeClass("has-error");
    $('#oetSRTReportGrpModuleName').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    
    $('#oetSRTRptGrpCode').parents('.form-group').removeClass("has-error");
    $('#oetSRTRptGrpCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();

    $('#oetSRTRptGrpName').parents('.form-group').removeClass("has-error");
    $('#oetSRTRptGrpName').parents('.form-group').find(".help-block").fadeOut('slow').remove();

    $('#oetSRTRptGrpSeq').parents('.form-group').removeClass("has-error");
    $('#oetSRTRptGrpSeq').parents('.form-group').find(".help-block").fadeOut('slow').remove();

    $('#oetSRTReportGrpModuleCode').val('');
    $('#oetSRTReportGrpModuleName').val('');
    $('#oetSRTRptGrpCode').val('');
    $('#oetSRTRptGrpName').val('');
    $('#oetSRTRptGrpSeq').val('');
    $('#ohdSeqMenuGrpRpt').val('');

}

//open add GmenuReport modal
$('#othSRTAddReportList').click(function() {
    JSxCheckPinMenuClose()
    $('#odvSRTModalAddEditReportMenu').modal('show');
    $('#ocbSRTRptMenuCode').prop('checked', true)
    if ($('#ocbSRTRptMenuCode').is(':checked')) {
        $('#oetSRTRptMenuCode').prop('disabled', true);
    } else {
        $('#oetSRTRptMenuCode').prop('disabled', false);
    }
    $('#odvMenuList').val(4);
    JSxSRTClearValidateMenuRpt();
    $('#odvSRTRptMenuCode').show();
});


//Functionality: Clear Validate Modal Menu
//Parameters: -
//Creator: 16/09/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSRTClearValidateMenuRpt() {
    
    $('#oetSRTReportGrpModMenuName').parents('.form-group').removeClass("has-error");
    $('#oetSRTReportGrpModMenuName').parents('.form-group').find(".help-block").fadeOut('slow').remove();

    $('#oetSRTReportMenuGrpName').parents('.form-group').removeClass("has-error");
    $('#oetSRTReportMenuGrpName').parents('.form-group').find(".help-block").fadeOut('slow').remove();

    $('#oetSRTRptMenuCode').parents('.form-group').removeClass("has-error");
    $('#oetSRTRptMenuCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();

    $('#oetSRTRptMenuCode').parents('.form-group').removeClass("has-error");
    $('#oetSRTRptMenuCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();

    $('#oetSRTRptMenuName').parents('.form-group').removeClass("has-error");
    $('#oetSRTRptMenuName').parents('.form-group').find(".help-block").fadeOut('slow').remove();

    $('#oetSRTRptMenuSeq').parents('.form-group').removeClass("has-error");
    $('#oetSRTRptMenuSeq').parents('.form-group').find(".help-block").fadeOut('slow').remove();

    $('#oetSRTReportGrpModMenuCode').val('');
    $('#oetSRTReportGrpModMenuName').val('');

    $('#oetSRTReportMenuGrpCode').val('');
    $('#oetSRTReportMenuGrpName').val('');

    $('#oetSRTRptMenuCode').val('');
    $('#oetSRTRptMenuName').val('');
    $('#oetSRTRptMenuSeq').val('');
    $('#ohdSeqRptList').val('');
    $('#oetSRTRptMenuUrl').val('');
    $('#oetSRTReportMenuFilterCode').val('');
    $('#oetSRTReportMenuFilterName').val('');
    $('#odvFilterShow').html('');
}

//Functionality: Call Max sequence And GenCode
//Parameters: from function
//Creator: 15/09/2020 Sooksanti(Non)
//Return: - 
//ReturnType: - 
function FSxSRTMaxSequenceAndGenCode(tRoute,tTableName, tFieldWhere, tFieldSeq, tCode, tFieldCode, callBack) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: tRoute,
                data: {
                    tTableName: tTableName,
                    tFieldWhere: tFieldWhere,
                    tFieldSeq: tFieldSeq,
                    tCode: tCode,
                    tFieldCode: tFieldCode
                },
                async: true,
                success: function(tResult) {
                    JCNxCloseLoading();
                    return callBack(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('FSxSRTMaxSequenceAndGenCode Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Delete Module ลบโมดูล 
//Parameters: tRout ส่งมาจากการคลิก osmSRTConfirm
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: 
function JSxSRTDelChoose(tRout) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $.ajax({
            type: "POST",
            url: tRout,
            data: {
                tCode: $('#osmSRTConfirm').val(),
            },
            async: false,
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aResult = JSON.parse(tResult);
                console.log(aResult);
                if (aResult['nStaEvent'] = 1) {
                    $('#odvSRTModalDelModuleReport').modal('hide');
                    $('.modal-backdrop').remove();
                    JSxSMUSettingReportCallPage();
                    JSxSMUSettingMenuCallPage();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Add Or Edit Report
//Parameters: Function Parameter
//Creator: 18/09/2020 Sooksanti(Non)
//Return: Ajax Success
//ReturnType: Text
function JSoSRTAddEditRpt(tForm, aRules, aMessages, oOhdCheckDup, tRoute, aData, oCallBack) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
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
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: tRoute,
                    data: aData,
                    async: false,
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        return oCallBack(tResult)
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
</script>