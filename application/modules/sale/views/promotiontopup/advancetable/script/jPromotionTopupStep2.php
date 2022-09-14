<script>

    $(document).ready(function(){
        JSxPTUPageStep2DataTable();

        // if( !bIsAddPage ){
        //     $('#olbPTUStep2AutoGen').hide();
        // }
        

        $('#ocbPTURefExAutoGen').off('click');
        $('#ocbPTURefExAutoGen').on('click',function(){
            let tStaRefEx = $(this).prop("checked");
            if( tStaRefEx ){
                if( bIsAddPage ){
                    $('.xWFTPmcRefEx').val('');
                }
                $('.xWFTPmcRefEx').attr('disabled',true);
            }else{
                $('.xWFTPmcRefEx').attr('disabled',false);
            }
        });

    });

    // แสดงรายการ ประเภทบัตร
    // Create By : Napat(Jame) 23/09/2020
    function JSxPTUPageStep2DataTable(){
        $.ajax({
            type: "POST",
            url: "docPTUPageStep2DataTable",
            data: {
                'tDocNo'    : $('#oetPTUDocNo').val(),
                'tBchCode'  : $('#oetPTUBchCode').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvPTUDataTableStep2').html(tResult);
                
                let tStaRefEx = $('#ocbPTURefExAutoGen').prop("checked");
                if( tStaRefEx ){
                    if( bIsAddPage ){
                        $('.xWFTPmcRefEx').val('');
                    }
                    $('.xWFTPmcRefEx').attr('disabled',true);
                }
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

    // Create By : Napat(Jame) 24/09/2020
    function JSxPTUEventStep2EditInLine(poElm){
        if(sessionStorage.getItem("EditInLine") == "1"){
            sessionStorage.setItem("EditInLine", "2");
            
            // Get Variable
            var nSeq         = poElm.parent().parent().attr('data-seq');
            var tField       = poElm.attr('data-field');
            // var nIndex       = $('.xW'+tField).index(poElm);
            var nIndex       = $('.xCNPdtEditInLine').index(poElm);
            var nDecimalShow = $('#oetPTUStep2DecimalShow').val();
            var tPrefix      = tField.substr(0, 2);
           
            if( tPrefix == 'FC' ){
                var nVal         = parseFloat($(poElm).val());
                // Check Values
                if(isNaN(nVal) || nVal === undefined){ nVal = 0; }
                $(poElm).val( nVal.toFixed(nDecimalShow) );
            }else{
                var nVal         = String($(poElm).val());
            }

            // Next Focus Inputs
            // $('.xW'+tField).eq(nIndex + 1).focus();
            $('.xCNPdtEditInLine').eq(nIndex + 1).focus();

            // Remove Session
            sessionStorage.removeItem("EditInLine");

            // Call Ajax
            $.ajax({
                type: "POST",
                url: "docPTUEventStep2EditInline",
                data: {
                    tDocNo     : $('#oetPTUDocNo').val(),
                    tBchCode   : $('#oetPTUBchCode').val(),
                    nSeq       : nSeq,
                    nVal       : nVal,
                    tField     : tField,
                    tPrefix    : tPrefix
                },
                cache: false,
                timeout: 0,
                success: function(oResult){
                    var aResult = $.parseJSON(oResult);
                    if( aResult['tCode'] != '1' ){
                        alert(aResult['tDesc']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }
    }

    // Create By : Napat(Jame) 24/09/2020
    function JSxPTUEventStep2SetValue(ptField,ptPrefix,ptSeq,ptVal){
        $.ajax({
            type: "POST",
            url: "docPTUEventStep2EditInline",
            data: {
                tDocNo     : $('#oetPTUDocNo').val(),
                tBchCode   : $('#oetPTUBchCode').val(),
                nSeq       : ptSeq,
                nVal       : ptVal,
                tField     : ptField,
                tPrefix    : ptPrefix
            },
            cache: false,
            timeout: 0,
            success: function(oResult){
                var aResult = $.parseJSON(oResult);
                if( aResult['tCode'] != '1' ){
                    alert(aResult['tDesc']);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Create By : Napat(Jame) 24/09/2020
    function JSxPTUBrowseNextFuncCoupon(oResult){
        let nSeq = $('#oetPTUStep2OnBrowseSeq').val();
        if( oResult == 'NULL' || oResult === null ){
            JSxPTUEventStep2SetValue('FTPmcRefIn','FT',nSeq,'NULL');
        }else{
            var aResult = $.parseJSON(oResult);
            JSxPTUEventStep2SetValue('FTPmcRefIn','FT',nSeq,aResult[0]);
        }
        
    }

    // ลบรายการ กำหนดเงื่อนไขโปรโมชั่น
    // Create By : Napat(Jame) 24/09/2020
    function JSxPTUEventStep2Delete(poObj){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docPTUEventStepDelete",
            data: {
                'tDocNo'    : $('#oetPTUDocNo').val(),
                'tBchCode'  : $('#oetPTUBchCode').val(),
                'nSeq'      : $(poObj).parent().parent().attr('data-seq'),
                'tDocKey'   : 'TFNTCrdPmtCD'
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aResult = $.parseJSON(oResult);
                if( aResult['tCode'] == '1' ){
                    JSxPTUPageStep2DataTable();
                }else{
                    alert(aResult['tDesc']);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

    // Create By : Napat(Jame) 25/09/2020
    function JCNbPTUStep2IsValid() {
        var bStatus         = false;
        var nStep1NumRow    = $('#oetPTUStep2NumRow').val();
        var tStaType        = $('#ocbPTURefExAutoGen').prop("checked");

        if(nStep1NumRow > 0){
            bStatus = true;
        }

        $(".xWPTUStep2Tr").each(function(){
            let cPmcAmtPay = parseFloat($(this).find('.xWFCPmcAmtPay').val());
            let cPmcAmtGet = parseFloat($(this).find('.xWFCPmcAmtGet').val());
            let tCoupon    = $(this).find('.xWPTUStep2Coupon').val();
            if( cPmcAmtPay == 0 ){
                bStatus = false;
            }else if( cPmcAmtGet == 0 && tCoupon == "" ){
                bStatus = false;
            }

            if( tStaType === false ){
                let tPmcRefEx = $(this).find('.xWFTPmcRefEx').val();
                if( tPmcRefEx == "" ){
                    bStatus = false;
                }
            }
        });
        
        return bStatus;
    }

    $('#obtPTUStep2AddCondition').off('click');
    $('#obtPTUStep2AddCondition').on('click',function(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docPTUEventStep2AddRow",
            data: {
                'tDocNo'    : $('#oetPTUDocNo').val(),
                'tBchCode'  : $('#oetPTUBchCode').val()
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                // console.log(oResult);
                var aResult = $.parseJSON(oResult);
                if( aResult['tCode'] == '1' ){
                    JSxPTUPageStep2DataTable();
                }else{
                    alert(aResult['tDesc']);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    });

</script>