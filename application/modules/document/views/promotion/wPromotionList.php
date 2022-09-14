<div class="panel panel-headline">
	<div class="panel-body">
		<section id="ostSearchPromotion">
			<div class="row">
				<div class="col-xs-12 col-md-9 col-lg-9">
					<div class ="row">
						<div class="col-xs-12 col-md-2 col-lg-2">
							<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
								<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tLabel17'); ?></label>
							</div>
							<div class="form-group">
								<select class="selectpicker form-control" id="ocmUsedStatus" name="ocmUsedStatus" onchange="JSvPromotionCallPageDataTable()">
									<option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
									<option value='1'><?php echo language('document/promotion/promotion', 'tPausedTemporarily'); ?></option>
									<option value='2'><?php echo language('document/promotion/promotion', 'tActive'); ?></option>
									<option value='3'><?php echo language('document/promotion/promotion', 'tLabel12'); ?></option>
									<option value='4'><?php echo language('document/promotion/promotion', 'tPmhDateExp'); ?></option>
									<option value='5'><?php echo language('document/promotion/promotion', 'tStaDoc3'); ?></option>
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-4 col-lg-4">
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('common/main/main', 'tSearch'); ?></label>
								<div class="input-group">
									<input 
									class="form-control xCNInputWithoutSingleQuote" 
									type="text" id="oetSearchAll" 
									name="oetSearchAll" 
									placeholder="<?= language('document/topupVending/topupVending', 'tFillTextSearch') ?>" 
									onkeyup="Javascript:if(event.keyCode==13) JSvPromotionCallPageDataTable()" 
									autocomplete="off">
									<span class="input-group-btn">
										<button type="button" class="btn xCNBtnDateTime" onclick="JSvPromotionCallPageDataTable()">
											<img src="<?php echo  base_url('application/modules/common/assets/images/icons/search-24.png') ?>">
										</button>
									</span>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-lg-6">
							<div style="margin-top:25px;">
								<a id="oahPromotionAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" style="margin-bottom: 5px;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
								<a id="oahTFWSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" style="margin-bottom: 5px;" onclick="JSxPromotionClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row hidden" id="odvPromotionAdvanceSearchContainer" style="margin-bottom:20px;">
				<div class="col-xs-12 col-md-6 col-lg-6">
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchBranch'); ?></label>
							<div class="input-group">
								<?php
									$nCountBch = $this->session->userdata("nSesUsrBchCount");
									if($nCountBch == 1){ //ค้นหาขั้นสูง
										$tBCHCode = $this->session->userdata("tSesUsrBchCodeDefault");
										$tBCHName = $this->session->userdata("tSesUsrBchNameDefault");
									}else{
										$tBCHCode = '';
										$tBCHName = '';
									}
                                ?>
								<input class="form-control xCNHide" id="oetBchCodeFrom" name="oetBchCodeFrom" maxlength="5" value="<?= $tBCHCode; ?>">
								<input 
								class="form-control xWPointerEventNone" 
								type="text" id="oetBchNameFrom" 
								name="oetBchNameFrom" 
								placeholder="<?php echo language('document/topupVending/topupVending', 'tFrom'); ?>" 
								readonly
								value="<?= $tBCHName; ?>" >
								<span class="input-group-btn">
									<button id="obtPromotionBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
									</button>
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchBranchTo'); ?></label>
							<div class="input-group">
								<input class="form-control xCNHide" id="oetBchCodeTo" name="oetBchCodeTo" maxlength="5" value="<?= $tBCHCode; ?>">
								<input 
								class="form-control xWPointerEventNone" 
								type="text" 
								id="oetBchNameTo" 
								name="oetBchNameTo" 
								placeholder="<?php echo language('document/topupVending/topupVending', 'tTo'); ?>" 
								readonly
								value="<?= $tBCHName; ?>">
								<span class="input-group-btn">
									<button id="obtPromotionBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-6">
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchDocDate'); ?></label>
							<div class="input-group">
								<input 
								class="form-control input100 xCNDatePicker" 
								type="text" id="oetSearchDocDateFrom" 
								name="oetSearchDocDateFrom" 
								placeholder="<?php echo language('document/topupVending/topupVending', 'tFrom'); ?>">
								<span class="input-group-btn">
									<button id="obtSearchDocDateFrom" type="button" class="btn xCNBtnDateTime">
										<img src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
									</button>
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchDocDateTo'); ?></label>
							<div class="input-group">
								<input 
								class="form-control input100 xCNDatePicker" 
								type="text" id="oetSearchDocDateTo" 
								name="oetSearchDocDateTo" 
								placeholder="<?php echo language('document/topupVending/topupVending', 'tTo'); ?>">
								<span class="input-group-btn">
									<button id="obtSearchDocDateTo" type="button" class="btn xCNBtnDateTime">
										<img src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-3 col-lg-3">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tTBStaDoc'); ?></label>
					</div>
					<div class="form-group">
						<select class="selectpicker form-control" id="ocmStaDoc" name="ocmStaDoc">
							<option value='0'><?php echo language('common/main/main', 'tStaDocAll'); ?></option>
                            <option value='1'><?php echo language('common/main/main', 'tStaDocApv'); ?></option>
                            <option value='2'><?php echo language('common/main/main', 'tStaDocPendingApv'); ?></option>
                            <option value='3'><?php echo language('common/main/main', 'tStaDocCancel'); ?></option>
						</select>
					</div>
				</div>
				<!-- <div class="col-xs-12 col-md-3 col-lg-3">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tTBStaPrc'); ?></label>
					</div>
					<div class="form-group">
						<select class="selectpicker form-control" id="ocmStaPrcStk" name="ocmStaPrcStk">
							<option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                            <option value='1'><?php echo language('common/main/main', 'tStaDocProcessor'); ?></option> -->
                            <!-- <option value='2'><?php echo language('common/main/main', 'tStaDocProcessing'); ?></option> -->
                            <!-- <option value='3'><?php echo language('common/main/main', 'tStaDocPendingProcessing'); ?></option>
						</select>
					</div>
				</div> -->
                    <!-- From Search Advanced Status Doc Aaction -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('common/main/main', 'tStaDocAct'); ?></label>
                            <select class="selectpicker form-control" id="ocmStaDocAct" name="ocmStaDocAct">
                                <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                                <option value='1' selected><?php echo language('common/main/main', 'tStaDocActMove'); ?></option>
                                <option value='2'><?php echo language('common/main/main', 'tStaDocActNotMoving'); ?></option>
                            </select>
                        </div>
                    </div>

				<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group" style="width: 60%;">
                        <label class="xCNLabelFrm">&nbsp;</label>
                        <button id="oahTFWAdvanceSearchSubmit" class="btn xCNBTNPrimery" style="width:100%" onclick="JSvPromotionCallPageDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></button>
                    </div>
                </div>

			</div>
		</section>
	</div>
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-8 col-md-4 col-lg-4">
			</div>
			<?php if($aAlwEventBranch['tAutStaFull'] == 1 || $aAlwEventBranch['tAutStaDelete'] == 1 ) : ?>
		<div class="col-xs-12 col-md-8 col-lg-8 text-right" style="margin-top:-35px;">

			<?php if($aAlwEventBranch['tAutStaFull'] == 1 || ($aAlwEventBranch['tAutStaAdd'] == 1)){ ?>
				<button type="button" id="odvPromotionEventImportFile" class="btn xCNBTNImportFile"><?= language('common/main/main','tImport')?></button>
			<?php } ?>

			<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
				<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
					<?= language('common/main/main','tCMNOption')?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li id="oliBtnDeleteAll" class="disabled">
						<a data-toggle="modal" data-target="#odvmodaldeleteBranch"><?= language('common/main/main','tDelAll')?></a>
					</li>
				</ul>
			</div>
		</div>
		<?php endif; ?>
		</div>
	</div>
	<div class="panel-body">
		<section id="odvPromotionContent"></section>
	</div>
