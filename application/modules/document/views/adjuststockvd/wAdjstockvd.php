<input id="oetADJVDStaBrowse" type="hidden" 		value="<?=$nBrowseType?>">
<input id="oetADJVDCallBackOption" type="hidden"	value="<?=$tBrowseOption?>">

<div id="odvADJVDMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="xCNADJVDVMaster">
				<div class="col-xs-12 col-md-6">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('ADJSTKVD/0/0');?> 
						<li id="oliADJVDTitle" class="xCNLinkClick" onclick="JSvCallPageADJVDList()"><?= language('document/adjuststockvd/adjuststockvd','tADJVDTitle')?></li>
						<li id="oliADJVDTitleAdd" class="active"><a><?= language('document/adjuststockvd/adjuststockvd','tADJVDTitleAdd')?></a></li>
						<li id="oliADJVDTitleEdit" class="active"><a><?= language('document/adjuststockvd/adjuststockvd','tADJVDTitleEdit')?></a></li>
						<li id="oliPITitleDetail" class="active"><a><?= language('document/purchaseinvoice/purchaseinvoice','tPITitleDetail');?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<div id="odvBtnADJVDInfo">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
								<button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageADJVDAdd()">+</button>
							<?php endif; ?>
						</div>
						<div id="odvBtnAddEdit">
							<div class="demo-button xCNBtngroup" style="width:100%;">
								<button onclick="JSvCallPageADJVDList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tBack')?></button>
								<?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
									<button id="obtADJVDPrint" onclick="JSxADJVDPrint()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tCMNPrint')?></button>
									<button id="obtADJVDCancel" onclick="JSxADJVDCancel(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tCancel')?></button>
									<button id="obtADJVDApprove" onclick="JSxADJVDApprove(false)" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?=language('common/main/main', 'tCMNApprove')?></button>
									<div id="obtADJVDSaveEdit" class="btn-group">
										<button type="button" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitADJVD').click()"> <?=language('common/main/main', 'tSave')?></button>
										<?php echo $vBtnSave?>
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
<div class="xCNMenuCump xCNADJVDBrowseLine" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content">
	<div id="odvContentPageADJVD"></div>
</div>

<script>
	var tBaseURL		= '<?php echo base_url(); ?>';
	var nOptDecimalShow = '<?php echo $nOptDecimalShow; ?>';
	var nOptDecimalSave = '<?php echo $nOptDecimalSave; ?>';
	var nLangEdits		= '<?php echo $this->session->userdata("tLangEdit"); ?>';
	var tUsrApv			= '<?php echo $this->session->userdata("tSesUsername"); ?>';
</script>

<script type="text/javascript" src="<?=base_url() ?>application/modules/document/assets/src/adjuststockvd/jAdjustStockVending.js"></script>
