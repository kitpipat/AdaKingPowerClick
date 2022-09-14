<script type="text/javascript">
    // $('.selection-2').selectpicker();

    $('#ocmCrdStaAct').selectpicker();

    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
    var nStaAddOrEdit = <?php echo $nStaAddOrEdit ?>;
    var tCrdStaShift = '<?php echo $tCrdStaShift ?>';
    var dDatNow = '<?php echo date('Y-m-d') ?>';
    $(document).ready(function() {
        $('.xCNSelectBox').selectpicker();

        $('#obtCrdStartDate').click(function(event) {
            $('#oetCrdStartDate').datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
                enableOnReadonly: false,
                startDate: '1900-01-01',
                disableTouchKeyboard: true,
                autoclose: true,
            });
            $('#oetCrdStartDate').datepicker('show');
            event.preventDefault();
        });

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            startDate: '1900-01-01',
            disableTouchKeyboard: true,
            autoclose: true
        });

        $('#obtCrdStartDate').click(function(event) {
            $('#oetCrdStartDate').datepicker('show');
            event.preventDefault();
        });

        $('#obtCrdExpireDate').click(function(event) {
            $('#oetCrdExpireDate').datepicker('show');
            event.preventDefault();
        });

        if (nStaAddOrEdit === 99) {
            $('#oetCrdDeposit').val('0.00');
            $('#ocbCrdStaLocateUse').prop("checked", true);
            $('#oetCrdStartDate').removeAttr('maxlength');
            $('#oetCrdExpireDate').removeAttr('maxlength');
            $('#oetCrdStartDate').val(dDatNow);
            $('#oetCrdExpireDate').val('9999-12-31');
            JSxChkUseCrdStaType();
        } else {
            JSxChkStaCardStaShif(tCrdStaShift);
        }
    });

    var tAgenCode = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>';

