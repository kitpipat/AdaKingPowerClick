var nStaSplBrowseType = $('#oetSplStaBrowse').val();
var tCallSplBackOption = $('#oetSplCallBackOption').val();
// alert(nStaSplBrowseType+'//'+tCallSplBackOption);
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxSplNavDefult();
    if (nStaSplBrowseType != 1) {
        JSvCallPageSupplierList();
    } else {
        JSvCallPageSupplierAdd();
    }
});

//function : Function Clear Defult Button Supplier
//Parameters : Document Ready
//Creator : 10/10/2018 Phisan
//Return : Show Tab Menu
//Return Type : -
function JSxSplNavDefult() {
    if (nStaSplBrowseType != 1 || nStaSplBrowseType == undefined) {
        $('.xCNChoose').hide();
        $('#oliSplTitleAdd').hide();
        $('#oliSplTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnSplInfo').show();
    } else {
        $('#odvModalBody .xCNSplVMaster').hide();
        $('#odvModalBody .xCNSplVBrowse').show();
        $('#odvModalBody #odvSplMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliSplNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvSplBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNSplBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNSplBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}


//function : Call Page Supplier list
//Parameters : Document Redy And Event Button
//Creator :	10/10/2018 Phisan
//Return : View
//Return Type : View
function JSvCallPageSupplierList() {
    localStorage.tStaPageNow = 'JSvCallPageSupplierList';
    $('#oetSearchSupplier').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "supplierList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageSupplier').html(tResult);
            JSvSupplierDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Product Type Data List
//Parameters: Ajax Success Event
//Creator:	10/10/2018 phisan
//Return: View
//Return Type: View
function JSvSupplierDataTable(pnPage) {
    var tSearchAll = $('#oetSearchSupplier').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "supplierDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataSupplier').html(tResult);
            }
            JSxSplNavDefult();
            JCNxLayoutControll();
            // JStCMMGetPanalLangHTML('TCNMSpl_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Page Supplier Add
//Parameters : Event Button Click
//Creator : 10/10/2018 phisan
//Return : View
//Return Type : View
function JSvCallPageSupplierAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "supplierPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaSplBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('#oliSplTitleEdit').hide();
                $('#oliSplTitleAdd').show();
                $('#odvBtnSplInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageSupplier').html(tResult);
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Page Supplier Edit
//Parameters : Event Button Click
//Creator : 11/10/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageSupplierEdit(ptSplCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageSupplierEdit', ptSplCode);
    $.ajax({
        type: "POST",
        url: "supplierPageEdit",
        data: { tSplCode: ptSplCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliSplTitleAdd').hide();
                $('#oliSplTitleEdit').show();
                $('#odvBtnSplInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageSupplier').html(tResult);
                $('#oetSplCode').addClass('xCNDisable');
                $('#oetSplCode').attr('readonly', true);
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

//Functionality : Event Add/Edit Supplier
//Parameters : From Submit
//Creator : 10/10/2018 wasin
//Return : Status Event Add/Edit Supplier
//Return Type : object
function JSoAddEditSupplier(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddsupplier1').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "supplierEventAdd") {
                if ($("#ohdCheckDuplicateSpl").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddsupplier1').validate({
            rules: {
                oetSplCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "supplierEventAdd") {
                                if ($('#ocbSplAutoGenCode').is(':checked')) {
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
                oetSplName: { "required": {} },
                oemtSplEmail: { "email": {} },
            },
            messages: {
                oetSplCode: {
                    "required": $('#oetSplCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetSplCode').attr('data-validate-dublicateCode')
                },
                oetSplName: {
                    "required": $('#oetSplName').attr('data-validate-required'),
                },
                oemtSplEmail: {
                    "email": $('#oemtSplEmail').attr('data-validate-email'),
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
                // console.log( $('#ofmAddsupplier1').serializeArray() );
                // console.log( $('#ofmAddsupplier3').serializeArray() );
                // console.log( $('#ofmAddsupplier2').serializeArray() );
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddsupplier1').serialize() + '&' + $('#ofmAddsupplier2').serialize() + '&' + $('#ofmAddsupplier3').serialize(),
                    success: function(oResult) {
                        if (nStaSplBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if (aReturn['nStaEvent'] == 1) {
                                switch (aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageSupplierEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageSupplierAdd();
                                        break;
                                    case '3':
                                        JSvCallPageSupplierList();
                                        break;
                                    default:
                                        JSvCallPageSupplierEdit(aReturn['tCodeReturn']);
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                                JCNxCloseLoading();
                                //JSvCallPageSupplierList();
                            }
                            JCNxImgWarningMessage(aReturn['aImgReturn']);
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallSplBackOption);
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

// //Functionality : Generate Code Supplier
// //Parameters : Event Button Click
// //Creator : 05/11/2018 phisan
// //Return : Event Push Value In Input
// //Return Type : -
function JStGenerateSupplierCode() {
    $('#oetSplCode').closest('.form-group').addClass("has-success").removeClass("has-error");
    var tTableName = 'TCNMSpl';
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "generateCode",
        data: { tTableName: tTableName },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var tData = $.parseJSON(tResult);
            if (tData.rtCode == '1') {
                $('#oetSplCode').val(tData.rtSplCode);
                $('#oetSplCode').addClass('xCNDisable');
                $('#oetSplCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetSplName').focus();
            } else {
                $('#oetSplCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Single Delete Supplier
//Parameters : Event Icon Delete
//Creator : 10/10/2018 wasin
//Return : object Status Delete
//Return Type : object
function JSoSupplierDel(tIDCode, tName) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    var tConfirm = $('#ohdDeleteconfirm').val();
    var tConfirmYN = $('#ohdDeleteconfirmYN').val();
    if (aDataSplitlength == '1') {
        $('#odvModalDelSupplier').modal('show');
        $('#ospConfirmDelete').html(tConfirm + " " + tIDCode + ' (' + tName + ')' + tConfirmYN);
        $('#osmConfirm').on('click', function(evt) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "supplierEventDelete",
                data: { aIDCode: tIDCode },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        $('#odvModalDelSupplier').modal('hide');
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        setTimeout(function() {
                            JSvSupplierDataTable();
                        }, 500);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JSxSplNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }
}

//Functionality: Event Multi Delete Supplier
//Parameters: Event Button Delete All
//Creator: 10/10/2018 wasin
//Return:  object Status Delete
//Return Type: object
function JSoSupplierDelChoose() {
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
            url: "supplierEventDelete",
            data: { aIDCode: aNewIdDelete },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturn = JSON.parse(oResult);
                if (aReturn['nStaEvent'] == 1) {
                    setTimeout(function() {
                        $('#odvModalDelSupplier').modal('hide');
                        JSvCallPageSupplierList();
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                    }, 1000);
                } else {
                    alert(aReturn['tStaMessg']);
                }
                JSxSplNavDefult();
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
//Parameters : Event Click Pagenation
//Creator : 17/09/2018 phisan
//Return : View
//Return Type : View
function JSvSupplierClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageSupplier .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageSupplier .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvSupplierDataTable(nPageCurrent);
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
function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        var tConfirm = $('#ohdDeleteChooseconfirm').val();
        $('#ospConfirmDelete').text(tConfirm);
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 11/10/2018 wasin
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

//Functionality: All DayCta
//Parameters: -
//Creator: 09/11/2018 phisan
//Return: Duplicate/none
//Return Type: string
function JSxAllDayCta() {
    tSplDayCtaAll = $('#ocbSplDayCtaAll:checked').val();
    if (tSplDayCtaAll == 'on') {
        $('.xWChkCtaChkAll').prop('checked', true);
    }
    nChk = 0;
    $(".xWChkCtaChkAll:checked").map(function() {
        nChk++;
    }).get();
    if (nChk >= 7) {
        $('.xWStaDayCta').prop('checked', true);
    } else {
        $('.xWStaDayCta').prop('checked', false);
    }
}

//Functionality: chk All DayCta
//Parameters: -
//Creator: 09/11/2018 phisan
//Return: Duplicate/none
//Return Type: string
function JSxChkAllDayCta() {
    nChk = 0;
    $(".xWChkCtaChkAll:checked").map(function() {
        nChk++;
    }).get();
    // alert(nChk)
    if (nChk >= 7) {
        $('.xWStaDayCta').prop('checked', true);
    } else {
        $('.xWStaDayCta').prop('checked', false);
    }
}


function JSxSupplierVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxSupplierlevVisibleComponent Error: ', err);
    }
}

function JSbSupplierUpdatePage() {
    try {
        const tSplCode = $('#oetSplCode').data('is-created');
        var bStatus = false;
        if (!tSplCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbSupplierlevIsUpdatePage Error: ', err);
    }
}

function JSbSupplierIsCreatePage() {
    try {
        const tSplCode = $('#oetSplCode').data('is-created');
        var bStatus = false;
        if (tSplCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbSupplierIsCreatePage Error: ', err);
    }
}

function JSvCallPageSupplierAddAddress(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddsupplier1').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "supplierEventAdd") {
                if ($("#ohdCheckDuplicateSpl").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddsupplier1').validate({
            rules: {
                oetSplCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "supplierEventAdd") {
                                if ($('#ocbSplAutoGenCode').is(':checked')) {
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
                oetSplName: { "required": {} },
                oemtSplEmail: { "email": {} },
            },
            messages: {
                oetSplCode: {
                    "required": $('#oetSplCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetSplCode').attr('data-validate-dublicateCode')
                },
                oetSplName: {
                    "required": $('#oetSplName').attr('data-validate-required'),
                },
                oemtSplEmail: {
                    "email": $('#oemtSplEmail').attr('data-validate-email'),
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
                    data: $('#ofmAddsupplier1').serialize() + '&' + $('#ofmAddsupplier2').serialize(),
                    success: function(oResult) {
                        if (nStaSplBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if (aReturn['nStaEvent'] == 1) {
                                switch (aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageSupplierEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageSupplierAdd();
                                        break;
                                    case '3':
                                        JSvCallPageSupplierList();
                                        break;
                                    default:
                                        JSvCallPageSupplierEdit(aReturn['tCodeReturn']);
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallSplBackOption);
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

//Functionality : CalpageAdd Address
//Parameters : -
//Creator : 24/06/2019 Sarun
//Return : view
//Return Type : view
function JSvCallPageSupplierCallpageAddAddress() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "supplierPageAddAddress",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            // if (nStaSplBrowseType == 1) {
            //     $('#odvModalBodyBrowse').html(tResult);
            //     $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
            // }else{
            //     $('#oliSplTitleEdit').hide();
            //     $('#oliSplTitleAdd').show();
            //     $('#odvBtnSplInfo').hide();
            //     $('#odvBtnAddEdit').show();
            // }
            $('#odvContentAddress').html(tResult);
            $('#olaTitleAdd').show();
            // $('#obtbackDataAddress').show();
            $('#obtAddAddress').hide();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Add/Edit Supplier Address
//Parameters : From Submit
//Creator : 21/06/2019 Sarun
//Return : view
//Return Type : object
function JSoAddEditSupplierAddress(ptRoute, ptSplCode, pnSeqNo) {

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: ptRoute,
        data: $('#ofmAddAddress').serialize() + '&ohdSupcode=' + $('#ohdSupcode').val() + '&ohdSeqNo=' + $('#ohdSeqNo').val(),
        success: function(oResult) {
            JSxAddressDatatable(ptSplCode);

        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

function JSxAddressDatatable(paData) {
    $.ajax({
        type: "POST",
        url: "supplierAddressDataTable",
        // data: { tSplAddress: paData },
        data: { tSplCode: paData },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentAddress').html(tResult);
            $('#obtAddAddress').show();
            $('#olaTitleAdd').hide();
            $('#olaTitleEdit').hide();
            JCNxCloseLoading();
            // JSxSplNavDefult();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

function JSxContactDatatable(paData) {
    $.ajax({
        type: "POST",
        url: "supplierAddressDataTable",
        // data: { tSplAddress: paData },
        data: { tSplCode: paData },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentAddress').html(tResult);
            $('#obtAddAddress').show();
            $('#olaTitleAdd').hide();
            $('#olaTitleEdit').hide();
            JCNxCloseLoading();
            // JSxSplNavDefult();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

function JSvCallPageSupplierAddressEdit(ptSplCode, pnSeqNo) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageSupplierEdit', ptSplCode);
    $.ajax({
        type: "POST",
        url: "supplierAddressPageEdit",
        data: {
            tSplCode: ptSplCode,
            nSeqNo: pnSeqNo
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            // if(tResult != ''){
            //     $('#oliSplTitleAdd').hide();
            //     $('#oliSplTitleEdit').show();
            //     $('#odvBtnSplInfo').hide();
            //     $('#odvBtnAddEdit').show();
            //     $('#odvContentPageSupplier').html(tResult);
            //     $('#oetSplCode').addClass('xCNDisable');
            //     $('#oetSplCode').attr('readonly', true);
            //     $('.xCNBtnGenCode').attr('disabled', true);
            // }
            $('#odvContentAddress').html(tResult);
            $('#olaTitleAdd').hide();
            $('#obtAddAddress').hide();
            $('#olaTitleEdit').show();

            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

function JSvCallPageSupplierContactEdit(ptSplCode, pnSeqNo) {
    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML('JSvCallPageSupplierEdit',ptSplCode);
    $.ajax({
        type: "POST",
        url: "supplierContactPageEdit",
        data: {
            tSplCode: ptSplCode,
            nSeqNo: pnSeqNo
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            // if(tResult != ''){
            //     $('#oliSplTitleAdd').hide();
            //     $('#oliSplTitleEdit').show();
            //     $('#odvBtnSplInfo').hide();
            //     $('#odvBtnAddEdit').show();
            //     $('#odvContentPageSupplier').html(tResult);
            //     $('#oetSplCode').addClass('xCNDisable');
            //     $('#oetSplCode').attr('readonly', true);
            //     $('.xCNBtnGenCode').attr('disabled', true);
            // }
            $('#odvContentContact').html(tResult);
            // $('#olaTitleContr').hide();
            $('#obtAddContr').hide();
            $('#olaTitleEditContr').show();

            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

function JSoSupplierAddressDel(ptSplCode, pnSqeNo, ptName) {
    // alert(ptSplCode);
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    var tConfirm = $('#ohdDeleteconfirm').val();
    var tConfirmYN = $('#ohdDeleteconfirmYN').val();

    $('#odvModalDelSupplier').modal('show');
    $('#ospConfirmDelete').html(tConfirm + " " + ' (' + ptName + ')' + tConfirmYN);
    $('#osmConfirm').on('click', function(evt) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "supplierAddressEventDelete",
            data: { nSqeNo: pnSqeNo },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                // var aReturn = JSON.parse(oResult);

                JSxAddressDatatable(ptSplCode);
                $('.modal-backdrop').remove();
                JSxSplNavDefult();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });

}

function JSoSupplierContactDel(ptSplCode, pnSqeNo, ptName) {
    // alert(ptSplCode);
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    var tConfirm = $('#ohdDeleteconfirm').val();
    var tConfirmYN = $('#ohdDeleteconfirmYN').val();

    $('#odvModalDelContact').modal('show');
    $('#ospConfirmDeleteContact').html(tConfirm + " " + ' (' + ptName + ')' + tConfirmYN);
    $('#osmConfirmContact').on('click', function(evt) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "supplierContactEventDelete",
            data: { nSqeNo: pnSqeNo },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                // console.log(oResult);
                // var aReturn = JSON.parse(oResult);

                JSxContactDatatable(ptSplCode);
                $('.modal-backdrop').remove();
                JSxSplNavDefult();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });

}

//Functionality : CalpageAdd Contrac
//Parameters : -
//Creator : 26/06/2019 Sarun
//Return : view
//Return Type : view
function JSvCallPageAddContact() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "supplierPageAddContact",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            // if (nStaSplBrowseType == 1) {
            //     $('#odvModalBodyBrowse').html(tResult);
            //     $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
            // }else{
            //     $('#oliSplTitleEdit').hide();
            //     $('#oliSplTitleAdd').show();
            //     $('#odvBtnSplInfo').hide();
            //     $('#odvBtnAddEdit').show();
            // }
            $('#odvContentContact').html(tResult);
            $('#olaTitleAddContr').show();
            $('#obtAddContr').hide();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Add/Edit Supplier Contact
//Parameters : From Submit
//Creator : 26/06/2019 Sarun
//Return : view
//Return Type : object
function JSoAddEditSupplierContact(ptRoute, ptSplCode, pnSeqNo) {
    // alert(ptRoute+ptSplCode+pnSeqNo);
    // console.log($('#ofmAddContact').serializeArray());
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: ptRoute,
        data: $('#ofmAddContact').serialize() + '&ohdSupcode=' + $('#ohdSupcode').val() + '&ohdSeqNo=' + $('#ohdSeqNo').val(),
        success: function(oResult) {
            JSxContactDatatable(ptSplCode);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : DataTable Contact
//Parameters : SplCode
//Creator : 26/06/2019 Sarun
//Return : view
//Return Type : String
function JSxContactDatatable(paData) {
    $.ajax({
        type: "POST",
        url: "supplierContactDataTable",
        // data: { tSplAddress: paData },
        data: { tSplCode: paData },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentContact').html(tResult);
            $('#obtAddContr').show();
            $('#olaTitleAddContr').hide();
            $('#olaTitleEditContr').hide();
            JCNxCloseLoading();
            // JSxSplNavDefult();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}
