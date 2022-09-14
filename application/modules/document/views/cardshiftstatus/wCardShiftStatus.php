<input id="oetCardShiftStatusStaBrowse" type="hidden" value="<?= $nCardShiftStatusBrowseType ?>">
<input id="oetCardShiftStatusCallBackOption" type="hidden" value="<?= $tCardShiftStatusBrowseOption ?>">

<div id="odvCardShiftStatusMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="xCNavRow" style="width:inherit;">

            <div class="xCNCardShiftStatusVMaster row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('cardShiftStatus/0/0');?>
                        <li id="oliCardShiftStatusTitle" class="xCNLinkClick" onclick="JSvCardShiftStatusCallPageCardShiftStatus('')"><?= language('document/card/cardstatus', 'tCardShiftStatusTitle') ?></li>
                        <li id="oliCardShiftStatusTitleAdd" class="active"><a href="javascrip:;"><?= language('document/card/cardstatus', 'tCardShiftStatusTitleAdd') ?></a></li>
                        <li id="oliCardShiftStatusTitleEdit" class="active"><a href="javascrip:;"><?= language('document/card/cardstatus', 'tCardShiftStatusTitleEdit') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] == "1") : ?>
                            <div id="odvBtnCardShiftStatusInfo">
                                <button id="obtCardShiftStatusAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCardShiftStatusCallPageCardShiftStatusAdd()">+</button>
                            </div>
                        <?php endif; ?>
                        <div id="odvBtnAddEdit">
                            <button onclick="JSvCardShiftStatusCallPageCardShiftStatus()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaPrint"] == "1") : ?>
                                <button type="button" id="obtCardShiftStatusBtnDocMa" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" onclick="JSxCardShiftStatusPrint()"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaCancel"] == "1") : ?>
                                <button id="obtCardShiftStatusBtnCancelApv" onclick="JSxCardShiftStatusStaDoc(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAppv"] == "1") : ?>
                                <button id="obtCardShiftStatusBtnApv" onclick="JSxCardShiftStatusStaApvDoc(false)" class="btn xCNBTNPrimery xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] || $aPermission["tAutStaEdit"]) : ?>
                                <button type="button" id="obtCardShiftStatusBtnSave" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="$('#obtSubmitCardShiftStatusMainForm').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>								
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xCNCardShiftStatusVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?= $tCardShiftStatusBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliCardShiftStatusNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?= $tCardShiftStatusBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?= language('document/card/cardstatus', 'tCardShiftStatusTitle') ?></a></li>
                        <li class="active"><a><?= language('document/card/cardstatus', 'tCardShiftStatusTitleAdd') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvCardShiftStatusBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCardShiftStatus').click()"><?= language('common/main/main', 'tSave') ?></button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="xCNMenuCump xCNCardShiftStatusBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content" id="odvMainContent" style="background-color: #F0F4F7;">    
    <div id="odvContentPageCardShiftStatus"></div>
</div>
<script src="<?= base_url('application/modules/document/assets/src/cardshiftstatus/jCardShiftStatus.js') ?>"></script>

