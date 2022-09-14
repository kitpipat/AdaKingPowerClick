$('ducument').ready(function() {
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    //โหลดข้อมูล view ค้นหา 
    JCNxInvList(1);
});

// function JSxMmtRenderInventory(){
//     $.ajax({
//         type: "GET",
//         url: "mmtINV/0/0",
//         cache: false,
//         success: function(tResult) {
//             $('#odvInvContentPage').html(tResult);
//             // JCNxInvList(1);
//         },
//         error: function(jqXHR, textStatus, errorThrown) {
//             JCNxResponseError(jqXHR, textStatus, errorThrown);
//         }
//     });
// }



function JCNxInvList(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $.ajax({
            type: "POST",
            url: "mmtINVPageList",
            cache: false,
            success: function(tResult) {
                $('#odvInvContentPage').html(tResult);
                JSxInvDataTable(pnPage);
                $('#obtInvSearchSubmit').on('click', function(){
                    JSxInvSearchData();
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSxInvDataTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
       //ตรวจสอบ Value สาขา
       var ptBchCode   = $('#oetInvBchCodeSelect').val();
       if (ptBchCode == undefined || ptBchCode == '') {
           tBchCode    = '';
       }else{
           tBchCode    = $('#oetInvBchCodeSelect').val();
       }
       //ตรวจสอบ Value คลังสินค้า
       var ptWahCode   = $('#oetInvWahCodeSelect').val();
       if (ptWahCode == undefined || ptWahCode == '') {
           tWahCode    = '';
       }else{
           tWahCode    = $('#oetInvWahCodeSelect').val();
       }
       //ตรวจสอบ Value สินค้า
       var ptPdtCode   = $('#oetInvPdtCodeSelect').val();
       if (ptPdtCode == undefined || ptPdtCode == '') {
           tPdtCode    = '';
       }else{
           tPdtCode   = $('#oetInvPdtCodeSelect').val();
       }
       
       //set value json
       var tDataFilter = { "tBchCode"   : tBchCode,
                           "tWahCode"   : tWahCode,
                           "tPdtCode"   : tPdtCode
                         };
        console.log(tDataFilter);
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "mmtINVDataTableList",
            data: {
                tDataFilter: JSON.stringify(tDataFilter),
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                $('#odvInvContentTable').html(tResult);

                JCNxLayoutControll();
                JCNxCloseLoading();

                // $('#obtInvPreviousPage').on('click', function(){
                //     JSxInvClickPage($(this).data('ngotopage'));
                // });
                // $('#obtInvNextPage').on('click', function(){
                //     JSxInvClickPage($(this).data('ngotopage'));
                // });
                // $('button[id ^= "obtInvPageNumber"]').on('click', function(el){
                //     // console.log('click on page:'+$(this).data('npagenumber'));
                //     JSxInvClickPage($(this).data('npagenumber'));
                // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
    
}

// function JSxInvClickPage(ptPage) {
//     JSxInvDataTable(ptPage);
// }

//Functionality: เปลี่ยนหน้า pagenation
//Parameters: -
//Creator: 11/03/202020 Saharat(Golf)
//Update: 15/04/2020 surawat
//Return: View
//Return Type: View
function JSxInvClickPage(ptPage) {
    var nPageCurrent = '';
    var nPageNew;
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
           nPageCurrent = $('#obtInvNextPage').data('ngotopage');
            break;
        case 'previous': //กดปุ่ม Previous
            nPageCurrent = $('#obtInvPreviousPage').data('ngotopage');
            break;
        default:
            nPageCurrent = ptPage;
    }
    JSxInvDataTable(nPageCurrent);
}


function JSxInvSearchData(){
    JSxInvDataTable(1);
}

//test
