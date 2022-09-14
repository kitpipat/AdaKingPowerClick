<script>

    $(document).ready(function(){

        localStorage.removeItem("LocalItemData");
        $('.ocbListItem').click(function(){
            var tSeq = $(this).parent().parent().parent().attr('data-seq-no');    //Seq
            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if(LocalItemData){
                obj = JSON.parse(LocalItemData);
            }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if(aArrayConvert == '' || aArrayConvert == null){
                obj.push({"tSeq": tSeq,});
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTVOPdtTextinModal();
            }else{
                var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeq',tSeq);
                if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                    obj.push({"tSeq": tSeq});
                    localStorage.setItem("LocalItemData",JSON.stringify(obj));
                    JSxTVOPdtTextinModal();
                }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalItemData");
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
                    localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                    JSxTVOPdtTextinModal();
                }
            }
            JSxTVOPdtShowButtonChoose();
        });

        $("#oetAllCheck").click(function(){ // เมื่อคลิกที่ checkbox ตัวควบคุม
            if($(this).prop("checked")){
                $(".ocbListItem").prop("checked",true);
                JSxAddlocalStorage();
            }else{
                $(".ocbListItem").prop("checked",false); 
                localStorage.removeItem("LocalItemData");
                JSxTVOPdtTextinModal();
            }
        });




        // Create By : Napat(Jame) 10/09/2020
        sessionStorage.removeItem("EditInLine");

        $('.xCNPdtEditInLine').off('keydown');
        $('.xCNPdtEditInLine').on('keydown',function(){
            if(event.keyCode == 13){
                if(sessionStorage.getItem("EditInLine") != "2"){
                    sessionStorage.setItem("EditInLine", "1");
                    JSxTVOEditInLine($(this));
                }
            }
        });
        
        $('.xCNPdtEditInLine').off('focus');
        $('.xCNPdtEditInLine').on('focus',function(){
            this.select();
        });

        $('.xCNPdtEditInLine').off('change');
        $('.xCNPdtEditInLine').on('change',function(){
            if(sessionStorage.getItem("EditInLine") != "2"){
                sessionStorage.setItem("EditInLine", "1");
                JSxTVOEditInLine($(this));
            }
        });

        if(bIsApvOrCancel){
            $('form .xCNApvOrCanCelDisabledQty').attr('disabled', true);
            $('#otbDOCPdtTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbDOCPdtTable .xCNIconDel').removeAttr('onclick', true);
            $('.xCNBTNMngTable').hide();
            $('.xCNCheckboxWhenDelete').hide();
            $('#obtTVOBrowsePdt').hide();
        }else{
            $('form .xCNApvOrCanCelDisabledQty').attr('disabled', false);
            $('#otbDOCPdtTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbDOCPdtTable .xCNIconDel').attr('onclick', 'JSxTVOPdtDataTableDeleteBySeq(this)');
            $('.xCNBTNMngTable').show();
            $('.xCNCheckboxWhenDelete').show();
            $('#obtTVOBrowsePdt').show();
        }
    });

    //Create By : Napat(Jame) 10/09/2020
    function JSxTVOPdtTextinModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $(".xCNIconDel").removeClass("xCNDisabled");
        } else {
            var tTextCode = "";
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].tSeq;
                tTextCode += " , ";
            }
            //Disabled ปุ่ม Delete
            if (aArrayConvert[0].length > 1) {
                $(".xCNIconDel").addClass("xCNDisabled");
            } else {
                $(".xCNIconDel").removeClass("xCNDisabled");
            }

            $("#ospConfirmDelete").text("ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?");
            $("#ohdConfirmIDDelete").val(tTextCode);
        }
    }

    //Create By : Napat(Jame) 10/09/2020
    function JSxTVOPdtShowButtonChoose() {
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
    
    //Create By : Napat(Jame) 10/09/2020
    function JSxTVOEditInLine(poElm){
        if(sessionStorage.getItem("EditInLine") == "1"){
            sessionStorage.setItem("EditInLine", "2");
            
            // Get Variable
            var tDocNo      = $('#oetTVODocNo').val();
            var nSeq        = poElm.parent().parent().attr('data-seq-no');
            // var nMaxQty     = poElm.parent().parent().attr('data-max-qty');
            var nStkQty     = poElm.parent().parent().attr('data-stk-qty');
            var tField      = poElm.attr('data-field');
            var nIndex      = $('.xW'+tField).index(poElm);
            var nVal        = parseInt($(poElm).val());

            // Check Values
            if(isNaN(nVal) || nVal === undefined){ nVal = 0; }

            // Next Focus Inputs
            $('.xW'+tField).eq(nIndex + 1).focus();

            // Remove Session
            sessionStorage.removeItem("EditInLine");
            // console.log('nVal: ' + parseInt(nVal));
            // console.log('nStkQty: ' + parseInt(nStkQty));

            // alert('nVal: ' + nVal);
            // alert('nStkQty: ' + nStkQty);

            if( /*parseInt(nVal) > parseInt(nMaxQty) &&*/ parseInt(nVal) > parseInt(nStkQty) ){
                // alert('if');
                $(poElm).val(parseInt(nStkQty));
                nVal = parseInt(nStkQty);
            }
            /*else{
                alert('else');
                nVal = parseInt(nStkQty);
            }*/

            //Update 
            $.ajax({
                type: "POST",
                url: "dcmTVOEventEditInline",
                data: {
                    ptDocNo     : tDocNo,
                    pnSeq       : nSeq,
                    pnVal       : nVal,
                    ptField     : tField
                },
                cache: false,
                timeout: 0,
                success: function(oResult){
                    var aReturn = JSON.parse(oResult);
                    if(aReturn['nStaQuery'] != 1){
                        JCNxResponseError(aReturn['nStaQuery']['tStaMeg']);
                    } 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }
    }

    /**
     * Functionality : Delete PDT Layout in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTVOPdtDataTableDeleteBySeq(poElm) {
        if($(poElm).hasClass('xCNDisabled')){
            return false; //ถ้าเลือกมัลติอยู่ ลบรายการไม่ได้
        }else{
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {

                JCNxOpenLoading();

                var nSeqNo   = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').data('seq-no');
                var tPdtCode = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').data('pdtcode');
                var tPdtName = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').data('pdtname');

                $.ajax({
                    type: "POST",
                    url: "docTVOEventDeletePdtLayoutInTmp",
                    data: {
                        nSeqNo: nSeqNo
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        JSxTVOGetPdtLayoutDataTableInTmp();
                        
                        var tNewTextName = $('#oetTVOPdtNameMulti').val().split(tPdtName+',').join('').split(','+tPdtName).join('').split(tPdtName).join('');
                        var tNewTextCode = $('#oetTVOPdtCodeMulti').val().split(tPdtCode+',').join('').split(','+tPdtCode).join('').split(tPdtCode).join('');
                        $('#oetTVOPdtCodeMulti').val(tNewTextCode);
                        $('#oetTVOPdtNameMulti').val(tNewTextName);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            } else {
                JCNxShowMsgSessionExpired();
            }
        }
    }

    //Create By : Napat(Jame) 10/09/2020
    function JSxTVOPdtDelChoose(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            var aSeq = [];
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                aSeq.push(aArrayConvert[0][$i].tSeq);
            }

            $.ajax({
                type: "POST",
                url: "docTVOEventDeletePdtLayoutInTmp",
                data: {
                    nSeqNo: aSeq
                },
                cache: false,
                timeout: 0,
                success: function() {
                    JSxTVOGetPdtLayoutDataTableInTmp();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }


    //function Checkbox All Header
    // Create By Witsarut 16-09-2020
    function JSxAddlocalStorage(){
        $('.ocbListItem').each(function(){
            var tSeq = $(this).parent().parent().parent().attr('data-seq-no');    //Seq
            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if(LocalItemData){
                obj = JSON.parse(LocalItemData);
            }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if(aArrayConvert == '' || aArrayConvert == null){
                obj.push({"tSeq": tSeq,});
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTVOPdtTextinModal();
            }else{
                var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeq',tSeq);
                if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                    obj.push({"tSeq": tSeq});
                    localStorage.setItem("LocalItemData",JSON.stringify(obj));
                    JSxTVOPdtTextinModal();
                }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalItemData");
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
                    localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                    JSxTVOPdtTextinModal();
                }
            }
            JSxTVOPdtShowButtonChoose();
        });
    }




</script>