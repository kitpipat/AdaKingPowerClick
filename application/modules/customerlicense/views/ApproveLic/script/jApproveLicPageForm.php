<script type="text/javascript">
JSxControlRegBusOth();
    $('#ocmRegBusType').on('change',function(){
        JSxControlRegBusOth();
    });

function JSxControlRegBusOth(){
    if($('#ocmRegBusType').val()=='5'){
                $('#odvRegBusOth').show();
            }else{
                $('#odvRegBusOth').hide();
            }
}
</script>
