<input type="hidden" id="oetCBNStaBrowse" value="<?php echo $nCBNBrowseType;?>">
<input type="hidden" id="oetCBNStaBrowseOption" value="<?php echo $tCBNBrowseOption;?>">


<?php if(isset($nCBNBrowseType) && $nCBNBrowseType == 0):?>
<div id="odvCBNMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                    <?php FCNxHADDfavorite('CabinetType/0/0');?> 
                    <li id="oliCBNTitle" class="xCNLinkClick" onclick="JSvCallPageCabinetTypeList()" style="cursor:pointer"><?php echo language('vending/cabinettype/cabinettype','tCBNTitle')?></li> <!-- เปลี่ยน -->
                    <li id="oliCBNTitleAdd" class="active"><a><?php echo language('vending/cabinettype/cabinettype','tCBNTitleAdd')?></a></li>
                    <li id="oliCBNTitleEdit" class="active"><a><?php echo language('vending/cabinettype/cabinettype','tCBNTitleEdit')?></a></li>
                </ol>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0"> <!-- เปลี่ยน -->
                <div id="odvBtnCBNInfo">
                    <?php if($aAlwEventCabinetType['tAutStaFull'] == 1 || $aAlwEventCabinetType['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCabinetTypeAdd()">+</button>
                    <?php endif; ?>
                </div>
                <div id="odvBtnAddEdit">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button onclick="JSvCallPageCabinetTypeList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                    <?php if($aAlwEventCabinetType['tAutStaFull'] == 1 || ($aAlwEventCabinetType['tAutStaAdd'] == 1 || $aAlwEventCabinetType['tAutStaEdit'] == 1)) : ?>
                        <div class="btn-group">
                            <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCabinetType').click()"> <?php echo language('common/main/main', 'tSave')?></button>
                            <?php echo $vBtnSave?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNCBNBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageCabinetType" class="panel panel-headline">
    </div>
</div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tCBNBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliCBNNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCBNBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('vending/cabinettype/cabinettype','tCBNTitle')?></a></li>
                    <li class="active"><a><?php echo language('vending/cabinettype/cabinettype','tCBNTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvCBNBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCabinetType').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>

<script src="<?= base_url('application/modules/vending/assets/src/cabinettype/jCabinetType.js')?>"></script>