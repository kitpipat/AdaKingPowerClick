<style type="text/css">
    #otbPromotionStep3PmtCBTable .xCNPromotionPbyMinValue, 
    #otbPromotionStep3PmtCBTable .xCNPromotionPbyMaxValue, 
    #otbPromotionStep3PmtCBTable .xCNPromotionPbyMinSetPri{
        min-width : 100px;
    }
</style>
<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbPromotionStep3PmtCBTable">
        <thead>
            <tr>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBNo'); ?></th>
                <th nowrap width="17%" class="text-left"><?php echo language('document/promotion/promotion', 'tListGroupName'); ?></th>
                <th nowrap width="10%" class="text-center"><?php echo language('document/promotion/promotion', 'tConditions'); ?></th>
                <th width="17%" class="text-right"><?php echo language('document/promotion/promotion', 'tBuyConditionCol'.$tPbyStaBuyCond); ?></th>
                <th width="17%" class="text-right"><?php echo language('document/promotion/promotion', 'tNotOver'); ?></th>
                <th width="17%" class="text-right"><?php echo language('document/promotion/promotion', 'tMinimumPrice_Unit'); ?></th>
                <?php if($bIsAlwPmtDisAvg) { ?>
                <th width="17%" class="text-right"><?php echo language('document/promotion/promotion', 'tAveragePercentDiscount'); ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <tr class="xCNTextDetail2 xCNPromotionPmtCBRow" data-seq-no="<?php echo $aValue['FNPbySeq']; ?>">
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTPmdGrpName']; ?></td>
                        <td nowrap class="text-center"><?php echo language('document/promotion/promotion', 'tBuyCondition' . $aValue['FTPbyStaBuyCond']); ?></td>
                        <td>
                            <input 
                            type="text" 
                            class="form-control text-right xCNInputNumericWithDecimal xCNApvOrCanCelDisabledPmtCB xCNPromotionPbyMinValue xCNInputLength"
                            maxlength="14" 
                            data-length="14"
                            data-field-name="FCPbyMinValue"
                            data-format-type="C"
                            value="<?php echo number_format($aValue['FCPbyMinValue'], $nOptDecimalShow); ?>">
                        </td>
                        <td>
                            <input 
                            type="text" 
                            class="form-control text-right xCNInputNumericWithDecimal xCNApvOrCanCelDisabledPmtCB xCNPromotionPbyMaxValue xCNInputLength"  
                            maxlength="14" 
                            data-length="14"
                            data-field-name="FCPbyMaxValue"
                            data-format-type="C"
                            value="<?php echo number_format($aValue['FCPbyMaxValue'], $nOptDecimalShow); ?>">
                        </td>
                        <td>
                            <input 
                            type="text" 
                            class="form-control text-right xCNInputNumericWithDecimal xCNApvOrCanCelDisabledPmtCB xCNPromotionPbyMinSetPri xCNInputLength"  
                            maxlength="14"
                            data-length="14" 
                            data-field-name="FCPbyMinSetPri"
                            data-format-type="C"
                            value="<?php echo number_format($aValue['FCPbyMinSetPri'], $nOptDecimalShow); ?>">
                        </td>
                        <?php if($bIsAlwPmtDisAvg) { ?>
                        <td>
                            <input 
                            type="text" 
                            class="form-control text-right xCNPromotionPgtPerAvgDisCB xCNInputNumeric xCNApvOrCanCelDisabledPmtCB xCNInputMaxValue xCNInputLength"  
                            maxlength="5"
                            data-max="100"
                            data-length="5" 
                            data-field-name="FCPbyPerAvgDis"
                            data-format-type="C"
                            value="<?php echo number_format($aValue['FCPbyPerAvgDis'], $nOptDecimalShow); ?>">
                        </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<?php if($aDataList['rnAllPage'] > 1) { ?>
    <div class="row xCNPromotionPmtCBPage">
        <div class="col-md-6">
            <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvPromotionStep3PmtCBDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                    <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
                </button>
                <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
                    <?php 
                        if($nPage == $i){ 
                            $tActive = 'active'; 
                            $tDisPageNumber = 'disabled';
                        }else{ 
                            $tActive = '';
                            $tDisPageNumber = '';
                        }
                    ?>
                    <button onclick="JSvPromotionStep3PmtCBDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>
                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvPromotionStep3PmtCBDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('script/jStep3PmtCBTableTmp.php'); ?>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
