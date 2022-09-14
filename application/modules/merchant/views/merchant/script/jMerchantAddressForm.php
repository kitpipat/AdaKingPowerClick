<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
    $(document).ready(function(){
        $('.selectpicker').selectpicker('refresh');
        // $('.xCNStartDisabled').find('button').attr("disabled","disabled");
        var poDataMap   = {
            'tMapLongitude' : <?php echo (isset($tFTAddLongitude)&&!empty($tFTAddLongitude))? floatval($tFTAddLongitude) : floatval('100.50182294100522')?>,
            'tMapLatitude'  : <?php echo (isset($tFTAddLatitude)&&!empty($tFTAddLatitude))? floatval($tFTAddLatitude):floatval('13.757309968845291')?>,
        };
        JSxMerchantSetMapToShow(poDataMap);
    });

    // Function Set Map Data
    function JSxMerchantSetMapToShow(poDataMap){
        var tMapLongitude   = poDataMap.tMapLongitude;
        var tMapLatitude    = poDataMap.tMapLatitude;
        var nStatusLoadMap  = 0;
		if(nStatusLoadMap == 0){
            $("#odvMerchantAddrMapView").empty();
            var oMapCompany = {
                tDivShowMap	:'odvMerchantAddrMapView',
                cLongitude	: parseFloat(tMapLongitude),
                cLatitude	: parseFloat(tMapLatitude),
                tInputLong	: 'oetMerchantMapLong',
                tInputLat	: 'oetMerchantMapLat',
                tIcon		: '<?php echo base_url().'application/modules/common/assets/images/icons/icon_mark.png';?>',
                tStatus		: '2'	
            }
            JSxMapAddEdit(oMapCompany);
			nStatusLoadMap = 1;
        }
    }

    // Browse จังหวัด
    var oMerchantAddrProvince       = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;
        var oOptionReturn       = {
            Title : ['address/province/province','tPVNTitle'],
            Table:{Master:'TCNMProvince',PK:'FTPvnCode'},
            Join :{
                Table:	['TCNMProvince_L'],
                On:['TCNMProvince_L.FTPvnCode = TCNMProvince.FTPvnCode AND TCNMProvince_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang	    : 'address/province/province',
                ColumnKeyLang	    : ['tPVNCode','tPVNName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMProvince.FTPvnCode','TCNMProvince_L.FTPvnName','TCNMProvince.FTPvnLatitude','TCNMProvince.FTPvnLongitude'],
                DataColumnsFormat   : ['','','',''],
                DisabledColumns     : [2,3],
                Perpage			    : 10,
                OrderBy			    : ['TCNMProvince.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMProvince.FTPvnCode"],
                Text		: [tInputReturnName,"TCNMProvince_L.FTPvnName"],
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            RouteAddNew : 'province',
            BrowseLev : nStaMcnBrowseType
        };
        return oOptionReturn;
    }

    // Browse อำเภอ
    var oMerchantAddrDistrict       = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;
        var oOptionReturn       = {
            Title   : ['address/district/district','tDSTTitle'],
            Table   : {Master:'TCNMDistrict',PK:'FTDstCode'},
            Join    : {
                Table:	['TCNMDistrict_L'],
                On:['TCNMDistrict_L.FTDstCode = TCNMDistrict.FTDstCode AND TCNMDistrict_L.FNLngID = '+nLangEdits]
            },
            Filter:{
                Selector    : 'oetMerchantAddrPvnCode',
                Table       : 'TCNMDistrict',
                Key         : 'FTPvnCode'
            },
            GrideView:{
                ColumnPathLang	    : 'address/district/district',
                ColumnKeyLang	    : ['tDSTTBCode','tDSTTBName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMDistrict.FTDstCode','TCNMDistrict_L.FTDstName','TCNMDistrict.FTDstLatitude','TCNMDistrict.FTDstLongitude'],
                DataColumnsFormat   : ['','','',''],
                DisabledColumns     : [2,3],
                Perpage			    : 10,
                OrderBy			    : ['TCNMDistrict.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMDistrict.FTDstCode"],
                Text		: [tInputReturnName,"TCNMDistrict_L.FTDstName"],
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            RouteAddNew : 'district',
            BrowseLev : nStaMcnBrowseType
        };
        return oOptionReturn;
    }

    // Browse ตำบล
    var oMerchantAddrSubDistrict    = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;
        var oOptionReturn       = {
            Title   : ['address/subdistrict/subdistrict','tSDTTitle'],
            Table   : {Master:'TCNMSubDistrict',PK:'FTSudCode'},
            Join    : {
                Table:	['TCNMSubDistrict_L'],
                On:['TCNMSubDistrict_L.FTSudCode = TCNMSubDistrict.FTSudCode AND TCNMSubDistrict_L.FNLngID = '+nLangEdits]
            },
            Filter:{
                Selector:'oetMerchantAddrDstCode',
                Table:'TCNMSubDistrict',
                Key:'FTDstCode'
            },
            GrideView:{
                ColumnPathLang	    : 'address/subdistrict/subdistrict',
                ColumnKeyLang	    : ['tSDTTBCode','tSDTTBSubdistrict'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMSubDistrict.FTSudCode','TCNMSubDistrict_L.FTSudName','TCNMSubDistrict.FTSudLatitude','TCNMSubDistrict.FTSudLongitude'],
                DataColumnsFormat   : ['','','',''],
                DisabledColumns     : [2,3],
                Perpage			    : 10,
                OrderBy			    : ['TCNMSubDistrict.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMSubDistrict.FTSudCode"],
                Text		: [tInputReturnName,"TCNMSubDistrict_L.FTSudName"],
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            RouteAddNew : 'subdistrict',
            BrowseLev : nStaMcnBrowseType
        };
        return oOptionReturn;
    }
    
    // Event Merchant Browse Province
    $('#obtMerChantAddrBrowseProvince').click(function() { 
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/201
            window.oMerchantAddrProvinceOption  = undefined;
            oMerchantAddrProvinceOption         = oMerchantAddrProvince({
                'tReturnInputCode'  : 'oetMerchantAddrPvnCode',
                'tReturnInputName'  : 'oetMerchantAddrPvnName',
                'tNextFuncName'     : 'JCNxMerchantSetMapProvince',
                'aArgReturn'        : ['FTPvnCode','FTPvnName','FTPvnLatitude','FTPvnLongitude']
            });
            JCNxBrowseData('oMerchantAddrProvinceOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Merchant Browse District
    $('#obtMerChantAddrBrowseDistrict').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
             // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
             // Create By Witsarut 04/10/201
            window.oMerchantAddrDistrictOption    = undefined;
            oMerchantAddrDistrictOption           = oMerchantAddrDistrict({
                'tReturnInputCode'  : 'oetMerchantAddrDstCode',
                'tReturnInputName'  : 'oetMerchantAddrDstName',
                'tNextFuncName'     : 'JCNxMerchantSetMapDistrict',
                'aArgReturn'        : ['FTDstCode','FTDstName','FTDstLatitude','FTDstLongitude']
            });
            JCNxBrowseData('oMerchantAddrDistrictOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtMerChantAddrBrowseSubDistrict').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
             // Create By Witsarut 04/10/201
            window.oMerchantAddrSubDistrictOption   = undefined;
            oMerchantAddrSubDistrictOption          = oMerchantAddrSubDistrict({
                'tReturnInputCode'  : 'oetMerchantAddrSubDstCode',
                'tReturnInputName'  : 'oetMerchantAddrSubDstName',
                'tNextFuncName'     : 'JCNxMerchantSetMapSubDistrict',
                'aArgReturn'        : ['FTSudCode','FTSudName','FTSudLatitude','FTSudLongitude']
            });
            JCNxBrowseData('oMerchantAddrSubDistrictOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Netfunc Merchant Browse Province
    function JCNxMerchantSetMapProvince(ptDataNextFunc){
        var aDataNextFunc,tPvnCode,tPvnName,tPvnLatitude,tPvnLongitude;
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            aDataNextFunc   = JSON.parse(ptDataNextFunc);
            tPvnCode        = aDataNextFunc[0];
            tPvnName        = aDataNextFunc[1];
            tPvnLatitude    = aDataNextFunc[2];
            tPvnLongitude   = aDataNextFunc[3];
            aDataCallMap    = {
                'tMapLatitude'  : parseFloat(tPvnLatitude),
                'tMapLongitude' : parseFloat(tPvnLongitude),
            };
            
            $('#oetMerchantMapLong').val(aDataCallMap.tMapLongitude);
            $('#oetMerchantMapLat').val(aDataCallMap.tMapLatitude);
            JSxMerchantSetMapToShow(aDataCallMap);

            // **** Clear Value ****
            $('#oetMerchantAddrDstCode').val('');
            $('#oetMerchantAddrDstName').val('');
            $('#oetMerchantAddrSubDstCode').val('');
            $('#oetMerchantAddrSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetMerchantAddrDstCode').val('');
            $('#oetMerchantAddrDstName').val('');
            $('#oetMerchantAddrSubDstCode').val('');
            $('#oetMerchantAddrSubDstName').val('');
            $('#oetMerchantMapLong').val('');
            $('#oetMerchantMapLat').val('');
        }
    }

    // Event Netfunc Merchant Browse District
    function JCNxMerchantSetMapDistrict(ptDataNextFunc){
        var aDataNextFunc,tDstCode,tDstName,tDstLatitude,tDstLongitude;
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            aDataNextFunc   = JSON.parse(ptDataNextFunc);
            tDstCode        = aDataNextFunc[0];
            tDstName        = aDataNextFunc[1];
            tDstLatitude    = aDataNextFunc[2];
            tDstLongitude   = aDataNextFunc[3];
            aDataCallMap    = {
                'tMapLatitude'  : parseFloat(tDstLatitude),
                'tMapLongitude' : parseFloat(tDstLongitude),
            };
            $('#oetMerchantMapLong').val(aDataCallMap.tMapLongitude);
            $('#oetMerchantMapLat').val(aDataCallMap.tMapLatitude);
            JSxMerchantSetMapToShow(aDataCallMap);

            // **** Clear Value ****
            $('#oetMerchantAddrSubDstCode').val('');
            $('#oetMerchantAddrSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetMerchantAddrSubDstCode').val('');
            $('#oetMerchantAddrSubDstName').val('');
            $('#oetMerchantMapLong').val('');
            $('#oetMerchantMapLat').val('');
        }
    }
    
    // Event Netfunc Merchant Browse Sub-District
    function JCNxMerchantSetMapSubDistrict(ptDataNextFunc){
        var aDataNextFunc,tSubDstCode,tSubDstName,tSubDstLatitude,tSubDstLongitude;
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            aDataNextFunc       = JSON.parse(ptDataNextFunc);
            tSubDstCode         = aDataNextFunc[0];
            tSubDstName         = aDataNextFunc[1];
            tSubDstLatitude     = aDataNextFunc[2];
            tSubDstLongitude    = aDataNextFunc[3];
            aDataCallMap    = {
                'tMapLatitude'  : parseFloat(tSubDstLatitude),
                'tMapLongitude' : parseFloat(tSubDstLongitude),
            };
            $('#oetMerchantMapLong').val(aDataCallMap.tMapLongitude);
            $('#oetMerchantMapLat').val(aDataCallMap.tMapLatitude);
            JSxMerchantSetMapToShow(aDataCallMap);
        }else{
            // **** Clear Value ****
            $('#oetMerchantMapLong').val('');
            $('#oetMerchantMapLat').val('');
        }
    }
</script>