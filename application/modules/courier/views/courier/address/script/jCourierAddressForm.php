<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
    
    // Browse จังหวัด
    var oCourierAddressProvince    = function(poDataFnc){
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
                OrderBy			    : ['TCNMProvince.FTPvnCode ASC'],
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
            BrowseLev : nStaCryBrowseType
        };
        return oOptionReturn;
    };

    // Browse อำเภอ
    var oCourierAddressDistrict    = function(poDataFnc){
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
                Selector    : 'oetCourierAddressPvnCode',
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
                OrderBy			    : ['TCNMDistrict.FTDstCode ASC'],
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
            BrowseLev : nStaCryBrowseType
        };
        return oOptionReturn;
    };

    // Browse ตำบล
    var oCourierAddressSubDistrict = function(poDataFnc){
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
                Selector    : 'oetCourierAddressDstCode',
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
                OrderBy			    : ['TCNMSubDistrict.FTSudCode ASC'],
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
            BrowseLev : nStaCryBrowseType
        };
        return oOptionReturn;
    };

    $(document).ready(function(){
        $('.selectpicker').selectpicker('refresh');
        var poDataMap   = {
            'tMapLongitude' : <?php echo (isset($tFTAddLongitude)&&!empty($tFTAddLongitude))? floatval($tFTAddLongitude) : floatval('100.50182294100522')?>,
            'tMapLatitude'  : <?php echo (isset($tFTAddLatitude)&&!empty($tFTAddLatitude))? floatval($tFTAddLatitude):floatval('13.757309968845291')?>,
        };
        JSxCourierAddressSetMapToShow(poDataMap);
    });

    // Event Courier Address Browse Province
    $('#obtCourierAddressBrowseProvince').unbind().click(function(){
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oCourierAddressProvinceOption    = undefined;
            oCourierAddressProvinceOption           = oCourierAddressProvince({
                'tReturnInputCode'  : 'oetCourierAddressPvnCode',
                'tReturnInputName'  : 'oetCourierAddressPvnName',
                'tNextFuncName'     : 'JCNxCourierAddressSetMapProvince',
                'aArgReturn'        : ['FTPvnCode','FTPvnName','FTPvnLatitude','FTPvnLongitude']
            });
            JCNxBrowseData('oCourierAddressProvinceOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Courier Address Browse District
    $('#obtCourierAddressBrowseDistrict').unbind().click(function(){
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oCourierAddressDistrictOption    = undefined;
            oCourierAddressDistrictOption           = oCourierAddressDistrict({
                'tReturnInputCode'  : 'oetCourierAddressDstCode',
                'tReturnInputName'  : 'oetCourierAddressDstName',
                'tNextFuncName'     : 'JCNxCourierAddressSetMapDistrict',
                'aArgReturn'        : ['FTDstCode','FTDstName','FTDstLatitude','FTDstLongitude']
            })
            JCNxBrowseData('oCourierAddressDistrictOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Courier Address Browse Sub-District
    $('#obtCourierAddressBrowseSubDistrict').unbind().click(function(){
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oCourierAddressSubDistrictOption = undefined;
            oCourierAddressSubDistrictOption        = oCourierAddressSubDistrict({
                'tReturnInputCode'  : 'oetCourierAddressSubDstCode',
                'tReturnInputName'  : 'oetCourierAddressSubDstName',
                'tNextFuncName'     : 'JCNxCourierAddressSetMapSubDistrict',
                'aArgReturn'        : ['FTSudCode','FTSudName','FTSudLatitude','FTSudLongitude']
            });
            JCNxBrowseData('oCourierAddressSubDistrictOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Function: Set Map Data
    // Parameters: Document Ready And Event Next Func
    // Creator: 12/09/2019 Wasin
    // Return: -
    // ReturnType: -
    function JSxCourierAddressSetMapToShow(poDataMap){
        var tMapLongitude   = poDataMap.tMapLongitude;
        var tMapLatitude    = poDataMap.tMapLatitude;
        var nStatusLoadMap  = 0;
        if(nStatusLoadMap == 0){
            $("#odvCourierAddressMapView").empty();
            var oMapCompany = {
                tDivShowMap	:'odvCourierAddressMapView',
                cLongitude	: parseFloat(tMapLongitude),
                cLatitude	: parseFloat(tMapLatitude),
                tInputLong	: 'ohdCourierAddressMapLong',
                tInputLat	: 'ohdCourierAddressMapLat',
                tIcon		: '<?php echo base_url().'application/modules/common/assets/images/icons/icon_mark.png';?>',
                tStatus		: '2'	
            }
            JSxMapAddEdit(oMapCompany);
			nStatusLoadMap = 1;
        }
    }

    // Function: Event Netfunc Courier Address Browse Province
    // Parameters: Event Netfunc 
    // Creator: 12/09/2019 Wasin
    // Return: -
    // ReturnType: -
    function JCNxCourierAddressSetMapProvince(ptDataNextFunc){
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
            $('#ohdCourierAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdCourierAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxCourierAddressSetMapToShow(aDataCallMap);
            // **** Clear Value ****
            $('#oetCourierAddressDstCode').val('');
            $('#oetCourierAddressDstName').val('');
            $('#oetCourierAddressSubDstCode').val('');
            $('#oetCourierAddressSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetCourierAddressDstCode').val('');
            $('#oetCourierAddressDstName').val('');
            $('#oetCourierAddressSubDstCode').val('');
            $('#oetCourierAddressSubDstName').val('');
            $('#ohdCourierAddressMapLong').val('');
            $('#ohdCourierAddressMapLat').val('');
        }
    }

    // Function: Event Netfunc Courier Address Browse District
    // Parameters: Event Netfunc
    // Creator: 12/09/2019 Wasin
    // Return: -
    // ReturnType: -
    function JCNxCourierAddressSetMapDistrict(ptDataNextFunc){
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
            $('#ohdCourierAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdCourierAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxCourierAddressSetMapToShow(aDataCallMap);
            // **** Clear Value ****
            $('#oetCourierAddressSubDstCode').val('');
            $('#oetCourierAddressSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetCourierAddressSubDstCode').val('');
            $('#oetCourierAddressSubDstName').val('');
            $('#ohdCourierAddressMapLong').val('');
            $('#ohdCourierAddressMapLat').val('');
        }
    }

    // Function: Event Netfunc Courier Address Browse Sub District
    // Parameters: Event Netfunc
    // Creator: 12/09/2019 Wasin
    // Return: -
    // ReturnType: -
    function JCNxCourierAddressSetMapSubDistrict(ptDataNextFunc){
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
            $('#ohdCourierAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdCourierAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxCourierAddressSetMapToShow(aDataCallMap);
        }else{
            // **** Clear Value ****
            $('#ohdCourierAddressMapLong').val('');
            $('#ohdCourierAddressMapLat').val('');
        }
    }
</script>