<script>

    $(document).ready(function(){

        $('.selectpicker').selectpicker();

        if(!bIsApvOrCancel){
            $('#otbPromotionStep3PmtCGTable .xCNPromotionStep3PgtGetvalue, #otbPromotionStep3PmtCGTable .xCNPromotionPgtPerAvgDisCG, #otbPromotionStep3PmtCGTable .xCNPromotionPgtGetQty').unbind().bind('change keyup', function(event){                
                if(event.keyCode == 13) {
                    JSxPromotionStep3PmtCGDataTableEditInline(this);
                }
                if(event.type == "change"){
                    JSxPromotionStep3PmtCGDataTableEditInline(this);
                }
            });

            $('#otbPromotionStep3PmtCGTable .xCNPromotionStep3PriceGroupCode').unbind().bind('change', function(event){                
                JSxPromotionStep3PmtCGDataTableEditInline(this);
            });

            $('#otbPromotionStep3PmtCGTable .xCNPromotionStep3PgtStaGetType').unbind().bind('change', function(){
                var bIsPgtStaGetTypeOfFree = $(this).val() == "5";
                var bIsPgtStaGetTypeOfPriceGroup = $(this).val() == "4";

                if(bIsPgtStaGetTypeOfPriceGroup){ // 4:ใช้กลุ่มราคา
                    JSvPromotionStep3UpdatePmtCGPgtStaGetEffectInTemp(2); // 2:ทั้งกลุ่ม
                }else{
                    JSvPromotionStep3UpdatePmtCGPgtStaGetEffectInTemp(1); // 1:ตามคำนวน Default
                }

                if(bIsPgtStaGetTypeOfFree){ // เป็นของแถม Default 1.00
                    $(this).parents('.xCNPromotionStep3PmtCGRow').find('.xCNPromotionPgtGetQty').val('<?php echo number_format("1", $nOptDecimalShow); ?>');
                }else{ // ไม่ใช่ของแถม Default 0.00
                    $(this).parents('.xCNPromotionStep3PmtCGRow').find('.xCNPromotionPgtGetQty').val('<?php echo number_format("0", $nOptDecimalShow); ?>');
                }

                $(this).parents('.xCNPromotionStep3PmtCGRow').find('.xCNPromotionStep3PgtGetvalue').val('<?php echo number_format("0", $nOptDecimalShow); ?>');
                $(this).parents('.xCNPromotionStep3PmtCGRow').find('.xCNPromotionStep3PriceGroupName').val("");
                $(this).parents('.xCNPromotionStep3PmtCGRow').find('.xCNPromotionStep3PriceGroupCode').val("");

                JSxPromotionStep3PmtCGDataTableEditInline(this, function(){
                    $nCurrentPage = $('.xCNPromotionPmtBrandDtPage').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep3GetPmtCGInTmp($nCurrentPage, false);
                });
                
            });

            /*===== Begin ocmPromotionPmhStaGrpPriority(กลุ่มคำนวนโปรโมชั่น) Control =======*/    
            if(JSbPromotionStaGrpPriorityIsPriceGroup()){
                $("#otbPromotionStep3PmtCGTable .xCNPromotionStep3PgtStaGetType").attr("disabled", true);
            }else{
                $("#otbPromotionStep3PmtCGTable .xCNPromotionStep3PgtStaGetType").attr("disabled", false);
            }

            if(JSbPromotionStaGrpPriorityIsTheBest() || JSbPromotionStaGrpPriorityIsForced()){
                $("#otbPromotionStep3PmtCGTable .xCNPromotionStep3PgtStaGetType .4").hide();
            }else{
                $("#otbPromotionStep3PmtCGTable .xCNPromotionStep3PgtStaGetType .4").show();
            }
            /*===== End ocmPromotionPmhStaGrpPriority(กลุ่มคำนวนโปรโมชั่น) Control ========*/   

            /*===== Begin ใช้เฉลี่ยส่วนลดกลุ่มรับอัตโนมัติ Control =================================*/ 
            /* if(JSbPromotionPmhStaSpcGrpDisIsDisSomeGroup()) {
                $("#otbPromotionStep3PmtCGTable .xCNPromotionPgtPerAvgDisCG").attr("disabled", true);
            }else{
                $("#otbPromotionStep3PmtCGTable .xCNPromotionPgtPerAvgDisCG").attr("disabled", false);
            } */
            /*===== End ใช้เฉลี่ยส่วนลดกลุ่มรับอัตโนมัติ Control ===================================*/ 
        }

        if(bIsApvOrCancel){
            $('#otbPromotionStep3PmtCGTable .xCNApvOrCanCelDisabledPmtCG').attr('disabled', true);
        }

        // Check All Control
        $('.xCNListItemAll').on('click', function(){
            var bIsCheckedAll = $(this).is(':checked');
            // console.log('bIsCheckedAll: ', bIsCheckedAll);
            if(bIsCheckedAll){
                $('#otbPromotionStep3PmtCGTable .xCNPromotionStep3PmtCGRow .xCNListItem').prop('checked', true);
            }else{
                $('#otbPromotionStep3PmtCGTable .xCNPromotionStep3PmtCGRow .xCNListItem').prop('checked', false);     
            }
        });
    });

    /**
     * Functionality : Update PMT_CG PgtStaGetEffect in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3UpdatePmtCGPgtStaGetEffectInTemp(ptStaGetEffect) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPgtStaGetEffect = ptStaGetEffect;

            $.ajax({
                type: "POST",
                url: "promotionStep5UpdatePmtCGStaGetEffectInTmp",
                data: {
                    tBchCode: tBchCode,
                    tPgtStaGetEffect: tPgtStaGetEffect // FTPgtStaGetEffect 1:ตามคำนวน 2:ตามช่วง 3:ตามกลุ่ม 4:ทุกกลุ่ม
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
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
     * Functionality : เรียกหน้าของรายการ PmtCG in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvPromotionStep3PmtCGDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xCNPromotionPmtCGPage .xWBtnNext").addClass("disabled");
                nPageOld = $(".xCNPromotionPmtCGPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xCNPromotionPmtCGPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxPromotionStep3GetPmtCGInTmp(nPageCurrent, true);
    }

    /**
     * Functionality : Update PmtCG in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3PmtCGDataTableEditInline(poElm, callback){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            callback = (typeof callback !== 'undefined')?callback: function(){};

            var nSeqNo = $(poElm).parents('.xCNPromotionStep3PmtCGRow').data('seq-no');
            var tPgtStaGetType = $(poElm).parents('.xCNPromotionStep3PmtCGRow').find('select.xCNPromotionStep3PgtStaGetType').val();
            var tPgtGetvalue = $(poElm).parents('.xCNPromotionStep3PmtCGRow').find('.xCNPromotionStep3PgtGetvalue').val();
            var tPgtPerAvgDisCG = $(poElm).parents('.xCNPromotionStep3PmtCGRow').find('.xCNPromotionPgtPerAvgDisCG').val();
            var tPgtGetQty = $(poElm).parents('.xCNPromotionStep3PmtCGRow').find('.xCNPromotionPgtGetQty').val();
            var tPriceGroupCode = $(poElm).parents('.xCNPromotionStep3PmtCGRow').find('.xCNPromotionStep3PriceGroupCode').val();
            var tPriceGroupName = $(poElm).parents('.xCNPromotionStep3PmtCGRow').find('.xCNPromotionStep3PriceGroupName').val();
            var tFieldName = $(poElm).data('field-name');
            var tFormatType = $(poElm).data('format-type');
            var tBchCode = $('#oetDepositBchCode').val();
            
            $.ajax({
                type: "POST",
                url: "promotionStep3UpdatePmtCGInTmp",
                data: {
                    tPgtStaGetType: tPgtStaGetType,
                    tPgtGetvalue: (tPgtGetvalue == '')?0:tPgtGetvalue,
                    tPgtPerAvgDisCG: (tPgtPerAvgDisCG == '' || !bIsAlwPmtDisAvg)?0:tPgtPerAvgDisCG,
                    tPgtGetQty: (tPgtGetQty == '')?0:tPgtGetQty,
                    tPriceGroupCode: tPriceGroupCode,
                    tPriceGroupName: tPriceGroupName,
                    nSeqNo: nSeqNo,
                    tFieldName: tFieldName,
                    tFormatType: tFormatType,
                    tBchCode: tBchCode,
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $(poElm).val(tResult.tValue);
                    callback();
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