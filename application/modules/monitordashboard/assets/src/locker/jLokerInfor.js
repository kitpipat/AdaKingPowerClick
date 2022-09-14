var tDLKBaseUrl     = $('#ohdDLKBaseURL').val();
var tDLKLangEdit    = $('#ohdDLKLangEdit').val();
$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    // Check เปิดปิด Menu ตาม Pin
    JSxCheckPinMenuClose();
    // Set Default Select Picker
    $('.selectpicker').selectpicker('refresh');

    // Option Browse Branch
    var oDLKBrowseBrach     = function(poReturnInput){
        let tDLKBchInputReturnCode  = poReturnInput.tReturnInputCode;
        let tDLKBchInputReturnName  = poReturnInput.tReturnInputName;
        let tDLKBchNextFuncName     = poReturnInput.tNextFuncName;
        let aDLKBchArgReturn        = poReturnInput.aArgReturn;
        let oDLKBchOptionReturn     = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table: {Master:'TCNMBranch',PK:'FTBchCode'},
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+tDLKLangEdit]
            },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMBranch_L.FTBchCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tDLKBchInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tDLKBchInputReturnName,"TCNMBranch_L.FTBchName"]
            },
            NextFunc : {
                FuncName    : tDLKBchNextFuncName,
                ArgReturn   : aDLKBchArgReturn
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        return oDLKBchOptionReturn;
    }

    // Option Browse Merchant
    var oDLKBrowseMerchant  = function(poReturnInput){
        let tDLKMerInputReturnCode  = poReturnInput.tReturnInputCode;
        let tDLKMerInputReturnName  = poReturnInput.tReturnInputName;
        let tDLKMerNextFuncName     = poReturnInput.tNextFuncName;
        let aDLKMerArgReturn        = poReturnInput.aArgReturn;
        let aDLKMerBchCode          = poReturnInput.tBchCode;
        var tDLKMerWhereModal       = "";
        // สถานะกลุ่มธุรกิจต้องใช้งานเท่านั้น
        tDLKMerWhereModal   += " AND (TCNMMerchant.FTMerStaActive = 1)";
        // เช็คเงื่อนไขแสดงกลุ่มธุรกิจเฉพาะสาขาตัวเอง
        if(typeof(aDLKMerBchCode) != undefined && aDLKMerBchCode != ""){
            tDLKMerWhereModal += " AND ((SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '"+aDLKMerBchCode+"') != 0)";
        }
        var oDLKMerOptionReturn     = {
            Title:  ['company/merchant/merchant','tMerchantTitle'],
            Table:  {Master:'TCNMMerchant',PK:'FTMerCode'},
            Join:   {
                Table: ['TCNMMerchant_L'],
                On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+tDLKLangEdit]
            },
            Where : {
                Condition : [tDLKMerWhereModal]
            },
            GrideView : {
                ColumnPathLang	    : 'company/merchant/merchant',
                ColumnKeyLang	    : ['tMerCode','tMerName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
                DataColumnsFormat   : ['',''],
                Perpage			    : 5,
                OrderBy			    : ['TCNMMerchant.FTMerCode ASC'],
            },
            CallBack : {
                ReturnType	: 'S',
                Value		: [tDLKMerInputReturnCode,"TCNMMerchant.FTMerCode"],
                Text		: [tDLKMerInputReturnName,"TCNMMerchant_L.FTMerName"],
            },
            NextFunc : {
                FuncName    : tDLKMerNextFuncName,
                ArgReturn   : aDLKMerArgReturn
            },
            RouteAddNew: 'merchant',
            BrowseLev: 1
        };
        return oDLKMerOptionReturn;
    }

    // Option Browse Shop
    var obtDLKBrowseShop    = function(poReturnInput){
        let tDLKShpInputReturnCode  = poReturnInput.tReturnInputCode;
        let tDLKShpInputReturnName  = poReturnInput.tReturnInputName;
        let tDLKShpBchCode          = poReturnInput.tBchCode;
        let tDLKShpMerCode          = poReturnInput.tMerCode;
        let tDLKShpWhereModal       = "";
        // สถานะร้านค้าใช้งาน
        tDLKShpWhereModal   += " AND (TCNMShop.FTShpStaActive = 1) AND (TCNMShop.FTShpType = 5)";
        // เช็คเงื่อนไขแสดงร้านค้าในสาขาตัวเอง
        if(typeof(tDLKShpBchCode) != undefined && tDLKShpBchCode != ""){
            tDLKShpWhereModal   += " AND (TCNMShop.FTBchCode = '"+tDLKShpBchCode+"')";
        }
        // เช็คเงื่อนไขแสดงร้านค้าในกลุ่มธุรกิจตัวเอง
        if(typeof(tDLKShpMerCode) != undefined && tDLKShpMerCode != ""){
            tDLKShpWhereModal   += " AND (TCNMShop.FTMerCode = '"+tDLKShpMerCode+"')";
        }
        // ตัวแปร ออฟชั่นในการ Return
        var oDLKShpOptionReturn = {
            Title: ["company/shop/shop","tSHPTitle"],
            Table: {Master:"TCNMShop",PK:"FTShpCode"},
            Join: {
                Table: ['TCNMShop_L','TCNMWaHouse_L'],
                On: [
                    'TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = '+tDLKLangEdit,
                    'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= '+tDLKLangEdit
                ]
            },
            Where: {
                Condition: [tDLKShpWhereModal]
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
                Value   : [tDLKShpInputReturnCode,"TCNMShop.FTShpCode"],
                Text    : [tDLKShpInputReturnName,"TCNMShop_L.FTShpName"],
            },
            RouteAddNew: 'shop',
            BrowseLev : 1
        };
        return oDLKShpOptionReturn;
    }

    // Event Browse Branch
    $('#obtDLKBrowseBranch').unbind().click(function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oDLKBrowseBrachOption    = undefined;
            oDLKBrowseBrachOption           = oDLKBrowseBrach({
                'tReturnInputCode'  : 'oetDLKBchCode',
                'tReturnInputName'  : 'oetDLKBchName',
                'tNextFuncName'     : 'JSxDLKConsNextFuncBrowseBranch',
                'aArgReturn'        : ['FTBchCode','FTBchName']
            });
            JCNxBrowseData('oDLKBrowseBrachOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Branch
    $('#obtDLKBrowseMerchant').unbind().click(function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            let tDLKBchCode = $("#oetDLKBchCode").val();
            window.oDLKBrowseMerchantOption = undefined;
            oDLKBrowseMerchantOption        = oDLKBrowseMerchant({
                'tBchCode'          : tDLKBchCode,
                'tReturnInputCode'  : 'oetDLKMerCode',
                'tReturnInputName'  : 'oetDLKMerName',
                'tNextFuncName'     : 'JSxDLKConsNextFuncBrowseMerchant',
                'aArgReturn'        : ['FTMerCode','FTMerName']
            });
            JCNxBrowseData('oDLKBrowseMerchantOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Shop
    $('#obtDLKBrowseShop').unbind().click(function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            let tDLKBchCode = $("#oetDLKBchCode").val();
            let tDLKMerCode = $("#oetDLKMerCode").val();
            window.oDLKBrowseShopOption = undefined;
            oDLKBrowseShopOption        = obtDLKBrowseShop({
                'tBchCode'          : tDLKBchCode,
                'tMerCode'          : tDLKMerCode,
                'tReturnInputCode'  : 'oetDLKShopCode',
                'tReturnInputName'  : 'oetDLKShopName',
            });
            JCNxBrowseData('oDLKBrowseShopOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    JCNvDLKGetPosStatusData();
});

// Functionality: Next Behind Next Function Browse Branch
// Parameters: Event Next Function Browse
// Creator: 06/11/2019 Wasin(Yoshi)
// Return: -
// Return Type: -
function JSxDLKConsNextFuncBrowseBranch(poDataNextFunc){
    if(poDataNextFunc == 'NULL'){
        // Start Add Disable Button Browse
        $('#obtDLKBrowseMerchant').prop("disabled",true);
        $('#obtDLKBrowseShop').prop("disabled",true);
        // Clear Data Input
        $('.xWInputBranch').val('');
        $('.xWInputMerchant').val('');
        $('.xWInputShop').val('');
    }else{
        // Start Remove Disable Button Browse
        $('#obtDLKBrowseMerchant').prop("disabled",false);
        let aDataNextfunc   = JSON.parse(poDataNextFunc);
        let tDLKNewBchCode  = aDataNextfunc[0];
        let tDLKOldBchCode  = $('#oetDLKBchCodeOld').val();
        if(tDLKOldBchCode != tDLKNewBchCode){
            $('#oetDLKBchCodeOld').val(tDLKNewBchCode);
            // Start Add Disable Button Browse
            $('#obtDLKBrowseShop').prop("disabled",true);
            // Clear Data Input
            $('.xWInputMerchant').val('');
            $('.xWInputShop').val('');
        }
    }
}

// Functionality: Next Behind Next Function Browse Merchant
// Parameters: Event Next Function Browse
// Creator: 06/11/2019 Wasin(Yoshi)
// Return: -
// Return Type: -
function JSxDLKConsNextFuncBrowseMerchant(poDataNextFunc){
    if(poDataNextFunc == 'NULL'){
        // Start Add Disable Button Browse
        $('#obtDLKBrowseShop').prop("disabled",true);
        // Clear Data Input
        $('.xWInputMerchant').val('');
        $('.xWInputShop').val('');
    }else{
        // Start Remove Disable Button Browse
        $('#obtDLKBrowseShop').prop("disabled",false);
        let aDataNextfunc   = JSON.parse(poDataNextFunc);
        let tDLKNewMerCode  = aDataNextfunc[0];
        let tDLKOldMerCode  = $('#oetDLKMerCodeOld').val();
        if(tDLKOldMerCode != tDLKNewMerCode){
            $('#oetDLKMerCodeOld').val(tDLKNewMerCode);
            // Clear Data Input
            $('.xWInputShop').val('');
        }
    }
}

// Functionality: 
// Parameters: Event Next Function Browse
// Creator: 06/11/2019 Wasin(Yoshi)
// Return: -
// Return Type: -
function JCNvDLKGetPosStatusData(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "lockerInforGetDataLockerStatus",
        data: $('#ofmDLKFilterCodtion').serialize(),
        success: function (tResponseView) {
            $('#odvDLKDataShowListPos').html(tResponseView);
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

