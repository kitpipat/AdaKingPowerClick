// ข้อมูลหน้า ก่อนหน้า
function JSxBifPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageActiveBif').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActiveBif').text(nPreviousPage);
    JSxBifListView();
}

// ข้อมูลหน้า หน้าถัดไป
function JSxBifForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageActiveBif').text();
    var nTotalPage = $('#ospTotalPageBif').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActiveBif').text(nForwardPage);
    JSxBifListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageActiveBif').text(tNumPage);
    JSxBifListView();
}

// แสดงข้อมูลสาขา
function JSxBifListView(pnPage) {
    var tFTBifName = $('#oetSCHFTBifName').val();
    var nPageNo = $('#ospPageActiveBif').text();
    $.ajax({
        type: "POST",
        url: "EticketBankInfoList",
        data: {tFTBifName: tFTBifName, nPageNo: nPageNo},
        cache: false,
        success: function (msg) {
            $('#oResultBif').html(msg);
            var ospPageActiveBif = $('#ospPageActiveBif').text();
            var ospTotalPageBif = $('#ospTotalPageBif').text();
            var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxBifPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPageBif); i++) {
                l = i + 1;
                if (parseInt(ospPageActiveBif) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxBifForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageActiveBif == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActiveBif == ospTotalPageBif) {
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
// ลบภาพ
function JSxBifDelImg(nImgID, tImgObj, tMsg) {
    if (confirm(tMsg) == true) {
        $.ajax({
            type: "POST",
            url: "EticketBankInfoDelImg",
            data: {
                tImgID: nImgID,
                tNameImg: tImgObj,
                tImgType: 9
            },
            cache: false,
            success: function (msg) {
                $('#oimImgMasterMain').attr("src", "application/modules/common/assets/images/Noimage.png");
                $('#oDelImgBif').hide();
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
    return false;
}

// นับจำนวนค้นหาสาขา
function JSxBifCount(pnPage) {
    var tFTBifName = $('#oetSCHFTBifName').val();
    if (tFTBifName == "") {
        var tBifName = '';
    } else {
        var tBifName = tFTBifName;
    }
    var nLocID = $('#ohdGetLocID').val();
    $('.xCNOverlay').show();
    $.ajax({
        type: "POST",
        url: "EticketBankInfoCount",
        data: {tFTBifName: tBifName},
        cache: false,
        success: function (msg) {
            $('#ospPageActiveBif').text('1');
            $('#ospTotalRecordBif').text(msg);
            $('#ospTotalPageBif').text(Math.ceil(parseInt(msg) / 8));
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
            if(pnPage != 1 && pnPage != $('#ospTotalPageBif').text()){
                var nPageAll = pnPage;
                var nPageTotal = nPageAll - 1 ;
                pnPage = nPageTotal;
                $('#ospPageActiveBif').text(pnPage);
            }else{
                $('#ospPageActiveBif').text(pnPage);
            }

            // $('#ospPageActiveBif').text(pnPage);
            JSxBifListView(pnPage);

            JSxCheckPinMenuClose();
            $('.xCNOverlay').hide();
        },
        error: function (data) {
            console.log(data);
            $('.xCNOverlay').hide();
        }
    });
}

function JSxBankInfoDel(pnPage,tBifID, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + tBifID + ' ('+tMsg+') ',
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
                    url: "EticketBankInfoDel",
                    data: {
                        ptBifId  : tBifID
                    
                    },
                    cache: false,
                    success: function (tResult) {
                    aResult = JSON.parse(tResult);
                    nCount = aResult.status;
                    tMsg = aResult.msg;
                    if (nCount == 1) {
                        $('#ospPageActiveBif').text(pnPage);
                        JSxBifCount(pnPage);
                    }else{
                        bootbox.alert({
                            title: aLocale['tWarning'],
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
        url: "EticketBankInfoDelCheckBox",
        data: {
            'nFTBbkCode': ocbListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('#ospPageActiveBif').text(pnPage);
            JSxBifCount(pnPage);
            $('.modal-backdrop').remove(); 
            $('.obtChoose').hide(); 
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        },
        error: function (data) {
            console.log(data);
        }
    });
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