<script type="text/javascript">
    var tPOStaDocDoc    = $('#ohdPOStaDoc').val();
    var tPOStaApvDoc    = $('#ohdPOStaApv').val();
    var tPOStaPrcStkDoc = $('#ohdPOStaPrcStk').val();

    $(document).ready(function(){

        // ==================================================== Event Confirm Delete PDT IN Tabel DT ===================================================
            $('#odvPOModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function(){
                // var nStaSession = JCNxFuncChkSessionExpired();
                var nStaSession = 1;
                if(typeof nStaSession !== "undefined" && nStaSession == 1){
                    JCNxOpenLoading();
                    JSnPORemovePdtDTTempMultiple();
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
    function JSxPOSaveEditInline(paParams){
        console.log('JSxPOSaveEditInline: ', paParams);
        var oThisEl         = paParams['Element'];
        var tThisDisChgText = $(oThisEl).parents('tr.xWPdtItem').find('td label.xWPIDisChgDT').text().trim();
        if(tThisDisChgText == ''){
            console.log('No Have Dis/Chage DT');
            // ไม่มีลด/ชาร์จ
            var nSeqNo      = paParams.DataAttribute[1]['data-seq'];
            var tFieldName  = paParams.DataAttribute[0]['data-field'];
            var tValue      = accounting.unformat(paParams.VeluesInline);
            var bIsDelDTDis = false;
            FSvPOEditPdtIntoTableDT(nSeqNo,tFieldName,tValue,bIsDelDTDis); 
        }else{
            console.log('Have Dis/Chage DT');
            // มีลด/ชาร์จ
            $('#odvPOModalConfirmDeleteDTDis').modal({
                backdrop: 'static',
                show: true
            });
            
            $('#odvPOModalConfirmDeleteDTDis #obtPOConfirmDeleteDTDis').unbind();
            $('#odvPOModalConfirmDeleteDTDis #obtPOConfirmDeleteDTDis').one('click',function(){
                $('#odvPOModalConfirmDeleteDTDis').modal('hide');
                $('.modal-backdrop').remove();
                var nSeqNo      = paParams.DataAttribute[1]['data-seq'];
                var tFieldName  = paParams.DataAttribute[0]['data-field'];
                var tValue      = accounting.unformat(paParams.VeluesInline);
                var bIsDelDTDis = true;
                FSvPOEditPdtIntoTableDT(nSeqNo,tFieldName,tValue,bIsDelDTDis);
            });

            $('#odvPOModalConfirmDeleteDTDis #obtPOCancelDeleteDTDis').unbind();
            $('#odvPOModalConfirmDeleteDTDis #obtPOCancelDeleteDTDis').one('click',function(){
                $('.modal-backdrop').remove();
                JSvPOLoadPdtDataTableHtml();
            });

            $('#odvPOModalConfirmDeleteDTDis').modal('show')
        }
    }

    //Functionality: Call Modal Dis/Chage Doc DT
    //Parameters: object Event Click
    //Creator: 02/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View
    // ReturnType : View
    function JCNvPOCallModalDisChagDT(poEl){
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

            console.log("DisChgDataRowDT",DisChgDataRowDT);
            var oPODisChgParams = {
                DisChgType: 'disChgDT'
            };
            JSxPOOpenDisChgPanel(oPODisChgParams);
        }else{
            JCNxShowMsgSessionExpired();
        }   
    }

    // Functionality: Pase Text Product Item In Modal Delete
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxPOTextInModalDelPdtDtTemp(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("PO_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
        }else{
            var tPOTextDocNo   = "";
            var tPOTextSeqNo   = "";
            var tPOTextPdtCode = "";
            // var tPOTextPunCode = "";
            // var tPOTextBarCode = "";
            $.each(aArrayConvert[0],function(nKey,aValue){
                tPOTextDocNo    += aValue.tDocNo;
                tPOTextDocNo    += " , ";

                tPOTextSeqNo    += aValue.tSeqNo;
                tPOTextSeqNo    += " , ";

                tPOTextPdtCode  += aValue.tPdtCode;
                tPOTextPdtCode  += " , ";

                // tPOTextPunCode  += aValue.tPunCode;
                // tPOTextPunCode  += " , ";

                // tPOTextBarCode  += aValue.tBarCode;
                // tPOTextBarCode  += " , ";
            });
            $('#odvPOModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPODocNoDelete').val(tPOTextDocNo);
            $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOSeqNoDelete').val(tPOTextSeqNo);
            $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOPdtCodeDelete').val(tPOTextPdtCode);
            // $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOBarCodeDelete').val(tPOTextBarCode);
            // $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOPunCodeDelete').val(tPOTextPunCode);
        }
    }

    // Functionality: Show Button Delete Multiple DT Temp
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxPOShowButtonDelMutiDtTemp(){
        var aArrayConvert = [JSON.parse(localStorage.getItem("PO_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
            $("#odvPOMngDelPdtInTableDT #oliPOBtnDeleteMulti").addClass("disabled");
        }else{
            var nNumOfArr   = aArrayConvert[0].length;
            if(nNumOfArr > 1) {
                $("#odvPOMngDelPdtInTableDT #oliPOBtnDeleteMulti").removeClass("disabled");
            }else{
                $("#odvPOMngDelPdtInTableDT #oliPOBtnDeleteMulti").addClass("disabled");
            }
        }
    }

    //Functionality: Function Delete Product In Doc DT Temp
    //Parameters: object Event Click
    //Creator: 04/07/2019 Wasin(Yoshi)
    // LastUpdate: 27/05/2020 Napat(jame)
    // Return: View
    // ReturnType : View
    function JSnPODelPdtInDTTempSingle(poEl) {
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JCNxOpenLoading();
            var tPdtCode = $(poEl).parents("tr.xWPdtItem").attr("data-pdtcode");
            var tSeqno   = $(poEl).parents("tr.xWPdtItem").attr("data-key");
            $(poEl).parents("tr.xWPdtItem").remove();
            JSnPORemovePdtDTTempSingle(tSeqno, tPdtCode);
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
    function JSnPORemovePdtDTTempSingle(ptSeqNo,ptPdtCode){
        var tPODocNo        = $("#oetPODocNo").val();
        var tPOBchCode      = $('#oetPOFrmBchCode').val();
        var tPOVatInOrEx    = $('#ocmPOFrmSplInfoVatInOrEx').val();

        JSxRendercalculate();
        JCNxCloseLoading();

        $.ajax({
            type: "POST",
            url: "docPORemovePdtInDTTmp",
            data: {
                'tBchCode'      : tPOBchCode,
                'tDocNo'        : tPODocNo,
                'nSeqNo'        : ptSeqNo,
                'tPdtCode'      : ptPdtCode,
                'tVatInOrEx'    : tPOVatInOrEx,
                'ohdPesSessionID'   : $('#ohdPesSessionID').val(),
                'ohdPOUsrCode'        : $('#ohdPOUsrCode').val(),
                'ohdPOLangEdit'       : $('#ohdPOLangEdit').val(),
                'ohdPesUsrLevel'      : $('#ohdPesUsrLevel').val(),
                'ohdPOSesUsrBchCode'  : $('#ohdPOSesUsrBchCode').val(),
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    // JSvPOLoadPdtDataTableHtml()
                    JSvPOCallEndOfBill();
                    JCNxLayoutControll();
                    var tCheckIteminTable = $('#otbPODocPdtAdvTableList tbody tr').length;
                    if(tCheckIteminTable==0){
                    $('#otbPODocPdtAdvTableList').append('<tr style="background-color: rgb(255, 255, 255);"><td class="text-center xCNTextDetail2 xCNTextNotfoundDataPdtTable" colspan="100%">ไม่พบข้อมูล</td></tr>');
                }
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                // JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                JSnPORemovePdtDTTempSingle(ptSeqNo,ptPdtCode)
            }
        });
    }

    
    //Functionality: Remove Comma
    //Parameters: Event Button Delete All
    //Creator: 26/07/2019 Wasin
    //Return:  object Status Delete
    //Return Type: object
    function JSoPORemoveCommaData(paData){
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
    function JSnPORemovePdtDTTempMultiple(){
        // JCNxOpenLoading();
        var tPODocNo        = $("#oetPODocNo").val();
        var tPOBchCode      = $('#oetPOFrmBchCode').val();
        var tPOVatInOrEx    = $('#ocmPOFrmSplInfoVatInOrEx').val();
        var aDataPdtCode    = JSoPORemoveCommaData($('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOPdtCodeDelete').val());
        // var aDataBarCode    = JSoPORemoveCommaData($('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOBarCodeDelete').val());
        // var aDataPunCode    = JSoPORemoveCommaData($('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOPunCodeDelete').val());
        var aDataSeqNo      = JSoPORemoveCommaData($('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOSeqNoDelete').val());

        for(var i=0;i<aDataSeqNo.length;i++){
            $('.xWPdtItemList'+aDataSeqNo[i]).remove();
        }

        $('#odvPOModalDelPdtInDTTempMultiple').modal('hide');
        $('#odvPOModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
        localStorage.removeItem('PO_LocalItemDataDelDtTemp');
        $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPODocNoDelete').val('');
        $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOSeqNoDelete').val('');
        $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOPdtCodeDelete').val('');
        // $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOBarCodeDelete').val('');
        // $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOPunCodeDelete').val('');
        setTimeout(function(){
            $('.modal-backdrop').remove();
            // JSvPOLoadPdtDataTableHtml();
            JCNxLayoutControll();
        }, 500);

        JSxRendercalculate();
        JCNxCloseLoading();

        $.ajax({
            type: "POST",
            url: "docPORemovePdtInDTTmpMulti",
            data: {
                'ptPOBchCode'   : tPOBchCode,
                'ptPODocNo'     : tPODocNo,
                'ptPOVatInOrEx' : tPOVatInOrEx,
                'paDataPdtCode' : aDataPdtCode,
                // 'paDataPunCode' : aDataPunCode,
                'paDataSeqNo'   : aDataSeqNo,
                'ohdPesSessionID'   : $('#ohdPesSessionID').val(),
                'ohdPOUsrCode'        : $('#ohdPOUsrCode').val(),
                'ohdPOLangEdit'       : $('#ohdPOLangEdit').val(),
                'ohdPesUsrLevel'      : $('#ohdPesUsrLevel').val(),
                'ohdPOSesUsrBchCode'  : $('#ohdPOSesUsrBchCode').val(),
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {

                var tCheckIteminTable = $('#otbPODocPdtAdvTableList tbody tr').length;

                if(tCheckIteminTable==0){
                    $('#otbPODocPdtAdvTableList').append('<tr style="background-color: rgb(255, 255, 255);"><td class="text-center xCNTextDetail2 xCNTextNotfoundDataPdtTable" colspan="100%">ไม่พบข้อมูล</td></tr>');
                }
                // var aReturnData = JSON.parse(tResult);
                // if(aReturnData['nStaEvent'] == '1'){
                //     $('#odvPOModalDelPdtInDTTempMultiple').modal('hide');
                //     $('#odvPOModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
                //     localStorage.removeItem('PO_LocalItemDataDelDtTemp');
                //     $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPODocNoDelete').val('');
                //     $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOSeqNoDelete').val('');
                //     $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOPdtCodeDelete').val('');
                //     // $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOBarCodeDelete').val('');
                //     // $('#odvPOModalDelPdtInDTTempMultiple #ohdConfirmPOPunCodeDelete').val('');
                //     setTimeout(function(){
                //         $('.modal-backdrop').remove();
                //         // JSvPOLoadPdtDataTableHtml();
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
                JSnPORemovePdtDTTempMultiple()
            }
        });
    }

    







</script>