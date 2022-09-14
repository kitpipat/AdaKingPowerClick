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

    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true,
    });

    // Event Click On/Off Advance Search
    $('#oahTRNAdvanceSearch').unbind().click(function(){
        if($('#odvTRNAdvanceSearchContainer').hasClass('hidden')){
            $('#odvTRNAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
        }else{
            $("#odvTRNAdvanceSearchContainer").slideUp(500,function() {
                $(this).addClass('hidden');
            });
        }
    });

    // ======================= Option Branch Advance Search =======================
    var oASTBrowseBch   = function(poReturnInput){

        
        var tUsrLevel 	  	= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var nCountBch 		= "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
        var tWhere 			= "";

        if(nCountBch == 1){
            $('#obtASTBrowseBchFrom').attr('disabled',true);
            $('#obtASTBrowseBchTo').attr('disabled',true);
        }
        if(tUsrLevel != "HQ"){
            tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
        }else{
            tWhere = "";
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
                // SourceOrder : "ASC"
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

    $('#obtTBISubmitFrmSearchAdv').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTBICallPageTransferReceiptDataTable();
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
    function JSxTBIClearSearchData(){
       
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
            JSvTBICallPageTransferReceiptDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

</script>