  <?php //print_r($aDataVatDT); ?>
  <div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" style="margin-bottom: 0px;">
        <tbody id="odvTBodyVat">
            <?php if(is_array($aDataVatDT) == 1){
                $cSumFCXtdVat = 0;    
            ?>
            <?php foreach($aDataVatDT AS $value){?> 
                <tr>
                    <td class='text-left xCNTextDetail2'><label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOTBVatRate') ?></label></td>
                    <td class='text-right xCNTextDetail2'><label><?php echo number_format($value['FCXtdVatRate'], $nOptDecimalShow, '.', ','); ?> % </label></td>
                    
                    <?php if($tXthVATInOrEx == 1){?>
                        <td class='text-right xCNTextDetail2'><label><?php echo number_format($value['FCXtdVat'], $nOptDecimalShow, '.', ','); ?>  </label></td>
                    <?php }else{ ?>
                        <td class='text-right xCNTextDetail2'><label><?php echo number_format(($value['FCXtdVatable']*-1), $nOptDecimalShow, '.', ','); ?>  </label></td>
                    <?php } ?>
                </tr>
                <?php 
                    if($tXthVATInOrEx == 1){
                        $cSumFCXtdVat += $value['FCXtdVat'];
                    }else{
                        $cSumFCXtdVat += ($value['FCXtdVatable']*-1);
                    }
                ?>
            <?php } ?>
                <tr>
                    <td class='text-left xCNTextDetail2' colspan='2'><label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOTBVat') ?></label></td>
                    <td class='text-right xCNTextDetail2'><label><?php echo  number_format($cSumFCXtdVat, $nOptDecimalShow, '.', ','); ?></label></td>
                </tr>
                <input type="text" class="xCNHide" id="ohdSumXtdVat" value="<?=$cSumFCXtdVat?>">
        <?php }else{ ?>
                    <tr style="height: 40px;"><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
        <?php } ?>
         
        </tbody>
      </table>
  </div>
