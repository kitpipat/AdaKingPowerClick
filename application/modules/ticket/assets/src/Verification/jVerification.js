// ข้อมูลหน้า ก่อนหน้า
function JSxVerPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageActiveVer').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActiveVer').text(nPreviousPage);
    JSxVerListView();
}

// ข้อมูลหน้า หน้าถัดไป
function JSxVerForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageActiveVer').text();
    var nTotalPage = $('#ospTotalPageVer').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActiveVer').text(nForwardPage);
    JSxVerListView();
}

function JSvPClickPage(tNumPage) {
    $('#ospPageActiveVer').text(tNumPage);
    JSxVerListView();
}

// แสดงข้อมูลสาขา
function JSxVerListView(nPageNo) {
    JCNxOpenLoading();
    var tFTBnkCode = $('#ocmFTBnkCode').val();
    var tFDDate = $('#oetFDDate').val();
    var tFTShdDocNo = $('#oetFTShdDocNo').val();
    var nPageNo = $('#ospPageActiveVer').text();
    $('.xCNOverlay').show();
    $.ajax({
        type: "POST",
        url: "EticketVerificationAjaxList",
        data: {tFTBnkCode: tFTBnkCode, tFDDate: tFDDate, tFTShdDocNo: tFTShdDocNo, nPageNo: nPageNo},
        cache: false,
        success: function (msg) {
            $('#oResultVer').html(msg);
            var ospPageActiveVer = $('#ospPageActiveVer').text();
            var ospTotalPageVer = $('#ospTotalPageVer').text();
            var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxVerPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
                for (i = 0; i < parseInt(ospTotalPageVer); i++) {
                    l = i + 1;
                    if (parseInt(ospPageActiveVer) == l) {
                        tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                    } else {
                        tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                    }
                }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxVerForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

                $('.xWGridFooter').html(tHtml);
                if (ospPageActiveVer == '1') {
                    $('#oPreviousPage').attr('disabled',true);
                } else {
                    $('#oPreviousPage').attr('disabled',false);
                }
                if (ospPageActiveVer == ospTotalPageVer) {
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


// นับจำนวนค้นหาสาขา
function JSxVerCount(pnPage) {
    var tFTBnkCode = $('#ocmFTBnkCode').val();
    var tFDDate = $('#oetFDDate').val();
    var tFTShdDocNo = $('#oetFTShdDocNo').val();
    $('.xCNOverlay').show();
    $.ajax({
        type: "POST",
        url: "EticketVerificationCount",
        data: {tFTBnkCode: tFTBnkCode, tFDDate: tFDDate, tFTShdDocNo: tFTShdDocNo},
        cache: false,
        success: function (msg) {
            $('#ospTotalRecordVer').text(msg);
            $('#ospPageActiveVer').text('1');
            $('#ospTotalPageVer').text(Math.ceil(parseInt(msg) / 8));
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
            if(pnPage != 1 && pnPage != $('#ospTotalPageVer').text()){
                var nPageAll = pnPage;
                var nPageTotal = nPageAll - 1 ;
                pnPage = nPageTotal;
                $('#ospPageActiveVer').text(pnPage);
            }else{
                $('#ospPageActiveVer').text(pnPage);
            }

            // $('#ospPageActiveVer').text(pnPage);
            JSxVerListView(pnPage);
            JSxCheckPinMenuClose();
            $('.xCNOverlay').hide();
        },
        error: function (data) {
            console.log(data);
            $('.xCNOverlay').hide();
        }
    });
}
function FSxCheckVerification(tShdDocNo) {
    var tImgObj = $('#ohdImgObj' + tShdDocNo).val();
    var tShdDocNo = $('#ohdShdDocNo' + tShdDocNo).val();
    var tBnkName = $('#ohdBnkName' + tShdDocNo).val();
    var tPmoName = $('#ohdPmoName' + tShdDocNo).val();
    var tShdDocDate = $('#ohdShdDocDate' + tShdDocNo).val();
    var tFAmt = $('#ohdFAmt' + tShdDocNo).val();
    var tAmt = $('#ohdAmt' + tShdDocNo).val();
    var tCstName = $('#ohdCstName' + tShdDocNo).val();
    var tCstTel = $('#ohdCstTel' + tShdDocNo).val();
    $('#oImgObj').attr('src', tImgObj);
    $('#oetFTShdDocN').val(tShdDocNo);
    $('#oetFTBnkName').val(tBnkName);
    $('#oetFDShdDocDate').val(tShdDocDate);
    $('#oetFCSrcFAmt').val(tFAmt);
    $('#oetFTCstName').val(tCstName);
    $('#oetFTPmoName').val(tPmoName);
    $('#oetFCSrcAmt').val(tAmt);
    $('#oetFTCstTel').val(tCstTel);
    $('#oModalBankVerification').modal('show');
}
function FSxVerification(nPageNo) {
    var tFAmt = $('#oetFCSrcFAmt').val();
    var tNet = $('#oetFCSrcNet').val();
    if (parseInt(tFAmt) > parseInt(tNet)) {
        bootbox.alert({
            title: aLocale['tWarning'],
            message: aLocale['tTheAmountReceivedShouldNotBeLessThanTheOrder'],
            callback: function () {
                $('.bootbox').modal('hide');
            }
        });
    } else if (tNet == '') {
        bootbox.alert({
            title: aLocale['tWarning'],
            message: aLocale['tTheAmountReceivedShouldNotBeEmpty'],
            callback: function () {
                $('.bootbox').modal('hide');
            }
        });
    } else {
        var tFTShdDocNo = $('#oetFTShdDocN').val();
        var tFTCstKeyAccess = $('#ohdCstKeyAccess' + tFTShdDocNo).val();
        var tFTCstEmail = $('#ohdCstEmail' + tFTShdDocNo).val();
        $('.xCNOverlay').show();
        $.ajax({
            type: "POST",
            url: "EticketVerificationApprove",
            data: {
                tFTShdDocNo: tFTShdDocNo,
                tFCSrcNet: tNet,
                tFTCstKeyAccess: tFTCstKeyAccess,
                tFTCstEmail: tFTCstEmail
            },
            cache: false,
            success: function (msg) {
                $('#oModalBankVerification').modal('hide');
                
                $('#ospPageActiveVer').text(nPageNo);
                JSxVerCount(nPageNo);
                $('.xCNOverlay').hide();
            },
            error: function (data) {
                console.log(data);
                $('.xCNOverlay').hide();
            }
        });
    }
}
function FSxCallCancelTicket(pnPage) {
        var ohdImgObj = $('#ohdImgObj').val();
        bootbox.confirm({
            title: aLocale['tConfirmTicketCancellation'],
            message: aLocale['tAreYouSureToCancelThisTicket'],
            buttons: {
                cancel: {
                    label: aLocale['tBtnConfirm'],
                    className: 'xCNBTNPrimery'
                },
                confirm: {
                    label:  aLocale['tBtnClose'],
                    className: 'xCNBTNDefult'
                }
            },
        callback: function (result) {
            if (result == false) {
                var tFTShdDocNo     = $('#oetFTShdDocN').val();
                var tFTTxhRsnCode   = $('#ocmFTTxhRsnCode').val();
                var tFTCstEmail     = $('#ohdFTCstEmail').val();
                var tFTTxhRsnText   = $("#ocmFTTxhRsnCode option:selected").text();
                if (tFTTxhRsnCode == '') {
                    bootbox.alert({
                        title: aLocale['tWarning'],
                        message: aLocale['tPleaseSelectAReasonForCancellation'],
                        callback: function () {
                            $('.bootbox').modal('hide');
                        }
                    });
                } else {
                    $('.xCNOverlay').show();
                    $.ajax({
                        type: "POST",
                        url: "EticketCancelTicket",
                        data: {
                            tFTCstEmail: tFTCstEmail,
                            tFTShdDocNo: tFTShdDocNo,
                            tFTTxhRsnText: tFTTxhRsnText,
                            tFTTxhRsnCode: tFTTxhRsnCode
                        },
                        cache: false,
                        success: function (tResult) {
                            aResult = JSON.parse(tResult);
                            nStatus = aResult.status;
                            tMsg = aResult.msg;
                            if (nStatus == 1) {
                                JSxAGECancellationCount(pnPage);

                            }else{
                                bootbox.alert({
                                    title: aLocale['tWarning'],
                                    // message: tMsg,
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
                            $('.xCNOverlay').hide();
                        }
                    });
                }

            }
        }
    });
}


// ข้อมูลหน้า ก่อนหน้า
function JSxTclPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActive').text(nPreviousPage);
    JSxTicketCancellationListView();
}

// ข้อมูลหน้า หน้าถัดไป
function JSxTclForwardPage() {
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
    JSxTicketCancellationListView();
}

function JSvCLClickPage(tNumPage) {
    $('#ospPageActive').text(tNumPage);
    JSxTicketCancellationListView();
}

//แสดงข้อมูลค้นหา
function JSxTicketCancellationListView(nPageNo) {
    JCNxOpenLoading();
    var nPageNo     =     $('#ospPageActive').text();
    var tFTShdDocNo = $('#oetFTShdDocNo').val();
    $.ajax({
        type: "POST",
        url: "EticketTicketCancellationAjax",
        data: {
               tFTShdDocNo: tFTShdDocNo,
               nPageNo: nPageNo 
              },
        cache: false,
        success: function (msg) {
            $('#oResultTicketCancellation').html(msg);
            var tPageActive = $('#ospPageActive').text();
            var tTotalPage = $('#ospTotalPage').text();
            var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxTclPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(tTotalPage); i++) {
                l = i + 1;
                if (parseInt(tPageActive) == l) {
                    tHtml += '<button onclick="JSvCLClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvCLClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxTclForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';
            $('.xWGridFooter').html(tHtml);
            if (tPageActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (tPageActive == tTotalPage) {
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


function FSxCheckCancellation(tShdDocNo) {
    var tImgObj = $('#ohdImgObj' + tShdDocNo).val();
    var tShdDocNo = $('#ohdShdDocNo' + tShdDocNo).val();
    var tBnkName = $('#ohdBnkName' + tShdDocNo).val();
    var tPmoName = $('#ohdPmoName' + tShdDocNo).val();
    var tShdDocDate = $('#ohdShdDocDate' + tShdDocNo).val();
    var tFAmt = $('#ohdFAmt' + tShdDocNo).val();
    var tAmt = $('#ohdAmt' + tShdDocNo).val();
    var tCstName = $('#ohdCstName' + tShdDocNo).val();
    var tCstTel = $('#ohdCstTel' + tShdDocNo).val();
    var tUsrName = $('#ohdUsrName' + tShdDocNo).val();
    var tSrcNet = $('#ohdSrcNet' + tShdDocNo).val();
    var tChkPay = $('#ohdChkPay' + tShdDocNo).val();
    var tEmail = $('#ohdCstEmail' + tShdDocNo).val();
    $('#oImgObj').attr('src', tImgObj);
    $('#oetFTShdDocN').val(tShdDocNo);
    $('#oetFTBnkName').val(tBnkName);
    $('#oetFDShdDocDate').val(tShdDocDate);
    $('#oetFCSrcFAmt').val(tFAmt);
    $('#oetFTCstName').val(tCstName);
    $('#oetFTPmoName').val(tPmoName);
    $('#oetFCSrcAmt').val(tAmt);
    $('#oetFTCstTel').val(tCstTel);
    $('#oetFTUsrName').val(tUsrName);
    $('#oetFCSrcNet').val(tSrcNet);
    $('#oetFDTxhChkPay').val(tChkPay);
    $('#ohdFTCstEmail').val(tEmail);
    $('#oModalTicketCancellation').modal('show');
}



function JSxAGECancellationCount(pnPage) {
    var tFTShdDocNo = $('#oetFTShdDocNo').val();
    if (tFTShdDocNo == "") {
        var tFTShdDocNo = '';
    } else {
        var tFTShdDocNo = tFTShdDocNo;
    }
    $('.xCNOverlay').show();
    $.ajax({
        type: "POST",
        url: "EticketTicketCancellation_Count",
        data: {
            tFTShdDocNo : tFTShdDocNo
        },
        cache: false,
        success: function (msg) {
            $('#ospTclTotalRecord').text(msg);
            $('#ospPageActive').text('1');
            $('#ospTotalPage').text(Math.ceil(parseInt(msg) / 8));
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

            // $('#ospPageActive').text(pnPage);
            JSxTicketCancellationListView(pnPage);
            $('#oModalTicketCancellation').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            JSxCheckPinMenuClose();
            $('.xCNOverlay').hide();
        },
        error: function (data) {
            console.log(data);
            $('.xCNOverlay').hide();
        }
    });
}