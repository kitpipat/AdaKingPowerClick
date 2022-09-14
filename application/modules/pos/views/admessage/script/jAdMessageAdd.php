<script type="text/javascript">
    $('.selection-2').selectpicker();

    // $('#ocmRcnGroup').change(function() {
    //     $('#ocmRcnGroup-error').hide();
    // });

    $(document).ready(function () {
        if(JSbAdvIsCreatePage()){
            // Adv Code
            $("#oetAdvCode").attr("disabled", true);
            $('#ocbAdvAutoGenCode').change(function(){
                if($('#ocbAdvAutoGenCode').is(':checked')) {
                    $('#oetAdvCode').val('');
                    $("#oetAdvCode").attr("disabled", true);
                    $('#odvAdvCodeForm').removeClass('has-error');
                    $('#odvAdvCodeForm em').remove();
                }else{
                    $("#oetAdvCode").attr("disabled", false);
                }
            });
            JSxAdvVisibleComponent('#odvAdvAutoGenCode', true);
        }

        if(JSbAdvIsUpdatePage()){
            // Sale Person Code
            $("#oetAdvCode").attr("readonly", true);
            $('#odvAdvAutoGenCode input').attr('disabled', true);
            JSxAdvVisibleComponent('#odvAdvAutoGenCode', false);    
        }

        $('#oetAdvCode').blur(function(){
            JSxCheckAdvCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckAdvCodeDupInDB(){
        if(!$('#ocbAdvAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMAdMsg",
                    tFieldName: "FTAdvCode",
                    tCode: $("#oetAdvCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateAdvCode").val(aResult["rtCode"]);
                    JSxAdvSetValidEventBlur();
                    $('#ofmAddAdMessage').submit();
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
    function JSxAdvSetValidEventBlur(){
        $('#ofmAddAdMessage').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateAdvCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddAdMessage').validate({
            rules: {
                oetAdvCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbAdvAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                oetAdvName:     {"required" :{}},
                // ocmRcnGroup:    {"required" :{}},
            },
            messages: {
                oetAdvCode : {
                    "required"      : $('#oetAdvCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetAdvCode').attr('data-validate-dublicateCode')
                },
                oetAdvName : {
                    "required"      : $('#oetAdvName').attr('data-validate-required'),
                }
                // ocmRcnGroup: {
                //     "required"      : $('#osmSelect').attr('data-validate-required'),
                // }
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


    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode'  : 'oetAdvAgnCode',
                'tReturnInputName'  : 'oetAdvAgnName',
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;

    //Option Agn
    var oBrowseAgn =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;

        var oOptionReturn       = {
            Title : ['ticket/agency/agency', 'tAggTitle'],
            Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
            Join :{
            Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['tAggCode', 'tAggName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnName,"TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew : 'agency',
            BrowseLev : 1,
        }
        return oOptionReturn;
    }


    var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';


    if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
        $('#oimBrowseAgn').attr("disabled", true);
    
    }


</script>