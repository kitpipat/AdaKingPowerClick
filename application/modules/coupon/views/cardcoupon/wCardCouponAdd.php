<?php
// print_r($aResult['raItems']);
if($aResult['rtCode'] == "1"){
	$tCclCode       	= $aResult['raItems']['rtCclCode'];
    $tCclName       	= $aResult['raItems']['rtCclName'];
    $tCclAmt    	    = $aResult['raItems']['rtCclAmt'];
    $dCclStartDate      = $aResult['raItems']['rdCclStartDate'];;
    $dCclEndDate      	= $aResult['raItems']['rdCclEndDate'];;
    $tCclStaUse    	    = $aResult['raItems']['rtCclStaUse'];
    $tCclPrnCond        = $aResult['raItems']['rtCclPrnCond'];

	$tRoute         	= "CardCouponEventEdit";

	//Event Control
	if(isset($aAlwEventVoucher)){
		if($aAlwEventVoucher['tAutStaFull'] == 1 || $aAlwEventVoucher['tAutStaEdit'] == 1){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
	}
	//Event Control
	
}else{
    $tCclCode       	= "";
	$tCclName       	= "";
    $tCclAmt     	    = "";
    $dCclStartDate      = "";
    $dCclEndDate      	= "";
    $tCclStaUse         = "";
    $tCclPrnCond        = "";

	$tRoute             = "CardCouponEventAdd";
	$nAutStaEdit        = 0; //Event Control
}
if($tCclStaUse == ""){$tCclStaUse == 1;}
?>
<input type="hidden" id="ohdCclAutStaEdit" value="<?=$nAutStaEdit?>">
    <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddCardCoupon">
        <button style="display:none" type="submit" id="obtSubmitCoupontype" onclick="JSnAddEditCardCoupon('<?= $tRoute?>')"></button>
            <div class="panel-body" style="padding-top:20px !important;">
                <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-6">
                    <button style="display:none" type="submit" id="obtSubmitPaymentMethod"></button>	
                        <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('coupon/cardcoupon/cardcoupon','tCPNTBCode')?><?= language('coupon/cardcoupon/cardcoupon','tCPNTitle')?></label>
                        <div id="odvCardCouponAutoGenCode" class="form-group">
                        <div class="validate-input">
                        <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbCardCouponAutoGenCode" name="ocbCardCouponAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>
                    <div id="odvCardCouponCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateCptCode" name="ohdCheckDuplicateCptCode" value="1">  
                                <div class="validate-input">
                                <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai" 
                                maxlength="5" 
                                id="oetCclCode" 
                                name="oetCclCode"
                                data-is-created="<?php echo $tCclCode;?>"
                                placeholder="<?= language('coupon/coupontype/coupontype' ,'tCptValidCode')?>"
                                value="<?= $tCclCode; ?>" 
                                data-validate-required = "<?= language('coupon/coupontype/coupontype','tCPTValidCheckCode')?>"
                                data-validate-dublicateCode = "<?= language('coupon/coupontype/coupontype','tCPTValidCheckCode')?>"
                            >
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('coupon/coupontype/coupontype','tCPNName')?><?= language('coupon/coupontype/coupontype','tCPNTitle')?></label>
                    <input type="text" class="form-control xWTooltipsBT" maxlength="100" id="oetCclName" name="oetCclName" maxlength="100" value="<?= $tCclName?>" data-toggle="tooltip" data-validate="<?= language('coupon/coupontype/coupontype','tCPNName')?>">
                </div>
                
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('coupon/cardcoupon/cardcoupon','tCPNTBValue')?></label>
                    <input type="text" class="form-control xCNInputNumericWithDecimal text-right" id="oetCclAmt" name="oetCclAmt"  placeholder="0.00" maxlength="18" value="<?=$tCclAmt?>">
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('coupon/cardcoupon/cardcoupon','tCPNTBDateStart')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetCclStartDate" name="oetCclStartDate" autocomplete="off" value="<?=$dCclStartDate?>">
                        <span class="input-group-btn">
                            <button id="obtCclDateStart" type="button" class="btn xCNBtnDateTime">
                                <img src="  <?php echo base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('coupon/cardcoupon/cardcoupon','tCPNTBExpired')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetCclEndDate" name="oetCclEndDate" autocomplete="off" value="<?=$dCclEndDate?>">
                        <span class="input-group-btn">
                            <button id="obtCclEndDate" type="button" class="btn xCNBtnDateTime">
                                <img src="  <?php echo base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="validate-input">
                        <label class="xCNLabelFrm"><?php echo language('coupon/cardcoupon/cardcoupon','tCPNCondition')?></label>
                        <textarea class="form-control" maxlength="100" rows="4" id="otaCclPrnCond" name="otaCclPrnCond"><?= $tCclPrnCond?></textarea>
                    </div>
                </div>
                
				<div class="form-group">
                <?php 
                    if  (!isset($tCclStaUse) || $tCclStaUse != 1 )  : ?>
                    <input type="checkbox" id="ocbCclcheck" name="ocbCclcheck"  value="1"> 
                <?php else: ?> 
                    <input type="checkbox" id="ocbCclcheck" name="ocbCclcheck" checked="true" value="<?=$tCclStaUse?>"> 
                <?php endif; ?>
                    <?= language('promotion/voucher/vouchertype','tVOTTBUsing')?>
                </div>
            </div>
        </div>
    </div>
</form>
<?php include "script/jCardCouponAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

    $('#oetCclEndDate').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        enableOnReadonly: false,
        startDate :'1900-01-01',
        disableTouchKeyboard : true,
        autoclose: true,
    });

    $('#oetCclEndDate').click(function(event){
        $('#oetCclEndDate').datepicker('show');
		event.preventDefault();
    });
	$('#obtCclEndDate').click(function(event){
		$('#oetCclEndDate').datepicker('show');
		event.preventDefault();
    });


    $('#oetCclStartDate').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        enableOnReadonly: false,
        startDate :'1900-01-01',
        disableTouchKeyboard : true,
        autoclose: true,
    });
    $('#oetCclStartDate').click(function(event){
        $('#oetCclStartDate').datepicker('show');
		event.preventDefault();
    });
	$('#obtCclDateStart').click(function(event){
		$('#oetCclStartDate').datepicker('show');
		event.preventDefault();
	});
    
});

//Lang Edit In Browse
var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;
//Set Option Browse -----------
//Option Depart
var oVocBrowseVot = {
    Title : ['coupon/coupontype/coupontype','tVOTTitle'],
    Table:{Master:'TFNMCouponType',PK:'FTCptCode'},
    Join :{
        Table:	['TFNMCouponType_L'],
        On:['TFNMCouponType_L.FTCptCode = TFNMCouponType.FTCptCode AND TFNMCouponType_L.FNLngID = '+nLangEdits,]
    },
    GrideView:{
        ColumnPathLang	: 'promotion/voucher/vouchertype',
        ColumnKeyLang	: ['FTCptCode','FTCptName'],
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
$('#obtVocBrowseVot').click(function(){JCNxBrowseData('oVocBrowseVot');});
</script>