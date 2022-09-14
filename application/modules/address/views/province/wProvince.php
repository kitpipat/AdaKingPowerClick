<input id="oetPvnStaBrowse" type="hidden" value="<?php echo $nPvnBrowseType?>">
<input id="oetPvnCallBackOption" type="hidden" value="<?php echo $tPvnBrowseOption?>">

<?php if(isset($nPvnBrowseType) && $nPvnBrowseType == 0) : ?>
    <div id="odvPvnMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li id="oliPvnTitle" class="xCNLinkClick" onclick="JSvCallPageProvinceList()" style="cursor:pointer"><?php echo language('address/province/province','tPVNTitle')?></li>
                        <li id="oliPvnTitleAdd" class="active"><a><?php echo language('address/province/province','tPVNTitleAdd')?></a></li>
                        <li id="oliPvnTitleEdit" class="active"><a><?php echo language('address/province/province','tPVNTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div id="odvBtnPvnInfo">
                        <?php if($aAlwEventProvince['tAutStaFull'] == 1 || $aAlwEventProvince['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageProvinceAdd()">+</button>
                        <?php endif; ?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <button onclick="JSvCallPageProvinceList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo  language('common/main/main', 'tBack')?></button>
                        <?php if($aAlwEventProvince['tAutStaFull'] == 1 || ($aAlwEventProvince['tAutStaAdd'] == 1 || $aAlwEventProvince['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
                                <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitProvince').click()"> <?php echo  language('common/main/main', 'tSave')?></button>
                                <?php echo $vBtnSave?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <div class="xCNMenuCump xCNPvnBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageProvince" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tPvnBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPvnBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('address/province/province','tPVNTitle')?></a></li>
                    <li class="active"><a><?php echo  language('address/province/province','tPVNTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitProvince').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body">
    </div>
<?php endif;?>
<script src="<?php echo  base_url('application/modules/address/assets/src/province/jProvince.js')?>"></script>
