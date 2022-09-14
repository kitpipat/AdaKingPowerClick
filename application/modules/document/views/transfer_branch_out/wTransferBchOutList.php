<div class="panel panel-headline">
	<div class="panel-heading">
		<section id="ostSearchTransferBchOut">
			<div class="row">
				<div class="col-xs-3 col-md-3">
					<div class="form-group">
						<div class="input-group">
							<input 
							class="form-control xCNInputWithoutSingleQuote" 
							type="text" id="oetSearchAll" 
							name="oetSearchAll" 
							placeholder="<?= language('document/topupVending/topupVending', 'tFillTextSearch') ?>" 
							onkeyup="Javascript:if(event.keyCode==13) JSvTransferBchOutCallPageDataTable()" 
							autocomplete="off">
							<span class="input-group-btn">
								<button type="button" class="btn xCNBtnDateTime" onclick="JSvTransferBchOutCallPageDataTable()">
									<img src="<?php echo  base_url('application/modules/common/assets/images/icons/search-24.png') ?>">
								</button>
							</span>
						</div>
					</div>
				</div>
				<a id="oahTransferBchOutAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
				<a id="oahTFWSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxTransferBchOutClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
			</div>

			<div class="row hidden" id="odvTransferBchOutAdvanceSearchContainer" style="margin-bottom:20px;">
				<div class="col-xs-12 col-md-6 col-lg-6">
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tBranch'); ?></label>
							<?php
								if ( $this->session->userdata("tSesUsrLevel") != "HQ" ){
									if( $this->session->userdata("nSesUsrBchCount") <= 1 ){
										$tBrowseBchDisabled = 'disabled';
										$tBCHCode    		= $this->session->userdata("tSesUsrBchCodeDefault");
										$tBCHName    		= $this->session->userdata("tSesUsrBchNameDefault");
									}else{
										$tBrowseBchDisabled = '';
										$tBCHCode    		= '';
										$tBCHName    		= '';
									}
								} else {
									$tBCHCode        		= "";
									$tBCHName        		= "";
									$tBrowseBchDisabled     = '';
								}
							?>
							<div class="input-group">
								<input class="form-control xCNHide" id="oetBchCodeFrom" name="oetBchCodeFrom" maxlength="5" value="<?= $tBCHCode; ?>">
								<input 
								class="form-control xWPointerEventNone" 
								type="text" id="oetBchNameFrom" 
								name="oetBchNameFrom" 
								placeholder="<?php echo language('document/topupVending/topupVending', 'tFrom'); ?>" 
								readonly
								value="<?= $tBCHName; ?>"
								>
								<span class="input-group-btn">
									<button id="obtTransferBchOutBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchBranchTo'); ?></label>
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
									<button id="obtTransferBchOutBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-6">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tTBDocDate'); ?></label>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
						<div class="form-group">
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
							<option value=''><?php echo language('common/main/main', 'tStaDocAll'); ?></option>

                            <option value='D1'><?php echo language('common/main/main', 'tStaDoc'); ?></option>
                            <option value='D2'><?php echo language('common/main/main', 'tStaDoc1'); ?></option>
                            <option value='D3'><?php echo language('common/main/main', 'tStaDoc3'); ?></option>

							<option value='D4'><?php echo language('document/transfer_branch_out/transfer_branch_out', 'tTBOIsWaitGenDocPack'); ?></option>
							<option value='D5'><?php echo language('document/transfer_branch_out/transfer_branch_out', 'tTBOIsWaitPackPdt'); ?></option>
							<option value='D6'><?php echo language('document/transfer_branch_out/transfer_branch_out', 'tTBOIsPackingPdt'); ?></option>
						</select>
					</div>
				</div>
				<!-- <div class="col-xs-12 col-md-3 col-lg-3">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tTBStaApv'); ?></label>
					</div>
					<div class="form-group">
						<select class="selectpicker form-control" id="ocmStaApprove" name="ocmStaApprove">
							<option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
							<option value='1'><?php echo language('common/main/main', 'tStaDocApv'); ?></option>
							<option value='2'><?php echo language('common/main/main', 'tStaDocPendingApv'); ?></option>
						</select>
					</div>
				</div> -->
				<div class="col-xs-12 col-md-3 col-lg-3">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tTBStaPrc'); ?></label>
					</div>
					<div class="form-group">
						<select class="selectpicker form-control" id="ocmStaPrcStk" name="ocmStaPrcStk">
							<option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
							<option value='1'><?php echo language('common/main/main', 'tStaDocProcessor'); ?></option>
							<option value='2'><?php echo language('common/main/main', 'tStaDocProcessing'); ?></option>
							<option value='3'><?php echo language('common/main/main', 'tStaDocPendingProcessing'); ?></option>
						</select>
					</div>
				</div>
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
                        <button id="oahTFWAdvanceSearchSubmit" class="btn xCNBTNPrimery" style="width:100%" onclick="JSvTransferBchOutCallPageDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></button>
                    </div>
                </div>
			</div>
		</section>
	</div>
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-8 col-md-4 col-lg-4">
			</div>
			<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:-35px;">
				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?= language('common/main/main', 'tCMNOption') ?>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvModalDel"><?= language('common/main/main', 'tCMNDeleteAll') ?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<section id="odvTransferBchOutContent"></section>
	</div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<?php include('script/jTransferBchOutList.php') ?>