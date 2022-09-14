<style>
    #odvTAXRowDataEndOfBill .panel-heading{
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
    #odvTAXRowDataEndOfBill .panel-body{
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }
    #odvTAXRowDataEndOfBill .list-group-item {
        padding-left: 0px !important;
        padding-right: 0px !important;
        border: 0px Solid #ddd;
    }
    .mark-font, .panel-default > .panel-heading.mark-font{
        color: #232C3D !important;
        font-weight: 900;
    }
</style>
<?php $nOptDecimalShow = FCNxHGetOptionDecimalShow(); ?>
<div id="odvTAXRowDataEndOfBill" >

    <div class="panel panel-default" style="margin-bottom: 20px;">
        <div class="panel-heading mark-font" id="olbGrandText">บาท</div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="list-group">
                <?php 
                    if($aGetHD['rtCode'] == 1){
                        //มีข้อมูล
                        $FCXshTotal     = number_format($aGetHD['raItems'][0]['FCXshTotal'], $nOptDecimalShow);
                        $FCXshDis       = number_format($aGetHD['raItems'][0]['FCXshDis'] + $aGetHD['raItems'][0]['FCXshChg'], $nOptDecimalShow);
                        $nB4            = number_format($aGetHD['raItems'][0]['FCXshTotal'] - ($aGetHD['raItems'][0]['FCXshDis'] - $aGetHD['raItems'][0]['FCXshChg']), $nOptDecimalShow);
                        $FCXshVat       = number_format($aGetHD['raItems'][0]['FCXshVat'], $nOptDecimalShow);
                        $FCXshGrand     = number_format($aGetHD['raItems'][0]['FCXshGrand'], $nOptDecimalShow);
                        $tGndText       = $aGetHD['raItems'][0]['FTXshGndText'];
                        $cXshRnd        = number_format($aGetHD['raItems'][0]['FCXshRnd'], $nOptDecimalShow);
                    }else{
                        //ไม่มีข้อมูล
                        $FCXshTotal     = '0.00';
                        $FCXshDis       = '0.00';
                        $nB4            = '0.00';
                        $FCXshVat       = '0.00';
                        $FCXshGrand     = '0.00';
                        $tGndText       = 'บาท';
                        $cXshRnd        = '0.00';
                    }
                ?>
                <li class="list-group-item">
                    <label class="pull-left mark-font"><?=language('document/taxinvoice/taxinvoice','tTAXTBSumFCXtdNet');?></label>
                    <label class="pull-right mark-font" id="olbTAXSumFCXtdNet"><?=$FCXshTotal?></label>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item">
                    <label class="pull-left"><?=language('document/taxinvoice/taxinvoice','tTAXTBDisChg');?></label>
                    <label class="pull-left" style="margin-left: 5px;" id="olbTAXDisChgHD"></label>
                    <label class="pull-right" id="olbTAXSumFCXtdAmt"><?=$FCXshDis?></label>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item">
                    <label class="pull-left"><?=language('document/taxinvoice/taxinvoice','tTAXTBSumFCXtdNetAfHD');?></label>
                    <label class="pull-right" id="olbTAXSumFCXtdNetAfHD"><?=$nB4?></label>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item">
                    <label class="pull-left"><?=language('document/taxinvoice/taxinvoice','tTAXTBSumFCXtdVat');?></label>
                    <label class="pull-right" id="olbTAXSumFCXtdVat"><?=$FCXshVat?></label>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item">
                    <label class="pull-left"><?=language('document/document/document','tDocRound');?></label>
                    <label class="pull-right" id="olbTAXRound"><?=$cXshRnd?></label>
                    <div class="clearfix"></div>
                </li>
            </ul>
        </div>
        <div class="panel-heading">
            <label class="pull-left mark-font"><?=language('document/taxinvoice/taxinvoice','tTAXTBFCXphGrand');?></label>
            <label class="pull-right mark-font" id="olbTAXCalFCXphGrand"><?=$FCXshGrand?></label>
            <div class="clearfix"></div>
        </div>
    </div>
    
</div>

<script>
    var tGndText = '<?=$tGndText?>';
    $('#olbGrandText').text(tGndText);
</script>
