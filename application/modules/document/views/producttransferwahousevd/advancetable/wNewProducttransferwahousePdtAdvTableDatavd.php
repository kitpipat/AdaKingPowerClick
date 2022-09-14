<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbDOCCashTable">
        <thead>
            <tr class="xCNCenter">
                <th><?php echo language('document/producttransferwahousevd/producttransferwahousevd', 'tTFWTBNo'); ?></th>
                <th><?php echo language('document/producttransferwahousevd/producttransferwahousevd', 'tTFXVDPdtCodeName'); ?></th>
                <th><?php echo language('document/producttransferwahousevd/producttransferwahousevd', 'tTFXVDPdtName'); ?></th>
                <th><?php echo language('document/producttransferwahousevd/producttransferwahousevd', 'tTFXVDPdtRow'); ?></th>
                <th><?php echo language('document/producttransferwahousevd/producttransferwahousevd', 'tTFXVDPdtCol'); ?></th>
                <th><?php echo language('document/producttransferwahousevd/producttransferwahousevd', 'tTFXVDPdtMaxTransfer'); ?></th>
                <th><?php echo language('document/producttransferwahousevd/producttransferwahousevd', 'tTFXVDPdtBalance'); ?></th>
                <th>
                <?php 
                if($tPanelPdtType==1){
                ?>
                <?php echo language('document/producttransferwahousevd/producttransferwahousevd', 'tTFXVDPdtNumTransfer'); ?>
                <?php
                }else if($tPanelPdtType==2 || $tPanelPdtType==3){
                ?>
                <?php echo language('document/producttransferwahousevd/producttransferwahousevd', 'tTFXVDPdtNumInCrease'); ?>
                
                <?php
                }else{
                ?>
                <?php echo language('document/producttransferwahousevd/producttransferwahousevd', 'tTFXVDPdtNumInCrease'); ?>
                
                <?php    
                }
                ?>
                
                </th>
                <th class="xWDeleteBtnEditButton"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if($tPanelPdtStaShow==1){
                if($aData){
                    $nCheckFCStkQty = 0;
                    for($nI=0;$nI<FCNnHSizeOf($aData);$nI++){
                        if($aData[$nI]["FCStkQty"]!=""){
                    ?>
                    <tr class="xWPdtItem">
                        <td>
                            <label><?php echo $aData[$nI]["FNRowID"]; ?></label>
                        </td>
                        <td><label><?php echo $aData[$nI]["FTPdtCode"]; ?></label></td>
                        <td><label><?php echo $aData[$nI]["FTPdtName"]; ?></label></td>
                        <td><label><?php echo $aData[$nI]["FNLayRowForTWXVD"]; ?></label></td>
                        <td><label><?php echo $aData[$nI]["FNLayColForTWXVD"]; ?></label></td>
                        <td><label><?php echo $aData[$nI]["FCLayColQtyMaxForTWXVD"]; ?></label></td>
                        <td><label><?php echo $aData[$nI]["FCStkQty"]; ?></label></td>
                        <td style="<?php if($aData[$nI]["FCMaxTransferForTWXVD"]==0){
                                            echo "background-color: #eee !important;opacity: 1;";
                                         }
                            ?>">
                            <label class="xCNPdtFont xWShowInLine"
                            <?php 
                            if($aData[$nI]["FCMaxTransferForTWXVD"]==0){
                                echo "readonly";
                            }
                            ?>
                            dataUser="<?php echo $aData[$nI]["FCUserInPutTransferForTWXVD"]; ?>" dataRow="<?php echo $aData[$nI]["FNLayRowForTWXVD"]; ?>" dataCol="<?php echo $aData[$nI]["FNLayColForTWXVD"]; ?>" dataSeq="<?php echo $nI; ?>" dataMax="<?php echo $aData[$nI]["FCMaxTransferForTWXVD"]; ?>" dataMin="0"><?php 
                            if($aData[$nI]["FCUserInPutTransferForTWXVD"]!=""){
                                echo $aData[$nI]["FCUserInPutTransferForTWXVD"];
                            }else{
                                echo $aData[$nI]["FCMaxTransferForTWXVD"];
                            }
                            ?></label>
                            <div class="xCNHide xWEditInLine">
                                <input  type="text" class="form-control xCNPdtEditInLine xCNInputWithoutSpc xWEditPdtInline" value="<?php 
                                if($aData[$nI]["FCUserInPutTransferForTWXVD"]!=""){
                                    echo $aData[$nI]["FCUserInPutTransferForTWXVD"];
                                }else{
                                    echo $aData[$nI]["FCMaxTransferForTWXVD"];
                                }
                                ?>">
                                <input type="hidden" class="xWOldValueInline" value="<?php 
                                if($aData[$nI]["FCUserInPutTransferForTWXVD"]!=""){
                                    echo $aData[$nI]["FCUserInPutTransferForTWXVD"];
                                }else{
                                    echo $aData[$nI]["FCMaxTransferForTWXVD"];
                                }
                                ?>">
                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <?php
                        }else{
                            $nCheckFCStkQty++;
                        }
                    }
                    if($nCheckFCStkQty==FCNnHSizeOf($aData)){
                    ?>
                        <tr>
                            <td colspan="100%" class="text-center"><span>ไม่พบข้อมูล</span></td>
                        </tr>
                    <?php
                    }
                }else{
                ?>
                    <tr>
                        <td colspan="100%" class="text-center"><span>ไม่พบข้อมูล</span></td>
                    </tr>
                <?php
                }
            }else{
                ?>
                <tr>
                    <td colspan="100%" class="text-center"><span>ไม่พบข้อมูล</span></td>
                </tr>
                <?php 
            }
            ?>
        </tbody>
    </table>
</div>
<div class="row" id="odvPaginationBtn">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$nAllPage?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$nPage?> / <?=ceil($nAllPage/10)?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageTFWPdt btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '';} ?>
            <button onclick="JSvTFWPdtClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php 
                for($i=max($nPage-2, 1); $i<=max(0, min(ceil($nAllPage/10),$nPage+2)); $i++){?> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                    
                ?>
                
                <button onclick="JSvTFWPdtClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= ceil($nAllPage/10)){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '';  } ?>
            <button onclick="JSvTFWPdtClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
  </div>