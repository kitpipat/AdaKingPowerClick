<!-- ใ บ รั บ เ ข้ า - คลังสินค้า -->

<input id="oetTRNStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetTRNCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvTRNMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="xCNavRow" style="width:inherit;">

			<div class="xCNTRNMaster row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">		
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('TXOOut/0/0');?>
						<li id="oliTransferReceiptTitle"     class="xCNLinkClick" onclick="JSvTRNCallPageTransferReceipt('')"><?= language('document/transferreceiptOut/transferreceiptOut','tTWITitle')?></li>
                        <li id="oliTransferReceiptTitleAdd"  class="active"><a href="javascrip:;"><?= language('document/transferreceiptOut/transferreceiptOut','tTWIAdd')?></a></li>
						<li id="oliTransferReceiptTitleEdit" class="active"><a href="javascrip:;"><?= language('document/transferreceiptOut/transferreceiptOut','tTWIEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] == "1") : ?>
						<div id="odvBtnTransferReceiptInfo">
							<button id="obtTransferReceiptAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvTRNTransferReceiptAdd()">+</button>
						</div>
						<?php endif; ?>
						
						<div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" onclick="JSvTRNCallPageTransferReceipt()"><?=language('common/main/main', 'tBack'); ?></button>
                                <?php if ($aPermission['tAutStaFull'] == 1 || ($aPermission['tAutStaAdd'] == 1 || $aPermission['tAutStaEdit'] == 1)): ?>
                                    <button id="obtTrnOutPrintDoc" 	class="btn xCNBTNDefult xCNBTNDefult2Btn" 	type="button" onclick="JSxTRNOutPrint()" > <?=language('common/main/main', 'tCMNPrint'); ?></button>
                                    <button id="obtTWICancelDoc" 	class="btn xCNBTNDefult xCNBTNDefult2Btn" 	type="button" onclick="JSxTRNTransferReceiptDocCancel(false)"> <?=language('common/main/main', 'tCancel'); ?></button>
                                    <button id="obtTWIApproveDoc" 	class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" onclick="JSxTRNTransferReceiptStaApvDoc(false)"> <?=language('common/main/main', 'tCMNApprove'); ?></button>                                  
                                    <div id="odvTWIBtnGrpSave" 		class="btn-group">
                                        <button id="obtTWISubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"><?=language('common/main/main', 'tSave'); ?></button>
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

<?php include('script/jTransferReceipt.php') ?>
<script src="<?= base_url('application/modules/common/assets/vendor/rabbitmq/stomp.min.js'); ?>"></script>
<script src="<?= base_url('application/modules/common/assets/vendor/rabbitmq/sockjs.min.js'); ?>"></script>
