var nStaCreditNoteBrowseType = $("#oetCreditNoteStaBrowse").val();
var tCallCreditNoteBackOption = $("#oetCreditNoteCallBackOption").val();

$("document").ready(function () {
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCreditNoteNavDefult();

    if (nStaCreditNoteBrowseType != 1) {
        JSvCallPageCreditNoteList();
    } else {
        JSvCallPageCreditNoteAdd();
    }
    
});

/**
 * Function : Set Default Nav
 * Parameters : -
 * Creator : 22/06/2019 Piya
 * Return : -
 * Return Type : -
 */
function JSxCreditNoteNavDefult() {
    if (nStaCreditNoteBrowseType != 1 || nStaCreditNoteBrowseType == undefined) {
        $(".xCNCreditNoteVBrowse").hide();
        $(".xCNCreditNoteVMaster").show();
        $("#oliCreditNoteTitleAdd").hide();
        $("#oliCreditNoteTitleEdit").hide();
        $("#odvBtnAddEdit").hide();
        $(".obtChoose").hide();
        $("#odvBtnCreditNoteInfo").show();
    } else {
        $("#odvModalBody .xCNCreditNoteVMaster").hide();
        $("#odvModalBody .xCNCreditNoteVBrowse").show();
        $("#odvModalBody #odvCreditNoteMainMenu").removeClass("main-menu");
        $("#odvModalBody #oliCreditNoteNavBrowse").css("padding", "2px");
        $("#odvModalBody #odvCreditNoteBtnGroup").css("padding", "0");
        $("#odvModalBody .xCNCreditNoteBrowseLine").css("padding", "0px 0px");
        $("#odvModalBody .xCNCreditNoteBrowseLine").css("border-bottom", "1px solid #e3e3e3");
    }
}

/**
 * Function : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 22/06/2019 Piya
 * Return : Modal Status Error
 * Return Type : view
 */
function JCNxResponseError(jqXHR, textStatus, errorThrown) {
    JCNxCloseLoading();
    var tHtmlError = $(jqXHR.responseText);
    var tMsgError = "<h3 style='font-size:20px;color:red'>";
    tMsgError += "<i class='fa fa-exclamation-triangle'></i>";
    tMsgError += " Error<hr></h3>";
    switch (jqXHR.status) {
        case 404:
            tMsgError += tHtmlError.find("p:nth-child(2)").text();
            break;
        case 500:
            tMsgError += tHtmlError.find("p:nth-child(3)").text();
            break;

        default:
            tMsgError += "something had error. please contact admin";
            break;
    }
    $("body").append(tModal);
    $("#modal-customs").attr(
            "style",
            "width: 450px; margin: 1.75rem auto;top:20%;"
            );
    $("#myModal").modal({show: true});
    $("#odvModalBody").html(tMsgError);
}



