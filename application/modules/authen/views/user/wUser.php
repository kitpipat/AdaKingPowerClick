<input id="oetUsrStaBrowse" type="hidden" value="<?php echo $nUsrBrowseType ?>">
<input id="oetUsrCallBackOption" type="hidden" value="<?php echo $tUsrBrowseOption ?>">
<input id="oetUsrLoginLevel" type="hidden" value="<?php echo $this->session->userdata("tSesUsrLoginLevel"); ?>">
<input id="oetUsrBchCount" type="hidden" value="<?php echo $this->session->userdata("nSesUsrBchCount"); ?>">

<div id="odvUsrMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNUsrVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">	<!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('user/0/0');?> 
                        <li id="oliUsrTitle" onclick="JSvCallPageUserList()" style="cursor:pointer"><?php echo language('authen/user/user', 'tUSRTitle') ?></li>
                        <li id="oliUsrTitleAdd" class="active"><a><?php echo language('authen/user/user', 'tUSRTitleAdd') ?></a></li>
                        <li id="oliUsrTitleEdit" class="active"><a><?php echo language('authen/user/user', 'tUSRTitleEdit') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0">
                    <div id="odvBtnUsrInfo">
                        <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1)) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageUserAdd()">+</button>
                        <?php endif; ?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPageUserList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack') ?></button>
                            <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                                <div class="btn-group">
                                    <button type="button" class="btn xWBtnGrpSaveLeft" onclick="$('#obtAddEditUser').click()"> <?php echo language('common/main/main', 'tSave') ?></button>
                                    <?php echo $vBtnSave ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- xxx -->
            <div class="xCNUsrVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tUsrBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliUsrNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tUsrBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('authen/user/user', 'tUSRTitle') ?></a></li>
                        <li class="active"><a><?php echo language('authen/user/user', 'tUSRTitleAdd') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvUsrBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtAddEditUser').click()"><?php echo language('common/main/main', 'tSave') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="xCNMenuCump xCNUsrBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageUser"></div>
</div>

<script src="<?php echo base_url('application/modules/authen/assets/src/user/jUser.js'); ?>"></script>




