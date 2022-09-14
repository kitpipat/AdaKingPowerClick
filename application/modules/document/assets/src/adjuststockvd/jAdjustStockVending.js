var nStaAdjStkSumBrowseType     = $("#oetADJVDStaBrowse").val();
var tCallAdjStkSumBackOption    = $("#oetADJVDCallBackOption").val();

$("document").ready(function () {
  localStorage.removeItem("LocalItemData");
  JSxCheckPinMenuClose(); 
  JSxADJVDNavDefult();
  JSvCallPageADJVDList();
});


function JSxADJVDNavDefult() {
    $(".xCNADJVDVMaster").show();
    $("#oliADJVDTitleAdd").hide();
    $("#oliADJVDTitleEdit").hide();
    $("#odvBtnAddEdit").hide();
    $(".obtChoose").hide();
    $("#odvBtnADJVDInfo").show();
    $("#oliPITitleDetail").hide();
}

//Call List
function JSvCallPageADJVDList() {
    $.ajax({
      type      : "GET",
      url       : "ADJSTKVDFormSearchList",
      data      : {},
      cache     : false,
      timeout   : 5000,
      success   : function (tResult) {
        $("#odvContentPageADJVD").html(tResult);
        JSxADJVDNavDefult();
        JSvCallPageADJVDPdtDataTable(); //แสดงข้อมูลใน List
      },
      error: function (jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
}

//Call page table
function JSvCallPageADJVDPdtDataTable(pnPage){
    JCNxOpenLoading();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    var oAdvanceSearch = JSoADJVDGetAdvanceSearchData();
    

  $.ajax({
    type    : "POST",
    url     : "ADJSTKVDDataTable",
    data    : {
      oAdvanceSearch    : oAdvanceSearch,
      nPageCurrent      : nPageCurrent
    },
    cache   : false,
    timeout : 5000,
    success : function (tResult) {
      $("#odvContentAdjustStockVD").html(tResult);

      JSxADJVDNavDefult();
      JCNxCloseLoading();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Get Filter Search
function JSoADJVDGetAdvanceSearchData() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            let oAdvanceSearchData = {
                tSearchAll            : $("#oetSearchAll").val(),
                tSearchBchCodeFrom    : $("#oetBchCodeFrom").val(),
                tSearchBchCodeTo      : $("#oetBchCodeTo").val(),
                tSearchDocDateFrom    : $("#oetSearchDocDateFrom").val(),
                tSearchDocDateTo      : $("#oetSearchDocDateTo").val(),
                tSearchStaDoc         : $("#ocmStaDoc").val(),
                tSearchStaApprove     : $("#ocmStaApprove").val(),
                tSearchStaPrcStk      : $("#ocmStaPrcStk").val(),
                tSearchStaAct         : $("#ocmStaDocAct").val()
            };
            return oAdvanceSearchData;
        } catch (err) {
            console.log("JSoADJVDGetAdvanceSearchData Error: ", err);
        }
    } else {
      JCNxShowMsgSessionExpired();
    }
}

//Call Page Add
function JSvCallPageADJVDAdd() {
    JCNxOpenLoading();
    $.ajax({
        type      : "POST",
        url       : "ADJSTKVDPageAdd",
        data      : {},
        cache     : false,
        timeout   : 5000,
        success   : function (tResult) {
            $("#odvContentPageADJVD").html(tResult);
            JSvADJVDLoadPdtDataTableHtml(1,'fisrtload');

            JSxControlPageEvent('pageadd');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//control page [มองเห็นปุ่ม]
function JSxControlPageEvent(ptPage){
    if(ptPage == 'pageadd'){
        $('#oliADJVDTitleAdd').show();
        $('#odvBtnADJVDInfo').hide();
        $('#odvBtnAddEdit').show();
        $('#obtADJVDCancel').hide();
        $('#obtADJVDApprove').hide();
        $('#obtADJVDSaveEdit').show();
        $('#oliADJVDTitleEdit').hide();
        $('#obtADJVDPrint').hide();
    }else if(ptPage == 'pageedit'){
        $('#oliADJVDTitleAdd').hide();
        $('#oliADJVDTitleEdit').show();
        $('#odvBtnADJVDInfo').hide();
        $('#odvBtnAddEdit').show();
        $('#obtADJVDCancel').show();
        $('#obtADJVDApprove').show();

        //เข้ามาแบบเเก้ไข แต่เอกสารถูกยกเลิก
        if($('#ohdXthStaDoc').val() == 3 || $('#ohdXthStaApv').val() == 1){
          $('#odvBtnAddEdit').show();
          $('#obtADJVDSaveEdit').hide();
          $('#obtADJVDCancel').hide();
          $('#obtADJVDApprove').hide();
          $('#obtADJVDPrint').show();
        }else{
          $('#obtADJVDSaveEdit').show();
          $('#obtADJVDPrint').show();
        }
    }
}

//โหลดหน้าจอโครงของ temp
function JSvADJVDLoadPdtDataTableHtml(pnPage,ptEvent) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        tXthStaApv        = $("#ohdXthStaApv").val();
        tXthStaDoc        = $("#ohdXthStaDoc").val();
        ptXthVATInOrEx    = $("#ostXthVATInOrEx").val();

        nPageCurrent = pnPage;

        var oInfor = {
            tBchCode            : $("#oetBchCode").val(),
            tShpCodeStart       : $("#oetShpCodeStart").val(),
            tPosCodeStart       : $("#oetPosCodeStart").val(),
            tWahCodeStart       : $("#ohdWahCodeStart").val(),
            tXthDocNo           : $("#oetXthDocNo").val(),
            tRoute              : $("#ohdADJVDRoute").val(),
            nPageCurrent        : nPageCurrent,
            tEvent              : ptEvent
        };

        $.ajax({
            type    : "POST",
            url     : "ADJSTKVDPdtDtLoadToTem",
            data    : oInfor,
            cache   : false,
            Timeout : 0,
            success : function (tResult) {
                // console.log(tResult);
                JSxLoadPdtDtFromTem(nPageCurrent);
                $(window).scrollTop(0);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//โหลดข้อมูลจาก temp
function JSxLoadPdtDtFromTem(nPageCurrent){
    var oInfor = {
        tBchCode            : $("#oetBchCode").val(),
        tShpCodeStart       : $("#oetShpCodeStart").val(),
        tPosCodeStart       : $("#oetPosCodeStart").val(),
        tWahCodeStart       : $("#ohdWahCodeStart").val(),
        tXthDocNo           : $("#oetXthDocNo").val(),
        tRoute              : $("#ohdADJVDRoute").val(),
        nPageCurrent        : nPageCurrent
    };

    $.ajax({
      type      : "POST",
      url       : "ADJSTKVDPdtAdvanceTableLoadData",
      data      : oInfor,
      cache     : false,
      Timeout   : 0,
      success   : function (tResult) {
        $("#odvContentPdtTableADJVDPanal").html(tResult);
        JCNxCloseLoading();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
}

//ค้นหาสินค้าใน temp
function JSvDOCSearchPdtHTML() {
    var value = $("#oetSearchPdtHTML").val().toLowerCase();
    $("#otbDOCPdtTable tbody tr ").filter(function () {
        tText = $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
}

//หน้าถัดไป
function JSvADJVDClickPage(ptPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (nStaSession !== undefined && nStaSession == 1) {
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
        JCNxOpenLoading();
        JSvCallPageADJVDPdtDataTable(nPageCurrent);
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//กดบันทึก แต่ต้อง validate ก่อน
function JSxAddEditADJVD(){

  //กรุณากรอกข้อมูลให้ครบถ้วน
  if($('#ohdWahCodeStart').val() == '' || $('#ohdWahCodeStart').val() == null){
    FSvCMNSetMsgErrorDialog('กรุณากรอกข้อมูลให้ครบถ้วน');
  }

  $('#ofmAddADJVD').validate().destroy();
  $('#ofmAddADJVD').validate({
      focusInvalid  : false,
      onclick       : false,
      onfocusout    : false,
      onkeyup       : false,
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
        oetXthDocDate   : { "required": true },
        oetXthDocTime   : { "required": true },
        oetWahNameStart : { "required": true },
      },
      messages: {
        oetXthDocNo: {
          "required": $('#oetXthDocNo').attr('data-validate')
        },
        oetXthDocDate: {
          "required": $('#oetXthDocDate').attr('data-validate')
        },
        oetXthDocTime: {
          "required": $('#oetXthDocTime').attr('data-validate')
        },
        oetWahNameStart: {
          "required": $('#oetWahNameStart').attr('data-validate')
        },
      },
      errorElement    : "em",
      errorPlacement  : function (error, element) {
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
      submitHandler: function (form) {
        JSxSubmitEventByButton();
      }
  });
}

//กดบันทึกข้อมูล
function JSxSubmitEventByButton() {

  //กรุณากรอกข้อมูลให้ครบถ้วน
  if($('#oetASTRsnName').val() == '' || $('#oetASTRsnName').val() == null){
    $('#odvADJVDReasonIsNull').modal('show');
    $('#oetASTRsnName').focus();
    return;
  }

  //เช็คใน Temp ก่อนมีไหม
  $.ajax({
    type    : "POST",
    url     : "ADJSTKVDCheckPdtInTmp",
    data    : { tDocNo : $('#oetXthDocNo').val() , tRoute : $('#ohdADJVDRoute').val()  },
    cache   : false,
    timeout : 0,
    success: function (tResult) {
      var bReturn = JSON.parse(tResult);
      if (bReturn) {
        $('#otbDOCPdtTable > tbody  > tr').each(function(index, tr) { 
            var nValue = $(tr).find('.xCNADJVDKeyQty').val();
            if(nValue == 0 || nValue == '0'){
              tCheckSave = false;
              return false;
            }else{
              tCheckSave = true; 
            }
        });

        if(tCheckSave == true){
          tSave = true;
        }else{
          $('#odvADJVDCheckItemHaveAdjZero').modal('show');
          tSave = false;
        }

        //ถ้าไม่มีการ adj 0 วิ่งไปฟังก์ save เลย + ถ้ากดยืนยัน
        $('.xCNConfrimCheckItemHaveAdjZero').off();
        $('.xCNConfrimCheckItemHaveAdjZero').on('click', function(event){
          JSxADJVDSave(true);
        });

        //ถ้าไม่มีการ adj 0 วิ่งไปฟังก์ save เลย + ถ้ากดยืนยัน
        JSxADJVDSave(tSave);
      } else {
        FSvCMNSetMsgWarningDialog("<p>โปรดระบุสินค้าที่ท่านต้องการตรวจนับ</p>");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//ฟังก์ชั่นบันทึกข้อมูล
function JSxADJVDSave(pbOption){
  if(pbOption == true){
      //บันทึกลงฐานข้อมูล
      $.ajax({
        type    : "POST",
        url     : $("#ohdADJVDRoute").val(),
        data    : $("#ofmAddADJVD").serialize(),
        cache   : false,
        timeout : 0,
        success : function (tResult) {
            //ล้างค่า
            pbOption = false;
            $('#odvADJVDCheckItemHaveAdjZero').modal('hide');
            var oResult = JSON.parse(tResult);
            if (oResult["nStaEvent"] == "900") {
              FSvCMNSetMsgWarningDialog(oResult["tStaMessg"]);
            }else if(oResult["nStaEvent"] == "80"){
              FSvCMNSetMsgWarningDialog(oResult["tStaMessg"]);
            }else{
              if (oResult["nStaCallBack"] == "1" || oResult["nStaCallBack"] == null){
                JSvCallPageADJVDEdit(oResult["tCodeReturn"]);
              } else if (oResult["nStaCallBack"] == "2") {
                JSvCallPageADJVDAdd();
              } else if (oResult["nStaCallBack"] == "3") {
                JSvCallPageADJVDList();
              }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
      });
  }
}


//เข้าหน้าแก้ไข
function JSvCallPageADJVDEdit(ptDocumentNumber) {
  JCNxOpenLoading();
  $.ajax({
    type    : "POST",
    url     : "ADJSTKVDPageEdit",
    data    : { 
      ptDocumentNumber  : ptDocumentNumber
    },
    cache   : false,
    timeout : 0,
    success : function (tResult) {
      $("#odvContentPageADJVD").html(tResult);
      JSvADJVDLoadPdtDataTableHtml(1);

      JSxControlPageEvent('pageedit');
		},
    error: function (jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//กดยกเลิกเอกสาร
function JSxADJVDCancel(pbIsConfirm) {
  tDocumentNumber = $("#oetXthDocNo").val();
  if (pbIsConfirm) {
    $.ajax({
      type  : "POST",
      url   : "ADJSTKVDCancel",
      data  : { tDocumentNumber : tDocumentNumber },
      cache   : false,
      timeout : 5000,
      success : function (tResult) {
        $("#odvADJVDPopupCancel").modal("hide");
        JSvCallPageADJVDEdit(tDocumentNumber);
        JCNxCloseLoading();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    $("#odvADJVDPopupCancel").modal("show");
  }
}

//ลบเอกสาร
function JSnADJVDDel(tCurrentPage, tIDCode) {
  var aData             = $("#ohdConfirmIDDelete").val();
  var aTexts            = aData.substring(0, aData.length - 2);
  var aDataSplit        = aTexts.split(" , ");
  var aDataSplitlength  = aDataSplit.length;

  if (aDataSplitlength == "1") {
      $("#odvModalDel").modal("show");
      $("#ospConfirmDelete").html("ยืนยันการลบข้อมูล หมายเลข : " + tIDCode);
      $("#osmConfirm").on("click", function (evt) {
        JCNxOpenLoading();
        $.ajax({
          type  : "POST",
          url   : "ADJSTKVDEventDelete",
          data  : { tIDCode: tIDCode },
          cache : false,
          success: function (tResult) {
            $("#odvModalDel").modal("hide");
            
            setTimeout(function(){ 
              JSvCallPageADJVDPdtDataTable(tCurrentPage);
            }, 1000);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
        });
      });
  }
}

//อนุมัติเอกสาร
function JSxADJVDApprove(pbIsConfirm) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
      if (pbIsConfirm) {
        $("#odvADJVDPopupApv").modal("hide");

        var tDocumentNumber = $("#oetXthDocNo").val();
        $.ajax({
          type    : "POST",
          url     : "ADJSTKVDApprove",
          data    : { tDocumentNumber: tDocumentNumber },
          cache   : false,
          timeout : 0,
          success : function (tResult) {
            tResult = tResult.replace("\r\n","");
            var oResult = JSON.parse(tResult);
            if (oResult["nStaEvent"] == "900") {
              FSvCMNSetMsgErrorDialog(oResult["tStaMessg"]);
            }else{
              JSoADJVDSubscribeMQ();
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
        });
      } else {
        $("#odvADJVDPopupApv").modal("show");
      }
  } else {
    JCNxShowMsgSessionExpired();
  }
}

//MQ หลังจากอนุมัติเเล้วขึ้น progress
function JSoADJVDSubscribeMQ() {
  //RabbitMQ
  // Document variable
  var tLangCode   = $("#ohdLangEdit").val();
  var tUsrBchCode = $("#ohdBchCode").val();
  var tUsrApv     = $("#oetXthApvCodeUsrLogin").val();
  var tDocNo      = $("#oetXthDocNo").val();
  var tPrefix     = "RESAJS";
  var tStaApv     = $("#ohdXthStaApv").val();
  var tStaDelMQ   = $("#ohdXthStaDelMQ").val();
  var tQName      = tPrefix + "_" + tDocNo + "_" + tUsrApv;

  // MQ Message Config
  var poDocConfig = {
    tLangCode     : tLangCode,
    tUsrBchCode   : tUsrBchCode,
    tUsrApv       : tUsrApv,
    tDocNo        : tDocNo,
    tPrefix       : tPrefix,
    tStaDelMQ     : tStaDelMQ,
    tStaApv       : tStaApv,
    tQName        : tQName
  };
  // RabbitMQ STOMP Config
  var poMqConfig = {
    host      : "ws://"+oSTOMMQConfig.host+":15674/ws",
    username  : oSTOMMQConfig.user,
    password  : oSTOMMQConfig.password,
    vHost     : oSTOMMQConfig.vhost
  };

  // Update Status For Delete Qname Parameter
  var poUpdateStaDelQnameParams = {
    ptDocTableName      : "TCNTPdtAdjStkHD",
    ptDocFieldDocNo     : "FTAjhDocNo",
    ptDocFieldStaApv    : "FTAjhStaPrcStk",
    ptDocFieldStaDelMQ  : "FTAjhStaDelMQ",
    ptDocStaDelMQ       : tStaDelMQ,
    ptDocNo             : tDocNo
  };

  // Callback Page Control(function)
  var poCallback = {
    tCallPageEdit       : "JSvCallPageADJVDEdit",
    tCallPageList       : "JSvCallPageADJVDList"
  };

  //Check Show Progress %
  FSxCMNRabbitMQMessage(
    poDocConfig,
    poMqConfig,
    poUpdateStaDelQnameParams,
    poCallback
  );
}

//ลบข้อมูลหลายตัว
function JSxTextinModal() {
  var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
  if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
      var tTextCode = '';
      for ($i = 0; $i < aArrayConvert[0].length; $i++) {
          tTextCode += aArrayConvert[0][$i].nCode;
          tTextCode += ' , ';
      }
      $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
      $('#ohdConfirmIDDelete').val(tTextCode);
  }
}

//ลบข้อมูลหลายตัว
function JSxShowButtonChoose() {
  var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
  if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
      $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
  } else {
      nNumOfArr = aArrayConvert[0].length;
      if (nNumOfArr > 1) {
          $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
      } else {
          $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
      }
  }
}

//ลบข้อมูลหลายตัว
function findObjectByKey(array, key, value) {
  for (var i = 0; i < array.length; i++) {
      if (array[i][key] === value) {
          return 'Dupilcate';
      }
  }
  return 'None';
}

function JSxADJVDDelChoose() {
  JCNxOpenLoading();
  var aData             = $("#ohdConfirmIDDelete").val();
  var aTexts            = aData.substring(0, aData.length - 2);
  var aDataSplit        = aTexts.split(",");
  var aDataSplitlength  = aDataSplit.length;
  var aNewIdDelete      = [];
  for ($i = 0; $i < aDataSplitlength; $i++) {
    aNewIdDelete.push(aDataSplit[$i].trim());
  }

  if (aDataSplitlength > 1) {
    $.ajax({
      type    : "POST",
      url     : "ADJSTKVDEventDelete",
      data    : { tIDCode : aNewIdDelete },
      success: function (tResult) {
        var aReturn = JSON.parse(tResult);
        if (aReturn["nStaEvent"] == 1) {
          setTimeout(function () {
            $("#odvModalDel").modal("hide");
            JSvCallPageADJVDPdtDataTable();
            $("#ohdConfirmIDDelete").val("");
            localStorage.removeItem("LocalItemData");
          }, 1000);
        } else {
          alert(aReturn["tStaMessg"]);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    return false;
  }
}
