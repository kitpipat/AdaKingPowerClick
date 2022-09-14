<script>
//open BrowseModule
$('#oimSMPBrowseModule').click(function() {
    $('#odvSMPModalAddEditMenuGrp').modal("hide");
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) != 'undefined' && nStaSession == 1) {
        window.oSMPBrowseModule = oBrowseModule({
            'tReturnInputCode': 'oetSMPMenuGrpModuleCode',
            'tReturnInputName': 'oetSMPMenuGrpModuleName',
        });
        JCNxBrowseData('oSMPBrowseModule');

    } else {
        JCNxShowMsgSessionExpired();
    }
});

//Browse Module
var nLangEdits = '<?=$this->session->userdata("tLangEdit")?>';
var oBrowseModule = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;

    var oSMPBrowseModule = {
        Title: ['settingconfig/settingmenu/settingmenu', 'tSettingMenuModule'],
        Table: {
            Master: 'TSysMenuGrpModule',
            PK: 'FTGmnModCode'
        },
        Join: {
            Table: ['TSysMenuGrpModule_L'],
            On: ['TSysMenuGrpModule.FTGmnModCode = TSysMenuGrpModule_L.FTGmnModCode AND TSysMenuGrpModule_L.FNLngID =' +
                nLangEdits
            ]
        },
        Where: {
            Condition: ["AND TSysMenuGrpModule_L.FTGmnModCode IS NOT NULL"]
        },
        GrideView: {
            ColumnPathLang: 'settingconfig/settingmenu/settingmenu',
            ColumnKeyLang: ['tModalModuleCode', 'tModalModuleName'],
            ColumnsSize: ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TSysMenuGrpModule.FTGmnModCode', 'TSysMenuGrpModule_L.FTGmnModName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TSysMenuGrpModule.FNGmnModShwSeq ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TSysMenuGrpModule_L.FTGmnModCode"],
            Text: [tInputReturnName, "TSysMenuGrpModule_L.FTGmnModName"],
        },
        NextFunc: {
            FuncName: 'FSxSMUSetMaxSequenceModule',
            ArgReturn: ['FTGmnModCode']
        },
    }
    return oSMPBrowseModule;
}

//close //Browse Module
$(document).on('click', '#myModal .xCNBTNDefult2Btn', function() {
    if ($('#odvMenuList').val() == 2) {
        JSxCheckPinMenuClose()
        $('#odvSMPModalAddEditMenuGrp').modal("show");
    }
});


//Functionality: Gen ค่าลำดับโมดูล
//Parameters: จากการ ฺBrowse Module
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function FSxSMUSetMaxSequenceModule(tGmnModCode) {
    JSxCheckPinMenuClose()
    if (tGmnModCode == 'NULL') {
        if ($('#odvMenuList').val() == 2) {
                $('#odvSMPModalAddEditMenuGrp').modal("show");
        }
        else if ($('#odvMenuList').val() == 1) {
            $('#odvSMPModalAddEditMenuList').modal("show");
            $('#oetSMPMenuListMenuGrpCode').val('');
            $('#oetSMPMenuListMenuGrpName').val('');
        }
    } else {
        oGmnModCode = JSON.parse(tGmnModCode)
        if ($('#odvMenuList').val() == 2) {
            if ($("#oetSMPMenuGrpModuleCode").data("menugrp") != oGmnModCode[0]) {
                FSxSMUMaxSequence('TSysMenuGrp', 'FTGmnModCode', 'FNGmnShwSeq', oGmnModCode[0])
                $('#oetSMPMenuGrpSeq').val(nMaxsequence + 1);
                $('#ohdSeqMenuGrp').val(nMaxsequence + 1);
                $('#odvSMPModalAddEditMenuGrp').modal("show");
            } else {
                $('#oetSMPMenuGrpSeq').val($("#oetSMPMenuGrpSeq").data("menuseq"));
                $('#ohdSeqMenuGrp').val($("#oetSMPMenuGrpSeq").data("menuseq"));
                $('#odvSMPModalAddEditMenuGrp').modal("show");
            }

        }
        if ($('#odvMenuList').val() == 1) {
            FSxSMUMaxSequence('TSysMenuList', 'FTGmnModCode', 'FNMnuSeq', oGmnModCode[0])
            $('#oetSMPMenuListMenuGrpCode').val('');
            $('#oetSMPMenuListMenuGrpName').val('');
            $('#oetSMPMenuListSeq').val(nMaxsequence + 1);
            $('#ohdSeqMenuList').val(nMaxsequence + 1);
            $('#odvSMPModalAddEditMenuList').modal("show");
        }
    }
}

//open ModalMenuGrp
$('#othSMPAddMenuGrp').click(function() {
    JSxCheckPinMenuClose()
    $('#odvMenuList').val(2);
    JSxSMUClearValidateMenuGrp()
    $('#odvSMPModalAddEditMenuGrp').modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#odvSMPModalAddEditMenuGrp').modal("show");
});


