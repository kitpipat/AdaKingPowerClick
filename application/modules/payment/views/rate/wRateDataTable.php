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
					<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                        <th  class="xCNTextBold" style="width:5%;"><?= language('payment/rate/rate','tRTETBChoose')?></th>
						<?php endif; ?>
						<th class="xCNTextBold" style="width:10%;"><?= language('payment/rate/rate','tRTETBPic')?></th>
						<th class="xCNTextBold" style="width:10%;"><?= language('payment/rate/rate','tRTETBRteCode')?></th>
						<th class="xCNTextBold" style="width:25%;"><?= language('payment/rate/rate','tRTETBRteName')?></th>
                        <th class="xCNTextBold" style="width:20%;"><?= language('payment/rate/rate','tRTETBRate')?></th>
						<!-- <th class="xCNTextBold"><?= language('payment/rate/rate','tRTETBManage')?></th> -->
						<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<th class="xCNTextBold" style="width:10%;"><?= language('common/main/main','tCMNActionDelete')?></th>
						<?php endif; ?>
						<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
						<th class="xCNTextBold" style="width:10%;"><?= language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
				<?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key => $aValue){ ?>
                           
                        <tr class="xCNTextDetail2 otrRate" id="otrRate<?=$key?>" data-code="<?=$aValue['FTRteCode']?>" data-name="<?=$aValue['FTRteName']?>">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
								<td class="text-center">
									<label class="fancy-checkbox">
										<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?php if( $aValue['FTStaRef'] == '1' ){ echo 'disabled'; } ?> >
										<span class="<?php if( $aValue['FTStaRef'] == '1' ){ echo 'xCNDocDisabled'; } ?>" >&nbsp;</span>
									</label>
								</td>
							<?php endif; ?>
                            <td class="text-center">
                                <?php echo  FCNtHGetImagePageList($aValue['FTImgObj'], '38px'); ?>
                            </td>
							<td><?php echo $aValue['FTRteCode'];?></td>
                            <td><?php echo $aValue['FTRteName'];?></td>
                            <td class="text-right"><?php echo number_format($aValue['FCRteRate'],$nOptDecimalShow)?></td>
                            <!-- <td>tManage</td> -->
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            	<!-- <td><img class="xCNIconTable" src="<?php echo  base_url().'/application/assets/icons/delete.png'?>" onClick="JSnRateDel('<?=$nCurrentPage?>','<?=$aValue['FTRteName']?>','<?=$aValue['FTRteCode']?>')"></td> -->
                                <td class="text-center"><img class="xCNIconTable xCNIconDel <?php if( $aValue['FTStaRef'] == '1' ){ echo 'xCNDocDisabled'; } ?>" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" <?php if( $aValue['FTStaRef'] == '2' ){ ?> onClick="JSnRateDel('<?=$nCurrentPage?>','<?=$aValue['FTRteName']?>','<?=$aValue['FTRteCode']?>')" <?php } ?> ></td>
							<?php endif; ?>
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                            	<!-- <td><img class="xCNIconTable" src="<?php echo  base_url().'/application/assets/icons/edit.png'?>" onClick="JSvCallPageRateEdit('<?=$aValue['FTRteCode']?>')"></td> -->
                                <td class="text-center"><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageRateEdit('<?=$aValue['FTRteCode']?>')"></td>
							<?php endif; ?>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='8'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPagingRate btn-toolbar pull-right">
			<?php if($nPage == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';} ?>
            <button onclick="JSvRTEClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

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
            		<button onclick="JSvRTEClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive?>" <?=$tDisPageNumber ?>><?=$i?></button>
			<?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvRTEClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelRate">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnRateDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<?php include "script/jRateAdd.php"; ?>