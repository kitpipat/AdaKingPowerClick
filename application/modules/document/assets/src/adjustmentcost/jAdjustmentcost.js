var nStaADCBrowseType = $("#oetADCStaBrowse").val();
var tCallADCBackOption = $("#oetADCCallBackOption").val();

$("document").ready(function () {
    sessionStorage.removeItem("EditInLine");
    localStorage.removeItem("LocalItemData");
    localStorage.removeItem("Ada.ProductListCenter");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    if (typeof (nStaADCBrowseType) != 'undefined' && nStaADCBrowseType == 0) { // เข้ามาจาก Menulist Tab
        $('#oliADCTitle').unbind().click(function () {
            JSvADCCallPageList();
        });
        $('#obtADCCallPageAdd').unbind().click(function () {
            JSvADCCallPageAdd();
        });
        $('#obtADCCallBackPage').unbind().click(function () {
            JSvADCCallPageList();
        });
        $('#obtADCCancel').unbind().click(function () {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {
                JSnADCCancelDoc(false);
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        $('#obtADCApprove').unbind().click(function () {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof (nStaSession) !== "undefined" && nStaSession == 1) {
                JSxADCSetStatusClickSubmit(2);
                JSxADCApproveDocument(false);
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        $('#obtADCSubmitFrom').click(function () {
            JSxADCSetStatusClickSubmit(1);
            JSxValidateFormAddADC();
            //$('#obtSubmitADC').click();
            $('#ofmADCFormAdd').submit();
        });


        JSxADCNavDefult();
        JSvADCCallPageList();
    } else if (typeof (nStaADCBrowseType) != 'undefined' && nStaADCBrowseType == 1) { // เข้ามาจาก Modal Browse
        $('#oahADCBrowseCallBack').unbind().click(function () { JCNxBrowseData(tCallADCBackOption); });
        $('#oliADCBrowsePrevious').unbind().click(function () { JCNxBrowseData(tCallADCBackOption); });
        $('#obtADCBrowseSubmit').unbind().click(function () {
            JSxADCSetStatusClickSubmit(1);
            $('#obtSubmitADC').click();
        });
        JSxADCNavDefult();
        JSvADCCallPageAdd();
    } else { }
});


// Function: Set Defult Nav Menu 
// Parameters: Document Ready And Button Event Click
// Creator: 23/02/2021 Sooksanti(Nont)
// LastUpdate:
// Return: -
// ReturnType: -
function JSxADCNavDefult() {
    if (typeof (nStaADCBrowseType) != 'undefined' && nStaADCBrowseType == 0) { // เข้ามาจาก Menulist Tab
        $('.xCNChoose').hide();
        $('#oliADCTitleAdd').hide();
        $('#oliADCTitleEdit').hide();
        $('#oliADCTitleDetail').hide();
        $('#odvADCBtnAddEdit').hide();

        $('#odvADCBtnInfo').show();
    } else if (typeof (nStaADCBrowseType) != 'undefined' && nStaADCBrowseType == 1) { // เข้ามาจาก Modal Browse
        $('#odvModalBody #odvADCMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliADCNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvADCBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNADCBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNADCBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    } else { }
}

// Function: Call Page List Document
// Parameters: Document Redy Function
// Creator: 23/02/2021 Sooksanti(Nont)
// LastUpdate:
// Return: Call View Adjust Cost List
// ReturnType: View
function JSvADCCallPageList() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        $.ajax({
            type: "GET",
            url: "docADCFormSearchList",
            cache: false,
            timeout: 0,
            success: function (tResult) {
                $("#odvADCContentPage").html(tResult);
                JSxADCNavDefult();
                JSvADCCallPageDataTable();
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
// Creator: 23/02/2021 Sooksanti(Nont)
// LastUpdate: -
// Return: object Data Advanced Search
// ReturnType: object
function JSoADSGetAdvanceSearchData() {
    var oAdvanceSearchData = {
        tSearchAll: $("#oetSearchAll").val(),
        tSearchBchCodeFrom: $("#oetADSBchCodeFrom").val(),
        tSearchBchCodeTo: $("#oetADSBchCodeTo").val(),
        tSearchDocDateFrom: $("#oetADSDocDateFrom").val(),
        tSearchDocDateTo: $("#oetADSDocDateTo").val(),
        tSearchStaDoc: $("#ocmADSStaDoc").val(),
        // tSearchStaDocAct: $("#ocmStaDocAct").val(),
        tSearchStaApprove: $("#ocmADSStaApprove").val(),
        tSearchStaPrcStk: $("#ocmADSStaPrcStk").val()
    };
    return oAdvanceSearchData;
}

// Functionality : Call Page Adjust Stock Add Page
// Parameters : Event Click Buttom
// Creator : 24/02/2021 Sooksanti(Nont)
// Return : View
// Return Type : View
function JSvADCCallPageAdd() {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        $.ajax({
            type: "GET",
            url: "docADCPageAdd",
            cache: false,
            timeout: 0,
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    if (nStaADCBrowseType == '1') {
                        $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                        $('#odvModalBodyBrowse').html(aReturnData['tViewPageAdd']);
                    } else {
                        $('#oliADCTitleEdit').hide();
                        $("#obtADCApprove").hide();
                        $("#obtADCCancel").hide();
                        $('#odvADCBtnInfo').hide();
                        $('#obtADCPrint').hide();
                        $('#oliADCTitleAdd').show();
                        $('#odvADCBtnAddEdit').show();

                        $(".xWBtnGrpSaveLeft").show();
                        $(".xWBtnGrpSaveRight").show();

                        $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                        $('#odvADCContentPage').html(aReturnData['tViewPageAdd']);
                    }
                    JSxADCNumberRows($("#odvADCTable"));
                    JCNxADCControlObjAndBtn()
                    JCNxCloseLoading();
                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}


// Functionality : call page edit 
// Parameter : function parameters
// Create : 02/03/2021 Sooksanti(Nont)
// Return : -
// Return Type : -
function JSvADCCallPageEdit(ptXchDocNo) {
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "docADCPageEdit",
        data: { ptXchDocNo: ptXchDocNo },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            var aReturnData = JSON.parse(tResult);
            if (tResult != "") {
                $("#oliADCTitleAdd").hide();
                $("#oliADCTitleEdit").show();
                $("#odvADCBtnInfo").hide();
                $("#odvADCBtnAddEdit").show();
                // $("#odvADCContentPage").html(tResult);
                $("#oetADCDocNo").addClass("xCNDisable");
                $(".xCNDisable").attr("readonly", true);
                $(".xCNiConGen").hide();
                $("#obtADCApprove").show();
                $("#obtADCPrint").show();
                $("#obtADCCancel").show();

                $(".xWBtnGrpSaveLeft").show();
                $(".xWBtnGrpSaveRight").show();

            }
            //Control Event Button
            if ($("#ohdASTAutStaEdit").val() == 0) {
                $(".xCNUplodeImage").hide();
                $(".xCNIconBrowse").show();
                $(".xCNEditRowBtn").show();
                $("select").prop("disabled", false);
                $("input").attr("disabled", false);
            } else {
                $(".xCNUplodeImage").show();
                $(".xCNIconBrowse").show();
                $(".xCNEditRowBtn").show();
                $("select").prop("disabled", false);
                $("input").attr("disabled", false);
            }

            $('#odvADCContentPage').html(aReturnData['tViewPageAdd']);
            JSxADCGetPdtFromDT()
            JCNxADCControlObjAndBtn()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}




// Function: Call Page Data Table Document
// Parameters: Function Call Page
// Creator: 01/03/2021 Sooksanti
// LastUpdate: -
// Return: Call View Adjust Cost Data Table
// ReturnType: View
function JSvADCCallPageDataTable(pnPage) {
    JCNxOpenLoading();
    var oAdvanceSearch = JSoASTGetAdvanceSearchData();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type: "POST",
        url: "docADCDataTable",
        data: {
            oAdvanceSearch: oAdvanceSearch,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        timeout: 0,
        success: function (oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxADCNavDefult();
                $('#ostContentAdjustmentcost').html(aReturnData['tViewDataTable']);
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

// Function: Get Data Advanced Search
// Parameters: Function Call Page
// Creator: 25/02/2021 Sooksanti(Nont)
// LastUpdate: -
// Return: object Data Advanced Search
// ReturnType: object
function JSoASTGetAdvanceSearchData() {
    var oAdvanceSearchData = {
        tSearchAll: $("#oetADCSearchAll").val(),
        tSearchBchCodeFrom: $("#oetADCBchCodeFrom").val(),
        tSearchBchCodeTo: $("#oetADCBchCodeTo").val(),
        tSearchDocDateFrom: $("#oetADCDocDateFrom").val(),
        tSearchDocDateTo: $("#oetADCDocDateTo").val(),
        tSearchStaDoc: $("#ocmADCStaDoc").val(),
    };
    return oAdvanceSearchData;
}

//Functionality : เซ็ตค่าเพื่อให้รู้ว่าตอนนี้กดปุ่มบันทึกหลักจริงๆ (เพราะมีการซัมมิทฟอร์มแต่ไม่บันทึกเพื่อให้เกิด validate ใน on blur)
//Parameters : -
//Creator : 01/03/2021 Sooksanti(Nont)
//Update : -
//Return : -
//Return Type : -
function JSxADCSetStatusClickSubmit(pnStatus) {
    $("#ohdCheckADCSubmitByButton").val(pnStatus);
}


//Functionality : main validate form (validate ขั้นที่ 1 ตรวจสอบทั่วไป)
//Parameters : -
//Creator : 01/03/2021 Sooksanti(Non)
//Update : -
//Return : -
//Return Type : - 
function JSxValidateFormAddADC() {

    if ($("#ohdCheckADCClearValidate").val() != 0) {
        $('#ofmADCFormAdd').validate().destroy();
    }
    $('#ofmADCFormAdd').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetADCDocNo: {
                "required": {
                    depends: function (oElement) {
                        if ($("#ohdADCRoute").val() == "docADCEventAdd") {
                            if ($('#ocbADCStaAutoGenCode').is(':checked')) {
                                return false;
                            } else {
                                return true;
                            }
                        } else {
                            return false;
                        }
                    }
                }
            },
            ohdADCBchName: {
                "required": true
            }
        },
        messages: {
            oetADCDocNo: {
                "required": $('#oetADCDocNo').attr('data-validate-required')
            },
            oetADCDocDate: {
                "required": $('#oetADCDocDate').attr('data-validate-required')
            },
            ohdADCBchName: {
                "required": $('#ohdADCBchName').attr('data-validate-required')
            }
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
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
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass("has-error");
        },
        invalidHandler: function (event, validator) {
            if ($("#ohdCheckADCSubmitByButton").val() == 1) {
                FSvCMNSetMsgWarningDialog("<p>โปรดระบุข้อมูลให้สมบูรณ์</p>");
            }
        },
        submitHandler: function (form) {
            if ($("#ohdADCRoute").val() == "docADCEventAdd") {
                if (!$('#ocbADCStaAutoGenCode').is(':checked')) {
                    JSxValidateADCCodeDublicate();
                } else {
                    if ($('#ohdCheckADCSubmitByButton').val() == 1) {
                        JSxADCSubmitEventByButton();
                    }
                }
            } else {
                if ($('#ohdCheckADCSubmitByButton').val() == 1) {
                    JSxADCSubmitEventByButton();;
                }
            }

        }
    });
    if ($("#ohdCheckADCClearValidate").val() != 0) {
        $('#ofmADCFormAdd').submit();
        $("#ohdCheckADCClearValidate").val(0);
    }
}

//Functionality : function submit by submit button only (ส่งข้อมูลที่ผ่านการ validate ไปบันทึกฐานข้อมูล)
//Parameters : route
//Creator : 01/03/2021 Sooksanti
//Update : -
//Return : -
//Return Type : -
function JSxADCSubmitEventByButton() {
    var aDataInsert = JSxADCGetDataFromTableInsert();
    if(aDataInsert.length == $("#ohdADCCountDocRemark").val()){
        FSvCMNSetMsgWarningDialog("<p>กรุณาตรวจสอบข้อมูล</p>");
    }else{
        JCNxOpenLoading();
        JSxADCInsertDT();
    }

}

function JSxADCInsertDT(){
    $.ajax({
        type: "POST",
        url: $("#ohdADCRoute").val(),
        data: {
            ohdADCDocNo: $('#ohdADCDocNo').val(),
            ohdADCBchCode: $('#ohdADCBchCode').val(),
            oetADCDocDate: $('#oetADCDocDate').val(),
            oetADCDocTime: $('#oetADCDocTime').val(),
            oetADCEffectiveDate: $('#oetADCEffectiveDate').val(),
            oetADCRefInt: $('#oetADCRefInt').val(),
            oetADCRefIntDate: $('#oetADCRefIntDate').val(),
            otaADCRmk: $('#otaADCRmk').val(),
            aDataInsert: JSxADCGetDataFromTableInsert()
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            var aReturn = JSON.parse(tResult);
            // console.log(aReturn);

            if (nStaADCBrowseType != 1) {
                if (aReturn['nStaEvent'] == 1) {
                    switch (aReturn['nStaCallBack']) {
                        case '1':
                            JSvADCCallPageEdit(aReturn['tCodeReturn']);
                            break;
                        case '2':
                            JSvADCCallPageAdd();
                            break;
                        case '3':
                            JSvADCCallPageList();
                            break;
                        default:
                            JSvADCCallPageEdit(aReturn['tCodeReturn']);
                    }
                } else {
                    FSvCMNSetMsgErrorDialog(aReturn['tStaMessg']);
                    JCNxCloseLoading();
                }
            } else {
                JCNxCloseLoading();
                JCNxBrowseData(tCallSpaBackOption);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}
// Functionality : Action for approve
// Parameters : pbIsConfirm
// Creator : 03/03/2021
// Last Modified : -
// Return : -
// Return Type : -
function JSnADCCancelDoc(pbIsConfirm) {

    var tXchDocNo = $("#ohdADCDocNo").val();

    if (pbIsConfirm) {
        $.ajax({
            type: "POST",
            url: "docADCCancel",
            data: {
                tXchDocNo: tXchDocNo
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                $("#odvADCPopupCancel").modal("hide");
                aResult = $.parseJSON(tResult);
                if (aResult.nSta == 1) {
                    JSvADCCallPageEdit(tXchDocNo);

                } else {
                    JCNxCloseLoading();
                    tMsgBody = aResult.tMsg;
                    FSvCMNSetMsgWarningDialog(tMsgBody);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        //Check Status Approve for Control Msg In Modal
        nStaApv = $("#ohdADCStaApv").val();
        if (nStaApv == 1) {
            $("#obpMsgApv").show();
        } else {
            $("#obpMsgApv").hide();
        }
        $("#odvADCPopupCancel").modal("show");

    }
}

//Function : Control Object And Button ปิด เปิด
// Parameter : function parameters
// Create : 02/03/2021 Sooksanti(Nont)
// Return : -
// Return Type : -
function JCNxADCControlObjAndBtn() {
    //Check สถานะอนุมัติ
    var ohdXthStaApv = $("#ohdADCStaApv").val();
    var ohdADCStaDoc = $("#ohdADCStaDoc").val();

    //Set Default
    //Btn Cancel
    $("#obtADCCancel").attr("disabled", false);
    //Btn Apv
    $("#obtADCApprove").attr("disabled", false);
    $("#obtADCPrint").attr("disabled", false);
    $(".form-control").attr("disabled", false);
    $(".ocbListItem").attr("disabled", false);
    // $(".xCNBtnBrowseAddOn").attr("disabled", false);
    $(".xCNBtnDateTime").attr("disabled", false);
    $(".xCNDocBrowsePdt")
        .attr("disabled", false)
        .removeClass("xCNBrowsePdtdisabled");
    $(".xCNDocDrpDwn").show();
    $("#oetADCSearchPdtHTML").attr("disabled", false);
    $(".xWBtnGrpSaveLeft").attr("disabled", false);
    $(".xWBtnGrpSaveRight").attr("disabled", false);
    $("#oliBtnEditShipAdd").show();
    $("#oliBtnEditTaxAdd").show();

    if (ohdXthStaApv == '1') {
        //Btn Apv
        $("#obtADCApprove").hide();
        $("#obtADCPrint").attr("disabled", false);

        $("#obtADCCancel").hide();
        $(".xWBtnGrpSaveLeft").hide();
        $(".xWBtnGrpSaveRight").hide();

        //Control input ปิด
        $(".form-control").attr("disabled", true);
        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnBrowseAddOn").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt")
            .attr("disabled", true)
            .addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetADCSearchPdtHTML").attr("disabled", false);
        $("#oliBtnEditShipAdd").hide();
        $("#oliBtnEditTaxAdd").hide();
        $("#obtImportPDTInCN").attr("disabled", true);
        $("#ocbADCPurchase").attr("disabled", true);
        $("#ocbADCAddDoc").attr("disabled", true);
        $(".xCNIconTable").addClass("xCNDocDisabled");
        $(".xCNIconTable").attr("onclick", "").unbind("click");
        $(".xWBtnDelPdt").attr("disabled", true);
        $(".xCNImportBtn").attr("disabled", true);
    }

    //Check สถานะเอกสาร
    if (ohdADCStaDoc == '3') {
        $("#obtADCCancel").hide();
        $("#obtADCApprove").hide();
        $("#obtADCPrint").hide();
        $(".form-control").attr("disabled", true);
        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnBrowseAddOn").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt")
            .attr("disabled", true)
            .addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetADCSearchPdtHTML").attr("disabled", false);
        $(".xWBtnGrpSaveLeft").hide();
        $(".xWBtnGrpSaveRight").hide();
        $("#oliBtnEditShipAdd").hide();
        $("#oliBtnEditTaxAdd").hide();
        $("#obtImportPDTInCN").attr("disabled", true);
        $("#ocbADCPurchase").attr("disabled", true);
        $(".xCNIconTable").addClass("xCNDocDisabled");
        $(".xCNIconTable").attr("onclick", "").unbind("click");
        $("#ocbADCAddDoc").attr("disabled", true);
        $(".xWBtnDelPdt").attr("disabled", true);
        $(".xCNImportBtn").attr("disabled", true);
    }
}


// Functionality : Applove Document 
// Parameters : Event Click Buttom
// Creator : 03/03/2021 Sooksanti
// LastUpdate: -
// Return : Status Applove Document
// Return Type : -
function JSxADCApproveDocument(pbIsConfirm) {
    if (pbIsConfirm) {
        $("#odvADCModalAppoveDoc").modal("hide");
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        var tADCDocNo = $("#ohdADCDocNo").val();
        var tADCBchCode = $('#ohdADCBchCode').val();
        var tADCStaApv = $("#ohdADCStaApv").val();

        $.ajax({
            type: "POST",
            url: "docADCApproveDocument",
            data: {
                'ptADCDocNo': tADCDocNo,
                'ptADCBchCode': tADCBchCode,
                'ptADCStaApv': tADCStaApv,
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                console.log(tResult);
                try {
                    let oResult = JSON.parse(tResult);
                    if (oResult.nStaEvent == "900") {
                        FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                    }
                } catch (err) { }
                JSoADCCallSubscribeMQ();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        $('#odvADCModalAppoveDoc').modal({ backdrop: 'static', keyboard: false });
        $("#odvADCModalAppoveDoc").modal("show");
    }
}

// Functionality : Call Data Subscript Document
// Parameters : Event Click Buttom
// Creator : 03/03/2021 Sooksanti(Non)
// LastUpdate: -
// Return : Status Applove Document
// Return Type : -
function JSoADCCallSubscribeMQ() {
    // RabbitMQ
    /*===========================================================================*/
    // Document variable
    var tLangCode = $("#ohdADCLang").val();
    var tUsrBchCode = $("#ohdADCBchCode").val();
    var tUsrApv = $("#ohdADCUsrApvMQ").val();
    var tDocNo = $("#ohdADCDocNo").val();
    var tPrefix = "RESADJCOST";
    var tStaApv = $("#ohdADCStaApv").val();
    var tQName = tPrefix + "_" + tDocNo + "_" + tUsrApv;

    // MQ Message Config
    var poDocConfig = {
        tLangCode: tLangCode,
        tUsrBchCode: tUsrBchCode,
        tUsrApv: tUsrApv,
        tDocNo: tDocNo,
        tPrefix: tPrefix,
        tStaApv: tStaApv,
        tQName: tQName
    };

    // RabbitMQ STOMP Config
    var poMqConfig = {
        host: "ws://" + oSTOMMQConfig.host + ":15674/ws",
        username: oSTOMMQConfig.user,
        password: oSTOMMQConfig.password,
        vHost: oSTOMMQConfig.vhost
    };

    // Update Status For Delete Qname Parameter
    var poUpdateStaDelQnameParams = {
        ptDocTableName: "TCNTPdtAdjCostHD",
        ptDocFieldDocNo: "FTXchDocNo",
        ptDocFieldStaApv: "FTXchStaApv",
        ptDocFieldStaDelMQ:"",
        ptDocNo: tDocNo
    };

    // Callback Page Control(function)
    var poCallback = {
        tCallPageEdit: "JSvADCCallPageEdit",
        tCallPageList: "JSvADCCallPageList"
    };

    // Check Show Progress %
    FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
}


//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 03/03/2021
//Return: -
//Return Type: -
function JSxADCTextInModal() {
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
        $("#ospTextConfirmDelMultiple").text("ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?");
        $("#ohdConfirmIDDelete").val(tTextCode);
        $("#ohdConfirmIDDelMultiple").val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 03/03/2021 Sooksanti
//Return: Duplicate/none
//Return Type: string
function JStADCFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

// Function: Event Mutiple Delete Doc Mutiple
// Parameters: Function Call Page
// Creator: 03/03/2021 Sooksanti
// LastUpdate: -
// Return: object Data Sta Delete
// ReturnType: object
function JSoADCDelDocMultiple() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        var aDataDelMultiple = $('#odvADCModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
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
                url: "docADCEventDelete",
                data: { 'tADCDocNo': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function (oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if (aReturnData['nStaEvent'] == '1') {
                        setTimeout(function () {
                            $('#odvADCModalDelDocMultiple').modal('hide');
                            $('#odvADCModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                            $('#odvADCModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                            $('.modal-backdrop').remove();
                            localStorage.removeItem('LocalItemData');
                            JSvADCCallPageList();
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
//Creator: 03/03/2021 Sooksanti
//Return: Show Button Delete All
//Return Type: -
function JSxADCShowButtonChoose() {
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

// Function: Event Single Delete Document Single
// Parameters: Event Click Button Delete Document Single
// Creator: 03/03/2021
// LastUpdate: -
// Return: object Data Status Delete
// ReturnType: object
function JSoADCDelDocSingle(ptCurrentPage, ptADCDocNo) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        $('#odvADCModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val() + ptADCDocNo);
        $('#odvADCModalDelDocSingle').modal('show');
        $('#odvADCModalDelDocSingle #osmADCConfirmPdtDTTemp ').unbind().click(function () {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docADCEventDelete",
                data: { 'tADCDocNo': ptADCDocNo },
                cache: false,
                timeout: 0,
                success: function (oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if (aReturnData['nStaEvent'] == '1') {
                        $('#odvADCModalDelDocSingle').modal('hide');
                        $('#odvADCModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                        $('.modal-backdrop').remove();
                        setTimeout(function () {
                            JSvADCCallPageDataTable(ptCurrentPage);
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

// Function: GetData Insert
function JSxADCGetDataFromTableInsert() {
    var aData = [];

    $('#odvADCPdtTablePanal').find('tr').each(function (i, el) {
        // no thead
        if (i != 0) {
            var $tds = $(this).find('td');
            var aRow = [];
            
            $tds.each(function (i, el) {
                if (i == 1) {
                    aRow.push($(this).text());
                }
                if (i == 2) {
                    aRow.push($(this).text());
                }
                if (i == 3) {
                    aRow.push($(this).text());
                }
                if (i == 4) {
                    aRow.push($(this).text());
                }

                if (i == 6) {
                    aRow.push($(this).text());
                }
                if (i == 7) {
                    var tCostDiff = $(this).text()
                    if (tCostDiff == '') {
                        tCostDiff = 0
                    }
                    aRow.push(tCostDiff);
                }
                if (i == 8) {
                    aRow.push($(this).parents("tr").find(".xCNPdtEditInLine").val());
                }

                if (i == 9) {
                    if($(this).text() == ''){
                        aRow.push(1);
                    }else{
                        aRow.push(0);
                    }
                }

                if (i == 11) {
                    aRow.push($(this).text());
                }
                if (i == 12) {
                    aRow.push($(this).text());
                }

            });

            if(aRow.length != 0){
                aData.push(aRow);
            }
            
        }

    });
    return aData;
}

// Functionality: เปลี่ยนหน้า Pagenation หน้า Table List Document
// Parameters: Event Click Pagenation
// Creator: 03/03/2021
// Return: View
// ReturnType : View
function JSvADCClickPage(ptPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                nPageOld = $(".xWPageADCPdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWPageADCPdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvADCCallPageDataTable(nPageCurrent);
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : validate Code (validate ขั้นที่ 2 ตรวจสอบรหัสเอกสาร)
//Parameters : -
//Creator : 03/03/2021 Non
//Update : -
//Return : -
//Return Type : -
function JSxValidateADCCodeDublicate() {
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            tTableName: "TCNTPdtAdjCostHD",
            tFieldName: "FTXchDocNo",
            tCode: $("#oetADCDocNo").val()
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var aResult = JSON.parse(tResult);
            $("#ohdADCCheckDuplicateCode").val(aResult["rtCode"]);
            if ($("#ohdCheckADCClearValidate").val() != 1) {
                $('#ofmADCFormAdd').validate().destroy();
            }
            $.validator.addMethod('dublicateCode', function(value, element) {
                if ($("#ohdADCRoute").val() == "docADCEventAdd") {
                    if ($('#ocbADCStaAutoGenCode').is(':checked')) {
                        return true;
                    } else {
                        if ($("#ohdADCCheckDuplicateCode").val() == 1) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                } else {
                    return true;
                }
            });
            $('#ofmADCFormAdd').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetADCDocNo: {
                        "dublicateCode": {}
                    }
                },
                messages: {
                    oetADCDocNo: {
                        "dublicateCode": "ไม่สามารถใช้รหัสเอกสารนี้ได้"
                    }
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
                invalidHandler: function(event, validator) {
                    if ($("#ohdCheckADCSubmitByButton").val() == 1) {
                        FSvCMNSetMsgWarningDialog("<p>โปรดระบุข้อมูลให้สมบูรณ์</p>");
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-error");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').removeClass("has-error");
                },
                submitHandler: function(form) {
                    if ($('#ohdCheckADCSubmitByButton').val() == 1) {
                        JSxADCSubmitEventByButton();
                    }
                }
            });
            if ($("#ohdCheckADCClearValidate").val() != 1) {
                $("#ofmADCFormAdd").submit();
                $("ohdCheckADCClearValidate").val(1);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}