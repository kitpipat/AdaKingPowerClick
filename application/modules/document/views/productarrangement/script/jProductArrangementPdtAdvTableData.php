<script type="text/javascript">
    var tPAMStaDocDoc    = $('#ohdPAMStaDoc').val();
    var tPAMStaApvDoc    = $('#ohdPAMStaApv').val();
    var tPAMStaPrcStkDoc = $('#ohdPAMSTaPrcStk').val();

    $(document).ready(function(){
        $("#odvPAMMngDelPdtInTableDT #oliPAMBtnDeleteMulti").addClass("disabled");
        // ==================================================== Event Confirm Delete PDT IN Tabel DT ===================================================
            $('#odvPAMModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function(){
                
                // var nStaSession = JCNxFuncChkSessionExpired();
                var nStaSession = 1;
                if(typeof nStaSession !== "undefined" && nStaSession == 1){
                    JCNxOpenLoading();
                    JSnPAMRemovePdtDTTempMultiple();
                }else{
                    JCNxShowMsgSessionExpired();
                }
            });
        // =============================================================================================================================================
        // สถานะ Cancel
        if(tPAMStaDocDoc == 3){
            // Disable Adv Table
            $(".xCNQty").attr("disabled",true);
            $(".xCNIconTable").attr("disabled",true);
            $(".xCNIconTable").addClass("xCNDocDisabled");
            $(".xCNIconTable").attr("onclick", "").unbind("click");
            $('.xCNPdtEditInLine').attr('readonly',true);
            $('#obtPAMBrowseCustomer').attr('disabled',true);
            $('.ocbListItem').attr('disabled',true);
            $("#odvPAMMngDelPdtInTableDT").hide();
            $('#oetPAMInsertBarcode').hide();
            $('#obtPAMDocBrowsePdt').hide();
        }

        // สถานะ Appove
        if(tPAMStaDocDoc == 1 && tPAMStaApvDoc == 1 ){
            $('.xCNBTNPrimeryDisChgPlus').hide();
            $(".xCNIconTable").addClass("xCNDocDisabled");
            $(".xCNIconTable").attr("onclick", "").unbind("click");
            $('.xCNPdtEditInLine').attr('readonly',true);
            $('#obtPAMBrowseCustomer').attr('disabled',true);
            $('.ocbListItem').attr('disabled',true);
            $("#odvPAMMngDelPdtInTableDT").hide();
            $('#oetPAMInsertBarcode').hide();
            $('#obtPAMDocBrowsePdt').hide();
        }
    });

    // Function: Pase Text Product Item In Modal Delete
    function JSxPAMTextInModalDelPdtDtTemp(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("PAM_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
        }else{
            var tPAMTextDocNo   = "";
            var tPAMTextSeqNo   = "";
            var tPAMTextPdtCode = "";
            // var tPAMTextPunCode = "";
            // var tPAMTextBarCode = "";
            $.each(aArrayConvert[0],function(nKey,aValue){
                tPAMTextDocNo    += aValue.tDocNo;
                tPAMTextDocNo    += " , ";

                tPAMTextSeqNo    += aValue.tSeqNo;
                tPAMTextSeqNo    += " , ";

                tPAMTextPdtCode  += aValue.tPdtCode;
                tPAMTextPdtCode  += " , ";
            });
            $('#odvPAMModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvPAMModalDelPdtInDTTempMultiple #ohdConfirmPAMDocNoDelete').val(tPAMTextDocNo);
            $('#odvPAMModalDelPdtInDTTempMultiple #ohdConfirmPAMSeqNoDelete').val(tPAMTextSeqNo);
            $('#odvPAMModalDelPdtInDTTempMultiple #ohdConfirmPAMPdtCodeDelete').val(tPAMTextPdtCode);
        }
    }

    // ความคุมปุ่มตัวเลือก -> ลบทั้งหมด
    function JSxPAMShowButtonDelMutiDtTemp(){
        var aArrayConvert = [JSON.parse(localStorage.getItem("PAM_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
            $("#odvPAMMngDelPdtInTableDT #oliPAMBtnDeleteMulti").addClass("disabled");
        }else{
            var nNumOfArr   = aArrayConvert[0].length;
            if(nNumOfArr > 1) {
                $("#odvPAMMngDelPdtInTableDT #oliPAMBtnDeleteMulti").removeClass("disabled");
            }else{
                $("#odvPAMMngDelPdtInTableDT #oliPAMBtnDeleteMulti").addClass("disabled");
            }
        }
    }

    //ลบรายการสินค้าในตาราง DT Temp
    function JSnPAMDelPdtInDTTempSingle(PAMEl) {
        var nStaSession = 1;
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JCNxOpenLoading();
            var tPdtCode = $(PAMEl).parents("tr.xWPdtItem").attr("data-pdtcode");
            var tSeqno   = $(PAMEl).parents("tr.xWPdtItem").attr("data-key");
            $(PAMEl).parents("tr.xWPdtItem").remove();
            JSnPAMRemovePdtDTTempSingle(tSeqno, tPdtCode);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ลบรายการสินค้าในตาราง DT Temp
    function JSnPAMRemovePdtDTTempSingle(ptSeqNo,ptPdtCode){
        var tPAMDocNo        = $("#oetPAMDocNo").val();
        var tPAMBchCode      = $('#oetPAMBchCode').val();
        JCNxCloseLoading();

        $.ajax({
            type: "POST",
            url: "docPAMRemovePdtInDTTmp",
            data: {
                'tBchCode'      : tPAMBchCode,
                'tDocNo'        : tPAMDocNo,
                'nSeqNo'        : ptSeqNo,
                'tPdtCode'      : ptPdtCode
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    JCNxLayoutControll();
                    JSxPAMCountPdtItems();
                    var tCheckIteminTable = $('#otbPAMDocPdtAdvTableList tbody tr').length;
                    if(tCheckIteminTable==0){
                        $('#otbPAMDocPdtAdvTableList').append('<tr style="background-color: rgb(255, 255, 255);"><td class="text-center xCNTextDetail2 xCNTextNotfoundDataPdtTable" colspan="100%">ไม่พบข้อมูล</td></tr>');
                    }
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                // JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResPAMnseError(jqXHR, textStatus, errorThrown);
                JSnPAMRemovePdtDTTempSingle(ptSeqNo,ptPdtCode)
            }
        });
    }

    
    //Functionality: Remove Comma
    function JSoPAMRemoveCommaData(paData){
        var aTexts              = paData.substring(0, paData.length - 2);
        var aDataSplit          = aTexts.split(" , ");
        var aDataSplitlength    = aDataSplit.length;
        var aNewDataDeleteComma = [];

        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewDataDeleteComma.push(aDataSplit[$i]);
        }
        return aNewDataDeleteComma;
    }

    // Function: Fucntion Call Delete Multiple Doc DT Temp
    function JSnPAMRemovePdtDTTempMultiple(){
        // JCNxOpenLoading();
        var tPAMDocNo        = $("#oetPAMDocNo").val();
        var tPAMBchCode      = $('#oetPAMBchCode').val();
        var aDataPdtCode    = JSoPAMRemoveCommaData($('#odvPAMModalDelPdtInDTTempMultiple #ohdConfirmPAMPdtCodeDelete').val().trim());
        var aDataSeqNo      = JSoPAMRemoveCommaData($('#odvPAMModalDelPdtInDTTempMultiple #ohdConfirmPAMSeqNoDelete').val().trim());

        // console.log($('#odvPAMModalDelPdtInDTTempMultiple #ohdConfirmPAMPdtCodeDelete').val().trim());
        // console.log($('#odvPAMModalDelPdtInDTTempMultiple #ohdConfirmPAMSeqNoDelete').val().trim());
        // console.log(aDataPdtCode);
        // console.log(aDataSeqNo);
        for(var i=0;i<aDataSeqNo.length;i++){
            $('.xWPdtItemList'+aDataSeqNo[i]).remove();
        }

        $('#odvPAMModalDelPdtInDTTempMultiple').modal('hide');
        $('#odvPAMModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
        localStorage.removeItem('PAM_LocalItemDataDelDtTemp');
        $('#odvPAMModalDelPdtInDTTempMultiple #ohdConfirmPAMDocNoDelete').val('');
        $('#odvPAMModalDelPdtInDTTempMultiple #ohdConfirmPAMSeqNoDelete').val('');
        $('#odvPAMModalDelPdtInDTTempMultiple #ohdConfirmPAMPdtCodeDelete').val('');
        $('#odvPAMModalDelPdtInDTTempMultiple #ohdConfirmPAMBarCodeDelete').val('');
        setTimeout(function(){
            $('.modal-backdrop').remove();
            // JSvPAMLoadPdtDataTableHtml();
            JCNxLayoutControll();
        }, 500);

        JCNxCloseLoading();

        $.ajax({
            type: "POST",
            url: "docPAMRemovePdtInDTTmpMulti",
            data: {
                'tBchCode'      : tPAMBchCode,
                'tDocNo'        : tPAMDocNo,
                'nSeqNo'        : aDataSeqNo,
                'tPdtCode'      : aDataPdtCode
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {

                var tCheckIteminTable = $('#otbPAMDocPdtAdvTableList tbody tr').length;

                if(tCheckIteminTable==0){
                    $('#otbPAMDocPdtAdvTableList').append('<tr style="background-color: rgb(255, 255, 255);"><td class="text-center xCNTextDetail2 xCNTextNotfoundDataPdtTable" colspan="100%">ไม่พบข้อมูล</td></tr>');
                }
                JSxPAMCountPdtItems();

            },  
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResPAMnseError(jqXHR, textStatus, errorThrown);
                JSnPAMRemovePdtDTTempMultiple()
            }
        });
    }

    // Product S/N

    $('.xWPAMViewPdtSN').off('click').on('click',function(){
        var nSeqNo = $(this).parents().parents().attr('data-seqno');
        var aPackData = {
            'nSeqNo'    : nSeqNo,
            'tPdtCode'  : $(this).parents().parents().attr('data-pdtcode'),
            'tPdtName'  : $(this).parents().parents().attr('data-pdtName'),
            'tBarCode'  : $(this).parents().parents().attr('data-barcode'),
            'tQty'      : $('#ohdQty'+nSeqNo).val(),
        };
        // console.log(aPackData);
        JSxPAMCallModalPdtSN(aPackData);
    });

    function JSxPAMCallModalPdtSN(paPackData){
        $.ajax({
            type: "POST",
            url: "docPAMPagePdtSN",
            data: {
                ptDocNo     : $('#oetPAMDocNo').val().trim(),
                pnSeqNo     : paPackData['nSeqNo']
            },
            cache: false,
            timeout: 0,
            success: function(tHTML) {
                
                $('#odvPAMModalViewPdtSN .modal-body').html(tHTML);

                $('#ospPAMProductCode').text(paPackData['tPdtCode']);
                $('#ospPAMProductName').text(paPackData['tPdtName']);
                $('#ospPAMBarCode').text(paPackData['tBarCode']);

                $('#ohdPAMEnterSNSeqNo').val(paPackData['nSeqNo']);
                $('#ohdPAMEnterSNPdtCode').val(paPackData['tPdtCode']);
                $('#ohdPAMEnterSNPdtName').val(paPackData['tPdtName']);
                $('#ohdPAMEnterSNBarCode').val(paPackData['tBarCode']);
                $('#ohdPAMEnterSNQty').val(paPackData['tQty']);

                $('#odvPAMModalViewPdtSN').modal('show');
                setTimeout(function(){ $('#oetPAMSerialNo').focus(); }, 500);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Product S/N
    
</script>