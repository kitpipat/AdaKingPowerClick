    <!-- LEFT PANEL -->
    <div class="col-xs-12 col-md-4 col-lg-4" >



            <div class="panel panel-default" style="margin-bottom: 0px;"> 
				<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?=language('sale/salemonitor/salemonitor', 'tIMPStaTus')?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataPromotion" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataPromotion" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
			
						<label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tIMPDocNo')?></label>
						<div class="form-group" id="odvPunCodeForm">
							<input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="20" id="oetXthDocNo" name="oetXthDocNo" data-is-created=""  value="" data-validate-required="กรุณากรอกหรือคลิกรันเลขที่เอกสาร" data-validate-dublicatecode="ไม่สามารถใช้เลขที่เอกสารนี้ได้" readonly="" >
							<input type="hidden" value="2" id="ohdCheckDuplicateTFW" name="ohdCheckDuplicateTFW"> 
						</div>

						<div class="form-group">
							<label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tIMPDocDate')?></label>
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXthDocDate" name="oetXthDocDate" value=""  maxlength="10"  readonly="">
						</div>

						<div class="form-group">
							<label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSMTBchName')?></label>
								<input type="text" class="form-control xCNTimePicker" id="oetBchName" name="oetBchName" value=""   readonly=""> 
						</div>

                        <div class="form-group">
							<label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tIMPStatusDoc')?></label>
								<input type="text" class="form-control xCNTimePicker" id="oetStaDoc" name="oetStaDoc" value=""   readonly="">
						</div>

			
					</div>
				</div>    
			</div>

            <div class="panel panel-default" style="margin-bottom: 50px;"> 

				<div id="odvDataPromotion" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
			
						<label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tIMPCstCode')?></label>
						<div class="form-group" id="odvPunCodeForm">
							<input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="20" id="oetCstCode" name="oetCstCode" data-is-created="" placeholder="" value="" data-validate-required="กรุณากรอกหรือคลิกรันเลขที่เอกสาร" data-validate-dublicatecode="ไม่สามารถใช้เลขที่เอกสารนี้ได้" readonly="" >
							<input type="hidden" value="2" id="ohdCheckDuplicateTFW" name="ohdCheckDuplicateTFW"> 
						</div>

						<div class="form-group">
							<label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tIMPCstName')?></label>
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetCstName" name="oetCstName" value=""  maxlength="10"  readonly="">
						</div>

			
					</div>
				</div>    
			</div>


    </div>

      <div class="col-xs-12 col-md-8 col-lg-8">
            <div class="panel panel-default" style="margin-bottom: 0px;"> 
			         <div class="panel-body xCNPDModlue">
					 <div class="row">
                            <div class="col-xs-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="xCNLabelFrm">
									<?=language('sale/salemonitor/salemonitor', 'tMQISearch')?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="oetSearchSpaPdtPri" name="oetSearchSpaPdtPri" placeholder="<?=language('sale/salemonitor/salemonitor', 'tMQISearch')?>">
                                        <span class="input-group-btn">
                                            <button id="oimSearchSpaPdtPri" class="btn xCNBtnSearch" type="button">
                                                <img class="xCNIconAddOn" src="http://202.44.55.96:81/AdaKubota//application/modules/common/assets/images/icons/search-24.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

								<div id="odvImpDataTable">
								
								</div>

								<div class="row" >
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class="panel panel-default">
											<div class="panel-heading mark-font" id="odvDataTextBath"><?=language('sale/salemonitor/salemonitor', 'tIMPBath')?></div>
										</div>
										
										
										<textarea id="otxDataRemark" readonly></textarea>
											
										
									</div>
									<!-- End Of Bill -->
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="odvRowDataEndOfBill">
										<div class="panel panel-default">
											<div class="panel-body">

												<div class="">
													<label class="pull-left mark-font"><?=language('sale/salemonitor/salemonitor', 'tIMPSumTotal')?></label>
													<label class="pull-right mark-font" id="olbCalFCXphGrand">0.00</label>
													<div class="clearfix"></div>
												</div>
												<div class="">
													<label class="pull-left mark-font"><?=language('sale/salemonitor/salemonitor', 'tIMPDiscount')?></label>
													<label class="pull-right mark-font" id="olbCalFCXphGrand">0.00</label>
													<div class="clearfix"></div>
												</div>
												<div class="">
													<label class="pull-left mark-font"><?=language('sale/salemonitor/salemonitor', 'tIMPVat')?></label>
													<label class="pull-right mark-font" id="olbCalFCXphGrand">0.00</label>
													<div class="clearfix"></div>
												</div>

											</div>
											<div class="panel-heading">
												<label class="pull-left mark-font"><?=language('sale/salemonitor/salemonitor', 'tIMPGrand')?></label>
												<label class="pull-right mark-font" id="olbCalFCXphGrand">0.00</label>
												<div class="clearfix"></div>
											</div>
										</div>
									</div>
								</div>


					 </div>
            </div>
      </div>

<script>
    $(document).ready(function(){
		JCNxOpenLoading();
		JCNxIMPCallDataTable();
	});
  			 // Function: Confirm Filter DashBoard
            // Parameters: Document Ready Or Parameter Event
            // Creator: 06/02/2020 Nattakit
            // Return: View Data Table
            // ReturnType: View
            function JCNxIMPCallDataTable(){
                $.ajax({
                    type: "POST",
                    url: "dasIMPCallDataTable",
                    data: {tIMPSearch:''},
                    cache: false,
                    timeout: 0,
                    success : function(paDataReturn){
                        $('#odvImpDataTable').html(paDataReturn);
                        JCNxCloseLoading();
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR,textStatus,errorThrown);
                    }
				});
				

				$('#oimSearchSpaPdtPri').click(function(){
    				JSxIMPRanderHDDT($('#oetXthDocNo').val(),1);
				});

				$('#oetSearchSpaPdtPri').keyup(function(){

					JSxIMPRanderHDDT($('#oetXthDocNo').val(),1);
				});
					}
</script>