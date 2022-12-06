//Functionality : Check ค่าจาก input ส่วไป Check ใน Base ว่ามี ID นี้อยู่หรือไม่
//Parameters : -
//Creator : 18/04/2018 Krit(Copter)
//Return : Status,Message
//Return Type : String
function JStCMNCheckDuplicateCodeMaster(ptObjCodeid, ptFuncName, ptTableName, ptFieldName) {

    tCode = $('#' + ptObjCodeid).val();

    var tTableName = ptTableName;
    var tFieldName = ptFieldName;

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

                //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
                if (tData.rtCode == '1') {
                    FSvCMNSetMsgWarningDialog(tData.rtDesc, ptFuncName, tCode)
                }

            },
            error: function (data) {
                console.log(data);
            }
        });

    } else {
        alert('กรุณากรอก Code');
    }

}

// ฟังก์ชั่นเช็ค Session Expried
function JCNxFuncChkSessionExpired() {
    var nStaSession = '';
    $.ajax({
        url     : 'CheckSession',
        type    : "POST",
        cache   : false,
        timeout : 0,
        async   : false,
        success: function (nReturn) {
            nStaSession = nReturn;
        }
    });
    return nStaSession.toString();
}

// ฟังก์ชั่นแสดง Message Error Session Expired
function JCNxShowMsgSessionExpired() {
    JCNxCloseLoading();
    var tMsgSesExpired = $('#ohdMsgSesExpired').val();
    $('#odvModalBodyWanning .modal-body ').html(tMsgSesExpired);
    $('#odvModalWanning').modal({ backdrop: 'static', keyboard: false })
    $('#odvModalWanning').modal({ show: true });
    $('#odvModalWanning #odvModalBodyWanning .modal-footer button').click(function () {
        window.location.href = tBaseURL + 'logout';
    });
}

// Create By : Napat(Jame) 25/11/2022
// ฟังก์ชั่นเช็ค Cookies Exprie
function JCNnCheckCookiesExpired() {
    var tChkCookies = $.cookie('AdaStoreBackCookies');
    var nStaReturn  = 1;
    if( tChkCookies === undefined ){
        nStaReturn = 0;
    }
    return nStaReturn;
}

function FSaChangeLang() {
    var tValLang = $('#ocmChangeLang').val();

    var tLangID = $('#ocmChangeLang option:selected').data('id');

    window.location.href = "ChangeLang/" + tValLang + '/' + tLangID;

}


//เปิดปิด Menu เงื่อนไข Pin Menu
function JSxCheckPinMenuClose() {
    if ($(".main").hasClass("xWWidth100")) {

    } else {
        $('.xCNBody').addClass('layout-fullwidth');
        $('.brand').removeClass('xWMargin100');
    }
}

