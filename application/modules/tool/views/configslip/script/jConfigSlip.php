<script>

    function JSaCFSGetDataUsrSlip(ptType){
        var aUsrSlip    = $('#odvCFSUsrSlip').sortable('toArray');
        var aUsrIDSeq   = $('#odvCFSUsrSlip').sortable('toArray', {attribute:'data-seq'});

        aUsrSlip   = aUsrSlip.filter(function (el) { return el != null && el != ""; });
        aUsrIDSeq  = aUsrIDSeq.filter(function (el) { return el != null && el != ""; });

        if( ptType == 'save' && aUsrSlip.length == 0 ){ 
            FSvCMNSetMsgWarningDialog('ต้องมีอย่างน้อย 1 รายการ ที่ใช้งาน');
            JCNxCloseLoading();
            return; 
        }

        var tAgnCode = $('#ohdCFSAgnCode').val();
        var tUsrCode = $('#ohdCFSUsrCode').val();
        var tGetDate = JStCFSGetDate();
        var aDataUsrSlipHD = [];
        var aDataUsrSlipDT = [];

        for(var i=0; i<aUsrSlip.length; i++){
            var tGrpCode = aUsrSlip[i];
            var nIDSeq   = aUsrIDSeq[i];
            var aPackDataHD = {
                'FTAgnCode'     : tAgnCode,
                'FNUshSeq'      : i+1,
                'FTGshCode'     : tGrpCode,
                'FTUshStaShw'   : '1',
                'FDLastUpdOn'   : tGetDate,
                'FTLastUpdBy'   : tUsrCode,
                'FDCreateOn'    : tGetDate,
                'FTCreateBy'    : tUsrCode
            };
            aDataUsrSlipHD.push(aPackDataHD);

            var aSubCode = $('#odvGshCode-Usr-'+tGrpCode+'-'+nIDSeq).sortable('toArray');
            for(var a=0; a<aSubCode.length; a++){
                var tSubCode = aSubCode[a];
                var tUsdLine = $('#ocmCFSUsdLine-Usr-'+tGrpCode+'-'+nIDSeq+'-'+tSubCode).val();
                var bStaShw  = $('#ocbCFSStaShw-Usr-'+tGrpCode+'-'+nIDSeq+'-'+tSubCode).prop('checked');
                var tStaShw  = '2';
                if( bStaShw ){
                    tStaShw  = '1';
                }
                var aPackDataDT = {
                    'FTAgnCode'     : tAgnCode,
                    'FNUshSeq'      : i+1,
                    'FTUsdSubCode'  : tSubCode,
                    'FTUsdStaShw'   : tStaShw,
                    'FNUsdSeqNo'    : a+1,
                    'FNUsdLine'     : tUsdLine,
                    'FDLastUpdOn'   : tGetDate,
                    'FTLastUpdBy'   : tUsrCode,
                    'FDCreateOn'    : tGetDate,
                    'FTCreateBy'    : tUsrCode
                };
                if( ptType == 'Demo' ){
                    aPackDataDT['FTGshCode'] = tGrpCode;
                    aPackDataDT['FNUsdMaxSeqNo'] = aSubCode.length;
                }
                aDataUsrSlipDT.push(aPackDataDT);
            }
        }

        var aReturnData = {
            aDataUsrSlipHD : aDataUsrSlipHD,
            aDataUsrSlipDT : aDataUsrSlipDT
        };
        return aReturnData;
    }

    $("document").ready(function(){
        
        $('#obtCFSSubmit').off('click').on('click', function(){
            JCNxOpenLoading();
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {

                var aDataUsrSlip = JSaCFSGetDataUsrSlip('save');
                var aDataUsrSlipHD = aDataUsrSlip['aDataUsrSlipHD'];
                var aDataUsrSlipDT = aDataUsrSlip['aDataUsrSlipDT'];

                $.ajax({
                    type: "POST",
                    url: "toolConfigSlipEventSave",
                    data: {
                        paDataUsrSlipDT : aDataUsrSlipDT,
                        paDataUsrSlipHD : aDataUsrSlipHD,
                    },
                    cache: false,
                    timeout: 0,
                    success: function (oResult){
                        var aResult = JSON.parse(oResult);
                        if( aResult['nStaEvent'] == '1' ){
                            JSvCFSCallPageList();
                        }else{
                            FSvCMNSetMsgErrorDialog(aResult['tStaMessg']);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        
        $('#oliCFSTitle').off('click').on('click', function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvCFSCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtCFSResetDefault').off('click').on('click', function(){
            JSxCFSResetDefault(false);
        });

        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSvCFSCallPageList();
    });

    function JSxCFSResetDefault(pbType){
        if( pbType ){
            JCNxOpenLoading();
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "toolConfigSlipEventResetDefault",
                    cache: false,
                    timeout: 0,
                    success: function (oResult){
                        var aResult = JSON.parse(oResult);
                        if( aResult['nStaEvent'] == '1' ){
                            JSvCFSCallPageList();
                        }else{
                            FSvCMNSetMsgErrorDialog(aResult['tStaMessg']);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }else{
            FSvCMNSetMsgWarningDialog('คุณต้องการใช้งานใบเสร็จค่าเริ่มต้น ใช่หรือไม่ ?','JSxCFSResetDefault','',true);
        }
    }

    function JStCFSGetDate(){
        var dFullDate   = new Date();
        var tDate       = $.datepicker.formatDate('yy-mm-dd', dFullDate);
        
        var h = dFullDate.getHours();
        h = (h < 10) ? ("0" + h) : h ;

        var m = dFullDate.getMinutes();
        m = (m < 10) ? ("0" + m) : m ;

        var s = dFullDate.getSeconds();
        s = (s < 10) ? ("0" + s) : s ;

        return tDate + " " + h + ":" + m + ":" + s;
    }

    function JSvCFSCallPageList(){
        JCNxOpenLoading();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            $.ajax({
                type: "POST",
                url: "toolConfigSlipDataList",
                cache: false,
                timeout: 0,
                success: function (tResult){
                    $("#odvCFSContentPageDocument").html(tResult);
                    JSvCFSCallPageDemo();
                    // JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    function JSvCFSCallPageDemo(){
        JCNxOpenLoading();   
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            // $('.xWShwIconRefresh').hide();
            // $('.xWIconRefresh').addClass('xWIconRefreshSpin');
            // $('.xWIconRefresh').addClass('fa-spin');
            setTimeout(() => {
                // JSxCFSShwRefresh();
                $.ajax({
                    type: "POST",
                    url: "toolConfigSlipPageDemo",
                    cache: false,
                    timeout: 0,
                    success: function (tResult){
                        $(".xWCFSDemoContent").html(tResult);
                        // setTimeout(() => {
                            // JSxCFSHideRefresh();
                        // }, 1000);
                        JSxCFSRenderDemo();
                        JCNxCloseLoading();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }, 500);
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
    
</script>