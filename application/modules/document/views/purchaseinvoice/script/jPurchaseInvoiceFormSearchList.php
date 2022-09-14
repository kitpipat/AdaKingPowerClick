<script type="text/javascript">
    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit"); ?>;

    $(document).ready(function(){
        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });

        // Doc Date From
        $('#obtPIAdvSearchDocDateForm').unbind().click(function(){
            $('#oetPIAdvSearcDocDateFrom').datepicker('show');
        });

        // Doc Date To
        $('#obtPIAdvSearchDocDateTo').unbind().click(function(){
            $('#oetPIAdvSearcDocDateTo').datepicker('show');
        });
        
    });

    // Advance search Display control
    $('#obtPIAdvanceSearch').unbind().click(function(){
        if($('#odvPIAdvanceSearchContainer').hasClass('hidden')){
            $('#odvPIAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
        }else{
            $("#odvPIAdvanceSearchContainer").slideUp(500,function() {
                $(this).addClass('hidden');
            });
        }
    });

    var nCountBch 		= "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    if(nCountBch == 1){
        $('#obtPIAdvSearchBrowseBchFrom').attr('disabled',true);
        $('#obtPIAdvSearchBrowseBchTo').attr('disabled',true);
    }
    
    // Option Branch
    var oPIBrowseBranch = function(poReturnInput){

        var tWhereModal = "";
        var tUsrLevel   = "<?php echo $this->session->userdata("tSesUsrLevel");?>";
        var tBchMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        if(tUsrLevel != "HQ"){
            tWhereModal 	+= " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
        }
            
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
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
                Perpage             : 10,
                OrderBy             : ['TCNMBranch.FDCreateOn DESC'],
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
    $('#obtPIAdvSearchBrowseBchFrom').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPIBrowseBranchFromOption  = oPIBrowseBranch({
                'tReturnInputCode'  : 'oetPIAdvSearchBchCodeFrom',
                'tReturnInputName'  : 'oetPIAdvSearchBchNameFrom'
            });
            JCNxBrowseData('oPIBrowseBranchFromOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Branch To
    $('#obtPIAdvSearchBrowseBchTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPIBrowseBranchToOption  = oPIBrowseBranch({
                'tReturnInputCode'  : 'oetPIAdvSearchBchCodeTo',
                'tReturnInputName'  : 'oetPIAdvSearchBchNameTo'
            });
            JCNxBrowseData('oPIBrowseBranchToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    
    $('#obtPISearchReset').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxPIClearAdvSearchData();
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
    function JSxPIClearAdvSearchData(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){

            var nCountBch = "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
            if(nCountBch != 1){ //ถ้ามีมากกว่า 1 สาขาต้อง reset 
                $('#oetPIAdvSearchBchNameFrom').val("");
                $('#oetPIAdvSearchBchCodeFrom').val("");
                $('#oetPIAdvSearchBchCodeTo').val("");
                $('#oetPIAdvSearchBchNameTo').val("");
            }

            $('#oetPIAdvSearcDocDateFrom').val("");
            $('#oetPIAdvSearcDocDateTo').val("");

            $('#ofmPIFromSerchAdv').find('select').val(0).selectpicker("refresh");
            JSvPICallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // ====================================================  From Search Data Page Purchase Invioce ====================================================
        $('#oetPISearchAllDocument').keyup(function(event){
            var nCodeKey    = event.which;
            if(nCodeKey == 13){
                event.preventDefault();
                var nStaSession = JCNxFuncChkSessionExpired();
                if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                    JSvPICallPageDataTable();
                }else{
                    JCNxShowMsgSessionExpired();
                }
            }
        });
        
        $('#obtPISerchAllDocument').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof nStaSession !== "undefined" && nStaSession == 1){
                JSvPICallPageDataTable();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $("#obtPIAdvSearchSubmitForm").unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof nStaSession !== "undefined" && nStaSession == 1){
                JSvPICallPageDataTable();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

    // =================================================================================================================================================



</script>