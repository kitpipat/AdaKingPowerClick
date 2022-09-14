<script type="text/javascript">
    $(document).ready(function(){
        localStorage.removeItem("LocalItemDataDelDtTemp");
        $('#otbTXODocPdtTable .xWTXOPdtListItem').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {
                var tTXODocNo   = $('#oetTXODocNo').val();
                var tTXOSeqNo   = $(this).parent().parent().parent().data('seqno');
                var tTXOPdtCode = $(this).parent().parent().parent().data('pdtcode');
                var tTXOPunCode = $(this).parent().parent().parent().data('puncode');
                $(this).prop('checked', true);
                var oLocalItemDTTemp    = localStorage.getItem("LocalItemDataDelDtTemp");
                var obj = [];
                if(oLocalItemDTTemp){
                    obj = JSON.parse(oLocalItemDTTemp);
                }
                var aArrayConvert   = [JSON.parse(localStorage.getItem("LocalItemDataDelDtTemp"))];
                if(aArrayConvert == '' || aArrayConvert == null){
                    obj.push({
                        'tDocNo'    : tTXODocNo,
                        'tSeqNo'    : tTXOSeqNo,
                        'tPdtCode'  : tTXOPdtCode,
                        'tPunCode'  : tTXOPunCode,
                    });
                    localStorage.setItem("LocalItemDataDelDtTemp",JSON.stringify(obj));
                    JSxTXOTextInModalDelPdtDtTemp();
                }else{
                    var aReturnRepeat   = JStTXOFindObjectByKey(aArrayConvert[0],'tSeqNo',tTXOSeqNo);
                    if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                        obj.push({
                            'tDocNo'    : tTXODocNo,
                            'tSeqNo'    : tTXOSeqNo,
                            'tPdtCode'  : tTXOPdtCode,
                            'tPunCode'  : tTXOPunCode,
                        });
                        localStorage.setItem("LocalItemDataDelDtTemp",JSON.stringify(obj));
                        JSxTXOTextInModalDelPdtDtTemp();
                    }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                        localStorage.removeItem("LocalItemDataDelDtTemp");
                        $(this).prop('checked', false);
                        var nLength = aArrayConvert[0].length;
                        for($i=0; $i<nLength; $i++){
                            if(aArrayConvert[0][$i].tSeqNo == tTXOSeqNo){
                                delete aArrayConvert[0][$i];
                            }
                        }
                        var aNewarraydata   = [];
                        for($i=0; $i<nLength; $i++){
                            if(aArrayConvert[0][$i] != undefined){
                                aNewarraydata.push(aArrayConvert[0][$i]);
                            }
                        }
                        localStorage.setItem("LocalItemDataDelDtTemp",JSON.stringify(aNewarraydata));
                        JSxTXOTextInModalDelPdtDtTemp();
                    }
                }
                JSxTXOShowButtonDelMutiDtTemp();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#odvTXOModalDelPdtDTTemp #osmTXOConfirmPdtDTTemp').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxTXORemoveMultiRowDTTmp();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
    });
    
    // Functionality: Pase Text Product Item In Modal Delete
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 21/05/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxTXOTextInModalDelPdtDtTemp(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        }else{
            var tTXOTextSeqNo   = "";
            var tTXOTextPdtCode = "";
            var tTXOTextDocNo   = "";
            var tTXOTextPunCode = "";
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTXOTextSeqNo   += aArrayConvert[0][$i].tSeqNo;
                tTXOTextSeqNo   += " , ";

                tTXOTextPdtCode += aArrayConvert[0][$i].tPdtCode;
                tTXOTextPdtCode += " , ";

                tTXOTextDocNo   += aArrayConvert[0][$i].tDocNo;
                tTXOTextDocNo   += " , ";

                tTXOTextPunCode += aArrayConvert[0][$i].tPunCode;
                tTXOTextPunCode += " , ";
            }
            $("#odvTXOModalDelPdtDTTemp #ospTXOConfirmDelPdtDTTemp").text($("#oetTextComfirmDeleteMulti").val());
            $("#odvTXOModalDelPdtDTTemp #ohdTXOConfirmSeqDelete").val(tTXOTextSeqNo);
            $("#odvTXOModalDelPdtDTTemp #ohdTXOConfirmPdtDelete").val(tTXOTextPdtCode);
            $("#odvTXOModalDelPdtDTTemp #ohdTXOConfirmPunDelete").val(tTXOTextPunCode);
            $("#odvTXOModalDelPdtDTTemp #ohdTXOConfirmDocDelete").val(tTXOTextDocNo);
        }
    }

    // Functionality: Show Button Delete Multiple DT Temp
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 21/05/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxTXOShowButtonDelMutiDtTemp(){
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#odvTXOMngAdvPdtDataTable #oliTXODelPdtDT").addClass("disabled");
        }else{
            var nNumOfArr   = aArrayConvert[0].length;
            if(nNumOfArr > 1) {
                $("#odvTXOMngAdvPdtDataTable #oliTXODelPdtDT").removeClass("disabled");
            }else{
                $("#odvTXOMngAdvPdtDataTable #oliTXODelPdtDT").addClass("disabled");
            }
        }
    }

</script>