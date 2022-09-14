<script>
    $(document).ready(function() {

        $("input #ocbPromotionStep3PointControl").attr("disabled", true);
        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: false,
            immediateUpdates: false,
        });

        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm:ss'
        });

        $('#obtPmtDocDate').click(function() {
            event.preventDefault();
            $('#oetPromotionDocDate').datepicker('show');
        });

        $('#obtPmtDocTime').click(function() {
            event.preventDefault();
            $('#oetPromotionDocTime').datetimepicker('show');
        });

        $('#obtPmtDocDateFrom').click(function() {
            event.preventDefault();
            $('#oetPromotionPmhDStart').datepicker('show');
        });

        $('#obtPmtDocDateTo').click(function() {
            event.preventDefault();
            $('#oetPromotionPmhDStop').datepicker('show');
        });

        $('#obtPmtDocTimeFrom').click(function() {
            event.preventDefault();
            $('#oetPromotionPmhTStart').datetimepicker('show');
        });

        $('#obtPmtDocTimeTo').click(function() {
            event.preventDefault();
            $('#oetPromotionPmhTStop').datetimepicker('show');
        });

        $('.xWTooltipsBT').tooltip({
            'placement': 'bottom'
        });

        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });

        $('#ocbPromotionAutoGenCode').unbind().bind('change', function() {
            var bIsChecked = $('#ocbPromotionAutoGenCode').is(':checked');
            var oInputDocNo = $('#oetPromotionDocNo');
            if (bIsChecked) {
                $(oInputDocNo).attr('readonly', true);
                $(oInputDocNo).attr('disabled', true);
                $(oInputDocNo).val("");
                $(oInputDocNo).parents('.form-group').removeClass('has-error').find('em').hide();
            } else {
                $(oInputDocNo).removeAttr('readonly');
                $(oInputDocNo).removeAttr('disabled');
            }
        });

        if (bIsApvOrCancel && !bIsAddPage) {
            $('#obtPromotionApprove').hide();
            $('#obtPromotionCancel').hide();
            $('#odvBtnAddEdit .btn-group').hide();
            $('form .xCNApvOrCanCelDisabled').attr('disabled', true);
        } else {
            $('#odvBtnAddEdit .btn-group').show();
        }

        if (bIsCancel) {
            $('form .xCNCanCelDisabled').attr('disabled', true);
        } else {
            $('#odvBtnAddEdit .btn-group').show();
        }

        if (!bIsAddPage) {
            if (JSbPromotionConditionBuyIsRange()) { // เงื่อนไขการซื้อแบบช่วง
                JSxPromotionStep3GetPmtCBWithPmtCGInTmp(1, false);
            }
            if (JSbPromotionConditionBuyIsNormal()) { // เงื่อนไขการซื้อแบบปกติ
                JSxPromotionStep3GetPmtCBInTmp(1, false);
                JSxPromotionStep3GetPmtCGInTmp(1, false);
            }
        }
        JSxPromotionStep4GetCheckAndConfirmPage(false);

        /*===== Begin Control สาขาที่สร้าง ================================================*/
        // if ((tUserLoginLevel == "HQ") || (!bIsAddPage) || (!bIsMultiBch)) {
        //     $("#obtPromotionBrowseBch").attr('disabled', true);
        // }
        var tUsrLevel = '<?= $this->session->userdata('tSesUsrLevel') ?>';
        if (tUsrLevel != "HQ") {
            var tBchCount = <?php echo $this->session->userdata("nSesUsrBchCount"); ?>;
            if (tBchCount < 2) {
                $('#obtPromotionBrowseBch').addClass('disabled');
                $('#obtPromotionBrowseBch').css('pointer-events', 'none');
                $('#obtPromotionBrowseBch').attr('disabled', true);
            }
        }
        /*===== End Control สาขาที่สร้าง ==================================================*/

        $(document).on('keyup keypress', 'form input[type="text"], form input[type="time"], form input[type="number"]', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                return false;
            }
        });

        /*===== Begin Step Form Page Control ===========================================*/
        $('.xCNPromotionCircle').on('click', function() {
            var tTab = $(this).data('tab');
            $('.xCNPromotionNextStep').prop('disabled', false);
            $('.xCNPromotionBackStep').prop('disabled', false);

            switch (tTab) {
                case "odvPromotionStep1": {
                    $('.xCNPromotionBackStep').prop('disabled', true);

                    $('.xCNPromotionStep1').css("background", "#fff");
                    $('.xCNPromotionStep2').css("background", "#d6d6d6");
                    $('.xCNPromotionStep3').css("background", "#d6d6d6");
                    $('.xCNPromotionStep4').css("background", "#d6d6d6");
                    $('.xCNPromotionStep5').css("background", "#d6d6d6");

                    $('.xCNPromotionStep1').css('border', '2px solid #000');
                    $('.xCNPromotionStep2').css('border', '2px solid #d6d6d6');
                    $('.xCNPromotionStep3').css('border', '2px solid #d6d6d6');
                    $('.xCNPromotionStep4').css('border', '2px solid #d6d6d6');
                    $('.xCNPromotionStep5').css('border', '2px solid #d6d6d6');

                    $('#odvPromotionLine').css("background", "#d6d6d6");
                    break;
                }
                case "odvPromotionStep2": {
                    if (!JCNbPromotionStep1IsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg20'); ?>'; // กรุณาตรวจสอบข้อมูล สร้างกลุ่ม/สินค้า
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $('.xCNPromotionBackStep').prop('disabled', true);
                        $(".xCNPromotionTabContent #odvPromotionStep1").addClass("active").addClass("in");
                        return;
                    }

                    JSxPromotionStep2GetPmtDtGroupNameInTmp(1, false, 1);
                    JSxPromotionStep2GetPmtDtGroupNameInTmp(1, false, 2);

                    $('.xCNPromotionStep1').css("background", "#000");
                    $('.xCNPromotionStep2').css("background", "#fff");
                    $('.xCNPromotionStep3').css("background", "#d6d6d6");
                    $('.xCNPromotionStep4').css("background", "#d6d6d6");
                    $('.xCNPromotionStep5').css("background", "#d6d6d6");

                    $('.xCNPromotionStep1').css('border', '2px solid #000');
                    $('.xCNPromotionStep2').css('border', '2px solid #000');
                    $('.xCNPromotionStep3').css('border', '2px solid #d6d6d6');
                    $('.xCNPromotionStep4').css('border', '2px solid #d6d6d6');
                    $('.xCNPromotionStep5').css('border', '2px solid #d6d6d6');

                    $('#odvPromotionLine').css("background", "linear-gradient(to right, black 25%, #d6d6d6 20% 40%)");
                    break;
                }
                case "odvPromotionStep3": {
                    if (!JCNbPromotionStep1IsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg20'); ?>'; // กรุณาตรวจสอบข้อมูล สร้างกลุ่ม/สินค้า
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep1").addClass("active").addClass("in");
                        return;
                    }
                    if (!JCNbPromotionStep2IsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg21'); ?>'; // กรุณาตรวจสอบข้อมูล กำหนดกลุ่ม ซื้อ-รับ
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep2").addClass("active").addClass("in");
                        return;
                    }

                    if (JSbPromotionConditionBuyIsRange()) { // เงื่อนไขการซื้อแบบช่วง
                        $('.xCNPromotionStep3TableGroupBuyContainer').hide();
                        $('.xCNPromotionStep3TableGroupBuyWithGroupGetContainer').show();
                        $('.xCNPromotionStep3TableGroupGetContainer').hide();
                    }
                    if (JSbPromotionConditionBuyIsNormal()) { // เงื่อนไขการซื้อแบบปกติ
                        $('.xCNPromotionStep3TableGroupBuyContainer').show();
                        $('.xCNPromotionStep3TableGroupBuyWithGroupGetContainer').hide();
                        $('.xCNPromotionStep3TableGroupGetContainer').show();
                    }

                    $('.xCNPromotionStep1').css("background", "#000");
                    $('.xCNPromotionStep2').css("background", "#000");
                    $('.xCNPromotionStep3').css("background", "#fff");
                    $('.xCNPromotionStep4').css("background", "#d6d6d6");
                    $('.xCNPromotionStep5').css("background", "#d6d6d6");

                    $('.xCNPromotionStep1').css('border', '2px solid #000');
                    $('.xCNPromotionStep2').css('border', '2px solid #000');
                    $('.xCNPromotionStep3').css('border', '2px solid #000');
                    $('.xCNPromotionStep4').css('border', '2px solid #d6d6d6');
                    $('.xCNPromotionStep5').css('border', '2px solid #d6d6d6');

                    $('#odvPromotionLine').css("background", "linear-gradient(to right, black 50%, #d6d6d6 20% 40%)");
                    break;
                }
                case "odvPromotionStep4": {
                    if (!JCNbPromotionStep1IsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg20'); ?>'; // กรุณาตรวจสอบข้อมูล สร้างกลุ่ม/สินค้า
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep1").addClass("active").addClass("in");
                        return;
                    }
                    if (!JCNbPromotionStep2IsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg21'); ?>'; // กรุณาตรวจสอบข้อมูล กำหนดกลุ่ม ซื้อ-รับ
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep2").addClass("active").addClass("in");
                        return;
                    }
                    if (!JCNbPromotionStep3AvgDisPercentIsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg22'); ?>'; // กรุณาตรวจสอบข้อมูล % เฉลี่ยส่วนลด
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep3").addClass("active").addClass("in");
                        return;
                    }
                    if (!JCNbPromotionStep3CouponIsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg23'); ?>'; // กรุณาตรวจสอบข้อมูล กำหนดเงื่อนไขกลุ่ม (เงื่อนไข - สิทธิประโยชน์คูปอง)
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep3").addClass("active").addClass("in");
                        return;
                    }
                    if (!JCNbPromotionStep3PointIsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg24'); ?>'; // กรุณาตรวจสอบข้อมูล กำหนดเงื่อนไขกลุ่ม (เงื่อนไข - สิทธิประโยชน์แต้ม)
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep3").addClass("active").addClass("in");
                        return;
                    }

                    JSxPromotionStep4GetPdtPmtHDCstPriInTmp(1, false);
                    JSxPromotionStep4GetPdtPmtHDBchInTmp(1, false);
                    JSxPromotionStep4GetHDChnInTmp(1, false);
                    JSxPromotionStep4GetPdtPmtHDCstLevInTmp(1, false);

                    $('.xCNPromotionStep1').css("background", "#000");
                    $('.xCNPromotionStep2').css("background", "#000");
                    $('.xCNPromotionStep3').css("background", "#000");
                    $('.xCNPromotionStep4').css("background", "#fff");
                    $('.xCNPromotionStep5').css("background", "#d6d6d6");

                    $('.xCNPromotionStep1').css('border', '2px solid #000');
                    $('.xCNPromotionStep2').css('border', '2px solid #000');
                    $('.xCNPromotionStep3').css('border', '2px solid #000');
                    $('.xCNPromotionStep4').css('border', '2px solid #000');
                    $('.xCNPromotionStep5').css('border', '2px solid #d6d6d6')

                    $('#odvPromotionLine').css("background", "linear-gradient(to right, black 75%, #d6d6d6 20% 40%)");
                    break;
                }
                case "odvPromotionStep5": {
                    if (!JCNbPromotionStep1IsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg20'); ?>'; // กรุณาตรวจสอบข้อมูล สร้างกลุ่ม/สินค้า
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep1").addClass("active").addClass("in");
                        return;
                    }
                    if (!JCNbPromotionStep2IsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg21'); ?>'; // กรุณาตรวจสอบข้อมูล กำหนดกลุ่ม ซื้อ-รับ
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep2").addClass("active").addClass("in");
                        return;
                    }
                    if (!JCNbPromotionStep3AvgDisPercentIsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg22'); ?>'; // กรุณาตรวจสอบข้อมูล % เฉลี่ยส่วนลด
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep3").addClass("active").addClass("in");
                        return;
                    }
                    if (!JCNbPromotionStep3CouponIsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg23'); ?>'; // กรุณาตรวจสอบข้อมูล กำหนดเงื่อนไขกลุ่ม (เงื่อนไข - สิทธิประโยชน์คูปอง)
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep3").addClass("active").addClass("in");
                        return;
                    }
                    if (!JCNbPromotionStep3PointIsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg24'); ?>'; // กรุณาตรวจสอบข้อมูล กำหนดเงื่อนไขกลุ่ม (เงื่อนไข - สิทธิประโยชน์แต้ม)
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        $(".xCNPromotionTabContent #odvPromotionStep3").addClass("active").addClass("in");
                        return;
                    }


                    JSxPromotionStep4GetCheckAndConfirmPage(false);
                    $('.xCNPromotionStep1').css("background", "#000");
                    $('.xCNPromotionStep2').css("background", "#000");
                    $('.xCNPromotionStep3').css("background", "#000");
                    $('.xCNPromotionStep4').css("background", "#000");
                    $('.xCNPromotionStep5').css("background", "#fff");

                    $('.xCNPromotionStep1').css('border', '2px solid #000');
                    $('.xCNPromotionStep2').css('border', '2px solid #000');
                    $('.xCNPromotionStep3').css('border', '2px solid #000');
                    $('.xCNPromotionStep4').css('border', '2px solid #000');
                    $('.xCNPromotionStep5').css('border', '2px solid #000')
                    $('#odvPromotionLine').css("background", "linear-gradient(to right, black 100%, #d6d6d6 20% 40%)");
                    $('.xCNPromotionNextStep').prop('disabled', true);
                    break;
                }
                default: {}
            }

            $('.xCNPromotionCircle').removeClass('active');
            $(this).addClass('active');
            // $('a[href="#'+tTab+'"]').tab('show');
            $(".xCNPromotionTabContent .tab-pane").removeClass('active').removeClass('in');
            $(".xCNPromotionTabContent #" + tTab).addClass("active").addClass("in");
        });
        /*===== End Step Form Page Control =============================================*/

        /*===== Begin Step Form Page Control Btn =======================================*/
        // Next
        $('.xCNPromotionNextStep').on('click', function() {
            var tStepNow = $('#odvPromotionLine .xCNPromotionCircle.active').data('step');
            // console.log(('tStepNow: ', tStepNow);

            if (tStepNow < "5") {
                $(".xCNPromotionTabContent .tab-pane").removeClass('active').removeClass('in');
                if (tStepNow == '1') {

                }
                if (tStepNow == '2') {

                }
                if (tStepNow == '3') {

                }
                if (tStepNow == '4') {
                    $('#odvPromotionLine').css("background", "linear-gradient(to right, black 100%, #d6d6d6 20% 40%)");
                    $('.xCNPromotionStep1').css("background", "black");
                    $('.xCNPromotionStep2').css("background", "black");
                    $('.xCNPromotionStep3').css("background", "black");
                    $('.xCNPromotionStep4').css("background", "black");

                    $('.xCNPromotionStep1').css('border', '2px solid black');
                    $('.xCNPromotionStep2').css('border', '2px solid black');
                    $('.xCNPromotionStep3').css('border', '2px solid black');
                    $('.xCNPromotionStep4').css('border', '2px solid black');
                }
                setTimeout(function() {
                    $('.xCNPromotionCircle.xCNPromotionStep' + (tStepNow + 1)).trigger('click');
                }, 100);
            }
        });

        // Back
        $('.xCNPromotionBackStep').on('click', function() {
            var tStepNow = $('#odvPromotionLine .xCNPromotionCircle.active').data('step');
            // console.log(('tStepNow: ', tStepNow);

            if (tStepNow > "1") {
                $(".xCNPromotionTabContent .tab-pane").removeClass('active').removeClass('in');
                setTimeout(function() {
                    $('.xCNPromotionCircle.xCNPromotionStep' + (tStepNow - 1)).trigger('click');
                }, 100);
            }
        });
        /*===== End Step Form Page Control Btn =========================================*/

        /*===== Begin ocmPromotionPbyStaBuyCond(เงื่อนไขการซื้อ) Control ===================*/
        var tPbyStaBuyCondBeforeChangeVal;
        $("button[data-id='ocmPromotionPbyStaBuyCond']").on('click', function() {
            tPbyStaBuyCondBeforeChangeVal = $(this).parents('.bootstrap-select').find('#ocmPromotionPbyStaBuyCond').val();
        });

        $('#ocmPromotionPbyStaBuyCond').on('change', function() {
            if (!JCNbPromotionStep1PmtDtGroupNameTableIsEmpty()) {
                var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg19'); ?>'; // ล้างข้อมูลหลังจากเปลี่ยนเงื่อนไขการซื้อ ต้องการดำเนินการต่อหรือไม่
                FSvCMNSetMsgWarningDialog(tWarningMessage, 'FSxPromotionAfterChangePbyStaBuyCond', '', true);
                $('#odvModalWanning .xWBtnCancel').on('click', function(event) {
                    $('#ocmPromotionPbyStaBuyCond').val(tPbyStaBuyCondBeforeChangeVal).selectpicker('refresh');
                });
            }
            JSxPromotionStep4GetCheckAndConfirmPage(false);
        });

        /**
         * Functionality : Action After Change PbyStaBuyCond
         * Parameters : -
         * Creator : 04/02/2020 Piya
         * Return : -
         * Return Type : -
         */
        window.FSxPromotionAfterChangePbyStaBuyCond = function() {
            // To Step 1
            $('.xCNPromotionCircle.xCNPromotionStep1').trigger('click');

            // Clear กลุ่มซื้อ,กลุ่มรับ Step2
            $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item .close').click();
            $('.xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item .close').click();
        }
        /*===== End ocmPromotionPbyStaBuyCond(เงื่อนไขการซื้อ) Control =====================*/

        /*===== Begin ocmPromotionPmhStaGrpPriority(กลุ่มคำนวนโปรโมชั่น) Control ===========*/
        var tPmhStaGrpPriorityBeforeChangeVal;
        $("button[data-id='ocmPromotionPmhStaGrpPriority']").on('click', function() {
            tPmhStaGrpPriorityBeforeChangeVal = $(this).parents('.bootstrap-select').find('#ocmPromotionPmhStaGrpPriority').val();
        });

        $('#ocmPromotionPmhStaGrpPriority').on('change', function() {
            if (JSbPromotionStaGrpPriorityIsPriceGroup()) {
                JSxPromotionStep3PmtCGUpdatePmtCGPgtStaGetTypeInTmp("4");
            } else {
                if (tPmhStaGrpPriorityBeforeChangeVal == "0") { // ค่าเดิมเป็น Price Group หรือไม่
                    JSxPromotionStep3PmtCGUpdatePmtCGPgtStaGetTypeInTmp("1")
                }
            }
        });
        /*===== End ocmPromotionPmhStaGrpPriority(กลุ่มคำนวนโปรโมชั่น) Control =============*/

        /*===== Begin ocbPromotionPmhStaSpcGrpDis(ใช้เฉลี่ยส่วนลดกลุ่มรับอัตโนมัติ) Control ========*/
        /* $('#ocbPromotionPmhStaSpcGrpDis').on('change', function(){
            if(JSbPromotionConditionBuyIsNormal()){
                if(JSbPromotionPmhStaSpcGrpDisIsDisSomeGroup()){
                    $("#otbPromotionStep3PmtCBTable .xCNPromotionPgtPerAvgDisCB").attr("disabled", true);
                    $("#otbPromotionStep3PmtCGTable .xCNPromotionPgtPerAvgDisCG").attr("disabled", true);
                    JSxPromotionStep3UpdatePmtCGAndPmtCBPerAvgDisInTmp("0", "0");
                }else{
                    $("#otbPromotionStep3PmtCBTable .xCNPromotionPgtPerAvgDisCB").attr("disabled", false);
                    $("#otbPromotionStep3PmtCGTable .xCNPromotionPgtPerAvgDisCG").attr("disabled", false);
                }
            }
        }); */
        /*===== End ocbPromotionPmhStaSpcGrpDis(ใช้เฉลี่ยส่วนลดกลุ่มรับอัตโนมัติ) Control =========*/

        /*===== Begin ocmPromotionPmhStaGetPdt(เงื่อนไขการเลือกสินค้า) Control ==============*/
        $('#ocmPromotionPmhStaGetPdt').on('change', function() {
            var bIsSelectedType3 = $(this).val() == "3"; // 1:ราคามากกว่า 2:ราคาน้อยกว่า 3:user เลือก
            if (bIsSelectedType3) {
                $('#obtPromotionBrowseRole').attr('disabled', false);
                $('#oetPromotionRoleCode').attr('disabled', false);
                $('#oetPromotionRoleName').attr('disabled', false);
            } else {
                $('#obtPromotionBrowseRole').attr('disabled', true);
                $('#oetPromotionRoleCode').attr('disabled', true);
                $('#oetPromotionRoleName').attr('disabled', true);
                $('#oetPromotionRoleCode').val("");
                $('#oetPromotionRoleName').val("");
            }
        });
        /*===== End ocmPromotionPmhStaGetPdt(เงื่อนไขการเลือกสินค้า) Control ================*/

        /*===== Begin ocbPromotionPmhStaLimitGet(จำกัดจำนวนครั้ง) Control =================*/
        $('#ocbPromotionPmhStaLimitGet').on('change', function() {
            var bIsChecked = $(this).is(':checked');

            if (bIsChecked) {
                $('#oetPromotionPmhLimitQty').attr('disabled', false);
                $('#ocmPromotionPmhStaLimitTime').attr('disabled', false);
                $('#ocmPromotionPmhStaChkLimit').attr('disabled', false);

                $("#ocmPromotionPmhStaLimitTime").selectpicker("refresh");
                $("#ocmPromotionPmhStaChkLimit").selectpicker("refresh");
            } else {
                $('#oetPromotionPmhLimitQty').attr('disabled', true);
                $('#oetPromotionPmhLimitQty').parents('.form-group').removeClass('has-error');
                $('#oetPromotionPmhLimitQty').parents('.form-group').find('em').empty();
                $('#ocmPromotionPmhStaLimitTime').attr('disabled', true);
                $('#ocmPromotionPmhStaChkLimit').attr('disabled', true);

                $("#ocmPromotionPmhStaLimitTime").selectpicker("refresh");
                $("#ocmPromotionPmhStaChkLimit").selectpicker("refresh");
            }
            JSxPromotionPmhSetStaLimitCst();
        });
        /*===== End ocbPromotionPmhStaLimitGet(จำกัดจำนวนครั้ง) Control ===================*/

        /*===== Begin ocbPromotionPmhStaChkCst(ตรวจสอบเงื่อนไขลูกค้า) Control ==============*/
        $('#ocbPromotionPmhStaChkCst').on('change', function() {
            var bIsChecked = $(this).is(':checked');

            if (bIsChecked) {
                $('#oetPromotionSpmMemAgeLT').attr('disabled', false);
                $('#oetPromotionPmhCstDobPrev').attr('disabled', false);
                $('#oetPromotionPmhCstDobNext').attr('disabled', false);

                $('#ocmPromotionSpmStaLimitCst').attr('disabled', false);
                $('#ocmPromotionSpmStaChkCstDOB').attr('disabled', false);

                $("#ocmPromotionSpmStaLimitCst").selectpicker("refresh");
                $("#ocmPromotionSpmStaChkCstDOB").selectpicker("refresh");
            } else {
                $('#oetPromotionSpmMemAgeLT').attr('disabled', true);
                $('#oetPromotionSpmMemAgeLT').parents('.form-group').removeClass('has-error');
                $('#oetPromotionSpmMemAgeLT').parents('.form-group').find('em').empty();
                $('#oetPromotionPmhCstDobPrev').attr('disabled', true);
                $('#oetPromotionPmhCstDobPrev').parents('.form-group').removeClass('has-error');
                $('#oetPromotionPmhCstDobPrev').parents('.form-group').find('em').empty();
                $('#oetPromotionPmhCstDobNext').attr('disabled', true);
                $('#oetPromotionPmhCstDobNext').parents('.form-group').removeClass('has-error');
                $('#oetPromotionPmhCstDobNext').parents('.form-group').find('em').empty();

                $('#ocmPromotionSpmStaLimitCst').attr('disabled', true);
                $('#ocmPromotionSpmStaChkCstDOB').attr('disabled', true);

                $("#ocmPromotionSpmStaLimitCst").selectpicker("refresh");
                $("#ocmPromotionSpmStaChkCstDOB").selectpicker("refresh");
            }
        });
        /*===== End ocbPromotionPmhStaChkCst(ตรวจสอบเงื่อนไขลูกค้า) Control ================*/

        /*===== Begin ocmPromotionPmhStaLimitCst(คิดต่อสมาชิก/ทั้งหมด) Control =============*/
        if (!bIsApvOrCancel) {
            if (JSbPromotionPmhStaLimitCstIsAll()) {
                $("#ocbPromotionStep3PointControl").attr('disabled', true);
            } else {
                $("#ocbPromotionStep3PointControl").attr('disabled', false);
            }
        }

        $('#ocmPromotionPmhStaLimitCst').on('change', function() {
            var nStaLimitCst = $('#ocmPromotionPmhStaLimitCst').val();
            if (JSbPromotionPmhStaLimitCstIsAll()) {
                var bPointControlIsChecked = $("#ocbPromotionStep3PointControl").is(":checked");
                if (bPointControlIsChecked) {
                    $("#ocbPromotionStep3PointControl")
                        .attr('checked', false)
                        .trigger('change').attr('disabled', true);
                }
            } else {
                $("#ocbPromotionStep3PointControl").attr('disabled', false);
            }
        });
        /*===== End ocbPromotionPmhStaChkCst(คิดต่อสมาชิก/ทั้งหมด) Control ================*/
        JSxPromotionPmhSetStaLimitCst();
    });

    var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tWhere = "";

    if (nCountBch == 1) {
        $('#oimBrowseBch').attr('disabled', true);
    }
    if (tUsrLevel != "HQ") {
        tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";
    } else {
        tWhere = "";
    }

    /*===== Begin Event Browse =========================================================*/
    // สาขาที่สร้าง
    $("#obtPromotionBrowseBch").click(function() {
        // option
        window.oPromotionBrowseBch = {
            Title: ['authen/user/user', 'tBrowseBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                // Condition: [" AND TCNMBranch.FTBchCode IN(<?php echo $this->session->userdata('tSesUsrBchCodeMulti'); ?>)"]
                Condition: [tWhere]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FTBchCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetPromotionBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetPromotionBchName", "TCNMBranch_L.FTBchName"]
            },
             NextFunc: {
                FuncName: 'JSxPromotionCallbackBch',
                ArgReturn: ['FTBchCode']
            }, 
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oPromotionBrowseBch');
    });


    function JSxPromotionCallbackBch(){
        $('#oetPromotionStep3CouponName').val('');
        $('#oetPromotionStep3CouponCode').val('');
    }

    // เลือกผู้ใช้งานระบบ
    $("#obtPromotionBrowseUsr").click(function() {
        // option User
        window.oPromotionBrowseUsr = {
            Title: ['authen/user/user', 'tUSRTitle'],
            Table: {
                Master: 'TCNMUser',
                PK: 'FTUsrCode'
            },
            Join: {
                Table: ['TCNMUser_L', 'TCNTUsrGroup'],
                On: ['TCNMUser.FTUsrCode = TCNMUser_L.FTUsrCode AND TCNMUser_L.FNLngID = ' + nLangEdits, 'TCNTUsrGroup.FTUsrCode = TCNMUser.FTUsrCode']
            },
            Where: {
                Condition: [
                    function() {
                        return "";
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tUSRCode', 'tUSRTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMUser.FTUsrCode', 'TCNMUser_L.FTUsrName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMUser.FTUsrCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetPromotionUsrCode", "TCNMUser.FTUsrCode"],
                Text: ["oetPromotionUsrName", "TCNMUser_L.FTUsrName"],
            },
            /* NextFunc: {
                FuncName: 'JSxPromotionCallbackUsr',
                ArgReturn: ['FTUsrCode', 'FTUsrName']
            }, */
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oPromotionBrowseUsr');
    });

    // เลือกสิทธิ์การใช้งาน
    $("#obtPromotionBrowseRole").click(function() {
        let tSesUsrRoleSpcCodeMulti = "<?= $this->session->userdata('tSesUsrRoleSpcCodeMulti') ?>";
        let nSesUsrBchCount = '<?= $this->session->userdata('nSesUsrBchCount') ?>';
        let tCondition = '';
        if (nSesUsrBchCount != 0) {
            tCondition += " AND TCNMUsrRole.FTRolCode IN (" + tSesUsrRoleSpcCodeMulti + ")";
        }
        // option User
        window.oPromotionBrowseRole = {
            Title: ['authen/role/role', 'tROLTitle'],
            Table: {
                Master: 'TCNMUsrRole',
                PK: 'FTRolCode',
                PKName: 'FTRolName'
            },
            Join: {
                Table: ['TCNMUsrRole_L'],
                On: ['TCNMUsrRole.FTRolCode = TCNMUsrRole_L.FTRolCode AND TCNMUsrRole_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    tCondition
                ]
            },
            GrideView: {
                ColumnPathLang: 'authen/role/role',
                ColumnKeyLang: ['tROLTBCode', 'tROLTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMUsrRole.FTRolCode', 'TCNMUsrRole_L.FTRolName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMUsrRole.FTRolCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetPromotionRoleCode", "TCNMUsrRole.FTRolCode"],
                Text: ["oetPromotionRoleName", "TCNMUsrRole_L.FTRolName"],
            },
            /* NextFunc: {
                FuncName: 'JSxPromotionCallbackUsr',
                ArgReturn: ['FTRolCode', 'FTRolName']
            }, */
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oPromotionBrowseRole');
    });
    /*===== End Event Browse ===========================================================*/

    var bUniquePromotionCode;
    $.validator.addMethod(
        "uniquePromotionCode",
        function(tValue, oElement, aParams) {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {

                var tPromotionCode = tValue;
                $.ajax({
                    type: "POST",
                    url: "promotionUniqueValidate",
                    data: "tPromotionCode=" + tPromotionCode,
                    dataType: "JSON",
                    success: function(poResponse) {
                        bUniquePromotionCode = (poResponse.bStatus) ? false : true;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // console.log('Custom validate uniquePromotionCode: ', jqXHR, textStatus, errorThrown);
                    },
                    async: false
                });
                return bUniquePromotionCode;

            } else {
                JCNxShowMsgSessionExpired();
            }

        },
        "Doc No. is Already Taken"
    );

    /**
     * Functionality : Validate Form
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionValidateForm() {
        var oTopUpVendingForm = $('#ofmPromotionForm').validate({
            focusInvalid: true,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetPromotionDocNo: {
                    required: true,
                    maxlength: 20,
                    uniquePromotionCode: bIsAddPage
                },
                oetPromotionDocDate: {
                    required: true
                },
                oetPromotionDocTime: {
                    required: true
                },
                oetPromotionMchName: {
                    required: true
                },
                oetPromotionShpName: {
                    required: true
                },
                oetPromotionAccountNameTo: {
                    required: true
                },
                oetPromotionRoleName: {
                    required: true
                },

                oetPromotionPmhLimitQty: {
                    required: true
                },
                oetPromotionSpmMemAgeLT: {
                    required: true
                },
                oetPromotionPmhCstDobPrev: {
                    required: true
                },
                oetPromotionPmhCstDobNext: {
                    required: true
                }
            },
            messages: {
                oetPromotionDocNo: {
                    "required": $('#oetPromotionDocNo').attr('data-validate-required')
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass("has-error");
            },
            submitHandler: function(form) {
                if (!JCNbPromotionStep1IsValid()) {
                    var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg20'); ?>';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
                if (!JCNbPromotionStep2IsValid()) {
                    var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg21'); ?>';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
                if (!JCNbPromotionStep3AvgDisPercentIsValid()) {
                    var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg22'); ?>';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
                if (!JCNbPromotionStep3CouponIsValid()) {
                    var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg23'); ?>';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
                if (!JCNbPromotionStep3PointIsValid()) {
                    var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg24'); ?>';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
                JSxPromotionSave();
            }
        });
    }

    /**
     * Functionality : Save Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionSave() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tMerCode = $('#oetPromotionMchCode').val();
            var tShpCode = $('#oetPromotionShpCode').val();
            var tPosCode = $('#oetPromotionPosCode').val();
            var tWahCode = $('#oetPromotionWahCode').val();

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "<?php echo $tRoute; ?>",
                data: $("#ofmPromotionForm").serialize(),
                cache: false,
                timeout: 5000,
                dataType: "JSON",
                success: function(oResult) {
                    switch (oResult.nStaCallBack) {
                        case "1": {
                            JSvPromotionCallPageEdit(oResult.tCodeReturn);
                            break;
                        }
                        case "2": {
                            JSvPromotionCallPageAdd();
                            break;
                        }
                        case "3": {
                            JSvPromotionCallPageList();
                            break;
                        }
                        default: {
                            JSvPromotionCallPageEdit(oResult.tCodeReturn);
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Approve Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionApprove(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            try {
                if (pbIsConfirm) {
                    $("#ohdPromotionStaApv").val(2); // Set status for processing approve
                    $("#odvPromotionPopupApv").modal("hide");

                    var tDocNo = $("#oetPromotionDocNo").val();

                    JCNxOpenLoading();

                    $.ajax({
                        type: "POST",
                        url: "promotionDocApprove",
                        data: {
                            tDocNo: tDocNo
                        },
                        cache: false,
                        timeout: 0,
                        success: function(oResult) {
                            // console.log(oResult);
                            try {
                                if (oResult.nStaEvent == "900") {
                                    FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                    JCNxCloseLoading();
                                    return;
                                }
                            } catch (err) {}
                            JSvPromotionCallPageEdit(tDocNo);
                            // JCNxCloseLoading();
                            // JSoPromotionSubscribeMQ(); // เอกสารนี้ไม่ต้องรอข้อความตอบกลับ
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                            JCNxCloseLoading();
                        }
                    });
                } else {
                    if (!JCNbPromotionStep1IsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg20'); ?>';
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        return;
                    }
                    if (!JCNbPromotionStep2IsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg21'); ?>';
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        return;
                    }
                    if (!JCNbPromotionStep3AvgDisPercentIsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg22'); ?>';
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        return;
                    }
                    if (!JCNbPromotionStep3CouponIsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg23'); ?>';
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        return;
                    }
                    if (!JCNbPromotionStep3PointIsValid()) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg24'); ?>';
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        return;
                    }
                    // console.log(("StaApvDoc Call Modal");
                    $("#odvPromotionPopupApv").modal("show");
                }
            } catch (err) {
                // console.log("JSvPromotionApprove Error: ", err);
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Cancel Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionCancel(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tDocNo = $("#oetPromotionDocNo").val();

            if (pbIsConfirm) {
                $.ajax({
                    type: "POST",
                    url: "promotionDocCancel",
                    data: {
                        tDocNo: tDocNo
                    },
                    cache: false,
                    timeout: 5000,
                    success: function(tResult) {
                        $("#odvPromotionPopupCancel").modal("hide");

                        var aResult = $.parseJSON(tResult);
                        if (aResult.nSta == 1) {
                            JSvPromotionCallPageEdit(tDocNo);
                        } else {
                            JCNxCloseLoading();
                            var tMsgBody = aResult.tMsg;
                            FSvCMNSetMsgWarningDialog(tMsgBody);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $("#odvPromotionPopupCancel").modal("show");
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : SubscribeMQ
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSoPromotionSubscribeMQ() {
        // RabbitMQ
        /*===========================================================================*/
        // Document variable
        var tLangCode = $("#ohdLangEdit").val();
        var tUsrBchCode = $("#oetPromotionBchCode").val();
        var tUsrApv = $("#oetPromotionApvCodeUsrLogin").val();
        var tDocNo = $("#oetPromotionDocNo").val();
        var tPrefix = "RESTFWVD";
        var tStaApv = $("#ohdPromotionStaApv").val();
        var tStaDelMQ = $("#ohdPromotionStaDelMQ").val();
        var tQName = tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode: tLangCode,
            tUsrBchCode: tUsrBchCode,
            tUsrApv: tUsrApv,
            tDocNo: tDocNo,
            tPrefix: tPrefix,
            tStaDelMQ: tStaDelMQ,
            tStaApv: tStaApv,
            tQName: tQName
        };

        // RabbitMQ STOMP Config
        var poMqConfig = {
            host: "ws://" + oSTOMMQConfig.host + ":15674/ws",
            username: oSTOMMQConfig.user,
            password: oSTOMMQConfig.password,
            vHost: oSTOMMQConfig.vhost
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName: "TFNTBnkDplHD",
            ptDocFieldDocNo: "FTBdhDocNo",
            ptDocFieldStaApv: "FTXthStaPrcStk",
            ptDocFieldStaDelMQ: "FTXthStaDelMQ",
            ptDocStaDelMQ: tStaDelMQ,
            ptDocNo: tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: "JSvPromotionCallPageEdit",
            tCallPageList: "JSvPromotionCallPageList"
        };

        // Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            poMqConfig,
            poUpdateStaDelQnameParams,
            poCallback
        );
        /*===========================================================================*/
        // RabbitMQ
    }

    /**
     * Functionality : ตรวจสอบเงื่อนไขการซื้อ ว่าเป็นประเภทช่วงหรือไม่
     * 3:ตามช่วงจำนวน, 4:ตามช่วงมูลค่า, 5:ตามช่วงเวลา
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSbPromotionConditionBuyIsRange() {
        var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();
        var aConditionBuyInRage = ["3", "4", "5", "6"];
        var bStatus = false;

        if (aConditionBuyInRage.includes(tPbyStaBuyCond)) {
            bStatus = true;
        }

        return bStatus;
    }

    /**
     * Functionality : ตรวจสอบเงื่อนไขการซื้อ ว่าเป็นประเภทปกติหรือไม่
     * 1:ครบจำนวน, 2:ครบมูลค่า
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSbPromotionConditionBuyIsNormal() {
        var tPbyStaBuyCond = $('#ocmPromotionPbyStaBuyCond').val();
        var aConditionBuyInRage = ["1", "2"];
        var bStatus = false;

        if (aConditionBuyInRage.includes(tPbyStaBuyCond)) {
            bStatus = true;
        }

        return bStatus;
    }

    /**
     * Functionality : ตรวจสอบเงื่อนไขกลุ่มคำนวนโปรโมชั่น ว่าเป็นประเภท Price Group หรือไม่
     * สถานะกลุ่มคำนวนโปรโมชั่น  (0.Price Group  1.The Best  2.Forced)
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSbPromotionStaGrpPriorityIsPriceGroup() {
        var tStaGrpPriority = $('#ocmPromotionPmhStaGrpPriority').val();
        var aStaGrpPriority = ["0"];
        var bStatus = false;

        if (aStaGrpPriority.includes(tStaGrpPriority)) {
            bStatus = true;
        }

        return bStatus;
    }

    /**
     * Functionality : ตรวจสอบเงื่อนไขกลุ่มคำนวนโปรโมชั่น ว่าเป็นประเภท The Best หรือไม่
     * สถานะกลุ่มคำนวนโปรโมชั่น  (0.Price Group  1.The Best  2.Forced)
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSbPromotionStaGrpPriorityIsTheBest() {
        var tStaGrpPriority = $('#ocmPromotionPmhStaGrpPriority').val();
        var aStaGrpPriority = ["1"];
        var bStatus = false;

        if (aStaGrpPriority.includes(tStaGrpPriority)) {
            bStatus = true;
        }

        return bStatus;
    }

    /**
     * Functionality : ตรวจสอบเงื่อนไขกลุ่มคำนวนโปรโมชั่น ว่าเป็นประเภท Forced หรือไม่
     * สถานะกลุ่มคำนวนโปรโมชั่น  (0.Price Group  1.The Best  2.Forced)
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSbPromotionStaGrpPriorityIsForced() {
        var tStaGrpPriority = $('#ocmPromotionPmhStaGrpPriority').val();
        var aStaGrpPriority = ["2"];
        var bStatus = false;

        if (aStaGrpPriority.includes(tStaGrpPriority)) {
            bStatus = true;
        }

        return bStatus;
    }

    /**
     * Functionality : ตรวจสถานะการให้ส่วนลดเฉพาะกลุ่มทีได้รับ ว่าเป็นประเภท ให้ส่วนลดเฉพาะกลุ่ม หรือไม่
     * สถานะการให้ส่วนลดเฉพาะกลุ่มทีได้รับ  (1=ให้ส่วนลดเฉพาะกลุ่ม 2=ให้ทั้งหมด รวมไม่เกิน 100%)
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    /* function JSbPromotionPmhStaSpcGrpDisIsDisSomeGroup() {
        var StaSpcGrpDis = $('#ocbPromotionPmhStaSpcGrpDis:checked').val();
        var aStaSpcGrpDis = ["1"];
        var bStatus = false;

        if(aStaSpcGrpDis.includes(StaSpcGrpDis)){
            bStatus = true;
        }

        return bStatus;
    } */

    /**
     * Functionality : ตรวจสถานะ คิดโปรโมชั่นสมาชิกทั้งหมด หรือไม่
     * คิดต่อสมาชิก/ทั้งหมด 1:ทั้งหมด 2: สมาชิก
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSbPromotionPmhStaLimitCstIsAll() {
        var tStaLimitCst = $('#ocmPromotionPmhStaLimitCst').val();
        var aStaLimitCst = ["1"];
        var bStatus = false;

        if (aStaLimitCst.includes(tStaLimitCst)) {
            bStatus = true;
        }

        return bStatus;
    }



    //กรณีเลือกจำกัดจำนวน ต่อสมาชิก ให้ คิดต่อสมาชิกด้วย By พี่เอ็มแจ้ง
    //Date : 2021-04-01
    //Dev : Nale 
    $('#ocmPromotionPmhStaChkLimit').change(function() {
        JSxPromotionPmhSetStaLimitCst();
    });
    /**
     * Functionality : กรณีเลือกจำกัดจำนวน ต่อสมาชิก ให้ คิดต่อสมาชิกด้วย By พี่เอ็มแจ้ง
     * Parameters : -
     * Creator : 01/04/2021 nale
     * Return : -
     * Return Type : -
     */
    function JSxPromotionPmhSetStaLimitCst() {
        var nPromotionPmhStaChkLimit = $("#ocmPromotionPmhStaChkLimit").val();
        // alert(nPromotionPmhStaChkLimit);
        if (nPromotionPmhStaChkLimit == 3 && $('#ocbPromotionPmhStaLimitGet').prop('checked') == true) {
            $('#ocmPromotionPmhStaLimitCst').val(2).change();
            $('#ocmPromotionPmhStaLimitCst option:not(:selected)').attr('disabled', true);
        } else {
            $('#ocmPromotionPmhStaLimitCst option:not(:selected)').attr('disabled', false);
            $('#ocmPromotionPmhStaLimitCst').val(1).change();
        }
        $("#ocmPromotionPmhStaLimitCst").selectpicker("refresh");
    }

    //พิมพ์
    function JSxPromotionPrintDoc() {
        var tUsrBchCode = $("#oetPromotionBchCode").val();
        var tDocNo = $("#oetPromotionDocNo").val();

        var aInfor = [{
                "Lang": '<?php echo FCNaHGetLangEdit(); ?>'
            }, // Lang ID
            {
                "ComCode": '<?php echo FCNtGetCompanyCode(); ?>'
            }, // Company Code
            {
                "BranchCode": '<?= FCNtGetAddressBranch($tUserBchCode); ?>'
            }, // สาขาที่ออกเอกสาร
            {
                "DocCode": tDocNo
            }, // เลขที่เอกสาร
            {
                "DocBchCode": tUsrBchCode
            }
        ];
        window.open("<?php echo base_url(); ?>formreport/Frm_SQL_ALLMPmt?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

    // Event Click Appove Document
    $('#obtPromotionCopy').unbind().click(function(){
        // var nStaSession = JCNxFuncChkSessionExpired();
        // if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxPromotionCopyDocument(false);
        // }else{
        //     JCNxShowMsgSessionExpired();
        // }
    });

    // Functionality: Copy Doc Promotion
    // Parameters: Event Click Save Document
    // Creator: 17/03/2022 Off
    // LastUpdate: 17/03/2022 Off
    function JSxPromotionCopyDocument(pbIsConfirm){
        if(pbIsConfirm){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                $("#odvPromotionModalCopyDoc").modal("hide");
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                JCNxOpenLoading();
                var tDocumentNumber =  $('#oetPromotionDocNo').val();
                var tBchCode        =  $('#oetPromotionBchCode').val();
                $.ajax({
                    type    : "POST",
                    url     : "promotionEvenCopy",
                    data    : {tDocumentNumber : tDocumentNumber  , tBchCode : tBchCode},
                    timeout: 0,
                    success: function(oDataReturn){
                        FSvCMNSetMsgSucessDialog('คัดลอกเอกสารสำเร็จ');
                        // JCNxCloseLoading();
                        setTimeout(function () {
                            JSvPromotionCallPageList();
                        }, 500);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }else{
            $('#odvPromotionModalCopyDoc').modal({backdrop:'static',keyboard:false});
            $("#odvPromotionModalCopyDoc").modal("show");
        }
    }
</script>