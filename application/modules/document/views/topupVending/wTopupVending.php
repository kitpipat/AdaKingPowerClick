<input id="oetTFWStaBrowse" type="hidden" value="<?= $nBrowseType ?>">
<input id="oetTFWCallBackOption" type="hidden" value="<?= $tBrowseOption ?>">

<div id="odvTFWMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNTFWVMaster">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('TWXVD/0/0');?> 
                        <li id="oliTFWTitle" class="xCNLinkClick" onclick="JSvTopUpVendingCallPageList()"><?= language('document/topupVending/topupVending', 'tTitle') ?></li>
                        <li id="oliTFWTitleAdd" class="active"><a><?= language('document/topupVending/topupVending', 'tTitleAdd') ?></a></li>
                        <li id="oliTFWTitleEdit" class="active"><a><?= language('document/topupVending/topupVending', 'tTitleEdit') ?></a></li>
                        <li id="oliPITitleDetail" class="active"><a><?= language('document/purchaseinvoice/purchaseinvoice', 'tPITitleDetail'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvBtnTFWInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvTopUpVendingCallPageAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvTopUpVendingCallPageList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack') ?></button>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                                    <button id="obtTFWVDPrint" onclick="JSvTopUpVendingPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint') ?></button>
                                    <button id="obtTFWCancel" onclick="JSvTopUpVendingCancel(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel') ?></button>
                                    <button id="obtTFWApprove" onclick="JSvTopUpVendingApprove(false)" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove') ?></button>                                 
                                    <div class="btn-group">
                                        <button type="button" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitTopUpVending').click()"> <?php echo language('common/main/main', 'tSave') ?></button>
                                        <?php echo $vBtnSave ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNTFWVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliTFWNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious"><a><?= language('common/main/main', 'tShowData') ?> : <?= language('promotion/promotion/promotion', 'tPMTTitle') ?></a></li>
                        <li class="active"><a><?= language('common/main/main', 'tAddData') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvTFWBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitTFW').click()"><?= language('common/main/main', 'tSave') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNTFWBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageTopUpVending">
    </div>
</div>

<script>
	var tBaseURL		= '<?php echo base_url(); ?>';
	var nOptDecimalShow = '<?php echo $nOptDecimalShow; ?>';
	var nOptDecimalSave = '<?php echo $nOptDecimalSave; ?>';
	var nLangEdits		= '<?php echo $this->session->userdata("tLangEdit"); ?>';
	var tUsrApv			= '<?php echo $this->session->userdata("tSesUsername"); ?>';
</script>

<?php include "script/jTopupVending.php"; ?>
