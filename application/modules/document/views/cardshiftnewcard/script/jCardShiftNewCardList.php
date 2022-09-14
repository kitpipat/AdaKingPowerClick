<script type="text/javascript">
$(document).ready(function(){

    $('#obtSearchCardShiftNewCard').click(function(){
		JCNxOpenLoading();
		JSvCardShiftNewCardDataTable();
	});
	$('#oetSearchCardShiftNewCard').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvCardShiftNewCardDataTable();
		}
	});
        
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
    $('#oahCardShiftNewCardAdvanceSearch').on('click', function(){
        if($('#odvCardNewCardAdvanceSearchContainer').hasClass('hidden')){
            JSxCMNVisibleComponent('#odvCardNewCardAdvanceSearchContainer', true, 'slideUD');
        }else{
            JSxCMNVisibleComponent('#odvCardNewCardAdvanceSearchContainer', false, 'slideUD');
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
function JSxCardShiftNewCardClearSearchData(){
    try{
        $('#oetSearchCardShiftNewCard').val("");
        $('#oetCardShiftNewCardSearchDocDateFrom').val("");
        $('#oetCardShiftNewCardSearchDocDateTo').val("");
        $(".selectpicker").val('0').selectpicker("refresh");
        JSvCardShiftNewCardDataTable();
    }catch(err){
        console.log("JSxCardShiftNewCardClearSearchData Error: ", err);
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
function JSoCardShiftNewCardGetSearchData(){
    try{
        var oAdvanceSearchData = {
            tSearchAll : $('#oetSearchCardShiftNewCard').val(),
            tSearchDocDateFrom : $('#oetCardShiftNewCardSearchDocDateFrom').val(),
            tSearchDocDateTo : $('#oetCardShiftNewCardSearchDocDateTo').val(),
            tSearchStaDoc : $('#ocmCardNewCardStaDoc').val(),
            tSearchStaPrc : $('#ocmCardNewCardStaPrc').val(),
            tSearchStaAct   : $('#ocmCardNewCardStaDocAct').val()
        };
        return oAdvanceSearchData;
    }catch(err){
        console.log("JSoCardShiftNewCardGetSearchData Error: ", err);
    }
}
</script>

