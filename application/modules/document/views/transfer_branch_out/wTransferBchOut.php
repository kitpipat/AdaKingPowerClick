<input id="oetTransferBchOutStaBrowse" type="hidden" value="<?= $nBrowseType ?>">
<input id="oetTransferBchOutCallBackOption" type="hidden" value="<?= $tBrowseOption ?>">
<input id="oetTransferBchOutJumpDocNo" type="hidden" value="<?php echo $aParams['tDocNo'] ?>">
<input id="oetTransferBchOutJumpBchCode" type="hidden" value="<?php echo $aParams['tBchCode'] ?>">
<input id="oetTransferBchOutJumpAgnCode" type="hidden" value="<?php echo $aParams['tAgnCode'] ?>">
<div id="odvTransferBchOutMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNTransferBchOutVMaster">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('deposit/0/0');?> 
                        <li id="oliTransferBchOutTitle" class="xCNLinkClick"><?= language('document/transfer_branch_out/transfer_branch_out', 'tTitle') ?></li>
                        <li id="oliTransferBchOutTitleAdd" class="active"><a><?= language('document/transfer_branch_out/transfer_branch_out', 'tTitleAdd') ?></a></li>
                        <li id="oliTransferBchOutTitleEdit" class="active"><a><?= language('document/transfer_branch_out/transfer_branch_out', 'tTitleEdit') ?></a></li>
                        <li id="oliTransferBchOutTitleDetail" class="active"><a><?= language('document/purchaseinvoice/purchaseinvoice', 'tPITitleDetail'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvTransferBchOutBtnInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvTransferBchOutCallPageAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvTransferBchOutCallPageList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack') ?></button>

                                
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                                    <button id="obtTBOGenPacking" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('document/transfer_branch_out/transfer_branch_out', 'tTBOBtnGenPacking') ?></button>
                                <?php endif; ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaPrint'] == 1)) : ?>
                                    <button id="obtTransferBchOutPrint" onclick="JSxTransferBchOutPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint') ?></button>
                                <?php endif; ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaCancel'] == 1)) : ?>
                                    <button id="obtTBOCancelOnApv" onclick="JSxTBOCancelOnApv(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn xCNHide" type="button"> <?php echo language('common/main/main', 'tCancel') ?></button>
                                    <button id="obtTransferBchOutCancel" onclick="JSvTransferBchOutCancel(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel') ?></button>
                                <?php endif; ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAppv'] == 1)) : ?>
                                    <button id="obtTransferBchOutApprove" onclick="JSxTBOChkPdtB4Apv(false)" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove') ?></button>                                 
                                <?php endif; ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                                    <div id="odvTBOBtnGrpSave" class="btn-group">
                                        <button type="button" class="btn xWBtnGrpSaveLeft" onclick="$('#obtTransferBchOutSubmit').click()"> <?php echo language('common/main/main', 'tSave') ?></button>
                                        <?php echo $vBtnSave ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNTransferBchOutVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliTransferBchOutNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious"><a><?= language('common/main/main', 'tShowData') ?> : <?= language('promotion/promotion/promotion', 'tPMTTitle') ?></a></li>
                        <li class="active"><a><?= language('common/main/main', 'tAddData') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvTransferBchOutBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtTransferBchOutSubmit').click()"><?= language('common/main/main', 'tSave') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="xCNMenuCump xCNTransferBchOutBrowseLine" id="odvMenuCump">&nbsp;</div>

<div class="main-content">
    <div id="odvTransferBchOutContentPage"></div>
</div>

<script>
	var tBaseURL		= '<?php echo base_url(); ?>';
	var nOptDecimalShow = '<?php echo $nOptDecimalShow; ?>';
	var nOptDecimalSave = '<?php echo $nOptDecimalSave; ?>';
	var nLangEdits		= '<?php echo $this->session->userdata("tLangEdit"); ?>';
	var tUsrApv			= '<?php echo $this->session->userdata("tSesUsername"); ?>';
</script>

<?php include "script/jTransferBchOut.php"; ?>
