var nCPHStaBrowseType   = $("#oetCPHStaBrowseType").val();
var tCPHCallBackOption  = $("#oetCPHCallBackOption").val();

$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    if(typeof(nCPHStaBrowseType) != 'undefined' && nCPHStaBrowseType == 0){
        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliCPHTitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvCPHCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtCPHCallPageAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvCPHCallPageAddDocument();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Call Back Page
        $('#obtCPHCallBackPage').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvCPHCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From Document
        $('#obtCPHSubmitFromDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                let nValueBchInc = JSnCPhCheckBchInc();
                if($('#ohdCPHSesUsrBchCount').val()==0){  //ถ้าเห็น HQ ไม่ต้องเช็ค
                    nValueBchInc = 1;
                }
                if(nValueBchInc>0){
                    let nDupData = JSnCPHCheckDupCoupon();
                    if(nDupData==0){
                        $tRoute  = $('#ohdCPHRouteEvent').val();
                        JSxCPHAddEditDocument($tRoute);
                    }else{
                        FSvCMNSetMsgErrorDialog('Coupon Duplicate');
                        // alert('Coupon Duplicate');
                    }
                }else{
                    $('#oetCPHBchCodeTo').val('');
                    $('#oetCPHBchNameTo').val('');
                    $('#oetCPHMerCodeTo').val('');
                    $('#oetCPHMerNameTo').val('');
                    $('#oetCPHShpCodeTo').val('');
                    $('#oetCPHShpNameTo').val('');
                    $('#ohdCPHcouponModalTypeInclude').val(1);
                    $("#odvCPHCouponHDBch").modal({backdrop: "static", keyboard: false});
                    $("#odvCPHCouponHDBch").modal({show: true});
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Cancel Document
        $('#obtCPHCancelDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCPHCancelDocument();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Appove Document
        $('#obtCPHApproveDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCPHApproveDocument(false);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });



        JSxCPHNavDefultDocument();
        JSvCPHCallPageList();
    }
});


function JSnCPhCheckBchInc(){
    var nCountValue = 0;
    if($('#ohdbUsrIsAgnLevel').val()=='1'){
    $('.ohdCPHCouponIncludeAgnCode').each(function(){
            if($(this).val()!=''){
                nCountValue++;
            }
    });
    $('.ohdCPHCouponExcludeAgnCode').each(function(){
        if($(this).val()!=''){
            nCountValue++;
        }
});
    }else{
        $('.ohdCPHCouponIncludeBchCode').each(function(){
            if($(this).val()!=''){
                nCountValue++;
            }
    });
    $('.ohdCPHCouponExcludeBchCode').each(function(){
        if($(this).val()!=''){
            nCountValue++;
        }
});

    }
    return nCountValue;
}
// Function: CheckDupCouponCode
// Parameters: Document Ready Or Parameter Event
// Creator: 26/03/2020 (nale)
// Return: Set Default Nav Menu Document
// ReturnType: -
function JSnCPHCheckDupCoupon(){
    let nCounDup = 0;
    let nSeqX = 1;
    $('.xWCPHDataDetailItems').each(function(){
            let tCodeX = $(this).data('cpdbarcpn');
            let nSeqY = 1;
            $('.xWCPHDataDetailItems').each(function(){
                let tCodeY = $(this).data('cpdbarcpn');

                    if(tCodeX==tCodeY && nSeqX!=nSeqY){
                        console.log(tCodeX+'='+tCodeY);
                        nCounDup++;
                    }
                    nSeqY++;
            });
            nSeqX++
    });
    return nCounDup;
}
// Function: Set Defult Nav Menu Document
// Parameters: Document Ready Or Parameter Event
// Creator: 23/12/2019 Wasin(Yoshi)
// Return: Set Default Nav Menu Document
// ReturnType: -
function JSxCPHNavDefultDocument(){
    if(typeof(nCPHStaBrowseType) != 'undefined' && nCPHStaBrowseType == 0) {
        // Title Label Hide/Show
        $('#oliCPHTitleAdd').hide();
        $('#oliCPHTitleEdit').hide();
        $('#oliCPHTitleDetail').hide();
        $("#obtCPHApproveDoc").hide();
        $("#obtCPHCancelDoc").hide();
        $('#obtCPHPrint').hide();
        // Button Hide/Show
        $('#odvCPHBtnGrpAddEdit').hide();
        $('#odvCPHBtnGrpInfo').show();
        $('#obtCPHCallPageAdd').show();
    }else{
        $('#odvModalBody #odvCPHMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliCPHNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvCPHBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNCPHBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNCPHBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 23/12/2019 Wasin(Yoshi)
// Return: Call View Tranfer Out List
// ReturnType: View
function JSvCPHCallPageList(){
    $.ajax({
        type: "GET",
        url: "dcmCouponSetupFormSearchList",
        cache: false,
        timeout: 0,
        success: function (tResult){
            $("#odvCPHContentPageDocument").html(tResult);
            JSxCPHNavDefultDocument();
            JSvCPHCallPageDataTable();
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
function JSoCPHGetAdvanceSearchData(){
    var oAdvanceSearchData  = {
        tSearchAll          : $("#oetCPHSearchAllDocument").val(),
        tSearchBchCodeFrom  : $("#oetCPHAdvSearchBchCodeFrom").val(),
        tSearchBchCodeTo    : $("#oetCPHAdvSearchBchCodeTo").val(),
        tSearchDocDateFrom  : $("#oetCPHAdvSearcDocDateFrom").val(),
        tSearchDocDateTo    : $("#oetCPHAdvSearcDocDateTo").val(),
        tSearchStaDoc       : $("#ocmCPHAdvSearchStaDoc").val(),
        tSearchStaApprove   : $("#ocmCPHAdvSearchStaApprove").val(),
        // tSearchStaPrcStk    : $("#ocmCPHAdvSearchStaPrcStk").val()
    };
    return oAdvanceSearchData;
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 23/12/2019 Wasin(Yoshi)
// Return: Call View Tabel Data List Document
// ReturnType: View
function JSvCPHCallPageDataTable(pnPage){
    JCNxOpenLoading();
    let oAdvanceSearch  = JSoCPHGetAdvanceSearchData();
    let nPageCurrent    = pnPage;
    if(typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type: "POST",
        url: "dcmCouponSetupGetDataTable",
        data: {
            oAdvanceSearch  : oAdvanceSearch,
            nPageCurrent    : nPageCurrent,
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxCPHNavDefultDocument();
                $('#ostCPHDataTableDocument').html(aReturnData['tCPHViewDataTableList']);
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
function JSvCPHCallPageAddDocument(){
    JCNxOpenLoading();
    $.ajax({
        type    : "POST",
        url     : "dcmCouponSetupPageAdd",
        cache   : false,
        timeout : 0,
        success : function (oResult) {
            var aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1') {
                if(nCPHStaBrowseType == '1'){
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tCPHViewPageAdd']);
                }else{
                    // Hide Title Menu And Button
                    $('#oliCPHTitleEdit').hide();
                    $('#oliCPHTitleDetail').hide();
                    $("#obtCPHApproveDoc").hide();
                    $("#obtCPHCancelDoc").hide();
                    $('#obtCPHPrint').hide();
                    $('#odvCPHBtnGrpInfo').hide();
                    // Show Title Menu And Button
                    $('#oliCPHTitleAdd').show();
                    $('#odvCPHBtnGrpSave').show();
                    $('#odvCPHBtnGrpAddEdit').show();
                    // Remove Disable Button Add
                    $(".xWBtnGrpSaveLeft").attr("disabled",false);
                    $(".xWBtnGrpSaveRight").attr("disabled",false);
                    $('#odvCPHContentPageDocument').html(aReturnData['tCPHViewPageAdd']);
                }
                JSvCPHLoadPdtDataTableHtml();

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
function JSvCPHLoadPdtDataTableHtml(pnPage){
    if($("#ohdCPHRouteEvent").val() == "dcmCouponSetupEventAdd"){
        var tCPHDocNo   = "";
    }else{
        var tCPHDocNo   = $("#oetCPHDocNo").val();
    }
    if(pnPage == '' || pnPage == null){
        var pnNewPage   = 1;
    }else{
        var pnNewPage   = pnPage;
    }
    var nCPHPageCurrent     = pnNewPage;
    var tCPHSearchDataDT    = $('#oetCPHSearchDataDT').val();
    var tCPHStaDoc           = $("#ohdCPHStaDoc").val();
    var tCPHStaApv           = $("#ohdCPHStaApv").val();


    $.ajax({
        type: "POST",
        url: "dcmCouponSetupPageDetailDT",
        data: {
            'pnCPHPageCurrent'  : nCPHPageCurrent,
            'ptCPHSearchDataDT' : tCPHSearchDataDT,
            'ptCPHDocNo'        : tCPHDocNo,
            'ptCPHStaDoc'       : tCPHStaDoc,
            'ptCPHStaApv'       : tCPHStaApv,
        },
        cache: false,
        Timeout: 0,
        success: function (oResult){
            let aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1') {
                $('#ofmCouponSetupAddEditForm #odvCPHDataPanelDetail #odvCPHDataDetailDT').html(aReturnData['tCPHViewPageDetailDT']);
                setTimeout(function(){
                    JSxCPHControlObjAndBtn();
                    JCNxLayoutControll();
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

// Function: Event Single Delete Document Single
// Parameters: Function Call Page
// Creator: 25/12/2019 Wasin(Yoshi)
// Return: object Data Sta Delete
// ReturnType: object
function JSoCPHDelDocSingle(ptCurrentPage, ptCPHDocNo){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        if(typeof(ptCPHDocNo) != undefined && ptCPHDocNo != ""){
            var tTextConfrimDelSingle   = $('#oetTextComfirmDeleteSingle').val()+"&nbsp"+ptCPHDocNo+"&nbsp"+$('#oetTextComfirmDeleteYesOrNot').val();
            $('#odvCPHModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
            $('#odvCPHModalDelDocSingle').modal('show');
            $('#odvCPHModalDelDocSingle #osmConfirmDelSingle').unbind().click(function(){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmCouponSetupEventDelete",
                    data: {'ptDataDocNo' : ptCPHDocNo},
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1') {
                            $('#odvCPHModalDelDocSingle').modal('hide');
                            $('#odvCPHModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function () {
                                JSvCPHCallPageDataTable(ptCurrentPage);
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
function JSoCPHDelDocMultiple(){
    var aDataDelMultiple    = $('#odvCPHModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
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
            url: "dcmCouponSetupEventDelete",
            data: {'ptDataDocNo' : aNewIdDelete},
            cache: false,
            timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    setTimeout(function () {
                        $('#odvCPHModalDelDocMultiple').modal('hide');
                        $('#odvCPHModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                        $('#odvCPHModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                        $('.modal-backdrop').remove();
                        localStorage.removeItem('LocalItemData');
                        JSvCPHCallPageList();
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
function JSxCPHShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliCPHBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliCPHBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliCPHBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 25/12/2019 Wasin(Yoshi)
//Return: Insert Code In Text Input
//Return Type: -
function JSxCPHTextinModal() {
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
        $("#odvCPHModalDelDocMultiple #ospTextConfirmDelMultiple").text($('#oetTextComfirmDeleteMulti').val());
        $("#odvCPHModalDelDocMultiple #ohdConfirmIDDelMultiple").val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 25/12/2019 Wasin(Yoshi)
//Return: Duplicate/none
//Return Type: string
function JStCPHFindObjectByKey(array, key, value) {
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
function JSxCPHAddEditDocument(ptRoute) {
    let tCPHFrmCptCode = $('#oetCPHFrmCptCode').val();
    let tCPHHDCstPriCode = $('#oetCPHHDCstPriCode').val();
    let nCPHLabelFrmCphDisType = $('#ostCPHFrmCphDisType').val();
    if(tCPHHDCstPriCode == '' && nCPHLabelFrmCphDisType == 3){
        $tTextMessage   = $('#oetCPHHDCstPriCode').attr('validatedata');
        FSvCMNSetMsgWarningDialog($tTextMessage);
        return false;
    }

    if(tCPHFrmCptCode != undefined && tCPHFrmCptCode != ''){
        let nCountDataInTableDT = $('#odvCPHDataPanelDetail #otbCPHDataDetailDT tbody .xWCPHDataDetailItems').length;
        if(nCountDataInTableDT > 0){


            var aDataDetailItems    = [];
            $('#odvCPHDataPanelDetail #otbCPHDataDetailDT tbody .xWCPHDataDetailItems').each(function(){
                let fimageold       = $(this).data('imageold');
                let fimagenew       = $(this).data('imagenew');
                let tcpdbarcpn      = $(this).data('cpdbarcpn');
                let tcpdalwmaxuse   = $(this).find('.xWCpdAlwMaxUse').val();
                aDataDetailItems.push({
                    'FTImgObjOld '      : fimageold,
                    'FTImgObjNew'       : fimagenew,
                    'FTCpdBarCpn'       : tcpdbarcpn,
                    'FNCpdAlwMaxUse'    : tcpdalwmaxuse
                });
            });
            // JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmCouponSetupAddEditForm').serialize() + "&aDetailItems=" + JSON.stringify(aDataDetailItems) ,
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aDataReturn = JSON.parse(tResult);
                    if(aDataReturn['nStaEvent'] == '1'){
                        var nCouponStaCallBack  = aDataReturn['nStaCallBack'];
                        var tCouponCoderReturn  = aDataReturn['tCodeReturn'];
                        switch(nCouponStaCallBack){
                            case 1 :
                                JSvCPHCallPageEditDocument(tCouponCoderReturn);
                            break;
                            case 2 :
                                JSvCPHCallPageAddDocument();
                            break;
                            case 3 :
                                JSvCPHCallPageList();
                            break;
                            default :
                                JSvCPHCallPageEditDocument(tCouponCoderReturn);
                        }
                        JCNxImgWarningMessage(aDataReturn['aImgReturn']);
                    }else{
                        JCNxResponseError(aDataReturn['tStaMessg']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            }else{
                $tTextMessage   = $('#ohdCPHMsgNotFoundDT').val()
                FSvCMNSetMsgWarningDialog($tTextMessage);
            }
        }else{
            $tTextMessage   = $('#ohdCPHMsgNotFoundCpt').val()
            FSvCMNSetMsgWarningDialog($tTextMessage);
        }
    // }else{
    //     $tTextMessage   = $('#oetCPHHDCstPriCode').attr('validatedata');
    //     FSvCMNSetMsgWarningDialog($tTextMessage);
    // }
}

//Functionality : Call Coupon Page Edit
//Parameters : -
//Creator : 26/012/2019 Saharat(Golf)
//Return : View
//Return Type : View
function JSvCPHCallPageEditDocument(ptCPHDocNo) {
   JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "dcmCouponSetupPageEdit",
        data: { tCPHDocNo : ptCPHDocNo },
        cache: false,
        timeout: 0,
        success: function(aResult) {
            $('#odvCPHContentPageDocument').html(aResult);
            JSvCPHLoadPdtDataTableHtml(1);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


function JSxCPHControlObjAndBtn(){
    // Check สถานะอนุมัติ
    var nCPHStaDoc      = $("#ohdCPHStaDoc").val();
    var nCPHStaApv      = $("#ohdCPHStaApv").val();
    var tCPHStaDelMQ    = $('#ohdCPHStaDelMQ').val();
    var tCPHStaPrcDoc   = $('#ohdCPHStaPrcDoc').val();
    let tCouponSetupPage = $('#ohdCPHRouteEvent').val();
    JSxCPHNavDefultDocument();

    // Title Menu Set De
    $("#oliCPHTitleAdd").hide();
    $('#oliCPHTitleDetail').hide();
    $('#oliCPHTitleEdit').hide();
    $('#odvCPHBtnGrpInfo').hide();
    // Button Menu

    if(tCouponSetupPage!='dcmCouponSetupEventAdd'){
      $("#obtCPHApproveDoc").show();
      $("#obtCPHCancelDoc").show();
      $('#oliCPHTitleEdit').show();
      $('#obtCPHPrint').show();
    }else {
      $("#oliCPHTitleAdd").show();
    }
    $('#odvCPHBtnGrpSave').show();
    $('#odvCPHBtnGrpAddEdit').show();

    // Remove Disable
    $("#obtCPHCancelDoc").attr("disabled",false);
    $("#obtCPHApproveDoc").attr("disabled",false);
    $("#obtCPHBrowseSupplier").attr("disabled",false);

    // Eneble Input
    $('.xCNInputWhenStaCancelDoc:input').prop('readonly',false);
    $('#otbCPHDataDetailDT tbody td .xWCpdAlwMaxUse').prop('readonly',false);
    $('.xCNInputWhenStaCancelDoc:button').prop('disabled',false)
    $('#obtCPHAddCouponDT').removeClass('xCNBrowsePdtdisabled')

    // Status Cancel Docement
    if(nCPHStaDoc != 1){
        // Hide/Show Menu Title
        $("#oliCPHTitleAdd").hide();
        $('#oliCPHTitleEdit').hide();
        $('#oliCPHTitleDetail').show();
        $('#odvCPHBtnGrpSave').hide();
        // Disabled Button
        $("#obtCPHCancelDoc").hide();
        $("#obtCPHApproveDoc").hide();
        // Disable Input
        $('.xCNInputWhenStaCancelDoc:input').prop('readonly',true);
        $('#otbCPHDataDetailDT tbody td .xWCpdAlwMaxUse').prop('readonly',true);

        $('.xCNInputWhenStaCancelDoc:button').prop('disabled',true)
        $('#obtCPHAddCouponDT').addClass('xCNBrowsePdtdisabled');

        $('#ostCPHFrmCphDisType').css('pointer-events','none');
        $('#ostCPHFrmCphDisType').selectpicker('destroy');
        $("#obtCPHBrowseHDCstPri").attr("disabled", true);
    }

    // Check Status Appove Success
    if(nCPHStaDoc == 1 && nCPHStaApv == 1 && tCPHStaDelMQ == 1 && tCPHStaPrcDoc == 1){
        // Hide/Show Menu Title
        $("#oliCPHTitleAdd").hide();
        $('#oliCPHTitleEdit').hide();
        $('#oliCPHTitleDetail').show();
        // Disabled Button
        $("#obtCPHCancelDoc").hide();
        $("#obtCPHApproveDoc").hide();
        $('#odvCPHBtnGrpSave').hide();
        // Disable Input
        $('.xCNInputWhenStaCancelDoc:input').prop('readonly',true);
        $('#otbCPHDataDetailDT tbody td .xWCpdAlwMaxUse').prop('readonly',true);
        $('.xCNInputWhenStaCancelDoc:button').prop('disabled',true)
        $('#obtCPHAddCouponDT').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDBchInclude').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDBchExclude').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDCstPriInclude').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDCstPriExclude').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDPdtInclude').addClass('xCNBrowsePdtdisabled');
        $('#obtTabCouponHDPdtExclude').addClass('xCNBrowsePdtdisabled');
        $('.xCNIconDel').addClass('xCNDocDisabled');
        $('.xCNIconDel').attr('onclick','');
        $('#ostCPHFrmCphDisType').selectpicker('refresh');
    }
}

// Functionality: Set Status Appove Document
// Parameters: Event Click Save Document
// Creator: 26/12/2019 Saharat(Golf)
// LastUpdate: 27/12/2019 Wasin(Yoshi)
// Return: Set Status Submit By Button In Input Hidden
// ReturnType: None
function JSxCPHApproveDocument(pbIsConfirm){
    if(pbIsConfirm){
        $("#odvCPHModalAppoveDoc").modal("hide");
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        JCNxOpenLoading();
        var tDocumentNumber =  $('#oetCPHDocNo').val();
        var tBchCode        =  $('#ohdCPHUsrBchCode').val();
        $.ajax({
            type    : "POST",
            url     : "dcmCouponSetupEvenApprove",
            data    : {tDocumentNumber : tDocumentNumber  , tBchCode : tBchCode},
            timeout: 0,
            success: function(oDataReturn){
                JSvCPHCallPageEditDocument(tDocumentNumber);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                (jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        $('#odvCPHModalAppoveDoc').modal({backdrop:'static',keyboard:false});
        $("#odvCPHModalAppoveDoc").modal("show");
    }
}

// Functionality: Set Status Cancel Document
// Parameters: Event Click Save Document
// Creator: 26/12/2019 Saharat(Golf)
// LastUpdate: 27/12/2019 Wasin(Yoshi)
// Return: Set Status Submit By Button In Input Hidden
// ReturnType: None
function JSxCPHCancelDocument(){
    JCNxOpenLoading();
    var tDocumentNumber =  $('#oetCPHDocNo').val();
    var tBchCode        =  $('#ohdCPHUsrBchCode').val();
    $.ajax({
        type    : "POST",
        url     : "dcmCouponSetupEvenCancel",
        data    : {tDocumentNumber : tDocumentNumber  , tBchCode : tBchCode},
        timeout: 0,
        success: function(oDataReturn){
            JSvCPHCallPageEditDocument(tDocumentNumber);
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


    // Functionality : Function Check Data Search And Add In Tabel DT Temp
// Parameters : Event Click Buttom
// Creator : 01/10/2019 Wasin(Yoshi)
// LastUpdate: -
// Return :
// Return Type : Filter
function JSvCPHClickPageList(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld    = $('.xWCPHPageDataTable .active').text(); // Get เลขก่อนหน้า
            nPageNew    = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld    = $('.xWCPHPageDataTable .active').text(); // Get เลขก่อนหน้า
            nPageNew    = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCPHCallPageDataTable(nPageCurrent);
}
