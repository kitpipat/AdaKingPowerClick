<input id="oetMCPStaBrowseType"     type="hidden" value="<?php echo @$nMCPBrowseType;?>">
<input id="oetMCPCallBackOption"    type="hidden" value="<?php echo @$tMCPBrowseOption;?>">

<div id="odvMCPMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <ol id="oliMCPMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('docManageCoupon/0/0');?>
                    <li id="oliMCPTitle" style="cursor:pointer;"><?php echo language('document/managecoupon/managecoupon','tMCPTitleMenu');?></li>
                </ol>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <div id="odvMCPBtnGrpInfo">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <input id="ohdMCPDocNoMulti" type="hidden" value="">
                            <input id="ohdMCPAdjType" type="hidden" value="">
                            <button id="obtMCPAdjustStatus" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" disabled> <?php echo language('common/main/main', 'ปิดใช้งาน'); ?></button> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNMCPBrowseLine" id="odvMenuCump">&nbsp;</div>
<div class="main-content">
    <div id="odvMCPContentPageDocument">
    </div>
</div>

<?php include('script/jManageCoupon.php')?>