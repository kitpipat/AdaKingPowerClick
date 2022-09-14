<?php 

$nSessionBCH = $this->session->userdata("tSesUsrBchCode");
$nSessionSHP = $this->session->userdata("tSesUsrShpCode");

if(!empty($aResult)){
	$tBchCode       = $aResult['raItems']['rtVslBch'];
    $tBchName       = $aResult['raItems']['rtBchName'];
	$tVstShopCode	= $aResult['raItems']['rtVslShp'];
	$tVstShpName	= $aResult['raItems']['rtShpName'];
	$tVstRowQty		= $aResult['raItems']['rtVslRowQty'];
	$tVstColQty		= $aResult['raItems']['rtVslColQty'];
	$tVstRemark		= $aResult['raItems']['rtVslRemark'];
	$tVstName		= $aResult['raItems']['rtVslName'];
	$tRoute         = "VendingShopLayoutEventEdit";
	$tTypePageVSL 	= 'Edit';
}else{
	// if($nSessionBCH != ''){
	// 	$tBchCode       = $this->session->userdata("tSesUsrBchCode");
	// }else{
	// 	$tBchCode       = '';
	// }

	// if($nSessionSHP != ''){
	// 	$tVstShopCode       = $this->session->userdata("tSesUsrShpCode");
	// }else{
	// 	$tVstShopCode       = '';
	// }

	$tBchCode       = '';
	$tVstShopCode   = '';
    $tBchName       = '';
	$tVstShpName	= '';
	$tVstRowQty		= '0';
	$tVstColQty		= '0';
	$tVstRemark		= '';
	$tVstName		= '';
	$tRoute         = "VendingShopLayoutEventAdd";
	$tTypePageVSL	= 'Add';
}

$tBCH           = explode(",",$FTBchCode);
$nCountBCH      = FCNnHSizeOf($tBCH);

