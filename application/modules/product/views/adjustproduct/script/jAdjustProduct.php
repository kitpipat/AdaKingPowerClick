<script>
$(function(){
    JSxAJPCallPageFrom();
});

$('#oliAdjPdtTitle').click(function(){
    JSxAJPCallPageFrom();
});

$('#obtCallBackAdjustProductExport').click(function(){
    window.open('adjustProductExportData' , '_blank');
});

$('#obtCallBackAdjustProductList').click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $.ajax({
            type: "POST",
            url: "product/0/0",
            error: function (jqXHR, textStatus, errorThrown) {
    
                JCNxCloseLoading();
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
            success: function (tView) {

                //console.log(tView);
                $(window).scrollTop(0);
                $('.odvMainContent').html(tView);

                // Chk Status Favorite
                JSxChkStaDisFavorite('product/0/0');
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
});

function JSxAJPCallPageFrom(){
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $.ajax({
            type: "POST",
            url: "adjustProductPageFrom",
            cache: false,
            timeout: 0,
            success: function(tView) {
                $('#odvContentPageAdjustProduct').html(tView);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}
</script>