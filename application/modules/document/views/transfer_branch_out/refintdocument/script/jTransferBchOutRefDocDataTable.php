<script>

$('.xDocuemntRefInt').click(function(){
    var tBchCode = $(this).data('bchcode');
    var tDocNo = $(this).data('docno');
    JSxTransferBchOutCallRefIntDocDetailDataTable(tBchCode,tDocNo);
    $('.xDocuemntRefInt').removeClass('active');
    $(this).addClass('active');
})

// Function Check Data Search And Add In Tabel DT Temp
function JSvIVRefIntClickPageList(ptPage){
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
    JSxRefIntDocHDDataTable(nPageCurrent);
}

// Function Check Data Search And Add In Tabel DT Temp
function JSxTransferBchOutCallRefIntDocDetailDataTable(ptBchCode,ptDocNo){
    JCNxOpenLoading();
    $.ajax({
        type    : "POST",
        url     : "docTransferBchOutRefIntDocDetailDataTable",
        data    : {
            'ptBchCode'     : ptBchCode,
            'ptDocNo'       : ptDocNo
        },
        cache: false,
        Timeout: 0,
        success: function (oResult){
            $('#odvRefIntDocDetail').html(oResult);
            JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}
</script>