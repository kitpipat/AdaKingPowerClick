// ข้อมูลหน้า ก่อนหน้า
function JSxTTBPreviousPage() {
    var nCurrentPage = $('#ospPageTTBActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageTTBActive').text(nPreviousPage);
    JSxTTBListView();
}
// ข้อมูลหน้า หน้าถัดไป
function JSxTTBForwardPage() {
    var nCurrentPage = $('#ospPageTTBActive').text();
    var nTotalPage = $('#ospTotalTTBPage').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageTTBActive').text(nForwardPage);
    JSxTTBListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageTTBActive').text(tNumPage);
    JSxTTBListView();
}
function JSxTTBListView() {
    var oetFTTmhName = $('#oetFTTmhName').val();
    var nPageNo = $('#ospPageTTBActive').text();
    $('.icon-loading').show();
    $.ajax({
        type: "POST",
        url: "EticketTimeTable/TimeTableAjaxList",
        data: {
            tFTTmhName: oetFTTmhName,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
            $('#oResultTTB').html(msg);
            var ospPageTTBActive = $('#ospPageTTBActive').text();
            var ospTotalTTBPage = $('#ospTotalTTBPage').text();
            var tHtml = '';

            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxTTBPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalTTBPage); i++) {
                l = i + 1;
                if (parseInt(ospPageTTBActive) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxTTBForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageTTBActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageTTBActive == ospTotalTTBPage) {
                $('#oForwardPage').attr('disabled',true);
            } else {
                $('#oForwardPage').attr('disabled',false);
            }
            JSxCheckPinMenuClose();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxTTBCount() {
    var oetFTTmhName = $('#oetFTTmhName').val();
    $.ajax({
        type: "POST",
        url: "EticketTimeTable/TimeTableCount",
        data: {
            tFTTmhName: oetFTTmhName,
        },
        cache: false,
        success: function (msg) {
            $('#ospTotalTTBRecord').text(msg);
            $('#ospPageTTBActive').text('1');
            $('#ospTotalTTBPage').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxTTBListView();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxTTBHDel(nFNTmhID, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + $(tMsg).data('name'),
        buttons: {
            cancel: {
                label: aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            },
            confirm: {
                label: aLocale['tBtnClose'],
                className: 'xCNBTNDefult'
            }
        },
        callback: function (result) {
            if (result == false) {
                $.ajax({
                    type: "post",
                    url: "EticketTimeTable/DeleteTimeTable",
                    data: {
                        nFNTmhID: nFNTmhID
                    },
                    cache: false,
                    success: function (oData) {
                        oBj = JSON.parse(oData);
                        if (oBj.count == 1) {
                            alert(oBj.msg);
                        } else {
                            JSxTTBCount();
                        }
                    },
                    error: function (tError) {
                        console.log(tError);
                    }
                });
            }
        }
    });
}

function FSxDelAllOnCheckHD() {
    var ocbListItem = [];
    var ocbListName = [];
    $('.ocbListItem:checked').each(function (i, e) {
        ocbListName.push($(this).data('name'));
    });

    $('.ocbListItem:checked').each(function (i, e) {
        ocbListItem.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "EticketTimeTable/DeleteTimeTable",
        data: {
            'nFNTmhID': ocbListItem.join()
        },
        cache: false,
        success: function (msg) {
            console.log(msg);
            console.log(ocbListItem.join());
            JSxTTBCount();
            $('.modal-backdrop').remove(); 
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        },
        error: function (data) {
            console.log(data);
        }
    });

}
// ข้อมูลหน้า ก่อนหน้า
function JSxTTBDTPreviousPage() {
    var nCurrentPage = $('#ospPageTTBDTActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageTTBDTActive').text(nPreviousPage);
    JSxTTBDTListView();
}
// ข้อมูลหน้า หน้าถัดไป
function JSxTTBDTForwardPage() {
    var nCurrentPage = $('#ospPageTTBDTActive').text();
    var nTotalPage = $('#ospTotalTTBDTPage').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageTTBDTActive').text(nForwardPage);
    JSxTTBDTListView();
}
function JSvPDTClickPage(tNumPage) {
    $('#ospPageTTBDTActive').text(tNumPage);
    JSxTTBDTListView();
}
function JSxTTBDTListView() {
    var oetFTTmdName = $('#oetFTTmdName').val();
    var ohdFNTmhID = $('#ohdFNTmhID').val();
    var nPageNo = $('#ospPageTTBDTActive').text();
    $.ajax({
        type: "POST",
        url: "EticketTimeTable/TimeTableDTAjaxList",
        data: {
            tFTTmdName: oetFTTmdName,
            nFNTmhID: ohdFNTmhID,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
            $('#oResultTTBDT').html(msg);
            var ospPageTTBDTActive = $('#ospPageTTBDTActive').text();
            var ospTotalTTBDTPage = $('#ospTotalTTBDTPage').text();
            var tHtml = '';

            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxTTBDTPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalTTBDTPage); i++) {
                l = i + 1;
                if (parseInt(ospPageTTBDTActive) == l) {
                    tHtml += '<button onclick="JSvPDTClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPDTClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxTTBDTForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageTTBDTActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageTTBDTActive == ospTotalTTBDTPage) {
                $('#oForwardPage').attr('disabled',true);
            } else {
                $('#oForwardPage').attr('disabled',false);
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxTTBDTCount() {
    var oetFTTmdName = $('#oetFTTmdName').val();
    var ohdFNTmhID = $('#ohdFNTmhID').val();
    $.ajax({
        type: "POST",
        url: "EticketTimeTable/TimeTableDTCount",
        data: {
            tFTTmdName: oetFTTmdName,
            nFNTmhID: ohdFNTmhID
        },
        cache: false,
        success: function (msg) {
            $('#ospTotalTTBDTRecord').text(msg);
            $('#ospPageTTBDTActive').text('1');
            $('#ospTotalTTBDTPage').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxTTBDTListView();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxTTBDTDel(nFNTmdID, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + $(tMsg).data('name'),
        buttons: {
            cancel: {
                label: aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            },
            confirm: {
                label: aLocale['tBtnClose'],
                className: 'xCNBTNDefult'
            }
        },
        callback: function (result) {
            if (result == false) {
                $.ajax({
                    type: "post",
                    url: "EticketTimeTable/DeleteTimeTableDT",
                    data: {
                        nFNTmdID: nFNTmdID
                    },
                    cache: false,
                    success: function (tResult) {
                        JSxTTBDTCount();
                    },
                    error: function (tError) {
                        console.log(tError);
                    }
                });
            }
        }
    });
}

function FSxDelAllOnCheckDT() {
    var ocbListItem = [];
    var ocbListName = [];
    $('.ocbListItem:checked').each(function (i, e) {
        ocbListName.push($(this).data('name'));
    });

    $('.ocbListItem:checked').each(function (i, e) {
        ocbListItem.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "EticketTimeTable/DeleteTimeTableDT",
        data: {
            'nFNTmdID': ocbListItem.join()
        },
        cache: false,
        success: function (msg) {
            JSxTTBDTCount();
            $('.obtChoose').hide();
            $('.modal-backdrop').remove(); 
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        },
        error: function (data) {
            console.log(data);
        }
    });
}


//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 22/01/2019 Krit
//Return: -
//Return Type: -
function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tText = '';
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tName + '(' + aArrayConvert[0][$i].nCode + ') ';
            tText += ' , ';
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        var tTexts = tText.substring(0, tText.length - 2);
        $('#ospConfirmDelete').text('ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?');
        $('#ospConfirmIDDelete').val(tTextCode);
    }
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 22/01/2019 Krit
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

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 22/01/2019 Krit
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
