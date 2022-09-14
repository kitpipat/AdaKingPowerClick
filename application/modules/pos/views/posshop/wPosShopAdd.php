<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdtlocationEventEdit"; 
        $tPlcCode   = $aLocData['raItems']['rtPlcCode'];
        $tPlcName   = $aLocData['raItems']['rtPlcName'];
        $tPlcRmk    = $aLocData['raItems']['rtPlcRmk'];
    }else{
        $tRoute     = "pdtlocationEventAdd";
        $tPlcCode   = "";
        $tPlcName   = "";
        $tPlcRmk    = "";
    }
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtLoc">
    <button style="display:none" type="submit" id="obtSubmitPdtLoc" onclick="JSoAddEditPdtLoc('<?= $tRoute?>')"></button>
    <div class="panel panel-headline">
        <div class="panel-body" style="padding-top:20px !important;">
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtlocation/pdtlocation','tLOCFrmLocCode')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNInputNumericWithoutDecimal" maxlength="5" id="oetPlcCode" name="oetPlcCode" placeholder="#####" value="<?=$tPlcCode?>"
                            data-validate="<?= language('product/pdtlocation/pdtlocation','tLOCValidCode')?>">
                            <span class="input-group-btn">
                                <button id="obtGenCodePdtLoc" class="btn xCNBtnGenCode" type="button">
                                    <i class="fa fa-magic"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtlocation/pdtlocation','tLOCFrmLocName')?></label>
                        <input type="text" class="form-control" maxlength="50" id="oetPlcName" name="oetPlcName" value="<?=$tPlcName?>" 
                        data-validate="<?= language('product/pdtlocation/pdtlocation','tLOCValidName')?>">
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/pdtlocation/pdtlocation','tLOCFrmLocRmk')?></label>
                        <textarea class="form-control" maxlength="100" rows="4" id="otaPlcRmk" name="otaPlcRmk"><?=$tPlcRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtLoc').click(function(){
        JStGeneratePdtLocCode();
    });
</script>