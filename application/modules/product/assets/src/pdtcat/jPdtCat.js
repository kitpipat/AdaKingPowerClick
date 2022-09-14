var nStaCatBrowseType = $('#oetCatStaBrowse').val();
var tCallCatBackOption = $('#oetCatCallBackOption').val();
// alert(nStaCatBrowseType+'//'+tCallCatBackOption);

$('document').ready(function() {
  JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
  JSxCatNavDefult();
  if (nStaCatBrowseType != 1) {
    JSvCallPagePdtCatList(1);
  } else {
    JSvCallPagePdtCatAdd();
  }
  localStorage.removeItem('LocalItemData');
});
///function : Function Clear Defult Button Product Unit
//Parameters : Document Ready
//Creator : 13/09/2018 wasin
//Return : Show Tab Menu
//Return Type : -
function JSxCatNavDefult() {
  if (nStaCatBrowseType != 1 || nStaCatBrowseType == undefined) {
    $('.xCNCatVBrowse').hide();
    $('.xCNCatVMaster').show();
    $('.xCNChoose').hide();
    $('#oliCatTitleAdd').hide();
    $('#oliCatTitleEdit').hide();
    $('#odvBtnAddEdit').hide();
    $('#odvBtnCatInfo').show();
  } else {
    $('#odvModalBody #odvCatMainMenu').removeClass('main-menu');
    $('#odvModalBody #oliCatNavBrowse').css('padding', '2px');
    $('#odvModalBody #odvCatBtnGroup').css('padding', '0');
    $('#odvModalBody .xCNCatBrowseLine').css('padding', '0px 0px');
    $('#odvModalBody .xCNCatBrowseLine').css('border-bottom', '1px solid #e3e3e3');
  }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function
//Creator : 13/09/2018 wasin
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
      tMsgError += tHtmlError.find('p:nth-child(2)').text();
      break;
    case 500:
      tMsgError += tHtmlError.find('p:nth-child(3)').text();
      break;

    default:
      tMsgError += 'something had error. please contact admin';
      break;
  }
  $("body").append(tModal);
  $('#modal-customs').attr("style", 'width: 450px; margin: 1.75rem auto;top:20%;');
  $('#myModal').modal({
    show: true
  });
  $('#odvModalBody').html(tMsgError);
}

