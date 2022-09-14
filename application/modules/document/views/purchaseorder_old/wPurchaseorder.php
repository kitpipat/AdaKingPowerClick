<input id="oetPOStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetPOCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvPOMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="xCNPOVMaster">
				<div class="col-xs-12 col-md-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<li id="oliPOTitle" onclick="JSvCallPagePOList()"><?= language('document/purchaseorder/purchaseorder','tPOTitle')?></li>
						<li id="oliPOTitleAdd" class="active"><a><?= language('document/purchaseorder/purchaseorder','tPOTitleAdd')?></a></li>
						<li id="oliPOTitleEdit" class="active"><a><?= language('document/purchaseorder/purchaseorder','tPOTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-4 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<div id="odvBtnPOInfo">
							<?php if($aAlwEventPO['tAutStaFull'] == 1 || $aAlwEventPO['tAutStaAdd'] == 1) : ?>
								<button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePOAdd()">+</button>
							<?php endif; ?>
						</div>
						<div id="odvBtnAddEdit">
						<div class="demo-button xCNBtngroup" style="width:100%;">
							<button onclick="JSvCallPagePOList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
							<?php if($aAlwEventPO['tAutStaFull'] == 1 || ($aAlwEventPO['tAutStaAdd'] == 1 || $aAlwEventPO['tAutStaEdit'] == 1)) : ?>
								<button id="obtPOCancel" onclick="JSnPOCancel(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel')?></button>
								<button id="obtPOApprove" onclick="JSnPOApprove(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove')?></button>
								<div class="btn-group">
									<button type="button" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitPO').click()"> <?php echo language('common/main/main', 'tSave')?></button>
									<?php echo $vBtnSave?>
								</div>
							<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="xCNPOVBrowse">
				<div class="col-xs-12 col-md-6">
					<a class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNIcon"></i>	
					</a>
					<ol id="oliPONavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
						<li class="xWBtnPrevious"><a><?= language('common/main/main', 'tShowData')?> : <?= language('promotion/promotion/promotion', 'tPMTTitle')?></a></li>
						<li class="active"><a><?= language('common/main/main', 'tAddData')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-6 text-right">
					<div id="odvPOBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
						<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPO').click()"><?= language('common/main/main', 'tSave')?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="xCNMenuCump xCNPOBrowseLine" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content">
	<div id="odvContentPagePO">
	</div>
</div>
<script>
	var tBaseURL = '<?php echo base_url(); ?>';
	//tSys Decimal Show
	var nOptDecimalShow = '<?php echo $nOptDecimalShow; ?>';
	var nOptDecimalSave = '<?php echo $nOptDecimalSave; ?>';
	
</script>

<!-- Load Lang Eticket -->
<?php if ($_SESSION['lang'] == 'en'):?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jEN.js"></script>
<?php else:?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jTH.js"></script>
<?php endif?>
<!-- END Load Lang Eticket -->

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/document/assets/src/purchaseorder/jPurchaseorder.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/document/assets/src/purchaseorder/jBrowseProduct.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js" integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>