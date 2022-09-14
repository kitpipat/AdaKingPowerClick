// ข้อมูลหน้า ก่อนหน้า
function JSxSHTPreviousPage() {
    var nCurrentPage = $('#ospPageActiveShowTime').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActiveShowTime').text(nPreviousPage);
    JSxShowTimeListView();
}

// ข้อมูลหน้า หน้าถัดไป
function JSxSHTForwardPage() {
    var nCurrentPage = $('#ospPageActiveShowTime').text();
    var nTotalPage = $('#ospTotalPageShowTime').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActiveShowTime').text(nForwardPage);
    JSxShowTimeListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageActiveShowTime').text(tNumPage);
    JSxShowTimeListView();
}

// แสดงข้อมูลสาขา
function JSxShowTimeListView() {
    var nPageNo = $('#ospPageActiveShowTime').text();
    var tFTSHTALocName = $('#oetSHTLocName').val();
    var nEventID = $('#ohdGetEventId').val();
    $('.icon-loading').show();
    $.ajax({
        type: "POST",
        url: "EticketShowTimeLocLoadList",
        data: {
            tFTSHTALocName: tFTSHTALocName,
            nEventID: nEventID,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
            $('#oResultLocationShowTime').html(msg);
            $('.icon-loading').hide();
            var ospPageActiveShowTime = $('#ospPageActiveShowTime').text();
            var ospTotalPageShowTime = $('#ospTotalPageShowTime').text();
            var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxZnePreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPageShowTime); i++) {
                l = i + 1;
                if (parseInt(ospPageActiveShowTime) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxZneForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageActiveShowTime == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActiveShowTime == ospTotalPageShowTime) {
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
function JSxSHTCount() {
    var tFTSHTALocName = $('#oetSHTLocName').val();
    var nEventID = $('#ohdGetEventId').val();
    $.ajax({
        type: "POST",
        url: "EticketShowTimeLocCount",
        data: {
            tFTSHTALocName: tFTSHTALocName,
            nEventID: nEventID
        },
        cache: false,
        success: function (msg) {
            $('#ospTotalRecord').text(msg);
            $('#ospPageActiveShowTime').text('1');
            $('#ospTotalPageShowTime').text(Math.ceil(parseInt(msg) / 5));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxShowTimeListView();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxSHTSearch() {
    JCNxOpenLoading();
    var ocmPrkPmoID = $('#ocmPrkPmoID').val();
    var oetLocName = $('#oetLocName').val();
    var tGetEventId = $('#ohdGetEventId').val();
    if (ocmPrkPmoID != "") {
        $.ajax({
            url: 'EticketShowTimeLocList',
            data: {
                ocmPrkPmoID: ocmPrkPmoID,
                oetLocName: oetLocName,
                tGetEventId: tGetEventId,
            },
            method: "POST"
        }).success(function (tResault) {
            // console.log(tResault);
            $('#oResultLocShowTime').html(tResault);
             
        }).error(function (data) {
            console.log(data);
        });
    }
    JCNxCloseLoading(); 
}

function JSxSHTAddLoc() {
    if ($(".xWCBFNLocID").is(':checked')) {
        var oetFDShwStartDate = $('#oetFDShwStartDate').val();
        var oetFDShwEndDate = $('#oetFDShwEndDate').val();
        if (oetFDShwStartDate == "") {
            $('#oetFDShwStartDate').addClass('input-invalid');
        }
        if (oetFDShwEndDate == "") {
            $('#oetFDShwEndDate').addClass('input-invalid');
        }
        if (oetFDShwStartDate != "" && oetFDShwEndDate != "") {
            $('#oetFDShwStartDate').removeClass('input-invalid');
            $('#oetFDShwEndDate').removeClass('input-invalid');
            $.ajax({
                type: "POST",
                url: "EticketShowTimeAddLoc",
                data: $("#ofmShowTimeAddLoc").serialize(),
                cache: false,
                success: function (msg) {
                    var ohdGetEventId = $('#ohdGetEventId').val();
                    JSxCallPage('EticketShowTime/' + ohdGetEventId + '');
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

    } else {
        alert('กรุณาเลือกสถานที่');
    }
}

function FSxCSHTDelShowTime(nFNEvnID, nFNLocID, tMsg) {
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
                    url: "EticketDelShowTime",
                    data: {
                        nFNEvnID: nFNEvnID,
                        nFNLocID: nFNLocID
                    },
                    cache: false,
                    success: function (msg) {
                        window.onload = JSxSHTCount();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}
function FSxDelAllOnCheck(nFNEvnID) {
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
        url: "EticketDelShowTime",
        data: {
            nFNEvnID: nFNEvnID,
            nFNLocID: ocbListItem.join()
        },
        cache: false,
        success: function () {
            JSxCallPage('EticketShowTime/'+nFNEvnID)
            $('.modal-backdrop').remove(); 
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function FSxCSHTDelPackage(nFNPkgID, nEvnID, nLocID) {
    
        bootbox.confirm({
            title: aLocale['tConfirmDelete'],
            message: aLocale['tConfirmDeletionOf'] + ' '+nFNPkgID,
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
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "EticketShowTimeDelPackage",
                    data: {
                        nFNPkgID: nFNPkgID,
                        nEvnID: nEvnID
                    },
                    cache: false,
                    success: function (msg) {
                        
                        JSxCallPage('EticketShowTimePackageList/' + nEvnID + '/' + nLocID+'');
                        $('.icon-loading').hide();
                         
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                JCNxCloseLoading();
            }
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