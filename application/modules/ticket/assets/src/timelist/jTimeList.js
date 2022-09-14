function JSxTLTDelTimeDOW(nFNEvnID, nFNLocID, nDayOfWeek) {
    // bootbox.confirm({
    //     title: 'ยืนยันการลบข้อมูล',
    //     message: 'Are you sure to delete this item?',
    //     buttons: {
    //         cancel: {
    //             label: '<i class="fa fa-times-circle" aria-hidden="true"></i> ' + aLocale['tBtnClose'],
    //             className: 'xCNBTNDefult'
    //         },
    //         confirm: {
    //             label: '<i class="fa fa-check-circle" aria-hidden="true"></i> ' + aLocale['tBtnConfirm'],
    //             className: 'xCNBTNPrimery'
    //         }
    //     },
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + nFNEvnID ,
        buttons: {
            cancel: {
                label:  aLocale['tBtnConfirm'],
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
                    url: "EticketTimeTable/DelTimeDOW",
                    data: {nFNEvnID: nFNEvnID, nFNLocID: nFNLocID, nDayOfWeek: nDayOfWeek},
                    cache: false,
                    success: function (msg) {
                        JSxCallPage('EticketTimeTable/TimeTableList/' + nFNEvnID + '/' + nFNLocID + '?dow=1');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}

function JSxTLTDelTimeHoliday(nFNEvnID, nFNLocID, nFNTmhID, tDate) {
    bootbox.confirm({
        title: 'ยืนยันการลบข้อมูล',
        message: 'Are you sure to delete this item?',
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
                $.ajax({
                    type: "POST",
                    url: "EticketTimeTable/DelTimeHoliday",
                    data: {nFNEvnID: nFNEvnID, nFNLocID: nFNLocID, nFNTmhID: nFNTmhID, tDate: tDate},
                    cache: false,
                    success: function (msg) {
                        JSxCallPage('TimeTable/TimeTableList/' + nFNEvnID + '/' + nFNLocID + '?hld=1');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}



/******************/
// รอบการแสดงวันปกติ
//ข้อมูลหน้า ก่อนหน้า
function JSxTLTSTPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageTLTSTActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageTLTSTActive').text(nPreviousPage);
    JSxTLTSTListView();
}
//ข้อมูลหน้า หน้าถัดไป
function JSxTLTSTForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageTLTSTActive').text();
    var nTotalPage = $('#ospTotalTLTSTPage').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageTLTSTActive').text(nForwardPage);
    JSxTLTSTListView();
}
function JSxTLTSTListView() {
    var tFTTmhName = $('#oetSCHFTTLTSTName').val();
    var nEventId = $('#ohdGetEventId').val();
    var nLocId = $('#ohdGetLocId').val();
    var nPageNo = $('#ospPageTLTSTActive').text();
    $('.icon-loading').show();
    $.ajax({
        type: "POST",
        url: "EticketTimeTable/TimeTableSTAjaxList",
        data: {
            tFTTmhName: tFTTmhName,
            nEventId: nEventId,
            nLocId: nLocId,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
            $('#oResultTimeTable').html(msg);
            $('.icon-loading').hide();
            var ospPageTLTSTActive = $('#ospPageTLTSTActive').text();
            var ospTotalTLTSTPage = $('#ospTotalTLTSTPage').text();
            if (ospPageTLTSTActive == '1') {
                $('#oPreviousPage').prop('disabled', true);
            } else {
                $('#oPreviousPage').prop('disabled', false);
            }
            if (ospPageTLTSTActive == ospTotalTLTSTPage) {
                $('#oForwardPage').prop('disabled', true);
            } else {
                $('#oForwardPage').prop('disabled', false);
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxTLTSTCount() {
    var tFTTmhName = $('#oetSCHFTTLTSTName').val();
    var nEventId = $('#ohdGetEventId').val();
    var nLocId = $('#ohdGetLocId').val();
    $.ajax({
        type: "POST",
        url: "EticketTimeTable/TimeTableSTCount",
        data: {
            tFTTmhName: tFTTmhName,
            nEventId: nEventId,
            nLocId: nLocId
        },
        cache: false,
        success: function (msg) {
            $('#ospTotalTLTSTRecord').text(msg);
            $('#ospPageTLTSTActive').text('1');
            $('#ospTotalTLTSTPage').text(Math.ceil(parseInt(msg) / 5));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            // check if msg = 1 จะสามารถเพิ่มรอบการแสดงได้แค่ 1 รอบ
            if (parseInt(msg) >= 1) {
                //$('#oBTNTLTST').hide();
            }
            JSxTLTSTListView();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxTLTDelTimeTableST(nFNEvnID, nFNLocID, nFNTmhID, tDateStart, tDateEnd, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + nFNEvnID + ' ('+tMsg+')',
        buttons: {
            cancel: {
                label:  aLocale['tBtnConfirm'],
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
                    url: "EticketTimeTable/DeleteTimeTableST",
                    data: {nFNEvnID: nFNEvnID, nFNLocID: nFNLocID, nFNTmhID: nFNTmhID, tDateStart: tDateStart, tDateEnd: tDateEnd},
                    cache: false,
                    success: function (msg) {
                        JSxCallPage('EticketTimeTable/TimeTableList/' + nFNEvnID + '/' + nFNLocID + '');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}
function JSxTLTSTModalShow(id) {
    $('#oModalShowTimeST').on('shown.bs.modal', function () {
        $('.icon-loading').show();
        nFNTmhID = id;
        $.ajax({
            type: "POST",
            url: "EticketTimeTable/TimeTableSTPickList",
            data: {nFNTmhID: nFNTmhID},
            cache: false,
            success: function (msg) {
                $('#oDivModalShowTimeST').html(msg);
                $('.icon-loading').hide();
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
}
JSxTLTSTCount();