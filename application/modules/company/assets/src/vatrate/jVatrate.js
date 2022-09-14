var nStaVatBrowseType = $('#oetVatStaBrowse').val();
var tCallVatBackOption = $('#oetVatCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxVatNavDefult();
    if (nStaVatBrowseType != 1) {
        JSvCallPageVatrateList();
    } else {
        JSvCallPageVatrateAdd();
    }
});

/*============================= End Auto Run =================================*/

/*============================= Begin Record Operator ========================*/

/**
 * Functionality : Validate record before save
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 29/08/2018 piya
 * Last Modified : -
 * Return : {return}
 * Return Type : {type}
 */
function JSxVatStartRecordValidate(poElement, poEvent) {
    try {
        var tFieldName = $(poElement).attr('name');
        var tAddVatStart = $(poElement).val();
        var oRecord = $('#otbRateList > tr').not('.hidden').not('#otrNoVatData');
        // Init validate effect
        $(poElement).removeClass('record-invalid');
        JCNxVisibledOperationIcon(poElement, 'save', true); // show save icon
        $(poElement).parent('.validate-input').attr('title', 'วันที่นี้นำไปใช้ได้');
        // Start validate
        $.each(oRecord, function(kpnIndexey, poEl) {
            if ($(poElement).attr('name') == $(poEl).find('.xWVatStart').attr('name')) {} else {
                var tVatStart = $(poEl).find('.xWVatStart').val();
                if (tAddVatStart == tVatStart) {
                    // After validate effect (invalid)
                    $(poElement).parent('.validate-input').attr('title', 'วันที่นี้ถูกใช้ไปแล้ว');
                    $(poElement).addClass('record-invalid');
                    JCNxVisibledOperationIcon(poElement, 'save', false); // hidden save icon
                }
            }
        });
    } catch (err) {
        console.log('JSxVatStartRecordValidate Error: ', err);
    }
}

/**
 * Functionality : Function Clear Defult Button Vatrate
 * Parameters : documet ready and Function Parameter
 * Creator : 13/06/2018 wasin
 * Last Modified : -
 * Return : Set Default Button View User
 * Return Type : n/a
 */
function JSxVatNavDefult() {
    try {
        if (nStaVatBrowseType != 1 || nStaVatBrowseType == undefined) {
            $('.xCNVatVBrowse').hide();
            $('.xCNVatVMaster').show();
            $('#oliVatTitleAdd').hide();
            $('#oliVatTitleEdit').hide();
            $('#oliVatTitleManage').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnVatInfo').show();
        } else {
            $('#odvModalBody .xCNVatVMaster').hide();
            $('#odvModalBody .xCNVatVBrowse').show();
            $('#odvModalBody #odvVatMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliVatNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvVatBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNVatBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNVatBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    } catch (err) {
        console.log('JSxVatNavDefult Error: ', err);
    }
}

/**
 * Functionality : Call Vatrate Page list
 * Parameters : Document Ready And Event Call Back
 * Creator : 13/06/2018 wasin
 * Last Modified : -
 * Return : View Html user List
 * Return Type : View
 */
function JSvCallPageVatrateList() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            localStorage.removeItem('LocalItemData');
            localStorage.tStaPageNow = 'JSvCallPageVatrateList';
            $('#oetSearchAll').val('');
            $.ajax({
                type: "POST",
                url: "vatrateList",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvContentPageVatrate').html(tResult);
                    JSvVatrateDataTable();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSvCallPageVatrateList Error: ', err);
    }
}

/**
 * Functionality : Call Page Vatrate Add
 * Parameters : Event Button Click Call Function
 * Creator : 13/06/2018 wasin
 * Last Modified : -
 * Return : View
 * Return Type : View
 */
function JSvCallPageVatrateAdd() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "vatratePageAdd",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaVatBrowseType == 1) {
                        $('#odvModalBody .xCNVatVMaster').hide();
                        $('#odvModalBody .xCNVatVBrowse').show();
                    } else {
                        $('.xCNVatVBrowse').hide();
                        $('.xCNVatVMaster').show();
                        $('#oliVatTitleManage').hide();
                        $('#oliVatTitleEdit').hide();
                        $('#oliVatTitleAdd').show();
                        $('#odvBtnVatInfo').hide();
                        $('#odvBtnAddEdit').show();
                    }
                    $('#odvContentPageVatrate').html(tResult);
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
    } catch (err) {
        console.log('JSvCallPageVatrateAdd Error: ', err);
    }
}

/**
 * Functionality : Call Vatrate Data List
 * Parameters : JS Function Parameter
 * Creator : 13/06/2018 wasin
 * Last Modified : -
 * Return : View Datatable
 * Return Type : View
 */
