<script type="text/javascript">
    var tSOStaDocDoc    = $('#ohdSOStaDoc').val();
    var tSOStaApvDoc    = $('#ohdSOStaApv').val();
    var tSOStaPrcStkDoc = $('#ohdSOStaPrcStk').val();

    $(document).ready(function(){
        // ======================================================= Set Edit In Line Pdt Doc Temp =======================================================
            if((tSOStaDocDoc == 3) || (tSOStaApvDoc == 1 && tSOStaPrcStkDoc == 1)){
                $('#otbSODocPdtAdvTableList .xCNPIBeHideMQSS').hide();
            }else{
                var oParameterEditInLine    = {
                    "DocModules"                    : "",
                    "FunctionName"                  : "JSxSOSaveEditInline",
                    "DataAttribute"                 : ['data-field', 'data-seq'],
                    "TableID"                       : "otbSODocPdtAdvTableList",
                    "NotFoundDataRowClass"          : "xWPITextNotfoundDataPdtTable",
                    "EditInLineButtonDeleteClass"   : "xWPIDeleteBtnEditButtonPdt",
                    "LabelShowDataClass"            : "xWShowInLine",
                    "DivHiddenDataEditClass"        : "xWEditInLine"
                }
                JCNxSetNewEditInline(oParameterEditInLine);

                $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
                $(".xWEditInlineElement").eq(nIndexInputEditInline).select();

                $(".xWEditInlineElement").removeAttr("disabled");


                let oElement = $(".xWEditInlineElement");
                for(let nI=0;nI<oElement.length;nI++){
                    $(oElement.eq(nI)).val($(oElement.eq(nI)).val().trim());
                }
            }
        // =============================================================================================================================================

        // ================================================ Event Click Delete Multiple PDT IN Table DT ================================================
            $('#otbSODocPdtAdvTableList #odvTBodySOPdtAdvTableList .ocbListItem').unbind().click(function(){
                let tSODocNo    = $('#oetSODocNo').val();
                let tSOSeqNo    = $(this).parents('.xWPdtItem').data('seqno');
                let tSOPdtCode  = $(this).parents('.xWPdtItem').data('pdtcode');
                let tSOPunCode  = $(this).parents('.xWPdtItem').data('puncode');
                $(this).prop('checked', true);
                let oLocalItemDTTemp    = localStorage.getItem("SO_LocalItemDataDelDtTemp");
                let oDataObj            = [];
                if(oLocalItemDTTemp){
                    oDataObj    = JSON.parse(oLocalItemDTTemp);
                }
                let aArrayConvert   = [JSON.parse(localStorage.getItem("SO_LocalItemDataDelDtTemp"))];
                if(aArrayConvert == '' || aArrayConvert == null){
                    oDataObj.push({
                        'tDocNo'    : tSODocNo,
                        'tSeqNo'    : tSOSeqNo,
                        'tPdtCode'  : tSOPdtCode,
                        'tPunCode'  : tSOPunCode,
                    });
                    localStorage.setItem("SO_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                    JSxSOTextInModalDelPdtDtTemp();
                }else{
                    var aReturnRepeat   = JStSOFindObjectByKey(aArrayConvert[0],'tSeqNo',tSOSeqNo);
                    if(aReturnRepeat == 'None' ){
                        //ยังไม่ถูกเลือก
                        oDataObj.push({
                            'tDocNo'    : tSODocNo,
                            'tSeqNo'    : tSOSeqNo,
                            'tPdtCode'  : tSOPdtCode,
                            'tPunCode'  : tSOPunCode,
                        });
                        localStorage.setItem("SO_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                        JSxSOTextInModalDelPdtDtTemp();
                    }else if(aReturnRepeat == 'Dupilcate'){
                        localStorage.removeItem("SO_LocalItemDataDelDtTemp");
                        $(this).prop('checked', false);
                        var nLength = aArrayConvert[0].length;
                        for($i=0; $i<nLength; $i++){
                            if(aArrayConvert[0][$i].tSeqNo == tSOSeqNo){
                                delete aArrayConvert[0][$i];
                            }
                        }
                        var aNewarraydata   = [];
                        for($i=0; $i<nLength; $i++){
                            if(aArrayConvert[0][$i] != undefined){
                                aNewarraydata.push(aArrayConvert[0][$i]);
                            }
                        }
                        localStorage.setItem("SO_LocalItemDataDelDtTemp",JSON.stringify(aNewarraydata));
                        JSxSOTextInModalDelPdtDtTemp();
                    }
                }
                JSxSOShowButtonDelMutiDtTemp();
            });
        // =============================================================================================================================================

        // ==================================================== Event Confirm Delete PDT IN Tabel DT ===================================================
            $('#odvSOModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function(){
                var nStaSession = JCNxFuncChkSessionExpired();
                if(typeof nStaSession !== "undefined" && nStaSession == 1){
                    JSnSORemovePdtDTTempMultiple();
                }else{
                    JCNxShowMsgSessionExpired();
                }
            });

         
        // =============================================================================================================================================
    });

    // Functionality: ฟังก์ชั่น Save Edit In Line Pdt Doc DT Temp
    // Parameters: Behind Next Func Edit Value
    // Creator: 02/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View
    // ReturnType : View
    function JSxSOSaveEditInline(paParams){
        console.log('JSxSOSaveEditInline: ', paParams);
        var oThisEl         = paParams['Element'];
        var tThisDisChgText = $(oThisEl).parents('tr.xWPdtItem').find('td label.xWPIDisChgDT').text().trim();
        if(tThisDisChgText == ''){
            console.log('No Have Dis/Chage DT');
            // ไม่มีลด/ชาร์จ
            var nSeqNo      = paParams.DataAttribute[1]['data-seq'];
            var tFieldName  = paParams.DataAttribute[0]['data-field'];
            var tValue      = accounting.unformat(paParams.VeluesInline);
            var bIsDelDTDis = false;
            FSvSOEditPdtIntoTableDTMonitor(nSeqNo,tFieldName,tValue,bIsDelDTDis); 
        }else{
            console.log('Have Dis/Chage DT');
            // มีลด/ชาร์จ
            $('#odvSOModalConfirmDeleteDTDis').modal({
                backdrop: 'static',
                show: true
            });
            
            $('#odvSOModalConfirmDeleteDTDis #obtSOConfirmDeleteDTDis').unbind();
            $('#odvSOModalConfirmDeleteDTDis #obtSOConfirmDeleteDTDis').one('click',function(){
                $('#odvSOModalConfirmDeleteDTDis').modal('hide');
                $('.modal-backdrop').remove();
                var nSeqNo      = paParams.DataAttribute[1]['data-seq'];
                var tFieldName  = paParams.DataAttribute[0]['data-field'];
                var tValue      = accounting.unformat(paParams.VeluesInline);
                var bIsDelDTDis = true;
                FSvSOEditPdtIntoTableDTMonitor(nSeqNo,tFieldName,tValue,bIsDelDTDis);
            });

            $('#odvSOModalConfirmDeleteDTDis #obtSOCancelDeleteDTDis').unbind();
            $('#odvSOModalConfirmDeleteDTDis #obtSOCancelDeleteDTDis').one('click',function(){
                $('.modal-backdrop').remove();
                JSvSOLoadPdtDataTableHtmlMonitor();
            });

            $('#odvSOModalConfirmDeleteDTDis').modal('show')
        }
    }

    //Functionality: Call Modal Dis/Chage Doc DT
    //Parameters: object Event Click
    //Creator: 02/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View
    // ReturnType : View
    function JCNvSOCallModalDisChagDT(poEl){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tDocNo          = $(poEl).parents('.xWPdtItem').data('docno');
            var tPdtCode        = $(poEl).parents('.xWPdtItem').data('pdtcode');
            var tPdtName        = $(poEl).parents('.xWPdtItem').data('pdtname');
            var tPunCode        = $(poEl).parents('.xWPdtItem').data('puncode');
            var tNet            = $(poEl).parents('.xWPdtItem').data('netafhd');
            var tSetPrice       = $(poEl).parents('.xWPdtItem').data('setprice');
            var tQty            = $(poEl).parents('.xWPdtItem').data('qty');
            var tStaDis         = $(poEl).parents('.xWPdtItem').data('stadis');
            var tSeqNo          = $(poEl).parents('.xWPdtItem').data('seqno');
            var bHaveDisChgDT   = $(poEl).parents('.xWPIDisChgDTForm').find('label.xWPIDisChgDT').text() == ''? false : true;
            window.DisChgDataRowDT  = {
                tDocNo          : tDocNo,
                tPdtCode        : tPdtCode,
                tPdtName        : tPdtName,
                tPunCode        : tPunCode,
                tNet            : tNet,
                tSetPrice       : tSetPrice,
                tQty            : tQty,
                tStadis         : tStaDis,
                tSeqNo          : tSeqNo,
                bHaveDisChgDT   : bHaveDisChgDT
            };
            var oSODisChgParams = {
                DisChgType: 'disChgDT'
            };
            JSxSOOpenDisChgPanel(oSODisChgParams);
        }else{
            JCNxShowMsgSessionExpired();
        }   
    }

    // Functionality: Pase Text Product Item In Modal Delete
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxSOTextInModalDelPdtDtTemp(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("SO_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
        }else{
            var tSOTextDocNo   = "";
            var tSOTextSeqNo   = "";
            var tSOTextPdtCode = "";
            var tSOTextPunCode = "";
            $.each(aArrayConvert[0],function(nKey,aValue){
                tSOTextDocNo    += aValue.tDocNo;
                tSOTextDocNo    += " , ";

                tSOTextSeqNo    += aValue.tSeqNo;
                tSOTextSeqNo    += " , ";

                tSOTextPdtCode  += aValue.tPdtCode;
                tSOTextPdtCode  += " , ";

                tSOTextPunCode  += aValue.tPunCode;
                tSOTextPunCode  += " , ";
            });
            $('#odvSOModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvSOModalDelPdtInDTTempMultiple #ohdConfirmSODocNoDelete').val(tSOTextDocNo);
            $('#odvSOModalDelPdtInDTTempMultiple #ohdConfirmSOSeqNoDelete').val(tSOTextSeqNo);
            $('#odvSOModalDelPdtInDTTempMultiple #ohdConfirmSOPdtCodeDelete').val(tSOTextPdtCode);
            $('#odvSOModalDelPdtInDTTempMultiple #ohdConfirmSOPunCodeDelete').val(tSOTextPunCode);
        }
    }

    // Functionality: Show Button Delete Multiple DT Temp
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxSOShowButtonDelMutiDtTemp(){
        var aArrayConvert = [JSON.parse(localStorage.getItem("SO_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
            $("#odvSOMngDelPdtInTableDT #oliSOBtnDeleteMulti").addClass("disabled");
        }else{
            var nNumOfArr   = aArrayConvert[0].length;
            if(nNumOfArr > 1) {
                $("#odvSOMngDelPdtInTableDT #oliSOBtnDeleteMulti").removeClass("disabled");
            }else{
                $("#odvSOMngDelPdtInTableDT #oliSOBtnDeleteMulti").addClass("disabled");
            }
        }
    }

    //Functionality: Function Delete Product In Doc DT Temp
    //Parameters: object Event Click
    //Creator: 04/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View
    // ReturnType : View
    function JSnSODelPdtInDTTempSingle(poEl) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tVal    = $(poEl).parents("tr.xWPdtItem").attr("data-pdtcode");
            var tSeqno  = $(poEl).parents("tr.xWPdtItem").attr("data-seqno");
            $(poEl).parents("tr.xWPdtItem").remove();
            JSnSORemovePdtDTTempSingle(tSeqno, tVal);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality: Function Remove Product In Doc DT Temp
    // Parameters: Event Btn Click Call Edit Document
    // Creator: 04/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: Status Add/Update Document
    // ReturnType: object
    function JSnSORemovePdtDTTempSingle(ptSeqNo,ptPdtCode){
        var tSODocNo        = $("#oetSODocNo").val();
        var tSOBchCode      = $('#oetSOFrmBchCode').val();
        var tSOVatInOrEx    = $('#ocmSOFrmSplInfoVatInOrEx').val();
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "dcmSORemovePdtInDTTmp",
            data: {
                'tBchCode'      : tSOBchCode,
                'tDocNo'        : tSODocNo,
                'nSeqNo'        : ptSeqNo,
                'tPdtCode'      : ptPdtCode,
                'tVatInOrEx'    : tSOVatInOrEx,
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    JSvSOLoadPdtDataTableHtmlMonitor();
                    JCNxLayoutControll();
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    
    //Functionality: Remove Comma
    //Parameters: Event Button Delete All
    //Creator: 26/07/2019 Wasin
    //Return:  object Status Delete
    //Return Type: object
    function JSoSORemoveCommaData(paData){
        var aTexts              = paData.substring(0, paData.length - 2);
        var aDataSplit          = aTexts.split(" , ");
        var aDataSplitlength    = aDataSplit.length;
        var aNewDataDeleteComma = [];

        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewDataDeleteComma.push(aDataSplit[$i]);
        }
        return aNewDataDeleteComma;
    }

    // Functionality: Fucntion Call Delete Multiple Doc DT Temp
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: array Data Status Delete
    // ReturnType: Array
    function JSnSORemovePdtDTTempMultiple(){
        JCNxOpenLoading();
        var tSODocNo        = $("#oetSODocNo").val();
        var tSOBchCode      = $('#oetSOFrmBchCode').val();
        var tSOVatInOrEx    = $('#ocmSOFrmSplInfoVatInOrEx').val();
        var aDataPdtCode    = JSoSORemoveCommaData($('#odvSOModalDelPdtInDTTempMultiple #ohdConfirmSOPdtCodeDelete').val());
        var aDataPunCode    = JSoSORemoveCommaData($('#odvSOModalDelPdtInDTTempMultiple #ohdConfirmSOPunCodeDelete').val());
        var aDataSeqNo      = JSoSORemoveCommaData($('#odvSOModalDelPdtInDTTempMultiple #ohdConfirmSOSeqNoDelete').val());
        $.ajax({
            type: "POST",
            url: "dcmSORemovePdtInDTTmpMulti",
            data: {
                'ptSOBchCode'   : tSOBchCode,
                'ptSODocNo'     : tSODocNo,
                'ptSOVatInOrEx' : tSOVatInOrEx,
                'paDataPdtCode' : aDataPdtCode,
                'paDataPunCode' : aDataPunCode,
                'paDataSeqNo'   : aDataSeqNo,
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    $('#odvSOModalDelPdtInDTTempMultiple').modal('hide');
                    $('#odvSOModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
                    localStorage.removeItem('SO_LocalItemDataDelDtTemp');
                    $('#odvSOModalDelPdtInDTTempMultiple #ohdConfirmSODocNoDelete').val('');
                    $('#odvSOModalDelPdtInDTTempMultiple #ohdConfirmSOSeqNoDelete').val('');
                    $('#odvSOModalDelPdtInDTTempMultiple #ohdConfirmSOPdtCodeDelete').val('');
                    $('#odvSOModalDelPdtInDTTempMultiple #ohdConfirmSOPunCodeDelete').val('');
                    setTimeout(function(){
                        $('.modal-backdrop').remove();
                        JSvSOLoadPdtDataTableHtmlMonitor();
                        JCNxLayoutControll();
                    }, 500);
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },  
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    




function JSxSOAPCompPareModalLoad(pnID){
    $("#odvSOModalComparePdt"+pnID).modal("show");
}


</script>