<input id="oetSlvStaBrowse" type="hidden" value="<?=$nSlvBrowseType?>">
<input id="oetSlvCallBackOption" type="hidden" value="<?=$tSlvBrowseOption?>">

<?php if (isset($nSlvBrowseType) && $nSlvBrowseType == 0) : ?>
<div id="odvSlvMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNSlvVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> 
                        <?php FCNxHADDfavorite('supplierlev/0/0');?> 
                        <li id="oliSlvTitle" class="xCNLinkClick" onclick="JSvCallPageSupplierLevelList()" style="cursor:pointer"><?= language('supplier/supplierlev/supplierlev','tSLVTitle')?></li> 
                        <li id="oliSlvTitleAdd" class="active"><a><?= language('supplier/supplierlev/supplierlev','tSLVTitleAdd')?></a></li>
                        <li id="oliSlvTitleEdit" class="active"><a><?= language('supplier/supplierlev/supplierlev','tSLVTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> 
                    <div id="odvBtnSlvInfo">
                        <?php if($aAlwEventSupplierLevel['tAutStaFull'] == 1 || $aAlwEventSupplierLevel['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageSupplierLevelAdd()">+</button>
                        <?php endif; ?>
                    </div>
                    <div id="odvBtnAddEdit">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <button onclick="JSvCallPageSupplierLevelList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventSupplierLevel['tAutStaFull'] == 1 || ($aAlwEventSupplierLevel['tAutStaAdd'] == 1 || $aAlwEventSupplierLevel['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitSupplierLevel').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNSlvVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tSlvBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSlvBrowseOption?>')"><a>แสดงข้อมูล : <?php echo language('supplier/supplierlev/supplierlev','tSLVTitle')?></a></li>
                        <li class="active"><a><?php echo  language('supplier/supplierlev/supplierlev','tSLVTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitSupplierLevel').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNSlvBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageSupplierLevel"></div>
</div>
<?php else : ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tSlvBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                    <i class="fa fa-arrow-left xCNIcon"></i>
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSlvBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('supplier/groupsupplier/groupsupplier', 'tSLVTitle') ?></a></li>
                    <li class="active"><a><?php echo  language('supplier/groupsupplier/groupsupplier', 'tSLVTitleAdd') ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitSupplierLevel').click()"><?php echo language('common/main/main', 'tSave') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div id="odvContentPageSupplierLevel"></div>
    </div>
<?php endif; ?>
<script src="<?= base_url('application/modules/supplier/assets/src/supplierlev/jSupplierLev.js')?>"></script>