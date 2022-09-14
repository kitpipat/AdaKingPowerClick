<style>
    .NumberDuplicate{
        font-size   : 15px !important;
        color       : red;
        font-style  : italic;
    }

    .xCNSearchpadding{
        padding     : 0px 3px;
    }
</style>
<input type="hidden" id="oetPSHBchCode"    name="oetPSHBchCode"    value='<?php echo $aPSHBchCode; ?>'>
<input type="hidden" id="oetPSHShpCode"    name="oetPSHShpCode"    value='<?php echo $aPSHShpCode; ?>'>
<input type="hidden" id="oetPshPSHMerCode" name="oetPshPSHMerCode" value='<?php echo $aPSHMerCode; ?>'>
<input type="hidden" id="oetPshPSHPosCode" name="oetPshPSHPosCode" value="<?php echo $tPSHPosCode?>">
    <div class="row">
    <!--ฟิลเตอร์ค้นหา-->
    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
        <div class="row" style="margin: 0px;">
            <!--กลุ่มช่อง-->
            <?php   
            $tBchCode  = explode(",",$aPSHBchCode);
            $tCountBch = FCNnHSizeOf($tBchCode);  
            if($tCountBch != 1 ) :  
            ?>
            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2 xCNSearchpadding">
            <div class="form-group">  
            <label class="xCNLabelFrm"><?=language('company/branch/branch','tBCHTitle')?></label>
                <select class="selectpicker form-control" id="ocmPshBchCode" name="ocmPshBchCode" maxlength="1">
                    <?php 
                    $tBchCode  = explode(",",$aPSHBchCode);
                    foreach($tBchCode as $aBCHCode){ ?>
                        <option value="<?=$aBCHCode?>"><?=$aBCHCode?></option>
                    <?php } ?>
                </select>
            </div>
            </div>
            <?php endif; ?>  

            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 xCNSearchpadding">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleGroup')?></label>
                    <select class="form-control selectpicker" id="osmPSHRakName">
                        <option value=''><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutPleaseSelect')?></option>
                        <?php foreach($aResultRack as $key => $value){ ?>
                            <option value="<?php echo $value['FTRakCode']; ?>"><?php echo $value['FTRakName']; ?></option> 
                        <?php } ?>
                    </select>
                </div>
            </div>

        <!--ช่อง-->
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 xCNSearchpadding">
            <div class="form-group">
                <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleBox')?></label>
                    <select class="form-control selectpicker" id="osmPSHLayNo">
                        <option value=''><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutPleaseSelect')?></option>
                        <?php foreach($aResultLayout as $key => $value){ ?>
                            <option value="<?php echo $value['FNLayNo']; ?>"><?php echo $value['FNLayNo']; ?></option> 
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!--ชั้น-->
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 xCNSearchpadding">
                <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleFloor')?></label>
                <input type="text" class="xCNInputWithoutSpcNotThai xCNInputNumericWithDecimal xCNInputWithoutSingleQuote" maxlength="3"  id="oetSearchPSHRow" name="oetSearchPSHRow" placeholder='<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleFloor')?>'>
            </div>

            <!--คอลัมน์-->
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 xCNSearchpadding">
                <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleColumn')?></label>
                <input type="text" class="xCNInputWithoutSpcNotThai xCNInputNumericWithDecimal xCNInputWithoutSingleQuote" maxlength="3" id="oetSearchPSHColumn" name="oetSearchPSHColumn" placeholder='<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleColumn')?>'>
            </div>

            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 xCNSearchpadding">
                <label class="xCNLabelFrm" style="width:100%; color:#FFF !important;">.</label>
                <button id="obtSearchPSHLayout" class="btn xCNBtnSearch" type="button" onclick="JSvPSHSearchAll()">
                    <img class="" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                </button>
            </div>
        </div>
    </div>

    <!--content-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentPSHLSettingDataTable"></div>
    </div>

</div>
<?php include "script/jPosShopMain.php"; ?>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
    $('ducument').ready(function(){ 
        $('.selectpicker').selectpicker();
    });
</script>