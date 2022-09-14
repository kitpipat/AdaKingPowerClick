<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
    var nLangEdits        = '<?php echo $this->session->userdata("tLangEdit");?>';
    var tUsrApvName       = '<?php echo $this->session->userdata("tSesUsername");?>';
    var tSesUsrLevel      = '<?php echo $this->session->userdata('tSesUsrLevel');?>';
    var tUserBchCode      = '<?php echo $this->session->userdata("tSesUsrBchCode");?>';
    var tUserBchName      = '<?php echo $this->session->userdata("tSesUsrBchName");?>';
    var tUserWahCode      = '<?php echo $this->session->userdata("tSesUsrWahCode");?>';
    // var tUserWahName      = '<?php //echo $this->session->userdata("tSesUsrWahName");?>';
    var tRoute                 = $('#ohdDORoute').val();
    var tDOSesSessionID        = $("#ohdSesSessionID").val();

 
    $(document).ready(function(){
        // var nCrTerm = $('#ocmDOTypePayment').val();
        // if (nCrTerm == 2) {
        //     $('.xCNPanel_CreditTerm').show();
        // }else{
        //     $('.xCNPanel_CreditTerm').hide();
        // }
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        $('.selectpicker').selectpicker('refresh');

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });


        var dCurrentDate    = new Date();
        if($('#oetDODocDate').val() == ''){
            $('#oetDODocDate').datepicker("setDate",dCurrentDate); 
        }

        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm:ss'
        });

        $('.xCNMenuplus').unbind().click(function(){
            if($(this).hasClass('collapsed')){
                $('.xCNMenuplus').removeClass('collapsed').addClass('collapsed');
                $('.xCNMenuPanelData').removeClass('in');
            }
        });

        $('.xWTooltipsBT').tooltip({'placement': 'bottom'});

        $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
    
        $(".xWConditionSearchPdt.disabled").attr("disabled","disabled");


        $('#obtDODocBrowsePdt').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                if($('#oetDOFrmSplCode').val()!=""){
                    JSxCheckPinMenuClose();
                    JCNvDOBrowsePdt();
                }else{
                    $('#odvDOModalPleseselectSPL').modal('show');
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        if($('#ohdDOBchCode').val() == ""){
            $("#obtDOFrmBrowseTaxAdd").attr("disabled","disabled");
        }

        /** =================== Event Search Function ===================== */
            $('#oliDOMngPdtScan').unbind().click(function(){
                var tDOSplCode  = $('#oetDOFrmSplCode').val();
                if(typeof(tDOSplCode) !== undefined && tDOSplCode !== ''){
                    //Hide
                    $('#oetDOFrmFilterPdtHTML').hide();
                    $('#obtDOMngPdtIconSearch').hide();
                    
                    //Show
                    $('#oetDOFrmSearchAndAddPdtHTML').show();
                    $('#obtDOMngPdtIconScan').show();
                }else{
                    var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
            });
            $('#oliDOMngPdtSearch').unbind().click(function(){
                //Hide
                $('#oetDOFrmSearchAndAddPdtHTML').hide();
                $('#obtDOMngPdtIconScan').hide();
                //Show
                $('#oetDOFrmFilterPdtHTML').show();
                $('#obtDOMngPdtIconSearch').show();
            });
        /** =============================================================== */

        /** ===================== Set Date Autometic Doc ========================  */
            var dCurrentDate    = new Date();
            var tAmOrPm         = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
            var tCurrentTime    = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes();

            if($('#oetDODocDate').val() == ''){
                $('#oetDODocDate').datepicker("setDate",dCurrentDate); 
            }

            if($('#oetDODocTime').val() == ''){
                $('#oetDODocTime').val(tCurrentTime);
            }
        /** =============================================================== */

        /** =================== Event Date Function  ====================== */
            $('#obtDODocDate').unbind().click(function(){
                $('#oetDODocDate').datepicker('show');
            });

            $('#obtDODocTime').unbind().click(function(){
                $('#oetDODocTime').datetimepicker('show');
            });

            $('#obtDOBrowseRefIntDocDate').unbind().click(function(){
                $('#oetDORefIntDocDate').datepicker('show');
            });

            $('#obtDORefDocExtDate').unbind().click(function(){
                $('#oetDORefDocExtDate').datepicker('show');
            });

            $('#obtDOTransDate').unbind().click(function(){
                $('#oetDOTransDate').datepicker('show');
            });

            $('#obtDODateSent').unbind().click(function(){
                $('#oetDODateSent').datepicker('show');
            });
        /** =============================================================== */

        /** ================== Check Box Auto GenCode ===================== */
            $('#ocbDOStaAutoGenCode').on('change', function (e) {
                if($('#ocbDOStaAutoGenCode').is(':checked')){
                    $("#oetDODocNo").val('');
                    $("#oetDODocNo").attr("readonly", true);
                    $('#oetDODocNo').closest(".form-group").css("cursor","not-allowed");
                    $('#oetDODocNo').css("pointer-events","none");
                    $("#oetDODocNo").attr("onfocus", "this.blur()");
                    $('#ofmDOFormAdd').removeClass('has-error');
                    $('#ofmDOFormAdd .form-group').closest('.form-group').removeClass("has-error");
                    $('#ofmDOFormAdd em').remove();
                }else{
                    $('#oetDODocNo').closest(".form-group").css("cursor","");
                    $('#oetDODocNo').css("pointer-events","");
                    $('#oetDODocNo').attr('readonly',false);
                    $("#oetDODocNo").removeAttr("onfocus");
                }
            });
        /** =============================================================== */

        var tStaDocAuto = $('#ohdDOStaDocAuto').val();
        if( tStaDocAuto == '1' ){
            $('.xCNHideWhenCancelOrApprove').hide();
            $('.xWDisabledOnGenAutoDoc').attr('disabled',true);
            $('.xWReadOnlyOnGenAutoDoc').attr('readonly',true);
        }

    });
 
    // ========================================== Brows Option Conditon ===========================================
        // ตัวแปร Option Browse Modal คลังสินค้า
        var oWahOption      = function(poDataFnc){
            var tDOBchCode          = poDataFnc.tDOBchCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var aArgReturn          = poDataFnc.aArgReturn;

            var oOptionReturn   = {
                Title: ["company/warehouse/warehouse","tWAHTitle"],
                Table: { Master:"TCNMWaHouse", PK:"FTWahCode"},
                Join: {
                    Table: ["TCNMWaHouse_L"],
                    On: ["TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode=TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '"+nLangEdits+"'"]
                },
                Where: {
                    Condition : [" AND (TCNMWaHouse.FTWahStaType IN (1,2,5) AND  TCNMWaHouse.FTBchCode='"+tDOBchCode+"')"]
                },
                GrideView:{
                    ColumnPathLang: 'company/warehouse/warehouse',
                    ColumnKeyLang: ['tWahCode','tWahName'],
                    DataColumns: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
                    DataColumnsFormat: ['',''],
                    ColumnsSize: ['15%','75%'],
                    Perpage: 5,
                    WidthModal: 50,
                    OrderBy: ['TCNMWaHouse_L.FTWahName ASC'],
                },
                CallBack: {
                    ReturnType  : 'S',
                    Value       : [tInputReturnCode,"TCNMWaHouse.FTWahCode"],
                    Text        : [tInputReturnName,"TCNMWaHouse_L.FTWahName"]
                },
                RouteAddNew: 'warehouse'
            }
            return oOptionReturn;
        }
            

        // ตัวแปร Option Browse Modal สาขา
        var oBranchOption = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tAgnCode            = poDataFnc.tAgnCode;
            var aArgReturn          = poDataFnc.aArgReturn;
            tUsrLevel = "<?=$this->session->userdata('tSesUsrLevel')?>";
            tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
            tSQLWhereBch = "";
            tSQLWhereAgn = "";

            if(tUsrLevel != "HQ"){
                tSQLWhereBch = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") AND TCNMBranch.FTAgnCode IN ("+tAgnCode+")";
            }

            if(tAgnCode != ""){
                tSQLWhereAgn = "AND TCNMBranch.FTAgnCode IN ("+tAgnCode+")";
            }
            // ตัวแปร ออฟชั่นในการ Return
            var oOptionReturn       = {
                Title: ['authen/user/user', 'tBrowseBCHTitle'],
                Table: {
                    Master  : 'TCNMBranch',
                    PK      : 'FTBchCode'
                },
                Join: {
                    Table   : ['TCNMBranch_L','TCNMWaHouse_L'],
                    On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits,
                             'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID ='+nLangEdits,]
                },
                Where : {
                    Condition : [tSQLWhereBch,tSQLWhereAgn]
                },
                GrideView: {
                    ColumnPathLang      : 'authen/user/user',
                    ColumnKeyLang       : ['tBrowseBCHCode', 'tBrowseBCHName'],
                    ColumnsSize         : ['10%', '75%'],
                    DataColumns         : ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName','TCNMWaHouse_L.FTWahCode','TCNMWaHouse_L.FTWahName'],
                    DataColumnsFormat   : ['', ''],
                    DisabledColumns   : [2,3],
                    WidthModal          : 50,
                    Perpage             : 10,
                    OrderBy             : ['TCNMBranch.FTBchCode'],
                    SourceOrder         : "ASC"
                },
                NextFunc:{
                    FuncName:'JSxNextFuncDOBch'
                },
                //DebugSQL : true,
                CallBack: {
                    ReturnType  : 'S',
                    Value       : [tInputReturnCode, "TCNMBranch.FTBchCode"],
                    Text        : [tInputReturnName, "TCNMBranch_L.FTBchName"]
                },
            };
            return oOptionReturn;
        }

        function JSxNextFuncDOBch() {
            $('#oetDOFrmWahCode').val('');
            $('#oetDOFrmWahName').val('');
        }

        //Option Agency
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
            NextFunc:{
                    FuncName:'JSxNextFuncDOAgn'
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

    function JSxNextFuncDOAgn() {
        $('#ohdDOBchCode').val('');
        $('#oetDOBchName').val('');
        $('#oetDOFrmWahCode').val('');
        $('#oetDOFrmWahName').val('');
    }

    var tStaUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';

        // ตัวแปร Option Browse Modal ตัวแทนจำหน่าย
        var oSplOption      = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;
        var tParamsAgnCode      = poDataFnc.tParamsAgnCode;
        
        if( tParamsAgnCode != "" ){
            tWhereAgency = " AND ( TCNMSpl.FTAgnCode = '"+tParamsAgnCode+"' OR ISNULL(TCNMSpl.FTAgnCode,'') = '' ) ";
        }else{
            tWhereAgency = "";
        }

        var oOptionReturn       = {
            Title: ['supplier/supplier/supplier', 'tSPLTitle'],
            Table: {Master:'TCNMSpl', PK:'FTSplCode'},
            Join: {
                Table: ['TCNMSpl_L', 'TCNMSplCredit'],
                On: [
                    'TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = '+nLangEdits,
                    'TCNMSpl_L.FTSplCode = TCNMSplCredit.FTSplCode',
                ]
            },
            Where:{
                Condition : ["AND TCNMSpl.FTSplStaActive = '1' " + tWhereAgency]
            },
            GrideView:{
                ColumnPathLang: 'supplier/supplier/supplier',
                ColumnKeyLang: ['tSPLTBCode', 'tSPLTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMSpl.FTSplCode', 'TCNMSpl_L.FTSplName', 'TCNMSpl.FTSplStaVATInOrEx','TCNMSplCredit.FNSplCrTerm'],
                DataColumnsFormat: ['',''],
                DisabledColumns: [2, 3],
                Perpage: 5,
                OrderBy: ['TCNMSpl_L.FTSplName ASC']
            },
            CallBack:{
                ReturnType: 'S',
                Value   : [tInputReturnCode,"TCNMSpl.FTSplCode"],
                Text    : [tInputReturnName,"TCNMSpl_L.FTSplName"]
            },
            NextFunc:{
                FuncName:'JSxNextFuncDOSpl',
                ArgReturn:['FTSplName', 'FTSplStaVATInOrEx', 'FNSplCrTerm']
            },
            RouteAddNew: 'supplier'
        };
        return oOptionReturn;
    }

    function JSxNextFuncDOSpl(paData) {
        $("#oetDOSplName").val("");
        $("#oetDOFrmSplInfoCrTerm").val("");
        var tDOSplName = '';
        var tDOTypePayment = '';
        var tDOFrmSplInfoCrTerm = '';
        var tDOFrmSplInfoVatInOrEx = '';
        if (typeof(paData) != 'undefined' && paData != "NULL") {
            var aDOSplData = JSON.parse(paData);
            tDOSplName = aDOSplData[0];
            tDOFrmSplInfoVatInOrEx = aDOSplData[1];
            tDOTypePayment = aDOSplData[2]
            tDOFrmSplInfoCrTerm = aDOSplData[2]
        }
        $("#oetDOSplName").val(tDOSplName);
        $("#oetDOFrmSplInfoCrTerm").val(tDOFrmSplInfoCrTerm);

        //ประเภทการชำระเงิน
        if (tDOTypePayment > 0) {
            $("#ocmDOTypePayment").val("2").selectpicker('refresh');
            $('.xCNPanel_CreditTerm').show();
        }else{
            $("#ocmDOTypePayment").val("1").selectpicker('refresh');
            $('.xCNPanel_CreditTerm').hide();
        }

        //ประเภทภาษี
        if (tDOFrmSplInfoVatInOrEx == 1) {
            //รวมใน
            $("#ocmDOFrmSplInfoVatInOrEx").val("1").selectpicker('refresh');
        }else{
            //แยกนอก
            $("#ocmDOFrmSplInfoVatInOrEx").val("2").selectpicker('refresh');
        }
        

    }
    // ============================================================================================================

    // ========================================== Brows Event Conditon ===========================================
        // Event Browse Warehouse
        $('#obtDOBrowseWahouse').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oDOBrowseWahOption   = undefined;
                oDOBrowseWahOption          = oWahOption({
                    'tDOBchCode'        : $('#ohdDOBchCode').val(),
                    'tReturnInputCode'  : 'oetDOFrmWahCode',
                    'tReturnInputName'  : 'oetDOFrmWahName',
                    'aArgReturn'        : []
                });
                JCNxBrowseData('oDOBrowseWahOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtDOBrowseBCH').unbind().click(function(){ 
        var nStaSession = JCNxFuncChkSessionExpired();
        var tAgnCode = $('#oetDOAgnCode').val();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oDOBrowseBranchOption  = undefined;
                oDOBrowseBranchOption         = oBranchOption({
                    'tReturnInputCode'  : 'ohdDOBchCode',
                    'tReturnInputName'  : 'oetDOBchName',
                    'tAgnCode'          : tAgnCode,
                    'aArgReturn'        : ['FTBchCode','FTBchName','FTWahCode','FTWahName'],
                });
                JCNxBrowseData('oDOBrowseBranchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }

        });

        //BrowseAgn 
        $('#oimDOBrowseAgn').click(function(e) {
            e.preventDefault();
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose();
                window.oDOBrowseAgencyOption = oBrowseAgn({
                    'tReturnInputCode': 'oetDOAgnCode',
                    'tReturnInputName': 'oetDOAgnName',
                });
                JCNxBrowseData('oDOBrowseAgencyOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        
        // Event Browse Supplier
        $('#obtDOBrowseSupplier').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oDOBrowseSplOption   = undefined;
                oDOBrowseSplOption          = oSplOption({
                    'tParamsAgnCode'    : '<?=$this->session->userdata("tSesUsrAgnCode")?>',
                    'tReturnInputCode'  : 'oetDOFrmSplCode',
                    'tReturnInputName'  : 'oetDOFrmSplName',
                    'aArgReturn'        : ['FTSplCode', 'FTSplName']
                });
                JCNxBrowseData('oDOBrowseSplOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtDOBrowseRefDocInt').on('click',function(){
            JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
            JSxCallDORefIntDoc();
        });

        //Browse เอกสารอ้างอิงภายใน
        function JSxCallDORefIntDoc(){
            var tBCHCode = $('#ohdDOBchCode').val()
            var tBCHName = $('#oetDOBchName').val()
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docDOCallRefIntDoc",
                data: {
                    'tBCHCode'      : tBCHCode,
                    'tBCHName'      : tBCHName,
                },
                cache: false,
                Timeout: 0,
                success: function (oResult){
                    JCNxCloseLoading();
                    $('#odvDOFromRefIntDoc').html(oResult);
                    $('#odvDOModalRefIntDoc').modal({backdrop : 'static' , show : true});
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }

        $('#obtConfirmRefDocInt').click(function(){
            var tRefIntDocNo =  $('.xPurchaseInvoiceRefInt.active').data('docno');
            var tRefIntDocDate =  $('.xPurchaseInvoiceRefInt.active').data('docdate');
            var tRefIntBchCode =  $('.xPurchaseInvoiceRefInt.active').data('bchcode');
            var aSeqNo = $('.ocbRefIntDocDT:checked').map(function(elm){
                    return $(this).val();
                }).get();

            var tSplStaVATInOrEx =  $('.xPurchaseInvoiceRefInt.active').data('vatinroex');
            var cSplCrLimit =  $('.xPurchaseInvoiceRefInt.active').data('crtrem');
            var nSplCrTerm =  $('.xPurchaseInvoiceRefInt.active').data('crlimit');
            var tSplCode =  $('.xPurchaseInvoiceRefInt.active').data('splcode');
            var tSplName =  $('.xPurchaseInvoiceRefInt.active').data('splname');
            
            var poParams = {
                    FCSplCrLimit        : cSplCrLimit,
                    FTSplCode           : tSplCode,
                    FTSplName           : tSplName,
                    FTSplStaVATInOrEx   : tSplStaVATInOrEx,
                    FTRefIntDocNo       : tRefIntDocNo,
                    FTRefIntDocDate     : tRefIntDocDate,
                };
                
            if (typeof tRefIntDocNo === "undefined") {
                $('#odvDOModalPONoFound').modal('show');
            } else {
                JSxDOSetPanelSupplierData(poParams);
                $('#oetDORefIntDoc').val(tRefIntDocNo);
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docDOCallRefIntDocInsertDTToTemp",
                    data: {
                        'tDODocNo'          : $('#oetDODocNo').val(),
                        'tDOFrmBchCode'     : $('#ohdDOBchCode').val(),
                        'tRefIntDocNo'      : tRefIntDocNo,
                        'tRefIntBchCode'    : tRefIntBchCode,
                        'aSeqNo'            : aSeqNo
                    },
                    cache: false,
                    Timeout: 0,
                    success: function (oResult){
                        JSvDOLoadPdtDataTableHtml();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });

        $('#obtConfirmPo').on('click',function(){
            $('#odvDOModalRefIntDoc').modal('show');
        });

        // Function : ฟังก์ชั่นเซทข้อมูล ผู้จำหน่าย
        function JSxDOSetPanelSupplierData(poParams){
            // Reset Panel เป็นค่าเริ่มต้น
            $("#ocmDOFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            $("#ocmDOTypePayment.selectpicker").val("2").selectpicker("refresh");
            $("#oetDORefDocIntName").val(poParams.FTRefIntDocNo);
            $("#oetDORefIntDocDate").val(poParams.FTRefIntDocDate).datepicker("refresh")
            // ประเภทภาษี
            if(poParams.FTSplStaVATInOrEx == 1){
                // รวมใน
                $("#ocmDOFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            }else{
                // แยกนอก
                $("#ocmDOFrmSplInfoVatInOrEx.selectpicker").val("2").selectpicker("refresh");
            }

            // ประเภทชำระเงิน
            if(poParams.FCSplCrLimit > 0){
                // เงินเชื่อ
                $("#ocmDOTypePayment.selectpicker").val("2").selectpicker("refresh");
                $('.xCNPanel_CreditTerm').show();
            }else{
                // เงินสด
                $("#ocmDOTypePayment.selectpicker").val("1").selectpicker("refresh");
                $('.xCNPanel_CreditTerm').hide();
                
            }
            
            //ผู้ขาย
            $("#oetDOFrmSplCode").val(poParams.FTSplCode);
            $("#oetDOFrmSplName").val(poParams.FTSplName);
            $("#oetDOSplName").val(poParams.FTSplName);
            $("#oetDOFrmSplInfoCrTerm").val(poParams.FCSplCrLimit);
        }

//------------------------------------------------------------------------------------------------//

    //นับจำนวนรายการท้ายเอกสาร
    function JSxDOCountPdtItems(){
        var nPdtItems = $('.xWPdtItem').length;
        $('.xShowQtyFooter').text(accounting.formatNumber(nPdtItems, 0, ','));
    }

    $('#ocmDOTypePayment').on('change', function() {
        if (this.value == 1) {
            $('.xCNPanel_CreditTerm').hide();
        } else {
            $('.xCNPanel_CreditTerm').show();
        }
    });


    // Rabbit MQ
    function JSoDOCallSubscribeMQ() {
        // Document variable
        var tLangCode = $("#ohdDOLangEdit").val();
        var tUsrBchCode = $("#ohdDOBchCode").val();
        var tUsrApv = '<?=$this->session->userdata('tSesUsername')?>';
        var tDocNo = $("#oetDODocNo").val();
        var tPrefix = "RESDO";
        var tStaApv = $("#ohdDOStaApv").val();
        var tStaDelMQ = 1;
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
            ptDocTableName: "TAPTDoHD",
            ptDocFieldDocNo: "FTXphDocNo",
            ptDocFieldStaApv: "FTXphStaPrcStk",
            ptDocFieldStaDelMQ: "FTXphStaDelMQ",
            ptDocStaDelMQ: tStaDelMQ,
            ptDocNo: tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: "JSvDOCallPageEdit",
            tCallPageList: "JSvDOCallPageList"
        };

        // Check Show Progress %
        FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
    }

    //พิมพ์เอกสาร
    function JSxDOPrintDoc(){
        var aInfor = [
            {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'},
            {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'},
            {"BranchCode"   : '<?=FCNtGetAddressBranch(@$tDOBchCode); ?>'},
            {"DocCode"      : '<?=@$tDODocNo; ?>'}, // เลขที่เอกสาร
            {"DocBchCode"   : '<?=@$tDOBchCode;?>'}
        ];
        window.open("<?=base_url(); ?>formreport/Frm_SQL_SMSBillDo?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

    $(document).ready(function(){
        //อ้างอิงเอกสาร
        JSxDOCallPageHDDocRef();
        JSxDOEventCheckShowHDDocRef();
    });

    //โหลด Table อ้างอิงเอกสารทั้งหมด
    function JSxDOCallPageHDDocRef(){
        $.ajax({
            type    : "POST",
            url     : "monDOPageHDDocRefList",
            data:{
                'ptDocNo'       : $('#oetDODocNo').val(),
                'ptStaApv'      : $('#ohdDOStaApv').val()
            },
            cache   : false,
            timeout : 0,
            success: function(oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == 1 ){
                    $('#odvDOTableHDRef').html(aResult['tViewPageHDRef']);
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
    $('#obtDOAddDocRef').off('click').on('click',function(){
        $('#ofmDOFormAddDocRef').validate().destroy();
        JSxDOEventClearValueInFormHDDocRef();
        $('#odvDOModalAddDocRef').modal('show');
    });

    //เคลียร์ค่า
    function JSxDOEventClearValueInFormHDDocRef(){
        $('#oetDORefDocNo').val('');
        $('#oetDORefDocDate').val('');
        $('#oetDODocRefInt').val('');
        $('#oetDODocRefIntName').val('');
        $('#oetDORefKey').val('');
    }

    //Default โชว์ panel ตามประเภท (ภายใน หรือ ภายนอก)
    function JSxDOEventCheckShowHDDocRef(){
        var tDORefType = $('#ocbDORefType').val();
        if( tDORefType == '1' ){
            $('.xWShowRefExt').hide();
            $('.xWShowRefInt').show();
        }else{
            $('.xWShowRefInt').hide();
            $('.xWShowRefExt').show();
        }
    }

    //เมื่อเปลี่ยน ประเภท (ภายใน หรือ ภายนอก)
    $('#ocbDORefType').off('change').on('change',function(){
        $(this).selectpicker('refresh');
        JSxDOEventCheckShowHDDocRef();
    });

    //กดเลือกอ้างอิงเอกสารภายใน (ใบจ่ายโอน - สาขา)
    $('#obtDOBrowseRefDoc').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCallPageTransferBchOutRefIntDoc();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $(document).on('show.bs.modal', '.modal', function() {
        const zIndex = 1040 + 10 * $('.modal:visible').length;
        $(this).css('z-index', zIndex);
        setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
    });

    $('#obtDOUpdateDoc').off('click').on('click',function(){
        JSxDOEventUpdateDoc(false);
    });

    function JSxDOEventUpdateDoc(pbEvent){
        if( pbEvent === true || pbEvent == 'true' ){
            JCNxOpenLoading();
            var tDocNo = $('#oetDODocNo').val();
            $.ajax({
                type    : "POST",
                url     : "docDOEventUpdateDoc",
                data:{
                    'ptDocNo'       : tDocNo,
                    'ptBchCode'     : $('#ohdDOBchCode').val()
                },
                cache   : false,
                timeout : 0,
                success: function(oResult){
                    var aResult = JSON.parse(oResult);
                    if( aResult['nStaEvent'] == 1 ){
                        JSvDOCallPageEdit(tDocNo);
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
        }else{
            FSvCMNSetMsgWarningDialog('คุณต้องการปรับปรุงข้อมูลใช่หรือไม่ ระบบจะทำการยกเลิกอนุมัติเอกสาร','JSxDOEventUpdateDoc','','true');
        }
    }

    // console.log( $('#ohdDOAlwQtyPickNotEqQtyOrd').val() );

    $('#obtDOBrowseShipAdd').click(function() {
		JSxCheckPinMenuClose(); // Hidden Pin Menu
		$("#odvDOBrowseShipAdd").modal("show");
	});

    //Event Browse ShipAdd
	$('#oliBtnEditShipAdd').click(function() {
		JSxCheckPinMenuClose(); // Hidden Pin Menu
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		//option Ship Address 
		oDOBrowseShipAdd = {
			Title: ['document/purchaseorder/purchaseorder', 'tBrowseADDTitle'],
			Table: {
				Master: 'TCNMCstAddress_L',
				PK: 'FNAddSeqNo'
			},
			Join: {
				Table: ['TCNMProvince_L', 'TCNMDistrict_L', 'TCNMSubDistrict_L'],
				On: [
					"TCNMCstAddress_L.FTAddV1PvnCode = TCNMProvince_L.FTPvnCode AND TCNMProvince_L.FNLngID = " + nLangEdits,
					"TCNMCstAddress_L.FTAddV1DstCode = TCNMDistrict_L.FTDstCode AND TCNMDistrict_L.FNLngID = " + nLangEdits,
					"TCNMCstAddress_L.FTAddV1SubDist = TCNMSubDistrict_L.FTSudCode AND TCNMSubDistrict_L.FNLngID = " + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tFilter = " AND TCNMCstAddress_L.FTAddGrpType = '3' AND TCNMCstAddress_L.FNLngID = " + nLangEdits;
						if ( $("#oetDOCstCode").val() != "" ) {
                            tFilter += " AND TCNMCstAddress_L.FTCstCode = '"+$("#oetDOCstCode").val()+"' ";
						}
                        if( $('#ohdDOAddressFormat').val() != "" ){
                            tFilter += " AND TCNMCstAddress_L.FTAddVersion = '"+$('#ohdDOAddressFormat').val()+"' ";
                        }
						return tFilter;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'document/purchaseorder/purchaseorder',
				ColumnKeyLang: ['tBrowseADDBch', 'tBrowseADDSeq', 'tBrowseADDV1No', 'tBrowseADDV1Soi', 'tBrowseADDV1Village', 'tBrowseADDV1Road', 'tBrowseADDV1SubDist', 'tBrowseADDV1DstCode', 'tBrowseADDV1PvnCode', 'tBrowseADDV1PostCode'],
				DataColumns: [
                    'TCNMCstAddress_L.FTAddName', //0
                    'TCNMCstAddress_L.FNAddSeqNo', //1
                    'TCNMCstAddress_L.FTAddV1No', //2
                    'TCNMCstAddress_L.FTAddV1Soi', //3
                    'TCNMCstAddress_L.FTAddV1Village', //4 
                    'TCNMCstAddress_L.FTAddV1Road', //5
                    'TCNMCstAddress_L.FTAddV1SubDist', //6
                    'TCNMSubDistrict_L.FTSudName', //7
                    'TCNMCstAddress_L.FTAddV1DstCode', //8 
                    'TCNMDistrict_L.FTDstName', //9
                    'TCNMCstAddress_L.FTAddV1PvnCode', //10
                    'TCNMProvince_L.FTPvnName', //11
                    'TCNMCstAddress_L.FTAddV1PostCode', //12
                    'TCNMCstAddress_L.FTAddV2Desc1', //13
                    'TCNMCstAddress_L.FTAddV2Desc2'], //14
				// DataColumnsFormat: ['', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
				ColumnsSize: [''],
				DisabledColumns: [
                    function() {
						var tDisabledColumns = "";
                        if( $('#ohdDOAddressFormat').val() == "1" ){
                            tDisabledColumns += "1,6,8,10,13,14";
                        }else{
                            tDisabledColumns += "1,2,3,4,5,6,8,10";
                        }
						return tDisabledColumns;
					}
                    
                ],
				Perpage: 10,
				WidthModal: 50,
				OrderBy: ['TCNMCstAddress_L.FNAddSeqNo'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["ohdShipAddSeqNo", "TCNMCstAddress_L.FNAddSeqNo"],
				Text: ["ohdShipAddSeqNo", "TCNMCstAddress_L.FNAddSeqNo"],
			},
			NextFunc: {
				FuncName: 'JSvDOGetShipAddData',
				ArgReturn: ['FNAddSeqNo', 'FTAddV1No', 'FTAddV1Soi', 'FTAddV1Village', 'FTAddV1Road', 'FTSudName', 'FTDstName', 'FTPvnName', 'FTAddV1PostCode', 'FTAddV2Desc1', 'FTAddV2Desc2']
			},
			BrowseLev: 1,
            // DebugSQL: true
		}
		//option Ship Address 
		JCNxBrowseData('oDOBrowseShipAdd');
	});

    
    //Get ข้อมูล Address มาใส่ modal แบบ Array
    function JSvDOGetShipAddData(pTAddressInfor) {
        if (pTAddressInfor !== "NULL") {
            var aData = JSON.parse(pTAddressInfor);
            $("#ospShipAddAddV1No").text(aData[1]);
            $("#ospShipAddV1Soi").text(aData[2]);
            $("#ospShipAddV1Village").text(aData[3]);
            $("#ospShipAddV1Road").text(aData[4]);
            $("#ospShipAddV1SubDist").text(aData[5]);
            $("#ospShipAddV1DstCode").text(aData[6]);
            $("#ospShipAddV1PvnCode").text(aData[7]);
            $("#ospShipAddV1PostCode").text(aData[8]);
            $("#ospShipAddV2Desc1").text(aData[9]);
            $("#ospShipAddV2Desc2").text(aData[10]);
        } else {
            $("#ospShipAddAddV1No").text("-");
            $("#ospShipAddV1Soi").text("-");
            $("#ospShipAddV1Village").text("-");
            $("#ospShipAddV1Road").text("-");
            $("#ospShipAddV1SubDist").text("-");
            $("#ospShipAddV1DstCode").text("-");
            $("#ospShipAddV1PvnCode").text("-");
            $("#ospShipAddV1PostCode").text("-");
            $("#ospShipAddV2Desc1").text("-");
            $("#ospShipAddV2Desc2").text("-");
        }
    }

    // put ค่าจาก Modal ลง Input หน้า Add
	function JSnDOAddShipAdd() {
		tShipAddSeqNoSelect = $('#ohdShipAddSeqNo').val();
		$('#ohdDOShipAdd').val(tShipAddSeqNoSelect);

		$('#odvDOBrowseShipAdd').modal('toggle');
	}

    // Event Click Appove Document
    $('#obtDOApproveDoc').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            $('#ohdDOStaSaveAndApv').val("1");
            $('#obtDOSubmitDocument').click();
            // JSxDOValidateFormDocument();
            // var tCheckIteminTable = $('#otbDODocPdtAdvTableList .xWPdtItem').length;
            // if (tCheckIteminTable > 0) {
            //     JSxDOApproveDocument(false);
            // } else {
            //     FSvCMNSetMsgWarningDialog($('#ohdDOValidatePdt').val());
            // }
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var tStaDoc = $('#ohdDOStaDoc').val();
    var tStaApv = $('#ohdDOStaApv').val();
    if( tStaDoc == '3' || (tStaDoc == '1' && tStaApv == '1') ){
        $('#obtDOApproveDoc').hide();
        $('#obtDOCancelDoc').hide();
        $('.xWDODisabledOnApv').attr('disabled',true);
        $('.xWDOReadOnlyOnApv').attr('readonly',true);
    }else{
        $('#obtDOApproveDoc').show();
        $('#obtDOCancelDoc').show();
    }

    if( tStaDoc == '3' ){
        $('#odvDOBtnGrpSave').hide();
    }

    $('#obtDOCallBackPage').off('click').on('click',function(){
        JSvDOCallPageList();
    });

    
    // Call MQ Progress
    function JSxDOCallSubscribeMQ(){
        // Document variable
        var tLangCode                   = <?=$this->session->userdata("tLangEdit")?>;
        var tUsrBchCode                 = $("#ohdDOBchCode").val();
        var tUsrApv                     = $("#ohdSesUsrCode").val();
        var tDocNo                      = $("#oetDODocNo").val().trim();
        var tPrefix                     = "RESDO";
        var tStaApv                     = $("#ohdDOStaApv").val();
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
            ptDocTableName              : "TARTDoHD",
            ptDocFieldDocNo             : "FTXshDocNo",
            ptDocFieldStaApv            : "",
            ptDocFieldStaDelMQ          : "",
            ptDocStaDelMQ               : tStaDelMQ,
            ptDocNo                     : tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit               : "JSvDOCallPageEdit",
            tCallPageList               : "JSvDOCallPageList"
        };

        //Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            '',
            poUpdateStaDelQnameParams,
            poCallback
        );
    }

    // Event Click Cancel Document
    $('#obtDOCancelDoc').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSnDOCancelDocument(false);
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

</script>