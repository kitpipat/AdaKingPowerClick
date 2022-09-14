<input id="oetCmdStaBrowse" type="hidden" value="<?=$nCmdBrowseType?>">
<input id="oetCmdCallBackOption" type="hidden" value="<?=$tCmdBrowseOption?>">

<div id="odvCmdMenuTitle" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNCmdVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('cardmngdata/0/0');?>
                        <li id="oliCMDTitle" onclick="JSvCallPageCardMngFrmList()" style="cursor:pointer"><?php echo language('document/cardmngdata/cardmngdata', 'tCMDTitle') ?></li>
                    </ol>
                </div>    
                <div class="col-xs-12 col-md-4 text-right p-r-0">
                    <div id="odvCardMngDataProcess" class="demo-button xCNBtngroup" style="width:100%;">
                        <button id="obtCmdDataProcess" type="button" class="btn xCNBTNPrimery"><?php echo language('document/cardmngdata/cardmngdata', 'tCMDBtnProcess') ?></button>
                    </div>
                </div>
            </div>
            <div class="xCNCmdVBrowse">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <a onclick="JCNxBrowseData('<?= $tCmdBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliCmdNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?= $tCmdBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?= language('document/cardmngdata/cardmngdata', 'tCMDTitle') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div id="odvCmdBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery"><?= language('document/cardmngdata/cardmngdata', 'tCMDBtnProcess') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNCmdBrowseLine" id="odvMenuCump">&nbsp;</div>
<div class="main-content">
    <div id="odvContentPageCardMngData"></div>
</div>

<div class="modal fade xCNModalApprove" id="odvCardMngProcessPopup">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardtopup', 'tCardShiftTopUpApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('document/card/newcard', 'tCardShiftApproveStatus'); ?></p>
                <ul>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus1'); ?></li>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus2'); ?></li>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus3'); ?></li>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus4'); ?></li>
                </ul>
                <p><?php echo language('document/card/newcard', 'tCardShiftApproveStatus5'); ?></p>
                <p><strong><?php echo language('document/card/newcard', 'tCardShiftApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button id="obtCardMngProcessConfirm" onclick="JSoImportProcessData(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Language for js file -->
<input type="hidden" id="ohdCardMngExcelErrorFileNotMatch" value="<?php echo language('document/card/main', 'tMainExcelErrorFileNotMatch'); ?>">
<input type="hidden" id="ohdCardMngExcelErrorColunmHead" value="<?php echo language('document/card/main', 'tMainExcelErrorColunmHead'); ?>">
<input type="hidden" id="ohdtCardEmptyRecordAlert" value="<?php echo language('document/card/main', 'tMainEmptyRecordAlert'); ?>">
<!-- Language for js file -->
<script src="<?= base_url('application/modules/document/assets/src/cardmngdata/jCardMngData.js'); ?>"></script>

