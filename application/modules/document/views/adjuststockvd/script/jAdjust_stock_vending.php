<script type="text/javascript">
	var nLangEdits		= '<?php echo $this->session->userdata("tLangEdit"); ?>';
	var tUsrApv    		= '<?php echo $this->session->userdata("tSesUsername"); ?>';
	var tSesUsrLevel    = '<?php echo $this->session->userdata('tSesUsrLevel');?>';
	var tRoute          =  $('#ohdADJVDRoute').val();
	$(document).keypress(
		function(event) {
			if (event.which == '13') {
				event.preventDefault();
			}
		}
	);

	//RabbitMQ
	var tLangCode 	= nLangEdits;
	var tUsrBchCode = $("#ohdBchCode").val();
	var tUsrApv 	= $("#oetXthApvCode").val();
	var tDocNo 		= $("#oetXthDocNo").val();
	var tPrefix 	= 'RESAJS';
	var tStaApv 	= $("#ohdXthStaApv").val();
	var tStaPrcStk 	= $("#ohdXthStaPrcStk").val();
	var tStaDelMQ 	= $("#ohdXthStaDelMQ").val();
	var tQName 		= tPrefix + '_' + tDocNo + '_' + tUsrApv;

	$(document).ready(function() {

		// MQ Message Config	
		var poDocConfig = {
			tLangCode	: tLangCode,
			tUsrBchCode	: tUsrBchCode,
			tUsrApv		: tUsrApv,
			tDocNo		: tDocNo,
			tPrefix		: tPrefix,
			tStaDelMQ	: tStaDelMQ,
			tStaApv		: tStaApv,
			tQName		: tQName
		};

		// RabbitMQ STOMP Config
		var poMqConfig = {
			host	: "ws://"+oSTOMMQConfig.host+":15674/ws",
			username: oSTOMMQConfig.user,
			password: oSTOMMQConfig.password,
			vHost	: oSTOMMQConfig.vhost
		};

		// Update Status For Delete Qname Parameter
		var poUpdateStaDelQnameParams = {
			ptDocTableName		: "TCNTPdtAdjStkHD",
			ptDocFieldDocNo		: "FTAjhDocNo",
			ptDocFieldStaApv	: "FTAjhStaPrcStk",
			ptDocFieldStaDelMQ	: "FTAjhStaDelMQ",
			ptDocStaDelMQ		: tStaDelMQ,
			ptDocNo				: tDocNo
		};

		// Callback Page Control(function)
		var poCallback	= {
			tCallPageEdit	: "JSvCallPageADJVDEdit",
			tCallPageList	: "JSvCallPageADJVDList"
		};

		//Check Show Progress %
		if (tDocNo != '' && (tStaApv == 2 || tStaPrcStk == 2)) { // 2 = Processing
			FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
		}

		//Check Delete MQ SubScrib
		if (tStaApv == 1 && tStaPrcStk == 1 && tStaDelMQ == '') { // Qname removed ?
			var poDelQnameParams = {
				ptPrefixQueueName	: tPrefix,
				ptBchCode			: tUsrBchCode,
				ptDocNo				: tDocNo,
				ptUsrCode			: tUsrApv
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
			format			: 'yyyy-mm-dd',
			autoclose		: true,
			todayHighlight	: true
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


	//เลือกรหัสอัตโนมัติ
	$('#ocbADJVDAutoGenCode').unbind().bind('change', function() {
		var bIsChecked = $('#ocbADJVDAutoGenCode').is(':checked');
		var oInputDocNo = $('#oetXthDocNo');
		if (bIsChecked) {
			$(oInputDocNo).attr('readonly', true);
			$(oInputDocNo).attr('disabled', true);
			$(oInputDocNo).val("");
			$(oInputDocNo).parents('.form-group').removeClass('has-error').find('em').hide();
		} else {
			$(oInputDocNo).removeAttr('readonly');
			$(oInputDocNo).removeAttr('disabled');
		}
	});

	//Control ปุ่ม
	if(tRoute == 'ADJSTKVDEventEdit'){
		//เข้ามาแบบแก้ไข
		$('#obtADJ_VendingBrowseShp').removeClass('xCNClassBlockEventClick');
		$('#obtADJ_VendingBrowseShp').removeClass('disabled');
		$('#obtADJ_VendingBrowseShp').attr('disabled',false);

		$('#obtADJVDBrowsePosStart').removeClass('xCNClassBlockEventClick');
		$('#obtADJVDBrowsePosStart').removeClass('disabled');
		$('#obtADJVDBrowsePosStart').attr('disabled',false);

		$('#obtADJVDBrowseWah').removeClass('xCNClassBlockEventClick');
		$('#obtADJVDBrowseWah').removeClass('disabled');
		$('#obtADJVDBrowseWah').attr('disabled',false);

		$('#obtADJVDControlFormSearchPDT').attr('disabled',false);

		//เข้ามาแบบเเก้ไข แต่เอกสารถูกยกเลิก
		if($('#ohdXthStaDoc').val() == 3 || $('#ohdXthStaApv').val() == 1){
			$('.xCNBtnBrowseAddOn').addClass('xCNClassBlockEventClick');
			$('.xCNBtnBrowseAddOn').removeClass('disabled');
			$('.xCNBtnBrowseAddOn').attr('disabled',false);

			$('.xCNWhenAprOrCancel').addClass('xCNClassBlockEventClick');
			$('.xCNWhenAprOrCancel').removeClass('disabled');
			$('.xCNWhenAprOrCancel').attr('disabled',false);

			$('.xCNBtnDateTime').attr('disabled',true)
		}
	}

	function JSxADJVDClearPdtInTmp(){
		$.ajax({
			type : "POST",
			url  : "ADJSTKVDRemoveItemAllInTemp",
			data : {
				'tBchCode' : $('#oetBchCode').val(),
				'tDocNo'   : $('#oetXthDocNo').val(),
			},
			catch 	: false,
			timeout	: 0,
			success	: function (tResult){
				JSxLoadPdtDtFromTem(1);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JCNxResponseError(jqXHR, textStatus, errorThrown);
			}
		});
	}

	function JSbADJVDHavePdtInTmp(ptNextFunc){
		var nCountPdtInTmp = $('.xCNADJVendingPdtLayoutRow').length;
		if( nCountPdtInTmp > 0 ){
			FSvCMNSetMsgWarningDialog("มีข้อมูลรายการสินค้าตรวจนับสต็อคในระบบ ท่านต้องการที่จะลบข้อมูลรายการสินค้า ใช่ หรือ ไม่ ?", ptNextFunc, '', '1');
			return true;
		}else{
			return false;
		}
	}

	//เลือกสาขา
	$('#obtBrowseBCH_ADJVending').click(function() {
		if(JSbADJVDHavePdtInTmp('JSxADJVDCallBrowseBranch')){
			return false;
		}else{
			JSxADJVDCallBrowseBranch('2');
			return true;
		}
	});

	// ptType : 1 = delete pdt in temp before browse , 2 = default browse
	function JSxADJVDCallBrowseBranch(ptType){

		if( ptType == '1' ){
			JSxADJVDClearPdtInTmp();
		}

		var nLangEdits = <?php echo $this->session->userdata("tLangEdit"); ?>;
        var tUsrLevel = "<?=$this->session->userdata('tSesUsrLevel')?>";
        var tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var tSQLWhere = "";

        if( tUsrLevel != "HQ" ){
            tSQLWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
        }

        window.oBrowse_Branch = {
            Title       : ['authen/user/user', 'tBrowseBCHTitle'],
            Table       : { Master : 'TCNMBranch' , PK : 'FTBchCode' },
            Join        : {
                Table   : ['TCNMBranch_L'],
                On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tSQLWhere]
            },
            GrideView   : {
                ColumnPathLang      : 'authen/user/user',
                ColumnKeyLang       : ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize         : ['10%', '75%'],
                DataColumns         : ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat   : ['', ''],
                WidthModal          : 50,
                Perpage             : 10,
                OrderBy             : ['TCNMBranch.FTBchCode'],
                SourceOrder         : "ASC"
            },
            CallBack    : {
                ReturnType          : 'S',
                Value               : ["oetBchCode", "TCNMBranch.FTBchCode"],
                Text                : ["oetBchName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc    : {
                FuncName            : 'JSxAfterChooseBCH',
                ArgReturn           : ['FTBchCode']
            },
            RouteAddNew 			: 'branch',
            BrowseLev   			: 1
        };
        JCNxBrowseData('oBrowse_Branch');
	}

	//หลังจากเลือกสาขา
	function JSxAfterChooseBCH(){
		//ล้างค่าแบบเป็นระดับ
		// var nReturn = JSxChangeValue();
		// if(nReturn == true){
			$('#oetMchName , #oetMchCode').val('');

			$('#oetShpNameStart , #oetShpCodeStart').val('');
			// $('#obtADJ_VendingBrowseShp').addClass('xCNClassBlockEventClick');

			$('#oetPosNameStart , #oetPosCodeStart').val('');
			$('#obtADJVDBrowsePosStart').addClass('xCNClassBlockEventClick');

			$('#oetWahNameStart , #ohdWahCodeStart').val('');
			$('#obtADJVDBrowseWah').addClass('xCNClassBlockEventClick');
		// }
	}

	//เลือกกลุ่มร้านค้า
	$('#obtADJVDBrowseMch').click(function() {
		if(JSbADJVDHavePdtInTmp('JSxADJVDCallBrowseMerchant')){
			return false;
		}else{
			JSxADJVDCallBrowseMerchant('2');
			return true;
		}
	});

	// ptType : 1 = delete pdt in temp before browse , 2 = default browse
	function JSxADJVDCallBrowseMerchant(ptType){

		if( ptType == '1' ){
			JSxADJVDClearPdtInTmp();
		}

		window.oBrowseADJMch = {
            Title: ['company/warehouse/warehouse', 'tWAHBwsMchTitle'],
            Table: {
                Master	: 'TCNMMerchant',
                PK		: 'FTMerCode'
            },
            Join: {
                Table	: ['TCNMMerchant_L'],
                On		: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '" + $("#oetBchCode").val() + "') != 0"]
            },
            GrideView: {
                ColumnPathLang		: 'company/warehouse/warehouse',
                ColumnKeyLang		: ['tWAHBwsMchCode', 'tWAHBwsMchNme'],
                ColumnsSize			: ['15%', '75%'],
                WidthModal			: 50,
                DataColumns			: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                DataColumnsFormat	: ['', ''],
                Perpage				: 10,
                OrderBy				: ['TCNMMerchant.FTMerCode'],
                SourceOrder			: "ASC"
            },
            CallBack: {
                ReturnType	: 'S',
                Value		: ["oetMchCode", "TCNMMerchant.FTMerCode"],
                Text		: ["oetMchName", "TCNMMerchant_L.FTMerName"],
            },
            NextFunc: {
                FuncName: 'JSxAfterChooseMER',
                ArgReturn: ['FTMerCode', 'FTMerName']
            },
            BrowseLev: 1
        };
		JCNxBrowseData('oBrowseADJMch');
		// Hide Pin Menu
		JSxCheckPinMenuClose();

	}

	//หลังจากเลือกกลุ่มร้านค้า
	function JSxAfterChooseMER(paData){
		//ถ้าไม่เลือกข้อมูลต้อง เคีลยร์ค่าเก่า
		if(paData == 'NULL' || paData == null){
			$('#oetShpNameStart , #oetShpCodeStart').val('');
			// $('#obtADJ_VendingBrowseShp').addClass('xCNClassBlockEventClick');

			$('#oetPosNameStart , #oetPosCodeStart').val('');
			$('#obtADJVDBrowsePosStart').addClass('xCNClassBlockEventClick');

			$('#oetWahNameStart , #ohdWahCodeStart').val('');
			$('#obtADJVDBrowseWah').addClass('xCNClassBlockEventClick');

			$('#obtADJVDControlFormSearchPDT').attr('disabled',true);
		}else{
			// var nReturn = JSxChangeValue();
			// if(nReturn == true){
				$('#oetShpNameStart , #oetShpCodeStart').val('');
				$('#oetPosNameStart , #oetPosCodeStart').val('');
				$('#oetWahNameStart , #ohdWahCodeStart').val('');
				$('#obtADJVDBrowsePosStart').addClass('xCNClassBlockEventClick');

				$('#obtADJ_VendingBrowseShp').removeClass('xCNClassBlockEventClick');
				$('#obtADJ_VendingBrowseShp').removeClass('disabled');
				$('#obtADJ_VendingBrowseShp').attr('disabled',false);
			// }
		}
	}

	//เลือก ร้านค้า / รูปแบบการจัดสินค้า
	$('#obtADJ_VendingBrowseShp').click(function() {
		if(JSbADJVDHavePdtInTmp('JSxADJVDCallBrowseShopVD')){
			return false;
		}else{
			JSxADJVDCallBrowseShopVD('2');
			return true;
		}
	});

	// ptType : 1 = delete pdt in temp before browse , 2 = default browse
	function JSxADJVDCallBrowseShopVD(ptType){

		if( ptType == '1' ){
			JSxADJVDClearPdtInTmp();
		}

		window.oBrowseADJShp = {
            Title: ['company/shop/shop', 'tSHPTitle_LAYOUT'],
            Table: {
                Master	: 'TCNMShop',
                PK		: 'FTShpCode'
            },
            Join: {
                Table	: [	'TCNMShop_L', 'TCNMWaHouse_L'],
                On		: [	'TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                    		'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMShop.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
                		]
            },
            Where: {
                Condition: [
                    function() {
						// Where Branch Shop
						var tBchCode		= $("#oetBchCode").val();
						var tWhereBchCode	= "";
						if(tBchCode != ""){
							tWhereBchCode   = " AND TCNMShop.FTBchCode = '" + $("#oetBchCode").val() + "' ";
						}
						// Where Merchant
						var tMerCode		= $('#oetMchCode').val();
						var tWhereMerCode   = "";
						if(tMerCode != ""){
							tWhereMerCode   = " AND TCNMShop.FTMerCode = '" + $("#oetMchCode").val() + "'";
						}
                        var tSQL = "AND TCNMShop.FTShpStaActive = 1 "+tWhereBchCode+tWhereMerCode;
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang		: 'company/shop/shop',
                ColumnKeyLang		: ['tShopCode_LAYOUT', 'tShopName_LAYOUT'],
                ColumnsSize			: ['25%', '75%'],
                WidthModal			: 50,
                DataColumns			: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTWahCode', 'TCNMWaHouse_L.FTWahName', 'TCNMShop.FTShpType', 'TCNMShop.FTBchCode'],
                DataColumnsFormat	: ['', '', '', '', '', ''],
                DisabledColumns		: [2, 3, 4, 5],
                Perpage				: 10,
                OrderBy				: ['TCNMShop_L.FTShpCode'],
                SourceOrder			: "ASC"
            },
            CallBack: {
                ReturnType			: 'S',
                Value				: ["oetShpCodeStart", "TCNMShop.FTShpCode"],
                Text				: ["oetShpNameStart", "TCNMShop_L.FTShpName"],
            },
            NextFunc: {
                FuncName			: 'JSxAfterChooseSHP',
                ArgReturn			: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
            },
            BrowseLev: 1
        }
        JCNxBrowseData('oBrowseADJShp');
	}

	//หลังจากเลือกร้านค้า
	function JSxAfterChooseSHP(paData){
		//ถ้าไม่เลือกข้อมูลต้อง เคีลยร์ค่าเก่า
		if(paData == 'NULL' || paData == null){
			$('#oetPosNameStart , #oetPosCodeStart').val('');
			$('#obtADJVDBrowsePosStart').addClass('xCNClassBlockEventClick');

			$('#oetWahNameStart , #ohdWahCodeStart').val('');
			$('#obtADJVDBrowseWah').addClass('xCNClassBlockEventClick');

			$('#obtADJVDControlFormSearchPDT').attr('disabled',true);
		}else{
			// var nReturn = JSxChangeValue();
			// var tJSON = JSON.parse(paData);
			// if(nReturn == true){
				$('#oetPosNameStart , #oetPosCodeStart').val('');
				$('#oetWahNameStart , #ohdWahCodeStart').val('');
				$('#obtADJVDBrowsePosStart').removeClass('xCNClassBlockEventClick');
				$('#obtADJVDBrowsePosStart').removeClass('disabled');
				$('#obtADJVDBrowsePosStart').attr('disabled',false);
			// }
		}
	}

	// ตูุ้ขายสินค้า
	$('#obtADJVDBrowsePosStart').click(function() {
		if(JSbADJVDHavePdtInTmp('JSxADJVDCallBrowsePosVD')){
			return false;
		}else{
			JSxADJVDCallBrowsePosVD('2');
			return true;
		}
	});

	// ptType : 1 = delete pdt in temp before browse , 2 = default browse
	function JSxADJVDCallBrowsePosVD(ptType){

		if( ptType == '1' ){
			JSxADJVDClearPdtInTmp();
		}
		
		var oJoinCondition  = {
			Table: ['TCNMPos', 'TCNMPosLastNo', 'TCNMWaHouse', 'TCNMWaHouse_L','TCNMPos_L'],
			On: ['TVDMPosShop.FTPosCode = TCNMPos.FTPosCode AND TVDMPosShop.FTBchCode = TCNMPos.FTBchCode',
				'TVDMPosShop.FTPosCode = TCNMPosLastNo.FTPosCode',
				'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTWahStaType = 6 AND TCNMPos.FTBchCode = TCNMWaHouse.FTBchCode',
				'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits ,
				'TVDMPosShop.FTPosCode = TCNMPos_L.FTPosCode AND TVDMPosShop.FTBchCode = TCNMPos_L.FTBchCode AND TCNMPos_L.FNLngID = ' + nLangEdits
			]
		};
        var aCondition = [
			function() {
				var tSQL = "AND TCNMPos.FTPosStaUse = 1 AND TVDMPosShop.FTShpCode = '" + $("#oetShpCodeStart").val() + "' AND TVDMPosShop.FTBchCode = '" + $("#oetBchCode").val() + "'";
				tSQL += " AND TCNMPos.FTPosType = '4'";
				return tSQL;
			}
		];
        var aDataColumns        = ['TVDMPosShop.FTPosCode', 'TCNMPos_L.FTPosName', 'TCNMPosLastNo.FTPosComName', 'TVDMPosShop.FTShpCode', 'TVDMPosShop.FTBchCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'];
        var aDataColumnsFormat  = ['', '', '', '', '', ''];
        var aDisabledColumns    = [2, 3, 4, 5, 6];
        var aArgReturn          = ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName'];

        window.oADJVDBrowsePos = {
            Title   : ['pos/posshop/posshop', 'tPshTBPosCode'],
            Table   : {
                Master  : 'TVDMPosShop',
                PK      : 'FTPosCode'
            },
            Join    : oJoinCondition,
            Where   : {
                Condition       : aCondition
            },
            GrideView: {
                ColumnPathLang  : 'pos/posshop/posshop',
                ColumnKeyLang   : ['tPshBRWShopTBCode', 'tPshBRWPosTBName'],
                ColumnsSize     : ['25%', '75%'],
                WidthModal      : 50,
                DataColumns     : aDataColumns,
                DataColumnsFormat: aDataColumnsFormat,
                DisabledColumns : aDisabledColumns,
                Perpage         : 10,
                OrderBy         : ['TVDMPosShop.FTPosCode'],
                SourceOrder     : "ASC"
            },
            CallBack: {
                ReturnType  : 'S',
                Value       : ["oetPosCodeStart", "TVDMPosShop.FTPosCode"],
                Text        : ["oetPosNameStart", "TCNMPos_L.FTPosName"],
            },
            NextFunc: {
                FuncName    : 'JSxAfterChoosePOS',
                ArgReturn   : aArgReturn
			}
        }

		// Hide Pin Menu
		JSxCheckPinMenuClose();
		JCNxBrowseData('oADJVDBrowsePos');
	}

	//หลังจากเลือกเครื่องจุดขาย
	function JSxAfterChoosePOS(paData){
		//ถ้าไม่เลือกข้อมูลต้อง เคีลยร์ค่าเก่า
		if(paData == 'NULL' || paData == null){
			$('#oetWahNameStart , #ohdWahCodeStart').val('');
			$('#obtADJVDBrowseWah').addClass('xCNClassBlockEventClick');

			$('#obtADJVDControlFormSearchPDT').attr('disabled',true);
		}else{
			// var nReturn = JSxChangeValue();
			var tJSON = JSON.parse(paData);
			// if(nReturn == true){
				$('#obtADJVDBrowseWah').removeClass('xCNClassBlockEventClick');
				$('#obtADJVDBrowseWah').removeClass('disabled');
				$('#obtADJVDBrowseWah').attr('disabled',false);

				$('#ohdWahCodeStart').val(tJSON[3]);
				$('#oetWahNameStart').val(tJSON[4]);

				$('#obtADJVDControlFormSearchPDT').attr('disabled',false);
			// }
		}
	}

	//เลือกคลังสินค้า
	$('#obtADJVDBrowseWah').click(function(){
		var nStaSession = JCNxFuncChkSessionExpired();
		if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
			JSxCheckPinMenuClose();
			window.oBrowseWah_AdjVendingOption  = undefined;
			oBrowseWah_AdjVendingOption         = oASTBrowseWah({
				'tASTBchCode'       : $('#oetBchCode').val(),
				'tASTShpCode'       : $('#oetShpCodeStart').val(),
				'tASTPosCode'       : $('#oetPosCodeStart').val(),
				'tReturnInputCode'  : "ohdWahCodeStart",
				'tReturnInputName'  : "oetWahNameStart",
				'tNextFuncName'     : "JSxAfterSelectWah",
				'aArgReturn'        : ['FTWahCode']
			});
			JCNxBrowseData('oBrowseWah_AdjVendingOption');
		}else{
			JCNxShowMsgSessionExpired();
		}
	});

	// Option Modal คลังสินค้า
	var oASTBrowseWah = function(poDataFnc){
		var tASTBchCode         = poDataFnc.tASTBchCode;
		var tASTShpCode         = poDataFnc.tASTShpCode;
		var tASTPosCode         = poDataFnc.tASTPosCode;
		var tInputReturnCode    = poDataFnc.tReturnInputCode;
		var tInputReturnName    = poDataFnc.tReturnInputName;
		var tNextFuncName       = poDataFnc.tNextFuncName;
		var aArgReturn          = poDataFnc.aArgReturn;
		var tWhereModal         = "";

		// Where คลังของ สาขา
		if(tASTShpCode == "" && tASTPosCode == ""){
			tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (1,2,5))";
		}

		// Where สาขา
		if(tASTBchCode  != ""){
			tWhereModal += " AND (TCNMWaHouse.FTBchCode = '"+tASTBchCode+"')";
		}

		// Where คลังของ ร้านค้า
		if(tASTShpCode  != "" && tASTPosCode == ""){
			tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (4))";
			tWhereModal += " AND (TCNMWaHouse.FTWahRefCode = '"+tASTShpCode+"')";
		}

		// Where คลังของ เครื่องจุดขาย
		if(tASTShpCode  != "" && tASTPosCode != ""){
			tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (6))";
			tWhereModal += " AND (TCNMWaHouse.FTWahRefCode = '"+tASTPosCode+"')";
		}

		var oOptionReturn       = {
			Title: ["company/warehouse/warehouse","tWAHTitle"],
			Table: { Master:"TCNMWaHouse", PK:"FTWahCode"},
			Join: {
				Table: ["TCNMWaHouse_L"],
				On: [
					"TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '"+nLangEdits+"'"
				]
			},
			Where: {
				Condition : [tWhereModal]
			},
			GrideView:{
				ColumnPathLang: 'company/warehouse/warehouse',
				ColumnKeyLang: ['tWahCode','tWahName'],
				DataColumns: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
				DataColumnsFormat: ['',''],
				ColumnsSize: ['15%','75%'],
				Perpage: 5,
				WidthModal: 50,
				OrderBy: ['TCNMWaHouse_L.FTWahName'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType  : 'S',
				Value       : [tInputReturnCode,"TCNMWaHouse.FTWahCode"],
				Text        : [tInputReturnName,"TCNMWaHouse_L.FTWahName"]
			},
			NextFunc: {
				FuncName    : tNextFuncName,
				ArgReturn   : aArgReturn
			}
		};
		return oOptionReturn;
	}

	//หลังจากเลือกคลังสินค้า
	function JSxAfterSelectWah(paData){
		//ถ้าไม่เลือกข้อมูลต้อง เคีลยร์ค่าเก่า
		if(paData == 'NULL' || paData == null){
			$('#obtADJVDControlFormSearchPDT').attr('disabled',true);
		}else{
			// var nReturn = JSxChangeValue();
			// if(nReturn == true){
				$('#obtADJVDControlFormSearchPDT').attr('disabled',false);
			// }else{

			// }
		}
	}

	//เหตุผล
	$('#obtASTBrowseRsn').click(function() {
		if(JSbADJVDHavePdtInTmp('JSxADJVDCallBrowseReason')){
			return false;
		}else{
			JSxADJVDCallBrowseReason('2');
			return true;
		}
	});

	// ptType : 1 = delete pdt in temp before browse , 2 = default browse
	function JSxADJVDCallBrowseReason(ptType){

		if( ptType == '1' ){
			JSxADJVDClearPdtInTmp();
		}
	
		// Option Modal เหตุผล
		oOptionReturn = {
			Title: ["other/reason/reason","tRSNTitle"],
			Table: {Master:"TCNMRsn",PK:"FTRsnCode"},
			Join: {
				Table: ["TCNMRsn_L"],
				On: ["TCNMRsn.FTRsnCode = TCNMRsn_L.FTRsnCode AND TCNMRsn_L.FNLngID = '"+nLangEdits+"'"]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = " AND TCNMRsn.FTRsgCode = '008' ";
						return tSQL;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'other/reason/reason',
				ColumnKeyLang: ['tRSNTBCode','tRSNTBName'],
				ColumnsSize: ['15%','75%'],
				WidthModal: 50,
				DataColumns: ['TCNMRsn.FTRsnCode','TCNMRsn_L.FTRsnName'],
				DataColumnsFormat: ['',''],
				Perpage: 10,
				OrderBy: ['TCNMRsn_L.FTRsnName ASC'],
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetASTRsnCode","TCNMRsn.FTRsnCode"],
				Text: ["oetASTRsnName","TCNMRsn_L.FTRsnName"],
			},
			RouteAddNew : 'reason',
			BrowseLev : 1,
		};
		// Hide Pin Menu
		JSxCheckPinMenuClose();
		JCNxBrowseData('oOptionReturn');
	}

	//เคลียร์ข้อมูลทั้งหมด
	$("#obtADJVDControlFormClear").click(function(){
		//ล้างปุ่ม
		$('#obtADJVDControlFormSearchPDT').attr('disabled',true);

		if(tSesUsrLevel == 'HQ'){
			//กลุ่มธุรกิจ
			$("#oetMchCode").val("");
			$("#oetMchName").val("");

			//ร้านค้า
			$("#oetShpCodeStart").val("");
			$("#oetShpNameStart").val("");
			$("#obtADJ_VendingBrowseShp").addClass("disabled");
			$("#obtADJ_VendingBrowseShp").attr("disabled", "disabled");
		}else if(tSesUsrLevel == 'SHP'){
			//ร้านค้า
			$("#oetShpCodeStart").val("");
			$("#oetShpNameStart").val("");
			$("#obtADJ_VendingBrowseShp").removeClass("disabled");
			$("#obtADJ_VendingBrowseShp").attr("disabled", false);
		}
		
		//เครื่องจุดขาย
		$("#oetPosCodeStart").val("");
		$("#oetPosNameStart").val("");
		$("#obtADJVDBrowsePosStart").addClass("disabled");
		$("#obtADJVDBrowsePosStart").attr("disabled", "disabled");
		
		//คลัง
		$("#ohdWahCodeStart").val("");
		$("#oetWahNameStart").val("");
		$("#obtADJVDBrowseWah").addClass("disabled");
		$("#obtADJVDBrowseWah").attr("disabled", "disabled");
	
	});

	//ค้นหารายการสินค้า
	$('#obtADJVDControlFormSearchPDT').click(function(){
		if($('#ohdWahCodeStart').val() == '' ){
			$('#oetWahNameStart').focus();
			return;
		}else if($('#oetASTRsnCode').val() == '' || $('#oetASTRsnCode').val() == null){
			$('#odvADJVDReasonIsNull').modal('show');
			$('#oetASTRsnName').focus();
		}else{
			JCNxOpenLoading();
			if(tRoute == 'ADJSTKVDEventEdit'){
				JSvADJVDLoadPdtDataTableHtml(1,'ProcessInPageEdit');
			}else{
				JSvADJVDLoadPdtDataTableHtml(1);
			}
		}
	});

	//ถ้ามีการเปลี่ยนค่า จะต้องขึ้นเเจ้งเตือน
	// function JSxChangeValue(){
	// 	var nLen = $("#odvTBodyADJVDPdtAdvTableList tr").length;
	// 	if(nLen >= 1){
	// 		var tCheckClass = $("#odvTBodyADJVDPdtAdvTableList tr td").hasClass('xCNNotfound');
	// 		if(tCheckClass == true){ //พบว่า "ไม่เจอข้อมูล"
	// 			return true;
	// 		}else{ //มีข้อมูล
	// 			$('#odvADJVDChangeData').modal("show");

	// 			//กดยืนยันข้อมูล
	// 			$('.xCNConfrimChangeData').click(function(){
	// 				$.ajax({
	// 					type : "POST",
	// 					url  : "ADJSTKVDRemoveItemAllInTemp",
	// 					data : {
	// 						'tBchCode' : $('#oetBchCode').val(),
	// 						'tDocNo'   : $('#oetXthDocNo').val(),
	// 					},
	// 					catch 	: false,
	// 					timeout	: 0,
	// 					success	: function (tResult){
	// 						// console.log(tResult);
	// 						$('#odvADJVDChangeData').modal("hide");
	// 						$("#odvTBodyADJVDPdtAdvTableList").html('');
	// 						$("#odvTBodyADJVDPdtAdvTableList").append('<tr><td colspan="100%" class="text-center xCNNotfound"><span><?=language('common/main/main','tCMNNotFoundData')?></span></td></tr>');
	// 						$('#odvPaginationBtn p').text('');
	// 					},
	// 					error: function (jqXHR, textStatus, errorThrown) {
	// 						JCNxResponseError(jqXHR, textStatus, errorThrown);
	// 					}
	// 				});
	// 			});
	// 			return true;
	// 		}
	// 	}
	// }

	//พิมพ์
	function JSxADJVDPrint(){
		var aInfor = [
			{"Lang"         : '<?=FCNaHGetLangEdit(); ?>'}, // Lang ID
			{"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, // Company Code
			{"BranchCode"   : '<?=FCNtGetAddressBranch($tBchCode); ?>'  }, // สาขาที่ออกเอกสาร
			{"DocCode"      : $('#oetXthDocNo').val()  } // เลขที่เอกสาร
		];
		window.open("<?=base_url(); ?>formreport/Frm_SQL_ALLMPdtBillChkStkVD?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
	}





</script>