?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddVendingShoplayout">
	
	<div style="clear: both;"></div>

	<div class="" style="padding-top:0px !important;">
	
		<div class="row">
			<div class="col-xs-12 col-md-4 col-lg-4">

				<input type="text" class="form-control xCNHide" id="oetCountBranchVSL"  	name="oetCountBranchVSL"   	value="<?php echo @$nCountBCH?>">
				<input type="text" class="form-control xCNHide" id="oetBranchCodeVSL" 		name="oetBranchCodeVSL" 	value="<?php echo @$FTBchCode?>">
				<input type="text" class="form-control xCNHide" id="oetShopCodeVSL" 		name="oetShopCodeVSL" 		value="<?php echo @$FTShpCode?>">
                <input type="text" class="form-control xCNHide" id="ohdTypepageVSL"     	name="ohdTypepageVSL"      	value="<?php echo @$tTypePageVSL?>">

				 <!-- <div class="form-group" id="odvWhaBCH">
                    <label class="xCNLabelFrm"><span style="color:red">*</span> <?//php echo language('authen/user/user','tUSRBranch')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetBranchCode" name="oetBranchCode" value="<?//php echo @$tBchCode?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetBranchName" name="oetBranchName" value="<?//php echo @$tBchName?>" readonly data-validate="<?//php echo language('vending/vendingshoptype/vendingshoptype','tVstValidBCH')?>">
                        <span class="input-group-btn">
                            <button id="oimBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?//php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
		
			 	<div class="form-group" id="odvWhaShop">
                    <label class="xCNLabelFrm"><span style="color:red">*</span> <?//php echo language('authen/user/user','tUSRShop')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetShopCode" name="oetShopCode" value="<?//php echo @$tVstShopCode?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetShopName" name="oetShopName" value="<?//php echo @$tVstShpName?>" readonly data-validate="<?//php echo language('vending/vendingshoptype/vendingshoptype','tVstValidStoreName')?>">
                        <span class="input-group-btn">
                            <button id="oimBrowseShop" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?//php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div> -->

				<div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('vending/Vendingshoplayout/Vendingshoplayout','tVstName')?></label>
						<input type="text" class="form-control" id="oetLayName" name="oetLayName"  data-validate="<?=language('vending/Vendingshoplayout/Vendingshoplayout','tVstvalidateName')?>" value="<?= $tVstName?>">
					</div>
				</div>

			</div>

			<div class="col-xs-12 col-lg-2 col-md-2">
				<div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><?= language('vending/Vendingshoplayout/Vendingshoplayout','tVstRowQty')?></label>
						<input type="hidden" id="ohdOldRowQty" name="ohdOldRowQty" value="<?=number_format($tVstRowQty,0)?>">
						<input type="text" class="form-control xCNInputNumericWithoutDecimal" style="text-align: right;"  id="oetVstRowQty" name="oetVstRowQty" maxlength="2" value="<?=number_format($tVstRowQty,0)?>">
					</div>
				</div>
			</div> 

			<div class="col-xs-12 col-lg-2 col-md-2">
				<div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><?= language('vending/Vendingshoplayout/Vendingshoplayout','tVstColQty')?></label>
						<input type="hidden" id="ohdOldColQty" name="ohdOldColQty" value="<?=number_format($tVstColQty,0)?>">
						<input type="text" class="form-control xCNInputNumericWithoutDecimal" style="text-align: right;"  id="oetVstColQty" name="oetVstColQty" value="<?=number_format($tVstColQty,0)?>">
					</div>
				</div>
			</div> 

			<div class="col-xs-12 col-lg-2 col-md-2">
				<div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><?= language('vending/Vendingshoplayout/Vendingshoplayout','tVstRemark')?></label>
						<input type="text" class="form-control" id="oetLayRemark" name="oetLayRemark" value="<?= $tVstRemark?>">
					</div>
				</div>
			</div> 

			<div class="col-lg-2">
				<div class="form-group" id="obtBTNInsertFormatvending" style="margin-top: 25px; display: block;">
					<button type="submit" style="float: right;  width: 100%;" id="" class="btn btn-primary" onclick="JSnAddEditVendingShopLayout('<?=$tRoute?>')"><?php echo language('vending/vendingshoplayout/vendingshoplayout', 'tSave')?></button>
				</div>
			</div>

			<div class="col-lg-2">
				<div class="form-group" id="obtBTNUpdateFormatvending" style="margin-top: 25px; display: none;">
					<button type="submit" style="float: right;  width: 100%;" id="" class="btn btn-primary" onclick="JSnAddEditVendingShopLayout('<?=$tRoute?>')"><?php echo language('vending/vendingshoplayout/vendingshoplayout', 'tBtSave')?></button>
				</div>
			</div>

		</div>
		
	</div>
</form>

<!-- modal set height-->
<div class="modal fade" id="odvModalWaringColLess">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('vending/Vendingshoplayout/Vendingshoplayout', 'tWaringColLess')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
						<?php echo language('vending/Vendingshoplayout/Vendingshoplayout', 'tWaringColLessText')?>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnVendingConfirmColLess()">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<div id="odvContentPageVendingShoplayout"></div> 

