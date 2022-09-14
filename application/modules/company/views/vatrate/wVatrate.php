<input id="oetVatStaBrowse" type="hidden" value="<?php echo $nVatBrowseType; ?>">
<input id="oetVatCallBackOption" type="hidden" value="<?php echo $tVatBrowseOption; ?>">

<?php 
// echo '<pre>';
// echo print_r($aAlwEventVatrate); 
// echo '</pre>';
?>

<?php if(isset($nVatBrowseType) && $nVatBrowseType == 0) : ?>
    <div id="odvVatMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">

                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb xCNBCMenu">
                        <?php FCNxHADDfavorite('vatrate/0/0');?> 
                        <li id="oliVatTitle" class="xCNLinkClick" onclick="JSvCallPageVatrateList()"><?php echo language('company/vatrate/vatrate', 'tVATTitle'); ?></li>
                        <li id="oliVatTitleAdd" class="active"><a><?php echo language('company/vatrate/vatrate', 'tVATTitleAdd'); ?></a></li>
                        <li id="oliVatTitleEdit" class="active"><a><?php echo language('company/vatrate/vatrate', 'tVATTitleEdit'); ?></a></li>
                        <li id="oliVatTitleManage" class="active"><a><?php echo language('company/vatrate/vatrate', 'tVATTitleManage'); ?></a></li>
                    </ol>
                </div>

                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div id="odvBtnVatInfo">
                        <?php if ($aAlwEventVatrate['tAutStaFull'] == 1 || ($aAlwEventVatrate['tAutStaAdd'] == 1 || $aAlwEventVatrate['tAutStaEdit'] == 1)) : ?>
                            <button id="obtVatrateAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageVatrateAdd()" title="<?php echo language('common/main/main', 'tAdd'); ?>">+</button>
                        <?php endif; ?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <button onclick="JSvCallPageVatrateList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                        <?php if ($aAlwEventVatrate['tAutStaFull'] == 1 || ($aAlwEventVatrate['tAutStaAdd'] == 1 || $aAlwEventVatrate['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
                                <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSaveVatRate').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>
                                <?php echo $vBtnSave; ?>
                            <?php endif; ?>	
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNCrdBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageVatrate" class="panel panel-headline"></div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tVatBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tVatBrowseOption; ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('pos5/province', 'tVATTitle'); ?></a></li>
                    <li class="active"><a><?php echo language('pos5/province', 'tVATTitleAdd'); ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtAddEditVatRate').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>
<?php endif;?>

<script src="<?php echo base_url('application/modules/company/assets/src/vatrate/jVatrate.js'); ?>"></script>

