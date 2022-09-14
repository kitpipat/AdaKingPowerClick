var nStaLabPriBrowseType = $('#oetLabPriStaBrowse').val();
var tCallLabPriBackOption = $('#oetLabPriCallBackOption').val();
/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxLabPriNavDefult();
    if (nStaLabPriBrowseType != 1) {
        JSvCallPageLabPri();
    } else {
        JSvCallPageLabPriAdd();
    }
});

/*============================= End Auto Run =================================*/



/*============================= Begin Custom Form Validate ===================*/

var bUniqueLabPriCode;
$.validator.addMethod(
    "uniqueLabPriCode",
    function(tValue, oElement, aParams) {
        let tLabPriCode = tValue;
        $.ajax({
            type: "POST",
            url: "LablePrinterUniqueValidate/LabPriCode",
            data: "tLabPriCode=" + tLabPriCode,
            dataType: "html",
            success: function(ptMsg) {
                // If vatrate and vat start exists, set response to true
                bUniqueLabPriCode = (ptMsg == 'true') ? false : true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Custom validate uniqueLabPriCode: ', jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueLabPriCode;
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
 * Functionality : (event) Add/Edit LabPri
 * Parameters : ptRoute is route to add Customer Group data.
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnAddEditLabPri(ptRoute) {

    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddLabPri').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "customerGroupEventAdd") {
                if ($("#ohdCheckDuplicateLabPriCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddLabPri').validate({
            rules: {
                oetLabPriCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "customerGroupEventAdd") {
                                if ($('#ocbLabPriAutoGenCode').is(':checked')) {
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
                oetLabPriName: { "required": {} },
                oetLableFormatName: { "required": {} },
                // oetPortPrnName: { "required": {} }

            },
            messages: {
                oetLabPriCode: {
                    "required": $('#oetLabPriCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetLabPriCode').attr('data-validate-dublicateCode')
                },
                oetLabPriName: {
                    "required": $('#oetLabPriName').attr('data-validate-required'),
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
                    data: $('#ofmAddLabPri').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaLabPriBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageLabPriEdit(aReturn['tCodeReturn'],aReturn['tAgnCode'])
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageLabPriAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageLabPri();
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallLabPriBackOption);
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

/*============================= End Form Validate ============================*/

/**
 * Functionality : Function Clear Defult Button LabPri
 * Parameters : -
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxLabPriNavDefult() {
    try {
        if (nStaLabPriBrowseType != 1 || nStaLabPriBrowseType == undefined) {
            $('.obtChoose').hide();
            $('#oliLabPriTitleAdd').hide();
            $('#oliLabPriTitleEdit').hide();
            $('#odvLabPriMainMenu #odvBtnAddEdit').hide();
            $('#odvLabPriMainMenu #odvBtnLabPriInfo').show();
        } else {
            $('#odvModalBody #odvLabPriMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliLabPriNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvLabPriBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNLabPriBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNLabPriBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    } catch (err) {
        console.log('JSxLabPriNavDefult Error: ', err);
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
 * Functionality : Call LabPri Page list
 * Parameters : {params}
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageLabPri() {
    try {
        localStorage.tStaPageNow = 'JSvCallPageLabPriList';
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "LablePrinterList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageLabPri').html(tResult);
                JSvLabPriDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvCallPageLabPri Error: ', err);
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
function JSvLabPriDataTable(pnPage) {
    try {
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "LablePrinterDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataLabPri').html(tResult);
                }

                var aArrayConvert = JSON.parse(localStorage.getItem("LocalItemData"));
                if (aArrayConvert !== null) {
                    $.each(aArrayConvert, function(key, value) {
                        // console.log(value['nCode'].split(','));
                        let aDataCode = value['nCode'].split(',');
                        $('.xWCheckBox_'+aDataCode[0]+'_'+aDataCode[1]).prop("checked", true);
                    });

                }
                if (aArrayConvert !== null) {
                    if (aArrayConvert.length > 0) {
                        $('#obtExportPrintSet').prop('disabled', false);
                    } else {
                        $('#obtExportPrintSet').prop('disabled', true);
                    }

                    if( aArrayConvert[0] !== undefined ){
                        if (aArrayConvert[0].length > 1) {
                            $('#oliBtnDeleteAll').removeClass("disabled");
                        } else {
                            $('#oliBtnDeleteAll').addClass("disabled");
                        }
                    }else{
                        $('#oliBtnDeleteAll').addClass("disabled");
                    }
                    
                }

                var nCheckLoop = 0
                var nMaxItem = $('.ocbListItem').length
                $.each($('.ocbListItem'), function(key, value) {

                    var tCheckprop = $(value).prop("checked")
                    if (tCheckprop === true) {
                        nCheckLoop += 1
                    }
                });

                if (nMaxItem == nCheckLoop) {
                    $('.ocmCENCheckDeleteAll').prop("checked", true)
                }




                JSxLabPriNavDefult();
                JCNxLayoutControll();
                // JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); //โหลดภาษาใหม่
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvLabPriDataTable Error: ', err);
    }
}

/**
 * Functionality : Call LabPri Page Add
 * Parameters : {params}
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageLabPriAdd() {
    try {
        JCNxOpenLoading();
        // JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "LablePrinterPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaLabPriBrowseType == 1) {
                    localStorage.removeItem('LocalItemData');
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(tResult);
                } else {
                    $('#odvLabPriMainMenu #oliLabPriTitleEdit').hide();
                    $('#odvLabPriMainMenu #odvBtnLabPriInfo').hide();
                    $('#odvLabPriMainMenu #oliLabPriTitleAdd').show();
                    $('#odvLabPriMainMenu #odvBtnAddEdit').show();
                    $('#odvContentPageLabPri').html(tResult);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvCallPageLabPriAdd Error: ', err);
    }
}

/**
 * Functionality : Call LabPri Page Edit
 * Parameters : {params}
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageLabPriEdit(ptLabPriCode,ptAgnCode) {
    try {
        JCNxOpenLoading();
        // JStCMMGetPanalLangSystemHTML('JSvCallPageLabPriEdit', ptLabPriCode);

        $.ajax({
            type: "POST",
            url: "LablePrinterPageEdit",
            data: { tLabPriCode: ptLabPriCode, tAgnCode: ptAgnCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    localStorage.removeItem('LocalItemData');
                    $('#oliLabPriTitleAdd').hide();
                    $('#oliLabPriTitleEdit').show();
                    $('#odvBtnLabPriInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageLabPri').html(tResult);
                    $('#oetLabPriCode').addClass('xCNDisable');
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
        console.log('JSvCallPageLabPriEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code LabPri
 * Parameters : {params}
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStGenerateLabPriCode() {
    try {
        var tTableName = 'TCNMPrnLabel';
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var tData = $.parseJSON(tResult);
                if (tData.rtCode == '1') {
                    $('#oetLabPriCode').val(tData.rtCgpCode);
                    $('#oetLabPriCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    //----------Hidden ปุ่ม Gen
                    $('.xCNiConGen').attr('disabled', true);
                } else {
                    $('#oetLabPriCode').val(tData.rtDesc);
                }
                $('#oetLabPriName').focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JStGenerateLabPriCode Error: ', err);
    }
}

/**
 * Functionality : Check LabPri Code In DB
 * Parameters : {params}
 * Creator : 20/12/2021 Worakorn
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCheckLabPriCode() {
    try {
        var tCode = $('#oetLabPriCode').val();
        var tAgnCode = $('#oetLabPriAgnCode').val();
        var tTableName = 'TCNMPrnLabel';
        var tFieldName = 'FTPlbCode';
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
                        JSvCallPageLabPriEdit(tCode,tAgnCode);
                    } else {
                        alert('ไม่พบระบบจะ Gen ใหม่');
                        JStGenerateLabPriCode();
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
        console.log('JStCheckLabPriCode Error: ', err);
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
function JSxLabPriSetDataBeforeDelMulti() { // Action start after delete all button click.
    try {
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each(function(pnIndex) {
            tValue += '';
        });
        var tConfirm = $('#ohdDeleteChooseconfirm').val();
        $('#ospConfirmDelete').text(tConfirm + tValue);
    } catch (err) {
        console.log('JSxLabPriSetDataBeforeDelMulti Error: ', err);
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
function JSaLabPriDelete(poElement = null, ptAgnCode) {
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;

        var tValue = $(poElement).parents('tr.otrLabPri').find('td.otdLabPriCode').text();
        var tValueName = $(poElement).parents('tr.otrLabPri').find('td.otdLabPriName').text();
        var tConfirm = $('#ohdDeleteconfirm').val();
        var tConfirmYN = $('#ohdDeleteconfirmYN').val();
        $('#ospConfirmDelete').text(tConfirm + ' ' + tValue + ' (' + tValueName + ')' + tConfirmYN);
        $('#ospCode').val(tValue);
        $('#ospAgnCode').val(ptAgnCode);

        if (nCheckedCount <= 1) {
            $('#odvModalDelLabPri').modal('show');
        }
    } catch (err) {
        console.log('JSaLabPriDelete Error: ', err);
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
function JSnLabPriDelChoose() {
    try {
        JCNxOpenLoading();

        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if (nCheckedCount > 1) { // For mutiple delete
            //
            // var oChecked = $('#odvRGPList td input:checked');
            // var aLabPriCode = [];
            // $(oChecked).each(function(pnIndex) {
            //     aLabPriCode[pnIndex] = $(this).parents('tr.otrLabPri').find('td.otdLabPriCode').text();
            // });

            // $(oChecked).each(function(pnIndex) {
            //     aLabPriCode[pnIndex] = {
            //         'FTPlbCode' : $(this).parents('tr.otrLabPri').attr('data-code'),
            //         'FTAgnCode' : $(this).parents('tr.otrLabPri').attr('data-agn'),
            //     }
            // });
            var aArrayConvert = localStorage.getItem("LocalItemData");

            $.ajax({
                type: "POST",
                url: "LablePrinterDeleteMulti",
                data: { 
                    aArrayData: aArrayConvert
                },
                success: function(tResult) {
                    $('#odvModalDelLabPri').modal('hide');
                    JSvLabPriDataTable();
                    JSxLabPriNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else { // For single delete

            var tLabPriCode = $('#ospCode').val();
            var tAgnCode = $('#ospAgnCode').val();
            // alert("=="+tLabPriCode);
            $.ajax({
                type: "POST",
                url: "LablePrinterDelete",
                data: { tLabPriCode: tLabPriCode, tAgnCode: tAgnCode },
                success: function(tResult) {
                    $('#odvModalDelLabPri').modal('hide');
                    JSvLabPriDataTable();
                    JSxLabPriNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });


        }
        JCNxCloseLoading();
    } catch (err) {
        console.log('JSnLabPriDelChoose Error: ', err);
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
function JSvLabPriClickPage(ptPage) {
    try {
        var nPageCurrent = '';
        var nPageNew;
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageLabPri .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageLabPri .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvLabPriDataTable(nPageCurrent);
    } catch (err) {
        console.log('JSvLabPriClickPage Error: ', err);
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
function JCNLabPriIsCreatePage() {
    try {
        const tLabPriCode = $('#oetLabPriCode').data('is-created');
        var bStatus = false;
        if (tLabPriCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNLabPriIsCreatePage Error: ', err);
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
function JCNLabPriIsUpdatePage() {
    try {
        const tLabPriCode = $('#oetLabPriCode').data('is-created');
        var bStatus = false;
        if (tLabPriCode != "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNLabPriIsUpdatePage Error: ', err);
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
function JSxLabPriVisibledDelAllBtn(poElement = null, poEvent = null) { // Action start after change check box value.
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        // if (nCheckedCount > 1) {
        //     $('#oliBtnDeleteAll').removeClass("disabled");
        // } else {
        //     $('#oliBtnDeleteAll').addClass("disabled");
        // }

        // if (nCheckedCount >= 1) {
        //     $('#obtExportPrintSet').prop('disabled', false);
        // } else {
        //     $('#obtExportPrintSet').prop('disabled', true);
        // }

        var nCheckLoop = 0
        var nMaxItem = $('.ocbListItem').length


        $.each($('.ocbListItem'), function(key, value) {
            var tCheckprop = $(value).prop("checked")
            if (tCheckprop === true) {
                nCheckLoop += 1
            }
        });

        if (nMaxItem == nCheckLoop) {
            $('.ocmCENCheckDeleteAll').prop("checked", true)
        } else {
            $('.ocmCENCheckDeleteAll').prop("checked", false)
        }

        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0].length > 0) {
            $('#obtExportPrintSet').prop('disabled', false);
        } else {
            $('#obtExportPrintSet').prop('disabled', true);
        }

        if (aArrayConvert[0].length > 1) {
            $('#oliBtnDeleteAll').removeClass("disabled");
        } else {
            $('#oliBtnDeleteAll').addClass("disabled");
        }

    } catch (err) {
        console.log('JSxLabPriVisibledDelAllBtn Error: ', err);
    }
}




// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 20/12/2021 Worakorn
// Return: object Status Delete
// ReturnType: boolean
function JSbLabPriIsCreatePage() {
    try {
        const tLabPriCode = $('#oetLabPriCode').data('is-created');
        var bStatus = false;
        if (tLabPriCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbLabPriIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 20/12/2021 Worakorn
// Return: object Status Delete
// ReturnType: boolean
function JSbLabPriIsUpdatePage() {
    try {
        const tLabPriCode = $('#oetLabPriCode').data('is-created');
        var bStatus = false;
        if (!tLabPriCode == "") { // Have data
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
function JSxLabPriVisibleComponent(ptComponent, pbVisible, ptEffect) {
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







function JSnLabPriExportChoose() {
    try {

        var tPlbPrnSrvCode = $('#oetPlbPrnSrvCode').val();
        if( tPlbPrnSrvCode == "" ){
            FSvCMNSetMsgWarningDialog('กรุณาเลือก ปริ้นเตอร์เซิร์ฟเวอร์');
            return;
        }

        JCNxOpenLoading();
        // var oChecked = $('#odvRGPList td input:checked');
        // var aLabPriCode = [];
        // $(oChecked).each(function(pnIndex) {
        //     aLabPriCode[pnIndex] = $(this).parents('tr.otrLabPri').find('td.otdLabPriCode').text();
        // });
        // $(oChecked).each(function(pnIndex) {
        //     aLabPriCode[pnIndex] = {
        //         'FTPlbCode' : $(this).parents('tr.otrLabPri').attr('data-code'),
        //         'FTAgnCode' : $(this).parents('tr.otrLabPri').attr('data-agn'),
        //     }
        // });
        var aArrayConvert = localStorage.getItem("LocalItemData");
        $.ajax({
            type: "POST",
            url: "LablePrinterEventExportJson",
            data: {
                // tLabPriCode: JSON.stringify(aLabPriCode)
                // tLabPriCode: aArrayConvert
                aArrayData  : aArrayConvert,
                tSrvCode    : tPlbPrnSrvCode
            },
            success: function(tResult) {
                // console.log(tResult);
                var oBlob = new Blob([tResult]);
                var oLink = document.createElement('a');
                // console.log(oBlob);
                oLink.href = window.URL.createObjectURL(oBlob);
                oLink.download = "Setup_Printer.json";
                oLink.click();
                // console.log(oLink);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        JCNxCloseLoading();
    } catch (err) {
        console.log('JSnLabPriExportChoose Error: ', err);
    }
}




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