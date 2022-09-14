var nSOStaSOBrowseType     = $("#oetSOStaBrowse").val();
var tSOCallSOBackOption    = $("#oetSOCallBackOption").val();
var tSOSesSessionID        = $("#ohdSesSessionID").val();

$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    if(typeof(nSOStaSOBrowseType) != 'undefined' && nSOStaSOBrowseType == 0){
        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliSOTitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvSOCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtSOCallPageAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvSOCallPageAddDoc();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Call Back Page
        $('#obtSOCallBackPage').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvSOCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Cancel Document
        $('#obtSOCancelDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSnSOCancelDocument(false);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Appove Document
        $('#obtSOApproveDoc').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                var tCheckIteminTable = $('#otbSODocPdtAdvTableList .xWPdtItem').length;
                if(tCheckIteminTable>0){
                JSxSOSetStatusClickSubmit(2);
                JSxSOApproveDocument(false);
                }else{
                    FSvCMNSetMsgWarningDialog($('#ohdSOValidatePdt').val());
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From Document
        $('#obtSOSubmitFromDoc').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
              var tHNNumber =  $('#oetSOFrmCstHNNumber').val();
              var tMerCode =  $('#oetSOFrmMerCode').val();
              var tShpCode =  $('#oetSOFrmShpCode').val();
              var tPosCode =  $('#oetSOFrmPosCode').val();
              var tWahCode =  $('#oetSOFrmWahCode').val();
              var tCheckIteminTable = $('#otbSODocPdtAdvTableList .xWPdtItem').length;
          
              if(tCheckIteminTable>0){
              if(tHNNumber!='' && tWahCode!=''){
                JSxSOSetStatusClickSubmit(1);
                $('#obtSOSubmitDocument').click();
              }else{
                    if(tHNNumber==''){
                        FSvCMNSetMsgWarningDialog($('#oetSOFrmCstHNNumber').attr('lavudate-label'));
                    }else if(tWahCode==''){
                        FSvCMNSetMsgWarningDialog($('#oetSOFrmWahName').attr('data-validate-required'));
                    }
              }
            }else{
                FSvCMNSetMsgWarningDialog($('#ohdSOValidatePdt').val());
            }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        
        JSxSONavDefultDocument();
        JSvSOCallPageList();
    }else{
        // Event Modal Call Back Before List
        $('#oahSOBrowseCallBack').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tSOCallSOBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Modal Call Back Previous
        $('#oliSOBrowsePrevious').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tSOCallSOBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtSOBrowseSubmit').unbind().click(function () {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxSOSetStatusClickSubmit(1);
                $('#obtSOSubmitDocument').click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JSxSONavDefultDocument();
        JSvSOCallPageAddDoc();
    }
});

