<script>

    $(document).ready(function(){

        if(!bIsApvOrCancel){
            $('.xCNDepositChequeRefAmt, .xCNDepositChequeRefNo').on('change keyup', function(event){
                if(event.type == "change"){
                    JSxDepositChequeDataTableEditInline(this);
                }
                if(event.keyCode == 13) {
                    JSxDepositChequeDataTableEditInline(this);
                } 
            });
        }

        if(bIsApvOrCancel){
            $('form .xCNApvOrCanCelDisabledCheque').attr('disabled', true);
            $('#otbDOCChequeTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbDOCChequeTable .xCNIconDel').removeAttr('onclick', true);
        }else{
            $('form .xCNApvOrCanCelDisabledCheque').attr('disabled', false);
            $('#otbDOCChequeTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbDOCChequeTable .xCNIconDel').attr('onclick', 'JSxDepositChequeDataTableDeleteBySeq(this)');
        }
    });

    /**
     * Functionality : เรียกหน้าของรายการ Cheque in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvDepositChequeDataTableClickPage(ptPage) {
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
        JSxDepositGetChequeInTmp(nPageCurrent);
    }

    /**
     * Functionality : Edit Inline Cheque in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxDepositChequeDataTableEditInline(poElm) {
        JCNxOpenLoading();

        var cChequeValue = $(poElm).parents('.xCNDepositChequeRow').find('.xCNDepositChequeRefAmt').val();
        var tChequeRefNo = $(poElm).parents('.xCNDepositChequeRow').find('.xCNDepositChequeRefNo').val();
        var nSeqNo = $(poElm).parents('.xCNDepositChequeRow').data('seq-no');

        JSxDepositChequeDataTableUpdateBySeq(nSeqNo, tChequeRefNo, cChequeValue);
    }

    /**
     * Functionality : Edit Cheque in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxDepositChequeDataTableUpdateBySeq(pnSeqNo, ptChequeRefNo, pcChequeValue) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetDepositBchCode').val();

            $.ajax({
                type: "POST",
                url: "depositUpdateChequeInTmp",
                data: {
                    tChequeRefNo: ptChequeRefNo, // วันที่นำส่ง
                    cChequeValue: pcChequeValue, // จำนวนเงิน
                    nSeqNo: pnSeqNo,
                    tBchCode: tBchCode, // สาขา
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvDepositChequeDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxDepositGetChequeInTmp($nCurrentPage);
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
     * Functionality : Delete Cheque in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxDepositChequeDataTableDeleteBySeq(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var nSeqNo = $(poElm).parents('.xCNDepositChequeRow').data('seq-no');

            $.ajax({
                type: "POST",
                url: "depositDeleteChequeInTmp",
                data: {
                    nSeqNo: nSeqNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvDepositChequeDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxDepositGetChequeInTmp($nCurrentPage);
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