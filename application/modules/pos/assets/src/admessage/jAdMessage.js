var nStaAdvBrowseType = $('#oetAdvStaBrowse').val();
var tCallAdvBackOption = $('#oetAdvCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxADVNavDefult();
    if (nStaAdvBrowseType != 1) {
        JSvCallPageAdMessage();
    } else {
        JSvCallPageAdMessageAdd();
    }
});

/*============================= End Auto Run =================================*/

/*============================= Begin Custom Form Validate ===================*/

var bUniqueAdvCode;
$.validator.addMethod(
    "uniqueAdvCode",
    function(tValue, oElement, aParams) {
        let tAdvCode = tValue;
        $.ajax({
            type: "POST",
            url: "adMessageUniqueValidate/advcode",
            data: "tAdvCode=" + tAdvCode,
            dataType: "html",
            success: function(ptMsg) {
                // If ad code exists, set response to true
                bUniqueAdvCode = (ptMsg == 'true') ? false : true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueAdvCode;
    },
    "Ad Code is Already Taken"
);

var bUniqueFileName;
$.validator.addMethod(
    "uniqueFileName",
    function(tValue, oElement, aParams) {
        let tFileName = oElement.files[0].name;
        $.ajax({
            type: "POST",
            url: "adMessageUniqueFileNameValidate/advFileName",
            data: "tFileName=" + tFileName + '&tAdvCode=' + $('#oetAdvCode').val(),
            dataType: "html",
            success: function(ptMsg) {
                // If file name exists, set response to true
                bUniqueFileName = (ptMsg == 'true') ? false : true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueFileName;
    },
    "File Name is Already Taken"
);

var bExtensionValidate;
$.validator.addMethod(
    "extensionValidate",
    function(tValue, oElement, tFileTypeFilter) {
        let tExtension = tValue.split('.').pop().toLowerCase();
        let aExtensions = tFileTypeFilter.split('|');

        if ($.inArray(tExtension, aExtensions) == -1) {
            console.log('Extension invalid');
            bExtensionValidate = false;
        } else {
            console.log('Extension valid');
            bExtensionValidate = true;
        }
        return bExtensionValidate;
    },
    "Extension is invalid"
);

var bFileSizeValidate;
$.validator.addMethod(
    "fileSizeValidate",
    function(tValue, oElement, tFileSizeFilter) {
        let nSizeFilter = tFileSizeFilter * 100000; // convert to byte 100000
        let nFileSize = oElement.files[0].size;
        if (nSizeFilter < nFileSize) {
            bFileSizeValidate = false;
        } else {
            bFileSizeValidate = true;
        }
        return bFileSizeValidate;
    },
    "File size is invalid"
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
 * Functionality : (event) Add/Edit Ad Message
 * Parameters : ptRoute is route to add ad message data.
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnAddEditAdMessage(ptRoute) {
    $('#ofmAddAdMessage').validate().destroy();
    $.validator.addMethod('dublicateCode', function(value, element) {
        if (ptRoute == "adMessageEventAdd") {
            if ($("#ohdCheckDuplicateAdvCode").val() == 1) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }, '');

    $('#ofmAddAdMessage').validate({
        rules: {
            oetAdvCode: {
                "required": {
                    depends: function(oElement) {
                        if (ptRoute == "adMessageEventAdd") {
                            if ($('#ocbAdvAutoGenCode').is(':checked')) {
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
            oetAdvName: { "required": {} },
            oetAdvStart: { "required": {} },
            oetAdvFinish: { "required": {} }
        },
        messages: {
            oetAdvCode: {
                "required": $('#oetAdvCode').attr('data-validate-required'),
                "dublicateCode": $('#oetAdvCode').attr('data-validate-dublicateCode')
            },
            oetAdvName: {
                "required": $('#oetAdvName').attr('data-validate-required'),
            },
            oetAdvStart: {
                "required": $('#oetAdvStart').attr('data-validate'),
            },
            oetAdvFinish: {
                "required": $('#oetAdvFinish').attr('data-validate'),
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
            $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
        },
        submitHandler: function(form) {
            JCNxOpenLoading();

            // console.log('eventAdd');

            if (JCNbIsMediaType()) {
                if (JCNnCountMediaRow() <= 0) {
                    JSxMediaRowDefualt(1);
                    JCNxCloseLoading();
                    return;
                }
            }

            var oFormData = new FormData();
            if (JCNbIsMediaType()) {
                var oMediaItems = $('#odvAdvMediaContainer .xWAdvItem.change-file');
                var aPdtMedKey = [];
                oMediaItems.each((pnIndex, poElement) => {
                    let nItemId = $(poElement).attr('id');
                    let oFile = $('#oetAdvMedia' + nItemId)[0].files[0];
                    let tMedKey = $('#oetAdvMedia' + nItemId).data('key');
                    oFormData.append('oetAdvMedia' + nItemId, oFile);
                    oFormData.append('oetAdvMediaKey' + nItemId, tMedKey);
                });
                oFormData.append('mediaSeqChange', JSON.stringify(JSaGetMediaChangeFileSort()));
                oFormData.append('mediaSeqChangeOld', JSON.stringify(JSaGetMediaChangeFileSortOfOld()));
                oFormData.append('mediaSeqNoChange', JSON.stringify(JSaGetMediaNoChangeFileSort()));
            }

            if (JSnGetAdTypeId() == 6) {
                // var aPdtImg = [];
                $('.xWImgCanvas').each(function(i) {
                    // aPdtImg.push( $(this).val() );
                    oFormData.append('aPdtImg['+i+']', $(this).val() );
                });
                // console.log(aPdtImg);
                // oFormData.append('aPdtImg', aPdtImg );
                // console.log(oFormData);

                //ถ้ารูปภาพน้อยกว่าหรือเท่ากับ 0 ให้ return กลับไป
                // if (ptRoute == "adMessageEventAdd" /*&& aPdtImg.length <= 0*/) {
                //     FSvCMNSetMsgWarningDialog('เพิ่มรูปภาพอย่างน้อย หนึ่งรูปภาพ');
                //     return;
                // }
            }

            oFormData.append('adTypeId', JSnGetAdTypeId());
            oFormData.append('ocbAdvAutoGenCode', ($(form.ocbAdvAutoGenCode).is(":checked") ? 1 : 2));
            oFormData.append('oetAdvCode', $(form.oetAdvCode).val());
            oFormData.append('oetAdvName', $(form.oetAdvName).val());
            oFormData.append('ocmAdvStatus', $('#ocmAdvStatus').val());
            oFormData.append('otaAdvRemark', $(form.otaAdvRemark).val());
            oFormData.append('oetAdvStart', $(form.oetAdvStart).val());
            oFormData.append('oetAdvFinish', $(form.oetAdvFinish).val());
            oFormData.append('oetAdvAgnCode', $(form.oetAdvAgnCode).val());
            oFormData.append('oetAdvAgnName', $(form.oetAdvAgnName).val());
            // oFormData.append('oetEvnTStart', $(form.oetEvnTStart).val());
            // oFormData.append('oetEvnTFinish', $(form.oetEvnTFinish).val());


            // var datestr = (new Date(fromDate)).toUTCString();
            // formdata.append("start", datestr);

            if (JCNbIsTextType()) {
                oFormData.append('oetAdvMsg', $(form.oetAdvMsg).val());
            } else {
                oFormData.append('oetAdvMsg', '');
            }

            // console.log(Array.from(oFormData));

            $.ajax({
                type: "POST",
                url: ptRoute,
                data: oFormData,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaAdvBrowseType != 1) {
                        // var aReturn = JSON.parse(JSON.stringify(tResult))
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            switch (aReturn['nStaCallBack']) {
                                case '1':
                                    JSvCallPageAdMessageEdit(aReturn['tCodeReturn']);
                                    break;
                                case '2':
                                    JSvCallPageAdMessageAdd();
                                    break;
                                case '3':
                                    JSvCallPageAdMessage();
                                    break;
                                default:
                                    JSvCallPageAdMessageEdit(aReturn['tCodeReturn']);
                            }

                        } else {
                            JCNxCloseLoading();
                            FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                        }
                    } else {
                        JCNxCloseLoading();
                        JCNxBrowseData(tCallAdvBackOption);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        },
    });

    // Media row validate
    if (JCNbIsMediaType()) { // 3: video, 5: sound
        $('.change-file .xWAdvMedia').each(function() { //.xWAdvMedia
            $(this).rules("add", {
                required: true,
                // extension: "avi|swf|mpg|wmf|mp4",
                extensionValidate: 'mp3|mp4|avi|wav|mpeg',
                fileSizeValidate: '2000', // unit kb
                uniqueFileName: true,
                // highlight: function(element, errorClass, validClass) {
                //     $(element).parents('.validate-input').addClass(errorClass).removeClass(validClass);
                // },
                // unhighlight: function(element, errorClass, validClass) {
                //     $(element).parents('.validate-input').removeClass(errorClass).addClass(validClass);
                // }
                highlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            });
        });
    }

    // Text row validate
    if (JCNbIsTextType()) { // 1: welcome message, 2: promotion message, 4: thank message
        $('#oetAdvMsg').rules("add", {
            required: true,
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            }
        });
    }
}

/*============================= End Form Validate ============================*/

/**
 * Functionality : Function Clear Defult Button Ad Message
 * Parameters : -
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxADVNavDefult() {

    if (nStaAdvBrowseType != 1 || nStaAdvBrowseType == undefined) {
        $('.xCNAdvVBrowse').hide();
        $('.xCNAdvVMaster').show();
        $('#oliAdvTitleAdd').hide();
        $('#oliAdvTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnAdvInfo').show();
    } else {
        $('#odvModalBody .xCNAdvVMaster').hide();
        $('#odvModalBody .xCNAdvVBrowse').show();
        $('#odvModalBody #odvAdvMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliAdvNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvAdvBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNAdvBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNAdvBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }

}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
 */
// function JCNxResponseError(jqXHR, textStatus, errorThrown) {

//     JCNxCloseLoading();
//     var tHtmlError = $(jqXHR.responseText);
//     var tMsgError = "<h3 style='font-size:20px;color:red'>";
//     tMsgError += "<i class='fa fa-exclamation-triangle'></i>";
//     tMsgError += " Error<hr></h3>";
//     switch (jqXHR.status) {
//         case 404:
//             tMsgError += tHtmlError.find('p:nth-child(2)').text();
//             break;
//         case 500:
//             tMsgError += tHtmlError.find('p:nth-child(3)').text();
//             break;

//         default:
//             tMsgError += 'something had error. please contact admin';
//             break;
//     }
//     $("body").append(tModal);
//     $('#modal-customs').attr("style", 'width: 450px; margin: 1.75rem auto;top:20%;');
//     $('#myModal').modal({ show: true });
//     $('#odvModalBody').html(tMsgError);

// }

/**
 * Functionality : Call Ad Message Page list
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageAdMessage() {
    localStorage.tStaPageNow = 'JSvCallPageBankList';

    $.ajax({
        type: "GET",
        url: "adMessageList",
        data: {},
        cache: false,
        timeout: 0,
        success: function(tResult) {

            $('#odvContentPageAdMessage').html(tResult);
            JSxADVNavDefult();

            JSvAdMessageDataTable(); //แสดงข้อมูลใน List
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
    // try{
    //     localStorage.tStaPageNow = 'JSvCallPageAdMessageList';

    //     $('#oetSearchAll').val('');
    //     $.ajax({
    //         type: "POST",
    //         url: "adMessageList",
    //         cache: false,
    //         timeout: 0,
    //         success: function(tResult) {
    //             $('#odvContentPageAdMessage').html(tResult);
    //             JSvAdMessageDataTable();
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // }catch(err){
    //     console.log('JSvCallPageAdMessage Error: ', err);
    // }
}

/**
 * Functionality : Call Recive Data List
 * Parameters : Ajax Success Event
 * Creator : 28/08/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvAdMessageDataTable(pnPage) {
    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "adMessageDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {

            $('#odvContentAdMessageData').html(tResult);

            JSxADVNavDefult();
            JCNxLayoutControll();
            // JStCMMGetPanalLangHTML('TCNMAdMsg_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
    // try{
    //     var tSearchAll = $('#oetSearchAll').val();
    //     var nPageCurrent = pnPage;
    //     if (nPageCurrent == undefined || nPageCurrent == '') {
    //         nPageCurrent = '1';
    //     }
    //     JCNxOpenLoading();
    //     $.ajax({
    //         type: "POST",
    //         url: "adMessageDataTable",
    //         data: {
    //             tSearchAll: tSearchAll,
    //             nPageCurrent: nPageCurrent
    //         },
    //         cache: false,
    //         Timeout: 5000,
    //         success: function(tResult) {
    //             if (tResult != "") {
    //                 $('#odvContentAdMessageData').html(tResult);
    //             }
    //             JSxADVNavDefult();
    //             JCNxLayoutControll();
    //             JStCMMGetPanalLangHTML('TCNMAdMsg_L'); //โหลดภาษาใหม่
    //             JCNxCloseLoading();
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // }catch(err){
    //     console.log('JSvAdMessageDataTable Error: ', err);
    // }
}

/**
 * Functionality : Call Ad Message Page Add
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageAdMessageAdd() {

    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "adMessagePageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaAdvBrowseType == 1) {
                $('.xCNAdvVMaster').hide();
                $('.xCNAdvVBrowse').show();
            } else {
                $('.xCNAdvVBrowse').hide();
                $('.xCNAdvVMaster').show();
                $('#oliAdvTitleEdit').hide();
                $('#oliAdvTitleAdd').show();
                $('#odvBtnAdvInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageAdMessage').html(tResult);
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

/**
 * Functionality : Call Ad Message Page Edit
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageAdMessageEdit(ptAdvCode) {

    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML('JSvCallPageAdMessageEdit', ptAdvCode);

    $.ajax({
        type: "POST",
        url: "adMessagePageEdit",
        data: { tAdvCode: ptAdvCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliAdvTitleAdd').hide();
                $('#oliAdvTitleEdit').show();
                $('#odvBtnAdvInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageAdMessage').html(tResult);
                $('#oetAdvCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

/**
 * Functionality : Generate Code Ad Message
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
// function JStGenerateAdMessageCode() {

//     var tTableName = 'TCNMAdMsg_L';
//     $.ajax({
//         type: "POST",
//         url: "generateCode",
//         data: { tTableName: tTableName },
//         cache: false,
//         timeout: 0,
//         success: function(tResult) {
//             var tData = $.parseJSON(tResult);
//             if (tData.rtCode == '1') {
//                 $('#oetAdvCode').val(tData.rtAdvCode);
//                 $('#oetAdvCode').addClass('xCNDisable');
//                 $('.xCNDisable').attr('readonly', true);
//                 //----------Hidden ปุ่ม Gen
//                 $('#obtGenCodeAdv').attr('disabled', true);
//             } else {
//                 $('#oetAdvCode').val(tData.rtDesc);
//             }
//             $('#oetAdvName').focus();
//         },
//         error: function(jqXHR, textStatus, errorThrown) {
//             JCNxResponseError(jqXHR, textStatus, errorThrown);
//         }
//     });

// }

/**
 * Functionality : Check Ad Message Code In DB
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
// function JStCheckAdMessageCode() {

//     var tCode = $('#oetAdvCode').val();
//     var tTableName = 'TCNMAdMsgHD_L';
//     var tFieldName = 'FTAdvCode';
//     if (tCode != '') {
//         $.ajax({
//             type: "POST",
//             url: "CheckInputGenCode",
//             data: {
//                 tTableName: tTableName,
//                 tFieldName: tFieldName,
//                 tCode: tCode
//             },
//             cache: false,
//             success: function(tResult) {
//                 var tData = $.parseJSON(tResult);
//                 $('.btn-default').attr('disabled', true);
//                 if (tData.rtCode == '1') { //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
//                     alert('มี id นี้แล้วในระบบ');
//                     JSvCallPageAdMessageEdit(tCode);
//                 } else {
//                     alert('ไม่พบระบบจะ Gen ใหม่');
//                     JStGenerateAdMessageCode();
//                 }
//                 $('.wrap-input100').removeClass('alert-validate');
//                 $('.btn-default').attr('disabled', false);
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 JCNxResponseError(jqXHR, textStatus, errorThrown);
//             }
//         });
//     }

// }

/**
 * Functionality : Set data on select multiple, use in table list main page
 * Parameters : -
 * Creator : 27/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSetDataBeforeDelMulti() { // Action start after delete all button click.
    try {
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each(function(pnIndex) {
            tValue += $(this).parents('tr.otrAdMessage').find('td.otdAdvCode').text() + ', ';
        });
        $('#ospConfirmDelete').text(tValue.replace(/, $/, ""));
    } catch (err) {
        console.log('JSxSetDataBeforeDelMulti Error: ', err);
    }
}

/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 27/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
// function JSaAdMessageDelete(poElement = null, poEvent = null){
//     try{
//         var nCheckedCount = $('#odvRGPList td input:checked').length;

//         var tValue = $(poElement).parents('tr.otrAdMessage').find('td.otdAdvCode').text();
//         $('#ospConfirmDelete').text(tValue);

//         if(nCheckedCount <= 1){
//             $('#odvModalDelAdMessage').modal('show');
//         }
//     }catch(err){
//         console.log('JSaAdMessageDelete Error: ', err);
//     }
// }
function JSaAdMessageDelete(pnPage, ptName, tIDCode) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelAdMessage').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ' ' + tIDCode + ' ( ' + ptName + ' ) ');
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "adMessageDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);

                        $('#odvModalDelAdMessage').modal('hide');
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        JSvAdMessageDataTable(pnPage);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }


        });
    }
}


/**
 * Functionality : Confirm delete
 * Parameters : -
 * Creator : 27/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnAdMessageDelChoose(pnPage) {
    JCNxOpenLoading();

    var tNamepage = '';
    var aDataIdBranch = '';
    var nStaBrowse = '';
    var tStaInto = '';
    var aData = $('#ohdConfirmIDDelete').val();
    //console.log('DATA : ' + aData);

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
            url: "adMessageDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {

                JSxADVNavDefult();
                setTimeout(function() {
                    $('#odvModalDelAdMessage').modal('hide');
                    JSvAdMessageDataTable(pnPage);
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
    // try{
    //     JCNxOpenLoading();

    //     var nCheckedCount = $('#odvRGPList td input:checked').length;
    //     if(nCheckedCount > 1){ // For mutiple delete

    //         var oChecked = $('#odvRGPList td input:checked');
    //         var aAdvCode = [];
    //         $(oChecked).each( function(pnIndex){
    //             aAdvCode[pnIndex] = $(this).parents('tr.otrAdMessage').find('td.otdAdvCode').text();
    //         });

    //         $.ajax({
    //             type: "POST",
    //             url: "adMessageDeleteMulti",
    //             data: {tAdvCode: JSON.stringify(aAdvCode)},
    //             success: function(tResult) {
    //                 $('#odvModalDelAdMessage').modal('hide');
    //                 JSvAdMessageDataTable();
    //                 JSxADVNavDefult();
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });

    //     }else{ // For single delete

    //         var tAdvCode = $('#ospConfirmDelete').text();

    //         $.ajax({
    //             type: "POST",
    //             url: "adMessageDelete",
    //             data: {tAdvCode: tAdvCode},
    //             success: function(tResult) {
    //                 $('#odvModalDelAdMessage').modal('hide');
    //                 JSvAdMessageDataTable();
    //                 JSxADVNavDefult();
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });

    //     }
    // }catch(err){
    //     console.log('JSnAdMessageDelChoose Error: ', err);
    // }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 18/01/2019 napat
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

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvAdMessageClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageAdMessage .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageAdMessage .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvAdMessageDataTable(nPageCurrent);

}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 31/08/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbIsCreatePage() {
    try {
        const tAdvCode = $('#oetAdvCode').data('is-created');
        var bStatus = false;
        if (tAdvCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNbIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Show or hide delete all button
 * Show on multiple selections, Hide on one or none selection 
 * Use in table list main page
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxVisibledDelAllBtn(poElement = null, poEvent = null) { // Action start after change check box value.
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if (nCheckedCount > 1) {
            $('.obtChoose').fadeIn(300);
        } else {
            $('.obtChoose').fadeOut(300);
        }
    } catch (err) {
        console.log('JSxVisibledDelAllBtn Error: ', err);
    }
}

/**
 * Functionality : Delete head recive or end recive row
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 06/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxDeleteMediaRow(poElement = null, poEvent = null) {
    try {
        if (JCNnCountMediaRow() <= 1) { return; }
        if (confirm('Delete ?')) {
            $(poElement).parents('.xWAdvItemSelect').remove();
            JSoMediaSortabled(true);
        }
    } catch (err) {
        console.log('JSxDeleteMediaRoww Error: ', err);
    }
}

/**
 * Functionality : Add media row
 * Parameters : -
 * Creator : 06/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAddMediaRow() {
    try {
        // if(JCNnCountMediaRow() >= 10){return;}

        let nIndex = JCNnGetMediaMaxID();
        let tTypeMedia = $('#oetAdvMediaType').val();
        // console.log('MaxID: ', JCNnGetMediaMaxID());
        let nCurrent = ++nIndex;
        // Get template in wAdMessageAdd.php
        var template = $.validator.format($.trim($('#oscAdvMediaTemplate').html()));
        // Add template
        $(template(nIndex++)).appendTo("#odvAdvMediaContainer");

        // setTimeout(function(){ 
        $('#' + nCurrent).find('.xWAdvFile').focus();
        //     console.log('JSxAddMediaRow' + nCurrent);
        // }, 1000);


        JSoMediaSortabled(true);
        switch (tTypeMedia) {
            case '3':
                $('.xWAdvMedia').attr('accept', 'video/mp4,video/x-m4v,video/*;');
                break;
            case '5':
                $('.xWAdvMedia').attr('accept', 'audio/mp3,audio/*;');
                break;
        }


    } catch (err) {
        console.log('JSxDeleteMediaRoww Error: ', err);
    }
}

/**
 * Functionality : Get max item id
 * Parameters : -
 * Creator : 07/09/2018 piya
 * Last Modified : -
 * Return : Max id number
 * Return Type : number
 */
function JCNnGetMediaMaxID() {
    try {
        // if(JCNnCountMediaRow() <= 0){return 0;}
        let nMaxID = 0;
        let oItems = $('#odvAdvMediaContainer .xWAdvItem');
        oItems.each((pnIndex, poElement) => {
            let tElementID = $(poElement).attr('id');
            // console.log('JCNnGetMediaMaxID: nMaxID: ' + nMaxID);
            // console.log('JCNnGetMediaMaxID: tElementID: ' + tElementID)
            // if(nMaxID < tElementID){
            nMaxID = tElementID;
            // }
        });
        return nMaxID;
    } catch (err) {
        console.log('JCNnGetMediaMaxID Error: ', err);
    }
}

/**
 * Functionality : Count row in media
 * Parameters : -
 * Creator : 06/09/2018 piya
 * Last Modified : -
 * Return : Row count
 * Return Type : number
 */
function JCNnCountMediaRow() {
    try {
        let nRow = $('#odvAdvMediaContainer .xWAdvItem').length;
        return nRow;
    } catch (err) {
        console.log('JCNnCountMediaRow Error: ', err);
    }
}

/**
 * Functionality : Display row default
 * Parameters : pnRows is number for row item
 * Creator : 07/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxMediaRowDefualt(pnRows) {
    try {
        // Validate pnRows
        if (pnRows <= 0) { return; } // Invalid exit function

        // Get template in wAdMessageAdd.php
        var template = $.validator.format($.trim($("#oscAdvMediaTemplate").html()));
        // console.log('JSxMediaRowDefualt');

        // Add template by pnRows
        for (let loop = 1; loop <= pnRows; loop++) {
            $(template(loop)).appendTo("#odvAdvMediaContainer");
        }
    } catch (err) {
        console.log('JSxDeleteMediaRoww Error: ', err);
    }
}

/**
 * Functionality : Prepare sort number
 * Parameters : pbUseStringFormat is use string format? (set true return string format, set false return object format)
 * Creator : 07/09/2018 piya
 * Last Modified : -
 * Return : Media value
 * Return Type : object
 */
function JSoMediaSortabled(pbUseStringFormat) {
    try {
        // console.log('JSoMediaSortabled');
        var oMediaItems = $('#odvAdvMediaContainer .xWAdvItem').find('.xWAdvMedia');
        // console.log('oMediaItems : ');
        // console.log(oMediaItems);
        var nSeq = 1;
        oMediaItems.each((pnIndex, poElement) => {
            $(poElement).attr('seq', nSeq);
            nSeq++;
            // console.log('poElement : ');
            // console.log(poElement);
        });
    } catch (err) {
        console.log('JSoMediaSortabled Error: ', err);
    }
}

/**
 * Functionality : Get sequence media no changed file
 * Parameters : -
 * Creator : 13/09/2018 piya
 * Last Modified : -
 * Return : Sequence
 * Return Type : array
 */
function JSaGetMediaNoChangeFileSort() {
    var oMediaItems = $('#odvAdvMediaContainer .xWAdvItem').not('.change-file').find('.xWAdvMedia');
    var aSeq = [];
    oMediaItems.each((pnIndex, poElement) => {
        aSeq[pnIndex] = { 'id': $(poElement).attr('media-id'), 'seq': $(poElement).attr('seq') };
    });
    return aSeq;
}

/**
 * Functionality : Get sequence media changed file
 * Parameters : -
 * Creator : 13/09/2018 piya
 * Last Modified : -
 * Return : Sequence
 * Return Type : array
 */
function JSaGetMediaChangeFileSort() {
    var oMediaItems = $('#odvAdvMediaContainer .xWAdvItem.change-file').find('.xWAdvMedia');
    var aSeq = [];
    oMediaItems.each((pnIndex, poElement) => {
        aSeq[pnIndex] = $(poElement).attr('seq');
    });
    return aSeq;
}

/**
 * Functionality : Get sequence media changed file of old
 * Parameters : -
 * Creator : 13/09/2018 piya
 * Last Modified : -
 * Return : Sequence
 * Return Type : array
 */
function JSaGetMediaChangeFileSortOfOld() {
    var oMediaItems = $('#odvAdvMediaContainer .xWAdvItem.change-file.old').find('.xWAdvMedia');
    var aSeq = [];
    oMediaItems.each((pnIndex, poElement) => {
        aSeq[pnIndex] = $(poElement).attr('media-id');
    });
    return aSeq;
}

/**
 * Functionality : Do when select option
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 10/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSelectAdType(poElement, poEvent) {
    try {
        // Reset all input field
        JSxResetInputFiled();
        let tAdTypeId = $(poElement).val();
        // console.log('tAdTypeId: ' + typeof tAdTypeId);
        switch (tAdTypeId) {
            case '1':
                JSxVisibledImageType(false);
                JSxVisibledTextType(true);
                JSxVisibledMediaType(false);
                break;
            case '2':
                JSxVisibledImageType(false);
                JSxVisibledTextType(true);
                JSxVisibledMediaType(false);
                break;
            case '3':
                JSxVisibledImageType(false);
                JSxVisibledTextType(false);
                JSxVisibledMediaType(true);
                break;
            case '4':
                JSxVisibledImageType(false);
                JSxVisibledTextType(true);
                JSxVisibledMediaType(false);
                break;
            case '5':
                JSxVisibledImageType(false);
                JSxVisibledTextType(false);
                JSxVisibledMediaType(true);
                break;
            case '6':
                JSxVisibledTextType(false);
                JSxVisibledMediaType(false);
                JSxVisibledImageType(true);
                break;
        }
        // if(JCNbIsTextType()){ // 1:Welcome Message, 2:Promotion Message, 4:Thank You
        //     JSxVisibledTextType(true);
        //     JSxVisibledMediaType(false);
        // }
        // if(JCNbIsMediaType()){ // 3:Video, 5:Sound, 6:Images
        //     JSxVisibledTextType(false);
        //     JSxVisibledMediaType(true);
        // }
    } catch (err) {
        console.log('JSxSelectAdType Error: ', err);
    }
}

/**
 * Functionality : Get ad type id
 * Parameters : -
 * Creator : 10/09/2018 piya
 * Last Modified : -
 * Return : Ad Type ID 1:Welcome Message, 2:Promotion Message, 4:Thank You, 3:Video, 5:Sound
 * Return Type : number
 */
function JSnGetAdTypeId() {
    try {
        return $('#oetAdvMediaType').val();
    } catch (err) {
        console.log('JSnGetAdTypeId Error: ', err);
    }
}

/**
 * Functionality : Text type check
 * Parameters : ptTextType is type for check ("welcome", "promotion", "thank", "all")
 * Creator : 12/09/2018 piya
 * Last Modified : -
 * Return : Type check
 * Return Type : boolean
 */
function JCNbIsTextType(ptTextType) {

    ptTextType = (typeof ptTextType == 'undefined') ? '' : ptTextType;
    var bIsType = false;
    var nTypeId = JSnGetAdTypeId();

    if (ptTextType == 'welcome') {
        if (nTypeId == 1) { // 1: welcome message
            bIsType = true;
        }
        return bIsType;
    }
    if (ptTextType == 'promotion') {
        if (nTypeId == 2) { // 2: promotion message
            bIsType = true;
        }
        return bIsType;
    }
    if (ptTextType == 'thank') {
        if (nTypeId == 4) { // 4: thank message
            bIsType = true;
        }
        return bIsType;
    }
    if (ptTextType == '') {
        if (nTypeId == 1 || nTypeId == 2 || nTypeId == 4) { // 1: welcome message, 2: promotion message, 4: thank message
            bIsType = true;
        }
        return bIsType;
    }
    return bIsType;

}

/**
 * Functionality : Media type check
 * Parameters : ptMediaType is type for check ("video", "sound", "all")
 * Creator : 12/09/2018 piya
 * Last Modified : -
 * Return : Type check
 * Return Type : boolean
 */
function JCNbIsMediaType(ptMediaType = 'all') {
    try {
        var bIsType = false;

        if (ptMediaType == 'video') {
            if (JSnGetAdTypeId() == 3) { // 3: video
                bIsType = true;
            }
            return bIsType;
        }
        if (ptMediaType == 'sound') {
            if (JSnGetAdTypeId() == 5) { // 5: sound
                bIsType = true;
            }
            return bIsType;
        }
        // if(ptMediaType == 'picture'){
        //     if(JSnGetAdTypeId() == 6){ // 6: sound
        //         bIsType = true;
        //     }
        //     return bIsType;
        // }
        if (ptMediaType == 'all') {
            if ((JSnGetAdTypeId() == 3) || (JSnGetAdTypeId() == 5)) { // 3: video, 5: sound //|| (JSnGetAdTypeId() == 6)
                bIsType = true;
            }
            return bIsType;
        }
        return bIsType;
    } catch (err) {
        console.log('JCNbIsMediaType Error: ', err);
    }
}

function JCNbIsImageType(ptMediaType = 'all') {
    try {
        var bIsType = false;

        if (ptMediaType == 'image') {
            if (JSnGetAdTypeId() == 6) {
                bIsType = true;
            }
            return bIsType;
        }
        if (ptMediaType == 'all') {
            if ((JSnGetAdTypeId() == 6)) {
                bIsType = true;
            }
            return bIsType;
        }
        return bIsType;
    } catch (err) {
        console.log('JCNbIsImageType Error: ', err);
    }
}

/**
 * Functionality : Show or Hide Text Input
 * Parameters : pbVisibled is true=show, false=hide
 * Creator : 10/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxVisibledTextType(pbVisibled) {
    try {
        if (pbVisibled) {
            $('#odvTextTypeContainer').show();
        } else {
            $('#odvTextTypeContainer').hide();
        }
    } catch (err) {
        console.log('JSxVisibledTextType Error: ', err);
    }
}

/**
 * Functionality : Show or Hide Media Input
 * Parameters : pbVisibled is true=show, false=hide
 * Creator : 10/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxVisibledMediaType(pbVisibled) {
    try {
        if (pbVisibled) {
            $('#odvMediaTypeContainer').show();
        } else {
            $('#odvMediaTypeContainer').hide();
        }
    } catch (err) {
        console.log('JSxVisibledMediaType Error: ', err);
    }
}

function JSxVisibledImageType(pbVisibled) {
    try {
        if (pbVisibled) {
            $('#odvImageTypeContainer').show();
        } else {
            $('#odvImageTypeContainer').hide();
        }
    } catch (err) {
        console.log('JSxVisibledMediaType Error: ', err);
    }
}

/**
 * Functionality : Clear all input field
 * Parameters : -
 * Creator : 11/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxResetInputFiled() {
    try {
        // Reset text message
        $('#oetAdvMsg').val('');
        // Reset media message
        $('#odvAdvMediaContainer').empty();
    } catch (err) {
        console.log('JSxResetInputFiled Error: ', err);
    }
}

/**
 * Functionality : Action for ad media input file changed.
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 13/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxChangedFile(poElement, poEvent) {
    var tMedKey = prompt("Please enter your media key:", "main");
    var tID = $(poElement).parents('.xWAdvItem').attr('id');
    if (tMedKey == null || tMedKey == "") {
        $('#oetAdvMedia' + tID).attr('data-key', 'NULL');
    } else {
        $('#oetAdvMedia' + tID).attr('data-key', tMedKey);
    }

    $(poElement).parents('.xWAdvItem').find('.xWAdvFile').val(poElement.files[0].name);
    $(poElement).parents('.xWAdvItem').addClass('change-file');
    $(poElement).removeAttr('data-media-id');
}

//Functionality: Search AdMessage List
//Parameters: tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
//Creator: 17/01/2019 Jame
//Return: View
//Return Type: View
function JSvSearchAllAdMessage() {
    var tSearchAll = $('#oetSearchAll').val();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "adMessageDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: 1
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#odvContentAdMessageData').html(tResult);
            }
            JSxADVNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMAdMsg_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 17/01/2019 Napat
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

//Functionality: Search AdMessage List
//Parameters: tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
//Creator: 17/01/2019 Jame
//Return: View
//Return Type: View
function JSvSearchAllBank() {
    var tSearchAll = $('#oetSearchAll').val();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "adMessageDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: 1
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#odvContentAdMessageData').html(tResult);
            }
            JSxADVNavDefult();
            JCNxLayoutControll();
            // JStCMMGetPanalLangHTML('TCNMAdMsg_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 18/01/2019 napat
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
function JSbAdvIsCreatePage() {
    try {
        const tAdvCode = $('#oetAdvCode').data('is-created');
        var bStatus = false;
        if (tAdvCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbAdvIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbAdvIsUpdatePage() {
    try {
        const tAdvCode = $('#oetAdvCode').data('is-created');
        var bStatus = false;
        if (!tAdvCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbAdvIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxAdvVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxAdvVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbAdvIsCreatePage() {
    try {
        const tAdvCode = $('#oetAdvCode').data('is-created');
        var bStatus = false;
        if (tAdvCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbAdvIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbAdvIsUpdatePage() {
    try {
        const tAdvCode = $('#oetAdvCode').data('is-created');
        var bStatus = false;
        if (!tAdvCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbAdvIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxAdvVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxAdvVisibleComponent Error: ', err);
    }
}