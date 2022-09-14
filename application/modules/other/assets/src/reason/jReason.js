var nStaRsnBrowseType = $('#oetRsnStaBrowse').val();
var tCallRsnBackOption = $('#oetRsnCallBackOption').val();

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxRsnNavDefult();
    if (nStaRsnBrowseType != 1) {
        JSvCallPageReasonList();
    } else {
        JSvCallPageReasonAdd();
    }
});

///function : Function Clear Defult Button Reason
//Parameters : -
//Creator : 08/05/2018 wasin
//Update:   28/05/2018 wasin
//Return : -
//Return Type : -
function JSxRsnNavDefult() {
    // Menu Bar เข้ามาจาก หน้า Master หรือ Browse
    if (nStaRsnBrowseType != 1) { // เข้ามาจาก  Master
        $('.obtChoose').hide();
        $('#oliRsnTitleAdd').hide();
        $('#oliRsnTitleEdit').hide();
        $('#odvBtnRsnAddEdit').hide();
        $('#odvBtnRsnInfo').show();
    } else { // เข้ามาจาก Browse Modal
        $('#odvModalBody #odvRsnMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliRsnNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvRsnBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNRsnBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNRsnBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

///function : Call Reason Page list  
//Parameters : - 
//Creator:	08/05/2018 wasin
//Update:   28/05/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageReasonList(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        localStorage.tStaPageNow = 'JSvCallPageReasonList';
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "reasonList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageReason').html(tResult);
                JSvReasonDataTable(pnPage);
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

///function : Call Reason Data List
//Parameters : Ajax Success Event 
//Creator:	28/05/2018 wasin
//Update:   
//Return : View
//Return Type : View
function JSvReasonDataTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "reasonDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataReasion').html(tResult);
                }
                JSxRsnNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMRsn_L'); //โหลดภาษาใหม่
                JCNxCloseLoading();
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Call Reason Page Add  
//Parameters : -
//Creator : 09/05/2018 wasin
//Update: 28/05/2018 wasin(yoshi)
//Return : View
//Return Type : View
function JSvCallPageReasonAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "reasonPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaRsnBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                } else {
                    $('.xCNRsnVBrowse').hide();
                    $('.xCNRsnVMaster').show();
                    $('#oliRsnTitleEdit').hide();
                    $('#oliRsnTitleAdd').show();
                    $('#odvBtnRsnInfo').hide();
                    $('#odvBtnRsnAddEdit').show();
                }
                $('#odvContentPageReason').html(tResult);
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Call Reason Page Edit  
//Parameters : -
//Creator: 09/05/2018 wasin(yoshi)
//Update: 28/05/2018 wasin(yoshi)
//Return : View
//Return Type : View
function JSvCallPageReasonEdit(ptRsnCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageReasonEdit', ptRsnCode);
        $.ajax({
            type: "POST",
            url: "reasonPageEdit",
            data: { tRsnCode: ptRsnCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#oliRsnTitleAdd').hide();
                    $('#oliRsnTitleEdit').show();
                    $('#odvBtnRsnInfo').hide();
                    $('#odvBtnRsnAddEdit').show();
                    $('#odvContentPageReason').html(tResult);
                    $('#oetRsnCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    $('.xCNiConGen').attr('disabled', true);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Set Status Click Validate
//Parameters: -
//Creator: 25/03/2019 wasin(Yoshi)
//Return: -
//ReturnType: -
function JSxRsnSetStatusClickSubmit() {
    $("#ohdCheckRsnClearValidate").val("1");
}

//Functionality : (event) Add/Edit Reason
//Parameters : form
//Creator : 09/05/2018 wasin
//Return : object Status Event And Event Call Back
//Return Type : object
function JSnAddEditReason(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddReason').validate().destroy();

        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "reasonEventAdd") {
                if ($("#ohdCheckDuplicateRsnCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');


        $('#ofmAddReason').validate({
            rules: {
                oetRsnCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "reasonEventAdd") {
                                if ($('#ocbReasonAutoGenCode').is(':checked')) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return true;
                            }
                        }
                    }
                },
                oetRsnName: { "required": {} },
                ocmRcnGroup: { "required": {} },
            },
            messages: {
                oetRsnCode: {
                    "required": $('#oetRsnCode').attr('data-validate-required')
                },
                oetRsnName: {
                    "required": $('#oetRsnName').attr('data-validate-required'),
                },
                ocmRcnGroup: {
                    "required": $('#osmSelect').attr('data-validate-required'),
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
                $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            },
            submitHandler: function(form) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddReason').serialize(),
                    async: false,
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaRsnBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageReasonEdit(aReturn['tCodeReturn']);
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageReasonAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageReasonList();
                                }
                            } else {
                                JCNxCloseLoading();
                                $("#odvRsnPopupDupCode #obpMsgApv").text(aReturn['tStaMessg']);
                                $('#odvRsnPopupDupCode').modal("show")
                                // alert(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallRsnBackOption);
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

//Functionality: เปลี่ยนหน้า pagenation
//Parameters: -
//Creator: 09/05/2018 wasin
//Update: 28/05/2018 wasin
//Return: View
//Return Type: View
function JSvClickPage(ptPage) {
    var nPageCurrent = '';
    var nPageNew;
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageReasonGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew;
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageReasonGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew;
            break;
        default:
            nPageCurrent = ptPage;
    }
    JSvReasonDataTable(nPageCurrent);
}

//Functionality: (event) Delete
//Parameters: Button Event [tIDCode รหัสเหตุผล]
//Creator: 10/05/2018 wasin
//Update: 27/08/2019 Saharata(Golf)
//Return: Event Delete Reason List
//Return Type: -
function JSnReasonDel(pnCurrentPage, ptDelName, ptIDCode, ptYesOnNo) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == '1') {
            $('#odvModalDelReason').modal('show');
            // $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode);
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptIDCode + ' ( ' + ptDelName + ' ) ' + ptYesOnNo);
            $('#osmConfirm').on('click', function(evt) {
                if (localStorage.StaDeleteArray != '1') {
                    $.ajax({
                        type: "POST",
                        url: "reasonEventDelete",
                        data: { 'tIDCode': ptIDCode },
                        cache: false,
                        success: function(tResult) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                $('#odvModalDelReason').modal('hide');
                                $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                                $('#ohdConfirmIDDelete').val('');
                                localStorage.removeItem('LocalItemData');
                                $('.modal-backdrop').remove();
                                setTimeout(function() {
                                    if (aReturn["nNumRowRsnLoc"] != 0) {
                                        if (aReturn["nNumRowRsnLoc"] > 10) {
                                            nNumPage = Math.ceil(aReturn["nNumRowRsnLoc"] / 10);
                                            if (pnCurrentPage <= nNumPage) {
                                                JSvCallPageReasonList(pnCurrentPage);
                                            } else {
                                                JSvCallPageReasonList(nNumPage);
                                            }
                                        } else {
                                            JSvCallPageReasonList(1);
                                        }
                                    } else {
                                        JSvCallPageReasonList(1);
                                    }
                                    // JSvBntDataTable(pnPage);
                                    // JSvReasonDataTable(tCurrentPage);
                                }, 500);
                            } else {
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                                //alert(aReturn['tStaMessg']);
                            }
                            JSxRsnNavDefult();
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            });
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : (event) Delete All
//Parameters : Button Event 
//Creator : 10/05/2018 wasin
//Update: 28/05/2018 wasin
//Return : Event Delete All Select List
//Return Type : -
function JSnReasonDelChoose(ptCurrentPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
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
                url: "reasonEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn['nStaEvent'] == '1') {
                        setTimeout(function() {
                            $('#odvModalDelReason').modal('hide');
                            JSvReasonDataTable(ptCurrentPage);
                            $('#ospConfirmDelete').empty();
                            $('#ohdConfirmIDDelete').val();
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            if (aReturn["nNumRowRsnLoc"] != 0) {
                                if (aReturn["nNumRowRsnLoc"] > 10) {
                                    nNumPage = Math.ceil(aReturn["nNumRowRsnLoc"] / 10);
                                    if (ptCurrentPage <= nNumPage) {
                                        JSvCallPageReasonList(ptCurrentPage);
                                    } else {
                                        JSvCallPageReasonList(nNumPage);
                                    }
                                } else {
                                    JSvCallPageReasonList(1);
                                }
                            } else {
                                JSvCallPageReasonList(1);
                            }
                            // JSvBntDataTable(pnPage);
                            // JSvReasonDataTable(tCurrentPage);
                        }, 1000);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JSxRsnNavDefult();
                },
                error: function(data) {
                    console.log(data);
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

//Functionality: Function Show Button Delete All
//Parameters:   Event Parameter
//Creator:  28/05/2018 wasin
//Return: Event Button Delete All
//Return Type: -
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('.obtChoose').hide();
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('.obtChoose').fadeIn(300);
        } else {
            $('.obtChoose').fadeOut(300);
        }
    }
}

//Functionality: Function Insert Text Delete
//Parameters: Event Parameter
//Creator: 28/05/2018 wasin
//Return: Event Insert Text
//Return Type: -
function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];

    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tText = '';
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tName + '(' + aArrayConvert[0][$i].nCode + ') ';
            tText += ' , ';

            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        var tTexts = tText.substring(0, tText.length - 2);
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val() + tTexts);
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}

//Functionality: Function Chack Dupilcate Data
//Parameters: Event Select List Reason
//Creator: 28/05/2018 wasin
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

//Choose Checkbox
function JSxReasonVisibledDelAllBtn(poElement, poEvent) { // Action start after change check box value.
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if (nCheckedCount > 1) {
            $('#oliBtnDeleteAll').removeClass("disabled");
        } else {
            $('#oliBtnDeleteAll').addClass("disabled");
        }
        if (nCheckedCount > 1) {
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('.xCNIconDel').removeClass('xCNDisabled');
        }
    } catch (err) {
        //console.log('JSxDepartmentVisibledDelAllBtn Error: ', err);
    }
}


//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 11/10/2018 wasin
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


// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbReasonIsCreatePage() {
    try {
        const tRsnCode = $('#oetRsnCode').data('is-created');
        var bStatus = false;
        if (tRsnCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbReasonIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbReasonIsUpdatePage() {
    try {
        const tRsnCode = $('#oetRsnCode').data('is-created');
        var bStatus = false;
        if (!tRsnCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbReasonIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxReasonVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxReasonVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbReasonIsCreatePage() {
    try {
        const tRsnCode = $('#oetRsnCode').data('is-created');
        var bStatus = false;
        if (tRsnCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbReasonIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbReasonIsUpdatePage() {
    try {
        const tRsnCode = $('#oetRsnCode').data('is-created');
        var bStatus = false;
        if (!tRsnCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbReasonIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxReasonVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxReasonVisibleComponent Error: ', err);
    }
}