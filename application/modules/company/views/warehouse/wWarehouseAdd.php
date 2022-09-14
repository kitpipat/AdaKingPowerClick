<?php
if (@$nResult['rtCode'] == '1') { // Edit Page

	// Table Master
	$tWahStaType = $nResult['roItem']['rtWahStaType']; // ประเภทคลัง 1:มาตรฐาน 2:คลังทั่วไป 3:คลังสาขา(ยกเลิก) 4:คลังฝากขาย/ร้านค้า 5:คลังหน่วยรถ 6:Vending

	$tWahCode = $nResult['roItem']['rtWahCode'];
	$tWahName = $nResult['roItem']['rtWahName'];
	$tBchCode = $nResult['roItem']['rtBchCode'];
	$tBchName = $nResult['roItem']['rtBchName'];
	$tBchCodeRef = $nResult['roItem']['rtBchCodeRef'];
	$tBchNameRef = $nResult['roItem']['rtBchNameRef'];
	$tShpCodeRef = $nResult['roItem']['rtShpCodeRef'];
	$tShpNameRef = $nResult['roItem']['rtShpNameRef'];
	$tSpnCodeRef = $nResult['roItem']['rtSpnCodeRef'];
	$tSpnNameRef = $nResult['roItem']['rtSpnNameRef'];
	$tPosCodeRef = $nResult['roItem']['rtPosCodeRef'];
	$tPosNameRef = $nResult['roItem']['rtPosNameRef'];
	$tWahStaChkStk = $nResult['roItem']['rtWahStaChkStk'];
	$tWahStaPrcStk = $nResult['roItem']['rtWahStaPrcStk'];
	$tWahStaAlwPLFrmTBO = $nResult['roItem']['rtWahStaAlwPLFrmTBO'];
	$tWahStaAlwPLFrmSale = $nResult['roItem']['rtWahStaAlwPLFrmSale'];
	$tWahStaAlwSNPL = $nResult['roItem']['rtWahStaAlwSNPL'];
	$tWahCheckCntStk = $nResult['roItem']['rtWahStaAlwCntStk'];
	$tWahCheckCostAmt = $nResult['roItem']['rtWahStaAlwCostAmt'];
	$tStaUsrLevel = $tStaUsrLevel;
	$tUsrBchCode = $tUsrBchCode;

	switch ($tWahStaType) {
		case "1": { // 1:มาตรฐาน
				$tWahRefCode = $tBchCodeRef;
				$tWahRefCodeName = $tBchNameRef;
				break;
			}
		case "2": { // 2:คลังทั่วไป
				// $tWahRefCode = $tBchCodeRef;
				// $tWahRefCodeName = $tBchNameRef;

				$tWahRefCode = $tPosCodeRef;
				$tWahRefCodeName = $tPosNameRef;
				break;
			}
		case "4": { // 4:คลังฝากขาย/ร้านค้า
				$tWahRefCode = $tShpCodeRef;
				$tWahRefCodeName = $tShpNameRef;
				break;
			}
		case "5": { // 5:คลังหน่วยรถ 
				$tWahRefCode = $tSpnCodeRef;
				$tWahRefCodeName = $tSpnNameRef;
				break;
			}
		case "6": { // 6:Vending
				$tWahRefCode = $tPosCodeRef;
				$tWahRefCodeName = $tPosNameRef;
				break;
			}
	}

	$tRoute	= 'warehouseEventEdit'; //Route ควบคุมการทำงาน Edit
} else { // Add Page
	$tRoute = 'warehouseEventAdd'; //Route ควบคุมการทำงาน Add
	$tWahStaType = "2";
	$tWahCode = "";
	$tWahName = "";

	//issue 19/10/2563 ถ้าเข้ามาแบบ HQ สาขาไม่ต้อง default
	if($this->session->userdata("tSesUsrLevel") == 'HQ'){
		$tBchCode = '';
		$tBchName = '';
	}else{
		$tBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
		$tBchName = $this->session->userdata("tSesUsrBchNameDefault");
	}

	$tShpCodeRef = $this->session->userdata("tSesUsrShpCodeDefault");
	$tShpNameRef = $this->session->userdata("tSesUsrShpNameDefault");
	$tSpnCodeRef = "";
	$tSpnNameRef = "";
	$tPosCodeRef = "";
	$tPosNameRef = "";
	$tWahStaChkStk = "1";
	$tWahStaPrcStk = "1";
	$tStaUsrLevel = $tStaUsrLevel;
	$tUsrBchCode = $tUsrBchCode;
	$tWahStaAlwPLFrmTBO = '';
	$tWahStaAlwPLFrmSale = '';
	$tWahStaAlwSNPL = '';
	$tWahRefCode = $this->session->userdata("tSesUsrBchCodeDefault");
	$tWahRefCodeName = $this->session->userdata("tSesUsrBchNameDefault");
	$tWahCheckCntStk = '1';
	$tWahCheckCostAmt = '1';
}

