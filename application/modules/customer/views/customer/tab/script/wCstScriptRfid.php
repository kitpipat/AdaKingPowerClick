<script>
$(document).ready(() => {
    
});
var bUniqueRfidCode;
$.validator.addMethod(
    "uniqueRfidCode", 
    function(tValue, oElement) {
        
        var tRfidCode = tValue;
            
        // if(JCNbCSTIsCreatePage()){
            let bStatus = true;
            // if(!JCNbCSTRfidEmptyRecord()){ // Not empty record
                let oRecord = $('#otbCstRfidContainer > tr').not('.hidden').not('#otrNoRfidData');
                
                oRecord.each((pnIndex, poElement) => {
                    let tRfidCodeVal = $(poElement).find('.xWCstRfidCode').val();
                    if(tRfidCode == tRfidCodeVal){
                        bStatus = false;
                    }
                });
                
            // }
            return bStatus;
        // }
        
        /*if(JCNbCSTIsUpdatePage()){
            $.ajax({
                type: "POST",
                url: "vatrateUniqueValidate/vatstart",
                data: "tAddVatCode=" + tAddVatCode + "&tAddVatRate=" + tAddVatRate + "&tRfidCode=" + tRfidCode,
                dataType:"html",
                success: function(ptMsg)
                {
                    // If vatrate and vat start exists, set response to true
                    bUniqueRfidCode = ( ptMsg == 'true' ) ? false : true;                
                },
                async: false
            });
            return bUniqueRfidCode;
        }*/
    },
    "RFID Code is Already Taken"
);

var bUniqueRecordRfidCode;
$.validator.addMethod(
    "uniqueRecordRfidCode", 
    function(tValue, poElement) {
        
        var tRfidCode = tValue;
            
        // if(JCNbCSTIsCreatePage()){
            let bStatus = true;
            // if(!JCNbCSTRfidEmptyRecord()){ // Not empty record
                let oRecord = $('#otbCstRfidContainer > tr').not('.hidden').not('#otrNoRfidData');
                
                oRecord.each((pnIndex, poEl) => {
                    let tRfidCodeVal = $(poEl).find('.xWCstRfidCode').val();
                    if($(poElement).attr('name') == $(poEl).find('.xWCstRfidCode').attr('name')){
                    }else{
                        if(tRfidCodeVal == tRfidCodeVal){
                            // After validate effect (invalid)
                            $(poElement).parent('.validate-input').attr('title', 'รหัสนี้ถูกใช้ไปแล้ว');
                            $(poElement).addClass('record-invalid');
                            JCNxCSTRfidVisibledOperationIcon(poElement, 'save', false); // hidden save icon
                            bStatus = false;
                        }
                    }
                });
                
            // }
            return bStatus;
        // }
    },
    "RFID Code is Already Taken"
);

