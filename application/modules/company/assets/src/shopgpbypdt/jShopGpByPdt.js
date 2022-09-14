// Function : Call View Main Shop Gp By Product
// Parameters : - 
// Creator : 20/06/2019 Supawat
// Return : View
// Return Type : View
function JSvCallPageShopGpByPdtMain(ptBchCode,ptShpCode,pnPages){
  JCNxOpenLoading();
  $.ajax({
      type: "POST",
      url: "CmpShopGpByProductMain",
      data: {
          tBchCode            : ptBchCode,
          tShpCode            : ptShpCode
      },
      success: function (tView) {
          $('#odvSHPContentInfoGPP').html(tView);
          JSvCallPageShopGpByProductDataTable();
      },
      error: function(jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR, textStatus, errorThrown);
      }
  });
}

// Function : Call Table
// Parameters : - 
// Creator : 20/06/2019 Supawat
// Return : View
// Return Type : View
function JSvCallPageShopGpByProductDataTable(nPageCurrent){
    if(nPageCurrent == ''){ nPageCurrent = 1; }
    $.ajax({
        type: "POST",
        url: "CmpShopGpByProductDataTable",
        data: {
                tBchCode           : $('#ohdShopGPPDTBch').val(),
                tShpCode           : $('#ohdShopGPPDTShp').val(),
                nPageCurrent       : nPageCurrent,
                tSearchAll         : $('#oetShopGpByPDTDateStart').val()
        },
        success: function (oResult) {
                JCNxCloseLoading();
                $('#odvContentGPProduct').html(oResult);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// //Functionality : เปลี่ยนหน้า pagenation
// //Parameters : -
// //Creator : 21/06/2019 Supawat
// //Return : View
// //Return Type : View
function JSvClickPageShopPDT(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageShopGPBYPDT  .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageShopGPBYPDT .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }

    JSvCallPageShopGpByProductDataTable(nPageCurrent);
}
