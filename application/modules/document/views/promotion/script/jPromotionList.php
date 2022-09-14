<?php include('jPromotionImport.php'); ?>

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

	});

	// Advance search display control
	$('#oahPromotionAdvanceSearch').on('click', function() {
		if ($('#odvPromotionAdvanceSearchContainer').hasClass('hidden')) {
			$('#odvPromotionAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
		} else {
			$('#odvPromotionAdvanceSearchContainer').addClass('hidden fadeIn');
		}
	});

    var tUsrLevel 	  	= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch 		= "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tWhere 			= "";
    
    if(nCountBch == 1){
        $('#obtPromotionBrowseBchFrom').attr('disabled',true);
        $('#obtPromotionBrowseBchTo').attr('disabled',true);
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
	$('#obtPromotionBrowseBchFrom').unbind().click(function() {
		var nStaSession = JCNxFuncChkSessionExpired();
		if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			JCNxBrowseData('oPmhBrowseBchFrom');
		} else {
			JCNxShowMsgSessionExpired();
		}
	});

	$('#obtPromotionBrowseBchTo').unbind().click(function() {
		var nStaSession = JCNxFuncChkSessionExpired();
		if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			JCNxBrowseData('oPmhBrowseBchTo');
		} else {
			JCNxShowMsgSessionExpired();
		}
	});
	
	// 03/08/2020 Piya
	// กดนำเข้า จะวิ่งไป Modal popup ที่ center
	$('#odvPromotionEventImportFile').click(function() {
		localStorage.removeItem("LocalItemData");
		
		var tNameModule = 'Promotion';
		var tTypeModule = 'master';
		var tAfterRoute = 'promotionGetImportExcelMainPage';

		var aPackdata = {
			'tNameModule': tNameModule,
			'tTypeModule': tTypeModule,
			'tAfterRoute': tAfterRoute
		};
		JSxPromotionImportPopUp(aPackdata);
	});



	/**
     * Functionality : ย้ายข้อมูล Tmp ลง Master
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPromotionImportPromotionTmpToMaster() {
		JCNxOpenLoading();
        var tTypeCaseDuplicate = $("input[name='orbPOSCaseInsAgain']:checked").val();
        $.ajax({
            type: "POST",
            url: "promotionImportExcelTempToMaster",
            data: {},
            cache: false,
            timeout: 0,
            success: function(oResult) {
                console.log('oResult: ', oResult);
                if(oResult.tCode == "1"){
                    $('#odvPromotionModalImportFile').modal('hide');
                    JSvPromotionCallPageList();
                    $(".modal-backdrop").remove();
                }else{
                    var tWarningMessage = oResult.tDesc;
                    FSvCMNSetMsgWarningDialog(tWarningMessage, '', '', false);
					JCNxCloseLoading();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
				JCNxCloseLoading();
            }
        });
    }

    /**
     * Functionality : Clear Temp
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPromotionImportPromotionClearInTemp() {
        $.ajax({
            type: "POST",
            url: "promotionClearImportExcelInTmp",
            data: {},
            cache: false,
            timeout: 0,
            success: function(oResult) {
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

/*===== Begin Product Group ============================================================*/
    /**
     * Functionality : Get Import Data in Temp
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPromotionImportGetPdtGroupTable() {
        $.ajax({
            type: "POST",
            url: "promotionGetImportExcelPdtGroupInTmp",
            data: {
                'tSearch': $('#oetPromotionImpPdtGroupSearchAll').val()
            },
            cache: false,
            Timeout: 0,
            success: function(oResponse) {
                localStorage.removeItem("PromotionPdtGroupLocalItemData");
                $('#odvPromotionImportExcelPdtGroupContainer').html(oResponse.html);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                localStorage.removeItem("PromotionPdtGroupLocalItemData");
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
/*===== End Product Group ==============================================================*/    

/*===== Begin Condition กลุ่มซื้อ =================================================*/
    /**
     * Functionality : Get Import Data in Temp
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPromotionImportGetCBTable() {
        $.ajax({
            type: "POST",
            url: "promotionGetImportExcelCBInTmp",
            data: {
                'tSearch': $('#oetPromotionImpCBSearchAll').val()
            },
            cache: false,
            Timeout: 0,
            success: function(oResponse) {
                localStorage.removeItem("PromotionCBLocalItemData");
                $('#odvPromotionImportExcelCBContainer').html(oResponse.html);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                localStorage.removeItem("PromotionCBLocalItemData");
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
/*===== End Condition กลุ่มซื้อ ===================================================*/

/*===== Begin Option1-กลุ่มรับ(กรณีส่วนลด) =========================================*/
    /**
     * Functionality : Get Import Data in Temp
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPromotionImportGetCGTable() {
        $.ajax({
            type: "POST",
            url: "promotionGetImportExcelCGInTmp",
            data: {
                'tSearch': $('#oetPromotionImpCGSearchAll').val()
            },
            cache: false,
            Timeout: 0,
            success: function(oResponse) {
                localStorage.removeItem("PromotionCGLocalItemData");
                $('#odvPromotionImportExcelCGContainer').html(oResponse.html);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                localStorage.removeItem("PromotionCGLocalItemData");
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
/*===== End Option1-กลุ่มรับ(กรณีส่วนลด) ===========================================*/
</script>