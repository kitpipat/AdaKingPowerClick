<input id="oetMcnStaBrowse" type="hidden" value="<?php echo $nMerchantType?>">
<input id="oetMcnCallBackOption" type="hidden" value="<?php echo $tMerchantOption?>">
<?php if(isset($nMerchantType) && $nMerchantType == 0) : ?>
	<div id="odvRsnMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('merchant/0/0');?> 
						<li id="oliRsnTitle" onclick="JSvCallPageMerchantList()" style="cursor:pointer"><?php echo language('merchant/merchant/merchant','tMerchantTitle')?></li>
						<li id="oliRsnTitleAdd" class="active"><a><?php echo language('merchant/merchant/merchant','tMerchantTitleAdd')?></a></li>
						<li id="oliRsnTitleEdit" class="active"><a><?php echo language('merchant/merchant/merchant','tMerchantTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
					<div id="odvBtnRsnInfo">
					<?php if($aAlwEventMerchant['tAutStaFull'] == 1 || ($aAlwEventMerchant['tAutStaAdd'] == 1 || $aAlwEventMerchant['tAutStaEdit'] == 1)) : ?>
						<button class="xCNBTNPrimeryPlus" type="submit" onclick="JSvCallPageMerchantAdd()">+</button>
					<?php endif;?>
					</div>
					<div id="odvBtnRsnAddEdit">
						<button onclick="JSvCallPageMerchantList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventMerchant['tAutStaFull'] == 1 || ($aAlwEventMerchant['tAutStaAdd'] == 1 || $aAlwEventMerchant['tAutStaEdit'] == 1)) : ?>
						<div class="btn-group">
							<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitMerchant').click()"> <?php echo language('common/main/main', 'tSave')?></button>
							<?php echo $vBtnSave?>
						</div>
					<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNRsnBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageMerchant" class="panel panel-headline"> <!-- เนื้อหาส่วนตาราง -->
		</div>
	</div>
<?php else: ?>
<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tMerchantOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tMerchantOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('merchant/merchant/merchant','tMerchantTitle')?></a></li>
                    <li class="active"><a><?php echo language('merchant/merchant/merchant','tMerchantTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitMerchant').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>

<script src="<?php echo base_url('application/modules/merchant/assets/src/merchant/jMerchant.js'); ?>"></script>