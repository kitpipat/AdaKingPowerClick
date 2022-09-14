var nStaSrvPriBrowseType = $('#oetSrvPriStaBrowse').val();
var tCallSrvPriBackOption = $('#oetSrvPriCallBackOption').val();
/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxSrvPriNavDefult();
    if (nStaSrvPriBrowseType != 1) {
        JSvCallPageSrvPri();
    } else {
        JSvCallPageSrvPriAdd();
    }
});

/*============================= End Auto Run =================================*/

/*============================= Begin Custom Form Validate ===================*/

var bUniqueSrvPriCode;
$.validator.addMethod(
    "uniqueSrvPriCode",
    function(tValue, oElement, aParams) {
        let tSrvPriCode = tValue;
        $.ajax({
            type: "POST",
            url: "ServerPrinterUniqueValidate/SrvPriCode",
            data: "tSrvPriCode=" + tSrvPriCode,
            dataType: "html",
            success: function(ptMsg) {
                // If vatrate and vat start exists, set response to true
                bUniqueSrvPriCode = (ptMsg == 'true') ? false : true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Custom validate uniqueSrvPriCode: ', jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueSrvPriCode;
    },
    "Vat Code is Already Taken"
);

// Override Error Message
jQuery.extend(jQuery.validator.messages, {
    required: "This field is required.",
    remote: "Please fix this field.",
    email: "Please enter a valid email address.",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Please enter a valid number.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});

/*============================= End Custom Form Validate =====================*/

/*============================= Begin Form Validate ==========================*/

/**
 * Functionality : (event) Add/Edit SrvPri
 * Parameters : ptRoute is route to add Customer Group data.
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnAddEditSrvPri(ptRoute) {



    // $.validator.addMethod('dublicateCode', function(value, element) {
    //     if (ptRoute == "ServerPrinterEventAdd") {
    //         if ($("ohdCheckDuplicateSrvPriCode").val() == 1) {
    //             return false;
    //         } else {
    //             return true;
    //         }
    //     } else {
    //         return true;
    //     }
    // }, '');
    // $('#ofmAddSrvPri').validate({
    //     rules: {
    //         oetSrvPriCode: {
    //             "required": {
    //                 depends: function(oElement) {
    //                     if (ptRoute == "ServerPrinterEventAdd") {
    //                         if ($('#ocbSrvPriAutoGenCode').is(':checked')) {
    //                             return false;
    //                         } else {
    //                             return true;
    //                         }
    //                     } else {
    //                         return true;
    //                     }
    //                 }
    //             },
    //             "dublicateCode": {}
    //         },
    //         oetSrvPriName: { "required": {} },
    //     },
    //     messages: {
    //         oetSrvPriCode: {
    //             "required": $('#oetSrvPriCode').attr('data-validate-required'),
    //             // "dublicateCode": $('#oetSrvPriCode').attr('data-validate-dublicateCode')
    //         },
    //         oetSrvPriName: {
    //             "required": $('#oetSrvPriName').attr('data-validate-required'),
    //         },
    //     },
    //     errorElement: "em",
    //     errorPlacement: function(error, element) {
    //         error.addClass("help-block");
    //         if (element.prop("type") === "checkbox") {
    //             error.appendTo(element.parent("label"));
    //         } else {
    //             var tCheck = $(element.closest('.form-group')).find('.help-block').length;
    //             if (tCheck == 0) {
    //                 error.appendTo(element.closest('.form-group')).trigger('change');
    //             }
    //         }
    //     },
    //     highlight: function(element, errorClass, validClass) {
    //         $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
    //     },
    //     unhighlight: function(element, errorClass, validClass) {
    //         $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
    //     },
    //     submitHandler: function(form) {
    //         if (!$('#ocbSrvPriAutoGenCode').is(':checked')) {
    //             JSxCheckServerPrinterCodeDupInDB(ptRoute);
    //         } else {
    //             JSxSrvPriAddUpdateInTable(ptRoute);

    //         }
    //     }
    // });
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddSrvPri').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "customerGroupEventAdd") {
                if ($("#ohdCheckDuplicateSrvPriCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddSrvPri').validate({
            rules: {
                oetSrvPriCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "customerGroupEventAdd") {
                                if ($('#ocbSrvPriAutoGenCode').is(':checked')) {
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
                oetSrvPriName: { "required": {} },
                oetLableFormatName: { "required": {} },
                // oetPortPrnName: { "required": {} }

            },
            messages: {
                oetSrvPriCode: {
                    "required": $('#oetSrvPriCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetSrvPriCode').attr('data-validate-dublicateCode')
                },
                oetSrvPriName: {
                    "required": $('#oetSrvPriName').attr('data-validate-required'),
                },
                oetLableFormatName: {
                    "required": $('#oetLableFormatName').attr('data-validate-required'),
                },
                // oetPortPrnName: {
                //     "required": $('#oetPortPrnName').attr('data-validate-required'),
                // },
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
                    data: $('#ofmAddSrvPri').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaSrvPriBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageSrvPriEdit(aReturn['tCodeReturn'],aReturn['tCodeReturn2'])
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageSrvPriAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageSrvPri();
                                }
                            } else {
                                FSvCMNSetMsgErrorDialog(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallSrvPriBackOption);
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


function JSxSrvPriAddUpdateInTable(ptRoute) {
    $.ajax({
        type: "POST",
        url: ptRoute,
        data: $('#ofmAddSrvPri').serialize(),
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaSrvPriBrowseType != 1) {
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == 1) {
                    if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                        JSvCallPageSrvPriEdit(aReturn['tCodeReturn'],aReturn['tCodeReturn2'])
                    } else if (aReturn['nStaCallBack'] == '2') {
                        JSvCallPageSrvPriAdd();
                    } else if (aReturn['nStaCallBack'] == '3') {
                        JSvCallPageSrvPri();
                    }
                } else {
                    alert(aReturn['tStaMessg']);
                }
            } else {
                JCNxCloseLoading();
                JCNxBrowseData(tCallSrvPriBackOption);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


/*============================= End Form Validate ============================*/

/**
 * Functionality : Function Clear Defult Button SrvPri
 * Parameters : -
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSrvPriNavDefult() {
    try {
        if (nStaSrvPriBrowseType != 1 || nStaSrvPriBrowseType == undefined) {
            $('.obtChoose').hide();
            $('#oliSrvPriTitleAdd').hide();
            $('#oliSrvPriTitleEdit').hide();
            $('#odvSrvPriMainMenu #odvBtnAddEdit').hide();
            $('#odvSrvPriMainMenu #odvBtnSrvPriInfo').show();
        } else {
            $('#odvModalBody #odvSrvPriMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliSrvPriNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvSrvPriBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNSrvPriBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNSrvPriBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    } catch (err) {
        console.log('JSxSrvPriNavDefult Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
 */
function JCNxResponseError(jqXHR, textStatus, errorThrown) {
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
        console.log('JCNxResponseError Error: ', err);
    }
}

/**
 * Functionality : Call SrvPri Page list
 * Parameters : {params}
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSrvPri() {
    try {
        localStorage.tStaPageNow = 'JSvCallPageSrvPriList';
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "ServerPrinterList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageSrvPri').html(tResult);
                JSvSrvPriDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvCallPageSrvPri Error: ', err);
    }
}

/**
 * Functionality : Call Recive Data List
 * Parameters : Ajax Success Event
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvSrvPriDataTable(pnPage) {
    try {
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "ServerPrinterDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataSrvPri').html(tResult);
                }
                JSxSrvPriNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); //โหลดภาษาใหม่
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvSrvPriDataTable Error: ', err);
    }
}

/**
 * Functionality : Call SrvPri Page Add
 * Parameters : {params}
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSrvPriAdd() {
    try {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "ServerPrinterPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaSrvPriBrowseType == 1) {
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(tResult);
                } else {
                    $('#odvSrvPriMainMenu #oliSrvPriTitleEdit').hide();
                    $('#odvSrvPriMainMenu #odvBtnSrvPriInfo').hide();
                    $('#odvSrvPriMainMenu #oliSrvPriTitleAdd').show();
                    $('#odvSrvPriMainMenu #odvBtnAddEdit').show();
                    $('#odvContentPageSrvPri').html(tResult);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvCallPageSrvPriAdd Error: ', err);
    }
}

/**
 * Functionality : Call SrvPri Page Edit
 * Parameters : {params}
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSrvPriEdit(ptSrvPriCode,ptSrvPriAgnCode) {
    try {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageSrvPriEdit', ptSrvPriCode);

        $.ajax({
            type: "POST",
            url: "ServerPrinterPageEdit",
            data: { tSrvPriCode: ptSrvPriCode,tSrvPriAgnCode:ptSrvPriAgnCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#oliSrvPriTitleAdd').hide();
                    $('#oliSrvPriTitleEdit').show();
                    $('#odvBtnSrvPriInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageSrvPri').html(tResult);
                    $('#oetSrvPriCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvCallPageSrvPriEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code SrvPri
 * Parameters : {params}
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStGenerateSrvPriCode() {
    try {
        var tTableName = 'TCNMPrnServer';
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var tData = $.parseJSON(tResult);
                if (tData.rtCode == '1') {
                    $('#oetSrvPriCode').val(tData.rtCgpCode);
                    $('#oetSrvPriCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    //----------Hidden ปุ่ม Gen
                    $('.xCNiConGen').attr('disabled', true);
                } else {
                    $('#oetSrvPriCode').val(tData.rtDesc);
                }
                $('#oetSrvPriName').focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JStGenerateSrvPriCode Error: ', err);
    }
}

/**
 * Functionality : Check SrvPri Code In DB
 * Parameters : {params}
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCheckSrvPriCode() {
    try {
        var tCode = $('#oetSrvPriCode').val();
        var tAgnCode = $('#oetSrvPriAgnCode').val();
        
        var tTableName = 'TCNMPrnServer';
        var tFieldName = 'FTSrvCode';
        if (tCode != '') {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: tTableName,
                    tFieldName: tFieldName,
                    tCode: tCode,
                    tAgnCode: tAgnCode
                },
                cache: false,
                success: function(tResult) {
                    var tData = $.parseJSON(tResult);
                    $('.btn-default').attr('disabled', true);
                    if (tData.rtCode == '1') { //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
                        alert('มี id นี้แล้วในระบบ');
                        JSvCallPageSrvPriEdit(tCode);
                    } else {
                        alert('ไม่พบระบบจะ Gen ใหม่');
                        JStGenerateSrvPriCode();
                    }
                    $('.wrap-input100').removeClass('alert-validate');
                    $('.btn-default').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    } catch (err) {
        console.log('JStCheckSrvPriCode Error: ', err);
    }
}

/**
 * Functionality : Set data on select multiple, use in table list main page
 * Parameters : -
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSrvPriSetDataBeforeDelMulti() { // Action start after delete all button click.
    try {
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each(function(pnIndex) {
            tValue += '';
        });
        var tConfirm = $('#ohdDeleteChooseconfirm').val();
        $('#ospConfirmDelete').text(tConfirm + tValue);
    } catch (err) {
        console.log('JSxSrvPriSetDataBeforeDelMulti Error: ', err);
    }
}

/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaSrvPriDelete(poElement = null, poEvent = null) {
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;

        var tValue = $(poElement).parents('tr.otrSrvPri').find('td.otdSrvPriCode').text();
        var tValueName = $(poElement).parents('tr.otrSrvPri').find('td.otdSrvPriName').text();
        var tValue2 = $(poElement).parents('tr.otrSrvPri').find('td.otdSrvPriCode').data('agncode');
        var tConfirm = $('#ohdDeleteconfirm').val();
        var tConfirmYN = $('#ohdDeleteconfirmYN').val();
        $('#ospConfirmDelete').text(tConfirm + ' ' + tValue + ' (' + tValueName + ')' + tConfirmYN);
        $('#ospCode').val(tValue);
        $('#ospCode2').val(tValue2);
        if (nCheckedCount <= 1) {
            $('#odvModalDelSrvPri').modal('show');
        }
    } catch (err) {
        console.log('JSaSrvPriDelete Error: ', err);
    }
}

/**
 * Functionality : Confirm delete
 * Parameters : -
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnSrvPriDelChoose() {
    try {
        JCNxOpenLoading();

        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if (nCheckedCount > 1) { // For mutiple delete

            var oChecked = $('#odvRGPList td input:checked');
            var aSrvPriCode = [];
            var aSrvPriAgnCode = [];
            $(oChecked).each(function(pnIndex) {
                aSrvPriCode[pnIndex] = $(this).parents('tr.otrSrvPri').find('td.otdSrvPriCode').text();
                aSrvPriAgnCode[pnIndex] = $(this).parents('tr.otrSrvPri').find('td.otdSrvPriCode').data('agncode');
            });

            $.ajax({
                type: "POST",
                url: "ServerPrinterDeleteMulti",
                data: { tSrvPriCode: JSON.stringify(aSrvPriCode) , tSrvPriAgnCode: JSON.stringify(aSrvPriAgnCode) },
                success: function(tResult) {
                    $('#odvModalDelSrvPri').modal('hide');
                    JSvSrvPriDataTable();
                    JSxSrvPriNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else { // For single delete

            var tSrvPriCode = $('#ospCode').val();
            var tSrvPriAgnCode = $('#ospCode2').val();
            // alert("=="+tSrvPriCode);
            $.ajax({
                type: "POST",
                url: "ServerPrinterDelete",
                data: { tSrvPriCode: tSrvPriCode , tSrvPriAgnCode:tSrvPriAgnCode},
                success: function(tResult) {
                    $('#odvModalDelSrvPri').modal('hide');
                    JSvSrvPriDataTable();
                    JSxSrvPriNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });


        }
        JCNxCloseLoading();
    } catch (err) {
        console.log('JSnSrvPriDelChoose Error: ', err);
    }
}

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvSrvPriClickPage(ptPage) {
    try {
        var nPageCurrent = '';
        var nPageNew;
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageSrvPri .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageSrvPri .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvSrvPriDataTable(nPageCurrent);
    } catch (err) {
        console.log('JSvSrvPriClickPage Error: ', err);
    }
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNSrvPriIsCreatePage() {
    try {
        const tSrvPriCode = $('#oetSrvPriCode').data('is-created');
        var bStatus = false;
        if (tSrvPriCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNSrvPriIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : Status true is update page
 * Return Type : Boolean
 */
function JCNSrvPriIsUpdatePage() {
    try {
        const tSrvPriCode = $('#oetSrvPriCode').data('is-created');
        var bStatus = false;
        if (tSrvPriCode != "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNSrvPriIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Show or hide delete all button
 * Show on multiple selections, Hide on one or none selection 
 * Use in table list main page
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSrvPriVisibledDelAllBtn(poElement = null, poEvent = null) { // Action start after change check box value.
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if (nCheckedCount > 1) {
            $('#oliBtnDeleteAll').removeClass("disabled");
        } else {
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    } catch (err) {
        console.log('JSxSrvPriVisibledDelAllBtn Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 20/12/2021 Worakorn
// Return: object Status Delete
// ReturnType: boolean
function JSbSrvPriIsCreatePage() {
    try {
        const tSrvPriCode = $('#oetSrvPriCode').data('is-created');
        var bStatus = false;
        if (tSrvPriCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbSrvPriIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 20/12/2021 Worakorn
// Return: object Status Delete
// ReturnType: boolean
function JSbSrvPriIsUpdatePage() {
    try {
        const tSrvPriCode = $('#oetSrvPriCode').data('is-created');
        var bStatus = false;
        if (!tSrvPriCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbVoucherIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 20/12/2021 Worakorn
// Return : -
// Return Type : -
function JSxSrvPriVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxVoucherVisibleComponent Error: ', err);
    }
}