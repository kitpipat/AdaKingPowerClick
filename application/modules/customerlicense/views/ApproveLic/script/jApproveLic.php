<script type="text/javascript">
var nCheckIntercalLeave;
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCLNNavDefult();
    JSvAPCApproveLicGetPageList();

    $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });

        $('#obtCbrLicStrDate').unbind().click(function(){
                $('#oetCbrLicStrDate').datepicker('show');
     });

});

/**
 * Functionality : Function Clear Defult Button Customer
 * Parameters : -
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCLNNavDefult() {
    try{
    
            $('.xCNCstVBrowse').hide();
            $('.xCNCstVMaster').show();
            $('#oliCstTitleAdd').hide();
            $('#oliCstTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnCstInfo').show();
  
    }catch(err){
        console.log('JSxDPTNavDefult Error: ', err);
    }
}
/**
 * Functionality : Call Customer Branch Data List
 * Parameters : 
 * Creator : 13/01/2021 Nale
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvAPCApproveLicGetPageList(pnPage) {
    try{


        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "ApproveLicList",
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#odvContentPageApproveLic').html(tResult);
                    JSvAPCApproveLicGetDataTable();
                }
                $('#odvBtnAddEdit .xWBtnSave').addClass('hidden');
                $('#odvCstMasterImgContainer').addClass('hidden');
                // $('#odvContentContainer').removeClass('xWFullWidth');
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvAPVCustomerDataTable Error: ', err);
    }
}



/**
 * Functionality : Call Customer Branch Data List
 * Parameters : 
 * Creator : 13/01/2021 Nale
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvAPCApproveLicGetDataTable(pnPage) {
    try{
        var dApvLicStart = $('#oedAPCLicStart').val();
        var tAPCKeyword = $('#oetAPCKeyword').val();
  
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "ApproveLicDataTable",
            data: {
                dApvLicStart: dApvLicStart,
                tAPCKeyword: tAPCKeyword,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataApproveLic').html(tResult);
                }
                $('.xCNDateApprove').hide();
                $('#obtAPCApproveLic').hide();
                $('#oliCstTitleEdit').hide();
                $('#obtAPCApproveLicSave').hide();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvAPVCustomerDataTable Error: ', err);
    }
}



/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 13/01/2021 Nale
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvAPVClickPage(ptPage) {
    try{
        var nPageCurrent = '';
        var nPageNew;
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageCst .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageCst .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvAPCApproveLicGetDataTable(nPageCurrent);
    }catch(err){
        console.log('JSvAPVClickPage Error: ', err);
    }
}










/**
 * Functionality : Call Customer Page Edit
 * Parameters : {params}
 * Creator : 14/01/2021 Nale
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvAPVCallPageApproveLicEdit(ptDocumentNumber){

    try{
        JCNxOpenLoading();
      
        $.ajax({    
            type: "POST",
            url: "ApproveLicPageEdit",
            cache: false,
            timeout: 0,
            data:{
                ptDocumentNumber : ptDocumentNumber
            },
            success: function(tResult) {
  
                $('#odvContentPageApproveLic').html(tResult);
                $('.xCNDateApprove').show();
                $('#obtAPCApproveLic').show();
                $('#oliCstTitleEdit').show();
                $('#obtAPCApproveLicSave').show();
                JCNxCloseLoading();
  
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCustomerAdd Error: ', err);
    }


}

/**
 * Functionality : Call Customer Page Add
 * Parameters : {params}
 * Creator : 14/01/2021 Nale
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSxAPCApproveLicAddUpdateEvent(){

   
        JCNxOpenLoading();
    var tApcRoute = $('#ohdRegRoute').val();
    var oDataCstBuyLic = {
        ohdRegID    : $('#ohdRegID').val(),
        oetRegBusName : $('#oetRegBusName').val(),
        oenRegQtyBch : $('#oenRegQtyBch').val(),
        ocmRegLicGroup : $('#ocmRegLicGroup').val(),
        ocmRegLicType : $('#ocmRegLicType').val(),
        ocmRegBusType : $('#ocmRegBusType').val(),
        oetRegBusOth : $('#oetRegBusOth').val(),
        oetRegRefCst : $('#oetRegRefCst').val(),
        ocmRegStaActive : $('#ocmRegStaActive').val()
    }
      $.ajax({
          type: "POST",
          url: tApcRoute,
          cache: false,
          timeout: 0,
          data:oDataCstBuyLic,
          success: function(tResult) {
            var aReturn = JSON.parse(tResult);
            if(aReturn['nStaEvent']=='01'){
                JSvAPCApproveLicGetPageList();
            }else{
                FSvCMNSetMsgSucessDialog('Error');
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
          }
      });


}



/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaCLBDelete(pnCbrSeq){
    try{
   

        $('#ohdConfirmIDDeleteCstBuyLic').val(pnCbrSeq);
        $('#ospConfirmDeleteCstBuyLic').text($('#oetTextComfirmDeleteSingle').val() + " " + pnCbrSeq);
        $('#odvModalDelApproveLic').modal('show');

    
    }catch(err){
        console.log('JSaCLNDelete Error: ', err);
    }
}





// Event Click Appove Document
$('#obtAPCApproveLic').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {

        JSxAPCApproveLic(false);
    
    }else{
        JCNxShowMsgSessionExpired();
    }
});


// Functionality : Applove Document 
// Parameters : Event Click Buttom
// Creator : 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : Status Applove Document
// Return Type : -
function JSxAPCApproveLic(pbIsConfirm){
    if(pbIsConfirm){
        $("#odvAPCModalAppoveLic").modal("hide");
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

       var tCstKey = $('#oetCstKey').val();
       var tDocNo = $('#oetDocNo').val();
       var dCbrLicStrDate = $('#oetCbrLicStrDate').val();
        $.ajax({
            type : "POST",
            url : "ApproveLicOnChecked",
            data: {
                'tCstKey'   : tCstKey,
                'tDocNo'    : tDocNo,
                'dCbrLicStrDate' : dCbrLicStrDate,
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                console.log(tResult);
                try {
                    let oResult = JSON.parse(tResult);
                    if (oResult.nStaEvent == "1") {
                     FSvCMNSetMsgSucessDialog(oResult.tStaMessg);
                     JSvAPCApproveLicGetPageList();
                  
                        }else{
                     FSvCMNSetMsgWarningDialog(oResult.tStaMessg);
                    }
          
                } catch (err) {}
                // JSoSOCallSubscribeMQ();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        $('#odvAPCModalAppoveLic').modal({backdrop:'static',keyboard:false});
        $("#odvAPCModalAppoveLic").modal("show");
    }
}




// Functionality : Applove Document 
// Parameters : Event Click Buttom
// Creator : 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : Status Applove Document
// Return Type : -
function JSxAPCExportJson(pnRegID){
    if(pnRegID){
     


        $.ajax({
            type : "GET",
            url : "ApproveLicExportJson",
            data: {
                'nRegID'   : pnRegID,
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                console.log(tResult);
            

            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}
</script>
