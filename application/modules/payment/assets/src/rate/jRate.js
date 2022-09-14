var nStaRteBrowseType = $('#oetRteStaBrowse').val();
var tCallRteBackOption = $('#oetRteCallBackOption').val();
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxRTENavDefult();

    if (nStaRteBrowseType != 1) {
        JSvCallPageRateList();
    } else {
        JSvCallPageRateAdd();
    }

});

function JSxRTENavDefult() {
    if (nStaRteBrowseType != 1 || nStaRteBrowseType == undefined) {
        $('.xCNRteVBrowse').hide();
        $('.xCNRteVMaster').show();
        $('#oliRteTitleAdd').hide();
        $('#oliRteTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnRteInfo').show();
    } else {
        $('#odvModalBody .xCNRteVMaster').hide();
        $('#odvModalBody .xCNRteVBrowse').show();
        $('#odvModalBody #odvRteMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliRteNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvRteBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNRteBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNRteBrowseLine').css('border-bottom', '1px solid #e3e3e3');
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


//Functionality : (event) Add/Edit Rate
//Parameters : form
//Creator : 02/07/2018 Krit(Copter)
//Return : Status Add
//Return Type : n
function JSnAddEditRate(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddRate').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "rateEventAdd") {
                if ($("#ohdCheckDuplicateRteCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddRate').validate({
            rules: {
                oetRteCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "rateEventAdd") {
                                if ($('#ocbRateAutoGenCode').is(':checked')) {
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
                oetRteName: { "required": {} },
            },
            messages: {
                oetRteCode: {
                    "required": $('#oetRteCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetRteCode').attr('data-validate-dublicateCode')
                },
                oetRteName: {
                    "required": $('#oetRteName').attr('data-validate-required'),
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
                    type    : "POST",
                    url     : ptRoute,
                    data    : $('#ofmAddRate').serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function(tResult) {
                        if (nStaRteBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageRateEdit(aReturn['tCodeReturn'])
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageRateAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageRateList();
                                }
                                JCNxImgWarningMessage(aReturn['aImgReturn']);
                            } else {
                                alert(aReturn['tStaMessg']);
                            }

                            //Switch Lang
                            //JCNxInsertLangOtherByMaster(aReturn['tCodeReturn']);
                        } else {
                            JCNxBrowseData(tCallRteBackOption);
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

function JSvCallPageRateList() {

    localStorage.tStaPageNow = 'JSvCallPageRateList';

    $.ajax({
        type: "GET",
        url: "rateFormSearchList",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {

            $('#odvContentPageRate').html(tResult);
            JSxRTENavDefult();
            JSvCallPageRateDataTable(); //แสดงข้อมูลใน List
        },
        error: function(data) {
            console.log(data);
        }
    });

}

function JSvCallPageRateDataTable(pnPage) {

    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "rateDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent
        },
        cache: false,
        timeout: 5000,
        success: function(tResult) {

            $('#odvContentRateData').html(tResult);

            JSxRTENavDefult();
            JCNxLayoutControll();
            // JStCMMGetPanalLangHTML('TFNMRate_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();

        },
        error: function(data) {
            console.log(data);
        }
    });
}


//Functionality : Call Credit Page Edit  
//Parameters : -
//Creator : 02/07/2018 krit
//Return : View
//Return Type : View
function JSvCallPageRateAdd() {

    $.ajax({
        type: "GET",
        url: "ratePageAdd",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            if (nStaRteBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('.xCNRteVBrowse').hide();
                $('.xCNRteVMaster').show();
                $('#oliRteTitleEdit').hide();
                $('#oliRteTitleAdd').show();
                $('#odvBtnRteInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#obtBarSubmitRte').show();

            $('#odvContentPageRate').html(tResult);
        },
        error: function(data) {
            console.log(data);
        }
    });
}


//Functionality : Call Credit Page Edit
//Parameters : -
//Creator : 04/07/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvCallPageRateEdit(ptRteCode) {

    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageRateEdit', ptRteCode);

    $.ajax({
        type: "POST",
        url: "ratePageEdit",
        data: { tRteCode: ptRteCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {

            if (tResult != '') {
                $('#oliRteTitleAdd').hide();
                $('#oliRteTitleEdit').show();
                $('#odvBtnRteInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageRate').html(tResult);
                $('#oetRteCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                $('.xCNiConGen').hide();
            }

            //Control Event Button
            if ($('#ohdRteAutStaEdit').val() == 0) {
                $('#obtBarSubmitRte').hide();
                $('.xCNUplodeImage').hide();
                $('.xCNIconBrowse').hide();
                $("select").prop('disabled', true);
                $('input').attr('disabled', true);
            } else {
                $('#obtBarSubmitRte').show();
                $('.xCNUplodeImage').show();
                $('.xCNIconBrowse').show();
                $("select").prop('disabled', false);
                $('input').attr('disabled', false);
            }
            //Control Event Button

            //Check Select By Value
            ohdRteType = $('#ohdRteType').val();
            $("#ocmRteType option[value='" + ohdRteType + "']").attr('selected', true).trigger('change');
            //Check Select By Value


            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}



//Functionality : gen code Branch
//Parameters : -
//Creator : 04/04/2018 Krit(Copter)
//Return : Data
//Return Type : String
function JStBCHGenerateRateCode() {
    JCNxOpenLoading();
    var tTableName = 'TFNMRate';
    $.ajax({
        type: "POST",
        url: "generateCode",
        data: { tTableName: tTableName },
        cache: false,
        success: function(tResult) {

            var tData = $.parseJSON(tResult);
            if (tData.rtCode == '1') {
                $('#oetRteCode').val(tData.rtRteCode);

                $('.xCNDisable').attr('readonly', true);
                $('#oetRteCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);

                //ปุ่ม Gen
                $('.xCNiConGen').css('display', 'none');

            } else {
                $('#oetRteCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
            $('#oetRteName').focus();
        },
        error: function(data) {
            console.log(data);
        }
    });
}


//Functionality : (event) Delete
//Parameters : tIDCode รหัส Rate
//Creator : 03/07/2018 Krit(Copter)
//Last Modified : 12/08/2019 Saharat(Golf)
//Return : JSON
//Return Type : JSON Status Number
function JSnRateDel(pnPage, ptName, tIDCode) {
    var aData = $('#ohdConfirmIDDelete').val();
    var YesOrNot = $('#oetTextComfirmDeleteYesOrNot').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];
    if (aDataSplitlength == '1') {
        $('#odvModalDelRate').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ' + YesOrNot);
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "rateEventDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var aReturn = $.parseJSON(tResult);
                        $('#odvModalDelRate').modal('hide');
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        setTimeout(function() {
                            if (aReturn["nNumRow"] != 0) {
                                if (aReturn["nNumRow"] > 10) {
                                    nNumPage = Math.ceil(aReturn["nNumRow"] / 10);
                                    if (pnPage <= nNumPage) {
                                        JSvCallPageRateDataTable(pnPage);
                                    } else {
                                        JSvCallPageRateDataTable(nNumPage);
                                    }
                                } else {
                                    JSvCallPageRateDataTable(1);
                                }
                            } else {
                                JSvCallPageRateDataTable(1);
                            }
                        }, 500);
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



// //Functionality : (event) Delete All
// //Parameters :
// //Creator : 04/07/2018 Krit
// //Return : 
// //Return Type :
function JSnRateDelChoose(pnPage) {
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
            url: "rateEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                tResult = tResult.trim();
                var aReturn = $.parseJSON(tResult);
                $('#odvModalDelRate').modal('hide');
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
                                JSvCallPageRateDataTable(pnPage);
                            } else {
                                JSvCallPageRateDataTable(nNumPage);
                            }
                        } else {
                            JSvCallPageRateDataTable(1);
                        }
                    } else {
                        JSvCallPageRateDataTable(1);
                    }
                }, 500);
                JCNxCloseLoading();
                JSxRTENavDefult();
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


// //Functionality : เปลี่ยนหน้า pagenation
// //Parameters : -
// //Creator : 02/07/2018 Krit(Copter)
// //Return : View
// //Return Type : View
function JSvRTEClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagingRate .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagingRate .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvCallPageRateDataTable(nPageCurrent);
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
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
            $('.xCNIconDel').removeClass('xCNDisabled');
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



//Functionality: Search Rate List
//Parameters: tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
//Creator: 15/01/2019 Jame
//Return: View
//Return Type: View
function JSvSearchAllRate() {
    var tSearchAll = $('#oetSearchAll').val();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "rateDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: 1
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#odvContentRateData').html(tResult);
            }
            JSxRTENavDefult();
            JCNxLayoutControll();
            // JStCMMGetPanalLangHTML('TFNMRate_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 07/06/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbRateIsCreatePage() {
    try {
        const tRteCode = $('#oetRteCode').data('is-created');
        var bStatus = false;
        if (tRteCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbRateIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 07/06/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbRateIsUpdatePage() {
    try {
        const tRteCode = $('#oetRteCode').data('is-created');
        var bStatus = false;
        if (!tRteCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbRateIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator: 07/06/2019 saharat(Golf)
// Return : -
// Return Type : -
function JSxRateVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxAgencyVisibleComponent Error: ', err);
    }
}