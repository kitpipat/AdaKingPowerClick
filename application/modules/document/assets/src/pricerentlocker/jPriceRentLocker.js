var nStaPriRntLkBrowseType  = $("#oetPriRntLkStaBrowse").val();
var tCallPriRntLkBackOption = $("#oetPriRntLkCallBackOption").val();

$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    /*Check เปิดปิด Menu ตาม Pin*/
    JSxCheckPinMenuClose();

    if(typeof(nStaPriRntLkBrowseType) != 'undefined' && nStaPriRntLkBrowseType == 0){
        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliPriRntLkTitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPriRntLkCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtPriRntLkCallPageAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPriRntLkCallPageAdd();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Call Back Page
        $('#obtPriRntLkCallBackPage').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPriRntLkCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From 
        $('#obtPriRntLkSubmitFromDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxPriRntLkSetStatusClickSubmit(1);
                $('#obtPriRntLkSubmit').click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JSxPriRntLkNavDefult();
        JSvPriRntLkCallPageList();
    }else{
        // Event Modal Call Back Before List
        $('#oahPriRntLkBrowseCallBack').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tCallPriRntLkBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Modal Call Back Previous
        $('#oliPriRntLkBrowsePrevious').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tCallPriRntLkBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtPriRntLkBrowseSubmit').unbind().click(function () {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxPriRntLkSetStatusClickSubmit(1);
                $('#obtPriRntLkSubmit').click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JSxPriRntLkNavDefult();
        JSvPriRntLkCallPageAdd();
    }
});