//function : Call Product Unit Page list
//Parameters : Document Redy And Event Button
//Creator :	13/09/2018 wasin
//Return : View
//Return Type : View
function JSvCallPagePdtCatList(pnPage) {
  localStorage.tStaPageNow = 'JSvCallPagePdtCatList';
  $('#oetSearchAll').val('');
  JCNxOpenLoading();
  $.ajax({
    type: "POST",
    url: "masPdtCatList",
    cache: false,
    timeout: 0,
    success: function(tResult) {
      $('#odvContentPagePdtCat').html(tResult);
      JSvPdtCatDataTable(pnPage);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//function : Call Product Unit Data List
//Parameters : Ajax Success Event
//Creator:	13/09/2018 wasin
//Return : View
//Return Type : View
function JSvPdtCatDataTable(pnPage) {
  var tSearchAll = $('#oetSearchPdtCat').val();
  var tCatCat = $('#oetCatCat').val();
  var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
  $.ajax({
    type: "POST",
    url: "masPdtCatDataTable",
    data: {
      tSearchAll: tSearchAll,
      nPageCurrent: nPageCurrent,
      tCatCat: tCatCat
    },
    cache: false,
    Timeout: 0,
    success: function(tResult) {
      if (tResult != "") {
        $('#ostDataPdtCat').html(tResult);
      }
      JSxCatNavDefult();
      JCNxLayoutControll();
      JStCMMGetPanalLangHTML('TCNMPdtCatInfo_L'); //โหลดภาษาใหม่
      JCNxCloseLoading();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Functionality : Call Product Unit Page Add
//Parameters : Event Button Click
//Creator : 13/09/2018 wasin
//Update : 29/03/2019 pap
//Return : View
//Return Type : View
function JSvCallPagePdtCatAdd() {
  JCNxOpenLoading();
  JStCMMGetPanalLangSystemHTML('', '');
  $.ajax({
    type: "POST",
    url: "masPdtCatPageAdd",
    data: {
      tCatCat: $("#oetCatCat").val()
    },
    cache: false,
    timeout: 0,
    success: function(tResult) {
      if (nStaCatBrowseType == 1) {
        $('#odvModalBodyBrowse').html(tResult);
        $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
      } else {
        $('.xCNCatVBrowse').hide();
        $('.xCNCatVMaster').show();
        $('#oliCatTitleEdit').hide();
        $('#oliCatTitleAdd').show();
        $('#odvBtnCatInfo').hide();
        $('#odvBtnAddEdit').show();
      }
      $('#odvContentPagePdtCat').html(tResult);
      $('#ocbCatAutoGenCode').change(function() {
        $("#oetCatCode").val("");
        if ($('#ocbCatAutoGenCode').is(':checked')) {
          $("#oetCatCode").attr("readonly", true);
          $("#oetCatCode").attr("onfocus", "this.blur()");
          $('#odvCatCodeForm').removeClass('has-error');
          $('#odvCatCodeForm em').remove();
        } else {
          $("#oetCatCode").attr("readonly", false);
          $("#oetCatCode").removeAttr("onfocus");
        }
      });
      // $("#oetCatCode").blur(function() {
      //   if (!$('#ocbCatAutoGenCode').is(':checked')) {
      //     if ($("#ohdCheckCatClearValidate").val() == 1) {
      //       $('#ofmAddPdtCat').validate().destroy();
      //       $("#ohdCheckCatClearValidate").val("0");
      //     }
      //     if ($("#ohdCheckCatClearValidate").val() == 0) {
      //       $.ajax({
      //         type: "POST",
      //         url: "CheckInputGenCode",
      //         data: {
      //           tTableName: "TCNMPdtCatInfo",
      //           tFieldName: "FTCatCode",
      //           tCode: $("#oetCatCode").val()
      //         },
      //         cache: false,
      //         timeout: 0,
      //         success: function(tResult) {
      //           var aResult = JSON.parse(tResult);
      //           $("#ohdCheckDuplicateCatCode").val(aResult["rtCode"]);
      //           JSxValidationFormPdtCat("", $("#ohdPdtunitRoute").val());
      //           $('#ofmAddPdtCat').submit();
      //         },
      //         error: function(jqXHR, textStatus, errorThrown) {
      //           JCNxResponseError(jqXHR, textStatus, errorThrown);
      //         }
      //       });
      //     }
      //   }
      // });
      JCNxLayoutControll();
      JCNxCloseLoading();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  })
}

//Functionality : center validate form
//Parameters : function submit name, route
//Creator : 29/03/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxValidationFormPdtCat(pFnSubmitName, ptRoute) {
  $.validator.addMethod('dublicateCode', function(value, element) {
    if (ptRoute == "masPdtCatEventAdd") {
      if ($('#ocbCatAutoGenCode').is(':checked')) {
        return true;
      } else {
        if ($("#ohdCheckDuplicateCatCode").val() == 1) {
          return false;
        } else {
          return true;
        }
      }
    } else {
      return true;
    }
  });

  $('#ofmAddPdtCat').validate({
    rules: {
      oetCatCode: {
        "required": {
          // ตรวจสอบเงื่อนไข validate
          depends: function(oElement) {
            if (ptRoute == "masPdtCatEventAdd") {
              if ($('#ocbCatAutoGenCode').is(':checked')) {
                return false;
              } else {
                return true;
              }
            } else {
              return false;
            }
          }
        },
        "dublicateCode": {}
      },
      oetCatName: {
        "required": {}
      }

    },
    messages: {
      oetCatCode: {
        "required": $('#oetCatCode').attr('data-validate-required'),
        "dublicateCode": $('#oetCatCode').attr('data-validate-dublicateCode')
      },

      oetCatName: {
        "required": $('#oetCatName').attr('data-validate-required')
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
    highlight: function(element, errorClass, validClass) {
      $(element).closest('.form-group').addClass("has-error");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).closest('.form-group').removeClass("has-error");
    },
    submitHandler: function(form) {
      if (pFnSubmitName != "") {
        window[pFnSubmitName](ptRoute);
      }
    }
  });
}

//Functionality : function submit by submit button only
//Parameters : route
//Creator : 29/03/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSubmitEventByButton(ptRoute) {
  if ($("#ohdCheckCatClearValidate").val() == 1) {
    JCNxOpenLoading();
    $.ajax({
      type: "POST",
      url: ptRoute,
      data: $('#ofmAddPdtCat').serialize(),
      cache: false,
      timeout: 0,
      success: function(oResult) {
        if (nStaCatBrowseType != 1) {
          var aReturn = JSON.parse(oResult);
          if (aReturn['nStaEvent'] == 1) {
            switch (aReturn['nStaCallBack']) {
              case '1':
                JSvCallPagePdtCatEdit(aReturn['tCodeReturn']);
                break;
              case '2':
                JSvCallPagePdtCatAdd();
                break;
              case '3':
                JSvCallPagePdtCatList(1);
                break;
              default:
                JSvCallPagePdtCatEdit(aReturn['tCodeReturn']);
            }
          } else {
            JCNxCloseLoading();
            FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
          }
        } else {
          JCNxCloseLoading();
          JCNxBrowseData(tCallCatBackOption);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
    });
  }
}

//Functionality : Call Product Unit Page Edit
//Parameters : Event Button Click
//Creator : 13/09/2018 wasin
//Return : View
//Return Type : View
function JSvCallPagePdtCatEdit(ptCatCode) {
  JCNxOpenLoading();
  JStCMMGetPanalLangSystemHTML('JSvCallPagePdtCatEdit', ptCatCode);
  $.ajax({
    type: "POST",
    url: "masPdtCatPageEdit",
    data: {
      tCatCode: ptCatCode
    },
    cache: false,
    timeout: 0,
    success: function(tResult) {
      if (tResult != '') {
        $('#oliCatTitleAdd').hide();
        $('#oliCatTitleEdit').show();
        $('#odvBtnCatInfo').hide();
        $('#odvBtnAddEdit').show();
        $('#odvContentPagePdtCat').html(tResult);
        $('#oetCatCode').addClass('xCNDisable');
        $('.xCNDisable').attr('readonly', true);
        $('.xCNBtnGenCode').attr('disabled', true);
      }
      JCNxLayoutControll();
      JCNxCloseLoading();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Functionality : set click status submit form from save button
//Parameters : -
//Creator : 26/03/2019 pap
//Return : -
//Return Type : -
function JSxSetStatusClickPdtCatSubmit() {
  $("#ohdCheckCatClearValidate").val("1");
}


//Functionality : Event Add/Edit Product Unit
//Parameters : From Submit
//Creator : 13/09/2018 wasin
//Update : 29/03/2019 pap
//Return : Status Event Add/Edit Product Unit
//Return Type : object
function JSoAddEditPdtCat(ptRoute) {
  // if ($("#ohdCheckCatClearValidate").val() == 1) {
  //   $('#ofmAddPdtCat').validate().destroy();
  //   if (!$('#ocbCatAutoGenCode').is(':checked')) {
  //     $.ajax({
  //       type: "POST",
  //       url: "CheckInputGenCode",
  //       data: {
  //         tTableName: "TCNMPdtCatInfo",
  //         tFieldName: "FTCatCode",
  //         tCode: $("#oetCatCode").val()
  //       },
  //       cache: false,
  //       timeout: 0,
  //       success: function(tResult) {
  //         var aResult = JSON.parse(tResult);
  //         $("#ohdCheckDuplicateCatCode").val(aResult["rtCode"]);
  //         JSxValidationFormPdtCat("JSxSubmitEventByButton", ptRoute);
  //         $('#ofmAddPdtCat').submit();
  //       },
  //       error: function(jqXHR, textStatus, errorThrown) {
  //         JCNxResponseError(jqXHR, textStatus, errorThrown);
  //       }
  //     });
  //   } else {
      JSxValidationFormPdtCat("JSxSubmitEventByButton", ptRoute);
    // }

  // }
}

//Functionality : Generate Code Product Unit
//Parameters : Event Button Click
//Creator : 13/09/2018 wasin
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtCatCode() {
  var tTableName = 'TCNMPdtCat';
  JCNxOpenLoading();
  $.ajax({
    type: "POST",
    url: "generateCode",
    data: {
      tTableName: tTableName
    },
    cache: false,
    timeout: 0,
    success: function(tResult) {
      var tData = $.parseJSON(tResult);
      if (tData.rtCode == '1') {
        $('#oetCatCode').val(tData.rtCatCode);
        $('#oetCatCode').addClass('xCNDisable');
        $('#oetCatCode').attr('readonly', true);
        $('.xCNBtnGenCode').attr('disabled', true);
        $('#oetCatName').focus();
      } else {
        $('#oetCatCode').val(tData.rtDesc);
      }
      JCNxCloseLoading();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
  });
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 13/09/2018 wasin
//Update: 01/04/2019 Pap
//Return : object Status Delete
//Return Type : object
function JSoPdtCatDel(tCurrentPage, tIDCode, tDelName, tYesOnNo) {
  var aData = $('#ohdConfirmIDDelete').val();
  var aTexts = aData.substring(0, aData.length - 2);
  var aDataSplit = aTexts.split(" , ");
  var aDataSplitlength = aDataSplit.length;
  var aNewIdDelete = [];

  if (aDataSplitlength == '1') {
    // $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล : ' + tIDCode+' ('+tDelName+')');
    $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + tDelName + ' ) ' + tYesOnNo);
    $('#odvModalDelPdtCat').modal('show');
    $('#osmConfirm').on('click', function(evt) {

      $.ajax({
        type: "POST",
        url: "masPdtCatEventDelete",
        data: {
          'tIDCode': tIDCode
        },
        cache: false,
        timeout: 0,
        success: function(oResult) {
          var aReturn = JSON.parse(oResult);
          // alert(aReturn['nStaEvent']);
          // if (aReturn['nStaEvent'] == '1'){
          //     $('#odvModalDelPdtCat').modal('hide');
          //     $('#ospConfirmDelete').empty();
          //     localStorage.removeItem('LocalItemData');

          //     setTimeout(function() {
          //         JSvCallPagePdtCatList(tCurrentPage);
          //     }, 500);
          // }else{
          //     JCNxOpenLoading();
          //     alert(aReturn['tStaMessg']);
          // }
          // JSxCatNavDefult();



          if (aReturn['nStaEvent'] == '1') {
            $('#odvModalDelPdtCat').modal('hide');
            $('#ospConfirmDelete').empty();
            localStorage.removeItem('LocalItemData');
            $('#ohdConfirmIDDelete').val('');
            $('#ospConfirmIDDelete').val('');
            setTimeout(function() {
              if (aReturn["nNumRowPdtCAT"] != 0) {
                if (aReturn["nNumRowPdtCAT"] > 10) {
                  nNumPage = Math.ceil(aReturn["nNumRowPdtCAT"] / 10);
                  if (tCurrentPage <= nNumPage) {
                    JSvCallPagePdtCatList(tCurrentPage);
                  } else {
                    JSvCallPagePdtCatList(nNumPage);
                  }
                } else {
                  JSvCallPagePdtCatList(1);
                }
              } else {
                JSvCallPagePdtCatList(1);
              }
            }, 500);
          } else {
            JCNxOpenLoading();
            alert(tData['tStaMessg']);
          }
          JSxCatNavDefult();
        },

        // error: function(data) {
        //     console.log(data)

        error: function(jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
      });
    });
  }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 13/09/2018 wasin
//Update: 01/04/2019 Pap
//Return:  object Status Delete
//Return Type: object

function JSoPdtCatDelChoose() {
  var tCurrentPage = $("#nCurrentPageTB").val();
  JCNxOpenLoading();

  var aData = $('#ohdConfirmIDDelete').val();
  var aTexts = aData.substring(0, aData.length - 2);
  var aDataSplit = aTexts.split(" , ");
  var aDataSplitlength = aDataSplit.length;
  var aNewIdDelete = [];

  for ($i = 0; $i < aDataSplitlength; $i++) {
    aNewIdDelete.push(aDataSplit[$i]);
  }

  if (aDataSplitlength > 1) {

    localStorage.StaDeleteArray = '1';
    $.ajax({
      type: "POST",
      url: "masPdtCatEventDelete",
      data: {
        'tIDCode': aNewIdDelete
      },
      success: function(tResult) {
        var aReturn = JSON.parse(tResult);
        if (aReturn['nStaEvent'] == '1') {
          $('#odvModalDelPdtCat').modal('hide');
          $('#ospConfirmDelete').empty();
          localStorage.removeItem('LocalItemData');
          $('#ohdConfirmIDDelete').val('');
          $('#ospConfirmIDDelete').val('');
          setTimeout(function() {
            if (aReturn["nNumRowPdtCAT"] != 0) {
              if (aReturn["nNumRowPdtCAT"] > 10) {
                nNumPage = Math.ceil(aReturn["nNumRowPdtCAT"] / 10);
                if (tCurrentPage <= nNumPage) {
                  JSvCallPagePdtCatList(tCurrentPage);
                } else {
                  JSvCallPagePdtCatList(nNumPage);
                }
              } else {
                JSvCallPagePdtCatList(1);
              }
            } else {
              JSvCallPagePdtCatList(1);
            }
          }, 500);
        } else {
          JCNxOpenLoading();
          alert(tData['tStaMessg']);
        }
        JSxCatNavDefult();



      },
      error: function(data) {
        console.log(data);
      }
    });


  } else {
    localStorage.StaDeleteArray = '0';

    return false;
  }

}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 13/09/2018 wasin
//Return : View
//Return Type : View
function JSvPdtCatClickPage(ptPage) {
  var nPageCurrent = '';
  switch (ptPage) {
    case 'next': //กดปุ่ม Next
      $('.xWBtnNext').addClass('disabled');
      nPageOld = $('.xWPagePdtCat .active').text(); // Get เลขก่อนหน้า
      nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน

      nPageCurrent = nPageNew
      break;
    case 'previous': //กดปุ่ม Previous
      nPageOld = $('.xWPagePdtCat .active').text(); // Get เลขก่อนหน้า
      nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
      nPageCurrent = nPageNew
      break;
    default:
      nPageCurrent = ptPage
  }
  JCNxOpenLoading();
  JSvPdtCatDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 13/09/2018 wasin
//Return: -
//Return Type: -
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
    if (nNumOfArr > 1) {
      $('.xCNIconDel').addClass('xCNDisabled');
    } else {
      $('.xCNIconDel').removeClass('xCNDisabled');
    }
  }
}



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




//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 13/09/2018 wasin
//Return: -
//Return Type: -

function JSxTextinModal() {
  var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
  if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
    var tTextCode = '';
    for ($i = 0; $i < aArrayConvert[0].length; $i++) {
      tTextCode += aArrayConvert[0][$i].nCode;
      tTextCode += ' , ';
    }
    //Disabled ปุ่ม Delete
    if (aArrayConvert[0].length > 1) {
      $('.xCNIconDel').addClass('xCNDisabled');
    } else {
      $('.xCNIconDel').removeClass('xCNDisabled');
    }

    $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลที่เลือกใช่หรือไม่ ?');
    $('#ohdConfirmIDDelete').val(tTextCode);
  }
}




//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 13/09/2018 wasin
//Return: Duplicate/none
//Return Type: string
function findObjectByKey(array, key, value) {
  for (var i = 0; i < array.length; i++) {
    if (array[i][key] === value) {
      return 'Dupilcate';
    }
  }
  return 'None';
}
