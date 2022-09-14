
//Conotrol Hide and Show Button
$( document ).ready(function() {
    // ID for Close ButtonMain
    $('#odvBtnPdtAddEdit').hide();
});


//Functionality : Event Add/Edit PdtDrug
//Parameters : From Submit
//Creator : 14/10/2018 witsarut
//Return : Status Event Add/Edit PdtDrug
//Return Type : object
function JSxDrugSaveAddEdit(ptRoute){

    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        $('.xWPdtDrugDetailTab').each(function(){
            $(this).find('.xCNPdtDrug').removeClass("active in").addClass("active in");
        });

        $('#ofmAddEditDrug').validate().destroy();
        $('#ofmAddEditDrug').validate({
            focusInvalid: true,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetDrugRegis            : {"required" :{}},
                oetGenericName          : {"required" :{}},
                oetDrugBrand            : {"required" :{}},
                oetDrugType             : {"required" :{}},
                oetDrugExpirePeriod     : {
                    "required" : true,
                    "number"   : true,
                },
                oetDoseMaximum          : {
                    "required" : true,
                    "number"   : true,
                },
                oetMaxintake            : {
                    "required" : true,
                    "number"   : true,
                },
            },
            messages: {
                oetDrugRegis : {
                    "required"  : $('#oetDrugRegis').attr('data-validate-required'),
                },
                oetGenericName : {
                    "required"  : $('#oetGenericName').attr('data-validate-required'),
                },
                oetDrugBrand : {
                    "required"  : $('#oetDrugBrand').attr('data-validate-required'),
                },
                oetDrugType : {
                    "required" : $('#oetDrugType').attr('data-validate-required'),
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

                let tID = $(element).attr('id');
                if( tID == 'oetMaximum' || tID == 'oetMaxintake' ){
                    $('.xWPdtDrugDetailTab').each(function(){
                        $(this).find('.xCNPdtDrug').removeClass('active in');
                    });
                    $('.xWPdtDrugHeadTab').each(function(){
                        $(this).find('.xWMenu').removeClass('active');
                    });
                    $('#odvPdtHowtouse').addClass('active in');
                    $('#oliPdtHowtouse').addClass('active');
                }

            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
            },
            submitHandler: function(form){
                JCNxOpenLoading();
                $.ajax({
                    type : "POST",
                    url: ptRoute,
                    data: $('#ofmAddEditDrug').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult){
                        var aData = JSON.parse(tResult);
                        if(aData['nStaEvent'] == 1){
                            JSxPdtGetContent();
                        }else{
                            JSxDrugSaveAddEdit(ptRoute);
                            $('#ofmAddEditDrug').submit();
                        }
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                })
            },
        });
    }  
    
} 