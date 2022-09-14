<script type="text/javascript">

$(document).ready(function(){
    
    JSxCMNVisibleComponent('#obtCreditNoteCancel', true);
    JSxCMNVisibleComponent('#obtCreditNoteApprove', true);
    JSxCMNVisibleComponent('#odvBtnAddEdit .btn-group', true);
    
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
        todayHighlight: true,
        autoclose: true,
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
$('#oahCreditNoteAdvanceSearch').on('click', function() {
    if($('#odvCreditNoteAdvanceSearchContainer').hasClass('hidden')){
        JSxCMNVisibleComponent('#odvCreditNoteAdvanceSearchContainer', true, 'slideUD');
    }else{
        JSxCMNVisibleComponent('#odvCreditNoteAdvanceSearchContainer', false, 'slideUD');
    }
});

var tUsrLevel 	  	= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
var tBchCodeMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
var nCountBch 		= "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
var tWhere 			= "";

if(nCountBch == 1){
    $('#obtCreditNoteBrowseBchFrom').attr('disabled',true);
    $('#obtCreditNoteBrowseBchTo').attr('disabled',true);
}
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
        Perpage: 10,
        OrderBy: ['TCNMBranch.FDCreateOn DESC'],
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
        Perpage: 10,
        OrderBy: ['TCNMBranch.FDCreateOn DESC'],
    },
    CallBack:{
        ReturnType: 'S',
        Value: ["oetBchCodeTo", "TCNMBranch.FTBchCode"],
        Text: ["oetBchNameTo", "TCNMBranch_L.FTBchName"]
    }
};
// Option Branch To

// Event Browse
$('#obtCreditNoteBrowseBchFrom').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        JCNxBrowseData('oPmhBrowseBchFrom');
    }else{
        JCNxShowMsgSessionExpired();
    }
});
$('#obtCreditNoteBrowseBchTo').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        JCNxBrowseData('oPmhBrowseBchTo');
    }else{
        JCNxShowMsgSessionExpired();
    }
});



/**
 * Functionality : Clear search data
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCreditNoteClearSearchData() {
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
            JSvCallPageCreditNotePdtDataTable();
        } catch (err) {
            console.log("JSxCreditNoteClearSearchData Error: ", err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

</script>










