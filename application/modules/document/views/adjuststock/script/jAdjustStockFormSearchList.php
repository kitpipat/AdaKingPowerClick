<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

    $(document).ready(function(){
        $('.selectpicker').selectpicker();

        // Set Select  Doc Date
        $('#obtASTDocDateForm').unbind().click(function(){
            event.preventDefault();
            $('#oetASTDocDateFrom').datepicker('show');
        });

        $('#obtASTDocDateTo').unbind().click(function(){
            event.preventDefault();
            $('#oetASTDocDateTo').datepicker('show');
        });
    });

    // Event Click On/Off Advance Search
    $('#oahASTAdvanceSearch').unbind().click(function(){
        if($('#odvASTAdvanceSearchContainer').hasClass('hidden')){
            $('#odvASTAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
        }else{
            $("#odvASTAdvanceSearchContainer").slideUp(500,function() {
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
        $('#obtBrowseASTBCH').attr('disabled', true);
    }

    if(tUsrLevel != "HQ"){
        tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
    }else{
        tWhere = "";
    }

    var oASTBrowseBch   = function(poReturnInput){
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
    $('#obtASTBrowseBchFrom').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oASTBrowseBchFromOption = oASTBrowseBch({
                'tReturnInputCode'  : 'oetASTBchCodeFrom',
                'tReturnInputName'  : 'oetASTBchNameFrom'
            });
            JCNxBrowseData('oASTBrowseBchFromOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Branch To
    $('#obtASTBrowseBchTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oASTBrowseBchToOption = oASTBrowseBch({
                'tReturnInputCode'  : 'oetASTBchCodeTo',
                'tReturnInputName'  : 'oetASTBchNameTo'
            });
            JCNxBrowseData('oASTBrowseBchToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // ============================================================================

    $('#obtASTSubmitFrmSearchAdv').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvASTCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Functionality: ฟังก์ชั่นล้างค่า Input Advance Search
    // Parameters: Button Event Click
    // Creator: 06/06/2019 Wasin(Yoshi)
    // Last Update: -
    // Return: Clear Value In Input Advance Search
    // ReturnType: -
    function JSxASTClearSearchData(){
       
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){

            var nCountBch = "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
            if(nCountBch != 1){ //ถ้ามีมากกว่า 1 สาขาต้อง reset 
                $("#oetASTBchCodeFrom").val("");
                $("#oetASTBchNameFrom").val(""); 
                $("#oetASTBchCodeTo").val("");
                $("#oetASTBchNameTo").val("");
            }

            $("#oetSearchAll").val("");
            $("#oetASTDocDateFrom").val("");
            $("#oetASTDocDateTo").val("");
            $(".xCNDatePicker").datepicker("setDate", null);
            $(".selectpicker")
            .val("0")
            .selectpicker("refresh");
            JSvASTCallPageDataTable();
            // $('#ofmASTFromSerchAdv').find('input').val('');
            // $('#ofmASTFromSerchAdv').find('select').val(0)
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

</script>