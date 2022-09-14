<script type="text/javascript">

    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;

    
    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseSetAgn({
                'tReturnInputCode'  : 'oetSetAgnCode',
                'tReturnInputName'  : 'oetSetAgnName',
                'tBchCodeWhere'     : $('#oetSetBchCode').val(),
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //BrowseBch
    $('#oimBrowseBch').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oBrowseBranchOption = oBrowseBch({
                'tReturnInputCode'  : 'oetSetBchCode',
                'tReturnInputName'  : 'oetSetBchName',
                'tAgnCodeWhere'     : $('#oetSetAgnCode').val(),
            });
            JCNxBrowseData('oBrowseBranchOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


        
    //BrowseAgn 
    $('#oimBrowseApiFmt').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseFormatApiOption = oBrowseFmtCode({
                'tReturnInputCode'  : 'oetfmtCode',
                'tReturnInputName'  : 'oetfmtName',
                'tBchCodeWhere'     : $('#oetSetBchCode').val(),
            });
            JCNxBrowseData('oPdtBrowseFormatApiOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //Option SetAgn
    var oBrowseSetAgn = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tBchCodeWhere       = poReturnInput.tBchCodeWhere;

        var oOptionReturn       = {
            Title : ['ticket/agency/agency', 'tAggTitle'],
            Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
            Join :{
            Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['tAggCode', 'tAggName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnName,"TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew : 'agency',
            BrowseLev : 0,
            NextFunc: {
				FuncName: 'JSxClearBrowseConditionAgn',
				ArgReturn: ['FTAgnCode']
			}
        }
        return oOptionReturn;
    }

    function JSxClearBrowseConditionAgn(ptData){
        // aData = JSON.parse(ptData);
        if(ptData != '' || ptData != 'null'){
            $('#oetSetBchCode').val(''); 
            $('#oetSetBchName').val(''); 
        }
    }


    //Option SetBranch
    var oBrowseBch       = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tAgnCodeWhere       = poReturnInput.tAgnCodeWhere;

        $nCountBCH = '<?=$this->session->userdata('nSesUsrBchCount')?>';

        if($nCountBCH > 1){
            //ถ้าสาขามากกว่า 1 
            tBCH        = "<?=$this->session->userdata('tSesUsrBchCodeMulti');?>";
            tWhereBCH   = " AND TCNMBranch.FTBchCode IN ( " + tBCH + " ) ";
        }else{
            tWhereBCH   = '';
        }

        if(tAgnCodeWhere == '' || tAgnCodeWhere == null){
            tWhereAgn   = '';
        }else{
            tWhereAgn   = " AND TCNMBranch.FTAgnCode = '"+tAgnCodeWhere+"'";
        }


        var oOptionReturn       = {
            Title   : ['company/branch/branch','tBCHTitle'],
            Table   :{Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table   :	['TCNMBranch_L','TCNMAgency_L'],
                On      :   [
                    'TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+ nLangEdits,
                    'TCNMAgency_L.FTAgnCode = TCNMBranch.FTAgnCode AND TCNMAgency_L.FNLngID = '+ nLangEdits,
            ]
            },
            Where:{
                Condition : [tWhereBCH+tWhereAgn]
            },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['15%','75%'],
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMAgency_L.FTAgnName','TCNMBranch.FTAgnCode'],
                DataColumnsFormat : ['','','',''],
                DisabledColumns: [2, 3],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
            },
            RouteAddNew : 'branch',
            BrowseLev : 0,
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionBCH',
                ArgReturn: ['FTAgnName','FTAgnCode']
            }
        }
        return oOptionReturn;
    }

    //หลังจากเลือกสาขาต้องล้างค้า
    function JSxClearBrowseConditionBCH(ptData){
        aData = JSON.parse(ptData);
        var FTAgnName = aData[0];
        var FTAgnCode = aData[1];

        $('#oetSetAgnCode').val(FTAgnCode);
        $('#oetSetAgnName').val(FTAgnName);
  }


    //Option SetAgn
    var oBrowseFmtCode = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tBchCodeWhere       = poReturnInput.tBchCodeWhere;

        var oOptionReturn       = {
            Title : ['interface/conSettingGenaral/conSettingGenaral', 'tGenaralApiFormat'],
            Table:{Master:'TSysFormatAPI_L', PK:'FTApiFmtCode'},
            // Join :{
            // Table: ['TCNMAgency_L'],
            //     On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
            // },
            Where:{
                Condition : [' AND TSysFormatAPI_L.FNLngID='+nLangEdits]
            },
             GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['tApiFormatCode', 'tApiFormatName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TSysFormatAPI_L.FTApiFmtCode', 'TSysFormatAPI_L.FTApiFmtName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TSysFormatAPI_L.FTApiFmtCode DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TSysFormatAPI_L.FTApiFmtCode"],
                Text		: [tInputReturnName,"TSysFormatAPI_L.FTApiFmtName"],
            },
            RouteAddNew : 'agency',
            BrowseLev : 0,
            // NextFunc: {
			// 	FuncName: 'JSxClearBrowseConditionAgn',
			// 	ArgReturn: ['FTAgnCode']
			// }
        }
        return oOptionReturn;
    }


</script>