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

<div class="row p-t-10" id="odvTAXRowDataEndOfBill" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-group">
                    <?php 
                        if($aGetHD['rtCode'] == 1){
                            //มีข้อมูล
                            $FCXshTotal     = number_format($aGetHD['raItems'][0]['FCXshTotal'],2);
                            $FCXshDis       = number_format($aGetHD['raItems'][0]['FCXshDis'] + $aGetHD['raItems'][0]['FCXshChg'],2);
                            $nB4            = number_format($aGetHD['raItems'][0]['FCXshTotal'] - ($aGetHD['raItems'][0]['FCXshDis'] - $aGetHD['raItems'][0]['FCXshChg']),2);
                            $FCXshVat       = number_format($aGetHD['raItems'][0]['FCXshVat'],2);
                            $FCXshGrand     = number_format($aGetHD['raItems'][0]['FCXshGrand'],2);
                            $tGndText       = $aGetHD['raItems'][0]['FTXshGndText'];
                        }else{
                            //ไม่มีข้อมูล
                            $FCXshTotal     = '0.00';
                            $FCXshDis       = '0.00';
                            $nB4            = '0.00';
                            $FCXshVat       = '0.00';
                            $FCXshGrand     = '0.00';
                            $tGndText       = 'บาท';
                        }
                    ?>
                    <li class="list-group-item">
                        <label class="pull-left mark-font"><?=language('sale/salemonitor/salemonitor','tTAXTBSumFCXtdNet');?></label>
                        <label class="pull-right mark-font" id="olbTAXSumFCXtdNet"><?=$FCXshTotal?></label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('sale/salemonitor/salemonitor','tTAXTBDisChg');?></label>
                        <label class="pull-left" style="margin-left: 5px;" id="olbTAXDisChgHD"></label>
                        <label class="pull-right" id="olbTAXSumFCXtdAmt"><?=$FCXshDis?></label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('sale/salemonitor/salemonitor','tTAXTBSumFCXtdNetAfHD');?></label>
                        <label class="pull-right" id="olbTAXSumFCXtdNetAfHD"><?=$nB4?></label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('sale/salemonitor/salemonitor','tTAXTBSumFCXtdVat');?></label>
                        <label class="pull-right" id="olbTAXSumFCXtdVat"><?=$FCXshVat?></label>
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?=language('sale/salemonitor/salemonitor','tTAXTBFCXphGrand');?></label>
                <label class="pull-right mark-font" id="olbTAXCalFCXphGrand"><?=$FCXshGrand?></label>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var tGndText = '<?=$tGndText?>';
    $('#olbGrandText').text(tGndText);
</script>