function JSvChangLangEdit(nLang) {

    $.ajax({
        type: "POST",
        url: 'ChangeLangEdit',
        data: {
            nLang: nLang
        },
        success: function (tResult) {

            if (localStorage.tStaPageNow != '' && localStorage.tStaPageNow != undefined) { //Check ค่าว่าอยู่หน้าไหน เพื่อ Refresh หน้าได้

                tStaPageNow = localStorage.tStaPageNow;
                aStaPageNow = tStaPageNow.split(',');
                tFsName = aStaPageNow[0];

                if (tFsName == 'JSvCallPageListShop') {
                    /*Load Function mี่รับ Paramitter 2 ตัว*/
                    tBchCode = aStaPageNow[1];
                    localStorage.tStaPageNow = '';
                    window[tFsName](tBchCode);
                } else {
                    /*Load Function mี่รับ Paramitter 1 ตัว*/
                    localStorage.tStaPageNow = '';
                    window[tFsName]();
                }
                0
                // if(tFsName == 'JSvCallPageReciveList'){ /*Receive List*/
                //     localStorage.tStaPageNow = '';
                //     window[tFsName]();
                // }

                // if(tFsName == 'JSvBCHCallPageBranchList'){ /*Branch List*/
                //     localStorage.tStaPageNow = '';
                //     window[tFsName]();
                // }

            } else {
                alert('ไม่สามารถโหลดภาษาที่เลือกได้')
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}


function JSvChangeBtnSaveAction(nStaActive) {

    $.ajax({
        type: "POST",
        url: 'ChangeBtnSaveAction',
        data: {
            nStaActive: nStaActive
        },
        success: function (tResult) {

            localStorage.tBtnSaveStaActive = nStaActive
            //Active Style
            $('.xWDrpDwnMenuMargLft li').removeClass('xWBtnSaveActive');
            // $('#olibtnsave' + nStaActive).addClass('xWBtnSaveActive');3
            $('.xWolibtnsave' + nStaActive).addClass('xWBtnSaveActive');

        },
        timeout: 3000,
        error: function (data) {
            console.log(data);
        }
    });

}


function JSvChangLangPageAddEdit(nLang, tFSNameString, tFSName, tCode) {

    $.ajax({
        type: "POST",
        url: 'ChangeLangEdit',
        data: {
            nLang: nLang
        },
        success: function (tResult) {

            if (tFSName != null) {

                aCode = tCode.split(',');

                if (aCode[1] != '') {
                    aCode = tCode.split(',');
                    tFSName(aCode[0], aCode[1]);
                } else {
                    tFSName(tCode); // Function หน้า Branch
                }

            } else {
                $.ajax({
                    type: "POST",
                    url: 'ChangeLangEdit',
                    data: {
                        nLang: nLang
                    },
                    success: function (tResult) {

                        JStCMMGetPanalLangSystemHTML(tFSName, tCode)

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

            }


        },
        error: function (data) {
            console.log(data);
        }
    });

}


//เปลี่ยน lang หน้า List
function JStCMMGetPanalLangHTML(tTableName) {

    $.ajax({
        type: "POST",
        url: 'GetPanalLangListHTML',
        data: {
            tTableName: tTableName
        },
        success: function (tResult) {

            $('#odvLangPanal').html(tResult);
            $('#odvLangEditPanal').css('display', 'block');

        },
        error: function (data) {
            console.log(data);
        }
    });

}
//เปลี่ยน lang หน้า Add Edit
function JStCMMGetPanalLangSystemHTML(tFSName, tCode) {

    $.ajax({
        type: "POST",
        url: 'GetPanalLangSystemHTML',
        data: {
            tFSName: tFSName,
            tCode: tCode
        },
        success: function (tResult) {

            $('#odvLangPanal').html(tResult);
            $('#odvLangEditPanal').css('display', 'block');

        },
        error: function (data) {
            console.log(data);
        }
    });

}

//function : function Open Lodding
//Parameters : -
//Creator : 03/05/2018 wasin
//Return : Open Loding
//Return Type : -
function JCNxOpenLoading() {
    $('.xCNOverlay').delay(5).fadeIn();
}

//function : function Close Lodding
//Parameters : -
//Creator : 03/05/2018 wasin
//Return : Close Lodding
//Return Type : -
function JCNxCloseLoading() {
    // $(window).scrollTop(0);
    $('.xCNOverlay').delay(10).fadeOut();
}

//function : function Open Lodding Data
//Parameters : -
//Creator : 19/04/2019 wasin(Yoshi)
//Return : Open Lodding Data
//Return Type : -
function JCNxOpenLoadingData() {
    $('.xCNOverlayLodingData #odvOverLayContentForLongTimeLoading').show();
    $('.xCNOverlayLodingData').delay(5).fadeIn();
}

//function : function Close Lodding Data
//Parameters : -
//Creator : 19/04/2019 wasin(Yoshi)
//Return : Close Lodding Data
//Return Type : -
function JCNxCloseLoadingData() {
    $('.xCNOverlayLodingData #odvOverLayContentForLongTimeLoading').hide();
    $('.xCNOverlayLodingData').delay(10).fadeOut();
}

//function : function Open Lodding Modal
//Parameters : -
//Creator : 09/10/2018 wasin
//Return : Open Loding
//Return Type : -
function JCNxOpenLoadingInModal() {
    $('.xCNLoddingModal').fadeIn();
}

//function : function Close Lodding Modal
//Parameters : -
//Creator : 09/10/2018 wasin
//Return : Open Loding
//Return Type : -
function JCNxCloseLoadingInModal() {
    $('.modal-body').scrollTop(0);
    $('.xCNLoddingModal').delay(500).fadeOut();
}


///function : function Call Modal Browse
//Parameters : -
//Creator : 03/05/2018 wasin
//Return : Modal Browse Data
//Return Type : String
function JSvCallModalBrowse(pnPage, ptBrowseType, ptRouteBrowse, ptInputBrowse, ptInputBrowseShow, ptLangTitle) {
    //pnPage			=> หน้าเพจปัจจุบัน
    //ptBrowseType		=> SB:Single Browse / MB:Muti Browse
    //ptRouteBrowse 	=> Route ใช้ในการดึงข้อมูล Data Browse
    //ptInputBrowse 	=> ชื่อ Input ที่ใช้ในการส่งข้อมูลกลับไปยัง Input
    //ptInputBrowseShow => ชื่อ Input ที่ใช้ในการแสดงข้อมูลการ Browse
    //ptLangTitle		=> Lang ของหัวเรื่องการ Browse Modal
    JCNxOpenLoading();
    var tBrowseCode = $('#' + ptInputBrowse).val();
    var tBrowseName = $('#' + ptInputBrowseShow).val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }
    $.ajax({
        type: "POST",
        url: ptRouteBrowse,
        cache: false,
        data: {
            nPageCurrent: nPageCurrent,
            tBrowseType: ptBrowseType,
            tRouteBrowse: ptRouteBrowse,
            tInputBrowse: ptInputBrowse,
            tInputBrowseShow: ptInputBrowseShow,
            tLangTitle: ptLangTitle
        },
        dataType: "JSON",
        success: function (tResult) {
            var tBrowseType = tResult.tBrowseType;
            if (tResult != "") {
                $('#olbModalTitle').html(ptLangTitle);
                $('#oetBrowseSearchAll').attr('onkeypress', 'Javascript:if(event.keyCode==13) JSvSearchBrowseData("' + ptRouteBrowse + '","' + tBrowseType + '","' + ptInputBrowse + '","' + ptInputBrowseShow + '","' + ptLangTitle + '")');
                $('#odvClickSearch').attr('onclick', 'JSvSearchBrowseData("' + ptRouteBrowse + '","' + tBrowseType + '","' + ptInputBrowse + '","' + ptInputBrowseShow + '","' + ptLangTitle + '")');
                $('.xCNBtnBrowse ').attr('onclick', 'JSxSelectBrowse("' + ptInputBrowse + '","' + ptInputBrowseShow + '")');
                $('#odvBrowseTable').html(tResult.tBrowseTable);
                $('#odvBrowseTotalAll').html(tResult.tBrowseTotalPage);
                $('#odvBrowsePaging').html(tResult.tBrowsePaging);
                $('#oetBrowseSearchAll').val(tResult.tSearchAll);
                $('#oetBrowseCode').val(tBrowseCode);
                $('#oetBrowseName').val(tBrowseName);
                JSvBrowseModalClick(tBrowseType, tBrowseCode, tBrowseName);
                $('#odvModalBrowse').modal({ backdrop: 'static', keyboard: false });
                $('#odvModalBrowse').modal('show');
            }
            JCNxCloseLoading();
        },
        timeout: 3000,
        error: function (data) {
            JSvCallModalBrowse(pnPage, ptBrowseType, ptRouteBrowse, ptInputBrowse, ptInputBrowseShow, ptLangTitle)
            console.log(data);
        }
    });
}

///function : function Search Data Modal Browse
//Parameters : -
//Creator : 03/05/2018 wasin
//Return : Browse Data
//Return Type : String
function JSvSearchBrowseData(ptRouteBrowse, ptBrowseType, ptInputBrowse, ptInputBrowseShow, ptLangTitle) {
    var tBrowseSearch = $('#oetBrowseSearchAll').val();
    $.ajax({
        type: "POST",
        url: ptRouteBrowse,
        cache: false,
        data: {
            tSearchAll: tBrowseSearch,
            tBrowseType: ptBrowseType,
            tRouteBrowse: ptRouteBrowse,
            tInputBrowse: ptInputBrowse,
            tInputBrowseShow: ptInputBrowseShow,
            tLangTitle: ptLangTitle
        },
        dataType: "JSON",
        success: function (tResult) {
            setTimeout(function () {
                $('#odvBrowseTable').html(tResult.tBrowseTable);
                $('#odvBrowseTotalAll').html(tResult.tBrowseTotalPage);
                $('#odvBrowsePaging').html(tResult.tBrowsePaging);
                $('#oetBrowseSearchAll').val(tResult.tSearchAll);
                tBrowseCode = $('#oetBrowseCode').val();
                tBrowseName = $('#oetBrowseName').val();
                JSvBrowseModalClick(ptBrowseType, tBrowseCode, tBrowseName);
            }, 500);
        },
        error: function (data) {
            console.log(data);
        }
    });
}



///function : function Search Data Modal Browse
//Parameters : -
//Creator : 03/05/2018 wasin
//Return : Browse Data
//Return Type : String
function JSvSearchBrowseDataWhereData(ptRouteBrowse, ptWhereCode, tBrowseType) {
    var tBrowseSearch = $('#oetBrowseSearchAll').val();
    $.ajax({
        type: "POST",
        url: ptRouteBrowse,
        cache: false,
        data: {
            tSearchAll: tBrowseSearch,
            tWhereCode: ptWhereCode
        },
        dataType: "JSON",
        success: function (tResult) {
            setTimeout(function () {
                $('#odvBrowseTable').html(tResult.tBrowseTable);
                $('#odvBrowseTotalAll').html(tResult.tBrowseTotalPage);
                $('#odvBrowsePaging').html(tResult.tBrowsePaging);
                $('#oetBrowseSearchAll').val(tResult.tSearchAll);

                tBrowseCode = $('#oetBrowseCode').val();
                tBrowseName = $('#oetBrowseName').val();

                JSvBrowseModalClick(tBrowseType, tBrowseCode, tBrowseName);
            }, 500);
        },
        timeout: 3000,
        error: function (data) {
            console.log(data);
        }
    });
}


///function : function Call Modal Browse Zone Where Area
//Parameters : -
//Creator : 22/05/2018 Krit(Copter)
//Return : Modal Browse Data
//Return Type : String
function JSvCallModalBrowseDataWhereData(pnPage, ptBrowseType, ptRouteBrowse, ptInputBrowse, ptInputBrowseShow, ptInputWhereCode, ptLangTitle) {
    //pnPage		=> หน้าเพจปัจจุบัน
    //ptBrowseType	=> SB:Single Browse / MB:Muti Browse
    //ptRouteBrowse => Route ใช้ในการดึงข้อมูล Data Browse
    //ptInputBrowse => Input ที่ใช้ในการส่งข้อมูลกลับไปยัง Input
    //ptLangTitle	=> Lang ของหัวเรื่องการ Browse Modal

    JCNxOpenLoading();
    var tBrowseCode = $('#' + ptInputBrowse).val();
    var tBrowseName = $('#' + ptInputBrowseShow).val();
    var tWhereCode = $('#' + ptInputWhereCode).val(); //input value ที่ใช้เอาไป Where
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }
    $.ajax({
        type: "POST",
        url: ptRouteBrowse,
        cache: false,
        data: {
            nPageCurrent: nPageCurrent,
            tBrowseType: ptBrowseType,
            tRouteBrowse: ptRouteBrowse,
            tInputBrowse: ptInputBrowse,
            tInputBrowseShow: ptInputBrowseShow,
            tLangTitle: ptLangTitle,
            tInputWhereCode: ptInputWhereCode,
            tWhereCode: tWhereCode
        },
        dataType: "JSON",
        success: function (tResult) {
            var tBrowseType = tResult.tBrowseType;
            if (tResult != "") {
                $('#olbModalTitle').html(ptLangTitle);
                $('#oetBrowseSearchAll').attr('onkeypress', 'Javascript:if(event.keyCode==13) JSvSearchBrowseDataWhereData("' + ptRouteBrowse + '","' + tWhereCode + '","' + tBrowseType + '")');
                $('#odvClickSearch').attr('onclick', 'JSvSearchBrowseDataWhereData("' + ptRouteBrowse + '","' + tWhereCode + '","' + tBrowseType + '")');
                $('.xCNBtnBrowse ').attr('onclick', 'JSxSelectBrowse("' + ptInputBrowse + '","' + ptInputBrowseShow + '")');
                $('#odvBrowseTable').html(tResult.tBrowseTable);
                $('#odvBrowseTotalAll').html(tResult.tBrowseTotalPage);
                $('#odvBrowsePaging').html(tResult.tBrowsePaging);
                $('#oetBrowseSearchAll').val(tResult.tSearchAll);
                $('#oetBrowseCode').val(tBrowseCode);
                $('#oetBrowseName').val(tBrowseName);
                JSvBrowseModalClick(tBrowseType, tBrowseCode, tBrowseName);
                $('#odvModalBrowse').modal({ backdrop: 'static', keyboard: false });
                $('#odvModalBrowse').modal('show');
            }
            JCNxCloseLoading();
        },
        timeout: 3000,
        error: function (data) {
            JSvCallModalBrowseDataWhereData(pnPage, ptBrowseType, ptRouteBrowse, ptInputBrowse, ptInputBrowseShow, ptInputWhereCode, ptLangTitle)
            console.log(data);
        }
    });
}


///function : Function
//Parameters : -
//Creator : 04/05/2018 wasin
//Return :
//Return Type : -
function JSvClickBrowseDataWhereDataPage(ptPage, ptBrowseType, ptRouteBrowse, ptInputBrowse, ptInputBrowseShow, ptInputWhereCode, ptLangTitle) {
    // if(ptPage == '1'){ var nPage = 'previous'; }else if(ptPage == '2'){ var nPage = 'next';}

    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.pagination .active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.pagination .active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }

    JSvCallModalBrowseDataWhereData(nPageCurrent, ptBrowseType, ptRouteBrowse, ptInputBrowse, ptInputBrowseShow, ptInputWhereCode, ptLangTitle);
}



///function : Function Click Select Data In Modal Browse
//Parameters : -
//Creator : 04/05/2018 wasin
//Return : event Click Data Browse
//Return Type : -
function JSvBrowseModalClick(ptBrowseType, ptBrowseCode, ptBrowseName) {

    var nLengBrowsecode = ptBrowseCode.length;
    if (nLengBrowsecode != '0') {
        var aBrowseCode = ptBrowseCode.split(",");
        var aBrowseName = ptBrowseName.split(",");
        localStorage.removeItem("LocalBrowseItems");
        var objOldData = [];
        for ($i = 0; $i < aBrowseCode.length; $i++) {
            objOldData.push({ "nCode": aBrowseCode[$i], "tName": aBrowseName[$i] });
        }
        localStorage.setItem("LocalBrowseItems", JSON.stringify(objOldData));
    } else {
        localStorage.removeItem("LocalBrowseItems");
    }
    JSxShowBtnBrowse(ptBrowseType);
    if (ptBrowseType == 'SB') {
        $('.ocbBrowseListItem').hide();
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalBrowseItems"))];
        var nlength = $('#odvBrowseList').children('tr').length;
        for ($i = 0; $i < nlength; $i++) {
            var tDataCode = $('#otrBrowseList' + $i).data('code')
            if (aArrayConvert == null || aArrayConvert == '') { } else {
                var aReturnRepeat = findObjectBrowseByKey(aArrayConvert[0], 'nCode', tDataCode);
                if (aReturnRepeat == 'Dupilcate') {
                    $('#ocbBrowseListItem' + $i).show();
                    $('#ocbBrowseListItem' + $i).prop('checked', true);
                } else { }
            }
        }
        $('.otrBrowseList').click(function () {
            $('.otrBrowseList').css('background-color', '#FFFFFF');
            $(this).css('background-color', '#4fbcf31a');
            $(this).find('.ocbBrowseListItem').show();
            $(this).find('.ocbBrowseListItem').prop('checked', true);
            var nCode = $(this).data('code');
            var tName = $(this).data('name');
            var LocalBrowseItems = localStorage.getItem("LocalBrowseItems");
            var obj = [];
            var tData = [];
            if (LocalBrowseItems) {
                obj = JSON.parse(LocalBrowseItems);
            } else { }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalBrowseItems"))];
            if (aArrayConvert == '' || aArrayConvert == null) {
                obj.push({ "nCode": nCode, "tName": tName });
                localStorage.setItem("LocalBrowseItems", JSON.stringify(obj));
            } else {
                var aReturnRepeat = findObjectBrowseByKey(aArrayConvert[0], 'nCode', nCode);
                if (aReturnRepeat == 'None') {
                    localStorage.removeItem("LocalBrowseItems");
                    $('.ocbBrowseListItem').hide();
                    $(this).find('.ocbBrowseListItem').show();
                    $(this).find('.ocbBrowseListItem').prop('checked', true);
                    tData.push({ "nCode": nCode, "tName": tName });
                    localStorage.setItem("LocalBrowseItems", JSON.stringify(tData));
                } else if (aReturnRepeat == 'Dupilcate') { }
            }
            JSxShowBtnBrowse(ptBrowseType);
        });
    } else if (ptBrowseType == 'MB') {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalBrowseItems"))];
        var nlength = $('#odvBrowseList').children('tr').length;
        for ($i = 0; $i < nlength; $i++) {
            var tDataCode = $('#otrBrowseList' + $i).data('code')
            if (aArrayConvert == null || aArrayConvert == '') { } else {
                var aReturnRepeat = findObjectBrowseByKey(aArrayConvert[0], 'nCode', tDataCode);
                if (aReturnRepeat == 'Dupilcate') {
                    $('#ocbBrowseListItem' + $i).prop('checked', true);
                } else { }
            }
        }
        $('.otrBrowseList').click(function () {
            $('.otrBrowseList').css('background-color', '#FFFFFF');
            $(this).css('background-color', '#4fbcf31a');
            var nCode = $(this).data('code');
            var tName = $(this).data('name');
            $(this).find('.ocbBrowseListItem').prop('checked', true);
            var LocalBrowseItems = localStorage.getItem("LocalBrowseItems");
            var obj = [];
            if (LocalBrowseItems) {
                obj = JSON.parse(LocalBrowseItems);
            } else { }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalBrowseItems"))];
            if (aArrayConvert == '' || aArrayConvert == null) {
                obj.push({ "nCode": nCode, "tName": tName });
                localStorage.setItem("LocalBrowseItems", JSON.stringify(obj));
            } else {
                var aReturnRepeat = findObjectBrowseByKey(aArrayConvert[0], 'nCode', nCode);
                if (aReturnRepeat == 'None') {
                    obj.push({ "nCode": nCode, "tName": tName });
                    localStorage.setItem("LocalBrowseItems", JSON.stringify(obj));
                } else if (aReturnRepeat == 'Dupilcate') {
                    localStorage.removeItem("LocalBrowseItems");
                    $(this).find('.ocbBrowseListItem').prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for ($i = 0; $i < nLength; $i++) {
                        if (aArrayConvert[0][$i].nCode == nCode) {
                            delete aArrayConvert[0][$i];
                        }
                    }
                    var aNewarraydata = [];
                    for ($i = 0; $i < nLength; $i++) {
                        if (aArrayConvert[0][$i] != undefined) {
                            aNewarraydata.push(aArrayConvert[0][$i]);
                        }
                    }
                    localStorage.setItem("LocalBrowseItems", JSON.stringify(aNewarraydata));
                }
            }
            JSxShowBtnBrowse(ptBrowseType);
        });
    }
}

///function : Function Chack Duplicate Data
//Parameters : -
//Creator : 04/05/2018 wasin
//Return : Chack Dupilcate localStorage and Data in Modal
//Return Type : string
function findObjectBrowseByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

///function : Function Show Botton In Modal Browse
//Parameters : -
//Creator : 04/05/2018 wasin
//Return : View Button
//Return Type : -
function JSxShowBtnBrowse(ptBrowseType) {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalBrowseItems"))];
    if (aArrayConvert == null || aArrayConvert == '') {
        $('.xCNBtnBrowse').hide();
    } else {
        if (ptBrowseType == "SB") {
            $('#obtBrowseSB').show();
            $('#obtBrowseMB').hide();
        } else {
            $('#obtBrowseMB').show();
            $('#obtBrowseSB').hide();
        }
    }
}

///function : Function Select To Input Browse
//Parameters : -
//Creator : 04/05/2018 wasin
//Return : Insert Value In Input
//Return Type : -
function JSxSelectBrowse(ptInputBrowse, ptInputBrowseShow) {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalBrowseItems"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') { } else {
        var tText = '';
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tName;
            tText += ',';

            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ',';
        }
        var tTexts = tText.substring(0, tText.length - 1);
        var tTextsCode = tTextCode.substring(0, tTextCode.length - 1);
        $('#' + ptInputBrowse).val('');
        $('#' + ptInputBrowseShow).val('');
        $('#' + ptInputBrowse).val(tTextsCode);
        $('#' + ptInputBrowseShow).val(tTexts);
        $('#odvModalBrowse').modal('hide');
        setTimeout(function () {
            $('#' + ptInputBrowse).change();
        }, 300);
    }
}

///function : Function
//Parameters : -
//Creator : 04/05/2018 wasin
//Return :
//Return Type : -
function JSvClickBrowsePage(ptPage, ptBrowseType, ptRouteBrowse, ptInputBrowse, ptInputBrowseShow, ptLangTitle) {
    // if(ptPage == '1'){ var nPage = 'previous'; }else if(ptPage == '2'){ var nPage = 'next';}
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.pagination .active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.pagination .active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvCallModalBrowse(nPageCurrent, ptBrowseType, ptRouteBrowse, ptInputBrowse, ptInputBrowseShow, ptLangTitle);
}

///function : Function Call Map
//Parameters : -
//Creator : 22/05/2018 wasin
//Return : -
//Return Type : -
function JSxMapAddEdit(poMapData) {
    var app = {};
    app.Drag = function () {
        ol.interaction.Pointer.call(this, {
            handleDownEvent: app.Drag.prototype.handleDownEvent,
            handleDragEvent: app.Drag.prototype.handleDragEvent,
            handleMoveEvent: app.Drag.prototype.handleMoveEvent,
            handleUpEvent: app.Drag.prototype.handleUpEvent
        });
        this.coordinate_ = null;
        this.cursor_ = 'pointer';
        this.feature_ = null;
        this.previousCursor_ = undefined;
    };
    ol.inherits(app.Drag, ol.interaction.Pointer);

    app.Drag.prototype.handleDownEvent = function (evt) {
        var map = evt.map;
        var feature = map.forEachFeatureAtPixel(evt.pixel,
            function (feature) {
                return feature;
            });
        if (feature) {
            this.coordinate_ = evt.coordinate;
            this.feature_ = feature;
        }
        return !!feature;
    };

    app.Drag.prototype.handleDragEvent = function (evt) {
        var deltaX = evt.coordinate[0] - this.coordinate_[0];
        var deltaY = evt.coordinate[1] - this.coordinate_[1];

        var geometry = this.feature_.getGeometry();
        geometry.translate(deltaX, deltaY);
        this.coordinate_[0] = evt.coordinate[0];
        this.coordinate_[1] = evt.coordinate[1];

        if (poMapData.tStatus == '2') {
            var aDataLatLong = ol.proj.toLonLat(evt.coordinate); //-------------------------covert Pixel To LatLong
            JSxInsertValLatLong(aDataLatLong, poMapData); //------------------------- Function Inset Val Latitude and Longtitude To Input
        } else { }
    };

    app.Drag.prototype.handleMoveEvent = function (evt) {
        if (this.cursor_) {
            var map = evt.map;
            var feature = map.forEachFeatureAtPixel(evt.pixel,
                function (feature) {
                    return feature;
                });
            var element = evt.map.getTargetElement();
            if (feature) {
                if (element.style.cursor != this.cursor_) {
                    this.previousCursor_ = element.style.cursor;
                    element.style.cursor = this.cursor_;
                }
            } else if (this.previousCursor_ !== undefined) {
                element.style.cursor = this.previousCursor_;
                this.previousCursor_ = undefined;
            }
        }
    };

    app.Drag.prototype.handleUpEvent = function () {
        this.coordinate_ = null;
        this.feature_ = null;
        return false;
    };

    var pointFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([poMapData.cLongitude, poMapData.cLatitude])) //---------------------------Set Lat Lon Marker
    });

    var map = new ol.Map({
        interactions: ol.interaction.defaults().extend([new app.Drag()]),
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            }),
            new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [pointFeature]
                }),
                style: new ol.style.Style({

                    image: new ol.style.Icon( /** @type {olx.style.IconOptions} */({
                        anchor: [0.5, 46],
                        anchorXUnits: 'fraction',
                        anchorYUnits: 'pixels',
                        opacity: 0.95,
                        src: poMapData.tIcon //Patch Icon
                    })),
                    stroke: new ol.style.Stroke({
                        width: 3,
                        color: [255, 0, 0, 1]
                    }),
                    fill: new ol.style.Fill({
                        color: [0, 0, 255, 0.6]
                    })
                })
            })
        ],
        target: poMapData.tDivShowMap,
        view: new ol.View({
            center: ol.proj.fromLonLat([poMapData.cLongitude, poMapData.cLatitude]), //--------------------------------------Set Lat Lon Map
            zoom: 16
        })
    });

    function JSxInsertValLatLong(paDataLatLong, poMapData) {
        var cLongtitude = paDataLatLong[0];
        var cLatitude = paDataLatLong[1];
        $('#' + poMapData.tInputLat).val(cLatitude);
        $('#' + poMapData.tInputLong).val(cLongtitude);
    }
}


