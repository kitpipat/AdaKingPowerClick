<script type="text/javascript">

	$(document).ready(function(){
		
		$('.selectpicker').selectpicker();

		$('#obtRVDDocDateFrom').click(function(){
			event.preventDefault();
			$('#oetRVDDocDateFrom').datepicker('show');
		});

		$('#obtRVDDocDateTo').click(function(){
			event.preventDefault();
			$('#oetRVDDocDateTo').datepicker('show');
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
	$('#oahRVDAdvanceSearch').on('click', function() {
		if($('#odvRVDAdvanceSearchContainer').hasClass('hidden')){
			$('#odvRVDAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
		}else{
			$('#odvRVDAdvanceSearchContainer').addClass('hidden fadeIn');
		}
	});

	var tUsrLevel       = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
	var tBchCodeMulti   = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
	var nCountBch       = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
	var nLangEdits		= '<?php echo $this->session->userdata("tLangEdit"); ?>'; 
	var tWhere          = "";
	if (nCountBch == 1) {
		$('#obtRVDBrowseBchFrom').attr('disabled', true);
		$('#obtRVDBrowseBchTo').attr('disabled', true);
	}
	if (tUsrLevel != "HQ") {
		tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";
	} else {
		tWhere = "";
	}
		
	var oPmhBrowseBchFrom = {
		Title 	: 	['company/branch/branch','tBCHTitle'],
		Table	:	{Master:'TCNMBranch',PK:'FTBchCode'},
		Join 	:	{
			Table	:	['TCNMBranch_L'],
			On		:	['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
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
			Perpage			: 5,
			OrderBy			: ['TCNMBranch.FTBchCode ASC'],
		},
		CallBack:{
			ReturnType	: 'S',
			Value		: ["oetBchCodeFrom","TCNMBranch.FTBchCode"],
			Text		: ["oetBchNameFrom","TCNMBranch_L.FTBchName"],
		},
	}

	// Option Branch To
	var oPmhBrowseBchTo = {
		Title 	: 	['company/branch/branch','tBCHTitle'],
		Table	:	{Master:'TCNMBranch',PK:'FTBchCode'},
		Join 	:	{
			Table	:	['TCNMBranch_L'],
			On		:	['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
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
			Perpage			: 5,
			OrderBy			: ['TCNMBranch.FTBchCode ASC'],
		},
		CallBack:{
			ReturnType	: 'S',
			Value		: ["oetBchCodeTo","TCNMBranch.FTBchCode"],
			Text		: ["oetBchNameTo","TCNMBranch_L.FTBchName"],
		},
	}

	$('#obtRVDBrowseBchFrom').unbind().click(function(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			JCNxBrowseData('oPmhBrowseBchFrom');
		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	$('#obtRVDBrowseBchTo').unbind().click(function(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			JCNxBrowseData('oPmhBrowseBchTo');
		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	//Clear search 
	function JSxRVDClearSearchData(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if (typeof nStaSession !== "undefined" && nStaSession == 1) {
			try {
				$("#oetBchCodeFrom").val(""); 	$("#oetBchNameFrom").val("");
				$("#oetBchCodeTo").val(""); 		$("#oetBchNameTo").val("");
				$(".xCNDatePicker").datepicker("setDate", null);
				$(".selectpicker").val("").selectpicker("refresh");
				JSvRVDCallPagePdtDataTable(1);
			} catch (err) {
				console.log("JSxCreditNoteClearSearchData Error: ", err);
			}
		} else {
			JCNxShowMsgSessionExpired();
		}
	}

</script>