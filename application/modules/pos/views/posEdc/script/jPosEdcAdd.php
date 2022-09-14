<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit")?>';
    $(document).ready(function(){

        var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';

        if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
            $('#obtEDCUsrBrowseAgency').attr("disabled", true);
            // $('#oimBrowseBranch').attr("disabled", true);
        }else{
            $('#obtEDCUsrBrowseAgency').attr("disabled", false);
        }

        $('.selectpicker').selectpicker('refresh');

        if(JSbPosEdcIsCreatePage()){
            $("#oetPosEdcCode").attr("readonly", true);
            $('#ocbPosEdcAutoGenCode').unbind().click(function(){
                if($('#ocbPosEdcAutoGenCode').is(':checked')) {
                    $('#oetPosEdcCode').val('');
                    $("#oetPosEdcCode").attr("readonly", true);

                    $('#odvPosEdcCode').removeClass('has-error');
                    $('#odvPosEdcCode em').remove();
                }else{
                    $("#oetPosEdcCode").attr("readonly", false);
                }
            });
            JSxPosEdcVisibleComponent('#odvPosEdcAutoGenCode',true);
        }

        if(JSbPosEdcIsUpdatePage()){
            $("#oetPosEdcCode").attr("readonly", true);
            $('#odvPosEdcAutoGenCode input').attr('disabled', true);
            JSxPosEdcVisibleComponent('#odvPosEdcAutoGenCode', false);    
        }
        
    });

    var oSysEdcOption   = function(poDataFnc){
        let tInputReturnCode    = poDataFnc.tReturnInputCode;
        let tInputReturnName    = poDataFnc.tReturnInputName;
        let oOptionReturn       = {
            Title   : ['pos/posEdc/posEdc','tPosSysEdcTitle'],
            Table   : {Master:'TSysEdc',PK:'FTSedCode'},
            GrideView : {
                ColumnPathLang	: 'pos/posEdc/posEdc',
                ColumnKeyLang	: ['tPosSysEdcCode','tPosSysEdcName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TSysEdc.FTSedCode','TSysEdc.FTSedModel'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TSysEdc.FDCreateOn DESC'],
            },
            CallBack : {
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TSysEdc.FTSedCode"],
                Text		: [tInputReturnName,"TSysEdc.FTSedModel"],
            },
            BrowseLev: 1,
            // DebugSQL : true,
        };
        return oOptionReturn;
    }

    $('#oimPosEdcSysModelBrowse').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oSysEdcBrowseOption  = undefined;
            oSysEdcBrowseOption = oSysEdcOption({
                'tReturnInputCode'  : 'oetPosEdcSedCode',
                'tReturnInputName'  : 'oetPosEdcSedName',
            });
            JCNxBrowseData('oSysEdcBrowseOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oBankOption   = function(poDataFnc){
        let tInputReturnCode    = poDataFnc.tReturnInputCode;
        let tInputReturnName    = poDataFnc.tReturnInputName;
        var tSesUsrLevel  = '<?=$this->session->userdata("tSesUsrLevel")?>';
        var tAgnCode      = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
        var tWhereSQL ='';
        if( tSesUsrLevel != "HQ" && tAgnCode != "" ){
            tWhereSQL = " AND TFNMBank.FTAgnCode = '"+tAgnCode+"' OR (TFNMBank.FTAgnCode = '' OR TFNMBank.FTAgnCode IS NULL)";
        }

        let oOptionReturn       = {
            Title : ['bank/bank/bank','tBNKTitle'],
            Table:{Master:'TFNMBank',PK:'FTBnkCode'},
            Join :{
                Table:	['TFNMBank_L'],
                On:['TFNMBank_L.FTBnkCode = TFNMBank.FTBnkCode AND TFNMBank_L.FNLngID = '+nLangEdits]
            },
            Where:{
                Condition: [tWhereSQL]
            },
            GrideView:{
                ColumnPathLang	: 'bank/bank/bank',
                ColumnKeyLang	: ['tBNKCode','tBNKName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns		: ['TFNMBank.FTBnkCode','TFNMBank_L.FTBnkName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TFNMBank.FDCreateOn DESC'],
                // SourceOrder		: "ASC"
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TFNMBank.FTBnkCode"],
                Text		: [tInputReturnName,"TFNMBank_L.FTBnkName"],
            },
            RouteAddNew : 'bank',
            BrowseLev : nStaPosEdcBrowseType
        };
        return oOptionReturn;
    }
    
    $('#oimPosEdcBankBrowse').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Create By Witsarut 04/10/2019
             JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oPosEdcBankBrowseOption  = undefined;
            oPosEdcBankBrowseOption = oBankOption({
                'tReturnInputCode'  : 'oetPosEdcBnkCode',
                'tReturnInputName'  : 'oetPosEdcBnkName',
            });
            JCNxBrowseData('oPosEdcBankBrowseOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Functionality: Function Check Is Create Page
    // Parameters: Event Documet Redy
    // Creator: 02/09/2019 Wasin(Yoshi)
    // Return: object Status Delete
    // ReturnType: boolean
    function JSbPosEdcIsCreatePage(){
        try{
            const tPosEdcCode = $('#oetPosEdcCode').data('is-created');    
            var bStatus = false;
            if(tPosEdcCode == ""){ // No have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JSbEdcIsCreatePage Error: ', err);
        }
    }

    // Functionality: Function Check Is Update Page
    // Parameters: Event Documet Redy
    // Creator: 02/09/2019 Wasin(Yoshi)
    // Return: object Status Delete
    // ReturnType: boolean
    function JSbPosEdcIsUpdatePage(){
        try{
            const tPosEdcCode = $('#oetPosEdcCode').data('is-created');
            var bStatus = false;
            if(!tPosEdcCode == ""){ // Have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JSbEdcIsUpdatePage Error: ', err);
        }
    }

    // Functionality : Show or Hide Component
    // Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
    // Creator: 02/09/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxPosEdcVisibleComponent(ptComponent, pbVisible, ptEffect){
        try{
            if(pbVisible == false){
                $(ptComponent).addClass('hidden');
            }
            if(pbVisible == true){
                $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                    $(this).removeClass('hidden fadeIn animated');
                });
            }
        }catch(err){
            console.log('JSxEdcVisibleComponent Error: ', err);
        }
    }


    $('#obtEDCUsrBrowseAgency').on('click',function(){
        var nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oUsrAgnOption       = undefined;
            oUsrAgnOption              = oUsrBrowseAgency({
                'tReturnInputCode'          : 'oetEDCUsrAgnCode',
                'tReturnInputName'          : 'oetEDCUsrAgnName',
                'aArgReturn'                : ['FTAgnCode','FTAgnName']
            });
            JCNxBrowseData('oUsrAgnOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Browse AD
    // Option Browse Merchant
    var oUsrBrowseAgency = function(poReturnInputAgency){
        
        let tInputReturnAgnCode   = poReturnInputAgency.tReturnInputCode;
        let tInputReturnAgnName   = poReturnInputAgency.tReturnInputName;
        let tAgencyNextFunc       = poReturnInputAgency.tNextFuncName;
        let aAgencyArgReturn      = poReturnInputAgency.aArgReturn;

        // let tJoinBranch = " LEFT JOIN ( SELECT FTMerCode FROM TCNMBranch GROUP BY FTMerCode ) B ON TCNMMerchant.FTMerCode = B.FTMerCode ";
        // let tJoinShop   = " LEFT JOIN ( SELECT FTMerCode FROM TCNMShop GROUP BY FTMerCode ) S ON TCNMMerchant.FTMerCode = S.FTMerCode ";

        let oAgencyOptionReturn = {
            Title : ['authen/user/user','tBrowseAgnTitle'],
            Table :{Master:'TCNMAgency',PK:'FTAgnCode'},
            Join :{
                Table:	['TCNMAgency_L'],
                On:[' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits] //+ tJoinBranch + tJoinShop
            },
            // Where :{
            //     Condition : [" AND ( ISNULL(B.FTMerCode,'') != '' OR ISNULL(S.FTMerCode,'') != '') "]
            // },
            GrideView:{
                ColumnPathLang	: 'authen/user/user',
                ColumnKeyLang	: ['tBrowseAgnCode','tBrowseAgnName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns	    : ['TCNMAgency.FTAgnCode','TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnAgnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnAgnName,"TCNMAgency_L.FTAgnName"]
            },
            //DebugSQL: true,
        };
        return oAgencyOptionReturn;
    }

</script>