<script type="text/javascript">
    var nLangEdits  = '<?=$this->session->userdata("tLangEdit");?>';

    $(document).ready(function(){
        $('.selectpicker').selectpicker();

        // Set Select Doc Date
        $('#obtAPODocDateForm').unbind().click(function(){
            event.preventDefault();
            $('#oetAPODocDateFrom').datepicker('show');
        });

        $('#obtAPODocDateTo').unbind().click(function(){
            event.preventDefault();
            $('#oetAPODocDateTo').datepicker('show');
        });
    });

    //กดค้นหาขั้นสูง
    $('#oahPOAdvanceSearch').unbind().click(function(){
        if($('#odvPOAdvanceSearchContainer').hasClass('hidden')){
            $('#odvPOAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
        }else{
            $("#odvPOAdvanceSearchContainer").slideUp(500,function() {
                $(this).addClass('hidden');
            });
        }
    });

    // ======================= Option Branch Advance Search =======================
    var oAPOBrowseBch   = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title   : ['company/branch/branch','tBCHTitle'],
            Table   : {Master:'TCNMBranch',PK:'FTBchCode'},
            Join    : {
                Table   : ['TCNMBranch_L'],
                On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
            },
            GrideView   :{
                ColumnPathLang      : 'company/branch/branch',
                ColumnKeyLang       : ['tBCHCode','tBCHName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMBranch_L.FTBchName'],
                SourceOrder         : "ASC"
            },
            CallBack:{
            ReturnType	    : 'S',
                Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
            },
        }
        return oOptionReturn;
    }

    // Branch From
    $('#obtAPOBrowseBchFrom').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oAPOBrowseBchFromOption = oAPOBrowseBch({
                'tReturnInputCode'  : 'oetAPOBchCodeFrom',
                'tReturnInputName'  : 'oetAPOBchNameFrom'
            });
            JCNxBrowseData('oAPOBrowseBchFromOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Branch To
    $('#obtAPOBrowseBchTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oAPOBrowseBchToOption = oAPOBrowseBch({
                'tReturnInputCode'  : 'oetASTBchCodeTo',
                'tReturnInputName'  : 'oetASTBchNameTo'
            });
            JCNxBrowseData('oAPOBrowseBchToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // ============================================================================

    $('#obtPOSubmitFrmSearchAdv').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvPOCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //ฟังก์ชั่นล้างค่า Input Advance Search
    function JSxPOClearSearchData(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $("#oetSearchAll").val("");
            $("#oetAPOBchCodeFrom").val("");
            $("#oetAPOBchNameFrom").val("");
            $("#oetAPOBchCodeTo").val("");
            $("#oetAPOBchNameTo").val("");
            $("#oetAPODocDateFrom").val("");
            $("#oetAPODocDateTo").val("");
            $(".xCNDatePicker").datepicker("setDate", null);
            $(".selectpicker").val("0").selectpicker("refresh");
            JSvPOCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

</script>