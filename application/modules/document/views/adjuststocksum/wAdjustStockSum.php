<input id="oetAdjStkSumStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetAdjStkSumCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvAdjStkSumMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNAdjStkSumVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('docSM/0/0');?>
                        <li id="oliAdjStkSumTitle" class="xCNLinkClick" onclick="JSvCallPageAdjStkSumList()"><?= language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumTitle') ?></li>
                        <li id="oliAdjStkSumTitleAdd" class="active"><a href="javascript:;"><?= language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumTitleAdd') ?></a></li>
                        <li id="oliAdjStkSumTitleEdit" class="active"><a href="javascript:;"><?= language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumTitleEdit') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvBtnAdjStkSumInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageAdjStkSumAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtAdjStkSumBack" onclick="JSvCallPageAdjStkSumList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack') ?></button>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                                    <button id="obtAdjStkSumPrint" onclick="JSxAdjStkSumPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint')?></button>
                                    <button id="obtAdjStkSumCancel" onclick="JSnAdjStkSumCancel(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel') ?></button>
                                    <button id="obtAdjStkSumApprove" onclick="JSnAdjStkSumApprove(false)" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove') ?></button>
                                    <div class="btn-group" id="obtAdjStkSumSave">
                                        <button type="button" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitAdjStkSum').click()"> <?php echo language('common/main/main', 'tSave') ?></button>
                                        <?php echo $vBtnSave ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNAdjStkSumVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliAdjStkSumNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious"><a><?= language('common/main/main', 'tShowData') ?> : <?= language('promotion/promotion/promotion', 'tPMTTitle') ?></a></li>
                        <li class="active"><a><?= language('common/main/main', 'tAddData') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvAdjStkSumBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitAdjStkSum').click()"><?= language('common/main/main', 'tSave') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNAdjStkSumBrowseLine" id="odvMenuCump">&nbsp;</div>
<div class="main-content">
    <div id="odvContentPageAdjStkSum"></div>
</div>
<script>
    var tBaseURL = '<?php echo base_url(); ?>';
    //tSys Decimal Show
    var nOptDecimalShow = '<?php echo $nOptDecimalShow; ?>';
    var nOptDecimalSave = '<?php echo $nOptDecimalSave; ?>';

    // Set Lang Edit 
    var nLangEdits 	= <?php echo $this->session->userdata("tLangEdit"); ?>;
    var tUsrApv 	= '<?php echo $this->session->userdata("tSesUsername"); ?>';
</script>


<script type="text/javascript" src="<?php echo base_url() ?>application/modules/document/assets/src/adjuststocksum/jAdjustStockSum.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js" integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>












