<script>
    $(document).ready(function() {

        localStorage.removeItem("LocalTransferBchOutPdtItemData");

        JSxTransferBchOutGetPdtInTmp();

        if (tStaApv == "2" && !bIsCancel) {
            JSoTransferBchOutSubscribeMQ();
        }

        var tStaDoc = '<?php echo $tStaDoc; ?>';
        var tStaApv = '<?php echo $tStaApv; ?>';
        var tRoute = '<?php echo $tRoute; ?>';
        var tStaPrcStk = '<?php echo $tStaPrcStk; ?>';


        // if (tStaDoc == 3 || tTWIStaApvDoc == 1) {
        //     $('#odvTWIMngAdvTableList').hide();
        //     $('#odvTWIMngDelPdtInTableDT').hide();
        //     $('#obtTWIDocBrowsePdt').hide();
        // }

        // //เอกสารถูกยกเลิก
        // if (tStaDoc == 3) {
        //     $('#obtTrnOutPrintDoc').show();
        //     $('#obtTWICancelDoc').hide();
        //     $('#obtTWIApproveDoc').hide();
        //     $('#odvTWIBtnGrpSave').hide();
        //     $('#otaTWIFrmInfoOthRmk').attr('disabled', true);

        //     //วันที่ + เวลา
        //     $('#oetTWIDocDate').attr('disabled', true);
        //     $('#oetTWIDocTime').attr('disabled', true);
        //     $('.xCNControllDateTime').attr('disabled', true);
        //     $('.xWDropdown').attr('disabled', true);

        //     //ประเภท
        //     $('#ocmSelectTransferDocument').attr('disabled', true);
        //     $('#ocmSelectTransTypeIN').attr('disabled', true);
        //     $('#oetTWIINEtc').attr('disabled', true);
        //     $('.xCNApvOrCanCelDisabled').attr('disabled', true);
        //     $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");

        // } else if (tStaApv == 1) {
        //     $('#obtTrnOutPrintDoc').show();
        //     if (tStaPrcStk == '') {
        //         $('#obtTWICancelDoc').show();
        //     } else {
        //         $('#obtTWICancelDoc').hide();
        //     }
        //     $('#obtTWIApproveDoc').hide();
        //     $('#odvTWIBtnGrpSave').show();
        //     $('#otaTWIFrmInfoOthRmk').removeAttr('disabled', true);

        //     //วันที่ + เวลา
        //     $('#oetTWIDocDate').attr('disabled', true);
        //     $('#oetTWIDocTime').attr('disabled', true);
        //     $('.xCNControllDateTime').attr('disabled', true);
        //     $('.xWDropdown').attr('disabled', true);

        //     //ประเภท
        //     $('#ocmSelectTransferDocument').attr('disabled', true);
        //     $('#ocmSelectTransTypeIN').attr('disabled', true);
        //     $('#oetTWIINEtc').attr('disabled', true);
        //     $('.xCNApvOrCanCelDisabled').attr('disabled', true);
        //     $(".xCNDocBrowsePdt").attr("disabled", true).addClass("xCNBrowsePdtdisabled");
        // } else {
        //     if (tStaDoc == 1 && tRoute == 'dcmTWIEventEdit') {
        //         $('#obtTrnOutPrintDoc').show();
        //         $('#obtTWICancelDoc').show();
        //         $('#obtTWIApproveDoc').show();
        //         $('#odvTWIBtnGrpSave').show();
        //     } else {
        //         $('#odvTWIBtnGrpSave').show();
        //         $('#obtTrnOutPrintDoc').hide();
        //         $('#obtTWICancelDoc').hide();
        //         $('#obtTWIApproveDoc').hide();
        //     }
        // }










        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        $('#obtXthDocDate').click(function() {
            event.preventDefault();
            $('#oetXthDocDate').datepicker('show');
        });

        $('#obtXthDocTime').click(function() {
            event.preventDefault();
            $('#oetXthDocTime').datetimepicker('show');
        });

        $('#obtXthRefExtDate').click(function() {
            event.preventDefault();
            $('#oetXthRefExtDate').datepicker('show');
        });

        $('#obtXthRefIntDate').click(function() {
            event.preventDefault();
            $('#oetXthRefIntDate').datepicker('show');
        });

        $('#obtXthTnfDate').click(function() {
            event.preventDefault();
            $('#oetXthTnfDate').datepicker('show');
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

        $('#ocbTransferBchOutAutoGenCode').unbind().bind('change', function() {
            var bIsChecked = $('#ocbTransferBchOutAutoGenCode').is(':checked');
            var oInputDocNo = $('#oetTransferBchOutDocNo');
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

        if (!bIsApvOrCancel) {
            if (tUserLoginLevel == 'HQ') {
                // สาขาต้นทางต้องถูกกำหนดก่อนที่จะเลือก กลุ่มร้านค้าปลายทาง
                if ($('#oetTransferBchOutXthBchFrmCode').val() == '') { // ไม่ได้กำหนดสาขาต้นทาง
                    $('#obtTransferBchOutBrowseMerFrom').attr('disabled', true);
                } else { // กำหนดสาขาต้นทางแล้ว
                    $('#obtTransferBchOutBrowseMerFrom').attr('disabled', false);
                }

                $('#obtTransferBchOutBrowseShpFrom').attr('disabled', true);
                // $('#obtTransferBchOutBrowseWahFrom').attr('disabled', true);
            }

            if (tUserLoginLevel == 'BCH' && !bIsMultiBch) {
                $('#obtTransferBchOutBrowseBchFrom').attr('disabled', true);
                $('#obtTransferBchOutBrowseShpFrom').attr('disabled', true);
                // $('#obtTransferBchOutBrowseWahFrom').attr('disabled', true);
            }

            if (tUserLoginLevel == 'SHP') {
                $('#obtTransferBchOutBrowseBchFrom').attr('disabled', true);
                $('#obtTransferBchOutBrowseMerFrom').attr('disabled', true);
                $('#obtTransferBchOutBrowseShpFrom').attr('disabled', true);
                $('#obtTransferBchOutBrowseWahFrom').attr('disabled', true);
            }

            if ($('#oetTransferBchOutXthMerchantFrmCode').val() != '') { // กำหนดกลุ่มร้านค้าต้นทางแล้ว
                $('#obtTransferBchOutBrowseShpFrom').attr('disabled', false);
            }
            if ($('#oetTransferBchOutXthShopFrmCode').val() != '') { // กำหนดร้านค้าต้นทางแล้ว
                $('#obtTransferBchOutBrowseWahFrom').attr('disabled', false);
            }

            // คลังต้นทางต้องถูกกำหนดก่อน ถึงจะเลือกปลายทาง
            if ($('#oetTransferBchOutXthWhFrmCode').val() == '') { // ไม่ได้กำหนดคลังต้นทาง
                $('#obtTransferBchOutBrowseBchTo').attr('disabled', true);
                $('#obtTransferBchOutBrowseWahTo').attr('disabled', true);
            } else { // กำหนดคลังต้นทางแล้ว
                if (tUserLoginLevel == "HQ" || bIsMultiBch) {
                    $('#obtTransferBchOutBrowseBchTo').attr('disabled', false);
                } else {
                    // $('#obtTransferBchOutBrowseBchTo').attr('disabled', true);
                }
                $('#obtTransferBchOutBrowseWahTo').attr('disabled', true);

            }

            // สาขาปลายทางต้องถูกกำหนดก่อน ถึงเลือกคลังปลายทางได้
            if ($('#oetTransferBchOutXthBchToCode').val() == '') { // ไม่ได้กำหนดสาขาปลายทาง
                $('#obtTransferBchOutBrowseWahTo').attr('disabled', true);
            } else { // กำหนดสาขาปลายทางแล้ว
                if (tUserLoginLevel == "HQ" || bIsMultiBch) {
                    $('#obtTransferBchOutBrowseWahTo').attr('disabled', false);
                } else {
                    $('#obtTransferBchOutBrowseWahTo').attr('disabled', true);
                }
            }
        }

        // console.log('bIsAddPage',bIsAddPage);
        // console.log('bIsApv',bIsApv);
        // console.log('bIsPrcStk',bIsPrcStk);
        // console.log('bIsCancel',bIsCancel);
       
        if ( bIsApvOrCancel && !bIsAddPage) {
            $('#obtTransferBchOutApprove').hide();
            $('#obtTransferBchOutCancel').hide();
            // $('#odvBtnAddEdit .btn-group').hide();
            $('form .xCNApvOrCanCelDisabled').attr('disabled', true);
        } else {
            $('#odvBtnAddEdit .btn-group').show();
        }

        if( !bIsAddPage && bIsApv && bIsPrcStk && bIsCancel ){  // หน้าจอแก้ไข && อนุมัติแล้ว && ประมวลผลแล้ว && ยกเลิกแล้ว
            $('#obtTBOCancelOnApv').addClass('xCNHide'); //ปิดปุ่มยกเลิก
        }else if( !bIsAddPage && bIsApv && bIsPrcStk && !bIsCancel ){ // หน้าจอแก้ไข && อนุมัติแล้ว && ประมวลผลแล้ว && ยังไม่ยกเลิก
            $('#obtTBOCancelOnApv').removeClass('xCNHide'); //เปิดปุ่มยกเลิก
        }else{
            $('#obtTBOCancelOnApv').addClass('xCNHide'); //ปิดปุ่มยกเลิก
        }

        if(bIsCancel){
            $('#odvTBOBtnGrpSave').hide();
        }else{
            $('#odvTBOBtnGrpSave').show();
        }

        /*===== Begin Control สาขาที่สร้าง ================================================*/
        if (tUserLoginLevel != "HQ" && !bIsMultiBch) { //|| (!bIsAddPage) || (!bIsMultiBch)
            $("#obtTransferBchOutBrowseBch").attr('disabled', true);
        }
        /*===== End Control สาขาที่สร้าง ==================================================*/

        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                return false;
            }
        });

    });

    /*===== Begin Event Browse =========================================================*/
    // สาขาที่สร้าง
    $("#obtTransferBchOutBrowseBch").click(function() {

        let tWhereCon = "";
        if (tUserLoginLevel != "HQ") {
            tWhereCon = " AND TCNMBranch.FTBchCode IN(<?php echo $this->session->userdata('tSesUsrBchCodeMulti'); ?>) ";
        }

        // option
        window.oTransferBchOutBrowseBch = {
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
                Condition: [tWhereCon]
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
                Value: ["oetTransferBchOutBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetTransferBchOutBchName", "TCNMBranch_L.FTBchName"]
            },
            /* NextFunc: {
                FuncName: 'JSxTransferBchOutCallbackBch',
                ArgReturn: ['FTBchCode']
            }, */
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oTransferBchOutBrowseBch');
    });

    // จากสาขา
    $("#obtTransferBchOutBrowseBchFrom").click(function() {

        let tWhereCon = "";
        if (tUserLoginLevel != "HQ") {
            tWhereCon = " AND TCNMBranch.FTBchCode IN(<?php echo $this->session->userdata('tSesUsrBchCodeMulti'); ?>) ";
        }

        // option
        window.oTransferBchOutBrowseBchFrom = {
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
                Condition: [
                    " AND TCNMBranch.FTBchCode NOT IN ('" + $('#oetTransferBchOutXthBchToCode').val() + "') ",
                    tWhereCon
                ]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FDCreateOn DESC'],
                // SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTransferBchOutXthBchFrmCode", "TCNMBranch.FTBchCode"],
                Text: ["oetTransferBchOutXthBchFrmName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxTransferBchOutCallbackBchFrom',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oTransferBchOutBrowseBchFrom');
    });

    // จากกลุ่มธุรกิจ
    $("#obtTransferBchOutBrowseMerFrom").click(function() {
        // option
        window.oTransferBchOutBrowseMerFrom = {
            Title: ['company/warehouse/warehouse', 'tWAHBwsMchTitle'],
            Table: {
                Master: 'TCNMMerchant',
                PK: 'FTMerCode'
            },
            Join: {
                Table: ['TCNMMerchant_L'],
                On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [""]
            },
            GrideView: {
                ColumnPathLang: 'company/warehouse/warehouse',
                ColumnKeyLang: ['tWAHBwsMchCode', 'tWAHBwsMchNme'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMMerchant.FDCreateOn DESC'],
                // SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTransferBchOutXthMerchantFrmCode", "TCNMMerchant.FTMerCode"],
                Text: ["oetTransferBchOutXthMerchantFrmName", "TCNMMerchant_L.FTMerName"],
            },
            NextFunc: {
                FuncName: 'JSxTransferBchOutCallbackMerFrom',
                ArgReturn: ['FTMerCode', 'FTMerName']
            },
            BrowseLev: 1,
            //DebugSQL : true
        };
        JCNxBrowseData('oTransferBchOutBrowseMerFrom');
    });

    // จากร้านค้า
    $("#obtTransferBchOutBrowseShpFrom").click(function() {
        // Option Shop
        window.oTransferBchOutBrowseShpFrom = {
            Title: ['company/shop/shop', 'tSHPTitle'],
            Table: {
                Master: 'TCNMShop',
                PK: 'FTShpCode'
            },
            Join: {
                Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
                On: [
                    'TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                    'TCNMWaHouse_L.FTWahCode = TCNMShop.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMShop.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits,
                ]
            },
            Where: {
                Condition: [
                    function() {
                        var tSQL = " AND TCNMShop.FTShpType = '1' AND TCNMShop.FTMerCode = '" + $('#oetTransferBchOutXthMerchantFrmCode').val() + "' AND TCNMShop.FTBchCode = '" + $('#oetTransferBchOutXthBchFrmCode').val() + "'";
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['25%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTShpType', 'TCNMShop.FTBchCode', 'TCNMShop.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['', '', '', '', '', ''],
                DisabledColumns: [2, 3, 4, 5],
                Perpage: 5,
                OrderBy: ['TCNMShop_L.FTShpName'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTransferBchOutXthShopFrmCode", "TCNMShop.FTShpCode"],
                Text: ["oetTransferBchOutXthShopFrmName", "TCNMShop_L.FTShpName"],
            },
            NextFunc: {
                FuncName: 'JSxTransferBchOutCallbackShpFrom',
                ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
            },
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oTransferBchOutBrowseShpFrom');
    });

    // จากคลังสินค้า
    $("#obtTransferBchOutBrowseWahFrom").click(function() {
        // Option
        var tShpFromCode = $('#oetTransferBchOutXthShopFrmCode').val();
        var bIsShpFromEmpty = (tShpFromCode === '') || (tShpFromCode == undefined);
        if (bIsShpFromEmpty) {
            window.oTransferBchOutBrowseWahFrom = {
                Title: ["company/warehouse/warehouse", "tWAHTitle"],
                Table: {
                    Master: 'TCNMWaHouse',
                    PK: 'FTWahCode'
                },
                Join: {
                    Table: ['TCNMWaHouse_L'],
                    On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits]
                },
                Where: {
                    Condition: [
                        function() {
                            // Last Update By : Napat(Jame) 31/07/2020
                            // เปลี่ยนจาก where FTWahRefCode เป็น FTBchCode แทน
                            var tSQL = " AND TCNMWaHouse.FTWahStaType IN('1', '2') AND TCNMWaHouse.FTWahStaPrcStk = '2' AND TCNMWaHouse.FTBchCode = '" + $('#oetTransferBchOutXthBchFrmCode').val() + "'";
                            return tSQL;
                        }
                    ]
                },
                GrideView: {
                    ColumnPathLang: 'company/warehouse/warehouse',
                    ColumnKeyLang: ['tWahCode', 'tWahName'],
                    ColumnsSize: ['25%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName', 'TCNMWaHouse.FTBchCode'],
                    DataColumnsFormat: ['', '', '', ''],
                    DisabledColumns: [2, 3],
                    Perpage: 10,
                    OrderBy: ['TCNMWaHouse.FDCreateOn DESC'],
                    // SourceOrder: "ASC"
                },
                CallBack: {
                    ReturnType: 'S',
                    Value: ["oetTransferBchOutXthWhFrmCode", "TCNMWaHouse.FTWahCode"],
                    Text: ["oetTransferBchOutXthWhFrmName", "TCNMWaHouse_L.FTWahName"],
                },
                NextFunc: {
                    FuncName: 'JSxTransferBchOutCallbackWahFrom',
                    ArgReturn: ['FTBchCode', 'FTWahCode', 'FTWahName']
                },
                BrowseLev: 1,
                // DebugSQL : true
            }
        } else {
            window.oTransferBchOutBrowseWahFrom = {
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
                    Condition: [
                        function() {
                            var tSQL = " AND TCNMShpWah.FTBchCode = '" + $('#oetTransferBchOutXthBchFrmCode').val() + "' AND TCNMShpWah.FTShpCode = '" + $('#oetTransferBchOutXthShopFrmCode').val() + "'";
                            return tSQL;
                        }
                    ]
                },
                GrideView: {
                    ColumnPathLang: 'company/shop/shop',
                    ColumnKeyLang: ['tWahCode', 'tWahName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMShpWah.FTWahCode', 'TCNMWaHouse_L.FTWahName', 'TCNMShpWah.FTBchCode'],
                    DataColumnsFormat: ['', ''],
                    Perpage: 10,
                    OrderBy: ['TCNMShpWah.FDCreateOn DESC'],
                    // SourceOrder  : "ASC"
                },
                CallBack: {
                    ReturnType: 'S',
                    Value: ["oetTransferBchOutXthWhFrmCode", "TCNMShpWah.FTWahCode"],
                    Text: ["oetTransferBchOutXthWhFrmName", "TCNMWaHouse_L.FTWahName"],
                },
                NextFunc: {
                    FuncName: 'JSxTransferBchOutCallbackWahFrom',
                    ArgReturn: ['FTBchCode', 'FTWahCode', 'FTWahName']
                },
                BrowseLev: 1,
                // DebugSQL : true
            }
        }
        JCNxBrowseData('oTransferBchOutBrowseWahFrom');
    });

    // ถึงสาขา
    $("#obtTransferBchOutBrowseBchTo").click(function() {

        var tSesUsrAgnCode = "<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>";
        let tWhereCon = "";
        // if(tUserLoginLevel != "HQ"){
        //     tWhereCon = " AND TCNMBranch.FTBchCode IN(<?php echo $this->session->userdata('tSesUsrBchCodeMulti'); ?>) ";
        // }
        if (tSesUsrAgnCode != "") {
            tWhereCon += " AND TCNMBranch.FTAgnCode ='" + tSesUsrAgnCode + "' ";
        }
        // option
        window.oTransferBchOutBrowseBchTo = {
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
                Condition: [
                    " AND TCNMBranch.FTBchCode NOT IN ('" + $('#oetTransferBchOutXthBchFrmCode').val() + "')",
                    tWhereCon
                ]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FDCreateOn DESC'],
                // SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTransferBchOutXthBchToCode", "TCNMBranch.FTBchCode"],
                Text: ["oetTransferBchOutXthBchToName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxTransferBchOutCallbackBchTo',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oTransferBchOutBrowseBchTo');
    });

    // ถึงคลังสินค้า
    $("#obtTransferBchOutBrowseWahTo").click(function() {
        // Option
        window.oTransferBchOutBrowseWahTo = {
            Title: ["company/warehouse/warehouse", "tWAHTitle"],
            Table: {
                Master: 'TCNMWaHouse',
                PK: 'FTWahCode'
            },
            Join: {
                Table: ['TCNMWaHouse_L'],
                On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    function() {
                        // Last Update By : Napat(Jame) 31/07/2020
                        // เปลี่ยนจาก where FTWahRefCode เป็น FTBchCode แทน
                        var tSQL = " AND TCNMWaHouse.FTWahStaType IN('1', '2') AND TCNMWaHouse.FTBchCode = '" + $('#oetTransferBchOutXthBchToCode').val() + "'";
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'company/warehouse/warehouse',
                ColumnKeyLang: ['tWahCode', 'tWahName'],
                ColumnsSize: ['25%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName', 'TCNMWaHouse.FTBchCode'],
                DataColumnsFormat: ['', '', '', ''],
                DisabledColumns: [2, 3],
                Perpage: 10,
                OrderBy: ['TCNMWaHouse.FDCreateOn DESC'],
                // SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTransferBchOutXthWhToCode", "TCNMWaHouse.FTWahCode"],
                Text: ["oetTransferBchOutXthWhToName", "TCNMWaHouse_L.FTWahName"],
            },
            NextFunc: {
                FuncName: 'JSxTransferBchOutCallbackWahTo',
                ArgReturn: ['FTBchCode', 'FTWahCode', 'FTWahName']
            },
            BrowseLev: 1
        }
        JCNxBrowseData('oTransferBchOutBrowseWahTo');
    });

    // เหตุผล
    $("#obtTransferBchOutBrowseReason").click(function() {
        // Option
        window.oTransferBchOutBrowseReason = {
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
                Value: ['oetTransferBchOutRsnCode', "TCNMRsn.FTRsnCode"],
                Text: ['oetTransferBchOutRsnName', "TCNMRsn_L.FTRsnName"]
            }
        }
        JCNxBrowseData('oTransferBchOutBrowseReason');
    });

    // ขนส่ง
    $("#obtTransferBchOutBrowseShipVia").click(function() {
        // Option
        window.oTransferBchOutBrowseShipVia = {
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
        JCNxBrowseData('oTransferBchOutBrowseShipVia');
    });
    /*===== End Event Browse ===========================================================*/

    /*===== Begin Callback Browse ======================================================*/
    // Browse Bch From Callback
    function JSxTransferBchOutCallbackBchFrom(params) {
        var tBchCodeFrom = $('#oetTransferBchOutXthBchFrmCode').val();

        // ต้นทาง
        $('#oetTransferBchOutXthMerchantFrmCode').val("");
        $('#oetTransferBchOutXthMerchantFrmName').val("");
        $('#oetTransferBchOutXthShopFrmCode').val("");
        $('#oetTransferBchOutXthShopFrmName').val("");
        $('#oetTransferBchOutXthWhFrmCode').val("");
        $('#oetTransferBchOutXthWhFrmName').val("");
        // ปลายทาง
        $('#oetTransferBchOutXthBchToCode').val("");
        $('#oetTransferBchOutXthBchToName').val("");
        $('#oetTransferBchOutXthWhToCode').val("");
        $('#oetTransferBchOutXthWhToName').val("");

        // ต้นทาง
        $('#obtTransferBchOutBrowseMerFrom').attr('disabled', true);
        $('#obtTransferBchOutBrowseShpFrom').attr('disabled', true);
        $('#obtTransferBchOutBrowseWahFrom').attr('disabled', true);
        // ปลายทาง
        $('#obtTransferBchOutBrowseBchTo').attr('disabled', true);
        $('#obtTransferBchOutBrowseWahTo').attr('disabled', true);

        if (tBchCodeFrom != "") {
            $('#obtTransferBchOutBrowseMerFrom').attr('disabled', false);
        }

        if (tUserLoginLevel == "HQ" || tUserLoginLevel == "BCH") {
            $('#obtTransferBchOutBrowseWahFrom').attr('disabled', false);
            if (tBchCodeFrom == "") {
                $('#obtTransferBchOutBrowseWahFrom').attr('disabled', true);
            }
        }

    }

    // Browse Mer From Callback
    function JSxTransferBchOutCallbackMerFrom(params) {
        var tMerCodeFrom = $('#oetTransferBchOutXthMerchantFrmCode').val();

        // ต้นทาง
        $('#oetTransferBchOutXthShopFrmCode').val("");
        $('#oetTransferBchOutXthShopFrmName').val("");
        $('#oetTransferBchOutXthWhFrmCode').val("");
        $('#oetTransferBchOutXthWhFrmName').val("");
        // ปลายทาง
        $('#oetTransferBchOutXthBchToCode').val("");
        $('#oetTransferBchOutXthBchToName').val("");
        $('#oetTransferBchOutXthWhToCode').val("");
        $('#oetTransferBchOutXthWhToName').val("");

        // ต้นทาง
        $('#obtTransferBchOutBrowseShpFrom').attr('disabled', true);
        $('#obtTransferBchOutBrowseWahFrom').attr('disabled', true);
        // ปลายทาง
        $('#obtTransferBchOutBrowseBchTo').attr('disabled', true);
        $('#obtTransferBchOutBrowseWahTo').attr('disabled', true);

        if (tMerCodeFrom != "") {
            $('#obtTransferBchOutBrowseShpFrom').attr('disabled', false);
        }

        if (tUserLoginLevel == "HQ" || tUserLoginLevel == "BCH") {
            $('#obtTransferBchOutBrowseWahFrom').attr('disabled', false);
        }
    }

    // Browse Shop From Callback
    function JSxTransferBchOutCallbackShpFrom(params) {
        var aParam = JSON.parse(params);
        $('#oetTransferBchOutWahInShopCode').val(aParam[3]);

        var tShpCodeFrom = $('#oetTransferBchOutXthShopFrmCode').val();

        // ต้นทาง
        $('#oetTransferBchOutXthWhFrmCode').val("");
        $('#oetTransferBchOutXthWhFrmName').val("");
        // ปลายทาง
        $('#oetTransferBchOutXthBchToCode').val("");
        $('#oetTransferBchOutXthBchToName').val("");
        $('#oetTransferBchOutXthWhToCode').val("");
        $('#oetTransferBchOutXthWhToName').val("");

        // ต้นทาง
        $('#obtTransferBchOutBrowseWahFrom').attr('disabled', true);
        // ปลายทาง
        $('#obtTransferBchOutBrowseBchTo').attr('disabled', true);
        $('#obtTransferBchOutBrowseWahTo').attr('disabled', true);

        if (tShpCodeFrom != "") {
            $('#obtTransferBchOutBrowseWahFrom').attr('disabled', false);
        }

        if (tUserLoginLevel == "HQ" || tUserLoginLevel == "BCH") {
            $('#obtTransferBchOutBrowseWahFrom').attr('disabled', false);
        }
    }

    // Browse Warehouse From Callback
    function JSxTransferBchOutCallbackWahFrom(params) {
        var tWahCodeFrom = $('#oetTransferBchOutXthWhFrmCode').val();
        var tBchCodeTo = $('#oetTransferBchOutXthBchToCode').val();
        var tWahCodeTo = $('#oetTransferBchOutXthWhToCode').val();

        // ปลายทาง
        $('#obtTransferBchOutBrowseBchTo').attr('disabled', true);
        $('#obtTransferBchOutBrowseWahTo').attr('disabled', true);

        if (tWahCodeFrom != "") {
            $('#obtTransferBchOutBrowseBchTo').attr('disabled', false);
            if (tBchCodeTo != "") {
                $('#obtTransferBchOutBrowseWahTo').attr('disabled', false);
            }
        } else {
            $('#oetTransferBchOutXthBchToCode').val("");
            $('#oetTransferBchOutXthBchToName').val("");
            $('#oetTransferBchOutXthWhToCode').val("");
            $('#oetTransferBchOutXthWhToName').val("");
        }
    }

    // Browse Bch To Callback
    function JSxTransferBchOutCallbackBchTo(params) {
        var tBchCodeTo = $('#oetTransferBchOutXthBchToCode').val();

        // ปลายทาง
        $('#oetTransferBchOutXthWhToCode').val("");
        $('#oetTransferBchOutXthWhToName').val("");

        // ปลายทาง
        $('#obtTransferBchOutBrowseWahTo').attr('disabled', true);

        if (tBchCodeTo != "") {
            $('#obtTransferBchOutBrowseWahTo').attr('disabled', false);
        }
    }

    // Browse Warehouse To Callback
    function JSxTransferBchOutCallbackWahTo(params) {}
    /*===== End Callback Browse ========================================================*/

    var bUniqueTransferBchOutCode;
    $.validator.addMethod(
        "uniqueTransferBchOutCode",
        function(tValue, oElement, aParams) {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {

                var tTransferBchOutCode = tValue;
                $.ajax({
                    type: "POST",
                    url: "docTransferBchOutUniqueValidate",
                    data: "tTransferBchOutCode=" + tTransferBchOutCode,
                    dataType: "JSON",
                    success: function(poResponse) {
                        bUniqueTransferBchOutCode = (poResponse.bStatus) ? false : true;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Custom validate uniqueTransferBchOutCode: ', jqXHR, textStatus, errorThrown);
                    },
                    async: false
                });
                return bUniqueTransferBchOutCode;

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
    function JSxTransferBchOutValidateForm() {
        var oTopUpVendingForm = $('#ofmTransferBchOutForm').validate({
            focusInvalid: false,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetTransferBchOutDocNo: {
                    required: true,
                    maxlength: 20,
                    uniqueTransferBchOutCode: bIsAddPage
                },
                oetTransferBchOutDocDate: {
                    required: true
                },
                oetTransferBchOutDocTime: {
                    required: true
                },
                /* oetTransferBchOutXthBchFrmName: {
                    required: true
                },
                oetTransferBchOutXthMerchantFrmName: {
                    required: true
                },
                oetTransferBchOutXthShopFrmName: {
                    required: true
                },
                oetTransferBchOutXthWhFrmName: {
                    required: true
                },
                oetTransferBchOutXthBchToName: {
                    required: true
                },
                oetTransferBchOutXthWhToName: {
                    required: true
                } */
            },
            messages: {
                oetTransferBchOutDocNo: {
                    "required": $('#oetTransferBchOutDocNo').attr('data-validate-required')
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
                JSxTransferBchOutSave();
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
    function JSxTransferBchOutSave() {
        var bIsWahFromEmpty = $('#oetTransferBchOutXthWhFrmCode').val() == "";
        var bIsWahToEmpty = $('#oetTransferBchOutXthWhToCode').val() == "";
        if (bIsWahFromEmpty || bIsWahToEmpty) {
            var tWarningMessage = 'กรุณาตรวจสอบข้อมูล เงื่อนไข ก่อนบันทึก';
            FSvCMNSetMsgWarningDialog(tWarningMessage);
            return;
        }

        var bIsPdtEmpty = $('#otbTransferBchOutPdtTable').find('tr.xWTransferBchOutPdtItem').length < 1;
        if (bIsPdtEmpty) {
            var tWarningMessage = 'กรุณาเพิ่มรายการสินค้า ก่อนบันทึก';
            FSvCMNSetMsgWarningDialog(tWarningMessage);
            return;
        }

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTransferBchOutBchCode').val();
            var tMerCode = $('#oetTransferBchOutMchCode').val();
            var tShpCode = $('#oetTransferBchOutShpCode').val();
            var tPosCode = $('#oetTransferBchOutPosCode').val();
            var tWahCode = $('#oetTransferBchOutWahCode').val();

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "<?php echo $tRoute; ?>",
                data: $("#ofmTransferBchOutForm").serialize(),
                cache: false,
                timeout: 5000,
                dataType: "JSON",
                success: function(oResult) {

                    let oTBOCallDataTableFile = {
                        ptElementID : 'odvTBOShowDataTable',
                        ptBchCode   : $('#oetTransferBchOutBchCode').val(),
                        ptDocNo     : oResult.tCodeReturn,
                        ptDocKey    :'TCNTPdtTboHD',
                    }
                    JCNxUPFInsertDataFile(oTBOCallDataTableFile);

                    switch (oResult.nStaCallBack) {
                        case "1": {
                            JSvTransferBchOutCallPageEdit(oResult.tCodeReturn);
                            break;
                        }
                        case "2": {
                            JSvTransferBchOutCallPageAdd();
                            break;
                        }
                        case "3": {
                            JSvTransferBchOutCallPageList();
                            break;
                        }
                        default: {
                            JSvTransferBchOutCallPageEdit(oResult.tCodeReturn);
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

    // ตรวจสอบจำนวนสินค้า กรณีจัดสินค้า
    function JSxTBOChkPdtB4Apv(pbIsConfirm) {

        var bIsWahFromEmpty = $('#oetTransferBchOutXthWhFrmCode').val() == "";
        var bIsWahToEmpty = $('#oetTransferBchOutXthWhToCode').val() == "";
        if (bIsWahFromEmpty || bIsWahToEmpty) {
            var tWarningMessage = 'กรุณาตรวจสอบข้อมูล เงื่อนไข ก่อนอนุมัติ';
            FSvCMNSetMsgWarningDialog(tWarningMessage);
            return;
        }

        var bIsPdtEmpty = $('#otbTransferBchOutPdtTable').find('tr.xWTransferBchOutPdtItem').length < 1;
        if (bIsPdtEmpty) {
            var tWarningMessage = 'กรุณาเพิ่มรายการสินค้า ก่อนอนุมัติ';
            FSvCMNSetMsgWarningDialog(tWarningMessage);
            return;
        }

        var tStaPrcDoc = $('#ohdTBOStaPrcDoc').val();
        if( tStaPrcDoc != "" && tStaPrcDoc != "4" ){
            FSvCMNSetMsgWarningDialog('ไม่สามารถอนุมัติได้ ต้องอนุมัติใบจัดสินค้าให้ครบถ้วน');
            return;
        }

        // ถ้าไม่สร้างใบจัดสินค้า อนุมัติได้เลยไม่ต้องตรวจสอบจำนวนสินค้า
        if( tStaPrcDoc == "" ){
            JSxTransferBchOutChkStkB4ApvDoc(pbIsConfirm);
            return;
        }

        $.ajax({
            type: "POST",
            url: "docTBOEventChkPdtB4Apv",
            data: {
                ptDocNo      : $("#oetTransferBchOutDocNo").val()
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aResult = JSON.parse(oResult);
                // console.log(aResult);
                if( aResult['nStaEvent'] == "1" ){
                    JSxTransferBchOutChkStkB4ApvDoc(pbIsConfirm);
                }else{
                    FSvCMNSetMsgWarningDialog(aResult['tStaMessg'],'JSxTransferBchOutChkStkB4ApvDoc','',true);
                    JCNxCloseLoading();
                    return;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

    // Create By: Napat(Jame) 23/06/2022
    async function JSxTransferBchOutChkStkB4ApvDoc(pbIsConfirm){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            // if (pbIsConfirm) {
                
                $("#odvTransferBchOutPopupApv").modal("hide");
                var aParams = {
                    'tBchCode'  : $('#oetTransferBchOutXthBchFrmCode').val(),
                    'tWahCode'  : $('#oetTransferBchOutXthWhFrmCode').val(),
                    'tDocNo'    : $('#oetTransferBchOutDocNo').val(),
                    'tTableHD'  : 'TCNTPdtTboHD',
                    'tTableDT'  : 'TCNTPdtTboDT',
                    'tNextFunc' : 'JSvTransferBchOutApprove'
                };
                var aChkStkB4ApvDoc = await JCNaChkStkB4ApvDoc(aParams);
                if( aChkStkB4ApvDoc['nStaEvent'] == 1 ){
                    return;
                }else{
                    // JSvTransferBchOutApprove();
                    $("#odvTransferBchOutPopupApv").modal("show");
                }

            // } else {
            //     $("#odvTransferBchOutPopupApv").modal("show");
            // }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Approve Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Last Update: Napat(Jame) 23/06/2022 เพิ่มการเช็คสต๊อกก่อน ค่อยอนุมัติ
     * Return : -
     * Return Type : -
     */
    function JSvTransferBchOutApprove(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                if (pbIsConfirm) {

                    $("#odvTransferBchOutPopupApv").modal("hide");

                    // var aParams = {
                    //     'tBchCode'  : $('#oetTransferBchOutXthBchFrmCode').val(),
                    //     'tWahCode'  : $('#oetTransferBchOutXthWhFrmCode').val(),
                    //     'tDocNo'    : $('#oetTransferBchOutDocNo').val(),
                    //     'tTableHD'  : 'TCNTPdtTboHD',
                    //     'tTableDT'  : 'TCNTPdtTboDT',
                    //     'tNextFunc' : 'JSvTransferBchOutApprove'
                    // };
                    // var aChkStkB4ApvDoc = await JCNaChkStkB4ApvDoc(aParams);
                    // if( aChkStkB4ApvDoc['nStaEvent'] == 1 ){
                    //     return;
                    // }

                    JCNxOpenLoading();
                    $("#ohdTransferBchOutStaApv").val(2); // Set status for processing approve
                    

                    var tDocNo = $("#oetTransferBchOutDocNo").val();
                    var tStaApv = $("#ohdTransferBchOutStaApv").val();
                    var tBchCode = $('#oetTransferBchOutBchCode').val(); //$('#ohdTransferBchOutBchLogin').val();

                    $.ajax({
                        type: "POST",
                        url: "docTransferBchOutDocApprove",
                        data: {
                            tDocNo: tDocNo,
                            tStaApv: tStaApv,
                            tBchCode: tBchCode
                        },
                        cache: false,
                        timeout: 0,
                        success: function(oResult) {
                            // console.log(oResult);
                            if (oResult.nStaEvent == "900") {
                                FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                JCNxCloseLoading();
                                return;
                            }
                            JCNxCloseLoading();
                            JSoTransferBchOutSubscribeMQ();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                            JCNxCloseLoading();
                        }
                    });
                } else {
                    // console.log("StaApvDoc Call Modal");
                    $("#odvTransferBchOutPopupApv").modal("show");
                }
            } catch (err) {
                console.log("JSvTransferBchOutApprove Error: ", err);
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
    function JSvTransferBchOutCancel(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tStaPrcDoc = $('#ohdTBOStaPrcDoc').val();
            if( tStaPrcDoc != "" && tStaPrcDoc != "1" ){
                FSvCMNSetMsgWarningDialog('ไม่สามารถยกเลิกได้ มีใบจัดสินค้าที่ยังค้างอยู่');
                return false;
            }

            var tDocNo = $("#oetTransferBchOutDocNo").val();
            if (pbIsConfirm) {
                $.ajax({
                    type: "POST",
                    url: "docTransferBchOutDocCancel",
                    data: {
                        tDocNo: tDocNo
                    },
                    cache: false,
                    timeout: 5000,
                    success: function(tResult) {
                        $("#odvTransferBchOutPopupCancel").modal("hide");

                        var aResult = $.parseJSON(tResult);
                        if (aResult.nSta == 1) {
                            JSvTransferBchOutCallPageEdit(tDocNo);
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
                $('#obtTBOShwBtnCancel').show();
                $('#obtTBOShwBtnCancelOnApv').hide();
                $("#odvTransferBchOutPopupCancel").modal("show");
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    // Create By : Napat(Jame) 21/01/2022
    function JSxTBOCancelOnApv(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tDocNo = $("#oetTransferBchOutDocNo").val();
            if (pbIsConfirm) {
                $.ajax({
                    type: "POST",
                    url: "docTBOCancelOnApv",
                    data: {
                        ptDocNo     : tDocNo,
                        ptBchCode   : $('#oetTransferBchOutBchCode').val()
                    },
                    cache: false,
                    timeout: 5000,
                    success: function(oResult) {
                        $("#odvTransferBchOutPopupCancel").modal("hide");
                        JCNxCloseLoading();

                        var aResult = JSON.parse(oResult);
                        if( aResult['nStaEvent'] == 1 ){
                            setTimeout(function(){
                                JSxTBOSubscribeMQCancelOnApv();
                            }, 500);
                        }else{
                            setTimeout(function(){
                                var tMessageError = aResult['tStaMessg'];
                                FSvCMNSetMsgErrorDialog(tMessageError);
                            }, 500);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $('#obtTBOShwBtnCancel').hide();
                $('#obtTBOShwBtnCancelOnApv').show();
                $("#odvTransferBchOutPopupCancel").modal("show");
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
    function JSoTransferBchOutSubscribeMQ() {
        // RabbitMQ
        /*===========================================================================*/
        // Document variable
        var tLangCode = $("#ohdLangEdit").val();
        var tUsrBchCode = $("#ohdTransferBchOutBchLogin").val();
        var tUsrApv = $("#oetTransferBchOutApvCodeUsrLogin").val();
        var tDocNo = $("#oetTransferBchOutDocNo").val();
        var tPrefix = "RESTBO";
        var tStaApv = $("#ohdTransferBchOutStaApv").val();
        var tStaDelMQ = $("#ohdTransferBchOutStaDelMQ").val();
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
            ptDocTableName: "TCNTPdtTboHD",
            ptDocFieldDocNo: "FTXthDocNo",
            ptDocFieldStaApv: "FTXthStaPrcStk",
            ptDocFieldStaDelMQ: "FTXthStaDelMQ",
            ptDocStaDelMQ: tStaDelMQ,
            ptDocNo: tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: "JSvTransferBchOutCallPageEdit",
            tCallPageList: "JSvTransferBchOutCallPageList"
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
                url: "docTransferBchOutGetPdtInTmp",
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
                    ptDocNo         : $('#oetTransferBchOutDocNo').val()
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    JSxTransferBchOutSetEndOfBill(oResult.aEndOfBill);
                    $('#odvTransferBchOutPdtDataTable').html(oResult.html);
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
     * Functionality : Imsert Pdt to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvTransferBchOutInsertPdtToTemp(ptPdtData) {
        console.log('poParams: ', ptPdtData);

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tTransferBchOutOptionAddPdt = $('#ocmTransferBchOutOptionAddPdt').val();

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "docTransferBchOutInsertPdtToTmp",
                data: {
                    tPdtData: ptPdtData,
                    ptBchCode: $('#oetTransferBchOutBchCode').val(),
                    tTransferBchOutOptionAddPdt: tTransferBchOutOptionAddPdt
                },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    JSxTransferBchOutGetPdtInTmp(1, true);
                    $('#odvTransferBchOutPopupPdtAdd').modal('hide');
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
     * Functionality : Clear Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvTransferBchOutClearPdtInTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "docTransferBchOutClearPdtInTmp",
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    JSxTransferBchOutGetPdtInTmp(1, true);
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
     * Functionality : Pdt Column Control
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutPdtColumnControl() {
        $("#odvTransferBchOutPdtColumnControlPanel").modal('show');
        $.ajax({
            type: "POST",
            url: "docTransferBchOutGetPdtColumnList",
            data: {},
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                $("#odvTransferBchOutPdtColummControlDetail").html(tResult);
                // JSCNAdjustTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : Update Pdt Column
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutUpdatePdtColumn() {
        var aColShowSet = [];
        $(".ocbTransferBchOutPdtColStaShow:checked").each(function() {
            aColShowSet.push($(this).data("id"));
        });

        var aColShowAllList = [];
        $(".ocbTransferBchOutPdtColStaShow").each(function() {
            aColShowAllList.push($(this).data("id"));
        });

        var aColumnLabelName = [];
        $(".olbTransferBchOutColumnLabelName").each(function() {
            aColumnLabelName.push($(this).text());
        });

        var nStaSetDef;
        if ($("#ocbSetToDef").is(":checked")) {
            nStaSetDef = 1;
        } else {
            nStaSetDef = 0;
        }

        $.ajax({
            type: "POST",
            url: "docTransferBchOutUpdatePdtColumn",
            data: {
                aColShowSet: aColShowSet,
                nStaSetDef: nStaSetDef,
                aColShowAllList: aColShowAllList,
                aColumnLabelName: aColumnLabelName
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                $("#odvTransferBchOutPdtColumnControlPanel").modal("hide");
                JSxTransferBchOutGetPdtInTmp(1, true);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : Browse Pdt
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JCNvTransferBchOutBrowsePdt() {

        var bIsWahFromEmpty = $('#oetTransferBchOutXthWhFrmCode').val() == "";
        var bIsWahToEmpty = $('#oetTransferBchOutXthWhToCode').val() == "";
        if (bIsWahFromEmpty || bIsWahToEmpty) {
            var tWarningMessage = 'กรุณาตรวจสอบข้อมูล เงื่อนไข ก่อนเพิ่มรายการสินค้า';
            FSvCMNSetMsgWarningDialog(tWarningMessage);
            return;
        }

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var oBrowsePdtSettings = {
                Qualitysearch: [
                    "NAMEPDT",
                    "CODEPDT"
                ],
                PriceType: ["Cost", "tCN_Cost", "Company", "1"],
                //'PriceType'       : ['Pricesell'],
                //'SelectTier'      : ['PDT'],
                SelectTier: ["Barcode"],
                //'Elementreturn'   : ['oetInputTestValue','oetInputTestName'],
                ShowCountRecord: 10,
                NextFunc: "JSvTransferBchOutInsertPdtToTemp",
                ReturnType: "M",
                SPL: ["", ""],
                BCH: [$("#oetTransferBchOutXthBchFrmCode").val(), $("#oetTransferBchOutXthBchFrmCode").val()],
                MER: [$('#oetTransferBchOutXthMerchantFrmCode').val(), $('#oetTransferBchOutXthMerchantFrmCode').val()],
                SHP: [$('#oetTransferBchOutXthShopFrmCode').val(), $('#oetTransferBchOutXthShopFrmCode').val()],
                'aAlwPdtType' : ['T1','T3','T4','T5','T6','S2','S3','S4']
            }

            var tMerFromCode = $('#oetTransferBchOutXthMerchantFrmCode').val();
            var bIsMerFromEmpty = (tMerFromCode === '') || (tMerFromCode == undefined);
            if (bIsMerFromEmpty) {
                delete oBrowsePdtSettings.MER;
            }
            var tShpFromCode = $('#oetTransferBchOutXthShopFrmCode').val();
            var bIsShpFromEmpty = (tShpFromCode === '') || (tShpFromCode == undefined);
            if (bIsShpFromEmpty) {
                delete oBrowsePdtSettings.SHP;
            }

            $.ajax({
                type: "POST",
                url: "BrowseDataPDT",
                data: oBrowsePdtSettings,
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    // $(".modal.fade:not(#odvTBBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTBPopupApv,#odvModalDelPdtTB)").remove();
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
                },
                error: function(data) {
                    console.log(data);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Display End Of Bill Calc
     * Parameters : poParams
     * Creator : 04/02/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutSetEndOfBill(poParams) {

    }

    //ปริ้นเอกสาร ใบจ่ายโอน - สาขา
    function JSxTransferBchOutPrintDoc() {
        var aInfor = [{
                "Lang": '<?= FCNaHGetLangEdit(); ?>'
            }, // Lang ID
            {
                "ComCode": '<?= FCNtGetCompanyCode(); ?>'
            }, // Company Code
            {
                "BranchCode": '<?= FCNtGetAddressBranch($tBchCode); ?>'
            }, // สาขาที่ออกเอกสาร
            {
                "DocCode": $('#oetTransferBchOutDocNo').val()
            },
            {
                "DocBchCode": '<?= $tBchCode ?>'
            } // เลขที่เอกสาร
        ];
        window.open("<?= base_url(); ?>formreport/Frm_SQL_ALLMPdtBillTnfOutBch?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

    $(document).ready(function(){

        //อ้างอิงเอกสาร
        JSxTBOCallPageHDDocRef();
        JSxTBOEventCheckShowHDDocRef();
    });

    //โหลด Table อ้างอิงเอกสารทั้งหมด
    function JSxTBOCallPageHDDocRef(){
        $.ajax({
            type    : "POST",
            url     : "docTBOPageHDDocRef",
            data:{
                'ptDocNo'       : $('#oetTransferBchOutDocNo').val(),
                'ptStaApv'      : $('#ohdTransferBchOutStaApv').val(),
                'ptStaPrcDoc'   : $('#ohdTBOStaPrcDoc').val()
            },
            cache   : false,
            timeout : 0,
            success: function(oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == 1 ){
                    $('#odvTBOTableHDRef').html(aResult['tViewPageHDRef']);
                    JCNxCloseLoading();
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

    //กดเพิ่มเอกสารอ้างอิง (ภายใน ภายนอก)
    $('#obtTBOAddDocRef').off('click').on('click',function(){
        $('#ofmTBOFormAddDocRef').validate().destroy();
        JSxTBOEventClearValueInFormHDDocRef();
        $('#odvTBOModalAddDocRef').modal('show');
    });

    //เคลียร์ค่า
    function JSxTBOEventClearValueInFormHDDocRef(){
        $('#oetTBORefDocNo').val('');
        $('#oetTBORefDocDate').val('');
        $('#oetTBODocRefInt').val('');
        $('#oetTBODocRefIntName').val('');
        $('#oetTBORefKey').val('');
    }

    //Default โชว์ panel ตามประเภท (ภายใน หรือ ภายนอก)
    function JSxTBOEventCheckShowHDDocRef(){
        var tTBORefType = $('#ocbTBORefType').val();
        if( tTBORefType == '1' ){
            $('.xWShowRefExt').hide();
            $('.xWShowRefInt').show();
        }else{
            $('.xWShowRefInt').hide();
            $('.xWShowRefExt').show();
        }
    }

    //เมื่อเปลี่ยน ประเภท (ภายใน หรือ ภายนอก)
    $('#ocbTBORefType').off('change').on('change',function(){
        $(this).selectpicker('refresh');
        JSxTBOEventCheckShowHDDocRef();
    });

    //กดเลือกอ้างอิงเอกสารภายใน (ใบขอโอน - สาขา)
    $('#obtTBOBrowseRefDoc').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCallPageTransferBchOutRefIntDoc();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //กดยืนยันบันทึกลง Temp
    $('#ofmTBOFormAddDocRef').off('click').on('click',function(){
        $('#ofmTBOFormAddDocRef').validate().destroy();
        $('#ofmTBOFormAddDocRef').validate({
            focusInvalid    : false,
            onclick         : false,
            onfocusout      : false,
            onkeyup         : false,
            rules           : {
                oetTBORefDocNo      : {
                    "required" : {
                        depends: function(oElement){
                            if( $('#ocbTBORefType').val() == '3' ){
                                return true;
                            }else{
                                return false;

                            }
                        }
                    },
                },
                oetTBODocRefIntName : {
                    "required" : {
                        depends: function(oElement){
                            if( $('#ocbTBORefType').val() == '1' ){
                                return true;
                            }else{
                                return false;

                            }
                        }
                    },
                },
                oetTBORefDocDate    : { "required" : true },
            },
            messages: {
                oetTBORefDocNo      : {"required" : 'กรุณากรอกเลขที่เอกสารอ้างอิง'},
                oetTBORefDocDate    : {"required" : 'กรุณากรอกวันที่เอกสารอ้างอิง'},
                oetTBODocRefIntName : {"required" : 'กรุณาเลือกเลขที่เอกสารอ้างอิง'},
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

                if($('#ocbTBORefType').val() == 1){         //อ้างอิงเอกสารภายใน
                    var tDocNoRef   = $('#oetTBODocRefInt').val();
                    var tDocRefKey  = 'TRB';
                }else{                                      //อ้างอิงเอกสารภายนอก
                    var tDocNoRef   = $('#oetTBORefDocNo').val();
                    var tDocRefKey  = $('#oetTBORefKey').val();
                }

                $.ajax({
                    type    : "POST",
                    url     : "docTBOEventAddEditHDDocRef",
                    data    : {
                        'ptRefDocNoOld'     : $('#oetTBORefDocNoOld').val(),
                        'ptDocNo'           : $('#oetTransferBchOutDocNo').val(),
                        'ptRefType'         : $('#ocbTBORefType').val(),
                        'ptRefDocNo'        : tDocNoRef,
                        'pdRefDocDate'      : $('#oetTBORefDocDate').val(),
                        'ptRefKey'          : tDocRefKey
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult){

                        JSxTBOEventClearValueInFormHDDocRef();
                        $('#odvTBOModalAddDocRef').modal('hide');

                        JSxTBOCallPageHDDocRef();

                        if( $('#ocbTBORefType').val() == 1 ){   //อ้างอิงเอกสารภายใน

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


                            $('#obtTransferBchOutBrowseBchFrom').attr('disabled',false);
                            $('#obtTransferBchOutBrowseWahFrom').attr('disabled',false);
                            $('#oetTransferBchOutXthBchFrmCode').val(tBchFrm);
                            $('#oetTransferBchOutXthBchFrmName').val(tBchNameFrm);
                            $('#oetTransferBchOutXthWhFrmCode').val(tWahFrm);
                            $('#oetTransferBchOutXthWhFrmName').val(tWahNameFrm);

                            $('#obtTransferBchOutBrowseBchTo').attr('disabled',false);
                            $('#obtTransferBchOutBrowseWahTo').attr('disabled',false);
                            $('#oetTransferBchOutXthBchToCode').val(tBchTo);
                            $('#oetTransferBchOutXthBchToName').val(tBchNameTo);
                            $('#oetTransferBchOutXthWhToCode').val(tWahTo);
                            $('#oetTransferBchOutXthWhToName').val(tWahNameTo);






                            // var poParams = {
                            // 	FTSplCode           : tSplCode,
                            // 	FTSplName           : tSplName,
                            // 	FTSplStaVATInOrEx   : tSplStaVATInOrEx,
                            // 	FTRefIntDocNo       : tRefIntDocNo,
                            // 	FTRefIntDocDate     : tRefIntDocDate,
                            // 	FNXphCrTerm         : nSplCrTerm
                            // };

                            JCNxOpenLoading();
                            $.ajax({
                            	type    : "POST",
                            	url     : "docTransferBchOutRefIntDocInsertDTToTemp",
                            	data    : {
                            		'tTransferBchOutDocNo'          : $('#oetTransferBchOutDocNo').val(),
                            		'tTransferBchOutFrmBchCode'     : $('#oetTransferBchOutBchCode').val(),
                            		'tRefIntDocNo'      			: tRefIntDocNo,
                            		'tRefIntBchCode'    			: tRefIntBchCode,
                            		'tSplStaVATInOrEx'  			: tSplStaVATInOrEx,
                            		'aSeqNo'            			: aSeqNo
                            	},
                            	cache: false,
                            	Timeout: 0,
                            	success: function (oResult){
                            		//โหลดสินค้าใน Temp
                            		JSxTransferBchOutGetPdtInTmp();
                            		// JCNxCloseLoading();
                            	},
                            	error: function (jqXHR, textStatus, errorThrown) {
                            		JCNxResponseError(jqXHR, textStatus, errorThrown);
                            	}
                            });

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

    $(document).on('show.bs.modal', '.modal', function() {
        const zIndex = 1040 + 10 * $('.modal:visible').length;
        $(this).css('z-index', zIndex);
        setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
    });


    var tStaPrcDoc = $('#ohdTBOStaPrcDoc').val();
    if( tStaPrcDoc != "" ){                                             // ต้องตรวจสอบสถานะใบจัด
        if( !bIsApvOrCancel ){
            $('#obtTBOGenPacking').show();
            if( tStaPrcDoc == '1' ){
                $('form .xCNApvOrCanCelDisabled').attr('disabled', false);  // ยังไม่กดสร้างใบจัดสินค้า สามารถแก้ไข input/product ได้อยู่
                $('.xCNHideWhenCancelOrApprove').show();

            }else{
                $('form .xCNApvOrCanCelDisabled').attr('disabled', true);   // สร้างใบจัดสินค้าแล้ว ไม่สามารถแก้ไข input/product ได้
                $('.xCNHideWhenCancelOrApprove').hide();
            }
        }else{
            $('#obtTBOGenPacking').hide();
            $('.xCNHideWhenCancelOrApprove').hide();
        }
    }else{
        if( bIsApvOrCancel ){
            $('.xCNHideWhenCancelOrApprove').hide();
        }else{
            $('.xCNHideWhenCancelOrApprove').show();
        }
        $('#obtTBOGenPacking').hide();
    }

    // switch(tStaPrcDoc){
    //     case '1':
    //         $('#obtTBOGenPacking').show();
    //         break;
    //     default:
    //         $('#obtTBOGenPacking').hide();
    // }
    // console.log(tStaPrcDoc);
    // if( tStaPrcDoc != "" ){                                                     // ต้องตรวจสอบสถานะใบจัด

    //     $('#obtTBOGenPacking').show();

    //     if( tStaPrcDoc == '1' ){
    //         $('#obtTBOGenPacking').attr('disabled',false);                      // กรณีรอสร้างใบจัดสินค้า เปิดปุ่มให้ gen ใบจัดสินค้าได้
    //         $('form .xCNApvOrCanCelDisabled').attr('disabled', false);          // ยังไม่กดสร้างใบจัดสินค้า สามารถแก้ไข input/product ได้อยู่
    //         $('#obtTransferBchOutCancel').attr('disabled',false);               // ยังไม่กดสร้างใบจัดสินค้า หรือลบไปจัดสินค้าหมดแล้ว สามารถยกเลิกใบจ่ายโอนได้
    //         $('#odvTBOBtnGrpSave button').attr('disabled',false);
    //     }else{
    //         $('#obtTBOGenPacking').attr('disabled',true);                       // ถ้ากดปุ่ม gen ใบจัดสินค้าไปแล้ว จะกดอีกไม่ได้
    //         $('form .xCNApvOrCanCelDisabled').attr('disabled', true);           // สร้างใบจัดสินค้าแล้ว ไม่สามารถแก้ไข input/product ได้
    //         $('#obtTransferBchOutCancel').attr('disabled',true);                // กดสร้างใบจัดสินค้าแล้ว ไม่สามารถยกเลิกใบจ่ายโอนได้
    //         $('#odvTBOBtnGrpSave button').attr('disabled',true);
    //     }

    //     if( tStaPrcDoc == '4' ){
    //         $('#obtTransferBchOutApprove').attr('disabled',false);              // กรณีใบจัดสินค้าทุกใบ อนุมัติครบแล้ว สามารถอนุมัติใบจ่ายโอนได้

    //     }else{
    //         $('#obtTransferBchOutApprove').attr('disabled',true);               // กรณีใบจัดสินค้าทุกใบ ยังอนุมัติไม่ครบ ไม่สามารถกดปุ่มอนุมัติใบจ่ายโอนได้

    //     }

    // }else{                                                                      // ไม่ต้องตรวจสอบ เพราะคลังต้นทางไม่อนุญาตให้สร้างใบจัด
    //     $('#odvTBOBtnGrpSave button').attr('disabled',false);
    //     $('#obtTransferBchOutApprove').attr('disabled',false);
    //     $('#obtTransferBchOutCancel').attr('disabled',false);
    //     $('#obtTBOGenPacking').hide();
    // }


    $('#obtTBOConfirmConfigGenDocPacking').off('click').on('click',function(){
        JCNxOpenLoading();
        var aCondition = [];
        $("input:checkbox[name=ocbTBOCondtionGenPacking]:checked").each(function(){
            var aPush = {
                'ptSplit' : $(this).val()
            };
            aCondition.push(aPush);
        });

        $.ajax({
            type    : "POST",
            url     : "docTBOEventSaveConfigGenDocPack",
            data    : {
                'paCondition' : aCondition
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == '1' ){
                    setTimeout(function(){
                        $('#odvTBOGenDocPacking').modal('show');
                    }, 500);
                }else{
                    FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });

    $('#obtTBOConfigGenDocPacking').off('click').on('click',function(){
        JSxTBOGetConfigGenDocPack(true);
    });

    function JSxTBOGetConfigGenDocPack(pbType){
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "docTBOEventGetConfigGenDocPack",
            data    : {},
            cache: false,
            Timeout: 0,
            success: function (oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == '1' ){
                    console.log(aResult['aDataList']);
                    var aDataList = aResult['aDataList'];
                    for (let i = 0; i < aDataList.length; i++) {
                        if( aDataList[i]['FTValue'] == '1' ){
                            $('.xWTBOSysSeq'+aDataList[i]['FTSysSeq']).prop('checked', true);
                        }else{
                            $('.xWTBOSysSeq'+aDataList[i]['FTSysSeq']).prop('checked', false);
                        }
                    }
                    if( pbType === true ){
                        setTimeout(function(){
                            $('#odvTBOConfigGenDocPacking').modal('show');
                        }, 500);
                    }
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    $('#obtTBOCancelConfigGenDocPacking').off('click').on('click',function(){
        setTimeout(function(){
            $('#odvTBOGenDocPacking').modal('show');
        }, 500);
    });



    $('#obtTBOGenPacking').off('click').on('click',function(){
        if( tStaPrcDoc != "1" ){
            FSvCMNSetMsgWarningDialog('เอกสารนี้สร้างใบจัดสินค้าแล้ว');
        }else{
            $('#odvTBOGenDocPacking').modal('show');
        }
    });

    $('#obtTBOConfirmGenDocPacking').off('click').on('click',function(){

        var aCondition = [];
        // $("input:checkbox[name=ocbTBOCondtionGenPacking]:checked").each(function(){
        //     var aPush = {
        //         'ptSplit' : $(this).val()
        //     };
        //     aCondition.push(aPush);
        // });

        // JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "docTBOEventGenDocPacking",
            data    : {
                'ptBchCode'     : $('#oetTransferBchOutBchCode').val(),
                'ptDocNo'       : $('#oetTransferBchOutDocNo').val(),
                'paCondition'   : aCondition
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                $('#odvTBOGenDocPacking').modal('hide');
                // JCNxCloseLoading();
                setTimeout(function(){
                    JSxTBOSubscribeMQOnGenPacking();
                }, 500);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });

    // Call MQ Progress
    function JSxTBOSubscribeMQOnGenPacking(){
        // Document variable
        var tLangCode                   = <?=$this->session->userdata("tLangEdit")?>;
        var tUsrBchCode                 = $("#oetTransferBchOutBchCode").val();
        var tUsrApv                     = $("#oetTransferBchOutApvCodeUsrLogin").val();
        var tDocNo                      = $("#oetTransferBchOutDocNo").val().trim();
        var tPrefix                     = "RESGEN";
        var tStaApv                     = $("#ohdTransferBchOutStaApv").val();
        var tStaDelMQ                   = '1'/*$("#ohdXthStaDelMQ").val()*/;
        var tQName                      = tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode                   : tLangCode,
            tUsrBchCode                 : tUsrBchCode,
            tUsrApv                     : tUsrApv,
            tDocNo                      : tDocNo,
            tPrefix                     : tPrefix,
            tStaDelMQ                   : tStaDelMQ,
            tStaApv                     : tStaApv,
            tQName                      : tQName,
            tVhostType                  : 'D'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName              : "TCNTPdtTboHD",
            ptDocFieldDocNo             : "FTXthDocNo",
            ptDocFieldStaApv            : "",
            ptDocFieldStaDelMQ          : "",
            ptDocStaDelMQ               : tStaDelMQ,
            ptDocNo                     : tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit               : "JSxCSSEventCallBackMQ",
            tCallPageList               : "JSxCSSEventCallBackMQ"
        };

        //Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            '',
            poUpdateStaDelQnameParams,
            poCallback
        );

    }

    function JSxCSSEventCallBackMQ(poObj){
        // var oResponse = JSON.parse(poObj);
        var oResponse = poObj;
        // console.log(oResponse);
        switch(oResponse['rtStatus']){
            case '1':
                JSvTransferBchOutCallPageEdit(oResponse['rtDocNo']);
                break;
            default:
                FSvCMNSetMsgWarningDialog(oResponse['rtMsgError']);
                JCNxCloseLoading();
        }
    }

    // Call MQ Progress
    function JSxTBOSubscribeMQCancelOnApv(){
        // Document variable
        var tLangCode                   = <?=$this->session->userdata("tLangEdit")?>;
        var tUsrBchCode                 = $("#oetTransferBchOutBchCode").val();
        var tUsrApv                     = $("#oetTransferBchOutApvCodeUsrLogin").val();
        var tDocNo                      = $("#oetTransferBchOutDocNo").val().trim();
        var tPrefix                     = "RESCANCELTBO";
        var tStaApv                     = $("#ohdTransferBchOutStaApv").val();
        var tStaDelMQ                   = '1'/*$("#ohdXthStaDelMQ").val()*/;
        var tQName                      = tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode                   : tLangCode,
            tUsrBchCode                 : tUsrBchCode,
            tUsrApv                     : tUsrApv,
            tDocNo                      : tDocNo,
            tPrefix                     : tPrefix,
            tStaDelMQ                   : tStaDelMQ,
            tStaApv                     : tStaApv,
            tQName                      : tQName,
            tVhostType                  : 'D'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName              : "TCNTPdtTboHD",
            ptDocFieldDocNo             : "FTXthDocNo",
            ptDocFieldStaApv            : "",
            ptDocFieldStaDelMQ          : "",
            ptDocStaDelMQ               : tStaDelMQ,
            ptDocNo                     : tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit               : "JSvTransferBchOutCallPageEdit",
            tCallPageList               : "JSvTransferBchOutCallPageEdit"
        };

        //Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            '',
            poUpdateStaDelQnameParams,
            poCallback
        );

    }

</script>
