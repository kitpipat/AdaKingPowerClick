
<script>


function JSxPdtFhnChqConsNextFuncBrowseBch(poDataNextfunc) {
        if (poDataNextfunc == 'NULL') {
            $('#obtInvPdtFhnBrowseWaHouse').attr('disabled',true);
            $('#obtInvPdtFhnBrowseProduct').attr('disabled',true);
        } else {
            $('#obtInvPdtFhnBrowseWaHouse').removeAttr('disabled');
            $('#obtInvPdtFhnBrowseProduct').removeAttr('disabled');
        }
        return;
    }
    //แสดงรายการสินค้าแฟชั่น
    function JSvInvMmtPdtFhnDetail(pnKey){

       var tPdtCode = $('#otrReason'+pnKey).data('code');
       var tPdtName = $('#otrReason'+pnKey).data('name');
       var tBchCode = $('#otrReason'+pnKey).data('bchcode');
       var tBchName = $('#otrReason'+pnKey).data('bchname');
       var tWahCode = $('#otrReason'+pnKey).data('wahcode');
       var tWahName = $('#otrReason'+pnKey).data('wahname');
       
        $('#oetInvPdtFhnPdtCode').val(tPdtCode);
        $('#olbPdtFhnPdtCode').text(tPdtCode);
        $('#olbPdtFhnPdtName').text(tPdtName);
        $('#oetInvPdtFhnWahCodeSelect').val(tWahCode);
        $('#oetInvPdtFhnWahNameSelect').val(tWahName);
        $('#oetInvPdtFhnBchCodeSelect').val(tBchCode);
        $('#oetInvPdtFhnBchNameSelect').val(tBchName);
        JSvMmtPDtFashionDataTable();

    }

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 13/09/2018 wasin
//Return : View
//Return Type : View
function JSvInvFhnPdtClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageFhnPdt .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน

            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageFhnPdt .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvMmtPDtFashionDataTable(nPageCurrent);
}



    function JSvMmtPDtFashionDataTable(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
      var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
       var tPdtCode = $('#oetInvPdtFhnPdtCode').val();
       var tBchCode = $('#oetInvPdtFhnBchCodeSelect').val();
       var tWahCode = $('#oetInvPdtFhnWahCodeSelect').val();
       var tFhnRefCode = $('#oetInvPdtFhnRefCode').val();
       var tSeaCode = $('#oetInvFhnPdtSeasonCode').val();
       var tClrCode = $('#oetInvFhnPdtColorCode').val();
       var tSzeCode = $('#oetInvFhnPdtSizeCode').val();
       var tFabCode = $('#oetInvFhnPdtFabricCode').val();
       if($('#ocbPdtFhnStaUse').prop('checked')==true){
        var nPdtFhnStaUse = 1;
       }else{
        var nPdtFhnStaUse = 2;
       }

       var oDataFileter = {
                    tPdtCode:tPdtCode,
                    tBchCode:tBchCode,
                    tWahCode:tWahCode,
                    tFhnRefCode:tFhnRefCode,
                    tSeaCode:tSeaCode,
                    tClrCode:tClrCode,
                    tSzeCode:tSzeCode,
                    tFabCode:tFabCode,
                    nPdtFhnStaUse:nPdtFhnStaUse
        }

        JCNxOpenLoading();
            $.ajax({
                type:'POST',
                url:'mmtINVPdtFhnDataTableList',
                data:{
                    tPdtCode:tPdtCode,
                    oDataFileter:oDataFileter,
                    nPageCurrent: nPageCurrent,
                },
                cache: false,
                timeout: 0,
                async: false,
                success:function(tResult){
                    $('#odvPdtFhnDataTable').html(tResult);
                    $('#odvInvMmtModalPdtFhn').modal('show');
                    JCNxCloseLoading();
                }
            });

        }
    }


    // =========================================== Event Browse Multi Branch ===========================================
    $('#obtInvPdtFhnBrowseBranch').unbind().click(function(){
        // เซตค่าว่าง คลังสินค้า
        $('#oetInvPdtFhnWahStaSelectAll').val('');
        $('#oetInvPdtFhnWahCodeSelect').val('');
        $('#oetInvPdtFhnWahNameSelect').val('');


        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

            var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
            var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
            var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
            let tWhere		     = "";

            if(tUsrLevel != "HQ"){
                tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
            }else{
                tWhere = "";
            }

            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oBranchBrowseMultiOption = undefined;
            oBranchBrowseMultiOption        = {
                Title: ['company/branch/branch','tBCHTitle'],
                Table:{Master:'TCNMBranch',PK:'FTBchCode'},
                Join :{
                    Table:	['TCNMBranch_L'],
                    On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
                },
                Where: {
                    Condition: [tWhere]
                },
                GrideView:{
                    ColumnPathLang  	: 'company/branch/branch',
                    ColumnKeyLang	    : ['tBCHCode','tBCHName'],
                    ColumnsSize         : ['15%','75%'],
                    WidthModal          : 50,
                    DataColumns		    : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                    DataColumnsFormat   : ['',''],
                    OrderBy			    : ['TCNMBranch.FDCreateOn DESC'],
                    Perpage: 10,
                },
                CallBack:{
                    ReturnType: 'S',
                    Value		: ['oetInvPdtFhnBchCodeSelect','TCNMBranch.FTBchCode'],
                    Text		: ['oetInvPdtFhnBchNameSelect','TCNMBranch_L.FTBchName']
                },
                NextFunc: {
                    FuncName: 'JSxPdtFhnChqConsNextFuncBrowseBch',
                    ArgReturn: ['FTBchCode','FTBchName']
                }
            };
            JCNxBrowseData('oBranchBrowseMultiOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // =========================================== Event Browse Multi Branch ===========================================



    // =========================================== Event Browse Multi WaHouse ===========================================
     $('#obtInvPdtFhnBrowseWaHouse').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        let tBchcode    = $('#oetInvPdtFhnBchCodeSelect').val();
  

        let tTable      = "TCNMWaHouse";   

        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oWaHouseBrowseMultiOption = undefined;
            tWahWherWah                = "";
            
            if(tBchcode != ""){
                tTable  = "TCNMWaHouse";
                tBchcode = tBchcode.replace(/,/g, "','");
                tWahWherWah = "AND TCNMWaHouse.FTBchCode  IN ('"+tBchcode+"') ";
            }



            var tOrderBy    = tTable + ".FDCreateOn DESC";

            oWaHouseBrowseMultiOption        = {
                Title: ['company/warehouse/warehouse','tWAHSubTitle'],
                Table:{Master:tTable,PK:'FTWahCode'},
                Join :{
                    Table:	['TCNMWaHouse_L', 'TCNMBranch_L'],
                    On:['TCNMWaHouse_L.FTWahCode = "'+tTable+'".FTWahCode AND "'+tTable+'".FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits,
                        'TCNMBranch_L.FTBchCode = "'+tTable+'".FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
                },
                Where :{
                    Condition : [tWahWherWah]
                },
                GrideView:{
                    ColumnPathLang  	: 'company/warehouse/warehouse',
                    ColumnKeyLang	    : ['tWahCode','tWahName'],
                    ColumnsSize         : ['25%', '50%'],
                    WidthModal          : 50,
                    DataColumns		    : [ '"'+tTable+'".FTWahCode','TCNMWaHouse_L.FTWahName'],
                    DataColumnsFormat   : ['',''],
                    OrderBy			    : [ tOrderBy, 'TCNMBranch_L.FTBchName ASC, TCNMWaHouse_L.FTWahCode ASC'],
                    Perpage             : 10,
                },
                CallBack:{
                    StausAll    : ['oetInvPdtFhnWahStaSelectAll'],
                    Value		: ['oetInvPdtFhnWahCodeSelect','"'+tTable+'".FTWahCode'],
                    Text		: ['oetInvPdtFhnWahNameSelect','TCNMWaHouse_L.FTWahName']
                }
            };
            JCNxBrowseMultiSelect('oWaHouseBrowseMultiOption');
            $('#obtInvMultiBrowseWaHouse').attr("disabled", false);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // =========================================== Event Browse Multi WaHouse ===========================================



// Click Browse Product Sub Class
$('#obInvFhnPdtSeasonBrows').unbind().click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    window.oFhnPdtSeasonBrowsOption = oFhnPdtSeasonBrows({
        'tReturnInputCode': 'oetInvFhnPdtSeasonCode',
        'tReturnInputName': 'oetInvFhnPdtSeasonName',
        'tNextFuncName': ''
    });
    JCNxBrowseData('oFhnPdtSeasonBrowsOption');
} else {
    JCNxShowMsgSessionExpired();
}
});


// Option Add Browse Product Sub Class
var oFhnPdtSeasonBrows = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;
    var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
    var tNextFuncName = poReturnInput.tNextFuncName;
    var tConditionWhere = '';
        if(tSesUsrAgnCode!=''){
            tConditionWhere +=" AND ( TFHMPdtSeason.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TFHMPdtSeason.FTAgnCode,'') = '' ) ";
        }

    var oOptionReturn = {
        Title: ['product/product/product', 'tFhnPdtDataTableSeason'],
        Table: {
            Master: 'TFHMPdtSeason',
            PK: 'FTSeaCode'
        },
        Join: {
                Table: ['TFHMPdtSeason_L'],
                On: [
                    'TFHMPdtSeason.FTSeaChain = TFHMPdtSeason_L.FTSeaChain AND TFHMPdtSeason_L.FNLngID = ' + nLangEdits,
                ]
        },
        Where: {
            Condition: [tConditionWhere]
        },
        GrideView: {
            ColumnPathLang: 'product/product/product',
            ColumnKeyLang: ['tFhnPdtDataTableSeasonCode', 'tFhnPdtDataTableSeasonName'],
            ColumnsSize: ['20%', '80%'],
            DataColumns: ['TFHMPdtSeason.FTSeaCode', 'TFHMPdtSeason_L.FTSeaName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TFHMPdtSeason.FTSeaCode'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TFHMPdtSeason.FTSeaCode"],
            Text: [tInputReturnName, "TFHMPdtSeason_L.FTSeaName"],
        },
        NextFunc: {
            FuncName: tNextFuncName
        },
        // RouteAddNew: 'productNoSaleEvent',
        BrowseLev: 1
    }
    return oOptionReturn;
}



// Click Browse Product Sub Class
$('#obInvFhnPdtFabricBrows').unbind().click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    window.oFhnPdtFabricBrowsOption = oFhnPdtFabricBrows({
        'tReturnInputCode': 'oetInvFhnPdtFabricCode',
        'tReturnInputName': 'oetInvFhnPdtFabricName',
        'tNextFuncName': ''
    });
    JCNxBrowseData('oFhnPdtFabricBrowsOption');
} else {
    JCNxShowMsgSessionExpired();
}
});


