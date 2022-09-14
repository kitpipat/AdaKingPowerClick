<script type="text/javascript">
    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit"); ?>;

    $(document).ready(function(){


        var aPAMAdvSearch = JSON.parse(localStorage.getItem("oPAMAdvSearch"));
        // console.log(aPAMAdvSearch);
        // console.log(typeof(aPAMAdvSearch));
        if( aPAMAdvSearch !== null ){
            $('#oetPAMSearchAllDocument').val(aPAMAdvSearch['oetPAMSearchAllDocument']);

            $('#oetPAMBchCode').val(aPAMAdvSearch['oetPAMBchCode']);
            $('#oetPAMBchName').val(aPAMAdvSearch['oetPAMBchName']);
            $('#oetPAMPlcCode').val(aPAMAdvSearch['oetPAMPlcCode']);
            $('#oetPAMPlcName').val(aPAMAdvSearch['oetPAMPlcName']);


            $("#oetPAMCat1Code").val(aPAMAdvSearch['tSearchCat1Code']),
            $("#oetPAMCat1Name").val(aPAMAdvSearch['tSearchCat1Name']),
            $("#oetPAMCat2Code").val(aPAMAdvSearch['tSearchCat2Code']),
            $("#oetPAMCat2Name").val(aPAMAdvSearch['tSearchCat2Name']),
            $("#oetPAMCat3Code").val(aPAMAdvSearch['tSearchCat3Code']),
            $("#oetPAMCat3Name").val(aPAMAdvSearch['tSearchCat3Name']),
            $("#oetPAMCat4Code").val(aPAMAdvSearch['tSearchCat4Code']),
            $("#oetPAMCat4Name").val(aPAMAdvSearch['tSearchCat4Name']),
            $("#oetPAMCat5Code").val(aPAMAdvSearch['tSearchCat5Code']),
            $("#oetPAMCat5Name").val(aPAMAdvSearch['tSearchCat5Name']),

            $('#oetPAMDocDateFrm').val(aPAMAdvSearch['oetPAMDocDateFrm']);
            $('#oetPAMDocDateTo').val(aPAMAdvSearch['oetPAMDocDateTo']);

            $('#ocmPAMPackType').val(aPAMAdvSearch['ocmPAMPackType']).selectpicker("refresh");
            $('#ocmPAMStaDoc').val(aPAMAdvSearch['ocmPAMStaDoc']).selectpicker("refresh");
        }

        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            onSelect: function(date) {
                alert(date);
            },
            format                  : 'yyyy-mm-dd',
            enableOnReadonly        : false,
            disableTouchKeyboard    : true,
            autoclose               : true,
            todayHighlight          : true 
        });

        // Doc Date From
        $('#obtPAMDocDateFrm').unbind().click(function(){
            $('#oetPAMDocDateFrm').datepicker('show');
        });

        // Doc Date To
        $('#obtPAMDocDateTo').unbind().click(function(){
            $('#oetPAMDocDateTo').datepicker('show');
        });
        
    });
    
    $('#obtPAMClearSearch').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxPAMClearAdvSearchData();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // ล้างค่า Input ทั้งหมดใน Advance Search
    function JSxPAMClearAdvSearchData(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $('#ofmPAMSearchAdv').find('input').val('');
            $('#ofmPAMSearchAdv').find('select').val('').selectpicker("refresh");
            JSvPAMCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // ====================================================  From Search Data Page  ====================================================
        $("#obtPAMConfirmSearch").unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof nStaSession !== "undefined" && nStaSession == 1){

                // var oPAMAdvSearch = {
                //     'oetPAMSearchAllDocument'   : $('#oetPAMSearchAllDocument').val(),
                //     'oetPAMBchCode'             : $('#oetPAMBchCode').val(),
                //     'oetPAMBchName'             : $('#oetPAMBchName').val(),
                //     'oetPAMPlcCode'             : $('#oetPAMPlcCode').val(),
                //     'oetPAMPlcName'             : $('#oetPAMPlcName').val(),
                    
                //     'oetPAMDocDateFrm'          : $('#oetPAMDocDateFrm').val(),
                //     'oetPAMDocDateTo'           : $('#oetPAMDocDateTo').val(),

                //     'ocmPAMPackType'            : $('#ocmPAMPackType').val(),
                //     'ocmPAMStaDoc'              : $('#ocmPAMStaDoc').val(),
                // };
                // localStorage.setItem("oPAMAdvSearch", JSON.stringify(oPAMAdvSearch));
                JSvPAMCallPageDataTable();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
    // =================================================================================================================================================

    // Event Browse Branch From
    $('#obtPAMBrowseBch').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPAMBrowseBranchFromOption  = oPAMBrowseBranch({
                'tReturnInputCode'  : 'oetPAMBchCode',
                'tReturnInputName'  : 'oetPAMBchName'
            });
            JCNxBrowseData('oPAMBrowseBranchFromOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Option Branch
    var oPAMBrowseBranch = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;

        var tUsrLevel 	  	= "<?=$this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti 	= "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var nCountBch 		= "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
        var nLangEdits      = "<?=$this->session->userdata("tLangEdit")?>";
        var tWhere 			= "";

        if(nCountBch == 1){
            $('#obtPAMBrowseBch').attr('disabled',true);
        }

        if(tUsrLevel != "HQ"){
            tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
        }else{
            tWhere = "";
        }

        var oOptionReturn       = {
            Title : ['company/branch/branch','tBCHTitle'],
            Table : {Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table : ['TCNMBranch_L'],
                On : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
            },
            Where   : {
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

    // Event Browse Location
    $('#obtPAMBrowsePlc').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPAMBrowseLocationOption  = oPAMBrowseLocation({
                'tReturnInputCode'  : 'oetPAMPlcCode',
                'tReturnInputName'  : 'oetPAMPlcName'
            });
            JCNxBrowseData('oPAMBrowseLocationOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Option Location
    var oPAMBrowseLocation = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;

        var oOptionReturn       = {
            Title : ['product/pdtlocation/pdtlocation','tLOCTitle'],
            Table : {Master:'TCNMPdtLoc',PK:'FTPlcCode'},
            Join :{
                Table : ['TCNMPdtLoc_L'],
                On : ['TCNMPdtLoc_L.FTPlcCode = TCNMPdtLoc.FTPlcCode AND TCNMPdtLoc_L.FNLngID = '+nLangEdits,]
            },
            Where   : {
                Condition : [tWhere]
            },
            GrideView:{
                ColumnPathLang      : 'product/pdtlocation/pdtlocation',
                ColumnKeyLang       : ['tLOCFrmLocCode','tLOCFrmLocName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMPdtLoc.FTPlcCode','TCNMPdtLoc_L.FTPlcName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMPdtLoc.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdtLoc.FTPlcCode"],
                Text		: [tInputReturnName,"TCNMPdtLoc_L.FTPlcName"],
            },
        }
        return oOptionReturn;
    };

    // Event Browse Category 1
    $('#obtPAMBrowseCat1').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPAMBrowseCategoryOption  = oPAMBrowseCategory({
                'tReturnInputCode'  : 'oetPAMCat1Code',
                'tReturnInputName'  : 'oetPAMCat1Name',
                'nCatLevel'         :  1
            });
            JCNxBrowseData('oPAMBrowseCategoryOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Category 2
    $('#obtPAMBrowseCat2').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPAMBrowseCategoryOption  = oPAMBrowseCategory({
                'tReturnInputCode'  : 'oetPAMCat2Code',
                'tReturnInputName'  : 'oetPAMCat2Name',
                'nCatLevel'         :  2
            });
            JCNxBrowseData('oPAMBrowseCategoryOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Category 3
    $('#obtPAMBrowseCat3').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPAMBrowseCategoryOption  = oPAMBrowseCategory({
                'tReturnInputCode'  : 'oetPAMCat3Code',
                'tReturnInputName'  : 'oetPAMCat3Name',
                'nCatLevel'         :  3
            });
            JCNxBrowseData('oPAMBrowseCategoryOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Category 4
    $('#obtPAMBrowseCat4').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPAMBrowseCategoryOption  = oPAMBrowseCategory({
                'tReturnInputCode'  : 'oetPAMCat4Code',
                'tReturnInputName'  : 'oetPAMCat4Name',
                'nCatLevel'         :  4
            });
            JCNxBrowseData('oPAMBrowseCategoryOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Category 5
    $('#obtPAMBrowseCat5').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPAMBrowseCategoryOption  = oPAMBrowseCategory({
                'tReturnInputCode'  : 'oetPAMCat5Code',
                'tReturnInputName'  : 'oetPAMCat5Name',
                'nCatLevel'         :  5
            });
            JCNxBrowseData('oPAMBrowseCategoryOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Option Location
    var oPAMBrowseCategory = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var nCatLevel           = poReturnInput.nCatLevel;
        var tWhere              = " AND TCNMPdtCatInfo.FTCatStaUse = '1' ";

        if( nCatLevel != "" ){
            tWhere += " AND TCNMPdtCatInfo.FNCatLevel = "+nCatLevel+" ";
        }

        var oOptionReturn       = {
            Title : ['product/pdtcat/pdtcat','tCATTitle'],
            Table : {Master:'TCNMPdtCatInfo',PK:'FTCatCode'},
            Join :{
                Table : ['TCNMPdtCatInfo_L'],
                On : ['TCNMPdtCatInfo_L.FTCatCode = TCNMPdtCatInfo.FTCatCode AND TCNMPdtCatInfo_L.FNCatLevel = TCNMPdtCatInfo.FNCatLevel AND TCNMPdtCatInfo_L.FNLngID = '+nLangEdits,]
            },
            Where   : {
                Condition : [tWhere]
            },
            GrideView:{
                ColumnPathLang      : 'product/pdtcat/pdtcat',
                ColumnKeyLang       : ['tCATTBCode','tCATTBName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMPdtCatInfo.FTCatCode','TCNMPdtCatInfo_L.FTCatName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMPdtCatInfo.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdtCatInfo.FTCatCode"],
                Text		: [tInputReturnName,"TCNMPdtCatInfo_L.FTCatName"],
            },
        }
        return oOptionReturn;
    };


</script>