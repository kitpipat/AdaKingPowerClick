<script>
    $('document').ready(function(){
        JSxCSSPageProductDataTable();

        $('#obtCSSConfirmApvDoc').off('click').on('click',function(){
            JSxCSSApproveDoc(true);
        });

        var tXshStaDelMQ = '<?=$tXshStaDelMQ?>';
        if( tXshStaDelMQ == '2' ){
            JSxCSSSubscribeMQ();
        }

        let cCententPointHeight     = $('#odvCSSPointsInfo').height();
        let cCententReceiveHeight   = $('#odvCSSReceiveInfo').height();

        if( cCententReceiveHeight < cCententPointHeight ){
            $('#odvCSSReceiveInfo').height(cCententPointHeight);
        }else{
            $('#odvCSSPointsInfo').height(cCententReceiveHeight);
        }
        
    });

    // 0	Online (DC จัดส่ง)
    // 1	Online(รับที่ Store)
    // 3	Offline(Store จัดส่ง)
    var tChnMapSeqNo = $('#oetCSSChnMapSeqNo').val();
    
    $('#obtCSSSubmitFromDoc').off('click').on('click',function(){
        JCNxOpenLoading();

        var tDocNo = $('#odvCSSDocNo').text();
        $.ajax({
            type: "POST",
            url: "docCSSEventMoveTmpToDT",
            data: {
                ptDocNo       : tDocNo,
                ptDocVatFull  : $('#ohdCSSXshDocVatFull').val(),
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                // console.log(aReturnData);
                if ( aReturnData['nStaEvent'] == '1' ) {
                    JSxCSSPageEdit(tDocNo);
                } else if ( aReturnData['nStaEvent'] == '600' ){
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgWarningDialog(tMessageError,'JSxCSSPageEdit',tDocNo);
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

    function JSxCSSPageProductDataTable(){
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $(".modal-backdrop").remove();
                
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docCSSPagePdtDataTable",
                    data: {
                        ptDocNo     : $('#odvCSSDocNo').text(),
                        ptSearch    : $('#oetCSSFilterPdt').val()
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if ( aReturnData['nStaEvent'] == '1' ) {
                            $('#odvCSSProductDataTableContent').html(aReturnData['tViewPdtDataTable']);

                            JSxCSSEventSetEndOfBill(aReturnData['aEndOfBill']);

                            var tXshStaPrcDoc   = '<?=$tXshStaPrcDoc?>';  //$tXshStaApv
                            // if( tXshStaPrcDoc != '3' && tChnMapSeqNo == '0' ){                  // ตรวจสอบสถานะอนุมัติเอกสารใบขาย
                            //     $('.xWCSSHideObj').hide();
                            // }else{
                            //     $('.xWCSSHideObj').show();
                            // }
                            // console.log('tChnMapSeqNo: '+tChnMapSeqNo);
                            // console.log('tXshStaPrcDoc: '+tXshStaPrcDoc);
                            // if( tChnMapSeqNo == '0' && tXshStaPrcDoc != '3' ){
                            //     $('#obtCSSChkPdtSN').hide();
                            // }else{
                            //     $('#obtCSSChkPdtSN').show();
                            // }

                            var tXshDocType = '<?=$nXshDocType?>';
                            if( tXshDocType == '1' ){                                           // เอกสารขาย
                                /*************** Control Button On Channels ***************/
                                // console.log('tChnMapSeqNo: '+tChnMapSeqNo);
                                // console.log('tXshStaPrcDoc: '+tXshStaPrcDoc);
                                // console.log('tXshStaApv: '+tXshStaApv);

                                if( tChnMapSeqNo != '0' ){                                      // ถ้าไม่ใช่ Online (DC จัดส่ง) ให้ปิดคีย์ S/N
                                    $('#obtCSSChkPdtSN').hide();
                                }

                                if( tChnMapSeqNo == '0' ){                                      // Online (DC จัดส่ง)
                                    var nCountSerial = aReturnData['nCountSerial'];
                                    if( nCountSerial == 0 ){                                    // ตรวจสอบว่ามีสินค้าที่ยังไม่ได้ระบุ S/N ไหม ?
                                        $('#obtCSSChkPdtSN').hide();
                                        if( tXshStaPrcDoc == '3' && aReturnData['aControlButton']['FNStaAlwApv'] == 0 ){
                                            $('#obtCSSApproveDoc').show();
                                        }else{
                                            $('#obtCSSApproveDoc').hide();
                                        }
                                    }else{
                                        if( tXshStaPrcDoc == '3' ){
                                            $('#obtCSSChkPdtSN').show();

                                            var tStaFirstEnter = $('#ohdCSSStaFirstEnter').val(); // เข้ามาหน้า Add/Edit ครั้งแรกให้เปิด modal ระบุ S/N
                                            if( tStaFirstEnter == '1' ){
                                                $('#obtCSSChkPdtSN').click();
                                                $('#ohdCSSStaFirstEnter').val('2');
                                            }
                                        }
                                        $('#obtCSSApproveDoc').hide();
                                    }
                                }else if( tChnMapSeqNo == '1' || tChnMapSeqNo == '4' ){         // Online(รับที่ Store) + Fast Delivery
                                    if( tXshStaPrcDoc == '7' && tXshStaApv == '' ){
                                        $('#obtCSSApproveDoc').show();                          // สถานะ รอสร้างใบส่ง + ยังไม่อนุมัติเอกสาร
                                    }else{
                                        $('#obtCSSApproveDoc').hide();                          // สถานะ รอสร้างใบส่ง + อนุมัติเอกสารแล้ว
                                    }
                                }else if( tChnMapSeqNo == '3' ){                                // Offline(Store จัดส่ง)
                                    $('#obtCSSApproveDoc').hide();
                                }

                                /*************** Control Button On Channels ***************/
                            }else{                                                          // เอกสารคืน
                                var tXshETaxStatus = '<?=$tXshETaxStatus?>';
                                if( tXshETaxStatus != '1' ){ 
                                    $('#obtCSSApproveDoc').show();
                                }else{
                                    $('#obtCSSApproveDoc').hide();
                                }
                                $('#obtCSSChkPdtSN').hide();

                                $('.xWCSSShwSNList').html('-');
                            }

                            // console.log( aReturnData['aControlButton'] );
                            if( aReturnData['aControlButton']['FNStaAlwSave'] == 0 ){
                                $('#odvCSSBtnGrpSave').hide();
                            }else{
                                $('#odvCSSBtnGrpSave').show();
                            }

                            JCNxLayoutControll();
                            JCNxCloseLoading();
                        } else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
                $('.xCNBody').css("padding-right", "0px");
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (oErr) {
            FSvCMNSetMsgWarningDialog(oErr.message);
        }
    }

    function JSxCSSEventGetDataPdtSN(){
        $.ajax({
            type: "POST",
            url: "docCSSEventGetDataPdtSN",
            data: {
                ptDocNo       : $('#odvCSSDocNo').text(),
                ptScanBarCode : $('#oetCSSScanBarCode').val()
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                if( aReturnData['nStaEvent'] == '1' ){
                    var aDataPdtSN = aReturnData['aDataPdtSN']['aItems'];
                    // console.log(aDataPdtSN);

                    // var aDataRegSN = [];
                    // for( var i = 0; i < aDataPdtSN.length; i++){
                    //     var nRegCur = parseInt(aDataPdtSN[i]['FNReqCur']);
                    //     if( nRegCur > 1 ){
                    //         for( var a = 0; a < nRegCur; a++){
                    //             aDataRegSN.push({
                    //                 'tStaAction'    : 'Insert',
                    //                 'FTPdtCode'     : aDataPdtSN[i]['FTPdtCode'],
                    //                 'FTXsdPdtName'  : aDataPdtSN[i]['FTXsdPdtName'],
                    //                 'FTXsdBarCode'  : aDataPdtSN[i]['FTXsdBarCode'],
                    //                 'tOldPdtSN'     : ''
                    //             });
                    //         }
                    //     }else{
                    //         aDataRegSN.push({
                    //             'tStaAction'    : 'Insert',
                    //             'FTPdtCode'     : aDataPdtSN[i]['FTPdtCode'],
                    //             'FTXsdPdtName'  : aDataPdtSN[i]['FTXsdPdtName'],
                    //             'FTXsdBarCode'  : aDataPdtSN[i]['FTXsdBarCode'],
                    //             'tOldPdtSN'     : ''
                    //         });
                    //     }
                    // }
                    // console.log(aDataRegSN);

                    localStorage.setItem("aDataPdtSN", JSON.stringify(aDataPdtSN));
                    JSxCSSEventRenderPdtSN(1);
                }else{
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    function JSxCSSEventRenderPdtSN(pnRow){
        var aDataPdtSN   = JSON.parse(localStorage.getItem("aDataPdtSN"));
        var nDataSize    = aDataPdtSN.length;
        var nRow         = pnRow - 1;
        var tCountPdtSN  = "";
        var tViewHtml    = "";
        var tStaDisabled = "";
        // console.log(aDataPdtSN);

        if( pnRow <= nDataSize && aDataPdtSN[nRow]['tPdtSN'] == '' ){
            // console.log('if');
            if( aDataPdtSN[nRow]['tStaAction'] == "Update" ){
                $('#odvModalChkPdtSNScanBarCode').hide();
            }else{
                $('#odvModalChkPdtSNScanBarCode').show();
            }

            tViewHtml += '<div class="mb-3 row">';
            tViewHtml += '   <input type="hidden" id="oetCSSPdtCode" name="oetCSSPdtCode" value="'+aDataPdtSN[nRow]['FTPdtCode']+'">';
            tViewHtml += '   <label class="col-md-12 col-form-label"><strong>ชื่อสินค้า</strong> : <strong style="font-size:25px;">'+aDataPdtSN[nRow]['FTXsdPdtName']+'</strong></label>';
            // tViewHtml += '   <div class="col-md-12" style="padding-left:25px;padding-right:25px;">'+aDataPdtSN[nRow]['FTXsdPdtName']+'</div>';
            tViewHtml += '</div>';

            tViewHtml += '<div class="mb-3 row">';
            tViewHtml += '   <label class="col-md-12 col-form-label"><strong>บาร์โค้ด</strong> : '+aDataPdtSN[nRow]['FTXsdBarCode']+'</label>';
            // tViewHtml += '   <div class="col-md-12" style="padding-left:25px;padding-right:25px;">'+aDataPdtSN[nRow]['FTXsdBarCode']+'</div>';
            tViewHtml += '</div>';

            tViewHtml += '<div class="mb-3 row">';
            tViewHtml += '   <label class="col-md-12 col-form-label"><strong>รหัสซีเรียล</strong></label>';
            tViewHtml += '   <input type="hidden" id="oetCSSStaAction" name="oetCSSStaAction" value="'+aDataPdtSN[nRow]['tStaAction']+'">';
            tViewHtml += '   <input type="hidden" id="oetCSSOldPdtSN" name="oetCSSOldPdtSN" value="'+aDataPdtSN[nRow]['tOldPdtSN']+'">';
            tViewHtml += '   <input type="hidden" id="oetCSSSeqNo" name="oetCSSSeqNo" value="'+aDataPdtSN[nRow]['FNXsdSeqNo']+'">';
            tViewHtml += '   <div class="col-md-12"><input type="text" class="form-control" id="oetCSSSerialNo" name="oetCSSSerialNo" placeholder="รหัสซีเรียล" maxlength="50" autocomplete="off" onkeyup="Javascript:if(event.keyCode==13) JSxCSSEventUpdatePdtSNTmp()" ></div>';
            tViewHtml += '</div>';
            
            $('#obtCSSConfirmChkPdtSN').attr('data-nextrow',parseInt(pnRow) + 1);
            $('#odvCSSCountPdtSN').html('รายการสินค้าตัวที่ '+pnRow+' จากรายการทั้งหมด '+nDataSize+' รายการ');
            $('#odvCSSPdtSNList').html(tViewHtml);
            $('#odvCSSModalChkPdtSN').modal('show');
            // JCNxCloseLoading();
            // $('#oetCSSSerialNo').focus();
            // $('#oetCSSScanBarCode').focus();
            setTimeout(function(){ $('#oetCSSSerialNo').focus(); }, 500);
            $('#obtCSSConfirmChkPdtSN').attr('disabled',false);
            $('#obtCSSCancelChkPdtSN').attr('disabled',false);
            
        }else{
            // console.log('else');
            $('#odvCSSModalChkPdtSN').modal('hide');
            var nBackward = nRow - 1;
            if( aDataPdtSN[nBackward]['tStaAction'] == "Update" ){
                JSxCSSCallModalPdtSN(aDataPdtSN[nBackward]['FNXsdSeqNo']);
            }else{
                setTimeout(function(){ 
                    var nIndexFound = 99999;
                    for( var i = 0; i < nDataSize; i++ ){
                        if( aDataPdtSN[i]['tPdtSN'] == '' ){
                            nIndexFound = i + 1;
                            break;
                        }
                    }

                    if( nIndexFound == 99999 ){
                        JSxCSSPageProductDataTable();
                    }else{
                        JSxCSSEventRenderPdtSN(nIndexFound);
                    }
                }, 500);

            }
        }
    }

    function JSxCSSEventScanPdtSN(){
        var tScanBarCode = $('#oetCSSScanBarCode').val().trim();
        var aDataPdtSN   = JSON.parse(localStorage.getItem("aDataPdtSN"));
        var nDataSize    = aDataPdtSN.length;
        var nIndexFound  = nDataSize + 1;

        var nChkFoundBarCode    = 0; // ตรวจสอบว่าพบบาร์โค้ดไหมใน Array Local Storage
        var nChkSNDone          = 0; // ตรวจสอบกรอกบาร์โค้ดครบหรือยังใน Array Local Storage

        // console.log('nIndexFound: ' + nIndexFound);

        $('#oetCSSScanBarCode').val('');

        for( var i = 0; i < nDataSize; i++ ){
            if( aDataPdtSN[i]['FTXsdBarCode'] == tScanBarCode ){
                nChkFoundBarCode++;
                if( aDataPdtSN[i]['tPdtSN'] == '' ){
                    nIndexFound = i + 1;
                    break;
                }else{
                    nChkSNDone++;
                }
            }
        }

        // console.log('nDataSize: ' + nDataSize);
        // console.log('nIndexFound: ' + nIndexFound);

        // console.log('nChkFoundBarCode: ' + nChkFoundBarCode);
        // console.log('nChkSNDone: ' + nChkSNDone);

        if( nIndexFound <= nDataSize ){
            JSxCSSEventRenderPdtSN(nIndexFound);
        }else{
            if( nChkFoundBarCode == nChkSNDone && nChkFoundBarCode != 0 && nChkSNDone != 0 ){
                FSvCMNSetMsgErrorDialog('รหัสบาร์โค้ดนี้ กรอก S/N ครบแล้ว');
            }else if( nChkFoundBarCode == 0 ){
                FSvCMNSetMsgErrorDialog('ไม่พบรหัสบาร์โค้ด');
            }else{
                FSvCMNSetMsgErrorDialog('กรุณาติดต่อผู้ดูแลระบบ');
            }
        }
        
    }

    function JSxCSSEventUpdatePdtSNTmp(){
        var tSerialNo = $('#oetCSSSerialNo').val();
        if( tSerialNo != "" ){
            $('#oetCSSSerialNo').attr('readonly',true);
            $('#obtCSSConfirmChkPdtSN').attr('disabled',true);
            $('#obtCSSCancelChkPdtSN').attr('disabled',true);
            // JCNxOpenLoading();

            var tPdtCode = $('#oetCSSPdtCode').val();

            $.ajax({
                type: "POST",
                url: "docCSSEventUpdatePdtSNTmp",
                data: {
                    ptDocNo       : $('#odvCSSDocNo').text(),
                    pnSeqNo       : $('#oetCSSSeqNo').val(),
                    ptPdtCode     : tPdtCode,
                    ptSerialNo    : tSerialNo,
                    ptStaAction   : $('#oetCSSStaAction').val(),
                    ptOldPdtSN    : $('#oetCSSOldPdtSN').val()
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturnData = JSON.parse(oResult);
                    // console.log(aReturnData);
                    if( aReturnData['tCode'] == '1' ){

                        var aDataPdtSN   = JSON.parse(localStorage.getItem("aDataPdtSN"));
                        var nDataSize    = aDataPdtSN.length;
                        for( var i = 0; i < nDataSize; i++ ){
                            if( aDataPdtSN[i]['FTPdtCode'] == tPdtCode && aDataPdtSN[i]['tPdtSN'] == '' ){
                                aDataPdtSN[i]['tPdtSN'] = tSerialNo;
                                localStorage.setItem("aDataPdtSN", JSON.stringify(aDataPdtSN));
                                break;
                            }
                        }

                        var nNextRow = $('#obtCSSConfirmChkPdtSN').attr('data-nextrow');
                        JSxCSSEventRenderPdtSN(nNextRow);
                    }else{
                        var tMessageError = aReturnData['tDesc'];
                        FSvCMNSetMsgErrorDialog(tMessageError);

                        $('#oetCSSSerialNo').attr('readonly',false);
                        $('#obtCSSConfirmChkPdtSN').attr('disabled',false);
                        $('#obtCSSCancelChkPdtSN').attr('disabled',false);

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            $('#oetCSSSerialNo').focus();
        }
    }

    $('#obtCSSChkPdtSN').off('click').on('click',function(){
        $('#oetCSSScanBarCode').val('');
        JSxCSSEventGetDataPdtSN();
    });

    $('#obtCSSConfirmChkPdtSN').off('click').on('click',function(){
        JSxCSSEventUpdatePdtSNTmp();
    });

    $('#obtCSSCancelChkPdtSN').off('click').on('click',function(){
        var tStaAction = $('#oetCSSStaAction').val();
        // var tPdtCode   = $('#oetCSSPdtCode').val();
        var nSeqNo     = $('#oetCSSSeqNo').val();
        if( tStaAction == "Update" ){
            JSxCSSCallModalPdtSN(nSeqNo);
        }else{
            JSxCSSPageProductDataTable();
        }
    });
    
    $('#obtCSSApproveDoc').off('click').on('click',function(){
        JSxCSSApproveDoc(false);
    });

    $('#obtCSSDownloadFullTax').off('click').on('click',function(){
        JCNxOpenLoading();
        // JSxCSSEventDownloadPrintFullTax();
        var tStaETax    = $('#obtCSSDownloadFullTax').attr('data-staetax');
        var tETaxStatus = $('#obtCSSDownloadFullTax').attr('data-etaxstatus');
        // console.log(tStaETax);
        // console.log( typeof(tStaETax) );

        // console.log(tETaxStatus);
        // console.log( typeof(tETaxStatus) );

        if( tStaETax == '1' && tETaxStatus == '' /*(tETaxStatus != '1' || tETaxStatus != '2')*/ ){
            // console.log('if');
            // $.ajax({
            //     type: "POST",
            //     url: "cenEventChkETaxFullTax",
            //     data: {
            //         ptTaxDocNo : $('#ohdCSSXshDocVatFull').val(),
            //     },
            //     cache: false,
            //     timeout: 0,
            //     success: function(oResult) {
            //         var aReturnData = JSON.parse(oResult);
            //         if ( aReturnData['tCode'] == '1' ) {

            //             var tXshETaxStatus = aReturnData['aItems']['FTXshETaxStatus'];
            //             console.log(tXshETaxStatus);
            //             $('#obtCSSDownloadFullTax').attr('data-etaxstatus',tXshETaxStatus);
                        
            //             var tCSSFullTaxTextBtn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnDownload'.$tXshDocType.'FullTax');?>';
            //             $('#obtCSSDownloadFullTax').html(tCSSFullTaxTextBtn);

            //         }

            //         JSxCSSEventDownloadPrintFullTax();
            //     },
            //     error: function(jqXHR, textStatus, errorThrown) {
            //         JCNxResponseError(jqXHR, textStatus, errorThrown);
            //     }
            // });


            var tUsrApv  = $("#ohdCSSUsrLogin").val();
            var tDocNo   = $('#ohdCSSXshDocVatFull').val();
            var tPrefix  = "RESETAX";
            var poDocConfig = {
                tLangCode                   : <?=$this->session->userdata("tLangEdit")?>,
                tUsrBchCode                 : $("#ohdCSSBchCode").val(),
                tUsrApv                     : $("#ohdCSSUsrLogin").val(),
                tDocNo                      : $('#ohdCSSXshDocVatFull').val(),
                tPrefix                     : "RESETAX",
                tStaDelMQ                   : '1',
                tStaApv                     : $("#ohdCSSXshStaApv").val(),
                tQName                      : tPrefix + "_" + tDocNo + "_" + tUsrApv,
                tVhostType                  : 'I'
            };

            var poDelQnameParams = {
                "ptPrefixQueueName"         : poDocConfig.tPrefix,
                "ptBchCode"                 : "",
                "ptDocNo"                   : poDocConfig.tDocNo,
                "ptUsrCode"                 : poDocConfig.tUsrApv,
                "ptDocConfig"               : JSON.stringify(poDocConfig)
            };

            oGetResponse = setInterval(function() {
                $.ajax({
                    url: 'GetMassageQueue',
                    type: 'POST',
                    data: {
                        tDocConfig  : JSON.stringify(poDocConfig),
                        tQName      : poDocConfig.tQName
                    },
                    success:function(oRes){
                        try {
                            var oResponse = JSON.parse(oRes);
                            var nProgress = oResponse['rnProg'];

                            if (nProgress == '100' || nProgress == 'end') {
                                clearInterval(oGetResponse);
                                FSxCMNRabbitMQDeleteQname(poDelQnameParams);

                                var tXshETaxStatus = oResponse['rtStatus'];
                                $('#obtCSSDownloadFullTax').attr('data-etaxstatus',tXshETaxStatus);
                        
                                var tCSSFullTaxTextBtn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnDownload'.$tXshDocType.'FullTax');?>';
                                $('#obtCSSDownloadFullTax').html(tCSSFullTaxTextBtn);

                                // ตรวจสอบใบกำกับภาษีเต็มรูป แล้ว Response Error กลับมา ให้แสดง Popup Error
                                if( tXshETaxStatus == '3' ){
                                    var tMsgError = oResponse['rtMsgError'];
                                    FSvCMNSetMsgWarningDialog(tMsgError,"JSxCSSEventDownloadPrintFullTax()");
                                }else{
                                    JSxCSSEventDownloadPrintFullTax();
                                }
                            }else if( nProgress == undefined ){ // ถ้าครั้งแรกไม่เจอ message ใน queue ให้วิ่งไปหน้าจอใบกำกับภาษีเต็มรูป เลย
                                clearInterval(oGetResponse);
                                FSxCMNRabbitMQDeleteQname(poDelQnameParams);

                                JSxCSSEventDownloadPrintFullTax();
                            }

                        } catch (err) {
                            console.log("Listening rabbit mq server: ", err);
                        }
                    }
                });

            }, 1000); // 10000 milliseconds = 10 seconds
        }else{
            JSxCSSEventDownloadPrintFullTax();
            // console.log('else');
        }
    });

    function JSxCSSEventDownloadPrintFullTax(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                var tStaETax = $('#obtCSSDownloadFullTax').attr('data-staetax');
                if( tStaETax == '1' ){
                    var tETaxStatus = $('#obtCSSDownloadFullTax').attr('data-etaxstatus');
                    if( tETaxStatus == '1' || tETaxStatus == '2' ){
                        // Call Full Tax
                        $.ajax({
                            type: "POST",
                            url: "cenEventCallApiETAX",
                            data: {
                                ptTaxDocNo : $('#ohdCSSXshDocVatFull').val(),
                                ptTaxType  : 'FullTax'
                            },
                            cache: false,
                            timeout: 0,
                            success: function(oResult) {
                                var aReturnData = JSON.parse(oResult);
                                // console.log(aReturnData);
                                if ( aReturnData['tReturnCode'] == '1' ) {
                                    $('.xWCSSOnDownloadFullTax').attr('href',aReturnData['tReturnData']['pdfURL']);
                                    $('.xWCSSOnDownloadFullTax').attr('download',aReturnData['tReturnData']['pdfURL']);
                                    $('.xWCSSOnDownloadFullTax')[0].click();
                                    
                                    var tCSSFullTaxTextBtn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnDownload'.$tXshDocType.'FullTax');?>';
                                    $('#obtCSSDownloadFullTax').html(tCSSFullTaxTextBtn);
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
                                'tDocNo'   : $('#ohdCSSXshDocVatFull').val(),
                                'tBchCode' : $('#ohdCSSBchCode').val()
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
                    var tDocCode        = $('#ohdCSSXshDocVatFull').val();
                    var tDocBCH         = $('#ohdCSSBchCode').val();
                    var tGrandText      = $("#odvCSSDataTextBath").text().trim();
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
                        $("#oifCSSPrintFullTax").prop('src', "<?=base_url();?>formreport/TaxInvoice?StaPrint=1&infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText + "&PrintOriginal="+tOrginalRight + "&PrintCopy="+tCopyRight + "&PrintByPage="+tPrintByPage);
                    }else{                      //เอกสารคืน - CN Full Tax
                        $("#oifCSSPrintFullTax").prop('src', "<?=base_url();?>formreport/TaxInvoice_refund?StaPrint=1&infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText + "&PrintOriginal="+tOrginalRight + "&PrintCopy="+tCopyRight + "&PrintByPage="+tPrintByPage);
                    }

                    JCNxCloseLoading();
                }
            } catch (oErr) {
                FSvCMNSetMsgWarningDialog(oErr.message);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    $('#obtCSSDownloadDoc').off('click').on('click',function(){
        JCNxOpenLoading();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                var tStaETax = $('#obtCSSDownloadDoc').attr('data-staetax');
                if( tStaETax == '1' ){
                    // Call ABB
                    $.ajax({
                        type: "POST",
                        url: "cenEventCallApiETAX",
                        data: {
                            ptTaxDocNo : $('#odvCSSDocNo').text(),
                            ptTaxType  : 'ABB'
                        },
                        cache: false,
                        timeout: 0,
                        success: function(oResult) {
                            var aReturnData = JSON.parse(oResult);
                            if ( aReturnData['tReturnCode'] == '1' ) {
                                $('.xWCSSOnDownload').attr('href',aReturnData['tReturnData']['urlPdf']);
                                $('.xWCSSOnDownload').attr('download',aReturnData['tReturnData']['urlPdf']);
                                $('.xWCSSOnDownload')[0].click();

                                var tCSSABBTextBtn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnDownload'.$tXshDocType.'ABB');?>';
                                $('#obtCSSDownloadDoc').html(tCSSABBTextBtn);
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
                    var tDocCode        = $('#odvCSSDocNo').text().trim();
                    var tGrandText      = $("#odvCSSDataTextBath").text().trim();
                    var tOrginalRight   = 0;
                    var tCopyRight      = 0;
                    var tPrintByPage    = 1;
                    var aInfor = [
                        {"Lang"         : '<?=FCNaHGetLangEdit(); ?>' },
                        {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>' },
                        {"BranchCode"   : tBCH },
                        {"DocCode"      : tDocCode },
                        {"DocBchCode"   : $('#ohdCSSBchCode').val() }
                    ];
                    $("#oifCSSPrintABB").prop('src', "<?=base_url();?>formreport/InvoiceSaleABB?infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText + "&PrintOriginal="+tOrginalRight + "&PrintCopy="+tCopyRight + "&PrintByPage=" + 'ALL');
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
    function JSxCSSApproveDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                if (pbIsConfirm) {
                    $('#odvCSSModalAppoveDoc').modal("hide");
                    JCNxOpenLoading();
                    var tDocNo = $('#odvCSSDocNo').text();
                    $.ajax({
                        type: "POST",
                        url: "docCSSEventApproved",
                        data: {
                            ptDocNo         : tDocNo,
                            ptStaPrcDoc     : $('#ohdCSSXshStaPrcDoc').val(),
                            ptChnMapSeqNo   : $('#oetCSSChnMapSeqNo').val()
                        },
                        cache: false,
                        timeout: 0,
                        success: function(oResult) {
                            var aReturnData = JSON.parse(oResult);
                            if ( aReturnData['nStaEvent'] == '1' ) {
                                if( aReturnData['tStaETax'] == '1' ){            // For E-Tax
                                    JSxCSSSubscribeMQ();
                                }else{                                              // For สลิป
                                    JSxCSSPageEdit(tDocNo);
                                }
                            } else if ( aReturnData['nStaEvent'] == '600' ){
                                var tMessageError = aReturnData['tStaMessg'];
                                FSvCMNSetMsgWarningDialog(tMessageError,'JSxCSSPageEdit',tDocNo);
                            } else {
                                FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                                JCNxCloseLoading();
                                return;
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                } else {
                    $('#odvCSSModalAppoveDoc').modal("show");
                }
            } catch (oErr) {
                FSvCMNSetMsgWarningDialog(oErr.message);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    // Call MQ Progress
    function JSxCSSSubscribeMQ(){
        // Document variable
        var tLangCode                   = <?=$this->session->userdata("tLangEdit")?>;
        var tUsrBchCode                 = $("#ohdCSSBchCode").val();
        var tUsrApv                     = $("#ohdCSSUsrLogin").val();
        var tDocNo                      = $("#odvCSSDocNo").text().trim();
        var tPrefix                     = "RESETAX";
        var tStaApv                     = $("#ohdCSSXshStaApv").val();
        var tStaDelMQ                   = '1'/*$("#ohdXthStaDelMQ").val()*/;
        var tQName                      = tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode                   : tLangCode,
            tUsrBchCode                 : tUsrBchCode,
            tUsrApv                     : tUsrApv,
            tDocNo                      : tDocNo,
            tPrefix                     : tPrefix,
            tStaDelMQ                   : tStaDelMQ,
            tStaApv                     : tStaApv,
            tQName                      : tQName,
            tVhostType                  : 'I'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName              : "TPSTSalHD",
            ptDocFieldDocNo             : "FTXshDocNo",
            ptDocFieldStaApv            : "FTXshStaPrcDoc",
            ptDocFieldStaDelMQ          : "FTXshStaDelMQ",
            ptDocStaDelMQ               : tStaDelMQ,
            ptDocNo                     : tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit               : "JSxCSSEventCallBackMQ",
            tCallPageList               : "JSxCSSPageList"
        };

        //Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            '',
            poUpdateStaDelQnameParams,
            poCallback
        );

    }

    function JSxCSSEventCallBackMQ(poObj){
        // var oResponse = JSON.parse(poObj);
        var oResponse = poObj;
        switch(oResponse['rtStatus']){
            case '1':
                JSxCSSPageEdit(oResponse['rtDocNo']);
                break;
            case '2':
                FSvCMNSetMsgWarningDialog('<?=language('document/document/document','tDocETaxErrorPC')?>','JSxCSSPageEdit',oResponse['rtDocNo']);
                break;
            default:
                FSvCMNSetMsgWarningDialog(oResponse['rtMsgError']);
                JCNxCloseLoading();
        }
    }

    /*************** สร้างใบจัดสินค้า ***************/
    var tWahStaAlwPLFrmSale = $('#ohdCSSWahStaAlwPLFrmSale').val();
    var tXshStaPrcDoc       = $('#ohdCSSXshStaPrcDoc').val();
    // console.log('tXshStaPrcDoc: '+tXshStaPrcDoc);
    // console.log('tWahStaAlwPLFrmSale: '+tWahStaAlwPLFrmSale);
    if( tXshStaPrcDoc == '1' && tWahStaAlwPLFrmSale == '1' ){
        $('#obtCSSGenDocPack').removeClass('xCNHide');
    }else{
        $('#obtCSSGenDocPack').addClass('xCNHide');
    }

    $('#obtCSSGenDocPack').off('click').on('click',function(){
        setTimeout(function(){
            $('#odvCSSGenDocPacking').modal('show');
        }, 500);
    });

    $('#obtCSSConfigGenDocPacking').off('click').on('click',function(){
        JSxCSSGetConfigGenDocPack(true);
    });

    $('#obtCSSCancelConfigGenDocPacking').off('click').on('click',function(){
        setTimeout(function(){
            $('#odvCSSGenDocPacking').modal('show');
        }, 500);
    });

    function JSxCSSGetConfigGenDocPack(pbType){
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "docCSSEventGetConfigGenDocPack",
            data    : {},
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == '1' ){
                    console.log(aResult['aDataList']);
                    var aDataList = aResult['aDataList'];
                    for (let i = 0; i < aDataList.length; i++) {
                        if( aDataList[i]['FTValue'] == '1' ){
                            $('.xWCSSSysSeq'+aDataList[i]['FTSysSeq']).prop('checked', true);
                        }else{
                            $('.xWCSSSysSeq'+aDataList[i]['FTSysSeq']).prop('checked', false);
                        }
                    }
                    if( pbType === true ){
                        setTimeout(function(){
                            $('#odvCSSConfigGenDocPacking').modal('show');
                        }, 500);
                    }
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    $('#obtCSSConfirmConfigGenDocPacking').off('click').on('click',function(){
        JCNxOpenLoading();
        var aCondition = [];
        $("input:checkbox[name=ocbCSSCondtionGenPacking]:checked").each(function(){
            var aPush = {
                'ptSplit' : $(this).val()
            };
            aCondition.push(aPush);
        });

        $.ajax({
            type    : "POST",
            url     : "docCSSEventSaveConfigGenDocPack",
            data    : {
                'paCondition' : aCondition
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == '1' ){
                    setTimeout(function(){
                        $('#odvCSSGenDocPacking').modal('show');
                    }, 500);
                }else{
                    FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });

    $('#obtCSSConfirmGenDocPacking').off('click').on('click',function(){
        $('#odvCSSGenDocPacking').modal('hide');
        $.ajax({
            type    : "POST",
            url     : "docCSSEventGenDocPacking",
            data    : {
                'ptBchCode'     : $('#ohdCSSBchCode').val(),
                'ptDocNo'       : $('#odvCSSDocNo').text().trim()
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == '1' ){
                    setTimeout(function(){ 
                        JSxCSSSubscribeMQOnGenPacking();
                    }, 500);
                }else{
                    FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });  
    
    // Call MQ Progress
    function JSxCSSSubscribeMQOnGenPacking(){
        // Document variable
        var tLangCode                   = <?=$this->session->userdata("tLangEdit")?>;
        var tUsrBchCode                 = $("#ohdCSSBchCode").val();
        var tUsrApv                     = $("#ohdCSSUsrLogin").val();
        var tDocNo                      = $('#odvCSSDocNo').text().trim();
        var tPrefix                     = "RESGEN";
        var tStaApv                     = '';
        var tStaDelMQ                   = '1';
        var tQName                      = tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode                   : tLangCode,
            tUsrBchCode                 : tUsrBchCode,
            tUsrApv                     : tUsrApv,
            tDocNo                      : tDocNo,
            tPrefix                     : tPrefix,
            tStaDelMQ                   : tStaDelMQ,
            tStaApv                     : tStaApv,
            tQName                      : tQName,
            tVhostType                  : 'D'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName              : "TPSTSalHD",
            ptDocFieldDocNo             : "FTXshDocNo",
            ptDocFieldStaApv            : "",
            ptDocFieldStaDelMQ          : "",
            ptDocStaDelMQ               : tStaDelMQ,
            ptDocNo                     : tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit               : "JSxCSSEventCallBackGenDoc",
            tCallPageList               : "JSxCSSEventCallBackGenDoc"
        };

        //Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            '',
            poUpdateStaDelQnameParams,
            poCallback
        );

    }

    function JSxCSSEventCallBackGenDoc(poObj){
        var oResponse = poObj;
        switch(oResponse['rtStatus']){
            case '1':
                JSxCSSPageEdit(oResponse['rtDocNo']);
                break;
            default:
                FSvCMNSetMsgWarningDialog(oResponse['rtMsgError']);
                JCNxCloseLoading();
        }
    }
    /*************** สร้างใบจัดสินค้า ***************/



    /*************** สร้างใบส่งของ ***************/
    var tChnStaUseDO    = $('#ohdCSSChnStaUseDO').val();
    var tXshStaApv      = $('#ohdCSSXshStaApv').val();
    if( (tXshStaPrcDoc == '7' && tXshStaApv == '1' && tChnStaUseDO == '1') && tChnMapSeqNo != '0' ){
        $('#obtCSSGenDocDelivery').removeClass('xCNHide');  // แสดงปุ่มสร้างใบส่ง
    }else{
        $('#obtCSSGenDocDelivery').addClass('xCNHide');     // ซ่อนปุ่มสร้างใบส่ง
    }

    $('#obtCSSGenDocDelivery').off('click').on('click',function(){
        setTimeout(function(){
            $('#odvCSSGenDocDelivery').modal('show');
        }, 500);
    });

    $('#obtCSSConfirmGenDocDelivery').off('click').on('click',function(){
        $('#odvCSSGenDocDelivery').modal('hide');
        $.ajax({
            type    : "POST",
            url     : "docCSSEventGenDocDelivery",
            data    : {
                'ptBchCode'     : $('#ohdCSSBchCode').val(),
                'ptDocNo'       : $('#odvCSSDocNo').text().trim()
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == '1' ){
                    setTimeout(function(){ 
                        JSxCSSSubscribeMQGenDelivery();
                    }, 500);
                }else{
                    FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });

    // Call MQ Progress
    function JSxCSSSubscribeMQGenDelivery(){
        // Document variable
        var tLangCode                   = <?=$this->session->userdata("tLangEdit")?>;
        var tUsrBchCode                 = $("#ohdCSSBchCode").val();
        var tUsrApv                     = $("#ohdCSSUsrLogin").val();
        var tDocNo                      = $('#odvCSSDocNo').text().trim();
        var tPrefix                     = "RESGEN";
        var tStaApv                     = '';
        var tStaDelMQ                   = '1';
        var tQName                      = tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode                   : tLangCode,
            tUsrBchCode                 : tUsrBchCode,
            tUsrApv                     : tUsrApv,
            tDocNo                      : tDocNo,
            tPrefix                     : tPrefix,
            tStaDelMQ                   : tStaDelMQ,
            tStaApv                     : tStaApv,
            tQName                      : tQName,
            tVhostType                  : 'D'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName              : "TPSTSalHD",
            ptDocFieldDocNo             : "FTXshDocNo",
            ptDocFieldStaApv            : "",
            ptDocFieldStaDelMQ          : "",
            ptDocStaDelMQ               : tStaDelMQ,
            ptDocNo                     : tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit               : "JSxCSSEventCallBackGenDoc",
            tCallPageList               : "JSxCSSEventCallBackGenDoc"
        };

        //Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            '',
            poUpdateStaDelQnameParams,
            poCallback
        );

    }
    /*************** สร้างใบส่งของ ***************/

</script>