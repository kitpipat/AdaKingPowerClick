<?php 
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        
        $tRoute         =  "CabinetTypeEventEdit";

        $tShtCode       = $aCBNData['raItems']['rtShtCode'];
        $tShtName       = $aCBNData['raItems']['rtShtName'];
        $tStatusType    = $aCBNData['raItems']['rtShtType'];
        $tCBNTempAgg    = $aCBNData['raItems']['rtShtValue'];
        $tCBNTempMin    = $aCBNData['raItems']['rtShtMin'];
        $tCBNTempMax    = $aCBNData['raItems']['rtShtMax'];
        $tCBNRemark     = $aCBNData['raItems']['rtShtReMark'];

    }else{

        $tShtCode       = "";
        $tShtName       = "";
        $tStatusType    = 1;
        $tCBNTempAgg    = "0";
        $tCBNTempMin    = "0";
        $tCBNTempMax    = "0";
        $tCBNRemark     = "";

        $tRoute         =  "CabinetTypeEventAdd";
    }
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddCabinetType">
    <button style="display:none" type="submit" id="obtSubmitCabinetType" onclick="JSoAddEditCabinetType('<?php echo $tRoute?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
        <!-- รหัสตู้ -->
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5">
                <label class="xCNLabelFrm"><span style="color:red">* </span><?php echo language('vending/cabinettype/cabinettype','tCBNCode')?></label> 

                <div id="odvCabinetTypeAutoGenCode" class="form-group">
					<div class="validate-input">
						<label class="fancy-checkbox">
							<input type="checkbox" id="ocbCabinetTypeAutoGenCode" name="ocbCabinetTypeAutoGenCode" checked="true" value="1">
							<span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
						</label>
					</div>
				</div>

                <div id="odvCabinetTypeCodeForm" class="form-group">
					<input type="hidden" id="ohdCheckDuplicateRsnCode" name="ohdCheckDuplicateCBNCode" value="1"> 
					<div class="validate-input">
						<input 
							type="text" 
							class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
							maxlength="5" 
							id="oetCBNCode" 
							name="oetCBNCode"
							data-is-created="<?php echo @$tShtCode; ?>"
							placeholder="<?php echo language('vending/cabinettype/cabinettype','tCBNCode')?>";
							value="<?php echo @$tShtCode; ?>" 
                            data-validate-required = "<?php echo language('vending/cabinettype/cabinettype','tCBNValidCode')?>"
                            data-validate-dublicateCode ="<?php echo language('vending/cabinettype/cabinettype','tCBNValidCodeDup');?>"
						>
					</div>
				</div>
            
                <!-- ชื่อตู้สินค้า -->
                <div class="form-group">
                    <div class="validate-input">
                        <label class="xCNLabelFrm"><span style="color:red">* </span><?php echo language('vending/cabinettype/cabinettype','tCBNName')?></label> 
                        <input
                            type = "text"
                            class= "form-control"
                            id ="oetCBNName"
                            name="oetCBNName"
                            value="<?php echo @$tShtName;?>"
                            data-validate-required = "<?php echo language('vending/cabinettype/cabinettype','tCBNValidName')?>"
                        >
                    </div>
                </div>

                <!-- ประเภทตู้เย็น -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('vending/cabinettype/cabinettype','tCBNCabinettype')?></label>
                    <select class="selectpicker form-control" id="ocmSelectSrcType" name="ocmSelectSrcType">
                        <option value="1" <?= ($tStatusType == 1)? 'selected':''?> ><?= language('vending/cabinettype/cabinettype','tCBNCool')?></option>
                        <option value="2" <?= ($tStatusType == 2)? 'selected':''?> ><?= language('vending/cabinettype/cabinettype','tCBNHeatCabinet')?></option>
                        <!-- <option value="3" <?= ($tStatusType == 3)? 'selected':''?> ><?= language('vending/cabinettype/cabinettype','tCBNHeatCool')?></option> -->
                    </select>
                </div>

                <!-- อุณหภูมิเฉลี่ย -->
                <div class="form-group">
                    <div class="validate-input">
                        <label class="xCNLabelFrm"><?= language('vending/cabinettype/cabinettype','tCBNTempAgg')?></label>
                        <input type="text" style="text-align: right;" class="form-control xCNInputVandingTemperature" maxlength="6"  id="oetCBNTempAgg" name="oetCBNTempAgg" value="<?php echo @$tCBNTempAgg;?>">
                    </div>
                </div>
                
                <!-- อุณหภูมิต่ำสุด (องศาเซลเซียส) -->
                <div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><?= language('vending/cabinettype/cabinettype','tCBNTempMin')?></label>
						<input type="text" style="text-align: right;" class="form-control xCNInputVandingTemperature" maxlength="6"  id="oetCBNTempMin" name="oetCBNTempMin" value="<?php echo @$tCBNTempMin; ?>">
					</div>
				</div>

                <!-- อุณหภูมิสูงสุด (องศาเซลเซียส) -->
                <div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><?= language('vending/cabinettype/cabinettype','tCBNTempMax')?></label>
						<input type="text" style="text-align: right;" class="form-control xCNInputVandingTemperature" maxlength="6"  id="oetCBNTempMax" name="oetCBNTempMax" value="<?= @$tCBNTempMax?>">
					</div>
				</div>
            </div><br>
            <div class="col-xs-12 col-md-6 col-lg-6">
                <!-- หมายเหตุ -->
                <div class="form-group">
                    <div class="validate-input">
                        <label class="xCNLabelFrm"><?= language('vending/cabinettype/cabinettype','tCBNRemark')?></label>
                        <textarea class="input100" style="resize: none; padding: 10px;" rows="10" maxlength="255" id="oetCBNRemark" name="oetCBNRemark" placeholder="<?= language('vending/vendingshoptype/vendingshoptype','tVstRemarkplaceholder')?>"><?= @$tCBNRemark?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jCabinetTypeAdd.php"; ?>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>

<script type="text/javascript">
    $('#ocmSelectSrcType').selectpicker();
</script>