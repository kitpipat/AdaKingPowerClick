<script>
    $('document').ready(function(){
        JSxABBPageProductDataTable();

        let cCententPointHeight     = $('#odvCSSPointsInfo').height();
        let cCententReceiveHeight   = $('#odvCSSReceiveInfo').height();

        if( cCententReceiveHeight < cCententPointHeight ){
            $('#odvCSSReceiveInfo').height(cCententPointHeight);
        }else{
            $('#odvCSSPointsInfo').height(cCententReceiveHeight);
        }

        // $('#obtABBConfirmApvDoc').off('click').on('click',function(){
        //     JSxABBApproveDoc(true);
        // })

    });

    $('#obtABBSubmitFromDoc').off('click').on('click',function(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docABBEventMoveTmpToDT",
            data: {
                ptDocNo       : $('#odvABBDocNo').text(),
                ptDocVatFull  : $('#ohdABBXshDocVatFull').val(),
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                if ( aReturnData['nStaEvent'] == '1' ) {
                    JSxABBPageProductDataTable();
                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });

    function JSxABBPageProductDataTable(){
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $(".modal-backdrop").remove();
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docABBPagePdtDataTable",
                    data: {
                        ptDocNo: $('#odvABBDocNo').text(),
                        ptSearch: $('#oetABBFilterPdt').val()
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if ( aReturnData['nStaEvent'] == '1' ) {
                            $('#odvABBProductDataTableContent').html(aReturnData['tViewPdtDataTable']);

                            JSxABBEventSetEndOfBill(aReturnData['aEndOfBill']);

                            var tXshDocType = '<?=$nXshDocType?>';
                            if( tXshDocType != '1' ){
                                $('.xWABBShwSNList').html('-');
                            } 

                            // $('#obtABBChkPdtSN').hide();
                            // $('#obtABBApproveDoc').hide();

                            // var tXshStaApv   = '<?=$tXshStaApv?>';
                            // if( tXshStaApv != '2' ){                                    // ตรวจสอบสถานะอนุมัติเอกสารใบขาย
                            //     $('.xWABBHideObj').hide();
                            // }else{
                            //     $('.xWABBHideObj').show();
                            // }

                            // var nCountSerial = aReturnData['nCountSerial'];
                            // if( nCountSerial == 0 ){                                    // ตรวจสอบว่ามีสินค้าที่ยังไม่ได้ระบุ S/N ไหม ?
                            //     $('#obtABBChkPdtSN').hide();
                            //     if( tXshStaApv == '2' ){
                            //         $('#obtABBApproveDoc').show();
                            //     }
                            // }else{
                            //     if( tXshStaApv == '2' ){
                            //         $('#obtABBChkPdtSN').show();

                            //         var tStaFirstEnter = $('#ohdABBStaFirstEnter').val(); // เข้ามาหน้า Add/Edit ครั้งแรกให้เปิด modal ระบุ S/N
                            //         if( tStaFirstEnter == '1' ){
                            //             $('#obtABBChkPdtSN').click();
                            //             $('#ohdABBStaFirstEnter').val('2');
                            //         }
                            //     }
                            //     $('#obtABBApproveDoc').hide();
                            // }

                            JCNxLayoutControll();
                            JCNxCloseLoading();
                            $('.xCNBody').css("padding-right", "0px");
                        } else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (oErr) {
            FSvCMNSetMsgWarningDialog(oErr.message);
        }
    }

    // function JSxABBEventGetDataPdtSN(){
    //     $.ajax({
    //         type: "POST",
    //         url: "docABBEventGetDataPdtSN",
    //         data: {
    //             ptDocNo       : $('#odvABBDocNo').text(),
    //             ptScanBarCode : $('#oetABBScanBarCode').val()
    //         },
    //         cache: false,
    //         timeout: 0,
    //         success: function(oResult) {
    //             var aReturnData = JSON.parse(oResult);
    //             if( aReturnData['nStaEvent'] == '1' ){
    //                 localStorage.setItem("aDataPdtSN", JSON.stringify(aReturnData['aDataPdtSN']['aItems']));
    //                 JSxABBEventRenderPdtSN(1);
    //             }else{
    //                 var tMessageError = aReturnData['tStaMessg'];
    //                 FSvCMNSetMsgErrorDialog(tMessageError);
    //             }
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // }

    // function JSxABBEventRenderPdtSN(pnRow){
    //     var aDataPdtSN   = JSON.parse(localStorage.getItem("aDataPdtSN"));
    //     var nDataSize    = aDataPdtSN.length;
    //     var nRow         = pnRow - 1;
    //     var tCountPdtSN  = "";
    //     var tViewHtml    = "";
    //     var tStaDisabled = "";
    //     // console.log(aDataPdtSN);

    //     if( pnRow <= nDataSize ){
    //         tViewHtml += '<div class="mb-3 row">';
    //         tViewHtml += '   <input type="hidden" id="oetABBPdtCode" name="oetABBPdtCode" value="'+aDataPdtSN[nRow]['FTPdtCode']+'">';
    //         tViewHtml += '   <label class="col-md-12 col-form-label"><strong>ชื่อสินค้า</strong> : <strong style="font-size:25px;">'+aDataPdtSN[nRow]['FTXsdPdtName']+'</strong></label>';
    //         // tViewHtml += '   <div class="col-md-12" style="padding-left:25px;padding-right:25px;">'+aDataPdtSN[nRow]['FTXsdPdtName']+'</div>';
    //         tViewHtml += '</div>';

    //         tViewHtml += '<div class="mb-3 row">';
    //         tViewHtml += '   <label class="col-md-12 col-form-label"><strong>บาร์โค้ด</strong> : '+aDataPdtSN[nRow]['FTXsdBarCode']+'</label>';
    //         // tViewHtml += '   <div class="col-md-12" style="padding-left:25px;padding-right:25px;">'+aDataPdtSN[nRow]['FTXsdBarCode']+'</div>';
    //         tViewHtml += '</div>';

    //         tViewHtml += '<div class="mb-3 row">';
    //         tViewHtml += '   <label class="col-md-12 col-form-label"><strong>รหัสซีเรียล</strong></label>';
    //         tViewHtml += '   <div class="col-md-12"><input type="text" class="form-control" id="oetABBSerialNo" name="oetABBSerialNo" placeholder="รหัสซีเรียล" maxlength="50" autocomplete="off" onkeyup="Javascript:if(event.keyCode==13) JSxABBEventUpdatePdtSNTmp()" ></div>';
    //         tViewHtml += '</div>';
            
    //         $('#obtABBConfirmChkPdtSN').attr('data-nextrow',parseInt(pnRow) + 1);
    //         $('#odvABBCountPdtSN').html('รายการสินค้าตัวที่ '+pnRow+' จากรายการทั้งหมด '+nDataSize+' รายการ');
    //         $('#odvABBPdtSNList').html(tViewHtml);
    //         $('#odvABBModalChkPdtSN').modal('show');
    //         // $('#oetABBSerialNo').focus();
    //         // $('#oetABBScanBarCode').focus();
    //         setTimeout(function(){ $('#oetABBSerialNo').focus(); }, 1000);
            
    //     }else{
    //         $('#odvABBModalChkPdtSN').modal('hide');
    //         JSxABBPageProductDataTable();
    //     }
    // }

    // function JSxABBEventScanPdtSN(){
    //     var tScanBarCode = $('#oetABBScanBarCode').val();
    //     var aDataPdtSN   = JSON.parse(localStorage.getItem("aDataPdtSN"));
    //     var nDataSize    = aDataPdtSN.length;
    //     var nIndexFound  = nDataSize + 1;

    //     for( var i = 0; i < nDataSize; i++ ){
    //         if( aDataPdtSN[i]['FTXsdBarCode'] == tScanBarCode ){
    //             nIndexFound = i + 1;
    //         }
    //     }

    //     if( nIndexFound <= nDataSize ){
    //         JSxABBEventRenderPdtSN(nIndexFound);
    //     }else{
    //         FSvCMNSetMsgErrorDialog('ไม่พบรหัสบาร์โค้ด');
    //     }
    //     $('#oetABBScanBarCode').val('');

    // }

    // function JSxABBEventUpdatePdtSNTmp(){
    //     var tSerialNo = $('#oetABBSerialNo').val();
    //     if( tSerialNo != "" ){
    //         $.ajax({
    //             type: "POST",
    //             url: "docABBEventUpdatePdtSNTmp",
    //             data: {
    //                 ptDocNo       : $('#odvABBDocNo').text(),
    //                 ptPdtCode     : $('#oetABBPdtCode').val(),
    //                 ptSerialNo    : tSerialNo
    //             },
    //             cache: false,
    //             timeout: 0,
    //             success: function(oResult) {
    //                 var nNextRow = $('#obtABBConfirmChkPdtSN').attr('data-nextrow');
    //                 JSxABBEventRenderPdtSN(nNextRow);
    //                 // var aReturnData = JSON.parse(oResult);
    //                 // if( aReturnData['nStaEvent'] == '1' ){
    //                 //     localStorage.setItem("aDataPdtSN", JSON.stringify(aReturnData['aDataPdtSN']['aItems']));
    //                 //     JSxABBEventRenderPdtSN(1);
    //                 // }else{
    //                 //     var tMessageError = aReturnData['tStaMessg'];
    //                 //     FSvCMNSetMsgErrorDialog(tMessageError);
    //                 // }
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });
    //     }else{
    //         $('#oetABBSerialNo').focus();
    //     }
    // }

    // $('#obtABBChkPdtSN').off('click').on('click',function(){
    //     $('#oetABBScanBarCode').val('');
    //     JSxABBEventGetDataPdtSN();
    // });

    // $('#obtABBConfirmChkPdtSN').off('click').on('click',function(){
    //     JSxABBEventUpdatePdtSNTmp();
    // });

    // $('#obtABBCancelChkPdtSN').off('click').on('click',function(){
    //     JSxABBPageProductDataTable();
    // });
    
    // $('#obtABBApproveDoc').off('click').on('click',function(){
    //     JSxABBApproveDoc(false);
    // });

    $('#obtABBDownloadFullTax').off('click').on('click',function(){
        JCNxOpenLoading();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                var tStaETax = $('#obtABBDownloadFullTax').attr('data-staetax');
                if( tStaETax == '1' ){
                    var tETaxStatus = $('#obtABBDownloadFullTax').attr('data-etaxstatus');
                    if( tETaxStatus == '1' || tETaxStatus == '2' ){
                        // Call Full Tax
                        $.ajax({
                            type: "POST",
                            url: "cenEventCallApiETAX",
                            data: {
                                ptTaxDocNo : $('#ohdABBXshDocVatFull').val(),
                                ptTaxType  : 'FullTax'
                            },
                            cache: false,
                            timeout: 0,
                            success: function(oResult) {
                                var aReturnData = JSON.parse(oResult);
                                if ( aReturnData['tReturnCode'] == '1' ) {
                                    $('.xWABBOnDownloadFullTax').attr('href',aReturnData['tReturnData']['pdfURL']);
                                    $('.xWABBOnDownloadFullTax').attr('download',aReturnData['tReturnData']['pdfURL']);
                                    $('.xWABBOnDownloadFullTax')[0].click();
                                    
                                    var tABBFullTaxTextBtn = '<?=language('document/checkstatussale/checkstatussale', 'tABBBtnDownload'.$tXshDocType.'FullTax');?>';
                                    $('#obtABBDownloadFullTax').html(tABBFullTaxTextBtn);
                                }else{
                                    var tMsgError = "(" + aReturnData['tReturnCode'] + ") " + aReturnData['tReturnMsg'];
                                    FSvCMNSetMsgWarningDialog(tMsgError);
                                }
                                JCNxCloseLoading();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxResponseError(jqXHR, textStatus, errorThrown);
                            }
                        });
                    }else{
                        // Call Page Add Full Tax
                        $.ajax({
                            type    : "POST",
                            url     : "dcmTXIN/1/0",
                            data    : {
                                'tDocNo'   : $('#ohdABBXshDocVatFull').val(),
                                'tBchCode' : $('#ohdABBBchCode').val()
                            },
                            cache   : false,
                            Timeout : 0,
                            success : function (oResult) {
                                $('.odvMainContent').html(oResult);
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                JCNxResponseError(jqXHR, textStatus, errorThrown);
                            }
                        });
                    }
                }else{
                    // เรียกรายงาน Full Tax
                    var tBCH            = '<?=FCNtGetAddressBranch($tBchCode)?>';
                    var tDocCode        = $('#ohdABBXshDocVatFull').val();
                    var tDocBCH         = $('#ohdABBBchCode').val();
                    var tGrandText      = $("#odvABBDataTextBath").text().trim();
                    var tOrginalRight   = 1;
                    var tCopyRight      = 0;
                    var tPrintByPage    = "ALL";
                    var aInfor = [
                        {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'},
                        {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'},
                        {"BranchCode"   : tBCH},
                        {"DocCode"      : tDocCode},
                        {"DocBchCode"   : tDocBCH}
                    ];
                    var nXshDocType = '<?=$nXshDocType?>';
                    if( nXshDocType == '1' ){   //เอกสารขาย - Full Tax
                        $("#oifABBPrintFullTax").prop('src', "<?=base_url();?>formreport/TaxInvoice?StaPrint=1&infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText + "&PrintOriginal="+tOrginalRight + "&PrintCopy="+tCopyRight + "&PrintByPage="+tPrintByPage);
                    }else{                      //เอกสารคืน - CN Full Tax
                        $("#oifABBPrintFullTax").prop('src', "<?=base_url();?>formreport/TaxInvoice_refund?StaPrint=1&infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText + "&PrintOriginal="+tOrginalRight + "&PrintCopy="+tCopyRight + "&PrintByPage="+tPrintByPage);
                    }
                    JCNxCloseLoading();
                }
            } catch (oErr) {
                FSvCMNSetMsgWarningDialog(oErr.message);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtABBDownloadDoc').off('click').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                var tStaETax = $('#obtABBDownloadDoc').attr('data-staetax');
                if( tStaETax == '1' ){
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "cenEventCallApiETAX",
                        data: {
                            ptTaxDocNo : $('#odvABBDocNo').text(),
                            ptTaxType  : 'ABB'
                        },
                        cache: false,
                        timeout: 0,
                        success: function(oResult) {
                            var aReturnData = JSON.parse(oResult);
                            if ( aReturnData['tReturnCode'] == '1' ) {
                                $('.xWABBOnDownload').attr('href',aReturnData['tReturnData']['urlPdf']);
                                $('.xWABBOnDownload').attr('download',aReturnData['tReturnData']['urlPdf']);
                                $('.xWABBOnDownload')[0].click();

                                var tABBABBTextBtn = '<?=language('document/checkstatussale/checkstatussale', 'tABBBtnDownload'.$tXshDocType.'ABB');?>';
                                $('#obtABBDownloadDoc').html(tABBABBTextBtn);
                            }else{
                                var tMsgError = "(" + aReturnData['tReturnCode'] + ") " + aReturnData['tReturnMsg'];
                                FSvCMNSetMsgWarningDialog(tMsgError);
                            }
                            JCNxCloseLoading();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }else{
                    // เรียกรายงาน ABB
                    var tBCH            = '<?=FCNtGetAddressBranch($tBchCode)?>';
                    var tDocCode        = $('#odvABBDocNo').text().trim();
                    var tGrandText      = $("#odvABBDataTextBath").text().trim();
                    var tOrginalRight   = 0;
                    var tCopyRight      = 0;
                    var aInfor = [
                        {"Lang"         : '<?=FCNaHGetLangEdit(); ?>' },
                        {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>' },
                        {"BranchCode"   : tBCH },
                        {"DocCode"      : tDocCode },
                        {"DocBchCode"   : $('#ohdABBBchCode').val() }
                    ];
                    // console.log(aInfor);
                    JCNxOpenLoading();
                    $("#oifABBPrint").prop('src', "<?=base_url();?>formreport/InvoiceSaleABB?infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText + "&PrintOriginal="+tOrginalRight + "&PrintCopy="+tCopyRight + "&PrintByPage=" + 'ALL');
                    JCNxCloseLoading();
                }
            } catch (oErr) {
                FSvCMNSetMsgWarningDialog(oErr.message);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //อนุมัติเอกสาร
    // function JSxABBApproveDoc(pbIsConfirm) {
    //     var nStaSession = JCNxFuncChkSessionExpired();
    //     if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    //         try {
    //             if (pbIsConfirm) {
    //                 $('#odvABBModalAppoveDoc').modal("hide");
    //                 JCNxOpenLoading();
    //                 var tDocNo = $('#odvABBDocNo').text();
    //                 $.ajax({
    //                     type: "POST",
    //                     url: "docABBEventApproved",
    //                     data: {
    //                         ptDocNo : tDocNo,
    //                     },
    //                     cache: false,
    //                     timeout: 0,
    //                     success: function(oResult) {
    //                         var aReturnData = JSON.parse(oResult);
    //                         if ( aReturnData['nStaEvent'] != 1 ) {
    //                             FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
    //                             JCNxCloseLoading();
    //                             return;
    //                         }else{
    //                             JSxABBPageEdit(tDocNo);
    //                         }
    //                     },
    //                     error: function(jqXHR, textStatus, errorThrown) {
    //                         JCNxResponseError(jqXHR, textStatus, errorThrown);
    //                     }
    //                 });
    //             } else {
    //                 $('#odvABBModalAppoveDoc').modal("show");
    //             }
    //         } catch (oErr) {
    //             FSvCMNSetMsgWarningDialog(oErr.message);
    //         }
    //     } else {
    //         JCNxShowMsgSessionExpired();
    //     }
    // }

</script>