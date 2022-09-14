<script>
    $('ducument').ready(function () {
        $('.selectpicker').selectpicker();
        
        $('.selectpicker').selectpicker();
	
        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm:ss'
        });
        
        JSvSMLKAdjStaCallPageTempDataTable(1);
    });
    
    /*========================= Begin Browse Options =============================*/

    // สาขา 
    $('#obtSMLKAdjStaAddBrowseBch').click(function () {
        JSoSMLKAdjStaGetBchCodeOnShop();
        tOldBchCkChange = $("#oetBchCode").val();
        // Lang Edit In Browse
        nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
        // Option Branch
        oPmhBrowseBch = {
            Title: ['company/branch/branch', 'tBCHTitle'],
            Table: {Master: 'TCNMBranch', PK: 'FTBchCode'},
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: ['AND TCNMBranch.FTBchCode IN (' + JSoSMLKAdjStaGetBchCodeOnShop('wraptextonly') + ')']
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                DisabledColumns: [],
                Perpage: 5,
                OrderBy: ['TCNMBranch_L.FTBchName'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetSMLKAdjStaAddBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetSMLKAdjStaAddBchName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxSMLKAdjStaAddCallbackAfterSelectBch',
                ArgReturn: ['FTBchCode', 'FTBchName']
            },
            RouteFrom: 'promotion',
            RouteAddNew: 'branch',
            BrowseLev: 2
        };
        // Option Branch
        JCNxBrowseData('oPmhBrowseBch');

    });
    
    /*========================= End Browse Options =============================*/
    
    /*=================== Begin Callback Browse ==================================*/
    
    /**
     * สาขา
     * Functionality : Process after shoose branch
     * Parameters : -
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxSMLKAdjStaAddCallbackAfterSelectBch(poJsonData) {
        JSvSMLKAdjStaClearTemp();
    }
    
    /*=================== End Callback Browse ==================================*/
    
    /**
     * Functionality : บันทึกการเปลี่ยนสถานะช่อง
     * Parameters : -
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxSMLKAdjStaSave(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
           
            if(!JSbSMLKAdjStaHasRowInTemp()){
               var tWarningMessage = '<?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaNotFoundChannelMsg')?>';
               FSvCMNSetMsgWarningDialog(tWarningMessage);
               return;
            }

            // From Validate
            $('#ofmSMLKAdjStaForm').validate({
                rules: {
                    oetSMLKAdjStaAddBchCode: {
                        required: true
                    },
                    oetSMLKAdjStaAddBchName: {
                        required: true
                    },
                    ocmSMLKAdjStaLockerCode: {
                        required: true
                    },
                    ocmSMLKAdjStaAddStatus: {
                        required: true
                    },
                    oetSMLKAdjStaAddDate: {
                        required: true
                    },
                    ohdSMLKAdjStaUserCode: {
                        required: true
                    },
                    ohdSMLKAdjStaUserName: {
                        required: true
                    }
                },
                messages: {
                    /*oetCardShiftChangeCode: {
                        required: "<?php echo language('document/card/cardchange','tValidCardShiftChange'); ?>","
                    }*/
                },
                submitHandler: function(form) {
                    console.log('Save');

                    var tBchCode = $('#oetSMLKAdjStaAddBchCode').val();
                    var tRackCode = $('#ocmSMLKAdjAddStaRackCode').val();
                    var tAdjChannelStatus = $('#ocmSMLKAdjStaAddStatus').val();

                    $.ajax({
                        type: "POST",
                        url: 'smartLockerAdjustStatusEventAdd',
                        data: {
                            tBchCode: (tBchCode == '') ? JSoSMLKAdjStaGetBchCodeOnShop('wraptextonly') : "'" + tBchCode + "'",
                            tShpCode: JStSMLKAdjStaGetShopCode(),
                            tRackCode: tRackCode,
                            tAdjChannelStatus: tAdjChannelStatus
                        },
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            JSxGetPSHContentAdjustStatus();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                },
                errorElement: "em",
                errorPlacement: function (error, element ) {
                    error.addClass( "help-block" );
                    if (element.prop("type") === "checkbox") {
                        error.appendTo(element.parent("label"));
                    } else {
                        var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                        if(tCheck == 0){
                            error.appendTo(element.closest('.form-group')).trigger('change');
                        }
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                }
            });
        } else {
           JCNxShowMsgSessionExpired();
        }
    }
    
    /**
     * Functionality : Has Row in Temp
     * Parameters : -
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : status
     * Return Type : boolean
     */
    function JSbSMLKAdjStaHasRowInTemp(){
        var bStatus = false;
        var nTempRows = $('#ohdSMLKAdjStaTempRows').val();
        if(nTempRows > 0){
            bStatus = true;
        }else{
            bStatus = false;
        }
        return bStatus;
    }
    
    /**
     * Functionality : Get AdminHis
     * Parameters : pnPage
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    function JSvSMLKAdjStaCallPageTempDataTable(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
            JCNxOpenLoading();

            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == "") {
                nPageCurrent = "1";
            }

            var tBchCode = $('#oetSMLKAdjStaAddBchCode').val();
            var tRackCode = $('#ocmSMLKAdjAddStaRackCode').val();
            var tIsView = $('#ohdSMLKAdjStaIsView').val();

            $.ajax({
                type: "POST",
                url: "smartLockerAdjustStatusTempDataTable",
                data: {
                    nPageCurrent: nPageCurrent,
                    tBchCode: (tBchCode == '') ? JSoSMLKAdjStaGetBchCodeOnShop('wraptextonly') : "'" + tBchCode + "'",
                    tShpCode: JStSMLKAdjStaGetShopCode(),
                    tRackCode: tRackCode,
                    tIsView: tIsView
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    $("#odvSMLKAdjStatusDataTableTempList").html(tResult);
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
        } else {
           JCNxShowMsgSessionExpired();
        }	
    }
    
    /**
    * Functionality : Open Rack Channel Modal
    * Parameters : -
    * Creator : 12/07/2019 Piya
    * Update : -
    * Return : -
    * Return Type : -
    */
    function JSxSMLKAdjStaOpenRackChannelPanel() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetSMLKAdjStaAddBchCode').val();
            var tRackCode = $('#ocmSMLKAdjAddStaRackCode').val();

            if(tBchCode === ''){
                var tWarningMessage = '<?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaSelectBchMsg')?>';
                FSvCMNSetMsgWarningDialog(tWarningMessage);
                return;
            }
            if(tRackCode === ''){
                var tWarningMessage = '<?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaSelectGroupChannelMsg')?>';
                FSvCMNSetMsgWarningDialog(tWarningMessage);
                return;
            }

            JSvSMLKAdjStaCallPageRackChannelDataTable(1);

            $('#odvSMLKAdjStaAddRackChannelPanel').modal('show');
        
        } else {
            JCNxShowMsgSessionExpired();
        }
    }
   
    /**
     * Functionality : Get RackChannel
     * Parameters : pnPage
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    function JSvSMLKAdjStaCallPageRackChannelDataTable(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            
            JCNxOpenLoading();

            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == "") {
                nPageCurrent = "1";
            }

            var tBchCode = $('#oetSMLKAdjStaAddBchCode').val();
            var tRackCode = $('#ocmSMLKAdjAddStaRackCode').val();
            var tPosCode = JStSMLKAdjStaGetLockerCode(); // $('#oetPosCode').val();

            $.ajax({
                type: "POST",
                url: "smartLockerAdjustStatusRackChannelDataTable",
                data: {
                    nPageCurrent: nPageCurrent,
                    tBchCode: (tBchCode == '') ? JSoSMLKAdjStaGetBchCodeOnShop('wraptextonly') : "'" + tBchCode + "'",
                    tShpCode: JStSMLKAdjStaGetShopCode(),
                    tRackCode: tRackCode,
                    tPosCode: tPosCode
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    $("#odvSMLKAdjStaRackChannelTable").html(tResult);
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
        }else {
            JCNxShowMsgSessionExpired();
        }
    }
    
    /**
    * Functionality : Add Rack Channel to Temp
    * Parameters : -
    * Creator : 12/07/2019 Piya
    * Update : -
    * Return : -
    * Return Type : -
    */
    function JSvSMLKAdjStaAddRackChannelToTemp(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            
            var tBchCode = $('#oetSMLKAdjStaAddBchCode').val();
            var tPosCode = JStSMLKAdjStaGetLockerCode(); // $('#oetPosCode').val();
            var tLockerCode = $('#ocmSMLKAdjStaLockerCode').val();
            var tRackCode = $('#ocmSMLKAdjAddStaRackCode').val();
            var tAdjChannelStatus = $('#ocmSMLKAdjStaAddStatus').val();

            var aRackItems = [];
            $('.xWRackChannelItems.xCNActive').each(function(index){
                var tBchCode = $(this).data('rack-bchcode');
                var tMerCode = $(this).data('rack-mercode');
                var tShpCode = $(this).data('rack-shpcode');
                var nLayNo = $(this).data('rack-layno');
                var nLayRow = $(this).data('rack-layrow');
                var nLayCol = $(this).data('rack-laycol');
                var tLayStaUse = $(this).data('rack-laystause');
                aRackItems.push({'tBchCode': tBchCode, 'tMerCode': tMerCode, 'tShpCode': tShpCode, 'nLayNo': nLayNo, 'nLayRow': nLayRow, 'nLayCol': nLayCol, 'tLayStaUse': tLayStaUse});
            });

            console.log('aRackItems: ', aRackItems);
            $('#odvSMLKAdjStaAddRackChannelPanel').modal('hide');

            $.ajax({
                type: "POST",
                url: "smartLockerAdjustStatusRackChannelToTemp",
                data: {
                    tBchCode: (tBchCode == '') ? JSoSMLKAdjStaGetBchCodeOnShop('wraptextonly') : "'" + tBchCode + "'",
                    tPosCode: tPosCode,
                    tLockerCode: tLockerCode,
                    tShpCode: JStSMLKAdjStaGetShopCode(),
                    tAdjChannelStatus: tAdjChannelStatus,
                    tRackCode: tRackCode,
                    tRackItems: JSON.stringify(aRackItems)
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    JSvSMLKAdjStaCallPageTempDataTable(1);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        
        } else {
            JCNxShowMsgSessionExpired();
        }
    }
    
    /**
    * Functionality : Delete Rack Channel in Temp by LayNo
    * Parameters : -
    * Creator : 12/07/2019 Piya
    * Update : -
    * Return : -
    * Return Type : -
    */
    function JSvSMLKAdjStaDeleteRackChannelInTemp(poEl){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    
            var tBchCode = $('#oetSMLKAdjStaAddBchCode').val();
            var tPosCode = $('#oetPosCode').val();
            var tLockerCode = $('#ocmSMLKAdjStaLockerCode').val();
            var tRackCode = $('#ocmSMLKAdjAddStaRackCode').val();
            var tAdjChannelStatus = $('#ocmSMLKAdjStaAddStatus').val();

            var nLayNo = $(poEl).parents('.xWRackChannelTemp').data('rack-layno');
            var nLayRow = $(poEl).parents('.xWRackChannelTemp').data('rack-layrow');
            var nLayCol = $(poEl).parents('.xWRackChannelTemp').data('rack-laycol');

            $.ajax({
                type: "POST",
                url: "smartLockerAdjustStatusDeleteRackChannelInTemp",
                data: {
                    tBchCode: (tBchCode == '') ? JSoSMLKAdjStaGetBchCodeOnShop('textonly') : tBchCode,
                    tPosCode: tPosCode,
                    tLockerCode: tLockerCode,
                    tShpCode: JStSMLKAdjStaGetShopCode(),
                    tAdjChannelStatus: tAdjChannelStatus,
                    tRackCode: tRackCode,
                    nLayNo: nLayNo,
                    nLayRow: nLayRow,
                    nLayCol: nLayCol
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    JSvSMLKAdjStaCallPageTempDataTable(1);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        
        } else {
            JCNxShowMsgSessionExpired();
        }
    }
    
    /**
    * Functionality : ปรับสถานะช่อง ใน Temp เมื่อมีการเปลี่ยนสถานะเงื่อนไข
    * Parameters : -
    * Creator : 12/07/2019 Piya
    * Update : -
    * Return : -
    * Return Type : -
    */
    function JSvSMLKAdjStaUpdateStaUseInTemp(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            if(!JSbSMLKAdjStaHasRowInTemp()){return;}
            
            var tBchCode = $('#oetSMLKAdjStaAddBchCode').val();
            var tPosCode = $('#oetPosCode').val();
            var tLockerCode = $('#ocmSMLKAdjStaLockerCode').val();
            var tRackCode = $('#ocmSMLKAdjAddStaRackCode').val();
            var tAdjChannelStatus = $('#ocmSMLKAdjStaAddStatus').val();
            
            $.ajax({
                type: "POST",
                url: "smartLockerAdjustStatusUpdateStaUseInTemp",
                data: {
                    tBchCode: tBchCode,
                    tPosCode: tPosCode,
                    tLockerCode: tLockerCode,
                    tShpCode: JStSMLKAdjStaGetShopCode(),
                    tAdjChannelStatus: tAdjChannelStatus,
                    tRackCode: tRackCode
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    JSvSMLKAdjStaCallPageTempDataTable(1);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        
        } else {
            JCNxShowMsgSessionExpired();
        }
    }
    
    /**
    * Functionality : Clear Temp
    * Parameters : -
    * Creator : 12/07/2019 Piya
    * Update : -
    * Return : -
    * Return Type : -
    */
    function JSvSMLKAdjStaClearTemp(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            
            if(!JSbSMLKAdjStaHasRowInTemp()){return;}
            
            $.ajax({
                type: "POST",
                url: "smartLockerAdjustStatusClearTemp",
                data: {},
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    JSvSMLKAdjStaCallPageTempDataTable(1);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
        }else {
            JCNxShowMsgSessionExpired();
        }
    }
    
</script>
