<input id="oetDstStaBrowse" type="hidden" value="<?php echo$nDstBrowseType?>">
<input id="oetDstCallBackOption" type="hidden" value="<?php echo$tDstBrowseOption?>">

<?php if(isset($nDstBrowseType) && $nDstBrowseType == 0) : ?>
	<div id="odvDstMainMenu" class="main-menu clearfix">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">

					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<li id="oliDstTitle" class="xCNLinkClick" onclick="JSvCallPageDistrictList('')" style="cursor:pointer"><?php echo language('address/district/district','tDSTTitle')?></li>
							<li id="oliDstTitleAdd" class="active"><a><?php echo language('address/district/district','tDSTTitleAdd')?></a></li>
							<li id="oliDstTitleEdit" class="active"><a><?php echo language('address/district/district','tDSTTitleEdit')?></a></li>
						</ol>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
						<div id="odvBtnDstInfo">
							<?php if($aAlwEventDistrict['tAutStaFull'] == 1 || $aAlwEventDistrict['tAutStaAdd'] == 1) : ?>
							<button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageDistrictAdd()">+</button>
							<?php endif; ?>
						</div>
						<div id="odvBtnAddEdit">
							<button onclick="JSvCallPageDistrictList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
							<?php if($aAlwEventDistrict['tAutStaFull'] == 1 || ($aAlwEventDistrict['tAutStaAdd'] == 1 || $aAlwEventDistrict['tAutStaEdit'] == 1)) : ?>
								<div class="btn-group">
									<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitDistrict').click()"> <?php echo language('common/main/main', 'tSave')?></button>
									<?php echo$vBtnSave?>
								</div>
							<?php endif; ?>
						</div>
					</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNDstBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageDistrict" class="panel panel-headline">
		</div>
	</div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tDstBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tDstBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('address/district/district','tDSTTitle')?></a></li>
                    <li class="active"><a><?php echo  language('address/district/district','tDSTTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitDistrict').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body">
    </div>
<?php endif;?>
<script src="<?php echo base_url(); ?>application/modules/address/assets/src/district/jDistrict.js"></script>