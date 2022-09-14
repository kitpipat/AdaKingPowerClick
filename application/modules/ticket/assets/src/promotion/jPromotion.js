// ข้อมูลหน้า ก่อนหน้า
function JSxPmtPreviousPage() {
    var nCurrentPage = $('#ospPageActivePmt').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1; 
    }
    $('#ospPageActivePmt').text(nPreviousPage);
    JSxPmtListView();
}

// ข้อมูลหน้า หน้าถัดไป
function JSxPmtForwardPage() {
    var nCurrentPage = $('#ospPageActivePmt').text();
    var nTotalPage = $('#ospTotalPagePmt').text();
    var nForwardPageJSxPkgCount
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActivePmt').text(nForwardPage);
    JSxPmtListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageActivePmt').text(tNumPage);
    JSxPmtListView();
}
// แสดงข้อมูลสาขา
function JSxPmtListView(nPageNo) {
    var tFTPmtName = $('#oetFTPmhName').val();
    var nPageNo = $('#ospPageActivePmt').text();
    $.ajax({
        type: "POST",
        url: "EticketPromotionList",
        data: {tFTPmtName: tFTPmtName, nPageNo: nPageNo},
        cache: false,
        success: function (msg) {
            $('#oResultPmt').html(msg);
            var ospPageActivePmt = $('#ospPageActivePmt').text();
            var ospTotalPagePmt = $('#ospTotalPagePmt').text();
            var tHtml = '';

            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxPmtPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPagePmt); i++) {
                l = i + 1;
                if (parseInt(ospPageActivePmt) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxPmtForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageActivePmt == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActivePmt == ospTotalPagePmt) {
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
function JSxPmtCount(nPageNo) {
    var tFTPmtName = $('#oetFTPmhName').val();
    $.ajax({
        type: "POST",
        url: "EticketPromotionCount",
        data: {tFTPmtName: tFTPmtName},
        cache: false,
        success: function (msg) {
            $('#ospPageActivePmt').text('1');
            $('#ospTotalPmtRecord').text(msg);
            $('#ospTotalPagePmt').text(Math.ceil(parseInt(msg) / 8));
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
            if(nPageNo != 1 && nPageNo != $('#ospTotalPagePmt').text()){
                var nPageAll = nPageNo;
                var nPageTotal = nPageAll - 1 ;
                nPageNo = nPageTotal;
                $('#ospPageActivePmt').text(nPageNo);
            }else{
                $('#ospPageActivePmt').text(nPageNo);
            }

            JSxPmtListView(nPageNo);
            JSxCheckPinMenuClose();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxPmtDel(pnPage,ptPmtID, ptPmtName) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + ptPmtID + ' ('+ptPmtName+')',
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
                    url: "EticketPromotionDel",
                    data: {tPmtID: ptPmtID},
                    cache: false,
                    success: function (oData) {
                        $('#ospPageActivePmt').text(pnPage);
                        JSxPmtCount(pnPage);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}

//Functionality : (event) Delete All
//Parameters : Button Event 
//Creator : P'Nut
//Update: 22/01/2018 Krit
//Return : Event Delete All Select List
//Return Type : -
function FSxDelAllOnCheck(pnPage) {
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
        url: "EticketPromotionDel",
        data: {
            'tPmtID': ocbListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('#ospPageActive').text(pnPage);
            JSxPmtCount();
            $('.modal-backdrop').remove(); 
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxPkgPreviousPage() {
    var nCurrentPage = $('#ospPageActivePkg').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActivePkg').text(nPreviousPage);
    JSxPkgList();
}
function JSxPkgForwardPage() {
    var nCurrentPage = $('#ospPageActivePkg').text();
    var nTotalPage = $('#ospTotalPagePkg').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActivePkg').text(nForwardPage);
    JSxPkgList();
}
function JSvPClickPagePkg(tNumPage) {
    $('#ospPageActivePkg').text(tNumPage);
    JSxPkgList();
}
function JSxPkgList() {
    $('.xCNOverlay').show();
    var aListItem = [];
    var FTPkgName = $('#oetFTPkgName').val();
    var nPageNo = $('#ospPageActivePkg').text();
    var tExclude = $('#oTablePkg #ohdChkExcludePkg:first-child').val();
    if (tExclude == '1' || tExclude == '2') {
        $('.xWFTPspStaExcludePkg1').attr("disabled", true);
        $('.xWFTPspStaExcludePkg2').attr("disabled", true);
    } else {
        $('.xWFTPspStaExcludePkg1').attr("disabled", false);
        $('.xWFTPspStaExcludePkg2').attr("disabled", false);
    }
    $('#oTablePkg tbody tr td #ohdPkgId').each(function (i, e) {
        aListItem.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "EticketPromotionPkgList",
        data: {
            FTPkgName: FTPkgName,
            nPageNo: nPageNo,
            aListItem: aListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('.xWTablePkgList tbody').html(msg);
            $('.xCNOverlay').hide();
            var ospPageActivePkg = $('#ospPageActivePkg').text();
            var ospTotalPagePkg = $('#ospTotalPagePkg').text();
            var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxPkgPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPagePkg); i++) {
                l = i + 1;
                if (parseInt(ospPageActivePkg) == l) {
                    tHtml += '<button onclick="JSvPClickPagePkg(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPagePkg(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxPkgForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWBoxPkg').html(tHtml);
            if (ospPageActivePkg == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActivePkg == ospTotalPagePkg) {
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
function JSxPkgCount() {
    var aListItem = [];
    var FTPkgName = $('#oetFTPkgName').val();
    $('#oTablePkg tbody tr td #ohdPkgId').each(function (i, e) {
        aListItem.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "EticketPromotionPkgCount",
        data: {
            FTPkgName: FTPkgName,
            aListItem: aListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('#ospPageActivePkg').text('1');
            $('#ospTotalPkgRecord').text(msg);
            $('#ospTotalPagePkg').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxPkgList();
            JSxCheckPinMenuClose();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxBchPreviousPage() {
    var nCurrentPage = $('#ospPageActiveBch').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActiveBch').text(nPreviousPage);
    JSxBchList();
}
function JSxBchForwardPage() {
    var nCurrentPage = $('#ospPageActiveBch').text();
    var nTotalPage = $('#ospTotalPageBch').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActiveBch').text(nForwardPage);
    JSxBchList();
}
function JSvPClickPageBch(tNumPage) {
    $('#ospPageActiveBch').text(tNumPage);
    JSxBchList();
}
function JSxBchList() {
    $('.xCNOverlay').show();
    var aListItem = [];
    var FTPmoName = $('#oetFTPmoName').val();
    var nPageNo = $('#ospPageActiveBch').text();
    var tExclude = $('#oTableBranch #ohdChkExcludeBch:first-child').val();
    if (tExclude == '1' || tExclude == '2') {
        $('.xWFTPspStaExcludeBch1').attr("disabled", true);
        $('.xWFTPspStaExcludeBch2').attr("disabled", true);
    } else {
        $('.xWFTPspStaExcludeBch1').attr("disabled", false);
        $('.xWFTPspStaExcludeBch2').attr("disabled", false);
    }

    $('#oTableBranch tbody tr td #ohdBranchId').each(function (i, e) {
        aListItem.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "EticketPromotionBchList",
        data: {
            FTPmoName: FTPmoName,
            nPageNo: nPageNo,
            aListItem: aListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('.xWTableBchList tbody').html(msg);
            $('.xCNOverlay').hide();


            var ospPageActiveBch = $('#ospPageActiveBch').text();
            var ospTotalPageBch = $('#ospTotalPageBch').text();
            var tHtml = '';

            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxBchPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPageBch); i++) {
                l = i + 1;
                if (parseInt(ospPageActiveBch) == l) {
                    tHtml += '<button onclick="JSvPClickPageBch(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPageBch(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxBchForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWBoxBch').html(tHtml);
            if (ospPageActiveBch == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActiveBch == ospTotalPageBch) {
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
function JSxBchCount() {
    var aListItem = [];
    var FTPmoName = $('#oetFTPmoName').val();
    $('#oTableBranch tbody tr td #ohdBranchId').each(function (i, e) {
        aListItem.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "EticketPromotionBchCount",
        data: {
            FTPmoName: FTPmoName,
            aListItem: aListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('#ospPageActiveBch').text('1');
            $('#ospTotalBchRecord').text(msg);
            $('#ospTotalPageBch').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxBchList();
            JSxCheckPinMenuClose();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxAgnPreviousPage() {
    var nCurrentPage = $('#ospPageActiveAgn').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActiveAgn').text(nPreviousPage);
    JSxAgnList();
}
function JSxAgnForwardPage() {
    var nCurrentPage = $('#ospPageActiveAgn').text();
    var nTotalPage = $('#ospTotalPageAgn').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActiveAgn').text(nForwardPage);
    JSxAgnList();
}
function JSvPClickPageAgn(tNumPage) {
    $('#ospPageActiveAgn').text(tNumPage);
    JSxAgnList();
}
function JSxAgnList() {
    $('.xCNOverlay').show();
    var nPageNo = $('#ospPageActiveAgn').text();
    var FTAggName = $('#oetFTAggName').val();
    var aListItem = [];
    var tExclude = $('#oTableGrp #ohdChkExcludeGrp:first-child').val();
    if (tExclude == '1' || tExclude == '2') {
        $('.xWFTPsgStaExcludeAgn1').attr("disabled", true);
        $('.xWFTPsgStaExcludeAgn2').attr("disabled", true);

        $('.xwFTPsgStaExcludeCst1').attr("disabled", true);
        $('.xwFTPsgStaExcludeCst2').attr("disabled", true);
    } else {
        $('.xWFTPsgStaExcludeAgn1').attr("disabled", false);
        $('.xWFTPsgStaExcludeAgn2').attr("disabled", false);

        $('.xwFTPsgStaExcludeCst1').attr("disabled", false);
        $('.xwFTPsgStaExcludeCst2').attr("disabled", false);
    }

    $('#oTableGrp tbody tr td #ohdAgnId').each(function (i, e) {
        aListItem.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "EticketPromotionAgnList",
        data: {
            nPageNo: nPageNo,
            FTAggName: FTAggName,
            aListItem: aListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('.nav-tabs a[href="#oAgn"]').tab('show');
            $('.xWTableAgnList tbody').html(msg);
            $('.xCNOverlay').hide();
            //$('.btn-add-grp').removeAttr("onclick");
            //$('.btn-add-grp').attr('onclick', 'FSxAddAgg()');
            var ospPageActiveAgn = $('#ospPageActiveAgn').text();
            var ospTotalPageAgn = $('#ospTotalPageAgn').text();
            var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxAgnPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPageAgn); i++) {
                l = i + 1;
                if (parseInt(ospPageActiveAgn) == l) {
                    tHtml += '<button onclick="JSvPClickPageAgn(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPageAgn(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxAgnForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWBoxAgn').html(tHtml);
            if (ospPageActiveAgn == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActiveAgn == ospTotalPageAgn) {
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
function JSxAgnCount() {
    var FTAggName = $('#oetFTAggName').val();
    var aListItem = [];
    $('#oTableGrp tbody tr td #ohdAgnId').each(function (i, e) {
        aListItem.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "EticketPromotionAgnCount",
        data: {
            FTAggName: FTAggName,
            aListItem: aListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('#ospPageActiveAgn').text('1');
            $('#ospTotalAgnRecord').text(msg);
            $('#ospTotalPageAgn').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxAgnList();
            JSxCheckPinMenuClose();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxCstPreviousPage() {
    var nCurrentPage = $('#ospPageActiveCst').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActiveCst').text(nPreviousPage);
    JSxCstList();
}
function JSxCstForwardPage() {
    var nCurrentPage = $('#ospPageActiveCst').text();
    var nTotalPage = $('#ospTotalPageCst').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActiveCst').text(nForwardPage);
    JSxCstList();
}
function JSvPClickPageCst(tNumPage) {
    $('#ospPageActiveCst').text(tNumPage);
    JSxCstList();
}
function JSxCstList() {
    $('.xCNOverlay').show();
    var FTCgpName = $('#oetFTCgpName').val();
    var nPageNo = $('#ospPageActiveCst').text();
    var aListItem = [];
    $('#oTableGrp tbody tr td #ohdCgpId').each(function (i, e) {
        aListItem.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "EticketPromotionCstList",
        data: {
            nPageNo: nPageNo,
            FTCgpName: FTCgpName,
            aListItem: aListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('.xWTableCstList tbody').html(msg);
            $('.xCNOverlay').hide();
            //$('.btn-add-grp').removeAttr("onclick");
            //$('.btn-add-grp').attr('onclick', 'FSxAddCst()');
            var ospPageActiveCst = $('#ospPageActiveCst').text();
            var ospTotalPageCst = $('#ospTotalPageCst').text();
            var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxCstPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPageCst); i++) {
                l = i + 1;
                if (parseInt(ospPageActiveCst) == l) {
                    tHtml += '<button onclick="JSvPClickPageCst(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPageCst(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxCstForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';


            $('.xWBoxCst').html(tHtml);
            if (ospPageActiveCst == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActiveCst == ospTotalPageCst) {
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
function JSxCstCount() {
    var FTCgpName = $('#oetFTCgpName').val();
    var aListItem = [];
    $('#oTableGrp tbody tr td #ohdCgpId').each(function (i, e) {
        aListItem.push($(this).val());
    });
    var tExclude = $('input[name="orbFTPsgStaExcludeAgn"]:checked').val();
    if (tExclude == '1') {
        $('.xwFTPsgStaExcludeCst1').prop('checked', true);
    } else if (tExclude == '2') {
        $('.xwFTPsgStaExcludeCst2').prop('checked', true);
    }
    $('.xwFTPsgStaExcludeCst1').prop('disabled', true);
    $('.xwFTPsgStaExcludeCst2').prop('disabled', true);

    $.ajax({
        type: "POST",
        url: "EticketPromotionCstCount",
        data: {
            FTCgpName: FTCgpName,
            aListItem: aListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('#ospPageActiveCst').text('1');
            $('#ospTotalCstRecord').text(msg);
            $('#ospTotalPageCst').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxCstList();
            JSxCheckPinMenuClose();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function FSxAddBch() {
    var nQ, id, nQu, tFTPspStaExclude, name, tExclude, nIndex, tHtml;
    nQ = $('#oTableBranch tbody tr #ohdBranchId').length;
    var i = parseInt(nQ);
    $('.xWTableBchList tbody .active #ohdModel').each(function () {
        id = $(this).data('id');
        tFTPspStaExclude = $("#orbFTPspStaExcludeBch:checked").val();
        name = $(this).val();
        if (tFTPspStaExclude == '1') {
            tExclude = 'ยกเว้นสาขา';
        } else if (tFTPspStaExclude == '2') {
            tExclude = 'เฉพาะสาขา';
        }
        $('#ohdFTPspStaExcludeBch').val(tFTPspStaExclude);
        nIndex = parseInt(i) + 1;
        tHtml = '<tr id="otrBch' + id + '"><td>' + nIndex + '</td><td>' + name + '<input type="hidden" id="ohdChkExcludeBch" value="' + tFTPspStaExclude + '"><input type="hidden" name="ohdFNPmoID[]" id="ohdFNPmoID" value="' + id + '"><input type="hidden" id="ohdBranchId" name="ohdBranchId[]" value="' + id + '"></td><td>' + tExclude + '</td><td> <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" onclick="FSxDelBch(\'#otrBch' + id + '\')"> </td></tr>';
        $('#oTableBranch tbody').append(tHtml);
        $("#oBchModal").modal('hide');
        $("#otrBch").remove();
        $('#ohdFTPmhStaSpcPark').val('1');
        i++;
    });
}
function FSxAddPkg() {
    var nQ, id, nQu, tFTPspStaExclude, name, tExclude, nIndex, tHtml;
    nQ = $('#oTablePkg tbody tr #ohdPkgId').length;
    var i = parseInt(nQ);
    $('.xWTablePkgList tbody .active #ohdPkgList').each(function () {
        id = $(this).data('id');
        name = $(this).val();
        tFTPspStaExclude = $("#orbFTPspStaExcludePkg:checked").val();
        $('#ohdFTPspStaExcludePkg').val(tFTPspStaExclude);
        if (tFTPspStaExclude == '1') {
            tExclude = 'ยกเว้นแพ็คเกจ';
        } else if (tFTPspStaExclude == '2') {
            tExclude = 'เฉพาะแพ็คเกจ';
        }
        nIndex = parseInt(i) + 1;
        tHtml = '<tr id="otrPkg' + id + '"><td>' + nIndex + '</td><td>' + name + '<input type="hidden" id="ohdChkExcludePkg" value="' + tFTPspStaExclude + '"><input type="hidden" name="ohdFNPkgID[]" id="ohdFNPkgID" value="' + id + '"><input type="hidden" id="ohdPkgId" name="ohdPkgId[]" value="' + id + '"></td><td>' + tExclude + '</td><td> <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" onclick="FSxDelPkg(\'#otrPkg' + id + '\')"> </td></tr>';
        $('#oTablePkg tbody').append(tHtml);
        $("#oPkgModal").modal('hide');
        $("#otrPkg").remove();
        $('#ohdFTPmhStaSpcPdt').val('1');
        i++;
    });
}
function FSxAddAgg() {
    var nQ, id, nQu, tFTPspStaExclude, name, tExclude, nIndex, tHtml;
    nQ = $('#oTableGrp tbody tr #ohdChkExcludeGrp').length; 
    var i = parseInt(nQ);
    $('.xWTableAgnList tbody .active #ohdAgg').each(function () {
        id = $(this).data('id');
        name = $(this).val();
        tFTPspStaExclude = $("#orbFTPsgStaExcludeAgn:checked").val();
        $("#ohdFTPsgStaExcludeGrp").val(tFTPspStaExclude);

        if (tFTPspStaExclude == '1') {
            tExclude = 'ยกเว้นกลุ่ม';
        } else if (tFTPspStaExclude == '2') {
            tExclude = 'เฉพาะกลุ่ม';
        }
        nIndex = parseInt(i) + 1;
        tHtml = '<tr id="otrGrp' + id + '"><td>' + nIndex + '</td><td>' + name + '<input type="hidden" id="ohdChkExcludeGrp" value="' + tFTPspStaExclude + '"><input type="hidden" name="ohdFTPsgType[]" value="1"><input type="hidden" name="ohdFTPsgRefID[]" id="ohdFTPsgRefID" value="' + id + '"><input type="hidden" id="ohdAgnId" name="ohdAgnId[]" value="' + id + '"></td><td>' + tExclude + '</td><td> <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" onclick="FSxDelGrp(\'#otrGrp' + id + '\')"> </td></tr>';
        $('#oTableGrp tbody').append(tHtml);
        $("#oGrpModal").modal('hide');
        $("#otrGrp").remove();
        $('#ohdFTPmhStaSpcGrp').val('1');
        i++;
    });
}
function FSxAddCst() {
    var nQ, id, nQu, tFTPspStaExclude, name, tExclude, nIndex, tHtml;
    nQ = $('#oTableGrp tbody tr #ohdChkExcludeGrp').length;
    var i = parseInt(nQ);
    $('.xWTableCstList tbody .active #ohdCgp').each(function () {
        id = $(this).data('id');
        name = $(this).val();
        tFTPspStaExclude = $("#orbFTPsgStaExcludeCst:checked").val();
        if (tFTPspStaExclude == '1') {
            tExclude = 'ยกเว้นกลุ่ม';
        } else if (tFTPspStaExclude == '2') {
            tExclude = 'เฉพาะกลุ่ม';
        }
        nIndex = parseInt(i) + 1;
        tHtml = '<tr id="otrGrp' + id + '"><td>' + nIndex + '</td><td>' + name + '<input type="hidden" id="ohdChkExcludeGrp" value="' + tFTPspStaExclude + '"><input type="hidden" name="ohdFTPsgType[]" id="ohdFTPsgType" value="2"><input type="hidden" name="ohdFTPsgRefID[]" id="ohdCFTPsgRefID" value="' + id + '"><input type="hidden" id="ohdCgpId" name="ohdCgpId[]" value="' + id + '"></td><td>' + tExclude + '</td><td><a onclick="FSxDelGrp(\'#otrGrp' + id + '\')"><i style="margin-left: 10px;" class="fa fa-trash-o fa-lg"></i></a></td></tr>';
        $('#oTableGrp tbody').append(tHtml);
        $("#oGrpModal").modal('hide');
        $("#otrGrp").remove();
        $('#ohdFTPmhStaSpcGrp').val('1');
        i++;
    });
}
function JSxBtnGen() {
    $.ajax({
        type: "GET",
        url: "EticketPromotionGenKey",
        data: {},
        cache: false,
        success: function (msg) {
            $('#oetFTPmhCode').val(msg);
            $('#oBtnGenCode').attr("disabled", true);
            $('#oBtnGenCode').attr("onclick","");
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxPmtApv(tFNPmhID) {
    $.ajax({
        type: "POST",
        url: "EticketPromotionApv",
        data: {tFNPmhID: tFNPmhID},
        cache: false,
        success: function (msg) {
            $('#oBtnApv').text('อนุมัติแล้ว');
            JSxPmtCount();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxDelPkg(tFNPspID, tFNPmhID, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + tMsg,
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
                    url: "EticketPromotionDelPkg",
                    data: {
                        tFNPspID: tFNPspID,
                        tFNPmhID: tFNPmhID
                    },
                    cache: false,
                    success: function (msg) {
                        $('#otrPkg' + tFNPspID + '').remove();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}
function JSxDelBch(tFNPspID, tFNPmhID, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + tMsg,
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
                    url: "EticketPromotionDelBch",
                    data: {
                        tFNPspID: tFNPspID,
                        tFNPmhID: tFNPmhID
                    },
                    cache: false,
                    success: function (msg) {
                        $('#otrBch' + tFNPspID + '').remove();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}
function JSxDelGrp(tFNPsgGrpID, tFNPmhID, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + tMsg,
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
                    url: "EticketPromotionDelGrp",
                    data: {
                        tFNPsgGrpID: tFNPsgGrpID,
                        tFNPmhID: tFNPmhID

                    },
                    cache: false,
                    success: function (msg) {
                        $('#otrGrp' + tFNPsgGrpID + '').remove();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}
function JSxGenImg(ptNameImg, ptFTPmhCode, ptImgRefID, ptSesUsername) {
    if (ptNameImg != '') {
        $.ajax({
            type: "POST",
            url: "gencodeimage/gen.php",
            data: {
                ptNameImg: ptNameImg,
                ptFTPmhCode: ptFTPmhCode,
                ptImgRefID: ptImgRefID,
                ptSesUsername: ptSesUsername,
            },
            cache: false,
            success: function (ee) {
                console.log(ee);
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
}
function FSxDelBch(nBchID) {
    $(nBchID).remove();
    var nQ = $('#oTableBranch tbody tr #ohdBranchId').length;
    if (parseInt(nQ) == 0) {
        $('#ohdFTPmhStaSpcPark').val('2');
    }
}
function FSxDelPkg(nPkgID) {
    $(nPkgID).remove();
    var nQ = $('#oTablePkg tbody tr #ohdPkgId').length;
    if (parseInt(nQ) == 0) {
        $('#ohdFTPmhStaSpcPdt').val('2');
    }
}
function FSxDelGrp(nGrpID) {
    $(nGrpID).remove();
    var nQ = $('#oTableGrp tbody tr #ohdChkExcludeGrp').length;
    if (parseInt(nQ) == 0) {
        $('#ohdFTPmhStaSpcGrp').val('2');
    }
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