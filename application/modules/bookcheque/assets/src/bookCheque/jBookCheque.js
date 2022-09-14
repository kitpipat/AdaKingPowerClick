var nStaBcqBrowseType = $('#oetBcqStaBrowse').val();
var tCallBcqBackOption = $('#oetBcqCallBackOption').val();
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxBCQNavDefult();
    if (nStaBcqBrowseType != 1) {
        JSvBCQCallPageList();
    } else {
        JSvCallPageBCQAdd();
    }

});

function JSxBCQNavDefult() {
    if (nStaBcqBrowseType != 1 || nStaBcqBrowseType == undefined) {
        $('.xCNBnkVBrowse').hide();
        $('.xCNBnkVMaster').show();
        $('#oliBcqEdit').hide();
        $('#oliBcqAdd').hide();
        $('.obtChoose').hide();
        $('#odvBtnChqInfo').show();
        $('#odvBtnCHqAddEdit').hide();
        $('#odvBtnCmpEditInfo').hide();
        
        
       
        
    } else {
        $('#odvModalBody .xCNBnkVMaster').hide();
        $('#odvModalBody .xCNBnkVBrowse').show();
        $('#odvModalBody #odvBnkMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliBnkNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvBnkBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNBnkBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNBnkBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 02/07/2018 wasin
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
    $('#myModal').modal({ show: true });
    $('#odvModalBody').html(tMsgError);
}


//Functionality : Add Data Agency Add/Edit  
//Parameters : from ofmAddBookCheque
//Creator : 10/06/2019 saharat(Golf)
//Last Modified : 09/04/2019 surawat
//Return : View
//Return Type : View
function JSnBCQAddEdit(ptRoute) {

    var nAgnStaApv = $('#ocmAgnStaApv').val();
    var nStaActive = $('#ocmAgnStaActive').val();
    // alert(ptRoute);
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddBookCheque').validate().destroy();
        $('#ofmAddBookCheque').validate({
            rules: {
                oetChqCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "BookChequeAddevent") {
                       
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },
                oetChqCode: { "required": {} },
                oetChqStaPrcDoc : { "required": {} },
                oetChqName: { "required": {} },
                oetBchName: { "required": {} },
                oetBbkName: { "required": {} },
                onbChqMin: { "required": {} },
                onbChqMax: { "required": {} },
                
               
              
            },
            messages: {
                oetChqCode: {
                    "required": $('#oetChqCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetChqCode').attr('data-validate-dublicateCode')
                },
                oetChqStaPrcDoc: {
                    // "required"     : "กรุณากรอก 
                    "required": $('#oetChqStaPrcDoc').attr('data-validate-required'),
                    "dublicateCode": $('#oetChqStaPrcDoc').attr('data-validate-dublicateCode')
                },
                oetChqName: {
                    // "required"     : "กรุณากรอก 
                    "required": $('#oetChqName').attr('data-validate-required'),
                    "dublicateCode": $('#oetChqName').attr('data-validate-dublicateCode')
                },
                oetBchName: {
                    // "required"     : "กรุณากรอก 
                    "required": $('#oetBchName').attr('data-validate-required'),
                    "dublicateCode": $('#oetBchName').attr('data-validate-dublicateCode')
                },

                oetBbkName: {
                    // "required"     : "กรุณากรอก 
                    "required": $('#oetBbkName').attr('data-validate-required'),
                    "dublicateCode": $('#oetBbkName').attr('data-validate-dublicateCode')
                },
                onbChqMin: {
                    // "required"     : "กรุณากรอก 
                    "required": $('#onbChqMin').attr('data-validate-required'),
                    "dublicateCode": $('#onbChqMin').attr('data-validate-dublicateCode')
                },
                onbChqMax: {
                    // "required"     : "กรุณากรอก 
                    "required": $('#onbChqMax').attr('data-validate-required'),
                    "dublicateCode": $('#onbChqMax').attr('data-validate-dublicateCode')
                },

                
          
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
                $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddBookCheque').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        
                        if (nStaBcqBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    // JSvBCQCallEdit(aReturn['tCodeReturn'], nAgnStaApv, nStaActive)
                                    JSvBCQCallEdit(aReturn['tCodeReturn'], aReturn['tBchCodeReturn']);
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageBCQAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvBCQCallPageList();
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxBrowseData(tCallCpnBackOption);
                        }
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }
}

function JSvCallPageBCQAdd() {
    
    // alert('test');
    $.ajax({
        type: "GET",
        url: "BookChequeAddPage",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            if (nStaBcqBrowseType == 1) {
                $('.xCNCpnVMaster').hide();
                $('.xCNCpnVBrowse').show();
               
            } else {

                $('.xCNCpnVBrowse').hide();
                $('.xCNCpnVMaster').show();
                $('#odvBtnAddEdit').show();
                $('#odvBtnCmpEditInfo').show();
                $('#odvBtnChqInfo').hide();
                $('#oliBcqEdit').hide();
                $('#odvBtnCHqAddEdit').show();
              
            }
         
            $('#odvContentPageBookCheque').html(tResult);
        },
        error: function(data) {
            console.log(data);
        }
    });
}


function JSvBCQCallPageList() {

    localStorage.tStaPageNow = 'JSvBCQCallPageList';

    $.ajax({
        type: "GET",
        url: "BookChequeList",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {

            $('#odvContentPageBookCheque').html(tResult);
            $('.xCNBTNPrimeryPlus').show();
            $('#oliBcqAdd').hide();
            $('#oliBcqEdit').hide();
            JSxBCQNavDefult();
        
            JSvCallPageBookChequeDataTable(); //แสดงข้อมูลใน List
        },
        error: function(data) {
            console.log(data);
        }
    });

}

function JSvCallPageBookChequeDataTable(pnPage) {
// alert('test');
    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "BookChequeDatatable",
        data: {            
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            
            $('#odvContentBookChequeDatatable').html(tResult);

            JSxBCQNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TFNMBookCheque_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();

        },
        error: function(data) {
            console.log(data);
        }
    });

}


