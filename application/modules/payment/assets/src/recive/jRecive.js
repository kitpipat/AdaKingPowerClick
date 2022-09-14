var nStaRcvBrowseType = $('#oetRcvStaBrowse').val();
var tCallRcvBackOption = $('#oetRcvCallBackOption').val();

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');

    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxRCVBtnNavDefult();

    if (nStaRcvBrowseType != 1) {
        JSvCallPageReciveList(1);
    } else {
        JSvCallPageReciveAdd();
    }
});

///function : Function Clear Defult Button Recive
//Parameters : -
//Creator : 11/05/2018 wasin
//Return : -
//Return Type : -
function JSxRCVBtnNavDefult() {


        // Menu Bar เข้ามาจาก หน้า Master หรือ Browse
        if (nStaRcvBrowseType != 1) { // เข้ามาจาก  Master
            $('#oliRcvTitleAdd').hide();
            $('#oliRcvTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnRcvInfo').show();
        } else { // เข้ามาจาก Browse Modal
            $('#odvModalBody #odvRsnMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliRsnNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvRsnBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNRsnBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNRsnBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }


}

///function : Call Recive Page list  
//Parameters : - 
//Creator :	11/05/2018 wasin
//Last Update :28/05/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageReciveList(pnPage) {
    localStorage.tStaPageNow = 'JSvCallPageReciveList'; /* เก็บ Function ไว้ ตอนเปลี่ยนภาษา Edit*/
    $('#oetSearchAll').val('');
    $.ajax({
        type: "POST",
        url: "reciveList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageRecive').html(tResult);
            JSvReciveDataTable(pnPage);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

///function : Call Recive Data List
//Parameters : Ajax Success Event 
//Creator:	28/05/2018 wasin
//Update:   
//Return : View
//Return Type : View
function JSvReciveDataTable(pnPage) {
    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "reciveDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataRecive').html(tResult);
            }
            JSxRCVBtnNavDefult();
            JCNxLayoutControll();
            // JStCMMGetPanalLangHTML('TFNMRcv_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

//Functionality: Search Recive List
//Parameters: tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
//Creator: 11/05/2018 wasin
//Return: View
//Return Type: View
function JSvSearchAllRecive() {
    var tSearchAll = $('#oetSearchAll').val();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "reciveDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: 1
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataRecive').html(tResult);
            }
            JSxRCVBtnNavDefult();
            JCNxLayoutControll();
            // JStCMMGetPanalLangHTML('TFNMRcv_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

//Functionality : Call Recive Page Add  
//Parameters : -
//Creator : 11/05/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageReciveAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "recivePageAdd",
        cache: false,
        success: function(tResult) {
            if (tResult != "") {
   
                
            if (nStaRcvBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('#oliRcvTitleEdit').hide();
                $('#oliRcvTitleAdd').show();
                $('#odvBtnRcvInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageRecive').html(tResult);
            }

            }


            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

//Functionality : Call Recive Page Edit  
//Parameters : -
//Creator : 11/05/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageReciveEdit(ptRcvCode) {

    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageReciveEdit', ptRcvCode);
    $.ajax({
        type: "POST",
        url: "recivePageEdit",
        data: { tRcvCode: ptRcvCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#oliRcvTitleAdd').hide();
                $('#oliRcvTitleEdit').show();
                $('#odvBtnRcvInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageRecive').html(tResult);


                $('#oetRcvCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                $('#obtGenCodeRcv').attr('disabled', true);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

//Functionality : (event) Add/Edit Recive
//Parameters : form
//Creator : 11/05/2018 wasin
//Return : Status Add
//Return Type : n
function JSnAddEditRecive(ptRoute) {
    $('#ofmAddRecive').validate().destroy();
    // $.validator.addMethod('dublicateCode', function(value, element) {
    //     if (ptRoute == 'reciveEventAdd') {
    //         if ($("#ohdCheckDuplicateRcvCode").val() == 1) {
    //             return false;
    //         } else {
    //             return true;
    //         }
    //     } else {
    //         return true;
    //     }
    // }, '');

    $('#ofmAddRecive').validate({
        rules: {
            oetRcvCode: {
                "required": {
                    depends: function(oElement) {
                        if (ptRoute == "reciveEventAdd") {
                            if ($('#ocbReciveAutoGenCode').is(':checked')) {
                                return false;
                            } else {
                                return true;
                            }
                        } else {
                            return true;
                        }
                    }
                },
                // "dublicateCode": {}
            },
            oetRcvName: { "required": {} },
            oetRcvFormatName: { "required": {} },

        },
        messages: {
            oetRcvCode: {
                "required": $('#oetRcvCode').attr('data-validate-required'),
                // "dublicateCode": $('#oetRcvCode').attr('data-validate-dublicateCode')
            },
            oetRcvName: {
                "required": $('#oetRcvName').attr('data-validate-required'),
            },
            oetRcvFormatName: {
                "required": $('#oetRcvFormatName').attr('data-validate-required'),
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
                data: $('#ofmAddRecive').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {

                    if (nStaRcvBrowseType != 1) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                JSvCallPageReciveEdit(aReturn['tCodeReturn']);
                            } else if (aReturn['nStaCallBack'] == '2') {
                                JSvCallPageReciveAdd();
                            } else if (aReturn['nStaCallBack'] == '3') {
                                JSvCallPageReciveList(1);
                            }
                            JCNxImgWarningMessage(aReturn['aImgReturn']);
                        } else {
                            alert(aReturn['tStaMessg']);
                        }
                    } else {
                        JCNxCloseLoading();
                        JCNxBrowseData(tCallRsnBackOption);
                    }

                    

                },
                error: function(data) {
                    console.log(data);
                }
            });
        },
    });
}

//Functionality : Generate Code Recive
//Parameters : -
//Creator : 11/05/2018 wasin
//Return : Data
//Return Type : String
// function JStGenerateReciveCode() {
//     var tTableName = 'TFNMRcv';
//     $.ajax({
//         type: "POST",
//         url: "generateCode",
//         data: { tTableName: tTableName },
//         cache: false,
//         timeout: 0,
//         success: function(tResult) {
//             var tData = $.parseJSON(tResult);
//             if (tData.rtCode == '1') {
//                 $('#oetRcvCode').val(tData.rtRcvCode);
//                 $('#oetRcvCode').addClass('xCNDisable');
//                 $('.xCNDisable').attr('readonly', true);
//                 $('#obtGenCodeRcv').attr('disabled', true);
//                 //----------Hidden ปุ่ม Gen
//                 $('.xCNiConGen').css('display', 'none');
//             } else {
//                 $('#oetRcvCode').val(tData.rtDesc);
//             }
//             $('#oetRcvName').focus();
//         },
//         error: function(data) {
//             console.log(data);
//         }
//     });
// }

//Functionality : Check Recive Code In DB
//Parameters : -
//Creator : 11/05/2018 wasin 
//Return : Status,Message
//Return Type : String
// function JStCheckReciveCode() {
//     tCode = $('#oetRcvCode').val();
//     var tTableName = 'TFNMRcv';
//     var tFieldName = 'FTRcvCode';
//     if (tCode != '') {
//         $.ajax({
//             type: "POST",
//             url: "CheckInputGenCode",
//             data: {
//                 tTableName: tTableName,
//                 tFieldName: tFieldName,
//                 tCode: tCode
//             },
//             cache: false,
//             success: function(tResult) {
//                 var tData = $.parseJSON(tResult);
//                 $('.btn-default').attr('disabled', true);
//                 if (tData.rtCode == '1') { //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
//                     alert('มี id นี้แล้วในระบบ');
//                     JSvCallPageReciveEdit(tCode);
//                 } else {
//                     alert('ไม่พบระบบจะ Gen ใหม่');
//                     JStGenerateReciveCode();
//                 }
//                 $('.wrap-input100').removeClass('alert-validate');
//                 $('.btn-default').attr('disabled', false);
//             },
//             error: function(data) {
//                 console.log(data);
//             }
//         });
//     }
// }

//Functionality : (event) Delete
//Parameters : tIDCod รหัส Recive
//Creator : 14/05/2018 wasin
//Return : 
//Return Type :
function JSnReciveDel(pnPage, ptName, tIDCode, tDel) {

    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        $('#odvModalDelRecive').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ' + tDel);
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "reciveEventDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            $('#odvModalDelRecive').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            tResult = tResult.trim();
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                if (aReturn["nNumRowRcvLoc"] != 0) {
                                    if (aReturn["nNumRowRcvLoc"] > 10) {
                                        nNumPage = Math.ceil(aReturn["nNumRowRcvLoc"] / 10);
                                        if (pnPage <= nNumPage) {
                                            JSvCallPageReciveList(pnPage);
                                        } else {
                                            JSvCallPageReciveList(nNumPage);
                                        }
                                    } else {
                                        JSvCallPageReciveList(1);
                                    }
                                } else {
                                    JSvCallPageReciveList(1);
                                }

                                // JSvReciveDataTable(pnPage)
                            }, 500);
                        } else {
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);
                        }
                        JSxRCVBtnNavDefult();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    }
}

