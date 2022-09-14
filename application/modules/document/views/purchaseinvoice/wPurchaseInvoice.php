<input id="oetPIStaBrowse" type="hidden" value="<?php echo $nPIBrowseType ?>">
<input id="oetPICallBackOption" type="hidden" value="<?php echo $tPIBrowseOption ?>">

<?php if (isset($nPIBrowseType) && $nPIBrowseType == 0) : ?>
    <div id="odvPIMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <ol id="oliPIMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('dcmPI/0/0');?>
                        <li id="oliPITitle" style="cursor:pointer;"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITitleMenu'); ?></li>
                        <li id="oliPITitleAdd" class="active"><a><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITitleAdd'); ?></a></li>
                        <li id="oliPITitleEdit" class="active"><a><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITitleEdit'); ?></a></li>
                        <li id="oliPITitleDetail" class="active"><a><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITitleDetail'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvPIBtnGrpInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button id="obtPICallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvPIBtnGrpAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtPICallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)): ?>
                                   
                                    <button id="obtPIPrintDoc" onclick="JSxPIPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                                    <button id="obtPICancelDoc" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                                    <button id="obtPIApproveDoc" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>                                  
                                    <div  id="odvPIBtnGrpSave" class="btn-group">
                                        <button id="obtPISubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main', 'tSave'); ?></button>
                                        <?php echo $vBtnSave ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNPIBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvPIContentPageDocument">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahPIBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPINavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliPIBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITitleMenu'); ?></a></li>
                    <li class="active"><a><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITitleAdd'); ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPIBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtPIBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/document/assets/src/purchaseinvoice/jpurchaseinvoice.js"></script>








