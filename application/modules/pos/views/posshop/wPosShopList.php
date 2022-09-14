<input id="oetPshPSHBchCode"  type="hidden" value="<?=$aPSHBchCode?>">
<input id="oetPshPSHShpCod"   type="hidden" value="<?=$aPSHShpCode?>">
<input id="oetPshPSHMerCode"  type="hidden" value="<?=$aPSHMerCode?>">
<input id="oetPshPSHShpType"  type="hidden" value="<?=$tPSHShpTypeCode?>">
<span id="ospRefCode" class="xCNHide"><?php echo $tRefCode;?></span>
<div id="odvPshContent">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
		<p style="font-weight: bold;"><?=language('pos/posshop/posshop','tPshTBDataPos')?></p>
		</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchPosShop" name="oetSearchPosShop" onkeypress="Javascript:if(event.keyCode==13) JSvSearchAll()" autocomplete="off"  placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
						<span class="input-group-btn">
							<button class="btn xCNBtnSearch" type="button" onclick="JSvSearchAll()">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
    	</div>
		<!--ปุ่มเพิ่ม-->
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-right">
		<?php if($aAlwEventPosShop['tAutStaFull'] == 1 || $aAlwEventPosShop['tAutStaDelete'] == 1 ) : ?>
				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?=language('common/main/main','tCMNOption')?>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvModalDeleteMutirecord"><?=language('common/main/main','tDelAll')?></a>
						</li>
					</ul>
				</div>
			<?php endif; ?>
			<button  class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPagePosShopEventAdd()">+</button>
		</div>
		<!--content-->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div id="odvPSHContentInfoPS"></div>
		</div>
	</div>
</div>

<script src="<?= base_url('application/modules/pos/assets/src/posshop/jPosShop.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jPosShopMain.php"; ?>
<script type="text/javascript">
	$('.selectpicker').selectpicker();
	$(document).ready(function () {
		$('#btnBrowsePos').click(function(){ JCNxBrowseData('oCmpBrowsePos'); });
		// $('#odvBtnShpInfo').hide();
		var tSHPCode = $('#oetShpCode').val();
		$('#oetShpCodePosList').val(tSHPCode);

		var tBCHCode = $('#oetBchCode').val();
		$('#oetBchCode').val(tBCHCode);
	});

	$('#obtAddPosShop').click(function(){
		JSoAddPosShop();
	});

	

	//Browse POS
    var oCmpBrowsePos = {
        Title 	: ['pos/posshop/posshop','tPshBRWPOSTitle'],
		Table	: {Master:'TCNMPos',PK:'FTPosCode'},
		Join 	: {
            Table	:	['TCNMPosLastNo'],
            On		:	["TCNMPosLastNo.FTPosCode = TCNMPos.FTPosCode"]
        },
        GrideView:{
            ColumnPathLang	: 'pos/posshop/posshop',
            ColumnKeyLang	: ['tPshTBNo','tPshTBPosCode'],
            ColumnsSize     : ['10%','90%'],
            DataColumns		: ['TCNMPos.FTPosCode','TCNMPosLastNo.FTPosComName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMPos.FTPosCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetPosCode","TCNMPos.FTPosCode"],
            Text		: ["oetPosName","TCNMPosLastNo.FTPosComName"],
		},
		//DebugSQL : true
	}

</script>




