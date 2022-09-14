var nStaAdjStkSumBrowseType = $("#oetAdjStkSumStaBrowse").val();
var tCallAdjStkSumBackOption = $("#oetAdjStkSumCallBackOption").val();

$("document").ready(function () {
  localStorage.removeItem("LocalItemData");
  JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
  JSxAdjStkSumNavDefult();
  JSvCallPageAdjStkSumList();
});



//Functionality: Del Pdt In Row Html And Del in DB
//Parameters: Event Proporty
//Creator: 04/04/2019 Krit(Copter)
//Return:  Call function Delete
function JSnRemoveDTRow(ele) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    var tVal = $(ele)
      .parent()
      .parent()
      .parent()
      .attr("data-pdtcode");
    var tSeqno = $(ele)
      .parent()
      .parent()
      .parent()
      .attr("data-seqno");
    $(ele)
      .parent()
      .parent()
      .parent()
      .remove();

    JSnAdjStkSumRemoveDTTemp(tSeqno, tVal);
  } else {
    JCNxShowMsgSessionExpired();
  }
}

function JSxAdjStkSumNavDefult() {
    if (nStaAdjStkSumBrowseType != 1 || nStaAdjStkSumBrowseType == undefined) {
        $(".xCNAdjStkSumVBrowse").hide();
        $(".xCNAdjStkSumVMaster").show();
        $("#oliAdjStkSumTitleAdd").hide();
        $("#oliAdjStkSumTitleEdit").hide();
        $("#odvBtnAddEdit").hide();
        $(".obtChoose").hide();
        $("#odvBtnAdjStkSumInfo").show();
    } else {
        $("#odvModalBody .xCNAdjStkSumVMaster").hide();
        $("#odvModalBody .xCNAdjStkSumVBrowse").show();
        $("#odvModalBody #odvAdjStkSumMainMenu").removeClass("main-menu");
        $("#odvModalBody #oliAdjStkSumNavBrowse").css("padding", "2px");
        $("#odvModalBody #odvAdjStkSumBtnGroup").css("padding", "0");
        $("#odvModalBody .xCNAdjStkSumBrowseLine").css("padding", "0px 0px");
        $("#odvModalBody .xCNAdjStkSumBrowseLine").css("border-bottom", "1px solid #e3e3e3");
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function
//Creator : 04/07/2018 Krit
//Return : Modal Status Error
//Return Type : view
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
  $("#myModal").modal({ show: true });
  $("#odvModalBody").html(tMsgError);
}

/*
function : Function Browse Pdt
Parameters : Error Ajax Function 
Creator : 22/05/2019 Piya(Tiger)
Return : Modal Status Error
Return Type : view
*/
function JCNvAdjStkSumBrowsePdt() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        aMulti = [];
        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                Qualitysearch: [
                    /* "NAMEPDT",
                    "CODEPDT",
                    "SUP",
                    "PurchasingManager",
                    "NAMEPDT",
                    "CODEPDT",
                    "BARCODE",
                    'LOC',
                    "FromToBCH",
                    "Merchant",
                    "FromToSHP",
                    "FromToPGP",
                    "FromToPTY",
                    "PDTLOGSEQ"*/
                ],
                PriceType       : ["Cost", "tCN_Cost", "Company", "1"],
                SelectTier      : ["Barcode"],
                ShowCountRecord : 10,
                NextFunc        : "FSvPDTAddPdtIntoTableDT",
                ReturnType      : "M",
                SPL             : ["", ""],
                BCH             : [$("#oetBchCode").val(), $("#oetBchCode").val()],
                SHP             : [$("#oetShpCodeStart").val(), $("#oetShpCodeStart").val()]
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                // $(".modal.fade:not(#odvAdjStkSumBrowseShipAdd, #odvModalDOCPDT, #odvModalWanning)").remove();
                $("#odvModalDOCPDT").modal({backdrop: "static", keyboard: false});
                $("#odvModalDOCPDT").modal({show: true});

                //remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                $("#odvModalsectionBodyPDT").html(tResult);
            },
            error: function (data) {
                console.log(data);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
// Create : 2018-08-28 Krit(Copter)
function FSvPDTAddPdtIntoTableDT(pjPdtData) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {

        JCNxOpenLoading();
        var ptXthDocNoSend = "";
        if ($("#ohdAdjStkSumRoute").val() == "AdjStkSumEventEdit") {
            ptXthDocNoSend = $("#oetAdjStkSumAjhDocNo").val();
        }

        $.ajax({
            type: "POST",
            url: "adjStkSumAddPdtIntoTableDT",
            data: {

                ptAjhDocNo: ptXthDocNoSend,
                pjPdtData: pjPdtData,
                pnAdjStkSumOptionAddPdt: '2' // เพิ่มแถวใหม่ // $("#ocmAdjStkSumOptionAddPdt").val()
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                console.log(tResult);
                JSvAdjStkSumLoadPdtDataTableHtml();
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
function JSvAdjStkSumDOCSearchPdtHTML() {
    JSvAdjStkSumLoadPdtDataTableHtml();
    /*var value = $("#oetAdjStkSumSearchPdtHTML").val().toLowerCase();
    $("#otbDOCPdtTable tbody tr ").filter(function () {
        var tText = $(this).toggle(
            $(this).text().toLowerCase().indexOf(value) > -1
        );
    });*/
}



//Function Save product price list inline
function JSxAdjStkSumSaveInLine(oEvent,oElm){
    // var nStaSession = 1;
    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
     
        // var nSeq        = oElm.DataAttribute[0]['dataSEQ'];
        // var tPrice      = oElm.DataAttribute[1]['dataPRICE'];
        // var nPage       = oElm.DataAttribute[2]['dataPAGE'];
        // var tValue      = oElm.VeluesInline;
        var cDecimal = $('#ohdGetOptionDecimalShow').val();
        var nSeq = $(oElm).attr('seq');
        var tPrice = $(oElm).attr('columname');
        var tColValidate = $(oElm).attr('col-validate');
        var nPage = $(oElm).attr('page');
        var b4value = parseFloat($(oElm).attr('b4value'));
        var tValue = ($(oElm).val() == "")?0:parseFloat($(oElm).val().replace(/,/g, ''));
        var cUnitfact = $(oElm).attr('unitfact');  
        // alert(tValue);
        console.log(b4value);
        console.log(tValue);
        // console.log(oElm);
        // if(tValue == ""){
        //     alert('Value is null');
        //     JSvSpaPdtPriDataTable();
        // }else{
            // var tRet = parseFloat($('#ohdFCXtdPriceRet'+pnSeq).val());
            // var tWhs = parseFloat($('#ohdFCXtdPriceWhs'+pnSeq).val());
            // var tNet = parseFloat($('#ohdFCXtdPriceNet'+pnSeq).val());

            var tDocNo   = $('#otrSpaPdtPri'+nSeq).data('docno');
            var tPdtCode = $('#otrSpaPdtPri'+nSeq).data('pdtcode');
            var tPunCode = $('#otrSpaPdtPri'+nSeq).data('puncode');
            var tSeq = $('#otrSpaPdtPri'+nSeq).data('seqno');
            var oetSearchSpaPdtPri  = $('#oetSearchSpaPdtPri').val();
            // $('.xWShowValueFCXtdPriceRet'+pnSeq).text(tRet.toFixed(2));
            // $('.xWShowValueFCXtdPriceWhs'+pnSeq).text(tWhs.toFixed(2));
            // $('.xWShowValueFCXtdPriceNet'+pnSeq).text(tNet.toFixed(2));

            // $('.xWEditInLine'+pnSeq).addClass('xCNHide');
            // $('.xWShowInLine'+pnSeq).removeClass('xCNHide');
            // $('.xWShowIconSaveInLine'+pnSeq).addClass('xCNHide');
            // $('.xWShowIconEditInLine'+pnSeq).removeClass('xCNHide');
            // $('.xWShowIconCancelInLine'+pnSeq).addClass('xCNHide');

            // JCNxOpenLoading();
            var tBchCode = $('#oetAdjStkSumBchCode').val();
            var tWahCode = $('#oetAdjStkSumWahCode').val();

            if(b4value!=tValue){
                // $(oElm).addClass('xCNHide');
            $.ajax({
                type: "POST",
                url: "docSMEventEditInLine",
                data: { 
                    'FTXthDocNo' : tDocNo,
                    'FTPdtCode' : tPdtCode,
                    'FTPunCode' : tPunCode,
                    'tBchCode' : tBchCode,
                    'tWahCode' : tWahCode, 
                    'ptPrice' : tPrice,
                    'ptValue' : tValue,
                    'cUnitfact':cUnitfact,
                    'tSearchSpaPdtPri' : oetSearchSpaPdtPri,
                    'tSeq' : tSeq,
                    'tColValidate' : tColValidate
                },
                cache: false,
                success: function(pResutl) {
                    var objResult = JSON.parse(pResutl);
                    // $(oElm).removeClass('xCNHide');
                    $(oElm).val(numberWithCommas(tValue.toFixed(cDecimal)));
                    $(oElm).attr('b4value',tValue);
                    $('.xWShowValueFDAjdDateC3'+tSeq).text(objResult['rdAjdDateC3']);
                    $('.xWShowValueFDAjdTimeC3'+tSeq).text(objResult['rdAjdTimeC3']);
                    $('.xWShowValueFCAjdWahB4Adj'+tSeq).text(objResult['FCAjdWahB4Adj']);
                    $('.xWShowValueFCAjdQtyAllDiff'+tSeq).text(objResult['FCAjdQtyAllDiff']);
                    $('.xWShowValueAfterAdj'+tSeq).text(objResult['AfterAdj']);
                    // $('#otdSPATotalPrice').text(objResult['cSpaTotalPrice']);
                    // $(oElm).parents(".otrSpaPdtPri").find(".xCNAdjPriceStaRmk").text("").removeClass("text-danger");
                    // JSvSpaPdtPriDataTable(nPage);
                    // JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            // $(oElm).val(accounting.formatNumber(tValue,2,','));
                 $(oElm).val(numberWithCommas(tValue.toFixed(cDecimal)));
        }
        // }
        if (oEvent.keyCode == 13) {

            var tNextElement = $(oElm).closest('form').find('input[type=text]');
            var tNextElementID=   tNextElement.eq( tNextElement.index(oElm)+ 1 ).attr('id');
            // console.log(tNextElementID);
            var tValueNext     = parseFloat($('#'+tNextElementID).val().replace(/,/g, ''));
            $('#'+tNextElementID).val(tValueNext);
            $('#'+tNextElementID).focus();
            $('#'+tNextElementID).select();
     
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

  //พวกตัวเลขใส่ comma ให้มัน
function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
}

/**
 * Functionality : Action for approve
 * Parameters : pbIsConfirm
 * Creator : 11/04/2019 Krit(Copter)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnAdjStkSumApprove(pbIsConfirm) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            if (pbIsConfirm) {
                $("#ohdCardShiftTopUpCardStaPrcDoc").val(2); // Set status for processing approve
                $("#odvAdjStkSumPopupApv").modal("hide");

               var tXthDocNo = $("#oetAdjStkSumAjhDocNo").val();
               var tXthStaApv = $("#ohdXthStaApv").val();
               var tBchCode  = $('#oetAdjStkSumBchCode').val();
               var tWahCode = $('#oetAdjStkSumWahCode').val();
                $.ajax({
                    type: "POST",
                    url: "docSMEventApprove",
                    data: {
                        tXthDocNo: tXthDocNo,
                        tXthStaApv: tXthStaApv,
                        tBchCode : tBchCode,
                        tWahCode : tWahCode
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
                        } catch (e) {
                        }

                        JSoAdjStkSumSubscribeMQ();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                //console.log("StaApvDoc Call Modal");
                $("#odvAdjStkSumPopupApv").modal("show");
            }
        } catch (err) {
            console.log("JSnAdjStkSumApprove Error: ", err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

/**
 * Functionality : Action for approve
 * Parameters : pbIsConfirm
 * Creator : 11/04/2019 Krit(Copter)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSoAdjStkSumSubscribeMQ() {
    // RabbitMQ
    /*===========================================================================*/
    // Document variable
    var tLangCode = $("#ohdLangEdit").val();
    var tUsrBchCode = $("#oetAdjStkSumBchCode").val();
    var tUsrApv = $("#ohdAdjStkSumUsrCode").val();
    var tDocNo = $("#oetAdjStkSumAjhDocNo").val();
    var tPrefix = "RESAJS";
    var tStaApv = $("#ohdXthStaApv").val();
    var tStaDelMQ = $("#ohdXthStaDelMQ").val();
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
        host: 'ws://' + oSTOMMQConfig.host + ':15674/ws',
        username: oSTOMMQConfig.user,
        password: oSTOMMQConfig.password,
        vHost: oSTOMMQConfig.vhost
    };

    // Update Status For Delete Qname Parameter
    var poUpdateStaDelQnameParams = {
        ptDocTableName: "TCNTPdtTwxHD",
        ptDocFieldDocNo: "FTXthDocNo",
        ptDocFieldStaApv: "FTXthStaPrcStk",
        ptDocFieldStaDelMQ: "FTXthStaDelMQ",
        ptDocStaDelMQ: tStaDelMQ,
        ptDocNo: tDocNo
    };

    // Callback Page Control(function)
    var poCallback = {
        tCallPageEdit: "JSvCallPageAdjStkSumEdit",
        tCallPageList: "JSvCallPageAdjStkSumList"
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

function JSnAdjStkSumCancel(pbIsConfirm) {
    tXthDocNo = $("#oetAdjStkSumAjhDocNo").val();

    if (pbIsConfirm) {
        $.ajax({
            type: "POST",
            url: "docSMEventCancel",
            data: {
                tXthDocNo: tXthDocNo
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                $("#odvAdjStkSumPopupCancel").modal("hide");

                aResult = $.parseJSON(tResult);
                if (aResult.nSta == 1) {
                    JSvCallPageAdjStkSumEdit(tXthDocNo);
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
        nStaApv = $("#ohdXthStaApv").val();

        if (nStaApv == 1) {
            $("#obpMsgApv").show();
        } else {
            $("#obpMsgApv").hide();
        }

        $("#odvAdjStkSumPopupCancel").modal("show");
    }
}

// Function : GET Scan BarCode
function JSvAdjStkSumScanPdtHTML() {
    tBarCode = $("#oetAdjStkSumScanPdtHTML").val();
    tSplCode = $("#oetSplCode").val();

    if (tBarCode != "") {
        JCNxOpenLoading();

        $.ajax({
            type: "POST",
            url: "adjStkSumGetPdtBarCode",
            data: {
                tBarCode: tBarCode,
                tSplCode: tSplCode
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                aResult = $.parseJSON(tResult);

                if (aResult.aData != 0) {
                    tData = $.parseJSON(aResult.aData);

                    tPdtCode = tData[0].FTPdtCode;
                    tPunCode = tData[0].FTPunCode;

                    //Funtion Add Pdt To Table
                    FSvAdjStkSumAddPdtIntoTableDT(tPdtCode, tPunCode);

                    $("#oetAdjStkSumScanPdtHTML").val("");
                    $("#oetAdjStkSumScanPdtHTML").focus();
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
        $("#oetAdjStkSumScanPdtHTML").focus();
    }
}

function JSnAdjStkSumRemoveAllDTInFile() {
    ptXthDocNo = $("#oetAdjStkSumAjhDocNo").val();

    $.ajax({
        type: "POST",
        url: "AdjStkSumRemoveAllPdtInFile",
        data: {
            ptXthDocNo: ptXthDocNo
        },
        cache: false,
        timeout: 5000,
        success: function (tResult) {
            JSvAdjStkSumLoadPdtDataTableHtml();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

function JSnAdjStkSumRemoveDTTemp(ptSeqno, ptPdtCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        ptXthDocNo = $("#oetAdjStkSumAjhDocNo").val();
        nPage = $(".xWPageAdjStkSumPdt .active").text();

        $.ajax({
            type: "POST",
            url: "docSMEventRemovePdtInDTTmp",
            data: {
                ptXthDocNo: ptXthDocNo,
                ptSeqno: ptSeqno,
                ptPdtCode: ptPdtCode
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                JSvAdjStkSumLoadPdtDataTableHtml(nPage);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}



function JSxDocSMClearPdtInTmp() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        ptXthDocNo = $("#oetAdjStkSumAjhDocNo").val();

        $.ajax({
            type: "POST",
            url: "docSMEventClearTemp",
            data: {
                ptXthDocNo: ptXthDocNo
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                JSvAdjStkSumLoadPdtDataTableHtml();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}



/*function JSnAdjStkSumRemoveDTInFile(ptIndex, ptPdtCode) {
    ptXthDocNo = $("#oetAdjStkSumAjhDocNo").val();

    $.ajax({
        type: "POST",
        url: "AdjStkSumRemovePdtInFile",
        data: {
            ptXthDocNo: ptXthDocNo,
            ptIndex: ptIndex,
            ptPdtCode: ptPdtCode
        },
        cache: false,
        timeout: 5000,
        success: function (tResult) {
            JSvAdjStkSumLoadPdtDataTableHtml();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}*/

// Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
// Create : 2018-08-28 Krit(Copter)
function FSvAdjStkSumAddPdtIntoTableDT(ptPdtCode, ptPunCode, pnXthVATInOrEx) {
    ptOptDocAdd = $("#ohdOptScanSku").val();

    JCNxOpenLoading();

    ptXthDocNo = $("#oetAdjStkSumAjhDocNo").val();
    ptBchCode = $("#ohdSesUsrBchCode").val();

    $.ajax({
        type: "POST",
        url: "adjStkSumAddPdtIntoTableDT",
        data: {
            ptXthDocNo: ptXthDocNo,
            ptBchCode: ptBchCode,
            ptPdtCode: ptPdtCode,
            ptPunCode: ptPunCode,
            ptOptDocAdd: ptOptDocAdd,
            pnXthVATInOrEx: pnXthVATInOrEx
        },
        cache: false,
        timeout: 5000,
        success: function (tResult) {
            JMvDOCGetPdtImgScan(ptPdtCode);

            JSvAdjStkSumLoadPdtDataTableHtml();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function : Get รูปภาพของสินค้า
function JMvDOCGetPdtImgScan(ptPdtCode){

    $.ajax({
        type: "POST",
        url: "DOCGetPdtImg",
        data: { 
            tPdtCode : ptPdtCode
        },
        cache: false,
        timeout: 5000,
        success: function(tResult){
            $('#odvShowPdtImgScan').html(tResult);
        },
        error: function(data) {
            console.log(data);
        }
    });
}

/**
 * Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
 */
function FSvAdjStkSumEditPdtIntoTableDT(ptEditSeqNo, paField, paValue) {
  ptXthDocNo = $("#oetAdjStkSumAjhDocNo").val();
  ptBchCode = $("#ohdSesUsrBchCode").val();

  $.ajax({
    type: "POST",
    url: "adjStkSumEditPdtIntoTableDT",
    data: {
      ptXthDocNo: ptXthDocNo,
      ptEditSeqNo: ptEditSeqNo,
      paField: paField,
      paValue: paValue
    },
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      // console.log(tResult);

      JSvAdjStkSumLoadPdtDataTableHtml();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}


/**
 * Functionality : Call Purchase Page Add
 * Parameters : -
 * Creator : 22/05/2019 Piya(Tiger)
 * Return : View
 * Return Type : View
 */
function JSvCallPageAdjStkSumAdd() {
    $.ajax({
        type: "POST",
        url: "docSMPageAdd",
        data: {},
        cache: false,
        timeout: 5000,
        success: function (tResult) {
            if (nStaAdjStkSumBrowseType == 1) {
                $(".xCNAdjStkSumVMaster").hide();
                $(".xCNAdjStkSumVBrowse").show();
            } else {
                $(".xCNAdjStkSumVBrowse").hide();
                $(".xCNAdjStkSumVMaster").show();
                $("#oliAdjStkSumTitleEdit").hide();
                $("#oliAdjStkSumTitleAdd").show();
                $("#odvBtnAdjStkSumInfo").hide();
                $("#odvBtnAddEdit").show();
                $("#obtAdjStkSumApprove").hide();
                $("#obtAdjStkSumPrint").hide();
                $("#obtAdjStkSumCancel").hide();
            }

            var oResult = JSON.parse(tResult);
            if(oResult['nStaEvent']=='1'){
                $("#odvContentPageAdjStkSum").html(oResult['tSMViewPageAdd']);
                JCNxAdjStkSumControlObjAndBtn();
            }
            
            $(".xWConditionSearchPdt.disabled").attr("disabled", "disabled");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


    function JSnAddEditAdjStkSum() {
        JSxValidateFormAddAdjStkSum();
    }

    function JSvCallPageAdjStkSumList() {
        try {
            $.ajax({
                type: "GET",
                url: "docSMFormSearchList",
                data: {},
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    $("#odvContentPageAdjStkSum").html(tResult);
                    JSxAdjStkSumNavDefult();

                    JSvCallPageAdjStkSumPdtDataTable(); // แสดงข้อมูลใน List
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSvCallPageAdjStkSumList Error: ', err);
        }
    }

    function JSvCallPageAdjStkSumPdtDataTable(pnPage) {
        JCNxOpenLoading();

        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }

        var oAdvanceSearch = JSoAdjStkSumGetAdvanceSearchData();

        $.ajax({
            type: "POST",
            url: "docSMDataTable",
            data: {
                oAdvanceSearch: oAdvanceSearch,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                var oResult =  JSON.parse(tResult)
                if(oResult['nStaEvent']=='1'){
                    $("#odvContentAdjustStockSumTable").html(oResult['tRDHViewDataTableList']);
                    JSxAdjStkSumNavDefult();
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                }


            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : Get search data
     * Parameters : -
     * Creator : 22/05/2019 Piya(Tiger)
     * Last Modified : -
     * Return : Search data
     * Return Type : Object
     */
    function JSoAdjStkSumGetAdvanceSearchData() {
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
                    tSearchStaPrcStk: $("#ocmStaPrcStk").val()
                };
                return oAdvanceSearchData;
            } catch (err) {
                console.log("JSoAdjStkSumGetAdvanceSearchData Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Call Credit Page Edit
     * Parameters : -
     * Creator : 22/05/2019 Piya(Tiger)
     * Return : View
     * Return Type : View
     */
    function JSvCallPageAdjStkSumEdit(ptAjhDocNo) {
        JCNxOpenLoading();

        JStCMMGetPanalLangSystemHTML("JSvCallPageAdjStkSumEdit", ptAjhDocNo);

        $.ajax({
            type: "POST",
            url: "docSMPageEdit",
            data: {ptAjhDocNo: ptAjhDocNo},
            cache: false,
            timeout: 0,
            success: function (tResult) {

                var oResult = JSON.parse(tResult);
                if (oResult['nStaEvent'] == "1") {
                    $("#oliAdjStkSumTitleAdd").hide();
                    $("#oliAdjStkSumTitleEdit").show();
                    $("#odvBtnAdjStkSumInfo").hide();
                    $("#odvBtnAddEdit").show();
                    $("#odvContentPageAdjStkSum").html(oResult['tSMViewPageAdd']);
                    $("#oetAdjStkSumAjhDocNo").addClass("xCNDisable");
                    $('#ocbAdjStkSumSubAutoGenCode').attr('disabled',true);
                    $(".xCNDisable").attr("readonly", true);
                    $(".xCNiConGen").hide();
                    $("#obtAdjStkSumApprove").show();
                    $("#obtAdjStkSumCancel").show();
                    $('#obtAdjStkSumPrint').show();

                }

                // Function Load Table Pdt ของ AdjStkSum
                JSvAdjStkSumLoadPdtDataTableHtml();

                // Put Data
                ohdXthCshOrCrd = $("#ohdXthCshOrCrd").val();
                $("#ostXthCshOrCrd option[value='" + ohdXthCshOrCrd + "']").attr("selected", true).trigger("change");

                ohdXthStaRef = $("#ohdXthStaRef").val();
                $("#ostXthStaRef option[value='" + ohdXthStaRef + "']").attr("selected", true).trigger("change");

                // Control Object And Button ปิด เปิด
                JCNxAdjStkSumControlObjAndBtn();

                JCNxLayoutControll();
                $(".xWConditionSearchPdt.disabled").attr("disabled", "disabled");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Function : Control Object And Button ปิด เปิด
    function JCNxAdjStkSumControlObjAndBtn() {
        // Check สถานะอนุมัติ
        var ohdXthStaApv = $("#ohdAdjStkSumAjhStaApv").val();
        var ohdXthStaDoc = $("#ohdAdjStkSumAjhStaDoc").val();
            
        // Set Default
        // Btn Cancel
        $("#obtAdjStkSumCancel").attr("disabled", false);
        // $('#obtAdjStkSumCancel').show();
        // Btn Apv
        $("#obtAdjStkSumApprove").attr("disabled", false);
        // $('#obtAdjStkSumApprove').show();
        // $(".form-control").attr("disabled", false);
        $(".ocbListItem").attr("disabled", false);
        // $(".xCNBtnBrowseAddOn").attr("disabled", false);
        $(".xCNBtnDateTime").attr("disabled", false);
        $(".xCNDocBrowsePdt").attr("disabled", false).removeClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").show();
        $("#oetAdjStkSumSearchPdtHTML").attr("disabled", false);
        $(".xWBtnGrpSaveLeft").attr("disabled", false);
        $(".xWBtnGrpSaveRight").attr("disabled", false);
        $("#oliBtnEditShipAdd").show();
        $("#oliBtnEditTaxAdd").show();

        if (ohdXthStaApv == 1) {
            // Btn Apv
            $("#obtAdjStkSumApprove").attr("disabled", true);
            $('#obtAdjStkSumApprove').hide();
            $('#obtAdjStkSumCancel').hide();
            $("#odvBtnAddEdit").show();
            $("#obtAdjStkSumSave").hide();
            $("#obtAdjStkSumBrowseWah").attr("disabled", true);
            $("#obtAdjStkSumBrowseBch").attr("disabled", true);
            $("#obtAdjStkSumBrowseReason").attr("disabled", true);
            // $(".xCNIconTable").hide();
            $("#ocmAdjStkSumCheckTime").attr("disabled", true);
            $("#obtSMLoadDTStkSubToTemp").attr("disabled", true);
            $('.xCNIconDel').attr("disabled", true).addClass('xCNDocDisabled');
            
            // Control input ปิด
            // $(".form-control").attr("disabled", true);
            $(".ocbListItem").attr("disabled", true);
            // $(".xCNBtnBrowseAddOn").attr("disabled", true);
            $(".xCNBtnDateTime").attr("disabled", true);
            $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
            $(".xCNDocDrpDwn").hide();
            $("#oetAdjStkSumSearchPdtHTML").attr("disabled", false);
            $(".xWBtnGrpSaveLeft").attr("disabled", true);
            $(".xWBtnGrpSaveRight").attr("disabled", true);
            $("#oliBtnEditShipAdd").hide();
            $("#oliBtnEditTaxAdd").hide();
            $("#ocbAdjStkSumStaDocAct").attr("disabled", true);
        }
        // Check สถานะเอกสาร
        if (ohdXthStaDoc == 3) {
            // Btn Cancel
            $("#obtAdjStkSumCancel").attr("disabled", true);
            $('#obtAdjStkSumCancel').hide();
            // Btn Apv
            $("#obtAdjStkSumApprove").attr("disabled", true);
            $('#obtAdjStkSumApprove').hide();
            // Control input ปิด
            // $("#odvBtnAddEdit").hide();
            $("#odvBtnAddEdit").show();
            $("#obtAdjStkSumSave").hide();
            $("#obtAdjStkSumBrowseWah").attr("disabled", true);
            $("#obtAdjStkSumBrowseBch").attr("disabled", true);
            $("#obtAdjStkSumBrowseReason").attr("disabled", true);
            $("#ocmAdjStkSumCheckTime").attr("disabled", true);
            $("#obtSMLoadDTStkSubToTemp").attr("disabled", true);
            // $(".xCNIconTable").hide();
            $('.xCNIconDel').addClass('xCNDocDisabled');
            // $(".form-control").attr("disabled", true);
            $(".ocbListItem").attr("disabled", true);
            // $(".xCNBtnBrowseAddOn").attr("disabled", true);
            $(".xCNBtnDateTime").attr("disabled", true);
            $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
            $(".xCNDocDrpDwn").hide();
            $("#oetAdjStkSumSearchPdtHTML").attr("disabled", false);
            $(".xWBtnGrpSaveLeft").attr("disabled", true);
            $(".xWBtnGrpSaveRight").attr("disabled", true);
            $("#oliBtnEditShipAdd").hide();
            $("#oliBtnEditTaxAdd").hide();
            $("#ocbAdjStkSumStaDocAct").attr("disabled", true);
        }
    }

    /**
     * Functionality : (event) Delete
     * Parameters : tIDCode รหัส
     * Creator : 22/05/2019 Piya(Tiger)
     * Return : 
     * Return Type : Status Number
     */
    function JSnAdjStkSumDel(tCurrentPage, tIDCode) {
        var aData = $("#ohdConfirmIDDelete").val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == "1") {
            $("#odvModalDel").modal("show");
            $("#ospConfirmDelete").html("ยืนยันการลบข้อมูล หมายเลข : " + tIDCode);
            $("#osmConfirm").on("click", function (evt) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docSMEventDelete",
                    data: {tIDCode: tIDCode},
                    cache: false,
                    success: function (tResult) {
                        var aReturn = JSON.parse(tResult);

                        if (aReturn["nStaEvent"] == 1) {
                            $("#odvModalDel").modal("hide");
                            $("#ospConfirmDelete").text("ยืนยันการลบข้อมูลของ : ");
                            $("#ohdConfirmIDDelete").val("");
                            localStorage.removeItem("LocalItemData");
                            setTimeout(function () {
                                JSvAdjStkSumClickPage(tCurrentPage);
                            }, 500);
                        } else {
                            alert(aReturn["tStaMessg"]);
                        }
                        JSxAdjStkSumNavDefult();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }
    }

    /**
     * Functionality : (event) Delete
     * Parameters : tIDCode รหัส
     * Creator : 22/05/2019 Piya(Tiger)
     * Return : 
     * Return Type : Status Number
     */
    function JSnAdjStkSumDelChoose() {
        JCNxOpenLoading();
        var aData = $("#ohdConfirmIDDelete").val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }
        if (aDataSplitlength > 1) {
            localStorage.StaDeleteArray = "1";
            $.ajax({
                type: "POST",
                url: "docSMEventDelete",
                data: {tIDCode: aNewIdDelete},
                success: function (tResult) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn["nStaEvent"] == 1) {
                        setTimeout(function () {
                            $("#odvModalDel").modal("hide");
                            JSvCallPageAdjStkSumPdtDataTable();
                            $("#ospConfirmDelete").text("ยืนยันการลบข้อมูลของ : ");
                            $("#ohdConfirmIDDelete").val("");
                            localStorage.removeItem("LocalItemData");
                            $(".modal-backdrop").remove();
                        }, 1000);
                    } else {
                        alert(aReturn["tStaMessg"]);
                    }
                    JSxAdjStkSumNavDefult();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = "0";
            return false;
        }
    }

    /**
     * Functionality: Event Pdt Multi Delete
     * Parameters: Event Button Delete All
     * Creator: 22/05/2019 Piya(Tiger)
     * Return:  object Status Delete
     * Return Type: object
     */
    function JSoAdjStkSumPdtDelChoose(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var aSeq = $("#ohdConfirmSeqDelete").val();
            var tDocNo = $("#oetAdjStkSumAjhDocNo").val();

            //PdtCode
            var aTextSeq = aSeq.substring(0, aSeq.length - 2);
            var aSeqSplit = aTextSeq.split(" , ");
            var aSeqSplitlength = aSeqSplit.length;
            //Seq
            var aTextSeq = aSeq.substring(0, aSeq.length - 2);
            var aSeqSplit = aTextSeq.split(" , ");
            var aSeqData = [];

            for ($i = 0; $i < aSeqSplitlength; $i++) {
                aSeqData.push(aSeqSplit[$i]);
            }
            
            if (aSeqSplitlength > 1) {
                // JCNxOpenLoading();
                localStorage.StaDeleteArray = "1";
                $.ajax({
                    type: "POST",
                    url: "docSMEventRemoveMultiPdtInDTTmp",
                    data: {
                        tDocNo: tDocNo,
                        tSeqCode: aSeqData
                    },
                    success: function (tResult) {
                        console.log(tResult);
                        setTimeout(function () {
                            $("#odvModalDelPdtAdjStkSum").modal("hide");
                            JSvAdjStkSumLoadPdtDataTableHtml();
                            $("#ospConfirmDelete").text($("#oetTextComfirmDeleteSingle").val());
                            $("#ohdConfirmSeqDelete").val("");
                            $("#ohdConfirmPdtDelete").val("");
                            $("#ohdConfirmPunDelete").val("");
                            $("#ohdConfirmDocDelete").val("");
                            localStorage.removeItem("LocalItemData");
                            $(".obtChoose").hide();
                            $(".modal-backdrop").remove();
                        }, 1000);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                localStorage.StaDeleteArray = "0";
                return false;
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : เปลี่ยนหน้า pagenation
     * Parameters : -
     * Creator : 22/05/2019 Piya(Tiger)
     * Return : View
     * Return Type : View
     */
    function JSvAdjStkSumClickPage(ptPage) {
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
        JSvCallPageAdjStkSumPdtDataTable(nPageCurrent);
    }

    //Functionality: Function Chack And Show Button Delete All
    //Parameters: LocalStorage Data
    //Creator: 10/07/2019 Krit(Copter)
    //Return: -
    //Return Type: -
    function JSxShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#oliAdjStkSumBtnDeleteAll").addClass("disabled");
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#oliAdjStkSumBtnDeleteAll").removeClass("disabled");
            } else {
                $("#oliAdjStkSumBtnDeleteAll").addClass("disabled");
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
    function JSxAdjStkSumPdtTextinModal() {
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
     * Creator : 22/05/2019 Piya(Tiger)
     * Return : View
     * Return Type : View
     */
    function JSvAdjStkSumPdtClickPage(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld = $(".xWPageAdjStkSumPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld = $(".xWPageAdjStkSumPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                default:
                    nPageCurrent = ptPage;
            }
            JCNxOpenLoading();
            JSvAdjStkSumLoadPdtDataTableHtml(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //Functionality : Generate Code Subdistrict
    //Parameters : Event Icon Click
    //Creator : 07/06/2018 wasin
    //Return : Data
    //Return Type : String
    function JStGenerateAdjStkSumCode() {
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
                    $("#oetAdjStkSumAjhDocNo").val(tData.rtXthDocNo);
                    $("#oetAdjStkSumAjhDocNo").addClass("xCNDisable");
                    $(".xCNDisable").attr("readonly", true);
                    //----------Hidden ปุ่ม Gen
                    $(".xCNBtnGenCode").attr("disabled", true);
                    $("#oetXthDocDate").focus();
                    $("#oetXthDocDate").focus();

                    JStCMNCheckDuplicateCodeMaster(
                            "oetAdjStkSumAjhDocNo",
                            "JSvCallPageAdjStkSumEdit",
                            "TCNTPdtTwxHD",
                            "FTXthDocNo"
                            );
                } else {
                    $("#oetAdjStkSumAjhDocNo").val(tData.rtDesc);
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Function : Get Html PDT มาแปะ ในหน้า Add
    // Create : 04/04/2019 Krit(Copter)
    function JSvAdjStkSumLoadPdtDataTableHtml(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            
            JCNxOpenLoading();
            
            var tSearchAll = $('#oetAdjStkSumSearchPdtHTML').val();
            var tAjhDocNo, tAjhStaApv, tAjhStaDoc, nPageCurrent ,tAjhBchCode , tAjhWahCode , nAdjCheckTime;
            if (JCNbAdjStkSumIsCreatePage()) {
                tAjhDocNo = "";
            } else {
                tAjhDocNo     = $("#oetAdjStkSumAjhDocNo").val();
            }

            tAjhBchCode   = $('#oetAdjStkSumBchCode').val();
            tAjhWahCode   = $('#oetAdjStkSumWahCode').val();
            nAdjCheckTime = $('#ocmAdjStkSumCheckTime').val();
            
            
            tAjhStaApv = $("#ohdAdjStkSumAjhStaApv").val();
            tAjhStaDoc = $("#ohdAdjStkSumAjhStaDoc").val();

            // เช็ค สินค้าใน table หน้านั้นๆ มีหรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
            if ($("#odvTBodyAdjStkSumPdt .xWPdtItem").length == 0) {
                if (typeof pnPage !== 'undefined') {
                    pnPage = pnPage - 1;
                }
            }

            nPageCurrent = ( (typeof pnPage === 'undefined') || (pnPage === "") || (pnPage <= 0) ) ? "1" : pnPage;

            $.ajax({
                type: "POST",
                url: "docSMTableLoadData",
                data: {
                    tSearchAll: tSearchAll,
                    tAjhDocNo: tAjhDocNo,
                    tAjhStaApv: tAjhStaApv,
                    tAjhStaDoc: tAjhStaDoc,
                    tAjhBchCode:tAjhBchCode,
                    tAjhWahCode:tAjhWahCode,
                    nAdjCheckTime:nAdjCheckTime,
                    nPageCurrent: nPageCurrent
                },
                cache: false,
                Timeout: 0,
                success: function (tResult) {
                    $("#odvAdjStkSumPdtTablePanal").html(tResult);
                    // JSvAdjStkSumLoadVatTableHtml(); // Load Vat Table

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


    function JSxOpenColumnFormSet() {
    $.ajax({
        type: "POST",
        url: "adjStkSumAdvanceTableShowColList",
        data: {},
        cache: false,
        Timeout: 0,
        success: function (tResult) {
        $("#odvShowOrderColumn").modal({ show: true });
        $("#odvOderDetailShowColumn").html(tResult);
        //JSCNAdjustTable();
        },
        error: function (jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
    }

    function JSxSaveColumnShow() {
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
            url: "adjStkSumAdvanceTableShowColSave",
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
                // Function Gen Table Pdt ของ AdjStkSum
                JSvAdjStkSumLoadPdtDataTableHtml();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // ปรับ Value ใน Input หลัวจาก กรอก เสร็จ
    function JSxAdjStkSumAdjInputFormat(ptInputID) {
        cVal = $("#" + ptInputID).val();
        cVal = accounting.toFixed(cVal, nOptDecimalShow);
        $("#" + ptInputID).val(cVal);
    }

    /**
     * Functionality : Is create page.
     * Parameters : -
     * Creator : 22/05/2019 piya(tiger)
     * Last Modified : -
     * Return : Status true is create page
     * Return Type : Boolean
     */
    function JCNbAdjStkSumIsCreatePage(){
        try{
            var tAdjStkSumDocNo   = $('#oetAdjStkSumAjhDocNo').data('is-created');
            var bStatus = false;
            if(tAdjStkSumDocNo == ""){ // No have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JCNbAdjStkSumIsCreatePage Error: ', err);
        }
    }

    /**
     * Functionality : Is update page.
     * Parameters : -
     * Creator : 22/05/2019 piya(tiger)
     * Last Modified : -
     * Return : Status true is create page
     * Return Type : Boolean
     */
    function JCNbAdjStkSumIsUpdatePage(){
        try{
            var tAdjStkSumDocNo = $('#oetAdjStkSumAjhDocNo').data('is-created');
            var bStatus = false;
            if(!tAdjStkSumDocNo == ""){ // Have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JCNbAdjStkSumIsUpdatePage Error: ', err);
        }
    }

        /**
     * Functionality : Is update page.
     * Parameters : -
     * Creator : 22/05/2019 piya(tiger)
     * Last Modified : -
     * Return : Status true is create page
     * Return Type : Boolean
     */
    function JSxAJHSetDTSeqPdt4Fhn(pnSeq){
        $('#ohdEditInlineSetDTSeq').val(pnSeq);
    }

    /**
     * Functionality : Is update page.
     * Parameters : -
     * Creator : 22/05/2019 piya(tiger)
     * Last Modified : -
     * Return : Status true is create page
     * Return Type : Boolean
     */
    function FSvStkSubAddPdtIntoDocDTTempC3_PDTSerialorFashion(paData){
        try{
            // console.log(paData);
            var paDataDTFhn = JSON.parse(paData);
            var aDataInsert = {
                tBchCode    : $('#oetAdjStkSumBchCode').val(),
                tDocNo      : $('#oetAdjStkSumAjhDocNo').val(),
                nDTTmpSeq   : $('#ohdEditInlineSetDTSeq').val()
            };
            $.ajax({
                type: "POST",
                url: "docSMEEventEditProductsFashion",
                data: {
                    paDataDTFhn     : paDataDTFhn,
                    paDataInsert    : aDataInsert
                },
                cache: false,
                Timeout: 0,
                success: function (oResult) {
                    JSvAdjStkSumLoadPdtDataTableHtml(1);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });


        }catch(err){
            console.log('JSxASTEventAddProducts Error: ', err);
        }


    }