function JSvVatrateDataTable(pnPage) {
    try {
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
                url: "vatrateDataTable",
                data: {
                    tSearchAll: tSearchAll,
                    nPageCurrent: nPageCurrent
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $('#ostDataVatrate').html(tResult);
                    }
                    JSxVatNavDefult();
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
    } catch (err) {
        console.log('JSvVatrateDataTable Error: ', err);
    }
}

/**
 * Functionality : Call Vatrate Page Edit
 * Parameters : Event Button Click Event
 * Creator : 13/06/2018 wasin
 * Last Modified : -
 * Return : View
 * Return Type : View
 */
function JSvCallPageVatrateEdit(ptVatCode) {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "vatratePageEdit",
                data: { tVatCode: ptVatCode },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $('#oliUsrTitleAdd').hide();
                        $('#oliUsrTitleEdit').hide();
                        $('#oliVatTitleAdd').hide();
                        $('#oliVatTitleManage').show();
                        $('#odvBtnVatInfo').hide();
                        $('#odvBtnAddEdit').show();
                        $('#odvContentPageVatrate').html(tResult);
                        $('#oetVatCode').addClass('xCNDisable');
                        $('.xCNiConGen').attr('readonly', true);
                        $('#oetVatCode').attr('readonly', true);
                        //
                        $('.xWVatSave').hide();
                        $('.xWVatCancel').hide();
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
    } catch (err) {
        console.log('JSvCallPageVatrateEdit Error: ', err);
    }
}

/**
 * Functionality : Delete Record Before to Save.
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 23/08/2018 piya
 * Last Modified : 27/08/2018 piya
 * Return : -
 * Return Type : -
 */
function JSxDeleteOperator(poElement, poEvent) {
    try {
        var tComfirmDelete = $('#oetTextComfirmDeleteMulti').val();
        $('#odvModalComfirmDelVatrate').modal('show');
        $('#ospComfirmDelete').html(tComfirmDelete);
        $('#osmConfirmDelete').on('click', function(evt) {
        // // if (confirm('Delete. ?')) {
            $(poElement).parents('.otrVRate').addClass('hidden');
            $('#odvModalComfirmDelVatrate').modal('hide');
        });
    } catch (err) {
        console.log('JSxDeleteOperator Error: ', err);
    } 
}

/**
 * Functionality : Edit Record Before to Save.
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 23/08/2018 piya
 * Last Modified : 27/08/2018 piya
 * Return : -
 * Return Type : -
 */
function JSxEditOperator(poElement, poEvent) {

    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            var tRecordId = $(poElement).parents('.otrVRate').attr('id');
            var oRecord = {
                tVatRate: $(poElement).parents('.otrVRate').find('input.xWVat').val(),
                tVatStart: $(poElement).parents('.otrVRate').find('input.xWVatStart').val()
            };
            // Backup Seft Record
            localStorage.setItem(tRecordId, JSON.stringify(oRecord));

            // Remove Percent Symbol.
            JSxSetFormatVatrateField(poElement, poEvent, 'remove-percent');

            // Visibled icons
            $('#'+tRecordId).find('.xWVatEdit').addClass('hidden').hide();
            $('#'+tRecordId).find('.xWVatSave').removeClass('hidden').show();
            $('#'+tRecordId).find('.xWVatCancel').removeClass('hidden').show();

            // Active Vatrate Field.
            $(poElement) // Active Vatrate Field.
                .parents('.otrVRate')
                .find('input.xWVat')
                .removeAttr('disabled')
                .addClass('active');

            // Active Vatrate Start Field.
            $(poElement)
                .parents('.otrVRate')
                .find('input.xWVatStart')
                .removeAttr('disabled')
                .addClass('btn');
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSxEditOperator Error: ', err);
    }
}

/**
 * Functionality : Cancel Edit Record Before to Save.
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 23/08/2018 piya
 * Last Modified : 27/08/2018 piya
 * Return : -
 * Return Type : -
 */
function JSxCancelOperator(poElement, poEvent) {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tRecordId = $(poElement).parents('.otrVRate').attr('id');
            // Restore Seft Record
            var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
            $(poElement).parents('.otrVRate').find('input.xWVat').val(oBackupRecord.tVatRate.replace(' %', ''));
            $(poElement).parents('.otrVRate').find('input.xWVatStart').val(oBackupRecord.tVatStart);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

            // Add Percent Symbol.
            JSxSetFormatVatrateField(poElement, poEvent, 'add-percent');

            // Visibled icons
            $('#'+tRecordId).find('.xWVatEdit').removeClass('hidden').show();
            $('#'+tRecordId).find('.xWVatSave').addClass('hidden').hide();
            $('#'+tRecordId).find('.xWVatCancel').addClass('hidden').hide();

            $(poElement) // Clear Active Vatrate Field.
                .parents('.otrVRate')
                .find('input.xWVat')
                .attr('disabled', true)
                .removeClass('active');

            $(poElement) // Clear Active Vatrate Start Field.
                .parents('.otrVRate')
                .find('input.xWVatStart')
                .attr('disabled', true)
                .removeClass('btn')
                .removeClass('record-invalid');
        }else{
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSxCancelOperator Error: ', err);
    }
}

