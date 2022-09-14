<script>

    //ลบข้อมูลทั้งหมดออกก่อน
    localStorage.removeItem("LocalItemData");


    //เข้ามาแบบเเก้ไข แต่เอกสารถูกยกเลิก
    if($('#ohdXthStaDoc').val() == 3 || $('#ohdXthStaApv').val() == 1){
        $('.xCNApvOrCanCelDisabledQty').attr('readonly',true);

        $('.xCNApvOrCanCelDisabledDelete').addClass('xCNClassBlockEventClick');
		$('.xCNApvOrCanCelDisabledDelete').addClass('disabled');
        $('.xCNApvOrCanCelDisabledDelete').attr('disabled',true);
        $('#odvADJVDMngDelPdtInTableDT').hide();

        $('.othShowBalance').css('display','table-cell');
        $('.otdShowBalance').css('display','table-cell');

        $('.othShowChkbox').css('display','none');
        $('.otdShowChkbox').css('display','none');
    }else{
        $('.othShowBalance').css('display','none');
        $('.otdShowBalance').css('display','none'); 
        $('.othShowChkbox').css('display','table-cell');
        $('.otdShowChkbox').css('display','table-cell');
        $('#odvADJVDMngDelPdtInTableDT').show();
    }

    //กดคลิก checkbox ทั้งหมด
    $("#oetAllCheck").click(function(){ // เมื่อคลิกที่ checkbox ตัวควบคุม
        if($(this).prop("checked")){
            $(".ocbListItem").prop("checked",true);
            JSxAddlocalStorage();
        }else{
            $(".ocbListItem").prop("checked",false); 
            localStorage.removeItem("LocalItemData");
        }
    });
        
    $('.xCNADJVDKeyQty').on('change keyup', function(event){
        if(event.type == "change"){
            JSxADJVendingPdtDataTableEditInline(this);
        }
        if(event.keyCode == 13) {
            JSxADJVendingPdtDataTableEditInline(this);
        } 
    });

    //เปลี่ยนจำนวน
    function JSxADJVendingPdtDataTableEditInline(poElm) {
        // JCNxOpenLoading();
        var nQty        = $(poElm).val();
        var nSeq        = $(poElm).parents('.xCNADJVendingPdtLayoutRow').data('seq-no');
        var nPdtCode    = $(poElm).parents('.xCNADJVendingPdtLayoutRow').find('.xCNADJVendingPdtLayoutPdtCode').text();
        var nCabinet    = $(poElm).parents('.xCNADJVendingPdtLayoutRow').data('seq-cabinet');
        var nMax        = $(poElm).parents('.xCNADJVendingPdtLayoutRow').find('.xCNADJVendingPdtLayoutMax').text();

        //ห้ามตรวจนับเกินจำนวนของในเกลียว
        if(parseInt(nQty) > parseInt(nMax)){
            $(poElm).val(nMax);
            nQty = nMax;
        }else{
            nQty = nQty;
        }

        JSxADJVendingPdtDataTableUpdateBySeq(nQty,nSeq,nPdtCode,nCabinet);
    }

    //อัพเดทจำนวน
    function JSxADJVendingPdtDataTableUpdateBySeq(pnQty, pnSeqNo, ptPdtCode , pnCabSeq) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tBchCode        = $('#oetBchCode').val();
            var tShpCode        = $('#oetShpCodeStart').val();
            var tPosCode        = $('#oetPosCodeStart').val();
            var tWahCode        = $('#ohdWahCodeStart').val();
            var tDocumentNumber = $('#oetXthDocNo').val();
            var tRoute          = $('#ohdADJVDRoute').val();

            $.ajax({
                type    : "POST",
                url     : "ADJSTKVDEditPdtIntoTableDT",
                data    : {
                    tDocumentNumber : tDocumentNumber,
                    nQty            : pnQty,
                    nSeqNo          : pnSeqNo,
                    tPdtCode        : ptPdtCode, 
                    tBchCode        : tBchCode,
                    tShpCode        : tShpCode,
                    tPosCode        : tPosCode, 
                    tWahCode        : tWahCode,
                    nCabSeq         : pnCabSeq,
                    tRoute          : tRoute
                },
                cache   : false,
                timeout : 0,
                success: function(tResult) {
                    // console.log(tResult);
                    //เดียวต้องมาหา page
                    //$nCurrentPage = $('#odvTopupVendingPdtDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    // JSxLoadPdtDtFromTem(1);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //เปลี่ยนหน้า
    function JSvADJVDClickPageInTemp(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (nStaSession !== undefined && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWPageInTemp").addClass("disabled");
                nPageOld        = $(".xWPageInTemp .active").text(); // Get เลขก่อนหน้า
                nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent    = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld        = $(".xWPageInTemp .active").text(); // Get เลขก่อนหน้า
                nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent    = nPageNew;
                break;
            default:
                nPageCurrent    = ptPage;
            }
            JSxLoadPdtDtFromTem(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ลบสินค้า
    function JSxDeletePDTInTmp(poElm){
        var nSeq        = $(poElm).parents('.xCNADJVendingPdtLayoutRow').data('seq-no');
        var nPdtCode    = $(poElm).parents('.xCNADJVendingPdtLayoutRow').find('.xCNADJVendingPdtLayoutPdtCode').text();
        var nCabinet    = $(poElm).parents('.xCNADJVendingPdtLayoutRow').data('seq-cabinet');
        var tBchCode        = $('#oetBchCode').val();
        var tShpCode        = $('#oetShpCodeStart').val();
        var tPosCode        = $('#oetPosCodeStart').val();
        var tWahCode        = $('#ohdWahCodeStart').val();
        var tDocumentNumber = $('#oetXthDocNo').val();
        
        $.ajax({
            type    : "POST",
            url     : "ADJSTKVDDeletePDTInTemp",
            data    : {
                tDocumentNumber : tDocumentNumber,
                tBchCode        : tBchCode,
                tShpCode        : tShpCode,
                nSeq            : nSeq,
                nPdtCode        : nPdtCode,
                nCabinet        : nCabinet
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                JSxLoadPdtDtFromTem(1);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // ****************************************************************************************************************

    //ลบสินค้าแบบ Delete Multi
    $('#otbDOCPdtTable #odvTBodyADJVDPdtAdvTableList .ocbListItem').unbind().click(function(){
        var tXthDocNo    = $('#oetXthDocNo').val();
        var tShpCode     = $('#oetShpCodeStart').val();
        var tADJVDSeqNo  = $(this).parents('.xWPdtItem').data('seq-no');
        var tPdtCode     = $(this).parents('.xCNADJVendingPdtLayoutRow').find('.xCNADJVendingPdtLayoutPdtCode').text();
        var tSeqCabinet  = $(this).parents('.xWPdtItem').data('seq-cabinet');

        $(this).prop('checked', true);

        let oLocalItemDTTemp    = localStorage.getItem("LocalItemData");
        let oDataObj            = [];
        if(oLocalItemDTTemp){
            oDataObj    = JSON.parse(oLocalItemDTTemp);
        }
        let aArrayConvert   = [JSON.parse(localStorage.getItem("LocalItemData"))];

        if(aArrayConvert == '' || aArrayConvert == null){
            oDataObj.push({
                'tDocNo'   : tXthDocNo,
                'tSeqNo'   : tADJVDSeqNo,
                'tPdtCode' : tPdtCode,
                'tSeqCabinet' : tSeqCabinet,
                'tShpCode' : tShpCode
            });
            localStorage.setItem("LocalItemData",JSON.stringify(oDataObj));
            JSxADJVDTextInModalDelPdtDtTemp();
        }else{
            var aReturnRepeat   = JStADJVDFindObjectByKey(aArrayConvert[0],'tSeqNo',tADJVDSeqNo);
            if(aReturnRepeat == 'None'){
                //ยังไม่ถูกเลือก
                oDataObj.push({
                    'tDocNo'   : tXthDocNo,
                    'tSeqNo'   : tADJVDSeqNo,
                    'tPdtCode' : tPdtCode,
                    'tSeqCabinet' : tSeqCabinet,
                    'tShpCode' : tShpCode
                });
                localStorage.setItem("LocalItemData",JSON.stringify(oDataObj));
                JSxADJVDTextInModalDelPdtDtTemp();
            }else if(aReturnRepeat == 'Dupilcate'){
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].tSeqNo == tADJVDSeqNo){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata   = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxADJVDTextInModalDelPdtDtTemp();
            }
        }
        JSxADJVDShowButtonDelMutiDtTemp();
    });

    //เซตข้อความลบในสินค้า
    function JSxADJVDTextInModalDelPdtDtTemp(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
        }else{
            var tADJVDTextSeqNo     = "";
            var tADJVDPdtCode       = "";
            var tSeqCabinet         = "";
            var tADJVDShop          = "";
            $.each(aArrayConvert[0],function(nKey,aValue){

                tADJVDTextSeqNo += aValue.tSeqNo;
                tADJVDTextSeqNo += " , ";

                tADJVDPdtCode   += aValue.tPdtCode;
                tADJVDPdtCode   += " , ";

                tSeqCabinet     += aValue.tSeqCabinet;
                tSeqCabinet     += " , ";

                tADJVDShop     += aValue.tShpCode;
                tADJVDShop     += " , ";
            });

            $('#odvADJVDModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDSeqNoDelete').val(tADJVDTextSeqNo);
            $('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDPdtCodeDelete').val(tADJVDPdtCode);
            $('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDSeqCabinetDelete').val(tSeqCabinet);
            $('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDShopDelete').val(tADJVDShop);
        }
    }

    //ค้นหา KEY
    function JStADJVDFindObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }

    //แสดงให้ปุ่ม Delete กดได้
    function JSxADJVDShowButtonDelMutiDtTemp(){
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
            $("#odvADJVDMngDelPdtInTableDT #oliADJVDBtnDeleteMulti").addClass("disabled");
        }else{
            var nNumOfArr   = aArrayConvert[0].length;
            if(nNumOfArr > 1) {
                $("#odvADJVDMngDelPdtInTableDT #oliADJVDBtnDeleteMulti").removeClass("disabled");
            }else{
                $("#odvADJVDMngDelPdtInTableDT #oliADJVDBtnDeleteMulti").addClass("disabled");
            }
        }
    }

    // Confirm Delete Modal Multiple
    $('#odvADJVDModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JSxADJVDDelDocMultiple();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //ลบ comma
    function JSoADJVDRemoveCommaData(paData){
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
    function JSxADJVDDelDocMultiple(){
        var tXthDocNo       = $('#oetXthDocNo').val();
        var tADJVDBchCode   = $('#oetBchCode').val();
        var aDataSeqNo      = JSoADJVDRemoveCommaData($('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDSeqNoDelete').val());
        var aDataCabinet    = JSoADJVDRemoveCommaData($('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDSeqCabinetDelete').val());
        var aDataPdtCode    = JSoADJVDRemoveCommaData($('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDPdtCodeDelete').val());
        var aDataShpCode    = JSoADJVDRemoveCommaData($('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDShopDelete').val());

        JCNxOpenLoading();
        $.ajax({
            type : "POST",
            url  : "ADJSTKVDRemoveMultiPdtInDTTmp",
            data : {
                'tBchCode'      : tADJVDBchCode,
                'tDocNo'        : tXthDocNo,
                'paDataSeqNo'   : aDataSeqNo,
                'paDataCabinet' : aDataCabinet,
                'paDataPdtCode' : aDataPdtCode,
                'aDataShpCode'  : aDataShpCode
            },
            catch :false,
            timeout: 0,
            success: function (tResult){
                var aReturnData = JSON.parse(tResult); 
                if(aReturnData['nStaEvent'] == '1'){
                    $('#odvADJVDModalDelPdtInDTTempMultiple').modal('hide');
                    $('#odvADJVDModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDSeqNoDelete').val('');
                    $('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDSeqCabinetDelete').val('');
                    $('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDPdtCodeDelete').val('');
                    $('#odvADJVDModalDelPdtInDTTempMultiple #ohdConfirmADJVDPunNameDelete').val('');
                    setTimeout(function(){
                        $('.modal-backdrop').remove();
                        JSxLoadPdtDtFromTem(1);
                        $("#odvADJVDMngDelPdtInTableDT #oliADJVDBtnDeleteMulti").addClass("disabled");
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

    //ลบสินค้าทั้งหมดจาก checkbox 
    function JSxAddlocalStorage(){


        $('.ocbListItem').each(function(){
            var tXthDocNo    = $('#oetXthDocNo').val();
            var tShpCode     = $('#oetShpCodeStart').val();
            var tADJVDSeqNo  = $(this).parents('.xWPdtItem').data('seq-no');
            var tPdtCode     = $(this).parents('.xCNADJVendingPdtLayoutRow').find('.xCNADJVendingPdtLayoutPdtCode').text();
            var tSeqCabinet  = $(this).parents('.xWPdtItem').data('seq-cabinet');

            $(this).prop('checked', true);

            let oLocalItemDTTemp    = localStorage.getItem("LocalItemData");
            let oDataObj            = [];
            if(oLocalItemDTTemp){
                oDataObj    = JSON.parse(oLocalItemDTTemp);
            }
            let aArrayConvert   = [JSON.parse(localStorage.getItem("LocalItemData"))];

            if(aArrayConvert == '' || aArrayConvert == null){
                oDataObj.push({
                    'tDocNo'   : tXthDocNo,
                    'tSeqNo'   : tADJVDSeqNo,
                    'tPdtCode' : tPdtCode,
                    'tSeqCabinet' : tSeqCabinet,
                    'tShpCode' : tShpCode
                });
                localStorage.setItem("LocalItemData",JSON.stringify(oDataObj));
                JSxADJVDTextInModalDelPdtDtTemp();
            }else{
                var aReturnRepeat   = JStADJVDFindObjectByKey(aArrayConvert[0],'tSeqNo',tADJVDSeqNo);
                if(aReturnRepeat == 'None'){
                    //ยังไม่ถูกเลือก
                    oDataObj.push({
                        'tDocNo'   : tXthDocNo,
                        'tSeqNo'   : tADJVDSeqNo,
                        'tPdtCode' : tPdtCode,
                        'tSeqCabinet' : tSeqCabinet,
                        'tShpCode' : tShpCode
                    });
                    localStorage.setItem("LocalItemData",JSON.stringify(oDataObj));
                    JSxADJVDTextInModalDelPdtDtTemp();
                }else if(aReturnRepeat == 'Dupilcate'){
                    localStorage.removeItem("LocalItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i].tSeqNo == tADJVDSeqNo){
                            delete aArrayConvert[0][$i];
                        }
                    }
                    var aNewarraydata   = [];
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i] != undefined){
                            aNewarraydata.push(aArrayConvert[0][$i]);
                        }
                    }
                    localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                    JSxADJVDTextInModalDelPdtDtTemp();
                }
            }
            JSxADJVDShowButtonDelMutiDtTemp();
        });
    }

</script>