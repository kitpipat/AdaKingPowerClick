
var nStaIFHBrowseType = $('#oetIFHStaBrowse').val();
var tCallIFHBackOption = $('#oetIFHCallBackOption').val();
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxIFHNavDefult();

    if (nStaIFHBrowseType != 1) {
        JSvCallPageIFHList();
    } else {

    }

});

function JSxIFHNavDefult() {
    if (nStaIFHBrowseType != 1 || nStaIFHBrowseType == undefined) {
        $('.xCNBnkVBrowse').hide();
        $('.xCNBnkVMaster').show();
        $('#oliBnkEdit').hide();
        $('#oliBnkAdd').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#ocmIFHStaDone').show();

    } else {
        $('#odvModalBody .xCNBnkVMaster').hide();
        $('#odvModalBody .xCNBnkVBrowse').show();
        $('#odvModalBody #odvBnkMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliBnkNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvBnkBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNBnkBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNBnkBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function
//Creator : 02/07/2018 wasin
//Return : Modal Status Error
//Return Type : view
function JCNxResponseError(jqXHR, textStatus, errorThrown) {
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
}



function JSvCallPageIFHList() {

    localStorage.tStaPageNow = 'JSvCallPageIFHList';

    $.ajax({
        type: "GET",
        url: "interfacehistorylist",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {

            $('#odvContentPagehistory').html(tResult);
            $('.xCNBTNPrimeryPlus').show();
            $('#oliBnkTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            JSxIFHNavDefult();

            JSvCallPageIFHDataTable(); //แสดงข้อมูลใน List
        },
        error: function(data) {
            console.log(data);
        }
    });

}

//Last Modified : Napat(Jame) 03/04/63
function JSvCallPageIFHDataTable(pnPage) {

    //Added By Napat(Jame) 03/04/63
    var aPackDataSearch = {
        tIFHSearchAll   : $('#oetSearchAll').val(),
        tIFHStatus      : $('#ocmIFHStaDone').val(),
        tIFHType        : $('#ocmITFXXshType').val(),
        tIFHInfCode     : $('#ocmIFHInfCode').val(),
        tIFHDateFrom    : $('#oetIFHDocDateFrom').val(),
        tIFHDateTo      : $('#oetIFHDocDateTo').val(),
    };

    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "interfaceihistorydatatable",
        data: {
                // tSearchAll: tSearchAll,
                // tStatusIFH: tStatusIFH,
                // tSearchDocDateFromIFH: tSearchDocDateFromIFH,
                // tSearchDocDateToIFH: tSearchDocDateToIFH,
                aPackDataSearch : aPackDataSearch,
                nPageCurrent    : nPageCurrent,
            },
        cache: false,
        timeout: 5000,
        success: function(tResult) {

            $('#odvContentIFHDatatable').html(tResult);

            JSxIFHNavDefult();
            JCNxLayoutControll();
            // JStCMMGetPanalLangHTML('TFNMBank_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();

        },
        error: function(data) {
            console.log(data);
        }
    });

}


///function : Function Clear Defult Button Bank
//Parameters : -
//Creator : 11/01/2019 Jame
//Return : -
//Return Type : -
function JSxIFHBtnNavDefult() {
    $('#oliBnkTitleAdd').hide();
    $('#oliBnkTitleEdit').hide();
    $('#odvBtnAddEdit').hide();
    $('.obtChoose').hide();
    $('#odvBtnBnkInfo').show();
}

// //Functionality : (event) Delete All
// //Parameters :
// //Creator : 15/05/2018 wasin
// //Return :
// //Return Type :
function JSnBankDelChoose1(pnPage) {

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
            url: "bankEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {

                JSxIFHBtnNavDefult();
                setTimeout(function() {
                    $('#odvModalDelBank').modal('hide');
                    JSvCallPageIFHDataTable(pnPage);
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
}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 02/07/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvBNKClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageBank .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageBank .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvCallPageIFHDataTable(nPageCurrent);
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
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 15/05/2018 wasin
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

//Functionality: Search all
//Parameters: tSearchAll = ข้อความที่ใช้ค้นหา  tStatusIFH = status
// tSearchDocDateFromIFH = datefrom  tSearchDocDateToIFH = date to, nPageCurrent = 1
//Creator: 5/3/2020
//Return: View
//Return Type: View
// function JSvSearchAllIFH() {
//     var tSearchAll = $('#oetSearchAll').val();
//     var tStatusIFH = $('#ocmIFHStaDone').val();
//     var tSearchDocDateFromIFH = $('#oetIFHDocDateFrom').val();
//     var tSearchDocDateToIFH   = $('#oetIFHDocDateTo').val();
//     var nIFHType = $('#ocmIFHType').val();
//     var nIFHInfCode = $('#ocmIFHInfCode').val();
//     JCNxOpenLoading();
//     $.ajax({
//         type: "POST",
//         url: "interfaceihistorydatatable",
//         data: {
//             tSearchAll: tSearchAll,
//             tStatusIFH: tStatusIFH,
//             tSearchDocDateFromIFH: tSearchDocDateFromIFH,
//             tSearchDocDateToIFH: tSearchDocDateToIFH,
//             nPageCurrent: 1,
//             nIFHType:nIFHType,
//             nIFHInfCode:nIFHInfCode
//         },
//         cache: false,
//         Timeout: 0,
//         success: function(tResult) {
//             if (tResult != "") {
//                 $('#odvContentIFHDatatable').html(tResult);
//             }
//             JSxIFHBtnNavDefult();
//             JCNxLayoutControll();
//             // JStCMMGetPanalLangHTML('TFNMBank_L'); //โหลดภาษาใหม่
//             JCNxCloseLoading();
//         },
//         error: function(data) {
//             console.log(data);
//         }
//     });
// }


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 18/06/2019 saharat(Golf)
//Return : View
//Return Type : View
function JSvCPNClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvCallPageIFHDataTable(nPageCurrent);
}







//Functionality : Call Credit Page Edit
//Parameters : -
//Creator : 02/07/2018 krit
//Return : View
//Return Type : View
function JSvCallPageRateAdd() {

    $.ajax({
        type: "GET",
        url: "bankAddData",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            if (nStaRteBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('.xCNCpnVBrowse').hide();
                $('.xCNCpnVMaster').show();
                $('#odvBtnAddEdit').show();
                $('#odvBtnCmpEditInfo').show();
                $('#odvBtnAgnInfo').hide();
                $('#oliBnkEdit').hide();
                $('#oliBnkAdd').show();
            }
            // $('#obtBarSubmitRte').show();

            $('#odvContentPageBank').html(tResult);
        },
        error: function(data) {
            console.log(data);
        }
    });


}
