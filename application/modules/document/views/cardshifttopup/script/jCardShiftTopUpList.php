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
    $('#oahCardShiftTopUpAdvanceSearch').on('click', function() {
        if($('#odvCardShiftTopUpAdvanceSearchContainer').hasClass('hidden')){
            JSxCMNVisibleComponent('#odvCardShiftTopUpAdvanceSearchContainer', true, 'slideUD');
        }else{
            JSxCMNVisibleComponent('#odvCardShiftTopUpAdvanceSearchContainer', false, 'slideUD');
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
function JSxCardShiftTopUpClearSearchData(){
    try{
        $('#oetSearchAll').val("");
        $('#oetCardShiftTopUpSearchDocDateFrom').val("");
        $('#oetCardShiftTopUpSearchDocDateTo').val("");
        $('#oetCardShiftTopUpSearchCardQtyTo').val("");
        $(".selectpicker").val('0').selectpicker("refresh");
        JSvCardShiftTopUpCardShiftTopUpDataTable();
    }catch(err){
        console.log("JSxCardShiftTopUpClearSearchData Error: ", err);
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
function JSoCardShiftTopUpGetSearchData(){
    try{
        let oAdvanceSearchData = {
            tSearchAll : $('#oetSearchAll').val(),
            tSearchDocDateFrom : $('#oetCardShiftTopUpSearchDocDateFrom').val(),
            tSearchDocDateTo : $('#oetCardShiftTopUpSearchDocDateTo').val(),
            tSearchStaDoc : $('#ocmCardShiftTopUpStaDoc').val(),
            tSearchStaPrc : $('#ocmCardShiftTopUpStaPrcDoc').val(),
            tSearchStaDocAct : $('#ocmStaDocAct').val(),
            tSearchStaApprove : $('#ocmCardShiftTopUpStaApprove').val()
        };
        return oAdvanceSearchData;
    }catch(err){
        console.log("JSoCardShiftTopUpGetSearchData Error: ", err);
    }
}
</script>

