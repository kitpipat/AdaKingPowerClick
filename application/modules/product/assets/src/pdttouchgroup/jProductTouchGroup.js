var nTCGBrowseType      = $("#ohdTCGBrowseType").val();
var tTCGBrowseOption    = $("#ohdTCGBrowseOption").val();

$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    /*Check เปิดปิด Menu ตาม Pin*/
    JSxCheckPinMenuClose();
    if(typeof(nTCGBrowseType) != 'undefined' && nTCGBrowseType == 0){
        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliTCGTitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvTCGCallPageMain();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        
        // Event Click Call Back Page
        $('#obtTCGCallBackPage').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvTCGCallPageMain();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtTCGCallPageAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvTCGCallPageAddForm();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From Document
        $('#obtTCGSubmitForm').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxTCGSetStatusClickSubmit(1);
                $('#obtTCGEventSubmitForm').unbind().click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JSxTCGNavDefult();
        JSvTCGCallPageMain();
    }else{
        // Event Modal Call Back Before List
        $('#oahTCGBrowseCallBack').unbind().click(function (){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tTCGBrowseOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Modal Call Back Previous
        $('#oliTCGBrowsePrevious').unbind().click(function (){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tTCGBrowseOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Submit Form
        $('#obtTCGBrowseSubmit').unbind().click(function () {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxTCGSetStatusClickSubmit(1);
                $('#obtTCGEventSubmitForm').unbind().click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JSxTCGNavDefult();
        JSvTCGCallPageAddForm();
    }
});

// Function: Set Defult Nav Menu
// Parameters: Document Ready Or Parameter Event
// Creator: 06/01/2020 Wasin(Yoshi)
// Return: Set Default Nav Menu
// ReturnType: -
function JSxTCGNavDefult(){
    if(typeof(nTCGBrowseType) != 'undefined' && nTCGBrowseType == 0) {
        // Title Label Hide/Show
        $('#oliTCGTitleAdd').hide();
        $('#oliTCGTitleEdit').hide();
        $('#oliTCGTitleDetail').hide();
        // Button Hide/Show
        $('#odvTCGBtnGrpAddEdit').hide();
        $('#odvTCGBtnGrpInfo').show();
        $('#obtTCGCallPageAdd').show();
    }else{
        $('#odvModalBody #odvTCGMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliTCGNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvTCGBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNTCGBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNTCGBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function: Call Page Main
// Parameters: Document Redy Function
// Creator: 06/01/2020 Wasin(Yoshi)
// Return: Call View Main
// ReturnType: View
function JSvTCGCallPageMain(){
    JCNxOpenLoading();
    $.ajax({
        type: "GET",
        url: "pdtTouchGroupPageMain",
        cache: false,
        timeout: 0,
        success: function (tResult){
            $("#odvTCGContentPageDocument").html(tResult);
            JSxTCGNavDefult();
            JSvTCGCallPageDataTable();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Call Page Data Table List
// Parameters: Document Redy Function
// Creator: 06/01/2020 Wasin(Yoshi)
// Return: Call View Data Table List
// ReturnType: View
function JSvTCGCallPageDataTable(pnPage){
    // Get Data Search All
    let tSearchAll      = $("#oetTCGSearchAll").val();
    // Check Page Call Select
    let nPageCurrent    = pnPage;
    if(typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type: "POST",
        url: "pdtTouchGroupPageDataTable",
        data: {
            'ptSearchAll'   : tSearchAll,
            'pnPageCurrent' : nPageCurrent,
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1') {
                JSxTCGNavDefult();
                $('#ostTCGDataTable').html(aReturnData['tTCGViewDataTableList']);
            } else {
                var tMessageError   = aReturnData['tStaMessg'];
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

// Functionality : Call Page Add
// Parameters : Event Click Buttom
// Creator : 06/01/2020 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvTCGCallPageAddForm(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "pdtTouchGroupPageAdd",
        cache: false,
        timeout: 0,
        success : function (oResult){
            var aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1') {
                if(nTCGBrowseType == '1'){
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tTCGViewPageAdd']);
                }else{
                    // Hide Title Menu And Button
                    $('#oliTCGTitleEdit').hide();
                    $('#odvTCGBtnGrpInfo').hide();
                    // Show Title Menu And Button
                    $('#oliTCGTitleAdd').show();
                    $('#odvTCGBtnGrpSave').show();
                    $('#odvTCGBtnGrpAddEdit').show();
                    // Remove Disable Button Add 
                    $(".xWBtnGrpSaveLeft").attr("disabled",false);
                    $(".xWBtnGrpSaveRight").attr("disabled",false);
                    $('#odvTCGContentPageDocument').html(aReturnData['tTCGViewPageAdd']);
                }
            }else{
                var tMessageError   = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Set Status Click Submit
// Parameters : Event Click Buttom
// Creator : 07/01/2020 Wasin(Yoshi)
// Return : None
// Return Type : None
function JSxTCGSetStatusClickSubmit(pnStatus){
    $("#ohdTCGCheckSubmitByButton").val(pnStatus);
}

// Functionality : Call Page Edit
// Parameters : Event Click Buttom
// Creator : 06/01/2020 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvTCGCallPageEditForm(ptTcgCode){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "pdtTouchGroupPageEdit",
        data: { ptTcgCode : ptTcgCode },
        cache: false,
        timeout: 0,
        success: function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1') {
                if(nTCGBrowseType == '1'){
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tTCGViewPageEdit']);
                }else{
                    // Hide Title Menu And Button
                    $('#oliTCGTitleAdd').hide();
                    $('#odvTCGBtnGrpInfo').hide();
                    // Show Title Menu And Button
                    $('#oliTCGTitleEdit').show();
                    $('#odvTCGBtnGrpSave').show();
                    $('#odvTCGBtnGrpAddEdit').show();
                    // Remove Disable Button Add 
                    $(".xWBtnGrpSaveLeft").attr("disabled",false);
                    $(".xWBtnGrpSaveRight").attr("disabled",false);
                    $('#odvTCGContentPageDocument').html(aReturnData['tTCGViewPageEdit']);
                }
            }else{
                var tMessageError   = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxCloseLoading();  
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Function Add Edit Form
// Parameters : Event Click Buttom
// Creator : 07/01/2020 Wasin(Yoshi)
// Return : None 
// Return Type : None
function JSxTCGCheckValidateForm(){
    // Check Status Check Validate
    if($("#ohdTCGCheckClearValidate").val() != 0){
        $('#ofmPdtTouchGroupAddEditForm').validate().destroy();
    }

    // Option Validate Form
    $('#ofmPdtTouchGroupAddEditForm').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetTCGCode : {
                "required" : {
                    depends: function (oElement) {
                        if($("#ohdTCGRouteEvent").val()  ==  "pdtTouchGroupEventAdd"){
                            if($('#ocbTCGStaAutoGenCode').is(':checked')){
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
            oetTCGName    : {"required" : true},
        },
        messages: {
            oetTCGCode  : {"required" : $('#oetTCGCode').attr('data-validate-required')},
            oetTCGName  : {"required" : $('#oetTCGName').attr('data-validate-required')},
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
            if(!$('#ocbTCGStaAutoGenCode').is(':checked')){
                JSxTCGValidateCodeDublicate();
            }else{
                if($("#ohdTCGCheckSubmitByButton").val() == 1){
                    JSxTCGSubmitEventByButton();
                }
            }
        }
    });
}

// Functionality : Function Check Code Duplicate In DB
// Parameters : Event Click Buttom
// Creator : 07/01/2020 Wasin(Yoshi)
// Return : None 
// Return Type : None
function JSxTCGValidateCodeDublicate(){
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            'tTableName' : 'TCNMPdtTouchGrp',
            'tFieldName' : 'FTTcgCode',
            'tCode' : $('#oetTCGCode').val()
        },
        success: function (oResult) {
            var aResultData = JSON.parse(oResult);
            // Set Status Code Duplicate
            $("#ohdTCGCheckDuplicateCode").val(aResultData["rtCode"]);
            // Check Cleate Validate
            if($("#ohdTCGCheckClearValidate").val() != 1) {
                $('#ofmPdtTouchGroupAddEditForm').validate().destroy();
            }
            // Add Option Duplicate Code
            $.validator.addMethod('dublicateCode', function(value,element){
                if($("#ohdTCGRouteEvent").val() == "pdtTouchGroupEventAdd"){
                    if($('#ocbTCGStaAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdTCGCheckDuplicateCode").val() == 1) {
                            return false;
                        }else{
                            return true;
                        }
                    }
                }else{
                    return true;
                }
            });

            // Set Validate Form
            $('#ofmPdtTouchGroupAddEditForm').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetTCGCode : {"dublicateCode": {}}
                },
                messages: {
                    oetTCGCode : {"dublicateCode"  : $('#oetTCGCode').attr('data-validate-duplicate')}
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
                    if($("#ohdTCGCheckSubmitByButton").val() == 1) {
                        JSxTCGSubmitEventByButton();
                    }
                },
            });
            if($("#ohdTCGCheckClearValidate").val() != 1) {
                $("#ofmPdtTouchGroupAddEditForm").submit();
                $("#ohdTCGCheckClearValidate").val(1);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Function Event Form
// Parameters : Event Click Buttom
// Creator : 07/01/2020 Wasin(Yoshi)
// Return : None 
// Return Type : None
function JSxTCGSubmitEventByButton(){
    $.ajax({
        type: "POST",
        url: $("#ohdTCGRouteEvent").val(),
        data: $("#ofmPdtTouchGroupAddEditForm").serialize(),
        cache: false,
        timeout: 0,
        success: function(oResult){
            if (nTCGBrowseType != 1) {
                let aDataReturnEvent    = JSON.parse(oResult);
                if(aDataReturnEvent['nStaEvent'] == '1'){
                    let nTCGStaCallBack      = aDataReturnEvent['nStaCallBack'];
                    let nTCGDocNoCallBack    = aDataReturnEvent['tCodeReturn'];
                    switch(nTCGStaCallBack){
                        case '1' :
                            JSvTCGCallPageEditForm(nTCGDocNoCallBack);
                        break;
                        case '2' :
                            JSvTCGCallPageAddForm();
                        break;
                        case '3' :
                            JSvTCGCallPageMain();
                        break;
                        default :
                            JSvTCGCallPageEditForm(nTCGDocNoCallBack);
                    }
                    JCNxImgWarningMessage(aDataReturnEvent['aImgReturn']);
                }else{
                    let tMessageError = aDataReturnEvent['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
            }else{
                JCNxCloseLoading();
                JCNxBrowseData(tTCGBrowseOption);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Event Single Delete Document Single
// Parameters: Function Call Page
// Creator: 07/01/2020 Wasin(Yoshi)
// Return: object Data Sta Delete
// ReturnType: object
function JSoTCGDeleteSingle(ptCurrentPage,ptTcgCode,ptTcgName){
    if(typeof(ptTcgCode) != undefined && ptTcgCode != ""){
        let tTextConfrimDelSingle   = $('#oetTextComfirmDeleteSingle').val()+"&nbsp"+ptTcgCode+" ("+ptTcgName+")"+"&nbsp"+$('#oetTextComfirmDeleteYesOrNot').val();
        $('#odvTCGModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
        $('#odvTCGModalDelDocSingle').modal('show');
        $('#odvTCGModalDelDocSingle #osmConfirmDelSingle').unbind().click(function(){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "pdtTouchGroupEventDelete",
                data: {'ptIDCode' : ptTcgCode},
                cache: false,
                timeout: 0,
                success: function(oResult){
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == '1') {
                        $('#odvTCGModalDelDocSingle').modal('hide');
                        $('#odvTCGModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                        $('.modal-backdrop').remove();
                        setTimeout(function () {
                            JSvTCGCallPageDataTable(ptCurrentPage);
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
    }else{
        FSvCMNSetMsgErrorDialog('Error Not Found Code Number !!');
    }
}

// Function: Event Single Delete Document Multiple
// Parameters: Function Call Page
// Creator: 07/01/2020 Wasin(Yoshi)
// Return: object Data Sta Delete
// ReturnType: object
function JSoTCGDeleteMultiple(){
    var aDataDelMultiple    = $('#odvTCGModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
    var aTextsDelMultiple   = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
    var aDataSplit          = aTextsDelMultiple.split(" , ");
    var nDataSplitlength    = aDataSplit.length;
    var aNewIdDelete        = [];
    for($i = 0; $i < nDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }
    if(nDataSplitlength > 1) {
        JCNxOpenLoading();
        localStorage.StaDeleteArray = '1';
        $.ajax({
            type: "POST",
            url: "pdtTouchGroupEventDelete",
            data: {'ptIDCode' : aNewIdDelete},
            cache: false,
            timeout: 0,
            success: function (oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    setTimeout(function () {
                        $('#odvTCGModalDelDocMultiple').modal('hide');
                        $('#odvTCGModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                        $('#odvTCGModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                        $('.modal-backdrop').remove();
                        localStorage.removeItem('LocalItemData');
                        JSvTCGCallPageMain();
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

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 06/01/2020 Wasin(Yoshi)
//Return: Show Button Delete All
//Return Type: -
function JSxTCGShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliTCGBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliTCGBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliTCGBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 06/01/2020 Wasin(Yoshi)
//Return: Insert Code In Text Input
//Return Type: -
function JSxTCGTextinModal() {
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
        $("#odvTCGModalDelDocMultiple #ospTextConfirmDelMultiple").text($('#oetTextComfirmDeleteMulti').val());
        $("#odvTCGModalDelDocMultiple #ohdConfirmIDDelMultiple").val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 06/01/2020 Wasin(Yoshi)
//Return: Duplicate/none
//Return Type: string
function JStTCGFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 13/09/2018 wasin
//Return : View
//Return Type : View
function JSvTCGClickPageList(ptPage){
    var nPageCurrent = '';
    switch(ptPage){
        case 'next' :
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWTCGPageDataTable .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน

            nPageCurrent = nPageNew
        break;
        case 'previous' :
            nPageOld = $('.xWTCGPageDataTable .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
        break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvTCGCallPageDataTable(nPageCurrent);
}