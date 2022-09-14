<script>
var nTRBStaDOBrowseType = $("#oetTRBStaBrowse").val();
var tTRBCallDOBackOption = $("#oetTRBCallBackOption").val();
var tTRBSesSessionID = $("#ohdSesSessionID").val();
var tTRBSesSessionName = $("#ohdSesSessionName").val();

$("document").ready(function() {
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    if (typeof(nTRBStaDOBrowseType) != 'undefined' && (nTRBStaDOBrowseType == 0 || nTRBStaDOBrowseType==2 )) { // Event Click Navigater Title (คลิก Title ของเอกสาร)
        if (nTRBStaDOBrowseType == 0) {
            localStorage.tCheckBackStage = '';
        }
        $('#oliTRBTitle').unbind().click(function() {
            localStorage.tCheckBackStage = '';
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvTRBCallPageList();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtTRBCallBackPage').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                //กดปุ่มย้อนกลับ ถ้ามาจาก "หน้าจอจัดการใบสั่งสินค้าจากสาขา" เวลาย้อนกลับต้องกลับไปหน้าจอเดิม
                if (localStorage.tCheckBackStage != '') {
                    if(localStorage.tCheckBackStage == 'PageMangeDocOrderBCH'){
                        var tRoute = 'docMngDocPreOrdB/0/0';
                    }else if(localStorage.tCheckBackStage = 'monDocTransfer'){
                        var tRoute = 'monSDT/1/0';
                    }
                    JSxBackStageToMangeDocOrderBCH(tRoute);
                }else{ //กลับสู่หน้า List
                    JSvTRBCallPageList();
                }
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtTRBCallPageAdd').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvTRBCallPageAddDoc();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Cancel Document
        $('#obtTRBCancelDoc').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSnTRBCancelDocument(false);
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Appove Document
        $('#obtTRBApproveDoc').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                var tCheckIteminTable = $('#otbTRBDocPdtAdvTableList .xWPdtItem').length;
                if (tCheckIteminTable > 0) {
                    JSxTRBSetStatusClickSubmit(2);
                    JSxTRBApproveDocument(false);
                } else {
                    FSvCMNSetMsgWarningDialog($('#ohdTRBValidatePdt').val());
                }
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From Document
        $('#obtTRBSubmitFromDoc').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {

                var tTRBFrmBchCode     = $('#oetTRBFrmBchCode').val();
                var tTRBAgnCode        = $('#oetTRBAgnCode').val();
                var tTRBFrmBchCodeTo   = $('#oetTRBFrmBchCodeTo').val();
                var tTRBFrmBchCodeShip = $('#oetTRBFrmBchCodeShip').val();
                var tTRBFrmWahCodeTo   = $('#oetTRBFrmWahCodeTo').val();
                var tTRBFrmWahCodeShip = $('#oetTRBFrmWahCodeShip').val();
                var tTRBReasonCode     = $('#oetTRBReasonCode').val();
                var tTRBStaDoc         = $('#ohdTRBStaDoc').val();

                var tCheckIteminTable = $('#otbTRBDocPdtAdvTableList .xWPdtItem').length;
       
                if (tCheckIteminTable > 0) {
                    if (tTRBStaDoc != 3) {
                        // alert(tCheckIteminTable);

                        // if(tTRBAgnCode==''){
                        //     FSvCMNSetMsgWarningDialog('<?php //echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsSelectAgnFrom'); ?>');
                        //     return;
                        // }
                        if(tTRBFrmBchCode==''){
                            FSvCMNSetMsgWarningDialog('<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsSelectBchFrom'); ?>');
                            return;
                        }
                        if(tTRBFrmBchCodeTo==''){
                            FSvCMNSetMsgWarningDialog('<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsSelectBchTo'); ?>');
                            return;
                        }
                        if(tTRBFrmWahCodeTo==''){
                            FSvCMNSetMsgWarningDialog('<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsSelectWahTo'); ?>');
                            return;
                        }
                        if(tTRBFrmBchCodeShip==''){
                            FSvCMNSetMsgWarningDialog('<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsSelectBchShip'); ?>');
                            return;
                        }
                        if(tTRBFrmWahCodeShip==''){
                            FSvCMNSetMsgWarningDialog('<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsSelectWahShip'); ?>');
                            return;
                        }
                        if(tTRBReasonCode==''){
                            FSvCMNSetMsgWarningDialog('<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsSelectReason'); ?>');
                            return;
                        }

                        JSxTRBSetStatusClickSubmit(1);
                        $('#obtTRBSubmitDocument').click();
                    } else {
                        JSxTRBSetStatusClickSubmit(1);
                        $('#obtTRBSubmitDocument').click();
                    }

                } else {
                    FSvCMNSetMsgWarningDialog($('#ohdTRBValidatePdt').val());
                }
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        switch(nTRBStaDOBrowseType){
            case '2':
                JSxTRBNavDefult('showpage_edit');
                var tAgnCode = $('#oetTRBJumpAgnCode').val();
                var tBchCode = $('#oetTRBJumpBchCode').val();
                var tDocNo = $('#oetTRBJumpDocNo').val();
                JSvTRBCallPageEdit(tBchCode,tAgnCode,tDocNo);
            break;
            default:
                JSxTRBNavDefult('showpage_list');
                JSvTRBCallPageList();
        }
    } else {

        JSxTRBNavDefult('showpage_list');
        JSvTRBCallPageAddDoc();
    }
});

//กดปุ่มย้อนกลับ ถ้ามาจาก "หน้าจอจัดการใบสั่งสินค้าจากสาขา" เวลาย้อนกลับต้องกลับไปหน้าจอเดิม
function JSxBackStageToMangeDocOrderBCH(ptRoute){
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
function JSxTRBApproveDocument(pbIsConfirm) {
    var nStaSession = 1;
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        try {
            if (pbIsConfirm) {
                $("#odvTRBModalAppoveDoc").modal('hide');

                var tTRBDocNo = $('#oetTRBDocNo').val();
                var tAgnCode = $('#oetTRBAgnCode').val();
                var tBchCode = $('#oetTRBFrmBchCode').val();
                var tRefInTRBcNo = $('#oetTRBRefDocIntName').val();

                $.ajax({
                    type: "POST",
                    url: "docTRBApproveDocument",
                    data: {
                        tTRBDocNo: tTRBDocNo,
                        tAgnCode : tAgnCode,
                        tBchCode: tBchCode,
                        tRefInTRBcNo: tRefInTRBcNo
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        $("#odvTRBModalAppoveDoc").modal("hide");
                        $('.modal-backdrop').remove();
                        var aReturnData = JSON.parse(tResult);
                        if (aReturnData.nStaEvent == "1") {
                            //  FSvCMNSetMsgSucessDialog(oResult.tStaMessg);
                            JSvTRBCallPageEdit(tBchCode,tAgnCode,tTRBDocNo);
                                }else{
                            FSvCMNSetMsgWarningDialog(oResult.tStaMessg);
                            }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $("#odvTRBModalAppoveDoc").modal('show');
            }
        } catch (err) {
            console.log("JSxTRBApproveDocument Error: ", err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Rabbit MQ
function JSoTRBCallSubscribeMQ() {
    // RabbitMQ

    // Document variable
    var tLangCode = $("#ohdTRBLangEdit").val();
    var tUsrBchCode = $("#oetTRBFrmBchCode").val();
    var tUsrApv = $("#ohdSesSessionName").val();
    var tTRBcNo = $("#oetTRBDocNo").val();
    var tPrefix = "RESDO";
    var tStaApv = $("#ohdTRBStaApv").val();
    var tStaDelMQ = 1;
    var tQName = tPrefix + "_" + tTRBcNo + "_" + tUsrApv;

    // MQ Message Config
    var poDocConfig = {
        tLangCode: tLangCode,
        tUsrBchCode: tUsrBchCode,
        tUsrApv: tUsrApv,
        tTRBcNo: tTRBcNo,
        tPrefix: tPrefix,
        tStaDelMQ: tStaDelMQ,
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
        ptTRBcTableName: "TAPTTRBHD",
        ptTRBcFieldDocNo: "FTXphDocNo",
        ptTRBcFieldStaApv: "FTXphStaPrcStk",
        ptTRBcFieldStaDelMQ: "FTXphStaDelMQ",
        ptTRBcStaDelMQ: tStaDelMQ,
        ptTRBcNo: tTRBcNo
    };

    // Callback Page Control(function)
    var poCallback = {
        tCallPageEdit: "JSvTRBCallPageEdit",
        tCallPageList: "JSvTRBCallPageList"
    };

    // Check Show Progress %
    FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
}

// Control เมนู
function JSxTRBNavDefult(ptType) {
    if (ptType == 'showpage_list') { // แสดง
        $("#oliTRBTitle").show();
        $("#odvTRBBtnGrpInfo").show();
        $("#obtTRBCallPageAdd").show();

        // ซ่อน
        $("#oliTRBTitleAdd").hide();
        $("#oliTRBTitleEdit").hide();
        $("#oliTRBTitleDetail").hide();
        $("#oliTRBTitleAprove").hide();
        $("#odvBtnAddEdit").hide();
        $("#obtTRBCallBackPage").hide();
        $("#obtTRBPrintDoc").hide();
        $("#obtTRBCancelDoc").hide();
        $("#obtTRBApproveDoc").hide();
        $("#odvTRBBtnGrpSave").hide();

    } else if (ptType == 'showpage_add') { // แสดง
        $("#oliTRBTitle").show();
        $("#odvTRBBtnGrpSave").show();
        $("#obtTRBCallBackPage").show();
        $("#oliTRBTitleAdd").show();

        // ซ่อน
        $("#oliTRBTitleEdit").hide();
        $("#oliTRBTitleDetail").hide();
        $("#oliTRBTitleAprove").hide();
        $("#odvBtnAddEdit").hide();
        $("#obtTRBPrintDoc").hide();
        $("#obtTRBCancelDoc").hide();
        $("#obtTRBApproveDoc").hide();
        $("#odvTRBBtnGrpInfo").hide();
    } else if (ptType == 'showpage_edit') { // แสดง
        $("#oliTRBTitle").show();
        $("#odvTRBBtnGrpSave").show();
        $("#obtTRBApproveDoc").show();
        $("#obtTRBCancelDoc").show();
        $("#obtTRBCallBackPage").show();
        $("#oliTRBTitleEdit").show();
        $("#obtTRBPrintDoc").show();

        // ซ่อน
        $("#oliTRBTitleAdd").hide();
        $("#oliTRBTitleDetail").hide();
        $("#oliTRBTitleAprove").hide();
        $("#odvBtnAddEdit").hide();
        $("#odvTRBBtnGrpInfo").hide();
    }

    // ล้างค่า
    localStorage.removeItem('IV_LocalItemDataDelDtTemp');
    localStorage.removeItem('LocalItemData');
}

// Function: Call Page List
function JSvTRBCallPageList() {
    $.ajax({
        type: "GET",
        url: "docTRBFormSearchList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $("#odvTRBContentPageDocument").html(tResult);
            JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
            JSxTRBNavDefult('showpage_list');
            JSvTRBCallPageDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Call Page DataTable
function JSvTRBCallPageDataTable(pnPage) {
    JCNxOpenLoading();
    var oAdvanceSearch = JSoTRBGetAdvanceSearchData();
    var nPageCurrent = pnPage;
    if (typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type: "POST",
        url: "docTRBDataTable",
        data: {
            oAdvanceSearch: oAdvanceSearch,
            nPageCurrent: nPageCurrent
        },
        cache: false,
        timeout: 0,
        success: function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                $('#ostTRBDataTableDocument').html(aReturnData['tTRBViewDataTableList']);
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
function JSoTRBGetAdvanceSearchData() {
    var oAdvanceSearchData = {
        tSearchAll: $("#oetTRBSearchAllDocument").val(),
        tSearchBchCodeFrom: $("#oetTRBAdvSearchBchCodeFrom").val(),
        tSearchBchCodeTo: $("#oetTRBAdvSearchBchCodeTo").val(),
        tSearchDocDateFrom: $("#oetTRBAdvSearcDocDateFrom").val(),
        tSearchDocDateTo: $("#oetTRBAdvSearcDocDateTo").val(),
        tSearchStaDoc: $("#ocmTRBAdvSearchStaDoc").val(),
        tSearchStaDocAct: $("#ocmStaDocAct").val()
    };
    return oAdvanceSearchData;
}

// เข้ามาแบบ insert
function JSvTRBCallPageAddDoc() {
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "docTRBPageAdd",
        cache: false,
        timeout: 0,
        success: function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxTRBNavDefult('showpage_add');
                $('#odvTRBContentPageDocument').html(aReturnData['tTRBViewPageAdd']);
                JSvTRBLoadPdtDataTableHtml();
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
function JSvTRBCallPageEdit(ptBchCode,ptAgnCode,ptTRBcumentNumber) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docTRBPageEdit",
            data: {
                'ptBchCode' : ptBchCode,
                'ptAgnCode' : ptAgnCode,
                'ptTRBDocNo': ptTRBcumentNumber
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSxTRBNavDefult('showpage_edit');

                    $('#odvTRBContentPageDocument').html(aReturnData['tViewPageEdit']);
                    //สถานะอ้างอิง
                    var nTRBStaRef = $('#ohdTRBStaRef').val();
                    if (nTRBStaRef == 0) {
                        $("#ocmTRBFrmInfoOthRef").val("0").selectpicker('refresh');
                    } else if (nTRBStaRef == 1) {
                        $("#ocmTRBFrmInfoOthRef").val("1").selectpicker('refresh');
                    } else {
                        $("#ocmTRBFrmInfoOthRef").val("2").selectpicker('refresh');
                    }
                    JSvTRBLoadPdtDataTableHtml();
                    JCNxCloseLoading();

                    // เช็คว่าเอกสารยกเลิก หรือเอกสารอนุมัติ
                    JSxTRBControlFormWhenCancelOrApprove();
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
        JCNxShowMsgSessionExpired();
    }
}

// Control ปุ่ม และอินพุตต่างๆ [เอกสารยกเลิก / เอกสารอนุมัติ]
function JSxTRBControlFormWhenCancelOrApprove() {
    var tStatusDoc = $('#ohdTRBStaDoc').val();
    var tStatusApv = $('#ohdTRBStaApv').val();

    // control ฟอร์ม
    if (tStatusDoc == 3 || (tStatusDoc == 1 && tStatusApv == 1)) {
        // เอกสารยกเลิก
        // ปุ่มเลือก
        $('.xCNBtnBrowseAddOn').addClass('disabled');
        $('.xCNBtnBrowseAddOn').attr('disabled', true);

        // ปุ่มเวลา
        $('.xCNBtnDateTime').addClass('disabled');
        $('.xCNBtnDateTime').attr('disabled', true);

        // เพิ่มข้อมูลสินค้า
        $('.xCNHideWhenCancelOrApprove').hide();
    }

    // control ปุ่ม
    if (tStatusDoc == 3) {
        // เอกสารยกเลิก
        // ปุ่มยกเลิก
        $('#obtTRBCancelDoc').hide();

        // ปุ่มอนุมัติ
        $('#obtTRBApproveDoc').hide();

        // ปุ่มบันทึก
        $('.xCNBTNSaveDoc').show();

        JCNxTRBControlObjAndBtn();

    } else if (tStatusDoc == 1 && tStatusApv == 1) {
        // เอกสารอนุมัติแล้ว
        // ปุ่มยกเลิก
        $('#obtTRBCancelDoc').hide();

        // ปุ่มอนุมัติ
        $('#obtTRBApproveDoc').hide();

        // ปุ่มบันทึก
        $('.xCNBTNSaveDoc').show();

        JCNxTRBControlObjAndBtn();
    }
}

// Function : Call Page Product Table In Add Document
function JSvTRBLoadPdtDataTableHtml(pnPage) {
    if ($("#ohdTRBRoute").val() == "docTRBEventAdd") {
        var tTRBDocNo = "";
    } else {
        var tTRBDocNo = $("#oetTRBDocNo").val();
    }
    var tTRBStaApv = $("#ohdTRBStaApv").val();
    var tTRBStaDoc = $("#ohdTRBStaDoc").val();
    var tTRBVATInOrEx = $("#ohdTRBFrmSplInfoVatInOrEx").val();

    // เช็ค สินค้าใน table หน้านั้นๆ หรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
    if ($("#otbTRBDocPdtAdvTableList .xWPdtItem").length == 0) {
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
    var tSearchPdtAdvTable = $('#oetTRBFrmFilterPdtHTML').val();

    if (tTRBStaApv == 2) {
        $('#obtTRBDocBrowsePdt').hide();
        $('#obtTRBPrintTRBc').hide();
        $('#obtTRBCancelDoc').hide();
        $('#obtTRBApproveDoc').hide();
        $('#odvTRBBtnGrpSave').hide();
    }

    $.ajax({
        type: "POST",
        url: "docTRBPdtAdvanceTableLoadData",
        data: {
            'tSelectBCH': $('#oetTRBFrmBchCode').val(),
            'ptSearchPdtAdvTable': tSearchPdtAdvTable,
            'ptTRBDocNo': tTRBDocNo,
            'ptTRBStaApv': tTRBStaApv,
            'ptTRBStaDoc': tTRBStaDoc,
            'ptTRBVATInOrEx': tTRBVATInOrEx,
            'pnTRBPageCurrent': nPageCurrent
        },
        cache: false,
        Timeout: 0,
        success: function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['checksession'] == 'expire') {
                JCNxShowMsgSessionExpired();
            } else {
                if (aReturnData['nStaEvent'] == '1') {
                    $('#odvTRBDataPanelDetailPDT #odvTRBDataPdtTableDTTemp').html(aReturnData['tTRBPdtAdvTableHtml']);
                    if ($('#ohdTRBStaImport').val() == 1) {
                        $('.xTRBImportDT').show();
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
            JSvTRBLoadPdtDataTableHtml(pnPage)
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function : Add Product Into Table Document DT Temp
function JCNvTRBBrowsePdt() {
    var tTRBSplCode = $('#oetTRBFrmSplCode').val();

    if (typeof(tTRBSplCode) !== undefined && tTRBSplCode !== '') {
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
                NextFunc: "FSvTRBNextFuncB4SelPDT",
                ReturnType: "M",
                'aAlwPdtType' : ['T1','T3','T4','T5','T6','S2','S3','S4']
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvModalDOCPDT").modal({ backdrop: "static", keyboard: false });
                $("#odvModalDOCPDT").modal({ show: true });
                // remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                $("#odvModalsectionBodyPDT").html(tResult);
                $("#odvModalDOCPDT #oliBrowsePDTSupply").css('display', 'none');
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

function JSvTRBDOCFilterPdtInTableTemp() {
    JCNxOpenLoading();
    JSvPOLoadPdtDataTableHtml();
}

// Function Chack Value LocalStorage
function JStTRBFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

function JSxTRBSetStatusClickSubmit(pnStatus) {
    $("#ohdTRBCheckSubmitByButton").val(pnStatus);
}

// Add/Edit Document
function JSxTRBAddEditDocument() { // var nStaSession = JCNxFuncChkSessionExpired();
    var nStaSession = 1;
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JSxTRBValidateFormDocument();
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Event Single Delete Document Single
function JSoTRBDelDocSingle(ptCurrentPage, ptTRBDocNo, ptAgnCode , ptBchCode, ptTRBRefInCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        if (typeof(ptTRBDocNo) != undefined && ptTRBDocNo != "") {
            var tTextConfrimDelSingle = $('#oetTextComfirmDeleteSingle').val() + "&nbsp" + ptTRBDocNo + "&nbsp" + $('#oetTextComfirmDeleteYesOrNot').val();
            $('#odvTRBModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
            $('#odvTRBModalDelDocSingle').modal('show');
            $('#odvTRBModalDelDocSingle #osmConfirmDelSingle').unbind().click(function() {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docTRBEventDelete",
                    data: {
                        'tDataDocNo': ptTRBDocNo,
                        'tBchCode': ptBchCode,
                        'tAgnCode': ptAgnCode,
                        'tTRBRefInCode': ptTRBRefInCode
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvTRBModalDelDocSingle').modal('hide');
                            $('#odvTRBModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                JSvTRBCallPageDataTable(ptCurrentPage);
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
function JSoTRBDelDocMultiple() {
    var aDataDelMultiple = $('#odvTRBModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
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
            var tAgnCode = $(this).data('agncode');
            var tTRBRefInCode = $(this).data('refcode');
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type: "POST",
                url: "docTRBEventDelete",
                data: {
                    'tDataDocNo': tDataDocNo,
                    'tBchCode': tBchCode,
                    'tAgnCode': tAgnCode,
                    'tTRBRefInCode': tTRBRefInCode
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if (aReturnData['nStaEvent'] == '1') {
                        setTimeout(function() {
                            $('#odvTRBModalDelDocMultiple').modal('hide');
                            $('#odvTRBModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                            $('#odvTRBModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                            $('.modal-backdrop').remove();
                            localStorage.removeItem('LocalItemData');
                            JSvTRBCallPageList();
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
function JSxTRBShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliTRBBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliTRBBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliTRBBtnDeleteAll").addClass("disabled");
        }
    }
}

// Function: Function Chack Value LocalStorage
function JStTRBFinTRBbjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

// Function: Cancel Document DO
function JSnTRBCancelDocument(pbIsConfirm) {
    var tTRBDocNo = $("#oetTRBDocNo").val();
    var tTRBAgnCode = $("#oetTRBAgnCode").val();
    var tTRBFrmBchCode = $("#oetTRBFrmBchCode").val();
    
    var tRefInTRBcNo = $('#oetTRBRefDocIntName').val();
    if (pbIsConfirm) {
        $.ajax({
            type: "POST",
            url: "docTRBCancelDocument",
            data: {
                'ptTRBDocNo': tTRBDocNo,
                'ptRefInTRBcNo': tRefInTRBcNo
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvTRBPopupCancel").modal("hide");
                $('.modal-backdrop').remove();
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSvTRBCallPageEdit(tTRBFrmBchCode,tTRBAgnCode,tTRBDocNo);
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
        $('#odvTRBPopupCancel').modal({ backdrop: 'static', keyboard: false });
        $("#odvTRBPopupCancel").modal("show");
    }
}

// Function: Function Control Object Button
function JCNxTRBControlObjAndBtn() { // Check สถานะอนุมัติ
    var nTRBStaDoc = $("#ohdTRBStaDoc").val();
    var nTRBStaApv = $("#ohdTRBStaApv").val();

    // Status Cancel
    if (nTRBStaDoc == 3) {
        $("#oliTRBTitleAdd").hide();
        $('#oliTRBTitleEdit').hide();
        $('#oliTRBTitleDetail').show();
        $('#oliTRBTitleAprove').hide();
        $('#oliTRBTitleConimg').hide();
        // Hide And Disabled
        $("#obtTRBCallPageAdd").hide();
        $("#obtTRBCancelDoc").hide(); // attr("disabled",true);
        $("#obtTRBApproveDoc").hide(); // attr("disabled",true);
        $("#obtTRBBrowseSupplier").attr("disabled", true);
        $(".xWConditionSearchPdt").attr("disabled", true);

        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNTRBcBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNTRBcDrpDwn").hide();
        $("#oetTRBFrmSearchPdtHTML").attr("disabled", false);
        $('#odvTRBBtnGrpSave').show();
        $("#oliTRBEditShipAddress").hide();
        $("#oliTRBEditTexAddress").hide();
        $("#oliTRBTitleDetail").show();

        $("#ocbDOFrmInfoOthStaDocAct").attr("readonly", true);
        $("#obtTRBFrmBrowseShipAdd").attr("disabled", true);
        $("#obtTRBFrmBrowseTaxAdd").attr("disabled", true);
        // อินพุต
        $('.xControlForm').attr('readonly', true);
        $('.xWTRBDisabledOnApv').attr('disabled', true);
        $("#obtTRBFrmBrowseTaxAdd").hide();


    }

    // Status Appove Success
    if (nTRBStaDoc == 1 && nTRBStaApv == 1) { // Hide/Show Menu Title

        $("#oliTRBTitleAdd").hide();
        $('#oliTRBTitleEdit').hide();
        $('#oliTRBTitleDetail').show();
        $('#oliTRBTitleAprove').hide();
        $('#oliTRBTitleConimg').hide();
        // Hide And Disabled
        $("#obtTRBCallPageAdd").hide();
        $("#obtTRBCancelDoc").hide(); // attr("disabled",true);
        $("#obtTRBApproveDoc").hide(); // attr("disabled",true);
        $("#obtTRBBrowseSupplier").attr("disabled", true);
        $(".xWConditionSearchPdt").attr("disabled",true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNTRBcBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNTRBcDrpDwn").hide();
        $("#oetTRBFrmSearchPdtHTML").attr("disabled", false);
        $('#odvTRBBtnGrpSave').show();
        $("#oliTRBEditShipAddress").hide();
        $("#oliTRBEditTexAddress").hide();
        $("#oliTRBTitleDetail").show();
        $('.xControlForm').attr('readonly', true);
        $('.xWTRBDisabledOnApv').attr('disabled', true);
        $("#ocbDOFrmInfoOthStaDocAct").attr("readonly", true);
        $("#obtTRBFrmBrowseShipAdd").attr("disabled", true);
        $("#obtTRBFrmBrowseTaxAdd").attr("disabled", true);
    }
}


function JSxSoCallBackUploadFile(ptParam){
    console.log(ptParam);
}
</script>