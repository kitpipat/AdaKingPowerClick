<!-- ใ บ จ่ า ย โ อ น - คลังสินค้า -->

<input id="oetTWOStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetTWOCallBackOption" type="hidden" value="<?=$tBrowseOption?>">
<input id="oetTWODocType" type="hidden" value="<?=$nDocType?>">
<div id="odvTWOMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="xCNavRow" style="width:inherit;">

			<div class="xCNTWOMaster row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">		
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('TWO/0/0/'.$nDocType);?>
						<li id="oliTransferwarehouseoutTitle"     class="xCNLinkClick" onclick="JSvTWOCallPageTransferwarehouseout('')"><?= language('document/transferwarehouseout/transferwarehouseout','tTWOTitle_'.$nDocType)?></li>
                        <li id="oliTransferwarehouseoutTitleAdd"  class="active"><a href="javascrip:;"><?= language('document/transferwarehouseout/transferwarehouseout','tTWOAdd')?></a></li>
						<li id="oliTransferwarehouseoutTitleEdit" class="active"><a href="javascrip:;"><?= language('document/transferwarehouseout/transferwarehouseout','tTWOEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] == "1") : ?>
						<div id="odvBtnTransferwarehouseoutInfo">
							<button id="obtTransferwarehouseoutAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvTWOTransferwarehouseoutAdd()">+</button>
						</div>
						<?php endif; ?>
						
						<div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" onclick="JSvTWOCallPageTransferwarehouseout()"><?=language('common/main/main', 'tBack'); ?></button>
                                <?php if ($aPermission['tAutStaFull'] == 1 || ($aPermission['tAutStaAdd'] == 1 || $aPermission['tAutStaEdit'] == 1)): ?>
                                    <button id="obtTWOPrintDoc" 	class="btn xCNBTNDefult xCNBTNDefult2Btn" 	type="button" onclick="JSxTWOTransferwarehouseoutPrint()" > <?=language('common/main/main', 'tCMNPrint'); ?></button>
                                    <button id="obtTWOCancelDoc" 	class="btn xCNBTNDefult xCNBTNDefult2Btn" 	type="button" onclick="JSxTWOTransferwarehouseoutDocCancel(false)"> <?=language('common/main/main', 'tCancel'); ?></button>
                                    <button id="obtTWOApproveDoc" 	class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" onclick="JSxTWOChkStkB4ApvDoc(false)"> <?=language('common/main/main', 'tCMNApprove'); ?></button>                                  
                                    <div id="odvTWOBtnGrpSave" 		class="btn-group">
                                        <button id="obtTWOSubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"><?=language('common/main/main', 'tSave'); ?></button>
                                        <?php echo $vBtnSave ?>
                                    </div>
                                <?php endif; ?>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="xCNMenuCump xCNTransferwarehouseoutLine" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content" id="odvMainContent" style="background-color: #F0F4F7;">    
	<div id="odvContentTransferwarehouseout"></div>
</div>

<?php include('script/jTransferwarehouseout.php') ?>
<script src="<?= base_url('application/modules/common/assets/vendor/rabbitmq/stomp.min.js'); ?>"></script>
<script src="<?= base_url('application/modules/common/assets/vendor/rabbitmq/sockjs.min.js'); ?>"></script>
