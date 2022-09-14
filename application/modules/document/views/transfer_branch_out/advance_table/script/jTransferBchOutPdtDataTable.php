<script>

    $(document).ready(function(){

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        //================================== in call function
        var oParameterSend = {
            "DocModules" : "",
            "FunctionName" : "JSxTransferBchOutPdtDataTableEditInline",
            "DataAttribute" : ['data-field', 'data-seq', 'data-qtyord', 'data-qtypick', 'data-ispack'],
            "TableID" : "otbTransferBchOutPdtTable",
            "NotFoundDataRowClass" : "xWTransferBchOutTextNotfoundDataPdtTable",
            "EditInLineButtonDeleteClass" : "xWTransferBchOutDeleteBtnEditButtonPdt",
            "LabelShowDataClass" : "xWShowInLine",
            "DivHiddenDataEditClass" : "xWEditInLine"
        };
        JCNxSetNewEditInline(oParameterSend);
        $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
        $(".xWEditInlineElement").eq(nIndexInputEditInline).select();

        $(".xWEditInlineElement").removeAttr("disabled");


        let oElement = $(".xWEditInlineElement");
        for(let nI=0;nI<oElement.length;nI++){
            $(oElement.eq(nI)).val($(oElement.eq(nI)).val().trim());
        }
        //================================== end in call function

        if(bIsApvOrCancel){
            $('#otbTransferBchOutPdtTable .xCNApvOrCanCelDisabledPdt').attr('disabled', true);
            $('#otbTransferBchOutPdtTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbTransferBchOutPdtTable .xCNIconDel').removeAttr('onclick', true);
        }else{
            $('#otbTransferBchOutPdtTable .xCNApvOrCanCelDisabledPdt').attr('disabled', false);
            $('#otbTransferBchOutPdtTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbTransferBchOutPdtTable .xCNIconDel').attr('onclick', 'JSxTransferBchOutPdtDataTableDeleteBySeq(this)');
        }

        /*===== Begin Checked Pdt Item Control =========================================*/
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalTransferBchOutPdtItemData"))];

        var oPdtItem = $('.xCNTransferBchOutTBodyPdtItem').children('tr');
        $.each(oPdtItem, function(nIndex, oElm){
            var tDataCode = $(this).data('seqno');
            if(aArrayConvert == null || aArrayConvert == ''){
            }else{
                var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeq',tDataCode);
                if(aReturnRepeat == 'Dupilcate'){
                    $(this).find('.ocbTransferBchOutPdtListItem').prop('checked', true);
                }else{}
            }
        });

        $('.ocbTransferBchOutPdtListItem').click(function(){

            var tSeq = $(this).parent().parent().parent().data('seqno'); // Seq
            var tPdt = $(this).parent().parent().parent().data('pdtcode'); // Pdt
            var tDoc = $(this).parent().parent().parent().data('docno'); // Doc
            var tPun = $(this).parent().parent().parent().data('puncode'); // Pun

            $(this).prop('checked', true);
            var LocalTransferBchOutPdtItemData = localStorage.getItem("LocalTransferBchOutPdtItemData");
            var obj = [];
            if(LocalTransferBchOutPdtItemData){
                obj = JSON.parse(LocalTransferBchOutPdtItemData);
            }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalTransferBchOutPdtItemData"))];
            if(aArrayConvert == '' || aArrayConvert == null){
                obj.push({"tSeq": tSeq, 
                            "tPdt": tPdt, 
                            "tDoc": tDoc, 
                            "tPun": tPun 
                        });
                localStorage.setItem("LocalTransferBchOutPdtItemData",JSON.stringify(obj));
            }else{
                var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeq',tSeq);
                if(aReturnRepeat == 'None' ){ // ยังไม่ถูกเลือก
                    obj.push({"tSeq": tSeq, 
                                "tPdt": tPdt, 
                                "tDoc": tDoc, 
                                "tPun": tPun 
                            });
                    localStorage.setItem("LocalTransferBchOutPdtItemData",JSON.stringify(obj));
                }else if(aReturnRepeat == 'Dupilcate'){ // เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalTransferBchOutPdtItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i].tSeq == tSeq){
                            delete aArrayConvert[0][$i];
                        }
                    }
                    var aNewarraydata = [];
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i] != undefined){
                            aNewarraydata.push(aArrayConvert[0][$i]);
                        }
                    }
                    localStorage.setItem("LocalTransferBchOutPdtItemData",JSON.stringify(aNewarraydata));
                }
            }
            JSxShowButtonChoose();
        });

        JSvTransferBchOutPdtDeleteMoreControl();

        $('.ocbTransferBchOutPdtListItem').on('change', function(){
            JSvTransferBchOutPdtDeleteMoreControl();   
        });
        /*===== End Checked Pdt Item Control =========================================*/
    });

    /**
     * Functionality : เรียกหน้าของรายการ Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvTransferBchOutPdtDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxTransferBchOutGetPdtInTmp(nPageCurrent, true);
    }

    /**
     * Functionality : Edit Inline Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutPdtDataTableEditInline(poElm) {
        var nSeqNo      = poElm.DataAttribute[1]['data-seq'];
        var tFieldName  = poElm.DataAttribute[0]['data-field'];
        var tValue      = accounting.unformat(poElm.VeluesInline);
        var nQtyOrd     = accounting.unformat(poElm.DataAttribute[2]['data-qtyord']);
        var nQtyPick    = accounting.unformat(poElm.DataAttribute[3]['data-qtypick']);
        var tStaIsPack  = poElm.DataAttribute[4]['data-ispack'];

        // console.log('tValue: '+tValue);
        // console.log('nQtyOrd: '+nQtyOrd);
        // console.log('nQtyPick: '+nQtyPick);
        // console.log('tStaIsPack: '+tStaIsPack)

        // ถ้าเอกสารนี้ต้องสร้างใบจัดสินค้า ต้อง validate จำนวน <> จำนวนจัด
        if( tStaIsPack == 'true' ){
            if( tValue != nQtyPick ){
                FSvCMNSetMsgWarningDialog('จำนวนจัดสินค้าไม่เท่ากับจำนวน กรุณาตรวจสอบอีกครั้ง');
                $nCurrentPage = $('#odvTransferBchOutCashDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                JSxTransferBchOutGetPdtInTmp($nCurrentPage, false);
                return;
            }
        }
        
        JSxTransferBchOutPdtDataTableUpdateBySeq(nSeqNo, tFieldName, tValue);
    }

    /**
     * Functionality : Edit Cash in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutPdtDataTableUpdateBySeq(pnSeqNo, ptFieldName, ptValue) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTransferBchOutBchCode').val();

            $.ajax({
                type: "POST",
                url: "docTransferBchOutUpdatePdtInTmp",
                data: {
                    tFieldName  : ptFieldName, // ชื่อ Field
                    tValue      : ptValue, // ค่าข้อมูล
                    nSeqNo      : pnSeqNo,
                    tBchCode    : tBchCode, // สาขา
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var nCurrentPage = $('#ohdTBOPageCurrent').val();
                    JSxTransferBchOutGetPdtInTmp(nCurrentPage, false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Delete Pdt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutPdtDataTableDeleteBySeq(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var nSeqNo = $(poElm).parents('.xWTransferBchOutPdtItem').data('seqno');

            $.ajax({
                type: "POST",
                url: "docTransferBchOutDeletePdtInTmp",
                data: {
                    nSeqNo: nSeqNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvTransferBchOutPdtDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxTransferBchOutGetPdtInTmp($nCurrentPage, true);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Call Delete More Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutCallPdtDataTableDeleteMore() {
        var tWarningMessage = 'ต้องการลบรายการทั้งหมดหรือไม่';
        FSvCMNSetMsgWarningDialog(tWarningMessage, 'JSxTransferBchOutPdtDataTableDeleteMoreBySeq', '', true);
    }
    
    /**
     * Functionality : Delete More Pdt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutPdtDataTableDeleteMoreBySeq() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var aSeqNo = [];
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalTransferBchOutPdtItemData"))];
            
            console.log(aArrayConvert[0]);

            $.each(aArrayConvert[0], function(nIndex, oElm){
                aSeqNo.push(oElm.tSeq);
            });

            console.log(aSeqNo);

            $.ajax({
                type: "POST",
                url: "docTransferBchOutDeleteMorePdtInTmp",
                data: {
                    paSeqNo: aSeqNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    localStorage.removeItem("LocalTransferBchOutPdtItemData");
                    $nCurrentPage = $('#odvTransferBchOutPdtDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxTransferBchOutGetPdtInTmp($nCurrentPage, true);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : ควบคุมการเปิดปิดการลบหลายรายการ(Pdt Temp)
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvTransferBchOutPdtDeleteMoreControl() {
        var nPdtListItemLength = $('.ocbTransferBchOutPdtListItem:checked').length; 
            
        if(nPdtListItemLength > 1){
            $('#oliTransferBchOutPdtBtnDeleteMulti').removeClass('disabled');
        }else{
            $('#oliTransferBchOutPdtBtnDeleteMulti').addClass('disabled');
        }
    }
</script>