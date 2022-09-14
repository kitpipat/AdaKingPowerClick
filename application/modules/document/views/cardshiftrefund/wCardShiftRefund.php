<input id="oetCardShiftRefundStaBrowse" type="hidden" value="<?= $nCardShiftRefundBrowseType ?>">
<input id="oetCardShiftRefundCallBackOption" type="hidden" value="<?= $tCardShiftRefundBrowseOption ?>">

<div id="odvCardShiftRefundMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        
        <div class="xCNavRow" style="width:inherit;">
            <div class="xCNCardShiftRefundVMaster row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('cardShiftRefund/0/0');?>
                        <li id="oliCardShiftRefundTitle" class="xCNLinkClick" onclick="JSvCardShiftRefundCallPageCardShiftRefund('')"><?= language('document/card/cardrefund', 'tCardShiftRefundTitle') ?></li>
                        <li id="oliCardShiftRefundTitleAdd" class="active"><a href="javascrip:;"><?= language('document/card/cardrefund', 'tCardShiftRefundTitleAdd') ?></a></li>
                        <li id="oliCardShiftRefundTitleEdit" class="active"><a href="javascrip:;"><?= language('document/card/cardrefund', 'tCardShiftRefundTitleEdit') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] == "1") : ?>
                            <div id="odvBtnCardShiftRefundInfo">
                                <button id="obtCardShiftRefundAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCardShiftRefundCallPageCardShiftRefundAdd()">+</button>
                            </div>
                        <?php endif; ?>
                        <div id="odvBtnAddEdit">
                            <button onclick="JSvCardShiftRefundCallPageCardShiftRefund()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                            <?php /*if ($aPermission["tAutStaFull"] == "5" || $aPermission["tAutStaPrint"] == "5") :*/ ?>
                                <button type="button" id="obtCardShiftRefundBtnDocMa" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" onclick="JSxCardShiftRefundPrint()"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                            <?php /*endif;*/ ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaCancel"] == "1") : ?>
                                <button id="obtCardShiftRefundBtnCancelApv" onclick="JSxCardShiftRefundStaDoc(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAppv"] == "1") : ?>
                                <button id="obtCardShiftRefundBtnApv" onclick="JSxCardShiftRefundStaApvDoc(false)" class="btn xCNBTNPrimery xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] || $aPermission["tAutStaEdit"]) : ?>
                                <button type="button" id="obtCardShiftRefundBtnSave" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="$('#obtSubmitCardShiftRefundMainForm').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>								
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xCNCardShiftRefundVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?= $tCardShiftRefundBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliCardShiftRefundNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?= $tCardShiftRefundBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?= language('document/card/cardrefund', 'tCardShiftRefundTitle') ?></a></li>
                        <li class="active"><a><?= language('document/card/cardrefund', 'tCardShiftRefundTitleAdd') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvCardShiftRefundBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCardShiftRefund').click()"><?= language('common/main/main', 'tSave') ?></button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="xCNMenuCump xCNCardShiftRefundBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content" id="odvMainContent" style="background-color: #F0F4F7;">    
    <div id="odvContentPageCardShiftRefund"></div>
</div>
<script src="<?php echo base_url('application/modules/document/assets/src/cardshiftrefund/jCardShiftRefund.js'); ?>"></script>


