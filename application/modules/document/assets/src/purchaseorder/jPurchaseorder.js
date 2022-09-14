var nPOStaBrowseType     = $("#oetPOStaBrowse").val();
var tPOCallBackOption    = $("#oetPOCallBackOption").val();
var tPOSesSessionID        = $("#ohdSesSessionID").val();

$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    if(typeof(nPOStaBrowseType) != 'undefined' && nPOStaBrowseType == 0){
        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliPOTitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPOCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtPOCallPageAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPOCallPageAddDoc();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Call Back Page
        $('#obtPOCallBackPage').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPOCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Cancel Document
        $('#obtPOCancelDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSnPOCancelDocument(false);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Appove Document
        $('#obtPOApproveDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                var tCheckIteminTable = $('#otbPODocPdtAdvTableList .xWPdtItem').length;
                if(tCheckIteminTable>0){
                JSxPOSetStatusClickSubmit(2);
                JSxPOApproveDocument(false);
                }else{
                    FSvCMNSetMsgWarningDialog($('#ohdPOValidatePdt').val());
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From Document
        $('#obtPOSubmitFromDoc').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
              var tFrmSplName =  $('#oetPOFrmSplName').val();
              var tCheckIteminTable = $('#otbPODocPdtAdvTableList .xWPdtItem').length;
              var nPOStaValidate =  $('.xPOStaValidate0').length;
              if(tCheckIteminTable>0){
                    if(nPOStaValidate==0){
                        if(tFrmSplName!=''){
                            JSxPOSetStatusClickSubmit(1);
                            $('#obtPOSubmitDocument').click();
                        }else{
                            $('#odvPOModalPleseselectSPL').modal('show');
                        }
                    }else{
                        // FSvCMNSetMsgWarningDialog($('#ohdPOValidatePdtImp').val());
                        $('#odvPOModalImpackImportExcel').modal('show')
                    }
                }else{
                    FSvCMNSetMsgWarningDialog($('#ohdPOValidatePdt').val());
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        
        JSxPONavDefultDocument();
        JSvPOCallPageList();
    }else{
        // Event Modal Call Back Before List
        $('#oahPOBrowseCallBack').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tPOCallBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Modal Call Back Previous
        $('#oliPOBrowsePrevious').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tPOCallBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtPOBrowseSubmit').unbind().click(function () {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxPOSetStatusClickSubmit(1);
                $('#obtPOSubmitDocument').click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JSxPONavDefultDocument();
        JSvPOCallPageAddDoc();
    }
});

// Function: Set Defult Nav Menu Document
// Parameters: Document Ready Or Parameter Event
// Creator: 17/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate:
// Return: Set Default Nav Menu Document
// ReturnType: -
function JSxPONavDefultDocument(){
    if(typeof(nPOStaBrowseType) != 'undefined' && nPOStaBrowseType == 0) {
        // Title Label Hide/Show
        $('#oliPOTitleAdd').hide();
        $('#oliPOTitleEdit').hide();
        $('#oliPOTitleDetail').hide();
        $('#oliPOTitleAprove').hide();
        $('#oliPOTitleConimg').hide();
        // Button Hide/Show
        $('#odvPOBtnGrpAddEdit').hide();
        $('#odvPOBtnGrpInfo').show();
        $('#obtPOCallPageAdd').show();
    }else{
        $('#odvModalBody #odvPOMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPONavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPOBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPOBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPOBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 17/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate:
// Return: Call View Tranfer Out List
// ReturnType: View
function JSvPOCallPageList(){
    $.ajax({
        type: "GET",
        url: "docPOFormSearchList",
        cache: false,
        timeout: 0,
        success: function (tResult){
            $("#odvPOContentPageDocument").html(tResult);
            JSxPONavDefultDocument();
            JSvPOCallPageDataTable();
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
function JSoPOGetAdvanceSearchData(){
    var oAdvanceSearchData  = {
        tSearchAll          : $("#oetPOSearchAllDocument").val(),
        tSearchBchCodeFrom  : $("#oetPOAdvSearchBchCodeFrom").val(),
        tSearchBchCodeTo    : $("#oetPOAdvSearchBchCodeTo").val(),
        tSearchDocDateFrom  : $("#oetPOAdvSearcDocDateFrom").val(),
        tSearchDocDateTo    : $("#oetPOAdvSearcDocDateTo").val(),
        tSearchStaDoc       : $("#ocmPOAdvSearchStaDoc").val(),
        tSearchStaApprove   : $("#ocmPOAdvSearchStaApprove").val(),
        tSearchStaDocAct    : $("#ocmStaDocAct").val(),
        tSearchStaPrcStk    : $("#ocmPOAdvSearchStaPrcStk").val()
    };
    return oAdvanceSearchData;
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate:
// Return: Call View Tabel Data List Document
// ReturnType: View
function JSvPOCallPageDataTable(pnPage){
    JCNxOpenLoading();
    var oAdvanceSearch  = JSoPOGetAdvanceSearchData();
    var nPageCurrent = pnPage;
    if(typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type: "POST",
        url: "docPODataTable",
        data: {
            oAdvanceSearch  : oAdvanceSearch,
            nPageCurrent    : nPageCurrent,
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxPONavDefultDocument();
                $('#ostPODataTableDocument').html(aReturnData['tPOViewDataTableList']);
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
function JSxPOShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliPOBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliPOBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliPOBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
//Return: Insert Code In Text Input
//Return Type: -
function JSxPOTextinModal() {
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
        $("#odvPOModalDelDocMultiple #ospTextConfirmDelMultiple").text($('#oetTextComfirmDeleteMulti').val());
        $("#odvPOModalDelDocMultiple #ohdConfirmIDDelMultiple").val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
//Return: Duplicate/none
//Return Type: string
function JStPOFindObjectByKey(array, key, value) {
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
function JSvPOClickPage(ptPage) {
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
        JSvPOCallPageDataTable(nPageCurrent);
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
function JSoPODelDocSingle(ptCurrentPage, ptPODocNo){
    var nStaSession = JCNxFuncChkSessionExpired();    
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        if(typeof(ptPODocNo) != undefined && ptPODocNo != ""){
            var tTextConfrimDelSingle   = $('#oetTextComfirmDeleteSingle').val()+"&nbsp"+ptPODocNo+"&nbsp"+$('#oetTextComfirmDeleteYesOrNot').val();
            $('#odvPOModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
            $('#odvPOModalDelDocSingle').modal('show');
            $('#odvPOModalDelDocSingle #osmConfirmDelSingle').unbind().click(function(){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docPOEventDelete",
                    data: {'tDataDocNo' : ptPODocNo},
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1') {
                            $('#odvPOModalDelDocSingle').modal('hide');
                            $('#odvPOModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function () {
                                JSvPOCallPageDataTable(ptCurrentPage);
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
function JSoPODelDocMultiple(){
    var aDataDelMultiple    = $('#odvPOModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
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
            url: "docPOEventDelete",
            data: {'tDataDocNo' : aNewIdDelete},
            cache: false,
            timeout: 0,
            success: function (oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    setTimeout(function () {
                        $('#odvPOModalDelDocMultiple').modal('hide');
                        $('#odvPOModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                        $('#odvPOModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                        $('.modal-backdrop').remove();
                        localStorage.removeItem('LocalItemData');
                        JSvPOCallPageList();
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
function JSvPOCallPageAddDoc(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "docPOPageAdd",
        cache: false,
        timeout: 0,
        success: function (oResult) {
            var aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1') {
                if (nPOStaBrowseType == '1') {
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tPOViewPageAdd']);
                } else {
                    // Hide Title Menu And Button
                    $('#oliPOTitleEdit').hide();
                    $('#oliPOTitleDetail').hide();
                    $("#obtPOApproveDoc").hide();
                    $("#obtPOCancelDoc").hide();
                    $('#obtPOPrintDoc').hide();
                    $('#odvPOBtnGrpInfo').hide();
                    // Show Title Menu And Button
                    $('#oliPOTitleAdd').show();
                    $('#odvPOBtnGrpSave').show();
                    $('#odvPOBtnGrpAddEdit').show();
                    $('#oliPOTitleAprove').hide();
                    $('#oliPOTitleConimg').hide();

                    // Remove Disable Button Add 
                    $(".xWBtnGrpSaveLeft").attr("disabled",false);
                    $(".xWBtnGrpSaveRight").attr("disabled",false);

                    $('#odvPOContentPageDocument').html(aReturnData['tPOViewPageAdd']);
                }
                JSvPOLoadPdtDataTableHtml();
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
function JSvPOLoadPdtDataTableHtml(pnPage){
        if($("#ohdPORoute").val() == "docPOEventAdd"){
            var tPODocNo    = "";
        }else{
            var tPODocNo    = $("#oetPODocNo").val();
        }
 
        var tPOStaApv       = $("#ohdPOStaApv").val();
        var tPOStaDoc       = $("#ohdPOStaDoc").val();
        var tPOVATInOrEx    = $("#ocmPOFrmSplInfoVatInOrEx").val();
        
        //เช็ค สินค้าใน table หน้านั้นๆ หรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
        if ($("#otbPODocPdtAdvTableList .xWPdtItem").length == 0){
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
        var tSearchPdtAdvTable  = $('#oetPOFrmFilterPdtHTML').val();

        if(tPOStaApv==2){
            $('#obtPODocBrowsePdt').hide();
            $('#obtPOPrintDoc').hide();
            $('#obtPOCancelDoc').hide();
            $('#obtPOApproveDoc').hide();
            $('#odvPOBtnGrpSave').hide();
        }

        $.ajax({
            type: "POST",
            url: "docPOPdtAdvanceTableLoadData",
            data: {
                'tSelectBCH'        : $('#oetPOFrmBchCode').val(),
                'ptSearchPdtAdvTable'   : tSearchPdtAdvTable,
                'ptPODocNo'             : tPODocNo,
                'ptPOStaApv'            : tPOStaApv,
                'ptPOStaDoc'            : tPOStaDoc,
                'ptPOVATInOrEx'         : tPOVATInOrEx,
                'pnPOPageCurrent'       : nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['checksession'] == 'expire'){
                    JCNxShowMsgSessionExpired();
                }else{
                    if(aReturnData['nStaEvent'] == '1') {
                        $('#odvPODataPanelDetailPDT #odvPODataPdtTableDTTemp').html(aReturnData['tPOPdtAdvTableHtml']);
                        var aPOEndOfBill    = aReturnData['aPOEndOfBill'];
                        JSxPOSetFooterEndOfBill(aPOEndOfBill);
                        if($('#ohdPOStaImport').val()==1){
                            $('.xPOImportDT').show();
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
                JSvPOLoadPdtDataTableHtml(pnPage)
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
function JCNvPOBrowsePdt(){
    var tPOSplCode = $('#oetPOFrmSplCode').val();

    if(typeof(tPOSplCode) !== undefined && tPOSplCode !== ''){
        var aMulti = [];
        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                Qualitysearch   : [],
                 PriceType      : ["Cost","tCN_Cost","Company","1"],
                // 'PriceType' : ['Pricesell'],
                // 'PriceType' : ['Price4Cst',tPOPplCode],
                //'SelectTier' : ['PDT'],
                SelectTier      : ["Barcode"],
                //'Elementreturn'   : ['oetInputTestValue','oetInputTestName'],
                ShowCountRecord : 10,
                NextFunc: "FSvPONextFuncB4SelPDT", //FSvPOAddPdtIntoDocDTTemp
                ReturnType: "M",
                SPL: [$("#oetPOFrmSplCode").val(),$("#oetPOFrmSplCode").val()],
                BCH: [$("#oetPOFrmBchCode").val(),$("#oetPOFrmBchCode").val()],
                MCH: [$("#oetPOFrmMerCode").val(),$("#oetPOFrmMerCode").val()],
                SHP: [$("#oetPOFrmShpCode").val(), $("#oetPOFrmShpCode").val()],
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
    }else{
        var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
        FSvCMNSetMsgWarningDialog(tWarningMessage);
        return;
    }
}



// Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
// Parameters: Function Behind Edit In Line
// Creator: 02/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View Table Product Doc DT Temp
// ReturnType : View
function FSvPOEditPdtIntoTableDT(pnSeqNo, ptFieldName, ptValue, pbIsDelDTDis){
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if (typeof nStaSession !== "undefined" && nStaSession == 1){
        var tPODocNo        = $("#oetPODocNo").val();
        var tPOBchCode      = $("#oetPOFrmBchCode").val();
        var tPOVATInOrEx    = $('#ocmPOFrmSplInfoVatInOrEx').val();
        $.ajax({
            type: "POST",
            url: "docPOEditPdtIntoDTDocTemp",
            data: {
                'tPOBchCode'    : tPOBchCode,
                'tPODocNo'      : tPODocNo,
                'tPOVATInOrEx'  : tPOVATInOrEx,
                'nPOSeqNo'      : pnSeqNo,
                'tPOFieldName'  : ptFieldName,
                'tPOValue'      : ptValue,
                'nPOIsDelDTDis' : (pbIsDelDTDis) ? '1' : '0' // 1: ลบ, 2: ไม่ลบ
            },
            cache: false,
            timeout: 0,
            success: function (oResult){

                if(oResult == 'expire'){
                    JCNxShowMsgSessionExpired();
                }else{
                    JSvPOLoadPdtDataTableHtml();
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
function JSxPOSetStatusClickSubmit(pnStatus) {
    $("#ohdPOCheckSubmitByButton").val(pnStatus);
}

// Functionality: Add/Edit Document
// Parameters: Event Click Save Document
// Creator: 03/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: None
function JSxPOAddEditDocument(){
    // var nStaSession = JCNxFuncChkSessionExpired();
    var nStaSession = 1;
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        JSxPOValidateFormDocument();
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
function JSxPOValidateFormDocument(){
    if($("#ohdPOCheckClearValidate").val() != 0){
        $('#ofmPOFormAdd').validate().destroy();
    }

    $('#ofmPOFormAdd').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetPODocNo : {
                "required" : {
                    depends: function (oElement) {
                        if($("#ohdPORoute").val()  ==  "docPOEventAdd"){
                            if($('#ocbPOStaAutoGenCode').is(':checked')){
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
            oetPODocDate    : {"required" : true},
            oetPODocTime    : {"required" : true},
            oetPOFrmWahName : {"required" : true},
        },
        messages: {
            oetPODocNo      : {"required" : $('#oetPODocNo').attr('data-validate-required')},
            oetPODocDate    : {"required" : $('#oetPODocDate').attr('data-validate-required')},
            oetPODocTime    : {"required" : $('#oetPODocTime').attr('data-validate-required')},
            oetPOFrmWahName : {"required" : $('#oetPOFrmWahName').attr('data-validate-required')},
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
            if(!$('#ocbPOStaAutoGenCode').is(':checked')){
                JSxPOValidateDocCodeDublicate();
            }else{
                if($("#ohdPOCheckSubmitByButton").val() == 1){
                    JSxPOSubmitEventByButton();
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
function JSxPOValidateDocCodeDublicate(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            'tTableName'    : 'TAPTPoHD',
            'tFieldName'    : 'FTXphDocNo',
            'tCode'         : $('#oetPODocNo').val()
        },
        success: function (oResult) {
            var aResultData = JSON.parse(oResult);
            $("#ohdPOCheckDuplicateCode").val(aResultData["rtCode"]);

            if($("#ohdPOCheckClearValidate").val() != 1) {
                $('#ofmPOFormAdd').validate().destroy();
            }

            $.validator.addMethod('dublicateCode', function(value,element){
                if($("#ohdPORoute").val() == "docPOEventAdd"){
                    if($('#ocbPOStaAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdPOCheckDuplicateCode").val() == 1) {
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
            $('#ofmPOFormAdd').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetPODocNo : {"dublicateCode": {}}
                },
                messages: {
                    oetPODocNo : {"dublicateCode"  : $('#oetPODocNo').attr('data-validate-duplicate')}
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
                    if($("#ohdPOCheckSubmitByButton").val() == 1) {
                        JSxPOSubmitEventByButton();
                    }
                }
            })

            if($("#ohdPOCheckClearValidate").val() != 1) {
                $("#ofmPOFormAdd").submit();
                $("#ohdPOCheckClearValidate").val(1);
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
function JSxPOSubmitEventByButton(){
    if($("#ohdPORoute").val() !=  "docPOEventAdd"){
        var tPODocNo    = $('#oetPODocNo').val();
    }
    $.ajax({
        type: "POST",
        url: "docPOChkHavePdtForDocDTTemp",
        data: {
            'ptPODocNo': tPODocNo,
            'tPOSesSessionID'   : $('#ohdSesSessionID').val(),
            'tPOUsrCode'        : $('#ohdPOUsrCode').val(),
            'tPOLangEdit'       : $('#ohdPOLangEdit').val(),
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
                    url     : $("#ohdPORoute").val(),
                    data    : $("#ofmPOFormAdd").serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function(oResult){
                        JCNxCloseLoading();
                        var aDataReturnEvent    = JSON.parse(oResult);
                        if(aDataReturnEvent['nStaReturn'] == '1'){
                            var nPOStaCallBack      = aDataReturnEvent['nStaCallBack'];
                            var nPODocNoCallBack    = aDataReturnEvent['tCodeReturn'];
                            switch(nPOStaCallBack){
                                case '1' :
                                    JSvPOCallPageEditDoc(nPODocNoCallBack);
                                break;
                                case '2' :
                                    JSvPOCallPageAddDoc();
                                break;
                                case '3' :
                                    JSvPOCallPageList();
                                break;
                                default :
                                    JSvPOCallPageEditDoc(nPODocNoCallBack);
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
function JSxPOSubmitEventByButton(){
    JCNxOpenLoading();
    $('#obtPOSubmitFromDoc').attr('disabled',true);
    if($("#ohdPORoute").val() !=  "docPOEventAdd"){
        var tPODocNo    = $('#oetPODocNo').val();
    }
    $.ajax({
        type: "POST",
        url: "docPOChkHavePdtForDocDTTemp",
        data: {
            'ptPODocNo': tPODocNo,
            'tPOSesSessionID'   : $('#ohdSesSessionID').val(),
            'tPOUsrCode'        : $('#ohdPOUsrCode').val(),
            'tPOLangEdit'       : $('#ohdPOLangEdit').val(),
            'tSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aDataReturnChkTmp   = JSON.parse(oResult);
            if (aDataReturnChkTmp['nStaReturn'] == '1'){
                $.ajax({
                    type    : "POST",
                    url     : $("#ohdPORoute").val(),
                    data    : $("#ofmPOFormAdd").serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function(oResult){
                  
                        var aDataReturnEvent    = JSON.parse(oResult);
                        if(aDataReturnEvent['nStaReturn'] == '1'){
                            var nPOStaCallBack      = aDataReturnEvent['nStaCallBack'];
                            var nPODocNoCallBack    = aDataReturnEvent['tCodeReturn'];
                            $('#obtPOSubmitFromDoc').attr('disabled',false);
                            switch(nPOStaCallBack){
                                case '1' :
                                    JSvPOCallPageEditDoc(nPODocNoCallBack);
                                break;
                                case '2' :
                                    JSvPOCallPageAddDoc();
                                break;
                                case '3' :
                                    JSvPOCallPageList();
                                break;
                                default :
                                    JSvPOCallPageEditDoc(nPODocNoCallBack);
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
function JSvPOCallPageEditDoc(ptPODocNo){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML("JSvPOCallPageEditDoc",ptPODocNo);
        $.ajax({
            type: "POST",
            url: "docPOPageEdit",
            data: {'ptPODocNo' : ptPODocNo},
            cache: false,
            timeout: 0,
            success: function(tResult){
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    if(nPOStaBrowseType == '1') {
                        $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                        $('#odvModalBodyBrowse').html(aReturnData['tPOViewPageEdit']);
                    }else{
                        $('#odvPOContentPageDocument').html(aReturnData['tPOViewPageEdit']);
                        JCNxPOControlObjAndBtn();
                        JSvPOLoadPdtDataTableHtml();
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
function JCNxPOControlObjAndBtn(){
    // Check สถานะอนุมัติ
    var nPOStaDoc       = $("#ohdPOStaDoc").val();
    var nPOStaApv       = $("#ohdPOStaApv").val();
    var tPOStaDelMQ     = $('#ohdPOStaDelMQ').val();
    var tPOStaPrcStk    = $('#ohdPOStaPrcStk').val();

    JSxPONavDefultDocument();

    // Title Menu Set De
    $("#oliPOTitleAdd").hide();
    $('#oliPOTitleDetail').hide();
    $('#oliPOTitleAprove').hide();
    $('#oliPOTitleConimg').hide();
    $('#oliPOTitleEdit').show();
    $('#odvPOBtnGrpInfo').hide();
    // Button Menu
    $("#obtPOApproveDoc").show();
    $("#obtPOCancelDoc").show();
    $('#obtPOPrintDoc').show();
    $('#odvPOBtnGrpSave').show();
    $('#odvPOBtnGrpAddEdit').show();

    // Remove Disable
    $("#obtPOCancelDoc").attr("disabled",false);
    $("#obtPOApproveDoc").attr("disabled",false);
    $("#obtPOPrintDoc").attr("disabled",false);
    $("#obtPOBrowseSupplier").attr("disabled",false);

    $(".xWConditionSearchPdt").attr("disabled",false);
    $(".ocbListItem").attr("disabled",false);
    $(".xCNBtnDateTime").attr("disabled",false);
    $(".xCNDocBrowsePdt").attr("disabled",false).removeClass("xCNBrowsePdtdisabled");
    $(".xCNDocDrpDwn").show();
    $("#oetPOFrmSearchPdtHTML").attr("disabled", false);
    $(".xWBtnGrpSaveLeft").show();
    $(".xWBtnGrpSaveRight").show();
    $("#oliPOEditShipAddress").show();
    $("#oliPOEditTexAddress").show();

    if(nPOStaDoc != 1){
        // Hide/Show Menu Title 
        $("#oliPOTitleAdd").hide();
        $('#oliPOTitleEdit').hide();
        $('#oliPOTitleDetail').show();
        $('#oliPOTitleAprove').hide();
        $('#oliPOTitleConimg').hide();
        // Disabled Button
        $("#obtPOCancelDoc").hide(); // attr("disabled",true);
        $("#obtPOApproveDoc").hide(); // attr("disabled",true);
        $("#obtPOPrintDoc").hide(); // attr("disabled",true);
        $("#obtPOBrowseSupplier").attr("disabled",true);
        $(".xWConditionSearchPdt").attr("disabled",true);
        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetPOFrmSearchPdtHTML").attr("disabled",true);
        $('#odvPOBtnGrpSave').hide();
        // $(".xWBtnGrpSaveLeft").hide(); // attr("disabled", true);
        // $(".xWBtnGrpSaveRight").hide(); // attr("disabled", true);
        $("#oliPOEditShipAddress").hide();
        $("#oliPOEditTexAddress").hide();
        // Hide Button
        $("#obtPOCallPageAdd").hide();
        
        $("#ocbPOFrmInfoOthStaDocAct").attr("disabled",true);
        $("#obtPOFrmBrowseShipAdd").attr("disabled",true);
        $("#obtPOFrmBrowseTaxAdd").attr("disabled",true);
        
    }

    // Check Status Appove Success


    if(nPOStaDoc == 1 && nPOStaApv == 1 ){
        // Hide/Show Menu Title 
        $("#oliPOTitleAdd").hide();
        $('#oliPOTitleEdit').hide();
        $('#oliPOTitleDetail').show();
        $('#oliPOTitleAprove').hide();
        $('#oliPOTitleConimg').hide();
        // Hide And Disabled
        $("#obtPOCallPageAdd").hide();
        $("#obtPOCancelDoc").hide(); // attr("disabled",true);
        $("#obtPOApproveDoc").hide(); // attr("disabled",true);
        $("#obtPOBrowseSupplier").attr("disabled",true);
        $(".xWConditionSearchPdt").attr("disabled",true);

        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetPOFrmSearchPdtHTML").attr("disabled", false);
        $('#odvPOBtnGrpSave').hide();
        // $(".xWBtnGrpSaveLeft").hide(); // attr("disabled", true);
        // $(".xWBtnGrpSaveRight").hide(); // attr("disabled", true);
        $("#oliPOEditShipAddress").hide();
        $("#oliPOEditTexAddress").hide();
        // Show And Disabled
        $("#oliPOTitleDetail").show();
        
        $("#ocbPOFrmInfoOthStaDocAct").attr("disabled",true);
        $("#obtPOFrmBrowseShipAdd").attr("disabled",true);
        $("#obtPOFrmBrowseTaxAdd").attr("disabled",true);
    }
}

// Functionality: Cancel Document PI
// Parameters: Event Btn Click Call Edit Document
// Creator: 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Status Cancel Document
// ReturnType: object
function JSnPOCancelDocument(pbIsConfirm){
    var tPODocNo    = $("#oetPODocNo").val();
    if(pbIsConfirm){
        $.ajax({
            type: "POST",
            url: "docPOCancelDocument",
            data: {'ptPODocNo' : tPODocNo},
            cache: false,
            timeout: 0,
            success: function (tResult) {
                $("#odvPurchaseInviocePopupCancel").modal("hide");
                $('.modal-backdrop').remove();
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    JSvPOCallPageEditDoc(tPODocNo);
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
function JSxPOApproveDocument(pbIsConfirm){
    if(pbIsConfirm){
        $("#odvPOModalAppoveDoc").modal("hide");
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        var tPODocNo            = $("#oetPODocNo").val();
        var tPOBchCode          = $('#oetPOFrmBchCode').val();
        var tPOStaApv           = $("#ohdPOStaApv").val();
        var tPOSplPaymentType   = $("#ocmPOFrmSplInfoPaymentType").val();

        $.ajax({
            type : "POST",
            url : "docPOApproveDocument",
            data: {
                'ptPODocNo'             : tPODocNo,
                'ptPOBchCode'           : tPOBchCode,
                'ptPOStaApv'            : tPOStaApv,
                'ptPOSplPaymentType'    : tPOSplPaymentType
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                console.log(tResult);
                try {
                    let oResult = JSON.parse(tResult);
                    if (oResult.nStaEvent == "1") {
                    //  FSvCMNSetMsgSucessDialog(oResult.tStaMessg);
                     JSvPOCallPageEditDoc(tPODocNo);
                        }else{
                     FSvCMNSetMsgWarningDialog(oResult.tStaMessg);
                    }
                    // if (oResult.nStaEvent == "900") {
                    //     FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                    // }
                } catch (err) {}
                // JSoPOCallSubscribeMQ();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        $('#odvPOModalAppoveDoc').modal({backdrop:'static',keyboard:false});
        $("#odvPOModalAppoveDoc").modal("show");
    }
}

// Functionality : Call Data Subscript Document
// Parameters : Event Click Buttom
// Creator : 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : Status Applove Document
// Return Type : -
function JSoPOCallSubscribeMQ() {
    // RabbitMQ
    /*===========================================================================*/
    // Document variable
    var tLangCode   = $("#ohdPOLangEdit").val();
    var tUsrBchCode = $("#oetPOFrmBchCode").val();
    var tUsrApv     = $("#ohdPOApvCodeUsrLogin").val();
    var tDocNo      = $("#oetPODocNo").val();
    var tPrefix     = "RESPPI";
    var tStaApv     = $("#ohdPOStaApv").val();
    var tStaDelMQ   = $("#ohdPOStaDelMQ").val();
    var tQName      = tPrefix + "_" + tDocNo + "_" + tUsrApv;

    // MQ Message Config
    // var poDocConfig = {
    //     tLangCode   : tLangCode,
    //     tUsrBchCode : tUsrBchCode,
    //     tUsrApv     : tUsrApv,
    //     tDocNo      : tDocNo,
    //     tPrefix     : tPrefix,
    //     tStaDelMQ   : tStaDelMQ,
    //     tStaApv     : tStaApv,
    //     tQName      : tQName
    // };

    // RabbitMQ STOMP Config
    // var poMqConfig = {
    //     host: "ws://" + oSTOMMQConfig.host + ":15674/ws",
    //     username: oSTOMMQConfig.user,
    //     password: oSTOMMQConfig.password,
    //     vHost: oSTOMMQConfig.vhost
    // };

    // Update Status For Delete Qname Parameter
    // var poUpdateStaDelQnameParams = {
    //     ptDocTableName      : "TARTPoHD",
    //     ptDocFieldDocNo     : "FTXshDocNo",
    //     ptDocFieldStaApv    : "FTXphStaPrcStk",
    //     ptDocFieldStaDelMQ  : "FTXphStaDelMQ",
    //     ptDocStaDelMQ       : tStaDelMQ,
    //     ptDocNo             : tDocNo
    // };

    // Callback Page Control(function)
    // var poCallback = {
    //     tCallPageEdit: "JSvPOCallPageEditDoc",
    //     tCallPageList: "JSvPOCallPageList"
    // };

    // Check Show Progress %
    // FSxCMNRabbitMQMessage(poDocConfig,poMqConfig,poUpdateStaDelQnameParams,poCallback);
}

// Functionality : Call Data Subscript Document
// Parameters : Event Click Buttom
// Creator : 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : Status Applove Document
// Return Type :
function JSvPODOCFilterPdtInTableTemp(){
    JCNxOpenLoading();
    JSvPOLoadPdtDataTableHtml();
}

// Functionality : Function Check Data Search And Add In Tabel DT Temp
// Parameters : Event Click Buttom
// Creator : 30/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : 
// Return Type : Filter
function JSxPOChkConditionSearchAndAddPdt(){
    var tPODataSearchAndAdd =   $("#oetPOFrmSearchAndAddPdtHTML").val();
    if(tPODataSearchAndAdd != undefined && tPODataSearchAndAdd != ""){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var tPODataSearchAndAdd = $("#oetPOFrmSearchAndAddPdtHTML").val();
            var tPODocNo            = $('#oetPODocNo').val();
            var tPOBchCode          = $("#oetPOFrmBchCode").val();
            var tPOStaReAddPdt      = $("#ocmPOFrmInfoOthReAddPdt").val();
            $.ajax({
                type: "POST",
                url: "docPOSerachAndAddPdtIntoTbl",
                data:{
                    'ptPOBchCode'           : tPOBchCode,
                    'ptPODocNo'             : tPODocNo,
                    'ptPODataSearchAndAdd'  : tPODataSearchAndAdd,
                    'ptPOStaReAddPdt'       : tPOStaReAddPdt,
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
function JSvPOClickPageList(ptPage){
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
    JSvPOCallPageDataTable(nPageCurrent);
}


//Next page
function JSvPOPDTDocDTTempClickPage(ptPage) {
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
        JSvPOLoadPdtDataTableHtml(nPageCurrent);
    } else {
        JCNxShowMsgSessionExpired();
    }
}



// Functionality: Call End Of Bill OnChange Vat
// Parameters: Function Ajax Success
// Creator: 22/02/2021
// LastUpdate: -
// Return: View
// ReturnType : View
function JSvPOCallEndOfBill(pnType){
    if($("#ohdPORoute").val() == "docPOEventAdd"){
        var tPODocNo    = "";
    }else{
        var tPODocNo    = $("#oetPODocNo").val();
    }

    var tPOStaApv       = $("#ohdPOStaApv").val();
    var tPOStaDoc       = $("#ohdPOStaDoc").val();
    var tPOVATInOrEx    = $("#ocmPOFrmSplInfoVatInOrEx").val();

    $.ajax({
        type: "POST",
        url: "docPOEventCallEndOfBill",
        data: {
            'tSelectBCH'        : $('#oetPOFrmBchCode').val(),
            'ptPODocNo'             : tPODocNo,
            'ptPOStaApv'            : tPOStaApv,
            'ptPOStaDoc'            : tPOStaDoc,
            'ptPOVATInOrEx'         : tPOVATInOrEx
        },
        cache: false,
        Timeout: 0,
        success: function (oResult){
            var aReturnData = JSON.parse(oResult);

                if(aReturnData['nStaEvent'] == '1') {
                    JCNxOpenLoading();
                    JSvPOLoadPdtDataTableHtml();
                    var aPOEndOfBill    = aReturnData['aPOEndOfBill'];
                    JSxPOSetFooterEndOfBill(aPOEndOfBill);
                    // JCNxCloseLoading();
                }else{
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // JSvPOCallEndOfBill(pnPage)
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

