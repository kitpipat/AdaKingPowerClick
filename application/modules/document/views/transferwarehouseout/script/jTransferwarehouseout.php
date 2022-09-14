<script>

    var nStaTRNBrowseType   = $('#oetTRNStaBrowse').val();
    var tCallTRNBackOption  = $('#oetTRNCallBackOption').val();

    $('document').ready(function() {
        localStorage.removeItem('LocalItemData');
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxTRNNavDefult();
        JSvTWOCallPageTransferwarehouseout();
    }); 

    //ซ่อนปุ่มต่างๆ
    function JSxTRNNavDefult() {
        try{
            $('.xCNTRNMaster').show();
            $('#oliTransferwarehouseoutTitleAdd').hide();
            $('#oliTransferwarehouseoutTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('#odvBtnTransferwarehouseoutInfo').show();
        }catch(err){
            console.log('JSxCardShiftTopUpCardShiftTopUpNavDefult Error: ', err);
        }
    }

    //Page - List
    function JSvTWOCallPageTransferwarehouseout(){
        try{
            var nStaSession         = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('#oetSearchAll').val('');
                $.ajax({
                    type    : "POST",
                    url     : "TWOTransferwarehouseoutList",
                    cache   : false,
                    timeout : 0,
                    success : function(tResult) {
                        $('#odvContentTransferwarehouseout').html(tResult);
                        JSvTWOCallPageTransferwarehouseoutDataTable();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxTRNResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log('JSvTWOCallPageTransferwarehouseout Error: ', err);
        }
    }

    //Page - Datatable
    function JSvTWOCallPageTransferwarehouseoutDataTable(pnPage){
        JCNxOpenLoading();
        var oAdvanceSearch = JSoTRNGetAdvanceSearchData();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var nTWODocType = $('#oetTWODocType').val();
        JCNxCloseLoading();
        $.ajax({
            type    : "POST",
            url     : "TWOTransferwarehouseoutDataTable",
            data    : {
                oAdvanceSearch  : oAdvanceSearch,
                nPageCurrent    : nPageCurrent,
                nTWODocType     : nTWODocType
            },
            cache   : false,
            timeout : 0,
            success : function (oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSxTRNNavDefult();
                    $('#ostContentTransferwarehouseout').html(aReturnData['tViewDataTable']);
                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Page - Add
    function JSvTWOTransferwarehouseoutAdd(){
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "TWOTransferwarehouseoutPageAdd",
                    cache   : false,
                    timeout : 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('.xCNTRNMaster').show();
                            $('#oliTransferwarehouseoutTitleEdit').hide();
                            $('#oliTransferwarehouseoutTitleAdd').show();
                            $('#odvBtnTransferwarehouseoutInfo').hide();
                            $('#odvBtnAddEdit').show();
                            JSxControlBTN('PAGEADD');
                            $('#odvContentTransferwarehouseout').html(aReturnData['tViewPageAdd']);
                            JCNxLayoutControll();
                            JCNxCloseLoading();

                            //Load PDT - TABLE
                            JSvTRNLoadPdtDataTableHtml();
                        }else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxTRNResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log('JSvTWOTransferwarehouseoutAdd Error: ', err);
        }
    }

    //Page - Edit
    function JSvTWOCallPageEdit(ptDocNumber) {
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var nTWODocType = $('#oetTWODocType').val();
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "TWOTransferwarehouseoutPageEdit",
                    data    : { ptDocNumber: ptDocNumber,nTWODocType:nTWODocType },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('.xCNTRNMaster').show();
                            $('#oliTransferwarehouseoutTitleEdit').show();
                            $('#oliTransferwarehouseoutTitleAdd').hide();
                            $('#odvBtnTransferwarehouseoutInfo').hide();
                            $('#odvBtnAddEdit').show();
                            JSxControlBTN('PAGEEDIT');
                            $('#odvContentTransferwarehouseout').html(aReturnData['tViewPageAdd']);
                            JCNxLayoutControll();
                            JCNxCloseLoading();

                            //Load PDT - TABLE
                            JSvTRNLoadPdtDataTableHtml();
                        }else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxTRNResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log('JSvTWOCallPageEdit Error: ', err);
        }
    }

    //Control ปุ่ม
    function JSxControlBTN(ptTypeEvent){
        if(ptTypeEvent == 'PAGEADD'){
            $('#obtTWOPrintDoc').hide();
            $('#obtTWOCancelDoc').hide();
            $('#obtTWOApproveDoc').hide();
        }
    }

    //Page - Product Table
    function JSvTRNLoadPdtDataTableHtml(pnPage){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            if($("#ohdTWORoute").val() == "dcmTWOEventAdd"){
                var tTWODocNo    = "";
            }else{
                var tTWODocNo    = $("#oetTWODocNo").val();
            }

            var tTWOStaApv       = $("#ohdTWOStaApv").val();
            var tTWOStaDoc       = $("#ohdTWOStaDoc").val();
            
            if(pnPage == '' || pnPage == null){
                var pnNewPage = 1;
            }else{
                var pnNewPage = pnPage;
            }
            var nPageCurrent = pnNewPage;
            var tSearchPdtAdvTable  = $('#oetTWOFrmFilterPdtHTML').val();

            $.ajax({
                type    : "POST",
                url     : "TWOTransferwarehouseoutPdtAdvanceTableLoadData",
                data: {
                        'ptSearchPdtAdvTable'    : tSearchPdtAdvTable,
                        'ptTWODocNo'             : tTWODocNo,
                        'ptTWOStaApv'            : tTWOStaApv,
                        'ptTWOStaDoc'            : tTWOStaDoc,
                        'pnTWOPageCurrent'       : nPageCurrent,
                        'tBCHCode'               : $('#oetSOFrmBchCode').val()
                },
                cache   : false,
                Timeout : 0,
                success : function (oResult){

                    localStorage.removeItem('TWO_LocalItemDataDelDtTemp');
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == '1') {
                        $('#odvTWODataPdtTableDTTemp').html(aReturnData['tTWOPdtAdvTableHtml']);
                        // var aTWOEndOfBill    = aReturnData['aTWOEndOfBill'];
                        // JSxTWOSetFooterEndOfBill(aTWOEndOfBill);
                        JCNxCloseLoading();
                    }else{
                        var tMessageError = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                        JCNxCloseLoading();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    //แสดง error
    function JCNxTRNResponseError(jqXHR, textStatus, errorThrown) {
        try{
            JCNxResponseError(jqXHR, textStatus, errorThrown)
        }catch(err){
            console.log('JCNxTRNResponseError Error: ', err);
        }
    }

    //ฟังก์ชั่น get ค่า INPUT Search
    function JSoTRNGetAdvanceSearchData() {
        var oAdvanceSearchData = {
            tSearchAll          : $("#oetSearchAll").val(),
            tSearchBchCodeFrom  : $("#oetASTBchCodeFrom").val(),
            tSearchBchCodeTo    : $("#oetASTBchCodeTo").val(),
            tSearchDocDateFrom  : $("#oetASTDocDateFrom").val(),
            tSearchDocDateTo    : $("#oetASTDocDateTo").val(),
            tSearchStaDoc       : $("#ocmASTStaDoc").val(),
            tSearchStaDocAct: $("#ocmStaDocAct").val(),
            tSearchStaApprove   : $("#ocmASTStaApprove").val(),
            tSearchStaPrcStk    : $("#ocmASTStaPrcStk").val()
        };
        return oAdvanceSearchData;
    }

    //ฟังก์ชั่นล้างค่า Input Advance Search
    function JSxTRNClearSearchData(){
       var nStaSession = JCNxFuncChkSessionExpired();
       if(typeof nStaSession !== "undefined" && nStaSession == 1){
           $("#oetSearchAll").val("");
           $("#oetASTBchCodeFrom").val("");
           $("#oetASTBchNameFrom").val("");  
           $("#oetASTBchCodeTo").val("");
           $("#oetASTBchNameTo").val("");
           $("#oetASTDocDateFrom").val("");
           $("#oetASTDocDateTo").val("");
           $(".xCNDatePicker").datepicker("setDate", null);
           $(".selectpicker").val("0").selectpicker("refresh");
           JSvTWOCallPageTransferwarehouseoutDataTable();
       }else{
           JCNxShowMsgSessionExpired();
       }
    }

    //เปลี่ยนหน้า 1 2 3 ..
    function JSvTWOClickPage(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld        = $(".xWPageTWOPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld        = $(".xWPageTWOPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                default:
                    nPageCurrent    = ptPage;
            }
            JSvTWOCallPageTransferwarehouseoutDataTable(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ลบ HD - ตัวเดียว
    function JSoTWODelDocSingle(ptCurrentPage,ptTWODocNo){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $('#odvTWOModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val() + ptTWODocNo);
            $('#odvTWOModalDelDocSingle').modal('show');
            $('#odvTWOModalDelDocSingle #osmTWOConfirmPdtDTTemp ').unbind().click(function(){
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "TWOTransferwarehouseoutEventDelete",
                    data    : {'tTWODocNo': ptTWODocNo},
                    cache   : false,
                    timeout : 0,
                    success : function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1') {
                            $('#odvTWOModalDelDocSingle').modal('hide');
                            $('#odvTWOModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function () {
                                JSvTWOCallPageTransferwarehouseout();
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

    //ลบ HD - หลายตัว
    function JSoTWODelDocMultiple(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var aDataDelMultiple    = $('#odvTWOModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
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
                    url     : "TWOTransferwarehouseoutEventDelete",
                    data    : {'tTWODocNo': aNewIdDelete},
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1'){
                            $('#odvTWOModalDelDocMultiple').modal('hide');
                            $('#odvTWOModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                            $('#odvTWOModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                            $('.modal-backdrop').remove();
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function () {
                                JSvTWOCallPageTransferwarehouseout();
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

    //ยกเลิกเอกสาร
    function JSxTWOTransferwarehouseoutDocCancel(pbIsConfirm) {
        tTWODocNo = $("#oetTWODocNo").val();
        if (pbIsConfirm) {
            $.ajax({
                type    : "POST",
                url     : "TWOTransferwarehouseoutEventCencel",
                data    : {
                    tTWODocNo   : tTWODocNo
                },
                cache   : false,
                timeout : 5000,
                success : function (tResult) {
                    $("#odvTWOPopupCancel").modal("hide");
                    aResult = $.parseJSON(tResult);
                    if (aResult.nSta == 1) {
                        JSvTWOCallPageEdit(tTWODocNo);
                    } else {
                        JCNxCloseLoading();
                        tMsgBody = aResult.tMsg;
                        FSvCMNSetMsgErrorDialog(tMsgBody);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            $("#odvTWOPopupCancel").modal("show");
        }
    }

    
    // Create By: Napat(Jame) 24/06/2022
    async function JSxTWOChkStkB4ApvDoc(pbIsConfirm){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            // if (pbIsConfirm) {
            //     $("#odvTWOModalAppoveDoc").modal("hide");
            //     var aParams = {
            //         'tBchCode'  : $('#oetSOFrmBchCode').val(),
            //         'tWahCode'  : $('#oetTROutWahFromCode').val(),
            //         'tDocNo'    : $('#oetTWODocNo').val(),
            //         'tTableHD'  : 'TCNTPdtTwoHD',
            //         'tTableDT'  : 'TCNTPdtTwoDT',
            //         'tNextFunc' : 'JSxTWOTransferwarehouseoutStaApvDoc'
            //     };
            //     var aChkStkB4ApvDoc = await JCNaChkStkB4ApvDoc(aParams);
            //     if( aChkStkB4ApvDoc['nStaEvent'] == 1 ){
            //         return;
            //     }else{
            //         JSnTFWApprove();
            //     }
            // } else {
            //     $("#odvTWOModalAppoveDoc").modal("show");
            // }

            var aParams = {
                'tBchCode'  : $('#oetSOFrmBchCode').val(),
                'tWahCode'  : $('#oetTROutWahFromCode').val(),
                'tDocNo'    : $('#oetTWODocNo').val(),
                'tTableHD'  : 'TCNTPdtTwoHD',
                'tTableDT'  : 'TCNTPdtTwoDT',
                'tNextFunc' : 'JSxTWOTransferwarehouseoutStaApvDoc'
            };
            var aChkStkB4ApvDoc = await JCNaChkStkB4ApvDoc(aParams);
            if( aChkStkB4ApvDoc['nStaEvent'] == 1 ){
                return;
            }else{
                $("#odvTWOModalAppoveDoc").modal("show");
            }
            
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //อนุมัติเอกสาร
    function JSxTWOTransferwarehouseoutStaApvDoc(pbIsConfirm){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            try{
                if(pbIsConfirm) {
                    $("#ohdTWOStaPrcStk").val(2); // Set status for processing approve 
                    $('#odvTWOModalAppoveDoc').modal("hide");
                    
                    var tXthDocNo   = $("#oetTWODocNo").val();
                    var tXthStaApv  = $("#ohdTWOStaApv").val();
                    var tXthDocType = $('#oetTWODocType').val();
                    var tXthBchCode = $('#ohdTWOBchCode').val();
                    $.ajax({
                        type    : "POST",
                        url     : "TWOTransferwarehouseoutEventApproved",
                        data: {
                            tXthDocNo   : tXthDocNo,
                            tXthStaApv  : tXthStaApv,
                            tXthDocType : tXthDocType,
                            tXthBchCode : tXthBchCode
                        },
                        cache   : false,
                        timeout : 0,
                        success : function (tResult){
                            if (tResult.nStaEvent == "900") {
                                FSvCMNSetMsgErrorDialog(tResult.tStaMessg);
                                JCNxCloseLoading();
                                return;
                            }
                            JSoTWOSubscribeMQ();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }else{
                    $('#odvTWOModalAppoveDoc').modal("show");
                }
            } catch (err){
                console.log("JSxTWOTransferwarehouseoutStaApvDoc Error: ", err);
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    //อนุมัติเอกสาร
    function JSoTWOSubscribeMQ(){   
        var tLangCode   = $("#ohdTWOLangEdit").val();
        var tUsrBchCode = $("#ohdTWOBchCode").val();
        var tUsrApv     = $("#ohdTWOSesUsrLogin").val();
        var tDocNo      = $("#oetTWODocNo").val();
        var tPrefix     = 'RESTWO';
        var tStaApv     = $("#ohdTWOStaApv").val();
        var tStaDelMQ   = $("#ohdTWOStaDelMQ").val();
        var tQName      = tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode: tLangCode,
            tUsrBchCode: tUsrBchCode,
            tUsrApv: tUsrApv,
            tDocNo: tDocNo,
            tPrefix: tPrefix,
            tStaDelMQ: tStaDelMQ,
            tStaApv: tStaApv,
            tQName: tQName
        };

        // RabbitMQ STOMP Config
        var poMqConfig = {
            host        : "ws://" + oSTOMMQConfig.host + ":15674/ws",
            username    : oSTOMMQConfig.user,
            password    : oSTOMMQConfig.password,
            vHost       : oSTOMMQConfig.vhost
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: 'JSvTWOCallPageEdit',
            tCallPageList: 'JSvTWOCallPageTransferwarehouseout'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName: "TCNTPdtTwoHD",
            ptDocFieldDocNo: "FTXthDocNo",
            ptDocFieldStaApv: "FTXthStaPrcStk",
            ptDocFieldStaDelMQ: "FTXthStaDelMQ",
            ptDocStaDelMQ: "1",
            ptDocNo: tDocNo
        };

        //Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            poMqConfig,
            poUpdateStaDelQnameParams,
            poCallback
        );
    }

</script>