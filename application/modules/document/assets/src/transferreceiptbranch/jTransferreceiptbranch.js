var nStaTBIBrowseType = $("#oetTBIStaBrowse").val();
var tCallTBIBackOption = $("#oetTBICallBackOption").val();
var tTBIDocType = $("#oetTBIDocType").val();

$("document").ready(function () {
  localStorage.removeItem("LocalItemData");
  JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
  JSxTBINavDefult();

  if (nStaTBIBrowseType != 1) {
    JSvCallPageTBIList();
  } else {
    JSvCallPageTBIAdd();
  }
});

function JSxTBIClearDTTemp() {

  console.log('Function : JSxTBIClearDTTemp')

  $.ajax({
    type: "POST",
    url: "dcmTBIClearDTTemp",
    data: {
      tTBIDocType: tTBIDocType,
      tXthDocNo: $("#oetXthDocNo").val(),
    },
    cache: false,
    Timeout: 0,
    success: function (tResult) {

      console.log("StaDelDTTmp :" + tResult)

      JSvTBILoadPdtDataTableHtml();

    },
    error: function (jqXHR, textStatus, errorThrown) { }
  });

}

function JSxTBIAftSelectRefInt(poJsonData) {

  console.log("JSxTBIAftSelectRefInt : ");
  console.log(poJsonData);

  if (poJsonData != 'NULL') {

    aData = JSON.parse(poJsonData);
    tOldRefIntCode = $("#oetXthRefInt").data("oldval");

    tNewRefIntCode = aData[0];
    tXthCtrName = aData[1];
    dXthTnfDate = aData[2];
    aXthTnfDate = dXthTnfDate.split(" ");;
    tXthRefTnfID = aData[3];
    tXthRefVehID = aData[4];
    tXthQtyAndTypeUnit = aData[5];
    nXthShipAdd = aData[6];
    tViaCode = aData[7];
    tViaName = aData[8];

    console.log(tOldRefIntCode + "::" + tNewRefIntCode);

    if (tOldRefIntCode != tNewRefIntCode) {

      //Set ค่าใหม่แทนที่ค่าเก่า ใน Iput
      $("#oetXthRefInt").data("oldval", tNewRefIntCode);

      console.log(aXthTnfDate);

      //ค่าที่ได้จากการเลือก เอกสารอ้างอิงภายใน
      $("#oetXthCtrName").val(tXthCtrName);
      $("#oetXthTnfDate").datepicker('setDate', aXthTnfDate[0]);
      $("#oetXthRefTnfID").val(tXthRefTnfID);
      $("#ohdViaCode").val(tViaCode);
      $("#oetViaName").val(tViaName);
      $("#oetXthRefVehID").val(tXthRefVehID);
      $("#oetXthQtyAndTypeUnit").val(tXthQtyAndTypeUnit);
      $("#ohdXthShipAdd").val(nXthShipAdd);

      $.ajax({
        type: "POST",
        url: "dcmTBIGetDataRefInt",
        data: {
          tXthDocNo: $("#oetXthDocNo").val(),
          tTBIDocType: tTBIDocType,
          tTXODocNo: tNewRefIntCode
        },
        cache: false,
        Timeout: 0,
        success: function (tResult) {

          console.log(tResult);
          aResult = JSON.parse(tResult);

          if (aResult['rtCode'] == 1) {
            var tItems = aResult['raItems'][0];
            // console.log(tItems)

            //Branch
            $("#oetBchCode").val(tItems['FTBchCode']);
            $("#oetBchName").val(tItems['FTBchName']);
            //Branch

            //Merchnt
            $("#oetMchCode").val(tItems['FTXthMerCode']);
            $("#oetMchName").val(tItems['FTMerName']);
            //Merchnt

            //Shop
            $("#oetShpCodeStart").val(tItems['FTXthShopFrm']);
            $("#oetShpNameStart").val(tItems['FTShpNameFrm']);

            $("#oetShpCodeEnd").val(tItems['FTXthShopTo']);
            $("#oetShpNameEnd").val(tItems['FTShpNameTo']);
            //Shop

            //Pos
            $("#oetPosCodeStart").val(tItems['FTPosCodeFrm']);
            $("#oetPosNameStart").val(tItems['FTPosNameFrm']);


            //ถ้า Pos Frm มีค่าจะ Show Input
            if (tItems['FTPosCodeFrm'] != null) {
              $('#oetPosCodeStart').parent().parent().removeClass('xCNHide');
            } else {
              $('#oetPosCodeStart').parent().parent().addClass('xCNHide');
            }

            $("#oetPosCodeEnd").val(tItems['FTPosCodeTo']);
            $("#oetPosNameEnd").val(tItems['FTPosNameTo']);
            //ถ้า Pos Frm มีค่าจะ Show Input
            if (tItems['FTPosCodeTo'] != null) {
              $('#oetPosCodeEnd').parent().parent().removeClass('xCNHide');
            } else {
              $('#oetPosCodeEnd').parent().parent().addClass('xCNHide');
            }
            //Pos

            //Wahouse
            $("#ohdWahCodeStart").val(tItems['FTXthWhFrm']);
            $("#oetWahNameStart").val(tItems['FTWahNameFrm']);

            $("#ohdWahCodeEnd").val(tItems['FTXthWhTo']);
            $("#oetWahNameEnd").val(tItems['FTWahNameTo']);
            //Wahouse


            //Put Data To Panal การจัดส่ง 



            JSvTBILoadPdtDataTableHtml();

            JCNxCloseLoading();
          } else {

            JCNxCloseLoading();
          }

        },
        error: function (jqXHR, textStatus, errorThrown) { }
      });



    } else {
      console.log('RefInt Not Change');
    }

  } else {

    JSxTBIClearDTTemp();

    $("#oetXthRefInt").data("oldval", "");
    if ($("#oetXthRefInt").data("oldval") != "") {
      $("#oetXthRefInt").data("oldval", "");
    }
    console.log("NULL");

    // ถ้าไม่เลือกจะดึงค่า Default มาแสดง
    //Branch
    $("#oetBchCode").val($("#oetBchCode").data('oldval'));
    $("#oetBchName").val($("#oetBchName").data('oldval'));

    //Merchant
    $("#oetMchCode").val($("#oetMchCode").data('oldval'));
    $("#oetMchName").val($("#oetMchName").data('oldval'));

    //Shop From
    $("#oetShpCodeStart").val($("#oetShpCodeStart").data('oldval'));
    $("#oetShpNameStart").val($("#oetShpNameStart").data('oldval'));

    //Pos From
    $("#oetPosCodeStart").val($("#oetPosCodeStart").data('oldval'));
    $("#oetPosNameStart").val($("#oetPosNameStart").data('oldval'));
    if ($("#oetPosCodeStart").data('oldval') != undefined) {
      $("#oetPosCodeStart").parent().parent().addClass('xCNHide');
    } else {
      $("#oetPosCodeStart").parent().parent().removeClass('xCNHide');
    }

    //Wahouse From
    $("#ohdWahCodeStart").val($("#ohdWahCodeStart").data('oldval'));
    $("#oetWahNameStart").val($("#oetWahNameStart").data('oldval'));

    /* ****************************************************************** */

    //Shop To
    $("#oetShpCodeEnd").val("");
    $("#oetShpNameEnd").val("");

    //Pos From
    $("#oetPosCodeEnd").parent().parent().addClass("xCNHide");
    $("#oetPosCodeEnd").val("");
    $("#oetPosNameEnd").val("");

    //Wahouse To
    $("#ohdWahCodeEnd").val("");
    $("#oetWahNameEnd").val("");


    //ค่าที่ได้จากการเลือก เอกสารอ้างอิงภายใน
    $("#oetXthCtrName").val('');
    $("#oetXthTnfDate").datepicker('setDate', new Date());
    $("#oetXthRefTnfID").val('');
    $("#ohdViaCode").val('');
    $("#oetViaName").val('');
    $("#oetXthRefVehID").val('');
    $("#oetXthQtyAndTypeUnit").val('');
    $("#ohdXthShipAdd").val('');

  }
}