var tWhereDepartmentByAgenCode = "";
var tWhereCardTyptByAgenCode = "";
if(tAgenCode != ''){
    tWhereDepartmentByAgenCode = " AND TCNMUsrDepart.FTAgnCode = '" + tAgenCode + "'";
    tWhereCardTyptByAgenCode = " AND TFNMCardType.FTAgnCode = '" + tAgenCode + "'";
}

    // Browse Card Type
    var oCrdBrwCardType = {
        Title: ['payment/cardtype/cardtype', 'tCTYTitle'],
        Table: {
            Master: 'TFNMCardType',
            PK: 'FTCtyCode'
        },
        Join: {
            Table: ['TFNMCardType_L'],
            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition : [tWhereCardTyptByAgenCode]
        },
        GrideView: {
            ColumnPathLang: 'payment/cardtype/cardtype',
            ColumnKeyLang: ['tCTYCode', 'tCTYName', 'tCRDFrmCrdDeposit'],
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName', 'TFNMCardType.FCCtyDeposit'],
            DisabledColumns: [2],
            Perpage: 10,
            OrderBy: ['TFNMCardType.FDCreateOn DESC']
            // SourceOrder		: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCrdCtyCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCrdCtyName", "TFNMCardType_L.FTCtyName"],
        },
        NextFunc: {
            FuncName: 'JSxNextFuncCrdType',
            ArgReturn: ['FTCtyCode', 'FTCtyName', 'FCCtyDeposit']
        },
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCrdBrowseType
    }

    $('#obtBrowseCardType').click(function() {
        JCNxBrowseData('oCrdBrwCardType');
    });

 


    // Browse Department
    var oCrdBrwDepartment = {
        Title: ['authen/department/department', 'tDPTTitle'],
        Table: {
            Master: 'TCNMUsrDepart',
            PK: 'FTDptCode'
        },
        Join: {
            Table: ['TCNMUsrDepart_L'],
            On: ['TCNMUsrDepart_L.FTDptCode = TCNMUsrDepart.FTDptCode AND TCNMUsrDepart_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition : [tWhereDepartmentByAgenCode]
        },
        GrideView: {
            ColumnPathLang: 'authen/department/department',
            ColumnKeyLang: ['tDPTTBCode', 'tDPTTBName'],
            DataColumns: ['TCNMUsrDepart.FTDptCode', 'TCNMUsrDepart_L.FTDptName'],
            // DisabledColumns : [2],
            Perpage: 10,
            OrderBy: ['TCNMUsrDepart.FDCreateOn DESC']
            // SourceOrder		: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCrdDepartment", "TCNMUsrDepart.FTDptCode"],
            Text: ["oetCrdDepartmentName", "TCNMUsrDepart_L.FTDptName"],
        },
        NextFunc: {
            FuncName: 'JSxNextFuncDetType',
            ArgReturn: ['FTDptCode']
        },
        // DebugSQL: true,
        RouteAddNew: 'department',
        BrowseLev: nStaCrdBrowseType
    }

    $('#obtBrowseDepartment').click(function() {
        JCNxBrowseData('oCrdBrwDepartment');
    });

    function JSxChkStaCardStaShif(tCrdStaShift) {
        if (tCrdStaShift != "" && tCrdStaShift != 1) {
            // $('#oetCrdHolderID').prop('readonly', true);

            // $('#oetCrdRefID').prop('readonly', true);

            $('#obtBrowseCardType').prop('disabled', true);

            $('#oetCrdDeposit').prop('readonly', true);

            $('#oetCrdStartDate').prop('readonly', true);
            $('#obtCrdStartDate').prop('disabled', true);

            $('#oetCrdExpireDate').prop('readonly', true);
            $('#obtCrdExpireDate').prop('disabled', true);

            $('#ocmCrdStaType').parent().addClass('xCNDivSelectReadOnly');
            $('#ocmCrdStaType').parent().find('button').addClass('xCNBtnSelectReadOnly');
        }
    }

    function JSxNextFuncDetType(paDataReturn) {
        $('#oetCrdDepartmentName').closest('.form-group').addClass("has-success").removeClass("has-error");
        $('#oetCrdDepartmentName').closest('.form-group').find(".help-block").fadeOut('slow').remove();
    }

    function JSxNextFuncCrdType(paDataReturn) {
        $('#oetCrdCtyName').closest('.form-group').addClass("has-success").removeClass("has-error");
        $('#oetCrdCtyName').closest('.form-group').find(".help-block").fadeOut('slow').remove();
        var aPdtTypeData = JSON.parse(paDataReturn);
        $('#oetCrdDeposit').val(accounting.formatNumber(aPdtTypeData[2], 2));
    }

    function JSxChkUseCrdStaType() {
        var tCrdStaType = $('#ocmCrdStaType').val();
        if (tCrdStaType == '1') {
            $('#ocbCrdStaLocateUse').prop("checked", true);
            $('#ocbCrdStaLocateUnUse').prop("checked", false);
        } else {
            $('#ocbCrdStaLocateUse').prop("checked", false);
            $('#ocbCrdStaLocateUnUse').prop("checked", true);
        }
    }
    $(document).ready(function() {

        $('#oliUsrloginDetail').click(function() {
            $('#odvBtnAddEdit').show();
        });

        if (JSbCrdIsCreatePage()) {
            $("#oetCrdCode").attr("disabled", true);
            $('#ocbCardAutoGenCode').change(function() {
                if ($('#ocbCardAutoGenCode').is(':checked')) {
                    $('#oetCrdCode').val('');
                    $("#oetCrdCode").attr("disabled", true);
                    $('#odvCardCodeForm').removeClass('has-error');
                    $('#odvCardCodeForm em').remove();
                } else {
                    $("#oetCrdCode").attr("disabled", false);
                }
            });
            JSxCrdVisibleComponent('#odvCardAutoGenCode', true);
        }

        if (JSbCrdIsUpdatePage()) {
            $("#oetCrdCode").attr("readonly", true);
            $('#odvCardAutoGenCode input').attr('disabled', true);
            JSxCrdVisibleComponent('#odvCardAutoGenCode', false);
        }

        $('#oetCrdCode').blur(function() {
            JSxCheckCrdCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckCrdCodeDupInDB() {
        if (!$('#ocbCardAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TFNMCard",
                    tFieldName: "FTCrdCode",
                    tCode: $("#oetCrdCode").val()
                },
                async: false,
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCrdCode").val(aResult["rtCode"]);
                    JSxCrdSetValidEventBlur();
                    $('#ofmAddCard').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    //Functionality: Set Validate Event Blur
    //Parameters: Validate Event Blur
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCrdSetValidEventBlur() {
        $('#ofmAddCard').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if ($("#ohdCheckDuplicateCrdCode").val() == 1) {
                return false;
            } else {
                return true;
            }
        }, '');

        // From Summit Validate
        $('#ofmAddCard').validate({
            rules: {
                oetCrdCode: {
                    "required": {
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if ($('#ocbCardAutoGenCode').is(':checked')) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },

                oetCrdCtyCode: {
                    "required": {}
                },
                oetCrdCtyName: {
                    "required": {}
                }

            },
            messages: {
                oetCrdCode: {
                    "required": $('#oetCrdCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetCrdCode').attr('data-validate-dublicateCode')
                },

                oetCrdCtyName: {
                    "required": $('#oetCrdCtyName').attr('data-validate-required'),
                },
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
                $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            },
            submitHandler: function(form) {}
        });
    }

    // Get Data CardCode
    // Create By Witsarut 25/11/2019
    function JSxCrdloginGetContent() {
        var tRoutepage = '<?= $tRoute ?>';

        if (tRoutepage == 'cardEventAdd') {
            return;
        } else {
            var ptCrdCode = '<?php echo $tCrdCode; ?>';

            // Check Login Expried
            var nStaSession = JCNxFuncChkSessionExpired();

            //if have Session
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $("#odvCrdloginContentInfoDT").attr("class", "tab-pane fade out");
                $.ajax({
                    type: "POST",
                    url: "cardlogin",
                    data: {
                        tCrdCode: ptCrdCode
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvBtnAddEdit').hide();
                        $('#odvCrdloginData').html(tResult);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        }
    }

    // BrowseAgn 
    $('#oimBrowseAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode': 'oetCrdAgnCode',
                'tReturnInputName': 'oetCrdAgnName',
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;

    var oBrowseAgn = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;

        var oOptionReturn = {
            Title: ['ticket/agency/agency', 'tAggTitle'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'ticket/agency/agency',
                ColumnKeyLang: ['tAggCode', 'tAggName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMAgency.FTAgnCode"],
                Text: [tInputReturnName, "TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew: 'agency',
            BrowseLev: 1,
        }
        return oOptionReturn;
    }

    var tStaUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';
    if (tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP') {
        $('#oimBrowseAgn').attr("disabled", true);
    }

    // สาขา(Card His)
    $("#obtCrdHisBrowseBch").click(function() {
        var tAgenCode = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>'
        var tWhereBch = "";
        if(tStaUsrLevel != "HQ" || tAgenCode != ""){
            tWhereBch = " AND TCNMBranch.FTBchCode IN(<?php echo $this->session->userdata('tSesUsrBchCodeMulti'); ?>)";
        }
        // option 
        window.oCrdHisBrowseBch = {
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
                Condition: [tWhereBch]
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
                Value: ["oetCrdHisBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetCrdHisBchName", "TCNMBranch_L.FTBchName"]
            },
            /* NextFunc: {
                FuncName: 'JSxPromotionCallbackBch',
                ArgReturn: ['FTBchCode']
            }, */
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oCrdHisBrowseBch');
    });

    function JSxGetCardHisDataTable(){
        // Check Login Expried
        var nStaSession = JCNxFuncChkSessionExpired();
        
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) { // if have Session
            var tBchCode = $("#oetCrdHisBchCode").val();
            var tHisDate = $("#oetCrdHisDate").val();
            var tCrdCode = '<?php echo $tCrdCode; ?>';
            
            $.ajax({
                type: "POST",
                url: "cardGetHisDataTable",
                data: {
                    tBchCode: tBchCode,
                    tHisDate: tHisDate,
                    tCrdCode: tCrdCode
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvCardHisDataTalbleContainer').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }
</script>