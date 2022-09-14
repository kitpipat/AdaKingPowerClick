<script type="text/javascript">
    // Set Event Click 
        $('#obtBchStart').unbind().click(function(){$('#oetPosRegDate').datepicker('show');});

        $('#obtPosRegDate').unbind().click(function(){
            $('#oetPosRegDate').datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
                enableOnReadonly: false,
                startDate :'1900-01-01',
                disableTouchKeyboard : true,
                autoclose: true,
            });
            $('#oetPosRegDate').datepicker('show');
        });

</script>