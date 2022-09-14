<script type="text/javascript">
    var tBaseURL        = '<?php echo base_url(); ?>';
    var nLangEdits      = '<?php echo $this->session->userdata("tLangEdit")?>';
    var nStaAddOrEdit   = '<?php echo $nStaAddOrEdit;?>';
    
    $(document).ready(function(){
        if(nStaAddOrEdit != "" && nStaAddOrEdit == 1){
            var nCountDataImgItem   =   $('#odvImageTumblr #otbImageListProduct tbody tr td.xWTDImgDataItem').length;
            if(nCountDataImgItem > 0){
                $('#odvImageTumblr #otbImageListProduct tbody tr td.xWTDImgDataItem').each(function(){
                    var tDataTumblr =   $(this).find('.xCNImgTumblr').data('tumblr');
                    if(tDataTumblr == 0){
                        var tImgSrcFirstRow =   $('#oimTumblrProduct'+tDataTumblr).attr('src');
                        $('#oimImgMasterProduct').attr('src',tImgSrcFirstRow);
                    }
                });
            }
        }

        if(JSbProductIsCreatePage()){
            $("#oetPdtCode").attr("disabled", true);
            $('#ocbProductAutoGenCode').change(function(){
                if($('#ocbProductAutoGenCode').is(':checked')) {
                    $('#oetPdtCode').val('');
                    $("#oetPdtCode").attr("disabled", true);
                    $('#odvProductCodeForm').removeClass('has-error');
                    $('#odvProductCodeForm em').remove();
                }else{
                    $("#oetPdtCode").attr("disabled", false);
                }
            });
            JSxProductVisibleComponent('#odvReasonAutoGenCode', true);
        }

        if(JSbProductIsUpdatePage()){
            $("#oetPdtCode").attr("readonly", true);
            $('#odvProductAutoGenCode input').attr('disabled', true);
            JSxProductVisibleComponent('#odvProductAutoGenCode', false);    
        }

        $('#oetPdtCode').blur(function(){
            JSxCheckProductCodeDupInDB();
        });
        
    });


    $('.xWPdtSelectBox').selectpicker();
    
    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        startDate: new Date(),
    });

    $('#obtPdtSaleStart').click(function(){$('#oetPdtSaleStart').datepicker('show')});

    $('#obtPdtSaleStop').click(function(){$('#oetPdtSaleStop').datepicker('show')});

    $('#obtSubmitProduct').click(function(){
        JSoAddEditProduct('<?php echo $tRoute?>')
    });

    $('#obtPdtGenCode').click(function(){JSoGenerateProductCode()});

    $('#olbDelAllPdtEvnNotSale').click(function(){
        JSxDelAllPdtEvnNotSale()
    });

    // Browse Modal Image Multiole
    $('#odvPdtAddImageBtn,#oimImgMasterProduct').click(function(){
        JSvImageCallTempNEW('1','2','Product')
    });

    //Functionality: Event Check Product Duplicate
    //Parameters: Event Blur Input Product Code
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckProductCodeDupInDB(){
        if(!$('#ocbProductAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMPdt",
                    tFieldName: "FTPdtCode",
                    tCode: $("#oetPdtCode").val()
                },
                async: false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicatePdtCode").val(aResult["rtCode"]);
                    JSxProductSetValidEventBlur();
                    $('#ofmAddEditProduct').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    //Functionality: Set Validate Event Blur
    //Parameters: Validate Event Blur
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxProductSetValidEventBlur(){
        $('#ofmAddEditProduct').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicatePdtCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddEditProduct').validate({
            rules: {
                oetPdtCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbProductAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                oetPdtName:     {"required" :{}},
            },
            messages: {
                oetPdtCode : {
                    "required"      : $('#oetPdtCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetPdtCode').attr('data-validate-dublicateCode')
                },
                oetPdtName : {
                    "required"      : $('#oetPdtName').attr('data-validate-required'),
                },
            },
            errorElement: "em",
            errorPlacement: function (error, element ) {
                error.addClass( "help-block" );
                if ( element.prop( "type" ) === "checkbox" ) {
                    error.appendTo( element.parent( "label" ) );
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if(tCheck == 0){
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid  = $(element).parents('.form-group').find('.help-block').length
                if(nStaCheckValid != 0){
                    $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                }
            },
            submitHandler: function(form){}
        });
    }

/** =================================================== Option Browse Info Product ================================================== */
    
    // Option Browse Product Branch
    var oPdtBrowseBranch        =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table:{Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table:	['TCNMBranch_L'],
                On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+ nLangEdits,]
            },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['15%','75%'],
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 20,
                OrderBy			: ['TCNMBranch_L.FTBchName'],
                SourceOrder		: "ASC"
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
            },
            RouteAddNew : 'branch',
            BrowseLev : nStaPdtBrowseType
        }
        return oOptionReturn;
    }

    // Option Browse Merchant
    var oPdtBrowseMerchant      = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title : ['company/merchant/merchant','tMERTitle'],
            Table : {Master:'TCNMMerchant',PK:'FTMerCode'},
            Join :{
                Table:	['TCNMMerchant_L'],
                On:['TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode AND TCNMMerchant_L.FNLngID = '+ nLangEdits,]
            },
            Where:{
                Condition: [
                    "AND TCNMMerchant.FTMerStaActive = '1'",
                ]
            },
            GrideView:{
                ColumnPathLang	    : 'company/merchant/merchant',
                ColumnKeyLang	    : ['tMERCode','tMERName'],
                ColumnsSize         : ['15%','75%'],
                DataColumns		    : ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
                DataColumnsFormat   : ['',''],
                WidthModal          : 50,
                Perpage			    : 20,
                OrderBy			    : ['TCNMMerchant.FTMerCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMMerchant.FTMerCode"],
                Text		: [tInputReturnName,"TCNMMerchant_L.FTMerName"],
            },
            RouteAddNew : 'merchant',
            BrowseLev   : nStaPdtBrowseType
        };
        return oOptionReturn;
    }

    // Option Browse Product Group
    var oPdtBrowsePdtGrp        =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title : ['product/pdtgroup/pdtgroup','tPGPTitle'],
            Table:{Master:'TCNMPdtGrp',PK:'FTPgpChain'},
            Join :{
                Table:['TCNMPdtGrp_L'],
                On:['TCNMPdtGrp.FTPgpChain = TCNMPdtGrp_L.FTPgpChain AND TCNMPdtGrp_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang : 'product/pdtgroup/pdtgroup',
                ColumnKeyLang : ['tPGPCode','tPGPChainCode','tPGPName','tPGPChain'],
                ColumnsSize     : ['10%','15%','40%','35%'],
                DataColumns:['TCNMPdtGrp.FTPgpCode','TCNMPdtGrp.FTPgpChain','TCNMPdtGrp_L.FTPgpName','TCNMPdtGrp_L.FTPgpChainName'],
                DataColumnsFormat : ['','','',''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMPdtGrp.FTPgpCode'],
                SourceOrder: "ASC" 
            },
            CallBack:{
                ReturnType: 'S',
                Value:[tInputReturnCode,"TCNMPdtGrp.FTPgpChain"],
                Text: [tInputReturnName,"TCNMPdtGrp_L.FTPgpChainName"],
            },
            RouteAddNew : 'productGroup',
            BrowseLev : nStaPdtBrowseType
        }
        return oOptionReturn;
    }

    // Option Browse Product Type
    var oPdtBrowsePdtType       =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title: ['product/pdttype/pdttype','tPTYTitle'],
            Table: {Master:'TCNMPdtType',PK:'FTPtyCode'},
            Join: {
                Table: ['TCNMPdtType_L'],
                On: ['TCNMPdtType_L.FTPtyCode = TCNMPdtType.FTPtyCode AND TCNMPdtType_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang: 'product/pdttype/pdttype',
                ColumnKeyLang: ['tPTYCode','tPTYName'],
                ColumnsSize: ['10%','90%'],
                DataColumns: ['TCNMPdtType.FTPtyCode','TCNMPdtType_L.FTPtyName'],
                DataColumnsFormat: ['',''],
                WidthModal: 50,
                Perpage: 5,
                OrderBy: ['TCNMPdtType.FTPtyCode'],
                SourceOrder: "DESC" 
            },
            CallBack:{
                ReturnType: 'S',
                Value:[tInputReturnCode,"TCNMPdtType.FTPtyCode"],
                Text: [tInputReturnName,"TCNMPdtType_L.FTPtyName"],
            },
            RouteAddNew: 'productType',
            BrowseLev: nStaPdtBrowseType
        }
        return oOptionReturn;
    }

    // Option Browse Product Brand
    var oPdtBrowsePdtBrand      =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title: ['product/pdtbrand/pdtbrand','tPBNTitle'],
            Table: {Master:'TCNMPdtBrand',PK:'FTPbnCode'},
            Join :{
                Table:['TCNMPdtBrand_L'],
                On:['TCNMPdtBrand_L.FTPbnCode = TCNMPdtBrand.FTPbnCode AND TCNMPdtBrand_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang: 'product/pdtbrand/pdtbrand',
                ColumnKeyLang: ['tPBNCode','tPBNName'],
                ColumnsSize: ['10%','90%'],
                DataColumns: ['TCNMPdtBrand.FTPbnCode','TCNMPdtBrand_L.FTPbnName'],
                DataColumnsFormat: ['',''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMPdtBrand.FTPbnCode'],
                SourceOrder: "DESC" 
            },
            CallBack:{
                ReturnType: 'S',
                Value:[tInputReturnCode,"TCNMPdtBrand.FTPbnCode"],
                Text: [tInputReturnName,"TCNMPdtBrand_L.FTPbnName"],
            },
            RouteAddNew : 'productBrand',
            BrowseLev : nStaPdtBrowseType
        }
        return oOptionReturn;
    }

    // Option Browse Product Model
    var oPdtBrowsePdtModel      =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title: ['product/pdtmodel/pdtmodel','tPMOTitle'],
            Table: {Master:'TCNMPdtModel',PK:'FTPmoCode'},
            Join: {
                Table:['TCNMPdtModel_L'],
                On:['TCNMPdtModel_L.FTPmoCode = TCNMPdtModel.FTPmoCode AND TCNMPdtModel_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang: 'product/pdtmodel/pdtmodel',
                ColumnKeyLang: ['tPMOCode','tPMOName'],
                ColumnsSize: ['10%','90%'],
                DataColumns: ['TCNMPdtModel.FTPmoCode','TCNMPdtModel_L.FTPmoName'],
                DataColumnsFormat: ['',''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMPdtModel.FTPmoCode'],
                SourceOrder: "DESC" 
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode,"TCNMPdtModel.FTPmoCode"],
                Text: [tInputReturnName,"TCNMPdtModel_L.FTPmoName"],
            },
            RouteAddNew: 'productModel',
            BrowseLev: nStaPdtBrowseType
        }
        return oOptionReturn;
    }

    // Option Browse Product Touch Group
    var oPdtBrowsePdtTouchGrp   =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title: ['product/pdttouchgroup/pdttouchgroup','tTCGTitle'],
            Table: {Master:'TCNMPdtTouchGrp',PK:'FTTcgCode'},
            Join: {
                Table: ['TCNMPdtTouchGrp_L'],
                On: ['TCNMPdtTouchGrp_L.FTTcgCode = TCNMPdtTouchGrp.FTTcgCode AND TCNMPdtTouchGrp_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang: 'product/pdttouchgroup/pdttouchgroup',
                ColumnKeyLang: ['tTCGCode','tTCGName'],
                ColumnsSize: ['10%','90%'],
                DataColumns: ['TCNMPdtTouchGrp.FTTcgCode','TCNMPdtTouchGrp_L.FTTcgName'],
                DataColumnsFormat: ['',''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMPdtTouchGrp.FTTcgCode'],
                SourceOrder:"DESC" 
            },
            CallBack:{
                ReturnType: 'S',
                Value:[tInputReturnCode,"TCNMPdtTouchGrp.FTTcgCode"],
                Text: [tInputReturnName,"TCNMPdtTouchGrp_L.FTTcgName"],
            },
            RouteAddNew : 'productTouchGrp',
            BrowseLev : nStaPdtBrowseType
        }
        return oOptionReturn;
    }

    // Option Add Browse Product Unit 
    var oPdtBrowseUnit          =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName       = poReturnInput.tNextFuncName;
        var oOptionReturn       = {
            Title: ['product/pdtunit/pdtunit','tPUNTitle'],
            Table: {Master:'TCNMPdtUnit',PK:'FTPunCode',PKName:'FTPunName'},
            Join :{
                Table:['TCNMPdtUnit_L'],
                On:['TCNMPdtUnit_L.FTPunCode = TCNMPdtUnit.FTPunCode AND TCNMPdtUnit_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang : 'product/pdtunit/pdtunit',
                ColumnKeyLang : ['tPUNCode','tPUNName'],
                ColumnsSize     : ['10%','90%'],
                DataColumns:['TCNMPdtUnit.FTPunCode','TCNMPdtUnit_L.FTPunName'],
                DataColumnsFormat : ['',''],
                WidthModal: 50,
                Perpage:20,
                OrderBy:['TCNMPdtUnit.FTPunCode'],
                SourceOrder:"ASC" 
            },
            CallBack:{
                ReturnType: 'M',
                StaDoc  : '1',
                Value:[tInputReturnCode,"TCNMPdtUnit.FTPunCode"],
                Text: [tInputReturnName,"TCNMPdtUnit_L.FTPunName"],
            },
            NextFunc:{
                FuncName: tNextFuncName,
                ArgReturn: ['FTPunCode','FTPunName']
            },
            RouteAddNew: 'pdtunit',
            BrowseLev: nStaPdtBrowseType,
        }
        return oOptionReturn
    }

    // Option Add Browse Product Set
    var oPdtBrowsePdtSet        =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName       = poReturnInput.tNextFuncName;
        var oOptionReturn       = {
            Title: ['product/product/product','tPDTTitle'],
            Table: {Master:'TCNMPdt',PK:'FTPdtCode',PKName:'FTPdtName'},
            Join: {
                Table: ['TCNMPdt_L'],
                On: ['TCNMPdt_L.FTPdtCode = TCNMPdt.FTPdtCode AND TCNMPdt_L.FNLngID = '+nLangEdits]
            },
            Where:{
                Condition: [
                    "AND TCNMPdt.FTPdtForSystem = '1'",
                    "AND TCNMPdt.FTPdtSetOrSN   = '1'",
                ]
            },
            NotIn:{
                Selector: 'oetPdtCode',
                Table: 'TCNMPdt',
                Key: 'FTPdtCode'
            },
            GrideView:{
                ColumnPathLang: 'product/product/product',
                ColumnKeyLang: ['tPDTCode','tPDTName','tPDTNameOth','tPDTNameABB'],
                ColumnsSize: ['10%','30%','30%','30%'],
                DataColumns: ['TCNMPdt.FTPdtCode','TCNMPdt_L.FTPdtName','TCNMPdt_L.FTPdtNameOth','TCNMPdt_L.FTPdtNameABB'],
                DataColumnsFormat: ['','','',''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMPdt.FTPdtCode'],
                SourceOrder:"ASC" 
            },
            CallBack:{
                ReturnType: 'M',
                Value: [tInputReturnCode,"TCNMPdt.FTPdtCode"],
                Text: [tInputReturnName,"TCNMPdt_L.FTPdtName"],
            },
            NextFunc:{
                FuncName: tNextFuncName,
                ArgReturn: ['FTPdtCode','FTPdtName']
            },
            RouteAddNew: 'product',
            BrowseLev: 1
        }
        return oOptionReturn;
    }

    // Option Add Browse Product Event Not Sale
    var oPdtBrowsePdtEvnNoSale  =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName       = poReturnInput.tNextFuncName;
        var oOptionReturn       = {
            Title: ['product/pdtnoslebyevn/pdtnoslebyevn','tEVNTitle'],
            Table: {Master:'TCNMPdtNoSleByEvn_L',PK:'FTEvnCode',PKName:'FTEvnName'},
            Where:{
                Condition: ["AND TCNMPdtNoSleByEvn_L.FNLngID = "+nLangEdits]
            },
            GrideView:{
                ColumnPathLang: 'product/pdtnoslebyevn/pdtnoslebyevn',
                ColumnKeyLang: ['tEVNTBCode','tEVNTBName'],
                ColumnsSize: ['20%','80%'],
                DataColumns: ['TCNMPdtNoSleByEvn_L.FTEvnCode','TCNMPdtNoSleByEvn_L.FTEvnName'],
                DataColumnsFormat: ['',''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy:['TCNMPdtNoSleByEvn_L.FTEvnCode'],
                SourceOrder:"DESC" 
            },
            CallBack:{
                ReturnType: 'S',
                Value:[tInputReturnCode,"TCNMPdtNoSleByEvn_L.FTEvnCode"],
                Text: [tInputReturnName,"TCNMPdtNoSleByEvn_L.FTEvnName"],
            },
            NextFunc:{
                FuncName: tNextFuncName,
                ArgReturn: ['FTEvnCode','FTEvnName']
            },
            RouteAddNew: 'productNoSaleEvent',
            BrowseLev: nStaPdtBrowseType
        }
        return oOptionReturn;
    }
    