// Option Add Browse Product Sub Class
var oFhnPdtFabricBrows = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;
    var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
    var tNextFuncName = poReturnInput.tNextFuncName;
    var tConditionWhere = '';
        if(tSesUsrAgnCode!=''){
            tConditionWhere +=" AND  ( TFHMPdtFabric.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TFHMPdtFabric.FTAgnCode,'') = '' ) ";
        }

    var oOptionReturn = {
        Title: ['product/product/product', 'tFhnPdtDataTableFabric'],
        Table: {
            Master: 'TFHMPdtFabric',
            PK: 'FTFabCode'
        },
        Join: {
                Table: ['TFHMPdtFabric_L'],
                On: [
                    'TFHMPdtFabric.FTFabCode = TFHMPdtFabric_L.FTFabCode AND TFHMPdtFabric_L.FNLngID = ' + nLangEdits,
                ]
        },
        Where: {
            Condition: [tConditionWhere]
        },
        GrideView: {
            ColumnPathLang: 'product/product/product',
            ColumnKeyLang: ['tFhnPdtDataTableFabricCode', 'tFhnPdtDataTableFabricName'],
            ColumnsSize: ['20%', '80%'],
            DataColumns: ['TFHMPdtFabric.FTFabCode', 'TFHMPdtFabric_L.FTFabName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TFHMPdtFabric.FTFabCode'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TFHMPdtFabric.FTFabCode"],
            Text: [tInputReturnName, "TFHMPdtFabric_L.FTFabName"],
        },
        NextFunc: {
            FuncName: tNextFuncName
        },
        // RouteAddNew: 'productNoSaleEvent',
        BrowseLev: 1
    }
    return oOptionReturn;
}


