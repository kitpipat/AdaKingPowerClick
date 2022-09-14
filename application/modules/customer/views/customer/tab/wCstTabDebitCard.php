<div id="odvTabDebitCard" class="tab-pane fade" style="width: 100%;"></div>

<script>
    $(document).ready(function(){
        //call list
        JSvCustomerDebitCardList(1)
    });

    function JSvCustomerDebitCardList(nPage){
        var ptCstCode =  $('#ohdCstCode').val();
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "DebitCardDataTable",
            data    : {
                tCstCode   :  ptCstCode,
                tSearchAll  : '',
                nPageCurrent  : nPage
            },
            cache : false,
            timeout : 0,
            success  : function (tResult){
                $('#odvTabDebitCard').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>