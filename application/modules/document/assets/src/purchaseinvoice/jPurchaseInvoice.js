var nPIStaPIBrowseType     = $("#oetPIStaBrowse").val();
var tPICallPIBackOption    = $("#oetPICallBackOption").val();

$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    if(typeof(nPIStaPIBrowseType) != 'undefined' && nPIStaPIBrowseType == 0){
        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliPITitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPICallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtPICallPageAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPICallPageAddDoc();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Call Back Page
        $('#obtPICallBackPage').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPICallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Cancel Document
        $('#obtPICancelDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSnPICancelDocument(false);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Appove Document
        $('#obtPIApproveDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxPISetStatusClickSubmit(2);
                JSxPIApproveDocument(false);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From Document
        $('#obtPISubmitFromDoc').unbind().click(function(){
            var nStaSession = 1;
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                var tFrmSplName =  $('#oetPIFrmSplName').val();
                var tCheckIteminTable = $('#otbPIDocPdtAdvTableList .xWPdtItem').length;
                var nPIStaValidate =  $('.xPIStaValidate0').length;

                if(tCheckIteminTable>0){
                    if(nPIStaValidate==0){
                        if(tFrmSplName!=''){
                            JSxPISetStatusClickSubmit(1);
                            $('#obtPISubmitDocument').click();
                        }else{
                            $('#odvPIModalPleseselectCustomer').modal('show');
                        }
                    }else{
                        FSvCMNSetMsgWarningDialog($('#ohdPIValidatePdtImp').val());
                    }
                }else{
                    FSvCMNSetMsgWarningDialog($('#ohdPIValidatePdt').val());
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JSxPINavDefultDocument();
        JSvPICallPageList();
    }else{
        // Event Modal Call Back Before List
        $('#oahPIBrowseCallBack').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tPICallPIBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Modal Call Back Previous
        $('#oliPIBrowsePrevious').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tPICallPIBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtPIBrowseSubmit').unbind().click(function () {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxPISetStatusClickSubmit(1);
                $('#obtPISubmitDocument').click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JSxPINavDefultDocument();
        JSvPICallPageAddDoc();
    }
});

// Function     : Set Defult Nav Menu Document
// Parameters   : Document Ready Or Parameter Event
// Creator      : 17/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate   :
// Return       : Set Default Nav Menu Document
// ReturnType   : -
function JSxPINavDefultDocument(){
    if(typeof(nPIStaPIBrowseType) != 'undefined' && nPIStaPIBrowseType == 0) {
        // Title Label Hide/Show
        $('#oliPITitleAdd').hide();
        $('#oliPITitleEdit').hide();
        $('#oliPITitleDetail').hide();
        // Button Hide/Show
        $('#odvPIBtnGrpAddEdit').hide();
        $('#odvPIBtnGrpInfo').show();
        $('#obtPICallPageAdd').show();
    }else{
        $('#odvModalBody #odvPIMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPINavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPIBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPIBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPIBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function     : Call Page List
// Parameters   : Document Redy Function
// Creator      : 17/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate   :
// Return       : Call View Tranfer Out List
// ReturnType   : View
function JSvPICallPageList(){
    $.ajax({
        type: "GET",
        url: "dcmPIFormSearchList",
        cache: false,
        timeout: 0,
        success: function (tResult){
            $("#odvPIContentPageDocument").html(tResult);
            JSxPINavDefultDocument();
            JSvPICallPageDataTable();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function     : Get Data Advanced Search
// Parameters   : Function Call Page
// Creator      : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate   : -
// Return       : object Data Advanced Search
// ReturnType   : object
function JSoPIGetAdvanceSearchData(){
    var oAdvanceSearchData  = {
        tSearchAll          : $("#oetPISearchAllDocument").val(),
        tSearchBchCodeFrom  : $("#oetPIAdvSearchBchCodeFrom").val(),
        tSearchBchCodeTo    : $("#oetPIAdvSearchBchCodeTo").val(),
        tSearchDocDateFrom  : $("#oetPIAdvSearcDocDateFrom").val(),
        tSearchDocDateTo    : $("#oetPIAdvSearcDocDateTo").val(),
        tSearchStaDoc       : $("#ocmPIAdvSearchStaDoc").val(),
        tSearchStaApprove   : $("#ocmPIAdvSearchStaApprove").val(),
        tSearchStaPrcStk    : $("#ocmPIAdvSearchStaPrcStk").val(),
        tSearchStaDocAct    : $("#ocmCardNewCardStaDocAct").val()
    };
    return oAdvanceSearchData;
}

// Function     : Call Page List
// Parameters   : Document Redy Function
// Creator      : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate   :
// Return       : Call View Tabel Data List Document
// ReturnType   : View
function JSvPICallPageDataTable(pnPage){
    JCNxOpenLoading();
    var oAdvanceSearch  = JSoPIGetAdvanceSearchData();
    var nPageCurrent = pnPage;
    if(typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type: "POST",
        url: "dcmPIDataTable",
        data: {
            oAdvanceSearch  : oAdvanceSearch,
            nPageCurrent    : nPageCurrent,
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxPINavDefultDocument();
                $('#ostPIDataTableDocument').html(aReturnData['tPIViewDataTableList']);
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

//Functionality : Function Chack And Show Button Delete All
//Parameters    : LocalStorage Data
//Creator       : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
//Return        : Show Button Delete All
//Return Type   : -
function JSxPIShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliPIBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliPIBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliPIBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality  : Insert Text In Modal Delete
//Functionality  : LocalStorage Data
//Creator        : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
//Return         : Insert Code In Text Input
//Return Type    : -
function JSxPITextinModal() {
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
        $("#odvPIModalDelDocMultiple #ospTextConfirmDelMultiple").text($('#oetTextComfirmDeleteMulti').val());
        $("#odvPIModalDelDocMultiple #ohdConfirmIDDelMultiple").val(tTextCode);
    }
}

//Functionality  : Function Chack Value LocalStorage
//Functionality  : Event Select List Branch
//Creator        : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
//Return         : Duplicate/none
//Return Type    : string
function JStPIFindObjectByKey(array, key, value) {
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
function JSvPIClickPage(ptPage) {
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
        JSvPICallPageDataTable(nPageCurrent);
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
function JSoPIDelDocSingle(ptCurrentPage, ptPIDocNo){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        if(typeof(ptPIDocNo) != undefined && ptPIDocNo != ""){
            var tTextConfrimDelSingle   = $('#oetTextComfirmDeleteSingle').val()+"&nbsp"+ptPIDocNo+"&nbsp"+$('#oetTextComfirmDeleteYesOrNot').val();
            $('#odvPIModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
            $('#odvPIModalDelDocSingle').modal('show');
            $('#odvPIModalDelDocSingle #osmConfirmDelSingle').unbind().click(function(){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmPIEventDelete",
                    data: {'tDataDocNo' : ptPIDocNo},
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1') {
                            $('#odvPIModalDelDocSingle').modal('hide');
                            $('#odvPIModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function () {
                                JSvPICallPageDataTable(ptCurrentPage);
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
function JSoPIDelDocMultiple(){
    var aDataDelMultiple    = $('#odvPIModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
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
            url: "dcmPIEventDelete",
            data: {'tDataDocNo' : aNewIdDelete},
            cache: false,
            timeout: 0,
            success: function (oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    setTimeout(function () {
                        $('#odvPIModalDelDocMultiple').modal('hide');
                        $('#odvPIModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                        $('#odvPIModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                        $('.modal-backdrop').remove();
                        localStorage.removeItem('LocalItemData');
                        JSvPICallPageList();
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
function JSvPICallPageAddDoc(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "dcmPIPageAdd",
        cache: false,
        timeout: 0,
        success: function (oResult) {
            var aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1') {
                if (nPIStaPIBrowseType == '1') {
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tPIViewPageAdd']);
                } else {
                    // Hide Title Menu And Button
                    $('#oliPITitleEdit').hide();
                    $('#oliPITitleDetail').hide();
                    $("#obtPIApproveDoc").hide();
                    $("#obtPICancelDoc").hide();
                    $('#obtPIPrintDoc').hide();
                    $('#odvPIBtnGrpInfo').hide();
                    // Show Title Menu And Button
                    $('#oliPITitleAdd').show();
                    $('#odvPIBtnGrpSave').show();
                    $('#odvPIBtnGrpAddEdit').show();

                    // Remove Disable Button Add
                    $(".xWBtnGrpSaveLeft").attr("disabled",false);
                    $(".xWBtnGrpSaveRight").attr("disabled",false);

                    $('#odvPIContentPageDocument').html(aReturnData['tPIViewPageAdd']);
                    // $('#obtPIBrowseShop').attr('disabled', true);
                }
                JSvPILoadPdtDataTableHtml();
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
function JSvPILoadPdtDataTableHtml(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        if($("#ohdPIRoute").val() == "dcmPIEventAdd"){
            var tPIDocNo    = "";
        }else{
            var tPIDocNo    = $("#oetPIDocNo").val();
        }

        var tPIStaApv       = $("#ohdPIStaApv").val();
        var tPIStaDoc       = $("#ohdPIStaDoc").val();
        var tPIVATInOrEx    = $("#ocmPIFrmSplInfoVatInOrEx").val();

        //เช็ค สินค้าใน table หน้านั้นๆ หรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
        if ($("#otbPIDocPdtAdvTableList .xWPdtItem").length == 0){
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
        var tSearchPdtAdvTable  = $('#oetPIFrmFilterPdtHTML').val();

        $.ajax({
            type: "POST",
            url: "dcmPIPdtAdvanceTableLoadData",
            data: {
                'tBCHCode'              : $('#oetPIFrmBchCode').val(),
                'ptSearchPdtAdvTable'   : tSearchPdtAdvTable,
                'ptPIDocNo'             : tPIDocNo,
                'ptPIStaApv'            : tPIStaApv,
                'ptPIStaDoc'            : tPIStaDoc,
                'ptPIVATInOrEx'         : tPIVATInOrEx,
                'pnPIPageCurrent'       : nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1') {
                    $('#odvPIDataPanelDetailPDT #odvPIDataPdtTableDTTemp').html(aReturnData['tPIPdtAdvTableHtml']);
                    var aPIEndOfBill    = aReturnData['aPIEndOfBill'];
                    JSxPISetFooterEndOfBill(aPIEndOfBill);
                    if($('#ohdPIStaImport').val()==1){
                        $('.xPIImportDT').show();
                    }
                    JCNxCloseLoading();
                   var nPIStaWaitScanOn = $('#ohdPIStaWaitScanOn').val();
                   var nWiatScanBarCode = $('.ohdWiatScanBarCode').length;
              
                    if(nPIStaWaitScanOn==1 && nWiatScanBarCode>0){
                       var tTextWaitScan = $('.ohdWiatScanBarCode').first().val();
                        JCNSearchBarcodePdt(tTextWaitScan);
                        // $('#ohdWiatScanBarCode'+tTextWaitScan).remove();
                    }

                    if(nWiatScanBarCode==0){
                        $('#ohdPIStaWaitScanOn').val(0);
                    }

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

// Functionality: Add Product Into Table Document DT Temp
// Parameters   : Function Ajax Success
// Creator      : 01/07/2019 Wasin(Yoshi)
// LastUpdate   : -
// Return       : View
// ReturnType   : View
function JCNvPIBrowsePdt(){
    var tPISplCode = $('#oetPIFrmSplCode').val();
    // if(typeof(tPISplCode) !== undefined && tPISplCode !== ''){
    // var aMulti = [];

    var tWhereCondition = "";
    // if( tPISplCode != "" ){
    //     tWhereCondition = " AND FTPdtSetOrSN IN('1','3') ";
    // }

    $.ajax({
        type: "POST",
        url: "BrowseDataPDT",
        data: {
            Qualitysearch   : [],
            PriceType       : ["Cost","tCN_Cost","Company","1"],
            SelectTier      : ["Barcode"],
            ShowCountRecord : 10,
            NextFunc        : "FSvPINextFuncB4SelPDT",
            ReturnType      : "M",
            SPL             : [$("#oetPIFrmSplCode").val(),$("#oetPIFrmSplCode").val()],
            BCH             : [$("#oetPIFrmBchCode").val(),$("#oetPIFrmBchCode").val()],
            MCH             : [$("#oetPIFrmMerCode").val(),$("#oetPIFrmMerCode").val()],
            SHP             : [$("#oetPIFrmShpCode").val(), $("#oetPIFrmShpCode").val()],
            Where           : [tWhereCondition]
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
function FSvPIEditPdtIntoTableDT(pnSeqNo, ptFieldName, ptValue, pbIsDelDTDis){
    // var nStaSession = JCNxFuncChkSessionExpired();
    // var  nStaSession = 1;
    // if (typeof nStaSession !== "undefined" && nStaSession == 1){
        var tPIDocNo        = $("#oetPIDocNo").val();
        var tPIBchCode      = $("#oetPIFrmBchCode").val();
        var tPIVATInOrEx    = $('#ocmPIFrmSplInfoVatInOrEx').val();
        $.ajax({
            type: "POST",
            url: "dcmPIEditPdtIntoDTDocTemp",
            data: {
                'tPIBchCode'    : tPIBchCode,
                'tPIDocNo'      : tPIDocNo,
                'tPIVATInOrEx'  : tPIVATInOrEx,
                'nPISeqNo'      : pnSeqNo,
                'tPIFieldName'  : ptFieldName,
                'tPIValue'      : ptValue,
                'nPIIsDelDTDis' : (pbIsDelDTDis) ? '1' : '0' // 1: ลบ, 2: ไม่ลบ
            },
            cache: false,
            timeout: 0,
            success: function (oResult){

                if(oResult == 'expire'){
                    JCNxShowMsgSessionExpired();
                }else{
                    JSvPILoadPdtDataTableHtml();
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
function JSxPISetStatusClickSubmit(pnStatus) {
    $("#ohdPICheckSubmitByButton").val(pnStatus);
}

// Functionality: Add/Edit Document
// Parameters: Event Click Save Document
// Creator: 03/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: None
function JSxPIAddEditDocument(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        JSxPIValidateFormDocument();
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
function JSxPIValidateFormDocument(){
    if($("#ohdPICheckClearValidate").val() != 0){
        $('#ofmPIFormAdd').validate().destroy();
    }

    $('#ofmPIFormAdd').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetPIDocNo : {
                "required" : {
                    depends: function (oElement) {
                        if($("#ohdPIRoute").val()  ==  "dcmPIEventAdd"){
                            if($('#ocbPIStaAutoGenCode').is(':checked')){
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
            oetPIDocDate    : {"required" : true},
            oetPIDocTime    : {"required" : true},
            oetPIFrmWahName : {"required" : true},
        },
        messages: {
            oetPIDocNo      : {"required" : $('#oetPIDocNo').attr('data-validate-required')},
            oetPIDocDate    : {"required" : $('#oetPIDocDate').attr('data-validate-required')},
            oetPIDocTime    : {"required" : $('#oetPIDocTime').attr('data-validate-required')},
            oetPIFrmWahName : {"required" : $('#oetPIFrmWahName').attr('data-validate-required')},
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
            if(!$('#ocbPIStaAutoGenCode').is(':checked')){
                JSxPIValidateDocCodeDublicate();
            }else{
                if($("#ohdPICheckSubmitByButton").val() == 1){
                    JSxPISubmitEventByButton();
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
function JSxPIValidateDocCodeDublicate(){
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            'tTableName'    : 'TAPTPiHD',
            'tFieldName'    : 'FTXphDocNo',
            'tCode'         : $('#oetPIDocNo').val()
        },
        success: function (oResult) {
            var aResultData = JSON.parse(oResult);
            $("#ohdPICheckDuplicateCode").val(aResultData["rtCode"]);

            if($("#ohdPICheckClearValidate").val() != 1) {
                $('#ofmPIFormAdd').validate().destroy();
            }

            $.validator.addMethod('dublicateCode', function(value,element){
                if($("#ohdPIRoute").val() == "dcmPIEventAdd"){
                    if($('#ocbPIStaAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdPICheckDuplicateCode").val() == 1) {
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
            $('#ofmPIFormAdd').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetPIDocNo : {"dublicateCode": {}}
                },
                messages: {
                    oetPIDocNo : {"dublicateCode"  : $('#oetPIDocNo').attr('data-validate-duplicate')}
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
                    if($("#ohdPICheckSubmitByButton").val() == 1) {
                        JSxPISubmitEventByButton();
                    }
                }
            })

            if($("#ohdPICheckClearValidate").val() != 1) {
                $("#ofmPIFormAdd").submit();
                $("#ohdPICheckClearValidate").val(1);
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
function JSxPISubmitEventByButton(){
    if($("#ohdPIRoute").val() !=  "dcmPIEventAdd"){
        var tPIDocNo    = $('#oetPIDocNo').val();
    }
    $.ajax({
        type: "POST",
        url: "dcmPIChkHavePdtForDocDTTemp",
        data: {'ptPIDocNo': tPIDocNo},
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aDataReturnChkTmp   = JSON.parse(oResult);
            if (aDataReturnChkTmp['nStaReturn'] == '1'){
                $.ajax({
                    type    : "POST",
                    url     : $("#ohdPIRoute").val(),
                    data    : $("#ofmPIFormAdd").serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function(oResult){
                        var aDataReturnEvent    = JSON.parse(oResult);
                        if(aDataReturnEvent['nStaReturn'] == '1'){
                            var nPIStaCallBack      = aDataReturnEvent['nStaCallBack'];
                            var nPIDocNoCallBack    = aDataReturnEvent['tCodeReturn'];
                            switch(nPIStaCallBack){
                                case '1' :
                                    JSvPICallPageEditDoc(nPIDocNoCallBack);
                                break;
                                case '2' :
                                    JSvPICallPageAddDoc();
                                break;
                                case '3' :
                                    JSvPICallPageList();
                                break;
                                default :
                                    JSvPICallPageEditDoc(nPIDocNoCallBack);
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
function JSvPICallPageEditDoc(ptPIDocNo){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML("JSvPICallPageEditDoc",ptPIDocNo);
        $.ajax({
            type: "POST",
            url: "dcmPIPageEdit",
            data: {'ptPIDocNo' : ptPIDocNo},
            cache: false,
            timeout: 0,
            success: function(tResult){
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    if(nPIStaPIBrowseType == '1') {
                        $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                        $('#odvModalBodyBrowse').html(aReturnData['tPIViewPageEdit']);
                    }else{
                        $('#odvPIContentPageDocument').html(aReturnData['tPIViewPageEdit']);
                        JCNxPIControlObjAndBtn();
                        JSvPILoadPdtDataTableHtml();
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
function JCNxPIControlObjAndBtn(){
    // Check สถานะอนุมัติ
    var nPIStaDoc       = $("#ohdPIStaDoc").val();
    var nPIStaApv       = $("#ohdPIStaApv").val();
    var tPIStaDelMQ     = $('#ohdPIStaDelMQ').val();
    var tPIStaPrcStk    = $('#ohdPIStaPrcStk').val();

    JSxPINavDefultDocument();

    // Title Menu Set De
    $("#oliPITitleAdd").hide();
    $('#oliPITitleDetail').hide();
    $('#oliPITitleEdit').show();
    $('#odvPIBtnGrpInfo').hide();
    // Button Menu
    $("#obtPIApproveDoc").show();
    $("#obtPICancelDoc").show();
    $('#obtPIPrintDoc').show();
    $('#odvPIBtnGrpSave').show();
    $('#odvPIBtnGrpAddEdit').show();

    // Remove Disable
    $("#obtPICancelDoc").attr("disabled",false);
    $("#obtPIApproveDoc").attr("disabled",false);
    $("#obtPIPrintDoc").attr("disabled",false);
    $("#obtPIBrowseSupplier").attr("disabled",false);

    $(".xWConditionSearchPdt").attr("disabled",false);
    $(".ocbListItem").attr("disabled",false);
    $(".xCNBtnDateTime").attr("disabled",false);
    $(".xCNDocBrowsePdt").attr("disabled",false).removeClass("xCNBrowsePdtdisabled");
    $(".xCNDocDrpDwn").show();
    $("#oetPIFrmSearchPdtHTML").attr("disabled", false);
    $(".xWBtnGrpSaveLeft").show();
    $(".xWBtnGrpSaveRight").show();
    $("#oliPIEditShipAddress").show();
    $("#oliPIEditTexAddress").show();

    if(nPIStaDoc != 1){
        // Hide/Show Menu Title
        $("#oliPITitleAdd").hide();
        $('#oliPITitleEdit').hide();
        $('#oliPITitleDetail').show();
        // Disabled Button
        $("#obtPICancelDoc").hide(); // attr("disabled",true);
        $("#obtPIApproveDoc").hide(); // attr("disabled",true);
        $("#obtPIPrintDoc").hide(); // attr("disabled",true);
        $("#obtPIBrowseSupplier").attr("disabled",true);
        $(".xWConditionSearchPdt").attr("disabled",true);
        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetPIFrmSearchPdtHTML").attr("disabled",true);
        $('#odvPIBtnGrpSave').hide();
        // $(".xWBtnGrpSaveLeft").hide(); // attr("disabled", true);
        // $(".xWBtnGrpSaveRight").hide(); // attr("disabled", true);
        $("#oliPIEditShipAddress").hide();
        $("#oliPIEditTexAddress").hide();
        // Hide Button
        $("#obtPICallPageAdd").hide();

        $("#ocbPIFrmInfoOthStaDocAct").attr("disabled", true);
        $('.xWDropdown').attr('disabled',true);
    }

    // Check Status Appove Success
    if(nPIStaDoc == 1 && nPIStaApv == 1 && tPIStaDelMQ == 1 && tPIStaPrcStk == 1){
        // Hide/Show Menu Title
        $("#oliPITitleAdd").hide();
        $('#oliPITitleEdit').hide();
        $('#oliPITitleDetail').show();

        // Hide And Disabled
        $("#obtPICallPageAdd").hide();
        $("#obtPICancelDoc").hide(); // attr("disabled",true);
        $("#obtPIApproveDoc").hide(); // attr("disabled",true);
        $("#obtPIBrowseSupplier").attr("disabled",true);
        $(".xWConditionSearchPdt").attr("disabled",true);

        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetPIFrmSearchPdtHTML").attr("disabled", false);
        $('#odvPIBtnGrpSave').hide();
        // $(".xWBtnGrpSaveLeft").hide(); // attr("disabled", true);
        // $(".xWBtnGrpSaveRight").hide(); // attr("disabled", true);
        $("#oliPIEditShipAddress").hide();
        $("#oliPIEditTexAddress").hide();
        // Show And Disabled
        $("#oliPITitleDetail").show();

        $("#ocbPIFrmInfoOthStaDocAct").attr("disabled", true);
        $('.xWDropdown').attr('disabled',true);
    }
}

// Functionality: Cancel Document PI
// Parameters: Event Btn Click Call Edit Document
// Creator: 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Status Cancel Document
// ReturnType: object
function JSnPICancelDocument(pbIsConfirm){
    var tPIDocNo    = $("#oetPIDocNo").val();
    if(pbIsConfirm){
        $.ajax({
            type: "POST",
            url: "dcmPICancelDocument",
            data: {'ptPIDocNo' : tPIDocNo},
            cache: false,
            timeout: 0,
            success: function (tResult) {
                $("#odvPurchaseInviocePopupCancel").modal("hide");
                $('.modal-backdrop').remove();
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    JSvPICallPageEditDoc(tPIDocNo);
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
function JSxPIApproveDocument(pbIsConfirm){
    if(pbIsConfirm){
        $("#odvPIModalAppoveDoc").modal("hide");
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        var tPIDocNo            = $("#oetPIDocNo").val();
        var tPIBchCode          = $('#oetPIFrmBchCode').val();
        var tPIStaApv           = $("#ohdPIStaApv").val();
        var tPISplPaymentType   = $("#ocmPIFrmSplInfoPaymentType").val();

        $.ajax({
            type : "POST",
            url : "dcmPIApproveDocument",
            data: {
                'ptPIDocNo'             : tPIDocNo,
                'ptPIBchCode'           : tPIBchCode,
                'ptPIStaApv'            : tPIStaApv,
                'ptPISplPaymentType'    : tPISplPaymentType
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                console.log(tResult);
                try {
                    let oResult = JSON.parse(tResult);
                    if (oResult.nStaEvent == "900") {
                        FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                    }
                } catch (err) {}
                JSoPICallSubscribeMQ();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        $('#odvPIModalAppoveDoc').modal({backdrop:'static',keyboard:false});
        $("#odvPIModalAppoveDoc").modal("show");
    }
}

// Functionality : Call Data Subscript Document
// Parameters : Event Click Buttom
// Creator : 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : Status Applove Document
// Return Type : -
function JSoPICallSubscribeMQ() {
    // RabbitMQ
    /*===========================================================================*/
    // Document variable
    var tLangCode   = $("#ohdPILangEdit").val();
    var tUsrBchCode = $("#oetPIFrmBchCode").val();
    var tUsrApv     = $("#ohdPIApvCodeUsrLogin").val();
    var tDocNo      = $("#oetPIDocNo").val();
    var tPrefix     = "RESPPI";
    var tStaApv     = $("#ohdPIStaApv").val();
    var tStaDelMQ   = $("#ohdPIStaDelMQ").val();
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
        ptDocTableName      : "TAPTPiHD",
        ptDocFieldDocNo     : "FTXphDocNo",
        ptDocFieldStaApv    : "FTXphStaPrcStk",
        ptDocFieldStaDelMQ  : "FTXphStaDelMQ",
        ptDocStaDelMQ       : tStaDelMQ,
        ptDocNo             : tDocNo
    };

    // Callback Page Control(function)
    var poCallback = {
        tCallPageEdit: "JSvPICallPageEditDoc",
        tCallPageList: "JSvPICallPageList"
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
function JSvPIDOCFilterPdtInTableTemp(){
    JCNxOpenLoading();
    JSvPILoadPdtDataTableHtml();
}

// Functionality : Function Check Data Search And Add In Tabel DT Temp
// Parameters : Event Click Buttom
// Creator : 30/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return :
// Return Type : Filter
function JSxPIChkConditionSearchAndAddPdt(){
    var tPIDataSearchAndAdd =   $("#oetPIFrmSearchAndAddPdtHTML").val();
    if(tPIDataSearchAndAdd != undefined && tPIDataSearchAndAdd != ""){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var tPIDataSearchAndAdd = $("#oetPIFrmSearchAndAddPdtHTML").val();
            var tPIDocNo            = $('#oetPIDocNo').val();
            var tPIBchCode          = $("#oetPIFrmBchCode").val();
            var tPIStaReAddPdt      = $("#ocmPIFrmInfoOthReAddPdt").val();
            $.ajax({
                type: "POST",
                url: "dcmPISerachAndAddPdtIntoTbl",
                data:{
                    'ptPIBchCode'           : tPIBchCode,
                    'ptPIDocNo'             : tPIDocNo,
                    'ptPIDataSearchAndAdd'  : tPIDataSearchAndAdd,
                    'ptPIStaReAddPdt'       : tPIStaReAddPdt,
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
function JSvPIClickPageList(ptPage){
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
    JSvPICallPageDataTable(nPageCurrent);
}

//Next page
function JSvPIPDTDocDTTempClickPage(ptPage) {
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
        JSvPILoadPdtDataTableHtml(nPageCurrent);
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
function JSvPICallEndOfBill(pnPage){
    if($("#ohdPIRoute").val() == "docPIEventAdd"){
        var tPIDocNo    = "";
    }else{
        var tPIDocNo    = $("#oetPIDocNo").val();
    }

    var tPIStaApv       = $("#ohdPIStaApv").val();
    var tPIStaDoc       = $("#ohdPIStaDoc").val();
    var tPIVATInOrEx    = $("#ocmPIFrmSplInfoVatInOrEx").val();

    $.ajax({
        type: "POST",
        url: "docPIEventCallEndOfBill",
        data :{
            'tSelectBCH'        : $('#oetPIFrmBchCode').val(),
            'ptPIDocNo'         : tPIDocNo,
            'ptPIStaApv'        : tPIStaApv,
            'ptPIStaDoc'        : tPIStaDoc,
            'ptPIVATInOrEx'     : tPIVATInOrEx
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1'){
                JCNxOpenLoading();
                JSvPILoadPdtDataTableHtml();
                var aPIEndOfBill    = aReturnData['aPIEndOfBill'];
                JSxPISetFooterEndOfBill(aPIEndOfBill);
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
