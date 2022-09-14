var nStaAdjStkSubBrowseType = $("#oetAdjStkSubStaBrowse").val();
var tCallAdjStkSubBackOption = $("#oetAdjStkSubCallBackOption").val();

$("document").ready(function () {
    localStorage.removeItem("LocalItemData");
    localStorage.removeItem("Ada.ProductListCenter");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxAdjStkSubNavDefult();

    sessionStorage.removeItem("EditInLine");

    if (nStaAdjStkSubBrowseType != 1) {
        JSvCallPageAdjStkSubList();
    } else {
        JSvCallPageAdjStkSubAdd();
    }


    // Event Click Cancel Document
    $('#obtAdjStkSubCancel').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSnAdjStkSubCancel(false);
        }else{
            JCNxShowMsgSessionExpired();
        } 
    });



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

    JSnAdjStkSubRemoveDTTemp(tSeqno, tVal, ele);
  } else {
    JCNxShowMsgSessionExpired();
  }
}

function JSxAdjStkSubNavDefult() {
    if (nStaAdjStkSubBrowseType != 1 || nStaAdjStkSubBrowseType == undefined) {
        $(".xCNAdjStkSubVBrowse").hide();
        $(".xCNAdjStkSubVMaster").show();
        $("#oliAdjStkSubTitleAdd").hide();
        $("#oliAdjStkSubTitleEdit").hide();
        $("#odvBtnAddEdit").hide();
        $(".obtChoose").hide();
        $("#odvBtnAdjStkSubInfo").show();
    } else {
        $("#odvModalBody .xCNAdjStkSubVMaster").hide();
        $("#odvModalBody .xCNAdjStkSubVBrowse").show();
        $("#odvModalBody #odvAdjStkSubMainMenu").removeClass("main-menu");
        $("#odvModalBody #oliAdjStkSubNavBrowse").css("padding", "2px");
        $("#odvModalBody #odvAdjStkSubBtnGroup").css("padding", "0");
        $("#odvModalBody .xCNAdjStkSubBrowseLine").css("padding", "0px 0px");
        $("#odvModalBody .xCNAdjStkSubBrowseLine").css("border-bottom", "1px solid #e3e3e3");
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
function JSxAdjStkSubBrowsePdt(ptType) {
    $('#odvModalDOCPDT').modal({backdrop: 'static', keyboard: false});
    if(ptType == 'from'){
        tNextFunc = 'JSxAdjStkSubBrowsePdtFrom';
    }else{
        tNextFunc = 'JSxAdjStkSubBrowsePdtTo';
    }
    if(localStorage.getItem("Ada.ProductListCenter") === null){
        localStorage.setItem("Ada.ProductListCenter",true);
        var dTime               = new Date();
        var dTimelocalStorage   = dTime.getTime();

        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                'Qualitysearch'   : ['SUP','NAMEPDT','CODEPDT','FromToBCH','FromToSHP','FromToPGP','FromToPTY'],
                'PriceType'       : ['Pricesell'],
                'SelectTier'      : ['PDT'],//PDT, Barcode
                // 'Elementreturn'   : ['oetASTFilterPdtCodeFrom','oetASTFilterPdtNameFrom'],
                'ShowCountRecord' : 10,
                'NextFunc'        : tNextFunc,
                'ReturnType'      : 'S', //S = Single M = Multi
                'SPL'             : ['',''],
                'BCH'             : [$('#ohdAdjStkSubBchCodeTo').val(),''],//Code, Name
                'SHP'             : ['',''],
                'TimeLocalstorage': dTimelocalStorage
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                // $('#odvModalDOCPDT').modal({backdrop: 'static', keyboard: false})  
                $('#odvModalDOCPDT').modal({ show: true });

                //remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                $('#odvModalsectionBodyPDT').html(tResult);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }else{
        $('#odhEleNameNextFunc').val(tNextFunc);
        $('#odvModalDOCPDT').modal({ show: true });
    }
}

function JSxAdjStkSubBrowsePdtFrom(poPdtData){
    var aDataPdt = JSON.parse(poPdtData);
    var tPdtCode = aDataPdt[0]['packData']['PDTCode'];
    var tPdtName = aDataPdt[0]['packData']['PDTName'];

    $('#oetASTFilterPdtCodeFrom').val(tPdtCode);
    $('#oetASTFilterPdtNameFrom').val(tPdtName);

    if($('#oetASTFilterPdtCodeTo').val() == ''){
        $('#oetASTFilterPdtCodeTo').val(tPdtCode);
        $('#oetASTFilterPdtNameTo').val(tPdtName);
    }
    
}

function JSxAdjStkSubBrowsePdtTo(poPdtData){
    var aDataPdt = JSON.parse(poPdtData);
    var tPdtCode = aDataPdt[0]['packData']['PDTCode'];
    var tPdtName = aDataPdt[0]['packData']['PDTName'];

    $('#oetASTFilterPdtCodeTo').val(tPdtCode);
    $('#oetASTFilterPdtNameTo').val(tPdtName);

    if($('#oetASTFilterPdtCodeFrom').val() == ''){
        $('#oetASTFilterPdtCodeFrom').val(tPdtCode);
        $('#oetASTFilterPdtNameFrom').val(tPdtName);
    }
}

/**
 * Functionality : Action for approve
 * Parameters : pbIsConfirm
 * Creator : 11/04/2019 Krit(Copter)
 * Last Modified : 20/07/2020 Napat(Jame)
 * Return : -
 * Return Type : -
 */
function JSnAdjStkSubApprove(pbIsConfirm) {
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    //     try {
            if (pbIsConfirm) {
                // $("#ohdCardShiftTopUpCardStaPrcDoc").val(2); // Set status for processing approve
                $("#odvAdjStkSubPopupApv").modal("hide");

                var tXthDocNo = $("#oetAdjStkSubAjhDocNo").val();
                // tXthStaApv = $("#ohdXthStaApv").val();

                $.ajax({
                    type: "POST",
                    url: "adjStkSubApproved",
                    data: {
                        tXthDocNo: tXthDocNo,
                        // tXthStaApv: tXthStaApv
                    },
                    cache: false,
                    timeout: 0,
                    success: function (oResult) {
                        let aResult = JSON.parse(oResult);
                        // console.log(aResult);
                        if(aResult['tCode'] == '1'){
                            JSvCallPageAdjStkSubEdit(tXthDocNo);
                        }else{
                            alert(aResult['tDesc']);
                        }
                        // try {
                        //     let aResult = JSON.parse(oResult);
                        //     // if (oResult.nStaEvent == "900") {
                        //     //     FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                        //     // }
                        // } catch (e) {
                        // }

                        // JSoAdjStkSubSubscribeMQ();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $("#odvAdjStkSubPopupApv").modal("show");
            }
    //     } catch (err) {
    //         console.log("JSnAdjStkSubApprove Error: ", err);
    //     }
    // } else {
    //     JCNxShowMsgSessionExpired();
    // }
}

// Last Update By : Napat(Jame) 2020/07/23
function JSnAdjStkSubCancel(pbIsConfirm) {
    var tXthDocNo = $("#oetAdjStkSubAjhDocNo").val();
    if (pbIsConfirm) {
        $.ajax({
            type: "POST",
            url: "adjStkSubCancel",
            data: {
                tXthDocNo: tXthDocNo
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                $("#odvAdjStkSubChangePopupStaDoc").modal("hide");
                $('.modal-backdrop').remove();
                var aResult = $.parseJSON(tResult);
                if (aResult.nSta == 1) {
                    JSvCallPageAdjStkSubEdit(tXthDocNo);
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
        $('#odvAdjStkSubPopupCancel').modal({backdrop:'static',keyboard:false});
        $("#odvAdjStkSubPopupCancel").modal("show");
    }
}

// Last Update : Napat(Jame) 2020/07/17
function JSnAdjStkSubRemoveDTTemp(ptSeqno, ptPdtCode, ele) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var ptXthDocNo  = $("#oetAdjStkSubAjhDocNo").val();
        var nPage       = $(".xWPageAdjStkSubPdt .active").text();

        $.ajax({
            type: "POST",
            url: "adjStkSubRemovePdtInDTTmp",
            data: {
                ptXthDocNo  : ptXthDocNo,
                ptSeqno     : ptSeqno,
                ptPdtCode   : ptPdtCode
            },
            cache: false,
            timeout: 0,
            success: function (oResult) {
                var aResult = $.parseJSON(oResult);
                if(aResult['rtCode'] == '1'){
                    $(ele).fadeOut();
                }else{
                    alert(aResult['rtDesc']);
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
 * Functionality : Call Purchase Page Add
 * Parameters : -
 * Creator : 22/05/2019 Piya(Tiger)
 * Return : View
 * Return Type : View
 */
function JSvCallPageAdjStkSubAdd() {
    $.ajax({
        type: "POST",
        url: "adjStkSubPageAdd",
        data: {},
        cache: false,
        timeout: 0,
        success: function (tResult) {
            if (nStaAdjStkSubBrowseType == 1) {
                $(".xCNAdjStkSubVMaster").hide();
                $(".xCNAdjStkSubVBrowse").show();
            } else {
                $(".xCNAdjStkSubVBrowse").hide();
                $(".xCNAdjStkSubVMaster").show();
                $("#oliAdjStkSubTitleEdit").hide();
                $("#oliAdjStkSubTitleAdd").show();
                $("#odvBtnAdjStkSubInfo").hide();
                $("#odvBtnAddEdit").show();
                $("#obtAdjStkSubApprove").hide();
                $("#obtAdjStkSubCancel").hide();
                $('.xWAstDivButtonSave').show();
                $('#obtAdjStkSubPrint').hide();
            }

            $("#odvContentPageAdjStkSub").html(tResult);

            // Control Object And Button ปิด เปิด
            JCNxAdjStkSubControlObjAndBtn();

            // Load Pdt Table
            JSvAdjStkSubLoadPdtDataTableHtml();

            $('#ocbAdjStkSubAutoGenCode').change(function () {
                $("#oetAdjStkSubAjhDocNo").val("");
                if ($('#ocbAdjStkSubAutoGenCode').is(':checked')) {
                    $("#oetAdjStkSubAjhDocNo").attr("readonly", true);
                    $("#oetAdjStkSubAjhDocNo").attr("onfocus", "this.blur()");
                    $('#ofmAddAdjStkSub').removeClass('has-error');
                    $('#ofmAddAdjStkSub .form-group').closest('.form-group').removeClass("has-error");
                    $('#ofmAddAdjStkSub em').remove();
                } else {
                    $("#oetAdjStkSubAjhDocNo").attr("readonly", false);
                    $("#oetAdjStkSubAjhDocNo").removeAttr("onfocus");
                }

            });
            // $("#oetAdjStkSubAjhDocNo,#oetXthDocDate,#oetXthDocTime").blur(function () {
            //     JSxSetStatusClickAdjStkSubSubmit(0);
            //     JSxValidateFormAddAdjStkSub();
            //     $('#ofmAddAdjStkSub').submit();
            // });

            $(".xWConditionSearchPdt.disabled").attr("disabled", "disabled");
            // $("#obtAdjStkSubDocBrowsePdt.disabled").attr("disabled","disabled");
            // $("#obtAdjStkSubDocBrowsePdt").css("opacity","0.4");
            // $("#obtAdjStkSubDocBrowsePdt").css("cursor","not-allowed");

        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

/**
 * Functionality : (event) Add/Edit
 * Parameters : form
 * Creator : 22/05/2019 Piya(Tiger)
 * Return : Status Add
 * Return Type : number
 */
function JSnAddEditAdjStkSub() {
    JSxValidateFormAddAdjStkSub();
}

function JSvCallPageAdjStkSubList() {
    try {
        $.ajax({
            type: "GET",
            url: "adjStkSubFormSearchList",
            data: {},
            cache: false,
            timeout: 0,
            success: function (tResult) {
                $("#odvContentPageAdjStkSub").html(tResult);
                JSxAdjStkSubNavDefult();

                JSvCallPageAdjStkSubPdtDataTable(); // แสดงข้อมูลใน List
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvCallPageAdjStkSubList Error: ', err);
    }
}

function JSvCallPageAdjStkSubPdtDataTable(pnPage) {
    JCNxOpenLoading();

    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }

    var oAdvanceSearch = JSoAdjStkSubGetAdvanceSearchData();

    $.ajax({
        type: "POST",
        url: "adjStkSubDataTable",
        data: {
            oAdvanceSearch: oAdvanceSearch,
            nPageCurrent: nPageCurrent
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            $("#odvContentPurchaseorder").html(tResult);

            JSxAdjStkSubNavDefult();
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
 * Creator : 22/05/2019 Piya(Tiger)
 * Last Modified : -
 * Return : Search data
 * Return Type : Object
 */
function JSoAdjStkSubGetAdvanceSearchData() {
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
                tSearchStaDocAct: $("#ocmStaDocAct").val()
            };
            return oAdvanceSearchData;
        } catch (err) {
            console.log("JSoAdjStkSubGetAdvanceSearchData Error: ", err);
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
function JSvCallPageAdjStkSubEdit(ptAjhDocNo) {

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "adjStkSubPageEdit",
        data: {ptAjhDocNo: ptAjhDocNo},
        cache: false,
        timeout: 0,
        success: function (tResult) {
            if (tResult != "") {
                $("#oliAdjStkSubTitleAdd").hide();
                $("#oliAdjStkSubTitleEdit").show();
                $("#odvBtnAdjStkSubInfo").hide();
                $("#odvBtnAddEdit").show();
                $("#odvContentPageAdjStkSub").html(tResult);
                $("#oetAdjStkSubAjhDocNo").addClass("xCNDisable");
                $(".xCNDisable").attr("readonly", true);
                $(".xCNiConGen").hide();
                $('#obtAdjStkSubPrint').show();

                var nStaApv = parseInt($('#ohdAdjStkSubAjhStaApv').val());
                var nStaDoc = parseInt($('#ohdAdjStkSubAjhStaDoc').val());
                if(nStaApv == 1 || nStaDoc == 3){
                    $("#obtAdjStkSubApprove").hide();
                    $("#obtAdjStkSubCancel").hide();
                    $('.xWAstDivButtonSave').hide();
                }else{
                    $("#obtAdjStkSubApprove").show();
                    $("#obtAdjStkSubCancel").show();
                    $('.xWAstDivButtonSave').show();
                }

            }

            // Function Load Table Pdt ของ AdjStkSub
            JSvAdjStkSubLoadPdtDataTableHtml();

            // Control Object And Button ปิด เปิด
            JCNxAdjStkSubControlObjAndBtn();
            JCNxLayoutControll();
            // $(".xWConditionSearchPdt.disabled").attr("disabled", "disabled");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function : Control Object And Button ปิด เปิด
function JCNxAdjStkSubControlObjAndBtn() {
    // Check สถานะอนุมัติ
    var ohdXthStaApv = $("#ohdXthStaApv").val();
    var ohdXthStaDoc = $("#ohdXthStaDoc").val();

    // Set Default
    // Btn Cancel
    $("#obtAdjStkSubCancel").attr("disabled", false);
    // Btn Apv
    $("#obtAdjStkSubApprove").attr("disabled", false);
    // $(".form-control").attr("disabled", false);
    $(".ocbListItem").attr("disabled", false);
    // $(".xCNBtnBrowseAddOn").attr("disabled", false);
    $(".xCNBtnDateTime").attr("disabled", false);
    $(".xCNDocBrowsePdt").attr("disabled", false).removeClass("xCNBrowsePdtdisabled");
    $(".xCNDocDrpDwn").show();
    $("#oetAdjStkSubSearchPdtHTML").attr("disabled", false);
    $(".xWBtnGrpSaveLeft").attr("disabled", false);
    $(".xWBtnGrpSaveRight").attr("disabled", false);
    $("#oliBtnEditShipAdd").show();
    $("#oliBtnEditTaxAdd").show();

    if (ohdXthStaApv == 1) {
        // Btn Apv
        $("#obtAdjStkSubApprove").attr("disabled", true);
        // Control input ปิด
        // $(".form-control").attr("disabled", true);
        $(".ocbListItem").attr("disabled", true);
        // $(".xCNBtnBrowseAddOn").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetAdjStkSubSearchPdtHTML").attr("disabled", false);
        $(".xWBtnGrpSaveLeft").attr("disabled", true);
        $(".xWBtnGrpSaveRight").attr("disabled", true);
        $("#oliBtnEditShipAdd").hide();
        $("#oliBtnEditTaxAdd").hide();
        $("#ocbAdjStkSubStaDocAct").attr("disabled", true);
    }
    // Check สถานะเอกสาร
    if (ohdXthStaDoc == 3) {
        // Btn Cancel
        $("#obtAdjStkSubCancel").attr("disabled", true);
        // Btn Apv
        $("#obtAdjStkSubApprove").attr("disabled", true);
        // Control input ปิด
        // $(".form-control").attr("disabled", true);
        $(".ocbListItem").attr("disabled", true);
        // $(".xCNBtnBrowseAddOn").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetAdjStkSubSearchPdtHTML").attr("disabled", false);
        $(".xWBtnGrpSaveLeft").attr("disabled", true);
        $(".xWBtnGrpSaveRight").attr("disabled", true);
        $("#oliBtnEditShipAdd").hide();
        $("#oliBtnEditTaxAdd").hide();
        $("#ocbAdjStkSubStaDocAct").attr("disabled", true);
    }
}

/**
 * Functionality : (event) Delete
 * Parameters : tIDCode รหัส
 * Creator : 22/05/2019 Piya(Tiger)
 * Return : 
 * Return Type : Status Number
 */
function JSnAdjStkSubDel(tCurrentPage, tIDCode) {
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
                url: "adjStkSubEventDelete",
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
                            JSvAdjStkSubClickPage(tCurrentPage);
                        }, 500);
                    } else {
                        alert(aReturn["tStaMessg"]);
                    }
                    JSxAdjStkSubNavDefult();
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
function JSnAdjStkSubDelChoose() {
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
            url: "adjStkSubEventDelete",
            data: {
                tIDCode: aNewIdDelete
            },
            success: function (tResult) {
                var aReturn = JSON.parse(tResult);
                if (aReturn["nStaEvent"] == 1) {
                    setTimeout(function () {
                        $("#odvModalDel").modal("hide");
                        JSvCallPageAdjStkSubPdtDataTable();
                        $("#ospConfirmDelete").text("ยืนยันการลบข้อมูลของ : ");
                        $("#ohdConfirmIDDelete").val("");
                        localStorage.removeItem("LocalItemData");
                        $(".modal-backdrop").remove();
                    }, 1000);
                } else {
                    alert(aReturn["tStaMessg"]);
                }
                JSxAdjStkSubNavDefult();
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
function JSoAdjStkSubPdtDelChoose(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var aSeq    = $("#ohdConfirmSeqDelete").val();
        var tDocNo  = $("#oetAdjStkSubAjhDocNo").val();

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
                url: "adjStkSubPdtMultiDeleteEvent",
                data: {
                    tDocNo: tDocNo,
                    tSeqCode: aSeqData
                },
                success: function (tResult) {
                    // console.log(tResult);
                    setTimeout(function () {
                        $("#odvModalDelPdtAdjStkSub").modal("hide");
                        JSvAdjStkSubLoadPdtDataTableHtml(pnPage);
                        $("#ospConfirmDelete").text($("#oetTextComfirmDeleteSingle").val());
                        $("#ohdConfirmSeqDelete").val("");
                        $("#ohdConfirmPdtDelete").val("");
                        $("#ohdConfirmPunDelete").val("");
                        $("#ohdConfirmDocDelete").val("");
                        localStorage.removeItem("LocalItemData");
                        $(".obtChoose").hide();
                        $(".modal-backdrop").remove();

                        // for ($i = 0; $i < aSeqSplitlength; $i++) {
                        //     $('.xWPdtItemSeq'+aSeqSplit[$i]).fadeOut();
                        // }
                        
                    }, 500);
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
function JSvAdjStkSubClickPage(ptPage) {
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
    JSvCallPageAdjStkSubPdtDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 10/07/2019 Krit(Copter)
//Return: -
//Return Type: -
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliAdjStkSubBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliAdjStkSubBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliAdjStkSubBtnDeleteAll").addClass("disabled");
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
function JSxAdjStkSubPdtTextinModal() {
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
function JSvAdjStkSubPdtClickPage(ptPage) {
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWPageAdjStkSubPdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWPageAdjStkSubPdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        console.log(nPageCurrent);
        // JCNxOpenLoading();
        JSvAdjStkSubLoadPdtDataTableHtml(nPageCurrent);
    // } else {
    //     JCNxShowMsgSessionExpired();
    // }
}

// Advance Table
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Function : Get Html PDT มาแปะ ในหน้า Add
// Create : 04/04/2019 Krit(Copter)
function JSvAdjStkSubLoadPdtDataTableHtml(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        JCNxOpenLoading();
        
        var tSearchAll = $('#oetAdjStkSubSearchPdtHTML').val();
        var tAjhDocNo, tAjhStaApv, tAjhStaDoc, nPageCurrent;
        if (JCNbAdjStkSubIsCreatePage()) {
            tAjhDocNo = "";
        } else {
            tAjhDocNo = $("#oetAdjStkSubAjhDocNo").val();
        }
        
        tAjhStaApv = $("#ohdAdjStkSubAjhStaApv").val();
        tAjhStaDoc = $("#ohdAdjStkSubAjhStaDoc").val();

        // เช็ค สินค้าใน table หน้านั้นๆ มีหรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
        if ($("#odvTBodyAdjStkSubPdt .xWPdtItem").length == 0) {
            if (typeof pnPage !== 'undefined') {
                pnPage = pnPage - 1;
            }
        }

        nPageCurrent = ( (typeof pnPage === 'undefined') || (pnPage === "") || (pnPage <= 0) ) ? "1" : pnPage;

        $.ajax({
            type: "POST",
            url: "adjStkSubPdtAdvanceTableLoadData",
            data: {
                tSearchAll      : tSearchAll,
                tAjhDocNo       : tAjhDocNo,
                tAjhStaApv      : tAjhStaApv,
                tAjhStaDoc      : tAjhStaDoc,
                nPageCurrent    : nPageCurrent
            },
            cache: false,
            Timeout: 0,
            success: function (tResult) {
                $("#odvAdjStkSubPdtTablePanal").html(tResult);
                // JSvAdjStkSubLoadVatTableHtml(); // Load Vat Table

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

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 22/05/2019 piya(tiger)
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbAdjStkSubIsCreatePage(){
    try{
        var tAdjStkSubDocNo   = $('#oetAdjStkSubAjhDocNo').data('is-created');
        var bStatus = false;
        if(tAdjStkSubDocNo == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbAdjStkSubIsCreatePage Error: ', err);
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
function JCNbAdjStkSubIsUpdatePage(){
    try{
        var tAdjStkSubDocNo = $('#oetAdjStkSubAjhDocNo').data('is-created');
        var bStatus = false;
        if(!tAdjStkSubDocNo == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbAdjStkSubIsUpdatePage Error: ', err);
    }
}


// Creatte By Napat(Jame) 2020/07/17
function JSxASTEventAddProducts(){
    try{

        var aDataCondition = {};
        jQuery.each($('#ofmASTFilterDataCondition').serializeArray(), function( i, aRes ) {
            if(aRes.value == ""){
                tResult = null;
            }else{
                tResult = aRes.value;
            }
            aDataCondition[aRes.name] = tResult;
        });

        var aDataLocation = [];
        jQuery.each($('input[name="ocbAdjStkSubPlcCode[]"]:checked').serializeArray(), function( i, aRes ) {
            aDataLocation.push(aRes.value);
        });

        var aDataInsert = {
            tBchCode    : $('#ohdAdjStkSubBchCodeTo').val(),
            tDocNo      : $('#oetAdjStkSubAjhDocNo').val()
        };

        $.ajax({
            type: "POST",
            url: "docASTEventAddProducts",
            data: {
                paLocation      : aDataLocation,
                paCondition     : aDataCondition,
                paDataInsert    : aDataInsert
            },
            cache: false,
        Timeout: 0,
            success: function (oResult) {
                var aResult = $.parseJSON(oResult);
                // console.log(aResult);
                // console.log(aResult['aPdtCallBackFunction']);
                var aData = aResult['aPdtCallBackFunction'];
                var oOptionForFashion = {
                    'bListItemAll'   : true,
                    'tSpcControl'  : '',
                    'tNextFunc' : 'JSxAdjStkSubInsertDTFhnToTmp'
                }
                switch(aResult['tCode']){
                    case '1':
                        $('#odvAdjStkSubFilterDataCondition').modal('hide');
                        JSvAdjStkSubLoadPdtDataTableHtml(1);
                        JSxCheckProductSerialandFashion(aData,oOptionForFashion,'insert');
                    break;
                    case '2':
                        $('#odvAdjStkSubFilterDataCondition').modal('hide');
                        JSvAdjStkSubLoadPdtDataTableHtml(1);
                        JSxCheckProductSerialandFashion(aData,oOptionForFashion,'insert');
                        

                        $('input[name="ocbAdjStkSubPlcCode"]:checked').prop( "checked", false );
                        $('#ocbAdjStkSubPlcCode'+aResult['tPlcCode']).prop( "checked", true );

                    break;
                    default:
                        alert(aResult['tDesc']);
                    break;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        
    }catch(err){
        console.log('JSxASTEventAddProducts Error: ', err);
    }
}



// // Create By : Nattakit(Nale) 2021/05/21
// function JSxAdjStkSubBrowsePdtFrom_PDTSerialorFashion(paData){
//     // console.log(paData);
//     JSxAdjStkSubInsertDTFhnToTmp(paData);

// }
// // Create By : Nattakit(Nale) 2021/05/21
// function JSxAdjStkSubBrowsePdtTo_PDTSerialorFashion(paData){
//     // console.log(paData);
//     JSxAdjStkSubInsertDTFhnToTmp(paData);
// }

// Create By : Nattakit(Nale) 2021/05/21
function JSxAdjStkSubInsertDTFhnToTmp_PDTSerialorFashion(paData){
    try{
        // console.log(paData);
         var paDataDTFhn = JSON.parse(paData);
         var aDataInsert = {
            tBchCode    : $('#ohdAdjStkSubBchCodeTo').val(),
            tDocNo      : $('#oetAdjStkSubAjhDocNo').val()
        };
        $.ajax({
            type: "POST",
            url: "docASTEventAddProductsFashion",
            data: {
                paDataDTFhn     : paDataDTFhn,
                paDataInsert    : aDataInsert
            },
            cache: false,
            Timeout: 0,
            success: function (oResult) {
                // JSvAdjStkSubLoadPdtDataTableHtml(1);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    }catch(err){
        console.log('JSxASTEventAddProducts Error: ', err);
    }
}

function FSvStkSubAddPdtIntoDocDTTempC1_PDTSerialorFashion(paData){
    FSvStkSubAddPdtIntoDocDTTemp(paData,1);
}

function FSvStkSubAddPdtIntoDocDTTempC2_PDTSerialorFashion(paData){
    FSvStkSubAddPdtIntoDocDTTemp(paData,2);
}

function FSvStkSubAddPdtIntoDocDTTemp(paData,pnCout){

    console.log(paData);

    try{
        // console.log(paData);
         var paDataDTFhn = JSON.parse(paData);
         var aDataInsert = {
            tBchCode    : $('#ohdAdjStkSubBchCodeTo').val(),
            tDocNo      : $('#oetAdjStkSubAjhDocNo').val()
        };
        $.ajax({
            type: "POST",
            url: "docASTEventEditProductsFashion",
            data: {
                paDataDTFhn     : paDataDTFhn,
                paDataInsert    : aDataInsert,
                pnCout          : pnCout
            },
            cache: false,
            Timeout: 0,
            success: function (oResult) {
                JSvAdjStkSubLoadPdtDataTableHtml(1);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    }catch(err){
        console.log('JSxASTEventAddProducts Error: ', err);
    }


}

// Create By : Napat(Jame) 2020/07/21
// ตรวจสอบเวลา ก่อนนำไปอัพเดทตอน edit inline
function JSxASTEditInlineCheckTime(poElm){
    if(sessionStorage.getItem("EditInLine") == "1"){
        sessionStorage.setItem("EditInLine", "2");
        var tField      = poElm.attr('data-field');
        var nSeq        = poElm.parent().parent().parent().attr('data-seqno');
        if(tField.search("C1") != "-1"){
            tPrefixQty = "C1";
        }else{
            tPrefixQty = "C2";
        }

        var tTime    = $('#ohdFTAjdUnitTime'+tPrefixQty+nSeq);
        var dDate    = $('#ohdFTAjdUnitDate'+tPrefixQty+nSeq);
        if(tTime.val() != "" && dDate.val() == ""){
            $('#ohdFTAjdUnitDate'+tPrefixQty+nSeq).val(JStASTGetDateTime(121));
        }
        if(tTime.val() == ""){
            $('#ohdFTAjdUnitDate'+tPrefixQty+nSeq).val('');
        }

        var nValue = $('#ohdFCAjdUnitQty'+tPrefixQty+nSeq);
        if(nValue.val() == ""){
            nValue.val(0);
        }

        sessionStorage.setItem("EditInLine", "1");
        JSxASTEditInLine(poElm,2);

    }
}

// Create By : Napat(Jame) 2020/07/21
// ตรวจสอบวันที่ ก่อนนำไปอัพเดทตอน edit inline
function JSxASTEditInlineCheckDate(poElm){
    if(sessionStorage.getItem("EditInLine") == "1"){
        sessionStorage.setItem("EditInLine", "2");
        var tField      = poElm.attr('data-field');
        var nSeq        = poElm.parent().parent().parent().attr('data-seqno');
        if(tField.search("C1") != "-1"){
            tPrefixQty = "C1";
        }else{
            tPrefixQty = "C2";
        }

        var dNewDate = "";
        var dOldDate = poElm.val();
        var tTime    = $('#ohdFTAjdUnitTime'+tPrefixQty+nSeq).val();
        // console.log('Old '+dOldDate);
        setTimeout(function(){ 
            dNewDate = $('#ohdFTAjdUnitDate'+tPrefixQty+nSeq).val();
            // console.log('New '+dNewDate);

            if(dNewDate == "" && tTime != ""){
                // console.log('clear time ' + '#ohdFTAjdUnitTime'+tPrefixQty+nSeq);
                $('#ohdFTAjdUnitTime'+tPrefixQty+nSeq).val('');
            }

            if( dNewDate == dOldDate && dOldDate != "" ){
                // console.log('cancel');
                sessionStorage.removeItem("EditInLine");
                return false;
            }else{
                // console.log('go on');
                var nValue = $('#ohdFCAjdUnitQty'+tPrefixQty+nSeq);
                if(nValue.val() == ""){
                    nValue.val(0);
                }
                if(dNewDate != ""){
                    $('#ohdFTAjdUnitTime'+tPrefixQty+nSeq).val(JStASTGetDateTime(108));
                }
                sessionStorage.setItem("EditInLine", "1");
                JSxASTEditInLine(poElm,2);
            }

        }, 100);
    }
}

function JSxASTEditInLine(poElm,pnType){
    if(sessionStorage.getItem("EditInLine") == "1"){
        sessionStorage.setItem("EditInLine", "2");
        var tDocNo      = $('#oetAdjStkSubAjhDocNo').val();
        var nSeq        = poElm.parent().parent().parent().attr('data-seqno');
        var tField      = poElm.attr('data-field');
        var nIndex      = $('.xW'+tField).index(poElm);

        if(tField.search("C1") != "-1"){
            tPrefixQty = "C1";
        }else{
            tPrefixQty = "C2";
        }

        // console.log(tPrefixQty);
        // console.log(tField);
        // console.log(poElm.val());
        // var dOldDate = poElm.val();
        // console.log(dOldDate);


        // Check Values if null or ""
        if(tField == "FCAjdUnitQtyC1"){
            // console.log('Edit C1');
            if($('#ohdFCAjdUnitQtyC1'+nSeq).val() == ""){ $('#ohdFCAjdUnitQtyC1'+nSeq).val(0); }
        }else if(tField == "FCAjdUnitQtyC2"){
            if($('#ohdFCAjdUnitQtyC2'+nSeq).val() == "" && ( $('#ohdFTAjdUnitDateC2'+nSeq).val() == "" || $('#ohdFTAjdUnitTimeC2'+nSeq).val() == "" ) ){
                // console.log('Edit C2');
                if($(poElm).hasClass('xWASTCanNextFocus') === true){
                    $('.xW'+tField).eq(nIndex + 1).focus();
                }
                sessionStorage.removeItem("EditInLine");
                return false;
            }
        }
        /*else{
            if(poElm.val() == ""){
                console.log('cencel');
                sessionStorage.removeItem("EditInLine");
                return false;
            }
        }*/

        if(tField.substr(0, 13) == "FCAjdUnitQtyC"){
            var tQty  = $('#ohdFCAjdUnitQty'+tPrefixQty+nSeq).val();
            var dDate = $('#ohdFTAjdUnitDate'+tPrefixQty+nSeq);
            var tTime = $('#ohdFTAjdUnitTime'+tPrefixQty+nSeq);
            // if( dDate.val() == "" ){
                dDate.val(JStASTGetDateTime(121));
            // }
            // if( tTime.val() == "" ){
                tTime.val(JStASTGetDateTime(108));
            // }
            $('#ohdFCAjdUnitQty'+tPrefixQty+nSeq).val(parseInt(tQty));
        }

        // Values
        var nVal        = parseInt($('#ohdFCAjdUnitQty'+tPrefixQty+nSeq).val());
        var dDate       = $('#ohdFTAjdUnitDate'+tPrefixQty+nSeq).val();
        var tTime       = $('#ohdFTAjdUnitTime'+tPrefixQty+nSeq).val();

        if(tDocNo == "" || tDocNo === undefined){ tDocNo = ' '; }
        if(isNaN(nVal) || nVal === undefined){ nVal = 0; }

        switch(pnType){
            case 1:
                if($(poElm).hasClass('xWASTCanNextFocus') === true){
                    $('.xW'+tField).eq(nIndex + 1).focus();
                }
                break;
            default:
                break;
        }

        sessionStorage.removeItem("EditInLine");

        $.ajax({
            type: "POST",
            url: "docASTEventEditInLine",
            data: {
                ptDocNo     : tDocNo,
                pnSeq       : nSeq,
                pnVal       : nVal,
                pdDate      : dDate,
                ptTime      : tTime,
                ptField     : tField
            },
            cache: false,
            timeout: 0,
            success: function(oResult){
                var aReturn = JSON.parse(oResult);
                // console.log(aReturn);
                if(aReturn['nStaQuery'] != 1){
                    alert(aReturn['nStaQuery']['tStaMessage']);
                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

function JStASTGetDateTime(nType,tDate){
    if(tDate == '' || tDate === undefined){
        var today   = new Date();
    }else{
        var today   = new Date(tDate);
    }
    var dd      = today.getDate();
    var mm      = today.getMonth()+1; 
    var yyyy    = today.getFullYear();
    var hh      = today.getHours();
    var mi      = today.getMinutes();
    var ss      = today.getSeconds();
    var tReturn = "";
    if(dd<10){
        dd='0'+dd;
    } 
    if(mm<10){
        mm='0'+mm;
    }
    if(hh<10){
        hh='0'+hh;
    }
    if(mi<10){
        mi='0'+mi;
    }
    if(ss<10){
        ss='0'+ss;
    }
    switch(nType){
        case 121:
            tReturn = yyyy+'-'+mm+'-'+dd;
            break;
        case 108:
            tReturn = hh+':'+mi+':'+ss;
            break;
    }
    return tReturn;
}























