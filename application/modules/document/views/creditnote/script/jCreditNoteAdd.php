
<script type="text/javascript">
    nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
    tUsrApv     = '<?php echo $this->session->userdata("tSesUsername");?>';

    // Disabled Enter in Form
    $(document).keypress(
        function(event){
            if (event.which == '13') {
                event.preventDefault();
            }
        }
    );

    $(document).ready(function(){

        $('.xCNMenuplus').unbind().click(function(){
            if($(this).hasClass('collapsed')){
                $('.xCNMenuplus').removeClass('collapsed').addClass('collapsed');
                $('.xCNMenuPanelData').removeClass('in');
            }
        });

        if(JSbCreditNoteIsApv() || JSbCreditNoteIsStaDoc('cancel')){
            JSxCMNVisibleComponent('#obtCreditNoteCancel', false);
            JSxCMNVisibleComponent('#obtCreditNoteApprove', false);
            JSxCMNVisibleComponent('#odvBtnAddEdit .btn-group', false);
        }

        // console.log('JCNbCreditNoteIsDocType: ', JCNbCreditNoteIsDocType('havePdt'));
        if(JCNbCreditNoteIsUpdatePage()){
            // Doc No
            $("#oetCreditNoteDocNo").attr("readonly", true);
            $("#odvCreditNoteAutoGenDocNoForm input").attr("disabled", true);
            JSxCMNVisibleComponent('#odvCreditNoteAutoGenDocNoForm', false);

            JSxCMNVisibleComponent('#obtCardShiftOutBtnApv', true);
            JSxCMNVisibleComponent('#obtCardShiftOutBtnCancelApv', true);
            JSxCMNVisibleComponent('#obtCardShiftOutBtnDocMa', true);

            if(JCNbCreditNoteIsDocType('havePdt') && JSbCreditNoteGetStaApv() == '2'){
                JSoCreditNoteSubscribeMQ();
            }

            if(JSbCreditNoteIsStaDoc('cancel')){ // ปิดปุ่มพิมพ์เมื่อมีการยกเลิกเอกสาร
                JSxCMNVisibleComponent('#obtCreditNotePrintDoc', false);
            }else{ // นอกนั้นให้เปิดปุ่ม
                JSxCMNVisibleComponent('#obtCreditNotePrintDoc', true);
            }

        }

        if(JCNbCreditNoteIsCreatePage()){
            // Doc No
            $("#oetCreditNoteDocNo").attr("disabled", true);
            $('#ocbCreditNoteAutoGenCode').change(function(){
                if($('#ocbCreditNoteAutoGenCode').is(':checked')) {
                    $("#oetCreditNoteDocNo").attr("disabled", true);
                    $('#odvCreditNoteDocNoForm').removeClass('has-error');
                    $('#odvCreditNoteDocNoForm em').remove();
                }else{
                    $("#oetCreditNoteDocNo").attr("disabled", false);
                }
            });
            JSxCMNVisibleComponent('#odvCreditNoteAutoGenDocNoForm', true);

            JSxCMNVisibleComponent('#obtCreditNotePrintDoc', false);
            JSxCMNVisibleComponent('#obtCardShiftOutBtnApv', false);
            JSxCMNVisibleComponent('#obtCardShiftOutBtnCancelApv', false);
            JSxCMNVisibleComponent('#obtCardShiftOutBtnDocMa', false);
        }

        // console.log('JStCMNUserLevel: ', JStCMNUserLevel());
        if(!(JSbCreditNoteIsApv() || JSbCreditNoteIsStaDoc('cancel'))){ // เอกสารยังไม่มีการอนุมัติ หรือ ไม่ถูกยกเลิกให้เริ่มการทำงานนี้
            // Condition control onload
            if(JStCMNUserLevel() == 'HQ'){
                // Init
                $('#obtCreditNoteBrowseMch').attr('disabled', false);
                $('#obtCreditNoteBrowseShp').attr('disabled', true);
                $('#obtCreditNoteBrowsePos').attr('disabled', true);
                $('#obtCreditNoteBrowseWah').attr('disabled', false);
            }

            if(JStCMNUserLevel() == 'BCH'){
                // Init
                // $('#obtCreditNoteBrowseBch').attr('disabled', true);
                $('#obtCreditNoteBrowseMch').attr('disabled', false);
                $('#obtCreditNoteBrowseShp').attr('disabled', true);
                $('#obtCreditNoteBrowsePos').attr('disabled', true);
                $('#obtCreditNoteBrowseWah').attr('disabled', false);
            }

            if(JStCMNUserLevel() == 'SHP'){
                // Init
                // console.log('SHP');
                // $('#obtCreditNoteBrowseBch').attr('disabled', true);
                $('#obtCreditNoteBrowseMch').attr('disabled', true);
                $('#obtCreditNoteBrowseShp').attr('disabled', true);
                $('#obtCreditNoteBrowsePos').attr('disabled', false);
                $('#obtCreditNoteBrowseWah').attr('disabled', true);
            }
        }
        $('#oliCreditNoteMngPdtScan').click(function(){

            var tSplCode = $('#oetCreditNoteSplCode').val();
            if(tSplCode === ''){
                var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
                FSvCMNSetMsgWarningDialog(tWarningMessage);
                return;
            }

            // Hide
            $('#oetCreditNoteSearchPdtHTML').hide();
            $('#oimCreditNoteMngPdtIconSearch').hide();
            // Show
            $('#oetCreditNoteScanPdtHTML').show();
            $('#oimCreditNoteMngPdtIconScan').show();
        });

        $('#oliCreditNoteMngPdtSearch').click(function(){
            // Hide
            $('#oetCreditNoteScanPdtHTML').hide();
            $('#oimCreditNoteMngPdtIconScan').hide();
            // Show
            $('#oetCreditNoteSearchPdtHTML').show();
            $('#oimCreditNoteMngPdtIconSearch').show();
        });

        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm:ss'
        });

        $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
        $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

    });

    /*========================= Begin Browse Options =============================*/

    // สาขา
    $('#obtCreditNoteBrowseBch').click(function(){
        tUsrLevel   = "<?=$this->session->userdata('tSesUsrLevel')?>";
        tBchMulti   = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        tSQLWhere   = "";
        if(tUsrLevel != "HQ"){
            tSQLWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
        }

        JSxCheckPinMenuClose();
        tOldBchCkChange = $("#oetBchCode").val();
        nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;
        oPmhBrowseBch = {
            Title: ['company/branch/branch', 'tBCHTitle'],
            Table: {Master:'TCNMBranch', PK:'FTBchCode'},
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
            },
            Where: {
                Condition: [tSQLWhere]
            },
            GrideView:{
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                DisabledColumns: [],
                Perpage: 10,
                OrderBy: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType: 'S',
                Value: ["oetCreditNoteBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetCreditNoteBchName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc:{
                FuncName: 'JSxCreditNoteCallbackAfterSelectBch',
                ArgReturn: ['FTBchCode', 'FTBchName']
            }
        };
        JCNxBrowseData('oPmhBrowseBch');
    });

    // กลุ่มร้านค้า
    $('#obtCreditNoteBrowseMch').click(function(){
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        tOldMchCkChange = $("#oetMchCode").val();
        // Option merchant
        var tBch = $("#oetCreditNoteBchCode").val();
        if($("#oetCreditNoteBchCode").val()){
            tBch = $("#oetCreditNoteBchCode").val();
        }
        oCreditNoteBrowseMch = {
            Title: ['company/warehouse/warehouse', 'tWAHBwsMchTitle'],
            Table: {Master:'TCNMMerchant', PK:'FTMerCode'},
            Join: {
                Table: ['TCNMMerchant_L'],
                On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits]
            },
            Where: {
                Condition: ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '"+tBch+"') != 0"]
            },
            GrideView: {
                ColumnPathLang: 'company/warehouse/warehouse',
                ColumnKeyLang: ['tWAHBwsMchCode', 'tWAHBwsMchNme'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                DataColumnsFormat: ['',''],
                Perpage: 10,
                OrderBy: ['TCNMMerchant.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType: 'S',
                Value: ["oetCreditNoteMchCode", "TCNMMerchant.FTMerCode"],
                Text: ["oetCreditNoteMchName", "TCNMMerchant_L.FTMerName"]
            },
            NextFunc:{
                FuncName:'JSxCreditNoteCallbackAfterSelectMer',
                ArgReturn:['FTMerCode', 'FTMerName']
            },
            BrowseLev: 1
            // DebugSQL : true
        };
        // Option merchant
        JCNxBrowseData('oCreditNoteBrowseMch');
    });

    // ร้านค้า
    $('#obtCreditNoteBrowseShp').click(function(){
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        // Option Shop
        var tMch = $("#oetCreditNoteMchCode").val();
        var tBch = $("#oetCreditNoteBchCode").val();
        if($("#oetCreditNoteBchCode").val()){
            tBch = $("#oetCreditNoteBchCode").val();
        }

        oCreditNoteBrowseShp = {
            Title : ['company/shop/shop', 'tSHPTitle'],
            Table:{Master: 'TCNMShop', PK: 'FTShpCode'},
            Join :{
                Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
                On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                    'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMShop.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID= '+nLangEdits
                ]
            },
            Where:{
                Condition : [
                    function(){
                        var tSQL = "AND TCNMShop.FTBchCode = '"+tBch+"' AND TCNMShop.FTMerCode = '"+tMch+"'";
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
                DisabledColumns:[2, 3, 4, 5],
                Perpage: 10,
                OrderBy: ['TCNMShop.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetCreditNoteShpCode", "TCNMShop.FTShpCode"],
                Text: ["oetCreditNoteShpName", "TCNMShop_L.FTShpName"]
            },
            NextFunc: {
                FuncName: 'JSxCreditNoteCallbackAfterSelectShp',
                ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
            },
            BrowseLev: 1,
            // DebugSQL : true
        };
        // Option Shop
        JCNxBrowseData('oCreditNoteBrowseShp');
    });

    // เครื่องจุดขาย
    $('#obtCreditNoteBrowsePos').click(function(){
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        // Option Shop
        var tBch = $("#oetCreditNoteBchCode").val();
        if($("#oetCreditNoteBchCode").val()){
            tBch = $("#oetCreditNoteBchCode").val();
        }
        oCreditNoteBrowsePos = {
            Title: ['pos/posshop/posshop', 'tPshTBPosCode'],
            Table: { Master:'TVDMPosShop', PK:'FTPosCode' },
            Join: {
                Table: ['TCNMPos', 'TCNMPosLastNo', 'TCNMWaHouse', 'TCNMWaHouse_L'],
                On:['TVDMPosShop.FTPosCode = TCNMPos.FTPosCode AND TVDMPosShop.FTBchCode = TCNMPos.FTBchCode' ,
                    'TVDMPosShop.FTPosCode = TCNMPosLastNo.FTPosCode',
                    'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TVDMPosShop.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse.FTWahStaType = 6',
                    'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TVDMPosShop.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID= '+nLangEdits
                ]
            },
            Where: {
                Condition: [
                    function(){
                        var tSQL = "AND TVDMPosShop.FTBchCode = '"+tBch+"' AND TVDMPosShop.FTShpCode = '"+$("#oetCreditNoteShpCode").val()+"'";
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
                DataColumnsFormat : ['', '', '', '', '', ''],
                DisabledColumns: [1, 2, 3, 4, 5],
                Perpage: 10,
                OrderBy: ['TVDMPosShop.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetCreditNotePosCode", "TVDMPosShop.FTPosCode"],
                Text: ["oetCreditNotePosName", "TCNMPosLastNo.FTPosCode"]
            },
            NextFunc: {
                FuncName: 'JSxCreditNoteCallbackAfterSelectPos',
                ArgReturn: ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName']
            },
            BrowseLev: 1
        };
        // Option Shop
        JCNxBrowseData('oCreditNoteBrowsePos');
    });

    // คลังสินค้า
    $('#obtCreditNoteBrowseWah').click(function(){
        var tCreditNoteBchCode   =  $('#oetCreditNoteBchCode').val();

        JSxCheckPinMenuClose(); // Hidden Pin Menu
        // Option WareHouse
        oCreditNoteBrowseWah = {
            Title: ['company/warehouse/warehouse', 'tWAHTitle'],
            Table: { Master:'TCNMWaHouse', PK:'FTWahCode'},
            Join: {
                Table: ['TCNMWaHouse_L'],
                On:['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND  TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits]
            },
            Where: {
                Condition: [
                    function(){
                        var tSQL = "AND TCNMWaHouse.FTBchCode = '"+tCreditNoteBchCode+"'";
                        if(($("#oetCreditNoteShpCode").val() == '') && ($("#oetCreditNotePosCode").val() == '') ){ // Branch Wah
                            tSQL += " AND TCNMWaHouse.FTWahStaType IN (1,2,5)";
                        }

                        if( ($("#oetCreditNoteShpCode").val() != '') && ($("#oetCreditNotePosCode").val() == '') ){ // Shop Wah
                            tSQL += " AND TCNMWaHouse.FTWahStaType IN (4)";
                            tSQL += " AND TCNMWaHouse.FTWahRefCode = '"+$('#oetCreditNoteShpCode').val()+"'";
                        }

                        if( ($("#oetCreditNoteShpCode").val() != '') && ($("#oetCreditNotePosCode").val() != '') ){ // Pos(vending) Wah
                            tSQL += " AND TCNMWaHouse.FTWahStaType IN (6)";
                            tSQL += " AND TCNMWaHouse.FTWahRefCode = '"+$('#oetCreditNotePosCode').val()+"'";
                        }
                        // console.log(tSQL);
                        return tSQL;
                    }
                ]
            },
            GrideView:{
                ColumnPathLang: 'company/warehouse/warehouse',
                ColumnKeyLang: ['tWahCode','tWahName'],
                DataColumns: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['',''],
                ColumnsSize: ['15%','75%'],
                Perpage: 10,
                WidthModal: 50,
                OrderBy: ['TCNMWaHouse.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType: 'S',
                Value: ["oetCreditNoteWahCode","TCNMWaHouse.FTWahCode"],
                Text: ["oetCreditNoteWahName","TCNMWaHouse_L.FTWahName"]
            },
            NextFunc:{
                FuncName: 'JSxCreditNoteCallbackAfterSelectWah',
                ArgReturn: []
            },
            RouteAddNew: 'warehouse',
            BrowseLev: nStaCreditNoteBrowseType
        };
        // Option WareHouse
        JCNxBrowseData('oCreditNoteBrowseWah');
    });

    // ผู้จำหน่าย
    $('#obtCreditNoteBrowseSpl').click(function(){
        var tCDNAgnCode = '<?=$this->session->userdata('tSesUsrAgnCode')?>';
        JSxCheckPinMenuClose();

        var tWhere = '';
        if(tCDNAgnCode != ''){
            tWhere += " AND ( TCNMSpl.FTAgnCode = '"+tCDNAgnCode+"' OR  ISNULL(TCNMSpl.FTAgnCode,'')=''  )  ";
        }

        oCreditNoteBrowseSpl = {
            Title: ['supplier/supplier/supplier', 'tSPLTitle'],
            Table: {Master:'TCNMSpl', PK:'FTSplCode'},
            Join: {
                Table: ['TCNMSpl_L', 'TCNMSplCredit' , 'TCNMVatRate'],
                On: [
                    'TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = '+nLangEdits,
                    'TCNMSpl_L.FTSplCode = TCNMSplCredit.FTSplCode',
                    'TCNMSpl.FTVatCode = TCNMVatRate.FTVatCode'
                ]
            },
            Where:{
                Condition : ["AND TCNMSpl.FTSplStaActive = '1' "+tWhere]
            },
            GrideView:{
                ColumnPathLang: 'supplier/supplier/supplier',
                ColumnKeyLang: ['tSPLTBCode', 'tSPLTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMSpl.FTSplCode', 'TCNMSpl_L.FTSplName', 'TCNMSplCredit.FNSplCrTerm', 'TCNMSplCredit.FCSplCrLimit', 'TCNMSpl.FTSplStaVATInOrEx', 'TCNMSplCredit.FTSplTspPaid', 'TCNMSpl.FTVatCode','TCNMVatRate.FCVatRate'],
                DataColumnsFormat: ['',''],
                DisabledColumns: [2, 3, 4, 5, 6 , 7],
                Perpage: 10,
                OrderBy: ['TCNMSpl.FDCreateOn DESC']
            },
            CallBack:{
                ReturnType: 'S',
                Value: ["oetCreditNoteSplCode", "TCNMSpl.FTSplCode"],
                Text: ["oetCreditNoteSplName", "TCNMSpl_L.FTSplName"]
            },
            NextFunc:{
                FuncName:'JSxCreditNoteCallbackAfterSelectSpl',
                ArgReturn:['FNSplCrTerm', 'FCSplCrLimit', 'FTSplStaVATInOrEx', 'FTSplTspPaid', 'FTSplCode', 'FTSplName', 'FTVatCode' , 'FCVatRate']
            },
            RouteAddNew: 'supplier',
            BrowseLev: nStaCreditNoteBrowseType

        };
        // Option WareHouse
        JCNxBrowseData('oCreditNoteBrowseSpl');
    });

    $('#obtCreditNoteBrowseReason').click(function(){
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        // Option WareHouse
        oCreditNoteBrowseReason = {
                Title: ['other/reason/reason', 'tRSNTitle'],
                Table: { Master:'TCNMRsn', PK:'FTRsnCode' },
                Join: {
                    Table: ['TCNMRsn_L'],
                    On: ['TCNMRsn_L.FTRsnCode = TCNMRsn.FTRsnCode AND TCNMRsn_L.FNLngID = '+nLangEdits]
                },
                Where: {
                    Condition : ["AND TCNMRsn.FTRsgCode = '003' "]
                },
                GrideView:{
                    ColumnPathLang: 'other/reason/reason',
                    ColumnKeyLang: ['tRSNTBCode', 'tRSNTBName'],
                    // ColumnsSize: ['15%', '85%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
                    DisabledColumns: [],
                    DataColumnsFormat: ['', ''],
                    Perpage: 5,
                    OrderBy: ['TCNMRsn_L.FTRsnName'],
                    SourceOrder: "ASC"
                },
                CallBack:{
                    ReturnType: 'S',
                    Value: ["oetCreditNoteReasonCode", "TCNMRsn.FTRsnCode"],
                    Text: ["oetCreditNoteReasonName", "TCNMRsn_L.FTRsnName"]
                },
                /*NextFunc:{
                    FuncName:'JSxCSTAddSetAreaCode',
                    ArgReturn:['FTRsnCode']
                },*/
                // RouteFrom : 'cardShiftChange',
                RouteAddNew : 'reason',
                BrowseLev : nStaCreditNoteBrowseType
        };
        // Option WareHouse
        JCNxBrowseData('oCreditNoteBrowseReason');
    });

    /**
     * สาขา
     * Functionality : Process after shoose branch
     * Parameters : -
     * Creator : 22/05/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCreditNoteCallbackAfterSelectBch(poJsonData) {
        var bDataIsNull = poJsonData == 'NULL';
        if(JCNbCreditNoteIsDocType('havePdt') && !bDataIsNull && JSbCreditNoteHasRowInTemp()) {
            $('#odvCreditNotePopupChangeSplConfirm').modal('show');
        }
    }

    /**
     * กลุ่มร้านค้า
     * Functionality : Process after shoose merchant
     * Parameters : -
     * Creator : 22/05/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCreditNoteCallbackAfterSelectMer(poJsonData) {

        if (poJsonData != "NULL") {
            aData = JSON.parse(poJsonData);
            tAddBch = aData[0];
            tAddSeqNo = aData[1];
        }

        var tBchCode = $('#ohdCreditNoteBchCode').val();
        var tMchName = $('#oetCreditNoteMchName').val();
        var tShpName = $('#oetCreditNoteShpName').val();
        var tPosName = $('#oetCreditNotePosName').val();
        var tWahName = $('#oetCreditNoteWahName').val();

        $('#obtCreditNoteBrowseShp').attr('disabled', true);
        $('#obtCreditNoteBrowsePos').attr('disabled', true);
        $('#obtCreditNoteBrowseWah').attr('disabled', true);

        if(JStCMNUserLevel() == 'HQ' || JStCMNUserLevel() == 'BCH'){
            if(tMchName != ''){
                $('#obtCreditNoteBrowseShp').attr('disabled', false);
                $('#obtCreditNoteBrowseWah').attr('disabled', true);
            }else{
                $('#obtCreditNoteBrowseWah').attr('disabled', false);
            }
            $('#oetCreditNoteShpCode, #oetCreditNoteShpName').val('');
            $('#oetCreditNotePosCode, #oetCreditNotePosName').val('');
            $('#oetCreditNoteWahCode, #oetCreditNoteWahName').val('');
        }
    }

    /**
     * ร้านค้า
     * Functionality : Process after shoose shop
     * Parameters : -
     * Creator : 22/05/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCreditNoteCallbackAfterSelectShp(poJsonData) {

        var aData, tResAddBch, tResAddSeqNo, tResWahCode, tResWahName;
        if (poJsonData != "NULL") {
            aData = JSON.parse(poJsonData);
            tResAddBch = aData[0];
            tResAddSeqNo = aData[1];
            tResWahCode = aData[3];
            tResWahName = aData[4];
        }else{
            $('#oetCreditNoteWahCode, #oetCreditNoteWahName').val('');
        }
        // console.log('aData: ', aData);
        $('#ohdCreditNoteWahCodeInShp').val(tResWahCode);
        $('#ohdCreditNoteWahNameInShp').val(tResWahName);
        var tBchCode = $('#ohdCreditNoteBchCode').val();
        var tMchName = $('#oetCreditNoteMchName').val();
        var tShpName = $('#oetCreditNoteShpName').val();
        var tPosName = $('#oetCreditNotePosName').val();
        var tWahName = $('#oetCreditNoteWahName').val();

        $('#obtCreditNoteBrowsePos').attr('disabled', true);
        $('#obtCreditNoteBrowseWah').attr('disabled', false);

        if(JStCMNUserLevel() == 'HQ' || JStCMNUserLevel() == 'BCH'){
            if(tShpName != ''){
                $('#obtCreditNoteBrowsePos').attr('disabled', false);
                $('#obtCreditNoteBrowseWah').attr('disabled', true);
                $('#oetCreditNoteWahCode').val(tResWahCode);
                $('#oetCreditNoteWahName').val(tResWahName);
            }else{
                $('#oetCreditNoteWahCode, #oetCreditNoteWahName').val('');
            }
            $('#oetCreditNotePosCode, #oetCreditNotePosName').val('');
        }
    }

    /**
     * เครื่องจุดขาย
     * Functionality : Process after shoose pos
     * Parameters : -
     * Creator : 22/05/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCreditNoteCallbackAfterSelectPos(poJsonData) {
        var aData, tResAddBch, tResAddSeqNo, tResWahCode, tResWahName;
        if (poJsonData != "NULL") {
            aData = JSON.parse(poJsonData);
            tResAddBch = aData[0];
            tResAddSeqNo = aData[1];
            tResWahCode = aData[3];
            tResWahName = aData[4];
        }else{
            $('#oetCreditNotePosCode, #oetCreditNotePosName').val('');
            $('#oetCreditNoteWahCode').val($('#ohdCreditNoteWahCodeInShp').val());
            $('#oetCreditNoteWahName').val($('#ohdCreditNoteWahNameInShp').val());
            return;
        }
        // console.log('aData Pos: ', aData);

        var tBchCode = $('#ohdCreditNoteBchCode').val();
        var tMchName = $('#oetCreditNoteMchName').val();
        var tShpName = $('#oetCreditNoteShpName').val();
        var tPosName = $('#oetCreditNotePosName').val();
        var tWahName = $('#oetCreditNoteWahName').val();

        $('#obtCreditNoteBrowseWah').attr('disabled', false);

        if(JStCMNUserLevel() == 'HQ' || JStCMNUserLevel() == 'BCH' || JStCMNUserLevel() == 'SHP'){
            if(tPosName != ''){
                $('#obtCreditNoteBrowseWah').attr('disabled', true);
                $('#oetCreditNoteWahCode').val(tResWahCode);
                $('#oetCreditNoteWahName').val(tResWahName);
            }
        }
    }

    /**
     * คลังสินค้า
     * Functionality : Process after shoose warehouse
     * Parameters : -
     * Creator : 22/05/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCreditNoteCallbackAfterSelectWah(poJsonData) {
        var aData;
        if (poJsonData != "NULL") {
            aData = JSON.parse(poJsonData);
            tAddBch = aData[0];
            tAddSeqNo = aData[1];
        }

    }

    /**
     * เลือกผู้จำหน่าย
     * Functionality : Process after shoose supplyer
     * Parameters : -
     * Creator : 21/06/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCreditNoteCallbackAfterSelectSpl(ptJsonData) {
        var aData;
        if (ptJsonData != "NULL") {
            aData = JSON.parse(ptJsonData);
            var poParams = {
                FNSplCrTerm         : aData[0],
                FCSplCrLimit        : aData[1],
                FTSplStaVATInOrEx   : aData[2],
                FTSplTspPaid        : aData[3],
                FTSplCode           : aData[4],
                FTSplName           : aData[5],
                FTVatCode           : aData[6],
                FCVatRate           : aData[7]
            };

            JSxCreditNoteSetPanelSpl(poParams);
        }
    }
    /*===================== End Callback Browse ==================================*/

    //ล้าง Temp เอกสารทั้งหมด
    function JSxCreditNoteClearTemp() {

        $('#odvCreditNotePopupChangeSplConfirm').modal('hide');

        if(JCNbCreditNoteIsDocType('havePdt')) {
            $.ajax({
                type: "POST",
                url: "creditNoteClearTemp",
                data: {},
                cache: false,
                Timeout: 0,
                success: function (oResult) {
                    JSvCreditNoteLoadPdtDataTableHtml(1, true);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    /**
     * เลือกผู้จำหน่าย
     * Functionality : Process after shoose supplyer
     * Parameters : -
     * Creator : 21/06/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCreditNoteSetPanelSpl(poParams) {
        // Reset
        $("#ocmCreditNoteXphVATInOrEx.selectpicker").val("1").selectpicker("refresh");
        $("#ocmCreditNoteXphCshOrCrd.selectpicker").val("2").selectpicker("refresh");
        $("#ocmCreditNoteHDPcSplXphDstPaid.selectpicker").val("1").selectpicker("refresh");
        $("#oetCreditNoteHDPcSplXphCrTerm.selectpicker").val("");

        // รหัสภาษีจากผู้จำหน่าย
        $("#ohdCreditNoteSplVatCode").val(poParams.FTVatCode);

        // ประเภทภาษี
        if(poParams.FTSplStaVATInOrEx === "1"){ // รวมใน
            $("#ocmCreditNoteXphVATInOrEx.selectpicker").val("1").selectpicker("refresh");
        }else{ // แยกนอก
            $("#ocmCreditNoteXphVATInOrEx.selectpicker").val("2").selectpicker("refresh");
        }
        // ประเภทชำระเงิน
        if(poParams.FCSplCrLimit > 0){ // เงินเชื่อ
            $("#ocmCreditNoteXphCshOrCrd.selectpicker").val("2").selectpicker("refresh");
        }else{ // เงินสด
            $("#ocmCreditNoteXphCshOrCrd.selectpicker").val("1").selectpicker("refresh");
        }
        // การชำระเงิน
        if(poParams.FTSplTspPaid === "1"){ // ต้นทาง
            $("#ocmCreditNoteHDPcSplXphDstPaid.selectpicker").val("1").selectpicker("refresh");
        }else{ // ปลายทาง
            $("#ocmCreditNoteHDPcSplXphDstPaid.selectpicker").val("2").selectpicker("refresh");
        }

        // ระยะเครดิต
        $("#oetCreditNoteHDPcSplXphCrTerm.selectpicker").val(poParams.FNSplCrTerm);

        // Vat จาก SPL
        $('#ohdCNFrmSplVatCode').val(poParams.FTVatCode);
        $('#ohdCNFrmSplVatRate').val(poParams.FCVatRate);

        //เปลี่ยน VAT
        var tVatCode = poParams.FTVatCode;
        var tVatRate = poParams.FCVatRate;
        JSxChangeVatBySPL(tVatCode,tVatRate);
    }

    //ทุกครั้งที่เปลี่ยน SPL ต้องเกิดการคำนวณ VAT ใหม่ที่อยู่ในสินค้า
    function JSxChangeVatBySPL(tVatCode,tVatRate){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "creditNoteChangeSPLAffectNewVAT",
            data: {
                'tBCHCode'      : $('#oetCreditNoteBchCode').val(),
                'tCNDocNo'      : $("#oetCreditNoteDocNo").val(),
                'tVatCode'      : tVatCode,
                'tVatRate'      : tVatRate
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                console.log(oResult);
                var tDocType = $('#ohdCreditNoteDocType').val();
                if(tDocType != '7'){
                    JSvCreditNoteLoadPdtDataTableHtml(1,true)
                }else{
                    JCNxCloseLoading();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //คำนวณท้ายบิล ใบลดหนี้ไม่มีสินค้า
    function JSoCreditNoteCalEndOfBillNonePdt(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tValue          = $('#oetCreditNoteNonePdtValue').val();
            var tVatCode        = $('#ohdCreditNoteSplVatCode').val();
            var tSplVatType     = $('#ocmCreditNoteXphVATInOrEx').val();
            $.ajax({
                type: "POST",
                url: "creditNoteCalEndOfBillNonePdt",
                data: {
                    tSplVatType     : tSplVatType,
                    tVatCode        : tVatCode,
                    tValue          : tValue
                },
                cache: false,
                Timeout: 0,
                success: function (oResult) {
                    alert
                    $('#ospCreditNoteCalEndOfBillNonePdt').text(JSON.stringify(oResult)); // เก็บยอดท้ายบิล ใบลดหนี้ไม่มีสินค้า

                    $('#oulCreditNoteListVatNonePdt').removeClass('xCNHide');
                    $('#odvCreditNoteTextBath').text(oResult['tTotalValueText']);
                    $('#oulCreditNoteListVatNonePdt #olbCreditNoteVatrate').text(oResult['tVatrateText']); // ภาษีมูลค่าเพิ่ม
                    $('#oulCreditNoteListVatNonePdt #oblCreditNoteSumVat').text(oResult['cVat']); // ยอดภาษี
                    $('#olbCrdditNoteVatSum').text(oResult['cVat']); // ยอดรวมภาษีมูลค่าเพิ่ม
                    $('#olbCrdditNoteSumFCXtdNet').text(oResult['tValue']); // จำนวนเงินรวม
                    $('#olbCrdditNoteSumFCXtdVat').text(oResult['cVat']); // ยอดรวมภาษีมูลค่าเพิ่ม
                    $('#olbCrdditNoteCalFCXphGrand').text(oResult['cTotalValue']); // จำนวนเงินรวมทั้งสิ้น
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }else {
            JCNxShowMsgSessionExpired();
        }
    }

    function JSxCreditNoteAddPdtInRow(poJsonData){
        for (var n = 0; n < poJsonData.length; n++) {

            var tdVal = $('.nItem'+n).data('otrval')

            if((tdVal != '') && (typeof tdVal == 'undefined')){

                nTRID = JCNnRandomInteger(100, 1000000);

                var aColDatas = JSON.parse(poJsonData[n]);
                var tPdtCode = aColDatas[0];
                var tPunCode = aColDatas[1];
                FSvCreditNoteAddPdtIntoTableDT(tPdtCode, tPunCode);

            }
        }
    }

    /**
    * Functionality : Check Approve
    * Parameters : -
    * Creator : 24/05/2019 piya
    * Last Modified : -
    * Return : Approve status
    * Return Type : boolean
    */
    function JSbCreditNoteIsApv(){
        var bStatus = false;
        if(($("#ohdCreditNoteStaApv").val() == "1") || ($("#ohdCreditNoteStaApv").val() == "2")){
            bStatus = true;
        }
        return bStatus;
    }

    /**
    * Functionality : Check Sta Approve
    * Parameters : -
    * Creator : 24/05/2019 piya
    * Last Modified : -
    * Return : Approve Type null:not 2:process 1:success
    * Return Type : Number
    */
    function JSbCreditNoteGetStaApv(){
        return $("#ohdCreditNoteStaApv").val();
    }

    /**
    * Functionality : Check Approve
    * Parameters : -
    * Creator : 24/05/2019 piya
    * Last Modified : -
    * Return : Approve status
    * Return Type : boolean
    */
    function JSbCreditNoteIsStaPrcStk(){
        var bStatus = false;
        if($("#ohdCreditNoteAjhStaPrcStk").val() == "1"){
            bStatus = true;
        }
        return bStatus;
    }

    /**
    * Functionality : Check document status
    * Parameters : ptStaType is ("complete", "incomplete", "cancel")
    * Creator : 24/05/2019 piya
    * Last Modified : -
    * Return : Document status
    * Return Type : boolean
    */
    function JSbCreditNoteIsStaDoc(ptStaType){
        var bStatus = false;
        if(ptStaType == "complete"){
            if($("#ohdCreditNoteStaDoc").val() == "1"){
                bStatus = true;
            }
            return bStatus;
        }
        if(ptStaType == "incomplete"){
            if($("#ohdCreditNoteStaDoc").val() == "2"){
                bStatus = true;
            }
            return bStatus;
        }
        if(ptStaType == "cancel"){
            if($("#ohdCreditNoteStaDoc").val() == "3"){
                bStatus = true;
            }
            return bStatus;
        }
        return bStatus;
    }

    /*============================= Begin Custom Form Validate ===================*/

    var bUniqueCreditNoteCode;
    $.validator.addMethod(
        "uniqueCreditNoteCode",
        function(tValue, oElement, aParams) {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {

                var tCreditNoteCode = tValue;
                $.ajax({
                    type: "POST",
                    url: "creditNoteUniqueValidate/docCreditNoteCode",
                    data: "tCreditNoteCode=" + tCreditNoteCode,
                    dataType:"html",
                    success: function(ptMsg)
                    {
                        // If vatrate and vat start exists, set response to true
                        bUniqueCreditNoteCode = (ptMsg == 'true') ? false : true;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Custom validate uniqueCreditNoteCode: ', jqXHR, textStatus, errorThrown);
                    },
                    async: false
                });
                return bUniqueCreditNoteCode;

            }else {
                JCNxShowMsgSessionExpired();
            }

        },
        "Credit Note Doc Code is Already Taken"
    );

    // Override Error Message
    jQuery.extend(jQuery.validator.messages, {
        required: "This field is required.",
        remote: "Please fix this field.",
        email: "Please enter a valid email address.",
        url: "Please enter a valid URL.",
        date: "Please enter a valid date.",
        dateISO: "Please enter a valid date (ISO).",
        number: "Please enter a valid number.",
        digits: "Please enter only digits.",
        creditcard: "Please enter a valid credit card number.",
        equalTo: "Please enter the same value again.",
        accept: "Please enter a value with a valid extension.",
        maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
        minlength: jQuery.validator.format("Please enter at least {0} characters."),
        rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
        range: jQuery.validator.format("Please enter a value between {0} and {1}."),
        max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
        min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
    });

    /*============================= End Custom Form Validate =====================*/

    /**
    * Functionality : Form validate
    * Parameters : -
    * Creator : 24/05/2019 piya
    * Last Modified : -
    * Return : -
    * Return Type : -
    */
    function JSxValidateFormAddCreditNote() {
        $('#ofmAddCreditNote').validate({
            focusInvalid: false,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetCreditNoteDocNo: {
                    required: true,
                    maxlength: 20,
                    uniqueCreditNoteCode: JCNbCreditNoteIsCreatePage()
                },
                obtCreditNoteDocDate: {
                    required: true
                },
                obtCreditNoteDocTime: {
                    required: true
                }
            },
            messages: {
                oetCreditNoteDocNo: {
                    "required": $('#oetCreditNoteDocNo').attr('data-validate-required')
                }
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass("has-error");
            },
            submitHandler: function (form) {
                JSxCreditNoteAddUpdateAction();
            }
        });
    }

    /**
     * Functionality : Add or Update
     * Parameters : route
     * Creator : 23/05/2019 Piya
     * Update : -
     * Return : -
     * Return Type : -
     */
    function JSxCreditNoteAddUpdateAction() {

        var nStaSession = JCNxFuncChkSessionExpired();

        // โปรดเลือกผู้จำหน่ายก่อนทำรายการ
        var tSltSupplierMessage     = '<?=language('document/creditnote/creditnote','tSltSuppiler');?>';
        // โปรดเลือกคลังสินค้าก่อนทำรายการ
        var tSltWahourseMessage     = '<?=language('document/creditnote/creditnote','tSltWahourse');?>';
        // โปรดกรอกชื่อรายการ
        var tPlsFillName            = '<?=language('document/creditnote/creditnote','tPlsEnterName');?>';
        // โปรดกรอกจำนวนเงินรวม
        var tPlsFillAmt             = '<?=language('document/creditnote/creditnote','tPlsFillAmt');?>';
        // ไม่พบรายการสินค้าไม่สามารถดำเนินการต่อได้
        var tPdtNotfound            = '<?=language('document/creditnote/creditnote','tPdtNotfound');?>';


        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tSplCode = $('#oetCreditNoteSplCode').val();
            if(tSplCode === ''){
                var tWarningMessage = tSltSupplierMessage;
                FSvCMNSetMsgWarningDialog(tWarningMessage);
                return;
            }

            if(JCNbCreditNoteIsDocType('nonePdt')){
                var $tNonePdtName = $('#oetCreditNoteNonePdtName').val();
                var $tNonePdtValue = $('#oetCreditNoteNonePdtValue').val();

                if($tNonePdtName === ''){
                    var tWarningMessage = tPlsFillName;
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
                if($tNonePdtValue === ''){
                    var tWarningMessage = tPlsFillAmt;
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
            }

            if(JCNbCreditNoteIsDocType('havePdt')){

                var tDocType = $('#ohdCreditNoteDocType').val();
                var tWahCode = $('#oetCreditNoteWahCode').val();
                if(tDocType != '7'){
                    if(tWahCode === ''){
                        var tWarningMessage = tSltWahourseMessage;
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        return;
                    }
                }

                if(!JSbCreditNoteHasRowInTemp()){
                    var tPdtNotfound = tPdtNotfound;
                    FSvCMNSetMsgWarningDialog(tPdtNotfound);
                    return;
                }

            }


            var tNonePdtCode = $('#olbCreditNoteNonePdtCode').text();
            var tNonePdtName = $('#oetCreditNoteNonePdtName').val();
            var tCalEndOfBillNonePdt = $('#ospCreditNoteCalEndOfBillNonePdt').text();

            $.ajax({
                type: "POST",
                url: '<?php echo $tRoute; ?>',
                data: $("#ofmAddCreditNote").serialize()
                    + '&tPdtCode=' + tNonePdtCode
                    + '&tPdtName=' + tNonePdtName
                    + '&tCalEndOfBillNonePdt=' + tCalEndOfBillNonePdt,
                cache: false,
                timeout: 0,
                success: function (oResult) {
                    if (nStaCreditNoteBrowseType != 1){
                        if (oResult.nStaEvent == "1") {
                            if(oResult.nStaCallBack == "1" || oResult.nStaCallBack == null){
                                JSvCallPageCreditNoteEdit(oResult.tCodeReturn);
                                return;
                            }
                            if(oResult.nStaCallBack == "2"){
                                JSvCallPageCreditNoteAdd();
                                return;
                            }
                            if(oResult.nStaCallBack == "3"){
                                JSvCallPageCreditNoteList();
                                return;
                            }
                        }else {
                            var tMsgBody = oResult.tStaMessg;
                            FSvCMNSetMsgWarningDialog(tMsgBody);
                        }
                    }else {
                        JCNxBrowseData(tCallCreditNoteBackOption);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : ตรวจสอบว่า ผู้จำหน่ายใช้ภาษีแบบไหน
     * Parameters : -
     * Creator : 23/06/2019 Piya
     * Update : -
     * Return : status
     * Return Type : boolean
     */
    function JSxCreditNoteIsSplUseVatType(ptSplVatType) {
        var tSplVatType = $('#ocmCreditNoteXphVATInOrEx').val();
        var bStatus = false;
        if(ptSplVatType == 'in'){
            if(tSplVatType == '1'){
                bStatus = true;
            }
        }
        if(ptSplVatType == 'ex'){
            if(tSplVatType == '2'){
                bStatus = true;
            }
        }
        return bStatus;
    }

    //เพิ่มรายการสินค้าจากการแสกนบาร์โค๊ด
    function JSxCreditNoteAddPdtFromScanBarCodeToDTTemp(){
        if(JCNbCreditNoteIsDocType('havePdt')){
            var aPdtItems = [];
            var tPdtItems = JSON.stringify(aPdtItems);
            var tIsRefPI = '0';
            var tIsByScanBarCode = '1';
            FSvPDTAddPdtIntoTableDT(tPdtItems, tIsRefPI, tIsByScanBarCode);
        }
    }

    /**
     * Functionality : Has Row in Temp
     * Parameters : -
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : status
     * Return Type : boolean
     */
    function JSbCreditNoteHasRowInTemp(){
        var bStatus = false;
        var nTempRows = $('#ohdCreditNoteTempRows').val();
        if(nTempRows > 0){
            bStatus = true;
        }else{
            bStatus = false;
        }
        return bStatus;
    }

    /**
     * Functionality : Change Spl Vat Type
     * Parameters : -
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSbCreditNoteChangeSplVatType(){

        if(JCNbCreditNoteIsDocType('nonePdt')){
            JSoCreditNoteCalEndOfBillNonePdt();
        }

        if(!JSbCreditNoteHasRowInTemp()){
            return;
        }else{
            JSvCreditNoteLoadPdtDataTableHtml(1, true);
        }
    }

    /**
     * Functionality : Print Document
     * Parameters : -
     * Creator : 28/08/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCreditNotePrintDoc(){
        var aInfor = [
            {"Lang"         : '<?= FCNaHGetLangEdit(); ?>'}, // Lang ID
            {"ComCode"      : '<?= FCNtGetCompanyCode(); ?>'}, // Company Code
            {"BranchCode"   : '<?= FCNtGetAddressBranch($tUserBchCode); ?>' }, // สาขาที่ออกเอกสาร
            {"DocCode"      : '<?= $tDocNo; ?>'}, // เลขที่เอกสาร
            {"FormName"     : 'PC'},
            {"DocBchCode"   : '<?= $tUserBchCode;?>'}
        ];
        var tGrandText = $('#odvCreditNoteTextBath').text();
        window.open("<?php echo base_url(); ?>formreport/SMBillPc?infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText,  '_blank');
    }


    /*
    function : Function Browse Pdt
    Parameters : Error Ajax Function
    Creator : 22/05/2019 Piya
    Return : Modal Status Error
    Return Type : view
    */
    function JCNvCreditNoteBrowsePdt() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JSxCheckPinMenuClose();
            var tSplCode = $('#oetCreditNoteSplCode').val();
            if(tSplCode === ''){
                var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
                FSvCMNSetMsgWarningDialog(tWarningMessage);
                return;
            }
            $.ajax({
                type: "POST",
                url: "BrowseDataPDT",
                data: {
                    Qualitysearch   : [],
                    PriceType       : ["Cost", "tCN_Cost", "Company", "1"],
                    SelectTier      : ["Barcode"],
                    ShowCountRecord : 10,
                    NextFunc        : "FSvPDTAddPdtIntoTableDT",
                    ReturnType      : "M",
                    SPL             : [$('#oetCreditNoteSplCode').val(), ''],
                    BCH             : [$("#oetCreditNoteBchCode").val(), ''],
                    MER             : [$('#oetCreditNoteMchCode').val(), ''],
                    SHP             : [$("#oetCreditNoteShpCode").val(), '']
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    $("#odvModalDOCPDT").modal({backdrop: "static", keyboard: false});
                    $("#odvModalDOCPDT").modal({show: true});

                    // remove localstorage
                    localStorage.removeItem("LocalItemDataPDT");
                    $("#odvModalsectionBodyPDT").html(tResult);

                    if(JCNbCreditNoteIsDocType('havePdt')){
                        $("#odvModalDOCPDT #oliBrowsePDTSupply").css('display','none');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }
</script>
