<input id="oetSdtStaBrowse" type="hidden" value="<?php echo $nSdtBrowseType?>">
<input id="oetSdtCallBackOption" type="hidden" value="<?php echo  $tSdtBrowseOption?>">

<?php if(isset($nSdtBrowseType) && $nSdtBrowseType == 0) : ?>
	<div id="odvSdtMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
			
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<li id="oliSdtTitle" class="xCNLinkClick" onclick="JSvCallPageSubdistrictList()" style="cursor:pointer"><?php echo  language('address/subdistrict/subdistrict','tSDTTitle')?></li>
							<li id="oliSdtTitleAdd" class="active"><a><?php echo  language('address/subdistrict/subdistrict','tSDTTitleAdd')?></a></li>
							<li id="oliSdtTitleEdit" class="active"><a><?php echo  language('address/subdistrict/subdistrict','tSDTTitleEdit')?></a></li>
						</ol>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
						<div class="demo-button xCNBtngroup" style="width:100%;">
							<div id="odvBtnSdtInfo">
								<?php if($aAlwEventSubdistrict['tAutStaFull'] == 1 || $aAlwEventSubdistrict['tAutStaAdd'] == 1) : ?>
									<button onclick="JSvCallPageSubdistrictAdd()" class="xCNBTNPrimeryPlus" type="submit" >+</button>
								<?php endif; ?>
							</div>
							<div id="odvBtnAddEdit">
								<button onclick="JSvCallPageSubdistrictList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo  language('common/main/main', 'tBack')?></button>
								<?php if($aAlwEventSubdistrict['tAutStaFull'] == 1 || ($aAlwEventSubdistrict['tAutStaAdd'] == 1 || $aAlwEventSubdistrict['tAutStaEdit'] == 1)) : ?>
									<div class="btn-group">
										<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitSubdistrict').click()"> <?php echo  language('common/main/main', 'tSave')?></button>
										<?php echo $vBtnSave?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
					
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNSdtBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageSubdistrict" class="panel panel-headline">
		</div>
	</div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tSdtBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliZneNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSdtBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('address/subdistrict/subdistrict','tSDTTitle')?></a></li>
                    <li class="active"><a><?php echo language('address/subdistrict/subdistrict','tSDTTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvZneBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitSubdistrict').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>

<script src="<?php echo base_url(); ?>application/modules/address/assets/src/subdistrict/jSubdistrict.js"></script>