function FSxDecimal(element, decimals) {
    $(element).keypress(function (event) {
        num = $(this).val();
        num = isNaN(num) || num === '' || num === null ? 0.00 : num;
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($(this).val() == parseFloat(num).toFixed(decimals)) {
            event.preventDefault();
        }
    });
}



//function: function Set Modal Text In Msg Success
//Parameters: Text Message Return
//Creator: 23/01/2020 nale
//Return: View Alert success Massage
//Return Type: -
function FSvCMNSetMsgSucessDialog(tMsgBody) {
    $('#odvModalInfoMessage .modal-body ').html(tMsgBody);
    $('#odvModalInfoMessage').modal({ backdrop: 'static', keyboard: false })
    JCNxCloseLoading();
    $('#odvModalInfoMessage').modal({ show: true });
}


//function: function Set Modal Text In Msg Error
//Parameters: Text Message Return
//Creator: 15/11/2018 wasin
//Return: View Alert Error Massage
//Return Type: -
function FSvCMNSetMsgErrorDialog(tMsgBody) {
    $('#odvModalBodyError .modal-body ').html(tMsgBody);
    $('#odvModalError').modal({ backdrop: 'static', keyboard: false })
    JCNxCloseLoading();
    $('#odvModalError').modal({ show: true });
}


