<script type="text/javascript">
    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit"); ?>';
    var tUsrApv = '<?php echo $this->session->userdata("tSesUsername"); ?>';
    var tUsrBchCode = '<?php echo $this->session->userdata("tSesUsrBchCode"); ?>';
    var tTWIDocType = '<?= $tTWIDocType; ?>';
    var tTWIRsnType = '<?= $tTWIRsnType; ?>';
    var tTWIStaDoc = '<?= $tTWIStaDoc; ?>';
    var tTWIStaApvDoc = '<?= $tTWIStaApv; ?>';
    var tTWIStaPrcStkDoc = '<?= $tTWIStaPrcStk; ?>';
    var tTWIRoute = '<?= $tTWIRoute; ?>';
    $(document).ready(function() {

        $('#odvTRNOut').css('display', 'none');
        $('#odvTRNIn').css('display', 'block');

        $('#obtTWIConfirmApprDoc').click(function() {
            JSxTRNTransferReceiptStaApvDoc(true);
        });

        if (tTWIStaDoc == 3 || tTWIStaApvDoc == 1) {
            $('#odvTWIMngAdvTableList').hide();
            $('#odvTWIMngDelPdtInTableDT').hide();
            $('#obtTWIDocBrowsePdt').hide();
        }

        //เอกสารถูกยกเลิก
        if (tTWIStaDoc == 3) {
            $('#obtTrnOutPrintDoc').show();
            $('#obtTWICancelDoc').hide();
            $('#obtTWIApproveDoc').hide();
            $('#odvTWIBtnGrpSave').show();

            //วันที่ + เวลา
            $('#oetTWIDocDate').attr('disabled', true);
            $('#oetTWIDocTime').attr('disabled', true);
            $('.xCNControllDateTime').attr('disabled', true);
            $('.xWDropdown').attr('disabled',true);
            $('#otaTWIFrmInfoOthRmk').removeAttr('disabled', true);

            //ประเภท
            $('#ocmSelectTransferDocument').attr('disabled', true);
            $('#ocmSelectTransTypeIN').attr('disabled', true);
            $('#oetTWIINEtc').attr('disabled', true);
            $('.xCNApvOrCanCelDisabled').attr('disabled', true);
            $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");

        } else if (tTWIStaApvDoc == 1) {
            $('#obtTrnOutPrintDoc').show();
            if (tTWIStaPrcStkDoc == '') {
                $('#obtTWICancelDoc').show();
            }else{
                $('#obtTWICancelDoc').hide();
            }
            $('#obtTWIApproveDoc').hide();
            $('#odvTWIBtnGrpSave').show();
            $('#otaTWIFrmInfoOthRmk').removeAttr('disabled', true);

            //วันที่ + เวลา
            $('#oetTWIDocDate').attr('disabled', true);
            $('#oetTWIDocTime').attr('disabled', true);
            $('.xCNControllDateTime').attr('disabled', true);
            $('.xWDropdown').attr('disabled',true);

            //ประเภท
            $('#ocmSelectTransferDocument').attr('disabled', true);
            $('#ocmSelectTransTypeIN').attr('disabled', true);
            $('#oetTWIINEtc').attr('disabled', true);
            $('.xCNApvOrCanCelDisabled').attr('disabled', true);
            //$(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        }
         else {

            if (tTWIStaDoc == 1 && tTWIRoute == 'dcmTXOOutEventEdit') {
                $('#obtTrnOutPrintDoc').show();
                $('#obtTWICancelDoc').show();
                $('#obtTWIApproveDoc').show();
                $('#odvTWIBtnGrpSave').show();
            } else {
                $('#odvTWIBtnGrpSave').show();
                $('#obtTrnOutPrintDoc').hide();
                $('#obtTWICancelDoc').hide();
                $('#obtTWIApproveDoc').hide();
            }
        }

        $('.selectpicker').selectpicker('refresh');

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            startDate: '1900-01-01',
            disableTouchKeyboard: true,
            autoclose: true
        });

        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm:ss'
        });

        $('.xWTooltipsBT').tooltip({
            'placement': 'bottom'
        });

        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });

        $(".xWConDisDocument .disabled").attr("disabled", "disabled");

        // ================================ Event Date Function  ===============================
        $('#obtTWIDocDate').unbind().click(function() {
            $('#oetTWIDocDate').datepicker('show');
        });

        $('#obtTWIDocTime').unbind().click(function() {
            $('#oetTWIDocTime').datetimepicker('show');
        });

        $('#obtTWIBrowseRefIntDocDate').unbind().click(function() {
            $('#oetTWIRefIntDocDate').datepicker('show');
        });

        $('#obtTWIBrowseRefExtDocDate').unbind().click(function() {
            $('#oetTWIRefExtDocDate').datepicker('show');
        });

        $('#obtTWITnfDate').unbind().click(function() {
            $('#oetTWITransportTnfDate').datepicker('show');
        });

        // ================================== Set Date Default =================================
        var dCurrentDate = new Date();
        var tAmOrPm = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
        var tCurrentTime = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

        if ($('#oetTWIDocDate').val() == '') {
            $('#oetTWIDocDate').datepicker("setDate", dCurrentDate);
        }

        if ($('#oetTWIDocTime').val() == '') {
            $('#oetTWIDocTime').val(tCurrentTime);
        }

        // =============================== Check Box Auto GenCode ==============================
        $('#ocbTWIStaAutoGenCode').on('change', function(e) {
            if ($('#ocbTWIStaAutoGenCode').is(':checked')) {
                $("#oetTWIDocNo").val('');
                $("#oetTWIDocNo").attr("readonly", true);
                $('#oetTWIDocNo').closest(".form-group").css("cursor", "not-allowed");
                $('#oetTWIDocNo').css("pointer-events", "none");
                $("#oetTWIDocNo").attr("onfocus", "this.blur()");
                $('#ofmTWIFormAdd').removeClass('has-error');
                $('#ofmTWIFormAdd .form-group').closest('.form-group').removeClass("has-error");
                $('#ofmTWIFormAdd em').remove();
            } else {
                $('#oetTWIDocNo').closest(".form-group").css("cursor", "");
                $('#oetTWIDocNo').css("pointer-events", "");
                $('#oetTWIDocNo').attr('readonly', false);
                $("#oetTWIDocNo").removeAttr("onfocus");
            }
        });

        // ============================== เลือกประเภทเอกสาร =====================================
        //แบบ EDIT
        if (tTWIDocType != '') {
            if (tTWIDocType == 5) { //IN
                $("#ocmSelectTransferDocument option[value=IN]").attr('selected', 'selected');
                $('#odvTRNOut').css('display', 'block');
                $('#odvTRNIn').css('display', 'none');
            } else { //OUT
                $("#ocmSelectTransferDocument option[value=OUT]").attr('selected', 'selected');
                $('#odvTRNOut').css('display', 'none');
                $('#odvTRNIn').css('display', 'block');

                if (tTWIRsnType == 3) { //ผู้จำหน่าย
                    $("#ocmSelectTransTypeIN option[value=SPL]").attr('selected', 'selected');
                    $('#odvINWhereSPL').css('display', 'block');
                    $('#odvINWhereCUS').css('display', 'none');
                    $('#odvINWhereETC').css('display', 'none');
                } else if (tTWIRsnType == 4)  { // แหล่งอื่น
                    $("#ocmSelectTransTypeIN option[value=ETC]").attr('selected', 'selected');
                    $('#odvINWhereSPL').css('display', 'none');
                    $('#odvINWhereCUS').css('display', 'none');
                    $('#odvINWhereETC').css('display', 'block');
                } else{
                    $("#ocmSelectTransTypeIN option[value=CUS]").attr('selected', 'selected');
                    $('#odvINWhereSPL').css('display', 'none');
                    $('#odvINWhereCUS').css('display', 'block');
                    $('#odvINWhereETC').css('display', 'none');
                }
            }
            $('.selectpicker').selectpicker('refresh');
        }

        //แบบ INS
        $('#ocmSelectTransferDocument').change(function() {
            var nValue = $(this).val();
            if (nValue == 'OUT') {
                $('#odvTRNOut').css('display', 'none');
                $('#odvTRNIn').css('display', 'block');
            } else if (nValue == 'IN') {
                $('#odvTRNOut').css('display', 'block');
                $('#odvTRNIn').css('display', 'none');
            }

            //เคลียร์ค่า กลับมาแบบตั้งต้น
            if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'SHP') {
                $('#obtBrowseTROutFromPos').attr('disabled', false);
                $('#obtBrowseTROutToPos').attr('disabled', false);
            } else {
                $('#obtBrowseTROutFromPos').attr('disabled', true);
                $('#obtBrowseTROutToPos').attr('disabled', true);
                $('.xCNClearValue').val('');
            }
        });

        // ===================================== เลือกสินค้า =====================================
        $('#obtTWIDocBrowsePdt').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose();
                JCNvTWIBrowsePdt();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // ===================================== แสดงคอลัมน์ =====================================
        $('#obtTWIAdvTablePdtDTTemp').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxTWIOpenColumnFormSet();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // ===================================== เลือกคอลัมน์ที่จะแสดง =====================================
        $('#odvTWIOrderAdvTblColumns #obtTWISaveAdvTableColums').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxTWISaveColumnShow();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        JSxTWICallPageHDDocRef();
    });

    // ===================================== เลือกประเภทต่างๆ =====================================

    ///////[เอกสารรับโอน]

    //เลือกร้านค้าต้นทาง
    var oBrowseTROutFromShp = {
        Title: ['company/shop/shop', 'tSHPTitle'],
        Table: {
            Master: 'TCNMShop',
            PK: 'FTShpCode'
        },
        Join: {
            Table: ['TCNMShop_L', 'TCNMBranch_L'],
            On: [
                'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = ' + nLangEdits
            ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tSHPTBBranch', 'tSHPTBCode', 'tSHPTBName'],
            ColumnsSize: ['15%', '15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMBranch_L.FTBchCode'],
            DataColumnsFormat: ['', '', '', ''],
            DisabledColumns: [3],
            Perpage: 10,
            OrderBy: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ['oetTROutShpFromCode', "TCNMShop.FTShpCode"],
            Text: ['oetTROutShpFromName', "TCNMShop_L.FTShpName"]
        },
        NextFunc: {
            FuncName: 'JSxSelectTROutFromShp',
            ArgReturn: ['FTShpCode', 'FTBchCode'],
        }
    }
    $('#obtBrowseTROutFromShp').click(function() {
        //กรณีเข้ามาแบบสาขา ต้องโชว์ร้านค้าเฉพาะของสาขา
        if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'BCH') {
            $tBCH = '<?= $this->session->userdata("tSesUsrBchCom") ?>';
            oBrowseTROutFromShp.Where.Condition = [" AND TCNMShop.FTBchCode = '" + $tBCH + "' "];
        } else {
            $tBCH = $('#oetSOFrmBchCode').val();
            oBrowseTROutFromShp.Where.Condition = [" AND TCNMShop.FTBchCode = '" + $tBCH + "' "];
        }
        JCNxBrowseData('oBrowseTROutFromShp');
    });

    function JSxSelectTROutFromShp(ptCode) {
        if (ptCode == 'NULL' || ptCode == null) {
            $('#obtBrowseTROutFromPos').attr('disabled', true);
        } else {
            var tResult = JSON.parse(ptCode);
            $('#obtBrowseTROutFromPos').attr('disabled', false);
            $('#obtBrowseTROutFromWah').attr('disabled', false);

            oBrowseTROutFromPos.Where.Condition = ["AND TVDMPosShop.FTShpCode = '" + tResult[0] + "' AND TVDMPosShop.FTBchCode = '" + tResult[1] + "' "]
            oBrowseTROutFromWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tResult[0] + "' "]
        }

        //ล้างค่าเครื่องจุดขาย
        $('#oetTROutPosFromName').val('');
        $('#oetTROutPosFromCode').val('');

        //ล้างค่าคลังสินค้า
        $('#oetTROutWahFromName').val('');
        $('#oetTROutWahFromCode').val('');
    }

    //เลือกเครื่องจุดขายต้นทาง
    $('#obtBrowseTROutFromPos').attr('disabled', true);
    var oBrowseTROutFromPos = {
        Title: ['pos/posshop/posshop', 'tPshBRWPOSTitle'],
        Table: {
            Master: 'TVDMPosShop',
            PK: 'FTPosCode'
        },
        Join: {
            Table: ['TCNMWaHouse', 'TCNMWaHouse_L'],
            On: [
                'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TVDMPosShop.FTBchCode = TCNMWaHouse.FTBchCode AND FTWahStaType = 6',
                'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
            ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'pos/posshop/posshop',
            ColumnKeyLang: ['tPshTBPosCode', 'tPshTBPosCode', 'tPshTBPosCode'],
            ColumnsSize: ['10%', '10%', '10%'],
            WidthModal: 50,
            DataColumns: ['TVDMPosShop.FTPosCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', '', ''],
            DisabledColumns: [1, 2],
            Perpage: 10,
            OrderBy: ['TVDMPosShop.FTPosCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTROutPosFromCode", "TVDMPosShop.FTPosCode"],
            Text: ["oetTROutPosFromName", "TVDMPosShop.FTPosCode"],
        },
        NextFunc: {
            FuncName: 'JSxSelectTROutFromPos',
            ArgReturn: ['FTPosCode', 'FTWahCode', 'FTWahName'],
        }
    }
    $('#obtBrowseTROutFromPos').click(function() {
        //กรณีเข้ามาแบบร้านค้า ต้องโชว์เครื่องจุดขายเฉพาะของร้านค้า
        if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'SHP') {
            $tBCH = '<?= $this->session->userdata("tSesUsrBchCom") ?>';
            $tSHP = '<?= $this->session->userdata("tSesUsrShpCode") ?>';
            oBrowseTROutFromPos.Where.Condition = [" AND TVDMPosShop.FTBchCode = '" + $tBCH + "'  AND TVDMPosShop.FTShpCode = '" + $tSHP + "' "];
        }
        JCNxBrowseData('oBrowseTROutFromPos');
    });

    function JSxSelectTROutFromPos(ptCode) {
        if (ptCode == 'NULL' || ptCode == null) {
            $('#obtBrowseTROutFromWah').attr('disabled', false);
            //ล้างค่า
            $('#oetTROutWahFromName').val('');
            $('#oetTROutWahFromCode').val('');
        } else {
            var tResult = JSON.parse(ptCode);
            $('#oetTROutWahFromName').val('');
            $('#oetTROutWahFromCode').val('');

            if (tResult[1] != '' || tResult[2] != '') {
                $('#oetTROutWahFromName').val(tResult[2]);
                $('#oetTROutWahFromCode').val(tResult[1]);
                $('#obtBrowseTROutFromWah').attr('disabled', true);
            }
        }
    }

    //เลือกคลังสินค้าต้นทาง
    var oBrowseTROutFromWah_SHP = {
        Title: ['company/shop/shop', 'tSHPWah'],
        Table: {
            Master: 'TCNMShpWah',
            PK: 'FTWahCode'
        },
        Join: {
            Table: ['TCNMWaHouse_L'],
            On: ['TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMShpWah.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tWahCode', 'tWahName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMShpWah.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMWaHouse_L.FTWahName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTROutWahFromCode", "TCNMShpWah.FTWahCode"],
            Text: ["oetTROutWahFromName", "TCNMWaHouse_L.FTWahName"],
        }
    }

    var oBrowseTROutFromWah_BCH = {
        Title: ['company/shop/shop', 'tSHPWah'],
        Table: {
            Master: 'TCNMWaHouse',
            PK: 'FTWahCode'
        },
        Join: {
            Table: ['TCNMWaHouse_L'],
            On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tWahCode', 'tWahName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMWaHouse_L.FTWahName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTROutWahFromCode", "TCNMWaHouse.FTWahCode"],
            Text: ["oetTROutWahFromName", "TCNMWaHouse_L.FTWahName"],
        }
    }
    $('#obtBrowseTROutFromWah').click(function() {
        if ($('#oetTROutShpFromCode').val() != '') {
            //เลือกคลังที่ร้านค้า
            var tBCH = $('#oetSOFrmBchCode').val();
            var tSHP = $('#oetTROutShpFromCode').val();
            oBrowseTROutFromWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '" + tBCH + "' "];
            JCNxBrowseData('oBrowseTROutFromWah_SHP');
        } else if ($('#oetSOFrmBchCode').val() != '') {
            //เลือกคลังที่สาขา
            var tBCH = $('#oetSOFrmBchCode').val();
            oBrowseTROutFromWah_BCH.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "'"];
            JCNxBrowseData('oBrowseTROutFromWah_BCH');
        }
    });

    //นำเข้าข้อมูล
    $('#obtImportPDTInCN').click(function() {
        var tBCHCode = $('#oetSOFrmBchCode').val();
        var tSHPCode = $('#oetTROutShpFromCode').val();
        var tWAHCode = $('#oetTROutWahFromCode').val();

        $.ajax({
            type: "POST",
            url: "TXOOutTransferReceiptSelectPDTInCN",
            cache: false,
            data: {
                tBCHCode: tBCHCode,
                tSHPCode: tSHPCode,
                tWAHCode: tWAHCode
            },
            Timeout: 0,
            success: function(oResult) {
                var aDataReturn = JSON.parse(oResult);
                if (aDataReturn['nStaEvent'] == '1') {
                    var tViewTableShow = aDataReturn['tViewPageAdd'];
                    $('#odvTWIModalPDTCN .modal-body').html(tViewTableShow);
                    $('#odvTWIModalPDTCN').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    $("#odvTWIModalPDTCN").modal({
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

    });

    //----------------------------------------------------------------------------------------//

    //เลือกร้านค้าปลายทาง
    var oBrowseTROutToShp = {
        Title: ['company/shop/shop', 'tSHPTitle'],
        Table: {
            Master: 'TCNMShop',
            PK: 'FTShpCode'
        },
        Join: {
            Table: ['TCNMShop_L', 'TCNMBranch_L'],
            On: [
                'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = ' + nLangEdits
            ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tSHPTBBranch', 'tSHPTBCode', 'tSHPTBName'],
            ColumnsSize: ['15%', '15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
            DataColumnsFormat: ['', '', ''],
            Perpage: 10,
            OrderBy: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ['oetTROutShpToCode', "TCNMShop.FTShpCode"],
            Text: ['oetTROutShpToName', "TCNMShop_L.FTShpName"]
        },
        NextFunc: {
            FuncName: 'JSxSelectTRToFromShp',
            ArgReturn: ['FTShpCode'],
        }
    }
    $('#obtBrowseTROutToShp').click(function() {
        //กรณีเข้ามาแบบสาขา ต้องโชว์ร้านค้าเฉพาะของสาขา
        if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'BCH') {
            $tBCH = '<?= $this->session->userdata("tSesUsrBchCom") ?>';
            oBrowseTROutToShp.Where.Condition = [" AND TCNMShop.FTBchCode = '" + $tBCH + "' "];
        } else {
            $tBCH = $('#oetSOFrmBchCode').val();
            oBrowseTROutToShp.Where.Condition = [" AND TCNMShop.FTBchCode = '" + $tBCH + "' "];
        }
        JCNxBrowseData('oBrowseTROutToShp');
    });

    function JSxSelectTRToFromShp(ptCode) {
        if (ptCode == 'NULL' || ptCode == null) {
            $('#obtBrowseTROutToPos').attr('disabled', true);
        } else {
            var tResult = JSON.parse(ptCode);
            $('#obtBrowseTROutToPos').attr('disabled', false);
            $('#obtBrowseTROutToWah').attr('disabled', false);

            oBrowseTROutToPos.Where.Condition = ["AND FTShpCode = '" + tResult[0] + "' "]
            oBrowseTROutToWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tResult[0] + "' "]
        }

        //ล้างค่าเครื่องจุดขาย
        $('#oetTROutPosToName').val('');
        $('#oetTROutPosToCode').val('');

        //ล้างค่าคลังสินค้า
        $('#oetTROutWahToName').val('');
        $('#oetTROutWahToCode').val('');
    }

    //เลือกเครื่องจุดขายปลายทาง
    var oBrowseTROutToPos = {
        Title: ['pos/posshop/posshop', 'tPshBRWPOSTitle'],
        Table: {
            Master: 'TVDMPosShop',
            PK: 'FTPosCode'
        },
        Join: {
            Table: ['TCNMWaHouse', 'TCNMWaHouse_L'],
            On: [
                'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TVDMPosShop.FTBchCode = TCNMWaHouse.FTBchCode AND FTWahStaType = 6',
                'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
            ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'pos/posshop/posshop',
            ColumnKeyLang: ['tPshTBPosCode', 'tPshTBPosCode', 'tPshTBPosCode'],
            ColumnsSize: ['10%', '10%', '10%'],
            WidthModal: 50,
            DataColumns: ['TVDMPosShop.FTPosCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', '', ''],
            DisabledColumns: [1, 2],
            Perpage: 10,
            OrderBy: ['TVDMPosShop.FTPosCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTROutPosToCode", "TVDMPosShop.FTPosCode"],
            Text: ["oetTROutPosToName", "TVDMPosShop.FTPosCode"],
        },
        NextFunc: {
            FuncName: 'JSxSelectTROutToPos',
            ArgReturn: ['FTPosCode', 'FTWahCode', 'FTWahName']
        }
    }
    $('#obtBrowseTROutToPos').attr('disabled', true);
    $('#obtBrowseTROutToPos').click(function() {
        //กรณีเข้ามาแบบร้านค้า ต้องโชว์เครื่องจุดขายเฉพาะของร้านค้า
        if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'SHP') {
            $tBCH = '<?= $this->session->userdata("tSesUsrBchCom") ?>';
            $tSHP = '<?= $this->session->userdata("tSesUsrShpCode") ?>';
            oBrowseTROutToPos.Where.Condition = [" AND TVDMPosShop.FTBchCode = '" + $tBCH + "'  AND TVDMPosShop.FTShpCode = '" + $tSHP + "' "];
        }
        JCNxBrowseData('oBrowseTROutToPos');
    });

    function JSxSelectTROutToPos(ptCode) {
        if (ptCode == 'NULL' || ptCode == null) {
            $('#obtBrowseTROutToWah').attr('disabled', false);
            //ล้างค่า
            $('#oetTROutWahToName').val('');
            $('#oetTROutWahToCode').val('');
        } else {
            var tResult = JSON.parse(ptCode);
            $('#oetTROutWahToName').val('');
            $('#oetTROutWahToCode').val('');

            if (tResult[1] != '' || tResult[2] != '') {
                $('#oetTROutWahToName').val(tResult[2]);
                $('#oetTROutWahToCode').val(tResult[1]);
                $('#obtBrowseTROutToWah').attr('disabled', true);
            }
        }
    }

    //เลือกคลังสินค้าปลายทาง
    var oBrowseTROutToWah_SHP = {
        Title: ['company/shop/shop', 'tSHPWah'],
        Table: {
            Master: 'TCNMShpWah',
            PK: 'FTWahCode'
        },
        Join: {
            Table: ['TCNMWaHouse_L'],
            On: ['TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMShpWah.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tWahCode', 'tWahName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMShpWah.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMWaHouse_L.FTWahName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTROutWahToCode", "TCNMShpWah.FTWahCode"],
            Text: ["oetTROutWahToName", "TCNMWaHouse_L.FTWahName"],
        }
    }

    var oBrowseTROutToWah_BCH = {
        Title: ['company/shop/shop', 'tSHPWah'],
        Table: {
            Master: 'TCNMWaHouse',
            PK: 'FTWahCode'
        },
        Join: {
            Table: ['TCNMWaHouse_L'],
            On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tWahCode', 'tWahName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMWaHouse_L.FTWahName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTROutWahToCode", "TCNMWaHouse.FTWahCode"],
            Text: ["oetTROutWahToName", "TCNMWaHouse_L.FTWahName"],
        }
    }

    $('#obtBrowseTROutToWah').click(function() {
        if ($('#oetTROutShpToCode').val() != '') {
            //เลือกคลังที่ร้านค้า
            var tBCH = $('#oetSOFrmBchCode').val();
            var tSHP = $('#oetTROutShpToCode').val();
            oBrowseTROutToWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '" + tBCH + "' "];
            JCNxBrowseData('oBrowseTROutToWah_SHP');
        } else if ($('#oetSOFrmBchCode').val() != '') {
            //เลือกคลังที่สาขา
            var tBCH = $('#oetSOFrmBchCode').val();
            oBrowseTROutToWah_BCH.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "' AND TCNMWaHouse.FTWahStaType IN('2','1') "];
            JCNxBrowseData('oBrowseTROutToWah_BCH');
        }
    });

    ///////[เอกสารรับเข้า]

    //เลือกประเภทผู้จำหน่าย - จากแบบ => ประเภทผู้จำหน่าย
    var oBrowseTRINFromSpl = {
        Title: ['supplier/supplier/supplier', 'tSPLTitle'],
        Table: {
            Master: 'TCNMSpl',
            PK: 'FTSplCode'
        },
        Where :{
            Condition : ["AND TCNMSpl.FTAgnCode = '<?php echo $tAgnCode; ?>' "],
        },
        Join: {
            Table: ['TCNMSpl_L'],
            On: ['TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = ' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'supplier/supplier/supplier',
            ColumnKeyLang: ['tSPLTBCode', 'tSPLTBName'],
            ColumnsSize: ['10%', '75%'],
            DataColumns: ['TCNMSpl.FTSplCode', 'TCNMSpl_L.FTSplName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TCNMSpl.FDCreateOn DESC'],
            // SourceOrder         : "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTRINSplCode", "TCNMSpl.FTSplCode"],
            Text: ["oetTRINSplName", "TCNMSpl_L.FTSplName"],
        },
    }
    $('#obtBrowseTRINFromSpl').click(function() {
        JCNxBrowseData('oBrowseTRINFromSpl');
    });

    //เลือกร้านค้า - จากแบบ => ประเภทผู้จำหน่าย
    var oBrowseTRINFromShp = {
        Title: ['company/shop/shop', 'tSHPTitle'],
        Table: {
            Master: 'TCNMShop',
            PK: 'FTShpCode'
        },
        Join: {
            Table: ['TCNMShop_L', 'TCNMBranch_L'],
            On: [
                'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = ' + nLangEdits
            ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tSHPTBBranch', 'tSHPTBCode', 'tSHPTBName'],
            ColumnsSize: ['15%', '15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
            DataColumnsFormat: ['', '', ''],
            Perpage: 10,
            OrderBy: ['TCNMShop.FDCreateOn DESC, TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ['oetTRINShpCodeTo', "TCNMShop.FTShpCode"],
            Text: ['oetTRINShpNameTo', "TCNMShop_L.FTShpName"]
        },
        NextFunc: {
            FuncName: 'JSxSelectTRINFromPos',
            ArgReturn: ['FTShpCode']
        }
    }

     // เบาวน์  Customer
     $('#obtBrowseTRINFromCus').click(function(){JCNxBrowseData('oBrowseTRINFromCus')});
    var oBrowseTRINFromCus = {
        Title   : ['document/transferreceiptOut/transferreceiptOut','tINCUS'],
        Table   : {Master:'TCNMCst',PK:'FTCstCode'},
        Join    : {
                Table:	['TCNMCst_L'],
                On:[' TCNMCst.FTCstCode = TCNMCst_L.FTCstCode AND TCNMCst_L.FNLngID = '+nLangEdits,] //+ tJoinBranch + tJoinShop
                },
        GrideView:{
            ColumnPathLang	: 'document/transferreceiptOut/transferreceiptOut',
            ColumnKeyLang	: ['tINCUSId','tINCUSName'],
            ColumnsSize     : ['10%','80%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMCst.FTCstCode','TCNMCst_L.FTCstName'],
            DataColumnsFormat : ['',''],
            Perpage			: 10,
            OrderBy			: ['TCNMCst.FTCstCode DESC'],
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetTRINCusCode","TCNMCst.FTCstCode"],
            Text		: ["oetTRINCusName","TCNMCst_L.FTCstName"],
        }
    }



    $('#obtBrowseTRINFromShp').click(function() {
        //กรณีเข้ามาแบบสาขา ต้องโชว์ร้านค้าเฉพาะของสาขา
        if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'BCH') {
            $tBCH = $('#oetSOFrmBchCode').val();
            oBrowseTRINFromShp.Where.Condition = [" AND TCNMShop.FTBchCode = '" + $tBCH + "' "];
        } else {
            $tBCH = $('#oetSOFrmBchCode').val();
            oBrowseTRINFromShp.Where.Condition = [" AND TCNMShop.FTBchCode = '" + $tBCH + "' "];
        }
        JCNxBrowseData('oBrowseTRINFromShp');
    });

    function JSxSelectTRINFromPos(ptCode) {
        if (ptCode == 'NULL' || ptCode == null) {
            $('#oetTRINWahNameTo').val('');
            $('#oetTRINWahCodeTo').val('');
        } else {
            var tResult = JSON.parse(ptCode);
            if (tResult[1] != '') {
                oBrowseTRINToWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tResult[0] + "' "]
            }
        }
    }

    //เลือกคลังสินค้า - จากแบบ => ประเภทผู้จำหน่าย
    var oBrowseTRINToWah_SHP = {
        Title: ['company/shop/shop', 'tSHPWah'],
        Table: {
            Master: 'TCNMShpWah',
            PK: 'FTWahCode'
        },
        Join: {
            Table: ['TCNMWaHouse_L'],
            On: ['TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMShpWah.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tWahCode', 'tWahName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMShpWah.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMShpWah.FDCreateOn DESC'],
            // SourceOrder		: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTRINWahCodeTo", "TCNMShpWah.FTWahCode"],
            Text: ["oetTRINWahNameTo", "TCNMWaHouse_L.FTWahName"],
        }
    }

    var oBrowseTRINToWah_BCH = {
        Title: ['company/shop/shop', 'tSHPWah'],
        Table: {
            Master: 'TCNMWaHouse',
            PK: 'FTWahCode'
        },
        Join: {
            Table: ['TCNMWaHouse_L'],
            On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tWahCode', 'tWahName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMWaHouse.FDCreateOn DESC'],
            // SourceOrder		: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTRINWahCodeTo", "TCNMWaHouse.FTWahCode"],
            Text: ["oetTRINWahNameTo", "TCNMWaHouse_L.FTWahName"],
        }
    }

    $('#obtBrowseTRINFromWah').click(function() {
        if ($('#oetTRINShpCodeTo').val() != '') {
            // เลือกคลังที่ร้านค้า
            var tBCH = $('#oetSOFrmBchCode').val();
            var tSHP = $('#oetTRINShpCodeTo').val();
            oBrowseTRINToWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '" + tBCH + "' "];
            JCNxBrowseData('oBrowseTRINToWah_SHP');
        } else
        if ($('#oetSOFrmBchCode').val() != '') {
            //เลือกคลังที่สาขา
            var tBCH = $('#oetSOFrmBchCode').val();

            //User สาขาจะมองไม่เห็นคลังของเสีย
            if('<?=$this->session->userdata("tSesUsrLevel")?>' != "HQ" ){
                var tFindWahouse = " AND TCNMWaHouse.FTWahStaType IN('2','1') ";
            }else{
                var tFindWahouse = " AND TCNMWaHouse.FTWahStaType IN('2','1','10') ";
            }

            oBrowseTRINToWah_BCH.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "' " + tFindWahouse + " "];
            JCNxBrowseData('oBrowseTRINToWah_BCH');
        }
    });

    //เลือกคลังสินค้า - จากแบบ =>  แหล่งอื่น
    var oBrowseTRINEtcWah_SHP = {
        Title: ['company/shop/shop', 'tSHPWah'],
        Table: {
            Master: 'TCNMShpWah',
            PK: 'FTWahCode'
        },
        Join: {
            Table: ['TCNMWaHouse_L'],
            On: ['TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tWahCode', 'tWahName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMShpWah.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMWaHouse_L.FTWahCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTRINWahEtcCode", "TCNMShpWah.FTWahCode"],
            Text: ["oetTRINWahEtcName", "TCNMWaHouse_L.FTWahName"],
        }
    }

    var oBrowseTRINEtcWah = {
        Title: ['company/shop/shop', 'tSHPWah'],
        Table: {
            Master: 'TCNMWaHouse',
            PK: 'FTWahCode'
        },
        Join: {
            Table: ['TCNMWaHouse_L'],
            On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tWahCode', 'tWahName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMWaHouse_L.FTWahCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTRINWahEtcCode", "TCNMWaHouse.FTWahCode"],
            Text: ["oetTRINWahEtcName", "TCNMWaHouse_L.FTWahName"],
        }
    }

    var oBrowseTRINEtcWah2 = {
        Title: ['company/shop/shop', 'tSHPWah'],
        Table: {
            Master: 'TCNMWaHouse',
            PK: 'FTWahCode'
        },
        Join: {
            Table: ['TCNMWaHouse_L'],
            On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            ColumnPathLang: 'company/shop/shop',
            ColumnKeyLang: ['tWahCode', 'tWahName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMWaHouse_L.FTWahCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTRINWahEtcCodeETC", "TCNMWaHouse.FTWahCode"],
            Text: ["oetTRINWahEtcNameETC", "TCNMWaHouse_L.FTWahName"],
        }
    }

    $('#obtBrowseTRINEtcWah').click(function() {

        if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'SHP') {
            var tBCH = '<?= $this->session->userdata("tSesUsrBchCom") ?>';
            var tSHP = '<?= $this->session->userdata("tSesUsrShpCode") ?>';
            oBrowseTRINToWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '" + tBCH + "' "];
            JCNxBrowseData('oBrowseTRINToWah_SHP');
        } else {
            var tBCH = $('#oetSOFrmBchCode').val();
            oBrowseTRINEtcWah.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "' AND TCNMWaHouse.FTWahStaType IN('2','1') "];
            JCNxBrowseData('oBrowseTRINEtcWah');
        }
    });

    $('#obtBrowseTRINEtcWah2').click(function() {

        if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'SHP') {
            var tBCH = '<?= $this->session->userdata("tSesUsrBchCom") ?>';
            var tSHP = '<?= $this->session->userdata("tSesUsrShpCode") ?>';
            oBrowseTRINToWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '" + tBCH + "' "];
            JCNxBrowseData('oBrowseTRINToWah_SHP');
        } else {
            var tBCH = $('#oetSOFrmBchCode').val();
            oBrowseTRINEtcWah2.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "' AND TCNMWaHouse.FTWahStaType IN('2','1') "];
            JCNxBrowseData('oBrowseTRINEtcWah2');
        }
    });

    //เหตุผล
    var oBrowseTWIReason = {
        Title: ['other/reason/reason', 'tRSNTitle'],
        Table: {
            Master: 'TCNMRsn',
            PK: 'FTRsnCode'
        },
        Join: {
            Table: ['TCNMRsn_L'],
            On: [
                'TCNMRsn.FTRsnCode = TCNMRsn_L.FTRsnCode AND TCNMRsn_L.FNLngID = ' + nLangEdits
            ]
        },
        GrideView: {
            ColumnPathLang: 'other/reason/reason',
            ColumnKeyLang: ['tRSNTBCode', 'tRSNTBName'],
            ColumnsSize: ['10%', '30%'],
            WidthModal: 50,
            DataColumns: ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMRsn.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ['oetTWIReasonCode', "TCNMRsn.FTRsnCode"],
            Text: ['oetTWIReasonName', "TCNMRsn_L.FTRsnName"]
        }
    }
    $('#obtBrowseTWIReason').click(function() {
        JCNxBrowseData('oBrowseTWIReason');
    });

    // ======================================================================================

    //แสดงคอลัมน์
    function JSxTWIOpenColumnFormSet() {
        $.ajax({
            type: "POST",
            url: "TXOOutTransferAdvanceTableShowColList",
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                var aDataReturn = JSON.parse(oResult);
                if (aDataReturn['nStaEvent'] == '1') {
                    var tViewTableShowCollist = aDataReturn['tViewTableShowCollist'];
                    $('#odvTWIOrderAdvTblColumns .modal-body').html(tViewTableShowCollist);
                    $('#odvTWIOrderAdvTblColumns').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    $("#odvTWIOrderAdvTblColumns").modal({
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

    //เลือกคอลัมน์ที่จะแสดง
    function JSxTWISaveColumnShow() {
        // คอลัมน์ที่เลือกให้แสดง
        var aTWIColShowSet = [];
        $("#odvTWIOrderAdvTblColumns .xWTWIInputColStaShow:checked").each(function() {
            aTWIColShowSet.push($(this).data("id"));
        });

        // คอลัมน์ทั้งหมด
        var aTWIColShowAllList = [];
        $("#odvTWIOrderAdvTblColumns .xWTWIInputColStaShow").each(function() {
            aTWIColShowAllList.push($(this).data("id"));
        });

        // ชื่อคอลัมน์ทั้งหมดในกรณีมีการแก้ไขชื่อคอลัมน์ที่แสดง
        var aTWIColumnLabelName = [];
        $("#odvTWIOrderAdvTblColumns .xWTWILabelColumnName").each(function() {
            aTWIColumnLabelName.push($(this).text());
        });

        // สถานะย้อนกลับค่าเริ่มต้น
        var nTWIStaSetDef;
        if ($("#odvTWIOrderAdvTblColumns #ocbTWISetDefAdvTable").is(":checked")) {
            nTWIStaSetDef = 1;
        } else {
            nTWIStaSetDef = 0;
        }

        $.ajax({
            type: "POST",
            url: "TWITransferAdvanceTableShowColSave",
            data: {
                'pnTWIStaSetDef': nTWIStaSetDef,
                'paTWIColShowSet': aTWIColShowSet,
                'paTWIColShowAllList': aTWIColShowAllList,
                'paTWIColumnLabelName': aTWIColumnLabelName
            },
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                $("#odvTWIOrderAdvTblColumns").modal("hide");
                $(".modal-backdrop").remove();
                JSvTRNLoadPdtDataTableHtml();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เลือกสินค้า Add Product Into Table Document DT Temp
    function JCNvTWIBrowsePdt() {
        var tWahCode_Input_Origin = $('#oetTROutWahFromCode').val();
        var tWahCode_Input_To = $('#oetTROutWahToCode').val();
        var tWahCode_Output_Spl = $('#oetTRINWahCodeTo').val();
        var tWahCode_Output_Etc = $('#oetTRINWahEtcName').val();
        var tWahCode_Output_Cus = $('#oetTRINWahEtcName').val();
        var tTypeDocument = 'OUT';
        let tBchCode = "";
        if (tUsrBchCode != '') {
            tBchCode = tUsrBchCode;
        }


        if (tTypeDocument == 0) {
            $('#odvWTIModalTypeIsEmpty').modal('show');
            $('#ospTypeIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tTypeDocumentISEmptyDetail') ?>');
            return;
        } else {
            if (tTypeDocument == 'IN') { //เอกสารรับโอน
                if (tWahCode_Input_Origin == '' || tWahCode_Input_To == '') {
                    $('#odvWTIModalWahIsEmpty').modal('show');
                    $('#ospWahIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tWahDocumentISEmptyDetail') ?>');
                    return;
                }
            } else if (tTypeDocument == 'OUT') { //เอกสารรับเข้า
                var tIN = $('#ocmSelectTransTypeIN :selected').val();
                if (tIN == 0) {
                    $('#odvWTIModalTypeIsEmpty').modal('show');
                    $('#ospTypeIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tINDocumentISEmptyDetail') ?>');
                    return;
                } else {
                    var tTypeDocumentIN = $('#ocmSelectTransTypeIN :selected').val();
                    if (tTypeDocumentIN == 'SPL') {
                        if ($('#oetTRINWahCodeTo').val() == '') {
                            $('#odvWTIModalWahIsEmpty').modal('show');
                            $('#ospWahIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tWahINDocumentISEmptyDetail') ?>');
                            return;
                        }
                    } else if (tTypeDocumentIN == 'ETC') {
                        if ($('#oetTRINWahEtcCode').val() == '') {
                            $('#odvWTIModalWahIsEmpty').modal('show');
                            $('#ospWahIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tWahINDocumentISEmptyDetail') ?>');
                            return;
                        }
                    } else if (tTypeDocumentIN == 'CUS') {
                        if ($('#oetTRINWahEtcCode').val() == '') {
                            $('#odvWTIModalWahIsEmpty').modal('show');
                            $('#ospWahIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tWahINDocumentISEmptyDetail') ?>');
                            return;
                        }
                    }
                }
            }
        }

        var aMulti = [];
        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                Qualitysearch: [
                    /*"CODEPDT",
                    "NAMEPDT",
                    "BARCODE",
                    "FromToSHP"*/
                ],
                PriceType: ["Cost", "tCN_Cost", "Company", "1"],
                SelectTier: ["Barcode"],
                ShowCountRecord: 10,
                NextFunc: "FSvTWIAddPdtIntoDocDTTemp",
                ReturnType: "M",
                SPL: [$('#oetTRINSplCode').val(), $('#oetTRINSplCode').val()],
                BCH: [$('#oetSOFrmBchCode').val(), ''],
                MCH: ['', ''],
                SHP: [$('#oetTROutShpFromCode').val(), $('#oetTROutShpFromName').val()]
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvModalDOCPDT").modal({
                    backdrop: "static",
                    keyboard: false
                });
                $("#odvModalDOCPDT").modal({
                    show: true
                });
                //remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                $("#odvModalsectionBodyPDT").html(tResult);
                $("#odvModalDOCPDT #oliBrowsePDTSupply").css('display', 'none');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เลือกสินค้าลงตาราง tmp
    function FSvTWIAddPdtIntoDocDTTemp(ptPdtData) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JCNxOpenLoading();

            var ptXthDocNoSend = "";
            if ($("#ohdTWIRoute").val() == "dcmTXOOutEventEdit") {
                ptXthDocNoSend = $("#oetTWIDocNo").val();
            }
            // console.log(ptPdtData);
            $.ajax({
                type: "POST",
                url: "TXOOutTransferReceiptAddPdtIntoDTDocTemp",
                data: {
                    'tTWIDocNo': ptXthDocNoSend,
                    'tTWIPdtData': ptPdtData,
                    'tBCH': $('#oetSOFrmBchCode').val(),
                    'tType': 'PDT'
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    JSvTRNLoadPdtDataTableHtml();
                    var aData = JSON.parse(ptPdtData);
                    // console.log(aData);
                    var oOptionForFashion = {
                        'bListItemAll'  : false,
                        'tSpcControl'  : 0
                    }
                    JSxCheckProductSerialandFashion(aData,oOptionForFashion,'insert');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }


    function FSvTWIAddPdtIntoDocDTTemp_PDTSerialorFashion(ptPdtDataFhn){
        console.log(ptPdtDataFhn);
        var aData = JSON.parse(ptPdtDataFhn);
        var ptXthDocNoSend = "";
            if ($("#ohdTWIRoute").val() == "dcmTXOOutEventEdit") {
                ptXthDocNoSend = $("#oetTWIDocNo").val();
            }

        $.ajax({
                type: "POST",
                url: "TXOOutTransferReceiptAddPdtIntoDTFhnTemp",
                data: {
                    'tTWIDocNo': ptXthDocNoSend,
                    'tTWIPdtDataFhn': ptPdtDataFhn,
                    'tBCH': $('#oetSOFrmBchCode').val(),
                    'tType': 'PDT'
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    if(aData['nStaLastSeq']=='1'){ //ถ้าเป็นสินค้าแฟชั่นตัวสุดท้ายให้โหลด Table
                    JSvTRNLoadPdtDataTableHtml(1);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

    }




    //กดโมเดลลบสินค้าใน Tmp
    function JSnTWIDelPdtInDTTempSingle(poEl) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tVal = $(poEl).parents("tr.xWPdtItem").attr("data-pdtcode");
            var tSeqno = $(poEl).parents("tr.xWPdtItem").attr("data-seqno");
            $(poEl).parents("tr.xWPdtItem").remove();
            JSnTWIRemovePdtDTTempSingle(tSeqno, tVal);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ลบสินค้าใน Tmp - ตัวเดียว
    function JSnTWIRemovePdtDTTempSingle(ptSeqNo, ptPdtCode) {
        var tTWIDocNo = $("#oetTWIDocNo").val();
        var tTWIBchCode = $('#oetSOFrmBchCode').val();
        var tTWIVatInOrEx = 1;
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "TXOOutTransferReceiptRemovePdtInDTTmp",
            data: {
                'tBchCode': tTWIBchCode,
                'tDocNo': tTWIDocNo,
                'nSeqNo': ptSeqNo,
                'tPdtCode': ptPdtCode,
                'tVatInOrEx': tTWIVatInOrEx,
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSvTRNLoadPdtDataTableHtml();
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

    //เซตข้อความลบในสินค้า
    function JSxTWITextInModalDelPdtDtTemp() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("TWI_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {} else {
            var tTWITextDocNo = "";
            var tTWITextSeqNo = "";
            var tTWITextPdtCode = "";
            var tTWITextPunCode = "";
            $.each(aArrayConvert[0], function(nKey, aValue) {
                tTWITextDocNo += aValue.tDocNo;
                tTWITextDocNo += " , ";

                tTWITextSeqNo += aValue.tSeqNo;
                tTWITextSeqNo += " , ";

                tTWITextPdtCode += aValue.tPdtCode;
                tTWITextPdtCode += " , ";

                tTWITextPunCode += aValue.tPunCode;
                tTWITextPunCode += " , ";
            });
            $('#odvTWIModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvTWIModalDelPdtInDTTempMultiple #ohdConfirmTWIDocNoDelete').val(tTWITextDocNo);
            $('#odvTWIModalDelPdtInDTTempMultiple #ohdConfirmTWISeqNoDelete').val(tTWITextSeqNo);
            $('#odvTWIModalDelPdtInDTTempMultiple #ohdConfirmTWIPdtCodeDelete').val(tTWITextPdtCode);
            $('#odvTWIModalDelPdtInDTTempMultiple #ohdConfirmTWIPunCodeDelete').val(tTWITextPunCode);
        }
    }

    //ค้นหา KEY
    function JStTWIFindObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }

    //แสดงให้ปุ่ม Delete กดได้
    function JSxTWIShowButtonDelMutiDtTemp() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("TWI_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#odvTWIMngDelPdtInTableDT #oliTWIBtnDeleteMulti").addClass("disabled");
        } else {
            var nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#odvTWIMngDelPdtInTableDT #oliTWIBtnDeleteMulti").removeClass("disabled");
            } else {
                $("#odvTWIMngDelPdtInTableDT #oliTWIBtnDeleteMulti").addClass("disabled");
            }
        }
    }

    // Confirm Delete Modal Multiple
    $('#odvTWIModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JSxTWIDelDocMultiple();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //ลบสินค้าใน Tmp - หลายตัว
    function JSxTWIDelDocMultiple() {
        JCNxOpenLoading();
        var tTWIDocNo = $("#oetTWIDocNo").val();
        var tTWIBchCode = $('#oetSOFrmBchCode').val();
        var tTWIVatInOrEx = 1;
        var aDataPdtCode = JSoTWIRemoveCommaData($('#odvTWIModalDelPdtInDTTempMultiple #ohdConfirmTWIPdtCodeDelete').val());
        var aDataPunCode = JSoTWIRemoveCommaData($('#odvTWIModalDelPdtInDTTempMultiple #ohdConfirmTWIPunCodeDelete').val());
        var aDataSeqNo = JSoTWIRemoveCommaData($('#odvTWIModalDelPdtInDTTempMultiple #ohdConfirmTWISeqNoDelete').val());
        $.ajax({
            type: "POST",
            url: "TXOOutTransferReceiptRemovePdtInDTTmpMulti",
            data: {
                'ptTWIBchCode': tTWIBchCode,
                'ptTWIDocNo': tTWIDocNo,
                'ptTWIVatInOrEx': tTWIVatInOrEx,
                'paDataPdtCode': aDataPdtCode,
                'paDataPunCode': aDataPunCode,
                'paDataSeqNo': aDataSeqNo,
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    $('#odvTWIModalDelPdtInDTTempMultiple').modal('hide');
                    $('#odvTWIModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
                    localStorage.removeItem('TWI_LocalItemDataDelDtTemp');
                    $('#odvTWIModalDelPdtInDTTempMultiple #ohdConfirmTWIDocNoDelete').val('');
                    $('#odvTWIModalDelPdtInDTTempMultiple #ohdConfirmTWISeqNoDelete').val('');
                    $('#odvTWIModalDelPdtInDTTempMultiple #ohdConfirmTWIPdtCodeDelete').val('');
                    $('#odvTWIModalDelPdtInDTTempMultiple #ohdConfirmTWIPunCodeDelete').val('');
                    setTimeout(function() {
                        $('.modal-backdrop').remove();
                        JSvTRNLoadPdtDataTableHtml();
                        $("#odvTWIMngDelPdtInTableDT #oliTWIBtnDeleteMulti").addClass("disabled");
                        JCNxLayoutControll();
                    }, 500);
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

    //ลบ comma
    function JSoTWIRemoveCommaData(paData) {
        var aTexts = paData.substring(0, paData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewDataDeleteComma = [];

        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewDataDeleteComma.push(aDataSplit[$i]);
        }
        return aNewDataDeleteComma;
    }

    //กดบันทึก
    $('#obtTWISubmitFromDoc').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {

            //ถ้าค่าไม่สมบูรณ์ไม่อนุญาตให้บันทึก
            var tWahCode_Input_Origin = $('#oetTROutWahFromCode').val();
            var tWahCode_Input_To = $('#oetTROutWahToCode').val();
            var tWahCode_Output_Spl = $('#oetTRINWahCodeTo').val();
            var tWahCode_Output_Etc = $('#oetTRINWahEtcName').val();
            var tWahCode_Output_Cus = $('#oetTRINWahEtcName').val();
            var tTypeDocument = 'OUT';

            if (tTypeDocument == 0) {
                $('#odvWTIModalTypeIsEmpty').modal('show');
                $('#ospTypeIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tTypeDocumentISEmptyDetail') ?>');
                return;
            } else {
                if (tTypeDocument == 'IN') { //เอกสารรับโอน
                    if (tWahCode_Input_To == '') {
                        $('#odvWTIModalWahIsEmpty').modal('show');
                        $('#ospWahIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tWahDocumentISEmptyDetail') ?>');
                        return;
                    }
                } else if (tTypeDocument == 'OUT') { //เอกสารรับเข้า
                    var tIN = $('#ocmSelectTransTypeIN :selected').val();
                    if (tIN == 0) {
                        $('#odvWTIModalTypeIsEmpty').modal('show');
                        $('#ospTypeIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tINDocumentISEmptyDetail') ?>');
                        return;
                    } else {
                        var tTypeDocumentIN = $('#ocmSelectTransTypeIN :selected').val();
                        if (tTypeDocumentIN == 'SPL') {
                            if ($('#oetTRINWahCodeTo').val() == '') {
                                $('#odvWTIModalWahIsEmpty').modal('show');
                                $('#ospWahIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tWahINDocumentISEmptyDetail') ?>');
                                return;
                            }
                        } else if (tTypeDocumentIN == 'ETC') {
                            if ($('#oetTRINWahEtcCode').val() == '') {
                                $('#odvWTIModalWahIsEmpty').modal('show');
                                $('#ospWahIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tWahINDocumentISEmptyDetail') ?>');
                                return;
                            }
                        } else if (tTypeDocumentIN == 'CUS') {
                        if ($('#oetTRINWahEtcCode').val() == '') {
                            $('#odvWTIModalWahIsEmpty').modal('show');
                            $('#ospWahIsEmpty').html('<?= language('document/transferreceiptNew/transferreceiptNew', 'tWahINDocumentISEmptyDetail') ?>');
                            return;
                        }
                      }
                    }
                }
            }

            $('#obtSubmitTransferreceipt').click();
            //$(".obtTSOAddDocRef").attr("disabled", true).removeClass("xCNBrowsePdtdisabled");
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //อีเวนท์บันทึก - แก้ไข
    function JSxTransferreceiptEventAddEdit(ptRoute) {
            $('#ofmTransferreceiptFormAdd').validate({
                rules: {
                    oetTWIDocNo:  {
                        "required" : {
                            depends: function(oElement){
                                if(ptRoute == "dcmTXOOutEventAdd"){
                                    if($('#ocbTWIStaAutoGenCode').is(':checked')){
                                        return false;
                                    }else{
                                        return true;
                                    }
                                }else{
                                    return true;
                                }
                            }
                        },
                    },
                    oetTWIDocDate: {
                        "required": true
                    },
                    oetTWIDocTime: {
                        "required": true
                    }
                },
                messages: {
                    oetTWIDocNo : {
                        "required" : $('#oetTWIDocNo').attr('data-validate-required'),
                    },
                    oetTWIDocDate : {
                        "required" : $('#oetTWIDocDate').attr('data-validate-required'),
                    },
                    oetTWIDocTime : {
                        "required" : $('#oetTWIDocTime').attr('data-validate-required'),
                    },
                },
                errorElement: "em",
                errorPlacement: function (error, element ) {
                    error.addClass( "help-block" );
                    if ( element.prop( "type" ) === "checkbox" ) {
                        error.appendTo( element.parent( "label" ) );
                    } else {
                        var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                        if(tCheck == 0){
                            error.appendTo(element.closest('.form-group')).trigger('change');
                        }
                    }
                },
                highlight: function ( element, errorClass, validClass ) {
                    $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
                },
                unhighlight: function (element, errorClass, validClass) {
                    $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                },
                submitHandler: function(form) {
                    var tItem = $('#odvTWIDataPdtTableDTTemp #otbTWIDocPdtAdvTableList .xWPdtItem').length;
                    //วันที่ + เวลา
                    $('#oetTWIDocDate').removeAttr('disabled', true);
                    $('#oetTWIDocTime').removeAttr('disabled', true);
                    $('.xCNControllDateTime').removeAttr('disabled', true);
                    $('.xWDropdown').removeAttr('disabled',true);

                    //ประเภท
                    $('#ocmSelectTransferDocument').removeAttr('disabled', true);
                    $('#ocmSelectTransTypeIN').removeAttr('disabled', true);
                    $('#oetTWIINEtc').removeAttr('disabled', true);
                    $('.xCNApvOrCanCelDisabled').removeAttr('disabled', true);
                    //$(".xCNDocBrowsePdt").removeAttr("disabled", true).addClass("xCNBrowsePdtdisabled");
        
                    if (tItem == 0) {
                        $('#odvWTIModalPleaseSelectPDT').modal('show');
                    }else{
                      $.ajax({
                          type: "POST",
                          url: ptRoute,
                          data: $('#ofmTransferreceiptFormAdd').serialize(),
                          cache: false,
                          timeout: 0,
                          success: function(tResult) {
                              // console.log(tResult);
                              var aReturn = JSON.parse(tResult);
                              if (aReturn['nStaReturn'] == 1) {
                                  if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                      JSvTWICallPageEdit(aReturn['tCodeReturn']);
                                  } else if (aReturn['nStaCallBack'] == '2') {
                                      JSvTRNTransferReceiptAdd();
                                  } else if (aReturn['nStaCallBack'] == '3') {
                                      JSvTRNCallPageTransferReceipt(1);
                                  }
                              } else {
                                  alert(aReturn['tStaMessg']);
                              }
                              var nDODocNoCallBack    = aReturn['tCodeReturn'];
                              var oDOCallDataTableFile = {
                                  ptElementID : 'odvDOShowDataTable',
                                  ptBchCode   : $('#oetSOFrmBchCode').val(),
                                  ptDocNo     : nDODocNoCallBack,
                                  ptDocKey    :'TCNTPdtTwiHD',
                              }
                              JCNxUPFInsertDataFile(oDOCallDataTableFile);

                              JCNxCloseLoading();
                          },
                          error: function(jqXHR, textStatus, errorThrown) {
                              JCNxResponseError(jqXHR, textStatus, errorThrown);
                          }
                      });
                    }
                }
            });
    }

    //บันทึก EDIT IN LINE - STEP 1
    function JSxTWISaveEditInline(paParams) {
        var oThisEl = paParams['Element'];
        var nSeqNo = paParams.DataAttribute[1]['data-seq'];
        var tFieldName = paParams.DataAttribute[0]['data-field'];
        var tValue = accounting.unformat(paParams.VeluesInline);
        FSvTWIEditPdtIntoTableDT(nSeqNo, tFieldName, tValue);
    }

    //บันทึก EDIT IN LINE - STEP 2
    function FSvTWIEditPdtIntoTableDT(pnSeqNo, ptFieldName, ptValue) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tTWIDocNo = $("#oetTWIDocNo").val();
            var tTWIBchCode = $("#ohdTWIBchCode").val();
            var tTWIVATInOrEx = $('#ohdTWIFrmSplInfoVatInOrEx').val();
            $.ajax({
                type: "POST",
                url: "TXOOutTransferReceiptEventEditInline",
                data: {
                    'tTWIBchCode': tTWIBchCode,
                    'tTWIDocNo': tTWIDocNo,
                    'tTWIVATInOrEx': tTWIVATInOrEx,
                    'nTWISeqNo': pnSeqNo,
                    'tTWIFieldName': ptFieldName,
                    'tTWIValue': ptValue
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    JSvTRNLoadPdtDataTableHtml();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ค้นหาสินค้าใน TEMP
    function JSvTWIDOCFilterPdtInTableTemp() {
        JCNxOpenLoading();
        JSvTRNLoadPdtDataTableHtml();
    }

    //Next page ในตารางสินค้า Tmp
    function JSvTWIPDTDocDTTempClickPage(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld = $(".xWPageTWIPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld = $(".xWPageTWIPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                default:
                    nPageCurrent = ptPage;
            }
            JCNxOpenLoading();
            JSvTRNLoadPdtDataTableHtml(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //พิมพ์
    function JSxTRNOutPrint(){
        var aInfor = [
            {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'}, // Lang ID
            {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, // Company Code
            {"BranchCode"   : '<?=FCNtGetAddressBranch($tTWIBchCode); ?>'   }, // สาขาที่ออกเอกสาร
            {"DocCode"      : $('#oetTWIDocNo').val()  }, // เลขที่เอกสาร
            {"DocBchCode"   : '<?= $tTWIBchCode;?>'}
        ];
        window.open("<?=base_url(); ?>formreport/Frm_SQL_ALLMPdtBillTnfIn?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

    //กดเพิ่มเอกสารอ้างอิง (ภายใน ภายนอก)
    $('#obtTSOAddDocRef').off('click').on('click',function(){
        $('#ofmTSOFormAddDocRef').validate().destroy();
        JSxTWIEventClearValueInFormHDDocRef();
        $('#odvTSOModalAddDocRef').modal('show');
        $("#odvTSOTypeRefTypeIn").show();
        $("#odvTSOTypeRefTypeOut").hide();
    });
    $("#ocbTWIRefType").change(function(event) {
      var tTape = $(this).val();
      if (tTape=='1') {
          $("#odvTSOTypeRefTypeIn").show();
          $("#odvTSOTypeRefTypeOut").hide();
          $("#oetTWIRefExtDoc").val("");
          $("#oetTWIRefExtDocDate").val("");
      }else {
          $("#odvTSOTypeRefTypeOut").show();
          $("#odvTSOTypeRefTypeIn").hide();
          $("#oetTWIRefIntDoc").val("");
          $("#oetTWIRefIntDocDate").val("");
      }
    });
    //เคลียร์ค่า
    function JSxTWIEventClearValueInFormHDDocRef(){
      $("#oetTWIRefIntDoc").val("");
      $("#oetTWIRefIntDocDate").val("");
      $("#oetTWIRefExtDoc").val("");
      $("#oetTWIRefExtDocDate").val("");
      $("#oetTWIRefKey").val("");
    }
    //กดยืนยันบันทึกลง Temp
    $('#ofmTSOFormAddDocRef').off('click').on('click',function(){
        $('#ofmTSOFormAddDocRef').validate().destroy();
        $('#ofmTSOFormAddDocRef').validate({
            focusInvalid    : false,
            onclick         : false,
            onfocusout      : false,
            onkeyup         : false,
            rules           : {
                oetTWIRefIntDoc      : {
                    "required" : {
                        depends: function(oElement){
                            if($("#ocbTWIRefType").val() =='1'){
                                return true;
                            }else{
                                return false;

                            }
                        }
                    },
                },
                oetTWIRefIntDocDate      : {
                    "required" : {
                        depends: function(oElement){
                            if($("#ocbTWIRefType").val() =='1'){
                                return true;
                            }else{
                                return false;

                            }
                        }
                    },
                },
                oetTWIRefExtDoc      : {
                    "required" : {
                        depends: function(oElement){
                            if($("#ocbTWIRefType").val() =='3'){
                                return true;
                            }else{
                                return false;

                            }
                        }
                    },
                },
                oetTWIRefExtDocDate      : {
                    "required" : {
                        depends: function(oElement){
                            if($("#ocbTWIRefType").val() =='1'){
                                return true;
                            }else{
                                return false;

                            }
                        }
                    },
                }
            },
            messages: {
                oetTWIRefIntDoc      : {"required" : 'กรุณากรอกอ้างอิงเอกสารภายใน'},
                oetTWIRefIntDocDate  : {"required" : 'กรุณากรอกวันที่เอกสารอ้างอิง'},
                oetTWIRefExtDoc      : {"required" : 'กรุณากรอกอ้างอิงเอกสารภายนอก'},
                oetTWIRefExtDocDate  : {"required" : 'กรุณากรอกวันที่เอกสารอ้างอิง'}
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                if(element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                }else{
                    var tCheck  = $(element.closest('.form-group')).find('.help-block').length;
                    if(tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass("has-error");
            },
            submitHandler: function (form){
                JCNxOpenLoading();
                //console.log('ok save');
                if($('#ocbTWIRefType').val() == 1){         //อ้างอิงเอกสารภายใน
                  var tDocNoRef   = $('#oetTWIRefIntDoc').val();
                  var tDocRefDate = $('#oetTWIRefIntDocDate').val();
                }else{                                      //อ้างอิงเอกสารภายนอก
                  var tDocNoRef   = $('#oetTWIRefExtDoc').val();
                  var tDocRefDate  = $('#oetTWIRefExtDocDate').val();
                }
                if ($("#oetTWIDocNo").val()=="") {
                  var  tDocNo = '';
                }else {
                  var  tDocNo = $("#oetTWIDocNo").val();
                }
                var tDocRefKey  = $('#oetTWIRefKey').val();


                $.ajax({
                    type    : "POST",
                    url     : "docTWOEventAddEditHDDocRef",
                    data    : {
                          'ptRefDocNo'     :tDocNoRef,
                          'pdRefDocDate'   :tDocRefDate,
                          'ptRefKey'       :tDocRefKey,
                          'ptRefType'      :$('#ocbTWIRefType').val(),
                          'ptDocNo'        :tDocNo,
                          'ptRefDocNoOld'  :$('#oetTWIRefDocNoOld').val(),
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        JCNxCloseLoading();
                        JSxTWIEventClearValueInFormHDDocRef();
                        $('#odvTSOModalAddDocRef').modal('hide');

                        JSxTWICallPageHDDocRef();

                        // if( $('#ocbTBORefType').val() == 1 ){   //อ้างอิงเอกสารภายใน
                        //
                        //     var tRefIntDocNo    =  $('.xDocuemntRefInt.active').data('docno');
                        //     var tRefIntDocDate  =  $('.xDocuemntRefInt.active').data('docdate');
                        //     var tRefIntBchCode  =  $('.xDocuemntRefInt.active').data('bchcode');
                        //     var aSeqNo 			=  $('.ocbRefIntDocDT:checked').map(function(elm){ return $(this).val(); }).get();
                        //
                        //     var tSplStaVATInOrEx =  $('.xDocuemntRefInt.active').data('vatinroex');
                        //     var cSplCrLimit      =  $('.xDocuemntRefInt.active').data('crtrem');
                        //     var nSplCrTerm       =  $('.xDocuemntRefInt.active').data('crlimit');
                        //     var tSplCode         =  $('.xDocuemntRefInt.active').data('splcode');
                        //     var tSplName         =  $('.xDocuemntRefInt.active').data('splname');
                        //     var tSPlPaidType     =  $('.xDocuemntRefInt.active').data('dstpain');
                        //     var tVatcode         =  $('.xDocuemntRefInt.active').data('vatcode');
                        //     var nVatrate         =  $('.xDocuemntRefInt.active').data('vatrate');
                        //
                        //     var tBchFrm         =  $('.xDocuemntRefInt.active').data('bchfrm');
                        //     var tBchNameFrm     =  $('.xDocuemntRefInt.active').data('bchnamefrm');
                        //
                        //     var tWahFrm         =  $('.xDocuemntRefInt.active').data('wahfrm');
                        //     var tWahNameFrm     =  $('.xDocuemntRefInt.active').data('wahnamefrm');
                        //
                        //     var tBchTo          =  $('.xDocuemntRefInt.active').data('bchto');
                        //     var tBchNameTo      =  $('.xDocuemntRefInt.active').data('bchnameto');
                        //
                        //     var tWahTo          =  $('.xDocuemntRefInt.active').data('wahto');
                        //     var tWahNameTo      =  $('.xDocuemntRefInt.active').data('wahnameto');
                        //
                        //
                        //     $('#obtTransferBchOutBrowseBchFrom').attr('disabled',false);
                        //     $('#obtTransferBchOutBrowseWahFrom').attr('disabled',false);
                        //     $('#oetTransferBchOutXthBchFrmCode').val(tBchFrm);
                        //     $('#oetTransferBchOutXthBchFrmName').val(tBchNameFrm);
                        //     $('#oetTransferBchOutXthWhFrmCode').val(tWahFrm);
                        //     $('#oetTransferBchOutXthWhFrmName').val(tWahNameFrm);
                        //
                        //     $('#obtTransferBchOutBrowseBchTo').attr('disabled',false);
                        //     $('#obtTransferBchOutBrowseWahTo').attr('disabled',false);
                        //     $('#oetTransferBchOutXthBchToCode').val(tBchTo);
                        //     $('#oetTransferBchOutXthBchToName').val(tBchNameTo);
                        //     $('#oetTransferBchOutXthWhToCode').val(tWahTo);
                        //     $('#oetTransferBchOutXthWhToName').val(tWahNameTo);
                        //
                        //
                        //
                        //
                        //
                        //
                        //     // var poParams = {
                        //     // 	FTSplCode           : tSplCode,
                        //     // 	FTSplName           : tSplName,
                        //     // 	FTSplStaVATInOrEx   : tSplStaVATInOrEx,
                        //     // 	FTRefIntDocNo       : tRefIntDocNo,
                        //     // 	FTRefIntDocDate     : tRefIntDocDate,
                        //     // 	FNXphCrTerm         : nSplCrTerm
                        //     // };
                        //
                        //     JCNxOpenLoading();
                        //     $.ajax({
                        //       type    : "POST",
                        //       url     : "docTransferBchOutRefIntDocInsertDTToTemp",
                        //       data    : {
                        //         'tTransferBchOutDocNo'          : $('#oetTransferBchOutDocNo').val(),
                        //         'tTransferBchOutFrmBchCode'     : $('#oetTransferBchOutBchCode').val(),
                        //         'tRefIntDocNo'      			: tRefIntDocNo,
                        //         'tRefIntBchCode'    			: tRefIntBchCode,
                        //         'tSplStaVATInOrEx'  			: tSplStaVATInOrEx,
                        //         'aSeqNo'            			: aSeqNo
                        //       },
                        //       cache: false,
                        //       Timeout: 0,
                        //       success: function (oResult){
                        //         //โหลดสินค้าใน Temp
                        //         JSxTransferBchOutGetPdtInTmp();
                        //         // JCNxCloseLoading();
                        //       },
                        //       error: function (jqXHR, textStatus, errorThrown) {
                        //         JCNxResponseError(jqXHR, textStatus, errorThrown);
                        //       }
                        //     });
                        //
                        // }
                        // JCNxCloseLoading();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    });
    //โหลด Table อ้างอิงเอกสารทั้งหมด
    function JSxTWICallPageHDDocRef(){
        $.ajax({
            type    : "POST",
            url     : "docTWOPageHDDocRef",
            data:{
                'ptDocNo'       : $('#oetTWIDocNo').val(),
                'ptStaApv'      : $('#ohdTransferBchOutStaApv').val(),
                'ptStaPrcDoc'   : $('#ohdTBOStaPrcDoc').val()
            },
            cache   : false,
            timeout : 0,
            success: function(oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == 1 ){
                    $('#odvTWITableHDRef').html(aResult['tViewPageHDRef']);
                    JCNxCloseLoading();
                }else{
                    var tMessageError = aResult['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>
