var nStaBdtStaBrowse = $('#nStaBdtStaBrowse').val();
var tCallBdtBackOption = $('#oetBdtCallBackOption').val();
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/


    if (nStaBdtStaBrowse != 1) {
        JSxBDTNavDefult();
        JSvCallPageBDTList();
    } else {
        JSvCallPageBDTAdd();
    }

});

function JSxBDTNavDefult() {
    if (nStaBdtStaBrowse != 1 || nStaBdtStaBrowse == undefined) {
        $('.xCNBnkVBrowse').hide();
        $('.xCNBnkVMaster').show();
        $('#oliBdtEdit').hide();
        $('#oliBdtAdd').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnBdtinfo').show();
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
//Parameters : from ofmAddBdt
//Creator : 10/06/2019 saharat(Golf)
//Return : View
//Return Type : View
function JSnAddEditBdt(ptRoute) {
    // var nAgnStaApv = $('#ocmAgnStaApv').val();
    // var nStaActive = $('#ocmAgnStaActive').val();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddBdt').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "bankdeptypeaddevent") {
                if ($("#oetBdtCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddBdt').validate({
            rules: {
                oetBdtCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "bankdeptypeaddevent") {
                                if ($('#ocbBdtAutoGenCode').is(':checked')) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },
                oetBdtCode: { "required": {} },
                oetBdtName: { "required": {} },

            },
            messages: {
                oetBdtCode: {
                    "required": $('#oetBdtCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetBdtCode').attr('data-validate-dublicateCode')
                },
                oetBdtName: {
                    // "required"     : "กรุณากรอก ชื่อตัวแทนขาย!"
                    "required": $('#oetBdtName').attr('data-validate-required'),
                    "dublicateCode": $('#oetBdtName').attr('data-validate-dublicateCode')
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
                    data: $('#ofmAddBdt').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaBdtStaBrowse != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallEditBdt(aReturn['tCodeReturn'])
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageBDTAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageBDTList();
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




function JSvCallPageBDTAdd() {
    $.ajax({
        type: "GET",
        url: "bankdeptypecallpageadd",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            if (nStaBdtStaBrowse == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('.xCNBnkVBrowse').hide();
                $('.xCNBnkVMaster').show();
                $('#oliBnkTitleEdit').hide();
                $('.xCNBTNPrimeryPlus').show();
                $('#oliBnkTitleAdd').show();
                $('#odvBtnCmpEditInfo').show();
                $('#oliBdtEdit').hide();
                $('#oliBdtAdd').show();
            }

            $('#odvBtnBdtinfo').hide();
            $('#odvContentPageBdt').html(tResult);
        },
        error: function(data) {
            console.log(data);
        }
    });
}





// //Functionality : Call Bank Page Edit
// //Parameters : -
// //Creator : 02/07/2018 krit
// //Return : View
// //Return Type : View
function JSvCallPageBankEdit(ptBdtCode){

    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageBankEdit', ptBdtCode);

    $.ajax({
        type: "POST",
        url: "bankPageEdit",
        data: { tBnkCode: ptBdtCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliBnkTitleAdd').hide();
                $('#oliBnkTitleEdit').show();
                $('#odvBtnBdtInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#banodvContentPageBdt').html(tResult);
                $('#oetBdtCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                $('#oliBdtAdd').hide();
            }

            //Control Event Button
            if ($('#ohdBnkAutStaEdit').val() == 0) {
                $('#obtSubmitBdt').hide();
                $('.xCNUplodeImage').hide();
                $('.xCNIconBrowse').hide();
                $("select").prop('disabled', true);
                $('input').attr('disabled', true);

            }else{

                $('#obtSubmitBdt').show();
                $("select").prop('disabled', false);
                $('input').attr('disabled', false);
            }
            //Control Event Button


            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


function JSvCallPageBDTList() {

    localStorage.tStaPageNow = 'JSvCallPageBDTList';

    $.ajax({
        type: "GET",
        url: "bankdeptypelist",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {

            $('#odvContentPageBdt').html(tResult);
            $('.xCNBTNPrimeryPlus').show();
            $('#oliBdtTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            JSxBDTNavDefult();

            JSvCallPageBDTDataTable(); //แสดงข้อมูลใน List
        },
        error: function(data) {
            console.log(data);
        }
    });

}

function JSvCallPageBDTDataTable(pnPage) {
// alert('test');
    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "bankdeptypedatatable",
        data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
        cache: false,
        timeout: 5000,
        success: function(tResult) {

            $('#odvContentBDTDatatable').html(tResult);

            JSxBDTNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TFNMBnkDepType_L'); //โหลดภาษาใหม่
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

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "bankEventDelete",
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
                        JSvCallPageBDTDataTable(pnPage);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }


        });
    }
}

///function : Function Clear Defult Button Bank
//Parameters : -
//Creator : 11/01/2019 Jame
//Return : -
//Return Type : -
function JSxBDTBtnNavDefult() {
    $('#oliBnkTitleAdd').hide();
    $('#oliBnkTitleEdit').hide();
    $('#odvBtnAddEdit').hide();
    $('.obtChoose').hide();
    // $('#odvBtnBdtInfo').show();
}


// //Functionality : (event) Delete All
// //Parameters :
// //Creator : 04/07/2018 Krit
// //Return :
// //Return Type :
function JSnBankDelChoose(pnPage) {
    JCNxOpenLoading();

    var tNamepage = '';
    var aDataIdBranch = '';
    var nStaBrowse = '';
    var tStaInto = '';
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
            url: "bankdeptypedelevent",
            data: { 'tIDCode': aNewIdDelete  },
            success: function(tResult) {
                tResult = tResult.trim();
                var aReturn = $.parseJSON(tResult);
                $('#odvModalDelBank').modal('hide');
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
                                JSvCallPageBDTDataTable(pnPage);
                            } else {
                                JSvCallPageBDTDataTable(nNumPage);
                            }
                        } else {
                            JSvCallPageBDTDataTable(1);
                        }
                    } else {
                        JSvCallPageBDTDataTable(1);
                    }
                }, 500);
                JCNxCloseLoading();
                JSxBDTNavDefult();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    } else {
        localStorage.StaDeleteArray = '0';

        return false;
    }

}


// Functionality: Event Single Delete Shop Single
// Parameters: Event Icon Delete
// Creator: 27/02/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: object
function JSoBnkDeleteMultiple() {
    var nStaSession = JCNxFuncChkSessionExpired();

    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
      var aDataDelMultiple = $(
        "#odvModalDeleteBnkMultiple #ohdConfirmIDDelMultiple"
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
          url: "bankEventDelete",
          data: { tIDCode: aNewIdDelete },
          async: false,
          cache: false,
          timeout: 0,
          success: function(tResult) {
            var aReturnData = JSON.parse(tResult);
            if (aReturnData["nStaEvent"] == 1) {
              setTimeout(function() {
                $("#odvModalDeleteBnkMultiple").modal("hide");
                $(
                  "#odvModalDeleteBnkMultiple #ospTextConfirmDelMultiple"
                ).empty();
                $("#odvModalDeleteBnkMultiple #ohdConfirmIDDelMultiple").val("");
                localStorage.removeItem("LocalItemData");
                JSvCallPageShopList();
                $(".modal-backdrop").remove();
              });
            } else {
              $("#odvModalDeleteBnkMultiple").modal("hide");
              $("#odvModalDeleteBnkMultiple #ospTextConfirmDelMultiple").empty();
              $("#odvModalDeleteBnkMultiple #ohdConfirmIDDelMultiple").val("");
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
    JSvCallPageBDTDataTable(nPageCurrent);
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
        $('#ohdConfirmIDDelete').val(tTextCode);
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
function JSvSearchAllBdt() {
    var tSearchAll = $('#oetSearchAll').val();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "bankdeptypedatatable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: 1
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#odvContentBDTDatatable').html(tResult);
            }
            JSxBDTBtnNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TFNMBnkDepType_L'); //โหลดภาษาใหม่
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
    JSvCallPageBDTDataTable(nPageCurrent);
}




// //Functionality : (event) Delete
// //Parameters : tBnkCode รหัส Bank
// //Creator :  29/1/2020 nonapwich
// //Return :
//Return Type : Status Number
function JSnBdtdelete(pnPage,ptName,tIDCode) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        $('#odvModalDelBank').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ');
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "bankdeptypedelevent",
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
                        JSvCallPageBDTDataTable(pnPage);
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    }
}

function JSvCallEditBdt(ptBdtCode){
    $('#oliBdtEdit').show();
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "bankdeptypecallpageedit",
                data: { tBdtCode: ptBdtCode },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                // console.log (tResult);
                    if (tResult != "") {
                        $('#oliBnkEdit').show();
                        $('#oliBnkAdd').hide();
                        $('#odvContentPageBdt').html(tResult);
                        $('#oetVatCode').addClass('xCNDisable');
                        $('.xCNiConGen').attr('readonly', true);
                        $('#oetVatCode').attr('readonly', true);
                        $('#odvBtnAgnInfo').hide();
                        $('#odvBtnCmpEditInfo').show();
                        $('#odvBtnBdtinfo').hide();
                        $('.xWVatSave').hide();
                        $('.xWVatCancel').hide();
                        $('#oliBdtAdd').hide();
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
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbBdtIsCreatePage(){
    try{
        const tBdtCode = $('#oetBdtCode').data('is-created');
        var bStatus = false;
        if(tBdtCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbBdtIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbBdtIsUpdatePage(){
    try{
        const tBdtCode = $('#oetBdtCode').data('is-created');
        var bStatus = false;
        if(!tBdtCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbBdtIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxBdtVisibleComponent(ptComponent, pbVisible, ptEffect){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    }catch(err){
        console.log('JSxBdtVisibleComponent Error: ', err);
    }
}
