var nStaShpBrowseType = $("#oetShpStaBrowse").val();
var tCallShpBackOption = $("#oetShpCallBackOption").val();

$("ducument").ready(function() {
  JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
  JSxSHPNavDefult();

  if (nStaShpBrowseType != 1) {
    JSvCallPageShopList();
  } else {
    JSvSHPAddPage();
  }
});

// Function : Function Clear Defult Button District
// Parameters : -
// Creator : 15/05/2018 Krit(Copter)
// Return : -
// Return Type : -
function JSxSHPNavDefult() {
  if (nStaShpBrowseType != 1 || tCallShpBackOption == undefined) {
    //Remove POSSHOP Title And Button
    $(".xWPshBtn").remove();
    $(".xWPshTitle").remove();
    $(".xWPshTitleAdd").remove();
    $(".xWPshTitleEdit").remove();

    $(".xWShopGpBtn").remove();
    $(".xWShopGpTitle").remove();
    $(".xWShopGpTitleAdd").remove();

    $("#oliShpTitleAdd").hide();
    $("#oliShpTitleEdit").hide();
    $("#odvBtnAddEdit").hide();
    $("#odvBtnAddEditPDT").hide();
    $("#odvBtnShpInfo").show();
    $(".obtChoose").hide();
  } else {
    $("#odvShpMainMenu").removeClass("main-menu");
    $("#oliShpNavBrowse").css("padding", "2px");
    $("#odvShpBtnGroup").css("padding", "0");
    $(".xCNShpBrowseLine").css("padding", "0px 0px");
    $(".xCNShpBrowseLine").css("border-bottom", "1px solid #e3e3e3");
  }
}

