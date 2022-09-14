// ข้อมูลหน้า ก่อนหน้า
function JSxEVTPreviousPage() {
    var nCurrentPage = $('#ospPageActiveEvent').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActiveEvent').text(nPreviousPage);
    JSxEVTListView();
}

// ข้อมูลหน้า หน้าถัดไป
function JSxEVTForwardPage() {
    var nCurrentPage = $('#ospPageActiveEvent').text();
    var nTotalPage = $('#ospTotalPageEvent').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActiveEvent').text(nForwardPage);
    JSxEVTListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageActiveEvent').text(tNumPage);
    JSxEVTListView();
}

// แสดงข้อมูลสาขา
function JSxEVTListView(nPageNo) {
    var tFTEvnName = $('#oetFTEvnName').val();
    var tFDEvnStart = $('#oetFDEvnStart').val();
    var nPageNo = $('#ospPageActiveEvent').text();
    $.ajax({
        type: "POST",
        url: "EticketEventList",
        data: {
            tFTEvnName: tFTEvnName,
            tFDEvnStart: tFDEvnStart,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
            $('#oResultEvent').html(msg);
            var ospPageActiveEvent = $('#ospPageActiveEvent').text();
            var ospTotalPageEvent = $('#ospTotalPageEvent').text();
            var tHtml = '';

            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxEVTPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPageEvent); i++) {
                l = i + 1;
                if (parseInt(ospPageActiveEvent) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxEVTForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageActiveEvent == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActiveEvent == ospTotalPageEvent) {
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

// นับจำนวนค้นหาสาขา
function JSxEVTCount(nPageNo) {
    var tFTEvnName = $('#oetFTEvnName').val();
    var tFDEvnStart = $('#oetFDEvnStart').val();
    $.ajax({
        type: "POST",
        url: "EticketEventCount",
        data: {
            tFTEvnName: tFTEvnName,
            tFDEvnStart: tFDEvnStart
        },
        cache: false,
        success: function (msg) {
            $('#oEventCount').text(msg);
            $('#ospPageActiveEvent').text('1');
            $('#ospTotalPageEvent').text(Math.ceil(parseInt(msg) / 5));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }

            if(nPageNo == '' || nPageNo == undefined || nPageNo == null){
                nPageNo = 1;
            }
            if(nPageNo != 1 && nPageNo != $('#ospTotalPageEvent').text()){
                var nPageAll = nPageNo;
                var nPageTotal = nPageAll - 1 ;
                nPageNo = nPageTotal;
                $('#ospPageActiveEvent').text(nPageNo);
            }else{
                $('#ospPageActiveEvent').text(nPageNo);
            }

            JSxEVTListView(nPageNo);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * FS ลบทางเข้า
 */
function JSxEVTDel(nEvtID, tMsg) {
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
                    type: "POST",
                    url: "EticketDelEvent",
                    data: {
                        nEvtID: nEvtID
                    },
                    cache: false,
                    success: function (msg) {
                        window.onload = JSxEVTCount();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}

function FSxDelAllOnCheck() {
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
        url: "EticketDelEvent",
        data: {
            'nEvtID': ocbListItem.join()
        },
        cache: false,
        success: function (msg) {
            JSxEVTCount();
            $('.modal-backdrop').remove(); 
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        },
        error: function (data) {
            console.log(data);
        }
    });
}


function JSxEVTDelImg(nImgID, tImgObj, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirm'],
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
                    type: "POST",
                    url: "EticketEventDelImg",
                    data: {
                        tImgID: nImgID,
                        tNameImg: tImgObj,
                    },
                    cache: false,
                    success: function (msg) {
                        $('#oimImgMasterMain').attr("src", "application/modules/common/assets/images/Noimage.png");
                        $('#oDelImgRoom').hide();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}


function JSxEVTDelImgSub(nImgID, tImgObj) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirm'],
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
                    type: "POST",
                    url: "EticketEventDelImg",
                    data: {
                        tImgID: nImgID,
                        tNameImg: tImgObj,
                    },
                    cache: false,
                    success: function (msg) {
                        $('.xWImg'+nImgID+'').attr("src", "application/modules/common/assets/images/Noimage.png");
                        $('#oDelImg'+nImgID+'').hide();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}

function JSxEVTApv(nFNEvnID) {
    $.ajax({
        type: "POST",
        url: "EticketEventApv",
        data: {
            nFNEvnID: nFNEvnID
        },
        cache: false,
        success: function (msg) {
            if (parseInt(msg) === 1) {
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aLocale['tPleaseAddShowTime'],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
            } else {
                JSxCallPage('EticketEvent');
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}


//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 18/01/2019 Krit
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
//Creator: 18/01/2019 Krit
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
//Creator: 18/01/2019 Krit
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