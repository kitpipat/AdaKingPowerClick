<input id="oetPTUStaBrowse" type="hidden" value="<?= $nBrowseType ?>">
<input id="oetPTUCallBackOption" type="hidden" value="<?= $tBrowseOption ?>">

<div id="odvPTUMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNPTUVMaster">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('docPTU/0/0'); ?> 
                        <li id="oliPTUTitle" class="xCNLinkClick" onclick="JSvPTUCallPageList()"><?= language('sale/promotiontopup/promotiontopup', 'tTitle') ?></li>
                        <li id="oliPTUTitleAdd" class="active"><a><?= language('sale/promotiontopup/promotiontopup', 'tTitleAdd') ?></a></li>
                        <li id="oliPTUTitleEdit" class="active"><a><?= language('sale/promotiontopup/promotiontopup', 'tTitleEdit') ?></a></li>
                        <li id="oliPTUTitleDetail" class="active"><a><?= language('sale/promotiontopup/promotiontopup', 'tPITitleDetail'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvPTUBtnInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvPTUCallPageAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvPTUCallPageList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack') ?></button>
                                <?php if ($aAlwEvent["tAutStaFull"] == "1" || $aAlwEvent["tAutStaPrint"] == "1") : ?>
                                    <button type="button" id="obtPTUPrint" class="btn xCNBTNDefult xCNBTNDefult2Btn" onclick="JSxPTUPrintDoc()"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                                <?php endif; ?>
                                <?php if ($aAlwEvent["tAutStaFull"] == "1" || $aAlwEvent["tAutStaCancel"] == "1") : ?>
                                    <button id="obtPTUCancel" onclick="JSvPTUCancel(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel') ?></button>
                                <?php endif; ?>
                                <?php if ($aAlwEvent["tAutStaFull"] == "1" || $aAlwEvent["tAutStaAppv"] == "1") : ?>
                                    <button id="obtPTUApprove" onclick="JSvPTUApprove(false)" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove') ?></button>                                 
                                <?php endif; ?>
                                <?php if ($aAlwEvent["tAutStaFull"] == "1" || $aAlwEvent["tAutStaAdd"] || $aAlwEvent["tAutStaEdit"]) : ?>
                                    <div class="btn-group" id="odvShwBtnSave">
                                        <button type="button" class="btn xWBtnGrpSaveLeft" onclick="$('#obtPTUSubmit').click()"> <?php echo language('common/main/main', 'tSave') ?></button>
                                        <?php echo $vBtnSave ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNPTUVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliPTUNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious"><a><?= language('common/main/main', 'tShowData') ?> : <?= language('promotion/promotion/promotion', 'tPMTTitle') ?></a></li>
                        <li class="active"><a><?= language('common/main/main', 'tAddData') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPTUBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtPTUSubmit').click()"><?= language('common/main/main', 'tSave') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="xCNMenuCump xCNPTUBrowseLine" id="odvMenuCump">&nbsp;</div>

<div class="main-content">
    <div id="odvPTUContentPage">
    </div>
</div>

<script>
	var tBaseURL		= '<?php echo base_url(); ?>';
	var nOptDecimalShow = '<?php echo $nOptDecimalShow; ?>';
	var nOptDecimalSave = '<?php echo $nOptDecimalSave; ?>';
	var nLangEdits		= '<?php echo $this->session->userdata("tLangEdit"); ?>';
	var tUsrApv			= '<?php echo $this->session->userdata("tSesUsername"); ?>';
</script>

<?php include "script/jPromotionTopup.php"; ?>
