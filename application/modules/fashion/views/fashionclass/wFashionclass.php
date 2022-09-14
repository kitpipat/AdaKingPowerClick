<input id="oetClsStaBrowse" type="hidden" value="<?php echo $nClsBrowseType; ?>">
<input id="oetClsCallBackOption" type="hidden" value="<?php echo $tClsBrowseOption; ?>">


<?php if (isset($nClsBrowseType) && $nClsBrowseType == 0) : ?>
	<div id="odvClsMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('masPDTClass/0/0'); ?>
						<li id="oliClsTitle" class="xCNLinkClick" onclick="JSvCallPageFashionClass('')"><?php echo language('fashion/fashionclass/fashionclass', 'tFashionClassTitle'); ?></li>
						<li id="oliClsTitleAdd" class="active"><a><?php echo language('fashion/fashionclass/fashionclass', 'tFashionClassTitleAdd'); ?></a></li>
						<li id="oliClsTitleEdit" class="active"><a><?php echo language('fashion/fashionclass/fashionclass', 'tFashionClassTitleEdit'); ?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-4 text-right p-r-0">
					<div id="odvBtnClsInfo">
						<button id="obtClsAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageFashionClassAdd()" title="<?php echo language('common/main/main', 'tAdd'); ?>">+</button>

					</div>
					<div id="odvBtnAddEdit" style="margin-top:3px">
						<div class="demo-button xCNBtngroup" style="width:100%;">
							<button onclick="JSvCallPageFashionClass()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
							<div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitFashionClass').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>
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
				<a onclick="JCNxBrowseData('<?php echo $tClsBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
					<i class="fa fa-arrow-left xCNIcon"></i>
				</a>
				<ol id="oliChnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
					<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tClsBrowseOption; ?>')"><a><?= language('common/main/main', 'tShowData') ?> : <?php echo language('pos/slipMessage/slipmessage', 'tSMGTitle'); ?></a></li>
					<li class="active"><a><?php echo language('pos/slipMessage/slipmessage', 'tSMGTitleAdd'); ?></a></li>
				</ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvChnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitFashionClass').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<div id="odvContentPageChanel" class="modal-body xCNModalBodyAdd">
	</div>
<?php endif; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery-ui-sortable.min.js') ?>"></script>
<script src="<?= base_url('application/modules/fashion/assets/src/fashionclass/jFashionclass.js') ?>"></script>