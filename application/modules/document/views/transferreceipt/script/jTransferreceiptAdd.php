<script type="text/javascript">
	nLangEdits = <?php echo $this->session->userdata("tLangEdit"); ?>;
	tUsrApv = <?php echo $this->session->userdata("tSesUsername"); ?>;
	$(document).ready(function() {

		//RabbitMQ
		/*===========================================================================*/
		// Document variable
		var tLangCode = nLangEdits;
		var tUsrBchCode = $("#ohdBchCode").val();
		var tUsrApv = $("#oetXthApvCode").val();
		var tDocNo = $("#oetXthDocNo").val();
		var tPrefix = 'RESTWI';
		var tStaApv = $("#ohdXthStaApv").val();
		var tStaPrcStk = $("#ohdXthStaPrcStk").val();
		var tStaDelMQ = $("#ohdXthStaDelMQ").val();
		var tQName = tPrefix + '_' + tDocNo + '_' + tUsrApv;

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
			host: 'ws://202.44.55.94:15674/ws',
			username: 'adasoft',
			password: 'adasoft',
			vHost: 'AdaPosV5.0'
		};

		// Update Status For Delete Qname Parameter
		var poUpdateStaDelQnameParams = {
			ptDocTableName: "TCNTPdtTwiHD",
			ptDocFieldDocNo: "FTXthDocNo",
			ptDocFieldStaApv: "FTXthStaPrcStk",
			ptDocFieldStaDelMQ: "FTXthStaDelMQ",
			ptDocStaDelMQ: tStaDelMQ,
			ptDocNo: tDocNo
		};

		// Callback Page Control(function)
		var poCallback = {
			tCallPageEdit: 'JSvCallPageTXIEdit',
			tCallPageList: 'JSvCallPageTXIList'
		};

		//Check Show Progress %
		if (tDocNo != '' && (tStaApv == 2 || tStaPrcStk == 2)) { // 2 = Processing
			// console.log('ShowMsg:')
			FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
		}

		//Check Delete MQ SubScrib
		if (tStaApv == 1 && tStaPrcStk == 1 && tStaDelMQ == '') { // Qname removed ?
			// alert('DelMQ:');
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

		$('.xWTooltipsBT').tooltip({
			'placement': 'bottom'
		});
		$('[data-toggle="tooltip"]').tooltip({
			'placement': 'top'
		});

		$('#obtTXIBrowseShipAdd').click(function(ele) {

			FTAddRefCode = "";

			if ($("#oetPosCodeEnd").val() != '') {
				FTAddRefCode = $("#oetPosCodeEnd").val();
				console.log('Address : POS');
			} else if ($("#oetShpCodeEnd").val() != '') {
				FTAddRefCode = $("#oetShpCodeEnd").val();
				console.log('Address : Shop');
			} else if ($("#oetBchCode").val() != '') {
				FTAddRefCode = $("#oetBchCode").val();
				console.log('Address : Branch');
			}
			FNAddSeqNo = $('#ohdXthShipAdd').val();

			JSvTWIGetShipAddData(FTAddRefCode, FNAddSeqNo);
		});


		//Set DocDate is Date Now	
		dCurrentDate = new Date();
		if ($('#oetXthDocDate').val() == '') {
			$('#oetXthDocDate').datepicker("setDate", dCurrentDate); // Doc Date
		}

		if ($('#oetXthTnfDate').val() == '') {
			$('#oetXthTnfDate').datepicker("setDate", dCurrentDate); // 
		}

		$('#ostXthVATInOrEx').on('change', function(e) {
			JSvTXILoadPdtDataTableHtml(); // คำนวนท้ายบิลใหม่
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


		// /*Controle Browse สาขา*/
		// $('#oetBchCode').on('change', function (e) {
		// 	if($('#oetBchCode').val() == ''){
		// 		/* Control Browse Merchant */
		// 		$('#oetMerCode').val('');
		// 		$('#oetMerName').val('');
		// 		/* Control Browse Merchant */

		// 		/* Control Browse ร้านค้า */
		// 		//จาก
		// 		$('#oetShpCode').val('');
		// 		$('#oetShpName').val('');
		// 		$('#obtTXIBrowseShp').attr('disabled',true);
		// 		//ถึง
		// 		$('#oetShpCodeTo').val('');
		// 		$('#oetShpNameTo').val('');
		// 		$('#obtTXIBrowseShpTo').attr('disabled',true);
		// 		/* Control Browse ร้านค้า */

		// 		/* Control Browse เดรื่องจุดขาย */
		// 		//จาก
		// 		$('#oetPosCodeFrom').val('');
		// 		$('#oetPosNameFrom').val('');
		// 		$('#obtTXIBrowsePosFrom').attr('disabled',true);
		// 		//ถึง
		// 		$('#oetPosCodeTo').val('');
		// 		$('#oetPosNameTo').val('');
		// 		$('#obtTXIBrowsePosTo').attr('disabled',true);
		// 		/* Control Browse เดรื่องจุดขาย */

		// 		/* Control Browse โอนจากคลัง */
		// 		//จาก
		// 		$('#ohdWahCodeFrom').val('');
		// 		$('#oetWahNameFrom').val('');
		// 		$('#obtTXIBrowseWahFrom').attr('disabled',true);
		// 		//ถึง
		// 		$('#ohdWahCodeTo').val('');
		// 		$('#oetWahNameTo').val('');
		// 		$('#obtTXIBrowseWahTo').attr('disabled',true);
		// 		/* Control Browse โอนจากคลัง */
		// 	}else{
		// 		/* Control Browse Merchant */
		// 		$('#oetMerCode').val('');
		// 		$('#oetMerName').val('');
		// 		/* Control Browse Merchant */

		// 		$('#oetShpCode').val('');
		// 		$('#oetShpName').val('');
		// 		$('#obtTXIBrowseShp').attr('disabled',true);


		// 		$('#oetPosCodeFrom').val('');
		// 		$('#oetPosNameFrom').val('');
		// 		$('#obtTXIBrowsePosFrom').attr('disabled',true);

		// 		$('#ohdWahCodeFrom').val('');
		// 		$('#ohdWahNameFrom').val('');


		// 		$('#oetShpCodeTo').val('');
		// 		$('#oetShpNameTo').val('');


		// 		$('#oetPosCodeTo').val('');
		// 		$('#oetPosNameTo').val('');


		// 		/* Control Browse โอนจากคลัง */
		// 		//จาก
		// 		$('#ohdWahCodeFrom').val('');
		// 		$('#oetWahNameFrom').val('');
		// 		$('#obtTXIBrowseWahFrom').attr('disabled',false);
		// 		//Change Condition : WareHouse
		// 		oTWIBrowseWahFrom.Where.Condition = ["AND (TCNMWaHouse.FTWahStaType = '1' OR TCNMWaHouse.FTWahStaType = '2') "];
		// 		//ถึง
		// 		$('#ohdWahCodeTo').val('');
		// 		$('#oetWahNameTo').val('');
		// 		$('#obtTXIBrowseWahTo').attr('disabled',false);
		// 		//Change Condition : WareHouse
		// 		oTWIBrowseWahTo.Where.Condition = ["AND (TCNMWaHouse.FTWahStaType = '1' OR TCNMWaHouse.FTWahStaType = '2') "];
		// 		/* Control Browse โอนจากคลัง */
		// 	}
		// });
		// /*Controle Browse สาขา*/


		// /*Controle Browse Merchant*/
		// $('#oetMerCode').on('change', function (e) {

		// 	if($('#oetMerCode').val() == ''){
		// 		/* Control Browse ร้านค้า */
		// 		//จาก
		// 		$('#oetShpCode').val('');
		// 		$('#oetShpName').val('');
		// 		$('#obtTXIBrowseShp').attr('disabled',true);
		// 		//ถึง
		// 		$('#oetShpCodeTo').val('');
		// 		$('#oetShpNameTo').val('');
		// 		$('#obtTXIBrowseShpTo').attr('disabled',true);
		// 		/* Control Browse ร้านค้า */

		// 		/* Control Browse เดรื่องจุดขาย */
		// 		//จาก
		// 		$('#oetPosCodeFrom').val('');
		// 		$('#oetPosNameFrom').val('');
		// 		$('#obtTXIBrowsePosFrom').attr('disabled',true);
		// 		//ถึง
		// 		$('#oetPosCodeTo').val('');
		// 		$('#oetPosNameTo').val('');
		// 		$('#obtTXIBrowsePosTo').attr('disabled',true);
		// 		/* Control Browse เดรื่องจุดขาย */

		// 		/* Control Browse โอนจากคลัง */
		// 		//จาก
		// 		$('#ohdWahCodeFrom').val('');
		// 		$('#oetWahNameFrom').val('');
		// 		$('#obtTXIBrowseWahFrom').attr('disabled',false);
		// 		//ถึง
		// 		$('#ohdWahCodeTo').val('');
		// 		$('#oetWahNameTo').val('');
		// 		$('#obtTXIBrowseWahTo').attr('disabled',false);
		// 		/* Control Browse โอนจากคลัง */
		// 	}else{

		// 		/* Control Browse ร้านค้า */
		// 		var tBchCode = $("#oetBchCode").val();
		// 		var tMerCode = $("#oetMerCode").val();
		// 		//จาก
		// 		$('#obtTXIBrowseShp').attr('disabled',false);
		// 		oTWIBrowseShp.Where.Condition = ["AND TCNMShop.FTBchCode = '"+tBchCode+"' AND TCNMShop.FTMerCode = '"+tMerCode+"' "];

		// 		// console.log(oTWIBrowseShp.Where.Condition);
		// 		//ถึง
		// 		$('#obtTXIBrowseShpTo').attr('disabled',false);
		// 		oTWIBrowseShpTo.Where.Condition = ["AND TCNMShop.FTBchCode = '"+tBchCode+"' AND TCNMShop.FTMerCode = '"+tMerCode+"' "];
		// 		/* Control Browse ร้านค้า */
		// 	}
		// });
		// /*Controle Browse Merchant*/


		// /*Controle Browse ร้านค้า*/
		// $('#oetShpCode').on('change', function (e) {
		// 	if($('#oetShpCode').val() == ''){
		// 		// Control Browse ร้านค้า
		// 		$('#ohdWahCodeFrom').val('');
		// 		$('#oetWahNameFrom').val('');
		// 		$('#obtTXIBrowseWahFrom').attr('disabled',false);

		// 		$('#oetPosCodeFrom').val('');
		// 		$('#oetPosNameFrom').val('');
		// 		$('#obtTXIBrowsePosFrom').attr('disabled',true);

		// 		oTWIBrowseWahFrom.Where.Condition = ["AND (TCNMWaHouse.FTWahStaType = '1' OR TCNMWaHouse.FTWahStaType = '2') "];
		// 	}else{
		// 		// Control Browse ร้านค้า FTWahStaType = 4 คลังฝากขาย/ร้านค้า
		// 		$('#obtTXIBrowseWahFrom').attr('disabled',false);
		// 		var tShpCode = $("#oetShpCode").val();
		// 		oTWIBrowseWahFrom.Where.Condition = ["AND TCNMWaHouse.FTWahStaType = '4' AND TCNMWaHouse.FTWahRefCode = '"+tShpCode+"' "];
		// 	}
		// });
		// /*Controle Browse ร้านค้า*/


		// /*Controle Browse ร้านค้าถึง*/
		// $('#oetShpCodeTo').on('change', function (e) {
		// 	if($('#oetShpCodeTo').val() == ''){
		// 		// Control Browse ร้านค้า
		// 		$('#ohdWahCodeTo').val('');
		// 		$('#oetWahNameTo').val('');
		// 		$('#obtTXIBrowseWahTo').attr('disabled',false);

		// 		$('#oetPosCodeTo').val('');
		// 		$('#oetPosNameTo').val('');
		// 		$('#obtTXIBrowsePosTo').attr('disabled',true);

		// 		oTWIBrowseWahTo.Where.Condition =  ["AND (TCNMWaHouse.FTWahStaType = '1' OR TCNMWaHouse.FTWahStaType = '2') "];
		// 	}else{
		// 		// Control Browse ร้านค้า
		// 		$('#obtTXIBrowseWahTo').attr('disabled',false);
		// 		var tShpCodeTo = $("#oetShpCodeTo").val();
		// 		oTWIBrowseWahTo.Where.Condition = ["AND TCNMWaHouse.FTWahStaType = '4' AND TCNMWaHouse.FTWahRefCode = '"+tShpCodeTo+"' "];
		// 	}
		// });
		// /*Controle Browse ร้านค้าถึง*/


		// /*Controle Browse PosFrom*/
		// $('#oetPosCodeFrom').on('change', function (e) {
		// 	if($('#oetPosCodeFrom').val() == ''){
		// 		// Control Browse ร้านค้า
		// 		$('#ohdWahCodeFrom').val('');
		// 		$('#oetWahNameFrom').val('');
		// 		$('#obtTXIBrowseWahFrom').attr('disabled',false);

		// 		var tShpCode = $("#oetShpCode").val();
		// 		oTWIBrowseWahFrom.Where.Condition = ["AND TCNMWaHouse.FTWahRefCode = '"+tShpCode+"' "];
		// 	}else{
		// 		$('#obtTXIBrowseWahFrom').attr('disabled',false);
		// 		var tPosCodeFrom = $("#oetPosCodeFrom").val();
		// 		oTWIBrowseWahFrom.Where.Condition = ["AND TCNMWaHouse.FTWahStaType = '6' AND TCNMWaHouse.FTWahRefCode = '"+tPosCodeFrom+"' "];

		// 		var tPosCodeTo = $("#oetPosCodeTo").val();
		// 		if(tPosCodeFrom == tPosCodeTo){
		// 			$("#oetPosCodeTo").val('');
		// 			$("#oetPosNameTo").val('');

		// 			$("#ohdWahCodeTo").val('');
		// 			$("#oetWahNameTo").val('');
		// 		}
		// 	}
		// });
		// /*Controle Browse PosFrom*/

		// /*Controle Browse WahFrom*/
		// $('#ohdWahCodeFrom').on('change', function (e) {

		// 	$('#ohdWahCodeTo').val('');
		// 	$('#oetWahNameTo').val('');

		// 	tWahCodeFrom = $('#ohdWahCodeFrom').val();
		// 	if(tWahCodeFrom != ""){
		// 		oTWIBrowseWahTo.Where.Condition = ["AND (TCNMWaHouse.FTWahStaType = '1' OR TCNMWaHouse.FTWahStaType = '2') AND TCNMWaHouse.FTWahCode NOT IN ('"+tWahCodeFrom+"') "];
		// 	}else{
		// 		oTWIBrowseWahTo.Where.Condition = ["AND (TCNMWaHouse.FTWahStaType = '1' OR TCNMWaHouse.FTWahStaType = '2')"];
		// 	}

		// });
		// /*Controle Browse WahFrom*/


	});

	/* Disabled Enter in Form */
	$(document).keypress(
		function(event) {
			if (event.which == '13') {
				event.preventDefault();
			}
		}
	);



	//Set Option Browse -----------
	//Option Branch
	var oPmhBrowseBch = {

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
			OrderBy: ['TCNMBranch_L.FTBchName'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetBchCode", "TCNMBranch.FTBchCode"],
			Text: ["oetBchName", "TCNMBranch_L.FTBchName"],
		},

		RouteFrom: 'promotion',
		RouteAddNew: 'branch',
		BrowseLev: nStaTXIBrowseType
	}
	//Option Branch

	//Option Merchant
	var oTWIBrowseMer = {

		Title: ['company/branch/branch', 'tBCHTitle'],
		Table: {
			Master: 'TCNMMerchant',
			PK: 'FTMerCode'
		},
		Join: {
			Table: ['TCNMMerchant_L'],
			On: ['TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits, ]
		},
		GrideView: {
			ColumnPathLang: 'company/branch/branch',
			ColumnKeyLang: ['tBCHCode', 'tBCHName'],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
			DataColumnsFormat: ['', ''],
			Perpage: 5,
			OrderBy: ['TCNMMerchant_L.FTMerName'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetMerCode", "TCNMMerchant.FTMerCode"],
			Text: ["oetMerName", "TCNMMerchant_L.FTMerName"],
		},
		BrowseLev: 1
	}
	//Option Merchant

	//Option Shop From
	var oTWIBrowseShp = {

		Title: ['company/shop/shop', 'tSHPTitle'],
		Table: {
			Master: 'TCNMShop',
			PK: 'FTShpCode'
		},
		Join: {
			Table: ['TCNMShop_L', 'TCNMWaHouse', 'TCNMWaHouse_L'],
			On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
				"TCNMShop.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMShop.FTShpCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTWahStaType = '4' ",
				'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
			]
		},
		Where: {
			Condition: ["AND 1=1"]
		},
		GrideView: {
			ColumnPathLang: 'company/shop/shop',
			ColumnKeyLang: ['tSHPTBCode', 'tSHPTBName', 'tShopType'],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTShpType', 'TCNMShop.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
			DataColumnsFormat: ['', '', '', '', ''],
			DisabledColumns: [3, 4],
			Perpage: 5,
			OrderBy: ['TCNMShop_L.FTShpName'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetShpCode", "TCNMShop.FTShpCode"],
			Text: ["oetShpName", "TCNMShop_L.FTShpName"],
		},
		NextFunc: {
			FuncName: 'JSxTWIGetWahFormShopFrom',
			ArgReturn: ['FTWahCode', 'FTWahName', 'FTShpType']
		},
		RouteAddNew: 'shop',
		BrowseLev: 1,
		DebugSQL: 1,

	}
	//Option Shop From

	//Option Shop To
	var oTWIBrowseShpTo = {

		Title: ['company/shop/shop', 'tSHPTitle'],
		Table: {
			Master: 'TCNMShop',
			PK: 'FTShpCode'
		},
		Join: {
			Table: ['TCNMShop_L', 'TCNMWaHouse', 'TCNMWaHouse_L'],
			On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
				"TCNMShop.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMShop.FTShpCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTWahStaType = '4' ",
				'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
			]
		},
		Where: {
			Condition: ["AND 1=1"]
		},
		// Filter:{
		// 	Selector	:'oetBchCode',
		// 	Table		:'TCNMShop',
		// 	Key			:'FTBchCode'
		// },
		GrideView: {
			ColumnPathLang: 'company/shop/shop',
			ColumnKeyLang: ['tSHPTBCode', 'tSHPTBName'],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTShpType', 'TCNMShop.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
			DataColumnsFormat: ['', '', '', '', ''],
			DisabledColumns: [3, 4],
			Perpage: 5,
			OrderBy: ['TCNMShop_L.FTShpName'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetShpCodeTo", "TCNMShop.FTShpCode"],
			Text: ["oetShpNameTo", "TCNMShop_L.FTShpName"],
		},
		NextFunc: {
			FuncName: 'JSxTWIGetWahFormShopTo',
			ArgReturn: ['FTWahCode', 'FTWahName', 'FTShpType']
		},
		RouteAddNew: 'shop',
		BrowseLev: 1,
		DebugSQL: 1,

	}
	//Option Shop To

	//Option Pos From
	var oTWIBrowsePosFrom = {

		Title: ['company/shop/shop', 'tSHPTitle'],
		Table: {
			Master: 'TVDMPosShop',
			PK: 'FTPosCode'
		},
		Join: {
			Table: ['TCNMWaHouse', 'TCNMWaHouse_L'],
			On: ['TCNMWaHouse.FTWahRefCode = TVDMPosShop.FTPosCode',
				'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
			]
		},
		Where: {
			Condition: ["AND 1=1"]
		},
		GrideView: {
			ColumnPathLang: 'company/shop/shop',
			ColumnKeyLang: ['tSHPTBCode', 'tSHPTBName', 'tWahCode', 'tWahName'],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TVDMPosShop.FTPosCode', 'TVDMPosShop.FTShpCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
			DataColumnsFormat: ['', ''],
			DisabledColumns: [2, 3],
			Perpage: 5,
			OrderBy: ['TVDMPosShop.FTPosCode'],
			SourceOrder: "ASC"
		},
		NextFunc: {
			FuncName: 'JSxTWIGetWahFormPosFrom',
			ArgReturn: ['FTWahCode', 'FTWahName']
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetPosCodeFrom", "TVDMPosShop.FTPosCode"],
			Text: ["oetPosNameFrom", "TVDMPosShop.FTPosCode"],
		},
		RouteAddNew: 'pos',
		BrowseLev: 1,
		DebugSQL: 1,

	}
	//Option Pos From

	//Option Pos To
	var oTWIBrowsePosTo = {

		Title: ['company/shop/shop', 'tSHPTitle'],
		Table: {
			Master: 'TVDMPosShop',
			PK: 'FTPosCode'
		},
		Join: {
			Table: ['TCNMWaHouse', 'TCNMWaHouse_L'],
			On: ['TCNMWaHouse.FTWahRefCode = TVDMPosShop.FTPosCode',
				'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
			]
		},
		Where: {
			Condition: ["AND 1=1"]
		},
		GrideView: {
			ColumnPathLang: 'company/shop/shop',
			ColumnKeyLang: ['tSHPTBCode', 'tSHPTBName', 'tWahCode', 'tWahName'],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TVDMPosShop.FTPosCode', 'TVDMPosShop.FTShpCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
			DataColumnsFormat: ['', ''],
			DisabledColumns: [2, 3],
			Perpage: 5,
			OrderBy: ['TVDMPosShop.FTPosCode'],
			SourceOrder: "ASC"
		},
		NextFunc: {
			FuncName: 'JSxTWIGetWahFormPosTo',
			ArgReturn: ['FTWahCode', 'FTWahName']
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetPosCodeTo", "TVDMPosShop.FTPosCode"],
			Text: ["oetPosNameTo", "TVDMPosShop.FTPosCode"],
		},
		RouteAddNew: 'pos',
		BrowseLev: 1,
		DebugSQL: 1,

	}
	//Option Pos To

	//Option WareHouse From
	var oTWIBrowseWahFrom = {
		Title: ['company/warehouse/warehouse', 'tWAHTitle'],
		Table: {
			Master: 'TCNMWaHouse',
			PK: 'FTWahCode'
		},
		Join: {
			Table: ['TCNMWaHouse_L'],
			On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
		},
		Where: {
			Condition: ["AND TCNMWaHouse.FTWahStaType != '6' AND TCNMWaHouse.FTWahRefCode = '' "]
		},
		GrideView: {
			ColumnPathLang: 'company/warehouse/warehouse',
			ColumnKeyLang: ['tWahCode', 'tWahName'],
			DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
			DataColumnsFormat: ['', ''],
			ColumnsSize: ['15%', '75%'],
			Perpage: 5,
			WidthModal: 50,
			OrderBy: ['TCNMWaHouse_L.FTWahName'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["ohdWahCodeFrom", "TCNMWaHouse.FTWahCode"],
			Text: ["oetWahNameFrom", "TCNMWaHouse_L.FTWahName"],
		},
		RouteAddNew: 'warehouse',
		BrowseLev: nStaTXIBrowseType,
		DebugSQL: 1,
	}
	//Option WareHouse From

	//Option WareHouse To
	var oTWIBrowseWahTo = {
		Title: ['company/warehouse/warehouse', 'tWAHTitle'],
		Table: {
			Master: 'TCNMWaHouse',
			PK: 'FTWahCode'
		},
		Join: {
			Table: ['TCNMWaHouse_L'],
			On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
		},
		Where: {
			Condition: ["AND TCNMWaHouse.FTWahStaType != '6' AND TCNMWaHouse.FTWahRefCode = '' "]
		},
		GrideView: {
			ColumnPathLang: 'company/warehouse/warehouse',
			ColumnKeyLang: ['tWahCode', 'tWahName'],
			DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
			DataColumnsFormat: ['', ''],
			ColumnsSize: ['15%', '75%'],
			Perpage: 5,
			WidthModal: 50,
			OrderBy: ['TCNMWaHouse_L.FTWahName'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["ohdWahCodeTo", "TCNMWaHouse.FTWahCode"],
			Text: ["oetWahNameTo", "TCNMWaHouse_L.FTWahName"],
		},
		RouteAddNew: 'warehouse',
		BrowseLev: nStaTXIBrowseType,
		DebugSQL: 1,
	}
	//Option WareHouse To

	//Option WareHouse To
	var oTWIBrowseReason = {
		Title: ['company/warehouse/warehouse', 'tWAHTitle'],
		Table: {
			Master: 'TCNMRsn',
			PK: 'FTRsnCode'
		},
		Join: {
			Table: ['TCNMRsn_L'],
			On: ['TCNMRsn_L.FTRsnCode = TCNMRsn.FTRsnCode AND TCNMRsn_L.FNLngID = ' + nLangEdits, ]
		},
		GrideView: {
			ColumnPathLang: 'company/warehouse/warehouse',
			ColumnKeyLang: ['tWahCode', 'tWahName'],
			DataColumns: ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
			DataColumnsFormat: ['', ''],
			ColumnsSize: ['15%', '75%'],
			Perpage: 5,
			WidthModal: 50,
			OrderBy: ['TCNMRsn_L.FTRsnName'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetRsnCode", "TCNMRsn.FTRsnCode"],
			Text: ["oetRsnName", "TCNMRsn_L.FTRsnName"],
		},

		RouteAddNew: 'reason',
		BrowseLev: nStaTXIBrowseType
	}
	//Option WareHouse To

	//option Ship Address 
	var oTWIBrowseShipAdd = {
		Title: ['document/purchaseorder/purchaseorder', 'tBrowseADDTitle'],
		Table: {
			Master: 'TCNMAddress_L',
			PK: 'FNAddSeqNo'
		},
		Join: {
			Table: ['TCNMProvince_L', 'TCNMDistrict_L', 'TCNMSubDistrict_L'],
			On: ['TCNMProvince_L.FTPvnCode = TCNMAddress_L.FTAddV1PvnCode AND TCNMProvince_L.FNLngID = ' + nLangEdits,
				'TCNMDistrict_L.FTDstCode = TCNMAddress_L.FTAddV1DstCode AND TCNMDistrict_L.FNLngID= ' + nLangEdits,
				'TCNMSubDistrict_L.FTSudCode = TCNMAddress_L.FTAddV1SubDist AND TCNMSubDistrict_L.FNLngID= ' + nLangEdits
			]
		},
		Where: {
			// Condition : ['AND TCNMAddress_L.FNLngID='+nLangEdits, 'AND FTAddGrpType = 1']
			Condition: [
				function() {
					var tFilter = "";
					if ($("#oetBchCode").val() != "") {
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
								tFilter += "AND FTAddGrpType = 1 AND FTAddRefCode = '" + $("#oetBchCode").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
							}
						} else {
							// สาขา
							tFilter += "AND FTAddGrpType = 1 AND FTAddRefCode = '" + $("#oetBchCode").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
						}
					}
					return tFilter;
				}
			]
		},
		GrideView: {
			ColumnPathLang: 'document/purchaseorder/purchaseorder',
			ColumnKeyLang: ['tBrowseADDBch', 'tBrowseADDSeq', 'tBrowseADDV1No', 'tBrowseADDV1Soi', 'tBrowseADDV1Village', 'tBrowseADDV1Road', 'tBrowseADDV1SubDist', 'tBrowseADDV1DstCode', 'tBrowseADDV1PvnCode', 'tBrowseADDV1PostCode'],
			DataColumns: ['TCNMAddress_L.FTAddRefCode', 'TCNMAddress_L.FNAddSeqNo', 'TCNMAddress_L.FTAddV1No', 'TCNMAddress_L.FTAddV1Soi', 'TCNMAddress_L.FTAddV1Village', 'TCNMAddress_L.FTAddV1Road', 'TCNMSubDistrict_L.FTSudName', 'TCNMDistrict_L.FTDstName', 'TCNMProvince_L.FTPvnName', 'TCNMAddress_L.FTAddV1PostCode'],
			DataColumnsFormat: ['', '', '', '', '', '', '', '', '', ''],
			ColumnsSize: [''],
			Perpage: 10,
			WidthModal: 50,
			OrderBy: ['TCNMAddress_L.FTAddRefCode'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["ohdShipAddSeqNo", "TCNMAddress_L.FNAddSeqNo"],
			Text: ["ohdShipAddSeqNo", "TCNMAddress_L.FNAddSeqNo"],
		},
		NextFunc: {
			FuncName: 'JSxTXIAftSelectShipAddress',
			ArgReturn: ['FTAddRefCode', 'FNAddSeqNo']
		},
		BrowseLev: 1,
		DebugSQL: 1
	}
	//option Ship Address 

	//Option RefInt
	var oTWIBrowseRefInt = {

		Title: ['document/transferwarehouseout/transferwarehouseout', 'tTWOTitle'],
		Table: {
			Master: 'TCNTPdtTwoHD',
			PK: 'FTXthDocNo'
		},
		Join: {
			Table: ['TCNTPdtTwoHDRef', 'TCNMShipVia_L'],
			On: ['TCNTPdtTwoHD.FTXthDocNo = TCNTPdtTwoHDRef.FTXthDocNo',
				'TCNTPdtTwoHDRef.FTViaCode = TCNMShipVia_L.FTViaCode AND TCNMShipVia_L.FNLngID=' + nLangEdits,
			]
		},
		Where: {
			Condition: [
				function() {
					var tSQL = "";
					if ($("#ohdUserLoginBchCode").val() != "") {
						tSQL += " AND TCNTPdtTwoHD.FTBchCode= '" + $("#ohdUserLoginBchCode").val() + "' ";
					}

					if ($("#ohdUserLoginShpCode").val() != "") {
						tSQL += " AND TCNTPdtTwoHD.FTXthShopTo= '" + $("#ohdUserLoginShpCode").val() + "' ";
					}

					//สถานะ 0:ไม่เคยอ้างอิง
					tSQL += " AND TCNTPdtTwoHD.FNXthStaRef= '0' ";

					console.log('Browse RrfInt :' + tSQL)
					return tSQL;
				}
			]
		},
		GrideView: {
			ColumnPathLang: 'document/transferwarehouseout/transferwarehouseout',
			ColumnKeyLang: ['tTWOTBCode'],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TCNTPdtTwoHD.FTXthDocNo', 'TCNTPdtTwoHDRef.FTXthCtrName', 'TCNTPdtTwoHDRef.FDXthTnfDate', 'TCNTPdtTwoHDRef.FTXthRefTnfID', 'TCNTPdtTwoHDRef.FTXthRefVehID', 'TCNTPdtTwoHDRef.FTXthQtyAndTypeUnit', 'TCNTPdtTwoHDRef.FNXthShipAdd', 'TCNTPdtTwoHDRef.FTViaCode', 'TCNMShipVia_L.FTViaName'],
			DataColumnsFormat: ['', '', '', '', '', '', '', ''],
			DisabledColumns: [1, 2, 3, 4, 5, 6, 7, 8],
			Perpage: 5,
			OrderBy: ['TCNTPdtTwoHD.FTXthDocNo'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetXthRefInt", "TCNTPdtTwoHD.FTXthDocNo"],
			Text: ["oetXthRefIntName", "TCNTPdtTwoHD.FTXthDocNo"],
		},
		NextFunc: {
			FuncName: 'JSxTXIAftSelectRefInt',
			ArgReturn: ['FTXthDocNo', 'FTXthCtrName', 'FDXthTnfDate', 'FTXthRefTnfID', 'FTXthRefVehID', 'FTXthQtyAndTypeUnit', 'FNXthShipAdd', 'FTViaCode', 'FTViaName']
		},
		BrowseLev: 1,
		DebugSQL: 1
	}
	//Option RefInt 


	//Option ขนส่งโดย
	var oTWIBrowseVia = {

		Title: ['document/transferwarehouseout/transferwarehouseout', 'tTWOTitle'],
		Table: {
			Master: 'TCNMShipVia',
			PK: 'FTViaCode'
		},
		Join: {
			Table: ['TCNMShipVia_L'],
			On: ['TCNMShipVia.FTViaCode = TCNMShipVia_L.FTViaCode']
		},
		// Where: {
		// 	Condition: [

		// 	]
		// },
		GrideView: {
			ColumnPathLang: 'document/transferwarehouseout/transferwarehouseout',
			ColumnKeyLang: ['tTWOTBCode', 'tTWOTBName'],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TCNMShipVia.FTViaCode', 'TCNMShipVia_L.FTViaName'],
			DataColumnsFormat: ['', ''],
			// DisabledColumns: [1, 2, 3, 4, 5, 6, 7, 8],
			Perpage: 5,
			OrderBy: ['TCNMShipVia.FTViaCode'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["ohdViaCode", "TCNMShipVia.FTViaCode"],
			Text: ["oetViaName", "TCNMShipVia_L.FTViaName"],
		},
		BrowseLev: 1,
		DebugSQL: 1
	}
	//Option ขนส่งโดย 


	//Event Browse
	//$('#obtTXIBrowseBch').click(function(){ localStorage.GrpBothNumItem = ''; $('.modal').remove(); JCNxBrowseData('oPmhBrowseBch');});
	$('#obtTXIBrowseMer').click(function() {
		localStorage.GrpBothNumItem = '';
		$('.modal').remove();
		JCNxBrowseData('oTWIBrowseMer');
	});
	$('#obtTXIBrowseShp').click(function() {
		localStorage.GrpBothNumItem = '';
		$('.modal').remove();
		JCNxBrowseData('oTWIBrowseShp');
	});
	$('#obtTXIBrowseShpTo').click(function() {
		localStorage.GrpBothNumItem = '';
		$('.modal').remove();
		JCNxBrowseData('oTWIBrowseShpTo');
	});
	$('#obtTXIBrowsePosFrom').click(function() {
		localStorage.GrpBothNumItem = '';
		$('.modal').remove();
		JCNxBrowseData('oTWIBrowsePosFrom');
	});

	$('#obtTXIBrowsePosTo').click(function() {

		localStorage.GrpBothNumItem = '';
		$('.modal').remove();
		//Check  ถ้ามีค่า ค่า PosFrom  ใน PosTo จะไม่มีค่านั้นๆ
		tStagement = "";
		tBchCode = $('#oetBchCode').val();

		tPosFrom = $('#oetPosCodeFrom').val();
		if (tPosFrom != '') {
			tStagement += " AND TVDMPosShop.FTPosCode NOT IN ('" + tPosFrom + "')";
		}

		tShpCodeTo = $("#oetShpCodeTo").val();
		if (tShpCodeTo != "") {
			tStagement += " AND TVDMPosShop.FTShpCode = '" + tShpCodeTo + "'";
		}

		console.log(tStagement);
		oTWIBrowsePosTo.Where.Condition = [tStagement];
		JCNxBrowseData('oTWIBrowsePosTo');
	});

	$('#obtTXIBrowseWahFrom').click(function() {
		localStorage.GrpBothNumItem = '';
		$('.modal').remove();
		JCNxBrowseData('oTWIBrowseWahFrom');
	});

	//Event Browse อ้างอิงเหตุผล
	$('#obtTXIBrowseWahTo').click(function() {

		localStorage.GrpBothNumItem = '';
		$('.modal').remove();
		//Check  ถ้ามีค่า ค่า WahFrom  ใน WahTo จะไม่มีค่านั้นๆ
		tStagement = "";
		tBchCode = $('#oetBchCode').val();

		if (tBchCode != '') {
			tStagement += " AND (TCNMWaHouse.FTWahStaType = '1' OR TCNMWaHouse.FTWahStaType = '2')";
			oTWIBrowseWahTo.Where.Condition = [tStagement];
		}

		tShpCodeTo = $('#oetShpCodeTo').val();
		if (tShpCodeTo != '') {
			tStagement += " AND TCNMWaHouse.FTWahStaType = '4' AND TCNMWaHouse.FTWahRefCode = '" + tShpCodeTo + "' ";
			oTWIBrowseWahTo.Where.Condition = [tStagement];
		}

		tWahFrom = $('#ohdWahCodeFrom').val();
		if (tWahFrom != '') {
			tStagement += " AND TCNMWaHouse.FTWahCode NOT IN ('" + tWahFrom + "')";
			oTWIBrowseWahTo.Where.Condition = [tStagement];
		}

		JCNxBrowseData('oTWIBrowseWahTo');
	});

	//Event Browse อ้างอิงเหตุผล
	$('#obtTXIBrowseRsn').click(function() {
		localStorage.GrpBothNumItem = '';
		$('.modal').remove();
		JCNxBrowseData('oTWIBrowseReason');
	});

	//Event Browse ShipAdd
	$('#oliBtnEditShipAdd').click(function() {
		JCNxBrowseData('oTWIBrowseShipAdd');
	});

	//Event Browse เอกสารอ้างอิงภายใน
	$('#obtTXIBrowseRefInt').click(function() {
		JCNxBrowseData('oTWIBrowseRefInt');
	});

	//Event Browse ขนส่งโดย
	$('#obtTXIBrowseVia').click(function() {
		JCNxBrowseData('oTWIBrowseVia');
	});




	//สาขา
	$('#obtTXIBrowseBch').click(function() {

		$(".modal.fade:not(#odvTXIBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalError)").remove();

		//Lang Edit In Browse
		nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
		//Set Option Browse -----------
		//Option Branch
		oPmhBrowseBch = {
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
				DisabledColumns: [],
				Perpage: 5,
				OrderBy: ['TCNMBranch_L.FTBchName'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetBchCode", "TCNMBranch.FTBchCode"],
				Text: ["oetBchName", "TCNMBranch_L.FTBchName"],
			},
			NextFunc: {
				FuncName: 'JSxTXISetSeqConditionBch',
				ArgReturn: ['FTBchCode', 'FTBchName']
			},
			RouteFrom: 'promotion',
			RouteAddNew: 'branch',
			BrowseLev: 2
		}
		JCNxBrowseData('oPmhBrowseBch');

	});

	//กลุ่มร้านค้า
	$('#obtTXIBrowseMch').click(function() {

		$(".modal.fade:not(#odvTXIBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalError)").remove();

		oTXIBrowseMch = {
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
				FuncName: 'JSxTXISetSeqConditionMerChant',
				ArgReturn: ['FTMerCode', 'FTMerName']
			},
			BrowseLev: 1
		};
		//Option merchant
		JCNxBrowseData('oTXIBrowseMch');
	});

	//ร้านเริ่ม
	$('#obtTXIBrowseShpStart').click(function() {
		$(".modal.fade:not(#odvTXIBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalError)").remove();
		//Option Shop  Start
		oTXIBrowseShpStart = {
			Title: ['company/shop/shop', 'tSHPTitle'],
			Table: {
				Master: 'TCNMShop',
				PK: 'FTShpCode'
			},
			Join: {
				Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
				On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
					'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = "AND TCNMShop.FTBchCode = '" + $("#oetBchCode").val() + "' AND TCNMShop.FTMerCode = '" + $("#oetMchCode").val() + "'";
						if ($("#oetShpCodeEnd").val() != "" && $("#ohdWahCodeEnd").val() != "") {
							if ($($($($("#obtTXIBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) {
								if ($($($($("#obtTXIBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")) {
									tSQL += " AND TCNMShop.FTShpCode != '" + $("#oetShpCodeEnd").val() + "'";
								} else {
									if ($("#oetShpCodeStart").val() != "") {
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
				Perpage: 5,
				OrderBy: ['TCNMShop_L.FTShpName'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetShpCodeStart", "TCNMShop.FTShpCode"],
				Text: ["oetShpNameStart", "TCNMShop_L.FTShpName"],
			},
			NextFunc: {
				FuncName: 'JSxTXISetSeqConditionShpStart',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1

		}
		//Option Shop Start
		JCNxBrowseData('oTXIBrowseShpStart');
	});

	//เครื่องจุดขายเริ่ม
	$('#obtTXIBrowsePosStart').click(function() {
		$(".modal.fade:not(#odvTXIBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalError)").remove();
		//Option Shop  Start
		oTXIBrowsePosStart = {
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
						var tSQL = "AND TVDMPosShop.FTShpCode = '" + $("#oetShpCodeStart").val() + "' AND TVDMPosShop.FTBchCode = '" + $("#oetBchCode").val() + "'";
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
				DisabledColumns: [2, 3, 4, 5],
				Perpage: 5,
				OrderBy: ['TVDMPosShop.FTPosCode'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetPosCodeStart", "TVDMPosShop.FTPosCode"],
				Text: ["oetPosNameStart", "TCNMPosLastNo.FTPosComName"],
			},
			NextFunc: {
				FuncName: 'JSxTXISetSeqConditionPosStart',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1

		}
		//Option Shop Start
		JCNxBrowseData('oTXIBrowsePosStart');
	});


	//คลังเริ่ม
	$('#obtTXIBrowseWahStart').click(function() {
		$(".modal.fade:not(#odvTXIBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalError)").remove();
		if ($("#oetBchCode").val() != "" &&
			$("#oetShpCodeStart").val() == "" &&
			$("#oetPosCodeStart").val() == "") {
			//Option WareHouse From
			obtTXIBrowseWahStart = {
				Title: ['company/warehouse/warehouse', 'tWAHTitle'],
				Table: {
					Master: 'TCNMWaHouse',
					PK: 'FTWahCode'
				},
				Join: {
					Table: ['TCNMWaHouse_L'],
					On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
				},
				Where: {
					Condition: [
						function() {
							var tSQL = "AND TCNMWaHouse.FTWahStaType IN (1,2)";
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
					Perpage: 5,
					WidthModal: 50,
					OrderBy: ['TCNMWaHouse_L.FTWahName'],
					SourceOrder: "ASC"
				},
				CallBack: {
					ReturnType: 'S',
					Value: ["ohdWahCodeStart", "TCNMWaHouse.FTWahCode"],
					Text: ["oetWahNameStart", "TCNMWaHouse_L.FTWahName"],
				},
				NextFunc: {
					FuncName: 'JSxTXISetSeqConditionWahStart',
					ArgReturn: []
				},
				RouteAddNew: 'warehouse',
				BrowseLev: nStaTXIBrowseType
			}
		} else if ($("#oetBchCode").val() != "" &&
			$("#oetShpCodeStart").val() != "" &&
			$("#oetPosCodeStart").val() == "") {
			//Option WareHouse From
			obtTXIBrowseWahStart = {
				Title: ['company/warehouse/warehouse', 'tWAHTitle'],
				Table: {
					Master: 'TCNMWaHouse',
					PK: 'FTWahCode'
				},
				Join: {
					Table: ['TCNMWaHouse_L', 'TCNMShop'],
					On: [
						"TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID = " + nLangEdits,
						"TCNMWaHouse.FTWahCode = TCNMShop.FTWahCode AND TCNMShop.FTBchCode = '" + $("#oetBchCode").val() + "' AND TCNMShop.FTShpCode = '" + $("#oetShpCodeStart").val() + "'"
					]
				},
				Where: {
					Condition: [
						function() {
							var tSQL = "AND (TCNMShop.FTBchCode != '' AND TCNMShop.FTShpCode != '') AND (TCNMShop.FTBchCode IS NOT NULL AND TCNMShop.FTShpCode IS NOT NULL)";
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
					Perpage: 5,
					WidthModal: 50,
					OrderBy: ['TCNMWaHouse.FTWahCode'],
					SourceOrder: "ASC"
				},
				CallBack: {
					ReturnType: 'S',
					Value: ["ohdWahCodeStart", "TCNMWaHouse.FTWahCode"],
					Text: ["oetWahNameStart", "TCNMWaHouse_L.FTWahName"],
				},
				NextFunc: {
					FuncName: 'JSxTXISetSeqConditionWahStart',
					ArgReturn: []
				},
				RouteAddNew: 'warehouse',
				BrowseLev: nStaTXIBrowseType
			}
		}
		//Option WareHouse From 
		JCNxBrowseData('obtTXIBrowseWahStart');
	});


	//ร้านจบ
	$('#obtTXIBrowseShpEnd').click(function() {
		$(".modal.fade:not(#odvTXIBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalError)").remove();
		//Option Shop  Start
		oTXIBrowseShpEnd = {
			Title: ['company/shop/shop', 'tSHPTitle'],
			Table: {
				Master: 'TCNMShop',
				PK: 'FTShpCode'
			},
			Join: {
				Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
				On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
					'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = "AND TCNMShop.FTBchCode = '" + $("#oetBchCode").val() + "' AND TCNMShop.FTMerCode = '" + $("#oetMchCode").val() + "'";
						if ($("#oetShpCodeStart").val() != "" && $("#ohdWahCodeStart").val() != "") {
							if ($($($($("#obtTXIBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")) {
								if ($($($($("#obtTXIBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) {
									if ($("#ohdWahCodeEnd").val() != "") {
										tSQL += " AND TCNMShop.FTShpCode != '" + $("#oetShpCodeStart").val() + "'";
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
				Perpage: 5,
				OrderBy: ['TCNMShop_L.FTShpName'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetShpCodeEnd", "TCNMShop.FTShpCode"],
				Text: ["oetShpNameEnd", "TCNMShop_L.FTShpName"],
			},
			NextFunc: {
				FuncName: 'JSxTXISetSeqConditionShpEnd',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1,
			DebugSQL: 1
		}
		//Option Shop Start
		JCNxBrowseData('oTXIBrowseShpEnd');
	});

	//เครื่องจุดขายจบ
	$('#obtTXIBrowsePosEnd').click(function() {
		$(".modal.fade:not(#odvTXIBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalError)").remove();
		//Option Shop  Start
		oTXIBrowsePosEnd = {
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
						var tSQL = "AND TVDMPosShop.FTShpCode = '" + $("#oetShpCodeEnd").val() + "' AND TVDMPosShop.FTBchCode = '" + $("#oetBchCode").val() + "'";
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
				DisabledColumns: [2, 3, 4, 5],
				Perpage: 5,
				OrderBy: ['TVDMPosShop.FTPosCode'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetPosCodeEnd", "TVDMPosShop.FTPosCode"],
				Text: ["oetPosNameEnd", "TCNMPosLastNo.FTPosComName"],
			},
			NextFunc: {
				FuncName: 'JSxTXISetSeqConditionPosEnd',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1

		}
		//Option Shop 
		JCNxBrowseData('oTXIBrowsePosEnd');
	});

	//คลังจบ
	$('#obtTXIBrowseWahEnd').click(function() {
		$(".modal.fade:not(#odvTXIBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalError)").remove();
		if ($("#oetBchCode").val() != "" &&
			$("#oetShpCodeEnd").val() == "" &&
			$("#oetPosCodeEnd").val() == "") {
			//Option WareHouse From
			obtTXIBrowseWahEnd = {
				Title: ['company/warehouse/warehouse', 'tWAHTitle'],
				Table: {
					Master: 'TCNMWaHouse',
					PK: 'FTWahCode'
				},
				Join: {
					Table: ['TCNMWaHouse_L'],
					On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
				},
				Where: {
					Condition: [
						function() {
							var tSQL = "AND TCNMWaHouse.FTWahStaType IN (1,2)";
							if ($("#ohdWahCodeStart").val() != "") {
								tSQL += " AND TCNMWaHouse.FTWahCode NOT IN ('" + $("#ohdWahCodeStart").val() + "')";
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
					Perpage: 5,
					WidthModal: 50,
					OrderBy: ['TCNMWaHouse_L.FTWahName'],
					SourceOrder: "ASC"
				},
				CallBack: {
					ReturnType: 'S',
					Value: ["ohdWahCodeEnd", "TCNMWaHouse.FTWahCode"],
					Text: ["oetWahNameEnd", "TCNMWaHouse_L.FTWahName"],
				},
				NextFunc: {
					FuncName: 'JSxTXISetSeqConditionWahEnd',
					ArgReturn: []
				},
				RouteAddNew: 'warehouse',
				BrowseLev: nStaTXIBrowseType
			}
		} else if ($("#oetBchCode").val() != "" &&
			$("#oetShpCodeEnd").val() != "" &&
			$("#oetPosCodeEnd").val() == "") {
			//Option WareHouse From
			obtTXIBrowseWahEnd = {
				Title: ['company/warehouse/warehouse', 'tWAHTitle'],
				Table: {
					Master: 'TCNMWaHouse',
					PK: 'FTWahCode'
				},
				Join: {
					Table: ['TCNMWaHouse_L', 'TCNMShop'],
					On: [
						"TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID = " + nLangEdits,
						"TCNMWaHouse.FTWahCode = TCNMShop.FTWahCode AND TCNMShop.FTBchCode = '" + $("#oetBchCode").val() + "' AND TCNMShop.FTShpCode = '" + $("#oetShpCodeEnd").val() + "'"
					]
				},
				Where: {
					Condition: [
						function() {
							var tSQL = "AND (TCNMShop.FTBchCode != '' AND TCNMShop.FTShpCode != '') AND (TCNMShop.FTBchCode IS NOT NULL AND TCNMShop.FTShpCode IS NOT NULL)";
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
					Perpage: 5,
					WidthModal: 50,
					OrderBy: ['TCNMWaHouse.FTWahCode'],
					SourceOrder: "ASC"
				},
				CallBack: {
					ReturnType: 'S',
					Value: ["ohdWahCodeEnd", "TCNMWaHouse.FTWahCode"],
					Text: ["oetWahNameEnd", "TCNMWaHouse_L.FTWahName"],
				},
				NextFunc: {
					FuncName: 'JSxTXISetSeqConditionWahEnd',
					ArgReturn: []
				},
				RouteAddNew: 'warehouse',
				BrowseLev: nStaTXIBrowseType
			}
		}
		//Option WareHouse From 
		JCNxBrowseData('obtTXIBrowseWahEnd');
	});


	//สาขา
	function JSxTXISetSeqConditionBch(poJsonData) {

		if (poJsonData != "NULL") {
			aData = JSON.parse(poJsonData);
			tOldBchCode = $("#oetBchCode").data("oldval");
			tNewBchCode = aData[0];
			console.log(tOldBchCode + "::" + tNewBchCode);

			if (tOldBchCode != tNewBchCode) {

				//Set ค่าใหม่แทนที่ค่าเก่า ใน Iput
				$("#oetBchCode").data("oldval", tNewBchCode);
				console.log('=> function ClearDTTemp');

				JSxTXIControlBch();

			} else {
				console.log('Branch Not Change');
			}

		} else {

			if ($("#oetBchCode").data("oldval") != "") {
				$("#oetBchCode").data("oldval", "");
				JSxTXIControlBch();
			}
			console.log("NULL");
		}

	}

	function JSxTXIControlBch() {

		// ร้านค้า
		$("#oetShpCodeStart").val("");
		$("#oetShpNameStart").val("");
		$($("#obtTXIBrowseShpStart").parent()).addClass("disabled");
		$($("#obtTXIBrowseShpStart").parent()).attr("disabled", "disabled");
		$("#obtTXIBrowseShpStart").addClass("disabled");
		$("#obtTXIBrowseShpStart").attr("disabled", "disabled");

		$("#oetShpCodeEnd").val("");
		$("#oetShpNameEnd").val("");
		$($("#obtTXIBrowseShpEnd").parent()).addClass("disabled");
		$($("#obtTXIBrowseShpEnd").parent()).attr("disabled", "disabled");
		$("#obtTXIBrowseShpEnd").addClass("disabled");
		$("#obtTXIBrowseShpEnd").attr("disabled", "disabled");
		//เครื่องจุดขาย
		$("#oetPosCodeStart").val("");
		$("#oetPosNameStart").val("");
		$($($($("#obtTXIBrowsePosStart").parent()).parent()).parent()).addClass("xCNHide");
		$($("#obtTXIBrowsePosStart").parent()).addClass("disabled");
		$($("#obtTXIBrowsePosStart").parent()).attr("disabled", "disabled");
		$("#obtTXIBrowsePosStart").addClass("disabled");
		$("#obtTXIBrowsePosStart").attr("disabled", "disabled");

		$("#oetPosCodeEnd").val("");
		$("#oetPosNameEnd").val("");
		$($($($("#obtTXIBrowsePosEnd").parent()).parent()).parent()).addClass("xCNHide");
		$($("#obtTXIBrowsePosEnd").parent()).addClass("disabled");
		$($("#obtTXIBrowsePosEnd").parent()).attr("disabled", "disabled");
		$("#obtTXIBrowsePosEnd").addClass("disabled");
		$("#obtTXIBrowsePosEnd").attr("disabled", "disabled");

		$("#oetMchCode").val("");
		$("#oetMchName").val("");
		$("#ohdWahCodeStart").val("");
		$("#oetWahNameStart").val("");
		$("#ohdWahCodeEnd").val("");
		$("#oetWahNameEnd").val("");



		if ($("#oetBchCode").val() != "") {

			//กลุ่มร้านค้า
			$($("#obtTXIBrowseMch").parent()).removeClass("disabled");
			$($("#obtTXIBrowseMch").parent()).removeAttr("disabled");
			$("#obtTXIBrowseMch").removeClass("disabled");
			$("#obtTXIBrowseMch").removeAttr("disabled");

			//คลังสินค้า
			$($("#obtTXIBrowseWahStart").parent()).removeClass("disabled");
			$($("#obtTXIBrowseWahStart").parent()).removeAttr("disabled", "disabled");
			$("#obtTXIBrowseWahStart").removeClass("disabled");
			$("#obtTXIBrowseWahStart").removeAttr("disabled", "disabled");

			$($("#obtTXIBrowseWahEnd").parent()).removeClass("disabled");
			$($("#obtTXIBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
			$("#obtTXIBrowseWahEnd").removeClass("disabled");
			$("#obtTXIBrowseWahEnd").removeAttr("disabled", "disabled");

		} else {

			//กลุ่มร้านค้า
			$($("#obtTXIBrowseMch").parent()).addClass("disabled");
			$($("#obtTXIBrowseMch").parent()).attr("disabled");
			$("#obtTXIBrowseMch").addClass("disabled");
			$("#obtTXIBrowseMch").attr("disabled");

			//คลังสินค้า
			$($("#obtTXIBrowseWahStart").parent()).addClass("disabled");
			$($("#obtTXIBrowseWahStart").parent()).attr("disabled", "disabled");
			$("#obtTXIBrowseWahStart").addClass("disabled");
			$("#obtTXIBrowseWahStart").attr("disabled", "disabled");

			$($("#obtTXIBrowseWahEnd").parent()).addClass("disabled");
			$($("#obtTXIBrowseWahEnd").parent()).attr("disabled", "disabled");
			$("#obtTXIBrowseWahEnd").addClass("disabled");
			$("#obtTXIBrowseWahEnd").attr("disabled", "disabled");

		}

		if ($("#oetBchCode").val() != "" ||
			$("#oetMchCode").val() != "" ||
			$("#oetShpCodeEnd").val() != "" ||
			$("#oetPosCodeEnd").val() != "") {
			$("#obtTXIBrowseShipAdd").removeAttr("disabled");
		} else {
			$("#obtTXIBrowseShipAdd").attr("disabled", "disabled");
		}

		//Check ที่อยู่ ว่ามีค่าหรือไม่ถ้ามีจะทำการ Clear ค่าเก่า
		var tMsg = "";
		var tMsgAddress = "";
		var tMsgPdt = "";
		if ($('#ohdXthShipAdd').val() != 0) {
			$('#ohdXthShipAdd').val("");
			tMsgAddress = "<p>ข้อมูลที่อยู่สำหรับจัดส่งเดิมจะถูกเคลียร์ โปรดทำการระบุข้อมูลที่อยู่สำหรับจัดส่งใหม่</p>";
		}
		if ($('.xWPdtItem').length > 0) {
			tMsgPdt = "<p>ข้อมูลสินค้าเดิมจะถูกเคลียร์ โปรดทำการระบุสินค้าใหม่</p>";
			JSxTXIClearDTTemp();
		}
		tMsg += tMsgAddress + tMsgPdt;
		if (tMsg != "") {
			FSvCMNSetMsgWarningDialog(tMsg);
		}
		//Check ที่อยู่ ว่ามีค่าหรือไม่ถ้ามีจะทำการ Clear ค่าเก่า

	}

	//กลุ่มร้านค้า
	function JSxTXISetSeqConditionMerChant(poJsonData) {


		if (poJsonData != "NULL") {
			aData = JSON.parse(poJsonData);
			tOldMchCode = $("#oetMchCode").data("oldval");
			tNewMchCode = aData[0];
			console.log(tOldMchCode + "::" + tNewMchCode);

			if (tOldMchCode != tNewMchCode) {

				//Set ค่าใหม่แทนที่ค่าเก่า ใน Iput
				$("#oetMchCode").data("oldval", tNewMchCode);
				console.log('=> function ClearDTTemp');

				JSxTXIControlMer();

			} else {
				console.log('Merchant Not Change');
			}

		} else {

			if ($("#oetMchCode").data("oldval") != "") {
				$("#oetMchCode").data("oldval", "");
				JSxTXIControlMer();
			}
			console.log("NULL");
		}


	}


	function JSxTXIControlMer() {

		/*Clone มาจาก ภาพ */
		//เครื่องจุดขาย
		$($($($("#obtTXIBrowsePosStart").parent()).parent()).parent()).addClass("xCNHide");
		$($("#obtTXIBrowsePosStart").parent()).addClass("disabled");
		$($("#obtTXIBrowsePosStart").parent()).attr("disabled", "disabled");
		$("#obtTXIBrowsePosStart").addClass("disabled");
		$("#obtTXIBrowsePosStart").attr("disabled", "disabled");

		$($($($("#obtTXIBrowsePosEnd").parent()).parent()).parent()).addClass("xCNHide");
		$($("#obtTXIBrowsePosEnd").parent()).addClass("disabled");
		$($("#obtTXIBrowsePosEnd").parent()).attr("disabled", "disabled");
		$("#obtTXIBrowsePosEnd").addClass("disabled");
		$("#obtTXIBrowsePosEnd").attr("disabled", "disabled");

		if ($("#oetMchCode").val() != "") {

			//คลังสินค้า
			$($("#obtTXIBrowseWahStart").parent()).removeClass("disabled");
			$($("#obtTXIBrowseWahStart").parent()).removeAttr("disabled", "disabled");
			$("#obtTXIBrowseWahStart").removeClass("disabled");
			$("#obtTXIBrowseWahStart").removeAttr("disabled", "disabled");

			$($("#obtTXIBrowseWahEnd").parent()).removeClass("disabled");
			$($("#obtTXIBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
			$("#obtTXIBrowseWahEnd").removeClass("disabled");
			$("#obtTXIBrowseWahEnd").removeAttr("disabled", "disabled");

			// ร้านค้า
			$($("#obtTXIBrowseShpStart").parent()).removeClass("disabled");
			$($("#obtTXIBrowseShpStart").parent()).removeAttr("disabled");
			$("#obtTXIBrowseShpStart").removeClass("disabled");
			$("#obtTXIBrowseShpStart").removeAttr("disabled");

			$($("#obtTXIBrowseShpEnd").parent()).removeClass("disabled");
			$($("#obtTXIBrowseShpEnd").parent()).removeAttr("disabled");
			$("#obtTXIBrowseShpEnd").removeClass("disabled");
			$("#obtTXIBrowseShpEnd").removeAttr("disabled");

		} else {

			//คลังสินค้า
			$($("#obtTXIBrowseWahStart").parent()).removeClass("disabled");
			$($("#obtTXIBrowseWahStart").parent()).removeAttr("disabled", "disabled");
			$("#obtTXIBrowseWahStart").removeClass("disabled");
			$("#obtTXIBrowseWahStart").removeAttr("disabled", "disabled");

			$($("#obtTXIBrowseWahEnd").parent()).removeClass("disabled");
			$($("#obtTXIBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
			$("#obtTXIBrowseWahEnd").removeClass("disabled");
			$("#obtTXIBrowseWahEnd").removeAttr("disabled", "disabled");

			// ร้านค้า
			$($("#obtTXIBrowseShpStart").parent()).addClass("disabled");
			$($("#obtTXIBrowseShpStart").parent()).attr("disabled", "disabled");
			$("#obtTXIBrowseShpStart").addClass("disabled");
			$("#obtTXIBrowseShpStart").attr("disabled", "disabled");

			$($("#obtTXIBrowseShpEnd").parent()).addClass("disabled");
			$($("#obtTXIBrowseShpEnd").parent()).attr("disabled", "disabled");
			$("#obtTXIBrowseShpEnd").addClass("disabled");
			$("#obtTXIBrowseShpEnd").attr("disabled", "disabled");
		}

		$("#oetShpCodeStart").val("");
		$("#oetShpNameStart").val("");
		$("#oetShpCodeEnd").val("");
		$("#oetShpNameEnd").val("");
		$("#oetPosCodeStart").val("");
		$("#oetPosNameStart").val("");
		$("#oetPosCodeEnd").val("");
		$("#oetPosNameEnd").val("");
		$("#ohdWahCodeStart").val("");
		$("#oetWahNameStart").val("");
		$("#ohdWahCodeEnd").val("");
		$("#oetWahNameEnd").val("");

		if ($("#oetBchCode").val() != "" ||
			$("#oetMchCode").val() != "" ||
			$("#oetShpCodeEnd").val() != "" ||
			$("#oetPosCodeEnd").val() != "") {
			$("#obtTXIBrowseShipAdd").removeAttr("disabled");
		} else {
			$("#obtTXIBrowseShipAdd").attr("disabled", "disabled");
		}
		/*Clone มาจาก ภาพ */

		//Check สินค้า ว่ามีค่าหรือไม่ถ้ามีจะทำการ Clear ค่าเก่า
		var tMsg = "";
		var tMsgPdt = "";
		if ($('.xWPdtItem').length > 0) {
			tMsgPdt = "<p>ข้อมูลสินค้าเดิมจะถูกเคลียร์ โปรดทำการระบุสินค้าใหม่</p>";
			JSxTXIClearDTTemp();
		}
		tMsg += tMsgPdt;
		if (tMsg != "") {
			FSvCMNSetMsgWarningDialog(tMsg);
		}
		//Check สินค้า ว่ามีค่าหรือไม่ถ้ามีจะทำการ Clear ค่าเก่า
	}

	//ร้านค้าเริ่ม
	function JSxTXISetSeqConditionShpStart(poJsonData) {

		if (poJsonData != "NULL") {
			aData = JSON.parse(poJsonData);
			tOldShpStartCode = $("#oetShpCodeStart").data("oldval");
			tNewShpStartCode = aData[1]; //ShopCode
			console.log(tOldShpStartCode + "::" + tNewShpStartCode);

			if (tOldShpStartCode != tNewShpStartCode) {

				//Set ค่าใหม่แทนที่ค่าเก่า ใน Iput
				$("#oetShpCodeStart").data("oldval", tNewShpStartCode);
				console.log('=> function ClearDTTemp');

				JSxTXIControlShpStart(poJsonData);

			} else {
				console.log('Merchant Not Change');
			}

		} else {

			if ($("#oetShpCodeStart").data("oldval") != "") {
				$("#oetShpCodeStart").data("oldval", "");
				JSxTXIControlShpStart(poJsonData);
			}
			console.log("NULL");
		}

	}

	function JSxTXIControlShpStart(poJsonData) {

		$("#oetPosCodeStart").val("");
		$("#oetPosNameStart").val("");
		$("#ohdWahCodeStart").val("");
		$("#oetWahNameStart").val("");

		if ($("#oetShpCodeStart").val() != "") {
			var aData = JSON.parse(poJsonData);
			tInforType = aData[2];
			if (tInforType == '4') {
				$($($($("#obtTXIBrowsePosStart").parent()).parent()).parent()).removeClass("xCNHide");
				//เครื่องจุดขาย
				$($("#obtTXIBrowsePosStart").parent()).removeClass("disabled");
				$($("#obtTXIBrowsePosStart").parent()).removeAttr("disabled");
				$("#obtTXIBrowsePosStart").removeClass("disabled");
				$("#obtTXIBrowsePosStart").removeAttr("disabled");

				//คลังสินค้า
				$($("#obtTXIBrowseWahStart").parent()).removeClass("disabled");
				$($("#obtTXIBrowseWahStart").parent()).removeAttr("disabled", "disabled");
				$("#obtTXIBrowseWahStart").removeClass("disabled");
				$("#obtTXIBrowseWahStart").removeAttr("disabled", "disabled");
			} else {
				$($($($("#obtTXIBrowsePosStart").parent()).parent()).parent()).addClass("xCNHide");
				//เครื่องจุดขาย
				$($("#obtTXIBrowsePosStart").parent()).addClass("disabled");
				$($("#obtTXIBrowsePosStart").parent()).attr("disabled", "disabled");
				$("#obtTXIBrowsePosStart").addClass("disabled");
				$("#obtTXIBrowsePosStart").attr("disabled", "disabled");

				$("#ohdWahCodeStart").val(aData[3]);
				$("#oetWahNameStart").val(aData[4]);

				//คลังสินค้า
				$($("#obtTXIBrowseWahStart").parent()).addClass("disabled");
				$($("#obtTXIBrowseWahStart").parent()).attr("disabled", "disabled");
				$("#obtTXIBrowseWahStart").addClass("disabled");
				$("#obtTXIBrowseWahStart").attr("disabled", "disabled");
			}
			if ($("#oetShpCodeEnd").val() != "") {
				if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
					if ($("#oetPosCodeEnd").val() == "" && $("#ohdWahCodeEnd").val() != "") {
						//คลังสินค้า
						$($("#obtTXIBrowseWahStart").parent()).addClass("disabled");
						$($("#obtTXIBrowseWahStart").parent()).attr("disabled", "disabled");
						$("#obtTXIBrowseWahStart").addClass("disabled");
						$("#obtTXIBrowseWahStart").attr("disabled", "disabled");
					}
				}
			}
		} else {

			$($($($("#obtTXIBrowsePosStart").parent()).parent()).parent()).addClass("xCNHide");
			//เครื่องจุดขาย
			$($("#obtTXIBrowsePosStart").parent()).addClass("disabled");
			$($("#obtTXIBrowsePosStart").parent()).attr("disabled", "disabled");
			$("#obtTXIBrowsePosStart").addClass("disabled");
			$("#obtTXIBrowsePosStart").attr("disabled", "disabled");

			if ($("#oetBchCode").val() == "") {
				//คลังสินค้า
				$($("#obtTXIBrowseWahStart").parent()).addClass("disabled");
				$($("#obtTXIBrowseWahStart").parent()).attr("disabled", "disabled");
				$("#obtTXIBrowseWahStart").addClass("disabled");
				$("#obtTXIBrowseWahStart").attr("disabled", "disabled");

			} else {
				if ($("#oetMchCode").val() != "") {
					//คลังสินค้า
					$($("#obtTXIBrowseWahStart").parent()).addClass("disabled");
					$($("#obtTXIBrowseWahStart").parent()).attr("disabled", "disabled");
					$("#obtTXIBrowseWahStart").addClass("disabled");
					$("#obtTXIBrowseWahStart").attr("disabled", "disabled");
				} else {
					//คลังสินค้า
					$($("#obtTXIBrowseWahStart").parent()).removeClass("disabled");
					$($("#obtTXIBrowseWahStart").parent()).removeAttr("disabled", "disabled");
					$("#obtTXIBrowseWahStart").removeClass("disabled");
					$("#obtTXIBrowseWahStart").removeAttr("disabled", "disabled");
				}
			}
		}

		if ($("#oetBchCode").val() != "" ||
			$("#oetMchCode").val() != "" ||
			$("#oetShpCodeEnd").val() != "" ||
			$("#oetPosCodeEnd").val() != "") {
			$("#obtTXIBrowseShipAdd").removeAttr("disabled");
		} else {
			$("#obtTXIBrowseShipAdd").attr("disabled", "disabled");
		}

		//Check สืนค้า ว่ามีค่าหรือไม่ถ้ามีจะทำการ Clear ค่าเก่า
		var tMsg = "";
		var tMsgPdt = "";
		if ($('.xWPdtItem').length > 0) {
			tMsgPdt = "<p>ข้อมูลสินค้าเดิมจะถูกเคลียร์ โปรดทำการระบุสินค้าใหม่</p>";
			JSxTXIClearDTTemp();
		}
		tMsg += tMsgPdt;
		if (tMsg != "") {
			FSvCMNSetMsgWarningDialog(tMsg);
		}
		//Check สืนค้า ว่ามีค่าหรือไม่ถ้ามีจะทำการ Clear ค่าเก่า
	}


	//เครื่องจุดขาย เริ่ม
	function JSxTXISetSeqConditionPosStart(paInForCon) {
		$("#ohdWahCodeStart").val("");
		$("#oetWahNameStart").val("");
		if ($("#oetPosCodeStart").val() != "") {
			var aData = JSON.parse(paInForCon);
			$("#ohdWahCodeStart").val(aData[3]);
			$("#oetWahNameStart").val(aData[4]);
			//คลังสินค้า
			$($("#obtTXIBrowseWahStart").parent()).addClass("disabled");
			$($("#obtTXIBrowseWahStart").parent()).attr("disabled", "disabled");
			$("#obtTXIBrowseWahStart").addClass("disabled");
			$("#obtTXIBrowseWahStart").attr("disabled", "disabled");
			if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
				if (!$($($($("#obtTXIBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) {
					if ($("#oetPosCodeEnd").val() == "") {
						//คลังสินค้า
						$($("#obtTXIBrowseWahEnd").parent()).removeClass("disabled");
						$($("#obtTXIBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
						$("#obtTXIBrowseWahEnd").removeClass("disabled");
						$("#obtTXIBrowseWahEnd").removeAttr("disabled", "disabled");
					}
				}
			}
		} else {
			//คลังสินค้า
			$($("#obtTXIBrowseWahStart").parent()).removeClass("disabled");
			$($("#obtTXIBrowseWahStart").parent()).removeAttr("disabled", "disabled");
			$("#obtTXIBrowseWahStart").removeClass("disabled");
			$("#obtTXIBrowseWahStart").removeAttr("disabled", "disabled");
			if (!$($($($("#obtTXIBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) {
				if ($("#oetPosCodeEnd").val() == "" && $("#ohdWahCodeEnd").val() != "") {
					//คลังสินค้า
					$($("#obtTXIBrowseWahStart").parent()).addClass("disabled");
					$($("#obtTXIBrowseWahStart").parent()).attr("disabled", "disabled");
					$("#obtTXIBrowseWahStart").addClass("disabled");
					$("#obtTXIBrowseWahStart").attr("disabled", "disabled");
				}
			}
		}

		if ($("#oetBchCode").val() != "" ||
			$("#oetMchCode").val() != "" ||
			$("#oetShpCodeEnd").val() != "" ||
			$("#oetPosCodeEnd").val() != "") {
			$("#obtTXIBrowseShipAdd").removeAttr("disabled");
		} else {
			$("#obtTXIBrowseShipAdd").attr("disabled", "disabled");
		}
	}

	//คลัง เริ่ม
	function JSxTXISetSeqConditionWahStart(paInForCon) {
		if ($("#oetShpCodeEnd").val() != "") {
			if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
				if (!$($($($("#obtTXIBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) {
					if ($("#oetPosCodeEnd").val() == "" && $("#ohdWahCodeEnd").val() == "") {
						//คลังสินค้า
						$($("#obtTXIBrowseWahEnd").parent()).addClass("disabled");
						$($("#obtTXIBrowseWahEnd").parent()).attr("disabled", "disabled");
						$("#obtTXIBrowseWahEnd").addClass("disabled");
						$("#obtTXIBrowseWahEnd").attr("disabled", "disabled");
						if ($("#oetPosCodeStart").val() == "" && $("#ohdWahCodeStart").val() == "") {
							//คลังสินค้า
							$($("#obtTXIBrowseWahEnd").parent()).removeClass("disabled");
							$($("#obtTXIBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
							$("#obtTXIBrowseWahEnd").removeClass("disabled");
							$("#obtTXIBrowseWahEnd").removeAttr("disabled", "disabled");
						}
					}
				}
			}
		}

		if ($("#oetBchCode").val() != "" ||
			$("#oetMchCode").val() != "" ||
			$("#oetShpCodeEnd").val() != "" ||
			$("#oetPosCodeEnd").val() != "") {
			$("#obtTXIBrowseShipAdd").removeAttr("disabled");
		} else {
			$("#obtTXIBrowseShipAdd").attr("disabled", "disabled");
		}
	}


	//ร้านค้าจบ
	function JSxTXISetSeqConditionShpEnd(poJsonData) {

		if (poJsonData != "NULL") {
			aData = JSON.parse(poJsonData);
			tOldShpCodeEnd = $("#oetShpCodeEnd").data("oldval");
			tNewShpCodeEnd = aData[1]; //FTShpCode
			console.log("Shop End: " + tOldShpCodeEnd + "::" + tNewShpCodeEnd);

			if (tOldShpCodeEnd != tNewShpCodeEnd) {

				//Set ค่าใหม่แทนที่ค่าเก่า ใน Iput
				$("#oetShpCodeEnd").data("oldval", tNewShpCodeEnd);
				console.log('=> function ClearDTTemp');

				JSxTXIControlShopEnd(poJsonData);

			} else {
				console.log('Shop To Not Change');
			}

		} else {

			if ($("#oetShpCodeEnd").data("oldval") != '') {
				$("#oetShpCodeEnd").data("oldval", '');

				JSxTXIControlShopEnd(poJsonData);
			}
			console.log($("#oetShpCodeEnd").data("oldval") + 'NULL')
		}

	}

	function JSxTXIControlShopEnd(poJsonData) {

		$("#oetPosCodeEnd").val("");
		$("#oetPosNameEnd").val("");
		$("#ohdWahCodeEnd").val("");
		$("#oetWahNameEnd").val("");

		if ($("#oetShpCodeEnd").val() != "") {
			var aData = JSON.parse(poJsonData);
			tInforType = aData[2];
			if (tInforType == '4') {
				$($($($("#obtTXIBrowsePosEnd").parent()).parent()).parent()).removeClass("xCNHide");
				//เครื่องจุดขาย
				$($("#obtTXIBrowsePosEnd").parent()).removeClass("disabled");
				$($("#obtTXIBrowsePosEnd").parent()).removeAttr("disabled");
				$("#obtTXIBrowsePosEnd").removeClass("disabled");
				$("#obtTXIBrowsePosEnd").removeAttr("disabled");

				//คลังสินค้า
				$($("#obtTXIBrowseWahEnd").parent()).removeClass("disabled");
				$($("#obtTXIBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
				$("#obtTXIBrowseWahEnd").removeClass("disabled");
				$("#obtTXIBrowseWahEnd").removeAttr("disabled", "disabled");
			} else {
				$($($($("#obtTXIBrowsePosEnd").parent()).parent()).parent()).addClass("xCNHide");
				//เครื่องจุดขาย
				$($("#obtTXIBrowsePosEnd").parent()).addClass("disabled");
				$($("#obtTXIBrowsePosEnd").parent()).attr("disabled", "disabled");
				$("#obtTXIBrowsePosEnd").addClass("disabled");
				$("#obtTXIBrowsePosEnd").attr("disabled", "disabled");

				$("#ohdWahCodeEnd").val(aData[3]);
				$("#oetWahNameEnd").val(aData[4]);

				//คลังสินค้า
				$($("#obtTXIBrowseWahEnd").parent()).addClass("disabled");
				$($("#obtTXIBrowseWahEnd").parent()).attr("disabled", "disabled");
				$("#obtTXIBrowseWahEnd").addClass("disabled");
				$("#obtTXIBrowseWahEnd").attr("disabled", "disabled");
			}
			if ($("#oetShpCodeStart").val() != "") {
				if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
					if ($("#oetPosCodeStart").val() == "" && $("#ohdWahCodeStart").val() != "") {
						//คลังสินค้า
						$($("#obtTXIBrowseWahEnd").parent()).addClass("disabled");
						$($("#obtTXIBrowseWahEnd").parent()).attr("disabled", "disabled");
						$("#obtTXIBrowseWahEnd").addClass("disabled");
						$("#obtTXIBrowseWahEnd").attr("disabled", "disabled");
					}
				}
			}
		} else {
			$($($($("#obtTXIBrowsePosEnd").parent()).parent()).parent()).addClass("xCNHide");
			//เครื่องจุดขาย
			$($("#obtTXIBrowsePosEnd").parent()).addClass("disabled");
			$($("#obtTXIBrowsePosEnd").parent()).attr("disabled", "disabled");
			$("#obtTXIBrowsePosEnd").addClass("disabled");
			$("#obtTXIBrowsePosEnd").attr("disabled", "disabled");
		}

		if ($("#oetBchCode").val() != "" ||
			$("#oetMchCode").val() != "" ||
			$("#oetShpCodeEnd").val() != "" ||
			$("#oetPosCodeEnd").val() != "") {
			$("#obtTXIBrowseShipAdd").removeAttr("disabled");
		} else {
			$("#obtTXIBrowseShipAdd").attr("disabled", "disabled");
		}

		//Check ที่อยู่ ว่ามีค่าหรือไม่ถ้ามีจะทำการ Clear ค่าเก่า
		if ($('#ohdXthShipAdd').val() != 0) {
			$('#ohdXthShipAdd').val("");
			FSvCMNSetMsgWarningDialog("<p>ข้อมูลที่อยู่สำหรับจัดส่งเดิมจะถูกเคลียร์ โปรดทำการระบุข้อมูลที่อยู่สำหรับจัดส่งใหม่</p>");
		}

	}

	//เครื่องจุดขาย จบ
	function JSxTXISetSeqConditionPosEnd(poJsonData) {

		if (poJsonData != "NULL") {
			aData = JSON.parse(poJsonData);
			tOldPosCodeEnd = $("#oetPosCodeEnd").data("oldval");
			tNewPosCodeEnd = aData[2]; //FTPosCode
			console.log("Pos End: " + tOldPosCodeEnd + "::" + tNewPosCodeEnd);

			if (tOldPosCodeEnd != tNewPosCodeEnd) {

				//Set ค่าใหม่แทนที่ค่าเก่า ใน Iput
				$("#oetPosCodeEnd").data("oldval", tNewPosCodeEnd);
				console.log('=> function ClearDTTemp');

				JSxTXIControlPosEnd(poJsonData);

			} else {
				console.log('Pos To Not Change');
			}

		} else {

			if ($("#oetPosCodeEnd").data("oldval") != '') {
				$("#oetPosCodeEnd").data("oldval", '');

				JSxTXIControlPosEnd(poJsonData);
			}
			console.log($("#oetPosCodeEnd").data("oldval") + 'NULL')
		}

	}

	function JSxTXIControlPosEnd(poJsonData) {

		$("#ohdWahCodeEnd").val("");
		$("#oetWahNameEnd").val("");
		if ($("#oetPosCodeEnd").val() != "") {
			var aData = JSON.parse(poJsonData);
			$("#ohdWahCodeEnd").val(aData[3]);
			$("#oetWahNameEnd").val(aData[4]);
			//คลังสินค้า
			$($("#obtTXIBrowseWahEnd").parent()).addClass("disabled");
			$($("#obtTXIBrowseWahEnd").parent()).attr("disabled", "disabled");
			$("#obtTXIBrowseWahEnd").addClass("disabled");
			$("#obtTXIBrowseWahEnd").attr("disabled", "disabled");
			if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
				if (!$($($($("#obtTXIBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")) {
					if ($("#oetPosCodeStart").val() == "") {
						//คลังสินค้า
						$($("#obtTXIBrowseWahStart").parent()).removeClass("disabled");
						$($("#obtTXIBrowseWahStart").parent()).removeAttr("disabled", "disabled");
						$("#obtTXIBrowseWahStart").removeClass("disabled");
						$("#obtTXIBrowseWahStart").removeAttr("disabled", "disabled");
					}
				}
			}
		} else {
			//คลังสินค้า
			$($("#obtTXIBrowseWahEnd").parent()).removeClass("disabled");
			$($("#obtTXIBrowseWahEnd").parent()).removeAttr("disabled", "disabled");
			$("#obtTXIBrowseWahEnd").removeClass("disabled");
			$("#obtTXIBrowseWahEnd").removeAttr("disabled", "disabled");
			if (!$($($($("#obtTXIBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")) {
				if ($("#oetPosCodeStart").val() == "" && $("#ohdWahCodeStart").val() != "") {
					//คลังสินค้า
					$($("#obtTXIBrowseWahEnd").parent()).addClass("disabled");
					$($("#obtTXIBrowseWahEnd").parent()).attr("disabled", "disabled");
					$("#obtTXIBrowseWahEnd").addClass("disabled");
					$("#obtTXIBrowseWahEnd").attr("disabled", "disabled");
				}
			}
		}

		if ($("#oetBchCode").val() != "" ||
			$("#oetMchCode").val() != "" ||
			$("#oetShpCodeEnd").val() != "" ||
			$("#oetPosCodeEnd").val() != "") {
			$("#obtTXIBrowseShipAdd").removeAttr("disabled");
		} else {
			$("#obtTXIBrowseShipAdd").attr("disabled", "disabled");
		}

		//Check ที่อยู่ ว่ามีค่าหรือไม่ถ้ามีจะทำการ Clear ค่าเก่า
		if ($('#ohdXthShipAdd').val() != 0) {
			$('#ohdXthShipAdd').val("");
			FSvCMNSetMsgWarningDialog("<p>ข้อมูลที่อยู่สำหรับจัดส่งเดิมจะถูกเคลียร์ โปรดทำการระบุข้อมูลที่อยู่สำหรับจัดส่งใหม่</p>");
		}
	}

	//คลัง จบ
	function JSxTXISetSeqConditionWahEnd(paInForCon) {
		if ($("#oetShpCodeStart").val() != "") {
			if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
				if (!$($($($("#obtTXIBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")) {
					if ($("#oetPosCodeStart").val() == "" && $("#ohdWahCodeStart").val() == "") {
						//คลังสินค้า
						$($("#obtTXIBrowseWahStart").parent()).addClass("disabled");
						$($("#obtTXIBrowseWahStart").parent()).attr("disabled", "disabled");
						$("#obtTXIBrowseWahStart").addClass("disabled");
						$("#obtTXIBrowseWahStart").attr("disabled", "disabled");
						if ($("#oetPosCodeEnd").val() == "" && $("#ohdWahCodeEnd").val() == "") {
							//คลังสินค้า
							$($("#obtTXIBrowseWahStart").parent()).removeClass("disabled");
							$($("#obtTXIBrowseWahStart").parent()).removeAttr("disabled", "disabled");
							$("#obtTXIBrowseWahStart").removeClass("disabled");
							$("#obtTXIBrowseWahStart").removeAttr("disabled", "disabled");
						}
					}
				}
			}
		}

		if ($("#oetBchCode").val() != "" ||
			$("#oetMchCode").val() != "" ||
			$("#oetShpCodeEnd").val() != "" ||
			$("#oetPosCodeEnd").val() != "") {
			$("#obtTXIBrowseShipAdd").removeAttr("disabled");
		} else {
			$("#obtTXIBrowseShipAdd").attr("disabled", "disabled");
		}
	}
</script>