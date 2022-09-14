<input id="oetStyStaBrowse" type="hidden" value="<?=$nStyBrowseType?>">
<input id="oetStyCallBackOption" type="hidden" value="<?=$tStyBrowseOption?>">

<?php if (isset($nStyBrowseType) && $nStyBrowseType == 0) : ?>
<div id="odvStyMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNStyVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('suppliertype/0/0');?> 
                        <li id="oliStyTitle" class="xCNLinkClick" onclick="JSvCallPageStyList()" style="cursor:pointer"><?= language('supplier/suppliertype/suppliertype','tSTYTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliStyTitleAdd" class="active"><a><?= language('supplier/suppliertype/suppliertype','tSTYTitleAdd')?></a></li>
                        <li id="oliStyTitleEdit" class="active"><a><?= language('supplier/suppliertype/suppliertype','tSTYTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnStyInfo">
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageStyAdd()">+</button>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPageStyList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitSty').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNStyVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tStyBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tStyBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('supplier/suppliertype/suppliertype','tSTYTitle')?></a></li>
                        <li class="active"><a><?php echo  language('supplier/suppliertype/suppliertype','tSTYTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitSty').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNStyBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageSty"></div>
</div>
<?php else : ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tStyBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                    <i class="fa fa-arrow-left xCNIcon"></i>
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tStyBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('supplier/suppliertype/suppliertype', 'tSTYTitle') ?></a></li>
                    <li class="active"><a><?php echo  language('supplier/groupsupplier/groupsupplier', 'tSGPTitleAdd') ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitSty').click()"><?php echo language('common/main/main', 'tSave') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div id="odvContentPageSty"></div>
    </div>
<?php endif; ?>

<script src="<?php echo base_url('application/modules/supplier/assets/src/suppliertype/jSupplierType.js')?>"></script>
