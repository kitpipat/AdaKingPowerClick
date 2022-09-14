<script>

    $('document').ready(function() {
       JSvTAXDataTable(1);
    });

    //STEP 1 เรียกข้อมูลในตาราง
    function JSvTAXDataTable(pnPageCurrent){
        var tTypeABB = $('#ohdTypeABB').val();
        if(pnPageCurrent == '' || pnPageCurrent == null){ pnPageCurrent = 1; }
        $.ajax({
            type    : "POST",
            url     : "TaxinvoiceABBTable",
            data    : { 
                tTypeABB        : tTypeABB,
                nPageCurrent    : pnPageCurrent
            },
            success: function(tResult){
                $("#ostDataTaxinvoiceABB").html(tResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

</script>