//function: function Set Modal Text In Msg Wanning
//Parameters: Text Message Return
//Creator: 15/11/2018 wasin
//Edit: 21/03/2019 Krit //เพิ่ม CallBack Function
//Return: View Alert Warning Massage
//Return Type: -
function FSvCMNSetMsgWarningDialog(tMsgBody, tFuntionName, tCode, tStaGp) {
    if(tStaGp == ''){tStaGp = null}
    $('#odvModalBodyWanning .modal-body ').html(tMsgBody);
    $("#odvModalWanning button.xCNBTNDefult2Btn.xWBtnCancel").hide();
    if (tFuntionName != undefined) {
        //     $('#odvModalBodyWanning .xWBtnOK').attr('onclick',tFuntionName+"('"+tCode+"')");
        if (tStaGp == null) {
            if( tCode != undefined ){
                tFuncParams = tFuntionName + "('" + tCode + "')";
            }else{
                tFuncParams = tFuntionName;
            }
            $('#odvModalBodyWanning .xWBtnOK').attr('onclick', tFuncParams);
        } else {
            if( tStaGp != undefined ){
                tFuncParams = tFuntionName + "('" + tStaGp + "')";
            }else{
                tFuncParams = tFuntionName;
            }
            $("#odvModalWanning button.xCNBTNDefult2Btn.xWBtnCancel").show();
            $('#odvModalBodyWanning .xWBtnOK').attr('onclick', tFuncParams);

        }

        $('#odvModalBodyWanning .xWBtnOK').click(function () {
            $('#odvModalBodyWanning .xWBtnOK').attr('onclick', '');
        });

        $('#odvModalWanning button.xCNBTNDefult2Btn.xWBtnCancel').click(function () {
            $('#odvModalBodyWanning .xWBtnOK').attr('onclick', '');
        });

        
    }

    $('#odvModalWanning').modal({ backdrop: 'static', keyboard: false });
    $('#odvModalWanning').modal({ show: true });

}

/**
 * Functionality : Show modal message
 * Parameters : ptMsgHeader, ptMsgBody, pcProgress(%), ptCloseButtonCallback is function name for after close button
 * Creator : 15/02/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSxCMNSetMsgInfoMessageDialog(ptMsgHeader, ptMsgBody, ptMsgButton, pcProgress, ptCloseButtonCallback) {
    $('#odvModalInfoMessage .modal-header span#ospHeader ').html(ptMsgHeader);

    if (typeof ptCloseButtonCallback == "undefined" || ptCloseButtonCallback == null) {
        $('#odvModalInfoMessage button').removeAttr('onclick');
    } else {
        $('#odvModalInfoMessage button').attr('onclick', ptCloseButtonCallback);
    }

    if (typeof ptMsgButton == "undefined" || ptMsgButton == null) {
        var tDefaultButtonLabel = $('#ohdCMNOK').val();
        $('#odvModalInfoMessage button').text(tDefaultButtonLabel);
    } else {
        $('#odvModalInfoMessage button').text(ptMsgButton);
    }

    if (typeof pcProgress == "undefined" || pcProgress == null) {
        $('#odvModalInfoMessage .modal-body #odvIdBar').hide();
        console.log('body: ', ptMsgBody);
        $('#odvModalInfoMessage .modal-body .xCNMessage').html(ptMsgBody);
        $('#odvModalInfoMessage').modal({ backdrop: 'static', keyboard: false });
        $('#odvModalInfoMessage').modal({ show: true });
    } else {
        $('#odvModalInfoMessage .modal-body #odvIdBar').show();
        $('#odvModalInfoMessage').modal({ backdrop: 'static', keyboard: false });
        $('#odvModalInfoMessage').modal({ show: true });
        // Init idbar instance create
        var oBar1 = new ldBar("#odvIdBar");
        // var bar2 = document.getElementById('odvIdBar').ldBar;
        oBar1.set(parseFloat(pcProgress));
    }

}

/**
* Functionality : Show or Hide Component
* Parameters : ptComponent is element on document(id or class or...),pbVisible is visible, ptEffect is effect name
* Creator : 10/05/2019 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCMNVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            switch (ptEffect) {
                case 'fadeIO': {
                    $(ptComponent).fadeOut(400, function () {
                        $(this).addClass('hidden xCNHide');
                    });
                    break;
                }
                case 'slideUD': {
                    $(ptComponent).slideUp(500, function () {
                        $(this).addClass('hidden xCNHide');
                    });
                    break;
                }
                default: {
                    $(ptComponent).addClass('hidden xCNHide');
                }
            }
        }
        if (pbVisible == true) {
            switch (ptEffect) {
                case 'fadeIO': {
                    $(ptComponent).removeClass('hidden xCNHide').hide().fadeIn(1000);
                    break;
                }
                case 'slideUD': {
                    $(ptComponent).removeClass('hidden xCNHide').hide().slideDown(500);
                    break;
                }
                default: {
                    $(ptComponent).removeClass('hidden xCNHide');
                    /*$(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                        $(this).removeClass('hidden fadeIn animated');
                    });*/
                }
            }
        }
    } catch (err) {
        console.log('JSxCMNVisibleComponent Error: ', err);
    }
}

/**
* Functionality : User login is level?
* Parameters : -
* Creator : 23/05/2019 piya
* Last Modified : -
* Return : User level (HQ=สำนักงานใหญ่, BCH=สาขา, SHP=ร้านค้า)
* Return Type : string
*/
function JStCMNUserLevel(){
    try{
        return $('#ohdUserLevel').val();
    }catch(err){
        console.log('JStCMNUserLevel Error: ', err);
    }
}

