<style>
	.xFontWeightBold{
		font-weight: bold;
	}

	.xCNBtnBuyLicence{
		height: 150px;
		width: 150px;
		margin-right: 10px;
		border-color: #1866ae;
		color : #1866ae;
		font-size: 20px;
		font-family: THSarabunNew-Bold;
		margin-top: 5px;
	}

	.xCNBtnBuyLicence:hover{
		background-color: #1866ae;
		color : #FFF;
	}

	img.xCNImageIconLast {
		display: none;  
	}
	.xCNBtnBuyLicence:hover img.xCNImageIconFisrt {
		display: none;  
	}

	.xCNBtnBuyLicence:hover .xCNImageIconLast {
		display: block;  
	}

	.xCNImageInformationBuy{
		width: 30px; 
		display: block; 
		margin: 0px auto; 
		margin-bottom: 10px;
	}

	@media (min-width:320px)  { .xCNDisplayButton{ padding: 15px; } }
    @media (min-width:1025px) { .xCNDisplayButton{ float: right; } }
    @media (min-width:1281px) { .xCNDisplayButton{ float: right; } }
	.xPadding30 {
    padding-left: 30px;
    padding-right: 30px;
    padding-bottom: 30px;
	}
	.xPaddingTop15 {
		padding-top: 15px;
	}
	.xPaddingTop25 {
		padding-top: 25px;
	}
</style>
<?php
	if($this->session->userdata('tSesUsrLevel')!='HQ'){
		$tDisplayNone ="none";
	}else{
		$tDisplayNone = '';
	}
?>
<div class="main-content">

	<!--ส่วนของรายละเอียดด้านบน-->
	<div class="panel panel-headline">
		<div class="row">
			<div class="col-md-12">
				<div class="panel-body">
					
		
					
					<!--Table ข้อมูลส่วนตัว -->
					<div class="row" >
	

					<!-- <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6" style="display:<?=$tDisplayNone?>">
                    <div class="form-group">
								<label class="xCNLabelFrm"><?= language('checkdocument/checkdocument','tChkDocFilAgnCode')?></label>
								<div class="input-group">
									<input class="form-control xCNHide" id="oetMNTAgnCode" name="oetMNTAgnCode" value="<?=$this->session->userdata('tSesUsrAgnCode')?>" >
									<input
										class="form-control xWPointerEventNone"
										type="text"
										id="oetMNTAgnName"
										name="oetMNTAgnName"
										value="<?=$this->session->userdata('tSesUsrAgnName')?>"
										placeholder="<?= language('checkdocument/checkdocument','tChkDocFilAgnCode')?>"
										readonly
									>
									<span class="input-group-btn">
										<button id="obtMNTBrowsAgn" type="button" class="btn xCNBtnBrowseAddOn" <?php if($this->session->userdata('tSesUsrAgnName')!=''){ echo 'disabled'; } ?>><img class="xCNIconFind"></button>
									</span>
								</div>
							</div>
					</div> -->
					<?php 
					if(!FCNbUsrIsAgnLevel() && $this->session->userdata('tSesUsrLevel')!='HQ'){
						$tBchCode       = $this->session->userdata("tSesUsrBchCodeDefault");
						$tBchName       = $this->session->userdata("tSesUsrBchNameDefault");
						}else{
						$tBchCode       = '';
						$tBchName       = '';
					}
					?>
						<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6" style="display:<?=$tDisplayNone?>">
							<div class="form-group">
								<label class="xCNLabelFrm"><?= language('checkdocument/checkdocument','tChkDocFilBchCode')?></label>
								<div class="input-group">
									<input class="form-control xCNHide" id="oetMNTBchCode" name="oetMNTBchCode" value="" >
									<input
										class="form-control xWPointerEventNone"
										type="text"
										id="oetMNTBchName"
										name="oetMNTBchName"
										value=""
										placeholder="<?= language('checkdocument/checkdocument','tChkDocFilBchCode')?>"
										readonly
									>
									<span class="input-group-btn">
										<button id="obtMNTBrowsBch" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
									</span>
								</div>
							</div>
						</div>


						<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6"  >
								<!-- วันที่ในการออกเอกสาร -->
								<div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('checkdocument/checkdocument', 'tChkDocDateFrom'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetMNTDocDateFrom" name="oetMNTDocDateFrom" value="" data-validate-required="<?= language('document/document/document', 'tDocDateFrom'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtMNTDocDateFrom" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6"  >
								<!-- วันที่ในการออกเอกสาร -->
								<div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('checkdocument/checkdocument', 'tChkDocDateTo'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetMNTDocDateTo" name="oetMNTDocDateTo" value="" data-validate-required="<?= language('document/document/document', 'tDocDateTo'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtMNTDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6"  >
								<!-- ประเภทการชำระ -->
								<div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('checkdocument/checkdocument', 'tChkDocType'); ?></label>
                                    <select class="selectpicker form-control" id="ocmMNTDocType" name="ocmMNTDocType" maxlength="1" >
										<option value="" ><?= language('checkdocument/checkdocument', 'tChkDocTypeAll'); ?></option>
										<?php if(!empty($aDocType['raItems'])){
										 foreach($aDocType['raItems'] as $key => $aVale){		 ?>
                                        <option value="<?=$aVale['FTNotCode']?>" ><?=$aVale['FTNotTypeName']?></option>
										<?php }} ?>
                                    </select>
                                </div>
							</div>
						
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 xPaddingTop25" >
							<button  class="btn xCNBTNDefult xCNBTNDefult2Btn" style="width:30%" type="button" onclick="JSxMNTClearConditionAll()"> <?= language('checkdocument/checkdocument','tChkDocBtnClear')?></button>
							<button id="obtMainAdjustProductFilter" type="button"  style="width:30%" class="btn btn xCNBTNPrimery xCNBTNPrimery2Btn"> <?= language('checkdocument/checkdocument','tChkDocBtnSubmit')?></button>
						</div>
				

					</div>




					<div class="row xPaddingTop25" id="odvCheckdocSumary"></div>

					<div class="row xPaddingTop25" id="odvCheckdocDataTable"></div>

				</div>
			</div>
		</div>
	</div>



</div>

<?php include('script/jChekdocumentPageFrom.php');?>