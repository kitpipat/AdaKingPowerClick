

<?php 
    if($tCode=='1'){
            foreach($aItems as $aValue){
 ?>
            <tr class="xCNTextDetail2 xSelectSaleBillHD" 
                data-ftbchcode="<?=$aValue['FTBchCode']?>"
                data-ftbchname="<?=$aValue['FTBchName']?>"
                data-ftshpcode="<?=$aValue['FTShpCode']?>"
                data-ftshpname="<?=$aValue['FTShpName']?>"
                data-ftposcode="<?=$aValue['FTPosCode']?>"
                data-ftposname="<?=$aValue['FTPosName']?>"
                data-docno="<?=$aValue['FTXshDocNo']?>"
                data-docdate="<?=date('Y-m-d',strtotime($aValue['FDXshDocDate']))?>"
                data-ftcstcode="<?=$aValue['FTCstCode']?>"
                data-ftcstname="<?=$aValue['FTCstName']?>"
                data-ftrtecode="<?=$aValue['FTRteCode']?>"
                data-fcxrcrtefac="<?=$aValue['FCXrcRteFac']?>"
                data-ftrcvcode="<?=$aValue['FTRcvCode']?>"
                data-ftrcvname="<?=$aValue['FTRcvName']?>"
              >
                    <td ><?=$aValue['FTBchName']?></td>
                    <td ><?=$aValue['FTPosName']?></td>
                    <td ><?=$aValue['FTXshDocNo']?></td>
                    <td ><?=date('d/m/Y H:i:s',strtotime($aValue['FDXshDocDate']))?></td>
                    <td ><?=$aValue['FTCstName']?></td>
            </tr>
<?php
            }
}else{ ?>

<tr>
<td colspan="5" align="center"><?php echo language('document/returnsale/returnsale','tRSRefDocBillEmpty');?></td>
</tr>
<?php  } ?>
<script>
$('.xSelectSaleBillHD').unbind().click(function(){
    JCNxOpenLoading();
    $('.xSelectSaleBillHD').removeClass('active');
    $(this).addClass('active');
  let  ftbchcode =  $(this).data('ftbchcode');
  let  ftbchname =  $(this).data('ftbchname');
  let  ftshpcode =  $(this).data('ftshpcode');
  let  ftshpname =  $(this).data('ftshpname');
  let  ftposcode =  $(this).data('ftposcode');
  let  ftposname =  $(this).data('ftposname');
  let  docno     =  $(this).data('docno');
  let  docdate   =  $(this).data('docdate');
  let  ftcstcode =  $(this).data('ftcstcode');
  let  ftcstname =  $(this).data('ftcstname');
  let  ftrtecode =  $(this).data('ftrtecode');
  let  fcxrcrtefac =  $(this).data('fcxrcrtefac');
  let  ftrcvcode =  $(this).data('ftrcvcode');
  let  ftrcvname =  $(this).data('ftrcvname');

  let oParameterBill = {
        FTBchCode : ftbchcode,
        FTBchName : ftbchname,
        FTShpCode : ftshpcode,
        FTShpName : ftshpname,
        FTPosCode : ftposcode,
        FTPosName : ftposname,
        FTXshDocNo : docno,
        FDXshDocDate : docdate,
        FTCstCode : ftcstcode,
        FTCstName : ftcstname,
        FTRteCode : ftrtecode,
        FCXrcRteFac : fcxrcrtefac,
        FTRcvCode : ftrcvcode,
        FTRcvName : ftrcvname,
  }

  var tParameterBillHD = JSON.stringify(oParameterBill);
    $('#ohdParameterBillHD').val(tParameterBillHD);
    
    JSxRSFindBillSaleVDDetail(docno);

});

</script>