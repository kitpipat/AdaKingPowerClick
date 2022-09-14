<?php
if($aResult['rtCode'] == "1"){
	$tCpnCode       	= $aResult['raItems']['rtCpnCode'];
	$tCpnBarCode       	= $aResult['raItems']['rtCpnBarCode'];
	$dCpnExpired       	= $aResult['raItems']['rdCpnExpired'];
	$tCptCode       	= $aResult['raItems']['rtCptCode'];
	$tCptName       	= $aResult['raItems']['rtCptName'];
	$cCpnValue       	= $aResult['raItems']['rcCpnValue'];
	$cCpnSalePri       	= $aResult['raItems']['rcCpnSalePri'];
	$cCpnBalance     	= $aResult['raItems']['rcCpnBalance'];
	$tCpnComBook     	= $aResult['raItems']['rtCpnComBook'];
	$tCpnStaBook       	= $aResult['raItems']['rtCpnStaBook'];
	$tCpnStaSale       	= $aResult['raItems']['rtCpnStaSale'];
	$tCpnStaUse       	= $aResult['raItems']['rtCpnStaUse'];
	$tCpnName       	= $aResult['raItems']['rtCpnName'];
	$tCpnRemark       	= $aResult['raItems']['rtCpnRemark'];
	$tRoute         	= "couponEventEdit";
	
	//Event Control
	if(isset($aAlwEventCoupon)){
		if($aAlwEventCoupon['tAutStaFull'] == 1 || $aAlwEventCoupon['tAutStaEdit'] == 1){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
	}
	//Event Control
	
}else{
	$tCpnCode       	= "";
	$tCpnBarCode       	= "";
	$dCpnExpired       	= "";
	$tCptCode       	= "";
	$tCptName       	= "";
	$cCpnValue       	= "";
	$cCpnSalePri       	= "";
	$cCpnBalance     	= "";
	$tCpnComBook     	= "";
	$tCpnStaBook       	= "";
	$tCpnStaSale       	= "";
	$tCpnStaUse       	= "";
	$tCpnName       	= "";
	$tCpnRemark       	= "";
	$tRoute         = "couponEventAdd";

	$nAutStaEdit = 0; //Event Control
}
?>

<input type="hidden" id="ohdCpnAutStaEdit" value="<?=$nAutStaEdit?>">
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddCoupon">
	<button style="display:none" type="submit" id="obtSubmitCoupon" onclick="JSnAddEditCoupon('<?= $tRoute?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5">
            
                <div class="form-group">
                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('coupon/coupon/coupon','tCPNTBCpnCode')?></label>
                    <div id="odvCpnAutoGenCode" class="form-group">
                    <div class="validate-input">
                        <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbCouponAutoGenCode" name="ocbCouponAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>
                    <div id="odvCpnCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateCpnCode" name="ohdCheckDuplicateCpnCode" value="1"> 
                                <div class="validate-input">
                                <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai" 
                                maxlength="5" 
                                id="oetCpnCode" 
                                name="oetCpnCode"
                                data-is-created="<?php echo $tCpnCode;?>"
                                placeholder="<?= language('promotion/voucher/voucher','tVOCValidCode')?>"
                                value="<?php echo $tCpnCode; ?>" 
                                data-validate-required = "<?= language('promotion/voucher/voucher','tVOCValidCheckCode')?>"
                                data-validate-dublicateCode = "<?= language('promotion/voucher/voucher','tVOCValidCheckCode')?>"
                            >
                        </div>
                    </div>
                </div>

				<div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('coupon/coupon/coupon','tCPNTBCpnName')?></label>
                    <input type="text" class="form-control" maxlength="100" id="oetCpnName" name="oetCpnName" maxlength="100" value="<?= $tCpnName?>" 
                    data-validate="<?= language('coupon/coupon/coupon','tCPNValidName')?>">
                </div>

				<div class="form-group">
                    <label class="xCNLabelFrm"><?= language('coupon/coupon/coupon','tCPNTBType')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="ohdCptCode" name="ohdCptCode" value="<?=$tCptCode?>" data-validate="<?= language('payment/card/card','tCRDValiDepartment');?>">
                        <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCptName" name="oetCptName" value="<?=$tCptName?>" data-validate="<?= language('payment/card/card','tCRDValiDepartment');?>" readonly>
                        <span class="input-group-btn">
                            <button id="obtBrowseCpt" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="  <?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

				<div class="form-group">
                    <label class="xCNLabelFrm"><?= language('coupon/coupon/coupon','tCPNTBBarcode')?></label>
                    <input type="text" class="form-control" maxlength="100" id="oetCpnBarCode" name="oetCpnBarCode" maxlength="30" value="<?= $tCpnBarCode?>">
                </div>

				<div class="form-group">
                    <label class="xCNLabelFrm"><?= language('coupon/coupon/coupon','tCPNTBExpired')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetCpnExpired" name="oetCpnExpired" autocomplete="off" value="<?=$dCpnExpired?>">
                        <span class="input-group-btn">
                            <button id="obtCpnExpired" type="button" class="btn xCNBtnDateTime">
                                <img src="  <?php echo base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

				<div class="form-group">
                    <label class="xCNLabelFrm"><?= language('coupon/coupon/coupon','tCPNTBValue')?></label>
                    <input type="text" class="form-control xCNInputNumericWithDecimal text-right" id="oetCpnValue" name="oetCpnValue"  placeholder="0.00" maxlength="18" value="<?=$cCpnValue?>">
                </div>

				<div class="form-group">
                    <label class="xCNLabelFrm"><?= language('coupon/coupon/coupon','tCPNTBSalePri')?></label>
                    <input type="text" class="form-control xCNInputNumericWithDecimal text-right" id="oetCpnSalePri" name="oetCpnSalePri"  placeholder="0.00" maxlength="18" value="<?=$cCpnSalePri?>">
                </div>

				<div class="form-group">
                    <label class="xCNLabelFrm"><?= language('coupon/coupon/coupon','tCPNTBRemark')?></label>
                    <textarea class="form-control" maxlength="100" rows="4" id="otaCpnRemark" name="otaCpnRemark"><?= $tCpnRemark?></textarea>
                </div>

            </div>
        </div>
    </div>
</form>

<?php include "script/jCouponAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#oetCpnExpired').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        enableOnReadonly: false,
        startDate :'1900-01-01',
        disableTouchKeyboard : true,
        autoclose: true,
    });
    $('#oetCpnExpired').click(function(event){
        $('#oetCpnExpired').datepicker('show');
		event.preventDefault();
    });
	$('#obtCpnExpired').click(function(event){
		$('#oetCpnExpired').datepicker('show');
		event.preventDefault();
	});
    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
});