/**
 * Functionality : (event) Add/Edit Customer RFID
 * Parameters : ptRoute is route to add customer data.
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnCSTAddEditCustomerRfid(ptRoute){
    try{
        console.log('Route: ', ptRoute);
        if(JCNbCSTRfidHasInvalidRecord()){
            alert('Has record invalid');
            return;
        }
        
        var tCstCode = $('#oetCstCodeRfid').val();
        var tOptionSave = localStorage.getItem('tBtnSaveStaActive');

        if((JCNbCSTRfidEmptyRecord()) && JCNbCSTIsUpdatePage()){
            console.log('Record empty and Update page');
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "customerEventDeleteRfid",
                data: "tCstCode=" + tCstCode,
                dataType:"html",
                success: function(ptMsg)
                {
                    // Save Options
                    /*if(tOptionSave == '1'){ // Save and view
                        JSvCSTCallPageCustomerEdit(tCstCode);
                    }
                    if(tOptionSave == '2'){// Save and new create
                        JSvCSTCallPageCustomereAdd();
                    }
                    if(tOptionSave == '3'){// Save and back ot list page
                        JSvCSTCallPageCustomereList();
                    }*/
                    JCNxCloseLoading();
                },
                async: false
            });
            return;
        }

        if(JCNbCSTRfidEmptyRecord()){
            return;
        }

        // Set data
        var aData = [];
        let nCountRecord = $('#otbCstRfidContainer > tr').not('.hidden').not('#otrNoRfidData');
        $.each(nCountRecord, (pnIndex, poElement) => {
            aData[pnIndex] =
                {
                    cstCode: tCstCode,
                    rfidCode: $(poElement).find('input.xWCstRfidCode').val(),
                    rfidName: $(poElement).find('input.xWCstRfidName').val()
                };
        });

        JCNxOpenLoading();

        $.ajax({
            type: "POST",
            url: "customerEventAddUpdateRfid",
            data: "tCstCode=" + tCstCode + "&tData=" + JSON.stringify(aData),
            dataType:"html",
            success: function(ptMsg)
            {
                // Save Options
                /*if(tOptionSave == '1'){ // Save and view
                    JSvCSTCallPageCustomerEdit(tCstCode);
                }
                if(tOptionSave == '2'){// Save and new create
                    JSvCSTCallPageCustomerAdd();
                }
                if(tOptionSave == '3'){// Save and back ot list page
                    JSvCSTCallPageCustomerList();
                }*/
                JCNxCloseLoading();
            },
            async: false
        });
    }catch(err){
        console.log('JSnAddEditCustomerRfid Error:', err);
    }
}

/**
 * Functionality : Validate RFID code record before save
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : {return}
 * Return Type : {type}
 */
function JSxCSTRfidCodeRecordValidate(poElement = null, poEvent = null){
    try{
        var tRfidCode = $(poElement).val();
        let oRecords = $('#otbCstRfidContainer > tr').not('.hidden').not('#otrNoRfidData');

        // Init validate effect
        if(!JCNbCSTRfidIsInvalidRow(poElement)){
            JCNxCSTRfidVisibledOperationIcon(poElement, 'save', true); // show save icon
        }
        $(poElement).removeClass('record-invalid');
        $(poElement).parent('.validate-input').attr('title', '');
        // Start validate
        oRecords.each((pnIndex, poEl) => {
            if($(poElement).attr('name') == $(poEl).find('.xWCstRfidCode').attr('name')){
            }else{
                let tRfid = $(poEl).find('.xWCstRfidCode').val();
                if(tRfidCode == tRfid){
                    // After validate effect (invalid)
                    $(poElement).parent('.validate-input').attr('title', 'รหัสนี้ถูกใช้ไปแล้ว');
                    $(poElement).addClass('record-invalid');
                    if(JCNbCSTRfidIsInvalidRow(poElement)){
                        JCNxCSTRfidVisibledOperationIcon(poElement, 'save', false); // hidden save icon
                    }
                }
            }
        });
        if(tRfidCode == ""){
            $(poElement).parent('.validate-input').attr('title', 'รหัสต้องไม่เป็นค่าว่าง');
            $(poElement).addClass('record-invalid');
            if(JCNbCSTRfidIsInvalidRow(poElement)){
                JCNxCSTRfidVisibledOperationIcon(poElement, 'save', false); // hidden save icon
            }
        }
    }catch(err){
        console.log('JSxRfidCodeRecordValidate Error: ', err);
    }
}

/**
 * Functionality : Validate RFID name record before save
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : {return}
 * Return Type : {type}
 */
function JSxCSTRfidNameRecordValidate(poElement = null, poEvent = null){
    try{
        var tRfidCode = $(poElement).val();

        // Init validate effect
        if(!JCNbCSTRfidIsInvalidRow(poElement)){
            JCNxCSTRfidVisibledOperationIcon(poElement, 'save', true); // show save icon
        }
        $(poElement).removeClass('record-invalid');
        $(poElement).parent('.validate-input').attr('title', '');
        
        if(tRfidCode == ""){
            $(poElement).parent('.validate-input').attr('title', 'ชื่อรหัสต้องไม่เป็นค่าว่าง');
            $(poElement).addClass('record-invalid');
            if(JCNbCSTRfidIsInvalidRow(poElement)){
                JCNxCSTRfidVisibledOperationIcon(poElement, 'save', false); // hidden save icon
            }
        }
        
    }catch(err){
        console.log('JSxRfidCodeRecordValidate Error: ', err);
    }
}