// //Functionality : (event) Delete
// //Parameters : tIDCode รหัส Bank
// //Creator : 03/07/2018 Krit(Copter)
// //Return : 
//Return Type : Status Number
function JSnBankDel(pnPage,ptName,tIDCode) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelBank').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ');
        $('#osmConfirm').on('click', function(evt) {

            // if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "BookChequeDelevent",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);

                        $('#odvModalDelBank').modal('hide');
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        JSvCallPageBookChequeDataTable(pnPage);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            // }


        });
    }
}

///function : Function Clear Defult Button Bank
//Parameters : -
//Creator : 11/01/2019 Jame
//Return : -
//Return Type : -
function JSxBNKBtnNavDefult() {
    $('#oliBnkTitleAdd').hide();
    $('#oliBnkTitleEdit').hide();
    $('#odvBtnAddEdit').hide();
    $('.obtChoose').hide();
    $('#odvBtnBnkInfo').show();
}



// //Functionality : (event) Delete All
// //Parameters :
// //Creator : 04/07/2018 Krit
// Last Modified : 09/04/2019 surawat
// //Return : 
// //Return Type :
function JSnBCQDelChoose(pnPage) {
    JCNxOpenLoading();
    var tNamepage = '';
    var aDataIdBranch = '';
    var nStaBrowse = '';
    var tStaInto = '';
    var aData = $('#ohdConfirmIDDelete').val();
    
    // var aTexts = aData.substring(0, aData.length - 2);
    // var aDataSplit = aTexts.split(" , ");
    // var aDataSplitlength = aDataSplit.length;
    // console.log(aData);
    var aChqChosenData = JSON.parse(aData);

    var aNewIdDelete = [];

    for (var i = 0; i < aChqChosenData.length; i++) {
        aNewIdDelete.push({
            'tIDCode': aChqChosenData[i]['nCode'],
            'tBchCode': aChqChosenData[i]['tBchCode']
        });
    }
    // console.log(aNewIdDelete);
    // return;
    // if (aDataSplitlength > 1) {
    if(aNewIdDelete.length > 0) {

        // localStorage.StaDeleteArray = '1';

        $.ajax({
            type: "POST",
            url: "BookChequeDelevent",
            //data: { 'tIDCode': aNewIdDelete  },
            data: { 'aChqDataToDelete': aNewIdDelete  },
            success: function(tResult) {
                
                tResult = tResult.trim();
                var aReturn = $.parseJSON(tResult);
                $('#odvModalDelChq').modal('hide');
                $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                $('#ohdConfirmIDDelete').val('');
                localStorage.removeItem('LocalItemData');
                $('.obtChoose').hide();
                $('.modal-backdrop').remove();
                //เช็คแถวข้อมูล ว่า <= 10 ไหมถ้าน้อยกว่า 10 ให้ กลับไปหน้า ก่อนหน้า
                setTimeout(function() {
                    if (aReturn["nNumRow"] != 0) {
                        if (aReturn["nNumRow"] > 10) {
                            nNumPage = Math.ceil(aReturn["nNumRow"] / 10);
                            if (pnPage <= nNumPage) {
                                JSvCallPageBookChequeDataTable(pnPage);
                            } else {
                                JSvCallPageBookChequeDataTable(nNumPage);
                            }
                        } else {
                            JSvCallPageBookChequeDataTable(1);
                        }
                    } else {
                        JSvCallPageBookChequeDataTable(1);
                    }
                }, 500);
                JCNxCloseLoading();
                JSxBCQNavDefult();
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    } else {
        // localStorage.StaDeleteArray = '0';

        return false;
    }

}



// Functionality: Event Single Delete Shop Single
// Parameters: Event Icon Delete
// Creator: 27/02/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: object
function JSoChqDeleteMultiple() {
    var nStaSession = JCNxFuncChkSessionExpired();
    
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
      var aDataDelMultiple = $(
        "#odvModalDeleteChqMultiple #ohdConfirmIDDelMultiple"
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
        // localStorage.StaDeleteArray = "1";
        $.ajax({
          type: "POST",
          url: "BookChequeDelevent",
          data: { tIDCode: aNewIdDelete },
          async: false,
          cache: false,
          timeout: 0,
          success: function(tResult) {
            var aReturnData = JSON.parse(tResult);
            if (aReturnData["nStaEvent"] == 1) {
              setTimeout(function() {
                $("#odvModalDeleteChqMultiple").modal("hide");
                $(
                  "#odvModalDeleteChqMultiple #ospTextConfirmDelMultiple"
                ).empty();
                $("#odvModalDeleteChqMultiple #ohdConfirmIDDelMultiple").val("");
                localStorage.removeItem("LocalItemData");
                JSvCallPageShopList();
                $(".modal-backdrop").remove();
              });
            } else {
              $("#odvModalDeleteChqMultiple").modal("hide");
              $("#odvModalDeleteChqMultiple #ospTextConfirmDelMultiple").empty();
              $("#odvModalDeleteChqMultiple #ohdConfirmIDDelMultiple").val("");
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

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 02/07/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvBNKClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageBank .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageBank .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvCallPageBookChequeDataTable(nPageCurrent);
}



//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 15/05/2018
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
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 15/05/2018 wasin
// Last Modified : 09/04/2019 surawat
//Return: -
//Return Type: -
function JSxPaseCodeDelInModal() {

    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
    }
    $('#ohdConfirmIDDelete').val(localStorage.getItem("LocalItemData")); // เก็บเป็น json array เลย 09/04/2019 surawat
    //console.log($('#ohdConfirmIDDelete').val());
}


//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 06/06/2018 Krit
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

//Functionality: Search Bank List
//Parameters: tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
//Creator: 11/01/2019 Jame
//Return: View
//Return Type: View
function JSvSearchAllChq() {
    var tSearchAll = $('#oetSearchAll').val();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "BookChequeDatatable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: 1
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#odvContentBookChequeDatatable').html(tResult);
            }
            JSxBCQNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TFNMBookCheque_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(data) {
            console.log(data);
        }
    });
}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 18/06/2019 saharat(Golf)
//Return : View
//Return Type : View
function JSvCPNClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvCallPageBookChequeDataTable(nPageCurrent);
}




// //Functionality : (event) Delete
// //Parameters : tBnkCode รหัส Bank
// //Creator :  29/1/2020 nonapwich
// Last Modified : 09/04/2019 surawat
// //Return : 
//Return Type : Status Number
function JSnBCqdelete(pnPage,ptName,tIDCode, ptBchName, ptBchCode) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        $('#odvModalDelChq').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ' + ptBchName);
        
        //ปุ่มosmConfirmDelete1 _จะแสดงเมื่อกดปุ่มถังขยะที่อยู่ท้ายรายการเชคเท่านั้น ที่เหลือจะแสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น 09/04/2020 surawat
        $('#osmConfirm').hide();
        $('#osmConfirmDelete1').show();
        $('#osmConfirmDelete1').off("click"); //ล้าง event เก่าก่อน 09/04/2020 surawat
        //end ปุ่มosmConfirmDelete1 _จะแสดงเมื่อกดปุ่มถังขยะที่อยู่ท้ายรายการเชคเท่านั้น ที่เหลือจะแสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น 09/04/2020 surawat
        $('#osmConfirmDelete1').on('click', function(evt) {
            // if (localStorage.StaDeleteArray != '1') {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "BookChequeDelevent",
                    data:   { 
                                'tIDCode': tIDCode,
                                'tBchCode': ptBchCode
                            },
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);
                        $('#odvModalDelChq').modal('hide');
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        JSvCallPageBookChequeDataTable(pnPage);
                        JCNxCloseLoading();
                        //แสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น 09/04/2020 surawat
                        $('#osmConfirmDelete1').hide();
                        $('#osmConfirm').show();
                        //แสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น 09/04/2020 surawat
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        //แสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น 09/04/2020 surawat
                        $('#osmConfirmDelete1').hide();
                        $('#osmConfirm').show();
                        //แสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น 09/04/2020 surawat
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            // }
        });
    }
}

