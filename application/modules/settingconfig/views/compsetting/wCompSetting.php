<input id="oetCompSettingStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetCompSettingCallBackOption" type="hidden" value="<?=$tBrowseOption?>">


<div id="odvCompSettingConfigMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNCompSettingConfigVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('CompSettingCon/0/0');?>
                        <li id="oliCompSettingConfigTitle" class="xCNLinkClick" onclick="JSvCompSettingConfigCallPageList()"><?php echo language('company/compsettingconnect/compsettingconnect','tCompSetConnectAPITitle'); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="xCNMenuCump xCNCompSettingConfigBrowseLine" id="odvMenuCump">&nbsp;</div>


<div class="main-content">
    <div id="odvContentPageCompSettingConfig"></div>
</div>

<script type="text/javascript" src="<?php echo base_url('application/modules/settingconfig/assets/src/compsetting/jCompSettingconfig.js'); ?>"></script>