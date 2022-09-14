<script type="text/javascript">

$(document).ready(function(){
	
	$('.selectpicker').selectpicker();

	//DATE
	$('#obtXphDocDateFrom').click(function(){
		event.preventDefault();
		$('#oetXphDocDateFrom').datepicker('show');
	});

	$('#obtXphDocDateTo').click(function(){
		event.preventDefault();
		$('#oetXphDocDateTo').datepicker('show');
	});

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
	});
	//DATE

	FSvGetSelectShpByBch('');

	$('#ostBchCode').change(function(){
		tBchCode = $(this).val();
		FSvGetSelectShpByBch(tBchCode);
	});

});


// Advance search display control
$('#oahTWOAdvanceSearch').on('click', function() {
	if($('#odvTWOAdvanceSearchContainer').hasClass('hidden')){
		$('#odvTWOAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
	}else{
		$('#odvTWOAdvanceSearchContainer').addClass('hidden fadeIn');
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
//Option Branch From

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
//Option Branch To

//Event Browse
$('#obtTWOBrowseBchFrom').click(function(){ JCNxBrowseData('oPmhBrowseBchFrom'); });
$('#obtTWOBrowseBchTo').click(function(){ JCNxBrowseData('oPmhBrowseBchTo'); });

</script>