var nStaCardShiftOutBrowseType = $('#oetCardShiftOutStaBrowse').val();
var tCallCardShiftOutBackOption = $('#oetCardShiftOutCallBackOption').val();

/*===== Begin Auto Run =================================================================*/
$('document').ready(function () {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCardShiftOutCardShiftOutNavDefult();
    if (nStaCardShiftOutBrowseType != 1) {
        JSvCardShiftOutCallPageCardShiftOut();
    } else {
        JSvCardShiftOutCallPageCardShiftOutAdd();
    }
});
/*===== End Auto Run ===================================================================*/

/**
 * Functionality : Function Clear Defult Button CardShiftOut
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftOutCardShiftOutNavDefult() {
    try {
        if (nStaCardShiftOutBrowseType != 1 || nStaCardShiftOutBrowseType == undefined) {
            $('.xCNCardShiftOutVBrowse').hide();
            $('.xCNCardShiftOutVMaster').show();
            $('#oliCardShiftOutTitleAdd').hide();
            $('#oliCardShiftOutTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnCardShiftOutInfo').show();
        } else {
            $('#odvModalBody .xCNCardShiftOutVMaster').hide();
            $('#odvModalBody .xCNCardShiftOutVBrowse').show();
            $('#odvModalBody #odvCardShiftOutMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCardShiftOutNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCardShiftOutBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNCardShiftOutBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNCardShiftOutBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    } catch (err) {
        console.log('JSxCardShiftOutCardShiftOutNavDefult Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
 */
function JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown) {
    try {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
    } catch (err) {
        console.log('JCNxCardShiftOutResponseError Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftOut Page list
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftOutCallPageCardShiftOut() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            localStorage.tStaPageNow = 'JSvCallPageCardShiftOutList';
            $('#oetSearchAll').val('');
            $.ajax({
                type: "POST",
                url: "cardShiftOutList",
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    $('#odvContentPageCardShiftOut').html(tResult);
                    JSvCardShiftOutCardShiftOutDataTable();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSvCardShiftOutCallPageCardShiftOut Error: ', err);
    }
}

/**
 * Functionality : Call Recive Data List
 * Parameters : Ajax Success Event
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftOutCardShiftOutDataTable(pnPage) {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            var tSearchAll = $('#oetSearchAll').val();
            var oAdvanceSearch = JSoCardShiftOutGetSearchData();
            console.log('Search data: ', oAdvanceSearch);
            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == '') {
                nPageCurrent = '1';
            }
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "cardShiftOutDataTable",
                data: {
                    tSearchAll: tSearchAll,
                    tAdvanceSearch: JSON.stringify(oAdvanceSearch),
                    nPageCurrent: nPageCurrent
                },
                cache: false,
                Timeout: 5000,
                success: function (tResult) {
                    if (tResult != "") {
                        $('#ostDataCardShiftOut').html(tResult);
                    }
                    JSxCardShiftOutCardShiftOutNavDefult();
                    JCNxLayoutControll();
                    JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); // โหลดภาษาใหม่
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSvCardShiftOutCardShiftOutDataTable Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftOut Page Add
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftOutCallPageCardShiftOutAdd() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JSnCallDeleteHelperByTable("TFNTCrdShiftTmp");
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('', '');
            $.ajax({
                type: "POST",
                url: "cardShiftOutPageAdd",
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    if (nStaCardShiftOutBrowseType == 1) {
                        $('.xCNCardShiftOutVMaster').hide();
                        $('.xCNCardShiftOutVBrowse').show();
                    } else {
                        $('.xCNCardShiftOutVBrowse').hide();
                        $('.xCNCardShiftOutVMaster').show();
                        $('#oliCardShiftOutTitleEdit').hide();
                        $('#oliCardShiftOutTitleAdd').show();
                        $('#odvBtnCardShiftOutInfo').hide();
                        $('#odvBtnAddEdit').show();
                    }
                    $('#odvContentPageCardShiftOut').html(tResult);
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSvCardShiftOutCallPageCardShiftOutAdd Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftOut Page Edit
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftOutCallPageCardShiftOutEdit(ptCardShiftOutCode) {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('JSvCallPageCardShiftOutEdit', ptCardShiftOutCode);
            $.ajax({
                type: "POST",
                url: "cardShiftOutPageEdit",
                data: { tCardShiftOutDocNo: ptCardShiftOutCode },
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    if (tResult != '') {
                        $('#oliCardShiftOutTitleAdd').hide();
                        $('#oliCardShiftOutTitleEdit').show();
                        $('#odvBtnCardShiftOutInfo').hide();
                        $('#odvBtnAddEdit').show();
                        $('#odvContentPageCardShiftOut').html(tResult);
                        $('#oetCardShiftOutCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                    }
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSvCardShiftOutCallPageCardShiftOutEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code CardShiftOut
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStCardShiftOutGenerateCardShiftOutCode() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            var tTableName = 'TFNTCrdShiftHD';
            var tStaDocType = '1'; // Request Card
            $.ajax({
                type: "POST",
                url: "generateCodeV5",
                data: { tTableName: tTableName, tStaDoc: tStaDocType },
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    var tData = $.parseJSON(tResult);
                    if (tData.rtCode == '1') {
                        $('#oetCardShiftOutCode').val(tData.rtCshDocNo);
                        JSXUpdateDocNoCenter(tData.rtCshDocNo, 'TFNTCrdShiftTmp');
                        $('#oetCardShiftOutCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                        // Hidden ปุ่ม Gen
                        $('.xCNBtnGenCode').attr('disabled', true);
                    } else {
                        $('#oetCardShiftOutCode').val(tData.rtDesc);
                    }
                    $('#oetCardShiftOutName').focus();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JStCardShiftOutGenerateCardShiftOutCode Error: ', err);
    }
}

/**
 * Functionality : Check CardShiftOut Code In DB
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCardShiftOutCheckCardShiftOutCode() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            var tCode = $('#oetCardShiftOutCode').val();
            var tTableName = 'TFNTCrdShiftHD';
            var tFieldName = 'FTXshDocNo';
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
                        if (tData.rtCode == '1') { //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
                            alert('มี id นี้แล้วในระบบ');
                            JSvCardShiftOutCallPageCardShiftOutEdit(tCode);

                            // update docno in center
                            // var tNameTableTemp = 'TFNTCrdShiftTmp';
                            // JSXUpdateDocNoCenter(tData.rtCshDocNo,tNameTableTemp);
                        } else {
                            alert('ไม่พบระบบจะ Gen ใหม่');
                            JStCardShiftOutGenerateCardShiftOutCode();
                        }
                        $('.wrap-input100').removeClass('alert-validate');
                        $('.btn-default').attr('disabled', false);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JStCardShiftOutCheckCardShiftOutCode Error: ', err);
    }
}

/**
 * Functionality : Set data on select multiple, use in table list main page
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftOutSetDataBeforeDelMulti() { // Action start after delete all button click.
    try {
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each(function (pnIndex) {
            tValue += $(this).parents('tr.otrCardShiftOut').find('td.otdCardShiftOutCode').text() + ', ';
        });
        $('#ospConfirmDelete').text(tValue.replace(/, $/, ""));
    } catch (err) {
        console.log('JSxCardShiftOutSetDataBeforeDelMulti Error: ', err);
    }
}

/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaCardShiftOutCardShiftOutDelete(poElement, poEvent) {
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;

        var tValue = $(poElement).parents('tr.otrCardShiftOut').find('td.otdCardShiftOutCode').text();
        $('#ospConfirmDelete').text(tValue);

        if (nCheckedCount <= 1) {
            $('#odvModalDelCardShiftOut').modal('show');
        }
    } catch (err) {
        console.log('JSaCardShiftOutCardShiftOutDelete Error: ', err);
    }
}

/**
 * Functionality : Confirm delete
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnCardShiftOutCardShiftOutDelChoose() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxOpenLoading();
            var nCheckedCount = $('#odvRGPList td input:checked').length;
            if (nCheckedCount > 1) { // For mutiple delete

                var oChecked = $('#odvRGPList td input:checked');
                var aCardShiftOutCode = [];
                $(oChecked).each(function (pnIndex) {
                    aCardShiftOutCode[pnIndex] = $(this).parents('tr.otrCardShiftOut').find('td.otdCardShiftOutCode').text();
                });

                $.ajax({
                    type: "POST",
                    url: "cardShiftOutDeleteMulti",
                    data: { tCardShiftOutCode: JSON.stringify(aCardShiftOutCode) },
                    success: function (tResult) {
                        $('#odvModalDelCardShiftOut').modal('hide');
                        JSvCardShiftOutCardShiftOutDataTable();
                        JSxCardShiftOutCardShiftOutNavDefult();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            } else { // For single delete

                var tCardShiftOutCode = $('#ospConfirmDelete').text();

                $.ajax({
                    type: "POST",
                    url: "cardShiftOutDelete",
                    data: { tCardShiftOutCode: tCardShiftOutCode },
                    success: function (tResult) {
                        $('#odvModalDelCardShiftOut').modal('hide');
                        JSvCardShiftOutCardShiftOutDataTable();
                        JSxCardShiftOutCardShiftOutNavDefult();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSnCardShiftOutCardShiftOutDelChoose Error: ', err);
    }
}

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftOutClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCardShiftOut .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCardShiftOut .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCardShiftOutCardShiftOutDataTable(nPageCurrent);
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCardShiftOutIsCreatePage() {
    try {
        var tCardShiftOutCode = $('#oetCardShiftOutCode').val();
        var bStatus = false;
        if (tCardShiftOutCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNbCardShiftOutIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCardShiftOutIsUpdatePage() {
    try {
        var tCardShiftOutCode = $('#oetCardShiftOutCode').val();
        var bStatus = false;
        if (tCardShiftOutCode != "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNbCardShiftOutIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Show or hide delete all button
 * Show on multiple selections, Hide on one or none selection 
 * Use in table list main page
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftOutVisibleDelAllBtn(poElement, poEvent) { // Action start after change check box value.
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if (nCheckedCount > 1) {
            $('#oliBtnDeleteAll').removeClass("disabled");
        } else {
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    } catch (err) {
        console.log('JSxCardShiftOutVisibleDelAllBtn Error: ', err);
    }
}