/**
 * Functionality : Get search data
 * Parameters : -
 * Creator : 07/03/2019 Krit(Copter)
 * Last Modified : -
 * Return : Search data
 * Return Type : Object
 */
function JSoTBIGetAdvanceSearchData() {
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
    console.log("JSoTBIGetAdvanceSearchData Error: ", err);
  }
}

/**
 * Functionality : Clear search data
 * Parameters : -
 * Creator : 12/12/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxTBIClearSearchData() {
  try {
    $("#oetSearchAll").val("");
    $("#oetBchCodeFrom").val("");
    $("#oetBchNameFrom").val("");
    $("#oetBchCodeTo").val("");
    $("#oetBchNameTo").val("");
    $("#oetSearchDocDateFrom").val("");
    $("#oetSearchDocDateTo").val("");
    $(".selectpicker")
      .val("0")
      .selectpicker("refresh");
    JSvCallPagePdtTBIPdtDataTable();
  } catch (err) {
    console.log("JSxCardShiftTopUpClearSearchData Error: ", err);
  }
}

// put ค่าจาก Modal ลง Input หน้า Add
function JSnTBIAddShipAdd() {
  tShipAddSeqNoSelect = $("#ohdShipAddSeqNo").val();
  $("#ohdXthShipAdd").val(tShipAddSeqNoSelect);

  $("#odvTBIBrowseShipAdd").modal("toggle");
}

function JSxTBIAftSelectShipAddress(poJsonData) {

  tBchCode = $("#oetBchCode").val();
  tShpCodeEnd = $("#oetShpCodeEnd").val();
  tShpCodeEnd = $("#oetShpCodeEnd").val();


  //ถ้าไม่มีการเลือก มาจะส่ง NULL
  if (poJsonData != "NULL") {
    aData = JSON.parse(poJsonData);
    FTAddRefCode = aData[0];
    FNAddSeqNo = aData[1];
  } else {
    FTAddRefCode = 0;
    FNAddSeqNo = 0;
  }

  JSvTWIGetShipAddData(FTAddRefCode, FNAddSeqNo);
}


/*
functionality : Nect function ของ ShopFrom
*/
function JSxTWIGetWahFormShopFrom(poJsonData) {
  if (poJsonData != "NULL") {
    aData = JSON.parse(poJsonData);

    tWahCode = aData[0];
    tWahName = aData[1];
    tShpType = aData[2];

    // 4 คือ Type Vending
    if (tShpType == 4) {

      //Control Pos From ถ้า เป็น Vending
      $('#oetPosCodeFrom').val('');
      $('#oetPosNameFrom').val('');
      $('#obtTBIBrowsePosFrom').attr('disabled', false);

      //Control WatrHouse From ถ้า เป็น Vending
      $('#ohdWahCodeFrom').val('');
      $('#oetWahNameFrom').val('');
      $('#obtTBIBrowseWahFrom').attr('disabled', false);

      var tBchCode = $("#oetBchCode").val();
      var tShpCode = $("#oetShpCode").val();
      oTWIBrowsePosFrom.Where.Condition = ["AND TVDMPosShop.FTBchCode = '" + tBchCode + "' AND TVDMPosShop.FTShpCode  = '" + tShpCode + "' "];

    } else {

      $('#oetPosCodeFrom').val('');
      $('#oetPosNameFrom').val('');
      $('#obtTBIBrowsePosFrom').attr('disabled', true);

      $('#ohdWahCodeFrom').val('');
      $('#oetWahNameFrom').val('');
      $('#obtTBIBrowseWahFrom').attr('disabled', false);
      var tShpCode = $("#oetShpCode").val();
      oTWIBrowseWahFrom.Where.Condition = ["AND TCNMWaHouse.FTWahStaType = '4' AND TCNMWaHouse.FTWahRefCode = '" + tShpCode + "' "];

    }

    //หยอดค่า Wah ของ Shp นั้นๆ 
    if (tWahCode != "" && tWahCode != undefined) {
      $("#ohdWahCodeFrom").val(tWahCode);
      $("#oetWahNameFrom").val(tWahName);
    } else {
      $("#ohdWahCodeFrom").val("");
      $("#oetWahNameFrom").val("");
    }

  }
}


