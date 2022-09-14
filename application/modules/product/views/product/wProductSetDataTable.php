<?php
//Decimal Show ลง 2 ตำแหน่ง
$nDecShow =  FCNxHGetOptionDecimalShow();
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <table id="otbPdtProductSetData" class="table table-striped">
        <thead>
            <tr>
            <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product','tPDTTBImg')?></th>
                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product', 'tPDTSetPdtCode') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:30%;"><?php echo language('product/product/product', 'tPDTSetPdtName') ?></th>
                <!-- <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product', 'tPDTCost') ?></th> -->
                <th nowrap class="text-right xCNTextBold" style="width:10%;"><?php echo language('product/product/product', 'tPDTSetPstQty') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product', 'tPDTTBUnit') ?></th>
                <!-- <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product', 'tPDTTBPrice') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product', 'tPDTTBSumPrice') ?></th> -->
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product', 'tPDTSetPstDel') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product', 'tPDTSetPstEdit') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($aItems) && is_array($aItems) && !empty($aItems)) : ?>
                <?php foreach ($aItems as $key => $aValue) : ?>
                    <?php
                    // $aUsrValue       = explode(',', $tStaUsrValue);
                    // $cPdtCost        = NULL;
                    // // $cSumPdtCost     = 0;
                    // // $nSumQty         = 0;
                    // // $cSumPrice       = 0;
                    // // $cSumPriceTotal  = 0;
                    // foreach ($aUsrValue as $tUsrValue) {
                    //     switch ($tUsrValue) {
                    //         case 1:
                    //             if ($cPdtCost == NULL) {
                    //                 $cPdtCost = $aValue['FCPdtCostAVGIN'];
                    //             }
                    //             break;
                    //         case 2:
                    //             if ($cPdtCost == NULL) {
                    //                 $cPdtCost = $aValue['FCPdtCostLast'];
                    //             }
                    //             break;
                    //         case 3:
                    //             if ($cPdtCost == NULL) {
                    //                 $cPdtCost = $aValue['FCPdtCostStd'];
                    //             }
                    //             break;
                    //         case 4:
                    //             if ($cPdtCost == NULL) {
                    //                 $cPdtCost = $aValue['FCPdtCostFIFOIN'];
                    //             }
                    //             break;
                    //         default:
                    //             $cPdtCost = NULL;
                    //             break;
                    //     }
                    // }

                    // //เช็คสินค้า เพื่อนำราคามาแสดง
                    // if ($aValue['FTPdtForSystem'] == '2') {
                    //     //ขายส่ง จะใข้ราคาขายส่ง (Whs)
                    //     $cPrice              = $aValue['FCPgdPriceWhs'];
                    //     $cTotalPrice         = $aValue['FCPgdPriceWhs'] * $aValue['FCPstQty'];
                    // } else {
                    //     //ปลีก ตั๋ว เข่า จะใข้ราคาขายปลีก (Net)
                    //     $cPrice              = $aValue['FCPgdPriceNet'];
                    //     $cTotalPrice         = $aValue['FCPgdPriceNet'] * $aValue['FCPstQty'];
                    // }

                    // @$cSumPdtCost     += $cPdtCost;
                    // @$nSumQty         += $aValue['FCPstQty'];
                    // @$cSumPrice       += $cPrice;
                    // @$cSumPriceTotal  += $cTotalPrice;

                   
                    // if(isset($aValue['FTImgObj']) && !empty($aValue['FTImgObj'])){
                    //     $tImgObj = substr($aValue['FTImgObj'],0,1);
                    //     $tStyle  = "";
                    //     // ตรวจสอบ Code Color Saharat(Golf)
                    //     if($tImgObj != '#'){
                    //         $aValueImgExplode = explode('/modules/',$aValue['FTImgObj']);
                    //         $tFullPatch = './application/modules/'.$aValueImgExplode[1];
                    //         if (file_exists($tFullPatch)){
                    //             $tPatchImg = base_url().'application/modules/'.$aValueImgExplode[1];
                    //         }else{
                    //             $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                    //         }

                    //     }else{  
                    //         $tPatchImg     = "0";
                    //         $tStyleName    = $aValue['FTImgObj'];
                    //   }
                    // }else{
                    //         $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                    // }
               
                    ?>
                    <tr id="otrPdtSetRow<?php echo $aValue['FTPdtCodeSet']; ?>" class="xWPdtSetRow" data-pdtcode="<?php echo $aValue['FTPdtCodeSet']; ?>" data-pdtname="<?php echo $aValue['FTPdtName']; ?>">
                        <td nowrap class="xCNBorderRight xWPdtImgtd"  style="padding-right:10px !important"><?=FCNtHGetImagePageList($aValue['FTImgObj'],'40px');?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTPdtCodeSet'] ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTPdtName'] ?></td>
                        <!-- <td nowrap class="text-right"><?php echo number_format($cPdtCost, $nDecShow) ?></td> -->
                        <td nowrap class="text-right"><?php echo number_format($aValue['FCPstQty'], $nDecShow) ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTPunName'] ?></td>
                        <!-- <td nowrap class="text-right"><?php echo number_format($cPrice, $nDecShow); ?></td> -->
                        <!-- <td nowrap class="text-right"><?php echo number_format($cTotalPrice, $nDecShow); ?></td> -->
                        <td nowrap class="text-center"><img class="xCNIconTable xWPdtSetDelete xCNIconDelete"></td>
                        <td nowrap class="text-center"><img class="xCNIconTable xWPdtSetEdit xCNIconEdit"></td>
                    </tr>
                <?php endforeach; ?>


            <?php else : ?>
                <tr class="xWPdtSetNoData">
                    <td class="text-center xCNTextDetail2" colspan="99"><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php endif; ?>
        </tbody>

        <!-- Sum Product Set -->
        <?php if (isset($aItems) && is_array($aItems) && !empty($aItems)) : ?>
            <!-- <thead> -->
                <!-- <tr> -->
                    <!-- <th nowrap colspan="3">จำนวนรายการสินค้าในชุด</th> -->
                    <!-- <th nowrap class="text-right xCNTextBold"><?php echo number_format($cSumPdtCost, $nDecShow) ?></th> -->
                    <!-- <th nowrap class="text-right xCNTextBold"><?php echo number_format($nSumQty, $nDecShow) ?></th> -->
                    <!-- <th nowrap class="text-right xCNTextBold"><?php echo number_format($cSumPrice, $nDecShow); ?></th>
                    <th nowrap class="text-right xCNTextBold"><?php echo number_format($cSumPriceTotal, $nDecShow); ?></th> -->
                    <!-- <th nowrap colspan="3">รายการ</th> -->
                <!-- </tr> -->
            <!-- </thead> -->
        <?php endif; ?>
    </table>
</div>

<!-- ===================================================== Modal Delete Product Set ===================================================== -->
<div id="odvModalDeletePdtSet" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelPdtSet" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelPdtSet" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ====================================================== End Modal Delete Product Set ======================================================= -->


<?php include "script/jProductSetDataTable.php"; ?>