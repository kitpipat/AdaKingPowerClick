var nStaAgnBrowseType = $('#oetANGStaBrowse').val();
var tCallAgnBackOption = $('#oetANGCallBackOption').val();


$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxAGNNavDefult();

    if (nStaAgnBrowseType != 1) {
        JSvCallPageAgencyList();
    } else {
        JSvCallPageAgencyAdd();
    }

});

// Function : controllor NavDefult
// Parameters : -
// Creator :	10/06/2019 saharat(Golf)
// Last Update:	
// Return : 
// Return Type : 
function JSxAGNNavDefult() {
    if (nStaAgnBrowseType != 1 || nStaAgnBrowseType == undefined) {
        $('.xCNCpnVBrowse').hide();
        $('.xCNCpnVMaster').show();
        $('#oliAngTitleAdd').hide();
        $('#oliAgnTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnAgnInfo').show();
    } else {
        $('#odvModalBody .xCNCpnVMaster').hide();
        $('#odvModalBody .xCNCpnVBrowse').show();
        $('#odvModalBody #odvCpnMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliAgnNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvAgnBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNAgnBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNAgnBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function : Call Agency Page list
// Parameters : -
// Creator :	10/06/2019 saharat(Golf)
// Last Update:	
// Return : View
// Return Type : View
function JSvCallPageAgencyList() {
    localStorage.tStaPageNow = 'JSvCallPageCouponList';
    JCNxOpenLoading();
    $.ajax({
        type: "GET",
        url: "agencyList",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            $('#odvContentPageAgency').html(tResult);
            JSxAGNNavDefult();
            JSvCallPageAgencyDataTable(); //แสดงข้อมูลใน List
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Search Agency List
//Parameters: tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
//Creator: 10/06/2019 saharat(Golf)
//Return: View
//Return Type: View
function JSvSearchAllAgency() {
    var tSearchAll = $('#oetSearchAll').val();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "agencyDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: 1
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#odvContentAgencyData').html(tResult);
            }
            JSxAGNNavDefult();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality:
//Parameters: 
//Creator: 10/06/2019 saharat(Golf)
//Return: View
//Return Type: View
function JSvCallPageAgencyDataTable(pnPage) {
    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "agencyDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentAgencyData').html(tResult);
            JSxAGNNavDefult();
            JCNxLayoutControll();
            JCNxCloseLoading();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Credit Page Add  
//Parameters : -
//Creator : 10/06/2019 saharat(Golf)
//Return : View
//Return Type : View
function JSvCallPageAgencyAdd() {
    $.ajax({
        type: "GET",
        url: "agencyPageAdd",
        data: {},
        cache: false,
        timeout: 0,
        success: function(tResult) {
            // if (nStaAgnBrowseType == 1) {
            //     $('.xCNCpnVMaster').hide();
            //     $('.xCNCpnVBrowse').show();
            // } else {
            //     $('.xCNCpnVBrowse').hide();
            //     $('.xCNCpnVMaster').show();
            //     $('#oliAngTitleEdit').hide();
            //     $('#oliAngTitleAdd').show();
            //     $('#odvBtnAgnInfo').hide();
            //     $('#odvBtnAddEdit').show();
            // }

            if (nStaAgnBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('.xCNCpnVBrowse').hide();
                $('.xCNCpnVMaster').show();
                $('#oliAgnTitleEdit').hide();
                $('#oliAngTitleAdd').show();
                $('#odvBtnAgnInfo').hide();
                $('#odvBtnAddEdit').show();
            }

            $('#obtBarSubmitAng').show();
            $('#odvContentPageAgency').html(tResult);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Add Data Agency Add/Edit  
//Parameters : from ofmAddAgn
//Creator : 10/06/2019 saharat(Golf)
//Return : View
//Return Type : View
function JSnAddEditAgency(ptRoute) {
    var nAgnStaApv = $('#ocmAgnStaApv').val();
    var nStaActive = $('#ocmAgnStaActive').val();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddAgn').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "agencyEventAdd") {
                if ($("#ohdCheckDuplicateAgnCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddAgn').validate({
            rules: {
                oetAgnCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "agencyEventAdd") {
                                if ($('#ocbAgencyAutoGenCode').is(':checked')) {
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

                oetAgnName: { "required": {} },
                oetAgnEmail: { "required": {} },
                opwAgnPwd: { "required": {} },
                oetVatRateName:   {"required" :{}},
                oetAgnRteName:    {"required" :{}},
            },
            messages: {
                oetAgnCode: {
                    "required": $('#oetAgnCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetAgnCode').attr('data-validate-dublicateCode')
                },
                oetAgnName: {
                    // "required"     : "กรุณากรอก ชื่อตัวแทนขาย!"
                    "required": $('#oetAgnName').attr('data-validate-required'),
                    "dublicateCode": $('#oetAgnName').attr('data-validate-dublicateCode')
                },
                oetAgnEmail: {
                    // "required"     : "กรุณากรอก อีเมล์!"
                    "required": $('#oetAgnEmail').attr('data-validate-required'),
                    "dublicateCode": $('#oetAgnEmail').attr('data-validate-dublicateCode')
                },
                opwAgnPwd: {
                    // "required"     : "กรุณากรอก รหัสผ่าน!"
                    "required": $('#opwAgnPwd').attr('data-validate-required'),
                    "dublicateCode": $('#opwAgnPwd').attr('data-validate-dublicateCode')
                },
                oetVatRateName : {
                    "required"      : $('#oetVatRateName').attr('data-validate-required'),
                },
                oetAgnRteName : {
                    "required"      : $('#oetAgnRteName').attr('data-validate-required'),
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
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddAgn').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaAgnBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageAgencyEdit(aReturn['tCodeReturn'], nAgnStaApv, nStaActive)
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageAgencyAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageAgencyList();
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                            JCNxImgWarningMessage(aReturn['aImgReturn']);
                        } else {
                            JCNxBrowseData(tCallAgnBackOption);
                        }
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                        JCNxCloseLoading();
                    }
                });
            },
        });
    }
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



// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 07/06/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbAgencyIsCreatePage() {
    try {
        const tAgnCode = $('#oetAgnCode').data('is-created');
        var bStatus = false;
        if (tAgnCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbAgencyIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 07/06/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbAgencyIsUpdatePage() {
    try {
        const tAgnCode = $('#oetAgnCode').data('is-created');
        var bStatus = false;
        if (!tAgnCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbAgencyIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator: 07/06/2019 saharat(Golf)
// Return : -
// Return Type : -
function JSxAgencyVisibleComponent(ptComponent, pbVisible, ptEffect) {
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

//Functionality : Call Agency Page Edit
//Parameters : -
//Creator : 10/06/2019 Saharat(golf)
//Return : View
//Return Type : View
function JSvCallPageAgencyEdit(ptAgnCode, ptStaApv, ptStaActive) {
    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML('JSvCallPageAgencyEdit', ptAgnCode);
    $.ajax({
        type: "POST",
        url: "agencyPageEdit",
        data: { tAgnCode: ptAgnCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliAngTitleAdd').hide();
                $('#oliAgnTitleEdit').show();
                $('#odvBtnAgnInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageAgency').html(tResult);
                $('#oetAgnCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                $('.xCNiConGen').hide();
                $('#ocbAgencyAutoGenCode').attr('disabled', true);
                //Check Select StaApv By Value
                $("#ocmAgnStaApv option[value='" + ptStaApv + "']").attr('selected', true).trigger('change');
                //Check Select StaActive By Value
                $("#ocmAgnStaActive option[value='" + ptStaActive + "']").attr('selected', true).trigger('change');
            }

            //Control Event Button
            if ($('#ohdAngAutStaEdit').val() == 0) {
                $('#obtSubmitAgency').hide();
                $('.xCNUplodeImage').hide();
                $('.xCNIconBrowse').hide();
                $("select").prop('disabled', true);
                $('input').attr('disabled', true);
            } else {

                $('#obtSubmitAgency').show();
                $('.xCNUplodeImage').show();
                $('.xCNIconBrowse').show();
                $("select").prop('disabled', false);
                $('input').attr('disabled', false);
            }
            //Control Event Button

            JCNxLayoutControll();
            // JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 11/06/2019 saharat(Golf)
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
    JSvCallPageAgencyDataTable(nPageCurrent);
}


//Functionality : (event) Delete
//Parameters : tIDCode รหัส Agency
//Creator : 11/06/2019 saharat(Golf)
//Return : 
//Return Type : Status Number
function JSnAgencyDel(tCurrentPage, ptName, tIDCode, tYesOnNo) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        $('#odvModalDelAgency').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ' + tYesOnNo);
        $('#osmConfirm').off('click');
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "agencyEventDelete",
                    data    : { 'tIDCode': tIDCode },
                    cache   : false,
                    success : function(aReturn) {
                        aReturn = aReturn.trim();
                        var aReturn = $.parseJSON(aReturn);
                        if (aReturn['nStaEvent'] == '1') {
                            $('#odvModalDelAgency').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                if (aReturn["nNumRowAgn"] != 0) {
                                    if (aReturn["nNumRowAgn"] > 10) {
                                        nNumPage = Math.ceil(aReturn["nNumRowAgn"] / 10);
                                        if (tCurrentPage <= nNumPage) {
                                            JSvCallPageAgencyDataTable(tCurrentPage);
                                        } else {
                                            JSvCallPageAgencyDataTable(nNumPage);
                                        }
                                    } else {
                                        JSvCallPageAgencyDataTable(1);
                                    }
                                } else {
                                    JSvCallPageAgencyDataTable(1);
                                }
                            }, 500);
                        } else {
                            alert(aReturn['tStaMessg']);
                        }
                        JCNxOpenLoading();
                        JSxAGNNavDefult();
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
//Creator : 11/06/2019 saharat
//Return : 
//Return Type :
function JSnAgencyDelChoose(tCurrentPage) {
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
            url: "agencyEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(aReturn) {
                aReturn = aReturn.trim();
                var aReturn = $.parseJSON(aReturn);
                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelAgency').modal('hide');
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                    setTimeout(function() {
                        if (aReturn["nNumRowAgn"] != 0) {
                            if (aReturn["nNumRowAgn"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowAgn"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvCallPageAgencyDataTable(tCurrentPage);
                                } else {
                                    JSvCallPageAgencyDataTable(nNumPage);
                                }
                            } else {
                                JSvCallPageAgencyDataTable(1);
                            }
                        } else {
                            JSvCallPageAgencyDataTable(1);
                        }
                    }, 500);
                } else {
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);
                }
                JSxAGNNavDefult();
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