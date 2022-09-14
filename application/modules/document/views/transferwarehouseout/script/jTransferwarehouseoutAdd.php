<script type="text/javascript">
    var nLangEdits = '<?= $this->session->userdata("tLangEdit"); ?>';
    var tUsrApv = '<?= $this->session->userdata("tSesUsername"); ?>';
    var tTWODocType = $('#oetTWODocType').val();
    var tTWORsnType = '<?= $tTWORsnType; ?>';
    var tTWOStaDoc = '<?= $tTWOStaDoc; ?>';
    var tTWOStaApvDoc = '<?= $tTWOStaApv; ?>';
    var tTWOStaPrcStkDoc = '<?= $tTWOStaPrcStk; ?>';
    var tTWORoute = '<?= $tTWORoute; ?>';
    var tSesUsrLevel = '<?= $this->session->userdata("tSesUsrLevel"); ?>';
    var tUserBchCode = '<?= $this->session->userdata("tSesUsrBchCode"); ?>';
    var tUserBchName = '<?= $this->session->userdata("tSesUsrBchName"); ?>';
    var tUserWahCode = '<?= $this->session->userdata("tSesUsrWahCode"); ?>';
    var tUserWahName = '<?= $this->session->userdata("tSesUsrWahName"); ?>';
    var tRoute = $('#ohdTWORoute').val();
    var nSesUsrBchCount = '<?= $this->session->userdata("nSesUsrBchCount"); ?>';

    $(document).ready(function() {
        if (nSesUsrBchCount == 1) {
            $('#obtBrowseTWOBCH').attr('disabled', true);
        }

        $('#obtTWOConfirmApprDoc').click(function() {
            JSxTWOTransferwarehouseoutStaApvDoc(true);
        });

        $('#ocmSelectTransferDocument').val(tTWODocType);

        if (tTWODocType == 4) {
            $('#odvDocType_2').hide();
        } else {
            $('#odvDocType_4').hide();
        }
        let tTwoRsnTypeCode = '';
        if (tTWORsnType == 3) {
            tTwoRsnTypeCode = 'SPL';
        } else if (tTWORsnType == 4) {
            tTwoRsnTypeCode = 'ETC';
        }

        $('#ocmSelectTransTypeIN').val(tTwoRsnTypeCode).change();

        //เอกสารถูกยกเลิก
        if (tTWOStaDoc == 3 || tTWOStaApvDoc == 1) {
            $('#obtTWOPrintDoc').show();
            $('#obtTWOCancelDoc').hide();
            $('#obtTWOApproveDoc').hide();
            $('#odvTWOBtnGrpSave').hide();

            //วันที่ + เวลา
            $('#oetTWODocDate').attr('disabled', true);
            $('#oetTWODocTime').attr('disabled', true);
            $('.xCNBtnDateTime').attr('disabled', true);
            $('.xWDropdown').attr('disabled', true);
            $('#obtTWOFrmBrowseShipAdd').attr('disabled', true);

            //ประเภท
            $('#ocmSelectTransferDocument').attr('disabled', true);
            $('#ocmSelectTransTypeIN').attr('disabled', true);
            $('#oetTWOINEtc').attr('disabled', true);
            $('.xCNApvOrCanCelDisabled').attr('disabled', true);
            $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        } else {
            if (tTWOStaDoc == 1 && tTWORoute == 'dcmTWOEventEdit') {
                $('#obtTWOPrintDoc').show();
                $('#obtTWOCancelDoc').show();
                $('#obtTWOApproveDoc').show();
            } else {
                $('#odvTWOBtnGrpSave').show();
                $('#obtTWOPrintDoc').hide();
                $('#obtTWOCancelDoc').hide();
                $('#obtTWOApproveDoc').hide();
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
        $('#obtTWODocDate').unbind().click(function() {
            $('#oetTWODocDate').datepicker('show');
        });

        $('#obtTWODocTime').unbind().click(function() {
            $('#oetTWODocTime').datetimepicker('show');
        });

        $('#obtTWOBrowseRefIntDocDate').unbind().click(function() {
            $('#oetTWORefIntDocDate').datepicker('show');
        });

        $('#obtTWOBrowseRefExtDocDate').unbind().click(function() {
            $('#oetTWORefExtDocDate').datepicker('show');
        });

        $('#obtTWOTnfDate').unbind().click(function() {
            $('#oetTWOTransportTnfDate').datepicker('show');
        });

        // ================================== Set Date Default =================================
        var dCurrentDate = new Date();
        var tAmOrPm = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
        var tCurrentTime = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

        if ($('#oetTWODocDate').val() == '') {
            $('#oetTWODocDate').datepicker("setDate", dCurrentDate);
        }

        if ($('#oetTWODocTime').val() == '') {
            $('#oetTWODocTime').val(tCurrentTime);
        }

        // =============================== Check Box Auto GenCode ==============================
        $('#ocbTWOStaAutoGenCode').on('change', function(e) {
            if ($('#ocbTWOStaAutoGenCode').is(':checked')) {
                $("#oetTWODocNo").val('');
                $("#oetTWODocNo").attr("readonly", true);
                $('#oetTWODocNo').closest(".form-group").css("cursor", "not-allowed");
                $('#oetTWODocNo').css("pointer-events", "none");
                $("#oetTWODocNo").attr("onfocus", "this.blur()");
                $('#ofmTWOFormAdd').removeClass('has-error');
                $('#ofmTWOFormAdd .form-group').closest('.form-group').removeClass("has-error");
                $('#ofmTWOFormAdd em').remove();
            } else {
                $('#oetTWODocNo').closest(".form-group").css("cursor", "");
                $('#oetTWODocNo').css("pointer-events", "");
                $('#oetTWODocNo').attr('readonly', false);
                $("#oetTWODocNo").removeAttr("onfocus");
            }
        });


        //เคลียร์ค่า กลับมาแบบตั้งต้น
        $('.xCNClearValue').val('');
        if ($('#oetTROutShpFromCode').val() == '') {
            $('#obtBrowseTROutFromPos').attr('disabled', true);
            if (<?= FCNbGetIsShpEnabled() ? '1' : '0'; ?> == 0) {
                $('#obtBrowseTROutFromPos').attr('disabled', false);
            }
        } else {
            $('#obtBrowseTROutFromPos').attr('disabled', false);
            if (<?= FCNbGetIsShpEnabled() ? '1' : '0'; ?> == 0) {
                $('#obtBrowseTROutFromPos').attr('disabled', false);
            }
        }

        if ($('#oetTROutShpToCode').val() == '') {
            $('#obtBrowseTROutToPos').attr('disabled', true);
        } else {
            $('#obtBrowseTROutToPos').attr('disabled', false);

        }


        JSxTWOEventCheckShowHDDocRef();
    });

    /** ========================================= Set Shipping Address =========================================== */
    $('#obtTWOFrmBrowseShipAdd').unbind().click(function() {
        // var nStaSession = JCNxFuncChkSessionExpired();
        // if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        // console.log('aaa');
        $('#odvTWOBrowseShipAdd').modal({
            backdrop: 'static',
            keyboard: false
        })
        $('#odvTWOBrowseShipAdd').modal('show');
        // } else {
        //     JCNxShowMsgSessionExpired();
        // }
    });


    // เลือกขนส่งโดย
    $("#obtSearchShipVia").click(function() {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
        // option Ship Address 
        oTFWBrowseShipVia = {
            Title: ['document/producttransferwahouse/producttransferwahouse', 'tTFWShipViaModalTitle'],
            Table: {
                Master: 'TCNMShipVia',
                PK: 'FTViaCode'
            },
            Join: {
                Table: ['TCNMShipVia_L'],
                On: [
                    "TCNMShipVia.FTViaCode = TCNMShipVia_L.FTViaCode AND TCNMShipVia_L.FNLngID = " + nLangEdits
                ]
            },
            GrideView: {
                ColumnPathLang: 'document/producttransferwahouse/producttransferwahouse',
                ColumnKeyLang: ['tTFWShipViaCode', 'tTFWShipViaName'],
                DataColumns: ['TCNMShipVia.FTViaCode', 'TCNMShipVia_L.FTViaName'],
                DataColumnsFormat: ['', ''],
                ColumnsSize: [''],
                Perpage: 10,
                WidthModal: 50,
                OrderBy: ['TCNMShipVia.FDCreateOn DESC'],
                // SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTWOUpVendingViaCode", "TCNMShipVia.FTViaCode"],
                Text: ["oetTWOUpVendingViaName", "TCNMShipVia_L.FTViaName"],
            },
            BrowseLev: 1
        }
        JCNxBrowseData('oTFWBrowseShipVia');
    });

    // Option Browse Shipping Address
    var oTWOBrowseShipAddress = function(poDataFnc) {
        var tInputReturnCode = poDataFnc.tReturnInputCode;
        var tInputReturnName = poDataFnc.tReturnInputName;
        var tTWOWhereCons = poDataFnc.tTWOWhereCons;
        var tNextFuncName = poDataFnc.tNextFuncName;
        var aArgReturn = poDataFnc.aArgReturn;
        var oOptionReturn = {
            Title: ['document/transferwarehouseout/transferwarehouseout', 'tTWOShipAddress'],
            Table: {
                Master: 'TCNMAddress_L',
                PK: 'FNAddSeqNo'
            },
            Join: {
                Table: ['TCNMProvince_L', 'TCNMDistrict_L', 'TCNMSubDistrict_L'],
                On: [
                    "TCNMAddress_L.FTAddV1PvnCode = TCNMProvince_L.FTPvnCode AND TCNMProvince_L.FNLngID = " + nLangEdits,
                    "TCNMAddress_L.FTAddV1DstCode = TCNMDistrict_L.FTDstCode AND TCNMDistrict_L.FNLngID = " + nLangEdits,
                    "TCNMAddress_L.FTAddV1SubDist = TCNMSubDistrict_L.FTSudCode AND TCNMSubDistrict_L.FNLngID = " + nLangEdits
                ]
            },
            Where: {
                Condition: [tTWOWhereCons]
            },
            GrideView: {
                ColumnPathLang: 'document/transferwarehouseout/transferwarehouseout',
                ColumnKeyLang: [
                    'tTWOShipADDBch',
                    'tTWOShipADDSeq',
                    'tTWOShipADDV1No',
                    'tTWOShipADDV1Soi',
                    'tTWOShipADDV1Village',
                    'tTWOShipADDV1Road',
                    'tTWOShipADDV1SubDist',
                    'tTWOShipADDV1DstCode',
                    'tTWOShipADDV1PvnCode',
                    'tTWOShipADDV1PostCode'
                ],
                DataColumns: [
                    'TCNMAddress_L.FTAddRefCode',
                    'TCNMAddress_L.FNAddSeqNo',
                    'TCNMAddress_L.FTAddV1No',
                    'TCNMAddress_L.FTAddV1Soi',
                    'TCNMAddress_L.FTAddV1Village',
                    'TCNMAddress_L.FTAddV1Road',
                    'TCNMAddress_L.FTAddV1SubDist',
                    'TCNMAddress_L.FTAddV1DstCode',
                    'TCNMAddress_L.FTAddV1PvnCode',
                    'TCNMAddress_L.FTAddV1PostCode',
                    'TCNMSubDistrict_L.FTSudName',
                    'TCNMDistrict_L.FTDstName',
                    'TCNMProvince_L.FTPvnName',
                    'TCNMAddress_L.FTAddV2Desc1',
                    'TCNMAddress_L.FTAddV2Desc2'
                ],
                DataColumnsFormat: ['', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
                ColumnsSize: [''],
                DisabledColumns: [10, 11, 12, 13, 14],
                Perpage: 10,
                WidthModal: 50,
                OrderBy: ['TCNMAddress_L.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMAddress_L.FNAddSeqNo"],
                Text: [tInputReturnName, "TCNMAddress_L.FNAddSeqNo"],
            },
            NextFunc: {
                FuncName: tNextFuncName,
                ArgReturn: aArgReturn
            },
            BrowseLev: 1
        };
        return oOptionReturn;
    };

    // Event Browse Shipping Address
    $('#odvTWOBrowseShipAdd #oliPIEditShipAddress').unbind().click(function() {
        // var nStaSession = JCNxFuncChkSessionExpired();
        // if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        // console.log('click');
        var tTWOWhereCons = "";
        if ($("#oetSOFrmBchCode").val() != "") {
            if ($("#oetTROutShpToCode").val() != "") {

                // Address Ref SHOP
                tTWOWhereCons += "AND FTAddGrpType = 4 AND FTAddRefCode = '" + $("#oetTROutShpToCode").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;

            } else {
                // Address Ref BCH
                tTWOWhereCons += "AND FTAddGrpType = 1 AND FTAddRefCode = '" + $("#oetSOFrmBchCode").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
            }
        }
        // Call Option Modal
        window.oTWOBrowseShipAddressOption = undefined;
        oTWOBrowseShipAddressOption = oTWOBrowseShipAddress({
            'tReturnInputCode': 'ohdTWOShipAddSeqNo',
            'tReturnInputName': 'ohdTWOShipAddSeqNo',
            'tTWOWhereCons': tTWOWhereCons,
            'tNextFuncName': 'JSvTWOGetShipAddrData',
            'aArgReturn': [
                'FNAddSeqNo',
                'FTAddV1No',
                'FTAddV1Soi',
                'FTAddV1Village',
                'FTAddV1Road',
                'FTSudName',
                'FTDstName',
                'FTPvnName',
                'FTAddV1PostCode',
                'FTAddV2Desc1',
                'FTAddV2Desc2'
            ]
        });
        $("#odvTWOBrowseShipAdd").modal("hide");
        $('.modal-backdrop').remove();
        JCNxBrowseData('oTWOBrowseShipAddressOption');
        // } else {
        //     $("#odvTWOBrowseShipAdd").modal("hide");
        //     $('.modal-backdrop').remove();
        //     JCNxShowMsgSessionExpired();
        // }
    });

    //Functionality : Behind NextFunc Browse Shippinh Address
    function JSvTWOGetShipAddrData(paInForCon) {
        if (paInForCon !== "NULL") {
            var aDataReturn = JSON.parse(paInForCon);
            $("#ospTWOShipAddAddV1No").text((aDataReturn[1] != "") ? aDataReturn[1] : '-');
            $("#ospTWOShipAddV1Soi").text((aDataReturn[2] != "") ? aDataReturn[2] : '-');
            $("#ospTWOShipAddV1Village").text((aDataReturn[3] != "") ? aDataReturn[3] : '-');
            $("#ospTWOShipAddV1Road").text((aDataReturn[4] != "") ? aDataReturn[4] : '-');
            $("#ospTWOShipAddV1SubDist").text((aDataReturn[5] != "") ? aDataReturn[5] : '-');
            $("#ospTWOShipAddV1DstCode").text((aDataReturn[6] != "") ? aDataReturn[6] : '-');
            $("#ospTWOShipAddV1PvnCode").text((aDataReturn[7] != "") ? aDataReturn[7] : '-');
            $("#ospTWOShipAddV1PostCode").text((aDataReturn[8] != "") ? aDataReturn[8] : '-');
            $("#ospTWOShipAddV2Desc1").text((aDataReturn[9] != "") ? aDataReturn[9] : '-');
            $("#ospTWOShipAddV2Desc2").text((aDataReturn[10] != "") ? aDataReturn[10] : '-');
        } else {
            $("#ospTWOShipAddAddV1No").text("-");
            $("#ospTWOShipAddV1Soi").text("-");
            $("#ospTWOShipAddV1Village").text("-");
            $("#ospTWOShipAddV1Road").text("-");
            $("#ospTWOShipAddV1SubDist").text("-");
            $("#ospTWOShipAddV1DstCode").text("-");
            $("#ospTWOShipAddV1PvnCode").text("-");
            $("#ospTWOShipAddV1PostCode").text("-");
            $("#ospTWOShipAddV2Desc1").text("-");
            $("#ospTWOShipAddV2Desc2").text("-");
        }
        $("#odvPIBrowseShipAdd").modal("show");
    }

    // ===================================== เลือกสินค้า =====================================
    $('#obtTWODocBrowsePdt').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            JCNvTWOBrowsePdt();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // ===================================== แสดงคอลัมน์ =====================================
    $('#obtTWOAdvTablePdtDTTemp').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxTWOOpenColumnFormSet();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // ===================================== เลือกคอลัมน์ที่จะแสดง =====================================
    $('#odvTWOOrderAdvTblColumns #obtTWOSaveAdvTableColums').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxTWOSaveColumnShow();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    // ===================================== เลือกประเภทต่างๆ =====================================

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
            DataColumns: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
            DataColumnsFormat: ['', '', ''],
            Perpage: 10,
            OrderBy: ['TCNMShop.FDCreateOn DESC, TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ['oetTROutShpFromCode', "TCNMShop.FTShpCode"],
            Text: ['oetTROutShpFromName', "TCNMShop_L.FTShpName"]
        },
        NextFunc: {
            FuncName: 'JSxSelectTROutFromShp',
            ArgReturn: ['FTShpCode'],
        }
        // DebugSQL : true
    }
    $('#obtBrowseTROutFromShp').click(function() {
        var tBCHCode = $('#oetSOFrmBchCode').val();
        // oBrowseTROutFromShp.Where.Condition = ["AND TCNMShop.FTBchCode='" + tBCHCode + "' "];
        oBrowseTROutFromShp.Where.Condition = ["AND TCNMShop.FTBchCode IN ('" + tBCHCode + "' )"];
        JCNxBrowseData('oBrowseTROutFromShp');
    });

    function JSxSelectTROutFromShp(ptCode) {
        if (ptCode == 'NULL' || ptCode == null) {
            $('#obtBrowseTROutFromPos').attr('disabled', true);
            $('#obtBrowseTROutFromWah').attr('disabled', false);

        } else {
            var tResult = JSON.parse(ptCode);
            $('#obtBrowseTROutFromPos').attr('disabled', false);
            $('#obtBrowseTROutFromWah').attr('disabled', false);

            oBrowseTROutFromPos.Where.Condition = [
                " AND TVDMPosShop.FTBchCode = '" + $('#oetSOFrmBchCode').val() + "'  AND TVDMPosShop.FTShpCode = '" + tResult[0] + "' " +
                " AND TVDMPosShop.FTPosCode != '" + $('#oetTROutPosToCode').val() + "' "
            ]
            // oBrowseTROutFromWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tResult[0] + "' "] 
        }

        //ล้างค่าเครื่องจุดขาย
        $('#oetTROutPosFromName').val('');
        $('#oetTROutPosFromCode').val('');

        //ล้างค่าคลังสินค้า
        $('#oetTROutWahFromName').val('');
        $('#oetTROutWahFromCode').val('');
    }

    //เลือกเครื่องจุดขายต้นทาง
    var oBrowseTROutFromPos;
    $('#obtBrowseTROutFromPos').click(function() {
        var tMasterTable = 'TVDMPosShop';
        var aJoin = [
            'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTBchCode=TVDMPosShop.FTBchCode  AND FTWahStaType = 6',
            'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
        ];
        var aCondition = [" AND TVDMPosShop.FTBchCode = '" + $('#oetSOFrmBchCode').val() + "'  AND TVDMPosShop.FTShpCode = '" + $('#oetTROutShpFromCode').val() + "' " +
            " AND TVDMPosShop.FTPosCode != '" + $('#oetTROutPosToCode').val() + "' "
        ];
        if (<?= FCNbGetIsShpEnabled() ? '1' : '0'; ?> == 0) {
            tMasterTable = 'TCNMPos';
            aJoin = [
                'TCNMPos.FTPosCode = TCNMWaHouse.FTWahRefCode AND FTWahStaType IN (\'6\')',
                'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
            ];
            aCondition = [" AND TCNMPos.FTBchCode = '" + $('#oetSOFrmBchCode').val() + "'" +
                " AND TCNMPos.FTPosCode != '" + $('#oetTROutPosToCode').val() + "' "
            ];
        }

        oBrowseTROutFromPos = {
            Title: ['pos/posshop/posshop', 'tPshBRWPOSTitle'],
            Table: {
                Master: tMasterTable,
                PK: 'FTPosCode'
            },
            Join: {
                Table: ['TCNMWaHouse', 'TCNMWaHouse_L'],
                On: aJoin
            },
            Where: {
                Condition: aCondition
            },
            GrideView: {
                ColumnPathLang: 'pos/posshop/posshop',
                ColumnKeyLang: ['tPshTBPosCode', 'tPshTBPosCode', 'tPshTBPosCode'],
                ColumnsSize: ['10%', '10%', '10%'],
                WidthModal: 50,
                DataColumns: [tMasterTable + '.FTPosCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['', '', ''],
                DisabledColumns: [1, 2],
                Perpage: 10,
                OrderBy: [tMasterTable + '.FTPosCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTROutPosFromCode", tMasterTable + ".FTPosCode"],
                Text: ["oetTROutPosFromName", tMasterTable + ".FTPosCode"],
            },
            NextFunc: {
                FuncName: 'JSxSelectTROutFromPos',
                ArgReturn: ['FTPosCode', 'FTWahCode', 'FTWahName'],
            }
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
    var oBrowseTROutFromWah_SHP = function(paParam) {

        var tBchCode = paParam.tBchCode;
        var tShpCode = paParam.tShpCode;

        var oOptionReturn = {
            Title: ['company/shop/shop', 'tSHPWah'],
            Table: {
                Master: 'TCNMShpWah',
                PK: 'FTWahCode'
            },
            Join: {
                Table: ['TCNMWaHouse_L', 'TCNMWaHouse'],
                On: [
                    'TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMShpWah.FTBchCode  AND TCNMWaHouse_L.FNLngID = ' + nLangEdits,
                    'TCNMShpWah.FTWahCode =  TCNMWaHouse.FTWahCode AND  TCNMShpWah.FTBchCode = TCNMWaHouse.FTBchCode '
                ]
            },
            Where: {
                Condition: [" AND TCNMWaHouse.FTWahStaType = 4 AND TCNMShpWah.FTShpCode = '" + tShpCode + "' AND TCNMShpWah.FTBchCode = '" + tBchCode + "' "]
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
                Value: ["oetTROutWahFromCode", "TCNMShpWah.FTWahCode"],
                Text: ["oetTROutWahFromName", "TCNMWaHouse_L.FTWahName"],
            }
        }
        return oOptionReturn;
    }

    var oBrowseTROutFromWah_BCH = function(paDataparamiter) {

        let tBchCode = paDataparamiter.tBchCode;
        let tWahCodeTo = paDataparamiter.tWahCodeTo;
        var oOptionReturn = {
            Title: ['company/shop/shop', 'tSHPWah'],
            Table: {
                Master: 'TCNMWaHouse',
                PK: 'FTWahCode'
            },
            Join: {
                Table: ['TCNMWaHouse_L'],
                On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode  AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
            },
            Where: {
                Condition: ["AND TCNMWaHouse.FTWahStaType IN (1,2,5) AND TCNMWaHouse.FTWahRefCode = '" + tBchCode + "' AND TCNMWaHouse.FTWahCode !='" + tWahCodeTo + "'"]
            },
            GrideView: {
                ColumnPathLang: 'company/shop/shop',
                ColumnKeyLang: ['tWahCode', 'tWahName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMWaHouse.FDCreateOn DESC']
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTROutWahFromCode", "TCNMWaHouse.FTWahCode"],
                Text: ["oetTROutWahFromName", "TCNMWaHouse_L.FTWahName"],
            },
            // DebugSQL : true
        }
        return oOptionReturn;
    }

    $('#obtBrowseTROutFromWah').click(function() {

        var tBCH = $('#oetSOFrmBchCode').val();
        var tWahCodeTo = $('#oetTROutWahToCode').val();
        oBrowseTROutFromWah_BCH_Option = oBrowseTROutFromWah_BCH({
            'tBchCode': tBCH,
            'tWahCodeTo': tWahCodeTo
        });
        oBrowseTROutFromWah_BCH_Option.Where.Condition = [" AND TCNMWaHouse.FTBchCode = '" + tBCH + "' AND TCNMWaHouse.FTWahStaPrcStk = '2' "];
        JCNxBrowseData('oBrowseTROutFromWah_BCH_Option');

    });

    //นำเข้าข้อมูล
    // $('#obtImportPDTInCN').click(function(){ 
    //     var tBCHCode = $('#oetSOFrmBchCode').val();
    //     var tSHPCode = $('#oetTROutShpFromCode').val();
    //     var tWAHCode = $('#oetTROutWahFromCode').val();

    //     $.ajax({
    //         type    : "POST",
    //         url     : "TWOTransferwarehouseoutSelectPDTInCN",
    //         cache   : false,
    //         data    : {
    //             tBCHCode : tBCHCode,
    //             tSHPCode : tSHPCode,
    //             tWAHCode : tWAHCode
    //         },
    //         Timeout : 0,
    //         success : function (oResult) {
    //             var aDataReturn = JSON.parse(oResult);
    //             if(aDataReturn['nStaEvent'] == '1'){
    //                 var tViewTableShow   = aDataReturn['tViewPageAdd'];
    //                 $('#odvTWOModalPDTCN .modal-body').html(tViewTableShow);
    //                 $('#odvTWOModalPDTCN').modal({backdrop: 'static', keyboard: false})  
    //                 $("#odvTWOModalPDTCN").modal({ show: true });
    //             }else{
    //                 var tMessageError = aReturnData['tStaMessg'];
    //                 FSvCMNSetMsgErrorDialog(tMessageError);
    //                 JCNxCloseLoading();
    //             }
    //         },
    //         error: function (jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });

    //  });

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
            OrderBy: ['TCNMShop.FDCreateOn DESC, TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
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
        var tBCHCode = $('#oetSOFrmBchCode').val();
        oBrowseTROutToShp.Where.Condition = ["AND TCNMShop.FTBchCode='" + tBCHCode + "' "];
        JCNxBrowseData('oBrowseTROutToShp');
    });

    function JSxSelectTRToFromShp(ptCode) {
        if (ptCode == 'NULL' || ptCode == null) {
            $('#obtBrowseTROutToPos').attr('disabled', true);
            $('#obtBrowseTROutToWah').attr('disabled', false);
        } else {
            var tResult = JSON.parse(ptCode);
            $('#obtBrowseTROutToPos').attr('disabled', false);
            $('#obtBrowseTROutToWah').attr('disabled', false);

            // oBrowseTROutToPos.Where.Condition = ["AND FTShpCode = '" + tResult[0] + "' "] 
            oBrowseTROutToPos.Where.Condition = [
                " AND TVDMPosShop.FTBchCode = '" + $('#oetSOFrmBchCode').val() + "'  AND TVDMPosShop.FTShpCode = '" + tResult[0] + "' " +
                " AND TVDMPosShop.FTPosCode != '" + $('#oetTROutPosFromCode').val() + "' "
            ]
            // oBrowseTROutToWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tResult[0] + "' "] 
        }

        //ล้างค่าเครื่องจุดขาย
        $('#oetTROutPosToName').val('');
        $('#oetTROutPosToCode').val('');

        //ล้างค่าคลังสินค้า
        $('#oetTROutWahToName').val('');
        $('#oetTROutWahToCode').val('');
    }

    //เลือกเครื่องจุดขายปลายทาง
    var oBrowseTROutToPos;

    // $('#obtBrowseTROutToPos').attr('disabled',true);
    $('#obtBrowseTROutToPos').click(function() {
        var tMasterTable = 'TVDMPosShop';
        var aJoin = [
            'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTBchCode=TVDMPosShop.FTBchCode',
            'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
        ];
        var aCondition = [" AND TVDMPosShop.FTBchCode = '" + $('#oetSOFrmBchCode').val() + "'  AND TVDMPosShop.FTShpCode = '" + $('#oetTROutShpToCode').val() + "' " +
            " AND TVDMPosShop.FTPosCode != '" + $('#oetTROutPosFromCode').val() + "' "
        ];
        if (<?= FCNbGetIsShpEnabled() ? '1' : '0'; ?> == 0) {
            tMasterTable = 'TCNMPos';
            aJoin = [
                'TCNMPos.FTPosCode = TCNMWaHouse.FTWahRefCode AND FTWahStaType IN (\'6\')',
                'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
            ];
            aCondition = [" AND TCNMPos.FTBchCode = '" + $('#oetSOFrmBchCode').val() + "'" +
                " AND TCNMPos.FTPosCode != '" + $('#oetTROutPosFromCode').val() + "' "
            ];
        }
        oBrowseTROutToPos = {
            Title: ['pos/posshop/posshop', 'tPshBRWPOSTitle'],
            Table: {
                Master: tMasterTable,
                PK: 'FTPosCode'
            },
            Join: {
                Table: ['TCNMWaHouse', 'TCNMWaHouse_L'],
                On: aJoin
            },
            Where: {
                Condition: aCondition
            },
            GrideView: {
                ColumnPathLang: 'pos/posshop/posshop',
                ColumnKeyLang: ['tPshTBPosCode', 'tPshTBPosCode', 'tPshTBPosCode'],
                ColumnsSize: ['10%', '10%', '10%'],
                WidthModal: 50,
                DataColumns: [tMasterTable + '.FTPosCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['', '', ''],
                DisabledColumns: [1, 2],
                Perpage: 10,
                OrderBy: [tMasterTable + '.FTPosCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTROutPosToCode", tMasterTable + ".FTPosCode"],
                Text: ["oetTROutPosToName", tMasterTable + ".FTPosCode"],
            },
            NextFunc: {
                FuncName: 'JSxSelectTROutToPos',
                ArgReturn: ['FTPosCode', 'FTWahCode', 'FTWahName']
            }
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


    var oBrowseTROutToWah_SHP = function(paParam) {

        var tBchCode = paParam.tBchCode;
        var tShpCode = paParam.tShpCode;

        var oOptionReturn = {
            Title: ['company/shop/shop', 'tSHPWah'],
            Table: {
                Master: 'TCNMShpWah',
                PK: 'FTWahCode'
            },
            Join: {
                Table: ['TCNMWaHouse_L', 'TCNMWaHouse'],
                On: [
                    'TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMShpWah.FTBchCode  AND TCNMWaHouse_L.FNLngID = ' + nLangEdits,
                    'TCNMShpWah.FTWahCode =  TCNMWaHouse.FTWahCode AND  TCNMShpWah.FTBchCode = TCNMWaHouse.FTBchCode '
                ]
            },
            Where: {
                Condition: [" AND TCNMWaHouse.FTWahStaType = 4 AND TCNMShpWah.FTShpCode = '" + tShpCode + "' AND TCNMShpWah.FTBchCode = '" + tBchCode + "' "]
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
                Value: ["oetTROutWahToCode", "TCNMShpWah.FTWahCode"],
                Text: ["oetTROutWahToName", "TCNMWaHouse_L.FTWahName"],
            }
        }
        return oOptionReturn;
    }


    var oBrowseTROutToWah_BCH = function(paParam) {

        let tBchCode = paParam.tBchCode;
        let tWahCodeFrom = paParam.tWahCodeFrom;

        console.log(tWahCodeFrom);

        var oOptionReturn = {
            Title: ['company/shop/shop', 'tSHPWah'],
            Table: {
                Master: 'TCNMWaHouse',
                PK: 'FTWahCode'
            },
            Join: {
                Table: ['TCNMWaHouse_L'],
                On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND  TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode   AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
            },
            Where: {
                Condition: ["AND TCNMWaHouse.FTWahStaType IN(1,2,5) AND TCNMWaHouse.FTWahRefCode = '" + tBchCode + "' AND TCNMWaHouse.FTWahCode != '" + tWahCodeFrom + "' "]
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
                Value: ["oetTROutWahToCode", "TCNMWaHouse.FTWahCode"],
                Text: ["oetTROutWahToName", "TCNMWaHouse_L.FTWahName"],
            }
        }
        return oOptionReturn;
    }

    $('#obtBrowseTROutToWah').click(function() {
        // if ($('#oetTROutShpToCode').val() != '') {
        //     //เลือกคลังที่ร้านค้า
        //     var tBCH = $('#oetSOFrmBchCode').val();
        //     var tSHP = $('#oetTROutShpToCode').val();
        //     oBrowseTROutToWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '" + tBCH + "' "];
        //     JCNxBrowseData('oBrowseTROutToWah_SHP');
        // } else if ($('#oetSOFrmBchCode').val() != '') {
        //     //เลือกคลังที่สาขา
        //     var tBCH = $('#oetSOFrmBchCode').val();
        //     var tWahCodeFrom = $('#oetTROutWahFromCode').val();
        //     oBrowseTROutToWah_BCH_Option = oBrowseTROutToWah_BCH({
        //         'tBchCode': tBCH,
        //         'tWahCodeFrom': tWahCodeFrom
        //     });
        //     //  oBrowseTROutToWah_BCH.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "'"];
        //     JCNxBrowseData('oBrowseTROutToWah_BCH_Option');
        // }

        if ($('#oetTROutShpToCode').val() != '') {
            //เลือกคลังที่ร้านค้า
            var tBCH = $('#oetSOFrmBchCode').val();
            var tSHP = $('#oetTROutShpToCode').val();
            // oBrowseTROutFromWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '"+ tBCH + "' "];
            oBrowseTROutToWah_SHP_Option = oBrowseTROutToWah_SHP({
                'tBchCode': tBCH,
                'tShpCode': tSHP
            });
            if ($("#oetTROutWahFromCode").val() != "") {
                oBrowseTROutToWah_SHP_Option.Where.Condition = [" AND TCNMWaHouse.FTWahStaType = 4 AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '" + tBCH + "' AND TCNMWaHouse.FTWahCode NOT IN ('" + $("#oetTROutWahFromCode").val() + "') "];
            }
            JCNxBrowseData('oBrowseTROutToWah_SHP_Option');

        } else if ($('#oetSOFrmBchCode').val() != '') {
            var tBCH = $('#oetSOFrmBchCode').val();
            var tWahCodeFrom = $('#oetTROutWahFromCode').val();
            oBrowseTROutToWah_BCH_Option = oBrowseTROutToWah_BCH({
                'tBchCode': tBCH,
                'tWahCodeFrom': tWahCodeFrom
            });
            oBrowseTROutToWah_BCH_Option.Where.Condition = [" AND TCNMWaHouse.FTBchCode = '" + tBCH + "'"];
            JCNxBrowseData('oBrowseTROutToWah_BCH_Option');
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
            OrderBy: ['TCNMSpl.FTSplCode'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTRINSplFromCode", "TCNMSpl.FTSplCode"],
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
            Condition: ["AND TCNMShop.FTBchCode='" + $('#oetSOFrmBchCode').val() + "' "]
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
            Value: ['oetTRINShpFromCode', "TCNMShop.FTShpCode"],
            Text: ['oetTRINShpName', "TCNMShop_L.FTShpName"]
        },
        NextFunc: {
            FuncName: 'JSxSelectTRINFromPos',
            ArgReturn: ['FTShpCode']
        }
    }
    $('#obtBrowseTRINFromShp').click(function() {
        JCNxBrowseData('oBrowseTRINFromShp');
    });

    function JSxSelectTRINFromPos(ptCode) {
        if (ptCode == 'NULL' || ptCode == null) {
            $('#oetTRINWahFromName').val('');
            $('#oetTRINWahFromCode').val('');
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
            OrderBy: ['TCNMWaHouse_L.FTWahName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTRINWahFromCode", "TCNMShpWah.FTWahCode"],
            Text: ["oetTRINWahFromName", "TCNMWaHouse_L.FTWahName"],
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
            On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
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
            Value: ["oetTRINWahFromCode", "TCNMWaHouse.FTWahCode"],
            Text: ["oetTRINWahFromName", "TCNMWaHouse_L.FTWahName"],
        }
    }

    $('#obtBrowseTRINFromWah').click(function() {
        if ($('#oetTRINShpFromCode').val() != '') {
            //เลือกคลังที่ร้านค้า
            var tBCH = $('#oetSOFrmBchCode').val();
            var tSHP = $('#oetTRINShpFromCode').val();
            oBrowseTRINToWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '" + tBCH + "' "];
            JCNxBrowseData('oBrowseTRINToWah_SHP');
        } else if ($('#oetSOFrmBchCode').val() != '') {
            //เลือกคลังที่สาขา
            var tBCH = $('#oetSOFrmBchCode').val();
            oBrowseTRINToWah_BCH.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "'"];
            JCNxBrowseData('oBrowseTRINToWah_BCH');
        }
    });

    //เลือกคลังสินค้า - จากแบบ =>  แหล่งอื่น
    var oBrowseTRINEtcWah = {
        Title: ['company/shop/shop', 'tSHPWah'],
        Table: {
            Master: 'TCNMWaHouse',
            PK: 'FTWahCode'
        },
        Join: {
            Table: ['TCNMWaHouse_L'],
            On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
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
            Value: ["oetTRINWahEtcCode", "TCNMWaHouse.FTWahCode"],
            Text: ["oetTRINWahEtcName", "TCNMWaHouse_L.FTWahName"],
        }
    }
    $('#obtBrowseTRINEtcWah').click(function() {
        var tBCH = $('#oetSOFrmBchCode').val();
        oBrowseTRINEtcWah.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "'"];
        JCNxBrowseData('oBrowseTRINEtcWah');
    });

    //เหตุผล
    var oBrowseTWOReason = {
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
            Value: ['oetTWOReasonCode', "TCNMRsn.FTRsnCode"],
            Text: ['oetTWOReasonName', "TCNMRsn_L.FTRsnName"]
        }
    }
    $('#obtBrowseTWOReason').click(function() {
        JCNxBrowseData('oBrowseTWOReason');
    });

    // ======================================================================================

    //แสดงคอลัมน์
    function JSxTWOOpenColumnFormSet() {
        $.ajax({
            type: "POST",
            url: "TWOTransferAdvanceTableShowColList",
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                var aDataReturn = JSON.parse(oResult);
                if (aDataReturn['nStaEvent'] == '1') {
                    var tViewTableShowCollist = aDataReturn['tViewTableShowCollist'];
                    $('#odvTWOOrderAdvTblColumns .modal-body').html(tViewTableShowCollist);
                    $('#odvTWOOrderAdvTblColumns').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    $("#odvTWOOrderAdvTblColumns").modal({
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
    function JSxTWOSaveColumnShow() {
        // คอลัมน์ที่เลือกให้แสดง
        var aTWOColShowSet = [];
        $("#odvTWOOrderAdvTblColumns .xWTWOInputColStaShow:checked").each(function() {
            aTWOColShowSet.push($(this).data("id"));
        });

        // คอลัมน์ทั้งหมด
        var aTWOColShowAllList = [];
        $("#odvTWOOrderAdvTblColumns .xWTWOInputColStaShow").each(function() {
            aTWOColShowAllList.push($(this).data("id"));
        });

        // ชื่อคอลัมน์ทั้งหมดในกรณีมีการแก้ไขชื่อคอลัมน์ที่แสดง
        var aTWOColumnLabelName = [];
        $("#odvTWOOrderAdvTblColumns .xWTWOLabelColumnName").each(function() {
            aTWOColumnLabelName.push($(this).text());
        });

        // สถานะย้อนกลับค่าเริ่มต้น
        var nTWOStaSetDef;
        if ($("#odvTWOOrderAdvTblColumns #ocbTWOSetDefAdvTable").is(":checked")) {
            nTWOStaSetDef = 1;
        } else {
            nTWOStaSetDef = 0;
        }

        $.ajax({
            type: "POST",
            url: "TWOTransferAdvanceTableShowColSave",
            data: {
                'pnTWOStaSetDef': nTWOStaSetDef,
                'paTWOColShowSet': aTWOColShowSet,
                'paTWOColShowAllList': aTWOColShowAllList,
                'paTWOColumnLabelName': aTWOColumnLabelName
            },
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                $("#odvTWOOrderAdvTblColumns").modal("hide");
                $(".modal-backdrop").remove();
                JSvTRNLoadPdtDataTableHtml();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เลือกสินค้า Add Product Into Table Document DT Temp
    function JCNvTWOBrowsePdt() {
        var tWahCode_Input_Origin = $('#oetTROutWahFromCode').val();
        var tWahCode_Input_To = $('#oetTROutWahToCode').val();
        var tWahCode_Output_Spl = $('#oetTRINWahFromCode').val();
        var tWahCode_Output_Etc = $('#oetTRINWahEtcName').val();
        var tTypeDocument = $('#ocmSelectTransferDocument :selected').val();

        if (tTypeDocument == 0) {
            $('#odvWTIModalTypeIsEmpty').modal('show');
            $('#ospTypeIsEmpty').html('<?= language('document/transferwarehouseout/transferwarehouseout', 'tTypeDocumentISEmptyDetail') ?>');
            return;
        } else {
            if (tTypeDocument == 'IN') { //เอกสารรับโอน
                if (tWahCode_Input_Origin == '' || tWahCode_Input_To == '') {
                    $('#odvWTIModalWahIsEmpty').modal('show');
                    $('#ospWahIsEmpty').html('<?= language('document/transferwarehouseout/transferwarehouseout', 'tWahDocumentISEmptyDetail') ?>');
                    return;
                }
            } else if (tTypeDocument == 'OUT') { //เอกสารรับเข้า
                var tIN = $('#ocmSelectTransTypeIN :selected').val();
                if (tIN == 0) {
                    $('#odvWTIModalTypeIsEmpty').modal('show');
                    $('#ospTypeIsEmpty').html('<?= language('document/transferwarehouseout/transferwarehouseout', 'tINDocumentISEmptyDetail') ?>');
                    return;
                } else {
                    var tTypeDocumentIN = $('#ocmSelectTransTypeIN :selected').val();
                    if (tTypeDocumentIN == 'SPL') {
                        if ($('#oetTRINWahFromCode').val() == '') {
                            $('#odvWTIModalWahIsEmpty').modal('show');
                            $('#ospWahIsEmpty').html('<?= language('document/transferwarehouseout/transferwarehouseout', 'tWahINDocumentISEmptyDetail') ?>');
                            return;
                        }
                    } else if (tTypeDocumentIN == 'ETC') {
                        if ($('#oetTRINWahEtcCode').val() == '') {
                            $('#odvWTIModalWahIsEmpty').modal('show');
                            $('#ospWahIsEmpty').html('<?= language('document/transferwarehouseout/transferwarehouseout', 'tWahINDocumentISEmptyDetail') ?>');
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
                Qualitysearch: [],
                PriceType: ["Cost", "tCN_Cost", "Company", "1"],
                SelectTier: ["Barcode"],
                ShowCountRecord: 10,
                NextFunc: "FSvTWOAddPdtIntoDocDTTemp",
                ReturnType: "M",
                SPL: ['', ''],
                BCH: [$('#oetSOFrmBchCode').val(), $('#oetSOFrmBchCode').val()],
                MCH: ['', ''],
                // SHP: [$('#oetTROutShpFromCode').val(), $('#oetTROutShpFromName').val()]
                SHP: ['', ''],
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
    function FSvTWOAddPdtIntoDocDTTemp(ptPdtData) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JCNxOpenLoading();

            var ptXthDocNoSend = "";
            if ($("#ohdTWORoute").val() == "dcmTWOEventEdit") {
                ptXthDocNoSend = $("#oetTWODocNo").val();
            }

            $.ajax({
                type: "POST",
                url: "TWOTransferwarehouseoutAddPdtIntoDTDocTemp",
                data: {
                    'tBchCode': $('#oetSOFrmBchCode').val(),
                    'tTWODocNo': ptXthDocNoSend,
                    'tTWOPdtData': ptPdtData,
                    'tType': 'PDT'
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    JSvTRNLoadPdtDataTableHtml();

                    var aData = JSON.parse(ptPdtData);
                    console.log(aData);
                    var oOptionForFashion = {
                        'bListItemAll': false,
                        'tSpcControl': 0,
                        'tNextFunc': 'FSvTWOPDTAddPdtIntoTableDT'
                    }
                    JSxCheckProductSerialandFashion(aData, oOptionForFashion, 'insert');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }


    // Create By: Nattakit(Nale) 21/05/2021
    function FSvTWOPDTAddPdtIntoTableDT_PDTSerialorFashion(ptPdtDataFhn) {

        console.log(ptPdtDataFhn);
        var aData = JSON.parse(ptPdtDataFhn);
        var ptXthDocNoSend = "";
        if ($("#ohdTWORoute").val() == "dcmTWOEventEdit") {
            ptXthDocNoSend = $("#oetTWODocNo").val();
        }

        $.ajax({
            type: "POST",
            url: "TWOTransferwarehouseoutEventAddPdtIntoDTFhnTemp",
            data: {
                'tTWODocNo': ptXthDocNoSend,
                'tTWOPdtDataFhn': ptPdtDataFhn,
                'tTWOBCH': $('#oetSOFrmBchCode').val(),
                'tTWOType': 'PDT'
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                if (aData['nStaLastSeq'] == '1') { //ถ้าเป็นสินค้าแฟชั่นตัวสุดท้ายให้โหลด Table 
                    JSvTRNLoadPdtDataTableHtml();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }

    //กดโมเดลลบสินค้าใน Tmp
    function JSnTWODelPdtInDTTempSingle(poEl) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tVal = $(poEl).parents("tr.xWPdtItem").attr("data-pdtcode");
            var tSeqno = $(poEl).parents("tr.xWPdtItem").attr("data-seqno");
            $(poEl).parents("tr.xWPdtItem").remove();
            JSnTWORemovePdtDTTempSingle(tSeqno, tVal);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ลบสินค้าใน Tmp - ตัวเดียว
    function JSnTWORemovePdtDTTempSingle(ptSeqNo, ptPdtCode) {
        var tTWODocNo = $("#oetTWODocNo").val();
        var tTWOBchCode = $('#oetSOFrmBchCode').val();
        var tTWOVatInOrEx = 1;
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "TWOTransferwarehouseoutRemovePdtInDTTmp",
            data: {
                'tBchCode': tTWOBchCode,
                'tDocNo': tTWODocNo,
                'nSeqNo': ptSeqNo,
                'tPdtCode': ptPdtCode,
                'tVatInOrEx': tTWOVatInOrEx,
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSvTRNLoadPdtDataTableHtml();
                    JCNxLayoutControll();
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
    function JSxTWOTextInModalDelPdtDtTemp() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("TWO_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {} else {
            var tTWOTextDocNo = "";
            var tTWOTextSeqNo = "";
            var tTWOTextPdtCode = "";
            var tTWOTextPunCode = "";
            $.each(aArrayConvert[0], function(nKey, aValue) {
                tTWOTextDocNo += aValue.tDocNo;
                tTWOTextDocNo += " , ";

                tTWOTextSeqNo += aValue.tSeqNo;
                tTWOTextSeqNo += " , ";

                tTWOTextPdtCode += aValue.tPdtCode;
                tTWOTextPdtCode += " , ";

                tTWOTextPunCode += aValue.tPunCode;
                tTWOTextPunCode += " , ";
            });
            $('#odvTWOModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvTWOModalDelPdtInDTTempMultiple #ohdConfirmTWODocNoDelete').val(tTWOTextDocNo);
            $('#odvTWOModalDelPdtInDTTempMultiple #ohdConfirmTWOSeqNoDelete').val(tTWOTextSeqNo);
            $('#odvTWOModalDelPdtInDTTempMultiple #ohdConfirmTWOPdtCodeDelete').val(tTWOTextPdtCode);
            $('#odvTWOModalDelPdtInDTTempMultiple #ohdConfirmTWOPunCodeDelete').val(tTWOTextPunCode);
        }
    }

    //ค้นหา KEY
    function JStTWOFindObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }

    //แสดงให้ปุ่ม Delete กดได้
    function JSxTWOShowButtonDelMutiDtTemp() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("TWO_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#odvTWOMngDelPdtInTableDT #oliTWOBtnDeleteMulti").addClass("disabled");
        } else {
            var nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#odvTWOMngDelPdtInTableDT #oliTWOBtnDeleteMulti").removeClass("disabled");
            } else {
                $("#odvTWOMngDelPdtInTableDT #oliTWOBtnDeleteMulti").addClass("disabled");
            }
        }
    }

    // Confirm Delete Modal Multiple
    $('#odvTWOModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JSxTWODelDocMultiple();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //ลบสินค้าใน Tmp - หลายตัว
    function JSxTWODelDocMultiple() {
        JCNxOpenLoading();
        var tTWODocNo = $("#oetTWODocNo").val();
        var tTWOBchCode = $('#oetSOFrmBchCode').val();
        var tTWOVatInOrEx = 1;
        var aDataPdtCode = JSoTWORemoveCommaData($('#odvTWOModalDelPdtInDTTempMultiple #ohdConfirmTWOPdtCodeDelete').val());
        var aDataPunCode = JSoTWORemoveCommaData($('#odvTWOModalDelPdtInDTTempMultiple #ohdConfirmTWOPunCodeDelete').val());
        var aDataSeqNo = JSoTWORemoveCommaData($('#odvTWOModalDelPdtInDTTempMultiple #ohdConfirmTWOSeqNoDelete').val());
        $.ajax({
            type: "POST",
            url: "TWOTransferwarehouseoutRemovePdtInDTTmpMulti",
            data: {
                'ptTWOBchCode': tTWOBchCode,
                'ptTWODocNo': tTWODocNo,
                'ptTWOVatInOrEx': tTWOVatInOrEx,
                'paDataPdtCode': aDataPdtCode,
                'paDataPunCode': aDataPunCode,
                'paDataSeqNo': aDataSeqNo,
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    $('#odvTWOModalDelPdtInDTTempMultiple').modal('hide');
                    $('#odvTWOModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
                    localStorage.removeItem('TWO_LocalItemDataDelDtTemp');
                    $('#odvTWOModalDelPdtInDTTempMultiple #ohdConfirmTWODocNoDelete').val('');
                    $('#odvTWOModalDelPdtInDTTempMultiple #ohdConfirmTWOSeqNoDelete').val('');
                    $('#odvTWOModalDelPdtInDTTempMultiple #ohdConfirmTWOPdtCodeDelete').val('');
                    $('#odvTWOModalDelPdtInDTTempMultiple #ohdConfirmTWOPunCodeDelete').val('');
                    setTimeout(function() {
                        $('.modal-backdrop').remove();
                        JSvTRNLoadPdtDataTableHtml();
                        $("#odvTWOMngDelPdtInTableDT #oliTWOBtnDeleteMulti").addClass("disabled");
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
    function JSoTWORemoveCommaData(paData) {
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
    $('#obtTWOSubmitFromDoc').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {

            // $('#obtTWOSubmitFromDoc').focus();

            //ถ้าค่าไม่สมบูรณ์ไม่อนุญาติให้บันทึก
            var tWahCode_Input_Origin = $('#oetTROutWahFromCode').val();
            var tWahCode_Input_To = $('#oetTROutWahToCode').val();
            var tWahCode_Output_Spl = $('#oetTRINSplFromCode').val();
            var tWahCode_Output_Etc = $('#oetTRINWahEtcName').val();
            var tTypeDocument = $('#ocmSelectTransferDocument').val();

            if (tTypeDocument == 0) {
                $('#odvWTIModalTypeIsEmpty').modal('show');
                $('#ospTypeIsEmpty').html('<?= language('document/transferwarehouseout/transferwarehouseout', 'tTypeDocumentISEmptyDetail') ?>');
                return;
            } else {
                if (tTypeDocument == 4) { //เอกสารรับโอน
                    if (tWahCode_Input_To == '' || tWahCode_Input_Origin == '') {
                        $('#odvWTIModalWahIsEmpty').modal('show');
                        $('#ospWahIsEmpty').html('<?= language('document/transferwarehouseout/transferwarehouseout', 'tWahDocumentISEmptyDetail') ?>');
                        return;
                    }
                } else if (tTypeDocument == 2) { //เอกสารรับเข้า
                    var tIN = $('#ocmSelectTransTypeIN :selected').val();
                    if (tIN == '') {
                        $('#odvWTIModalTypeIsEmpty').modal('show');
                        $('#ospTypeIsEmpty').html('<?= language('document/transferwarehouseout/transferwarehouseout', 'tINDocumentISEmptyDetail') ?>');
                        return;
                    } else {

                        if (tWahCode_Input_Origin == '') {
                            $('#odvWTIModalWahIsEmpty').modal('show');
                            $('#ospWahIsEmpty').html('<?= language('document/transferwarehouseout/transferwarehouseout', 'tWahDocumentISEmptyDetail') ?>');
                            return;
                        }

                        var tTypeDocumentIN = $('#ocmSelectTransTypeIN :selected').val();
                        if (tTypeDocumentIN == 'SPL') {
                            if (tWahCode_Output_Spl == '') {
                                $('#odvWTIModalWahIsEmpty').modal('show');
                                $('#ospWahIsEmpty').html('<?= language('document/transferwarehouseout/transferwarehouseout', 'tWahINDocumentISEmptyDetailSpl') ?>');
                                return;
                            }
                        } else if (tTypeDocumentIN == 'ETC') {
                            if ($('#oetTWOINEtc').val() == '') {
                                $('#odvWTIModalWahIsEmpty').modal('show');
                                $('#ospWahIsEmpty').html('<?= language('document/transferwarehouseout/transferwarehouseout', 'tWahINDocumentISEmptyDetailReson') ?>');
                                return;
                            }
                        }
                    }
                }
            }

            $('#obtSubmitTransferwarehouseout').click();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //อีเวนท์บันทึก - แก้ไข
    function JSxTransferwarehouseoutEventAddEdit(ptRoute) {
        $('#ofmTransferwarehouseoutFormAdd').validate({
            rules: {
                oetTWODocNo: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "dcmTWOEventAdd") {
                                if ($('#ocbTWOStaAutoGenCode').is(':checked')) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return true;
                            }
                        }
                    },
                },
                oetTWODocDate: {
                    "required": true
                },
                oetTWODocTime: {
                    "required": true
                }
            },
            messages: {
                oetTWODocNo: {
                    "required": $('#oetTWODocNo').attr('data-validate-required'),
                },
                oetTWODocDate: {
                    "required": $('#oetTWODocDate').attr('data-validate-required'),
                },
                oetTWODocTime: {
                    "required": $('#oetTWODocTime').attr('data-validate-required'),
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
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            },
            submitHandler: function(form) {
                var tItem = $('#odvTWODataPdtTableDTTemp #otbTWODocPdtAdvTableList .xWPdtItem').length;
                if (tItem > 0) {
                    $.ajax({
                        type: "POST",
                        url: ptRoute,
                        data: $('#ofmTransferwarehouseoutFormAdd').serialize(),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            // console.log(tResult);
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaReturn'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvTWOCallPageEdit(aReturn['tCodeReturn']);
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvTWOTransferwarehouseoutAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvTWOCallPageTransferwarehouseout(1);
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                            // JCNxCloseLoading();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                } else {
                    $('#odvWTIModalPleaseSelectPDT').modal('show');
                }
            }
        });
    }

    //บันทึก EDIT IN LINE - STEP 1
    function JSxTWOSaveEditInline(paParams) {
        var oThisEl = paParams['Element'];
        var nSeqNo = paParams.DataAttribute[1]['data-seq'];
        var tFieldName = paParams.DataAttribute[0]['data-field'];
        var tValue = accounting.unformat(paParams.VeluesInline);
        FSvTWOEditPdtIntoTableDT(nSeqNo, tFieldName, tValue);
    }

    //บันทึก EDIT IN LINE - STEP 2 
    function FSvTWOEditPdtIntoTableDT(pnSeqNo, ptFieldName, ptValue) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tTWODocNo = $("#oetTWODocNo").val();
            var tTWOBchCode = $('#oetSOFrmBchCode').val(); //$("#ohdTWOBchCode").val();
            var tTWOVATInOrEx = $('#ohdTWOFrmSplInfoVatInOrEx').val();
            var tPageCurrent = $('#ohdTWOPageCurrent').val();
            $.ajax({
                type: "POST",
                url: "TWOTransferwarehouseoutEventEditInline",
                data: {
                    'tTWOBchCode': tTWOBchCode,
                    'tTWODocNo': tTWODocNo,
                    'tTWOVATInOrEx': tTWOVATInOrEx,
                    'nTWOSeqNo': pnSeqNo,
                    'tTWOFieldName': ptFieldName,
                    'tTWOValue': ptValue
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    JSvTRNLoadPdtDataTableHtml(tPageCurrent);
                    // console.log(oResult);
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
    function JSvTWODOCFilterPdtInTableTemp() {
        JCNxOpenLoading();
        JSvTRNLoadPdtDataTableHtml();
    }

    //Next page ในตารางสินค้า Tmp
    function JSvTWOPDTDocDTTempClickPage(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld = $(".xWPageTWOPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld = $(".xWPageTWOPdt .active").text(); // Get เลขก่อนหน้า
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

    //RABBIT MQ
    $(document).ready(function() {

        // //RabbitMQ
        // var tLangCode   = nLangEdits;
        // var tUsrBchCode = $("#ohdTWOBchCode").val();
        // var tUsrApv     = $("#ohdTWOApvCodeUsrLogin").val();
        // var tDocNo      = $("#oetTWODocNo").val();
        // var tPrefix     = 'RESAJS';
        // var tStaApv     = $("#ohdTWOStaApv").val();
        // var tStaDelMQ   = $("#ohdTWOStaDelMQ").val();
        // var tQName      = tPrefix + "_" + tDocNo + "_" + tUsrApv;
        // var tStaPrcStk  = $("#ohdTWOStaPrcStk").val();

        // // MQ Message Config
        // var poDocConfig = {
        //     tLangCode: tLangCode,
        //     tUsrBchCode: tUsrBchCode,
        //     tUsrApv: tUsrApv,
        //     tDocNo: tDocNo,
        //     tPrefix: tPrefix,
        //     tStaDelMQ: tStaDelMQ,
        //     tStaApv: tStaApv,
        //     tQName: tQName
        // };

        // // RabbitMQ STOMP Config
        // var poMqConfig = {
        //     host        : "ws://" + oSTOMMQConfig.host + ":15674/ws",
        //     username    : oSTOMMQConfig.user,
        //     password    : oSTOMMQConfig.password,
        //     vHost       : oSTOMMQConfig.vhost
        // };

        // // Update Status For Delete Qname Parameter
        // var poUpdateStaDelQnameParams = {
        //     ptDocTableName: "TCNTPdtAdjStkHD",
        //     ptDocFieldDocNo: "FTAjhDocNo",
        //     ptDocFieldStaApv: "FTAjhStaPrcStk",
        //     ptDocFieldStaDelMQ: "FTAjhStaDelMQ",
        //     ptDocStaDelMQ: "1",
        //     ptDocNo: tDocNo
        // };

        // // Callback Page Control(function)
        // var poCallback = {
        //     tCallPageEdit: 'JSvTWOCallPageEdit',
        //     tCallPageList: 'JSvTWOCallPageList'
        // };

        // //Check Show Progress %
        // if (tDocNo != '' && (tStaApv == 2 || tStaPrcStk == 2)) { // 2 = Processing
        //     FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);	
        // }

        // //Check Delete MQ SubScrib
        // if (tStaApv == 1 && tStaPrcStk == 1 && tStaDelMQ == '') { // Qname removed ?
        //     // console.log('DelMQ:');
        //     // Delete Queue Name Parameter
        //     var poDelQnameParams = {
        // 		ptPrefixQueueName: tPrefix,
        // 		ptBchCode: tUsrBchCode,
        // 		ptDocNo: tDocNo,
        // 		ptUsrCode: tUsrApv
        // 	};    
        //     FSxCMNRabbitMQDeleteQname(poDelQnameParams);
        //     FSxCMNRabbitMQUpdateStaDeleteQname(poUpdateStaDelQnameParams);
        // }

    });


    tSQLWhere = "";
    tUsrLevel = "<?= $this->session->userdata('tSesUsrLevel') ?>";
    tBchMulti = "<?= $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    if (tUsrLevel != "HQ") {
        tSQLWhere = " AND TCNMBranch.FTBchCode IN (" + tBchMulti + ") ";
    }

    $('#obtBrowseTWOBCH').click(function() {
        JCNxBrowseData('oBrowse_BCH');
    });

    var oBrowse_BCH = {
        Title: ['company/branch/branch', 'tBCHTitle'],
        Table: {
            Master: 'TCNMBranch',
            PK: 'FTBchCode',
            PKName: 'FTBchName'
        },
        Join: {
            Table: ['TCNMBranch_L', 'TCNMWaHouse_L'],
            On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID =' + nLangEdits,
                'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID =' + nLangEdits,
            ]
        },
        Where: {
            Condition: [tSQLWhere]
        },
        GrideView: {
            ColumnPathLang: 'company/branch/branch',
            ColumnKeyLang: ['tBCHCode', 'tBCHName', ''],
            ColumnsSize: ['15%', '75%', ''],
            WidthModal: 50,
            DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName', 'TCNMWaHouse_L.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            DisabledColumns: [2, 3],
            Perpage: 10,
            OrderBy: ['TCNMBranch.FDCreateOn DESC'],
            // SourceOrder  : "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetSOFrmBchCode", "TCNMBranch.FTBchCode"],
            Text: ["oetSOFrmBchName", "TCNMBranch_L.FTBchName"],
        },
        NextFunc: {
            FuncName: 'JSxSetDefauleWahouse',
            ArgReturn: ['FTWahCode', 'FTWahName']
        },
        // DebugSQL : true
    }

    function JSxSetDefauleWahouse(ptData) {
        if (ptData == '' || ptData == 'NULL') {
            $('#oetTROutWahFromCode').val('');
            $('#oetTROutWahFromName').val('');
            $('#oetTROutWahToCode').val('');
            $('#oetTROutWahToName').val('');
        } else {
            //ร้านค้าต้นทาง ร้านค้าปลายทางต้องเคลียร์ค่า
            $('#oetTROutShpFromName').val('');
            $('#oetTROutShpFromCode').val('');

            $('#oetTROutShpToName').val('');
            $('#oetTROutShpToCode').val('');

            var tResult = JSON.parse(ptData);
            $('#oetTROutWahFromCode').val(tResult[0]);
            $('#oetTROutWahFromName').val(tResult[1]);
        }
    }

    //ฟังก์ชั่นพิมพ์
    function JSxTWOTransferwarehouseoutPrint() {
        var aInfor = [{
                "Lang": '<?= FCNaHGetLangEdit(); ?>'
            }, // Lang ID
            {
                "ComCode": '<?= FCNtGetCompanyCode(); ?>'
            }, // Company Code
            {
                "BranchCode": '<?= FCNtGetAddressBranch($tTWOBchCode); ?>'
            }, // สาขาที่ออกเอกสาร
            {
                "DocCode": $('#oetTWODocNo').val()
            }, // เลขที่เอกสาร
            {
                "DocBchCode": '<?= $tTWOBchCode; ?>'
            }
        ];

        if (tTWODocType == 4) { //ใบจ่ายโอน
            window.open("<?= base_url(); ?>formreport/Frm_SQL_ALLMPdtBillTnfOutWah?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
        } else { //ใบเบิกออก
            window.open("<?= base_url(); ?>formreport/Frm_SQL_ALLMPdtBillTnfOut?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
        }
    }


    $(document).ready(function() {

        //อ้างอิงเอกสาร
        JSxTWOCallPageHDDocRef();
        JSxTWOEventCheckShowHDDocRef();
    });

    //โหลด Table อ้างอิงเอกสารทั้งหมด
    function JSxTWOCallPageHDDocRef() {
        $.ajax({
            type: "POST",
            url: "docTWOPageHDDocRefN",
            data: {
                'ptDocNo': $('#oetTWODocNo').val(),
                'ptStaApv': $('#ohdTWOStaApv').val(),
                'ptStaPrcDoc': $('#ohdTWOStaPrcStk').val()
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aResult = JSON.parse(oResult);
                if (aResult['nStaEvent'] == 1) {
                    $('#odvTWOTableHDRef').html(aResult['tViewPageHDRef']);
                    JCNxCloseLoading();
                } else {
                    var tMessageError = aResult['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
    //กดเพิ่มเอกสารอ้างอิง (ภายใน ภายนอก)
    $('#obtTWOAddDocRef').off('click').on('click', function() {
        $('#ofmTWOFormAddDocRef').validate().destroy();
        JSxTWOEventClearValueInFormHDDocRef();
        $('#odvTWOModalAddDocRef').modal('show');
    });

    //เคลียร์ค่า
    function JSxTWOEventClearValueInFormHDDocRef() {
        $('#oetTWORefDocNo').val('');
        $('#oetTWORefDocDate').val('');
        $('#oetTWODocRefInt').val('');
        $('#oetTWODocRefIntName').val('');
        $('#oetTWORefKey').val('');
    }


    //Default โชว์ panel ตามประเภท (ภายใน หรือ ภายนอก)
    function JSxTWOEventCheckShowHDDocRef() {
        var tTWORefType = $('#ocbTWORefType').val();
        $('.xWShowRefInt').hide();
        $('.xWShowRefExt').show();
        // if (tTWORefType == '1') {
        //     $('.xWShowRefExt').hide();
        //     $('.xWShowRefInt').show();
        // } else {
        //     $('.xWShowRefInt').hide();
        //     $('.xWShowRefExt').show();
        // }
    }

    //เมื่อเปลี่ยน ประเภท (ภายใน หรือ ภายนอก)
    $('#ocbTWORefType').off('change').on('change', function() {
        $(this).selectpicker('refresh');
        JSxTWOEventCheckShowHDDocRef();
    });

    //กดเลือกอ้างอิงเอกสารภายใน (ใบขอโอน - สาขา)
    $('#obtTWOBrowseRefDoc').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCallPageTransferBchOutRefIntDoc();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //กดยืนยันบันทึกลง Temp
    $('#ofmTWOFormAddDocRef').off('click').on('click', function() {
        $('#ofmTWOFormAddDocRef').validate().destroy();
        $('#ofmTWOFormAddDocRef').validate({
            focusInvalid: false,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetTWORefDocNo: {
                    "required": {
                        depends: function(oElement) {
                            if ($('#ocbTWORefType').val() == '3') {
                                return true;
                            } else {
                                return false;

                            }
                        }
                    },
                },
                oetTWODocRefIntName: {
                    "required": {
                        depends: function(oElement) {
                            if ($('#ocbTWORefType').val() == '1') {
                                return true;
                            } else {
                                return false;

                            }
                        }
                    },
                },
                oetTWORefDocDate: {
                    "required": true
                },
            },
            messages: {
                oetTWORefDocNo: {
                    "required": 'กรุณากรอกเลขที่เอกสารอ้างอิง'
                },
                oetTWORefDocDate: {
                    "required": 'กรุณากรอกวันที่เอกสารอ้างอิง'
                },
                oetTWODocRefIntName: {
                    "required": 'กรุณาเลือกเลขที่เอกสารอ้างอิง'
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
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass("has-error");
            },
            submitHandler: function(form) {
                JCNxOpenLoading();

                if ($('#ocbTWORefType').val() == 1) { //อ้างอิงเอกสารภายใน
                    // var tDocNoRef = $('#oetTWODocRefInt').val();
                    var tDocNoRef = $('#oetTWORefDocNo').val();
                    var tDocRefKey = 'TWO';
                } else { //อ้างอิงเอกสารภายนอก
                    var tDocNoRef = $('#oetTWORefDocNo').val();
                    var tDocRefKey = $('#oetTWORefKey').val();
                }

                $.ajax({
                    type: "POST",
                    url: "docTWOEventAddEditHDDocRefN",
                    data: {
                        'ptRefDocNoOld': $('#oetTWORefDocNoOld').val(),
                        'ptDocNo': $('#oetTWODocNo').val(),
                        'ptRefType': $('#ocbTWORefType').val(),
                        'ptRefDocNo': tDocNoRef,
                        'pdRefDocDate': $('#oetTWORefDocDate').val(),
                        'ptRefKey': tDocRefKey
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {

                        JSxTWOEventClearValueInFormHDDocRef();
                        $('#odvTWOModalAddDocRef').modal('hide');

                        JSxTWOCallPageHDDocRef();

                        // if ($('#ocbTWORefType').val() == 1) { //อ้างอิงเอกสารภายใน

                        //     var tRefIntDocNo = $('.xDocuemntRefInt.active').data('docno');
                        //     var tRefIntDocDate = $('.xDocuemntRefInt.active').data('docdate');
                        //     var tRefIntBchCode = $('.xDocuemntRefInt.active').data('bchcode');
                        //     var aSeqNo = $('.ocbRefIntDocDT:checked').map(function(elm) {
                        //         return $(this).val();
                        //     }).get();

                        //     var tSplStaVATInOrEx = $('.xDocuemntRefInt.active').data('vatinroex');
                        //     var cSplCrLimit = $('.xDocuemntRefInt.active').data('crtrem');
                        //     var nSplCrTerm = $('.xDocuemntRefInt.active').data('crlimit');
                        //     var tSplCode = $('.xDocuemntRefInt.active').data('splcode');
                        //     var tSplName = $('.xDocuemntRefInt.active').data('splname');
                        //     var tSPlPaidType = $('.xDocuemntRefInt.active').data('dstpain');
                        //     var tVatcode = $('.xDocuemntRefInt.active').data('vatcode');
                        //     var nVatrate = $('.xDocuemntRefInt.active').data('vatrate');

                        //     var tBchFrm = $('.xDocuemntRefInt.active').data('bchfrm');
                        //     var tBchNameFrm = $('.xDocuemntRefInt.active').data('bchnamefrm');

                        //     var tWahFrm = $('.xDocuemntRefInt.active').data('wahfrm');
                        //     var tWahNameFrm = $('.xDocuemntRefInt.active').data('wahnamefrm');

                        //     var tBchTo = $('.xDocuemntRefInt.active').data('bchto');
                        //     var tBchNameTo = $('.xDocuemntRefInt.active').data('bchnameto');

                        //     var tWahTo = $('.xDocuemntRefInt.active').data('wahto');
                        //     var tWahNameTo = $('.xDocuemntRefInt.active').data('wahnameto');


                        //     $('#obtTransferBchOutBrowseBchFrom').attr('disabled', false);
                        //     $('#obtTransferBchOutBrowseWahFrom').attr('disabled', false);
                        //     $('#oetTransferBchOutXthBchFrmCode').val(tBchFrm);
                        //     $('#oetTransferBchOutXthBchFrmName').val(tBchNameFrm);
                        //     $('#oetTransferBchOutXthWhFrmCode').val(tWahFrm);
                        //     $('#oetTransferBchOutXthWhFrmName').val(tWahNameFrm);

                        //     $('#obtTransferBchOutBrowseBchTo').attr('disabled', false);
                        //     $('#obtTransferBchOutBrowseWahTo').attr('disabled', false);
                        //     $('#oetTransferBchOutXthBchToCode').val(tBchTo);
                        //     $('#oetTransferBchOutXthBchToName').val(tBchNameTo);
                        //     $('#oetTransferBchOutXthWhToCode').val(tWahTo);
                        //     $('#oetTransferBchOutXthWhToName').val(tWahNameTo);

                        //     JCNxOpenLoading();

                        // }
     
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    });


    $(document).on('show.bs.modal', '.modal', function() {
        const zIndex = 1040 + 10 * $('.modal:visible').length;
        $(this).css('z-index', zIndex);
        setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
    });


    var tStaPrcDoc = $('#ohdTWOStaPrcStk').val();
    if (tStaPrcDoc != "") { // ต้องตรวจสอบสถานะใบจัด
        if (!bIsApvOrCancel) {
            $('#obtTWOGenPacking').show();
            if (tStaPrcDoc == '1') {
                $('form .xCNApvOrCanCelDisabled').attr('disabled', false); // ยังไม่กดสร้างใบจัดสินค้า สามารถแก้ไข input/product ได้อยู่
                $('.xCNHideWhenCancelOrApprove').show();

            } else {
                $('form .xCNApvOrCanCelDisabled').attr('disabled', true); // สร้างใบจัดสินค้าแล้ว ไม่สามารถแก้ไข input/product ได้
                $('.xCNHideWhenCancelOrApprove').hide();
            }
        } else {
            $('#obtTWOGenPacking').hide();
            $('.xCNHideWhenCancelOrApprove').hide();
        }
    } else {
        if (bIsApvOrCancel) {
            $('.xCNHideWhenCancelOrApprove').hide();
        } else {
            $('.xCNHideWhenCancelOrApprove').show();
        }
        $('#obtTWOGenPacking').hide();
    }
</script>