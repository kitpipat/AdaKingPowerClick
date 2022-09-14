<script type="text/javascript">
	$(document).ready(function() {

		$('.selectpicker').selectpicker();

		$('#obtXphDocDateFrom').click(function() {
			event.preventDefault();
			$('#oetXphDocDateFrom').datepicker('show');
		});

		$('#obtXphDocDateTo').click(function() {
			event.preventDefault();
			$('#oetXphDocDateTo').datepicker('show');
		});

		$('.xCNDatePicker').datepicker({
			format: 'yyyy-mm-dd',
			todayHighlight: true,
			autoclose: true
		});

		$(".selection-2").select2({
			// minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});

	});

	// Advance search display control
	$('#oahDepositAdvanceSearch').on('click', function() {
		if ($('#odvDepositAdvanceSearchContainer').hasClass('hidden')) {
			$('#odvDepositAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
		} else {
			$('#odvDepositAdvanceSearchContainer').addClass('hidden fadeIn');
		}
	});

	var tUsrLevel 	  	= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
	var tBchCodeMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
	var nCountBch 		= "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
	var tWhere 			= "";

	if(nCountBch == 1){
		$('#obtDepositBrowseBchFrom').attr('disabled',true);
		$('#obtDepositBrowseBchTo').attr('disabled',true);
	}
	if(tUsrLevel != "HQ"){
		tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
	}else{
		tWhere = "";
	}


	// Option Branch From
	var oPmhBrowseBchFrom = {

		Title: ['company/branch/branch', 'tBCHTitle'],
		Table: {
			Master: 'TCNMBranch',
			PK: 'FTBchCode'
		},
		Join: {
			Table: ['TCNMBranch_L'],
			On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits, ]
		},
		Where:{
			Condition : [tWhere]
		},
		GrideView: {
			ColumnPathLang: 'company/branch/branch',
			ColumnKeyLang: ['tBCHCode', 'tBCHName'],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
			DataColumnsFormat: ['', ''],
			Perpage: 5,
			OrderBy: ['TCNMBranch.FTBchCode ASC'],
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetBchCodeFrom", "TCNMBranch.FTBchCode"],
			Text: ["oetBchNameFrom", "TCNMBranch_L.FTBchName"],
		},
	}
	// Option Branch From

	// Option Branch To
	var oPmhBrowseBchTo = {

		Title: ['company/branch/branch', 'tBCHTitle'],
		Table: {
			Master: 'TCNMBranch',
			PK: 'FTBchCode'
		},
		Join: {
			Table: ['TCNMBranch_L'],
			On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits, ]
		},
		Where:{
			Condition : [tWhere]
		},
		GrideView: {
			ColumnPathLang: 'company/branch/branch',
			ColumnKeyLang: ['tBCHCode', 'tBCHName'],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
			DataColumnsFormat: ['', ''],
			Perpage: 10,
			OrderBy: ['TCNMBranch.FTBchCode DESC'],
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetBchCodeTo", "TCNMBranch.FTBchCode"],
			Text: ["oetBchNameTo", "TCNMBranch_L.FTBchName"],
		},
	}
	// Option Branch To

	// Event Browse
	$('#obtDepositBrowseBchFrom').unbind().click(function() {
		var nStaSession = JCNxFuncChkSessionExpired();
		if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			JCNxBrowseData('oPmhBrowseBchFrom');
		} else {
			JCNxShowMsgSessionExpired();
		}
	});
	$('#obtDepositBrowseBchTo').unbind().click(function() {
		var nStaSession = JCNxFuncChkSessionExpired();
		if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			JCNxBrowseData('oPmhBrowseBchTo');
		} else {
			JCNxShowMsgSessionExpired();
		}
	});
</script>