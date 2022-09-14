<input id="oetTBIStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetTBICallBackOption" type="hidden" value="<?=$tBrowseOption?>">
<input id="ohdTBIDocType" type="hidden" value="<?=$nDocType?>">
<input id="oetTBIJumpDocNo" type="hidden" value="<?php echo $aParams['tDocNo'] ?>">
<input id="oetTBIJumpBchCode" type="hidden" value="<?php echo $aParams['tBchCode'] ?>">
<input id="oetTBIJumpAgnCode" type="hidden" value="<?php echo $aParams['tAgnCode'] ?>">
<div id="odvTBIMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="xCNavRow" style="width:inherit;">
			<div class="xCNTBIMaster row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('TBI/0/0/'.$nDocType);?>
						<li id="oliTBITitle"     class="xCNLinkClick"><?= language('document/transferreceiptbranch/transferreceiptbranch','tTBITitle'.$nDocType)?></li>
                        <li id="oliTBITitleAdd"  class="active"><a href="javascrip:;"><?= language('document/transferreceiptbranch/transferreceiptbranch','tTBIAdd')?></a></li>
						<li id="oliTBITitleEdit" class="active"><a href="javascrip:;"><?= language('document/transferreceiptbranch/transferreceiptbranch','tTBIEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] == "1") : ?>
						<div id="odvBtnTBIInfo">
							<button id="obtTBIAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvTBITransferReceiptAdd()">+</button>
						</div>
						<?php endif; ?>
						<div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtTBICallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?=language('common/main/main', 'tBack'); ?></button>
                                <?php if ($aPermission['tAutStaFull'] == 1 || ($aPermission['tAutStaAdd'] == 1 || $aPermission['tAutStaEdit'] == 1)): ?>
                                    <button id="obtTBIPrintDoc" 	class="btn xCNBTNDefult xCNBTNDefult2Btn" 	type="button" onclick="JSxTBITransferReceiptPrintDoc()" > <?=language('common/main/main', 'tCMNPrint'); ?></button>
                                    <button id="obtTBICancelDoc" 	class="btn xCNBTNDefult xCNBTNDefult2Btn" 	type="button" onclick="JSxTBITransferReceiptDocCancel(false)"> <?=language('common/main/main', 'tCancel'); ?></button>
                                    <button id="obtTBIApproveDoc" 	class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" onclick="JSxTBITransferReceiptStaApvDoc(false)"> <?=language('common/main/main', 'tCMNApprove'); ?></button>
                                    <div id="odvTBIBtnGrpSave" 		class="btn-group">
                                        <button id="obtTBISubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"><?=language('common/main/main', 'tSave'); ?></button>
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
<div class="xCNMenuCump xCNTransferReceiptLine" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content" id="odvMainContent" style="background-color: #F0F4F7;">
	<div id="odvContentTransferReceipt"></div>
</div>

<?php include('script/jTransferReceiptbranch.php') ?>
<script src="<?= base_url('application/modules/common/assets/vendor/rabbitmq/stomp.min.js'); ?>"></script>
<script src="<?= base_url('application/modules/common/assets/vendor/rabbitmq/sockjs.min.js'); ?>"></script>
