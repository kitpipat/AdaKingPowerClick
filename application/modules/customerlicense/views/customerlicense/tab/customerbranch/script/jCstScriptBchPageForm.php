<script type="text/javascript">

$('#obtBrowseSrvCode').on('click', function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oPdtBrowseSrvCodeOption = oPdtBrowseSrvCode({
                'tReturnInputCode': 'oetSrvCode',
                'tReturnInputName': 'oetSrvName'
            });
            JCNxBrowseData('oPdtBrowseSrvCodeOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



        // Option Browse Product Vat
        var oPdtBrowseSrvCode = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;

        var tRegLicType = $('#ohdRegLicType').val();
        var oOptionReturn = {
            Title: ['customerlicense/customerlicense/customerlicense', 'tCLBSrvTitle'],
            Table: {
                Master: 'TRGMPosSrv',
                PK: 'FTSrvCode'
            },
            Join: {
                Table: ['TRGMPosSrv_L'],
                On: ['TRGMPosSrv.FTSrvCode = TRGMPosSrv_L.FTSrvCode']
            },
            Where: {
                Condition: [
                    "AND TRGMPosSrv.FTSrvGroup = '"+tRegLicType+"' ",
                ]
            },
            GrideView: {
                ColumnPathLang: 'customerlicense/customerlicense/customerlicense',
                ColumnKeyLang: ['tCLBSrvCode', 'tCLBSrvName'],
                DataColumns: ['TRGMPosSrv.FTSrvCode', 'TRGMPosSrv_L.FTSrvName'],
                Perpage: 10,
                OrderBy: ['TRGMPosSrv.FDCreateOn DESC'],
                // SourceOrder		: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TRGMPosSrv.FTSrvCode"],
                Text: [tInputReturnName, "TRGMPosSrv_L.FTSrvName"],
            },
            // DebugSQL : true
        };
        return oOptionReturn;
    }


</script>
