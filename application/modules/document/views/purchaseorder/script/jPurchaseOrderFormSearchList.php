<script type="text/javascript">
    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit"); ?>;

    $(document).ready(function(){
        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });

        // Doc Date From
        $('#obtPOAdvSearchDocDateForm').unbind().click(function(){
            $('#oetPOAdvSearcDocDateFrom').datepicker('show');
        });

        // Doc Date To
        $('#obtPOAdvSearchDocDateTo').unbind().click(function(){
            $('#oetPOAdvSearcDocDateTo').datepicker('show');
        });
        
    });

    // Advance search Display control
    $('#obtPOAdvanceSearch').unbind().click(function(){
        if($('#odvPOAdvanceSearchContainer').hasClass('hidden')){
            $('#odvPOAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
        }else{
            $("#odvPOAdvanceSearchContainer").slideUp(500,function() {
                $(this).addClass('hidden');
            });
        }
    });

    var nCountBch 		= "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    if(nCountBch == 1){
        $('#obtPOAdvSearchBrowseBchFrom').attr('disabled',true);
        $('#obtPOAdvSearchBrowseBchTo').attr('disabled',true);
    }
    // Option Branch
    var oPOBrowseBranch = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tWhereModal = "";
        var tUsrLevel   = "<?php echo $this->session->userdata("tSesUsrLevel");?>";
        var tBchMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        if(tUsrLevel != "HQ"){
            tWhereModal 	+= " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
        }
        var oOptionReturn       = {
            Title : ['company/branch/branch','tBCHTitle'],
            Table : {Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table : ['TCNMBranch_L'],
                On : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
            },
            Where : {
                Condition : [tWhereModal]
            },
            GrideView:{
                ColumnPathLang      : 'company/branch/branch',
                ColumnKeyLang       : ['tBCHCode','tBCHName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMBranch_L.FTBchName ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
            },
        }
        return oOptionReturn;
    };

    // Event Browse Branch From
    $('#obtPOAdvSearchBrowseBchFrom').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPOBrowseBranchFromOption  = oPOBrowseBranch({
                'tReturnInputCode'  : 'oetPOAdvSearchBchCodeFrom',
                'tReturnInputName'  : 'oetPOAdvSearchBchNameFrom'
            });
            JCNxBrowseData('oPOBrowseBranchFromOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Branch To
    $('#obtPOAdvSearchBrowseBchTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPOBrowseBranchToOption  = oPOBrowseBranch({
                'tReturnInputCode'  : 'oetPOAdvSearchBchCodeTo',
                'tReturnInputName'  : 'oetPOAdvSearchBchNameTo'
            });
            JCNxBrowseData('oPOBrowseBranchToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    
    $('#obtPOSearchReset').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxPOClearAdvSearchData();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Functionality: ฟังก์ชั่นล้างค่า Input Advance Search
    // Parameters: Button Event Click
    // Creator: 19/06/2019 Wasin(Yoshi)
    // Last Update: -
    // Return: Clear Value In Input Advance Search
    // ReturnType: -
    function JSxPOClearAdvSearchData(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $('#ofmPOFromSerchAdv').find('input').val('');
            $('#ofmPOFromSerchAdv').find('select').val(0).selectpicker("refresh");
            JSvPOCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // ====================================================  From Search Data Page Purchase Invioce ====================================================
        $('#oetPOSearchAllDocument').keyup(function(event){
            var nCodeKey    = event.which;
            if(nCodeKey == 13){
                event.preventDefault();
                var nStaSession = JCNxFuncChkSessionExpired();
                if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                    JSvPOCallPageDataTable();
                }else{
                    JCNxShowMsgSessionExpired();
                }
            }
        });
        
        $('#obtPOSerchAllDocument').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof nStaSession !== "undefined" && nStaSession == 1){
                JSvPOCallPageDataTable();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $("#obtPOAdvSearchSubmitForm").unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof nStaSession !== "undefined" && nStaSession == 1){
                JSvPOCallPageDataTable();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

    // =================================================================================================================================================



</script>