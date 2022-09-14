<div id="odvCFSMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <ol id="oliCFSMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('toolConfigSlip');?>
                    <li id="oliCFSTitle" style="cursor:pointer;"><?php echo language('tool/configslip','tCFSTitleMenu');?></li>
                </ol>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <div id="odvCFSBtnGrpInfo">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <input id="ohdCFSAgnCode" type="hidden" value="<?=$this->session->userdata("tSesUsrAgnCode")?>">
                            <input id="ohdCFSUsrCode" type="hidden" value="<?=$this->session->userdata("tSesUsername")?>">
                            <button id="obtCFSResetDefault" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('tool/configslip', 'tCFSBtnReset'); ?></button>  
                            <button id="obtCFSSubmit" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('tool/configslip', 'tCFSBtnSave'); ?></button>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div id="odvCFSContentPageDocument"></div>
</div>

<?php include('script/jConfigSlip.php')?>