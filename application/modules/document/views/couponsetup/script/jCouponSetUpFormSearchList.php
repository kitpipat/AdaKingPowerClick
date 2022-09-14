<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

    $(document).ready(function(){
        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            autoclose		: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });

        // Doc Date From
        $('#obtCPHAdvSearchDocDateForm').unbind().click(function(){
            $('#oetCPHAdvSearcDocDateFrom').datepicker('show');
        });

        // Doc Date To
        $('#obtCPHAdvSearchDocDateTo').unbind().click(function(){
            $('#oetCPHAdvSearcDocDateTo').datepicker('show');
        });
    });

    // Advance search Display control
    $('#obtCPHAdvanceSearch').unbind().click(function(){
        if($('#odvCPHAdvanceSearchContainer').hasClass('hidden')){
            $('#odvCPHAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
        }else{
            $("#odvCPHAdvanceSearchContainer").slideUp(500,function() {
                $(this).addClass('hidden');
            });
        }
    });

    var tUsrLevel 	  	= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
	var tBchCodeMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
	var nCountBch 		= "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
	var tWhere 			= "";

	if(nCountBch == 1){
		$('#obtCPHAdvSearchBrowseBchFrom').attr('disabled',true);
		$('#obtCPHAdvSearchBrowseBchTo').attr('disabled',true);
	}
	if(tUsrLevel != "HQ"){
		tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
	}else{
		tWhere = "";
	}


    // Option Branch
    var oCPHBrowseBranch    = function(poCPHBchReturnInput){
        let tCPHBchInputReturnCode  = poCPHBchReturnInput.tReturnInputCode;
        let tCPHBchInputReturnName  = poCPHBchReturnInput.tReturnInputName;
        let oCPHBchOptionReturn     = {
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
                Perpage             : 20,
                OrderBy             : ['TCNMBranch.FTBchCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tCPHBchInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tCPHBchInputReturnName,"TCNMBranch_L.FTBchName"],
            },
        }
        return oCPHBchOptionReturn;
    };

    // Event Browse Branch From
    $('#obtCPHAdvSearchBrowseBchFrom').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oCPHBrowseBranchFromOption   = undefined;
            oCPHBrowseBranchFromOption          = oCPHBrowseBranch({
                'tReturnInputCode'  : 'oetCPHAdvSearchBchCodeFrom',
                'tReturnInputName'  : 'oetCPHAdvSearchBchNameFrom'
            });
            JCNxBrowseData('oCPHBrowseBranchFromOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Branch To
    $('#obtCPHAdvSearchBrowseBchTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oCPHBrowseBranchToOption = undefined;
            oCPHBrowseBranchToOption        = oCPHBrowseBranch({
                'tReturnInputCode'  : 'oetCPHAdvSearchBchCodeTo',
                'tReturnInputName'  : 'oetCPHAdvSearchBchNameTo'
            });
            JCNxBrowseData('oCPHBrowseBranchToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtCPHSearchReset').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCPHClearAdvSearchData();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Functionality: ฟังก์ชั่นล้างค่า Input Advance Search
    // Parameters: Button Event Click
    // Creator: 23/12/2019 Wasin(Yoshi)
    // Last Update -
    // Return: Clear Value In Input Advance Search
    // ReturnType: -
    function JSxCPHClearAdvSearchData(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){

            var nCountBch = "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
            if(nCountBch != 1){ //ถ้ามีมากกว่า 1 สาขาต้อง reset 
                $("#oetCPHAdvSearchBchNameFrom").val("");
                $("#oetCPHAdvSearchBchCodeFrom").val("");
                $("#oetCPHAdvSearchBchNameTo").val("");
                $("#oetCPHAdvSearchBchCodeTo").val("");
            }

            $("#oetSearchAll").val("");
            $("#oetCPHAdvSearcDocDateFrom").val("");
            $("#oetCPHAdvSearcDocDateTo").val("");

            $('#ofmCPHFromSerchAdv').find('select').val(0).selectpicker("refresh");
            JSvCPHCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // ====================================================  From Search Data Page Purchase Invioce ====================================================
    $('#oetCPHSearchAllDocument').keyup(function(event){
        var nCodeKey    = event.which;
        if(nCodeKey == 13){
            event.preventDefault();
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSvCPHCallPageDataTable();
            }else{
                JCNxShowMsgSessionExpired();
            }
        }
    });

    $('#obtCPHSerchAllDocument').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            JSvCPHCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $("#obtCPHAdvSearchSubmitForm").unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            JSvCPHCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // 27/06/2022 Napat(Jame)
    // 24/08/2022 Napat(Jame) - Hold Task ไว้ เนื่องจากลูกค้ายกเลิก
	// กดนำเข้า จะวิ่งไป Modal popup ที่ center
	// $('#obtCPHEventImportFile').click(function() {
    $('#obtCPHEventImportFile').off('click').on('click', function(){
		var tNameModule = 'coupon';
		var tTypeModule = 'master';
		var tAfterRoute = 'dcmCPHPageImportDataTable'; //productPageImportDataTable

		var aPackdata = {
			'tNameModule': tNameModule,
			'tTypeModule': tTypeModule,
			'tAfterRoute': tAfterRoute
		};
		JSxImportPopUp(aPackdata);
	});
</script>