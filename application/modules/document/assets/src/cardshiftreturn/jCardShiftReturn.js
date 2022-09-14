var nStaCardShiftReturnBrowseType = $('#oetCardShiftReturnStaBrowse').val();
var tCallCardShiftReturnBackOption = $('#oetCardShiftReturnCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function () {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCardShiftReturnCardShiftReturnNavDefult();
    if (nStaCardShiftReturnBrowseType != 1) {
        JSvCardShiftReturnCallPageCardShiftReturn();
    } else {
        JSvCardShiftReturnCallPageCardShiftReturnAdd();
    }
});

/*============================= End Auto Run =================================*/

/**
 * Functionality : Function Clear Defult Button CardShiftReturn
 * Parameters : -
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
*/
function JSxCardShiftReturnCardShiftReturnNavDefult() {
    try {
        if (nStaCardShiftReturnBrowseType != 1 || nStaCardShiftReturnBrowseType == undefined) {
            $('.xCNCardShiftReturnVBrowse').hide();
            $('.xCNCardShiftReturnVMaster').show();
            $('#oliCardShiftReturnTitleAdd').hide();
            $('#oliCardShiftReturnTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnCardShiftReturnInfo').show();
        } else {
            $('#odvModalBody .xCNCardShiftReturnVMaster').hide();
            $('#odvModalBody .xCNCardShiftReturnVBrowse').show();
            $('#odvModalBody #odvCardShiftReturnMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCardShiftReturnNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCardShiftReturnBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNCardShiftReturnBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNCardShiftReturnBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    } catch (err) {
        console.log('JSxCardShiftReturnCardShiftReturnNavDefult Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
 */
function JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown) {
    try {
        JCNxResponseError(jqXHR, textStatus, errorThrown)
    } catch (err) {
        console.log('JCNxCardShiftReturnResponseError Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftReturn Page list
 * Parameters : {params}
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftReturnCallPageCardShiftReturn() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            localStorage.tStaPageNow = 'JSvCallPageCardShiftReturnList';
            $('#oetSearchAll').val('');
            $.ajax({
                type: "POST",
                url: "cardShiftReturnList",
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    $('#odvContentPageCardShiftReturn').html(tResult);
                    JSvCardShiftReturnCardShiftReturnDataTable();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSvCardShiftReturnCallPageCardShiftReturn Error: ', err);
    }
}

/**
 * Functionality : Call Recive Data List
 * Parameters : Ajax Success Event
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftReturnCardShiftReturnDataTable(pnPage) {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            var tSearchAll = $('#oetSearchAll').val();
            var oAdvanceSearch = JSoCardShiftReturnGetSearchData();
            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == '') {
                nPageCurrent = '1';
            }
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "cardShiftReturnDataTable",
                data: {
                    tSearchAll: tSearchAll,
                    tAdvanceSearch: JSON.stringify(oAdvanceSearch),
                    nPageCurrent: nPageCurrent
                },
                cache: false,
                Timeout: 0,
                success: function (tResult) {
                    if (tResult != "") {
                        $('#ostDataCardShiftReturn').html(tResult);
                    }
                    JSxCardShiftReturnCardShiftReturnNavDefult();
                    JCNxLayoutControll();
                    JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); // โหลดภาษาใหม่
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSvCardShiftReturnCardShiftReturnDataTable Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftReturn Page Add
 * Parameters : {params}
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftReturnCallPageCardShiftReturnAdd() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JSnCallDeleteHelperByTable("TFNTCrdShiftTmp");
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('', '');
            $.ajax({
                type: "POST",
                url: "cardShiftReturnPageAdd",
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    if (nStaCardShiftReturnBrowseType == 1) {
                        $('.xCNCardShiftReturnVMaster').hide();
                        $('.xCNCardShiftReturnVBrowse').show();
                    } else {
                        $('.xCNCardShiftReturnVBrowse').hide();
                        $('.xCNCardShiftReturnVMaster').show();
                        $('#oliCardShiftReturnTitleEdit').hide();
                        $('#oliCardShiftReturnTitleAdd').show();
                        $('#odvBtnCardShiftReturnInfo').hide();
                        $('#odvBtnAddEdit').show();
                    }
                    $('#odvContentPageCardShiftReturn').html(tResult);
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSvCardShiftReturnCallPageCardShiftReturnAdd Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftReturn Page Edit
 * Parameters : {params}
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftReturnCallPageCardShiftReturnEdit(ptCardShiftReturnCode) {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('JSvCardShiftReturnCallPageCardShiftReturnEdit', ptCardShiftReturnCode);
            $.ajax({
                type: "POST",
                url: "cardShiftReturnPageEdit",
                data: { tCardShiftReturnDocNo: ptCardShiftReturnCode },
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    if (tResult != '') {
                        $('#oliCardShiftReturnTitleAdd').hide();
                        $('#oliCardShiftReturnTitleEdit').show();
                        $('#odvBtnCardShiftReturnInfo').hide();
                        $('#odvBtnAddEdit').show();
                        $('#odvContentPageCardShiftReturn').html(tResult);
                        $('#oetCardShiftReturnCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                    }
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSvCardShiftReturnCallPageCardShiftReturnEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code CardShiftReturn
 * Parameters : {params}
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStCardShiftReturnGenerateCardShiftReturnCode() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            var tTableName = 'TFNTCrdShiftHD';
            var tStaDocType = '2'; // Return Card
            $.ajax({
                type: "POST",
                url: "generateCodeV5",
                data: { tTableName: tTableName, tStaDoc: tStaDocType },
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    var tData = $.parseJSON(tResult);
                    if (tData.rtCode == '1') {
                        $('#oetCardShiftReturnCode').val(tData.rtCshDocNo);
                        $('#oetCardShiftReturnCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                        //----------Hidden ปุ่ม Gen
                        $('.xCNBtnGenCode').attr('disabled', true);

                        //update docno in center
                        var tNameTableTemp = 'TFNTCrdShiftTmp';
                        JSXUpdateDocNoCenter(tData.rtCshDocNo, tNameTableTemp);
                    } else {
                        $('#oetCardShiftReturnCode').val(tData.rtDesc);
                    }
                    $('#oetCardShiftReturnName').focus();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JStCardShiftReturnGenerateCardShiftReturnCode Error: ', err);
    }
}

/**
 * Functionality : Check CardShiftReturn Code In DB
 * Parameters : {params}
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCardShiftReturnCheckCardShiftReturnCode() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            var tCode = $('#oetCardShiftReturnCode').val();
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
                            JSvCardShiftReturnCallPageCardShiftReturnEdit(tCode);
                        } else {
                            alert('ไม่พบระบบจะ Gen ใหม่');
                            JStCardShiftReturnGenerateCardShiftReturnCode();

                            //update docno in center
                            // var tNameTableTemp = 'TFNTCrdShiftTmp';
                            // JSXUpdateDocNoCenter(tData.rtCshDocNo,tNameTableTemp);
                        }
                        $('.wrap-input100').removeClass('alert-validate');
                        $('.btn-default').attr('disabled', false);

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JStCardShiftReturnCheckCardShiftReturnCode Error: ', err);
    }
}

/**
 * Functionality : Set data on select multiple, use in table list main page
 * Parameters : -
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftReturnSetDataBeforeDelMulti() { // Action start after delete all button click.
    try {
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each(function (pnIndex) {
            tValue += $(this).parents('tr.otrCardShiftReturn').find('td.otdCardShiftReturnCode').text() + ', ';
        });
        $('#ospConfirmDelete').text(tValue.replace(/, $/, ""));
    } catch (err) {
        console.log('JSxCardShiftReturnSetDataBeforeDelMulti Error: ', err);
    }
}

/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaCardShiftReturnCardShiftReturnDelete(poElement, poEvent) {
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;

        var tValue = $(poElement).parents('tr.otrCardShiftReturn').find('td.otdCardShiftReturnCode').text();
        $('#ospConfirmDelete').text(tValue);

        if (nCheckedCount <= 1) {
            $('#odvModalDelCardShiftReturn').modal('show');
        }
    } catch (err) {
        console.log('JSaCardShiftReturnCardShiftReturnDelete Error: ', err);
    }
}

/**
 * Functionality : Confirm delete
 * Parameters : -
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnCardShiftReturnCardShiftReturnDelChoose() {
    try {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxOpenLoading();
            var nCheckedCount = $('#odvRGPList td input:checked').length;
            if (nCheckedCount > 1) { // For mutiple delete

                var oChecked = $('#odvRGPList td input:checked');
                var aCardShiftReturnCode = [];
                $(oChecked).each(function (pnIndex) {
                    aCardShiftReturnCode[pnIndex] = $(this).parents('tr.otrCardShiftReturn').find('td.otdCardShiftReturnCode').text();
                });

                $.ajax({
                    type: "POST",
                    url: "cardShiftReturnDeleteMulti",
                    data: { tCardShiftReturnCode: JSON.stringify(aCardShiftReturnCode) },
                    success: function (tResult) {
                        $('#odvModalDelCardShiftReturn').modal('hide');
                        JSvCardShiftReturnCardShiftReturnDataTable();
                        JSxCardShiftReturnCardShiftReturnNavDefult();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            } else { // For single delete

                var tCardShiftReturnCode = $('#ospConfirmDelete').text();

                $.ajax({
                    type: "POST",
                    url: "cardShiftReturnDelete",
                    data: { tCardShiftReturnCode: tCardShiftReturnCode },
                    success: function (tResult) {
                        $('#odvModalDelCardShiftReturn').modal('hide');
                        JSvCardShiftReturnCardShiftReturnDataTable();
                        JSxCardShiftReturnCardShiftReturnNavDefult();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    } catch (err) {
        console.log('JSnCardShiftReturnCardShiftReturnDelChoose Error: ', err);
    }
}

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftReturnClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCardShiftReturn .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCardShiftReturn .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCardShiftReturnCardShiftReturnDataTable(nPageCurrent);
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCardShiftReturnIsCreatePage() {
    try {
        const tCardShiftReturnCode = $('#oetCardShiftReturnCode').data('is-created');
        var bStatus = false;
        if (tCardShiftReturnCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNbCardShiftReturnIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCardShiftReturnIsUpdatePage() {
    try {
        const tCardShiftReturnCode = $('#oetCardShiftReturnCode').data('is-created');
        var bStatus = false;
        if (!tCardShiftReturnCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNbCardShiftReturnIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Show or hide delete all button
 * Show on multiple selections, Hide on one or none selection 
 * Use in table list main page
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 25/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftReturnVisibleDelAllBtn(poElement, poEvent) { // Action start after change check box value.
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if (nCheckedCount > 1) {
            $('#oliBtnDeleteAll').removeClass("disabled");
        } else {
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    } catch (err) {
        console.log('JSxCardShiftReturnVisibleDelAllBtn Error: ', err);
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
function JSxCardShiftReturnVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxCardShiftReturnVisibleComponent Error: ', err);
    }
}


// Function: Event Single Delete Document Card ShifNew Card Single
// Parameters: Function Call Page
// Creator: 25/12/2019 WitsarutBell
// Return: object Data Sta Delete
// ReturnType: object
function JSoCrdShifReturnDelDocSingle(ptCurrentPage, ptCrdShifReturnDocNo, ptBchCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== "undefined" && nStaSession == 1) {
        if (typeof (ptCrdShifReturnDocNo) != undefined && ptCrdShifReturnDocNo != "") {
            var tTextConfrimDelSingle = $('#oetTextComfirmDeleteSingle').val() + "&nbsp" + ptCrdShifReturnDocNo + "&nbsp" + $('#oetTextComfirmDeleteYesOrNot').val();
            $('#odvCardShifReturnModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
            $('#odvCardShifReturnModalDelDocSingle').modal('show');
            $('#odvCardShifReturnModalDelDocSingle #osmConfirmDelSingle').unbind().click(function () {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "cardShifReturnEventDelete",
                    data: {
                        tCrdShifReturnDocNo: ptCrdShifReturnDocNo,
                        tBchCode: ptBchCode
                    },
                    cache: false,
                    timeout: 0,
                    success: function (oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == 1) {
                            $('#odvCardShifReturnModalDelDocSingle').modal('hide');
                            $('#odvCardShifReturnModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function () {
                                JSvCardShiftReturnCardShiftReturnDataTable(ptCurrentPage);
                            }, 500);
                        } else {
                            JCNxCloseLoading();
                            FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        } else {
            FSvCMNSetMsgErrorDialog('Error Not Found Document Number !!');
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 25/12/2019 Witsarut(Bell)
//Return: Insert Code In Text Input
//Return Type: -
function JSxCardReturnTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") { } else {
        var tTextCode = "";
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += " , ";
        }

        //Disabled ปุ่ม Delete
        if (aArrayConvert[0].length > 1) {
            $(".xCNIconDel").addClass("xCNDisabled");
        } else {
            $(".xCNIconDel").removeClass("xCNDisabled");
        }

        $("#ospConfirmDelete").text("ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?");
        $("#ohdConfirmIDDelete").val(tTextCode);
    }
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 25/12/2019 Wasin(Yoshi)
//Return: Show Button Delete All
//Return Type: -
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliCardReturnBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliCardReturnBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliCardReturnBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 25/12/2019 Witsarut(Bell)
//Return: Duplicate/none
//Return Type: string
function JStCardReturnFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

/**
 * Functionality : Multi Delete Multi Card Retiurn
 * Parameters : -
 * Creator : 23/11/2020 Witsarut (Bell)
 * Return : -
 * Return Type : -
 */
function JSoCardShifReturnCardDelDocMultiple() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof (nStaSession) !== "undefined" && nStaSession == 1) {
        $("#odvModalDelCardShiftReturn").modal("hide");
        JCNxOpenLoading();

        var aData = $("#ohdConfirmIDDelete").val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;

        var aDocNo = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aDocNo.push(aDataSplit[$i]);
        }

        if (aDataSplitlength > 1) {
            localStorage.StaDeleteArray = "1";
            $.ajax({
                type: "POST",
                url: "cardShifReturnEventDeleteMulti",
                data: {
                    aDocNo: aDocNo
                },
                success: function (oResult) {
                    JSvCardShiftReturnCardShiftReturnDataTable();
                    JSxCardShiftReturnCardShiftReturnNavDefult();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = "0";
            return false;
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}