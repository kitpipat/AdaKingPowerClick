<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

    // Browse จังหวัด
    var oBranchAddressProvince    = function(poDataFnc){
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
            BrowseLev : nStaBchBrowseType
        };
        return oOptionReturn;
    };

    // Browse อำเภอ
    var oBranchAddressDistrict    = function(poDataFnc){
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
                Selector    : 'oetBranchAddressPvnCode',
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
            BrowseLev : nStaBchBrowseType
        };
        return oOptionReturn;
    };

    // Browse ตำบล
    var oBranchAddressSubDistrict = function(poDataFnc){
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
                Selector    : 'oetBranchAddressDstCode',
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
            BrowseLev : nStaBchBrowseType
        };
        return oOptionReturn;
    };

    $(document).ready(function(){
        $('.selectpicker').selectpicker('refresh');
        var poDataMap   = {
            'tMapLongitude' : <?php echo (isset($tFTAddLongitude)&&!empty($tFTAddLongitude))? floatval($tFTAddLongitude) : floatval('100.50182294100522')?>,
            'tMapLatitude'  : <?php echo (isset($tFTAddLatitude)&&!empty($tFTAddLatitude))? floatval($tFTAddLatitude):floatval('13.757309968845291')?>,
        };
        JSxBranchAddressSetMapToShow(poDataMap);
    });

    // Event Branch Address Browse Province
    $('#obtBranchAddressBrowseProvince').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oBranchAddressProvinceOption = undefined;
            oBranchAddressProvinceOption        = oBranchAddressProvince({
                'tReturnInputCode'  : 'oetBranchAddressPvnCode',
                'tReturnInputName'  : 'oetBranchAddressPvnName',
                'tNextFuncName'     : 'JCNxBranchAddressSetMapProvince',
                'aArgReturn'        : ['FTPvnCode','FTPvnName','FTPvnLatitude','FTPvnLongitude']
            });
            JCNxBrowseData('oBranchAddressProvinceOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Branch Address Browse District
    $('#obtBranchAddressBrowseDistrict').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oBranchAddressDistrictOption = undefined;
            oBranchAddressDistrictOption        = oBranchAddressDistrict({
                'tReturnInputCode'  : 'oetBranchAddressDstCode',
                'tReturnInputName'  : 'oetBranchAddressDstName',
                'tNextFuncName'     : 'JCNxBranchAddressSetMapDistrict',
                'aArgReturn'        : ['FTDstCode','FTDstName','FTDstLatitude','FTDstLongitude']
            })
            JCNxBrowseData('oBranchAddressDistrictOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Branch Address Browse Sub-District
    $('#obtBranchAddressBrowseSubDistrict').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oBranchAddressSubDistrictOption  = undefined;
            oBranchAddressSubDistrictOption         = oBranchAddressSubDistrict({
                'tReturnInputCode'  : 'oetBranchAddressSubDstCode',
                'tReturnInputName'  : 'oetBranchAddressSubDstName',
                'tNextFuncName'     : 'JCNxBranchAddressSetMapSubDistrict',
                'aArgReturn'        : ['FTSudCode','FTSudName','FTSudLatitude','FTSudLongitude']
            });
            JCNxBrowseData('oBranchAddressSubDistrictOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Function: Set Map Data
    // Parameters: Document Ready And Function Netfnc
    // Creator: 11/09/2019 Wasin
    // Return: -
    // ReturnType: -
    function JSxBranchAddressSetMapToShow(poDataMap){
        var tMapLongitude   = poDataMap.tMapLongitude;
        var tMapLatitude    = poDataMap.tMapLatitude;
        var nStatusLoadMap  = 0;
        if(nStatusLoadMap == 0){
            $("#odvBranchAddressMapView").empty();
            var oMapCompany = {
                tDivShowMap	:'odvBranchAddressMapView',
                cLongitude	: parseFloat(tMapLongitude),
                cLatitude	: parseFloat(tMapLatitude),
                tInputLong	: 'ohdBranchAddressMapLong',
                tInputLat	: 'ohdBranchAddressMapLat',
                tIcon		: '<?php echo base_url().'application/modules/common/assets/images/icons/icon_mark.png';?>',
                tStatus		: '2'	
            }
            JSxMapAddEdit(oMapCompany);
			nStatusLoadMap = 1;
        }
    }


    // Function: Branch Address Browse Province
    // Parameters: Event Next Function 
    // Creator: 11/09/2019 Wasin
    // Return: -
    // ReturnType: None
    function JCNxBranchAddressSetMapProvince(ptDataNextFunc){
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
            $('#ohdBranchAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdBranchAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxBranchAddressSetMapToShow(aDataCallMap);
            // **** Clear Value ****
            $('#oetBranchAddressDstCode').val('');
            $('#oetBranchAddressDstName').val('');
            $('#oetBranchAddressSubDstCode').val('');
            $('#oetBranchAddressSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetBranchAddressDstCode').val('');
            $('#oetBranchAddressDstName').val('');
            $('#oetBranchAddressSubDstCode').val('');
            $('#oetBranchAddressSubDstName').val('');
            $('#ohdBranchAddressMapLong').val('');
            $('#ohdBranchAddressMapLat').val('');
        }
    }

    // Function: Branch Address Browse District
    // Parameters: Event Next Function 
    // Creator: 11/09/2019 Wasin
    // Return: -
    // ReturnType: None
    function JCNxBranchAddressSetMapDistrict(ptDataNextFunc){
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
            $('#ohdBranchAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdBranchAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxBranchAddressSetMapToShow(aDataCallMap);
            // **** Clear Value ****
            $('#oetBranchAddressSubDstCode').val('');
            $('#oetBranchAddressSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetBranchAddressSubDstCode').val('');
            $('#oetBranchAddressSubDstName').val('');
            $('#ohdBranchAddressMapLong').val('');
            $('#ohdBranchAddressMapLat').val('');
        }
    }

    // Function: Branch Address Browse Sub District
    // Parameters: Event Next Function
    // Creator: 11/09/2019 Wasin
    // Return: -
    // ReturnType: None
    function JCNxBranchAddressSetMapSubDistrict(ptDataNextFunc){
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
            $('#ohdBranchAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdBranchAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxBranchAddressSetMapToShow(aDataCallMap);
        }else{
            // **** Clear Value ****
            $('#ohdBranchAddressMapLong').val('');
            $('#ohdBranchAddressMapLat').val('');
        }
    }
</script>