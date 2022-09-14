<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbDOCCashTable">
        <thead>
            <tr class="xCNCenter">
                <th><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWTBNo')?></th>
                <th><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tADJPLSizeCode')?></th>
                <th><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tADJPLSizeName')?></th>
                <th><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tADJPLRateRentalCode')?></th>
                <th class="xWDeleteBtnEditButton"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $bCheckNodata = false;

            if($tPanelPdtStaShow==1){
                if($aData){
                    for($nI=0;$nI<FCNnHSizeOf($aData);$nI++){
                        if($aData[$nI]["FTPdtCode"]==""){
                            $bCheckNodata = true;
                            break;
                        }
                    }
                    if($bCheckNodata==false){

                    
                        for($nI=0;$nI<FCNnHSizeOf($aData);$nI++){
                    ?>
                        <tr class="xWPdtItem">
                            <td><label><?php echo $nI+1; ?></label></td>
                            <td><label><?php echo $aData[$nI]["FTPzeCodeForADJPL"]; ?></label></td>
                            <td><label><?php echo $aData[$nI]["FTSizNameForADJPL"]; ?></label></td>
                            <td><label style="width: 95%;"><?php 
                            if($aData[$nI]["FTRthCodeForADJPL"]!=""){
                                ?>
                                <div class="row">
                                    <div class="col-xs-2" style="padding-right: 5px;padding-left: 0px;">
                                        <button style="width:20px;height:20px;font-size: 20px;line-height: 20px;color: #424242;background-color: #CCCCCC;" class="xCNBTNPrimeryPlus" type="button" onclick="JSxSetToRateRentalModalSelect(this,{
                                            'FTBchCode':'<?php echo $aData[$nI]["FTBchCode"]; ?>',
                                            'FTBchCodeForADJPL':'<?php echo $aData[$nI]["FTBchCodeForADJPL"]; ?>',
                                            'FTMerCodeForADJPL':'<?php echo $aData[$nI]["FTMerCodeForADJPL"]; ?>',
                                            'FTShpCodeForADJPL':'<?php echo $aData[$nI]["FTShpCodeForADJPL"]; ?>',
                                            'FTXthDocNo':'<?php echo $aData[$nI]["FTXthDocNo"]; ?>',
                                            'FTXthDocKey':'<?php echo $aData[$nI]["FTXthDocKey"]; ?>',
                                            'FTSessionID':'<?php echo $aData[$nI]["FTSessionID"]; ?>',
                                            'FTPzeCodeForADJPL':'<?php echo $aData[$nI]["FTPzeCodeForADJPL"]; ?>',
                                            'FTRthCodeForADJPL':'<?php echo $aData[$nI]["FTRthCodeForADJPL"]; ?>'
                                        });"><img class="xCNIconTable" src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/edit.png"></button>
                                    </div>
                                    <div class="col-xs-10" style="padding-right: 5px;padding-left: 0px;">
                                        <span><?php echo $aData[$nI]["FTRthName"]; ?></span>
                                    </div>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class="row">
                                    <div class="col-xs-2" style="padding-right: 5px;padding-left: 0px;">
                                        <button style="width:20px;height:20px;font-size: 20px;line-height: 20px;color: #424242;background-color: #CCCCCC;" class="xCNBTNPrimeryPlus" type="button" onclick="JSxSetToRateRentalModalSelect(this,{
                                            'FTBchCode':'<?php echo $aData[$nI]["FTBchCode"]; ?>',
                                            'FTBchCodeForADJPL':'<?php echo $aData[$nI]["FTBchCodeForADJPL"]; ?>',
                                            'FTMerCodeForADJPL':'<?php echo $aData[$nI]["FTMerCodeForADJPL"]; ?>',
                                            'FTShpCodeForADJPL':'<?php echo $aData[$nI]["FTShpCodeForADJPL"]; ?>',
                                            'FTXthDocNo':'<?php echo $aData[$nI]["FTXthDocNo"]; ?>',
                                            'FTXthDocKey':'<?php echo $aData[$nI]["FTXthDocKey"]; ?>',
                                            'FTSessionID':'<?php echo $aData[$nI]["FTSessionID"]; ?>',
                                            'FTPzeCodeForADJPL':'<?php echo $aData[$nI]["FTPzeCodeForADJPL"]; ?>',
                                            'FTRthCodeForADJPL':'<?php echo $aData[$nI]["FTRthCodeForADJPL"]; ?>'
                                        });">+</button>
                                    </div>
                                    <div class="col-xs-10" style="padding-right: 5px;padding-left: 0px;">
                                        <span>เพิ่ม</span>
                                    </div>
                                </div>
                                <?php
                            } 

                            ?></label></td>
                            <td></td>
                        </tr>
                    <?php
                        }
                    }else{
                    ?>
                    <tr>
                        <td colspan="100%" class="text-center"><span><?php echo language('common/main/main','tCMNNotFoundData')?></span></td>
                    </tr>
                    <?php
                    }
                }else{
                    
                ?>
                    <tr>
                        <td colspan="100%" class="text-center"><span><?php echo language('common/main/main','tCMNNotFoundData')?></span></td>
                    </tr>
                <?php
                }
            }else{
            ?>
                <tr>
                    <td colspan="100%" class="text-center"><span><?php echo language('common/main/main','tCMNNotFoundData')?></span></td>
                </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>
</div>
<!-- <div class="row" id="odvPaginationBtn">
    <div class="col-md-6">
        <p><//?= //language('common/main/main','tResultTotalRecord')?> <//?=//$nAllPage?> <//?= //language('common/main/main','tRecord')?> <//?= //language('common/main/main','tCurrentPage')?> <//?=//$nPage?> / <//?=//ceil($nAllPage/10)?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageTFWPdt btn-toolbar pull-right">
            <?php //if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '';} ?>
            <button onclick="JSvTFWPdtClickPage('previous')" class="btn btn-white btn-sm" <?php //echo $tDisabledLeft ?>> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php 
                //for($i=max($nPage-2, 1); $i<=max(0, min(ceil($nAllPage/10),$nPage+2)); $i++){?> 
                <?php 
                    // if($nPage == $i){ 
                    //     $tActive = 'active'; 
                    //     $tDisPageNumber = 'disabled';
                    // }else{ 
                    //     $tActive = '';
                    //     $tDisPageNumber = '';
                    // }
                    
                ?>
                
                <button onclick="JSvTFWPdtClickPage('<?php //echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php //echo $tActive ?>" <?php //echo $tDisPageNumber ?>><?php //echo $i?></button>
            <?php //} ?>
            <?php //if($nPage >= ceil($nAllPage/10)){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '';  } ?>
            <button onclick="JSvTFWPdtClickPage('next')" class="btn btn-white btn-sm" <?php //echo $tDisabledRight ?>> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
  </div> -->
  <?php
    if($bCheckNodata){
    ?>
    <script>
        FSvCMNSetMsgWarningDialog("<p>โปรดเพิ่มสินค้าเช่าของร้านค้าก่อนดำเนินการ</p>");
    </script>
    <?php
    }
  ?>