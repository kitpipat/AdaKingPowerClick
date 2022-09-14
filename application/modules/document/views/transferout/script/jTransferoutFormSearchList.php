<script type="text/javascript">

$(document).ready(function(){
    $('.selectpicker').selectpicker();

    // Set Select  Doc Date
    $('#obtTxoDocDateForm').unbind().click(function(){
		event.preventDefault();
		$('#oetTxoDocDateFrom').datepicker('show');
	});

    $('#obtTxoDocDateTo').unbind().click(function(){
		event.preventDefault();
		$('#oetTxoDocDateTo').datepicker('show');
	});

});

// Event Click On/Off Advance Search
$('#oahTXOAdvanceSearch').unbind().click(function(){
    if($('#odvTXOAdvanceSearchContainer').hasClass('hidden')){
        $('#odvTXOAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
    }else{
        $("#odvTXOAdvanceSearchContainer").slideUp(500,function() {
            $(this).addClass('hidden');
        });
    }
});

// Option Branch
var oTxoBrowseBch   = function(poReturnInput){
    var tInputReturnCode    = poReturnInput.tReturnInputCode;
    var tInputReturnName    = poReturnInput.tReturnInputName;
    var oOptionReturn       = {
        Title : ['company/branch/branch','tBCHTitle'],
        Table : {Master:'TCNMBranch',PK:'FTBchCode'},
        Join :{
		    Table : ['TCNMBranch_L'],
		    On : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang : 'company/branch/branch',
            ColumnKeyLang : ['tBCHCode','tBCHName'],
            ColumnsSize : ['15%','75%'],
            WidthModal : 50,
            DataColumns : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['',''],
            Perpage : 20,
            OrderBy : ['TCNMBranch_L.FTBchName'],
            SourceOrder : "ASC"
        },
        CallBack:{
		    ReturnType	: 'S',
            Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
            Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
        },
    }
    return oOptionReturn;
} 

// Event Browse
$('#obtTxoBrowseBchFrom').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        window.oTxoBrowseBchFromOption = oTxoBrowseBch({
            'tReturnInputCode'  : 'oetTxoBchCodeFrom',
            'tReturnInputName'  : 'oetTxoBchNameFrom'
        });
        JCNxBrowseData('oTxoBrowseBchFromOption');
    }else{
        JCNxShowMsgSessionExpired();
    }
});

$('#obtTxoBrowseBchTo').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        window.oTxoBrowseBchToOption = oTxoBrowseBch({
            'tReturnInputCode'  : 'oetTxoBchCodeTo',
            'tReturnInputName'  : 'oetTxoBchNameTo'
        });
        JCNxBrowseData('oTxoBrowseBchToOption');
    }else{
        JCNxShowMsgSessionExpired();
    }
});

$('#obtTXOSubmitFrmSearchAdv').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JSvTXOCallPageDataTable();
    }else{
        JCNxShowMsgSessionExpired();
    }
});

// Functionality: ฟังก์ชั่นล้างค่า Input Advance Search
// Parameters: Button Event Click
// Creator: 03/05/2019 Wasin(Yoshi)
// Last Update: -
// Return: Clear Value In Input Advance Search
// ReturnType: -
function JSxTXOClearSearchData(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1){
        $('#ofmTXOFromSerchAdv').find('input').val('');
        $('#ofmTXOFromSerchAdv').find('select').val(0).selectpicker("refresh");
        JSvTXOCallPageDataTable();
    }else{
        JCNxShowMsgSessionExpired();
    }
}



</script>