/**
 * Functionality : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
 * Parameters : ptPdtData, ptIsRefPI
 * Creator : 22/06/2019 Piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSvPDTAddPdtIntoTableDT(ptPdtData, ptIsRefPI, tIsByScanBarCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        ptIsRefPI           = typeof ptIsRefPI == 'undefined' ? '0' : ptIsRefPI;
        tIsByScanBarCode    = typeof tIsByScanBarCode == 'undefined' ? '0' : tIsByScanBarCode;

        var ptXthDocNoSend = "";
        if (JCNbCreditNoteIsUpdatePage()) {
            ptXthDocNoSend = $("#oetCreditNoteDocNo").val();
        }
        
        var tSplCode = $('#oetCreditNoteSplCode').val();
        
        $.ajax({
            type: "POST",
            url: "creditNoteAddPdtIntoTableDT",
            data: {
                tDocNo                  : ptXthDocNoSend,
                tSplCode                : tSplCode,
                tIsRefPI                : ptIsRefPI,
                tIsByScanBarCode        : tIsByScanBarCode,
                tBarCodeByScan          : $('#oetCreditNoteScanPdtHTML').val(),
                tSplVatType             : JSxCreditNoteIsSplUseVatType('in') ? '1' : '2', // 1: รวมใน, 2: แยกนอก
                tPdtData                : ptPdtData,
                tCreditNoteOptionAddPdt : $("#ocmCreditNoteOptionAddPdt").val() // เพิ่มแถวใหม่ Default 1 : บวกรายการเดิมในรายการ
            },
            cache: false,
            success: function (tResult) {
                if(JCNbCreditNoteIsDocType('havePdt')){
                    if(tResult.rtCode == '800'){
                        FSvCMNSetMsgWarningDialog('ไม่พบรายการสินค้า');
                        return;
                    }
                    JSvCreditNoteLoadPdtDataTableHtml();
                }
                if(JCNbCreditNoteIsDocType('nonePdt')){
                    JSvCreditNoteLoadNonePdtDataTableHtml();
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

// Function : Search Pdt
function JSvCreditNoteDOCSearchPdtHTML() {
    if(JCNbCreditNoteIsDocType('havePdt')){
        JSvCreditNoteLoadPdtDataTableHtml();
    }
    if(JCNbCreditNoteIsDocType('nonePdt')){
        JSvCreditNoteLoadNonePdtDataTableHtml();
    }
}

/**
 * Functionality : Action for approve
 * Parameters : pbIsConfirm
 * Creator : 22/06/2019 Piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnCreditNoteApprove(pbIsConfirm) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        try {
            if (pbIsConfirm) {
                $("#ohdCardShiftTopUpCardStaPrcDoc").val(2); // Set status for processing approve
                $("#odvCreditNotePopupApv").modal("hide");

                var tDocNo = $("#oetCreditNoteDocNo").val();
                var tStaApv = $("#ohdXthStaApv").val();
                var tDocType = $("#ohdCreditNoteDocType").val();
                var tBchCode = $("#oetCreditNoteBchCode").val();
                JCNxOpenLoading();
                
                $.ajax({
                    type: "POST",
                    url: "creditNoteApprove",
                    data: {
                        tDocNo: tDocNo,
                        tStaApv: tStaApv,
                        tDocType: tDocType,
                        tBchCode:tBchCode
                    },
                    cache: false,
                    timeout: 0,
                    success: function (oResult) {
                        console.log(oResult);
                        try{
                            if (oResult.nStaEvent == "900") {
                                FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                JCNxCloseLoading();
                                return;
                            }
                        }catch(err) {}
                        
                        if(JCNbCreditNoteIsDocType('havePdt')){
                            JSoCreditNoteSubscribeMQ();
                        }
                        
                        if(JCNbCreditNoteIsDocType('nonePdt')){
                            var tDocNo = $('#oetCreditNoteDocNo').val();
                            JSvCallPageCreditNoteEdit(tDocNo);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                        JCNxCloseLoading();
                    }
                });
            } else {
                // console.log("StaApvDoc Call Modal");
                $("#odvCreditNotePopupApv").modal("show");
            }
        } catch (err) {
            console.log("JSnCreditNoteApprove Error: ", err);
        }
        
    } else {
        JCNxShowMsgSessionExpired();
    }
}

/**
 * Functionality : Action for approve
 * Parameters : pbIsConfirm
 * Creator : 22/06/2019 Piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSoCreditNoteSubscribeMQ() {
    // RabbitMQ
    /*===========================================================================*/
    // Document variable
    var tLangCode = $("#ohdLangEdit").val();
    var tUsrBchCode = $("#ohdCreditNoteBchCode").val();
    var tUsrApv = $("#ohdCreditNoteUsrCode").val();
    var tDocNo = $("#oetCreditNoteDocNo").val();
    var tPrefix = "RESPCN";
    var tStaApv = $("#ohdCreditNoteStaApv").val();
    var tStaDelMQ = $("#ohdCreditNoteStaDelMQ").val();
    var tQName = tPrefix + "_" + tDocNo + "_" + tUsrApv;

    // MQ Message Config
    var poDocConfig = {
        tLangCode: tLangCode,
        tUsrBchCode: tUsrBchCode,
        tUsrApv: tUsrApv,
        tDocNo: tDocNo,
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
        ptDocTableName: "TAPTPcHD",
        ptDocFieldDocNo: "FTXphDocNo",
        ptDocFieldStaApv: "FTXphStaPrcStk",
        ptDocFieldStaDelMQ: "FTXphStaDelMQ",
        ptDocStaDelMQ: tStaDelMQ,
        ptDocNo: tDocNo
    };

    // Callback Page Control(function)
    var poCallback = {
        tCallPageEdit: "JSvCallPageCreditNoteEdit",
        tCallPageList: "JSvCallPageCreditNoteList"
    };

    // Check Show Progress %
    FSxCMNRabbitMQMessage(
        poDocConfig,
        poMqConfig,
        poUpdateStaDelQnameParams,
        poCallback
    );
    /*===========================================================================*/
    // RabbitMQ
}

