<script type="text/javascript">

    var tStaUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';
    var nLangEdits   = <?php echo $this->session->userdata("tLangEdit") ?>;


    $('.xCNDatePicker').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        enableOnReadonly: false,
        startDate: '1900-01-01',
        disableTouchKeyboard: true,
        autoclose: true
    });

    // สาขา(Card His)
    $("#obtCrdHisBrowseBch").click(function() {
        var tAgenCode = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>'
        var tWhereBch = "";

        if(tStaUsrLevel != "HQ" || tAgenCode != ""){
            tWhereBch = " AND TCNMBranch.FTBchCode IN(<?php echo $this->session->userdata('tSesUsrBchCodeMulti'); ?>)";
        }

        // option 
        window.oCrdHisBrowseBch = {
            Title: ['authen/user/user', 'tBrowseBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tWhereBch]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FTBchCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetCrdHisBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetCrdHisBchName", "TCNMBranch_L.FTBchName"]
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oCrdHisBrowseBch');
    });


    // Browse CardCode
    $('#oimCardHistory').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1 ){
            JSxCheckPinMenuClose();
            window.oPdtBrowseCrdHis = oBrowseCrdHis({
                'tReturnInputCode'  : 'oetCardHistoryCode',
                'tReturnInputName'  : 'oetCardHistoryName',
            });
            JCNxBrowseData('oPdtBrowseCrdHis');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Browse CardType
    $('#oimCardTypeHistory').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1 ){
            JSxCheckPinMenuClose();
            window.oPdtBrowseCrdTypeHis = oBrowseCrdTypeHis({
                'tReturnInputCode'  : 'oetCardTypeHistory',
                'tReturnInputName'  : 'oetCardTypeHistoryName',
            });
            JCNxBrowseData('oPdtBrowseCrdTypeHis');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    var oBrowseCrdHis = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;

        var tAgenCode = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>';
        var tWhereAgn = "";

        if(tAgenCode != ''){
            tWhereAgn = " AND TFNMCard.FTAgnCode = '" + tAgenCode + "'";
        }

        var oOptionReturn       = {
            Title : ['payment/card/card', 'tCardCode'],
            Table:{Master:'TFNMCard', PK:'FTCrdCode'},
            Join :{
            Table: ['TFNMCard_L'],
                On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = '+nLangEdits]
            },
            Where: {
                Condition : [tWhereAgn]
            },
            GrideView:{
                ColumnPathLang	: 'payment/card/card',
                ColumnKeyLang	: ['tCRDTBCode', 'tCRDTBName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TFNMCard.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TFNMCard.FTCrdCode"],
                Text		: [tInputReturnName,"TFNMCard_L.FTCrdCode"],
            },
            RouteAddNew : 'card',
            BrowseLev : 1,
        }
        return oOptionReturn;
    }



    var oBrowseCrdTypeHis = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;

        var oOptionReturn       = {
            Title: ['payment/cardtype/cardtype', 'tCTYTitle'],
            Table:{Master:'TFNMCardType', PK:'FTCtyCode'},
            Join: {
                Table: ['TFNMCardType_L'],
                On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'payment/cardtype/cardtype',
                ColumnKeyLang: ['tCTYCode', 'tCTYName'],
                WidthModal: 50,
                DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
                DisabledColumns: [],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TFNMCardType.FDCreateOn DESC']
            },
            CallBack: {
                ReturnType: 'S',
                Value		: [tInputReturnCode,"TFNMCardType.FTCtyCode"],
                Text		: [tInputReturnName,"TFNMCardType_L.FTCtyName"],
            },
            RouteAddNew : 'cardtype',
            BrowseLev : 1,
            
        }
        return oOptionReturn;
    }


    function JSxGetCardHisDataTable(){
        var nStaSession = JCNxFuncChkSessionExpired();

        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tBchCode        = $("#oetCrdHisBchCode").val();
            var tHisDate        = $("#oetCrdHisDate").val();
            var tCrdHisCode     = $('#oetCardHistoryCode').val();
            var tCrdTypeHis     = $('#oetCardTypeHistory').val();

            $.ajax({
                type : "POST",
                url  : "cardgethisdatatable",
                data : {
                    tBchCode    : tBchCode,
                    tHisDate    : tHisDate,
                    tCrdHisCode : tCrdHisCode,
                    tCrdTypeHis : tCrdTypeHis
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#ostDataCardHistory').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }


</script>