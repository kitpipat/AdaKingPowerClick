var nStaCmdBrowseType = $('#oetCmdStaBrowse').val();
var tCallCmdBackOption = $('#oetCmdCallBackOption').val();
// alert(nStaCmdBrowseType+'//'+tCallCmdBackOption);

$('document').ready(function () {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCmdNavDefult();
    if (nStaCmdBrowseType != 1) {
        JSvCallPageCardMngFrmList();
    } else {
        JSvCallPageCardMngFrmList();
    }
});

//function : Function Defult Button
//Parameters : Document Ready
//Creator : 19/10/2018 wasin
//Return : Show Tab Menu
//Return Type : -
function JSxCmdNavDefult() {
    if (nStaCmdBrowseType != 1 || nStaCmdBrowseType == undefined) {
        $('.xCNCmdVBrowse').hide();
        $('.xCNCmdVMaster').show();
    } else {
        $('.xCNCmdVMaster').hide();
        $('.xCNCmdVBrowse').show();
    }
}

/** ============================================ Call View Import-Export ============================================ */

//function : Call Page Management Data Form  
//Parameters : Document Redy And Event Button
//Creator :	16/10/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageCardMngFrmList() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "cardmngdataFromList",
            cache: false,
            timeout: 0,
            success: function (tResult) {
                if (nStaCmdBrowseType == 1) {
                    $('.xCNCmdVMaster').hide();
                    $('.xCNCmdVBrowse').show();
                } else {
                    $('.xCNCmdVBrowse').hide();
                    $('.xCNCmdVMaster').show();
                }
                $('#odvContentPageCardMngData').html(tResult);
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

/** ============================================ Import Module ============================================ */

//Function: Call Data In DataBase (Import)
//Parameters : Event Button Click
//Creator : 25/10/2018 wasin
//Return : Data List Group For Condition
//Return Type : view
function JSvImpSelectDataInTable(pnPage, poData) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        var tSearchAll = $('#oetCMDSearchImport').val();
        var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
        if (poData != undefined && poData['nStaChkFile'] == 1) {
            var aDataFile = poData['oDataFile'];
        } else {
            var aDataFile = null;
        }
        var tCmdConsImport = $('.xWCmdConsImport:checked').val();
        var tCmdDataEntry = $('#ocmCmdDataEntry').val();
        var tReasonFile = $('#oetCardReasonCode').val();

        /** Set Form Send Data */
        var oFromData = new FormData();
        oFromData.append('nStaImportProcess', nStaImportProcess);
        oFromData.append('nPageCurrent', nPageCurrent);
        oFromData.append('tSearchAll', tSearchAll);
        oFromData.append('tCmdDataEntry', tCmdDataEntry);
        oFromData.append('tCmdConsImport', tCmdConsImport);
        oFromData.append('aFile', aDataFile);
        oFromData.append('tReasonFile', tReasonFile);
        oFromData.append('tBchCode', $("#oetBCHCode_cardShiftMng").val());

        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "cardmngdataImpFileDataList",
            data: oFromData,
            contentType: false,
            processData: false,
            cache: false,
            timeout: 0,
            success: function (oDataReturn) {
                var aDataReturn = jQuery.parseJSON(oDataReturn);
                var tStaError = aDataReturn.tStaLog;

                if (tStaError == 'E101') {
                    FSvCMNSetMsgWarningDialog($('#ohdCardMngExcelErrorFileNotMatch').val());
                } else if (tStaError == 'E102') {
                    FSvCMNSetMsgWarningDialog($('#ohdCardMngExcelErrorColunmHead').val());
                } else if (tStaError == 'Success') {
                    var tDocType = aDataReturn.tDocType;
                    var tPage = 1;
                    var tIDElement = 'odvPanelCmdMngDataDetail';
                    JSvClickCallTableTemp(tDocType, tPage, tIDElement);
                } else if (tStaError == 'FirstPage') {
                    var tDocType = 'NewCard';
                    var tPage = 1;
                    var tIDElement = 'odvPanelCmdMngDataDetail';
                    JSvClickCallTableTemp(tDocType, tPage, tIDElement);
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                (jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// function : Check Data Import Condition
// Parameters : Document Redy And Event Button
// Creator : 25/10/2018 wasin
// Return : View
// Return Type : View
function JSoChkConditionImport(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        var oDataFileImport = $('#oflCmdImportFile').prop('files');
        var tReasonFile = $('#oetCardReasonCode').val();
        var tCmdDataEntry = $('#ocmCmdDataEntry').val();
        var nDataCountFile = oDataFileImport.length;
        if (nDataCountFile > 0 && !jQuery.isEmptyObject(oDataFileImport[0])) {
            $('#odvCMDMessageImport .xWMsgConditonErr').fadeOut('slow').remove();
            var oDataReturn = {
                'nStaChkFile': 1,
                'oDataFile': oDataFileImport[0]
            };

            if (tCmdDataEntry == 3 && (tReasonFile == null || tReasonFile == '')) {
                $('#odvCMDMessageReason').empty().append($('<label>').attr('class', 'xWMsgConditonErr').text(oLangMngData['tCMDErrorReason']).hide().fadeIn('slow'));
            } else {
                $('#odvCardMngModalImportFileConfirm').modal({ backdrop: 'static', keyboard: false });
                $('#odvCardMngModalImportFileConfirm').modal('show');
                $('#osmCardMngBtnImportFileConfirm').one('click', function (evt) {
                    $('#odvCardMngModalImportFileConfirm').modal('hide');
                    console.log('Confrim');
                    JSvImpSelectDataInTable(pnPage, oDataReturn);
                });
            }
        } else {
            if (tReasonFile == '' || tReasonFile == null && tCmdDataEntry == 3) {
                $('#odvCMDMessageReason').empty().append($('<label>').attr('class', 'xWMsgConditonErr').text(oLangMngData['tCMDErrorReason']).hide().fadeIn('slow'));
            }
            $('#odvCMDMessageImport').empty().append($('<label>').attr('class', 'xWMsgConditonErr').text(oLangMngData['tCMDValImpNoBrowsFile']).hide().fadeIn('slow'));
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Function: Click Page Import Data List
//Parameters : Event Button Click
//Creator : 13/11/2018 wasin
//Return : Select View
//Return Type : view
function JSvImportClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageImportMngData .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageImportMngData .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSoChkConditionImport(nPageCurrent);
}

/**
 * Functionality : Import Card Process
 * Parameters : pbIsConfirm is boolean for confirm
 * Creator : 13/11/2018 wasin
 * Last Modified : 11/02/2019 piya
 * Return : -
 * Return Type : -
 */
function JSoImportProcessData(pbIsConfirm) {
    var nStaSession = JCNxFuncChkSessionExpired();
    pbIsConfirm = (typeof pbIsConfirm !== 'undefined') ? pbIsConfirm : false;
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        if (pbIsConfirm) {

            var tCountRowFromTempID = $('.xWCardMngCountRowFromTemp').attr('id');
            if ($('#' + tCountRowFromTempID).val() <= 0) { // Empty record check
                $("#odvCardMngProcessPopup").modal('hide');
                FSvCMNSetMsgWarningDialog($('#ohdtCardEmptyRecordAlert').val());
                return;
            }

            $("#odvCardMngProcessPopup").modal('hide');
            var nTypePage = $('#ocmCmdDataEntry').val();
            var tBchCode = $('#oetBCHCode_cardShiftMng').val();

            $.ajax({
                type: "POST",
                url: "cardmngdataProcessImport",
                data: { 
                    nTypePage: nTypePage,
                    tBchCode: tBchCode 
                },
                cache: false,
                timeout: 0,
                success: function (tDataReturn) {
                    console.log('Res: ', tDataReturn);
                    try {
                        oDataReturn = JSON.parse(tDataReturn);
                        if (oDataReturn.nStaProcess == '1') {
                            JSvCallPageCardMngFrmList();
                        }
                    } catch (err) { }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            $("#odvCardMngProcessPopup").modal('show');
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

/** ============================================ Export Module ============================================ */

//Function: Call Data In DataBase (Export)
//Parameters : Event Button Click
//Creator : 24/10/2018 wasin
//Return : Data List Group For Condition
//Return Type : view
function JSvExpSelectDataInTable(pnPage, poCMDDataExport) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        var tSearchAll = $('#oetCMDSearchExport').val();
        var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "cardmngdataExpFileDataList",
            data: {
                nStaExportProcess: nStaExportProcess,
                nPageCurrent: nPageCurrent,
                tSearchAll: tSearchAll,
                tCMDDataType: $('#ocmCMDType').val(),
                tCMDDataList: $('#ocmCmdDataEntry').val(),
                oCMDDataExport: poCMDDataExport
            },
            success: function (tResult) {
                if (tResult != "") {
                    $('#odvPanelCmdMngDataDetail').html(tResult);
                }
                JSxCmdNavDefult();
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// function : Check Data In Condition
// Parameters : Document Redy And Event Button
// Creator :	24/10/2018 wasin
// Return : View
// Return Type : View
function JSoChkConditionExport() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        var oCMDDataExport = {
            'tCmdCardTypeForm': ($('#oetCMDFromCardTypeCode').val() != "") ? $('#oetCMDFromCardTypeCode').val() : null,
            'tCmdCardTypeTo': ($('#oetCMDToCardTypeCode').val() != "") ? $('#oetCMDToCardTypeCode').val() : null,
            'tCmdCardCodeFrom': ($('#oetCMDFromCardCode').val() != "") ? $('#oetCMDFromCardCode').val() : null,
            'tCmdCardCodeTo': ($('#oetCMDToCardCode').val() != "") ? $('#oetCMDToCardCode').val() : null,
            'tCmdCardNameFrom': ($('#oetCMDFromNameCardCode').val() != "") ? $('#oetCMDFromNameCardCode').val() : null,
            'tCmdCardNameTo': ($('#oetCMDToNameCardCode').val() != "") ? $('#oetCMDToNameCardCode').val() : null,
            'tCmdCardHolderIDFrom': ($('#oetCMDFromCardHolderIDCode').val() != "") ? $('#oetCMDFromCardHolderIDCode').val() : null,
            'tCmdCardHolderIDTo': ($('#oetCMDToCardHolderIDCode').val() != "") ? $('#oetCMDToCardHolderIDCode').val() : null,
        }
        var aDataStaReturn = 0;
        var nCountAllArray = Object.keys(oCMDDataExport).length;
        $.each(oCMDDataExport, function (nkey, tValue) {
            if (tValue === null) {
                aDataStaReturn++;
            }
        });
        if (aDataStaReturn == nCountAllArray) {
            $('#odvCMDMessageExport').empty().append($('<label>').attr('class', 'xWMsgConditonErr').text(oLangMngData['tCMDValExpNoCondition']).hide().fadeIn('slow'));
            return aDataReturn = { nStaCheck: 99 };
        } else {
            var nModStaReturn = aDataStaReturn % 2;
            if (nModStaReturn == 1) {
                $('#odvCMDMessageExport').empty().append($('<label>').attr('class', 'xWMsgConditonErr').text(oLangMngData['tCMDValExpNoCondition']).hide().fadeIn('slow'));
                return aDataReturn = { nStaCheck: 99 };
            } else {
                $('#odvCMDMessageExport').empty();
                return aDataReturn = { nStaCheck: 1, aDataCondition: oCMDDataExport };
            }
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Function: Click Page Export Data List
//Parameters : Event Button Click
//Creator : 24/10/2018 wasin
//Return : Select View
//Return Type : view
function JSvExportClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageExportMngData .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageExportMngData .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    var aReturn = JSoChkConditionExport();
    if (aReturn['nStaCheck'] == 1) {
        JSvExpSelectDataInTable(nPageCurrent, aReturn['aDataCondition']);
    }
}

//Function: Export Data Process
//Parameters : Event Button Click
//Creator : 25/10/2018 wasin
//Return : Select View
//Return Type : view
function JSoExportProcessData() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
        var nDataListDetail = $('#odvPanelCmdMngDataDetail #otbMngDataTable .xWDataExportList').length;
        var aDataChkCondition = JSoChkConditionExport();
        if (aDataChkCondition['nStaCheck'] == 1 && nDataListDetail > 0) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "cardmngdataProcessExport",
                data: {
                    aDataCondition: aDataChkCondition['aDataCondition']
                },
                success: function (tResult) {
                    var aDataReturn = JSON.parse(tResult);
                    if (aDataReturn['nStaExport'] == 1) {

                        //Set Global Status Export Process
                        nStaExportProcess = 1;
                        //--------------------------------

                        var $oObjectExport = $("<a>");
                        $oObjectExport.attr("href", aDataReturn['tFile']);
                        $("body").append($oObjectExport);
                        $oObjectExport.attr("download", aDataReturn['tFileName']);
                        $oObjectExport[0].click();
                        $oObjectExport.remove();
                    } else {
                        alert(aDataReturn['tMessage']);
                    }
                    setTimeout(function () {
                        var aStaCheckCons = JSoChkConditionExport();
                        if (aStaCheckCons['nStaCheck'] == 1) {
                            JSvExpSelectDataInTable(1, aStaCheckCons['aDataCondition']);
                        }
                    }, 1000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else if (aDataChkCondition['nStaCheck'] == 1 && nDataListDetail == 0) {
            $('#odvCMDMessageExport').empty().append($('<label>').attr('class', 'xWMsgConditonErr').text(oLangMngData['tCMDValExpNoDataInTable']).hide().fadeIn('slow'));
        } else { }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSxSetQtyCardAllAndAllRow(poData) {
    var tQtyAllRow = poData['tQtyAllRow'];
    var tQtySucessRow = poData['tQtySucessRow'];
    $('#oetQtyCardSuccess').val(tQtySucessRow + ' / ' + tQtyAllRow);
}





