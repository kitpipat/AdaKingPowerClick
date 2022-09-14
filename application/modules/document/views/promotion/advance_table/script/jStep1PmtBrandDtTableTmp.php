<script>

    $(document).ready(function(){

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        if(bIsApvOrCancel){
            $('form .xCNApvOrCanCelDisabledPmtBrandDt').attr('disabled', true);
            $('#otbPromotionStep1PmtBrandDtTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbPromotionStep1PmtBrandDtTable .xCNIconDel').removeAttr('onclick', true);
        }else{
            $('form .xCNApvOrCanCelDisabledPmtBrandDt').attr('disabled', false);
            $('#otbPromotionStep1PmtBrandDtTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbPromotionStep1PmtBrandDtTable .xCNIconDel').attr('onclick', 'JSxPromotionStep1PmtBrandDtDataTableDeleteBySeq(this)');
        }

        // Check All Control
        $('.xCNListItemAll').on('click', function(){
            var bIsCheckedAll = $(this).is(':checked');
            // console.log('bIsCheckedAll: ', bIsCheckedAll);
            if(bIsCheckedAll){
                $('.xCNPromotionPmtBrandDtRow .xCNListItem').prop('checked', true);
            }else{
                $('.xCNPromotionPmtBrandDtRow .xCNListItem').prop('checked', false);     
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
     * Functionality : เรียกหน้าของรายการ PmtBrandDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvPromotionStep1PmtBrandDtDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xCNPromotionPmtBrandDtPage .xWBtnNext").addClass("disabled");
                nPageOld = $(".xCNPromotionPmtBrandDtPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xCNPromotionPmtBrandDtPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxPromotionStep1GetPmtBrandDtInTmp(nPageCurrent, true);
    }

    /**
     * Functionality : Edit Cash in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1PmtBrandDtDataTableUpdateBySeq(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var nSeqNo = $(poElm).parents('.xCNPromotionPmtBrandDtRow').data('seq-no');
            var tModelCode = $(poElm).parents('.xCNPromotionPmtBrandDtRow').find('.xCNModelCode').val();
            var tModelName = $(poElm).parents('.xCNPromotionPmtBrandDtRow').find('.xCNModelName').val();
            var tBchCode = $('#oetDepositBchCode').val();
            var tPmtGroupNameTmp = $('#oetPromotionGroupNameTmp').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();
            var tPmtGroupTypeTmp = $('#ocmPromotionGroupTypeTmp').val();
            var tPmtGroupListTypeTmp = $('#ocmPromotionListTypeTmp').val();

            $.ajax({
                type: "POST",
                url: "promotionStep1UpdatePmtBrandDtInTmp",
                data: {
                    tPmtGroupNameTmp: tPmtGroupNameTmp,
                    tPmtGroupNameTmpOld: tPmtGroupNameTmpOld,
                    tPmtGroupTypeTmp: tPmtGroupTypeTmp,
                    tPmtGroupListTypeTmp: tPmtGroupListTypeTmp,
                    tModelCode: tModelCode,
                    tModelName: tModelName,
                    nSeqNo: nSeqNo,
                    tBchCode: tBchCode,
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('.xCNPromotionPmtBrandDtPage').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep1GetPmtBrandDtInTmp($nCurrentPage, true);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Delete PmtBrandDt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1PmtBrandDtDataTableDeleteBySeq(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var nSeqNo = $(poElm).parents('.xCNPromotionPmtBrandDtRow').data('seq-no');

            $.ajax({
                type: "POST",
                url: "promotionStep1DeletePmtDtInTmp",
                data: {
                    nSeqNo: nSeqNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvPromotionPmtBrandDtDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep1GetPmtBrandDtInTmp($nCurrentPage, true);
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
    function JSxPromotionStep1PmtBrandDtDataTableDeleteMore() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var oListChecked = $(".xCNListItem:checked");
            var oListCheckedLength = oListChecked.length;
            var aSeqNo = [];

            $.each(oListChecked, function(index, item){
                var nSeqNo = $(item).parents('.xCNPromotionPmtBrandDtRow').data('seq-no');
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
                    JSxPromotionStep1GetPmtBrandDtInTmp($nCurrentPage, true);
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