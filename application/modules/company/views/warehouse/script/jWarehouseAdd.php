<script type="text/javascript">
    //Set Lang Edit 
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;

    /* // ตรวจสอบระดับของ User  07/02/2020 Saharat(Golf)
    var tStaUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';
    var tUsrBchCode = '<?php echo $this->session->userdata("tSesUsrBchCode"); ?>';
    var tUsrBchName = '<?php echo $this->session->userdata("tSesUsrBchName"); ?>';
    var tUsrShpCode = '<?php echo $this->session->userdata("tSesUsrShpCode"); ?>';
    var tUsrShpName = '<?php echo $this->session->userdata("tSesUsrShpName"); ?>'; */



    var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tWhere = "";

    $(document).ready(function() {
        
        // Control มาจากหน้าจอเครื่องจุดขาย ส่ง PArameter มายังหน้า Wahourse
        if( bIsAddPage ){
            let nStaTypeWah = $('#ocmPosType').val();
            let tPosBchCode = $('#oetPosBchCode').val();
            let tPosBchName = $('#oetPosBchName').val();

            if( tPosBchCode != undefined ){
                $('#oetWahBchCodeCreated').val(tPosBchCode);
                $('#oetWahBchNameCreated').val(tPosBchName);
                $('#obtWahBrowseBchCreated').attr('disabled',true);

                if(nStaTypeWah == 4){
                    $('#ocmWahStaType').val(6);
                }else{
                    $('#ocmWahStaType').val(2);
                }
                $('#ocmWahStaType').attr('disabled',true);
            }

           
        }

        /* // ตรวจสอบระดับUser banch  07/02/2020 Saharat(Golf)
        if (tUsrBchCode != "") {
            $('#oetWAHBchCode').val(tUsrBchCode);
            $('#oetWAHBchName').val(tUsrBchName);
            $('#obtWahBroseBchRef').attr("disabled", true);
            $('#oimBrowseShop').prop("disabled", false);
        }

        // ตรวจสอบระดับUser shop  07/02/2020 Saharat(Golf)
        if (tUsrShpCode != "") {
            $('#oetWahRefCode').val(tUsrShpCode);
            $('#oetWahRefName').val(tUsrShpName);
            $('#oimBrowseShop').attr("disabled", true);
        } */

        // ถ้าเข้ามาแล้วจะล็อคปุมเครื่องจุดขายหากเป็น สาขา HQ เพื่อบังคับเลือกสาขาก่อน
        JSxWahBrowsPos();

        if (!bIsAddPage) {
            $("#obtWahBrowseBchCreated").attr('disabled', true);
        }

        // if(!bIsMultiBch && nCountBch == 1){
        //     $('#obtWahBroseBchRef').attr("disabled", true); 
        // }
    });

    $('.selectpicker').selectpicker();

    //ส่วนสูงของ div ที่แสดงข้อมูล
    $nWinHeight = $(window).height();
    // $("#oetWahCode").attr("readonly", true);

    $(document).ready(function() {
        $("#oetWahCode").attr("readonly", true);
        if (JSbWahIsCreatePage()) {
            $('#ocbWahAutoGenCode').change(function() {
                if ($('#ocbWahAutoGenCode').is(':checked')) {
                    $('#oetWahCode').val('');
                    $("#oetWahCode").attr("readonly", true);
                    $('#odvWahCodeForm').removeClass('has-error');
                    $('#odvWahCodeForm em').remove();
                } else {
                    $("#oetWahCode").attr("readonly", false);
                }
            });
            JSxWahVisibleComponent('#ocbWahAutoGenCode', true);
        }

        if (JSbWahIsUpdatePage()) {
            $("#oetWahCode").attr("readonly", true);
            $('#odvWahAutoGenCode input').attr('disabled', true);
            JSxWahVisibleComponent('#odvWahAutoGenCode', false);
        }
    });

    $('#oetWahCode').blur(function() {
        JSxCheckWarehouseCodeDupInDB();
    });

    //Functionality: Event Check Warehouse Duplicate
    //Parameters: Event Blur Input Warehouse Code
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: 14/08/2019 Sahatat(Golf)
    //ReturnType: - 
    function JSxCheckWarehouseCodeDupInDB() {
        if (!$('#ocbWahAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TCNMWaHouse",
                    tFieldName: "FTWahCode",
                    tCode: $("#oetWahCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateWahCode").val(aResult["rtCode"]);
                    // Set Validate Dublicate Code
                    $.validator.addMethod('dublicateCode', function(value, element) {
                        if ($("#ohdCheckDuplicateWahCode").val() == 1) {
                            return false;
                        } else {
                            return true;
                        }
                    }, '');

                    // From Summit Validate
                    $('#ofmAddWarehouse').validate({
                        rules: {
                            oetWahCode: {
                                "required": {
                                    // ตรวจสอบเงื่อนไข validate
                                    depends: function(oElement) {
                                        if ($('#ocbWahAutoGenCode').is(':checked')) {
                                            return false;
                                        } else {
                                            return true;
                                        }
                                    }
                                },
                                "dublicateCode": {}
                            },
                            oetWahName: {
                                "required": {}
                            },
                            oetWAHBchName: {
                                "required": {}
                            },
                        },
                        messages: {
                            oetWahCode: {
                                "required": $('#oetWahCode').attr('data-validate-required'),
                                "dublicateCode": $('#oetWahCode').attr('data-validate-dublicateCode')
                            },
                            oetWahName: {
                                "required": $('#oetWahName').attr('data-validate-required'),
                            },
                            oetWAHBchName: {
                                "required": $('#oetWAHBchName').attr('data-validate-required'),
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
                            // Submit From
                            JSxHideObjWahouseType();
                            $('#ofmAddWarehouse').submit();

                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }
    }

    $('#ocmWahStaType').change(function() {
        JSxHideObjWahouseType();
    });

    function JSxHideObjWahouseType() {
        tValWahStaType = $('#ocmWahStaType').val();
        switch (tValWahStaType) {
            // มาตรฐาน
            case '1':
                $('#odvWhaSaleperson').hide();
                $('#odvWhaSaleMCPos').hide();
                $('#odvWahBranch').hide();
                $('#odvWhaShop').hide();
                $('#odvRefCode').show();
                $('#odvWhaBach').hide();
                $('#oetWahRefCode').val(''); // ล้างค่าใน Input Textbox
                break;
                // คลังทั่วไป
            case '2':
                $('#odvWhaSaleperson').hide();
                $('#odvWhaSaleMCPos').show();
                $('#odvWahBranch').hide();
                $('#odvWhaShop').hide();
                $('#odvRefCode').hide();
                $('#odvWhaBach').hide();

                // $('#oetWahPosCode').val('');
                // $('#oetWahPosName').val('');

                // $('#oetWahRefCode').val(tUsrBchCode);

                $('#oetWahRefCode').val(); // ล้างค่าใน Input Textbox
                break;
                // คลังสาขา
                // case '3':
                // 	$('#odvWhaSaleperson').hide();
                // 	$('#odvWhaSaleMCPos').hide();
                // 	$('#odvWahBranch').show();
                // 	$('#odvWhaShop').hide();
                // 	$('#odvRefCode').hide();
                // break;
                // คลังฝากขาย/ร้านค้า
            case '4':
                $('#odvWhaSaleperson').hide();
                $('#odvWhaSaleMCPos').hide();
                $('#odvWahBranch').hide();
                $('#odvWhaShop').hide();
                $('#odvRefCode').hide();
                $('#odvWhaBach').show();
                break;
                // คลังหน่วยรถ
            case '5':
                $('#odvWhaSaleperson').show();
                $('#odvWhaSaleMCPos').hide();
                $('#odvWahBranch').hide();
                $('#odvWhaShop').hide();
                $('#odvRefCode').hide();
                $('#odvWhaBach').show();
                break;
                // คลัง Vending
            case '6':
                $('#odvWhaSaleperson').hide();
                $('#odvWhaSaleMCPos').show();
                $('#odvWahBranch').hide();
                $('#odvWhaShop').hide();
                $('#odvRefCode').hide();
                $('#odvWhaBach').hide();

                // $('#oetWahPosCode').val('');
                // $('#oetWahPosName').val('');


                break;
            default:
                $('#odvWhaSaleperson').hide();
                $('#odvWhaSaleMCPos').hide();
                $('#odvWahBranch').hide();
                $('#odvWhaBach').hide();
                $('#odvWhaShop').hide();
                $('#odvRefCode').hide();
        }
    }

    $('.xWTooltipsBT').tooltip({
        'placement': 'bottom'
    });
    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });

    $('#ocmWahStaType').change(function() {
        $('#ocmWahStaType-error').hide();
    });

    //Option POS
    var oBrowsePOS = function(poDataFnc) {
        var tWAHBchCodeParam = poDataFnc.tWAHBchCodeParam;

        var tWahStaType = $('#ocmWahStaType').val();

        if(tWahStaType == 2){
            
          var tWherePosType = "AND TCNMPos.FTPosType = '1' AND TCNMPos.FTBchCode='" + tWAHBchCodeParam + "' AND (TCNMWaHouse.FTWahRefCode = '' OR TCNMWaHouse.FTWahRefCode IS NULL) ";
        
        }else{
           var tWherePosType = "AND TCNMPos.FTPosType = '4' AND TCNMPos.FTBchCode='" + tWAHBchCodeParam + "' AND (TCNMWaHouse.FTWahRefCode = '' OR TCNMWaHouse.FTWahRefCode IS NULL) ";
        }

        var oOptionReturn = {
            Title: ['company/warehouse/warehouse', 'tSalemachinePOS'],
            Table: {
                Master: 'TCNMPos',
                PK: 'FTPosCode'
            },
            Join: {
                Table: ['TCNMPos_L', 'TCNMWaHouse'],
                On: [
                    'TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos_L.FTBchCode = TCNMPos.FTBchCode',
                    'TCNMWaHouse.FTWahRefCode = TCNMPos.FTPosCode AND TCNMWaHouse.FTBchCode = TCNMPos.FTBchCode AND TCNMWaHouse.FTWahStaType = '+tWahStaType,
                ]
            },
            Where: {
                Condition: [tWherePosType]
            },
            GrideView: {
                ColumnPathLang: 'pos/salemachine/salemachine',
                ColumnKeyLang: ['tPOSCode', 'tPOSName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMPos.FTPosCode', 'TCNMPos_L.FTPosName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMPos.FTPosCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetWahPosCode", "TCNMPos.FTPosCode"],
                Text: ["oetWahPosName", "TCNMPos_L.FTPosName"],
            },
            RouteAddNew: 'salemachine',
            BrowseLev: nStaWahBrowseType
            // DebugSQL: true,
        }
        return oOptionReturn;
    }

    // Option Branch
    var oBrowseBch = {

        Title: ['company/branch/branch', 'tBCHTitle'],
        Table: {
            Master: 'TCNMBranch',
            PK: 'FTBchCode',
            PKName: 'FTBchName'
        },
        Join: {
            Table: ['TCNMBranch_L'],
            On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition: [
                function() {
                    var tSQL = "";
                    if (tUserLoginLevel != "HQ") {
                        tSQL += " AND TCNMBranch.FTBchCode IN(<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>)";
                    }
                    return tSQL;
                }
            ]
        },
        GrideView: {
            ColumnPathLang: 'company/branch/branch',
            ColumnKeyLang: ['tBCHCode', 'tBCHName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMBranch.FDCreateOn DESC'],
        },
        NextFunc: {
            FuncName: 'JSxWahBrowsPos'
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetWAHBchCode", "TCNMBranch.FTBchCode"],
            Text: ["oetWAHBchName", "TCNMBranch_L.FTBchName"],
        },
        RouteAddNew: 'branch',
        BrowseLev: nStaWahBrowseType

    }

    function JSxWahBrowsPos() {
        var tWAHBchCode = $('#oetWahBchCodeCreated').val();
        if (tWAHBchCode == '') {
            $('#oimBrowsePOS').attr('disabled', true);
        } else {
            $('#oimBrowsePOS').attr('disabled', false);
        }

    }

    //OPtion Shop
    var oBrowseShop = {
        Title: ['authen/user/user', 'tBrowseSHPTitle'],
        Table: {
            Master: 'TCNMShop',
            PK: 'FTShpCode'
        },
        Join: {
            Table: ['TCNMShop_L'],
            On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits, ]
        },
        Filter: {
            Selector: 'oetBranchCode',
            Table: 'TCNMShop',
            Key: 'FTBchCode'
        },
        GrideView: {
            ColumnPathLang: 'authen/user/user',
            ColumnKeyLang: ['tBrowseSHPCode', 'tBrowseSHPName'],
            ColumnsSize: ['10%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
            DataColumnsFormat: ['', ''],
            Perpage: 5,
            OrderBy: ['TCNMShop.FTShpCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            StaSingItem: '1',
            ReturnType: 'S',
            Value: ["oetWahRefCode", "TCNMShop.FTShpCode"],
            Text: ["oetWahRefName", "TCNMShop_L.FTShpName"],
        },
        RouteAddNew: 'shop',
        BrowseLev: nStaWahBrowseType
    }

    //OPtion Shop
    var oBrowseSalePerson = {
        Title: ['company/warehouse/warehouse', 'tWAHBrowseSpnTitle'],
        Table: {
            Master: 'TCNMSpn',
            PK: 'FTSpnCode'
        },
        Join: {
            Table: ['TCNMSpn_L'],
            On: ['TCNMSpn_L.FTSpnCode = TCNMSpn.FTSpnCode AND TCNMSpn_L.FNLngID = ' + nLangEdits, ]
        },
        // Filter: {
        //     Selector: 'oetSpnCode',
        //     Table: 'TCNMSpn',
        //     Key: 'FTSpnCode'
        // },
        GrideView: {
            ColumnPathLang: 'company/warehouse/warehouse',
            ColumnKeyLang: ['tWAHBrowseSpnCode', 'tWAHBrowseSpnName'],
            ColumnsSize: ['10%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMSpn.FTSpnCode', 'TCNMSpn_L.FTSpnName'],
            DataColumnsFormat: ['', ''],
            Perpage: 5,
            OrderBy: ['TCNMSpn.FTSpnCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            StaSingItem: '1',
            ReturnType: 'S',
            Value: ["oetWahSpnCode", "TCNMSpn.FTSpnCode"],
            Text: ["oetWahSpnName", "TCNMSpn_L.FTSpnName"],
        },
        RouteAddNew: 'saleperson',
        BrowseLev: nStaWahBrowseType
    }

    // $('#oimBrowsePOS').click(function(){JCNxBrowseData('oBrowsePOS')});

    $('#oimBrowsePOS').click(function() {
        JSxCheckPinMenuClose();
        var tWAHBchCodeParam = $('#oetWahBchCodeCreated').val();
        window.oBrowseWahOption = undefined;
        oBrowseWahOption = oBrowsePOS({
            'tWAHBchCodeParam': tWAHBchCodeParam
        });
        JCNxBrowseData('oBrowseWahOption');
    });

    $('#obtWahBroseBchRef').click(function() {
        JCNxBrowseData('oBrowseBch')
    });
    $('#oimBrowseShop').click(function() {
        JCNxBrowseData('oBrowseShop')
    });
    $('#oimBrowseSalePerson').click(function() {
        JCNxBrowseData('oBrowseSalePerson')
    });

    //Functionality: Set Validate Event Blur
    //Parameters: Validate Event Blur
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxWahSetValidEventBlur() {
        $('#ofmAddWarehouse').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if ($("#ohdCheckDuplicateWahCode").val() == 1) {
                return false;
            } else {
                return true;
            }
        }, '');

        // From Summit Validate
        $('#ofmAddWarehouse').validate({
            rules: {
                oetWahCode: {
                    "required": {
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if ($('#ocbWahAutoGenCode').is(':checked')) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },
                oetWahName: {
                    "required": {}
                },
                ocmWahStaType: {
                    "required": {}
                },
            },
            messages: {
                oetWahCode: {
                    "required": $('#oetWahCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetWahCode').attr('data-validate-dublicateCode')
                },
                oetWahName: {
                    "required": $('#oetWahName').attr('data-validate-required'),
                },
                ocmWahStaType: {
                    "required": $('#ocmWahStaType').attr('data-validate-required'),
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

    /*===== Begin Browse ===============================================================*/
    var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tWhere = "";

    if (nCountBch == 1) {
        $('#obtWahBrowseBchCreated').attr('disabled', true);
    }
    if (tUsrLevel != "HQ") {
        tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";

    } else {
        tWhere = "";
    }

    // สาขาที่สร้าง
    $("#obtWahBrowseBchCreated").click(function() {
        // option 
        window.oWahBrowseBchCreated = {
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
                    tWhere
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
                OrderBy: ['TCNMBranch.FTBchCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetWahBchCodeCreated", "TCNMBranch.FTBchCode"],
                Text: ["oetWahBchNameCreated", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxWahCallClearData',
                ArgReturn: ['FTBchCode']
            }, 
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oWahBrowseBchCreated');
    });
    /*===== End Browse =================================================================*/

    function JSxWahCallClearData(ptData){
        if(ptData != '' || ptData != 'null'){
            $('#oetWahPosName').val('');
            $('#oetWahPosCode').val('');
        }
    }



</script>