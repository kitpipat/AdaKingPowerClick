<div class="row">
    <input type="hidden" id="ohdCSTAddressCode" name="ohdCSTAddressCode" value="<?php echo @$tCSTAddressCode;?>">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label id="olbCSTAddressInfo"  class="xCNLabelFrm xCNLinkClick"><?php echo language('customer/customer/customer','tCSTAddressTitle');?></label>
        <label id="olbCSTAddressAdd"   class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddressTitleAdd');?></label>
        <label id="olbCSTAddressEdit"  class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddressTitleEdit');?></label>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
        <div class="demo-button xCNBtngroup" style="width:100%;">
            <?php if($aCSTAlwAddress['tAutStaFull'] == 1 || ($aCSTAlwAddress['tAutStaAdd'] == 1 || $aCSTAlwAddress['tAutStaEdit'] == 1)) : ?>
                <div id="odvCSTAddressBtnGrpInfo">
                    <button id="obtCSTAddressCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                </div>
            <?php endif; ?>
            <div id="odvCSTAddressBtnGrpAddEdit">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtCSTAddressCancle" type="button" class="btn" style="background-color:#D4D4D4; color:white;">
                        <?php echo language('common/main/main','tCancel')?>
                    </button>
                    <?php if($aCSTAlwAddress['tAutStaFull'] == 1 || ($aCSTAlwAddress['tAutStaAdd'] == 1 || $aCSTAlwAddress['tAutStaEdit'] == 1)) : ?>
                        <button id="obtCSTAddressSave" type="button" class="btn" style="background-color:#179BFD; color:white;">
                            <?php echo language('common/main/main', 'tSave')?>
                        </button>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="odvCSTAddressContent"></div>
</div>
<script src="<?php echo  base_url('application/modules/customer/assets/src/customer/jCustomerAddress.js'); ?>"></script>