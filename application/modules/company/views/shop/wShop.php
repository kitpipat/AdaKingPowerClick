<input id="oetShpStaBrowse" type="hidden" value="<?=$nShpBrowseType?>">
<input id="oetShpCallBackOption" type="hidden" value="<?=$tShpBrowseOption?>">
<input id="oetShpNameMenuGroup" type="hidden" value="<?=$tNameMenuGroup?>">

<?php
	//เปลี่ยนคำตาม name POS + LAYOUT + LOCKER
	if($tNameMenuGroup == 'POS'){
		$tShopCode_lang 				= language('company/shop/shop','tShopCode_POS');
		$tShopName_lang					= language('company/shop/shop','tShopName_POS');	
		$tShopNodata_lang				= language('company/shop/shop','tShopNodata_POS');
		$tSHPTitle_lang					= language('company/shop/shop','tSHPTitle_POS');
		$tSHPSubTitle_lang				= language('company/shop/shop','tSHPSubTitle_POS');
		$tSHPTitleAdd_lang				= language('company/shop/shop','tSHPTitleAdd_POS');
		$tSHPTitleEdit_lang				= language('company/shop/shop','tSHPTitleEdit_POS');
	}else if($tNameMenuGroup == 'LAYOUT'){
		$tShopCode_lang 				= language('company/shop/shop','tShopCode_LAYOUT');
		$tShopName_lang					= language('company/shop/shop','tShopName_LAYOUT');	
		$tShopNodata_lang				= language('company/shop/shop','tShopNodata_LAYOUT');
		$tSHPTitle_lang					= language('company/shop/shop','tSHPTitle_LAYOUT');
		$tSHPSubTitle_lang				= language('company/shop/shop','tSHPSubTitle_LAYOUT');
		$tSHPTitleAdd_lang				= language('company/shop/shop','tSHPTitleAdd_LAYOUT');
		$tSHPTitleEdit_lang				= language('company/shop/shop','tSHPTitleEdit_LAYOUT');
	}else if($tNameMenuGroup == 'LOCKER'){
		$tShopCode_lang 				= language('company/shop/shop','tShopCode_LOCKER');
		$tShopName_lang					= language('company/shop/shop','tShopName_LOCKER');	
		$tShopNodata_lang				= language('company/shop/shop','tShopNodata_LOCKER');
		$tSHPTitle_lang					= language('company/shop/shop','tSHPTitle_LOCKER');
		$tSHPSubTitle_lang				= language('company/shop/shop','tSHPSubTitle_LOCKER');
		$tSHPTitleAdd_lang				= language('company/shop/shop','tSHPTitleAdd_LOCKER');
		$tSHPTitleEdit_lang				= language('company/shop/shop','tSHPTitleEdit_LOCKER');
	}
?>

<?php if(isset($nShpBrowseType) && $nShpBrowseType == 0) : ?>
	<div id="odvShpMainMenu" class="main-menu clearfix">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<?php FCNxHADDfavorite('shop/0/0/'.$tNameMenuGroup);?> 
							<li id="oliShpTitle" class="xCNLinkClick" onclick="JSvCallPageShopList()" style="cursor:pointer"><?=$tSHPTitle_lang?></li>
							<li id="oliShpTitleAdd"  class="active"><a><?=$tSHPTitleAdd_lang?></a></li>
							<li id="oliShpTitleEdit" class="active"><a><?=$tSHPTitleEdit_lang?></a></li>
						</ol>
					</div>
					<div id="odvBtnGrpShop" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
						<div id="odvBtnShpInfo">
							<?php if($aAlwEventShop['tAutStaFull'] == 1 || $aAlwEventShop['tAutStaAdd'] == 1) : ?>
								<button class="xCNBTNPrimeryPlus" type="button" onclick="JSvSHPAddPage()">+</button>
							<?php endif; ?>
							<script>
								if('<?=$this->session->userdata('tSesUsrLevel')?>' == 'SHP'){
									$('.xCNBTNPrimeryPlus').hide();
								}
							</script>
						</div>
						<div id="odvBtnAddEdit">
							<button onclick="JSvCallPageShopList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tBack')?></button>
							<?php if($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaAdd'] == 1 || $aAlwEventShop['tAutStaEdit'] == 1)) : ?>
								<div class="btn-group">
									<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitShp').click()"> <?=language('common/main/main', 'tSave')?></button>
									<?=$vBtnSave?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<div class="xCNMenuCump xCNShpBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageShop" class="panel panel-headline" style="margin-bottom:0px;">
        </div>
    </div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a onclick="JCNxBrowseData('<?=$tShpBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
					<i class="fa fa-arrow-left xCNIcon"></i>	
				</a>
				<ol id="oliShpNavBrowse" class="breadcrumb xCNMenuModalBrowse">
					<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?=$tShpBrowseOption?>')"><a><?=language('common/main/main','tShowData');?> : <?=$tSHPTitle_lang?></a></li>
					<li class="active"><a><?=$tSHPTitleAdd_lang?></a></li>
				</ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvShpBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitShp').click()"><?=language('common/main/main', 'tSave')?></button>
				</div>
			</div>
		</div>
	</div>
	<div id="odvModalBodyBrowse" class="modal-body">
	</div>
<?php endif;?>

<script src="<?=base_url('application/modules/company/assets/src/shop/jShop.js'); ?>"></script>
<script src="<?=base_url('application/modules/company/assets/src/shopgpbyshp/jShopGpByShp.js'); ?>"></script>
<script src="<?=base_url('application/modules/company/assets/src/shopgpbypdt/jShopGpByPdt.js'); ?>"></script>
<script src="<?=base_url('application/modules/pos/assets/src/posshop/jPosShop.js'); ?>"></script>
<script src="<?=base_url('application/modules/vending/assets/src/vendingshoptype/jVendingshoptype.js'); ?>"></script>
<script src="<?=base_url('application/modules/vending/assets/src/vendingshoplayout/jVendingshoplayout.js'); ?>"></script>
<script src="<?=base_url('application/modules/vending/assets/src/vendingshoplayout/jVendingManagelayout.js');?>"></script>