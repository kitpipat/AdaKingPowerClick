var nCrdHisBrowseType   = $('#oetCrdHisStaBrowse').val();
var tCrdHisBrowseOption  = $('#oetCrdHisCallBackOption').val();
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    if(nCrdHisBrowseType != '1'){
        JSvCallPageCardHistoryList();
    }
});


//function : Call Page Cardhistory list  
//Creator:	05/01/2021 Witsarut
function JSvCallPageCardHistoryList(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageCardHistoryList';
        JCNxOpenLoading();  
        $.ajax({
            type : "POST",
            url  : "cardhistorylist",
            cache: false,
            data: {},
            timeout : 0,
            success: function(tResult){
                $('#odvContentPageCardHis').html(tResult);
                JSvCardHistoryDataTable(pnPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function: Call Product Type Data List
//Parameters: Ajax Success Event 
function JSvCardHistoryDataTable(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        $.ajax({
            type : "POST",
            url  : "cardhistorydatatable",
            data : {
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult){
                if (tResult != "") {
                    $('#ostDataCardHistory').html(tResult);
                }
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}


 // Functionality: ฟังก์ชั่นล้างค่า Input Advance Search
// Creator: 01/06/2021 Bell
function JSxTBIClearSearchData(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== "undefined" && nStaSession == 1){
        $('#oetCrdHisBchCode').val("");
        $('#oetCrdHisBchName').val("");
        $('#oetCardHistoryCode').val("");
        $('#oetCardHistoryName').val("");
        $('#oetCrdHisDate').val("");
        JSvCallPageCardHistoryList();
    }else{
        JCNxShowMsgSessionExpired();
    }
}
