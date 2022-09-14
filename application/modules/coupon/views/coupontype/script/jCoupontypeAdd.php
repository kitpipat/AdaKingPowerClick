<script type="text/javascript">
    $(document).ready(function(){
        var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';
        if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
            $('#obtCPTUsrBrowseAgency').attr("disabled", true);
            // $('#oimBrowseBranch').attr("disabled", true);
        }else{
            $('#obtCPTUsrBrowseAgency').attr("disabled", false);
        }

        if(JSbCoupontypeIsCreatePage()){
            // Coupontype Code
            $("#oetCptCode").attr("disabled", true);
            $('#ocbCoupontypeAutoGenCode').change(function(){
                if($('#ocbCoupontypeAutoGenCode').is(':checked')) {
                    $('#oetCptCode').val('');
                    $("#oetCptCode").attr("disabled", true);
                    $('#odvCoupontypeCodeForm').removeClass('has-error');
                    $('#odvCoupontypeCodeForm em').remove();
                }else{
                    $("#oetCptCode").attr("disabled", false);
                }
            });
            JSxCoupontypeVisibleComponent('#odvCoupontypeAutoGenCode', true);
        }
        
        if(JSbCoupontypeIsUpdatePage()){
            // Department Code
            $("#oetCptCode").attr("readonly", true);
            $('#odvCoupontypeAutoGenCode input').attr('disabled', true);
            JSxCoupontypeVisibleComponent('#odvCoupontypeAutoGenCode', false);    
        }
    });

    $('#oetCptCode').blur(function(){
        JSxCheckDepartmentCodeDupInDB();
    });

    //Functionality : Event Check CouponType
    //Parameters : Event Blur Input CouponType Code
    //Creator : 02/05/2019 saharat (golf)
    //Return : -
    //Return Type : -
    function JSxCheckDepartmentCodeDupInDB(){ 
        if(!$('#ocbCoupontypeAutoGenCode').is(':checked')){

            $.ajax({
            type: "POST",
            url: "CheckInputGenCode",
            data: { 
                    tTableName: "TFNMCouponType",
                    tFieldName: "FTCptCode",
                    tCode: $("#oetCptCode").val()
                },
            cache: false,
            timeout: 0,
            success: function(tResult){
                var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCptCode").val(aResult["rtCode"]);
                        // Set Validate Dublicate Code
            $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdCheckDuplicateCptCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            },'');
            // From Summit Validate
            $('#ofmAddCoupontype').validate({
                rules: {
                    oetCptCode : {
                        "required" :{
                            // ตรวจสอบเงื่อนไข validate
                            depends: function(oElement) {
                            if($('#ocbCoupontypeAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                            }
                        },
                        "dublicateCode" :{}
                    },
                    oetCptName:     {"required" :{}},
                },
                messages: {
                    oetCptCode : {
                        "required"      : $('#oetCptCode').attr('data-validate-required'),
                        "dublicateCode" : $('#oetCptCode').attr('data-validate-dublicateCode')
                    },
                    oetCptName : {
                        "required"      : $('#oetCptName').attr('data-validate-required'),
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
            $('#ofmAddCoupontype').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }    
    }

    $('#obtCPTUsrBrowseAgency').on('click',function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oUsrAgnOption       = undefined;
                oUsrAgnOption              = oUsrBrowseAgency({
                    'tReturnInputCode'          : 'oetCPTUsrAgnCode',
                    'tReturnInputName'          : 'oetCPTUsrAgnName',
                    'aArgReturn'                : ['FTAgnCode','FTAgnName']
                });
                JCNxBrowseData('oUsrAgnOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        //Browse AD
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