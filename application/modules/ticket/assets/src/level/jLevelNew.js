/**
 * สาขา pagination และ ค้นหา
 */
// ข้อมูลหน้า ก่อนหน้า
function JSxLvlPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageActiveLvl').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActiveLvl').text(nPreviousPage);
    JSxLvlListView();
}

// ข้อมูลหน้า หน้าถัดไป
function JSxLvlForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageActiveLvl').text();
    var nTotalPage = $('#ospTotalPageLvl').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActiveLvl').text(nForwardPage);
    JSxLvlListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageActiveLvl').text(tNumPage);
    JSxLvlListView();
}
// แสดงข้อมูลสาขา
function JSxLvlListView() {
    var tFTLvlName = $('#oetSCHFTLvlName').val();
    var nPageNo = $('#ospPageActiveLvl').text();
    var nLocID = $('#ohdGetLocID').val();
    $('.icon-loading').show();
    $.ajax({
        type: "POST",
        url: "EticketLevelListNew",
        data: {tFTLvlName: tFTLvlName, nLocID: nLocID, nPageNo: nPageNo},
        cache: false,
        success: function (msg) {
            $('#oResultLvl').html(msg);
            var ospPageActiveLvl = $('#ospPageActiveLvl').text();
            var ospTotalPageLvl = $('#ospTotalPageLvl').text();
            var tHtml = '';

            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxLvlPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPageLvl); i++) {
                l = i + 1;
                if (parseInt(ospPageActiveLvl) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxLvlPreviousPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageActiveLvl == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActiveLvl == ospTotalPageLvl) {
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
function JSxLvlCountSearch() {
    var tFTLvlName = $('#oetSCHFTLvlName').val();
    if (tFTLvlName == "") {
        var LvlName = '';
    } else {
        var LvlName = tFTLvlName;
    }
    var nLocID = $('#ohdGetLocID').val();
    $.ajax({
        type: "POST",
        url: "EticketLvlCount",
        data: {tFTLvlName: LvlName, nLocID: nLocID},
        cache: false,
        success: function (msg) {
            $('#ospTotalRecordLvl').text(msg);
            $('#ospPageActiveLvl').text('1');
            $('#ospTotalPageLvl').text(Math.ceil(parseInt(msg) / 5));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxLvlListView();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * FS แก้ไขชั้น
 */
function JSxEditLev(tLocID, tLevID, tLevName) {
    $('#ohdEditLocID').val(tLocID);
    $('#ohdEditFNLevID').val(tLevID);
    $('#oetEditFTLevName').val(tLevName);
}

/**
 * FS ลบชั้น
 */
function JSxDelLev(tLevID, tFNLocID, tMsg) {
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
                $.ajax({
                    type: "POST",
                    url: "EticketDelLevel",
                    data: {tLevID: tLevID},
                    cache: false,
                    success: function (oData) {
                        console.log(oData);
                        
                        oBj = JSON.parse(oData);
                        if (oBj.count == 1) {
                            bootbox.alert({
                                title: aLocale['tWarning'],
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
                            JSxLvlCountSearch();
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
 * FS ชั้น
 */
function FSxLoadFloor() {
    $('#oTbList2').hide();
    $('#oResultHoliday').html('');
    $('#xWNameMngLocs').removeAttr("style").css({'font-weight': 'bold', 'margin-top': '10px'});
    JSxLvlCountSearch();
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
                $('.ocbListItem:checked').each(function (i, e) {
                    ocbListItem.push($(this).val());
                });
                $.ajax({
                    type: "POST",
                    url: "EticketDelLevel",
                    data: {
                        'tLevID': ocbListItem.join()
                    },
                    cache: false,
                    success: function (msg) {
                        JSxLvlCountSearch();
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