<script type="text/javascript">
    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit"); ?>';
    var tUsrApv = '<?php echo $this->session->userdata("tSesUsername"); ?>';
    var tSesUsrLevel = '<?php echo $this->session->userdata('tSesUsrLevel'); ?>';
    var tUserBchCode = '<?php echo $this->session->userdata("tSesUsrBchCodeDefault"); ?>';
    var tUserBchName = '<?php echo $this->session->userdata("tSesUsrBchNameDefault"); ?>';
    var tUserWahCode = '<?php echo $this->session->userdata("tSesUsrWahCode"); ?>';
    var tUserWahName = '<?php echo $this->session->userdata("tSesUsrWahName"); ?>';
    var tUserBchCodeto = '<?php echo $this->session->userdata("tSesUsrBchCodeDefault"); ?>';
    var tUserBchNameto = '<?php echo $this->session->userdata("tSesUsrBchNameDefault"); ?>';
    var tUserWahCodeto = '<?php echo $this->session->userdata("tSesUsrWahCode"); ?>';
    var tUserWahNameto = '<?php echo $this->session->userdata("tSesUsrWahName"); ?>';
    var tTBIDocType = $('#ohdTBIDocType').val();
    var tTBIRsnType = $('#ocmSelectTransTypeIN').val();
    var tTBIStaDoc = '<?= $tTBIStaDoc; ?>';
    var tTBIStaApvDoc = '<?= $tTBIStaApv; ?>';
    var tTBIStaPrcStkDoc = '<?= $tTBIStaPrcStk; ?>';
    var tTBIRoute = '<?= $tTBIRoute; ?>';
    var tRoute = $('#ohdTBIRoute').val();
    var bIsApvOrCancel  = '<?= $bIsApvOrCancel; ?>';

    var tStaDoc = '<?php echo $tTBIStaDoc; ?>';
    var tStaApv = '<?php echo $tTBIStaApv; ?>';
    var tRoute = '<?php echo $tTBIRoute; ?>';
    var tStaPrcStk = '<?php echo $tTBIStaPrcStk; ?>';
    var bIsAddPage = <?php echo ($bIsAddPage) ? 'true' : 'false'; ?>;
    $(document).ready(function() {
        JSxTBIEventCheckShowHDDocRef();
        JSxTBICallPageHDDocRef();
        // if(tUserBchCode != ''){
        //     $('#oetTBIBchCode').val(tUserBchCode);
        //     $('#oetTBIFrmBchName').val(tUserBchName);
        //     $('#obtBrowseTWOBCH').attr("disabled",true);
        // }
        if (tUserWahCode != '' && tRoute == 'docTBIEventAdd') {
            $('#oetTBIWahCodeTo').val(tUserWahCode);
            $('#oetTBIWahNameTo').val(tUserWahName);
        }


        // if(tUserBchCodeto != ''){
        //     $('#oetTBIBchCodeTo').val(tUserBchCodeto);
        //     $('#oetTBIBchNameTo').val(tUserBchNameto);
        //     $('#obtBrowseTWOBCHTo').attr("disabled",true);
        // }
        if (tUserWahCodeto != '' && tRoute == 'docTBIEventAdd') {
            $('#oetTBIWahCodeTo').val(tUserWahCodeto);
            $('#oetTBIWahNameTo').val(tUserWahNameto);
        }

        // อนุมัติแล้วเข้ามาใหม่อีกรอบให้ขึ้น Progress
        if ($('#ohdTBIStaApv').val() == '1' && $('#ohdTBIStaPrcStk').val() == '2') {
            JSoTBISubscribeMQ();
        }

        $("form input").keypress(function(e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                $('button[type=submit] .default').click();
                return false;
            } else {
                return true;
            }
        });


        $('#ohdTBIFrmDocType').val(tTBIDocType);
        $('#obtTBIConfirmApprDoc').click(function() {
            JSxTBITransferReceiptStaApvDoc(true);
        });

        //เอกสารถูกยกเลิก
        if (tTBIStaDoc == 3 || tTBIStaApvDoc == 1) {

            $('#obtTBIPrintDoc').show();
            if (tTBIStaDoc == 3) {
                $('#obtTBICancelDoc').hide();
            }
            $('#obtTBIApproveDoc').hide();
            $('#obtTBICancelDoc').hide();
            // $('#odvTBIBtnGrpSave').hide();

            //วันที่ + เวลา
            $('#oetTBIDocDate').attr('disabled',true);
            $('#oetTBIDocTime').attr('disabled',true);
            $('.xWDropdown').attr('disabled', true);

            // อ้างอิงภายนอก
            $('#oetTBIRefExtDoc').attr('disabled',true);
            $('#oetTBIRefExtDocDate').attr('disabled',true);

            //ประเภท
            $('#ocmSelectTransferDocument').attr('disabled', true);
            $('#ocmSelectTransTypeIN').attr('disabled', true);
            $('#oetTBIINEtc').attr('disabled', true);
            $('.xCNApvOrCanCelDisabled').attr('disabled', true);
            $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        } else {

            if (tTBIStaDoc == 1 && tTBIRoute == 'docTBIEventEdit') {

                $('#odvTBIBtnGrpSave').show();
                $('#obtTBIPrintDoc').show();
                $('#obtTBICancelDoc').show();
                $('#obtTBIApproveDoc').show();
            } else {

                $('#odvTBIBtnGrpSave').show();
                $('#obtTBIPrintDoc').hide();
                $('#obtTBICancelDoc').hide();
                $('#obtTBIApproveDoc').hide();
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
        $('#obtTBIDocDate').unbind().click(function() {
            $('#oetTBIDocDate').datepicker('show');
        });

        $('#obtTBIDocTime').unbind().click(function() {
            $('#oetTBIDocTime').datetimepicker('show');
        });

        $('#obtTBIBrowseRefIntDocDate').unbind().click(function() {
            $('#oetTBIRefIntDocDate').datepicker('show');
        });

        $('#obtTBIBrowseRefExtDocDate').unbind().click(function() {
            $('#oetTBIRefExtDocDate').datepicker('show');
        });

        $('#obtTBITnfDate').unbind().click(function() {
            $('#oetTBITransportTnfDate').datepicker('show');
        });

        // ================================== Set Date Default =================================
        var dCurrentDate = new Date();
        var tAmOrPm = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
        var tCurrentTime = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

        if ($('#oetTBIDocDate').val() == '') {
            $('#oetTBIDocDate').datepicker("setDate", dCurrentDate);
        }

        if ($('#oetTBIDocTime').val() == '') {
            $('#oetTBIDocTime').val(tCurrentTime);
        }

        // =============================== Check Box Auto GenCode ==============================
        $('#ocbTBIStaAutoGenCode').on('change', function(e) {
            if ($('#ocbTBIStaAutoGenCode').is(':checked')) {
                $("#oetTBIDocNo").val('');
                $("#oetTBIDocNo").attr("readonly", true);
                $('#oetTBIDocNo').closest(".form-group").css("cursor", "not-allowed");
                $('#oetTBIDocNo').css("pointer-events", "none");
                $("#oetTBIDocNo").attr("onfocus", "this.blur()");
                $('#ofmTBIFormAdd').removeClass('has-error');
                $('#ofmTBIFormAdd .form-group').closest('.form-group').removeClass("has-error");
                $('#ofmTBIFormAdd em').remove();
            } else {
                $('#oetTBIDocNo').closest(".form-group").css("cursor", "");
                $('#oetTBIDocNo').css("pointer-events", "");
                $('#oetTBIDocNo').attr('readonly', false);
                $("#oetTBIDocNo").removeAttr("onfocus");
            }
        });

        // ============================== เลือกประเภทเอกสาร =====================================
        //แบบ EDIT
        if (tTBIDocType != '') {
            if (tTBIDocType == 5) { //IN
                $("#ocmSelectTransferDocument option[value=IN]").attr('selected', 'selected');
                $('#odvTBI_5').css('display', 'block');
                $('#odvTBI_1').css('display', 'none');
            } else { //OUT
                $("#ocmSelectTransferDocument option[value=OUT]").attr('selected', 'selected');
                $('#odvTBI_5').css('display', 'none');
                $('#odvTBI_1').css('display', 'block');
                $('#odvINWhereSPL').css('display', 'block');

                // if(tTBIRsnType == 3){//ผู้จำหน่าย
                //     $("#ocmSelectTransTypeIN option[value=SPL]").attr('selected','selected');
                //     $('#odvINWhereSPL').css('display','block');
                //     $('#odvINWhereETC').css('display','none');
                // }else{// แหล่งอื่น
                //     $("#ocmSelectTransTypeIN option[value=ETC]").attr('selected','selected');
                //     $('#odvINWhereSPL').css('display','none');
                //     $('#odvINWhereETC').css('display','block');
                // }
            }
            $('.selectpicker').selectpicker('refresh');
        }

        //แบบ INS
        // $('#ocmSelectTransferDocument').change(function() {
        //     var nValue = $(this).val();
        //     if(nValue == 'OUT'){
        //         $('#odvTRNOut').css('display','none');
        //         $('#odvTRNIn').css('display','block');
        //     }else if(nValue == 'IN'){
        //         $('#odvTRNOut').css('display','block');
        //         $('#odvTRNIn').css('display','none');
        //     }

        //     //เคลียร์ค่า กลับมาแบบตั้งต้น
        //     if('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'SHP'){
        //         $('#obtBrowseTROutFromPos').attr('disabled',false);
        //         $('#obtBrowseTROutToPos').attr('disabled',false);
        //     }else{
        //         $('#obtBrowseTROutFromPos').attr('disabled',true);
        //         $('#obtBrowseTROutToPos').attr('disabled',true);
        //         $('.xCNClearValue').val('');
        //     }
        // });

        // ===================================== เลือกสินค้า =====================================
        $('#obtTBIDocBrowsePdt').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose();
                JCNvTBIBrowsePdt();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // ===================================== แสดงคอลัมน์ =====================================
        $('#obtTBIAdvTablePdtDTTemp').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxTBIOpenColumnFormSet();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // ===================================== เลือกคอลัมน์ที่จะแสดง =====================================
        $('#odvTBIOrderAdvTblColumns #obtTBISaveAdvTableColums').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxTBISaveColumnShow();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
    });


    //TCNTPdtIntDTBch
    function JSxTBIEventClearTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docTBIEventClearTemp",

                cache: false,
                timeout: 0,
                success: function(oResult) {


                    JSvTBILoadPdtDataTableHtml();


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //TCNTPdtIntDTBch
    function JSxTBIEventGetPdtIntDTBch(ptTBODocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            let tTBIBchCode = $('#oetTBIBchCodeTo').val();
            let tTBIDocNo = $('#oetTBIDocNo').val();
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docTBIEventGetPdtIntDTBch",
                data: {
                    'tTBODocNo': ptTBODocNo,
                    'tTBIDocNo': tTBIDocNo,
                    'tTBIBchCode': tTBIBchCode
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturnData = JSON.parse(oResult);

                    console.log(aReturnData);

                    if (aReturnData['nStaEvent'] == '1') {
                        JSvTBILoadPdtDataTableHtml();

                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    // ===================================== เลือกประเภทต่างๆ =====================================

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
                Value: ["oetTBIUpVendingViaCode", "TCNMShipVia.FTViaCode"],
                Text: ["oetTBIUpVendingViaName", "TCNMShipVia_L.FTViaName"],
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
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            var tTWOWhereCons = "";
            if ($("#oetTBIBchCode").val() != "") {

                // Address Ref BCH
                tTWOWhereCons += "AND FTAddGrpType = 1 AND FTAddRefCode = '" + $("#oetTBIBchCode").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;

            }
            // Call Option Modal
            window.oTWOBrowseShipAddressOption = undefined;
            oTWOBrowseShipAddressOption = oTWOBrowseShipAddress({
                'tReturnInputCode': 'ohdTBIShipAddSeqNo',
                'tReturnInputName': 'ohdTBIShipAddSeqNo',
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
        } else {
            $("#odvTWOBrowseShipAdd").modal("hide");
            $('.modal-backdrop').remove();
            JCNxShowMsgSessionExpired();
        }
    });

    //Functionality : Behind NextFunc Browse Shippinh Address
    //Parameters : Event Next Func Modal
    //Creator : 04/07/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
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



    /** ========================================= Set Shipping Address =========================================== */
    $('#obtTBIFrmBrowseShipAdd').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            $('#odvTWOBrowseShipAdd').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#odvTWOBrowseShipAdd').modal('show');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    //เลือกร้านค้าต้นทาง
    var oBrowseTBIBPdtIntBranchBrows = {
        Title: ['document/transferreceiptbranch/transferreceiptbranch', 'tTBIBrowsDocTBO'],
        Table: {
            Master: 'TCNTPdtIntDTBch',
            PK: 'FTXthDocNo'
        },
        Join: {
            Table: ['TCNMBranch_L', 'TCNMWaHouse_L'],
            On: [
                'TCNTPdtIntDTBch.FTBchCode = TCNMBranch_L.FTBchCode  AND TCNMBranch_L.FNLngID = ' + nLangEdits,
                'TCNTPdtIntDTBch.FTXthWahTo = TCNMWaHouse_L.FTWahCode AND TCNTPdtIntDTBch.FTXthBchTo = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID=' + nLangEdits,
            ]
        },
        Where: {
            Condition: []
        },
        GrideView: {
            //  DistinctField       : ['TCNTPdtIntDTBch.FTXthDocNo'],
            ColumnPathLang: 'document/transferreceiptbranch/transferreceiptbranch',
            ColumnKeyLang: ['tTBIBchCode', 'tTBITablePDTBch', 'tTBIBrowsDocDate', 'tTBIBrowsDocNo', 'tTBIWarehouseTo'],
            ColumnsSize: ['10%', '20%', '20%', '30%', '20%'],
            WidthModal: 50,
            DataColumns: ['TCNTPdtIntDTBch.FTBchCode', 'TCNMBranch_L.FTBchName', 'TCNTPdtIntDTBch.FDCreateOn', 'TCNTPdtIntDTBch.FTXthDocNo', 'TCNMWaHouse_L.FTWahName', 'TCNTPdtIntDTBch.FTXthWahTo'],
            DataColumnsFormat: ['', '', '', '', ''],
            DisabledColumns: [5],
            Perpage: 10,
            OrderBy: ['TCNTPdtIntDTBch.FDCreateOn DESC,TCNTPdtIntDTBch.FTXthDocNo ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ['oetTBIRefIntDoc', "TCNTPdtIntDTBch.FTXthDocNo"],
            Text: ['oetTBIRefIntDoc', "TCNTPdtIntDTBch.FTXthDocNo"]
        },
        NextFunc: {
            FuncName: 'JSxTBISelectDocRefer',
            ArgReturn: ['FTXthDocNo', 'FTBchCode', 'FTBchName', 'FTWahName', 'FTXthWahTo'],
        },
        // DebugSQL : true
    }


    function JSxTBISelectDocRefer(ptCode) {
        if (ptCode == 'NULL' || ptCode == null) {
            JSxTBIEventClearTemp();
        } else {
            var tResult = JSON.parse(ptCode);
            console.log(tResult);
            let tTBODocNo = tResult[0];
            let tTBIBchCode = tResult[1];
            let tTBIBchName = tResult[2];
            let tTBIWahName = tResult[3];
            let tTBIWahCode = tResult[4];
            $('#oetTBIBchCodeFrom').val(tTBIBchCode);
            $('#oetTBIBchNameFrom').val(tTBIBchName);
            $('#oetTBIWahCodeTo').val(tTBIWahCode);
            $('#oetTBIWahNameTo').val(tTBIWahName);
            JSxTBIEventGetPdtIntDTBch(tTBODocNo);
        }
    }

    ////เอกสารอ้างอิงจ่ายโอน

    $('#oetTBIDocReferBrows').unbind().click(function() {
        var tTBIBchCode = $('#oetTBIBchCodeTo').val();
        oBrowseTBIBPdtIntBranchBrows.Where.Condition = ["AND TCNTPdtIntDTBch.FTXthBchTo = '" + tTBIBchCode + "' AND  ISNULL(TCNTPdtIntDTBch.FTXtdRvtRef,'') = '' AND TCNTPdtIntDTBch.FNXtdSeqNo = 1 "];
        JCNxBrowseData('oBrowseTBIBPdtIntBranchBrows');
    });
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
        },

    }
    $('#obtBrowseTROutFromShp').click(function() {
        //กรณีเข้ามาแบบสาขา ต้องโชว์ร้านค้าเฉพาะของสาขา
        if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'BCH') {
            $tBCH = '<?= $this->session->userdata("tSesUsrBchCom") ?>';
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
            var tBCH = $('#oetTBIBchCode').val();
            var tSHP = $('#oetTROutShpFromCode').val();
            oBrowseTROutFromWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '" + tBCH + "' "];
            JCNxBrowseData('oBrowseTROutFromWah_SHP');
        } else if ($('#oetTBIBchCode').val() != '') {
            //เลือกคลังที่สาขา
            var tBCH = $('#oetTBIBchCode').val();
            oBrowseTROutFromWah_BCH.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "'"];
            JCNxBrowseData('oBrowseTROutFromWah_BCH');
        }
    });

    //นำเข้าข้อมูล
    $('#obtImportPDTInCN').click(function() {
        var tBCHCode = $('#oetTBIBchCode').val();
        var tSHPCode = $('#oetTROutShpFromCode').val();
        var tWAHCode = $('#oetTROutWahFromCode').val();

        $.ajax({
            type: "POST",
            url: "docTBIPageSelectPDTInCN",
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
                    $('#odvTBIModalPDTCN .modal-body').html(tViewTableShow);
                    $('#odvTBIModalPDTCN').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    $("#odvTBIModalPDTCN").modal({
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
            OrderBy: ['TCNMShpWah.FDCreateOn DESC'],
            // SourceOrder		: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTROutWahToCode", "TCNMShpWah.FTWahCode"],
            Text: ["oetTROutWahToName", "TCNMWaHouse_L.FTWahName"],
        }
    }

    var oTBIBrowseWahTo = {
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
            Value: ["oetTBIWahCodeTo", "TCNMWaHouse.FTWahCode"],
            Text: ["oetTBIWahNameTo", "TCNMWaHouse_L.FTWahName"],
        }
    }

    // $('#obtTBIBrowseWahTo').click(function() {
    //     //เลือกคลังที่สาขา
    //     var tBCH = $('#oetTBIBchCodeTo').val();
    //     oTBIBrowseWahTo.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "' AND TCNMWaHouse.FTWahStaType IN('2','1') "];
    //     JCNxBrowseData('oTBIBrowseWahTo');
    // });

    ///////[เอกสารรับเข้า]

    //เลือกประเภทผู้จำหน่าย - จากแบบ => ประเภทผู้จำหน่าย
    var oTBIBrowseSpl = {
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
            OrderBy: ['TCNMSpl.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTBISplCode", "TCNMSpl.FTSplCode"],
            Text: ["oetTBISplName", "TCNMSpl_L.FTSplName"],
        },
    }
    $('#obtTBIBrowseSpl').click(function() {
        JCNxBrowseData('oTBIBrowseSpl');
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
            var tBCH = $('#oetTBIBchCode').val();
            var tSHP = $('#oetTRINShpFromCode').val();
            oBrowseTRINToWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '" + tBCH + "' "];
            JCNxBrowseData('oBrowseTRINToWah_SHP');
        } else if ($('#oetTBIBchCode').val() != '') {
            //เลือกคลังที่สาขา
            var tBCH = $('#oetTBIBchCode').val();
            oBrowseTRINToWah_BCH.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "' AND TCNMWaHouse.FTWahStaType IN('2','1') "];
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
            OrderBy: ['TCNMWaHouse_L.FTWahName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTRINWahFromCode", "TCNMShpWah.FTWahCode"],
            Text: ["oetTRINWahFromName", "TCNMWaHouse_L.FTWahName"],
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

        if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'SHP') {
            var tBCH = '<?= $this->session->userdata("tSesUsrBchCom") ?>';
            var tSHP = '<?= $this->session->userdata("tSesUsrShpCode") ?>';
            oBrowseTRINToWah_SHP.Where.Condition = ["AND TCNMShpWah.FTShpCode = '" + tSHP + "' AND TCNMShpWah.FTBchCode = '" + tBCH + "' "];
            JCNxBrowseData('oBrowseTRINToWah_SHP');
        } else {
            var tBCH = $('#oetTBIBchCode').val();
            oBrowseTRINEtcWah.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "' "];
            JCNxBrowseData('oBrowseTRINEtcWah');
        }
    });

    //เหตุผล
    var oBrowseTBIReason = {
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
            Value: ['oetTBIReasonCode', "TCNMRsn.FTRsnCode"],
            Text: ['oetTBIReasonName', "TCNMRsn_L.FTRsnName"]
        }
    }
    $('#obtBrowseTBIReason').click(function() {
        JCNxBrowseData('oBrowseTBIReason');
    });

    // ======================================================================================

    //แสดงคอลัมน์
    function JSxTBIOpenColumnFormSet() {
        $.ajax({
            type: "POST",
            url: "docTBIPageTableShowColList",
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                var aDataReturn = JSON.parse(oResult);
                if (aDataReturn['nStaEvent'] == '1') {
                    var tViewTableShowCollist = aDataReturn['tViewTableShowCollist'];
                    $('#odvTBIOrderAdvTblColumns .modal-body').html(tViewTableShowCollist);
                    $('#odvTBIOrderAdvTblColumns').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    $("#odvTBIOrderAdvTblColumns").modal({
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
    function JSxTBISaveColumnShow() {
        // คอลัมน์ที่เลือกให้แสดง
        var aTBIColShowSet = [];
        $("#odvTBIOrderAdvTblColumns .xWTBIInputColStaShow:checked").each(function() {
            aTBIColShowSet.push($(this).data("id"));
        });

        // คอลัมน์ทั้งหมด
        var aTBIColShowAllList = [];
        $("#odvTBIOrderAdvTblColumns .xWTBIInputColStaShow").each(function() {
            aTBIColShowAllList.push($(this).data("id"));
        });

        // ชื่อคอลัมน์ทั้งหมดในกรณีมีการแก้ไขชื่อคอลัมน์ที่แสดง
        var aTBIColumnLabelName = [];
        $("#odvTBIOrderAdvTblColumns .xWTBILabelColumnName").each(function() {
            aTBIColumnLabelName.push($(this).text());
        });

        // สถานะย้อนกลับค่าเริ่มต้น
        var nTBIStaSetDef;
        if ($("#odvTBIOrderAdvTblColumns #ocbTBISetDefAdvTable").is(":checked")) {
            nTBIStaSetDef = 1;
        } else {
            nTBIStaSetDef = 0;
        }

        $.ajax({
            type: "POST",
            url: "docTBIEventTableShowColSave",
            data: {
                'pnTBIStaSetDef': nTBIStaSetDef,
                'paTBIColShowSet': aTBIColShowSet,
                'paTBIColShowAllList': aTBIColShowAllList,
                'paTBIColumnLabelName': aTBIColumnLabelName
            },
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                $("#odvTBIOrderAdvTblColumns").modal("hide");
                $(".modal-backdrop").remove();
                JSvTBILoadPdtDataTableHtml();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เลือกสินค้า Add Product Into Table Document DT Temp
    function JCNvTBIBrowsePdt() {
        var tWahCode_Input_Origin = $('#oetTROutWahFromCode').val();
        var tWahCode_Input_To = $('#oetTROutWahToCode').val();
        var tWahCode_Output_Spl = $('#oetTRINWahFromCode').val();
        var tWahCode_Output_Etc = $('#oetTRINWahEtcName').val();
        var tTypeDocument = $('#ocmSelectTransferDocument :selected').val();

        if (tTypeDocument == 0) {
            $('#odvTBIModalTypeIsEmpty').modal('show');
            $('#ospTypeIsEmpty').html('<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTypeDocumentISEmptyDetail') ?>');
            return;
        } else {
            if (tTypeDocument == 'IN') { //เอกสารรับโอน
                if (tWahCode_Input_Origin == '' || tWahCode_Input_To == '') {
                    $('#odvTBIModalWahIsEmpty').modal('show');
                    $('#ospWahIsEmpty').html('<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tWahDocumentISEmptyDetail') ?>');
                    return;
                }
            } else if (tTypeDocument == 'OUT') { //เอกสารรับเข้า
                var tIN = $('#ocmSelectTransTypeIN :selected').val();
                if (tIN == 0) {
                    $('#odvTBIModalTypeIsEmpty').modal('show');
                    $('#ospTypeIsEmpty').html('<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tINDocumentISEmptyDetail') ?>');
                    return;
                } else {
                    var tTypeDocumentIN = $('#ocmSelectTransTypeIN :selected').val();
                    if (tTypeDocumentIN == 'SPL') {
                        if ($('#oetTRINWahFromCode').val() == '') {
                            $('#odvTBIModalWahIsEmpty').modal('show');
                            $('#ospWahIsEmpty').html('<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tWahINDocumentISEmptyDetail') ?>');
                            return;
                        }
                    } else if (tTypeDocumentIN == 'ETC') {
                        if ($('#oetTRINWahEtcCode').val() == '') {
                            $('#odvTBIModalWahIsEmpty').modal('show');
                            $('#ospWahIsEmpty').html('<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tWahINDocumentISEmptyDetail') ?>');
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
                    "CODEPDT",
                    "NAMEPDT",
                    "BARCODE",
                    "FromToSHP"
                ],
                PriceType: ["Cost", "tCN_Cost", "Company", "1"],
                SelectTier: ["Barcode"],
                ShowCountRecord: 10,
                NextFunc: "FSvTBIAddPdtIntoDocDTTemp",
                ReturnType: "M",
                SPL: ['', ''],
                BCH: [$('#oetTBIBchCodeTo').val(), $('#oetTBIBchCodeTo').val()],
                MCH: [$('#ohdTBIMerCode').val(), $('#ohdTBIMerCode').val()],
                SHP: [$('#ohdTBIShpCode').val(), $('#ohdTBIShpCode').val()],
                'aAlwPdtType' : ['T1','T3','T4','T5','T6','S2','S3','S4']
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
    function FSvTBIAddPdtIntoDocDTTemp(ptPdtData) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JCNxOpenLoading();

            var ptXthDocNoSend = "";
            if ($("#ohdTBIRoute").val() == "docTBIEventEdit") {
                ptXthDocNoSend = $("#oetTBIDocNo").val();
            }

            $.ajax({
                type: "POST",
                url: "docTBIEventAddPdtIntoDTDocTemp",
                data: {
                    'tTBIDocNo': ptXthDocNoSend,
                    'tTBIBchCode': $('#oetTBIBchCode').val(),
                    'tTBIPdtData': ptPdtData,
                    'tType': 'PDT'
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    JSvTBILoadPdtDataTableHtml();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //กดโมเดลลบสินค้าใน Tmp
    function JSnTBIDelPdtInDTTempSingle(poEl) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tVal = $(poEl).parents("tr.xWPdtItem").attr("data-pdtcode");
            var tSeqno = $(poEl).parents("tr.xWPdtItem").attr("data-seqno");
            $(poEl).parents("tr.xWPdtItem").remove();
            JSnTBIRemovePdtDTTempSingle(tSeqno, tVal);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ลบสินค้าใน Tmp - ตัวเดียว
    function JSnTBIRemovePdtDTTempSingle(ptSeqNo, ptPdtCode) {
        var tTBIDocNo = $("#oetTBIDocNo").val();
        var tTBIBchCode = $('#oetTBIBchCode').val();
        var tTBIVatInOrEx = 1;
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docTBIEventRemovePdtInDTTmp",
            data: {
                'tBchCode': tTBIBchCode,
                'tDocNo': tTBIDocNo,
                'nSeqNo': ptSeqNo,
                'tPdtCode': ptPdtCode,
                'tVatInOrEx': tTBIVatInOrEx,
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSvTBILoadPdtDataTableHtml();
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
    function JSxTBITextInModalDelPdtDtTemp() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("TBI_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {} else {
            var tTBITextDocNo = "";
            var tTBITextSeqNo = "";
            var tTBITextPdtCode = "";
            var tTBITextPunCode = "";
            $.each(aArrayConvert[0], function(nKey, aValue) {
                tTBITextDocNo += aValue.tDocNo;
                tTBITextDocNo += " , ";

                tTBITextSeqNo += aValue.tSeqNo;
                tTBITextSeqNo += " , ";

                tTBITextPdtCode += aValue.tPdtCode;
                tTBITextPdtCode += " , ";

                tTBITextPunCode += aValue.tPunCode;
                tTBITextPunCode += " , ";
            });
            $('#odvTBIModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIDocNoDelete').val(tTBITextDocNo);
            $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBISeqNoDelete').val(tTBITextSeqNo);
            $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPdtCodeDelete').val(tTBITextPdtCode);
            $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPunCodeDelete').val(tTBITextPunCode);
        }
    }

    //ค้นหา KEY
    function JStTBIFindObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }

    //แสดงให้ปุ่ม Delete กดได้
    function JSxTBIShowButtonDelMutiDtTemp() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("TBI_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#odvTBIMngDelPdtInTableDT #oliTBIBtnDeleteMulti").addClass("disabled");
        } else {
            var nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#odvTBIMngDelPdtInTableDT #oliTBIBtnDeleteMulti").removeClass("disabled");
            } else {
                $("#odvTBIMngDelPdtInTableDT #oliTBIBtnDeleteMulti").addClass("disabled");
            }
        }
    }

    // Confirm Delete Modal Multiple
    $('#odvTBIModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JSnTBIRemovePdtDTTempMultiple();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //ลบสินค้าใน Tmp - หลายตัว
    function JSnTBIRemovePdtDTTempMultiple() {
        JCNxOpenLoading();
        var tTBIDocNo = $("#oetTBIDocNo").val();
        var tTBIBchCode = $('#oetTBIBchCode').val();
        var tTBIVatInOrEx = 1;
        var aDataPdtCode = JSoTBIRemoveCommaData($('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPdtCodeDelete').val());
        var aDataPunCode = JSoTBIRemoveCommaData($('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPunCodeDelete').val());
        var aDataSeqNo = JSoTBIRemoveCommaData($('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBISeqNoDelete').val());
        $.ajax({
            type: "POST",
            url: "docTBIEventRemovePdtInDTTmpMulti",
            data: {
                'ptTBIBchCode': tTBIBchCode,
                'ptTBIDocNo': tTBIDocNo,
                'ptTBIVatInOrEx': tTBIVatInOrEx,
                'paDataPdtCode': aDataPdtCode,
                'paDataPunCode': aDataPunCode,
                'paDataSeqNo': aDataSeqNo,
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    $('#odvTBIModalDelPdtInDTTempMultiple').modal('hide');
                    $('#odvTBIModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
                    localStorage.removeItem('TBI_LocalItemDataDelDtTemp');
                    $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIDocNoDelete').val('');
                    $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBISeqNoDelete').val('');
                    $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPdtCodeDelete').val('');
                    $('#odvTBIModalDelPdtInDTTempMultiple #ohdConfirmTBIPunCodeDelete').val('');
                    setTimeout(function() {
                        $('.modal-backdrop').remove();
                        JSvTBILoadPdtDataTableHtml();
                        $("#odvTBIMngDelPdtInTableDT #oliTBIBtnDeleteMulti").addClass("disabled");
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
    function JSoTBIRemoveCommaData(paData) {
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
    $('#obtTBISubmitFromDoc').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {

            //ถ้าค่าไม่สมบูรณ์ไม่อนุญาตให้บันทึก
            var tWahCode_Input_Origin = $('#oetTROutWahFromCode').val();
            var tWahCode_Input_To = $('#oetTROutWahToCode').val();
            var tWahCode_Output_Spl = $('#oetTRINWahFromCode').val();
            var tWahCode_Output_Etc = $('#oetTRINWahEtcName').val();
            var tTypeDocument = $('#ocmSelectTransferDocument :selected').val();

            if (tTypeDocument == 0) {
                $('#odvTBIModalTypeIsEmpty').modal('show');
                $('#ospTypeIsEmpty').html('<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTypeDocumentISEmptyDetail') ?>');
                return;
            } else {
                if (tTypeDocument == 'IN') { //เอกสารรับโอน
                    if (tWahCode_Input_To == '') {
                        $('#odvTBIModalWahIsEmpty').modal('show');
                        $('#ospWahIsEmpty').html('<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tWahDocumentISEmptyDetail') ?>');
                        return;
                    }
                } else if (tTypeDocument == 'OUT') { //เอกสารรับเข้า
                    var tIN = $('#ocmSelectTransTypeIN :selected').val();
                    if (tIN == 0) {
                        $('#odvTBIModalTypeIsEmpty').modal('show');
                        $('#ospTypeIsEmpty').html('<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tINDocumentISEmptyDetail') ?>');
                        return;
                    } else {
                        var tTypeDocumentIN = $('#ocmSelectTransTypeIN :selected').val();
                        if (tTypeDocumentIN == 'SPL') {
                            if ($('#oetTRINWahFromCode').val() == '') {
                                $('#odvTBIModalWahIsEmpty').modal('show');
                                $('#ospWahIsEmpty').html('<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tWahINDocumentISEmptyDetail') ?>');
                                return;
                            }
                        } else if (tTypeDocumentIN == 'ETC') {
                            if ($('#oetTRINWahEtcCode').val() == '') {
                                $('#odvTBIModalWahIsEmpty').modal('show');
                                $('#ospWahIsEmpty').html('<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tWahINDocumentISEmptyDetail') ?>');
                                return;
                            }
                        }
                    }
                }
            }

            $('#obtSubmitTransferreceipt').click();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //อีเวนท์บันทึก - แก้ไข
    function JSxTransferreceiptEventAddEdit(ptRoute) {
        //console.log($('#ocmSelectTransTypeIN').val());
        $("#ofmTransferreceiptFormAdd").validate({
            rules: {
                oetTBIDocNo: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "docTBIEventAdd") {
                                if ($('#ocbTBIStaAutoGenCode').is(':checked')) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return false;
                            }
                        }
                    }
                },
                oetTBIRefIntDoc: {
                    "required": {
                        depends: function(oElement) {
                            if ($('#ohdTBIFrmDocType').val() == '1') {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    }
                },
                oetTBISplName: {
                    "required": {
                        depends: function(oElement) {
                            if ($('#ocmSelectTransTypeIN').val() == '3') {
                                if ($('#ohdTBIFrmDocType').val() == '5') {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return false;
                            }
                        }
                    }
                },
                oetTBIINEtc: {
                    "required": {
                        depends: function(oElement) {
                            if ($('#ocmSelectTransTypeIN').val() == '4') {
                                if ($('#ohdTBIFrmDocType').val() == '5') {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return false;
                            }
                        }
                    }
                },
                oetTBIWahNameTo: "required",
            },
            messages: {
                oetTBIDocNo: $("#oetTBIDocNo").data("validate"),
                oetTBIRefIntDoc: $("#oetTBIRefIntDoc").data("validate"),
                oetTBIWahNameTo: $("#oetTBIWahNameTo").data("validate"),
                oetTBISplName: $("#oetTBISplName").data("validate"),
                oetTBIINEtc: $("#oetTBIINEtc").data("validate"),
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest(".form-group")).find(".help-block").length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest(".form-group")).trigger("change");
                    }
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element)
                    .closest(".form-group")
                    .addClass("has-error")
                    .removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element)
                    .closest(".form-group")
                    .addClass("has-success")
                    .removeClass("has-error");
            },
            submitHandler: function(form) {
                var tItem = $('#odvTBIDataPdtTableDTTemp #otbTBIDocPdtAdvTableList .xWPdtItem').length;
                var tItem2 = $('#odvTBIDataPdtTableDTTemp #otbTransferBchOutPdtTable .xWTransferBchOutPdtItem').length;
                if ($("#oetTBIRefIntDoc").val()=="") {
                  $('#odvTBIModalPleaseSelectLef').modal('show');
                }else if (tItem > 0 || tItem2 >0 ) {
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
                                    JSvTBICallPageEdit(aReturn['tCodeReturn']);
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvTBITransferReceiptAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvTBICallPageTransferReceipt(1);
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                            var nDODocNoCallBack = aReturn['tCodeReturn'];
                            let oDOCallDataTableFile = {
                                ptElementID: 'odvDOShowDataTable',
                                ptBchCode: $('#oetTBIBchCode').val(),
                                ptDocNo: nDODocNoCallBack,
                                ptDocKey: 'TCNTPdtTbiHD',
                            }
                            JCNxUPFInsertDataFile(oDOCallDataTableFile);

                            JCNxCloseLoading();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                } else {
                    $('#odvTBIModalPleaseSelectPDT').modal('show');
                }
            }
        });

    }

    //บันทึก EDIT IN LINE - STEP 1
    function JSxTBISaveEditInline(paParams) {
        var oThisEl = paParams['Element'];
        var nSeqNo = paParams.DataAttribute[1]['data-seq'];
        var tFieldName = paParams.DataAttribute[0]['data-field'];
        var tValue = accounting.unformat(paParams.VeluesInline);
        FSvTBIEditPdtIntoTableDT(nSeqNo, tFieldName, tValue);
    }

    //บันทึก EDIT IN LINE - STEP 2
    function FSvTBIEditPdtIntoTableDT(pnSeqNo, ptFieldName, ptValue) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tTBIDocNo = $("#oetTBIDocNo").val();
            var tTBIBchCode = $("#oetTBIBchCode").val();
            var tTBIVATInOrEx = $('#ohdTBIFrmSplInfoVatInOrEx').val();
            $.ajax({
                type: "POST",
                url: "docTBIEventEditInline",
                data: {
                    'tTBIBchCode': tTBIBchCode,
                    'tTBIDocNo': tTBIDocNo,
                    'tTBIVATInOrEx': tTBIVATInOrEx,
                    'nTBISeqNo': pnSeqNo,
                    'tTBIFieldName': ptFieldName,
                    'tTBIValue': ptValue
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    JSvTBILoadPdtDataTableHtml();
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
    function JSvTBIDOCFilterPdtInTableTemp() {
        JCNxOpenLoading();
        JSvTBILoadPdtDataTableHtml();
    }

    //Next page ในตารางสินค้า Tmp
    function JSvTBIPDTDocDTTempClickPage(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld = $(".xWPageTBIPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld = $(".xWPageTBIPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                default:
                    nPageCurrent = ptPage;
            }
            JCNxOpenLoading();
            JSvTBILoadPdtDataTableHtml(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    $('#obtBrowseTBIBch').click(function() {
        JCNxBrowseData('oBrowse_BCH');
    });

    var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tWhere = "";

    if (nCountBch == 1) {
        $('#obtBrowseTBIBch').attr('disabled', true);
    }
    if (tUsrLevel != "HQ") {
        tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";
    } else {
        tWhere = "";
    }

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
            Condition: [tWhere]
        },
        GrideView: {
            ColumnPathLang: 'company/branch/branch',
            ColumnKeyLang: ['tBCHCode', 'tBCHName', ''],
            ColumnsSize: ['15%', '75%', ''],
            WidthModal: 50,
            DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName', 'TCNMWaHouse_L.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            DisabledColumns: [2, 3],
            Perpage: 5,
            OrderBy: ['TCNMBranch_L.FTBchName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetTBIBchCode", "TCNMBranch.FTBchCode"],
            Text: ["oetTBIBchName", "TCNMBranch_L.FTBchName"],
        },
        // NextFunc: {
        //     FuncName: 'JSxSetDefauleWahouse',
        //     ArgReturn: ['FTWahCode', 'FTWahName']
        // }
    }

    // function JSxSetDefauleWahouse(ptData) {
    //     if (ptData == '' || ptData == 'NULL') {
    //         $('#oetTBIWahCodeTo').val('');
    //         $('#oetTBIWahNameTo').val('');
    //     } else {
    //         var tResult = JSON.parse(ptData);
    //         $('#oetTBIWahCodeTo').val(tResult[0]);
    //         $('#oetTBIWahNameTo').val(tResult[1]);
    //     }
    // }

    function JSxTBIClearPdtAndRefTmp(){
        $.ajax({
            type: "POST",
            url: "docTBIEventClearTemp",
            cache: false,
            timeout: 0,
            success: function(oResult) {
                JSvTBILoadPdtDataTableHtml();
                JSxTBICallPageHDDocRef();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Project : King Power Click
    // Create By : Napat(Jame) 05/05/2022
    $('#obtBrowseTWOBCHTo ,#obtTBIBrowseWahTo').off('click').on('click',function() {
        var nPdtCount       = $('.xWPdtItem').length;
        var nRefCount       = $('.xWRefDocNoItem').length;
        var tBtn            = $(this).attr('data-btn');
        var tBCH            = $('#oetTBIBchCodeTo').val();
        var tMsgWarnning    = "มีข้อมูลรายการสินค้าหรืออ้างอิงในระบบ ท่านต้องการที่จะลบข้อมูล ใช่ หรือ ไม่ ?";

        if( nPdtCount > 0 || nRefCount > 0 ){
            // ถ้ามีสินค้าหรืออ้างอิงแล้วให้แจ้ง Message ถามว่าต้องการเคลียร์และ Browse เลือกรายการต่อ หรือยกเลิก
            switch(tBtn){
                case 'TOBCH':
                    FSvCMNSetMsgWarningDialog(tMsgWarnning,'JSxTBINextFuncBrowseBch','','true');
                    break;
                case 'TOWAH':
                    FSvCMNSetMsgWarningDialog(tMsgWarnning,'JSxTBINextFuncBrowseWah','','true');
                    break;
            }
        }else{
            // ถ้าไม่มีสินค้าหรืออ้างอิงในระบบ แสดง Browse ปกติ
            switch(tBtn){
                case 'TOBCH':
                    JCNxBrowseData('oBrowse_BCHTo');
                    break;
                case 'TOWAH':
                    oTBIBrowseWahTo.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "' AND TCNMWaHouse.FTWahStaType IN('2','1') "];
                    JCNxBrowseData('oTBIBrowseWahTo');
                    break;
            }
        }
    });

    function JSxTBINextFuncBrowseBch(ptReturn){
        JCNxBrowseData('oBrowse_BCHTo');
        JSxTBIClearPdtAndRefTmp();
    }

    function JSxTBINextFuncBrowseWah(ptReturn){
        oTBIBrowseWahTo.Where.Condition = ["AND TCNMWaHouse.FTBchCode = '" + tBCH + "' AND TCNMWaHouse.FTWahStaType IN('2','1') "];
        JCNxBrowseData('oTBIBrowseWahTo');
        JSxTBIClearPdtAndRefTmp();
    }

    var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tWhereBchTo = "";

    if (nCountBch == 1) {
        $('#obtBrowseTWOBCHTo').attr('disabled', true);
    }
    if (tUsrLevel != "HQ") {
        tWhereBchTo = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";
    } else {
        tWhereBchTo = "";
    }


    var oBrowse_BCHTo = {
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
            Condition: [tWhereBchTo]
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
            Value: ["oetTBIBchCodeTo", "TCNMBranch.FTBchCode"],
            Text: ["oetTBIBchNameTo", "TCNMBranch_L.FTBchName"],
        },
        NextFunc: {
            FuncName: 'JSxSetDefauleWahouse',
            ArgReturn: ['FTWahCode', 'FTWahName']
        }
    }

    function JSxSetDefauleWahouse(ptData) {
        if (ptData == '' || ptData == 'NULL') {
            $('#oetTBIWahCodeTo').val('');
            $('#oetTBIWahNameTo').val('');
        } else {
            var tResult = JSON.parse(ptData);
            $('#oetTBIWahCodeTo').val(tResult[0]);
            $('#oetTBIWahNameTo').val(tResult[1]);
        }
    }

    //ปริ้นเอกสาร ใบรับโอน - สาขา
    function JSxTBITransferReceiptPrintDoc() {
        var aInfor = [{
                "Lang": '<?= FCNaHGetLangEdit(); ?>'
            }, // Lang ID
            {
                "ComCode": '<?= FCNtGetCompanyCode(); ?>'
            }, // Company Code
            {
                "BranchCode": '<?= FCNtGetAddressBranch($tTBIBchCode); ?>'
            }, // สาขาที่ออกเอกสาร
            {
                "DocCode": $('#oetTBIDocNo').val()
            },
            {
                "DocBchCode": '<?= $tTBIBchCode ?>'
            } // เลขที่เอกสาร
        ];
        window.open("<?= base_url(); ?>formreport/Frm_SQL_ALLMPdtBillTnfInBch?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

    //กดเพิ่มเอกสารอ้างอิง (ภายใน ภายนอก)
    $('#obtTBIAddDocRef').off('click').on('click',function(){
        $('#ofmTBIFormAddDocRef').validate().destroy();
        JSxTBIEventClearValueInFormHDDocRef();
        $('#odvTBIModalAddDocRef').modal('show');
    });
    //กดเลือกอ้างอิงเอกสารภายใน (ใบขอโอน - สาขา)
    $('#obtTBIBrowseRefDoc').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCallPageTransferBchOutRefIntDoc();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //เมื่อเปลี่ยน ประเภท (ภายใน หรือ ภายนอก)
    $('#ocbTBIRefType').off('change').on('change',function(){
        $(this).selectpicker('refresh');
        JSxTBIEventCheckShowHDDocRef();
    });
    //Default โชว์ panel ตามประเภท (ภายใน หรือ ภายนอก)
    function JSxTBIEventCheckShowHDDocRef(){
        var tTBIRefType = $('#ocbTBIRefType').val();
        if( tTBIRefType == '1' ){
            $('.xWShowRefExt').hide();
            $('.xWShowRefInt').show();
        }else{
            $('.xWShowRefInt').hide();
            $('.xWShowRefExt').show();
        }
    }
    //เคลียร์ค่า
    function JSxTBIEventClearValueInFormHDDocRef(){
        $('#oetTBIRefDocNo').val('');
        $('#oetTBIRefDocDate').val('');
        $('#oetTBIDocRefInt').val('');
        $('#oetTBIDocRefIntName').val('');
        $('#oetTBIRefKey').val('');
    }
    //กดยืนยันบันทึกลง Temp
    $('#ofmTBIFormAddDocRef').off('click').on('click',function(){
        $('#ofmTBIFormAddDocRef').validate().destroy();
        $('#ofmTBIFormAddDocRef').validate({
            focusInvalid    : false,
            onclick         : false,
            onfocusout      : false,
            onkeyup         : false,
            rules           : {
                oetTBIRefDocNo      : {
                    "required" : {
                        depends: function(oElement){
                            if( $('#ocbTBIRefType').val() == '3' ){
                                return true;
                            }else{
                                return false;

                            }
                        }
                    },
                },
                oetTBIDocRefIntName : {
                    "required" : {
                        depends: function(oElement){
                            if( $('#ocbTBIRefType').val() == '1' ){
                                return true;
                            }else{
                                return false;

                            }
                        }
                    },
                },
                oetTBIRefDocDate    : { "required" : true },
            },
            messages: {
                oetTBIRefDocNo      : {"required" : 'กรุณากรอกเลขที่เอกสารอ้างอิง'},
                oetTBIRefDocDate    : {"required" : 'กรุณากรอกวันที่เอกสารอ้างอิง'},
                oetTBIDocRefIntName : {"required" : 'กรุณาเลือกเลขที่เอกสารอ้างอิง'},
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
                //JCNxCloseLoading();//ต้องเอาตรงนี้ออก
                if($('#ocbTBIRefType').val() == 1){         //อ้างอิงเอกสารภายใน
                    var tDocNoRef   = $('#oetTBIDocRefInt').val();
                    var tDocRefKey  = 'TBO';
                }else{                                      //อ้างอิงเอกสารภายนอก
                    var tDocNoRef   = $('#oetTBIRefDocNo').val();
                    var tDocRefKey  = $('#oetTBIRefKey').val();
                }

                $.ajax({
                    type    : "POST",
                    url     : "docTBIEventAddEditHDDocRef",
                    data    : {
                        'ptRefDocNoOld'     : $('#oetTBIRefDocNoOld').val(),
                        'ptDocNo'           : $('#oetTBIDocNo').val(),
                        'ptRefType'         : $('#ocbTBIRefType').val(),
                        'ptRefDocNo'        : tDocNoRef,
                        'pdRefDocDate'      : $('#oetTBIRefDocDate').val(),
                        'ptRefKey'          : tDocRefKey
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult){

                        JSxTBIEventClearValueInFormHDDocRef();
                        $('#odvTBIModalAddDocRef').modal('hide');

                        

                        if( $('#ocbTBIRefType').val() == 1 ){   //อ้างอิงเอกสารภายใน

                            JSxTBICallPageHDDocRef(false);

                            var tRefIntDocNo    =  $('.xDocuemntRefInt.active').data('docno');
                            var tRefIntDocDate  =  $('.xDocuemntRefInt.active').data('docdate');
                            var tRefIntBchCode  =  $('.xDocuemntRefInt.active').data('bchcode');
                            var aSeqNo 			=  $('.ocbRefIntDocDT:checked').map(function(elm){ return $(this).val(); }).get();

                            var tSplStaVATInOrEx =  $('.xDocuemntRefInt.active').data('vatinroex');
                            var cSplCrLimit      =  $('.xDocuemntRefInt.active').data('crtrem');
                            var nSplCrTerm       =  $('.xDocuemntRefInt.active').data('crlimit');
                            var tSplCode         =  $('.xDocuemntRefInt.active').data('splcode');
                            var tSplName         =  $('.xDocuemntRefInt.active').data('splname');
                            var tSPlPaidType     =  $('.xDocuemntRefInt.active').data('dstpain');
                            var tVatcode         =  $('.xDocuemntRefInt.active').data('vatcode');
                            var nVatrate         =  $('.xDocuemntRefInt.active').data('vatrate');

                            var tBchFrm         =  $('.xDocuemntRefInt.active').data('bchfrm');
                            var tBchNameFrm     =  $('.xDocuemntRefInt.active').data('bchnamefrm');

                            var tWahFrm         =  $('.xDocuemntRefInt.active').data('wahfrm');
                            var tWahNameFrm     =  $('.xDocuemntRefInt.active').data('wahnamefrm');

                            var tBchTo          =  $('.xDocuemntRefInt.active').data('bchto');
                            var tBchNameTo      =  $('.xDocuemntRefInt.active').data('bchnameto');

                            var tWahTo          =  $('.xDocuemntRefInt.active').data('wahto');
                            var tWahNameTo      =  $('.xDocuemntRefInt.active').data('wahnameto');
                            // console.log(tBchFrm);
                            // console.log(tBchNameFrm);
                            // console.log(tWahFrm);
                            // console.log(tWahNameFrm);
                            // console.log(tBchTo);
                            // console.log(tBchNameTo);
                            // console.log(tWahTo);
                            // console.log(tWahNameTo);
                            // $('#obtTransferBchOutBrowseBchFrom').attr('disabled',false);
                            // $('#obtTransferBchOutBrowseWahFrom').attr('disabled',false);
                            // $('#oetTransferBchOutXthBchFrmCode').val(tBchFrm);
                            // $('#oetTransferBchOutXthBchFrmName').val(tBchNameFrm);
                            // $('#oetTransferBchOutXthWhFrmCode').val(tWahFrm);
                            // $('#oetTransferBchOutXthWhFrmName').val(tWahNameFrm);
                            $("#oetTBIBchCodeFrom").val(tBchFrm);
                            $("#oetTBIBchNameFrom").val(tBchNameFrm);
                             // $("#oetTransferBchOutBchCode").val();
                             // $("#oetTransferBchOutMchCode").val();
                             // $("#oetTransferBchOutShpCode").val();
                             // $("#oetTransferBchOutPosCode").val();
                             // $("#oetTransferBchOutWahCode").val();

                            $('#tRefIntDocNo').val(tRefIntDocNo);
                            $('#tRefIntDocDate').val(tRefIntDocDate);
                            $('#tRefIntBchCode').val(tRefIntBchCode);
                            // $('#obtTransferBchOutBrowseBchTo').attr('disabled',false);
                            // $('#obtTransferBchOutBrowseWahTo').attr('disabled',false);
                            // $('#oetTransferBchOutXthBchToCode').val(tBchTo);
                            // $('#oetTransferBchOutXthBchToName').val(tBchNameTo);
                            $('#oetTBIWahCodeTo').val(tWahTo);
                            $('#oetTBIWahNameTo').val(tWahNameTo);




                            //JCNxOpenLoading();
                            $.ajax({
                              type    : "POST",
                              url     : "docTBITransferBchOutRefIntDocInsertDTToTemp",
                              data    : {
                                'tTransferBchOutDocNo'          : $('#tRefIntDocNo').val(),
                                'tTransferBchOutFrmBchCode'     : $('#tRefIntBchCode').val(),
                                'tRefIntDocNo'      			: tRefIntDocNo,
                                'tRefIntBchCode'    			: tRefIntBchCode,
                                'tSplStaVATInOrEx'  			: tSplStaVATInOrEx,
                                'aSeqNo'            			: aSeqNo
                              },
                              cache: false,
                              Timeout: 0,
                              success: function (oResult){
                                //โหลดสินค้าใน Temp
                                JSxTransferBchOutGetPdtInTmp(1,true);

                              },
                              error: function (jqXHR, textStatus, errorThrown) {
                                JCNxResponseError(jqXHR, textStatus, errorThrown);
                              }
                            });

                        }else{
                            JSxTBICallPageHDDocRef();
                        }
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
    function JSxTBICallPageHDDocRef(pbStaCloseLoading = true){
        $.ajax({
            type    : "POST",
            url     : "docTBIPageHDDocRef",
            data:{
                'ptDocNo'       : $('#oetTBIDocNo').val(),
                'ptStaApv'      : $('#ohdTBIStaApv').val(),
                'ptStaPrcDoc'   : $('#ohdTBIStaPrcDoc').val()
            },
            cache   : false,
            timeout : 0,
            success: function(oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == 1 ){
                    $('#odvTBITableHDRef').html(aResult['tViewPageHDRef']);
                    if( pbStaCloseLoading ){
                        JCNxCloseLoading();
                    }
                }else{
                    var tMessageError = aResult['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
    /*===== Begin Pdt Process =========================================================*/
    /**
     * Functionality : Get Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutGetPdtInTmp(pnPage, pbUseLoading) {

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTransferBchOutBchCode').val();
            var tMerCode = $('#oetTransferBchOutMchCode').val();
            var tShpCode = $('#oetTransferBchOutShpCode').val();
            var tPosCode = $('#oetTransferBchOutPosCode').val();
            var tWahCode = $('#oetTransferBchOutWahCode').val();

            var tSearchAll = $('#oetTransferBchOutPdtSearchAll').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "docTBITransferBchOutGetPdtInTmp",
                data: {
                    tBchCode        : tBchCode,
                    tMerCode        : tMerCode,
                    tShpCode        : tShpCode,
                    tPosCode        : tPosCode,
                    tWahCode        : tWahCode,
                    nPageCurrent    : pnPage,
                    tIsApvOrCancel  : (bIsApvOrCancel) ? "1" : "0",
                    tSearchAll      : tSearchAll,
                    ptStaPrcDoc     : $('#ohdTBOStaPrcDoc').val(),
                    pbIsAddPage     : bIsAddPage,
                    ptDocNo         : $('#tRefIntDocNo').val()
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    //console.log(oResult.html);
                    //JSxTransferBchOutSetEndOfBill(oResult.aEndOfBill);
                    $('#odvTBIDataPdtTableDTTemp').html(oResult.html);
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
</script>