/**
* Functionality : เข้ารหัสค่าตัวแปรที่ส่งมาพร้อมกับค่า get ใน url
* Parameters : รูปแบบ array ค่าตัวแปรที่ส่งมาพร้อมกับค่า get ใน url
* Creator : 29/05/2019 Pap
* Last Modified : -
* Return : text ค่าที่ถูกเข้ารหัสแล้ว เป็นก้อนเดียวกัน
* Return Type : string
*/
function JCNtEnCodeUrlParameter(paParameter){
    /*
    ตัวอย่างค่าที่ต้องส่งมา ไม่จำกัดจำนวนเอเรย์
    [
        {"Lang":"1"},
        {"ComCode":"C0001"},
        {"BranchCode":"00342"},
        {"DocCode":"TM0034219000001"}
    ]
    */
    let tResult = "";
    let tRuleCompareUpper = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    let tRuleCompareLower = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    let tEnCodeParameter = "";
    for(let i = 0;i<paParameter.length;i++){
        //========================= frist encode
        let tKey;
        if(JSON.stringify(Object.keys( paParameter[i] )).indexOf("\"")!=-1 &&
           JSON.stringify(Object.keys( paParameter[i] )).indexOf("[")!=-1 &&
           JSON.stringify(Object.keys( paParameter[i] )).indexOf("]")!=-1){
            tKey = (JSON.stringify(Object.keys( paParameter[i] )).replace("[\"", "")).replace("\"]", "");
        }else{
            tKey = JSON.stringify(Object.keys( paParameter[i] ));
        }
        let tKeyChar = tKey.split('');
        let tVldFristKey = "";
        for(let j = 0;j<tKeyChar.length;j++){
            let letters = "^[a-zA-Z]+$";
            if(tKeyChar[j].match(letters)){
                if(tKeyChar[j]==tKeyChar[j].toUpperCase()){
                    let nDifLoop = 0;
                    for(let z = 0;z<tRuleCompareUpper.length;z++){
                        if(tKeyChar[j]==tRuleCompareUpper[z]){
                            if((z+2)>tRuleCompareUpper.length){
                                nDifLoop = (z+2)-tRuleCompareUpper.length;
                            }else{
                                nDifLoop = z+2;
                            }
                            break;
                        }
                    }
                    tKeyChar[j] = tRuleCompareUpper[nDifLoop];
                }else if(tKeyChar[j]==tKeyChar[j].toLowerCase()){
                    let nDifLoop = 0;
                    for(let z = 0;z<tRuleCompareLower.length;z++){
                        if(tKeyChar[j]==tRuleCompareLower[z]){
                            if((z+2)>tRuleCompareLower.length){
                                nDifLoop = (z+2)-tRuleCompareLower.length;
                            }else{
                                nDifLoop = z+2;
                            }
                            break;
                        }
                    }
                    tKeyChar[j] = tRuleCompareLower[nDifLoop];
                }
            }
            tVldFristKey += tKeyChar[j];
        }
        let tValue;
        if(JSON.stringify(Object.values( paParameter[i] )).indexOf("\"")!=-1 &&
           JSON.stringify(Object.values( paParameter[i] )).indexOf("[")!=-1 &&
           JSON.stringify(Object.values( paParameter[i] )).indexOf("]")!=-1){
            tValue = (JSON.stringify(Object.values( paParameter[i] )).replace("[\"", "")).replace("\"]", "");
        }else{
            tValue = JSON.stringify(Object.values( paParameter[i] ));
        }
        let tValueChar = tValue.split('');
        let tVldFristValue = "";
        for(let j = 0;j<tValueChar.length;j++){
            let letters = "^[a-zA-Z]+$";
            if(tValueChar[j].match(letters)){
                if(tValueChar[j]==tValueChar[j].toUpperCase()){
                    let nDifLoop = 0;
                    for(let z = 0;z<tRuleCompareUpper.length;z++){
                        if(tValueChar[j]==tRuleCompareUpper[z]){
                            if((z+2)>tRuleCompareUpper.length){
                                nDifLoop = (z+2)-tRuleCompareUpper.length;
                            }else{
                                nDifLoop = z+2;
                            }
                            break;
                        }
                    }
                    tValueChar[j] = tRuleCompareUpper[nDifLoop];
                }else if(tValueChar[j]==tValueChar[j].toLowerCase()){
                    let nDifLoop = 0;
                    for(let z = 0;z<tRuleCompareLower.length;z++){
                        if(tValueChar[j]==tRuleCompareLower[z]){
                            if((z+2)>tRuleCompareLower.length){
                                nDifLoop = (z+2)-tRuleCompareLower.length;
                            }else{
                                nDifLoop = z+2;
                            }
                            break;
                        }
                    }
                    tValueChar[j] = tRuleCompareLower[nDifLoop];
                }
            }
            tVldFristValue += tValueChar[j];
        }
        //========================= end frist encode
        //========================= secound encode
        tKey = tVldFristKey;
        tKeyChar = tKey.split('');
        let tVldSecoundKey = "";
        for(let j = 0;j<tKeyChar.length;j++){
            let letters = "^[a-zA-Z]+$";
            if(tKeyChar[j].match(letters)){
                if(tKeyChar[j]==tKeyChar[j].toUpperCase()){
                    let nDifLoop = 0;
                    for(let z = 0;z<tRuleCompareUpper.length;z++){
                        if(tKeyChar[j]==tRuleCompareUpper[z]){
                            if((z-5)<0){
                                nDifLoop = (z-5)+tRuleCompareUpper.length;
                            }else{
                                nDifLoop = z-5;
                            }
                            break;
                        }
                    }
                    tKeyChar[j] = tRuleCompareUpper[nDifLoop];
                }else if(tKeyChar[j]==tKeyChar[j].toLowerCase()){
                    let nDifLoop = 0;
                    for(let z = 0;z<tRuleCompareLower.length;z++){
                        if(tKeyChar[j]==tRuleCompareLower[z]){
                            if((z-5)<0){
                                nDifLoop = (z-5)+tRuleCompareLower.length;
                            }else{
                                nDifLoop = z-5;
                            }
                            break;
                        }
                    }
                    tKeyChar[j] = tRuleCompareLower[nDifLoop];
                }
            }
            tVldSecoundKey += tKeyChar[j];
        }
        tValue = tVldFristValue;
        tValueChar = tValue.split('');
        let tVldSecoundValue = "";
        for(let j = 0;j<tValueChar.length;j++){
            let letters = "^[a-zA-Z]+$";
            if(tValueChar[j].match(letters)){
                if(tValueChar[j]==tValueChar[j].toUpperCase()){
                    let nDifLoop = 0;
                    for(let z = 0;z<tRuleCompareUpper.length;z++){
                        if(tValueChar[j]==tRuleCompareUpper[z]){
                            if((z-5)<0){
                                nDifLoop = (z-5)+tRuleCompareUpper.length;
                            }else{
                                nDifLoop = z-5;
                            }
                            break;
                        }
                    }
                    tValueChar[j] = tRuleCompareUpper[nDifLoop];
                }else if(tValueChar[j]==tValueChar[j].toLowerCase()){
                    let nDifLoop = 0;
                    for(let z = 0;z<tRuleCompareLower.length;z++){
                        if(tValueChar[j]==tRuleCompareLower[z]){
                            if((z-5)<0){
                                nDifLoop = (z-5)+tRuleCompareLower.length;
                            }else{
                                nDifLoop = z-5;
                            }
                            break;
                        }
                    }
                    tValueChar[j] = tRuleCompareLower[nDifLoop];
                }
            }
            tVldSecoundValue += tValueChar[j];
        }
        //========================= end secound encode
        if(i==0){
            tEnCodeParameter += tVldSecoundKey+"="+tVldSecoundValue;
        }else{
            tEnCodeParameter += "&"+tVldSecoundKey+"="+tVldSecoundValue;
        }
    }
    //==================== third encode
    return btoa(tEnCodeParameter);
    //==================== end third encode
}

