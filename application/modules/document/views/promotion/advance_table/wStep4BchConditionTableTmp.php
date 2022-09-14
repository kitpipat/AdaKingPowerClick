<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbPromotionStep4BchConditionTable">
        <thead>
            <tr>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBNo'); ?></th>
                <th width="15%" class="text-left"><?php echo language('document/promotion/promotion', 'tGroup'); ?></th>
                <th width="20%" class="text-left <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>"><?php echo language('document/promotion/promotion', 'tLabel20'); ?></th>
                <th width="20%" class="text-left"><?php echo language('document/promotion/promotion', 'tBranch'); ?></th>
                <?php if($bIsShpEnabled) { ?>
                <th width="20%" class="text-left"><?php echo language('document/promotion/promotion', 'tBusinessGroup'); ?></th>
                <th width="20%" class="text-left"><?php echo language('document/promotion/promotion', 'tShop'); ?></th>
                <?php } ?>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <tr 
                    class="xCNTextDetail2 xCNPromotionPdtPmtHDBchRow" 
                    data-bch-code="<?php echo $aValue['FTBchCode']; ?>" 
                    data-doc-no="<?php echo $aValue['FTPmhDocNo']; ?>" 
                    data-agn-to="<?php echo $aValue['FTPmhAgnTo']; ?>"
                    data-bch-to="<?php echo $aValue['FTPmhBchTo']; ?>"
                    data-mer-to="<?php echo $aValue['FTPmhMerTo']; ?>"
                    data-shp-to="<?php echo $aValue['FTPmhShpTo']; ?>">

                        <?php
                        $tDisabled = "";
                        $tClassDisabled = "";
                        if($tUserLevel == "BCH" && !empty($aValue['FTPmhBchTo']) && empty($aValue['FTPmhMerTo']) && empty($aValue['FTPmhShpTo'])) {
                            $tDisabled = "disabled";
                            $tClassDisabled = "xCNDocDisabled";
                        }
                        ?>
                    
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td class="text-left">
                            <select <?php echo $tDisabled; ?> class="selectpicker_ form-control xCNApvOrCanCelDisabledPdtPmtHDBch xCNPromotionStep3PgtStaGetType" onchange="JSxPromotionStep4BchConditionDataTableEditInline(this)">
                                <option value='1' <?php echo ($aValue['FTPmhStaType'] == '1') ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tJoining'); ?></option>
                                <option value='2' <?php echo ($aValue['FTPmhStaType'] == '2') ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tExclude'); ?></option>
                            </select>
                        </td>
                        <td class="text-left <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>"><?php echo $aValue['FTPmhAgnToName']; ?></td>
                        <td class="text-left"><?php echo $aValue['FTPmhBchToName']; ?></td>
                        <?php if($bIsShpEnabled) { ?>
                        <td class="text-left"><?php echo $aValue['FTPmhMerToName']; ?></td>
                        <td class="text-left"><?php echo $aValue['FTPmhShpToName']; ?></td>
                        <?php } ?>
                        <td class="text-center">
                            <img class="xCNIconTable xCNIconDel <?php echo $tClassDisabled; ?>" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
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
    <div class="row xCNPromotionPdtPmtHDBchPage">
        <div class="col-md-6">
            <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvPromotionStep4BchConditionDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                    <button onclick="JSvPromotionStep4BchConditionDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>
                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvPromotionStep4BchConditionDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('script/jStep4BchConditionTableTmp.php'); ?>