/*
functionality : Nect function ของ ShopTo
*/
function JSxTWIGetWahFormShopTo(poJsonData) {
  if (poJsonData != "NULL") {
    aData = JSON.parse(poJsonData);

    tWahCode = aData[0];
    tWahName = aData[1];
    tShpType = aData[2];

    // 4 คือ Type Vending
    if (tShpType == 4) {

      //Control Pos To ถ้า เป็น Vending
      $('#oetPosCodeTo').val('');
      $('#oetPosNameTo').val('');
      $('#obtTBIBrowsePosTo').attr('disabled', false);

      //Control WatrHouse To ถ้า เป็น Vending
      $('#ohdWahCodeTo').val('');
      $('#oetWahNameTo').val('');
      $('#obtTBIBrowseWahTo').attr('disabled', false);

      var tBchCode = $("#oetBchCode").val();
      var tShpCodeTo = $("#oetShpCodeTo").val();
      oTWIBrowsePosTo.Where.Condition = ["AND TVDMPosShop.FTBchCode = '" + tBchCode + "' AND TVDMPosShop.FTShpCode  = '" + tShpCodeTo + "' "];

    } else {

      $('#oetPosCodeTo').val('');
      $('#oetPosNameTo').val('');
      $('#obtTBIBrowsePosTo').attr('disabled', true);

      $('#ohdWahCodeTo').val('');
      $('#oetWahNameTo').val('');
      $('#obtTBIBrowseWahTo').attr('disabled', false);
      var tShpCodeTo = $("#oetShpCodeTo").val();
      oTWIBrowseWahTo.Where.Condition = ["AND TCNMWaHouse.FTWahStaType = '4' AND TCNMWaHouse.FTWahRefCode = '" + tShpCodeTo + "' "];

    }

    //หยอดค่า Wah ของ Shp นั้นๆ 
    if (tWahCode != "" && tWahCode != undefined) {

      tWahCodeFrom = $('#ohdWahCodeFrom').val();
      if (tWahCodeFrom != tWahCode) {
        $("#ohdWahCodeTo").val(tWahCode);
        $("#oetWahNameTo").val(tWahName);
      }

    } else {
      $("#ohdWahCodeTo").val("");
      $("#oetWahNameTo").val("");
    }

  }
}

/*Get Wah From PosFrom */
function JSxTWIGetWahFormPosFrom(poJsonData) {

  if (poJsonData != 'NULL') {
    aData = JSON.parse(poJsonData);

    tWahCode = aData[0];
    tWahName = aData[1];

    //หยอดค่า Wah ของ Pos นั้นๆ 
    if (tWahCode != "" && tWahCode != undefined) {
      $("#ohdWahCodeFrom").val(tWahCode);
      $("#oetWahNameFrom").val(tWahName);
    } else {
      $("#ohdWahCodeFrom").val("");
      $("#oetWahNameFrom").val("");
    }

  } else {
    $("#ohdWahCodeFrom").val("");
    $("#oetWahNameFrom").val("");
  }

}

/*Get Wah From PosTo */
function JSxTWIGetWahFormPosTo(poJsonData) {
  if (poJsonData != 'NULL') {
    aData = JSON.parse(poJsonData);

    tWahCode = aData[0];
    tWahName = aData[1];

    //หยอดค่า Wah ของ Pos นั้นๆ 
    if (tWahCode != "" && tWahCode != undefined) {
      $("#ohdWahCodeTo").val(tWahCode);
      $("#oetWahNameTo").val(tWahName);
    } else {
      $("#ohdWahCodeTo").val("");
      $("#oetWahNameTo").val("");
    }

  } else {
    $("#ohdWahCodeTo").val("");
    $("#oetWahNameTo").val("");
  }

}

//Get ข้อมูล Address มาใส่ modal แบบ Array
function JSvTWIGetShipAddData(FTAddRefCode, FNAddSeqNo) {
  console.log(FTAddRefCode + " " + FNAddSeqNo);
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    if (FNAddSeqNo != "" && FNAddSeqNo != 0) {
      $.ajax({
        type: "POST",
        url: "dcmTBIGetAddress",
        data: {
          FTAddRefCode: FTAddRefCode,
          FNAddSeqNo: FNAddSeqNo
        },
        cache: false,
        Timeout: 0,
        success: function (tResult) {
          aData = JSON.parse(tResult);

          // console.log('JSvTWIGetShipAddData: ');
          console.log(aData);

          if (aData != 0) {
            $("#ospShipAddAddV1No").text(aData[0]["FTAddV1No"]);
            $("#ospShipAddV1Soi").text(aData[0]["FTAddV1Soi"]);
            $("#ospShipAddV1Village").text(aData[0]["FTAddV1Village"]);
            $("#ospShipAddV1Road").text(aData[0]["FTAddV1Road"]);
            $("#ospShipAddV1SubDist").text(aData[0]["FTSudName"]);
            $("#ospShipAddV1DstCode").text(aData[0]["FTDstName"]);
            $("#ospShipAddV1PvnCode").text(aData[0]["FTPvnName"]);
            $("#ospShipAddV1PostCode").text(aData[0]["FTAddV1PostCode"]);
            $("#ospShipAddV2Desc1").text(aData[0]["FTAddV2Desc1"]);
            $("#ospShipAddV2Desc2").text(aData[0]["FTAddV2Desc2"]);
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

          //เอาค่าจาก input หลัก มาใส่ input ใน modal
          $("#ohdShipAddSeqNo").val(FNAddSeqNo);
          //Show
          $("#odvTBIBrowseShipAdd").modal("show");
        },
        error: function (jqXHR, textStatus, errorThrown) { }
      });
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

      //เอาค่าจาก input หลัก มาใส่ input ใน modal
      $("#ohdShipAddSeqNo").val("");
      //Show
      $("#odvTBIBrowseShipAdd").modal("show");
    }
  } else {
    JCNxShowMsgSessionExpired();
  }
}

