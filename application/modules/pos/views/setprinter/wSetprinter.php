<input id="oetSprStaBrowse" type="hidden" value="<?php echo $nSprBrowseType; ?>">
<input id="oetSprCallBackOption" type="hidden" value="<?php echo $tSprBrowseOption; ?>">

<?php if(isset($nSprBrowseType) && $nSprBrowseType == 0) : ?>
	<div id="odvSprMainMenu" class="main-menu clearfix">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="xCNSprVMaster">
					<div class="col-xs-12 col-md-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<li id="oliSprTitle" class="xCNLinkClick" onclick="JSvCallPageSetprinter('')"><?php echo language('pos/setprinter/Setprinter','tSprTitle'); ?></li>
							<li id="oliSprTitleAdd" class="active"><a><?php echo language('pos/setprinter/Setprinter','tSprTitleAdd'); ?></a></li>
							<li id="oliSprTitleEdit" class="active"><a><?php echo language('pos/setprinter/Setprinter','tSprTitleEdit'); ?></a></li>
						</ol>
					</div>
					<div class="col-xs-12 col-md-4 text-right">
						<div class="demo-button xCNBtngroup" style="width:100%;">
							<div id="odvBtnSprInfo">
								<button id="obtSprAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageSetprinterAdd()" title="<?php echo language('common/main/main', 'tAdd'); ?>">+</button>
							</div>
							<div id="odvBtnAddEdit">
								<button onclick="JSvCallPageSetprinter()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
								<div class="btn-group">
									<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSetprinter').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>
									<?php echo $vBtnSave; ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="xCNSprVBrowse">
					<div class="col-xs-12 col-md-6">
						<a onclick="JCNxBrowseData('<?php echo $tSprBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
							<i class="fa fa-arrow-left xCNIcon"></i>	
						</a>
						<ol id="oliSprNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
							<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSprBrowseOption; ?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('pos/setprinter/Setprinter','tSprTitle'); ?></a></li>
							<li class="active"><a><?php echo language('pos/setprinter/Setprinter','tSprTitleAdd'); ?></a></li>
						</ol>
					</div>
					<div class="col-xs-12 col-md-6 text-right">
						<div id="odvSprBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
							<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSetprinter').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNSmgBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
        <div id="odvContentPageSetprinter" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a onclick="JCNxBrowseData('<?php echo $tSprBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
					<i class="fa fa-arrow-left xCNIcon"></i>	
				</a>
				<ol id="oliSprNavBrowse" class="breadcrumb xCNMenuModalBrowse">
					<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSprBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?= language('pos/setprinter/Setprinter','tSprTitle')?></a></li>
					<li class="active"><a><?= language('pos/setprinter/Setprinter','tSprTitleAdd')?></a></li>
				</ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
			<div id="odvSprBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSetprinter').click()"><?php echo language('common/main/main', 'tSave')?></button>
				</div>
			</div>
			</div>
		</div>
	<div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
	</div>
<?php endif;?>	
<script src="<?= base_url('application/modules/common/assets/js/jquery-ui-sortable.min.js')?>"></script>
<script src="<?= base_url('application/modules/pos/assets/src/setprinter/jSetprinter.js')?>"></script>




