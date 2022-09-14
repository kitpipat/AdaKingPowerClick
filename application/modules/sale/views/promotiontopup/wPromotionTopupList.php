<div class="panel panel-headline">
	<div class="panel-heading">
		<section id="ostSearchPTU">
			<div class="row">
				<div class="col-xs-12 col-md-2">
					<div class="form-group">
						<label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tStatusActive'); ?></label>
                        <select class="selectpicker form-control" id="ocmPTUShowStatus" name="ocmPTUShowStatus">
                            <option value="ALL"><?=language('common/main/main', 'tAll');?></option>
							<option value="0"><?=language('sale/promotiontopup/promotiontopup', 'tActive');?></option>
                            <option value="1"><?=language('sale/promotiontopup/promotiontopup', 'tPTUStaClosed');?></option>
							<option value="NOTSTART"><?=language('sale/promotiontopup/promotiontopup', 'tPTUNotStart');?></option>
							<option value="EXP"><?=language('sale/promotiontopup/promotiontopup', 'tPmhDateExp');?></option>
                        </select>
                    </div>
				</div>
				<div class="col-xs-12 col-md-3">
					<div class="form-group">
						<label class="xCNLabelFrm"><?php echo language('common/main/main', 'tSearch'); ?></label>
						<div class="input-group">
							<input 
							class="form-control xCNInputWithoutSingleQuote" 
							type="text" id="oetSearchAll" 
							name="oetSearchAll" 
							placeholder="<?= language('sale/promotiontopup/promotiontopup', 'tFillTextSearch') ?>" 
							onkeyup="Javascript:if(event.keyCode==13) JSvPTUCallPageDataTable()" 
							autocomplete="off">
							<span class="input-group-btn">
								<button type="button" class="btn xCNBtnDateTime" onclick="JSvPTUCallPageDataTable()">
									<img src="<?php echo  base_url('application/modules/common/assets/images/icons/search-24.png') ?>">
								</button>
							</span>
						</div>
					</div>
				</div>
                <div class="col-xs-6 col-md-4" style="margin-top: 24px;">
                    <a id="oahPTUAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
                    <a id="oahPTUSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxPTUClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
                </div>
                <div class="col-xs-6 col-md-3 text-right" style="margin-top: 24px;">
                    <!-- <button type="button" id="odvPTUEventImportFile" class="btn xCNBTNImportFile">นำเข้า</button> -->
                    <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                        <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                            <?=language('common/main/main', 'tCMNOption');?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li id="oliBtnDeleteAll" class="disabled">
                                <a data-toggle="modal" data-target="#odvModalDel"><?=language('common/main/main', 'tCMNDeleteAll');?></a>
                            </li>
                        </ul>
                    </div>
                </div>
			</div>

			<div class="row hidden" id="odvPTUAdvanceSearchContainer" style="margin-bottom:20px;">
				<div class="col-xs-12 col-md-6 col-lg-6">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tBranch'); ?></label>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
						<div class="form-group">
							<div class="input-group">
								<input class="form-control xCNHide" id="oetBchCodeFrom" name="oetBchCodeFrom" maxlength="5">
								<input 
								class="form-control xWPointerEventNone" 
								type="text" id="oetBchNameFrom" 
								name="oetBchNameFrom" 
								placeholder="<?php echo language('sale/promotiontopup/promotiontopup', 'tFrom'); ?>" 
								readonly>
								<span class="input-group-btn">
									<button id="obtPTUBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
						<div class="form-group">
							<div class="input-group">
								<input class="form-control xCNHide" id="oetBchCodeTo" name="oetBchCodeTo" maxlength="5">
								<input 
								class="form-control xWPointerEventNone" 
								type="text" 
								id="oetBchNameTo" 
								name="oetBchNameTo" 
								placeholder="<?php echo language('sale/promotiontopup/promotiontopup', 'tTo'); ?>" 
								readonly>
								<span class="input-group-btn">
									<button id="obtPTUBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-6">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tTBDocDate'); ?></label>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
						<div class="form-group">
							<div class="input-group">
								<input 
								class="form-control input100 xCNDatePicker" 
								type="text" id="oetSearchDocDateFrom" 
								name="oetSearchDocDateFrom" 
								placeholder="<?php echo language('sale/promotiontopup/promotiontopup', 'tFrom'); ?>">
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
							<div class="input-group">
								<input 
								class="form-control input100 xCNDatePicker" 
								type="text" id="oetSearchDocDateTo" 
								name="oetSearchDocDateTo" 
								placeholder="<?php echo language('sale/promotiontopup/promotiontopup', 'tTo'); ?>">
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
						<label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tTBStaDoc'); ?></label>
					</div>
					<div class="form-group">
						<select class="selectpicker form-control" id="ocmStaApprove" name="ocmStaApprove">
							<option value='0'><?php echo language('common/main/main', 'tStaDocAll'); ?></option>
                            <option value='1'><?php echo language('common/main/main', 'tStaDocApv'); ?></option>
                            <option value='2'><?php echo language('common/main/main', 'tStaDocPendingApv'); ?></option>
                            <option value='3'><?php echo language('common/main/main', 'tStaDocCancel'); ?></option>
						</select>
					</div>
				</div>
			
				    <!-- From Search Advanced Status Process Stock -->
					<!-- <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchStaPrcStk'); ?></label>
                            <select class="selectpicker form-control" id="ocmStaPrcStk" name="ocmStaPrcStk">
                                <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main', 'tStaDocProcessor'); ?></option>
                                <option value='2'><?php echo language('common/main/main', 'tStaDocProcessing'); ?></option>
                                <option value='3'><?php echo language('common/main/main', 'tStaDocPendingProcessing'); ?></option>
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
				
				<div class="col-lg-12">
					<a id="oahPTUAdvanceSearchSubmit" class="btn xCNBTNDefult xCNBTNDefult1Btn pull-right" href="javascript:;" onclick="JSvPTUCallPageDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></a>
				</div>
			</div>
		</section>
	</div>

	<div class="panel-body">
		<section id="odvPTUContent"></section>
	</div>

