<input id="oetCPHStaBrowseType"     type="hidden" value="<?php echo @$nCPHBrowseType;?>">
<input id="oetCPHCallBackOption"    type="hidden" value="<?php echo @$tCPHBrowseOption;?>">

<?php if (isset($nCPHBrowseType) && $nCPHBrowseType == 0): ?>
    <div id="odvCPHMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <ol id="oliCPHMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('dcmCouponSetup/0/0');?>
                        <li id="oliCPHTitle" style="cursor:pointer;"><?php echo language('document/couponsetup/couponsetup','tCPHTitleMenu');?></li>
                        <li id="oliCPHTitleAdd" class="active"><a><?php echo language('document/couponsetup/couponsetup','tCPHTitleAdd'); ?></a></li>
                        <li id="oliCPHTitleEdit" class="active"><a><?php echo language('document/couponsetup/couponsetup','tCPHTitleEdit'); ?></a></li>
                        <li id="oliCPHTitleDetail" class="active"><a><?php echo language('document/couponsetup/couponsetup','tCPHTitleDetail'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvCPHBtnGrpInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button id="obtCPHCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvCPHBtnGrpAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtCPHCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)): ?>
                                    <button id="obtCPHPrint" onclick="JSvCPHPrintDoc();" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tCMNPrint')?></button>
                                    <button id="obtCPHCancelDoc" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                                    <button id="obtCPHApproveDoc" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button> 
                                    <div  id="odvCPHBtnGrpSave"     class="btn-group">
                                        <button id="obtCPHSubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main', 'tSave'); ?></button>
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
    <div class="xCNMenuCump xCNCPHBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvCPHContentPageDocument">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahCPHBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliCPHNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliCPHBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('document/couponsetup/couponsetup','tCPHTitleMenu');?></a></li>
                    <li class="active"><a><?php echo language('document/couponsetup/couponsetup','tCPHTitleAdd');?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvCPHBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtCPHBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/document/assets/src/couponsetup/jCouponSetup.js"></script>