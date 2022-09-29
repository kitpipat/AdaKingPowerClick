<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center" style="width:5%;"><?php echo language('common/main/main', 'tCMNSequence') ?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?php echo language('product/settingprinter/settingprinter', 'tLPTBCode') ?></th>
                        <th class="xCNTextBold text-center" style="width:30%;"><?php echo language('product/settingprinter/settingprinter', 'tLPTBName') ?></th>
                        <th class="xCNTextBold text-center" style="width:15%;"><?php echo language('product/settingprinter/settingprinter', 'tLBFCode') ?></th>
                        <th class="xCNTextBold text-center" style="width:30%;"><?php echo language('product/settingprinter/settingprinter', 'tLBFName') ?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?php echo language('product/settingprinter/settingprinter', 'tSPTBDelete') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($aDataList['tCode'] == 1) : ?>
                        <?php foreach ($aDataList['aItems'] as $nKey => $aValue) { ?>
                            <tr class="text-center xCNTextDetail2 otrSrvPri" id="otrSrvPriSpc<?=$nKey?>" data-srvcode="<?=$aValue['FTSrvCode']?>" data-agncode="<?=$aValue['FTAgnCode']?>" data-plbcode="<?=$aValue['FTPlbCode']?>" data-plbname="<?=$aValue['FTPblName']?>">
                                <td class="text-center"><?=($nKey+1)?></td>
                                <td class="text-left"><?=$aValue['FTPlbCode']?></td>
                                <td class="text-left"><?=$aValue['FTPblName']?></td>
                                <td class="text-left"><?=$aValue['FTLblCode']?></td>
                                <td class="text-left"><?=$aValue['FTLblName']?></td>
                                <td>
                                    <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" onClick="JSxSrvPriSpcDelete(<?=$nKey?>)" title="<?php echo language('customer/customerGroup/customerGroup', 'tCstGrpTBDelete'); ?>">
                                </td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('product/settingprinter/settingprinter', 'tLPRTNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="odvSrvPriSpcModalDel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tModalDelete')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button id="obtSrvPriSpcConfirm" type="button" class="btn xCNBTNPrimery">
					<?=language('common/main/main', 'tModalConfirm')?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<script>
    $('#ohdSrvPriCountSpc').val(<?=$nCountSpc?>);
</script>