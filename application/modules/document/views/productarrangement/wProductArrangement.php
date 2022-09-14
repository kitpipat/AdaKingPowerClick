<input id="oetPAMStaBrowse" type="hidden" value="<?php echo $nPAMBrowseType ?>">
<input id="oetPAMCallBackOption" type="hidden" value="<?php echo $tPAMBrowseOption ?>">
<input id="oetPAMJumpDocNo" type="hidden" value="<?php echo $aParams['tDocNo'] ?>">

<?php if (isset($nPAMBrowseType) && ( $nPAMBrowseType == 0 || $nPAMBrowseType == 2 ) ) : ?>
    <div id="odvPAMMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <ol id="oliPAMMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('docPAM/0/0');?>
                        <li id="oliPAMTitle" style="cursor:pointer;"><?php echo language('document/productarrangement/productarrangement', 'tPAMTitleMenu'); ?></li>
                        <li id="oliPAMTitleAdd" class="active"><a><?php echo language('document/productarrangement/productarrangement', 'tPAMTitleAdd'); ?></a></li>
                        <li id="oliPAMTitleEdit" class="active"><a><?php echo language('document/productarrangement/productarrangement', 'tPAMTitleEdit'); ?></a></li>
                        <li id="oliPAMTitleDetail" class="active"><a><?php echo language('document/productarrangement/productarrangement', 'tPAMTitleDetail'); ?></a></li>
                        <li id="oliPAMTitleAprove" class="active"><a><?php echo language('document/productarrangement/productarrangement', 'tPAMTitleAprove'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        
                        <div id="odvPAMBtnGrpAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtPAMCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaPrint'] == 1)): ?>
                                    <button id="obtPAMPrintDoc" onclick="JSxPAMPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                                <?php endif; ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaCancel'] == 1)): ?>
                                    <button id="obtPAMCancelDoc" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                                <?php endif; ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAppv'] == 1)): ?>
                                    <button id="obtPAMApproveDoc" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>                                  
                                <?php endif; ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)): ?>
                                    <div  id="odvPAMBtnGrpSave" class="btn-group">
                                        <button id="obtPAMSubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main', 'tSave'); ?></button>
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
    
    <div class="xCNMenuCump xCNPAMBrowseLine" id="odvMenuCump">&nbsp;</div>

    <div id="odvPAMContentPageDocument" class="main-content"></div>
    <script>
        localStorage.removeItem("oPAMAdvSearch");
    </script>
    
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahPAMBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPAMNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliPAMBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPAMTitleMenu'); ?></a></li>
                    <li class="active"><a><?php echo language('document/purchaseorder/purchaseorder', 'tPAMTitleAdd'); ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPAMBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtPAMBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/document/assets/src/productarrangement/jProductArrangement.js"></script>








