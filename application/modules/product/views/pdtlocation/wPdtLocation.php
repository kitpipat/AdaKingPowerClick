<input id="oetLocStaBrowse" type="hidden" value="<?=$nLocBrowseType?>">
<input id="oetLocCallBackOption" type="hidden" value="<?=$tLocBrowseOption?>">

<?php if(isset($nLocBrowseType) && $nLocBrowseType == 0) : ?>
<div id="odvLocMainMenu" class="main-menu"> 
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNLocVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> 
                        <?php FCNxHADDfavorite('pdtlocation/0/0');?> 
                        <li id="oliLocTitle" class="xCNLinkClick" onclick="JSvCallPagePdtLocList()" style="cursor:pointer"><?= language('product/pdtlocation/pdtlocation','tLOCTitle')?></li> 
                        <li id="oliLocTitleAdd" class="active"><a><?= language('product/pdtlocation/pdtlocation','tLOCTitleAdd')?></a></li>
                        <li id="oliLocTitleManage" class="active"><a><?= language('product/pdtlocation/pdtlocation','tLOCTitleManage')?></a></li>
                        <li id="oliLocTitleEdit" class="active"><a><?= language('product/pdtlocation/pdtlocation','tLOCTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> 
                    <div id="odvBtnLocInfo">
                        <?php if($aAlwEventPdtLocation['tAutStaFull'] == 1 || $aAlwEventPdtLocation['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtLocAdd()">+</button>
                        <?php endif;?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPagePdtLocList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventPdtLocation['tAutStaFull'] == 1 || ($aAlwEventPdtLocation['tAutStaAdd'] == 1 || $aAlwEventPdtLocation['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="button" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickPdtUnitSubmit();$('#obtSubmitPdtLoc').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNLocVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tLocBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tLocBrowseOption?>')"><a>แสดงข้อมูล : <?php echo language('product/pdtlocation/pdtlocation','tLOCTitle')?></a></li>
                        <li class="active"><a><?php echo  language('product/pdtlocation/pdtlocation','tLOCTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPdtLoc').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<div class="xCNMenuCump xCNLocBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPagePdtLoc"></div>
</div>
<script src="<?= base_url('application/modules/product/assets/src/pdtlocation/jPdtLocation.js')?>"></script>