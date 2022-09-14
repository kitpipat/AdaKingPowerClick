<script type="text/javascript">

$(document).ready(function(){
    $('.selectpicker').selectpicker();

    $('#obtXphDocDateFrom').click(function(){
        event.preventDefault();
        $('#oetXphDocDateFrom').datepicker('show');
    });

    $('#obtXphDocDateTo').click(function(){
        event.preventDefault();
        $('#oetXphDocDateTo').datepicker('show');
    });

    $('.xCNDatePicker').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true
    });

    $(".selection-2").select2({
        // minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });

    /*FSvGetSelectShpByBch('');

    $('#ostBchCode').change(function(){
        tBchCode = $(this).val();
        FSvGetSelectShpByBch(tBchCode);
    });*/
});

// Advance search display control
$('#oahAdjStkSumAdvanceSearch').on('click', function() {
    if($('#odvAdjStkSumAdvanceSearchContainer').hasClass('hidden')){
        $('#odvAdjStkSumAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
    }else{
        $('#odvAdjStkSumAdvanceSearchContainer').addClass('hidden fadeIn');
    }
});

var tUsrLevel 	  	= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
var tBchCodeMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
var nCountBch 		= "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
var tWhere 			= "";

if(tUsrLevel != "HQ"){
    tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
}else{
    tWhere = "";
}

// Option Branch From
var oPmhBrowseBchFrom = {
    Title: ['company/branch/branch', 'tBCHTitle'],
    Table: {Master:'TCNMBranch', PK:'FTBchCode'},
    Join: {
        Table: ['TCNMBranch_L'],
        On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
    },
    Where:{
        Condition : [tWhere]
    },
    GrideView: {
        ColumnPathLang: 'company/branch/branch',
        ColumnKeyLang: ['tBCHCode', 'tBCHName'],
        ColumnsSize: ['15%', '75%'],
    WidthModal: 50,
        DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
        DataColumnsFormat: ['', ''],
        Perpage: 5,
        OrderBy: ['TCNMBranch_L.FTBchName'],
        SourceOrder: "ASC"
    },
    CallBack: {
        ReturnType: 'S',
        Value: ["oetBchCodeFrom", "TCNMBranch.FTBchCode"],
        Text: ["oetBchNameFrom", "TCNMBranch_L.FTBchName"]
    }
};
// Option Branch From

// Option Branch To
var oPmhBrowseBchTo = {
    Title: ['company/branch/branch', 'tBCHTitle'],
    Table: {Master:'TCNMBranch', PK:'FTBchCode'},
    Join: {
        Table: ['TCNMBranch_L'],
        On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
    },
    Where:{
        Condition : [tWhere]
    },
    GrideView: {
        ColumnPathLang: 'company/branch/branch',
        ColumnKeyLang: ['tBCHCode', 'tBCHName'],
        ColumnsSize: ['15%', '75%'],
    WidthModal: 50,
        DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
        DataColumnsFormat: ['', ''],
        Perpage: 5,
        OrderBy: ['TCNMBranch_L.FTBchName'],
        SourceOrder: "ASC"
    },
    CallBack:{
        ReturnType: 'S',
        Value: ["oetBchCodeTo", "TCNMBranch.FTBchCode"],
        Text: ["oetBchNameTo", "TCNMBranch_L.FTBchName"]
    }
};
// Option Branch To

// Event Browse
$('#obtAdjStkSumBrowseBchFrom').click(function(){ JCNxBrowseData('oPmhBrowseBchFrom'); });
$('#obtAdjStkSumBrowseBchTo').click(function(){ JCNxBrowseData('oPmhBrowseBchTo'); });

/**
 * Functionality : Clear search data
 * Parameters : -
 * Creator : 22/05/2019 Piya(Tiger)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSumClearSearchData() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            var nCountBch = "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
            if(nCountBch != 1){ //ถ้ามีมากกว่า 1 สาขาต้อง reset 
                $("#oetBchCodeFrom").val("");
                $("#oetBchNameFrom").val("");
                $("#oetBchCodeTo").val("");
                $("#oetBchNameTo").val("");
            }

            $("#oetSearchAll").val("");
            $("#oetSearchDocDateFrom").val("");
            $("#oetSearchDocDateTo").val("");
            $(".xCNDatePicker").datepicker("setDate", null);
            $(".selectpicker")
                    .val("0")
                    .selectpicker("refresh");
            JSvCallPageAdjStkSumPdtDataTable();
        } catch (err) {
            console.log("JSxAdjStkSumClearSearchData Error: ", err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

</script>





