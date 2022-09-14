<script>
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

$(document).ready(function(){
    $('.selectpicker').selectpicker();

    // Set Select  Doc Date
    $('#obtADCDocDateForm').unbind().click(function(){
        event.preventDefault();
        $('#oetADCDocDateFrom').datepicker('show');
    });

    $('#obtADCDocDateTo').unbind().click(function(){
        event.preventDefault();
        $('#oetADCDocDateTo').datepicker('show');
    });
});

// Event Click On/Off Advance Search
$('#oahADCAdvanceSearch').unbind().click(function(){
    if($('#odvADCAdvanceSearchContainer').hasClass('hidden')){
        $('#odvADCAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
    }else{
        $("#odvADCAdvanceSearchContainer").slideUp(500,function() {
            $(this).addClass('hidden');
        });
    }
});


    // ======================= Option Branch Advance Search =======================

    var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tWhere = "";

    if(nCountBch == 1){
        $('#obtBrowseADCBCH').attr('disabled', true);
    }

    if(tUsrLevel != "HQ"){
        tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
    }else{
        tWhere = "";
    }

    var oADCBrowseBch   = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title : ['company/branch/branch','tBCHTitle'],
            Table : {Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table : ['TCNMBranch_L'],
                On : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
            },
            Where:{
                Condition : [tWhere]
            },
            GrideView:{
                ColumnPathLang : 'company/branch/branch',
                ColumnKeyLang : ['tBCHCode','tBCHName'],
                ColumnsSize : ['15%','75%'],
                WidthModal : 50,
                DataColumns : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                Perpage : 10,
                OrderBy : ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack:{
            ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
            },
        }
        return oOptionReturn;
    }

    // Branch From
    $('#obtADCBrowseBchFrom').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oADCBrowseBchFromOption = oADCBrowseBch({
                'tReturnInputCode'  : 'oetADCBchCodeFrom',
                'tReturnInputName'  : 'oetADCBchNameFrom'
            });
            JCNxBrowseData('oADCBrowseBchFromOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Branch To
    $('#obtADCBrowseBchTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oADCBrowseBchToOption = oADCBrowseBch({
                'tReturnInputCode'  : 'oetADCBchCodeTo',
                'tReturnInputName'  : 'oetADCBchNameTo'
            });
            JCNxBrowseData('oADCBrowseBchToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // ============================================================================

    $('#obtADCSubmitFrmSearchAdv').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvADCCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    // Functionality: ฟังก์ชั่นล้างค่า Input Advance Search
    // Parameters: Button Event Click
    // Creator: 03/03/2021 Sooksanti
    // Last Update: -
    // Return: Clear Value In Input Advance Search
    // ReturnType: -
    function JSxADCClearSearchData(){
       
       var nStaSession = JCNxFuncChkSessionExpired();
       if(typeof nStaSession !== "undefined" && nStaSession == 1){

           var nCountBch = "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
           if(nCountBch != 1){ //ถ้ามีมากกว่า 1 สาขาต้อง reset 
               $("#oetADCBchCodeFrom").val("");
               $("#oetADCBchNameFrom").val(""); 
               $("#oetADCBchCodeTo").val("");
               $("#oetADCBchNameTo").val("");
           }

           $("#oetADCSearchAll").val("");
           $("#oetADCDocDateFrom").val("");
           $("#oetADCDocDateTo").val("");
           $(".xCNDatePicker").datepicker("setDate", null);
           $(".selectpicker")
           .val("0")
           .selectpicker("refresh");
           JSvADCCallPageDataTable();
           // $('#ofmASTFromSerchAdv').find('input').val('');
           // $('#ofmASTFromSerchAdv').find('select').val(0)
       }else{
           JCNxShowMsgSessionExpired();
       }
   }
</script>