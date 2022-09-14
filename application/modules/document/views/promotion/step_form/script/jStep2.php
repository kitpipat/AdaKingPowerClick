<script>
    $(document).ready(function(){ 
        JSvPromotionStep2GetPmtCBInTemp();
        JSvPromotionStep2GetPmtCGInTemp();
    });
    
    /**
     * Functionality : Get PMT_DT Group Name in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep2GetPmtDtGroupNameInTmp(pnPage, pbUseLoading, ptGroupType) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            var tSearchAll = $('#oetPromotionPdtLayoutSearchAll').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "promotionStep2GetPmtDtGroupNameInTmp",
                data: {
                    tBchCode: tBchCode,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll,
                    tGroupType: ptGroupType
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    if(ptGroupType == "1") {
                        $('.xCNPromotionStep2GroupNameType1').html(oResult.html);
                    }
                    if(ptGroupType == "2") {
                        $('.xCNPromotionStep2GroupNameType2').html(oResult.html);
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
     * Functionality : Get PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep2GetPmtCBInTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            $.ajax({
                type: "POST",
                url: "promotionStep2GetPmtCBInTmp",
                data: {
                    tBchCode: tBchCode
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    $('.xCNPromotionStep2GroupBuy').html(oResult.html);
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
     * Functionality : Get PmtCG in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep2GetPmtCGInTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            $.ajax({
                type: "POST",
                url: "promotionStep2GetPmtCGInTmp",
                data: {
                    tBchCode: tBchCode
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    $('.xCNPromotionStep2GroupGet').html(oResult.html);
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

    /*
    function : ข้อมูลในกลุ่มซื้อว่างหรือไม่
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep2PmtDtGroupBuyIsEmpty() {
        var bStatus = true;
        nRowLength = $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item').length;
        if(nRowLength > 0){
            bStatus = false;
        }
        return bStatus;
    }

    /*
    function : ข้อมูลในกลุ่มรับว่างหรือไม่
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep2PmtDtGroupGetIsEmpty() {
        var bStatus = true;
        nRowLength = $('.xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item').length;
        if(nRowLength > 0){
            bStatus = false;
        }
        return bStatus;
    }

    /*
    function : ตรวจสอบข้อมูลก่อน Next Step
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep2IsValid() {
        var bStatus = false;
        var bPmtDtGroupBuyIsEmpty = JCNbPromotionStep2PmtDtGroupBuyIsEmpty();   

        if(!bPmtDtGroupBuyIsEmpty){
            bStatus = true;
        }
        return bStatus;
    }
</script>