var nStaTFWBrowseType = $("#oetTFWStaBrowse").val();
var tCallTFWBackOption = $("#oetTFWCallBackOption").val();

$("document").ready(function () {
  localStorage.removeItem("LocalItemData");
  JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
  JSxTFWNavDefult();

  if (nStaTFWBrowseType != 1) {
    JSvCallPageTFWList();
  } else {
    JSvCallPageTFWAdd();
  }  
     
});

//Functionality: Event Edit Pdt Table
//Parameters: Event Proporty
//Creator: 04/04/2019 Krit(Copter)
//Return:  Status Edit
function JSnEditDTRow(event) {

  var tTypeButton = $(".xCNTextDetail2.xWPdtItem > td > lable > img").not("[title='Remove']");
  for (var nI = 0; nI < tTypeButton.length; nI++) {
    if ($(tTypeButton.get(nI)).attr("title") == "Edit") {
      $(tTypeButton.get(nI)).addClass("xCNDisabled");
      $(tTypeButton.get(nI)).attr("onclick", "");
      $(tTypeButton.get(nI)).unbind("click");
    }
  }
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {

    var tEditSeqNo = $(event)
      .parents()
      .eq(2)
      .attr("data-seqno");
    $(".xWShowInLine" + tEditSeqNo).addClass("xCNHide");
    $(".xWEditInLine" + tEditSeqNo).removeClass("xCNHide");

    $(event)
      .parents()
      .eq(2)
      .find(".xWPdtOlaShowQty")
      .addClass("xCNHide");

    $(event)
      .parents()
      .eq(2)
      .find(".xWPdtDivSetQty")
      .removeClass("xCNHide");
    $(event)
      .parents()
      .eq(2)
      .find(".xWPdtDivSetQty")
      .find(".xWPdtSetInputQty")
      .focus();
    $($(event).parent().parent().parent().find("td div input.xWValueEditInLine" + tEditSeqNo)).blur(function (event) {
      if ($(event.target).val() == "") {
        $(event.target).val(0);
      }
    });
    $(event)
      .parent()
      .empty()
      .append(
        $("<img>")
          .attr("class", "xCNIconTable")
          .attr("title", "Save")
          .attr(
            "src",
            tBaseURL +
            "/application/modules/common/assets/images/icons/save.png"
          )
          .click(function () {
            JSnSaveDTEdit(this);
          })
      );

  } else {
    JCNxShowMsgSessionExpired();
  }
}

//Functionality: Save Pdt And Calculate Field
//Parameters: Event Proporty
//Creator: 04/04/2019 Krit(Copter)
//Return:  Cpntroll input And Call Function Edit
function JSnSaveDTEdit(event) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    var nPdtValQty = $(event)
      .parents()
      .eq(2)
      .find(".xWPdtSetInputQty")
      .val();
    var tEditSeqNo = $(event)
      .parents()
      .eq(2)
      .attr("data-seqno");
    var aField = [];
    var aValue = [];

    $(".xWValueEditInLine" + tEditSeqNo).each(function (index) {
      tValue = $(this).val();
      tField = $(this).attr("data-field");
      $(".xWShowValue" + tField + tEditSeqNo).text(tValue);
      aField.push(tField);
      aValue.push(tValue);
    });

    FSvTFWEditPdtIntoTableDT(tEditSeqNo, aField, aValue);

    $(".xWShowInLine" + tEditSeqNo).removeClass("xCNHide");
    $(".xWEditInLine" + tEditSeqNo).addClass("xCNHide");

    $(event)
      .parent()
      .empty()
      .append(
        $("<img>")
          .attr("class", "xCNIconTable")
          .attr(
            "src",
            tBaseURL + "application/modules/common/assets/images/icons/edit.png"
          )
          .click(function () {
            JSnEditDTRow(this);
          })
      );
  } else {
    JCNxShowMsgSessionExpired();
  }
}

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

    JSnTFWRemoveDTTemp(tSeqno, tVal);
  } else {
    JCNxShowMsgSessionExpired();
  }
}

