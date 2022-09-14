<script type="text/javascript">
    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit"); ?>';
    var tUsrApvName = '<?php echo $this->session->userdata("tSesUsername"); ?>';
    var tSesUsrLevel = '<?php echo $this->session->userdata('tSesUsrLevel'); ?>';
    var tUserBchCode = '<?php echo $this->session->userdata("tSesUsrBchCode"); ?>';
    var tUserBchName = '<?php echo $this->session->userdata("tSesUsrBchName"); ?>';
    var tUserWahCode = '<?php echo $this->session->userdata("tSesUsrWahCode"); ?>';
    var tUserWahName = '<?php echo $this->session->userdata("tSesUsrWahName"); ?>';
    var tRoute = $('#ohdRSRoute').val();
    var tRSSesSessionID = $("#ohdSesSessionID").val();
    $(document).ready(function() {

        // if(tUserBchCode != ''){
        //     $('#oetRSFrmBchCode').val(tUserBchCode);
        //     $('#oetRSFrmBchName').val(tUserBchName);
        //     $('#obtBrowseTWOBCH').attr("disabled","disabled");
        // }
        if (tUserWahCode != '' && tRoute == 'dcmRSEventAdd') {
            $('#oetRSFrmWahCode').val(tUserWahCode);
            $('#oetRSFrmWahName').val(tUserWahName);
        }

        $('.selectpicker').selectpicker('refresh');

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard: true,
            autoclose: true
        });

        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm:ss'
        });

        $('.xCNMenuplus').unbind().click(function() {
            if ($(this).hasClass('collapsed')) {
                $('.xCNMenuplus').removeClass('collapsed').addClass('collapsed');
                $('.xCNMenuPanelData').removeClass('in');
            }
        });

        $('.xWTooltipsBT').tooltip({
            'placement': 'bottom'
        });

        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });

        $(".xWConditionSearchPdt.disabled").attr("disabled", "disabled");


        $('#obtRSDocBrowsePdt').unbind().click(function() {
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                if ($('#oetRSFrmCstHNNumber').val() != "") {
                    JSxCheckPinMenuClose();
                    JCNvRSBrowsePdt();
                } else {
                    $('#odvRSModalPleseselectCustomer').modal('show');
                }
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        if ($('#oetRSFrmBchCode').val() == "") {
            $("#obtRSFrmBrowseTaxAdd").attr("disabled", "disabled");
        }

        /** =================== Event Search Function ===================== */
        $('#oliRSMngPdtScan').unbind().click(function() {
            var tRSSplCode = $('#oetRSFrmSplCode').val();
            if (typeof(tRSSplCode) !== undefined && tRSSplCode !== '') {
                //Hide
                $('#oetRSFrmFilterPdtHTML').hide();
                $('#obtRSMngPdtIconSearch').hide();

                //Show
                $('#oetRSFrmSearchAndAddPdtHTML').show();
                $('#obtRSMngPdtIconScan').show();
            } else {
                var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
                FSvCMNSetMsgWarningDialog(tWarningMessage);
                return;
            }
        });
        $('#oliRSMngPdtSearch').unbind().click(function() {
            //Hide
            $('#oetRSFrmSearchAndAddPdtHTML').hide();
            $('#obtRSMngPdtIconScan').hide();
            //Show
            $('#oetRSFrmFilterPdtHTML').show();
            $('#obtRSMngPdtIconSearch').show();
        });
        /** =============================================================== */

        /** ===================== Set Date Autometic Doc ========================  */
        var dCurrentDate = new Date();
        var tAmOrPm = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
        var tCurrentTime = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

        if ($('#oetRSDocDate').val() == '') {
            $('#oetRSDocDate').datepicker("setDate", dCurrentDate);
        }

        if ($('#oetRSRefDocDate').val() == '') {
            $('#oetRSRefDocDate').datepicker("setDate", dCurrentDate);
        }

        if ($('#oetRSDocTime').val() == '') {
            $('#oetRSDocTime').val(tCurrentTime);
        }
        /** =============================================================== */

        /** =================== Event Date Function  ====================== */
        $('#obtRSDocDate').unbind().click(function() {
            $('#oetRSDocDate').datepicker('show');
        });

        $('#obtRSRefDocDate').unbind().click(function() {
            $('#oetRSRefDocDate').datepicker('show');
        });

        $('#obtRSDocTime').unbind().click(function() {
            $('#oetRSDocTime').datetimepicker('show');
        });

        $('#obtRSBrowseRefIntDocDate').unbind().click(function() {
            $('#oetRSRefIntDocDate').datepicker('show');
        });

        $('#obtRSBrowseRefExtDocDate').unbind().click(function() {
            $('#oetRSRefExtDocDate').datepicker('show');
        });

        $('#obtRSFrmSplInfoDueDate').unbind().click(function() {
            $('#oetRSFrmSplInfoDueDate').datepicker('show');
        });

        $('#obtRSFrmSplInfoBillDue').unbind().click(function() {
            $('#oetRSFrmSplInfoBillDue').datepicker('show');
        });

        $('#obtRSFrmSplInfoTnfDate').unbind().click(function() {
            $('#oetRSFrmSplInfoTnfDate').datepicker('show');
        });
        /** =============================================================== */

        /** ================== Check Box Auto GenCode ===================== */
        $('#ocbRSStaAutoGenCode').on('change', function(e) {
            if ($('#ocbRSStaAutoGenCode').is(':checked')) {
                $("#oetRSDocNo").val('');
                $("#oetRSDocNo").attr("readonly", true);
                $('#oetRSDocNo').closest(".form-group").css("cursor", "not-allowed");
                $('#oetRSDocNo').css("pointer-events", "none");
                $("#oetRSDocNo").attr("onfocus", "this.blur()");
                $('#ofmRSFormAdd').removeClass('has-error');
                $('#ofmRSFormAdd .form-group').closest('.form-group').removeClass("has-error");
                $('#ofmRSFormAdd em').remove();
            } else {
                $('#oetRSDocNo').closest(".form-group").css("cursor", "");
                $('#oetRSDocNo').css("pointer-events", "");
                $('#oetRSDocNo').attr('readonly', false);
                $("#oetRSDocNo").removeAttr("onfocus");
            }
        });
        /** =============================================================== */

        $('#ocmRSFrmSplInfoVatInOrEx').on('change', function(e) {
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxOpenLoading();
                JSvRSLoadPdtDataTableHtml();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });


        var nRSStaApv = $('#ohdRSStaApv').val();

        if (nRSStaApv == 2 || nRSStaApv == 1) {

            $('#obtRSDocBrowsePdt').hide();
            $('#obtRSPrintDoc').hide();
            $('#obtRSCancelDoc').hide();
            $('#obtRSApproveDoc').hide();
            $('#odvRSBtnGrpSave').hide();
            // $('.xCNIconTable').addClass('xCNIconDel');
            // $('.xCNIconTable').addClass('xCNDocDisabled');
            // $('.ocbListItem').attr('disabled',true);

            $('#oetRSInsertBarcode').hide();
        }

        // JSxRSChkStaDocCallModalMQ();

    });



    $('.xRsSelectTypeOption').unbind().click(function() {
        let nTarget = $(this).data('target');

        if (nTarget == 1) {

            $('#oeiRsIconFilter').show();
            $('#oeiRsIconScan').hide();

            $('#oetRSFrmFilterPdtHTML').show();
            $('#oetRSInsertBarcode').hide();

        } else {

            $('#oeiRsIconFilter').hide();
            $('#oeiRsIconScan').show();

            $('#oetRSFrmFilterPdtHTML').hide();
            $('#oetRSInsertBarcode').show();

        }
    });

    // ========================================== Brows Option Conditon ===========================================
    // ตัวแปร Option Browse Modal กลุ่มธุรกิจ
    var oMerchantOption = function(poDataFnc) {
        var tRSBchCode = poDataFnc.tRSBchCode;
        var tInputReturnCode = poDataFnc.tReturnInputCode;
        var tInputReturnName = poDataFnc.tReturnInputName;
        var tNextFuncName = poDataFnc.tNextFuncName;
        var aArgReturn = poDataFnc.aArgReturn;
        var tWhereModal = "";

        // สถานะกลุ่มธุรกิจต้องใช้งานเท่านั้น
        tWhereModal += " AND (TCNMMerchant.FTMerStaActive = 1)";

        // เช็คเงื่อนไขแสดงกลุ่มธุรกิจเฉพาะสาขาตัวเอง
        if (typeof(tRSBchCode) != undefined && tRSBchCode != "") {
            tWhereModal += " AND ((SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '" + tRSBchCode + "') != 0)";
        }

        // ตัวแปร ออฟชั่นในการ Return
        var oOptionReturn = {
            Title: ['company/merchant/merchant', 'tMerchantTitle'],
            Table: {
                Master: 'TCNMMerchant',
                PK: 'FTMerCode'
            },
            Join: {
                Table: ['TCNMMerchant_L'],
                On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tWhereModal]
            },
            GrideView: {
                ColumnPathLang: 'company/merchant/merchant',
                ColumnKeyLang: ['tMerCode', 'tMerName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMMerchant.FTMerCode ASC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMMerchant.FTMerCode"],
                Text: [tInputReturnName, "TCNMMerchant_L.FTMerName"],
            },
            NextFunc: {
                FuncName: tNextFuncName,
                ArgReturn: aArgReturn
            },
            RouteAddNew: 'merchant',
            BrowseLev: nRSStaRSBrowseType
        };
        return oOptionReturn;
    }

    // ตัวแปร Option Browse Modal ร้านค้า
    var oShopOption = function(poDataFnc) {
        var tRSBchCode = poDataFnc.tRSBchCode;
        var tRSMerCode = poDataFnc.tRSMerCode;
        var tInputReturnCode = poDataFnc.tReturnInputCode;
        var tInputReturnName = poDataFnc.tReturnInputName;
        var tNextFuncName = poDataFnc.tNextFuncName;
        var aArgReturn = poDataFnc.aArgReturn;
        var tWhereModal = "";

        // สถานะร้านค้าใช้งาน
        tWhereModal += " AND (TCNMShop.FTShpStaActive = 1) AND TCNMShop.FTShpType  = 4";

        // เช็คเงื่อนไขแสดงร้านค้าในสาขาตัวเอง
        if (typeof(tRSBchCode) != undefined && tRSBchCode != "") {
            tWhereModal += " AND (TCNMShop.FTBchCode = '" + tRSBchCode + "') "
        }

        // เช็คเงื่อนไขแสดงร้านค้าในกลุ่มธุรกิจตัวเอง
        if (typeof(tRSMerCode) != undefined && tRSMerCode != "") {
            tWhereModal += " AND (TCNMShop.FTMerCode = '" + tRSMerCode + "') ";

        }

        // ตัวแปร ออฟชั่นในการ Return
        var oOptionReturn = {
            Title: ["company/shop/shop", "tSHPTitle"],
            Table: {
                Master: "TCNMShop",
                PK: "FTShpCode"
            },
            Join: {
                Table: ['TCNMShop_L'],
                On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,

                ]
            },
            Where: {
                Condition: [tWhereModal]
            },
            GrideView: {
                ColumnPathLang: 'company/shop/shop',
                ColumnKeyLang: ['tShopCode', 'tShopName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTShpType', 'TCNMShop.FTBchCode'],
                DataColumnsFormat: ['', '', '', ''],
                DisabledColumns: [2, 3, 4, 5],
                Perpage: 10,
                OrderBy: ['TCNMShop_L.FTShpName ASC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMShop.FTShpCode"],
                Text: [tInputReturnName, "TCNMShop_L.FTShpName"],
            },
            NextFunc: {
                FuncName: tNextFuncName,
                ArgReturn: aArgReturn
            },
            RouteAddNew: 'shop',
            BrowseLev: nRSStaRSBrowseType,
        };
        return oOptionReturn;
    }

    // ตัวแปร Option Browse Modal เครื่องจุดขาย
    var oPosOption = function(poDataFnc) {
        var tRSBchCode = poDataFnc.tRSBchCode;
        var tRSShpCode = poDataFnc.tRSShpCode;
        var tInputReturnCode = poDataFnc.tReturnInputCode;
        var tInputReturnName = poDataFnc.tReturnInputName;
        var tNextFuncName = poDataFnc.tNextFuncName;
        var aArgReturn = poDataFnc.aArgReturn;
        var tWhereModal = "";

        // สถานะเครื่องจุดขายต้องใช้งาน
        tWhereModal += " AND (TVDMPosShop.FTPshStaUse  = 1)";

        // เช็คเงื่อนไขแสดงร้านค้าในสาขาตัวเอง
        if (typeof(tRSBchCode) != undefined && tRSBchCode != "") {
            tWhereModal += " AND (TVDMPosShop.FTBchCode = '" + tRSBchCode + "') ";
        }

        // เช็คเงื่อนไขแสดงร้านค้าในร้านค้าตัวเอง
        if (typeof(tRSShpCode) != undefined && tRSShpCode != "") {
            tWhereModal += " AND (TVDMPosShop.FTShpCode = '" + tRSShpCode + "')";
        }

        // ตัวแปร ออฟชั่นในการ Return
        var oOptionReturn = {
            Title: ["pos/posshop/posshop", "tPshTitle"],
            Table: {
                Master: 'TVDMPosShop',
                PK: 'FTPosCode'
            },
            Join: {
                Table: ['TCNMPos_L', 'TCNMWaHouse', 'TCNMWaHouse_L'],
                On: [
                    "TCNMPos_L.FTPosCode = TVDMPosShop.FTPosCode AND TCNMPos_L.FtBchCode = TVDMPosShop.FTBchCode",
                    "TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TVDMPosShop.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse.FTWahStaType = 6",
                    "TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode=TCNMWaHouse_L.FTBchCode  AND TCNMWaHouse_L.FNLngID = '" + nLangEdits + "'"
                ]
            },
            Where: {
                Condition: [tWhereModal]
            },
            GrideView: {
                ColumnPathLang: 'pos/posshop/posshop',
                ColumnKeyLang: ['tPshBRWShopTBCode', 'tPshBRWPosTBName'],
                ColumnsSize: ['25%', '75%'],
                WidthModal: 50,
                DataColumns: ['TVDMPosShop.FTPosCode', 'TCNMPos_L.FTPosName', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['', ''],
                DisabledColumns: [2, 3],
                Perpage: 5,
                OrderBy: ['TVDMPosShop.FTPosCode ASC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TVDMPosShop.FTPosCode"],
                Text: [tInputReturnName, "TVDMPosShop.FTPosName"]
            },
            NextFunc: {
                FuncName: tNextFuncName,
                ArgReturn: aArgReturn
            },
            RouteAddNew: 'salemachine',
            BrowseLev: nRSStaRSBrowseType
        };
        return oOptionReturn;
    }

    // ตัวแปร Option Browse Modal คลังสินค้า
    var oWahOption = function(poDataFnc) {
        var tRSBchCode = poDataFnc.tRSBchCode;
        var tRSShpCode = poDataFnc.tRSShpCode;
        var tRSPosCode = poDataFnc.tRSPosCode;
        var tInputReturnCode = poDataFnc.tReturnInputCode;
        var tInputReturnName = poDataFnc.tReturnInputName;
        var tNextFuncName = poDataFnc.tNextFuncName;
        var aArgReturn = poDataFnc.aArgReturn;
        var tWhereModal = "";

        // Where คลังของ สาขา
        // if( tRSBchCode != "" ){
        //     tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN ('1','2') AND  TCNMWaHouse.FTBchCode='"+tRSBchCode+"')";
        // }

        // Where คลังของ ร้านค้า
        // if(tRSShpCode  != "" && tRSPosCode == ""){
        // tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (4))";
        // tWhereModal += " AND (TCNMWaHouse.FTWahRefCode = '"+tRSShpCode+"')";
        // }

        // Where คลังของ เครื่องจุดขาย
        // if(tRSShpCode  != "" && tRSPosCode != ""){
        //     tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (6))";
        //     tWhereModal += " AND (TCNMWaHouse.FTWahRefCode = '"+tRSPosCode+"')";
        // }



        //     if(tRSShpCode  != ""){
        //     var oOptionReturn = {
        //     Title   : ['company/shop/shop','tSHPWah'],
        //     Table   : {Master:'TCNMShpWah',PK:'FTWahCode'},
        //     Join    : {
        //         Table   : ['TCNMWaHouse_L' , 'TCNMWaHouse'],
        //         On      : [
        //                     'TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMShpWah.FTBchCode  AND TCNMWaHouse_L.FNLngID = '+nLangEdits,
        //                     'TCNMShpWah.FTWahCode =  TCNMWaHouse.FTWahCode AND  TCNMShpWah.FTBchCode = TCNMWaHouse.FTBchCode '
        //                     ]
        //     },
        //     Where : {
        //         Condition : [" AND TCNMShpWah.FTShpCode = '" + tRSShpCode + "' AND TCNMShpWah.FTBchCode = '"+ tRSBchCode + "' "]
        //     },
        //     GrideView : {
        //         ColumnPathLang  : 'company/shop/shop',
        //         ColumnKeyLang   : ['tWahCode','tWahName'],
        //         ColumnsSize     : ['15%','75%'],
        //         WidthModal      : 50,
        //         DataColumns     : ['TCNMShpWah.FTWahCode','TCNMWaHouse_L.FTWahName'],
        //         DataColumnsFormat : ['',''],
        //         Perpage         : 10,
        //         OrderBy   : ['TCNMWaHouse_L.FTWahName'],
        //         SourceOrder  : "ASC"
        //     },
        //     CallBack : {
        //         ReturnType : 'S',
        //         Value  : [tInputReturnCode,"TCNMShpWah.FTWahCode"],
        //         Text  : [tInputReturnName,"TCNMWaHouse_L.FTWahName"],
        //     }
        //    }
        // }else
        // if(tRSShpCode == ""){
        var oOptionReturn = {
            Title: ["company/warehouse/warehouse", "tWAHTitle"],
            Table: {
                Master: "TCNMWaHouse",
                PK: "FTWahCode"
            },
            Join: {
                Table: ["TCNMWaHouse_L"],
                On: ["TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode=TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '" + nLangEdits + "'"]
            },
            Where: {
                Condition: [" AND (TCNMWaHouse.FTWahStaType IN ('1','2') AND  TCNMWaHouse.FTBchCode = '" + tRSBchCode + "') "]
            },
            GrideView: {
                ColumnPathLang: 'company/warehouse/warehouse',
                ColumnKeyLang: ['tWahCode', 'tWahName'],
                DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['', ''],
                ColumnsSize: ['15%', '75%'],
                Perpage: 5,
                WidthModal: 50,
                OrderBy: ['TCNMWaHouse_L.FTWahName ASC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMWaHouse.FTWahCode"],
                Text: [tInputReturnName, "TCNMWaHouse_L.FTWahName"]
            },
            NextFunc: {
                FuncName: tNextFuncName,
                ArgReturn: aArgReturn
            },
            RouteAddNew: 'warehouse',
            BrowseLev: nRSStaRSBrowseType
        }
        // }
        return oOptionReturn;
    }




    // ตัวแปร Option Browse Modal ตัวแทนจำหน่าย
    var oRcvOption = function(poDataFnc) {
        var tInputReturnCode = poDataFnc.tReturnInputCode;
        var tInputReturnName = poDataFnc.tReturnInputName;
        var tNextFuncName = poDataFnc.tNextFuncName;
        var aArgReturn = poDataFnc.aArgReturn;
        var tSessionAgnCode = '<?= $this->session->userdata('tSesUsrAgnCode') ?>';
        var tConditionWhereSpc = "";

        if ($('#oetRSFrmBchCode').val() != '') {
            tConditionWhereSpc = " OR ( ISNULL(TFNMRcvSpc.FTaggCode,'')='" + tSessionAgnCode + "' AND  TFNMRcvSpc.FTAppCode='VD' AND ( ISNULL(TFNMRcvSpc.FTBchCode,'')='' OR ISNULL(TFNMRcvSpc.FTBchCode,'')='" + $('#oetRSFrmBchCode').val() + "' ) )";
        }


        if ($('#oetRSFrmBchCode').val() != '' && $('#oetRSFrmShpCode').val() != '') {
            tConditionWhereSpc = " OR ( ISNULL(TFNMRcvSpc.FTaggCode,'')='" + tSessionAgnCode + "' AND TFNMRcvSpc.FTAppCode='VD' AND  ISNULL(TFNMRcvSpc.FTBchCode,'')='" + $('#oetRSFrmBchCode').val() + "' AND ( ISNULL(TFNMRcvSpc.FTShpCode,'')=''  OR ISNULL(TFNMRcvSpc.FTShpCode,'')='" + $('#oetRSFrmShpCode').val() + "' ) )";
        }


        if ($('#oetRSFrmBchCode').val() != '' && $('#oetRSFrmShpCode').val() != '' && $('#oetRSFrmPosCode').val() != '') {
            tConditionWhereSpc = " OR ( ISNULL(TFNMRcvSpc.FTaggCode,'')='" + tSessionAgnCode + "' AND TFNMRcvSpc.FTAppCode='VD' AND  ISNULL(TFNMRcvSpc.FTBchCode,'')='" + $('#oetRSFrmBchCode').val() + "' AND ISNULL(TFNMRcvSpc.FTShpCode,'')='" + $('#oetRSFrmShpCode').val() + "' AND ( ISNULL(TFNMRcvSpc.FTPosCode,'')=''  OR ISNULL(TFNMRcvSpc.FTPosCode,'')='" + $('#oetRSFrmPosCode').val() + "' ) )";
        }


        var oOptionReturn = {
            Title: ['payment/recive/recive', 'tRCVTitle'],
            Table: {
                Master: 'TFNMRcv',
                PK: 'FTRcvCode'
            },
            Join: {
                Table: ['TFNMRcv_L', 'TFNMRcvSpc'],
                On: [
                    'TFNMRcv_L.FTRcvCode = TFNMRcv.FTRcvCode AND TFNMRcv_L.FNLngID = ' + nLangEdits,
                    "TFNMRcv.FTRcvCode  =  TFNMRcvSpc.FTRcvCode  "
                ]
            },
            Where: {
                Condition: [
                    "AND TFNMRcv.FTRcvStaUse = '1' AND ( ISNULL(TFNMRcvSpc.FTRcvCode,'')='')  " + tConditionWhereSpc
                ]
            },
            GrideView: {
                ColumnPathLang: 'payment/recive/recive',
                ColumnKeyLang: ['tRCVCode', 'tRCVName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TFNMRcv.FTRcvCode', 'TFNMRcv_L.FTRcvName'],
                DataColumnsFormat: ['', ''],
                DisabledColumns: [2, 3, 4, 5],
                Perpage: 5,
                OrderBy: ['TFNMRcv_L.FTRcvCode ASC']
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TFNMRcv.FTRcvCode"],
                Text: [tInputReturnName, "TFNMRcv_L.FTRcvName"]
            },
            NextFunc: {
                FuncName: tNextFuncName,
                ArgReturn: aArgReturn
            },
            RouteAddNew: 'recive',
            BrowseLev: nRSStaRSBrowseType
        };
        return oOptionReturn;
    }


    // ตัวแปร Option Browse Modal ตัวแทนจำหน่าย
    var oCstOption = function(poDataFnc) {
        var tInputReturnCode = poDataFnc.tReturnInputCode;
        var tInputReturnName = poDataFnc.tReturnInputName;
        var tNextFuncName = poDataFnc.tNextFuncName;
        var aArgReturn = poDataFnc.aArgReturn;
        var oOptionReturn = {
            Title: ['customer/customer/customer', 'tCSTTitle'],
            Table: {
                Master: 'TCNMCst',
                PK: 'FTCstCode'
            },
            Join: {
                Table: ['TCNMCst_L', 'TCNMCstCard'],
                On: [
                    'TCNMCst_L.FTCstCode = TCNMCst.FTCstCode AND TCNMCst_L.FNLngID = ' + nLangEdits,
                    'TCNMCst.FTCstCode = TCNMCstCard.FTCstCode'
                ]
            },
            Where: {
                Condition: ["AND TCNMCst.FTCstStaActive = '1' "]
            },
            GrideView: {
                ColumnPathLang: 'customer/customer/customer',
                ColumnKeyLang: ['tCSTCode', 'tCSTName', 'tCSTTel', 'tCSTTel', 'tCSTTel', 'tCSTTel', 'tCSTTel', 'tCSTCardNo'],
                ColumnsSize: ['15%', '30%', '20%', '20%'],
                WidthModal: 50,
                DataColumns: ['TCNMCst.FTCstCode', 'TCNMCst_L.FTCstName', 'TCNMCst.FTCstCardID', 'TCNMCst.FTCstTel', 'TCNMCst.FTPplCodeRet', 'TCNMCst.FTCstDiscRet', 'TCNMCst.FTCstStaAlwPosCalSo', 'TCNMCstCard.FTCstCrdNo'],
                DataColumnsFormat: ['', '', '', '', '', '', '', ''],
                DisabledColumns: [2, 4, 5, 6],
                Perpage: 10,
                OrderBy: ['TCNMCst.FDCreateOn DESC']
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMCst.FTCstCode"],
                Text: [tInputReturnName, "TCNMCst_L.FTCstName"]
            },
            NextFunc: {
                FuncName: tNextFuncName,
                ArgReturn: aArgReturn
            },
            RouteAddNew: 'customer',
            BrowseLev: nRSStaRSBrowseType
        };
        return oOptionReturn;
    }


    // Option Modal เหตุผล
    var oRSBrowseRsn = function(poDataFnc) {
        var tInputReturnCode = poDataFnc.tReturnInputCode;
        var tInputReturnName = poDataFnc.tReturnInputName;
        var oOptionReturn = {
            Title: ["other/reason/reason", "tRSNTitle"],
            Table: {
                Master: "TCNMRsn",
                PK: "FTRsnCode"
            },
            Join: {
                Table: ["TCNMRsn_L"],
                On: ["TCNMRsn.FTRsnCode = TCNMRsn_L.FTRsnCode AND TCNMRsn_L.FNLngID = '" + nLangEdits + "'"]
            },
            Where: {
                Condition: ["  AND TCNMRsn.FTRsgCode = '003' "]
            },
            GrideView: {
                ColumnPathLang: 'other/reason/reason',
                ColumnKeyLang: ['tRSNTBCode', 'tRSNTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMRsn.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMRsn.FTRsnCode"],
                Text: [tInputReturnName, "TCNMRsn_L.FTRsnName"],
            },
            RouteAddNew: 'reason',
            BrowseLev: nRSStaRSBrowseType,
        };
        return oOptionReturn;
    }

    // ============================================================================================================

    // ========================================== Brows Event Conditon ===========================================
    // Event Browse Merchant
    $('#obtRSBrowseMerchant').unbind().click(function() {
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oRSBrowseMerchantOption = undefined;
            oRSBrowseMerchantOption = oMerchantOption({
                'tRSBchCode': $('#oetRSFrmBchCode').val(),
                'tReturnInputCode': 'oetRSFrmMerCode',
                'tReturnInputName': 'oetRSFrmMerName',
                'tNextFuncName': 'JSxRSSetConditionMerchant',
                'aArgReturn': ['FTMerCode', 'FTMerName'],
            });
            JCNxBrowseData('oRSBrowseMerchantOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Shop
    $('#obtRSBrowseShop').unbind().click(function() {
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oRSBrowseShopOption = undefined;
            oRSBrowseShopOption = oShopOption({
                'tRSBchCode': $('#oetRSFrmBchCode').val(),
                'tRSMerCode': $('#oetRSFrmMerCode').val(),
                'tReturnInputCode': 'oetRSFrmShpCode',
                'tReturnInputName': 'oetRSFrmShpName',
                'tNextFuncName': 'JSxRSSetConditionShop',
                'aArgReturn': ['FTBchCode', 'FTShpType', 'FTShpCode', 'FTShpName']
            });
            JCNxBrowseData('oRSBrowseShopOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Pos
    $('#obtRSBrowsePos').unbind().click(function() {
        // alert(111);
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oRSBrowsePosOption = undefined;
            oRSBrowsePosOption = oPosOption({
                'tRSBchCode': $('#oetRSFrmBchCode').val(),
                'tRSShpCode': $('#oetRSFrmShpCode').val(),
                'tReturnInputCode': 'oetRSFrmPosCode',
                'tReturnInputName': 'oetRSFrmPosName',
                'tNextFuncName': 'JSxRSSetConditionPos',
                'aArgReturn': ['FTPosCode', 'FTWahCode', 'FTWahName']
            });
            JCNxBrowseData('oRSBrowsePosOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Warehouse
    $('#obtRSBrowseWahouse').unbind().click(function() {
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oRSBrowseWahOption = undefined;
            oRSBrowseWahOption = oWahOption({
                'tRSBchCode': $('#oetRSFrmBchCode').val(),
                'tRSShpCode': $('#oetRSFrmShpCode').val(),
                'tRSPosCode': $('#oetRSFrmWahCode').val(),
                'tReturnInputCode': 'oetRSFrmWahCode',
                'tReturnInputName': 'oetRSFrmWahName',
                'tNextFuncName': 'JSxRSSetConditionWahouse',
                'aArgReturn': []
            });
            JCNxBrowseData('oRSBrowseWahOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    // Event Browse Customer
    $('#obtRSBrowseCustomer').unbind().click(function() {
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oRSBrowseSplOption = undefined;
            oRSBrowseCstOption = oCstOption({
                'tReturnInputCode': 'oetRSFrmCstCode',
                'tReturnInputName': 'oetRSFrmCstName',
                'tNextFuncName': 'JSxRSSetConditionAfterSelectCst',
                'aArgReturn': ['FTCstCode', 'FTCstName', 'FTCstCardID', 'FTCstTel', 'FTPplCodeRet', 'FTCstDiscRet', 'FTCstStaAlwPosCalSo']
            });
            JCNxBrowseData('oRSBrowseCstOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    // Event Browse Supplier
    $('#obtRSBrowseRecive').unbind().click(function() {
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oRSBrowseRcvOption = undefined;
            oRSBrowseRcvOption = oRcvOption({
                'tReturnInputCode': 'oetRSRcvCode',
                'tReturnInputName': 'oetRSRcvName',
                'tNextFuncName': '',
                'aArgReturn': ['FTRcvCode', 'FTRcvName']
            });
            JCNxBrowseData('oRSBrowseRcvOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Modal เหตุผล
    $('#obtRSBrowseRsn').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRSBrowseRsnOption = undefined;
            oRSBrowseRsnOption = oRSBrowseRsn({
                'tReturnInputCode': "oetRSRsnCode",
                'tReturnInputName': "oetRSRsnName",
            });
            JCNxBrowseData('oRSBrowseRsnOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    // ===========================================================================================================

    // ====================================== Function NextFunc Browse Modal =====================================
    // Functionality : Function Behind NextFunc กลุ่มธุรกิจ
    // Parameter : Event Next Func Modal
    // Create : 26/06/2019 Wasin(Yoshi)
    // Return : Set value And Control Input
    // Return Type : -
    function JSxRSSetConditionMerchant(poDataNextFunc) {
        var aDataNextFunc, tRSMerCode, tRSMerName;
        if (typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL") {
            aDataNextFunc = JSON.parse(poDataNextFunc);
            tRSMerCode = aDataNextFunc[0];
            tRSMerName = aDataNextFunc[1];
        }

        let tRSBchCode = $('#oetRSFrmBchCode').val();
        let tRSMchCode = $('#oetRSFrmMerCode').val();
        let tRSMchName = $('#oetRSFrmMerName').val();
        let tRSShopCode = $('#oetRSFrmShpCode').val();
        let tRSShopName = $('#oetRSFrmShpName').val();
        let tRSPosCode = $('#oetRSFrmPosCode').val();
        let tRSPosName = $('#oetRSFrmPosName').val();
        let tRSWahCode = $('#oetRSFrmWahCode').val();
        let tRSWahName = $('#oetRSFrmWahName').val();

        let nCountDataInTable = $('#otbRSDocPdtAdvTableList tbody .xWPdtItem').length;

        if (nCountDataInTable > 0 && tRSMchCode != "" && tRSShopCode != "" && tRSWahCode != "") {
            // รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนกลุ่มธุรกิจ
            var tTextMssage = '<?php echo language('document/purchaseinvoice/purchaseinvoice', 'tRSMsgNotiChangeMerchantClearDocTemp'); ?>';
            FSvCMNSetMsgWarningDialog("<p>" + tTextMssage + "</p>");

            // Event CLick Close Massage And Delete Temp
            $('#odvModalWanning .xWBtnOK').click(function(evn) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmRSClearDataDocTemp",
                    data: {
                        'ptRSDocNo': $("#oetRSDocNo").val()
                    },
                    cache: false,
                    success: function(oResult) {
                        var aDataReturn = JSON.parse(oResult);
                        var tMessageError = aDataReturn['tStaMessg'];
                        switch (aDataReturn['nStaReturn']) {
                            case 1:
                                JSvRSLoadPdtDataTableHtml();
                                JCNxCloseLoading();
                                break;
                            case 800:
                                FSvCMNSetMsgErrorDialog(tMessageError);
                                break;
                            case 500:
                                FSvCMNSetMsgErrorDialog(tMessageError);
                                break;
                        }
                        $('#odvModalWanning .xWBtnOK').unbind();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }

        // $('#obtRSBrowseShop').attr('disabled', true);
        $('#obtRSBrowsePos').attr('disabled', true);
        // $('#obtRSBrowseWahouse').attr('disabled', true);

        if (tSesUsrLevel == 'HQ' || tSesUsrLevel == 'BCH') {
            if ((tRSMchCode == "" && tRSMchName == "") && (tRSShopCode == "" && tRSShopName == "") && (tRSPosCode == "" && tRSPosName == "")) {
                $('#obtRSBrowseWahouse').attr('disabled', false).removeClass('disabled');
                $('#obtRSBrowseShop').attr('disabled', false).removeClass('disabled');
            } else {
                // $('#obtRSBrowseShop').attr('disabled',false).removeClass('disabled');
                // $('#obtRSBrowseWahouse').attr('disabled', true).addClass('disabled');
            }

            $('#oetRSFrmShpCode,#oetRSFrmShpName').val('');
            $('#oetRSFrmPosCode,#oetRSFrmPosName').val('');
            $('#oetRSFrmWahCode,#oetRSFrmWahName').val('');
        }
    }

    // Functionality : Function Behind NextFunc ร้านค้า
    // Parameter : Event Next Func Modal
    // Create : 26/06/2019 Wasin(Yoshi)
    // Return : Set value And Control Input
    // Return Type : -
    function JSxRSSetConditionShop(poDataNextFunc) {
        var aDataNextFunc, tRSBchCode, tRSShpType, tRSShpCode, tRSShpName, tRSWahCode, tRSWahName;
        if (typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL") {
            aDataNextFunc = JSON.parse(poDataNextFunc);
            tRSBchCode = aDataNextFunc[0];
            tRSShpType = aDataNextFunc[1];
            tRSShpCode = aDataNextFunc[2];
            tRSShpName = aDataNextFunc[3];

        } else {
            $('#oetRSFrmWahCode,#oetRSFrmWahName').val('');
        }


        let tRSDataBchCode = $('#oetRSFrmBchCode').val();
        let tRSDataMchCode = $('#oetRSFrmMerCode').val();
        let tRSDataMchName = $('#oetRSFrmMerName').val();
        let tRSDataShopCode = $('#oetRSFrmShpCode').val();
        let tRSDataShopName = $('#oetRSFrmShpName').val();
        let tRSDataPosCode = $('#oetRSFrmPosCode').val();
        let tRSDataPosName = $('#oetRSFrmPosName').val();
        let tRSDataWahCode = $('#oetRSFrmWahCode').val();

        let nCountDataInTable = $('#otbRSDocPdtAdvTableList tbody .xWPdtItem').length;
        if (nCountDataInTable > 0 && tRSDataMchCode != "" && tRSDataShopCode != "" && tRSDataWahCode != "") {
            // Show Modal Notification Found Data In Table Doctemp Behide Change Shop 
            FSvCMNSetMsgWarningDialog("<p>รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนร้านค้าใหม่</p>");

            // Event CLick Close Massage And Delete Temp
            $('#odvModalWanning .xWBtnOK').click(function(evn) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmRSClearDataDocTemp",
                    data: {
                        'ptRSDocNo': $("#oetRSDocNo").val()
                    },
                    cache: false,
                    success: function(oResult) {
                        var aDataReturn = JSON.parse(oResult);
                        var tMessageError = aDataReturn['tStaMessg'];
                        switch (aDataReturn['nStaReturn']) {
                            case 1:
                                JSvRSLoadPdtDataTableHtml();
                                JCNxCloseLoading();
                                break;
                            case 800:
                                FSvCMNSetMsgErrorDialog(tMessageError);
                                break;
                            case 500:
                                FSvCMNSetMsgErrorDialog(tMessageError);
                                break;
                        }
                        $('#odvModalWanning .xWBtnOK').unbind();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }

        if (tSesUsrLevel == 'HQ' || tSesUsrLevel == 'BCH') {
            if (typeof(tRSShpName) != undefined && tRSShpName != '') {

                $('#obtRSBrowsePos').attr('disabled', false).removeClass('disabled');
                JSxRSFindWahouseDefaultByShop(tRSBchCode, tRSShpCode);

            } else {
                $('#obtRSBrowsePos').attr('disabled', true).addClass('disabled');
                $('#oetRSFrmWahCode,#oetRSFrmWahName').val('');
            }
            $('#oetRSFrmPosCode,#oetRSFrmPosName').val('');
        }

    }

    // Functionality : Function Behind NextFunc เครื่องจุดขาย
    // Parameter : Event Next Func Modal
    // Create : 26/06/2019 Wasin(Yoshi)
    // Return : Set value And Control Input
    // Return Type : -
    function JSxRSFindWahouseDefaultByShop(ptRSBchCode, ptRSShpCode) {

        $.ajax({
            type: "POST",
            url: "dcmRSFindWahouseDefaultByShop",
            data: {
                'tRSBchCode': ptRSBchCode,
                'tRSShpCode': ptRSShpCode
            },
            cache: false,
            success: function(oResult) {
                var aDataReturn = JSON.parse(oResult);
                var tMessageCode = aDataReturn['tCode'];
                if (tMessageCode == '1') {
                    var tWahCode = aDataReturn['aItems']['FTWahCode'];
                    var tWahName = aDataReturn['aItems']['FTWahName'];
                    $('#oetRSFrmWahCode').val(tWahCode);
                    $('#oetRSFrmWahName').val(tWahName);
                } else {
                    $('#oetRSFrmWahCode').val('');
                    $('#oetRSFrmWahName').val('');
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }

    // Functionality : Function Behind NextFunc เครื่องจุดขาย
    // Parameter : Event Next Func Modal
    // Create : 26/06/2019 Wasin(Yoshi)
    // Return : Set value And Control Input
    // Return Type : -
    function JSxRSSetConditionPos(poDataNextFunc) {

        var aDataNextFunc, tRSBchCode, tRSShpCode, tRSPosCode, tRSWahCode, tRSWahName;
        if (typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL") {
            aDataNextFunc = JSON.parse(poDataNextFunc);
            // tRSBchCode      = aDataNextFunc[0];
            // tRSShpCode      = aDataNextFunc[1];
            tRSPosCode = aDataNextFunc[0];
            tRSWahCode = aDataNextFunc[1];
            tRSWahName = aDataNextFunc[2];
            // $('#oetRSFrmWahCode,#oetRSFrmWahName').val('')
            $('#obtRSBrowsePos').attr('disabled', false).removeClass('disabled');
            // $('#obtRSBrowseWahouse').attr('disabled',true).addClass('disabled');
        } else {
            $('#oetRSFrmPosCode,#oetRSFrmPosCode').val('');
            // $('#oetRSFrmWahCode').val('');
            // $('#oetRSFrmWahName').val('');
            return;
        }
        // $('#obtRSBrowseWahouse').attr('disabled',true).addClass('disabled');
        // $('#obtRSBrowseWahouse').attr('disabled',false).removeClass('disabled');

    }



    function JSxRSSetConditionAfterSelectCst(poDataNextFunc) {
        var aData;
        if (poDataNextFunc != "NULL") {
            aData = JSON.parse(poDataNextFunc);
            var poParams = {
                FTCstCode: aData[0],
                FTCstName: aData[1],
                FTCstCtzID: aData[2],
                FTCstTel: aData[3],
                FTPplCode: aData[4],
                FTCstDiscRet: aData[5],
                FTCstStaAlwPosCalSo: aData[6]
            };
            // conRSle.log(poDataNextFunc);
            // JSxRSSetPanelCustomerData(poParams);
            // JSxRSClearDTTmp(aData[5]);


        }
    }

    // Functionality : Posecc AddDisTmpCst
    // Parameters : FTCstDiscRet
    // Creator : 18/02/2020 Nattakit(Nale)
    // Return : -
    // Return Type : -
    function JSxRSPocessAddDisTmpCst(rtCstDiscRet) {
        $.ajax({
            type: "POST",
            url: "dcmRSPocessAddDisTmpCst",

            data: {
                tCstDiscRet: rtCstDiscRet,
                tBchCode: $('#oetRSFrmBchCode').val(),
                tDocNo: $('#oetRSDocNo').val(),
                tVatInOrEx: $('#ocmRSFrmSplInfoVatInOrEx').val(), // 1: รวมใน, 2: แยกนอก
            },
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                var aDataReturn = JSON.parse(oResult);
                if (aDataReturn['nStaEvent'] == '1') {
                    JSvRSLoadPdtDataTableHtml();
                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


    function JSxRSSetPanelCustomerData(poParams) {

        $("#oetRSFrmCstHNNumber").val(poParams.FTCstCode);
        $("#oetRSFrmCstCtzID").val(poParams.FTCstCtzID);
        $("#oetRSFrmCustomerName").val(poParams.FTCstName);
        $("#oetRSFrmCstTel").val(poParams.FTCstTel);
        $('#ohdRSPplCodeCst').val(poParams.FTPplCode);
        if (poParams.FTCstStaAlwPosCalSo == 1) {
            $('#ocbRSStaAlwPosCalSo').prop('checked', true);
        } else {
            $('#ocbRSStaAlwPosCalSo').prop('checked', false);
        }
    }


    // ===========================================================================================================

    /** ================================== Manage Product Advance Table Colums  ================================== */
    // Event Call Modal Show Option Advance Product Doc DT Tabel
    $('#obtRSAdvTablePdtDTTemp').unbind().click(function() {
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxRSOpenColumnFormSet();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    $('#odvRSOrderAdvTblColumns #obtRSSaveAdvTableColums').unbind().click(function() {
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxRSSaveColumnShow();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Functionality : Call Advnced Table 
    // Parameters : Event Next Func Modal
    // Creator : 01/07/2019 Wasin(Yoshi)
    // Return : Open Modal Manage Colums Show
    // Return Type : -
    function JSxRSOpenColumnFormSet() {
        $.ajax({
            type: "POST",
            url: "dcmRSAdvanceTableShowColList",
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                var aDataReturn = JSON.parse(oResult);
                if (aDataReturn['nStaEvent'] == '1') {
                    var tViewTableShowCollist = aDataReturn['tViewTableShowCollist'];
                    $('#odvRSOrderAdvTblColumns .modal-body').html(tViewTableShowCollist);
                    $('#odvRSOrderAdvTblColumns').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    $("#odvRSOrderAdvTblColumns").modal({
                        show: true
                    });
                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality : Save Columns Show Advanced Table
    //Parameters : Event Next Func Modal
    //Creator : 02/07/2019 Wasin(Yoshi)
    //Return : Open Modal Manage Colums Show
    //Return Type : -
    function JSxRSSaveColumnShow() {
        // คอลัมน์ที่เลือกให้แสดง
        var aRSColShowSet = [];
        $("#odvRSOrderAdvTblColumns .xWPIInputColStaShow:checked").each(function() {
            aRSColShowSet.push($(this).data("id"));
        });

        // คอลัมน์ทั้งหมด
        var aRSColShowAllList = [];
        $("#odvRSOrderAdvTblColumns .xWPIInputColStaShow").each(function() {
            aRSColShowAllList.push($(this).data("id"));
        });

        // ชื่อคอลัมน์ทั้งหมดในกรณีมีการแก้ไขชื่อคอลัมน์ที่แสดง
        var aRSColumnLabelName = [];
        $("#odvRSOrderAdvTblColumns .xWPILabelColumnName").each(function() {
            aRSColumnLabelName.push($(this).text());
        });

        // สถานะย้อนกลับค่าเริ่มต้น
        var nRSStaSetDef;
        if ($("#odvRSOrderAdvTblColumns #ocbRSSetDefAdvTable").is(":checked")) {
            nRSStaSetDef = 1;
        } else {
            nRSStaSetDef = 0;
        }

        $.ajax({
            type: "POST",
            url: "dcmRSAdvanceTableShowColSave",
            data: {
                'pnRSStaSetDef': nRSStaSetDef,
                'paRSColShowSet': aRSColShowSet,
                'paRSColShowAllList': aRSColShowAllList,
                'paRSColumnLabelName': aRSColumnLabelName
            },
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                $("#odvRSOrderAdvTblColumns").modal("hide");
                $(".modal-backdrop").remove();
                JSvRSLoadPdtDataTableHtml();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
    // ===========================================================================================================




    //Functionality : Add Shiping Add To Input
    //Parameters : Event Next Func Modal
    //Creator : 04/07/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
    function JSnRSShipAddData() {
        var tRSShipAddSeqNoSelect = $('#ohdRSShipAddSeqNo').val();
        $('#ohdRSFrmShipAdd').val(tRSShipAddSeqNoSelect);
        $("#odvRSBrowseShipAdd").modal("hide");
        $('.modal-backdrop').remove();
    }

    // ===========================================================================================================




    // Functionality: Check Status Document Process EQ And Call Back MQ
    // Parameters: Event Document Ready Load Page
    // Creator: 11/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: -
    // ReturnType: -
    function JSxRSChkStaDocCallModalMQ() {
        var nRSLangEdits = nLangEdits;
        var tRSFrmBchCode = $("#oetRSFrmBchCode").val();
        var tRSUsrApv = $("#ohdRSApvCodeUsrLogin").val();
        var tRSDocNo = $("#oetRSDocNo").val();
        var tRSPrefix = "RESPPI";
        var tRSStaApv = $("#ohdRSStaApv").val();
        var tRSStaPrcStk = $("#ohdRSStaPrcStk").val();
        var tRSStaDelMQ = $("#ohdRSStaDelMQ").val();
        var tRSQName = tRSPrefix + "_" + tRSDocNo + "_" + tRSUsrApv;
        var tRSTableName = "TARTRSHD";
        var tRSFieldDocNo = "FTXphDocNo";
        var tRSFieldStaApv = "FTXphStaPrcStk";
        var tRSFieldStaDelMQ = "FTXphStaDelMQ";

        // MQ Message Config
        var poDocConfig = {
            tLangCode: nRSLangEdits,
            tUsrBchCode: tRSFrmBchCode,
            tUsrApv: tRSUsrApv,
            tDocNo: tRSDocNo,
            tPrefix: tRSPrefix,
            tStaDelMQ: tRSStaDelMQ,
            tStaApv: tRSStaApv,
            tQName: tRSQName
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
            ptDocTableName: tRSTableName,
            ptDocFieldDocNo: tRSFieldDocNo,
            ptDocFieldStaApv: tRSFieldStaApv,
            ptDocFieldStaDelMQ: tRSFieldStaDelMQ,
            ptDocStaDelMQ: tRSStaDelMQ,
            ptDocNo: tRSDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: "JSvRSCallPageEditDoc",
            tCallPageList: "JSvRSCallPageList"
        };

        // Check Show Progress %
        if (tRSDocNo != '' && (tRSStaApv == 2 || tRSStaPrcStk == 2)) {
            FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
        }

        // Check Delete MQ SubScrib
        if (tRSStaApv == 1 && tRSStaPrcStk == 1 && tRSStaDelMQ == "") {
            var poDelQnameParams = {
                ptPrefixQueueName: tRSPrefix,
                ptBchCode: tRSFrmBchCode,
                ptDocNo: tRSDocNo,
                ptUsrCode: tRSUsrApv
            };
            FSxCMNRabbitMQDeleteQname(poDelQnameParams);
            FSxCMNRabbitMQUpdateStaDeleteQname(poUpdateStaDelQnameParams);
        }
    }

    /**
     * Functionality : Print Document
     * Parameters : -
     * Creator : 28/08/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxRSPrintDoc() {

    }



    function JSxRSClearDTTmp(ptDataDisTmp) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "dcmRSClearDataDocTemp",
            data: {
                'ptRSDocNo': $("#oetRSDocNo").val()
            },
            cache: false,
            success: function(oResult) {
                var aDataReturn = JSON.parse(oResult);
                var tMessageError = aDataReturn['tStaMessg'];
                switch (aDataReturn['nStaReturn']) {
                    case 1:
                        if (ptDataDisTmp != '' && ptDataDisTmp != null && ptDataDisTmp != ' ') {

                            JSxRSPocessAddDisTmpCst(ptDataDisTmp);
                        } else {
                            JSvRSLoadPdtDataTableHtml();
                            JCNxCloseLoading();
                        }

                        break;
                    case 800:
                        FSvCMNSetMsgErrorDialog(tMessageError);
                        break;
                    case 500:
                        FSvCMNSetMsgErrorDialog(tMessageError);
                        break;
                }
                $('#odvModalWanning .xWBtnOK').unbind();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    $('#obtBrowseTWOBCH').click(function() {
        // JCNxBrowseData('oBrowse_BCH'); 

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oRSBrowseBranchOption = undefined;
            oRSBrowseBranchOption = oBranchOption({
                'tReturnInputCode': 'oetRSFrmBchCode',
                'tReturnInputName': 'oetRSFrmBchName',
                'tNextFuncName': 'JSxSetDefauleWahouse',
                'aArgReturn': ['FTBchCode', 'FTBchName', 'FTWahCode', 'FTWahName'],
            });
            JCNxBrowseData('oRSBrowseBranchOption');
        } else {
            JCNxShowMsgSessionExpired();
        }

    });


    // ========================================== Brows Option Conditon ===========================================
    // ตัวแปร Option Browse Modal สาขา
    var oBranchOption = function(poDataFnc) {
        var tInputReturnCode = poDataFnc.tReturnInputCode;
        var tInputReturnName = poDataFnc.tReturnInputName;
        var tNextFuncName = poDataFnc.tNextFuncName;
        var aArgReturn = poDataFnc.aArgReturn;

        tUsrLevel = "<?= $this->session->userdata('tSesUsrLevel') ?>";
        tBchMulti = "<?= $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        tSQLWhere = "";
        if (tUsrLevel != "HQ") {
            tSQLWhere = " AND TCNMBranch.FTBchCode IN (" + tBchMulti + ") ";
        }

        // ตัวแปร ออฟชั่นในการ Return
        var oOptionReturn = {
            Title: ['authen/user/user', 'tBrowseBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L', 'TCNMWaHouse_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits,
                    'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID =' + nLangEdits,
                ]
            },
            Where: {
                Condition: [tSQLWhere]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName', 'TCNMWaHouse_L.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['', ''],
                DisabledColumns: [2, 3],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FTBchCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMBranch.FTBchCode"],
                Text: [tInputReturnName, "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: tNextFuncName,
                ArgReturn: aArgReturn
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        return oOptionReturn;
    }


    //    var oBrowse_BCH = {
    //         Title   : ['company/branch/branch','tBCHTitle'],
    //         Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
    //         Join    : {
    //             Table   : ['TCNMBranch_L','TCNMWaHouse_L'],
    //             On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID ='+nLangEdits,
    //                         'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID ='+nLangEdits,
    //             ]
    //         },
    //         GrideView:{
    //             ColumnPathLang : 'company/branch/branch',
    //             ColumnKeyLang : ['tBCHCode','tBCHName',''],
    //             ColumnsSize     : ['15%','75%',''],
    //             WidthModal      : 50,
    //             DataColumns  : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMWaHouse_L.FTWahCode','TCNMWaHouse_L.FTWahName'],
    //             DataColumnsFormat : ['',''],
    //             DisabledColumns   : [2,3],
    //             Perpage   : 5,
    //             OrderBy   : ['TCNMBranch_L.FTBchName'],
    //             SourceOrder  : "ASC"
    //         },
    //         CallBack:{
    //             ReturnType : 'S',
    //             Value  : ["demo","TCNMBranch.FTBchCode"],
    //             Text  : ["demo","TCNMBranch_L.FTBchName"],
    //         },
    //         NextFunc    :   {
    //             FuncName    :   'JSxSetDefauleWahouse',
    //             ArgReturn   :   ['FTBchCode','FTBchName','FTWahCode','FTWahName']
    //         }
    //     }

    function JSxSetDefauleWahouse(ptData) {
        if (ptData == '' || ptData == 'NULL') {
            $('#oetRSFrmWahCode').val('');
            $('#oetRSFrmWahName').val('');
            $('#oetRSFrmMerCode').val('');
            $('#oetRSFrmMerName').val('');
        } else {
            var tResult = JSON.parse(ptData);
            //เช็คค่าเก่ากับค่าใหม่ ก่อนจะเเจ้งเตือนให้ล้างค่า
            if ($('#oetRSFrmBchCode').val() == tResult[0]) {

            } else {
                nRowCount = $('#otbRSDocPdtAdvTableList >tbody >tr').length;
                if (nRowCount >= 1) {
                    if ($('#otbRSDocPdtAdvTableList >tbody >tr > td').hasClass('xWPITextNotfoundDataPdtTable') == true) {
                        $('#oetRSFrmBchCode').val(tResult[0]);
                        $('#oetRSFrmBchName').val(tResult[1]);
                    } else {
                        //แจ้งเตือนว่ามีการเปลี่ยนค่า
                        $('#odvRSModalChangeBCH').modal('show');
                        $('#obtChangeBCH').on("click", function() {
                            $.ajax({
                                type: "POST",
                                url: "dcmRSClearDataDocTemp",
                                data: {
                                    'ptRSDocNo': $("#oetRSDocNo").val()
                                },
                                cache: false,
                                Timeout: 0,
                                success: function(oResult) {
                                    JSvRSLoadPdtDataTableHtml();
                                    $('#oetRSFrmBchCode').val(tResult[0]);
                                    $('#oetRSFrmBchName').val(tResult[1]);
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                                }
                            });
                        });
                    }
                }
            }

            $('#oetRSFrmWahCode').val(tResult[2]);
            $('#oetRSFrmWahName').val(tResult[3]);
        }

        $('#oetRSFrmShpCode').val('');
        $('#oetRSFrmShpName').val('');
        $('#oetRSFrmPosCode').val('');
        $('#oetRSFrmPosName').val('');
        $('#oetRSFrmWahCode').val('');
        $('#oetRSFrmWahName').val('');
        $('#oetRSFrmMerCode').val('');
        $('#oetRSFrmMerName').val('');
    }




    $('#oetRSBrowsRefDocNo').click(function() {
        // JCNxBrowseData('oBrowse_BCH'); 

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

            // var tRSRefDocNo = $('#oetRSRefDocNo').val();
            JSxRSFindBillSaleVDDocNo('');

        } else {
            JCNxShowMsgSessionExpired();
        }

    });


    function JSxRSFindBillSaleVDDocNo(tRSRefDocNo) {
        JCNxOpenLoading();

        let tRSRefDocDate = $('#oetRSRefDocDate').val();
        let tRSFrmBchCode = $('#oetRSFrmBchCode').val();
        let tRSFrmShpCode = $('#oetRSFrmShpCode').val();
        let tRSFrmPosCode = $('#oetRSFrmPosCode').val();
        let tRSSearchDocument = $('#oetRSSearchDocument').val();

        $.ajax({
            type: "POST",
            url: "dcmRSFindBillSaleVDDocNo",
            data: {
                'tRSFrmBchCode': tRSFrmBchCode,
                'tRSFrmShpCode': tRSFrmShpCode,
                'tRSFrmPosCode': tRSFrmPosCode,
                'tRSRefDocDate': tRSRefDocDate,
                'tRSRefDocNo': tRSRefDocNo,
                'tRSSearchDocument': tRSSearchDocument
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aResult = JSON.parse(oResult);
                if (aResult['tCode'] == '1') {
                    $('#othDataTableSalHD').html(aResult['tRSBillHeaderHtml']);
                    $('#othDataTableSalVD').html('<tr><td colspan="8" align="center"><?php echo language('document/returnsale/returnsale', 'tRSRefDocBillEmpty'); ?></td></tr>');
                    $('#odvRSBrowseBillSaleVD').modal('show');

                    if (tRSRefDocNo != '') {
                        $('.xSelectSaleBillHD').addClass('active');
                        JSxRSFindBillSaleVDDetail(tRSRefDocNo);

                        let ftbchcode = $('.xSelectSaleBillHD.active').data('ftbchcode');
                        let ftbchname = $('.xSelectSaleBillHD.active').data('ftbchname');
                        let ftshpcode = $('.xSelectSaleBillHD.active').data('ftshpcode');
                        let ftshpname = $('.xSelectSaleBillHD.active').data('ftshpname');
                        let ftposcode = $('.xSelectSaleBillHD.active').data('ftposcode');
                        let ftposname = $('.xSelectSaleBillHD.active').data('ftposname');
                        let docno = $('.xSelectSaleBillHD.active').data('docno');
                        let docdate = $('.xSelectSaleBillHD.active').data('docdate');
                        let ftcstcode = $('.xSelectSaleBillHD.active').data('ftcstcode');
                        let ftcstname = $('.xSelectSaleBillHD.active').data('ftcstname');
                        let ftrtecode = $('.xSelectSaleBillHD.active').data('ftrtecode');
                        let fcxrcrtefac = $('.xSelectSaleBillHD.active').data('fcxrcrtefac');
                        let ftrcvcode = $('.xSelectSaleBillHD.active').data('ftrcvcode');
                        let ftrcvname = $('.xSelectSaleBillHD.active').data('ftrcvname');
                        let oParameterBill = {
                            FTBchCode: ftbchcode,
                            FTBchName: ftbchname,
                            FTShpCode: ftshpcode,
                            FTShpName: ftshpname,
                            FTPosCode: ftposcode,
                            FTPosName: ftposname,
                            FTXshDocNo: docno,
                            FDXshDocDate: docdate,
                            FTCstCode: ftcstcode,
                            FTCstName: ftcstname,
                            FTRteCode: ftrtecode,
                            FCXrcRteFac: fcxrcrtefac,
                            FTRcvCode: ftrcvcode,
                            FTRcvName: ftrcvname,
                        }

                        var tParameterBillHD = JSON.stringify(oParameterBill);
                        $('#ohdParameterBillHD').val(tParameterBillHD);

                    }

                } else {
                    $('#odvRSModalBillNotFound').modal('show');
                }

                JCNxCloseLoading();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    }


    $('#obtRSSerchDocument').unbind().click(function() {

        JSxRSFindBillSaleVDDocNo('');

    });


    $('#oetRSSearchDocument').on('keypress', function(e) {
        event.preventDefault();
        if (event.keyCode == 13) {
            JSxRSFindBillSaleVDDocNo('');
        }
    });

    var oRSXBrowseSaleOption = function(poReturnInput) {
        let tNextFuncName = poReturnInput.tNextFuncName;
        let aArgReturn = poReturnInput.aArgReturn;
        let tInputReturnCode = poReturnInput.tReturnInputCode;
        let tInputReturnName = poReturnInput.tReturnInputName;
        let tRSRefDocDate = $('#oetRSRefDocDate').val();
        let tRSFrmBchCode = $('#oetRSFrmBchCode').val();
        let tRSFrmShpCode = $('#oetRSFrmShpCode').val();
        let tRSFrmPosCode = $('#oetRSFrmPosCode').val();
        let tWhere = "";


        if (tRSFrmBchCode != '') {
            tWhere += " AND TVDTSalHD.FTBchCode = '" + tRSFrmBchCode + "' ";
        }

        if (tRSFrmShpCode != '') {
            tWhere += " AND TVDTSalHD.FTShpCode = '" + tRSFrmShpCode + "' ";
        }

        if (tRSFrmPosCode != '') {
            tWhere += " AND TVDTSalHD.FTPosCode = '" + tRSFrmPosCode + "' ";
        }

        if (tRSRefDocDate != "") {
            tWhere += " AND CONVERT(VARCHAR(10),TVDTSalHD.FDXshDocDate,121) = '" + tRSRefDocDate + "' ";
        } else {
            tWhere += " ";
        }



        let oOptionReturn = {
            Title: ['document/returnsale/returnsale', 'tRSRefDocNo'],
            Table: {
                Master: 'TVDTSalHD',
                PK: 'FTXshDocNo'
            },
            Where: {
                Condition: [tWhere]
            },
            // Filter:{
            // 	Selector    : 'oetIFXBchCodeSale',
            // 	Table       : 'TCNTBrsBillTmp',
            // 	Key         : 'FTBchCode'
            // },
            GrideView: {
                ColumnPathLang: 'document/returnsale/returnsale',
                ColumnKeyLang: ['tRSRefDocNoColum', 'tRSRefDocDateColum'],
                ColumnsSize: ['50%', '50%'],
                WidthModal: 50,
                DataColumns: ['TVDTSalHD.FTXshDocNo', 'TVDTSalHD.FDXshDocDate'],
                DataColumnsFormat: ['', '', ''],
                Perpage: 10,
                OrderBy: ['TVDTSalHD.FTXshDocNo ASC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TVDTSalHD.FTXshDocNo"],
                Text: [tInputReturnName, "TVDTSalHD.FTXshDocNo"]
            },
            NextFunc: {
                FuncName: tNextFuncName,
                ArgReturn: aArgReturn
            }
            // RouteAddNew: 'branch',
            // BrowseLev: 1
        };
        return oOptionReturn;
    };


    function JSxRSFindBillSaleVDDetail(tRSRefDocNo) {

        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "dcmRSFindBillSaleVDDetail",
            data: {
                'tRSRefDocNo': tRSRefDocNo
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                $('#othDataTableSalVD').html(oResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    }

    function JSnRSTexAddData() {
        JCNxOpenLoading();
        var aRSSelectPdt = $(".xRSSelectPdtLabel input:checkbox:checked").map(function() {
            return $(this).val();
        }).get();

        console.log(aRSSelectPdt);
        let tRSBchCode = $('.xSelectSaleBillHD.active').data('ftbchcode');
        let tRSRefDocNo = $('.xSelectSaleBillHD.active').data('docno');
        if (jQuery.isEmptyObject(aRSSelectPdt) == false) {
            $.ajax({
                type: "POST",
                url: "dcmRSInsertBillToTemp",
                data: {
                    'tRSDocNo': $('#oetRSDocNo').val(),
                    'tRSRefDocNo': tRSRefDocNo,
                    'tRSBchCode': tRSBchCode,
                    'aRSSelectPdt': aRSSelectPdt
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aResult = JSON.parse(oResult);
                    if (aResult['rtCode'] == '1') {
                        JSvRSLoadPdtDataTableHtml();
                        JSvRSLoadDocHD();
                        $('#odvRSBrowseBillSaleVD').modal('hide');
                    } else {
                        $('#odvRSModalBillNotFound').modal('show');
                    }
                    // JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            alert('ไม่พบรายการสินค้าคืน');
        }
    }


    function JSvRSLoadDocHD() {

        var aParameterBillHD = JSON.parse($('#ohdParameterBillHD').val());

        console.log(aParameterBillHD);
        $('#oetRSFrmBchCode').val(aParameterBillHD['FTBchCode']);
        $('#oetRSFrmBchName').val(aParameterBillHD['FTBchName']);
        $('#oetRSFrmShpCode').val(aParameterBillHD['FTShpCode']);
        $('#oetRSFrmShpName').val(aParameterBillHD['FTShpName']);
        $('#oetRSFrmPosCode').val(aParameterBillHD['FTPosCode']);
        $('#oetRSFrmPosName').val(aParameterBillHD['FTPosName']);
        $('#oetRSFrmCstCode').val(aParameterBillHD['FTCstCode']);
        $('#oetRSFrmCstName').val(aParameterBillHD['FTCstName']);
        $('#oetRSRefDocDate').val(aParameterBillHD['FDXshDocDate']);
        $('#oetRSRefDocNo').val(aParameterBillHD['FTXshDocNo']);

        $('#ohdRSCmpRteCode').val(aParameterBillHD['FTRteCode']);
        $('#ohdRSRteFac').val(aParameterBillHD['FCXrcRteFac']);
        $('#oetRSRcvCode').val(aParameterBillHD['FTRcvCode']);
        $('#oetRSRcvName').val(aParameterBillHD['FTRcvName']);

        JSxRSFindWahouseDefaultByShop(aParameterBillHD['FTBchCode'], aParameterBillHD['FTShpCode']);

    }
</script>