$nLangEdit = $this->session->userdata("tLangEdit");
$tUserLoginLevel = $this->session->userdata("tSesUsrLevel");
$bIsAddPage = empty($tWahCode) ? true : false;
$bIsMultiBch = $this->session->userdata("nSesUsrBchCount") > 1;
$bIsShpEnabled = FCNbGetIsShpEnabled();
?>

<script>
	var nLangEdit = '<?php echo $nLangEdit; ?>';
	var tUserLoginLevel = '<?php echo $tUserLoginLevel; ?>';
	var bIsAddPage = <?php echo ($bIsAddPage) ? 'true' : 'false'; ?>;
	var bIsMultiBch = <?php echo ($bIsMultiBch) ? 'true' : 'false'; ?>;
	var bIsShpEnabled = <?php echo ($bIsShpEnabled) ? 'true' : 'false'; ?>;
</script>

<!-- Zone Input Hide -->
<input type="text" class="xCNHide" id="ohdWahStaType" value="<?= $tWahStaType ?>">
<!-- Zone Input Hide -->

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddWarehouse">
	<button type="submit" id="obtSubmitWah" onclick="JSnAddEditWarehouse('<?= $tRoute ?>');" class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNHide"> <?php echo language('common/main/main', 'tSave') ?></button>
	<div class="panel-body" style="padding-top:20px !important;">
		<div class="row">
			<div class="col-xs-12 col-md-5 col-lg-5">
				<!-- รหัสคลังสินค้า -->
				<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('company/warehouse/warehouse', 'tWahCode'); ?></label>
				<div id="odvWahAutoGenCode" class="form-group">
					<div class="validate-input">
						<label class="fancy-checkbox">
							<input type="checkbox" id="ocbWahAutoGenCode" name="ocbWahAutoGenCode" checked="true" value="1">
							<span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
						</label>
					</div>
				</div>
				<div id="odvWahCodeForm" class="form-group">
					<input type="hidden" id="ohdCheckDuplicateWahCode" name="ohdCheckDuplicateWahCode" value="1">
					<div class="validate-input">
						<input type="text" class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" maxlength="5" id="oetWahCode" name="oetWahCode" value="<?php echo $tWahCode ?>" autocomplete="off" data-is-created="<?php echo $tWahCode ?>" placeholder="<?php echo language('company/warehouse/warehouse', 'tWahCode') ?>" data-validate-required="<?php echo language('company/warehouse/warehouse', 'tWAHValidCode'); ?>" data-validate-dublicateCode="<?php echo language('company/warehouse/warehouse', 'tWAHValidCodeDup') ?>">
					</div>
				</div>
				
				<!-- ชื่อคลังสินค้า -->
				<div class="form-group">
					<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('company/warehouse/warehouse', 'tWahName') ?></label> <!-- เปลี่ยนชื่อ Class -->
					<input class="form-control" type="text" id="oetWahName" name="oetWahName" placeholder="<?php echo language('company/warehouse/warehouse', 'tWahName') ?>" maxlength="100" value="<?php echo @$tWahName ?>" data-validate-required="<?php echo language('company/warehouse/warehouse', 'tWAHValidName') ?>">
				</div>
				<!--ประเภทคลังสินค้า-->
				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse', 'tWahStaType') ?></label>
					<!-- Last Updated By : Napat(Jame) 11/08/2020 ปิดปุ่มเลือกคลังในโปรเจค SKC ให้เลือกเฉพาะคลังทั่วไปอย่างเดียว -->
					<select class="selectpicker form-control" id="ocmWahStaType" name="ocmWahStaType" maxlength="1" data-validate-required="<?php echo language('company/warehouse/warehouse', 'tWAHValidType') ?>" >
						<!-- เปิดแสดงเฉพาะ หน้าจอแก้ไข ประเภทคลังมาตรฐาน Create By : 03/11/2020 Napat(Jame) -->
						<?php if( $tRoute == 'warehouseEventEdit' && $tWahStaType == "1" ){ ?>
						<option <?php if($tWahStaType == "1"){ echo "selected"; } ?> value="1"><?php echo language('company/warehouse/warehouse', 'tWahStaTypeSEL1');?></option>
						<?php } ?>

						<?php if( $tWahStaType != "1" ){ ?>
							<option <?php if($tWahStaType == "2"){ echo "selected"; } ?> value="2"><?php echo language('company/warehouse/warehouse', 'tWahStaTypeSEL2');?></option>
							<?php if(FCNbGetIsShpEnabled() == 1){ ?>
								<option <?php if($tWahStaType == "6"){ echo "selected"; } ?> value="6" ><?php echo language('company/warehouse/warehouse', 'tWahStaTypeSEL6');?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div>

				<!-- สาขาที่สร้าง -->
				<div class="form-group">
					<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('document/transfer_branch_out/transfer_branch_out', 'tWahBchCreate'); ?></label>
					<div class="input-group">
						<input type="text" class="input100 xCNHide" id="oetWahBchCodeCreated" name="oetWahBchCodeCreated" maxlength="5" value="<?php echo $tBchCode; ?>">
						<input class="form-control xWPointerEventNone" type="text" id="oetWahBchNameCreated" name="oetWahBchNameCreated" value="<?php echo $tBchName; ?>" data-validate-required="<?php echo language('company/warehouse/warehouse', 'tWAHValidbch') ?>" readonly>
						<span class="input-group-btn xWConditionSearchPdt">
							<button id="obtWahBrowseBchCreated" type="button" class="btn xCNBtnBrowseAddOn" <?php echo ($this->session->userdata("nSesUsrBchCount") == 1) ? 'disabled' : ''; ?>>
								<img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
							</button>
						</span>
					</div>
				</div>

				<!-- สาขาที่มีผล -->
				<div class="form-group" id="odvWhaBach" style="display:none">
					<input type="hidden" class="form-control xCNHide" id="oetWAHBchCodeOld" name="oetWAHBchCodeOld" value="<?php echo $tBchCode; ?>">
					<label class="xCNLabelFrm">
						<!-- <span class="text-danger">*</span> --><?php echo language('company/warehouse/warehouse', 'tWahBranchRefer') ?></label>
					<?php
					if (@$nResult['rtCode'] == '99') {
						$tWahRefCode = '';
						$tWahRefCodeName = '';
					} else {
						$tWahRefCode = $tWahRefCode;
						$tWahRefCodeName = $tWahRefCodeName;
					}
					?>
					<div class="input-group">
						<input type="text" class="form-control xCNHide" id="oetWAHBchCode" name="oetWAHBchCode" value="<?php echo $tWahRefCode ?>">
						<input type="text" class="form-control xWPointerEventNone" id="oetWAHBchName" name="oetWAHBchName" value="<?php echo $tWahRefCodeName ?>" readonly>
						<span class="input-group-btn">
							<button id="obtWahBroseBchRef" type="button" class="btn xCNBtnBrowseAddOn" <?php echo ($this->session->userdata("nSesUsrBchCount") == 1) ? 'disabled' : ''; ?>>
								<img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
							</button>
						</span>
					</div>
				</div>

				<!-- ร้านค้าที่มีผล -->
				<div class="form-group" id="odvWhaShop" style="display:none"> 
					<label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse', 'tWahRefCode') ?></label>
					<div class="input-group">
						<input type="text" class="form-control xCNHide" id="oetWahRefCode" name="oetWahRefCode" value="<?php echo $tWahRefCode; ?>">
						<input type="text" class="form-control xWPointerEventNone" id="oetWahRefName" name="oetWahRefName" value="<?php echo $tWahRefCodeName; ?>" readonly>
						<span class="input-group-btn">
							<button id="oimBrowseShop" type="button" class="btn xCNBtnBrowseAddOn">
								<img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
							</button>
						</span>
					</div>
				</div>

				<!-- พนักงานขายที่มีผล -->
				<div class="form-group" id="odvWhaSaleperson">
					<label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse', 'tWAHBrowseSpnTitle') ?></label>
					<div class="input-group">
						<input type="text" class="form-control xCNHide" id="oetWahSpnCode" name="oetWahSpnCode" maxlength="5" value="<?php echo $tSpnCodeRef; ?>">
						<input type="text" class="form-control xWPointerEventNone" id="oetWahSpnName" name="oetWahSpnName" maxlength="100" value="<?php echo $tSpnNameRef; ?>" readonly>
						<span class="input-group-btn">
							<button id="oimBrowseSalePerson" type="button" class="btn xCNBtnBrowseAddOn">
								<img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
							</button>
						</span>
					</div>
				</div>

				<!-- จุดขายที่มีผล -->
				<div class="form-group" id="odvWhaSaleMCPos">
					<label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse', 'tSalemachinePOS') ?></label>
					<div class="input-group">
						<input type="text" class="form-control xCNHide" id="oetWahPosCode" name="oetWahPosCode" maxlength="5" value="<?php echo $tWahRefCode; ?>">
						<input type="text" class="form-control xWPointerEventNone" id="oetWahPosName" name="oetWahPosName" maxlength="100" value="<?php echo $tWahRefCodeName; ?>" readonly>
						<span class="input-group-btn">
							<button id="oimBrowsePOS" type="button" class="btn xCNBtnBrowseAddOn">
								<img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
							</button>
						</span>
					</div>
				</div>

				<!-- สถานะประมวลผลสต็อก -->
				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse', 'tPosStatusprocessstock') ?></label>
					<select class="selectpicker form-control" id="ocmWahStaPrcStk" name="ocmWahStaPrcStk" maxlength="1" data-validate-required="<?php echo language('company/warehouse/warehouse', 'tWAHValidType') ?>">
						<option value="1" <?php echo ($tWahStaPrcStk == "1") ? 'selected' : ''; ?>><?php echo language('company/warehouse/warehouse', 'tPosStatusprocessstockCant') ?></option>
						<option value="2" <?php echo ($tWahStaPrcStk == "2") ? 'selected' : ''; ?>><?php echo language('company/warehouse/warehouse', 'tPosStatusprocessstockCut') ?></option>
					</select>
				</div>
				<!-- สถานะ เช็คสต็อก -->
				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse', 'tPosCheckStatusstock') ?></label>
					<select class="selectpicker form-control" id="ocmWahStaChkStk" name="ocmWahStaChkStk" maxlength="1" data-validate-required="<?php echo language('company/warehouse/warehouse', 'tWAHValidType') ?>">
						<option value="1" <?php echo ($tWahStaChkStk == "1") ? 'selected' : ''; ?>><?=language('company/warehouse/warehouse', 'tPosCheckCantStock') ?></option>
						<option value="2" <?php echo ($tWahStaChkStk == "2") ? 'selected' : ''; ?>><?=language('company/warehouse/warehouse', 'tPosCheckOffline') ?></option>
						<option value="3" <?php echo ($tWahStaChkStk == "3") ? 'selected' : ''; ?>><?=language('company/warehouse/warehouse', 'tPosCheckOnline') ?></option>
					</select>
				</div>

				<!-- สถานะอนุญาต ตรวจสอบสต๊อกคงเหลือ(สำหรับขาย) -->
				<div class="form-group">
					<label class="fancy-checkbox">
						<input type="checkbox" id="ocbWahCheckCntStk" value="1" name="ocbWahCheckCntStk" <?php echo $tWahCheckCntStk == "1" ? 'checked' : ''; ?>>
						<span><?php echo language('company/warehouse/warehouse', 'tPosCheckCntStk') ?></span>
					</label>
				</div>

				<!-- สถานะอนุญาต คำนวณมูลค่าสินค้า -->
				<div class="form-group">
					<label class="fancy-checkbox">
						<input type="checkbox" id="ocbWahCheckCostAmt" value="1" name="ocbWahCheckCostAmt" <?php echo $tWahCheckCostAmt == "1" ? 'checked' : ''; ?>>
						<span><?php echo language('company/warehouse/warehouse', 'tPosCheckCostAmt') ?></span>
					</label>
				</div>

				<!-- อนุญาตใช้ใบจัดจากใบจ่ายโอน -->
				<div class="form-group"> 
					<label class="fancy-checkbox"> 
						<?php if (isset($tWahStaAlwPLFrmTBO) && $tWahStaAlwPLFrmTBO == 1) {
							$tChecked   = 'checked'; 
						} else {
							$tChecked   = ''; 
						} ?> 
						<input type="checkbox" id="ocbWahStaAlwPLFrmTBO" name="ocbWahStaAlwPLFrmTBO" <?php echo $tChecked; ?>> 
							<span> <?php echo language('company/warehouse/warehouse', 'tPosStaAlwPLFrmTBO'); ?></span> 
					</label> 
				</div>
				<!-- อนุญาตใช้ใบจัดจากใบขาย -->
				<div class="form-group"> 
					<label class="fancy-checkbox"> 
						<?php if (isset($tWahStaAlwPLFrmSale) && $tWahStaAlwPLFrmSale == 1) {
							$tChecked   = 'checked'; 
						} else {
							$tChecked   = ''; 
						} ?> 
						<input type="checkbox" id="ocbWahStaAlwPLFrmSale" name="ocbWahStaAlwPLFrmSale" <?php echo $tChecked; ?>> 
							<span> <?php echo language('company/warehouse/warehouse', 'tPosStaAlwPLFrmSale'); ?></span> 
					</label> 
				</div>
				<!-- รับ S/N ในใบจัด -->
				<div class="form-group"> 
					<label class="fancy-checkbox"> 
						<?php if (isset($tWahStaAlwSNPL) && $tWahStaAlwSNPL == 1) {
							$tChecked   = 'checked'; 
						} else {
							$tChecked   = ''; 
						} ?> 
						<input type="checkbox" id="ocbWahStaAlwSNPL" name="ocbWahStaAlwSNPL" <?php echo $tChecked; ?>> 
							<span> <?php echo language('company/warehouse/warehouse', 'tPosStaAlwSNPL'); ?></span> 
					</label> 
				</div>
			</div>
		</div>
	</div>
</form>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include "script/jWarehouseAdd.php"; ?>


<script>
	$('#odvWhaShop').hide();
	$('#odvWhaSaleperson').hide();
	$('#odvWhaSaleMCPos').show();
</script>