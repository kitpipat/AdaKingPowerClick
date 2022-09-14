<script type="text/javascript">
	var nLangEdits = '<?php echo $this->session->userdata("tLangEdit"); ?>';
	var tUsrApv = '<?php echo $this->session->userdata("tSesUsername"); ?>';
	var tSesUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';
	var tSesUsrWahCode = '<?php echo $this->session->userdata("tSesUsrWahCode"); ?>';
	var tSesUsrWahName = '<?php echo $this->session->userdata("tSesUsrWahName"); ?>';
	var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
	var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
	var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
	var tRoute = $('#ohdTFWRoute').val();

	<?php
	if ($tRoute == "TFWEventAdd") {
		if ($tBchCode == '') {
			if ($tShpCodeStart == '') {
				// user hq
	?>
				var tUserType = "HQ";
			<?php
			}
			?>

			<?php
		} else {
			if ($tShpCodeStart != '') {
				// user shop
			?>
				var tUserType = "SHP";
			<?php
			} else {
				// user bch
			?>
				var tUserType = "BCH";
	<?php
			}
		}
	}
	?>
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
	var tLangCode = nLangEdits;
	var tUsrBchCode = $("#ohdBchCode").val();
	var tUsrApv = $("#oetXthApvCode").val();
	var tDocNo = $("#oetXthDocNo").val();
	var tPrefix = 'RESTFW';
	var tStaApv = $("#ohdXthStaApv").val();
	var tStaPrcStk = $("#ohdXthStaPrcStk").val();
	var tStaDelMQ = $("#ohdXthStaDelMQ").val();
	var tQName = tPrefix + '_' + tDocNo + '_' + tUsrApv;
	$(document).ready(function() {

		if (tUsrLevel != "HQ") {
			var tBchCount = <?php echo $this->session->userdata("nSesUsrBchCount"); ?>;
			if (tBchCount < 2) {
				$('#oimBrowseBch').addClass('disabled');
				$('#oimBrowseBch').css('pointer-events', 'none');
				$('#oimBrowseBch').attr('disabled', true);
			}
		}

		// if (tSesUsrWahCode != '' && tRoute == 'TFWEventAdd') {
		// 	$('#ohdWahCodeStart').val(tSesUsrWahCode);
		// 	$('#oetWahNameStart').val(tSesUsrWahName);
		// }


		// MQ Message Config
		var poDocConfig = {
			tLangCode: tLangCode,
			tUsrBchCode: tUsrBchCode,
			tUsrApv: tUsrApv,
			tDocNo: tDocNo,
			tPrefix: tPrefix,
			tStaDelMQ: tStaDelMQ,
			tStaApv: tStaApv,
			tQName: tQName
		};

		// RabbitMQ STOMP Config
		var poMqConfig = {
			host: "ws://" + oSTOMMQConfig.host + ":15674/ws",
			username: oSTOMMQConfig.user,
			password: oSTOMMQConfig.password,
			vHost: oSTOMMQConfig.vhost
		};

		// Update Status For Delete Qname Parameter
		var poUpdateStaDelQnameParams = {
			ptDocTableName: "TCNTPdtTwxHD",
			ptDocFieldDocNo: "FTXthDocNo",
			ptDocFieldStaApv: "FTXthStaPrcStk",
			ptDocFieldStaDelMQ: "FTXthStaDelMQ",
			ptDocStaDelMQ: tStaDelMQ,
			ptDocNo: tDocNo
		};

		// Callback Page Control(function)
		var poCallback = {
			tCallPageEdit: "JSvCallPageTFWEdit",
			tCallPageList: "JSvCallPageTFWList"
		};

		//Check Show Progress %
		if (tDocNo != '' && (tStaApv == 2 || tStaPrcStk == 2)) { // 2 = Processing
			FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
		}

		//Check Delete MQ SubScrib
		if (tStaApv == 1 && tStaPrcStk == 1 && tStaDelMQ == '') { // Qname removed ?
			// console.log('DelMQ:');
			// Delete Queue Name Parameter
			var poDelQnameParams = {
				ptPrefixQueueName: tPrefix,
				ptBchCode: tUsrBchCode,
				ptDocNo: tDocNo,
				ptUsrCode: tUsrApv
			};
			FSxCMNRabbitMQDeleteQname(poDelQnameParams);
			FSxCMNRabbitMQUpdateStaDeleteQname(poUpdateStaDelQnameParams);
		}

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


		tSpmCode = $('#oetSpmCode').val();

		$('#oetSplCode').change(function() {
			//Clear Modal Pdt เพื่อโหลดใหม่ตอนเปลี่ยน Spl
			$('#odvBrowsePdtPanal').html('');
		});


		$('#ostPmcGetCond').on('change', function(e) {
			var nSelected = $("option:selected", this);
			var nValue = this.value;
			if (nValue == 1 || nValue == 3) {
				// alert('ราคา')
				$('.xWCdGetValue').removeClass('xCNHide');
				$('.xWCdGetQty').addClass('xCNHide');
				$('.xWCdPerAvgDis').addClass('xCNHide');

			} else if (nValue == 2) {
				// alert('จำนวน %')
				$('.xWCdGetValue').addClass('xCNHide');
				$('.xWCdGetQty').addClass('xCNHide');
				$('.xWCdPerAvgDis').removeClass('xCNHide');

			} else if (nValue == 4) {
				// alert('จำนวน แต้ม')
				$('.xWCdGetValue').addClass('xCNHide');
				$('.xWCdGetQty').removeClass('xCNHide');
				$('.xWCdPerAvgDis').addClass('xCNHide');

			}

			$('#oetPmcGetQty').val('');
			$('#oetPmcGetValue').val('');
			$('#oetPmcPerAvgDis').val('');

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

		$('#ostXthVATInOrEx').on('change', function(e) {
			JSvTFWLoadPdtDataTableHtml(); // คำนวนท้ายบิลใหม่
		});

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

	var oTFWBrowseSpl = {

		Title: ['supplier/supplier/supplier', 'tSPLTitle'],
		Table: {
			Master: 'TCNMSpl',
			PK: 'FTSplCode'
		},
		Join: {
			Table: ['TCNMSpl_L', 'TCNMSplCredit'],
			On: ['TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = ' + nLangEdits,
				'TCNMSpl_L.FTSplCode = TCNMSplCredit.FTSplCode'
			]
		},
		Where: {
			Condition: ["AND TCNMSpl.FTSplStaActive = '1' "]
		},
		GrideView: {
			ColumnPathLang: 'supplier/supplier/supplier',
			ColumnKeyLang: ['tSPLTBCode', 'tSPLTBName'],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TCNMSpl.FTSplCode', 'TCNMSpl_L.FTSplName', 'TCNMSplCredit.FNSplCrTerm', 'TCNMSplCredit.FCSplCrLimit', 'TCNMSpl.FTSplStaVATInOrEx', 'TCNMSplCredit.FTSplTspPaid'],
			DataColumnsFormat: ['', ''],
			DisabledColumns: [2, 3, 4, 5],
			Perpage: 10,
			OrderBy: ['TCNMSpl.FDCreateOn DESC'],
			// SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetSplCode", "TCNMSpl.FTSplCode"],
			Text: ["oetSplName", "TCNMSpl_L.FTSplName"],
		},
		NextFunc: {
			FuncName: 'JSxTFWGetDataToFillSpl',
			ArgReturn: ['FNSplCrTerm', 'FCSplCrLimit', 'FTSplStaVATInOrEx', 'FTSplTspPaid', 'FTSplCode', 'FTSplName']
		},
		RouteAddNew: 'supplier',
		BrowseLev: nStaTFWBrowseType

	}

	var oTFWBrowseSpn = {

		Title: ['pos5/saleperson', 'tSPNTitle'],
		Table: {
			Master: 'TCNMSpn',
			PK: 'FTSpnCode'
		},
		Join: {
			Table: ['TCNMSpn_L'],
			On: ['TCNMSpn_L.FTSpnCode = TCNMSpn.FTSpnCode AND TCNMSpn_L.FNLngID = ' + nLangEdits, ]
		},
		GrideView: {
			ColumnPathLang: 'pos5/saleperson',
			ColumnKeyLang: ['tSPNCode', 'tSPNName', '', '', ''],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TCNMSpn.FTSpnCode', 'TCNMSpn_L.FTSpnName'],
			DataColumnsFormat: ['', ''],
			DisabledColumns: [2, 3, 4],
			Perpage: 10,
			OrderBy: ['TCNMSpn.FDCreateOn DESC'],
			// SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetSpnCode", "TCNMSpn.FTSpnCode"],
			Text: ["oetSpnName", "TCNMSpn_L.FTSpnName"],
		},
		RouteAddNew: 'suplier',
		BrowseLev: nStaTFWBrowseType

	}

	var nLangEdits;
	var oPmhBrowseBch;
	var oTFWBrowseMch;
	var oTFWBrowseShpStart;
	var oTFWBrowsePosStart;
	var oTFWBrowseWahStart;
	var oTFWBrowseShpEnd;
	var oTFWBrowsePosEnd;
	var oTFWBrowseWahEnd;
	var oTFWBrowseShipAdd;
	var tOldBchCkChange = "";
	var tOldMchCkChange = "";
	var tOldShpStartCkChange = "";
	var tOldShpEndCkChange = "";
	var oTFWBrowseShipVia = "";

	//กลุ่มร้านค้า
	$('#obtTFWBrowseMch').click(function() {

		var tWhereBch = "";
		tWhereBch = $("#oetBchCode").val();

		JSxCheckPinMenuClose(); // Hidden Pin Menu
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW,#odvTFWPopupCancel,#odvPDTTrnCantQtyisZero)").remove();
		tOldMchCkChange = $("#oetMchCode").val();
		oTFWBrowseMch = {
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
				Condition: ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '" + tWhereBch + "') != 0"]
			},
			GrideView: {
				ColumnPathLang: 'company/warehouse/warehouse',
				ColumnKeyLang: ['tWAHBwsMchCode', 'tWAHBwsMchNme'],
				ColumnsSize: ['15%', '75%'],
				WidthModal: 50,
				DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
				DataColumnsFormat: ['', ''],
				Perpage: 10,
				OrderBy: ['TCNMMerchant.FDCreateOn DESC'],
				// SourceOrder: "ASC"
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
			BrowseLev: 1,
			// DebugSQL : true
		};
		//Option merchant
		JCNxBrowseData('oTFWBrowseMch');
	});

	//ร้านเริ่ม
	$('#obtTFWBrowseShpStart').click(function() {
		// let tBchCode =  "";
		// if(tSesUsrLevel == 'HQ'){
		// 	tBchCode = $("#oetHQBchCode").val();
		// }else{
		var tBchCode = $("#oetBchCode").val();
		// }
		// let tEditBchCode = $('#oetEditBchCode').val();
		// if(tEditBchCode != ""){
		// 	tBchCode = tEditBchCode;
		// }
		JSxCheckPinMenuClose(); // Hidden Pin Menu
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW,#odvTFWPopupCancel,#odvPDTTrnCantQtyisZero)").remove();
		tOldShpStartCkChange = $("#oetShpCodeStart").val();
		//Option Shop  Start
		oTFWBrowseShpStart = {
			Title: ['company/shop/shop', 'tSHPTitle_POS'],
			Table: {
				Master: 'TCNMShop',
				PK: 'FTShpCode'
			},
			Join: {
				Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
				On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
					'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMShop.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = " AND TCNMShop.FTShpStaActive = '1' AND TCNMShop.FTBchCode = '" + tBchCode + "' ";
						if ($("#oetMchCode").val() != '') {
							tSQL += " AND TCNMShop.FTMerCode = '" + $("#oetMchCode").val() + "' ";
						}
						tSQL += " AND TCNMShop.FTShpType NOT IN ('4','5') ";
						if ($("#oetShpCodeEnd").val() != "" && $("#ohdWahCodeEnd").val() != "") { // ร้านค้าปลายทางกำหนดแล้ว และ คลังปลายทางกำหนดแล้ว
							if ($($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) { // POS ปลายทางถูกซ่อนอยู่
								if ($($($($("#obtTFWBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")) { // POS ต้นทางถูกซ่อนอยู่ 
									// tSQL += " AND TCNMShop.FTShpCode != '" + $("#oetShpCodeEnd").val() + "'";
								} else {
									if ($("#oetShpCodeStart").val() != "") { // ร้านค้าต้นทางกำหนดแล้ว
										tSQL += " AND TCNMShop.FTShpCode != '" + $("#oetShpCodeEnd").val() + "'";
									}
								}
							}
						}
						return tSQL;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'company/branch/branch',
				ColumnKeyLang: ['tBCHCode', 'tBCHName'],
				ColumnsSize: ['25%', '75%'],
				WidthModal: 50,
				DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTWahCode', 'TCNMWaHouse_L.FTWahName', 'TCNMShop.FTShpType', 'TCNMShop.FTBchCode'],
				DataColumnsFormat: ['', '', '', '', '', ''],
				DisabledColumns: [2, 3, 4, 5],
				Perpage: 10,
				OrderBy: ['TCNMShop.FDCreateOn DESC'],
				// SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetShpCodeStart", "TCNMShop.FTShpCode"],
				Text: ["oetShpNameStart", "TCNMShop_L.FTShpName"],
			},
			NextFunc: {
				FuncName: 'JSxSetSeqConditionShpStart',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1,
			// DebugSQL: true

		}
		//Option Shop Start
		JCNxBrowseData('oTFWBrowseShpStart');
	});

	//เครื่องจุดขายเริ่ม
	$('#obtTFWBrowsePosStart').click(function() {
		// let tBchCode =  "";
		// if(tSesUsrLevel == 'HQ'){
		// 	tBchCode = $("#oetHQBchCode").val();
		// }else{
		// 	tBchCode = $("#oetBchCode").val();
		// }
		// let tEditBchCode = $('#oetEditBchCode').val();
		// if(tEditBchCode != ""){
		// 	tBchCode = tEditBchCode;
		// }

		var tBchCode = $("#oetBchCode").val();

		JSxCheckPinMenuClose(); // Hidden Pin Menu
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW,#odvTFWPopupCancel,#odvPDTTrnCantQtyisZero)").remove();
		//Option Shop  Start
		oTFWBrowsePosStart = {
			Title: ['pos/posshop/posshop', 'tPshTBPosCode'],
			Table: {
				Master: 'TVDMPosShop',
				PK: 'FTPosCode'
			},
			Join: {
				Table: ['TCNMPos', 'TCNMPosLastNo', 'TCNMWaHouse', 'TCNMWaHouse_L'],
				On: ['TVDMPosShop.FTPosCode = TCNMPos.FTPosCode',
					'TVDMPosShop.FTPosCode = TCNMPosLastNo.FTPosCode',
					'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTWahStaType = 6',
					'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode  AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = "AND TCNMPos.FTPosStaUse = 1 AND TVDMPosShop.FTShpCode = '" + $("#oetShpCodeStart").val() + "' AND TVDMPosShop.FTBchCode = '" + tBchCode + "'";
						if ($("#oetShpCodeEnd").val() != "") {
							if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
								if ($("#oetPosCodeEnd").val() != "") {
									tSQL += " AND TVDMPosShop.FTPosCode != '" + $("#oetPosCodeEnd").val() + "'";
								}
							}
						}
						return tSQL;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'pos/posshop/posshop',
				ColumnKeyLang: ['tPshBRWShopTBCode', 'tPshBRWPosTBName'],
				ColumnsSize: ['25%', '75%'],
				WidthModal: 50,
				DataColumns: ['TVDMPosShop.FTPosCode', 'TCNMPosLastNo.FTPosComName', 'TVDMPosShop.FTShpCode', 'TVDMPosShop.FTBchCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
				DataColumnsFormat: ['', '', '', '', '', ''],
				DisabledColumns: [1, 2, 3, 4, 5],
				Perpage: 10,
				OrderBy: ['TVDMPosShop.FDCreateOn DESC'],
				// SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetPosCodeStart", "TVDMPosShop.FTPosCode"],
				Text: ["oetPosNameStart", "TVDMPosShop.FTPosCode"],
			},
			NextFunc: {
				FuncName: 'JSxSetSeqConditionPosStart',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1

		}
		//Option Shop Start
		JCNxBrowseData('oTFWBrowsePosStart');
	});

	//คลังเริ่ม
	$('#obtTFWBrowseWahStart').click(function() {

		//User สาขาจะมองไม่เห็นคลังของเสีย
		//โอนสินค้าระหว่างคลัง จะมองไม่เห็นคลัง VD
		if ('<?= $this->session->userdata("tSesUsrLevel") ?>' != "HQ") {
			var tFindWahouse = " AND TCNMWaHouse.FTWahStaType IN('1','2','3','4','5','7','8','9') ";
		} else {
			var tFindWahouse = " AND TCNMWaHouse.FTWahStaType IN('1','2','3','4','5','7','8','9','10') ";
		}

		let tBchCode = $('#oetBchCode').val();

		//คลังเริ่ม
		JSxCheckPinMenuClose(); // Hidden Pin Menu
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW,#odvTFWPopupCancel,#odvPDTTrnCantQtyisZero)").remove();
		if (tBchCode != "" && $("#oetShpCodeStart").val() == "") {
			//Option WareHouse From
			oTFWBrowseWahStart = {
				Title: ['company/warehouse/warehouse', 'tWAHTitle'],
				Table: {
					Master: 'TCNMWaHouse',
					PK: 'FTWahCode'
				},
				Join: {
					Table: ['TCNMWaHouse_L'],
					On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
				},
				Where: {
					Condition: [
						function() {
							var tSQL = " AND TCNMWaHouse.FTBchCode ='" + tBchCode + "' AND TCNMWaHouse.FTWahStaPrcStk IN ('2') " + tFindWahouse + " ";
							if ($("#ohdWahCodeEnd").val() != "") {
								tSQL += " AND TCNMWaHouse.FTWahCode NOT IN ('" + $("#ohdWahCodeEnd").val() + "')";
							}
							return tSQL;
						}
					]
				},
				GrideView: {
					ColumnPathLang: 'company/warehouse/warehouse',
					ColumnKeyLang: ['tWahCode', 'tWahName'],
					DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
					DataColumnsFormat: ['', ''],
					ColumnsSize: ['15%', '75%'],
					Perpage: 10,
					WidthModal: 50,
					OrderBy: ['TCNMWaHouse.FDCreateOn DESC'],
					// SourceOrder: "ASC"
				},
				CallBack: {
					ReturnType: 'S',
					Value: ["ohdWahCodeStart", "TCNMWaHouse.FTWahCode"],
					Text: ["oetWahNameStart", "TCNMWaHouse_L.FTWahName"],
				},
				NextFunc: {
					FuncName: 'JSxSetSeqConditionWahStart',
					ArgReturn: []
				},
				RouteAddNew: 'warehouse',
				BrowseLev: nStaTFWBrowseType,
				// DebugSQL:true
			}
		} else if (tBchCode != "" && $("#oetShpCodeStart").val() != "") {
			//Option WareHouse From
			oTFWBrowseWahStart = {
				Title: ['company/warehouse/warehouse', 'tWAHTitle'],
				Table: {
					Master: 'TCNMShpWah',
					PK: 'FTWahCode'
				},
				Join: {
					Table: ['TCNMWaHouse', 'TCNMWaHouse_L'],
					On: [
						'TCNMShpWah.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMShpWah.FTBchCode = TCNMWaHouse.FTBchCode ',
						'TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode  AND TCNMWaHouse_L.FNLngID = ' + nLangEdits,
					]
				},
				Where: {
					Condition: [
						function() {
							var tSQL = "AND TCNMWaHouse.FTBchCode ='" + tBchCode + "' ";
							tSQL += " AND (TCNMWaHouse.FTWahStaType IN (2))";
							tSQL += " AND (TCNMShpWah.FTShpCode = '" + $("#oetShpCodeStart").val() + "')";
							if ($("#ohdWahCodeEnd").val() != "") {
								tSQL += " AND TCNMWaHouse.FTWahCode NOT IN ('" + $("#ohdWahCodeEnd").val() + "')";
							}
							return tSQL;
						}
					]
				},
				GrideView: {
					ColumnPathLang: 'company/warehouse/warehouse',
					ColumnKeyLang: ['tWahCode', 'tWahName'],
					DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
					DataColumnsFormat: ['', ''],
					ColumnsSize: ['15%', '75%'],
					Perpage: 10,
					WidthModal: 50,
					OrderBy: ['TCNMShpWah.FDCreateOn DESC'],
					// SourceOrder: "ASC"
				},
				CallBack: {
					ReturnType: 'S',
					Value: ["ohdWahCodeStart", "TCNMWaHouse.FTWahCode"],
					Text: ["oetWahNameStart", "TCNMWaHouse_L.FTWahName"],
				},
				NextFunc: {
					FuncName: 'JSxSetSeqConditionWahStart',
					ArgReturn: []
				},
				RouteAddNew: 'warehouse',
				BrowseLev: nStaTFWBrowseType,
				// DebugSQL:true
			}
		}
		//Option WareHouse From 
		JCNxBrowseData('oTFWBrowseWahStart');
	});

	//คลังจบ
	$('#obtTFWBrowseWahEnd').click(function() {

		//User สาขาจะมองไม่เห็นคลังของเสีย
		if ('<?= $this->session->userdata("tSesUsrLevel") ?>' != "HQ") {
			var tFindWahouse = " AND TCNMWaHouse.FTWahStaType IN('1','2','3','4','5','7','8','9') ";
		} else {
			var tFindWahouse = " AND TCNMWaHouse.FTWahStaType IN('1','2','3','4','5','7','8','9','10') ";
		}

		let tBchCode = $('#oetBchCode').val();
		JSxCheckPinMenuClose(); // Hidden Pin Menu
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW,#odvTFWPopupCancel,#odvPDTTrnCantQtyisZero)").remove();
		if (tBchCode != "" && $("#oetShpCodeEnd").val() == "") {
			//Option WareHouse From
			oTFWBrowseWahEnd = {
				Title: ['company/warehouse/warehouse', 'tWAHTitle'],
				Table: {
					Master: 'TCNMWaHouse',
					PK: 'FTWahCode'
				},
				Join: {
					Table: ['TCNMWaHouse_L'],
					On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
				},
				Where: {
					Condition: [
						function() {
							var tSQL = "AND TCNMWaHouse.FTBchCode ='" + tBchCode + "' AND TCNMWaHouse.FTWahStaPrcStk IN ('2') " + tFindWahouse + " ";
							if ($("#ohdWahCodeStart").val() != "") {
								tSQL += " AND TCNMWaHouse.FTWahCode NOT IN ('" + $("#ohdWahCodeStart").val() + "') ";
							}
							return tSQL;
						}
					]
				},
				GrideView: {
					ColumnPathLang: 'company/warehouse/warehouse',
					ColumnKeyLang: ['tWahCode', 'tWahName'],
					DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
					DataColumnsFormat: ['', ''],
					ColumnsSize: ['15%', '75%'],
					Perpage: 10,
					WidthModal: 50,
					OrderBy: ['TCNMWaHouse.FDCreateOn DESC'],
					// SourceOrder: "ASC"
				},
				CallBack: {
					ReturnType: 'S',
					Value: ["ohdWahCodeEnd", "TCNMWaHouse.FTWahCode"],
					Text: ["oetWahNameEnd", "TCNMWaHouse_L.FTWahName"],
				},
				NextFunc: {
					FuncName: 'JSxSetSeqConditionWahEnd',
					ArgReturn: []
				},
				RouteAddNew: 'warehouse',
				BrowseLev: nStaTFWBrowseType,
				// DebugSQL:true
			}
		} else if (tBchCode != "" && $("#oetShpCodeEnd").val() != "") {
			//Option WareHouse From
			oTFWBrowseWahEnd = {
				Title: ['company/warehouse/warehouse', 'tWAHTitle'],
				Table: {
					Master: 'TCNMShpWah',
					PK: 'FTWahCode'
				},
				Join: {
					Table: ['TCNMWaHouse', 'TCNMWaHouse_L'],
					On: [
						'TCNMShpWah.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMShpWah.FTBchCode = TCNMWaHouse.FTBchCode ',
						'TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode  AND TCNMWaHouse_L.FNLngID = ' + nLangEdits,
					]
				},
				Where: {
					Condition: [
						function() {

							var tSQL = "AND TCNMWaHouse.FTBchCode ='" + tBchCode + "' ";
							tSQL += " AND (TCNMWaHouse.FTWahStaType IN (2))";
							tSQL += " AND (TCNMShpWah.FTShpCode = '" + $("#oetShpCodeEnd").val() + "')";
							if ($("#ohdWahCodeStart").val() != "") {
								tSQL += " AND (TCNMWaHouse.FTWahCode NOT IN ('" + $("#ohdWahCodeStart").val() + "'))";
							}
							return tSQL;
						}
					]
				},
				GrideView: {
					ColumnPathLang: 'company/warehouse/warehouse',
					ColumnKeyLang: ['tWahCode', 'tWahName'],
					DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
					DataColumnsFormat: ['', ''],
					ColumnsSize: ['15%', '75%'],
					Perpage: 10,
					WidthModal: 50,
					OrderBy: ['TCNMShpWah.FDCreateOn DESC'],
					// SourceOrder: "ASC"
				},
				CallBack: {
					ReturnType: 'S',
					Value: ["ohdWahCodeEnd", "TCNMWaHouse.FTWahCode"],
					Text: ["oetWahNameEnd", "TCNMWaHouse_L.FTWahName"],
				},
				NextFunc: {
					FuncName: 'JSxSetSeqConditionWahEnd',
					ArgReturn: []
				},
				RouteAddNew: 'warehouse',
				BrowseLev: nStaTFWBrowseType,
				// DebugSQL:true
			}
		}
		//Option WareHouse From 
		JCNxBrowseData('oTFWBrowseWahEnd');
	});

	// เลือกร้านปลายทาง
	$('#obtTFWBrowseShpEnd').click(function() {
		// 	var tBchCode =  "";
		// 	if(tSesUsrLevel == 'HQ'){
		// 		tBchCode = $("#oetHQBchCode").val();
		// 	}else{
		// 		tBchCode = $("#oetBchCode").val();
		// 	}
		// 	let tEditBchCode = $('#oetEditBchCode').val();
		// 	if(tEditBchCode != ""){
		// 		tBchCode = tEditBchCode;
		// }

		var tBchCode = $("#oetBchCode").val();

		JSxCheckPinMenuClose(); // Hidden Pin Menu
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW,#odvTFWPopupCancel,#odvPDTTrnCantQtyisZero)").remove();
		tOldShpEndCkChange = $("#oetShpCodeEnd").val();
		// Option Shop  Start
		oTFWBrowseShpEnd = {
			Title: ['company/shop/shop', 'tSHPTitle_POS'],
			Table: {
				Master: 'TCNMShop',
				PK: 'FTShpCode'
			},
			Join: {
				Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
				On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
					'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMShop.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = "AND TCNMShop.FTShpStaActive = '1' AND TCNMShop.FTBchCode = '" + tBchCode + "' ";
						if ($("#oetMchCode").val() != '') {
							tSQL += " AND TCNMShop.FTMerCode = '" + $("#oetMchCode").val() + "' ";
						}
						tSQL += " AND TCNMShop.FTShpType NOT IN ('4','5') ";
						if ($("#oetShpCodeStart").val() != "" && $("#ohdWahCodeStart").val() != "") { // เลือกร้านค้า และคลัง ต้นทาง แล้ว
							if ($($($($("#obtTFWBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")) { // Browse POS ต้นทาง ซ่อนอยู่ 
								if ($($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) { // Browse POS ปลายทาง ซ่อนอยู่
									// tSQL += " AND TCNMShop.FTShpCode != '" + $("#oetShpCodeStart").val() + "'";
								} else { // Browse POS ปลายทาง แสดงอยู่
									if ($("#oetShpCodeEnd").val() != "") { // มีการกำหนดค่าให้กับ shop code ร้านค้าปลายทางแล้ว
										tSQL += " AND TCNMShop.FTShpCode != '" + $("#oetShpCodeStart").val() + "' ";
									}
								}
							}
						}

						return tSQL;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'company/branch/branch',
				ColumnKeyLang: ['tBCHCode', 'tBCHName'],
				ColumnsSize: ['25%', '75%'],
				WidthModal: 50,
				DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTWahCode', 'TCNMWaHouse_L.FTWahName', 'TCNMShop.FTShpType', 'TCNMShop.FTBchCode'],
				DataColumnsFormat: ['', '', '', '', '', ''],
				DisabledColumns: [2, 3, 4, 5],
				Perpage: 10,
				OrderBy: ['TCNMShop.FDCreateOn DESC'],
				// SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetShpCodeEnd", "TCNMShop.FTShpCode"],
				Text: ["oetShpNameEnd", "TCNMShop_L.FTShpName"],
			},
			NextFunc: {
				FuncName: 'JSxSetSeqConditionShpEnd',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1,
			// DebugSQL:true
		}
		// Option Shop End
		JCNxBrowseData('oTFWBrowseShpEnd');
	});

	//เครื่องจุดขายจบ
	$('#obtTFWBrowsePosEnd').click(function() {
		let tBchCode = "";
		if (tSesUsrLevel == 'HQ') {
			tBchCode = $("#oetHQBchCode").val();
		} else {
			tBchCode = $("#oetBchCode").val();
		}
		let tEditBchCode = $('#oetEditBchCode').val();
		if (tEditBchCode != "") {
			tBchCode = tEditBchCode;
		}
		JSxCheckPinMenuClose(); // Hidden Pin Menu
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW,#odvTFWPopupCancel,#odvPDTTrnCantQtyisZero)").remove();
		//Option Shop  Start
		oTFWBrowsePosEnd = {
			Title: ['pos/posshop/posshop', 'tPshTBPosCode'],
			Table: {
				Master: 'TVDMPosShop',
				PK: 'FTPosCode'
			},
			Join: {
				Table: ['TCNMPos', 'TCNMPosLastNo', 'TCNMWaHouse', 'TCNMWaHouse_L'],
				On: ['TVDMPosShop.FTPosCode = TCNMPos.FTPosCode',
					'TVDMPosShop.FTPosCode = TCNMPosLastNo.FTPosCode',
					'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTWahStaType = 6',
					'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = "AND TCNMPos.FTPosStaUse = 1 AND TVDMPosShop.FTShpCode = '" + $("#oetShpCodeEnd").val() + "' AND TVDMPosShop.FTBchCode = '" + tBchCode + "'";
						if ($("#oetShpCodeStart").val() != "") {
							if ($("#oetShpCodeEnd").val() == $("#oetShpCodeStart").val()) {
								if ($("#oetPosCodeStart").val() != "") {
									tSQL += " AND TVDMPosShop.FTPosCode NOT IN ('" + $("#oetPosCodeStart").val() + "')";
								}
							}
						}
						return tSQL;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'pos/posshop/posshop',
				ColumnKeyLang: ['tPshBRWShopTBCode', 'tPshBRWPosTBName'],
				ColumnsSize: ['25%', '75%'],
				WidthModal: 50,
				DataColumns: ['TVDMPosShop.FTPosCode', 'TCNMPosLastNo.FTPosComName', 'TVDMPosShop.FTShpCode', 'TVDMPosShop.FTBchCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
				DataColumnsFormat: ['', '', '', '', '', ''],
				DisabledColumns: [1, 2, 3, 4, 5],
				Perpage: 10,
				OrderBy: ['TVDMPosShop.FDCreateOn DESC'],
				// SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetPosCodeEnd", "TVDMPosShop.FTPosCode"],
				Text: ["oetPosNameEnd", "TVDMPosShop.FTPosCode"],
			},
			NextFunc: {
				FuncName: 'JSxSetSeqConditionPosEnd',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1

		}
		//Option Shop 
		JCNxBrowseData('oTFWBrowsePosEnd');
	});

	$('#obtTFWBrowseShipAdd').click(function(pE) {
		JSxCheckPinMenuClose(); // Hidden Pin Menu
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW,#odvTFWPopupCancel,#odvPDTTrnCantQtyisZero)").remove();
		$("#odvTFWBrowseShipAdd").modal("show");
	});

	//Event Browse ShipAdd
	$('#oliBtnEditShipAdd').click(function() {
		// let tBchCode = $("#oetBchCode").val();
		let tBchCode = "";
		if (tSesUsrLevel == 'HQ') {
			tBchCode = $("#oetBchCode").val();
		} else {
			tBchCode = $("#oetBchCode").val();
		}
		let tEditBchCode = $('#oetBchCode').val();
		if (tEditBchCode != "") {
			tBchCode = tEditBchCode;
		}


		JSxCheckPinMenuClose(); // Hidden Pin Menu
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW,#odvTFWPopupCancel,# .modal('toggle'))").remove();
		//option Ship Address 
		oTFWBrowseShipAdd = {
			Title: ['document/producttransferwahouse/producttransferwahouse', 'tBrowseADDTitle'],
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
						var tFilter = "";
						if (tBchCode != "") {
							if ($("#oetMchCode").val() != "") {
								if ($("#oetShpCodeEnd").val() != "") {
									if ($("#oetPosCodeEnd").val() != "") {
										// เครื่องจุดขาย
										tFilter += "AND FTAddGrpType = 6 AND FTAddRefCode = '" + $("#oetPosCodeEnd").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
									} else {
										// ร้านค้า
										tFilter += "AND FTAddGrpType = 4 AND FTAddRefCode = '" + $("#oetShpCodeEnd").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
									}
								} else {
									// สาขา
									tFilter += "AND FTAddGrpType = 1 AND FTAddRefCode = '" + tBchCode + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
								}
							} else {
								// สาขา
								tFilter += "AND FTAddGrpType = 1 AND FTAddRefCode = '" + tBchCode + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
							}
						}
						return tFilter;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'document/producttransferwahouse/producttransferwahouse',
				ColumnKeyLang: [
					'tBrowseADDBch',
					'tBrowseADDSeq',
					'tBrowseADDV1No',
					'tBrowseADDV1Soi',
					'tBrowseADDV1Village',
					'tBrowseADDV1Road',
					'tBrowseADDV1SubDist',
					'tBrowseADDV1DstCode',
					'tBrowseADDV1PvnCode',
					'tBrowseADDV1PostCode'
				],
				DataColumns: [
					'TCNMAddress_L.FTAddRefCode',
					'TCNMAddress_L.FNAddSeqNo',
					'TCNMAddress_L.FTAddV1No',
					'TCNMAddress_L.FTAddV1Soi',
					'TCNMAddress_L.FTAddV1Village',
					'TCNMAddress_L.FTAddV1Road',
					'TCNMSubDistrict_L.FTSudName',
					'TCNMDistrict_L.FTDstName',
					'TCNMProvince_L.FTPvnName',
					'TCNMAddress_L.FTAddV1PostCode',
					'TCNMAddress_L.FTAddV1SubDist',
					'TCNMAddress_L.FTAddV1DstCode',
					'TCNMAddress_L.FTAddV1PvnCode',
					'TCNMAddress_L.FTAddV2Desc1',
					'TCNMAddress_L.FTAddV2Desc2'
				],
				DataColumnsFormat: ['', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
				ColumnsSize: [''],
				DisabledColumns: [10, 11, 12, 13, 14],
				Perpage: 10,
				WidthModal: 50,
				OrderBy: ['TCNMAddress_L.FDCreateOn DESC'],
				// SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["ohdShipAddSeqNo", "TCNMAddress_L.FNAddSeqNo"],
				Text: ["ohdShipAddSeqNo", "TCNMAddress_L.FNAddSeqNo"],
			},
			NextFunc: {
				FuncName: 'JSvTFWGetShipAddData',
				ArgReturn: ['FNAddSeqNo', 'FTAddV1No', 'FTAddV1Soi', 'FTAddV1Village', 'FTAddV1Road', 'FTSudName', 'FTDstName', 'FTPvnName', 'FTAddV1PostCode', 'FTAddV2Desc1', 'FTAddV2Desc2']
			},
			BrowseLev: 1
		}
		//option Ship Address 
		JCNxBrowseData('oTFWBrowseShipAdd');
	});

	$("#obtSearchShipVia").click(function() {
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW,#odvTFWPopupCancel,#odvPDTTrnCantQtyisZero)").remove();
		//option Ship Address 
		oTFWBrowseShipVia = {
			Title: ['document/producttransferwahouse/producttransferwahouse', 'tTFWShipViaModalTitle'],
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
				ColumnPathLang: 'document/producttransferwahouse/producttransferwahouse',
				ColumnKeyLang: ['tTFWShipViaCode', 'tTFWShipViaName'],
				DataColumns: ['TCNMShipVia.FTViaCode', 'TCNMShipVia_L.FTViaName'],
				DataColumnsFormat: ['', ''],
				ColumnsSize: [''],
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
			BrowseLev: 0
		}
		//option Ship Address 
		JCNxBrowseData('oTFWBrowseShipVia');
	});

	$('#obtTFWBrowseSpl').click(function() {
		JCNxBrowseData('oTFWBrowseSpl');
	});
	$('#obtTFWBrowseShp').click(function() {
		JCNxBrowseData('oTFWBrowseShp');
	});

	$('#obtTFWBrowseWahTo').click(function() {
		JCNxBrowseData('oTFWBrowseWahTo');
	});
	$('#obtTFWBrowseRate').click(function() {
		JCNxBrowseData('oTFWBrowseRate');
	});


	//Option Promotion GrpBuy
	var oTFWBrowsePdt = {

		Title: ['product/product/product', 'tPDTTitle'],
		Table: {
			Master: 'TCNMPdt',
			PK: 'FTPdtCode'
		},
		Join: {
			Table: ['TCNMPdt_L', 'TCNMPdtPackSize', 'TCNMPdtUnit_L', 'TCNMPdtBar', 'TCNMPdtSpl', 'TCNTPdtPrice4PDT'],
			On: ['TCNMPdt_L.FTPdtCode 			= 	TCNMPdt.FTPdtCode AND TCNMPdt_L.FNLngID = ' + nLangEdits,
				"TCNMPdt.FTPdtCode					= 	TCNMPdtPackSize.FTPdtCode AND TCNMPdtPackSize.FCPdtUnitFact = '1'",
				'TCNMPdtPackSize.FTPunCode	= 	TCNMPdtUnit_L.FTPunCode AND TCNMPdtUnit_L.FNLngID=' + nLangEdits,
				'TCNMPdt.FTPdtCode					= 	TCNMPdtBar.FTPdtCode AND TCNMPdtPackSize.FTPunCode = TCNMPdtBar.FTPunCode',
				'TCNMPdt.FTPdtCode					= 	TCNMPdtSpl.FTPdtCode',
				'TCNTPdtPrice4PDT.FTPdtCode	= 	TCNMPdt.FTPdtCode  AND TCNTPdtPrice4PDT.FTPunCode  = TCNMPdtPackSize.FTPunCode AND TCNTPdtPrice4PDT.FTPghDocType = 1 AND TCNTPdtPrice4PDT.FDPghDStart <= GETDATE()',
			]
		},
		Where: {
			Condition: ["AND TCNMPdt.FTPdtType IN('1','2','4') AND TCNMPdt.FTPdtStaActive='1' AND TCNMPdt.FTPdtForSystem = '1' AND TCNMPdt.FTPdtStaActive = '1' "]
		},
		Filter: {
			Selector: 'oetSplCode',
			Table: 'TCNMPdtSpl',
			Key: 'FTSplCode'
		},
		GrideView: {
			ColumnPathLang: 'pos5/product',
			ColumnKeyLang: ['tPDTCode', 'tPDTName', 'tPDTTBUnit', 'tPDTTBPrice', ''],
			ColumnsSize: ['15%', '25%', '20%', '20%'],
			WidthModal: 50,
			DataColumns: ['TCNMPdt.FTPdtCode', 'TCNMPdt_L.FTPdtName', 'TCNMPdtUnit_L.FTPunName', 'TCNTPdtPrice4PDT.FCPgdPriceRET', 'TCNMPdtUnit_L.FTPunCode'],
			DataColumnsFormat: ['', '', '', ''],
			DisabledColumns: [4],
			Perpage: 10,
			OrderBy: ['TCNMPdt_L.FTPdtName'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'M',
			StaDoc: '1',
			StaSingItem: '1',
			Value: ["ohdTFWPdtCode", "TCNMPdt.FTPdtCode"],
			Text: ["ohdTFWPdtName", "TCNMPdt_L.FTPdtName"],

		},
		BrowsePdt: 1,
		NextFunc: {
			FuncName: 'JSxTFWAddPdtInRow',
			ArgReturn: ['FTPdtCode', 'FTPunCode']
		},
		RouteAddNew: 'product',
		BrowseLev: nStaTFWBrowseType,
		DebugSQL: 0,
		DebugSQL: true,
	}

	//Event Browse
	$('#obtTFWBrowsePdt').click(function() {
		JCNxBrowseProductData('oTFWBrowsePdt');
	});

	// put ค่าจาก Modal ลง Input หน้า Add
	function JSnTFWAddShipAdd() {
		tShipAddSeqNoSelect = $('#ohdShipAddSeqNo').val();
		$('#ohdXthShipAdd').val(tShipAddSeqNoSelect);

		$('#odvTFWBrowseShipAdd').modal('toggle');
	}

	function JSxTFWAddPdtInRow(poJsonData) {

		for (var n = 0; n < poJsonData.length; n++) {

			tdVal = $('.nItem' + n).data('otrval')

			if (tdVal != '' && tdVal == undefined) {

				nTRID = JCNnRandomInteger(100, 1000000);

				aColDatas = JSON.parse(poJsonData[n]);
				tPdtCode = aColDatas[0];
				tPunCode = aColDatas[1];
				FSvTFWAddPdtIntoTableDT(tPdtCode, tPunCode);

			}
		}

	}

	//Functionality : Select Spl To input
	//Parameters : -
	//Creator : 01/08/2018 Krit(Copter)
	//Return : View
	//Return Type : value to input
	function JSxTFWGetDataToFillSpl(poJsonData) {

		tOldSplCode = $('#ohdOldSplCode').val();
		tOldSplName = $('#oetOldSplName').val();
		tNewSplCode = $('#oetSplCode').val();

		bStaHavePdt = $('#odvPdtTablePanal tbody tr').hasClass('xCNDOCPdtItem');

		//Check ว่ามีการเปลี่ยน Spl หรือไม่
		if (tOldSplCode != tNewSplCode && tOldSplCode != '' && bStaHavePdt === true) {

			bootbox.confirm({
				title: aLocale['tWarning'],
				message: 'Suplier มีการเปลี่ยนแปลง Product ที่ถูกเพิ่มแล้วจะถูกล้างค่า ต้องการทำต่อหรือไม่ ?',
				buttons: {
					cancel: {
						label: aLocale['tBtnConfirm'],
						className: 'xCNBTNPrimery'
					},
					confirm: {
						label: aLocale['tBtnClose'],
						className: 'xCNBTNDefult'
					}
				},
				callback: function(result) {
					if (result == false) {

						aJsonData = JSON.parse(poJsonData);
						nXthCrTerm = days = parseInt(aJsonData[0], 10); //
						tSplCrLimit = aJsonData[1] //
						tSplStaVATInOrEx = aJsonData[2] //
						tSplTspPaid = aJsonData[3] //
						tSplCode = aJsonData[4] //
						tSplName = aJsonData[5] //

						$('#ohdOldSplCode').val(tSplCode).trigger('change');
						$('#oetOldSplName').val(tSplName).trigger('change');

						//Put Data into Form
						//สด/เครดิต
						if (nXthCrTerm > 0) {
							$('#ostXthCshOrCrd').val('2').trigger('change');
						} else {
							$('#ostXthCshOrCrd').val('1').trigger('change');
						}
						//จำนวนวันเครดิต
						$('#oetXthCrTerm').val(nXthCrTerm);

						//ประเภทภาษี 1.รวมใน 2.แยกนอกแยกนอก
						if (tSplStaVATInOrEx == '') {
							tSplStaVATInOrEx = 1; //Def value 
						}
						$('#ostXthVATInOrEx').val(tSplStaVATInOrEx).trigger('change');

						dDocDate = $('#oetXthDocDate').val(); // Doc Date
						date = new Date($("#oetXthDocDate").val());


						if (!isNaN(date.getTime())) {
							date.setDate(date.getDate() + days);
							$('#oetXthDueDate').datepicker("setDate", date); //วันที่ครบกำหนดชำระนที่ครบกำหนดชำระ
						} else {
							alert("Please Enter Date");
							$('#oetXthDocDate').focus();
						}

						//การชำระเงิน
						if (tSplTspPaid == '') {
							tSplTspPaid = 1; //Def value 
						}
						$('#ostXthDstPaid').val(tSplTspPaid).trigger('change');


						//ลบข้อมูล สินค้าใน File
						JSnTFWRemoveAllDTInFile();

					} else {
						$('#oetSplCode').val(tOldSplCode).trigger('change');
						$('#oetSplName').val(tOldSplName).trigger('change');
					}
				}
			});

		} else {
			aJsonData = JSON.parse(poJsonData);
			nXthCrTerm = days = parseInt(aJsonData[0], 10); //
			tSplCrLimit = aJsonData[1] //
			tSplStaVATInOrEx = aJsonData[2] //
			tSplTspPaid = aJsonData[3] //
			tSplCode = aJsonData[4] //
			tSplName = aJsonData[5] //

			$('#ohdOldSplCode').val(tSplCode).trigger('change');
			$('#oetOldSplName').val(tSplName).trigger('change');

			//Put Data into Form
			//สด/เครดิต
			if (nXthCrTerm > 0) {
				$('#ostXthCshOrCrd').val('2').trigger('change');
			} else {
				$('#ostXthCshOrCrd').val('1').trigger('change');
			}
			//จำนวนวันเครดิต
			$('#oetXthCrTerm').val(nXthCrTerm);

			//ประเภทภาษี 1.รวมใน 2.แยกนอกแยกนอก
			if (tSplStaVATInOrEx == '') {
				tSplStaVATInOrEx = 1; //Def value 
			}
			$('#ostXthVATInOrEx').val(tSplStaVATInOrEx).trigger('change');

			dDocDate = $('#oetXthDocDate').val(); // Doc Date
			date = new Date($("#oetXthDocDate").val());


			if (!isNaN(date.getTime())) {
				date.setDate(date.getDate() + days);
				$('#oetXthDueDate').datepicker("setDate", date); //วันที่ครบกำหนดชำระนที่ครบกำหนดชำระ
			} else {
				alert("Please Enter Date");
				$('#oetXthDocDate').focus();
			}

			//การชำระเงิน
			if (tSplTspPaid == '') {
				tSplTspPaid = 1; //Def value 
			}
			$('#ostXthDstPaid').val(tSplTspPaid).trigger('change');

		}

	}

	function JSxTFWGetWahFormShop(poJsonData) {

		if (poJsonData != undefined) {
			aData = JSON.parse(poJsonData);

			tWahCode = aData[0];
			tWahName = aData[1];

			if (tWahCode != '' && tWahCode != undefined) {
				$('#ohdWahCode').val(tWahCode);
				$('#oetWahCodeName').val(tWahName);
			} else {
				$('#ohdWahCode').val('');
				$('#oetWahCodeName').val('');

			}
		}

	}

	function FSvTFWAddHDDis() {

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
					type: "TFWST",
					url: "TFWAddHDDisIntoTable",
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

	// Browse Branch
	$('#oimBrowseBch').click(function() {
		var nStaSession = JCNxFuncChkSessionExpired();
		if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
			JSxCheckPinMenuClose(); // Hide Menu Pin
			JCNxBrowseData('oBrowseBch');
		} else {
			JCNxShowMsgSessionExpired();
		}
	});

	var tWhere = "";
	if (nCountBch == 1) {
		$('#oimBrowseBch').attr('disabled', true);
	}
	if (tUsrLevel != "HQ") {
		tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";
	} else {
		tWhere = "";
	}

	var oBrowseBch = {
		Title: ['company/branch/branch', 'tBCHTitle'],
		Table: {
			Master: 'TCNMBranch',
			PK: 'FTBchCode',
			PKName: 'FTBchName'
		},
		Join: {
			Table: ['TCNMBranch_L', 'TCNMWaHouse_L'],
			On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID =' + nLangEdits,
				'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID =' + nLangEdits,
			]
		},
		Where: {
			Condition: [tWhere]
		},
		GrideView: {
			ColumnPathLang: 'company/branch/branch',
			ColumnKeyLang: ['tBCHCode', 'tBCHName', ''],
			ColumnsSize: ['15%', '75%', ''],
			WidthModal: 50,
			DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName', 'TCNMWaHouse_L.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
			DataColumnsFormat: ['', ''],
			DisabledColumns: [2, 3],
			Perpage: 10,
			OrderBy: ['TCNMBranch.FDCreateOn DESC'],
			// SourceOrder  : "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetBchCode", "TCNMBranch.FTBchCode"],
			Text: ["oetBchName", "TCNMBranch_L.FTBchName"],
		},
		NextFunc: {
			FuncName: 'JSxSetDefauleWahouse',
			ArgReturn: ['FTWahCode', 'FTWahName']
		}
	}

	function JSxSetDefauleWahouse(ptData) {
		if (ptData == '' || ptData == 'NULL') {
			$('#ohdWahCodeStart').val('');
			$('#oetWahNameStart').val('');
			$('#ohdWahCodeEnd').val('');
			$('#oetWahNameEnd').val('');
		} else {
			var tResult = JSON.parse(ptData);
			$('#oetWahNameStart').val(tResult[1]);
			$('#ohdWahCodeStart').val(tResult[0]);
		}

		$('#oetMchName').val('');
		$('#oetMchCode').val('');
		$('#oetShpNameStart').val('');
		$('#oetShpCodeStart').val('');
		$('#oetShpNameEnd').val('');
		$('#oetShpCodeEnd').val('');

	}

	//Print ใบโอนสินค้าระหว่างคลัง
	function FSxTranferProductPrintDoc() {
		var aInfor = [{
				"Lang": '<?= FCNaHGetLangEdit(); ?>'
			}, // Lang ID
			{
				"ComCode": '<?= FCNtGetCompanyCode(); ?>'
			}, // Company Code
			{
				"BranchCode": '<?= FCNtGetAddressBranch($tBchCode); ?>'
			}, // สาขาที่ออกเอกสาร
			{
				"DocCode": $('#oetXthDocNo').val()
			}, // เลขที่เอกสาร
			{
				"DocBchCode": '<?= $tBchCode; ?>'
			}
		];
		window.open("<?= base_url(); ?>formreport/ALLMPdtBillTnf?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
	}
</script>