/**
 * Functionality : Action for approve
 * Parameters : pbIsConfirm
 * Creator : 1/02/2019 Krit(Copter)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnTWIApprove(pbIsConfirm) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    try {
      if (pbIsConfirm) {
        $("#ohdCardShiftTopUpCardStaPrcDoc").val(2); // Set status for processing approve
        $("#odvTBIPopupApv").modal("hide");

        tXthDocNo = $("#oetXthDocNo").val();
        tXthStaApv = $("#ohdXthStaApv").val();

        $.ajax({
          type: "POST",
          url: "dcmTBIApprove",
          data: {
            tXthDocNo: tXthDocNo,
            tXthStaApv: tXthStaApv
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
            } catch (e) { }

            JSoTWISubscribeMQ();
          },
          error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
        });
      } else {
        //console.log("StaApvDoc Call Modal");
        $("#odvTBIPopupApv").modal("show");
      }
    } catch (err) {
      console.log("JSnTWIApprove Error: ", err);
    }
  } else {
    JCNxShowMsgSessionExpired();
  }

}


function JSoTWISubscribeMQ() {
  //RabbitMQ
  /*===========================================================================*/
  // Document variable
  var tLangCode = $("#ohdLangEdit").val();
  var tUsrBchCode = $("#oetBchCode").val();
  var tUsrApv = $("#oetXthApvCodeUsrLogin").val();
  var tDocNo = $("#oetXthDocNo").val();
  var tPrefix = "RESTWI";
  var tStaApv = $("#ohdXthStaApv").val();
  var tStaPrcStk = $("#ohdXthStaPrcStk").val();
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
    host: "ws://202.44.55.94:15674/ws",
    username: "adasoft",
    password: "adasoft",
    vHost: "AdaPosV5.0"
  };

  // Update Status For Delete Qname Parameter
  var poUpdateStaDelQnameParams = {
    ptDocTableName: "TCNTPdtTwiHD",
    ptDocFieldDocNo: "FTXthDocNo",
    ptDocFieldStaApv: "FTXthStaPrcStk",
    ptDocFieldStaDelMQ: "FTXthStaDelMQ",
    ptDocStaDelMQ: tStaDelMQ,
    ptDocNo: tDocNo
  };

  // Callback Page Control(function)
  var poCallback = {
    tCallPageEdit: "JSvCallPageTBIEdit",
    tCallPageList: "JSvCallPageTBIList"
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

function JCNxCloseTBIPDT() {

  $('#odvModalTBIPDT').modal('toggle');

}

function JSvTWIBrowsePdt() {

  console.log('Function : JSvTWIBrowsePdt');

  $.ajax({
    type: "POST",
    url: "dcmTBIBrowseDataPDT",
    data: {
      tRefInt: $("#oetXthRefInt").val(),
      FromToBCH: $("#ohdUserLoginBchCode").val(),
      FromToBCHName: $("#ohdUserLoginBchName").val(),
      FromToSHP: $("#ohdUserLoginShpCode").val(),
      FromToSHPName: $("#ohdUserLoginShpName").val(),
      tViaCode: $("#ohdViaCode").val(),
      nShowCountRecord: 2,
      NextFunc: "FSvPDTAddPdtIntoTableDT",
      ReturnType: "M"
    },
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      $("#odvModalTBIPDT").modal({ backdrop: "static", keyboard: false });
      $("#odvModalTBIPDT").modal({ show: true });

      //remove localstorage
      localStorage.removeItem("LocalItemDataPDT");
      $("#odvModalsectionBodyTBIPDT").html(tResult);
    },
    error: function (data) {
      console.log(data);
    }
  });

}

// function JCNvTWIBrowsePdt() {
//   aMulti = [];
//   $.ajax({
//     type: "POST",
//     url: "BrowseDataPDT",
//     data: {
//       Qualitysearch: [
//         "NAMEPDT",
//         "CODEPDT",
//         "FromToBCH",
//         "FromToSHP",
//         "FromToPGP",
//         "FromToPTY"
//       ],
//       PriceType: ["Cost", "tCN_Cost", "PDTTWI", "1"],
//       //'PriceType'       : ['Pricesell'],
//       // SelectTier: ['PDT'],
//       SelectTier: ["Barcode"],
//       //'Elementreturn'   : ['oetInputTestValue','oetInputTestName'],
//       ShowCountRecord: 5,
//       NextFunc: "FSvPDTAddPdtIntoTableDT",
//       ReturnType: "M",
//       SPL: ["", ""],
//       BCH: ["", ""],
//       SHP: ["", ""]
//     },
//     cache: false,
//     timeout: 5000,
//     success: function (tResult) {
//       $("#odvModalDOCPDT").modal({ backdrop: "static", keyboard: false });
//       $("#odvModalDOCPDT").modal({ show: true });

//       //remove localstorage
//       localStorage.removeItem("LocalItemDataPDT");
//       $("#odvModalsectionBodyPDT").html(tResult);
//     },
//     error: function (data) {
//       console.log(data);
//     }
//   });
// }

//Function Call Edit Pdt set qty
function JSnEditDTRow(event) {
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

  $(event).parent().empty().append(
    $("<img>")
      .attr("class", "xCNIconTable")
      .attr("title", "Save")
      .attr(
        "src",
        tBaseURL + "/application/modules/common/assets/images/icons/save.png"
      )
      .click(function () {
        JSnSaveDTEdit(this);
      })
  );

  //Disabled ให้กับ Input ที่ไม่ได้กด แก้ไข
  $("#odvPdtTablePanal .xCNIconTable[title='Edit']").addClass('xCNDisabled').attr("onclick", "").unbind("click");
}

//Function Save Pdt Set Qty
function JSnSaveDTEdit(event) {
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

  FSvTWIEditPdtIntoTableDT(tEditSeqNo, aField, aValue);

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
}

// Function : Del Row Html
function JSnRemoveDTRow(ele) {

  var tPdtCode = $(ele).parent().parent().parent().attr("data-pdtcode");
  var tPunCode = $(ele).parent().parent().parent().attr("data-puncode");
  var tBarCode = $(ele).parent().parent().parent().attr("data-barcode");
  var tQty = $(ele).parent().parent().parent().attr("data-qty");
  var tSeqno = $(ele).parent().parent().parent().attr("data-seqno");

  JSnTWIRemoveDTInTemp(tSeqno, tPdtCode, tPunCode, tBarCode, tQty);

}

