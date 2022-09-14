<script type="text/javascript">
	var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';
	var tUsrBchCode     = '<?php  echo $this->session->userdata("tSesUsrBchCodeDefault"); ?>';
	var tUsrBchName     = '<?php  echo $this->session->userdata("tSesUsrBchNameDefault"); ?>';
	var tUsrShpCode     = '<?php  echo $this->session->userdata("tSesUsrShpCodeDefault"); ?>';
	var tUsrShpName     = '<?php  echo $this->session->userdata("tSesUsrShpNameDefault"); ?>';
	var tUsrLevel 		= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
	var tBchCodeMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
	var nCountBch 		= "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";

	$(document).ready(function(){
		JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
	
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

		FSvGetSelectShpByBch('');

		$('#ostBchCode').change(function(){
			tBchCode = $(this).val();
			FSvGetSelectShpByBch(tBchCode);
		});

	});

	$('.xCNDatePicker').datepicker({
        format			: 'yyyy-mm-dd',
        todayHighlight	: true,
        autoclose		: true,
    }).on('changeDate',function(ev){
        var dDateFrom = $('#oetSearchDocDateFrom').val();
		var dDateTo   = $('#oetSearchDocDateTo').val();

        if( dDateFrom == "" ){
			$('#oetSearchDocDateFrom').val(dDateTo);
		}
		if( dDateTo == "" ){
			$('#oetSearchDocDateTo').val(dDateFrom);
		}
	});
	
	// Advance search display control
	$('#oahTFWAdvanceSearch').on('click', function() {
		if($('#odvTFWAdvanceSearchContainer').hasClass('hidden')){
			$('#odvTFWAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
		}else{
			$('#odvTFWAdvanceSearchContainer').addClass('hidden fadeIn');
		}
	});


	var tWhere = "";
	if(nCountBch == 1){
		$('#obtTFWBrowseBchFrom').attr('disabled',true);
		$('#obtTFWBrowseBchTo').attr('disabled',true);
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
		Where:{
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
		NextFunc : {
            FuncName	: 'JSxNextFuncBranch',
			ArgReturn	: ['FTBchCode','FTBchName']
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
		Where:{
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

	//Event Browse
	$('#obtTFWBrowseBchFrom').click(function(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			JCNxBrowseData('oPmhBrowseBchFrom');
		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	$('#obtTFWBrowseBchTo').click(function(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			JCNxBrowseData('oPmhBrowseBchTo');
		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	// Create By Sooksanti
	// Default Search BranchFrom To BranchTO 
	function JSxNextFuncBranch(oReturn){
		var aReturn  = JSON.parse(oReturn);
		var tBchCode = aReturn[0];
		var tBchName = aReturn[1];

		if( $('#oetBchCodeFrom').val() == "" ){
			$('#oetBchCodeFrom').val(tBchCode);
			$('#oetBchNameFrom').val(tBchName);
		}

		if( $('#oetBchCodeTo').val() == "" ){
			$('#oetBchCodeTo').val(tBchCode);
			$('#oetBchNameTo').val(tBchName);
		}

	}


	//Functionality : Clear search data
	function JSxTFWClearSearchData() {
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
				JSvCallPageTFWPdtDataTable();
			} catch (err) {
				console.log("JSxTFWClearSearchData Error: ", err);
			}
		} else {
			JCNxShowMsgSessionExpired();
		}
	}


</script>