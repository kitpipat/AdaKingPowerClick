<input id="oetTBStaBrowse" type="hidden" value="<?= $nBrowseType ?>">
<input id="oetTBCallBackOption" type="hidden" value="<?= $tBrowseOption ?>">
<input id="oetTBUsrLevel" type="hidden" value="<?php echo $this->session->userdata("tSesUsrLevel"); ?>">

<div id="odvTBMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="xCNavRow" style="width:inherit;">

            <div class="row xCNTBVMaster">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('TBX/0/0');?>
                        <li id="oliTBTitle" class="xCNLinkClick" onclick="JSvCallPageTBList()"><?= language('document/producttransferbranch/producttransferbranch', 'tTBTitle') ?></li>
                        <li id="oliTBTitleAdd" class="active"><a><?= language('document/producttransferbranch/producttransferbranch', 'tTBTitleAdd') ?></a></li>
                        <li id="oliTBTitleEdit" class="active"><a><?= language('document/producttransferbranch/producttransferbranch', 'tTBTitleEdit') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvBtnTBInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageTBAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvCallPageTBList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack') ?></button>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                                    <button id="obtTFBchPrint" onclick="JSxTBBchPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint') ?></button>
                                    <button id="obtTBCancel" onclick="JSnTBCancel(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel') ?></button>
                                    <button id="obtTBApprove" onclick="JSxSetStatusClickTBSubmit(2);JSnTBApprove(false)" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove') ?></button>                                   
                                    <div class="btn-group">
                                        <button type="button" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickTBSubmit(1);$('#obtSubmitTB').click()"> <?php echo language('common/main/main', 'tSave') ?></button>
                                        <?php echo $vBtnSave ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNTBVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliTBNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious"><a><?= language('common/main/main', 'tShowData') ?> : <?= language('promotion/promotion/promotion', 'tPMTTitle') ?></a></li>
                        <li class="active"><a><?= language('common/main/main', 'tAddData') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvTBBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitTB').click()"><?= language('common/main/main', 'tSave') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNTBBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageTB">
    </div>
</div>

<script>
    var tBaseURL = '<?php echo base_url(); ?>';
    //tSys Decimal Show
    var nOptDecimalShow = '<?php echo $nOptDecimalShow; ?>';
    var nOptDecimalSave = '<?php echo $nOptDecimalSave; ?>';

    // Set Lang Edit 
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit"); ?>;
    var tUsrApv = <?php echo $this->session->userdata("tSesUsername"); ?>;
</script>

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/document/assets/src/producttransferbranch/jProducttransferbranch.js"></script>
