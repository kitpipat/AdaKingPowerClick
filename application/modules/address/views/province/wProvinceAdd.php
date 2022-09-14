<?php
if($aResult['rtCode'] == "1"){
    $tPvnCode   	= $aResult['raItems']['rtPvnCode'];
	$tPvnName   	= $aResult['raItems']['rtPvnName'];
	$tPvnZneCode	= $aResult['raItems']['rtZneCode'];
	$tPvnZneName	= $aResult['raItems']['rtZneName'];
    $tRoute     	= "provinceEventEdit";
}else{
    $tPvnCode   	= "";
	$tPvnName   	= "";
	$tPvnZneCode	= "";
	$tPvnZneName	= "";
    $tRoute     	= "provinceEventAdd";
}
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddProvince">
	<button style="display:none" type="submit" id="obtSubmitProvince" onclick="JSnAddEditProvince('<?php echo $tRoute?>')"></button>
	<div class="panel-body" style="padding-top:20px !important;">
		<div class="row">
			<div class="col-xs-12 col-md-5 col-lg-5">
            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/province/province','tPVNFrmCode')?></label>
                <div class="form-group" id="odvPvnAutoGenCode">
                    <div class="validate-input">
                        <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbPvnAutoGenCode" name="ocbPvnAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group" id="odvPvnCodeForm">
				<input type="hidden" id="ohdCheckDuplicatePvnCode" name="ohdCheckDuplicatePvnCode" value="1" >
                    <div class="validate-input">
                        <input
                            type="text"
                            class="form-control xCNInputWithoutSpcNotThai"
                            maxlength="5"
                            id="oetPvnCode"
                            name="oetPvnCode"
                            data-is-created="<?php echo $tPvnCode; ?>"
                            placeholder="#####"
                            value="<?php echo $tPvnCode?>"
							data-validate-required = "<?php echo language('address/province/province','tPVNValidCode')?>"
							data-validate-dublicateCode = "<?php echo language('address/province/province','tPVNValidCodeDup');?>"
							>
                    </div>
                </div>

				<div class="form-group">
					<div class="validate-input">
					<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/province/province','tPVNFrmName')?></label>
						<input
							type="text"
							class="form-control xCNInputWithoutSpc"
							maxlength="200"
							id="oetPvnName"
							name="oetPvnName"
							value="<?php echo $tPvnName;?>"
							data-validate-required="<?php echo language('address/province/province','tPVNValidName')?>"
						>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<?php include 'script/jProvinceAdd.php';?>


<script type="text/javascript">
	var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;
	var oZneOption = {
		Title : ['address/zone/zone','tZNETitle'],
		Table:{Master:'TCNMZone',PK:'FTZneCode'},
		Join :{
			Table:	['TCNMZone_L'],
			On:['TCNMZone_L.FTZneCode = TCNMZone.FTZneCode AND TCNMZone_L.FNLngID = '+nLangEdits,]
		},
		GrideView:{
			ColumnPathLang	: 'address/zone/zone',
			ColumnKeyLang	: ['tZNECode','tZNEName','tZNEChainName'],
			DataColumns		: ['TCNMZone.FTZneCode','TCNMZone_L.FTZneName','TCNMZone_L.FTZneChainName'],
			Perpage			: 10,
			OrderBy			: ['TCNMZone.FTZneChain'],
			SourceOrder		: "ASC"
		},
		CallBack:{
			ReturnType	: 'S',
			Value		: ["oetPvnZnecode","TCNMZone,FTZneCode"],
			Text		: ["oetPvnZneName","TCNMZone_L.FTZneName"],
		},
		RouteAddNew : 'zone',
        BrowseLev	: nStaPvnBrowseType
	}
	$('#obtPvnBrowseZone').click(function(){JCNxBrowseData('oZneOption');});
</script>