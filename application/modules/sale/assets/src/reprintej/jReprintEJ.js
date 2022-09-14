var nEJBrowseType   = $("#ohdEJBrowseType").val();
var tEJBrowseOption = $("#ohdEJBrowseOption").val();

$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    // Hide Tab Menu
    JSxCheckPinMenuClose();
    if(typeof(nEJBrowseType) != 'undefined' && nEJBrowseType == 0){
        JSvCallPageEJMainFormPrint();

        // Event Click Title
        $('#oliEJTitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSvCallPageEJMainFormPrint();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Print
        $('#obtEJReprintAbb').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxEJCallRederPrintABB();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

    }else{
        JSvCallPageEJMainFormPrint();
    }
});

// Function: Call Page EJ Main From Print
// Parameters: Document Redy And Function Call Back Event
// Creator:	09/10/2019 wasin(Yoshi)
// LastUpdate: -
// Return: View Main Form Preview Print
// ReturnType: View
function JSvCallPageEJMainFormPrint(){
    JCNxOpenLoading();
    localStorage.tStaPageNow = 'JSvCallPageEJMainFormPrint';
    $.ajax({
        type: "GET",
        url: "dcmReprintEJCallPageMainFormPrint",
        success: function(tResult){
            $('#odvContentPageEJ').html(tResult);
            JSxEJFilterDataABBInDB(1);
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Next Function Branch
// Parameter : Event Next Func Modal
// Create : 10/10/2019 Wasin(Yoshi)
// Return : Clear Velues Data
// Return Type : -
function JSxEJConsNextFuncBrowseBch(poDataNextFunc){
    if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
        var tEJShopCode = $('#oetEJShopCode').val();
        var tEJShopName = $('#oetEJShopName').val();
        if((tEJShopCode !== 'undefined' && tEJShopCode != "") && (tEJShopName !== 'undefined' && tEJShopName != "")){
            $('#oetEJShopCode').val('');
            $('#oetEJShopName').val('');
        }
    }
}

// Functionality: Filter Data ABB IN DataBase
// Parameter: Event Click Button Search View
// Create: 11/10/2019 Wasin(Yoshi)
// Return: View Show ABB
// ReturnType : object
function JSxEJFilterDataABBInDB(pnPage){
    JCNxOpenLoading();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }
    var aDataFormSerialize  = $('#ofmEJConditionFilter').serialize()+"&nPageCurrent="+nPageCurrent;
    $.ajax({
        type: "POST",
        url: "dcmReprintEJFilterDataABB",
        data: aDataFormSerialize,
        success: function(tResult){
            $('#odvAbbrViewerData .panel-body').html(tResult);
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: Function Event Click Page
// Parameter: Event Click Pagenation
// Create: 11/10/2019 Wasin(Yoshi)
// Return: View Show ABB
// ReturnType : object
function JSvEJClickPage(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageReprintEJ .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageReprintEJ .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSxEJFilterDataABBInDB(nPageCurrent);
}

// Functionality: Function Call Page Render Print ABB
// Parameter: Event Click Pagenation
// Create: 15/10/2019 Wasin(Yoshi)
// Return: View Show ABB
// ReturnType : object
function JSxEJCallRederPrintABB(){
    $.ajax({
        type: "POST",
        url: "dcmReprintEJCallPageRenderPrintABB",
        data: $('#ofmEJConditionFilter').serialize(),
        success: function(tResult){
            var aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaCallPage'] == 1){
                var tViewImageHtml  = aDataReturn['tViewImageHtml'];
                var oPrintWindows   = window.open('','','height=768,width=1024,scrollbars=1');
                oPrintWindows.document.write('<html><head><title>Print ABB</title>');   // ตั้งชื่อ Title Reder Print
                oPrintWindows.document.write('</head><body onLoad="self.print();self.close();">'); // สั่ง Print เมื่อ reder เสร็จ
                oPrintWindows.document.write(tViewImageHtml);
                oPrintWindows.document.write('</body></html>');
                oPrintWindows.document.close();
            }else{
                var tMessageError   = aDataReturn['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}