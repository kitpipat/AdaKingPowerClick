<script>

    $(document).ready(function(){
    });

    /**
     * Functionality : Get Check and Confirm Page
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4GetCheckAndConfirmPage(pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var bConditionBuyIsRange = JSbPromotionConditionBuyIsRange();
            var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            $.ajax({
                type: "POST",
                url: "promotionStep5GetCheckAndConfirmPage",
                data: {
                    tBchCode: tBchCode,
                    tPbyStaBuyCond: tPbyStaBuyCond, // เงื่อนไขการซื้อ
                    tConditionBuyIsRange: (bConditionBuyIsRange)?'true':'false'
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    $('.xCNPromotionStep5CheckAndConfirmContainer').html(oResult.html);
                    JCNxCloseLoading();
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
     * Functionality : Update PMT_CB PbyStaCalSum in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep5UpdatePmtCBStaCalSumInTemp(pbUseLoading, pbIsGetPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPbyStaCalSum = $('#ocmPromotionStep5BuyPbyStaCalSum').val();
            // console.log('tPbyStaCalSum: ', tPbyStaCalSum);
            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            $.ajax({
                type: "POST",
                url: "promotionStep5UpdatePmtCBStaCalSumInTmp",
                data: {
                    tBchCode: tBchCode,
                    tPbyStaCalSum: tPbyStaCalSum // FTPbyStaCalSum 1:เฉพาะกลุ่ม 2:ทุกกลุ่ม 3:ทั้งร้าน 4:ไม่กำหนด
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    if (pbIsGetPage) {
                        JSxPromotionStep4GetCheckAndConfirmPage(false);
                    }
                    JCNxCloseLoading();
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
     * Functionality : Update PMT_CG PgtStaGetEffect in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep5UpdatePmtCGPgtStaGetEffectInTemp(pbUseLoading, pbIsGetPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPgtStaGetEffect = $('#ocmPromotionStep5GetPgtStaGetEffect').val();
            // console.log('tPgtStaGetEffect: ', tPgtStaGetEffect);

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            $.ajax({
                type: "POST",
                url: "promotionStep5UpdatePmtCGStaGetEffectInTmp",
                data: {
                    tBchCode: tBchCode,
                    tPgtStaGetEffect: tPgtStaGetEffect // FTPgtStaGetEffect 1:ตามคำนวน 2:ตามช่วง 3:ตามกลุ่ม
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    if (pbIsGetPage) {
                        JSxPromotionStep4GetCheckAndConfirmPage(false);
                    }
                    JCNxCloseLoading();
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
</script>