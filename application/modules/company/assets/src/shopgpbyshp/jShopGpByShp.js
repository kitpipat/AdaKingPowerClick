// Function : Call View Main Shop Gp By Shp
// Parameters : - 
// Creator : 25/01/2019 wasin(Yoshi)
//Last Modified : 13/08/2019 Saharat(Golf)
// Return : View
// Return Type : View
function JSvCallPageShopGpByShpMain(ptBchCode, ptShpCode, pnPageShpCallBack, pnPages) {
    pnPages = 1;
    pnPageShpCallBack = 0;
    $.ajax({
        type: "POST",
        url: "CmpShopGpByShpMain",
        data: {
            tBchCode: ptBchCode,
            tShpCode: ptShpCode,
            nPageShpCallBack: pnPageShpCallBack
        },
        success: function(tView) {
            $('#odvSHPContentInfoGPS').html(tView);
            JSvCallPageShopGpByShpDataTable(pnPages);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function : Call View DataTable Shop Gp By Shp
// Parameters : - 
// Creator : 25/01/2019 wasin(Yoshi)
// Return : View
// Return Type : View
function JSvCallPageShopGpByShpDataTable(pnPages, ptOcmBchCode) {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var tOcmBchCode = ptOcmBchCode;
        var tSearchAll = $('#oetSearchShopGpShp').val();
        var tBchCode = $('#ohdShopGpByShpBchCode').val();
        var tShpCpde = $('#ohdShopGpByShpShpCode').val();
        var nPageCurrent = (pnPages === undefined || pnPages == '') ? '1' : pnPages;
        $.ajax({
            type: "POST",
            url: "CmpShopGpByShpDataTable",
            data: {
                tOcmBchCode: tOcmBchCode,
                tSearchAll: tSearchAll,
                tBchCode: tBchCode,
                tShpCpde: tShpCpde,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            async: false,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    $('#oetShopGpByShpDateStart').val('');
                    $('#oetShopGpByShopGpAvg').val('');
                    $('#oetShopGpByShopGpMon').val('');
                    $('#oetShopGpByShopGpTue').val('');
                    $('#oetShopGpByShopGpWed').val('');
                    $('#oetShopGpByShopGpThu').val('');
                    $('#oetShopGpByShopGpFri').val('');
                    $('#oetShopGpByShopGpSat').val('');
                    $('#oetShopGpByShopGpSun').val('');
                    $('.xWPageEdit').addClass('hidden');
                    $('.xWPageAdd').removeClass('hidden');
                    $('#odvSetionShopGPBySHP').html(aReturnData['vShopGpByShpDataList']);
                    JCNxLayoutControll();
                    JStCMMGetPanalLangHTML('TCNMShop_L'); //โหลดภาษาใหม่
                    JCNxCloseLoading();
                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        JCNxCloseLoading();
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Event Add POS SHOP
//Parameters : From Submit
//Creator : 09/05/2019 Saharat (Golf)
//Return : Status Event Add POS SHOP
//Return Type : object
function JSoAddGpByShop(ptStaGp) {
    var tStaGp = ptStaGp
    var tBchCode = $('#ohdShopGpByShpBchCode').val();
    var tShpCode = $('#ohdShopGpByShpShpCode').val();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "CmpShopGpByShpEventAdd",
        data: $('#ofmAddGpByShp').serialize() + "&tStaGp=" + tStaGp + "$tBchCode=" + tBchCode + "$tShpCode=" + tShpCode,
        success: function(oResult) {
            var tResult = JSON.parse(oResult);
            if (tResult['rtCode'] == '1') {
                $('#oetShopGpByShpDateStart').val('');
                $('#oetShopGpByShopGpAvg').val('');
                $('#oetShopGpByShopGpMon').val('');
                $('#oetShopGpByShopGpTue').val('');
                $('#oetShopGpByShopGpWed').val('');
                $('#oetShopGpByShopGpThu').val('');
                $('#oetShopGpByShopGpFri').val('');
                $('#oetShopGpByShopGpSat').val('');
                $('#oetShopGpByShopGpSun').val('');
                JSvCallPageShopGpByShpDataTable(1, tResult['rtBchCode']);
            }
            if (tResult['rtCode'] == '600') {
                tMsgBody = tResult['rtDesc'];
                tCode = '001';
                tStaGp = 1;
                tFuntionName = 'JSoAddGpByShop'; //ฟังชั่น ที่จะดำเนินการต่อ 
                FSvCMNSetMsgWarningDialog(tMsgBody, tFuntionName, tCode, tStaGp);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality: (event) Delete
//Parameters: Button Event [tIDCode รหัสเหตุผล]
//Creator: 13/05/2019 saharat(Golf)
//Update: -
//Return: Event Delete Reason List
//Return Type: -
function JSnShopGpByShpDel(pnSeq,pnSHP,pDateStart, pnPage, ptBchCode, ptYesOnNo) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];
    if (aDataSplitlength == '1') {
        $tBchCode = $('#ocmShopGpByShpBchCode').val();
        $('#odvModalDelShopGpByShp').modal('show');
        $('#odvModalDelShopGpByShp #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptBchCode + ' ( ' + pDateStart + ' ) ' + ptYesOnNo);
        $('#odvModalDelShopGpByShp #osmConfirm').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url: "CmpShopGpByShpEventDelete",
                data: {
                    pnSeq       : pnSeq,
                    pnSHP       : pnSHP,
                    tIDCode     : pDateStart,
                    tBchCode    : ptBchCode
                },
                cache: false,
                success: function(tResult) {
                    tResult         = tResult.trim();
                    var aReturn     = $.parseJSON(tResult);
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                    setTimeout(function() {
                        if (aReturn["nNumRowPdtGpbyShop"] != 0) {
                            if (aReturn["nNumRowPdtGpbyShop"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowPdtGpbyShop"] / 10);
                                if (pnPage <= nNumPage) {
                                    JSvSearchAllShopGp(pnPage);
                                } else {
                                    JSvSearchAllShopGp(nNumPage);
                                }
                            } else {
                                JSvSearchAllShopGp(1, ptBchCode);
                            }
                        } else {
                            JSvSearchAllShopGp(1, ptBchCode);
                        }
                    }, 500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 14/05/2019 Saharat(Golf)
//Return : View
//Return Type : View
function JSvPshClickPage(ptPage, ptBchCode) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePsh .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            JSvCallPageShopGpByShpDataTable(nPageCurrent, ptBchCode);
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePsh .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            JSvCallPageShopGpByShpDataTable(nPageCurrent, ptBchCode);
            break;
        default:
            nPageCurrent = ptPage
            JSvCallPageShopGpByShpDataTable(nPageCurrent, ptBchCode);
    }

}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 15/05/2018
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
        if (nNumOfArr > 1) {
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('.xCNIconDel').removeClass('xCNDisabled');
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 15/05/2018 wasin
//Return: -
//Return Type: -
function JSxSHPPaseCodeDelInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        $('#odvModalDelShopGpShp #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
        $('#odvModalDelShopGpShp #ohdConfirmIDDelMultiple').val(tTextCode);
    }
}


//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 06/06/2018 Krit
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

function JSnShopGpByShpDelChoose(pnSeq,pnSHP,pnPage,pDateStart,ptBchCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var aDataDelMultiple = $(
            "#odvModalDelShopGpShp #ohdConfirmIDDelMultiple"
        ).val();
        var aTextsDelMultiple = aDataDelMultiple.substring(
            0,
            aDataDelMultiple.length - 2
        );
        var aDataSplit = aTextsDelMultiple.split(" , ");
        var nDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        for ($i = 0; $i < nDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }
        JCNxOpenLoading();
        if (nDataSplitlength > 1) {
            $.ajax({
                type: "POST",
                url: "CmpShopGpByShpEventDelete",
                data: {
                    pnSeq   : pnSeq,
                    pnSHP   : pnSHP,
                    tIDCode : aNewIdDelete,
                    tBchCode: ptBchCode
                },
                success: function(tResult) {
                    tResult = tResult.trim();
                    var aReturn = $.parseJSON(tResult);
                    $('#odvModalDelShopGpShp').modal('hide');
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.obtChoose').hide();
                    $('.modal-backdrop').remove();
                    setTimeout(function() {
                        if (aReturn["nNumRowPdtGpbyShop"] != 0) {
                            if (aReturn["nNumRowPdtGpbyShop"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowPdtGpbyShop"] / 10);
                                if (pnPage <= nNumPage) {
                                    JSvCallPageShopGpByShpDataTable(pnPage, ptBchCode);
                                } else {
                                    JSvCallPageShopGpByShpDataTable(pnPage, ptBchCode);
                                }
                            } else {
                                JSvCallPageShopGpByShpDataTable(1, ptBchCode);
                            }
                        } else {
                            JSvCallPageShopGpByShpDataTable(1, ptBchCode);
                        }
                    }, 500);
                    JCNxCloseLoading();
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
}

// Functionality: Search District List
// Parameters: tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
// Creator: 15/05/2019 Saharat(Golf)
// Last Update:	-
// Return: Views
// Return Type: View
function JSvSearchAllShopGp(pnPages) {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var tSearchAll = $('#oetSearchShopGpShp').val();
        var tBchCode = $('#ocmShopGpByShpBchCode').val();
        var tShpCpde = $('#ohdShopGpByShpShpCode').val();
        var nPageCurrent = (pnPages === undefined || pnPages == '') ? '1' : pnPages;
        var tSearchAll = $("#oetSearchShopGpShp").val();

        $.ajax({
            type: "POST",
            url: "CmpShopGpByShpDataTable",
            data: {
                tSearchAll: tSearchAll,
                tBchCode: tBchCode,
                tShpCpde: tShpCpde,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == 1) {
                    JSvCallPageShopGpByShpDataTable(pnPages, tBchCode);
                    $('#oetSearchShopGpShp').val('');
                }
                // JSxSHPNavDefult();
                // JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}


//Functionality : Call Agency Page Edit
//Parameters : -
//Creator : 10/06/2019 Krit(golf)
//Return : View
//Return Type : View
function JSvCallPageShopByGPEdit(pnSeq,pdDateStr, ptBchCode, ptShpCode) {
    JCNxOpenLoading();
    $.ajax({
        type    : "POST",
        url     : "CmpShopGpByShpPageEdit",
        data    : {
            pnSeq       : pnSeq,
            dDateStr    : pdDateStr,
            ptBchCode   : ptBchCode,
            tBchCode    : $('#ohdShopGpByShpBchCode').val(),
            tShpCode    : $('#ohdShopGpByShpShpCode').val(),
            tPageEvent  : 'PageAEdit'
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#odvSetionShopGPByShp').html(tResult);
                $('.xWPageEdit').removeClass('hidden');
                $('.xWPageAdd').addClass('hidden');
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}