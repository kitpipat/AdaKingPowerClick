<input type="hidden" id="oetDpcDisStaBrowseType" name="oetDpcDisStaBrowseType" value="<?php echo $nDispocilyBrowseType;?>">
<input type="hidden" id="oetDpcDisCallBackOption" name="oetDpcDisCallBackOption" value="<?php echo $tDispocilyBrowseOption;?>">

<div id="odvDpcDisMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNDpcDisVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('discountpolicy/0/0');?>
                        <li id="oliDpcDisTitle" class="xCNLinkClick" onclick="JSvDpcDisCallPageList()"><?php echo language('settingconfig/discountpolicy/discountpolicy', 'tDpcDisTitle'); ?></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div id="odvBtnAddEdit" style="display: block;">
                        <div class="btn-group"> 
                            <button onclick="JSxDpcDisSave()" type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNBTNSave" style="margin-left: 5px;" style="display: block;"><?php echo language('settingconfig/discountpolicy/discountpolicy', 'tDpcDisSave'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="xCNMenuCump" id="odvMenuCump">&nbsp;</div>

<div class="main-content">
    <div id="odvContentPageDiscountpolicy"></div>
</div>


<script src="<?php echo base_url('application/modules/settingconfig/assets/src/discountpolicy/jDiscountpolicy.js')?>"></script>