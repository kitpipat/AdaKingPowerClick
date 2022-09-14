function JSxProductGroup() {
    $('.xWBoxPlace').hide();
    // alert('Load TchGrp');
    var tParkId = $('#ohdGetParkId').val();
    $.ajax({
        type: "post",
        url: "EticketParkProductGroup",
        data: {
            tParkId: tParkId
        },
        method: "GET",
        success: function (data) {
            $('#odvPdtTchGrid').html(data);
            JSxGrpPdtListView();
        },
        error: function (e) {
            console.log(e);
        }
    });
}

/**
 * สาขา pagination และ ค้นหา
 */
// ข้อมูลหน้า ก่อนหน้า
function JSxLocPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActive').text(nPreviousPage);
    JSxLocListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageActive').text(tNumPage);
    JSxLocListView();
}
// ข้อมูลหน้า หน้าถัดไป
function JSxLocForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageActive').text();
    var nTotalPage = $('#ospTotalPage').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActive').text(nForwardPage);
    JSxLocListView();
}
// แสดงข้อมูลสาขา
function JSxLocListView(nPageNo) {
    JCNxOpenLoading();
    var tFTLocName = $('#oetSCHFTLocName').val();
    var nPageNo = $('#ospPageActive').text();
    var nParkId = $('#ohdGetParkId').val();
    $.ajax({
        type: "POST",
        url: "EticketLocAjaxListNew",
        data: {
            tFTLocName: tFTLocName,
            tParkId: nParkId,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
         
            $('#oResultLocation').html(msg);
            var ospPageActive = $('#ospPageActive').text();
            var ospTotalPage = $('#ospTotalPage').text();
            var tHtml = '';

            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxLocPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPage); i++) {
                l = i + 1;
                if (parseInt(ospPageActive) == l) {
                    tHtml += '<button onclick="JSvLocClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvLocClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxLocForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActive == ospTotalPage) {
                $('#oForwardPage').attr('disabled',true);
            } else {
                $('#oForwardPage').attr('disabled',false);
            }
        JCNxCloseLoading();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 27/03/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvLocClickPage(ptPage) {

    // if(ptPage == '1'){ var nPage = 'previous'; }else if(ptPage == '2'){ var nPage = 'next';}
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWBCHPaging .active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWBCHPaging .active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }

    JSvPClickPage(nPageCurrent)
    // JSvBranchDataTable(nPageCurrent);
}

// นับจำนวนค้นหาสาขา
function JSxLocCountSearch(pnPage) {
    var tFTLocName = $('#oetSCHFTLocName').val();
    var nParkId = $('#ohdGetParkId').val();
    $.ajax({
        type: "POST",
        url: "EticketLocAjaxSearchNew",
        data: {
            tFTLocName: tFTLocName,
            nParkId: nParkId
        },
        cache: false,
        success: function (msg) {
            $('#ospTotalRecord').text(msg);
            $('#ospPageActive').text('1');
            $('#ospTotalPage').text(Math.ceil(parseInt(msg) / 2));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }

            if(pnPage == '' || pnPage == undefined || pnPage == null){
                pnPage = 1;
            }
            if(pnPage != 1 && pnPage != $('#ospTotalPage').text()){
                var nPageAll = pnPage;
                var nPageTotal = nPageAll - 1 ;
                pnPage = nPageTotal;
                $('#ospPageActive').text(pnPage);
            }else{
                $('#ospPageActive').text(pnPage);
			}
            
            JSxLocListView(pnPage);
            JSxCheckPinMenuClose(pnPage);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * FS ลบสถานที่
 */
function FsxDelLoc(ptPage, tID, tMsg) {

    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + tMsg+' ('+tID+')',
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
                    url: "EticketDeleteLocation",
                    data: {
                        tId: tID
                    },
                    cache: false,
                    success: function (oData) {
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
                            window.onload = JSxLocCountSearch();
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
 * FS แก้ไขสถานที่
 */
function JSxEditLoc(tID, tImg, tLocName, tLocLimit, tOpening, tClosing,
        nFNImgID, nFNPmoID) {
    $('#ohdEditLocationID').val(tID);
    if (tImg != "") {
        $('#oResultImgLoc')
                .html(
                        '<img src="data:image/jpeg;base64,'
                        + tImg
                        + '" class="xWhdLocImgEdit" id="thumbnail-edit"><div><a href="javascript:void(0)" onclick="JSxLOCDelImg('
                        + nFNImgID
                        + ', '
                        + nFNPmoID
                        + ')" style="border: 0 !important; position: absolute; right: 17px; top: 1px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a></div>');
    } else {
        $('#oResultImgLoc')
                .html(
                        '<img src="application/modules/common/assets/images/Noimage.png"class="xWhdLocImgEdit" id="thumbnail-edit">');

    }
    $('#oetFTLocEditName').val(tLocName);
    $('#oetFNLocEditLimit').val(tLocLimit);
    $('#oetFTLocTimeEditOpening').val(tOpening);
    $('#oetFTLocTimeEditClosing').val(tClosing);
    $.ajax({
        type: "POST",
        url: "EticketLoadArea",
        data: {
            nId: tID
        },
        cache: false,
        success: function (msg) {
            $('#oResultArea').html(msg);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * FS แสดงข้อมูลสถานที่
 */
function FSxManageLoc(tFNLocID, tFTImgObj, tFTLocName, tFTLocNameOth) {
    if (tFTImgObj != '') {
        $('#oImgMngLoc').attr('src', 'data:image/jpeg;base64,' + tFTImgObj);
    }
    $('.xWNameMngLoc').text(tFTLocName);
    $('.xWNameMngLocOth').text(tFTLocNameOth);
    $('#oAddLocFloor #ohdLevFNLocID').val(tFNLocID);
    $('#oetHDFNLocIDAddZone').val(tFNLocID);
    $('#ohdLocIDTime').val(tFNLocID);
    $('#ohdLocIDDOW').val(tFNLocID);
    $('#ohdLocIDHolidays').val(tFNLocID);
    $('.nav-tabs a[href="#LocFloor"]').tab('show');

    $.ajax({
        type: "POST",
        url: "EticketLvlCount",
        data: {
            tFTLvlName: '',
            nLocID: tFNLocID
        },
        cache: false,
        success: function (msg) {
            $('#ospTotalRecordLvl').text(msg);
            $('#ospTotalPageLvl').text(Math.ceil(parseInt(msg) / 9));
        },
        error: function (data) {
            console.log(data);
        }
    });
    JSxLvlCountSearch(tFNLocID);
    $('#oTbList2').hide();
}

// โหลดอำเภอ
function JSxLOCDistrict(tID) {
    $.ajax({
        type: "POST",
        url: "EticketDistrict",
        data: {
            ocmFNPvnID: tID
        },
        cache: false,
        success: function (msg) {
            $('#ocmFNDstID').html(msg);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxLOCDistrict2(tID) {
    $.ajax({
        type: "POST",
        url: "EticketDistrict",
        data: {
            ocmFNPvnID: tID
        },
        cache: false,
        success: function (msg) {
            $('#ocmEtFNDstID').html(msg);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxLOCDelAre(tID, tMsg) {
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
                    url: "EticketDelAre",
                    data: {
                        tID: tID
                    },
                    cache: false,
                    success: function (msg) {
                        $('#otr' + tID).remove();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}

function JSxLOCAddAre() {
    $tFNAreID = $('#ocmFNAreID :selected');
    $tFNPvnID = $('#ocmFNPvnID :selected');
    $tFNDstID = $('#ocmFNDstID :selected');

    if ($('#otbAre #otdFNDstID:contains(' + $tFNDstID.text() + ')').length == 0) {
        $tHtml = '<tr id="otr'
                + $tFNAreID.val()
                + $tFNPvnID.val()
                + $tFNDstID.val()
                + '"><td>'
                + $tFNAreID.text()
                + '<input type="hidden" name="ohdFNAreID[]" value="'
                + $tFNAreID.val()
                + '"></td><td>'
                + $tFNPvnID.text()
                + '<input type="hidden" name="ohdFNPvnID[]" value="'
                + $tFNPvnID.val()
                + '"></td><td id="otdFNDstID">'
                + $tFNDstID.text()
                + '<input type="hidden" name="ohdFNDstID[]" value="'
                + $tFNDstID.val()
                + '"></td><td style="text-align: center;"><a href="javascript:void(0)" onclick="javascript: $(\'#otr'
                + $tFNAreID.val()
                + $tFNPvnID.val()
                + $tFNDstID.val()
                + '\').remove();"><i class="fa fa-trash-o fa-lg"></i></a></td></tr>';
        $('#otbAre tbody').append($tHtml);
        $('#otbAre tbody #otr').hide();
    }

}

function JSxLOCEditAre() {
    $tFNAreID = $('#ocmEtFNAreID :selected');
    $tFNPvnID = $('#ocmEtFNPvnID :selected');
    $tFNDstID = $('#ocmEtFNDstID :selected');
    $tHtml = '<tr id="otr'
            + $tFNAreID.val()
            + $tFNPvnID.val()
            + $tFNDstID.val()
            + '"><td>'
            + $tFNAreID.text()
            + '<input type="hidden" name="ohdFNAreID[]" value="'
            + $tFNAreID.val()
            + '"></td><td>'
            + $tFNPvnID.text()
            + '<input type="hidden" name="ohdFNPvnID[]" value="'
            + $tFNPvnID.val()
            + '"></td><td>'
            + $tFNDstID.text()
            + '<input type="hidden" name="ohdFNDstID[]" value="'
            + $tFNDstID.val()
            + '"></td><td><a href="#" onclick="javascript: $(\'#otr'
            + $tFNAreID.val()
            + $tFNPvnID.val()
            + $tFNDstID.val()
            + '\').remove();"><i class="fa fa-trash-o" aria-hidden="true" style="color: #087380"></i> ลบ</a></td></tr>';
    $('#otbAre tbody').append($tHtml);
    $('#otbAre tbody #otr').hide();
    $('#modal-area2').modal('hide');
}

/**
 * JS for layout
 */
function clear_selected_all_pin() {
    $('#container_hotspot').find('.bg-pin').removeClass('pin-selected');
    $('#container_hotspot').find('.bg-pin').addClass('pin-unselected');
    $('input[name=\'product_id\']').val('');
    $('#color_code').val('FF0000');
}

function clicked_on_pin() {
    $('.pin.clicked').click(
            function (e) {
                var area_selected_id = $(this).attr('id');
                var visible_input = $('#kv_mark').find('#' + area_selected_id)
                        .attr('data-visible');
                var color_input = $('#kv_mark').find('#' + area_selected_id)
                        .attr('data-color');
                var color_code_select = color_input != ''
                        || color_input != 'undefined' ? color_input : 'fa0606';

                $('select[id=visibility]').val(visible_input);
                $('input[id=color_code]').val(color_code_select);
                clear_selected_all_pin();

                if ($(this).find('.bg-pin').hasClass('pin-selected')) {
                    $(this).find('.bg-pin').removeClass('pin-selected');
                    $(this).find('.bg-pin').addClass('pin-unselected');
                } else {
                    $(this).find('.bg-pin').removeClass('pin-unselected');
                    $(this).find('.bg-pin').addClass('pin-selected');
                }

                $('#position').attr('value', area_selected_id);

                $("#dialog").dialog("open");
                e.stopImmediatePropagation();
            });
}

function dragable_point(container_area) {
    $('.draggable').draggable({
        containment: container_area,
        start: function () {

        },
        stop: function (event, ui) {
            $(event.toElement).one('click', function (e) {
                e.stopImmediatePropagation();
            });
        }
    });
}

function ShowInformation(id) {
    $('#' + id).attr('title', $('#' + id).data('zone') + ' 300-500 Bath');
}

function JSxLOCDelImg(nImgID, tImgObj, tMsg) {
    bootbox.confirm({
        title: 'ยืนยันการลบข้อมูล',
        message: tMsg,
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
                    url: "EticketDelImgLoc",
                    data: {
                        tImgID: nImgID,
                        tNameImg: tImgObj,
                    },
                    cache: false,
                    success: function (msg) {
                        // console.log(msg);
                        $('#oimImgMasterMain').attr("src","application/modules/common/assets/images/Noimage.png");
                        $('#oDelImgLoc').hide();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}

function FSxLocDayOff(nFNLocID) {
    $('.icon-loading').show();
    $.ajax({
        type: "POST",
        url: "EticketDayOff",
        data: {
            nFNLocID: nFNLocID
        },
        cache: false,
        success: function (msg) {
            $('#ooResultDayOff').html(msg);
            $('.icon-loading').hide();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxLocEditDayoff(nFNLdoID, tFDLdoDateFrm, tFDLdoDateTo, tFTLdoRmk) {
    $('#ohdFNLdoID').val(nFNLdoID);
    $('#odtFDLdoDateFrmEdit').val(tFDLdoDateFrm);
    $('#odtFDLdoDateToEdit').val(tFDLdoDateTo);
    $('#odtFDLdoDateToEdit').val(tFDLdoDateTo);
    $('#otaFTLdoRmkEdit').val(tFTLdoRmk);
    $('#otaFTLdoRmkEdit').html(tFTLdoRmk);
}

function JSxLocDelDayoff(nFNLdoID, nFNLocID) {
    bootbox.confirm({
        message: "Are you sure to delete this item?",
        callback: function (tResult) {
            if (tResult == true) {
                $.ajax({
                    type: "POST",
                    url: "EticketDelDayOff",
                    data: {
                        nFNLdoID: nFNLdoID
                    },
                    cache: false,
                    success: function (msg) {
                        FSxLocDayOff(nFNLocID);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}

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
        url: "EticketDeleteLocation",
        data: {
            'tId': ocbListItem.join()
        },
        cache: false,
        success: function (msg) {
            
            $('#ospPageActive').text(pnPage);
            JSxLocCountSearch(pnPage);

            $('.modal-backdrop').remove(); 
            $('.obtChoose').hide(); 
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
          
        },
        error: function (data) {
            console.log(data);
        }
    });
    // var ocbListItem = [];
    // var ocbListName = [];
    // $('.ocbListItem:checked').each(function (i, e) {
    //     ocbListName.push($(this).data('name'));
    // });
    // bootbox.confirm({
    //     title: aLocale['tConfirmDelete'],
    //     message: aLocale['tConfirmDeletionOf'] + ' ' + ocbListName.join(),
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
    //     callback: function (result) {
    //         if (result == true) {
    //             $('.ocbListItem:checked').each(function (i, e) {
    //                 ocbListItem.push($(this).val());
    //             });
    //             $.ajax({
    //                 type: "POST",
    //                 url: "EticketDeleteLocation",
    //                 data: {
    //                     'tId': ocbListItem.join()
    //                 },
    //                 cache: false,
    //                 success: function (msg) {
    //                     JSxLocCountSearch();
    //                     $('.obtChoose').hide();
    //                 },
    //                 error: function (data) {
    //                     console.log(data);
    //                 }
    //             });
    //         }
    //     }
    // });
}


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



function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

