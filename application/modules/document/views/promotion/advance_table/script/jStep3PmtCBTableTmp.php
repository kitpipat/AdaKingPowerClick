<script>

    $(document).ready(function(){

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        if(!bIsApvOrCancel){
            $('.xCNPromotionPbyMinValue, .xCNPromotionPbyMaxValue, .xCNPromotionPbyMinSetPri, .xCNPromotionPgtPerAvgDisCB').unbind().bind('change keyup', function(event){                
                if(event.keyCode == 13) {
                    JSxPromotionStep3PmtCBDataTableEditInline(this);
                }
                if(event.type == "change"){
                    JSxPromotionStep3PmtCBDataTableEditInline(this);
                }
            });

            /*===== Begin ใช้เฉลี่ยส่วนลดกลุ่มรับอัตโนมัติ Control =================================*/ 
            /* if(JSbPromotionPmhStaSpcGrpDisIsDisSomeGroup()) {
                $("#otbPromotionStep3PmtCBTable .xCNPromotionPgtPerAvgDisCB").attr("disabled", true);
            }else{
                $("#otbPromotionStep3PmtCBTable .xCNPromotionPgtPerAvgDisCB").attr("disabled", false);
            } */
            /*===== End ใช้เฉลี่ยส่วนลดกลุ่มรับอัตโนมัติ Control ===================================*/
        }

        if(bIsApvOrCancel){
            $('#otbPromotionStep3PmtCBTable .xCNApvOrCanCelDisabledPmtCB').attr('disabled', true);
        }

        // Check All Control
        $('.xCNListItemAll').on('click', function(){
            var bIsCheckedAll = $(this).is(':checked');
            // console.log('bIsCheckedAll: ', bIsCheckedAll);
            if(bIsCheckedAll){
                $('.xCNPromotionPmtCBRow .xCNListItem').prop('checked', true);
            }else{
                $('.xCNPromotionPmtCBRow .xCNListItem').prop('checked', false);     
            }
        });

    });

    /**
     * Functionality : เรียกหน้าของรายการ PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvPromotionStep3PmtCBDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xCNPromotionPmtCBPage .xWBtnNext").addClass("disabled");
                nPageOld = $(".xCNPromotionPmtCBPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xCNPromotionPmtCBPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxPromotionStep3GetPmtCBInTmp(nPageCurrent, true);
    }

    /**
     * Functionality : Update PmtCB in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3PmtCBDataTableEditInline(poElm){

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var nSeqNo          = $(poElm).parents('.xCNPromotionPmtCBRow').data('seq-no');
            var tPbyMinValue    = $(poElm).parents('.xCNPromotionPmtCBRow').find('.xCNPromotionPbyMinValue').val();
            var tPbyMaxValue    = $(poElm).parents('.xCNPromotionPmtCBRow').find('.xCNPromotionPbyMaxValue').val();
            var tPbyMinSetPri   = $(poElm).parents('.xCNPromotionPmtCBRow').find('.xCNPromotionPbyMinSetPri').val();
            var tPgtPerAvgDisCB = $(poElm).parents('.xCNPromotionPmtCBRow').find('.xCNPromotionPgtPerAvgDisCB').val();
            var tFieldName      = $(poElm).data('field-name');
            var tFormatType     = $(poElm).data('format-type');
            var tBchCode        = $('#oetDepositBchCode').val();

            $.ajax({
                type: "POST",
                url: "promotionStep3UpdatePmtCBInTmp",
                data: {
                    tPbyMinValue: (tPbyMinValue == '')?0:tPbyMinValue,
                    tPbyMaxValue: (tPbyMaxValue == '')?0:tPbyMaxValue,
                    tPbyMinSetPri: (tPbyMinSetPri == '')?0:tPbyMinSetPri,
                    tPgtPerAvgDisCB: (tPgtPerAvgDisCB == '' || !bIsAlwPmtDisAvg)?0:tPgtPerAvgDisCB,
                    nSeqNo: nSeqNo,
                    tFieldName: tFieldName,
                    tFormatType: tFormatType,
                    tBchCode: tBchCode,
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $(poElm).val(tResult.tValue);
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