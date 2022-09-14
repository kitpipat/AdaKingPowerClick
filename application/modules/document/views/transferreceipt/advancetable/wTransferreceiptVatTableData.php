  <?php //print_r($aDataVatDT); ?>
  <div class="table-responsive" style="height: 100px;overflow-y: scroll;">
    <table class="table table-striped xWPdtTableFont" style="margin-bottom: 0px;">
        <tbody id="odvTBodyTWIVat">
            <?php $cSumFCXtdVat = 0; ?>
            <?php if(is_array($aDataVatDT) == 1){
                
            ?>
            <?php foreach($aDataVatDT AS $value){?> 
                <tr>
                    <td class='text-left xCNTextDetail2'><span style="margin-left:25px;">ภาษีมูลค่าเพิ่ม</span></td>
                    <td class='text-right xCNTextDetail2'><span><?php echo number_format($value['FCXtdVatRate'], $nOptDecimalShow, '.', ','); ?> % </span></td>
                    
                    <?php if($tXthVATInOrEx == 1){?>
                        <td class='text-right xCNTextDetail2'><span><?php echo number_format($value['FCXtdVat'], $nOptDecimalShow, '.', ','); ?>  </span></td>
                    <?php }else{ ?>
                        <td class='text-right xCNTextDetail2'><span><?php echo number_format(($value['FCXtdVatable']*-1), $nOptDecimalShow, '.', ','); ?>  </span></td>
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
                <!-- <tr>
                    <td class='text-left xCNTextDetail2' colspan='2'><span class="xCNLabelFrm">ยอดรวมภาษี</span></td>
                    <td class='text-right xCNTextDetail2' id="otdVatTotal"><span><?php echo  number_format($cSumFCXtdVat, $nOptDecimalShow, '.', ','); ?></span></td>
                </tr> -->
                
        <?php }else{ ?>
                    <tr style="height: 40px;"><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
        <?php } ?>
            <input type="text" class="xCNHide" id="ohdSumXtdVat" value="<?php echo  number_format($cSumFCXtdVat, $nOptDecimalShow, '.', ','); ?>">
        </tbody>
      </table>
  </div>

<script>

    //Get Data แล้ว เอาไป Put ใส่หน้า Add ที่เป็น ส้วนท้ายบิล
    nSumVat = $("#ohdSumXtdVat").val();
    $("#olaSumXtdVat").text(nSumVat);
    $("#olaVatTotal").text(nSumVat);


</script>