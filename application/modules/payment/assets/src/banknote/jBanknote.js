var nStaBntBrowseType = $('#oetBntStaBrowse').val();
var tCallBntBackOption = $('#oetBntCallBackOption').val();

$('document').ready(function () {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxBntNavDefult();
    if (nStaBntBrowseType != 1) {
        JSvCallPageBntList(1);
    } else {
        JSvCallPageBntAdd();
    }
});

//function : Function Clear Defult Button Product Brand
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxBntNavDefult() {
    if (nStaBntBrowseType != 1 || nStaBntBrowseType == undefined) {
        $('.xCNChoose').hide();
        $('#oliBntTitleAdd').hide();
        $('#oliBntTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnBntInfo').show();
    } else {
        $('#odvModalBody #odvBntMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliBntNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvBntBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNBntBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNBntBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Call Product Brand Page list  
//Parameters : Document Redy And Event Button
//Creator :	17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageBntList() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        localStorage.tStaPageNow = 'JSvCallPageBntList';
        $('#oetSearchBnt').val('');
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "banknoteList",
            cache: false,
            timeout: 0,
            success: function (tResult) {
                $('#odvContentPageBnt').html(tResult);
                JSvBntDataTable();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//function: Call Product Brand Data List
//Parameters: Ajax Success Event 
//Creator:	17/10/2018 witsarut
//Return: View
//Return Type: View
function JSvBntDataTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        var tSearchAll = $('#oetSearchBnt').val();
        var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
        $.ajax({
            type: "POST",
            url: "banknoteDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function (tResult) {
                if (tResult != "") {
                    $('#ostDataBnt').html(tResult);
                }
                JSxBntNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); //โหลดภาษาใหม่
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

//Functionality : Call Product Brand Page Add  
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageBntAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "banknotePageAdd",
            cache: false,
            timeout: 0,
            success: function (tResult) {
                if (nStaBntBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                } else {
                    $('#oliBntTitleEdit').hide();
                    $('#oliBntTitleAdd').show();
                    $('#odvBtnBntInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageBnt').html(tResult);
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

//Functionality : Call Product Brand Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageBntEdit(ptBntCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageBntEdit', ptBntCode);
        $.ajax({
            type: "POST",
            url: "banknotePageEdit",
            data: { tBntCode: ptBntCode },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                if (tResult != '') {
                    $('#oliBntTitleAdd').hide();
                    $('#oliBntTitleEdit').show();
                    $('#odvBtnBntInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageBnt').html(tResult);
                    $('#oetBntCode').addClass('xCNDisable');
                    $('#oetBntCode').attr('readonly', true);
                    $('#obtGenCodeBnt').attr('disabled', true);
                }
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

var bUniqueBanknoteCode;
$.validator.addMethod(
    "uniqueBanknoteCode",
    function (tValue, oElement, aParams) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBanknoteCode = tValue;
            $.ajax({
                type: "POST",
                url: "banknoteUniqueValidate",
                data: "tBanknoteCode=" + tBanknoteCode,
                dataType: "JSON",
                success: function (poResponse) {
                    bUniqueBanknoteCode = (poResponse.bStatus) ? false : true;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // console.log('Custom validate uniquePromotionCode: ', jqXHR, textStatus, errorThrown);
                },
                async: false
            });
            return bUniqueBanknoteCode;

        } else {
            JCNxShowMsgSessionExpired();
        }

    },
    "Code No. is Already Taken"
);

/**
 * Functionality : Validate Form
 * Parameters : -
 * Creator : 11/06/2020 Piya
 * Return : -
 * Return Type : -
 */
function JSxBanknoteValidateForm(ptRoute) {
    $('#ofmAddBnt').validate({
        focusInvalid: true,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetBntCode: {
                required: true,
                maxlength: 5,
                uniqueBanknoteCode: JSbBntIsCreatePage()
            },
            oetBntName: {
                required: true
            }
        },
        messages: {
            oetBntCode: {
                required: $('#oetBntCode').attr('data-validate-required'),
                uniqueBanknoteCode: $('#oetBntCode').attr('data-validate-dublicateCode')
            },
            oetBntName: {
                required: $('#oetBntName').attr('data-validate-required')
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
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass("has-error");
        },
        submitHandler: function (form) {
            JSoAddEditBnt(ptRoute);
        }
    });
}

//Functionality : Event Add/Edit Product Brand
//Parameters : From Submit
//Creator : 17/10/2018 witsarut
//Return : Status Event Add/Edit Product Brand
//Return Type : object
function JSoAddEditBnt(ptRoute) {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddBnt').serialize(),
            success: function (oResult) {
                if (nStaBntBrowseType == 0) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        switch (aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPageBntEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPageBntAdd();
                                break;
                            case '3':
                                JSvCallPageBntList();
                                break;
                            default:
                                JSvCallPageBntEdit(aReturn['tCodeReturn']);
                        }
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JCNxImgWarningMessage(aReturn['aImgReturn']);
                }
                if (nStaBntBrowseType == 1) {
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallBntBackOption);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxCloseLoading();
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Generate Code Product Brand
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
// function JStGenerateBntCode(){
//     var nStaSession = JCNxFuncChkSessionExpired();
//     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
//         $('#oetBntCode').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
//         $('#oetBntCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
//         var tTableName = 'TFNMBankNote';
//         JCNxOpenLoading();
//         $.ajax({
//             type: "POST",
//             url: "generateCode",
//             data: { tTableName: tTableName },
//             cache: false,
//             timeout: 0,
//             success: function(tResult) {
//                 var tData = $.parseJSON(tResult);
//                 console.log(tData);
//                 if (tData.rtCode == '1') {
//                     $('#oetBntCode').val(tData.rtBntCode);
//                     $('#oetBntCode').addClass('xCNDisable');
//                     $('#oetBntCode').attr('readonly', true);
//                     $('#obtGenCodeBnt').attr('disabled', true); //เปลี่ยน Class ใหม่
//                     $('#oetBntName').focus();
//                 } else {
//                     $('#oetBntCode').val(tData.rtDesc);
//                 }
//                 JCNxCloseLoading();
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 JCNxResponseError(jqXHR, textStatus, errorThrown);
//             }
//         });
//     }else{
//         JCNxShowMsgSessionExpired();
//     }
// }

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 17/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoBntDel(pnPage, ptName, tIDCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == '1') {
            $('#odvModalDelBnt').modal('show');
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' )');
            $('#osmConfirm').on('click', function (evt) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "banknoteEventDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    timeout: 0,
                    success: function (oResult) {
                        var aReturn = JSON.parse(oResult);
                        if (aReturn['nStaEvent'] == 1) {
                            $('#odvModalDelBnt').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function () {
                                if (aReturn["nNumRowBntLoc"] != 0) {
                                    if (aReturn["nNumRowBntLoc"] > 10) {
                                        nNumPage = Math.ceil(aReturn["nNumRowBntLoc"] / 10);
                                        if (pnPage <= nNumPage) {
                                            JSvCallPageBntList(pnPage);
                                        } else {
                                            JSvCallPageBntList(nNumPage);
                                        }
                                    } else {
                                        JSvCallPageBntList(1);
                                    }
                                } else {
                                    JSvCallPageBntList(1);
                                }
                                // JSvBntDataTable(pnPage);
                            }, 500);
                        } else {
                            JCNxCloseLoading();
                            alert(aReturn['tStaMessg']);
                        }
                        JSxBntNavDefult();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 17/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoBntDelChoose(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
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
                url: "banknoteEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function (oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        setTimeout(function () {
                            $('#odvModalDelBnt').modal('hide');
                            JSvBntDataTable(pnPage);
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();

                            if (aReturn["nNumRowBntLoc"] != 0) {
                                if (aReturn["nNumRowBntLoc"] > 10) {
                                    nNumPage = Math.ceil(aReturn["nNumRowBntLoc"] / 10);
                                    if (pnPage <= nNumPage) {
                                        JSvCallPageBntList(pnPage);
                                        console.log(pnPage);
                                    } else {
                                        JSvCallPageBntList(nNumPage);
                                    }
                                } else {
                                    JSvCallPageBntList(1);
                                }
                            } else {
                                JSvCallPageBntList(1);
                            }

                        }, 500);
                    } else {
                        JCNxCloseLoading();
                        alert(aReturn['tStaMessg']);
                    }
                    JSxBntNavDefult();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = '0';
            return false;
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvBntClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageBnt .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageBnt .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvBntDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 11/10/2018 wasin
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
//Creator: 11/10/2018 wasin
//Return: -
//Return Type: -
function JSxPaseCodeDelInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') { } else {
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
//Creator: 17/10/2018 witsarut
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
function JSbBntIsCreatePage() {
    try {
        const tBntCode = $('#oetBntCode').data('is-created');
        var bStatus = false;
        if (tBntCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbBntIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbBntIsUpdatePage() {
    try {
        const tBntCode = $('#oetBntCode').data('is-created');
        var bStatus = false;
        if (!tBntCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbBntIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxBntVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxBntVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbBntIsCreatePage() {
    try {
        const tBntCode = $('#oetBntCode').data('is-created');
        var bStatus = false;
        if (tBntCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbBntIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbBntIsUpdatePage() {
    try {
        const tBntCode = $('#oetBntCode').data('is-created');
        var bStatus = false;
        if (!tBntCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbBntIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxBntVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxBntVisibleComponent Error: ', err);
    }
}




