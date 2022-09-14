<script type="text/javascript">
    $(document).ready(function(){
        localStorage.removeItem('LocalItemData');
        JSxCheckPinMenuClose();

        JSvRVDCallPageList();
        JSxRVDControlNavDefault('MAINPAGE');
    });

    //Function List
    function JSvRVDCallPageList(){
        $.ajax({
            type    : "GET",
            url     : "docRVDRefillPDTVDPageList",
            data    : {},
            cache   : false,
            timeout : 5000,
            success: function(tResult) {
                $('#odvProgressSplit').modal('hide');

                setTimeout(function(){
                    $("#odvContentPageRVD").html(tResult);
                    JSvRVDCallPagePdtDataTable(1);
                    JSxRVDControlNavDefault('MAINPAGE');
                }, 500);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Control menu bar
    function JSxRVDControlNavDefault(ptType) {
        if(ptType == 'MAINPAGE'){
            $("#oliRVDTitleAdd").hide();
            $("#oliRVDTitleEdit").hide();
            $("#odvBtnAddEdit").hide();
            $("#odvBtnRVDInfo").show();
        }else if(ptType == 'PAGEADD'){
            $('#odvBtnRVDInfo').hide();
            $('#odvBtnAddEdit').show();
            $('#oliRVDTitleAdd').show();
            $('#oliRVDTitleEdit').hide();
            $('#obtRVDCancel').hide();
            $('#obtRVDApprove').hide();
            $('#obtRVDPrint').hide();
            $('.xCNRVDBtnSave').show();
        }else if(ptType == 'PAGEEDIT'){
            $('#odvBtnRVDInfo').hide();
            $('#odvBtnAddEdit').show();
            $('#oliRVDTitleAdd').hide();
            $('#oliRVDTitleEdit').show();
            $('#obtRVDCancel').show();
            $('#obtRVDApprove').show();
            $('#obtRVDPrint').show();

            //ปุ่มสำหรับเอกสารอนุมัติแล้ว หรือ ยกเลิก
            JSxControlWhenApproveOrCancel();
        }
    }

    //Control ปุ่มสำหรับเอกสารอนุมัติแล้ว หรือ ยกเลิก
    function JSxControlWhenApproveOrCancel(){
        //ถ้าเอกสารถูกยกเลิก + ถ้าเอกสารอนุมัติเเล้ว
        if($('#ohdRVDStaDoc').val() == 3 || $('#ohdRVDStaApv').val() == 1){
            $('.xCNApvOrCanCelDisabled').attr('disabled',true);
            $('.xCNhideWhenApproveOrCancel').hide();
            $('#obtRVDCancel').hide();
            $('#obtRVDApprove').hide();
            $('#obtRVDPrint').show();
            $('.xCNRVDBtnSave').hide();
        }
    }

    //Call Table
    function JSvRVDCallPagePdtDataTable(pnPage){
        var oAdvanceSearch = JSoRVDGetAdvanceSearchData();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        JCNxCloseLoading();
        $.ajax({
            type    : "POST",
            url     : "docRVDRefillPDTVDDataTable",
            data    : {
                oAdvanceSearch  : oAdvanceSearch,
                nPageCurrent    : nPageCurrent
            },
            cache   : false,
            timeout : 0,
            success : function (oResult) {
                $('#odvContentRVD').html(oResult);
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ฟังก์ชั่น get ค่า INPUT Search
    function JSoRVDGetAdvanceSearchData() {
        var oAdvanceSearchData = {
            tSearchAll          : $("#oetSearchAll").val(),
            tSearchBchCodeFrom  : $("#oetBchCodeFrom").val(),
            tSearchBchCodeTo    : $("#oetBchCodeTo").val(),
            tSearchDocDateFrom  : $("#oetSearchDocDateFrom").val(),
            tSearchDocDateTo    : $("#oetSearchDocDateTo").val(),
            tSearchStaDoc       : $("#ocmStaDoc").val(),
            tSearchStaApprove   : $("#ocmStaApprove").val(),
            tSearchStaPrcStk    : $("#ocmStaPrcStk").val()
        };
        return oAdvanceSearchData;
    }

    //Call Page Add
    function JSvRVDCallPageAdd(){
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "docRVDRefillPDTVDPageAdd",
                    data    : { tDocumentNumber : $('#oetRVDDocNo').val() },
                    cache   : false,
                    timeout : 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvContentPageRVD').html(aReturnData['tViewPageAdd']);
                            JSxRVDControlNavDefault('PAGEADD');
                            JCNxLayoutControll();
                            JCNxCloseLoading();
                        }else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log('JSvRVDCallPageAdd Error: ', err);
        }
    }

    //Call Page Edit
    function JSvRVDCallPageEdit(tDocumentNumber){
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "docRVDRefillPDTVDPageEdit",
                    data    : { tDocumentNumber : tDocumentNumber },
                    cache   : false,
                    timeout : 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvContentPageRVD').html(aReturnData['tViewPageAdd']);
                            JSxRVDControlNavDefault('PAGEEDIT');
                            JCNxLayoutControll();
                            JCNxCloseLoading();

                            JSxGotoStep4();
                        }else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log('JSvRVDCallPageEdit Error: ', err);
        }
    }

    //Go To Step 4
    function JSxGotoStep4(){
        $('#ohdClickStep').val(4);
        $('.xCNRefillVDStep4').click();
    }

    //Cancel ยกเลิกเอกสาร
    function JSvRVDCancleDocument(pbIsConfirm){
        if (pbIsConfirm) {
            $.ajax({
                type    : "POST",
                url     : "docRVDRefillPDTCancelDocument",
                data    : {
                    tDocumentNumber : $("#oetRVDDocNo").val()
                },
                cache   : false,
                timeout : 5000,
                success : function (tResult) {
                    $("#odvRVDPopupCancel").modal("hide");
                    JCNxCloseLoading();
                    setTimeout(function(){ 
                        JSvRVDCallPageList();
                    }, 500);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            $("#odvRVDPopupCancel").modal("show");
        }
    }

    //function validate before save
    function JSxRVDEventAddEdit(){
        //กรุณากรอกข้อมูลให้ครบถ้วน
        var tCheckClassTbody = $('.xCNTableStep1 #otdTBodyTableStep1 tr').hasClass('otrDataNotFound');
        if(tCheckClassTbody == true){
            //ไม่มีข้อมูลใน step1
            setTimeout(function(){
                $('#odvPDTInStep1IsEmpty').modal('show');
            }, 500);
            return;
        }

        if($('#ohdClickStep').val() != 4){
            //กรุณาตรวจสอบข้อมูลให้ครบก่อนกดบันทึก
            setTimeout(function(){
                $('#odvRecheckFullTab').modal('show');
            }, 500);
            return;
        }

        //กรุณากรอกข้อมูลให้ครบถ้วน
        if($('#oetRVDCusTransferName').val() == '' || $('#oetRVDCusTransferName').val() == null){
            FSvCMNSetMsgErrorDialog('กรุณากรอกข้อมูลให้ครบถ้วน');
            $('#oetRVDCusTransferName').focus();
            return;
        }

        JSxRVDSubmitEventSaveByButton();
    }

    //บันทึกข้อมูล
    function JSxRVDSubmitEventSaveByButton(){
        var tDocumentNumber = ""
        if ($('#ohdRVDRoute').val() == "docRVDRefillPDTVDEventAdd") {
            tDocumentNumber = $("#oetRVDDocNo").val();
        }else{
            tDocumentNumber = "";
        }
        
        $.ajax({
            type    : "POST",
            url     : $('#ohdRVDRoute').val(),
            data    : $('#ofmRVDFormAdd').serialize(),
            cache   : false,
            timeout : 0,
            success : function (tResult) {
                var aReturn = JSON.parse(tResult);
                if(aReturn["nStaEvent"] == 1){
                    if(aReturn["nStaCallBack"] == "1" || aReturn["nStaCallBack"] == null){
                        JSvRVDCallPageEdit(aReturn['tCodeReturn']);
                    }else if(aReturn["nStaCallBack"] == "2"){
                        JSvRVDCallPageAdd();
                    }else if(aReturn["nStaCallBack"] == "3"){
                        JSvRVDCallPageList();
                    }else{
                        JSvRVDCallPageEdit(aReturn['tCodeReturn']);
                    }
                }else{
                    tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgWarningDialog(tMessageError);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Delete เอกสาร 1 ตัว
    function JSoRVDDelDocSingle(pnPage , ptDocumentNumber){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $('#odvRVDModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val() + ' ' + ptDocumentNumber);
            $('#odvRVDModalDelDocSingle').modal('show');
            $('#odvRVDModalDelDocSingle #osmRVDConfirmPdtDTTemp ').unbind().click(function(){
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "docRVDRefillPDTVDDeleteDocument",
                    data    : { tDocumentNumber : ptDocumentNumber },
                    cache   : false,
                    timeout : 0,
                    success : function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['rtCode'] == '1') {
                            $('#odvRVDModalDelDocSingle').modal('hide');
                            $('#odvRVDModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function () {
                                JSvRVDCallPageList();
                            }, 500);
                        }else{
                            JCNxCloseLoading();
                            FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    //Delete เอกสาร มากกว่า 1 ตัว
    function JSoRVDDelDocMulti(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var aDataDelMultiple    = $('#odvRVDModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
            var aTextsDelMultiple   = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
            var aDataSplit          = aTextsDelMultiple.split(" , ");
            var nDataSplitlength    = aDataSplit.length;
            var aNewIdDelete        = [];
            
            for($i = 0; $i < nDataSplitlength; $i++){
                aNewIdDelete.push(aDataSplit[$i]);
            }
            if(nDataSplitlength > 1){
                JCNxOpenLoading();
                localStorage.StaDeleteArray = '1';
                $.ajax({
                    type    : "POST",
                    url     : "docRVDRefillPDTVDDeleteDocument",
                    data    : { tDocumentNumber : aNewIdDelete },
                    cache   : false,
                    timeout : 0,
                    success : function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['rtCode'] == '1'){
                            $('#odvRVDModalDelDocMultiple').modal('hide');
                            $('#odvRVDModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                            $('#odvRVDModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                            $('.modal-backdrop').remove();
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function () {
                                JSvRVDCallPageList();
                            }, 500);
                        }else{
                            JCNxCloseLoading();
                            FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    //อนุมัติเอกสาร
    function JSxRVDApprovedDocument(pbIsConfirm,pbIsConfirmCheckSTK) {
        if($('#ohdClickStep').val() != 4){
            //กรุณาตรวจสอบข้อมูลให้ครบก่อนกดบันทึก
            setTimeout(function(){
                $('#odvRecheckFullTab').modal('show');
            }, 500);
            return;
        }

        //ต้องเช็คสต๊อก
        if(pbIsConfirmCheckSTK != 'PASS'){
            if($('#ocbRVDStaFullRefillPos:checked').val() == 'on'){
                var tFlagSTKAVG = false;
                $.ajax({
                    type    : "POST",
                    url     : "docRVDRefillPDTCheckStockWhenApv",
                    data    : {
                        tDocumentNumber   : $('#oetRVDDocNo').val() ,
                        nCountPOS         : $('#ohdCountPOS').val()                
                    },
                    cache   : false,
                    async   : false,
                    timeout : 0,
                    success : function(tResult) {
                        if(tResult == true || tResult == 1){
                            $('#odvRVDAVGPDT').modal('show');
                            tFlagSTKAVG = true;
                        }else{
                            tFlagSTKAVG = false;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                        JCNxCloseLoading();
                    }
                });

                if(tFlagSTKAVG == true){
                    return;
                }
            }else{
                var tFlagSTKAVG = false;
            }
        }

        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1) {
            try{
                if(pbIsConfirm == true){
                    $("#odvRVDModalAppoveDoc").modal("hide");
                    // JCNxOpenLoading();
                    $.ajax({
                        type    : "POST",
                        url     : "docRVDRefillPDTApprovedDocument",
                        data    : {
                            tDocumentNumber   : $('#oetRVDDocNo').val(),
                            tFlagSTKAVG       : pbIsConfirmCheckSTK                       
                        },
                        cache   : false,
                        timeout : 0,
                        success : function(tResult) {
                            var oResult = JSON.parse(tResult);
                            if (oResult["nStaEvent"] == "900") {
                                FSvCMNSetMsgErrorDialog(oResult["tStaMessg"]);
                            } else {
                                var tDocumentWahouse = oResult["tDocumentWahouse"];
                                JSoSubscribeMQ_Document(tDocumentWahouse);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                            JCNxCloseLoading();
                        }
                    });
                }else{
                    $("#odvRVDModalAppoveDoc").modal("show");
                }
            }catch(err){
                console.log("JSxRVDApprovedDocument Error: ", err);
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    //วิ่ง sub คิว
    function JSoSubscribeMQ_Document(tDocumentWahouse) {
        var tDocumentNumberTopup = $('#ohdDocumentprintTopup').val(tDocumentWahouse);
        var tLangCode            = $("#ohdLangEdit").val();
        var tUsrBchCode          = $("#oetRVDBchCode").val();
        var tUsrApv              = '<?=$this->session->userdata('tSesUsername')?>';
        var tDocNo               = tDocumentWahouse;
        var tPrefix              = "RESTFW";
        var tStaApv              = $("#ohdRVDStaApv").val();
        var tStaDelMQ            = '';
        var tQName               = 'WAIT'; //tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode           : tLangCode,
            tUsrBchCode         : tUsrBchCode,
            tUsrApv             : tUsrApv,
            tDocNo              : tDocNo,
            tPrefix             : tPrefix,
            tStaDelMQ           : tStaDelMQ,
            tStaApv             : tStaApv,
            tQName              : tQName
        };
        // RabbitMQ STOMP Config
        var poMqConfig = {
            host                : "ws://" + oSTOMMQConfig.host + ":15674/ws",
            username            : oSTOMMQConfig.user,
            password            : oSTOMMQConfig.password,
            vHost               : oSTOMMQConfig.vhost
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName      : "TCNTPdtTwxHD",
            ptDocFieldDocNo     : "FTXthDocNo",
            ptDocFieldStaApv    : "FTXthStaPrcStk",
            ptDocFieldStaDelMQ  : "FTXthStaDelMQ",
            ptDocStaDelMQ       : tStaDelMQ,
            ptDocNo             : tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit       : "JSvRVDCallPageEdit",
            tCallPageList       : "JSvRVDCallPageList"
        };

        //Check Show Progress %
        JSxProgressMulti(poDocConfig,poMqConfig,poUpdateStaDelQnameParams,poCallback);
    }

    //โหลด คิวเป็นแบบ step
    async function JSxProgressMulti(poDocConfig, poRabbitMQConfig, poUpdateStaDelQnameParams, poCallback){
        var poDelQnameParams = {
            "ptPrefixQueueName" : poDocConfig.tPrefix,
            "ptBchCode"         : "",
            "ptDocNo"           : poDocConfig.tDocNo,
            "ptUsrCode"         : poDocConfig.tUsrApv
        };

        //สั้งให้ pop-up โชว์
        $('#odvProgressSplit').modal("show");

        //ถ้ามีเอกสารมากกว่าหนึ่ง
        var aTextDocument 	= poDocConfig.tDocNo.split(",");
        var tTextPopup      = '';
        for(var i=0; i<aTextDocument.length; i++){
            var tDocument       = aTextDocument[i];
            var tUsrApv         = '<?=$this->session->userdata('tSesUsername')?>';
            var tQueuesName     = 'RESTFW' + "_" + aTextDocument[i] + "_" + tUsrApv;
            var tIDDoucment     = 'oalProgressByDocument' + aTextDocument[i];
            tTextPopup  = "<p>";
            tTextPopup += "<label> เอกสารหมายเลข : <label class='text-success'>" + aTextDocument[i] + " </label></label>";
            tTextPopup += "<label style='margin-left: 5px;'> สถานะ : <label class='" + tIDDoucment + " text-warning'>กำลังประมวลผล</label></label>";
            tTextPopup += "</p>";
            $('#odvProgressSplitContent').append(tTextPopup);
        }

        //Loop ส่งข้อมูล
        var aTextDocument = poDocConfig.tDocNo.split(",");
        for(var i=0; i<aTextDocument.length; i++){
            var tDocument       = aTextDocument[i];
            var tUsrApv         = '<?=$this->session->userdata('tSesUsername')?>';
            var tQueuesName     = 'RESTFW' + "_" + aTextDocument[i] + "_" + tUsrApv;
            const tResult       = await JSxGetLastMsg(tQueuesName,tDocument);
            if(tResult == true){
                continue;
            }
        }
    }

    //ค้นหาคิวล่าสุด
    function JSxGetLastMsg(tQueuesName,tDocument){
        return new Promise(resolve => {
            oGetResponse = setInterval(function(){
                $.ajax({
                    url     : 'GetMassageQueueMutiDocument',
                    type    : 'post',
                    data    : { tQName : tQueuesName },
                    async   : false,
                    success:function(res){
                        if(res.trim() == '' || res.trim() == null){
                            resolve(true);
                            $('.oalProgressByDocument'+tDocument).removeClass('text-warning').addClass('text-danger');
                            $('.oalProgressByDocument'+tDocument).text("ไม่สำเร็จ");
                        }else if (res.trim() == '100') {
                            //ส่งค่ากลับไป
                            resolve(true);

                            //ลบ Interval
                            JSxRemoveSetInterval();

                            //ลบ queue
                            var poDelQnameParams = {
                                "ptPrefixQueueName" : 'RESTFW',
                                "ptBchCode"         : "",
                                "ptDocNo"           : tDocument,
                                "ptUsrCode"         : '<?=$this->session->userdata('tSesUsername')?>'
                            };
                            FSxCMNRabbitMQDeleteQname(poDelQnameParams);

                            $('.oalProgressByDocument'+tDocument).removeClass('text-warning').addClass('text-success');
                            $('.oalProgressByDocument'+tDocument).text("สมบูรณ์");
                        }
                    }
                });
            }, 1000);
        });
    }

    //สั้งให้ลบ interval
    function JSxRemoveSetInterval() {
        clearInterval(oGetResponse);
    }
</script>