/**
* Functionality : เปลี่ยนรูปแบบ Edit inline ใหม่
* Parameters : ค่า next function and parameter
* Creator : 18/06/2019 Pap
* Last Modified : -
* Return : text -
* Return Type : -
*/
//================================== in call function
// example set parameter : let oParameterSend =  {
//                                                  "FunctionName" : "JSnSaveDTEdit",
//                                                  "DataAttribute" : [],
//                                                  "TableID" : "otbDOCPdtTable",
//                                                  "NotFoundDataRowClass" : "xWTextNotfoundDataTablePdt",
//                                                  "EditInLineButtonDeleteClass" : "xWDeleteBtnEditButton",
//                                                  "LabelShowDataClass" : "xWShowInLine",
//                                                  "DivHiddenDataEditClass" : "xWEditInLine"
//                                               };
// JCNxSetNewEditInline(oParameterSend);
// $(".xWEditInlineElement").eq(nIndexInputEditInline).focus(function(){
//     this.select();
// });
// $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
// $(".xWEditInlineElement").removeAttr("disabled");
//================================== end in call function
var nIndexInputEditInline = 0;
function JCNxSetNewEditInline(poParameter){
    //========= delete edit inline btn
    var odvEditInlineBtn = $("#"+poParameter.TableID+" tr th."+poParameter.EditInLineButtonDeleteClass);
    var nOdvEditInlineBtnIndex = $("#"+poParameter.TableID+" tr th").index(odvEditInlineBtn);
    $($("#"+poParameter.TableID+" tr th").eq(nOdvEditInlineBtnIndex)).remove();
    if($("#"+poParameter.TableID+" tbody tr td."+poParameter.NotFoundDataRowClass).length==0){
        for(var nI = 0;nI < $("#"+poParameter.TableID+" tbody tr").length;nI++){
            let aOtdPdtTable = $("#"+poParameter.TableID+" tbody tr").eq(nI).children();
            $($(aOtdPdtTable).eq(nOdvEditInlineBtnIndex)).remove();
        }
    }
    //========= end delete edit inline btn
    if($("#"+poParameter.TableID+" tbody ."+poParameter.NotFoundDataRowClass).length==0){
        var aDOCPdtTableTRChild = $("#"+poParameter.TableID+" tbody").children();
        for(var nI = 0;nI < aDOCPdtTableTRChild.length;nI++){
            var aDOCPdtTableTDChild = $($(aDOCPdtTableTRChild).eq(nI)).children();
            for(var nJ = 0;nJ < aDOCPdtTableTDChild.length;nJ++){
                if($(aDOCPdtTableTDChild.eq(nJ)).children().length==2){
                    let aDOCPdtTableTDChildElement;
                    if($($(aDOCPdtTableTDChild.eq(nJ)).children().eq(0)).attr("class").indexOf(""+poParameter.LabelShowDataClass)!=-1){
                        aDOCPdtTableTDChildElement = $($(aDOCPdtTableTDChild.eq(nJ)).children().eq(0));
                    }else if($($(aDOCPdtTableTDChild.eq(nJ)).children().eq(1)).attr("class").indexOf(""+poParameter.LabelShowDataClass)!=-1){
                        aDOCPdtTableTDChildElement = $($(aDOCPdtTableTDChild.eq(nJ)).children().eq(1));
                    }
                    aDOCPdtTableTDChildElement.addClass("xWEditInlineElement");
                    $($(aDOCPdtTableTDChildElement).parent()).attr("style","border : 0px !important;position:relative;");

                    $(aDOCPdtTableTDChildElement).addClass("field__input a-field__input");
                    var tNewInputReplace = "<input value='"+$(aDOCPdtTableTDChildElement).text().trim()+"' type='text' class='"+$(aDOCPdtTableTDChildElement).attr("class")+"'";
                    for(let nI = 0;nI<poParameter.DataAttribute.length;nI++){
                        let aDOCPdtTableTDChildElementAttr = $(aDOCPdtTableTDChildElement).attr(poParameter.DataAttribute[nI]);
                        if(aDOCPdtTableTDChildElementAttr!==undefined && aDOCPdtTableTDChildElementAttr!=""){
                            tNewInputReplace += " "+poParameter.DataAttribute[nI]+"=\""+aDOCPdtTableTDChildElementAttr+"\"";
                        }
                    }
                    tNewInputReplace += ">";
                    $(aDOCPdtTableTDChildElement).parent().append(tNewInputReplace);
                    $(aDOCPdtTableTDChildElement).remove();
                    if($($(aDOCPdtTableTDChild.eq(nJ)).children().eq(0)).attr("class").indexOf(""+poParameter.LabelShowDataClass)!=-1){
                        aDOCPdtTableTDChildElement = $($(aDOCPdtTableTDChild.eq(nJ)).children().eq(0));
                    }else if($($(aDOCPdtTableTDChild.eq(nJ)).children().eq(1)).attr("class").indexOf(""+poParameter.LabelShowDataClass)!=-1){
                        aDOCPdtTableTDChildElement = $($(aDOCPdtTableTDChild.eq(nJ)).children().eq(1));
                    }
                    $(aDOCPdtTableTDChildElement).attr("style","background:#F9F9F9;border-top: 0px !important;border-left: 0px !important;border-right: 0px !important;box-shadow: inset 0 0px 0px; min-width:100px;text-align:right;");
                    $(aDOCPdtTableTDChildElement).unbind("keydown focusout");
                    $(aDOCPdtTableTDChildElement).bind("keydown focusout",function(e){
                        let nKeyCode = e.keyCode || e.which;
                        let bCheckeyEvent = false;
                        let nIndexElement = $(".xWEditInlineElement").index(this);
                        if(e.type=="keydown"){
                            if(nKeyCode === 13){
                                e.preventDefault();
                                if(nIndexElement!=$(".xWEditInlineElement").length){
                                    nIndexInputEditInline = nIndexElement+1;
                                }else{
                                    nIndexInputEditInline = 0;
                                }
                                bCheckeyEvent = true;
                            }
                        }else if(e.type=="focusout"){
                            bCheckeyEvent = true;
                        }
                        if(bCheckeyEvent){
                            //============== set label value to input value
                            let oOdvInputElemen;
                            if($($(this).parent().children().eq(0)).attr("class").indexOf(""+poParameter.DivHiddenDataEditClass)!=-1){
                                oOdvInputElement = $($(this).parent().children().eq(0));
                            }else if($($(this).parent().children().eq(1)).attr("class").indexOf(""+poParameter.DivHiddenDataEditClass)!=-1){
                                oOdvInputElement = $($(this).parent().children().eq(1));
                            }
                            // input tag value
                            let oOhdTextInput = $(oOdvInputElement).children().eq(0);
                            let oOhdTextInputValue = $(oOhdTextInput).val();
                            let oElementValue = $(this).val();
                            let bCheckIsNumber = false;
                            if((oOhdTextInputValue.match(/^-{0,1}\d+$/)
                                                                    ||
                               oOhdTextInputValue.match(/^\d+\.\d+$/)
                                                                    ||
                               oOhdTextInputValue.match(/^\d{0,10}(\.\d{1,2})?$/))
                                                                    &&
                               (oElementValue.match(/^-{0,1}\d+$/)
                                                                 ||
                                oElementValue.match(/^\d+\.\d+$/)
                                                                ||
                                oElementValue.match(/^\d{0,10}(\.\d{1,2})?$/))
                            ){
                                bCheckIsNumber = true;
                            }else{
                                bCheckIsNumber = false;
                            }
                            let bCheckCompare = false;
                            if(bCheckIsNumber){
                                if(parseFloat(oOhdTextInputValue)!=parseFloat(oElementValue)){
                                    bCheckCompare = true;
                                }
                            }else{
                                if(oOhdTextInputValue!=oElementValue){
                                    bCheckCompare = true;
                                }
                            }
                            if(bCheckCompare){
                                $(oOhdTextInput).val($(this).val());
                                if(poParameter.FunctionName!=""){
                                    let oLoaddingHtml = "<div>";
                                    oLoaddingHtml     += "   <img style=\"width:20px;height:20px;position:absolute;left: 50%;transform: translate(-40%, 0);\" src=\""+$("#ohdBaseUrlUseInJS").val()+"application/modules/common/assets/images/ada.loading.gif\" class=\"xWImgLoading xWEditInlineLoadding\">";
                                    oLoaddingHtml     += "</div>";
                                    $($(this).parent()).children().addClass("hidden");
                                    $($(this).parent()).append(oLoaddingHtml);

                                    $(".xWEditInlineElement").attr("disabled","disabled");
                                    let oParameters = {};
                                    oParameters.VeluesInline = $(oOhdTextInput).val();
                                    oParameters.Element = $(oOhdTextInput);
                                    oParameters.DataAttribute = [];
                                    for(let nI = 0;nI<poParameter.DataAttribute.length;nI++){
                                        let aDOCPdtTableTDChildElementAttr = $(this).attr(poParameter.DataAttribute[nI]);
                                        if(aDOCPdtTableTDChildElementAttr!==undefined && aDOCPdtTableTDChildElementAttr!=""){
                                            oParameters.DataAttribute[nI] = {[poParameter.DataAttribute[nI]]:$(this).attr(poParameter.DataAttribute[nI])};
                                        }
                                    }
                                    // let bCheckUpdate = false;
                                    // let oOtdChildren = $($(oOhdTextInput).parent()).children();
                                    // let oOldInput;
                                    // if($($(oOtdChildren).eq(1)).prop("tagName")=="DIV")){
                                    //     oOldInput = $($(oOtdChildren).eq(1)).find("input");
                                    // }else{
                                    //     oOldInput = $($(oOtdChildren).eq(0)).find("input");
                                    // }
                                    // if($(oOldInput).val()!=$(oOhdTextInput).val()){
                                        window[poParameter.FunctionName](oParameters);
                                    //}
                                }
                            }else{
                                if(e.type=="keydown"){
                                    $(".xWEditInlineElement").eq(nIndexInputEditInline).focus(function(){
                                        setTimeout(function() {
                                            this.select();
                                        }, 500);
                                    });
                                    $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
                                }
                            }
                        }
                    });
                }
            }
        }
    }
}

