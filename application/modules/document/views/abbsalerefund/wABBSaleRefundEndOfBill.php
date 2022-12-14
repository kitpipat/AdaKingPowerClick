<style>
    #odvABBRowDataEndOfBill .panel-heading{
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
    #odvABBRowDataEndOfBill .panel-body{
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }
    #odvABBRowDataEndOfBill .list-group-item {
        padding-left: 0px !important;
        padding-right: 0px !important;
        border: 0px solid #ddd;
    }
    .mark-font, .panel-default > .panel-heading.mark-font{
        color: #232C3D !important;
        font-weight: 900;
    }
</style>
<div class="row p-t-20" id="odvABBRowDataEndOfBill" >

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="pull-left mark-font"><?=language('document/document/document','tDocPointInfo');?></div>
                <div class="pull-right mark-font"></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <div id="odvABBCstPoints">
                        <table id="otbABBCstPointsList" class="table xWPdtTableFont xWtableShwPoints" style="margin-top: 15px !important;margin-bottom: 15px !important;">
                            <thead>
                                <tr class="xCNCenter">
                                    <th width="30%" nowrap><?=language('document/document/document','tDocB4Point')?></th> 
                                    <th width="24%" nowrap><?=language('document/document/document','tDocBurnEarnPoint')?></th>
                                    <th width="23%" nowrap><?=language('document/document/document','tDocProPoint')?></th>
                                    <th width="23%" nowrap><?=language('document/document/document','tDocBalPoint')?></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div id="odvABBSplPoints"></div>
                </div>
            </div>

            <div class="panel-heading">
                <div class="pull-left mark-font"><?=language('document/saleorder/saleorder','tSOTBVatRate');?></div>
                <div class="pull-right mark-font"><?=language('document/saleorder/saleorder','tSOTBAmountVat');?></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <ul class="list-group" id="oulABBDataListVat" style="margin-bottom: 0px;margin-top: 10px;"></ul>
                <ul class="list-group" style="margin-bottom: 0px;">
                    <li class="list-group-item">
                        <label class="pull-left mark-font"><?=language('document/saleorder/saleorder','tSOTBTotalValVat');?></label>
                        <label class="pull-right mark-font" id="olbABBVatSum">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>

            <div class="panel-heading">
                <div class="pull-left mark-font"><?=language('document/document/document','tDocPayInfo');?></div>
                <div class="pull-right mark-font"></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <ul class="list-group" id="oulABBDataListPayment" style="margin-bottom: 0px;margin-top: 10px;"></ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?=language('document/document/document','tDocPayGrand');?></label>
                <label class="pull-right mark-font" id="olbABBPaymentSum">0.00</label>
                <div class="clearfix"></div>
            </div>

        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default" style="margin-bottom: 20px;">
            <div class="panel-heading">
                <div class="pull-left mark-font"><?=language('document/document/document','tDocDisPromotions');?></div>
                <div class="pull-right mark-font"><?=language('document/document/document','tDocTotalDisPro');?></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <ul class="list-group" id="oulABBDataListPromotions" style="margin-bottom: 0px;margin-top: 10px;"></ul>
                <ul class="list-group" style="margin-bottom: 0px;">
                    <li class="list-group-item">
                        <label class="pull-left mark-font"><?=language('document/document/document','tDocGrandDisPro');?></label>
                        <label class="pull-right mark-font" id="olbABBPromotionsSum">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="panel panel-default" style="margin-bottom: 20px;">
            <div class="panel-heading mark-font" id="odvABBDataTextBath"></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <label class="pull-left mark-font"><?=language('document/saleorder/saleorder','tSOTBSumFCXtdNet');?></label>
                        <label class="pull-right mark-font" id="olbABBSumFCXtdNet">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/saleorder/saleorder','tSOTBDisChg');?></label>
                        <label class="pull-left" style="margin-left: 5px;" id="olbABBDisChgHD"></label>
                        <label class="pull-right" id="olbABBSumFCXtdAmt">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/saleorder/saleorder','tSOTBSumFCXtdNetAfHD');?></label>
                        <label class="pull-right" id="olbABBSumFCXtdNetAfHD">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/saleorder/saleorder','tSOTBSumFCXtdVat');?></label>
                        <label class="pull-right" id="olbABBSumFCXtdVat">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/document/document','tDocRound');?></label>
                        <label class="pull-right" id="olbABBRound">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?=language('document/saleorder/saleorder','tSOTBFCXphGrand');?></label>
                <label class="pull-right mark-font" id="olbABBCalFCXphGrand">0.00</label>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var tMsgVatDataNotFound = '<?=language('common/main/main','tCMNNotFoundData')?>';

    //Set Data Value End Of Bile
    function JSxABBEventSetEndOfBill(poParams){
        // Set Text Bath
        var tTextBath   = poParams.tTextBath;
        $('#odvABBDataTextBath').text(tTextBath);

        // ??????????????????????????????????????????????????????????????????
        let aCstBurnPoints = poParams.aDataPoints.aCstBurnPoints;
        let aCstEarnPoints = poParams.aDataPoints.aCstEarnPoints;
        let tPointsRender = "";
        if( aCstBurnPoints.length > 0 || aCstEarnPoints.length > 0 ){
            if( aCstBurnPoints.length > 0 ){
                for(let i = 0; i < aCstBurnPoints.length; i++){
                    let cPntB4Bill  = accounting.formatNumber(aCstBurnPoints[i]['FCRedPntB4Bill'], <?=$nOptDecimalShow;?>, ',');
                    let cPntBillQty = accounting.formatNumber(aCstBurnPoints[i]['FCRedPntBillQty'], <?=$nOptDecimalShow;?>, ',');
                    let cPntProQty  = accounting.formatNumber(0, <?=$nOptDecimalShow;?>, ',');
                    let cPntBal     = accounting.formatNumber(aCstBurnPoints[i]['FCRedPntBal'], <?=$nOptDecimalShow;?>, ',');

                    tPointsRender += '<tr class="text-center xCNTextDetail2 xWPdtItem" >';
                    tPointsRender += '    <td nowrap class="text-center">'+cPntB4Bill+'</td>';
                    tPointsRender += '    <td nowrap class="text-center">'+cPntBillQty+'</td>';
                    tPointsRender += '    <td nowrap class="text-center">'+cPntProQty+'</td>';
                    tPointsRender += '    <td nowrap class="text-center">'+cPntBal+'</td>';
                    tPointsRender += '</tr>';
                }
            }
            if( aCstEarnPoints.length > 0 ){
                for(let i = 0; i < aCstEarnPoints.length; i++){
                    let cPntB4Bill  = accounting.formatNumber(aCstEarnPoints[i]['FCTxnPntB4Bill'], <?=$nOptDecimalShow;?>, ',');
                    let cPntBillQty = accounting.formatNumber(aCstEarnPoints[i]['FCTxnPntBillQty'], <?=$nOptDecimalShow;?>, ',');
                    let cPntProQty  = accounting.formatNumber(0, <?=$nOptDecimalShow;?>, ',');
                    let cPntBal     = accounting.formatNumber(aCstEarnPoints[i]['FCTxnPntBal'], <?=$nOptDecimalShow;?>, ',');

                    tPointsRender += '<tr class="text-center xCNTextDetail2 xWPdtItem" >';
                    tPointsRender += '    <td nowrap class="text-center">'+cPntB4Bill+'</td>';
                    tPointsRender += '    <td nowrap class="text-center">'+cPntBillQty+'</td>';
                    tPointsRender += '    <td nowrap class="text-center">'+cPntProQty+'</td>';
                    tPointsRender += '    <td nowrap class="text-center">'+cPntBal+'</td>';
                    tPointsRender += '</tr>';
                }
            }
        }else{
            tPointsRender += '<tr class="text-center xCNTextDetail2 xWPdtItem" >';
            tPointsRender += '    <td nowrap class="text-center">'+parseFloat(0).toFixed(<?=$nOptDecimalShow;?>)+'</td>';
            tPointsRender += '    <td nowrap class="text-center">'+parseFloat(0).toFixed(<?=$nOptDecimalShow;?>)+'</td>';
            tPointsRender += '    <td nowrap class="text-center">'+parseFloat(0).toFixed(<?=$nOptDecimalShow;?>)+'</td>';
            tPointsRender += '    <td nowrap class="text-center">'+parseFloat(0).toFixed(<?=$nOptDecimalShow;?>)+'</td>';
            tPointsRender += '</tr>';
        }
        $('#odvABBCstPoints tbody').html(tPointsRender);

        // ??????????????????????????????????????????????????????????????????????????????
        let aSplEarnPoints = poParams.aDataPoints.aSplEarnPoints;
        if( aSplEarnPoints.length > 0 ){
            let tSplPointsRender = '';
            tSplPointsRender += '<table class="table xWPdtTableFont xWtableShwPoints" style="margin-top:15px;">';
            tSplPointsRender += '  <thead>';
            tSplPointsRender += '      <tr class="xCNCenter">';
            tSplPointsRender += '          <th width="30%" nowrap><?=language('document/document/document','tDocSplPoint')?></th>';
            tSplPointsRender += '          <th width="24%" nowrap><?=language('document/document/document','tDocEarnPoint')?></th>';
            tSplPointsRender += '          <th width="23%" nowrap><?=language('document/document/document','tDocStartPoint')?></th>';
            tSplPointsRender += '          <th width="23%" nowrap><?=language('document/document/document','tDocEndPoint')?></th>';
            tSplPointsRender += '      </tr>';
            tSplPointsRender += '  </thead>';
            tSplPointsRender += '  <tbody>';

            for(let i = 0; i < aSplEarnPoints.length; i++){
                let cPntBillQty  = accounting.formatNumber(aSplEarnPoints[i]['FCTxnPntBillQty'], <?=$nOptDecimalShow;?>, ',');
                tSplPointsRender += '<tr class="text-center xCNTextDetail2 xWPdtItem" >';
                tSplPointsRender += '    <td nowrap class="text-center">'+aSplEarnPoints[i]['FTSplName']+'</td>';
                tSplPointsRender += '    <td nowrap class="text-center">'+cPntBillQty+'</td>';
                tSplPointsRender += '    <td nowrap class="text-center">'+$.datepicker.formatDate('dd/mm/yy', new Date(aSplEarnPoints[i]['FDTxnPntStart']))+'</td>';
                tSplPointsRender += '    <td nowrap class="text-center">'+$.datepicker.formatDate('dd/mm/yy', new Date(aSplEarnPoints[i]['FDTxnPntExpired']))+'</td>';
                tSplPointsRender += '</tr>';
            }

            tSplPointsRender += '  </tbody>';
            tSplPointsRender += '</table>';
            $('#odvABBSplPoints').html(tSplPointsRender);
        }
        
        // ?????????????????????????????????????????????????????????????????????
        let aDataDocRC = poParams.aDataDocRC;
        if( aDataDocRC['tCode'] == '1' ){
            let tRCRender = '';
            let cRcSum    = 0;
            for(let i = 0; i < aDataDocRC['aItems'].length; i++){
                cRcSum += parseFloat(aDataDocRC['aItems'][i]['FCXrcNet']);
                tRCRender += '<li class="list-group-item" style="padding-top: 1px;padding-bottom: 1px;">';
                tRCRender += '    <label class="pull-left">';
                tRCRender += '      <div>('+aDataDocRC['aItems'][i]['FTRcvCode']+') '+aDataDocRC['aItems'][i]['FTRcvName']+'</div>';
                if( aDataDocRC['aItems'][i]['FTXrcRefNo1'] != "" ){
                    tRCRender += '  <div style="padding-left: 32px;">'+aDataDocRC['aItems'][i]['FTXrcRefNo1']+'</div>';
                }
                tRCRender += '    </label>';
                tRCRender += '    <label class="pull-right">'+accounting.formatNumber(aDataDocRC['aItems'][i]['FCXrcNet'], <?=$nOptDecimalShow;?>, ',')+'</label>';
                tRCRender += '    <div class="clearfix"></div>';
                tRCRender += '</li>';
            }
            $('#oulABBDataListPayment').html(tRCRender);
            $('#olbABBPaymentSum').html(accounting.formatNumber(cRcSum, <?=$nOptDecimalShow;?>, ','));
        }
        
        // ???????????????????????????????????????????????????????????????
        if( poParams.aDataDisPro.tCode == '1' ){
            let aDisProItems    = poParams.aDataDisPro.aItems;
            let tDisProList     = "";
            if( aDisProItems.length > 0 ){
                for(let i = 0; i < aDisProItems.length; i++){
                    let tDisProValue = accounting.formatNumber(aDisProItems[i]['FCXddValue'], <?=$nOptDecimalShow;?>, ',') == 0 ? '0.00' : accounting.formatNumber(aDisProItems[i]['FCXddValue'], <?=$nOptDecimalShow;?>, ',');
                    tDisProList += '<li class="list-group-item" style="padding-top: 1px;padding-bottom: 1px;"><label class="pull-left">'+ aDisProItems[i]['FTPmhName'] + '</label><label class="pull-right">' + tDisProValue + '</label><div class="clearfix"></div></li>';
                }
                
                $('#oulABBDataListPromotions').html(tDisProList);

                // ???????????????????????????????????????????????????????????????
                let cSDisProSumValue = accounting.formatNumber(aDisProItems[0]['FCXddSumValue'], <?=$nOptDecimalShow;?>, ',');
                $('#olbABBPromotionsSum').text(cSDisProSumValue);
                
            }
        }

        // ?????????????????? vat
        var aVatItems   = poParams.aEndOfBillVat.aItems;
        var tVatList    = "";
        if(aVatItems.length > 0){
            for(var i = 0; i < aVatItems.length; i++){
                var tVatRate = accounting.formatNumber(aVatItems[i]['FCXtdVatRate'], 0, ',');
                var tSumVat  = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(0) == 0 ? '0.00' : accounting.formatNumber(aVatItems[i]['FCXtdVat'], <?=$nOptDecimalShow;?>, ',');
                var tSumVat  = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?=$nOptDecimalShow?>) == 0 ? '0.00' : accounting.formatNumber(aVatItems[i]['FCXtdVat'], <?=$nOptDecimalShow;?>, ',');
                tVatList += '<li class="list-group-item" style="padding-top: 1px;padding-bottom: 1px;"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' + tSumVat + '</label><div class="clearfix"></div></li>';
            }
        }
        $('#oulABBDataListVat').html(tVatList);
        
        // ???????????????????????????????????????????????????????????????
        var cSumVat     = poParams.aEndOfBillVat.cVatSum;
        $('#olbABBVatSum').text(accounting.formatNumber(cSumVat, <?=$nOptDecimalShow;?>, ','));

        /* ================================================= Right End Of Bill ================================================ */
        var cCalFCXphGrand      = poParams.aEndOfBillCal.cCalFCXphGrand;
        var cSumFCXtdAmt        = poParams.aEndOfBillCal.cSumFCXtdAmt;
        var cSumFCXtdNet        = poParams.aEndOfBillCal.cSumFCXtdNet;
        var cSumFCXtdNetAfHD    = poParams.aEndOfBillCal.cSumFCXtdNetAfHD;
        var cSumFCXtdVat        = poParams.aEndOfBillCal.cSumFCXtdVat;
        var tDisChgTxt          = poParams.aEndOfBillCal.tDisChgTxt;
        let cXshRnd             = poParams.aEndOfBillCal.cXshRnd;
        
        // ????????????????????????????????????
        $('#olbABBSumFCXtdNet').text(cSumFCXtdNet);
        // ??????/???????????????
        $('#olbABBSumFCXtdAmt').text(cSumFCXtdAmt);
        // ????????????????????????????????????/???????????????
        $('#olbABBSumFCXtdNetAfHD').text(cSumFCXtdNetAfHD);
        // ???????????????????????????????????????????????????????????????
        $('#olbABBSumFCXtdVat').text(cSumFCXtdVat);
        // ????????????????????????????????????????????????????????????
        $('#olbABBCalFCXphGrand').text(cCalFCXphGrand);
        //?????????????????????/??????????????? ?????????????????????
        $('#olbABBDisChgHD').text(tDisChgTxt);
        // ???????????????????????????
        $('#olbABBRound').text(cXshRnd);
    }
 
</script>