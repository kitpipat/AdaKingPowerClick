<input id="oetRteStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetRteCallBackOption" type="hidden" value="<?=$tBrowseOption?>">


<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
	<div id="odvRteMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<?php FCNxHADDfavorite('rate/0/0');?> 
							<li id="oliRteTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageRateList()"><?= language('payment/rate/rate','tRTETitle')?></li>
							<li id="oliRteTitleAdd" class="active"><a><?= language('payment/rate/rate','tRTETitleAdd')?></a></li>
							<li id="oliRteTitleEdit" class="active"><a><?= language('payment/rate/rate','tRTETitleEdit')?></a></li>
						</ol>
					</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
			<div class="demo-button xCNBtngroup" style="width:100%;">
				<div id="odvBtnRteInfo">
					<?php if($aAlwEventRate['tAutStaFull'] == 1 || $aAlwEventRate['tAutStaAdd'] == 1) : ?>
						<button id="obtRteAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageRateAdd()">+</button>
					<?php endif; ?>
				</div> 
			<div id="odvBtnAddEdit">
				<button onclick="JSvCallPageRateList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?= language('common/main/main', 'tBack')?></button>
					<?php if($aAlwEventRate['tAutStaFull'] == 1 || ($aAlwEventRate['tAutStaAdd'] == 1 || $aAlwEventRate['tAutStaEdit'] == 1)) : ?>
						<div class="btn-group"  id="obtBarSubmitRte">
							<div class="btn-group">
							<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitRate').click()"><?= language('common/main/main', 'tSave')?></button>
							<?=$vBtnSave?>
							</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			</div>
			</div>
		</div>
	<div class="xCNMenuCump" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageRate" class="panel panel-headline"></div>
	</div>
	<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
	<?php else: ?>
		<div class="modal-header xCNModalHead">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<a onclick="JCNxBrowseData('<?php echo $tBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
						<i class="fa fa-arrow-left xCNIcon"></i>	
					</a>
					<ol id="oliBchNavBrowse" class="breadcrumb xCNMenuModalBrowse">
						<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?= language('payment/rate/rate','tRTETitle')?></a></li>
						<li class="active"><a><?= language('payment/rate/rate','tRTETitleAdd')?></a></li>
					</ol>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvBchBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
						<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitRate').click()"><?php echo language('common/main/main', 'tSave')?></button>
					</div>
				</div>
				</div>
			</div>
		<div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
		</div>
	<?php endif;?>	
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/payment/assets/src/rate/jRate.js"></script>