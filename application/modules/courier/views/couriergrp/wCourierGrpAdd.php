<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "courierGrpEventEdit"; 
        $tCpgCode   = $aCpgData['raItems']['rtCgpCode'];
        $tCpgName   = $aCpgData['raItems']['rtCgpName'];
        $tCpgRmk    = $aCpgData['raItems']['rtCgpRmk'];
    }else{
        $tRoute     = "courierGrpEventAdd";
        $tCpgCode   = "";
        $tCpgName   = "";
        $tCpgRmk    = "";
    }
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddCpg">
    <input type="hidden" id="ohdPdtGroupRoute" value="<?php echo $tRoute; ?>">
    <button style="display:none" type="submit" id="obtSubmitCpg" onclick="JSoAddEditCpg('<?php echo $tRoute;?>');"></button>

    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->
                <div class="form-group">
                        <input type="hidden" value="0" id="ohdCheckCpgClearValidate" name="ohdCheckCpgClearValidate"> 
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('courier/couriergrp/couriergrp','tCPGTBCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <?php
                        if($tRoute=="courierGrpEventAdd"){
                        ?>
                        <div class="form-group" id="odvCpgAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbCpgAutoGenCode" name="ocbCpgAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="odvPunCodeForm">
                            <input 
                                type="text" 
                                class="form-control xCNGenarateCodeTextInputValidate" 
                                maxlength="5" 
                                id="oetCpgCode" 
                                name="oetCpgCode"
                                data-is-created="<?php  ?>"
                                placeholder="<?= language('courier/couriergrp/couriergrp','tCPGTBCode')?>"
                                value="<?php  ?>" 
                                data-validate-required="<?php echo language('product/pdtgroup/pdtgroup','tCPGValidCode')?>"
                                data-validate-dublicateCode="<?php echo language('courier/couriergrp/couriergrp','tCPGValidCodeDup')?>"
                                readonly
                                onfocus="this.blur()">
                            <input type="hidden" value="2" id="ohdCheckDuplicateCpgCode" name="ohdCheckDuplicateCpgCode"> 
                        </div>
                        <?php
                        }else{
                        ?>
                        <div class="form-group" id="odvPunCodeForm">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                <input 
                                    type="text" 
                                    class="form-control xCNGenarateCodeTextInputValidate" 
                                    maxlength="5" 
                                    id="oetCpgCode" 
                                    name="oetCpgCode"
                                    data-is-created="<?php  ?>"
                                    placeholder="<?= language('courier/couriergrp/couriergrp','tCPGTBCode')?>"
                                    value="<?php echo $tCpgCode; ?>" 
                                    readonly
                                    onfocus="this.blur()">
                                </label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('courier/couriergrp/couriergrp','tCPGName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control" maxlength="50" id="oetCpgName" name="oetCpgName" value="<?=$tCpgName?>" 
                        data-validate-required="<?= language('courier/couriergrp/couriergrp','tCPGValidName')?>"
                        placeholder="<?= language('courier/couriergrp/couriergrp','tCPGName')?>"
                        > <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('courier/couriergrp/couriergrp','tCPGRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaCpgRmk" name="otaCpgRmk"><?=$tCpgRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodeCpg').click(function(){
        JStGenerateCpgCode();
    });
</script>