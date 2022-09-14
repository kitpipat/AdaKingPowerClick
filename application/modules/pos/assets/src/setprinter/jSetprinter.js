var nStaSprBrowseType = $('#oetSprStaBrowse').val();
var tCallSprBackOption = $('#oetSprCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxSetprinterNavDefult();
    if (nStaSprBrowseType != 1) {
        JSvCallPageSetprinter();
    } else {
        JSvCallPageSetprinterAdd();
    }
    //console.log('Set printer run'); 
});

/*============================= End Auto Run =================================*/

/**
 * Functionality : Function Clear Defult Button Set printer
 * Parameters : -
 * Creator : 28/01/2018 supawat
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSetprinterNavDefult() {
    try {
        if (nStaSprBrowseType != 1 || nStaSprBrowseType == undefined) {
            $('.xCNSprVBrowse').hide();
            $('.xCNSprVMaster').show();
            $('#oliSprTitleAdd').hide();
            $('#oliSprTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnSprInfo').show();
        } else {
            $('#odvModalBody .xCNSprVMaster').hide();
            $('#odvModalBody .xCNSprVBrowse').show();
            $('#odvModalBody #odvSprMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliSprNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvSprBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNSprBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNSprBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    } catch (err) {
        console.log('JSxSetprinterNavDefult Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 28/01/2018 supawat
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
 */
function JCNxSetprinterResponseError(jqXHR, textStatus, errorThrown) {
    try {
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
    } catch (err) {
        console.log('JCNxSetprinterResponseError Error: ', err);
    }
}

