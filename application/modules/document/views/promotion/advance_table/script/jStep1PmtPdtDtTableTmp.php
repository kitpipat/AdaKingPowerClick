<script>
    $(document).ready(function(){

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        if(bIsApvOrCancel){
            $('form .xCNApvOrCanCelDisabledPmtPdtDt').attr('disabled', true);
            $('#otbPromotionStep1PmtPdtDtTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbPromotionStep1PmtPdtDtTable .xCNIconDel').removeAttr('onclick', true);
        }else{
            $('form .xCNApvOrCanCelDisabledPmtPdtDt').attr('disabled', false);
            $('#otbPromotionStep1PmtPdtDtTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbPromotionStep1PmtPdtDtTable .xCNIconDel').attr('onclick', 'JSxPromotionStep1PmtPdtDtDataTableDeleteBySeq(this)');
        }

        // Checked Row All Control
        $('.xCNListItemAll').on('click', function(){
            var bIsCheckedAll = $(this).is(':checked');
            // console.log('bIsCheckedAll: ', bIsCheckedAll);
            if(bIsCheckedAll){
                $('.xCNPromotionPmtPdtDtRow .xCNListItem').prop('checked', true);
            }else{
                $('.xCNPromotionPmtPdtDtRow .xCNListItem').prop('checked', false);     
            }
        });

        /*===== Begin Checked Shop All Control =========================================*/
        var bIsShopAll = $('.xCNPromotionStep1PmtDtShopAll').data('status') == "1";
        if(bIsShopAll){
            $('#ocbPromotionPmtPdtDtShopAll').prop('checked', true);
            $('.xCNPromotionStep1BtnBrowse').prop('disabled', true).addClass('xCNBrowsePdtdisabled');
            $('.xCNPromotionStep1BtnShooseFile').prop('disabled', true);
            $('.xCNPromotionStep1BtnDropDrownOption').prop('disabled', true);
            $('#oetPromotionStep1PmtFileName').prop('disabled', true);
        }else{
            $('#ocbPromotionPmtPdtDtShopAll').prop('checked', false);
            $('.xCNPromotionStep1BtnBrowse').prop('disabled', false).removeClass('xCNBrowsePdtdisabled');
            $('.xCNPromotionStep1BtnShooseFile').prop('disabled', false);
            $('.xCNPromotionStep1BtnDropDrownOption').prop('disabled', false);
            $('#oetPromotionStep1PmtFileName').prop('disabled', false);
            
        }
        /*===== End Checked Shop All Control ===========================================*/

        if(bIsApvOrCancel){
            $('.xCNAddPmtGroupModalCanCelDisabled').prop('disabled', true);
            $('.xCNPromotionStep1BtnBrowse').prop('disabled', true).addClass('xCNBrowsePdtdisabled');
        }
    });

    /**
     * Functionality : เรียกหน้าของรายการ PmtPdtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvPromotionStep1PmtPdtDtDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xCNPromotionPmtPdtDtPage .xWBtnNext").addClass("disabled");
                nPageOld = $(".xCNPromotionPmtPdtDtPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xCNPromotionPmtPdtDtPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxPromotionStep1GetPmtPdtDtInTmp(nPageCurrent, true);
    }

    /**
     * Functionality : Delete PmtPdtDt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1PmtPdtDtDataTableDeleteBySeq(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var nSeqNo = $(poElm).parents('.xCNPromotionPmtPdtDtRow').data('seq-no');

            $.ajax({
                type: "POST",
                url: "promotionStep1DeletePmtDtInTmp",
                data: {
                    nSeqNo: nSeqNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvPromotionPmtPdtDtDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep1GetPmtPdtDtInTmp($nCurrentPage, true);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    JCNxCloseLoading();
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Delete More PmtPdtDt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1PmtPdtDtDataTableDeleteMore() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var oListChecked = $(".xCNListItem:checked");
            var oListCheckedLength = oListChecked.length;
            var aSeqNo = [];

            $.each(oListChecked, function(index, item){
                var nSeqNo = $(item).parents('.xCNPromotionPmtPdtDtRow').data('seq-no');
                aSeqNo.push(nSeqNo);
            });

            $.ajax({
                type: "POST",
                url: "promotionStep1DeleteMorePmtDtInTmp",
                data: {
                    tSeqNo: JSON.stringify(aSeqNo)
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvPromotionPmtPdtDtDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep1GetPmtPdtDtInTmp($nCurrentPage, true);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    JCNxCloseLoading();
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }
</script>