<input id="oetTVOStaBrowse" type="hidden" value="<?= $nBrowseType ?>">
<input id="oetTVOCallBackOption" type="hidden" value="<?= $tBrowseOption ?>">

<div id="odvTVOMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNTVOVMaster">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('TVO/0/0');?> 
                        <li id="oliTVOTitle" class="xCNLinkClick" onclick="JSxTVOPageList()"><?= language('document/TransferVendingOut/TransferVendingOut', 'tTitle') ?></li>
                        <li id="oliTVOTitleAdd" class="active"><a><?= language('document/TransferVendingOut/TransferVendingOut', 'tTitleAdd') ?></a></li>
                        <li id="oliTVOTitleEdit" class="active"><a><?= language('document/TransferVendingOut/TransferVendingOut', 'tTitleEdit') ?></a></li>
                        <li id="oliPITitleDetail" class="active"><a><?= language('document/purchaseinvoice/purchaseinvoice', 'tPITitleDetail'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvBtnTVOInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxTVOPageAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSxTVOPageList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack') ?></button>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                                    <button id="obtTVOVDPrint" onclick="JSxTVOPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint') ?></button>
                                    <button id="obtTVOCancel" onclick="JSvTVOCancel(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel') ?></button>
                                    <button id="obtTVOApprove" onclick="JSvTVOApprove(false)" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove') ?></button>                                 
                                    <div class="btn-group">
                                        <button type="button" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitTVO').click()"> <?php echo language('common/main/main', 'tSave') ?></button>
                                        <?php echo $vBtnSave ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNTVOVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliTVONavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious"><a><?= language('common/main/main', 'tShowData') ?> : <?= language('promotion/promotion/promotion', 'tPMTTitle') ?></a></li>
                        <li class="active"><a><?= language('common/main/main', 'tAddData') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvTVOBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitTVO').click()"><?= language('common/main/main', 'tSave') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNTVOBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvTVOContentPage">
    </div>
</div>

<script>
	var tBaseURL		= '<?php echo base_url(); ?>';
	var nOptDecimalShow = '<?php echo $nOptDecimalShow; ?>';
	var nOptDecimalSave = '<?php echo $nOptDecimalSave; ?>';
	var nLangEdits		= '<?php echo $this->session->userdata("tLangEdit"); ?>';
	var tUsrApv			= '<?php echo $this->session->userdata("tSesUsername"); ?>';
</script>

<?php include "script/jTransferVendingOut.php"; ?>
