<style>
    .table tbody tr,
    .table>tbody>tr>td {
        font-size: 18px !important;
    }

    .table thead th,
    .table>thead>tr>th {
        font-family: THSarabunNew-Bold !important;
        font-size: 18px !important;
    }
</style>
<div class="panel-body">
    <div class="row">
        <div class="table-responsive">
            <table class="table">
                <thead class="xCNPanelHeadColor">
                    <tr class="xCNCenter">
                        <th nowrap class="xCNTextBold" width="40%" rowspan="2" style="vertical-align: middle;color:white !important;"><?=language('sale/salemonitor/salemonitor', 'tSMTRcvCode')?></th>
                        <th nowrap class="xCNTextBold" width="20%" colspan="2" style="vertical-align: middle;color:white !important;"><?=language('sale/salemonitor/salemonitor', 'tSMTSysData')?></th>
                        <th nowrap class="xCNTextBold" width="20%" colspan="2" style="vertical-align: middle;color:white !important;"><?=language('sale/salemonitor/salemonitor', 'tSMTShiftUsr')?></th>
                        <th nowrap class="xCNTextBold" width="20%" colspan="2" style="vertical-align: middle;color:white !important;"><?=language('sale/salemonitor/salemonitor', 'tSMTShiftConf')?></th>
                    </tr>
                    <tr class="xCNCenter">
                        <th nowrap class="xCNTextBold" width="10%" style="vertical-align: middle;color:white !important;"><?=language('sale/salemonitor/salemonitor', 'tSMTShiftUseAmt')?></th>
                        <th nowrap class="xCNTextBold" width="10%" style="vertical-align: middle;color:white !important;"><?=language('sale/salemonitor/salemonitor', 'tSMTShiftSumRcv')?></th>
                        <th nowrap class="xCNTextBold" width="10%" style="vertical-align: middle;color:white !important;"><?=language('sale/salemonitor/salemonitor', 'tSMTShiftSumRcv')?></th>
                        <th nowrap class="xCNTextBold" width="10%" style="vertical-align: middle;color:white !important;"><?=language('sale/salemonitor/salemonitor', 'tSMTShiftDiff')?></th>
                        <th nowrap class="xCNTextBold" width="10%" style="vertical-align: middle;color:white !important;"><?=language('sale/salemonitor/salemonitor', 'tSMTShiftSumRcv')?></th>
                        <th nowrap class="xCNTextBold" width="10%" style="vertical-align: middle;color:white !important;"><?=language('sale/salemonitor/salemonitor', 'tSMTShiftDiff')?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    foreach($aDataRcvApv['aItems'] AS $nKey => $aValue){
                        //              value > 0            และ           อนุมัติแล้ว            หรือ           ยังไม่อนุมัติ
                        if( ($aValue['FTStaHideOnApv'] == '2' && $aValue['FTShdStaPrc'] == '1') || $aValue['FTShdStaPrc'] != '1' ){ 
                        //             ถ้าอนุมัติแล้ว จะแสดงเฉพาะรายการที่มี value > 0                        ถ้ายังไม่อนุมัติแสดงทั้งหมด
                ?>
                        <tr data-rcvcode="<?=$aValue['FTRcvCode']?>" data-seqno="<?=$aValue['FNSdtSeqNo']?>" >
                            <?php 
                                if( $aValue['FNSdtSeqNo'] == 1 ){ 
                                    $tClassBold = "style='font-weight: bold;vertical-align: middle;'"; 
                            ?>
                                <td class="text-left" <?=$tClassBold?>><?="(".$aValue['FTRcvCode'].") ".$aValue['FTRcvName']?></td>
                            <?php 
                                }else{
                                    $tClassBold = "style='vertical-align: middle;'"; 
                                    $tSpacebar = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
                            ?>
                                <?php if( $aValue['FTRcvRefType'] == '1' ){ ?>
                                    <td class="text-left"><?=$tSpacebar."(".$aValue['FTRcvRefNo1'].") ".$aValue['FTRcvRefNo2']?></td>
                                <?php }else if( $aValue['FTRcvRefType'] == '2' ){ ?>
                                    <td class="text-left"><?=$tSpacebar."Voucher : ".$aValue['FTRcvRefNo2']?></td>
                                <?php } ?>
                            <?php } ?>
                            <td class="text-right" <?=$tClassBold?>><?=number_format($aValue['FNRcvUseAmt'],$nOptDecimalShow)?></td>
                            <td class="text-right" <?=$tClassBold?>><?=number_format($aValue['FCRcvPayAmt'],$nOptDecimalShow)?></td>
                            <td class="text-right" <?=$tClassBold?>><?=number_format($aValue['FCRcvUsrKeyAmt'],$nOptDecimalShow)?></td>
                            <td class="text-right" <?=$tClassBold?>><?=number_format($aValue['FCRcvUsrKeyDiff'],$nOptDecimalShow)?></td>
                            <td class="text-right">
                                <?php 
                                    if( $aValue['FTShdStaPrc'] == '1' || ($aValue['FNMaxSeqNo'] > 1 && $aValue['FNSdtSeqNo'] == 1) ){
                                        $tStaShwInput = "xCNHide";
                                        $tStaShwSpan  = "";
                                    }else{
                                        $tStaShwInput = "";
                                        $tStaShwSpan  = "xCNHide";
                                    }
                                ?>
                                <input type="text" class="form-control <?=$tStaShwInput?> xCNInputNumericWithDecimal text-right xWSMTSupKeyAmt" id="ohdSMTSupKayAmt<?="_".$aValue['FTRcvCode']."_".$aValue['FNSdtSeqNo']?>" maxlength="10" value="<?=number_format($aValue['FCRcvSupKeyAmt'],$nOptDecimalShow)?>" autocomplete="off">
                                <span class="xWSMTSupShwAmt <?=$tStaShwSpan?>" <?=$tClassBold?>><?=number_format($aValue['FCRcvSupKeyAmt'],$nOptDecimalShow)?></span>
                            </td>
                            <td class="text-right" <?=$tClassBold?>><?=number_format($aValue['FCRcvSupKeyDiff'],$nOptDecimalShow)?></td>
                        </tr>
                <?php 
                        }
                    } 
                ?>
                    <tr>
                        <td nowrap class="text-right"><b><?=language('sale/salemonitor/salemonitor', 'tSMTShiftSum')?></b></td>
                        <td nowrap class="text-right"></td>
                        <td nowrap class="text-right"><b><?=number_format($aDataRcvApv['aItems'][0]['FCSumRcvPayAmt'],$nOptDecimalShow)?></b></td>
                        <td nowrap class="text-right"><b><?=number_format($aDataRcvApv['aItems'][0]['FCSumRcvUsrKeyAmt'],$nOptDecimalShow)?></b></td>
                        <td nowrap class="text-right"><b><?=number_format($aDataRcvApv['aItems'][0]['FCSumRcvUsrKeyDiff'],$nOptDecimalShow)?></b></td>
                        <td nowrap class="text-right"><b><?=number_format($aDataRcvApv['aItems'][0]['FCSumRcvSupKeyAmt'],$nOptDecimalShow)?></b></td>
                        <td nowrap class="text-right"><b><?=number_format($aDataRcvApv['aItems'][0]['FCSumRcvSupKeyDiff'],$nOptDecimalShow)?></b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

    // var tStaPrc = $('#ohdSMTStaPrc').val();
    // if( tStaPrc == '1' ){
    //     $('.xWSMTSupKeyAmt').hide();
    //     $('.xWSMTSupShwAmt').show();
    // }else{
    //     $('.xWSMTSupKeyAmt').show();
    //     $('.xWSMTSupShwAmt').hide();
    // }

    //Create By : Napat(Jame) 25/03/2022
    $('.xWSMTSupKeyAmt').off('change').on('change',function(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "salemonitorShiftEditInline",
            data: {
                ptShfCode   : $('#ohdSMTShfCode').val(),
                ptBchCode   : $('#ohdSMTBchCode').val(),
                ptRcvCode   : $(this).parents().parents().attr('data-rcvcode'),
                pnRcvSeqNo  : $(this).parents().parents().attr('data-seqno'),
                pcSupKey    : $(this).val()
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                if( aReturnData['tCode'] == '1' ){
                    JSxSMTShiftRcvDataList();
                }else{
                    FSvCMNSetMsgWarningDialog(aReturnData['tDesc']);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    });
</script>