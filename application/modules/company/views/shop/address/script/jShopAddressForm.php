<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

    // Browse จังหวัด
    var oShopAddressProvince    = function(poDataFnc){
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
            BrowseLev : nStaShpBrowseType
        };
        return oOptionReturn;
    };

    // Browse อำเภอ
    var oShopAddressDistrict    = function(poDataFnc){
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
                Selector    : 'oetShopAddressPvnCode',
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
            BrowseLev : nStaShpBrowseType
        };
        return oOptionReturn;
    };

    // Browse ตำบล
    var oShopAddressSubDistrict = function(poDataFnc){
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
                Selector    : 'oetShopAddressDstCode',
                Table       : 'TCNMSubDistrict',
                Key         : 'FTDstCode'
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
            BrowseLev : nStaShpBrowseType
        };
        return oOptionReturn;
    };

    $(document).ready(function(){
        $('.selectpicker').selectpicker('refresh');
        var poDataMap   = {
            'tMapLongitude' : <?php echo (isset($tFTAddLongitude)&&!empty($tFTAddLongitude))? floatval($tFTAddLongitude) : floatval('100.50182294100522')?>,
            'tMapLatitude'  : <?php echo (isset($tFTAddLatitude)&&!empty($tFTAddLatitude))? floatval($tFTAddLatitude):floatval('13.757309968845291')?>,
        };
        JSxShopAddressSetMapToShow(poDataMap);
    });

    // Event Shop Address Browse Province
    $('#obtShopAddressBrowseProvince').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oShopAddressProvinceOption   = undefined;
            oShopAddressProvinceOption          = oShopAddressProvince({
                'tReturnInputCode'  : 'oetShopAddressPvnCode',
                'tReturnInputName'  : 'oetShopAddressPvnName',
                'tNextFuncName'     : 'JCNxShopAddressSetMapProvince',
                'aArgReturn'        : ['FTPvnCode','FTPvnName','FTPvnLatitude','FTPvnLongitude']
            });
            JCNxBrowseData('oShopAddressProvinceOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Shop Address Browse District
    $('#obtShopAddressBrowseDistrict').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oShopAddressDistrictOption   = undefined;
            oShopAddressDistrictOption          = oShopAddressDistrict({
                'tReturnInputCode'  : 'oetShopAddressDstCode',
                'tReturnInputName'  : 'oetShopAddressDstName',
                'tNextFuncName'     : 'JCNxShopAddressSetMapDistrict',
                'aArgReturn'        : ['FTDstCode','FTDstName','FTDstLatitude','FTDstLongitude']
            })
            JCNxBrowseData('oShopAddressDistrictOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Shop Address Browse Sub-District
    $('#obtShopAddressBrowseSubDistrict').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oShopAddressSubDistrictOption    = undefined;
            oShopAddressSubDistrictOption           = oShopAddressSubDistrict({
                'tReturnInputCode'  : 'oetShopAddressSubDstCode',
                'tReturnInputName'  : 'oetShopAddressSubDstName',
                'tNextFuncName'     : 'JCNxShopAddressSetMapSubDistrict',
                'aArgReturn'        : ['FTSudCode','FTSudName','FTSudLatitude','FTSudLongitude']
            });
            JCNxBrowseData('oShopAddressSubDistrictOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Function: Set Map Data
    // Parameters: -
    // Creator: 10/09/2019 Wasin
    // LastUpdate: -
    // Return: -
    // ReturnType: -
    function JSxShopAddressSetMapToShow(poDataMap){
        var tMapLongitude   = poDataMap.tMapLongitude;
        var tMapLatitude    = poDataMap.tMapLatitude;
        var nStatusLoadMap  = 0;
        if(nStatusLoadMap == 0){
            $("#odvShopAddressMapView").empty();
            var oMapCompany = {
                tDivShowMap	:'odvShopAddressMapView',
                cLongitude	: parseFloat(tMapLongitude),
                cLatitude	: parseFloat(tMapLatitude),
                tInputLong	: 'ohdShopAddressMapLong',
                tInputLat	: 'ohdShopAddressMapLat',
                tIcon		: '<?php echo base_url().'application/modules/common/assets/images/icons/icon_mark.png';?>',
                tStatus		: '2'	
            }
            JSxMapAddEdit(oMapCompany);
			nStatusLoadMap = 1;
        }
    }

    // Function: Event Netfunc Shop Address Browse Province
    // Parameters: -
    // Creator: 10/09/2019 Wasin
    // LastUpdate: -
    // Return: -
    // ReturnType: -
    function JCNxShopAddressSetMapProvince(ptDataNextFunc){
        let aDataNextFunc,tPvnCode,tPvnName,tPvnLatitude,tPvnLongitude;
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
            $('#ohdShopAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdShopAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxShopAddressSetMapToShow(aDataCallMap);
            // **** Clear Value ****
            $('#oetShopAddressDstCode').val('');
            $('#oetShopAddressDstName').val('');
            $('#oetShopAddressSubDstCode').val('');
            $('#oetShopAddressSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetShopAddressDstCode').val('');
            $('#oetShopAddressDstName').val('');
            $('#oetShopAddressSubDstCode').val('');
            $('#oetShopAddressSubDstName').val('');
            $('#ohdShopAddressMapLong').val('');
            $('#ohdShopAddressMapLat').val('');
        }
    }

    // Function: Event Netfunc Shop Address Browse District
    // Parameters: -
    // Creator: 10/09/2019 Wasin
    // LastUpdate: -
    // Return: -
    // ReturnType: -
    function JCNxShopAddressSetMapDistrict(ptDataNextFunc){
        let aDataNextFunc,tDstCode,tDstName,tDstLatitude,tDstLongitude;
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
            $('#ohdShopAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdShopAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxShopAddressSetMapToShow(aDataCallMap);
            // **** Clear Value ****
            $('#oetShopAddressSubDstCode').val('');
            $('#oetShopAddressSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetShopAddressSubDstCode').val('');
            $('#oetShopAddressSubDstName').val('');
            $('#ohdShopAddressMapLong').val('');
            $('#ohdShopAddressMapLat').val('');
        }
    }

    // Function: Event Netfunc Shop Address Browse Sub District
    // Parameters: -
    // Creator: 10/09/2019 Wasin
    // LastUpdate: -
    // Return: -
    // ReturnType: -
    function JCNxShopAddressSetMapSubDistrict(ptDataNextFunc){
        let aDataNextFunc,tSubDstCode,tSubDstName,tSubDstLatitude,tSubDstLongitude;
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
            $('#ohdShopAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdShopAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxShopAddressSetMapToShow(aDataCallMap);
        }else{
            // **** Clear Value ****
            $('#ohdShopAddressMapLong').val('');
            $('#ohdShopAddressMapLat').val('');
        }
    }
</script>