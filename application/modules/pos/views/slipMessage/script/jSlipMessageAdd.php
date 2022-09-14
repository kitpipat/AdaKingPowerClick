<script type="text/javascript">
    $('.selection-2').selectpicker();


    $(document).ready(function () {
        var tStaUsrLevel    = "<?php  echo $this->session->userdata("tSesUsrLevel");?>";

        if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
            $('#obtSMGUsrBrowseAgency').attr("disabled", true);
            // $('#oimBrowseBranch').attr("disabled", true);
        }else{
            $('#obtSMGUsrBrowseAgency').attr("disabled", false);
        }

        if(JSbSmgIsCreatePage()){
            // Smg Code
            $("#oetSmgCode").attr("disabled", true);
            $('#ocbSlipmessageAutoGenCode').change(function(){
                if($('#ocbSlipmessageAutoGenCode').is(':checked')) {
                    $('#oetSmgCode').val('');
                    $("#oetSmgCode").attr("disabled", true);
                    $('#odvSlipmessageCodeForm').removeClass('has-error');
                    $('#odvSlipmessageCodeForm em').remove();
                }else{
                    $("#oetSmgCode").attr("disabled", false);
                }
            });
            JSxSmgVisibleComponent('#odvSlipmessageAutoGenCode', true);
        }

        if(JSbSmgIsUpdatePage()){
            // Sale Person Code
            $("#oetSmgCode").attr("readonly", true);
            $('#odvSlipmessageAutoGenCode input').attr('disabled', true);
            JSxSmgVisibleComponent('#odvSlipmessageAutoGenCode', false);    
        }

        $('#oetSmgCode').blur(function(){
            JSxCheckSmgCodeDupInDB();
        });

    });

    
    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckSmgCodeDupInDB(){
        if(!$('#ocbSlipmessageAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMSlipMsgHD_L",
                    tFieldName: "FTSmgCode",
                    tCode: $("#oetSmgCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateSmgCode").val(aResult["rtCode"]);
                    JSxSmgSetValidEventBlur();
                    $('#ofmAddSlipMessage').submit();
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
    function JSxSmgSetValidEventBlur(){
        $('#ofmAddSlipMessage').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateSmgCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddSlipMessage').validate({
            rules: {
                oetSmgCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbSlipmessageAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                oetSmgTitle:     {"required" :{}},
                // ocmRcnGroup:    {"required" :{}},
            },
            messages: {
                oetSmgCode : {
                    "required"      : $('#oetSmgCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetSmgCode').attr('data-validate-dublicateCode')
                },
                oetSmgTitle : {
                    "required"      : $('#oetSmgTitle').attr('data-validate-required'),
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

    $('#obtSMGUsrBrowseAgency').on('click',function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oUsrAgnOption       = undefined;
                oUsrAgnOption              = oUsrBrowseAgency({
                    'tReturnInputCode'          : 'oetSMGUsrAgnCode',
                    'tReturnInputName'          : 'oetSMGUsrAgnName',
                    'aArgReturn'                : ['FTAgnCode','FTAgnName']
                });
                JCNxBrowseData('oUsrAgnOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });


        // เบาวน์  ข้อความพิเศษ
        $('#obtSMGBrowseSpecialM').click(function(){JCNxBrowseData('oBrowseSpecialM')});
    var oBrowseSpecialM = {
        Title   : ['pos/slipMessage/slipmessage','tSMGSpecialMessage'],
        Table   : {Master:'TCNMMsgHD',PK:'FTMshCode'},
        Join    : {
                   Table:	['TCNMMsgHD_L'],
                   On:[' TCNMMsgHD.FTMshCode = TCNMMsgHD_L.FTMshCode '] //+ tJoinBranch + tJoinShop
                  },
        GrideView:{
            ColumnPathLang	: 'pos/slipMessage/slipmessage',
            ColumnKeyLang	: ['tSMGSpecialMsCode','tSMGSpecialMessage'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMMsgHD.FTMshCode','TCNMMsgHD_L.FTMshName'],
            DataColumnsFormat : ['',''],
            Perpage			: 10,
            OrderBy			: ['TCNMMsgHD.FTMshCode DESC'],
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetSMGSpecialCode","TCNMMsgHD.FTMshCode"],
            Text		: ["oetSmgSpecialName","TCNMMsgHD_L.FTMshName"],
        }
    }




        var nLangEdits = "<?php echo $this->session->userdata("tLangEdit")?>";
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