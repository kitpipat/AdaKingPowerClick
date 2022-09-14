<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdtpromotionEventEdit";
        $tPmgCode   = $aPmgData['raItems']['rtPmgCode'];
        $tPmgName   = $aPmgData['raItems']['rtPmgName'];
        $tPmgRmk    = $aPmgData['raItems']['rtPmgRmk'];
    }else{
        $tRoute     = "pdtpromotionEventAdd";
        $tPmgCode   = "";
        $tPmgName   = "";
        $tPmgRmk    = "";
    }
?>


<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtPmtGrp">
    <button style="display:none" type="submit" id="obtSubmitPdtPmgGrp" onclick="JSoAddEditPdtPmgGrp('<?php echo $tRoute?>')"></button>
    <input type="hidden" id="ohdPdtPromotionRoute" value="<?php echo $tRoute; ?>">
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5">
                <div class="form-group">
                    <input type="hidden" value="0" id="ohdCheckPmtClearValidate" name="ohdCheckPmtClearValidate"> 
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdtpromotion/pdtpromotion','tPMGFrmPmgCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                    <?php
                    if($tRoute == "pdtpromotionEventAdd"){ ?>
                        <div class="form-group" id="odvPunAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbPmtAutoGenCode" name="ocbPmtAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="odvPmtCodeForm">
                            <input 
                                type="text" 
                                class="form-control" 
                                maxlength="5" 
                                id="oetPmtCode" 
                                name="oetPmtCode"
                                data-is-created=""
                                placeholder="<?php echo language('product/pdtpromotion/pdtpromotion','tPMGFrmPmgCode')?>"
                                value="" 
                                data-validate-required="<?php echo language('product/pdtpromotion/pdtpromotion','tPMGValidCode')?>"
                                data-validate-dublicateCode="<?php echo language('product/pdtpromotion/pdtpromotion','tPMGVldCodeDuplicate')?>"
                                readonly
                                onfocus="this.blur()">
                            <input type="hidden" value="2" id="ohdCheckDuplicatePmtCode" name="ohdCheckDuplicatePmtCode"> 
                        </div>
                    <?php }else{ ?>
                        <div class="form-group" id="odvPmtCodeForm">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    maxlength="5" 
                                    id="oetPmtCode" 
                                    name="oetPmtCode"
                                    data-is-created="<?php $tPmgCode;?>"
                                    placeholder="<?php echo language('product/pdtpromotion/pdtpromotion','tPMGFrmPmgCode')?>"
                                    value="<?php echo $tPmgCode;?>" 
                                    readonly
                                    onfocus="this.blur()">
                                </label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdtpromotion/pdtpromotion','tPMGFrmPmgName')?></label> <!-- เปลี่ยนชื่อ Class -->
                    <input type="text" class="form-control" maxlength="50" id="oetPmtName" name="oetPmtName" value="<?php echo $tPmgName;?>" 
                    data-validate-required="<?php echo language('product/pdtpromotion/pdtpromotion','tPMGValidName');?>"> 
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtpromotion/pdtpromotion','tPMGFrmPmgRmk');?></label>
                    <textarea class="form-control" maxlength="100" rows="4" id="otaPmgRmk" name="otaPmgRmk"><?php echo $tPmgRmk;?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtPmgGrp').click(function(){
        JStGeneratePdtPmgGrpCode();
    });
</script>