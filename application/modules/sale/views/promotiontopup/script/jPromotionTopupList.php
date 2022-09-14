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
		});

		$(".selection-2").select2({
			// minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});

        $('#ocmPTUShowStatus').change(function(){
            JSvPTUCallPageDataTable();
        });

	});

	// Advance search display control
	$('#oahPTUAdvanceSearch').on('click', function() {
		if ($('#odvPTUAdvanceSearchContainer').hasClass('hidden')) {
			$('#odvPTUAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
		} else {
			$('#odvPTUAdvanceSearchContainer').addClass('hidden fadeIn');
		}
	});

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
			Value: ["oetBchCodeTo", "TCNMBranch.FTBchCode"],
			Text: ["oetBchNameTo", "TCNMBranch_L.FTBchName"],
		},
	}
	// Option Branch To

	// Event Browse
	$('#obtPTUBrowseBchFrom').unbind().click(function() {
		var nStaSession = JCNxFuncChkSessionExpired();
		if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			JCNxBrowseData('oPmhBrowseBchFrom');
		} else {
			JCNxShowMsgSessionExpired();
		}
	});

	$('#obtPTUBrowseBchTo').unbind().click(function() {
		var nStaSession = JCNxFuncChkSessionExpired();
		if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			JCNxBrowseData('oPmhBrowseBchTo');
		} else {
			JCNxShowMsgSessionExpired();
		}
	});

/*===== End Option1-กลุ่มรับ(กรณีส่วนลด) ===========================================*/
</script>