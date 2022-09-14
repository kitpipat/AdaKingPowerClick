<script type="text/javascript">

	nLangEdits 	= <?php echo $this->session->userdata("tLangEdit"); ?>;
	tUsrApv 	= <?php echo $this->session->userdata("tSesUsername"); ?>;
	var tRoute          =  $('#ohdTBRoute').val();
	
	/* Disabled Enter in Form */
	$(document).keypress(
		function(event) {
			if (event.which == '13') {
				event.preventDefault();
			}
		}
	);

	//RabbitMQ
	/*===========================================================================*/
	// Document variable
	var tLangCode 		= nLangEdits;
	var tUsrBchCode 	= $("#ohdBchCode").val();
	var tUsrApv 		= $("#oetXthApvCode").val();
	var tDocNo 			= $("#oetXthDocNo").val();
	var tPrefix 		= 'RESTB';
	var tStaApv 		= $("#ohdXthStaApv").val();
	var tStaPrcStk 		= $("#ohdXthStaPrcStk").val();
	var tStaDelMQ 		= $("#ohdXthStaDelMQ").val();
	var tQName 			= tPrefix + '_' + tDocNo + '_' + tUsrApv;

	var tBchCount 		= <?php echo $this->session->userdata("nSesUsrBchCount"); ?>

	$(document).ready(function() {
		if( tBchCount ==  1 ){
			$('#obtBrowseTWOBCH').attr('disabled',true);
			$('#obtTBBrowseBchTo').attr('disabled',true);
			$('#obtBrowseTBXBranchCreate').attr('disabled',true);
		}

		// if(tUserBchCode != ''){
        //     $('#oetTBBchCodeFrom').val(tUserBchCode);
        //     $('#oetTBBchNameFrom').val(tUserBchName);
        //     $('#obtBrowseTWOBCH').attr("disabled",true);
        // }
        // if(tUserWahCode != '' && tRoute == 'TBXEventAdd'){
        //     $('#ohdWahCodeStart').val(tUserWahCode);
        //     $('#oetWahNameStart').val(tUserWahName);
        // }


		// MQ Message Config
		JSoTBSubscribeMQ('2');
		// var poDocConfig = {
		// 	tLangCode		: tLangCode,
		// 	tUsrBchCode		: tUsrBchCode,
		// 	tUsrApv			: tUsrApv,
		// 	tDocNo			: tDocNo,
		// 	tPrefix			: tPrefix,
		// 	tStaDelMQ		: tStaDelMQ,
		// 	tStaApv			: tStaApv,
		// 	tQName			: tQName
		// };

		// // RabbitMQ STOMP Config
		// var poMqConfig = {
		// 	host			: 'ws://202.44.55.94:15674/ws',
		// 	username		: 'adasoft',
		// 	password		: 'adasoft',
		// 	vHost			: 'AdaPosV5.0'
		// };

		// // Update Status For Delete Qname Parameter
		// var poUpdateStaDelQnameParams = {
		// 	ptDocTableName			: "TCNTPdtTbxHD",
		// 	ptDocFieldDocNo			: "FTXthDocNo",
		// 	ptDocFieldStaApv		: "FTXthStaPrcStk",
		// 	ptDocFieldStaDelMQ		: "FTXthStaDelMQ",
		// 	ptDocStaDelMQ			: tStaDelMQ,
		// 	ptDocNo					: tDocNo
		// };

		// // Callback Page Control(function)
		// var poCallback = {
		//     tCallPageEdit			: "JSvCallPageTBEdit",
    	// 	tCallPageList			: "JSvCallPageTBList"
		// };

		// //Check Show Progress %
		// if (tDocNo != '' && (tStaApv == 2 || tStaPrcStk == 2)) { // 2 = Processing
		// 	FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
		// }

		// //Check Delete MQ SubScrib
		// if (tStaApv == 1 && tStaPrcStk == 1 && tStaDelMQ == '') { // Qname removed ?
		// 	// Delete Queue Name Parameter
		// 	var poDelQnameParams = {
		// 		ptPrefixQueueName	: tPrefix,
		// 		ptBchCode			: tUsrBchCode,
		// 		ptDocNo				: tDocNo,
		// 		ptUsrCode			: tUsrApv
		// 	};
		// 	FSxCMNRabbitMQDeleteQname(poDelQnameParams);
		// 	FSxCMNRabbitMQUpdateStaDeleteQname(poUpdateStaDelQnameParams);
		// }

		$('#obtTBAdvTablePdtDTTemp').off('click').on('click',function(){
			JSxOpenColumnFormSet();
		});

		/*===========================================================================*/
		//RabbitMQ
		$('#oliMngPdtScan').click(function() {
			//Hide
			$('#oetSearchPdtHTML').hide();
			$('#oimMngPdtIconSearch').hide();
			//Show
			$('#oetScanPdtHTML').show();
			$('#oimMngPdtIconScan').show();
		});

		$('#oliMngPdtSearch').click(function() {
			//Hide
			$('#oetScanPdtHTML').hide();
			$('#oimMngPdtIconScan').hide();
			//Show
			$('#oetSearchPdtHTML').show();
			$('#oimMngPdtIconSearch').show();
		});

		$('.selectpicker').selectpicker();

		$('.xCNDatePicker').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});

		//DATE
		$('#obtXthDocDate').click(function() {
			event.preventDefault();
			$('#oetXthDocDate').datepicker('show');
		});

		$('#obtXthDocTime').click(function() {
			event.preventDefault();
			$('#oetXthDocTime').datetimepicker('show');
		});

		$('#obtXthRefExtDate').click(function() {
			event.preventDefault();
			$('#oetXthRefExtDate').datepicker('show');
		});

		$('#obtXthRefIntDate').click(function() {
			event.preventDefault();
			$('#oetXthRefIntDate').datepicker('show');
		});


		$('#obtXthTnfDate').click(function() {
			event.preventDefault();
			$('#oetXthTnfDate').datepicker('show');
		});

		//DATE
		$('.xCNTimePicker').datetimepicker({
			format: 'HH:mm:ss'
		});

		$('.xWTooltipsBT').tooltip({
			'placement': 'bottom'
		});
		$('[data-toggle="tooltip"]').tooltip({
			'placement': 'top'
		});

		//Set DocDate is Date Now	
		var dCurrentDate = new Date();
		var tAmOrPm = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
		var tCurrentTime = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

		if ($('#oetXthDocDate').val() == '') {
			$('#oetXthDocDate').datepicker("setDate", dCurrentDate); // Doc Date
		}
		if ($('#oetXthTnfDate').val() == '') {
			$('#oetXthTnfDate').datepicker("setDate", dCurrentDate); // 
		}
		//Set DocTime is Time Now	
		if ($('#oetXthDocTime').val() == '') {
			$('#oetXthDocTime').val(tCurrentTime);
		}
		//Config Option ScanSku
		// nOptScanSku = $('#ohdOptScanSku').val();
		// $('#ostOptScanSku').val(nOptScanSku).attr('selected',true).trigger('change');

		//Config Option DocSave
		// nOptAlwSavQty0 = $('#ohdOptAlwSavQty0').val();
		// $('#ostOptAlwSavQty0').val(nOptAlwSavQty0).attr('selected',true).trigger('change');


		// $('#ostXthVATInOrEx').on('change', function(e) {
		// 	JSvTBLoadPdtDataTableHtml(); // คำนวนท้ายบิลใหม่
		// });

		//Check Box Auto Gen Code
		$('#ocbStaAutoGenCode').on('change', function(e) {
			if ($('#ocbStaAutoGenCode').is(':checked')) {
				$('#oetXthDocNo').val('');
				$('#oetXthDocNo').attr('disabled', true);

				$('#oetXthDocNo-error').remove();
				$('#oetXthDocNo').parent().parent().removeClass('has-error');
			} else {
				$('#oetXthDocNo').attr('disabled', false);
			}
		});

	});

	var nLangEdits;
	var oTBBrowseMch;
	var oTBBrowseShpStart;
	var oTBBrowseShpEnd;
	var oTBBrowseShipAdd;
	var tOldBchCkChange = "";
	var tOldMchCkChange = "";
	var tOldShpStartCkChange = "";
	var tOldShpEndCkChange = "";
	var oTBBrowseShipVia = "";

	//กลุ่มร้านค้า
	$('#obtTBBrowseMch').click(function() {
		// $(".modal.fade:not(#odvTBBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTBPopupApv,#odvModalDelPdtTB)").remove();
		tOldMchCkChange = $("#oetMchCode").val();
		oTBBrowseMch = {
			Title: ['company/warehouse/warehouse', 'tWAHBwsMchTitle'],
			Table: {
				Master: 'TCNMMerchant',
				PK: 'FTMerCode'
			},
			Join: {
				Table: ['TCNMMerchant_L'],
				On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits]
			},
			Where: {
				Condition: ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '" + $("#oetBchCode").val() + "') != 0"]
			},
			GrideView: {
				ColumnPathLang: 'company/warehouse/warehouse',
				ColumnKeyLang: ['tWAHBwsMchCode', 'tWAHBwsMchNme'],
				ColumnsSize: ['15%', '75%'],
				WidthModal: 50,
				DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
				DataColumnsFormat: ['', ''],
				Perpage: 5,
				OrderBy: ['TCNMMerchant.FTMerCode'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetMchCode", "TCNMMerchant.FTMerCode"],
				Text: ["oetMchName", "TCNMMerchant_L.FTMerName"],
			},
			NextFunc: {
				FuncName: 'JSxSetSeqConditionMerChant',
				ArgReturn: ['FTMerCode', 'FTMerName']
			},
			BrowseLev: 1
		};
		//Option merchant
		JCNxBrowseData('oTBBrowseMch');
	});


	$('#obtTBBrowseShipAdd').click(function(pE) {
		// $(".modal.fade:not(#odvTBBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTBPopupApv,#odvModalDelPdtTB)").remove();
		$("#odvTBBrowseShipAdd").modal("show");
		// tBchCode    = $('#oetBchCode').val();
		// tXthShipAdd = $('#ohdXthShipAdd').val();

		// JSvTBGetShipAddData(tBchCode,tXthShipAdd);

	});

	//Event Browse ShipAdd
	$('#oliBtnEditShipAdd').click(function() {
		// $(".modal.fade:not(#odvTBBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTBPopupApv,#odvModalDelPdtTB)").remove();
		//option Ship Address 
		oTBBrowseShipAdd = {
			Title: ['document/purchaseorder/purchaseorder', 'tBrowseADDTitle'],
			Table: {
				Master: 'TCNMAddress_L',
				PK: 'FNAddSeqNo'
			},
			Join: {
				Table: ['TCNMProvince_L', 'TCNMDistrict_L', 'TCNMSubDistrict_L'],
				On: [
					"TCNMAddress_L.FTAddV1PvnCode = TCNMProvince_L.FTPvnCode AND TCNMProvince_L.FNLngID = " + nLangEdits,
					"TCNMAddress_L.FTAddV1DstCode = TCNMDistrict_L.FTDstCode AND TCNMDistrict_L.FNLngID = " + nLangEdits,
					"TCNMAddress_L.FTAddV1SubDist = TCNMSubDistrict_L.FTSudCode AND TCNMSubDistrict_L.FNLngID = " + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tFilter = "AND FTAddGrpType = 1 AND FTAddRefCode = '" + $("#oetTBBchCodeTo").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
						return tFilter;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'document/purchaseorder/purchaseorder',
				ColumnKeyLang: ['tBrowseADDBch', 'tBrowseADDSeq', 'tBrowseADDV1No', 'tBrowseADDV1Soi', 'tBrowseADDV1Village', 'tBrowseADDV1Road', 'tBrowseADDV1SubDist', 'tBrowseADDV1DstCode', 'tBrowseADDV1PvnCode', 'tBrowseADDV1PostCode'],
				DataColumns: ['TCNMAddress_L.FTAddRefCode', 'TCNMAddress_L.FNAddSeqNo', 'TCNMAddress_L.FTAddV1No', 'TCNMAddress_L.FTAddV1Soi', 'TCNMAddress_L.FTAddV1Village', 'TCNMAddress_L.FTAddV1Road', 'TCNMAddress_L.FTAddV1SubDist', 'TCNMAddress_L.FTAddV1DstCode', 'TCNMAddress_L.FTAddV1PvnCode', 'TCNMAddress_L.FTAddV1PostCode', 'TCNMSubDistrict_L.FTSudName', 'TCNMDistrict_L.FTDstName', 'TCNMProvince_L.FTPvnName', 'TCNMAddress_L.FTAddV2Desc1', 'TCNMAddress_L.FTAddV2Desc2'],
				DataColumnsFormat: ['', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
				ColumnsSize: [''],
				DisabledColumns: [10, 11, 12, 13, 14],
				Perpage: 10,
				WidthModal: 50,
				OrderBy			: ['TCNMAddress_L.FDCreateOn DESC'],
				// SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["ohdShipAddSeqNo", "TCNMAddress_L.FNAddSeqNo"],
				Text: ["ohdShipAddSeqNo", "TCNMAddress_L.FNAddSeqNo"],
			},
			NextFunc: {
				FuncName: 'JSvTBGetShipAddData',
				ArgReturn: ['FNAddSeqNo', 'FTAddV1No', 'FTAddV1Soi', 'FTAddV1Village', 'FTAddV1Road', 'FTSudName', 'FTDstName', 'FTPvnName', 'FTAddV1PostCode', 'FTAddV2Desc1', 'FTAddV2Desc2']
			},
			BrowseLev: 1
		}
		//option Ship Address 
		JCNxBrowseData('oTBBrowseShipAdd');
	});

	$("#obtSearchShipVia").click(function(){
		// $(".modal.fade:not(#odvTBBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTBPopupApv,#odvModalDelPdtTB)").remove();
		//option Ship Address 
		oTBBrowseShipVia = {
			Title: ['shipvia/shipvia/shipvia', 'tVIATitle'],
			Table: {
				Master: 'TCNMShipVia',
				PK: 'FTViaCode'
			},
			Join: {
				Table: ['TCNMShipVia_L'],
				On: [
					"TCNMShipVia.FTViaCode = TCNMShipVia_L.FTViaCode AND TCNMShipVia_L.FNLngID = " + nLangEdits
				]
			},
			GrideView: {
				ColumnPathLang: 'shipvia/shipvia/shipvia',
				ColumnKeyLang: ['tVIACode', 'tVIAName'],
				DataColumns: ['TCNMShipVia.FTViaCode', 'TCNMShipVia_L.FTViaName'],
				DataColumnsFormat: ['', ''],
				ColumnsSize: ['20%','80%'],
				Perpage: 10,
				WidthModal: 50,
				OrderBy: ['TCNMShipVia.FDCreateOn DESC'],
				// SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetViaCode", "TCNMShipVia.FTViaCode"],
				Text: ["oetViaName", "TCNMShipVia_L.FTViaName"],
			},
			RouteAddNew: 'shipvia',
			BrowseLev: 1
		}
		//option Ship Address 
		JCNxBrowseData('oTBBrowseShipVia');
	});

	$('#obtTBBrowseWahTo').click(function() {
		JCNxBrowseData('oTBBrowseWahTo');
	});

	// put ค่าจาก Modal ลง Input หน้า Add
	function JSnTBAddShipAdd() {
		tShipAddSeqNoSelect = $('#ohdShipAddSeqNo').val();
		$('#ohdXthShipAdd').val(tShipAddSeqNoSelect);

		$('#odvTBBrowseShipAdd').modal('toggle');
	}

	function FSvTBAddHDDis() {

		tHDXthDisChgText = $('#ostXthHDDisChgText').val();
		cHDXthDis = $('#oetXddHDDis').val();
		tHDXthDocNo = $('#oetXthDocNo').val();
		tHDBchCode = $('#ohdSesUsrBchCode').val();

		nPlusOld = '';
		nPercentOld = '';
		tPlusNew = '';
		nPercentNew = '';
		tOldDisHDChgLength = '';

		if (tHDXthDisChgText == 1 || tHDXthDisChgText == 2) {
			tPlusNew = '+';
		}
		if (tHDXthDisChgText == 2 || tHDXthDisChgText == 4) {
			nPercentNew = '%';
		}

		//หา length ที่มีอยู่ ของ HD
		$('.xWAlwEditXpdHDDisChgValue').each(function(e) {
			nDistypeOld = $(this).data('distype');
			if (nDistypeOld == 1 || nDistypeOld == 2) {
				nPlusOld = '+';
			}
			if (nDistypeOld == 2 || nDistypeOld == 4) {
				nPercentOld = '%';
			}
			tOldDisHDChgLength += nPlusOld + $(this).text() + nPercentOld + ','
		});
		tNewDisHDChgLength = tPlusNew + accounting.formatNumber(cHDXthDis, nOptDecimalSave, "") + nPercentNew;
		//เอาทั้งสองมาต่อกัน
		tCurDisHDChgLength = tOldDisHDChgLength + tNewDisHDChgLength
		//หาจำนวนตัวอักษร
		nCurDisHDChgLength = tCurDisHDChgLength.length;

		if (cHDXthDis == '') {
			$('#oetXddHDDis').focus();
		} else {
			//Check ขนาดของ Text DisChgText
			if (nCurDisHDChgLength <= 20) {
				$.ajax({
					type: "TBST",
					url: "TBAddHDDisIntoTable",
					data: {
						tHDXthDocNo: tHDXthDocNo,
						tHDBchCode: tHDBchCode,
						tHDXthDisChgText: tHDXthDisChgText,
						cHDXthDis: cHDXthDis
					},
					cache: false,
					timeout: 5000,
					success: function(tResult) {



					},
					error: function(jqXHR, textStatus, errorThrown) {
						(jqXHR, textStatus, errorThrown);
					}
				});
			} else {
				alert('ไม่สามารถเพิ่มได้ จำนวนขนาดเกิน 20');
			}

		}
	}


	//Create By Napat(Jame) 18/03/63
	// Event Browse Modal กลุ่มร้านค้า
	$('#obtTBBrowseMerFrom').unbind().click(function(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			window.oTBBrowseMerchantOption = undefined;
			oTBBrowseMerchantOption        = oTBBrowseMerchant({
				'tASTBchCode'       : $('#oetTBBchCodeFrom').val(),
				'tReturnInputCode'  : 'oetTBMerCodeFrom',
				'tReturnInputName'  : 'oetTBMerNameFrom',
				'tNextFuncName'     : 'JSxTBSetConditionMerchant',
				'aArgReturn'        : ['FTMerCode','FTMerName','FTShpCode','FTShpName'],
			});
			JCNxBrowseData('oTBBrowseMerchantOption');
		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	//Create By Napat(Jame) 18/03/63
	// Option Modal กลุ่มธุรกิจ (กลุ่มร้านค้า)
	var oTBBrowseMerchant  = function(poDataFnc){
		var tASTBchCode         = poDataFnc.tASTBchCode;
		var tInputReturnCode    = poDataFnc.tReturnInputCode;
		var tInputReturnName    = poDataFnc.tReturnInputName;
		var tNextFuncName       = poDataFnc.tNextFuncName;
		var aArgReturn          = poDataFnc.aArgReturn;
		var tWhereModal         = "";
		if(typeof(tASTBchCode) != undefined && tASTBchCode != ""){
			tWhereModal = "AND TCNMMerchant.FTMerStaActive = '1' AND TCNMShop.FTShpCode IS NOT NULL";
		}
		var oOptionReturn       = {
			Title   : ['company/merchant/merchant','tMerchantTitle'],
			Table   : {Master:'TCNMMerchant',PK:'FTMerCode'},
			Join    : {
				Table : ['TCNMMerchant_L','TCNMShop','TCNMShop_L'],
				On : [
					'TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits,
					"TCNMMerchant.FTMerCode = TCNMShop.FTMerCode AND TCNMShop.FTBchCode = '"+tASTBchCode+"' AND TCNMShop.FTShpCode = ( SELECT TOP 1 FTShpCode FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '"+tASTBchCode+"' )",
					"TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = " + nLangEdits
				]
			},
			Where : {
				Condition : [tWhereModal]
			},
			GrideView : {
				ColumnPathLang	: 'company/merchant/merchant',
				ColumnKeyLang	: ['tMerCode','tMerName'],
				ColumnsSize     : ['15%','75%'],
				WidthModal      : 50,
				DataColumns		: ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName','TCNMShop.FTShpCode','TCNMShop_L.FTShpName'],
				DataColumnsFormat : ['',''],
				DisabledColumns	: ['2','3'],
				Perpage			: 10,
				OrderBy			: ['TCNMMerchant.FDCreateOn DESC'],
				// SourceOrder		: "ASC"
			},
			CallBack : {
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TCNMMerchant.FTMerCode"],
				Text		: [tInputReturnName,"TCNMMerchant_L.FTMerName"],
			},
			NextFunc : {
				FuncName    : tNextFuncName,
				ArgReturn   : aArgReturn
			},
			RouteAddNew: 'merchant',
			BrowseLev: nStaTBBrowseType,
			// DebugSQL : true
		};
		return oOptionReturn;
	}

	//Create By Napat(Jame) 18/03/63
	// Event Browse Modal ร้านค้า
	$('#obtTBBrowseShp').unbind().click(function(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose(); // Hidden Pin Menu
			window.oTBBrowseShopOption = undefined;
			oTBBrowseShopOption     = oTBBrowseShop({
				'tTBBchCode'       : $('#oetTBBchCodeFrom').val(),
				'tTBMerCode'       : $('#oetTBMerCodeFrom').val(),
				'tReturnInputCode'  : 'oetTBShopCodeFrom',
				'tReturnInputName'  : 'oetTBShopNameFrom',
				'tNextFuncName'     : 'JSxTBSetConditionShopFrom',
				'aArgReturn'        : ['FTShpCode','FTShpName'],
			});
			JCNxBrowseData('oTBBrowseShopOption');
		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	//Create By Napat(Jame) 18/03/63
	// Option Modal ร้านค้า
	var oTBBrowseShop      = function(poDataFnc){
		var tTBBchCode          = poDataFnc.tTBBchCode;
		var tTBMerCode          = poDataFnc.tTBMerCode;
		var tInputReturnCode    = poDataFnc.tReturnInputCode;
		var tInputReturnName    = poDataFnc.tReturnInputName;
		var tNextFuncName       = poDataFnc.tNextFuncName;
		var aArgReturn          = poDataFnc.aArgReturn;
		var tWhereModal         = "";

		// Check Shop Branch
		if(typeof(tTBBchCode) != undefined && tTBBchCode != ""){
			tWhereModal += " AND (TCNMShop.FTBchCode = '"+tTBBchCode+"') AND TCNMShop.FTShpType  != 5";
		}
		// Cheack Shop Merchant
		if(typeof(tTBMerCode) != undefined && tTBMerCode != ""){
			tWhereModal += " AND (TCNMShop.FTMerCode = '"+tTBMerCode+"') AND TCNMShop.FTShpType  != 5";

		}

		var oOptionReturn       = {
			Title: ["company/shop/shop","tSHPTitle"],
			Table: {Master:"TCNMShop",PK:"FTShpCode"},
			Join: {
				Table: ['TCNMShop_L','TCNMWaHouse_L'],
				On: [
					'TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = '+nLangEdits,
					'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMShop.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID= '+nLangEdits
				]
			},
			Where: {
				Condition: [tWhereModal]
			},
			GrideView: {
				ColumnPathLang      : 'company/shop/shop',
				ColumnKeyLang       : ['tShopCode','tShopName'],
				ColumnsSize         : ['15%','75%'],
				WidthModal          : 50,
				DataColumns         : ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName','TCNMShop.FTWahCode','TCNMWaHouse_L.FTWahName','TCNMShop.FTShpType','TCNMShop.FTBchCode'],
				DataColumnsFormat   : ['','','','','',''],
				DisabledColumns     : [2,3,4,5],
				Perpage             : 10,
				OrderBy			    : ['TCNMShop_L.FTShpCode ASC'],
			},
			CallBack: {
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TCNMShop.FTShpCode"],
				Text		: [tInputReturnName,"TCNMShop_L.FTShpName"],
			},
			NextFunc : {
				FuncName    : tNextFuncName,
				ArgReturn   : aArgReturn
			},
			RouteAddNew: 'shop',
			BrowseLev : nStaTBBrowseType,
			// DebugSQL : true
		};
		return oOptionReturn;
	}

	// Create By Napat(Jame) 18/03/63
	// Event Browse Modal คลังสินค้า (ต้นทาง)
	$('#obtTBBrowseWahStart').unbind().click(function(){

		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose(); // Hidden Pin Menu

			var tShpCdoe = $('#oetTBShopCodeFrom').val();
			if(typeof(tShpCdoe) != undefined && tShpCdoe != ""){
				//คล้งร้านค้า ShopWah  Where ShpCode
				window.oTBBrowseShpWahFromOption = undefined;
				oTBBrowseShpWahFromOption     = oTBBrowseShpWahFrom({
					'tTBBchCode'        : $('#oetTBBchCodeFrom').val(),
					'tTBShpCode'        : $('#oetTBShopCodeFrom').val(),
					'tReturnInputCode'  : 'ohdWahCodeStart',
					'tReturnInputName'  : 'oetWahNameStart'
				});
				JCNxBrowseData('oTBBrowseShpWahFromOption');
			}else{
				//คลังสาขา Wahouse   Where RefCode
				window.oTBBrowseWaHouseFromOption = undefined;
				oTBBrowseWaHouseFromOption     = oTBBrowseWaHouseFrom({
					'tTBBchCode'        : $('#oetTBBchCodeFrom').val(),
					'tReturnInputCode'  : 'ohdWahCodeStart',
					'tReturnInputName'  : 'oetWahNameStart'
				});
				JCNxBrowseData('oTBBrowseWaHouseFromOption');
			}
		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	// Create By Napat(Jame) 18/03/63
	// Option Modal คลังสินค้า (สาขา) (ต้นทาง)
	var oTBBrowseWaHouseFrom      = function(poDataFnc){
		var tTBBchCode          = poDataFnc.tTBBchCode;
		var tInputReturnCode    = poDataFnc.tReturnInputCode;
		var tInputReturnName    = poDataFnc.tReturnInputName;
		var tWhereModal         = "";

		// Check Branch
		if(typeof(tTBBchCode) != undefined && tTBBchCode != ""){
			tWhereModal += " AND TCNMWaHouse.FTWahStaType IN(1, 2) AND TCNMWaHouse.FTBchCode = '" + tTBBchCode + "' "; //TCNMWaHouse.FTWahRefCode = '" + tTBBchCode + "'
		}

		var oOptionReturn       = {
			Title: ["company/warehouse/warehouse","tWAHTitle"],
			Table: {Master:"TCNMWaHouse",PK:"FTWahCode"},
			Join: {
				Table: ['TCNMWaHouse_L'],
				On: [
					'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
				]
			},
			Where: {
				Condition: [tWhereModal]
			},
			GrideView: {
				ColumnPathLang      : 'company/warehouse/warehouse',
				ColumnKeyLang       : ['tWahCode','tWahName'],
				ColumnsSize         : ['15%','75%'],
				WidthModal          : 50,
				DataColumns         : ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
				DataColumnsFormat   : ['',''],
				// DisabledColumns     : [2,3,4,5],
				Perpage             : 10,
				OrderBy			    : ['TCNMWaHouse.FDCreateOn DESC'],
			},
			CallBack: {
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TCNMWaHouse.FTWahCode"],
				Text		: [tInputReturnName,"TCNMWaHouse_L.FTWahName"],
			},
			RouteAddNew: 'warehouse',
			BrowseLev : nStaTBBrowseType,
			// DebugSQL : true
		};
		return oOptionReturn;
	}

	// Create By Napat(Jame) 18/03/63
	// Option Modal คลังสินค้า (ร้านค้า) (ต้นทาง)
	var oTBBrowseShpWahFrom      = function(poDataFnc){
		var tTBBchCode          = poDataFnc.tTBBchCode;
		var tTBShpCode          = poDataFnc.tTBShpCode;
		var tInputReturnCode    = poDataFnc.tReturnInputCode;
		var tInputReturnName    = poDataFnc.tReturnInputName;
		var tWhereModal         = "";

		var oOptionReturn       = {
			Title: ["company/warehouse/warehouse","tWAHTitle"],
			Table: {Master:"TCNMShpWah",PK:"FTWahCode"},
			Join: {
				Table: ['TCNMWaHouse_L'],
				On: [
					'TCNMShpWah.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMShpWah.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					" AND TCNMShpWah.FTBchCode = '" + tTBBchCode + "' ",
					" AND TCNMShpWah.FTShpCode = '" + tTBShpCode + "' "
				]
			},
			GrideView: {
				ColumnPathLang      : 'company/warehouse/warehouse',
				ColumnKeyLang       : ['tWahCode','tWahName'],
				ColumnsSize         : ['15%','75%'],
				WidthModal          : 50,
				DataColumns         : ['TCNMShpWah.FTWahCode','TCNMWaHouse_L.FTWahName'],
				DataColumnsFormat   : ['',''],
				// DisabledColumns     : [2,3,4,5],
				Perpage             : 10,
				OrderBy			    : ['TCNMShpWah.FDCreateOn DESC'],
			},
			CallBack: {
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TCNMShpWah.FTWahCode"],
				Text		: [tInputReturnName,"TCNMWaHouse_L.FTWahName"],
			},
			RouteAddNew: 'warehouse',
			BrowseLev : nStaTBBrowseType,
			// DebugSQL : true
		};
		return oOptionReturn;
	}

	// Create By Napat(Jame) 19/03/63
	// Event Browse Modal คลังสินค้า (ปลายทาง)
	$('#obtTBBrowseWahTo').unbind().click(function(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose(); // Hidden Pin Menu

			//คลังสาขา Wahouse Where RefCode
			window.oTBBrowseWaHouseToOption = undefined;
			oTBBrowseWaHouseToOption     = oTBBrowseWaHouseTo({
				'tTBBchCode'        : $('#oetTBBchCodeTo').val(),
				'tReturnInputCode'  : 'oetTBWahCodeTo',
				'tReturnInputName'  : 'oetTBWahNameTo'
			});
			JCNxBrowseData('oTBBrowseWaHouseToOption');

		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	// Create By Napat(Jame) 19/03/63
	// Option Modal คลังสินค้า (สาขา) (ต้นทาง)
	var oTBBrowseWaHouseTo      = function(poDataFnc){
		var tTBBchCode          = poDataFnc.tTBBchCode;
		var tInputReturnCode    = poDataFnc.tReturnInputCode;
		var tInputReturnName    = poDataFnc.tReturnInputName;
		var tWhereModal         = "";

		// Check Branch
		if(typeof(tTBBchCode) != undefined && tTBBchCode != ""){
			tWhereModal += " AND TCNMWaHouse.FTWahStaType IN(1, 2) AND TCNMWaHouse.FTBchCode = '" + tTBBchCode + "' ";
		}

		var oOptionReturn       = {
			Title: ["company/warehouse/warehouse","tWAHTitle"],
			Table: {Master:"TCNMWaHouse",PK:"FTWahCode"},
			Join: {
				Table: ['TCNMWaHouse_L'],
				On: [
					'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
				]
			},
			Where: {
				Condition: [tWhereModal]
			},
			GrideView: {
				ColumnPathLang      : 'company/warehouse/warehouse',
				ColumnKeyLang       : ['tWahCode','tWahName'],
				ColumnsSize         : ['15%','75%'],
				WidthModal          : 50,
				DataColumns         : ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
				DataColumnsFormat   : ['',''],
				Perpage             : 10,
				OrderBy			    : ['TCNMWaHouse.FDCreateOn DESC'],
			},
			CallBack: {
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TCNMWaHouse.FTWahCode"],
				Text		: [tInputReturnName,"TCNMWaHouse_L.FTWahName"],
			},
			RouteAddNew: 'warehouse',
			BrowseLev : nStaTBBrowseType,
			// DebugSQL : true
		};
		return oOptionReturn;
	}

	// Create By Napat(Jame) 19/03/63
	// Event Browse Modal สาขา (ปลายทาง)
	$('#obtTBBrowseBchTo').unbind().click(function(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose(); // Hidden Pin Menu

			window.oTBBrowseBranchToOption = undefined;
			oTBBrowseBranchToOption     = oTBBrowseBranchTo({
				'tBchCodeFrom'		: $('#oetTBBchCodeFrom').val(),
				'tReturnInputCode'  : 'oetTBBchCodeTo',
				'tReturnInputName'  : 'oetTBBchNameTo',
				'tNextFuncName'     : 'JSxTBSetConditionBranchTo',
				'aArgReturn'        : ['FTBchCode','FTBchName']
			});
			JCNxBrowseData('oTBBrowseBranchToOption');

		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	// Create By Napat(Jame) 19/03/63
	// Option Modal สาขา (ปลายทาง)
	var oTBBrowseBranchTo      = function(poDataFnc){
		// var tTBBchCode          = poDataFnc.tTBBchCode;
		var tInputReturnCode    = poDataFnc.tReturnInputCode;
		var tInputReturnName    = poDataFnc.tReturnInputName;
		var tNextFuncName		= poDataFnc.tNextFuncName;
		var aArgReturn			= poDataFnc.aArgReturn;
		var tBchCodeFrom		= poDataFnc.tBchCodeFrom;
		var tWhereModal         = "";

		// เพิ่มเงื่อนไข Where Branch Multi
		var tWhereModal = "";
		var tUsrLevel   = "<?php echo $this->session->userdata("tSesUsrLevel");?>";
		var tBchMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
		var tSesUsrAgnCode 	= "<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>";
		// if(tUsrLevel != "HQ"){
		// 	tWhereModal 	+= " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
		// }

		if(tSesUsrAgnCode != ""){
			tWhereModal 	+= " AND TCNMBranch.FTAgnCode ='"+tSesUsrAgnCode+"' ";
		}
		// สาขาที่ให้เลือกต้องไม่ตรงกับสาขา ต้นทาง
		if(typeof(tBchCodeFrom) != undefined && tBchCodeFrom != ""){
			tWhereModal += " AND TCNMBranch.FTBchCode <> '" + tBchCodeFrom + "' ";
		}

		var oOptionReturn       = {
			Title: ["company/branch/branch","tBCHTitle"],
			Table: {Master:"TCNMBranch",PK:"FTBchCode"},
			Join: {
				Table: ['TCNMBranch_L'],
				On: [
					'TCNMBranch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits
				]
			},
			Where: {
				Condition: [tWhereModal]
			},
			GrideView: {
				ColumnPathLang      : 'company/branch/branch',
				ColumnKeyLang       : ['tBCHCode','tBCHName'],
				ColumnsSize         : ['15%','75%'],
				WidthModal          : 50,
				DataColumns         : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
				DataColumnsFormat   : ['',''],
				Perpage             : 10,
				OrderBy			    : ['TCNMBranch.FDCreateOn DESC'],
			},
			CallBack: {
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
				Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
			},
			NextFunc : {
				FuncName    : tNextFuncName,
				ArgReturn   : aArgReturn
			},
			RouteAddNew: 'branch',
			BrowseLev : nStaTBBrowseType,
			// DebugSQL : true
		};
		return oOptionReturn;
	}

	// Create By Napat(Jame) 20/03/63
	// Event Browse Modal เหตุผล
	$('#obtTBBrowseRsn').unbind().click(function(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose(); // Hidden Pin Menu

			window.oTBBrowseReasonOption = undefined;
			oTBBrowseReasonOption     = oTBBrowseReason({
				'tReturnInputCode'  : 'oetTBRsnCode',
				'tReturnInputName'  : 'oetTBRsnName'
			});
			JCNxBrowseData('oTBBrowseReasonOption');

		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	// Create By Napat(Jame) 20/03/63
	// Option Modal เหตุผล
	var oTBBrowseReason      = function(poDataFnc){
		var tInputReturnCode    = poDataFnc.tReturnInputCode;
		var tInputReturnName    = poDataFnc.tReturnInputName;
		var tWhereModal         = "";

		var oOptionReturn       = {
			Title: ["other/reason/reason","tRSNTitle"],
			Table: {Master:"TCNMRsn",PK:"FTRsnCode"},
			Join: {
				Table: ['TCNMRsn_L'],
				On: [
					'TCNMRsn.FTRsnCode = TCNMRsn_L.FTRsnCode AND TCNMRsn_L.FNLngID = ' + nLangEdits
				]
			},
			GrideView: {
				ColumnPathLang      : 'other/reason/reason',
				ColumnKeyLang       : ['tRSNTBCode','tRSNTBName'],
				ColumnsSize         : ['15%','75%'],
				WidthModal          : 50,
				DataColumns         : ['TCNMRsn.FTRsnCode','TCNMRsn_L.FTRsnName'],
				DataColumnsFormat   : ['',''],
				Perpage             : 10,
				OrderBy			    : ['TCNMRsn.FDCreateOn DESC'],
			},
			CallBack: {
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TCNMRsn.FTRsnCode"],
				Text		: [tInputReturnName,"TCNMRsn_L.FTRsnName"],
			},
			RouteAddNew: 'reason',
			BrowseLev : nStaTBBrowseType,
			// DebugSQL : true
		};
		return oOptionReturn;
	}

	$('#obtBrowseTWOBCH').click(function(){
		// เพิ่มเงื่อนไข Where Branch Multi
		var tWhereModal = "";
		var tUsrLevel   = "<?php echo $this->session->userdata("tSesUsrLevel");?>";
		var tBchMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
		if(tUsrLevel != "HQ"){
			tWhereModal 	+= " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
		}

		if( $('#oetTBBchCodeTo').val() != "" ){
			tWhereModal += " AND TCNMBranch.FTBchCode <> '"+$('#oetTBBchCodeTo').val()+"' ";
		}

		oBrowse_BCH.Where.Condition = [tWhereModal];
		JCNxBrowseData('oBrowse_BCH'); 
	});

	var oBrowse_BCH = {
		Title   : ['company/branch/branch','tBCHTitle'],
		Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
		Join    : {
			Table   : ['TCNMBranch_L','TCNMWaHouse_L'],
			On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID ='+nLangEdits,
						'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID ='+nLangEdits,
			]
		},
		Where : {
			Condition : [""]
		},
		GrideView:{
			ColumnPathLang : 'company/branch/branch',
			ColumnKeyLang : ['tBCHCode','tBCHName',''],
			ColumnsSize     : ['15%','75%',''],
			WidthModal      : 50,
			DataColumns  : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMWaHouse_L.FTWahCode','TCNMWaHouse_L.FTWahName'],
			DataColumnsFormat : ['',''],
			DisabledColumns   : [2,3],
			Perpage   : 10,
			OrderBy   : ['TCNMBranch.FDCreateOn DESC'],
			// SourceOrder  : "ASC"
		},
		CallBack:{
			ReturnType : 'S',
			Value  : ["oetTBBchCodeFrom","TCNMBranch.FTBchCode"],
			Text  : ["oetTBBchNameFrom","TCNMBranch_L.FTBchName"],
		},
			// DebugSQL : true,
		NextFunc    :   {
			FuncName    :   'JSxSetDefauleWahouse',
			ArgReturn   :   ['FTWahCode','FTWahName']
		}
	}
		
	function JSxSetDefauleWahouse(ptData){
		if(ptData == '' || ptData == 'NULL'){
			$('#ohdWahCodeStart').val('');
			$('#oetWahNameStart').val('');
		}else{
			var tResult = JSON.parse(ptData);
			$('#ohdWahCodeStart').val(tResult[0]);
			$('#oetWahNameStart').val(tResult[1]);
		}
	}

	$('#obtBrowseTBXBranchCreate').off('click');
	$('#obtBrowseTBXBranchCreate').on('click',function(){
		// เพิ่มเงื่อนไข Where Branch Multi
		var tWhereModal = "";
		var tUsrLevel   = "<?php echo $this->session->userdata("tSesUsrLevel");?>";
		var tBchMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
		if(tUsrLevel != "HQ"){
			tWhereModal 	+= " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
		}

		oBrowseTBXBranchCreate.Where.Condition = [tWhereModal];
		JCNxBrowseData('oBrowseTBXBranchCreate');
	});

	var oBrowseTBXBranchCreate = {
		Title   : ['company/branch/branch','tBCHTitle'],
		Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
		Join    : {
			Table   : ['TCNMBranch_L','TCNMWaHouse_L'],
			On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID ='+nLangEdits,
						'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID ='+nLangEdits,
			]
		},
		Where : {
			Condition : [""]
		},
		GrideView:{
			ColumnPathLang : 'company/branch/branch',
			ColumnKeyLang : ['tBCHCode','tBCHName',''],
			ColumnsSize     : ['15%','75%',''],
			WidthModal      : 50,
			DataColumns  : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMWaHouse_L.FTWahCode','TCNMWaHouse_L.FTWahName'],
			DataColumnsFormat : ['',''],
			DisabledColumns   : [2,3],
			Perpage   : 10,
			OrderBy   : ['TCNMBranch.FDCreateOn DESC'],
			// SourceOrder  : "ASC"
		},
		CallBack:{
			ReturnType : 'S',
			Value  : ["ohdTbxBchCode","TCNMBranch.FTBchCode"],
			Text  : ["ohdTbxBchName","TCNMBranch_L.FTBchName"]
		},
			// DebugSQL : true,
		// NextFunc    :   {
		// 	FuncName    :   'JSxSetDefauleWahouse',
		// 	ArgReturn   :   ['FTWahCode','FTWahName']
		// }
	}

	//ปริ้นเอกสาร ใบโอนสินค้าระหว่างสาขา
	function JSxTBBchPrintDoc(){
		var aInfor = [
			{"Lang"         : '<?=FCNaHGetLangEdit(); ?>'}, // Lang ID
			{"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, // Company Code
			{"BranchCode"   : '<?=FCNtGetAddressBranch($tBchCode); ?>' }, // สาขาที่ออกเอกสาร
			{"DocCode"      : $('#oetXthDocNo').val()  },
            {"DocBchCode"   : '<?=$tBchCode?>' } // เลขที่เอกสาร
		];
		window.open("<?=base_url(); ?>formreport/Frm_SQL_ALLMPdtBillTnfBch?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
	}


</script>





