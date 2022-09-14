
<script type="text/javascript">
    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit"); ?>;
    var tUsrApv     = <?php echo $this->session->userdata("tSesUsername"); ?>;
            
// Disabled Enter in Form
$(document).keypress(
    function(event){
        if (event.which == '13') {
            event.preventDefault();
        }
    }
);

$(document).ready(function(){

    var nStaApv = parseInt($('#ohdAdjStkSubAjhStaApv').val());
    var nStaDoc = parseInt($('#ohdAdjStkSubAjhStaDoc').val());
    if(nStaApv == 1 || nStaDoc == 3){
        $('.xCNBtnBrowseAddOn').attr('disabled',true);
        $('.xWASTDisabledOnApv').attr('disabled',true);
        $('.xWASTReadOnlyOnApv').attr('readonly',true);
    }

    var tUsrLevel = $('#ohdAdjStkSubUsrLevel').val();
    if( tUsrLevel != "HQ" ){
        var tBchCount = <?php echo $this->session->userdata("nSesUsrBchCount"); ?>;
        if(tBchCount < 2){
            $('#obtAdjStkSubBrowseBchTo').attr('disabled', true);
        }
    }
    
    if(JCNbAdjStkSubIsUpdatePage()){
        // Doc No
        $("#oetAdjStkSubAjhDocNo").attr("readonly", true);
        $("#odvAdjStkSubSubAutoGenDocNoForm input").attr("disabled", true);
        JSxCMNVisibleComponent('#odvAdjStkSubSubAutoGenDocNoForm', false);
        
        JSxCMNVisibleComponent('#obtCardShiftOutBtnApv', true);
        JSxCMNVisibleComponent('#obtCardShiftOutBtnCancelApv', true);
        JSxCMNVisibleComponent('#obtCardShiftOutBtnDocMa', true);
    }
    
    if(JCNbAdjStkSubIsCreatePage()){
        // Doc No
        $("#oetAdjStkSubAjhDocNo").attr("disabled", true);
        $('#ocbAdjStkSubSubAutoGenCode').change(function(){
            if($('#ocbAdjStkSubSubAutoGenCode').is(':checked')) {
                $("#oetAdjStkSubAjhDocNo").attr("disabled", true);
                $('#odvAdjStkSubSubDocNoForm').removeClass('has-error');
                $('#odvAdjStkSubSubDocNoForm em').remove();
            }else{
                $("#oetAdjStkSubAjhDocNo").attr("disabled", false);
            }
        });
        JSxCMNVisibleComponent('#odvAdjStkSubSubAutoGenDocNoForm', true);
        
        JSxCMNVisibleComponent('#obtCardShiftOutBtnApv', false);
        JSxCMNVisibleComponent('#obtCardShiftOutBtnCancelApv', false);
        JSxCMNVisibleComponent('#obtCardShiftOutBtnDocMa', false);
    }
    
    // console.log('JStCMNUserLevel: ', JStCMNUserLevel());
    // // Condition control onload
    // if(JStCMNUserLevel() == 'HQ'){
    //     // Init
    //     $('#obtAdjStkSubBrowseMch').attr('disabled', false);
    //     $('#obtAdjStkSubBrowseShp').attr('disabled', true);
    //     $('#obtAdjStkSubBrowsePos').attr('disabled', true);
    //     $('#obtAdjStkSubBrowseWah').attr('disabled', false);
    // }
    
    // if(JStCMNUserLevel() == 'BCH'){
    //     // Init
    //     // $('#obtAdjStkSubBrowseBch').attr('disabled', true);
    //     $('#obtAdjStkSubBrowseMch').attr('disabled', false);
    //     $('#obtAdjStkSubBrowseShp').attr('disabled', true);
    //     $('#obtAdjStkSubBrowsePos').attr('disabled', true);
    //     $('#obtAdjStkSubBrowseWah').attr('disabled', false);
    // }
    
    // if(JStCMNUserLevel() == 'SHP'){
    //     // Init
    //     console.log('SHP');
    //     // $('#obtAdjStkSubBrowseBch').attr('disabled', true);
    //     $('#obtAdjStkSubBrowseMch').attr('disabled', true);
    //     $('#obtAdjStkSubBrowseShp').attr('disabled', true);
    //     $('#obtAdjStkSubBrowsePos').attr('disabled', false);
    //     $('#obtAdjStkSubBrowseWah').attr('disabled', true);
    // }
    
    // $('#oliAdjStkSubMngPdtScan').click(function(){
    //     // Hide
    //     $('#oetAdjStkSubSearchPdtHTML').hide();
    //     $('#oimAdjStkSubMngPdtIconSearch').hide();
    //     // Show
    //     $('#oetAdjStkSubScanPdtHTML').show();
    //     $('#oimAdjStkSubMngPdtIconScan').show();
    // });

    $('#oliAdjStkSubMngPdtSearch').click(function(){
        // Hide
        $('#oetAdjStkSubScanPdtHTML').hide();
        $('#oimAdjStkSubMngPdtIconScan').hide();
        // Show
        $('#oetAdjStkSubSearchPdtHTML').show();
        $('#oimAdjStkSubMngPdtIconSearch').show();
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
$('#obtAdjStkSubBrowseBchTo').click(function(){
    var tUsrLevel = $('#ohdAdjStkSubUsrLevel').val();
    var tBchMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var tSQLWhere = "";
    if(tUsrLevel != "HQ"){
        tSQLWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
    }
    // Option Branch
    oPmhBrowseBch = {
        Title: ['company/branch/branch', 'tBCHTitle'],
        Table: {Master:'TCNMBranch', PK:'FTBchCode'},
        Join: {
            Table: ['TCNMBranch_L'],
            On: ['TCNMBranch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
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
            Perpage: 5,
            OrderBy: ['TCNMBranch.FDCreateOn'],
            SourceOrder: "DESC"
        },
        CallBack:{
            ReturnType  : 'S',
            Value       : ["ohdAdjStkSubBchCodeTo", "TCNMBranch.FTBchCode"],
            Text        : ["ohdAdjStkSubBchNameTo", "TCNMBranch_L.FTBchName"]
        },
        NextFunc:{
            FuncName: 'JSxAdjStkSubCallbackAfterSelectBch',
            ArgReturn: ['FTBchCode', 'FTBchName']
        },
        // RouteFrom: 'promotion',
        RouteAddNew: 'branch',
        BrowseLev: 2
    };
    // Option Branch
    JCNxBrowseData('oPmhBrowseBch');

});

// กลุ่มร้านค้า
$('#obtAdjStkSubBrowseMch').click(function(){
    tOldMchCkChange = $("#oetMchCode").val();
    // Option merchant
    oAdjStkSubBrowseMch = {
        Title: ['company/warehouse/warehouse', 'tWAHBwsMchTitle'],
        Table: {Master:'TCNMMerchant', PK:'FTMerCode'}, 
        Join: {
            Table: ['TCNMMerchant_L'], 
            On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits]
        },
        Where: {
            Condition: ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '"+$("#ohdAdjStkSubBchCode").val()+"') != 0"]
        },
        GrideView: {
            ColumnPathLang: 'company/warehouse/warehouse',
            ColumnKeyLang: ['tWAHBwsMchCode', 'tWAHBwsMchNme'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
            DataColumnsFormat: ['',''],
            Perpage: 5,
            OrderBy: ['TCNMMerchant.FTMerCode'],
            SourceOrder: "ASC"
        },
        CallBack:{
            ReturnType: 'S',
            Value: ["oetAdjStkSubMchCode", "TCNMMerchant.FTMerCode"],
            Text: ["oetAdjStkSubMchName", "TCNMMerchant_L.FTMerName"]
        },
        NextFunc:{
            FuncName:'JSxAdjStkSubCallbackAfterSelectMer',
            ArgReturn:['FTMerCode', 'FTMerName']
        },
        BrowseLev: 1
    };
    // Option merchant
    JCNxBrowseData('oAdjStkSubBrowseMch');
});

// ร้านค้า
$('#obtAdjStkSubBrowseShp').click(function(){
    console.log('Mer: ', $("#oetAdjStkSubMchCode").val());
    // $(".modal.fade:not(#odvAdjStkSubBrowseShipAdd, #odvModalDOCPDT, #odvModalWanning)").remove();
    // Option Shop
    oAdjStkSubBrowseShp = {
        Title : ['company/shop/shop', 'tSHPTitle'],
        Table:{Master: 'TCNMShop', PK: 'FTShpCode'},
        Join :{
            Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
            On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= '+nLangEdits
            ]
        },
        Where:{
            Condition : [
                function(){
                    var tSQL = "AND TCNMShop.FTBchCode = '"+$("#ohdAdjStkSubBchCode").val()+"' AND TCNMShop.FTMerCode = '"+$("#oetAdjStkSubMchCode").val()+"'";
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
            Perpage: 5,
            OrderBy: ['TCNMShop_L.FTShpName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetAdjStkSubShpCode", "TCNMShop.FTShpCode"],
            Text: ["oetAdjStkSubShpName", "TCNMShop_L.FTShpName"]
        },
        NextFunc: {
            FuncName: 'JSxAdjStkSubCallbackAfterSelectShp',
            ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
        },
        BrowseLev: 1
    };
    // Option Shop
    JCNxBrowseData('oAdjStkSubBrowseShp');
});

// เครื่องจุดขาย
$('#obtAdjStkSubBrowsePos').click(function(){ 
    // $(".modal.fade:not(#odvAdjStkSubBrowseShipAdd, #odvModalDOCPDT, #odvModalWanning)").remove();
    // Option Shop
    oAdjStkSubBrowsePos = {
        Title: ['pos/posshop/posshop', 'tPshTBPosCode'],
        Table: { Master:'TVDMPosShop', PK:'FTPosCode' },
        Join: {
            Table: ['TCNMPos', 'TCNMPosLastNo', 'TCNMWaHouse', 'TCNMWaHouse_L'],
            On:['TVDMPosShop.FTPosCode = TCNMPos.FTPosCode',
                'TVDMPosShop.FTPosCode = TCNMPosLastNo.FTPosCode',
                'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTWahStaType = 6',
                'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= '+nLangEdits
            ]
        },
        Where: {
            Condition: [
                function(){
                    var tSQL = "AND TVDMPosShop.FTBchCode = '"+$("#ohdAdjStkSubBchCode").val()+"' AND TVDMPosShop.FTShpCode = '"+$("#oetAdjStkSubShpCode").val()+"'";
                    /*if($("#oetShpCodeEnd").val()!=""){
                        if($("#oetShpCodeStart").val()==$("#oetShpCodeEnd").val()){
                            if($("#oetPosCodeEnd").val()!=""){
                                tSQL += " AND TVDMPosShop.FTPosCode != '"+$("#oetPosCodeEnd").val()+"'";
                            }
                        }
                    }*/
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
            DisabledColumns: [2, 3, 4, 5],
            Perpage: 5,
            OrderBy: ['TVDMPosShop.FTPosCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetAdjStkSubPosCode", "TVDMPosShop.FTPosCode"],
            Text: ["oetAdjStkSubPosName", "TCNMPosLastNo.FTPosComName"]
        },
        NextFunc: {
            FuncName: 'JSxAdjStkSubCallbackAfterSelectPos',
            ArgReturn: ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName']
        },
        BrowseLev: 1

    };
    // Option Shop
    JCNxBrowseData('oAdjStkSubBrowsePos');
});

// คลังสินค้า
$('#obtAdjStkSubBrowseWah').click(function(){
    // $(".modal.fade:not(#odvAdjStkSubBrowseShipAdd, #odvModalDOCPDT, #odvModalWanning)").remove();
    // Option WareHouse
    oAdjStkSubBrowseWah = {
        Title: ['company/warehouse/warehouse', 'tWAHTitle'],
        Table: { Master:'TCNMWaHouse', PK:'FTWahCode'},
        Join: {
            Table: ['TCNMWaHouse_L'],
            On:['TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits]
        },
        Where: {
            Condition: [
                " AND TCNMWaHouse.FTBchCode = '"+$('#ohdAdjStkSubBchCodeTo').val()+"' "
                // function(){
                //     var tSQL = "";
                //     if( $('#ohdAdjStkSubUsrLevel').val() != "HQ" ){
                //         tSQL += " AND TCNMWaHouse.FTBchCode = '"+$('#ohdAdjStkSubBchCodeCreate').val()+"' ";
                //     }
                //     // if( ($("#oetAdjStkSubShpCode").val() == '') && ($("#oetAdjStkSubPosCode").val() == '') ){ // Branch Wah
                //     //     tSQL += " AND TCNMWaHouse.FTWahStaType IN (1,2,5)";
                //     // }
                    
                //     // if( ($("#oetAdjStkSubShpCode").val() != '') && ($("#oetAdjStkSubPosCode").val() == '') ){ // Shop Wah
                //     //     tSQL += " AND TCNMWaHouse.FTWahStaType IN (4)";
                //     //     tSQL += " AND TCNMWaHouse.FTWahRefCode = '"+$('#oetAdjStkSubShpCode').val()+"'";
                //     // }
                    
                //     // if( ($("#oetAdjStkSubShpCode").val() != '') && ($("#oetAdjStkSubPosCode").val() != '') ){ // Pos(vending) Wah
                //     //     tSQL += " AND TCNMWaHouse.FTWahStaType IN (6)";
                //     //     tSQL += " AND TCNMWaHouse.FTWahRefCode = '"+$('#oetAdjStkSubPosCode').val()+"'";
                //     // }

                //     if( $('#ohdAdjStkSubBchCodeTo').val() != '' ){
                //         tSQL += " AND TCNMWaHouse.FTWahRefCode = '"+$('#ohdAdjStkSubBchCodeTo').val()+"' ";
                //     }

                //     return tSQL;
                // }
            ]
        },
        GrideView:{
            ColumnPathLang: 'company/warehouse/warehouse',
            ColumnKeyLang: ['tWahCode','tWahName'],
            DataColumns: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['',''],
            ColumnsSize: ['15%','75%'],
            Perpage: 5,
            WidthModal: 50,
            OrderBy: ['TCNMWaHouse.FDCreateOn'],
            SourceOrder: "DESC"
        },
        CallBack:{
            ReturnType: 'S',
            Value: ["oetAdjStkSubWahCodeTo","TCNMWaHouse.FTWahCode"],
            Text: ["oetAdjStkSubWahNameTo","TCNMWaHouse_L.FTWahName"]
        },
        NextFunc:{
            FuncName: 'JSxAdjStkSubCallbackAfterSelectWah',
            ArgReturn: []
        },
        RouteAddNew: 'warehouse',
        BrowseLev: nStaAdjStkSubBrowseType,
        // DebugSQL : false
    };
    // Option WareHouse
    JCNxBrowseData('oAdjStkSubBrowseWah');
});

// เหตุผล
$('#obtAdjStkSubBrowseReason').click(function(){
    // $(".modal.fade:not(#odvAdjStkSubBrowseShipAdd, #odvModalDOCPDT, #odvModalWanning)").remove();
    // Option WareHouse
    oAdjStkSubBrowseReason = {
            Title: ['other/reason/reason', 'tRSNTitle'],
            Table: { Master:'TCNMRsn', PK:'FTRsnCode' },
            Join: {
                Table: ['TCNMRsn_L'],
                On: ['TCNMRsn.FTRsnCode = TCNMRsn_L.FTRsnCode AND TCNMRsn_L.FNLngID = '+nLangEdits]
            },
            Where: {
                Condition : ["AND TCNMRsn.FTRsgCode = '008' "] // Type การตรวจนับสต็อกสินค้า
            },
            GrideView:{
                ColumnPathLang: 'other/reason/reason',
                ColumnKeyLang: ['tRSNTBCode', 'tRSNTBName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
                DisabledColumns: [],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMRsn.FDCreateOn'],
                SourceOrder: "DESC"
            },
            CallBack:{
                ReturnType: 'S',
                Value: ["oetAdjStkSubReasonCode", "TCNMRsn.FTRsnCode"],
                Text: ["oetAdjStkSubReasonName", "TCNMRsn_L.FTRsnName"]
            },
            /*NextFunc:{
                FuncName:'JSxCSTAddSetAreaCode',
                ArgReturn:['FTRsnCode']
            },*/
            // RouteFrom : 'cardShiftChange',
            RouteAddNew : 'reason',
            BrowseLev : nStaAdjStkSubBrowseType
    };
    // Option WareHouse
    JCNxBrowseData('oAdjStkSubBrowseReason');
});

/*=========================== End Browse Options =============================*/

/*=================== Begin Callback Browse ==================================*/
/**
 * สาขา
 * Functionality : Process after shoose branch
 * Parameters : -
 * Creator : 22/05/2019 piya(tiger)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSubCallbackAfterSelectBch(poJsonData) {
    
    if (poJsonData != "NULL") {
        // aData = JSON.parse(poJsonData);
        // tAddBch = aData[0];
        // tAddSeqNo = aData[1];
        $('#oetAdjStkSubWahCodeTo').val('');
        $('#oetAdjStkSubWahNameTo').val('');
    }
    
    // var tBchCode = $('#ohdAdjStkSubBchCode').val();
    // var tMchName = $('#oetAdjStkSubMchName').val();
    // var tShpName = $('#oetAdjStkSubShpName').val();
    // var tPosName = $('#oetAdjStkSubPosName').val();
    // var tWahName = $('#oetAdjStkSubWahName').val();
    
    // $('#obtAdjStkSubBrowseMch').attr('disabled', true);
    // $('#obtAdjStkSubBrowseShp').attr('disabled', true);
    // $('#obtAdjStkSubBrowsePos').attr('disabled', true);
    // $('#obtAdjStkSubBrowseWah').attr('disabled', true);

}

/**
 * กลุ่มร้านค้า
 * Functionality : Process after shoose merchant
 * Parameters : -
 * Creator : 22/05/2019 piya(tiger)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSubCallbackAfterSelectMer(poJsonData) {
    
    if (poJsonData != "NULL") {
        aData = JSON.parse(poJsonData);
        tAddBch = aData[0];
        tAddSeqNo = aData[1];
    }
    
    var tBchCode = $('#ohdAdjStkSubBchCode').val();
    var tMchName = $('#oetAdjStkSubMchName').val();
    var tShpName = $('#oetAdjStkSubShpName').val();
    var tPosName = $('#oetAdjStkSubPosName').val();
    var tWahName = $('#oetAdjStkSubWahName').val();
    
    $('#obtAdjStkSubBrowseShp').attr('disabled', true);
    $('#obtAdjStkSubBrowsePos').attr('disabled', true);
    $('#obtAdjStkSubBrowseWah').attr('disabled', true);
    
    if(JStCMNUserLevel() == 'HQ' || JStCMNUserLevel() == 'BCH'){
        if(tMchName != ''){
            $('#obtAdjStkSubBrowseShp').attr('disabled', false);
            $('#obtAdjStkSubBrowseWah').attr('disabled', true);
        }else{
            $('#obtAdjStkSubBrowseWah').attr('disabled', false);
        }
        $('#oetAdjStkSubShpCode, #oetAdjStkSubShpName').val('');
        $('#oetAdjStkSubPosCode, #oetAdjStkSubPosName').val('');
        $('#oetAdjStkSubWahCode, #oetAdjStkSubWahName').val('');
    }
}

/**
 * ร้านค้า
 * Functionality : Process after shoose shop
 * Parameters : -
 * Creator : 22/05/2019 piya(tiger)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSubCallbackAfterSelectShp(poJsonData) {
    
    var aData, tResAddBch, tResAddSeqNo, tResWahCode, tResWahName;
    if (poJsonData != "NULL") {
        aData = JSON.parse(poJsonData);
        tResAddBch = aData[0];
        tResAddSeqNo = aData[1];
        tResWahCode = aData[3];
        tResWahName = aData[4];
    }else{
        $('#oetAdjStkSubWahCode, #oetAdjStkSubWahName').val('');
    }
    console.log('aData: ', aData);
    $('#ohdAdjStkSubWahCodeInShp').val(tResWahCode);
    $('#ohdAdjStkSubWahNameInShp').val(tResWahName);
    var tBchCode = $('#ohdAdjStkSubBchCode').val();
    var tMchName = $('#oetAdjStkSubMchName').val();
    var tShpName = $('#oetAdjStkSubShpName').val();
    var tPosName = $('#oetAdjStkSubPosName').val();
    var tWahName = $('#oetAdjStkSubWahName').val();
    
    $('#obtAdjStkSubBrowsePos').attr('disabled', true);
    $('#obtAdjStkSubBrowseWah').attr('disabled', false);
    
    if(JStCMNUserLevel() == 'HQ' || JStCMNUserLevel() == 'BCH'){
        if(tShpName != ''){
            $('#obtAdjStkSubBrowsePos').attr('disabled', false);
            $('#obtAdjStkSubBrowseWah').attr('disabled', true);
            $('#oetAdjStkSubWahCode').val(tResWahCode);
            $('#oetAdjStkSubWahName').val(tResWahName);
        }else{
            $('#oetAdjStkSubWahCode, #oetAdjStkSubWahName').val('');
        }
        $('#oetAdjStkSubPosCode, #oetAdjStkSubPosName').val('');
    }
}

/**
 * เครื่องจุดขาย
 * Functionality : Process after shoose pos
 * Parameters : -
 * Creator : 22/05/2019 piya(tiger)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSubCallbackAfterSelectPos(poJsonData) {
    
    var aData, tResAddBch, tResAddSeqNo, tResWahCode, tResWahName;
    if (poJsonData != "NULL") {
        aData = JSON.parse(poJsonData);
        tResAddBch = aData[0];
        tResAddSeqNo = aData[1];
        tResWahCode = aData[3];
        tResWahName = aData[4];
    }else{
        $('#oetAdjStkSubPosCode, #oetAdjStkSubPosName').val('');
        $('#oetAdjStkSubWahCode').val($('#ohdAdjStkSubWahCodeInShp').val());
        $('#oetAdjStkSubWahName').val($('#ohdAdjStkSubWahNameInShp').val());
        return;
    }
    console.log('aData Pos: ', aData);
    
    var tBchCode = $('#ohdAdjStkSubBchCode').val();
    var tMchName = $('#oetAdjStkSubMchName').val();
    var tShpName = $('#oetAdjStkSubShpName').val();
    var tPosName = $('#oetAdjStkSubPosName').val();
    var tWahName = $('#oetAdjStkSubWahName').val();
    
    $('#obtAdjStkSubBrowseWah').attr('disabled', false);
    
    if(JStCMNUserLevel() == 'HQ' || JStCMNUserLevel() == 'BCH' || JStCMNUserLevel() == 'SHP'){
        if(tPosName != ''){
            $('#obtAdjStkSubBrowseWah').attr('disabled', true);
            $('#oetAdjStkSubWahCode').val(tResWahCode);
            $('#oetAdjStkSubWahName').val(tResWahName);
        }
    }
}

/**
 * คลังสินค้า
 * Functionality : Process after shoose warehouse
 * Parameters : -
 * Creator : 22/05/2019 piya(tiger)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSubCallbackAfterSelectWah(poJsonData) {
    
    if (poJsonData != "NULL") {
        aData = JSON.parse(poJsonData);
        tAddBch = aData[0];
        tAddSeqNo = aData[1];
    }
    
}

/**
* Functionality : Check Approve
* Parameters : -
* Creator : 24/05/2019 piya(tiger)
* Last Modified : -
* Return : Approve status
* Return Type : boolean
*/
function JSbAdjStkSubIsApv(){
    var bStatus = false;
    if(($("#ohdAdjStkSubAjhStaApv").val() == "1") || ($("#ohdAdjStkSubAjhStaApv").val() == "2")){
        bStatus = true;
    }
    return bStatus;
}

/**
* Functionality : Check Approve
* Parameters : -
* Creator : 24/05/2019 piya(tiger)
* Last Modified : -
* Return : Approve status
* Return Type : boolean
*/
function JSbAdjStkSubIsStaPrcStk(){
    var bStatus = false;
    if($("#ohdAdjStkSubAjhStaPrcStk").val() == "1"){
        bStatus = true;
    }
    return bStatus;
}

/**
* Functionality : Check document status
* Parameters : ptStaType is ("complete", "incomplete", "cancel")
* Creator : 24/05/2019 piya(tiger)
* Last Modified : -
* Return : Document status
* Return Type : boolean
*/
function JSbAdjStkSubIsStaDoc(ptStaType){
    var bStatus = false;
    if(ptStaType == "complete"){
        if($("#ohdAdjStkSubAjhStaDoc").val() == "1"){
            bStatus = true;
        }
        return bStatus;
    }
    if(ptStaType == "incomplete"){
        if($("#ohdAdjStkSubAjhStaDoc").val() == "2"){
            bStatus = true;
        }
        return bStatus;
    }
    if(ptStaType == "cancel"){
        if($("#ohdAdjStkSubAjhStaDoc").val() == "3"){
            bStatus = true;
        }
        return bStatus;
    }
    return bStatus;
}

/**
* Functionality : Form validate
* Parameters : -
* Creator : 24/05/2019 piya(tiger)
* Last Modified : 2020/07/17 Napat(Jame)
* Return : -
* Return Type : -
*/
function JSxValidateFormAddAdjStkSub() {
    
    $('#ofmAddAdjStkSub').validate({
        focusInvalid: true,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetAdjStkSubAjhDocNo: {
                required: true,
                maxlength: 20,
                uniqueAdjStkSubCode: JCNbAdjStkSubIsCreatePage()
            },
            oetAdjStkSubAjhDocDate  : { required: true },
            oetAdjStkSubAjhDocTime  : { required: true },
            oetAdjStkSubWahNameTo   : { required: true },
            oetAdjStkSubReasonName  : { required: true },
            ohdAdjStkSubBchNameTo   : { required: true }
        },
        messages: {
            oetAdjStkSubAjhDocNo    : { "required": $('#oetAdjStkSubAjhDocNo').attr('data-validate-required') },
            oetAdjStkSubAjhDocDate  : { "required": $('#oetAdjStkSubAjhDocDate').attr('data-validate-required') },
            oetAdjStkSubAjhDocTime  : { "required": $('#oetAdjStkSubAjhDocTime').attr('data-validate-required') },
            oetAdjStkSubWahNameTo   : { "required": $('#oetAdjStkSubWahNameTo').attr('data-validate-required') },
            oetAdjStkSubReasonName  : { "required": $('#oetAdjStkSubReasonName').attr('data-validate-required') },
            ohdAdjStkSubBchNameTo   : { "required": $('#ohdAdjStkSubBchNameTo').attr('data-validate-required') }
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
            JSxAdjStkSubAddUpdateAction();
        }
    });
}

/**
 * Functionality : Add or Update
 * Parameters : route
 * Creator : 23/05/2019 Piya(Tiger)
 * Last Update : 2020/07/17 Napat(Jame)
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSubAddUpdateAction() {
    // console.log( $("#ofmAddAdjStkSub").serializeArray() );

    let nCountItemsDT = 0;
    $('.xWPdtItem').each(function(){
        nCountItemsDT++;
    });

    // Check Product In DT
    if( nCountItemsDT > 0 ){
        $.ajax({
            type: "POST",
            url: '<?php echo $tRoute; ?>',
            data: $("#ofmAddAdjStkSub").serialize(),
            cache: false,
            timeout: 0,
            success: function (tResult) {
                if (nStaAdjStkSubBrowseType != 1) {
                    var aReturn = JSON.parse(tResult);
                    var tMsgBody = aReturn["tStaMessg"];
                    if (aReturn["nStaEvent"] == 1) {
                        if ( aReturn["nStaCallBack"] == "1" || aReturn["nStaCallBack"] == null ){
                            JSvCallPageAdjStkSubEdit(aReturn["tCodeReturn"]);
                        } else if (aReturn["nStaCallBack"] == "2") {
                            JSvCallPageAdjStkSubAdd();
                        } else if (aReturn["nStaCallBack"] == "3") {
                            JSvCallPageAdjStkSubList();
                        }
                    } else if (aReturn["nStaEvent"] == 905) {
                        $('#odvASTModalAlertDateTime .modal-body').html(tMsgBody);
                        $('#odvASTModalAlertDateTime').modal('show');

                        $('.xWASTModalConfirmAlertDateTime').off('click');
                        $('.xWASTModalConfirmAlertDateTime').on('click',function(){
                            JSxASTUpdateDateTimeAllDT();
                        });

                    } else {
                        FSvCMNSetMsgWarningDialog(tMsgBody);
                    }
                } else {
                    JCNxBrowseData(tCallAdjStkSubBackOption);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        FSvCMNSetMsgWarningDialog('กรุณาเลือกสินค้า');
    }
}

// Create By : Napat(Jame) 2020/07/23
// อัพเดทวันที่-เวลา ทั้งหมดในเอกสาร
function JSxASTUpdateDateTimeAllDT(){
    $.ajax({
        type: "POST",
        url: 'docASTEventUpdateDateTime',
        data: {},
        cache: false,
        timeout: 0,
        success: function (oResult) {
            var aReturn = JSON.parse(oResult);
            var tMsgBody = aReturn['tStaMessage'];
            if( aReturn['nStaQuery'] == 1 ){
                $('#odvASTModalAlertDateTime').modal('hide');
                JSxAdjStkSubAddUpdateAction();
            }else{
                FSvCMNSetMsgWarningDialog(tMsgBody);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


$('#obtAdjStkSubFilterDataCondition').click(function(){
    if( $('#oetAdjStkSubWahCodeTo').val() != '' ){
        $('#odvAdjStkSubFilterDataCondition').modal('show');

        //Clear ค่า
        $('#oetASTFilterPdtNameFrom , #oetASTFilterPdtNameTo').val('');
        $('#oetASTFilterPdtCodeFrom , #oetASTFilterPdtCodeTo').val('');

        //Clear ค่า
        $('#oetASTFilterSplNameFrom , #oetASTFilterSplNameTo').val('');
        $('#oetASTFilterSplCodeFrom , #oetASTFilterSplCodeTo').val('');

        //Clear ค่า
        $('#oetASTFilterPgpName').val('');
        $('#oetASTFilterPgpCode').val('');

        //Clear ค่า
        $('#oetASTFilterPlcName').val('');
        $('#oetASTFilterPlcCode').val('');

    }else{
        alert('กรุณาเลือกคลัง');
    }
});

$('#odvAdjStkSubSubHeadDocPanel').on('show.bs.collapse', function () {
    $('#odvAdjStkSubSubWarehousePanel').collapse('hide');
});

$('#odvAdjStkSubSubWarehousePanel').on('show.bs.collapse', function () {
    $('#odvAdjStkSubSubHeadDocPanel').collapse('hide');
});

$('#obtAdjStkSubConfirmFilter').click(function(){
    JSxASTEventAddProducts();
});


/////////////// Browse Filter Product ///////////////

$('#obtASTBrowseFilterProductFrom').click(function(){
    JSxAdjStkSubBrowsePdt('from');
});

$('#obtASTBrowseFilterProductTo').click(function(){
    JSxAdjStkSubBrowsePdt('to');
});

// Browse Supplier
$('#obtASTBrowseFilterSupplierFrom').click(function(){
    JSxASTBrowseFilterSupplier('from');
});

$('#obtASTBrowseFilterSupplierTo').click(function(){
    JSxASTBrowseFilterSupplier('to');
});

function JSxASTBrowseFilterSupplier(ptType){

    // $('#odvAdjStkSubFilterDataCondition').modal('hide');

    var tValue = "";
    var tText  = "";

    if(ptType == 'from'){
        tValue  = 'oetASTFilterSplCodeFrom';
        tText   = 'oetASTFilterSplNameFrom';
    }else{
        tValue  = 'oetASTFilterSplCodeTo';
        tText   = 'oetASTFilterSplNameTo';
    }

    let tAgnCode     = '<?=$this->session->userdata("tSesUsrAgnCode");?>';
    let tCondition   = '';
    if(tAgnCode != ''){
        tCondition += " AND TCNMSpl.FTAgnCode = '"+tAgnCode+"' ";
    }

    oASTFilterBrowseSpl = {
        Title: ['supplier/supplier/supplier', 'tSPLTitle'],
        Table: {Master:'TCNMSpl', PK:'FTSplCode'},
        Join: {
            Table: ['TCNMSpl_L'],
            On: ['TCNMSpl.FTSplCode = TCNMSpl_L.FTSplCode AND TCNMSpl_L.FNLngID = '+nLangEdits]
        },
        Where: {
            Condition: [tCondition]
        },
        GrideView:{
            ColumnPathLang: 'supplier/supplier/supplier',
            ColumnKeyLang: ['tSPLTBCode', 'tSPLTBName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMSpl.FTSplCode', 'TCNMSpl_L.FTSplName'],
            DataColumnsFormat: ['', ''],
            DisabledColumns: [],
            Perpage: 10,
            OrderBy: ['TCNMSpl.FDCreateOn DESC']
        },
        CallBack:{
            ReturnType  : 'S',
            Value       : [tValue, "TCNMSpl.FTSplCode"],
            Text        : [tText, "TCNMSpl_L.FTSplName"]
        },
        NextFunc:{
            FuncName: 'JSxASTBrowseFilterSupplierNextFunc',
            ArgReturn: ['FTSplCode', 'FTSplName']
        },
        RouteAddNew: 'supplier',
        BrowseLev: 2
    };
    JCNxBrowseData('oASTFilterBrowseSpl');
}

function JSxASTBrowseFilterSupplierNextFunc(poArgReturn){
    if(poArgReturn != "NULL"){
        var aReturn = JSON.parse(poArgReturn);
        if($('#oetASTFilterSplCodeFrom').val() == ''){
            $('#oetASTFilterSplCodeFrom').val(aReturn[0]);
            $('#oetASTFilterSplNameFrom').val(aReturn[1]);
        }
        if($('#oetASTFilterSplCodeTo').val() == ''){
            $('#oetASTFilterSplCodeTo').val(aReturn[0]);
            $('#oetASTFilterSplNameTo').val(aReturn[1]);
        }
    }else{
        $('#oetASTFilterSplCodeFrom').val('');
        $('#oetASTFilterSplNameFrom').val('');

        $('#oetASTFilterSplCodeTo').val('');
        $('#oetASTFilterSplNameTo').val('');
    }
    $('#odvAdjStkSubFilterDataCondition').modal('show');
}

// Browse Product Group
$('#obtASTBrowseFilterProductGroup').click(function(){
    JSxASTBrowseFilterPdtGrp();
});

function JSxASTBrowseFilterPdtGrp(ptType){

    // $('#odvAdjStkSubFilterDataCondition').modal('hide');

    let tValue = "oetASTFilterPgpCode";
    let tText  = "oetASTFilterPgpName";

    let tAgnCode     = '<?=$this->session->userdata("tSesUsrAgnCode");?>';
    let tCondition   = '';
    if(tAgnCode != ''){
        tCondition += " AND TCNMPdtGrp.FTAgnCode = '"+tAgnCode+"' ";
    }

    oASTFilterBrowsePdtGrp = {
        Title: ['product/pdtgroup/pdtgroup', 'tPGPTitle'],
        Table: {Master:'TCNMPdtGrp', PK:'FTPgpChain'},
        Join: {
            Table: ['TCNMPdtGrp_L'],
            On: ['TCNMPdtGrp.FTPgpChain = TCNMPdtGrp_L.FTPgpChain AND TCNMPdtGrp_L.FNLngID = '+nLangEdits]
        },
        Where: {
            Condition: [tCondition]
        },
        GrideView:{
            ColumnPathLang: 'product/pdtgroup/pdtgroup',
            ColumnKeyLang: ['tPGPTBCode', 'tPGPTBName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdtGrp.FTPgpChain', 'TCNMPdtGrp_L.FTPgpName'],
            DataColumnsFormat: ['', ''],
            DisabledColumns: [],
            Perpage: 10,
            OrderBy: ['TCNMPdtGrp.FDCreateOn DESC']
        },
        CallBack:{
            ReturnType  : 'S',
            Value       : [tValue, "TCNMPdtGrp.FTPgpChain"],
            Text        : [tText, "TCNMPdtGrp_L.FTPgpName"]
        },
        NextFunc:{
            FuncName: 'JSxASTBrowseFilterPdtGrpNextFunc',
            ArgReturn: ['FTPgpChain', 'FTPgpName']
        },
        // RouteAddNew: 'pdtgroup',
        // BrowseLev: 2
    };
    JCNxBrowseData('oASTFilterBrowsePdtGrp');
}

function JSxASTBrowseFilterPdtGrpNextFunc(poArgReturn){
    $('#odvAdjStkSubFilterDataCondition').modal('show');
}

// Browse Product Location
$('#obtASTBrowseFilterProductLocation').click(function(){
    JSxASTBrowseFilterPdtLoc();
});

function JSxASTBrowseFilterPdtLoc(ptType){

    // $('#odvAdjStkSubFilterDataCondition').modal('hide');

    let tValue = "oetASTFilterPlcCode";
    let tText  = "oetASTFilterPlcName";

    oASTFilterBrowsePdtGrp = {
        Title: ['product/pdtlocation/pdtlocation', 'tLOCTitle'],
        Table: {Master:'TCNMPdtLoc', PK:'FTPlcCode'},
        Join: {
            Table: ['TCNMPdtLoc_L'],
            On: ['TCNMPdtLoc.FTPlcCode = TCNMPdtLoc_L.FTPlcCode AND TCNMPdtLoc_L.FNLngID = '+nLangEdits]
        },
        GrideView:{
            ColumnPathLang: 'product/pdtlocation/pdtlocation',
            ColumnKeyLang: ['tLOCFrmLocCode', 'tLOCFrmLocName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdtLoc.FTPlcCode', 'TCNMPdtLoc_L.FTPlcName'],
            DataColumnsFormat: ['', ''],
            DisabledColumns: [],
            Perpage: 5,
            OrderBy: ['TCNMPdtLoc.FDCreateOn DESC']
        },
        CallBack:{
            ReturnType  : 'S',
            Value       : [tValue, "TCNMPdtLoc.FTPlcCode"],
            Text        : [tText, "TCNMPdtLoc_L.FTPlcName"]
        },
        NextFunc:{
            FuncName: 'JSxASTBrowseFilterPdtPlcNextFunc',
            ArgReturn: ['FTPlcCode', 'FTPlcName']
        },
        // RouteAddNew: 'pdtgroup',
        // BrowseLev: 2
    };
    JCNxBrowseData('oASTFilterBrowsePdtGrp');
}

function JSxASTBrowseFilterPdtPlcNextFunc(poArgReturn){
    $('#odvAdjStkSubFilterDataCondition').modal('show');
}

$('#ocbASTUsePdtStkCard').change(function() {
    if(this.checked){
        $('.xWASTDisabledOnCheckUsePdtStkCard').attr('disabled',false);
    }else{
        $('.xWASTDisabledOnCheckUsePdtStkCard').attr('disabled',true);
    }
});

/////////////// Browse Filter Product ///////////////

function JSxAdjStkSubPrintDoc(){
    var aInfor = [
        { "Lang"        : '<?=FCNaHGetLangEdit(); ?>'},
        { "ComCode"     : '<?=FCNtGetCompanyCode(); ?>'},
        { "BranchCode"  : '<?=FCNtGetAddressBranch($tBchCode); ?>' },
        { "DocCode"     : $("#oetAdjStkSubAjhDocNo").val() }, // เลขที่เอกสาร
        { "DocBchCode"  : '<?=$tBchCode;?>'}
    ];
    window.open($("#ohdBaseUrl").val() + "formreport/Frm_SQL_ALLMPdtBillSubChkStk?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
}

</script>