<input id="oetBchStaBrowse"       type="hidden" value="<?=$nBrowseType?>">
<input id="oetBchCallBackOption"  type="hidden" value="<?=$tBrowseOption?>">
<input id="oetBchRouteFromName"   type="hidden" value="<?=$tRouteFromName?>">
<input id="oetBchSessionCstKey"   type="hidden" value="<?=$this->session->userdata('tSesCstKey')?>">

<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
	<div id="odvBchMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<?php FCNxHADDfavorite('branch/0/0');?> 
							<li id="oliBCHTitle" class="xCNLinkClick" onclick="JSvBCHCallPageBranchList()" style="cursor:pointer"><?= language('company/branch/branch','tBCHSubTitle')?></li>
							<li id="oliBCHAdd"  class="active"><a><?= language('company/branch/branch','tBCHAddBranch')?></a></li>
							<li id="oliBCHEdit"  class="active"><a><?= language('company/branch/branch','tBCHTitleEdit')?></a></li>

							<li id="oliBCHSHP" onclick="$('#obtBackShp').click();"  class="active"><a><?= language('company/shop/shop','tSHPTitle')?></a></li>
							<li id="oliBCHSHPAdd"  class="active"><a><?= language('company/shop/shop','tSHPTitleAdd')?></a></li>
							<li id="oliBCHSHPEdit"  class="active"><a><?= language('company/shop/shop','tSHPTitleEdit')?></a></li>
						</ol>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
						<div id="odvBtnCmpEditInfo">
							<button onclick="JSvBCHCallPageBranchList()" id="obtBarBackBch" class="btn btn-default xCNBTNDefult" type="submit"> <?= language('common/main/main', 'tBack')?></button>
								<?php if($aAlwEventBranch['tAutStaFull'] == 1 || ($aAlwEventBranch['tAutStaAdd'] == 1 || $aAlwEventBranch['tAutStaEdit'] == 1)) : ?>
									<div class="btn-group">
									<button onclick="$('#obtSubmitBch').click();" class="btn btn-default xWBtnGrpSaveLeft" type="submit"> <?= language('common/main/main', 'tSave')?></button>
									<?=$vBtnSaveBranch?>
								</div>
							<?php endif; ?>
						</div>
					<div id="odvBtnBchInfo">
						<?php $BchCode = $this->session->userdata("tSesUsrBchCodeOld"); ?>
							<?php // if($BchCode == '' || $BchCode == null) : ?>
								<?php if($aAlwEventBranch['tAutStaFull'] == 1 || $aAlwEventBranch['tAutStaAdd'] == 1) : ?>
									      
										  <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvBCHCallPageBranchAdd('','','');">+</button>
								<?php endif; ?>
							<?php //endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<div class="xCNMenuCump xCNPtyBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageBranch" class="panel panel-headline"></div>
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
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('company/branch/branch','tBCHTitle')?></a></li>
                    <li class="active"><a><?php echo language('company/branch/branch','tBCHAddBranch')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvBchBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitBch').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>	

<?php if($tRouteFromName != 'shop'): ?>
	<!-- <script src="<?= base_url('application/modules/company/assets/js/shop/jShop.js'); ?>"></script>  -->
<?php endif; ?>
<script src="<?= base_url('application/modules/company/assets/src/branch/jBranch.js'); ?>"></script>

