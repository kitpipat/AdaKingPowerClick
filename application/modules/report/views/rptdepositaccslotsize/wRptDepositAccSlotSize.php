<style>
  body{
      padding:20px 5%;
  }
  th{
      border-bottom:1px solid;
      border-top:1px solid;
  }
  th,td{
      padding: 5px 0px 5px 0px;
      font-size:13px;
  }
  .number{
      text-align:right;
  }
  table{
      width:100%;
  }
  .sum-footer{
      text-align:left;
  }
  .pagination{
      font-size:12px;
      padding: 7px 0px;
      border:1px solid #333;
  }
</style>

<p>รายงานตัวอย่างที่ 1</p>

<table cellspacing="0">
<tr>
    <th width="30%">ร้านค้า</th>
    <th width="40%">ตู้ล็อกเกอร์</th>
    <th width="15%">ขนาด</th>
    <th width="15%">จำนวนบิล(ฝาก)</th>
</tr>

<?php if(!empty($DataSource['aRptData'])){?>
<?php
        

$nSumQty = 0;
$nSumDis = 0;
$nSumNet = 0;

$nSumFooterQty = 0;
$nSumFooterDis = 0;
$nSumFooterNet = 0;



foreach ($DataSource['aRptData'] as $key=>$value) { ?>
    
            <?php
                // echo '<pre>';
                // print_r($value);
                // Step 1 เตรียม Parameter สำหรับการ Groupping
                $tShpName = $value["FTShpName"];  
                $tPosCode = 'POS '.$value["FTPosCode"]; 

                $nGroupMember = $value["Qtybill"]; 
                $nRowPartID = $value["FNRowPartID"]; 
            ?>

            <?php
                //Step 2 Groupping data
                $aGrouppingData = array($tShpName,$tPosCode);
                // Parameter
                //$nRowPartID = ลำดับตามกลุ่ม
                //$aGrouppingData = ข้อมูลสำหรับ Groupping
                FCNMtRPTHeadGroupping($nRowPartID,$aGrouppingData);
                //   $CI->FCNMtRPTHeadGroupping($nRowPartID,$aGrouppingData);
            //    $Sum = $this->$CI->FCNMtRPTSum(5,10);
            //    echo '=='.$Sum; exit();
            ?>


            <!-- Step 2 แสดงข้อมูลใน TD -->
            <tr>
               
                <td></td>
                <td><?php echo $value["FTPosCode"];?></td>
                <td class="number" style="text-align:center;"><?php echo $value["FTPzeName"];?></td>
                <td class="number"><?php echo $value["FTXhdQty"];?></td>
            </tr>

<?php

   //Step 3 : เตรียม Parameter สำหรับ Summary SubFooter
   $nSumQty = $value["Qtybill_All"];
   $aSumFooter = array('รวม','N','N',$nSumQty);

   //Step 4 : สั่ง Summary SubFooter
  

   //Parameter 
   //$nGroupMember = จำนวนข้อมูลทั้งหมดในกลุ่ม
   //$nRowPartID = ลำดับข้อมูลในกลุ่ม
   //$aSumFooter =  ข้อมูล Summary SubFooter
   $nStaNewGroup = FCNMtRPTSumSubFooter($nGroupMember,$nRowPartID,$aSumFooter);


    //Step 5 เตรียม Parameter สำหรับ SumFooter
//    $nSumFooterQty = number_format($value["FCSdtQtyFooter"]);
//    $nSumFooterDis = number_format($value["FCSdtDisFooter"],2);
//    $nSumFooterNet = number_format($value["FCSdtNetFooter"],2);

//    $paFooterSumData = array('รวมทั้งสิ้น','N','N','N',$nSumFooterQty,'N',$nSumFooterDis,$nSumFooterNet);

?>

<?php } // End for ?>
<?php 



   
   $nPageNo = $DataSource["aPagination"]["nDisplayPage"];
   $nTotalPage = $DataSource["aPagination"]["nTotalPage"];
    
//    //Step 6 : สั่ง Summary Footer
//    $CI->FCNMtRPTSumFooter($nPageNo,$nTotalPage,$paFooterSumData);

?>
</table>

        <!-- แสดงข้อมูล Footer -->
        <div class="pagination">
            <div class="row">
                <div class="col-6">
                     พบข้อมูล    <?php echo $DataSource["aPagination"]["nTotalRecord"];?> รายการ 
                     แสดงหน้า    <?php echo $DataSource["aPagination"]["nDisplayPage"];?>  /  
                                <?php echo $DataSource["aPagination"]["nTotalPage"];?>
                </div>
                <div class="col-6">
                    <?php 
                        $nCurrentPage = $DataSource["aPagination"]["nDisplayPage"]; 
                        for($p = 1;$p <= $DataSource["aPagination"]["nTotalPage"];$p++){
                    ?>
                    <!-- <?php  $tPage="rptDpsSize"; ?> -->
                    <a href="<?=base_url($tPage)?>"> [<?=$p?>] </a> 
                    <?php } ?>
                </div>
            </div>

        </div>
        <!-- จบแสดงข้อมูล Footer -->

<?php } else {

// echo "Empty";

}
?>