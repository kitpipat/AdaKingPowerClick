<div id="odvPosRegister" class="panel panel-headline">
	<div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-md-9 col-lg-9">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                            <label class="xCNLabelFrm"><?php echo language('common/main/main','tSearchNew')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchDpcDis" name="oetSearchDpcDis" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
                                <span class="input-group-btn">
                                    <button id="oimSearchDpcDis" class="btn xCNBtnSearch" type="button">
                                        <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="odvContentDpcDisTable"></div>
	</div>
</div>

<script>
	$('#oimSearchDpcDis').click(function(){
		JCNxOpenLoading();
		JSvDpcDisDataTable();
	});
	$('#oetSearchDpcDis').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvDpcDisDataTable();
		}
	});
</script>

