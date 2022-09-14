<script type="text/javascript">
    
$(document).ready(() => {
    JSvCustomerContactDataTable();
    JSxCSTVisibleComponent('#obtSubSave', false); // Hide Sub Save
    JSxCSTVisibleComponent('#obtSubCancel', false); // Hide Sub Cancel
    
    $('#oimCstCtrBrowseZone').click(function(){
        // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
        // Create By Witsarut 04/10/2019
        JCNxBrowseData('oCstCtrBrowseZone');
    });
    $('#oimCstCtrBrowsePvn').click(function(){
        // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
        // Create By Witsarut 04/10/2019
        JCNxBrowseData('oCstCtrBrowsePvn');
    });

    $('#oimCstCtrBrowseDst').click(function(){
        console.log('Ref Code: ', JSxCSTCtrGetLocationRef("province"));
        window.oCstCtrBrowseDstOption = oCstCtrBrowseDst(JSxCSTCtrGetLocationRef("province"));
            // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
        JCNxBrowseData('oCstCtrBrowseDstOption');
    });
    $('#oimCstCtrBrowseSubDist').click(function(){
        console.log('SubRef Code: ', JSxCSTCtrGetLocationRef("district"));
        window.oCstCtrBrowseSubDistOption = oCstCtrBrowseSubDist(JSxCSTCtrGetLocationRef("district"));
        // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
        // Create By Witsarut 04/10/2019
        JCNxBrowseData('oCstCtrBrowseSubDistOption');
    });
    
    JSxCSTCtrEnabledLocation('district', false); // Disabled District Input Field
    JSxCSTCtrEnabledLocation('subdistrict', false); // Disabled Subdistrict Input Field
});

// Set Lang Edit 
var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;
// Option Reference

