<script type="text/javascript">

$(document).ready(function(){
	
	$('.selectpicker').selectpicker();

	$('#obtSearchDocDateFrom').click(function(){
		event.preventDefault();
		$('#oetSearchDocDateFrom').datepicker('show');
	});

	$('#obtSearchDocDateTo').click(function(){
		event.preventDefault();
		$('#oetSearchDocDateTo').datepicker('show');
	});

	$('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
		autoclose: true,
	});

	$(".selection-2").select2({
		// minimumResultsForSearch: 20,
		dropdownParent: $('#dropDownSelect1')
	});

});

// Event Click On/Off Advance Search
$('#oahTBAdvanceSearch').unbind().click(function(){
	if($('#odvTBAdvanceSearchContainer').hasClass('hidden')){
		$('#odvTBAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
	}else{
		$("#odvTBAdvanceSearchContainer").slideUp(500,function() {
			$(this).addClass('hidden');
		});
	}
});

// Advance Enter Search
$('#obtTBSubmitFrmSearchAdv').off('click').on('click',function(){
	JSvCallPageTBPdtDataTable();
});

var tUsrLevel 	  	= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
var tBchCodeMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
var nCountBch 		= "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
var tWhere 			= "";

if(nCountBch == 1){
    $('#obtTBBrowseBchFrom').attr('disabled',true);
    $('#obtTBBrowseBchTo').attr('disabled',true);
}
if(tUsrLevel != "HQ"){
    tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
}else{
    tWhere = "";
}

//Option Branch From
var oPmhBrowseBchFrom = {
	
	Title : ['company/branch/branch','tBCHTitle'],
	Table:{Master:'TCNMBranch',PK:'FTBchCode'},
	Join :{
		Table:	['TCNMBranch_L'],
		On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
	},
	Where : {
		Condition : [tWhere]
	},
	GrideView:{
		ColumnPathLang	: 'company/branch/branch',
		ColumnKeyLang	: ['tBCHCode','tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
		DataColumnsFormat : ['',''],
		Perpage			: 10,
		OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
		// SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetBchCodeFrom","TCNMBranch.FTBchCode"],
		Text		: ["oetBchNameFrom","TCNMBranch_L.FTBchName"],
	},
}
//Option Branch From

//Option Branch To
var oPmhBrowseBchTo = {
	
	Title : ['company/branch/branch','tBCHTitle'],
	Table:{Master:'TCNMBranch',PK:'FTBchCode'},
	Join :{
		Table:	['TCNMBranch_L'],
		On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
	},
	Where : {
		Condition : [tWhere]
	},
	GrideView:{
		ColumnPathLang	: 'company/branch/branch',
		ColumnKeyLang	: ['tBCHCode','tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
		DataColumnsFormat : ['',''],
		Perpage			: 10,
		OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
		// SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetBchCodeTo","TCNMBranch.FTBchCode"],
		Text		: ["oetBchNameTo","TCNMBranch_L.FTBchName"],
	},
}
//Option Branch To

//Event Browse
$('#obtTBBrowseBchFrom').click(function(){ JCNxBrowseData('oPmhBrowseBchFrom'); });
$('#obtTBBrowseBchTo').click(function(){ JCNxBrowseData('oPmhBrowseBchTo'); });

//Clear search data
function JSxTBClearSearchData() {
  var nStaSession = JCNxFuncChkSessionExpired();
  if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    try {

		var nCountBch = "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
		if(nCountBch != 1){ //ถ้ามีมากกว่า 1 สาขาต้อง reset 
			$("#oetBchCodeFrom").val("");
			$("#oetBchNameFrom").val("");
			$("#oetBchCodeTo").val("");
			$("#oetBchNameTo").val("");
		}
		
		$("#oetSearchAll").val("");
		$("#oetSearchDocDateFrom").val("");
		$("#oetSearchDocDateTo").val("");
		$(".xCNDatePicker").datepicker("setDate", null);
		$(".selectpicker")
        .val("0")
        .selectpicker("refresh");
      JSvCallPageTBPdtDataTable();
    } catch (err) {
      console.log("JSxTBClearSearchData Error: ", err);
    }
  } else {
    JCNxShowMsgSessionExpired();
  }
}

</script>