function JSxTFWNavDefult() {
  if (nStaTFWBrowseType != 1 || nStaTFWBrowseType == undefined) {
    $(".xCNTFWVBrowse").hide();
    $(".xCNTFWVMaster").show();
    $("#oliTFWTitleAdd").hide();
    $("#oliTFWTitleEdit").hide();
    $("#odvBtnAddEdit").hide();
    $(".obtChoose").hide();
    $("#odvBtnTFWInfo").show();
    $("#oliPITitleDetail").hide();
  } else {
    $("#odvModalBody .xCNTFWVMaster").hide();
    $("#odvModalBody .xCNTFWVBrowse").show();
    $("#odvModalBody #odvTFWMainMenu").removeClass("main-menu");
    $("#odvModalBody #oliTFWNavBrowse").css("padding", "2px");
    $("#odvModalBody #odvTFWBtnGroup").css("padding", "0");
    $("#odvModalBody .xCNTFWBrowseLine").css("padding", "0px 0px");
    $("#odvModalBody .xCNTFWBrowseLine").css(
      "border-bottom",
      "1px solid #e3e3e3"
    );
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
Creator : 02/04/2019 Krit(Copter)
Return : Modal Status Error
Return Type : view
*/
function JCNvTFWBrowsePdt() {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    aMulti = [];
    $.ajax({
      type: "POST",
      url: "BrowseDataPDT",
      data: {
        Qualitysearch: [
            //"NAMEPDT",
            //"CODEPDT"
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
        $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
        $("#odvModalDOCPDT").modal({ backdrop: "static", keyboard: false });
        $("#odvModalDOCPDT").modal({ show: true });

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

//Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
//Create : 2018-08-28 Krit(Copter)
function FSvPDTAddPdtIntoTableDT(pjPdtData) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    pnXthVATInOrEx = $("#ostXthVATInOrEx").val();

    JCNxOpenLoading();
    var ptXthDocNoSend = "";
    if ($("#ohdTFWRoute").val() == "ADJSTKVDEventEdit") {
      ptXthDocNoSend = $("#oetXthDocNo").val();
    }

    $.ajax({
      type: "POST",
      url: "ADJSTKVDAddPdtIntoTableDT",
      data: {
        ptXthBchCode: $("#oetBchCode").val(),
        ptXthDocNo: ptXthDocNoSend,
        pnXthVATInOrEx: pnXthVATInOrEx,
        pjPdtData: pjPdtData,
        pnTFWOptionAddPdt: $("#ocmTFWOptionAddPdt").val()
      },
      cache: false,
      timeout: 5000,
      success: function (tResult) {
        console.log(tResult);
        JSvTFWLoadPdtDataTableHtml(1);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

//Function : Search Pdt
function JSvDOCSearchPdtHTML() {
  var value = $("#oetSearchPdtHTML")
    .val()
    .toLowerCase();
  $("#otbDOCPdtTable tbody tr ").filter(function () {
    tText = $(this).toggle(
      $(this)
        .text()
        .toLowerCase()
        .indexOf(value) > -1
    );
  });
}

function JSxTFWSetBchAddressAfterSelectBch(poJsonData) {

  //ถ้าไม่มีการเลือก มาจะส่ง NULL
  if (poJsonData != "NULL") {
    aData = JSON.parse(poJsonData);
    tAddBch = aData[0];
    tAddSeqNo = aData[1];
  }
  JSxSetSeqConditionBch(poJsonData);
}

// function JSxTFWAftSelectShipAddress(poJsonData) {
//   tBchCode = $("#oetBchCode").val();
//   //ถ้าไม่มีการเลือก มาจะส่ง NULL
//   if (poJsonData != "NULL") {
//     aData = JSON.parse(poJsonData);
//     tAddBch = aData[0];
//     tAddSeqNo = aData[1];
//   } else {
//     tAddBch = 0;
//     tAddSeqNo = 0;
//   }

//   JSvTFWGetShipAddData(tBchCode, tAddSeqNo);
// }

//Get ข้อมูล Address มาใส่ modal แบบ Array
function JSvTFWGetShipAddData(pTAddressInfor) {
  if (pTAddressInfor !== "NULL") {
    var aData = JSON.parse(pTAddressInfor);
    $("#ospShipAddAddV1No").text(aData[1]);
    $("#ospShipAddV1Soi").text(aData[2]);
    $("#ospShipAddV1Village").text(aData[3]);
    $("#ospShipAddV1Road").text(aData[4]);
    $("#ospShipAddV1SubDist").text(aData[5]);
    $("#ospShipAddV1DstCode").text(aData[6]);
    $("#ospShipAddV1PvnCode").text(aData[7]);
    $("#ospShipAddV1PostCode").text(aData[8]);
    $("#ospShipAddV2Desc1").text(aData[9]);
    $("#ospShipAddV2Desc2").text(aData[10]);
  } else {
    $("#ospShipAddAddV1No").text("-");
    $("#ospShipAddV1Soi").text("-");
    $("#ospShipAddV1Village").text("-");
    $("#ospShipAddV1Road").text("-");
    $("#ospShipAddV1SubDist").text("-");
    $("#ospShipAddV1DstCode").text("-");
    $("#ospShipAddV1PvnCode").text("-");
    $("#ospShipAddV1PostCode").text("-");
    $("#ospShipAddV2Desc1").text("-");
    $("#ospShipAddV2Desc2").text("-");
  }

  // $.ajax({
  //   type: "POST",
  //   url: "TFWGetAddress",
  //   data: {
  //     tBchCode: tBchCode,
  //     tXthShipAdd: tXthShipAdd
  //   },
  //   cache: false,
  //   Timeout: 0,
  //   success: function (tResult) {
  //     aData = JSON.parse(tResult);

  //     if (aData != 0) {
  //       $("#ospShipAddAddV1No").text(aData[0]["FTAddV1No"]);
  //       $("#ospShipAddV1Soi").text(aData[0]["FTAddV1Soi"]);
  //       $("#ospShipAddV1Village").text(aData[0]["FTAddV1Village"]);
  //       $("#ospShipAddV1Road").text(aData[0]["FTAddV1Road"]);
  //       $("#ospShipAddV1SubDist").text(aData[0]["FTSudName"]);
  //       $("#ospShipAddV1DstCode").text(aData[0]["FTDstName"]);
  //       $("#ospShipAddV1PvnCode").text(aData[0]["FTPvnName"]);
  //       $("#ospShipAddV1PostCode").text(aData[0]["FTAddV1PostCode"]);
  //       $("#ospShipAddV2Desc1").text(aData[0]["FTAddV2Desc1"]);
  //       $("#ospShipAddV2Desc2").text(aData[0]["FTAddV2Desc2"]);
  //     } else {
  //       $("#ospShipAddAddV1No").text("-");
  //       $("#ospShipAddV1Soi").text("-");
  //       $("#ospShipAddV1Village").text("-");
  //       $("#ospShipAddV1Road").text("-");
  //       $("#ospShipAddV1SubDist").text("-");
  //       $("#ospShipAddV1DstCode").text("-");
  //       $("#ospShipAddV1PvnCode").text("-");
  //       $("#ospShipAddV1PostCode").text("-");
  //       $("#ospShipAddV2Desc1").text("-");
  //       $("#ospShipAddV2Desc2").text("-");
  //     }

  //     //เอาค่าจาก input หลัก มาใส่ input ใน modal
  //     $("#ohdShipAddSeqNo").val(tXthShipAdd);
  //     $(".modal.fade:not(#odvTFWBrowseShipAdd)").remove();
  //     //Show
  //     $("#odvTFWBrowseShipAdd").modal("show");
  //   },
  //   error: function (jqXHR, textStatus, errorThrown) { }
  // });



}

// function JSnTFWApprove(pbIsConfirm){

//     tXthDocNo = $('#oetXthDocNo').val();

//     if(pbIsConfirm){

//         $.ajax({
//             type: "POST",
//             url: "TFWApprove",
//             data: {
//                 tXthDocNo : tXthDocNo
//             },
//             cache: false,
//             timeout: 5000,
//             success: function(tResult){

//                 $("#odvTFWPopupApv").modal('hide');

//                 aResult = $.parseJSON(tResult);
//                 if(aResult.nSta == 1){
//                     JSvCallPageTFWEdit(tXthDocNo)
//                 }else{
//                     JCNxCloseLoading();
//                     tMsgBody = aResult.tMsg
//                     FSvCMNSetMsgWarningDialog(tMsgBody);
//                 }

//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 JCNxResponseError(jqXHR, textStatus, errorThrown);
//             }
//         });
//     }else{
//         $("#odvTFWPopupApv").modal('show');
//     }
// }

/**
 * Functionality : Action for approve
 * Parameters : pbIsConfirm
 * Creator : 11/04/2019 Krit(Copter)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnTFWApprove(pbIsConfirm) {

  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    try {
      if (pbIsConfirm) {
        $("#ohdCardShiftTopUpCardStaPrcDoc").val(2); // Set status for processing approve
        $("#odvTFWPopupApv").modal("hide");

        var tXthDocNo = $("#oetXthDocNo").val();
        var tXthStaApv = $("#ohdXthStaApv").val();
        $.ajax({
          type: "POST",
          url: "ADJSTKVDApprove",
          data: {
            tXthDocNo: tXthDocNo,
            tXthStaApv: tXthStaApv
          },
          cache: false,
          timeout: 0,
          success: function (tResult) {
            tResult = tResult.replace("\r\n","");
            let oResult = JSON.parse(tResult);
            if (oResult["nStaEvent"] == "900") {
              FSvCMNSetMsgErrorDialog(oResult["tStaMessg"]);
            }else{
              JSoTFWSubscribeMQ();
            }

          },
          error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
        });
      } else {
        //console.log("StaApvDoc Call Modal");
        $("#odvTFWPopupApv").modal("show");
      }
    } catch (err) {
      console.log("JSnTFWApprove Error: ", err);
    }
  } else {
    JCNxShowMsgSessionExpired();
  }
}



//Functionality : main validate form (validate ขั้นที่ พิเศษ ตรวจสอบเลขที่การขนส่ง)
//Parameters : -
//Creator : 22/05/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxValidateViaOrderBeforeApv(pbIsConfirm) {
  // if (!$($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) {
  //   if($("#oetOldPosCodeEnd").val()==$("#oetPosCodeEnd").val() && 
  //      $("#oetOldShpCodeEnd").val()==$("#oetShpCodeEnd").val()){
  //     if($("#oetOldPosCodeEnd").val()!=""){
  //       $("#odvDelivery").addClass("in");
  //       if ($("#ohdCheckTFWClearValidate").val() != 2) {
  //         $('#ofmAddTFW').validate().destroy();
  //       }
  //       $.ajax({
  //         type: "POST",
  //         url: "ADJSTKVDCheckViaCodeForApv",
  //         data: {
  //           tXthDocNo: $("#oetXthDocNo").val()
  //         },
  //         cache: false,
  //         timeout: 0,
  //         success: function (ptResult) {
  //           var oResult = JSON.parse(ptResult);
  //           if(oResult["staPrc"]){
  //             $('#ofmAddTFW').validate({
  //               focusInvalid: true,
  //               onclick: false,
  //               onfocusout: false,
  //               onkeyup: false,
  //               rules: {
  //                 oetViaName: {
  //                   "required": {
  //                     depends: function (oElement) {
  //                       if(oResult["staHasVia"]){
  //                         return false;
  //                       }else{
  //                         return true;
  //                       }
  //                     }
  //                   }
  //                 }
  //               },
  //               messages: {
  //                 oetViaName: {
  //                   "required": "โปรดระบุ ขนส่งโดย"
  //                 }
  //               },
  //               errorElement: "em",
  //               errorPlacement: function (error, element) {
  //                 error.addClass("help-block");
  //                 if (element.prop("type") === "checkbox") {
  //                   error.appendTo(element.parent("label"));
  //                 } else {
  //                   var tCheck = $(element.closest('.form-group')).find('.help-block').length;
  //                   if (tCheck == 0) {
  //                     error.appendTo(element.closest('.form-group')).trigger('change');
  //                   }
  //                 }
  //               },
  //               highlight: function (element, errorClass, validClass) {
  //                 $(element).closest('.form-group').addClass("has-error");
  //               },
  //               unhighlight: function (element, errorClass, validClass) {
  //                 $(element).closest('.form-group').removeClass("has-error");
  //               },
  //               submitHandler: function (form) {
  //                 if ($("#ohdCheckTFWSubmitByButton").val() == 2) {
  //                   if($("#oetViaCode").val()==oResult["FTViaCode"]){
                      JSnTFWApprove(pbIsConfirm);
  //                   }else{
  //                     FSvCMNSetMsgWarningDialog("<p>โปรดทำการเลือก ขนส่งโดย และบันทึกข้อมูล</p>");
  //                   }
  //                 }
  //               }
  //             });
  //           }
  //           $("#ofmAddTFW").submit();
  //           $("#ohdCheckTFWClearValidate").val(2);
            
  //         },
  //         error: function (jqXHR, textStatus, errorThrown) {
  //           JCNxResponseError(jqXHR, textStatus, errorThrown);
  //         }
  //       });
  //     }else{
  //       JSnTFWApprove(pbIsConfirm);
  //     }
  //   }else{
  //     FSvCMNSetMsgWarningDialog("<p>โปรดทำการบันทึกข้อมูลใหม่</p>");
  //   }
  // }else{
  //   JSnTFWApprove(pbIsConfirm);
  // }
}



/**
 * Functionality : Action for approve
 * Parameters : pbIsConfirm
 * Creator : 11/04/2019 Krit(Copter)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSoTFWSubscribeMQ() {
  //RabbitMQ
  /*===========================================================================*/
  // Document variable
  var tLangCode = $("#ohdLangEdit").val();
  var tUsrBchCode = $("#ohdBchCode").val();
  var tUsrApv = $("#oetXthApvCodeUsrLogin").val();
  var tDocNo = $("#oetXthDocNo").val();
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
    host: "ws://"+oSTOMMQConfig.host+":15674/ws",
    username: oSTOMMQConfig.user,
    password: oSTOMMQConfig.password,
    vHost: oSTOMMQConfig.vhost
  };

  // Update Status For Delete Qname Parameter
  var poUpdateStaDelQnameParams = {
    ptDocTableName: "TCNTPdtAdjStkHD",
    ptDocFieldDocNo: "FTXthDocNo",
    ptDocFieldStaApv: "FTXthStaPrcStk",
    ptDocFieldStaDelMQ: "FTXthStaDelMQ",
    ptDocStaDelMQ: tStaDelMQ,
    ptDocNo: tDocNo
  };

  // Callback Page Control(function)
  var poCallback = {
    tCallPageEdit: "JSvCallPageTFWEdit",
    tCallPageList: "JSvCallPageTFWList"
  };

  //Check Show Progress %
  FSxCMNRabbitMQMessage(
    poDocConfig,
    poMqConfig,
    poUpdateStaDelQnameParams,
    poCallback
  );
  /*===========================================================================*/
  //RabbitMQ
}

function JSnTFWCancel(pbIsConfirm) {
  tXthDocNo = $("#oetXthDocNo").val();
  
  if (pbIsConfirm) {
    $.ajax({
      type: "POST",
      url: "ADJSTKVDCancel",
      data: {
        tXthDocNo: tXthDocNo
      },
      cache: false,
      timeout: 5000,
      success: function (tResult) {
        $("#odvTFWPopupCancel").modal("hide");

        aResult = $.parseJSON(tResult);
        if (aResult.nSta == 1) {
          JSvCallPageTFWEdit(tXthDocNo);
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

    $("#odvTFWPopupCancel").modal("show");
  }
}

/**
 * Functionality : พิมพ์เอกสาร
 * Parameters : 
 * Creator : 27/05/2019 Pap
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxTFXPrintFormReport(){

}

//Function : GET Scan BarCode
function JSvTFWScanPdtHTML() {
  tBarCode = $("#oetScanPdtHTML").val();
  tSplCode = $("#oetSplCode").val();

  if (tBarCode != "") {
    JCNxOpenLoading();

    $.ajax({
      type: "POST",
      url: "ADJSTKVDGetPdtBarCode",
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
          FSvTFWAddPdtIntoTableDT(tPdtCode, tPunCode);

          $("#oetScanPdtHTML").val("");
          $("#oetScanPdtHTML").focus();
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
    $("#oetScanPdtHTML").focus();
  }
}

function JSnTFWRemoveAllDTInFile() {
  ptXthDocNo = $("#oetXthDocNo").val();

  $.ajax({
    type: "POST",
    url: "ADJSTKVDRemoveAllPdtInFile",
    data: {
      ptXthDocNo: ptXthDocNo
    },
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      JSvTFWLoadPdtDataTableHtml(1);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

function JSnTFWRemoveDTTemp(ptSeqno, ptPdtCode) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    ptXthDocNo = $("#oetXthDocNo").val();
    nPage = $(".xWPageTFWPdt .active").text();

    $.ajax({
      type: "POST",
      url: "ADJSTKVDRemovePdtInDTTmp",
      data: {
        ptXthDocNo: ptXthDocNo,
        ptSeqno: ptSeqno,
        ptPdtCode: ptPdtCode
      },
      cache: false,
      timeout: 5000,
      success: function (tResult) {
        JSvTFWLoadPdtDataTableHtml(nPage);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

function JSnTFWRemoveDTInFile(ptIndex, ptPdtCode) {
  ptXthDocNo = $("#oetXthDocNo").val();

  $.ajax({
    type: "POST",
    url: "ADJSTKVDRemovePdtInFile",
    data: {
      ptXthDocNo: ptXthDocNo,
      ptIndex: ptIndex,
      ptPdtCode: ptPdtCode
    },
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      JSvTFWLoadPdtDataTableHtml(1);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
//Create : 2018-08-28 Krit(Copter)
function FSvTFWAddPdtIntoTableDT(ptPdtCode, ptPunCode, pnXthVATInOrEx) {
  ptOptDocAdd = $("#ohdOptScanSku").val();

  JCNxOpenLoading();

  ptXthDocNo = $("#oetXthDocNo").val();
  ptBchCode = $("#ohdSesUsrBchCode").val();

  $.ajax({
    type: "POST",
    url: "TFWAddPdtIntoTableDT",
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

      JSvTFWLoadPdtDataTableHtml(1);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
//Create : 2018-08-28 Krit(Copter)
function FSvTFWEditPdtIntoTableDT(ptEditSeqNo, paField, paValue) {
  ptXthDocNo = $("#oetXthDocNo").val();
  ptBchCode = $("#ohdSesUsrBchCode").val();

  $.ajax({
    type: "POST",
    url: "ADJSTKVDEditPdtIntoTableDT",
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

      JSvTFWLoadPdtDataTableHtml(1);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

function FSvGetSelectShpByBch(ptBchCode) {
  $.ajax({
    type: "POST",
    url: "ADJSTKVDGetShpByBch",
    data: { ptBchCode: ptBchCode },
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      var tData = $.parseJSON(tResult);

      $("#ostShpCode option").each(function () {
        if ($(this).val() != "") {
          $(this).remove();
        }
      });

      if (tData.raItems != undefined) {
        for (var i = 0; i < tData.raItems.length; i++) {
          if (tData.raItems[i].rtShpCode != "") {
            //    $('.xWostShpCode #ostShpCode').append($('option')
            //                    .val(tData.raItems[i].rtShpCode)
            //                    .text(tData.raItems[i].rtShpName)
            //    );
            var data = {
              id: tData.raItems[i].rtShpCode,
              text: tData.raItems[i].rtShpName
            };

            var newOption = new Option(data.text, data.id, false, false);
            $("#ostShpCode")
              .append(newOption)
              .trigger("change");
          }
        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Functionality : Call Purchase Page Add
//Parameters : -
//Creator : 02/07/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvCallPageTFWAdd() {
  JCNxOpenLoading();
  $.ajax({
    type: "POST",
    url: "ADJSTKVDPageAdd",
    data: {},
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      nIndexInputEditInlineForVD=0;
      if (nStaTFWBrowseType == 1) {
        $(".xCNTFWVMaster").hide();
        $(".xCNTFWVBrowse").show();
      } else {
        $(".xCNTFWVBrowse").hide();
        $(".xCNTFWVMaster").show();
        $("#oliTFWTitleEdit").hide();
        $("#oliTFWTitleAdd").show();
        $("#odvBtnTFWInfo").hide();
        $("#odvBtnAddEdit").show();
        $("#obtTFWApprove").hide();
        $("#obtTFWPrint").hide();
        $("#obtTFWCancel").hide();
        $("#oliPITitleDetail").hide();
      // ================== Create By Witsarut 28/08/2019 ==================
        $(".xWBtnGrpSaveLeft").show();
        $(".xWBtnGrpSaveRight").show();                      
      // ================== Create By Witsarut 28/08/2019 ==================

      }
      $("#odvContentPageTFW").html(tResult);
      
      // Control Object And Button ปิด เปิด
      JCNxTFWControlObjAndBtn();
      //Load Pdt Table


      if ($("#oetBchCode").val() == "") {
        $("#obtTFWBrowseShipAdd").attr("disabled", "disabled");


      }
      $('#ocbTFWAutoGenCode').change(function () {
        $("#oetXthDocNo").val("");
        if ($('#ocbTFWAutoGenCode').is(':checked')) {
          $("#oetXthDocNo").attr("readonly", true);
          $("#oetXthDocNo").attr("onfocus", "this.blur()");
          $('#ofmAddTFW').removeClass('has-error');
          $('#ofmAddTFW .form-group').closest('.form-group').removeClass("has-error");
          $('#ofmAddTFW em').remove();
        } else {
          $("#oetXthDocNo").attr("readonly", false);
          $("#oetXthDocNo").removeAttr("onfocus");
        }

      });
      $("#oetXthDocNo,#oetXthDocDate,#oetXthDocTime").bind("blur change",function () {
        JSxSetStatusClickTFWSubmit(0);
        JSxValidateFormAddTFW();
        $('#ofmAddTFW').submit();
      });

      $(".xWConditionSearchPdt.disabled").attr("disabled", "disabled");
      // $("#obtDocBrowsePdt.disabled").attr("disabled","disabled");
      // $("#obtDocBrowsePdt").css("opacity","0.4");
      // $("#obtDocBrowsePdt").css("cursor","not-allowed");

      // if ($($($($("#obtTFWBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")==false||
      //     $($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")==false) {
      //     if($("#oetPosCodeStart").val()!="" || $("#oetPosCodeEnd").val()!=""){
      //       $("#obtTWXVDControlForm").removeAttr("disabled");
      //     }
      // }else{
      //   $("#obtTWXVDControlForm").attr("disabled","disabled");
      // }
      $("#ohdCheckSetDataDTFromTmp").val(1);
      JSvTFWLoadPdtDataTableHtml(1);
      
      $("#obtTWXVDControlForm").click(function(){
        JCNxOpenLoading();
        $("#ohdCheckSetDataDTFromTmp").val(1);
        JSvTFWLoadPdtDataTableHtml(1);
      });
      $("#obtTWXVDControlFormClear").click(function(){
        $("#oetMchCode").val("");
        $("#oetMchName").val("");
        $("#oetShpCodeStart").val("");
        $("#oetShpNameStart").val("");
        $($("#obtTFWBrowseShpStart").parent()).addClass("disabled");
        $($("#obtTFWBrowseShpStart").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseShpStart").addClass("disabled");
        $("#obtTFWBrowseShpStart").attr("disabled", "disabled");
        $("#oetPosCodeStart").val("");
        $("#oetPosNameStart").val("");
        $($("#obtTFWBrowsePosStart").parent()).addClass("disabled");
        $($("#obtTFWBrowsePosStart").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowsePosStart").addClass("disabled");
        $("#obtTFWBrowsePosStart").attr("disabled", "disabled");
        //$($($($("#obtTFWBrowsePosStart").parent()).parent()).parent()).addClass("xCNHide");
        $("#ohdWahCodeStart").val("");
        $("#oetWahNameStart").val("");
        $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
        $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseWahStart").addClass("disabled");
        $("#obtTFWBrowseWahStart").attr("disabled", "disabled");
        
        $("#oetShpCodeEnd").val("");
        $("#oetShpNameEnd").val("");
        $($("#obtTFWBrowseShpEnd").parent()).addClass("disabled");
        $($("#obtTFWBrowseShpEnd").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseShpEnd").addClass("disabled");
        $("#obtTFWBrowseShpEnd").attr("disabled", "disabled");
        $("#oetPosCodeEnd").val("");
        $("#oetPosNameEnd").val("");
        $($("#obtTFWBrowsePosEnd").parent()).addClass("disabled");
        $($("#obtTFWBrowsePosEnd").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowsePosEnd").addClass("disabled");
        $("#obtTFWBrowsePosEnd").attr("disabled", "disabled");
        $($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).addClass("xCNHide");
        $("#ohdWahCodeEnd").val("");
        $("#oetWahNameEnd").val("");
        $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
        $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseWahEnd").addClass("disabled");
        $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");
      });
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Functionality : main validate form (validate ขั้นที่ 1 ตรวจสอบทั่วไป)
//Parameters : -
//Creator : 26/04/2019 pap
//Update : -
//Return : -
//Return Type : - 
function JSxValidateFormAddTFW() {
  if ($("#ohdCheckTFWClearValidate").val() != 0) {
    $('#ofmAddTFW').validate().destroy();
  }
  $('#ofmAddTFW').validate({
    focusInvalid: false,
    onclick: false,
    onfocusout: false,
    onkeyup: false,
    rules: {
      oetXthDocNo: {
        "required": {
          depends: function (oElement) {
            if ($("#ohdTFWRoute").val() == "ADJSTKVDEventAdd") {
              if ($('#ocbTFWAutoGenCode').is(':checked')) {
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
      oetXthDocDate: {
        "required": true
      },
      oetXthDocTime: {
        "required": true
      },
      oetWahNameStart: {
        "required": true
      },
      oetWahNameEnd: {
        "required": true
      }
    },
    messages: {
      oetXthDocNo: {
        "required": $('#oetXthDocNo').attr('data-validate-required')
      },
      oetXthDocDate: {
        "required": $('#oetXthDocDate').attr('data-validate-required')
      },
      oetXthDocTime: {
        "required": $('#oetXthDocTime').attr('data-validate-required')
      },
      oetWahNameStart: {
        "required": $('#oetWahNameStart').attr('data-validate-required')
      },
      oetWahNameEnd: {
        "required": $('#oetWahNameEnd').attr('data-validate-required')
      },
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
    invalidHandler: function(event, validator) {
      if ($("#ohdCheckTFWSubmitByButton").val() == 1) {
        FSvCMNSetMsgWarningDialog("<p>โปรดระบุข้อมูลให้สมบูรณ์</p>");
      }
      if($('#oetPosNameStart').val()=="" || $('#oetWahNameStart').val()==""){
        $("#obtTWXVDControlForm").attr("disabled","disabled");
        $("#obtTWXVDControlForm").addClass("disabled");
      }else{
        $("#obtTWXVDControlForm").removeAttr("disabled");
        $("#obtTWXVDControlForm").removeClass("disabled");
      }
    },
    submitHandler: function (form) {
      if($('#oetPosNameStart').val()=="" || $('#oetWahNameStart').val()==""){
        $("#obtTWXVDControlForm").attr("disabled","disabled");
        $("#obtTWXVDControlForm").addClass("disabled");
      }else{
        $("#obtTWXVDControlForm").removeAttr("disabled");
        $("#obtTWXVDControlForm").removeClass("disabled");
      }
      if (!$('#ocbTFWAutoGenCode').is(':checked')) {
        JSxValidateTFWCodeDublicate();
      } else {
        if ($("#ohdCheckTFWSubmitByButton").val() == 1) {
          JSxSubmitEventByButton();
        }
      }
    }
  });
  if ($("#ohdCheckTFWClearValidate").val() != 0) {
    $("#ofmAddTFW").submit();
    $("#ohdCheckTFWClearValidate").val(0);
  }
}

//Functionality : validate TFW Code (validate ขั้นที่ 2 ตรวจสอบรหัสเอกสาร)
//Parameters : -
//Creator : 07/05/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxValidateTFWCodeDublicate() {
  $.ajax({
    type: "POST",
    url: "CheckInputGenCode",
    data: {
      tTableName: "TCNTPdtAdjStkHD",
      tFieldName: "FTAjhDocNo",
      tCode: $("#oetXthDocNo").val()
    },
    cache: false,
    timeout: 0,
    success: function (tResult) {
      var aResult = JSON.parse(tResult);
      $("#ohdCheckDuplicateTFW").val(aResult["rtCode"]);
      if ($("#ohdCheckTFWClearValidate").val() != 1) {
        $('#ofmAddTFW').validate().destroy();
      }
      $.validator.addMethod('dublicateCode', function (value, element) {
        if ($("#ohdTFWRoute").val() == "ADJSTKVDEventAdd") {
          if ($('#ocbTFWAutoGenCode').is(':checked')) {
            return true;
          } else {
            if ($("#ohdCheckDuplicateTFW").val() == 1) {
              return false;
            } else {
              return true;
            }
          }
        } else {
          return true;
        }
      });
      $('#ofmAddTFW').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
          oetXthDocNo: {
            "dublicateCode": {}
          }
        },
        messages: {
          oetXthDocNo: {
            "dublicateCode": "ไม่สามารถใช้รหัสเอกสารนี้ได้"
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
        invalidHandler: function(event, validator) {
          if ($("#ohdCheckTFWSubmitByButton").val() == 1) {
            FSvCMNSetMsgWarningDialog("<p>โปรดระบุข้อมูลให้สมบูรณ์</p>");
          }
          if($('#oetPosNameStart').val()=="" || $('#oetWahNameStart').val()==""){
            $("#obtTWXVDControlForm").attr("disabled","disabled");
            $("#obtTWXVDControlForm").addClass("disabled");
          }else{
            $("#obtTWXVDControlForm").removeAttr("disabled");
            $("#obtTWXVDControlForm").removeClass("disabled");
          }
        },
        highlight: function (element, errorClass, validClass) {
          $(element).closest('.form-group').addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).closest('.form-group').removeClass("has-error");
        },
        submitHandler: function (form) {
          if($('#oetPosNameStart').val()=="" || $('#oetWahNameStart').val()==""){
            $("#obtTWXVDControlForm").attr("disabled","disabled");
            $("#obtTWXVDControlForm").addClass("disabled");
          }else{
            $("#obtTWXVDControlForm").removeAttr("disabled");
            $("#obtTWXVDControlForm").removeClass("disabled");
          }
          if ($("#ohdCheckTFWSubmitByButton").val() == 1) {
            JSxSubmitEventByButton();
          }
        }
      });
      if ($("#ohdCheckTFWClearValidate").val() != 1) {
        $("#ofmAddTFW").submit();
        $("#ohdCheckTFWClearValidate").val(1);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Functionality : function submit by submit button only (ส่งข้อมูลที่ผ่านการ validate ไปบันทึกฐานข้อมูล)
//Parameters : route
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSubmitEventByButton() {
  var tDocNoSend = ""
  if ($("#ohdTFWRoute").val() != "ADJSTKVDEventAdd") {
    tDocNoSend = $("#oetXthDocNo").val();
  }
  $.ajax({
    type: "POST",
    url: "ADJSTKVDCheckPdtTmpForTransfer",
    data: { tDocNo: tDocNoSend },
    cache: false,
    timeout: 0,
    success: function (tResult) {
      var bReturn = JSON.parse(tResult);
      if (bReturn) {
        $.ajax({
          type: "POST",
          url: $("#ohdTFWRoute").val(),
          data: $("#ofmAddTFW").serialize(),
          cache: false,
          timeout: 0,
          success: function (tResult) {
            
            if (nStaTFWBrowseType != 1) {
              tResult = tResult.replace("\r\n","");
              let oResult = JSON.parse(tResult);
              if (oResult["nStaEvent"] == "900") {
                FSvCMNSetMsgErrorDialog(oResult["tStaMessg"]);
              }else{
                if (
                  oResult["nStaCallBack"] == "1" ||
                  oResult["nStaCallBack"] == null
                ) {
                  JSvCallPageTFWEdit(oResult["tCodeReturn"]);
                } else if (oResult["nStaCallBack"] == "2") {
                  JSvCallPageTFWAdd();
                } else if (oResult["nStaCallBack"] == "3") {
                  JSvCallPageTFWList();
                }
              }
            }
            //else {
            //   JCNxBrowseData(tCallTFWBackOption);
            // }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
        });
      } else {
        FSvCMNSetMsgWarningDialog("<p>โปรดระบุสินค้าที่ท่านต้องการทำการโอน</p>");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Functionality : เซ็ตค่าเพื่อให้รู้ว่าตอนนี้กดปุ่มบันทึกหลักจริงๆ (เพราะมีการซัมมิทฟอร์มแต่ไม่บันทึกเพื่อให้เกิด validate ใน on blur)
//Parameters : -
//Creator : 26/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSetStatusClickTFWSubmit(pnStatus) {
  $("#ohdCheckTFWSubmitByButton").val(pnStatus);
}

// //Functionality : (event) Add/Edit
// //Parameters : form
// //Creator : 02/07/2018 Krit(Copter)
// //Return : Status Add
// //Return Type : n
function JSnAddEditTFW() {
  JSxValidateFormAddTFW();
}


function JSnPmhAddCondition() {
  $("#ofmAddCondition").validate({
    rules: {
      oetPmcGrpName: "required",
      oetPmcStaGrpCond: "required",
      oetPmcBuyQty: "required",
      oetPmcBuyAmt: "required",
      ostPmcGetCond: "required"
    },
    messages: {
      oetPmcGrpName: "",
      oetPmcStaGrpCond: "",
      oetPmcBuyQty: "",
      oetPmcBuyAmt: "",
      ostPmcGetCond: ""
    },
    errorClass: "alert-validate",
    validClass: "",
    highlight: function (element, errorClass, validClass) {
      $(element)
        .parent(".validate-input")
        .addClass(errorClass)
        .removeClass(validClass);
      $(element)
        .parent()
        .parent(".validate-input")
        .addClass(errorClass)
        .removeClass(validClass);
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element)
        .parent(".validate-input")
        .removeClass(errorClass)
        .addClass(validClass);
      $(element)
        .parent()
        .parent(".validate-input")
        .removeClass(errorClass)
        .addClass(validClass);
    },
    submitHandler: function (form) {
      //กลุ่ม
      nPmcGrpName = $("#oetPmcGrpName").val();
      tPmcGrpName = $("#oetPmcGrpName option:selected").text();

      //ประเภทการซื้อ/รับ
      nPmcStaGrpCond = $("#oetPmcStaGrpCond").val();
      tPmcStaGrpCond = $("#oetPmcStaGrpCond option:selected").text();

      //put ลง Input hiden เพื่อเช็คประเภท
      if (nPmcStaGrpCond != "" || nPmcStaGrpCond == undefined) {
        tStaGrpCondHave = $("#ohdStaGrpCondHave").val();

        if (tStaGrpCondHave != "") {
          tStaGrpCondHave += "," + nPmcStaGrpCond;
          $("#ohdStaGrpCondHave").val(tStaGrpCondHave);
        } else {
          $("#ohdStaGrpCondHave").val(nPmcStaGrpCond);
        }
      }

      //ซื้อครบจำนวน
      nPmcBuyQty = $("#oetPmcBuyQty").val();
      if (nPmcBuyQty == "" || nPmcBuyQty == undefined) {
        nPmcBuyQty = "-";
      } else {
        nPmcBuyQty = parseFloat(nPmcBuyQty);
        nPmcBuyQty = nPmcBuyQty.toFixed(2);
      }

      //ซื้อครบมูลค่า
      nPmcBuyAmt = $("#oetPmcBuyAmt").val();
      if (nPmcBuyAmt == "" || nPmcBuyAmt == undefined) {
        nPmcBuyAmt = "-";
      } else {
        nPmcBuyAmt = parseFloat(nPmcBuyAmt);
        nPmcBuyAmt = nPmcBuyAmt.toFixed(2);
      }

      //รูปแบบส่วนลด
      nPmcGetCond = $("#ostPmcGetCond").val();
      tPmcGetCond = $("#ostPmcGetCond option:selected").text();

      if (nPmcGetCond == 4) {
        ohdControllCound = $("#ohdControllCound").val();
        $("#ohdControllCound").val(ohdControllCound + nPmcGetCond + ",");
      }

      //Avg %
      nPmcPerAvgDis = $("#oetPmcPerAvgDis").val();
      if (nPmcPerAvgDis == "" || nPmcPerAvgDis == undefined) {
        nPmcPerAvgDis = "-";
      } else {
        nPmcPerAvgDis = parseFloat(nPmcPerAvgDis);
        nPmcPerAvgDis = nPmcPerAvgDis.toFixed(2);
      }

      //มูลค่า
      nPmcGetValue = $("#oetPmcGetValue").val();
      if (nPmcGetValue == "" || nPmcGetValue == undefined) {
        nPmcGetValue = "-";
      } else {
        nPmcGetValue = parseFloat(nPmcGetValue);
        nPmcGetValue = nPmcGetValue.toFixed(2);
      }

      //จำนวน
      nPmcGetQty = $("#oetPmcGetQty").val();
      if (nPmcGetQty == "" || nPmcGetQty == undefined) {
        nPmcGetQty = "-";
      } else {
        nPmcGetQty = parseFloat(nPmcGetQty);
        nPmcGetQty = nPmcGetQty.toFixed(2);
      }

      //ขั้นต่ำ
      nPmcBuyMinQty = $("#oetPmcBuyMinQty").val();
      if (nPmcBuyMinQty == "" || nPmcBuyMinQty == undefined) {
        nPmcBuyMinQty = "-";
      } else {
        nPmcBuyMinQty = parseFloat(nPmcBuyMinQty);
        nPmcBuyMinQty = nPmcBuyMinQty.toFixed(2);
      }

      //ไม่เกิน
      nPmcBuyMaxQty = $("#oetPmcBuyMaxQty").val();
      if (nPmcBuyMaxQty == "" || nPmcBuyMaxQty == undefined) {
        nPmcBuyMaxQty = "-";
      } else {
        nPmcBuyMaxQty = parseFloat(nPmcBuyMaxQty);
        nPmcBuyMaxQty = nPmcBuyMaxQty.toFixed(2);
      }

      ohdSpmStaBuy = $("#ohdSpmStaBuy").val();
      if (ohdSpmStaBuy == "3" || ohdSpmStaBuy == "4") {
        nBuyVal = nPmcBuyQty;
      } else if (ohdSpmStaBuy == "1" || ohdSpmStaBuy == "2") {
        nBuyVal = nPmcBuyAmt;
      }

      var nRows = $("#odvCondition tr.xWCondition").length;
      var nRows = nRows + 1;

      if (nRows >= 0) {
        //Append Tr Unit
        $("#odvCondition").append(
          $("<tr>")
            .addClass("text-center xCNTextDetail2 xWCondition")
            .attr("id", "otrCondition" + nRows)
            .attr("data-grpcound", nPmcStaGrpCond)
            .attr("data-getcound", nPmcGetCond)
            .attr("data-name", tPmcGrpName)

            //<input type="text" name="ohdCondition[]" value="1,กลุ่มซื้อ,1,1,,10,11,12">
            .append(
              $("<input>")
                .addClass("xCNHide " + "xWValHiden" + nPmcGrpName)
                .attr("name", "ohdCondition[]")
                .val(
                  nRows +
                  "," +
                  tPmcGrpName +
                  "," +
                  nPmcStaGrpCond +
                  "," +
                  nPmcPerAvgDis +
                  "," +
                  nPmcGetValue +
                  "," +
                  nPmcGetQty +
                  "," +
                  nPmcGetCond +
                  "," +
                  nPmcBuyAmt +
                  "," +
                  nPmcBuyQty +
                  "," +
                  nPmcBuyMinQty +
                  "," +
                  nPmcBuyMaxQty +
                  "," +
                  nPmcGrpName
                )
            )

            //Append Td ลำดับ
            .append($("<td>").text(nRows))

            //Append Td กลุ่ม
            .append(
              $("<td>")
                .addClass("text-left " + "xWPut" + nPmcGrpName)
                .text(tPmcGrpName)
            )

            //Append Td ซื้อ/ร้บ
            .append($("<td>").text(tPmcStaGrpCond))

            //Append Td Avg
            .append(
              $("<td>")
                .addClass("text-right")
                .text(nPmcPerAvgDis)
            )

            //Append Td Buy Amt
            .append(
              $("<td>")
                .addClass("text-right")
                .text(nPmcBuyAmt)
            )

            //Append Td Buy Qty
            .append(
              $("<td>")
                .addClass("text-right")
                .text(nPmcBuyQty)
            )

            //Append Td Min Amt
            .append(
              $("<td>")
                .addClass("text-right")
                .text(nPmcBuyMinQty)
            )

            //Append Td Max Amt
            .append(
              $("<td>")
                .addClass("text-right")
                .text(nPmcBuyMaxQty)
            )

            //Append Td Value
            .append(
              $("<td>")
                .addClass("text-right")
                .text(nPmcGetValue)
            )

            //Append Td Qty
            .append(
              $("<td>")
                .addClass("text-right")
                .text(nPmcGetQty)
            )

            //Append Td Delete
            .append(
              $("<td>")
                .attr("class", "text-center")
                .append(
                  $("<lable>")
                    .attr("class", "xCNTextLink")
                    .append(
                      $("<i>")
                        .attr("class", "fa fa-trash-o")
                        .attr("onclick", "JSnRemoveRow(this)")
                    )
                )
            )
        );
      } else {
        alert("Duplicate");
      }

      $("#").val();

      $("#odvModalPmhCondition").modal("toggle"); /*Close Modal*/

      //Clear Data Input
      $("#odvModalPmhCondition input").val("");
      $("#odvModalPmhCondition select")
        .val("")
        .trigger("change");
      //Clear Data Input

      JSxPMTControlGetCond(); //Check Cound เพื่อ Controll Layout
    },
    errorPlacement: function (error, element) {
      return true;
    }
  });
}


















//สาขา
function JSxSetSeqConditionBch(aInForCon) {
  if (tOldBchCkChange != $("#oetBchCode").val()) {
    // ร้านค้า
    $($("#obtTFWBrowseShpStart").parent()).addClass("disabled");
    $($("#obtTFWBrowseShpStart").parent()).attr("disabled", "disabled");
    $("#obtTFWBrowseShpStart").addClass("disabled");
    $("#obtTFWBrowseShpStart").attr("disabled", "disabled");
    $($("#obtTFWBrowseShpEnd").parent()).addClass("disabled");
    $($("#obtTFWBrowseShpEnd").parent()).attr("disabled", "disabled");
    $("#obtTFWBrowseShpEnd").addClass("disabled");
    $("#obtTFWBrowseShpEnd").attr("disabled", "disabled");
    //เครื่องจุดขาย
    //$($($($("#obtTFWBrowsePosStart").parent()).parent()).parent()).addClass("xCNHide");
    $($("#obtTFWBrowsePosStart").parent()).addClass("disabled");
    $($("#obtTFWBrowsePosStart").parent()).attr("disabled", "disabled");
    $("#obtTFWBrowsePosStart").addClass("disabled");
    $("#obtTFWBrowsePosStart").attr("disabled", "disabled");
    $($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).addClass("xCNHide");
    $($("#obtTFWBrowsePosEnd").parent()).addClass("disabled");
    $($("#obtTFWBrowsePosEnd").parent()).attr("disabled", "disabled");
    $("#obtTFWBrowsePosEnd").addClass("disabled");
    $("#obtTFWBrowsePosEnd").attr("disabled", "disabled");


    $("#oetMchCode").val("");
    $("#oetMchName").val("");
    $("#oetShpCodeStart").val("");
    $("#oetShpNameStart").val("");

    $("#oetShpCodeEnd").val("");
    $("#oetShpNameEnd").val("");

    $("#oetPosCodeStart").val("");
    $("#oetPosNameStart").val("");

    $("#oetPosCodeEnd").val("");
    $("#oetPosNameEnd").val("");

    $("#ohdWahCodeStart").val("");
    $("#oetWahNameStart").val("");
    $("#ohdWahCodeEnd").val("");
    $("#oetWahNameEnd").val("");
    






    if ($("#oetBchCode").val() != "") {
      // $("#obtDocBrowsePdt").removeAttr("disabled");
      // $("#obtDocBrowsePdt").removeClass("disabled");
      // $("#obtDocBrowsePdt").css("opacity","");
      // $("#obtDocBrowsePdt").css("cursor","");


      //กลุ่มร้านค้า

      $($("#obtTFWBrowseMch").parent()).removeClass("disabled");
      $($("#obtTFWBrowseMch").parent()).removeAttr("disabled");
      $("#obtTFWBrowseMch").removeClass("disabled");
      $("#obtTFWBrowseMch").removeAttr("disabled");

      //คลังสินค้า
      $($("#obtTFWBrowseWahStart").parent()).removeClass("disabled");
      $($("#obtTFWBrowseWahStart").parent()).removeAttr("disabled", "disabled");
      $("#obtTFWBrowseWahStart").removeClass("disabled");
      $("#obtTFWBrowseWahStart").removeAttr("disabled", "disabled");

      $($("#obtTFWBrowseWahEnd").parent()).removeClass("disabled");
      $($("#obtTFWBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
      $("#obtTFWBrowseWahEnd").removeClass("disabled");
      $("#obtTFWBrowseWahEnd").removeAttr("disabled", "disabled");



    } else {
      // $("#obtDocBrowsePdt").attr("disabled","disabled");
      // $("#obtDocBrowsePdt").css("opacity","0.4");
      // $("#obtDocBrowsePdt").css("cursor","not-allowed");




      //กลุ่มร้านค้า
      $($("#obtTFWBrowseMch").parent()).addClass("disabled");
      $($("#obtTFWBrowseMch").parent()).attr("disabled", "disabled");
      $("#obtTFWBrowseMch").addClass("disabled", "disabled");
      $("#obtTFWBrowseMch").attr("disabled", "disabled");

      //คลังสินค้า
      $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
      $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
      $("#obtTFWBrowseWahStart").addClass("disabled");
      $("#obtTFWBrowseWahStart").attr("disabled", "disabled");

      $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
      $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
      $("#obtTFWBrowseWahEnd").addClass("disabled");
      $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");

    }

    if ($("#oetBchCode").val() != "" ||
      $("#oetMchCode").val() != "" ||
      $("#oetShpCodeEnd").val() != "" ||
      $("#oetPosCodeEnd").val() != "") {
      $("#obtTFWBrowseShipAdd").removeAttr("disabled");
    } else {
      $("#obtTFWBrowseShipAdd").attr("disabled", "disabled");
    }
    if (tOldBchCkChange != "") {
      if ($("#ohdShipAddSeqNo").val() != "" && $(".xWPdtItem").length == 0) {
        FSvCMNSetMsgWarningDialog("<p>ข้อมูลที่อยู่สำหรับจัดส่งเดิมจะถูกเคลียร์ โปรดทำการระบุข้อมูลที่อยู่สำหรับจัดส่งใหม่</p>");
      } else if ($(".xWPdtItem").length != 0 && $("#ohdShipAddSeqNo").val() == "") {
        FSvCMNSetMsgWarningDialog("<p>รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนสาขาสำหรับจัดส่งสินค้าใหม่</p>");
      } else if ($(".xWPdtItem").length != 0 && $("#ohdShipAddSeqNo").val() != "") {
        FSvCMNSetMsgWarningDialog("<p>ที่อยู่สำหรับจัดส่งและรายการสินค้าที่ท่านเพิ่มไปแล้ว จะถูกล้างค่าเมื่อท่านเปลี่ยนสาขาสำหรับจัดส่งใหม่</p>");
      }
      if ($("#ohdShipAddSeqNo").val() != "") {
        $("#ospShipAddAddV1No").text("-");
        $("#ospShipAddV1Soi").text("-");
        $("#ospShipAddV1Village").text("-");
        $("#ospShipAddV1Road").text("-");
        $("#ospShipAddV1SubDist").text("-");
        $("#ospShipAddV1DstCode").text("-");
        $("#ospShipAddV1PvnCode").text("-");
        $("#ospShipAddV1PostCode").text("-");
        $("#ospShipAddV2Desc1").text("-");
        $("#ospShipAddV2Desc2").text("-");
        $("#ohdShipAddSeqNo").val("");

      }
      if ($(".xWPdtItem").length != 0) {
        JCNxOpenLoading();
        $.ajax({
          type: "POST",
          url: "ADJSTKVDClearDocTemForChngCdt",
          data: {
            tDocNo: $("#oetXthDocNo").val(),
            tBrachCode: $("#oetBchCode").val()
          },
          cache: false,
          timeout: 0,
          success: function (tResult) {
            
            JSvTFWLoadPdtDataTableHtml(1);
            JCNxCloseLoading();
          },
          error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
        });
      }
    }
    tOldBchCkChange = "";
  }


}

//กลุ่มร้านค้า
function JSxSetSeqConditionMerChant(aInForCon) {
  if (tOldMchCkChange != $("#oetMchCode").val()) {
    //เครื่องจุดขาย

    $($("#obtTFWBrowsePosStart").parent()).addClass("disabled");
    $($("#obtTFWBrowsePosStart").parent()).attr("disabled", "disabled");
    $("#obtTFWBrowsePosStart").addClass("disabled");
    $("#obtTFWBrowsePosStart").attr("disabled", "disabled");

    $($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).addClass("xCNHide");
    $($("#obtTFWBrowsePosEnd").parent()).addClass("disabled");
    $($("#obtTFWBrowsePosEnd").parent()).attr("disabled", "disabled");
    $("#obtTFWBrowsePosEnd").addClass("disabled");
    $("#obtTFWBrowsePosEnd").attr("disabled", "disabled");

    if ($("#oetMchCode").val() != "") {

      // ร้านค้า
      $($("#obtTFWBrowseShpStart").parent()).removeClass("disabled");
      $($("#obtTFWBrowseShpStart").parent()).removeAttr("disabled");
      $("#obtTFWBrowseShpStart").removeClass("disabled");
      $("#obtTFWBrowseShpStart").removeAttr("disabled");

      $($("#obtTFWBrowseShpEnd").parent()).removeClass("disabled");
      $($("#obtTFWBrowseShpEnd").parent()).removeAttr("disabled");
      $("#obtTFWBrowseShpEnd").removeClass("disabled");
      $("#obtTFWBrowseShpEnd").removeAttr("disabled");

    } else {
      // $("#obtDocBrowsePdt").attr("disabled","disabled");
      // $("#obtDocBrowsePdt").css("opacity","0.4");
      // $("#obtDocBrowsePdt").css("cursor","not-allowed");

      // ร้านค้า
      $($("#obtTFWBrowseShpStart").parent()).addClass("disabled");
      $($("#obtTFWBrowseShpStart").parent()).attr("disabled", "disabled");
      $("#obtTFWBrowseShpStart").addClass("disabled");
      $("#obtTFWBrowseShpStart").attr("disabled", "disabled");

      $($("#obtTFWBrowseShpEnd").parent()).addClass("disabled");
      $($("#obtTFWBrowseShpEnd").parent()).attr("disabled", "disabled");
      $("#obtTFWBrowseShpEnd").addClass("disabled");
      $("#obtTFWBrowseShpEnd").attr("disabled", "disabled");
    }


    $("#oetShpCodeStart").val("");
    $("#oetShpNameStart").val("");
    $("#oetShpCodeEnd").val("");
    $("#oetShpNameEnd").val("");
    $("#oetPosCodeStart").val("");
    $("#oetPosNameStart").val("");
    $("#oetPosCodeEnd").val("");
    $("#oetPosNameEnd").val("");
    $("#ohdWahCodeStart").val("");
    $("#oetWahNameStart").val("");
    $("#ohdWahCodeEnd").val("");
    $("#oetWahNameEnd").val("");
    tOldMchCkChange = "";


    
    if ($("#ohdShipAddSeqNo").val() != "" && $(".xWPdtItem").length == 0) {
      FSvCMNSetMsgWarningDialog("<p>ข้อมูลที่อยู่สำหรับจัดส่งเดิมจะถูกเคลียร์ โปรดทำการระบุข้อมูลที่อยู่สำหรับจัดส่งใหม่</p>");
    } else if ($(".xWPdtItem").length != 0 && $("#ohdShipAddSeqNo").val() == "") {
      FSvCMNSetMsgWarningDialog("<p>รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนกลุ่มร้านค้าสำหรับจัดส่งสินค้าใหม่</p>");
    } else if ($(".xWPdtItem").length != 0 && $("#ohdShipAddSeqNo").val() != "") {
      FSvCMNSetMsgWarningDialog("<p>ที่อยู่สำหรับจัดส่งและรายการสินค้าที่ท่านเพิ่มไปแล้ว จะถูกล้างค่าเมื่อท่านเปลี่ยนกลุ่มร้านค้าสำหรับจัดส่งใหม่</p>");
    }
    if ($("#ohdShipAddSeqNo").val() != "") {
      $("#ospShipAddAddV1No").text("-");
      $("#ospShipAddV1Soi").text("-");
      $("#ospShipAddV1Village").text("-");
      $("#ospShipAddV1Road").text("-");
      $("#ospShipAddV1SubDist").text("-");
      $("#ospShipAddV1DstCode").text("-");
      $("#ospShipAddV1PvnCode").text("-");
      $("#ospShipAddV1PostCode").text("-");
      $("#ospShipAddV2Desc1").text("-");
      $("#ospShipAddV2Desc2").text("-");
      $("#ohdShipAddSeqNo").val("");
    }
    if ($(".xWPdtItem").length != 0) {
      if($("#otbDOCPdtTable tbody tr").length==1){ // ถ้าพบว่าข้อมูลในตาราง มี 1 แถว
        if(!($("#otbDOCPdtTable tbody tr td[colspan='100%']").length==1)){ // ถ้าพบว่าข้อมูล 1 แถวนั้นคือ ข้อมูล Layout สินค้า (ในโค๊ดกล่าวตรงข้ามคือ ถ้าไม่ใช่ แถวที่แสดงข้อมูลว่าไม่พบข้อมูล)
          FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
          $("#otbDOCPdtTable tbody tr").remove();
          $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
          
  
          
          let tHtml = "<div class=\"col-md-6\">";
          tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
          tHtml += "</div>";
          tHtml += "<div class=\"col-md-6\">";
          tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
          tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
          tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
          tHtml += "</button>";
          tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
          tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
          tHtml += "</button>";
          tHtml += "</div>";
          tHtml += "</div>";
          $("#odvPaginationBtn").html(tHtml);
  
  
  
  
        }
      }else{ // ถ้าพบว่าข้อมูลในตาราง มีหลายแถว (มี layout สินค้า)
        FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
        $("#otbDOCPdtTable tbody tr").remove();
        $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
        let tHtml = "<div class=\"col-md-6\">";
        tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
        tHtml += "</div>";
        tHtml += "<div class=\"col-md-6\">";
        tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
        tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
        tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "</div>";
        tHtml += "</div>";
        $("#odvPaginationBtn").html(tHtml);
      }
      JCNxOpenLoading();
      $.ajax({
        type: "POST",
        url: "ADJSTKVDClearDocTemForChngCdt",
        data: {
          tDocNo: $("#oetXthDocNo").val(),
          tBrachCode: $("#oetBchCode").val()
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
          JSvTFWLoadPdtDataTableHtml(1);
          JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
      });
    }



    if ($("#oetBchCode").val() != "" ||
      $("#oetMchCode").val() != "" ||
      $("#oetShpCodeEnd").val() != "" ||
      $("#oetPosCodeEnd").val() != "") {
      $("#obtTFWBrowseShipAdd").removeAttr("disabled");
    } else {
      $("#obtTFWBrowseShipAdd").attr("disabled", "disabled");
    }
    tOldMchCkChange = "";
  }
  JSxSetStatusClickTFWSubmit(0);
  // JSxValidateFormAddTFW();
  // $('#ofmAddTFW').submit();
}

//ร้านค้าเริ่ม
function JSxSetSeqConditionShpStart(paInForCon) {
  if (tOldShpStartCkChange != $("#oetShpCodeStart").val()) {
    
    $("#oetPosCodeStart").val("");
    $("#oetPosNameStart").val("");
    $("#ohdWahCodeStart").val("");
    $("#oetWahNameStart").val("");
    tOldShpStartCkChange = "";

    //ลบสินค้ากรณีมีสินค้ามากกว่าหนึ่ง
    if ($(".xWPdtItem").length != 0) {
      FSvCMNSetMsgWarningDialog("<p>รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนร้านค้าต้นทางสำหรับจัดส่งสินค้าใหม่</p>");
      if($("#otbDOCPdtTable tbody tr").length==1){ // ถ้าพบว่าข้อมูลในตาราง มี 1 แถว
        if(!($("#otbDOCPdtTable tbody tr td[colspan='100%']").length==1)){ // ถ้าพบว่าข้อมูล 1 แถวนั้นคือ ข้อมูล Layout สินค้า (ในโค๊ดกล่าวตรงข้ามคือ ถ้าไม่ใช่ แถวที่แสดงข้อมูลว่าไม่พบข้อมูล)
          FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
          $("#otbDOCPdtTable tbody tr").remove();
          $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
          let tHtml = "<div class=\"col-md-6\">";
          tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
          tHtml += "</div>";
          tHtml += "<div class=\"col-md-6\">";
          tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
          tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
          tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
          tHtml += "</button>";
          tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
          tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
          tHtml += "</button>";
          tHtml += "</div>";
          tHtml += "</div>";
          $("#odvPaginationBtn").html(tHtml);
        }
      }else{ // ถ้าพบว่าข้อมูลในตาราง มีหลายแถว (มี layout สินค้า)
        FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
        $("#otbDOCPdtTable tbody tr").remove();
        $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
        let tHtml = "<div class=\"col-md-6\">";
        tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
        tHtml += "</div>";
        tHtml += "<div class=\"col-md-6\">";
        tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
        tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
        tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "</div>";
        tHtml += "</div>";
        $("#odvPaginationBtn").html(tHtml);
      }
      JCNxOpenLoading();
      $.ajax({
        type: "POST",
        url: "ADJSTKVDClearDocTemForChngCdt",
        data: {
          tDocNo: $("#oetXthDocNo").val(),
          tBrachCode: $("#oetBchCode").val()
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
          JSvTFWLoadPdtDataTableHtml(1);
          JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
      });
    }

    //เลือกร้านค้า
    if ($("#oetShpCodeStart").val() != "") {
      var aData = JSON.parse(paInForCon);
      tInforType = aData[2];

      //ร้านค้า TYPE 4 
      if (tInforType == '4') {
          //เครื่องจุดขาย
          $($("#obtTFWBrowsePosStart").parent()).removeClass("disabled");
          $($("#obtTFWBrowsePosStart").parent()).removeAttr("disabled");
          $("#obtTFWBrowsePosStart").removeClass("disabled");
          $("#obtTFWBrowsePosStart").removeAttr("disabled");
          // if($("#oetShpCodeEnd").val()!=aData[1]){
          //   $("#ohdWahCodeStart").val(aData[3]);
          //   $("#oetWahNameStart").val(aData[4]);
          // }else{
          //   $("#ohdWahCodeStart").val("");
          //   $("#oetWahNameStart").val("");
          // }

          //คลังสินค้า
          $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
          $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
          $("#obtTFWBrowseWahStart").addClass("disabled");
          $("#obtTFWBrowseWahStart").attr("disabled", "disabled");
      } else {
        //ร้านค้า TYPE อื่นๆ 
        
        //เครื่องจุดขาย
        $($("#obtTFWBrowsePosStart").parent()).addClass("disabled");
        $($("#obtTFWBrowsePosStart").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowsePosStart").addClass("disabled");
        $("#obtTFWBrowsePosStart").attr("disabled", "disabled");
        // $("#ohdWahCodeStart").val(aData[3]);
        // $("#oetWahNameStart").val(aData[4]);
        //คลังสินค้า
        $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
        $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseWahStart").addClass("disabled");
        $("#obtTFWBrowseWahStart").attr("disabled", "disabled");
      }

      if ($("#oetShpCodeEnd").val() != "") {
        if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
          if ($("#oetPosCodeEnd").val() == "" && $("#ohdWahCodeEnd").val() != "") {
            //คลังสินค้า
            $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
            $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
            $("#obtTFWBrowseWahStart").addClass("disabled");
            $("#obtTFWBrowseWahStart").attr("disabled", "disabled");
          }
        }
      }
    } else {
      //ไม่ได้เลือกร้านค้า

      //เครื่องจุดขาย
      $($("#obtTFWBrowsePosStart").parent()).addClass("disabled");
      $($("#obtTFWBrowsePosStart").parent()).attr("disabled", "disabled");
      $("#obtTFWBrowsePosStart").addClass("disabled");
      $("#obtTFWBrowsePosStart").attr("disabled", "disabled");

      if ($("#oetBchCode").val() == "") {
        //คลังสินค้า
        $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
        $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseWahStart").addClass("disabled");
        $("#obtTFWBrowseWahStart").attr("disabled", "disabled");

      } else {
        if ($("#oetMchCode").val() != "") {
          //คลังสินค้า
          $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
          $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
          $("#obtTFWBrowseWahStart").addClass("disabled");
          $("#obtTFWBrowseWahStart").attr("disabled", "disabled");
        } else {
          //คลังสินค้า
          $($("#obtTFWBrowseWahStart").parent()).removeClass("disabled");
          $($("#obtTFWBrowseWahStart").parent()).removeAttr("disabled", "disabled");
          $("#obtTFWBrowseWahStart").removeClass("disabled");
          $("#obtTFWBrowseWahStart").removeAttr("disabled", "disabled");
        }

      }
    }

    if ($("#oetBchCode").val() != "" || $("#oetMchCode").val() != "" || $("#oetShpCodeEnd").val() != "" || $("#oetPosCodeEnd").val() != "") {
      $("#obtTFWBrowseShipAdd").removeAttr("disabled");
    } else {
      $("#obtTFWBrowseShipAdd").attr("disabled", "disabled");
    }
    tOldShpStartCkChange = "";
  }
  JSxSetStatusClickTFWSubmit(0);
  // JSxValidateFormAddTFW();
  // $('#ofmAddTFW').submit();
}

//เครื่องจุดขาย เริ่ม
function JSxSetSeqConditionPosStart(paInForCon) {
  if (tOldPosStartCkChange != $("#oetPosCodeStart").val()) {

    //สินค้ามีมากกว่า 1 ต้องถูกลบ
    if ($(".xWPdtItem").length != 0) {
      FSvCMNSetMsgWarningDialog("<p>รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนร้านค้าต้นทางสำหรับจัดส่งสินค้าใหม่</p>");
      if($("#otbDOCPdtTable tbody tr").length==1){ // ถ้าพบว่าข้อมูลในตาราง มี 1 แถว
        if(!($("#otbDOCPdtTable tbody tr td[colspan='100%']").length==1)){ // ถ้าพบว่าข้อมูล 1 แถวนั้นคือ ข้อมูล Layout สินค้า (ในโค๊ดกล่าวตรงข้ามคือ ถ้าไม่ใช่ แถวที่แสดงข้อมูลว่าไม่พบข้อมูล)
          FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
          $("#otbDOCPdtTable tbody tr").remove();
          $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
          let tHtml = "<div class=\"col-md-6\">";
          tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
          tHtml += "</div>";
          tHtml += "<div class=\"col-md-6\">";
          tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
          tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
          tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
          tHtml += "</button>";
          tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
          tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
          tHtml += "</button>";
          tHtml += "</div>";
          tHtml += "</div>";
          $("#odvPaginationBtn").html(tHtml);
        }
      }else{ // ถ้าพบว่าข้อมูลในตาราง มีหลายแถว (มี layout สินค้า)
        FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
        $("#otbDOCPdtTable tbody tr").remove();
        $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
        let tHtml = "<div class=\"col-md-6\">";
        tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
        tHtml += "</div>";
        tHtml += "<div class=\"col-md-6\">";
        tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
        tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
        tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "</div>";
        tHtml += "</div>";
        $("#odvPaginationBtn").html(tHtml);
      }
      JCNxOpenLoading();
      $.ajax({
        type: "POST",
        url: "ADJSTKVDClearDocTemForChngCdt",
        data: {
          tDocNo: $("#oetXthDocNo").val(),
          tBrachCode: $("#oetBchCode").val()
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
          JSvTFWLoadPdtDataTableHtml(1);
          JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
      });
    }

    $("#ohdWahCodeStart").val("");
    $("#oetWahNameStart").val("");

    if ($("#oetPosCodeStart").val() != "") {
      var aData = JSON.parse(paInForCon);
      $("#ohdWahCodeStart").val(aData[3]);
      $("#oetWahNameStart").val(aData[4]);



      //คลังสินค้า
      $($("#obtTFWBrowseWahStart").parent()).removeClass("disabled");
      $($("#obtTFWBrowseWahStart").parent()).removeAttr("disabled", "disabled");
      $("#obtTFWBrowseWahStart").removeClass("disabled");
      $("#obtTFWBrowseWahStart").removeAttr("disabled", "disabled");


      //เปิดปุ่มตรวจสอบ
      $("#obtTWXVDControlForm").removeAttr("disabled");
      $("#obtTWXVDControlForm").removeClass("disabled");

      // $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
      // $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
      // $("#obtTFWBrowseWahStart").addClass("disabled");
      // $("#obtTFWBrowseWahStart").attr("disabled", "disabled");
      // if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
      //   if (!$($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) {
      //     if ($("#oetPosCodeEnd").val() == "") {
      //       //คลังสินค้า
      //       $($("#obtTFWBrowseWahEnd").parent()).removeClass("disabled");
      //       $($("#obtTFWBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
      //       $("#obtTFWBrowseWahEnd").removeClass("disabled");
      //       $("#obtTFWBrowseWahEnd").removeAttr("disabled", "disabled");
      //     }
      //   }
      // }
    } else {
      //คลังสินค้า
      $($("#obtTFWBrowseWahStart").parent()).removeClass("disabled");
      $($("#obtTFWBrowseWahStart").parent()).removeAttr("disabled", "disabled");
      $("#obtTFWBrowseWahStart").removeClass("disabled");
      $("#obtTFWBrowseWahStart").removeAttr("disabled", "disabled");
      if (!$($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) {
        if ($("#oetPosCodeEnd").val() == "" && $("#ohdWahCodeEnd").val() != "") {
          if($("#oetShpCodeEnd").val()==$("#oetShpCodeStart").val()){
            //คลังสินค้า
            $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
            $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
            $("#obtTFWBrowseWahStart").addClass("disabled");
            $("#obtTFWBrowseWahStart").attr("disabled", "disabled");
          }
        }
      }
    }

    if ($("#oetBchCode").val() != "" || $("#oetMchCode").val() != "" || $("#oetShpCodeEnd").val() != "" || $("#oetPosCodeEnd").val() != "") {
      $("#obtTFWBrowseShipAdd").removeAttr("disabled");
    } else {
      $("#obtTFWBrowseShipAdd").attr("disabled", "disabled");
    }
  
  }
  JSxSetStatusClickTFWSubmit(0);
  // JSxValidateFormAddTFW();
  // $('#ofmAddTFW').submit();
}

//คลัง เริ่ม
function JSxSetSeqConditionWahStart(paInForCon) {
  if(tOldWahStartCkChange!=$("#ohdWahCodeStart").val()){
    if($("#otbDOCPdtTable tbody tr").length==1){ // ถ้าพบว่าข้อมูลในตาราง มี 1 แถว
      if(!($("#otbDOCPdtTable tbody tr td[colspan='100%']").length==1)){ // ถ้าพบว่าข้อมูล 1 แถวนั้นคือ ข้อมูล Layout สินค้า (ในโค๊ดกล่าวตรงข้ามคือ ถ้าไม่ใช่ แถวที่แสดงข้อมูลว่าไม่พบข้อมูล)
        FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
        $("#otbDOCPdtTable tbody tr").remove();
        $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
        let tHtml = "<div class=\"col-md-6\">";
        tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
        tHtml += "</div>";
        tHtml += "<div class=\"col-md-6\">";
        tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
        tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
        tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "</div>";
        tHtml += "</div>";
        $("#odvPaginationBtn").html(tHtml);
      }
    }else{ // ถ้าพบว่าข้อมูลในตาราง มีหลายแถว (มี layout สินค้า)
      FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
      $("#otbDOCPdtTable tbody tr").remove();
      $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
      let tHtml = "<div class=\"col-md-6\">";
      tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
      tHtml += "</div>";
      tHtml += "<div class=\"col-md-6\">";
      tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
      tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
      tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
      tHtml += "</button>";
      tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
      tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
      tHtml += "</button>";
      tHtml += "</div>";
      tHtml += "</div>";
      $("#odvPaginationBtn").html(tHtml);
    }
    if ($("#oetShpCodeEnd").val() != "") {
      if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
        if (!$($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) {
          if ($("#oetPosCodeEnd").val() == "" && $("#ohdWahCodeEnd").val() == "") {
            //คลังสินค้า
            $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
            $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
            $("#obtTFWBrowseWahEnd").addClass("disabled");
            $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");
            if ($("#oetPosCodeStart").val() == "" && $("#ohdWahCodeStart").val() == "") {
              //คลังสินค้า
              $($("#obtTFWBrowseWahEnd").parent()).removeClass("disabled");
              $($("#obtTFWBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
              $("#obtTFWBrowseWahEnd").removeClass("disabled");
              $("#obtTFWBrowseWahEnd").removeAttr("disabled", "disabled");
            }
          }
        }
      }
    }

    if ($("#oetBchCode").val() != "" ||
      $("#oetMchCode").val() != "" ||
      $("#oetShpCodeEnd").val() != "" ||
      $("#oetPosCodeEnd").val() != "") {
      $("#obtTFWBrowseShipAdd").removeAttr("disabled");
    } else {
      $("#obtTFWBrowseShipAdd").attr("disabled", "disabled");
    }
  }
  JSxSetStatusClickTFWSubmit(0);
  // JSxValidateFormAddTFW();
  // $('#ofmAddTFW').submit();
}

//ร้านค้าจบ
function JSxSetSeqConditionShpEnd(paInForCon) {

  if (tOldShpEndCkChange != $("#oetShpCodeEnd").val()) {
    if($("#otbDOCPdtTable tbody tr").length==1){ // ถ้าพบว่าข้อมูลในตาราง มี 1 แถว
      if(!($("#otbDOCPdtTable tbody tr td[colspan='100%']").length==1)){ // ถ้าพบว่าข้อมูล 1 แถวนั้นคือ ข้อมูล Layout สินค้า (ในโค๊ดกล่าวตรงข้ามคือ ถ้าไม่ใช่ แถวที่แสดงข้อมูลว่าไม่พบข้อมูล)
        FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
        $("#otbDOCPdtTable tbody tr").remove();
        $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
        let tHtml = "<div class=\"col-md-6\">";
        tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
        tHtml += "</div>";
        tHtml += "<div class=\"col-md-6\">";
        tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
        tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
        tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "</div>";
        tHtml += "</div>";
        $("#odvPaginationBtn").html(tHtml);
      }
    }else{ // ถ้าพบว่าข้อมูลในตาราง มีหลายแถว (มี layout สินค้า)
      FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
      $("#otbDOCPdtTable tbody tr").remove();
      $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
      let tHtml = "<div class=\"col-md-6\">";
      tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
      tHtml += "</div>";
      tHtml += "<div class=\"col-md-6\">";
      tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
      tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
      tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
      tHtml += "</button>";
      tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
      tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
      tHtml += "</button>";
      tHtml += "</div>";
      tHtml += "</div>";
      $("#odvPaginationBtn").html(tHtml);
    }
    $("#oetPosCodeEnd").val("");
    $("#oetPosNameEnd").val("");
    $("#ohdWahCodeEnd").val("");
    $("#oetWahNameEnd").val("");
    tOldShpEndCkChange = "";

    if ($("#oetShpCodeEnd").val() != "") {
      var aData = JSON.parse(paInForCon);
      tInforType = aData[2];
      if (tInforType == '4') {
        $($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).removeClass("xCNHide");
        //เครื่องจุดขาย
        $($("#obtTFWBrowsePosEnd").parent()).removeClass("disabled");
        $($("#obtTFWBrowsePosEnd").parent()).removeAttr("disabled");
        $("#obtTFWBrowsePosEnd").removeClass("disabled");
        $("#obtTFWBrowsePosEnd").removeAttr("disabled");
        if($("#oetShpCodeStart").val()!=aData[1]){
          
            $("#ohdWahCodeEnd").val(aData[3]);
            $("#oetWahNameEnd").val(aData[4]);
          
          
        }else{
          $("#ohdWahCodeEnd").val("");
          $("#oetWahNameEnd").val("");
        }

        //คลังสินค้า
        $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
        $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseWahEnd").addClass("disabled");
        $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");
      } else {
        $($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).addClass("xCNHide");
        //เครื่องจุดขาย
        $($("#obtTFWBrowsePosEnd").parent()).addClass("disabled");
        $($("#obtTFWBrowsePosEnd").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowsePosEnd").addClass("disabled");
        $("#obtTFWBrowsePosEnd").attr("disabled", "disabled");

        $("#ohdWahCodeEnd").val(aData[3]);
        $("#oetWahNameEnd").val(aData[4]);

        //คลังสินค้า
        $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
        $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseWahEnd").addClass("disabled");
        $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");
      }
      if ($("#oetShpCodeStart").val() != "") {
        if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
          if ($("#oetPosCodeStart").val() == "" && $("#ohdWahCodeStart").val() != "") {
            //คลังสินค้า
            $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
            $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
            $("#obtTFWBrowseWahEnd").addClass("disabled");
            $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");
          }
        }
      }
    } else {
      $($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).addClass("xCNHide");
      //เครื่องจุดขาย
      $($("#obtTFWBrowsePosEnd").parent()).addClass("disabled");
      $($("#obtTFWBrowsePosEnd").parent()).attr("disabled", "disabled");
      $("#obtTFWBrowsePosEnd").addClass("disabled");
      $("#obtTFWBrowsePosEnd").attr("disabled", "disabled");

      if ($("#oetBchCode").val() == "") {
        //คลังสินค้า
        $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
        $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseWahEnd").addClass("disabled");
        $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");

      } else {
        if ($("#oetMchCode").val() != "") {
          //คลังสินค้า
          $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
          $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
          $("#obtTFWBrowseWahEnd").addClass("disabled");
          $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");
        } else {
          //คลังสินค้า
          $($("#obtTFWBrowseWahEnd").parent()).removeClass("disabled");
          $($("#obtTFWBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
          $("#obtTFWBrowseWahEnd").removeClass("disabled");
          $("#obtTFWBrowseWahEnd").removeAttr("disabled", "disabled");
        }

      }
    }

    if ($("#oetBchCode").val() != "" ||
      $("#oetMchCode").val() != "" ||
      $("#oetShpCodeEnd").val() != "" ||
      $("#oetPosCodeEnd").val() != "") {
      $("#obtTFWBrowseShipAdd").removeAttr("disabled");
    } else {
      $("#obtTFWBrowseShipAdd").attr("disabled", "disabled");
    }

    if ($("#ohdShipAddSeqNo").val() != "") {
      FSvCMNSetMsgWarningDialog("<p>ข้อมูลที่อยู่สำหรับจัดส่งเดิมจะถูกเคลียร์ โปรดทำการระบุข้อมูลที่อยู่สำหรับจัดส่งใหม่</p>");
    }
    if ($("#ohdShipAddSeqNo").val() != "") {
      $("#ospShipAddAddV1No").text("-");
      $("#ospShipAddV1Soi").text("-");
      $("#ospShipAddV1Village").text("-");
      $("#ospShipAddV1Road").text("-");
      $("#ospShipAddV1SubDist").text("-");
      $("#ospShipAddV1DstCode").text("-");
      $("#ospShipAddV1PvnCode").text("-");
      $("#ospShipAddV1PostCode").text("-");
      $("#ospShipAddV2Desc1").text("-");
      $("#ospShipAddV2Desc2").text("-");
      $("#ohdShipAddSeqNo").val("");

    }
    tOldShpEndCkChange = "";
  }
  JSxSetStatusClickTFWSubmit(0);
  JSxValidateFormAddTFW();
  $('#ofmAddTFW').submit();
}

//เครื่องจุดขาย จบ
function JSxSetSeqConditionPosEnd(paInForCon) {
  if (tOldPosEndCkChange != $("#oetPosCodeEnd").val()) {
    if($("#otbDOCPdtTable tbody tr").length==1){ // ถ้าพบว่าข้อมูลในตาราง มี 1 แถว
      if(!($("#otbDOCPdtTable tbody tr td[colspan='100%']").length==1)){ // ถ้าพบว่าข้อมูล 1 แถวนั้นคือ ข้อมูล Layout สินค้า (ในโค๊ดกล่าวตรงข้ามคือ ถ้าไม่ใช่ แถวที่แสดงข้อมูลว่าไม่พบข้อมูล)
        FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
        $("#otbDOCPdtTable tbody tr").remove();
        $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
        let tHtml = "<div class=\"col-md-6\">";
        tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
        tHtml += "</div>";
        tHtml += "<div class=\"col-md-6\">";
        tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
        tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
        tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "</div>";
        tHtml += "</div>";
        $("#odvPaginationBtn").html(tHtml);
      }
    }else{ // ถ้าพบว่าข้อมูลในตาราง มีหลายแถว (มี layout สินค้า)
      FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
      $("#otbDOCPdtTable tbody tr").remove();
      $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
      let tHtml = "<div class=\"col-md-6\">";
      tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
      tHtml += "</div>";
      tHtml += "<div class=\"col-md-6\">";
      tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
      tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
      tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
      tHtml += "</button>";
      tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
      tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
      tHtml += "</button>";
      tHtml += "</div>";
      tHtml += "</div>";
      $("#odvPaginationBtn").html(tHtml);
    }
    let bCheckPosTransferPos = true;
    if($("#oetShpCodeStart").val()!="" && $("#oetPosCodeStart").val()!=""){
      if($("#oetShpCodeEnd").val()!=$("#oetShpCodeStart").val()){
        bCheckPosTransferPos = false;
      }
    }
    if(bCheckPosTransferPos){
      $("#ohdWahCodeEnd").val("");
      $("#oetWahNameEnd").val("");
      if ($("#oetPosCodeEnd").val() != "") {
        var aData = JSON.parse(paInForCon);
        $("#ohdWahCodeEnd").val(aData[3]);
        $("#oetWahNameEnd").val(aData[4]);
        //คลังสินค้า
        $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
        $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseWahEnd").addClass("disabled");
        $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");
        if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
          if (!$($($($("#obtTFWBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")) {
            if ($("#oetPosCodeStart").val() == "") {
              //คลังสินค้า
              $($("#obtTFWBrowseWahStart").parent()).removeClass("disabled");
              $($("#obtTFWBrowseWahStart").parent()).removeAttr("disabled", "disabled");
              $("#obtTFWBrowseWahStart").removeClass("disabled");
              $("#obtTFWBrowseWahStart").removeAttr("disabled", "disabled");
            }
          }
        }
      } else {
        //คลังสินค้า
        $($("#obtTFWBrowseWahEnd").parent()).removeClass("disabled");
        $($("#obtTFWBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
        $("#obtTFWBrowseWahEnd").removeClass("disabled");
        $("#obtTFWBrowseWahEnd").removeAttr("disabled", "disabled");
        if (!$($($($("#obtTFWBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")) {
          if ($("#oetPosCodeStart").val() == "" && $("#ohdWahCodeStart").val() != "") {
            if($("#oetShpCodeEnd").val()==$("#oetShpCodeStart").val()){
              //คลังสินค้า
              $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
              $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
              $("#obtTFWBrowseWahEnd").addClass("disabled");
              $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");
            }
          }
        }
      }

      if ($("#oetBchCode").val() != "" ||
        $("#oetMchCode").val() != "" ||
        $("#oetShpCodeEnd").val() != "" ||
        $("#oetPosCodeEnd").val() != "") {
        $("#obtTFWBrowseShipAdd").removeAttr("disabled");
      } else {
        $("#obtTFWBrowseShipAdd").attr("disabled", "disabled");
      }

      if ($("#ohdShipAddSeqNo").val() != "" && $(".xWPdtItem").length == 0) {
        FSvCMNSetMsgWarningDialog("<p>ข้อมูลที่อยู่สำหรับจัดส่งเดิมจะถูกเคลียร์ โปรดทำการระบุข้อมูลที่อยู่สำหรับจัดส่งใหม่</p>");
      }
      if ($("#ohdShipAddSeqNo").val() != "") {
        $("#ospShipAddAddV1No").text("-");
        $("#ospShipAddV1Soi").text("-");
        $("#ospShipAddV1Village").text("-");
        $("#ospShipAddV1Road").text("-");
        $("#ospShipAddV1SubDist").text("-");
        $("#ospShipAddV1DstCode").text("-");
        $("#ospShipAddV1PvnCode").text("-");
        $("#ospShipAddV1PostCode").text("-");
        $("#ospShipAddV2Desc1").text("-");
        $("#ospShipAddV2Desc2").text("-");
        $("#ohdShipAddSeqNo").val("");

      }
      
    
    }else{
      var aData = JSON.parse(paInForCon);
      $("#ohdWahCodeEnd").val(aData[3]);
      $("#oetWahNameEnd").val(aData[4]);
      //คลังสินค้า
      $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
      $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
      $("#obtTFWBrowseWahEnd").addClass("disabled");
      $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");
      $("#oetShpCodeStart").val("");
      $("#oetShpNameStart").val("");
      $("#oetPosCodeStart").val("");
      $("#oetPosNameStart").val("");
      $("#ohdWahCodeStart").val("");
      $("#oetWahNameStart").val("");
      $($($($("#obtTFWBrowsePosStart").parent()).parent()).parent()).addClass("xCNHide");
      $($("#obtTFWBrowsePosStart").parent()).addClass("disabled");
      $($("#obtTFWBrowsePosStart").parent()).attr("disabled", "disabled");
      $("#obtTFWBrowsePosStart").addClass("disabled");
      $("#obtTFWBrowsePosStart").attr("disabled", "disabled");
      $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
      $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
      $("#obtTFWBrowseWahStart").addClass("disabled");
      $("#obtTFWBrowseWahStart").attr("disabled", "disabled");
      $("#obtTFWBrowseShipAdd").attr("disabled", "disabled");
      FSvCMNSetMsgWarningDialog("<p>ไม่สามารถโอนสินค้าระหว่างตู้สินค้าต่างร้านค้ากันได้</p>");
    }
  }
  JSxSetStatusClickTFWSubmit(0);
  JSxValidateFormAddTFW();
  $('#ofmAddTFW').submit();
}

//คลัง จบ
function JSxSetSeqConditionWahEnd(paInForCon) {
  if(tOldWahEndCkChange!=$("#ohdWahCodeEnd").val()){
    if($("#otbDOCPdtTable tbody tr").length==1){ // ถ้าพบว่าข้อมูลในตาราง มี 1 แถว
      if(!($("#otbDOCPdtTable tbody tr td[colspan='100%']").length==1)){ // ถ้าพบว่าข้อมูล 1 แถวนั้นคือ ข้อมูล Layout สินค้า (ในโค๊ดกล่าวตรงข้ามคือ ถ้าไม่ใช่ แถวที่แสดงข้อมูลว่าไม่พบข้อมูล)
        FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
        $("#otbDOCPdtTable tbody tr").remove();
        $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
        let tHtml = "<div class=\"col-md-6\">";
        tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
        tHtml += "</div>";
        tHtml += "<div class=\"col-md-6\">";
        tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
        tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
        tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
        tHtml += "</button>";
        tHtml += "</div>";
        tHtml += "</div>";
        $("#odvPaginationBtn").html(tHtml);
      }
    }else{ // ถ้าพบว่าข้อมูลในตาราง มีหลายแถว (มี layout สินค้า)
      FSvCMNSetMsgWarningDialog("<p>ข้อมูลเลย์เอาต์เดิมจะถูกเคลียร์ทิ้งเมื่อท่านเลือกกลุ่มร้านค้าใหม่</p>");
      $("#otbDOCPdtTable tbody tr").remove();
      $("#otbDOCPdtTable tbody").append("<tr><td colspan=\"100%\" class=\"text-center\"><span>ไม่พบข้อมูล</span></td></tr>");
      let tHtml = "<div class=\"col-md-6\">";
      tHtml += "<p>พบข้อมูลทั้งหมด 0 รายการ แสดงหน้า 1 / 0</p>";
      tHtml += "</div>";
      tHtml += "<div class=\"col-md-6\">";
      tHtml += "<div class=\"xWPageTFWPdt btn-toolbar pull-right\">";
      tHtml += "<button onclick=\"JSvTFWPdtClickPage('previous')\" class=\"btn btn-white btn-sm\" disabled=\"\">"; 
      tHtml += "<i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
      tHtml += "</button>";
      tHtml += "<button onclick=\"JSvTFWPdtClickPage('next')\" class=\"btn btn-white btn-sm\" disabled=\"\"> ";
      tHtml += "<i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
      tHtml += "</button>";
      tHtml += "</div>";
      tHtml += "</div>";
      $("#odvPaginationBtn").html(tHtml);
    }
    if ($("#oetShpCodeStart").val() != "") {
      if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
        if (!$($($($("#obtTFWBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")) {
          if ($("#oetPosCodeStart").val() == "" && $("#ohdWahCodeStart").val() == "") {
            //คลังสินค้า
            $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
            $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
            $("#obtTFWBrowseWahStart").addClass("disabled");
            $("#obtTFWBrowseWahStart").attr("disabled", "disabled");
            if ($("#oetPosCodeEnd").val() == "" && $("#ohdWahCodeEnd").val() == "") {
              //คลังสินค้า
              $($("#obtTFWBrowseWahStart").parent()).removeClass("disabled");
              $($("#obtTFWBrowseWahStart").parent()).removeAttr("disabled", "disabled");
              $("#obtTFWBrowseWahStart").removeClass("disabled");
              $("#obtTFWBrowseWahStart").removeAttr("disabled", "disabled");
            }
          }
        }
      }
    }

    if ($("#oetBchCode").val() != "" ||
      $("#oetMchCode").val() != "" ||
      $("#oetShpCodeEnd").val() != "" ||
      $("#oetPosCodeEnd").val() != "") {
      $("#obtTFWBrowseShipAdd").removeAttr("disabled");
    } else {
      $("#obtTFWBrowseShipAdd").attr("disabled", "disabled");
    }
  }
  JSxSetStatusClickTFWSubmit(0);
  JSxValidateFormAddTFW();
  $('#ofmAddTFW').submit();
}

function JSvCallPageTFWList() {
  $.ajax({
    type: "GET",
    url: "ADJSTKVDFormSearchList",
    data: {},
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      $("#odvContentPageTFW").html(tResult);
      JSxTFWNavDefult();

      JSvCallPageTFWPdtDataTable(); //แสดงข้อมูลใน List
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

function JSvCallPageTFWPdtDataTable(pnPage) {
  JCNxOpenLoading();

  var nPageCurrent = pnPage;
  if (nPageCurrent == undefined || nPageCurrent == "") {
    nPageCurrent = "1";
  }

  var oAdvanceSearch = JSoTFWGetAdvanceSearchData();

  $.ajax({
    type: "POST",
    url: "ADJSTKVDDataTable",
    data: {
      oAdvanceSearch: oAdvanceSearch,
      nPageCurrent: nPageCurrent
    },
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      $("#odvContentPurchaseorder").html(tResult);

      JSxTFWNavDefult();
      JCNxLayoutControll();
      JCNxCloseLoading();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

/**
 * Functionality : Get search data
 * Parameters : -
 * Creator : 01/04/2019 Krit(Copter)
 * Last Modified : -
 * Return : Search data
 * Return Type : Object
 */
function JSoTFWGetAdvanceSearchData() {
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
      console.log("JSoTFWGetAdvanceSearchData Error: ", err);
    }
  } else {
    JCNxShowMsgSessionExpired();
  }
}

/**
 * Functionality : Clear search data
 * Parameters : -
 * Creator : 01/04/2019 Krit(Copter)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxTFWClearSearchData() {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    try {
      $("#oetSearchAll").val("");
      $("#oetBchCodeFrom").val("");
      $("#oetBchNameFrom").val("");
      $("#oetBchCodeTo").val("");
      $("#oetBchNameTo").val("");
      $("#oetSearchDocDateFrom").val("");
      $("#oetSearchDocDateTo").val("");
      $(".xCNDatePicker").datepicker("setDate", null);
      $(".selectpicker")
        .val("0")
        .selectpicker("refresh");
      JSvCallPageTFWPdtDataTable();
    } catch (err) {
      console.log("JSxTFWClearSearchData Error: ", err);
    }
  } else {
    JCNxShowMsgSessionExpired();
  }
}

//Functionality : Call Credit Page Edit
//Parameters : -
//Creator : 04/07/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvCallPageTFWEdit(ptXthDocNo) {
  JCNxOpenLoading();

  JStCMMGetPanalLangSystemHTML("JSvCallPageTFWEdit", ptXthDocNo);
  $.ajax({
    type: "POST",
    url: "ADJSTKVDPageEdit",
    data: { 
      ptXthDocNo: ptXthDocNo
    },
    cache: false,
    timeout: 0,
    success: function (tResult) {
      nIndexInputEditInlineForVD=0;
      if (tResult != "") {
        $("#oliTFWTitleAdd").hide();
        $("#oliTFWTitleEdit").show();
        $("#odvBtnTFWInfo").hide();
        $("#odvBtnAddEdit").show();
        $("#odvContentPageTFW").html(tResult);
        $("#oetXthDocNo").addClass("xCNDisable");
        $(".xCNDisable").attr("readonly", true);
        $(".xCNiConGen").hide();
        $("#obtTFWApprove").show();
        $("#obtTFWPrint").show();
        $("#obtTFWCancel").show();
        // ================== Create By Witsarut 28/08/2019 ==================
        $(".xWBtnGrpSaveLeft").show();
        $(".xWBtnGrpSaveRight").show();                      
        // ================== Create By Witsarut 28/08/2019 ==================
      }
      
      //Control Event Button
      if ($("#ohdTFWAutStaEdit").val() == 0) {
        $(".xCNUplodeImage").hide();
        $(".xCNIconBrowse").hide();
        $(".xCNEditRowBtn").hide();
        $("select").prop("disabled", true);
        $("input").attr("disabled", true);
      } else {
        $(".xCNUplodeImage").show();
        $(".xCNIconBrowse").show();
        $(".xCNEditRowBtn").show();
        $("select").prop("disabled", false);
        $("input").attr("disabled", false);
      }
      //Control Event Button
      //Put Data
      ohdXthCshOrCrd = $("#ohdXthCshOrCrd").val();
      $("#ostXthCshOrCrd option[value='" + ohdXthCshOrCrd + "']")
        .attr("selected", true)
        .trigger("change");

      ohdXthStaRef = $("#ohdXthStaRef").val();
      $("#ostXthStaRef option[value='" + ohdXthStaRef + "']")
        .attr("selected", true)
        .trigger("change");

      // Control Object And Button ปิด เปิด
      JCNxTFWControlObjAndBtn();

      JCNxLayoutControll();
      $(".xWConditionSearchPdt.disabled").attr("disabled", "disabled");
      
      
      $("#ohdCheckSetDataDTFromTmp").val(0);
      JSvTFWLoadPdtDataTableHtml(1);
      
      $("#obtTWXVDControlForm").click(function(){
        JCNxOpenLoading();
        $("#ohdCheckSetDataDTFromTmp").val(1);
        JSvTFWLoadPdtDataTableHtml(1);
      });
      $("#obtTWXVDControlFormClear").click(function(){
        $("#oetMchCode").val("");
        $("#oetMchName").val("");
        $("#oetShpCodeStart").val("");
        $("#oetShpNameStart").val("");
        $($("#obtTFWBrowseShpStart").parent()).addClass("disabled");
        $($("#obtTFWBrowseShpStart").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseShpStart").addClass("disabled");
        $("#obtTFWBrowseShpStart").attr("disabled", "disabled");
        $("#oetPosCodeStart").val("");
        $("#oetPosNameStart").val("");
        $($("#obtTFWBrowsePosStart").parent()).addClass("disabled");
        $($("#obtTFWBrowsePosStart").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowsePosStart").addClass("disabled");
        $("#obtTFWBrowsePosStart").attr("disabled", "disabled");
        $($($($("#obtTFWBrowsePosStart").parent()).parent()).parent()).addClass("xCNHide");
        $("#ohdWahCodeStart").val("");
        $("#oetWahNameStart").val("");
        $($("#obtTFWBrowseWahStart").parent()).addClass("disabled");
        $($("#obtTFWBrowseWahStart").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseWahStart").addClass("disabled");
        $("#obtTFWBrowseWahStart").attr("disabled", "disabled");
        
        $("#oetShpCodeEnd").val("");
        $("#oetShpNameEnd").val("");
        $($("#obtTFWBrowseShpEnd").parent()).addClass("disabled");
        $($("#obtTFWBrowseShpEnd").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseShpEnd").addClass("disabled");
        $("#obtTFWBrowseShpEnd").attr("disabled", "disabled");
        $("#oetPosCodeEnd").val("");
        $("#oetPosNameEnd").val("");
        $($("#obtTFWBrowsePosEnd").parent()).addClass("disabled");
        $($("#obtTFWBrowsePosEnd").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowsePosEnd").addClass("disabled");
        $("#obtTFWBrowsePosEnd").attr("disabled", "disabled");
        $($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).addClass("xCNHide");
        $("#ohdWahCodeEnd").val("");
        $("#oetWahNameEnd").val("");
        $($("#obtTFWBrowseWahEnd").parent()).addClass("disabled");
        $($("#obtTFWBrowseWahEnd").parent()).attr("disabled", "disabled");
        $("#obtTFWBrowseWahEnd").addClass("disabled");
        $("#obtTFWBrowseWahEnd").attr("disabled", "disabled");
      });
      if (tDocNo != '' && (tStaApv == 1 && tStaPrcStk == 1)) {
        $("#obtTWXVDControlForm").attr("disabled","disabled");
        $("#obtTWXVDControlForm").unbind("click");
        $("#obtTWXVDControlFormClear").attr("disabled","disabled");
        $("#obtTWXVDControlFormClear").unbind("click");
      }
		},
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Function : Control Object And Button ปิด เปิด
function JCNxTFWControlObjAndBtn() {
  //Check สถานะอนุมัติ
  ohdXthStaApv = $("#ohdXthStaApv").val();
  ohdXthStaDoc = $("#ohdXthStaDoc").val();

  //Set Default
  //Btn Cancel
  $("#obtTFWCancel").attr("disabled", false);
  //Btn Apv
  $("#obtTFWApprove").attr("disabled", false);
  $("#obtTFWPrint").attr("disabled", false);
  $(".form-control").attr("disabled", false);
  $(".ocbListItem").attr("disabled", false);
  $(".xCNBtnBrowseAddOn").attr("disabled", false);
  $(".xCNBtnDateTime").attr("disabled", false);
  $(".xCNDocBrowsePdt")
    .attr("disabled", false)
    .removeClass("xCNBrowsePdtdisabled");
  $(".xCNDocDrpDwn").show();
  $("#oetSearchPdtHTML").attr("disabled", false);
  $(".xWBtnGrpSaveLeft").attr("disabled", false);
  $(".xWBtnGrpSaveRight").attr("disabled", false);
  $("#oliBtnEditShipAdd").show();
  $("#oliBtnEditTaxAdd").show();
  $('#oliPITitleDetail').hide();
  if (ohdXthStaApv == 1) {
    //Btn Apv
    $("#obtTFWApprove").hide();
    $("#obtTFWPrint").attr("disabled", false);
    //===== Create by Witsarut 28/08/2019 ======
    $("#obtTFWCancel").hide();  
    $(".xWBtnGrpSaveLeft").hide();
    $(".xWBtnGrpSaveRight").hide();
    //===== Create by Witsarut 28/08/2019 ======
    //Control input ปิด
    $(".form-control").attr("disabled", true);
    $(".ocbListItem").attr("disabled", true);
    $(".xCNBtnBrowseAddOn").attr("disabled", true);
    $(".xCNBtnDateTime").attr("disabled", true);
    $(".xCNDocBrowsePdt")
      .attr("disabled", true)
      .addClass("xCNBrowsePdtdisabled");
    $(".xCNDocDrpDwn").hide();
    $("#oetSearchPdtHTML").attr("disabled", false);
    $("#oliBtnEditShipAdd").hide();
    $("#oliBtnEditTaxAdd").hide();
    $('#oliTFWTitleEdit').hide();
    $('#oliPITitleDetail').show();
  }
  //Check สถานะเอกสาร
  if (ohdXthStaDoc == 3) {
    //Btn Cancel
    $("#obtTFWCancel").hide();
    //Btn Apv
    $("#obtTFWApprove").hide();
    $("#obtTFWPrint").hide();
    //Control input ปิด
    $(".form-control").attr("disabled", true);
    $(".ocbListItem").attr("disabled", true);
    $(".xCNBtnBrowseAddOn").attr("disabled", true);
    $(".xCNBtnDateTime").attr("disabled", true);
    $(".xCNDocBrowsePdt")
      .attr("disabled", true)
      .addClass("xCNBrowsePdtdisabled");
    $(".xCNDocDrpDwn").hide();
    $("#oetSearchPdtHTML").attr("disabled", false);
// ================= Create By Witsarut 28/08/2019 =================
    $(".xWBtnGrpSaveLeft").hide();
    $(".xWBtnGrpSaveRight").hide();
// ================= Create By Witsarut 28/08/2019 =================
    $("#oliBtnEditShipAdd").hide();
    $("#oliBtnEditTaxAdd").hide();
    $('#oliTFWTitleEdit').hide();
    $('#oliPITitleDetail').show();
  }
}

// //Functionality : (event) Delete
// //Parameters : tIDCode รหัส
// //Creator : 03/07/2018 Krit(Copter)
// //Return :
//Return Type : Status Number
function JSnTFWDel(tCurrentPage, tIDCode) {
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
        url: "ADJSTKVDEventDelete",
        data: { tIDCode: tIDCode },
        cache: false,
        success: function (tResult) {
          var aReturn = JSON.parse(tResult);

          if (aReturn["nStaEvent"] == 1) {
            $("#odvModalDel").modal("hide");
            $("#ospConfirmDelete").text("ยืนยันการลบข้อมูลของ : ");
            $("#ohdConfirmIDDelete").val("");
            localStorage.removeItem("LocalItemData");
            setTimeout(function () {
              JSvTFWClickPage(tCurrentPage);
            }, 500);
          } else {
            alert(aReturn["tStaMessg"]);
          }
          JSxTFWNavDefult();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
      });
    });
  }
}

// //Functionality : (event) Delete All
// //Parameters :
// //Creator : 04/07/2018 Krit
// //Return :
// //Return Type :
function JSnTFWDelChoose() {
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
      url: "ADJSTKVDEventDelete",
      data: { tIDCode: aNewIdDelete },
      success: function (tResult) {
        var aReturn = JSON.parse(tResult);
        if (aReturn["nStaEvent"] == 1) {
          setTimeout(function () {
            $("#odvModalDel").modal("hide");
            JSvCallPageTFWPdtDataTable();
            $("#ospConfirmDelete").text("ยืนยันการลบข้อมูลของ : ");
            $("#ohdConfirmIDDelete").val("");
            localStorage.removeItem("LocalItemData");
            $(".modal-backdrop").remove();
          }, 1000);
        } else {
          alert(aReturn["tStaMessg"]);
        }
        JSxTFWNavDefult();
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

//Functionality: Event Pdt Multi Delete
//Parameters: Event Button Delete All
//Creator: 10/04/2019 Krit(Copter)
//Return:  object Status Delete
//Return Type: object
function JSoTFWPdtDelChoose(pnPage) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    var aSeq = $("#ohdConfirmSeqDelete").val();
    var tDocNo = $("#oetXthDocNo").val();

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
        url: "ADJSTKVDPdtMultiDeleteEvent",
        data: {
          tDocNo: tDocNo,
          tSeqCode: aSeqData
        },
        success: function (tResult) {
          setTimeout(function () {
            $("#odvModalDelPdtTFW").modal("hide");
            JSvTFWLoadPdtDataTableHtml(1);
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

// //Functionality : เปลี่ยนหน้า pagenation
// //Parameters : -
// //Creator : 02/07/2018 Krit(Copter)
// //Return : View
// //Return Type : View
function JSvTFWClickPage(ptPage) {
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
  JSvCallPageTFWPdtDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 10/07/2019 Krit(Copter)
//Return: -
//Return Type: -
function JSxShowButtonChoose() {
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
function JSxTFWPdtTextinModal() {
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

//Functionality : เปลี่ยนหน้า pagenation product table
//Parameters : Event Click Pagination
//Creator : 04/04/2019 Krit(Copter)
//Return : View
//Return Type : View
function JSvTFWPdtClickPage(ptPage) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (nStaSession !== undefined && nStaSession == 1) {
    var nPageCurrent = "";
    switch (ptPage) {
      case "next": //กดปุ่ม Next
        $(".xWBtnNext").addClass("disabled");
        nPageOld = $(".xWPageTFWPdt .active").text(); // Get เลขก่อนหน้า
        nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
        nPageCurrent = nPageNew;
        break;
      case "previous": //กดปุ่ม Previous
        nPageOld = $(".xWPageTFWPdt .active").text(); // Get เลขก่อนหน้า
        nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
        nPageCurrent = nPageNew;
        break;
      default:
        nPageCurrent = ptPage;
    }
    JCNxOpenLoading();
    JSvTFWLoadPdtDataTableHtml(nPageCurrent);
  } else {
    JCNxShowMsgSessionExpired();
  }
}

//Functionality : Generate Code Subdistrict
//Parameters : Event Icon Click
//Creator : 07/06/2018 wasin
//Return : Data
//Return Type : String
function JStGenerateTFWCode() {
  var tTableName = "TCNTPdtAdjStkHD";
  JCNxOpenLoading();
  $.ajax({
    type: "POST",
    url: "generateCode",
    data: { tTableName: tTableName },
    cache: false,
    timeout: 0,
    success: function (tResult) {
      console.log(tResult);
      var tData = $.parseJSON(tResult);
      if (tData.rtCode == "1") {
        console.log(tData);
        $("#oetXthDocNo").val(tData.rtXthDocNo);
        $("#oetXthDocNo").addClass("xCNDisable");
        $(".xCNDisable").attr("readonly", true);
        //----------Hidden ปุ่ม Gen
        $(".xCNBtnGenCode").attr("disabled", true);
        $("#oetXthDocDate").focus();
        $("#oetXthDocDate").focus();

        JStCMNCheckDuplicateCodeMaster(
          "oetXthDocNo",
          "JSvCallPageTFWEdit",
          "TCNTPdtAdjStkHD",
          "FTXthDocNo"
        );
      } else {
        $("#oetXthDocNo").val(tData.rtDesc);
      }
      JCNxCloseLoading();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

// Advance Table
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Function : ตรวจสอบข้อมูลใน tem พร้อมกับ ดึงข้อมูลจาก tem มา
//Create : 04/04/2019 Krit(Copter)
//Update : 24/06/2019 pap
function JSvTFWLoadPdtDataTableHtml(pnPage) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    if ($("#ohdTFWRoute").val() == "ADJSTKVDEventAdd") {
      tXthDocNo = "";
    } else {
      tXthDocNo = $("#oetXthDocNo").val();
    }
    tXthStaApv = $("#ohdXthStaApv").val();
    tXthStaDoc = $("#ohdXthStaDoc").val();
    ptXthVATInOrEx = $("#ostXthVATInOrEx").val();
  
    //เช็ค สินค้าใน table หน้านั้นๆ หรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
    if ($("#otbDOCPdtTable .xWPdtItem").length == 0) {
      if (pnPage != undefined) {
        pnPage = pnPage - 1;
      }
    }
  
    nPageCurrent = pnPage === undefined || pnPage == "" || pnPage <= 0 ? "1" : pnPage;
    var tBchCodeInput = $("#oetBchCode").val();
    var tShpCpdeInput = "";
    var tWahCodeInput = "";
    var tPanelPdtTypeInput = "";
    // var tPanelPdtStaShowInput = 0; // hideden
    // var oBtnDisAttr = $("#obtTWXVDControlForm").attr("disabled");
    // if(oBtnDisAttr===undefined || oBtnDisAttr==false){
      tPanelPdtStaShowInput = 1; // show
    // }
    var tXthDocNo = $("#oetXthDocNo").val();
    if($("#ohdTFWRoute").val()=="ADJSTKVDEventAdd"){
      tXthDocNo = "";
    }
    let oInfor = {
      // tBchCodePanelPdt : tBchCodeInput,
      // tShpCodePanelPdt : tShpCpdeInput,
      // tWahCodePanelPdt : tWahCodeInput,
      // tPanelPdtType : tPanelPdtTypeInput,
      tBchCode : $("#oetBchCode").val(),
      tShpCodeStart : $("#oetShpCodeStart").val(),
      tPosCodeStart : $("#oetPosCodeStart").val(),
      tWahCodeStart : $("#ohdWahCodeStart").val(),
      tPanelPdtStaShow :  tPanelPdtStaShowInput,
      tXthDocNo : tXthDocNo,
      tRoute : $("#ohdTFWRoute").val(),
      nPageCurrent: nPageCurrent,
      nStatusSetDTForEdit:$("#ohdCheckSetDataDTFromTmp").val() 
    };
    if($("#ohdCheckSetDataDTFromTmp").val()==1){
     
      // ถ้ามีการกดปุ่มเพื่อโหลดข้อมูลมา ให้ทำการนำรายการสินค้าเข้าสู่ tem
      $.ajax({
        type: "POST",
        url: "ADJSTKVDPdtDtLoadToTem",
        data: oInfor,
        cache: false,
        Timeout: 0,
        success: function (tResult) {
          
          $("#ohdCheckSetDataDTFromTmp").val(0); 
          JSxLoadPdtDtFromTem(oInfor);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
      });
    }else{
      // หากไม่มีการกดปุ่มเพื่อโหลดให้ดึงข้อมูลจาก tem มาใช้ได้เลย
      JSxLoadPdtDtFromTem(oInfor);
    }
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// โหลดข้อมูลจาก tem พร้อมคำนวน vat
function JSxLoadPdtDtFromTem(oInfor){
  $.ajax({
    type: "POST",
    url: "ADJSTKVDPdtAdvanceTableLoadData",
    data: oInfor,
    cache: false,
    Timeout: 0,
    success: function (tResult) {
     
      $("#odvPdtTablePanal").html(tResult);
      let oParameterSend =  {
                "FunctionName"                : "JSxUpdateTmpInfor",
                "DataAttribute"               : ['dataMax','dataMin','dataSeq','dataRow','dataCol','dataUser','dataseqcabinet'],
                "TableID"                     : "otbDOCPdtTable",
                "NotFoundDataRowClass"        : "xWTextNotfoundDataTablePdt",
                "EditInLineButtonDeleteClass" : "xWDeleteBtnEditButton",
                "LabelShowDataClass"          : "xWShowInLine",
                "DivHiddenDataEditClass"      : "xWEditInLine"
              };
      JCNxSetNewEditInlineForVD(oParameterSend);
      
      
      var oElementSetReadOnly = $(".xWEditInlineElement");
      
      $(".xWEditInlineElement").eq(nIndexInputEditInlineForVD).focus();
      $($(".xWEditInlineElement").eq(nIndexInputEditInlineForVD)).select(); 
          

      $(".xWEditInlineElement").removeAttr("disabled");
      // tNewEvent = "";
      // tOldEvent = "";
      //JSvTFWLoadVatTableHtml(); // Load Vat Table
      if ((tDocNo != '' && (tStaApv == 1 && tStaPrcStk == 1))) {
        $(".xWEditInlineElement").attr("readonly","readonly");
        // $(".xCNBTNPrimeryPlus").attr("disabled","disabled");
        $(".xCNBTNPrimeryPlus").unbind("click");
      }
      JCNxCloseLoading();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}



/**
* Functionality : เปลี่ยนรูปแบบ Edit inline ใหม่ สำหรับ ใบโอนคลังแบบมี validate
* Parameters : ค่า next function and parameter
* Creator : 18/06/2019 Pap
* Last Modified : -
* Return : text -
* Return Type : -
*/
var tNewEvent = "";
var tOldEvent = "";
var nIndexInputEditInlineForVD  = 0;
function JCNxSetNewEditInlineForVD(poParameter){
    //========= delete edit inline btn
    var odvEditInlineBtn = $("#"+poParameter.TableID+" tr th."+poParameter.EditInLineButtonDeleteClass);
    var nOdvEditInlineBtnIndex = $("#"+poParameter.TableID+" tr th").index(odvEditInlineBtn);
    $($("#"+poParameter.TableID+" tr th").eq(nOdvEditInlineBtnIndex)).remove();
    if($("#"+poParameter.TableID+" tbody tr td."+poParameter.NotFoundDataRowClass).length==0){
        for(var nI = 0;nI < $("#"+poParameter.TableID+" tbody tr").length;nI++){
            let aOtdPdtTable = $("#"+poParameter.TableID+" tbody tr").eq(nI).children();
            $($(aOtdPdtTable).eq(nOdvEditInlineBtnIndex)).remove();
        }
    }
    //========= end delete edit inline btn
    if($("#"+poParameter.TableID+" tbody ."+poParameter.NotFoundDataRowClass).length==0){
        var aDOCPdtTableTRChild = $("#"+poParameter.TableID+" tbody").children();
        for(var nI = 0;nI < aDOCPdtTableTRChild.length;nI++){
            var aDOCPdtTableTDChild = $($(aDOCPdtTableTRChild).eq(nI)).children();
            for(var nJ = 0;nJ < aDOCPdtTableTDChild.length;nJ++){
                if($(aDOCPdtTableTDChild.eq(nJ)).children().length==2){
                    let aDOCPdtTableTDChildElement;
                    if($($(aDOCPdtTableTDChild.eq(nJ)).children().eq(0)).attr("class").indexOf(""+poParameter.LabelShowDataClass)!=-1){
                        aDOCPdtTableTDChildElement = $($(aDOCPdtTableTDChild.eq(nJ)).children().eq(0));
                    }else if($($(aDOCPdtTableTDChild.eq(nJ)).children().eq(1)).attr("class").indexOf(""+poParameter.LabelShowDataClass)!=-1){
                        aDOCPdtTableTDChildElement = $($(aDOCPdtTableTDChild.eq(nJ)).children().eq(1));
                    }
                    aDOCPdtTableTDChildElement.addClass("xWEditInlineElement");
                    
                    $($(aDOCPdtTableTDChildElement).parent()).attr("style",$($(aDOCPdtTableTDChildElement).parent()).attr("style")+"border : 0px !important;position:relative;");
                    
                    $(aDOCPdtTableTDChildElement).addClass("field__input a-field__input");
                    var tReadOnlyAttr = "";
                    if($(aDOCPdtTableTDChildElement).attr("readonly")!==undefined){
                      tReadOnlyAttr = "readonly";
                    }
                    var tNewInputReplace = "<input "+tReadOnlyAttr+" value='"+$(aDOCPdtTableTDChildElement).text()+"' type='text' class='"+$(aDOCPdtTableTDChildElement).attr("class")+"'";
                    for(let nI = 0;nI<poParameter.DataAttribute.length;nI++){
                        let aDOCPdtTableTDChildElementAttr = $(aDOCPdtTableTDChildElement).attr(poParameter.DataAttribute[nI]);
                        if(aDOCPdtTableTDChildElementAttr!==undefined && aDOCPdtTableTDChildElementAttr!=""){
                            tNewInputReplace += " "+poParameter.DataAttribute[nI]+"=\""+aDOCPdtTableTDChildElementAttr+"\"";
                        }
                    }
                    if($(aDOCPdtTableTDChildElement).attr("readonly")!==undefined){
                      tNewInputReplace += " style=\"background-color: #eee !important;opacity: 1;\"";
                    }
                    tNewInputReplace += ">";
                    $(aDOCPdtTableTDChildElement).parent().append(tNewInputReplace);
                    $(aDOCPdtTableTDChildElement).remove();
                    if($($(aDOCPdtTableTDChild.eq(nJ)).children().eq(0)).attr("class").indexOf(""+poParameter.LabelShowDataClass)!=-1){
                        aDOCPdtTableTDChildElement = $($(aDOCPdtTableTDChild.eq(nJ)).children().eq(0));
                    }else if($($(aDOCPdtTableTDChild.eq(nJ)).children().eq(1)).attr("class").indexOf(""+poParameter.LabelShowDataClass)!=-1){
                        aDOCPdtTableTDChildElement = $($(aDOCPdtTableTDChild.eq(nJ)).children().eq(1));
                    }
                    $(aDOCPdtTableTDChildElement).attr("style","background:#F9F9F9;border-top: 0px !important;border-left: 0px !important;border-right: 0px !important;box-shadow: inset 0 0px 0px;"+$(aDOCPdtTableTDChildElement).attr("style"));
                    $(aDOCPdtTableTDChildElement).unbind("keydown focusout");
                    $(aDOCPdtTableTDChildElement).bind("keydown focusout",function(e){
                        let oEmElement = $(".xWEditInlineElement");
                        for(let nI=0;nI<oEmElement.length;nI++){
                          let OElementEmError = $($($(".xWEditInlineElement").eq(nI)).parent()).children();
                          for(let nJ =0;nJ<$(OElementEmError).length;nJ++){
                            if($($(OElementEmError).eq(nJ)).attr("class")!==undefined){
                              if($($(OElementEmError).eq(nJ)).attr("class").indexOf("error")!=-1 &&
                                $($(OElementEmError).eq(nJ)).prop("tagName")=="EM"){
                                $(oEmElement.eq(nI)).attr("style","background: #F9F9F9;border-top: 0px !important;border-left: 0px !important;border-right: 0px !important;box-shadow: inset 0 0px 0px;"+$(oEmElement.eq(nI)).attr("style"));
                                $($(OElementEmError).eq(nJ)).remove();
                              }
                            }
                          }
                        }
                        let bCehckEvent = false;
                        let nKeyCode = e.keyCode || e.which;
                        let bCheckeyEvent = false;
                        let nIndexElement = $(".xWEditInlineElement").index(this);
                        
                        if(e.type=="keydown"){
                            if(nKeyCode === 13){
                                if(nIndexElement+1!=$(".xWEditInlineElement").length){
                                    nIndexInputEditInlineForVD = nIndexElement+1;
                                }else{
                                    nIndexInputEditInlineForVD = 0;
                                }
                                bCheckeyEvent = true;
                            }
                        }else if(e.type=="focusout"){
                          bCheckeyEvent = true;
                        }
                        if(bCheckeyEvent){
                            tNewEvent = e.type;
                            //============== set label value to input value
                            let oOdvInputElemen;
                            if($($(this).parent().children().eq(0)).attr("class").indexOf(""+poParameter.DivHiddenDataEditClass)!=-1){
                                oOdvInputElement = $($(this).parent().children().eq(0));
                            }else if($($(this).parent().children().eq(1)).attr("class").indexOf(""+poParameter.DivHiddenDataEditClass)!=-1){
                                oOdvInputElement = $($(this).parent().children().eq(1));
                            }
                            // input tag value
                            let oOhdTextInput = $(oOdvInputElement).children().eq(0);
                            let oOhdTextInputValue = $(oOhdTextInput).val();
                            let oElementValue = $(this).val();
                            let bCheckIsNumber = false;
                            if(oOhdTextInputValue.match(/^-{0,1}\d+$/) &&
                               oElementValue.match(/^-{0,1}\d+$/)){
                                bCheckIsNumber = true;
                                
                            }else if(oOhdTextInputValue.match(/^\d+\.\d+$/) &&
                                     oElementValue.match(/^\d+\.\d+$/)){
                                bCheckIsNumber = true;
                                
                            }
                            let bCheckCompare = false;
                            if(bCheckIsNumber){
                                if(parseFloat(oOhdTextInputValue)!=parseFloat(oElementValue)){
                                    bCheckCompare = true;
                                }
                            }
                            let oParameters = {};
                            oParameters.VeluesInline = oElementValue;
                            oParameters.Element = $(oOhdTextInput);
                            oParameters.DataAttribute = [];
                            for(let nI = 0;nI<poParameter.DataAttribute.length;nI++){
                                let aDOCPdtTableTDChildElementAttr = $(this).attr(poParameter.DataAttribute[nI]);
                                if(aDOCPdtTableTDChildElementAttr!==undefined && aDOCPdtTableTDChildElementAttr!=""){
                                    oParameters.DataAttribute[nI] = {[poParameter.DataAttribute[nI]]:$(this).attr(poParameter.DataAttribute[nI])};
                                }
                            }
                            let nDataMax = 0;
                            let nDataMin = 0;
                            let nDataSeq = 0;
                            let nDataUser = 0;
                            let nValue = parseFloat(oParameters.VeluesInline);
                            for(let nI=0;nI<oParameters.DataAttribute.length;nI++){
                                if(Object.keys(oParameters.DataAttribute[nI])=="dataMax"){
                                  nDataMax = parseFloat(oParameters.DataAttribute[nI].dataMax);
                                }else if(Object.keys(oParameters.DataAttribute[nI])=="dataMin"){
                                  nDataMin = parseFloat(oParameters.DataAttribute[nI].dataMin);
                                }else if(Object.keys(oParameters.DataAttribute[nI])=="dataSeq"){
                                  nDataSeq = oParameters.DataAttribute[nI].dataSeq;
                                }else if(Object.keys(oParameters.DataAttribute[nI])=="dataUser"){
                                  nDataUser = parseFloat(oParameters.DataAttribute[nI].dataUser);
                                }
                            }
                            
                            let oEmElement = $($($(this).parent()).find("em.error"));
                            if(oEmElement!==undefined){
                              oEmElement.remove();
                            }
                            
                            if(bCheckIsNumber){
                              if(bCheckCompare){
                                  if(nValue>=nDataMin&&nValue<=nDataMax){
                                    if(nDataUser!=nValue){
                                        let oLoaddingHtml = "<div>";
                                        oLoaddingHtml     += "   <img style=\"width:20px;height:20px;position:absolute;left: 50%;transform: translate(-40%, 0);\" src=\""+$("#ohdBaseUrlUseInJS").val()+"application/modules/common/assets/images/ada.loading.gif\" class=\"xWImgLoading xWEditInlineLoadding\">";
                                        oLoaddingHtml     += "</div>";
                                        $($(this).parent()).children().addClass("hidden");
                                        $($(this).parent()).append(oLoaddingHtml);
  
                                        $(".xWEditInlineElement").attr("disabled","disabled");
                                        
                                        window[poParameter.FunctionName](oParameters);
                                    }else{
                                      $($(".xWEditInlineElement").eq(nDataSeq)).attr("style","background: #F9F9F9;border-top: 0px !important;border-left: 0px !important;border-right: 0px !important;box-shadow: inset 0 0px 0px;"+$($(".xWEditInlineElement").eq(nDataSeq)).attr("style"));
                                      if(e.type=="keydown"){
                                        
                                        $(".xWEditInlineElement").eq(nIndexInputEditInlineForVD).focus();
                                        $($(".xWEditInlineElement").eq(nIndexInputEditInlineForVD)).select(); 
                                      }

                                    }
                                    
                                      
                                  }else{
                                    
                                    if(nValue<nDataMin){
                                      $($(".xWEditInlineElement").eq(nDataSeq)).val(nDataMax);
                                      $($(".xWEditInlineElement").eq(nDataSeq)).attr("style","background: #F9F9F9;border-color: #a94442;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);"+$($(".xWEditInlineElement").eq(nDataSeq)).attr("style"));
                                      $($(this).parent()).append("<em class=\"error help-block\">กรุณากรอกตัวเลขต่ำสุด "+nDataMin+"</em>");
                                    }else if(nValue>nDataMax){
                                      $($(".xWEditInlineElement").eq(nDataSeq)).val(nDataMax);
                                      $($(".xWEditInlineElement").eq(nDataSeq)).attr("style","background: #F9F9F9;border-color: #a94442;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);"+$($(".xWEditInlineElement").eq(nDataSeq)).attr("style"));
                                      $($(this).parent()).append("<em class=\"error help-block\">กรุณากรอกตัวเลขสูงสุด "+nDataMax+"</em>");
                                    }
                                    
                                    
                                  }
                              }else{
                                $($(".xWEditInlineElement").eq(nDataSeq)).attr("style","background: #F9F9F9;border-top: 0px !important;border-left: 0px !important;border-right: 0px !important;box-shadow: inset 0 0px 0px;"+$($(".xWEditInlineElement").eq(nDataSeq)).attr("style"));
                                if(e.type=="keydown"){
                                        
                                  $(".xWEditInlineElement").eq(nIndexInputEditInlineForVD).focus();
                                  $($(".xWEditInlineElement").eq(nIndexInputEditInlineForVD)).select(); 
                                }
                              }
                            }else{
                              $($(".xWEditInlineElement").eq(nDataSeq)).val(nDataMax);
                              $($(".xWEditInlineElement").eq(nDataSeq)).attr("style","background: #F9F9F9;border-color: #a94442;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);"+$($(".xWEditInlineElement").eq(nDataSeq)).attr("style"));
                              $($(this).parent()).append("<em class=\"error help-block\">กรุณากรอกตัวเลข</em>");
                                    
                            }
                        }
                    });
                }
            }
        }
    }
}



function JSxUpdateTmpInfor(poInforInlineUpdate){
  if((tOldEvent=="focusout" && tNewEvent=="focusout") || (tOldEvent=="" && tNewEvent=="focusout")){
    let nDataRow = 0;
    let nDtaCol = 0;
    let nValue = parseFloat(poInforInlineUpdate.VeluesInline);
    for(let nI=0;nI<poInforInlineUpdate.DataAttribute.length;nI++){
        if(Object.keys(poInforInlineUpdate.DataAttribute[nI])=="dataRow"){
          nDataRow  = parseFloat(poInforInlineUpdate.DataAttribute[nI].dataRow);
        }else if(Object.keys(poInforInlineUpdate.DataAttribute[nI])=="dataCol"){
          nDtaCol   = parseFloat(poInforInlineUpdate.DataAttribute[nI].dataCol);
        }
    }
    let nPage     = $(".xWPageTFWPdt .active").text();
    var tXthDocNo = $("#oetXthDocNo").val();
    if($("#ohdTFWRoute").val()=="ADJSTKVDEventAdd"){
      tXthDocNo = "";
    }
    $.ajax({
      type  : "POST",
      url   : "ADJSTKVDPdtUpdateTem",
      data  : {
        FTBchCode           : $("#ohdBchCode").val(),
        FTXthDocNo          : tXthDocNo,
        FNLayRow            : nDataRow,
        FNLayCol            : nDtaCol,
        FCUserInPutTransfer : nValue,
        FNCabSeq            : poInforInlineUpdate.DataAttribute[6].dataseqcabinet
      },
      cache   : false,
      Timeout : 0,
      success : function (tResult) {
        $("#aa").html(tResult);
        JSvTFWLoadPdtDataTableHtml(nPage);
      },
      error   : function (jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });


  }
  tOldEvent = tNewEvent;
}

//Function : โหลด Html Vat มาแปะ ในหน้า Add
//Create : 04/04/2019 Krit(Copter)
function JSvTFWLoadVatTableHtml() {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    // var tXthDocNo = $("#oetXthDocNo").val();
    // var tXthVATInOrEx = $("#ostXthVATInOrEx").val();

    $.ajax({
      type: "POST",
      url: "ADJSTKVDVatTableLoadData",
      data: {
        // tXthDocNo: tXthDocNo,
        // tXthVATInOrEx: tXthVATInOrEx
      },
      cache: false,
      Timeout: 0,
      success: function (tResult) {
        // $("#odvVatPanal").html(tResult);
        // //จำนวนรวมภาษี
        // var nSumVatRate = 0;
        // for (var i = 0; i < $(".xWPriceSumVateRate").length; i++) {
        //   nSumVatRate += parseFloat($($(".xWPriceSumVateRate").get(i)).find("label").html().replace(",", ""));
        // }
        // if ($(".xWPriceSumVateRate").length != 0) {

        //   $("#olaSumXtdVat").html(accounting.formatMoney(nSumVatRate.toFixed(2), "", "2"));
        //   $("#olaVatTotal").html(accounting.formatMoney(nSumVatRate.toFixed(2), "", "2"));
        // } else {
        //   $("#olaSumXtdVat").html("-");
        //   $("#olaVatTotal").html("-");
        // }
        // JSxTFWSetCalculateLastBillSetText();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });



  } else {
    JCNxShowMsgSessionExpired();
  }
}

//Function : ส่ง จำนวนเงิน ไปแปลเป็น ไทย , Set Text จำนวนยอดสุทธิท้ายบิล
//Create : 04/04/2019 Krit(Copter)
function JSxTFWSetCalculateLastBillSetText() {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    tXthDocNo = $("#oetXthDocNo").val();
    tXthVATInOrEx = $("#ostXthVATInOrEx").val();
    $.ajax({
      type: "POST",
      url: "ADJSTKVDCalculateLastBill",
      data: {
        tXthDocNo: tXthDocNo,
        tXthVATInOrEx: tXthVATInOrEx
      },
      cache: false,
      Timeout: 0,
      success: function (tResult) {
        aResult = $.parseJSON(tResult);
        //จำนวนเงินเป็นภาษาไทย
        $("#othFCXthGrandText").html(aResult.tXphGndText);

        //ยอดรวมสุทธิ
        $("#othFCXthGrandB4Wht").text(aResult.FCXthTotal);

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
    url: "ADJSTKVDAdvanceTableShowColList",
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

  //alert(aColShowAllList);

  var nStaSetDef;
  if ($("#ocbSetToDef").is(":checked")) {
    nStaSetDef = 1;
  } else {
    nStaSetDef = 0;
  }
  //alert(aColShowSet);

  $.ajax({
    type: "POST",
    url: "ADJSTKVDAdvanceTableShowColSave",
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
      //Function Gen Table Pdt ของ TFW
      JSvTFWLoadPdtDataTableHtml(1);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//ปรับ Value ใน Input หลัวจาก กรอก เสร็จ
function JSxTFWAdjInputFormat(ptInputID) {
  cVal = $("#" + ptInputID).val();
  cVal = accounting.toFixed(cVal, nOptDecimalShow);
  $("#" + ptInputID).val(cVal);
}

// function JSvTFWCallGetHDDisTableData(){

//     tXthDocNo 			= $('#oetXthDocNo').val();
//     nXthVATInOrEx 		= $('#ostXthVATInOrEx').val();
//     nXthRefAEAmt 		= $('#oetXthRefAEAmtInput').val();
//     nXthVATRate 		= $('#oetXthVatRateInput').val();
//     nXthWpTax 			= $('#oetFCXthWpTaxInput').val();

//         $.ajax({
//         type: "POST",
//         url: "TFWGetHDDisTableData",
//         data: {
//             'tXthDocNo'    		: tXthDocNo,
//             'nXthVATInOrEx'		: nXthVATInOrEx,
//             'nXthRefAEAmt' 		: nXthRefAEAmt,
//             'nXthVATRate'  		: nXthVATRate,
//             'nXthWpTax'			: nXthWpTax
//         },
//         cache: false,
//         success: function(tResult) {

//             $('#odvHDDisListPanal').html(tResult);

//         },
//         error: function(jqXHR, textStatus, errorThrown) {
//             JCNxResponseError(jqXHR, textStatus, errorThrown);
//         }
//     });

// }