// Function: Set Defult Nav Menu Document
// Parameters: Document Ready Or Parameter Event
// Creator: 17/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate:
// Return: Set Default Nav Menu Document
// ReturnType: -
function JSxSONavDefultDocument(){
    if(typeof(nSOStaSOBrowseType) != 'undefined' && nSOStaSOBrowseType == 0) {
        // Title Label Hide/Show
        $('#oliSOTitleAdd').hide();
        $('#oliSOTitleEdit').hide();
        $('#oliSOTitleDetail').hide();
        $('#oliSOTitleAprove').hide();
        $('#oliSOTitleConimg').hide();
        // Button Hide/Show
        $('#odvSOBtnGrpAddEdit').hide();
        $('#odvSOBtnGrpInfo').show();
        $('#obtSOCallPageAdd').show();
    }else{
        $('#odvModalBody #odvSOMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliSONavBrowse').css('padding', '2px');
        $('#odvModalBody #odvSOBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNSOBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNSOBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 17/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate:
// Return: Call View Tranfer Out List
// ReturnType: View
function JSvSOCallPageList(){
    $.ajax({
        type: "GET",
        url: "dcmSOFormSearchList",
        cache: false,
        timeout: 0,
        success: function (tResult){
            $("#odvSOContentPageDocument").html(tResult);
            JSxSONavDefultDocument();
            JSvSOCallPageDataTable();
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
function JSoSOGetAdvanceSearchData(){
    var oAdvanceSearchData  = {
        tSearchAll          : $("#oetSOSearchAllDocument").val(),
        tSearchBchCodeFrom  : $("#oetSOAdvSearchBchCodeFrom").val(),
        tSearchBchCodeTo    : $("#oetSOAdvSearchBchCodeTo").val(),
        tSearchDocDateFrom  : $("#oetSOAdvSearcDocDateFrom").val(),
        tSearchDocDateTo    : $("#oetSOAdvSearcDocDateTo").val(),
        tSearchStaDoc       : $("#ocmSOAdvSearchStaDoc").val(),
        tSearchStaApprove   : $("#ocmSOAdvSearchStaApprove").val(),
        tSearchStaDocAct    : $("#ocmStaDocAct").val(),
        tSearchStaPrcStk    : $("#ocmSOAdvSearchStaPrcStk").val()
    };
    return oAdvanceSearchData;
}

// Function: Call Page List
// Parameters: Document Redy Function
// Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
// LastUpdate:
// Return: Call View Tabel Data List Document
// ReturnType: View
function JSvSOCallPageDataTable(pnPage){
    JCNxOpenLoading();
    var oAdvanceSearch  = JSoSOGetAdvanceSearchData();
    var nPageCurrent = pnPage;
    if(typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type: "POST",
        url: "dcmSODataTable",
        data: {
            oAdvanceSearch  : oAdvanceSearch,
            nPageCurrent    : nPageCurrent,
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxSONavDefultDocument();
                $('#ostSODataTableDocument').html(aReturnData['tSOViewDataTableList']);
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
function JSxSOShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliSOBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliSOBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliSOBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
//Return: Insert Code In Text Input
//Return Type: -
function JSxSOTextinModal() {
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
        $("#odvSOModalDelDocMultiple #ospTextConfirmDelMultiple").text($('#oetTextComfirmDeleteMulti').val());
        $("#odvSOModalDelDocMultiple #ohdConfirmIDDelMultiple").val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 19/06/2019 wasin (Yoshi AKA: Mr.JW)
//Return: Duplicate/none
//Return Type: string
function JStSOFindObjectByKey(array, key, value) {
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
function JSvSOClickPage(ptPage) {
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
        JSvSOCallPageDataTable(nPageCurrent);
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
function JSoSODelDocSingle(ptCurrentPage, ptSODocNo){
    var nStaSession = JCNxFuncChkSessionExpired();    
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        if(typeof(ptSODocNo) != undefined && ptSODocNo != ""){
            var tTextConfrimDelSingle   = $('#oetTextComfirmDeleteSingle').val()+"&nbsp"+ptSODocNo+"&nbsp"+$('#oetTextComfirmDeleteYesOrNot').val();
            $('#odvSOModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
            $('#odvSOModalDelDocSingle').modal('show');
            $('#odvSOModalDelDocSingle #osmConfirmDelSingle').unbind().click(function(){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmSOEventDelete",
                    data: {'tDataDocNo' : ptSODocNo},
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1') {
                            $('#odvSOModalDelDocSingle').modal('hide');
                            $('#odvSOModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function () {
                                JSvSOCallPageDataTable(ptCurrentPage);
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
function JSoSODelDocMultiple(){
    var aDataDelMultiple    = $('#odvSOModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
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
            url: "dcmSOEventDelete",
            data: {'tDataDocNo' : aNewIdDelete},
            cache: false,
            timeout: 0,
            success: function (oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    setTimeout(function () {
                        $('#odvSOModalDelDocMultiple').modal('hide');
                        $('#odvSOModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                        $('#odvSOModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                        $('.modal-backdrop').remove();
                        localStorage.removeItem('LocalItemData');
                        JSvSOCallPageList();
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
function JSvSOCallPageAddDoc(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "dcmSOPageAdd",
        cache: false,
        timeout: 0,
        success: function (oResult) {
            var aReturnData = JSON.parse(oResult);
            if(aReturnData['nStaEvent'] == '1') {
                if (nSOStaSOBrowseType == '1') {
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tSOViewPageAdd']);
                } else {
                    // Hide Title Menu And Button
                    $('#oliSOTitleEdit').hide();
                    $('#oliSOTitleDetail').hide();
                    $("#obtSOApproveDoc").hide();
                    $("#obtSOCancelDoc").hide();
                    $('#obtSOPrintDoc').hide();
                    $('#odvSOBtnGrpInfo').hide();
                    // Show Title Menu And Button
                    $('#oliSOTitleAdd').show();
                    $('#odvSOBtnGrpSave').show();
                    $('#odvSOBtnGrpAddEdit').show();
                    $('#oliSOTitleAprove').hide();
                    $('#oliSOTitleConimg').hide();

                    // Remove Disable Button Add 
                    $(".xWBtnGrpSaveLeft").attr("disabled",false);
                    $(".xWBtnGrpSaveRight").attr("disabled",false);

                    $('#odvSOContentPageDocument').html(aReturnData['tSOViewPageAdd']);
                }
                JSvSOLoadPdtDataTableHtml();
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
function JSvSOLoadPdtDataTableHtml(pnPage){
        if($("#ohdSORoute").val() == "dcmSOEventAdd"){
            var tSODocNo    = "";
        }else{
            var tSODocNo    = $("#oetSODocNo").val();
        }

        var tSOStaApv       = $("#ohdSOStaApv").val();
        var tSOStaDoc       = $("#ohdSOStaDoc").val();
        var tSOVATInOrEx    = $("#ocmSOFrmSplInfoVatInOrEx").val();
        
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
        var tSearchPdtAdvTable  = $('#oetSOFrmFilterPdtHTML').val();

        if(tSOStaApv==2){
            $('#obtSODocBrowsePdt').hide();
            $('#obtSOPrintDoc').hide();
            $('#obtSOCancelDoc').hide();
            $('#obtSOApproveDoc').hide();
            $('#odvSOBtnGrpSave').hide();
        }

        $.ajax({
            type: "POST",
            url: "dcmSOPdtAdvanceTableLoadData",
            data: {
                'tSelectBCH'        : $('#oetSOFrmBchCode').val(),
                'ptSearchPdtAdvTable'   : tSearchPdtAdvTable,
                'ptSODocNo'             : tSODocNo,
                'ptSOStaApv'            : tSOStaApv,
                'ptSOStaDoc'            : tSOStaDoc,
                'ptSOVATInOrEx'         : tSOVATInOrEx,
                'pnSOPageCurrent'       : nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['checksession'] == 'expire'){
                    JCNxShowMsgSessionExpired();
                }else{
                    if(aReturnData['nStaEvent'] == '1') {
                        $('#odvSODataPanelDetailPDT #odvSODataPdtTableDTTemp').html(aReturnData['tSOPdtAdvTableHtml']);
                        var aSOEndOfBill    = aReturnData['aSOEndOfBill'];
                        JSxSOSetFooterEndOfBill(aSOEndOfBill);
                        JCNxCloseLoading();
                    }else{
                        var tMessageError = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                        JCNxCloseLoading();
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JSvSOLoadPdtDataTableHtml(pnPage)
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
}




// Functionality: Call Page Product Table In Add Document
// Parameters: Function Ajax Success
// Creator: 28/06/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View
// ReturnType : View
function JSvSOLoadPdtDataTableHtmlMonitor(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        if($("#ohdSORoute").val() == "dcmSOEventAdd"){
            var tSODocNo    = "";
        }else{
            var tSODocNo    = $("#oetSODocNo").val();
        }

        var tSOStaApv       = $("#ohdSOStaApv").val();
        var tSOStaDoc       = $("#ohdSOStaDoc").val();
        var tSOVATInOrEx    = $("#ocmSOFrmSplInfoVatInOrEx").val();
        
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
        var tSearchPdtAdvTable  = $('#oetSOFrmFilterPdtHTML').val();
        $.ajax({
            type: "POST",
            url: "dcmSOPdtAdvanceTableLoadDataMonitor",
            data: {
                'tSelectBCH'            : $('#oetSOFrmBchCode').val(),
                'ptSearchPdtAdvTable'   : tSearchPdtAdvTable,
                'ptSODocNo'             : tSODocNo,
                'ptSOStaApv'            : tSOStaApv,
                'ptSOStaDoc'            : tSOStaDoc,
                'ptSOVATInOrEx'         : tSOVATInOrEx,
                'pnSOPageCurrent'       : nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1') {
                    $('#odvSODataPanelDetailPDT #odvSODataPdtTableDTTempMonitor').html(aReturnData['tSOPdtAdvTableHtml']);
                    var aSOEndOfBill    = aReturnData['aSOEndOfBill'];
                    // JSxSOSetFooterEndOfBill(aSOEndOfBill);
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


// Functionality: Add Product Into Table Document DT Temp
// Parameters: Function Ajax Success
// Creator: 01/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View
// ReturnType : View
function JCNvSOBrowsePdt(){
    var tSOSplCode = $('#oetSOFrmSplCode').val();
    if($('#ohdSOPplCodeCst').val()!=''){
        var tSOPplCode =$('#ohdSOPplCodeCst').val();
    }else{
        var tSOPplCode =$('#ohdSOPplCodeBch').val();
    }
    // if(typeof(tSOSplCode) !== undefined && tSOSplCode !== ''){
        var aMulti = [];
        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                Qualitysearch   : [],
                // PriceType: ["Cost","tCN_Cost","Company","1"],
                // 'PriceType' : ['Pricesell'],
                'PriceType' : ['Price4Cst',tSOPplCode],
                //'SelectTier' : ['PDT'],
                SelectTier: ["Barcode"],
                //'Elementreturn'   : ['oetInputTestValue','oetInputTestName'],
                ShowCountRecord: 10,
                NextFunc: "FSvSONextFuncB4SelPDT", //FSvSOAddPdtIntoDocDTTemp
                ReturnType: "M",
                SPL: [$("#oetSOFrmSplCode").val(),$("#oetSOFrmSplCode").val()],
                BCH: [$("#oetSOFrmBchCode").val(),$("#oetSOFrmBchCode").val()],
                MCH: [$("#oetSOFrmMerCode").val(),$("#oetSOFrmMerCode").val()],
                SHP: [$("#oetSOFrmShpCode").val(), $("#oetSOFrmShpCode").val()],
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

// Function : เพิ่มสินค้าลงในตาราง Doc DT Temp
// Parameters: Function Behind Next Func Select Product
// Creator: 01/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View Table Product Doc DT Temp
// ReturnType : View
// function FSvSOAddPdtIntoDocDTTemp(ptPdtData){
//     var nStaSession = JCNxFuncChkSessionExpired();
//     if (typeof nStaSession !== "undefined" && nStaSession == 1){
//         JCNxOpenLoading();
//         var ptXthDocNoSend  = "";
//         if ($("#ohdSORoute").val() == "dcmSOEventEdit") {
//             ptXthDocNoSend  = $("#oetSODocNo").val();
//         }
//         var tSOVATInOrEx    = $('#ocmSOFrmSplInfoVatInOrEx').val();
//         var tSOOptionAddPdt = $('#ocmSOFrmInfoOthReAddPdt').val();
//         let tSOPplCodeBch = $('#ohdSOPplCodeBch').val();
//         let tSOPplCodeCst = $('#ohdSOPplCodeCst').val();
//         $.ajax({
//             type: "POST",
//             url: "dcmSOAddPdtIntoDTDocTemp",
//             data: {
//                 'tSelectBCH'        : $('#oetSOFrmBchCode').val(),
//                 'tSODocNo'          : ptXthDocNoSend,
//                 'tSOVATInOrEx'      : tSOVATInOrEx,
//                 'tSOOptionAddPdt'   : tSOOptionAddPdt,
//                 'tSOPdtData'        : ptPdtData,
//                 'tSOPplCodeBch'     : tSOPplCodeBch,
//                 'tSOPplCodeCst'     : tSOPplCodeCst
//             },
//             cache: false,
//             timeout: 0,
//             success: function (oResult){
//                 JSvSOLoadPdtDataTableHtml();
//             },
//             error: function (jqXHR, textStatus, errorThrown) {
//                 JCNxResponseError(jqXHR, textStatus, errorThrown);
//             }
//         });
//     }else{
//         JCNxShowMsgSessionExpired();
//     }
// }

// Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
// Parameters: Function Behind Edit In Line
// Creator: 02/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View Table Product Doc DT Temp
// ReturnType : View
function FSvSOEditPdtIntoTableDT(pnSeqNo, ptFieldName, ptValue, pbIsDelDTDis){
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if (typeof nStaSession !== "undefined" && nStaSession == 1){
        var tSODocNo        = $("#oetSODocNo").val();
        var tSOBchCode      = $("#oetSOFrmBchCode").val();
        var tSOVATInOrEx    = $('#ocmSOFrmSplInfoVatInOrEx').val();
        $.ajax({
            type: "POST",
            url: "dcmSOEditPdtIntoDTDocTemp",
            data: {
                'tSOBchCode'    : tSOBchCode,
                'tSODocNo'      : tSODocNo,
                'tSOVATInOrEx'  : tSOVATInOrEx,
                'nSOSeqNo'      : pnSeqNo,
                'tSOFieldName'  : ptFieldName,
                'tSOValue'      : ptValue,
                'nSOIsDelDTDis' : (pbIsDelDTDis) ? '1' : '0' // 1: ลบ, 2: ไม่ลบ
            },
            cache: false,
            timeout: 0,
            success: function (oResult){

                if(oResult == 'expire'){
                    JCNxShowMsgSessionExpired();
                }else{
                    JSvSOLoadPdtDataTableHtml();
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




// Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
// Parameters: Function Behind Edit In Line
// Creator: 02/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View Table Product Doc DT Temp
// ReturnType : View
function FSvSOEditPdtIntoTableDTMonitor(pnSeqNo, ptFieldName, ptValue, pbIsDelDTDis){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1){
        var tSODocNo        = $("#oetSODocNo").val();
        var tSOBchCode      = $("#oetSOFrmBchCode").val();
        var tSOVATInOrEx    = $('#ocmSOFrmSplInfoVatInOrEx').val();
        $.ajax({
            type: "POST",
            url: "dcmSOEditPdtIntoDTDocTemp",
            data: {
                'tSOBchCode'    : tSOBchCode,
                'tSODocNo'      : tSODocNo,
                'tSOVATInOrEx'  : tSOVATInOrEx,
                'nSOSeqNo'      : pnSeqNo,
                'tSOFieldName'  : ptFieldName,
                'tSOValue'      : ptValue,
                'nSOIsDelDTDis' : (pbIsDelDTDis) ? '1' : '0' // 1: ลบ, 2: ไม่ลบ
            },
            cache: false,
            timeout: 0,
            success: function (oResult){
                JSvSOLoadPdtDataTableHtmlMonitor();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}


// Functionality: Set Status On Click Submit Buttom
// Parameters: Event Click Save Document
// Creator: 03/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Set Status Submit By Button In Input Hidden
// ReturnType: None
function JSxSOSetStatusClickSubmit(pnStatus) {
    $("#ohdSOCheckSubmitByButton").val(pnStatus);
}

// Functionality: Add/Edit Document
// Parameters: Event Click Save Document
// Creator: 03/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: None
function JSxSOAddEditDocument(){
    // var nStaSession = JCNxFuncChkSessionExpired();
    var nStaSession = 1;
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        JSxSOValidateFormDocument();
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
function JSxSOValidateFormDocument(){
    if($("#ohdSOCheckClearValidate").val() != 0){
        $('#ofmSOFormAdd').validate().destroy();
    }

    $('#ofmSOFormAdd').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetSODocNo : {
                "required" : {
                    depends: function (oElement) {
                        if($("#ohdSORoute").val()  ==  "dcmSOEventAdd"){
                            if($('#ocbSOStaAutoGenCode').is(':checked')){
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
            oetSODocDate    : {"required" : true},
            oetSODocTime    : {"required" : true},
            oetSOFrmWahName : {"required" : true},
        },
        messages: {
            oetSODocNo      : {"required" : $('#oetSODocNo').attr('data-validate-required')},
            oetSODocDate    : {"required" : $('#oetSODocDate').attr('data-validate-required')},
            oetSODocTime    : {"required" : $('#oetSODocTime').attr('data-validate-required')},
            oetSOFrmWahName : {"required" : $('#oetSOFrmWahName').attr('data-validate-required')},
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
            if(!$('#ocbSOStaAutoGenCode').is(':checked')){
                JSxSOValidateDocCodeDublicate();
            }else{
                if($("#ohdSOCheckSubmitByButton").val() == 1){
                    JSxSOSubmitEventByButton();
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
function JSxSOValidateDocCodeDublicate(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            'tTableName'    : 'TARTSoHD',
            'tFieldName'    : 'FTXshDocNo',
            'tCode'         : $('#oetSODocNo').val()
        },
        success: function (oResult) {
            var aResultData = JSON.parse(oResult);
            $("#ohdSOCheckDuplicateCode").val(aResultData["rtCode"]);

            if($("#ohdSOCheckClearValidate").val() != 1) {
                $('#ofmSOFormAdd').validate().destroy();
            }

            $.validator.addMethod('dublicateCode', function(value,element){
                if($("#ohdSORoute").val() == "dcmSOEventAdd"){
                    if($('#ocbSOStaAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdSOCheckDuplicateCode").val() == 1) {
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
            $('#ofmSOFormAdd').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetSODocNo : {"dublicateCode": {}}
                },
                messages: {
                    oetSODocNo : {"dublicateCode"  : $('#oetSODocNo').attr('data-validate-duplicate')}
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
                    if($("#ohdSOCheckSubmitByButton").val() == 1) {
                        JSxSOSubmitEventByButton();
                    }
                }
            })

            if($("#ohdSOCheckClearValidate").val() != 1) {
                $("#ofmSOFormAdd").submit();
                $("#ohdSOCheckClearValidate").val(1);
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
function JSxSOSubmitEventByButton(){
    if($("#ohdSORoute").val() !=  "dcmSOEventAdd"){
        var tSODocNo    = $('#oetSODocNo').val();
    }
    $.ajax({
        type: "POST",
        url: "dcmSOChkHavePdtForDocDTTemp",
        data: {
            'ptSODocNo': tSODocNo,
            'tSOSesSessionID'   : $('#ohdSesSessionID').val(),
            'tSOUsrCode'        : $('#ohdSOUsrCode').val(),
            'tSOLangEdit'       : $('#ohdSOLangEdit').val(),
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
                    url     : $("#ohdSORoute").val(),
                    data    : $("#ofmSOFormAdd").serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function(oResult){
                        JCNxCloseLoading();
                        var aDataReturnEvent    = JSON.parse(oResult);
                        if(aDataReturnEvent['nStaReturn'] == '1'){
                            var nSOStaCallBack      = aDataReturnEvent['nStaCallBack'];
                            var nSODocNoCallBack    = aDataReturnEvent['tCodeReturn'];
                            switch(nSOStaCallBack){
                                case '1' :
                                    JSvSOCallPageEditDoc(nSODocNoCallBack);
                                break;
                                case '2' :
                                    JSvSOCallPageAddDoc();
                                break;
                                case '3' :
                                    JSvSOCallPageList();
                                break;
                                default :
                                    JSvSOCallPageEditDoc(nSODocNoCallBack);
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
function JSxSOSubmitEventByButton(){
    if($("#ohdSORoute").val() !=  "dcmSOEventAdd"){
        var tSODocNo    = $('#oetSODocNo').val();
    }
    $.ajax({
        type: "POST",
        url: "dcmSOChkHavePdtForDocDTTemp",
        data: {
            'ptSODocNo': tSODocNo,
            'tSOSesSessionID'   : $('#ohdSesSessionID').val(),
            'tSOUsrCode'        : $('#ohdSOUsrCode').val(),
            'tSOLangEdit'       : $('#ohdSOLangEdit').val(),
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
                    url     : $("#ohdSORoute").val(),
                    data    : $("#ofmSOFormAdd").serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function(oResult){
                        JCNxCloseLoading();
                        var aDataReturnEvent    = JSON.parse(oResult);
                        if(aDataReturnEvent['nStaReturn'] == '1'){
                            var nSOStaCallBack      = aDataReturnEvent['nStaCallBack'];
                            var nSODocNoCallBack    = aDataReturnEvent['tCodeReturn'];
                            if($('#ohdSOPage').val()==1){
                            switch(nSOStaCallBack){
                                case '1' :
                                    JSvSOCallPageEditDoc(nSODocNoCallBack);
                                break;
                                case '2' :
                                    JSvSOCallPageAddDoc();
                                break;
                                case '3' :
                                    JSvSOCallPageList();
                                break;
                                default :
                                    JSvSOCallPageEditDoc(nSODocNoCallBack);
                            }
                        }else{
                            JSvSOCallPageEditDocOnMonitor(nSODocNoCallBack);
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
function JSvSOCallPageEditDoc(ptSODocNo){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML("JSvSOCallPageEditDoc",ptSODocNo);
        $.ajax({
            type: "POST",
            url: "dcmSOPageEdit",
            data: {'ptSODocNo' : ptSODocNo},
            cache: false,
            timeout: 0,
            success: function(tResult){
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    if(nSOStaSOBrowseType == '1') {
                        $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                        $('#odvModalBodyBrowse').html(aReturnData['tSOViewPageEdit']);
                    }else{
                        $('#odvSOContentPageDocument').html(aReturnData['tSOViewPageEdit']);
                        JCNxSOControlObjAndBtn();
                        JSvSOLoadPdtDataTableHtml();
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
function JCNxSOControlObjAndBtn(){
    // Check สถานะอนุมัติ
    var nSOStaDoc       = $("#ohdSOStaDoc").val();
    var nSOStaApv       = $("#ohdSOStaApv").val();
    var tSOStaDelMQ     = $('#ohdSOStaDelMQ').val();
    var tSOStaPrcStk    = $('#ohdSOStaPrcStk').val();

    JSxSONavDefultDocument();

    // Title Menu Set De
    $("#oliSOTitleAdd").hide();
    $('#oliSOTitleDetail').hide();
    $('#oliSOTitleAprove').hide();
    $('#oliSOTitleConimg').hide();
    $('#oliSOTitleEdit').show();
    $('#odvSOBtnGrpInfo').hide();
    // Button Menu
    $("#obtSOApproveDoc").show();
    $("#obtSOCancelDoc").show();
    $('#obtSOPrintDoc').show();
    $('#odvSOBtnGrpSave').show();
    $('#odvSOBtnGrpAddEdit').show();

    // Remove Disable
    $("#obtSOCancelDoc").attr("disabled",false);
    $("#obtSOApproveDoc").attr("disabled",false);
    $("#obtSOPrintDoc").attr("disabled",false);
    $("#obtSOBrowseSupplier").attr("disabled",false);

    $(".xWConditionSearchPdt").attr("disabled",false);
    $(".ocbListItem").attr("disabled",false);
    $(".xCNBtnDateTime").attr("disabled",false);
    $(".xCNDocBrowsePdt").attr("disabled",false).removeClass("xCNBrowsePdtdisabled");
    $(".xCNDocDrpDwn").show();
    $("#oetSOFrmSearchPdtHTML").attr("disabled", false);
    $(".xWBtnGrpSaveLeft").show();
    $(".xWBtnGrpSaveRight").show();
    $("#oliSOEditShipAddress").show();
    $("#oliSOEditTexAddress").show();

    if(nSOStaDoc != 1){
        // Hide/Show Menu Title 
        $("#oliSOTitleAdd").hide();
        $('#oliSOTitleEdit').hide();
        $('#oliSOTitleDetail').show();
        $('#oliSOTitleAprove').hide();
        $('#oliSOTitleConimg').hide();
        // Disabled Button
        $("#obtSOCancelDoc").hide(); // attr("disabled",true);
        $("#obtSOApproveDoc").hide(); // attr("disabled",true);
        $("#obtSOPrintDoc").hide(); // attr("disabled",true);
        $("#obtSOBrowseSupplier").attr("disabled",true);
        $(".xWConditionSearchPdt").attr("disabled",true);
        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $("#ocbSOFrmInfoOthStaDocAct").attr("disabled", true);
        $('.xWDropdown').attr('disabled',true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetSOFrmSearchPdtHTML").attr("disabled",true);
        $('#odvSOBtnGrpSave').hide();
        // $(".xWBtnGrpSaveLeft").hide(); // attr("disabled", true);
        // $(".xWBtnGrpSaveRight").hide(); // attr("disabled", true);
        $("#oliSOEditShipAddress").hide();
        $("#oliSOEditTexAddress").hide();
        // Hide Button
        $("#obtSOCallPageAdd").hide();
    }

    // Check Status Appove Success


    if(nSOStaDoc == 1 && nSOStaApv == 1 ){
        // Hide/Show Menu Title 
        $("#oliSOTitleAdd").hide();
        $('#oliSOTitleEdit').hide();
        $('#oliSOTitleDetail').show();
        $('#oliSOTitleAprove').hide();
        $('#oliSOTitleConimg').hide();
        // Hide And Disabled
        $("#obtSOCallPageAdd").hide();
        $("#obtSOCancelDoc").hide(); // attr("disabled",true);
        $("#obtSOApproveDoc").hide(); // attr("disabled",true);
        $("#obtSOBrowseSupplier").attr("disabled",true);
        $(".xWConditionSearchPdt").attr("disabled",true);

        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $("#ocbSOFrmInfoOthStaDocAct").attr("disabled", true);
        $('.xWDropdown').attr('disabled',true);
        $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetSOFrmSearchPdtHTML").attr("disabled", false);
        $('#odvSOBtnGrpSave').hide();
        // $(".xWBtnGrpSaveLeft").hide(); // attr("disabled", true);
        // $(".xWBtnGrpSaveRight").hide(); // attr("disabled", true);
        $("#oliSOEditShipAddress").hide();
        $("#oliSOEditTexAddress").hide();
        // Show And Disabled
        $("#oliSOTitleDetail").show();
    }
}

// Functionality: Cancel Document PI
// Parameters: Event Btn Click Call Edit Document
// Creator: 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Status Cancel Document
// ReturnType: object
function JSnSOCancelDocument(pbIsConfirm){
    var tSODocNo    = $("#oetSODocNo").val();
    if(pbIsConfirm){
        $.ajax({
            type: "POST",
            url: "dcmSOCancelDocument",
            data: {'ptSODocNo' : tSODocNo},
            cache: false,
            timeout: 0,
            success: function (tResult) {
                $("#odvPurchaseInviocePopupCancel").modal("hide");
                $('.modal-backdrop').remove();
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    JSvSOCallPageEditDoc(tSODocNo);
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
function JSxSOApproveDocument(pbIsConfirm){
    if(pbIsConfirm){
        $("#odvSOModalAppoveDoc").modal("hide");
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        var tSODocNo            = $("#oetSODocNo").val();
        var tSOBchCode          = $('#oetSOFrmBchCode').val();
        var tSOStaApv           = $("#ohdSOStaApv").val();
        var tSOSplPaymentType   = $("#ocmSOFrmSplInfoPaymentType").val();

        $.ajax({
            type : "POST",
            url : "dcmSOApproveDocument",
            data: {
                'ptSODocNo'             : tSODocNo,
                'ptSOBchCode'           : tSOBchCode,
                'ptSOStaApv'            : tSOStaApv,
                'ptSOSplPaymentType'    : tSOSplPaymentType
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                console.log(tResult);
                try {
                    let oResult = JSON.parse(tResult);
                    if (oResult.nStaEvent == "1") {
                    //  FSvCMNSetMsgSucessDialog(oResult.tStaMessg);
                     JSvSOCallPageEditDoc(tSODocNo);
                        }else{
                     FSvCMNSetMsgWarningDialog(oResult.tStaMessg);
                    }
                    // if (oResult.nStaEvent == "900") {
                    //     FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                    // }
                } catch (err) {}
                // JSoSOCallSubscribeMQ();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        $('#odvSOModalAppoveDoc').modal({backdrop:'static',keyboard:false});
        $("#odvSOModalAppoveDoc").modal("show");
    }
}

// Functionality : Call Data Subscript Document
// Parameters : Event Click Buttom
// Creator : 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : Status Applove Document
// Return Type : -
function JSoSOCallSubscribeMQ() {
    // RabbitMQ
    /*===========================================================================*/
    // Document variable
    var tLangCode   = $("#ohdSOLangEdit").val();
    var tUsrBchCode = $("#oetSOFrmBchCode").val();
    var tUsrApv     = $("#ohdSOApvCodeUsrLogin").val();
    var tDocNo      = $("#oetSODocNo").val();
    var tPrefix     = "RESPPI";
    var tStaApv     = $("#ohdSOStaApv").val();
    var tStaDelMQ   = $("#ohdSOStaDelMQ").val();
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
    //     ptDocTableName      : "TARTSoHD",
    //     ptDocFieldDocNo     : "FTXshDocNo",
    //     ptDocFieldStaApv    : "FTXphStaPrcStk",
    //     ptDocFieldStaDelMQ  : "FTXphStaDelMQ",
    //     ptDocStaDelMQ       : tStaDelMQ,
    //     ptDocNo             : tDocNo
    // };

    // Callback Page Control(function)
    // var poCallback = {
    //     tCallPageEdit: "JSvSOCallPageEditDoc",
    //     tCallPageList: "JSvSOCallPageList"
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
function JSvSODOCFilterPdtInTableTemp(){
    JCNxOpenLoading();
    JSvSOLoadPdtDataTableHtml();
}

// Functionality : Function Check Data Search And Add In Tabel DT Temp
// Parameters : Event Click Buttom
// Creator : 30/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : 
// Return Type : Filter
function JSxSOChkConditionSearchAndAddPdt(){
    var tSODataSearchAndAdd =   $("#oetSOFrmSearchAndAddPdtHTML").val();
    if(tSODataSearchAndAdd != undefined && tSODataSearchAndAdd != ""){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var tSODataSearchAndAdd = $("#oetSOFrmSearchAndAddPdtHTML").val();
            var tSODocNo            = $('#oetSODocNo').val();
            var tSOBchCode          = $("#oetSOFrmBchCode").val();
            var tSOStaReAddPdt      = $("#ocmSOFrmInfoOthReAddPdt").val();
            $.ajax({
                type: "POST",
                url: "dcmSOSerachAndAddPdtIntoTbl",
                data:{
                    'ptSOBchCode'           : tSOBchCode,
                    'ptSODocNo'             : tSODocNo,
                    'ptSODataSearchAndAdd'  : tSODataSearchAndAdd,
                    'ptSOStaReAddPdt'       : tSOStaReAddPdt,
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
function JSvSOClickPageList(ptPage){
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
    JSvSOCallPageDataTable(nPageCurrent);
}


//Next page
function JSvSOPDTDocDTTempClickPage(ptPage) {
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
        JSvSOLoadPdtDataTableHtml(nPageCurrent);
    } else {
        JCNxShowMsgSessionExpired();
    }
}


//Next page
function JSvSOPDTDocDTTempClickPageMonitor(ptPage) {
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
        JSvSOLoadPdtDataTableHtmlMonitor(nPageCurrent);
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Functionality: Call Page Edit Document
// Parameters: Event Btn Click Call Edit Document
// Creator: 04/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Status Add/Update Document
// ReturnType: object
function JSvSOCallPageEditDocOnMonitor(ptSODocNo){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML("JSvSOCallPageEditDocOnMonitor",ptSODocNo);
        $.ajax({
            type: "POST",
            url: "dcmSOPageEditMonitor",
            data: {'ptSODocNo' : ptSODocNo},
            cache: false,
            timeout: 0,
            success: function(tResult){
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    if(nSOStaSOBrowseType == '1') {
                        $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                        $('#odvModalBodyBrowse').html(aReturnData['tSOViewPageEdit']);
                    }else{
                        $('#odvSOContentPageDocument').html(aReturnData['tSOViewPageEdit']);
                        JCNxSOControlObjAndBtn();
                        JSvSOLoadPdtDataTableHtmlMonitor();
                        $(".xWConditionSearchPdt.disabled").attr("disabled","disabled");
                            // Title Menu Set De
                        $("#oliSOTitleAdd").hide();
                        $('#oliSOTitleDetail').hide();
                        $('#oliSOTitleAprove').show();
                        $('#oliSOTitleConimg').hide();
                        $('#oliSOTitleEdit').hide();
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
