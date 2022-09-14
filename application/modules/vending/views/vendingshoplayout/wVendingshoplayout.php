<input id="oetVslStaBrowse" type="hidden" value="<?=$nVslBrowseType?>">
<input id="oetVslCallBackOption" type="hidden" value="<?=$tVslBrowseOption?>">

 <?php if(isset($nVslBrowseType) && $nVslBrowseType == 0) : ?>
	<div id="odvVslMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<li id="oliVslTitle" onclick="JSvCallPageVendingShoplayoutList()" style="cursor:pointer"><?= language('vending/vendingshoplayout/vendingshoplayout','tVendingShopLayoutHead')?></li>
						
						<li id="oliVslStore" class="active"><a><?php echo  language('company/shop/shop','tSHPTitle')?></a></li>
						<li id="oliVslManageProduct" class="active"><a><?= language('vending/vendingshoplayout/vendingmanage','tVendingManageHead')?></a></li>
						
						<li id="oliVslTitleAdd" class="active"><a><?= language('vending/vendingshoplayout/vendingshoplayout','tVEDTitleAdd')?></a></li>
						<li id="oliVslTitleEdit" class="active"><a><?= language('vending/vendingshoplayout/vendingshoplayout','tVEDTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">

					<div id="odvBtnVslInfo">
					<?php if($aAlwEventvendingshoplayout['tAutStaFull'] == 1 || ($aAlwEventvendingshoplayout['tAutStaAdd'] == 1 || $aAlwEventvendingshoplayout['tAutStaEdit'] == 1)) : ?>
						<button class="xCNBTNPrimeryPlus" type="submit" onclick="JSvCallPageVendingShoplayoutAdd()">+</button>
					<?php endif;?>
					</div>

					<div id="odvBtnVslAddEdit">
						<button onclick="JSvCallPageVendingShoplayoutList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?= language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventvendingshoplayout['tAutStaFull'] == 1 || ($aAlwEventvendingshoplayout['tAutStaAdd'] == 1 || $aAlwEventvendingshoplayout['tAutStaEdit'] == 1)) : ?>
						<div class="btn-group">
							<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitVendingShopLayout').click()"> <?= language('common/main/main', 'tSave')?></button>
							<?=$vBtnSave?>
						</div>
						<?php endif;?>
					</div>

					<!--BTN Save in vendingmanage-->
					<div id="odvBtnVslManage">
						<button onclick="JSvCallPageVendingShoplayoutList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?= language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventvendingshoplayout['tAutStaFull'] == 1 || ($aAlwEventvendingshoplayout['tAutStaAdd'] == 1 || $aAlwEventvendingshoplayout['tAutStaEdit'] == 1)) : ?>
						<div class="btn-group">
							<button type="button" class="btn xWBtnGrpSaveLeft" onclick="JSxInsertPDTintoDatabase();"> <?= language('common/main/main', 'tSave')?> / Manage</button>
							<?=$vBtnSave?>
						</div>
						<?php endif;?>
					</div>
					<!--END BTN Save in vendingmanage-->

				</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNVslBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageVendingShoplayout" class="panel panel-headline">
		</div>
	</div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tVslBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tVslBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('vending/vendingshoplayout/vendingshoplayout','tVendingShopLayoutHead')?></a></li>
                    <li class="active"><a><?php echo language('vending/vendingshoplayout/vendingshoplayout','tVEDTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitVendingShopLayout').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>

<script src="<?php echo base_url('application/modules/vending/assets/src/vendingshoplayout/jVendingshoplayout.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/vending/assets/src/vendingshoplayout/jVendingManagelayout.js');?>"></script>