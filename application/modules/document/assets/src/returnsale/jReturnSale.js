var nRSStaRSBrowseType     = $("#oetRSStaBrowse").val();
var tRSCallRSBackOption    = $("#oetRSCallBackOption").val();
var tRSSesSessionID        = $("#ohdSesSessionID").val();

$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    if(typeof(nRSStaRSBrowseType) != 'undefined' && nRSStaRSBrowseType == 0){
        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliRSTitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvRSCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtRSCallPageAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvRSCallPageAddDoc();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Call Back Page
        $('#obtRSCallBackPage').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvRSCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Cancel Document
        $('#obtRSCancelDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSnRSCancelDocument(false);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Appove Document
        $('#obtRSApproveDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                var tCheckIteminTable = $('#otbRSDocPdtAdvTableList .xWPdtItem').length;
                if(tCheckIteminTable>0){
                JSxRSSetStatusClickSubmit(2);
                JSxRSApproveDocument(false);
                }else{
                    FSvCMNSetMsgWarningDialog($('#ohdRSValidatePdt').val());
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From Document
        $('#obtRSSubmitFromDoc').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
              var tHNNumber =  $('#oetRSFrmCstHNNumber').val();
              var tMerCode =  $('#oetRSFrmMerCode').val();
              var tShpCode =  $('#oetRSFrmShpCode').val();
              var tPosCode =  $('#oetRSFrmPosCode').val();
              var tWahCode =  $('#oetRSFrmWahCode').val();
              var tCheckIteminTable = $('#otbRSDocPdtAdvTableList .xWPdtItem').length;
          
              if(tCheckIteminTable>0){
                JSxRSSetStatusClickSubmit(1);
                $('#obtRSSubmitDocument').click();
                }else{
                    FSvCMNSetMsgWarningDialog($('#ohdRSValidatePdt').val());
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        
        JSxRSNavDefultDocument();
        JSvRSCallPageList();
    }else{
        // Event Modal Call Back Before List
        $('#oahRSBrowseCallBack').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tRSCallRSBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Modal Call Back Previous
        $('#oliRSBrowsePrevious').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tRSCallRSBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtRSBrowseSubmit').unbind().click(function () {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxRSSetStatusClickSubmit(1);
                $('#obtRSSubmitDocument').click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JSxRSNavDefultDocument();
        JSvRSCallPageAddDoc();
    }
});

// Function: Set Defult Nav Menu Document
// Parameters: Document Ready Or Parameter Event
// Creator: 17/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate:
// Return: Set Default Nav Menu Document
// ReturnType: -
function JSxRSNavDefultDocument(){
    if(typeof(nRSStaRSBrowseType) != 'undefined' && nRSStaRSBrowseType == 0) {
        // Title Label Hide/Show
        $('#oliRSTitleAdd').hide();
        $('#oliRSTitleEdit').hide();
        $('#oliRSTitleDetail').hide();
        $('#oliRSTitleAprove').hide();
        $('#oliRSTitleConimg').hide();
        // Button Hide/Show
        $('#odvRSBtnGrpAddEdit').hide();
        $('#odvRSBtnGrpInfo').show();
        $('#obtRSCallPageAdd').show();
    }else{
        $('#odvModalBody #odvRSMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliRSNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvRSBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNRSBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNRSBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 17/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate:
// Return: Call View Tranfer Out List
// ReturnType: View
function JSvRSCallPageList(){
    $.ajax({
        type: "GET",
        url: "dcmRSFormSearchList",
        cache: false,
        timeout: 0,
        success: function (tResult){
            $("#odvRSContentPageDocument").html(tResult);
            JSxRSNavDefultDocument();
            JSvRSCallPageDataTable();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });  
}

// Function: Get Data Advanced Search
// Parameters: Function Call Page
// Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate: -
// Return: object Data Advanced Search
// ReturnType: object
function JSoRSGetAdvanceSearchData(){
    var oAdvanceSearchData  = {
        tSearchAll          : $("#oetRSSearchAllDocument").val(),
        tSearchBchCodeFrom  : $("#oetRSAdvSearchBchCodeFrom").val(),
        tSearchBchCodeTo    : $("#oetRSAdvSearchBchCodeTo").val(),
        tSearchDocDateFrom  : $("#oetRSAdvSearcDocDateFrom").val(),
        tSearchDocDateTo    : $("#oetRSAdvSearcDocDateTo").val(),
        tSearchStaDoc       : $("#ocmRSAdvSearchStaDoc").val(),
        tSearchStaApprove   : $("#ocmRSAdvSearchStaApprove").val(),
        tSearchStaPrcStk    : $("#ocmRSAdvSearchStaPrcStk").val()
    };
    return oAdvanceSearchData;
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate:
// Return: Call View Tabel Data List Document
// ReturnType: View
function JSvRSCallPageDataTable(pnPage){
    JCNxOpenLoading();
    var oAdvanceSearch  = JSoRSGetAdvanceSearchData();
    var nPageCurrent = pnPage;
    if(typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type: "POST",
        url: "dcmRSDataTable",
        data: {
            oAdvanceSearch  : oAdvanceSearch,
            nPageCurrent    : nPageCurrent,
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxRSNavDefultDocument();
                $('#ostRSDataTableDocument').html(aReturnData['tRSViewDataTableList']);
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

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
//Return: Show Button Delete All
//Return Type: -
function JSxRSShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliRSBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliRSBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliRSBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
//Return: Insert Code In Text Input
//Return Type: -
function JSxRSTextinModal() {
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
        $("#odvRSModalDelDocMultiple #ospTextConfirmDelMultiple").text($('#oetTextComfirmDeleteMulti').val());
        $("#odvRSModalDelDocMultiple #ohdConfirmIDDelMultiple").val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
//Return: Duplicate/none
//Return Type: string
function JStRSFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

// Functionality : เปลี่ยนหน้า Pagenation Document HD List 
// Parameters : Event Click Pagenation Table HD List
// Creator : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
// Return : View
// Return Type : View
function JSvRSClickPage(ptPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld        = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent    = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld        = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent    = nPageNew;
                break;
            default:
                nPageCurrent    = ptPage;
        }
        JSvRSCallPageDataTable(nPageCurrent);
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Event Single Delete Document Single
// Parameters: Function Call Page
// Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate: -
// Return: object Data Sta Delete
// ReturnType: object
function JSoRSDelDocSingle(ptCurrentPage, ptRSDocNo){
    var nStaSession = JCNxFuncChkSessionExpired();    
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        if(typeof(ptRSDocNo) != undefined && ptRSDocNo != ""){
            var tTextConfrimDelSingle   = $('#oetTextComfirmDeleteSingle').val()+"&nbsp"+ptRSDocNo+"&nbsp"+$('#oetTextComfirmDeleteYesOrNot').val();
            $('#odvRSModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
            $('#odvRSModalDelDocSingle').modal('show');
            $('#odvRSModalDelDocSingle #osmConfirmDelSingle').unbind().click(function(){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmRSEventDelete",
                    data: {'tDataDocNo' : ptRSDocNo},
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1') {
                            $('#odvRSModalDelDocSingle').modal('hide');
                            $('#odvRSModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function () {
                                JSvRSCallPageDataTable(ptCurrentPage);
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
// Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate: -
// Return: object Data Sta Delete
// ReturnType: object
function JSoRSDelDocMultiple(){
    var aDataDelMultiple    = $('#odvRSModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
    var aTextsDelMultiple   = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
    var aDataSplit          = aTextsDelMultiple.split(" , ");
    var nDataSplitlength    = aDataSplit.length;
    var aNewIdDelete        = [];
    for ($i = 0; $i < nDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }
    if (nDataSplitlength > 1) {
        JCNxOpenLoading();
        localStorage.StaDeleteArray = '1';
        $.ajax({
            type: "POST",
            url: "dcmRSEventDelete",
            data: {'tDataDocNo' : aNewIdDelete},
            cache: false,
            timeout: 0,
            success: function (oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    setTimeout(function () {
                        $('#odvRSModalDelDocMultiple').modal('hide');
                        $('#odvRSModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                        $('#odvRSModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                        $('.modal-backdrop').remove();
                        localStorage.removeItem('LocalItemData');
                        JSvRSCallPageList();
                    }, 1000);
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

// Functionality : Call Page PI Add Page
// Parameters : Event Click Buttom
// Creator : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
// Return : View
// Return Type : View
function JSvRSCallPageAddDoc(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "dcmRSPageAdd",
        cache: false,
        timeout: 0,
        success: function (oResult) {
            var aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1') {
                if (nRSStaRSBrowseType == '1') {
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tRSViewPageAdd']);
                } else {
                    // Hide Title Menu And Button
                    $('#oliRSTitleEdit').hide();
                    $('#oliRSTitleDetail').hide();
                    $("#obtRSApproveDoc").hide();
                    $("#obtRSCancelDoc").hide();
                    $('#obtRSPrintDoc').hide();
                    $('#odvRSBtnGrpInfo').hide();
                    // Show Title Menu And Button
                    $('#oliRSTitleAdd').show();
                    $('#odvRSBtnGrpSave').show();
                    $('#odvRSBtnGrpAddEdit').show();
                    $('#oliRSTitleAprove').hide();
                    $('#oliRSTitleConimg').hide();

                    // Remove Disable Button Add 
                    $(".xWBtnGrpSaveLeft").attr("disabled",false);
                    $(".xWBtnGrpSaveRight").attr("disabled",false);

                    $('#odvRSContentPageDocument').html(aReturnData['tRSViewPageAdd']);
                }
                JSvRSLoadPdtDataTableHtml();
                JCNxLayoutControll();
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

// Functionality: Call Page Product Table In Add Document
// Parameters: Function Ajax Success
// Creator: 28/06/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View
// ReturnType : View
function JSvRSLoadPdtDataTableHtml(pnPage){
        if($("#ohdRSRoute").val() == "dcmRSEventAdd"){
            var tRSDocNo    = "";
        }else{
            var tRSDocNo    = $("#oetRSDocNo").val();
        }

        var tRSStaApv       = $("#ohdRSStaApv").val();
        var tRSStaDoc       = $("#ohdRSStaDoc").val();
        var tRSVATInOrEx    = $("#ocmRSFrmSplInfoVatInOrEx").val();
        
        //เช็ค สินค้าใน table หน้านั้นๆ หรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
        if ($("#otbRSDocPdtAdvTableList .xWPdtItem").length == 0){
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
        var tSearchPdtAdvTable  = $('#oetRSFrmFilterPdtHTML').val();

        if(tRSStaApv==2){
            $('#obtRSDocBrowsePdt').hide();
            $('#obtRSPrintDoc').hide();
            $('#obtRSCancelDoc').hide();
            $('#obtRSApproveDoc').hide();
            $('#odvRSBtnGrpSave').hide();
        }

        $.ajax({
            type: "POST",
            url: "dcmRSPdtAdvanceTableLoadData",
            data: {
                'tSelectBCH'        : $('#oetRSFrmBchCode').val(),
                'ptSearchPdtAdvTable'   : tSearchPdtAdvTable,
                'ptRSDocNo'             : tRSDocNo,
                'ptRSStaApv'            : tRSStaApv,
                'ptRSStaDoc'            : tRSStaDoc,
                'ptRSVATInOrEx'         : tRSVATInOrEx,
                'pnRSPageCurrent'       : nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['checksession'] == 'expire'){
                    JCNxShowMsgSessionExpired();
                }else{
                    if(aReturnData['nStaEvent'] == '1') {
                        $('#odvRSDataPanelDetailPDT #odvRSDataPdtTableDTTemp').html(aReturnData['tRSPdtAdvTableHtml']);
                        var aRSEndOfBill    = aReturnData['aRSEndOfBill'];
                        JSxRSSetFooterEndOfBill(aRSEndOfBill);

                        if($('#oetRSRefDocNo').val()!=""){
                            $('.xCNBTNPrimeryDisChgPlus').hide();
                            $('#obtRSDocBrowsePdt').hide();
                        }

                        JCNxCloseLoading();
                    }else{
                        var tMessageError = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                        JCNxCloseLoading();
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JSvRSLoadPdtDataTableHtml(pnPage)
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
}




// Functionality: Add Product Into Table Document DT Temp
// Parameters: Function Ajax Success
// Creator: 01/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View
// ReturnType : View
function JCNvRSBrowsePdt(){
    var tRSSplCode = $('#oetRSFrmSplCode').val();
    if($('#ohdRSPplCodeCst').val()!=''){
        var tRSPplCode =$('#ohdRSPplCodeCst').val();
    }else{
        var tRSPplCode =$('#ohdRSPplCodeBch').val();
    }
    // if(typeof(tRSSplCode) !== undefined && tRSSplCode !== ''){
        var aMulti = [];
        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                Qualitysearch   : [],
                // PriceType: ["Cost","tCN_Cost","Company","1"],
                // 'PriceType' : ['Pricesell'],
                'PriceType' : ['Price4Cst',tRSPplCode],
                //'SelectTier' : ['PDT'],
                SelectTier: ["Barcode"],
                //'Elementreturn'   : ['oetInputTestValue','oetInputTestName'],
                ShowCountRecord: 10,
                NextFunc: "FSvRSNextFuncB4SelPDT", //FSvRSAddPdtIntoDocDTTemp
                ReturnType: "M",
                SPL: [$("#oetRSFrmSplCode").val(),$("#oetRSFrmSplCode").val()],
                BCH: [$("#oetRSFrmBchCode").val(),$("#oetRSFrmBchCode").val()],
                MCH: [$("#oetRSFrmMerCode").val(),$("#oetRSFrmMerCode").val()],
                SHP: [$("#oetRSFrmShpCode").val(), $("#oetRSFrmShpCode").val()],
                //NOTINITEM: [["00001", "8858998588015"]]
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


// Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
// Parameters: Function Behind Edit In Line
// Creator: 02/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View Table Product Doc DT Temp
// ReturnType : View
function FSvRSEditPdtIntoTableDT(pnSeqNo, ptFieldName, ptValue, pbIsDelDTDis){
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if (typeof nStaSession !== "undefined" && nStaSession == 1){
        var tRSDocNo        = $("#oetRSDocNo").val();
        var tRSBchCode      = $("#oetRSFrmBchCode").val();
        var tRSVATInOrEx    = $('#ocmRSFrmSplInfoVatInOrEx').val();
        $.ajax({
            type: "POST",
            url: "dcmRSEditPdtIntoDTDocTemp",
            data: {
                'tRSBchCode'    : tRSBchCode,
                'tRSDocNo'      : tRSDocNo,
                'tRSVATInOrEx'  : tRSVATInOrEx,
                'nRSSeqNo'      : pnSeqNo,
                'tRSFieldName'  : ptFieldName,
                'tRSValue'      : ptValue,
                'nRSIsDelDTDis' : (pbIsDelDTDis) ? '1' : '0' // 1: ลบ, 2: ไม่ลบ
            },
            cache: false,
            timeout: 0,
            success: function (oResult){

                if(oResult == 'expire'){
                    JCNxShowMsgSessionExpired();
                }else{
                    JSvRSLoadPdtDataTableHtml();
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    // }else{
    //     JCNxShowMsgSessionExpired();
    // }
}



// Functionality: Set Status On Click Submit Buttom
// Parameters: Event Click Save Document
// Creator: 03/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Set Status Submit By Button In Input Hidden
// ReturnType: None
function JSxRSSetStatusClickSubmit(pnStatus) {
    $("#ohdRSCheckSubmitByButton").val(pnStatus);
}

// Functionality: Add/Edit Document
// Parameters: Event Click Save Document
// Creator: 03/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: None
function JSxRSAddEditDocument(){
    // var nStaSession = JCNxFuncChkSessionExpired();
    var nStaSession = 1;
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        JSxRSValidateFormDocument();
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Validate From Add Or Update Document
// Parameters: Function Ajax Success
// Creator: 03/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Status Add Or Update Document 
// ReturnType : -
function JSxRSValidateFormDocument(){
    if($("#ohdRSCheckClearValidate").val() != 0){
        $('#ofmRSFormAdd').validate().destroy();
    }

    $('#ofmRSFormAdd').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetRSDocNo : {
                "required" : {
                    depends: function (oElement) {
                        if($("#ohdRSRoute").val()  ==  "dcmRSEventAdd"){
                            if($('#ocbRSStaAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }else{
                            return false;
                        }
                    }
                }
            },
            oetRSDocDate    : {"required" : true},
            oetRSDocTime    : {"required" : true},
            oetRSFrmBchName : {"required" : true},
            oetRSFrmShpName : {"required" : true},
            oetRSFrmPosName : {"required" : true},
            oetRSFrmWahName : {"required" : true},
            oetRSRcvName : {"required" : true},
            oetRSRsnName : {"required" : true},
        },
        messages: {
            oetRSDocNo      : {"required" : $('#oetRSDocNo').attr('data-validate-required')},
            oetRSDocDate    : {"required" : $('#oetRSDocDate').attr('data-validate-required')},
            oetRSDocTime    : {"required" : $('#oetRSDocTime').attr('data-validate-required')},
            oetRSFrmBchName : {"required" : $('#oetRSFrmBchName').attr('data-validate-required')},
            oetRSFrmShpName : {"required" : $('#oetRSFrmShpName').attr('data-validate-required')},
            oetRSFrmPosName : {"required" : $('#oetRSFrmPosName').attr('data-validate-required')},
            oetRSFrmWahName : {"required" : $('#oetRSFrmWahName').attr('data-validate-required')},
            oetRSRcvName    : {"required" : $('#oetRSRcvName').attr('data-validate-required')},
            oetRSRsnName    : {"required" : $('#oetRSRsnName').attr('data-validate-required')},
            
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("help-block");
            if(element.prop("type") === "checkbox") {
                error.appendTo(element.parent("label"));
            }else{
                var tCheck  = $(element.closest('.form-group')).find('.help-block').length;
                if(tCheck == 0) {
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass("has-error");
        },
        submitHandler: function (form){
            if(!$('#ocbRSStaAutoGenCode').is(':checked')){
                JSxRSValidateDocCodeDublicate();
            }else{
                if($("#ohdRSCheckSubmitByButton").val() == 1){
                    JSxRSSubmitEventByButton();
                }
            }
        },
    });
}

// Functionality: Validate Doc Code (Validate ตรวจสอบรหัสเอกสาร)
// Parameters: -
// Creator: 03/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JSxRSValidateDocCodeDublicate(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            'tTableName'    : 'TVDTSalHD',
            'tFieldName'    : 'FTXshDocNo',
            'tCode'         : $('#oetRSDocNo').val()
        },
        success: function (oResult) {
            var aResultData = JSON.parse(oResult);
            $("#ohdRSCheckDuplicateCode").val(aResultData["rtCode"]);

            if($("#ohdRSCheckClearValidate").val() != 1) {
                $('#ofmRSFormAdd').validate().destroy();
            }

            $.validator.addMethod('dublicateCode', function(value,element){
                if($("#ohdRSRoute").val() == "dcmRSEventAdd"){
                    if($('#ocbRSStaAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdRSCheckDuplicateCode").val() == 1) {
                            return false;
                        }else{
                            return true;
                        }
                    }
                }else{
                    return true;
                }
            });

            // Set Form Validate From Add Document
            $('#ofmRSFormAdd').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetRSDocNo : {"dublicateCode": {}}
                },
                messages: {
                    oetRSDocNo : {"dublicateCode"  : $('#oetRSDocNo').attr('data-validate-duplicate')}
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    if(element.prop("type") === "checkbox") {
                        error.appendTo(element.parent("label"));
                    }else{
                        var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                        if (tCheck == 0) {
                            error.appendTo(element.closest('.form-group')).trigger('change');
                        }
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-error");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').removeClass("has-error");
                },
                submitHandler: function (form) {
                    if($("#ohdRSCheckSubmitByButton").val() == 1) {
                        JSxRSSubmitEventByButton();
                    }
                }
            })

            if($("#ohdRSCheckClearValidate").val() != 1) {
                $("#ofmRSFormAdd").submit();
                $("#ohdRSCheckClearValidate").val(1);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: Validate Success And Send Ajax Add/Update Document
// Parameters: Function Parameter Behide NextFunc Validate
// Creator: 03/07/2019 Wasin(Yoshi)
// LastUpdate: 04/07/2019 Wasin(Yoshi)
// Return: Status Add/Update Document
// ReturnType: object
function JSxRSSubmitEventByButton(){
    if($("#ohdRSRoute").val() !=  "dcmRSEventAdd"){
        var tRSDocNo    = $('#oetRSDocNo').val();
    }
    $.ajax({
        type: "POST",
        url: "dcmRSChkHavePdtForDocDTTemp",
        data: {
            'ptRSDocNo': tRSDocNo,
            'tRSSesSessionID'   : $('#ohdSesSessionID').val(),
            'tRSUsrCode'        : $('#ohdRSUsrCode').val(),
            'tRSLangEdit'       : $('#ohdRSLangEdit').val(),
            'tSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            JCNxCloseLoading();
            var aDataReturnChkTmp   = JSON.parse(oResult);
            if (aDataReturnChkTmp['nStaReturn'] == '1'){
                $.ajax({
                    type    : "POST",
                    url     : $("#ohdRSRoute").val(),
                    data    : $("#ofmRSFormAdd").serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function(oResult){
                        JCNxCloseLoading();
                        var aDataReturnEvent    = JSON.parse(oResult);
                        if(aDataReturnEvent['nStaReturn'] == '1'){
                            var nRSStaCallBack      = aDataReturnEvent['nStaCallBack'];
                            var nRSDocNoCallBack    = aDataReturnEvent['tCodeReturn'];
                            switch(nRSStaCallBack){
                                case '1' :
                                    JSvRSCallPageEditDoc(nRSDocNoCallBack);
                                break;
                                case '2' :
                                    JSvRSCallPageAddDoc();
                                break;
                                case '3' :
                                    JSvRSCallPageList();
                                break;
                                default :
                                    JSvRSCallPageEditDoc(nRSDocNoCallBack);
                            }
                        }else{
                            var tMessageError = aDataReturnEvent['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error   : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else if(aDataReturnChkTmp['nStaReturn'] == '800'){
                var tMsgDataTempFound   = aDataReturnChkTmp['tStaMessg'];
                FSvCMNSetMsgWarningDialog('<p class="text-left">'+tMsgDataTempFound+'</p>');
            }else{
                var tMsgErrorFunction   = aDataReturnChkTmp['tStaMessg'];
                FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}




// Functionality: Validate Success And Send Ajax Add/Update Document
// Parameters: Function Parameter Behide NextFunc Validate
// Creator: 03/07/2019 Wasin(Yoshi)
// LastUpdate: 04/07/2019 Wasin(Yoshi)
// Return: Status Add/Update Document
// ReturnType: object
function JSxRSSubmitEventByButton(){
    if($("#ohdRSRoute").val() !=  "dcmRSEventAdd"){
        var tRSDocNo    = $('#oetRSDocNo').val();
    }
    $.ajax({
        type: "POST",
        url: "dcmRSChkHavePdtForDocDTTemp",
        data: {
            'ptRSDocNo': tRSDocNo,
            'tRSSesSessionID'   : $('#ohdSesSessionID').val(),
            'tRSUsrCode'        : $('#ohdRSUsrCode').val(),
            'tRSLangEdit'       : $('#ohdRSLangEdit').val(),
            'tSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            JCNxCloseLoading();
            var aDataReturnChkTmp   = JSON.parse(oResult);
            if (aDataReturnChkTmp['nStaReturn'] == '1'){
                $.ajax({
                    type    : "POST",
                    url     : $("#ohdRSRoute").val(),
                    data    : $("#ofmRSFormAdd").serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function(oResult){
                        JCNxCloseLoading();
                        var aDataReturnEvent    = JSON.parse(oResult);
                        if(aDataReturnEvent['nStaReturn'] == '1'){
                            var nRSStaCallBack      = aDataReturnEvent['nStaCallBack'];
                            var nRSDocNoCallBack    = aDataReturnEvent['tCodeReturn'];
                            if($('#ohdRSPage').val()==1){
                            switch(nRSStaCallBack){
                                case '1' :
                                    JSvRSCallPageEditDoc(nRSDocNoCallBack);
                                break;
                                case '2' :
                                    JSvRSCallPageAddDoc();
                                break;
                                case '3' :
                                    JSvRSCallPageList();
                                break;
                                default :
                                    JSvRSCallPageEditDoc(nRSDocNoCallBack);
                            }
                        }else{
                            JSvRSCallPageEditDocOnMonitor(nRSDocNoCallBack);
                        }
                        }else{
                            var tMessageError = aDataReturnEvent['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error   : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else if(aDataReturnChkTmp['nStaReturn'] == '800'){
                var tMsgDataTempFound   = aDataReturnChkTmp['tStaMessg'];
                FSvCMNSetMsgWarningDialog('<p class="text-left">'+tMsgDataTempFound+'</p>');
            }else{
                var tMsgErrorFunction   = aDataReturnChkTmp['tStaMessg'];
                FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: Call Page Edit Document
// Parameters: Event Btn Click Call Edit Document
// Creator: 04/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Status Add/Update Document
// ReturnType: object
function JSvRSCallPageEditDoc(ptRSDocNo){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        // JStCMMGetPanalLangSystemHTML("JSvRSCallPageEditDoc",ptRSDocNo);
        $.ajax({
            type: "POST",
            url: "dcmRSPageEdit",
            data: {'ptRSDocNo' : ptRSDocNo},
            cache: false,
            timeout: 0,
            success: function(tResult){
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    if(nRSStaRSBrowseType == '1') {
                        $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                        $('#odvModalBodyBrowse').html(aReturnData['tRSViewPageEdit']);
                    }else{
                        $('#odvRSContentPageDocument').html(aReturnData['tRSViewPageEdit']);
                        JCNxRSControlObjAndBtn();
                        JSvRSLoadPdtDataTableHtml();
                        $(".xWConditionSearchPdt.disabled").attr("disabled","disabled");
                        JCNxLayoutControll();
                    }
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function (jqXHR, textStatus, errorThrown){
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality: Function Control Object Button
// Parameters: Event Btn Click Call Edit Document
// Creator: 11/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Status Add/Update Document
// ReturnType: object
function JCNxRSControlObjAndBtn(){
    // Check สถานะอนุมัติ
    var nRSStaDoc       = $("#ohdRSStaDoc").val();
    var nRSStaApv       = $("#ohdRSStaApv").val();
    var tRSStaDelMQ     = $('#ohdRSStaDelMQ').val();
    var tRSStaPrcStk    = $('#ohdRSStaPrcStk').val();

    JSxRSNavDefultDocument();

    // Title Menu Set De
    $("#oliRSTitleAdd").hide();
    $('#oliRSTitleDetail').hide();
    $('#oliRSTitleAprove').hide();
    $('#oliRSTitleConimg').hide();
    $('#oliRSTitleEdit').show();
    $('#odvRSBtnGrpInfo').hide();
    // Button Menu
    $("#obtRSApproveDoc").show();
    $("#obtRSCancelDoc").show();
    $('#obtRSPrintDoc').show();
    $('#odvRSBtnGrpSave').show();
    $('#odvRSBtnGrpAddEdit').show();

    // Remove Disable
    $("#obtRSCancelDoc").attr("disabled",false);
    $("#obtRSApproveDoc").attr("disabled",false);
    $("#obtRSPrintDoc").attr("disabled",false);
    $("#obtRSBrowseSupplier").attr("disabled",false);

    $(".xWConditionSearchPdt").attr("disabled",false);
    $(".ocbListItem").attr("disabled",false);
    $(".xCNBtnDateTime").attr("disabled",false);
    $(".xCNDocBrowsePdt").attr("disabled",false).removeClass("xCNBrowsePdtdisabled");
    $(".xCNDocDrpDwn").show();
    $("#oetRSFrmSearchPdtHTML").attr("disabled", false);
    $(".xWBtnGrpSaveLeft").show();
    $(".xWBtnGrpSaveRight").show();
    $("#oliRSEditShipAddress").show();
    $("#oliRSEditTexAddress").show();

    if(nRSStaDoc != 1){
        // Hide/Show Menu Title 
        $("#oliRSTitleAdd").hide();
        $('#oliRSTitleEdit').hide();
        $('#oliRSTitleDetail').show();
        $('#oliRSTitleAprove').hide();
        $('#oliRSTitleConimg').hide();
        // Disabled Button
        $("#obtRSCancelDoc").hide(); // attr("disabled",true);
        $("#obtRSApproveDoc").hide(); // attr("disabled",true);
        $("#obtRSPrintDoc").hide(); // attr("disabled",true);
        $("#obtRSBrowseSupplier").attr("disabled",true);
        $(".xWConditionSearchPdt").attr("disabled",true);
        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetRSFrmSearchPdtHTML").attr("disabled",true);
        $('#odvRSBtnGrpSave').hide();
        // $(".xWBtnGrpSaveLeft").hide(); // attr("disabled", true);
        // $(".xWBtnGrpSaveRight").hide(); // attr("disabled", true);
        $("#oliRSEditShipAddress").hide();
        $("#oliRSEditTexAddress").hide();
        // Hide Button
        $("#obtRSCallPageAdd").hide();
    }

    // Check Status Appove Success


    if(nRSStaDoc == 1 && nRSStaApv == 1 ){
        // Hide/Show Menu Title 
        $("#oliRSTitleAdd").hide();
        $('#oliRSTitleEdit').hide();
        $('#oliRSTitleDetail').show();
        $('#oliRSTitleAprove').hide();
        $('#oliRSTitleConimg').hide();
        // Hide And Disabled
        $("#obtRSCallPageAdd").hide();
        $("#obtRSCancelDoc").hide(); // attr("disabled",true);
        $("#obtRSApproveDoc").hide(); // attr("disabled",true);
        $("#obtRSBrowseSupplier").attr("disabled",true);
        $(".xWConditionSearchPdt").attr("disabled",true);
        $('#oetRSInsertBarcode').attr("disabled", true);
        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetRSFrmSearchPdtHTML").attr("disabled", false);
        $('#odvRSBtnGrpSave').hide();
        // $(".xWBtnGrpSaveLeft").hide(); // attr("disabled", true);
        // $(".xWBtnGrpSaveRight").hide(); // attr("disabled", true);
        $("#oliRSEditShipAddress").hide();
        $("#oliRSEditTexAddress").hide();
        // Show And Disabled
        $("#oliRSTitleDetail").show();
    }
}

// Functionality: Cancel Document PI
// Parameters: Event Btn Click Call Edit Document
// Creator: 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Status Cancel Document
// ReturnType: object
function JSnRSCancelDocument(pbIsConfirm){
    var tRSDocNo    = $("#oetRSDocNo").val();
    if(pbIsConfirm){
        $.ajax({
            type: "POST",
            url: "dcmRSCancelDocument",
            data: {'ptRSDocNo' : tRSDocNo},
            cache: false,
            timeout: 0,
            success: function (tResult) {
                $("#odvPurchaseInviocePopupCancel").modal("hide");
                $('.modal-backdrop').remove();
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    JSvRSCallPageEditDoc(tRSDocNo);
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
    }else{
        $('#odvPurchaseInviocePopupCancel').modal({backdrop:'static',keyboard:false});
        $("#odvPurchaseInviocePopupCancel").modal("show");
    }
}

// Functionality : Applove Document 
// Parameters : Event Click Buttom
// Creator : 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : Status Applove Document
// Return Type : -
function JSxRSApproveDocument(pbIsConfirm){
    if(pbIsConfirm){
        $("#odvRSModalAppoveDoc").modal("hide");
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        var tRSDocNo            = $("#oetRSDocNo").val();
        var tRSBchCode          = $('#oetRSFrmBchCode').val();
        var tRSStaApv           = $("#ohdRSStaApv").val();
      

        $.ajax({
            type : "POST",
            url : "dcmRSApproveDocument",
            data: {
                'ptRSDocNo'             : tRSDocNo,
                'ptRSBchCode'           : tRSBchCode,
                'ptRSStaApv'            : tRSStaApv
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                console.log(tResult);
                    let oResult = JSON.parse(tResult);
                    if (oResult.nStaEvent == "900") {
                        FSvCMNSetMsgErrorDialog(tResult.tStaMessg);
                        JCNxCloseLoading();
                        return;
                    }


                    var tDialogHeader = $('#ohdSystemIsInProgress').val();
                    var tButtonLabel = $('#ohdHideProcessProgress').val();
                    var tButtonLabelDone = $('#ohdHideProcessProgressDone').val();
                    // console.log('Session: ', sessionStorage.getItem(poDocConfig.tQName));
            
                    FSxCMNSetMsgInfoMessageDialog(tDialogHeader, 'กำลังประมวลผล...', tButtonLabel, '', '');
                    FSxCMNSetMsgInfoMessageDialog(tDialogHeader, 0, tButtonLabel, 0, '');
                    setTimeout(function(){
                    FSxCMNSetMsgInfoMessageDialog(tDialogHeader, 50, tButtonLabel, 50, '');
                    setTimeout(function(){
                        FSxCMNSetMsgInfoMessageDialog(tDialogHeader, 100, tButtonLabel, 100, '');
                        $('#odvModalInfoMessage button').text(tButtonLabelDone);
                            setTimeout(function(){ 
                                $('#odvModalInfoMessage').modal('hide');
                                JSvRSCallPageEditDoc(tRSDocNo);
                            }, 1000);
                        }, 1000);
                    }, 1000);
       


                 
                // JSoRSCallSubscribeMQ();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        $('#odvRSModalAppoveDoc').modal({backdrop:'static',keyboard:false});
        $("#odvRSModalAppoveDoc").modal("show");
    }
}

// Functionality : Call Data Subscript Document
// Parameters : Event Click Buttom
// Creator : 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : Status Applove Document
// Return Type : -
function JSoRSCallSubscribeMQ() {
    // RabbitMQ
    /*===========================================================================*/
    // Document variable
    var tLangCode   = $("#ohdRSLangEdit").val();
    var tUsrBchCode = $("#oetRSFrmBchCode").val();
    var tUsrApv     = $("#ohdRSApvCodeUsrLogin").val();
    var tDocNo      = $("#oetRSDocNo").val();
    var tPrefix     = "RESPVD";
    var tStaApv     = $("#ohdRSStaApv").val();
    var tStaDelMQ   = $("#ohdRSStaDelMQ").val();
    var tQName      = tPrefix + "_" + tDocNo + "_" + tUsrApv;

    // MQ Message Config
    var poDocConfig = {
        tLangCode   : tLangCode,
        tUsrBchCode : tUsrBchCode,
        tUsrApv     : tUsrApv,
        tDocNo      : tDocNo,
        tPrefix     : tPrefix,
        tStaDelMQ   : tStaDelMQ,
        tStaApv     : tStaApv,
        tQName      : tQName
    };

    // RabbitMQ STOMP Config
    var poMqConfig = {
        host: "ws://" + oSTOMMQConfig.host + ":15674/ws",
        username: oSTOMMQConfig.user,
        password: oSTOMMQConfig.password,
        vHost: oSTOMMQConfig.vhost
    };

    // Update Status For Delete Qname Parameter
    var poUpdateStaDelQnameParams = {
        ptDocTableName      : "TARTRSHD",
        ptDocFieldDocNo     : "FTXshDocNo",
        ptDocFieldStaApv    : "FTXphStaPrcStk",
        ptDocFieldStaDelMQ  : "FTXphStaDelMQ",
        ptDocStaDelMQ       : tStaDelMQ,
        ptDocNo             : tDocNo
    };

    // Callback Page Control(function)
    var poCallback = {
        tCallPageEdit: "JSvRSCallPageEditDoc",
        tCallPageList: "JSvRSCallPageList"
    };

    // Check Show Progress %
    FSxCMNRabbitMQMessage(poDocConfig,poMqConfig,poUpdateStaDelQnameParams,poCallback);
}

// Functionality : Call Data Subscript Document
// Parameters : Event Click Buttom
// Creator : 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : Status Applove Document
// Return Type :
function JSvRSDOCFilterPdtInTableTemp(){
    JCNxOpenLoading();
    JSvRSLoadPdtDataTableHtml();
}

// Functionality : Function Check Data Search And Add In Tabel DT Temp
// Parameters : Event Click Buttom
// Creator : 30/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : 
// Return Type : Filter
function JSxRSChkConditionSearchAndAddPdt(){
    var tRSDataSearchAndAdd =   $("#oetRSFrmSearchAndAddPdtHTML").val();
    if(tRSDataSearchAndAdd != undefined && tRSDataSearchAndAdd != ""){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var tRSDataSearchAndAdd = $("#oetRSFrmSearchAndAddPdtHTML").val();
            var tRSDocNo            = $('#oetRSDocNo').val();
            var tRSBchCode          = $("#oetRSFrmBchCode").val();
            var tRSStaReAddPdt      = $("#ocmRSFrmInfoOthReAddPdt").val();
            $.ajax({
                type: "POST",
                url: "dcmRSSerachAndAddPdtIntoTbl",
                data:{
                    'ptRSBchCode'           : tRSBchCode,
                    'ptRSDocNo'             : tRSDocNo,
                    'ptRSDataSearchAndAdd'  : tRSDataSearchAndAdd,
                    'ptRSStaReAddPdt'       : tRSStaReAddPdt,
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aDataReturn = JSON.parse(tResult);
                    switch(aDataReturn['nStaEvent']){

                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
}

// Functionality : Function Check Data Search And Add In Tabel DT Temp
// Parameters : Event Click Buttom
// Creator : 01/10/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : 
// Return Type : Filter
function JSvRSClickPageList(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld    = $('.xWPIPageDataTable .active').text(); // Get เลขก่อนหน้า
            nPageNew    = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld    = $('.xWPIPageDataTable .active').text(); // Get เลขก่อนหน้า
            nPageNew    = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvRSCallPageDataTable(nPageCurrent);
}


//Next page
function JSvRSPDTDocDTTempClickPage(ptPage) {
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
        JSvRSLoadPdtDataTableHtml(nPageCurrent);
    } else {
        JCNxShowMsgSessionExpired();
    }
}