/**
* Functionality : Validate Form Before to Record
* Parameters : -
* Creator : 26/09/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCSTRfidFormValidate(){
    $('#ofmAddCustomerRfidForm').validate().destroy();
    $('#ofmAddCustomerRfidForm').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            'oetAddRfidCode'  : {"required" :{}},
            'oetAddRfidName'     : {"required" :{}},
        },
        messages: {
            oetAddRfidCode   :{
                "required"  : $('#oetAddRfidCode').attr('data-validate'),
            },
            oetAddRfidName   :{
                "required"  : $('#oetAddRfidName').attr('data-validate'),
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
                url: "customerEventAddUpdateRfid",
                data: {
                    ptCstCode : $('#oetCstCode').val(),
                    ptCstID   : $('#oetAddRfidCode').val(),
                    ptCrfName : $('#oetAddRfidName').val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    // $('#odvTabIdRfid').remove();
                    $('#odvTabIdRfid').html(tResult);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        },
        
    });
}

/**
 * Functionality : Add media row
 * Parameters : poForm is form
 * Creator : 06/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCSTAddRfidRow(poForm){
    try{
        // Get Value Form Field
        let tRfidCode = $(poForm.oetAddRfidCode).val();
        let tRfidName = $(poForm.oetAddRfidName).val();

        // Reset Form Field
        $(poForm.oetAddRfidCode).val('');
        $(poForm.oetAddRfidName).val('');
                
        let nIndex = JCNnCSTGetRfidMaxID();
        console.log('MaxID: ', JCNnCSTGetRfidMaxID());
        
        // Get template in wAdMessageAdd.php
        var template = $.validator.format($.trim($('#oscCstRfidTemplate').html()));
        // Add template
        $(template(++nIndex, tRfidCode, tRfidName)).prependTo("#otbCstRfidContainer");
        
        $('#otrNoRfidData').css('display', 'none');
        
    }catch(err){
        console.log('JSxAddRfidRow Error: ', err);
    }
}

/**
 * Functionality : Count row in RFID
 * Parameters : -
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : Row count
 * Return Type : number
 */
function JCNnCSTCountRfidRow(){
    try{
        let nRow = $('#otbCstRfidContainer .otrCstRfid').length;
        return nRow;
    }catch(err){
        console.log('JCNnCountRfidRow Error: ', err);
    }
}

/**
 * Functionality : Get max item id
 * Parameters : -
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : Max id number
 * Return Type : number
 */
function JCNnCSTGetRfidMaxID(){
    try{
        if(JCNnCSTCountRfidRow() <= 0){return 0;}
        let nMaxID = 0;
        let oItems = $('#otbCstRfidContainer > .otrCstRfid');
        oItems.each((pnIndex, poElement) => {
            let tElementID = $(poElement).attr('id');
            if(nMaxID < tElementID){
                nMaxID = tElementID;
            }
        });
        return nMaxID;
    }catch(err){
        console.log('JCNnCSTGetRfidMaxID Error: ', err);
    }
}

