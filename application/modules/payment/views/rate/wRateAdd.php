<?php
if($aResult['rtCode'] == "1"){
	$tRteCode       	= $aResult['raItems']['rtRteCode'];
	$cRteRate       	= number_format($aResult['raItems']['rcRteRate'],$nOptDecimalShow);
	$cRteFraction      	= number_format($aResult['raItems']['rcRteFraction'],$nOptDecimalShow);
	$tRteType       	= $aResult['raItems']['rtRteType'];
	$cRteTypeChg       	= $aResult['raItems']['rcRteTypeChg'];
	$cRteSign     		= $aResult['raItems']['rcRteSign'];
	$tRteStaLocal     	= $aResult['raItems']['rcRteStaLocal'];
	$tRteStaUse       	= $aResult['raItems']['rtRteStaUse'];
	$tRteName       	= $aResult['raItems']['rtRteName'];
	$tRteShtName       	= $aResult['raItems']['rtRteShtName'];
	$tRteNameText       = $aResult['raItems']['rtRteNameText'];
	$tRteDecText       	= $aResult['raItems']['rtRteDecText'];
	$cRteStaUse        	= $aResult['raItems']['rtRteStaUse'];         
	$cRteStaLocal       = $aResult['raItems']['rtRteStaLocal'];
	//Event Control
	if(isset($aAlwEventRate)){
		if($aAlwEventRate['tAutStaFull'] == 1 || $aAlwEventRate['tAutStaEdit'] == 1){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
	}
	//Event Control
	$tRoute         	= "rateEventEdit";
}else{
	$tRteCode       	= "";
	$cRteRate       	= "";
	$cRteFraction      	= "";
	$tRteType       	= "";
	$cRteTypeChg       	= "";
	$cRteSign     		= "";
	$tRteStaLocal     	= "";
	$tRteStaUse       	= "";
	$tRteName       	= "";
	$tRteShtName       	= "";
	$tRteNameText       = "";
	$tRteDecText       	= "";
	$cRteStaUse         = 1;
	$cRteStaLocal       = 1;
	$tRoute         	= "rateEventAdd";
	$nAutStaEdit = 0;	//Event Control
}
?>
<style>
.xBTNPrimeryPlus {
    border-radius: 50%;
     float: right; 
     width: 20px; 
     height: 20px; 
    line-height: 20px;
    background-color: #179BFD;
    text-align: center;
    margin-top: 3px;
    /* margin-right: -15px; */
    font-size: 29px;
    color: #ffffff;
    cursor: pointer;
    -webkit-border-radius: 50%;
}

.xRateFacBox{
	background-color: #eee;
    padding: 20px;
	border-radius: 10px;
}
</style>
<input type="hidden" id="ohdRteAutStaEdit" value="<?php echo $nAutStaEdit?>">
<input type="hidden" id="ohdRteType" value="<?php echo $tRteType?>">

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddRate">
	<button style="display:none" type="submit" id="obtSubmitRate" onclick="JSnAddEditRate('<?php echo $tRoute;?>')"></button>
	<div class="panel-body" style="padding-top:20px !important;">
		<div class="row">
			<div class="col-xs-12 col-md-4 col-lg-4">
				<?php echo FCNtHGetContentUploadImage(@$tImgObjAll,'Rate');?>
			</div>
			<div class="col-md-8">
				<button style="display:none" type="submit" id="obtSubmitPaymentMethod"></button>
				<div class="form-group">
					<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo  language('payment/rate/rate','tRTETBRteCode')?></label>
						<div id="odvRteAutoGenCode" class="form-group">
							<div class="validate-input">
							<label class="fancy-checkbox">
							<input type="checkbox" id="ocbRateAutoGenCode" name="ocbRateAutoGenCode" checked="true" value="1">
							<span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
						</label>
					</div>
				</div>

				<div id="odvRteCodeForm" class="form-group">
					<input type="hidden" id="ohdCheckDuplicateRteCode" name="ohdCheckDuplicateRteCode" value="1"> 
						<div class="validate-input">
							<input 
							type="text" 
							class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
							maxlength="5" 
							id="oetRteCode" 
							name="oetRteCode"
							value="<?php echo $tRteCode ?>"
							data-is-created="<?php echo $tRteCode ?>"
							placeholder="<?php echo  language('payment/rate/rate','tRTETBRteCode')?>"
							data-validate-required = "<?php echo  language('payment/rate/rate','tRTEValidCode')?>"
							data-validate-dublicateCode = "<?php echo  language('payment/rate/rate','tRTEValidCheckCode')?>"
							>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo  language('payment/rate/rate','tRTETBRteName')?></label> 
					<input class="form-control xWTooltipsBT" type="text" id="oetRteName" name="oetRteName" autocomplete="off"
					maxlength="100" value="<?php echo @$tRteName?>"  placeholder="<?php echo  language('payment/rate/rate','tRTETBRteName')?>"
					data-toggle="tooltip" data-validate-required = "<?php echo  language('payment/rate/rate','tRTEValidName')?>">
				</div>

				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo  language('payment/rate/rate','tRTETBSign')?></label> 
					<input class="form-control" type="text" id="oetRteSign" name="oetRteSign"
					placeholder="<?php echo language('payment/rate/rate','tRTETBSign')?>"
					maxlength="10" value="<?php echo @$cRteSign?>">
				</div>

				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo  language('payment/rate/rate','tRTETBRate')?></label> 
					<input class="form-control  xCNInputNumericWithDecimal text-right" 
					type="text" id="oetRteRate" name="oetRteRate" 
					placeholder="0.00"
					maxlength="18"
					value="<?php echo @$cRteRate?>">
				</div>

				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo language('payment/rate/rate','tRTETBType')?></label>
					<select class="selectpicker form-control" id="ocmRteType" name="ocmRteType" maxlength="1">
						<!-- <option value=""><?php echo  language('common/main/main', 'tCMNBlank-NA') ?></option> -->
						<option value="1"><?php echo  language('payment/rate/rate', 'tRTETBTypeSeq1') ?></option>
						<option value="2"><?php echo  language('payment/rate/rate', 'tRTETBTypeSeq2') ?></option>
						<option value="3"><?php echo  language('payment/rate/rate', 'tRTETBTypeSeq3') ?></option>
						<option value="4"><?php echo  language('payment/rate/rate', 'tRTETBTypeSeq4') ?></option>
						<option value="5"><?php echo  language('payment/rate/rate', 'tRTETBTypeSeq5') ?></option>
					</select>
				</div>

				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo  language('payment/rate/rate','tRTETBFraction')?></label> 
					<input class="form-control  xCNInputNumericWithDecimal text-right" type="text" 
					id="oetRteFraction" name="oetRteFraction" 
					placeholder="0.00"
					maxlength="18" value="<?php echo @$cRteFraction?>">
				</div>


				<div class="form-group xRateFacBox"  > 
				<label class="xCNLabelFrm"><?php echo  language('payment/rate/rate','tRteUnit')?></label> 
				<button class="xBTNPrimeryPlus" type="button" style="padding-botton:20px" onclick="JSvAddRateUnitFac()">+</button>

							<div class="row" id="odvRteUnitContent">
							<?php
							if(!empty($aRateUnit)){
								foreach($aRateUnit as $nKey => $aRateUnit){
									$nSeq = $nKey+1;
							?>
								<div class="col-md-3 odvRateUnitFac" id="odvRateUnitFac_<?=$nSeq?>">
									<div class="input-group">
										<input class="form-control  xCNInputNumericWithDecimal text-right" type="text" 
												name="oetRtuFac[]" 
												placeholder="0.00"
												maxlength="18" value="<?=round($aRateUnit['FCRtuFac'],$nOptDecimalShow)?>">
											<span class="input-group-btn">
												<button type="button" class="btn xCNBtnDateTime"   onclick="JSxRateUnitRemove(<?=$nSeq?>)">
													<img src="<?=base_url('/')?>/application/modules/common/assets/images/icons/delete.png" width="15px">
												</button>
											</span>
											</div>
								</div>
							<?php
									}
								}
							?>


							</div>


				</div>


				<div class="form-group" > 
							<div class="col-md-3">
							<label class="fancy-checkbox">
								<input id="" type="checkbox" class="" name="ocmRteStaUse" value="1" <?php if($cRteStaUse==1){ echo 'checked'; }  ?>>
								<span>&nbsp;<label class="xCNLabelFrm"><?php echo  language('payment/rate/rate','tRteStaUse')?></label> </span>
							</label>
							</div>
							<div class="col-md-3">
							<label class="fancy-checkbox">
								<input id="" type="checkbox" class="" name="ocmRteStaLocal" value="1" <?php if($cRteStaLocal==1){ echo 'checked'; }  ?>>
								<span>&nbsp;<label class="xCNLabelFrm"><?php echo  language('payment/rate/rate','tRteStaLocal')?></label> </span>
							</label>
					</div>
				</div>
			
			</div>
		</div>
	</div>
</form>
<!-- div Dropdownbox -->
<div id="dropDownSelect1"></div>
<?php include "script/jRateAdd.php"; ?>
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
$(document).ready(function(){

	$('.selectpicker').selectpicker();

    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
	$('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
	
});






function JSvAddRateUnitFac(){
	var nSeqUnit = ($('.odvRateUnitFac').length)+1;

		var tMarkUp ='';
			tMarkUp	 += '<div class="col-md-3" id="odvRateUnitFac_'+nSeqUnit+'">';
			tMarkUp	 += '<div class="input-group">';
			tMarkUp	 +=	'<input class="form-control  xCNInputNumericWithDecimal text-right" type="text" name="oetRtuFac[]" placeholder="0.00" maxlength="18" value="0.00">';
			tMarkUp	 +=	'<span class="input-group-btn">';
			tMarkUp	 +=	'<button type="button" class="btn xCNBtnDateTime" onclick="JSxRateUnitRemove('+nSeqUnit+')" >';
			tMarkUp	 +=	'<img src="<?=base_url('/')?>/application/modules/common/assets/images/icons/delete.png" width="15px">';
			tMarkUp	 +=	'</button>';
			tMarkUp	 +=	'</span>';
			tMarkUp	 +=	'</div>';
			tMarkUp	 +=	'</div>';

			$('#odvRteUnitContent').append(tMarkUp);
}


function JSxRateUnitRemove(pnSeq){
	$('#odvRateUnitFac_'+pnSeq).remove();
}
//Lang Edit In Browse
var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;
//Set Option Browse -----------
//Option Depart
var oRteBrowseRtu = {
    Title : ['pos5/ratetype','tCPTTitle'],
    Table:{Master:'TFNMRateType',PK:'FTRtuCode'},
    Join :{
        Table:	['TFNMRateType_L'],
        On:['TFNMRateType_L.FTRtuCode = TFNMRateType.FTRtuCode AND TFNMRateType_L.FNLngID = '+nLangEdits,]
    },
    GrideView:{
        ColumnPathLang	: 'pos5/ratetype',
        ColumnKeyLang	: ['tCPTTBCode','tCPTTBName'],
        DataColumns		: ['TFNMRateType.FTRtuCode','TFNMRateType_L.FTRtuName'],
        ColumnsSize     : ['20%','80%'],
        DataColumnsFormat : ['',''],
        WidthModal      : 50,
        Perpage			: 10,
		OrderBy			: ['TFNMRateType.FTRtuCode'],
		SourceOrder		: "ASC"
    },
    CallBack:{
        ReturnType	: 'S',
        Value		: ["ohdRtuCode","TFNMRateType.FTRtuCode"],
		Text		: ["oetRtuName","TFNMRateType_L.FTRtuName"],
    },
    BrowseLev : 1
}
//Event Browse
$('#oimRteBrowseRtu').click(function(){JCNxBrowseData('oRteBrowseRtu');});
</script>