/**
 * Functionality : Confirm Record Before to Save.
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 27/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSaveOperator(poElement, poEvent) {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tRecordId = $(poElement).parents('.otrVRate').attr('id');
            JSxSetFormatVatrateField(poElement, poEvent, 'add-percent');
            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

            // Visibled icons
            $('#'+tRecordId).find('.xWVatEdit').removeClass('hidden').show();
            $('#'+tRecordId).find('.xWVatSave').addClass('hidden').hide();
            $('#'+tRecordId).find('.xWVatCancel').addClass('hidden').hide();

            $(poElement) // Clear Active Vatrate Field.
                .parents('.otrVRate')
                .find('input.xWVat')
                .attr('disabled', true)
                .removeClass('active');

            $(poElement) // Clear Active Vatrate Start Field.
                .parents('.otrVRate')
                .find('input.xWVatStart')
                .attr('disabled', true)
                .removeClass('btn');
        }else{
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSxSaveOperator Error: ', err);
    }
}

/**
 * Functionality : Remove or Add Percent Symbol.(Helper Function)
 * Parameters : poElement is Itself element, poEvent is Itself event, 
 * ptOption(remove-percent or add-percent) 
 * Creator : 23/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSetFormatVatrateField(poElement, poEvent, ptOption) {
    try {
        if (ptOption == 'remove-percent') {
            // Vatrate Field Convert Format
            var tVatrate = $(poElement).parents('.otrVRate').find('.xWVat').val().replace(' %', '');
            // Set Vatrate Field After Convert Format
            $(poElement).parents('.otrVRate').find('.xWVat').val(tVatrate);
        }
        if (ptOption == 'add-percent') {
            // Vatrate Field Convert Format
            var tVatrate = $(poElement).parents('.otrVRate').find('.xWVat').val();
            // Set Vatrate Field After Convert Format
            $(poElement).parents('.otrVRate').find('.xWVat').val(tVatrate + ' %');
        }
    } catch (err) {
        console.log('JSxSetFormatVatrateField Error: ', err);
    }
}

/*============================= End Record Operator ==========================*/

/**
 * Functionality : Show or hide delete all button
 * Show on multiple selections, Hide on one or none selection 
 * Use in table list main page
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 27/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxVatrateVisibledDelAllBtn(poElement, poEvent) { // Action start after change check box value.
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if (nCheckedCount > 1) {
            $('#oliBtnDeleteAll').removeClass("disabled");
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('#oliBtnDeleteAll').addClass("disabled");
            $('.xCNIconDel').removeClass('xCNDisabled');
        }
    } catch (err) {
        console.log('JSxVatrateVisibledDelAllBtn Error: ', err);
    }
}

/**
 * Functionality : Set data on select multiple, use in table list main page
 * Parameters : -
 * Creator : 27/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxVatrateSetDataBeforeDelMulti() { // Action start after delete all button click.
    try {
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each(function(pnIndex) {
            tValue += $(this).parents('tr.otrVatrate').find('td.otdVatCode').text() + ', ';
        });
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ospConfirmIDDelete').val(tValue.replace(/, $/, ""));

    } catch (err) {
        console.log('JSxVatrateSetDataBeforeDelMulti Error: ', err);
    }
}

/**
 * Functionality : Confirm delete multiple
 * Parameters : -
 * Creator : 27/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaVatrateDelChoose(pnPage) {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxOpenLoading();
            var nCheckedCount = $('#odvRGPList td input:checked').length;
            if (nCheckedCount > 1) { // For mutiple delete
                $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
                var oChecked = $('#odvRGPList td input:checked');
                var aVatCode = [];
                $(oChecked).each(function(pnIndex) {
                    aVatCode[pnIndex] = $(this).parents('tr.otrVatrate').find('td.otdVatCode').text();
                });

                $.ajax({
                    type: "POST",
                    url: "vatrateDeleteMulti",
                    data: { tVatCode: JSON.stringify(aVatCode) },
                    success: function(tResult) {
                        $('#odvModalDelVatrate').modal('hide');

                        setTimeout(function() {
                            JSvVatrateDataTable(pnPage);
                            JSxVatNavDefult();
                        }, 1000);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            } else { // For single delete

                //var tVatCode = $('#ospConfirmDelete').text();
                var tVatCode = $('#ospConfirmIDDelete').val();

                $.ajax({
                    type: "POST",
                    url: "vatrateDelete",
                    data: { tVatCode: tVatCode },
                    success: function(tResult) {
                        $('#odvModalDelVatrate').modal('hide');

                        setTimeout(function() {
                            JSvVatrateDataTable(pnPage);
                            JSxVatNavDefult();
                        }, 1000);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSaVatrateDelChoose Error: ', err);
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
function JSaVatrateDelete(pnPage, ptVatCode, ptConfirmYN) {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            var nCheckedCount = $('#odvRGPList td input:checked').length;
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptVatCode + ' ( ' + ptVatCode + ' ) ' + ptConfirmYN);
            $('#ospConfirmIDDelete').val(ptVatCode);
            if (nCheckedCount <= 1) {
                $('#odvModalDelVatrate').modal('show');
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSaVatrateDelete Error: ', err);
    }
}

/**
 * Functionality : Generate Code VatRate
 * Parameters : {params}
 * Creator : Creator : 18/05/2018 wasin
 * Last Modified : 22/08/2018 piya
 * Return : Data
 * Return Type : String
 */
