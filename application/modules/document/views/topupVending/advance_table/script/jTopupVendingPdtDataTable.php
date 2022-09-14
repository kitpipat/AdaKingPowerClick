<script>

    $(document).ready(function(){
        if(!bIsApvOrCancel){
            $('.xCNTopUpVendingQty').on('change keypress', function(event){
                var tValue = $(this).val();
                // console.log(event.type,event.keyCode);
                if( tValue == '' ){
                    $(this).val(0);
                    return;
                }
                if(event.type == "change"){
                    JSxTopUpVendingPdtDataTableEditInline(this);
                    return;
                }
                if(event.keyCode == 13) {
                    JSxTopUpVendingPdtDataTableEditInline(this);
                    return;
                } 
            });
        }

        if(bIsApvOrCancel){
            $('form .xCNApvOrCanCelDisabledQty').attr('disabled', true);
            $('#otbDOCPdtTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbDOCPdtTable .xCNIconDel').removeAttr('onclick', true);
           
            $('.othShowChkbox').css('display','none');
            $('.otdShowChkbox').css('display','none');
        }else{
            $('form .xCNApvOrCanCelDisabledQty').attr('disabled', false);
            $('#otbDOCPdtTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbDOCPdtTable .xCNIconDel').attr('onclick', 'JSxTopUpVendingPdtDataTableDeleteBySeq(this)');
           
            $('.othShowChkbox').css('display','table-cell');
            $('.otdShowChkbox').css('display','table-cell');
        }

        localStorage.removeItem("TUV_LocalItemDataDelDtTemp");
        $("#oetAllCheck").click(function(){ // เมื่อคลิกที่ checkbox ตัวควบคุม
            if($(this).prop("checked")){
                $(".ocbListItem").prop("checked",true);
                JSxAddlocalStorage();
            }else{
                $(".ocbListItem").prop("checked",false); 
                localStorage.removeItem("TUV_LocalItemDataDelDtTemp");
            }
        });

    });

    /**
     * Functionality : เรียกหน้าของรายการ PDT Layout
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvTopUpVendignPdtDataTableClickPage(ptPage) {
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
        JSxTopUpVendingGetPdtLayoutDataTableInTmp(nPageCurrent);
    }

    /**
     * Functionality : Edit Inline PDT Layout in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingPdtDataTableEditInline(poElm) {
        JCNxOpenLoading();

        var nQty        = $(poElm).val();
        var nStkQty     = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').find('.xCNTopUpVendingPdtLayoutStkQty').text();
        var nMaxQty     = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').find('.xCNTopUpVendingPdtLayoutMaxQty').text();
        var tPdtCode    = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').find('.xCNTopUpVendingPdtLayoutPdtCode').text();
        var nSeqNo      = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').data('seq-no');
        var nCheckSTK   = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').data('checkstk');
        var nStkShop    = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').data('stkshop');
        var nMaxRefill  = nMaxQty - nStkQty;

        // console.log('nQty: '+nQty);
        // console.log('nMaxQty: '+nMaxQty);
        // console.log('nMaxRefill: '+nMaxRefill);
        // console.log('nStkQty: '+nStkQty);
        

        if (nQty <= nMaxRefill) {
            // ตรวจสอบสินค้าในคลังร้านค้า
            if( nQty > nStkShop ){
                nQty = nStkShop;
            }
            JSxTopUpVendingPdtDataTableUpdateBySeq(nQty, nSeqNo, tPdtCode , nCheckSTK);
        } else {
            //ถ้าเช็คว่าไม่ตัดสต๊อก สามารถคีย์เท่่าไหร่ก็ได้
            if(nCheckSTK == 1){
                if(nQty <= nMaxRefill){
                    nMaxRefill = nQty;
                }else{
                    nMaxRefill = nMaxRefill;
                }
            }else{
                nMaxRefill = nMaxRefill;
            }

            // console.log('nMaxRefill: '+nMaxRefill);
            // console.log('nStkShop: '+nStkShop);

            // ตรวจสอบสินค้าในคลังร้านค้า
            if( nMaxRefill > nStkShop ){
                nMaxRefill = nStkShop;
            }

            JSxTopUpVendingPdtDataTableUpdateBySeq(nMaxRefill, nSeqNo, tPdtCode , nCheckSTK);
        }
    }

    /**
     * Functionality : Edit PDT Layout in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingPdtDataTableUpdateBySeq(pnQty, pnSeqNo, ptPdtCode , pnCheckSTK) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTopUpVendingBCHCode').val();
            var tPosCode = $('#oetTopUpVendingPosCode').val();
            var tWahCode = $('#oetTopUpVendingWahCode').val();

            $.ajax({
                type: "POST",
                url: "TopupVendingUpdatePdtLayoutInTmp",
                data: {
                    nQty        : pnQty, // จำนวนที่เติม
                    nSeqNo      : pnSeqNo,
                    tPdtCode    : ptPdtCode, // สินค้าที่จะเติม
                    tBchCode    : tBchCode, // สาขาที่จะเติม
                    tPosCode    : tPosCode, // ตู้ขายสินค้าที่จะเติม
                    tWahCode    : tWahCode, // คลังสินค้าต้นทาง เพื่อใช้ในการเติมให้กับ คลังตู้สินค้า
                    nCheckSTK   : pnCheckSTK //สถานะเช็คสต๊อกว่าตัดหรือไม่ตัด
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    // console.log(tResult);
                    $nCurrentPage = $('#odvTopupVendingPdtDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxTopUpVendingGetPdtLayoutDataTableInTmp($nCurrentPage);
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
     * Functionality : Delete PDT Layout in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingPdtDataTableDeleteBySeq(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var nSeqNo = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').data('seq-no');

            $.ajax({
                type: "POST",
                url: "TopupVendingDeletePdtLayoutInTmp",
                data: {
                    nSeqNo: nSeqNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvTopupVendingPdtDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxTopUpVendingGetPdtLayoutDataTableInTmp($nCurrentPage);
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
     * Functionality : Delete MUlti
     * Parameters : -
     * Creator : 03/09/2020 Witsarut
     * Return : -
     * Return Type : -
     */
    $('#otbDOCPdtTable #odvTBodyTUVPdtAdvTableList .ocbListItem').unbind().click(function(){

        var tXthDocNo = $('#oetTopUpVendingDocNo').val();
        var tSeqNo    = $(this).parents('.xCNTextDetail2').data('seq-no');
        var tPdtCode  = $(this).parents('.xCNTextDetail2').find('.xCNTopUpVendingPdtLayoutPdtCode').text();

        $(this).prop('checked', true);

        let oLocalItemDTTemp    = localStorage.getItem("TUV_LocalItemDataDelDtTemp");
        let oDataObj            = [];

        if(oLocalItemDTTemp){
            oDataObj    = JSON.parse(oLocalItemDTTemp);
        }

        let aArrayConvert   = [JSON.parse(localStorage.getItem("TUV_LocalItemDataDelDtTemp"))];

        if(aArrayConvert == '' || aArrayConvert == null){
            oDataObj.push({
                'tDocNo'    : tXthDocNo,
                'tSeqNo'    : tSeqNo,
                'tPdtCode'  : tPdtCode,
            });
            localStorage.setItem("TUV_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
            JSxTUVTextInModalDelPdtDtTemp();
        }else{
            var aReturnRepeat   = JStTUVFindObjectByKey(aArrayConvert[0],'tSeqNo',tSeqNo);
            if(aReturnRepeat == 'None'){
                oDataObj.push({
                    'tDocNo'    : tXthDocNo,
                    'tSeqNo'    : tSeqNo,
                    'tPdtCode'  : tPdtCode,
                });
                localStorage.setItem("TUV_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                JSxTUVTextInModalDelPdtDtTemp();
            }else if(aReturnRepeat == 'Dupilcate'){
                localStorage.removeItem("TUV_LocalItemDataDelDtTemp");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].tSeqNo == tSeqNo){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata   = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("TUV_LocalItemDataDelDtTemp",JSON.stringify(aNewarraydata));
                JSxTUVTextInModalDelPdtDtTemp();
            }
        }
        JSxTUVShowButtonDelMutiDtTemp();
    });

    //function Checkbox All Header
    // Create By Witsarut 16-09-2020
    function JSxAddlocalStorage(){
        $('.ocbListItem').each(function(){

            var tXthDocNo = $('#oetTopUpVendingDocNo').val();
            var tSeqNo    = $(this).parents('.xCNTextDetail2').data('seq-no');
            var tPdtCode  = $(this).parents('.xCNTextDetail2').find('.xCNTopUpVendingPdtLayoutPdtCode').text();

            $(this).prop('checked', true);

            let oLocalItemDTTemp    = localStorage.getItem("TUV_LocalItemDataDelDtTemp");
            let oDataObj            = [];

            if(oLocalItemDTTemp){
                oDataObj    = JSON.parse(oLocalItemDTTemp);
            }

            let aArrayConvert   = [JSON.parse(localStorage.getItem("TUV_LocalItemDataDelDtTemp"))];

            if(aArrayConvert == '' || aArrayConvert == null){
                oDataObj.push({
                    'tDocNo'    : tXthDocNo,
                    'tSeqNo'    : tSeqNo,
                    'tPdtCode'  : tPdtCode,
                });
                localStorage.setItem("TUV_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                JSxTUVTextInModalDelPdtDtTemp();
            }else{
                var aReturnRepeat   = JStTUVFindObjectByKey(aArrayConvert[0],'tSeqNo',tSeqNo);
                if(aReturnRepeat == 'None'){
                    oDataObj.push({
                        'tDocNo'    : tXthDocNo,
                        'tSeqNo'    : tSeqNo,
                        'tPdtCode'  : tPdtCode,
                    });
                    localStorage.setItem("TUV_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                    JSxTUVTextInModalDelPdtDtTemp();
                }else if(aReturnRepeat == 'Dupilcate'){
                    localStorage.removeItem("TUV_LocalItemDataDelDtTemp");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i].tSeqNo == tSeqNo){
                            delete aArrayConvert[0][$i];
                        }
                    }
                    var aNewarraydata   = [];
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i] != undefined){
                            aNewarraydata.push(aArrayConvert[0][$i]);
                        }
                    }
                    localStorage.setItem("TUV_LocalItemDataDelDtTemp",JSON.stringify(aNewarraydata));
                    JSxTUVTextInModalDelPdtDtTemp();
                }
            }
            JSxTUVShowButtonDelMutiDtTemp();
        });
    }

    //แสดงให้ปุ่ม Delete กดได้
    // Create By WItsarut 03/09/2020
    function JSxTUVShowButtonDelMutiDtTemp(){
        var aArrayConvert = [JSON.parse(localStorage.getItem("TUV_LocalItemDataDelDtTemp"))];
        if(aArrayConvert[0] == null || aArrayConvert[0] == ""){
            $("#odvTUVMngDelPdtInTableDT #oliTUVBtnDeleteMulti").addClass("disabled");
        }else{
            var nNumOfArr   = aArrayConvert[0].length;
            if(nNumOfArr > 1) {
                 $("#odvTUVMngDelPdtInTableDT #oliTUVBtnDeleteMulti").removeClass("disabled");
            }else{
                $("#odvTUVMngDelPdtInTableDT #oliTUVBtnDeleteMulti").addClass("disabled");
            }
        }
    }


    //เซตข้อความลบในสินค้าif
    // Create By WItsarut 03/09/2020
    function JSxTUVTextInModalDelPdtDtTemp(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("TUV_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
        }else{
            var tTUVSeqNo       = "";
            var tTUVPdtCode     = "";
            $.each(aArrayConvert[0],function(nKey, aValue){
                
                tTUVSeqNo   += aValue.tSeqNo;
                tTUVSeqNo   += " , ";

                tTUVPdtCode += aValue.tPdtCode;
                tTUVPdtCode += " , ";
            });

            $('#odvTUVModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvTUVModalDelPdtInDTTempMultiple #ohdConfirmTUVSeqNoDelete').val(tTUVSeqNo);
            $('#odvTUVModalDelPdtInDTTempMultiple #ohdConfirmTUVPdtCodeDelete').val(tTUVPdtCode);
        }
    }


    //ค้นหา KEY
    //Create BY WItsarut 3/09/2020
    function JStTUVFindObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }


    // Confirm Delete Modal Multiple
    //Create By Witsarut 03/09/2020
    $('#odvTUVModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== 'undefined' && nStaSession == 1){
            JSxTUVDelDocMultiple();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //ลบ comma
    // create By Witsarut 03/09/2020
    function JSoTUVRemoveCommaData(paData){
        var aTexts              = paData.substring(0, paData.length - 2);
        var aDataSplit          = aTexts.split(" , ");
        var aDataSplitlength    = aDataSplit.length;
        var aNewDataDeleteComma = [];

        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewDataDeleteComma.push(aDataSplit[$i]);
        }
        return aNewDataDeleteComma;
    }


    //ลบสินค้าใน Tmp - หลายตัว
    // create By Witsarut 03/09/2020
    function JSxTUVDelDocMultiple(){
        var tXthDocNo       = $('#oetTopUpVendingDocNo').val();
        var aDataSeqNo      = JSoTUVRemoveCommaData($('#odvTUVModalDelPdtInDTTempMultiple #ohdConfirmTUVSeqNoDelete').val());
        var aDataPdtCode    = JSoTUVRemoveCommaData($('#odvTUVModalDelPdtInDTTempMultiple #ohdConfirmTUVPdtCodeDelete').val());

        JCNxOpenLoading();

        $.ajax({
            type    : "POST",
            url     : "TopupVendingDeleteMultiPdtLayoutInTmp",
            data    : {
               'tDocNo'     : tXthDocNo,
               'tSeqNo'     : aDataSeqNo,
               'tPdtCode'   : aDataPdtCode,
            },
            catch : false,
            timeout: 0,
            success: function (tResult){
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == 1){
                    $('#odvTUVModalDelPdtInDTTempMultiple').modal('hide');
                    $('#odvTUVModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
                    localStorage.removeItem('TUV_LocalItemDataDelDtTemp');
                    $('#odvTUVModalDelPdtInDTTempMultiple #ohdConfirmTUVSeqNoDelete').val('');
                    $('#odvTUVModalDelPdtInDTTempMultiple #ohdConfirmTUVPdtCodeDelete').val('');
                    setTimeout(function(){
                        $('.modal-backdrop').remove();
                        $nCurrentPage = $('#odvTopupVendingPdtDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                        JSxTopUpVendingGetPdtLayoutDataTableInTmp($nCurrentPage);
                        $("#odvTUVMngDelPdtInTableDT #oliTUVBtnDeleteMulti").addClass("disabled");
                    }, 500);
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading()
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


       /**
     * Functionality : Insert Text In Modal Delete
     * Parameters : LocalStorage Data
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTextinModal1() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {} else {
            var tTextCode = "";
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].nCode;
                tTextCode += " , ";
            }
            //Disabled ปุ่ม Delete
            if (aArrayConvert[0].length > 1) {
                $(".xCNIconDel").addClass("xCNDisabled");
            } else {
                $(".xCNIconDel").removeClass("xCNDisabled");
            }

            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
            $("#ohdConfirmIDDelete").val(tTextCode);
        }
    }


     /**
     * Functionality : Function Chack And Show Button Delete All
     * Parameters : LocalStorage Data
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxShowButtonChoose1() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#oliBtnDeleteAll").addClass("disabled");
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#oliBtnDeleteAll").removeClass("disabled");
            } else {
                $("#oliBtnDeleteAll").addClass("disabled");
            }
        }
    }


    /**
     * Functionality : Function Chack Value LocalStorage
     * Parameters : array, key, value
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function findObjectByKey1(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }


</script>