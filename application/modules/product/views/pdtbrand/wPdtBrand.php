<input id="oetPbnStaBrowse" type="hidden" value="<?=$nPbnBrowseType?>">
<input id="oetPbnCallBackOption" type="hidden" value="<?=$tPbnBrowseOption?>">

<?php if(isset($nPbnBrowseType) && $nPbnBrowseType == 0) : ?>
<div id="odvPbnMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNPbnVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('pdtbrand/0/0');?> 
                        <li id="oliPbnTitle" class="xCNLinkClick" onclick="JSvCallPagePdtPbnList()" style="cursor:pointer"><?= language('product/pdtbrand/pdtbrand','tPBNTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliPbnTitleAdd" class="active"><a><?= language('product/pdtbrand/pdtbrand','tPBNTitleAdd')?></a></li>
                        <li id="oliPbnTitleEdit" class="active"><a><?= language('product/pdtbrand/pdtbrand','tPBNTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnPbnInfo">
                        <?php if($aAlwEventPdtBrand['tAutStaFull'] == 1 || $aAlwEventPdtBrand['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtPbnAdd()">+</button>
                        <?php endif;?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPagePdtPbnList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventPdtBrand['tAutStaFull'] == 1 || ($aAlwEventPdtBrand['tAutStaAdd'] == 1 || $aAlwEventPdtBrand['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickPbnSubmit();$('#obtSubmitPdtPbn').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="xCNPbnVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tPbnBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPbnBrowseOption?>')"><a>แสดงข้อมูล : <?php echo language('product/pdtbrand/pdtbrand','tPBNTitle')?></a></li>
                        <li class="active"><a><?php echo  language('product/pdtbrand/pdtbrand','tPBNTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPdtPbn').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tPbnBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPbnBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?= language('product/pdtbrand/pdtbrand','tPBNTitle')?></a></li>
                    <li class="active"><a><?= language('product/pdtbrand/pdtbrand','tPBNTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="JSxSetStatusClickPbnSubmit();$('#obtSubmitPdtPbn').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>
<?php endif;?>
<div class="xCNMenuCump xCNPbnBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPagePdtPbn"></div>
</div>
<script src="<?= base_url('application/modules/product/assets/src/pdtbrand/jPdtBrand.js')?>"></script>