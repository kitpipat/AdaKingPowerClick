<?php
	if ($this->session->userdata("tSesUsrLevel") != "HQ" ){
		if( $this->session->userdata("nSesUsrBchCount") <= 1 ){
			$tBrowseBchDisabled 	= 'disabled';
			$tBchCodeDefault 		= $this->session->userdata("tSesUsrBchCodeDefault");
			$tBchNameDefault 		= $this->session->userdata("tSesUsrBchNameDefault");
		}else{
			$tBrowseBchDisabled 	= '';
			$tBchCodeDefault 		= '';
			$tBchNameDefault 		= '';
		}
	} else {
		$tBchCodeDefault = "";
		$tBchNameDefault = "";
		$tBrowseBchDisabled = '';
	}
?>
<div class="panel panel-headline">
	<div class="panel-heading">
		<section id="ostSearch">
			<div class="row">
				<div class="col-xs-3 col-md-3">
					<div class="form-group">
						<div class="input-group">
							<input 
							class="form-control xCNInputWithoutSingleQuote" 
							type="text" id="oetSearchAll" 
							name="oetSearchAll" 
							placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDFillTextSearch') ?>" 
							onkeyup="Javascript:if(event.keyCode==13) JSvRVDCallPagePdtDataTable()" 
							autocomplete="off">
							<span class="input-group-btn">
								<button type="button" class="btn xCNBtnDateTime" onclick="JSvRVDCallPagePdtDataTable()">
									<img src="<?=base_url('application/modules/common/assets/images/icons/search-24.png') ?>">
								</button>
							</span>
						</div>
					</div>
				</div>
				<a id="oahRVDAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?=language('common/main/main', 'tAdvanceSearch'); ?></a>
				<a id="oahRVDSearchReset"   class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxRVDClearSearchData()"><?=language('common/main/main', 'tClearSearch'); ?></a>
			</div>

			<div class="row hidden" id="odvRVDAdvanceSearchContainer" style="margin-bottom:20px;">
				<div class="col-xs-12 col-md-6 col-lg-6">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?=language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchBranch'); ?></label>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
						<div class="form-group">
							<div class="input-group">
								<input class="form-control xCNHide" id="oetBchCodeFrom" name="oetBchCodeFrom" value="<?=$tBchCodeDefault;?>" maxlength="5">
								<input 
								class="form-control xWPointerEventNone" 
								type="text" id="oetBchNameFrom" 
								name="oetBchNameFrom" 
								value="<?=$tBchNameDefault;?>"
								placeholder="<?=language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchFrom'); ?>" 
								readonly>
								<span class="input-group-btn">
									<button id="obtRVDBrowseBchFrom" <?=$tBrowseBchDisabled;?> type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?=base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
						<div class="form-group">
							<div class="input-group">
								<input class="form-control xCNHide" id="oetBchCodeTo" name="oetBchCodeTo" value="<?=$tBchCodeDefault;?>" maxlength="5">
								<input 
								class="form-control xWPointerEventNone" 
								type="text" 
								id="oetBchNameTo" 
								name="oetBchNameTo"
								value="<?=$tBchNameDefault;?>" 
								placeholder="<?=language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchTo'); ?>" 
								readonly>
								<span class="input-group-btn">
									<button id="obtRVDBrowseBchTo" <?=$tBrowseBchDisabled;?> type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?=base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-6">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?=language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchDocDate'); ?></label>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
						<div class="form-group">
							<div class="input-group">
								<input 
								class="form-control input100 xCNDatePicker" 
								type="text" id="oetSearchDocDateFrom" 
								name="oetSearchDocDateFrom" 
								placeholder="<?=language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchFrom'); ?>">
								<span class="input-group-btn">
									<button id="obtSearchDocDateFrom" type="button" class="btn xCNBtnDateTime">
										<img src="<?=base_url(); ?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
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
								placeholder="<?=language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchTo'); ?>">
								<span class="input-group-btn">
									<button id="obtSearchDocDateTo" type="button" class="btn xCNBtnDateTime">
										<img src="<?=base_url(); ?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-3 col-lg-3">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?=language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchLabelStaDoc'); ?></label>
					</div>
					<div class="form-group">
						<select class="selectpicker form-control" id="ocmStaDoc" name="ocmStaDoc">
							<option value='0'><?=language('common/main/main', 'tStaDocAll'); ?></option>
							<option value='1'><?=language('common/main/main', 'tStaDocComplete'); ?></option>
							<option value='2'><?=language('common/main/main', 'tStaDocinComplete'); ?></option>
							<option value='3'><?=language('common/main/main', 'tStaDocCancel'); ?></option>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-md-3 col-lg-3">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?=language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchStaApprove'); ?></label>
					</div>
					<div class="form-group">
						<select class="selectpicker form-control" id="ocmStaApprove" name="ocmStaApprove">
							<option value='0'><?=language('common/main/main', 'tAll'); ?></option>
							<option value='1'><?=language('common/main/main', 'tStaDocApv'); ?></option>
							<option value='2'><?=language('common/main/main', 'tStaDocPendingApv'); ?></option>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-md-3 col-lg-3">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?=language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchStaPrcStk'); ?></label>
					</div>
					<div class="form-group">
						<select class="selectpicker form-control" id="ocmStaPrcStk" name="ocmStaPrcStk">
							<option value='0'><?=language('common/main/main', 'tAll'); ?></option>
							<option value='1'><?=language('common/main/main', 'tStaDocProcessor'); ?></option>
							<option value='2'><?=language('common/main/main', 'tStaDocProcessing'); ?></option>
							<option value='3'><?=language('common/main/main', 'tStaDocPendingProcessing'); ?></option>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
						<div class="form-group" style="width: 60%;">
							<label class="xCNLabelFrm">&nbsp;</label>
							<button id="oahRVDAdvanceSearchSubmit" class="btn xCNBTNPrimery" style="width:100%" onclick="JSvRVDCallPagePdtDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></button>
						</div>
				</div>
			</div>
		</section>
	</div>
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-8 col-md-4 col-lg-4"></div>
			<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:-35px;">
				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?= language('common/main/main', 'tCMNOption') ?>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvRVDModalDelDocMultiple"><?= language('common/main/main', 'tCMNDeleteAll') ?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<section id="odvContentRVD"></section>
	</div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<?php include('script/jRefillProductVDSearchList.php') ?>