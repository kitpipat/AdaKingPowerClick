var nRDHStaBrowseType   = $("#oetRDHStaBrowseType").val();
var tRDHCallBackOption  = $("#oetRDHCallBackOption").val();



$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    if(typeof(nRDHStaBrowseType) != 'undefined' && nRDHStaBrowseType == 0){
        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliRDHTitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvRDHCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtRDHCallPageAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvRDHCallPageAddDocument();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Call Back Page
        $('#obtRDHCallBackPage').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvRDHCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From Document
        $('#obtRDHSubmitFromDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                $tRoute  = $('#ohdRDHRouteEvent').val();
                JSxRDHAddEditDocument($tRoute);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Cancel Document
        $('#obtRDHCancelDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxRDHCancelDocument();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Appove Document
        $('#obtRDHApproveDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxRDHApproveDocument(false);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

   

        JSxRDHNavDefultDocument();
        JSvRDHCallPageList();
    }
});

// Function: Set Defult Nav Menu Document
// Parameters: Document Ready Or Parameter Event
// Creator: 23/12/2019 Wasin(Yoshi)
// Return: Set Default Nav Menu Document
// ReturnType: -
function JSxRDHNavDefultDocument(){
    if(typeof(nRDHStaBrowseType) != 'undefined' && nRDHStaBrowseType == 0) {
        // Title Label Hide/Show
        $('#oliRDHTitleAdd').hide();
        $('#oliRDHTitleEdit').hide();
        $('#oliRDHTitleDetail').hide();
        $("#obtRDHApproveDoc").hide();
        $("#obtRDHCancelDoc").hide();
        $('#obtRDHPrintDoc').hide();
        // Button Hide/Show
        $('#odvRDHBtnGrpAddEdit').hide();
        $('#odvRDHBtnGrpInfo').show();
        $('#obtRDHCallPageAdd').show();
    }else{
        $('#odvModalBody #odvRDHMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliRDHNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvRDHBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNRDHBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNRDHBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 23/12/2019 Wasin(Yoshi)
// Return: Call View Tranfer Out List
// ReturnType: View
function JSvRDHCallPageList(){
    $.ajax({
        type: "GET",
        url: "dcmRDHFormSearchList",
        cache: false,
        timeout: 0,
        success: function (tResult){
            $("#odvRDHContentPageDocument").html(tResult);
            JSxRDHNavDefultDocument();
            JSvRDHCallPageDataTable();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Get Data Advanced Search
// Parameters: Function Call Page
// Creator: 23/12/2019 Wasin(Yoshi)
// Return: object Data Advanced Search
// ReturnType: object
function JSoRDHGetAdvanceSearchData(){
    var oAdvanceSearchData  = {
        tSearchAll          : $("#oetRDHSearchAllDocument").val(),
        tSearchBchCodeFrom  : $("#oetRDHAdvSearchBchCodeFrom").val(),
        tSearchBchCodeTo    : $("#oetRDHAdvSearchBchCodeTo").val(),
        tSearchDocDateFrom  : $("#oetRDHAdvSearcDocDateFrom").val(),
        tSearchDocDateTo    : $("#oetRDHAdvSearcDocDateTo").val(),
        tSearchStaDoc       : $("#ocmRDHAdvSearchStaDoc").val(),
        tSearchStaDocAct    : $("#ocmStaDocAct").val(),
        tSearchStaPrcStk    : $("#ocmRDHAdvSearchStaPrcStk").val()
    };
    return oAdvanceSearchData;
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 23/12/2019 Wasin(Yoshi)
// Return: Call View Tabel Data List Document
// ReturnType: View
function JSvRDHCallPageDataTable(pnPage){
    JCNxOpenLoading();
    let oAdvanceSearch  = JSoRDHGetAdvanceSearchData();
    let nPageCurrent    = pnPage;
    if(typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type: "POST",
        url: "dcmRDHGetDataTable",
        data: {
            oAdvanceSearch  : oAdvanceSearch,
            nPageCurrent    : nPageCurrent,
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxRDHNavDefultDocument();
                $('#ostRDHDataTableDocument').html(aReturnData['tRDHViewDataTableList']);
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

// Functionality : Call Page Add
// Parameters : Event Click Buttom
// Creator : 23/12/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvRDHCallPageAddDocument(){
    JCNxOpenLoading();
    $.ajax({
        type    : "POST",
        url     : "dcmRDHPageAdd",
        cache   : false,
        timeout : 0,
        success : function (oResult) {
            var aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1') {
                if(nRDHStaBrowseType == '1'){
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tRDHViewPageAdd']);
                }else{
                    // Hide Title Menu And Button
                    $('#oliRDHTitleEdit').hide();
                    $('#oliRDHTitleDetail').hide();
                    $("#obtRDHApproveDoc").hide();
                    $("#obtRDHCancelDoc").hide();
                    $('#obtRDHPrintDoc').hide();
                    $('#odvRDHBtnGrpInfo').hide();
                    // Show Title Menu And Button
                    $('#oliRDHTitleAdd').show();
                    $('#odvRDHBtnGrpSave').show();
                    $('#odvRDHBtnGrpAddEdit').show();
                    // Remove Disable Button Add 
                    $(".xWBtnGrpSaveLeft").attr("disabled",false);
                    $(".xWBtnGrpSaveRight").attr("disabled",false);
                    $('#odvRDHContentPageDocument').html(aReturnData['tRDHViewPageAdd']);
                }
                // JSvRDHLoadPdtDataTableHtml();
                JCNxCloseLoading();
                
            }else{
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Call Page Data Detail Table
// Parameters : Event Click Buttom
// Creator : 25/12/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvRDHLoadPdtDataTableHtml(pnPage){
    if($("#ohdRDHRouteEvent").val() == "dcmRDHEventAdd"){
        var tRDHDocNo   = "";
    }else{
        var tRDHDocNo   = $("#oetRDHDocNo").val();
    }
    if(pnPage == '' || pnPage == null){
        var pnNewPage   = 1;
    }else{
        var pnNewPage   = pnPage;
    }
    var nRDHPageCurrent      = pnNewPage;
    var tRDHSearchDataDT     = '';
    var tRDHStaDoc           = $("#ohdRDHStaDoc").val();
    var tRDHStaApv           = $("#ohdRDHStaApv").val();
    var tRDDGrpName          = $('#oetRDDGrpName').val();
    var tRDDGrpCode          = $('#oetRDDGrpCode').val();

    $.ajax({
        type: "POST",
        url: "dcmRDHPdtAdvanceTableLoadData",
        data: {
            'pnRDHPageCurrent'  : nRDHPageCurrent,
            'ptRDHSearchDataDT' : tRDHSearchDataDT,
            'ptRDHDocNo'        : tRDHDocNo,
            'tRDDGrpName'       : tRDDGrpName,
            'tRDDGrpCode'       : tRDDGrpCode,
            'ptRDHStaDoc'       : tRDHStaDoc,
            'ptRDHStaApv'       : tRDHStaApv,
        },
        cache: false,
        Timeout: 0,
        success: function (oResult){
            let aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1') {

                 $('#otbConditionRedeemHDPdtTab').html(aReturnData['tRDHPdtAdvTableHtml']);
                if(tRDDGrpName==tRDDGrpCode && tRDDGrpName!=''){
                 $('#oetRDDGrpName').attr('readonly',true);
                }else{
                    $('#oetRDDGrpName').attr('readonly',false); 
                }
                setTimeout(function(){
                    JCNxCloseLoading();
                },500)
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
}



function JSxRDHClearConditionRedeemTmp(){

    if($("#ohdSORoute").val() == "dcmSOEventAdd"){
        var tRDHDocNo    = "";
    }else{
        var tRDHDocNo    = $("#oetRDHDocNo").val();
    }
    var tRDHUsrBchCode    = $('#ohdRDHUsrBchCode').val();
    var tRDDGrpCode       = $('#oetRDDGrpCode').val();
    $.ajax({
        type: "POST",
        url: "dcmRDHPdtClearConditionRedeemTmp",
        data:{
            tRDHDocNo:tRDHDocNo,
            tBchCode :tRDHUsrBchCode,
            tRDDGrpCode:tRDDGrpCode
        },
        cache: false,
        Timeout: 0,
        success: function (){
       
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Event Single Delete Document Single
// Parameters: Function Call Page
// Creator: 25/12/2019 Wasin(Yoshi)
// Return: object Data Sta Delete
// ReturnType: object
function JSoRDHDelDocSingle(ptCurrentPage, ptRDHDocNo){
    var nStaSession = JCNxFuncChkSessionExpired();    
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        if(typeof(ptRDHDocNo) != undefined && ptRDHDocNo != ""){
            var tTextConfrimDelSingle   = $('#oetTextComfirmDeleteSingle').val()+"&nbsp"+ptRDHDocNo+"&nbsp"+$('#oetTextComfirmDeleteYesOrNot').val();
            $('#odvRDHModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
            $('#odvRDHModalDelDocSingle').modal('show');
            $('#odvRDHModalDelDocSingle #osmConfirmDelSingle').unbind().click(function(){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmRDHEventDelete",
                    data: {'ptDataDocNo' : ptRDHDocNo},
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1') {
                            $('#odvRDHModalDelDocSingle').modal('hide');
                            $('#odvRDHModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function () {
                                JSvRDHCallPageDataTable(ptCurrentPage);
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
            });
        }else{
            FSvCMNSetMsgErrorDialog('Error Not Found Document Number !!');
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Function: Event Single Delete Doc Mutiple
// Parameters: Function Call Page
// Creator: 25/12/2019 Wasin(Yoshi)
// Return: object Data Sta Delete
// ReturnType: object
function JSoRDHDelDocMultiple(){
    var aDataDelMultiple    = $('#odvRDHModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
    var aTextsDelMultiple   = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
    var aDataSplit          = aTextsDelMultiple.split(" , ");
    var nDataSplitlength    = aDataSplit.length;
    var aNewIdDelete        = [];
    for ($i = 0; $i < nDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }
    if(nDataSplitlength > 1) {
        JCNxOpenLoading();
        localStorage.StaDeleteArray = '1';
        $.ajax({
            type: "POST",
            url: "dcmRDHEventDelete",
            data: {'ptDataDocNo' : aNewIdDelete},
            cache: false,
            timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    setTimeout(function () {
                        $('#odvRDHModalDelDocMultiple').modal('hide');
                        $('#odvRDHModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                        $('#odvRDHModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                        $('.modal-backdrop').remove();
                        localStorage.removeItem('LocalItemData');
                        JSvRDHCallPageList();
                    },1000);
                } else {
                    JCNxCloseLoading();
                    FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 25/12/2019 Wasin(Yoshi)
//Return: Show Button Delete All
//Return Type: -
function JSxRDHShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];

    console.log(aArrayConvert);
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliRDHBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliRDHBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliRDHBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 25/12/2019 Wasin(Yoshi)
//Return: Insert Code In Text Input
//Return Type: -
function JSxRDHTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") { } else {
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
        $("#odvRDHModalDelDocMultiple #ospTextConfirmDelMultiple").text($('#oetTextComfirmDeleteMulti').val());
        $("#odvRDHModalDelDocMultiple #ohdConfirmIDDelMultiple").val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 25/12/2019 Wasin(Yoshi)
//Return: Duplicate/none
//Return Type: string
function JStRDHFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

//Functionality : Add Data CouponSetup Add  
//Parameters : from ofmCouponSetupAddEditForm
//Creator : 26/12/2019 Saharat(Golf)
//Return : -
//Return Type : -
function JSxRDHAddEditDocument(ptRoute) {
    let tRDHFrmCptCode = $('#oetRDHFrmCptCode').val();
    if($('#oetRDHName').val()!=''){
        let nCountDataInTableDT = $('.otrConditionRedeemCDGROUP').length;
        if(nCountDataInTableDT > 0){
            $('#ocmRDHDocType').attr('disabled',false);
            // JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmConditionRedeemAddEditForm').serialize()  ,  
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aDataReturn = JSON.parse(tResult);
                    if(aDataReturn['nStaEvent'] == '1'){
                        var nCouponStaCallBack  = aDataReturn['nStaCallBack'];
                        var tCouponCoderReturn  = aDataReturn['tCodeReturn'];
                        var tBchCoderReturn  = aDataReturn['tBchCode'];
                        switch(nCouponStaCallBack){
                            case 1 :
                                JSvRDHCallPageEditDocument(tCouponCoderReturn, tBchCoderReturn);
                            break;
                            case 2 :
                                JSvRDHCallPageAddDocument();
                            break;
                            case 3 :
                                JSvRDHCallPageList();
                            break;
                            default :
                                JSvRDHCallPageEditDocument(tCouponCoderReturn, tBchCoderReturn);
                        }
                    }else{
                        JCNxResponseError(aDataReturn['tStaMessg']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            }else{
                $tTextMessage   = $('#ohdRDHMsgNotFoundDT').val()
                FSvCMNSetMsgWarningDialog($tTextMessage);
            }
        }else{
            $tTextMessage   = $('#ohdRDHValidatePromotionRedeem').val();
            FSvCMNSetMsgWarningDialog($tTextMessage);
        }
    // }else{
    //     $tTextMessage   = $('#oetRDHHDCstPriCode').attr('validatedata');
    //     FSvCMNSetMsgWarningDialog($tTextMessage);
    // }
}

//Functionality : Call Coupon Page Edit
//Parameters : -
//Creator : 26/012/2019 Saharat(Golf) 
//Return : View
//Return Type : View
function JSvRDHCallPageEditDocument(ptRDHDocNo ,ptBchCode) {
   JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "dcmRDHPageEdit",
        data: { 
            tRDHDocNo : ptRDHDocNo ,
            tBchCode  : ptBchCode
        },
        cache: false,
        timeout: 0,
        success: function(aResult) {
            $('#odvRDHContentPageDocument').html(aResult);
            JSvRDHLoadGroupListTable();
            JSxRDHControlObjAndBtn();
            JSxRddPdtGroupPageFinal();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


function JSxRDHControlObjAndBtn(){
    // Check สถานะอนุมัติ
    var nRDHStaDoc      = $("#ohdRDHStaDoc").val();
    var nRDHStaApv      = $("#ohdRDHStaApv").val();
    var tRDHStaPrcDoc   = $('#ohdRDHStaPrcDoc').val();
    let tCouponSetupPage = $('#ohdRDHRouteEvent').val();

   
    JSxRDHNavDefultDocument();

    // Title Menu Set De
    $("#oliRDHTitleAdd").show();
    $('#oliRDHTitleDetail').hide();
    $('#oliRDHTitleEdit').hide();
    $('#odvRDHBtnGrpInfo').hide();
    // Button Menu

    if(tCouponSetupPage != 'dcmRDHEventAdd'){
      
        $("#obtRDHApproveDoc").show();
        $("#obtRDHCancelDoc").show();
        $("#obtRDHPrintDoc").show();
        $('#obtRDHNextStepDoc').hide();
        $('#odvRDHBtnGrpSave').show();
        $('.oliTab_step').removeClass('active');
        $('.tab-pane').removeClass('active');
        $('#complete').addClass('active');
        $('.olbTab_step').css('color','rgb(224, 224, 224)');
        $('#olbTab_step4').css('color','rgb(29, 37, 48)');
        $('#oliTab_step4').addClass('active');
        $('#ohdRDHNowTab').val(4);

        for(i=1;i<=4;i++){
            $('#oliTab_step'+i).removeClass('disabled');
            $('#ospTab_step'+i).css( "background-color", "#1D2530" );
        }
        $('#obtTabConditionRedeemHDGrp').hide();

        if($('#ocmRDHDocType').val() != 1){
            $('#oliTab_step1').hide();
            $('.hideGrpNameColum').hide();
            $('#obtTabConditionRedeemHDGrp').css('display','block');
            $('#oliTab_step3').css('left','105px');
            $('#oliTab_step4').css('left','0%');
            $('#ospRddWording1').hide();
            $('#ospRddWording2').show();
            $('#obtTabConditionRedeemHDGrp').show();

            $('#oliTab_step2').css('width','7%');
            $('#oliTab_step2 a').css('right','81%');
            $('#oliTab_step3').css('width','49%');
            $('#oliTab_step3').css('left','8%');
            $('#oliTab_step4').css('left','0px');
            $('#oliTab_step4').css('width','44%');
            $('#olbTab_step4').css('margin-left','82%');
            let active = $('.wizard .nav-tabs li.active');
            active.next().removeClass('disabled');
            JSxnextTab(active);
            //แก้ไข CSS ตุ่มวิซาร์ด - supawat
            $('#oliTab_step2 a, #oliTab_step3 a, #oliTab_step4 a').css('margin-top','-8px');

            $('#ospTab_step2').css( "background-color", "#000" );
            $('#ospTab_step3').css( "background-color", "#000" );
            $('#ospTab_step4').css( "background-color", "#fff" );

            $('#ospTab_step2').css('border', '2px solid #000');
            $('#ospTab_step3').css('border', '2px solid #000');
            $('#ospTab_step4').css('border', '2px solid #000');

            $('.xWPromotionLine').css( "border-bottom","2px solid transparent" );
            $('.xWPromotionLine').css( "border-image","linear-gradient(to right, black 100%, #d6d6d6 20% 40%)" );
            $('.xWPromotionLine').css( "border-image-slice","1" );
        }

        $('#ocmRDHDocType').attr('disabled',true);
    }
    
    $('#odvRDHBtnGrpAddEdit').show();
    
    // Remove Disable
    $("#obtRDHCancelDoc").attr("disabled",false);
    $("#obtRDHApproveDoc").attr("disabled",false);
    $("#obtRDHBrowseSupplier").attr("disabled",false);

    // Eneble Input 
    $('.xCNInputWhenStaCancelDoc:input').prop('readonly',false);
    $('#otbRDHDataDetailDT tbody td .xWCpdAlwMaxUse').prop('readonly',false);
    $('.xCNInputWhenStaCancelDoc:button').prop('disabled',false)
    $('#obtRDHAddCouponDT').removeClass('xCNBrowsePdtdisabled')
    
    // Status Cancel Docement
    if(nRDHStaDoc != 1){
        $('#obtRDHBackStepDoc').attr('disabled',true);
        $('#oliTab_step1').addClass('disabled')
        $('#oliTab_step2').addClass('disabled')
        $('#oliTab_step3').addClass('disabled')
        // Hide/Show Menu Title 
        $("#oliRDHTitleAdd").hide();
        $('#oliRDHTitleEdit').show();
        $('#oliRDHTitleDetail').show();
        $('#odvRDHBtnGrpSave').hide();
        // Disabled Button
        $("#obtRDHCancelDoc").hide();
        $("#obtRDHApproveDoc").hide();
        // Disable Input 
        $('.xCNInputWhenStaCancelDoc:input').prop('readonly',true);
        $('#otbRDHDataDetailDT tbody td .xWCpdAlwMaxUse').prop('readonly',true);

        $('.xCNInputWhenStaCancelDoc:button').prop('disabled',true)
        $('#obtRDHAddCouponDT').addClass('xCNBrowsePdtdisabled');
    
        $('#ostRDHFrmRDHDisType').css('pointer-events','none');
        $('#ostRDHFrmRDHDisType').selectpicker('destroy');
    }

    //สถานะยกเลิก
    if(nRDHStaDoc == 3){
        $('#oliRDHTitleEdit').hide();
    }

    // Check Status Appove Success
    if(nRDHStaDoc == 1 && nRDHStaApv == 1 && tRDHStaPrcDoc == 1){
        $('#obtRDHBackStepDoc').attr('disabled',true);
        $('#oliTab_step1').addClass('disabled')
        $('#oliTab_step2').addClass('disabled')
        $('#oliTab_step3').addClass('disabled')
        // Hide/Show Menu Title 
        $("#oliRDHTitleAdd").hide();
        $('#oliRDHTitleEdit').hide();
        $('#oliRDHTitleDetail').show();
        // Disabled Button
        $("#obtRDHCancelDoc").hide();
        $("#obtRDHApproveDoc").hide();
        $('#odvRDHBtnGrpSave').hide();
        // Disable Input 
        $('.xCNInputWhenStaCancelDoc:input').prop('readonly',true);
        $('#otbRDHDataDetailDT tbody td .xWCpdAlwMaxUse').prop('readonly',true);
        $('.xCNInputWhenStaCancelDoc:button').prop('disabled',true)
        $('#obtRDHAddCouponDT').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDBchInclude').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDBchExclude').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDCstPriInclude').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDCstPriExclude').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDPdtInclude').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDPdtExclude').addClass('xCNBrowsePdtdisabled');
        $('.xCNIconDel').addClass('xCNDocDisabled');
        $('.xCNIconDel').attr('onclick','');

        $('.xCNIconTable').addClass('xCNDocDisabled');
        $('.xCNIconTable').attr('onclick','');
        
        $('#ostRDHFrmRDHDisType').selectpicker('refresh');

        $('#ospTab_step1').css( "background-color", "#000" );
        $('#ospTab_step2').css( "background-color", "#000" );
        $('#ospTab_step3').css( "background-color", "#000" );
        $('#ospTab_step4').css( "background-color", "#fff" );

        $('#ospTab_step1').css('border', '2px solid #000');
        $('#ospTab_step2').css('border', '2px solid #000');
        $('#ospTab_step3').css('border', '2px solid #000');
        $('#ospTab_step4').css('border', '2px solid #000');

        $('.xWPromotionLine').css( "border-bottom","2px solid transparent" );
        $('.xWPromotionLine').css( "border-image","linear-gradient(to right, black 100%, #d6d6d6 20% 40%)" );
        $('.xWPromotionLine').css( "border-image-slice","1" );
    }
}

// Functionality: Set Status Appove Document
// Parameters: Event Click Save Document
// Creator: 26/12/2019 Saharat(Golf)
// LastUpdate: 27/12/2019 Wasin(Yoshi)
// Return: Set Status Submit By Button In Input Hidden
// ReturnType: None
function JSxRDHApproveDocument(pbIsConfirm){
    if(pbIsConfirm){
        $("#odvRDHModalAppoveDoc").modal("hide");
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        JCNxOpenLoading();
        var tDocumentNumber =  $('#oetRDHDocNo').val();
        var tBchCode        =  $('#ohdRDHUsrBchCode').val();
        $.ajax({
            type    : "POST",
            url     : "dcmRDHEvenApprove",
            data    : {tDocumentNumber : tDocumentNumber  , tBchCode : tBchCode},
            timeout: 0,
            success: function(oDataReturn){
                JSvRDHCallPageEditDocument(tDocumentNumber, tBchCode);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                (jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        $('#odvRDHModalAppoveDoc').modal({backdrop:'static',keyboard:false});
        $("#odvRDHModalAppoveDoc").modal("show");
    }
}

// Functionality: Set Status Cancel Document
// Parameters: Event Click Save Document
// Creator: 26/12/2019 Saharat(Golf)
// LastUpdate: 27/12/2019 Wasin(Yoshi)
// Return: Set Status Submit By Button In Input Hidden
// ReturnType: None
function JSxRDHCancelDocument(){
    JCNxOpenLoading();
    var tDocumentNumber =  $('#oetRDHDocNo').val();
    var tBchCode        =  $('#ohdRDHUsrBchCode').val();
    $.ajax({
        type    : "POST",
        url     : "dcmRDHEvenCancel",
        data    : {tDocumentNumber : tDocumentNumber  , tBchCode : tBchCode},
        timeout: 0,
        success: function(oDataReturn){
            JSvRDHCallPageEditDocument(tDocumentNumber, tBchCode);
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            (jqXHR, textStatus, errorThrown);
        }
    });
}

  /*
      * Functionality : Crete Array javascript
      * Parameters : 
      * Creator : 13/02/2020 nattakit(nale)
      * Last Modified : -
      * Return : -
      * Return Type : -
      */  

     function JSxCreateArray(length) {
        var arr = new Array(length || 0),
            i = length;
    
        if (arguments.length > 1) {
            var args = Array.prototype.slice.call(arguments, 1);
            while(i--) arr[length-1 - i] = JSxCreateArray.apply(this, args);
        }
    
        return arr;
    }




    
// Functionality: Add Product Into Table Document DT Temp
// Parameters: Function Ajax Success
// Creator: 01/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View
// ReturnType : View
function JCNvRDHBrowsePdt(){
if($('#ocmRDHCalType').val()==1){
    var ocmRDHCalType = $('#ocmRDHCalType').val();
}else{
    var ocmRDHCalType = '';
}
    // if(typeof(tRDHSplCode) !== undefined && tRDHSplCode !== ''){
        var aMulti = [];
        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                Qualitysearch   : [],
                PriceType       : ["Cost","tCN_Cost","Company","1"],
                // 'PriceType' : ['Pricesell'],
                // 'PriceType' : ['Price4Cst',tRDHPplCode],
                SelectTier      : ['PDT'],
                // SelectTier: ["Barcode"],
                //'Elementreturn'   : ['oetInputTestValue','oetInputTestName'],
                Filter:[""],
                ShowCountRecord: 10,
                NextFunc: "FSvRDHAddPdtIntoRedeemDTTemp",
                ReturnType: "M",
                DISTYPE: ocmRDHCalType,
               // SPL: [$("#oetRDHFrmSplCode").val(),$("#oetRDHFrmSplCode").val()],
                BCH: [$("#oetRDHBchCodeMulti").val(),''],
              //  MCH: [$("#oetRDHFrmMerCode").val(),$("#oetRDHFrmMerCode").val()],
                //SHP: [$("#oetRDHFrmShpCode").val(), $("#oetRDHFrmShpCode").val()],
               // NOTINITEM: [["00003","00004",'00033']]
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                $("#odvModalDOCPDT").modal({backdrop: "static", keyboard: false});
                $("#odvModalDOCPDT").modal({show: true});
                //remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                $("#odvModalsectionBodyPDT").html(tResult);
                $("#odvModalDOCPDT #oliBrowsePDTSupply").css('display','none');
            },
            error: function (jqXHR,textStatus,errorThrown){
                JCNxResponseError(jqXHR,textStatus,errorThrown);
            }
        });
    // }else{
    //     var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
    //     FSvCMNSetMsgWarningDialog(tWarningMessage);
    //     return;
    // }
}



function FSvRDHAddPdtIntoRedeemDTTemp(ptPdtData){
    var nStaSession = JCNxFuncChkSessionExpired();

    if (typeof nStaSession !== "undefined" && nStaSession == 1){
        JCNxOpenLoading();

 
        var ptXthDocNoSend  = "";
        if ($("#ohdRDHRouteEvent").val() == "dcmRDHEventEdit") {
            ptXthDocNoSend  = $("#oetRDHDocNo").val();
        }
        var tRDHUsrBchCode    = $('#ohdRDHUsrBchCode').val();

        if($('#ohdRDHModalType').val()==2){
        var tRDDGrpName       = $('#oetRDDGrpName').val();
        }else{
        var tRDDGrpName       = '';
        }

        var nRDDStaType       = $('#ocmRDDStaType').val();
        $.ajax({
            type: "POST",
            url: "dcmRDHAddPdtIntoDTDocTemp",
            data: {
                'tRDHDocNo'          : ptXthDocNoSend,
                'tBchCode'           : tRDHUsrBchCode,
                'tRDHPdtData'        : ptPdtData,
                'tRDDGrpName'        : tRDDGrpName,
                'nRDDStaType'        : nRDDStaType
            },
            cache: false,
            timeout: 0,
            success: function (oResult){

                var aDataReturn = JSON.parse(oResult);
                if(aDataReturn['nStaEvent'] == '1'){
                    JSvRDHLoadPdtDataTableHtml();
                }else{
                    FSvCMNSetMsgErrorDialog(aDataReturn['tStaMessg']);
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


function JSvSOLoadPdtDataTableHtml(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        if($("#ohdSORoute").val() == "dcmSOEventAdd"){
            var tRDHDocNo    = "";
        }else{
            var tRDHDocNo    = $("#oetRDHDocNo").val();
        }

        var tRDHStaApv       = $("#ohdSOStaApv").val();
        var tRDHStaDoc       = $("#ohdSOStaDoc").val();
        var tRDHVATInOrEx    = $("#ocmSOFrmSplInfoVatInOrEx").val();
        
        //เช็ค สินค้าใน table หน้านั้นๆ หรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
        if ($("#otbSODocPdtAdvTableList .xWPdtItem").length == 0){
            if (pnPage != undefined) {
                pnPage = pnPage - 1;
            }
        }

        if(pnPage == '' || pnPage == null){
            var pnNewPage = 1;
        }else{
            var pnNewPage = pnPage;
        }
        var nPageCurrent = pnNewPage;
        var tSearchPdtAdvTable  = $('#oetRDHFrmFilterPdtHTML').val();




        if(tRDHStaApv==2){
            $('#obtRDHDocBrowsePdt').hide();
            $('#obtRDHPrintDoc').hide();
            $('#obtRDHCancelDoc').hide();
            $('#obtRDHApproveDoc').hide();
            $('#odvSOBtnGrpSave').hide();
         }

        $.ajax({
            type: "POST",
            url: "dcmRDHPdtAdvanceTableLoadData",
            data: {
                'ptSearchPdtAdvTable'   : tSearchPdtAdvTable,
                'ptRDHDocNo'             : tRDHDocNo,
                'ptRDHStaApv'            : tRDHStaApv,
                'ptRDHStaDoc'            : tRDHStaDoc,
                'ptRDHVATInOrEx'         : tRDHVATInOrEx,
                'pnSOPageCurrent'       : nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1') {
                    $('#odvSODataPanelDetailPDT #odvSODataPdtTableDTTemp').html(aReturnData['tRDHPdtAdvTableHtml']);
                    var aSOEndOfBill    = aReturnData['aSOEndOfBill'];
                    JSxSOSetFooterEndOfBill(aSOEndOfBill);
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

// $(".next-step").click(function (e) {

//     var nTab = $('#ohdRDHNowTab').val();
//     var nRedeemType = $('#ocmRDHDocType').val();
//     if(nTab==1 && nRedeemType==1){
//        var nRddGroupNameInput = $('input[name^="ohdRddGroupNameInput"]').length;
   
//         if(nRddGroupNameInput==0){
//            let tMsgAlertvalidateGrpNamePdt = $('#ohdRDHValidatePromotionRedeem').attr('validateGrpNamePdt');
//             alert(tMsgAlertvalidateGrpNamePdt);
//             return false;
//         }

//         $('#ocmRDHDocType').attr('disabled',true);
//         $('#obtTabConditionRedeemHDGrp').hide();
//         $('.othColumDelete').hide();
//         if($('#ohdRDHRouteEvent').val()=='dcmRDHEventAdd'){
//          JSxRDHGenGroupForHtmlTab2();
//         }

//     }

//     if(nTab==2 && nRedeemType==2){
//         $('#ocmRDHDocType').attr('disabled',true);
//     }

//     if(nTab==2){
//        let nRdcRefCode = $('input[name^="oetRdcRefCode"]').length;

//        if(nRdcRefCode==0){
//         let tMsgAlertvalidateGrpCondition = $('#ohdRDHValidatePromotionRedeem').attr('validateGrpCondition');
//         alert(tMsgAlertvalidateGrpCondition);
//         return false;
//        }
       
//         let nCheckRefCode = 0 ;
//         let nCheckUsePointCode = 0 ;
//         let nCheckUseMny = 0 ;
//         let nCheckRdcMinTotBill = 0 ;
//         let nDuplicateRefCode = 0 ;  
//         let nNumberData = 0;
//         if($('#ocbRddStaAutoGenCode').prop('checked')==false){
//                  $('input[name^="oetRdcRefCode"]').each(function(){
                 
//                     if($(this).val()==''){
//                         nCheckRefCode++;
//                     }{
//                      let nNumberDataSub = 0;
//                        let tRefCode = $(this).val();
//                         $('input[name^="oetRdcRefCode"]').each(function(){
//                             let tRefCodeSub = $(this).val();
//                             if(tRefCodeSub==tRefCode && nNumberData!=nNumberDataSub ){
//                                 nDuplicateRefCode++;
//                             }

//                             nNumberDataSub++;
//                         });

//                     }

//                     nNumberData++;
                    
//                 });


             
//         }
//         $('input[name^="oetRdcUsePoint"]').each(function(){
//             if($(this).val()==''){
//                 nCheckUsePointCode++;
//             }
//         });
//         $('input[name^="oetRdcUseMny"]').each(function(){
//             if($(this).val()==''){
//                 nCheckUseMny++;
//             }
//         });
//         $('input[name^="oetRdcMinTotBill"]').each(function(){
//             if($(this).val()==''){
//                 nCheckRdcMinTotBill++;
//             }
//         });
        
//         if(nCheckRefCode>0){
//             let tMsgAlertvalidateRdhRefCode = $('#ohdRDHValidatePromotionRedeem').attr('validateRdhRefCode');
//             alert(tMsgAlertvalidateRdhRefCode);
//             return false;
//         }
//         if(nCheckUsePointCode>0){
//             let tMsgAlertvalidateRdhUsePoint = $('#ohdRDHValidatePromotionRedeem').attr('validateRdhUsePoint');
//             alert(tMsgAlertvalidateRdhUsePoint);
//             return false;
//         }
//         if(nCheckUseMny>0){
//             let tMsgAlertvalidateRdhMoney = $('#ohdRDHValidatePromotionRedeem').attr('validateRdhMoney');
//             alert(tMsgAlertvalidateRdhMoney);
//             return false;
//         }
//         if(nCheckRdcMinTotBill>0){
//             let tMsgAlertvalidateRdhLimitBill = $('#ohdRDHValidatePromotionRedeem').attr('validateRdhLimitBill');
//             alert(tMsgAlertvalidateRdhLimitBill);
//             return false;
//         }

//         if(nDuplicateRefCode>0){
//             alert('Ref Code Dupclicate');
//             return false;  
//         }

//     }



//     let active = $('.wizard .nav-tabs li.active');
//     active.next().removeClass('disabled');
//     JSxnextTab(active);

// });
// $(".prev-step").click(function (e) {

//     var $active = $('.wizard .nav-tabs li.active');

//     JSxPrevTab($active);

// });

// function JSxnextTab(elem) {
//     $(elem).next().find('a[data-toggle="tab"]').click();
// }
// function JSxPrevTab(elem) {
//     $(elem).prev().find('a[data-toggle="tab"]').click();
// }


function JSxRDHGenGroupForHtmlTab2(){
    var tMarkUp = '';
   
    $('input[name^="ohdRddGroupNameInput"]').each(function(index){
       let nRddgroupstatype = $(this).attr('ohdrddgroupstatype');

            if(nRddgroupstatype==1){
           
                    let tGroupName =  $(this).val();
                    // var tCheckNameDup = 0;
                    // $('.textGroupName').each(function(){
                    //             if(tGroupName==$(this).text()){
                    //                 tCheckNameDup++;
                    //             }
                    // });

                    // if(tCheckNameDup==0){
                    tMarkUp += "<tr class='otrConditionRedeemCDGROUP' id='otrGrpRowID_"+index+"'>";
                    tMarkUp += "<td class='hideGrpNameColum textGroupName' id='textGroupSeq_"+tGroupName+"' >"+tGroupName+"</td>";
                    tMarkUp += "<td><input type='text' class='form-control' name='oetRdcRefCode[]' readonly ></td>";
                    tMarkUp += "<td><input type='text' class='form-control xCNInputNumericWithDecimal  text-right'  name='oetRdcUsePoint[]' value='0' ></td>";
                    tMarkUp += "<td><input type='text' class='form-control xCNInputNumericWithDecimal xCNInputMaskCurrencyRdh  text-right'  name='oetRdcUseMny[]'  value='0.00' ></td>";
                    tMarkUp += "<td><input type='text' class='form-control xCNInputNumericWithDecimal xCNInputMaskCurrencyRdh  text-right'  name='oetRdcMinTotBill[]' value='0.00' ></td>";
                    // tMarkUp += "<td align='center'><img class='xCNIconTable' src='application/modules/common/assets/images/icons/delete.png' title='Remove' onclick='JSxRDHDelGroupCondition(\""+index+"\")'></td>";
                    tMarkUp += "</tr>";
                    // }
                }

                });

                $('#otbConditionRedeemHDGrp').html(tMarkUp);

                $('.xCNInputMaskCurrencyRdh').on("blur", function() {
                    var tInputVal = $(this).val();
                    tInputVal += '';
                    tInputVal = tInputVal.replace(',', '');
                    tInputVal = tInputVal.split('.');
                    tValCurency = tInputVal[0];
                    tDegitInput = tInputVal.length > 1 ? '.' + tInputVal[1] : '';
                    var tCharecterComma = /(\d+)(\d{3})/;
                    while (tCharecterComma.test(tValCurency))
                        tValCurency = tValCurency.replace(tCharecterComma, '$1' + ',' + '$2');
                    var tInputReplaceComma = tValCurency + tDegitInput;
                    var tSearch = ".";
                    var tStrinreplace = ".00";
                    var tInputCommaDegit = ""
                    if (tInputReplaceComma.indexOf(tSearch) == -1 && tInputReplaceComma != "") {
                        tInputCommaDegit = tInputReplaceComma.concat(tStrinreplace);
                    } else {
                        tInputCommaDegit = tInputReplaceComma;
                    }
                    $(this).val(tInputCommaDegit);
                });

        
}


function JSxRdhAddRowOnPageEdit(paData){

    // if(paData.tGrpCode!=paData.tGrpName){
        // $('#textGroupSeq_'+paData.tGrpCode).text(paData.tGrpName);
    // }
    // var tCheckNameDup = 0;
    // $('.textGroupName').each(function(){
    //             if(paData.tGrpName==$(this).text()){
    //                 tCheckNameDup++;
    //             }
    // });

    // if(tCheckNameDup==0){
    var tMarkUp = '';
        let nIndex = ($('input[name^="ohdRddGroupNameInput"]').length)+1;
        tMarkUp += "<tr class='otrConditionRedeemCDGROUP' id='otrGrpRowID_"+nIndex+"'>";
        tMarkUp += "<td class='hideGrpNameColum textGroupName' id='textGroupSeq_"+paData.tGrpCode+"' >"+paData.tGrpName+"</td>";
        if($('#ocbRddStaAutoGenCode').prop('checked')==true){
        tMarkUp += "<td><input type='text' class='form-control' name='oetRdcRefCode[]' readonly ></td>";
        }else{
        tMarkUp += "<td><input type='text' class='form-control' name='oetRdcRefCode[]'  ></td>";  
        }
        tMarkUp += "<td><input type='text' class='form-control xCNInputNumericWithDecimal  text-right'  name='oetRdcUsePoint[]' value='0' ></td>";
        tMarkUp += "<td><input type='text' class='form-control xCNInputNumericWithDecimal xCNInputMaskCurrencyRdh  text-right'  name='oetRdcUseMny[]'  value='0.00' ></td>";
        tMarkUp += "<td><input type='text' class='form-control xCNInputNumericWithDecimal xCNInputMaskCurrencyRdh  text-right'  name='oetRdcMinTotBill[]' value='0.00' ></td>";
        // tMarkUp += "<td align='center'><img class='xCNIconTable' src='application/modules/common/assets/images/icons/delete.png' title='Remove' onclick='JSxRDHDelGroupCondition(\""+nIndex+"\")'></td>";
        tMarkUp += "</tr>";

    $('#otbConditionRedeemHDGrp').append(tMarkUp);
    $('.xCNInputMaskCurrencyRdh').on("blur", function() {
        var tInputVal = $(this).val();
        tInputVal += '';
        tInputVal = tInputVal.replace(',', '');
        tInputVal = tInputVal.split('.');
        tValCurency = tInputVal[0];
        tDegitInput = tInputVal.length > 1 ? '.' + tInputVal[1] : '';
        var tCharecterComma = /(\d+)(\d{3})/;
        while (tCharecterComma.test(tValCurency))
            tValCurency = tValCurency.replace(tCharecterComma, '$1' + ',' + '$2');
        var tInputReplaceComma = tValCurency + tDegitInput;
        var tSearch = ".";
        var tStrinreplace = ".00";
        var tInputCommaDegit = ""
        if (tInputReplaceComma.indexOf(tSearch) == -1 && tInputReplaceComma != "") {
            tInputCommaDegit = tInputReplaceComma.concat(tStrinreplace);
        } else {
            tInputCommaDegit = tInputReplaceComma;
        }
        $(this).val(tInputCommaDegit);
    });

    // }

}

function JSxRDHDelGroupCondition(pnRow){
    if(confirm('คุณแน่ใจที่จะลบกลุ่มนี้ออกจากเงื่อนไขแลกแต้ม')==true){
         $('#otrGrpRowID_'+pnRow).remove();
    }
}




function JSxRDHGenGroupAddRowHtml(){

    var tMarkUp = '';
        let nIndex = $('input[name^="oetRdcRefCode"]').length;
        tMarkUp += "<tr class='otrConditionRedeemCDGROUP' id='otrGrpRowID_"+nIndex+"'>";
        if($('#ocbRddStaAutoGenCode').prop('checked')==true){
        tMarkUp += "<td><input type='text' class='form-control' name='oetRdcRefCode[]' readonly ></td>";
        }else{
        tMarkUp += "<td><input type='text' class='form-control' name='oetRdcRefCode[]'  ></td>";  
        }
        tMarkUp += "<td><input type='text' class='form-control xCNInputNumericWithDecimal  text-right'  name='oetRdcUsePoint[]' value='0' ></td>";
        tMarkUp += "<td><input type='text' class='form-control xCNInputNumericWithDecimal xCNInputMaskCurrencyRdh  text-right'  name='oetRdcUseMny[]'  value='0.00' ></td>";
        tMarkUp += "<td><input type='text' class='form-control xCNInputNumericWithDecimal xCNInputMaskCurrencyRdh  text-right'  name='oetRdcMinTotBill[]' value='0.00' ></td>";
        tMarkUp += "<td align='center'><img class='xCNIconTable' src='application/modules/common/assets/images/icons/delete.png' title='Remove' onclick='JSxRDHDelGroupCondition(\""+nIndex+"\")'></td>";
        tMarkUp += "</tr>";

    $('#otbConditionRedeemHDGrp').append(tMarkUp);
    $('.xCNInputMaskCurrencyRdh').on("blur", function() {
        var tInputVal = $(this).val();
        tInputVal += '';
        tInputVal = tInputVal.replace(',', '');
        tInputVal = tInputVal.split('.');
        tValCurency = tInputVal[0];
        tDegitInput = tInputVal.length > 1 ? '.' + tInputVal[1] : '';
        var tCharecterComma = /(\d+)(\d{3})/;
        while (tCharecterComma.test(tValCurency))
            tValCurency = tValCurency.replace(tCharecterComma, '$1' + ',' + '$2');
        var tInputReplaceComma = tValCurency + tDegitInput;
        var tSearch = ".";
        var tStrinreplace = ".00";
        var tInputCommaDegit = ""
        if (tInputReplaceComma.indexOf(tSearch) == -1 && tInputReplaceComma != "") {
            tInputCommaDegit = tInputReplaceComma.concat(tStrinreplace);
        } else {
            tInputCommaDegit = tInputReplaceComma;
        }
        $(this).val(tInputCommaDegit);
    });

}



///-----------------------------------------------------------------------------------------------------///

//Next page
function JSvRDHPDTDocDTTempClickPage(ptPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWPagePIPdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWPagePIPdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JCNxOpenLoading();
        JSvRDHLoadPdtDataTableHtml(nPageCurrent);
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSnRDHDelPdtInDTTempSingle(pnSeq,ptSesionID){

    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        if($("#ohdSORoute").val() == "dcmSOEventAdd"){
            var tRDHDocNo    = "";
        }else{
            var tRDHDocNo    = $("#oetRDHDocNo").val();
        }
        var tRDHStaApv       = $("#ohdSOStaApv").val();
        var tRDDGrpName       = $("#oetRDDGrpName").val();
        var tRDHStaDoc       = $("#ohdSOStaDoc").val();
        var tRDHUsrBchCode    = $("#ohdRDHUsrBchCode").val();
     if(confirm('คุณแน่ใจที่จะลบสินค้านี้ออกจากกลุ่ม '+tRDDGrpName)==true){

        $.ajax({
            type: "POST",
            url: "dcmRDHPdtAdvanceTableDeleteSingle",
            data: {
                'tRDHDocNo'   : tRDHDocNo,
                'nRddSeq'     : pnSeq,
                'tSessionID'  : ptSesionID,
                'tBchCode'    :tRDHUsrBchCode
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1') {
                    JSvRDHLoadPdtDataTableHtml();
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


function JSxRDHSaveGrpNameDTTemp(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1){
      
        var ptXthDocNoSend  = "";
        if ($("#ohdRDHRouteEvent").val() == "dcmRDHEventEdit") {
            ptXthDocNoSend  = $("#oetRDHDocNo").val();
        }
        var tRDHUsrBchCode    = $('#ohdRDHUsrBchCode').val();
        var tRDDGrpName       = $('#oetRDDGrpName').val();
        var tRDDGrpCode       = $('#oetRDDGrpCode').val();
        var nRDDStaType       = $('#ocmRDDStaType').val();

        if(tRDDGrpName!=""){
            JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmRDHSaveGrpNameDTTemp",
                    data: {
                        'tRDHDocNo'          : ptXthDocNoSend,
                        'tBchCode'           : tRDHUsrBchCode,
                        'tRDDGrpName'        : tRDDGrpName,
                        'tRDDGrpCode'        : tRDDGrpCode,
                        'nRDDStaType'        : nRDDStaType
                    },
                    cache: false,
                    timeout: 0,
                    success: function (oResult){

                        var aDataReturn = JSON.parse(oResult);
                        if(aDataReturn['nStaEvent'] == '1'){
                            JSvRDHLoadGroupListTable();
                                if(nRDDStaType==1){
                                    let aSetData = { tGrpCode:tRDDGrpCode,tGrpName:tRDDGrpName }
                                    JSxRdhAddRowOnPageEdit(aSetData);
                                }else{
                                    JSxRDHRemoveGrupInStep2(tRDDGrpName);
                                }
                        }else{
                            FSvCMNSetMsgErrorDialog(aDataReturn['tStaMessg']);
                        }
                    
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

        }else{

            FSvCMNSetMsgErrorDialog('Please Select Group Name.');
            
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}



function JSxRDHSaveGrpNameDTTemp(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1){
      
        var ptXthDocNoSend  = "";
        if ($("#ohdRDHRouteEvent").val() == "dcmRDHEventEdit") {
            ptXthDocNoSend  = $("#oetRDHDocNo").val();
        }
        var tRDHUsrBchCode    = $('#ohdRDHUsrBchCode').val();
        var tRDDGrpName       = $('#oetRDDGrpName').val();
        var tRDDGrpCode       = $('#oetRDDGrpCode').val();
        var nRDDStaType       = $('#ocmRDDStaType').val();

        if(tRDDGrpName!=""){
            JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmRDHSaveGrpNameDTTemp",
                    data: {
                        'tRDHDocNo'          : ptXthDocNoSend,
                        'tBchCode'           : tRDHUsrBchCode,
                        'tRDDGrpName'        : tRDDGrpName,
                        'tRDDGrpCode'        : tRDDGrpCode,
                        'nRDDStaType'        : nRDDStaType
                    },
                    cache: false,
                    timeout: 0,
                    success: function (oResult){

                        var aDataReturn = JSON.parse(oResult);
                        if(aDataReturn['nStaEvent'] == '1'){
                            JSvRDHLoadGroupListTable();
                                if(nRDDStaType==1){
                                    let aSetData = { tGrpCode:tRDDGrpCode,tGrpName:tRDDGrpName }
                                    JSxRdhAddRowOnPageEdit(aSetData);
                                }else{
                                    JSxRDHRemoveGrupInStep2(tRDDGrpName);
                                }
                        }else{
                            FSvCMNSetMsgErrorDialog(aDataReturn['tStaMessg']);
                        }
                    
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

        }else{

            FSvCMNSetMsgErrorDialog('Please Select Group Name.');
            
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

function JSvRDHLoadGroupListTable(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        if($("#ohdSORoute").val() == "dcmSOEventAdd"){
            var tRDHDocNo    = "";
        }else{
            var tRDHDocNo    = $("#oetRDHDocNo").val();
        }
        var tRDHStaApv       = $("#ohdSOStaApv").val();
        var tRDHStaDoc       = $("#ohdSOStaDoc").val();
        var tRDHUsrBchCode    = $("#ohdRDHUsrBchCode").val();
      

        $.ajax({
            type: "POST",
            url: "dcmRDHGetGrpDTTemp",
            data: {
                'tRDHDocNo'   : tRDHDocNo,
                'tBchCode'    :tRDHUsrBchCode
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1') {
                    JSvRDHLoadGropRedeemHtml(aReturnData['titem']['rtitem']);
                    JSxRddPdtGroupCreate();
                    $('#odvRDHConditionRedeemHDPdt').modal('hide');
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


function JSvRDHLoadGropRedeemHtml(paData){
    // aData = JSON.parse(paData);
    // console.log(paData[0]['FTRddGrpName']);
    var nRDHStaApv = $('#ohdRDHStaApv').val();
    var tMarkUp = '';
    let nRow = 1;
    if(paData.length>0){
        for(i=0;i<paData.length;i++){
            // console.log(aData[i]);
            tMarkUp +=  "<tr>";
            tMarkUp +=  "<td align='center'>"+nRow+"</td>";
            tMarkUp +=  "<td>"+paData[i]['FTRddGrpName']+"<input type='hidden' ohdRddGroupStaType='"+paData[i]['FTRddStaType']+"' name='ohdRddGroupNameInput[] 'id='ohdRddGroupNameInput"+nRow+"' value='"+paData[i]['FTRddGrpName']+"'  ></td>";
            tMarkUp += "<td align='center'>";
            if(nRDHStaApv!=1){
            tMarkUp += " <img class='xCNIconTable' src='application/modules/common/assets/images/icons/delete.png' title='Remove' onclick='JSnRDHDelGroupInDTTemp(\""+paData[i]['FTRddGrpCode']+"\",\""+paData[i]['FTRddGrpName']+"\")'>";
            }
            tMarkUp += " </td>";
            tMarkUp += "<td align='center'>";
            // if(nRDHStaApv!=1){
            tMarkUp += "<img class='xCNIconTable' src='application/modules/common/assets/images/icons/edit.png' title='Edit' onclick='JSnRDHEditGroupInDTTempSingle(\""+paData[i]['FTRddGrpCode']+"\",\""+paData[i]['FTRddGrpName']+"\",\""+paData[i]['FTRddStaType']+"\")'>"
            //  }
            tMarkUp +="</td>";
            tMarkUp += "</tr>";
            nRow++;
        }
    }else{
        tMarkUp +=  "<tr>";
        tMarkUp +=  "<td align='center'  colspan='4' class='center'>ไม่พบข้อมูล</td>";
        tMarkUp += "</tr>";
    }
      
       $('#otbConditionRedeemHDPdtInclude').html(tMarkUp);
}


function JSnRDHEditGroupInDTTempSingle(ptgrpCode,ptgrpName,pngrpType){

    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
            $('#oetRDDGrpName').val(ptgrpName);
            $('#oetRDDGrpCode').val(ptgrpCode);
            $('#ocmRDDStaType').val(pngrpType).change();
            $('#ohdRDHModalType').val(2);
            JSxRDHSETPdtCeatedOnGroup(ptgrpCode);
    }else{
        JCNxShowMsgSessionExpired();
    }

}



function JSxRDHSETPdtCeatedOnGroup(ptgrpCode){

    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        if($("#ohdSORoute").val() == "dcmSOEventAdd"){
            var tRDHDocNo    = "";
        }else{
            var tRDHDocNo    = $("#oetRDHDocNo").val();
        }

        var tRDHUsrBchCode    = $('#ohdRDHUsrBchCode').val();
        $.ajax({
            type: "POST",
            url: "dcmRDHSetPdtGrpDTTemp",
            data: {
                'tRDHDocNo'   : tRDHDocNo,
                'tBchCode'    : tRDHUsrBchCode,
                'tGrpCode'    : ptgrpCode
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1') {
                    JSvRDHLoadPdtDataTableHtml();
                    $("#odvRDHConditionRedeemHDPdt").modal({backdrop: "static", keyboard: false});
                    $("#odvRDHConditionRedeemHDPdt").modal({show: true});
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


function JSnRDHDelGroupInDTTemp(ptgrpCode,ptgrpName){

    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        if($("#ohdSORoute").val() == "dcmSOEventAdd"){
            var tRDHDocNo    = "";
        }else{
            var tRDHDocNo    = $("#oetRDHDocNo").val();
        }

        var tRDHUsrBchCode    = $('#ohdRDHUsrBchCode').val();
        $.ajax({
            type: "POST",
            url: "dcmRDHDelGroupInDTTemp",
            data: {
                'tRDHDocNo'   : tRDHDocNo,
                'tBchCode'    : tRDHUsrBchCode,
                'tGrpCode'    : ptgrpCode
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1') {
                    JSvRDHLoadGroupListTable();
                    JSxRDHRemoveGrupInStep2(ptgrpName);
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



function JSxRDHRemoveGrupInStep2(ptGrpName){

    $('.textGroupName').each(function(){
       let tGetTextName =  $(this).text();
       if(tGetTextName==ptGrpName){
        $(this).parent().remove();
       }
    });
}

// Functionality : Function Check Data Search And Add In Tabel DT Temp
// Parameters : Event Click Buttom
// Creator : 02/03/2019 Nattakit(Nale)
// LastUpdate: -
// Return : 
// Return Type : Filter
function JSvRDHClickPageList(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld    = $('.xWRDHPageDataTable .active').text(); // Get เลขก่อนหน้า
            nPageNew    = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld    = $('.xWRDHPageDataTable .active').text(); // Get เลขก่อนหน้า
            nPageNew    = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvRDHCallPageDataTable(nPageCurrent);
}