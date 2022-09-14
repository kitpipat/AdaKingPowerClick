<input id="oetCatStaBrowse" type="hidden" value="<?php echo $nCatBrowseType?>">
<input id="oetCatCallBackOption" type="hidden" value="<?php echo $tCatBrowseOption?>">
<input id="oetCatCat" type="hidden" value="<?php echo $tCatCat?>">
<?php $aCatBrowseType = array('0' => 1,'1' => 2,'2' => 3,'3' => 4,'4' => 5); ?>
<?php if(isset($nCatBrowseType) && $nCatBrowseType == 0) : ?>
	<div id="odvCatMenuTitle" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <?php FCNxHADDfavorite('pdtunit/0/0');?>
                            <li id="oliCatTitle" class="xCNLinkClick" onclick="JSvCallPagePdtCatList()" style="cursor:pointer"><?php echo language('product/pdtcat/pdtcat','tCATTitle')?> <?php echo $aCatBrowseType[$tCatCat] ; ?></li>
                            <li id="oliCatTitleAdd" class="active"><a><?php echo language('product/pdtcat/pdtcat','tCATTitleAdd')?> <?php echo $aCatBrowseType[$tCatCat] ; ?></a></li>
                            <li id="oliCatTitleEdit" class="active"><a><?php echo language('product/pdtcat/pdtcat','tCATTitleEdit')?> <?php echo $aCatBrowseType[$tCatCat] ; ?></a></li>
                        </ol>
					</div>
                        <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <div id="odvBtnCatInfo">
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtCatAdd()">+</button>
                        </div>
                        <div id="odvBtnAddEdit" style="margin-top:3px">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvCallPagePdtCatList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>

                                <div class="btn-group">
                                    <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickPdtCatSubmit();$('#obtSubmitPdtCat').click();"> <?php echo language('common/main/main', 'tSave')?></button>
                                    <?php echo $vBtnSave?>
                                </div>


                            </div>
                        </div>
                    </div>
					</div>
				</div>
			</div>
		</div>
	<div class="xCNMenuCump xCNPtyBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPagePdtCat" class="panel panel-headline"></div>
	</div>
	<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
    <?php else: ?>
        <div class="modal-header xCNModalHead">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <a onclick="JCNxBrowseData('<?php echo $tCatBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                        <i class="fa fa-arrow-left xCNIcon"></i>
                    </a>
                    <ol id="oliCatNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCatBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('product/pdtcat/pdtcat','tCATTitle')?></a></li>
                        <li class="active"><a><?php echo language('product/pdtcat/pdtcat','tCATTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <div id="odvCatBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="JSxSetStatusClickPdtCatSubmit();$('#obtSubmitPdtCat').click();"><?php echo language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
</div>
<?php endif;?>
<script src="<?php echo  base_url('application/modules/product/assets/src/pdtcat/jPdtCat.js')?>"></script>