function JSvBCQCallEdit(ptChqCode, ptBchCode){

    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "BookChequeUpdatPage",
                data: { tChqCode: ptChqCode,
                        tBchCode: ptBchCode},
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                   
                        $('#oliBcqEdit').show();
                        $('#oliBcqAdd').hide();
                        $('#odvContentPageBookCheque').html(tResult);
                        $('#oetVatCode').addClass('xCNDisable');
                        $('.xCNiConGen').attr('readonly', true);
                        $('#oetVatCode').attr('readonly', true);
                        $('#odvBtnChqInfo').hide();
                        $('#odvBtnCHqAddEdit').show();
                        
                        $('.xWVatSave').hide();
                        $('.xWVatCancel').hide();
                    }
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
    } catch (err) {
        console.log('JSvCallPageVatrateEdit Error: ', err);
    }

}


// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 07/06/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbBookChequeIsCreatePage() {
    try {
        const tChqCode = $('#oetChqCode').data('is-created');
        var bStatus = false;
        if (tChqCode == "") { // No have data
            bStatus = true;
        }
        // alert(bStatus);
        return bStatus;
    } catch (err) {
        console.log('JSbBookChequeIsCreatePage Error: ', err);
    }
}


// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator: 07/06/2019 saharat(Golf)
// Return : -
// Return Type : -
function JSxBookChequeVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {

            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxBookChequeVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 07/06/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSBookChequeIsUpdatePage() {
    try {
        const tChqCode = $('#oetChqCode').data('is-created');
        var bStatus = false;
        if (!tChqCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSBookChequeIsUpdatePage Error: ', err);
    }
}



function JSvBCQCallEdits(ptChqCode){

    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "BookChequeUpdatPage",
                data: { tChqCode: ptChqCode },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                   
                        $('#oliBnkEdit').show();
                        $('#oliBnkAdd').hide();
                        $('#odvContentPageBank').html(tResult);
                        $('#oetVatCode').addClass('xCNDisable');
                        $('.xCNiConGen').attr('readonly', true);
                        $('#oetVatCode').attr('readonly', true);
                        $('#odvBtnAgnInfo').hide();
                        $('#odvBtnCmpEditInfo').show();
                        
                        $('.xWVatSave').hide();
                        $('.xWVatCancel').hide();
                    }
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
    } catch (err) {
        console.log('JSvCallPageVatrateEdit Error: ', err);
    }

}
