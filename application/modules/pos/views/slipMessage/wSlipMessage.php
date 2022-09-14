<input id="oetSmgStaBrowse" type="hidden" value="<?php echo $nSmgBrowseType; ?>">
<input id="oetSmgCallBackOption" type="hidden" value="<?php echo $tSmgBrowseOption; ?>">


<?php if(isset($nSmgBrowseType) && $nSmgBrowseType == 0) : ?>
	<div id="odvSmgMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('slipMessage/0/0');?> 
						<li id="oliSmgTitle" class="xCNLinkClick" onclick="JSvCallPageSlipMessage('')"><?php echo language('pos/slipMessage/slipmessage','tSMGTitle'); ?></li>
						<li id="oliSmgTitleAdd" class="active"><a><?php echo language('pos/slipMessage/slipmessage','tSMGTitleAdd'); ?></a></li>
						<li id="oliSmgTitleEdit" class="active"><a><?php echo language('pos/slipMessage/slipmessage','tSMGTitleEdit'); ?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
					<div id="odvBtnSmgInfo">
						<button id="obtSmgAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageSlipMessageAdd()" title="<?php echo language('common/main/main', 'tAdd'); ?>">+</button>
					</div>
					<div id="odvBtnAddEdit">
						<button onclick="JSvCallPageSlipMessage()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
						<div class="btn-group">
							<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitSlipMessage').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>
							<?php echo $vBtnSave; ?>
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
		<div id="odvContentPageSlipMessage"></div>
	</div>
	<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
	<?php else: ?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a onclick="JCNxBrowseData('<?php echo $tSmgBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
					<i class="fa fa-arrow-left xCNIcon"></i>	
				</a>
				<ol id="oliSmgNavBrowse" class="breadcrumb xCNMenuModalBrowse">
					<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSmgBrowseOption; ?>')"><a>แสดงข้อมูล : <?php echo language('pos/slipMessage/slipmessage','tSMGTitle'); ?></a></li>
					<li class="active"><a><?php echo language('pos/slipMessage/slipmessage','tSMGTitleAdd'); ?></a></li>
				</ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvSmgBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitSlipMessage').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<div id="odvContentPageSlipMessage" class="modal-body xCNModalBodyAdd">
	</div>
<?php endif;?>
<script src="<?= base_url('application/modules/common/assets/js/jquery-ui-sortable.min.js')?>"></script>
<script src="<?= base_url('application/modules/pos/assets/src/slipMessage/jSlipMessage.js')?>"></script>