// function : Function Show Event Error
// Parameters : Error Ajax Function
// Creator : 04/07/2018 Krit
// Return : Modal Status Error
// Return Type : view
function JCNxResponseError(jqXHR, textStatus, errorThrown) {
    JCNxCloseLoading();
    var tHtmlError      = $(jqXHR.responseText);
    var tMsgErrorBody   = '';
    var tMsgErrorHeader = "<h3 style='font-size:20px;color:red'>";
    tMsgErrorHeader     += "<i class='fa fa-exclamation-triangle'></i>";
    tMsgErrorHeader     += " Error</h3>";
    switch (jqXHR.status) {
        case 404:
            tMsgErrorBody += tHtmlError.find('p:nth-child(2)').text();
            break;
        case 500:
            tMsgErrorBody += tHtmlError.find('p:nth-child(3)').text();
            break;
        default:
            tMsgErrorBody += 'something had error. please contact admin';
            break;
    }
    FSvCMNSetMsgErrorDialog(tMsgErrorBody);
}

// ฟังก์ชั่นสำหรับเปลี่ยนภาษา ไว้เพิ่มข้อมูล supawat 08/01/2020
function JSxSwitchLang(ptTableMaster){
    $.ajax({
        type    : "POST",
        url     : 'SwitchLang',
        cache   : false,
        data    : {
            ptTableMaster : ptTableMaster
        },
        success: function (tResult) {
            //console.log(tResult);
            $('.xCNContentlSwitchLang').html(tResult);
            $('#odvModalSwitchLang').modal({ show: true });
        },
        timeout: 3000,
        error: function (data) {
            console.log(data);
        }
    });

}

function JCNxInsertLangOtherByMaster(ptPK){
    var JsonString = JSON.stringify(aPackDataLang);
    $.ajax({
        type    : "POST",
        url     : 'InsertSwitchLang',
        cache   : false,
        data    : {
            tPK           : ptPK,
            aPackDataLang : JsonString
        },
        success: function (tResult) {
            console.log(tResult);
            // aPackDataLang = [];
        },
        timeout: 3000,
        error: function (data) {
            console.log(data);
        }
    });
}

// เอาปุ่ม Favorite ออก
function JSxFavDel(pnDelCode){
    var nCode = pnDelCode;
    $.ajax({
        url: 'favoritedel',
        type: 'POST',
        data: {nCode: nCode},//ส่งค่าไปยังcontrol key:value
        error: function() {

        },
        timeout: 3000,
        success: function(result) {//control ส่งค่ากลับมา
        // location.reload();
        JSxFavCallback();

        }
    });
}

// กดปุ่ม Favorite
function JSxFavCallback(pnFavCalback){
    $.ajax({
        url: 'favorite/0/0',
        type: "POST",
        success: function (tView) {
            $(window).scrollTop(0);
            $('.odvMainContent').html(tView);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxCloseLoading();
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        },
    });
}

// ฟังก์ชั่น เพิ่มเมนูโปรด ไว้เพิ่มข้อมูล Witsarut 08/01/2020
function JSxAddfavorit(ptRoutefavorit){
    $.ajax({
        type: "POST",
        url: "CallModalOptionFavorite",
        data: {'ptRoutefavorit':ptRoutefavorit},
        timeout: 0,
        cache:false,
        success: function (tViewModalRes) {
            $('#odvAddForiteAppendDiv').html(tViewModalRes);
            // $('#odvModalFavName').modal({backdrop: 'static', keyboard: false})
            $('#odvModalFavName').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR,textStatus,errorThrown);
        }
    });
}

