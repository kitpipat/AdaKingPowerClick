<!-- ใ บ สั้ ง ซื้ อ -->

<input id="oetPOStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetPOCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvPOMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="xCNavRow" style="width:inherit;">

			<div class="xCNPOMaster row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">		
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('docPO/0/0');?>
						<li id="oliPOTitle"     class="xCNLinkClick" onclick="JSvPOCallPageMain('')"><?= language('document/purchaseorderNew/purchaseorderNew','tPOTitle')?></li>
                        <li id="oliPOTitleAdd"  class="active"><a href="javascrip:;"><?= language('document/purchaseorderNew/purchaseorderNew','tPOAdd')?></a></li>
						<li id="oliPOTitleEdit" class="active"><a href="javascrip:;"><?= language('document/purchaseorderNew/purchaseorderNew','tPOEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] == "1") : ?>
						<div id="odvBtnPOPageAddorEdit">
							<button class="xCNBTNPrimeryPlus" type="button" onclick="JSvPOPageAdd('pageadd')">+</button>
						</div>
						<?php endif; ?>
						
						<div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" onclick="JSvPOCallPageMain('')"><?=language('common/main/main', 'tBack'); ?></button>
                                <?php if ($aPermission['tAutStaFull'] == 1 || ($aPermission['tAutStaAdd'] == 1 || $aPermission['tAutStaEdit'] == 1)): ?>
                                    <button id="obtPOPrintDoc" 	    class="btn xCNBTNDefult xCNBTNDefult2Btn" 	type="button" onclick="" > <?=language('common/main/main', 'tCMNPrint'); ?></button>
                                    <button id="obtPOCancelDoc" 	class="btn xCNBTNDefult xCNBTNDefult2Btn" 	type="button" onclick="JSxPODocumentCancel(false)"> <?=language('common/main/main', 'tCancel'); ?></button>
                                    <button id="obtPOApproveDoc" 	class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" onclick="JSxPODocumentApv(false)"> <?=language('common/main/main', 'tCMNApprove'); ?></button>                                  
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
<div class="xCNMenuCump" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content" id="odvMainContent" style="background-color: #F0F4F7;">    
	<div id="odvContentPO"></div>
</div>

<?php include('script/jPO.php') ?>
<script src="<?= base_url('application/modules/common/assets/vendor/rabbitmq/stomp.min.js'); ?>"></script>
<script src="<?= base_url('application/modules/common/assets/vendor/rabbitmq/sockjs.min.js'); ?>"></script>
