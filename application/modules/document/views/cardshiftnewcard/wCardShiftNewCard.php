<input id="ohdCardShiftNewCardBrowseType" type="hidden" value="<?php echo $nCardShiftNewCardBrowseType; ?>">
<input id="ohdCardShiftNewCardBrowseOption" type="hidden" value="<?php echo $tCardShiftNewCardBrowseOption; ?>">

<?php if (isset($nCardShiftNewCardBrowseType) && $nCardShiftNewCardBrowseType == 0) : ?>
    <div id="odvCardShiftNewCardMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row" style="width:inherit;">
                <div class="col-xs-12 col-md-7">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('cardShiftNewCard/0/0');?>
                        <li id="oliCardShiftNewCardTitle" class="xCNLinkClick" onclick="JSvCallPageCardShiftNewCardList()"><?php echo language('document/card/newcard', 'tCardShiftNewCardTitle'); ?></li>
                        <li id="oliCardShiftNewCardTitleAdd" class="active"><a href="javascrip:;"><?php echo language('document/card/newcard', 'tCardShiftNewCardTitleAdd'); ?></a></li>
                        <li id="oliCardShiftNewCardTitleEdit" class="active"><a href="javascrip:;"><?php echo language('document/card/newcard', 'tCardShiftNewCardTitleEdit'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-5 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] == "1") : ?>
                            <div id="odvBtnCardShiftNewCardInfo">
                                <button id="obtCardShiftNewCardAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCardShiftNewCardAdd()">+</button>
                            </div>
                        <?php endif; ?>
                        <div id="odvBtnAddEdit">
                            <button onclick="JSvCallPageCardShiftNewCardList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaPrint"] == "1") : ?>
                                <button type="button" id="obtCardShiftNewCardBtnDocMa" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" onclick="JSxCardShiftNewCardPrint()"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaCancel"] == "1") : ?>
                                <button id="obtCardShiftNewCardBtnCancelApv" onclick="JSxCardShiftNewCardStaDoc(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAppv"] == "1") : ?>
                                <button id="obtCardShiftNewCardBtnApv" onclick="JSxCardShiftNewCardStaApvDoc(false)" class="btn xCNBTNPrimery xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] || $aPermission["tAutStaEdit"]) : ?>
                                <button type="button" id="obtCardShiftNewCardBtnSave" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="$('#obtSubmitCardShiftNewCardMainForm').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>								
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNCardShiftNewCardBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content" id="odvMainContent" style="background-color: #F0F4F7;">
        <div id="odvContentPageCardShiftNewCard"></div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tCardShiftNewCardBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliCardShiftNewCardNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCardShiftNewCardBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('document/card/newcard', 'tCardShiftNewCardTitle') ?></a></li>
                    <li class="active"><a><?php echo language('document/card/newcard', 'tCardShiftNewCardTitleAdd') ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvCardShiftNewCardBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCard').click()"><?php echo language('common/main/main', 'tSave') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>
<?php endif; ?>
<script src="<?php echo base_url('application/modules/document/assets/src/cardshiftnewcard/jCardShiftNewCard.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/vendor/rabbitmq/stomp.min.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/vendor/rabbitmq/sockjs.min.js'); ?>"></script>
