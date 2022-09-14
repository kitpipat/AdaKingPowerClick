
<?php
if($aResult['rtCode'] == "1"){
    $tMgpCode       	= $aResult['raItems']['FTMgpCode'];
    $tMgpName       	= $aResult['raItems']['FTMgpName'];
    $tMerCode       	= $aResult['raItems']['FTMerCode'];

    //route
	$tRoute         	= "MerchantProductEventEdit";

}else{
    $tMgpCode       	= "";
    $tMgpName       	= "";
    
    //route
	$tRoute             = "MerchantProductEventAdd";
}
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtGroup">
<button style="display:none" type="submit" id="obtSubmitMgp" onclick="JSnAddEditMerchantProduct('<?= $tRoute?>')"></button>
<input type="hidden" name="ohdMerchantcode" id="ohdMerchantcode" value="<?php echo $tMerCode; ?>"/>
<div class="" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('product/merpdtgroup/merpdtgroup', 'tMGPFrmPdtCode'); ?></label>
                            <div id="odvMgpAutoGenCode" class="form-group">
                                <div class="validate-input">
                                <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbMgpAutoGenCode" name="ocbMgpAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>
                        <div id="odvMgpCodeForm" class="form-group">
                            <input type="hidden" id="ohdCheckDuplicateMgpCode" name="ohdCheckDuplicateMgpCode" value="1"> 
                                <div class="validate-input">
                                    <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                    maxlength="5" 
                                    id="oetMgpCode" 
                                    name="oetMgpCode"
                                    value="<?php echo $tMgpCode;?>"
                                    data-is-created="<?php echo $tMgpCode;?>"
                                    placeholder="<?= language('product/merpdtgroup/merpdtgroup','tMGPFrmPdtCode')?>"
                                    data-validate-required = "<?= language('product/merpdtgroup/merpdtgroup','tMGPValidCode')?>"
                                    data-validate-dublicateCode = "<?= language('product/merpdtgroup/merpdtgroup','tMGPValidCheckCode')?>"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/merpdtgroup/merpdtgroup', 'tMGPFrmPdtName'); ?></label>
                        <input class="form-control" type="text" name="oetMgpName" id="oetMgpName"  autocomplete="off" value="<?php echo $tMgpName; ?>" data-validate-required="<?= language('product/merpdtgroup/merpdtgroup', 'tMGPValidName') ?>"
                        >
                    </div>
                </div>
            </div>
        </div>        
    </form>
<?php include "script/jMerpdtgroupAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>