// ฟังก์ชัน Getdata modal Popup
// Create By Witsarut 3/2/2020
function JSoGetDataFavarite(ptTypeEvent){
    $.ajax({
        type: "POST",
        url: "GetDatafavname",
        dataType : "json",
        cache : false,
        data : $('#ofmAddFovriteForm').serialize()+"&ptTypeEvent="+ptTypeEvent,
        success: function (tResult){
            $('#odvModalFavName').modal('hide');
            if(ptTypeEvent == 'cancel'){
                $('#oimImgFavicon').addClass('xCNDisabled');
                $('#oimImgFavicon').addClass('xWImgDisable');
            }else{
                $('#oimImgFavicon').removeClass('xCNDisabled');
                $('#oimImgFavicon').removeClass('xWImgDisable');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

//ฟังก์ชันอ่านข้อความที่ค้างไว้
function JSoGetDataNotification(){
    $.ajax({
        type    : "POST",
        url     : "GetDataNotification",
        cache   : false,
        success: function(tResult){
            var aResult = JSON.parse(tResult);
            if(aResult['nStaEvent'] == 900){
                //ไม่พบข้อมูล
            }else if(aResult['nStaEvent'] == 1){
                //ต้องเพิ่ม append เข้าไปใน List ใหม่
                var nCountTotal     = aResult.aData.length;
                var aItem           = aResult.aData;
                var tCountMSGAll    = 0;
                // console.log('COUNT : ' + nCountTotal);

                for(var i=0; i<nCountTotal; i++){
                    var tItem       = aItem[i].FTNtiContents;
                    var tTopic      = aItem[i].FTNtiTopic;
                    var tDateTime   = aItem[i].FDNtiSendDate
                    var aMsg        = JSON.parse(tItem);
                    tCountMSGAll    = tCountMSGAll + aMsg.length;
                    //จำนวนข้อความที่ได้รับ
                    $('#odvCntMessage').text(tCountMSGAll);

                    for(var k=0; k<aMsg.length; k++){
                        var tTopic      = tTopic;
                        var tDataTime   = tDateTime;
                        var tWah        = aMsg[k].ptFTSubTopic;
                        var tMsg        = aMsg[k].ptFTMsg;
                        var tHTML = "<div class='xCNBlockNoti'>";
                        tHTML += "<label style='font-weight: bold; font-style: italic;'>"+tTopic+"</label><label>" + '&nbsp; (' + tDataTime + ')' + "</label>";
                        tHTML += "<p>คลังสินค้า : "+tWah+"</p>";
                        tHTML += "<p>ข้อความ : "+tMsg+"</p>";
                        tHTML += "</div>";
                        $('#odvMessageShow').prepend(tHTML);
                    }
                }
            }
        },
        error: function (data) {
             console.log(data);
        }
    });

}

//ฟังก์ชันกดว่าข้อความอ่านแล้ว
function JSxEventClickNotiRead(){
    // JSxEventClickDelClass();
    $.ajax({
        type    : "POST",
        url     : "GetDataNotificationRead",
        data    : "json",
        cache   : false,
        success: function (tResult){
            numCount = 0;
            // หาำจำนวน content ว่ามีกี่้ Content แล้วไป Add Class Remove
            $('.xCNWillingRemove').remove();
            var nCountTotal  = $('.xCNBlockNoti').length;
            for(var i=0; i<nCountTotal; i++){
                $('.xCNBlockNoti').addClass('xCNWillingRemove')
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

// เมื่อ Click ที่ Body แล้วไปดู message เก่าจะหายไป
$('body').click(function(){
    if($('#odvNotiMessageAlert').css('display') == 'none'){ //จะเช็คทุกครั้งเมื่อ panel ปิด
        $('.xCNWillingRemove').remove();
    }
});

//Functionality : โนติ
//Parameters : -
//Creator : 15/11/2021 Nale
//Return : Status,Message
//Return Type : String
function JCNxNTFCallPrcNotifocation(){
    // JSxEventClickDelClass();
    $.ajax({
        type    : "POST",
        url     : "mntCallNotification",
        data    : {
                    tNTFUsrCode : '',
                    tNTFAgnCode : '',
                    tNTFBchCode : '',
                    tNTFNotCode : '',
                    tNTFLstLogin : '',
                    tNTFLngID   : ''
        },
        cache   : false,
        success: function (tResult){
            localStorage.setItem("LocalNumSubMassageNoti",0);
            JCNxNTFSubMassageNotifocation();
        },
        error: function (data) {
            console.log(data);
        }
    });
}


//Functionality : โนติ
//Parameters : -
//Creator : 15/11/2021 Nale
//Return : Status,Message
//Return Type : String
$('.xCNMenuItem').click(function(){
    var tSesAlwNoti = $('#ohdSesAlwNoti').val();
    var tSesAlwNews = $('#ohdSesAlwNews').val();
    if( tSesAlwNoti == '1' || tSesAlwNews == '1' ){
        JCNxNTFCallPrcNotifocation();
    }
});
//Functionality : โนติ
//Parameters : -
//Creator : 15/11/2021 Nale
//Return : Status,Message
//Return Type : String
function JCNxNTFSubMassageNotifocation(pnNum){
    // JSxEventClickDelClass();
    $.ajax({
        type    : "POST",
        url     : "mntSubDataNotification",
        data    : {
                    tNTFUsrCode : '',
                    tNTFAgnCode : '',
                    tNTFBchCode : '',
                    tNTFNotCode : '',
                    tNTFLstLogin : '',
                    tNTFLngID   : ''
        },
        cache   : false,
        success: function (tResult){
            if(tResult.trim()!=''){
                JCNxNTFGetDataNotifocation();
            }else{
                var LocalNumSubMassageNoti = parseInt(localStorage.getItem("LocalNumSubMassageNoti"))+1;
                if(LocalNumSubMassageNoti<=30){
                    // console.log(LocalNumSubMassageNoti);
                    localStorage.setItem("LocalNumSubMassageNoti",LocalNumSubMassageNoti);
                    JCNxNTFSubMassageNotifocation(LocalNumSubMassageNoti);
                }else{
                    JCNxNTFGetDataNotifocation();
                }
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}
//Functionality : โนติ
//Parameters : -
//Creator : 15/11/2021 Nale
//Return : Status,Message
//Return Type : String
function JCNxNTFGetDataNotifocation(){
    // JSxEventClickDelClass();
    $.ajax({
        type    : "POST",
        url     : "mntGetDataNotification",
        data    : {
                    tNTFUsrCode : '',
                    tNTFAgnCode : '',
                    tNTFBchCode : '',
                    tNTFNotCode : '',
        },
        cache   : false,
        success: function (tResult){
            var aResult = JSON.parse(tResult);
            $('#odvNTFContent').html(aResult.tHTMLNotiDoc);
            if(aResult.nSizeOffNotiDoc!=0){
            $('#ospNTFQty').text(aResult.nSizeOffNotiDoc);
            $('#ospNTFQty').css('display','');
            }else{
            $('#ospNTFQty').css('display','none');
            }

            $('#odvNEWContent').html(aResult.tHTMLNotiNews);
            if(aResult.nSizeOffNotiNews!=0){
            $('#ospNEWQty').text(aResult.nSizeOffNotiNews);
            $('#ospNEWQty').css('display','');
            }else{
            $('#ospNEWQty').css('display','none');
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}



//Functionality : โนติ
//Parameters : -
//Creator : 15/11/2021 Nale
//Return : Status,Message
//Return Type : String
function JCNxNTFJumpDocPageEdit(ptDocumentRef,tRoute,ptAgnCode,ptBchCode){

    $.ajax({
        type    : "POST",
        url     : tRoute,
        data    : {
                    tDocNo : ptDocumentRef,
                    tBchCode : ptBchCode,
                    tAgnCode : ptAgnCode
        },
        cache   : false,
        timeout : 5000,
        success : function (tResult) {
            $(window).scrollTop(0);
            $('.odvMainContent').html(tResult);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : โนติ
//Parameters : -
//Creator : 15/11/2021 Nale
//Return : Status,Message
//Return Type : String
function JCNxNFTReadNotID(ptNotID,pnNotiType){
    // JSxEventClickDelClass();
    $.ajax({
        type    : "POST",
        url     : "mntReadNotification",
        data    : {
                    tNTFNotID : ptNotID,
                    pnNotiType : pnNotiType,
        },
        cache   : false,
        success: function (tResult){
            JCNxNTFGetDataNotifocation();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

//Functionality : โนติ
//Parameters : -
//Creator : 15/11/2021 Nale
//Return : Status,Message
//Return Type : String
function JCNxNTFPopUpNew(e){
  var tNewTitle =  $(e).data('desc1');
  var tNewDesc  =  $(e).data('desc2');
  var dNewDate  =  $(e).data('date');
  $('#ospMntTextDesc1').text(tNewTitle);
  $('#ospMntTextDesc2').text(tNewDesc);
  $('#ospMntTextDate').text(dNewDate);
  $('#odvMntModalNotiNews').modal({backdrop:'static',keyboard:false});
  $("#odvMntModalNotiNews").modal("show");
}

//Functionality : เปิดโนติ url
//Parameters : -
//Creator : 15/11/2021 Nale
//Return : Status,Message
//Return Type : String
function JCNxNTFOpenUrl(ptUrl){
    window.open(ptUrl, '_blank');
}


//Functionality : เมื่อกดเลือกทั้งหมดให้ติ๊ก checkBox ทั้งหมด
//Parameters : -
//Creator : 15/11/2021 Nale
//Return : Status,Message
//Return Type : String
$(document).on('click', '.ocmCENCheckDeleteAll', function(e) {
// $(document).on('click', 'input[class="ocmCENCheckDeleteAll"]', function(e) {
    // console.log($(e.target).attr('id'));
    var nStaClick = $(e.target).is(':checked');
    // console.log(nStaClick);
    JCNxClickCheckBox(nStaClick);
    // var LocalItemData = localStorage.getItem("LocalItemData");
    // console.log(LocalItemData);
});

//Functionality : เมื่อกดเลือกทั้งหมดให้ติ๊ก checkBox ทั้งหมด
//Parameters : -
//Creator : 15/11/2021 Nale
//Last Update : 29/11/2021 Napat(Jame)
//Return : Status,Message
//Return Type : String
function JCNxClickCheckBox(pnStaClick){

    $('.ocbListItem').each(function(){
        if( pnStaClick ){                                       // กรณีติ๊กถูก
            if( !$(this).is(':checked') ){                      // ตรวจสอบ checkbox ในหน้าจอ จะติ๊กเฉพาะที่ยังไม่ถูกติ๊ก (ปล.checkbox ที่ถูกติ๊กก่อนหน้าที่จะกด checkall จะไม่ถูกติ๊กซ้ำ)
                $(this).trigger("click");
            }
        }else{                                                  // กรณียกเลิกติ๊กถูก
            if( $(this).is(':checked') ){                       // ตรวจสอบ checkbox ในหน้าจอ จะติ๊กเฉพาะที่ถูกติ๊กไว้ก่อนหน้าเท่านั้น
                $(this).trigger("click");
            }
        }
    });
}

$(document).on('click', '.ocbListItem', function(e) {
    var nID = $(this).data("checkrowid");
    if ($(this).data("checkrow")==true) {
        $("#otdDel"+nID).removeClass("xWTdDisable");
        if ($("#ocmCENCheckDeleteAll").prop("checked")==true) {
          $("#otdDel"+nID).addClass("xWTdDisable");
          $("#oimDel"+nID).addClass("xWImgDisable");
        }else {
          $("#otdDel"+nID).removeClass("xWTdDisable");
          $("#oimDel"+nID).removeClass("xWImgDisable");
        }
    }else if ($(this).data("checkrow")==false) {
        if ($("#ocmCENCheckDeleteAll").prop("checked")==true) {
          $("#otdDel"+nID).addClass("xWTdDisable");
          $("#oimDel"+nID).addClass("xWImgDisable");
        }else {
          $("#otdDel"+nID).removeClass("xWTdDisable");
          $("#oimDel"+nID).removeClass("xWImgDisable");
        }
    }else {

    }
    var nBtnTarget = $(e.target).is(':checked');
    var nBtnChkDelAll = $('#ocmCENCheckDeleteAll').is(':checked');
    // console.log('nBtnTarget: '+nBtnTarget);
    // console.log('nBtnChkDelAll: '+nBtnChkDelAll);
    if( !nBtnTarget ){
        if( nBtnChkDelAll ){
            $('#ocmCENCheckDeleteAll').prop( "checked", false );
        }
    }
    // var LocalItemData = localStorage.getItem("LocalItemData");
    // console.log(LocalItemData);
});

// Create By: Napat(Jame) 22/06/2022
// var aParams = {
//     'tBchCode'  : 'สาขาที่ต้องการตรวจสอบสต๊อก',
//     'tWahCode'  : 'คลังที่ต้องการตรวจสอบสต๊อก',
//     'tDocNo'    : 'รหัสเอกสารที่ต้องการอนุมัติ',
//     'tTableHD'  : 'TCNTPdtTboHD'
//     'tTableDT'  : 'TCNTPdtTboDT'
// };
async function JCNaChkStkB4ApvDoc(paParams){
    JCNxOpenLoading();
    // console.log(paParams);

    return new Promise(resolve => {
        $.ajax({
            type: "POST",
            url: "cenEventChkStkB4ApvDoc",
            data: {
                paParams : paParams
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aResult = JSON.parse(oResult);

                // แสดง Dialog
                if( aResult['nStaEvent'] == 1 ){
                    var bStaShwBtnConfirm = true;
                    var tNextFunc = paParams['tNextFunc'];

                    $('#obtConfirmChkStkB4ApvDoc').removeAttr("onclick");
                    $('#odvModalChkStkB4ApvDoc .modal-body #odvSection1').html('');
                    $('#odvModalChkStkB4ApvDoc .modal-body #odvSection2').html('');

                    // เอกสารรออนุมัติ
                    if( aResult['aSection1']['nStaEvent'] == 1 ){
                        $('#odvModalChkStkB4ApvDoc .modal-body #odvSection1').html(aResult['aSection1']['tHtmlRender']);
                    }

                    // สินค้าต้องทำใบรับเข้า
                    if( aResult['aSection2']['nStaEvent'] == 1 ){
                        bStaShwBtnConfirm = false;
                        $('#odvModalChkStkB4ApvDoc .modal-body #odvSection2').html(aResult['aSection2']['tHtmlRender']);
                    }

                    if( bStaShwBtnConfirm ){
                        $('#obtConfirmChkStkB4ApvDoc').attr('onclick', tNextFunc+'(false)').show();
                    }else{
                        $('#obtConfirmChkStkB4ApvDoc').hide();
                    }

                    $('#odvModalChkStkB4ApvDoc').modal('show');
                }

                JCNxCloseLoading();
                resolve(aResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });

}