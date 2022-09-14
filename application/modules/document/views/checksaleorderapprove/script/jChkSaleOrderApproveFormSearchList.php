<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

    var tBchCode = '<?php echo $this->session->userdata('tSesUsrBchCodeDefault');?>';

    // Advance search Display control
    $('#obtCHKAdvanceSearch').unbind().click(function(){
        if($('#odvCPHAdvanceSearchContainer').hasClass('hidden')){
            $('#odvCPHAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
        }else{
            $("#odvCPHAdvanceSearchContainer").slideUp(500,function() {
                $(this).addClass('hidden');
            });
        }
    });

    // Clear Fillter
    $('#obtCHKSearchReset').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCHKClearAdvSearchData();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Search Data
    $('#obtCHKAdvSearchSubmitForm').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvCHKSoCallPageMain();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //ฟังก์ชั่นล้างค่า Input Advance Search
    function JSxCHKClearAdvSearchData(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $('#obtChkMultiBrowseMerchant').attr('disabled',true);
            $('#obtChkMultiBrowseShop').attr('disabled',true);
            $('#ofmCHKFromSerchAdv').find('input').val('');
            $('#ofmCHKFromSerchAdv').find('select').val(0).selectpicker("refresh");
            JSvCHKSoCallPageMain();
        }else{
            JCNxShowMsgSessionExpired();
        }
        
    }

    //ต้องไม่ให้เลือก กลุ่มธุรกิจ กับ ร้านค้า
    $('#obtChkMultiBrowseMerchant').attr('disabled',true);
    $('#obtChkMultiBrowseShop').attr('disabled',true);

    //เลือกสาขา
    var oBrowseBch = {
        Title : ['company/branch/branch','tBCHTitle'],
        Table:{Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join :{
            Table:	['TCNMBranch_L'],
            On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBCHCode','tBCHName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['',''],
            Perpage			: 10,
            OrderBy			: ['TCNMBranch_L.FTBchName ASC'],
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetChkBchCodeSelect","TCNMBranch.FTBchCode"],
            Text		: ["oetChkBchNameSelect","TCNMBranch_L.FTBchName"],
        },
        NextFunc:{
            FuncName    :   'JSxBrowseByStepBCH',
            ArgReturn   :   ['FTBchCode'],
        },
    }
    $('#obtChkMultiBrowseBranch').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            JCNxBrowseData('oBrowseBch');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    //เลือกกลุ่มธุรกิจ
    var tWhereModal     = "";
    if(typeof(tBchCode) != undefined && tBchCode != ""){
        tWhereModal += " AND ((SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '"+tBchCode+"') != 0)";
    }
    var oBrowseMer = {
        Title: ['company/merchant/merchant','tMerchantTitle'],
        Table: {Master:'TCNMMerchant',PK:'FTMerCode'},
        Join: {
            Table: ['TCNMMerchant_L'],
            On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits]
        },
        Where : {
            Condition : [tWhereModal]
        },
        GrideView: {
            ColumnPathLang	    : 'company/merchant/merchant',
            ColumnKeyLang	    : ['tMerCode','tMerName'],
            ColumnsSize         : ['15%','75%'],
            WidthModal          : 50,
            DataColumns		    : ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
            DataColumnsFormat   : ['',''],
            Perpage			    : 10,
            OrderBy			    : ['TCNMMerchant.FTMerCode ASC'],
        },
        CallBack: {
            ReturnType	: 'S',
            Value       : ['oetChkMerCodeSelect','TCNMMerchant.FTMerCode'],
            Text        : ['oetChkMerNameSelect','TCNMMerchant_L.FTMerName']
        },
        NextFunc:{
            FuncName    :   'JSxBrowseByStepMER',
            ArgReturn   :   ['FTMerCode'],
        },
    }
    $('#obtChkMultiBrowseMerchant').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            JCNxBrowseData('oBrowseMer');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //เลือกร้านค้า
    var tWhereSHP = '';
    var oBrowseShp = {
        Title   : ['company/shop/shop','tSHPTitle'],
        Table   : {Master:'TCNMShop', PK:'FTShpCode'},
        Join    : {
            Table   : ['TCNMShop_L', 'TCNMBranch_L'],
            On      : [
                'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
            ]
        },
        Where : {
            Condition : [tWhereSHP]
        },
        GrideView:{
            ColumnPathLang	    : 'company/shop/shop',
            ColumnKeyLang	    : ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
            ColumnsSize         : ['15%','15%','75%'],
            WidthModal          : 50,
            DataColumns		    : ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
            DataColumnsFormat   : ['','',''],
            Perpage			    : 10,
            OrderBy			    : ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
        },
        CallBack: {
            ReturnType	: 'S',
            Value		: ['oetChkShpCodeSelect',"TCNMShop.FTShpCode"],
            Text		: ['oetChkShpNameSelect',"TCNMShop_L.FTShpName"]
        },
        NextFunc:{
            FuncName    :   'JSxBrowseByStepSHP',
            ArgReturn   :   ['FTShpCode'],
        },debugSQL : true
    }
    $('#obtChkMultiBrowseShop').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); 
            JCNxBrowseData('oBrowseShp');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
  
    //เลือกคลังสินค้า
    var tWhereWAH = '';
    var oBrowseWah = {
        Title   :  ['company/warehouse/warehouse','tWAHSubTitle'],
        Table   :  {Master:'TCNMWaHouse',PK:'FTWahCode'},
        Join    : {
                Table   : ['TCNMWaHouse_L'],
                On      : [
                    'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits,
                ]
            },
        Where   : {
            Condition : [' AND TCNMWaHouse.FTWahStaType = 6 ']
        },
        GrideView:{
            ColumnPathLang      : 'company/warehouse/warehouse',
            ColumnKeyLang       : ['tWahCode','tWahName'],
            ColumnsSize         : ['15%','15%'],
            WidthModal          : 50,
            DataColumns         : ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat   : ['',''],
            Perpage			    : 10,
            OrderBy             : ['TCNMWaHouse.FTWahCode ASC'],
        },
        CallBack: {
            ReturnType	: 'S',
            Value       : ['oetChkWahCodeSelect','TCNMWaHouse.FTWahCode'],
            Text        : ['oetChkWahNameSelect','TCNMWaHouse_L.FTWahName'], 
        }
    }
    $('#obtChkMultiBrowseWah').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession ==1){
            JSxCheckPinMenuClose();
            JCNxBrowseData('oBrowseWah');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //เมื่อเลือกสาขา
    function JSxBrowseByStepBCH(ptParam){
        JSxWhenUSelect('BCH');
    }

    //เมื่อเลือกกลุ่มธุรกิจ
    function JSxBrowseByStepMER(ptParam){
        JSxWhenUSelect('MER');
    }

    //เมื่อเลือกกร้านค้า
    function JSxBrowseByStepSHP(ptParam){
        JSxWhenUSelect('SHP');
    }

    //ฟังก์ชั่นรวมไว้เช็คว่าเลือกอะไรไปแล้วบ้าง
    function JSxWhenUSelect(ptType){
        if(ptType == 'BCH'){
            //เปิด
            $('#obtChkMultiBrowseMerchant').attr('disabled',false);
            $('#obtChkMultiBrowseShop').attr('disabled',true);

            //ล้างค่า
            $('#oetChkMerCodeSelect , #oetChkMerNameSelect').val('');
            $('#oetChkShpCodeSelect , #oetChkShpNameSelect').val('');
            $('#oetChkWahCodeSelect , #oetChkWahNameSelect').val('');
        }else if(ptType == 'MER'){
            //เปิด
            $('#obtChkMultiBrowseMerchant').attr('disabled',false);
            $('#obtChkMultiBrowseShop').attr('disabled',false);

            //กำหนดค่าใหม่ให้กับร้านค้า
            var tValueMerCode = $('#oetChkMerCodeSelect').val();
            var tValueBchCode = $('#oetChkBchCodeSelect').val();
            oBrowseShp.Where.Condition = [" AND TCNMShop.FTMerCode = '" + tValueMerCode + "' AND TCNMShop.FTBchCode = '"+tValueBchCode+"' "];

            //ล้างค่า
            $('#oetChkShpCodeSelect , #oetChkShpNameSelect').val('');
            $('#oetChkWahCodeSelect , #oetChkWahNameSelect').val('');
        }else if(ptType == 'SHP'){
            //ล้างค่า
            $('#oetChkWahCodeSelect , #oetChkWahNameSelect').val('');
        }
    }

</script>