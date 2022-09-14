<script type="text/javascript">
    $(document).ready(function(){

        $('.selectpicker').selectpicker();

        if(JSbStmIsCreatePage()){
            //supplierlev Code
            $("#oetStmCode").attr("disabled", true);
            $('#ocbStmAutoGenCode').change(function(){
                if($('#ocbStmAutoGenCode').is(':checked')) {
                    $('#oetStmCode').val('');
                    $("#oetStmCode").attr("disabled", true);
                    $('#odvStmCodeForm').removeClass('has-error');
                    $('#odvStmCodeForm em').remove();
                }else{
                    $("#oetStmCode").attr("disabled", false);
                }
            });
            JSxStmVisibleComponent('#odvStmAutoGenCode', true);
        }
        
        if(JSbStmIsUpdatePage()){
      
            // supplierlev Code
            $("#oetStmCode").attr("readonly", true);
            $('#odvStmAutoGenCode input').attr('disabled', true);
            JSxStmVisibleComponent('#odvStmAutoGenCode', false);    
        }
    });

    $('#oetStmCode').blur(function(){
        JSxStmCheckCodeDupInDB();
    });

    // Create By : Napat(Jame) 08/11/2021
    function JSxStmCheckCodeDupInDB(){
        if(!$('#ocbStmAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMSplGrp",
                    tFieldName: "FTStmCode",
                    tCode: $("#oetStmCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdStmCheckDuplicateCode").val(aResult["rtCode"]);
                    // Set Validate  Code
                    $.validator.addMethod('dublicateCode', function(value, element) {
                        if($("#ohdStmCheckDuplicateCode").val() == 1){
                            return false;
                        }else{
                            return true;
                        }
                    },'');
                    // From Summit Validate
                    $('#ofmStmAdd').validate({
                        rules: {
                            oetStmCode : {
                                "required" :{
                                    // ตรวจสอบเงื่อนไข validate
                                    depends: function(oElement) {
                                    if($('#ocbStmAutoGenCode').is(':checked')){
                                            return false;
                                    }else{
                                            return true;
                                        }
                                    }
                                },
                                "dublicateCode" :{}
                            },
                            oetStmName:     {"required" :{ }},
                        },
                        messages: {
                            oetStmCode : {
                                "required"      : $('#oetStmCode').attr('data-validate-required'),
                                "dublicateCode" : $('#oetStmCode').attr('data-validate-dublicateCode')
                            },
                            oetStmName : {
                                "required"      : $('#oetStmName').attr('data-validate-required'),
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
                        unhighlight: function (element, errorClass, validClass) {
                            $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                        },
                        submitHandler: function(form){}
                    });

                    // Submit From
                    $('#ofmStmAdd').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }

    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;

    // BrowseAgn 
    $('#obtStmBrowseAgency').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oStmBrowseAgencyOption = oStmBrowseAgency({
                'tReturnInputCode'  : 'oetStmAgnCode',
                'tReturnInputName'  : 'oetStmAgnName',
            });
            JCNxBrowseData('oStmBrowseAgencyOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    }); 

    //Option Agn
    var oStmBrowseAgency =   function(poReturnInput){
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

    
    $('#oliStmContent1').off('click').on('click',function(){
        $('#odvBtnAddEdit').show();
    });

    $('#oliStmContent2').off('click').on('click',function(){
        if ($(this).hasClass('xCNCloseTabNav') == false) {
            JSxStmSubPageDataTable();
        }
    });

    // Browse CreditCard
    $('#obtStmAddSub').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oStmBrowseCreditCardOption = oStmBrowseCreditCard({
                'tReturnInputCode'  : 'oetStmCrdCode',
                'tReturnInputName'  : 'oetStmCrdName',
                'tStmCode'          : $('#oetStmCode').val(),
                'tStmAgnCode'       : $('#oetStmAgnCode').val()
            });
            // JCNxBrowseData('oStmBrowseCreditCardOption');
            JCNxBrowseMultiSelect('oStmBrowseCreditCardOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    }); 

    // Option CreditCard
    var oStmBrowseCreditCard =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;

        var tStmCode            = poReturnInput.tStmCode;
        var tStmAgnCode         = poReturnInput.tStmAgnCode;

        var oOptionReturn       = {
            Title : ['ticket/agency/agency', 'บัตรเครดิต'],
            Table:{Master:'TFNMCreditCard', PK:'FTCrdCode'},
            Join :{
            Table: ['TFNMCreditCard_L','TFNMBank_L','TFNMInstallmentSub'],
                On: [
                    ' TFNMCreditCard_L.FTCrdCode = TFNMCreditCard.FTCrdCode AND TFNMCreditCard_L.FNLngID = ' + nLangEdits,
                    ' TFNMBank_L.FTBnkCode = TFNMCreditCard.FTBnkCode AND TFNMBank_L.FNLngID = ' + nLangEdits,
                    " TFNMInstallmentSub.FTAgnCode = '"+tStmAgnCode+"' AND TFNMInstallmentSub.FTStmCode = '"+tStmCode+"'  AND TFNMCreditCard.FTCrdCode = TFNMInstallmentSub.FTCrdCode "
                ]
            },
            Where: {
                Condition: [' AND TFNMInstallmentSub.FTCrdCode IS NULL ']
            },
            GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['รหัสบัตรเครดิต', 'ชื่อบัตรเครดิต','ธนาคารที่ออกให้'],
                ColumnsSize     : ['10%', '50%', '40%'],
                WidthModal      : 50,
                DataColumns		: ['TFNMCreditCard.FTCrdCode', 'TFNMCreditCard_L.FTCrdName','TFNMBank_L.FTBnkName','TFNMBank_L.FTBnkCode'],
                DisabledColumns : [3],
                // DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TFNMCreditCard.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TFNMCreditCard.FTCrdCode"],
                Text		: [tInputReturnName,"TFNMCreditCard_L.FTCrdName"],
            },
            NextFunc:{
                FuncName    : 'JSxStmNextFuncCreditCard',
                ArgReturn   : ['FTCrdCode','FTBnkCode']
            },
            // DebugSQL: true,
        }
        return oOptionReturn;
    }
    
    function JSxStmNextFuncCreditCard(poDataNextfunc) {
        if( poDataNextfunc[0] != null ){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "masInstallmentTermsSubEventAddEdit",
                data: {
                    oetStmAgnCode     : $('#oetStmAgnCode').val(),
                    oetStmCode        : $('#oetStmCode').val(),
                    poDataParam       : poDataNextfunc
                },
                cache: false,
                Timeout: 0,
                success: function(oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if( aReturnData['nStaEvent'] == 1 ){
                        JSxStmSubPageDataTable();
                    }else{
                        alert(aReturnData['tStaMessg']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

</script>