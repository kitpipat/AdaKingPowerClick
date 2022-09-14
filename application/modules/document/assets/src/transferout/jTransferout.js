var nStaTXOBrowseType   = $("#oetTXOStaBrowse").val();
var tCallTXOBackOption  = $("#oetTXOCallBackOption").val();
var tTXODocType         = $("#oetTXODocType").val();

$("document").ready(function () {
    localStorage.removeItem("LocalItemData");
    
    if(typeof (nStaTXOBrowseType) != 'undefined' && nStaTXOBrowseType == 0){
        $('#oliTXOTitle').unbind().click(function () { JSvTXOCallPageList(); })

        $('#obtTXOCallPageAdd').unbind().click(function () { JSvTXOCallPageAdd(); });

        $('#obtTXOCallBackPage').unbind().click(function () { JSvTXOCallPageList(); });

        $('#obtTXOCancel').unbind().click(function () {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {
                JSnTXOCancel(false);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtTXOApprove').unbind().click(function () {
            JSxTXOSetStatusClickSubmit(2);
            JSxTXOValidateViaOrderBeforeApvDoc(false);
        });

        $('#obtTXOSubmitFrom').click(function () {
            JSxTXOSetStatusClickSubmit(1);
            $('#obtSubmitTXO').click();
        });

        JSxTXONavDefult();
        JSvTXOCallPageList();
    }else if(typeof (nStaTXOBrowseType) != 'undefined' && nStaTXOBrowseType == 1){
        $('#oahTXOBrowseCallBack').unbind().click(function () { JCNxBrowseData(tCallTXOBackOption); });
        $('#oliTXOBrowsePrevious').unbind().click(function () { JCNxBrowseData(tCallTXOBackOption); });
        $('#obtTXOBrowseSubmit').unbind().click(function () {
            JSxTXOSetStatusClickSubmit(1);
            $('#obtSubmitTXO').click();
        });

        JSxTXONavDefult();
        JSvTXOCallPageAdd();
    }else{ }
});

// Function: Set Defult Nav Menu
// Parameters: Error Ajax Function
// Creator: 30/04/2019 Wasin(Yoshi)
// LastUpdate:
// Return: Set Default Nav Menu
// ReturnType: -
function JSxTXONavDefult() {
    if (typeof (nStaTXOBrowseType) != 'undefined' && nStaTXOBrowseType == 0) {
        $('.xCNChoose').hide();
        $('#oliTXOTitleAdd').hide();
        $('#oliTXOTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnTXOInfo').show();
    } else if (typeof (nStaTXOBrowseType) != 'undefined' && nStaTXOBrowseType == 1) {
        $('#odvModalBody #odvTXOMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliTXONavBrowse').css('padding', '2px');
        $('#odvModalBody #odvTXOBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNTXOBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNTXOBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    } else { }
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 30/04/2019 Wasin(Yoshi)
// LastUpdate:
// Return: Call View Tranfer Out List
// ReturnType: View
function JSvTXOCallPageList() {
    $.ajax({
        type: "GET",
        url: "dcmTXOFormSearchList",
        cache: false,
        timeout: 0,
        success: function (tResult) {
            $("#odvContentPageTXO").html(tResult);
            JSxTXONavDefult();
            JSvTXOCallPageDataTable();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Call Page Data Table
// Parameters: Function Call Page
// Creator: 02/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Call View Tranfer Out Data Table
// ReturnType: View
function JSvTXOCallPageDataTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        var oAdvanceSearch = JSoTXOGetAdvanceSearchData();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        $.ajax({
            type: "POST",
            url: "dcmTXODataTable",
            data: {
                oAdvanceSearch: oAdvanceSearch,
                nPageCurrent: nPageCurrent,
                tTXODocType: tTXODocType
            },
            cache: false,
            timeout: 0,
            success: function (oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSxTXONavDefult();
                    $('#ostContentTransferOut').html(aReturnData['tTXOViewDataTable']);
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
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Get Data Advanced Search
// Parameters: Function Call Page
// Creator: 02/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: object Data Advanced Search
// ReturnType: object
function JSoTXOGetAdvanceSearchData() {
    var oAdvanceSearchData = {
        tSearchAll: $("#oetSearchAll").val(),
        tSearchBchCodeFrom: $("#oetTxoBchCodeFrom").val(),
        tSearchBchCodeTo: $("#oetTxoBchCodeTo").val(),
        tSearchDocDateFrom: $("#oetTxoDocDateFrom").val(),
        tSearchDocDateTo: $("#oetTxoDocDateTo").val(),
        tSearchStaDoc: $("#ocmTxoStaDoc").val(),
        tSearchStaApprove: $("#ocmTxoStaApprove").val(),
        tSearchStaPrcStk: $("#ocmTxoStaPrcStk").val()
    };
    return oAdvanceSearchData;
}

// Functionality : เปลี่ยนหน้า pagenation
// Parameters : -
// Creator : 02/05/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvTXOClickPage(ptPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvTXOCallPageDataTable(nPageCurrent);
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Event Single Delete Document Single
// Parameters: Function Call Page
// Creator: 03/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: object Data Sta Delete
// ReturnType: object
function JSnTXODelDocSingle(ptCurrentPage, ptTxoDocNo) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        $('#odvTxoModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val() + ptTxoDocNo);
        $('#odvTxoModalDelDocSingle').modal('show');
        $('#odvTxoModalDelDocSingle #osmConfirmDelSingle').unbind().click(function () {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "dcmTXOEventDelete",
                data: {
                    'tTXODocType': tTXODocType,
                    'tTxoDocNo': ptTxoDocNo
                },
                cache: false,
                timeout: 0,
                success: function (oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if (aReturnData['nStaEvent'] == '1') {
                        $('#odvTxoModalDelDocSingle').modal('hide');
                        $('#odvTxoModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                        $('.modal-backdrop').remove();
                        setTimeout(function () {
                            JSvTXOCallPageDataTable(ptCurrentPage);
                        }, 500);
                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Event Single Delete Doc Mutiple
// Parameters: Function Call Page
// Creator: 03/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: object Data Sta Delete
// ReturnType: object
function JSnTXODelDocMultiple() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        var aDataDelMultiple = $('#odvTxoModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
        var aTextsDelMultiple = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
        var aDataSplit = aTextsDelMultiple.split(" , ");
        var nDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        for ($i = 0; $i < nDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }
        if (nDataSplitlength > 1) {
            JCNxOpenLoading();
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type: "POST",
                url: "dcmTXOEventDelete",
                data: {
                    'tTXODocType': tTXODocType,
                    'tTxoDocNo': aNewIdDelete
                },
                cache: false,
                timeout: 0,
                success: function (oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if (aReturnData['nStaEvent'] == '1') {
                        setTimeout(function () {
                            $('#odvTxoModalDelDocMultiple').modal('hide');
                            $('#odvTxoModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                            $('#odvTxoModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                            $('.modal-backdrop').remove();
                            localStorage.removeItem('LocalItemData');
                            JSvTXOCallPageList();
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
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 02/05/2019 Wasin(Yoshi)
//Return: Show Button Delete All
//Return Type: -
function JSxTXOShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 02/05/2019 Wasin(Yoshi)
//Return: Insert Code In Text Input
//Return Type: -
function JSxTXOTextinModal() {
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
        $("#odvTxoModalDelDocMultiple #ospTextConfirmDelMultiple").text($('#oetTextComfirmDeleteMulti').val());
        $("#odvTxoModalDelDocMultiple #ohdConfirmIDDelMultiple").val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 02/05/2019 Wasin(Yoshi)
//Return: Duplicate/none
//Return Type: string
function JStTXOFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

// Functionality : Call Page Transfer Out Add Page
// Parameters : Event Click Buttom
// Creator : 02/05/2018 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvTXOCallPageAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "dcmTXOPageAdd",
            data: {
                'tTXODocType': tTXODocType
            },
            cache: false,
            timeout: 0,
            success: function (oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    if (nStaTXOBrowseType == '1') {
                        $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                        $('#odvModalBodyBrowse').html(aReturnData['tTXOViewPageAdd']);
                    } else {
                        $('#oliTXOTitleEdit').hide();
                        $("#obtTXOApprove").hide();
                        $("#obtTXOCancel").hide();
                        $('#odvBtnTXOInfo').hide();
                        $('#obtTXOPrint').hide();
                        $('#oliTXOTitleAdd').show();
                        $('#odvBtnAddEdit').show();
                        $('#odvContentPageTXO').html(aReturnData['tTXOViewPageAdd']);
                    }
                    JSvTXOLoadPdtDataTableHtml();
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
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality: Call Page Product Table In Add Document
// Parameters: Function Ajax Success
// Creator: 10/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View
// ReturnType : View
function JSvTXOLoadPdtDataTableHtml(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        JCNxOpenLoading();
        if($("#ohdTXORoute").val()  ==  "dcmTXOEventAdd"){
            var tTXODocNo   = "";
        }else{
            var tTXODocNo   = $("#oetTXODocNo").val();
        }

        var tTXOStaApv      = $("#ohdTXOStaApv").val();
        var tTXOStaDoc      = $("#ohdTXOStaDoc").val();
        var tTXOVATInOrEx   = $("#ostTXOVATInOrEx").val();

        //เช็ค สินค้าใน table หน้านั้นๆ หรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
        if ($("#odvTBodyTXOPdt .xWPdtItem").length == 0){
            if (pnPage != undefined) {
                pnPage = pnPage - 1;
            }
        }

        var nPageCurrent = (pnPage === undefined || pnPage == "" || pnPage <= 0)? "1" : pnPage;
        $.ajax({
            type: "POST",
            url: "dcmTXOPdtAdvanceTableLoadData",
            data: {
                'ptTXODocNo'        : tTXODocNo,
                'ptTXOStaApv'       : tTXOStaApv,
                'ptTXOStaDoc'       : tTXOStaDoc,
                'ptTXOVATInOrEx'    : tTXOVATInOrEx,
                'pnTXOPageCurrent'  : nPageCurrent,
                'ptTXODocType'      : tTXODocType
            },
            cache: false,
            Timeout: 0,
            success: function (oResult) {
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1'){
                    var tTransferOutAdvTable    = aReturnData['tTransferOutPdtAdvTableView'];
                    $('#ofmTXOFormAdd #odvTXOPdtTablePanal').html(tTransferOutAdvTable);
                    JSvTXOLoadVatTableHtml();
                    JSxTXOSetCalculateLastBillSetText();
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

// Functionality: โหลด Html Vat มาแปะ ในหน้า Add
// Parameters: Function Ajax Success
// Creator: 13/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View
// ReturnType : View
function JSvTXOLoadVatTableHtml() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        tTXODocNo       = $("#oetTXODocNo").val();
        tTXOVATInOrEx   = $("#ostTXOVATInOrEx").val();
        $.ajax({
            type: "POST",
            url: "dcmTXOVatTableLoadData",
            data: {
                tTXODocType     : tTXODocType,
                tTXODocNo       : tTXODocNo,
                tTXOVATInOrEx   : tTXOVATInOrEx,
            },
            cache: false,
            Timeout: 0,
            success: function (oResult) {
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1'){
                    var tTXOViewVatTableData    = aReturnData['tTXOViewVatTableData'];
                    $('#ofmTXOFormAdd #odvTXOVatTableData').html(tTXOViewVatTableData);
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

// Functionality : ส่ง จำนวนเงิน ไปแปลเป็น ไทย , Set Text จำนวนยอดสุทธิท้ายบิล
// Parameters: Function Ajax Success
// Creator: 13/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View
// ReturnType : View
function JSxTXOSetCalculateLastBillSetText(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        tTXODocNo       = $("#oetTXODocNo").val();
        tTXOVATInOrEx   = $("#ostTXOVATInOrEx").val();
        $.ajax({
            type: "POST",
            url: "dcmTXOCalculateLastBill",
            data: {
                tTXODocType     : tTXODocType,
                tTXODocNo       : tTXODocNo,
                tTXOVATInOrEx   : tTXOVATInOrEx,
            },
            cache: false,
            Timeout: 0,
            success: function (oResult) {
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1'){
                    var tTXOViewCalcLastBill    = aReturnData['tTXOViewCalcLastBill'];
                    $('#ofmTXOFormAdd #odvTXOCalcLastBillSetText').html(tTXOViewCalcLastBill);
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
// Creator: 21/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Set Status Submit By Button In Input Hidden
// ReturnType: None
function JSxTXOSetStatusClickSubmit(pnStatus) {
    $("#ohdTXOCheckSubmitByButton").val(pnStatus);
}

// Functionality : Add Or Update Document 
// Parameters: Function Ajax Success
// Creator: 21/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Status Add Or Update Document 
// ReturnType : -
function JSxTXOAddEditDocument(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        JSxTXOValidateFormDocument();
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Validate From Add Or Update Document
// Parameters: Function Ajax Success
// Creator: 21/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Status Add Or Update Document 
// ReturnType : -
function JSxTXOValidateFormDocument(){
    if($("#ohdTXOCheckClearValidate").val() != 0){
        $('#ofmTXOFormAdd').validate().destroy();
    }

    $('#ofmTXOFormAdd').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetTXODocNo : {
                "required" : {
                    depends: function (oElement) {
                        if($("#ohdTXORoute").val()  ==  "dcmTXOEventAdd"){
                            if($('#ocbTXOStaAutoGenCode').is(':checked')){
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
            oetTXODocDate       : {"required" : true},
            oetTXODocTime       : {"required" : true},
            oetTXOWahNameFrom   : {"required" : true},
            oetTXOWahNameTo     : {"required" : true}
        },
        messages: {
            oetTXODocNo         : {"required" : $('#oetTXODocNo').attr('data-validate-required')},
            oetTXODocDate       : {"required" : $('#oetTXODocDate').attr('data-validate-required')},
            oetTXODocTime       : {"required" : $('#oetTXODocTime').attr('data-validate-required')},
            oetTXOWahNameFrom   : {"required" : $('#oetTXOWahNameFrom').attr('data-validate-required')},
            oetTXOWahNameTo     : {"required" : $('#oetTXOWahNameTo').attr('data-validate-required')},
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
            if(!$('#ocbTXOStaAutoGenCode').is(':checked')){
                JSxTXOValidateDocCodeDublicate();
            }else{
                if($("#ohdTXOCheckSubmitByButton").val() == 1){
                    JSxTXOSubmitEventByButton();
                }
            }
        },
    });
    if($("#ohdTXOCheckClearValidate").val() != 0) {
        $("#ofmTXOFormAdd").submit();
        $("#ohdTXOCheckClearValidate").val(0);
    }
}

// Functionality: Validate Doc Code (Validate ตรวจสอบรหัสเอกสาร)
// Parameters: -
// Creator: 21/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JSxTXOValidateDocCodeDublicate(){
    var tTXOTableName  = "";
    var tTXOFieldName  = "";
    switch(tTXODocType){
        case 'WAH':
            tTXOTableName   = 'TCNTPdtTwo';
            tTXOFieldName   = 'FTXthDocNo';
        break;
        case 'BCH':
            tTXOTableName   = 'TCNTPdtTbo';
            tTXOFieldName   = 'FTXthDocNo';
        break;
    }
    var tTXOTableCheckName  = tTXOTableName+'HD';
    var tTXODocNo           = $("#oetTXODocNo").val();
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            'tTableName'    : tTXOTableCheckName,
            'tFieldName'    : tTXOFieldName,
            'tCode'         : tTXODocNo
        },
        success: function (oResult) {
            var aResultData = JSON.parse(oResult);

            $("#ohdTXOCheckDuplicateCode").val(aResultData["rtCode"]);

            if ($("#ohdTXOCheckClearValidate").val() != 1) {
                $('#ofmTXOFormAdd').validate().destroy();
            }

            $.validator.addMethod('dublicateCode', function (value,element){
                if($("#ohdTXORoute").val()  ==  "dcmTXOEventAdd"){
                    if($('#ocbTXOStaAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdTXOCheckDuplicateCode").val() == 1) {
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
            $('#ofmTXOFormAdd').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetTXODocNo : {"dublicateCode": {}}
                },
                messages: {
                    oetTXODocNo : {"dublicateCode"  : $('#oetTXODocNo').attr('data-validate-duplicate')}
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
                    if($("#ohdTXOCheckSubmitByButton").val() == 1) {
                        JSxTXOSubmitEventByButton();
                    }
                }
            });

            if($("#ohdTXOCheckClearValidate").val() != 1) {
                $("#ofmTXOFormAdd").submit();
                $("#ohdTXOCheckClearValidate").val(1);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: Validate Success And Send Ajax Add/Update Document
// Parameters: Function Parameter Behide NextFunc Validate
// Creator: 21/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Status Add/Update Document
// ReturnType: object
function JSxTXOSubmitEventByButton(){
    // JCNxOpenLoading();
    if($("#ohdTXORoute").val() !=  "dcmTXOEventAdd"){
        var tTXODocNo   = $('#oetTXODocNo').val();
    }
    $.ajax({
        type    : "POST",
        url     : "dcmTXOChkHavePdtForTnf",
        data    : {
            ptTXODocType    : tTXODocType,
            ptTXODocNo      : tTXODocNo
        },
        cache: false,
        timeout: 0,
        success: function (oResult) {
            var aDataReturnChkTmp   = JSON.parse(oResult);
            if (aDataReturnChkTmp['nStaReturn'] == '1'){
                $.ajax({
                    type    : "POST",
                    url     : $("#ohdTXORoute").val(),
                    data    : $("#ofmTXOFormAdd").serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function (oResult) {
                        var aDataReturnEvent    = JSON.parse(oResult);
                        if(aDataReturnEvent['nStaReturn'] == '1'){
                            var nTXOStaCallBack     = aDataReturnEvent['nStaCallBack'];
                            var nTXODocNoCallBack   = aDataReturnEvent['tCodeReturn'];
                            switch(nTXOStaCallBack){
                                case '1' :
                                    JSvTXOCallPageEdit(nTXODocNoCallBack);
                                break;
                                case '2' :
                                    JSvTXOCallPageAdd();
                                break;
                                case '3' :
                                    JSvTXOCallPageList();
                                break;
                                default :
                                    JSvTXOCallPageEdit(nTXODocNoCallBack);
                            }
                        }else{
                            var tMessageError = aDataReturnEvent['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error   : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else if(aDataReturnChkTmp['nStaReturn'] == '800'){
                var tMsgDataTempFound   = aDataReturnChkTmp['tStaMessg'];
                FSvCMNSetMsgWarningDialog('<p class="text-left">'+tMsgDataTempFound+'</p>');
            }else{
                var tMsgErrorFunction   = aDataReturnChkTmp['tStaMessg'];
                FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Call Page Transfer Out Edit Page
// Parameters : Event Click Buttom
// Creator : 23/05/2018 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvTXOCallPageEdit(ptTXODocNo){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML("JSvTXOCallPageEdit",ptTXODocNo);
        $.ajax({
            type: "POST",
            url: "dcmTXOPageEdit",
            data: {
                'tTXODocType'   : tTXODocType,
                'tTXODocNo'     : ptTXODocNo
            },
            cache: false,
            timeout: 0,
            success: function(oResult){
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    if(nStaTXOBrowseType == '1') {
                        $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                        $('#odvModalBodyBrowse').html(aReturnData['tTXOViewPageAdd']);
                    }else{
                        $("#oliTXOTitleAdd").hide();
                        $("#odvBtnTXOInfo").hide();

                        $("#odvBtnAddEdit").show();
                        $("#oliTXOTitleEdit").show();
                        $("#obtTXOApprove").show();
                        $("#obtTXOPrint").show();
                        $("#obtTXOCancel").show();
                        $("#odvContentPageTXO").html(aReturnData['tTXOViewPageAdd']);
                    }

                    JSvTXOLoadPdtDataTableHtml();
                    JSxTXOControlObjAndBtn();
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                }else{
                    var tMessageError = aReturnData['tStaMessg'];
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

// Functionality : Check Validate 
// Parameters : Event Click Buttom
// Creator : 23/05/2018 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSxTXOControlObjAndBtn(){
    // Check สถานะอนุมัติ
    var nTXOStaApv  = $("#ohdTXOStaApv").val();
    var nTXOStaDoc  = $("#ohdTXOStaDoc").val();

    // Set Default Buttons
    $("#obtTXOCancel").attr("disabled", false);
    $("#obtTXOApprove").attr("disabled", false);
    $("#obtTXOPrint").attr("disabled", false);
    $(".form-control").attr("disabled", false);
    $(".ocbListItem").attr("disabled", false);
    $(".xCNBtnBrowseAddOn").attr("disabled", false);
    $(".xCNBtnDateTime").attr("disabled", false);
    $(".xCNDocBrowsePdt").attr("disabled", false).removeClass("xCNBrowsePdtdisabled");
    $(".xCNDocDrpDwn").show();
    $("#oetTXOSearchPdtHTML").attr("disabled", false);
    $(".xWBtnGrpSaveLeft").attr("disabled", false);
    $(".xWBtnGrpSaveRight").attr("disabled", false);
    $("#oliTXOEditShipAddr").show();
    $("#oliTXOBtnEditTaxAdd").show();
    
    // เช็คสถานะ Appove
    if(nTXOStaApv  == 1) {
        // ปิดปุ่ม Document Menu
        $("#obtTXOApprove").attr("disabled",true);
        $("#obtTXOPrint").attr("disabled",true);
        // ปิด Control input
        $(".form-control").attr("disabled",true);
        $(".ocbListItem").attr("disabled",true);
        $(".xCNBtnBrowseAddOn").attr("disabled",true);
        $(".xCNBtnDateTime").attr("disabled",true);
        $(".xCNDocBrowsePdt").attr("disabled",true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetTXOSearchPdtHTML").attr("disabled",false);
        $(".xWBtnGrpSaveLeft").attr("disabled",true);
        $(".xWBtnGrpSaveRight").attr("disabled",true);
        $("#oliTXOEditShipAddr").hide();
        $("#oliTXOBtnEditTaxAdd").hide();
    }

    // เช็คสถานะเอกสาร
    if(nTXOStaDoc == 3) {
        // ปิดปุ่ม Document Menu
        $("#obtTXOCancel").attr("disabled",true);
        $("#obtTXOApprove").attr("disabled",true);
        $("#obtTXOPrint").attr("disabled",true);
        // ปิด Control input
        $(".form-control").attr("disabled",true);
        $(".ocbListItem").attr("disabled",true);
        $(".xCNBtnBrowseAddOn").attr("disabled",true);
        $(".xCNBtnDateTime").attr("disabled",true);
        $(".xCNDocBrowsePdt").attr("disabled",true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetTXOSearchPdtHTML").attr("disabled", false);
        $(".xWBtnGrpSaveLeft").attr("disabled", true);
        $(".xWBtnGrpSaveRight").attr("disabled", true);
        $("#oliTXOEditShipAddr").hide();
        $("#oliTXOBtnEditTaxAdd").hide();
    }
}

// Functionality : Check Validate 
// Parameters : Event Click Buttom
// Creator : 23/05/2018 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSxTXOValidateViaOrderBeforeApvDoc(pbIsConfirm){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        if(!$($($($("#obtTXOBrowsePosTo").parent()).parent()).parent()).hasClass("xCNHide")) {
            if($("#oetTXOOldPosCodeTo").val() == $("#oetTXOPosCodeTo").val() && $("#oetTXOOldShpCodeTo").val() == $("#oetTXOShpCodeTo").val()){
                if($("#oetTXOOldPosCodeTo").val() != ""){
                    $("#odvTXODataTransportationDoc").addClass("in");
                    if($("#ohdTXOCheckClearValidate").val() != 2) {
                        $('#ofmTXOFormAdd').validate().destroy();
                    }
                    $.ajax({
                        type: "POST",
                        url: "dcmTXOCheckViaCodeForApv",
                        data: {
                            'ptTXODocType'  : tTXODocType,
                            'ptTXODocNo'    : $("#oetTXODocNo").val()
                        },
                        cache: false,
                        timeout: 0,
                        success: function (oResult){
                            var aChkDataViaCode = JSON.parse(oResult);
                            if(aChkDataViaCode['staPrc']){
                                $('#ofmTXOFormAdd').validate({
                                    focusInvalid: true,
                                    onclick: false,
                                    onfocusout: false,
                                    onkeyup: false,
                                    rules: {
                                        oetTXOViaName: {
                                            "required": {
                                                depends: function(oElement){
                                                    if(aChkDataViaCode["staHasVia"]){
                                                        return false;
                                                    }else{
                                                        return true;
                                                    }
                                                }
                                            }
                                        }
                                    },
                                    messages: {
                                        oetTXOViaName: {
                                            "required"  : $('#oetTXOViaName').attr('data-validate-required')
                                        }
                                    },
                                    errorElement: "em",
                                    errorPlacement: function (error, element){
                                        error.addClass("help-block");
                                        if(element.prop("type") === "checkbox"){
                                            error.appendTo(element.parent("label"));
                                        }else{
                                            var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                                            if(tCheck == 0){
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
                                        if($("#ohdTXOCheckSubmitByButton").val() == 2) {
                                            if($("#oetViaCode").val()==oResult["FTViaCode"]){
                                                JSxTXOApproveDocument(pbIsConfirm);
                                            }else{
                                                FSvCMNSetMsgWarningDialog("<p>"+tTXOMsgSltShpViaAndSave+"</p>");
                                            }
                                        }
                                    }
                                });
                            }
                            $("#ofmTXOFormAdd").submit();
                            $("#ohdTXOCheckClearValidate").val(2);
                        },
                        error: function(jqXHR, textStatus, errorThrown){
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }else{
                    JSxTXOApproveDocument(pbIsConfirm);
                }
            }else{
                FSvCMNSetMsgWarningDialog(tTXOMsgResaveDocument);
            }
        }else{
            JSxTXOApproveDocument(pbIsConfirm);
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Applove Document 
// Parameters : Event Click Buttom
// Creator : 28/05/2018 Wasin(Yoshi)
// Return : Status Applove Document
// Return Type : -
function JSxTXOApproveDocument(pbIsConfirm){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        if(pbIsConfirm){
            // $("#ohdCardShiftTopUpCardStaPrcDoc").val(2); // Set status for processing approve
            $("#odvTXOModalAppoveDoc").modal("hide");
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            var tTXODocNo   = $("#oetTXODocNo").val();
            var tTXOStaApv  = $("#ohdTXOStaApv").val();
            $.ajax({
                type: "POST",
                url: "dcmTXOApproveDoc",
                data: {
                    'ptTXODocType'  : tTXODocType,
                    'ptTXODocNo'    : tTXODocNo,
                    'ptTXOStaApv'   : tTXOStaApv
                },
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    if(tResult  !=  "") {
                        var aResultDataAppove = JSON.parse(tResult);
                        if (aResultDataAppove.nStaEvent == "900") {
                            FSvCMNSetMsgErrorDialog(aResultDataAppove.tStaMessg);
                        }
                    }else{
                        JSoTXOSubscribeMQDocument();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            $('#odvTXOModalAppoveDoc').modal({backdrop:'static',keyboard:false});
            $("#odvTXOModalAppoveDoc").modal("show");
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Subscribe Document MQ
// Parameters : Event Click Buttom
// Creator : 29/05/2018 Wasin(Yoshi)
// Return : Subscribe Document MQ
// Return Type : -
function JSoTXOSubscribeMQDocument(){
    // Switch Case Doctype Valiable
    switch(tTXODocType){
        case 'WAH':
            var tTXOLangCode    = $("#ohdTXOLangEdit").val();
            var tTXOUsrBchCode  = $("#ohdTXOBchCode").val();
            var tTXOUsrApv      = $("#ohdTXOApvCodeUsrLogin").val();
            var tTXODocNo       = $("#oetTXODocNo").val();
            var tTXOPrefix      = "RESTWO";
            var tTXOStaApv      = $("#ohdTXOStaApv").val();
            var tTXOStaDelMQ    = $("#ohdTXOStaDelMQ").val();
            var tTXOQName       = tTXOPrefix + "_" + tTXODocNo + "_" + tTXOUsrApv;

            // Update Status For Delete Qname Parameter
            var poUpdateStaDelQnameParams   = {
                ptDocTableName      : "TCNTPdtTwoHD",
                ptDocFieldDocNo     : "FTXthDocNo",
                ptDocFieldStaApv    : "FTXthStaPrcStk",
                ptDocFieldStaDelMQ  : "FTXthStaDelMQ",
                ptDocStaDelMQ       : tTXOStaDelMQ,
                ptDocNo             : tTXODocNo
            };

        break;
        case 'BCH':
            
        break;
    }

    // MQ Message Config
    var poDocConfig = {
        tLangCode     : tTXOLangCode,
        tUsrBchCode   : tTXOUsrBchCode,
        tUsrApv       : tTXOUsrApv,
        tDocNo        : tTXODocNo,
        tPrefix       : tTXOPrefix,
        tStaDelMQ     : tTXOStaDelMQ,
        tStaApv       : tTXOStaApv,
        tQName        : tTXOQName
    };
    
    // RabbitMQ STOMP Config
    var poMqConfig  = {
        host : "ws://202.44.55.94:15674/ws",
        username : "adasoft",
        password : "adasoft",
        vHost : "AdaPosV5.0"
    };

    // Callback Page Control(function)
    var poCallback = {
        tCallPageEdit : "JSvTXOCallPageEdit",
        tCallPageList : "JSvTXOCallPageList"
    };

    //Check Show Progress %
    FSxCMNRabbitMQMessage(poDocConfig,poMqConfig,poUpdateStaDelQnameParams,poCallback);
}

function JSvPIDOCSearchPdtHTML(){
    
}