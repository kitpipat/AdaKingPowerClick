<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "courierTypeEventEdit"; 
        $tCtyCode   = $aCtyData['raItems']['rtCtyCode'];
        $tCtyName   = $aCtyData['raItems']['rtCtyName'];
        $tCtyRmk    = $aCtyData['raItems']['rtCtyRmk'];
    }else{
        $tRoute     = "courierTypeEventAdd";
        $tCtyCode   = "";
        $tCtyName   = "";
        $tCtyRmk    = "";
    }
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddCty">
<input type="hidden" id="ohdPdtGroupRoute" value="<?php echo $tRoute; ?>">
<button style="display:none" type="submit" id="obtSubmitCty" onclick="JSoAddEditCty('<?php echo $tRoute;?>');"></button>

    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->
                    <div class="form-group">
                        <input type="hidden" value="0" id="ohdCheckCtyClearValidate" name="ohdCheckCtyClearValidate">
                        <label  class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('courier/couriertype/couriertype','tCTYTBtypeCode');?></label> <!-- เปลี่ยนชื่อ Class -->
                        <?php 
                            if($tRoute == "courierTypeEventAdd"){
                        ?>
                        <div class="form-group" id="odvCtyAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbCtyAutoGenCode" name="ocbCtyAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>   
                        </div>
                        <div class="form-group" id="odvCtyCodeForm">
                        <input 
                            type="text" 
                            class="form-control xCNGenarateCodeTextInputValidate" 
                            maxlength="5" 
                            id="oetCtyCode" 
                            name="oetCtyCode"
                            data-is-created="<?php  ?>"
                            placeholder="<?= language('courier/couriertype/couriertype','tCTYTBtypeCode')?>"
                            value="<?php  ?>" 
                            data-validate-required="<?php echo language('courier/couriertype/couriertype','tCTYValidCode')?>"
                            data-validate-dublicateCode="<?php echo language('courier/couriertype/couriertype','tCTYValidCodeDup')?>"
                            readonly
                            onfocus="this.blur()">
                            <input type="hidden" value="2" id="ohdCheckDuplicateCtyCode" name="ohdCheckDuplicateCtyCode"> 
                        </div>      
                        <?php 
                            }else{
                        ?>
                        <div class="form-group" id="odvCtyCodeForm">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                <input 
                                    type="text" 
                                    class="form-control xCNGenarateCodeTextInputValidate" 
                                    maxlength="5" 
                                    id="oetCtyCode" 
                                    name="oetCtyCode"
                                    data-is-created="<?php  ?>"
                                    placeholder="<?= language('courier/couriertype/couriertype','tCTYTBtypeCode')?>"
                                    value="<?php echo $tCtyCode; ?>" 
                                    readonly
                                    onfocus="this.blur()">
                                </label>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('courier/couriertype/couriertype','tCTYName');?></label>
                                <input type="text" class="form-control xCNInputWithoutSingleQuote" maxlength="50" id="oetCtyName" name="oetCtyName" value="<?=$tCtyName?>" 
                                data-validate-required="<?= language('courier/couriertype/couriertype','tCTYValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('courier/couriertype/couriertype','tCTYRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                            <textarea class="form-control xCNInputWithoutSpc" maxlength="100" rows="4" id="otaCtyRmk" name="otaCtyRmk"><?=$tCtyRmk?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</form>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodeCty').click(function(){
        JStGenerateCtyCode();
    });
</script>