<script type="text/javascript">
    $('#oetSpnLevel').selectpicker();

    $(document).ready(() => {
        $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
        $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

        $('#oimSpnBrowseProvince').click(function(){
            JCNxBrowseData('oPvnOption');
        });
        
        $('#oimSpnBrowseBranch').click(function(){JCNxBrowseData('oBchBrowseBranch');});
        $('#oimSpnBrowseShop').click(function(){JCNxBrowseData('oShpBrowseShop');});
        
        $('#xWShopMode').css('display', 'none');
        $('#oetSpnLevel').change();
        
        // if(JSbSalePersonIsCreatePage()){
            // Sale Person Code
            $("#oetSpnCode").attr("disabled", true);
            $('#ocbSalePersonAutoGenCode').change(function(){
                console.log('1');
                if($('#ocbSalePersonAutoGenCode').is(':checked')) {
                    console.log('1.1');
                    $('#oetSpnCode').val('');
                    $("#oetSpnCode").attr("disabled", true);
                    $('#odvSalePersonCodeForm').removeClass('has-error');
                    $('#odvSalePersonCodeForm em').remove();
                }else{
                    console.log('1.2');
                    $("#oetSpnCode").attr("disabled", false);
                }
            });
            JSxSalePersonVisibleComponent('#odvSalePersonAutoGenCode', true);
        // }

        if(JSbSalePersonIsUpdatePage()){
            // Sale Person Code
            $("#oetSpnCode").attr("readonly", true);
            $('#odvSalePersonAutoGenCode input').attr('disabled', true);
            JSxSalePersonVisibleComponent('#odvSalePersonAutoGenCode', false);    
        }
    });

    $('#oetSpnCode').blur(function(){
        JSxCheckSalePersonCodeDupInDB();
    });

    //Set Lang Edit 
    var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;
    //Option Reference
    var oBchBrowseBranch = {
        Title : ['company/branch/branch', 'tBCHTitle'],
        Table:{Master:'TCNMBranch', PK:'FTBchCode'},
        Join :{
            Table: ['TCNMBranch_L'],
            On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
        },
        Where :{
            // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
        },
        GrideView:{
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBCHCode', 'tBCHName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 5,
            OrderBy			: ['TCNMBranch_L.FTBchName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetBchCode", "TCNMBranch.FTBchCode"],
            Text		: ["oetBchName", "TCNMBranch_L.FTBchName"]
        },
        RouteFrom : 'saleperson',
        RouteAddNew : 'branch',
        BrowseLev : nStaSpnBrowseType
    };

    var oShpBrowseShop = {
        Title : ['company/shop/shop', 'tSHPTitle'],
        Table:{Master:'TCNMShop', PK:'FTShpCode'},
        Join :{
            Table: ['TCNMShop_L'],
            On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits]
        },
        Where :{
            // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
        },
        GrideView:{
            ColumnPathLang	: 'company/shop/shop',
            ColumnKeyLang	: ['tSHPCode', 'tShopName'],
            ColumnsSize     : ['15%', '75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 5,
            OrderBy			: ['TCNMShop_L.FTShpName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetShpCode", "TCNMShop.FTShpCode"],
            Text		: ["oetShpName", "TCNMShop.FTShpName"]
        },
        RouteFrom : 'saleperson',
        RouteAddNew : 'shop',
        BrowseLev : nStaSpnBrowseType
    };


    //Functionality : Event Check Sale Person Duplicate
    //Parameters : Event Blur Input Sale Person Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Return : -
    //Return Type : -
    function JSxCheckSalePersonCodeDupInDB(){
        if(!$('#ocbSalePersonAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMSpn",
                    tFieldName: "FTSpnCode",
                    tCode: $("#oetSpnCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateSpnCode").val(aResult["rtCode"]);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

            // Set Validate Dublicate Code
            $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdCheckDuplicateSpnCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            },'');

            // From Summit Validate
            $('#ofmAddSalePerson').validate({
                rules: {
                    oetSpnCode : {
                        "required" :{
                            // ตรวจสอบเงื่อนไข validate
                            depends: function(oElement) {
                                if($('#ocbSalePersonAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                            }
                        },
                        "dublicateCode" :{}
                    },
                    oetSpnName:     {"required" :{}},
                    oetSpnEmail:    {"required" :{}},
                },
                messages: {
                    oetSpnCode : {
                        "required"      : $('#oetSpnCode').attr('data-validate-required'),
                        "dublicateCode" : $('#oetSpnCode').attr('data-validate-dublicateCode')
                    },
                    oetSpnName : {
                        "required"      : $('#oetSpnName').attr('data-validate-required'),
                    },
                    oetSpnEmail: {
                        "required"      : $('#oetSpnEmail').attr('data-validate-required'),
                    }
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
                unhighlight: function (element, errorClass, validClass) {
                    $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                },
                submitHandler: function(form){}
            });

            // Submit From
            $('#ofmAddSalePerson').submit();
        }
    }




</script>