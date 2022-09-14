<script>
    $(document).ready(function() {

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
            $('#oetPTUDocDate').datepicker('show');
        });

        $('#obtPmtDocTime').click(function() {
            event.preventDefault();
            $('#oetPTUDocTime').datetimepicker('show');
        });

        $('#obtPmtDocDateFrom').click(function() {
            event.preventDefault();
            $('#oetPTUPmhDStart').datepicker('show');
        });

        $('#obtPmtDocDateTo').click(function() {
            event.preventDefault();
            $('#oetPTUPmhDStop').datepicker('show');
        });

        $('#obtPmtDocTimeFrom').click(function() {
            event.preventDefault();
            $('#oetPTUPmhTStart').datetimepicker('show');
        });

        $('#obtPmtDocTimeTo').click(function() {
            event.preventDefault();
            $('#oetPTUPmhTStop').datetimepicker('show');
        });

        $('.xWTooltipsBT').tooltip({
            'placement': 'bottom'
        });

        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });

        
        /*===== Begin Control สาขาที่สร้าง ================================================*/
        if ((tUserLoginLevel == "HQ") || (!bIsAddPage) || (!bIsMultiBch)) {
            $("#obtPTUBrowseBch").attr('disabled', true);
        }

        $('#ocbPTUAutoGenCode').unbind().bind('change', function() {
            var bIsChecked = $('#ocbPTUAutoGenCode').is(':checked');
            var oInputDocNo = $('#oetPTUDocNo');
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
            $('#obtPTUApprove').hide();
            $('#obtPTUCancel').hide();
            $('#odvBtnAddEdit .btn-group').hide();
            $('form .xCNApvOrCanCelDisabled').attr('disabled', true);
        } else {
            $('#odvBtnAddEdit .btn-group').show();
        }

        /*===== Begin Control สาขาที่สร้าง ================================================*/
        if ( !bIsAddPage ) {
            $("#obtPTUBrowseBch").attr('disabled', true);

            // Skip to Step 4 for edit page
            $('.xCNPromotionCircle').removeClass('active').removeClass('before');
            // $('.xCNPromotionCircle').removeClass('before');
            $('.xCNPromotionStep1').addClass('before');
            $('.xCNPromotionStep2').addClass('before');
            $('.xCNPromotionStep3').addClass('before');
            $('.xCNPromotionStep4').addClass('active');
            $('a[href="#odvPTUStep4"]').tab('show');
            $('.xCNPromotionBackStep').attr('disabled',false);
            $('.xCNPromotionNextStep').attr('disabled',true);
        }
        /*===== End Control สาขาที่สร้าง ==================================================*/

        $(document).on('keyup keypress', 'form input[type="text"], form input[type="time"], form input[type="number"]', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                return false;
            }
        });

        /*===== Begin Step Form Page Control ===========================================*/
        $('.xCNPromotionCircle').on('click', function(){
            var tTab = $(this).data('tab');
            $('.xCNPromotionNextStep').prop('disabled', false);
            $('.xCNPromotionBackStep').prop('disabled', false);

            switch(tTab){
                case "odvPTUStep1" : {
                    $('.xCNPromotionBackStep').prop('disabled', true);
                    $('.xCNPromotionCircle').removeClass('active').removeClass('before');
                    $('.xCNPromotionStep1').addClass('active');
                    break;
                }
                case "odvPTUStep2" : {
                    if(!JCNbPTUStep1IsValid()){
                        JSxPTUEventMsgStep(1);
                        $('.xCNPromotionBackStep').prop('disabled', true);
                        return;   
                    }else{
                        $('.xCNPromotionCircle').removeClass('active').removeClass('before');
                        $('.xCNPromotionStep1').addClass('before');
                        $('.xCNPromotionStep2').addClass('active');
                    }
                    break;
                }
                case "odvPTUStep3" : {
                    if(!JCNbPTUStep1IsValid()){
                        JSxPTUEventMsgStep(1);
                        return;   
                    }else if(!JCNbPTUStep2IsValid()){
                        JSxPTUEventMsgStep(2);
                        return;   
                    }else{
                        $('.xCNPromotionCircle').removeClass('active').removeClass('before');
                        $('.xCNPromotionStep1').addClass('before');
                        $('.xCNPromotionStep2').addClass('before');
                        $('.xCNPromotionStep3').addClass('active');
                    }
                    break;
                }
                case "odvPTUStep4" : {
                    if(!JCNbPTUStep1IsValid()){
                        JSxPTUEventMsgStep(1);
                        return;   
                    }else if(!JCNbPTUStep2IsValid()){
                        JSxPTUEventMsgStep(2);
                        return;
                    }else if(!JCNbPTUStep3IsValid()){
                        JSxPTUEventMsgStep(3);
                        return;
                    }else{
                        $('.xCNPromotionCircle').removeClass('active').removeClass('before');
                        $('.xCNPromotionStep1').addClass('before');
                        $('.xCNPromotionStep2').addClass('before');
                        $('.xCNPromotionStep3').addClass('before');
                        $('.xCNPromotionStep4').addClass('active');
                    }

                    $('.xCNPromotionNextStep').prop('disabled', true);

                    JSxPTUPageStep4CheckAndConfirm();
                    break;
                }
                default : {
                }
            }
            
            $('a[href="#'+tTab+'"]').tab('show');
        });
        /*===== End Step Form Page Control =============================================*/

        /*===== Begin Step Form Page Control Btn =======================================*/
        // Next
        $('.xCNPromotionNextStep').unbind().bind('click', function(){

            var tStepNow = $('#odvPromotionLine .xCNPromotionCircle.active').data('step');
            // console.log(('tStepNow: ', tStepNow);

            if(tStepNow < "5"){ 
                $('.xCNPromotionCircle.xCNPromotionStep'+(tStepNow+1)).trigger('click'); 
            }
        });

        // Back
        $('.xCNPromotionBackStep').unbind().bind('click', function(){
            var tStepNow = $('#odvPromotionLine .xCNPromotionCircle.active').data('step');
            // console.log(('tStepNow: ', tStepNow);
            if(tStepNow > "1"){ 
                $('.xCNPromotionCircle.xCNPromotionStep'+(tStepNow-1)).trigger('click'); 
            }
        });
        /*===== End Step Form Page Control Btn =========================================*/
    });

    /*===== Begin Event Browse =========================================================*/
    // สาขาที่สร้าง
    $("#obtPTUBrowseBch").click(function() {

        var tWhere = "";
        if( tUserLoginLevel != "HQ" ){
            tWhere = " AND TCNMBranch.FTBchCode IN(<?php echo $this->session->userdata('tSesUsrBchCodeMulti'); ?>) ";
        }

        // option 
        window.oPTUBrowseBch = {
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
                Condition: [ tWhere ]
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
                Value: ["oetPTUBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetPTUBchName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxPTUBranchCallback',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oPTUBrowseBch');
    });

    function JSxPTUBranchCallback(poData){
        if( poData != "NULL" ){
            var aResult = $.parseJSON(poData);
            // console.log(aResult[0]);
            $.ajax({
                type: "POST",
                url: "docPTUEventChangeBchInTemp",
                data: {
                    tBchCode: aResult[0]
                },
                cache: false,
                timeout: 0,
                success: function(){},
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }
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
     * Creator : 28/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSxPTUValidateForm() {
        $('#ofmPTUForm').validate().destroy();
        $('#ofmPTUForm').validate({
            focusInvalid: true,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetPTUDocNo: {
                    required: true,
                    maxlength: 20,
                    uniquePromotionCode: bIsAddPage
                },
                oetPTUDocDate: {
                    required: true
                },
                oetPTUDocTime: {
                    required: true
                },
                oetPTUBchName: {
                    required: true
                },
                oetPTUPmhName: {
                    required: true
                },
            },
            messages: {
                oetCreditNoteDocNo: {
                    "required": $('#oetPTUDocNo').attr('data-validate-required')
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

                if(!JCNbPTUStep1IsValid()){
                    JSxPTUEventMsgStep(1);
                    return;   
                }
                if(!JCNbPTUStep2IsValid()){
                    JSxPTUEventMsgStep(2);
                    return;   
                }
                if(!JCNbPTUStep3IsValid()){
                    JSxPTUEventMsgStep(3);
                    return;   
                }
                JSxPTUSave();
            }
        });
    }

    /**
     * Functionality : Save Doc
     * Parameters : -
     * Creator : 28/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSxPTUSave() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "<?php echo $tRoute; ?>",
                data: $("#ofmPTUForm").serialize(),
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aResult = $.parseJSON(oResult);
                    switch (aResult['nStaCallBack']) {
                        case "1": {
                            JSvPTUCallPageEdit(aResult['tCodeReturn']);
                            break;
                        }
                        case "2": {
                            JSvPTUCallPageAdd();
                            break;
                        }
                        case "3": {
                            JSvPTUCallPageList();
                            break;
                        }
                        default: {
                            JSvPTUCallPageEdit(aResult['tCodeReturn']);
                        }
                    }
                    // JCNxCloseLoading();
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
     * Functionality : Approve Doc
     * Parameters : -
     * Creator : 01/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSvPTUApprove(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            if (pbIsConfirm) {
                $("#ohdPTUStaApv").val(2); // Set status for processing approve
                $("#odvPTUPopupApv").modal("hide");

                var tDocNo = $("#oetPTUDocNo").val();

                JCNxOpenLoading();

                $.ajax({
                    type: "POST",
                    url: "docPTUEventApproveDoc",
                    data: {
                        tDocNo: tDocNo
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aResult = $.parseJSON(oResult);
                        if ( aResult['tCode'] != "1" ) {
                            FSvCMNSetMsgErrorDialog(aResult['tDesc']);
                            JCNxCloseLoading();
                            return;
                        }
                        JSvPTUCallPageEdit(tDocNo);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                        JCNxCloseLoading();
                    }
                });
            } else {
                if(!JCNbPTUStep1IsValid()){
                    JSxPTUEventMsgStep(1);
                    return;   
                }
                if(!JCNbPTUStep2IsValid()){
                    JSxPTUEventMsgStep(2);
                    return;   
                }
                if(!JCNbPTUStep3IsValid()){
                    JSxPTUEventMsgStep(2);
                    return;   
                }
                $("#odvPTUPopupApv").modal("show");
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Cancel Doc
     * Parameters : -
     * Creator : 28/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSvPTUCancel(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            
            if (pbIsConfirm) {
                var tDocNo = $("#oetPTUDocNo").val();
                $.ajax({
                    type: "POST",
                    url: "docPTUEventCancelDoc",
                    data: {
                        tDocNo: tDocNo
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        $("#odvPTUPopupCancel").modal("hide");

                        var aResult = $.parseJSON(oResult);
                        if (aResult['tCode'] == 1) {
                            JSvPTUCallPageEdit(tDocNo);
                        } else {
                            JCNxCloseLoading();
                            var tMsgBody = aResult['tDesc'];
                            FSvCMNSetMsgWarningDialog(tMsgBody);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $("#odvPTUPopupCancel").modal("show");
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    function JSxPTUEventMsgStep(pnStepType){
        var tWarningMessage = "";
        switch(pnStepType){
            case 1:
                tWarningMessage = 'กรุณาตรวจสอบข้อมูล กำหนดประเภทบัตร';
            break;
            case 2:
                tWarningMessage = 'กรุณาตรวจสอบข้อมูล กำหนดเงื่อนไขโปรโมชั่น';
            break;
            case 3:
                tWarningMessage = 'กรุณาตรวจสอบข้อมูล กำหนดเงื่อนไขเฉพาะ';
            break;
        }
        FSvCMNSetMsgWarningDialog(tWarningMessage);
    }

    // Create By : Napat(Jame) 25/03/2021
    function JSxPTUPrintDoc(){
        var tUsrBchCode = $("#oetPTUBchCode").val();
        var tDocNo      = $("#oetPTUDocNo").val();
        var aInfor = [
			{"Lang"         : '<?=FCNaHGetLangEdit(); ?>'}, // Lang ID
			{"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, // Company Code
			{"BranchCode"   : '<?=FCNtGetAddressBranch($tBchCode); ?>' }, // สาขาที่ออกเอกสาร
			{"DocCode"      : tDocNo }, // เลขที่เอกสาร
            {"DocBchCode"   : '<?=$tBchCode?>'}
		];
        window.open("<?php echo base_url(); ?>formreport/Frm_SQL_FCPmtCardCash?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

</script>