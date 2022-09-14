<script type="text/javascript">
$(document).ready(() => {

    var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
        if( tUsrLevel != "HQ" ){
            //BCH - SHP
            var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
            if(tBchCount < 2){
                $('#oimCstBrowseCardBch').attr('disabled',true);
            }
        }


    $('#oimCstBrowseCardBch').click(function(){
        // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
        // Create By Witsarut 04/10/2019
        JCNxBrowseData('oCstBrowseCardBch');

     
    });
});

// Set Lang Edit 
var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;
// Option Reference
var tUsrLevel = "<?=$this->session->userdata('tSesUsrLevel')?>";
var tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
var tSQLWhere = "";
    if(tUsrLevel != "HQ"){
        tSQLWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
    }
var oCstBrowseCardBch = {
	Title : ['company/branch/branch', 'tBCHTitle'],
	Table:{Master:'TCNMBranch', PK:'FTBchCode'},
	Join :{
		Table: ['TCNMBranch_L'],
		On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
	},
	Where :{
        Condition : [tSQLWhere]
	},
	GrideView:{
		ColumnPathLang	: 'company/branch/branch',
		ColumnKeyLang	: ['tBCHCode', 'tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
		DataColumnsFormat : ['', ''],
		Perpage			: 10,
		OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetCstCardBchCode", "TCNMBranch.FTBchCode"],
		Text		: ["oetCstCardBchName", "TCNMBranch_L.FTBchName"]
	},
	RouteFrom : 'customer',
	RouteAddNew : 'branch',
	BrowseLev : nStaCstBrowseType
};

/**
 * Functionality : (event) Add/Edit Customer Card Info
 * Parameters : ptRoute is route to add customer data.
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnCSTAddEditCustomerCardInfo(ptRoute){
        $('#ofmAddCustomerContact').validate().destroy();
        $('#ofmAddCustomerCardInfo').validate({
            focusInvalid: false,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                'oetCstCardNo'   : {"required" :{}},
            },
            messages: {
                oetCstCardNo   :{
                    "required"  : $('#oetCstCardNo').attr('data-validate'),
                },
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
                console.log("CardInfo Validate Complete.");
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddCustomerCardInfo').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        // console.log(tResult);
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
}

/**
* Functionality : Action After Cancel Button
* Parameters : -
* Creator : 13/11/2018 Witsarut (Bell)
* Last Modified : -
* Return : -
* Return Type : -
*/
// function JSnCSTCancelCustomerCardInfo(){
//     try{
//         JSxCSTVisibleComponent('#xWContactFormContainer', false); // Hide Form Section
//         JSxCSTVisibleComponent('#xWContactAdd', true); // Show Add Button
//         JSxCSTVisibleComponent('#ostDataCustomerContactInfo', true); // Show Data Table
//         JSxCSTVisibleComponent('#obtSubSave', false); // Hide Sub Save
//         JSxCSTVisibleComponent('#obtSubCancel', false); // Hide Sub Cancel
//     }catch(err){
//         console.log('JSnCSTCancelCustomerCardInfo Error: ', err);
//     }
// }
</script>
