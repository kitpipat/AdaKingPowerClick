

<?php 
  $nOptDecimalShow = FCNxHGetOptionDecimalShow();
    if($tCode=='1'){
            foreach($aItems as $aValue){
 ?>
            <tr class="xCNTextDetail2 xSelectSaleBillDT" 
                data-ftbchcode="<?=$aValue['FTBchCode']?>"
                data-docno="<?=$aValue['FTXshDocNo']?>"
              >
                    <td align="center">           
                        <label class="fancy-checkbox xRSSelectPdtLabel">
                            <input type="checkbox" class="xRSSelectPdt" name="ocbRSSelectPdt" id="ocbRSSelectPdt"  value="<?=$aValue['FNXsdSeqNo']?>" checked >
                            <span class="">&nbsp;</span>
                        </label>
                     </td>

                    <td ><?=$aValue['FTPdtCode']?></td>
                    <td ><?=$aValue['FTXsdPdtName']?></td>
                    <td ><?=$aValue['FTPunCode']?><?=' - '.$aValue['FTPunName']?></td>
                    <td align="right" ><?=number_format($aValue['FCXsdQty'],$nOptDecimalShow)?></td>
                    <td align="right" ><?=number_format($aValue['FCXsdSetPrice'],$nOptDecimalShow)?></td>
                    <td  align="right"><?=number_format($aValue['FCXddValue'],$nOptDecimalShow)?></td>
                    <td  align="right"><?=number_format($aValue['FCXsdNetAfHD'],$nOptDecimalShow)?></td>
            </tr>
<?php
            }
}else{ ?>

<tr>
<td colspan="8" align="center"><?php echo language('document/returnsale/returnsale','tRSRefDocBillEmpty');?></td>
</tr>
<?php  } ?>
<script>


$('.xRSSelectPdt').unbind().click(function(){
 var nCounChecked = 0;
        $('.xRSSelectPdt').each(function(){
            if($(this).prop('checked')==false){
                nCounChecked++;
            }
        });
        if(nCounChecked>0){
            $('#ocbRSSelectPdtAll').prop('checked',false);
        }else{
            $('#ocbRSSelectPdtAll').prop('checked',true);
        }
});


$('#ocbRSSelectPdtAll').unbind().click(function(){
        if($(this).prop('checked')==true){
            $('.xRSSelectPdt').prop('checked',true);
        }else{
            $('.xRSSelectPdt').prop('checked',false);
        }
});
</script>