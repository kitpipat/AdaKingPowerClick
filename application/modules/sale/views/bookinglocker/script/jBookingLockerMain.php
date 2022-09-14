<script type="text/javascript">
    var nBKLLangEdits    = '<?php echo $this->session->userdata("tLangEdit");?>';

    // Browse Option Branch
    var oBKLBrowseBranch    = function(poReturnInput){
        let tBchInputReturnCode = poReturnInput.tReturnInputCode;
        let tBchInputReturnName = poReturnInput.tReturnInputName;
        let tBchNextFuncName    = poReturnInput.tNextFuncName;
        let aBchArgReturn       = poReturnInput.aArgReturn;
        let oBchOptionReturn       = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table:{Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table:	['TCNMBranch_L'],
                On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nBKLLangEdits]
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
                Value		: [tBchInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tBchInputReturnName,"TCNMBranch_L.FTBchName"]
            },
            NextFunc : {
                FuncName    : tBchNextFuncName,
                ArgReturn   : aBchArgReturn
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        }
        return oBchOptionReturn;
    }

    // Browse Option Shop
    var oBKLBrowseShop      = function(poReturnInput){
        let tShpInputReturnCode = poReturnInput.tReturnInputCode;
        let tShpInputReturnName = poReturnInput.tReturnInputName;
        let tShpNextFuncName    = poReturnInput.tNextFuncName;
        let aShpArgReturn       = poReturnInput.aArgReturn;
        let tShpBchCode         = poReturnInput.tBchCode;
        let tWhereCondition     = "";
        if(tShpBchCode != ""){
            tWhereCondition += " AND (TCNMShop.FTBchCode = '"+tShpBchCode+"' AND TCNMShop.FTShpType = 5)"
        }else{
            tWhereCondition += " AND (TCNMShop.FTShpType = 5)";
        }
        let oShpOptionReturn    = {
            Title: ["company/shop/shop","tSHPTitle"],
            Table: {Master:"TCNMShop",PK:"FTShpCode"},
            Join: {
                Table: ['TCNMShop_L','TCNMBranch_L'],
                On: [
                    'TCNMShop_L.FTBchCode = TCNMShop.FTBchCode AND TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = '+nBKLLangEdits,
                    'TCNMShop_L.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nBKLLangEdits
                ]
            },
            Where: {
                Condition: [tWhereCondition]
            },
            GrideView: {
                ColumnPathLang      : 'company/shop/shop',
                ColumnKeyLang       : ['tSHPTBBranch','tShopCode','tShopName'],
                ColumnsSize         : ['20%','15%','55%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMBranch_L.FTBchName','TCNMShop.FTShpCode','TCNMShop_L.FTShpName'],
                DataColumnsFormat   : ['','',''],
                Perpage             : 10,
                OrderBy			    : ['TCNMShop.FTBchCode ASC','TCNMShop.FTShpCode ASC'],
            },
            CallBack: {
                ReturnType	: 'S',
                Value		: [tShpInputReturnCode,"TCNMShop.FTShpCode"],
                Text		: [tShpInputReturnName,"TCNMShop_L.FTShpName"],
            },
            NextFunc:{
                FuncName    : tShpNextFuncName,
                ArgReturn   : aShpArgReturn
            },
            RouteAddNew: 'shop',
            BrowseLev : 1
        }
        return oShpOptionReturn;
    }

    // Browse Option Pos
    var oBKLBrowsePos       = function(poReturnInput){
        let tPosBchCode         = poReturnInput.tBchCode;
        let tPosShpCode         = poReturnInput.tShpCode;
        let tPosInputReturnCode = poReturnInput.tReturnInputCode;
        let tPosInputReturnName = poReturnInput.tReturnInputName;
        let tPosNextFuncName    = poReturnInput.tNextFuncName;
        let aPosArgReturn       = poReturnInput.aArgReturn;
        let tPosWhereCondition  = " AND (TCNMPos.FTPosType = 5)";
        // Where Branch Code
        if(typeof tPosBchCode != 'undefined' && tPosBchCode != ''){
            tPosWhereCondition  += " AND (TRTMShopPos.FTBchCode = '"+tPosBchCode+"')";
        }
        // Where Shop Code
        if(typeof tPosShpCode != 'undefined' && tPosShpCode != ''){
            tPosWhereCondition  += " AND (TRTMShopPos.FTShpCode = '"+tPosShpCode+"')";
        }

        let oPosOptionReturn    = {
            Title: ["sale/bookinglocker/bookinglocker","tBKLFilterPosTitle"],
            Table: { Master:'TRTMShopPos', PK:'FTPosCode'},
            Join: {
                Table: ['TCNMPos','TCNMBranch_L','TCNMShop_L'],
                On: [
                    "TRTMShopPos.FTPosCode = TCNMPos.FTPosCode",
                    "TRTMShopPos.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = "+nBKLLangEdits,
                    "TRTMShopPos.FTBchCode = TCNMShop_L.FTBchCode AND TRTMShopPos.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = "+nBKLLangEdits
                ]
            },
            Where: {
                Condition : [tPosWhereCondition]
            },
            GrideView: {
                ColumnPathLang: 'sale/bookinglocker/bookinglocker',
                ColumnKeyLang: ['','tBKLFilterPosToBch','','tBKLFilterPosToShop','tBKLFilterPosCode'],
                ColumnsSize: ['','20%','','20%','50%'],
                WidthModal: 50,
                DataColumns: ['TRTMShopPos.FTBchCode','TCNMBranch_L.FTBchName','TRTMShopPos.FTShpCode','TCNMShop_L.FTShpName','TRTMShopPos.FTPosCode'],
                DataColumnsFormat: ['','','','',''],
                DisabledColumns: [0,2],
                Perpage: 5,
                OrderBy: ['TRTMShopPos.FTBchCode ASC','TRTMShopPos.FTShpCode ASC'],
            },
            CallBack: {
                ReturnType  : 'S',
                Value       : [tPosInputReturnCode,"TRTMShopPos.FTPosCode"],
                Text        : [tPosInputReturnName,"TRTMShopPos.FTPosCode"]
            },
            NextFunc: {
                FuncName : tPosNextFuncName,
                ArgReturn : aPosArgReturn
            },
            RouteAddNew: 'salemachine',
            BrowseLev : 1
        };
        return oPosOptionReturn;
    }

    // Browse Option Rack
    var oBKLBrowseRack      = function(poReturnInput){
        let tRakBchCode         = poReturnInput.tBchCode;
        let tRakShpCode         = poReturnInput.tShpCode;
        let tRakPosCode         = poReturnInput.tPosCode;
        let tRakInputReturnCode = poReturnInput.tReturnInputCode;
        let tRakInputReturnName = poReturnInput.tReturnInputName;
        let tRakNextFuncName    = poReturnInput.tNextFuncName;
        let aRakArgReturn       = poReturnInput.aArgReturn;
        // Where Data Branch
        let tWhereBranch        = "";
        if(typeof tRakBchCode != 'undefined' && tRakBchCode != ''){
            tWhereBranch    += " AND SPLDATA.FTBchCode = '"+tRakBchCode+"'";
        }
        // Where Data Shop
        let tWhereShop          = "";
        if(typeof tRakShpCode != 'undefined' && tRakShpCode != ''){
            tWhereShop      += " AND SPLDATA.FTShpCode = '"+tRakShpCode+"'";
        }
        // Where Data Pos
        let tWherePos           = "";
        if(typeof tRakPosCode != 'undefined' && tRakPosCode != ''){
            tWherePos       += " AND SPLDATA.FTPosCode = '"+tRakPosCode+"'";
        }
        let tWhereIn    = "";
        tWhereIn    += " ( SELECT SHPL.FTRakCode FROM( SELECT SPL.FTBchCode,SPL.FTShpCode,SPL.FTPosCode FROM TRTMShopPosLayout SPL WITH(NOLOCK) WHERE 1=1 GROUP BY SPL.FTBchCode,SPL.FTShpCode,SPL.FTPosCode ) AS SPLDATA"
        tWhereIn    += " LEFT JOIN ( SELECT SHL.FTBchCode,SHL.FTShpCode,SHL.FTRakCode FROM TRTMShopLayout SHL WITH(NOLOCK) GROUP BY SHL.FTBchCode,SHL.FTShpCode,SHL.FTRakCode ) AS SHPL";
        tWhereIn    += " ON SPLDATA.FTBchCode = SHPL.FTBchCode AND SPLDATA.FTShpCode = SHPL.FTShpCode WHERE 1=1 ";
        tWhereIn    += tWhereBranch+tWhereShop+tWherePos+' GROUP BY SHPL.FTRakCode )';
        let tRakWhereModal      = " AND (TRTMShopRack.FTRakCode IN "+tWhereIn+")";
        let oRakOptionReturn    = {
            Title: ['sale/bookinglocker/bookinglocker','tBKLFilterRakTitle'],
            Table: {Master:'TRTMShopRack',PK:'FTRakCode'},
            Join: {
                Table : ['TRTMShopRack_L'],
                On : ['TRTMShopRack.FTRakCode = TRTMShopRack_L.FTRakCode AND TRTMShopRack_L.FNLngID = '+nBKLLangEdits,]
            },
            Where: {
                Condition : [tRakWhereModal]
            },
            GrideView: {
                ColumnPathLang	    : 'sale/bookinglocker/bookinglocker',
                ColumnKeyLang	    : ['tBKLFilterRakCode','tBKLFilterRakName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TRTMShopRack.FTRakCode','TRTMShopRack_L.FTRakName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 5,
                OrderBy             : ['TRTMShopRack.FTRakCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tRakInputReturnCode,"TRTMShopRack.FTRakCode"],
                Text		: [tRakInputReturnName,"TRTMShopRack_L.FTRakName"],
            },
            RouteAddNew : 'rack',
            BrowseLev   : 1,
        };
        return oRakOptionReturn;
    }


    // Event Browse Branch
    $('#obtBKLBrowseBranch').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oBKLBrowseBranchOption   = undefined;
            oBKLBrowseBranchOption          = oBKLBrowseBranch({
                'tReturnInputCode'  : 'oetBKLBchCode',
                'tReturnInputName'  : 'oetBKLBchName',
                'tNextFuncName'     : 'JSxBKLConsNextFuncBrowseBch',
                'aArgReturn'        : ['FTBchCode','FTBchName']
            });
            JCNxBrowseData('oBKLBrowseBranchOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Shop
    $('#obtBKLBrowseShop').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            let tShpBchCode = $('#oetBKLBchCode').val();
            window.oBKLBrowseShopOption = undefined;
            oBKLBrowseShopOption      = oBKLBrowseShop({
                'tReturnInputCode'  : 'oetBKLShpCode',
                'tReturnInputName'  : 'oetBKLShpName',
                'tNextFuncName'     : 'JSxBKLConsNextFuncBrowseShp',
                'tBchCode'          : tShpBchCode,
                'aArgReturn'        : ['FTShpCode','FTShpCode'],
            });
            JCNxBrowseData('oBKLBrowseShopOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Pos
    $('#obtBKLBrowsePos').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            let tPosBchCode = $('#oetBKLBchCode').val();
            let tPosShpCode = $('#oetBKLShpCode').val();
            window.oBKLBrowsePosOption  = undefined;
            oBKLBrowsePosOption         = oBKLBrowsePos({
                'tBchCode'          : tPosBchCode,
                'tShpCode'          : tPosShpCode,
                'tReturnInputCode'  : 'oetBKLPosCode',
                'tReturnInputName'  : 'oetBKLPosName',
                'tNextFuncName'     : 'JSxBKLConsNextFuncBrowsePos',
                'aArgReturn'        : ['FTPosCode'],
            });
            JCNxBrowseData('oBKLBrowsePosOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Rack
    $('#obtBKLBrowseRack').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            let tRakBchCode = $('#oetBKLBchCode').val();
            let tRakShpCode = $('#oetBKLShpCode').val();
            let tRakPosCode = $('#oetBKLPosCode').val();
            window.oBKLBrowseRakOption  = undefined;
            oBKLBrowseRakOption         = oBKLBrowseRack({
                'tBchCode'          : tRakBchCode,
                'tShpCode'          : tRakShpCode,
                'tPosCode'          : tRakPosCode,
                'tReturnInputCode'  : 'oetBKLRakCode',
                'tReturnInputName'  : 'oetBKLRakName',
            });
            JCNxBrowseData('oBKLBrowseRakOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtBKLFilterData').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#obtBKLSubmitGetDataRack').click();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Functionality : Next Function Branch
    // Parameter : Event Next Func Modal
    // Create : 29/10/2019 Wasin(Yoshi)
    // Return : Clear Velues Data
    // Return Type : -
    function JSxBKLConsNextFuncBrowseBch(poDataNextfunc){
        if(poDataNextfunc == 'NULL'){
            // Start Add Disable Button Browse
            $('#obtBKLBrowseShop').prop("disabled",true);
            // $('#obtBKLBrowsePos').prop("disabled",true);
            // $('#obtBKLBrowseRack').prop("disabled",true);
            // Clear Data Input
            $('.xWInputBranch').val('');
            $('.xWInputShop').val('');
            $('.xWInputPos').val('');
            $('.xWInputRack').val('');
        }else{
            // Start Remove Disable Button Browse
            $('#obtBKLBrowseShop').prop("disabled",false);
            // End Remove Disable Button Browse     
            let aDataNextfunc   = JSON.parse(poDataNextfunc);
            let tBKLNewBchCode  = aDataNextfunc[0];
            let tBKLOldBchCode  = $('#oetBKLBchCodeOld').val();
            if(tBKLOldBchCode != tBKLNewBchCode){
                $('#oetBKLBchCodeOld').val(tBKLNewBchCode);
                // Start Add Disable Button Browse
                // $('#obtBKLBrowsePos').prop("disabled",true);
                // $('#obtBKLBrowseRack').prop("disabled",true);
                // Clear Data Input
                $('.xWInputShop').val('');
                $('.xWInputPos').val('');
                $('.xWInputRack').val('');
            }
        }
        return;
    }

    // Functionality : Next Function Shop
    // Parameter : Event Next Func Modal
    // Create : 29/10/2019 Wasin(Yoshi)
    // Return : Clear Velues Data
    // Return Type : -
    function JSxBKLConsNextFuncBrowseShp(poDataNextfunc){
        if(poDataNextfunc == 'NULL'){
            // Start Add Disable Button Browse
            $('#obtBKLBrowsePos').prop("disabled",true);
            // $('#obtBKLBrowseRack').prop("disabled",true);
            // Clear Data Input
            $('.xWInputShop').val('');
            $('.xWInputPos').val('');
            $('.xWInputRack').val('');
        }else{
            // Start Remove Disable Button Browse
            $('#obtBKLBrowsePos').prop("disabled",false);
            // End Remove Disable Button Browse
            let aDataNextfunc   = JSON.parse(poDataNextfunc);
            let tBKLNewShopCode = aDataNextfunc[0];
            let tBKLOldShopCode = $('#oetBKLShpCodeOld').val();
            if(tBKLOldShopCode != tBKLNewShopCode){
                $('#oetBKLShpCodeOld').val(tBKLNewShopCode);
                $('#obtBKLBrowseRack').prop("disabled",true);
                // Clear Data Input
                $('.xWInputPos').val('');
                $('.xWInputRack').val('');
            }
        }
        return;
    }

    // Functionality : Next Function Pos
    // Parameter : Event Next Func Modal
    // Create : 30/10/2019 Wasin(Yoshi)
    // Return : Clear Velues Data
    // Return Type : -
    function JSxBKLConsNextFuncBrowsePos(poDataNextfunc){
        if(poDataNextfunc == 'NULL'){
            // Start Add Disable Button Browse
            $('#obtBKLBrowseRack').prop("disabled",true);
            // Clear Data Input
            $('.xWInputPos').val('');
            $('.xWInputRack').val('');
        }else{
            // Start Remove Disable Button Browse
            $('#obtBKLBrowseRack').prop("disabled",false);
            // End Remove Disable Button Browse
            let aDataNextfunc   = JSON.parse(poDataNextfunc);
            let tBKLNewPosCode  = aDataNextfunc[0];
            let tBKLOldPosCode  = $('#oetBKLPosCodeOld').val();
            if(tBKLOldPosCode != tBKLNewPosCode){
                $('#oetBKLPosCodeOld').val(tBKLNewPosCode);
                $('.xWInputRack').val('');
            }
        }
        return;
    }

    // Event Click Button Add Booking
    $("#obtBKLBookingLockerAdd").unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#oetBKLDataStaPageEvent').val('ADDBOOKING');
            JCNoBKLCallPageAddBooking();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Button Detail Booking
    $("#obtBKLBookingLockerDetail").unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#oetBKLDataStaPageEvent').val('CANCELBOOKING');
            JCNoBKLCallPageAddBooking();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });







</script>