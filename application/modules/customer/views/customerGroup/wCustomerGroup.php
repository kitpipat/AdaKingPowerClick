<input type="hidden" id="oetCstGrpStaBrowse" value="<?php echo $nCstGrpBrowseType;?>">
<input type="hidden" id="oetCstGrpCallBackOption" value="<?php echo $tCstGrpBrowseOption;?>">

<?php if(isset($nCstGrpBrowseType) && $nCstGrpBrowseType == 0): ?>
	<div id="odvCstGrpMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('customerGroup/0/0');?> 
                        <li id="oliCstGrpTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageCstGrp('')"><?php echo language('customer/customerGroup/customerGroup','tCstGrpTitle')?></li>
						<li id="oliCstGrpTitleAdd" class="active"><a><?php echo language('customer/customerGroup/customerGroup','tCstGrpTitleAdd')?></a></li>
						<li id="oliCstGrpTitleEdit" class="active"><a><?php echo language('customer/customerGroup/customerGroup','tCstGrpTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<div id="odvBtnCstGrpInfo">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
								<button id="obtCstGrpAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCstGrpAdd()">+</button>
							<?php endif; ?>
						</div>
						<div id="odvBtnAddEdit">
							<div class="demo-button xCNBtngroup" style="width:100%;">
								<button onclick="JSvCallPageCstGrp()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
								<?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)):?>
									<div class="btn-group">
										<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCstGrp').click()"> <?php echo language('common/main/main', 'tSave')?></button>
										<?php echo $vBtnSave?>
									</div>
								<?php endif;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNCstGrpBrowseLine" id="odvMenuCump">&nbsp;</div>
	<div class="main-content">
        <div id="odvContentPageCstGrp" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahCstGrpBrowseCallBack" onclick="JCNxBrowseData('<?php echo $tCstGrpBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliCstGrpNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliCstGrpBrowsePrevious" onclick="JCNxBrowseData('<?php echo $tCstGrpBrowseOption?>')" class="xWBtnPrevious"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('customer/customerGroup/customerGroup','tCstGrpTitle');?></a></li>
                    <li class="active"><a><?php echo language('customer/customerGroup/customerGroup','tCstGrpTitleAdd');?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvCstGrpBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtCstGrpBrowseSubmit" type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCstGrp').click()">
						<?php echo language('common/main/main', 'tSave');?>
					</button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script src="<?php echo base_url('application/modules/customer/assets/src/customerGroup/jCstGroup.js')?>"></script>