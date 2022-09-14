<input id="oetRSStaBrowse" type="hidden" value="<?php echo $nRSBrowseType ?>">
<input id="oetRSCallBackOption" type="hidden" value="<?php echo $tRSBrowseOption ?>">

<?php if (isset($nRSBrowseType) && $nRSBrowseType == 0) : ?>
    <div id="odvRSMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <ol id="oliRSMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('dcmRS/0/0');?>
                        <li id="oliRSTitle" style="cursor:pointer;"><?php echo language('document/returnsale/returnsale', 'tRSTitleMenu'); ?></li>
                        <li id="oliRSTitleAdd" class="active"><a><?php echo language('document/returnsale/returnsale', 'tRSTitleAdd'); ?></a></li>
                        <li id="oliRSTitleEdit" class="active"><a><?php echo language('document/returnsale/returnsale', 'tRSTitleEdit'); ?></a></li>
                        <li id="oliRSTitleDetail" class="active"><a><?php echo language('document/returnsale/returnsale', 'tRSTitleDetail'); ?></a></li>
                        <li id="oliRSTitleAprove" class="active"><a><?php echo language('document/returnsale/returnsale', 'tRSTitleAprove'); ?></a></li>
                        <li id="oliRSTitleConimg" class="active"><a><?php echo language('document/returnsale/returnsale', 'tRSTitleConimg'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvRSBtnGrpInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button id="obtRSCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvRSBtnGrpAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtRSCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)): ?>
                                    <!-- <button id="obtRSPrintDoc" onclick="JSxRSPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button> -->
                                    <button id="obtRSCancelDoc" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                                    <button id="obtRSApproveDoc" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>                                  
                                    <div  id="odvRSBtnGrpSave" class="btn-group">
                                        <button id="obtRSSubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main', 'tSave'); ?></button>
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
    <div class="xCNMenuCump xCNRSBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvRSContentPageDocument">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahRSBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliRSNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliRSBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('document/purchaseinvoice/purchaseinvoice', 'tRSTitleMenu'); ?></a></li>
                    <li class="active"><a><?php echo language('document/returnsale/saleorder', 'tRSTitleAdd'); ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvRSBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtRSBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/document/assets/src/returnsale/jReturnSale.js"></script>








