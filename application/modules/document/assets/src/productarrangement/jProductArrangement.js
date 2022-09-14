var nPAMStaPAMBrowseType = $("#oetPAMStaBrowse").val();
var tPAMCallPAMBackOption = $("#oetPAMCallBackOption").val();
var tPAMSesSessionID = $("#ohdSesSessionID").val();
var tPAMSesSessionName = $("#ohdSesSessionName").val();

$("document").ready(function() {
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    if (typeof(nPAMStaPAMBrowseType) != 'undefined' && (nPAMStaPAMBrowseType == 0 || nPAMStaPAMBrowseType ==2)) { // Event Click Navigater Title (คลิก Title ของเอกสาร)
        if (nPAMStaPAMBrowseType == 0) {
            localStorage.tCheckBackStage = '';
        }
        $('#oliPAMTitle').unbind().click(function() {
            localStorage.tCheckBackStage = '';
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPAMCallPageList();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtPAMCallBackPage').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                //กดปุ่มย้อนกลับ ไปหน้าจอตรวจสอบสถานะเอกสารโอน
                if(localStorage.tCheckBackStage == 'monDocTransfer'){
                    var tRoute = 'monSDT/1/0';
                    JSxBackStage(tRoute);
                }else{ //กลับสู่หน้า List
                    JSvPAMCallPageList();
                }
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtPAMCallPageAdd').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPAMCallPageAddDoc();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Cancel Document
        $('#obtPAMCancelDoc').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSnPAMCancelDocument(false);
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Appove Document
        $('#obtPAMApproveDoc').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {

                // var tCheckIteminTable = $('#otbPAMDocPdtAdvTableList .xWPdtItem').length;
                // if (tCheckIteminTable > 0) {
                    JCNxOpenLoading();
                    JSxPAMSubmitEventByButton('approve');
                    JSxPAMSetStatusClickSubmit(2);
                    // JSxPAMApproveDocument(false);
                // } else {
                //     FSvCMNSetMsgWarningDialog($('#ohdPAMValidatePdt').val());
                // }

            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From Document
        $('#obtPAMSubmitFromDoc').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                var tFrmSplName = $('#oetPAMFrmSplName').val();
                var tPAMFrmWahName = $('#oetPAMFrmWahName').val();
                var tCheckIteminTable = $('#otbPAMDocPdtAdvTableList .xWPdtItem').length;
                var nPOStaValidate = $('.xPOStaValidate0').length;
                if (tCheckIteminTable > 0) {
                    JSxPAMSetStatusClickSubmit(1);
                    $('#obtPAMSubmitDocument').click();
                } else {
                    FSvCMNSetMsgWarningDialog($('#ohdPAMValidatePdt').val());
                }
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        
        JSxPAMNavDefult('showpage_list');
        switch(nPAMStaPAMBrowseType){
            case '2':
                var tDocNo = $('#oetPAMJumpDocNo').val();
                JSvPAMCallPageEdit(tDocNo);
            break;
            default:
                JSvPAMCallPageList();
        }
    } else {

        JSxPAMNavDefult('showpage_list');
        JSvPAMCallPageAddDoc();
    }
});

//กดปุ่มย้อนกลับ ถ้ามาจาก "หน้าจออื่นที่ไม่ใช่หน้าตัวเอง" เวลาย้อนกลับต้องกลับไปหน้าจอเดิม
function JSxBackStage(ptRoute){
    $.ajax({
        type    : "GET",
        url     : ptRoute,
        cache   : false,
        timeout : 5000,
        success : function (tResult) {
            $(window).scrollTop(0);
            $('.odvMainContent').html(tResult);

            //เก็บเอาไว้ว่า มาจากหน้าจอจัดการใบสั่งสินค้าจากสาขา
            localStorage.tCheckBackStage = '';
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// อนุมัติเอกสาร
function JSxPAMApproveDocument(pbIsConfirm) { /*a*/
    var nStaSession = 1;
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        try {
            if (pbIsConfirm) {
                $("#odvPAMModalAppoveDoc").modal('hide');
                var tDocNo      = $('#oetPAMDocNo').val();
                var tBchCode    = $('#ohdPAMBchCode').val();
                var tAlwQtyPickNotEqQtyOrd = $('#ohdPAMAlwQtyPickNotEqQtyOrd').val();
                // return;

                // var tRefInDocNo = $('#oetPAMRefDocIntName').val();
                $.ajax({
                    type: "POST",
                    url: "docPAMApproveDocument",
                    data: {
                        tDocNo                  : tDocNo,
                        tBchCode                : tBchCode,
                        tAlwQtyPickNotEqQtyOrd  : tAlwQtyPickNotEqQtyOrd,
                        tDocType                : $('#ohdPAMDocType').val()
                        // ,tRefInDocNo: tRefInDocNo
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        // $("#odvPAMModalAppoveDoc").modal("hide");
                        // $('.modal-backdrop').remove();
                        var aReturnData = JSON.parse(tResult);
                        var tMessageError = aReturnData['tStaMessg'];
                        if (aReturnData['nStaEvent'] == '1') {
                            // JSoPAMCallSubscribeMQ();
                            JSvPAMCallPageEdit(tDocNo);
                        } else if( aReturnData['nStaEvent'] == '800' ) {
                            setTimeout(function(){
                                FSvCMNSetMsgWarningDialog(tMessageError,'JSvPAMCallPageEdit',tDocNo);
                                JCNxCloseLoading();
                            }, 500);
                        } else {
                            setTimeout(function(){
                                FSvCMNSetMsgErrorDialog(tMessageError);
                                JCNxCloseLoading();
                            }, 500);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $("#odvPAMModalAppoveDoc").modal('show');
            }
        } catch (err) {
            console.log("JSxPAMApproveDocument Error: ", err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}


// Control เมนู
function JSxPAMNavDefult(ptType) {
    if (ptType == 'showpage_list') { // แสดง
        $("#oliPAMTitle").show();
        $("#odvPAMBtnGrpInfo").show();
        $("#obtPAMCallPageAdd").show();

        // ซ่อน
        $("#oliPAMTitleAdd").hide();
        $("#oliPAMTitleEdit").hide();
        $("#oliPAMTitleDetail").hide();
        $("#oliPAMTitleAprove").hide();
        $("#odvBtnAddEdit").hide();
        $("#obtPAMCallBackPage").hide();
        $("#obtPAMPrintDoc").hide();
        $("#obtPAMCancelDoc").hide();
        $("#obtPAMApproveDoc").hide();
        $("#odvPAMBtnGrpSave").hide();
        $("#obtPAMUpdateDoc").hide();

    } else if (ptType == 'showpage_add') { // แสดง
        $("#oliPAMTitle").show();
        $("#odvPAMBtnGrpSave").show();
        $("#obtPAMCallBackPage").show();
        $("#oliPAMTitleAdd").show();

        // ซ่อน
        $("#oliPAMTitleEdit").hide();
        $("#oliPAMTitleDetail").hide();
        $("#oliPAMTitleAprove").hide();
        $("#odvBtnAddEdit").hide();
        $("#obtPAMPrintDoc").hide();
        $("#obtPAMCancelDoc").hide();
        $("#obtPAMApproveDoc").hide();
        $("#odvPAMBtnGrpInfo").hide();
        $("#obtPAMUpdateDoc").hide();
    } else if (ptType == 'showpage_edit') { // แสดง
        $("#oliPAMTitle").show();
        $("#odvPAMBtnGrpSave").show();
        $("#obtPAMApproveDoc").show();
        $("#obtPAMCancelDoc").show();
        $("#obtPAMCallBackPage").show();
        $("#oliPAMTitleEdit").show();
        $("#obtPAMPrintDoc").show();
        $("#obtPAMUpdateDoc").show();

        // ซ่อน
        $("#oliPAMTitleAdd").hide();
        $("#oliPAMTitleDetail").hide();
        $("#oliPAMTitleAprove").hide();
        $("#odvBtnAddEdit").hide();
        $("#odvPAMBtnGrpInfo").hide();
    }

    // ล้างค่า
    localStorage.removeItem('IV_LocalItemDataDelDtTemp');
    localStorage.removeItem('LocalItemData');
}

// Function: Call Page List
function JSvPAMCallPageList() {
    $.ajax({
        type: "GET",
        url: "docPAMFormSearchList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $("#odvPAMContentPageDocument").html(tResult);
            JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
            JSxPAMNavDefult('showpage_list');
            JSvPAMCallPageDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Call Page DataTable
function JSvPAMCallPageDataTable(pnPage) {
    JCNxOpenLoading();
    // var oAdvanceSearch = JSoPAMGetAdvanceSearchData();

    var oPAMAdvSearch = {
        'oetPAMSearchAllDocument'   : $('#oetPAMSearchAllDocument').val().trim(),
        'oetPAMBchCode'             : $('#oetPAMBchCode').val(),
        'oetPAMBchName'             : $('#oetPAMBchName').val(),
        'oetPAMPlcCode'             : $('#oetPAMPlcCode').val(),
        'oetPAMPlcName'             : $('#oetPAMPlcName').val(),

        'tSearchCat1Code'           : $("#oetPAMCat1Code").val(),
        'tSearchCat1Name'           : $("#oetPAMCat1Name").val(),
        'tSearchCat2Code'           : $("#oetPAMCat2Code").val(),
        'tSearchCat2Name'           : $("#oetPAMCat2Name").val(),
        'tSearchCat3Code'           : $("#oetPAMCat3Code").val(),
        'tSearchCat3Name'           : $("#oetPAMCat3Name").val(),
        'tSearchCat4Code'           : $("#oetPAMCat4Code").val(),
        'tSearchCat4Name'           : $("#oetPAMCat4Name").val(),
        'tSearchCat5Code'           : $("#oetPAMCat5Code").val(),
        'tSearchCat5Name'           : $("#oetPAMCat5Name").val(),
        
        'oetPAMDocDateFrm'          : $('#oetPAMDocDateFrm').val(),
        'oetPAMDocDateTo'           : $('#oetPAMDocDateTo').val(),

        'ocmPAMPackType'            : $('#ocmPAMPackType').val(),
        'ocmPAMStaDoc'              : $('#ocmPAMStaDoc').val(),
    };
    localStorage.setItem("oPAMAdvSearch", JSON.stringify(oPAMAdvSearch));

    var oAdvanceSearch = {
        tSearchAll          : $("#oetPAMSearchAllDocument").val().trim(),
        tSearchBchCode      : $("#oetPAMBchCode").val(),
        tSearchPlcCode      : $("#oetPAMPlcCode").val(),
        tSearchCat1Code     : $("#oetPAMCat1Code").val(),
        tSearchCat1Name     : $("#oetPAMCat1Name").val(),
        tSearchCat2Code     : $("#oetPAMCat2Code").val(),
        tSearchCat2Name     : $("#oetPAMCat2Name").val(),
        tSearchCat3Code     : $("#oetPAMCat3Code").val(),
        tSearchCat3Name     : $("#oetPAMCat3Name").val(),
        tSearchCat4Code     : $("#oetPAMCat4Code").val(),
        tSearchCat4Name     : $("#oetPAMCat4Name").val(),
        tSearchCat5Code     : $("#oetPAMCat5Code").val(),
        tSearchCat5Name     : $("#oetPAMCat5Name").val(),
        tSearchDocDateFrm   : $("#oetPAMDocDateFrm").val(),
        tSearchDocDateTo    : $("#oetPAMDocDateTo").val(),
        tSearchStaDoc       : $("#ocmPAMStaDoc").val(),
        tSearchPackType     : $("#ocmPAMPackType").val()
    };
    // console.log(oAdvanceSearch);

    var nPageCurrent = pnPage;
    if (typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type: "POST",
        url: "docPAMDataTable",
        data: {
            oAdvanceSearch  : oAdvanceSearch,
            nPageCurrent    : nPageCurrent
        },
        cache: false,
        timeout: 0,
        success: function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                $('#ostPAMDataTableDocument').html(aReturnData['tPAMViewDataTableList']);
            } else {
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// รวม Values ต่างๆของการค้นหาขั้นสูง
// function JSoPAMGetAdvanceSearchData() {
//     var oAdvanceSearchData = {
//         tSearchAll: $("#oetPAMSearchAllDocument").val(),
//         tSearchBchCodeFrom: $("#oetPAMAdvSearchBchCodeFrom").val(),
//         tSearchBchCodeTo: $("#oetPAMAdvSearchBchCodeTo").val(),
//         tSearchDocDateFrom: $("#oetPAMAdvSearcDocDateFrom").val(),
//         tSearchDocDateTo: $("#oetPAMAdvSearcDocDateTo").val(),
//         tSearchStaDoc: $("#ocmPAMAdvSearchStaDoc").val(),
//         tSearchStaDocAct: $("#ocmStaDocAct").val()
//     };
//     return oAdvanceSearchData;
// }

// เข้ามาแบบ insert
function JSvPAMCallPageAddDoc() {
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "docPAMPageAdd",
        cache: false,
        timeout: 0,
        success: function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxPAMNavDefult('showpage_add');
                $('#odvPAMContentPageDocument').html(aReturnData['tPAMViewPageAdd']);
                $("#ocmPAMTypePayment").val("1").selectpicker('refresh');
                $('.xCNPanel_CreditTerm').hide();

                window.scrollTo(0, 0);

                JSvPAMLoadPdtDataTableHtml();
                JCNxLayoutControll();
            } else {
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// เข้าหน้าแบบ แก้ไข
function JSvPAMCallPageEdit(ptDocumentNumber) { /* , pnPAMPayType, pnPAMVatInOrEx, pnPAMStaRef */
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docPAMPageEdit",
            data: {
                'ptPAMDocNo': ptDocumentNumber
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturnData = JSON.parse(tResult)
                console.log(aReturnData);
                if( aReturnData['nStaEvent'] == '1' ){
                    JSxPAMNavDefult('showpage_edit');
                    $('#odvPAMContentPageDocument').html(aReturnData['tViewPageEdit']);

                    window.scrollTo(0, 0);
                    JSvPAMLoadPdtDataTableHtml();

                    // เช็คว่าเอกสารยกเลิก หรือเอกสารอนุมัติ
                    JSxPAMControlFormWhenCancelOrApprove();
                }else{
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
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

// Control ปุ่ม และอินพุตต่างๆ [เอกสารยกเลิก / เอกสารอนุมัติ]
function JSxPAMControlFormWhenCancelOrApprove() {
    var tStatusDoc  = $('#ohdPAMStaDoc').val();
    var tStatusApv  = $('#ohdPAMStaApv').val();
    var tStaDocAuto = $('#ohdPAMStaDocAuto').val();

    // control ฟอร์ม
    if( tStatusDoc == 3 || (tStatusDoc == 1 && tStatusApv == 1) || tStaDocAuto == '1' ){
        // ปุ่มเลือก
        $('.xCNBtnBrowseAddOn').addClass('disabled');
        $('.xCNBtnBrowseAddOn').attr('disabled', true);

        // ปุ่มเวลา
        $('.xCNBtnDateTime').addClass('disabled');
        $('.xCNBtnDateTime').attr('disabled', true);

        // เพิ่มข้อมูลสินค้า
        $('.xCNHideWhenCancelOrApprove').hide();

        // ปุ่มยกเลิก
        $('#obtPAMCancelDoc').hide();

        // ปุ่มอนุมัติ
        $('#obtPAMApproveDoc').hide();

        // ปุ่มบันทึก
        $('.xCNBTNSaveDoc').show();

        JCNxPAMControlObjAndBtn();
    }

    if( tStatusDoc == '1' && tStatusApv != '1' && tStaDocAuto == '1' ){
        // ปุ่มยกเลิก
        $('#obtPAMCancelDoc').show();

        // ปุ่มอนุมัติ
        $('#obtPAMApproveDoc').show();
    } 

    // กรณีอนุมัติเอกสารแล้ว จะเปิดปุ่ม ปรับปรุงข้อมูล เพื่อปรับสถานะเอกสารเป็นรออนุมัติ และให้แก้ไขจำนวนจัดได้อีกครั้ง
    if( tStatusDoc == 1 && tStatusApv == 1 ){
        // $("#obtPAMUpdateDoc").show();
        // ปุ่มยกเลิก
        $('#obtPAMCancelDoc').show();
    }
    // else{
        // $("#obtPAMUpdateDoc").hide();
    // }

    // control ปุ่ม
    // if (tStatusDoc == 3) {
    //     // เอกสารยกเลิก
    //     // ปุ่มยกเลิก
    //     $('#obtPAMCancelDoc').hide();

    //     // ปุ่มอนุมัติ
    //     $('#obtPAMApproveDoc').hide();

    //     // ปุ่มบันทึก
    //     $('.xCNBTNSaveDoc').show();

    //     JCNxPAMControlObjAndBtn();

    // } else if (tStatusDoc == 1 && tStatusApv == 1) {
    //     // เอกสารอนุมัติแล้ว
    //     // ปุ่มยกเลิก
    //     $('#obtPAMCancelDoc').hide();

    //     // ปุ่มอนุมัติ
    //     $('#obtPAMApproveDoc').hide();

    //     // ปุ่มบันทึก
    //     $('.xCNBTNSaveDoc').show();

    //     JCNxPAMControlObjAndBtn();
    // }
}

// Function : Call Page Product Table In Add Document
function JSvPAMLoadPdtDataTableHtml(pnPage) {
    if ($("#ohdPAMRoute").val() == "docPAMEventAdd") {
        var tPAMDocNo = "";
    } else {
        var tPAMDocNo = $("#oetPAMDocNo").val();
    }
    var tPAMStaApv = $("#ohdPAMStaApv").val();
    var tPAMStaDoc = $("#ohdPAMStaDoc").val();
    var tPAMVATInOrEx = $("#ocmPAMFrmSplInfoVatInOrEx").val();

    // เช็ค สินค้าใน table หน้านั้นๆ หรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
    if ($("#otbPAMDocPdtAdvTableList .xWPdtItem").length == 0) {
        if (pnPage != undefined) {
            pnPage = pnPage - 1;
        }
    }

    if (pnPage == '' || pnPage == null) {
        var pnNewPage = 1;
    } else {
        var pnNewPage = pnPage;
    }
    var nPageCurrent = pnNewPage;
    var tSearchPdtAdvTable = $('#oetPAMFrmFilterPdtHTML').val();

    if (tPAMStaApv == 2) {
        $('#obtPAMDocBrowsePdt').hide();
        $('#obtPAMPrintDoc').hide();
        $('#obtPAMCancelDoc').hide();
        $('#obtPAMApproveDoc').hide();
        $('#odvPAMBtnGrpSave').hide();
    }

    $.ajax({
        type: "POST",
        url: "docPAMPdtAdvanceTableLoadData",
        data: {
            'tSelectBCH': $('#oetPAMBchCode').val(),
            'ptSearchPdtAdvTable': tSearchPdtAdvTable,
            'ptPAMDocNo': tPAMDocNo,
            'ptPAMStaApv': tPAMStaApv,
            'ptPAMStaDoc': tPAMStaDoc,
            'ptPAMVATInOrEx': tPAMVATInOrEx,
            'pnPAMPageCurrent': nPageCurrent,
            'ptPAMDocType' : $('#ohdPAMDocType').val()
        },
        cache: false,
        Timeout: 0,
        success: function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['checksession'] == 'expire') {
                JCNxShowMsgSessionExpired();
            } else {
                if (aReturnData['nStaEvent'] == '1') {
                    $('#odvPAMDataPanelDetailPDT #odvPAMDataPdtTableDTTemp').html(aReturnData['tPAMPdtAdvTableHtml']);
                    if ($('#ohdPAMStaImport').val() == 1) {
                        $('.xPAMImportDT').show();
                    }
                    JCNxCloseLoading();
                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JSvPAMLoadPdtDataTableHtml(pnPage)
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function : Add Product Into Table Document DT Temp
function JCNvPAMBrowsePdt() {
    var tPAMSplCode = $('#oetPAMFrmSplCode').val();

    if (typeof(tPAMSplCode) !== undefined && tPAMSplCode !== '') {
        var aMulti = [];
        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                Qualitysearch: [],
                PriceType: [
                    "Cost", "tCN_Cost", "Company", "1"
                ],
                SelectTier: ["Barcode"],
                ShowCountRecord: 10,
                NextFunc: "FSvPAMNextFuncB4SelPDT",
                ReturnType: "M",
                'aAlwPdtType' : ['T1','T3','T4','T5','T6','S2','S3','S4']
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvModalPAMCPDT").modal({ backdrop: "static", keyboard: false });
                $("#odvModalPAMCPDT").modal({ show: true });
                // remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                $("#odvModalsectionBodyPDT").html(tResult);
                $("#odvModalPAMCPDT #oliBrowsePDTSupply").css('display', 'none');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
        FSvCMNSetMsgWarningDialog(tWarningMessage);
        return;
    }
}

function JSvPAMPAMCFilterPdtInTableTemp() {
    JCNxOpenLoading();
    JSvPOLoadPdtDataTableHtml();
}

// Function Chack Value LocalStorage
function JStPAMFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

function JSxPAMSetStatusClickSubmit(pnStatus) {
    $("#ohdPAMCheckSubmitByButton").val(pnStatus);
}

// Add/Edit Document
function JSxPAMAddEditDocument() { // var nStaSession = JCNxFuncChkSessionExpired();
    var nStaSession = 1;
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JSxPAMValidateFormDocument();
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Event Single Delete Document Single
function JSoPAMDelDocSingle(ptCurrentPage, ptPAMDocNo, tBchCode){ /*, ptPAMRefInCode*/
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        if (typeof(ptPAMDocNo) != undefined && ptPAMDocNo != "") {
            var tTextConfrimDelSingle = $('#oetTextComfirmDeleteSingle').val() + "&nbsp" + ptPAMDocNo + "&nbsp" + $('#oetTextComfirmDeleteYesOrNot').val();
            $('#odvPAMModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
            $('#odvPAMModalDelDocSingle').modal('show');
            $('#odvPAMModalDelDocSingle #osmConfirmDelSingle').unbind().click(function() {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docPAMEventDelete",
                    data: {
                        'tDataDocNo'        : ptPAMDocNo,
                        'tBchCode'          : tBchCode,
                        // 'tPAMRefInCode'     : ptPAMRefInCode
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvPAMModalDelDocSingle').modal('hide');
                            $('#odvPAMModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                JSvPAMCallPageDataTable(ptCurrentPage);
                            }, 500);
                        } else {
                            JCNxCloseLoading();
                            FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        } else {
            FSvCMNSetMsgErrorDialog('Error Not Found Document Number !!');
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Event Single Delete Doc Mutiple
function JSoPAMDelDocMultiple() {
    var aDataDelMultiple = $('#odvPAMModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
    var aTextsDelMultiple = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
    var aDataSplit = aTextsDelMultiple.split(" , ");
    var nDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];
    for ($i = 0; $i < nDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }
    if (nDataSplitlength > 1) {

        JCNxOpenLoading();
        $('.ocbListItem:checked').each(function() {
            var tDataDocNo = $(this).val();
            var tBchCode = $(this).data('bchcode');
            var tPAMRefInCode = $(this).data('refcode');
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type: "POST",
                url: "docPAMEventDelete",
                data: {
                    'tDataDocNo': tDataDocNo,
                    'tBchCode': tBchCode,
                    'tPAMRefInCode': tPAMRefInCode
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if (aReturnData['nStaEvent'] == '1') {
                        setTimeout(function() {
                            $('#odvPAMModalDelDocMultiple').modal('hide');
                            $('#odvPAMModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                            $('#odvPAMModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                            $('.modal-backdrop').remove();
                            localStorage.removeItem('LocalItemData');
                            JSvPAMCallPageList();
                        }, 1000);
                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        });


    }
}

// Function: Function Chack And Show Button Delete All
function JSxPAMShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliPAMBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliPAMBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliPAMBtnDeleteAll").addClass("disabled");
        }
    }
}

// Function: Function Chack Value LocalStorage
function JStPAMFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

// Function: Cancel Document PAM
function JSnPAMCancelDocument(pbIsConfirm) {
    var tPAMDocNo = $("#oetPAMDocNo").val();
    if (pbIsConfirm) {
        $.ajax({
            type: "POST",
            url: "docPAMCancelDocument",
            data: {
                'ptPAMDocNo'    : tPAMDocNo,
                'ptPAMDocType'  : $('#ohdPAMDocType').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvPAMPopupCancel").modal("hide");
                $('.modal-backdrop').remove();
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSvPAMCallPageEdit(tPAMDocNo);
                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        $('#odvPAMPopupCancel').modal({ backdrop: 'static', keyboard: false });
        $("#odvPAMPopupCancel").modal("show");
    }
}

// Function: Function Control Object Button
function JCNxPAMControlObjAndBtn() { // Check สถานะอนุมัติ
    var nPAMStaDoc  = $("#ohdPAMStaDoc").val();
    var nPAMStaApv  = $("#ohdPAMStaApv").val();
    var tStaDocAuto = $('#ohdPAMStaDocAuto').val();

    // Status Cancel
    if ( (nPAMStaDoc == '3') || (nPAMStaDoc == '1' && nPAMStaApv == '1') || tStaDocAuto == '1' ) {
        $("#oliPAMTitleAdd").hide();
        $('#oliPAMTitleEdit').hide();
        $('#oliPAMTitleDetail').show();
        $('#oliPAMTitleAprove').hide();
        $('#oliPAMTitleConimg').hide();
        // Hide And Disabled
        $("#obtPAMCallPageAdd").hide();
        $("#obtPAMCancelDoc").hide(); // attr("disabled",true);
        $("#obtPAMApproveDoc").hide(); // attr("disabled",true);
        $("#obtPAMBrowseSupplier").attr("disabled", true);

        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetPAMFrmSearchPdtHTML").attr("disabled", false);
        $('#odvPAMBtnGrpSave').show();
        $("#oliPAMEditShipAddress").hide();
        $("#oliPAMEditTexAddress").hide();
        $("#oliPAMTitleDetail").show();
        $('.xControlForm').attr('readonly', true);
        $('.xWPAMDisabledOnApv').attr('disabled', true);
        $("#ocbPAMFrmInfoOthStaDocAct").attr("readonly", true);
        $("#obtPAMFrmBrowseShipAdd").attr("disabled", true);
        $("#obtPAMFrmBrowseTaxAdd").attr("disabled", true);


    }

    // Status Appove Success
    // if (nPAMStaDoc == 1 && nPAMStaApv == 1) { // Hide/Show Menu Title
    //     $("#oliPAMTitleAdd").hide();
    //     $('#oliPAMTitleEdit').hide();
    //     $('#oliPAMTitleDetail').show();
    //     $('#oliPAMTitleAprove').hide();
    //     $('#oliPAMTitleConimg').hide();
    //     // Hide And Disabled
    //     $("#obtPAMCallPageAdd").hide();
    //     $("#obtPAMCancelDoc").hide(); // attr("disabled",true);
    //     $("#obtPAMApproveDoc").hide(); // attr("disabled",true);
    //     $("#obtPAMBrowseSupplier").attr("disabled", true);

    //     $(".xCNBtnDateTime").attr("disabled", true);
    //     $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
    //     $(".xCNDocDrpDwn").hide();
    //     $("#oetPAMFrmSearchPdtHTML").attr("disabled", false);
    //     $('#odvPAMBtnGrpSave').show();
    //     $("#oliPAMEditShipAddress").hide();
    //     $("#oliPAMEditTexAddress").hide();
    //     $("#oliPAMTitleDetail").show();
    //     $('.xControlForm').attr('readonly', true);
    //     $('.xWPAMDisabledOnApv').attr('disabled', true);
    //     $("#ocbPAMFrmInfoOthStaDocAct").attr("readonly", true);
    //     $("#obtPAMFrmBrowseShipAdd").attr("disabled", true);
    //     $("#obtPAMFrmBrowseTaxAdd").attr("disabled", true);
    // }
}