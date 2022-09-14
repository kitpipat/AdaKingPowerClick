<div class="row">
    <input type="hidden" id="ohdSalemachineAddrPosCode" name="ohdSalemachineAddrPosCode" value="<?php echo @$tSalemachineAddrPosCode;?>">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label id="olbSalemachineAddressInfo"  class="xCNLabelFrm xCNLinkClick"><?php echo language('pos/salemachine/salemachine','tPOSAddressTitle');?></label>
        <label id="olbSalemachineAddressAdd"   class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine','tPOSAddressTitleAdd');?></label>
        <label id="olbSalemachineAddressEdit"  class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine','tPOSAddressTitleEdit');?></label>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
        <div class="demo-button xCNBtngroup" style="width:100%;">
            <?php if($aAlwSalemachineAddress['tAutStaFull'] == 1 || ($aAlwSalemachineAddress['tAutStaAdd'] == 1 || $aAlwSalemachineAddress['tAutStaEdit'] == 1)) : ?>
                <div id="odvSalemachineAddressBtnGrpInfo">
                    <button id="obtSalemachineAddressCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                </div>
            <?php endif; ?>
            <div id="odvSalemachineAddressBtnGrpAddEdit">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtSalemachineAddressCancle" type="button" class="btn" style="background-color:#D4D4D4; color:white;">
                        <?php echo language('common/main/main','tCancel')?>
                    </button>
                    <?php if($aAlwSalemachineAddress['tAutStaFull'] == 1 || ($aAlwSalemachineAddress['tAutStaAdd'] == 1 || $aAlwSalemachineAddress['tAutStaEdit'] == 1)) : ?>
                        <button id="obtSalemachineAddressSave" type="button" class="btn" style="background-color:#179BFD; color:white;">
                            <?php echo language('common/main/main', 'tSave')?>
                        </button>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="odvSalemachineAddressContent"></div>
</div>
<script src="<?php echo  base_url('application/modules/pos/assets/src/salemachine/jSalemachineAddress.js'); ?>"></script>