function JStGenerateVatrateCode() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            var tTableName = 'TCNMVatRate';
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
                        $('#oetVatCode').val(tData.rtVatCode);
                        $('#oetAddVatCode').val(tData.rtVatCode);

                        $('#oetVatCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                        //----------Hidden ปุ่ม Gen
                        $('.xCNiConGen').attr('disabled', true);
                    } else {
                        $('#oetVatCode').val(tData.rtDesc);
                    }
                    JCNxCloseLoading();
                    $('#oetAddVatRate').focus();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JStGenerateVatrateCode Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function 
 * Creator : 13/06/2018 wasin
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
 * Functionality : Empty check record before to save
 * Parameters : -
 * Creator : 28/08/2018 piya
 * Last Modified : -
 * Return : Empty status
 * Return Type : boolean
 */
function JCNbEmptyRecord() {
    try {
        var bStatus = false;
        if ($('#otbRateList > tr').not('.hidden').not('#otrNoVatData').length == 0) {
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNVatrateIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Visibled operation icon
 * Parameters : [poElement] is seft element in scope(<tr class="otrVRate">), 
 * [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
 * Creator : 29/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JCNxVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
    try {
        switch (ptOperation) {
            case 'edit':
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.otrVRate')
                                .find('.xWVatEdit'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.otrVRate')
                                .find('.xWVatEdit'))
                            .addClass('hidden');
                        $('.xWVatSave').show();
                        $('.xWVatCancel').show();
                    }
                    break;
                }
            case 'cancel':
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.otrVRate')
                                .find('.xWVatCancel'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.otrVRate')
                                .find('.xWVatCancel'))
                            .addClass('hidden');
                    }
                    break;
                }
            case 'save':
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.otrVRate')
                                .find('.xWVatSave'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.otrVRate')
                                .find('.xWVatSave'))
                            .addClass('hidden');
                    }
                    break;
                }
            default:
                {}
        }
    } catch (err) {
        console.log('JCNxVisibledOperationIcon Error: ', err);
    }
}

/**
 * Functionality : Check records has invalid
 * Parameters : -
 * Creator : 29/08/2018 piya
 * Last Modified : -
 * Return : Valid status is valid return false, is invalid return true
 * Return Type : boolean
 */
function JCNbHasInvalidRecord() {
    try {
        var isInvalid = true;
        if ($('.record-invalid').length == 0) {
            isInvalid = false;
            console.log('Record is valid');
        } else {
            console.log('Record is invalid');
        }
        return isInvalid;
    } catch (err) {
        console.log('JCNbHasInvalidRecord Error: ', err);
    }
}

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvVatrateClickPage(ptPage) {
    try {
        var nPageCurrent = '';
        var nPageOld;
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageVatrate .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageVatrate .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvVatrateDataTable(nPageCurrent);
    } catch (err) {
        console.log('JSvVatrateClickPage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 24/08/2018 piya
 * Last Modified : 27/08/2018 piya
 * Return : Status true is update page
 * Return Type : Boolean
 */
function JCNVatrateIsUpdatePage() {
    try {
        var tVCode = $('#oetVatCode').data('is-created');
        var bStatus = false;
        if (tVCode != "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNVatrateIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 24/08/2018 piya
 * Last Modified : 27/08/2018 piya
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNVatrateIsCreatePage() {
    try {
        var tVCode = $('#oetVatCode').data('is-created');
        var bStatus = false;
        if (tVCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNVatrateIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Show or Hide Component
 * Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
 * Creator : 09/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxCardVisibleComponent Error: ', err);
    }
}