// Function: Set Defult Nav Menu 
// Parameters: Document Ready Or Parameter Event
// Creator: 05/07/2019 wasin (AKA: MR.JW)
// LastUpdate:
// Return: Set Default Nav Menu Document
// ReturnType: -
function JSxPriRntLkNavDefult(){
    if(typeof(nStaPriRntLkBrowseType) != 'undefined' && nStaPriRntLkBrowseType == 0) {
        $('.xCNChoose').hide();
        $('#oliPriRntLkTitleAdd').hide();
        $('#oliPriRntLkTitleEdit').hide();
        $('#oliPriRntLkTitleDetail').hide();
        $('#odvPriRntLkBtnGrpAddEdit').hide();
        $('#odvPriRntLkBtnGrpInfo').show();
    }else{
        $('#odvModalBody #odvPriRntLkMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPriRntLkNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPriRntLkBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPriRntLkBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPriRntLkBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 05/07/2019 wasin (AKA: MR.JW)
// LastUpdate:
// Return: Call View Tranfer Out List
// ReturnType: View
function JSvPriRntLkCallPageList(){
    $.ajax({
        type: "GET",
        url: "dcmPriRntLkFormSearchList",
        cache: false,
        timeout: 0,
        success: function (tResult){
            $("#odvPriRntLkContentPage").html(tResult);
            JSxPriRntLkNavDefult();
            JSvPriRntLkCallPageDataTable();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });  
}

// Function: Call Page Data Table
// Parameters: Document Redy Function
// Creator: 05/07/2019 wasin (AKA: MR.JW)
// LastUpdate:
// Return: Call View Tabel Data List Document
// ReturnType: View
function JSvPriRntLkCallPageDataTable(pnPage){
    JCNxOpenLoading();
    var nPageCurrent = pnPage;
    if(typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    var tSearchAll = $('#oetPriRntLkSearchAll').val();
    $.ajax({
        type: "POST",
        url: "dcmPriRntLkDataTable",
        data: {
            'ptSearchAll'   : tSearchAll,
            'pnPageCurrent' : nPageCurrent,
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1'){
                JSxPriRntLkNavDefult();
                $('#ostPriRntLkDataTableDocument').html(aReturnData['tPIViewDataTableList']);
            }else{
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 05/07/2019 wasin (AKA: MR.JW)
//Return: Show Button Delete All
//Return Type: -
function JSxPriRntLkShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliPriRntLkBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliPriRntLkBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliPriRntLkBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 05/07/2019 wasin (AKA: MR.JW)
//Return: Insert Code In Text Input
//Return Type: -
function JSxPriRntLkTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") { } else {
        var tTextCode = "";
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += " , ";
        }

        //Disabled ปุ่ม Delete
        if (aArrayConvert[0].length > 1) {
            $(".xCNIconDel").addClass("xCNDisabled");
        } else {
            $(".xCNIconDel").removeClass("xCNDisabled");
        }
        $("#odvPriRntLkModalDelDocMultiple #ospTextConfirmDelMultiple").text($('#oetTextComfirmDeleteMulti').val());
        $("#odvPriRntLkModalDelDocMultiple #ohdConfirmIDDelMultiple").val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 05/07/2019 wasin (AKA: MR.JW)
//Return: Duplicate/none
//Return Type: string
function JStPriRntLkFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

//Functionality: Call Page Add
//Parameters: Event Select List Branch
//Creator: 05/07/2019 wasin (AKA: MR.JW)
//Return: Duplicate/none
//Return Type: string
function JSvPriRntLkCallPageAdd(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "dcmPriRntLkPageAdd",
        cache: false,
        timeout: 0,
        success: function (tResult) {
            var aReturnData = JSON.parse(tResult);
            if (aReturnData['nStaEvent'] == '1') {
                if (nStaPriRntLkBrowseType == '1') {
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tViewPageAdd']);
                } else {
                    $('#oliPriRntLkTitleEdit').hide();
                    $('#odvPriRntLkBtnGrpInfo').hide();
                    $('#oliPriRntLkTitleAdd').show();
                    $('#odvPriRntLkBtnGrpAddEdit').show();
                    $('#odvPriRntLkContentPage').html(aReturnData['tViewPageAdd']);
                    JSvPriRntLkLoadDataTableDT();
                }
            } else {
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Call Page Edt
//Parameters: Event Select List Branch
//Creator: 10/07/2019 wasin (AKA: MR.JW)
//Return: Duplicate/none
//Return Type: string
function JSvPriRntLkCallPageEdit(ptPIDocNo){
    JStCMMGetPanalLangSystemHTML("JSvPriRntLkCallPageEdit",ptPIDocNo);
    $.ajax({
        type: "POST",
        url: "dcmPriRntLkPageEdit",
        data: {'tRthCode' : ptPIDocNo},
        cache: false,
        timeout: 0,
        success: function(tResult){
            var aReturnData = JSON.parse(tResult);
            if (aReturnData['nStaEvent'] == '1') {
                if (nStaPriRntLkBrowseType == '1') {
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tViewPageAdd']);
                } else {
                    $('#odvPriRntLkBtnGrpInfo').hide();
                    $('#oliPriRntLkTitleAdd').hide();
                    $('#oliPriRntLkTitleEdit').show();
                    $('#odvPriRntLkBtnGrpAddEdit').show();
                    $('#odvPriRntLkContentPage').html(aReturnData['tViewPageAdd']);
                    JSvPriRntLkLoadDataTableDT();
                }
            } else {
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown){
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    })
}

//Functionality: Call Data Price Rent Loker Table DT
//Parameters: Event Select List Branch
//Creator: 08/07/2019 wasin (AKA: MR.JW)
//Return: Duplicate/none
//Return Type: string
function JSvPriRntLkLoadDataTableDT(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        if($("#ohdPriRntLkRoute").val() == "dcmPriRntLkEventAdd"){
            var tPriRntLkRthCode    = "";
        }else{
            var tPriRntLkRthCode    = $("#oetPriRntLkRthCode").val();
        }
        var nPageCurrent = (pnPage === undefined || pnPage == "" || pnPage <= 0)? "1" : pnPage;
        $.ajax({
            type: "POST",
            url: "dcmPriRntLkLoadDataDT",
            data: {
                'ptPriRntLkRthCode' : tPriRntLkRthCode,
                'pnPageCurrent'     : nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function (tResult){
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    var tPriRntLkViewTableDT    = aReturnData['tPriRntLkViewTableDT'];
                    $('#odvPriRntLkDataDT').html(tPriRntLkViewTableDT);
                    setTimeout(function(){
                        JCNxCloseLoading();
                    },500);
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality: Set Status On Click Submit Buttom
// Parameters: Event Click Save Document
// Creator: 08/07/2019 wasin (AKA: MR.JW)
// LastUpdate: -
// Return: Set Status Submit By Button In Input Hidden
// ReturnType: None
function JSxPriRntLkSetStatusClickSubmit(pnStatus) {
    $("#ohdPriRntLkCheckSubmitByButton").val(pnStatus);
}

// Functionality: Fuction Call Send/Add Price Rent Locker
// Parameters: Event Click Save Document
// Creator: 08/07/2019 wasin (AKA: MR.JW)
// LastUpdate: -
// Return: Set Status Submit By Button In Input Hidden
// ReturnType: None
function JSxPriRntLkValidateFormDocument(){
    if($("#ohdPriRntLkCheckClearValidate").val() != 0){
        $('#ofmPriRntLkFormHDAdd').validate().destroy();
    }

    $('#ofmPriRntLkFormHDAdd').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetPriRntLkRthCode : {
                "required" : {
                    depends: function (oElement){
                        if($("#ohdPriRntLkRoute").val() == "dcmPriRntLkEventAdd"){
                            if($('#ocbPriRntLkAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }else{
                            return false;
                        }
                    }
                }
            },
            oetPriRntLkRthName  : {"required" : true},
        },
        messages: {
            oetPriRntLkRthCode  : {"required" : $('#oetPriRntLkRthCode').attr('data-validate-required')},
            oetPriRntLkRthName  : {"required" : $('#oetPriRntLkRthName').attr('data-validate-required')},
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("help-block");
            if(element.prop("type") === "checkbox") {
                error.appendTo(element.parent("label"));
            }else{
                var tCheck  = $(element.closest('.form-group')).find('.help-block').length;
                if(tCheck == 0) {
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass("has-error");
        },
        submitHandler: function (form){
            if(!$('#ocbPriRntLkAutoGenCode').is(':checked')){
                JSxPriRntLkValidateDocCodeDublicate();
            }else{
                if($("#ohdPriRntLkCheckSubmitByButton").val() == 1){
                    JCNxPriRntLkSubmitEventByButton();
                }
            }
        }
    });
}

// Functionality: Validate Doc Code (Validate ตรวจสอบรหัสเอกสาร)
// Parameters: Function Event Call
// Creator: 10/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JSxPriRntLkValidateDocCodeDublicate(){
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            'tTableName'    : 'TRTMPriRateHD',
            'tFieldName'    : 'FTRthCode',
            'tCode'         : $('#oetPriRntLkRthCode').val()
        },
        success: function (tResult){
            var aResultData = JSON.parse(tResult);
            $("#ohdPriRntLkCheckDuplicateCode").val(aResultData["rtCode"]);

            if($("#ohdPriRntLkCheckClearValidate").val() != 1) {
                $('#ofmPriRntLkFormHDAdd').validate().destroy();
            }

            $.validator.addMethod('dublicateCode', function(value,element){
                if($("#ohdPriRntLkRoute").val() == "dcmPriRntLkEventAdd"){
                    if($('#ocbPriRntLkAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdPriRntLkCheckDuplicateCode").val() == 1) {
                            return false;
                        }else{
                            return true;
                        }
                    }
                }else{
                    return true;
                }
            });

            // Set Form Validate From Add Document
            $('#ofmPriRntLkFormHDAdd').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetPriRntLkRthCode : {"dublicateCode": {}}
                },
                messages: {
                    oetPriRntLkRthCode : {"dublicateCode"  : $('#oetPriRntLkRthCode').attr('data-validate-duplicate')}
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    if(element.prop("type") === "checkbox") {
                        error.appendTo(element.parent("label"));
                    }else{
                        var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                        if (tCheck == 0) {
                            error.appendTo(element.closest('.form-group')).trigger('change');
                        }
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-error");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').removeClass("has-error");
                },
                submitHandler: function (form) {
                    if($("#ohdPriRntLkCheckSubmitByButton").val() == 1) {
                        JCNxPriRntLkSubmitEventByButton();
                    }
                }
            });

            if($("#ohdPriRntLkCheckClearValidate").val() != 1) {
                $("#ofmPriRntLkFormHDAdd").submit();
                $("#ohdPriRntLkCheckClearValidate").val(1);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: ดึงข้อมูล รายการอัตราค่าเช่า
// Parameters: Function Event Call 
// Creator: 10/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JSaPriRntLKGetFromDataDT(){
    var aPriRntLkDataDT = [];
    var tCountDataInTbl = $('#otbPriRntLkTabelDataDT tbody .xCNPriRntLkItem').length;
    if(tCountDataInTbl > 0){
        $('#otbPriRntLkTabelDataDT tbody .xCNPriRntLkItem').each(function(){
            var tRtdSeqNo   = $(this).data('seqno');
            var tRtdTmeType = $(this).data('tmetype');
            var tRtdMinQty  = $(this).data('minqty');
            var tRtdCalMin  = $(this).data('calmin');
            var tRtdPrice   = $(this).data('price');
            aPriRntLkDataDT.push({
                'tRtdSeqNo'     : tRtdSeqNo,
                'tRtdMinQty'    : tRtdMinQty,
                'tRtdCalMin'    : tRtdCalMin,
                'tRtdTmeType'   : tRtdTmeType,
                'tRtdPrice'     : tRtdPrice
            });
        });
    }
    return aPriRntLkDataDT;
}

// Functionality: ตรวจสอบข้อมูลในตาราง DT ว่ามีการเพิ่มข้อมูลแล้วหรือไหม
// Parameters: Function Event Call 
// Creator: 10/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JCNxPriRntLkSubmitEventByButton(){
    JCNxOpenLoading();
    var nPriRntLkAutoGenCode    = "";
    if(typeof($('#ocbPriRntLkAutoGenCode').val()) !== undefined &&  $('#ocbPriRntLkAutoGenCode').is(':checked',true)){
        nPriRntLkAutoGenCode    = 1;
    }else{
        nPriRntLkAutoGenCode    = 0;
    }
    
    var oPriRntLkDataHD = {
        'ocbPriRntLkAutoGenCode'    : nPriRntLkAutoGenCode,
        'oetPriRntLkRthCode'        : $("#oetPriRntLkRthCode").val(),
        'oetPriRntLkRthName'        : $("#oetPriRntLkRthName").val(),
        'ocmPriRntLkRthCalType'     : $("#ocmPriRntLkRthCalType").val(),
        'oetPrnAgnCode'             : $("#oetPrnAgnCode").val(),
    };

    $.ajax({
        type: "POST",
        url: $('#ohdPriRntLkRoute').val(),
        data: {
            'aPriRntLkDataHD'   : oPriRntLkDataHD,
            'aPriRntLkDataDT'   : JSaPriRntLKGetFromDataDT()
        },
        success: function (tResult){
            var aDataReturnEvent    = JSON.parse(tResult);
            if(aDataReturnEvent['nStaEvent'] == '1'){
                var nPriRntLkStaCallBack    = aDataReturnEvent['nStaCallBack'];
                var nPriRntLkCodeCallBack   = aDataReturnEvent['tCodeReturn'];
                switch(nPriRntLkStaCallBack){
                    case '1' :
                        JSvPriRntLkCallPageEdit(nPriRntLkCodeCallBack);
                    break;
                    case '2' :
                        JSvPriRntLkCallPageAdd();
                    break;
                    case '3' :
                        JSvPriRntLkCallPageList();
                    break;
                    default :
                        JSvPriRntLkCallPageEdit(nPriRntLkCodeCallBack);
                }
                JCNxCloseLoading();
            }else{
                var tMessageError = aDataReturnEvent['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
                JCNxCloseLoading();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: ฟังก์ชั่นลบข้อมูลแบบรายการเดียว
// Parameters: Function Event Call 
// Creator: 11/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JSoPriRntLkDelDocSingle(ptPriRntLkCode,ptPriRntLkName){
    var tPriRntLkTextConfrim    = $('#oetTextComfirmDeleteSingle').val()+" "+ptPriRntLkCode+' ('+ptPriRntLkName+') '+$('#oetTextComfirmDeleteYesOrNot').val();
    $('#odvPriRntLkModalDelDocSingle #ospTextConfirmDelSingle').html(tPriRntLkTextConfrim);
    $('#odvPriRntLkModalDelDocSingle').modal('show');
    $('#odvPriRntLkModalDelDocSingle #osmConfirmDelSingle').unbind().click(function () {
        JCNxOpenLoading();
        var nPriRntLkPageCurrent    = $('#ohdPriRntLkPageCurrent').val();
        $.ajax({
            type: "POST",
            url: "dcmPriRntLkEvemtDeleteSingle",
            data: {
                'pnDocNo'   : ptPriRntLkCode,
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    $('#odvPriRntLkModalDelDocSingle').modal('hide');
                    $('#odvPriRntLkModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                    $('.modal-backdrop').remove();
                    setTimeout(function () {
                        JSvPriRntLkCallPageDataTable(nPriRntLkPageCurrent);
                    }, 500);
                }else{
                    JCNxCloseLoading();
                    FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });
}

// Functionality: ฟังก์ชั่นลบข้อมูลแบบหลายรายการ
// Parameters: Function Event Call 
// Creator: 11/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JSoPriRntLkDelDocMultiple(){
    var aDataDelMultiple    = $('#odvPriRntLkModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
    var aTextsDelMultiple   = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
    var aDataSplit = aTextsDelMultiple.split(" , ");
    var nDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];
    for ($i = 0; $i < nDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }
    if (nDataSplitlength > 1) {
        JCNxOpenLoading();
        localStorage.StaDeleteArray = '1';
        var nPriRntLkPageCurrent    = $('#ohdPriRntLkPageCurrent').val();
        $.ajax({
            type: "POST",
            url: "dcmPriRntLkEvemtDeleteMulti",
            data: {
                'paDocNo': aNewIdDelete
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    setTimeout(function () {
                        $('#odvPriRntLkModalDelDocMultiple').modal('hide');
                        $('#odvPriRntLkModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                        $('#odvPriRntLkModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                        $('.modal-backdrop').remove();
                        localStorage.removeItem('LocalItemData');
                        JSvPriRntLkCallPageDataTable(nPriRntLkPageCurrent);
                    }, 1000);
                } else {
                    JCNxCloseLoading();
                    FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

function JSvPriRntLkClickPageList(ptPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld        = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent    = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld        = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent    = nPageNew;
                break;
            default:
                nPageCurrent    = ptPage;
        }
        JSvPriRntLkCallPageDataTable(nPageCurrent);
    } else {
        JCNxShowMsgSessionExpired();
    }
}