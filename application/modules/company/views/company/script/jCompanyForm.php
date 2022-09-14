<script type="text/javascript">
    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;

    // Option Branch
    var oCmpBranch      = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var oOptionReturn       = {
            Title   : ['company/branch/branch','tBCHTitle'],
            Table   :{Master:'TCNMBranch',PK:'FTBchCode'},
            Join    :{
                Table : ['TCNMBranch_L'],
                On : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType : 'S',
                Value : [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text : [tInputReturnName,"TCNMBranch_L.FTBchName"],
            },
            RouteAddNew : 'branch',
            BrowseLev : nStaCmpBrowseType
        };
        return oOptionReturn;
    }
    
    // Option Currency
    var oCmpCurrency    = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var oOptionReturn       = {
            Title   : ['payment/rate/rate','tRTETitle'],
            Table   :{Master:'TFNMRate',PK:'FTRteCode'},
            Join    :{
                Table : ['TFNMRate_L'],
                On : ['TFNMRate_L.FTRteCode = TFNMRate.FTRteCode AND TFNMRate_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang	: 'payment/rate/rate',
                ColumnKeyLang	: ['tRTETBRteCode','tRTETBRteName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns		: ['TFNMRate.FTRteCode','TFNMRate_L.FTRteName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TFNMRate.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TFNMRate.FTRteCode"],
                Text		: [tInputReturnName,"TFNMRate_L.FTRteName"],
            },
            RouteAddNew : 'rate',
            BrowseLev : nStaCmpBrowseType,
            // DebugSQL : true
        };
        return oOptionReturn;
    }
    var oCmpVatRate     = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tTextLeftJoin       = "( SELECT Result.* ";
            tTextLeftJoin       += " FROM ";
            tTextLeftJoin       += " ( ";
            tTextLeftJoin       += "   SELECT VatAtv.* FROM (  ";
            tTextLeftJoin       += "     SELECT  ";
            tTextLeftJoin       += "        row_number() over (partition by TCNMVatRate.FTVatCode order by FDVatStart DESC) as VatRateActive, ";
            tTextLeftJoin       += "        TCNMVatRate.FDVatStart, ";
            tTextLeftJoin       += "        TCNMVatRate.FTVatCode,  ";
            tTextLeftJoin       += "        TCNMVatRate.FCVatRate ";
            tTextLeftJoin       += "     FROM TCNMVatRate ";
            tTextLeftJoin       += "     WHERE 1 = 1 ";
            tTextLeftJoin       += "    AND (CONVERT(VARCHAR(19), GETDATE(), 121) >= CONVERT(VARCHAR(19), TCNMVatRate.FDVatStart, 121)) ";
            tTextLeftJoin       += " ) VatAtv WHERE VatAtv.VatRateActive = 1 ";
            tTextLeftJoin       += " ) AS Result ";
            tTextLeftJoin       += ") AS TVJOIN ";

        var oOptionReturn       = {
            Title : ['company/vatrate/vatrate','tVATTitle'],
            Table : {Master:'TCNMVatRate',PK:'FTVatCode'},
            Join    :{
                Table : [tTextLeftJoin],
                SpecialJoin : ['INNER JOIN'],
                On : ['TCNMVatRate.FTVatCode = TVJOIN.FTVatCode AND TCNMVatRate.FDVatStart = TVJOIN.FDVatStart']
            },
            GrideView :{
                ColumnPathLang	: 'company/vatrate/vatrate',
                ColumnKeyLang	: ['tVATTBCode','tVATTBRate','tVATDateStart'],
                DataColumns		: ['TCNMVatRate.FTVatCode','TCNMVatRate.FCVatRate','TCNMVatRate.FDVatStart'],
                DataColumnsFormat : ['','Number:','Date:DD/MM/YYYY'],
                Perpage			: 10,
                OrderBy			: ['TCNMVatRate.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMVatRate.FTVatCode"],
                Text		: [tInputReturnName,"TCNMVatRate.FCVatRate"],
            },
            // DebugSQL : true
        };
        return oOptionReturn;
    }


    $(document).ready(function(){
        $('.xCNComboSelect').selectpicker('refresh');

        // Event Browse สาขา
        $('#obtCmpBrowseBranch').click(function() { 
            poElement = this;
            if (poElement.getAttribute("data-dblclick") == null) {
                poElement.setAttribute("data-dblclick", 1);
                $(poElement).select();
                setTimeout(function () {
                    if (poElement.getAttribute("data-dblclick") == 1) {
                        var nStaSession = JCNxFuncChkSessionExpired();
                        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                            // Create By Witsarut 04/10/2019
                                JSxCheckPinMenuClose();
                             // Create By Witsarut 04/10/2019
                            window.oCmpBranchOption = undefined;
                            oCmpBranchOption        = oCmpBranch({
                                'tReturnInputCode'  : 'oetCmpBchCode',
                                'tReturnInputName'  : 'oetCmpBchName',
                            })
                            JCNxBrowseData('oCmpBranchOption');
                        }else{
                            JCNxShowMsgSessionExpired();
                        }
                    }
                    poElement.removeAttribute("data-dblclick");
                }, 300);
            }
        });

        // Event Browse สกุลเงิน
        $('#obtCmpBrowseCurrency').click(function() { 
            poElement = this;
            if (poElement.getAttribute("data-dblclick") == null) {
                poElement.setAttribute("data-dblclick", 1);
                $(poElement).select();
                setTimeout(function () {
                    if (poElement.getAttribute("data-dblclick") == 1) {
                        var nStaSession = JCNxFuncChkSessionExpired();
                        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                            // Create By Witsarut 04/10/2019
                                JSxCheckPinMenuClose();
                             // Create By Witsarut 04/10/2019
                            window.oCmpCurrencyOption   = undefined;
                            oCmpCurrencyOption          = oCmpCurrency({
                                'tReturnInputCode'  : 'oetCmpRteCode',
                                'tReturnInputName'  : 'oetCmpRteName',
                            });
                            JCNxBrowseData('oCmpCurrencyOption');
                        }else{
                            JCNxShowMsgSessionExpired();
                        }
                    }
                    poElement.removeAttribute("data-dblclick");
                }, 300);
            }
        });

        // Event Browse อัตรภาษี
        $('#obtCmpBrowseVatRate').click(function() { 
            poElement = this;
            if (poElement.getAttribute("data-dblclick") == null) {
                poElement.setAttribute("data-dblclick", 1);
                $(poElement).select();
                setTimeout(function () {
                    if (poElement.getAttribute("data-dblclick") == 1) {
                        var nStaSession = JCNxFuncChkSessionExpired();
                        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                             // Create By Witsarut 04/10/2019
                                JSxCheckPinMenuClose();
                             // Create By Witsarut 04/10/2019
                            window.oCmpVatRateOption   = undefined;
                            oCmpVatRateOption          = oCmpVatRate({
                                'tReturnInputCode'  : 'oetVatRateCode',
                                'tReturnInputName'  : 'oetVatRateName',
                            });
                            JCNxBrowseData('oCmpVatRateOption');
                        }else{
                            JCNxShowMsgSessionExpired();
                        }
                    }
                    poElement.removeAttribute("data-dblclick");
                }, 300);
            }
        });

    });



</script>