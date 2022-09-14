<script type="text/javascript">
var nCheckIntercalLeave;
$('#oliBchAddr').unbind().click(function(){
    if($('#oetCbrRefBch').val()!=''){
    JSvTBAGetPageList();

    }
});



// Functionality: Set Branch Address Nav Default
// Parameters: Document Ready And Function Parameter
// Creator: 11/09/2019 Wasin
// Return: -
// ReturnType: -
function JCNxBranchAddressSetNavDefault(){
    // Hide Title And Button Default
    $('#olbBranchAddressAdd').hide();
    $('#olbBranchAddressEdit').hide();
    $('#odvBranchAddressBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#olbBranchAddressInfo').show();
    $('#odvBranchAddressBtnGrpInfo').show();
}
/**
 * Functionality : Call Customer Branch Data List
 * Parameters : 
 * Creator : 13/01/2021 Nale
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvTBAGetPageList(pnPage) {
    try{
        var tSearchAll = $('#oetBchAddrSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "BchAddrList",
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#odvTabBchAddr').html(tResult);
                    JSvTBAGetDataTable();
                    JCNxBranchAddressSetNavDefault();
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
        console.log('JSvTBACustomerDataTable Error: ', err);
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
function JSvTBAGetDataTable(pnPage) {
    try{
        var tSearchAll = $('#oetBchAddrSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "BchAddrDataTable",
            data: {
                tCstCode : $('#oetCstCode').val() ,
                tCbrRefBch : $('#oetCbrRefBch').val(),
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#odvBranchAddressContent').html(tResult);
                }

            
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvTBACustomerDataTable Error: ', err);
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
function JSvTBAClickPage(ptPage) {
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
        JSvTBAGetDataTable(nPageCurrent);
    }catch(err){
        console.log('JSvTBAClickPage Error: ', err);
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
function JSvTBACallPageBchAddrAdd() {
    try{
        JCNxOpenLoading();
      
        $.ajax({
            type: "POST",
            url: "BchAddrPageAdd",
            cache: false,
            timeout: 0,
            data:{
                tCstCode : $('#oetCstCode').val() ,
                tCbrRefBch : $('#oetCbrRefBch').val(),
            },
            success: function(tResult) {
  
                $('#odvBranchAddressContent').html(tResult);
                // Hide Title And Button
                $('#olbBranchAddressEdit').hide();
                $('#odvBranchAddressBtnGrpInfo').hide();
                // Show Title And Button
                $('#olbBranchAddressAdd').show();
                $('#odvBranchAddressBtnGrpAddEdit').show();
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
 * Functionality : Call Customer Page Edit
 * Parameters : {params}
 * Creator : 14/01/2021 Nale
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvTBACallPageBchAddrEdit(poBranchAddressData){

    try{
        JCNxOpenLoading();
      
        $.ajax({    
            type: "POST",
            url: "BchAddrPageEdit",
            cache: false,
            timeout: 0,
            data:poBranchAddressData,
            success: function(tResult) {
  
                $('#odvBranchAddressContent').html(tResult);
                // Hide Title And Button
                $('#olbBranchAddressEdit').hide();
                $('#odvBranchAddressBtnGrpInfo').hide();
                // Show Title And Button
                $('#olbBranchAddressAdd').show();
                $('#odvBranchAddressBtnGrpAddEdit').show();
   
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
function JSxTBAAddUpdateEvent(){

   
        JCNxOpenLoading();
    var tCbrRoute = $('#ofmBranchAddressForm #ohdBranchAddressRoute').val();
    // var oDataBchAddr = {
    //     rtCstCode : $('#oetCstCode').val(),
    //     rtCbrRefBch : $('#ohdCbrRefBch').val(),
    //     rtLicPdtCode : $('#oetLicPdtCode').val(),
    //     rdLicStart : $('#oedLicStart').val(),
    //     rdLicFinish : $('#oedLicFinish').val(),
    //     rtLicRefUUID : $('#oetLicRefUUID').val(),
    //     rnLicStaUse : $('#ocmLicStaUse').val(),
    // }
    var oDataBchAddr =   $('#ofmBranchAddressForm').serialize();
    console.log(tCbrRoute);
    console.log(oDataBchAddr);

      $.ajax({
          type: "POST",
          url: tCbrRoute,
          cache: false,
          timeout: 0,
          data:oDataBchAddr,
          success: function(tResult) {
            var aReturn = JSON.parse(tResult);
            if(aReturn['nStaReturn']==1){
                JSvTBAGetDataTable();
                JCNxBranchAddressSetNavDefault();
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
function JSaTBADelete(pnCbrSeq){
    try{
   

        $('#ohdConfirmIDDeleteBchAddr').val(pnCbrSeq);
        $('#ospConfirmDeleteBchAddr').text($('#oetTextComfirmDeleteSingle').val() + " " + pnCbrSeq);
        $('#odvModalDelBchAddr').modal('show');

    
    }catch(err){
        console.log('JSaCLNDelete Error: ', err);
    }
}


/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaTBABchAddrDelete(poBranchAddressData){

    // var oDataBchAddr = {
    //     rtCstCode : $('#oetCstCode').val(),
    //     rnCbrSeq :$('#ohdConfirmIDDeleteBchAddr').val()
    // }

    $.ajax({
          type: "POST",
          url: "BchAddrDelete",
          cache: false,
          timeout: 0,
          data:poBranchAddressData,
          success: function(tResult) {
            var aReturn = JSON.parse(tResult);
            $('#odvModalDelBchAddr').modal('hide');
            if(aReturn['nStaReturn']==1){
                JSvTBAGetDataTable();
                JCNxBranchAddressSetNavDefault();
            }else{
                FSvCMNSetMsgSucessDialog('Error');
            }
      
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
          }
      });

}




</script>