</div>

<div class="modal fade" id="odvPromotionModalImportFile" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
    <div class="modal-dialog" role="document" style="width: 450px; margin: 1.75rem auto;top:20%;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;">นำเข้าข้อมูล</label>
                    </div>
                </div>
			</div>
			
            <div class="modal-body">
                <div id="odvContentFileImport">
                    <div class="form-group">
                        <div class="input-group">
                            <!--Hidden : ชื่อหน้าจอ -->
                            <input type="hidden" class="form-control" id="ohdPromotionImportNameModule" name="ohdPromotionImportNameModule" >

                            <!--Hidden : route หลังจาก import เสร็จแล้ว [Document] - [Master] -->
                            <input type="hidden" class="form-control" id="ohdPromotionImportAfterRoute" name="ohdPromotionImportAfterRoute" >

                            <!--Hidden : Type Import [Document] - [Master] -->
                            <input type="hidden" class="form-control" id="ohdPromotionImportTypeModule" name="ohdPromotionImportTypeModule" >

                            <!--Hidden : สำหรับ [Document] ว่ามันจะมีการตรวจสอบ ว่าเคลียร์ทั้งหมด และเพิ่ม ใหม่ หรือ เพิ่มจำนวนต่อจากเดิม  -->
                            <input type="hidden" class="form-control" id="ohdPromotionImportClearTempOrInsCon" name="ohdPromotionImportClearTempOrInsCon" >

                            <input type="text" class="form-control" id="oetPromotionFileNameImport" name="oetPromotionFileNameImport" placeholder="<?php echo language('document/promotion/promotion', 'tLabel13'); ?>" readonly="">
                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefPromotionFileImportExcel" name="oefPromotionFileImportExcel" onchange="JSxPromotionCheckFileImportFile(this, event)" 
                            accept=".csv,application/vnd.ms-excel,.xlt,application/vnd.ms-excel,.xla,application/vnd.ms-excel,.xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.xltx,application/vnd.openxmlformats-officedocument.spreadsheetml.template,.xlsm,application/vnd.ms-excel.sheet.macroEnabled.12,.xltm,application/vnd.ms-excel.template.macroEnabled.12,.xlam,application/vnd.ms-excel.addin.macroEnabled.12,.xlsb,application/vnd.ms-excel.sheet.binary.macroEnabled.12">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" style="border-radius: 0px 5px 5px 0px;" onclick="$('#oefPromotionFileImportExcel').click()">
									<?php echo language('document/promotion/promotion', 'tLabel13'); ?>                                                            
                                </button>
                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="border-radius: 0px !important; margin-left: 30px; width: 100px;" id="obtPromotionConfirmUpload" onclick="JSxPromotionImportFileExcel()"><?php echo language('document/promotion/promotion', 'tLabel11') ?></button>  
                            </span>
                        </div>
                    </div>
                    <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                        <a id="oahDowloadTemplate" href="<?=base_url('application/modules/common/assets/template/Promotion_Template.xlsx')?>">
                            <u><?php echo language('document/promotion/promotion', 'tLabel14'); ?></u>
                        </a>
                    </div>
                </div>
                <div id="odvPromotionContentRenderHTMLImport"></div>
			</div>
			
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <span class="xCNPromotionSummaryImportText" style="text-align: left; display: block; font-weight: bold;"></span>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" id="obtIMPUpdateAgain" style="display:none;"><?php echo language('document/promotion/promotion', 'tLabel15'); ?></button>
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNPromotionImportConfirmBtn" id="obPromotionImportConfirm" style="display:none;"><?php echo language('document/promotion/promotion', 'tLabel16'); ?></button>
                        <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtIMPCancel" data-dismiss="modal"><?php echo language('common/main/main', 'ยกเลิก') ?></button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDialogClearData"  data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
    <div class="modal-dialog" role="document" style="margin: 1.75rem auto; top: 20%;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <h3 style="font-size:20px;color:#FFFF00;font-weight: 1000;"><i class="fa fa-exclamation-triangle"></i> <?=language('common/main/main', 'tModalWarning') ?></h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
					<?php echo language('document/promotion/promotion', 'tWarMsg2'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" data-dismiss="modal" id="obtConfirmDeleteBeforeInsert"><?php echo language('common/main/main', 'tModalConfirm') ?></button>  
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button> 
            </div>
        </div>
    </div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<?php include('script/jPromotionList.php') ?>