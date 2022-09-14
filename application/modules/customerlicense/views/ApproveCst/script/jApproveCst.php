<script type="text/javascript">
var nCheckIntercalLeave;
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCLNNavDefult();
    JSvAPCApproveCstGetPageList();
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
function JSvAPCApproveCstGetPageList(pnPage) {
    try{


        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "ApproveCstList",
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#odvContentPageApproveCst').html(tResult);
                    JSvAPCApproveCstGetDataTable();
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
function JSvAPCApproveCstGetDataTable(pnPage) {
    try{
        var dApvLicStart = $('#oedAPCLicStart').val();
        var tAPCRegBusName = $('#oetAPCRegBusName').val();
        var nAPCRegLicGroup = $('#ocmAPCRegLicGroup').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "ApproveCstDataTable",
            data: {
                dApvLicStart: dApvLicStart,
                tAPCRegBusName: tAPCRegBusName,
                nAPCRegLicGroup: nAPCRegLicGroup,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataApproveCst').html(tResult);
                }
                $('#obtAPCApproveCst').hide();
                $('#oliCstTitleEdit').hide();
                $('#obtAPCApproveCstSave').hide();
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
        JSvAPCApproveCstGetDataTable(nPageCurrent);
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
function JSvAPVCallPageApproveCstEdit(pnRegID){

    try{
        JCNxOpenLoading();
      
        $.ajax({    
            type: "POST",
            url: "ApproveCstPageEdit",
            cache: false,
            timeout: 0,
            data:{
                pnRegID : pnRegID
            },
            success: function(tResult) {
  
                $('#odvContentPageApproveCst').html(tResult);
                $('#obtAPCApproveCst').show();
                $('#oliCstTitleEdit').show();
                $('#obtAPCApproveCstSave').show();
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
function JSxAPCApproveCstAddUpdateEvent(){

   
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
        ocmRegStaActive : $('#ocmRegStaActive').val(),
        oetRegEmail : $('#oetRegEmail').val(),
        oetRegTel : $('#oetRegTel').val()
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
                JSvAPCApproveCstGetPageList();
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
        $('#odvModalDelApproveCst').modal('show');

    
    }catch(err){
        console.log('JSaCLNDelete Error: ', err);
    }
}





// Event Click Appove Document
$('#obtAPCApproveCst').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {

        JSxAPCApproveCst(false);
    
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
function JSxAPCExportJson(pnRegID){
    if(pnRegID){
     


        $.ajax({
            type : "GET",
            url : "ApproveCstExportJson",
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
