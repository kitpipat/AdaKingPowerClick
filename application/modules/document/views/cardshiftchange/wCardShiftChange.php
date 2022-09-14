<input id="oetCardShiftChangeStaBrowse" type="hidden" value="<?php echo $nCardShiftChangeBrowseType; ?>">
<input id="oetCardShiftChangeCallBackOption" type="hidden" value="<?php echo $tCardShiftChangeBrowseOption; ?>">

<div id="odvCardShiftChangeMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="xCNavRow" style="width:inherit;">

            <div class="xCNCardShiftChangeVMaster row">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('cardShiftChange/0/0');?>
                        <li id="oliCardShiftChangeTitle" class="xCNLinkClick" onclick="JSvCardShiftChangeCallPageCardShiftChange('')"><?php echo language('document/card/cardchange', 'tCardShiftChangeTitle'); ?></li>
                        <li id="oliCardShiftChangeTitleAdd" class="active"><a href="javascrip:;"><?php echo language('document/card/cardchange', 'tCardShiftChangeTitleAdd'); ?></a></li>
                        <li id="oliCardShiftChangeTitleEdit" class="active"><a href="javascrip:;"><?php echo language('document/card/cardchange', 'tCardShiftChangeTitleEdit'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] == "1") : ?>
                            <div id="odvBtnCardShiftChangeInfo">
                                <button id="obtCardShiftChangeAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCardShiftChangeCallPageCardShiftChangeAdd()">+</button>
                            </div>
                        <?php endif; ?>
                        <div id="odvBtnAddEdit">
                        <button onclick="JSvCardShiftChangeCallPageCardShiftChange()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaPrint"] == "1") : ?>
                                <!-- <button type="button" id="obtCardShiftChangeBtnDocMa" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSxCardShiftChangePrint()"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button> -->
                                <button type="button" id="obtCardShiftChangeBtnDocMa" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" onclick="JSxCardShiftChangePrint()"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaCancel"] == "1") : ?>
                                <button id="obtCardShiftChangeBtnCancelApv" onclick="JSxCardShiftChangeStaDoc(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAppv"] == "1") : ?>
                                <button id="obtCardShiftChangeBtnApv" onclick="JSxCardShiftChangeStaApvDoc(false)" class="btn xCNBTNPrimery xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>
                            <?php endif; ?>
                            <?php if ($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] || $aPermission["tAutStaEdit"]) : ?>
                                <button type="button" id="obtCardShiftChangeBtnSave" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="$('#obtSubmitCardShiftChangeMainForm').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>								
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xCNCardShiftChangeVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tCardShiftChangeBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliCardShiftChangeNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCardShiftChangeBrowseOption; ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('document/card/cardchange', 'tCardShiftChangeTitle'); ?></a></li>
                        <li class="active"><a><?php echo language('document/card/cardchange', 'tCardShiftChangeTitleAdd'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvCardShiftChangeBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCardShiftChange').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="xCNMenuCump xCNCardShiftChangeBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content" id="odvMainContent" style="background-color: #F0F4F7;">    
    <div id="odvContentPageCardShiftChange"></div>
</div>
<script src="<?php echo base_url('application/modules/document/assets/src/cardshiftchange/jCardShiftChange.js'); ?>"></script>

