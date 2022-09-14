<script type="text/javascript">
$(document).ready(function() {
        
    $('body').on('focus',".xCNDatePicker", function(){
        $(this).datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            // startDate: new Date(),
            // startDate: '-3d',
            orientation: "bottom"
        });
    });

    $('.selectpicker').selectpicker();

    // Advance search display control
    $('#oahCardShiftReturnAdvanceSearch').on('click', function() {
        if($('#odvCardShiftReturnAdvanceSearchContainer').hasClass('hidden')){
            JSxCMNVisibleComponent('#odvCardShiftReturnAdvanceSearchContainer', true, 'slideUD');
        }else{
            JSxCMNVisibleComponent('#odvCardShiftReturnAdvanceSearchContainer', false, 'slideUD');
        }
    });
    
});

/**
* Functionality : Clear search data
* Parameters : -
* Creator : 12/12/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCardShiftReturnClearSearchData(){
    try{
        $('#oetSearchAll').val("");
        $('#oetCardShiftReturnSearchDocDateFrom').val("");
        $('#oetCardShiftReturnSearchDocDateTo').val("");
        $('#oetCardShiftReturnSearchCardQtyTo').val("");
        $(".selectpicker").val('0').selectpicker("refresh");
        JSvCardShiftReturnCardShiftReturnDataTable();
    }catch(err){
        console.log("JSxCardShiftReturnClearSearchData Error: ", err);
    }
}

/**
* Functionality : Get search data
* Parameters : -
* Creator : 12/12/2018 piya
* Last Modified : -
* Return : Search data
* Return Type : Object
*/
function JSoCardShiftReturnGetSearchData(){
    try{
        var oAdvanceSearchData = {
            tSearchAll          : $('#oetSearchAll').val(),
            tSearchDocDateFrom  : $('#oetCardShiftReturnSearchDocDateFrom').val(),
            tSearchDocDateTo    : $('#oetCardShiftReturnSearchDocDateTo').val(),
            tSearchStaDoc       : $('#ocmCardShiftReturnStaDoc').val(),
            tSearchStaPrcDoc    : $('#ocmCardShiftReturnStaPrcDoc').val(),
            tSearchStaDocAct    : $('#ocmCardNewCardStaDocAct').val(),
            tSearchStaApprove   : $('#ocmCardShiftReturnStaApprove').val()
        };
        return oAdvanceSearchData;
    }catch(err){
        console.log("JSoCardShiftReturnGetSearchData Error: ", err);
    }
}
</script>

