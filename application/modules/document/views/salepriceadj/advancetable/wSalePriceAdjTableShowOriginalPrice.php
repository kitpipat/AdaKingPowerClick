
<?php 
    // echo $tSQL;
    if($nStaEvent == 1){
        echo "<h3>".$aPdtData4PDT['FTPdtCode']." ".$aPdtData4PDT['FTPdtName']."</h3>";
    }
?>

<table class="table table-bordered table-striped" id="otbOrderListDetail">
    <tr class="xCNCenter">
        <th nowrap width="40%"><?= language('document/salepriceadj/salepriceadj','tPdtPriTBPunCode')?></th>
        <th nowrap width="20%"><?= language('document/salepriceadj/salepriceadj','tPdtPriTBPriceRet')?></th>
        <!-- <th nowrap width="20%"><?= language('document/salepriceadj/salepriceadj','tPdtPriTBPriceWhs')?></th>
        <th nowrap width="20%"><?= language('document/salepriceadj/salepriceadj','tPdtPriTBPriceNet')?></th> -->
    </tr> 
    <?php if($nStaEvent == 1){?>
    <tr>
        <td nowrap class="text-center"><?=$aPdtData4PDT['FTPunName']?></td>
        <td nowrap class="text-right"><?=number_format($aPdtData4PDT['FCPgdPriceRet'], $nOptDecimal);?></td>
        <!-- <td nowrap class="text-right"><?=number_format($aPdtData4PDT['FCPgdPriceWhs'], $nOptDecimal);?></td>
        <td nowrap class="text-right"><?=number_format($aPdtData4PDT['FCPgdPriceNet'], $nOptDecimal);?></td> -->
    </tr>
    <?php }else{ ?>
        <tr><td nowrap colspan="4" class="text-center">ไม่พบข้อมูล</td></tr>
    <?php } ?>

</table>
