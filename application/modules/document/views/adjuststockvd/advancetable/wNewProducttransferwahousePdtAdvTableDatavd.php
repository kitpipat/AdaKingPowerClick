<?php //print_r($aData); ?>

<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbDOCPdtTable">
        <thead>
            <tr class="xCNCenter">
                <th><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWTBNo'); ?></th>
                <th><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFXVDPdtCodeName'); ?></th>
                <th><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFXVDPdtName'); ?></th>
                <th><?php echo language('vending/cabinet/cabinet', 'tTiTleCabinetHead'); ?></th>
                <th><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFXVDPdtRow'); ?></th>
                <th><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFXVDPdtCol'); ?></th>
                <th><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFXVDPdtMaxTransfer'); ?></th>
                <th style="display:none;"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFXVDPdtBalance'); ?></th>
                <th><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFXVDPdtDateInput'); ?></th>
                <th><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFXVDPdtTimeInput'); ?></th>
                <th>
                <?php 
                 echo language('document/adjuststockvd/producttransferwahousevd', 'tTFXVDPdtCounted'); 
                ?>
                
                </th>
                <th class="xWDeleteBtnEditButton"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            // echo $tPanelPdtStaShow;
            if($tPanelPdtStaShow == 1){
                if($aData){
                    $nCheckFCStkQty = 0;
                    for($nI=0;$nI<FCNnHSizeOf($aData);$nI++){
                        // print_r($aData[$nI]);
                        if($aData[$nI]["FCStkQty"] != ""){
                    ?>

                    <tr class="xWPdtItem">
                        <td>
                            <label><?php echo $aData[$nI]["FNRowID"]; ?></label>
                        </td>
                        <td><label><?php echo $aData[$nI]["FTPdtCode"]; ?></label></td>
                        <td><label><?php echo $aData[$nI]["FTPdtName"]; ?></label></td>
                        <td><label><?php echo $aData[$nI]["FTCabName"]; ?></label></td>
                        <td><label><?php echo $aData[$nI]["FNLayRowForADJSTKVD"]; ?></label></td>
                        <td><label><?php echo $aData[$nI]["FNLayColForADJSTKVD"]; ?></label></td>
                        <td><label><?php echo $aData[$nI]["FCLayColQtyMaxForADJSTKVD"]; ?></label></td>
                        <td style="display:none;"><label><?php echo $aData[$nI]["FCStkQty"]; ?></label></td>
                        <td><label><?php if($aData[$nI]["FCDateTimeInputForADJSTKVD"]!=""){ 
                            echo date("Y-m-d",strtotime($aData[$nI]["FCDateTimeInputForADJSTKVD"])); 
                        } ?></label></td>
                        <td><label><?php if($aData[$nI]["FCDateTimeInputForADJSTKVD"]!=""){ 
                            echo date("H:i:s",strtotime($aData[$nI]["FCDateTimeInputForADJSTKVD"])); 
                        } ?></label></td>
                        <td style="<?php if($aData[$nI]["FCLayColQtyMaxForADJSTKVD"]==0){
                                            echo "background-color: #eee !important;opacity: 1;";
                                         }
                            ?>">
                            <label class="xCNPdtFont xWShowInLine"
                            <?php 
                            if($aData[$nI]["FCLayColQtyMaxForADJSTKVD"]==0){
                                echo "readonly";
                            }
                            ?>
                            dataUser="<?php echo $aData[$nI]["FCUserInPutForADJSTKVD"]; ?>" 
                            dataRow="<?php echo $aData[$nI]["FNLayRowForADJSTKVD"]; ?>" 
                            dataCol="<?php echo $aData[$nI]["FNLayColForADJSTKVD"]; ?>" 
                            dataSeq="<?php echo $nI; ?>" 
                            dataMax="<?php echo $aData[$nI]["FCLayColQtyMaxForADJSTKVD"]; ?>" 
                            dataMin="0"
                            dataseqcabinet="<?=$aData[$nI]["FNCabSeqForTWXVD"]; ?>" ><?php 
                            if($aData[$nI]["FCUserInPutForADJSTKVD"]!=""){
                                echo $aData[$nI]["FCUserInPutForADJSTKVD"];
                            }else{
                                echo $aData[$nI]["FCLayColQtyMaxForADJSTKVD"];
                            }
                            ?></label>
                            <div class="xCNHide xWEditInLine">
                                <input  type="text" class="form-control xCNPdtEditInLine xCNInputWithoutSpc xWEditPdtInline" value="<?php 
                                if($aData[$nI]["FCUserInPutForADJSTKVD"]!=""){
                                    echo $aData[$nI]["FCUserInPutForADJSTKVD"];
                                }else{
                                    echo $aData[$nI]["FCLayColQtyMaxForADJSTKVD"];
                                }
                                ?>">
                                <input type="hidden" class="xWOldValueInline" value="<?php 
                                if($aData[$nI]["FCUserInPutForADJSTKVD"]!=""){
                                    echo $aData[$nI]["FCUserInPutForADJSTKVD"];
                                }else{
                                    echo $aData[$nI]["FCLayColQtyMaxForADJSTKVD"];
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
                    if($nCheckFCStkQty == FCNnHSizeOf($aData)){
                    ?>
                        <tr>
                            <td colspan="100%" class="text-center"><span><?=language('common/main/main','tCMNNotFoundData')?></span></td>
                        </tr>
                    <?php
                    }
                }else{
                ?>
                    <tr>
                        <td colspan="100%" class="text-center"><span><?=language('common/main/main','tCMNNotFoundData')?></span></td>
                    </tr>
                <?php
                }
            }else{
                ?>
                <tr>
                    <td colspan="100%" class="text-center"><span><?=language('common/main/main','tCMNNotFoundData')?></span></td>
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