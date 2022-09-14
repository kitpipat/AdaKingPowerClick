<script>

    $(document).ready(function(){
        JSxPTUPageStep3DataTable();

        let tUsrLevel        = "<?=$this->session->userdata("tSesUsrLevel");?>";
        let tUsrAgnCode      = "<?=$this->session->userdata("tSesUsrAgnCode");?>";
        let tUsrAgnName      = "<?=$this->session->userdata("tSesUsrAgnName");?>";
        if( tUsrLevel != "HQ" ){
            $('#oetPTUHDBchAgnCode').val(tUsrAgnCode);
            $('#oetPTUHDBchAgnName').val(tUsrAgnName);
            $('#obtPTUHDBchBrowseAgency').attr('disabled',true);
        }
        

    });

    // แสดงรายการ ประเภทบัตร
    // Create By : Napat(Jame) 23/09/2020
    function JSxPTUPageStep3DataTable(){
        $.ajax({
            type: "POST",
            url: "docPTUPageStep3DataTable",
            data: {
                'tDocNo'    : $('#oetPTUDocNo').val(),
                'tBchCode'  : $('#oetPTUBchCode').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvPTUDataTableStep3').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

    // Create By : Napat(Jame) 25/09/2020
    // Last Update : Napat(Jame) 21/12/2020
    function JSxPTUStep3AddEditHDBch(){

        var tAgnCode = $('#oetPTUHDBchAgnCode').val();
        var tBchCode = $('#oetPTUHDBchBchCode').val();
        var tMerCode = $('#oetPTUHDBchMerCode').val();
        var tShpCode = $('#oetPTUHDBchShpCode').val();

        if( tBchCode == "" && tMerCode == "" && tShpCode == "" && tAgnCode == "" ){
            $('#oetPTUHDBchAgnName').closest('.form-group').addClass( "has-error" );
            $('#oetPTUHDBchBchName').closest('.form-group').addClass( "has-error" );
            $('#oetPTUHDBchMerName').closest('.form-group').addClass( "has-error" );
            $('#oetPTUHDBchShpName').closest('.form-group').addClass( "has-error" );
            return false;
        }else{
            $('#oetPTUHDBchAgnName').closest('.form-group').removeClass( "has-error" );
            $('#oetPTUHDBchBchName').closest('.form-group').removeClass( "has-error" );
            $('#oetPTUHDBchMerName').closest('.form-group').removeClass( "has-error" );
            $('#oetPTUHDBchShpName').closest('.form-group').removeClass( "has-error" );
        }

        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docPTUEventStep3AddEditHDBch",
            data: {
                tDocNo      : $('#oetPTUDocNo').val(),
                tBchCode    : $('#oetPTUBchCode').val(),
                tHDAgnCode  : tAgnCode,
                tHDBchCode  : tBchCode,
                tHDMerCode  : tMerCode,
                tHDShpCode  : tShpCode,
                nSeq        : $('#oetPTUHDBchSeqNo').val(),
                tStaType    : $('#ocmPTUAddPmhStaType').val()
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aResult = $.parseJSON(oResult);
                    if( aResult['tCode'] == '1' ){
                        $('#odvPTUAddHDBchModal').modal('hide');
                        JSxPTUPageStep3DataTable();
                    }else{
                        alert(aResult['tDesc']);
                    }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

    // ลบรายการ กำหนดเงื่อนไขเฉพาะ
    // Create By : Napat(Jame) 25/09/2020
    function JSxPTUEventStep3Delete(poObj){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docPTUEventStepDelete",
            data: {
                'tDocNo'    : $('#oetPTUDocNo').val(),
                'tBchCode'  : $('#oetPTUBchCode').val(),
                'nSeq'      : $(poObj).parent().parent().attr('data-seq'),
                'tDocKey'   : 'TFNTCrdPmtHDBch'
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aResult = $.parseJSON(oResult);
                if( aResult['tCode'] == '1' ){
                    JSxPTUPageStep3DataTable();
                }else{
                    alert(aResult['tDesc']);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

    // Create By : Napat(Jame) 25/09/2020
    // Last Update : Napat(Jame) 21/12/2020 เพิ่ม Agency
    function JSxPTUEventStep3Edit(poObj){
        var nSeq     = $(poObj).parent().parent().attr('data-seq');
        var tAgnCode = $(poObj).parent().parent().attr('data-agn-code');
        var tAgnName = $(poObj).parent().parent().attr('data-agn-name');
        var tBchCode = $(poObj).parent().parent().attr('data-bch-code');
        var tBchName = $(poObj).parent().parent().attr('data-bch-name');
        var tMerCode = $(poObj).parent().parent().attr('data-mer-code');
        var tMerName = $(poObj).parent().parent().attr('data-mer-name');
        var tShpCode = $(poObj).parent().parent().attr('data-shp-code');
        var tShpName = $(poObj).parent().parent().attr('data-shp-name');
        var tType    = $(poObj).parent().parent().attr('data-type');

        $('#oetPTUHDBchSeqNo').val(nSeq);
        $('#oetPTUHDBchAgnCode').val(tAgnCode);
        $('#oetPTUHDBchAgnName').val(tAgnName);
        $('#oetPTUHDBchBchCode').val(tBchCode);
        $('#oetPTUHDBchBchName').val(tBchName);
        $('#oetPTUHDBchMerCode').val(tMerCode);
        $('#oetPTUHDBchMerName').val(tMerName);
        $('#oetPTUHDBchShpCode').val(tShpCode);
        $('#oetPTUHDBchShpName').val(tShpName);
        $('#ocmPTUAddPmhStaType').selectpicker('val', tType);

        if( tMerCode == "" ){
            $('#obtPTUHDBchBrowseShop').attr('disabled',true);
        }

        $('#odvPTUAddHDBchModal').modal('show');
    }

    // Create By : Napat(Jame) 25/09/2020
    $('#obtPTUStep3AddHDBch').off('click');
    $('#obtPTUStep3AddHDBch').on('click',function(){
        $('#obtPTUHDBchBrowseShop').attr('disabled',true);
        $('#obtPTUHDBchBrowseMerchant').attr('disabled',true);

        let tSesUsrLevel = '<?=$this->session->userdata("tSesUsrLevel")?>';
        if( tSesUsrLevel == "HQ" ){
            $('#oetPTUHDBchAgnCode').val('');
            $('#oetPTUHDBchAgnName').val('');
        }

        $('#oetPTUHDBchBchCode').val('');
        $('#oetPTUHDBchBchName').val('');
        $('#oetPTUHDBchMerCode').val('');
        $('#oetPTUHDBchMerName').val('');
        $('#oetPTUHDBchShpCode').val('');
        $('#oetPTUHDBchShpName').val('');
        $('#oetPTUHDBchSeqNo').val('0');
        $("#ocmPTUAddPmhStaType").prop("selectedIndex", 0);
        $("#ocmPTUAddPmhStaType").selectpicker("refresh");

        $('#odvPTUAddHDBchModal').modal('show');
    });

    // Create By : Napat(Jame) 21/12/2020
    $('#obtPTUHDBchBrowseAgency').off('click');
    $('#obtPTUHDBchBrowseAgency').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oOptionHDBchBrowsAgency   = undefined;
            oOptionHDBchBrowsAgency          = oPTUHDBchBrowseAgency({
                'tReturnInputCode'  : 'oetPTUHDBchAgnCode',
                'tReturnInputName'  : 'oetPTUHDBchAgnName',
                'tNextFuncName'     : 'JSxPTUBrowseNextFuncAgency',
                'aArgReturn'        : ['FTAgnCode']
            });
            JCNxBrowseData('oOptionHDBchBrowsAgency');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oPTUHDBchBrowseAgency  = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
        let tInputReturnName = poReturnInput.tReturnInputName;
        let tNextFuncName    = poReturnInput.tNextFuncName;
        let aArgReturn       = poReturnInput.aArgReturn;

        let oAgnOptionReturn    = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table:{
                Master:'TCNMAgency',
                PK:'FTAgnCode'},
            Join :{
                Table:	['TCNMAgency_L'],
                On:     ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdit]
            },
            Where:{
                Condition: [" AND TCNMAgency.FTAgnStaActive = '1' "]
            },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMAgency.FTAgnCode','TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnName,"TCNMAgency_L.FTAgnName"]
            },
            NextFunc : {
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            RouteAddNew: 'agency',
            BrowseLev: 2
        }
        return oAgnOptionReturn;
    }

    // Create By : Napat(Jame) 21/12/2020
    function JSxPTUBrowseNextFuncAgency(poObj){
        if( poObj != "NULL" ){
            $('#oetPTUHDBchBchCode').val('');
            $('#oetPTUHDBchBchName').val('');
            // var aResult = $.parseJSON(poObj);
        }
    }

    // Create By : Napat(Jame) 25/09/2020
    $('#obtPTUHDBchBrowseBranch').off('click');
    $('#obtPTUHDBchBrowseBranch').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oOptionHDBchBrowsBranch   = undefined;
            oOptionHDBchBrowsBranch          = oPTUHDBchBrowseBranch({
                'tReturnInputCode'  : 'oetPTUHDBchBchCode',
                'tReturnInputName'  : 'oetPTUHDBchBchName',
                'tNextFuncName'     : 'JSxPTUBrowseNextFuncBranch',
                'aArgReturn'        : ['FTBchCode'],
                'tGetValAgnCode'    : $('#oetPTUHDBchAgnCode').val()
            });
            JCNxBrowseData('oOptionHDBchBrowsBranch');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oPTUHDBchBrowseBranch  = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
        let tInputReturnName = poReturnInput.tReturnInputName;
        let tNextFuncName    = poReturnInput.tNextFuncName;
        let aArgReturn       = poReturnInput.aArgReturn;

        let tGetValAgnCode   = poReturnInput.tGetValAgnCode;
        let tUsrLevel        = "<?=$this->session->userdata("tSesUsrLevel");?>";
        let tUsrBchCodeMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti");?>";
        let tWhereCondition  = "";

        tWhereCondition += " AND TCNMBranch.FTBchStaActive = '1' ";

        if( tUsrLevel != "HQ" ){
            tWhereCondition += " AND TCNMBranch.FTBchCode IN ("+tUsrBchCodeMulti+") ";
        }else{
            if( tGetValAgnCode != "" ){
                tWhereCondition += " AND TCNMBranch.FTAgnCode = '"+tGetValAgnCode+"' ";
            }
        }

        let oBchOptionReturn    = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table:{
                Master:'TCNMBranch',
                PK:'FTBchCode'},
            Join :{
                Table:	['TCNMBranch_L'],
                On:     ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdit]
            },
            Where :{
                Condition: [tWhereCondition]
            },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"]
            },
            NextFunc : {
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            RouteAddNew: 'branch',
            BrowseLev: 2
        }
        return oBchOptionReturn;
    }

    // Create By : Napat(Jame) 30/09/2020
    function JSxPTUBrowseNextFuncBranch(poObj){
        if( poObj != "NULL" ){
            var aResult = $.parseJSON(poObj);
            $('#obtPTUHDBchBrowseMerchant').attr('disabled',false);
        }else{
            $('#obtPTUHDBchBrowseMerchant').attr('disabled',true);
        }
        
        $('#oetPTUHDBchMerCode').val('');
        $('#oetPTUHDBchMerName').val('');
        $('#oetPTUHDBchShpCode').val('');
        $('#oetPTUHDBchShpName').val('');
        $('#obtPTUHDBchBrowseShop').attr('disabled',true);
    }
    
    // Create By : Napat(Jame) 25/09/2020
    $('#obtPTUHDBchBrowseMerchant').off('click');
    $('#obtPTUHDBchBrowseMerchant').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oOptionHDBchBrowsMerchant   = undefined;
            oOptionHDBchBrowsMerchant          = oPTUHDBchBrowseMerchant({
                'tReturnInputCode'  : 'oetPTUHDBchMerCode',
                'tReturnInputName'  : 'oetPTUHDBchMerName',
                'tNextFuncName'     : 'JSxPTUBrowseNextFuncMerchant',
                'aArgReturn'        : ['FTMerCode','FTMerName']
            });
            JCNxBrowseData('oOptionHDBchBrowsMerchant');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oPTUHDBchBrowseMerchant  = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
        let tInputReturnName = poReturnInput.tReturnInputName;
        let tNextFuncName    = poReturnInput.tNextFuncName;
        let aArgReturn       = poReturnInput.aArgReturn;

        let oBchOptionReturn    = {
            Title: ['merchant/merchant/merchant','tMerchantTitle'],
            Table:{
                Master:'TCNMMerchant',
                PK:'FTMerCode'},
            Join :{
                Table:	['TCNMMerchant_L'],
                On:     ['TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdit]
            },
            GrideView:{
                ColumnPathLang	: 'merchant/merchant/merchant',
                ColumnKeyLang	: ['tMCNTBCode','tMCNTBName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMMerchant.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMMerchant.FTMerCode"],
                Text		: [tInputReturnName,"TCNMMerchant_L.FTMerName"]
            },
            NextFunc : {
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            RouteAddNew: 'merchant',
            BrowseLev: 2
        }
        return oBchOptionReturn;
    }

    // Create By : Napat(Jame) 29/09/2020
    function JSxPTUBrowseNextFuncMerchant(poObj){
        if( poObj != "NULL" ){
            var aResult = $.parseJSON(poObj);
            $('#obtPTUHDBchBrowseShop').attr('disabled',false);
            // console.log(aResult);
        }else{
            $('#oetPTUHDBchShpCode').val('');
            $('#oetPTUHDBchShpName').val('');
            $('#obtPTUHDBchBrowseShop').attr('disabled',true);
        }
    }

    // Create By : Napat(Jame) 25/09/2020
    $('#obtPTUHDBchBrowseShop').off('click');
    $('#obtPTUHDBchBrowseShop').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oOptionHDBchBrowsShop   = undefined;
            oOptionHDBchBrowsShop          = oPTUHDBchBrowseShop({
                'tReturnInputCode'  : 'oetPTUHDBchShpCode',
                'tReturnInputName'  : 'oetPTUHDBchShpName',
                'tBchCode'          : $('#oetPTUHDBchBchCode').val(),
                'tMerCode'          : $('#oetPTUHDBchMerCode').val()
                // 'tNextFuncName'     : '',
                // 'aArgReturn'        : ['']
            });
            JCNxBrowseData('oOptionHDBchBrowsShop');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oPTUHDBchBrowseShop  = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
        let tInputReturnName = poReturnInput.tReturnInputName;
        let tBchCode         = poReturnInput.tBchCode;
        let tMerCode         = poReturnInput.tMerCode;
        // let tNextFuncName    = poReturnInput.tNextFuncName;
        // let aArgReturn       = poReturnInput.aArgReturn;

        let tWhere = "";
        if(tBchCode != ""){
            tWhere += " AND TCNMShop.FTBchCode = '" + tBchCode + "' ";
        }
        if(tMerCode != ""){
            tWhere += " AND TCNMShop.FTMerCode = '" + tMerCode + "' ";
        }

        let oBchOptionReturn    = {
            Title: ['company/shop/shop','tSHPTitle'],
            Table:{
                Master:'TCNMShop',
                PK:'FTShpCode'},
            Join :{
                Table:	['TCNMShop_L'],
                On:     ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdit]
            },
            Where :{
                Condition: [ tWhere ]
            },
            GrideView:{
                ColumnPathLang	: 'company/shop/shop',
                ColumnKeyLang	: ['tShopCode','tShopName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMShop.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMShop.FTShpCode"],
                Text		: [tInputReturnName,"TCNMShop_L.FTShpName"]
            },
            // NextFunc : {
            //     FuncName    : tNextFuncName,
            //     ArgReturn   : aArgReturn
            // },
            RouteAddNew: 'merchant',
            BrowseLev: 2
        }
        return oBchOptionReturn;
    }

    // Create By : Napat(Jame) 22/12/2020
    function JCNbPTUStep3IsValid() {
        var bStatus         = false;
        var nStep3NumRow    = $('#oetPTUStep3NumRow').val();
        var tStaType        = $('#ocbPTURefExAutoGen').prop("checked");
        var tSesUsrLevel    = '<?=$this->session->userdata("tSesUsrLevel")?>';

        // ถ้าเป็น HQ ข้าม Step 3 ได้
        if( tSesUsrLevel != "HQ" ){
            if(nStep3NumRow > 0){
                bStatus = true;
            }
        }else{
            bStatus = true;
        }
        
        return bStatus;
    }
    

</script>