// Click Browse Product Sub Class
$('#obInvFhnPdtColorBrows').unbind().click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    window.oFhnPdtColorBrowsOption = oFhnPdtColorBrows({
        'tReturnInputCode': 'oetInvFhnPdtColorCode',
        'tReturnInputName': 'oetInvFhnPdtColorName',
        'tNextFuncName': ''
    });
    JCNxBrowseData('oFhnPdtColorBrowsOption');
} else {
    JCNxShowMsgSessionExpired();
}
});


// Option Add Browse Product Sub Class
var oFhnPdtColorBrows = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;
    var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
    var tNextFuncName = poReturnInput.tNextFuncName;
    var tConditionWhere = '';
        if(tSesUsrAgnCode!=''){
            tConditionWhere +=" AND  ( TCNMPdtColor.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TCNMPdtColor.FTAgnCode,'') = '' )";
        }

    var oOptionReturn = {
        Title: ['product/product/product', 'tFhnPdtDataTableColor'],
        Table: {
            Master: 'TCNMPdtColor',
            PK: 'FTClrCode'
        },
        Join: {
                Table: ['TCNMPdtColor_L'],
                On: [
                    'TCNMPdtColor.FTClrCode = TCNMPdtColor_L.FTClrCode AND TCNMPdtColor_L.FNLngID = ' + nLangEdits,
                ]
        },
        Where: {
            Condition: [tConditionWhere]
        },
        GrideView: {
            ColumnPathLang: 'product/product/product',
            ColumnKeyLang: ['tFhnPdtDataTableColorCode', 'tFhnPdtDataTableColorName'],
            ColumnsSize: ['20%', '80%'],
            DataColumns: ['TCNMPdtColor.FTClrCode', 'TCNMPdtColor_L.FTClrName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TCNMPdtColor.FTClrCode'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtColor.FTClrCode"],
            Text: [tInputReturnName, "TCNMPdtColor_L.FTClrName"],
        },
        NextFunc: {
            FuncName: tNextFuncName
        },
        // RouteAddNew: 'productNoSaleEvent',
        BrowseLev: 1
    }
    return oOptionReturn;
}

    
// Click Browse Product Sub Class
$('#obInvFhnPdtSizeBrows').unbind().click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    window.oFhnPdtSizeBrowsOption = oFhnPdtSizeBrows({
        'tReturnInputCode': 'oetInvFhnPdtSizeCode',
        'tReturnInputName': 'oetInvFhnPdtSizeName',
        'tNextFuncName': ''
    });
    JCNxBrowseData('oFhnPdtSizeBrowsOption');
} else {
    JCNxShowMsgSessionExpired();
}
});


