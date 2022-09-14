var nStaRsnBrowseType = $('#oetRsnStaBrowse').val();
var tCallRsnBackOption = $('#oetRsnCallBackOption').val();

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxRsnNavDefult();
    if (nStaRsnBrowseType != 1) {
        JSvCallPageNationList();
    } else {
        JSvCallPageNationAdd();
    }
});

///function : Function Clear Defult Button Nation
//Parameters : -
//Creator : 08/05/2018 wasin
//Update:   28/05/2018 wasin
//Return : -
//Return Type : -
function JSxRsnNavDefult() {
    // Menu Bar เข้ามาจาก หน้า Master หรือ Browse
    if (nStaRsnBrowseType != 1) { // เข้ามาจาก  Master
        $('.obtChoose').hide();
        $('#oliRsnTitleAdd').hide();
        $('#oliRsnTitleEdit').hide();
        $('#odvBtnRsnAddEdit').hide();
        $('#odvBtnRsnInfo').show();
    } else { // เข้ามาจาก Browse Modal
        $('#odvModalBody #odvRsnMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliRsnNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvRsnBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNRsnBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNRsnBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

///function : Call Nation Page list  
//Parameters : - 
//Creator:	08/05/2018 wasin
//Update:   28/05/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageNationList(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        // localStorage.tStaPageNow = 'JSvCallPageNationList';
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "nationList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageNation').html(tResult);
                JSvNationDataTable(pnPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

///function : Call Nation Data List
//Parameters : Ajax Success Event 
//Creator:	28/05/2018 wasin
//Update:   
//Return : View
//Return Type : View
function JSvNationDataTable(pnPage) {
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
            url: "nationDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataNationTableList').html(tResult);
                }
                JSxRsnNavDefult();
                JCNxLayoutControll();
                // JStCMMGetPanalLangHTML('TCNMRsn_L'); //โหลดภาษาใหม่
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


function JSvNationDataTableAPI(pnPage) {


    $('#odvModalAPINation').modal('show');

    $('#osmConfirmAPINation').on('click', function(evt) {
        $('#odvModalAPINation').modal('hide');
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "nationDataTableAPI",
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                var aResult = JSON.parse(tResult);
                if (aResult['rtCode'] == 1) {
                    JSxRsnNavDefult();
                    JCNxLayoutControll();
                    // JStCMMGetPanalLangHTML('TCNMRsn_L'); //โหลดภาษาใหม่
                    JCNxCloseLoading();
                    JSvNationDataTable(pnPage);
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });
}

// Create By : Napat(Jame) 15/03/2022
function JSvClickPage(ptPage) {
    var nPageCurrent = '';
    var nPageNew;
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageNationGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew;
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageNationGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew;
            break;
        default:
            nPageCurrent = ptPage;
    }
    JSvNationDataTable(nPageCurrent);
}