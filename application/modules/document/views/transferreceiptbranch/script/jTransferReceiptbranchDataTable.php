<script type="text/javascript">
    var tTBIStaDocDoc    = $('#ohdTBIStaDoc').val();
    var tTBIStaApvDoc    = $('#ohdTBIStaApv').val();
    var tTBIStaPrcStkDoc = $('#ohdTBIStaPrcStk').val();

    $(document).ready(function(){
        // ======================================================= Set Edit In Line Pdt Doc Temp =======================================================
            if((tTBIStaDocDoc == 3) || (tTBIStaApvDoc == 1 && tTBIStaPrcStkDoc == 1)){
                $('#otbTBIDocPdtAdvTableList .xCNPIBeHideMQSS').hide();
            }else{
                var oParameterEditInLine    = {
                    "DocModules"                    : "",
                    "FunctionName"                  : "JSxTBISaveEditInline",
                    "DataAttribute"                 : ['data-field', 'data-seq', 'data-maxqty', 'data-oldqty'],
                    "TableID"                       : "otbTBIDocPdtAdvTableList",
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
            $('#otbTBIDocPdtAdvTableList #odvTBodyTBIPdtAdvTableList .ocbListItem').unbind().click(function(){
                let tTBIDocNo    = $('#oetTBIDocNo').val();
                let tTBISeqNo    = $(this).parents('.xWPdtItem').data('seqno');
                let tTBIPdtCode  = $(this).parents('.xWPdtItem').data('pdtcode');
                let tTBIPunCode  = $(this).parents('.xWPdtItem').data('puncode');
                $(this).prop('checked', true);
                let oLocalItemDTTemp    = localStorage.getItem("TBI_LocalItemDataDelDtTemp");
                let oDataObj            = [];
                if(oLocalItemDTTemp){
                    oDataObj    = JSON.parse(oLocalItemDTTemp);
                }
                let aArrayConvert   = [JSON.parse(localStorage.getItem("TBI_LocalItemDataDelDtTemp"))];
                if(aArrayConvert == '' || aArrayConvert == null){
                    oDataObj.push({
                        'tDocNo'    : tTBIDocNo,
                        'tSeqNo'    : tTBISeqNo,
                        'tPdtCode'  : tTBIPdtCode,
                        'tPunCode'  : tTBIPunCode,
                    });
                    localStorage.setItem("TBI_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                    JSxTBITextInModalDelPdtDtTemp();
                }else{
                    var aReturnRepeat   = JStTBIFindObjectByKey(aArrayConvert[0],'tSeqNo',tTBISeqNo);
                    if(aReturnRepeat == 'None' ){
                        //ยังไม่ถูกเลือก
                        oDataObj.push({
                            'tDocNo'    : tTBIDocNo,
                            'tSeqNo'    : tTBISeqNo,
                            'tPdtCode'  : tTBIPdtCode,
                            'tPunCode'  : tTBIPunCode,
                        });
                        localStorage.setItem("TBI_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                        JSxTBITextInModalDelPdtDtTemp();
                    }else if(aReturnRepeat == 'Dupilcate'){
                        localStorage.removeItem("TBI_LocalItemDataDelDtTemp");
                        $(this).prop('checked', false);
                        var nLength = aArrayConvert[0].length;
                        for($i=0; $i<nLength; $i++){
                            if(aArrayConvert[0][$i].tSeqNo == tTBISeqNo){
                                delete aArrayConvert[0][$i];
                            }
                        }
                        var aNewarraydata   = [];
                        for($i=0; $i<nLength; $i++){
                            if(aArrayConvert[0][$i] != undefined){
                                aNewarraydata.push(aArrayConvert[0][$i]);
                            }
                        }
                        localStorage.setItem("TBI_LocalItemDataDelDtTemp",JSON.stringify(aNewarraydata));
                        JSxTBITextInModalDelPdtDtTemp();
                    }
                }
                JSxTBIShowButtonDelMutiDtTemp();
            });
        // =============================================================================================================================================

        // ==================================================== Event Confirm Delete PDT IN Tabel DT ===================================================
            $('#odvTBIModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function(){
                var nStaSession = JCNxFuncChkSessionExpired();
                if(typeof nStaSession !== "undefined" && nStaSession == 1){
                    JSnTBIRemovePdtDTTempMultiple();
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
    function JSxTBISaveEditInline(paParams){
        // console.log('JSxTBISaveEditInline: ', paParams);
        var oThisEl         = paParams['Element'];
        var tThisDisChgText = $(oThisEl).parents('tr.xWPdtItem').find('td label.xWPIDisChgDT').text().trim();

        var nSeqNo      = paParams.DataAttribute[1]['data-seq'];
        var tFieldName  = paParams.DataAttribute[0]['data-field'];
        var cMaxQty     = accounting.unformat(paParams.DataAttribute[2]['data-maxqty']);
        var cOldQty     = accounting.unformat(paParams.DataAttribute[3]['data-oldqty']);
        var tValue      = accounting.unformat(paParams.VeluesInline);
        var bIsDelDTDis = false;
        // console.log('tValue: '+tValue);
        // console.log('cMaxQty: '+cMaxQty);
        // console.log('cOldQty: '+cOldQty);

        if( tValue > cMaxQty ){
            FSvCMNSetMsgWarningDialog('จำนวนที่ระบุมากกว่า จำนวนที่สามารถรับได้');
            JSvTBILoadPdtDataTableHtml();
            return;
        }

        if(tThisDisChgText == ''){
            console.log('No Have Dis/Chage DT');
            // ไม่มีลด/ชาร์จ
            // var nSeqNo      = paParams.DataAttribute[1]['data-seq'];
            // var tFieldName  = paParams.DataAttribute[0]['data-field'];
            // var cMaxQty     = accounting.unformat(paParams.DataAttribute[2]['data-maxqty']);
            // var cOldQty     = accounting.unformat(paParams.DataAttribute[3]['data-oldqty']);
            // var tValue      = accounting.unformat(paParams.VeluesInline);
            var bIsDelDTDis = false;
            // console.log('tValue: '+tValue);
            // console.log('cMaxQty: '+cMaxQty);
            // console.log('cOldQty: '+cOldQty);
            FSvTBIEditPdtIntoTableDT(nSeqNo,tFieldName,tValue,bIsDelDTDis); 
        }else{
            console.log('Have Dis/Chage DT');
            // มีลด/ชาร์จ
            $('#odvTBIModalConfirmDeleteDTDis').modal({
                backdrop: 'static',
                show: true
            });
            
            $('#odvTBIModalConfirmDeleteDTDis #obtTBIConfirmDeleteDTDis').unbind();
            $('#odvTBIModalConfirmDeleteDTDis #obtTBIConfirmDeleteDTDis').one('click',function(){
                $('#odvTBIModalConfirmDeleteDTDis').modal('hide');
                $('.modal-backdrop').remove();
                // var nSeqNo      = paParams.DataAttribute[1]['data-seq'];
                // var tFieldName  = paParams.DataAttribute[0]['data-field'];
                // var tValue      = accounting.unformat(paParams.VeluesInline);
                var bIsDelDTDis = true;
                FSvTBIEditPdtIntoTableDT(nSeqNo,tFieldName,tValue,bIsDelDTDis);
            });

            $('#odvTBIModalConfirmDeleteDTDis #obtTBICancelDeleteDTDis').unbind();
            $('#odvTBIModalConfirmDeleteDTDis #obtTBICancelDeleteDTDis').one('click',function(){
                $('.modal-backdrop').remove();
                JSvTBILoadPdtDataTableHtml();
            });

            $('#odvTBIModalConfirmDeleteDTDis').modal('show')
        }
    }

    //Functionality: Call Modal Dis/Chage Doc DT
    //Parameters: object Event Click
    //Creator: 02/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View
    // ReturnType : View
    function JCNvTBICallModalDisChagDT(poEl){
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
            var oTBIDisChgParams = {
                DisChgType: 'disChgDT'
            };
            JSxTBIOpenDisChgPanel(oTBIDisChgParams);
        }else{
            JCNxShowMsgSessionExpired();
        }   
    }

    // Functionality: Pase Text Product Item In Modal Delete
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxTBITextInModalDelPdtDtTemp(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("TBI_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
        }else{
            var tTBITextDocNo   = "";
            var tTBITextSeqNo   = "";
            var tTBITextPdtCode = "";
            var tTBITextPunCode = "";
            $.each(aArrayConvert[0],function(nKey,aValue){
                tTBITextDocNo    += aValue.tDocNo;
                tTBITextDocNo    += " , ";

                tTBITextSeqNo    += aValue.tSeqNo;
                tTBITextSeqNo    += " , ";

                tTBITextPdtCode  += aValue.tPdtCode;
                tTBITextPdtCode  += " , ";

                tTBITextPunCode  += aValue.tPunCode;
                tTBITextPunCode  += " , ";
            });
            $('#odvTBIModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIDocNoDelete').val(tTBITextDocNo);
            $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBISeqNoDelete').val(tTBITextSeqNo);
            $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPdtCodeDelete').val(tTBITextPdtCode);
            $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPunCodeDelete').val(tTBITextPunCode);
        }
    }

    // Functionality: Show Button Delete Multiple DT Temp
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxTBIShowButtonDelMutiDtTemp(){
        var aArrayConvert = [JSON.parse(localStorage.getItem("TBI_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
            $("#odvTBIMngDelPdtInTableDT #oliTBIBtnDeleteMulti").addClass("disabled");
        }else{
            var nNumOfArr   = aArrayConvert[0].length;
            if(nNumOfArr > 1) {
                $("#odvTBIMngDelPdtInTableDT #oliTBIBtnDeleteMulti").removeClass("disabled");
            }else{
                $("#odvTBIMngDelPdtInTableDT #oliTBIBtnDeleteMulti").addClass("disabled");
            }
        }
    }

    //Functionality: Function Delete Product In Doc DT Temp
    //Parameters: object Event Click
    //Creator: 04/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View
    // ReturnType : View
    function JSnTBIDelPdtInDTTempSingle(poEl) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tVal    = $(poEl).parents("tr.xWPdtItem").attr("data-pdtcode");
            var tSeqno  = $(poEl).parents("tr.xWPdtItem").attr("data-seqno");
            $(poEl).parents("tr.xWPdtItem").remove();
            JSnTBIRemovePdtDTTempSingle(tSeqno, tVal);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    // // Functionality: Function Remove Product In Doc DT Temp
    // // Parameters: Event Btn Click Call Edit Document
    // // Creator: 04/07/2019 Wasin(Yoshi)
    // // LastUpdate: -
    // // Return: Status Add/Update Document
    // // ReturnType: object
    // function JSnTBIRemovePdtDTTempSingle(ptSeqNo,ptPdtCode){
    //     var tTBIDocNo        = $("#oetTBIDocNo").val();
    //     var tTBIBchCode      = $('#oetTBIFrmBchCode').val();
    //     var tTBIVatInOrEx    = $('#ocmTBIFrmSplInfoVatInOrEx').val();
    //     JCNxOpenLoading();
    //     $.ajax({
    //         type: "POST",
    //         url: "docTBIEventRemovePdtInDTTmp",
    //         data: {
    //             'tBchCode'      : tTBIBchCode,
    //             'tDocNo'        : tTBIDocNo,
    //             'nSeqNo'        : ptSeqNo,
    //             'tPdtCode'      : ptPdtCode,
    //             'tVatInOrEx'    : tTBIVatInOrEx,
    //         },
    //         cache: false,
    //         timeout: 0,
    //         success: function (tResult) {
    //             var aReturnData = JSON.parse(tResult);
    //             if(aReturnData['nStaEvent'] == '1'){
    //                 JSvTBILoadPdtDataTableHtml();
    //                 JCNxLayoutControll();
    //             }else{
    //                 var tMessageError   = aReturnData['tStaMessg'];
    //                 FSvCMNSetMsgErrorDialog(tMessageError);
    //                 JCNxCloseLoading();
    //             }
    //         },
    //         error: function (jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // }

    
    //Functionality: Remove Comma
    //Parameters: Event Button Delete All
    //Creator: 26/07/2019 Wasin
    //Return:  object Status Delete
    //Return Type: object
    function JSoTBIRemoveCommaData(paData){
        var aTexts              = paData.substring(0, paData.length - 2);
        var aDataSplit          = aTexts.split(" , ");
        var aDataSplitlength    = aDataSplit.length;
        var aNewDataDeleteComma = [];

        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewDataDeleteComma.push(aDataSplit[$i]);
        }
        return aNewDataDeleteComma;
    }

    // // Functionality: Fucntion Call Delete Multiple Doc DT Temp
    // // Parameters: Event Click List Table Delete Mutiple
    // // Creator: 26/07/2019 Wasin(Yoshi)
    // // Return: array Data Status Delete
    // // ReturnType: Array
    // function JSnTBIRemovePdtDTTempMultiple(){
    //     JCNxOpenLoading();
    //     var tTBIDocNo        = $("#oetTBIDocNo").val();
    //     var tTBIBchCode      = $('#oetTBIFrmBchCode').val();
    //     var tTBIVatInOrEx    = $('#ocmTBIFrmSplInfoVatInOrEx').val();
    //     var aDataPdtCode    = JSoTBIRemoveCommaData($('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPdtCodeDelete').val());
    //     var aDataPunCode    = JSoTBIRemoveCommaData($('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPunCodeDelete').val());
    //     var aDataSeqNo      = JSoTBIRemoveCommaData($('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBISeqNoDelete').val());
    //     $.ajax({
    //         type: "POST",
    //         url: "docTBIEventRemovePdtInDTTmpMulti",
    //         data: {
    //             'ptTBIBchCode'   : tTBIBchCode,
    //             'ptTBIDocNo'     : tTBIDocNo,
    //             'ptTBIVatInOrEx' : tTBIVatInOrEx,
    //             'paDataPdtCode' : aDataPdtCode,
    //             'paDataPunCode' : aDataPunCode,
    //             'paDataSeqNo'   : aDataSeqNo,
    //         },
    //         cache: false,
    //         timeout: 0,
    //         success: function (tResult) {
    //             var aReturnData = JSON.parse(tResult);
    //             if(aReturnData['nStaEvent'] == '1'){
    //                 $('#odvTBIModalDelPdtInDTTempMultiple').modal('hide');
    //                 $('#odvTBIModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
    //                 localStorage.removeItem('TBI_LocalItemDataDelDtTemp');
    //                 $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIDocNoDelete').val('');
    //                 $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBISeqNoDelete').val('');
    //                 $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPdtCodeDelete').val('');
    //                 $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPunCodeDelete').val('');
    //                 setTimeout(function(){
    //                     $('.modal-backdrop').remove();
    //                     JSvTBILoadPdtDataTableHtml();
    //                     JCNxLayoutControll();
    //                 }, 500);
    //             }else{
    //                 var tMessageError   = aReturnData['tStaMessg'];
    //                 FSvCMNSetMsgErrorDialog(tMessageError);
    //                 JCNxCloseLoading();
    //             }
    //         },  
    //         error: function (jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // }

    







</script>