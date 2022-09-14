<?php 

if($aResult['rtCode'] == "1"){
    $tVstType       = $aResult['raItems']['rtVstType'];
    $tVstName       = $aResult['raItems']['rtVstName'];
    $tVstTempAgg    = $aResult['raItems']['rtVstTempAgg'];
    $tVstTempMax    = $aResult['raItems']['rtVstTempMax'];
    $tVstTempMin    = $aResult['raItems']['rtVstTempMin'];
    $tVstRemark     = $aResult['raItems']['rtVstRemark'];
    $tRoute         = "VendingShopTypeEventEdit";
    $tTypePage      = 'Edit';
}else{
    $tVstType       = 1;
    $tVstName       = "";
    $tVstTempAgg    = "0";
    $tVstTempMax    = "0";
    $tVstTempMin    = "0";
    $tVstRemark     = "";
    $tRoute         = "VendingShopTypeEventAdd";
    $tTypePage      = 'Add';
}

?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddVendingShopType">
	<button style="display:none" type="submit" id="obtSubmitVendingShopType" onclick="JSnAddEditVendingShopType('VendingShopTypeEventAdd')"></button>
	<div class=""  style="padding-top:0px !important;">

		<div class="row">
            <div style="clear: both;"></div>
			<div class="col-xs-12 col-md-4 col-lg-4">

                <input type="text" class="form-control xCNHide" id="ohdTypepage" name="ohdTypepage" value="<?=@$tTypePage?>">
                <div class="form-group">
					<div class="validate-input" data-validate="Please Insert Name">
						<label class="xCNLabelFrm">
                            <span style="color:red">*</span>
                            <?=language('vending/vendingshoptype/vendingshoptype','tVstName')?>
                        </label>
						<input type="text" class="form-control" maxlength="255"  id="oetVstName" name="oetVstName" value="<?= $tVstName?>" data-validate="<?php echo language('vending/vendingshoptype/vendingshoptype','tVstValidName')?>">
					</div>
				</div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('vending/vendingshoptype/vendingshoptype','tVstTypeVending')?></label>
                    <select class="selectpicker form-control" id="ocmSelectSrcType" name="ocmSelectSrcType">
                        <option value="1" <?= ($tVstType == 1)? 'selected':''?> ><?= language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending01')?></option>
                        <!-- <option value="2" <?= ($tVstType == 2)? 'selected':''?> ><?= language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending02')?></option> -->
                        <!-- <option value="3" <?= ($tVstType == 3)? 'selected':''?> ><?= language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending03')?></option> -->
                    </select>
                </div>

                <div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><?= language('vending/vendingshoptype/vendingshoptype','tVstTempAgg')?></label>
						<input type="text" style="text-align: right;" class="form-control xCNInputVandingTemperature" maxlength="6"  id="oetVstTempAgg" name="oetVstTempAgg" value="<?= $tVstTempAgg?>">
					</div>
				</div>

                <div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><?= language('vending/vendingshoptype/vendingshoptype','tVstTempMin')?></label>
						<input type="text" style="text-align: right;" class="form-control xCNInputVandingTemperature" maxlength="6"  id="oetVstTempMin" name="oetVstTempMin" value="<?= $tVstTempMin?>">
					</div>
				</div>

                <div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><?= language('vending/vendingshoptype/vendingshoptype','tVstTempMax')?></label>
						<input type="text" style="text-align: right;" class="form-control xCNInputVandingTemperature" maxlength="6"  id="oetVstTempMax" name="oetVstTempMax" value="<?= $tVstTempMax?>">
					</div>
				</div>

			</div>

            <div class="col-xs-12 col-md-8 col-lg-8">
				<div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><?= language('vending/vendingshoptype/vendingshoptype','tVstRemark')?></label>
						<textarea class="input100" style="resize: none; padding: 10px;" rows="10" maxlength="255" id="otaVstRemark" name="oetVstRemark" placeholder="<?= language('vending/vendingshoptype/vendingshoptype','tVstRemarkplaceholder')?>"><?= $tVstRemark?></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    // var tTypePage = '<?=$tTypePage?>';
    // if(tTypePage == 'Add'){
    //     $('#obtBTNInsertTypevending').css('display','block');
    //     $('#obtBTNUpdateTypevending').css('display','none');
    // }else if(tTypePage == 'Edit'){
    //     $('#obtBTNUpdateTypevending').css('display','block');
    //     $('#obtBTNInsertTypevending').css('display','none');
    // }

    $('#ocmSelectSrcType').selectpicker();
</script>