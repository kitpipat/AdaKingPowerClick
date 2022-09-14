<input id="oetVstStaBrowse" type="hidden" value="<?=$nVstBrowseType?>">
<input id="oetVstCallBackOption" type="hidden" value="<?=$tVstBrowseOption?>">

<?php if(isset($nVstBrowseType) && $nVstBrowseType == 0) : ?>
	<div id="odvVstMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<li id="oliVstTitle" onclick="JSvCallPageVendingShoptypeList()" style="cursor:pointer"><?= language('vending/vendingshoptype/vendingshoptype','tVendingShopHead')?></li>
						<li id="oliVstTitleAdd" class="active"><a><?= language('vending/vendingshoptype/vendingshoptype','tVEDTitleAdd')?></a></li>
						<li id="oliVstTitleEdit" class="active"><a><?= language('vending/vendingshoptype/vendingshoptype','tVEDTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
					<div id="odvBtnVstInfo">
					<?php if($aAlwEventVendingShoptype['tAutStaFull'] == 1 || ($aAlwEventVendingShoptype['tAutStaAdd'] == 1 || $aAlwEventVendingShoptype['tAutStaEdit'] == 1)) : ?>
						<button class="xCNBTNPrimeryPlus" type="submit" onclick="JSvCallPageVendingShopTypeAdd()">+</button>
					<?php endif;?>
					</div>
					<div id="odvBtnVstAddEdit">
						<button onclick="JSvCallPageVendingShoptypeList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?= language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventVendingShoptype['tAutStaFull'] == 1 || ($aAlwEventVendingShoptype['tAutStaAdd'] == 1 || $aAlwEventVendingShoptype['tAutStaEdit'] == 1)) : ?>
						<div class="btn-group">
							<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitVendingShopType').click()"> <?= language('common/main/main', 'tSave')?></button>
							<?=$vBtnSave?>
						</div>
					<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNVstBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageVendingShopType" class="panel panel-headline">
		</div>
	</div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?=$tVstBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?=$tVstBrowseOption?>')"><a><?=language('common/main/main','tShowData');?> : <?=language('vending/vendingshoptype/vendingshoptype','tVendingShopHead')?></a></li>
                    <li class="active"><a><?=language('vending/vendingshoptype/vendingshoptype','tVEDTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitVendingShopType').click()"><?=language('vending/vendingshoptype/vendingshoptype', 'tSaveShopLayout')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>

<script src="<?php echo base_url('application/modules/vending/assets/src/vendingshoptype/jVendingshoptype.js'); ?>"></script>