<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "areaEventEdit"; 
        $tAreCode   = $aAreData['raItems']['rtAreCode'];
        $tAreName   = $aAreData['raItems']['rtAreName'];
    }else{
        $tRoute     = "areaEventAdd";
        $tAreCode   = "";
        $tAreName   = "";
      
    }
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddAre">
    <button style="display:none" type="submit" id="obtSubmitAre" onclick="JSoAddEditAre('<?php echo $tRoute?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5">
                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/area/area','tARECode')?></label>
                <div class="form-group" id="odvAreAutoGenCode">
                    <div class="validate-input">
                        <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbAreAutoGenCode" name="ocbAreAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>

                <div id="odvAreCodeForm" class="form-group">
                    <input type="hidden" id="ohdCheckDuplicateAreCode" class="ohdCheckDuplicateAreCode" value="1">
                    <div class="validate-input">
                        <input
                            type="text"
                            class="form-control xCNInputWithoutSpcNotThai"
                            maxlength="5"
                            id="oetAreCode"
                            name="oetAreCode"
                            data-is-created="<?php echo $tAreCode; ?>"
                            placeholder="#####"
                            value="<?php echo $tAreCode;?>"
                            data-validate-required = "<?php echo language('address/area/area','tAREValidCode')?>"
                            data-validate-dublicateCode ="<?php echo language('address/area/area','tAREValidCodeDup');?>"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <div class="validate-input">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('address/area/area','tAREName')?></label>
                        <input
                            type="text"
                            class="form-control xCNInputWithoutSpc"
                            maxlength="200"
                            id="oetAreName"
                            name="oetAreName"
                            value="<?php echo $tAreName;?>"
                            data-validate-required="<?php echo language('address/area/area','tAREValidName')?>"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include 'script/jAreaAdd.php'; ?>

<script>
    $('#obtGenCodeAre').click(function(){
        JStGenerateAreCode();
    });
</script>