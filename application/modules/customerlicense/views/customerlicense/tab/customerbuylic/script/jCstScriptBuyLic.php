<script type="text/javascript">
var nCheckIntercalLeave;
$('#oliCstBuyLic').unbind().click(function(){
	JSvCBLCstBuyLicGetPageList();
});
/**
 * Functionality : Call Customer Branch Data List
 * Parameters : 
 * Creator : 13/01/2021 Nale
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCBLCstBuyLicGetPageList(pnPage) {
    try{
        var tSearchAll = $('#oetCstBuyLicSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "customerBuyLicList",
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#odvTabCstBuyLic').html(tResult);
                    JSvCBLCstBuyLicGetDataTable();
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
        console.log('JSvCBLCustomerDataTable Error: ', err);
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
function JSvCBLCstBuyLicGetDataTable(pnPage) {
    try{
        var tSearchAll = $('#oetCstBuyLicSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "customerBuyLicDataTable",
            data: {
				tCstCode : $('#oetCstCode').val() ,
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataCustomerBuyLic').html(tResult);
                }

            
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCBLCustomerDataTable Error: ', err);
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
function JSvCBLClickPage(ptPage) {
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
        JSvCBLCstBuyLicGetDataTable(nPageCurrent);
    }catch(err){
        console.log('JSvCBLClickPage Error: ', err);
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
function JSvCBLCallPageCustomerBuyLicAdd() {
    try{
        JCNxOpenLoading();
      
        $.ajax({
            type: "POST",
            url: "customerBuyLicPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
  
                $('#odvTabCstBuyLic').html(tResult);
   
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
function JSvCBLCallPageCustomerBuyLicEdit(ptCbrRefBch,pnLicUUIDSeq,ptLicPdtCode){

    try{
        JCNxOpenLoading();
      
        $.ajax({    
            type: "POST",
            url: "customerBuyLicPageEdit",
            cache: false,
            timeout: 0,
            data:{
                rtCstCode : $('#oetCstCode').val(),
                rtCbrRefBch  : ptCbrRefBch,
                rnLicUUIDSeq : pnLicUUIDSeq,
                rtLicPdtCode  : ptLicPdtCode,
            },
            success: function(tResult) {
  
                $('#odvTabCstBuyLic').html(tResult);
   
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
function JSxCBLCstBuyLicAddUpdateEvent(){

   
        JCNxOpenLoading();
    var tCbrRoute = $('#ohdCbrRouteBuyLic').val();
    var oDataCstBuyLic = {
        rtCstCode : $('#oetCstCode').val(),
        rtCbrRefBch : $('#ohdCbrRefBch').val(),
        rnLicUUIDSeq : $('#ohdLicUUIDSeq').val(),
        rtLicPdtCode : $('#oetLicPdtCode').val(),
        rdLicStart : $('#oedLicStart').val(),
        rdLicFinish : $('#oedLicFinish').val(),
        rtLicRefUUID : $('#oetLicRefUUID').val(),
        rnLicStaUse : $('#ocmLicStaUse').val(),
        rtCbrRefBchEdit : $('#oetCbrRefBch').val(),
    }
      $.ajax({
          type: "POST",
          url: tCbrRoute,
          cache: false,
          timeout: 0,
          data:oDataCstBuyLic,
          success: function(tResult) {
            var aReturn = JSON.parse(tResult);
            if(aReturn['nStaEvent']=='01'){
                JSvCBLCstBuyLicGetPageList();
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
        $('#odvModalDelCustomerBuyLic').modal('show');

    
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
function JSaCLBCstBuyLicDelete(){

    var oDataCstBuyLic = {
        rtCstCode : $('#oetCstCode').val(),
        rnCbrSeq :$('#ohdConfirmIDDeleteCstBuyLic').val()
    }

    $.ajax({
          type: "POST",
          url: "customerBuyLicDelete",
          cache: false,
          timeout: 0,
          data:oDataCstBuyLic,
          success: function(tResult) {
            var aReturn = JSON.parse(tResult);
            $('#odvModalDelCustomerBuyLic').modal('hide');
            if(aReturn['nStaEvent']=='01'){
                JSvCBLCstBuyLicGetDataTable();
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
function JSaSyncLicenseAll (){


    var oDataCstBuyLic = {
        rtCstCode : $('#oetCstCode').val(),
    }

    $.ajax({
          type: "POST",
          url: "customerBuyLicSyncLicense",
          cache: false,
          timeout: 0,
          data:oDataCstBuyLic,
          success: function(tResult) {
            var aReturn = JSON.parse(tResult);
            if(aReturn['rtCode']=='001'){
                // JSvCBLCstBuyLicGetDataTable();
                FSvCMNSetMsgSucessDialog(aReturn['rtDesc']);
            }else{
                FSvCMNSetMsgSucessDialog(aReturn['rtDesc']);
            }
      
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
          }
      });

}

</script>
