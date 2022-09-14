<script type="text/javascript">
$(document).ready(function() {
        
    $('body').on('focus',".xCNDatePicker", function(){
        $(this).datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            // startDate: new Date(),
            // startDate: '-3d',
            orientation: "bottom"
        });
    });

    $('.selectpicker').selectpicker();

    // Advance search display control
    $('#oahCardShiftRefundAdvanceSearch').on('click', function() {
        if($('#odvCardShiftRefundAdvanceSearchContainer').hasClass('hidden')){
            JSxCMNVisibleComponent('#odvCardShiftRefundAdvanceSearchContainer', true, 'slideUD');
        }else{
            JSxCMNVisibleComponent('#odvCardShiftRefundAdvanceSearchContainer', false, 'slideUD');
        }
    });
    
});

/**
* Functionality : Clear search data
* Parameters : -
* Creator : 12/12/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCardShiftRefundClearSearchData(){
    try{
        $('#oetSearchAll').val("");
        $('#oetCardShiftRefundSearchDocDateFrom').val("");
        $('#oetCardShiftRefundSearchDocDateTo').val("");
        $('#oetCardShiftRefundSearchCardQtyTo').val("");
        $(".selectpicker").val('0').selectpicker("refresh");
        JSvCardShiftRefundCardShiftRefundDataTable();
    }catch(err){
        console.log("JSxCardShiftRefundClearSearchData Error: ", err);
    }
}

/**
* Functionality : Get search data
* Parameters : -
* Creator : 12/12/2018 piya
* Last Modified : -
* Return : Search data
* Return Type : Object
*/
function JSoCardShiftRefundGetSearchData(){
    try{
        var oAdvanceSearchData  = {
            tSearchAll : $('#oetSearchAll').val(),
            tSearchDocDateFrom : $('#oetCardShiftRefundSearchDocDateFrom').val(),
            tSearchDocDateTo : $('#oetCardShiftRefundSearchDocDateTo').val(),
            tSearchStaDoc : $('#ocmCardShiftRefundStaDoc').val(),
            tSearchStaPrc : $('#ocmCardShiftRefundStaPrcDoc').val(),
            tSearchStaAct : $('#ocmCardShiftRefundStaDocAct').val(),
            tSearchStaApprove : $('#ocmCardShiftRefundStaApprove').val()
        };
        return oAdvanceSearchData;
    }catch(err){
        console.log("JSoCardShiftRefundGetSearchData Error: ", err);
    }
}

/**
     * Functionality : Delete Doc
     * Parameters : tCurrentPage, tDocNo
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundDocDel(tCurrentPage, tDocNo, tBchCode) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            $("#odvModalDel").addClass('one')
            $("#odvModalDel").removeClass('more')
            $("#odvModalDel").modal("show");
            $("#ospConfirmDelete").html("<?php echo language('common/main/main', 'tModalConfirmDeleteItemsNo'); ?> : " + tDocNo);

            $("#odvModalDel.one #osmConfirm").on("click", function(evt) {
                $("#odvModalDel").modal("hide");
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "cardShifRefundDelDoc",
                    data: {
                        tDocNo: tDocNo,
                        tBchCode: tBchCode
                    },
                    cache: false,
                    success: function(tResult) {
                        JSvCardShiftRefundCardShiftRefundDataTable(tCurrentPage);
                        JSxCardShiftRefundCardShiftRefundNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCloseLoading();
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Multi Delete Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundDelChoose() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            $("#odvModalDel").addClass('more')
            $("#odvModalDel").removeClass('one')
            $("#odvModalDel").modal("show");
            $("#ospConfirmDelete").html("<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll'); ?>");

            $("#odvModalDel.more #osmConfirm").on("click", function(evt) {

                var oItem = $(".otrCardShiftRefund .ocbListItem:checked");
                var nItemLength = oItem.length;
                var aDocData = [];

                $.each(oItem, function(){
                    var tDocNo = $(this).parents(".otrCardShiftRefund").data('doc-no');
                    var tBchCode = $(this).parents(".otrCardShiftRefund").data('bch-code');
                    aDocData.push({
                        tDocNo: tDocNo,
                        tBchCode: tBchCode
                    })
                });

                $("#odvModalDel").modal("hide");
                JCNxOpenLoading();

                $.ajax({
                    type: "POST",
                    url: "cardShiftRefundDelDocMulti",
                    data: {
                        aDocData: JSON.stringify(aDocData)
                    },
                    success: function(tResult) {
                        JSvCardShiftRefundCardShiftRefundDataTable(1);
                        JSxCardShiftRefundCardShiftRefundNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCloseLoading();
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }
</script>

