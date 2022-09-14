<input type="hidden" name="oetCstContactMode" value="2">
<input type="hidden" id="oetCstContactAreaCode" name="oetCstContactAreaCode" value="n/a">
<input type="hidden" id="oetCstContactZoneCode" name="oetCstContactZoneCode" value="n/a">
<div class="col-xl-6 col-lg-6 col-md-6">
    <div class="form-group">
        <div class="validate-input-">
            <textarea
                class="input100"
                rows="4" 
                cols="50" 
                id="otaCstContactDesc1" 
                name="otaCstContactDesc1"
                placeholder="<?= language('customer/customer/customer', 'tCSTAddDist1')?>"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="validate-input">
            <textarea 
                class="input100" 
                rows="4" 
                cols="50"
                id="otaCstContactDesc2" 
                name="otaCstContactDesc2" 
                placeholder="<?= language('customer/customer/customer', 'tCSTAddDist2')?>"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="validate-input" data-validate="Please Insert Website">
            <label class="xCNLabelFrm"><?= language('customer/customer/customer','tCSTAddWebsite')?></label>
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
