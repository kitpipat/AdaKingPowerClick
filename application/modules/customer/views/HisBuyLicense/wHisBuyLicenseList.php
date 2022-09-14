<div class="panel-heading">
	<div class="row">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<div class="form-group">
				<label class="xCNLabelFrm"><?=language('common/main/main','tSearch')?></label>
				<div class="input-group">
					<input type="text" class="form-control" id="oetSearchAll" name="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvHisBuyDataTable(1)" placeholder="<?=language('common/main/main','tPlaceholder')?>">
					<span class="input-group-btn">
						<button class="btn xCNBtnSearch" type="button" onclick="JSvHisBuyDataTable(1)">
							<img class="xCNIconAddOn" src="<?=base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="margin-top: 25px;">
			<a id="oahHisBuyAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?=language('common/main/main', 'tAdvanceSearch'); ?></a>
			<a id="oahHisBuySearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxHisBuyClearSearchData()"><?=language('common/main/main', 'tClearSearch'); ?></a>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row hidden" id="odvHisbuyAdvanceSearchContainer" style="margin-bottom:20px;">

				<!--วันที่เอกสาร-->
				<div class="col-xs-12 col-md-4 col-lg-4">
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
						<div class="form-group">
							<label class="xCNLabelFrm"><?=language('document/adjuststockvd/adjuststockvd','tADJVDTBDocDate'); ?></label>
							<div class="input-group">
							<input  class="form-control input100 xCNDatePicker" type="text" id="oetSearchDocDateFrom" name="oetSearchDocDateFrom" placeholder="<?=language('document/adjuststockvd/adjuststockvd', 'tFrom'); ?>">
								<span class="input-group-btn" >
									<button id="obtSearchDocDateFrom" type="button" class="btn xCNBtnDateTime">
										<img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
									</button>
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
						<div class="form-group">
							<label class="xCNLabelFrm"><?=language('document/adjuststockvd/adjuststockvd','tTo'); ?></label>
							<div class="input-group">
							<input  class="form-control input100 xCNDatePicker" type="text" id="oetSearchDocDateTo" name="oetSearchDocDateTo" placeholder="<?=language('document/adjuststockvd/adjuststockvd', 'tTo'); ?>">
								<span class="input-group-btn" >
									<button id="obtSearchDocDateTo" type="button" class="btn xCNBtnDateTime">
										<img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>

				<!--ลูกค้า-->
				<div class="col-xs-12 col-md-2 col-lg-2">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?=language('customer/HisBuyLicense/HisBuyLicense', 'tHisTBDocumentCustomerName'); ?></label>
					</div>
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding padding-right-15">
						<div class="form-group">
							<div class="input-group">
								<input class="form-control xCNHide" id="oetCstCode" name="oetCstCode" maxlength="10">
								<input 
									class="form-control xWPointerEventNone" 
									type="text" id="oetCstName" 
									name="oetCstName" 
									placeholder="<?=language('customer/HisBuyLicense/HisBuyLicense', 'tHisTBDocumentCustomerName'); ?>" 
									readonly>
								<span class="input-group-btn">
									<button id="obtHisBuyBrowseCst" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?=base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>

				<!--ประเภทเอกสาร-->
				<div class="col-xs-12 col-md-2 col-lg-2">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentType'); ?></label>
					</div>
					<div class="form-group">
						<select class="selectpicker form-control" id="ocmStaTypeDoc" name="ocmStaTypeDoc">
							<option value='0'><?=language('common/main/main','tAll'); ?></option>
							<option value='1'><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentTypeSell'); ?></option>
							<option value='9'><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentTypeReturn'); ?></option>
						</select>
					</div>
				</div>

				<!--สถานะชำระเงิน-->
				<div class="col-xs-12 col-md-2 col-lg-2">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentStatusPayment'); ?></label>
					</div>
					<div class="form-group">
						<select class="selectpicker form-control" id="ocmStaPayment" name="ocmStaPayment">
							<option value='0'><?=language('common/main/main','tAll'); ?></option>
							<option value='1'><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentStatusPaymentFail'); ?></option>
							<option value='2'><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentStatusPaymentSome'); ?></option>
							<option value='3'><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentStatusPaymentSuccess'); ?></option>
						</select>
					</div>
				</div>	

				<!--ปุ่มค้นหา-->
				<div class="col-xs-12 col-md-2 col-lg-2">
					<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
						<label class="xCNLabelFrm"></label>
					</div>
					<a id="oahHisBuyAdvanceSearchSubmit" class="btn xCNBTNPrimery" style="width: 120px;" href="javascript:;" onclick="JSvHisBuyDataTable()"><?=language('common/main/main', 'tSearch'); ?></a>
				</div>
			</div>
		</div>
		
	</div>
</div>
<div class="panel-body">
	<section id="ostDataHisBuyLicenseList"></section>
</div>

<script>
	//ค้นหาขั้นสูง
	$('.selectpicker').selectpicker();	
	$('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
	});

	// Set Select  Doc Date
	$('#obtSearchDocDateFrom').unbind().click(function(){
        event.preventDefault();
        $('#oetSearchDocDateFrom').datepicker('show');
    });

    $('#obtSearchDocDateTo').unbind().click(function(){
        event.preventDefault();
        $('#oetSearchDocDateTo').datepicker('show');
    });
	
	//เลือกลูกค้า
	$('#obtHisBuyBrowseCst').unbind().click(function(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose();
			JCNxBrowseData('oHisBuyCustomer');
		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	var nLangEdits        = '<?=$this->session->userdata("tLangEdit");?>';
	var oHisBuyCustomer = {
		Title 	: 	['customer/customer/customer', 'tCSTTitle'],
		Table	:	{Master:'TCNMCst',PK:'FTCstCode'},
		Join 	:	{
			Table	:	['TCNMCst_L'],
			On		:	['TCNMCst_L.FTCstCode = TCNMCst.FTCstCode AND TCNMCst_L.FNLngID = '+nLangEdits,]
		},
		Where:{
			Condition : ["AND TCNMCst.FTCstStaActive = '1' "]
		},
		GrideView:{
			ColumnPathLang	: 'customer/customer/customer',
			ColumnKeyLang	: ['tCSTCode', 'tCSTName','tCSTTel'],
			ColumnsSize     : ['15%','50%','50%'],
			WidthModal      : 50,
			DataColumns		: ['TCNMCst.FTCstCode', 'TCNMCst_L.FTCstName','TCNMCst.FTCstTel'],
			DataColumnsFormat : ['',''],
			Perpage			: 10,
			OrderBy			: ['TCNMCst.FDCreateOn DESC']
		},
		CallBack:{
			ReturnType	: 'S',
			Value		: ["oetCstCode","TCNMCst.FTCstCode"],
			Text		: ["oetCstName","TCNMCst_L.FTCstName"],
		},
	}

	//กดค้นหาขั้นสูง
	$('#oahHisBuyAdvanceSearch').on('click', function() {
		if($('#odvHisbuyAdvanceSearchContainer').hasClass('hidden')){
			$('#odvHisbuyAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
		}else{
			$('#odvHisbuyAdvanceSearchContainer').addClass('hidden fadeIn');
		}
	});
</script>