//Functionality : (event) Delete All
//Parameters :
//Creator : 14/05/2018 wasin
//Return :
//Return Type :
function JSnReciveDelChoose(pnPage) {

    var tNamepage = '';
    var aDataIdBranch = '';
    var nStaBrowse = '';
    var tStaInto = '';
    var aData = $('#ohdConfirmIDDelete').val();
    //console.log('DATA : ' + aData);

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
            url: "reciveEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == 1) {
                    setTimeout(function() {
                        $('#odvModalDelRecive').modal('hide');
                        JSvReciveDataTable(pnPage);
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        if (aReturn["nNumRowRcvLoc"] != 0) {
                            if (aReturn["nNumRowRcvLoc"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowRcvLoc"] / 10);
                                if (pnPage <= nNumPage) {
                                    JSvCallPageReciveList(pnPage);

                                } else {
                                    JSvCallPageReciveList(nNumPage);
                                }
                            } else {
                                JSvCallPageReciveList(1);
                            }
                        } else {
                            JSvCallPageReciveList(1);
                        }

                    }, 500);
                } else {
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);
                }
                JSxRCVBtnNavDefult();
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

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 11/05/2018 wasin
//Return : View
//Return Type : View
function JSvClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageRecive .active').text(); // Get เลขก่อนหน้า
            // nPageOld = $('.xWBTNPageActive').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageRecive .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvReciveDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 11/05/2018
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
//Creator: 11/05/2018 wasin
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
//Parameters: Event Select List Reason
//Creator: 11/05/2018 wasin
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








// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbRcvIsCreatePage() {
    try {
        const tRcvCode = $('#oetRcvCode').data('is-created');
        var bStatus = false;
        if (tRcvCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbRcvIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbRcvIsUpdatePage() {
    try {
        const tRcvCode = $('#oetRcvCode').data('is-created');
        var bStatus = false;
        if (!tRcvCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbRcvIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxRcvVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxRcvVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbRcvIsCreatePage() {
    try {
        const tRcvCode = $('#oetRcvCode').data('is-created');
        var bStatus = false;
        if (tRcvCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbRcvIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbRcvIsUpdatePage() {
    try {
        const tRcvCode = $('#oetRcvCode').data('is-created');
        var bStatus = false;
        if (!tRcvCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbRcvIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxRcvVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxRcvVisibleComponent Error: ', err);
    }
}