</div>

<div class="modal fade" id="odvPTUModalImportFile" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
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
                            <input type="hidden" class="form-control" id="ohdPTUImportNameModule" name="ohdPTUImportNameModule" >

                            <!--Hidden : route หลังจาก import เสร็จแล้ว [Document] - [Master] -->
                            <input type="hidden" class="form-control" id="ohdPTUImportAfterRoute" name="ohdPTUImportAfterRoute" >

                            <!--Hidden : Type Import [Document] - [Master] -->
                            <input type="hidden" class="form-control" id="ohdPTUImportTypeModule" name="ohdPTUImportTypeModule" >

                            <!--Hidden : สำหรับ [Document] ว่ามันจะมีการตรวจสอบ ว่าเคลียร์ทั้งหมด และเพิ่ม ใหม่ หรือ เพิ่มจำนวนต่อจากเดิม  -->
                            <input type="hidden" class="form-control" id="ohdPTUImportClearTempOrInsCon" name="ohdPTUImportClearTempOrInsCon" >

                            <input type="text" class="form-control" id="oetPTUFileNameImport" name="oetPTUFileNameImport" placeholder="เลือกไฟล์" readonly="">
                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefPTUFileImportExcel" name="oefPTUFileImportExcel" onchange="JSxPTUCheckFileImportFile(this, event)" 
                            accept=".csv,application/vnd.ms-excel,.xlt,application/vnd.ms-excel,.xla,application/vnd.ms-excel,.xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.xltx,application/vnd.openxmlformats-officedocument.spreadsheetml.template,.xlsm,application/vnd.ms-excel.sheet.macroEnabled.12,.xltm,application/vnd.ms-excel.template.macroEnabled.12,.xlam,application/vnd.ms-excel.addin.macroEnabled.12,.xlsb,application/vnd.ms-excel.sheet.binary.macroEnabled.12">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" style="border-radius: 0px 5px 5px 0px;" onclick="$('#oefPTUFileImportExcel').click()">
                                    เลือกไฟล์                                                            
                                </button>
                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="border-radius: 0px !important; margin-left: 30px; width: 100px;" id="obtPTUConfirmUpload" onclick="JSxPTUImportFileExcel()"><?php echo language('common/main/main', 'ตกลง') ?></button>  
                            </span>
                        </div>
                    </div>
                    <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                        <a id="oahDowloadTemplate" href="<?=base_url('application/modules/common/assets/template/Promotion_Template.xlsx')?>">
                            <u>ดาวน์โหลดแม่แบบ</u>
                        </a>
                    </div>
                </div>
                <div id="odvPTUContentRenderHTMLImport"></div>
			</div>
			
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <span class="xCNPTUSummaryImportText" style="text-align: left; display: block; font-weight: bold;"></span>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" id="obtIMPUpdateAgain" style="display:none;"><?php echo language('common/main/main', 'เลือกไฟล์ใหม่') ?></button>
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNPTUImportConfirmBtn" id="obPTUImportConfirm" style="display:none;"><?php echo language('common/main/main', 'ยืนยันการนำเข้า') ?></button>
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
                    ข้อมูลที่ทำรายการไปแล้ว จะถูกล้างทั้งหมด และนำเข้าใหม่ กดยืนยันเพื่อดำเนินการต่อ ? 
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

<?php include('script/jPromotionTopupList.php') ?>