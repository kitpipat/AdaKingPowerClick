<script>

    $(document).ready(function(){
        JSxPTUPageStep4CheckAndConfirm();
    });

    // แสดงรายการ ประเภทบัตร
    // Create By : Napat(Jame) 23/09/2020
    function JSxPTUPageStep4CheckAndConfirm(){
        $.ajax({
            type: "POST",
            url: "docPTUPageStep4CheckAndConfirm",
            data: {
                'tDocNo'    : $('#oetPTUDocNo').val(),
                'tBchCode'  : $('#oetPTUBchCode').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvPTUDataTableStep4').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

</script>