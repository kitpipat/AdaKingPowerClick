<input id="oetPshStaBrowse" type="hidden" value="<?=$nPshBrowseType?>">
<input id="oetPshCallBackOption" type="hidden" value="<?=$tPshBrowseOption?>">
<!-- <input id="oetPshRouteFromName"  type="hidden" value="<?=$tRouteFromName?>"> -->

<?php if(isset($nPshBrowseType) && $nPshBrowseType == 0) : ?>
<div id="odvPshMainMenu" class="main-menu"> 
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNPshVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> 
                        <li id="oliPshTitle" class="xCNLinkClick" onclick="JSvCallPagePdtLocList()" style="cursor:pointer"><?= language('product/pdtlocation/pdtlocation','tLOCTitle')?></li> 
                        <li id="oliPshTitleAdd" class="active"><a><?= language('product/pdtlocation/pdtlocation','tLOCTitleAdd')?></a></li>
                        <li id="oliPshTitleManage" class="active"><a><?= language('product/pdtlocation/pdtlocation','tLOCTitleManage')?></a></li>
                        <li id="oliPshTitleEdit" class="active"><a><?= language('product/pdtlocation/pdtlocation','tLOCTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> 
                    <div id="odvBtnPshInfo">
                        <?php if($aAlwEventPosShop['tAutStaFull'] == 1 || $aAlwEventPosShop['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtLocAdd()">+</button>
                        <?php endif;?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPagePdtLocList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventPosShop['tAutStaFull'] == 1 || ($aAlwEventPosShop['tAutStaAdd'] == 1 || $aAlwEventPosShop['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="button" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitPosShop').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNPshVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tPshBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPshBrowseOption?>')"><a>แสดงข้อมูล : <?php echo language('product/pdtlocation/pdtlocation','tLOCTitle')?></a></li>
                        <li class="active"><a><?php echo  language('product/pdtlocation/pdtlocation','tLOCTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPosShop').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<div class="xCNMenuCump xCNPshBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPagePosShop"></div>
</div>
<script src="<?= base_url('application/modules/pos/assets/src/posshop/jPosShop.js')?>"></script>