/**
 * Functionality : Call Set printer Page list
 * Parameters : {params}
 * Creator : 28/01/2018 supawat
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSetprinter(pnPage) {
    try {
        localStorage.tStaPageNow = 'JSvCallPageSetprinterList';

        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "setprinterList",
            cache: false,
            timeout: 0,
            data: {
                nPageCurrent: pnPage,
            },
            success: function(tResult) {
                $('#odvContentPageSetprinter').html(tResult);
                JSvSetprinterDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxSetprinterResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvCallPageSetprinter Error: ', err);
    }
}

/**
 * Functionality : Call Set printer Data List
 * Parameters : Ajax Success Event
 * Creator : 28/01/2018 supawat
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvSetprinterDataTable(pnPage) {
    try {
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "setprinterDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataSetprinter').html(tResult);
                }
                JSxSetprinterNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMPrinter_L'); //โหลดภาษาใหม่
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxSetprinterResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvSetprinterDataTable Error: ', err);
    }
}

/**
 * Functionality : Call Set printer Page Add
 * Parameters : {params}
 * Creator : 28/01/2018 supawat
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSetprinterAdd() {
    try {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "setprinterPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaSprBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                } else {
                    $('.xCNSprVBrowse').hide();
                    $('.xCNSprVMaster').show();
                    $('#oliSprTitleEdit').hide();
                    $('#oliSprTitleAdd').show();
                    $('#odvBtnSprInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageSetprinter').html(tResult);
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxSetprinterResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvCallPageSetprinterAdd Error: ', err);
    }
}

/**
 * Functionality : Call  Set printer Page Edit
 * Parameters : {params}
 * Creator : 28/01/2018 supawat
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSetprinterEdit(ptSprCode) {
    try {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageSetprinterEdit', ptSprCode);

        $.ajax({
            type: "POST",
            url: "setprinterPageEdit",
            data: { tSprCode: ptSprCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#oliSprTitleAdd').hide();
                    $('#oliSprTitleEdit').show();
                    $('#odvBtnSprInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageSetprinter').html(tResult);
                    $('#oetSprCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    $('.xCNBtnGenCode ').attr('disabled', true);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxSetprinterResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvCallPageSetprinterEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code Slip Message
 * Parameters : {params}
 * Creator : 28/01/2018 supawat
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStGenerateSetprinterCode() {
    try {
        var tTableName = 'TCNMPrinter';
        $('#oetSprCode').closest('.form-group').addClass("has-success").removeClass("has-error");
        $('#oetSprCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var tData = $.parseJSON(tResult);
                if (tData.rtCode == '1') {
                    $('#oetSprCode').val(tData.rtPrnCode);
                    $('#oetSprCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    //----------Hidden ปุ่ม Gen
                    $('.xCNiConGen').attr('disabled', true);
                } else {
                    $('#oetSprCode').val(tData.rtDesc);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxSetprinterResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JStGenerateSetprinterCode Error: ', err);
    }
}

/**
 * Functionality : Check Slip Message Code In DB
 * Parameters : {params}
 * Creator : 28/01/2018 supawat
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCheckSetprinterCode() {
    try {
        var tCode = $('#oetSprCode').val();
        var tTableName = 'TCNMPrinter';
        var tFieldName = 'FTPrnCode';
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
                success: function(tResult) {
                    var tData = $.parseJSON(tResult);
                    $('.btn-default').attr('disabled', true);
                    if (tData.rtCode == '1') { //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
                        alert('มี id นี้แล้วในระบบ');
                        JSvCallPageSetprinterEdit(tCode);
                    } else {
                        alert('ไม่พบระบบจะ Gen ใหม่');
                        JStGenerateSetprinterCode();
                    }
                    $('.wrap-input100').removeClass('alert-validate');
                    $('.btn-default').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxSetprinterResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    } catch (err) {
        console.log('JStCheckSetprinterCode Error: ', err);
    }
}

/**
 * Functionality : Set data on select multiple, use in table list main page
 * Parameters : -
 * Creator : 28/01/2018 supawat
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSetprinterSetDataBeforeDelMulti() { // Action start after delete all button click.
    try {
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each(function(pnIndex) {
            tValue += $(this).parents('tr.otrSetprinter').find('td.otdSprCode').text() + ', ';
        });
        $('#ospConfirmDelete').text(tValue.replace(/, $/, ""));
    } catch (err) {
        console.log('JSxSetprinterSetDataBeforeDelMulti Error: ', err);
    }
}


//Event Single Delete Printer
function JSaSetprinterDelete(pnPage, ptName, tIDCode) {

    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(",");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == '1') {
            //tDelName
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' (' + ptName + ')');
            $('#odvModalDelSetprinter').modal('show');
            $('#osmConfirm').unbind().click(function(evt) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "setprinterDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturn = JSON.parse(oResult);
                        if (aReturn['nStaEvent'] == '1') {
                            $('#odvModalDelSetprinter').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function() {
                                JSvSetprinterDataTable(pnPage);
                            }, 500);
                        } else {
                            alert(aReturn['tStaMessg']);
                        }
                        JSxSetprinterNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}


//Event Delete All Printer
function JSnSetprinterDelChoose(pnPage) {
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
                url: "setprinterDeleteMulti",
                data: { 'tIDCode': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        setTimeout(function() {
                            $('#odvModalDelCard').modal('hide');
                            $('#ospConfirmDelete').empty();
                            $('#ohdConfirmIDDelete').val('');
                            JSvCallPageSetprinter(pnPage);
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                        }, 1000);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JSxSetprinterNavDefult();
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

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator :  28/01/2018 supawat
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvSetprinterClickPage(ptPage) {
    try {
        var nPageCurrent = '';
        var nPageNew;
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPagePrinter .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPagePrinter .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvSetprinterDataTable(nPageCurrent);
    } catch (err) {
        console.log('JSvSetprinterClickPage Error: ', err);
    }
}


//Functionality : (event) Add/Edit Set printer
//Parameters : form
//Creator : 28/01/2018 supawat
//Return : object Status Event And Event Call Back
//Return Type : object
function JSnAddEditSetprinter(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmSetprinter').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "setprinterEventAdd") {
                if ($("#ohdCheckDuplicateSptCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmSetprinter').validate({
            rules: {
                oetSprCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "setprinterEventAdd") {
                                if ($('#ocbSetprinerAutoGenCode').is(':checked')) {
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

                oetSprName: { "required": {} },

            },
            messages: {
                oetSprCode: {
                    "required": $('#oetSprCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetSprCode').attr('data-validate-dublicateCode')
                },
                oetSprName: {
                    "required": $('#oetSprName').attr('data-validate-required'),
                    "dublicateCode": $('#oetSprName').attr('data-validate-dublicateCode')
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
                    data: $('#ofmSetprinter').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        if (nStaSprBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if (aReturn['nStaEvent'] == 1) {
                                switch (aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageSetprinterEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageSetprinterAdd();
                                        break;
                                    case '3':
                                        JSvCallPageSetprinter();
                                        break;
                                    default:
                                        JSvCallPageSetprinterEdit(aReturn['tCodeReturn']);
                                }
                            } else {
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallSprBackOption);
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });
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
    }
}

//Functionality: Insert Text In Modal Delete (Delete muti)
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

//Functionality: Function Chack Value LocalStorage (Delete muti)
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

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSetprinterIsCreatePage() {
    try {
        const tPrnCodeCode = $('#oetSprCode').data('is-created');
        var bStatus = false;
        if (tPrnCodeCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbSetprinterIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSetprinterIsUpdatePage() {
    try {
        const tPrnCodeCode = $('#oetSprCode').data('is-created');
        var bStatus = false;
        if (!tPrnCodeCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbSetprinterIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxSetprinterVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxSetprinterVisibleComponent Error: ', err);
    }
}