// Function : Call District Page list
// Parameters : -
// Creator :	15/05/2018 wasin(Yoshi)
// Last Update:	15/01/2019 wasin(Yoshi)
// Return : View
// Return Type : View
function JSvCallPageShopList(pnPage) {
  $("#odvBtnGrpShop").show();

  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    /* เก็บ Function ไว้ ตอนเปลี่ยนภาษา Edit*/
    localStorage.tStaPageNow = "JSvCallPageShopList";
    $("#oetSearchAll").val("");
    $.ajax({
      type: "POST",
      url: "shopList",
      cache: false,
      timeout: 0,
      success: function(tResult) {
        $("#odvBtnPdtInfo").hide();
        $("#odvContentPageShop").html(tResult);
        JSxSHPNavDefult();
        JSvShopDataTable(pnPage);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// Function : Call Recive Data List
// Parameters : Ajax Success Event
// Creator:	17/06/2018 Krit(Copter)
// Last Update:	15/01/2019 wasin(Yoshi)
// Return : View
// Return Type : View
function JSvShopDataTable(pnPage) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    var tSearchAll = $("#oetSearchAll").val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == "") {
      nPageCurrent = "1";
    }
    JCNxOpenLoading();
    $.ajax({
      type: "POST",
      url: "shopDataTable",
      data: {
        tSearchAll: tSearchAll,
        nPageCurrent: nPageCurrent
      },
      cache: false,
      Timeout: 0,
      success: function(tResult) {
        if (tResult != "") {
          $("#ostDataShop").html(tResult);
        }
        JSxSHPNavDefult();
        JCNxLayoutControll();
        JStCMMGetPanalLangHTML("TCNMShop_L"); //โหลดภาษาใหม่
        JCNxCloseLoading();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// Functionality: Search District List
// Parameters: tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
// Creator: 15/05/2018 wasin(Yoshi)
// Last Update:	15/01/2019 wasin(Yoshi)
// Return: Views
// Return Type: View
function JSvSearchAllShop() {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    var tSearchAll = $("#oetSearchAll").val();
    JCNxOpenLoading();
    $.ajax({
      type: "POST",
      url: "shopDataTable",
      data: {
        tSearchAll: tSearchAll,
        nPageCurrent: 1
      },
      cache: false,
      Timeout: 0,
      success: function(tResult) {
        if (tResult != "") {
          $("#ostDataShop").html(tResult);
        }
        JSxSHPNavDefult();
        JCNxLayoutControll();
        JStCMMGetPanalLangHTML("TCNMShop_L"); //โหลดภาษาใหม่
        JCNxCloseLoading();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// Functionality : (event) Add/Edit Shop
// Parameters : form
// Creator : 03/04/2018 Krit(Copter)
// Last Update:	15/01/2019 wasin(Yoshi)
// Return : Status Add
// Return Type : n
function JSnAddEditShop(tRouteEvent, StaPage) {
  // alert(tRouteEvent);
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    $("#ofmAddShop")
      .validate()
      .destroy();

    $.validator.addMethod(
      "dublicateCode",
      function(value, element) {
        if (tRouteEvent == "shopEventAdd") {
          if ($("#ohdCheckDuplicateShpCode").val() == 1) {
            return false;
          } else {
            return true;
          }
        } else {
          return true;
        }
      },
      ""
    );

    $("#ofmAddShop").validate({
      rules: {
        oetShpCode: {
          required: {
            depends: function(oElement) {
              if (tRouteEvent == "shopEventAdd") {
                if ($("#ocbShopAutoGenCode").is(":checked")) {
                  return false;
                } else {
                  return true;
                }
              } else {
                return true;
              }
            }
          },
          dublicateCode: {}
        },
        oetShpName: { required: {} },
        oetShpBchName: { required: {} },
        oetWahName: { required: {} },
        oetShpMerName: { required: {} }
      },
      messages: {
        oetShpCode: {
          required: $("#oetShpCode").attr("data-validate-required"),
          dublicateCode: $("#oetShpCode").attr("data-validate-dublicateCode")
        },
        oetShpName: {
          required: $("#oetShpName").attr("data-validate-required")
        },
        oetShpBchName: {
          required: $("#oetShpBchName").attr("data-validate-required")
        },
        oetWahName: {
          required: $("#oetWahName").attr("data-validate-required")
        },
        oetShpMerName: {
          required: $("#oetShpMerName").attr("data-validate-required")
        }
      },
      errorElement: "em",
      errorPlacement: function(error, element) {
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
      highlight: function(element, errorClass, validClass) {
        $(element)
          .closest(".form-group")
          .addClass("has-error")
          .removeClass("has-success");
      },
      unhighlight: function(element, errorClass, validClass) {
        var nStaCheckValid = $(element)
          .parents(".form-group")
          .find(".help-block").length;
        if (nStaCheckValid != 0) {
          $(element)
            .closest(".form-group")
            .addClass("has-success")
            .removeClass("has-error");
        }
      },
      submitHandler: function(form) {
        JCNxOpenLoading();
        $.ajax({
          type: "POST",
          url: tRouteEvent,
          data: $("#ofmAddShop").serialize(),
          timeout: 0,
          success: function(tResult) {
              // console.log(tResult);
            if (nStaShpBrowseType != 1) {
              var aReturnData = JSON.parse(tResult);
              if (aReturnData["nStaEvent"] == 1) {
                switch (aReturnData["nStaCallBack"]) {
                  case "1":
                    JSvSHPEditPage(
                      aReturnData["tBchCodeReturn"],
                      aReturnData["tShopCodeReturn"]
                    );
                    break;
                  case "2":
                    JSvSHPAddPage(tBchCode);
                    break;
                  case "3":
                    JSvCallPageShopList();
                    break;
                  default:
                    JSvSHPEditPage(
                      aReturnData["tBchCodeReturn"],
                      aReturnData["tShopCodeReturn"]
                    );
                }
              } else {
                var tMsgErrReturn = aReturnData["tStaMessg"];
                FSvCMNSetMsgErrorDialog(tMsgErrReturn);
              }
            } else {
              JCNxBrowseData(tCallPdtBackOption);
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
        });
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// Functionality : Shop Add Page
// Parameters : form
// Creator : 03/04/2018 Krit(Copter)
// Last Update:	15/01/2019 wasin(Yoshi)
// Return : Status Add
// Return Type : n
function JSvSHPAddPage(ptBchCode) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML("", "");
    $.ajax({
      type: "POST",
      url: "shopPageAdd",
      data: {
        tBchCode: ptBchCode,
        tStaPage: "master"
      },
      cache: false,
      timeout: 0,
      success: function(tResult) {
        if (nStaShpBrowseType == 1) {
          $("#odvModalBodyBrowse").html(tResult);
          $("#odvModalBodyBrowse .panel-body").css("padding-top", "0");
        } else {
          $("#oliShpTitleAdd").show();
          $("#oliShpTitleEdit").hide();
          $("#odvBtnShpInfo").hide();
          $("#odvBtnAddEdit").show();
        }
        $("#odvContentPageShop").html(tResult);
        JCNxLayoutControll();
        JCNxCloseLoading();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// Functionality : Page Shop Add Page From Branch
// Parameters : form
// Creator : 03/04/2018 Krit(Copter)
// Last Update:	15/01/2019 wasin(Yoshi)
// Return : Status Add
// Return Type : n
function JSvSHPAddPageFromBch(ptBchCode) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    $("#obtBarAddShp").hide();
    $("#obtBarBackBch").hide();
    $(".obtChoose").hide();
    $("#oliBCHSHPEdit").hide();
    $("#obtBarSubmitShp").show();
    $("#obtBarBackShp").show();
    $("#oliBCHSHPAdd").show();
    JStCMMGetPanalLangSystemHTML("", "");
    $.ajax({
      type: "POST",
      url: "shopPageAdd",
      data: {
        tBchCode: ptBchCode,
        tStaPage: "branch"
      },
      cache: false,
      timeout: 0,
      success: function(tResult) {
        $("#odvContentPageBranch").html(tResult);

        $("#obtBarSubmitShp").show();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// Functionality : Edit Page Shop
// Parameters : form
// Creator : 03/04/2018 Krit(Copter)
// Last Update:	15/01/2019 wasin(Yoshi)
// Return : Status Add
// Return Type : n
function JSvSHPEditPage(ptBchCode, ptShpCode) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    JStCMMGetPanalLangSystemHTML("JSvSHPEditPage", ptBchCode + "," + ptShpCode);
    $.ajax({
      type: "POST",
      url: "shopPageEdit",
      data: {
        tBchCode: ptBchCode,
        tShpCode: ptShpCode,
        tStaPage: "master"
      },
      cache: false,
      timeout: 0,
      success: function(tResult) {
        //alert('success');
        $("#odvContentPageShop").html(tResult);
        $("#obtBarBackShp").show();
        $("#oliShpTitleAdd").hide();
        $("#oliShpTitleEdit").show();
        $("#odvBtnAddEdit").show();
        $("#odvBtnShpInfo").hide();
        $("#odvBtnPdtInfo").hide();

        ohdShpType = $("#ohdShpType").val();
        if(ohdShpType == 4){
          $("#ocmShpType").attr("disabled", true);
          $('#ocmShpType').selectpicker('refresh');
          $("#ocmShpType option[value='" + ohdShpType + "']")
          .attr("selected", true)
          .trigger("change");
        }else{
          $("#ocmShpType option[value='" + ohdShpType + "']")
          .attr("selected", true)
          .trigger("change");
        }

        ohdShpStaActive = $("#ohdShpStaActive").val();
        $("#ocmShpStaActive option[value='" + ohdShpStaActive + "']")
          .attr("selected", true)
          .trigger("change");

        ohdShpStaClose = $("#ohdShpStaClose").val();
        $("#ocmShpStaClose option[value='" + ohdShpStaClose + "']")
          .attr("selected", true)
          .trigger("change");

        //Disabled input
        $("#oetShpCode")
          .addClass("xCNCursorNotAlw")
          .attr("readonly", true);

        //Control Event Button
        if ($("#ohdShpAutStaEdit").val() == 0) {
          $("#obtBarSubmitShp").hide();
          $(".xCNUplodeImage").hide();
          $(".xCNIconBrowse").hide();
          $("select").prop("disabled", true);
          $("input").attr("disabled", true);
        } else {
          $("#obtBarSubmitShp").show();
          $(".xCNUplodeImage").show();
          $(".xCNIconBrowse").show();
          $("select").prop("disabled", false);
          $("input").attr("disabled", false);
        }

        JCNxLayoutControll();
        //Control Event Button
        JCNxCloseLoading();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// Functionality : Edit Page Shop From Brach
// Parameters : form
// Creator : 03/04/2018 Krit(Copter)
// Last Update:	15/01/2019 wasin(Yoshi)
// Return : Status Add
// Return Type : n
function JSvSHPEditPageFromBch(ptBchCode, ptShpCode) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    JStCMMGetPanalLangSystemHTML(
      "JSvSHPEditPageFromBch",
      ptBchCode + "," + ptShpCode
    );
    $.ajax({
      type: "POST",
      url: "shopPageEdit",
      data: {
        tBchCode: ptBchCode,
        tShpCode: ptShpCode,
        tStaPage: "branch"
      },
      cache: false,
      timeout: 0,
      success: function(tResult) {
        $("#odvContentPageBranch").html(tResult);

        $("#oliBCHSHPAdd").hide();
        $("#obtBarAddShp").hide();
        $("#obtBarBackBch").hide();
        $("#obtBarSubmitShp").show();
        $("#obtBarBackShp").show();
        $("#odvBtnShpInfoFromBch").show();
        $("#oliBCHSHPEdit").show();

        ohdShpType = $("#ohdShpType").val();
        $("#ocmShpType option[value='" + ohdShpType + "']")
          .attr("selected", true)
          .trigger("change");

        ohdShpStaActive = $("#ohdShpStaActive").val();
        $("#ocmShpStaActive option[value='" + ohdShpStaActive + "']")
          .attr("selected", true)
          .trigger("change");

        ohdShpStaClose = $("#ohdShpStaClose").val();
        $("#ocmShpStaClose option[value='" + ohdShpStaClose + "']")
          .attr("selected", true)
          .trigger("change");

        //Disabled input
        $("#oetShpCode")
          .addClass("xCNCursorNotAlw")
          .attr("readonly", true);

        //Control Event Button
        if ($("#ohdShpAutStaEdit").val() == 0) {
          $("#obtBarSubmitShp").hide();
          $(".xCNUplodeImage").hide();
          $(".xCNIconBrowse").hide();
          $("select").prop("disabled", true);
          $("input").attr("disabled", true);
        } else {
          $("#obtBarSubmitShp").show();
          $(".xCNUplodeImage").show();
          $(".xCNIconBrowse").show();
          $("select").prop("disabled", false);
          $("input").attr("disabled", false);
        }
        //Control Event Button
      },
      error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// Functionality : Call Page Branch Add Shop
// Parameters : function Parameters
// Creator : 03/04/2018 Krit(Copter)
// Last Update:	15/01/2019 wasin(Yoshi)
// Return : View
// Return Type : View
function JSvCallPageListShop(ptBchCode, pnPageCurrent) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    localStorage.tStaPageNow = "JSvCallPageListShop" + "," + ptBchCode;
    if (pnPageCurrent == "" || pnPageCurrent == undefined) {
      pnPageCurrent = "1";
    }
    JCNxOpenLoading();
    $("#odvBtnBchInfo").hide();
    $("#obtBarSubmitShp").hide();
    $("#obtBarBackShp").hide();
    $("#oliBCHSHPAdd").hide();
    $("#oliBCHSHP").show();
    $("#odvBtnShpInfo").show();
    $("#odvBtnShpInfoFromBch").show();
    $("#obtBarAddShp").show();
    $.ajax({
      type: "POST",
      url: "shopListFromBch",
      data: {
        tBchCode: ptBchCode,
        nPageCurrent: pnPageCurrent
      },
      cache: false,
      success: function(tResult) {
        $("#odvContentPageBranch").html(tResult);

        JSvBranchToShopDataTable();
      },
      timeout: 0,
      error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// Function : Call Branch Data List
// Parameters : Ajax Success Event
// Creator:	05/06/2018 Krit
// Last Update:	15/01/2019 wasin(Yoshi)
// Return : View
// Return Type : View
function JSvBranchToShopDataTable(pnPage) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    var tBchCode = $("#ohdBchCode").val();
    var tSearchAll = $("#oetShopSearch").val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == "") {
      nPageCurrent = "1";
    }
    JCNxOpenLoading();
    $.ajax({
      type: "POST",
      url: "branchToShopDataTable",
      data: {
        tBchCode: tBchCode,
        tSearchAll: tSearchAll,
        nPageCurrent: nPageCurrent
      },
      cache: false,
      Timeout: 0,
      success: function(tResult) {
        if (tResult != "") {
          $("#ostDataBranchShop").html(tResult);
        }
        // JSxBCHNavDefult();
        JCNxLayoutControll();
        JStCMMGetPanalLangHTML("TCNMShop_L"); //โหลดภาษาใหม่
        JCNxCloseLoading();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// Functionality : ค้นหา
// Parameters : tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
// Creator:	05/06/2018 Krit
// Last Update:	15/01/2019 wasin(Yoshi)
// Return : View
// Return Type : View
function JSvSearchAllBranchShop() {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    var tSearchAll = $("#oetSearchAll").val();
    $.ajax({
      type: "POST",
      url: "branchDataTable",
      data: {
        tSearchAll: tSearchAll,
        nPageCurrent: 1
      },
      cache: false,
      timeout: 0,
      success: function(tResult) {
        if (tResult != "") {
          $("#ostDataBranchShop").html(tResult);
        }
        JSxBCHNavDefult();
        JCNxLayoutControll();
        JStCMMGetPanalLangHTML("TCNMShop_L"); //โหลดภาษาใหม่
        JCNxCloseLoading();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 09/05/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvSHPClickPage(ptPage) {
  var nPageCurrent = "";
  switch (ptPage) {
    case "next": //กดปุ่ม Next
      $(".xWBtnNext").addClass("disabled");
      nPageOld = $(".xWSHPPaging .active").text(); // Get เลขก่อนหน้า
      nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
      nPageCurrent = nPageNew;
      break;
    case "previous": //กดปุ่ม Previous
      nPageOld = $(".xWSHPPaging .active").text(); // Get เลขก่อนหน้า
      nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
      nPageCurrent = nPageNew;
      break;
    default:
      nPageCurrent = ptPage;
  }
  JSvShopDataTable(nPageCurrent);
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 09/05/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvSHPClickPageFromBch(ptPage) {
  // if(ptPage == '1'){ var nPage = 'previous'; }else if(ptPage == '2'){ var nPage = 'next';}
  var nPageCurrent = "";
  switch (ptPage) {
    case "next": //กดปุ่ม Next
      $(".xWBtnNext").addClass("disabled");
      nPageOld = $(".xWSHPPaging .active").text(); // Get เลขก่อนหน้า
      nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
      nPageCurrent = nPageNew;
      break;
    case "previous": //กดปุ่ม Previous
      nPageOld = $(".xWSHPPaging .active").text(); // Get เลขก่อนหน้า
      nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
      nPageCurrent = nPageNew;
      break;
    default:
      nPageCurrent = ptPage;
  }
  JSvBranchToShopDataTable(nPageCurrent);
  //	JSvCallPageBranchList(ptNamepage,nPageCurrent,pnStaBrowse,ptStaInto,ptInputId);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 11/10/2018 wasin
//Return: -
//Return Type: -
function JSxShopShowButtonChoose() {
  var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
  if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
    $("#odvMngTableList #oliBtnDeleteAll").addClass("disabled");
  } else {
    nNumOfArr = aArrayConvert[0].length;

    if (nNumOfArr > 1) {
      $("#odvMngTableList #oliBtnDeleteAll").removeClass("disabled");
    } else {
      $("#odvMngTableList #oliBtnDeleteAll").addClass("disabled");
    }
  }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 11/10/2018 wasin
//Return: -
//Return Type: -
function JSxShopPaseCodeDelInModal() {
  var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
  var tConfirm =$('#ohdDeleteChooseconfirm').val();
  if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
  } else {
    var tTextCode = "";
    for ($i = 0; $i < aArrayConvert[0].length; $i++) {
      tTextCode += aArrayConvert[0][$i].nCode;
      tTextCode += " , ";
    }
    $("#odvModalDeleteShopMultiple #ospTextConfirmDelMultiple").text(
      $("#ospTextConfirmDelMultiple").val()+tConfirm
    );
    $("#odvModalDeleteShopMultiple #ohdConfirmIDDelMultiple").val(tTextCode);
  }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Shop
//Creator: 15/05/2018 wasin
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

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 27/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbShopIsCreatePage() {
  try {
    const tShpCode = $("#oetShpCode").data("is-created");
    var bStatus = false;
    if (tShpCode == "") {
      // No have data
      bStatus = true;
    }
    return bStatus;
  } catch (err) {
    console.log("JSbShopIsCreatePage Error: ", err);
  }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 27/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbShopIsUpdatePage() {
  try {
    const tShpCode = $("#oetShpCode").data("is-created");
    var bStatus = false;
    if (!tShpCode == "") {
      // Have data
      bStatus = true;
    }
    return bStatus;
  } catch (err) {
    console.log("JSbShopIsUpdatePage Error: ", err);
  }
}

// Functionality: Show or Hide Component
// Parameters: ptComponent is element on document(id or class or...),pbVisible is visible
// Creator: 27/03/2019 wasin(Yoshi)
// Return: -
// Return Type: -
function JSxShopVisibleComponent(ptComponent, pbVisible, ptEffect) {
  try {
    if (pbVisible == false) {
      $(ptComponent).addClass("hidden");
    }
    if (pbVisible == true) {
      // $(ptComponent).removeClass('hidden');
      $(ptComponent)
        .removeClass("hidden fadeIn animated")
        .addClass("fadeIn animated")
        .one(
          "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",
          function() {
            $(this).removeClass("hidden fadeIn animated");
          }
        );
    }
  } catch (err) {
    console.log("JSxShopVisibleComponent Error: ", err);
  }
}

// Functionality: Event Single Delete Shop Single
// Parameters: Event Icon Delete
// Creator: 27/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: object
function JSoShopDeleteSingle(pnPage, ptShopCode, ptShopName, ptBchCode) {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    var tConfirm =$('#ohdDeleteconfirm').val();
    var tConfirmYN =$('#ohdDeleteconfirmYN').val();

    $("#odvModalDeleteShopSingle #ospTextConfirmDelSingle").html(
      $("#ospTextConfirmDelSingle").val()+tConfirm + ptShopCode +" ("+ptShopName+")"+tConfirmYN
    );
    $("#odvModalDeleteShopSingle").modal("show");
    $("#odvModalDeleteShopSingle #osmConfirmDelSingle")
      .unbind()
      .click(function() {
        JCNxOpenLoading();
        $.ajax({
          type: "POST",
          url: "shopEventDelete",
          data: { tIDCode: ptShopCode, tBchCode: ptBchCode },
          async: false,
          cache: false,
          timeout: 0,
          success: function(tResult) {
            var aReturnData = JSON.parse(tResult);
            if (aReturnData["nStaEvent"] == 1) {
              $("#odvModalDeleteShopSingle").modal("hide");
              $("#odvModalDeleteShopSingle #ospTextConfirmDelSingle").html(
                $("#oetTextComfirmDeleteSingle").val()
              );
              $(".modal-backdrop").remove();
              setTimeout(function() {
                JSvShopDataTable(pnPage);
              }, 500);
            } else {
              $("#odvModalDeleteShopSingle").modal("hide");
              $("#odvModalDeleteShopSingle #ospTextConfirmDelSingle").html(
                $("#oetTextComfirmDeleteSingle").val()
              );
              $(".modal-backdrop").remove();
              setTimeout(function() {
                JCNxCloseLoading();
                FSvCMNSetMsgErrorDialog(aReturnData["tStaMessg"]);
              }, 500);
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
        });
      });
  } else {
    JCNxShowMsgSessionExpired();
  }
}

// Functionality: Event Single Delete Shop Single
// Parameters: Event Icon Delete
// Creator: 27/02/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: object
function JSoShopDeleteMultiple() {
  var nStaSession = JCNxFuncChkSessionExpired();
  
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    var aDataDelMultiple = $(
      "#odvModalDeleteShopMultiple #ohdConfirmIDDelMultiple"
    ).val();
    var aTextsDelMultiple = aDataDelMultiple.substring(
      0,
      aDataDelMultiple.length - 2
    );
    var aDataSplit = aTextsDelMultiple.split(" , ");
    var nDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];
    for ($i = 0; $i < nDataSplitlength; $i++) {
      aNewIdDelete.push(aDataSplit[$i]);
    }
    if (nDataSplitlength > 1) {
      JCNxOpenLoading();
      localStorage.StaDeleteArray = "1";
      $.ajax({
        type: "POST",
        url: "shopEventDelete",
        data: { tIDCode: aNewIdDelete },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
          var aReturnData = JSON.parse(tResult);
          if (aReturnData["nStaEvent"] == 1) {
            setTimeout(function() {
              $("#odvModalDeleteShopMultiple").modal("hide");
              $(
                "#odvModalDeleteShopMultiple #ospTextConfirmDelMultiple"
              ).empty();
              $("#odvModalDeleteShopMultiple #ohdConfirmIDDelMultiple").val("");
              localStorage.removeItem("LocalItemData");
              JSvCallPageShopList();
              $(".modal-backdrop").remove();
            });
          } else {
            $("#odvModalDeleteShopMultiple").modal("hide");
            $("#odvModalDeleteShopMultiple #ospTextConfirmDelMultiple").empty();
            $("#odvModalDeleteShopMultiple #ohdConfirmIDDelMultiple").val("");
            $(".modal-backdrop").remove();
            setTimeout(function() {
              JCNxCloseLoading();
              FSvCMNSetMsgErrorDialog(aReturnData["tStaMessg"]);
            }, 500);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
      });
    }
  } else {
    JCNxShowMsgSessionExpired();
  }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Functionality: Function Check Type Shop GP
//Parameters: Event Select List Shop
//Creator: 25/01/2019 Wasin(Yoshi)
//Return: Duplicate/none
//Return Type: Page View
function JSxChkTypeDataGpInDB(ptBchCode, ptShpCode, pnPage) {
  var tReturn = "";
  $.ajax({
    type: "POST",
    url: "shopChkTypeGPInDB",
    data: {
      tShpCode: ptShpCode,
      tBchCode: ptBchCode
    },
    dataType: "html",
    cache: false,
    async: false,
    timeout: 0,
    success: function(tDataReturn) {
      tReturn = tDataReturn;
    },
    error: function(jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
  return tReturn;
}


//Functionality: Function call page Data Locker Type
//Parameters: Ajax
//Creator: 3/7/2019 Sarun
//Return: Viwe
//Return Type: Page View
function JSxLocTypeDatatable(paData){
  $.ajax({
      type: "POST",
      url: "LocTypeData",
      // data: { tSplAddress: paData },
      data: { nShpCode: paData },
      cache: false,
      timeout: 0,
      success: function(tResult) {
          $('#odvContentLocType').html(tResult);
          // $('#obtAddAddress').show();
          // $('#olaTitleAdd').hide();
          // $('#olaTitleEdit').hide();
          JCNxCloseLoading();
          // JSxSplNavDefult();
      },
      error: function(jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
  });

}

//Functionality: Function CallPage Add OR Edit page Data Locker
//Parameters: ShopCode
//Creator: 3/7/2019 Sarun
//Return: Viwe
//Return Type: Page View
function JSxLocTypeCallPageAddEdit(pnShpCode){
  JCNxOpenLoading();
  $.ajax({
      type: "POST",
      url: "LocTypeDataAddOrEdit",
      data: { nShpCode: pnShpCode},
      cache: false,
      timeout: 0,
      success: function(tResult) {
          $('#odvContentLocType').html(tResult);
          $('#obtShptSubmit').show();
           $('#obtShptEdit').hide();
          $('#olaTitleEdit').show();
          JCNxCloseLoading();
          // JSxSplNavDefult();
      },
      error: function(jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
  });
}

//Functionality: Function Add Or Edit ShopType Data
//Parameters: ShopCode
//Creator: 3/7/2019 Sarun
//Return: Viwe
//Return Type: Page View
function JSxLocTypeAddEdit(tRout, pnShpCode, pnBrhCode){
  JCNxOpenLoading();
  $.ajax({
    type: "POST",
      url: tRout,
      data:  $("#ofmAddShopt").serialize() + '&nShpCode='+ pnShpCode +'&nBrhCode=' + pnBrhCode  ,
      cache: false,
      timeout: 0,
      success: function(tResult) {
        JSxLocTypeDatatable(pnShpCode)
          $('#obtShptSubmit').hide();
           $('#obtShptEdit').show();
          $('#olaTitleEdit').hide();
          JCNxCloseLoading();
          // JSxSplNavDefult();
      },
      error: function(jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
     
  });
}