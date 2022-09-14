//Function : Get รูปภาพของสินค้า
function JMvDOCGetPdtImgScan(ptPdtCode){

    $.ajax({
        type: "POST",
        url: "DOCGetPdtImg",
        data: { 
            tPdtCode : ptPdtCode
        },
        cache: false,
        timeout: 5000,
        success: function(tResult){
            $('#odvShowPdtImgScan').html(tResult);
        },
        error: function(data) {
            console.log(data);
        }
    });

}

//Function : Search Pdt
function JSvDOCSearchPdtHTML(){

    var value = $('#oetSearchPdtHTML').val().toLowerCase();
    $("#otbDOCCashTable tbody tr ").filter(function() {
      tText = $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });

}

//Function : Get Pdt List In to Table
function JCNvBrowsePdt(){

    //Clear Active ที่ค้างอยู่
    $('#odvPdtDataMultiSelection').html('');
    $('#odvBrowsePdtPanal .collapse').removeClass('active');

    tSplCode = $('#oetSplCode').val();
    tStaPage = $('#ohdBrowsePdtStaPage').val();
    nStaLoad = $('#odvBrowsePdtPanal').html().length;
    

    //Count text in div เพื่อ Check ที่จะไม่ต้อง โหลด Html มาลงใหม่
    if(nStaLoad < 20){
        $.ajax({
            type: "POST",
            url: "BrowseGetPdtList",
            data: {
                tSplCode:tSplCode,
                tStaPage:tStaPage
            },
            cache: false,
            timeout: 5000,
            success: function(tResult){
                
                $('#odvBrowsePdtPanal').html(tResult);
               
                $('#odvBrowsePdt').modal('toggle');
    
            },
            error: function(data) {
                console.log(data);
            }
        });
    }else{
        $('#odvBrowsePdt').modal('toggle');
    }
  
}

//Function :modal Pdt Search
function JSxPdtBrowseSearch(pnPage){
    
    JCNxOpenLoading();
    tSplCode    = $('#oetSplCode').val();
    tPdtBarCode = $('#oetBrowsePdtBarCode').val();
    tPdtCode    = $('#oetBrowsePdtCode').val();
    tPdtPdtName = $('#oetBrowsePdtName').val();
    tPdtPunCode = $('#ostBrowsePdtPunCode').val();
    tStaPage = $('#ohdBrowsePdtStaPage').val();

    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }
    
    $.ajax({
        type: "POST",
        url: "BrowseGetPdtList",
        data: { 
            tSplCode:tSplCode,
            tPdtBarCode:tPdtBarCode,
            tPdtCode:tPdtCode,
            tPdtPdtName:tPdtPdtName,
            tPdtPunCode:tPdtPunCode,
            nPageCurrent:nPageCurrent,
            tStaPage:tStaPage
        },
        cache: false,
        timeout: 5000,
        success: function(tResult){

            $('#odvBrowsePdtPanal').html(tResult);
            JCNxCloseLoading();
        },
        error: function(data) {
            console.log(data);
        }
    });
    
}


//Function :Get Pdt Data Detail  ราคา , Barcode, หน่วย
function JSvPdtGetPdtDetailList(tPdtCode){

    tSplCode        = $('#oetSplCode').val();
    tPdtBarCode     = $('#oetBrowsePdtBarCode').val();
    tPdtPdtName     = $('#oetBrowsePdtName').val();
    tPdtPunCode     = $('#ostBrowsePdtPunCode').val();
    tStaPage        = $('#ohdBrowsePdtStaPage').val();
    tXphVATInOrEx   = $('#ohdXphVATInOrEx').val();

    $.ajax({
        type: "POST",
        url: "BrowseGetPdtDetailList",
        data: {
            tPdtCode:tPdtCode,
            tSplCode:tSplCode,
            tPdtBarCode:tPdtBarCode,
            tPdtPdtName:tPdtPdtName,
            tPdtPunCode:tPdtPunCode,
            tStaPage:tStaPage,
            tXphVATInOrEx:tXphVATInOrEx
        },
        cache: false,
        timeout: 5000,
        success: function(tResult){

            $('#otbodyPdt'+tPdtCode).append(tResult);
        },
        error: function(data) {
            console.log(data);
        }
    });
}


