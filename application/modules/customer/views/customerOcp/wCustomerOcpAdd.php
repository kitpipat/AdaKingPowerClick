<?php
if($aResult['rtCode'] == "1"){
    $tCstOcpCode    = $aResult['raItems']['rtCstOcpCode'];
    $tCstOcpName    = $aResult['raItems']['rtCstOcpName'];
    $tCstOcpRmk     = $aResult['raItems']['rtCstOcpRmk'];
    $tRoute         = "customerOcpEventEdit";
}else{
    $tCstOcpCode    = "";
    $tCstOcpName    = "";
    $tCstOcpRmk     = "";
    $tRoute         = "customerOcpEventAdd";
}
?>
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCstOcp">
    <button style="display:none" type="submit" id="obtSubmitCstOcp" onclick="JSnAddEditCstOcp('<?= $tRoute?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('customer/customerOcp/customerOcp','tCstOcpCode'); ?><?= language('customer/customerOcp/customerOcp','tCstOcpTitle')?></label>
                    <div id="odvCstOcpAutoGenCode" class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbCstOcpAutoGenCode" name="ocbCstOcpAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>
                    <div id="odvCustomerOcpCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateCstOcpCode" name="ohdCheckDuplicateCstOcpCode" value="1"> 
                        <div class="validate-input">
                            <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai" 
                                maxlength="5" 
                                id="oetCstOcpCode" 
                                name="oetCstOcpCode"
                                data-is-created="<?php echo $tCstOcpCode;?>"
                                placeholder="<?= language('customer/customerOcp/customerOcp','tCstOcpValidCode')?>"
                                value="<?php echo $tCstOcpCode; ?>" 
                                data-validate-required = "<?= language('customer/customerOcp/customerOcp','tCstOcpValidCheckCode')?>"
                                data-validate-dublicateCode = "<?= language('customer/customerOcp/customerOcp','tCstOcpValidCheckCode')?>"
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="validate-input" data-validate="Please Insert Name">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('customer/customerOcp/customerOcp','tCstOcpName')?></label>
                        <input type="text" class="input100 xCNInputWithoutSpc" maxlength="100" id="oetCstOcpName" name="oetCstOcpName" value="<?= $tCstOcpName ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm">หมายเหตุ</label>
                                <textarea maxlength="100" rows="4" id="otaCstOcpRemark" name="otaCstOcpRemark"><?= $tCstOcpRmk ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js');?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js');?>"></script>
<?php include "script/jCustomerOcpAdd.php"; ?>
