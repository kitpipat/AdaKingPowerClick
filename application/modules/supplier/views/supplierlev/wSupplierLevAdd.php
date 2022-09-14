<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "supplierlevEventEdit";
        $tSlvCode   = $aSlvData['raItems']['rtSlvCode'];
        $tSlvName   = $aSlvData['raItems']['rtSlvName'];
        $tSlvRmk    = $aSlvData['raItems']['rtSlvRmk'];
    }else{
        $tRoute     = "supplierlevEventAdd";
        $tSlvCode   = "";
        $tSlvName   = "";
        $tSlvRmk    = "";
    }
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddSupplierLevel">
    <button style="display:none" type="submit" id="obtSubmitSupplierLevel" onclick="JSoAddEditSupplierLevel('<?= $tRoute?>')"></button>
    <div><!-- เพิ่มมาใหม่ -->
        <div class="panel panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5">

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('supplier/supplierlev/supplierlev','tSLVFrmSlvCode')?></label>
                        <div id="odvSupplierlevAutoGenCode" class="form-group">
                        <div class="validate-input">
                        <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbSupplierlevAutoGenCode" name="ocbSupplierlevAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>
                    <div id="odvSupplierlevCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateSlvCode" name="ohdCheckDuplicateSlvCode" value="1">
                                <div class="validate-input">
                                <input
                                type="text"
                                class="form-control xCNGenarateCodeTextInputValidate"
                                maxlength="5"
                                id="oetSplevCode"
                                name="oetSplevCode"
                                data-is-created="<?php echo $tSlvCode;?>"
                                placeholder="<?= language('supplier/supplierlev/supplierlev','tSLVCode')?>"
                                value="<?= $tSlvCode; ?>"
                                data-validate-required = "<?= language('supplier/supplierlev/supplierlev','tSLVValidCode')?>"
                                data-validate-dublicateCode = "<?= language('supplier/supplierlev/supplierlev','tSLVValidCheckCode')?>"
                            >
                        </div>
                    </div>
                </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('supplier/supplierlev/supplierlev','tSLVFrmSlvName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control" maxlength="50" id="oetSlvName" name="oetSlvName" value="<?=$tSlvName?>"
                        data-validate-required="<?= language('supplier/supplierlev/supplierlev','tSLVValidName')?>"
                        placeholder="<?php echo language('supplier/supplierlev/supplierlev','tSLVFrmSlvName')?>"
                        autocomplete="off"
                        > <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('supplier/supplierlev/supplierlev','tSLVFrmSlvRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaSlvRmk" name="otaSlvRmk"><?=$tSlvRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jSupplierLevAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodeSupplierLevel').click(function(){
        JStGenerateSupplierLevelCode();
    });
</script>
