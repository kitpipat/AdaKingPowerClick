var nStaZneBrowseType = $('#oetZneStaBrowse').val();
var tCallZneBackOption = $('#oetZneCallBackOption').val();
var tGetCurrentvalidate = 0;

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxZNENavDefult();
    if (nStaZneBrowseType != 1) {
        JSvCallPageZoneList(1);
    } else {
        JSvCallPageZoneAdd();
    }
});

function JSxZNENavDefult() {
    if (nStaZneBrowseType != 1) {
        $('#oliZneAdd').hide();
        $('#oliZneEdit').hide();
        $('#odvBtnZneEditInfo').hide();
        $('#odvBtnZneInfo').show();
        $('#odvBtnShpInfo').hide();
        $('.obtChoose').hide();
    } else {
        $('#odvModalBody #odvZneMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliZneNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvZneBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNZneBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNZneBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function : Call Reason Pagelist
// Parameters : tSearchAll : ข้อความที่ใช้ค้นหา , nPageCurrent = 1 Refresh หน้า
// Last Update: 29/06/2018 wasin [ปรับรองรับการเพิ่มข้อมูลผ่านหน้า Browse]
// Creator :
// Return : View
// Return Type : View
function JSvCallPageZoneList(nPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        localStorage.tStaPageNow = 'JSvCallPageZoneList';
        JCNxOpenLoading();
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "zoneList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageZone').html(tResult);
                JSvZoneDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function : Call Zone Data List
// Parameters : Ajax Success Event 
// Creator:	05/06/2018 Krit
// Last Update: 29/06/2018 wasin [ปรับรองรับการเพิ่มข้อมูลผ่านหน้า Browse]
// Return : View
// Return Type : View
function JSvZoneDataTable(pnPage) {
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
            url: "zoneDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataZone').html(tResult);
                }
                JSxZNENavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMZone_L'); //โหลดภาษาใหม่
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

//Functionality : Call Reason PageAdd
//Parameters : function Parameters
//Last Update: 29/06/2018 wasin [ปรับรองรับการเพิ่มข้อมูลผ่านหน้า Browse]
//Creator :
//Return : View
//Return Type : View
function JSvCallPageZoneAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "zonePageAdd",
            data: {
                tTypePage: 'Add',
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaZneBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                } else {

                    $('#oliZneAdd').show();
                    $('#oliZneEdit').hide();
                    $('#odvBtnZneInfo').hide();
                    $('#odvBtnZneEditInfo').show();
                }

                $('#odvContentPageZone').html(tResult);
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


//Functionality : Call Reason PageEdit
//Parameters : function Parameters
//Creator : 27/03/2018 Krit
//Last Update: 29/06/2018 wasin [ปรับรองรับการเพิ่มข้อมูลผ่านหน้า Browse]
//Return : View
//Return Type : View
function JSvCallPageZoneEdit(ptZneCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageZoneEdit', ptZneCode);
        $.ajax({
            type: "POST",
            url: "zonePageEdit",
            data: {
                tZneCode: ptZneCode,
                tTypePage: 'edit'
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#odvContentPageZone').html(tResult);
                    $('#oliZneAdd').hide();
                    //Check box 
                    ohdZneParent = $('#ohdZneParent').val();
                    if (ohdZneParent == '') {
                        $('#ocbSelectRoot').prop('checked', true);
                        $('.xWPanalZneChain').hide();
                    } else {
                        $('.xWPanalZneChain').show();
                    }
                    //Disabled input 
                    $('#oetZneCodeTab2').addClass('xCNCursorNotAlw').attr('readonly', true);
                    $('#oetZneCodeTab2').addClass('xCNDisable');

                    $('#oetZneName').addClass('xCNCursorNotAlw').attr('readonly', true);
                    $('#oetZneName').addClass('xCNDisable');

                    $('#oetZneCode').addClass('xCNCursorNotAlw').attr('readonly', true);
                    $('#oetZneCode').addClass('xCNDisable');

                    $('#oliZneAdd').hide();
                    $('#oliZneEdit').show();
                    $('#odvBtnZneInfo').hide();
                    $('#odvBtnZneEditInfo').show();
                    $('#obtBarBack').show();

                    $('.xCNBtnGenCode').attr('disabled', true);
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
}

//Functionality : (event) Add/Edit Reason
//Parameters : form
//Creator : 27/03/2018 Krit
//Last Update: 29/08/2019 Saharat(Golf)
//Return : Status Add
//Return Type : n
function JSnAddEditZone(tRouteEvent) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddZone').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (tRouteEvent == "zoneEventAdd") {
                if ($("#ohdCheckDuplicateZneCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddZone').validate({
            rules: {
                oetZneCode: {
                    "required": {
                        depends: function(oElement) {
                            if (tRouteEvent == "zoneEventAdd") {
                                if ($('#ocbZoneAutoGenCode').is(':checked')) {
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

                oetZneName: { "required": {} },
                oetZneParent: { "required": {} },
                oetZneParentName: { "required": {} },
                oetZneNameTab1: { "required": {} },
                oetZneNameOldTab1: { "required": {} },
            },
            messages: {
                oetZneCode: {
                    "required": $('#oetZneCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetZneCode').attr('data-validate-dublicateCode')
                },
                oetZneName: {
                    "required": $('#oetZneName').attr('data-validate-required'),
                    "dublicateCode": $('#oetZneName').attr('data-validate-dublicateCode')
                },
                oetZneParent: {
                    "required": $('#oetZneParent').attr('data-validate-required'),
                    "dublicateCode": $('#oetZneParent').attr('data-validate-dublicateCode')
                },
                oetZneParentName: {
                    "required": $('#oetZneParentName').attr('data-validate-required'),
                    "dublicateCode": $('#oetZneParentName').attr('data-validate-dublicateCode')
                },
                oetZneNameTab1: {
                    "required": $('#oetZneNameTab1').attr('data-validate-required'),
                    "dublicateCode": $('#oetZneNameTab1').attr('data-validate-dublicateCode')
                },

                oetZneNameOldTab1: {
                    "required": $('#oetZneNameOldTab1').attr('data-validate-required'),
                    "dublicateCode": $('#oetZneNameOldTab1').attr('data-validate-dublicateCode')
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
                // JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: tRouteEvent,
                    data: $("#ofmAddZone").serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        var aDataReturn = JSON.parse(tResult);
                        if (aDataReturn['nStaEvent'] == 1) {
                            var tZneCode = aDataReturn['tCodeReturn'];

                            switch (aDataReturn['nStaCallBack']) {
                                case '1':
                                    /*บีนทึกแล้วดู*/
                                    JSvCallPageZoneEdit(tZneCode);
                                    break;
                                case '2':
                                    /*บีนทึกแล้วสร้างใหม่*/
                                    JSvCallPageZoneAdd();
                                    break;
                                case '3':
                                    /*บีนทึกแล้วกลับไปหน้า List*/
                                    JSvCallPageZoneList();
                                    break;
                                default:
                            }
                        } else {
                            FSvCMNSetMsgErrorDialog(aDataReturn['tStaMessg']);
                        }
                        // JCNxCloseLoading();
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

//Functionality : (event) Delete แบบ ID 1 ตัว
//Parameters : tIDCode รหัส
//Creator : 10/5/2018 Krit(Copter)
//Return : -
//Return Type : n
function JSnZoneDel(pnPage, ptName, tIDCode, ptConfirm) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == '1') {
            $('#odlmodaldelete').modal('show');
            // $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ptConfirm);
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ' + ptConfirm);
            $('#osmConfirm').on('click', function(evt) {
                if (localStorage.StaDeleteArray != '1') {
                    $.ajax({
                        type: "POST",
                        url: "zoneEventDelete",
                        data: { 'tIDCode': tIDCode },
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            tResult = tResult.trim();
                            var aReturn = JSON.parse(tResult);
                            $('#odlmodaldelete').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                if (aReturn["nNumRowZneLoc"] != 0) {
                                    if (aReturn["nNumRowZneLoc"] > 10) {
                                        nNumPage = Math.ceil(aReturn["nNumRowZneLoc"] / 10);
                                        if (pnPage <= nNumPage) {
                                            JSvCallPageZoneList(pnPage);
                                        } else {
                                            JSvCallPageZoneList(nNumPage);
                                        }
                                    } else {
                                        JSvCallPageZoneList(1);
                                    }
                                } else {
                                    JSvCallPageZoneList(1);
                                }
                                // JSvZoneDataTable(pnPage);
                            }, 1000);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            });
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}



//Functionality : (event) Delete แบบ เลือก Id หลายตัว ส่งค่า Array ไปลบ 
//Parameters : tIDCode รหัส
//Creator : 10/05/2018 Krit(Copter)
//Return : -
//Return Type : n
function JSnZoneDelChoose(pnPage) {
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
                url: "zoneEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                timeout: 0,
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    setTimeout(function() {
                        $('#odlmodaldelete').modal('hide');
                        JSvZoneDataTable(pnPage);
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();

                        if (aReturn["nNumRowZneLoc"] != 0) {
                            if (aReturn["nNumRowZneLoc"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowZneLoc"] / 10);
                                if (pnPage <= nNumPage) {
                                    JSvCallPageZoneList(pnPage);
                                } else {
                                    JSvCallPageZoneList(nNumPage);
                                }
                            } else {
                                JSvCallPageZoneList(1);
                            }
                        } else {
                            JSvCallPageZoneList(1);
                        }

                    }, 1000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
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
//Parameters : -
//Creator : 27/03/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWZNEPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWZNEPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvZoneDataTable(nPageCurrent);
}

//Functionality : gen code Branch
//Parameters : -
//Creator : 04/04/2018 Krit(Copter)
//Return : Data
//Return Type : String
function JStGenerateZoneCode() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#oetZneCode').closest('.form-group').addClass("has-success").removeClass("has-error");
        $('#oetZneCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
        JCNxOpenLoading();
        var tTableName = 'TCNMZone';
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var tData = $.parseJSON(tResult);
                if (tData.rtCode == '1') {
                    $('#oetZneCode').val(tData.rtZneCode);
                    $('#oetZneCode').addClass('xCNDisable');
                    $('#oetZneCode').attr('readonly', true);
                    $('.xCNiConGen').attr('disabled', true); //เปลี่ยน Class ใหม่

                } else {
                    $('#oetZneCode').val(tData.rtDesc);
                }
                JCNxCloseLoading();
                //$('#ocmZneName').focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Check ค่าจาก input ส่วไป Check ใน Base ว่ามี ค่านี้อยู่หรือไม่
//Parameters : -
//Creator : 18/04/2018 Krit(Copter)
//Return : Status,Message
//Return Type : String
function JStCheckZoneCode() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        tCode = $('#oetZneCode').val();
        var tTableName = 'TCNMZone';
        var tFieldName = 'FTZneCode';
        if (tCode != '') {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: tTableName,
                    tFieldName: tFieldName,
                    tCode: tCode
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var tData = $.parseJSON(tResult);
                    $('.btn-default').attr('disabled', true);
                    //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
                    if (tData.rtCode == '1') {
                        alert('มี id นี้แล้วในระบบ');
                        JSvCallPageZoneEdit(tCode);
                    } else {
                        alert('ไม่พบระบบจะ Gen ใหม่');
                        JStGenerateZoneCode();
                    }
                    $('.wrap-input100').removeClass('alert-validate');
                    $('.btn-default').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            alert('กรุณากรอก Code');
            $('.btn-default').attr('disabled', true);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
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
        if (nNumOfArr > 1) {
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('.xCNIconDel').removeClass('xCNDisabled');
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
function JSbZoneIsCreatePage() {
    try {
        const tZneCode = $('#oetZneCode').data('is-created');
        var bStatus = false;
        if (tZneCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbZoneIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 07/06/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbZoneIsUpdatePage() {
    try {
        const tZneCode = $('#oetZneCode').data('is-created');
        var bStatus = false;
        if (!tZneCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbZoneIsUpdatePage Error: ', err);
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




//Functionality : (event) AddRefer Zone
//Parameters : form
//Creator : 14/06/2019 saharat
//Last : - 
//Return : Status Add
//Return Type : n
function JSnAddReferZone() {
    $('#ofmAddReferzone').validate({
        rules: {
            ocmTypeRefer: "required",
            oetZneBchName: "required",
            oetZneUSerName: "required",
            oetZneSpnName: "required",
            oetZneShopName: "required",
            oetZnePosName: "required",
        },
        messages: {

            ocmTypeRefer: {
                // "required": "กรุณาเลือก ประเภทข้อมูลอ้างอิง!" 
                "required": $('#ocmTypeRefer').attr('data-validate-required'),
                "dublicateCode": $('#ocmTypeRefer').attr('data-validate-dublicateCode')
            },
            oetZneBchName: {
                // "required": "กรุณาเลือก ข้อมูลอ้างอิง!" 
                "required": $('#oetZneBchName').attr('data-validate-required'),
                "dublicateCode": $('#oetZneBchName').attr('data-validate-dublicateCode')
            },
            oetZneUSerName: {
                // "required": "กรุณาเลือก ข้อมูลอ้างอิง!" 
                "required": $('#oetZneUSerName').attr('data-validate-required'),
                "dublicateCode": $('#oetZneUSerName').attr('data-validate-dublicateCode')
            },
            oetZneSpnName: {
                // "required": "กรุณาเลือก ข้อมูลอ้างอิง!" 
                "required": $('#oetZneSpnName').attr('data-validate-required'),
                "dublicateCode": $('#oetZneSpnName').attr('data-validate-dublicateCode')
            },
            oetZneShopName: {
                // "required": "กรุณาเลือก ข้อมูลอ้างอิง!" 
                "required": $('#oetZneShopName').attr('data-validate-required'),
                "dublicateCode": $('#oetZneShopName').attr('data-validate-dublicateCode')
            },
            oetZnePosName: {
                // "required": "กรุณาเลือก ข้อมูลอ้างอิง!" 
                "required": $('#oetZnePosName').attr('data-validate-required'),
                "dublicateCode": $('#oetZnePosName').attr('data-validate-dublicateCode')
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
                url: "zoneEvenAddRefer",
                data: $('#ofmAddReferzone').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var tData = $.parseJSON(tResult);
                    if (tData.nStaEvent == '1') {

                        // $('#oetZneBchName').val('');
                        $('#oetZneBchCode').val('');
                        $('#oetZneUSerCode').val('');
                        $('#oetZneUSerName').val('');
                        $('#oetZneSpnCode').val('');
                        $('#oetZneSpnName').val('');
                        $('#oetZneShopCode').val('');
                        $('#oetZneShopName').val('');
                        $('#oetZnePosCode').val('');
                        $('#oetZnePosName').val('');
                        $('#oetKeyReferName').val('');

                        $("#ocmTypeRefer").val('TCNMBranch').selectpicker("refresh");
                        $('#odvZneBranch').show();
                        $('#odvZneUSer').hide();
                        $('#odvZneSaleMan').hide();
                        $('#odvZneShop').hide();
                        $('#odvZnePos').hide();
                        JSvZoneObjDataTable(1);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }

    });
}


//Functionality: load page ZoneRefer
//Parameters: 
//Creator: 17/06/2019 saharat(Golf)
//Return: View
//Return Type: View
function JSvCallPageZoneReferDataTable(pnPage) {
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "zoneReferTable",
        data: {
            nPageCurrent: nPageCurrent
        },
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            $('#odvContentZoneObjData').html(tResult);
            JSxZNENavDefult();
            JCNxLayoutControll();
            JCNxCloseLoading();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function : Call ZoneObj Data List
// Parameters : Ajax Success Event 
// Creator:	05/06/2018 Krit
// Last Update: 29/06/2018 wasin [ปรับรองรับการเพิ่มข้อมูลผ่านหน้า Browse]
// Return : View
// Return Type : View
function JSvZoneObjDataTable(pnPage) {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    var nZneCode = $('#oetZneChainOld').val();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        $.ajax({
            type: "POST",
            url: "zoneReferTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
                nZneCode: nZneCode,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#odvContentZoneObjData').html(tResult);
                    //    if(){
                    //เช็คtr  ในตาราง ว่ามีข้อมูลไหม
                    //    } 


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
}

//Functionality : (event) Delete ZoneRefer
//Parameters : tIDCode รหัส ZoneRefer
//Creator : 11/06/2019 saharat(Golf)
//Return : 
//Return Type : Status Number
function JSnZoneObjDel(tCurrentPage, ptName, tIDCode, tTable, tYesOnNo) {
    var tZneChain = $('#oetZneChainOld').val();
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        $('#odvModalDelZoneObj').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ' + tYesOnNo);
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "zoneReferEventDelete",
                    data: {
                        'tIDCode': tIDCode,
                        'tTable': tTable,
                        'tZneChain': tZneChain

                    },
                    cache: false,
                    success: function(aReturn) {
                        aReturn = aReturn.trim();
                        var aReturn = $.parseJSON(aReturn);
                        if (aReturn['nStaEvent'] == '1') {
                            $('#odvModalDelZoneObj').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            $('#oetZneBchName').val('');
                            $('#oetZneBchCode').val('');
                            $('#oetZneUSerCode').val('');
                            $('#oetZneUSerName').val('');
                            $('#oetZneSpnCode').val('');
                            $('#oetZneSpnName').val('');
                            $('#oetZneShopCode').val('');
                            $('#oetZneShopName').val('');
                            $('#oetZnePosCode').val('');
                            $('#oetZnePosName').val('');
                            $('#oetKeyReferName').val('');

                            $("#ocmTypeRefer").val('TCNMBranch').selectpicker("refresh");
                            $('#odvZneBranch').show();
                            $('#odvZneUSer').hide();
                            $('#odvZneSaleMan').hide();
                            $('#odvZneShop').hide();
                            $('#odvZnePos').hide();
                            setTimeout(function() {
                                if (aReturn["nNumRowzen"] != 0) {
                                    if (aReturn["nNumRowzen"] > 10) {
                                        nNumPage = Math.ceil(aReturn["nNumRowzen"] / 10);
                                        if (tCurrentPage <= nNumPage) {
                                            JSvZoneObjDataTable(tCurrentPage);
                                        } else {
                                            JSvZoneObjDataTable(nNumPage);
                                        }
                                    } else {
                                        JSvZoneObjDataTable(1);
                                    }
                                } else {
                                    JSvZoneObjDataTable(1);
                                }
                            }, 500);
                        } else {
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);
                        }

                        JSxZNENavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    }
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
    JSvZoneObjDataTable(nPageCurrent);
}