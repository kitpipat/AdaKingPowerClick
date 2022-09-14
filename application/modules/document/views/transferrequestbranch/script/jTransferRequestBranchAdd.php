<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
    var nLangEdits        = '<?php echo $this->session->userdata("tLangEdit");?>';
    var tUsrApvName       = '<?php echo $this->session->userdata("tSesUsername");?>';
    var tSesUsrLevel      = '<?php echo $this->session->userdata('tSesUsrLevel');?>';
    var tUserBchCode      = '<?php echo $this->session->userdata("tSesUsrBchCode");?>';
    var tUserBchName      = '<?php echo $this->session->userdata("tSesUsrBchName");?>';
    var tUserWahCode      = '<?php echo $this->session->userdata("tSesUsrWahCode");?>';
    // var tUserWahName      = '<?php //echo $this->session->userdata("tSesUsrWahName");?>';
    var tRoute                 = $('#ohdTRBRoute').val();
    var tTRBSesSessionID        = $("#ohdSesSessionID").val();

 
    $(document).ready(function(){
        var nCrTerm = $('#ocmTRBTypePayment').val();
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
        if($('#oetTRBDocDate').val() == ''){
            $('#oetTRBDocDate').datepicker("setDate",dCurrentDate); 
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


        $('#obtTRBDocBrowsePdt').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                if($('#oetTRBFrmSplCode').val()!=""){
                JSxCheckPinMenuClose();
                JCNvTRBBrowsePdt();
                }else{
                    $('#odvTRBModalPleseselectSPL').modal('show');
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        if($('#oetTRBFrmBchCode').val() == ""){
            $("#obtTRBFrmBrowseTaxAdd").attr("disabled","disabled");
        }

        /** =================== Event Search Function ===================== */
            $('#oliTRBMngPdtScan').unbind().click(function(){
                var tTRBSplCode  = $('#oetTRBFrmSplCode').val();
                if(typeof(tTRBSplCode) !== undefined && tTRBSplCode !== ''){
                    //Hide
                    $('#oetTRBFrmFilterPdtHTML').hide();
                    $('#obtTRBMngPdtIconSearch').hide();
                    
                    //Show
                    $('#oetTRBFrmSearchAndAddPdtHTML').show();
                    $('#obtTRBMngPdtIconScan').show();
                }else{
                    var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
            });
            $('#oliTRBMngPdtSearch').unbind().click(function(){
                //Hide
                $('#oetTRBFrmSearchAndAddPdtHTML').hide();
                $('#obtTRBMngPdtIconScan').hide();
                //Show
                $('#oetTRBFrmFilterPdtHTML').show();
                $('#obtTRBMngPdtIconSearch').show();
            });
        /** =============================================================== */

        /** ===================== Set Date Autometic Doc ========================  */
            var dCurrentDate    = new Date();
            //var tAmOrPm         = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
            var tCurrentTime    = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes();

            if($('#oetTRBDocDate').val() == ''){
                $('#oetTRBDocDate').datepicker("setDate",dCurrentDate); 
            }

            if($('#oetTRBDocTime').val() == ''){
                $('#oetTRBDocTime').val(tCurrentTime);
            }
        /** =============================================================== */

        /** =================== Event Date Function  ====================== */
            $('#obtTRBDocDate').unbind().click(function(){
                $('#oetTRBDocDate').datepicker('show');
            });

            $('#obtTRBDocTime').unbind().click(function(){
                $('#oetTRBDocTime').datetimepicker('show');
            });

            $('#obtTRBBrowseRefIntDocDate').unbind().click(function(){
                $('#oetTRBRefIntDocDate').datepicker('show');
            });

            $('#obtTRBRefDocExtDate').unbind().click(function(){
                $('#oetTRBRefDocExtDate').datepicker('show');
            });

            $('#obtTRBTransDate').unbind().click(function(){
                $('#oetTRBTransDate').datepicker('show');
            });
        /** =============================================================== */

        /** ================== Check Box Auto GenCode ===================== */
            $('#ocbTRBStaAutoGenCode').on('change', function (e) {
                if($('#ocbTRBStaAutoGenCode').is(':checked')){
                    $("#oetTRBDocNo").val('');
                    $("#oetTRBDocNo").attr("readonly", true);
                    $('#oetTRBDocNo').closest(".form-group").css("cursor","not-allowed");
                    $('#oetTRBDocNo').css("pointer-events","none");
                    $("#oetTRBDocNo").attr("onfocus", "this.blur()");
                    $('#ofmTRBFormAdd').removeClass('has-error');
                    $('#ofmTRBFormAdd .form-group').closest('.form-group').removeClass("has-error");
                    $('#ofmTRBFormAdd em').remove();
                }else{
                    $('#oetTRBDocNo').closest(".form-group").css("cursor","");
                    $('#oetTRBDocNo').css("pointer-events","");
                    $('#oetTRBDocNo').attr('readonly',false);
                    $("#oetTRBDocNo").removeAttr("onfocus");
                }
            });
        /** =============================================================== */
    });
 
    // ========================================== Brows Option Conditon ===========================================
        // ตัวแปร Option Browse Modal คลังสินค้า
        var oWahOption      = function(poDataFnc){
            var tTRBBchCode          = poDataFnc.tTRBBchCode;
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
                    Condition : [" AND (TCNMWaHouse.FTWahStaType IN (1,2,5) AND  TCNMWaHouse.FTBchCode='"+tTRBBchCode+"')"]
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
            var tNextFuncName    = poDataFnc.tNextFuncName;
            var tAgnCode            = poDataFnc.tAgnCode;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tBchCodeLock          = poDataFnc.tBchCodeLock;
            
            tUsrLevel = "<?=$this->session->userdata('tSesUsrLevel')?>";
            tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
            tSQLWhereBch = "";
            tSQLWhereAgn = "";

            if(tUsrLevel != "HQ"){
                tSQLWhereBch = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+")";
            }

            if(tAgnCode != ""){
                tSQLWhereAgn = " AND TCNMBranch.FTAgnCode IN ("+tAgnCode+")";
            }
            
            if(tBchCodeLock!=''){
                tSQLWhereBch += " AND TCNMBranch.FTBchCode <> '"+tBchCodeLock+"' ";
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
                    FuncName:tNextFuncName
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
            $('#oetTRBRefDocIntName').val('');
            $('#oetTRBRefIntDocDate').val('');
            // $('#oetTRBFrmWahCodeTo').val('');
            // $('#oetTRBFrmWahNameTo').val('');
        }

        function JSxNextFuncDOBchTo() {
            $('#oetTRBFrmWahCodeTo').val('');
            $('#oetTRBFrmWahNameTo').val('');
        }

        function JSxNextFuncDOBchShip() {
            $('#oetTRBFrmWahCodeShip').val('');
            $('#oetTRBFrmWahNameShip').val('');
        }

        //Option Agency
        var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
        var oBrowseAgn = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tAgnCodeLock = poReturnInput.tAgnCodeLock;
        var tFuncName = poReturnInput.tFuncName;

        if( tAgnCodeLock != "" ){
            tWhereAgency = " AND (TCNMAgency.FTAgnCode != '"+tAgnCodeLock+"') ";
        }else{
            tWhereAgency = "";
        }

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
            Where:{
                Condition : [tWhereAgency]
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
                    FuncName:tFuncName
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

    function JSxNextFuncTRBAgn() {
        $('#oetTRBFrmBchCode').val('');
        $('#oetTRBFrmBchName').val('');
        $('#oetTRBFrmWahCode').val('');
        $('#oetTRBFrmWahName').val('');
        $('#oetTRBRefDocIntName').val('');
        $('#oetTRBRefIntDocDate').val('');
    }

    function JSxNextFuncTRBAgnTo() {
        $('#oetTRBFrmBchCodeTo').val('');
        $('#oetTRBFrmBchNameTo').val('');
        $('#oetTRBFrmWahCodeTo').val('');
        $('#oetTRBFrmWahNameTo').val('');
    }

    function JSxNextFuncTRBAgnShip() {
        $('#oetTRBFrmBchCodeShip').val('');
        $('#oetTRBFrmBchNameShip').val('');
        $('#oetTRBFrmWahCodeShip').val('');
        $('#oetTRBFrmWahNameShip').val('');
    }

    var tStaUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';



    // ========================================== Brows Event Conditon ===========================================
        // Event Browse Warehouse
        $('#obtTRBBrowseWahouseTo').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oDOBrowseWahOption   = undefined;
                oDOBrowseWahOption          = oWahOption({
                    'tTRBBchCode'        : $('#oetTRBFrmBchCodeTo').val(),
                    'tReturnInputCode'  : 'oetTRBFrmWahCodeTo',
                    'tReturnInputName'  : 'oetTRBFrmWahNameTo',
                    'aArgReturn'        : []
                });
                JCNxBrowseData('oDOBrowseWahOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Browse Warehouse
        $('#obtTRBBrowseWahouseShip').unbind().click(function(){
        // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oDOBrowseWahOption   = undefined;
                oDOBrowseWahOption          = oWahOption({
                    'tTRBBchCode'        : $('#oetTRBFrmBchCodeShip').val(),
                    'tReturnInputCode'  : 'oetTRBFrmWahCodeShip',
                    'tReturnInputName'  : 'oetTRBFrmWahNameShip',
                    'aArgReturn'        : []
                });
                JCNxBrowseData('oDOBrowseWahOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtTRBBrowseBCH').unbind().click(function(){ 
        var nStaSession = JCNxFuncChkSessionExpired();
        var tAgnCode = $('#oetTRBAgnCode').val();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oDOBrowseBranchOption  = undefined;
                oDOBrowseBranchOption         = oBranchOption({
                    'tReturnInputCode'  : 'oetTRBFrmBchCode',
                    'tReturnInputName'  : 'oetTRBFrmBchName',
                    'tAgnCode'          : tAgnCode,
                    'tBchCodeLock'      : '',
                    'tNextFuncName'     : 'JSxNextFuncDOBch',
                    'aArgReturn'        : ['FTBchCode','FTBchName'],
                  
                });
                JCNxBrowseData('oDOBrowseBranchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }

        });

        $('#obtTRBBrowseBCHTo').unbind().click(function(){ 
        var nStaSession = JCNxFuncChkSessionExpired();
        var tAgnCode = $('#oetTRBAgnCodeTo').val();
        var tBchCodeLock = $('#oetTRBFrmBchCodeShip').val();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oDOBrowseBranchOption  = undefined;
                oDOBrowseBranchOption         = oBranchOption({
                    'tReturnInputCode'  : 'oetTRBFrmBchCodeTo',
                    'tReturnInputName'  : 'oetTRBFrmBchNameTo',
                    'tAgnCode'          : tAgnCode,
                    'tBchCodeLock'      : tBchCodeLock,
                    'tNextFuncName'     : 'JSxNextFuncDOBchTo',
                    'aArgReturn'        : ['FTBchCode','FTBchName'],
                });
                JCNxBrowseData('oDOBrowseBranchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }

        });

        $('#obtTRBBrowseBCHShip').unbind().click(function(){ 
        var nStaSession = JCNxFuncChkSessionExpired();
        var tAgnCode = $('#oetTRBAgnCodeShip').val();
        var tBchCodeLock = $('#oetTRBFrmBchCodeTo').val();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oDOBrowseBranchOption  = undefined;
                oDOBrowseBranchOption         = oBranchOption({
                    'tReturnInputCode'  : 'oetTRBFrmBchCodeShip',
                    'tReturnInputName'  : 'oetTRBFrmBchNameShip',
                    'tAgnCode'          : tAgnCode,
                    'tBchCodeLock'      : tBchCodeLock,
                    'tNextFuncName'     : 'JSxNextFuncDOBchShip',
                    'aArgReturn'        : ['FTBchCode','FTBchName'],
                });
                JCNxBrowseData('oDOBrowseBranchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }

        });

        //BrowseAgn 
        $('#oimTRBBrowseAgn').click(function(e) {
            e.preventDefault();
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose();
                window.oTRBBrowseAgencyOption = oBrowseAgn({
                    'tReturnInputCode': 'oetTRBAgnCode',
                    'tReturnInputName': 'oetTRBAgnName',
                    'tAgnCodeLock' : '',
                    'tFuncName' : 'JSxNextFuncTRBAgn',
                    'aArgReturn'      : ['FTAgnCode','FTAgnName'],
                });
                JCNxBrowseData('oTRBBrowseAgencyOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        
        //BrowseAgn To
        $('#oimTRBBrowseAgnTo').click(function(e) {
            e.preventDefault();
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose();
                window.oTRBBrowseAgencyOption = oBrowseAgn({
                    'tReturnInputCode': 'oetTRBAgnCodeTo',
                    'tReturnInputName': 'oetTRBAgnNameTo',
                    'tAgnCodeLock' : $('#oetTRBAgnCodeShip').val(),
                    'tFuncName' : 'JSxNextFuncTRBAgnTo',
                    'aArgReturn'      : ['FTAgnCode','FTAgnName'],
                });
                JCNxBrowseData('oTRBBrowseAgencyOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });


        //BrowseAgn Ship
        $('#oimTRBBrowseAgnShip').click(function(e) {
            e.preventDefault();
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose();
                window.oTRBBrowseAgencyOption = oBrowseAgn({
                    'tReturnInputCode': 'oetTRBAgnCodeShip',
                    'tReturnInputName': 'oetTRBAgnNameShip',
                    'tAgnCodeLock' : $('#oetTRBAgnCodeTo').val(),
                    'tFuncName' : 'JSxNextFuncTRBAgnShip',
                    'aArgReturn'      : ['FTAgnCode','FTAgnName'],
                });
                JCNxBrowseData('oTRBBrowseAgencyOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });




// เหตุผล
$('#obtTRBBrowseReason').click(function(){
    // $(".modal.fade:not(#odvAdjStkSubBrowseShipAdd, #odvModalDOCPDT, #odvModalWanning)").remove();
    // Option WareHouse
    oAdjStkSubBrowseReason = {
            Title: ['other/reason/reason', 'tRSNTitle'],
            Table: { Master:'TCNMRsn', PK:'FTRsnCode' },
            Join: {
                Table: ['TCNMRsn_L'],
                On: ['TCNMRsn.FTRsnCode = TCNMRsn_L.FTRsnCode AND TCNMRsn_L.FNLngID = '+nLangEdits]
            },
            Where: {
                Condition : ["AND TCNMRsn.FTRsgCode = '016' "] // Type โอน
            },
            GrideView:{
                ColumnPathLang: 'other/reason/reason',
                ColumnKeyLang: ['tRSNTBCode', 'tRSNTBName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
                DisabledColumns: [],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMRsn.FDCreateOn'],
                SourceOrder: "DESC"
            },
            CallBack:{
                ReturnType: 'S',
                Value: ["oetTRBReasonCode", "TCNMRsn.FTRsnCode"],
                Text: ["oetTRBReasonName", "TCNMRsn_L.FTRsnName"]
            },
            /*NextFunc:{
                FuncName:'JSxCSTAddSetAreaCode',
                ArgReturn:['FTRsnCode']
            },*/
            // RouteFrom : 'cardShiftChange',
            RouteAddNew : 'reason',
            BrowseLev : 0
    };
    // Option WareHouse
    JCNxBrowseData('oAdjStkSubBrowseReason');
});


        $('#obtTRBBrowseRefDocInt').on('click',function(){
            JSxCallDORefIntDoc();
        });

        //Browse เอกสารอ้างอิงภายใน
        function JSxCallDORefIntDoc(){
            var tBCHCode = $('#oetTRBFrmBchCode').val()
            var tBCHName = $('#oetTRBFrmBchName').val()
            
            console.log(tBCHName);
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docTRBCallRefIntDoc",
                data: {
                    'tBCHCode'      : tBCHCode,
                    'tBCHName'      : tBCHName,
                },
                cache: false,
                Timeout: 0,
                success: function (oResult){
                    JCNxCloseLoading();
                    $('#odvTRBFromRefIntDoc').html(oResult);
                    $('#odvTRBModalRefIntDoc').modal({backdrop : 'static' , show : true});
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
            JSxTRBSetPanelSupplierData(poParams);

            $('#oetTRBRefIntDoc').val(tRefIntDocNo);
            JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docTRBCallRefIntDocInsertDTToTemp",
                    data: {
                        'tTRBDocNo'          : $('#oetTRBDocNo').val(),
                        'tTRBFrmBchCode'     : $('#oetTRBFrmBchCode').val(),
                        'tRefIntDocNo'      : tRefIntDocNo,
                        'tRefIntBchCode'    : tRefIntBchCode,
                        'aSeqNo'            : aSeqNo
                    },
                    cache: false,
                    Timeout: 0,
                    success: function (oResult){
                        JSvTRBLoadPdtDataTableHtml();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

        });

        // Function : ฟังก์ชั่นเซทข้อมูล ผู้จำหน่าย
        function JSxTRBSetPanelSupplierData(poParams){
            // Reset Panel เป็นค่าเริ่มต้น
            $("#ohdTRBFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            $("#ocmTRBTypePayment.selectpicker").val("2").selectpicker("refresh");
            $("#oetTRBRefDocIntName").val(poParams.FTRefIntDocNo);
            $("#oetTRBRefIntDocDate").val(poParams.FTRefIntDocDate).datepicker("refresh");

            // ประเภทภาษี
            if(poParams.FTSplStaVATInOrEx === "1"){
                // รวมใน
                $("#ohdTRBFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            }else{
                // แยกนอก
                $("#ohdTRBFrmSplInfoVatInOrEx.selectpicker").val("2").selectpicker("refresh");
            }

            // ประเภทชำระเงิน
            if(poParams.FCSplCrLimit > 0){
                // เงินเชื่อ
                $("#ocmTRBTypePayment.selectpicker").val("2").selectpicker("refresh");
            }else{
                // เงินสด
                $("#ocmTRBTypePayment.selectpicker").val("1").selectpicker("refresh");
            }
            
            //ผู้ขาย
            $("#oetTRBFrmSplCode").val(poParams.FTSplCode);
            $("#oetTRBFrmSplName").val(poParams.FTSplName);
            $("#oetTRBSplName").val(poParams.FTSplName);
            $("#oetTRBFrmSplInfoCrTerm").val(poParams.FCSplCrLimit);
        }

//------------------------------------------------------------------------------------------------//

    // Validate From Add Or Update Document
    function JSxTRBValidateFormDocument(){
        if($("#ohdTRBCheckClearValidate").val() != 0){
            $('#ofmTRBFormAdd').validate().destroy();
        }
        var tTRBStaDoc = $('#ohdTRBStaDoc').val();

        if (tTRBStaDoc != 3) {
            $('#ofmTRBFormAdd').validate({
                focusInvalid: true,
                rules: {
                    oetTRBDocNo : {
                        "required" : {
                            depends: function (oElement) {
                                if($("#ohdTRBRoute").val()  ==  "docTRBEventAdd"){
                                    if($('#ocbTRBStaAutoGenCode').is(':checked')){
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
                    oetTRBFrmBchName    : {"required" : true},
                    oetTRBFrmBchNameTo : {"required" : true},
                    oetTRBFrmBchNameShip : {"required" : true},
                    oetTRBFrmWahNameTo : {"required" : true},
                    oetTRBFrmWahNameShip : {"required" : true},
                    oetTRBReasonName : {"required" : true},
                    
                },
                messages: {
                    oetTRBDocNo      : {"required" : $('#oetTRBDocNo').attr('data-validate-required')},
                    oetTRBFrmBchName : {"required" : $('#oetTRBFrmBchName').attr('data-validate-required')},
                    oetTRBFrmBchNameShip : {"required" : $('#oetTRBFrmBchNameShip').attr('data-validate-required')},
                    oetTRBFrmWahNameTo : {"required" : $('#oetTRBFrmBchNameShip').attr('data-validate-required')},
                    oetTRBFrmWahNameShip : {"required" : $('#oetTRBFrmBchNameShip').attr('data-validate-required')},
                    oetTRBReasonName : {"required" : $('#oetTRBReasonName').attr('data-validate-required')},
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
                    if(!$('#ocbTRBStaAutoGenCode').is(':checked')){
                        JSxTRBValidateDocCodeDublicate();
                    }else{
                        if($("#ohdTRBCheckSubmitByButton").val() == 1){
                            JSxTRBSubmitEventByButton();
                        }
                    }
                },
            });
        }else{
            if(!$('#ocbTRBStaAutoGenCode').is(':checked')){
                JSxTRBValidateDocCodeDublicate();
            }else{
                if($("#ohdTRBCheckSubmitByButton").val() == 1){
                    JSxTRBSubmitEventByButton();
                }
            }
        }
    }

    // Validate Doc Code (Validate ตรวจสอบรหัสเอกสาร)
    function JSxTRBValidateDocCodeDublicate(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "CheckInputGenCode",
            data: {
                'tTableName'    : 'TCNTPdtReqBchHD',
                'tFieldName'    : 'FTXthDocNo',
                'tCode'         : $('#oetTRBDocNo').val()
            },
            success: function (oResult) {
                var aResultData = JSON.parse(oResult);
                $("#ohdTRBCheckDuplicateCode").val(aResultData["rtCode"]);

                if($("#ohdTRBCheckClearValidate").val() != 1) {
                    $('#ofmTRBFormAdd').validate().destroy();
                }

                $.validator.addMethod('dublicateCode', function(value,element){
                    if($("#ohdTRBRoute").val() == "docTRBEventAdd"){
                        if($('#ocbTRBStaAutoGenCode').is(':checked')) {
                            return true;
                        }else{
                            if($("#ohdTRBCheckDuplicateCode").val() == 1) {
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
                $('#ofmTRBFormAdd').validate({
                    focusInvalid: false,
                    onclick: false,
                    onfocusout: false,
                    onkeyup: false,
                    rules: {
                        oetTRBDocNo : {"dublicateCode": {}}
                    },
                    messages: {
                        oetTRBDocNo : {"dublicateCode"  : $('#oetTRBDocNo').attr('data-validate-duplicate')}
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
                        if($("#ohdTRBCheckSubmitByButton").val() == 1) {
                            JSxTRBSubmitEventByButton();
                        }
                    }
                })

                if($("#ohdTRBCheckClearValidate").val() != 1) {
                    $("#ofmTRBFormAdd").submit();
                    $("#ohdTRBCheckClearValidate").val(1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Function: Validate Success And Send Ajax Add/Update Document
    function JSxTRBSubmitEventByButton(){
        var tTRBDocNo = '';

        if($("#ohdTRBRoute").val() !=  "docTRBEventAdd"){
            var tTRBDocNo    = $('#oetTRBDocNo').val();
        }
        var tTRBAgnCode = $("#oetTRBAgnCode").val();
        var tTRBFrmBchCode = $("#oetTRBFrmBchCode").val();
        $.ajax({
            type: "POST",
            url: "docTRBChkHavePdtForDocDTTemp",
            data: {
                'ptBchCode'          : tTRBFrmBchCode,
                'ptAgnCode'          : tTRBAgnCode,
                'ptTRBDocNo'         : tTRBDocNo,
                'tTRBSesSessionID'   : $('#ohdSesSessionID').val(),
                'tTRBUsrCode'        : $('#ohdTRBUsrCode').val(),
                'tTRBLangEdit'       : $('#ohdTRBLangEdit').val(),
                'tSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
            },
            cache: false,
            timeout: 0,
            success: function (oResult){
                // JCNxCloseLoading();
                var aDataReturnChkTmp   = JSON.parse(oResult);
                $('.xWTRBDisabledOnApv').attr('disabled',false);
                if (aDataReturnChkTmp['nStaReturn'] == '1'){
                    $.ajax({
                        type    : "POST",
                        url     : $("#ohdTRBRoute").val(),
                        data    : $("#ofmTRBFormAdd").serialize(),
                        cache   : false,
                        timeout : 0,
                        success : function(oResult){
                            // JCNxCloseLoading();
                            var aDataReturnEvent    = JSON.parse(oResult);
                            if(aDataReturnEvent['nStaReturn'] == '1'){
                                var nDOStaCallBack      = aDataReturnEvent['nStaCallBack'];
                                var nDODocNoCallBack    = aDataReturnEvent['tCodeReturn'];

                                let oDOCallDataTableFile = {
                                    ptElementID: 'odvTRBShowDataTable',
                                    ptBchCode: $('#oetTRBFrmBchCode').val(),
                                    ptDocNo: nDODocNoCallBack,
                                    ptDocKey:'TCNTPdtReqBchHD',
                                }

                                JCNxUPFInsertDataFile(oDOCallDataTableFile);

                                switch(nDOStaCallBack){
                                    case '1' :
                                        JSvTRBCallPageEdit(tTRBFrmBchCode,tTRBAgnCode,nDODocNoCallBack);
                                    break;
                                    case '2' :
                                        JSvTRBCallPageAddDoc();
                                    break;
                                    case '3' :
                                        JSvTRBCallPageList();
                                    break;
                                    default :
                                        JSvTRBCallPageEdit(tTRBFrmBchCode,tTRBAgnCode,nDODocNoCallBack);
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
    function JSxTRBCountPdtItems(){
        var nPdtItems = $('.xWPdtItem').length;
        $('.xShowQtyFooter').text(accounting.formatNumber(nPdtItems, 0, ','));
    }

    $('#ocmTRBTypePayment').on('change', function() {
        if (this.value == 1) {
            $('.xCNPanel_CreditTerm').hide();
        } else {
            $('.xCNPanel_CreditTerm').show();
        }
    });

    //พิมพ์เอกสาร
    function JSxTRBPrintDoc(){
        var aInfor = [
            {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'},
            {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'},
            {"BranchCode"   : '<?=FCNtGetAddressBranch(@$tTRBBchCode); ?>'},
            {"DocCode"      : '<?=@$tTRBDocNo; ?>'}, // เลขที่เอกสาร
            {"DocBchCode"   : '<?=@$tTRBBchCode;?>'}
        ];
        window.open("<?=base_url(); ?>formreport/Frm_SQL_ALLMPdtReqTnfBch?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

    $(document).ready(function(){
        //อ้างอิงเอกสาร
        JSxTRBCallPageHDDocRef();
        // JSxTBOEventCheckShowHDDocRef();
    });

    //โหลด Table อ้างอิงเอกสารทั้งหมด
    function JSxTRBCallPageHDDocRef(){
        $.ajax({
            type    : "POST",
            url     : "docTRBPageHDDocRef",
            data:{
                'ptDocNo'       : $('#oetTRBDocNo').val(),
                'ptStaApv'      : $('#ohdTRBStaApv').val()
            },
            cache   : false,
            timeout : 0,
            success: function(oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == 1 ){
                    $('#odvTRBTableHDRef').html(aResult['tViewPageHDRef']);
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



</script>