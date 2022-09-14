<input type="hidden" id="ohdPAMEnterSNSeqNo" >
<input type="hidden" id="ohdPAMEnterSNPdtCode" >
<input type="hidden" id="ohdPAMEnterSNPdtName" >
<input type="hidden" id="ohdPAMEnterSNBarCode" >
<input type="hidden" id="ohdPAMEnterSNQty" >

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <style>
            .xWFontBold{
                font-size:25px !important;
                font-weight: bold !important;
            }
        </style>

        <div class="row">

            <!-- รหัสสินค้า -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 xWFontBold"><?=language('document/document/document','รหัสสินค้า')?></div>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 xWFontBold">
                        <span id="ospPAMProductCode" class="xWFontBold"></span>
                    </div>
                </div>
            </div>
            <!-- รหัสสินค้า -->

            <!-- ชื่อสินค้า -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 xWFontBold"><?=language('document/document/document','tDocPdtName')?></div>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 xWFontBold">
                        <span id="ospPAMProductName" class="xWFontBold"></span>
                    </div>
                </div>
            </div>
            <!-- ชื่อสินค้า -->

            <!-- บาร์โค้ด -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 xWFontBold"><?=language('document/document/document','บาร์โค้ด')?></div>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 xWFontBold">
                        <span id="ospPAMBarCode" class="xWFontBold"></span>
                    </div>
                </div>
            </div>
            <!-- บาร์โค้ด -->

            <!-- รหัสซีเรียล -->
            <div id="odvPAMContentKeySN" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;margin-bottom:15px;">
                <div class="row">
                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-form-label"><strong>รหัสซีเรียล</strong></label>
                    <input type="hidden" id="oetPAMPdtSNCurrentQty" value="'+paPackData['nSNCurrentQty']+'">
                    <input type="hidden" id="oetPAMPdtSNBalanceQty" value="'+paPackData['nSNBalanceQty']+'">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <input type="text" class="form-control" id="oetPAMSerialNo" name="oetPAMSerialNo" placeholder="รหัสซีเรียล" maxlength="20" autocomplete="off" onkeyup="Javascript:if(event.keyCode==13) JSxPAMEventAddPdtSN()" >
                    </div>
                </div>
            </div>
            <!-- รหัสซีเรียล -->

        </div>

    </div>

    <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right xWPdtSNHideOnApv" style="margin-bottom:15px;">
        <button id="obtPAMAddPdtSN" class="xCNBTNPrimeryPlus" type="button">+</button>
    </div> -->

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbCSSPdtTableList" class="table xWPdtTableFont">
                <thead>
                    <tr class="xCNCenter">
                        <th nowrap width="10%"><?=language('document/document/document','tDocNumber')?></th>
                        <th nowrap><?=language('document/document/document','tDocPdtS/N')?></th>
                        <th nowrap width="10%" class="xWPdtSNHideOnApv"><?=language('common/main/main','tCMNActionDelete')?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if( $tCode == '1' ){
                        foreach($aItems as $nKey => $aDataVal){
                ?>
                            <tr class="text-center xCNTextDetail2 xWPdtSNItems" data-seqno="<?=$aDataVal['FNXtdSeqNo']?>" data-pdtcode="<?=$aDataVal['FTPdtCode']?>" data-pdtname="<?=$aDataVal['FTPdtName']?>" data-barcode="<?=$aDataVal['FTBarCode']?>" data-serial="<?=$aDataVal['FTPdtSerial']?>" >
                                <td nowrap class="text-center"><?=($nKey + 1)?></td>
                                <td nowrap class="text-left"><?=$aDataVal['FTPdtSerial']?></td>
                                <td nowrap class="text-center xWPdtSNHideOnApv">
                                    <img class="xCNIconTable xCNIconDel xWPAMDeletePdtSN" onclick="JSxPAMEventDeletePdtSN($(this))" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>">
                                </td>
                            </tr>
                <?php
                        }
                    }else{
                ?>
                            <tr><td class="text-center xCNTextDetail2 xWTWITextNotfoundDataPdtTable" colspan="100%"><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

    // setTimeout(function(){ $('#oetPAMSerialNo').focus(); }, 500);

    // $('.xWCSSEditPdtSN').off('click').on('click',function(){
    //     var nSeqNo      = $(this).parents().parents().attr('data-seqno');
    //     var tPdtCode    = $(this).parents().parents().attr('data-pdtcode');
    //     var tPdtName    = $(this).parents().parents().attr('data-pdtname');
    //     var tBarCode    = $(this).parents().parents().attr('data-barcode');
    //     var tOldPdtSN   = $(this).parents().parents().attr('data-oldsn');

    //     var aDataRegSN = [];
    //     aDataRegSN.push({
    //         'tStaAction'    : 'Update',
    //         'FNXtdSeqNo'    : nSeqNo,
    //         'FTPdtCode'     : tPdtCode,
    //         'FTXtdPdtName'  : tPdtName,
    //         'FTXtdBarCode'  : tBarCode,
    //         'tOldPdtSN'     : tOldPdtSN,
    //         'tPdtSN'        : ''
    //     });

    //     localStorage.setItem("aDataPdtSN", JSON.stringify(aDataRegSN));
    //     JSxCSSEventRenderPdtSN(1);
    // });

    // var tXshStaPrcDoc = $('#ohdCSSXshStaPrcDoc').val();
    // if( tXshStaPrcDoc == '3' ){
    //     $('.xWCSSEditPdtSN').removeClass('xCNHide');
    //     $('.xWCSSDisplayPdtSN').addClass('xCNHide');
    // }else{
    //     $('.xWCSSEditPdtSN').addClass('xCNHide');
    //     $('.xWCSSDisplayPdtSN').removeClass('xCNHide');
    // }

    // $('#obtPAMAddPdtSN').off('click').on('click',function(){
    //     // console.log( $('#otbCSSPdtTableList .xWPdtSNItems').length );

    //     var tPdtQty         = parseInt($('#ohdPAMEnterSNQty').val());
    //     var tSNQty          = parseInt($('#otbCSSPdtTableList .xWPdtSNItems').length);
    //     var nSNBalanceQty   = tPdtQty - tSNQty;

    //     if( nSNBalanceQty != 0 ){
    //         var aPackData = {
    //             'nSeqNo'        : $('#ohdPAMEnterSNSeqNo').val(),
    //             'tPdtCode'      : $('#ohdPAMEnterSNPdtCode').val(),
    //             'tPdtName'      : $('#ohdPAMEnterSNPdtName').val(),
    //             'tBarCode'      : $('#ohdPAMEnterSNBarCode').val(),
    //             'nSNCurrentQty' : 1,
    //             'nSNBalanceQty' : nSNBalanceQty
    //         };
    //         JSxPAMRenderEnterPdtSN(aPackData);
    //     }else{
    //         FSvCMNSetMsgWarningDialog('ระบุซีเรียลครบแล้ว');
    //     }
    // });

    // function JSxPAMRenderEnterPdtSN(paPackData){
    //     // console.log(paPackData);

    //     var tViewHtml = "";
    //     tViewHtml += '<div class="mb-3 row">';
    //     tViewHtml += '   <input type="hidden" id="oetCSSPdtCode" name="oetCSSPdtCode" value="'+paPackData['tPdtCode']+'">';
    //     tViewHtml += '   <label class="col-md-12 col-form-label"><strong>ชื่อสินค้า</strong> : <strong style="font-size:25px;">'+paPackData['tPdtName']+'</strong></label>';
    //     tViewHtml += '</div>';

    //     tViewHtml += '<div class="mb-3 row">';
    //     tViewHtml += '   <label class="col-md-12 col-form-label"><strong>บาร์โค้ด</strong> : '+paPackData['tBarCode']+'</label>';
    //     tViewHtml += '</div>';

    //     tViewHtml += '<div class="mb-3 row">';
    //     tViewHtml += '   <label class="col-md-12 col-form-label"><strong>รหัสซีเรียล</strong></label>';
    //     tViewHtml += '   <input type="hidden" id="oetPAMPdtSNCurrentQty" value="'+paPackData['nSNCurrentQty']+'">';
    //     tViewHtml += '   <input type="hidden" id="oetPAMPdtSNBalanceQty" value="'+paPackData['nSNBalanceQty']+'">';
    //     // tViewHtml += '   <input type="hidden" id="oetCSSStaAction" name="oetCSSStaAction" value="'+paPackData['tStaAction']+'">';
    //     // tViewHtml += '   <input type="hidden" id="oetCSSOldPdtSN" name="oetCSSOldPdtSN" value="'+paPackData['tOldPdtSN']+'">';
    //     tViewHtml += '   <input type="hidden" id="oetCSSSeqNo" name="oetCSSSeqNo" value="'+paPackData['nSeqNo']+'">';
    //     tViewHtml += '   <div class="col-md-12"><input type="text" class="form-control" id="oetPAMSerialNo" name="oetPAMSerialNo" placeholder="รหัสซีเรียล" maxlength="50" autocomplete="off" onkeyup="Javascript:if(event.keyCode==13) JSxPAMEventAddPdtSN()" ></div>';
    //     tViewHtml += '</div>';

    //     $('#odvPAMPdtSNList').html(tViewHtml);
    //     $('#odvPAMCountPdtSN').html('รายการสินค้าตัวที่ '+paPackData['nSNCurrentQty']+' จากรายการทั้งหมด '+paPackData['nSNBalanceQty']+' รายการ');
    //     $('#obtPAMConfirmEnterPdtSN').attr('disabled',false);
    //     $('#obtPAMCancelEnterPdtSN').attr('disabled',false);
    //     $('#oetPAMSerialNo').val('').attr('disabled',false);

    //     $('#odvPAMModalEnterPdtSN').modal('show');

    //     setTimeout(function(){ $('#oetPAMSerialNo').focus(); }, 500);

    // }

    $('#obtPAMConfirmEnterPdtSN').off('click').on('click',function(){
        JSxPAMEventAddPdtSN();
    });

    function JSxPAMEventAddPdtSN(){
        // JCNxOpenLoading();
        var nSeqNo      = $('#ohdPAMEnterSNSeqNo').val();
        var nDocType    = $('#ohdPAMDocType').val();
        var tAlwQtyPickNotEqQtyOrd = $('#ohdPAMAlwQtyPickNotEqQtyOrd').val();

        // ใบจัดสินค้าที่เกิดจากใบขาย จัดสินค้าได้ไม่เกินจำนวนใบขาย
        // if( nDocType == '2' ){
        if( tAlwQtyPickNotEqQtyOrd == 'false' ){ //อนุญาตจัดสินค้าไม่เท่ากับจำนวนสั่ง
            var nQtyOrd = parseFloat($('#ohdQty'+nSeqNo).attr('data-qtyord'));
            // var nQty    = parseFloat($('#ohdQty'+nSeqNo).val());
            var nQty    = parseFloat($('.xWPdtSNItems').length);
            
            if( nQty == nQtyOrd ){
                FSvCMNSetMsgWarningDialog('ระบุซีเรียลครบแล้ว');
                $('#oetPAMSerialNo').val('');
                return;
            }
        }
        // }

        var tPdtSerial = $('#oetPAMSerialNo').val();
        if( tPdtSerial != "" ){
            
            var aPackData = {
                'tDocNo'        : $('#oetPAMDocNo').val(),
                'tBchCode'      : $('#oetPAMBchCode').val(),
                'nSeqNo'        : nSeqNo,
                'tPdtSerial'    : $('#oetPAMSerialNo').val()
            };

            $('#oetPAMSerialNo').attr('disabled',true);
            $('#obtPAMConfirmEnterPdtSN').attr('disabled',true);
            $('#obtPAMCancelEnterPdtSN').attr('disabled',true);

            // var nPdtSNCurrentQty = parseInt($('#oetPAMPdtSNCurrentQty').val()) + 1;
            // var nPdtSNBalanceQty = parseInt($('#oetPAMPdtSNBalanceQty').val());

            // console.log('nPdtSNCurrentQty: '+nPdtSNCurrentQty);
            // console.log('nPdtSNBalanceQty: '+nPdtSNBalanceQty);

            $.ajax({
                type: "POST",
                url: "docPAMEventAddPdtSN",
                data: { paPackData : aPackData },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if( aReturnData['nStaEvent'] == '1' ){
                        var aPackDataPdtSN = {
                            'nSeqNo'    : nSeqNo,
                            'tPdtCode'  : $('#ohdPAMEnterSNPdtCode').val(),
                            'tPdtName'  : $('#ohdPAMEnterSNPdtName').val(),
                            'tBarCode'  : $('#ohdPAMEnterSNBarCode').val(),
                            'tQty'      : $('#ohdPAMEnterSNQty').val()
                        };
                        JSxPAMCallModalPdtSN(aPackDataPdtSN);

                        // JSvPAMLoadPdtDataTableHtml(1);

                        // if( nPdtSNCurrentQty <= nPdtSNBalanceQty ){
                        //     var aPackData = {
                        //         'nSeqNo'        : $('#ohdPAMEnterSNSeqNo').val(),
                        //         'tPdtCode'      : $('#ohdPAMEnterSNPdtCode').val(),
                        //         'tPdtName'      : $('#ohdPAMEnterSNPdtName').val(),
                        //         'tBarCode'      : $('#ohdPAMEnterSNBarCode').val(),
                        //         'nSNCurrentQty' : nPdtSNCurrentQty,
                        //         'nSNBalanceQty' : nPdtSNBalanceQty
                        //     };
                        //     JSxPAMRenderEnterPdtSN(aPackData);
                        // }else{
                        //     $('#odvPAMModalEnterPdtSN').modal('hide');
                        // }
                    }else{
                        var tMessageError = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);

                        $('#oetPAMSerialNo').attr('disabled',false);
                        $('#obtPAMConfirmEnterPdtSN').attr('disabled',false);
                        $('#obtPAMCancelEnterPdtSN').attr('disabled',false);

                    }

                    // JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            FSvCMNSetMsgErrorDialog('กรุณาระบุรหัสซีเรียล');
        }
        
    }

    
    $('#obtPAMModalViewPdtSNCancel').off('click').on('click',function(){
        JSvPAMLoadPdtDataTableHtml(1);
    });

    $('.xWPAMDeletePdtSN').off('click').on('click',function(){
        // alert('a');
        JSxPAMEventDeletePdtSN($(this));
    });

    function JSxPAMEventDeletePdtSN(poThis){
        var nSeqNo = $('#ohdPAMEnterSNSeqNo').val();
        var aPackData = {
            'tDocNo'        : $('#oetPAMDocNo').val(),
            'tBchCode'      : $('#oetPAMBchCode').val(),
            'nSeqNo'        : nSeqNo,
            'tPdtSerial'    : poThis.parents().parents().attr('data-serial')
        };
        $.ajax({
            type: "POST",
            url: "docPAMEventDeletePdtSN",
            data: { paPackData : aPackData },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                if( aReturnData['nStaEvent'] == '1' ){
                    var aPackDataPdtSN = {
                        'nSeqNo'    : nSeqNo,
                        'tPdtCode'  : $('#ohdPAMEnterSNPdtCode').val(),
                        'tPdtName'  : $('#ohdPAMEnterSNPdtName').val(),
                        'tBarCode'  : $('#ohdPAMEnterSNBarCode').val(),
                        'tQty'      : $('#ohdPAMEnterSNQty').val()
                    };
                    JSxPAMCallModalPdtSN(aPackDataPdtSN);
                    // JSvPAMLoadPdtDataTableHtml(1);
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

    var tStaDoc = $('#ohdPAMStaDoc').val();
    var tStaApv = $('#ohdPAMStaApv').val();
    if( (tStaDoc == '3') || (tStaDoc == '1' && tStaApv == '1') ){
        $('.xWPdtSNHideOnApv').hide();
        $('#odvPAMContentKeySN').hide();
    }

</script>