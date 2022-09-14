<script type="text/javascript">

$(document).ready(function(){

	localStorage.removeItem("LocalItemData");
	
	$('.selectpicker').selectpicker();

	$('#obtXphDocDateFrom').click(function(){
		event.preventDefault();
		$('#oetXphDocDateFrom').datepicker('show');
	});

	$('#obtXphDocDateTo').click(function(){
		event.preventDefault();
		$('#oetXphDocDateTo').datepicker('show');
	});

	$('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
	});

	$(".selection-2").select2({
		// minimumResultsForSearch: 20,
		dropdownParent: $('#dropDownSelect1')
	});

});

// Advance search display control
$('#oahTVOAdvanceSearch').on('click', function() {
	if($('#odvTVOAdvanceSearchContainer').hasClass('hidden')){
		$('#odvTVOAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
	}else{
		$('#odvTVOAdvanceSearchContainer').addClass('hidden fadeIn');
	}
});


// Option Branch From
var tWhereModal = "";
var tUsrLevel   = "<?php echo $this->session->userdata("tSesUsrLevel");?>";
var tBchMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
if(tUsrLevel != "HQ"){
	tWhereModal 	+= " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
}
			
var oPmhBrowseBchFrom = {
	
	Title : ['company/branch/branch','tBCHTitle'],
	Table:{Master:'TCNMBranch',PK:'FTBchCode'},
	Join :{
		Table:	['TCNMBranch_L'],
		On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
	},
	Where : {
		Condition : [tWhereModal]
	},
	GrideView:{
		ColumnPathLang	: 'company/branch/branch',
		ColumnKeyLang	: ['tBCHCode','tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMBranch.FTBchCode ASC'],
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetBchCodeFrom","TCNMBranch.FTBchCode"],
		Text		: ["oetBchNameFrom","TCNMBranch_L.FTBchName"],
	},
}
// Option Branch From

// Option Branch To
var oPmhBrowseBchTo = {
	
	Title : ['company/branch/branch','tBCHTitle'],
	Table:{Master:'TCNMBranch',PK:'FTBchCode'},
	Join :{
		Table:	['TCNMBranch_L'],
		On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
	},
	Where : {
		Condition : [tWhereModal]
	},
	GrideView:{
		ColumnPathLang	: 'company/branch/branch',
		ColumnKeyLang	: ['tBCHCode','tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMBranch.FTBchCode ASC'],
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetBchCodeTo","TCNMBranch.FTBchCode"],
		Text		: ["oetBchNameTo","TCNMBranch_L.FTBchName"],
	},
}
// Option Branch To

// Event Browse
$('#obtTVOBrowseBchFrom').unbind().click(function(){
	var nStaSession = JCNxFuncChkSessionExpired();
	if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
		JSxCheckPinMenuClose(); // Hidden Pin Menu
		JCNxBrowseData('oPmhBrowseBchFrom');
	}else{
		JCNxShowMsgSessionExpired();
	}
});
$('#obtTVOBrowseBchTo').unbind().click(function(){
	var nStaSession = JCNxFuncChkSessionExpired();
	if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
		JSxCheckPinMenuClose(); // Hidden Pin Menu
		JCNxBrowseData('oPmhBrowseBchTo');
	}else{
		JCNxShowMsgSessionExpired();
	}
});

</script>