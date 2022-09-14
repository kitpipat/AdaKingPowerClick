<div class="row">
    <input type="hidden" id="ohdShpAddrBchCode" name="ohdShpAddrBchCode" value="<?php echo @$tShopAddrBchCode;?>">
    <input type="hidden" id="ohdShpAddrShpCode" name="ohdShpAddrShpCode" value="<?php echo @$tShopAddrShpCode;?>">
    <input type="hidden" id="ohdShpAddrShpName" name="ohdShpAddrShpName" value="<?php echo @$tShopAddrShpName;?>">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label id="olbShopAddressInfo"  class="xCNLabelFrm xCNLinkClick"><?php echo language('company/shop/shop','tSHPAddressTitle');?></label>
        <label id="olbShopAddressAdd"   class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddressTitleAdd');?></label>
        <label id="olbShopAddressEdit"  class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddressTitleEdit');?></label>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
        <div class="demo-button xCNBtngroup" style="width:100%;">
            <?php if($aAlwShopAddress['tAutStaFull'] == 1 || ($aAlwShopAddress['tAutStaAdd'] == 1 || $aAlwShopAddress['tAutStaEdit'] == 1)) : ?>
                <div id="odvShopAddressBtnGrpInfo">
                    <button id="obtShopAddressCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                </div>
            <?php endif; ?>
            <div id="odvShopAddressBtnGrpAddEdit">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtShopAddressCancle" type="button" class="btn" style="background-color:#D4D4D4; color:white;">
                        <?php echo language('common/main/main','tCancel')?>
                    </button>
                    <?php if($aAlwShopAddress['tAutStaFull'] == 1 || ($aAlwShopAddress['tAutStaAdd'] == 1 || $aAlwShopAddress['tAutStaEdit'] == 1)) : ?>
                        <button id="obtShopAddressSave" type="button" class="btn" style="background-color:#179BFD; color:white;">
                            <?php echo language('common/main/main', 'tSave')?>
                        </button>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="odvShopAddressContent"></div>
</div>
<script src="<?php echo  base_url('application/modules/company/assets/src/shop/jShopAddress.js'); ?>"></script>