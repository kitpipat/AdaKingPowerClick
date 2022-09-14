<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "suppliertypeEventEdit";
        $tStyCode   = $aStyData['raItems']['rtStyCode'];
        $tStyName   = $aStyData['raItems']['rtStyName'];
        $tStyRmk    = $aStyData['raItems']['rtStyRmk'];
    }else{
        $tRoute     = "suppliertypeEventAdd";
        $tStyCode   = "";
        $tStyName   = "";
        $tStyRmk    = "";
    }
?>


<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddSty">
    <button style="display:none" type="submit" id="obtSubmitSty" onclick="JSoAddEditSty('<?= $tRoute?>')"></button>
    <div><!-- เพิ่มมาใหม่ --> 
        <div class="panel panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('supplier/suppliertype/suppliertype','tSTYFrmStyCode')?></label>
                        <div id="odvStyAutoGenCode" class="form-group">
                        <div class="validate-input">
                        <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbSupplierTypeAutoGenCode" name="ocbSupplierTypeAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>
                    <div id="odvSupplierlevCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateStyCode" name="ohdCheckDuplicateStyCode" value="1">
                                <div class="validate-input">
                                <input
                                type="text"
                                class="form-control xCNGenarateCodeTextInputValidate"
                                maxlength="5"
                                id="oetSptCode"
                                name="oetSptCode"
                                data-is-created="<?php echo $tStyCode;?>"
                                placeholder="<?= language('supplier/suppliertype/suppliertype','tSTYTBCode')?>"
                                value="<?= $tStyCode; ?>"
                                data-validate-required = "<?= language('supplier/supplierlev/supplierlev','tSTYValidCode')?>"
                                data-validate-dublicateCode = "<?= language('supplier/supplierlev/supplierlev','tSTYValidCheckCode')?>"
                            >
                        </div>
                    </div>
                </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('supplier/suppliertype/suppliertype','tSTYFrmStyName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text"
                        class="form-control"
                        maxlength="50" id="oetStyName"
                        name="oetStyName"
                        autocomplete="off"
                        placeholder="<?= language('supplier/suppliertype/suppliertype','tSTYFrmStyName')?>"
                        value="<?=$tStyName?>"
                        data-validate-required ="<?= language('supplier/suppliertype/suppliertype','tSTYValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('supplier/suppliertype/suppliertype','tSTYFrmStyRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaStyRmk" name="otaStyRmk"><?=$tStyRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jSupplierTypeAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
    $('#obtGenCodeSty').click(function(){
        JStGenerateStyCode();
    });
</script>
