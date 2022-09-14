<script>
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
    $(document).ready(function(){
        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            autoclose		: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });

        // Doc Date From
        $('#obtMCPAdvSearchDocDateForm').unbind().click(function(){
            $('#oetMCPAdvSearcDocDateFrom').datepicker('show');
        });

        // Doc Date To
        $('#obtMCPAdvSearchDocDateTo').unbind().click(function(){
            $('#oetMCPAdvSearcDocDateTo').datepicker('show');
        });
    });

    $('#obtMCPSearchReset').off('click').on('click',function(){
        var tSesUsrLevel    = '<?=$this->session->userdata("tSesUsrLevel")?>';
        var nSesUsrBchCount = '<?=$this->session->userdata("nSesUsrBchCount")?>';
        var tNot = '';
        if( tSesUsrLevel != 'HQ' && parseInt(nSesUsrBchCount) == 1 ){
            tNot = ":not(.xWNotClearInUsrBch)";
        }
        $('#ofmMCPFromSerchAdv input'+tNot).val('');
        $('#ofmMCPFromSerchAdv select').val('0').change();
        JSvMCPCallPageDataTable();
    });

    $("#obtMCPAdvSearchSubmitForm").unbind().click(function(){
        JSvMCPCallPageDataTable();
    });

    // Event Browse Branch 
    $('#obtMCPAdvSearchBrowseBch').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oMCPBrowseBranchOption   = undefined;
            oMCPBrowseBranchOption          = oMCPBrowseBranch({
                'tReturnInputCode'  : 'oetMCPAdvSearchBchCode',
                'tReturnInputName'  : 'oetMCPAdvSearchBchName'
            });
            JCNxBrowseData('oMCPBrowseBranchOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Option Branch
    var oMCPBrowseBranch    = function(poMCPBchReturnInput){

        let tUsrLevel 	  	= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        let tBchCodeMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        let tWhere 			= "";

        if( tUsrLevel != "HQ" ){
            tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
        }

        let tMCPBchInputReturnCode  = poMCPBchReturnInput.tReturnInputCode;
        let tMCPBchInputReturnName  = poMCPBchReturnInput.tReturnInputName;
        let oMCPBchOptionReturn     = {
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
                ColumnPathLang      : 'company/branch/branch',
                ColumnKeyLang       : ['tBCHCode','tBCHName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 10,
                OrderBy             : ['TCNMBranch.FTBchCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tMCPBchInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tMCPBchInputReturnName,"TCNMBranch_L.FTBchName"],
            },
        }
        return oMCPBchOptionReturn;
    };

</script>