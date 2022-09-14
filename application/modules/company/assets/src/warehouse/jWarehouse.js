var nStaWahBrowseType = $('#oetWahStaBrowse').val();
var tCallWahBackOption = $('#oetWahCallBackOption').val();

$('ducument').ready(function () {
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    // JSvCheckUserLevel();
    JSxBCNavDefult();
    localStorage.removeItem('LocalItemData');

    if (nStaWahBrowseType != 1) {
        JSvCallPageWarehouseList(1);
    } else {
        JSvCallPageWarehouseAdd();
    }
});

function JSxBCNavDefult() {
    if (nStaWahBrowseType != 1 || tCallWahBackOption == undefined) {
        $('.xCNWahVMaster').show(); /*Control Bar Browse*/
        $('.xCNWahVBrowse').hide(); /*Control Bar Browse*/

        $('#oliWAHAdd').hide();
        $('#oliWAHEdit').hide();
        $('#odvBtnCmpEditInfo').hide();
        $('#odvBtnWahInfo').show();
        $('#odvBtnShpInfo').hide();
        $('.obtChoose').hide();
    } else {
        /*Control Bar Browse*/
        $('#odvModalBody .xCNWahVMaster').hide();
        $('#odvModalBody .xCNWahVBrowse').show();
        $('#odvModalBody #odvWahMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliWahNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvWahBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNWahBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNWahBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        /*Control Bar Browse*/
    }
}

function CheckValidation() {
    $("#frmPart").validate({
        rules: {
            Code: "required",
            Name: "required",
        },
        messages: {
            Code: "",
            Name: "",
        },
        errorClass: "xCNinvalid",
        validClass: "xCNvalid",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {

            alert('0f');

        }
    });


    //Check Validate
    if (!$("#frmPart").validate()) { // Not Valid
        return false;
    } else {
        $("#frmPart").submit()
    }

}

//Functionality : Check UserLogin Level For Control view.
//Parameters : function Parameters
//Creator : 01/04/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvCheckUserLevel() {

    localStorage.removeItem('tStaPageNow'); //remove ค่า ที่เก็บ ชื่อหน้าที่เข้าอยู่ปัจจุบัน 

    JCNxOpenLoading();

    $.ajax({
        type: "POST",
        url: "warehouseCheckUserLevel",
        data: {},
        cache: false,
        success: function (tResult) {

            $('#odvContentPageWarehouse').html(tResult);

            //Put Data
            ohdWahStaType = $('#ohdWahStaType').val();
            $('#ocmWahStaType').val(ohdWahStaType).attr('selected', true);

            JSvWarehouseDataTable();

        },
        error: function (data) {
            console.log(data);
        }
    });

}

//Functionality : Call Reason PageEdit
//Parameters : function Parameters
//Creator : 27/03/2018 wasin(yoshi)
//Return : View
//Return Type : View
function JSvCallPageWarehouseEdit(ptWahCode, ptBchCode) {

    JCNxOpenLoading();
    tStaType = 'Edit';
    // JStCMMGetPanalLangSystemHTML('JSvCallPageWarehouseEdit', ptWahCode);
    $.ajax({
        type: "POST",
        url: "warehousePageEdit",
        data: {
            tWahCode: ptWahCode,
            tBchCode: ptBchCode,
            tStaType: tStaType,
            tTypePage: 'edit'
        },
        success: function (tResult) {
            $('#odvContentPageWarehouse').html(tResult);
            //Put Data
            ohdWahStaType = $('#odvContentPageWarehouse #ohdWahStaType').val();
            $("#odvContentPageWarehouse #ocmWahStaType option[value='" + ohdWahStaType + "']").attr('selected', true).trigger('change');

            //Disabled input
            $('#odvContentPageWarehouse #oetWahCode').addClass('xCNCursorNotAlw').attr('readonly', true);
            $('#oliWAHEdit').show();
            $('#oliWAHAdd').hide();
            $('#odvBtnWahInfo').hide();
            $('#odvBtnCmpEditInfo').show();
            $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่

            JCNxCloseLoading();

        },
        error: function (data) {
            console.log(data);
        }
    });
}

