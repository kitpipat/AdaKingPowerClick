<script>

//Check Status Table
JSvPSHCheckStatusTableData();
function JSvPSHCheckStatusTableData(){
   var tBchCode = $('#oetInputPSHCheckStatusBchCode').val();
   if(tBchCode == '' || tBchCode == null ){
        $('#oetInputPSHCheckStatusBchName').focus();
   }else{
        $('#odvPSHCheckStatusContent').html('<div class="col-xs-12 col-md-4 col-lg-4"></div>'+
                        '<div class="col-xs-12 col-md-12 col-lg-6">'+
                            '<div id="odvLayoutCheckStatus"></div>'+
                        '</div>'+
                        '<div class="col-xs-12 col-md-12 col-lg-2"></div>'
        );

        var nWidth = $('#odvLayoutCheckStatus').width();
        JCNxOpenLoading();
        setTimeout(function(){ 
            $.ajax({
                type: "POST",
                url : "PSHSmartLockerCheckStatusDataTable",
                data: { 
                    tBchCode      : $('#oetInputPSHCheckStatusBchCode').val() ,
                    tShpCode      : $('#oetPshPSHShpCod').val(),
                    tRack         : $('#osmPSHCheckStatusLayoutRack option:selected').val(),
                    tSaleMac      : $('#oetPosCodeSN').val(),
                    nWidth        : nWidth
                },
                success: function(tResult) {
                    JCNxCloseLoading();
                    $('#odvPSHCheckStatusContent').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }, 1000);
   }
}

</script>