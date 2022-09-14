<script>


//Open Modal Module
$('#othSMPAddModule').click(function() {
    JSxCheckPinMenuClose()
    $("#ofmSMPModalModul").trigger("reset");
    JSxSMUClearValidateModule();
    FSxSMUMaxSequence('TSysMenuGrpModule','','FNGmnModShwSeq','')
    $('#oetSMPModuleSeq').val(nMaxsequence+1);
    $('#ohdSeqModule').val(nMaxsequence+1);
    $('#oetSMPModuleCode').prop('disabled', false);
    $('#oetSMPModulePathIcon').val('');
    $('#oetSMPModuleCode').val('');
    $('#oetSMPModuleName').val('');
    $('#obtSMPModalSubmit').val('SettingMenuEditModule');
    $('#odvSMPModalAddEditModule').modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#odvSMPModalAddEditModule').modal("show");
});

//Functionality: Clear Validate Modal Module
//Parameters: -
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSMUClearValidateModule() {
    // Clear Validate Modulecode Input
    $('#oetSMPModuleCode').parents('.form-group').removeClass("has-error");
    $('#oetSMPModuleCode').parents('.form-group').removeClass("has-success");
    $('#oetSMPModuleCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    // Clear Validate Modulename Input
    $('#oetSMPModuleName').parents('.form-group').removeClass("has-error");
    $('#oetSMPModuleName').parents('.form-group').removeClass("has-success");
    $('#oetSMPModuleName').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    // Clear Validate Seq Input
    $('#oetSMPModuleSeq').parents('.form-group').removeClass("has-error");
    $('#oetSMPModuleSeq').parents('.form-group').removeClass("has-success");
    $('#oetSMPModuleSeq').parents('.form-group').find(".help-block").fadeOut('slow').remove();
}


//Functionality: Event Check Module Duplicate
//Parameters:-
//Creator: 20/08/2020  Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSMUCheckModuleCodeDupInDB() {
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            tTableName: "TSysMenuGrpModule",
            tFieldName: "FTGmnModCode",
            tCode: $("#oetSMPModuleCode").val(),
        },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var aResult = JSON.parse(tResult);
            $("#ohdCheckDuplicateModuleCode").val(aResult["rtCode"]);
            JSxSMUModuleSetValidEventBlur();
            $('#ofmSMPAddEditModule').submit();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

$('#oetSMPModuleCode').blur(function() {
    JSxSMUCheckModuleCodeDupInDB();
});


//Functionality: Set Validate Event Blur
//Parameters: -
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSMUModuleSetValidEventBlur() {
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
        },
        messages: {
            oetSMPModuleCode: {
                "required": $('#oetSMPModuleCode').attr('data-validate-required'),
                "dublicateCode": $('#oetSMPModuleCode').attr('data-validate-dublicateCode'),
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
        submitHandler: function(form) {}
    });
}

//Functionality: Cancel Modal
//Parameters: -
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSMUSMPCancelModal() {
    JSxCheckPinMenuClose()
    $('#odvSMPModalAddEditModule').modal("hide");
}


//Submit
$("#obtSMPModalSubmit").click(function() {
    JSxSMUAddEditModule();
});


//Functionality: Call Data Edit Modules
//Parameters: ModCode ส่งมาจากการคลิกปุ่มแก้ไข
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSMUCallModalModulEdit(tModCode) {
    $.ajax({
        type: "POST",
        url: "CallModalModulEdit",
        data: {
            tModCode: tModCode,
        },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            JSxCheckPinMenuClose()
            var aResult = JSON.parse(tResult);
            if (aResult['rtCode'] = 1) {
                $('#odvSMPModalAddEditModule').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                JSxSMUClearValidateModule();
                $('#odvSMPModalAddEditModule').modal("show");
                $('#oetSMPModuleCode').prop('disabled', true);
                $('#oetSMPModuleCode').val(aResult['raItems'][0]['FTGmnModCode']);
                $('#oetSMPModuleName').val(aResult['raItems'][0]['FTGmnModName']);
                $('#oetSMPModuleSeq').val(aResult['raItems'][0]['FNGmnModShwSeq']);
                $('#ohdSeqModule').val(aResult['raItems'][0]['FNGmnModShwSeq']);
                $('#oetSMPModulePathIcon').val(aResult['raItems'][0]['FTGmmModPathIcon']);
                $('#obtSMPModalSubmit').val('SettingMenuEditModule');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality: Modal Delete Confirm แสดง modal ยืนยันการลบ
//Parameters: -
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: 
function JSxSMUModuleDel(tModuleCode, tModuleName, tYesOrNo) {
    JSxCheckPinMenuClose()
    $('#odvSMPModalDelModule').modal('show');
    $('#odvSMPModalDelModule #ospConfirmDelete').html('<p><strong>'+$('#oetTextComfirmDeleteSingle').val() + tModuleCode +
                ' ( ' +
                tModuleName + ' ) ' +'</strong></p>');
    $('#ohdConfirmIDDelete').val('SettingMenuDelModule');
    $('#osmConfirm').val(tModuleCode);
}



//confirm delete
$('#osmConfirm').click(function() {
    JSxSMUDelChoose($('#ohdConfirmIDDelete').val())
});


//Functionality: Delete Module ลบโมดูล 
//Parameters: tRout ส่งมาจากการคลิก osmConfirm
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: 
function JSxSMUDelChoose(tRout) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $.ajax({
            type: "POST",
            url: tRout,
            data: {
                tCode: $('#osmConfirm').val(),
            },
            async: false,
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aResult = JSON.parse(tResult);
                var tCodeRpt = $('#osmConfirm').val().substring(0, 3)
                console.log(aResult);
                if (aResult['nStaEvent'] = 1) {
                    $('#odvSMPModalDelModule').modal('hide');
                    JSxSMUSettingMenuCallPage()
                    if(tCodeRpt =='RPT'){
                        JSxSMUSettingReportCallPage()
                    }
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
</script>