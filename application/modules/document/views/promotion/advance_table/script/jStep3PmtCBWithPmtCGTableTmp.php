<script>

    $(document).ready(function(){

        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionPgtPerAvgDisCBWithCG").attr("disabled", true);

        var bIsEnter = false;

        if(!bIsApvOrCancel){
            $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionCBPbyMinValue, #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionCBPbyMaxValue, #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionCBPbyMinSetPri').unbind().bind('change keyup', function(event){                
                
                var bIsPbyMinValue = $(this).hasClass("xCNPromotionCBPbyMinValue");
                var bIsPbyMaxValue = $(this).hasClass("xCNPromotionCBPbyMaxValue");
                var tPbyMinValue = $(this).parents(".xCNPromotionStep3PmtCBWithPmtCGRow").find(".xCNPromotionCBPbyMinValue").val();
                var tPbyMaxValue = $(this).parents(".xCNPromotionStep3PmtCBWithPmtCGRow").find(".xCNPromotionCBPbyMaxValue").val();
                var cPbyMinValue = parseFloat(tPbyMinValue);
                var cPbyMaxValue = parseFloat(tPbyMaxValue);
                var tMsgMax = '<?php echo language('document/promotion/promotion', 'tWarMsg27'); ?>'; // ช่องไม่เกิน ไม่ถูกต้อง(ต้อง เท่ากับ หรือมากกว่า มูลค่า/จำนวน หรือเป็น 0)
                // var tMsgMin = 'ช่องมูลค่า/จำนวน ไม่ถูกต้อง(ต้องมีค่าเท่ากับ หรือน้อยกว่า ช่องไม่เกิน)';

                if(event.keyCode == 13) {
                    if(bIsPbyMaxValue && cPbyMaxValue != 0 && (cPbyMaxValue < cPbyMinValue)){
                        FSvCMNSetMsgWarningDialog(tMsgMax, '', '', false);
                        $(this).val("0");
                    }

                    // if(bIsPbyMinValue && (cPbyMinValue > cPbyMaxValue)){
                    //     FSvCMNSetMsgWarningDialog(tMsgMin, '', '', false);
                    //     $(this).val("0");
                    // }

                    bIsEnter = true;

                    JSxPromotionStep3PmtCBRangeDataTableEditInline(this);

                    return;
                }
                if(event.type == "change" && !bIsEnter){
                    if(bIsPbyMaxValue && cPbyMaxValue != 0 && (cPbyMaxValue < cPbyMinValue)){
                        FSvCMNSetMsgWarningDialog(tMsgMax, '', '', false);
                        $(this).val("0");
                    }

                    // if(bIsPbyMinValue && (cPbyMinValue > cPbyMaxValue)){
                    //     FSvCMNSetMsgWarningDialog(tMsgMin, '', '', false);
                    //     $(this).val("0");
                    // }

                    JSxPromotionStep3PmtCBRangeDataTableEditInline(this);
                    
                    return;
                }

                setTimeout(function(){
                    bIsEnter = false;
                },500);
            });

            $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionPgtPerAvgDisCBWithCG').unbind().bind('change keyup', function(event){                
                if(event.keyCode == 13) {
                    JSxPromotionStep3PmtCBRangeDataTableEditInline(this);
                    JSxPromotionStep3PmtCGRangeDataTableEditInline(this);
                }
                if(event.type == "change"){
                    JSxPromotionStep3PmtCBRangeDataTableEditInline(this);
                    JSxPromotionStep3PmtCGRangeDataTableEditInline(this);
                }
            });

            // $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PbyMinTimeHr, #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PbyMinTimeMin").on("change", function (e) {
            //     JSxPromotionStep3PmtCBRangeDataTableEditInline(this);
            // });

            // $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PbyMaxTimeHr, #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PbyMaxTimeMin").on("change", function (e) {
            //     JSxPromotionStep3PmtCBRangeDataTableEditInline(this);
            // });

            $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PgtGetvalue, #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionPgtGetQty').unbind().bind('change keyup', function(event){                
                if(event.keyCode == 13) {
                    JSxPromotionStep3PmtCGRangeDataTableEditInline(this);
                }
                if(event.type == "change"){
                    JSxPromotionStep3PmtCGRangeDataTableEditInline(this);
                }
            });

            $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PriceGroupCode').unbind().bind('change', function(event){                
                JSxPromotionStep3PmtCGRangeDataTableEditInline(this);
            });

            $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3CGPgtStaGetType').unbind().bind('change', function(){
                var bIsPgtStaGetTypeOfFree = $(this).val() == "5";

                if(bIsPgtStaGetTypeOfFree){ // เป็นของแถม Default 1.00
                    $(this).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionPgtGetQty').val('<?php echo number_format("1", $nOptDecimalShow); ?>');
                }else{ // ไม่ใช่ของแถม Default 0.00
                    $(this).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionPgtGetQty').val('<?php echo number_format("0", $nOptDecimalShow); ?>');
                }

                $(this).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PgtGetvalue').val('<?php echo number_format("0", $nOptDecimalShow); ?>');
                $(this).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PriceGroupName').val("");
                $(this).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PriceGroupCode').val("");

                JSxPromotionStep3PmtCGRangeDataTableEditInline(this, function(){
                    $nCurrentPage = $('.xCNPromotionPmtBrandDtPage').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep3GetPmtCBWithPmtCGInTmp($nCurrentPage, false);
                });
            });

            /*===== Begin ocmPromotionPmhStaGrpPriority(กลุ่มคำนวนโปรโมชั่น) Control =======*/    
            if(JSbPromotionStaGrpPriorityIsPriceGroup()){
                $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3CGPgtStaGetType").attr("disabled", true);
            }else{
                $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3CGPgtStaGetType").attr("disabled", false);
            }

            if(JSbPromotionStaGrpPriorityIsTheBest() || JSbPromotionStaGrpPriorityIsForced()){
                $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3CGPgtStaGetType .4").hide();
            }else{
                $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3CGPgtStaGetType .4").show();
            }
            /*===== End ocmPromotionPmhStaGrpPriority(กลุ่มคำนวนโปรโมชั่น) Control ========*/

            /*===== Begin ใช้เฉลี่ยส่วนลดกลุ่มรับอัตโนมัติ Control =================================*/ 
            /* if(JSbPromotionPmhStaSpcGrpDisIsDisSomeGroup()) {
                $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionPgtPerAvgDisCBWithCG").attr("disabled", true);
            }else{
                $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionPgtPerAvgDisCBWithCG").attr("disabled", true);
            } */
            /*===== End ใช้เฉลี่ยส่วนลดกลุ่มรับอัตโนมัติ Control ===================================*/ 
        }

        if(bIsApvOrCancel){
            $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNApvOrCanCelDisabledPmtCBWithPmtCG').attr('disabled', true);
            $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNIconDel').removeAttr('onclick', true);
            $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3RangeAddItemRowBtn').hide();
        }else{
            $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNIconDel').attr('onclick', 'JSxPromotionStep3PmtCBRangeDataTableDeleteBySeq(this)');

            JSxPromotionStep3LockIsOneRow();

            var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();
            if(["3","4"].includes(tPbyStaBuyCond)){
                JSbPromotionStep3LockPbyMinValue();
            }
        }

        $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3RangeAddItemRowBtn').on('click', function(){
            var tGroupName = $(this).data('grpname');
            JSvPromotionStep3InsertPmtCBAndPmtCGToTemp(tGroupName, true);
            /* var oTrPrev = $(this).parents('tr').prev();
            var oTemplate = $(oTrPrev).clone();
            $(oTemplate).insertAfter(oTrPrev); */
        });

        /* document.querySelectorAll('.xCNPromotionStep3TimeContainer input[type=number]')
        .forEach(e => e.oninput = () => {
            // Always 2 digits
            if (e.value.length >= 2) e.value = e.value.slice(0, 2);
            // 0 on the left (doesn't work on FF)
            if (e.value.length === 1) e.value = '0' + e.value;
            // Avoiding letters on FF
            if (!e.value) e.value = '00';
        }); */

    });

    /**
     * Functionality : เรียกหน้าของรายการ PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvPromotionStep3PmtCBWithPmtCGDataTableClickPage(ptPage) {
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
        JSxPromotionStep3GetPmtCBWithPmtCGInTmp(nPageCurrent, true);
    }

    /**
     * Functionality : Delete PmtCB(Range) in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3PmtCBRangeDataTableDeleteBySeq(poElm) {
        JSxPromotionStep3LockIsOneRow();
        var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();
        if(["3","4"].includes(tPbyStaBuyCond)){
            JSbPromotionStep3LockPbyMinValue();
        }
        
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var nCbSeqNo = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').data('cb-seq-no');
            var nCgSeqNo = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').data('cg-seq-no');

            $.ajax({
                type: "POST",
                url: "promotionStep3DeletePmtCBAndPmtCGInTmpBySeq",
                data: {
                    tCbSeqNo: nCbSeqNo,
                    tCgSeqNo: nCgSeqNo
                },
                cache: false,
                timeout: 0,
                success: function(oRes) {
                    if(oRes.nStaEvent == "1"){
                        if(JSbPromotionConditionBuyIsRange()){ // เงื่อนไขการซื้อแบบช่วง
                            JSxPromotionStep3GetPmtCBWithPmtCGInTmp(1, true);
                            JSvPromotionStep5UpdatePmtCBStaCalSumInTemp(false, false);
                            JSvPromotionStep5UpdatePmtCGPgtStaGetEffectInTemp(false, false);
                        }
                    }
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
     * Functionality : Update PmtCB(Range) in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3PmtCBRangeDataTableEditInline(poElm){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var nSeqNo = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').data('cb-seq-no');
            var tPbyMinValue = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionCBPbyMinValue').val();
            var tPbyMaxValue = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionCBPbyMaxValue').val();
            var tPbyMinSetPri = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionCBPbyMinSetPri').val();
            var tPgtPerAvgDisCBWithCG = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionPgtPerAvgDisCBWithCG').val();
            var tFieldName = $(poElm).data('field-name');
            var tFormatType = $(poElm).data('format-type');

            /*===== Begin Time Convert =================================================*/
                // var tPbyMinTimeHr = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PbyMinTimeHr').val();
                // var tPbyMinTimeMin = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PbyMinTimeMin').val();
                // var tPbyPbyMaxTimeHr = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PbyMaxTimeHr').val();
                // var tPbyMaxTimeMin = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PbyMaxTimeMin').val();

                // if(tPbyMinTimeHr == ""){tPbyMinTimeHr = "00";}
                // if(tPbyMinTimeMin == ""){tPbyMinTimeMin = "00";}
                // if(tPbyPbyMaxTimeHr == ""){tPbyPbyMaxTimeHr = "00";}
                // if(tPbyMaxTimeMin == ""){tPbyMaxTimeMin = "00";}
                
                // if(parseInt(tPbyMinTimeHr) < 10 && tPbyMinTimeHr.length == 1){
                //     tPbyMinTimeHr = '0' + String(tPbyMinTimeHr);    
                // }
                // if(parseInt(tPbyMinTimeMin) < 10 && tPbyMinTimeMin.length == 1){
                //     tPbyMinTimeMin = '0' + String(tPbyMinTimeMin);
                // }

                // if(parseInt(tPbyPbyMaxTimeHr) < 10 && tPbyPbyMaxTimeHr.length == 1){
                //     tPbyPbyMaxTimeHr = '0' + String(tPbyPbyMaxTimeHr);
                // }
                // if(parseInt(tPbyMaxTimeMin) < 10 && tPbyMaxTimeMin.length == 1){
                //     tPbyMaxTimeMin = '0' + String(tPbyMaxTimeMin);
                // }

                // var tPbyMinTime = tPbyMinTimeHr + ':' + tPbyMinTimeMin;
                // var tPbyPbyMaxTime = tPbyPbyMaxTimeHr + ':' + tPbyMaxTimeMin; 
            /*===== End Time Convert ===================================================*/
            
            var tPbyMinTime = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PbyMinTime').val();
            var tPbyPbyMaxTime = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PbyMaxTime').val();
            console.log("tPbyMinTime: ", tPbyMinTime);
            console.log("tPbyPbyMaxTime: ", tPbyPbyMaxTime);
            var tBchCode = $('#oetDepositBchCode').val();
            var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();

            $.ajax({
                type: "POST",
                url: "promotionStep3UpdatePmtCBInTmp",
                data: {
                    tStaBuyIsRange: "1",
                    tPbyStaBuyCond: tPbyStaBuyCond, // 1:ครบจำนวน 2:ครบมูลค่า 3:ตามช่วงจำนวน 4:ตามช่วงมูลค่า 5:ตามช่วงเวลา 6:ตามช่วงเวลา ครบจำนวน 7:ตามช่วงเวลา ครบมูลค่า
                    tPbyMinValue: (tPbyMinValue == '')?0:tPbyMinValue,
                    tPbyMaxValue: (tPbyMaxValue == '')?0:tPbyMaxValue,
                    tPbyMinSetPri: (tPbyMinSetPri == '')?0:tPbyMinSetPri,
                    tPgtPerAvgDisCB: (tPgtPerAvgDisCBWithCG == '' || !bIsAlwPmtDisAvg)?0:tPgtPerAvgDisCBWithCG,
                    tPbyMinTime: (tPbyMinTime == '')?'00:00':tPbyMinTime,
                    tPbyPbyMaxTime: (tPbyPbyMaxTime == '')?'59:00':tPbyPbyMaxTime,
                    nSeqNo: nSeqNo,
                    tFieldName: tFieldName,
                    tFormatType: tFormatType,
                    tBchCode: tBchCode,
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if(tFormatType == "D"){
                        // var tPbyMinTime = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PbyMinTime').val();
                        // var tPbyPbyMaxTime = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PbyMaxTime').val();
                        // $(poElm).parents(".xCNPromotionStep3PmtCBWithPmtCGRow")
                        // .find(".xCNPromotionStep3PbyMinTimeHr").val(tResult.tValue.timeForm.tHr);
                        // $(poElm).parents(".xCNPromotionStep3PmtCBWithPmtCGRow")
                        // .find(".xCNPromotionStep3PbyMinTimeMin").val(tResult.tValue.timeForm.tMin);
                        // $(poElm).parents(".xCNPromotionStep3PmtCBWithPmtCGRow")
                        // .find(".xCNPromotionStep3PbyMaxTimeHr").val(tResult.tValue.timeTo.tHr);
                        // $(poElm).parents(".xCNPromotionStep3PmtCBWithPmtCGRow")
                        // .find(".xCNPromotionStep3PbyMaxTimeMin").val(tResult.tValue.timeTo.tMin);
                    }else{
                        $(poElm).val(tResult.tValue);
                    }
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
     * Functionality : Update PmtCG(Range) in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3PmtCGRangeDataTableEditInline(poElm, callback){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            callback = (typeof callback !== 'undefined')?callback: function(){};

            var nSeqNo = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').data('cg-seq-no');
            var tPgtStaGetType = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('select.xCNPromotionStep3CGPgtStaGetType').val();
            var tPgtGetvalue = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PgtGetvalue').val();
            var tPgtGetQty = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionPgtGetQty').val();
            var tPgtPerAvgDisCBWithCG = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionPgtPerAvgDisCBWithCG').val();
            var tPriceGroupCode = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PriceGroupCode').val();
            var tPriceGroupName = $(poElm).parents('.xCNPromotionStep3PmtCBWithPmtCGRow').find('.xCNPromotionStep3PriceGroupName').val();
            var tFieldName = $(poElm).data('field-name');
            var tFormatType = $(poElm).data('format-type');
            var tBchCode = $('#oetDepositBchCode').val();
            
            $.ajax({
                type: "POST",
                url: "promotionStep3UpdatePmtCGInTmp",
                data: {
                    tStaBuyIsRange: "1",
                    tPgtStaGetType: tPgtStaGetType,
                    tPgtGetvalue: (tPgtGetvalue == '')?0:tPgtGetvalue,
                    tPgtGetQty: (tPgtGetQty == '')?0:tPgtGetQty,
                    tPgtPerAvgDisCG: (tPgtPerAvgDisCBWithCG == '' || !bIsAlwPmtDisAvg)?0:tPgtPerAvgDisCBWithCG,
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
                    var nNewValue = tResult.tValue;
                    var nNewValue = nNewValue.replace(/,/g, '');
                    $(poElm).val(nNewValue);
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

    /**
     * Functionality : Lock Table Row Have One
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3LockIsOneRow(){
        var oAllRow = $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PmtCBWithPmtCGRow");
        var aGrpName = [];
        $.each(oAllRow, function(nIndex, oValue){
            var tGrpNamePoint = "";
            var tGrpName = $(this).data("grp-name");
            if(tGrpName != tGrpNamePoint){
                tGrpNamePoint = tGrpName;
                aGrpName.push(tGrpName);
            }
        });

        $.each(aGrpName, function(nIndex, tValue){
            var tName = tValue.replace(" ", "");
            var nRowLength = $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PmtCBWithPmtCGRow." + tName).length;
            if(nRowLength == 1){
                $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PmtCBWithPmtCGRow.' + tName + ' .xCNIconDel').addClass('xCNDocDisabled');
                $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PmtCBWithPmtCGRow.' + tName + ' .xCNIconDel').removeAttr('onclick', true);
            }else{
                $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PmtCBWithPmtCGRow.' + tName + ' .xCNIconDel').removeClass('xCNDocDisabled');
                $('#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PmtCBWithPmtCGRow.' + tName + ' .xCNIconDel').attr('onclick', 'JSxPromotionStep3PmtCBRangeDataTableDeleteBySeq(this)');
            }
        });
    }

    /**
     * Functionality : Lock PbyMinValue Input
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSbPromotionStep3LockPbyMinValue(){
        var oAllRow = $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PmtCBWithPmtCGRow");
        var aGrpName = [];
        $.each(oAllRow, function(nIndex, oValue){
            var tGrpNamePoint = "";
            var tGrpName = $(this).data("grp-name");
            if(tGrpName != tGrpNamePoint){
                tGrpNamePoint = tGrpName;
                aGrpName.push(tGrpName);
            }
        });

        $.each(aGrpName, function(nIndex, tValue){
            var tName = tValue.replace(" ", "");
            var oRow = $("#otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PmtCBWithPmtCGRow." + tName);
            var nRowLength = $(oRow).length;
            $.each(oRow, function(nIndex, oValue){
                if(nIndex == 0){
                }else{
                    $(this).find(".xCNPromotionCBPbyMinValue").attr("readonly", true);
                }
            });
        });
    }
</script>