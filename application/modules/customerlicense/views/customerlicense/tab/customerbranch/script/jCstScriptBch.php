<script type="text/javascript">
var nCheckIntercalLeave;
$('#oliCstBch').unbind().click(function(){
	JSvCLNCshBchGetPageList();
});


/**
 * Functionality : Call Customer Branch Data List
 * Parameters : 
 * Creator : 13/01/2021 Nale
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCLNCshBchGetPageList(pnPage) {
    try{
        var tSearchAll = $('#oetCstBchSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "customerbranchList",
            data: {
				tCstCode : $('#oetCstCode').val() ,
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#odvTabCstBch').html(tResult);
                    JSvCLNCshBchGetDataTable();
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
        console.log('JSvCLNCustomerDataTable Error: ', err);
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
function JSvCLNCshBchGetDataTable(pnPage) {
    try{
        var tSearchAll = $('#oetCstBchSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "customerbranchDataTable",
            data: {
				tCstCode : $('#oetCstCode').val() ,
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataCustomerBranch').html(tResult);
                }

            
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCLNCustomerDataTable Error: ', err);
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
function JSvCLBClickPage(ptPage) {
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
        JSvCLNCshBchGetDataTable(nPageCurrent);
    }catch(err){
        console.log('JSvCLBClickPage Error: ', err);
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
function JSvCLBCallPageCustomerBranchAdd() {
    try{
        JCNxOpenLoading();
      
        $.ajax({
            type: "POST",
            url: "customerbranchPageAdd",
            data: {
				tCstCode : $('#oetCstCode').val() ,
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
  
                $('#odvTabCstBch').html(tResult);
   
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
function JSvCLBCallPageCustomerBranchEdit(pnCbrSeq){

    try{
        JCNxOpenLoading();
      
        $.ajax({    
            type: "POST",
            url: "customerbranchPageEdit",
            cache: false,
            timeout: 0,
            data:{
                rtCstCode : $('#oetCstCode').val(),
                rnCbrSeq  : pnCbrSeq,
            },
            success: function(tResult) {
  
                $('#odvTabCstBch').html(tResult);
   
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
function JSxCLBCstBchAddUpdateEvent(){

    if($('#oetCbrRefBchName').val()!=''){
        JCNxOpenLoading();
    var tCbrRoute = $('#ohdCbrRoute').val();
    var oDataCstBch = {
        rtCstCode : $('#oetCstCode').val(),
        rnCbrSeq : $('#ohdCbrSeq').val(),
        rtSrvCode : $('#oetSrvCode').val(),
        rtCbrRefBch : $('#oetCbrRefBch').val(),
        rtCbrRefBchName : $('#oetCbrRefBchName').val(),
        rnCbrQtyPos : $('#oenCbrQtyPos').val(),
    }
      $.ajax({
          type: "POST",
          url: tCbrRoute,
          cache: false,
          timeout: 0,
          data:oDataCstBch,
          success: function(tResult) {
            var aReturn = JSON.parse(tResult);
            if(aReturn['nStaEvent']=='01'){
                JSvCLNCshBchGetPageList();
            }else{
                FSvCMNSetMsgSucessDialog('Error');
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
          }
      });


    }else{

        FSvCMNSetMsgSucessDialog('กรุณาอ้างอิงชื่อสาขา');
    }
    

}





</script>