//Lang Edit In Browse
var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;
//Set Option Browse -----------
//Option Depart
var oCpnBrowseCpt = {
    Title : ['coupon/coupontype/coupontype','tCPTTitle'],
    Table:{Master:'TFNMCouponType',PK:'FTCptCode'},
    Join :{
        Table:	['TFNMCouponType_L'],
        On:['TFNMCouponType_L.FTCptCode = TFNMCouponType.FTCptCode AND TFNMCouponType_L.FNLngID = '+nLangEdits,]
    },
    Where :{
            Condition : ["AND TFNMCouponType.FTCptStaUse = 1 "]
    },
    GrideView:{
        ColumnPathLang	: 'coupon/coupontype/coupontype',
        ColumnKeyLang	: ['tCPTTBCode','tCPTTBName'],
        DataColumns		: ['TFNMCouponType.FTCptCode','TFNMCouponType_L.FTCptName'],
        ColumnsSize     : ['20%','80%'],
        DataColumnsFormat : ['',''],
        WidthModal      : 50,
        Perpage			: 10,
		OrderBy			: ['TFNMCouponType.FTCptCode'],
		SourceOrder		: "ASC"
    },
    CallBack:{
        ReturnType	: 'S',
        Value		: ["ohdCptCode","TFNMCouponType.FTCptCode"],
		Text		: ["oetCptName","TFNMCouponType_L.FTCptName"],
    },
    BrowseLev : 1
}
//Event Browse
$('#obtBrowseCpt').click(function(){JCNxBrowseData('oCpnBrowseCpt');});
</script>