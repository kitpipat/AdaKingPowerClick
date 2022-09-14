<script>

    $(document).ready(function(){

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        if(!bIsApvOrCancel){
            $('.xCNDepositCashRefAmt, .xCNDepositCashRefDate').on('change keyup', function(event){
                if(event.type == "change"){
                    JSxDepositCashDataTableEditInline(this);
                }
                if(event.keyCode == 13) {
                    JSxDepositCashDataTableEditInline(this);
                } 
            });
        }

        if(bIsApvOrCancel){
            $('form .xCNApvOrCanCelDisabledCash').attr('disabled', true);
            $('#otbDOCCashTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbDOCCashTable .xCNIconDel').removeAttr('onclick', true);
        }else{
            $('form .xCNApvOrCanCelDisabledCash').attr('disabled', false);
            $('#otbDOCCashTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbDOCCashTable .xCNIconDel').attr('onclick', 'JSxDepositCashDataTableDeleteBySeq(this)');
        }
    });

    /**
     * Functionality : เรียกหน้าของรายการ Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvDepositCashDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxDepositGetCashInTmp(nPageCurrent);
    }

    /**
     * Functionality : Edit Inline Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxDepositCashDataTableEditInline(poElm) {
        JCNxOpenLoading();

        var cCashValue = $(poElm).parents('.xCNDepositCashRow').find('.xCNDepositCashRefAmt').val();
        var tCashRefDate = $(poElm).parents('.xCNDepositCashRow').find('.xCNDepositCashRefDate').val();
        var nSeqNo = $(poElm).parents('.xCNDepositCashRow').data('seq-no');

        JSxDepositCashDataTableUpdateBySeq(nSeqNo, tCashRefDate, cCashValue);
    }

    /**
     * Functionality : Edit Cash in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxDepositCashDataTableUpdateBySeq(pnSeqNo, ptCashDate, pcCashValue) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetDepositBchCode').val();

            $.ajax({
                type: "POST",
                url: "depositUpdateCashInTmp",
                data: {
                    tCashDate: ptCashDate, // วันที่นำส่ง
                    cCashValue: pcCashValue, // จำนวนเงิน
                    nSeqNo: pnSeqNo,
                    tBchCode: tBchCode, // สาขา
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvDepositCashDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxDepositGetCashInTmp($nCurrentPage);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Delete Cash in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxDepositCashDataTableDeleteBySeq(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var nSeqNo = $(poElm).parents('.xCNDepositCashRow').data('seq-no');

            $.ajax({
                type: "POST",
                url: "depositDeleteCashInTmp",
                data: {
                    nSeqNo: nSeqNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvDepositCashDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxDepositGetCashInTmp($nCurrentPage);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }
</script>