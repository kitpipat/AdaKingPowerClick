
<?php if(isset($aPdtDetailList[0]->FTPdtCode)){ ?>
   
    <?php foreach($aPdtDetailList as $Key=>$Value){?>
        
        <tr class="panel-collapse collapse in xWPdtlistDetail<?php echo $Value->FTPdtCode?>" data-pdtcode="<?php echo $Value->FTPdtCode?>" onclick="JSxPDTPushMultiSelection('<?php echo $Value->FTPdtCode?>','<?php echo $Value->FTPunCode?>','<?php echo $Value->FTBarCode?>',this);">
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left"><?php echo $Value->FTBarCode?></td>
            <td class="text-left"><?php echo $Value->FCPdtUnitFact != '' ? number_format($Value->FCPdtUnitFact, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ','); ?></td>
            <td class="text-left"><?php echo $Value->FTPunName?></td>
            <td class="text-left"><?php echo $Value->FCPdtQtyBal; ?></td>
            <?php 
            //คำนวนต้นทุนเฉลีย
                //1 ต้นทุนเฉลี่ย
                if($nCostPurPO == 1){
                    if($tXphVATInOrEx == 1){
                        $cPdtCostPrice = $Value->FCPdtCostIn != '' ? $Value->FCPdtCostIn : 0;
                    }else{
                        $cPdtCostPrice = $Value->FCPdtCostEx != '' ? $Value->FCPdtCostEx : 0;
                    }

                //2 ต้นทุนสุดท้าย
                }else if($nCostPurPO == 2){
                    $cPdtCostPrice = $Value->FCSplLastPrice != '' ? $Value->FCSplLastPrice : 0;

                //3 ต้นทุนมาตรฐาน 
                }else if($nCostPurPO == 3){
                    $cPdtCostPrice = $Value->FCPdtCostStd != '' ? $Value->FCPdtCostStd : 0;
                }

                //คูณกับ PdtUnitFact
                $cPdtCostPriceRES = $cPdtCostPrice*$Value->FCPdtUnitFact;

            //คำนวนต้นทุนเฉลีย
            ?>
            <td class="text-left"><?=  $cPdtCostPriceRES != '' ? number_format($cPdtCostPriceRES, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ','); ?></td>
        </tr> 
    <?php } ?>
<?php }else{ ?>
        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
<?php } ?>
