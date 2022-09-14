<script type="text/javascript">

$(document).ready(function(){
	
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
		dropdownParent: $('#dropDownSelect1')
	});

});

// Advance search display control
$('#oahADJVDAdvanceSearch').on('click', function() {
	if($('#odvADJVDAdvanceSearchContainer').hasClass('hidden')){
		$('#odvADJVDAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
	}else{
		$('#odvADJVDAdvanceSearchContainer').addClass('hidden fadeIn');
	}
});

//Option Branch From
var oPmhBrowseBchFrom = {
	
	Title : ['company/branch/branch','tBCHTitle'],
	Table:{Master:'TCNMBranch',PK:'FTBchCode'},
	Join :{
		Table:	['TCNMBranch_L'],
		On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
	},
	GrideView:{
		ColumnPathLang	: 'company/branch/branch',
		ColumnKeyLang	: ['tBCHCode','tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMBranch_L.FTBchName'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetBchCodeFrom","TCNMBranch.FTBchCode"],
		Text		: ["oetBchNameFrom","TCNMBranch_L.FTBchName"],
	},
}

//Option Branch To
var oPmhBrowseBchTo = {
	
	Title : ['company/branch/branch','tBCHTitle'],
	Table:{Master:'TCNMBranch',PK:'FTBchCode'},
	Join :{
		Table:	['TCNMBranch_L'],
		On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
	},
	GrideView:{
		ColumnPathLang	: 'company/branch/branch',
		ColumnKeyLang	: ['tBCHCode','tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMBranch_L.FTBchName'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetBchCodeTo","TCNMBranch.FTBchCode"],
		Text		: ["oetBchNameTo","TCNMBranch_L.FTBchName"],
	},
}

//Event Browse
$('#obtADJVDBrowseBchFrom').unbind().click(function(){
	var nStaSession = JCNxFuncChkSessionExpired();
	if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
		JSxCheckPinMenuClose();
		JCNxBrowseData('oPmhBrowseBchFrom');
	}else{
		JCNxShowMsgSessionExpired();
	}
});
$('#obtADJVDBrowseBchTo').unbind().click(function(){
	var nStaSession = JCNxFuncChkSessionExpired();
	if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
		JSxCheckPinMenuClose();
		JCNxBrowseData('oPmhBrowseBchTo');
	}else{
		JCNxShowMsgSessionExpired();
	}
});

//ล้างค่าในค้นหาขั้นสูง
function JSxADJVDClearSearchData() {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    try {
      $("#oetSearchAll").val("");
      $("#oetBchCodeFrom").val("");
      $("#oetBchNameFrom").val("");
      $("#oetBchCodeTo").val("");
      $("#oetBchNameTo").val("");
      $("#oetSearchDocDateFrom").val("");
      $("#oetSearchDocDateTo").val("");
      $(".xCNDatePicker").datepicker("setDate", null);
      $(".selectpicker").val("0").selectpicker("refresh");
      JSvCallPageADJVDPdtDataTable();
    } catch (err) {
      console.log("JSxADJVDClearSearchData Error: ", err);
    }
  } else {
    JCNxShowMsgSessionExpired();
  }
}
</script>