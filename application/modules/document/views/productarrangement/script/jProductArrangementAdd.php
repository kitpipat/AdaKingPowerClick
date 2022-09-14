<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
    var nLangEdits        = '<?php echo $this->session->userdata("tLangEdit");?>';
    var tUsrApvName       = '<?php echo $this->session->userdata("tSesUsername");?>';
    var tSesUsrLevel      = '<?php echo $this->session->userdata('tSesUsrLevel');?>';
    var tUserBchCode      = '<?php echo $this->session->userdata("tSesUsrBchCode");?>';
    var tUserBchName      = '<?php echo $this->session->userdata("tSesUsrBchName");?>';
    var tUserWahCode      = '<?php echo $this->session->userdata("tSesUsrWahCode");?>';
    // var tUserWahName      = '<?php //echo $this->session->userdata("tSesUsrWahName");?>';
    var tRoute                 = $('#ohdPAMRoute').val();
    var tPAMSesSessionID        = $("#ohdSesSessionID").val();

 
    $(document).ready(function(){
        var nCrTerm = $('#ocmPAMTypePayment').val();
        if (nCrTerm == 2) {
            $('.xCNPanel_CreditTerm').show();
        }else{
            $('.xCNPanel_CreditTerm').hide();
        }
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
        if($('#oetPAMDocDate').val() == ''){
            $('#oetPAMDocDate').datepicker("setDate",dCurrentDate); 
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


        $('#obtPAMDocBrowsePdt').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                if($('#oetPAMFrmSplCode').val()!=""){
                JSxCheckPinMenuClose();
                JCNvPAMBrowsePdt();
                }else{
                    $('#odvPAMModalPleseselectSPL').modal('show');
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        if($('#oetPAMBchCode').val() == ""){
            $("#obtPAMFrmBrowseTaxAdd").attr("disabled","disabled");
        }

        /** =================== Event Search Function ===================== */
            $('#oliPAMMngPdtScan').unbind().click(function(){
                var tPAMSplCode  = $('#oetPAMFrmSplCode').val();
                if(typeof(tPAMSplCode) !== undefined && tPAMSplCode !== ''){
                    //Hide
                    $('#oetPAMFrmFilterPdtHTML').hide();
                    $('#obtPAMMngPdtIconSearch').hide();
                    
                    //Show
                    $('#oetPAMFrmSearchAndAddPdtHTML').show();
                    $('#obtPAMMngPdtIconScan').show();
                }else{
                    var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
            });
            $('#oliPAMMngPdtSearch').unbind().click(function(){
                //Hide
                $('#oetPAMFrmSearchAndAddPdtHTML').hide();
                $('#obtPAMMngPdtIconScan').hide();
                //Show
                $('#oetPAMFrmFilterPdtHTML').show();
                $('#obtPAMMngPdtIconSearch').show();
            });
        /** =============================================================== */

        /** ===================== Set Date Autometic Doc ========================  */
            var dCurrentDate    = new Date();
            var tAmOrPm         = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
            var tCurrentTime    = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes();

            if($('#oetPAMDocDate').val() == ''){
                $('#oetPAMDocDate').datepicker("setDate",dCurrentDate); 
            }

            if($('#oetPAMDocTime').val() == ''){
                $('#oetPAMDocTime').val(tCurrentTime);
            }
        /** =============================================================== */

        /** =================== Event Date Function  ====================== */
            $('#obtPAMDocDate').unbind().click(function(){
                $('#oetPAMDocDate').datepicker('show');
            });

            $('#obtPAMDocTime').unbind().click(function(){
                $('#oetPAMDocTime').datetimepicker('show');
            });

            $('#obtPAMBrowseRefIntDocDate').unbind().click(function(){
                $('#oetPAMRefIntDocDate').datepicker('show');
            });

            $('#obtPAMRefDocExtDate').unbind().click(function(){
                $('#oetPAMRefDocExtDate').datepicker('show');
            });

            $('#obtPAMTransDate').unbind().click(function(){
                $('#oetPAMTransDate').datepicker('show');
            });
        /** =============================================================== */

        /** ================== Check Box Auto GenCode ===================== */
            $('#ocbPAMStaAutoGenCode').on('change', function (e) {
                if($('#ocbPAMStaAutoGenCode').is(':checked')){
                    $("#oetPAMDocNo").val('');
                    $("#oetPAMDocNo").attr("readonly", true);
                    $('#oetPAMDocNo').closest(".form-group").css("cursor","not-allowed");
                    $('#oetPAMDocNo').css("pointer-events","none");
                    $("#oetPAMDocNo").attr("onfocus", "this.blur()");
                    $('#ofmPAMFormAdd').removeClass('has-error');
                    $('#ofmPAMFormAdd .form-group').closest('.form-group').removeClass("has-error");
                    $('#ofmPAMFormAdd em').remove();
                }else{
                    $('#oetPAMDocNo').closest(".form-group").css("cursor","");
                    $('#oetPAMDocNo').css("pointer-events","");
                    $('#oetPAMDocNo').attr('readonly',false);
                    $("#oetPAMDocNo").removeAttr("onfocus");
                }
            });
        /** =============================================================== */
    });
 
    // ========================================== Brows Option Conditon ===========================================
        // ตัวแปร Option Browse Modal คลังสินค้า
        var oWahOption      = function(poDataFnc){
            var tPAMBchCode          = poDataFnc.tPAMBchCode;
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
                    Condition : [" AND (TCNMWaHouse.FTWahStaType IN (1,2,5) AND  TCNMWaHouse.FTBchCode='"+tPAMBchCode+"')"]
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
                    FuncName:'JSxNextFuncPAMBch'
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

        function JSxNextFuncPAMBch() {
            $('#oetPAMFrmWahCode').val('');
            $('#oetPAMFrmWahName').val('');
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
                    FuncName:'JSxNextFuncPAMAgn'
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

    function JSxNextFuncPAMAgn() {
        $('#oetPAMBchCode').val('');
        $('#oetPAMBchName').val('');
        $('#oetPAMFrmWahCode').val('');
        $('#oetPAMFrmWahName').val('');
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
                FuncName:'JSxNextFuncPAMSpl',
                ArgReturn:['FTSplName', 'FTSplStaVATInOrEx', 'FNSplCrTerm']
            },
            RouteAddNew: 'supplier'
        };
        return oOptionReturn;
    }

    function JSxNextFuncPAMSpl(paData) {
        $("#oetPAMSplName").val("");
        $("#oetPAMFrmSplInfoCrTerm").val("");
        var tPAMSplName = '';
        var tPAMTypePayment = '';
        var tPAMFrmSplInfoCrTerm = '';
        var tPAMFrmSplInfoVatInOrEx = '';
        if (typeof(paData) != 'undefined' && paData != "NULL") {
            var aPAMSplData = JSON.parse(paData);
            tPAMSplName = aPAMSplData[0];
            tPAMFrmSplInfoVatInOrEx = aPAMSplData[1];
            tPAMTypePayment = aPAMSplData[2]
            tPAMFrmSplInfoCrTerm = aPAMSplData[2]
        }
        $("#oetPAMSplName").val(tPAMSplName);
        $("#oetPAMFrmSplInfoCrTerm").val(tPAMFrmSplInfoCrTerm);

        //ประเภทการชำระเงิน
        if (tPAMTypePayment > 0) {
            $("#ocmPAMTypePayment").val("2").selectpicker('refresh');
            $('.xCNPanel_CreditTerm').show();
        }else{
            $("#ocmPAMTypePayment").val("1").selectpicker('refresh');
            $('.xCNPanel_CreditTerm').hide();
        }

        //ประเภทภาษี
        if (tPAMFrmSplInfoVatInOrEx == 1) {
            //รวมใน
            $("#ocmPAMFrmSplInfoVatInOrEx").val("1").selectpicker('refresh');
        }else{
            //แยกนอก
            $("#ocmPAMFrmSplInfoVatInOrEx").val("2").selectpicker('refresh');
        }
        

    }
    // ============================================================================================================

    // ========================================== Brows Event Conditon ===========================================
        // Event Browse Warehouse
        $('#obtPAMBrowseWahouse').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPAMBrowseWahOption   = undefined;
                oPAMBrowseWahOption          = oWahOption({
                    'tPAMBchCode'        : $('#oetPAMBchCode').val(),
                    'tReturnInputCode'  : 'oetPAMFrmWahCode',
                    'tReturnInputName'  : 'oetPAMFrmWahName',
                    'aArgReturn'        : []
                });
                JCNxBrowseData('oPAMBrowseWahOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtPAMBrowseBCH').unbind().click(function(){ 
        var nStaSession = JCNxFuncChkSessionExpired();
        var tAgnCode = $('#oetPAMAgnCode').val();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPAMBrowseBranchOption  = undefined;
                oPAMBrowseBranchOption         = oBranchOption({
                    'tReturnInputCode'  : 'oetPAMBchCode',
                    'tReturnInputName'  : 'oetPAMBchName',
                    'tAgnCode'          : tAgnCode,
                    'aArgReturn'        : ['FTBchCode','FTBchName','FTWahCode','FTWahName'],
                });
                JCNxBrowseData('oPAMBrowseBranchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }

        });

        //BrowseAgn 
        $('#oimPAMBrowseAgn').click(function(e) {
            e.preventDefault();
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose();
                window.oPAMBrowseAgencyOption = oBrowseAgn({
                    'tReturnInputCode': 'oetPAMAgnCode',
                    'tReturnInputName': 'oetPAMAgnName',
                });
                JCNxBrowseData('oPAMBrowseAgencyOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        
        // Event Browse Supplier
        $('#obtPAMBrowseSupplier').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPAMBrowseSplOption   = undefined;
                oPAMBrowseSplOption          = oSplOption({
                    'tParamsAgnCode'    : '<?=$this->session->userdata("tSesUsrAgnCode")?>',
                    'tReturnInputCode'  : 'oetPAMFrmSplCode',
                    'tReturnInputName'  : 'oetPAMFrmSplName',
                    'aArgReturn'        : ['FTSplCode', 'FTSplName']
                });
                JCNxBrowseData('oPAMBrowseSplOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtPAMBrowseRefDocInt').on('click',function(){
            JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
            JSxCallPAMRefIntDoc();
        });

        //Browse เอกสารอ้างอิงภายใน
        function JSxCallPAMRefIntDoc(){
            var tBCHCode = $('#oetPAMBchCode').val()
            var tBCHName = $('#oetPAMBchName').val()
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docPAMCallRefIntDoc",
                data: {
                    'tBCHCode'      : tBCHCode,
                    'tBCHName'      : tBCHName,
                },
                cache: false,
                Timeout: 0,
                success: function (oResult){
                    JCNxCloseLoading();
                    $('#odvPAMFromRefIntDoc').html(oResult);
                    $('#odvPAMModalRefIntDoc').modal({backdrop : 'static' , show : true});
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
                $('#odvPAMModalPONoFound').modal('show');
            } else {
                JSxPAMSetPanelSupplierData(poParams);
                $('#oetPAMRefIntDoc').val(tRefIntDocNo);
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docPAMCallRefIntDocInsertDTToTemp",
                    data: {
                        'tPAMDocNo'          : $('#oetPAMDocNo').val(),
                        'tPAMFrmBchCode'     : $('#oetPAMBchCode').val(),
                        'tRefIntDocNo'      : tRefIntDocNo,
                        'tRefIntBchCode'    : tRefIntBchCode,
                        'aSeqNo'            : aSeqNo
                    },
                    cache: false,
                    Timeout: 0,
                    success: function (oResult){
                        JSvPAMLoadPdtDataTableHtml();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });

        $('#obtConfirmPo').on('click',function(){
            $('#odvPAMModalRefIntDoc').modal('show');
        });

        // Function : ฟังก์ชั่นเซทข้อมูล ผู้จำหน่าย
        function JSxPAMSetPanelSupplierData(poParams){
            // Reset Panel เป็นค่าเริ่มต้น
            $("#ocmPAMFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            $("#ocmPAMTypePayment.selectpicker").val("2").selectpicker("refresh");
            $("#oetPAMRefDocIntName").val(poParams.FTRefIntDocNo);
            $("#oetPAMRefIntDocDate").val(poParams.FTRefIntDocDate).datepicker("refresh")
            // ประเภทภาษี
            if(poParams.FTSplStaVATInOrEx == 1){
                // รวมใน
                $("#ocmPAMFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            }else{
                // แยกนอก
                $("#ocmPAMFrmSplInfoVatInOrEx.selectpicker").val("2").selectpicker("refresh");
            }

            // ประเภทชำระเงิน
            if(poParams.FCSplCrLimit > 0){
                // เงินเชื่อ
                $("#ocmPAMTypePayment.selectpicker").val("2").selectpicker("refresh");
                $('.xCNPanel_CreditTerm').show();
            }else{
                // เงินสด
                $("#ocmPAMTypePayment.selectpicker").val("1").selectpicker("refresh");
                $('.xCNPanel_CreditTerm').hide();
                
            }
            
            //ผู้ขาย
            $("#oetPAMFrmSplCode").val(poParams.FTSplCode);
            $("#oetPAMFrmSplName").val(poParams.FTSplName);
            $("#oetPAMSplName").val(poParams.FTSplName);
            $("#oetPAMFrmSplInfoCrTerm").val(poParams.FCSplCrLimit);
        }

//------------------------------------------------------------------------------------------------//

    // Validate From Add Or Update Document
    function JSxPAMValidateFormDocument(){
        if($("#ohdPAMCheckClearValidate").val() != 0){
            $('#ofmPAMFormAdd').validate().destroy();
        }

        $('#ofmPAMFormAdd').validate({
            focusInvalid: true,
            rules: {
                oetPAMDocNo : {
                    "required" : {
                        depends: function (oElement) {
                            if($("#ohdPAMRoute").val()  ==  "docPAMEventAdd"){
                                if($('#ocbPAMStaAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                            }else{
                                return false;
                            }
                        }
                    }
                },
                oetPAMBchName       : {"required" : true},
                // oetPAMFrmSplName : {"required" : true},
                // oetPAMFrmWahName : {"required" : true},
            },
            messages: {
                oetPAMDocNo         : {"required" : $('#oetPAMDocNo').attr('data-validate-required')},
                oetPAMBchName       : {"required" : $('#oetPAMBchName').attr('data-validate-required')},
                // oetPAMFrmSplName : {"required" : $('#oetPAMFrmSplName').attr('data-validate-required')},
                // oetPAMFrmWahName : {"required" : $('#oetPAMFrmWahName').attr('data-validate-required')},
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
                if(!$('#ocbPAMStaAutoGenCode').is(':checked')){
                    JSxPAMValidateDocCodeDublicate();
                }else{
                    if($("#ohdPAMCheckSubmitByButton").val() == 1){
                        JSxPAMSubmitEventByButton('');
                    }
                }
            },
        });
    }

    // Validate Doc Code (Validate ตรวจสอบรหัสเอกสาร)
    function JSxPAMValidateDocCodeDublicate(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "CheckInputGenCode",
            data: {
                'tTableName'    : 'TCNTPdtPickHD',
                'tFieldName'    : 'FTXthDocNo',
                'tCode'         : $('#oetPAMDocNo').val()
            },
            success: function (oResult) {
                var aResultData = JSON.parse(oResult);
                $("#ohdPAMCheckDuplicateCode").val(aResultData["rtCode"]);

                if($("#ohdPAMCheckClearValidate").val() != 1) {
                    $('#ofmPAMFormAdd').validate().destroy();
                }

                $.validator.addMethod('dublicateCode', function(value,element){
                    if($("#ohdPAMRoute").val() == "docPAMEventAdd"){
                        if($('#ocbPAMStaAutoGenCode').is(':checked')) {
                            return true;
                        }else{
                            if($("#ohdPAMCheckDuplicateCode").val() == 1) {
                                return false;
                            }else{
                                return true;
                            }
                        }
                    }else{
                        return true;
                    }
                });

                // Set Form Validate From Add Document
                $('#ofmPAMFormAdd').validate({
                    focusInvalid: false,
                    onclick: false,
                    onfocusout: false,
                    onkeyup: false,
                    rules: {
                        oetPAMDocNo : {"dublicateCode": {}}
                    },
                    messages: {
                        oetPAMDocNo : {"dublicateCode"  : $('#oetPAMDocNo').attr('data-validate-duplicate')}
                    },
                    errorElement: "em",
                    errorPlacement: function (error, element) {
                        error.addClass("help-block");
                        if(element.prop("type") === "checkbox") {
                            error.appendTo(element.parent("label"));
                        }else{
                            var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                            if (tCheck == 0) {
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
                    submitHandler: function (form) {
                        if($("#ohdPAMCheckSubmitByButton").val() == 1) {
                            JSxPAMSubmitEventByButton('');
                        }
                    }
                })

                if($("#ohdPAMCheckClearValidate").val() != 1) {
                    $("#ofmPAMFormAdd").submit();
                    $("#ohdPAMCheckClearValidate").val(1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Function: Validate Success And Send Ajax Add/Update Document
    function JSxPAMSubmitEventByButton(ptType){
        var tPAMDocNo = '';

        if($("#ohdPAMRoute").val() !=  "docPAMEventAdd"){
            var tPAMDocNo    = $('#oetPAMDocNo').val();
        }

        $.ajax({
            type: "POST",
            url: "docPAMChkHavePdtForDocDTTemp",
            data: {
                'ptPAMDocNo'         : tPAMDocNo,
                'tPAMSesSessionID'   : $('#ohdSesSessionID').val(),
                'tPAMUsrCode'        : $('#ohdPAMUsrCode').val(),
                'tPAMLangEdit'       : $('#ohdPAMLangEdit').val(),
                'tSesUsrLevel'       : $('#ohdSesUsrLevel').val(),
            },
            cache: false,
            timeout: 0,
            success: function (oResult){
                // JCNxCloseLoading();
                var aDataReturnChkTmp   = JSON.parse(oResult);
                $('.xWPAMDisabledOnApv').attr('disabled',false);
                if (aDataReturnChkTmp['nStaReturn'] == '1'){
                    $.ajax({
                        type    : "POST",
                        url     : $("#ohdPAMRoute").val(),
                        data    : $("#ofmPAMFormAdd").serialize(),
                        cache   : false,
                        timeout : 0,
                        success : function(oResult){
                            // JCNxCloseLoading();
                            var aDataReturnEvent    = JSON.parse(oResult);
                            if(aDataReturnEvent['nStaReturn'] == '1'){
                                var nPAMStaCallBack      = aDataReturnEvent['nStaCallBack'];
                                var nPAMDocNoCallBack    = aDataReturnEvent['tCodeReturn'];
                                var nPAMPayType          = $('#ocmPAMTypePayment').val();
                                var nPAMVatInOrEx        = $('#ocmPAMFrmSplInfoVatInOrEx').val();
                                var nPAMStaRef           = $('#ocmPAMFrmInfoOthRef').val();
                                
                                let oPAMCallDataTableFile = {
                                    ptElementID: 'odvPAMShowDataTable',
                                    ptBchCode: $('#oetPAMBchCode').val(),
                                    ptDocNo: nPAMDocNoCallBack,
                                    ptDocKey:'TCNTPdtPickHD',
                                }

                                JCNxUPFInsertDataFile(oPAMCallDataTableFile);

                                if( ptType == 'approve' ){
                                    JSxPAMApproveDocument(false);
                                }else{
                                    switch(nPAMStaCallBack){
                                        case '1' :
                                            JSvPAMCallPageEdit(nPAMDocNoCallBack,nPAMPayType,nPAMVatInOrEx,nPAMStaRef);
                                        break;
                                        case '2' :
                                            JSvPAMCallPageAddDoc();
                                        break;
                                        case '3' :
                                            JSvPAMCallPageList();
                                        break;
                                        default :
                                            JSvPAMCallPageEdit(nPAMDocNoCallBack,nPAMPayType,nPAMVatInOrEx,nPAMStaRef);
                                    }
                                }
                            }else{
                                var tMessageError = aDataReturnEvent['tStaMessg'];
                                FSvCMNSetMsgErrorDialog(tMessageError);
                            }
                        },
                        error   : function (jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }else if(aDataReturnChkTmp['nStaReturn'] == '800'){
                    var tMsgDataTempFound   = aDataReturnChkTmp['tStaMessg'];
                    FSvCMNSetMsgWarningDialog('<p class="text-left">'+tMsgDataTempFound+'</p>');
                }else{
                    var tMsgErrorFunction   = aDataReturnChkTmp['tStaMessg'];
                    FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //นับจำนวนรายการท้ายเอกสาร
    function JSxPAMCountPdtItems(){
        var nPdtItems = $('.xWPdtItem').length;
        $('.xShowQtyFooter').text(accounting.formatNumber(nPdtItems, 0, ','));
    }

    $('#ocmPAMTypePayment').on('change', function() {
        if (this.value == 1) {
            $('.xCNPanel_CreditTerm').hide();
        } else {
            $('.xCNPanel_CreditTerm').show();
        }
    });


    // Rabbit MQ
    function JSoPAMCallSubscribeMQ() {
        // Document variable
        var tLangCode = $("#ohdPAMLangEdit").val();
        var tUsrBchCode = $("#ohdPAMBchCode").val();
        var tUsrApv = '<?=$this->session->userdata('tSesUsername')?>';
        var tDocNo = $("#oetPAMDocNo").val();
        var tPrefix = "RESPAM";
        var tStaApv = $("#ohdPAMStaApv").val();
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
            tCallPageEdit: "JSvPAMCallPageEdit",
            tCallPageList: "JSvPAMCallPageList"
        };

        // Check Show Progress %
        FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
    }

    //พิมพ์เอกสาร
    function JSxPAMPrintDoc(){
        var aInfor = [
            {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'},
            {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'},
            {"BranchCode"   : '<?=FCNtGetAddressBranch(@$tPAMBchCode); ?>'},
            {"DocCode"      : '<?=@$tPAMDocNo; ?>'}, // เลขที่เอกสาร
            {"DocBchCode"   : '<?=@$tPAMBchCode;?>'}
        ];
        window.open("<?=base_url(); ?>formreport/Frm_SQL_ALLMPdtBillPick?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

    $(document).ready(function(){
        //อ้างอิงเอกสาร
        JSxPAMCallPageHDDocRef();
        JSxPAMEventCheckShowHDDocRef();
    });

    //โหลด Table อ้างอิงเอกสารทั้งหมด
    function JSxPAMCallPageHDDocRef(){
        $.ajax({
            type    : "POST",
            url     : "docPAMPageHDDocRefList",
            data:{
                'ptDocNo'       : $('#oetPAMDocNo').val(),
                'ptStaApv'      : $('#ohdPAMStaApv').val()
            },
            cache   : false,
            timeout : 0,
            success: function(oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == 1 ){
                    $('#odvPAMTableHDRef').html(aResult['tViewPageHDRef']);
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
    $('#obtPAMAddDocRef').off('click').on('click',function(){
        $('#ofmPAMFormAddDocRef').validate().destroy();
        JSxPAMEventClearValueInFormHDDocRef();
        $('#odvPAMModalAddDocRef').modal('show');
    });

    //เคลียร์ค่า
    function JSxPAMEventClearValueInFormHDDocRef(){
        $('#oetPAMRefDocNo').val('');
        $('#oetPAMRefDocDate').val('');
        $('#oetPAMDocRefInt').val('');
        $('#oetPAMDocRefIntName').val('');
        $('#oetPAMRefKey').val('');
    }

    //Default โชว์ panel ตามประเภท (ภายใน หรือ ภายนอก)
    function JSxPAMEventCheckShowHDDocRef(){
        var tPAMRefType = $('#ocbPAMRefType').val();
        if( tPAMRefType == '1' ){
            $('.xWShowRefExt').hide();
            $('.xWShowRefInt').show();
        }else{
            $('.xWShowRefInt').hide();
            $('.xWShowRefExt').show();
        }
    }

    //เมื่อเปลี่ยน ประเภท (ภายใน หรือ ภายนอก)
    $('#ocbPAMRefType').off('change').on('change',function(){
        $(this).selectpicker('refresh');
        JSxPAMEventCheckShowHDDocRef();
    });

    //กดเลือกอ้างอิงเอกสารภายใน (ใบจ่ายโอน - สาขา)
    $('#obtPAMBrowseRefDoc').unbind().click(function(){
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

    $('#obtPAMUpdateDoc').off('click').on('click',function(){
        JSxPAMEventUpdateDoc(false);
    });

    function JSxPAMEventUpdateDoc(pbEvent){
        if( pbEvent === true || pbEvent == 'true' ){
            JCNxOpenLoading();
            var tDocNo = $('#oetPAMDocNo').val();
            $.ajax({
                type    : "POST",
                url     : "docPAMEventUpdateDoc",
                data:{
                    'ptDocNo'       : tDocNo,
                    'ptBchCode'     : $('#oetPAMBchCode').val()
                },
                cache   : false,
                timeout : 0,
                success: function(oResult){
                    var aResult = JSON.parse(oResult);
                    if( aResult['nStaEvent'] == 1 ){
                        JSvPAMCallPageEdit(tDocNo);
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
            FSvCMNSetMsgWarningDialog('คุณต้องการปรับปรุงข้อมูลใช่หรือไม่ ระบบจะทำการยกเลิกอนุมัติเอกสาร','JSxPAMEventUpdateDoc','','true');
        }
    }

    // console.log( $('#ohdPAMAlwQtyPickNotEqQtyOrd').val() );

</script>