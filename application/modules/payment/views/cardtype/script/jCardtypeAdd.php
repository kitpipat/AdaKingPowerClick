<script type="text/javascript">

    $(document).ready(function () {
        var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';

        if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
            $('#obtCTYUsrBrowseAgency').attr("disabled", true);
            // $('#oimBrowseBranch').attr("disabled", true);
        }else{
            $('#obtCTYUsrBrowseAgency').attr("disabled", false);
        }

        if(JSbCtyIsCreatePage()){
            // Cty Code
            $("#oetCtyCode").attr("disabled", true);
            $('#ocbCardtypeAutoGenCode').change(function(){
                if($('#ocbCardtypeAutoGenCode').is(':checked')) {
                    $('#oetCtyCode').val('');
                    $("#oetCtyCode").attr("disabled", true);
                    $('#odvCardtypeCodeForm').removeClass('has-error');
                    $('#odvCardtypeCodeForm em').remove();
                }else{
                    $("#oetCtyCode").attr("disabled", false);
                }
            });
            JSxCtyVisibleComponent('#odvCardtypeAutoGenCode', true);
        }

        if(JSbCtyIsUpdatePage()){
            // Sale Person Code
            $("#oetCtyCode").attr("readonly", true);
            $('#odvCardtypeAutoGenCode input').attr('disabled', true);
            JSxCtyVisibleComponent('#odvCardtypeAutoGenCode', false);    
        }

        $('#oetCtyCode').blur(function(){
            JSxCheckCtyCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckCtyCodeDupInDB(){
        if(!$('#ocbCardtypeAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMCardType",
                    tFieldName: "FTCtyCode",
                    tCode: $("#oetCtyCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCtyCode").val(aResult["rtCode"]);
                    JSxCtySetValidEventBlur();
                    $('#ofmAddCardType').submit();
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
    function JSxCtySetValidEventBlur(){
        $('#ofmAddCardType').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateCtyCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddCardType').validate({
            rules: {
                oetCtyCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbCardtypeAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },

                oetCtyName:  {"required" :{}},
  
            },
            messages: {
                oetCtyCode : {
                    "required"      : $('#oetCtyCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCtyCode').attr('data-validate-dublicateCode')
                },
             
                oetCtyName : {
                    "required"      : $('#oetCtyName').attr('data-validate-required'),
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
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid  = $(element).parents('.form-group').find('.help-block').length
                if(nStaCheckValid != 0){
                    $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                }
            },
            submitHandler: function(form){}
        });
    }


        $('#obtCTYUsrBrowseAgency').on('click',function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oUsrAgnOption       = undefined;
                oUsrAgnOption              = oUsrBrowseAgency({
                    'tReturnInputCode'          : 'oetCTYUsrAgnCode',
                    'tReturnInputName'          : 'oetCTYUsrAgnName',
                    'aArgReturn'                : ['FTAgnCode','FTAgnName']
                });
                JCNxBrowseData('oUsrAgnOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Browse AD
        // Option Browse Merchant
        var nLangEdits = "<?php echo $this->session->userdata("tLangEdit")?>";
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