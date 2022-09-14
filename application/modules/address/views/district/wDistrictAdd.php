<?php
if($aResult['rtCode'] == "1"){
    $tDstCode       = $aResult['raItems']['rtDstCode'];
    $tDstName       = $aResult['raItems']['rtDstName'];
    $tDstPost       = $aResult['raItems']['rtDstPost'];
    $tDstPvnCode    = $aResult['raItems']['rtPvnCode'];
    $tDstPvnName    = $aResult['raItems']['rtPvnName'];
    $tRoute         = "districtEventEdit";
}else{
    $tDstCode       = "";
    $tDstName       = "";
    $tDstPost       = "";
    $tDstPvnCode    = "";
    $tDstPvnName    = "";
    $tRoute         = "districtEventAdd";
}
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddDistrict">
	<button style="display:none" type="submit" id="obtSubmitDistrict" onclick="JSnAddEditDistrict('<?php echo $tRoute?>')"></button>
	<div class="panel-body" style="padding-top:20px !important;">
		<div class="row">
			<div class="col-xs-12 col-md-5 col-lg-5">
				<label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('address/district/district','tDSTCode')?></label>
					<div class="form-group" id="odvDstAutoGenCode">
						<div class="validate-input">
							<label class="fancy-checkbox" id="odvDistrictAutoGenCode">
								<input type="checkbox" id="ocbDstAutoGenCode" name="ocbDstAutoGenCode" checked="true" value="1">
								<span><?php echo language('common/main/main', 'tGenerateAuto');?></span>
							</label>
						</div>
					</div>

					<div class="form-group" id="odvDstCodeForm">
						<input type="hidden" value="1" id="ohdCheckDuplicateDstCode" name="ohdCheckDuplicateDstCode" value="1">
						<div class="validate-input">
							<input
								type="text"
								class="form-control xCNInputWithoutSpcNotThai"
								maxlength="5"
								id="oetDstCode"
								name="oetDstCode"
								data-is-created="<?php echo $tDstCode; ?>"
								placeholder ="#####"
								value="<?php echo $tDstCode; ?>"
								data-validate-required="<?php echo language('address/district/district','tDSTValiCode');?>"
								data-validate-dublicateCode="<?=language('address/district/district','tDSTValiDst');?>"
								>
						</div>
					</div>
					
					<div class="form-group">
						<div class="validate-input">
						<label class="xCNLabelFrm"><?= language('address/district/district','tDSTName')?></label>
							<input
								type="text"
								class="form-control xCNInputWithoutSpc"
								maxlength="200"
								id="oetDstName"
								name="oetDstName"
								value="<?php echo $tDstName?>"
								data-validate-required="<?php echo language('other/reason/reason','tDstValidName')?>"
							>
						</div>
					</div>

					<div class="form-group">
						<div class=" validate-input" data-validate="Please Insert PostCode">
							<label class="xCNLabelFrm"><?php echo language('address/district/district','tDSTPostCode')?></label>
							<input type="text" maxlength="10" class=" xCNInputNumericWithoutDecimal"  id="oetDstPost" name="oetDstPost" value="<?php echo $tDstPost?>">
							<span class="focus-"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/district/district','tDSTProvince')?></label>
						<div class="input-group">
							<input type="text" class="form-control xCNHide" id="oetDstPvncode" name="oetDstPvncode" value="<?php echo $tDstPvnCode?>">
							<input type="text" class="form-control xWPointerEventNone" id="oetDstPvnName" name="oetDstPvnName" value="<?php echo $tDstPvnName?>" readonly data-validate="<?php echo language('address/district/district','tDSTValiProvince')?>">
							<span class="input-group-btn">
								<button id="oimDstBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
									<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
								</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-5 col-lg-5">
			</div>
		</div>

	</div>
</form>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<?php include "script/jDistrictAdd.php"; ?>


<script type="text/javascript">
$('.xWTooltipsBT').tooltip({'placement': 'bottom'});
$('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

// Lang Browse Province
var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;
//Set Option Browse Province
var oPvnOption = {
	Title : ['address/district/district','tBrowsePVNTitle'],
	Table:{Master:'TCNMProvince',PK:'FTPvnCode'},
	Join :{
		Table:	['TCNMProvince_L'],
		On:['TCNMProvince_L.FTPvnCode = TCNMProvince.FTPvnCode AND TCNMProvince_L.FNLngID = '+nLangEdits,]
	},
	GrideView:{
		ColumnPathLang	: 'address/district/district',
		ColumnKeyLang	: ['tBrowsePVNCode','tBrowsePVNName'],
		DataColumns		: ['TCNMProvince.FTPvnCode','TCNMProvince_L.FTPvnName'],
		Perpage			: 10,
		OrderBy			: ['TCNMProvince.FTPvnCode'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Text		: ["oetDstPvnName","TCNMProvince_L.FTPvnName"],
		Value		: ["oetDstPvncode","TCNMProvince.FTPvnCode"],
	},
	NextFunc:{
		FuncName:'JSxNextFuncDistrictParent',
		ArgReturn:['FTPvnCode']
	},
	RouteAddNew : 'province',
	BrowseLev : nStaDstBrowseType
}

function JSxNextFuncDistrictParent(){
	$('#oetDstPvnName').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
	$('#oetDstPvnName').closest('.form-group').find(".help-block").fadeOut('slow').remove();
}

$('#oimDstBrowseProvince').click(function(){
	JCNxBrowseData('oPvnOption');
});
</script>