<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
	 var tTypePage = '<?=$tTypePageVSL?>';
    if(tTypePage == 'Add'){
        $('#obtBTNInsertFormatvending').css('display','block');
        $('#obtBTNUpdateFormatvending').css('display','none');
    }else if(tTypePage == 'Edit'){
        $('#obtBTNUpdateFormatvending').css('display','block');
		$('#obtBTNInsertFormatvending').css('display','none');
		
		var tShopCode = $('#oetShopCodeVSL').val();
		JSnVendingShoplayoutManageProduct(tShopCode);
	}

	// $('#oetVstRowQty').change(function() {
	// 	alert('tset');
	// });
	
	// if('<?//=$tTypepage?>' == 'Add'){
	// 	var tBchCode 	= '<?//=$tBchCode?>';
	// 	var tShopCode 	= '<?//=$tVstShopCode?>';

	// 	if(tBchCode == null || tBchCode == ''){
	// 		$('#odvWhaBCH').css('display','block');
	// 		$('#oimBrowseShop').attr('disabled',true);
	// 	}else{
	// 		$('#odvWhaBCH').css('display','none');
	// 	}

	// 	if(tShopCode == null || tShopCode == ''){
	// 		$('#odvWhaShop').css('display','block');
	// 	}else{
	// 		$('#odvWhaShop').css('display','none');
	// 	}
	// }else if('<?//=$tTypepage?>' == 'Edit'){
	// 	$('#oimBrowseBranch').attr('disabled',true);
	// 	$('#oimBrowseShop').attr('disabled',true);
	// }

	//Option BCH
	// var nLangEdits    = <?//=$this->session->userdata("tLangEdit")?>;
    // var oBrowseBranch = {
    //     Title : ['authen/user/user','tBrowseBCHTitle'],
    //     Table:{Master:'TCNMBranch',PK:'FTBchCode'},
    //     Join :{
    //         Table:	['TCNMBranch_L'],
    //         On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
	// 	},
    //     GrideView:{
    //         ColumnPathLang	: 'authen/user/user',
    //         ColumnKeyLang	: ['tBrowseBCHCode','tBrowseBCHName'],
    //         ColumnsSize     : ['10%','75%'],
    //         DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
    //         DataColumnsFormat : ['',''],
    //         WidthModal      : 50,
    //         Perpage			: 10,
    //         OrderBy			: ['TCNMBranch.FTBchCode'],
    //         SourceOrder		: "ASC"
    //     },
    //     CallBack:{
    //         ReturnType	: 'S',
    //         Value		: ["oetBranchCode","TCNMBranch.FTBchCode"],
    //         Text		: ["oetBranchName","TCNMBranch_L.FTBchName"],
    //     },
    //     NextFunc:{
    //         FuncName    :   'JSxChangeBranch',
    //         ArgReturn   :   ['FTBchCode'],
    //     },
    //     RouteAddNew : 'branch',
    //     BrowseLev : 1
    // }
    // $('#oimBrowseBranch').click(function(){JCNxBrowseData('oBrowseBranch');})
    // function JSxChangeBranch(elm){
	// 	var aData 	= JSON.parse(elm);
	// 	tBchCode  	= aData[0];
	// 	$('#oetBranchCode').val(tBchCode);
	// 	var tValue 	= $('#oetBranchCode').val();
	// 	oBrowseShop.Where.Condition = ["AND TCNMShop.FTBchCode = '"+tBchCode+"'"];

	// 	if(tBchCode != tValue){
	// 		$('#oetShopCode').val('');
	// 		$('#oetShopName').val('');
	// 	}

	// 	$('#oimBrowseShop').attr('disabled',false);
	// }
	
	//Option SHP
	// var oBrowseShop = {
	// 	Title 	: ['authen/user/user','tBrowseSHPTitle'],
	// 	Table	: {Master:'TCNMShop',PK:'FTShpCode'},
	// 	Join 	: {
	// 		Table	:	['TCNMShop_L'],
	// 		On		:['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,]
	// 	},
	// 	Where :{
	// 		Condition : ["AND TCNMShop.FTBchCode = '"+tBchCode+"'"]
	// 	},
	// 	Filter	: {
	// 		Selector	:'oetBranchCode',
	// 		Table		:'TCNMShop',
	// 		Key			:'FTBchCode'
	// 	},
	// 	GrideView : {
	// 		ColumnPathLang	: 'authen/user/user',
	// 		ColumnKeyLang	: ['tBrowseSHPCode','tBrowseSHPName'],
	// 		ColumnsSize     : ['10%','75%'],
	// 		WidthModal      : 50,
	// 		DataColumns		: ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName'],
	// 		DataColumnsFormat : ['',''],
	// 		Perpage			: 5,
	// 		OrderBy			: ['TCNMShop.FTShpCode'],
	// 		SourceOrder		: "ASC"
	// 	},
	// 	CallBack : {
	// 		StaSingItem : '1',
	// 		ReturnType	: 'S',
	// 		Value		: ["oetShopCode","TCNMShop.FTShpCode"],
	// 		Text		: ["oetShopName","TCNMShop_L.FTShpName"],
	// 	},
	// }
	// $('#oimBrowseShop').click(function(){JCNxBrowseData('oBrowseShop');})
</script>