function JSxPDTPushMultiSelection(pnPdtCode, ptPunCode, ptBarCode, elem) {

    var nDataSelected = $('span.olbVal'+pnPdtCode+ptPunCode+ptBarCode).length;

    if (nDataSelected == 0) {
        $('#odvPdtDataMultiSelection').append($('<span>')
            .append('<label>')
            .attr('class', 'olbVal'+pnPdtCode+ptPunCode+ptBarCode)
            .attr('data-pdtcode', pnPdtCode)
            .attr('data-puncode', ptPunCode)
            .attr('data-barcode', ptBarCode)
        );
        $(elem).addClass('active');
    } else {
        $('span.olbVal'+pnPdtCode+ptPunCode+ptBarCode).remove();
        $(elem).removeClass('active');
    }

}


function JSxPDTConfirmSelected() {
        
    var aCallBackPdtCode = [];
    var aCallBackPunCode = [];
    var aCallBackBarCode = [];
    tStaPage = $('#ohdStaPage').val();//arm 23/11/18
    
    $('#odvPdtDataMultiSelection span').each(function() {
        aCallBackPdtCode.push($(this).data('pdtcode'));
        aCallBackPunCode.push($(this).data('puncode'));
        aCallBackBarCode.push($(this).data('barcode'));

        tPdtCode = $(this).data('pdtcode');
        tPunCode = $(this).data('puncode');
        tBarCode = $(this).data('barcode');
        
        nXphVATInOrEx = $('#ohdXphVATInOrEx').val(); /*ประเภท Vat ของ SPL*/

        switch(tStaPage) {
            case 'SplProduct':

                break;
            case null:
                FSvPDTAddPdtIntoTableDT(tPdtCode,tPunCode,nXphVATInOrEx);
                break;
            default:
                FSvPDTAddPdtIntoTableDT(tPdtCode,tPunCode,nXphVATInOrEx);
        }
    });

    $('#ohdBrowseDataPdtCode').val(aCallBackPdtCode);
    $('#ohdBrowseDataPunCode').val(aCallBackPunCode);
    if(tStaPage == 'SplProduct'){
        // $('#ohdBrowseDataBarCode').val(aCallBackBarCode);
        FSvAddSplProduct(aCallBackPdtCode,aCallBackBarCode);
    }

    $('#odvBrowsePdt').modal('hide');

}

//Function : Call Page Pdt
function JSvCallPagePdtMaster(){
    //Close Modal
    $('#odvBrowsePdt').modal('toggle');

    var tURL = 'product/0/0';
    $.ajax({
        url: tURL,
        type: "POST",
        error: function (jqXHR, textStatus, errorThrown) {

            JCNxCloseLoading();
            var tHtmlError = $(jqXHR.responseText);
            var tMsgError = "<h3 style='font-size:20px;color:red'>";
            tMsgError += "<i class='fa fa-exclamation-triangle'></i>";
            tMsgError += " Error<hr></h3>";
            switch (jqXHR.status) {

                case 404:
                    tMsgError += tHtmlError.find('p:nth-child(2)').text();
                    break;
                case 500:
                    tMsgError += tHtmlError.find('p:nth-child(3)').text();
                    break;

                default:
                    tMsgError += 'something had error. please contact admin';
                    break;
            }

            $("body").append(tModal);
            $('#modal-customs').attr("style", 'width: 450px; margin: 1.75rem auto;top:20%;');

            $('#myModal').modal({show: true});
            $('#odvModalBody').html(tMsgError);

        },
        success: function (tView) {
            //console.log(tView);
            $(window).scrollTop(0);
            $('.odvMainContent').html(tView);
            $('.modal-backdrop').remove();
        }
    });
}


// //Functionality : เปลี่ยนหน้า pagenation
// //Parameters : -
// //Creator : 02/07/2018 Krit(Copter)
// //Return : View
// //Return Type : View
function JSvBrowsePdtClickPage(ptPage,ptStaPage){

    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageBrowsePdt .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageBrowsePdt .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    
    JSxPdtBrowseSearch(nPageCurrent,ptStaPage);
}
