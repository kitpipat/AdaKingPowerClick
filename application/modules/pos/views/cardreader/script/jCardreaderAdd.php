<script type="text/javascript">
 $(document).ready(function(){
    $('.selectpicker').selectpicker();
    if(JSbEdcIsCreatePage()){
        $("#oetEdcCode").attr("disabled", true);
        $('#ocbEdcAutoGenCode').change(function(){
            if($('#ocbEdcAutoGenCode').is(':checked')) {
                $('#oetEdcCode').val('');
                $("#oetEdcCode").attr("disabled", true);
                $('#odvEdcCodeForm').removeClass('has-error');
                $('#odvEdcCodeForm em').remove();
            }else{
                $("#oetEdcCode").attr("disabled", false);
            }
        });
        JSxEdcVisibleComponent('#odvEdcAutoGenCode', true);
    }
    
    if(JSbEdcIsUpdatePage()){
  
        // Agency Code
        $("#oeteEdcCode").attr("readonly", true);
        $('#odvEdcAutoGenCode input').attr('disabled', true);
        JSxEdcVisibleComponent('#odvEdcAutoGenCode', false);    

        }
    });
    $('#oetEdcCode').blur(function(){
        JSxCheckEdcCodeDupInDB();
    });


    //Functionality : Event Check Agency
    //Parameters : Event Blur Input Agency Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Update : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckEdcCodeDupInDB(){
        if(!$('#ocbEdcAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMEdc",
                    tFieldName: "FTEdcCode",
                    tCode: $("#oetEdcCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateAgnCode").val(aResult["rtCode"]);  
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateAgnCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddEdc').validate({
                    rules: {
                        oeteEdcCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbEdcAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                       
                            oetEdcName  : {"required" :{}},
                            oetBnkName  : {"required" :{}},
                        },
                        messages: {
                            oetEdcCode : {
                                "required"      : $('#oetEdcCode').attr('data-validate-required'),
                                "dublicateCode" : $('#oetEdcCode').attr('data-validate-dublicateCode')
                            },
                            oetEdcName : {
                                "required"      : $('#oetEdcName').attr('data-validate-required'),
                                "dublicateCode" : $('#oetEdcName').attr('data-validate-dublicateCode')
                            },
                            oetBnkName : {
                                "required"      : $('#oetBnkName').attr('data-validate-required'),
                                "dublicateCode" : $('#oetBnkName').attr('data-validate-dublicateCode')
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
                $('#ofmAddEdc').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }    
    }



$('#oimBrowseEdc').click(function(){JCNxBrowseData('oBrowseEdc');});
$('#oimBrowsebank').click(function(){JCNxBrowseData('oBrowseBnk');});

var oBrowseEdc = {
        FormName : "Edc",
        AddNewRouteName : "Edc",
        Title : ['pos/salemachine/salemachine','tPOSModelEDCName'],
        Table:{Master:'TSysEdc',PK:'FTSedCode'},
        GrideView:{
            ColumnPathLang	: 'pos/salemachine/salemachine',
            ColumnKeyLang	: ['tPOSCodeDevice','tPOSModelEDC'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TSysEdc.FTSedCode','TSysEdc.FTSedModel'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TSysEdc.FTSedCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetEdcCodeBrowse","TSysEdc.FTSedCode"],
            Text		: ["oetEdcName","TSysEdc.FTSedModel"],
        },
        RouteAddNew : 'Edc',
	    BrowseLev : 1
    }

    //Set Lang Edit 
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;
    var oBrowseBnk = {
        FormName : "Bank",
        AddNewRouteName : "Bank",
        Title : ['bank/bank/bank','tBNKTitle'],
        Table:{Master:'TFNMBank',PK:'FTBnkCode'},
        Join :{
		Table:	['TFNMBank_L'],
		On:['TFNMBank_L.FTBnkCode = TFNMBank.FTBnkCode AND TFNMBank_L.FNLngID = '+nLangEdits ,]
	    },
        GrideView:{
            ColumnPathLang	: 'bank/bank/bank',
            ColumnKeyLang	: ['tBNKCode','tBNKName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TFNMBank.FTBnkCode','TFNMBank_L.FTBnkName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TFNMBank.FTBnkCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetBnkCode","TFNMBank.FTBnkCode"],
            Text		: ["oetBnkName","TFNMBank_L.FTBnkName"],
        },
        RouteAddNew : 'Bank',
	    BrowseLev : 1

    }

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 17/07/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbEdcIsCreatePage(){
    try{
        const tEdcCode = $('#oetEdcCode').data('is-created');    
        var bStatus = false;
        if(tEdcCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbEdcIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 17/07/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbEdcIsUpdatePage(){
    try{
        const tEdcCode = $('#oetEdcCode').data('is-created');
        var bStatus = false;
        if(!tEdcCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbEdcIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator: 17/07/2019 saharat(Golf)
// Return : -
// Return Type : -
function JSxEdcVisibleComponent(ptComponent, pbVisible, ptEffect){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){

            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    }catch(err){
        console.log('JSxEdcVisibleComponent Error: ', err);
    }
}


//Functionality : Add Data Agency Add/Edit  
//Parameters : from ofmAddAgn
//Creator : 10/06/2019 saharat(Golf)
//Return : View
//Return Type : View
function JSnAddEditEdc(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddEdc').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "EdcEventAdd"){
                if($("#ohdCheckDuplicateEdcCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');
        $('#ofmAddEdc').validate({
            rules: {
                oetEdcCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "EdcEventAdd"){
                                if($('#ocbEdcAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },   

                oetEdcName  : {"required" :{}},
                oetBnkName  : {"required" :{}},
            },
            messages: {
                oetEdcCode : {
                    "required"      : $('#oetEdcCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetEdcCode').attr('data-validate-dublicateCode')
                },
                oetEdcName : {
                    "required"      : $('#oetEdcName').attr('data-validate-required'),
                    "dublicateCode" : $('#oetEdcName').attr('data-validate-dublicateCode')
                },
                oetBnkName : {
                    "required"      : $('#oetBnkName').attr('data-validate-required'),
                    "dublicateCode" : $('#oetBnkName').attr('data-validate-dublicateCode')
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
            highlight: function(element, errorClass, validClass) {
                $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function(element, errorClass, validClass) {
                $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
            },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmAddEdc').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                //   console.log(tResult);
                  JCNxBrowseData('oCmpBrowsePortEDC');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }
}



</script>