function JSnCreditNoteCancel(pbIsConfirm) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        var tDocNo = $("#oetCreditNoteDocNo").val();

        if (pbIsConfirm) {
            $.ajax({
                type: "POST",
                url: "creditNoteCancel",
                data: {
                    tDocNo: tDocNo
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    $("#odvCreditNotePopupCancel").modal("hide");

                    var aResult = $.parseJSON(tResult);
                    if (aResult.nSta == 1) {
                        JSvCallPageCreditNoteEdit(tDocNo);
                    } else {
                        JCNxCloseLoading();
                        var tMsgBody = aResult.tMsg;
                        FSvCMNSetMsgWarningDialog(tMsgBody);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            $("#odvCreditNotePopupCancel").modal("show");
        }
    
    }else {
        JCNxShowMsgSessionExpired();
    }
}

// Function : GET Scan BarCode
function JSvCreditNoteScanPdtHTML() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    
        var tBarCode = $("#oetCreditNoteScanPdtHTML").val();
        var tSplCode = $("#oetSplCode").val();

        if (tBarCode != "") {
            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "creditNoteGetPdtBarCode",
                data: {
                    tBarCode: tBarCode,
                    tSplCode: tSplCode
                },
                cache: false,
                success: function (tResult) {
                    aResult = $.parseJSON(tResult);

                    if (aResult.aData != 0) {
                        tData = $.parseJSON(aResult.aData);

                        tPdtCode = tData[0].FTPdtCode;
                        tPunCode = tData[0].FTPunCode;

                        //Funtion Add Pdt To Table
                        FSvCreditNoteAddPdtIntoTableDT(tPdtCode, tPunCode);

                        $("#oetCreditNoteScanPdtHTML").val("");
                        $("#oetCreditNoteScanPdtHTML").focus();
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
            $("#oetCreditNoteScanPdtHTML").focus();
        }
        
    }else {
        JCNxShowMsgSessionExpired();
    }    
}

/**
 * Function: Remove DT Temp
 * @param {type} ptSeqNo
 * @param {type} ptPdtCode
 * @returns {undefined}
 */
function JSnCreditNoteRemoveDTTemp(ptSeqNo, ptPdtCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        var tDocNo      = $("#oetCreditNoteDocNo").val();
        var nPage       = $(".xWPageCreditNotePdt .active").text();
        var tBchCode    = $('#oetCreditNoteBchCode').val();
        $.ajax({
            type: "POST",
            url: "creditNoteRemovePdtInDTTmp",
            data: {
                tDocNo      : tDocNo,
                nSeqNo      : ptSeqNo,
                tBchCode    : tBchCode,
                tSplVatType : JSxCreditNoteIsSplUseVatType('in') ? '1' : '2', // 1: รวมใน, 2: แยกนอก
                tPdtCode    : ptPdtCode
            },
            cache: false,
            success: function (tResult) {
                if(JCNbCreditNoteIsDocType('havePdt')){
                    JSvCreditNoteLoadPdtDataTableHtml(nPage);
                }
                if(JCNbCreditNoteIsDocType('nonePdt')){
                    JSvCreditNoteLoadNonePdtDataTableHtml();
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

/**
 * Function : เพิ่มสินค้า ลง Table DT
 * @param {type} ptPdtCode
 * @param {type} ptPunCode
 * @param {type} pnXthVATInOrEx
 * @returns {undefined}
 */
function FSvCreditNoteAddPdtIntoTableDT(ptPdtCode, ptPunCode, pnXthVATInOrEx) {
    
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    
        var ptOptDocAdd = $("#ohdOptScanSku").val();

        JCNxOpenLoading();

        var ptXthDocNo = $("#oetCreditNoteDocNo").val();
        var ptBchCode = $("#ohdSesUsrBchCode").val();

        $.ajax({
            type: "POST",
            url: "creditNoteAddPdtIntoTableDT",
            data: {
                ptXthDocNo: ptXthDocNo,
                ptBchCode: ptBchCode,
                ptPdtCode: ptPdtCode,
                ptPunCode: ptPunCode,
                ptOptDocAdd: ptOptDocAdd,
                pnXthVATInOrEx: pnXthVATInOrEx
            },
            cache: false,
            success: function (tResult) {
                JMvDOCGetPdtImgScan(ptPdtCode);

                if(JCNbCreditNoteIsDocType('havePdt')){
                    JSvCreditNoteLoadPdtDataTableHtml();
                }
                if(JCNbCreditNoteIsDocType('nonePdt')){
                    JSvCreditNoteLoadNonePdtDataTableHtml();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        
    }else {
        JCNxShowMsgSessionExpired();
    }    
}

/**
 * Function : Get รูปภาพของสินค้า
 * @param {type} ptPdtCode
 * @returns {undefined}
 */
function JMvDOCGetPdtImgScan(ptPdtCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        $.ajax({
            type: "POST",
            url: "DOCGetPdtImg",
            data: { 
                tPdtCode : ptPdtCode
            },
            cache: false,
            success: function(tResult){
                $('#odvShowPdtImgScan').html(tResult);
            },
            error: function(data) {
                console.log(data);
            }
        });
    
    }else {
        JCNxShowMsgSessionExpired();
    }
}

/**
 * Function : แก้ไขสินค้าใน Table DT
 * @param {type} pnSeqNo
 * @param {type} ptFieldName
 * @param {type} ptValue
 * @param {type} pbIsDelDTDis
 * @returns {undefined}
 */
function FSvCreditNoteEditPdtIntoTableDT(pnSeqNo, ptFieldName, ptValue, pbIsDelDTDis) {
    
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        var tDocNo = $("#oetCreditNoteDocNo").val();
        var tBchCode = $("#ohdSesUsrBchCode").val();

        $.ajax({
            type: "POST",
            url: "creditNoteEditPdtIntoTableDT",
            data: {
                tDocNo: tDocNo,
                tSplVatType: JSxCreditNoteIsSplUseVatType('in') ? '1' : '2', // 1: รวมใน, 2: แยกนอก
                tSeqNo: pnSeqNo,
                tFieldName: ptFieldName,
                tValue: ptValue,
                tIsDelDTDis: (pbIsDelDTDis) ? '1' : '0' // 1: ลบ, 2: ไม่ลบ
            },
            cache: false,
            success: function (tResult) {
                // console.log(tResult);

                if (JCNbCreditNoteIsDocType('havePdt')) {
                    JSvCreditNoteLoadPdtDataTableHtml(1, false);
                }
                if (JCNbCreditNoteIsDocType('nonePdt')) {
                    JSvCreditNoteLoadNonePdtDataTableHtml(1, false);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        
    }else {
        JCNxShowMsgSessionExpired();
    }
}

/**
 * Functionality : Call Page Add
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSvCallPageCreditNoteAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        localStorage.removeItem('LocalItemData');
        $('#odvCreditNoteSelectDocTypePopup').modal('show');
        $('#obtnCreditNoteConfirmSelectDocType').one('click', function(){
            $('#odvCreditNoteSelectDocTypePopup').modal('hide');
            var nDoctype = $('#odvCreditNoteSelectDocTypePopup input[name=orbCreditNoteSelectDocType]:checked').val();
            // console.log('nDoctype: ', nDoctype);
            $.ajax({
                type: "POST",
                url: "creditNotePageAdd",
                data: {
                    nDocType: nDoctype
                },
                cache: false,
                success: function (tResult) {
                    if (nStaCreditNoteBrowseType == 1) {
                        $(".xCNCreditNoteVMaster").hide();
                        $(".xCNCreditNoteVBrowse").show();
                    } else {
                        $(".xCNCreditNoteVBrowse").hide();
                        $(".xCNCreditNoteVMaster").show();
                        $("#oliCreditNoteTitleEdit").hide();
                        $("#oliCreditNoteTitleAdd").show();
                        $("#odvBtnCreditNoteInfo").hide();
                        $("#odvBtnAddEdit").show();
                        $("#obtCreditNoteApprove").hide();
                        $("#obtCreditNoteCancel").hide();
                    }
                    $("#odvContentPageCreditNote").html(tResult);

                    // Control Object And Button ปิด เปิด
                    JCNxCreditNoteControlObjAndBtn();
                    // Load Pdt Table

                    if ($("#oetBchCode").val() == "") {
                        $("#obtCreditNoteBrowseShipAdd").attr("disabled", "disabled");
                    }

                    if(JCNbCreditNoteIsDocType('havePdt')){
                        JSvCreditNoteLoadPdtDataTableHtml();
                    }
                    if(JCNbCreditNoteIsDocType('nonePdt')){
                        JSvCreditNoteLoadNonePdtDataTableHtml();
                    }

                    $('#ocbCreditNoteAutoGenCode').change(function () {
                        $("#oetCreditNoteDocNo").val("");
                        if ($('#ocbCreditNoteAutoGenCode').is(':checked')) {
                            $("#oetCreditNoteDocNo").attr("readonly", true);
                            $("#oetCreditNoteDocNo").attr("onfocus", "this.blur()");
                            $('#ofmAddCreditNote').removeClass('has-error');
                            $('#ofmAddCreditNote .form-group').closest('.form-group').removeClass("has-error");
                            $('#ofmAddCreditNote em').remove();
                        } else {
                            $("#oetCreditNoteDocNo").attr("readonly", false);
                            $("#oetCreditNoteDocNo").removeAttr("onfocus");
                        }

                    });
                    $("#oetCreditNoteDocNo,#oetXthDocDate,#oetXthDocTime").blur(function () {
                        // JSxSetStatusClickCreditNoteSubmit(0);
                        JSxValidateFormAddCreditNote();
                        $('#ofmAddCreditNote').submit();
                    });

                    $(".xWConditionSearchPdt.disabled").attr("disabled", "disabled");

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
        
    }else {
        JCNxShowMsgSessionExpired();
    }    
}

/**
 * Functionality : (event) Add/Edit
 * Parameters : form
 * Creator : 22/05/2019 Piya
 * Return : Status Add
 * Return Type : number
 */
function JSnAddEditCreditNote() {
    JSxValidateFormAddCreditNote();
}
            
function JSvCallPageCreditNoteList() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type: "GET",
                url: "creditNoteFormSearchList",
                data: {},
                cache: false,
                success: function (tResult) {
                    $("#odvContentPageCreditNote").html(tResult);
                    JSxCreditNoteNavDefult();

                    JSvCallPageCreditNotePdtDataTable(); // แสดงข้อมูลใน List
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSvCallPageCreditNoteList Error: ', err);
        }
        
    }else {
        JCNxShowMsgSessionExpired();
    }    
}

/**
 * Functionality : Call Product List
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : View
 * Return Type : View
 */
function JSvCallPageCreditNotePdtDataTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        JCNxOpenLoading();

        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }

        var oAdvanceSearch = JSoCreditNoteGetAdvanceSearchData();

        $.ajax({
            type: "POST",
            url: "creditNoteDataTable",
            data: {
                tAdvanceSearch: JSON.stringify(oAdvanceSearch),
                nPageCurrent: nPageCurrent
            },
            cache: false,
            success: function (tResult) {
                $("#odvContentCreditNoteList").html(tResult);

                JSxCreditNoteNavDefult();
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        
    }else {
        JCNxShowMsgSessionExpired();
    }    
}

/**
 * Functionality : Get search data
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : Search data
 * Return Type : Object
 */
function JSoCreditNoteGetAdvanceSearchData() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            let oAdvanceSearchData = {
                tSearchAll: $("#oetSearchAll").val(),
                tSearchBchCodeFrom: $("#oetBchCodeFrom").val(),
                tSearchBchCodeTo: $("#oetBchCodeTo").val(),
                tSearchDocDateFrom: $("#oetSearchDocDateFrom").val(),
                tSearchDocDateTo: $("#oetSearchDocDateTo").val(),
                tSearchStaDoc: $("#ocmStaDoc").val(),
                tSearchStaApprove: $("#ocmStaApprove").val(),
                tSearchStaPrcStk: $("#ocmStaPrcStk").val(),
                tSearchDocType: $("#ocmDocType").val(),
                tSearchStaDocAct: $("#ocmStaDocAct").val()
            };
            return oAdvanceSearchData;
        } catch (err) {
            console.log("JSoCreditNoteGetAdvanceSearchData Error: ", err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}


/**
 * Functionality : Call Credit Page Edit
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSvCallPageCreditNoteEdit(ptDocNo) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        localStorage.removeItem('LocalItemData');
        JCNxOpenLoading();

        JStCMMGetPanalLangSystemHTML("JSvCallPageCreditNoteEdit", ptDocNo);

        $.ajax({
            type: "POST",
            url: "creditNotePageEdit",
            data: {tDocNo: ptDocNo},
            cache: false,
            success: function (tResult) {
                if (tResult != "") {
                    $("#oliCreditNoteTitleAdd").hide();
                    $("#oliCreditNoteTitleEdit").show();
                    $("#odvBtnCreditNoteInfo").hide();
                    $("#odvBtnAddEdit").show();
                    $("#odvContentPageCreditNote").html(tResult);
                    $("#oetCreditNoteDocNo").addClass("xCNDisable");
                    $(".xCNDisable").attr("readonly", true);
                    $(".xCNiConGen").hide();
                    $("#obtCreditNoteApprove").show();
                    $("#obtCreditNoteCancel").show();

                }

                // Function Load Table Pdt ของ CreditNote
                if(JCNbCreditNoteIsDocType('havePdt')){
                    JSvCreditNoteLoadPdtDataTableHtml();
                }
                if(JCNbCreditNoteIsDocType('nonePdt')){
                    JSvCreditNoteLoadNonePdtDataTableHtml();
                }

                // Put Data
                ohdXthCshOrCrd = $("#ohdXthCshOrCrd").val();
                $("#ostXthCshOrCrd option[value='" + ohdXthCshOrCrd + "']").attr("selected", true).trigger("change");

                ohdXthStaRef = $("#ohdXthStaRef").val();
                $("#ostXthStaRef option[value='" + ohdXthStaRef + "']").attr("selected", true).trigger("change");

                // Control Object And Button ปิด เปิด
                JCNxCreditNoteControlObjAndBtn();

                JCNxLayoutControll();
                $(".xWConditionSearchPdt.disabled").attr("disabled", "disabled");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        
    }else {
        JCNxShowMsgSessionExpired();
    }    
}

// Function : Control Object And Button ปิด เปิด
function JCNxCreditNoteControlObjAndBtn() {
    // Check สถานะอนุมัติ
    var ohdXthStaApv = $("#ohdXthStaApv").val();
    var ohdXthStaDoc = $("#ohdXthStaDoc").val();

    var tDocType     = $("#ohdCreditNoteDocType").val();

    if(tDocType == '7'){
        $('#odvCreditNoteCondition').css('display','none');
        $('#obtCreditNoteBrowseRefPI').attr('disabled',true);
        $('#oetCreditNoteXphRefIntDate').attr('disabled',true);
        $('#obtCreditNoteRefIntDate').attr('disabled',true);
    }

    // Set Default
    // Btn Cancel
    $("#obtCreditNoteCancel").attr("disabled", false);
    // Btn Apv
    $("#obtCreditNoteApprove").attr("disabled", false);
    // $(".form-control").attr("disabled", false);
    $(".ocbListItem").attr("disabled", false);
    // $(".xCNBtnBrowseAddOn").attr("disabled", false);
    $(".xCNBtnDateTime").attr("disabled", false);
    $(".xCNDocBrowsePdt").attr("disabled", false).removeClass("xCNBrowsePdtdisabled");
    $(".xCNDocDrpDwn").show();
    $("#oetCreditNoteSearchPdtHTML").attr("disabled", false);
    $(".xWBtnGrpSaveLeft").attr("disabled", false);
    $(".xWBtnGrpSaveRight").attr("disabled", false);
    $("#oliBtnEditShipAdd").show();
    $("#oliBtnEditTaxAdd").show();

    if (ohdXthStaApv == 1) {
        // Btn Apv
        $("#obtCreditNoteApprove").attr("disabled", true);
        // Control input ปิด
        // $(".form-control").attr("disabled", true);
        $(".ocbListItem").attr("disabled", true);
        // $(".xCNBtnBrowseAddOn").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetCreditNoteSearchPdtHTML").attr("disabled", false);
        $(".xWBtnGrpSaveLeft").attr("disabled", true);
        $(".xWBtnGrpSaveRight").attr("disabled", true);
        $("#oliBtnEditShipAdd").hide();
        $("#oliBtnEditTaxAdd").hide();
        $(".xCNBtnDateTime").attr("disabled", true);
    }
    // Check สถานะเอกสาร
    if (ohdXthStaDoc == 3) {
        // Btn Cancel
        $("#obtCreditNoteCancel").attr("disabled", true);
        // Btn Apv
        $("#obtCreditNoteApprove").attr("disabled", true);
        // Control input ปิด
        // $(".form-control").attr("disabled", true);
        $(".ocbListItem").attr("disabled", true);
        // $(".xCNBtnBrowseAddOn").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetCreditNoteSearchPdtHTML").attr("disabled", false);
        $(".xWBtnGrpSaveLeft").attr("disabled", true);
        $(".xWBtnGrpSaveRight").attr("disabled", true);
        $("#oliBtnEditShipAdd").hide();
        $("#oliBtnEditTaxAdd").hide();
        $(".xCNBtnDateTime").attr("disabled", true);
    }
}

/**
 * Functionality : (event) Delete
 * Parameters : tIDCode รหัส
 * Creator : 22/05/2019 Piya
 * Return : 
 * Return Type : Status Number
 */
function JSnCreditNoteDel(tCurrentPage, tDocNo) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        var aData = $("#ohdConfirmIDDelete").val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;

        if (aDataSplitlength == "1") {
            $("#odvModalDel").modal("show");
            $("#ospConfirmDelete").html("ยืนยันการลบข้อมูล หมายเลข : " + tDocNo);

            $("#osmConfirm").on("click", function (evt) {
                $("#odvModalDel").modal("hide");
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "creditNoteEventDeleteDoc",
                    data: {tDocNo: tDocNo},
                    cache: false,
                    success: function (tResult) {
                        JSvCallPageCreditNotePdtDataTable(tCurrentPage);
                        JSxCreditNoteNavDefult();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }
    
    }else {
        JCNxShowMsgSessionExpired();
    }
}

/**
 * Functionality : (event) Delete
 * Parameters : tIDCode รหัส
 * Creator : 22/05/2019 Piya
 * Return : 
 * Return Type : Status Number
 */
function JSnCreditNoteDelChoose() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        $("#odvModalDel").modal("hide");
        JCNxOpenLoading();

        var aData = $("#ohdConfirmIDDelete").val();
        var aTexts = aData.substring(0, aData.length - 2);
        console.log('aTexts: ', aTexts);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;

        var aDocNo = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aDocNo.push(aDataSplit[$i]);
        }
        console.log('aDocNo: ', aDocNo);
        if (aDataSplitlength > 1) {
            localStorage.StaDeleteArray = "1";
            $.ajax({
                type: "POST",
                url: "creditNoteEventDeleteMultiDoc",
                data: {aDocNo: aDocNo},
                success: function (tResult) {
                    JSvCallPageCreditNotePdtDataTable();
                    JSxCreditNoteNavDefult();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = "0";
            return false;
        }
        
    }else {
        JCNxShowMsgSessionExpired();
    }
}

/**
 * Functionality : เปลี่ยนหน้า pagenation
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSvCreditNoteClickPage(ptPage) {
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
    JSvCallPageCreditNotePdtDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 10/07/2019 Krit(Copter)
//Return: -
//Return Type: -
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliCreditNoteBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliCreditNoteBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliCreditNoteBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 15/05/2018 wasin
//Return: -
//Return Type: -
function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
    } else {
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

        $("#ospConfirmDelete").text("ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?");
        $("#ohdConfirmIDDelete").val(tTextCode);
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 25/02/2019 Napat(Jame)
//Return: -
//Return Type: -
function JSxCreditNotePdtTextinModal() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        } else {
            var tTextSeq = "";
            var tTextPdt = "";
            var tTextDoc = "";
            var tTextPun = "";
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextSeq += aArrayConvert[0][$i].tSeq;
                tTextSeq += " , ";
                tTextPdt += aArrayConvert[0][$i].tPdt;
                tTextPdt += " , ";
                tTextDoc += aArrayConvert[0][$i].tDoc;
                tTextDoc += " , ";
                tTextPun += aArrayConvert[0][$i].tPun;
                tTextPun += " , ";
            }
            $("#ospConfirmDelete").text($("#oetTextComfirmDeleteMulti").val());
            $("#ohdConfirmSeqDelete").val(tTextSeq);
            $("#ohdConfirmPdtDelete").val(tTextPdt);
            $("#ohdConfirmPunDelete").val(tTextPun);
            $("#ohdConfirmDocDelete").val(tTextDoc);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 06/06/2018 Krit
//Return: Duplicate/none
//Return Type: string
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

/**
 * Functionality : เปลี่ยนหน้า pagenation product table
 * Parameters : Event Click Pagination
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSvCreditNotePdtClickPage(ptPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWPageCreditNotePdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWPageCreditNotePdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JCNxOpenLoading();
        if(JCNbCreditNoteIsDocType('havePdt')){
            JSvCreditNoteLoadPdtDataTableHtml(nPageCurrent);
        }
        if(JCNbCreditNoteIsDocType('nonePdt')){
            JSvCreditNoteLoadNonePdtDataTableHtml();
        }
        
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Generate Code Subdistrict
//Parameters : Event Icon Click
//Creator : 07/06/2018 wasin
//Return : Data
//Return Type : String
function JStGenerateCreditNoteCode() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        var tTableName = "TCNTPdtTwxHD";
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: {tTableName: tTableName},
            cache: false,
            timeout: 0,
            success: function (tResult) {
                console.log(tResult);
                var tData = $.parseJSON(tResult);
                if (tData.rtCode == "1") {
                    console.log(tData);
                    $("#oetCreditNoteDocNo").val(tData.rtXthDocNo);
                    $("#oetCreditNoteDocNo").addClass("xCNDisable");
                    $(".xCNDisable").attr("readonly", true);
                    //----------Hidden ปุ่ม Gen
                    $(".xCNBtnGenCode").attr("disabled", true);
                    $("#oetXthDocDate").focus();
                    $("#oetXthDocDate").focus();

                    JStCMNCheckDuplicateCodeMaster(
                            "oetCreditNoteDocNo",
                            "JSvCallPageCreditNoteEdit",
                            "TCNTPdtTwxHD",
                            "FTXthDocNo"
                            );
                } else {
                    $("#oetCreditNoteDocNo").val(tData.rtDesc);
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        
    }else {
        JCNxShowMsgSessionExpired();
    }    
}

// Advance Table
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Functionality : Get Html PDT มาแปะ ในหน้า Add แบบมีสินค้า
 * Parameters : pnPage is page, pbUseLoading is use backdrop loading
 * Creator : 21/06/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSvCreditNoteLoadPdtDataTableHtml(pnPage, pbUseLoading) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        pbUseLoading = typeof pbUseLoading === 'undefined' ? true : pbUseLoading;
        
        if(pbUseLoading){
            JCNxOpenLoading();
        }
        
        var tSearchAll = $('#oetCreditNoteSearchPdtHTML').val();
        var tDocNo, tStaApv, tStaDoc, nPageCurrent;
        if (JCNbCreditNoteIsCreatePage()) {
            tDocNo = "";
        } else {
            tDocNo = $("#oetCreditNoteDocNo").val();
        }
        
        tStaApv = $("#ohdCreditNoteStaApv").val();
        tStaDoc = $("#ohdCreditNoteStaDoc").val();

        // เช็ค สินค้าใน table หน้านั้นๆ มีหรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
        if ($("#odvTBodyCreditNotePdt .xWPdtItem").length == 0) {
            if (typeof pnPage !== 'undefined') {
                pnPage = pnPage - 1;
            }
        }

        nPageCurrent = ( (typeof pnPage === 'undefined') || (pnPage === "") || (pnPage <= 0) ) ? "1" : pnPage;
        
        $.ajax({
            type: "POST",
            url: "creditNotePdtAdvanceTableLoadData",
            data: {
                tSearchAll: tSearchAll,
                tDocNo: tDocNo,
                tSplVatType: JSxCreditNoteIsSplUseVatType('in') ? '1' : '2', // 1: รวมใน, 2: แยกนอก,
                tStaApv: tStaApv,
                tStaDoc: tStaDoc,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 0,
            success: function (oResult) {
                // console.log('JSvCreditNoteLoadPdtDataTableHtml: ', oResult);
                try{
                    $("#odvCreditNotePdtTablePanal").html(oResult.tTalbleHtml);
                    JSxCrdditNoteSetEndOfBill(oResult.aEndOfBill);
                    // JSvCreditNoteLoadVatTableHtml(); // Load Vat Table
                    
                    if(pbUseLoading){
                        JCNxCloseLoading();
                    }
                }catch(err){
                    console.log('JSvCreditNoteLoadPdtDataTableHtml Error: ', err);
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
    
// Function : Get Html PDT มาแปะ ในหน้า Add แบบไม่มีสินค้า
// Create : 04/04/2019 Krit(Copter)
function JSvCreditNoteLoadNonePdtDataTableHtml(pnPage, pbUseLoading) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        pbUseLoading = typeof pbUseLoading === 'undefined' ? true : pbUseLoading;
        
        if(pbUseLoading){
            JCNxOpenLoading();
        }
        
        var tSearchAll = $('#oetCreditNoteSearchPdtHTML').val();
        var tDocNo, tStaApv, tStaDoc, nPageCurrent;
        if (JCNbCreditNoteIsCreatePage()) {
            tDocNo = "";
        } else {
            tDocNo = $("#oetCreditNoteDocNo").val();
        }
        
        tStaApv = $("#ohdCreditNoteStaApv").val();
        tStaDoc = $("#ohdCreditNoteStaDoc").val();

        // เช็ค สินค้าใน table หน้านั้นๆ มีหรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
        if ($("#odvTBodyCreditNotePdt .xWPdtItem").length == 0) {
            if (typeof pnPage !== 'undefined') {
                pnPage = pnPage - 1;
            }
        }

        nPageCurrent = ( (typeof pnPage === 'undefined') || (pnPage === "") || (pnPage <= 0) ) ? "1" : pnPage;

        $.ajax({
            type: "POST",
            url: "creditNoteNonePdtAdvanceTableLoadData",
            data: {
                tSearchAll: tSearchAll,
                tDocNo: tDocNo,
                tSplVatType: JSxCreditNoteIsSplUseVatType('in') ? '1' : '2', // 1: รวมใน, 2: แยกนอก,
                tStaApv: tStaApv,
                tStaDoc: tStaDoc,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 0,
            success: function (oResult) {
                try{
                    console.log(oResult);
                    $("#odvCreditNotePdtTablePanal").html(oResult.tTalbleHtml);
                    // JSxCrdditNoteSetEndOfBill(oResult.aEndOfBill);
                    
                    if(pbUseLoading){
                        JCNxCloseLoading();
                    }
                }catch(err){
                    console.log('JSvCreditNoteLoadPdtDataTableHtml Error: ', err);
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

function JSxOpenColumnFormSet() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        $.ajax({
            type: "POST",
            url: "creditNoteAdvanceTableShowColList",
            data: {},
            cache: false,
            Timeout: 0,
            success: function (tResult) {
                $("#odvShowOrderColumn").modal({show: true});
                $("#odvOderDetailShowColumn").html(tResult);
                //JSCNAdjustTable();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    
    }else {
        JCNxShowMsgSessionExpired();
    }
}

function JSxSaveColumnShow() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        var aColShowSet = [];
        $(".ocbColStaShow:checked").each(function () {
            aColShowSet.push($(this).data("id"));
        });

        var aColShowAllList = [];
        $(".ocbColStaShow").each(function () {
            aColShowAllList.push($(this).data("id"));
        });

        var aColumnLabelName = [];
        $(".olbColumnLabelName").each(function () {
            aColumnLabelName.push($(this).text());
        });

        // alert(aColShowAllList);

        var nStaSetDef;
        if ($("#ocbSetToDef").is(":checked")) {
            nStaSetDef = 1;
        } else {
            nStaSetDef = 0;
        }
        // alert(aColShowSet);

        $.ajax({
            type: "POST",
            url: "creditNoteAdvanceTableShowColSave",
            data: {
                aColShowSet: aColShowSet,
                nStaSetDef: nStaSetDef,
                aColShowAllList: aColShowAllList,
                aColumnLabelName: aColumnLabelName
            },
            cache: false,
            Timeout: 0,
            success: function (tResult) {
                $("#odvShowOrderColumn").modal("hide");
                $(".modal-backdrop").remove();
                // Function Gen Table Pdt ของ CreditNote

                if(JCNbCreditNoteIsDocType('havePdt')){
                    JSvCreditNoteLoadPdtDataTableHtml();
                }
                if(JCNbCreditNoteIsDocType('nonePdt')){
                    JSvCreditNoteLoadNonePdtDataTableHtml();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        
    }else {
        JCNxShowMsgSessionExpired();
    }    
}

// ปรับ Value ใน Input หลัวจาก กรอก เสร็จ
function JSxCreditNoteAdjInputFormat(ptInputID) {
    cVal = $("#" + ptInputID).val();
    cVal = accounting.toFixed(cVal, nOptDecimalShow);
    $("#" + ptInputID).val(cVal);
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 22/05/2019 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCreditNoteIsCreatePage(){
    try{
        var tCreditNoteDocNo = $('#oetCreditNoteDocNo').data('is-created');
        var bStatus = false;
        if(tCreditNoteDocNo == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCreditNoteIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 22/05/2019 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCreditNoteIsUpdatePage(){
    try{
        var tCreditNoteDocNo = $('#oetCreditNoteDocNo').data('is-created');
        var bStatus = false;
        if(!tCreditNoteDocNo == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCreditNoteIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Check Doc Type
 * Parameters : -
 * Creator : 24/06/2019 piya
 * Last Modified : -
 * Return : Status true is doc type match
 * Return Type : Boolean
 */
function JCNbCreditNoteIsDocType(ptDocType){
    try{
        var tCreditNoteDocType = $('#ohdCreditNoteDocType').val();
        var bStatus = false;
        if(ptDocType == "havePdt"){ // ใบลดหนี้แบบมีสินค้า
            if(tCreditNoteDocType == '6'){
                bStatus = true;
            }
        }
        if(ptDocType == "nonePdt"){ // ใบลดหนี้แบบไม่มีสินค้า
            if(tCreditNoteDocType == '7'){
                bStatus = true;
            }
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCreditNoteIsDocType Error: ', err);
    }
}
































































