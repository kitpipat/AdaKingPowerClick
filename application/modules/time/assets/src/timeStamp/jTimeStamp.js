var nStaTimeStampBrowseType = $('#oetTimeStampStaBrowse').val();
var tCallTimeStampBackOption = $('#oetTimeStampCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSvCallPageTimeStampMainContent();

    
    $('#oliTimeStampDetail').hide();
});

/*============================= End Auto Run =================================*/

/*============================= Begin Custom Form Validate ===================*/

//Call Mainpage
function JSvCallPageTimeStampMainContent(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "timeStampMainpage",
        cache: false,
        success: function(tResult) {
            $('#odvContentPageTimeStamp').html(tResult);
            JCNxCloseLoading();
            $('#obtCheckDetail').show();
            $('#oliTimeStampDetail').hide();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

//Call page check detail
function JSxCallPageCheckDetail(){
    $.ajax({
        type: "POST",
        url: "timeStampMainGetDetail",
        cache: false,
        success: function(tResult) {
            $('#obtCheckDetail').hide();
            $('#oliTimeStampDetail').show();
            $('#odvContentPageTimeStamp').html(tResult);
            JCNxLayoutControll();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Get page check detail DataTable
function JSxCallDataTableDetailAll(pnPage){

    var pnPage                              = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    var ptDateCheckin                       = $('#oetTimeStampStartDate').val();
    var ptDateCheckout                      = $('#oetTimeStampEndDate').val();
    var ptBranch                            = $('#oetTimeStampBranch').val();
    var ptUsername                          = $('#oetTimeStampUsername').val();
    var ptTypeSearchCheckinorCheckout       = $('#ocmSelectTypeTimestamp').val();
    

    JCNxOpenLoading();
    $.ajax({
        type    : "POST",
        url     : "timeStampMainGetDetailDataTable",
        cache   : false,
        data    : {
            'nPageCurrent'                      : pnPage ,
            'ptDateCheckin'                     : ptDateCheckin ,
            'ptDateCheckout'                    : ptDateCheckout ,
            'ptBranch'                          : ptBranch ,
            'ptTypeSearchCheckinorCheckout'     : ptTypeSearchCheckinorCheckout,
            'ptUsername'                        : ptUsername 
        },
        success: function(tResult) {
            $('#ostContentTimeStampDataTable').html(tResult);
            JCNxCloseLoading();
        },
        error: function(data) {
            console.log(data);
        }
    });
}  

//เปลี่ยนหน้า pagenation
function JSvTimeStampClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageTimeStamp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageTimeStamp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSxCallDataTableDetailAll(nPageCurrent);
}