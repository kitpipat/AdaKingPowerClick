<script type="text/javascript">
    $(document).ready(function(){
        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        });


        if($('#oetBchCode').val() != ''){
            var tBchId = $('#oetBchCode').val();
            window.onload = JSvPRKCallPageBranchEdit(tBchId);
        }
        

        if(JCNbUserIsUpdatePage()){
            // Card Code
            $("#oetBchCode").attr("readonly", true);
            $('#ocbBchAutoGenCode input').attr('disabled', true);
            JSxUserVisibleComponent('#ocbBchAutoGenCode', false);
        }

        if(JCNbUserIsCreatePage()){
            // Card Code
            $("#oetBchCode").attr("disabled", true);
            $('#ocbBchAutoGenCode').change(function(){
                if($('#ocbBchAutoGenCode').is(':checked')) {
                    $("#oetBchCode").attr("disabled", true);
                    $("#oetBchCode").val('');
                    $('#odvBchCodeForm').removeClass('has-error');
                    $('#odvBchCodeForm em').remove();
                }else{
                    $("#oetBchCode").attr("disabled", false);
                }
            });
            JSxUserVisibleComponent('#ocbBchAutoGenCode', true);
        }

            if(JCNbUserIsUpdatePage()){
            // Card Code
            $("#oetBchCode").attr("readonly", true);
            $('#ocbBchAutoGenCode input').attr('disabled', true);
            JSxUserVisibleComponent('#ocbBchAutoGenCode', false);
        }

    });
</script>