///function : Call Reason Pagelist
//Parameters : tSearchAll : ข้อความที่ใช้ค้นหา , nPageCurrent = 1 Refresh หน้า
//Creator :
//Return : View
//Return Type : View
function JSvCallPageWarehouseList(nPage) {

    JCNxOpenLoading();
    localStorage.removeItem('LocalItemData'); //remove ค่า ที่เก็บ Chkbox หน้า List
    localStorage.tStaPageNow = 'JSvCallPageWarehouseList';

    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = nPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }

    $.ajax({
        type: "POST",
        url: "warehouseList",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent
        },
        cache: false,
        success: function (tResult) {

            JSxBCNavDefult(); //คืนค่าปุ่ม
            $('#odvContentPageWarehouse').html(tResult);
            JSvWarehouseDataTable();

        },
        error: function (data) {
            //Error call again
            JSvCallPageWarehouseList(nPage)
            console.log(data);
        }
    });
}

///function : Call Recive Data List
//Parameters : Ajax Success Event 
//Creator:	28/05/2018 wasin
//Update:   
//Return : View
//Return Type : View
function JSvWarehouseDataTable(pnPage) {
    var tSearchAll = $('#odvContentPageWarehouse #oetSearchAll').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "warehouseDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 5000,
        success: function (tResult) {
            if (tResult != "") {
                $('#odvContentPageWarehouse #ostDataWarehouse').html(tResult);
            }
            JSxBCNavDefult();
            JCNxLayoutControll();
            // JStCMMGetPanalLangHTML('TCNMWaHouse_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

//Functionality : Call Reason PageAdd
//Parameters : function Parameters
//Creator :
//Return : View
//Return Type : View
function JSvCallPageWarehouseAdd() {

    tRouteFromName = $('#oetWahRouteFromName').val(); /*Get Master ก้อนหน้าที่จะ Brw มาเพื่อเอาไป COntol หน้าจอ Add*/

    JCNxOpenLoading();

    if (tRouteFromName != '') {
        tTypePage = tRouteFromName
    } else {
        tTypePage = 'Add';
    }

    // JStCMMGetPanalLangSystemHTML('', '');

    $.ajax({
        type: "POST",
        url: "warehousePageAdd",
        data: {
            tTypePage: tTypePage,

        },
        cache: false,
        success: function (tResult) {
            if (nStaWahBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                // Hide/Show AutoGen Input
                JSxWahVisibleComponent('#odvModalBodyBrowse #odvWahAutoGenCode', true);
                $('#odvModalBodyBrowse #oetWahCode').attr("disabled", true);
                $('#odvModalBodyBrowse #ocbWahAutoGenCode').change(function () {
                    if ($('#odvModalBodyBrowse #ocbWahAutoGenCode').is(':checked')) {
                        $('#odvModalBodyBrowse #oetWahCode').val('');
                        $('#odvModalBodyBrowse #oetWahCode').attr("disabled", true);
                        $('#odvModalBodyBrowse #odvWahCodeForm').removeClass('has-error');
                        $('#odvModalBodyBrowse #odvWahCodeForm em').remove();
                    } else {
                        $("#odvModalBodyBrowse #oetWahCode").attr("disabled", false);
                    }
                });
            } else {
                $('#oliWAHAdd').show();
                $('#oliWAHEdit').hide();
                $('#odvBtnWahInfo').hide();
                $('#odvBtnCmpEditInfo').show();
            }
            $('#odvContentPageWarehouse').html(tResult);
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : (event) Delete แบบ ID 1 ตัว
//Parameters : tIDCode รหัส
//Creator : 10/5/2018 Krit(Copter)
//Return : -
//Return Type : n
function JSnWarehouseDel(tCurrentPage, tIDCode, tBchCode, tDelName, tYesOnNo) {

    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + tDelName + ' ) ' + tYesOnNo);
        $('#odvModalDelWarehouse').modal('show');
        $('#osmConfirm').on('click', function (evt) {

            $.ajax({
                type: "POST",
                url: "warehouseEventDelete",
                data: { 'tIDCode': tIDCode, 'tBchCode': tBchCode },
                cache: false,
                success: function (oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == '1') {
                        $('#odvModalDelWarehouse').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        setTimeout(function () {

                            if (aReturn["nNumRowWahLoc"] != 0) {
                                if (aReturn["nNumRowWahLoc"] > 10) {
                                    nNumPage = Math.ceil(aReturn["nNumRowWahLoc"] / 10);
                                    if (tCurrentPage <= nNumPage) {
                                        JSvCallPageWarehouseList(tCurrentPage);
                                    } else {
                                        JSvCallPageWarehouseList(nNumPage);
                                    }
                                } else {
                                    JSvCallPageWarehouseList(1);
                                }
                            } else {
                                JSvCallPageWarehouseList(1);
                            }
                            // JSvWarehouseDataTable(tCurrentPage);
                        }, 500);
                    } else {
                        JCNxCloseLoading();
                        alert(aReturn['tStaMessg']);
                    }
                    JSxBCNavDefult();

                },
                error: function (data) {
                    console.log(data)
                }
            });

        });
    }
}

//Functionality : (event) Delete แบบ เลือก Id หลายตัว ส่งค่า Array ไปลบ 
//Parameters : tIDCode รหัส
//Creator : 10/05/2018 Krit(Copter)
//Return : -
//Return Type : n
function JSnWarehouseDelChoose(pnPage) {
    JCNxOpenLoading();
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];
    var aNewIdBchDelete = [];
    for ($i = 0; $i < aDataSplitlength; $i++) {
        var aSplitCode = aDataSplit[$i].split("||");
        aNewIdDelete.push(aSplitCode[0]);
        aNewIdBchDelete.push(aSplitCode[1]);
    }

    if (aDataSplitlength > 1) {

        localStorage.StaDeleteArray = '1';

        $.ajax({
            type: "POST",
            url: "warehouseEventDelete",
            data: { 'tIDCode': aNewIdDelete, 'tBchCode': aNewIdBchDelete },
            success: function (tResult) {
                setTimeout(function () {
                    $('#odvModalDelWarehouse').modal('hide');
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    JSvWarehouseDataTable(pnPage);
                    $('.modal-backdrop').remove();

                    if (tResult["nNumRowWahLoc"] != 0) {
                        if (tResult["nNumRowWahLoc"] > 10) {
                            nNumPage = Math.ceil(tResult["nNumRowWahLoc"] / 10);
                            if (tCurrentPage <= nNumPage) {
                                JSvCallPageWarehouseList(tCurrentPage);
                            } else {
                                JSvCallPageWarehouseList(nNumPage);
                            }
                        } else {
                            JSvCallPageWarehouseList(1);
                        }
                    } else {
                        JSvCallPageWarehouseList(1);
                    }
                    // JSvWarehouseDataTable(tCurrentPage);



                }, 500);

            },
            error: function (data) {
                console.log(data);
            }
        });


    } else {
        localStorage.StaDeleteArray = '0';

        return false;
    }

}

// Functionality : (event) Add/Edit Warehouse
// Parameters : form
// Creator : 27/03/2018 wasin(yoshi)
// update : 20/09/2019 Sahaart(Golf)
// Return : Status Add
// Return Type : n
function JSnAddEditWarehouse(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ocmWahStaType').attr('disabled',false);
        $('#ofmAddWarehouse').validate().destroy();
        $.validator.addMethod('dublicateCode', function (value, element) {
            if (ptRoute == "warehouseEventAdd") {
                if ($("#ohdCheckDuplicateAgnCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddWarehouse').validate({
            rules: {
                oetWahCode: {
                    "required": {
                        depends: function (oElement) {
                            if (ptRoute == "warehouseEventAdd") {
                                if ($('#ocbWahAutoGenCode').is(':checked')) {
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

                oetWahName: { "required": {} },
                oetWahBchNameCreated: { "required": {} },
            },
            messages: {
                oetWahCode: {
                    "required": $('#oetWahCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetWahCode').attr('data-validate-dublicateCode')
                },
                oetWahName: {
                    "required": $('#oetWahName').attr('data-validate-required'),
                },
                oetWahBchNameCreated: {
                    "required": $('#oetWahBchNameCreated').attr('data-validate-required'),
                },
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
                $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddWarehouse').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function (tResult) {
                        $('#ocmWahStaType').attr('disabled',true);
                        if (nStaWahBrowseType != 1) {
                            // console.log(JSON.stringify(tResult));
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageWarehouseEdit(aReturn['tCodeReturn'], $('#oetWahBchCodeCreated').val());
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageWarehouseAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageWarehouseList();
                                }
                            } else {
                                var tMsgError = aReturn['tStaMessg']
                                FSvCMNSetMsgWarningDialog(tMsgError);
                            }

                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageWarehouseEdit(aReturn['tCodeReturn'], $('#oetWahBchCodeCreated').val());
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageWarehouseAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageWarehouseList();
                                }
                            } else {
                                var tMsgError = aReturn['tStaMessg']
                                FSvCMNSetMsgWarningDialog(tMsgError);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallWahBackOption);
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            },
        });
    }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 27/03/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvClickPage(ptPage) {

    // if(ptPage == '1'){ var nPage = 'previous'; }else if(ptPage == '2'){ var nPage = 'next';}
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageWah .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageWah .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvWarehouseDataTable(nPageCurrent);
}

//Functionality : gen code Branch
//Parameters : -
//Creator : 04/04/2018 Krit(Copter)
//Return : Data
//Return Type : String
function JStGenerateWarehouseCode() {

    JCNxOpenLoading();

    var tTableName = 'TCNMWaHouse';
    $.ajax({
        type: "POST",
        url: "generateCode",
        data: { tTableName: tTableName },
        cache: false,
        success: function (tResult) {

            var tData = $.parseJSON(tResult);
            if (tData.rtCode == '1') {
                $('#oetWahCode').val(tData.rtWahCode);

                $('.xCNDisable').attr('readonly', true);
                $('#oetWahCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);

                //ปุ่ม Gen
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetWahName').focus();
            } else {
                $('#oetWahCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

//Functionality : Check ค่าจาก input ส่วไป Check ใน Base ว่ามี ค่านี้อยู่หรือไม่
//Parameters : -
//Creator : 18/04/2018 Krit(Copter)
//Return : Status,Message
//Return Type : String
function JStCheckWahouseCode() {
    tCode = $('#oetWahCode').val();
    tBchCode = $('#oetWahBchCodeCreated').val();

    var tTableName = 'TCNMWaHouse';
    var tFieldName = 'FTWahCode';


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

            success: function (tResult) {

                var tData = $.parseJSON(tResult);

                $('.btn-default').attr('disabled', true);

                //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
                if (tData.rtCode == '1') {
                    alert('มี id นี้แล้วในระบบ');
                    JSvCallPageWarehouseEdit(tCode, tBchCode);
                } else {
                    alert('ไม่พบระบบจะ Gen ใหม่');
                    JStGenerateWarehouseCode();
                }


                $('.wrap-input100').removeClass('alert-validate');
                $('.btn-default').attr('disabled', false);

            },
            error: function (data) {
                console.log(data);
            }
        });

    } else {

        alert('กรุณากรอก Code');

        $('.btn-default').attr('disabled', true);

    }



}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 16/1/2019 (golf)
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
        var tTextBchCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode + "||" + aArrayConvert[0][$i].nBchCode;
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
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbWahIsCreatePage() {
    try {
        const tWahCode = $('#oetWahCode').data('is-created');
        var bStatus = false;
        if (tWahCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbWahIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbWahIsUpdatePage() {
    try {
        const tWahCode = $('#oetWahCode').data('is-created');
        var bStatus = false;
        if (!tWahCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbWahIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin(Yoshi)
// Last Modified : -
// Return : -
// Return Type : -
function JSxWahVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxWahVisibleComponent Error: ', err);
    }
}