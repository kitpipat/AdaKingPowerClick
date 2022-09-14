<div class="row">
    <input type="hidden" id="ohdBranchAddressBchCode" name="ohdBranchAddressBchCode" value="<?php echo @$tBranchAddressCode;?>">
    <input type="hidden" id="ohdBranchAddressBchName" name="ohdBranchAddressBchName" value="<?php echo @$tBranchAddressName;?>">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label id="olbBranchAddressInfo"  class="xCNLabelFrm xCNLinkClick"><?php echo language('company/branch/branch','tBCHAddressTitle');?></label>
        <label id="olbBranchAddressAdd"   class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddressTitleAdd');?></label>
        <label id="olbBranchAddressEdit"  class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddressTitleEdit');?></label>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
        <div class="demo-button xCNBtngroup" style="width:100%;">
            <?php if($aAlwBranchAddress['tAutStaFull'] == 1 || ($aAlwBranchAddress['tAutStaAdd'] == 1 || $aAlwBranchAddress['tAutStaEdit'] == 1)) : ?>
                <div id="odvBranchAddressBtnGrpInfo">
                    <button id="obtBranchAddressCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                </div>
            <?php endif; ?>
            <div id="odvBranchAddressBtnGrpAddEdit">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtBranchAddressCancle" type="button" class="btn" style="background-color:#D4D4D4; color:white;">
                        <?php echo language('common/main/main','tCancel')?>
                    </button>
                    <?php if($aAlwBranchAddress['tAutStaFull'] == 1 || ($aAlwBranchAddress['tAutStaAdd'] == 1 || $aAlwBranchAddress['tAutStaEdit'] == 1)) : ?>
                        <button id="obtBranchAddressSave" type="button" class="btn" style="background-color:#179BFD; color:white;">
                            <?php echo language('common/main/main', 'tSave')?>
                        </button>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="odvBranchAddressContent"></div>
</div>
<script src="<?php echo  base_url('application/modules/company/assets/src/branch/jBranchAddress.js'); ?>"></script>