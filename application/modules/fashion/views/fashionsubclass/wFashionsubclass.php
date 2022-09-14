<input id="oetSCLStaBrowse" type="hidden" value="<?php echo $nSCLBrowseType; ?>">
<input id="oetSCLCallBackOption" type="hidden" value="<?php echo $tSCLBrowseOption; ?>">


<?php if (isset($nSCLBrowseType) && $nSCLBrowseType == 0) : ?>
	<div id="odvSCLMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('fashionsubclass/0/0'); ?>
						<li id="oliSCLTitle" class="xCNLinkClick" onclick="JSvSCLCallPageList('')"><?php echo language('fashion/fashionsubclass/fashionsubclass', 'tSCLTitle'); ?></li>
						<li id="oliSCLTitleAdd" class="active"><a><?php echo language('fashion/fashionsubclass/fashionsubclass', 'tSCLTitleAdd'); ?></a></li>
						<li id="oliSCLTitleEdit" class="active"><a><?php echo language('fashion/fashionsubclass/fashionsubclass', 'tSCLTitleEdit'); ?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-4 text-right p-r-0">
					<div id="odvBtnSCLInfo">
						<button id="obtSCLAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSxSCLCallPageAdd()" title="<?php echo language('common/main/main', 'tAdd'); ?>">+</button>
					</div>
					<div id="odvBtnAddEdit" style="margin-top:3px">
						<div class="demo-button xCNBtngroup" style="width:100%;">
							<button onclick="JSvSCLCallPageList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
							<div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSCLSubmit').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>
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
		<div id="odvSCLContentPage"></div>
	</div>
	<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
<?php else : ?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a onclick="JCNxBrowseData('<?php echo $tSCLBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
					<i class="fa fa-arrow-left xCNIcon"></i>
				</a>
				<ol id="oliChnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
					<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSCLBrowseOption; ?>')"><a><?= language('common/main/main', 'tShowData') ?> : <?php echo language('pos/slipMessage/slipmessage', 'tSMGTitle'); ?></a></li>
					<li class="active"><a><?php echo language('pos/slipMessage/slipmessage', 'tSMGTitleAdd'); ?></a></li>
				</ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvChnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitSCL').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<div id="odvSCLContentPage" class="modal-body xCNModalBodyAdd">
	</div>
<?php endif; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery-ui-sortable.min.js') ?>"></script>
<script src="<?= base_url('application/modules/fashion/assets/src/fashionsubclass/jFashionsubclass.js') ?>"></script>