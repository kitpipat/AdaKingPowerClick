<script>

    $(document).ready(function(){

        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        if(bIsApvOrCancel){
            $('form .xCNApvOrCanCelDisabledPdtPmtHDChn').attr('disabled', true);
            $('#otbPromotionStep4ChnConditionTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbPromotionStep4ChnConditionTable .xCNIconDel').removeAttr('onclick', true);
        }else{
            $('form .xCNApvOrCanCelDisabledPdtPmtHDChn').attr('disabled', false);
            $('#otbPromotionStep4ChnConditionTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbPromotionStep4ChnConditionTable .xCNIconDel').attr('onclick', 'JSxPromotionStep4ChnConditionDataTableDeleteByKey(this)');
        }

        // Check All Control
        $('.xCNListItemAll').on('click', function(){
            var bIsCheckedAll = $(this).is(':checked');
            // console.log('bIsCheckedAll: ', bIsCheckedAll);
            if(bIsCheckedAll){
                $('.xCNPromotionPdtPmtHDChnRow .xCNListItem').prop('checked', true);
            }else{
                $('.xCNPromotionPdtPmtHDChnRow .xCNListItem').prop('checked', false);     
            }
        });

    });

    /**
     * Functionality : เรียกหน้าของรายการ PdtPmtHDChn in Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Return : Table List
     * Return Type : View
     */
    function JSvPromotionStep4PriceGroupConditionDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xCNPromotionPdtPmtHDChnPage .xWBtnNext").addClass("disabled");
                nPageOld = $(".xCNPromotionPdtPmtHDChnPriPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xCNPromotionPdtPmtHDChnPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxPromotionStep4GetHDChnInTmp(nPageCurrent, true);
    }

    /**
     * Functionality : Update PdtPmtHDChn in Temp by Primary Key
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4ChnConditionDataTableEditInline(poElm){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $(poElm).parents('.xCNPromotionPdtPmtHDChnRow').data('bch-code');
            var tDocNo = $(poElm).parents('.xCNPromotionPdtPmtHDChnRow').data('doc-no');
            var tChnCode = $(poElm).parents('.xCNPromotionPdtPmtHDChnRow').data('chn-code');
            var tPmhStaType = $(poElm).val();

            $.ajax({
                type: "POST",
                url: "promotionStepeUpdateChnConditionInTmp",
                data: {
                    tDocNo: tDocNo,
                    tChnCode: tChnCode,
                    tBchCode: tBchCode,
                    tPmhStaType: tPmhStaType
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('.xCNPromotionPmtBrandDtPage').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep4GetHDChnInTmp($nCurrentPage, false);
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
     * Functionality : Delete PdtPmtHDCstPri in Temp by Primary Key
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4ChnConditionDataTableDeleteByKey(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var tBchCode = $(poElm).parents('.xCNPromotionPdtPmtHDChnRow').data('bch-code');
            var tDocNo = $(poElm).parents('.xCNPromotionPdtPmtHDChnRow').data('doc-no');
            var tChnCode = $(poElm).parents('.xCNPromotionPdtPmtHDChnRow').data('chn-code');


            $.ajax({
                type: "POST",
                url: "promotionStep4DeleteChnConditionInTmp",
                data: {
                    tBchCode: tBchCode,
                    tDocNo: tDocNo,
                    tChnCode: tChnCode
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('.xCNPromotionPdtPmtHDChnPage').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep4GetHDChnInTmp($nCurrentPage, true);
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