/**
 * Functionality : Delete Record Before to Save.
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCSTRfidDeleteOperator(tId,tCode,tYesOnNo){
    try{
        $('#odvModalDeleteSingle2').modal('show');
        $('#odvModalDeleteSingle2 #ospConfirmDelete2').html($('#oetTextComfirmDeleteSingle').val() + tCode + ' ' + tYesOnNo );
        $('#odvModalDeleteSingle2 #osmConfirmDelete2').on('click', function(evt){
            $.ajax({
                    type: "POST",
                    url: "customerEventDeleteRfid",
                    data: {
                        ptCstCode : tCode,
                        ptCstID   : tId
                    },
                    catch: false,
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvModalDeleteSingle2').modal('hide');
                        setTimeout(function(){
                            $('#odvTabIdRfid').html(tResult);
                        },500);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
        });
    }catch(err){
        console.log('JSxDeleteOperator Error: ', err);
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
function JSxCSTRfidEditOperator(poElement = null, poEvent = null){
    try{
        let tRecordId = $(poElement).parents('.otrCstRfid').attr('id-name');
        let oRecord = {
            tRfidCode: $(poElement).parents('.otrCstRfid').find('input.xWCstRfidCode').val(),
            tRfidName: $(poElement).parents('.otrCstRfid').find('input.xWCstRfidName').val()
        };
        // Backup Seft Record
        localStorage.setItem(tRecordId, JSON.stringify(oRecord));
        
        // Visibled icons
        JCNxCSTRfidVisibledOperationIcon(poElement, 'edit', false); // Itself hidden(edit)
        JCNxCSTRfidVisibledOperationIcon(poElement, 'cancel', true); // hidden cancel icon
        JCNxCSTRfidVisibledOperationIcon(poElement, 'save', true); // hidden save icon

        $(poElement) // Active Vatrate Field.
            .parents('.otrCstRfid')
            .find('input.xWCstRfidCode')
            .removeAttr('disabled')
            .addClass('active');

        $(poElement) // Active Vatrate Start Field.
            .parents('.otrCstRfid')
            .find('input.xWCstRfidName')
            .removeAttr('disabled')
            .addClass('active');
    }catch(err){
        console.log('JSxEditOperator Error: ', err);
    }
}

/**
 * Functionality : Cancel Edit Record Before to Save.
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCSTRfidCancelOperator(poElement = null, poEvent = null){
    try{
        var tRecordId = $(poElement).parents('.otrCstRfid').attr('id-name');

        // Restore Seft Record
        var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
        $(poElement).parents('.otrCstRfid').find('input.xWCstRfidCode').val(oBackupRecord.tRfidCode);
        $(poElement).parents('.otrCstRfid').find('input.xWCstRfidName').val(oBackupRecord.tRfidName);

        // Remove Seft Record Backup
        localStorage.removeItem(tRecordId);

        // Visibled icons
        JCNxCSTRfidVisibledOperationIcon(poElement, 'cancel', false); // Itself hidden(cancel)
        JCNxCSTRfidVisibledOperationIcon(poElement, 'save', false); // hidden save icon
        JCNxCSTRfidVisibledOperationIcon(poElement, 'edit', true); // show edit icon

        $(poElement) // Clear Active Vatrate Field.
            .parents('.otrCstRfid')
            .find('input.xWCstRfidCode')
            .attr('disabled', true)
            .removeClass('active')
            .removeClass('record-invalid');

        $(poElement) // Clear Active Vatrate Start Field.
            .parents('.otrCstRfid')
            .find('input.xWCstRfidName')
            .attr('disabled', true)
            .removeClass('active')
            .removeClass('record-invalid');
    }catch(err){
        console.log('JSxCancelOperator Error: ', err);
    }
}

/**
 * Functionality : Confirm Record Before to Save.
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCSTRfidSaveOperator(tCstID,tCstCode,tIdKey){
    try{
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "customerEventUpdateRfid",
            data: {
                ptCstCode       : tCstCode,
                ptCstID         : tCstID,
                ptEditCstID     : $('#oetRfidCode'+tIdKey).val(),
                ptEditCrfName   : $('#oetRfidName'+tIdKey).val()
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvTabIdRfid').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });


        // var tRecordId = $(poElement).parents('.otrCstRfid').attr('id-name');

        // // Remove Seft Record Backup
        // localStorage.removeItem(tRecordId);
        // // Visibled icons
        // JCNxCSTRfidVisibledOperationIcon(poElement, 'save', false); // Itself hidden(save)
        // JCNxCSTRfidVisibledOperationIcon(poElement, 'cancel', false); // hidden cancel icon
        // JCNxCSTRfidVisibledOperationIcon(poElement, 'edit', true); // show edit icon

        // $(poElement) // Clear Active Vatrate Field.
        //     .parents('.otrCstRfid')
        //     .find('input.xWCstRfidCode')
        //     .attr('disabled', true)
        //     .removeClass('active');

        // $(poElement) // Clear Active Vatrate Start Field.
        //     .parents('.otrCstRfid')
        //     .find('input.xWCstRfidName')
        //     .attr('disabled', true)
        //     .removeClass('active');
    }catch(err){
        console.log('JSxSaveOperator Error: ', err);
    }
}   
/**
 * Functionality : Visibled operation icon
 * Parameters : [poElement] is seft element in scope(<tr class="otrCstRfid">), 
 * [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JCNxCSTRfidVisibledOperationIcon(poElement, ptOperation, pbVisibled){
    try{
        switch(ptOperation){
            case 'edit' : {
                if(pbVisibled){ // show
                    $($(poElement) // Unhidden Cancel of seft group
                        .parents('.otrCstRfid')
                        .find('.xWCstRfidEdit'))
                            .removeClass('hidden');
                }else{ // hide
                    $($(poElement) // Hidden Cancel of seft group
                        .parents('.otrCstRfid')
                        .find('.xWCstRfidEdit'))
                            .addClass('hidden');
                }
                break;
            }
            case 'cancel' : {
                if(pbVisibled){ // show
                    $($(poElement) // Unhidden Cancel of seft group
                        .parents('.otrCstRfid')
                        .find('.xWCstRfidCancel'))
                            .removeClass('hidden');
                }else{ // hide
                    $($(poElement) // Hidden Cancel of seft group
                        .parents('.otrCstRfid')
                        .find('.xWCstRfidCancel'))
                            .addClass('hidden');
                }
                break;
            }
            case 'save' : {
                if(pbVisibled){ // show
                    $($(poElement) // Unhidden Cancel of seft group
                        .parents('.otrCstRfid')
                        .find('.xWCstRfidSave'))
                            .removeClass('hidden');
                }else{ // hide
                    $($(poElement) // Hidden Cancel of seft group
                        .parents('.otrCstRfid')
                        .find('.xWCstRfidSave'))
                            .addClass('hidden');
                }
                break;
            }
            default : {}
        }
    }catch(err){
        console.log('JCNxVisibledOperationIcon Error: ', err);
    }
}

/**
 * Functionality : Check records has invalid
 * Parameters : -
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : Valid status is valid return false, is invalid return true
 * Return Type : boolean
 */
