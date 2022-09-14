<script>

    $(document).ready(function(){

        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        if(bIsApvOrCancel || ((tUserLoginLevel != "HQ") && (JSvPromotionStep4BchConditionGetItemCount() == 1))){
            $('form .xCNApvOrCanCelDisabledPdtPmtHDBch').attr('disabled', true);
            $('#otbPromotionStep4BchConditionTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbPromotionStep4BchConditionTable .xCNIconDel').removeAttr('onclick', true);
        }

        if(!bIsApvOrCancel && ((tUserLoginLevel == "HQ") || (bIsMultiBch && (JSvPromotionStep4BchConditionGetItemCount() > 1)))){
            $('#otbPromotionStep4BchConditionTable .xCNIconDel').attr('onclick', 'JSxPromotionStep4BchConditionDataTableDeleteByKey(this)');
        }

        // Check All Control
        $('.xCNListItemAll').on('click', function(){
            var bIsCheckedAll = $(this).is(':checked');
            // console.log('bIsCheckedAll: ', bIsCheckedAll);
            if(bIsCheckedAll){
                $('.xCNPromotionPdtPmtHDBchRow .xCNListItem').prop('checked', true);
            }else{
                $('.xCNPromotionPdtPmtHDBchRow .xCNListItem').prop('checked', false);     
            }
        });

    });

    /**
     * Functionality : เรียกดูจำนวนแถวข้อมูล
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Row number
     * Return Type : number
     */
    function JSvPromotionStep4BchConditionGetItemCount() {
        return $("#otbPromotionStep4BchConditionTable .xCNPromotionPdtPmtHDBchRow").length;
    }

    /**
     * Functionality : เรียกหน้าของรายการ PdtPmtHDBch in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvPromotionStep4BchConditionDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xCNPromotionPdtPmtHDBchPage .xWBtnNext").addClass("disabled");
                nPageOld = $(".xCNPromotionPdtPmtHDBchPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xCNPromotionPdtPmtHDBchPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxPromotionStep4GetPdtPmtHDBchInTmp(nPageCurrent, true);
    }

    /**
     * Functionality : Update PdtPmtHDBch in Temp by Primary Key
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4BchConditionDataTableEditInline(poElm){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $(poElm).parents('.xCNPromotionPdtPmtHDBchRow').data('bch-code');
            var tDocNo = $(poElm).parents('.xCNPromotionPdtPmtHDBchRow').data('doc-no');
            var tBchCodeTo = $(poElm).parents('.xCNPromotionPdtPmtHDBchRow').data('bch-to');
            var tMerCodeTo = $(poElm).parents('.xCNPromotionPdtPmtHDBchRow').data('mer-to');
            var tShpCodeTo = $(poElm).parents('.xCNPromotionPdtPmtHDBchRow').data('shp-to');
            var tPmhStaType = $(poElm).val();

            $.ajax({
                type: "POST",
                url: "promotionStepeUpdateBchConditionInTmp",
                data: {
                    tDocNo: tDocNo,
                    tBchCode: tBchCode,
                    tBchCodeTo: tBchCodeTo,
                    tMerCodeTo: tMerCodeTo,
                    tShpCodeTo: tShpCodeTo,
                    tPmhStaType: tPmhStaType
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('.xCNPromotionPmtBrandDtPage').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep4GetPdtPmtHDBchInTmp($nCurrentPage, false);
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
     * Functionality : Delete PdtPmtHDBch in Temp by Primary Key
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4BchConditionDataTableDeleteByKey(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var tBchCode = $(poElm).parents('.xCNPromotionPdtPmtHDBchRow').data('bch-code');
            var tDocNo = $(poElm).parents('.xCNPromotionPdtPmtHDBchRow').data('doc-no');
            var tBchCodeTo = $(poElm).parents('.xCNPromotionPdtPmtHDBchRow').data('bch-to');
            var tMerCodeTo = $(poElm).parents('.xCNPromotionPdtPmtHDBchRow').data('mer-to');
            var tShpCodeTo = $(poElm).parents('.xCNPromotionPdtPmtHDBchRow').data('shp-to');

            $.ajax({
                type: "POST",
                url: "promotionStep4DeleteBchConditionInTmp",
                data: {
                    tBchCode: tBchCode,
                    tDocNo: tDocNo,
                    tBchCodeTo: tBchCodeTo,
                    tMerCodeTo: tMerCodeTo,
                    tShpCodeTo: tShpCodeTo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('.xCNPromotionPdtPmtHDBchPage').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep4GetPdtPmtHDBchInTmp($nCurrentPage, true);
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