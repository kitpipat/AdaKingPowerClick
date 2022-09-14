<script type="text/javascript">
$(document).ready(() => {
    $('#oimCstBrowseShipVia').click(function(){JCNxBrowseData('oBchBrowseShipVia');});
});

// Set Lang Edit 
var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;
// Option Reference
var oBchBrowseShipVia = {
	Title : ['shipvia/shipvia/shipvia', 'tVIATitle'],
	Table:{Master:'TCNMShipVia', PK:'FTViaCode'},
	Join :{
		Table: ['TCNMShipVia_L'],
		On: ['TCNMShipVia_L.FTViaCode = TCNMShipVia.FTViaCode AND TCNMShipVia_L.FNLngID = '+nLangEdits]
	},
	Where :{
        // Condition : ["AND TCNMShipVia.FTWahStaType = '3' "]
	},
	GrideView:{
		ColumnPathLang	: 'shipvia/shipvia/shipvia',
		ColumnKeyLang	: ['tVIACode', 'tVIAName'],
		ColumnsSize     : ['15%','85%'],
        WidthModal      : 20,
		DataColumns		: ['TCNMShipVia.FTViaCode', 'TCNMShipVia_L.FTViaName'],
		DataColumnsFormat : ['', ''],
		Perpage			: 10,
		OrderBy			: ['TCNMShipVia.FDCreateOn DESC'],
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetCstShipViaCode", "TCNMShipVia.FTViaCode"],
		Text		: ["oetCstShipViaName", "TCNMShipVia_L.FTViaName"]
    },
    // DebugSQL : true,
	// RouteFrom : 'customer',
	RouteAddNew : 'shipvia',
	BrowseLev : nStaCstBrowseType
};

/**
 * Functionality : (event) Add/Edit Customer Credit
 * Parameters : ptRoute is route to add customer data.
 * Creator : 27/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnCSTAddEditCustomerCredit(ptRoute){
    try{
        $('#ofmAddCustomerCredit').validate().destroy();
        $('#ofmAddCustomerCredit').validate({
            focusInvalid: false,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                'oetCstCreditTerm'     : {"required" :{}},
                'oetCstCreditLimit'    : {"required" :{}},
                'oetCstViaTime'        : {"required" :{}},
            },
            messages: {
                oetCstCreditTerm   :{
                    "required"  : $('#oetCstCreditTerm').attr('data-validate'),
                },
                oetCstCreditLimit  :{
                    "required"  : $('#oetCstCreditLimit').attr('data-validate')
                },

                oetCstViaTime      : {
                    "required"  : $('#oetCstViaTime').attr('data-validate'),
                } 

            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
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
                console.log("Credit Validate Complete.");
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddCustomerCredit').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        /*if (nStaCstBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCSTCallPageCustomerEdit(aReturn['tCodeReturn'])
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCSTCallPageCustomerAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCSTCallPageCustomer();
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxBrowseData(tCallCstBackOption);
                        }*/
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
        $('.xWSmgDyForm').each(function () {
            $(this).rules("add", {
                required: true
            });
        });
    }catch(err){
        console.log('JSnCSTAddEditCustomerCredit Error: ', err);
    }
} 
</script>
