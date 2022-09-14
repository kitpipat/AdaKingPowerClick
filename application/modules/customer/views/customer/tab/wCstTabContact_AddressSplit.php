<input type="hidden" name="oetCstContactMode" value="1">
<div class="col-xl-6 col-lg-6 col-md-6">
    <div class="form-group">
        <div class="validate-input" data-validate="Please Insert Address Number">
            <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddNo'); ?></label>
            <input type="text" class="form-control" maxlength="100" id="oetCstContactNo" name="oetCstContactNo" value="">
        </div>
    </div>
    <div class="form-group">
        <div class="validate-input" data-validate="Please Insert Soi">
            <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddSoi'); ?></label>
            <input type="text" class="input100" maxlength="100" id="oetCstContactSoi" name="oetCstContactSoi" value="">
        </div>
    </div>
    <div class="form-group">
        <div class="validate-input" data-validate="Please Insert Village">
            <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddVillage'); ?></label>
            <input type="text" class="form-control" maxlength="100" id="oetCstContactVillage" name="oetCstContactVillage" value="">
        </div>
    </div>
    <div class="form-group">
        <div class="validate-input" data-validate="Please Insert Road">
            <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddRoad'); ?></label>
            <input type="text" class="form-control" maxlength="100" id="oetCstContactRoad" name="oetCstContactRoad" value="">
        </div>
    </div>
    <div class="form-group">
        <div class="validate-input" data-validate="Please Insert Country">
            <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddCountry'); ?></label>
            <input type="text" class="form-control" maxlength="100" id="oetCstContactCountry" name="oetCstContactCountry" value="">
        </div>
    </div>
    <input type="hidden" id="ohdContactProvinceRef" value="">
    <input type="hidden" id="ohdContactDistrictRef" value="">
    <input type="hidden" id="ohdContactSubdistrictRef" value="">

    <!--  BrowseZone โซน -->
    <div class="form-group">
        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddArea'); ?></label>
        <div class="input-group">
            <input type="hidden" id="oetCstContactAreaCode" name="oetCstContactAreaCode">
            <input type="text" class="form-control xCNHide" id="oetCstContactZoneCode" name="oetCstContactZoneCode" maxlength="5" value="">
            <input class="input100 xWPointerEventNone" type="text" id="oetCstContactZoneName" name="oetCstContactZoneName" placeholder="" value="" readonly>
            <span class="input-group-btn">
                <button id="oimCstCtrBrowseZone" type="button" class="btn xCNBtnBrowseAddOn">
                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                </button>
            </span>
        </div>
    </div>
    
    <!--  BrowsePvn จังหวัด -->
    <div class="form-group" id="odvAddPvnContainer">
        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddPvn'); ?></label>
        <div class="input-group">
            <input  type="text" class="form-control xCNHide" id="oetCstContactPvnCode" name="oetCstContactPvnCode" maxlength="5" onchange="JSxCSTCtrChangeLocation(this, event, 'province')" value="<?php echo $tCstContactProvinceCode; ?>">
            <input class="input100 xWPointerEventNone" type="text" id="oetCstContactPvnName" name="oetCstContactPvnName" placeholder="" value="" readonly>
            <span class="input-group-btn">
                <button id="oimCstCtrBrowsePvn" type="button" class="btn xCNBtnBrowseAddOn">
                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                </button>
            </span>
        </div>
    </div>

    <!-- BrowseDst อำเภอ -->
    <div class="form-group" id="odvAddDstContainer">
        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddDst'); ?></label>
        <div class="input-group">
            <input  type="text"  class="form-control xCNHide" id="oetCstContactDstCode" name="oetCstContactDstCode" onchange="JSxCSTCtrChangeLocation(this, event, 'district')" maxlength="5" value="<?php echo $tCstContactDistrictCode; ?>">
            <input class="input100 xWPointerEventNone" type="text" id="oetCstContactDstName" name="oetCstContactDstName" placeholder="" value="" readonly>
            <span class="input-group-btn xWPointerEventNone">
                <button id="oimCstCtrBrowseDst" type="button" class="btn xCNBtnBrowseAddOn">
                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                </button>
            </span>
        </div>
    </div>
 
    <!--  BrowseSubDist ตำบล -->
    <div class="form-group" id="odvAddSubDistContainer">
        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddSubDist'); ?></label>
        <div class="input-group">
            <input  type="text" class="form-control xCNHide" id="oetCstContactSubDistCode" name="oetCstContactSubDistCode" onchange="JSxCSTCtrChangeLocation(this, event, 'subdistrict')" maxlength="5" value="<?php echo $tCstContactSubDistrictCode; ?>">
            <input class="input100 xWPointerEventNone" type="text" id="oetCstContactSubDistName" name="oetCstContactSubDistName" placeholder= "" value="" readonly>
            <span class="input-group-btn xWPointerEventNone">
                <button id="oimCstCtrBrowseSubDist" type="button" class="btn xCNBtnBrowseAddOn">
                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                </button>
            </span>
        </div>
    </div>


    <div class="form-group">
        <div class="validate-input" data-validate="Please Insert Post Code">
            <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddPostCode'); ?></label>
            <input type="text" class="input100" maxlength="100" id="oetCstContactPostCode" name="oetCstContactPostCode" value="">
        </div>
    </div>
    <div class="form-group">
        <div class="validate-input" data-validate="Please Insert Website">
            <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddWebsite'); ?></label>
            <input type="text" class="input100" maxlength="100" id="oetCstContactWebsite" name="oetCstContactWebsite" value="">
        </div>
    </div>

    <div class="form-group">
        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTLocation'); ?></label>
        <input type="hidden" id="ohdCstContactLongitude" name="ohdCstContactLongitude">
        <input type="hidden" id="ohdCstContactLatitude" name="ohdCstContactLatitude">
        <div id="odvCstCtrMapEdit" class="xCNMapShow"></div>                
    </div>
</div>

