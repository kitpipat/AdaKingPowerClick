<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "shipviaEventEdit"; 
        $tViaCode   = $aViaData['raItems']['rtViaCode'];
        $tViaName   = $aViaData['raItems']['rtViaName'];
    }else{
        $tRoute     = "shipviaEventAdd"; 
        $tViaCode   = "";
        $tViaName   = "";
    }
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddShipVia">
    <button style="display:none" type="submit" id="obtSubmitShipVia" onclick="JSoAddEditShipVia('<?= $tRoute?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->
                <div class="form-group">
                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('shipvia/shipvia/shipvia','tVIAFrmViaCode')?></label>
                <div id="odvShipviaAutoGenCode" class="form-group">
                <div class="validate-input">
                    <label class="fancy-checkbox">
                        <input type="checkbox" id="ocbShipviaAutoGenCode" name="ocbShipviaAutoGenCode" checked="true" value="1">
                        <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                    </label>
                </div>
            </div>
                <div id="odvShipviaCodeForm" class="form-group">
                    <input type="hidden" id="ohdCheckDuplicateViaCode" name="ohdCheckDuplicateViaCode" value="1"> 
                            <div class="validate-input">
                            <input 
                            type="text" 
                            class="form-control xCNInputWithoutSpcNotThai" 
                            maxlength="5" 
                            id="oetViaCode" 
                            name="oetViaCode"
                            data-is-created="<?php echo $tViaCode;?>"
                            placeholder="<?= language('shipvia/shipvia/shipvia','tVIAValidCode')?>"
                            value="<?php echo $tViaCode; ?>" 
                            data-validate-required = "<?= language('shipvia/shipvia/shipvia','tVIAValidCode')?>"
                            data-validate-dublicateCode = "<?= language('shipvia/shipvia/shipvia','tVIAValidCheckCode')?>"
            
                        >
                    </div>
                </div>
            </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('shipvia/shipvia/shipvia','tVIAFrmViaName')?></label> <!-- เปลี่ยนชื่อ Class -->
                    <input type="text" class="form-control" maxlength="50" id="oetViaName" name="oetViaName" value="<?=$tViaName?>" 
                    data-validate="<?= language('shipvia/shipvia/shipvia','tVIAValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                </div>
            </div>
        </div>
    </div>
</form>
<?php include "script/jShipViaAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodeShipVia').click(function(){
        JStGenerateShipViaCode();
    });
</script>