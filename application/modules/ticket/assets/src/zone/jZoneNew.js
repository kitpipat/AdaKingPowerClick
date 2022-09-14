// ข้อมูลหน้า ก่อนหน้า
function JSxZnePreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageActiveZne').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActiveZne').text(nPreviousPage);
    JSxZneListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageActiveZne').text(tNumPage);
    JSxZneListView();
}
// ข้อมูลหน้า หน้าถัดไป
function JSxZneForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageActiveZne').text();
    var nTotalPage = $('#ospTotalPageZne').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActiveZne').text(nForwardPage);
    JSxZneListView();
}

// แสดงข้อมูลสาขา
function JSxZneListView() {
    var tFTZneName = $('#oetSCHFTZneName').val();
    var nPageNo = $('#ospPageActiveZne').text();
    var nLocID = $('#ohdGetLocID').val();
    var nPrkID = $('#ohdGetPrkID').val();
    $.ajax({
        type: "POST",
        url: "EticketZoneListNew",
        data: {tFTZneName: tFTZneName, nLocID: nLocID, nPrkID: nPrkID, nPageNo: nPageNo},
        cache: false,
        success: function (msg) {
            $('#oResultZne').html(msg);
            var ospPageActiveZne = $('#ospPageActiveZne').text();
            var ospTotalPageZne = $('#ospTotalPageZne').text();
            var tHtml = '';

            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxZnePreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPageZne); i++) {
                l = i + 1;
                if (parseInt(ospPageActiveZne) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxZneForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';


            $('.xWGridFooter').html(tHtml);
            if (ospPageActiveZne == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActiveZne == ospTotalPageZne) {
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
// นับจำนวนค้นหาสาขา
function JSxZneCount() {
    var tFTZneName = $('#oetSCHFTZneName').val();
    if (tFTZneName == "") {
        var tZneName = '';
    } else {
        var tZneName = tFTZneName;
    }
    var nLocID = $('#ohdGetLocID').val();

    $.ajax({
        type: "POST",
        url: "EticketZneCount",
        data: {tFTZneName: tZneName, nLocID: nLocID},
        cache: false,
        success: function (msg) {
            $('#ospPageActiveZne').text('1');
            $('#ospTotalRecordZne').text(msg);
            $('#ospTotalPageZne').text(Math.ceil(parseInt(msg) / 5));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxZneListView();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
/**
 * FS โซน
 */
function FSxLoadZone() {
    $('#oResultHoliday').html('');
    $('#xWNameMngLocs').css({"margin-top": "0px", "position": "absolute", "top": "5px", "width": "100%"});
    $('#oTbList2').show();
    var tFTZneName = $('#oetSCHFTZneName').val();
    if (tFTZneName == "") {
        var ZneName = '';
    } else {
        var ZneName = tFTZneName;
    }
    var nLocID = $('#oetHDFNLocIDAddZone').val();
    $.ajax({
        type: "POST",
        url: "EticketZneCount",
        data: {tFTZneName: ZneName, nLocID: nLocID},
        cache: false,
        success: function (msg) {
            $('#ospTotalRecordZne').text(msg);
            $('#ospPageActiveZne').text('1');
            $('#ospTotalPageZne').text(Math.ceil(parseInt(msg) / 9));
        },
        error: function (data) {
            console.log(data);
        }
    });
    JSxZneCount();
}
// Load Lev Select
function FSxLoadLevSlc() {
    var LocID = $('#oetHDFNLocIDAddZone').val();
    $.ajax({
        type: "POST",
        url: "EticketLoadLevSlc/" + LocID,
        data: {LocID: LocID},
        cache: false,
        success: function (data) {
            $('#ocmSlcListLev').html(data);
            $("#ocmSlcListLev option").filter(function () {
                return $(this).val() == $('#oetHDFNLevIDAddZone').val();
            }).attr('selected', true);
        },
        error: function (data) {
            console.log(data);
        }
    });
}
/**
 * FS ลบโซน
 */
function JSxDelZone(tZoneID, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + $(tMsg).data('name'),
        buttons: {
            cancel: {
                label: aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            },
            confirm: {
                label: aLocale['tBtnCancel'],
                className: 'xCNBTNDefult'
            }
        },
        callback: function (result) {
            if (result == false) {
                var nLocID = $('#ohdGetLocID').val();
                $.ajax({
                    type: "POST",
                    url: "EticketZoneDel",
                    data: {tZoneID: tZoneID},
                    cache: false,
                    success: function (oData) {
                        oBj = JSON.parse(oData);
                        if (oBj.count == 1) {
                            bootbox.alert({
                                title: 'แจ้งเตือน',
                                message: oBj.msg,
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
                            JSxZneCount();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}
/**
 * FS แก้ไขโซน
 */
function JSxEditZone(tFTZneID, tFTZneName, tFNZneCol, tFNZneRow, tFNZneRowStart, tFNStaSeat, tFTZneBookingType, tFNLevID, nLocID) {
    $('#oetEditFNZneRowStart').val(tFNZneRowStart);
    $('#oetEditFNZneCol').val(tFNZneCol);
    $('#oetEditFNZneRow').val(tFNZneRow);
    $('#oetEditFTZneName').val(tFTZneName);
    $('#oetHDFNZneID').val(tFTZneID);
    if (tFNStaSeat != "") {
        $('#oDivInputForm').hide();
    } else if (tFTZneBookingType == "3") {
        $('#oDivInputForm').hide();
    } else if (tFTZneBookingType == "2") {
        $('#oDivInputForm').hide();
    } else {
        $('#oDivInputForm').show();
    }
    var LocID = nLocID;
    $.ajax({
        type: "POST",
        url: "EticketLoadLevSlc/" + LocID,
        data: {LocID: LocID},
        cache: false,
        success: function (data) {
            $('#ocmSlcListLevLoad').html(data);
            $('select[id=ocmSlcListLevLoad]').val(tFNLevID);
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxZNESeat(tFNLocID, tFNLevID, tFNZneID) {
    $('.icon-loading').show();
    $.ajax({
        type: "POST",
        url: "EticketSeatListNew",
        data: {tFNLocID: tFNLocID, tFNLevID: tFNLevID, tFNZneID: tFNZneID},
        cache: false,
        success: function (msg) {
            $('.xWwrapBox').html(msg);
            $('.icon-loading').hide();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxZNECreateSeat() {
    $tFNZneRow = $('#ohdSetFNZneRow').val();
    $tFNZneCol = $('#ohdSetFNZneCol').val();
    $tFNZneRowStart = $('#ohdSetFNZneRowStart').val();
    $tFNZneColStart = $('#ohdFNZneColStart').val();
    $tFNLocIDSet = $('#ohdFNLocIDSet').val();
    $tFNLevIDSet = $('#ohdFNLevIDSet').val();
    $tFNZneIDSet = $('#ohdFNZneIDSet').val();
    $('.icon-loading').show();
    $.ajax({
        type: "POST",
        url: "EticketCreateSeatNew",
        data: {ohdFNLocIDSet: $tFNLocIDSet, ohdFNLevIDSet: $tFNLevIDSet, ohdFNZneIDSet: $tFNZneIDSet, ohdFNZneRow: $tFNZneRow, ohdFNZneCol: $tFNZneCol, ohdFNZneRowStart: $tFNZneRowStart, ohdFNZneColStart: $tFNZneColStart},
        cache: false,
        success: function (msg) {
            //console.log(msg);
            JSxZNESeat($tFNLocIDSet, $tFNLevIDSet, $tFNZneIDSet);
            $('.icon-loading').hide();
            $('#oBtnAddSeat').show();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxEditSeat(ohdFNSetID, tFTSetName, tFTSetStaAlw) {
    $('#ohdFNSetID').val(ohdFNSetID);
    $('#oetFTSetName').val(tFTSetName);
    $('select[id=ocmFTSetStaAlw]').val(tFTSetStaAlw);
}
// Load Zone Select
function FSxLoadZoneSlc() {
    var tLocID = $('#oetHDFNLocIDAddZone').val();
    $.ajax({
        type: "POST",
        url: "EticketLoadZoneSlc/" + tLocID,
        data: {
            tLocID: tLocID
        },
        cache: false,
        success: function (data) {
            $('#oSlcListZone').html(data);
            $("#oSlcListZone option").filter(function () {
                return $(this).val() == $('#oetHDFNZneIDAddGate').val();
            }).attr('selected', true);
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxZNEDelImg(nImgID, tImgObj, tMsg) {
    bootbox.confirm({
        title: 'ยืนยันการลบข้อมูล',
        message: 'Are you sure to delete this item?',
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
                    url: "EticketDelImgZne",
                    data: {
                        tImgID: nImgID,
                        tNameImg: tImgObj,
                        tImgType: 3
                    },
                    cache: false,
                    success: function (msg) {
                        console.log(msg);
                        $('#oimImgMasterMain').attr("src", "application/modules/common/assets/images/Noimage.png");
                        $('#oDelImgZone').hide();
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
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + ocbListName.join(),
        buttons: {
            cancel: {
                label: '<i class="fa fa-times-circle" aria-hidden="true"></i> ' + aLocale['tBtnClose'],
                className: 'xCNBTNDefult'
            },
            confirm: {
                label: '<i class="fa fa-check-circle" aria-hidden="true"></i> ' + aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            }
        },
        callback: function (result) {
            if (result == true) {
                $('.ocbListItem:checked').each(function (i, e) {
                    ocbListItem.push($(this).val());
                });
                $.ajax({
                    type: "POST",
                    url: "EticketZoneDel",
                    data: {
                        'tZoneID': ocbListItem.join()
                    },
                    cache: false,
                    success: function (msg) {
                        JSxZneCount();
                        $('.obtChoose').hide();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}