function JSnTWIRemoveDTInTemp(ptSeqno, ptPdtCode, ptPunCode, ptBarCode, ptQty) {

  ptXthDocNo = $("#oetXthDocNo").val();

  $.ajax({
    type: "POST",
    url: "dcmTBIRemovePdtInTemp",
    data: {
      tTBIDocType: tTBIDocType,
      ptXthDocNo: ptXthDocNo,
      ptSeqno: ptSeqno,
      ptPdtCode: ptPdtCode,
      ptPunCode: ptPunCode,
      ptBarCode: ptBarCode,
      ptQty: ptQty
    },
    cache: false,
    timeout: 5000,
    success: function (tResult) {

      console.log(tResult);

      JSvTBILoadPdtDataTableHtml();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });

}

function JSxTBINavDefult() {
  if (nStaTBIBrowseType != 1 || nStaTBIBrowseType == undefined) {
    $(".xCNTWIVBrowse").hide();
    $(".xCNTWIVMaster").show();
    $("#oliTWITitleAdd").hide();
    $("#oliTWITitleEdit").hide();
    $("#odvBtnAddEdit").hide();
    $(".obtChoose").hide();
    $("#odvBtnTWIInfo").show();
  } else {
    $("#odvModalBody .xCNTWIVMaster").hide();
    $("#odvModalBody .xCNTWIVBrowse").show();
    $("#odvModalBody #odvTWIMainMenu").removeClass("main-menu");
    $("#odvModalBody #oliTWINavBrowse").css("padding", "2px");
    $("#odvModalBody #odvTWIBtnGroup").css("padding", "0");
    $("#odvModalBody .xCNTWIBrowseLine").css("padding", "0px 0px");
    $("#odvModalBody .xCNTWIBrowseLine").css(
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

//Function : โหลด Html Vat มาแปะ ในหน้า Add
function JSvTBILoadVatTableHtml() {
  tXthDocNo = $("#oetXthDocNo").val();
  tXthVATInOrEx = $("#ostXthVATInOrEx").val();

  $.ajax({
    type: "POST",
    url: "dcmTBIVatTableLoadData",
    data: {
      tTBIDocType: tTBIDocType,
      tXthDocNo: tXthDocNo,
      tXthVATInOrEx: tXthVATInOrEx
    },
    cache: false,
    Timeout: 0,
    success: function (tResult) {
      $("#odvVatPanal").html(tResult);

      JSxSetCalculateLastBillSetText();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Function : ส่ง จำนวนเงิน ไปแปลเป็น ไทย
//Create : 28/02/2019 Krit(Copter)
function JSxSetCalculateLastBillSetText() {
  tXthDocNo = $("#oetXthDocNo").val();
  tXthVATInOrEx = $("#ostXthVATInOrEx").val();

  $.ajax({
    type: "POST",
    url: "dcmTBICalculateLastBill",
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
}

//Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
//Create : 2018-08-28 Krit(Copter)
function FSvPDTAddPdtIntoTableDT(pjPdtData) {

  console.log(pjPdtData);

  pnXphVATInOrEx = $("#ostXthVATInOrEx").val();

  JCNxOpenLoading();

  ptXthDocNo = $("#oetXthDocNo").val();
  ptBchCode = $("#oetBchCode").val();
  pnOptionAddPdt = $("#ocmTBIOptionAddPdt").val();

  $.ajax({
    type: "POST",
    url: "dcmTBIAddPdtIntoTableDT",
    data: {
      tTBIDocType: tTBIDocType,
      ptXthDocNo: ptXthDocNo,
      ptBchCode: ptBchCode,
      pnXphVATInOrEx: pnXphVATInOrEx,
      pnOptionAddPdt: pnOptionAddPdt,
      pjPdtData: pjPdtData
    },
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      console.log(tResult);

      JSvTBILoadPdtDataTableHtml();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
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

function JSnTWICancel(pbIsConfirm) {
  tXthDocNo = $("#oetXthDocNo").val();

  if (pbIsConfirm) {
    $.ajax({
      type: "POST",
      url: "dcmTBICancel",
      data: {
        tXthDocNo: tXthDocNo
      },
      cache: false,
      timeout: 5000,
      success: function (tResult) {
        $("#odvTBIPopupCancel").modal("hide");

        aResult = $.parseJSON(tResult);
        if (aResult.nSta == 1) {
          JSvCallPageTBIEdit(tXthDocNo);
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

    $("#odvTBIPopupCancel").modal("show");
  }
}

//Function : GET Scan BarCode
function JSvTWIScanPdtHTML() {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    tBarCode = $("#oetScanPdtHTML").val();
    tSplCode = $("#oetSplCode").val();

    if (tBarCode != "") {
      JCNxOpenLoading();

      $.ajax({
        type: "POST",
        url: "dcmTBIGetPdtBarCode",
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
            FSvPDTAddPdtIntoTableDT(tPdtCode, tPunCode);

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
  } else {
    JCNxShowMsgSessionExpired();
  }
}

function JSnTWIRemoveAllDTInFile() {
  ptXthDocNo = $("#oetXthDocNo").val();

  $.ajax({
    type: "POST",
    url: "dcmTBIRemoveAllPdtInFile",
    data: {
      ptXthDocNo: ptXthDocNo
    },
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      JSvTBILoadPdtDataTableHtml();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}



//Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
//Create : 2018-08-28 Krit(Copter)
function FSvTWIEditPdtIntoTableDT(ptEditSeqNo, paField, paValue) {
  JCNxOpenLoading();

  ptXthDocNo = $("#oetXthDocNo").val();

  $.ajax({
    type: "POST",
    url: "dcmTBIEditPdtIntoTableDT",
    data: {
      tTBIDocType: tTBIDocType,
      ptXthDocNo: ptXthDocNo,
      ptEditSeqNo: ptEditSeqNo,
      paField: paField,
      paValue: paValue
    },
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      console.log(tResult);

      JSvTBILoadPdtDataTableHtml();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

function FSvGetSelectShpByBch(ptBchCode) {
  $.ajax({
    type: "POST",
    url: "dcmTBIGetShpByBch",
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
function JSvCallPageTBIAdd() {

  $.ajax({
    type: "POST",
    url: "dcmTBIPageAdd",
    data: {
      tTBIDocType: tTBIDocType
    },
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      if (nStaTBIBrowseType == 1) {
        $(".xCNTWIVMaster").hide();
        $(".xCNTWIVBrowse").show();
      } else {
        $(".xCNTWIVBrowse").hide();
        $(".xCNTWIVMaster").show();
        $("#oliTWITitleEdit").hide();
        $("#oliTWITitleAdd").show();
        $("#odvBtnTWIInfo").hide();
        $("#odvBtnAddEdit").show();
        $("#obtTWIApprove").hide();
        $("#obtTWICancel").hide();
      }

      $("#odvContentPageTWI").html(tResult);

      // Control Object And Button ปิด เปิด
      JCNxTWIControlObjAndBtn();

      //Control Input
      $('#oetXthDocNo').attr('disabled', true);

      //Load Pdt Table
      JSvTBILoadPdtDataTableHtml();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
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

// //Functionality : (event) Add/Edit
// //Parameters : form
// //Creator : 02/07/2018 Krit(Copter)
// //Return : Status Add
// //Return Type : n
function JSnAddEditTBI(ptRoute) {
  $("#ofmAddTBI").validate({
    rules: {
      oetXthDocNo: "required",
      oetXthDocDate: "required",
      oetWahNameStart: "required",
      oetWahNameEnd: "required",
    },
    messages: {
      oetXthDocNo: $("#oetXthDocNo").data("validate"),
      oetXthDocDate: $("#oetXthDocDate").data("validate"),
      oetWahNameStart: $("#oetWahNameStart").data("validate"),
      oetWahNameEnd: $("#oetWahNameEnd").data("validate"),
    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      error.addClass("help-block");
      if (element.prop("type") === "checkbox") {
        error.appendTo(element.parent("label"));
      } else {
        var tCheck = $(element.closest(".form-group")).find(".help-block")
          .length;
        if (tCheck == 0) {
          error.appendTo(element.closest(".form-group")).trigger("change");
        }
      }
    },
    highlight: function (element, errorClass, validClass) {
      $(element)
        .closest(".form-group")
        .addClass("has-error")
        .removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element)
        .closest(".form-group")
        .addClass("has-success")
        .removeClass("has-error");
    },
    submitHandler: function (form) {
      $.ajax({
        type: "POST",
        url: ptRoute,
        data: $("#ofmAddTBI").serialize(),
        cache: false,
        timeout: 0,
        success: function (tResult) {
          console.log(tResult);

          if (nStaTBIBrowseType != 1) {
            var aReturn = JSON.parse(tResult);
            if (aReturn["nStaEvent"] == 1) {
              if (
                aReturn["nStaCallBack"] == "1" ||
                aReturn["nStaCallBack"] == null
              ) {
                JSvCallPageTBIEdit(aReturn["tCodeReturn"]);
              } else if (aReturn["nStaCallBack"] == "2") {
                JSvCallPageTBIAdd();
              } else if (aReturn["nStaCallBack"] == "3") {
                JSvCallPageTBIList();
              }
            } else {
              tMsgBody = aReturn["tStaMessg"];
              FSvCMNSetMsgWarningDialog(tMsgBody);
            }
          } else {
            JCNxBrowseData(tCallTBIBackOption);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
      });
    }
  });
}

function JSvCallPageTBIList() {
  $.ajax({
    type: "GET",
    url: "dcmTBIFormSearchList",
    data: {},
    cache: false,
    timeout: 5000,
    success: function (tResult) {
      $("#odvContentPageTWI").html(tResult);
      JSxTBINavDefult();

      JSvCallPagePdtTBIPdtDataTable(); //แสดงข้อมูลใน List
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

function JSvCallPagePdtTBIPdtDataTable(pnPage) {

  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    JCNxOpenLoading();
    var oAdvanceSearch = JSoTBIGetAdvanceSearchData();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == "") {
      nPageCurrent = "1";
    }

    $.ajax({
      type: "POST",
      url: "dcmTBIDataTable",
      data: {
        tTBIDocType: tTBIDocType,
        oAdvanceSearch: oAdvanceSearch,
        nPageCurrent: nPageCurrent
      },
      cache: false,
      timeout: 5000,
      success: function (tResult) {
        $("#odvContentPurchaseorder").html(tResult);

        JSxTBINavDefult();
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

//Functionality : Call Credit Page Edit
//Parameters : -
//Creator : 04/07/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvCallPageTBIEdit(ptXthDocNo) {
  JCNxOpenLoading();

  JStCMMGetPanalLangSystemHTML("JSvCallPageTBIEdit", ptXthDocNo);

  $.ajax({
    type: "POST",
    url: "dcmTBIPageEdit",
    data: {
      tTBIDocType: tTBIDocType,
      ptXthDocNo: ptXthDocNo
    },
    cache: false,
    timeout: 0,
    success: function (tResult) {
      if (tResult != "") {
        $("#oliTWITitleAdd").hide();
        $("#oliTWITitleEdit").show();
        $("#odvBtnTWIInfo").hide();
        $("#odvBtnAddEdit").show();
        $("#odvContentPageTWI").html(tResult);
        $("#oetXthDocNo").addClass("xCNDisable");
        $(".xCNDisable").attr("readonly", true);
        $(".xCNiConGen").hide();
        $("#obtTWIApprove").show();
        $("#obtTWICancel").show();
      }


      //Function Load Table Pdt ของ TWI
      JSvTBILoadPdtDataTableHtml();

      ohdXthVATInOrEx = $("#ohdXthVATInOrEx").val();
      $("#ostXthVATInOrEx option[value='" + ohdXthVATInOrEx + "']").attr("selected", true).trigger("change");

      // Control Object And Button ปิด เปิด
      JCNxTWIControlObjAndBtn();

      JCNxLayoutControll();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Function : Control Object And Button ปิด เปิด
function JCNxTWIControlObjAndBtn() {
  //Check สถานะอนุมัติ
  ohdXthStaApv = $("#ohdXthStaApv").val();
  ohdXthStaDoc = $("#ohdXthStaDoc").val();

  /* ตัวเลือกในการเพิ่มรายการสินค้าจากเมนูสแกนสินค้าในหน้าเอกสาร * กรณีเพิ่มสินค้าเดิม */
  nOptScanSku = $('#ohdOptScanSku').val();
  $("#ocmTBIOptionAddPdt option[value='" + nOptScanSku + "']").attr("selected", true).trigger("change");

  //Set Default
  //Btn Cancel
  $("#obtTWICancel").attr("disabled", false);
  //Btn Apv
  $("#obtTWIApprove").attr("disabled", false);

  // $(".form-control").attr("disabled", false);
  // $(".ocbListItem").attr("disabled", false);
  // $(".xCNBtnBrowseAddOn").attr("disabled", false);
  // $(".xCNBtnDateTime").attr("disabled", false);
  // $(".xCNDocBrowsePdt").attr("disabled", false).removeClass("xCNBrowsePdtdisabled");
  // $(".xCNDocDrpDwn").show();
  // $("#oetSearchPdtHTML").attr("disabled", false);
  $(".xWBtnGrpSaveLeft").attr("disabled", false);
  $(".xWBtnGrpSaveRight").attr("disabled", false);
  // $("#oliBtnEditShipAdd").show();
  // $("#oliBtnEditTaxAdd").show();

  console.log("Function : JCNxTWIControlObjAndBtn => " + ohdXthStaApv + " : " + ohdXthStaDoc);


  if (ohdXthStaApv == 1 || ohdXthStaApv == 2) {
    //Btn Apv
    $("#obtTWIApprove").attr("disabled", true);
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
    $(".xWBtnGrpSaveLeft").attr("disabled", true);
    $(".xWBtnGrpSaveRight").attr("disabled", true);
    $("#oliBtnEditShipAdd").hide();
    $("#oliBtnEditTaxAdd").hide();
  }

  //Check สถานะเอกสาร
  if (ohdXthStaDoc == 3) {
    //Btn Cancel
    $("#obtTWICancel").attr("disabled", true);
    //Btn Apv
    $("#obtTWIApprove").attr("disabled", true);
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
    $(".xWBtnGrpSaveLeft").attr("disabled", true);
    $(".xWBtnGrpSaveRight").attr("disabled", true);
    $("#oliBtnEditShipAdd").hide();
    $("#oliBtnEditTaxAdd").hide();
  }

  // //Control ปุ่ม Browse Shop
  // tBrwBchCode = $("#oetBchCode").val();
  // if (tBrwBchCode == "") {
  //   /* Control ปุ่ม Browse ร้านค้า*/
  //   /* จาก */
  //   $("#oetShpCode").val("");
  //   $("#oetShpName").val("");
  //   $("#obtTBIBrowseShp").attr("disabled", true);
  //   /* ถึง */
  //   $("#oetShpCodeTo").val("");
  //   $("#oetShpNameTo").val("");
  //   $("#obtTBIBrowseShpTo").attr("disabled", true);
  //   /* Control ปุ่ม Browse ร้านค้า*/

  //   /* Control ปุ่ม Browse เครื่องจุดขาย*/
  //   /* จาก */
  //   $("#oetPosCodeFrom").val("");
  //   $("#oetPosNameFrom").val("");
  //   $("#obtTBIBrowsePosFrom").attr("disabled", true);
  //   /* ถึง */
  //   $("#oetPosCodeTo").val("");
  //   $("#oetPosNameTo").val("");
  //   $("#obtTBIBrowsePosTo").attr("disabled", true);
  //   /* Control ปุ่ม Browse เครื่องจุดขาย*/

  //   /* Control ปุ่ม Browse โอนจากคลัง*/
  //   /* จาก */
  //   $("#ohdWahCodeFrom").val("");
  //   $("#oetWahNameFrom").val("");
  //   $("#obtTBIBrowseWahFrom").attr("disabled", true);
  //   /* ถึง */
  //   $("#ohdWahCodeTo").val("");
  //   $("#oetWahNameTo").val("");
  //   $("#obtTBIBrowseWahTo").attr("disabled", true);
  //   /* Control ปุ่ม Browse โอนจากคลัง*/
  // } else {
  //   /* Control ปุ่ม Browse ร้านค้า*/
  //   $("#obtTBIBrowseShp").attr("disabled", false);
  //   $("#obtTBIBrowseShpTo").attr("disabled", false);
  //   /* Control ปุ่ม Browse ร้านค้า*/

  //   /* Control ปุ่ม Browse เครื่องจุดขาย*/
  //   $("#obtTBIBrowsePosFrom").attr("disabled", false);
  //   $("#obtTBIBrowsePosTo").attr("disabled", false);
  //   /* Control ปุ่ม Browse เครื่องจุดขาย*/

  //   /* Control ปุ่ม Browse โอนจากคลัง*/
  //   $("#obtTBIBrowseWahFrom").attr("disabled", false);
  //   $("#obtTBIBrowseWahTo").attr("disabled", false);
  //   /* Control ปุ่ม Browse โอนจากคลัง*/
  // }

}

// //Functionality : (event) Delete
// //Parameters : tIDCode รหัส
// //Creator : 03/07/2018 Krit(Copter)
// //Return :
//Return Type : Status Number
function JSnTWIDel(tCurrentPage, tIDCode) {
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
        url: "dcmTBIEventDelete",
        data: {
          tTBIDocType: tTBIDocType,
          tIDCode: tIDCode
        },
        cache: false,
        success: function (tResult) {
          var aReturn = JSON.parse(tResult);

          if (aReturn["nStaEvent"] == 1) {
            $("#odvModalDel").modal("hide");
            $("#ospConfirmDelete").text("ยืนยันการลบข้อมูลของ : ");
            $("#ohdConfirmIDDelete").val("");
            localStorage.removeItem("LocalItemData");
            setTimeout(function () {
              JSvClickPage(tCurrentPage);
            }, 500);
          } else {
            alert(aReturn["tStaMessg"]);
          }
          JSxTBINavDefult();
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
function JSoTBIDelChoose() {
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
      url: "dcmTBIEventDelete",
      data: {
        tTBIDocType: tTBIDocType,
        tIDCode: aNewIdDelete
      },
      success: function (tResult) {
        var aReturn = JSON.parse(tResult);
        if (aReturn["nStaEvent"] == 1) {
          setTimeout(function () {
            $("#odvModalDel").modal("hide");
            JSvCallPagePdtTBIPdtDataTable();
            $("#ospConfirmDelete").text("ยืนยันการลบข้อมูลของ : ");
            $("#ohdConfirmIDDelete").val("");
            localStorage.removeItem("LocalItemData");
            $(".modal-backdrop").remove();
          }, 1000);
        } else {
          alert(aReturn["tStaMessg"]);
        }
        JSxTBINavDefult();
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
function JSoTBIPdtDelChoose(pnPage) {

  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    var tDocNo = $("#oetXthDocNo").val();
    var aSeq = $("#ohdConfirmSeqDelete").val();
    var aPdt = $("#ohdConfirmPdtDelete").val();
    var aPun = $("#ohdConfirmPunDelete").val();
    var aBar = $("#ohdConfirmBarDelete").val();

    //Seq
    var aTextSeq = aSeq.substring(0, aSeq.length - 2);
    var aSeqSplit = aTextSeq.split(" , ");
    var aSeqSplitlength = aSeqSplit.length;
    var aSeqData = [];
    for ($i = 0; $i < aSeqSplitlength; $i++) {
      aSeqData.push(aSeqSplit[$i]);
    }

    //Pdt
    var aTextPdt = aPdt.substring(0, aPdt.length - 2);
    var aPdtSplit = aTextPdt.split(" , ");
    var aPdtSplitlength = aPdtSplit.length;
    var aPdtData = [];
    for ($i = 0; $i < aPdtSplitlength; $i++) {
      aPdtData.push(aPdtSplit[$i]);
    }

    //Pun
    var aTextPun = aPun.substring(0, aPun.length - 2);
    var aPunSplit = aTextPun.split(" , ");
    var aPunSplitlength = aPunSplit.length;
    var aPunData = [];
    for ($i = 0; $i < aPunSplitlength; $i++) {
      aPunData.push(aPunSplit[$i]);
    }

    //Bar
    var aTextBar = aBar.substring(0, aBar.length - 2);
    var aBarSplit = aTextBar.split(" , ");
    var aBarSplitlength = aBarSplit.length;
    var aBarData = [];
    for ($i = 0; $i < aBarSplitlength; $i++) {
      aBarData.push(aBarSplit[$i]);
    }

    console.log(aSeqData)
    console.log(aPdtData)
    console.log(aPunData)
    console.log(aBarData);

    if (aSeqSplitlength > 1) {
      // JCNxOpenLoading();
      localStorage.StaDeleteArray = "1";
      $.ajax({
        type: "POST",
        // dcmTBIEventDelete
        url: "dcmTBIPdtMultiDeleteEvent",
        data: {
          tTBIDocType: tTBIDocType,
          tDocNo: tDocNo,
          aSeqData: aSeqData,
          aPdtData: aPdtData,
          aPunData: aPunData,
          aBarData: aBarData,

        },
        success: function (tResult) {
          console.log(tResult);
          setTimeout(function () {
            $("#odvModalDelPdtTBI").modal("hide");
            JSvTBILoadPdtDataTableHtml();
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
function JSvClickPage(ptPage) {
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
  JSvCallPagePdtTBIPdtDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 15/05/2018
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
//Creator: 13/05/2019 Napat(Jame)
//Return: -
//Return Type: -
function JSxTBIPdtTextinModal() {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {

    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    console.log(aArrayConvert);
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
    } else {

      var tTextSeq = "";
      var tTextPdt = "";
      var tTextDoc = "";
      var tTextPun = "";
      var tTextBar = "";

      for ($i = 0; $i < aArrayConvert[0].length; $i++) {

        tTextSeq += aArrayConvert[0][$i].tSeq;
        tTextSeq += " , ";

        tTextPdt += aArrayConvert[0][$i].tPdt;
        tTextPdt += " , ";

        tTextDoc += aArrayConvert[0][$i].tDoc;
        tTextDoc += " , ";

        tTextPun += aArrayConvert[0][$i].tPun;
        tTextPun += " , ";

        tTextBar += aArrayConvert[0][$i].tBar;
        tTextBar += " , ";

      }

      $("#ospConfirmDelete").text($("#oetTextComfirmDeleteMulti").val());

      $("#ohdConfirmDocDelete").val(tTextDoc);
      $("#ohdConfirmSeqDelete").val(tTextSeq);
      $("#ohdConfirmPdtDelete").val(tTextPdt);
      $("#ohdConfirmPunDelete").val(tTextPun);
      $("#ohdConfirmBarDelete").val(tTextBar);

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


// Advance Table
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Function : Gen  Html มาแปะ ในหน้า Add
function JSvTBILoadPdtDataTableHtml() {
  JCNxOpenLoading();

  tXthDocNo = $("#oetXthDocNo").val();
  tXthStaApv = $("#ohdXthStaApv").val();
  tXthStaDoc = $("#ohdXthStaDoc").val();
  ptXthVATInOrEx = $("#ostXthVATInOrEx").val();

  $.ajax({
    type: "POST",
    url: "dcmTBIPdtAdvanceTableLoadData",
    data: {
      tTBIDocType: tTBIDocType,
      tXthDocNo: tXthDocNo,
      tXthStaApv: tXthStaApv,
      tXthStaDoc: tXthStaDoc,
      ptXthVATInOrEx: ptXthVATInOrEx
    },
    cache: false,
    Timeout: 0,
    success: function (tResult) {
      $("#odvPdtTablePanal").html(tResult);

      JSvTBILoadVatTableHtml();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

function JSxOpenColumnFormSet() {
  $.ajax({
    type: "POST",
    url: "dcmTBIAdvanceTableShowColList",
    data: { tTBIDocType: tTBIDocType },
    cache: false,
    Timeout: 0,
    success: function (tResult) {
      $("#odvShowOrderColumn").modal({ show: true });
      $("#odvOderDetailShowColumn").html(tResult);
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
    url: "dcmTBIAdvanceTableShowColSave",
    data: {
      tTBIDocType: tTBIDocType,
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
      //Function Gen Table Pdt ของ TWI
      JSvTBILoadPdtDataTableHtml();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//ปรับ Value ใน Input หลัวจาก กรอก เสร็จ
function JSxTWIAdjInputFormat(ptInputID) {
  cVal = $("#" + ptInputID).val();
  cVal = accounting.toFixed(cVal, nOptDecimalShow);
  $("#" + ptInputID).val(cVal);
}
