<script>
$(document).ready(function(){

    $('.selectpicker').selectpicker('refresh');

    $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
    });

    $('#obtTRBBrowseBchRefIntDoc').click(function(){ 
        $('#odvTRBModalRefIntDoc').modal('hide');
        var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                window.oTRBBrowseBranchOption  = undefined;
                oTRBBrowseBranchOption         = oBranchOption({
                    'tReturnInputCode'  : 'oetTRBRefIntBchCode',
                    'tReturnInputName'  : 'oetTRBRefIntBchName',
                    'tNextFuncName'     : 'JSxTRBRefIntNextFunctBrowsBranch',
                    'tAgnCode'          : $('#oetTRBAgnCode').val(),
                    'aArgReturn'        : ['FTBchCode','FTBchName','FTWahCode','FTWahName'],
                });
                JCNxBrowseData('oTRBBrowseBranchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }

    });


    $('#obtTRBBrowseRefExtDocDateFrm').unbind().click(function(){
        $('#oetTRBRefIntDocDateFrm').datepicker('show');
    });


    $('#obtTRBBrowseRefExtDocDateTo').unbind().click(function(){
        $('#oetTRBRefIntDocDateTo').datepicker('show');
    });

    JSxRefIntDocHDDataTable();
});


$('#odvTRBModalRefIntDoc').on('hidden.bs.modal', function () {
    $('#wrapper').css('overflow','auto');
    $('#odvTRBModalRefIntDoc').css('overflow','auto');
 
});

$('#odvTRBModalRefIntDoc').on('show.bs.modal', function () {
    $('#wrapper').css('overflow','hidden');
    $('#odvTRBModalRefIntDoc').css('overflow','auto');
});

function JSxTRBRefIntNextFunctBrowsBranch(ptData){
    JSxCheckPinMenuClose();
      $('#odvTRBModalRefIntDoc').modal("show");
    
}

$('#obtRefIntDocFilter').on('click',function(){
    JSxRefIntDocHDDataTable();
});

//เรียกตารางเลขที่เอกสารอ้างอิง
function JSxRefIntDocHDDataTable(pnPage){
    if(pnPage == '' || pnPage == null){
            var pnNewPage = 1;
        }else{
            var pnNewPage = pnPage;
        }
        var nPageCurrent = pnNewPage;
        var tTRBRefIntBchCode  = $('#oetTRBRefIntBchCode').val();
        var tTRBRefIntDocNo  = $('#oetTRBRefIntDocNo').val();
        var tTRBRefIntDocDateFrm  = $('#oetTRBRefIntDocDateFrm').val();
        var tTRBRefIntDocDateTo  = $('#oetTRBRefIntDocDateTo').val();
        var tTRBRefIntStaDoc  = $('#oetTRBRefIntStaDoc').val();
        // JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docTRBCallRefIntDocDataTable",
            data: {
                'tTRBRefIntBchCode'     : tTRBRefIntBchCode,
                'tTRBRefIntDocNo'       : tTRBRefIntDocNo,
                'tTRBRefIntDocDateFrm'  : tTRBRefIntDocDateFrm,
                'tTRBRefIntDocDateTo'   : tTRBRefIntDocDateTo,
                'tTRBRefIntStaDoc'      : tTRBRefIntStaDoc,
                'nTRBRefIntPageCurrent' : nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                 $('#odvRefIntDocHDDataTable').html(oResult);
                 JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JSxRefIntDocHDDataTable(pnPage)
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

}


</script>