//Functionality: Clear Validate ModalMenuGrp
//Parameters: -
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSMUClearValidateMenuGrp() {
    $('#oetSMPMenuGrpCode').prop('disabled', false);
    $('#oetSMPMenuGrpModuleCode').val('')
    $('#oetSMPMenuGrpModuleName').val('')
    $('#oetSMPMenuGrpCode').val('')
    $('#oetSMPMenuGrpName').val('')
    $('#oetSMPMenuGrpName').val('')
    $('#oetSMPMenuGrpSeq').val('')
    $('#ohdSeqMenuGrp').val('')
    // Clear Validate MenuGrpCode Input
    $('#oetSMPMenuGrpCode').parents('.form-group').removeClass("has-error");
    $('#oetSMPMenuGrpCode').parents('.form-group').removeClass("has-success");
    $('#oetSMPMenuGrpCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    // Clear Validate MenuGrpName Input
    $('#oetSMPMenuGrpName').parents('.form-group').removeClass("has-error");
    $('#oetSMPMenuGrpName').parents('.form-group').removeClass("has-success");
    $('#oetSMPMenuGrpName').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    // Clear Validate MenuGrpSeq Input
    $('#oetSMPMenuGrpSeq').parents('.form-group').removeClass("has-error");
    $('#oetSMPMenuGrpSeq').parents('.form-group').removeClass("has-success");
    $('#oetSMPMenuGrpSeq').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    // Clear Validate Modulename Input
    $('#oetSMPMenuGrpModuleName').parents('.form-group').removeClass("has-error");
    $('#oetSMPMenuGrpModuleName').parents('.form-group').removeClass("has-success");
    $('#oetSMPMenuGrpModuleName').parents('.form-group').find(".help-block").fadeOut('slow').remove()
}


//Event (Blur) check duplicate
$('#oetSMPMenuGrpCode').blur(function() {
    JSxSMUCheckMenuGrpCodeDupInDB();
});


//Functionality: Event Check MenuGrp Duplicate
//Parameters:-
//Creator: 20/08/2020  Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSMUCheckMenuGrpCodeDupInDB() {
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            tTableName: "TSysMenuGrp",
            tFieldName: "FTGmnCode",
            tCode: $("#oetSMPMenuGrpCode").val(),
        },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var aResult = JSON.parse(tResult);
            $("#ohdCheckDuplicateMenuGrpCode").val(aResult["rtCode"]);
            JSxSMUMenuGrpSetValidEventBlur();
            $('#ofmSMPAddEditMenuGrp').submit();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality: Set Validate Event Blur
//Parameters: -
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSMUMenuGrpSetValidEventBlur() {
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
        },
        messages: {
            oetSMPMenuGrpCode: {
                "required": $('#oetSMPMenuGrpCode').attr('data-validate-required'),
                "dublicateCode": $('#oetSMPMenuGrpCode').attr('data-validate-dublicateCode'),
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

//Submit 
$("#obtSMPModalMenuGrpSubmit").click(function() {
    JSxSMUAddEditMenuGrp();
});


//Functionality: Call Modal EditMenuGrp
//Parameters: -
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: 
function JSxSMUCallModalMenuGrpEdit(tMenuGrpCode, tModuleName) {
    $.ajax({
        type: "POST",
        url: "CallModalMenuGrpEdit",
        data: {
            tMenuGrpCode: tMenuGrpCode,
        },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            JSxCheckPinMenuClose()
            var aResult = JSON.parse(tResult);
            $('#odvMenuList').val(2);
            if (aResult['rtCode'] == '1') {
                $('#odvSMPModalAddEditMenuGrp').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                JSxSMUClearValidateModule();
                $('#odvSMPModalAddEditMenuGrp').modal("show");
                $('#oetSMPMenuGrpCode').prop('disabled', true);
                $('#oetSMPMenuGrpCode').val(aResult['raItems'][0]['FTGmnCode']);
                $("#oetSMPMenuGrpModuleCode").data("menugrp", aResult['raItems'][0]['FTGmnModCode'])
                $("#oetSMPMenuGrpSeq").data("menuseq", aResult['raItems'][0]['FNGmnShwSeq'])
                $('#oetSMPMenuGrpName').val(aResult['raItems'][0]['FTGmnName']);
                $('#oetSMPMenuGrpModuleCode').val(aResult['raItems'][0]['FTGmnModCode']);
                $('#oetSMPMenuGrpModuleName').val(tModuleName);
                $('#oetSMPMenuGrpSeq').val(aResult['raItems'][0]['FNGmnShwSeq']);
                $('#ohdSeqMenuGrp').val(aResult['raItems'][0]['FNGmnShwSeq'])
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Modal DeleteMenuGrp Confirm
//Parameters: -
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: 
function JSxSMUMenuGrpDel(tMenuGrpCode, tMenuGrpName, tYesOrNo) {
    JSxCheckPinMenuClose()
    $('#odvSMPModalDelModule').modal('show');
    $('#odvSMPModalDelModule #ospConfirmDelete').html('<p><strong>' + $('#oetTextComfirmDeleteSingle').val() +
        tMenuGrpCode +
        ' ( ' +
        tMenuGrpName + ' ) ' + '</strong></p>');
    $('#ohdConfirmIDDelete').val('SettingMenuDelMenuGrp');
    $('#osmConfirm').val(tMenuGrpCode);
}
</script>