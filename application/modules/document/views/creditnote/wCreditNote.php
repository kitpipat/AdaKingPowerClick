<input id="oetCreditNoteStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetCreditNoteCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvCreditNoteMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNCreditNoteVMaster">
                <div class="col-xs-12 col-md-5">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('creditNote/0/0');?>
                        <li id="oliCreditNoteTitle" class="xCNLinkClick" onclick="JSvCallPageCreditNoteList()"><?= language('document/creditnote/creditnote', 'tCreditNoteTitle') ?></li>
                        <li id="oliCreditNoteTitleAdd" class="active"><a href="javascript:;"><?= language('document/creditnote/creditnote', 'tCreditNoteTitleAdd') ?></a></li>
                        <li id="oliCreditNoteTitleEdit" class="active"><a href="javascript:;"><?= language('document/creditnote/creditnote', 'tCreditNoteTitleEdit') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-7 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvBtnCreditNoteInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCreditNoteAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvCallPageCreditNoteList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack') ?></button>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                                    <button id="obtCreditNotePrintDoc" onclick="JSxCreditNotePrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                                    <button id="obtCreditNoteCancel" onclick="JSnCreditNoteCancel(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel') ?></button>
                                    <button id="obtCreditNoteApprove" onclick="JSnCreditNoteApprove(false)" class="btn xCNBTNPrimery xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove') ?></button>
                                    <div class="btn-group">
                                        <button type="button" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCreditNote').click()"> <?php echo language('common/main/main', 'tSave') ?></button>
                                        <?php echo $vBtnSave ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNCreditNoteVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliCreditNoteNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious"><a><?= language('common/main/main', 'tShowData') ?> : <?= language('promotion/promotion/promotion', 'tPMTTitle') ?></a></li>
                        <li class="active"><a><?= language('common/main/main', 'tAddData') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvCreditNoteBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCreditNote').click()"><?= language('common/main/main', 'tSave') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="xCNMenuCump xCNCreditNoteBrowseLine" id="odvMenuCump">&nbsp;</div>

<div class="main-content">
    <div id="odvContentPageCreditNote"></div>
</div>

<div class="modal fade" id="odvCreditNoteSelectDocTypePopup">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/creditnote/creditnote','tCreditNoteMemoType');?></label>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="fancy-radio">
                        <label class="fancy-checkbox custom-bgcolor-blue">
                            <input type="radio" name="orbCreditNoteSelectDocType" checked="true" value="6">
                            <span><i></i><?php echo language('document/creditnote/creditnote','tCreditNoteSendAndReceive');?></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fancy-radio">
                        <label class="fancy-checkbox custom-bgcolor-blue">
                            <input type="radio" name="orbCreditNoteSelectDocType" value="7">
                            <span><i></i><?php echo language('document/creditnote/creditnote','tCreditNoteProductAmount');?></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="obtnCreditNoteConfirmSelectDocType" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var tBaseURL        = '<?php echo base_url(); ?>';
    //tSys Decimal Show
    var nOptDecimalShow = '<?php echo $nOptDecimalShow; ?>';
    var nOptDecimalSave = '<?php echo $nOptDecimalSave; ?>';
    // Set Lang Edit 
    var nLangEdits      = '<?php echo $this->session->userdata("tLangEdit");?>';
    var tUsrApv         = '<?php echo $this->session->userdata("tSesUsername");?>';
</script>

<script type="text/javascript" src="<?php echo base_url('application/modules/document/assets/src/creditnote/jCreditNote.js'); ?>"></script>



