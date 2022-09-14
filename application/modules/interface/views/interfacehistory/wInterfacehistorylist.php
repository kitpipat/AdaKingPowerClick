<div class="panel-heading">
	<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock','tASTFillTextSearch')?></label>
                    <div class="input-group">
                        <input
                            class="form-control xCNInpuASTthoutSingleQuote"
                            type="text"
                            id="oetSearchAll"
                            name="oetSearchAll"
                            placeholder="<?php echo language('document/adjuststock/adjuststock','tASTFillTextSearch')?>"
                            onkeyup="Javascript:if(event.keyCode==13) JSvSearchAllIFH()"
                            autocomplete="off"
                        >
                        <span class="input-group-btn">
                            <button type="button" class="btn xCNBtnDateTime" onclick="JSvSearchAllIFH()">
                                <img class="xCNIconSearch">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
										<label class="xCNLabelFrm"><?php echo language('interface/interfacehistory', 'tIFHDatefrom')?></label>
                    <div class="input-group">
                        <input
                            class="form-control xCNDatePicker"
                            type="text"
                            id="oetIFHDocDateFrom"
                            name="oetIFHDocDateFrom"
                            placeholder="<?php echo language('interface/interfacehistory', 'tIFHDatefrom'); ?>"
                            value="<?=date("Y-m-d")?>"
                        >
                        <span class="input-group-btn" >
                            <button  type="button" id="obtIFHDocDateFrom" class="btn xCNBtnDateTime "> <img class="xCNIconCalendar"></button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
								  	<label class="xCNLabelFrm"><?php echo language('interface/interfacehistory', 'tIFHDateto')?></label>
                    <div class="input-group">
                        <input
                            class="form-control xCNDatePicker"
                            type="text"
                            id="oetIFHDocDateTo"
                            name="oetIFHDocDateTo"
                            placeholder="<?php echo language('interface/interfacehistory', 'tIFHDateto'); ?>"
                            value="<?=date("Y-m-d")?>"
                        >
                        <span class="input-group-btn" >
                            <button  type="button" id="obtIFHDocDateTo" class="btn xCNBtnDateTime" onclick=""><img class="xCNIconCalendar"></button>
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
								<label class="xCNLabelFrm"><?php echo language('interface/interfacehistory', 'tIFHStatus')?></label>
                <div class="form-group">
                    <select class="selectpicker form-control" id="ocmIFHStaDone" name="ocmIFHStaDone">
                        <option value=''><?php echo language('interface/interfacehistory','tIFHStatus'); ?></option>
                        <option value='1'><?php echo language('interface/interfacehistory','tIFHSuccess'); ?></option>
                        <option value='2'><?php echo language('interface/interfacehistory','tIFHFail'); ?></option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
								<label class="xCNLabelFrm"><?php echo language('interface/interfacehistory', 'tIFHType')?></label>
                <div class="form-group">
                    <select class="selectpicker form-control" id="ocmITFXXshType" name="ocmITFXXshType">
												<option value=''><?php echo language('interface/interfacehistory','tIFHTypeAll'); ?></option>
                        <option value='1'><?php echo language('interface/interfacehistory','tIFHImport'); ?></option>
                        <option value='2'><?php echo language('interface/interfacehistory','tIFHExport'); ?></option>

                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
							<label class="xCNLabelFrm"><?php echo language('interface/interfacehistory', 'tIFHList')?></label>
                <div class="form-group">
                    <select class="selectpicker form-control" id="ocmIFHInfCode" name="ocmIFHInfCode">
                        <option value=''><?php echo language('interface/interfacehistory','tIFHList'); ?></option>
                        <?php if(!empty($aDataMasterImport)){
                            foreach($aDataMasterImport as $aData){ ?>
                        <option value='<?php echo $aData['FTApiCode']; ?>' class="xWIFHDocType xWIFHDoctype_<?=$aData['FTApiTxnType'];?>"><?php echo $aData['FTApiName']; ?></option>
                        <?php } }  ?>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
								<label class="xCNLabelFrm"></label>
                <div class="form-group">
                    <div class="input-group">
											<div class="row">
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<a  id="oahIFHClearSearchData" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" > <?php echo language('interface/interfacehistory','tIFHBtnClearSearch'); ?></a>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<a  id="oahIFHSearchData" class="btn xCNBTNPrimery xCNBTNDefult1Btn" href="javascript:;" onclick="JSvCallPageIFHDataTable()"> <?php echo language('interface/interfacehistory','tIFHBtnSearch'); ?></a>
												</div>
											</div>



                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="panel-body">

	<div id="odvContentIFHDatatable"></div>
</div>

<script>
    $(document).ready(function(){
        $('.selectpicker').selectpicker();
    });
    $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
    });

    $('#obtIFHDocDateTo').on('click',function(){
        $('#oetIFHDocDateTo').datepicker('show');
    });

    $('#obtIFHDocDateFrom').on('click',function(){
        $('#oetIFHDocDateFrom').datepicker('show');
    });
		$('#oahIFHClearSearchData').on('click',function(){
				JCNxOpenLoading();
				$("#oetSearchAll").val("");
				$("#oetIFHDocDateFrom").val("");
				$("#oetIFHDocDateTo").val("");
				$("#ocmIFHStaDone").selectpicker('val', '');
				$("#ocmIFHType").selectpicker('val', '');
				$("#ocmIFHInfCode").selectpicker('val', '');
				$('.selectpicker').selectpicker('refresh');
				JCNxCloseLoading();
		});


    //Added by Napat(Jame) 03/04/63
    $('#ocmIFHType').on('change',function(e){
        if(this.value != ''){
            $('.xWIFHDocType').css('display','none');
            $('.xWIFHDoctype_' + this.value).css('display','block');
        }else{
            $('.xWIFHDocType').css('display','block');
        }
    });
</script>
