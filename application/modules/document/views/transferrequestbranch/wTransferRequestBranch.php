<input id="oetTRBStaBrowse" type="hidden" value="<?php echo $nTRBBrowseType ?>">
<input id="oetTRBCallBackOption" type="hidden" value="<?php echo $tTRBBrowseOption ?>">
<input id="oetTRBJumpDocNo" type="hidden" value="<?php echo $aParams['tDocNo'] ?>">
<input id="oetTRBJumpBchCode" type="hidden" value="<?php echo $aParams['tBchCode'] ?>">
<input id="oetTRBJumpAgnCode" type="hidden" value="<?php echo $aParams['tAgnCode'] ?>">
<?php if (isset($nTRBBrowseType) && ( $nTRBBrowseType == 0 || $nTRBBrowseType ==2)) : ?>
    <div id="odvTRBMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <ol id="oliTRBMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('docTRB/0/0');?>
                        <li id="oliTRBTitle" style="cursor:pointer;"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBTitleMenu'); ?></li>
                        <li id="oliTRBTitleAdd" class="active"><a><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBTitleAdd'); ?></a></li>
                        <li id="oliTRBTitleEdit" class="active"><a><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBTitleEdit'); ?></a></li>
                        <li id="oliTRBTitleDetail" class="active"><a><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBTitleDetail'); ?></a></li>
                        <li id="oliTRBTitleAprove" class="active"><a><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBTitleAprove'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvTRBBtnGrpInfo">
                            <?php //if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button id="obtTRBCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                            <?php //endif; ?>
                        </div>
                        <div id="odvTRBBtnGrpAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtTRBCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                                <?php //if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)): ?>
                                    <button id="obtTRBPrintDoc" onclick="JSxTRBPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                                    <button id="obtTRBCancelDoc" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                                    <button id="obtTRBApproveDoc" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>                                  
                                    <div  id="odvTRBBtnGrpSave" class="btn-group">
                                        <button id="obtTRBSubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main', 'tSave'); ?></button>
                                        <?php echo $vBtnSave ?>
                                    </div>
                                <?php //endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNTRBBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvTRBContentPageDocument">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahTRBBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliTRBNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliTRBBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('document/purchaseinvoice/purchaseinvoice', 'tDOTitleMenu'); ?></a></li>
                    <li class="active"><a><?php echo language('document/purchaseorder/purchaseorder', 'tDOTitleAdd'); ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvTRBBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtTRBBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<?php include('script/jTransferReqeustBranch.php')?>








