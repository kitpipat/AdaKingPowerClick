<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbPromotionStep4PriceGroupConditionTable">
        <thead>
            <tr>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBNo'); ?></th>
                <th width="30%" class="text-left"><?php echo language('document/promotion/promotion', 'tGroup'); ?></th>
                <th width="60%" class="text-left"><?php echo language('document/promotion/promotion', 'tPriceGroupName'); ?></th>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <tr 
                    class="xCNTextDetail2 xCNPromotionPdtPmtHDCstPriRow" 
                    data-bch-code="<?php echo $aValue['FTBchCode']; ?>" 
                    data-doc-no="<?php echo $aValue['FTPmhDocNo']; ?>" 
                    data-ppl-code="<?php echo $aValue['FTPplCode']; ?>">
                    
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td class="text-left">
                            <select class="xCNApvOrCanCelDisabledPdtPmtHDCstPri form-control xCNPromotionStep3PgtStaGetType" onchange="JSxPromotionStep4PriceGroupConditionDataTableEditInline(this)">
                                <option value='1' <?php echo ($aValue['FTPmhStaType'] == '1') ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tJoining'); ?></option>
                                <option value='2' <?php echo ($aValue['FTPmhStaType'] == '2') ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tExclude'); ?></option>
                            </select>
                        </td>
                        <td class="text-left"><?php echo $aValue['FTPplName']; ?></td>
                        <td class="text-center">
                            <img class="xCNIconTable xCNIconDel" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                        </td>
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
    <div class="row xCNPromotionPdtPmtHDCstPriPage">
        <div class="col-md-6">
            <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvPromotionStep4PriceGroupConditionDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                    <button onclick="JSvPromotionStep4PriceGroupConditionDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>
                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvPromotionStep4PriceGroupConditionDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('script/jStep4PriceGroupConditionTableTmp.php'); ?>