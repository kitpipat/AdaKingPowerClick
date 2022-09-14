<script type="text/javascript">
    var tSOStaDocDoc    = $('#ohdSOStaDoc').val();
    var tSOStaApvDoc    = $('#ohdSOStaApv').val();
    var tSOStaPrcStkDoc = $('#ohdSOStaPrcStk').val();

    $(document).ready(function(){
        // ======================================================= Set Edit In Line Pdt Doc Temp =======================================================
            if((tSOStaDocDoc == 3) || (tSOStaApvDoc == 1 && tSOStaPrcStkDoc == 1)){
                $('#otbSODocPdtAdvTableList .xCNPIBeHideMQSS').hide();
            }else{
                // var oParameterEditInLine    = {
                //     "DocModules"                    : "",
                //     "FunctionName"                  : "JSxSOSaveEditInline",
                //     "DataAttribute"                 : ['data-field', 'data-seq'],
                //     "TableID"                       : "otbSODocPdtAdvTableList",
                //     "NotFoundDataRowClass"          : "xWPITextNotfoundDataPdtTable",
                //     "EditInLineButtonDeleteClass"   : "xWPIDeleteBtnEditButtonPdt",
                //     "LabelShowDataClass"            : "xWShowInLine",
                //     "DivHiddenDataEditClass"        : "xWEditInLine"
                // }
                // JCNxSetNewEditInline(oParameterEditInLine);

                // $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
                // $(".xWEditInlineElement").eq(nIndexInputEditInline).select();

                // $(".xWEditInlineElement").removeAttr("disabled");


                // let oElement = $(".xWEditInlineElement");
                // for(let nI=0;nI<oElement.length;nI++){
                //     $(oElement.eq(nI)).val($(oElement.eq(nI)).val().trim());
                // }
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
            FSvSOEditPdtIntoTableDT(nSeqNo,tFieldName,tValue,bIsDelDTDis); 
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
                FSvSOEditPdtIntoTableDT(nSeqNo,tFieldName,tValue,bIsDelDTDis);
            });

            $('#odvSOModalConfirmDeleteDTDis #obtSOCancelDeleteDTDis').unbind();
            $('#odvSOModalConfirmDeleteDTDis #obtSOCancelDeleteDTDis').one('click',function(){
                $('.modal-backdrop').remove();
                JSvSOLoadPdtDataTableHtml();
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

    //แสดงหน้าป็อปอัพลบสินค้า
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

    //แสดงหน้าป็อปอัพเหตุผล
    function JSxInsertReasonPDTDrug(poEl){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tVal        = $(poEl).parents("tr.xWPdtItem").attr("data-pdtcode");
            var tSeqno      = $(poEl).parents("tr.xWPdtItem").attr("data-seqno");
            $('#odvSOModalKeyReasonDrug').modal('show');
            JSxGetReasoninDT(tVal,tSeqno);
            $('#oetReasonPDTSeq').val(tSeqno);
            $('#oetReasonPDTCode').val(tVal);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ไปดึงค่าเหตุผลมาใส่กลับ
    function JSxGetReasoninDT(tPdtCode,tSeq){
        $.ajax({
            type    : "POST",
            url     : "dcmSOGetReasoninDT_STD",
            data    : {
                'tSeq'      : tSeq,
                'tPdtCode'  : tPdtCode
            },
            cache   : false,
            timeout : 0,
            success : function (oResult){
                var tResult = JSON.parse(oResult);
                $('#oetReasonPDTDrug').val(tResult);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //กรอกเหตุผล พร้อมบันทึก
    function JSxInsertReasoDrugToTmp(){
        var tSeq        = $('#oetReasonPDTSeq').val();
        var tPDTCode    = $('#oetReasonPDTCode').val();
        var tReason     = $('#oetReasonPDTDrug').val();
        $.ajax({
            type    : "POST",
            url     : "dcmSOUpdateReasoninDT_STD",
            data    : {
                'tSeq'      : tSeq,
                'tPDTCode'  : tPDTCode,
                'tReason'   : tReason
            },
            cache: false,
            timeout: 0,
            success: function (oResult){
                JSvSOLoadPdtDataTableHtml();
                $('#odvSOModalKeyReasonDrug').modal('hide');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
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
            url: "dcmSORemovePdtInDTTmp_STD",
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
                    JSvSOLoadPdtDataTableHtml();
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
            url: "dcmSORemovePdtInDTTmpMulti_STD",
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
                        JSvSOLoadPdtDataTableHtml();
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

    $( document ).ready(function() {
        // JSxAddScollBarInTablePdt();
        JSxRendercalculate();
        JSxEditQtyAndPrice();    
        // if($('#ohdSOStaApv').val()==1){
        //     $('.xCNBTNPrimeryDisChgPlus').hide();
        //     $('.xCNIconTable').hide();
        //     $('.xCNPdtEditInLine').attr('readonly',true);
        //     $('#obtSOBrowseCustomer').attr('disabled',true);
        //     $('.ocbListItem').attr('disabled',true);
        // }

    });

    //คำนวณจำนวนเงินจากตางราง DT
    function JSxRendercalculate(){

        var nTotal                  = 0;
        var nTotal_alwDiscount      = 0;

        $(".xWFCXtdSetPrice").each(function(e) {
            var nSeq   = $(this).parent().parent().parent().attr('data-seq'); /*$(this).attr('data-seq');*/
            var nValue = $('#ospGrandTotal'+nSeq).text();
            var nValue = nValue.replace(/,/g, '');
            // console.log(nValue);

            nTotal = parseFloat(nTotal) + parseFloat(nValue);
        
            if($(this).attr('data-alwdis') == 1){
                nTotal_alwDiscount = parseFloat(nTotal_alwDiscount) + parseFloat(nValue);
            };
        });
        // console.log(nTotal);

        //จำนวนเงินรวม
        $('#olbSOSumFCXtdNet').text(numberWithCommas(parseFloat(nTotal).toFixed(2)));

        //จำนวนเงินรวม ที่อนุญาติลด
        $('#olbSOSumFCXtdNetAlwDis').val(nTotal_alwDiscount);

        //คิดส่วนลดใหม่
        var tChgHD          = $('#olbSODisChgHD').text();
        console.log(tChgHD);
        var nNewDiscount    = 0;
        if(tChgHD != '' && tChgHD != null){ //มีส่วนลดท้ายบิล
            var aChgHD      = tChgHD.split(",");
            var nNetAlwDis  = $('#olbSOSumFCXtdNetAlwDis').val();

            for(var i=0; i<aChgHD.length; i++){
                console.log('ยอดที่มันเอาไปคิดทำส่วนลด : ' + nNetAlwDis);
                if(aChgHD[i] != '' && aChgHD[i] != null){
                    if(aChgHD[i].search("%") == -1){ 
                    
                        //ไม่เจอ = ต้องคำนวณแบบบาท
                        var nVal        = aChgHD[i];
                        var nCal        = (parseFloat(nNetAlwDis) + parseFloat(nVal));
                        console.log('ลดเเล้วเหลือ : ' + nCal)
                        nNewDiscount    = parseFloat(nCal);
                        nNetAlwDis      = nNewDiscount;
                        nNewDiscount    = 0;
                    }else{ 
            
                        //เจอ = ต้องคำนวณแบบ %
                        var nPercent    = aChgHD[i];
                        var nPercent    = nPercent.replace("%", "");
                        var tCondition  = nPercent.substr(0, 1);
                        var nValPercent = Math.abs(nPercent);
                        if(tCondition == '-'){
                            var nCal        = parseFloat(nNetAlwDis) - ((parseFloat(nNetAlwDis) * nValPercent) / 100);
                            if(nCal == 0){
                                var nCal        = -nNetAlwDis;
                            }else{
                                var nCal        = nCal;
                            }
                        }else if(tCondition == '+'){
                            var nCal        = parseFloat(nNetAlwDis) + ((parseFloat(nNetAlwDis) * nValPercent) / 100);
                        }

                        console.log('ลดเเล้วเหลือ : ' + nCal);
                        nNewDiscount    = parseFloat(nCal);
                        nNetAlwDis      = nNewDiscount;
                        nNewDiscount    = 0;
                    }
                }
            }
            var nDiscount = (nNetAlwDis - parseFloat($('#olbSOSumFCXtdNetAlwDis').val()));
                            console.log(nDiscount,"nDiscount");
                        
            $('#olbSOSumFCXtdAmt').text(numberWithCommas(parseFloat(nDiscount).toFixed(2)));

            //Prorate
            JSxProrate();
        }

        //ยอดรวมหลังลด/ชาร์จ
        var nTotalFisrt = $('#olbSOSumFCXtdNet').text().replace(/,/g, '');
        var nDiscount   = $('#olbSOSumFCXtdAmt').text().replace(/,/g, '');
        var nResult     = parseFloat(Math.abs(nTotalFisrt))+parseFloat(nDiscount);
        $('#olbSOSumFCXtdNetAfHD').text(numberWithCommas(parseFloat(nResult).toFixed(2)));

        //คำนวณภาษี
        JSxCalculateVat();
    }

        
    //Prorate ส่วนลดเฉลี่ยท้ายบิล
    function JSxProrate(){
        //pnSumDiscount         : ส่วนลดท้ายบิลทั้งหมด
        //pnSum                 : ราคาทั้งหมดหลังหักส่วนลดต่อชิ้น
        var pnSumDiscount       = $('#olbSOSumFCXtdAmt').text().replace(/,/g, '');
        var pnSum               = $('#olbSOSumFCXtdNetAlwDis').val().replace(/,/g, '');
        var length              = $(".xWFCXtdSetPrice").length;
        var nSumProrate         = 0;
        var nDifferenceProrate  = 0;
        $(".xWFCXtdSetPrice").each(function(index,e) {
            var nSeq    = $(this).parent().parent().parent().attr('data-seq'); /*$(this).attr('data-seq');*/
            var alwdis  = $(this).attr('data-alwdis');

            var nValue  = $('#ospGrandTotal'+nSeq).text();
            var nValue  = parseFloat(nValue.replace(/,/g, ''));
           var nProrate = (pnSumDiscount * nValue) / pnSum;
           var netAfterHD = 0 ;
            // console.log(alwdis,'alwdis');
           if(alwdis==1){
            // console.log(pnSumDiscount,'pnSumDiscount');
            // console.log(nValue,'nProrate');
            // console.log(nProrate,'netAfterHD');
        //    console.log(nValue,'nValue');
           //ผลรวม prorate ที่เหลือต้องเอาไป + ตัวสุดท้าย
           nSumProrate     = parseFloat(nSumProrate) + parseFloat(nProrate);
           if(index === (length - 1)){
                nDifferenceProrate = pnSumDiscount - nSumProrate;
                nProrate = nProrate + nDifferenceProrate;
                netAfterHD =  nValue + nProrate;
            }else{
                nProrate = nProrate;
                netAfterHD =  nValue + nProrate;
            }
       
        //    $('#ospnetAfterHD'+nSeq).text(numberWithCommas(Math.abs(parseFloat(nProrate).toFixed(2))));
          
            // var nNetb4hd = parseFloat($('#ospnetAfterHD'+nSeq).text().replace(/,/g, ''));
            // console.log(nNetb4hd,'nNetb4hd');
            // console.log(nProrate,'nProrate');
           $('#ospnetAfterHD'+nSeq).text(numberWithCommas(parseFloat(nValue+nProrate).toFixed(2)));
        }
        });    
    }

    //เเก้ไขจำนวน และ ราคา
    function JSxEditQtyAndPrice(){

        $('.xCNPdtEditInLine').click(function(){
            $(this).focus().select();
        });

        // $('.xCNQty').change(function(e){
        $('.xCNPdtEditInLine').off().on('change keyup',function(e){
            if(e.type === 'change' || e.keyCode === 13){
                // console.log(e.type);
                
                // var nValue      = $(this).val();
                var nSeq    = $(this).parent().parent().parent().attr('data-seq');
                var nQty    = $('.xWPdtItemList'+nSeq).attr('data-qty');
                var cPrice  = $('.xWPdtItemList'+nSeq).attr('data-setprice');
                var tTagID  = $(this).attr('id');
                // var nNewValue   = parseInt(nValue) * parseFloat($('#ohdPrice'+nSeq).val());
                // $('#ospGrandTotal'+nSeq).text(numberWithCommas(nNewValue.toFixed(2)));
                // JSxRendercalculate();
                // console.log(nSeq);
                // console.log(nQty);
                // console.log(cPrice);

                // ตรวจสอบลดรายการ
                var tDisChgDTTmp = $('#olbSODisChgDT'+nSeq).text();
                if(tDisChgDTTmp == ''){
                    // var nIndex      = $(':input').index($(this));
                    // console.log(nIndex);
                    // $(':input').eq(nIndex + 1).focus().select();
                    $('#'+tTagID).val( parseFloat($(this).val()).toFixed(2) );
                    JSxGetDisChgList(nSeq,0);
                    // console.log( $(':input').index(this) );
                    $('input:eq(' + ($('input').index(this) + 1) +')').focus().select();
                    // $(':input:eq(2)').focus().select();
                }else{
                    // มีลด/ชาร์จ
                    $('#odvSOModalConfirmDeleteDTDis').modal({
                        backdrop: 'static',
                        show: true
                    });
                    
                    // $('#odvSOModalConfirmDeleteDTDis #obtSOConfirmDeleteDTDis').unbind();
                    $('#odvSOModalConfirmDeleteDTDis #obtSOConfirmDeleteDTDis').off('click');
                    $('#odvSOModalConfirmDeleteDTDis #obtSOConfirmDeleteDTDis').on('click',function(){
                        // $('#odvSOModalConfirmDeleteDTDis').modal('hide');
                        // $('.modal-backdrop').remove();
                        JSxGetDisChgList(nSeq,1);
                        $(':input:eq(' + ($(':input').index(this) + 1) +')').focus().select();
                    });

                    // $('#odvSOModalConfirmDeleteDTDis #obtSOCancelDeleteDTDis').unbind();
                    $('#odvSOModalConfirmDeleteDTDis #obtSOCancelDeleteDTDis').off('click');
                    $('#odvSOModalConfirmDeleteDTDis #obtSOCancelDeleteDTDis').on('click',function(){
                        // $('.modal-backdrop').remove();
                        e.preventDefault();
                        $('#ohdFCXtdQty'+nSeq).val(nQty);
                        $('#ohdFCXtdSetPrice'+nSeq).val(cPrice);
                    });

                    // $('#odvSOModalConfirmDeleteDTDis').modal('show');
                }
            }
        });

    }

    // ptStaDelDis = 1 ลบ DTDis
    // ptStaDelDis = 0 ไม่ลบ DTDis
    function JSxGetDisChgList(pnSeq,pnStaDelDis){
        var tChgDT      = $('#olbSODisChgDT'+pnSeq).text();
        var cPrice      = $('#ohdFCXtdSetPrice'+pnSeq).val();
        var nQty        = $('#ohdFCXtdQty'+pnSeq).val();
        var cResult     = parseFloat(cPrice * nQty);

        console.log(cPrice);

        // Fixed ราคาต่อหน่วย 2 ตำแหน่ง
        $('#ohdFCXtdSetPrice'+pnSeq).val(parseFloat(cPrice).toFixed(2));

        // Update Value
        $('#ospGrandTotal'+pnSeq).text(numberWithCommas(parseFloat(cResult).toFixed(2)));
        $('.xWPdtItemList'+pnSeq).attr('data-qty',nQty);
        $('.xWPdtItemList'+pnSeq).attr('data-setprice',parseFloat(cPrice).toFixed(2));
        $('.xWPdtItemList'+pnSeq).attr('data-net',parseFloat(cResult).toFixed(2));
        if(pnStaDelDis == 1){
            $('#olbSODisChgDT'+pnSeq).text('');
        }

        // ถ้าไม่มีลดท้ายบิล ให้ปรับ NetAfHD
        if($('#olbDisChgHD').text() == ''){
            $('#ospnetAfterHD'+pnSeq).text(parseFloat(cResult).toFixed(2));
            $('.xWPdtItemList'+pnSeq).attr('data-netafhd',parseFloat(cResult).toFixed(2));
        }

        JSxRendercalculate();

        var tSODocNo        = $("#oetSODocNo").val();
        var tSOBchCode      = $("#oetSOFrmBchCode").val();
        $.ajax({
            type: "POST",
            url: "dcmSOEditPdtIntoDTDocTemp_STD",
            data: {
                'tSOBchCode'    : tSOBchCode,
                'tSODocNo'      : tSODocNo,
                'nSOSeqNo'      : pnSeq,
                'nQty'          : nQty,
                'cPrice'        : cPrice,
                'cNet'          : cResult,
                'nStaDelDis'    : pnStaDelDis,
                'ohdSesSessionID'   : $('#ohdSesSessionID').val(),
                'ohdSOUsrCode'        : $('#ohdSOUsrCode').val(),
                'ohdSOLangEdit'       : $('#ohdSOLangEdit').val(),
                'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
                'ohdSOSesUsrBchCode'  : $('#ohdSOSesUsrBchCode').val(),
            },
            cache: false,
            timeout: 0,
            success: function (oResult){
                // if(oResult == 'expire'){
                //     JCNxShowMsgSessionExpired();
                // }else{
                //     JSvSOLoadPdtDataTableHtml();
                // }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                // JSxGetDisChgList(pnSeq,pnStaDelDis);
            }
        });
    }

    //คำนวณภาษี
    $('#ocmVatInOrEx').change(function (){ JSxCalculateVat(); });  
    function JSxCalculateVat(){
        var tVatList  = '';
        var aVat      = [];
        $('#otbSODocPdtAdvTableList tbody tr').each(function(){
            var nAlwVat  = $(this).attr('data-alwvat');
            var nVat     = parseFloat($(this).attr('data-vat'));
            var nKey     = $(this).attr('data-key');
            var tTypeVat = $('#ohdSOCmpRetInOrEx').val();;

            console.log(nVat);    
            if(nAlwVat == 1){ 
                //อนุญาติคิด VAT
                if(tTypeVat == 1){ 
                    // ภาษีรวมใน tSoot = net - ((net * 100) / (100 + rate));
                    var net       = parseFloat($('#ospnetAfterHD'+nKey).text().replace(/,/g, ''));
                    var nTotalVat = net - (net * 100 / (100 + nVat));
                    var nResult   = parseFloat(nTotalVat).toFixed(2);
                }else if(tTypeVat == 2){
                    // ภาษีแยกนอก tSoot = net - (net * (100 + 7) / 100) - net;
                    var net       = parseFloat($('#ospnetAfterHD'+nKey).text().replace(/,/g, ''));
                    var nTotalVat = (net * (100 + nVat) / 100) - net;
                    var nResult   = parseFloat(nTotalVat).toFixed(2);
                }

                var oVat = { VAT: nVat , VALUE: nResult };
                aVat.push(oVat);
            }
        });


        //เรียงลำดับ array ใหม่
        aVat.sort(function (a, b) {
            return a.VAT - b.VAT;
        });

        //รวมค่าใน array กรณี vat ซ้ำ
        var nVATStart       = 0;
        var nSumValueVat    = 0;
        var aSumVat         = [];
        for(var i=0; i<aVat.length; i++){
            if(nVATStart == aVat[i].VAT){
                nSumValueVat = nSumValueVat + parseFloat(aVat[i].VALUE);
                aSumVat.pop();
            }else{
                nSumValueVat = 0;
                nSumValueVat = nSumValueVat + parseFloat(aVat[i].VALUE);
                nVATStart    = aVat[i].VAT;
            }

            var oSum = { VAT: nVATStart , VALUE: nSumValueVat };
            aSumVat.push(oSum);
        }

        //  console.log(aVat);


        var SOVatRate =  parseFloat($('#ohdSOVatRate').val());
        var SOCmpRetInOrEx = $('#ohdSOCmpRetInOrEx').val();
        // ภาษีรวมใน tSoot = net - ((net * 100) / (100 + rate));
        var cSumFCXtdNetAfHD  = parseFloat($('#olbSOSumFCXtdNetAfHD').text().replace(/,/g, ''));
        var nSumVatHD = cSumFCXtdNetAfHD - ((cSumFCXtdNetAfHD * 100)/(100 + SOVatRate));
        
        //ยอดรวมภาษีมูลค่าเพิ่ม
        $('#olbVatSum').text(numberWithCommas(parseFloat(nSumVatHD).toFixed(2)));

                //เอา VAT ไปทำในตาราง
        var nSumVat = 0;
        var nCount = 1;
        for(var j=0; j<aSumVat.length; j++){
            var tVatRate    = aSumVat[j].VAT;
                  if(nCount!=aSumVat.length){
                    var tSumVat     = parseFloat(aSumVat[j].VALUE).toFixed(2) == 0 ? '0.00' : parseFloat(aSumVat[j].VALUE).toFixed(2);
                    }else{
                    var tSumVat     = (nSumVatHD - nSumVat).toFixed(2);
                    }
            tVatList    += '<li class="list-group-item"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' + tSumVat + '</label><div class="clearfix"></div></li>';
            nSumVat += parseFloat(aSumVat[j].VALUE);
            nCount++;
        }
        
        $('#oulDataListVat').html(tVatList);

        //ยอดรวมภาษีมูลค่าเพิ่ม
        $('#olbSumFCXtdVat').text(numberWithCommas(parseFloat(nSumVatHD).toFixed(2)));
        $('#ohdSumFCXtdVat').val(nSumVatHD.toFixed(2));
        //สรุปราคารวม
        var tTypeVat = $('#ohdSOCmpRetInOrEx').val();;
        if(tTypeVat == 1){ //คิดแบบรวมใน
            var nTotal          = parseFloat($('#olbSOSumFCXtdNetAfHD').text().replace(/,/g, ''));
            var nResultTotal    = nTotal;
        }else if(tTypeVat == 2){ //คิดแบบแยกนอก
            var nTotal          = parseFloat($('#olbSOSumFCXtdNetAfHD').text().replace(/,/g, ''));
            var nVat            = parseFloat($('#olbSumFCXtdVat').text().replace(/,/g, ''));
            var nResultTotal    = parseFloat(nTotal) + parseFloat(nVat);
        }

        //จำนวนเงินรวมทั้งสิ้น
        $('#olbCalFCXphGrand').text(numberWithCommas(parseFloat(nResultTotal).toFixed(2)));

        //ราคารวมทั้งหมด ตัวเลขบาท
        var tTextTotal  = $('#olbCalFCXphGrand').text().replace(/,/g, '');
        var tThaibath 	= ArabicNumberToText(tTextTotal);
        $('#odvDataTextBath').text(tThaibath);
    }


    //พวกตัวเลขใส่ comma ให้มัน
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }


</script>