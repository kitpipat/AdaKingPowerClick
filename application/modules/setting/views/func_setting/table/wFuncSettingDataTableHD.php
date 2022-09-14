<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage   = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<style>
    .xWPIHDDocItems:hover {
        cursor: pointer;
    }
    .xWPIHDDocItems.xCNActive {
        background-color: #179bfd !important;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbFuncSettingTblDataHDList" class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold" width="5%"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingSeq'); ?></th>
                        <th class="xCNTextBold"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingSys'); ?></th>
                        <th class="xCNTextBold"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingFuncGroup'); ?></th>
                        <th class="xCNTextBold"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingFunc'); ?></th>
                        <!-- <th class="xCNTextBold"><?php //echo language('setting/funcsetting/funcsetting', 'tFuncSettingLevel'); ?></th> -->
                        <th class="xCNTextBold"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingStatus'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php $tBreakPoint = '' ?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue): ?>
                            <tr class="text-center xCNTextDetail2 xWFuncSettingHDItems">
                                <td class="text-center"><?php echo $aValue['FNRowID']; ?></td>
                                <td class="text-left"><?php echo (!empty($aValue['FTAppName']))? $aValue['FTAppName']   : '' ?></td>
                                <td class="text-left"><?php echo (!empty($aValue['FTKbdScreen']))? $aValue['FTKbdScreen']   : '' ?></td>
                                <td class="text-left"><?php echo (!empty($aValue['FTGdtName']))? $aValue['FTGdtName'] : '' ?></td>
                                <!-- <td class="text-center"><?php //echo (!empty($aValue['FNGdtFuncLevel']))? $aValue['FNGdtFuncLevel'] : '' ?></td> -->
                                <td class="text-center">
                                    <?php echo ($aValue['FTGdtStaUse'] == '1') ? language('common/main/main', 'tCommonActive') : ''; ?>
                                    <?php echo (empty($aValue['FTGdtStaUse'])) ? language('common/main/main', 'tCommonNotActive') : ''; ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if($aDataList['rnAllPage'] > 1) : ?>
    <div class="row" id="odvFuncSettingHDClickPage">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main', 'tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvFuncSettingHDClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                    <button onclick="JSvFuncSettingHDClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>

                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvFuncSettingHDClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include_once('script/jFuncSettingDataTableHD.php'); ?>
