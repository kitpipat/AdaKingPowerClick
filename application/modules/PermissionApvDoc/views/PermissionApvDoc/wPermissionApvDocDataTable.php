<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
					<tr class="xCNCenter">
                        <th style="width:10%;"><?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADTableSeq')?></th>
                        <th style="width:50%;"><?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADTableDocument')?></th>
						<th class="xCNTextBold" style="width:15%;"><?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADTableManage')?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr>
                            <td class="text-center"><?=$aValue['FNRowID']?></td>
                            <td class="text-left"><?=$aValue['rtSdtDocName']?></td>
							<td class="text-center"><img class="xCNIconTable" src="<?= base_url().'/application/modules/common/assets/images/icons/document.png'?>" onClick="JSvCallPagePermissionApproveDocEdit('<?php echo $aValue['rtDapTable']; ?>','<?php echo $aValue['rtDapRefType']; ?>','<?php echo $aValue['rtSdtDocName']; ?>')"></td>
                        </tr>
                    <?php } ?>
                <?php else:?>

                    <tr><td class='text-center xCNTextDetail2' colspan='3'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="xWCDCPaging btn-toolbar pull-right">
			<?php if($nPage == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';} ?>
            <button onclick="JSvPADClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

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
            		<button onclick="JSvPADClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive?>" <?=$tDisPageNumber ?>><?=$i?></button>
			<?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvPADClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>
