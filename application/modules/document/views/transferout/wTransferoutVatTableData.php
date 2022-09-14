<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 panel panel-default" style="background: white;height: 180px;">
    <div class="row" style="background: #eeeeee;">					
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="xCNLabelFrm" style="margin:5px 0 5px;"><?php echo $tTXOTotalText;?></label>
        </div>
    </div>
    <div class="row" id="odvTXOVatPanalTable">
        <div class="table-responsive" style="height: 100px;overflow-y:scroll;">
            <table class="table">
                <tbody>
                    <?php $cSumFCXtdVat = 0; ?>
                    <?php if(isset($aDataVatDT) &&  $aDataVatDT['rtCode'] == '1'):?>
                        <?php foreach($aDataVatDT['raItems'] AS $aValue):?> 
                            <tr>
                                <td class='text-left xCNTextDetail2'><span style="margin-left:25px;"><?php echo language('document/transferout/transferout','tTXOTBVatRate');?></span></td>
                                <td class='text-right xCNTextDetail2'><span><?php echo number_format($aValue['FCXtdVatRate'], $nOptDecimalShow, '.', ','); ?> % </span></td>
                                <?php if($tTXOVATInOrEx == 1){?>
                                    <td class='text-right xCNTextDetail2'><label><?php echo number_format($aValue['FCXtdVat'], $nOptDecimalShow, '.', ','); ?>  </label></td>
                                <?php }else{ ?>
                                    <td class='text-right xCNTextDetail2'><label><?php echo number_format(($aValue['FCXtdVatable']*-1), $nOptDecimalShow, '.', ','); ?>  </label></td>
                                <?php } ?>
                            </tr>
                            <?php 
                                if($tTXOVATInOrEx == 1){
                                    $cSumFCXtdVat   += $aValue['FCXtdVat'];
                                }else{
                                    $cSumFCXtdVat   += ($aValue['FCXtdVatable']*-1);
                                }
                            ?>
                        <?php endforeach; ?>
                        <input type="text" class="xCNHide" id="ohdSumXtdVat" value="<?php echo $cSumFCXtdVat?>">
                    <?php else: ?>
                        <tr nowrap style="height: 40px;"><td class='text-center xCNTextDetail2' colspan='100%'><?php echo  language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style="background: #eeeeee; padding-top: 6px; padding-bottom: 6px;">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout','tTXOTBVat');?></label>
                </div>
                <div class="col-lg-6 text-right">
                    <label class="xCNLabelFrm" id="olaTXOSumVat"><?php echo number_format($cSumFCXtdVat,$nOptDecimalShow,'.',',');?></label>
                </div>
            </div>
        </div>
    </div>
</div>