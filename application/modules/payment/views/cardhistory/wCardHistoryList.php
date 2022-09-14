<div class="panel-heading">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
			<!-- สาขา -->
			<div class="form-group"> 
				<label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tBranch'); ?></label>
				<?php
					$tBchCodeDef = $this->session->userdata('tSesUsrBchCodeDefault');
					$tBchNameDef = $this->session->userdata('tSesUsrBchNameDefault');
				?>
				<div class="input-group">
					<input type="text" class="input100 xCNHide" id="oetCrdHisBchCode" name="oetCrdHisBchCode" maxlength="5" value="<?php echo $tBchCodeDef; ?>">
					<input class="form-control xWPointerEventNone" type="text" id="oetCrdHisBchName" name="oetCrdHisBchName" readonly="" value="<?php echo $tBchNameDef; ?>">
					<span class="input-group-btn xWConditionSearchPdt">
						<button id="obtCrdHisBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
							<img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<!-- รหัสบัตร -->
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
			<label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCardCode'); ?></label>
			<div class="input-group">
				<input type="text" class="form-control xCNHide" id="oetCardHistoryCode" name="oetCardHistoryCode">
				<input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCardHistoryName" name="oetCardHistoryName" placeholder="<?php echo language('document/card/cardout','รหัสบัตร'); ?>" readonly="">
				<span class="input-group-btn">
					<button id="oimCardHistory" type="button" class="btn xCNBtnBrowseAddOn">
						<img src="<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>">
					</button>
				</span>
			</div>
		</div>

	    <!-- ประเภทบัตร -->
		<!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
			<label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCardType'); ?></label>
			<div class="input-group">
				<input type="text" class="form-control xCNHide" id="oetCardTypeHistory" name="oetCardTypeHistory">
				<input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCardTypeHistoryName" name="oetCardTypeHistoryName" placeholder="<?php echo language('document/card/cardout','ประเภทบัตร'); ?>" readonly="">
				<span class="input-group-btn">
					<button id="oimCardTypeHistory" type="button" class="btn xCNBtnBrowseAddOn">
						<img src="<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>">
					</button>
				</span>
			</div>
		</div> -->

		<!-- วันที่ -->
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
			<div class="form-group">
				<label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tDate'); ?></label>
				<div class="input-group">
					<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetCrdHisDate" name="oetCrdHisDate" autocomplete="off" value="" maxlength="10">
					<span class="input-group-btn">
						<button type="button" class="btn xCNBtnDateTime" onclick="$('#oetCrdHisDate').trigger('focus');">
							<img src="<?php echo base_url('application/modules/common/assets/images/icons/icons8-Calendar-100.png'); ?>">
						</button>
					</span>
				</div>
			</div>
		</div>

		<!-- ค้นหา ล้างข้อมูล -->
		<div class="col-xs-12 col-sm-12 col-md-2 co2-lg-2">
			<div class="form-group pull-left">
				<label class="xCNLabelFrm">&nbsp;</label>
				<div class="input-group">
					<a class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxGetCardHisDataTable()"><?php echo language('payment/card/card', 'tSearch'); ?></a>&nbsp;
					<a class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxTBIClearSearchData()"><?php echo language('payment/card/card', 'tResetData'); ?></a>
				</div>
			</div>
		</div>

			

	</div>
</div>
<div class="panel-body">
	<section id="ostDataCardHistory"></section>
</div>


<?php include "script/jCardHistoryAdd.php"; ?>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>

