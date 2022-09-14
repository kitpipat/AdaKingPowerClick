<input id="oetPtyStaBrowse" type="hidden" value="<?=$nPtyBrowseType?>">
<input id="oetPtyCallBackOption" type="hidden" value="<?=$tPtyBrowseOption?>">

<?php if(isset($nPtyBrowseType) && $nPtyBrowseType == 0) : ?>
<div id="odvPtyMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNPtyVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('pdttype/0/0');?> 
                        <li id="oliPtyTitle" class="xCNLinkClick" onclick="JSvCallPagePdtTypeList()" style="cursor:pointer"><?= language('product/pdttype/pdttype','tPTYTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliPtyTitleAdd" class="active"><a><?= language('product/pdttype/pdttype','tPTYTitleAdd')?></a></li>
                        <li id="oliPtyTitleEdit" class="active"><a><?= language('product/pdttype/pdttype','tPTYTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnPtyInfo">
                        <?php if($aAlwEventPdtType['tAutStaFull'] == 1 || $aAlwEventPdtType['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtTypeAdd()">+</button>
                        <?php endif; ?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPagePdtTypeList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventPdtType['tAutStaFull'] == 1 || ($aAlwEventPdtType['tAutStaAdd'] == 1 || $aAlwEventPdtType['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickPdtTypeSubmit();$('#obtSubmitPdtType').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="xCNPtyVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tPtyBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPtyBrowseOption?>')"><a><?= language('common/main/main', 'tShowData')?> : <?php echo language('product/pdttype/pdttype','tPTYTitle')?></a></li>
                        <li class="active"><a><?php echo  language('product/pdttype/pdttype','tPTYTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPdtType').click()"><?php echo  language('common/main/main', 'tSave')?></button>
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
                <a onclick="JCNxBrowseData('<?php echo $tPtyBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPtyBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?= language('product/pdttype/pdttype','tPTYTitle')?></a></li>
                    <li class="active"><a><?= language('product/pdttype/pdttype','tPTYTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="JSxSetStatusClickPdtTypeSubmit();$('#obtSubmitPdtType').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>
<?php endif;?>
<div class="xCNMenuCump xCNPtyBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPagePdtType"></div>
</div>
<script src="<?= base_url('application/modules/product/assets/src/pdttype/jPdtType.js')?>"></script>