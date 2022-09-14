<input id="oetCardShiftOutStaBrowse" type="hidden" value="<?php echo $nCardShiftOutBrowseType; ?>">
<input id="oetCardShiftOutCallBackOption" type="hidden" value="<?php echo $tCardShiftOutBrowseOption; ?>">

<div id="odvCardShiftOutMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="xCNavRow" style="width:inherit;">

            <div class="xCNCardShiftOutVMaster row" >
                <div class="col-xs-12 col-md-7">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('cardShiftOut/0/0');?>
                        <li id="oliCardShiftOutTitle" class="xCNLinkClick" onclick="JSvCardShiftOutCallPageCardShiftOut('')"><?php echo language('document/card/cardout', 'tCardShiftOutTitle'); ?></li>
                        <li id="oliCardShiftOutTitleAdd" class="active"><a href="javascrip:;"><?php echo language('document/card/cardout', 'tCardShiftOutTitleAdd'); ?></a></li>
                        <li id="oliCardShiftOutTitleEdit" class="active"><a href="javascrip:;"><?php echo language('document/card/cardout', 'tCardShiftOutTitleEdit'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-5 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] == "1") : ?>
                            <div id="odvBtnCardShiftOutInfo">
                                <button id="obtCardShiftOutAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCardShiftOutCallPageCardShiftOutAdd()">+</button>
                            </div>
                        <?php endif; ?>
                        <div id="odvBtnAddEdit">
                            <button onclick="JSvCardShiftOutCallPageCardShiftOut()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaPrint"] == "1") : ?>
                                <button type="button" id="obtCardShiftOutBtnDocMa" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" onclick="JSxCardShiftOutPrint()"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaCancel"] == "1") : ?>
                                <button id="obtCardShiftOutBtnCancelApv" onclick="JSxCardShiftOutStaDoc(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAppv"] == "1") : ?>
                                <button id="obtCardShiftOutBtnApv" onclick="JSxCardShiftOutStaApvDoc(false)" class="btn xCNBTNPrimery xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] || $aPermission["tAutStaEdit"]) : ?>
                                <button type="button" id="obtCardShiftOutBtnSave" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="$('#obtSubmitCardShiftOutMainForm').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>								
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xCNCardShiftOutVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tCardShiftOutBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliCardShiftOutNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCardShiftOutBrowseOption; ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('document/card/cardout', 'tCardShiftOutTitle'); ?></a></li>
                        <li class="active"><a><?php echo language('document/card/cardout', 'tCardShiftOutTitleAdd'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvCardShiftOutBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCardShiftOut').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="xCNMenuCump xCNCardShiftOutBrowseLine" id="odvMenuCump">&nbsp;</div>
<div class="main-content" id="odvMainContent" style="background-color: #F0F4F7;">    
    <div id="odvContentPageCardShiftOut"></div>
</div>
<script src="<?php echo base_url('application/modules/document/assets/src/cardshiftout/jCardShiftOut.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/vendor/rabbitmq/stomp.min.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/vendor/rabbitmq/sockjs.min.js'); ?>"></script>

