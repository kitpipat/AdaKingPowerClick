<input type="hidden" id="oetLabPriStaBrowse" value="<?php echo $nLabPriBrowseType; ?>">
<input type="hidden" id="oetLabCallBackOption" value="<?php echo $tLabPriBrowseOption; ?>">

<?php if (isset($nLabPriBrowseType) && $nLabPriBrowseType == 0) : ?>
	<div id="odvLabPriMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('LablePrinter/0/0'); ?>
						<li id="oliLabPriTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageLabPri('')"><?php echo language('product/settingprinter/settingprinter', 'tLPTitle') ?></li>
						<li id="oliLabPriTitleAdd" class="active"><a><?php echo language('product/settingprinter/settingprinter', 'tLPTitleAdd') ?></a></li>
						<li id="oliLabPriTitleEdit" class="active"><a><?php echo language('product/settingprinter/settingprinter', 'tLPTitleEdit') ?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<div id="odvBtnLabPriInfo">
							<?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
								<button id="obtLabPriAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageLabPriAdd()">+</button>
							<?php endif; ?>
						</div>
						<div id="odvBtnAddEdit">
							<div class="demo-button xCNBtngroup" style="width:100%;">
								<button onclick="JSvCallPageLabPri()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack') ?></button>
								<?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
									<div class="btn-group">
										<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitLabPri').click()"> <?php echo language('common/main/main', 'tSave') ?></button>
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
	<div class="xCNMenuCump xCNLabPriBrowseLine" id="odvMenuCump">&nbsp;</div>
	<div class="main-content">
		<div id="odvContentPageLabPri" class="panel panel-headline">
		</div>
	</div>
<?php else : ?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a id="oahLabPriBrowseCallBack" onclick="JCNxBrowseData('<?php echo $tLabPriBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
					<i class="fa fa-arrow-left xCNIcon"></i>
				</a>
				<ol id="oliLabPriNavBrowse" class="breadcrumb xCNMenuModalBrowse">
					<li id="oliLabPriBrowsePrevious" onclick="JCNxBrowseData('<?php echo $tLabPriBrowseOption ?>')" class="xWBtnPrevious"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('customer/customerGroup/customerGroup', 'tCstGrpTitle'); ?></a></li>
					<li class="active"><a><?php echo language('customer/customerGroup/customerGroup', 'tCstGrpTitleAdd'); ?></a></li>
				</ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvLabPriBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button id="obtLabPriBrowseSubmit" type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitLabPri').click()">
						<?php echo language('common/main/main', 'tSave'); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
	</div>
<?php endif; ?>
<script src="<?php echo base_url('application/modules/settingconfig/assets/src/settingprint/jLablePrinter.js') ?>"></script>


