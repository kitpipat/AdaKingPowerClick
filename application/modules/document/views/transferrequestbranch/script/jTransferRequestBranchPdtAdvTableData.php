<script type="text/javascript">
    var tTRBStaDocTRBc    = $('#ohdTRBStaDoc').val();
    var tTRBStaApvDoc    = $('#ohdTRBStaApv').val();
    var tTRBStaPrcStkDoc = $('#ohdTRBSTaPrcStk').val();

    $(document).ready(function(){
        $("#odvTRBMngDelPdtInTableDT #oliTRBBtnDeleteMulti").addClass("disabled");
        // ==================================================== Event Confirm Delete PDT IN Tabel DT ===================================================
            $('#odvTRBModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function(){
                
                // var nStaSession = JCNxFuncChkSessionExpired();
                var nStaSession = 1;
                if(typeof nStaSession !== "undefined" && nStaSession == 1){
                    JCNxOpenLoading();
                    JSnTRBRemovePdtDTTempMultiple();
                }else{
                    JCNxShowMsgSessionExpired();
                }
            });
        // =============================================================================================================================================
        // สถานะ Cancel
        if(tTRBStaDocTRBc == 3){
            // Disable Adv Table
            $(".xCNQty").attr("disabled",true);
            $(".xCNIconTable").attr("disabled",true);
            $(".xCNIconTable").addClass("xCNDocDisabled");
            $(".xCNIconTable").attr("onclick", "").unbind("click");
            $('.xCNPdtEditInLine').attr('readonly',true);
            $('#obtTRBBrowseCustomer').attr('disabled',true);
            $('.ocbListItem').attr('disabled',true);
            $("#odvTRBMngDelPdtInTableDT").hide();
            $('#oetTRBInsertBarcode').hide();
            $('#obtTRBDocBrowsePdt').hide();
        }

        // สถานะ Appove
        if(tTRBStaDocTRBc == 1 && tTRBStaApvDoc == 1 ){
            $('.xCNBTNPrimeryDisChgPlus').hide();
            $(".xCNIconTable").addClass("xCNDocDisabled");
            $(".xCNIconTable").attr("onclick", "").unbind("click");
            $('.xCNPdtEditInLine').attr('readonly',true);
            $('#obtTRBBrowseCustomer').attr('disabled',true);
            $('.ocbListItem').attr('disabled',true);
            $("#odvTRBMngDelPdtInTableDT").hide();
            $('#oetTRBInsertBarcode').hide();
            $('#obtTRBDocBrowsePdt').hide();
        }
    });

    // Function: Pase Text Product Item In Modal Delete
    function JSxTRBTextInModalDelPdtDtTemp(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("TRB_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
        }else{
            var tTRBTextDocNo   = "";
            var tTRBTextSeqNo   = "";
            var tTRBTextPdtCode = "";
            // var tTRBTextPunCode = "";
            // var tTRBTextBarCode = "";
            $.each(aArrayConvert[0],function(nKey,aValue){
                tTRBTextDocNo    += aValue.tDocNo;
                tTRBTextDocNo    += " , ";

                tTRBTextSeqNo    += aValue.tSeqNo;
                tTRBTextSeqNo    += " , ";

                tTRBTextPdtCode  += aValue.tPdtCode;
                tTRBTextPdtCode  += " , ";
            });
            $('#odvTRBModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvTRBModalDelPdtInDTTempMultiple #ohdConfirmTRBDocNoDelete').val(tTRBTextDocNo);
            $('#odvTRBModalDelPdtInDTTempMultiple #ohdConfirmTRBSeqNoDelete').val(tTRBTextSeqNo);
            $('#odvTRBModalDelPdtInDTTempMultiple #ohdConfirmTRBPdtCodeDelete').val(tTRBTextPdtCode);
        }
    }

    // ความคุมปุ่มตัวเลือก -> ลบทั้งหมด
    function JSxTRBShowButtonDelMutiDtTemp(){
        var aArrayConvert = [JSON.parse(localStorage.getItem("TRB_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
            $("#odvTRBMngDelPdtInTableDT #oliTRBBtnDeleteMulti").addClass("disabled");
        }else{
            var nNumOfArr   = aArrayConvert[0].length;
            if(nNumOfArr > 1) {
                $("#odvTRBMngDelPdtInTableDT #oliTRBBtnDeleteMulti").removeClass("disabled");
            }else{
                $("#odvTRBMngDelPdtInTableDT #oliTRBBtnDeleteMulti").addClass("disabled");
            }
        }
    }

    //ลบรายการสินค้าในตาราง DT Temp
    function JSnTRBDelPdtInDTTempSingle(DOEl) {
        var nStaSession = 1;
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JCNxOpenLoading();
            var tPdtCode = $(DOEl).parents("tr.xWPdtItem").attr("data-pdtcode");
            var tSeqno   = $(DOEl).parents("tr.xWPdtItem").attr("data-key");
            $(DOEl).parents("tr.xWPdtItem").remove();
            JSnTRBRemovePdtDTTempSingle(tSeqno, tPdtCode);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ลบรายการสินค้าในตาราง DT Temp
    function JSnTRBRemovePdtDTTempSingle(ptSeqNo,ptPdtCode){
        var tTRBDocNo        = $("#oetTRBDocNo").val();
        var tTRBBchCode      = $('#oetTRBFrmBchCode').val();
        JCNxCloseLoading();

        $.ajax({
            type: "POST",
            url: "docTRBRemovePdtInDTTmp",
            data: {
                'tBchCode'      : tTRBBchCode,
                'tDocNo'        : tTRBDocNo,
                'nSeqNo'        : ptSeqNo,
                'tPdtCode'      : ptPdtCode
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    JCNxLayoutControll();
                    JSxTRBCountPdtItems();

                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                // JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResDOnseError(jqXHR, textStatus, errorThrown);
                JSnTRBRemovePdtDTTempSingle(ptSeqNo,ptPdtCode)
            }
        });
    }

    
    //Functionality: Remove Comma
    function JSoTRBRemoveCommaData(paData){
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
    function JSnTRBRemovePdtDTTempMultiple(){
        // JCNxOpenLoading();
        var tTRBDocNo        = $("#oetTRBDocNo").val();
        var tTRBBchCode      = $('#oetTRBFrmBchCode').val();
        var aDataPdtCode    = JSoTRBRemoveCommaData($('#odvTRBModalDelPdtInDTTempMultiple #ohdConfirmTRBPdtCodeDelete').val());
        var aDataSeqNo      = JSoTRBRemoveCommaData($('#odvTRBModalDelPdtInDTTempMultiple #ohdConfirmTRBSeqNoDelete').val());

        for(var i=0;i<aDataSeqNo.length;i++){
            $('.xWPdtItemList'+aDataSeqNo[i]).remove();
        }

        $('#odvTRBModalDelPdtInDTTempMultiple').modal('hide');
        $('#odvTRBModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
        localStorage.removeItem('TRB_LocalItemDataDelDtTemp');
        $('#odvTRBModalDelPdtInDTTempMultiple #ohdConfirmTRBDocNoDelete').val('');
        $('#odvTRBModalDelPdtInDTTempMultiple #ohdConfirmTRBSeqNoDelete').val('');
        $('#odvTRBModalDelPdtInDTTempMultiple #ohdConfirmTRBPdtCodeDelete').val('');
        $('#odvTRBModalDelPdtInDTTempMultiple #ohdConfirmTRBBarCodeDelete').val('');
        setTimeout(function(){
            $('.modal-backdrop').remove();
            // JSvDOLoadPdtDataTableHtml();
            JCNxLayoutControll();
        }, 500);

        JCNxCloseLoading();

        $.ajax({
            type: "POST",
            url: "docTRBRemovePdtInDTTmpMulti",
            data: {
                'tBchCode'      : tTRBBchCode,
                'tDocNo'        : tTRBDocNo,
                'nSeqNo'        : aDataSeqNo,
                'tPdtCode'      : aDataPdtCode
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {

                var tCheckIteminTable = $('#otbTRBDocPdtAdvTableList tbody tr').length;

                if(tCheckIteminTable==0){
                    $('#otbTRBDocPdtAdvTableList').append('<tr style="background-color: rgb(255, 255, 255);"><td class="text-center xCNTextDetail2 xCNTextNotfoundDataPdtTable" colspan="100%">ไม่พบข้อมูล</td></tr>');
                }
                JSxTRBCountPdtItems();

            },  
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResDOnseError(jqXHR, textStatus, errorThrown);
                JSnTRBRemovePdtDTTempMultiple()
            }
        });
    }
    
</script>