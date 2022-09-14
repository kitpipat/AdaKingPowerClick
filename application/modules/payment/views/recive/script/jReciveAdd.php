<script type="text/javascript">
    $('.selection-2').selectpicker();
    var nLangEdits = "<?php echo $this->session->userdata("tLangEdit")?>";

    $(document).ready(function() {
        var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';
        if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
            $('#obtRCVUsrBrowseAgency').attr("disabled", true);
            // $('#oimBrowseBranch').attr("disabled", true);
        }else{
            $('#obtRCVUsrBrowseAgency').attr("disabled", false);
        }

        if (JSbRcvIsCreatePage()) {
            // Rcv Code
            $("#oetRcvCode").attr("disabled", true);
            $('#ocbReciveAutoGenCode').change(function() {
                if ($('#ocbReciveAutoGenCode').is(':checked')) {
                    $('#oetRcvCode').val('');
                    $("#oetRcvCode").attr("disabled", true);
                    $('#odvReciveCodeForm').removeClass('has-error');
                    $('#odvReciveCodeForm em').remove();
                } else {
                    $("#oetRcvCode").attr("disabled", false);
                }
            });
            JSxRcvVisibleComponent('#odvReciveAutoGenCode', true);
        }

        if (JSbRcvIsUpdatePage()) {
            // Sale Person Code
            $("#oetRcvCode").attr("readonly", true);
            $('#odvReciveAutoGenCode input').attr('disabled', true);
            JSxRcvVisibleComponent('#odvReciveAutoGenCode', false);
        }

        // $('#oetRcvCode').blur(function() {
        //     JSxCheckRcvCodeDupInDB();
        // });

        $('.xWHideSave').show();
        $('.xWMenu').click(function() {
            var tMenuType = $(this).data('menutype');
            if (tMenuType == 'Cfg' || tMenuType == 'Log') {
                $('.xWHideSave').hide();
            } else {
                $('.xWHideSave').show();
            }
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    // function JSxCheckRcvCodeDupInDB() {
    //     if (!$('#ocbReciveAutoGenCode').is(':checked')) {
    //         $.ajax({
    //             type: "POST",
    //             url: "CheckInputGenCode",
    //             data: {
    //                 tTableName: "TFNMRcv",
    //                 tFieldName: "FTRcvCode",
    //                 tCode: $("#oetRcvCode").val()
    //             },
    //             async: false,
    //             cache: false,
    //             timeout: 0,
    //             success: function(tResult) {
    //                 var aResult = JSON.parse(tResult);
    //                 $("#ohdCheckDuplicateRcvCode").val(aResult["rtCode"]);
    //                 JSxRcvSetValidEventBlur();
    //                 $('#ofmAddRecive').submit();
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });
    //     }
    // }

    //Functionality: Set Validate Event Blur
    //Parameters: Validate Event Blur
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxRcvSetValidEventBlur() {
        $('#ofmAddRecive').validate().destroy();

        // Set Validate Dublicate Code
        // $.validator.addMethod('dublicateCode', function(value, element) {
        //     if ($("#ohdCheckDuplicateRcvCode").val() == 1) {
        //         return false;
        //     } else {
        //         return true;
        //     }
        // }, '');

        // From Summit Validate
        $('#ofmAddRecive').validate({
            rules: {
                oetRcvCode: {
                    "required": {
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if ($('#ocbReciveAutoGenCode').is(':checked')) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    },
                    // "dublicateCode": {}
                },

                oetRcvName: {
                    "required": {}
                },
                oetRcvFormatName: {
                    "required": {}
                },
                oetRcvReadCardName: {
                    "required": {}
                },
            },
            messages: {
                oetRcvCode: {
                    "required": $('#oetRcvCode').attr('data-validate-required'),
                    // "dublicateCode": $('#oetRcvCode').attr('data-validate-dublicateCode')
                },
                oetRcvName: {
                    "required": $('#oetRcvName').attr('data-validate-required'),
                },
                oetRcvFormatName: {
                    "required": $('#oetRcvFormatName').attr('data-validate-required'),
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

    // Create By Witsarut 27/11/2019
    // Get Data FTRcvCode
    function JSxRcvSpcGetContent() {
        JCNxOpenLoading();
        var tRoutepage = '<?= $tRoute ?>';
        if (tRoutepage == 'reciveEventAdd') {
            return;
        } else {
            var ptRcvCode = '<?php echo $tRcvCode; ?>'
            var ptRcvName = '<?php echo $tRcvName; ?>'

            // Check Login Expried
            var nStaSession = JCNxFuncChkSessionExpired();

            // if have session
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

                $("#odvRcvSpcContentInfoDT").attr("class", "tab-pane fade out");
                $.ajax({
                    type: "POST",
                    url: "recivespc/0/0",
                    data: {
                        tRcvCode: ptRcvCode,
                        tRcvName: ptRcvName
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvRcvSpcData').html(tResult);
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



    // Create By Worakorn 04/11/2020
    // Get Data FTRcvCode
    function JSxRcvSpcGetConfig() {
        JCNxOpenLoading();
        var tRoutepage = '<?= $tRoute ?>';
        if (tRoutepage == 'reciveEventAdd') {
            return;
        } else {
            var ptRcvCode = '<?php echo $tRcvCode; ?>'
            var ptRcvName = '<?php echo $tRcvName; ?>'

            // Check Login Expried
            var nStaSession = JCNxFuncChkSessionExpired();

            // if have session
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

                $("#odvRcvSpcContentInfoDT").attr("class", "tab-pane fade out");
                $.ajax({
                    type: "POST",
                    url: "recivespcconfig/0/0",
                    data: {
                        tRcvCode: ptRcvCode,
                        tRcvName: ptRcvName
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvRcvSpcConfig').html(tResult);
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


    $('#oimRcvFormatBrowse').click(function() {
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowsetSysFormat');
    });

    $('#oimRcvElectronicBrowse').click(function() {
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowsetElectronicFormat');
    });


    var oBrowsetSysFormat = {
        Title: ['payment/recive/recive', 'tRCVFormat'],
        Table: {
            Master: 'TSysRcvFmt',
            PK: 'FTFmtCode'
        },
        Join: {
            Table: ['TSysRcvFmt_L'],
            On: ['TSysRcvFmt_L.FTFmtCode = TSysRcvFmt.FTFmtCode  AND TSysRcvFmt_L.FNLngID =' + nLangEdits]
        },
        Where: {
            Condition: [' AND TSysRcvFmt.FTFmtStaUsed = 1 ']
        },
        GrideView: {
            ColumnPathLang: 'payment/recivespc/recivespc',
            ColumnKeyLang: ['tBrowseAppCode', 'tBrowseAppName'],
            ColumnsSize: ['15%', '75%'],
            DataColumns: ['TSysRcvFmt.FTFmtCode', 'TSysRcvFmt_L.FTFmtName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TSysRcvFmt.FTFmtCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRcvFormatCode", "TSysRcvFmt.FTFmtCode"],
            Text: ["oetRcvFormatName", "TSysRcvFmt_L.FTFmtName"]
        },
        // DebugSQL:true
        NextFunc: {
            FuncName: 'JSxNextFuncFormatValidate',
            ArgReturn: ['FTFmtCode']
        },
    };

    var oBrowsetElectronicFormat = {
        Title: ['payment/recive/recive', 'tRCVTBReadCard'],
        Table: {
            Master: 'TFNMEdc',
            PK: 'FTEdcCode'
        },
        Join: {
            Table: ['TFNMEdc_L'],
            On: ['TFNMEdc_L.FTEdcCode = TFNMEdc.FTEdcCode  AND TFNMEdc_L.FNLngID =' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'payment/recivespc/recivespc',
            ColumnKeyLang: ['tBrowseAppCode', 'tBrowseAppName'],
            ColumnsSize: ['15%', '75%'],
            DataColumns: ['TFNMEdc.FTEdcCode', 'TFNMEdc_L.FTEdcName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TFNMEdc.FTEdcCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRcvReadCardCode", "TFNMEdc.FTEdcCode"],
            Text: ["oetRcvReadCardName", "TFNMEdc_L.FTEdcName"]
        },
    };

    //Functionality: show and hide Coupon browse
    //Creator: 23/06/2021 Pakkahwat Chuesaard
    $(document).ready(function(){
        $("#odvRcvCouponName").hide();
        var tFmtCode = $('#oetRcvFormatCode').val();
        if (tFmtCode == '004' || tFmtCode == '020') {
            $("#odvRcvCouponName").show();
        }else{
            $("#odvRcvCouponName").hide();
        }
    });

    function JSxNextFuncFormatValidate(ptFmtCode) {
        if (ptFmtCode != 'NULL') {
            $('#oetRcvFormatName').removeAttr('data-validate-required')
            $('#oetRcvFormatName').removeAttr('aria-describedby')
            $("#oetRcvFormatName-error").css({"display":"none"})
            $('#odvRcvFmtName').removeClass("has-error")
            $('#odvRcvFmtName').addClass("has-success")
        } else {
            $('#odvRcvFmtName').removeClass("has-success")
            $('#odvRcvFmtName').addClass("has-error")
            $("#oetRcvFormatName-error").removeAttr("style")
        }

        //Functionality: show and hide Coupon browse after select Format type browse
        //Creator: 23/06/2021 Pakkahwat Chuesaard
        $(document).ready(function(){
            var tFmtCode = JSON.parse(ptFmtCode);
            if (tFmtCode == '004' || tFmtCode == '020') {
                tCondition = " AND FTCptType = 1 ";
                $("#odvRcvCouponName").show();
            }else{
                $("#odvRcvCouponName").hide();
            }
        });

        
    }

        $('#obtRCVUsrBrowseAgency').on('click',function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oUsrAgnOption       = undefined;
                oUsrAgnOption              = oUsrBrowseAgency({
                    'tReturnInputCode'          : 'oetRCVUsrAgnCode',
                    'tReturnInputName'          : 'oetRCVUsrAgnName',
                    'aArgReturn'                : ['FTAgnCode','FTAgnName']
                });
                JCNxBrowseData('oUsrAgnOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        //Browse AD
        // Option Browse Merchant
        var oUsrBrowseAgency = function(poReturnInputAgency){
            let tInputReturnAgnCode   = poReturnInputAgency.tReturnInputCode;
            let tInputReturnAgnName   = poReturnInputAgency.tReturnInputName;
            let tAgencyNextFunc       = poReturnInputAgency.tNextFuncName;
            let aAgencyArgReturn      = poReturnInputAgency.aArgReturn;

            // let tJoinBranch = " LEFT JOIN ( SELECT FTMerCode FROM TCNMBranch GROUP BY FTMerCode ) B ON TCNMMerchant.FTMerCode = B.FTMerCode ";
            // let tJoinShop   = " LEFT JOIN ( SELECT FTMerCode FROM TCNMShop GROUP BY FTMerCode ) S ON TCNMMerchant.FTMerCode = S.FTMerCode ";

            let oAgencyOptionReturn = {
                Title : ['authen/user/user','tBrowseAgnTitle'],
                Table :{Master:'TCNMAgency',PK:'FTAgnCode'},
                Join :{
                    Table:	['TCNMAgency_L'],
                    On:[' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits] //+ tJoinBranch + tJoinShop
                },
                // Where :{
                //     Condition : [" AND ( ISNULL(B.FTMerCode,'') != '' OR ISNULL(S.FTMerCode,'') != '') "]
                // },
                GrideView:{
                    ColumnPathLang	: 'authen/user/user',
                    ColumnKeyLang	: ['tBrowseAgnCode','tBrowseAgnName'],
                    ColumnsSize     : ['10%','75%'],
                    DataColumns	    : ['TCNMAgency.FTAgnCode','TCNMAgency_L.FTAgnName'],
                    DataColumnsFormat : ['',''],
                    WidthModal      : 50,
                    Perpage			: 10,
                    OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnAgnCode,"TCNMAgency.FTAgnCode"],
                    Text		: [tInputReturnAgnName,"TCNMAgency_L.FTAgnName"]
                },
                //DebugSQL: true,
            };
            return oAgencyOptionReturn;
        }

    //Functionality: browse coupon type
    //Creator: 23/06/2021 Pakkahwat Chuesaard
    //Last Update 14/07/2021 Off
    $('#oimRcvCouponBrowse').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            
            JSxCheckPinMenuClose();
            var nRcvCode = $("#oetRcvFormatCode").val();
            var dDatenow = $("#ohdDatenow").val();
            if(nRcvCode == '004'){
                nCptType = '1';
            }else{
                nCptType = '2';
            }
            tCondition = " AND FTCptType = '"+nCptType+"' AND FTCphStaApv = 1 AND FDCphDateStart <= '"+dDatenow+"' AND FDCphDateStop >= '"+dDatenow+"'";  
            window.oBrowseCouponOption   = undefined;
            oBrowseCouponOption          = oFindCOuponOption({
                'tReturnInputCode'  : 'oetRcvCouponCode',
                'tReturnInputName'  : 'oetRcvCouponName',
                'tWhereCondition'   : tCondition
            });
            setTimeout(function(){ 
                JCNxBrowseData('oBrowseCouponOption');
            }, 500);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oFindCOuponOption      = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tCondition          = poDataFnc.tWhereCondition;
        var tValueCusCode       = '';

        var oOptionReturn       = {
            Title: ['payment/recive/recive', 'tRCVCoupon'],
            Table: {
            Master: 'TFNTCouponHD',
            PK: 'FTCphDocNo'
            },
            Join: {
            Table: ['TFNMCouponType','TFNTCouponHD_L'],
            On: [
            'TFNTCouponHD.FTCptCode = TFNMCouponType.FTCptCode',
            'TFNTCouponHD.FTCphDocNo = TFNTCouponHD_L.FTCphDocNo AND TFNTCouponHD_L.FNLngID ='+ nLangEdits]
            },
            Where                   : {
                Condition           : [tCondition]
            },
            GrideView: {
            ColumnPathLang: 'coupon/coupon/coupon',
            ColumnKeyLang: ['tCPNTBCpnCode', 'tCPNTBCpnName', 'tCPNTBCpnName', 'tCPNTBCpnName', 'tCPNTBCpnName'],
            ColumnsSize: ['15%', '75%'],
            DataColumns: ['TFNTCouponHD.FTCphDocNo', 'TFNTCouponHD_L.FTCpnName' ,'TFNMCouponType.FTCptType','TFNTCouponHD.FTCphStaApv','TFNTCouponHD.FDCphDateStart','TFNTCouponHD.FDCphDateStop'],
            DataColumnsFormat: ['', ''],
            DisabledColumns: [2,3,4,5],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TFNTCouponHD.FTCphDocNo ASC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetRcvCouponCode", "TFNTCouponHD.FTCphDocNo"],
                Text: ["oetRcvCouponName", "TFNTCouponHD_L.FTCpnName"]
            }
        };
        return oOptionReturn;
    }
</script>