<?php 
if($aResult['rtCode'] == 1){
    $tRsnCode   = $aResult['raItems']['rtRsnCode'];
    $tRsnName   = $aResult['raItems']['rtRsnName'];
    $tRsnRemark = $aResult['raItems']['rtRsnRmk'];
	$tRsnRefID  = $aResult['raItems']['FTRsnRefID'];
    $tSelected  = $aResult['rtSelected'];
	$tRoute     = "reasonEventEdit";
	
	$tRSNAgnCode       = $aResult['raItems']['rtAgnCode'];
    $tRSNAgnName       = $aResult['raItems']['rtAgnName'];


}else{
    $tRsnCode   = "";
    $tRsnName   = "";
    $tRsnRemark = "";
	$tRsnRefID  = "";
    $tSelected  = $aResult['rtSelected'];
	$tRoute     = "reasonEventAdd";
	

	$tRSNAgnCode       = $tSesAgnCode;
    $tRSNAgnName       = $tSesAgnName;
}
?>
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddReason">
	<button style="display:none" type="submit" id="obtSubmitReason" onclick="JSnAddEditReason('<?php echo $tRoute?>')"></button>
	<div class="panel-body"  style="padding-top:20px !important;">
	
		<div class="row">
			<div class="col-xs-12 col-md-5 col-lg-5">
				<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('other/reason/reason','tRSNCode')?></label>
				<div id="odvReasonAutoGenCode" class="form-group">
					<div class="validate-input">
						<label class="fancy-checkbox">
							<input type="checkbox" id="ocbReasonAutoGenCode" name="ocbReasonAutoGenCode" checked="true" value="1">
							<span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
						</label>
					</div>
				</div>

				<div id="odvReasonCodeForm" class="form-group">
					<input type="hidden" id="ohdCheckDuplicateRsnCode" name="ohdCheckDuplicateRsnCode" value="1"> 
					<div class="validate-input">
						<input 
							type="text" 
							class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
							maxlength="5" 
							id="oetRsnCode" 
							name="oetRsnCode"
							data-is-created="<?php echo $tRsnCode; ?>"
							placeholder="<?php echo language('other/reason/reason','tRSNTBCode')?>";
							value="<?php echo $tRsnCode; ?>" 
							data-validate-required = "<?php echo language('other/reason/reason','tRSNValidCode')?>"
							data-validate-dublicateCode = "<?php echo language('other/reason/reason','tRSNValidCodeDup')?>"
						>
					</div>
				</div>
				
			</div>
		</div>

		<?php 
			if($tRoute == "reasonEventAdd"){
				$tRSNAgnCode   = $tSesAgnCode;
				$tRSNAgnName   = $tSesAgnName;
				$tDisabled     = '';
				$tNameElmIDAgn = 'oimBrowseAgn';
			}else{
				$tRSNAgnCode    = $tRSNAgnCode;
				$tRSNAgnName    = $tRSNAgnName;
				$tDisabled      = '';
				$tNameElmIDAgn  = 'oimBrowseAgn';
			}
		?>

		<!-- เพิ่ม Browser AD  -->
		<div class="row">
			<div class="col-xs-12 col-md-5 col-lg-5">
				<div class="form-group  <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
					<label class="xCNLabelFrm"></span><?php echo language('other/reason/reason','tRSNAgency')?></label>	
					<div class="input-group"><input class="form-control xCNHide" type="text" id="oetRSNAgnCode" name="oetRSNAgnCode" maxlength="5" value="<?php echo @$tRSNAgnCode;?>">
						<input type="text" class="form-control xWPointerEventNone" 
							id="oetRSNAgnName" 
							name="oetRSNAgnName" 
							maxlength="100" 
							placeholder ="<?php echo language('other/reason/reason','tRSNAgency');?>"
							value="<?php echo @$tRSNAgnName;?>" readonly>
						<span class="input-group-btn">
							<button id="<?=@$tNameElmIDAgn;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled?>">
								<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
							</button>
						</span>
					</div>
				</div>	
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-5 col-lg-5">

				<div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('other/reason/reason','tRSNName')?></label>
						<input
							type="text"
							class="form-control"
							maxlength="200"
							id="oetRsnName"
							name="oetRsnName"
							placeholder="<?php echo language('other/reason/reason','tRSNName')?>"
							value="<?php echo $tRsnName?>"
							data-validate-required="<?php echo language('other/reason/reason','tRSNValidName')?>"
						>
					</div>
				</div>

				<div class="form-group">
					<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('other/reason/reason','tRSNGroup')?></label>
					<div
						id="osmSelect"
						class="dropdown bootstrap-select form-control xCNSelectBox"
						data-validate-required = "<?php echo language('other/reason/reason','tRSNValidGroup')?>"
					>
						<?php echo $tSelected?>
					</div>
				</div>

				<div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><?php echo language('other/reason/reason','tRSNRefID')?></label>
						<input type="text" class="form-control" maxlength="30" id="oetRsnRefID" name="oetRsnRefID" placeholder="<?php echo language('other/reason/reason','tRSNRefID')?>" value="<?=$tRsnRefID;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="xCNLabelFrm"><?= language('other/reason/reason','tRSNRemark')?></label>
					<textarea class="form-control" rows="4" maxlength="100" id="otaRsnRemark" name="oetRsnRemark"><?php echo $tRsnRemark?></textarea>
				</div>

			</div>
		</div>
	</div>
</form>

<div class="modal fade" id="odvRsnPopupDupCode">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('other/reason/reason','tRSNWarning')?></label>
			</div>
			<div class="modal-body">
				<p id="obpMsgApv"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>
<?php include "script/jReasonAdd.php"; ?>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
	var tRouteLevel = $('#oetRsnCallBackOption').val();
	if(tRouteLevel == 'oASTBrowseRsnOption' || tRouteLevel == 'oAdjStkSumBrowseReason' || tRouteLevel == 'oAdjStkSubBrowseReason'){
		$(".selection-2[name=ocmRcnGroup]").val('008');
		$(".selection-2[name=ocmRcnGroup]").selectpicker('refresh');
	}
</script>