// Option Add Browse Product Sub Class
var oFhnPdtSizeBrows = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;
    var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
    var tNextFuncName = poReturnInput.tNextFuncName;
    var tConditionWhere = '';
        if(tSesUsrAgnCode!=''){
            tConditionWhere +=" AND  ( TCNMPdtSize.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TCNMPdtSize.FTAgnCode,'') = '' ) ";
        }

    var oOptionReturn = {
        Title: ['product/product/product', 'tFhnPdtDataTableColor'],
        Table: {
            Master: 'TCNMPdtSize',
            PK: 'FTPszCode'
        },
        Join: {
                Table: ['TCNMPdtSize_L'],
                On: [
                    'TCNMPdtSize.FTPszCode = TCNMPdtSize_L.FTPszCode AND TCNMPdtSize_L.FNLngID = ' + nLangEdits,
                ]
        },
        Where: {
            Condition: [tConditionWhere]
        },
        GrideView: {
            ColumnPathLang: 'product/product/product',
            ColumnKeyLang: ['tFhnPdtDataTableColorCode', 'tFhnPdtDataTableColorName'],
            ColumnsSize: ['20%', '80%'],
            DataColumns: ['TCNMPdtSize.FTPszCode', 'TCNMPdtSize_L.FTPszName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TCNMPdtSize.FTPszCode'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtSize.FTPszCode"],
            Text: [tInputReturnName, "TCNMPdtSize_L.FTPszName"],
        },
        NextFunc: {
            FuncName: tNextFuncName,
        },
        // RouteAddNew: 'productNoSaleEvent',
        BrowseLev: 1
    }
    return oOptionReturn;
}


    </script>