<script type="text/javascript">
    var nBKLModalLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

    // Browse Option Rate
    var oBKLModalPriceRate  = function(poReturnInput){
        let tPriRthShpCode          = poReturnInput.tShpCode;
        let tPriRthPzeCode          = poReturnInput.tPzeCode;
        let tPriRthInputReturnCode  = poReturnInput.tReturnInputCode;
        let tPriRthInputReturnName  = poReturnInput.tReturnInputName;
        let tWhereDataModal         = " SELECT DISTINCT PRI4PDT.FTRthCode FROM TRTTPdtPrice4PDT PRI4PDT WITH(NOLOCK) WHERE 1=1 ";
        // Where Shop Modal
        if(tPriRthShpCode != ""){
            tWhereDataModal += " AND (PRI4PDT.FTShpCode = '"+tPriRthShpCode+"')";
        }
        // Where Size Modal
        if(tPriRthPzeCode != ""){
            tWhereDataModal += " AND (PRI4PDT.FTPzeCode = '"+tPriRthPzeCode+"')";
        }

        tWhereDataModal += " AND ((CONVERT(DATETIME,GETDATE(),120) >= CONVERT(DATETIME,PRI4PDT.FDPghDStart+PRI4PDT.FTPghTStart,120) ) AND (CONVERT(DATETIME,GETDATE(),120) <= CONVERT(DATETIME,PRI4PDT.FDPghDStop+PRI4PDT.FTPghTStop,120)))";

        let tWhereCondition = " AND (TRTMPriRateHD.FTRthCode IN ( "+tWhereDataModal+" ))"

        let oPriRthOptionReturn     = {
            Title: ['sale/bookinglocker/bookinglocker','tBKLPriceRateTitle'],
            Table: {Master:'TRTMPriRateHD',PK:'FTRthCode'},
            Join: {
                Table:	['TRTMPriRateHD_L'],
                On:['TRTMPriRateHD.FTRthCode = TRTMPriRateHD_L.FTRthCode AND TRTMPriRateHD_L.FNLngID = '+nBKLModalLangEdits]
            },
            Where: {
                Condition: [tWhereCondition]
            },
            GrideView:{
                ColumnPathLang	: 'sale/bookinglocker/bookinglocker',
                ColumnKeyLang	: ['tBKLPriceRateCode','tBKLPriceRateName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TRTMPriRateHD.FTRthCode','TRTMPriRateHD_L.FTRthName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TRTMPriRateHD.FTRthCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tPriRthInputReturnCode,"TRTMPriRateHD.FTRthCode"],
                Text		: [tPriRthInputReturnName,"TRTMPriRateHD_L.FTRthName"]
            },
            RouteAddNew: 'dcmPriRentLocker',
            BrowseLev: 1,
            // DebugSQL: true
        };
        return oPriRthOptionReturn;
    }

    $("#obtBKLBrowseRentalRate").unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            let tBKLModalShpCode    = $('#ohdBKLModalShpCode').val();
            let tBKLModalPzeCode    = $('#ohdBKLModalPzeCode').val();
            window.oBKLModalPriceRateOption = undefined;
            oBKLModalPriceRateOption    = oBKLModalPriceRate({
                'tShpCode'          : tBKLModalShpCode,
                'tPzeCode'          : tBKLModalPzeCode,
                'tReturnInputCode'  : 'oetBKLRthCode',
                'tReturnInputName'  : 'oetBKLRthName',
            });
            JCNxBrowseData('oBKLModalPriceRateOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Cancel Modal Add Booking 
    $('#obtBKLModalBtnCancle').unbind().click(function(){
        $('#odvBKLModalBooking').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass( "modal-open" );
    })

    // Event Click Save Modal Booking 
    $('#obtBKLModalBtnAddBooking').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNoBKLConfirmBookingLocker();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Cancel Modal Booking 
    $('#obtBKLModalBtnCancelBooking').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNoBKLCancelBookingLocker();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });













</script>