function JCNbCSTRfidHasInvalidRecord(){
    try{
        var isInvalid = true;
        if($('.record-invalid').length == 0){
            isInvalid = false;
            console.log('Record is valid');
        }else{
            console.log('Record is invalid');
        }
        return isInvalid;
    }catch(err){
        console.log('JCNbHasInvalidRecord Error: ', err);
    }
}

/**
 * Functionality : Empty check record
 * Parameters : -
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : Empty status
 * Return Type : boolean
 */
function JCNbCSTRfidEmptyRecord(){
    try{
        var bStatus = false;
        if($('#otbCstRfidContainer > tr').not('.hidden').not('#otrNoRfidData').length == 0){
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCSTRfidEmptyRecord Error: ', err);
    }
}

/**
* Functionality : Check owner row
* Parameters : poElement is Itself element
* Creator : 26/09/2018 piya
* Last Modified : -
* Return : Invalid row status
* Return Type : boolean
*/
function JCNbCSTRfidIsInvalidRow(poElement){
    let bStatus = false;
    let bRfidCodeInvalid = $(poElement).parents('.otrCstRfid').find('.xWCstRfidCode').hasClass('record-invalid');
    let bRfidNameInvalid = $(poElement).parents('.otrCstRfid').find('.xWCstRfidName').hasClass('record-invalid');
    if(bRfidCodeInvalid || bRfidNameInvalid){
        bStatus = true;
    }
    console.log(bStatus);
    return bStatus;
}
</script>
