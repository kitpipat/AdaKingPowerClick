<script>

    $(document).ready(function(){

        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        if(bIsApvOrCancel){
            $('form .xCNApvOrCanCelDisabledPdtPmtHDCstLev').attr('disabled', true);
            $('#otbPromotionStep4CstLevConditionTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbPromotionStep4CstLevConditionTable .xCNIconDel').removeAttr('onclick', true);
        }else{
            $('form .xCNApvOrCanCelDisabledPdtPmtHDCstLev').attr('disabled', false);
            $('#otbPromotionStep4CstLevConditionTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbPromotionStep4CstLevConditionTable .xCNIconDel').attr('onclick', 'JSxPromotionStep4CstLevConditionDataTableDeleteByKey(this)');
        }

        // Check All Control
        $('.xCNListItemAll').on('click', function(){
            var bIsCheckedAll = $(this).is(':checked');
            // console.log('bIsCheckedAll: ', bIsCheckedAll);
            if(bIsCheckedAll){
                $('.xCNPromotionPdtPmtHDCstLevRow .xCNListItem').prop('checked', true);
            }else{
                $('.xCNPromotionPdtPmtHDCstLevRow .xCNListItem').prop('checked', false);     
            }
        });

    });

    /**
     * Functionality : เรียกหน้าของรายการ PdtPmtHDCstLev in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvPromotionStep4CstLevConditionDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xCNPromotionPdtPmtHDCstLevPage .xWBtnNext").addClass("disabled");
                nPageOld = $(".xCNPromotionPdtPmtHDCstLevPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xCNPromotionPdtPmtHDCstLevPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxPromotionStep4GetPdtPmtHDCstLevInTmp(nPageCurrent, true);
    }

    /**
     * Functionality : Update PdtPmtHDCstLev in Temp by Primary Key
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4CstLevConditionDataTableEditInline(poElm){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $(poElm).parents('.xCNPromotionPdtPmtHDCstLevRow').data('bch-code');
            var tDocNo = $(poElm).parents('.xCNPromotionPdtPmtHDCstLevRow').data('doc-no');
            var tClvCode = $(poElm).parents('.xCNPromotionPdtPmtHDCstLevRow').data('ppl-code');
            var tPmhStaType = $(poElm).val();

            $.ajax({
                type: "POST",
                url: "promotionStepeUpdateCstLevConditionInTmp",
                data: {
                    tDocNo: tDocNo,
                    tClvCode: tClvCode,
                    tBchCode: tBchCode,
                    tPmhStaType: tPmhStaType
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('.xCNPromotionPmtBrandDtPage').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep3GetPmtCGInTmp($nCurrentPage, false);
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
     * Functionality : Delete PdtPmtHDCstLev in Temp by Primary Key
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4CstLevConditionDataTableDeleteByKey(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var tBchCode = $(poElm).parents('.xCNPromotionPdtPmtHDCstLevRow').data('bch-code');
            var tDocNo = $(poElm).parents('.xCNPromotionPdtPmtHDCstLevRow').data('doc-no');
            var tClvCode = $(poElm).parents('.xCNPromotionPdtPmtHDCstLevRow').data('ppl-code');

            $.ajax({
                type: "POST",
                url: "promotionStep4DeleteCstLevConditionInTmp",
                data: {
                    tBchCode: tBchCode,
                    tDocNo: tDocNo,
                    tClvCode: tClvCode
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('.xCNPromotionPdtPmtHDCstLevPage').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep4GetPdtPmtHDCstLevInTmp($nCurrentPage, true);
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