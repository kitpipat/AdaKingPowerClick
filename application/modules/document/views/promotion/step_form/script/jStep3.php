<script>
    $(document).ready(function() {
        JSvPromotionStep3GetCouponInTemp();
        JSvPromotionStep3GetPointInTemp();

        if (JCNbPromotionStep3PmtCGTableIsEmpty()) {
            $('#ocbPromotionStep3GroupGetControl').prop('checked', false);
        } else {
            $('#ocbPromotionStep3GroupGetControl').prop('checked', true);
        }
    });

    $('#obtPmtDateStart').click(function() {
        $('#oetPromotionStep3DateStart').datepicker('show');
    });

    $('#obtPmtDateEnd').click(function() {
        $('#oetPromotionStep3DateEnd').datepicker('show');
    });

    var dStart = new Date($('#oetPromotionPmhDStart').val());
    var dEnd = new Date(new Date($('#oetPromotionPmhDStart').val()).setYear(dStart.getFullYear() + 1));

    $('#oetPromotionStep3DateStart').datepicker({
        startDate: dStart,
        endDate: dEnd,
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,

    }).on('changeDate', function() {
        $('#oetPromotionStep3DateEnd').datepicker('setStartDate', new Date($('#oetPromotionStep3DateStart').val()));
    });

    $('#oetPromotionStep3DateEnd').datepicker({
        startDate: dStart,
        endDate: dEnd,
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,

    }).on('changeDate', function() {
        $('#oetPromotionStep3DateStart').datepicker('setStartDate', new Date($('#oetPromotionPmhDStart').val()));
    });



    /*===== Begin Check Control All ====================================================*/
    /* $('#ocbPromotionStep3CouponControl, #ocbPromotionStep3PointControl, #ocbPromotionStep3GroupGetControl').bind('change', function(){
        // console.log('checked');
        if( JSbPromotionStep3GetCouponPointEmptyChecked() ){
            // console.log('this: ', this);
            $(this).prop('checked', true);
            $(this).trigger("change");
            var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg8'); ?>'; // กรุณาเลือกรายการ เงื่อนไขกลุ่มรับ, เงื่อนไข-สิทธิประโยชน์คูปอง, เงื่อนไข-สิทธิประโยชน์แต้ม อย่างน้อย 1 เงื่อนไข
            FSvCMNSetMsgWarningDialog(tWarningMessage);
        } 
    }); */
    /*===== End Check Control All ======================================================*/

    if (!bIsApvOrCancel) {
        /*===== Begin ocbPromotionStep3GroupGetControl เงื่อนไขกลุ่มรับ =========================*/
        $('#ocbPromotionStep3GroupGetControl').unbind().bind('change', function() {

            if (JSbPromotionStep3GetCouponPointEmptyChecked()) {
                $(this).prop('checked', true);
                $(this).trigger("change");
                var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg8'); ?>'; // กรุณาเลือกรายการ เงื่อนไขกลุ่มรับ, เงื่อนไข-สิทธิประโยชน์คูปอง, เงื่อนไข-สิทธิประโยชน์แต้ม อย่างน้อย 1 เงื่อนไข
                FSvCMNSetMsgWarningDialog(tWarningMessage);
                $('#ocbPromotionStep3GroupGetControl').prop('checked', true);
            } else {
                var bIsChecked = $(this).is(':checked');
                if (bIsChecked) {
                    // ให้ไปเพิ่มรายใหม่ Prev Step
                    var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg9'); ?>'; // กรุณาเลือกรายการ กำหนดกลุ่ม ซื้อ-รับ
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    $('#ocbPromotionStep3GroupGetControl').attr('checked', false);
                } else {
                    $('.xCNPromotionStep2GroupGet').empty();
                    // Remove CG Table Tmp
                    JSvPromotionStep3ClearPmtCGInTemp();
                }
            }
        });
        /*===== End ocbPromotionStep3GroupGetControl เงื่อนไขกลุ่มรับ ===========================*/

        /*===== Begin ocbPromotionStep3CouponControl เงื่อนไข - สิทธิประโยชน์คูปอง ===========*/
        $('#ocbPromotionStep3CouponControl').unbind().bind('change', function() {
            if (JSbPromotionStep3GetCouponPointEmptyChecked()) {
                $(this).prop('checked', true);
                $(this).trigger("change");
                var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg8'); ?>'; // กรุณาเลือกรายการ เงื่อนไขกลุ่มรับ, เงื่อนไข-สิทธิประโยชน์คูปอง, เงื่อนไข-สิทธิประโยชน์แต้ม อย่างน้อย 1 เงื่อนไข
                FSvCMNSetMsgWarningDialog(tWarningMessage);
            } else {
                var bIsChecked = $(this).is(':checked');
                if (bIsChecked) {
                    $('#ocmPromotionStep3PgtStaCoupon').prop('disabled', false);
                    $('#ocmPromotionStep3PgtStaCoupon').selectpicker("refresh");
                    $('#obtPromotionBrowseCoupon').prop('disabled', false);
                    $('#oetPromotionStep3PgtCpnText').prop('disabled', false);
                    // ให้ไปเพิ่มรายใหม่
                    JSvPromotionStep3InsertOrUpdateCouponToTemp();
                } else {
                    $('.xCNPromotionStep3BrowseCouponContainer').show();
                    $('.xCNPromotionStep3PgtCpnTextContainer').hide();

                    $('#ocmPromotionStep3PgtStaCoupon').prop('disabled', true);
                    $('#ocmPromotionStep3PgtStaCoupon').val('2').selectpicker("refresh");
                    $('#obtPromotionBrowseCoupon').prop('disabled', true);
                    $('#oetPromotionStep3PgtCpnText').prop('disabled', true);

                    $('#oetPromotionStep3CouponName').val("");
                    $('#oetPromotionStep3CouponCode').val("");
                    $('#oetPromotionStep3PgtCpnText').val("");
                    // Remove CG Table Tmp
                    JSvPromotionStep3DeleteCouponInTemp();
                }
            }
        });

        $('#ocmPromotionStep3PgtStaCoupon').on('change', function() {
            var bIsPgtCpnTextType = $(this).val() == "3"; // การให้สิทธิ์ 1:ไม่กำหนด 2:.ให้สิทธิ์คูปอง 3:ข้อความ
            if (bIsPgtCpnTextType) {
                $('.xCNPromotionStep3BrowseCouponContainer').hide();
                $('.xCNPromotionStep3PgtCpnTextContainer').show();
                $('#oetPromotionStep3CouponCode').val("");
                $('#oetPromotionStep3CouponName').val("");
            } else {
                $('.xCNPromotionStep3BrowseCouponContainer').show();
                $('.xCNPromotionStep3PgtCpnTextContainer').hide();
                $('#oetPromotionStep3PgtCpnText').val("");
            }
        });
        /*===== End ocbPromotionStep3CouponControl เงื่อนไข - สิทธิประโยชน์คูปอง =============*/

        /*===== Begin ocbPromotionStep3PointControl เงื่อนไข - สิทธิประโยชน์แต้ม =============*/
        // $('#ocbPromotionStep3PointControl').parents(".fancy-checkbox").find("span").unbind().bind('click', function() {
        //     if (JSbPromotionPmhStaLimitCstIsAll()) {
        //         var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg7'); ?>'; // ใช้งานได้เฉพาะ คิดทั้งหมด/คิดต่อสมาชิก เป็นต่อสมาชิกเท่านั้น
        //         FSvCMNSetMsgWarningDialog(tWarningMessage);
        //     }
        // });

        // Last Update : Napat(Jame) 19/12/2022 เพิ่มการตรวจสอบการ เปิด/ปิด input เมื่อ Alert Fail ให้ปิด input ไว้เหมือนเดิม
        // $('#ocbPromotionStep3PointControl').unbind().bind('change', function(event) {
        $('#ocbPromotionStep3PointControl').off('change').on('change', function() {

            var bIsChecked  = $(this).is(':checked');
            var bCurChecked = $(this).is(':checked');

            if (JSbPromotionStep3GetCouponPointEmptyChecked()) {
                bCurChecked = true;
                $(this).prop('checked', true);
                var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg8'); ?>'; // กรุณาเลือกรายการ เงื่อนไขกลุ่มรับ, เงื่อนไข-สิทธิประโยชน์คูปอง, เงื่อนไข-สิทธิประโยชน์แต้ม อย่างน้อย 1 เงื่อนไข
                FSvCMNSetMsgWarningDialog(tWarningMessage);
            }

            if (bIsChecked) {
                if (JSbPromotionPmhStaLimitCstIsAll()) {
                    bCurChecked = false;
                    $(this).prop('checked', false);
                    var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg7'); ?>'; // ใช้งานได้เฉพาะ คิดทั้งหมด/คิดต่อสมาชิก เป็นต่อสมาชิกเท่านั้น
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                }
            }
            
            if (bCurChecked) {
                $('#ocmPromotionStep3PgtStaPoint').prop('disabled', false);
                $('#ocmPromotionStep3PgtStaPoint').selectpicker("refresh");
                $('#ocmPromotionStep3PgtStaPntCalType').prop('disabled', false);
                $('#ocmPromotionStep3PgtStaPntCalType').selectpicker("refresh");
                $('#oetPromotionStep3PgtPntBuy').prop('disabled', false);
                $('#oetPromotionStep3PgtPntGet').prop('disabled', false);
                $('#obtPromotionBrowseSpl').prop('disabled', false);
                $('#oetPromotionStep3DateStart').prop('disabled', false);
                $('#obtPmtDateStart').prop('disabled', false);
                $('#oetPromotionStep3DateEnd').prop('disabled', false);
                $('#obtPmtDateEnd').prop('disabled', false);
                // ให้ไปเพิ่มรายใหม่
                JSvPromotionStep3InsertOrUpdatePointToTemp();
            } else {
                $('#ocmPromotionStep3PgtStaPoint').prop('disabled', true);
                $('#ocmPromotionStep3PgtStaPoint').val('2').selectpicker("refresh");
                $('#ocmPromotionStep3PgtStaPntCalType').prop('disabled', true);
                $('#ocmPromotionStep3PgtStaPntCalType').val('1').selectpicker("refresh");
                $('#oetPromotionStep3PgtPntBuy').val("").prop('disabled', true);
                $('#oetPromotionStep3PgtPntGet').val("").prop('disabled', true);
                $('#oetPromotionSplCode').val("")
                $('#oetPromotionSplName').val("")
                $('#obtPromotionBrowseSpl').prop('disabled', true);
                $('#oetPromotionStep3DateStart').val("").prop('disabled', true);
                $('#obtPmtDateStart').prop('disabled', true);
                $('#oetPromotionStep3DateEnd').val("").prop('disabled', true);
                $('#obtPmtDateEnd').prop('disabled', true);
                // Remove CG Table Tmp
                JSvPromotionStep3DeletePointInTemp();
            }

        });
        /*===== End ocbPromotionStep3PointControl เงื่อนไข - สิทธิประโยชน์แต้ม ===============*/
    }

    /**
     * Functionality : Empty Checked Status
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Status
     * Return Type : boolean
     */
    function JSbPromotionStep3GetCouponPointEmptyChecked() {
        var bIsCheckedCoupon = $('#ocbPromotionStep3CouponControl').is(':checked');
        var bIsCheckedPoint = $('#ocbPromotionStep3PointControl').is(':checked');
        var bIsCheckedGroupGet = $('#ocbPromotionStep3GroupGetControl').is(':checked');

        var bStatus = false;

        if ((bIsCheckedCoupon == false) && (bIsCheckedPoint == false) && (bIsCheckedGroupGet == false)) {
            bStatus = true;
        }

        return bStatus;
    }

    /*===== Begin PMT CB Table Process =================================================*/
    /**
     * Functionality : Get PMT_CB in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3GetPmtCBInTmp(pnPage, pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();
            var tSearchAll = $('#oetPromotionPdtLayoutSearchAll').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "promotionStep3GetPmtCBInTmp",
                data: {
                    tBchCode: tBchCode,
                    tPbyStaBuyCond: tPbyStaBuyCond,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll,
                    bIsAlwPmtDisAvg: bIsAlwPmtDisAvg
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    $('.xCNPromotionStep3TableGroupBuy').html(oResult.html);
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
     * Functionality : Insert PMT_CB to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3InsertPmtCBToTemp(ptGroupName) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();
            // var bStaSpcGrpDisIsDisSomeGroup = JSbPromotionPmhStaSpcGrpDisIsDisSomeGroup();
            var tGroupName = ptGroupName;

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep3InsertPmtCBToTmp",
                data: {
                    tBchCode: tBchCode,
                    tGroupNameInBuy: tGroupName, // Group Name for Add
                    tPbyStaBuyCond: tPbyStaBuyCond, // เงื่อนไขการซื้อ
                    bIsAlwPmtDisAvg: bIsAlwPmtDisAvg
                    // tStaSpcGrpDisIsDisSomeGroup: (bStaSpcGrpDisIsDisSomeGroup)?'true':'false',
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    if (JSbPromotionConditionBuyIsRange()) { // เงื่อนไขการซื้อแบบช่วง
                        JSxPromotionStep3GetPmtCBWithPmtCGInTmp(1, false);
                    }
                    if (JSbPromotionConditionBuyIsNormal()) { // เงื่อนไขการซื้อแบบปกติ
                        JSxPromotionStep3GetPmtCBInTmp(1, false);
                    }
                    JSvPromotionStep5UpdatePmtCBStaCalSumInTemp(false, false);
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
     * Functionality : Delete PMT_CB In Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3DeletePmtCBInTemp(ptGroupName) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();
            var tGroupName = ptGroupName;

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep3DeletePmtCBInTmp",
                data: {
                    tBchCode: tBchCode,
                    tGroupNameInBuy: tGroupName, // Group Name for Remove
                    tPbyStaBuyCond: tPbyStaBuyCond // เงื่อนไขการซื้อ
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    if (JSbPromotionConditionBuyIsRange()) { // เงื่อนไขการซื้อแบบช่วง
                        JSxPromotionStep3GetPmtCBWithPmtCGInTmp(1, false);
                    }
                    if (JSbPromotionConditionBuyIsNormal()) { // เงื่อนไขการซื้อแบบปกติ
                        JSxPromotionStep3GetPmtCBInTmp(1, false);
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
    /*===== End PMT CB Table Process ===================================================*/

    /*===== Begin PMT CG Table Process =================================================*/
    /**
     * Functionality : Get PMT_CG in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3GetPmtCGInTmp(pnPage, pbUseLoading) {
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
                url: "promotionStep3GetPmtCGInTmp",
                data: {
                    tBchCode: tBchCode,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll,
                    bIsAlwPmtDisAvg: bIsAlwPmtDisAvg,
                    tStaBuyCond: $('#ocmPromotionPbyStaBuyCond').val()
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    $('.xCNPromotionStep3TableGroupGet').html(oResult.html);
                    if (JCNbPromotionStep3PmtCGTableIsEmpty()) {
                        $('#ocbPromotionStep3GroupGetControl').prop('checked', false);
                    } else {
                        $('#ocbPromotionStep3GroupGetControl').prop('checked', true);
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
     * Functionality : Insert PMT_CG to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3InsertPmtCGToTemp(ptGroupName) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            // console.log(JSvPromotionStep3GetPmtGroupNameBuyInStep2());
            // console.log(JSvPromotionStep3GetPmtGroupNameGetInStep2());

            var bConditionBuyIsRange = JSbPromotionConditionBuyIsRange();
            var bStaGrpPriorityIsPriceGroup = JSbPromotionStaGrpPriorityIsPriceGroup();
            // var bStaSpcGrpDisIsDisSomeGroup = JSbPromotionPmhStaSpcGrpDisIsDisSomeGroup();
            var tBchCode = $('#oetPromotionBchCode').val();
            var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();
            var tGroupName = ptGroupName;

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep3InsertPmtCGToTmp",
                data: {
                    tBchCode: tBchCode,
                    tConditionBuyIsRange: (bConditionBuyIsRange) ? 'true' : 'false',
                    tStaGrpPriorityIsPriceGroup: (bStaGrpPriorityIsPriceGroup) ? 'true' : 'false',
                    // tStaSpcGrpDisIsDisSomeGroup: (bStaSpcGrpDisIsDisSomeGroup)?'true':'false',
                    tGroupNameInGet: tGroupName, // Group Name for Add
                    tPbyStaBuyCond: tPbyStaBuyCond, // เงื่อนไขการซื้อ
                    bIsAlwPmtDisAvg: bIsAlwPmtDisAvg
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    if (JSbPromotionConditionBuyIsRange()) { // เงื่อนไขการซื้อแบบช่วง
                    }
                    if (JSbPromotionConditionBuyIsNormal()) { // เงื่อนไขการซื้อแบบปกติ
                        JSxPromotionStep3GetPmtCGInTmp(1, false);
                    }
                    JSvPromotionStep5UpdatePmtCGPgtStaGetEffectInTemp(false, false);
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
     * Functionality : Delete PMT_CG In Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3DeletePmtCGInTemp(ptGroupName) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();
            var tGroupName = ptGroupName;

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep3DeletePmtCGInTmp",
                data: {
                    tBchCode: tBchCode,
                    tGroupNameInGet: tGroupName, // Group Name for Remove
                    tPbyStaBuyCond: tPbyStaBuyCond // เงื่อนไขการซื้อ
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    if (JSbPromotionConditionBuyIsRange()) { // เงื่อนไขการซื้อแบบช่วง
                        // JSxPromotionStep3GetPmtCGWithPmtCGInTmp(1, false);
                    }
                    if (JSbPromotionConditionBuyIsNormal()) { // เงื่อนไขการซื้อแบบปกติ
                        JSxPromotionStep3GetPmtCGInTmp(1, false);
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
     * Functionality : Delete PMT_CG in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3ClearPmtCGInTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep3ClearPmtCGInTmp",
                data: {
                    tBchCode: tBchCode
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    JSxPromotionStep3GetPmtCGInTmp(1, false);
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
    function : มีข้อมูลในตาราง CG
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep3PmtCGTableIsEmpty() {
        var bStatus = true;
        nRowLength = $('.xCNPromotionStep3TableGroupGetContainer #otbPromotionStep3PmtCGTable .xCNPromotionStep3PmtCGRow').length;
        // console.log('nRowLength: ', nRowLength);
        if (nRowLength > 0) {
            bStatus = false;
        }
        return bStatus;
    }

    /**
     * Functionality : Update PmtCG UpdatePmtCGPgtStaGetTypeInTmp in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3PmtCGUpdatePmtCGPgtStaGetTypeInTmp(ptPgtStaGetType) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            // console.log('tPgtStaGetType: ', tPgtStaGetType);

            var tBchCode = $('#oetDepositBchCode').val();

            $.ajax({
                type: "POST",
                url: "promotionStep3UpdatePmtCGPgtStaGetTypeInTmp",
                data: {
                    tPgtStaGetType: ptPgtStaGetType,
                    tBchCode: tBchCode
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (JSbPromotionConditionBuyIsNormal()) {
                        JSxPromotionStep3GetPmtCGInTmp(1, false);
                    }

                    if (JSbPromotionConditionBuyIsRange()) {
                        JSxPromotionStep3GetPmtCBWithPmtCGInTmp(1, false);
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
    /*===== End PMT CG Table Process ===================================================*/

    /*===== Begin PMT CB and CG Table Process ==========================================*/
    /**
     * Functionality : Get PMT_CB and PMT_CG in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3GetPmtCBWithPmtCGInTmp(pnPage, pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();
            var tSearchAll = $('#oetPromotionPdtLayoutSearchAll').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "promotionStep3GetPmtCBWithPmtCGInTmp",
                data: {
                    tBchCode: tBchCode,
                    tPbyStaBuyCond: tPbyStaBuyCond,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll,
                    bIsAlwPmtDisAvg: bIsAlwPmtDisAvg
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    $('.xCNPromotionStep3TableGroupBuyWithGroupGet').html(oResult.html);
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
     * Functionality : Insert PMT_CB and PMT_CG to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3InsertPmtCBAndPmtCGToTemp(ptGroupName, pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            // console.log(JSvPromotionStep3GetPmtGroupNameBuyInStep2());
            // console.log(JSvPromotionStep3GetPmtGroupNameGetInStep2());
            var tPbyMaxValueLastRow = $(".xCNPromotionStep3RangeTbody .xCNPromotionStep3PmtCBWithPmtCGRow." + ptGroupName.replace(" ", "")).last().find(".xCNPromotionCBPbyMaxValue").val();
            var tBchCode = $('#oetPromotionBchCode').val();
            var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();
            var bStaGrpPriorityIsPriceGroup = JSbPromotionStaGrpPriorityIsPriceGroup();

            // JCNxOpenLoading();
            console.log("tPbyMaxValueLastRow: ", tPbyMaxValueLastRow);

            $.ajax({
                type: "POST",
                url: "promotionStep3InsertPmtCBAndPmtCGToTmp",
                data: {
                    tBchCode: tBchCode,
                    tGroupName: ptGroupName,
                    tPbyStaBuyCond: tPbyStaBuyCond, // เงื่อนไขการซื้อ
                    tStaGrpPriorityIsPriceGroup: (bStaGrpPriorityIsPriceGroup) ? 'true' : 'false',
                    tPbyMaxValueLastRow: (typeof tPbyMaxValueLastRow == undefined) ? 0 : tPbyMaxValueLastRow,
                    bIsAlwPmtDisAvg: bIsAlwPmtDisAvg
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    if (JSbPromotionConditionBuyIsRange()) { // เงื่อนไขการซื้อแบบช่วง
                        JSxPromotionStep3GetPmtCBWithPmtCGInTmp(1, pbUseLoading);
                        JSvPromotionStep5UpdatePmtCBStaCalSumInTemp(false, false);
                        JSvPromotionStep5UpdatePmtCGPgtStaGetEffectInTemp(false, false);
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
     * Functionality : Update CB and CB PerAvgDis in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3UpdatePmtCGAndPmtCBPerAvgDisInTmp(ptCBPerAvgDis, ptCGPerAvgDis) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetDepositBchCode').val();

            $.ajax({
                type: "POST",
                url: "promotionStep3UpdatePmtCGAndPmtCBPerAvgDisInTmp",
                data: {
                    tCBPerAvgDis: ptCBPerAvgDis,
                    tCGPerAvgDis: ptCGPerAvgDis,
                    tBchCode: tBchCode
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (JSbPromotionConditionBuyIsNormal()) {
                        JSxPromotionStep3GetPmtCBInTmp(1, false);
                        JSxPromotionStep3GetPmtCGInTmp(1, false);
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
    /*===== End PMT CB and CG Table Process ============================================*/

    /*===== Begin PMT Coupon Table Process =============================================*/
    /**
     * Functionality : Browse Coupon
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep3BrowseCoupon() {
        var tSesUsrLevel = '<?= $this->session->userdata('tSesUsrLevel') ?>';
        var tWhere = '';
        if (tSesUsrLevel != 'HQ') {
            var tUserLoginBchCode   = "<?= $this->session->userdata('tSesUsrBchCodeMulti') ?>";
            var tSesUsrAgnCode      = '<?= $this->session->userdata('tSesUsrAgnCode') ?>';
        }
        // option Brand
        window.oPromotionBrowseBrand = {
            Title: ['coupon/coupon/coupon', 'tCPNTitle'],
            Table: {
                Master: 'TFNTCouponHD',
                PK: 'FTCphDocNo',
                PKName: 'FTCpnName'
            },
            Join: {
                Table: ['TFNTCouponHD_L'],
                On: ['TFNTCouponHD.FTCphDocNo = TFNTCouponHD_L.FTCphDocNo AND TFNTCouponHD_L.FNLngID = ' + nLangEdits + ' LEFT JOIN TFNTCouponHDBch WITH(NOLOCK) ON TFNTCouponHDBch.FTCphDocNo = TFNTCouponHD.FTCphDocNo AND  TFNTCouponHDBch.FTBchCode = TFNTCouponHD.FTBchCode LEFT JOIN (SELECT FTBchCode,FTCphDocNo,SUM(FNCpdAlwMaxUse) AS FNCpdAlwMaxUse FROM TFNTCouponDT WITH(NOLOCK) GROUP BY FTBchCode,FTCphDocNo) TFNTCouponDT ON TFNTCouponHD.FTBchCode = TFNTCouponDT.FTBchCode AND TFNTCouponDT.FTCphDocNo = TFNTCouponHD.FTCphDocNo ']
            },
            Where: {
                Condition: [
                    function() {
                        // tSQL = "  AND (TFNTCouponHD.FTBchCode = " + $('#oetPromotionBchCode').val() + " OR TFNTCouponHDBch.FTCphBchTo = " + $('#oetPromotionBchCode').val() + ") AND TFNTCouponHDBch.FTCphStaType = '1' AND TFNTCouponHD.FTCphStaApv = '1' AND TFNTCouponHD.FTCphStaClosed = '1' AND (CONVERT(VARCHAR(10), TFNTCouponHD.FDCphDateStop, 121) >= CONVERT(VARCHAR(10), GETDATE(), 121))  AND TFNTCouponDT.FNCpdAlwMaxUse > 0 ";
                        tSQL = "  AND (TFNTCouponHD.FTBchCode = " + $('#oetPromotionBchCode').val() + " OR TFNTCouponHDBch.FTCphBchTo = " + $('#oetPromotionBchCode').val() + ") AND TFNTCouponHD.FTCphStaApv = '1' AND TFNTCouponHD.FTCphStaClosed = '1' AND (CONVERT(VARCHAR(10), TFNTCouponHD.FDCphDateStop, 121) >= CONVERT(VARCHAR(10), GETDATE(), 121))";
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'coupon/coupon/coupon',
                ColumnKeyLang: ['tCPNTBCpnCode', 'tCPNTBCpnName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TFNTCouponHD.FTCphDocNo', 'TFNTCouponHD_L.FTCpnName'],
                DistinctField: [0],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TFNTCouponHD.FTCphDocNo'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetPromotionStep3CouponCode", "TFNTCouponHD.FTCphDocNo"],
                Text: ["oetPromotionStep3CouponName", "TFNTCouponHD_L.FTCpnName"],
            },
            BrowseLev: 1,
            // DebugSQL: true
        }
        JCNxBrowseData('oPromotionBrowseBrand');
    }

    /**
     * Functionality : Get Coupon in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3GetCouponInTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            $.ajax({
                type: "POST",
                url: "promotionStep3GetCouponInTmp",
                data: {
                    tBchCode: tBchCode
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    if (oResult != null) {
                        $('#ocbPromotionStep3CouponControl').prop('checked', true);
                        $('#ocmPromotionStep3PgtStaCoupon').prop('disabled', false);
                        $('#ocmPromotionStep3PgtStaCoupon').val(oResult.FTPgtStaCoupon).selectpicker("refresh");
                        $('#obtPromotionBrowseCoupon').prop('disabled', false);

                        if (oResult.FTPgtStaCoupon == "3") { // การให้สิทธิ์ 1:ไม่กำหนด 2:.ให้สิทธิ์คูปอง 3:ข้อความ
                            $('#oetPromotionStep3PgtCpnText').val(oResult.FTPgtCpnText);
                            $('.xCNPromotionStep3BrowseCouponContainer').hide();
                            $('.xCNPromotionStep3PgtCpnTextContainer').show();
                        } else {
                            $('#oetPromotionStep3CouponName').val(oResult.FTCphDocName);
                            $('#oetPromotionStep3CouponCode').val(oResult.FTCphDocNo);
                            $('.xCNPromotionStep3BrowseCouponContainer').show();
                            $('.xCNPromotionStep3PgtCpnTextContainer').hide();
                        }
                    } else {
                        $('#ocbPromotionStep3CouponControl').prop('checked', false);
                        $('#ocmPromotionStep3PgtStaCoupon').prop('disabled', true);
                        $('#ocmPromotionStep3PgtStaCoupon').val('2').selectpicker("refresh");
                        $('#obtPromotionBrowseCoupon').prop('disabled', true);
                        $('#oetPromotionStep3CouponName').val("");
                        $('#oetPromotionStep3CouponCode').val("");
                    }

                    if (bIsApvOrCancel) {
                        $('#ocmPromotionStep3PgtStaCoupon').prop('disabled', true);
                        $('#ocmPromotionStep3PgtStaCoupon').selectpicker("refresh");
                        $('#obtPromotionBrowseCoupon').prop('disabled', true);
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
     * Functionality : Insert or Update Coupon to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3InsertOrUpdateCouponToTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPgtStaCoupon = $('#ocmPromotionStep3PgtStaCoupon').val();
            var tCphDocNo = $('#oetPromotionStep3CouponCode').val();
            var tCphDocName = $('#oetPromotionStep3CouponName').val();
            var tPgtCpnText = $('#oetPromotionStep3PgtCpnText').val();

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep3InsertOrUpdateCouponToTmp",
                data: {
                    tBchCode: tBchCode,
                    tCphDocNo: tCphDocNo, // รหัสเอกสารคูปอง (Bar in DT)
                    tCphDocName: tCphDocName, // ชื่อเอกสารคูปอง (Bar in DT)
                    tPgtCpnText: tPgtCpnText,
                    tPgtStaCoupon: tPgtStaCoupon, // การให้สิทธิ์ 1:ไม่กำหนด 2:.ให้สิทธิ์คูปอง 3:ข้อความ
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {},
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
     * Functionality : Delete Coupon to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3DeleteCouponInTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep3DeleteCouponInTmp",
                data: {
                    tBchCode: tBchCode
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {},
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }
    /*===== End PMT Coupon Table Process ===============================================*/

    /*===== Begin PMT Point Table Process ==============================================*/
    /**
     * Functionality : Get Point in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3GetPointInTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            $.ajax({
                type: "POST",
                url: "promotionStep3GetPointInTmp",
                data: {
                    tBchCode: tBchCode
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    if (oResult != null) {
                        $('#oetPromotionStep3PgtPntGet').val(oResult.FNPgtPntGet);
                        $('#oetPromotionStep3PgtPntBuy').val(oResult.FNPgtPntBuy);
                        $('#ocbPromotionStep3PointControl').prop('checked', true);
                        $('#ocmPromotionStep3PgtStaPoint').prop('disabled', false);
                        $('#ocmPromotionStep3PgtStaPoint').val(oResult.FTPgtStaPoint).selectpicker("refresh");

                        $('#ocmPromotionStep3PgtStaPntCalType').prop('disabled', false);
                        $('#ocmPromotionStep3PgtStaPntCalType').val(oResult.FTPgtStaPntCalType).selectpicker("refresh");

                        $('#oetPromotionStep3PgtPntBuy').prop('disabled', false);
                        $('#oetPromotionStep3PgtPntGet').prop('disabled', false);
                        $('#oetPromotionSplCode').val(oResult.FTSplCode)
                        $('#oetPromotionSplName').val(oResult.FTSplName)
                        $('#obtPromotionBrowseSpl').prop('disabled', false);
                        $('#oetPromotionStep3DateStart').val(oResult.FDPgtPntStart).prop('disabled', false);
                        $('#obtPmtDateStart').prop('disabled', false);
                        $('#oetPromotionStep3DateEnd').val(oResult.FDPgtPntExpired).prop('disabled', false);
                        $('#obtPmtDateEnd').prop('disabled', false);

                        JSvPromotionStep3InsertOrUpdatePointToTemp();
                    } else {
                        $('#ocbPromotionStep3PointControl').prop('checked', false);
                        $('#ocmPromotionStep3PgtStaPoint').prop('disabled', true);
                        $('#ocmPromotionStep3PgtStaPoint').val('2').selectpicker("refresh");

                        $('#ocmPromotionStep3PgtStaPntCalType').prop('disabled', true);
                        $('#ocmPromotionStep3PgtStaPntCalType').val('1').selectpicker("refresh");

                        $('#oetPromotionStep3PgtPntBuy').prop('disabled', true);
                        $('#oetPromotionStep3PgtPntGet').prop('disabled', true);
                        $('#oetPromotionStep3PgtPntBuy').val("");
                        $('#oetPromotionStep3PgtPntGet').val("");
                        $('#oetPromotionSplCode').val("")
                        $('#oetPromotionSplName').val("")
                        $('#obtPromotionBrowseSpl').prop('disabled', true);
                        $('#oetPromotionStep3DateStart').val("").prop('disabled', true);
                        $('#obtPmtDateStart').prop('disabled', true);
                        $('#oetPromotionStep3DateEnd').val("").prop('disabled', true);
                        $('#obtPmtDateEnd').prop('disabled', true);

                        JSvPromotionStep3DeletePointInTemp();
                    }

                    if (bIsApvOrCancel) {
                        $('#ocmPromotionStep3PgtStaPoint').prop('disabled', true);
                        $('#ocmPromotionStep3PgtStaPoint').selectpicker("refresh");
                        $('#ocmPromotionStep3PgtStaPntCalType').prop('disabled', true);
                        $('#ocmPromotionStep3PgtStaPntCalType').selectpicker("refresh");
                        $('#oetPromotionStep3PgtPntGet').prop('disabled', true);
                        $('#oetPromotionStep3PgtPntBuy').prop('disabled', true);
                        $('#oetPromotionSplCode').val("")
                        $('#oetPromotionSplName').val("")
                        $('#obtPromotionBrowseSpl').prop('disabled', true);
                        $('#oetPromotionStep3DateStart').val("").prop('disabled', true);
                        $('#obtPmtDateStart').prop('disabled', true);
                        $('#oetPromotionStep3DateEnd').val("").prop('disabled', true);
                        $('#obtPmtDateEnd').prop('disabled', true);
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
     * Functionality : Insert or Update Point to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3InsertOrUpdatePointToTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPgtStaPoint = $('#ocmPromotionStep3PgtStaPoint').val();
            var tPgtStaPntCalType = $('#ocmPromotionStep3PgtStaPntCalType').val();
            var tPgtPntBuy = $('#oetPromotionStep3PgtPntBuy').val();
            var tPgtPntGet = $('#oetPromotionStep3PgtPntGet').val();
            var tPgtSplCode = $('#oetPromotionSplCode').val();
            var tPgtDateStart = $('#oetPromotionStep3DateStart').val();
            var tPgtDateEnd = $('#oetPromotionStep3DateEnd').val();

            $.ajax({
                type: "POST",
                url: "promotionStep3InsertOrUpdatePointToTmp",
                data: {
                    tBchCode: tBchCode,
                    tPgtPntBuy: tPgtPntBuy, // อัตราส่วนแต้มที่จะได้รับ
                    tPgtPntGet: tPgtPntGet, // จำนวนที่จะได้รับ
                    tPgtStaPoint: tPgtStaPoint, // การให้สิทธิ์ 1:ไม่กำหนด 2:.ให้สิทธิ์คูปอง 3:ข้อความ
                    tPgtStaPntCalType: tPgtStaPntCalType, // การคำนวณตาม 1:มูลค่า 2:จำนวน
                    tPgtSplCode: tPgtSplCode, //รหัสผู้จำหน่าย
                    tPgtDateStart: tPgtDateStart, //วันที่มีผล
                    tPgtDateEnd: tPgtDateEnd //วันที่หมดอายุ

                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {},
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
     * Functionality : Delete Point to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3DeletePointInTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep3DeletePointInTmp",
                data: {
                    tBchCode: tBchCode
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {},
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }
    /*===== End PMT Point Table Process ================================================*/

    /**
     * Functionality : Get PmtGroupNameBuy in Step2
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3GetPmtGroupNameBuyInStep2() {
        var oGroupNameInBuy = $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item, .xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType2Item');
        var aGroupNameInBuy = [];
        $.each(oGroupNameInBuy, function(nIndex, oItem) {
            var tGroupName = $(oItem).data('grpname');
            aGroupNameInBuy.push(tGroupName);
        });

        return aGroupNameInBuy;
    }

    /**
     * Functionality : Get PmtGroupNameGet in Step2
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep3GetPmtGroupNameGetInStep2() {
        var oGroupNameInGet = $('.xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item, .xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType2Item');
        var aGroupNameInGet = [];
        $.each(oGroupNameInGet, function(nIndex, oItem) {
            var tGroupName = $(oItem).data('grpname');
            aGroupNameInGet.push(tGroupName);
        });

        return aGroupNameInGet;
    }

    /*
    function : ตรวจสอบข้อมูล Coupon ก่อน Next Step
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep3CouponIsValid() {
        var bStatus = false;

        var bCouponControlIsChecked = $('#ocbPromotionStep3CouponControl').is(':checked');
        var bCouponCodeIsEmpty = $('#oetPromotionStep3CouponCode').val() == "";
        var bPgtCpnTextIsEmpty = $('#oetPromotionStep3PgtCpnText').val() == "";
        var bIsPgtCpnTextType = $('#ocmPromotionStep3PgtStaCoupon').val() == "3";


        if (!bCouponControlIsChecked || (!bCouponCodeIsEmpty || !bPgtCpnTextIsEmpty)) {
            bStatus = true;
        }
        // console.log(('JCNbPromotionStep3CouponIsValid: ', bStatus);
        return bStatus;
    }

    /*
    function : ตรวจสอบข้อมูล Point ก่อน Next Step
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep3PointIsValid() {
        var bStatus = false;

        var bPointControlIsChecked = $('#ocbPromotionStep3PointControl').is(':checked');
        var bPgtPntBuyIsEmpty = $('#oetPromotionStep3PgtPntBuy').val() == "";
        var bPgtGetQtyIsEmpty = $('#oetPromotionStep3PgtPntGet').val() == "";
        if (!bPointControlIsChecked || (!bPgtPntBuyIsEmpty && !bPgtGetQtyIsEmpty)) {
            bStatus = true;
        }
        // console.log(('JCNbPromotionStep3PointIsValid: ', bStatus);
        return bStatus;
    }

    /*
    function : ตรวจสอบข้อมูล % เฉลี่ยส่วนลด ก่อน Next Step
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep3AvgDisPercentIsValid() {
        if (JSbPromotionConditionBuyIsRange() || !bIsAlwPmtDisAvg /*|| JSbPromotionPmhStaSpcGrpDisIsDisSomeGroup()*/ ) {
            return true;
        } // ไม่มีการตรวจสอบข้อมูล % เฉลี่ยส่วนลด ในเงื่อนไขแบบการซื้อแบบช่วง

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var bStatus = false;

            $.ajax({
                type: "POST",
                url: "promotionStep3GetPmtCBAndPmtCGPgtPerAvgDisInTmp",
                data: {},
                cache: false,
                timeout: 5000,
                async: false,
                success: function(oResult) {
                    console.log('oResult.cPgtPerAvgDis: ', oResult.cPgtPerAvgDis == 100);
                    if (oResult.cPgtPerAvgDis == 100) {
                        bStatus = true;
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
        return bStatus;
    }

    $("#obtPromotionBrowseSpl").click(function() {
        // option
        window.oPromotionBrowseBch = {
            Title: ['supplier/supplier/supplier', 'tSPLTitle'],
            Table: {
                Master: 'TCNMSpl',
                PK: 'FTSplCode'
            },
            Join: {
                Table: ['TCNMSpl_L'],
                On: ['TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: []
            },
            GrideView: {
                ColumnPathLang: 'supplier/supplier/supplier',
                ColumnKeyLang: ['tCode', 'tName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMSpl.FTSplCode', 'TCNMSpl_L.FTSplName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMSpl.FTSplCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetPromotionSplCode", "TCNMSpl.FTSplCode"],
                Text: ["oetPromotionSplName", "TCNMSpl_L.FTSplName"]
            },
        };
        JCNxBrowseData('oPromotionBrowseBch');
    });
</script>