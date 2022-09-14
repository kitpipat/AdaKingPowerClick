<script type="text/javascript">
    $(document).ready(function(){

        if(JSbBdtIsCreatePage()){
            // Coupontype Code
            $("#oetBdtCode").attr("disabled", true);
            $('#ocbBdtAutoGenCode').change(function(){
                if($('#ocbBdtAutoGenCode').is(':checked')) {
                    $('#oetBdtCode').val('');
                    $("#oetBdtCode").attr("disabled", true);
                    $('#odvBdtCodeForm').removeClass('has-error');
                    $('#odvBdtCodeForm em').remove();
                }else{
                    $("#oetBdtCode").attr("disabled", false);
                }
            });
            JSxBdtVisibleComponent('#odvBdtAutoGenCode', true);
        }
        
        if(JSbBdtIsUpdatePage()){
            // Department Code
            $("#oetBdtCode").attr("readonly", true);
            $('#odvBdtAutoGenCode input').attr('disabled', true);
            JSxBdtVisibleComponent('#odvBdtAutoGenCode', false);    
        }
    });

    $('#oetBdtCode').blur(function(){
        JSxCheckDepartmentCodeDupInDB();
    });

    //Functionality : Event Check Voucher
    //Parameters : Event Blur Input Voucher Code
    //Creator : 02/05/2019 saharat (golf)
    //Return : -
    //Return Type : -
    function JSxCheckDepartmentCodeDupInDB(){
        
        if(!$('#ocbBdtAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMBnkDepType",
                    tFieldName: "FTBdtCode",
                    tCode: $("#oetBdtCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                // alert(tResult);
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateBdtCode").val(aResult["rtCode"]);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

            // Set Validate Dublicate Code
            $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdCheckDuplicateBdtCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            },'');

            // From Summit Validate
            $('#ofmAddBdt').validate({
                rules: {
                    oetBdtCode : {
                        "required" :{
                            // ตรวจสอบเงื่อนไข validate
                            depends: function(oElement) {
                            if($('#ocbBdtAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                            }
                        },
                        "dublicateCode" :{}
                    },
                    oetBdtName:     {"required" :{}},
                },
                messages: {
                    oetBdtCode : {
                        "required"      : $('#oetBdtCode').attr('data-validate-required'),
                        "dublicateCode" : $('#oetBdtCode').attr('data-validate-dublicateCode')
                    },
                    oetBdtName : {
                        "required"      : $('#oetBdtName').attr('data-validate-required'),
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
            $('#ofmAddBdt').submit();

        }    
    }

    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit")?>';
    $('#obtBDTUsrBrowseAgency').on('click',function(){
        var nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oUsrAgnOption       = undefined;
            oUsrAgnOption              = oUsrBrowseAgency({
                'tReturnInputCode'          : 'oetBDTUsrAgnCode',
                'tReturnInputName'          : 'oetBDTUsrAgnName',
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

    var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';


    if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
        $('#obtBDTUsrBrowseAgency').attr("disabled", true);
    }


</script>