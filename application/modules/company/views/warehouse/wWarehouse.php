<input id="oetWahStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetWahCallBackOption" type="hidden" value="<?=$tBrowseOption?>">
<input id="oetWahRouteFromName" type="hidden" value="<?=$tRouteFromName?>">

<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
<div class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="xCNWahVMaster">
				<div class="col-xs-12 col-md-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('warehouse/0/0');?> 
						<li id="oliWAHTitle" onclick="JSvCallPageWarehouseList()"  style="cursor:pointer" ><?= language('company/warehouse/warehouse','tWAHSubTitle')?></li>
						<li id="oliWAHAdd"  class="active"><a><?= language('company/warehouse/warehouse','tWAHAddWarehouse')?></a></li>
						<li id="oliWAHEdit"  class="active"><a><?= language('company/warehouse/warehouse','tWAHEditWarehouse')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-4 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<div id="odvBtnCmpEditInfo">
							<button onclick="JSvCallPageWarehouseList()" id="obtBarBack" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="submit"> <?= language('common/main/main', 'tBack')?></button>
							<?php if($aAlwEventWarehouse['tAutStaFull'] == 1 || ($aAlwEventWarehouse['tAutStaAdd'] == 1 || $aAlwEventWarehouse['tAutStaEdit'] == 1)) : ?>
							<div class="btn-group">
								<button onclick="$('#obtSubmitWah').click();" class="btn btn-default xWBtnGrpSaveLeft" type="submit"> <?= language('common/main/main', 'tSave')?></button>
								<?=$vBtnSave?>
							</div>
							<?php endif; ?>
						</div>
						<div id="odvBtnWahInfo">
							<?php if($aAlwEventWarehouse['tAutStaFull'] == 1 || $aAlwEventWarehouse['tAutStaAdd'] == 1) : ?>
							<button class="btn xCNBTNPrimery xCNBTNPrimery2Btn obtChoose" type="submit" data-toggle="modal" data-target="#odlmodaldelete"> <?= language('common/main/main', 'tDelAll')?></button>
							<button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageWarehouseAdd()">+</button>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="xCNMenuCump" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageWarehouse" class="panel panel-headline"></div>
</div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?=$tBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliBchNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?=$tBrowseOption?>')"><a><?= language('common/main/main', 'tShowData')?> : <?= language('company/warehouse/warehouse','tWAHSubTitle')?></a></li>
                    <li class="active"><a><?= language('company/warehouse/warehouse','tWAHAddWarehouse')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvBchBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitWah').click()"><?= language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body">
    </div>
<?php endif;?>
<script src="<?= base_url('application/modules/company/assets/src/warehouse/jWarehouse.js'); ?>"></script>