var oCstCtrBrowseZone = {
	Title : ['address/zone/zone', 'tZNETitle'],
	Table:{Master:'TCNMZone', PK:'FTZneCode'},
	Join :{
		Table: ['TCNMZone_L'],
		On: ['TCNMZone_L.FTZneCode = TCNMZone.FTZneCode AND TCNMZone_L.FNLngID = '+nLangEdits]
	},
	Where :{
        // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
	},
	GrideView:{
		ColumnPathLang	: 'address/zone/zone',
		ColumnKeyLang	: ['tZNECode', '', 'tZNEName'],
		ColumnsSize     : ['15%', '85%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMZone.FTZneCode', 'TCNMZone_L.FTZneName', 'TCNMZone.FTAreCode'],
        DisabledColumns	:[1],
		DataColumnsFormat : ['', ''],
		Perpage			: 5,
		OrderBy			: ['TCNMZone_L.FTZneName'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetCstContactZoneCode", "TCNMZone.FTZneCode"],
		Text		: ["oetCstContactZoneName", "TCNMZone_L.FTZneName"]
	},
    NextFunc:{
        FuncName:'JSxCSTCtrSetAreaCode',
        ArgReturn:['FTAreCode']
    },
	// RouteFrom : 'customer',
	RouteAddNew : 'zone',
	BrowseLev : nStaCstBrowseType
};

var oCstCtrBrowsePvn = {
	Title : ['address/province/province', 'tPVNTitle'],
	Table:{Master:'TCNMProvince', PK:'FTPvnCode'},
	Join :{
		Table: ['TCNMProvince_L'],
		On: ['TCNMProvince_L.FTPvnCode = TCNMProvince.FTPvnCode AND TCNMProvince_L.FNLngID = '+nLangEdits]
	},
	Where :{
        // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
	},
	GrideView:{
		ColumnPathLang	: 'address/province/province',
		ColumnKeyLang	: ['tPVNTBCode', 'tPVNTBName'],
		ColumnsSize     : ['15%', '85%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMProvince.FTPvnCode', 'TCNMProvince_L.FTPvnName'],
		DataColumnsFormat : ['', ''],
		Perpage			: 5,
		OrderBy			: ['TCNMProvince_L.FTPvnName'],//TCNMProvince_L.FTShpName
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetCstContactPvnCode", "TCNMProvince.FTPvnCode"],
		Text		: ["oetCstContactPvnName", "TCNMProvince_L.FTPvnName"]
	},
	// RouteFrom : 'customer',
	RouteAddNew : 'province',
	BrowseLev : nStaCstBrowseType
};

var oCstCtrBrowseDst = function (pRefCode){
    let oOptions = {
        Title : ['address/district/district', 'tDSTTitle'],
        Table:{Master:'TCNMDistrict', PK:'FTDstCode'},
        Join :{
            Table: ['TCNMDistrict_L'],
            On: ['TCNMDistrict_L.FTDstCode = TCNMDistrict.FTDstCode AND TCNMDistrict_L.FNLngID = '+nLangEdits]
        },
        Where :{
            Condition : ["AND TCNMDistrict.FTPvnCode = " + pRefCode + " "]
        },
        GrideView:{
            ColumnPathLang	: 'address/district/district',
            ColumnKeyLang	: ['tDSTTBCode', 'tDSTTBName'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMDistrict.FTDstCode', 'TCNMDistrict_L.FTDstName', 'TCNMDistrict.FTDstPost'],
            DisabledColumns	:[2],
            DataColumnsFormat : ['', ''],
            Perpage			: 5,
            OrderBy			: ['TCNMDistrict_L.FTDstName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetCstContactDstCode", "TCNMDistrict.FTDstCode"],
            Text		: ["oetCstContactDstName", "TCNMDistrict_L.FTDstName"]
        },
        NextFunc:{
            FuncName:'JSxCSTCtrSetPostCode',
            ArgReturn:['FTDstPost']
        },
        // RouteFrom : 'customer',
        RouteAddNew : 'district',
        BrowseLev : nStaCstBrowseType
        // DebugSQL : true
    };
    
    return oOptions;
};

var oCstCtrBrowseSubDist = function (pRefCode){
    let oOptions = {
        Title : ['address/subdistrict/subdistrict', 'tSDTTitle'],
        Table:{Master:'TCNMSubDistrict', PK:'FTSudCode'},
        Join :{
            Table: ['TCNMSubDistrict_L'],
            On: ['TCNMSubDistrict_L.FTSudCode = TCNMSubDistrict.FTSudCode AND TCNMSubDistrict_L.FNLngID = '+nLangEdits]
        },
        Where :{
            Condition : ["AND TCNMSubDistrict.FTDstCode = " + pRefCode + " "]
        },
        GrideView:{
            ColumnPathLang	: 'address/subdistrict/subdistrict',
            ColumnKeyLang	: ['tSDTTBCode', 'tSDTTBSubdistrict'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMSubDistrict.FTSudCode', 'TCNMSubDistrict_L.FTSudName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 5,
            OrderBy			: ['TCNMSubDistrict_L.FTSudName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetCstContactSubDistCode", "TCNMSubDistrict.FTSudCode"],
            Text		: ["oetCstContactSubDistName", "TCNMSubDistrict_L.FTSudName"]
        },
        // RouteFrom : 'customer',
        RouteAddNew : 'subdistrict',
        BrowseLev : nStaCstBrowseType
    };
    return oOptions;
};

/**
* Functionality : Add or Edit Customer Contact
* Parameters : -
* Creator : 26/09/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSnCSTAddEditCustomerContact(ptRoute){

    $('#ofmAddCustomerContact').validate().destroy();
    $('#ofmAddCustomerContact').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            'oetCstContactName'     : {"required" :{}},
            'oetCstContactEmail'    : {"required" :{}},
            'oetCstContactTel'      : {"required" :{}},
            'oetCstContactFax'      : {"required" :{}},
        },
        messages: {
            oetCstContactName   :{
                "required"  : $('#oetCstContactName').attr('data-validate'),
            },
            oetCstContactEmail   :{
                "required"  : $('#oetCstContactEmail').attr('data-validate'),
            },
            oetCstContactTel   :{
                "required"  : $('#oetCstContactTel').attr('data-validate'),
            },
            oetCstContactFax   :{
                "required"  : $('#oetCstContactFax').attr('data-validate'),
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
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "customerEventAddUpdateContact",
                data: $('#ofmAddCustomerContact').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    JSvCustomerContactDataTable();
                    JSxCSTCtrResetContactForm();
                    JSxCSTVisibleComponent('#xWContactFormContainer', false); // Hide Form Section
                    JSxCSTVisibleComponent('#xWContactAdd', true); // Show Add Button
                    JSxCSTVisibleComponent('#ostDataCustomerContactInfo', true); // Show Data Table
                    JSxCSTVisibleComponent('#obtSubSave', false); // Hide Sub Save
                    JSxCSTVisibleComponent('#obtSubCancel', false); // Hide Sub Save
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        },
    });
}

/**
* Functionality : Clear Contact Form Value
* Parameters : -
* Creator : 28/09/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCSTCtrResetContactForm(){
    try{
        let aFields_1 = ["Name", "Email", "Tel"];
        $.each(aFields_1, (nIndex, tVal) => {
            $("#oetCstContact" + tVal).val("");
        });
        
        let aFields_2 = ["Fax", "Rmk", "Seq"];
        $.each(aFields_2, (nIndex, tVal) => {
            if(tVal == "Rmk"){
                $('#otaCstContact' + tVal).text("");
            }
            if(tVal == "Fax"){
                $('#oetCstContact' + tVal).val("");
            }
            if(tVal == "Seq"){
                $('#ohdCstContact' + tVal).val("");
            }
        });
        
        let aFields_3 = [
            {type:"text", field:"No"}, 
            {type:"text", field:"Soi"}, 
            {type:"text", field:"Village"}, 
            {type:"text", field:"Road"}, 
            {type:"text", field:"Country"}, 
            {type:"text", field:"ZoneCode"}, 
            {type:"text", field:"ZoneName"}, 
            {type:"text", field:"AreaCode"}, 
            {type:"text", field:"PvnCode"},
            {type:"text", field:"PvnName"},
            {type:"text", field:"DstCode"},
            {type:"text", field:"DstName"},
            {type:"text", field:"SubDistCode"},
            {type:"text", field:"SubDistName"},
            {type:"text", field:"PostCode"},
            {type:"text", field:"Website"},
            {type:"textArea", field:"Desc1"},
            {type:"textArea", field:"Desc2"},
            {type:"text", field:"PvnCode"},
            {type:"text", field:"PvnCode"},
            {type:"text", field:"PvnCode"}
        ];
        $.each(aFields_3, (nIndex, tVal) => {
            if(tVal.type == "textArea"){
                $('#otaCstContact' + tVal.field).html("");
            }
            if(tVal.type == "text"){
                $('#oetCstContact' + tVal.field).val("");
            }
        });
        
        let aFields_4 = ["Longitude", "Latitude"];
        $.each(aFields_4, (nIndex, tVal) => {
            $('#ohdCstContact' + tVal).val("");
        });
    }catch(err){
        console.log("JSxCSTCtrResetContactForm Error: ", err);
    }
}

/**
* Functionality : Set Data Contact Form Value
* Parameters : -
* Creator : 28/09/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCSTCtrSetDataContactForm(poElement){
    try{
        let aFields_1 = ["Name", "Email", "Tel"];
        $.each(aFields_1, (nIndex, tVal) => {
            let tFieldVal = $(poElement).parents(".otrContact").find(".xWCtr" + tVal).text();
            $("#oetCstContact" + tVal).val(tFieldVal);
        });
        
        let aFields_2 = ["Fax", "Rmk", "Seq"];
        $.each(aFields_2, (nIndex, tVal) => {
            let tFieldVal = $(poElement).parents(".otrContact").find(".xWCtr" + tVal).val();
            if(tVal == "Rmk"){
                $('#otaCstContact' + tVal).text(tFieldVal);
            }
            if(tVal == "Fax"){
                $('#oetCstContact' + tVal).val(tFieldVal);
            }
            if(tVal == "Seq"){
                $('#ohdCstContact' + tVal).val(tFieldVal);
            }
        });
        
        let aFields_3 = [
            {type:"text", field:"No"}, 
            {type:"text", field:"Soi"}, 
            {type:"text", field:"Village"}, 
            {type:"text", field:"Road"}, 
            {type:"text", field:"Country"}, 
            {type:"text", field:"ZoneCode"}, 
            {type:"text", field:"ZoneName"}, 
            {type:"text", field:"AreaCode"}, 
            {type:"text", field:"PvnCode"},
            {type:"text", field:"PvnName"},
            {type:"text", field:"DstCode"},
            {type:"text", field:"DstName"},
            {type:"text", field:"SubDistCode"},
            {type:"text", field:"SubDistName"},
            {type:"text", field:"PostCode"},
            {type:"text", field:"Website"},
            {type:"textArea", field:"Desc1"},
            {type:"textArea", field:"Desc2"},
            {type:"text", field:"PvnCode"},
            {type:"text", field:"PvnCode"},
            {type:"text", field:"PvnCode"}
        ];
        $.each(aFields_3, (nIndex, tVal) => {
            let tFieldVal = $(poElement).parents(".otrContact").find(".xWCtr" + tVal.field).val();
            if(tVal.type == "textArea"){
                $('#otaCstContact' + tVal.field).text(tFieldVal);
            }
            if(tVal.type == "text"){
                console.log('#oetCstContact' + tVal.field);
                console.log("Get Val: ", tFieldVal);
                $('#oetCstContact' + tVal.field).val(tFieldVal);
            }
        });
        
        let aFields_4 = ["Longitude", "Latitude"];
        $.each(aFields_4, (nIndex, tVal) => {
            let tFieldVal = $(poElement).parents(".otrContact").find(".xWCtr" + tVal).val();
            $('#ohdCstContact' + tVal).val(tFieldVal);
        });
    }catch(err){
        console.log('JSxCSTCtrResetContactForm Error: ', err);
    }
}

/**
* Functionality : Action After Cancel Button
* Parameters : -
* Creator : 28/09/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSnCSTCancelCustomerContact(){
    try{
        console.log('Sub Cancel Btn');
        JSxCSTVisibleComponent('#xWContactFormContainer', false); // Hide Form Section
        JSxCSTVisibleComponent('#xWContactAdd', true); // Show Add Button
        JSxCSTVisibleComponent('#ostDataCustomerContactInfo', true); // Show Data Table
        JSxCSTVisibleComponent('#obtSubSave', false); // Hide Sub Save
        JSxCSTVisibleComponent('#obtSubCancel', false); // Hide Sub Cancel
    }catch(err){
        console.log('JSnCSTCancelCustomerContact Error: ', err);
    }
}

/**
* Functionality : Display Contact form
* Parameters : -
* Creator : 27/06/2018 piya
* Last Modified : -
* Return : {return}
* Return Type : {type}
*/
function JSxCSTCtrAddContactForm(){
    // Call Map Api
	var oCstCtrMapCustomer = {
		tDivShowMap	:'odvCstCtrMapEdit',
		cLongitude	: <?=(isset($tCstContactLongitude)&&!empty($tCstContactLongitude))? floatval($tCstContactLongitude):floatval('100.50182294100522')?>,
        cLatitude	: <?=(isset($tCstContactLatitude)&&!empty($tCstContactLatitude))? floatval($tCstContactLatitude):floatval('13.757309968845291')?>,
		tInputLong	: 'ohdCstContactLongitude',
		tInputLat	: 'ohdCstContactLatitude',
		tIcon		: "https://openlayers.org/en/v4.6.5/examples/data/icon.png",
		tStatus		: '2'	
	};
    $("#odvCstCtrMapEdit").empty();
    setTimeout(() => {
        JSxMapAddEdit(oCstCtrMapCustomer);
    }, 1000);
    JSxCSTCtrResetContactForm();
    JSxCSTVisibleComponent('#xWContactFormContainer', true); // Show Form Section
    JSxCSTVisibleComponent('#xWContactAdd', false); // Hide Add Button
    JSxCSTVisibleComponent('#ostDataCustomerContactInfo', false); // Hide Data Table
    JSxCSTVisibleComponent('#obtSubSave', true); // Show Sub Save
    JSxCSTVisibleComponent('#obtSubCancel', true); // Show Sub Save
}

/**
 * Functionality : Delete Record Before to Save.
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCSTCtrDeleteOperator(ptCtrName,ptCstCode,ptCtrSeq,tYesOnNo){
    try{
        $('#odvModalDeleteSingle').modal('show');
        $('#odvModalDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptCtrName + ' ' + tYesOnNo );
        $('#odvModalDeleteSingle #osmConfirmDelete').on('click', function(evt){
            $.ajax({
                type: "POST",
                url:  "customerEventDeleteContact",
                data: {
                     tCtrName  : ptCtrName,
                     tCstCode  : ptCstCode,
                     tCtrSeq   : ptCtrSeq
                },
                cache: false,
                success: function(tResult){
                    $('#odvModalDeleteSingle').modal('hide');
                    setTimeout(function(){
                        JSvCustomerContactDataTable();
                        JSxCSTCtrResetContactForm();
                        JSxCSTVisibleComponent('#xWContactFormContainer', false); // Hide Form Section
                        JSxCSTVisibleComponent('#xWContactAdd', true); // Show Add Button
                        JSxCSTVisibleComponent('#ostDataCustomerContactInfo', true); // Show Data Table
                        JSxCSTVisibleComponent('#obtSubSave', false); // Hide Sub Save
                        JSxCSTVisibleComponent('#obtSubCancel', false); // Hide Sub Cancel
                    },500);
                }
            });
        });

   
    }catch(err){
        console.log('JSxCSTCtrDeleteOperator Error: ', err);
    }
}
/**
 * Functionality : Edit Record Before to Save.
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCSTCtrEditOperator(poElement = null, poEvent = null){
    try{
        console.log('Contact Edit Operator');
        JSxCSTCtrResetContactForm();
        JSxCSTCtrSetDataContactForm(poElement);
        
        $("#odvCstCtrMapEdit").empty();
        setTimeout(() => {
            // Call Map Api
            var oCstCtrMapCustomer = {
                tDivShowMap	:'odvCstCtrMapEdit',
                cLongitude	: parseFloat($("#ohdCstContactLongitude").val()),
                cLatitude	: parseFloat($("#ohdCstContactLatitude").val()),
                tInputLong	: 'ohdCstContactLongitude',
                tInputLat	: 'ohdCstContactLatitude',
                tIcon		: "https://openlayers.org/en/v4.6.5/examples/data/icon.png",
                tStatus		: '2'	
            };
            JSxMapAddEdit(oCstCtrMapCustomer);
        }, 1000);
        JSxCSTVisibleComponent('#xWContactFormContainer', true); // Show Form Section
        JSxCSTVisibleComponent('#xWContactAdd', false); // Hide Add Button
        JSxCSTVisibleComponent('#ostDataCustomerContactInfo', false); // Hide Data Table
        JSxCSTVisibleComponent('#obtSubSave', true); // Show Sub Save
        JSxCSTVisibleComponent('#obtSubCancel', true); // Show Sub Save
    }catch(err){
        console.log('JSxCSTCtrEditOperator Error: ', err);
    }
}

/**
 * Functionality : Call Recive Customer Contact Infomation Data List
 * Parameters : -
 * Creator : 19/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCustomerContactDataTable(pnPage = "") {
    try{
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "customerContactDataTable",
            data: {
                tSearchAll: "",
                nPageCurrent: nPageCurrent,
                tCstCode: $('#ohdCstCode').val()
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataCustomerContactInfo').html(tResult);
                }
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCustomerContactDataTable Error: ', err);
    }
}

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 28/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCSTCtrClickPage(ptPage) {
    try{
        var nPageCurrent = '';
        switch (ptPage){
            case 'next' : //กดปุ่ม Next
                $('xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageCstContact .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1;  // +1 จำนวนเลขหน้า
                nPageCurrent = nPageNew
            break;
            case 'previous' : //กดปุ่ม Previous
                nPageOld = $('.xWPageCstContact .active').text();
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
            break;
            default:
                nPageCurrent = ptPage
        }   
        JCNxOpenLoading();
        JSvCustomerContactDataTable(nPageCurrent);
    }catch(err){
        console.log('JSvCSTClickPage Error: ', err);
    }

}

/**
* Functionality : Set Area Code
* Parameters : {params}
* Creator : 01/10/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCSTCtrSetAreaCode(poAreaCode){
    try{
        let tAreaCode = JSON.parse(poAreaCode)[0];
        console.log("Area Code: ", tAreaCode);
        $("#oetCstContactAreaCode").val(tAreaCode);
    }catch(err){
        console.log("JSxCSTCtrSetAreaCode Error: ", err);
    }
}

/**
* Functionality : Set Post Code
* Parameters : poPostCode is Area Code from oCstBrowseAddDst
* Creator : 02/10/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCSTCtrSetPostCode(poPostCode){
    try{
        let tAreaCode = JSON.parse(poPostCode)[0];
        console.log("Post Code: ", tAreaCode);
        $("#oetCstContactPostCode").val(tAreaCode);
    }catch(err){
        console.log("JSxCSTCtrSetPostCode Error: ", err);
    }
}

/**
* Functionality : Action After Change Input Field
* Parameters : poElement is Itself element, poEvent is Itself event, ptLocation is ("province", "distric", "subdistric")
* Creator : 01/09/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCSTCtrChangeLocation(poElement, poEvent, ptLocation){
    if(ptLocation == "province"){
        let tProvinceCode = $(poElement).val();
        JSxCSTCtrSetLocationRef("province", tProvinceCode); // Set Location Code
        JSxCSTCtrResetLocation('district'); // Reset District Field
        JSxCSTCtrResetLocation('subdistrict'); // Reset Subdistrict Field
        JSxCSTCtrEnabledLocation('district', true); // Enabled District Input Field
        return;
    }
    if(ptLocation == "district"){
        let tDistrictCode = $(poElement).val();
        JSxCSTCtrSetLocationRef("district", tDistrictCode); // Set Location Code
        JSxCSTCtrResetLocation('subdistrict'); // Reset Subdistrict Field
        JSxCSTCtrEnabledLocation('subdistrict', true); // Enabled Subdistrict Input Field
        return;
    }
    if(ptLocation == "subdistrict"){
        return;
    }
}

/**
* Functionality : Reset Location Input Value
* Parameters : ptLocation is ("district", "subdistrict")
* Creator : 01/10/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCSTCtrResetLocation(ptLocation){
    try{
        if(ptLocation == "district"){
            $("#oetCstContactDstCode").val("");
            $("#oetCstContactDstName").val("");
        }
        if(ptLocation == "subdistrict"){
            $("#oetCstContactSubDistCode").val("");
            $("#oetCstContactSubDistName").val("");
        }
    }catch(err){
        console.log("JSxCSTCtrResetLocation Error: ", err);
    }
}

/**
* Functionality : Set Location Code to Input Field
* Parameters : ptLocation is ("province", "district", "subdistrict"), 
* ptLocationCode is Location Reference Code
* Creator : 01/10/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCSTCtrSetLocationRef(ptLocation, ptLocationCode){
    if(ptLocation == "province"){
        $("#ohdContactProvinceRef").val(ptLocationCode);
    }
    if(ptLocation == "district"){
        $("#ohdContactDistrictRef").val(ptLocationCode);
    }
    if(ptLocation == "subdistrict"){
        $("#ohdContactSubdistrictRef").val(ptLocationCode);
    }
}

/**
* Functionality : Get Location Code from Input Field
* Parameters : ptLocationCode is Location Reference Code
* Creator : 01/10/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCSTCtrGetLocationRef(ptLocation){
    if(ptLocation == "province"){
        return $("#ohdContactProvinceRef").val();
    }
    if(ptLocation == "district"){
        return $("#ohdContactDistrictRef").val();
    }
    if(ptLocation == "subdistrict"){
        return $("#ohdContactSubdistrictRef").val();
    }
}

/**
* Functionality : Enabled or Disabled Location Input Field
* Parameters : ptLocation is ("district", "subdistrict"), pbEnabled is Enabled(true) Disabled(false)
* Creator : 01/10/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCSTCtrEnabledLocation(ptLocation, pbEnabled){
    try{
        if(ptLocation == "district"){
            if(pbEnabled == false){
                if($("#oetCstContactPvnCode").val() == ""){
                    $("#odvAddDstContainer div").addClass("xWCurNotAlw");
                    $("#odvAddDstContainer img").addClass("xWPointerEventNone");
                    $("#odvAddDstContainer span").addClass("xWPointerEventNone");
                }
            }else{
                $("#odvAddDstContainer div").removeClass("xWCurNotAlw");
                $("#odvAddDstContainer img").removeClass("xWPointerEventNone");
                $("#odvAddDstContainer span").removeClass("xWPointerEventNone");
            }
            return;
        }
        if(ptLocation == "subdistrict"){
            if(pbEnabled == false){
                if($("#oetCstContactDstCode").val() == ""){
                    $("#odvAddSubDistContainer div").addClass("xWCurNotAlw");
                    $("#odvAddSubDistContainer img").addClass("xWPointerEventNone");
                    $("#odvAddSubDistContainer span").addClass("xWPointerEventNone");
                }
            }else{
                $("#odvAddSubDistContainer div").removeClass("xWCurNotAlw");
                $("#odvAddSubDistContainer img").removeClass("xWPointerEventNone");
                $("#odvAddSubDistContainer span").removeClass("xWPointerEventNone");
            }
            return;
        }
    }catch(err){
        console.log('JSxCSTCtrEnabledLocation', err);
    }
}
</script>
