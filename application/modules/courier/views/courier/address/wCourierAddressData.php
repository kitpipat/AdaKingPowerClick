<div class="row">
    <input type="hidden" id="ohdCourierAddrCryCode" name="ohdCourierAddrCryCode" value="<?php echo @$tCourierAddrCryCode;?>">
    <input type="hidden" id="ohdCourierAddrCryName" name="ohdCourierAddrCryName" value="<?php echo @$tCourierAddrCryName;?>">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label id="olbCourierAddressInfo"  class="xCNLabelFrm xCNLinkClick"><?php echo language('courier/courier/courier','tCRYAddressTitle');?></label>
        <label id="olbCourierAddressAdd"   class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddressTitleAdd');?></label>
        <label id="olbCourierAddressEdit"  class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddressTitleEdit');?></label>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
        <div class="demo-button xCNBtngroup" style="width:100%;">
            <?php if($aAlwCourierAddress['tAutStaFull'] == 1 || ($aAlwCourierAddress['tAutStaAdd'] == 1 || $aAlwCourierAddress['tAutStaEdit'] == 1)) : ?>
                <div id="odvCourierAddressBtnGrpInfo">
                    <button id="obtCourierAddressCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                </div>
            <?php endif; ?>
            <div id="odvCourierAddressBtnGrpAddEdit">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtCourierAddressCancle" type="button" class="btn" style="background-color:#D4D4D4; color:white;">
                        <?php echo language('common/main/main','tCancel')?>
                    </button>
                    <?php if($aAlwCourierAddress['tAutStaFull'] == 1 || ($aAlwCourierAddress['tAutStaAdd'] == 1 || $aAlwCourierAddress['tAutStaEdit'] == 1)) : ?>
                        <button id="obtCourierAddressSave" type="button" class="btn" style="background-color:#179BFD; color:white;">
                            <?php echo language('common/main/main', 'tSave')?>
                        </button>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="odvCourierAddressContent"></div>
</div>
<script src="<?php echo  base_url('application/modules/courier/assets/src/courier/jCourierAddress.js'); ?>"></script>