/** ================================================================================================================================= */

/** =================================================== Event Browse Info Product =================================================== */
    // Click Browse Branch
    $('#obtBrowseBranch').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oPdtBrowseBranchOption = oPdtBrowseBranch({
                'tReturnInputCode'  : 'oetPdtBchCode',
                'tReturnInputName'  : 'oetPdtBchName'
            });
            JCNxBrowseData('oPdtBrowseBranchOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // Click Browse Merchant
    $('#obtBrowseMerchant').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oPdtBrowseMerchantOption = oPdtBrowseMerchant({
                'tReturnInputCode'  : 'oetPdtMerCode',
                'tReturnInputName'  : 'oetPdtMerName',
            });
            JCNxBrowseData('oPdtBrowseMerchantOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // Click Browse Product Group
    $('#obtBrowsePdtGrp').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oPdtBrowsePdtGrpOption = oPdtBrowsePdtGrp({
                'tReturnInputCode'  : 'oetPdtPgpChain',
                'tReturnInputName'  : 'oetPdtPgpChainName',
            });
            JCNxBrowseData('oPdtBrowsePdtGrpOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // Click Browse Product Type
    $('#obtBrowsePdtType').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oPdtBrowsePdtTypeOption = oPdtBrowsePdtType({
                'tReturnInputCode'  : 'oetPdtPtyCode',
                'tReturnInputName'  : 'oetPdtPtyName',
            });
            JCNxBrowseData('oPdtBrowsePdtTypeOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // Click Browse Product Brand
    $('#obtBrowsePdtBrand').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oPdtBrowsePdtBrandOption = oPdtBrowsePdtBrand({
                'tReturnInputCode'  : 'oetPdtPbnCode',
                'tReturnInputName'  : 'oetPdtPbnName',
            });
            JCNxBrowseData('oPdtBrowsePdtBrandOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // Click Browse Product Model
    $('#obtBrowsePdtModel').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oPdtBrowsePdtModelOption = oPdtBrowsePdtModel({
                'tReturnInputCode'  : 'oetPdtPmoCode',
                'tReturnInputName'  : 'oetPdtPmoName',
            });
            JCNxBrowseData('oPdtBrowsePdtModelOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // Click Browse Product Touch Group
    $('#obtBrowsePdtTouchGrp').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oPdtBrowsePdtTouchGrpOption = oPdtBrowsePdtTouchGrp({
                'tReturnInputCode'  : 'oetPdtTcgCode',
                'tReturnInputName'  : 'oetPdtTcgName',
            });
            JCNxBrowseData('oPdtBrowsePdtTouchGrpOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //Click Browse Poduct Unit
    $('#olbAddProductUnit').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oPdtBrowseUnitOption   =   oPdtBrowseUnit({
                'tReturnInputCode'  : 'ohdPdtUnitCode',
                'tReturnInputName'  : 'ohdPdtUnitName',
                'tNextFuncName'     : 'JSxAddDataUnitPackSizeToTable'
            });
            JCNxBrowseData('oPdtBrowseUnitOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

/** ================================================================================================================================= */

/** =================================================== Function And Event Pack Size ================================================ */
    
    var oPdtBrowseColor     = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName       = poReturnInput.tNextFuncName;
        var oOptionReturn       = {
            Title: ['product/pdtcolor/pdtcolor','tCLRTitle'],
            Table: {Master:'TCNMPdtColor',PK:'FTClrCode'},
            Join :{
                Table:['TCNMPdtColor_L'],
                On:['TCNMPdtColor_L.FTClrCode = TCNMPdtColor.FTClrCode AND TCNMPdtColor_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang : 'product/pdtcolor/pdtcolor',
                ColumnKeyLang : ['tCLRCode','tCLRName'],
                ColumnsSize     : ['10%','90%'],
                DataColumns:['TCNMPdtColor.FTClrCode','TCNMPdtColor_L.FTClrName'],
                DataColumnsFormat : ['',''],
                WidthModal: 50,
                Perpage:5,
                OrderBy:['TCNMPdtColor.FTClrCode'],
                SourceOrder:"DESC" 
            },
            CallBack:{
                ReturnType: 'S',
                Value:[tInputReturnCode,"TCNMPdtColor.FTClrCode"],
                Text: [tInputReturnName,"TCNMPdtColor_L.FTClrName"],
            },
            NextFunc:{
                FuncName: tNextFuncName,
            },
            RouteAddNew : 'productColor',
            BrowseLev : nStaPdtBrowseType
        }
        return oOptionReturn;
    }

    var oPdtBrowseSize      = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName       = poReturnInput.tNextFuncName;
        var oOptionReturn       = {
            Title: ['product/pdtsize/pdtsize','tPSZTitle'],
            Table: {Master:'TCNMPdtSize',PK:'FTPszCode'},
            Join :{
                Table: ['TCNMPdtSize_L'],
                On: ['TCNMPdtSize_L.FTPszCode = TCNMPdtSize.FTPszCode AND TCNMPdtSize_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang: 'product/pdtsize/pdtsize',
                ColumnKeyLang: ['tPSZCode','tPSZName'],
                ColumnsSize: ['10%','90%'],
                DataColumns: ['TCNMPdtSize.FTPszCode','TCNMPdtSize_L.FTPszName'],
                DataColumnsFormat: ['',''],
                WidthModal: 50,
                Perpage: 20,
                OrderBy: ['TCNMPdtSize.FTPszCode'],
                SourceOrder: "DESC" 
            },
            CallBack:{
                ReturnType: 'S',
                Value: [tInputReturnCode,"TCNMPdtSize.FTPszCode"],
                Text: [tInputReturnName,"TCNMPdtSize_L.FTPszName"],
            },
            NextFunc:{
                FuncName: tNextFuncName,
            },
            RouteAddNew : 'productSize',
            BrowseLev : nStaPdtBrowseType
        }
        return oOptionReturn;
    }

    $('#obtModalPszBrowseColor').click(function(e){ 
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#odvModalMngUnitPackSize').modal("hide");
            window.oPdtBrowseColorOption    =   oPdtBrowseColor({
                'tReturnInputCode'  : 'oetModalPszClrCode',
                'tReturnInputName'  : 'oetModalPszClrName',
                'tNextFuncName'     : 'JSxShowModalMngUnitPackSize'
            });
            JCNxBrowseData('oPdtBrowseColorOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtModalPszBrowseSize').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#odvModalMngUnitPackSize').modal("hide");
            window.oPdtBrowseSizeOption    =   oPdtBrowseSize({
                'tReturnInputCode'  : 'oetModalPszSizeCode',
                'tReturnInputName'  : 'oetModalPszSizeName',
                'tNextFuncName'     : 'JSxShowModalMngUnitPackSize'
            })
            JCNxBrowseData('oPdtBrowseSizeOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Function: Function Get Data Product PackSize
    // Parameters:  Object In Next Funct Modal Browse
    // Creator:	08/02/2019 wasin(Yoshi)
    // Return: object View Product Set
    // Return Type: object
    function JSxAddDataUnitPackSizeToTable(poDataNextFunc){
        var aPdtUnitCode    = [];
        for(var i = 0; i < poDataNextFunc.length; i++){
            aColDatas   = JSON.parse(poDataNextFunc[i]);
            if(aColDatas != null){
                aPdtUnitCode.push(aColDatas[0]);
            }
        }
        if(aPdtUnitCode.length !== 0){
            $.ajax({
                type: "POST",
                url: "productGetPackSizeUnit",
                data: {aPdtUnitCode : aPdtUnitCode},
                cache: false,
                timeout: 0,
                async: false,
                success: function(oResult){
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == '1'){
                        $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable table tbody .xWPdtPackSizeNoData').remove();
                        var aPdtPackSizeRow   = aReturnData['aPdtPackSizeRow'];
                        $.each(aPdtPackSizeRow,function(nKey,aValue){
                            var tPdtPunFindRowDup   = 'otrPdtDataUnitRow'+aValue['tPdtUnitCode'];
                            var nPdtPunFindRowDup   = $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable table tbody').find('#'+tPdtPunFindRowDup).length
                            if(nPdtPunFindRowDup == 0){
                                $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable table tbody').append(aValue['tPdtPackSizeRow']).css('opacity',0).slideDown('slow')
                                .animate(
                                    { opacity: 1 },
                                    { queue: false, duration: 'slow' }
                                );
                            }
                        });
                    }else{
                        var tMessageError   = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR,textStatus,errorThrown);
                }
            });
        }
    }

    // Function: Func. Call Back Show Modal Mng Unit Pack Size
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // Return: Open Pop Up Modal Manage PackSize Unit
    // Return Type: -
    function JSxShowModalMngUnitPackSize(){
        $('#odvModalMngUnitPackSize').modal({backdrop: 'static', keyboard: false});
        $('#odvModalMngUnitPackSize').modal("show");
    }

    // Function: Func.Manage Unit PackSize
    // Parameters: Obj Event Click
    // Creator:	11/02/2019 wasin(Yoshi)
    // Return: open Pop Up Modal Manage PackSize Unit
    // Return Type: -
    function JSxPdtMngPszUnitInTable(oEvent){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tPszUnitCode    = $(oEvent).parents('.xWPdtDataUnitRow').data('puncode');
            var tPszUnitName    = $(oEvent).parents('.xWPdtDataUnitRow').data('punname');
            var tPszUnitFact    = $("#otrPdtUnitBarCodeRow"+tPszUnitCode+" #oetPdtUnitFact"+tPszUnitCode).val();
            var tPszGrade       = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtGrandRow"+tPszUnitCode).val();
            var tPszWeight      = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtWeightRow"+tPszUnitCode).val();
            var tPszClrCode     = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtClrCodeRow"+tPszUnitCode).val();
            var tPszClrName     = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtClrNameRow"+tPszUnitCode).val();
            var tPszSizeCode    = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtSizeCodeRow"+tPszUnitCode).val();
            var tPszSizeName    = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtSizeNameRow"+tPszUnitCode).val();
            var tPszUnitDim     = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtUnitDimRow"+tPszUnitCode).val();
            var tPszPackageDim  = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtPkgDimRow"+tPszUnitCode).val();
            var tPszStaAlwPick  = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtStaAlwPickRow"+tPszUnitCode).val();
            var tPszStaAlwPoHQ  = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtStaAlwPoHQRow"+tPszUnitCode).val();
            var tPszStaAlwBuy   = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtStaAlwBuyRow"+tPszUnitCode).val();
            var tPszStaAlwSale  = $(oEvent).parents('.xWPdtDataUnitRow').find("#ohdPdtStaAlwSaleRow"+tPszUnitCode).val();

            $('#ohdModalPszUnitCode').val(tPszUnitCode);
            $('#ohdModalPszUnitName').val(tPszUnitName);
            $("#odvModalMngUnitPackSize #olbModalPszUnitTitle").text('<?php echo language("product/product/product","tPDTViewPackMDUnit");?>'+" : "+tPszUnitName);
            $('#oetModalPszUnitFact').val(tPszUnitFact);
            $('#oetModalPszGrade').val(tPszGrade);
            $('#oetModalPszWeight').val(tPszWeight);
            $('#oetModalPszClrCode').val(tPszClrCode);
            $('#oetModalPszClrName').val(tPszClrName);
            $('#oetModalPszSizeCode').val(tPszSizeCode);
            $('#oetModalPszSizeName').val(tPszSizeName);

            // Chack Data Unit Dim
            if(tPszUnitDim != ""){
                var aSplitPszUnitDim    = tPszUnitDim.split(";");
                $('#oetModalPszUnitDimWidth').val(aSplitPszUnitDim[0]);
                $('#oetModalPszUnitDimLength').val(aSplitPszUnitDim[1]);
                $('#oetModalPszUnitDimHeight').val(aSplitPszUnitDim[2]);
            }else{
                $('#oetModalPszUnitDimWidth').val('');
                $('#oetModalPszUnitDimLength').val('');
                $('#oetModalPszUnitDimHeight').val('');
            }

            // Chack Data Pkg Dim
            if(tPszPackageDim != ""){
                var aSplitPszPackageDim = tPszPackageDim.split(";");
                $('#oetModalPszPackageDimWidth').val(aSplitPszPackageDim[0]);
                $('#oetModalPszPackageDimLength').val(aSplitPszPackageDim[1]);
                $('#oetModalPszPackageDimHeight').val(aSplitPszPackageDim[2]);
            }else{
                $('#oetModalPszPackageDimWidth').val('');
                $('#oetModalPszPackageDimLength').val('');
                $('#oetModalPszPackageDimHeight').val('');
            }
            // Chk Status Allow Pick
            if(tPszStaAlwPick != "" && tPszStaAlwPick == 1){
                $("#ocbModalPszStaAlwPick").prop('checked', true);
            }else{
                $("#ocbModalPszStaAlwPick").prop('checked', false);
            }

            // Chk Status Allow HQ
            if(tPszStaAlwPoHQ != "" && tPszStaAlwPoHQ == 1){
                $("#ocbModalPszStaAlwPoHQ").prop('checked', true);
            }else{
                $("#ocbModalPszStaAlwPoHQ").prop('checked', false);
            }

            // Chk Status Allow Buy
            if(tPszStaAlwBuy != "" && tPszStaAlwBuy == 1){
                $("#ocbModalPszStaAlwBuy").prop('checked', true);
            }else{
                $("#ocbModalPszStaAlwBuy").prop('checked', false);
            }

            // Chk Status Allow Sale
            if(tPszStaAlwSale != "" && tPszStaAlwSale == 1){
                $("#ocbModalPszStaAlwSale").prop('checked', true);
            }else{
                $("#ocbModalPszStaAlwSale").prop('checked', false);
            }

            $('#odvModalMngUnitPackSize').modal({backdrop: 'static', keyboard: false});
            $('#odvModalMngUnitPackSize').modal('show');
            $.getScript( "application/modules/common/assets/src/jFormValidate.js")
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Function: Func.Save Manage Unit PackSize
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // Return: Save Pop Up Modal Manage PackSize Unit
    // Return Type: -
    function JSxPdtSaveMngPszUnitInTable(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tSaveMngPunCode     = $('#ohdModalPszUnitCode').val();

            var tSaveMngUnitFact    = $('#oetModalPszUnitFact').val();
            var tSaveMngPszGrade    = $('#oetModalPszGrade').val();
            var tSaveMngPszWeight   = $('#oetModalPszWeight').val();
            var tSaveMngPszClrCode  = $('#oetModalPszClrCode').val();
            var tSaveMngPszClrName  = $('#oetModalPszClrName').val();
            var tSaveMngPszSizeCode = $('#oetModalPszSizeCode').val();
            var tSaveMngPszSizeName = $('#oetModalPszSizeName').val();
            // Concat String Pack Size Unit Dim
            var tSaveMngPszUnitDimWidth     = $('#oetModalPszUnitDimWidth').val();
            var tSaveMngPszUnitDimLength    = $('#oetModalPszUnitDimLength').val();
            var tSaveMngPszUnitDimHeight    = $('#oetModalPszUnitDimHeight').val();
            var tConcPszUnitDim     =   tSaveMngPszUnitDimWidth+';'+tSaveMngPszUnitDimLength+';'+tSaveMngPszUnitDimHeight
            // Concat String Pack Size Package Dim
            var tSaveMngPszPackageDimWidth  = $('#oetModalPszPackageDimWidth').val();
            var tSaveMngPszPackageDimLength = $('#oetModalPszPackageDimLength').val();
            var tSaveMngPszPackageDimHeight = $('#oetModalPszPackageDimHeight').val();
            var tConcPszPackageDim  =   tSaveMngPszPackageDimWidth+';'+tSaveMngPszPackageDimLength+';'+tSaveMngPszPackageDimHeight
            // Status Manage Pack Size
            var tSaveMngStaPszStaAlwPick    = $('#ocbModalPszStaAlwPick').is(':checked')? '1' : '2';
            var tSaveMngStaPszStaAlwPoHQ    = $('#ocbModalPszStaAlwPoHQ').is(':checked')? '1' : '2';
            var tSaveMngStaPszStaAlwBuy     = $('#ocbModalPszStaAlwBuy').is(':checked')? '1' : '2';
            var tSaveMngStaPszStaAlwSale    = $('#ocbModalPszStaAlwSale').is(':checked')? '1' : '2';

            // Set Value In Input PackSize Data Row
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tSaveMngPunCode+' #oetPdtUnitFact'+tSaveMngPunCode).val(tSaveMngUnitFact);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtGrandRow'+tSaveMngPunCode).val(tSaveMngPszGrade);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtWeightRow'+tSaveMngPunCode).val(tSaveMngPszWeight);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtClrCodeRow'+tSaveMngPunCode).val(tSaveMngPszClrCode);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtClrNameRow'+tSaveMngPunCode).val(tSaveMngPszClrName);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtSizeCodeRow'+tSaveMngPunCode).val(tSaveMngPszSizeCode);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtSizeNameRow'+tSaveMngPunCode).val(tSaveMngPszSizeName);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtUnitDimRow'+tSaveMngPunCode).val(tConcPszUnitDim);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtPkgDimRow'+tSaveMngPunCode).val(tConcPszPackageDim);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtStaAlwPickRow'+tSaveMngPunCode).val(tSaveMngStaPszStaAlwPick);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtStaAlwPoHQRow'+tSaveMngPunCode).val(tSaveMngStaPszStaAlwPoHQ);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtStaAlwBuyRow'+tSaveMngPunCode).val(tSaveMngStaPszStaAlwBuy);
            $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtDataUnitRow'+tSaveMngPunCode+' #ohdPdtStaAlwSaleRow'+tSaveMngPunCode).val(tSaveMngStaPszStaAlwSale);
            $('#odvModalMngUnitPackSize').modal("toggle");
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Function: Func.Delete Unit Pack Size In Table
    // Parameters: Obj Event Click
    // Creator:	11/02/2019 wasin(Yoshi)
    // Return: Delete Row Data Unit Pack Size In Table
    // Return Type: -
    function JSxPdtDelPszUnitInTable(oEvent){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var nPunCode    = $(oEvent).parents('.xWPdtDataUnitRow').data('puncode');
            var tObjUnitDelName = "#otrPdtDataUnitRow"+nPunCode+",#otrPdtUnitBarCodeRow"+nPunCode;
            $(tObjUnitDelName).fadeOut(500,function(){
                $(this).remove();
                var tPdtUnitCode = '';
                var tPdtUnitName = '';
                $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable tbody .xWPdtDataUnitRow').each(function(){
                    var tCode = $(this).data('puncode');
                    var tName = $(this).data('punname');
                    tPdtUnitCode += tCode+','
                    tPdtUnitName += tName+','
                });
                $('#ohdPdtUnitCode').val(tPdtUnitCode.substring(0,tPdtUnitCode.length - 1));
                $('#ohdPdtUnitName').val(tPdtUnitName.substring(0,tPdtUnitName.length - 1));
                var nCoutePdtUnitPszRow = $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable tbody').children().length;
                if(nCoutePdtUnitPszRow == 0){
                    $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable tbody').append($('<tr>')
                    .attr('class','xWPdtPackSizeNoData')
                        .append($('<td>')
                        .attr('class','text-center xCNTextDetail2')
                        .attr('colspan','99')
                        .text('<?php echo language("common/main/main","tCMNNotFoundData");?>')
                        )
                    )
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

/** ================================================================================================================================= */

/** =================================================== Function And Event BarCode ================================================== */

    var oPdtBrowseLocation  = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName       = poReturnInput.tNextFuncName;
        var oOptionReturn       = {
            Title: ['product/pdtlocation/pdtlocation','tLOCTitle'],
            Table: {Master:'TCNMPdtLoc',PK:'FTPlcCode'},
            Join :{  
                Table:['TCNMPdtLoc_L'],
                On:['TCNMPdtLoc_L.FTPlcCode = TCNMPdtLoc.FTPlcCode AND TCNMPdtLoc_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang: 'product/pdtlocation/pdtlocation',
                ColumnKeyLang: ['tLOCFrmLocCode','tLOCFrmLocName'],
                ColumnsSize: ['10%','75%'],
                DataColumns: ['TCNMPdtLoc.FTPlcCode','TCNMPdtLoc_L.FTPlcName'],
                DataColumnsFormat: ['',''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMPdtLoc.FTPlcCode'],
                SourceOrder: "DESC" 
            },
            CallBack:{
                ReturnType: 'S',
                Value: [tInputReturnCode,"TCNMPdtLoc.FTPlcCode"],
                Text: [tInputReturnName,"TCNMPdtLoc_L.FTPlcName"],
            },
            NextFunc:{
                FuncName: tNextFuncName,
            },
            RouteAddNew : 'productLocation',
            BrowseLev : nStaPdtBrowseType
        };
        return oOptionReturn;
    }

    // Event Browse Location In Modal
    $('#obtModalAebBrowsePdtLocation').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#odvModalAddEditBarCode').modal("hide");
            window.oPdtBrowseLocationOption    =   oPdtBrowseLocation({
                'tReturnInputCode'  : 'oetModalAebPlcCode',
                'tReturnInputName'  : 'oetModalAebPlcName',
                'tNextFuncName'     : 'JSxShowModalAddBarCode'
            })
            JCNxBrowseData('oPdtBrowseLocationOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Add BarCode In Modal Add BarCode
    $('#obtModalAebBarCodeSubmit').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxPdtSaveBarCodeInUnitPack();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Function: Func. Call Back Show Modal Add BarCode
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // Return: Open Pop Up Modal Manage PackSize Unit
    // Return Type: -
    function JSxShowModalAddBarCode(){
        // Clear Validate BarCode Input
        $('#oetModalAebBarCode').parents('.form-group').removeClass("has-error");
        $('#oetModalAebBarCode').parents('.form-group').removeClass("has-success");
        $('#oetModalAebBarCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();
        // Clear Validate Product Location Input
        $('#oetModalAebPlcName').parents('.form-group').removeClass("has-error");
        $('#oetModalAebPlcName').parents('.form-group').removeClass("has-success");
        $('#oetModalAebPlcName').parents('.form-group').find(".help-block").fadeOut('slow').remove();
        $('#odvModalAddEditBarCode').modal({backdrop: 'static', keyboard: false});
        $('#odvModalAddEditBarCode').modal("show");
    }

    // Function: Func. Add BarCode In Unit Pack
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // LastUpdate: 13/02/2019 wasin(Yoshi)
    // Return: -
    // Return Type: -
    function JSxPdtCallModalAddEditBardCode(oEvent,tCallAddOrEdit){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Set Add/Edit In Input Hidden In Modal Add Bracode
            $('#ohdModalAebStaCallAddOrEdit').val(tCallAddOrEdit);
            if(tCallAddOrEdit == 'Add'){
                // Get Data Unit Pack Size And Add Value Into Input And Append Text Label Unit Title
                var tAebUnitCode    = $(oEvent).parents('.xWPdtDataUnitRow').data('puncode');
                var tAebUnitName    = $(oEvent).parents('.xWPdtDataUnitRow').data('punname');

                $('#ohdModalAebUnitCode').val(tAebUnitCode);
                $('#ohdModalAebUnitName').val(tAebUnitName);
                $("#odvModalAddEditBarCode #olbModalAebUnitTitle").text('<?php echo language("product/product/product","tPDTViewPackMDUnit");?>'+" : "+tAebUnitName);
                // Clear Value In Input
                $('#oetModalAebBarCode').val('');
                $('#oetModalAebBarCode').prop('disabled',false).removeAttr('style');
                $('#oetModalAebPlcCode').val('');
                $('#oetModalAebPlcName').val('');
                $('#ocbModalAebBarStaUse').prop("checked",false);
                $('#ocbModalAebBarStaAlwSale').prop("checked",false);
                // Clear Validate BarCode Input
                $('#oetModalAebBarCode').parents('.form-group').removeClass("has-error");
                $('#oetModalAebBarCode').parents('.form-group').removeClass("has-success");
                $('#oetModalAebBarCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();

                // Clear Validate Product Location Input
                $('#oetModalAebPlcName').parents('.form-group').removeClass("has-error");
                $('#oetModalAebPlcName').parents('.form-group').removeClass("has-success");
                $('#oetModalAebPlcName').parents('.form-group').find(".help-block").fadeOut('slow').remove();

                // Show Modal
                $('#odvModalAddEditBarCode').modal({backdrop: 'static', keyboard: false});
                $('#odvModalAddEditBarCode').modal('show');
                $.getScript( "application/modules/common/assets/src/jFormValidate.js");
            }else if(tCallAddOrEdit == 'Edit'){
                // Get Value For Input
                var tAebUnitCode            = $(oEvent).parents('.xWPdtUnitBarCodeRow').data('puncode');
                var tAebUnitName            = $(oEvent).parents('.xWPdtUnitBarCodeRow').data('punname');
                var tAebBarcode             = $(oEvent).parents('.xWBarCodeItem').find('.xWPdtAebBarCodeItem').val();
                var tAebPlcCode             = $(oEvent).parents('.xWBarCodeItem').find('.xWPdtAebPlcCodeItem').val();
                var tAebPlcName             = $(oEvent).parents('.xWBarCodeItem').find('.xWPdtAebPlcNameItem').val();
                var tAebBarStaUseItem       = $(oEvent).parents('.xWBarCodeItem').find('.xWPdtAebBarStaUseItem').val();
                var tAebBarStaAlwSaleItem   = $(oEvent).parents('.xWBarCodeItem').find('.xWPdtAebBarStaAlwSaleItem').val();
                // console.log(tAebUnitCode+'/'+tAebUnitName+'/'+tAebBarcode+'/'+tAebPlcCode+'/'+tAebPlcName+'/'+tAebBarStaUseItem+'/'+tAebBarStaAlwSaleItem);
                $('#odvModalAddEditBarCode #ohdModalAebUnitCode').val(tAebUnitCode);
                $('#odvModalAddEditBarCode #ohdModalAebUnitName').val(tAebUnitName);
                $("#odvModalAddEditBarCode #olbModalAebUnitTitle").text('<?php echo language("product/product/product","tPDTViewPackMDUnit");?>'+" : "+tAebUnitName);
                // Set Value In Input
                $('#odvModalAddEditBarCode #oetModalAebBarCode').val(tAebBarcode);
                $('#odvModalAddEditBarCode #oetModalAebBarCode').prop("disabled",true).css('cursor','not-allowed');
                $('#odvModalAddEditBarCode #oetModalAebPlcCode').val(tAebPlcCode);
                $('#odvModalAddEditBarCode #oetModalAebPlcName').val(tAebPlcName);
                (tAebBarStaUseItem == 1)? $('#odvModalAddEditBarCode #ocbModalAebBarStaUse').prop("checked",true) : $('#odvModalAddEditBarCode #ocbModalAebBarStaUse').prop("checked",false);
                (tAebBarStaAlwSaleItem == 1)? $('#odvModalAddEditBarCode #ocbModalAebBarStaAlwSale').prop("checked",true) : $('#odvModalAddEditBarCode #ocbModalAebBarStaAlwSale').prop("checked",false);
                // Clear Validate BarCode Input
                $('#odvModalAddEditBarCode #oetModalAebBarCode').parents('.form-group').removeClass("has-error");
                $('#odvModalAddEditBarCode #oetModalAebBarCode').parents('.form-group').removeClass("has-success");
                $('#odvModalAddEditBarCode #oetModalAebBarCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();

                // Clear Validate Product Location Input
                $('#odvModalAddEditBarCode #oetModalAebPlcName').parents('.form-group').removeClass("has-error");
                $('#odvModalAddEditBarCode #oetModalAebPlcName').parents('.form-group').removeClass("has-success");
                $('#odvModalAddEditBarCode #oetModalAebPlcName').parents('.form-group').find(".help-block").fadeOut('slow').remove();

                // Show Modal
                $('#odvModalAddEditBarCode').modal({backdrop: 'static', keyboard: false});
                $('#odvModalAddEditBarCode').modal('show');
                $.getScript( "application/modules/common/assets/src/jFormValidate.js")
            }else{}
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Function: Func.Save BarCode In Unit Pack
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // LastUpdate: 13/02/2019 wasin(Yoshi)
    // Return: -
    // Return Type: -
    function JSxPdtSaveBarCodeInUnitPack(){
        $('#ofmModalAebBarCode').validate({
            rules: {
                oetModalAebBarCode : "required",
                oetModalAebPlcName : "required",
            },
            messages: {
                oetModalAebBarCode : {
                    "required"      : $('#oetModalAebBarCode').attr('data-validate-required'),
                },
                oetModalAebPlcName : {
                    "required"      : $('#oetModalAebPlcName').attr('data-validate-required'),
                },
            },
            errorElement: "em",
            errorPlacement: function (error,element ) {
                error.addClass( "help-block" );
                if ( element.prop( "type" ) === "checkbox" ) {
                    error.appendTo( element.parent( "label" ) );
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if(tCheck == 0){
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element,errorClass,validClass) {
                $(element).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid  = $(element).parents('.form-group').find('.help-block').length
                if(nStaCheckValid != 0){
                    $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                }
            },
            submitHandler: function(form){
                var tMdAebAddOrEdit     = $('#ohdModalAebStaCallAddOrEdit').val();
                var tMdAebUnitCode      = $('#ohdModalAebUnitCode').val();
                var tMdAebBarCode       = $('#oetModalAebBarCode').val();
                var tMdAebPlcCode       = $('#oetModalAebPlcCode').val();
                var tMdAebPlcName       = $('#oetModalAebPlcName').val();
                var tMdAebBarStaUse     = $('#ocbModalAebBarStaUse').is(':checked')? '1' : '2';
                var tMdAebBarStaAlwSale = $('#ocbModalAebBarStaAlwSale').is(':checked')? '1' : '2';
                
                if(tMdAebAddOrEdit == 'Add'){ // Add BarCode
                    var tPdtStaAutoGenCode  = $('#ocbProductAutoGenCode').is(':checked')? 1 : 2;
                    if(tPdtStaAutoGenCode == 1){
                        var nStaChkBarCodeDupInHtml = JSnChkDupBarcodeItemInHtml(tMdAebBarCode);
                        if(nStaChkBarCodeDupInHtml == 0){
                            // Append Barcode Data Div
                            $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAebUnitCode+' .xWPdtUnitDataBarCode').append($('<div>')
                            .attr('class','text-right xWBarCodeItem xWBarCodeRow'+tMdAebBarCode)
                                .append($('<input>')
                                .attr('type','hidden')
                                .attr('class','form-control xWPdtAebBarCodeItem')
                                .val(tMdAebBarCode)
                                )
                                .append($('<input>')
                                .attr('type','hidden')
                                .attr('class','form-control xWPdtAebPlcCodeItem')
                                .val(tMdAebPlcCode)
                                )
                                .append($('<input>')
                                .attr('type','hidden')
                                .attr('class','form-control xWPdtAebPlcNameItem')
                                .val(tMdAebPlcName)
                                )
                                .append($('<input>')
                                .attr('type','hidden')
                                .attr('class','form-control xWPdtAebBarStaUseItem')
                                .val(tMdAebBarStaUse)
                                )
                                .append($('<input>')
                                .attr('type','hidden')
                                .attr('class','form-control xWPdtAebBarStaAlwSaleItem')
                                .val(tMdAebBarStaAlwSale)
                                )
                                .append($('<lable>')
                                .attr('class','xCNTextLink xWPdtBarCodeDetail')
                                    .append($('<i>')
                                    .attr('class','fa fa-barcode')
                                    .text(' '+tMdAebBarCode)
                                        .click(function(){
                                            JSxPdtCallModalAddEditBardCode(this,'Edit');
                                        })
                                    )
                                )
                            );
                            // Append Div Delete Barcode 
                            $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAebUnitCode+' .xWPdtDelUnitBarCode').append($('<div>')
                            .attr('class','text-center xWDelBarCodeItem xWBarCodeRow'+tMdAebBarCode)
                            .attr('data-barcode',tMdAebBarCode)
                                .append($('<img>')
                                .attr('class','xCNIconTable xWPdtDelBarCodeItem')
                                .attr('src','<?php echo base_url()."/application/modules/common/assets/images/icons/delete.png";?>')
                                    .click(function(){
                                        JSxPdtDelBarCodeInTable(this);
                                    })
                                )
                            )
                            // Append Div Data Supplier
                            $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAebUnitCode+' .xWPdtUnitDataSupplier').append($('<div>')
                            .attr('class','text-right xWSupplierDt xWAddSupplierItem')
                            .attr('data-barcode',tMdAebBarCode)
                            .append("&nbsp;")
                            )
                            // Append Div Delete Supplier
                            $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAebUnitCode+' .xWPdtDelUnitSupplier').append($('<div>')
                            .attr('class','text-center xWSupplierDt xWDelSupplierItem')
                            .attr('data-barcode',tMdAebBarCode)
                            .append("&nbsp;")
                            )
                            $('#odvModalAddEditBarCode').modal("hide");
                        }else{
                            var tMsgBarCodeDupHTML =   '<?php echo language("product/product/product","tPDTViewPackMDMsgBarCodeDupHtml");?>';
                            $('#oetModalAebBarCode').parents('.form-group').removeClass("has-error");
                            $('#oetModalAebBarCode').parents('.form-group').removeClass("has-success");
                            $('#oetModalAebBarCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();
                            $('#oetModalAebBarCode').parents('.form-group').append($('<em>')
                            .attr('id','oetModalAebBarCode-error')
                            .attr('class','error help-block')
                            .text(tMsgBarCodeDupHTML)
                            )
                            $('#oetModalAebBarCode').parents('.form-group').addClass("has-error");
                        }
                    }else{
                        var tMdAebPdtCode = $('#oetPdtCode').val();
                        // เช็ครหัสบาร์โค้ดว่าซ้ำในฐานข้อมูลหรือป่าว
                        var nStaChkBarCodeDupInDB   = JSnChkDupBarcodeItemInDB(tMdAebPdtCode,tMdAebBarCode);
                        // เช็ครหัสบาร์โค้ดว่ามีการเพิ่มไปในตารางแล้วหรือป่าว
                        var nStaChkBarCodeDupInHtml = JSnChkDupBarcodeItemInHtml(tMdAebBarCode);
                        if(nStaChkBarCodeDupInDB == 0){
                            if(nStaChkBarCodeDupInHtml == 0){
                                // Append Barcode Data Div
                                $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAebUnitCode+' .xWPdtUnitDataBarCode').append($('<div>')
                                .attr('class','text-right xWBarCodeItem xWBarCodeRow'+tMdAebBarCode)
                                    .append($('<input>')
                                    .attr('type','hidden')
                                    .attr('class','form-control xWPdtAebBarCodeItem')
                                    .val(tMdAebBarCode)
                                    )
                                    .append($('<input>')
                                    .attr('type','hidden')
                                    .attr('class','form-control xWPdtAebPlcCodeItem')
                                    .val(tMdAebPlcCode)
                                    )
                                    .append($('<input>')
                                    .attr('type','hidden')
                                    .attr('class','form-control xWPdtAebPlcNameItem')
                                    .val(tMdAebPlcName)
                                    )
                                    .append($('<input>')
                                    .attr('type','hidden')
                                    .attr('class','form-control xWPdtAebBarStaUseItem')
                                    .val(tMdAebBarStaUse)
                                    )
                                    .append($('<input>')
                                    .attr('type','hidden')
                                    .attr('class','form-control xWPdtAebBarStaAlwSaleItem')
                                    .val(tMdAebBarStaAlwSale)
                                    )
                                    .append($('<lable>')
                                    .attr('class','xCNTextLink xWPdtBarCodeDetail')
                                        .append($('<i>')
                                        .attr('class','fa fa-barcode')
                                        .text(' '+tMdAebBarCode)
                                            .click(function(){
                                                JSxPdtCallModalAddEditBardCode(this,'Edit');
                                            })
                                        )
                                    )
                                );
                                // Append Div Delete Barcode 
                                $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAebUnitCode+' .xWPdtDelUnitBarCode').append($('<div>')
                                .attr('class','text-center xWDelBarCodeItem xWBarCodeRow'+tMdAebBarCode)
                                .attr('data-barcode',tMdAebBarCode)
                                    .append($('<img>')
                                    .attr('class','xCNIconTable xWPdtDelBarCodeItem')
                                    .attr('src','<?php echo base_url()."/application/modules/common/assets/images/icons/delete.png";?>')
                                        .click(function(){
                                            JSxPdtDelBarCodeInTable(this);
                                        })
                                    )
                                )
                                // Append Div Data Supplier
                                $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAebUnitCode+' .xWPdtUnitDataSupplier').append($('<div>')
                                .attr('class','text-right xWSupplierDt xWAddSupplierItem')
                                .attr('data-barcode',tMdAebBarCode)
                                .append("&nbsp;")
                                )
                                // Append Div Delete Supplier
                                $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAebUnitCode+' .xWPdtDelUnitSupplier').append($('<div>')
                                .attr('class','text-center xWSupplierDt xWDelSupplierItem')
                                .attr('data-barcode',tMdAebBarCode)
                                .append("&nbsp;")
                                )
                                $('#odvModalAddEditBarCode').modal("hide");
                            }else{
                                var tMsgBarCodeDupHTML =   '<?php echo language("product/product/product","tPDTViewPackMDMsgBarCodeDupHtml");?>';
                                $('#oetModalAebBarCode').parents('.form-group').removeClass("has-error");
                                $('#oetModalAebBarCode').parents('.form-group').removeClass("has-success");
                                $('#oetModalAebBarCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();
                                $('#oetModalAebBarCode').parents('.form-group').append($('<em>')
                                .attr('id','oetModalAebBarCode-error')
                                .attr('class','error help-block')
                                .text(tMsgBarCodeDupHTML)
                                )
                                $('#oetModalAebBarCode').parents('.form-group').addClass("has-error");
                            }
                        }else{
                            var tMsgBarCodeDup = "<?php echo language('product/product/product','tPDTViewPackMDMsgBarCodeDup');?>";
                            $('#oetModalAebBarCode').parents('.form-group').removeClass("has-error");
                            $('#oetModalAebBarCode').parents('.form-group').removeClass("has-success");
                            $('#oetModalAebBarCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();
                            $('#oetModalAebBarCode').parents('.form-group').append($('<em>')
                            .attr('id','oetModalAebBarCode-error')
                            .attr('class','error help-block')
                            .text(tMsgBarCodeDup)
                            )
                            $('#oetModalAebBarCode').parents('.form-group').addClass("has-error");
                        }
                    }
                }else if(tMdAebAddOrEdit == 'Edit'){ // Edit BarCode
                    var oObjBarCodeEdit = $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAebUnitCode+' .xWPdtUnitDataBarCode'+' .xWBarCodeRow'+tMdAebBarCode);
                    $(oObjBarCodeEdit).find('.xWPdtAebPlcCodeItem').val(tMdAebPlcCode);
                    $(oObjBarCodeEdit).find('.xWPdtAebPlcNameItem').val(tMdAebPlcName);
                    $(oObjBarCodeEdit).find('.xWPdtAebBarStaUseItem').val(tMdAebBarStaUse);
                    $(oObjBarCodeEdit).find('.xWPdtAebBarStaAlwSaleItem').val(tMdAebBarStaAlwSale);
                    $('#odvModalAddEditBarCode').modal("hide");
                }
            }
        });
    }

    // Function: Func.Check Barcode Duplicate In DB
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // LastUpdate: 13/02/2019 wasin(Yoshi)
    // Return: Status Check Barcode Duplicate In DB
    // Return Type: Numeric
    function JSnChkDupBarcodeItemInDB(ptPdtCode,ptBarcode){
        var nDataChkReturn  =   "";
        $.ajax({
            type: "POST",
            url: "productChkBarCodeDup",
            data: { 
                tPdtCode : ptPdtCode,
                tBarCode : ptBarcode
            },
            cache: false,
            timeout: 0,
            async: false,
            success: function(oResult){
                var aDataChkDup  = JSON.parse(oResult);
                if(aDataChkDup['nStaEvent'] == 1){
                    nDataChkReturn = aDataChkDup['nStaBarCodeDup'];
                }else{
                    var tMsgError   = aDataReturn['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMsgError);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        return nDataChkReturn;
    }

    // Function: Func.Check Barcode Duplicate In Html Add
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // LastUpdate: 13/02/2019 wasin(Yoshi)
    // Return: Status Check Barcode Duplicate In HTML Div
    // Return Type: Numeric
    function JSnChkDupBarcodeItemInHtml(ptBarcode){
        var aDataBarCode   = [];
        $('#odvPdtSetPackSizeTable .xWPdtUnitBarCodeRow .xWBarCodeItem .xWPdtAebBarCodeItem').each(function() {
            var tDataBarCode = $(this).val();
            aDataBarCode.push(tDataBarCode.toString());
        });
        if(jQuery.inArray(ptBarcode,aDataBarCode) != -1){
            return 1;
        }else{
            return 0;
        }
    }

    // Function: Func.Delete Barcode
    // Parameters: Obj Event Click
    // Creator:	13/02/2019 wasin(Yoshi)
    // Return: -
    // Return Type: -
    function JSxPdtDelBarCodeInTable(oEvent){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tMDAebPunCode       = $(oEvent).parents('.xWPdtUnitBarCodeRow').data('puncode');
            var tMDAebBarCode       = $(oEvent).parents('.xWDelBarCodeItem').data('barcode');
            var oObjDeleteBarCode   = $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMDAebPunCode+' .xWBarCodeRow'+tMDAebBarCode);
            $(oObjDeleteBarCode).fadeOut('slow',function(){
                $(this).remove();
            });
            var oObjDeleteSupplier  = $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMDAebPunCode+' .xWSupplierDt[data-barcode="'+tMDAebBarCode+'"]');
            $(oObjDeleteSupplier).fadeOut('slow',function(){
                $(this).remove();
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }


/** ================================================================================================================================= */

/** =================================================== Function And Event Supplier ================================================= */

    var oPdtBrowseSupplier  = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName       = poReturnInput.tNextFuncName;
        var oOptionReturn       = {
            Title: ['supplier/supplier/supplier','tSPLTitle'],
            Table: { Master:'TCNMSpl',PK:'FTSplCode' },
            Join :{  
                Table:['TCNMSpl_L'],
                On:['TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang: 'supplier/supplier/supplier',
                ColumnKeyLang: ['tSPLTBCode','tSPLTBName'],
                ColumnsSize: ['10%','75%'],
                DataColumns: ['TCNMSpl.FTSplCode','TCNMSpl_L.FTSplName'],
                DataColumnsFormat: ['',''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMSpl.FTSplCode'],
                SourceOrder: "DESC" 
            },
            CallBack:{
                ReturnType: 'S',
                Value: [tInputReturnCode,"TCNMSpl.FTSplCode"],
                Text: [tInputReturnName,"TCNMSpl_L.FTSplName"],
            },
            NextFunc:{
                FuncName: tNextFuncName,
            },
            RouteAddNew : 'supplier',
            BrowseLev : nStaPdtBrowseType
        }
        return oOptionReturn;
    }

    // Event Browse Supplier In Modal
    $('#obtModalAebBrowsePdtSupplier').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#odvModalAddEditSupplier').modal("hide");
            window.oPdtBrowseSupplierOption    =   oPdtBrowseSupplier({
                'tReturnInputCode'  : 'oetModalAesSplCode',
                'tReturnInputName'  : 'oetModalAesSplName',
                'tNextFuncName'     : 'JSxShowModalAddEditSupplier'
            })
            JCNxBrowseData('oPdtBrowseSupplierOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Summit Product
    $('#obtModalAesSupplierSubmit').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxPdtSaveSupplierInUnitPack();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Function: Func. Call Back In Browse Show Modal Add Edit Supplier
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // Return: Open Pop Up Modal Manage PackSize Unit
    // Return Type: -
    function JSxShowModalAddEditSupplier(){
        $('#odvModalAddEditSupplier #oetModalAesSplName').parents('.form-group').removeClass("has-error");
        $('#odvModalAddEditSupplier #oetModalAesSplName').parents('.form-group').removeClass("has-success");
        $('#odvModalAddEditSupplier #oetModalAesSplName').parents('.form-group').find(".help-block").fadeOut('slow').remove();

        $('#odvModalAddEditSupplier').modal({backdrop: 'static', keyboard: false});
        $('#odvModalAddEditSupplier').modal("show");
    }
    
    // Function: ฟังก์ชั่นดึงข้อมูลบาร์โค้ดจากตารางคอลัมน์บาร์โค้ด
    // Parameters:
    // Creator:	13/02/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Array Data BarCode
    // Return Type: Array
    function JSaPdtGetDataBarCodeInColumBarCode(ptUnitCode){
        var aDataBarCode   = [];
        $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+ptUnitCode+' .xWBarCodeItem .xWPdtAebBarCodeItem').each(function() {
            var tBarCode    = $(this).val();
            aDataBarCode.push(tBarCode.toString());
        });
        return aDataBarCode;
    }

    // Function: ฟังก์ชั่นดึงข้อมูลบาร์โค้ดจากตารางคอลัมน์ผู้จำหน่าย
    // Parameters:
    // Creator:	14/02/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Array Data BarCode
    // Return Type: Array
    function JSaPdtGetDataBarCodeInColumSupplier(ptUnitCode){
        var aDataBarCodeSpl   = [];
        $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+ptUnitCode+' .xWSupplierDt .xWPdtAesBarCodeItem').each(function() {
            var tBarCode    = $(this).val();
            aDataBarCodeSpl.push(tBarCode.toString());
        });
        return aDataBarCodeSpl;
    }

    // Function: Func.Add Supplier
    // Parameters: Obj Event Click
    // Creator:	14/02/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Show View Modal
    // Return Type: None
    function JSxPdtCallModalAddEditSupplier(oEvent,tCallAddOrEdit){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Set Sta Add Or Edit
            $('#odvModalAddEditSupplier #ohdModalAesStaCallAddOrEdit').val(tCallAddOrEdit);
            if(tCallAddOrEdit == 'Add'){
                var tAesUnitCode    = $(oEvent).parents('.xWPdtDataUnitRow').data('puncode');
                var tAesUnitName    = $(oEvent).parents('.xWPdtDataUnitRow').data('punname');
                var nRowBarCodePsz  = $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tAesUnitCode+' .xWPdtUnitDataBarCode .xWBarCodeItem').length;
                if(nRowBarCodePsz > 0){
                    $('#odvModalAddEditSupplier #ohdModalAesUnitCode').val(tAesUnitCode);
                    $('#odvModalAddEditSupplier #ohdModalAesUnitName').val(tAesUnitName);
                    $("#odvModalAddEditSupplier #olbModalAesUnitTitle").text('<?php echo language("product/product/product","tPDTViewPackMDUnit");?>'+" : "+tAesUnitName);
                    // ===== Get Data BarCode And Append In Modal [odvModalAddEditSupplier]
                    var aDataBarCodeInSupplier  = JSaPdtGetDataBarCodeInColumSupplier(tAesUnitCode);
                    var aDataBarCodeInBarCode   = JSaPdtGetDataBarCodeInColumBarCode(tAesUnitCode);

                    $("#odvModalAddEditSupplier #odvMdAesSelectBarCode").empty()
                    .append($('<label>')
                    .attr('class','xCNLabelFrm')
                    .text('<?php echo language("product/product/product","tPDTViewPackMDSplBarCode");?>')
                    )
                    .append($('<select>')
                    .attr('id','ostModalAesBarcode')
                    .attr('class','selectpicker form-control')
                    .attr('name','ostModalAesBarcode')
                    .attr('data-validate','<?php echo language('product/product/product','tPDTViewPackMDMsgSplNotSltBarCode');?>')
                        .append($('<option>')
                        .attr('value','')
                        .text('<?php echo language("common/main/main","tCMNBlank-NA");?>')
                        )
                    )
                    $.each(aDataBarCodeInBarCode,function(nKey,tBarCode){
                        if(jQuery.inArray(tBarCode,aDataBarCodeInSupplier) != -1){
                        }else{
                            $('#odvModalAddEditSupplier #odvMdAesSelectBarCode #ostModalAesBarcode').append($('<option>')
                            .attr('value',tBarCode)
                            .text(tBarCode)
                            )
                        }
                    });

                    if(aDataBarCodeInSupplier.length === aDataBarCodeInBarCode.length){
                        $('#odvModalAddEditSupplier #ostModalAesBarcode').prop("disabled",true);
                        $('#odvModalAddEditSupplier #obtModalAebBrowsePdtSupplier').prop("disabled",true);
                        $('#odvModalAddEditSupplier #ocbModalAesSplStaAlwPO').prop("disabled",true);
                        $('#odvModalAddEditSupplier #obtModalAddSupplierSubmit').hide();
                    }else{
                        $('#odvModalAddEditSupplier #ostModalAesBarcode').prop("disabled",false);
                        $('#odvModalAddEditSupplier #obtModalAebBrowsePdtSupplier').prop("disabled",false);
                        $('#odvModalAddEditSupplier #ocbModalAesSplStaAlwPO').prop("disabled",false);
                        $('#odvModalAddEditSupplier #obtModalAddSupplierSubmit').show();
                    }

                    $('#ostModalAesBarcode').selectpicker('refresh');
                    $.getScript("application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/css/bootstrap-select.min.css");
                    $.getScript("application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/js/bootstrap-select.min.js");
                    // ===== End Get Data BarCode

                    // ===== Clear Data In Input From
                    $('#ostModalAesBarcode').val('');
                    $('#oetModalAesSplCode').val('');
                    $('#oetModalAesSplName').val('');
                    $('#ocbModalAesSplStaAlwPO').prop("checked",false);
                    // ===== Clear Data In Input From

                    // ===== Clear Validate Modal Suppler
                    $('#odvModalAddEditSupplier #ostModalAesBarcode').parents('.form-group').removeClass("has-error");
                    $('#odvModalAddEditSupplier #ostModalAesBarcode').parents('.form-group').removeClass("has-success");
                    $('#odvModalAddEditSupplier #ostModalAesBarcode').parents('.form-group').find(".help-block").fadeOut('slow').remove();

                    $('#odvModalAddEditSupplier #oetModalAesSplName').parents('.form-group').removeClass("has-error");
                    $('#odvModalAddEditSupplier #oetModalAesSplName').parents('.form-group').removeClass("has-success");
                    $('#odvModalAddEditSupplier #oetModalAesSplName').parents('.form-group').find(".help-block").fadeOut('slow').remove();
                    // ===== End Clear Validate Modal Suppler
                    $('#odvModalAddEditSupplier').modal({backdrop: 'static', keyboard: false});
                    $('#odvModalAddEditSupplier').modal('show');
                    $.getScript( "application/modules/common/assets/src/jFormValidate.js")
                }else{
                    var tMsgBarCodeNotFound = '<?php echo language("product/product/product","tPDTViewPackMDMsgSplBarCodeNotFound");?>';
                    FSvCMNSetMsgWarningDialog(tMsgBarCodeNotFound);
                }
            }else if(tCallAddOrEdit == 'Edit'){
                // Get Value For Input
                var tAesUnitCode    = $(oEvent).parents('.xWPdtUnitBarCodeRow').data('puncode');
                var tAesUnitName    = $(oEvent).parents('.xWPdtUnitBarCodeRow').data('punname');
                var tAesBarcode     = $(oEvent).parents('.xWAddSupplierItem').find('.xWPdtAesBarCodeItem').val();
                var tAesSplCode     = $(oEvent).parents('.xWAddSupplierItem').find('.xWPdtAesSplCodeItem').val();
                var tAesSplName     = $(oEvent).parents('.xWAddSupplierItem').find('.xWPdtAesSplNameItem').val();
                var tAesSplStaAlwPO = $(oEvent).parents('.xWAddSupplierItem').find('.xWPdtAesSplStaAlwPOItem').val();

                // Set Title Modal Supplier
                $('#odvModalAddEditSupplier #ohdModalAesUnitCode').val(tAesUnitCode);
                $('#odvModalAddEditSupplier #ohdModalAesUnitName').val(tAesUnitName);
                $('#odvModalAddEditSupplier #olbModalAesUnitTitle').text('<?php echo language("product/product/product","tPDTViewPackMDUnit");?>'+" : "+tAesUnitName);

                // Set Value In Input
                // ===== Get Data BarCode And Append In Modal [odvModalAddEditSupplier]
                var aDataBarCodeInBarCode   = JSaPdtGetDataBarCodeInColumBarCode(tAesUnitCode);

                $("#odvModalAddEditSupplier #odvMdAesSelectBarCode").empty()
                .append($('<label>')
                .attr('class','xCNLabelFrm')
                .text('<?php echo language("product/product/product","tPDTViewPackMDSplBarCode");?>')
                )
                .append($('<select>')
                .attr('id','ostModalAesBarcode')
                .attr('class','selectpicker form-control')
                .attr('name','ostModalAesBarcode')
                .attr('data-validate','<?php echo language('product/product/product','tPDTViewPackMDMsgSplNotSltBarCode');?>')
                    .append($('<option>')
                    .attr('value','')
                    .text('<?php echo language("common/main/main","tCMNBlank-NA");?>')
                    )
                )

                $.each(aDataBarCodeInBarCode,function(nKey,tBarCode){
                    $('#odvModalAddEditSupplier #odvMdAesSelectBarCode #ostModalAesBarcode').append($('<option>')
                    .attr('value',tBarCode)
                    .text(tBarCode)
                    )
                })

                $('#odvModalAddEditSupplier #ostModalAesBarcode').val(tAesBarcode);
                $('#odvModalAddEditSupplier #ostModalAesBarcode').prop("disabled",true);
                $('#odvModalAddEditSupplier #obtModalAebBrowsePdtSupplier').prop("disabled",false);
                $('#odvModalAddEditSupplier #ocbModalAesSplStaAlwPO').prop("disabled",false);
                $('#odvModalAddEditSupplier #obtModalAddSupplierSubmit').show();

                $('#ostModalAesBarcode').selectpicker('refresh');
                $.getScript("application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/css/bootstrap-select.min.css");
                $.getScript("application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/js/bootstrap-select.min.js");

                $('#odvModalAddEditSupplier #oetModalAesSplCode').val(tAesSplCode);
                $('#odvModalAddEditSupplier #oetModalAesSplName').val(tAesSplName);

                if(tAesSplStaAlwPO == '1'){
                    $('#odvModalAddEditSupplier #ocbModalAesSplStaAlwPO').prop("checked",true);
                }else{
                    $('#odvModalAddEditSupplier #ocbModalAesSplStaAlwPO').prop("checked",false);
                }

                // ===== Clear Validate Modal Suppler
                $('#odvModalAddEditSupplier #ostModalAesBarcode').parents('.form-group').removeClass("has-error");
                $('#odvModalAddEditSupplier #ostModalAesBarcode').parents('.form-group').removeClass("has-success");
                $('#odvModalAddEditSupplier #ostModalAesBarcode').parents('.form-group').find(".help-block").fadeOut('slow').remove();

                $('#odvModalAddEditSupplier #oetModalAesSplName').parents('.form-group').removeClass("has-error");
                $('#odvModalAddEditSupplier #oetModalAesSplName').parents('.form-group').removeClass("has-success");
                $('#odvModalAddEditSupplier #oetModalAesSplName').parents('.form-group').find(".help-block").fadeOut('slow').remove();
                // ===== End Clear Validate Modal Suppler
                $('#odvModalAddEditSupplier').modal({backdrop: 'static', keyboard: false});
                $('#odvModalAddEditSupplier').modal('show');
                $.getScript( "application/modules/common/assets/src/jFormValidate.js")
            }else{}
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
    
    // Function: Func. Save Supplier By BarCode In PackSize Table
    // Parameters: Obj Event Click
    // Creator:	14/02/2019 wasin(Yoshi)
    // Return: Append Data Supplier In Div
    // Return Type: None
    function JSxPdtSaveSupplierInUnitPack(){
        $('#ofmModalAesSupplier').validate({
            rules: {
                ostModalAesBarcode : { required: true },
                oetModalAesSplName : { required: true },
            },
            messages: {
                ostModalAesBarcode : $('#ostModalAesBarcode').data('validate'),
                oetModalAesSplName : $('#oetModalAesSplName').data('validate'),
            },
            errorElement: "em",
            errorPlacement: function (error,element ) {
                error.addClass( "help-block" );
                if ( element.prop( "type" ) === "checkbox" ) {
                    error.appendTo( element.parent( "label" ) );
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if(tCheck == 0){
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element,errorClass,validClass) {
                $(element).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function(element,errorClass,validClass) {
                $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
            },
            submitHandler: function(form){
                var tMdAesAddOrEdit     = $('#ohdModalAesStaCallAddOrEdit').val();
                var tMdAesUnitCode      = $('#ohdModalAesUnitCode').val();
                var tMdAesUnitName      = $('#ohdModalAesUnitName').val();
                var tMdAesBarCode       = $('#ostModalAesBarcode').val();
                var tMdAesSplCode       = $('#oetModalAesSplCode').val();
                var tMdAesSplName       = $('#oetModalAesSplName').val();
                var tMdAesSplStaAlwPO   = $('#ocbModalAesSplStaAlwPO').is(':checked')? '1' : '2';
                if(tMdAesAddOrEdit == 'Add'){
                    // Append Supplier Data In Div
                        $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAesUnitCode+' .xWPdtUnitDataSupplier .xWAddSupplierItem[data-barcode="'+tMdAesBarCode+'"]').empty()
                        .append($('<input>')
                        .attr('type','hidden')
                        .attr('class','form-control xWPdtAesBarCodeItem')
                        .val(tMdAesBarCode)
                        )
                        .append($('<input>')
                        .attr('type','hidden')
                        .attr('class','form-control xWPdtAesSplCodeItem')
                        .val(tMdAesSplCode)
                        )
                        .append($('<input>')
                        .attr('type','hidden')
                        .attr('class','form-control xWPdtAesSplNameItem')
                        .val(tMdAesSplName)
                        )
                        .append($('<input>')
                        .attr('type','hidden')
                        .attr('class','form-control xWPdtAesSplStaAlwPOItem')
                        .val(tMdAesSplStaAlwPO)
                        )
                        .append($('<lable>')
                        .attr('class','xCNTextLink xWPdtSplDetail')
                            .append($('<i>')
                            .attr('class','fa fa-users')
                            .text(' '+tMdAesSplName)
                                .click(function(){
                                    JSxPdtCallModalAddEditSupplier(this,'Edit');
                                })
                            )
                        )
                    // End Supplier Data In Div

                    // Append Delete Supplier Data In Div
                        $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAesUnitCode+' .xWPdtDelUnitSupplier .xWDelSupplierItem[data-barcode="'+tMdAesBarCode+'"]').empty()
                        .append($('<img>')
                        .attr('class','xCNIconTable xWPdtDelSupplierItem')
                        .attr('src','<?php echo base_url()."/application/modules/common/assets/images/icons/delete.png";?>')
                            .click(function(){
                                JSxPdtDelSupplierInTable(this);
                            })
                        )
                    // End Delete Supplier Data In Div
                    $('#odvModalAddEditSupplier').modal("hide");
                }else if(tMdAesAddOrEdit == 'Edit'){
                    var oPdtSplEdit = $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMdAesUnitCode+' .xWPdtUnitDataSupplier .xWAddSupplierItem[data-barcode="'+tMdAesBarCode+'"]');
                    $(oPdtSplEdit).find('.xWPdtAesSplCodeItem').val(tMdAesSplCode);
                    $(oPdtSplEdit).find('.xWPdtAesSplNameItem').val(tMdAesSplName);
                    $(oPdtSplEdit).find('.xWPdtAesSplStaAlwPOItem').val(tMdAesSplStaAlwPO);
                    $(oPdtSplEdit).find('.xWPdtSplDetail').empty()
                    .append($('<i>')
                    .attr('class','fa fa-users')
                    .text(' '+tMdAesSplName)
                        .click(function(){
                            JSxPdtCallModalAddEditSupplier(this,'Edit');
                        })
                    );

                    $('#odvModalAddEditSupplier').modal("hide");
                }else{}
            }
        });
    }

    // Function: Func. Delete Supplier 
    // Parameters: Obj Event Click
    // Creator:	14/02/2019 wasin(Yoshi)
    // Return: -
    // Return Type: -
    function JSxPdtDelSupplierInTable(oEvent){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tMDAesPunCode       = $(oEvent).parents('.xWPdtUnitBarCodeRow').data('puncode');
            var tMDAesBarCode       = $(oEvent).parents('.xWDelSupplierItem').data('barcode');
            var oMDAesDelDataSpl    = $('#odvPdtSetPackSizeTable #otrPdtUnitBarCodeRow'+tMDAesPunCode+' .xWSupplierDt[data-barcode="'+tMDAesBarCode+'"]');
            $(oMDAesDelDataSpl).fadeOut('slow',function(){
                $(this).empty().removeAttr('style').append("&nbsp;");
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }



/** ================================================================================================================================= */

/** ==================================================== Function And Event Product Set ============================================= */

    // Click Browse Product Product Set
    $('#olbAddPdtSet').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oPdtBrowsePdtSetOption   =   oPdtBrowsePdtSet({
                'tReturnInputCode'  : 'ohdPdtSetCode',
                'tReturnInputName'  : 'ohdPdtSetName',
                'tNextFuncName'     : 'JSxAddDataPdtSetToTable'
            });
            JCNxBrowseData('oPdtBrowsePdtSetOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Function: Function Get Data Product Set
    // Parameters:  Object In Next Funct Modal Browse
    // Creator:	07/02/2019 wasin(Yoshi)
    // Return: object View Product Set
    // Return Type: object
    function JSxAddDataPdtSetToTable(poDataNextFunc){
        var aProductCode = [];
        for(var i = 0; i < poDataNextFunc.length; i++){
            aColDatas   = JSON.parse(poDataNextFunc[i]);
            if(aColDatas != null){
                aProductCode.push(aColDatas[0]);
            }
        }
        if(aProductCode.length !== 0){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "productGetDataPdtSet",
                data: { aPdtCode : aProductCode },
                cache: false,
                timeout: 0,
                async: false,
                success: function(oResult){
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == '1'){
                        $('#odvPdtContentSet #odvPdtSetTable #odvPdtSetDataTable').empty().html(aReturnData['vPdtDataSet']).hide().fadeIn('slow');
                        JSxAddRowDataConfigPdtSet();
                    }else{
                        var tMessageError   = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                    }
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR,textStatus,errorThrown);
                }
            });
        }
    }
/** ================================================================================================================================= */

/** ================================================ Function And Event Product Event No Sale ======================================== */
    // Click Browse Product Event Not Sale
    $('#olbAddPdtEvnNotSale').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oPdtBrowsePdtEvnNoSaleOption = oPdtBrowsePdtEvnNoSale({
                'tReturnInputCode'  : 'ohdPdtEvnNoSleCode',
                'tReturnInputName'  : 'ohdPdtEvnNoSleName',
                'tNextFuncName'     : 'JSoAddDataPdtEvnNotSaleToTable'
            });
            JCNxBrowseData('oPdtBrowsePdtEvnNoSaleOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Function: Function Get Data Event Not Sale To Table
    // Parameters:  Object In Next Funct Modal Browse
    // Creator:	07/02/2019 wasin(Yoshi)
    // Return: object View Event Not Sale Data Table
    // Return Type: object
    function JSoAddDataPdtEvnNotSaleToTable(poDataNextFunc){
        if(poDataNextFunc != 'NULL'){
            var aDataPdtEvnNotSale  = $.parseJSON(poDataNextFunc);
            var tEvnCode            = aDataPdtEvnNotSale[0];
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "productGetEvnNotSale",
                data: { tEvnCode : tEvnCode},
                cache: false,
                timeout: 0,
                success: function(oResult){
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == '1'){
                        $('#odvPdtContentEvnNotSale #odvPdtEvnNotSaleTable #odvPdtEvnNotSaleDataTable').empty().html(aReturnData['vPdtEvnNotSale']).hide().fadeIn('slow');
                    }else{
                        var tMessageError   = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                    }
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR,textStatus,errorThrown);
                }
            });
        }
    }

    // Function : Delete All Prodcut Event Not Sale
    // Parameters : 
    // Creator : 07/02/2019 wasin(Yoshi)
    // Return : Delete Data All In Table Event Not Sale
    // Return Type : -
    function JSxDelAllPdtEvnNotSale(){
        var nRowDataEvnNotSale  = $('#odvPdtContentEvnNotSale #odvPdtEvnNotSaleDataTable table tbody tr.xWEvnNotSaleRow').length;
        if(nRowDataEvnNotSale > 0){
            $('#odvPdtContentEvnNotSale #odvPdtEvnNotSaleDataTable table tbody').empty().append($('<tr>')
            .attr('class','xWPdtEvnNoSaleNoData')
                .append($('<td>')
                .attr('class','text-center xCNTextDetail2')
                .attr('colspan','99')
                .text('<?php echo language("common/main/main","tCMNNotFoundData");?>')
                )    
            ).hide().fadeIn('slow');
            $('#ohdPdtEvnNoSleCode').val('');
            $('#ohdPdtEvnNoSleName').val('');
        }else{
            var tTextMessage    = '<?php echo language("product/product/product","tPDTDelNotFoundEvnNotSale");?>';
            FSvCMNSetMsgWarningDialog(tTextMessage);
        }
    }

/** ================================================================================================================================== */

/** ============================================= Function Show Price Detail All ===================================================== */
    
    $('#olbPdtPriceAllData').unbind().click(function(){
        JSvPdtCallModalPriceList();
    });

    
    // Function: ฟังก์ชั่น Call Modal View Product Price Detail
    // Parameters: Object In Next Funct Modal Browse
    // Creator:	27/02/2019 wasin(Yoshi)
    // Return: View Modal Price Detail
    // ReturnType: View
    function JSvPdtCallModalPriceList(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tPriceDTPdtCode = $('#oetPdtCode').val();
            var tPriceDTPdtName = $('#oetPdtName').val();
            $.ajax({
                type: "POST",
                url: "productCallModalPriceList",
                data: {
                    ptPriceDTPdtCode : tPriceDTPdtCode,
                    ptPriceDTPdtName : tPriceDTPdtName
                },
                cache: false,
                timeout: 0,
                async: false,
                success: function(oResult){
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == 1){
                        $('#odvModallAllPriceList').empty();
                        $('#odvModallAllPriceList').append(aReturnData['vPdtModalPriceList']);
                        $('#odvModallAllPriceList #odvModalPdtPriceDetail').modal({backdrop: 'static', keyboard: false});
                        $('#odvModallAllPriceList #odvModalPdtPriceDetail').modal('show');
                        $.getScript( "application/modules/common/assets/src/jFormValidate.js");
                    }else if(aReturnData['nStaEvent'] == 500){
                        var tMessageError   = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                    }else{}
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

/** ================================================================================================================================== */
</script>