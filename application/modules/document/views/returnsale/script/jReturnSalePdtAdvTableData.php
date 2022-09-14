<script type="text/javascript">
    var tRSStaDocDoc    = $('#ohdRSStaDoc').val();
    var tRSStaApvDoc    = $('#ohdRSStaApv').val();
    var tRSStaPrcStkDoc = $('#ohdRSStaPrcStk').val();

    $(document).ready(function(){
        // ======================================================= Set Edit In Line Pdt Doc Temp =======================================================
            // if((tRSStaDocDoc == 3) || (tRSStaApvDoc == 1 && tRSStaPrcStkDoc == 1)){
            //     $('#otbRSDocPdtAdvTableList .xCNPIBeHideMQSS').hide();
            // }else{
            //     var oParameterEditInLine    = {
            //         "DocModules"                    : "",
            //         "FunctionName"                  : "JSxRSSaveEditInline",
            //         "DataAttribute"                 : ['data-field', 'data-seq'],
            //         "TableID"                       : "otbRSDocPdtAdvTableList",
            //         "NotFoundDataRowClass"          : "xWPITextNotfoundDataPdtTable",
            //         "EditInLineButtonDeleteClass"   : "xWPIDeleteBtnEditButtonPdt",
            //         "LabelShowDataClass"            : "xWShowInLine",
            //         "DivHiddenDataEditClass"        : "xWEditInLine"
            //     }
            //     JCNxSetNewEditInline(oParameterEditInLine);

            //     $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
            //     $(".xWEditInlineElement").eq(nIndexInputEditInline).select();

            //     $(".xWEditInlineElement").removeAttr("disabled");


            //     let oElement = $(".xWEditInlineElement");
            //     for(let nI=0;nI<oElement.length;nI++){
            //         $(oElement.eq(nI)).val($(oElement.eq(nI)).val().trim());
            //     }
            // }
        // =============================================================================================================================================
            
        // ================================================ Event Click Delete Multiple PDT IN Table DT ================================================
        // function FSxSOSelectMulDel(ptElm){
        //     // $('#otbRSDocPdtAdvTableList #odvTBodySOPdtAdvTableList .ocbListItem').click(function(){
        //         console.log('Enter Del');
        //         let tRSDocNo    = $('#oetRSDocNo').val();
        //         let tRSSeqNo    = $(ptElm).parents('.xWPdtItem').data('seqno');
        //         let tRSPdtCode  = $(ptElm).parents('.xWPdtItem').data('pdtcode');
        //         console.log(tRSPdtCode);
        //         // let tRSPunCode  = $(this).parents('.xWPdtItem').data('puncode');
        //         $(ptElm).prop('checked', true);
        //         let oLocalItemDTTemp    = localStorage.getItem("RS_LocalItemDataDelDtTemp");
        //         let oDataObj            = [];
        //         if(oLocalItemDTTemp){
        //             oDataObj    = JSON.parse(oLocalItemDTTemp);
        //         }
        //         let aArrayConvert   = [JSON.parse(localStorage.getItem("RS_LocalItemDataDelDtTemp"))];
        //         if(aArrayConvert == '' || aArrayConvert == null){
        //             oDataObj.push({
        //                 'tDocNo'    : tRSDocNo,
        //                 'tSeqNo'    : tRSSeqNo,
        //                 'tPdtCode'  : tRSPdtCode,
        //                 // 'tPunCode'  : tRSPunCode,
        //             });
        //             localStorage.setItem("RS_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
        //             JSxRSTextInModalDelPdtDtTemp();
        //         }else{
        //             var aReturnRepeat   = JStRSFindObjectByKey(aArrayConvert[0],'tSeqNo',tRSSeqNo);
        //             if(aReturnRepeat == 'None' ){
        //                 //ยังไม่ถูกเลือก
        //                 oDataObj.push({
        //                     'tDocNo'    : tRSDocNo,
        //                     'tSeqNo'    : tRSSeqNo,
        //                     'tPdtCode'  : tRSPdtCode,
        //                     // 'tPunCode'  : tRSPunCode,
        //                 });
        //                 localStorage.setItem("RS_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
        //                 JSxRSTextInModalDelPdtDtTemp();
        //             }else if(aReturnRepeat == 'Dupilcate'){
        //                 localStorage.removeItem("RS_LocalItemDataDelDtTemp");
        //                 $(ptElm).prop('checked', false);
        //                 var nLength = aArrayConvert[0].length;
        //                 for($i=0; $i<nLength; $i++){
        //                     if(aArrayConvert[0][$i].tSeqNo == tRSSeqNo){
        //                         delete aArrayConvert[0][$i];
        //                     }
        //                 }
        //                 var aNewarraydata   = [];
        //                 for($i=0; $i<nLength; $i++){
        //                     if(aArrayConvert[0][$i] != undefined){
        //                         aNewarraydata.push(aArrayConvert[0][$i]);
        //                     }
        //                 }
        //                 localStorage.setItem("RS_LocalItemDataDelDtTemp",JSON.stringify(aNewarraydata));
        //                 JSxRSTextInModalDelPdtDtTemp();
        //             }
        //         }
        //         JSxRSShowButtonDelMutiDtTemp();
        //     // });
        // }
        // =============================================================================================================================================

        // ==================================================== Event Confirm Delete PDT IN Tabel DT ===================================================
            $('#odvRSModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function(){
                // var nStaSession = JCNxFuncChkSessionExpired();
                var nStaSession = 1;
                if(typeof nStaSession !== "undefined" && nStaSession == 1){
                    JCNxOpenLoading();
                    JSnRSRemovePdtDTTempMultiple();
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
    function JSxRSSaveEditInline(paParams){
        console.log('JSxRSSaveEditInline: ', paParams);
        var oThisEl         = paParams['Element'];
        var tThisDisChgText = $(oThisEl).parents('tr.xWPdtItem').find('td label.xWPIDisChgDT').text().trim();
        if(tThisDisChgText == ''){
            console.log('No Have Dis/Chage DT');
            // ไม่มีลด/ชาร์จ
            var nSeqNo      = paParams.DataAttribute[1]['data-seq'];
            var tFieldName  = paParams.DataAttribute[0]['data-field'];
            var tValue      = accounting.unformat(paParams.VeluesInline);
            var bIsDelDTDis = false;
            FSvRSEditPdtIntoTableDT(nSeqNo,tFieldName,tValue,bIsDelDTDis); 
        }else{
            console.log('Have Dis/Chage DT');
            // มีลด/ชาร์จ
            $('#odvRSModalConfirmDeleteDTDis').modal({
                backdrop: 'static',
                show: true
            });
            
            $('#odvRSModalConfirmDeleteDTDis #obtRSConfirmDeleteDTDis').unbind();
            $('#odvRSModalConfirmDeleteDTDis #obtRSConfirmDeleteDTDis').one('click',function(){
                $('#odvRSModalConfirmDeleteDTDis').modal('hide');
                $('.modal-backdrop').remove();
                var nSeqNo      = paParams.DataAttribute[1]['data-seq'];
                var tFieldName  = paParams.DataAttribute[0]['data-field'];
                var tValue      = accounting.unformat(paParams.VeluesInline);
                var bIsDelDTDis = true;
                FSvRSEditPdtIntoTableDT(nSeqNo,tFieldName,tValue,bIsDelDTDis);
            });

            $('#odvRSModalConfirmDeleteDTDis #obtRSCancelDeleteDTDis').unbind();
            $('#odvRSModalConfirmDeleteDTDis #obtRSCancelDeleteDTDis').one('click',function(){
                $('.modal-backdrop').remove();
                JSvSOLoadPdtDataTableHtml();
            });

            $('#odvRSModalConfirmDeleteDTDis').modal('show')
        }
    }

    //Functionality: Call Modal Dis/Chage Doc DT
    //Parameters: object Event Click
    //Creator: 02/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View
    // ReturnType : View
    function JCNvRSCallModalDisChagDT(poEl){
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if(typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tDocNo          = $(poEl).parents('.xWPdtItem').attr('data-docno');
            var tPdtCode        = $(poEl).parents('.xWPdtItem').attr('data-pdtcode');
            var tPdtName        = $(poEl).parents('.xWPdtItem').attr('data-pdtname');
            var tPunCode        = $(poEl).parents('.xWPdtItem').attr('data-puncode');
            var tNet            = $(poEl).parents('.xWPdtItem').attr('data-net');
            var tSetPrice       = $(poEl).parents('.xWPdtItem').attr('data-setprice'); //$(poEl).parents('.xWPdtItem').data('setprice');
            var tQty            = $(poEl).parents('.xWPdtItem').attr('data-qty'); //$(poEl).parents('.xWPdtItem').data('qty');
            var tStaDis         = $(poEl).parents('.xWPdtItem').attr('data-stadis');
            var tSeqNo          = $(poEl).parents('.xWPdtItem').attr('data-seqno');
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
            var oRSDisChgParams = {
                DisChgType: 'disChgDT'
            };
            JSxRSOpenDisChgPanel(oRSDisChgParams);
        }else{
            JCNxShowMsgSessionExpired();
        }   
    }

    // Functionality: Pase Text Product Item In Modal Delete
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxRSTextInModalDelPdtDtTemp(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("RS_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
        }else{
            var tRSTextDocNo   = "";
            var tRSTextSeqNo   = "";
            var tRSTextPdtCode = "";
            // var tRSTextPunCode = "";
            // var tRSTextBarCode = "";
            $.each(aArrayConvert[0],function(nKey,aValue){
                tRSTextDocNo    += aValue.tDocNo;
                tRSTextDocNo    += " , ";

                tRSTextSeqNo    += aValue.tSeqNo;
                tRSTextSeqNo    += " , ";

                tRSTextPdtCode  += aValue.tPdtCode;
                tRSTextPdtCode  += " , ";

                // tRSTextPunCode  += aValue.tPunCode;
                // tRSTextPunCode  += " , ";

                // tRSTextBarCode  += aValue.tBarCode;
                // tRSTextBarCode  += " , ";
            });
            $('#odvRSModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSDocNoDelete').val(tRSTextDocNo);
            $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSSeqNoDelete').val(tRSTextSeqNo);
            $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSPdtCodeDelete').val(tRSTextPdtCode);
            // $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSBarCodeDelete').val(tRSTextBarCode);
            // $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSPunCodeDelete').val(tRSTextPunCode);
        }
    }

    // Functionality: Show Button Delete Multiple DT Temp
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxRSShowButtonDelMutiDtTemp(){
        var aArrayConvert = [JSON.parse(localStorage.getItem("RS_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
            $("#odvRSMngDelPdtInTableDT #oliRSBtnDeleteMulti").addClass("disabled");
        }else{
            var nNumOfArr   = aArrayConvert[0].length;
            if(nNumOfArr > 1) {
                $("#odvRSMngDelPdtInTableDT #oliRSBtnDeleteMulti").removeClass("disabled");
            }else{
                $("#odvRSMngDelPdtInTableDT #oliRSBtnDeleteMulti").addClass("disabled");
            }
        }
    }

    //Functionality: Function Delete Product In Doc DT Temp
    //Parameters: object Event Click
    //Creator: 04/07/2019 Wasin(Yoshi)
    // LastUpdate: 27/05/2020 Napat(jame)
    // Return: View
    // ReturnType : View
    function JSnRSDelPdtInDTTempSingle(poEl) {
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JCNxOpenLoading();
            var tPdtCode = $(poEl).parents("tr.xWPdtItem").attr("data-pdtcode");
            var tSeqno   = $(poEl).parents("tr.xWPdtItem").attr("data-key");
            $(poEl).parents("tr.xWPdtItem").remove();
            JSnRSRemovePdtDTTempSingle(tSeqno, tPdtCode);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality: Function Remove Product In Doc DT Temp
    // Parameters: Event Btn Click Call Edit Document
    // Creator: 04/07/2019 Wasin(Yoshi)
    // LastUpdate: 27/05/2020 Napat(jame)
    // Return: Status Add/Update Document
    // ReturnType: object
    function JSnRSRemovePdtDTTempSingle(ptSeqNo,ptPdtCode){
        var tRSDocNo        = $("#oetRSDocNo").val();
        var tRSBchCode      = $('#oetRSFrmBchCode').val();
        var tRSVatInOrEx    = $('#ocmRSFrmSplInfoVatInOrEx').val();

        JSxRendercalculate();
        JCNxCloseLoading();

        $.ajax({
            type: "POST",
            url: "dcmRSRemovePdtInDTTmp",
            data: {
                'tBchCode'      : tRSBchCode,
                'tDocNo'        : tRSDocNo,
                'nSeqNo'        : ptSeqNo,
                'tPdtCode'      : ptPdtCode,
                'tVatInOrEx'    : tRSVatInOrEx,
                'ohdSesSessionID'   : $('#ohdSesSessionID').val(),
                'ohdRSUsrCode'        : $('#ohdRSUsrCode').val(),
                'ohdRSLangEdit'       : $('#ohdRSLangEdit').val(),
                'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
                'ohdRSSesUsrBchCode'  : $('#ohdRSSesUsrBchCode').val(),
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    // JSvSOLoadPdtDataTableHtml();
                    JCNxLayoutControll();
                    var tCheckIteminTable = $('#otbRSDocPdtAdvTableList tbody tr').length;
                    if(tCheckIteminTable==0){
                    $('#otbRSDocPdtAdvTableList').append('<tr style="background-color: rgb(255, 255, 255);"><td class="text-center xCNTextDetail2 xCNTextNotfoundDataPdtTable" colspan="100%">ไม่พบข้อมูล</td></tr>');
                }
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                // JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                JSnRSRemovePdtDTTempSingle(ptSeqNo,ptPdtCode)
            }
        });
    }

    
    //Functionality: Remove Comma
    //Parameters: Event Button Delete All
    //Creator: 26/07/2019 Wasin
    //Return:  object Status Delete
    //Return Type: object
    function JSoRSRemoveCommaData(paData){
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
    // Last Update: 27/05/2020 Napat(Jame)
    // Return: array Data Status Delete
    // ReturnType: Array
    function JSnRSRemovePdtDTTempMultiple(){
        // JCNxOpenLoading();
        var tRSDocNo        = $("#oetRSDocNo").val();
        var tRSBchCode      = $('#oetRSFrmBchCode').val();
        var tRSVatInOrEx    = $('#ocmRSFrmSplInfoVatInOrEx').val();
        var aDataPdtCode    = JSoRSRemoveCommaData($('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSPdtCodeDelete').val());
        // var aDataBarCode    = JSoRSRemoveCommaData($('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSBarCodeDelete').val());
        // var aDataPunCode    = JSoRSRemoveCommaData($('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSPunCodeDelete').val());
        var aDataSeqNo      = JSoRSRemoveCommaData($('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSSeqNoDelete').val());

        for(var i=0;i<aDataSeqNo.length;i++){
            $('.xWPdtItemList'+aDataSeqNo[i]).remove();
        }

        $('#odvRSModalDelPdtInDTTempMultiple').modal('hide');
        $('#odvRSModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
        localStorage.removeItem('RS_LocalItemDataDelDtTemp');
        $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSDocNoDelete').val('');
        $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSSeqNoDelete').val('');
        $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSPdtCodeDelete').val('');
        // $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSBarCodeDelete').val('');
        // $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSPunCodeDelete').val('');
        setTimeout(function(){
            $('.modal-backdrop').remove();
            // JSvSOLoadPdtDataTableHtml();
            JCNxLayoutControll();
        }, 500);

        JSxRendercalculate();
        JCNxCloseLoading();

        $.ajax({
            type: "POST",
            url: "dcmRSRemovePdtInDTTmpMulti",
            data: {
                'ptRSBchCode'   : tRSBchCode,
                'ptRSDocNo'     : tRSDocNo,
                'ptRSVatInOrEx' : tRSVatInOrEx,
                'paDataPdtCode' : aDataPdtCode,
                // 'paDataPunCode' : aDataPunCode,
                'paDataSeqNo'   : aDataSeqNo,
                'ohdSesSessionID'   : $('#ohdSesSessionID').val(),
                'ohdRSUsrCode'        : $('#ohdRSUsrCode').val(),
                'ohdRSLangEdit'       : $('#ohdRSLangEdit').val(),
                'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
                'ohdRSSesUsrBchCode'  : $('#ohdRSSesUsrBchCode').val(),
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {

                var tCheckIteminTable = $('#otbRSDocPdtAdvTableList tbody tr').length;

                if(tCheckIteminTable==0){
                    $('#otbRSDocPdtAdvTableList').append('<tr style="background-color: rgb(255, 255, 255);"><td class="text-center xCNTextDetail2 xCNTextNotfoundDataPdtTable" colspan="100%">ไม่พบข้อมูล</td></tr>');
                }
                // var aReturnData = JSON.parse(tResult);
                // if(aReturnData['nStaEvent'] == '1'){
                //     $('#odvRSModalDelPdtInDTTempMultiple').modal('hide');
                //     $('#odvRSModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
                //     localStorage.removeItem('RS_LocalItemDataDelDtTemp');
                //     $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSDocNoDelete').val('');
                //     $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSSeqNoDelete').val('');
                //     $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSPdtCodeDelete').val('');
                //     // $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSBarCodeDelete').val('');
                //     // $('#odvRSModalDelPdtInDTTempMultiple #ohdConfirmRSPunCodeDelete').val('');
                //     setTimeout(function(){
                //         $('.modal-backdrop').remove();
                //         // JSvSOLoadPdtDataTableHtml();
                //         JCNxLayoutControll();
                //     }, 500);
                // }else{
                //     var tMessageError   = aReturnData['tStaMessg'];
                //     FSvCMNSetMsgErrorDialog(tMessageError);
                //     // JCNxCloseLoading();
                // }
            },  
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                JSnRSRemovePdtDTTempMultiple()
            }
        });
    }

    







</script>