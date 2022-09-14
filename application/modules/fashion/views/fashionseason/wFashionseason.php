<input id="oetSeaStaBrowse" type="hidden" value="<?php echo $nSeaBrowseType; ?>">
<input id="oetSeaCallBackOption" type="hidden" value="<?php echo $tSeaBrowseOption; ?>">


<?php if (isset($nSeaBrowseType) && $nSeaBrowseType == 0) : ?>
	<div id="odvSeaMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('masPDTSeason/0/0'); ?>
						<li id="oliSeaTitle" class="xCNLinkClick" onclick="JSvCallPageFashionSeason('')"><?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonTitle'); ?></li>
						<li id="oliSeaTitleAdd" class="active"><a><?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonTitleAdd'); ?></a></li>
						<li id="oliSeaTitleEdit" class="active"><a><?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonTitleEdit'); ?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-4 text-right p-r-0">
					<div id="odvBtnSeaInfo">
						<button id="obtSeaAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageFashionSeasonAdd()" title="<?php echo language('common/main/main', 'tAdd'); ?>">+</button>

					</div>
					<div id="odvBtnAddEdit" style="margin-top:3px">
						<div class="demo-button xCNBtngroup" style="width:100%;">
							<button onclick="JSvCallPageFashionSeason()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
							<div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitFashionSeason').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>
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
	<input type="hidden" name="ohdbaseURL" id="ohdbaseURL" value="<?php echo  base_url(); ?>">


<?php else : ?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a onclick="JCNxBrowseData('<?php echo $tSeaBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
					<i class="fa fa-arrow-left xCNIcon"></i>
				</a>
				<ol id="oliChnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
					<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSeaBrowseOption; ?>')"><a><?= language('common/main/main', 'tShowData') ?> : <?php echo language('pos/slipMessage/slipmessage', 'tSMGTitle'); ?></a></li>
					<li class="active"><a><?php echo language('pos/slipMessage/slipmessage', 'tSMGTitleAdd'); ?></a></li>
				</ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvChnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitFashionSeason').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<div id="odvContentPageChanel" class="modal-body xCNModalBodyAdd">
	</div>
<?php endif; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery-ui-sortable.min.js') ?>"></script>
<script src="<?= base_url('application/modules/fashion/assets/src/fashionseason/jFashionseason.js') ?>"></script>