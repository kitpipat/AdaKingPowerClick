var nStaSlvBrowseType = $('#oetSlvStaBrowse').val();
var tCallSlvBackOption = $('#oetSlvCallBackOption').val();
// alert(nStaSlvBrowseType+'//'+tCallSlvBackOption);
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxSlvNavDefult();
    if (nStaSlvBrowseType != 1) {
        JSvCallPageSupplierLevelList();
    } else {
        JSvCallPageSupplierLevelAdd();
    }
});

//function : Function Clear Defult Button SupplierLevel
//Parameters : Document Ready
//Creator : 09/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxSlvNavDefult() {
    if (nStaSlvBrowseType != 1 || nStaSlvBrowseType == undefined) {
        $('.xCNSlvVBrowse').hide();
        $('.xCNSlvVMaster').show();
        $('.xCNChoose').hide();
        $('#oliSlvTitleAdd').hide();
        $('#oliSlvTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnSlvInfo').show();
    } else {
        $('#odvModalBody .xCNSlvVMaster').hide();
        $('#odvModalBody .xCNSlvVBrowse').show();
        $('#odvModalBody #odvSlvMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliSlvNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvSlvBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNSlvBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNSlvBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 09/10/2018 witsarut
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

//function : Call SupplierLevel Page list  
//Parameters : Document Redy And Event Button
//Creator :	09/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageSupplierLevelList() {
    localStorage.tStaPageNow = 'JSvCallPageSupplierLevelList';
    $('#oetSearchSupplierLevel').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "supplierlevList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageSupplierLevel').html(tResult);
            JSvSupplierLevelDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call SupplierLevel Data List
//Parameters: Ajax Success Event 
//Creator:	09/10/2018 witsarut
//Return: View
//Return Type: View
function JSvSupplierLevelDataTable(pnPage) {
    var tSearchAll = $('#oetSearchSupplierLevel').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "supplierlevDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataSupplierLevel').html(tResult);
            }
            JSxSlvNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMSplLev_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call SupplierLevel Page Add  
//Parameters : Event Button Click
//Creator : 09/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageSupplierLevelAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "supplierlevPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaSlvBrowseType == 1) {
                $('.xCNSlvVMaster').hide();
                $('.xCNSlvVBrowse').show();
            } else {
                $('.xCNSlvVBrowse').hide();
                $('.xCNSlvVMaster').show();
                $('#oliSlvTitleEdit').hide();
                $('#oliSlvTitleAdd').show();
                $('#odvBtnSlvInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageSupplierLevel').html(tResult);
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call SupplierLevel Page Edit  
//Parameters : Event Button Click 
//Creator : 09/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageSupplierLevelEdit(ptSlvCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageSupplierLevelEdit', ptSlvCode);
    $.ajax({
        type: "POST",
        url: "supplierlevPageEdit",
        data: { tSlvCode: ptSlvCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliSlvTitleAdd').hide();
                $('#oliSlvTitleEdit').show();
                $('#odvBtnSlvInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageSupplierLevel').html(tResult);
                $('#oetSplevCode').addClass('xCNDisable');
                $('#oetSplevCode').attr('readonly', true);
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

//Functionality : Event Add/Edit SupplierLevel
//Parameters : From Submit
//Creator : 09/10/2018 witsarut
//Return : Status Event Add/Edit SupplierLevel
//Return Type : object
function JSoAddEditSupplierLevel(ptRoute) {
    // $('#ofmAddSupplierLevel').validate({
    //     rules: {
    //         oetSplevCode: "required",
    //         oetSlvName: "required",

    //     },
    //     messages: {
    //         oetSplevCode: $('#oetSplevCode').data('validate'),
    //         oetSlvName: $('#oetSlvName').data('validate')
    //     },
    //     errorElement: "em",
    //     errorPlacement: function (error, element ) {
    //         error.addClass( "help-block" );
    //         if ( element.prop( "type" ) === "checkbox" ) {
    //             error.appendTo( element.parent( "label" ) );
    //         } else {
    //             var tCheck = $(element.closest('.form-group')).find('.help-block').length;
    //             if(tCheck == 0){
    //                 error.appendTo(element.closest('.form-group')).trigger('change');
    //             }
    //         }
    //     },
    //     highlight: function(element, errorClass, validClass) {
    //         $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
    //     },
    //     unhighlight: function(element, errorClass, validClass) {
    //         $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
    //     },
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddSupplierLevel').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "supplierlevEventAdd") {
                if ($("#ohdCheckDuplicateSlvCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddSupplierLevel').validate({
            rules: {
                oetSplevCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "supplierlevEventAdd") {
                                if ($('#ocbSupplierlevAutoGenCode').is(':checked')) {
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
                oetSlvName: { "required": {} },
            },
            messages: {
                oetSplevCode: {
                    "required": $('#oetSplevCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetSplevCode').attr('data-validate-dublicateCode')
                },
                oetSlvName: {
                    "required": $('#oetSlvName').attr('data-validate-required'),
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
                    data: $('#ofmAddSupplierLevel').serialize(),
                    success: function(oResult) {
                        if (nStaSlvBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if (aReturn['nStaEvent'] == 1) {
                                switch (aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageSupplierLevelEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageSupplierLevelAdd();
                                        break;
                                    case '3':
                                        JSvCallPageSupplierLevelList();
                                        break;
                                    default:
                                        JSvCallPageSupplierLevelEdit(aReturn['tCodeReturn']);
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallSlvBackOption);
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

//Functionality : Generate Code SupplierLevel
//Parameters : Event Button Click
//Creator : 09/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGenerateSupplierLevelCode() {
    $('#oetSplevCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMSplLev';
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
                $('#oetSplevCode').val(tData.rtSlvCode);
                $('#oetSplevCode').addClass('xCNDisable');
                $('#oetSplevCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetSlvName').focus();
            } else {
                $('#oetSplevCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 09/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoSupplierLevelDel(pnPage, ptName, tIDCode) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    var tConfirm = $('#ohdDeleteconfirm').val();
    var tConfirmYN = $('#ohdDeleteconfirmYN').val();

    if (aDataSplitlength == '1') {

        $('#odvModalDelSupplierLevel').modal('show');
        $('#ospConfirmDelete').text(tConfirm + ' ' + tIDCode + ' (' + ptName + ') ' + tConfirmYN);
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "supplierlevEventDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);

                        $('#odvModalDelSupplierLevel').modal('hide');
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        JSvSupplierLevelDataTable(pnPage);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }


        });
    }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 09/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoSupplierLevelDelChoose(pnPage) {
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
            url: "supplierlevEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {

                JSxSlvNavDefult();
                setTimeout(function() {
                    $('#odvModalDelSupplierLevel').modal('hide');
                    JSvSupplierLevelDataTable(pnPage);
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.obtChoose').hide();
                    $('.modal-backdrop').remove();
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
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 09/10/2018 witsarut
//Return : View
//Return Type : View
function JSvSupplierLevelClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageSupplierLevel .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageSupplierLevel .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvSupplierLevelDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 09/10/2018 witsarut
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
//Creator: 09/10/2018 witsarut
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
//Creator: 09/10/2018 witsarut
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
function JSbSupplierlevIsCreatePage() {
    try {
        const tSlvCode = $('#oetSplevCode').data('is-created');
        var bStatus = false;
        if (tSlvCode == "" || tSlvCode == null) { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbSupplierlevIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSupplierlevIsUpdatePage() {
    try {
        const tSlvCode = $('#oetSplevCode').data('is-created');
        var bStatus = false;
        if (!tSlvCode == "" || !tSlvCode == null) { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbSupplierlevIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxSupplierlevVisibleComponent(ptComponent, pbVisible, ptEffect) {
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