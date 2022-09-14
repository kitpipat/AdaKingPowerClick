<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage   = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage   = '1';
    }
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <input type="hidden" id="nCurrentPageTB" value="$nCurrentPage">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('pos/posedc/posedc','tPosEdcTBChoose')?></th>
                    <?php endif; ?>
                        <th nowrap class="xCNTextBold text-center"><?php echo language('pos/posedc/posedc','tPosEdcTBCode')?></th>
                        <th nowrap class="xCNTextBold text-center"><?php echo language('pos/posedc/posedc','tPosEdcTBName')?></th>
                        <th nowrap class="xCNTextBold text-center"><?php echo language('pos/posedc/posedc','tPosEdcTBSysModel')?></th>
                        <th nowrap class="xCNTextBold text-center"><?php echo language('pos/posedc/posedc','tPosEdcTBBank')?></th>
                    <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('pos/posedc/posedc','tPosEdcTBDelete')?></th>
                    <?php endif; ?>
                    <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaEdit'] == 1 || $aAlwEvent['tAutStaRead'] == 1))  : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('pos/posedc/posedc','tPosEdcTBEdit');?></th>
                    <?php endif; ?> 
                </thead>
                <tbody id="odvRGPList">
                    <?php if(isset($aDataList) && $aDataList['rtCode'] == 1):?>
                        <?php foreach($aDataList['raItems'] AS $key => $aValue):?>
                            <tr class="xCNTextDetail2 xCNPoeEdc" id="otrPosEdc<?php echo $key?>" data-code="<?php echo $aValue['FTEdcCode']?>" data-name="<?php echo $aValue['FTEdcName']?>">
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td nowrap class="text-center">
                                        <label class="fancy-checkbox">
                                            <input id="ocbListItem<?php echo $key;?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                            <span>&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td nowrap class="text-left"><?php echo $aValue['FTEdcCode'];?></td>
                                <td nowrap class="text-left"><?php echo $aValue['FTEdcName'];?></td>
                                <td nowrap class="text-left"><?php echo $aValue['FTSedModel'];?></td>
                                <td nowrap class="text-left"><?php echo $aValue['FTBnkName'];?></td>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                                    <td nowrap class="text-center">
                                        <img
                                            class="xCNIconTable xCNIconDel"
                                            src="<?php echo base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                            data-code="<?php echo $aValue['FTEdcCode'];?>"
                                            data-name="<?php echo $aValue['FTEdcName'];?>"
                                            data-currentpage="<?php echo $nCurrentPage;?>"
                                        >
                                    </td>
                                <?php endif; ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                                    <td nowrap class="text-center">
                                        <img
                                            class="xCNIconTable xCNIconEdit"
                                            src="<?php echo base_url().'/application/modules/common/assets/images/icons/edit.png';?>"
                                            data-code="<?php echo $aValue['FTEdcCode'];?>"
                                        >
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100'><?php echo language('common/main/main', 'tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPagePosEdc btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';}?>
            <button onclick="JSvPosEdcClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                if($nPage == $i){ 
                        $tActive = 'disabled'; 
                        $tDisPageNumber = 'active'; 
                }else{
                        $tActive = '-'; 
                        $tDisPageNumber = ''; 
                }
                ?>
                <button onclick="JSvPosEdcClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tDisPageNumber; ?>" <?php echo $tActive ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPosEdcClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<?php include "script/jPosEdcDataTable.php";?>