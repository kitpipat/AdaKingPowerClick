<input id="oetFabStaBrowse" type="hidden" value="<?php echo $nFabBrowseType; ?>">
<input id="oetFabCallBackOption" type="hidden" value="<?php echo $tFabBrowseOption; ?>">


<?php if (isset($nFabBrowseType) && $nFabBrowseType == 0) : ?>
	<div id="odvFabMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('masPDTFabric/0/0'); ?>
						<li id="oliFabTitle" class="xCNLinkClick" onclick="JSvCallPageFashionFabric('')"><?php echo language('fashion/fashionfabric/fashionfabric', 'tFashionFabricTitle'); ?></li>
						<li id="oliFabTitleAdd" class="active"><a><?php echo language('fashion/fashionfabric/fashionfabric', 'tFashionFabricTitleAdd'); ?></a></li>
						<li id="oliFabTitleEdit" class="active"><a><?php echo language('fashion/fashionfabric/fashionfabric', 'tFashionFabricTitleEdit'); ?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-4 text-right p-r-0">
					<div id="odvBtnFabInfo">
						<button id="obtFabAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageFashionFabricAdd()" title="<?php echo language('common/main/main', 'tAdd'); ?>">+</button>

					</div>
					<div id="odvBtnAddEdit" style="margin-top:3px">
						<div class="demo-button xCNBtngroup" style="width:100%;">
							<button onclick="JSvCallPageFashionFabric()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
							<div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitFashionFabric').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>
								<?php echo $vBtnSave; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNPtyBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageChanel"></div>
	</div>
	<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
<?php else : ?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a onclick="JCNxBrowseData('<?php echo $tFabBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
					<i class="fa fa-arrow-left xCNIcon"></i>
				</a>
				<ol id="oliChnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
					<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tFabBrowseOption; ?>')"><a><?= language('common/main/main', 'tShowData') ?> : <?php echo language('pos/slipMessage/slipmessage', 'tSMGTitle'); ?></a></li>
					<li class="active"><a><?php echo language('pos/slipMessage/slipmessage', 'tSMGTitleAdd'); ?></a></li>
				</ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvChnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitFashionFabric').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<div id="odvContentPageChanel" class="modal-body xCNModalBodyAdd">
	</div>
<?php endif; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery-ui-sortable.min.js') ?>"></script>
<script src="<?= base_url('application/modules/fashion/assets/src/fashionfabric/jFashionfabric.js') ?>"></script>