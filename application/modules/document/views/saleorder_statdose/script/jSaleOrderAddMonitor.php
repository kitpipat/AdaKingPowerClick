<script type="text/javascript">
    var nLangEdits      = '<?php echo $this->session->userdata("tLangEdit");?>';
    var tUsrApvName     = '<?php echo $this->session->userdata("tSesUsername");?>';
    var tSesUsrLevel    = '<?php echo $this->session->userdata('tSesUsrLevel');?>';

    $(document).ready(function(){
        

        $('.selectpicker').selectpicker('refresh');

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });

        $('.xCNTimePicker').datetimepicker({
            format: 'LT'
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


        $('#obtSODocBrowsePdt').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                JCNvSOBrowsePdt();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        if($('#oetSOFrmBchCode').val() == ""){
            $("#obtSOFrmBrowseTaxAdd").attr("disabled","disabled");
        }

        /** =================== Event Search Function ===================== */
            $('#oliSOMngPdtScan').unbind().click(function(){
                var tSOSplCode  = $('#oetSOFrmSplCode').val();
                if(typeof(tSOSplCode) !== undefined && tSOSplCode !== ''){
                    //Hide
                    $('#oetSOFrmFilterPdtHTML').hide();
                    $('#obtSOMngPdtIconSearch').hide();
                    
                    //Show
                    $('#oetSOFrmSearchAndAddPdtHTML').show();
                    $('#obtSOMngPdtIconScan').show();
                }else{
                    var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
            });
            $('#oliSOMngPdtSearch').unbind().click(function(){
                //Hide
                $('#oetSOFrmSearchAndAddPdtHTML').hide();
                $('#obtSOMngPdtIconScan').hide();
                //Show
                $('#oetSOFrmFilterPdtHTML').show();
                $('#obtSOMngPdtIconSearch').show();
            });
        /** =============================================================== */

        /** ===================== Set Date Autometic Doc ========================  */
            var dCurrentDate    = new Date();
            var tAmOrPm         = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
            var tCurrentTime    = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

            if($('#oetSODocDate').val() == ''){
                $('#oetSODocDate').datepicker("setDate",dCurrentDate); 
            }

            if($('#oetSODocTime').val() == ''){
                $('#oetSODocTime').val(tCurrentTime);
            }
        /** =============================================================== */

        /** =================== Event Date Function  ====================== */
            $('#obtSODocDate').unbind().click(function(){
                $('#oetSODocDate').datepicker('show');
            });

            $('#obtSODocTime').unbind().click(function(){
                $('#oetSODocTime').datetimepicker('show');
            });

            $('#obtSOBrowseRefIntDocDate').unbind().click(function(){
                $('#oetSORefIntDocDate').datepicker('show');
            });

            $('#obtSOBrowseRefExtDocDate').unbind().click(function(){
                $('#oetSORefExtDocDate').datepicker('show');
            });

            $('#obtSOFrmSplInfoDueDate').unbind().click(function(){
                $('#oetSOFrmSplInfoDueDate').datepicker('show');
            });

            $('#obtSOFrmSplInfoBillDue').unbind().click(function(){
                $('#oetSOFrmSplInfoBillDue').datepicker('show');
            });

            $('#obtSOFrmSplInfoTnfDate').unbind().click(function(){
                $('#oetSOFrmSplInfoTnfDate').datepicker('show');
            });
        /** =============================================================== */

        /** ================== Check Box Auto GenCode ===================== */
            $('#ocbSOStaAutoGenCode').on('change', function (e) {
                if($('#ocbSOStaAutoGenCode').is(':checked')){
                    $("#oetSODocNo").val('');
                    $("#oetSODocNo").attr("readonly", true);
                    $('#oetSODocNo').closest(".form-group").css("cursor","not-allowed");
                    $('#oetSODocNo').css("pointer-events","none");
                    $("#oetSODocNo").attr("onfocus", "this.blur()");
                    $('#ofmSOFormAdd').removeClass('has-error');
                    $('#ofmSOFormAdd .form-group').closest('.form-group').removeClass("has-error");
                    $('#ofmSOFormAdd em').remove();
                }else{
                    $('#oetSODocNo').closest(".form-group").css("cursor","");
                    $('#oetSODocNo').css("pointer-events","");
                    $('#oetSODocNo').attr('readonly',false);
                    $("#oetSODocNo").removeAttr("onfocus");
                }
            });
        /** =============================================================== */

        $('#ocmSOFrmSplInfoVatInOrEx').on('change', function (e) {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                JSvSOLoadPdtDataTableHtmlMonitor();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // JSxSOChkStaDocCallModalMQ();


        // Event Click Appove Document
        $('#obtSOApproveDoc').unbind().click(function(){
           
           var nStaSession = JCNxFuncChkSessionExpired();
           if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {

                JSxSOSetStatusClickSubmit(2);
               
                //ซ้อนตัวเดิม
                $('#odvSOModalAppoveDocTxn').modal("hide");
                setTimeout(function(){
                    JSxSOApproveDocument(false);
                }, 500);

           }else{
               JCNxShowMsgSessionExpired();
           }
       });
    });

    //กดปิด modal approve
    function JSxSOCancelApproveDocument(pbIsConfirm){
        $('#odvSOModalAppoveDocTxn').modal("show");
    }


    var SecondTimeCountDonw = Math.abs(parseFloat($('#ohdSOSecondTimeCountDonw').val()));
    //var oMyVar = setTimeout(JSxSORunDownSecondTime, SecondTimeCountDonw);

    $('#obtSOCallBackPage').click(function(){
        // alert(111);
        clearTimeout(oMyVar);
    });
    $('#obtSOCallBackPage1').click(function(){
        // alert(222);
        clearTimeout(oMyVar);
    });
    $("ul.get-menu li > a").click(function () {
        localStorage.setItem("SucOnSO", 1);
        clearTimeout(oMyVar);
    });

   function JSxSORunDownSecondTime(){
        var nStaSession = JCNxFuncChkSessionExpired();
         if(typeof nStaSession !== "undefined" && nStaSession == 1) {
            if($('#ohdPageMnitor').val()==2){
            JSvCHKSoCallPageMain();
            }
         }else{
            JCNxShowMsgSessionExpired();
         }
    }
 
    // ========================================== Brows Option Conditon ===========================================
        // ตัวแปร Option Browse Modal กลุ่มธุรกิจ
        var oMerchantOption = function(poDataFnc){
            var tSOBchCode          = poDataFnc.tSOBchCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";
            
            // สถานะกลุ่มธุรกิจต้องใช้งานเท่านั้น
            tWhereModal += " AND (TCNMMerchant.FTMerStaActive = 1)";

            // เช็คเงื่อนไขแสดงกลุ่มธุรกิจเฉพาะสาขาตัวเอง
            if(typeof(tSOBchCode) != undefined && tSOBchCode != ""){
                tWhereModal += " AND ((SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '"+tSOBchCode+"') != 0)";
            }

            // ตัวแปร ออฟชั่นในการ Return
            var oOptionReturn       = {
                Title   : ['company/merchant/merchant','tMerchantTitle'],
                Table   : {Master:'TCNMMerchant',PK:'FTMerCode'},
                Join    : {
                    Table : ['TCNMMerchant_L'],
                    On : ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits]
                },
                Where : {
                    Condition : [tWhereModal]
                },
                GrideView : {
                    ColumnPathLang	: 'company/merchant/merchant',
                    ColumnKeyLang	: ['tMerCode','tMerName'],
                    ColumnsSize     : ['15%','75%'],
                    WidthModal      : 50,
                    DataColumns		: ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
                    DataColumnsFormat : ['',''],
                    Perpage			: 5,
                    OrderBy			: ['TCNMMerchant.FTMerCode ASC'],
                },
                CallBack : {
                    ReturnType	: 'S',
                    Value		: [tInputReturnCode,"TCNMMerchant.FTMerCode"],
                    Text		: [tInputReturnName,"TCNMMerchant_L.FTMerName"],
                },
                NextFunc : {
                    FuncName    : tNextFuncName,
                    ArgReturn   : aArgReturn
                },
                RouteAddNew: 'merchant',
                BrowseLev: nSOStaSOBrowseType
            };
            return oOptionReturn;
        }
        
        // ตัวแปร Option Browse Modal ร้านค้า
        var oShopOption     = function(poDataFnc){
            var tSOBchCode          = poDataFnc.tSOBchCode;
            var tSOMerCode          = poDataFnc.tSOMerCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";

            // สถานะร้านค้าใช้งาน
            tWhereModal += " AND (TCNMShop.FTShpStaActive = 1)";

            // เช็คเงื่อนไขแสดงร้านค้าในสาขาตัวเอง
            if(typeof(tSOBchCode) != undefined && tSOBchCode != ""){
                tWhereModal += " AND ((TCNMShop.FTBchCode = '"+tSOBchCode+"') AND TCNMShop.FTShpType  != 5)"
            }

            // เช็คเงื่อนไขแสดงร้านค้าในกลุ่มธุรกิจตัวเอง
            if(typeof(tSOMerCode) != undefined && tSOMerCode != ""){
                tWhereModal += " AND ((TCNMShop.FTMerCode = '"+tSOMerCode+"') AND TCNMShop.FTShpType  != 5)";

            }

            // ตัวแปร ออฟชั่นในการ Return
            var oOptionReturn   = {
                Title: ["company/shop/shop","tSHPTitle"],
                Table: {Master:"TCNMShop",PK:"FTShpCode"},
                Join: {
                    Table: ['TCNMShop_L','TCNMWaHouse_L'],
                    On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                        'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= '+nLangEdits
                    ]
                },
                Where: {
                    Condition: [tWhereModal]
                },
                GrideView: {
                    ColumnPathLang      : 'company/shop/shop',
                    ColumnKeyLang       : ['tShopCode','tShopName'],
                    ColumnsSize         : ['15%','75%'],
                    WidthModal          : 50,
                    DataColumns         : ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName','TCNMShop.FTWahCode','TCNMWaHouse_L.FTWahName','TCNMShop.FTShpType','TCNMShop.FTBchCode'],
                    DataColumnsFormat   : ['','','','','',''],
                    DisabledColumns     : [2,3,4,5],
                    Perpage             : 10,
                    OrderBy			    : ['TCNMShop_L.FTShpName ASC'],
                },
                CallBack: {
                    ReturnType	: 'S',
                    Value		: [tInputReturnCode,"TCNMShop.FTShpCode"],
                    Text		: [tInputReturnName,"TCNMShop_L.FTShpName"],
                },
                NextFunc:{
                    FuncName    : tNextFuncName,
                    ArgReturn   : aArgReturn
                },
                RouteAddNew: 'shop',
                BrowseLev : nSOStaSOBrowseType
            };
            return oOptionReturn;
        }

        // ตัวแปร Option Browse Modal เครื่องจุดขาย
        var oPosOption      = function(poDataFnc){
            var tSOBchCode          = poDataFnc.tSOBchCode;
            var tSOShpCode          = poDataFnc.tSOShpCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";

            // สถานะเครื่องจุดขายต้องใช้งาน
            tWhereModal +=  " AND (TCNMPos.FTPosStaUse  = 1)";

            // เช็คเงื่อนไขแสดงร้านค้าในสาขาตัวเอง
            if(typeof(tSOBchCode) != undefined && tSOBchCode != ""){
                tWhereModal += " AND ((TVDMPosShop.FTBchCode = '"+tSOBchCode+"') AND TVDMPosShop.FTPshStaUse = 1)";
            }

            // เช็คเงื่อนไขแสดงร้านค้าในร้านค้าตัวเอง
            if(typeof(tSOShpCode) != undefined && tSOShpCode != ""){
                tWhereModal += " AND ((TVDMPosShop.FTShpCode = '"+tSOShpCode+"') AND TVDMPosShop.FTPshStaUse = 1)";
            }

            // ตัวแปร ออฟชั่นในการ Return
            var oOptionReturn   = {
                Title: ["pos/posshop/posshop","tPshTitle"],
                Table: { Master:'TVDMPosShop', PK:'FTPosCode' },
                Join: {
                    Table: ['TCNMPos', 'TCNMPosLastNo', 'TCNMWaHouse', 'TCNMWaHouse_L'],
                    On: [
                        "TVDMPosShop.FTPosCode = TCNMPos.FTPosCode",
                        "TVDMPosShop.FTPosCode = TCNMPosLastNo.FTPosCode",
                        "TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTWahStaType = 6",
                        "TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID = '"+nLangEdits+"'"
                    ]
                },
                Where: {
                    Condition : [tWhereModal]
                },
                GrideView: {
                    ColumnPathLang: 'pos/posshop/posshop',
                    ColumnKeyLang: ['tPshBRWShopTBCode', 'tPshBRWPosTBName'],
                    ColumnsSize: ['25%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TVDMPosShop.FTPosCode', 'TCNMPosLastNo.FTPosComName', 'TVDMPosShop.FTShpCode', 'TVDMPosShop.FTBchCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName','TVDMPosShop.FTPshStaUse'],
                    DataColumnsFormat : ['', '', '', '', '', ''],
                    DisabledColumns: [2, 3, 4, 5, 6],
                    Perpage: 5,
                    OrderBy: ['TVDMPosShop.FTPosCode ASC'],
                },
                CallBack: {
                    ReturnType  : 'S',
                    Value       : [tInputReturnCode,"TVDMPosShop.FTPosCode"],
                    Text        : [tInputReturnName,"TCNMPosLastNo.FTPosComName"]
                },
                NextFunc: {
                    FuncName    : tNextFuncName,
                    ArgReturn   : aArgReturn
                },
                RouteAddNew: 'salemachine',
                BrowseLev : nSOStaSOBrowseType
            };
            return oOptionReturn;
        }

        // ตัวแปร Option Browse Modal คลังสินค้า
        var oWahOption      = function(poDataFnc){
            var tSOShpCode          = poDataFnc.tSOShpCode;
            var tSOPosCode          = poDataFnc.tSOPosCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";

            // Where คลังของ สาขา
            if(tSOShpCode == "" && tSOPosCode == ""){
                tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (1,2,5))";
            }

            // Where คลังของ ร้านค้า
            if(tSOShpCode  != "" && tSOPosCode == ""){
                tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (4))";
                tWhereModal += " AND (TCNMWaHouse.FTWahRefCode = '"+tSOShpCode+"')";
            }

            // Where คลังของ เครื่องจุดขาย
            if(tSOShpCode  != "" && tSOPosCode != ""){
                tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (6))";
                tWhereModal += " AND (TCNMWaHouse.FTWahRefCode = '"+tSOPosCode+"')";
            }

            var oOptionReturn   = {
                Title: ["company/warehouse/warehouse","tWAHTitle"],
                Table: { Master:"TCNMWaHouse", PK:"FTWahCode"},
                Join: {
                    Table: ["TCNMWaHouse_L"],
                    On: ["TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID = '"+nLangEdits+"'"]
                },
                Where: {
                    Condition : [tWhereModal]
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
                NextFunc: {
                    FuncName    : tNextFuncName,
                    ArgReturn   : aArgReturn
                },
                RouteAddNew: 'warehouse',
                BrowseLev : nSOStaSOBrowseType
            }
            return oOptionReturn;
        }

        // ตัวแปร Option Browse Modal ตัวแทนจำหน่าย
        var oSplOption      = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var oOptionReturn       = {
                Title: ['supplier/supplier/supplier', 'tSPLTitle'],
                Table: {Master:'TCNMSpl', PK:'FTSplCode'},
                Join: {
                    Table: ['TCNMSpl_L', 'TCNMSplCredit'],
                    On: [
                        'TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = '+nLangEdits,
                        'TCNMSpl_L.FTSplCode = TCNMSplCredit.FTSplCode'
                    ]
                },
                Where:{
                    Condition : ["AND TCNMSpl.FTSplStaActive = '1' "]
                },
                GrideView:{
                    ColumnPathLang: 'supplier/supplier/supplier',
                    ColumnKeyLang: ['tSPLTBCode', 'tSPLTBName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMSpl.FTSplCode', 'TCNMSpl_L.FTSplName', 'TCNMSplCredit.FNSplCrTerm', 'TCNMSplCredit.FCSplCrLimit', 'TCNMSpl.FTSplStaVATInOrEx', 'TCNMSplCredit.FTSplTspPaid'],
                    DataColumnsFormat: ['',''],
                    DisabledColumns: [2, 3, 4, 5],
                    Perpage: 5,
                    OrderBy: ['TCNMSpl_L.FTSplName ASC']
                },
                CallBack:{
                    ReturnType: 'S',
                    Value   : [tInputReturnCode,"TCNMSpl.FTSplCode"],
                    Text    : [tInputReturnName,"TCNMSpl_L.FTSplName"]
                },
                NextFunc:{
                    FuncName    : tNextFuncName,
                    ArgReturn   : aArgReturn
                },
                RouteAddNew: 'supplier',
                BrowseLev: nSOStaSOBrowseType
            };
            return oOptionReturn;
        }



                // ตัวแปร Option Browse Modal ตัวแทนจำหน่าย
        var oCstOption      = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var oOptionReturn       = {
                Title: ['customer/customer/customer', 'tCSTTitle'],
                Table: {Master:'TCNMCst', PK:'FTCstCode'},
                Join: {
                    Table: ['TCNMCst_L', 'TCNMCstCredit'],
                    On: [
                        'TCNMCst_L.FTCstCode = TCNMCst.FTCstCode AND TCNMCst_L.FNLngID = '+nLangEdits,
                        'TCNMCst_L.FTCstCode = TCNMCstCredit.FTCstCode'
                    ]
                },
                Where:{
                    Condition : ["AND TCNMCst.FTCstStaActive = '1' "]
                },
                GrideView:{
                    ColumnPathLang: 'customer/customer/customer',
                    ColumnKeyLang: ['tCSTCode', 'tCSTName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMCst.FTCstCode', 'TCNMCst_L.FTCstName','TCNMCst.FTCstCardID','TCNMCst.FTCstTel'],
                    DataColumnsFormat: ['',''],
                    DisabledColumns: [2, 3, 4, 5],
                    Perpage: 5,
                    OrderBy: ['TCNMCst_L.FTCstName ASC']
                },
                CallBack:{
                    ReturnType: 'S',
                    Value   : [tInputReturnCode,"TCNMCst.FTCstCode"],
                    Text    : [tInputReturnName,"TCNMCst_L.FTCstName"]
                },
                NextFunc:{
                    FuncName    : tNextFuncName,
                    ArgReturn   : aArgReturn
                },
                RouteAddNew: 'customer',
                BrowseLev: 1
            };
            return oOptionReturn;
        }




    // ============================================================================================================

    // ========================================== Brows Event Conditon ===========================================
        // Event Browse Merchant
        $('#obtSOBrowseMerchant').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oSOBrowseMerchantOption  = undefined;
                oSOBrowseMerchantOption         = oMerchantOption({
                    'tSOBchCode'        : $('#oetSOFrmBchCode').val(),
                    'tReturnInputCode'  : 'oetSOFrmMerCode',
                    'tReturnInputName'  : 'oetSOFrmMerName',
                    'tNextFuncName'     : 'JSxSOSetConditionMerchant',
                    'aArgReturn'        : ['FTMerCode','FTMerName'],
                });
                JCNxBrowseData('oSOBrowseMerchantOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        
        // Event Browse Shop
        $('#obtSOBrowseShop').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oSOBrowseShopOption  = undefined;
                oSOBrowseShopOption         = oShopOption({
                    'tSOBchCode'        : $('#oetSOFrmBchCode').val(),
                    'tSOMerCode'        : $('#oetSOFrmMerCode').val(),
                    'tReturnInputCode'  : 'oetSOFrmShpCode',
                    'tReturnInputName'  : 'oetSOFrmShpName',
                    'tNextFuncName'     : 'JSxSOSetConditionShop',
                    'aArgReturn'        : ['FTBchCode','FTShpType','FTShpCode','FTShpName','FTWahCode','FTWahName']
                });
                JCNxBrowseData('oSOBrowseShopOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Browse Pos
        $('#obtSOBrowsePos').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oSOBrowsePosOption   = undefined;
                oSOBrowsePosOption          = oPosOption({
                    'tSOBchCode'        : $('#oetSOFrmBchCode').val(),
                    'tSOShpCode'        : $('#oetSOFrmShpCode').val(),
                    'tReturnInputCode'  : 'oetSOFrmPosCode',
                    'tReturnInputName'  : 'oetSOFrmPosName',
                    'tNextFuncName'     : 'JSxSOSetConditionPos',
                    'aArgReturn'        : ['FTBchCode','FTShpCode','FTPosCode','FTWahCode','FTWahName']
                });
                JCNxBrowseData('oSOBrowsePosOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Browse Warehouse
        $('#obtSOBrowseWahouse').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oSOBrowseWahOption   = undefined;
                oSOBrowseWahOption          = oWahOption({
                    'tSOShpCode'        : $('#oetSOFrmShpCode').val(),
                    'tSOPosCode'        : $('#oetSOFrmWahCode').val(),
                    'tReturnInputCode'  : 'oetSOFrmWahCode',
                    'tReturnInputName'  : 'oetSOFrmWahName',
                    'tNextFuncName'     : 'JSxSOSetConditionWahouse',
                    'aArgReturn'        : []
                });
                JCNxBrowseData('oSOBrowseWahOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Browse Supplier
        $('#obtSOBrowseSupplier').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oSOBrowseSplOption   = undefined;
                oSOBrowseSplOption          = oSplOption({
                    'tReturnInputCode'  : 'oetSOFrmSplCode',
                    'tReturnInputName'  : 'oetSOFrmSplName',
                    'tNextFuncName'     : 'JSxSOSetConditionAfterSelectSpl',
                    'aArgReturn'        : ['FNSplCrTerm', 'FCSplCrLimit', 'FTSplStaVATInOrEx', 'FTSplTspPaid', 'FTSplCode', 'FTSplName']
                });
                JCNxBrowseData('oSOBrowseSplOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });


            // Event Browse Customer
            $('#obtSOBrowseCustomer').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oSOBrowseSplOption   = undefined;
                oSOBrowseCstOption          = oCstOption({
                    'tReturnInputCode'  : 'oetSOFrmCstCode',
                    'tReturnInputName'  : 'oetSOFrmCstName',
                    'tNextFuncName'     : 'JSxSOSetConditionAfterSelectCst',
                    'aArgReturn'        : ['FTCstCode', 'FTCstName','FTCstCardID','FTCstTel']
                });
                JCNxBrowseData('oSOBrowseCstOption');
            }else{
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
        function JSxSOSetConditionMerchant(poDataNextFunc){
            var aDataNextFunc,tSOMerCode,tSOMerName;
            if(typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL"){
                aDataNextFunc   = JSON.parse(poDataNextFunc);
                tSOMerCode      = aDataNextFunc[0];
                tSOMerName      = aDataNextFunc[1];
            }
            
            let tSOBchCode  = $('#oetSOFrmBchCode').val();
            let tSOMchCode  = $('#oetSOFrmMerCode').val();
            let tSOMchName  = $('#oetSOFrmMerName').val();
            let tSOShopCode = $('#oetSOFrmShpCode').val();
            let tSOShopName = $('#oetSOFrmShpName').val();
            let tSOPosCode  = $('#oetSOFrmPosCode').val();
            let tSOPosName  = $('#oetSOFrmPosName').val();
            let tSOWahCode  = $('#oetSOFrmWahCode').val();
            let tSOWahName  = $('#oetSOFrmWahName').val();

            let nCountDataInTable = $('#otbSODocPdtAdvTableList tbody .xWPdtItem').length;
            
            if(nCountDataInTable > 0 && tSOMchCode != "" && tSOShopCode != "" && tSOWahCode != ""){
                // รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนกลุ่มธุรกิจ
                var tTextMssage    = '<?php echo language('document/purchaseinvoice/purchaseinvoice','tSOMsgNotiChangeMerchantClearDocTemp');?>';
                FSvCMNSetMsgWarningDialog("<p>"+tTextMssage+"</p>");
                
                // Event CLick Close Massage And Delete Temp
                $('#odvModalWanning .xWBtnOK').click(function(evn){
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "dcmSOClearDataDocTemp_STD",
                        data: {
                            'ptSODocNo' : $("#oetSODocNo").val()
                        },
                        cache: false,
                        success: function (oResult){
                            var aDataReturn     = JSON.parse(oResult);
                            var tMessageError   = aDataReturn['tStaMessg'];
                            switch(aDataReturn['nStaReturn']){
                                case 1:
                                    JSvSOLoadPdtDataTableHtmlMonitor();
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
                        error: function (jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                });
            }

            $('#obtSOBrowseShop').attr('disabled', true);
            $('#obtSOBrowsePos').attr('disabled', true);
            $('#obtSOBrowseWahouse').attr('disabled', true);
            
            if(tSesUsrLevel == 'HQ' || tSesUsrLevel == 'BCH'){
                if((tSOMchCode == "" && tSOMchName == "") && (tSOShopCode == "" && tSOShopName == "") && (tSOPosCode == "" && tSOPosName == "" )) {
                    $('#obtSOBrowseWahouse').attr('disabled', false).removeClass('disabled');

                }else{
                    $('#obtSOBrowseShop').attr('disabled',false).removeClass('disabled');
                    $('#obtSOBrowseWahouse').attr('disabled', true).addClass('disabled');
                }

                $('#oetSOFrmShpCode,#oetSOFrmShpName').val('');
                $('#oetSOFrmPosCode,#oetSOFrmPosName').val('');
                $('#oetSOFrmWahCode,#oetSOFrmWahName').val('');
            }
        }

        // Functionality : Function Behind NextFunc ร้านค้า
        // Parameter : Event Next Func Modal
        // Create : 26/06/2019 Wasin(Yoshi)
        // Return : Set value And Control Input
        // Return Type : -
        function JSxSOSetConditionShop(poDataNextFunc){
            var aDataNextFunc,tSOBchCode,tSOShpType,tSOShpCode,tSOShpName,tSOWahCode,tSOWahName;
            if(typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL"){
                aDataNextFunc   = JSON.parse(poDataNextFunc);
                tSOBchCode      = aDataNextFunc[0];
                tSOShpType      = aDataNextFunc[1];
                tSOShpCode      = aDataNextFunc[2];
                tSOShpName      = aDataNextFunc[3];
                tSOWahCode      = aDataNextFunc[4];
                tSOWahName      = aDataNextFunc[5];
            }else{
                $('#oetSOFrmWahCode,#oetSOFrmWahName').val('');
            }

            let tSODataBchCode  = $('#oetSOFrmBchCode').val();
            let tSODataMchCode  = $('#oetSOFrmMerCode').val();
            let tSODataMchName  = $('#oetSOFrmMerName').val();
            let tSODataShopCode = $('#oetSOFrmShpCode').val();
            let tSODataShopName = $('#oetSOFrmShpName').val();
            let tSODataPosCode  = $('#oetSOFrmPosCode').val();
            let tSODataPosName  = $('#oetSOFrmPosName').val();
            let tSODataWahCode  = $('#oetSOFrmWahCode').val();
            let tSODataWahName  = $('#oetSOFrmWahName').val();

            let nCountDataInTable = $('#otbSODocPdtAdvTableList tbody .xWPdtItem').length;
            if(nCountDataInTable > 0 && tSODataMchCode != "" && tSODataShopCode != "" && tSODataWahCode != ""){
                // Show Modal Notification Found Data In Table Doctemp Behide Change Shop 
                FSvCMNSetMsgWarningDialog("<p>รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนร้านค้าใหม่</p>");
                
                // Event CLick Close Massage And Delete Temp
                $('#odvModalWanning .xWBtnOK').click(function(evn){
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "dcmSOClearDataDocTemp_STD",
                        data: {
                            'ptSODocNo' : $("#oetSODocNo").val()
                        },
                        cache: false,
                        success: function (oResult){
                            var aDataReturn     = JSON.parse(oResult);
                            var tMessageError   = aDataReturn['tStaMessg'];
                            switch(aDataReturn['nStaReturn']){
                                case 1:
                                    JSvSOLoadPdtDataTableHtmlMonitor();
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
                        error: function (jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                });
            }

            if(tSesUsrLevel == 'HQ' || tSesUsrLevel == 'BCH'){
                if(typeof(tSOShpName) != undefined && tSOShpName != ''){
                    if(tSOShpType == 4){
                        $('#obtSOBrowsePos').attr('disabled',false).removeClass('disabled');
                        $('#obtSOBrowseWahouse').attr('disabled',true).addClass('disabled');
                        $('#oetSOFrmWahCode').val(tSOWahCode);
                        $('#oetSOFrmWahName').val(tSOWahName);
                    }else{
                        $('#oetSOFrmWahCode').val(tSOWahCode);
                        $('#oetSOFrmWahName').val(tSOWahName);
                        $('#obtSOBrowsePos').attr('disabled',true).addClass('disabled');
                        $('#obtSOBrowseWahouse').attr('disabled',true).addClass('disabled');
                    }
                }else{
                    $('#oetSOFrmWahCode,#oetSOFrmWahName').val('');
                }
                $('#oetSOFrmPosCode,#oetSOFrmPosName').val('');
            }

        }

        // Functionality : Function Behind NextFunc เครื่องจุดขาย
        // Parameter : Event Next Func Modal
        // Create : 26/06/2019 Wasin(Yoshi)
        // Return : Set value And Control Input
        // Return Type : -
        function JSxSOSetConditionPos(poDataNextFunc){
            var aDataNextFunc,tSOBchCode,tSOShpCode,tSOPosCode,tSOWahCode,tSOWahName;
            if(typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL"){
                aDataNextFunc   = JSON.parse(poDataNextFunc);
                tSOBchCode      = aDataNextFunc[0];
                tSOShpCode      = aDataNextFunc[1];
                tSOPosCode      = aDataNextFunc[2];
                tSOWahCode      = aDataNextFunc[3];
                tSOWahName      = aDataNextFunc[4];
                $('#oetSOFrmWahCode').val(tSOWahCode);
                $('#oetSOFrmWahName').val(tSOWahName);
                $('#obtSOBrowsePos').attr('disabled',false).removeClass('disabled');
                $('#obtSOBrowseWahouse').attr('disabled',true).addClass('disabled');
            }else{
                $('#oetSOFrmPosCode,#oetSOFrmPosCode').val('');
                $('#oetSOFrmWahCode').val('');
                $('#oetSOFrmWahName').val('');
                return;
            }
            $('#obtSOBrowseWahouse').attr('disabled',false).removeClass('disabled');
       
        }

        // Functionality : Function Behind NextFunc Supllier
        // Parameter : Event Next Func Modal
        // Create : 01/07/2019 Wasin(Yoshi)
        // Return : -
        // Return Type : -
        function JSxSOSetConditionAfterSelectSpl(poDataNextFunc){
            var aData;
            if (poDataNextFunc  != "NULL") {
                aData = JSON.parse(poDataNextFunc);
                var poParams = {
                    FNSplCrTerm         : aData[0],
                    FCSplCrLimit        : aData[1],
                    FTSplStaVATInOrEx   : aData[2],
                    FTSplTspPaid        : aData[3],
                    FTSplCode           : aData[4],
                    FTSplName           : aData[5]
                };
                JSxSOSetPanelSupplierData(poParams);
            }
        }


        function JSxSOSetConditionAfterSelectCst(poDataNextFunc){
            var aData;
            if (poDataNextFunc  != "NULL") {
                aData = JSON.parse(poDataNextFunc);
                var poParams = {
                    FTCstCode         : aData[0],
                    FTCstName        : aData[1],
                    FTCstCtzID   : aData[2],
                    FTCstTel        : aData[3]
                };
                JSxSOSetPanelCustomerData(poParams);
            }
        }


        function JSxSOSetPanelCustomerData(poParams){
   
            $("#oetSOFrmCstHNNumber").val(poParams.FTCstCode);
            $("#oetSOFrmCstCtzID").val(poParams.FTCstCtzID);
            $("#oetSOFrmCustomerName").val(poParams.FTCstName);
            $("#oetSOFrmCstTel").val(poParams.FTCstTel);
            
        }

        // Functionality : ฟังก์ชั่นเซทข้อมูล ผู้จำหน่าย
        // Parameter : Event Next Func Modal
        // Create : 01/07/2019 Wasin(Yoshi)
        // Return : -
        // Return Type : -
        function JSxSOSetPanelSupplierData(poParams){
            // Reset Panel เป็นค่าเริ่มต้น
            $("#ocmSOFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            $("#ocmSOFrmSplInfoPaymentType.selectpicker").val("2").selectpicker("refresh");
            $("#ocmSOFrmSplInfoDstPaid.selectpicker").val("1").selectpicker("refresh");
            $("#oetSOFrmSplInfoCrTerm").val("");

            // ประเภทภาษี
            if(poParams.FTSplStaVATInOrEx === "1"){
                // รวมใน
                $("#ocmSOFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            }else{
                // แยกนอก
                $("#ocmSOFrmSplInfoVatInOrEx.selectpicker").val("2").selectpicker("refresh");
            }

            // ประเภทชำระเงิน
            if(poParams.FCSplCrLimit > 0){
                // เงินเชื่อ
                $("#ocmSOFrmSplInfoPaymentType.selectpicker").val("2").selectpicker("refresh");
            }else{
                // เงินสด
                $("#ocmSOFrmSplInfoPaymentType.selectpicker").val("1").selectpicker("refresh");
            }

            // การชำระเงิน
            if(poParams.FTSplTspPaid === "1"){ // ต้นทาง
                $("#ocmSOFrmSplInfoDstPaid.selectpicker").val("1").selectpicker("refresh");
            }else{ // ปลายทาง
                $("#ocmSOFrmSplInfoDstPaid.selectpicker").val("2").selectpicker("refresh");
            }
            
            // ระยะเครดิต
            $("#oetSOFrmSplInfoCrTerm").val(poParams.FCSplCrLimit);
        }

    // ===========================================================================================================

    /** ================================== Manage Product Advance Table Colums  ================================== */
        // Event Call Modal Show Option Advance Product Doc DT Tabel
        $('#obtSOAdvTablePdtDTTemp').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxSOOpenColumnFormSet();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });


        $('#odvSOOrderAdvTblColumns #obtSOSaveAdvTableColums').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxSOSaveColumnShow();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Functionality : Call Advnced Table 
        // Parameters : Event Next Func Modal
        // Creator : 01/07/2019 Wasin(Yoshi)
        // Return : Open Modal Manage Colums Show
        // Return Type : -
        function JSxSOOpenColumnFormSet(){
            $.ajax({
                type: "POST",
                url: "dcmSOAdvanceTableShowColList_STD",
                cache: false,
                Timeout: 0,
                success: function (oResult) {
                    var aDataReturn = JSON.parse(oResult);
                    if(aDataReturn['nStaEvent'] == '1'){
                        var tViewTableShowCollist   = aDataReturn['tViewTableShowCollist'];
                        $('#odvSOOrderAdvTblColumns .modal-body').html(tViewTableShowCollist);
                        $('#odvSOOrderAdvTblColumns').modal({backdrop: 'static', keyboard: false})  
                        $("#odvSOOrderAdvTblColumns").modal({ show: true });
                    }else{
                        var tMessageError = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                        JCNxCloseLoading();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }

        //Functionality : Save Columns Show Advanced Table
        //Parameters : Event Next Func Modal
        //Creator : 02/07/2019 Wasin(Yoshi)
        //Return : Open Modal Manage Colums Show
        //Return Type : -
        function JSxSOSaveColumnShow(){
            // คอลัมน์ที่เลือกให้แสดง
            var aSOColShowSet = [];
            $("#odvSOOrderAdvTblColumns .xWPIInputColStaShow:checked").each(function(){
                aSOColShowSet.push($(this).data("id"));
            });

            // คอลัมน์ทั้งหมด
            var aSOColShowAllList = [];
            $("#odvSOOrderAdvTblColumns .xWPIInputColStaShow").each(function () {
                aSOColShowAllList.push($(this).data("id"));
            });

            // ชื่อคอลัมน์ทั้งหมดในกรณีมีการแก้ไขชื่อคอลัมน์ที่แสดง
            var aSOColumnLabelName = [];
            $("#odvSOOrderAdvTblColumns .xWPILabelColumnName").each(function () {
                aSOColumnLabelName.push($(this).text());
            });

            // สถานะย้อนกลับค่าเริ่มต้น
            var nSOStaSetDef;
            if($("#odvSOOrderAdvTblColumns #ocbSOSetDefAdvTable").is(":checked")) {
                nSOStaSetDef   = 1;
            } else {
                nSOStaSetDef   = 0;
            }

            $.ajax({
                type: "POST",
                url: "dcmSOAdvanceTableShowColSave_STD",
                data: {
                    'pnSOStaSetDef'         : nSOStaSetDef,
                    'paSOColShowSet'        : aSOColShowSet,
                    'paSOColShowAllList'    : aSOColShowAllList,
                    'paSOColumnLabelName'   : aSOColumnLabelName
                },
                cache: false,
                Timeout: 0,
                success: function (oResult){
                    $("#odvSOOrderAdvTblColumns").modal("hide");
                    $(".modal-backdrop").remove();
                    JSvSOLoadPdtDataTableHtmlMonitor();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    // ===========================================================================================================

    /** ========================================= Set Shipping Address =========================================== */
        $('#obtSOFrmBrowseShipAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('#odvSOBrowseShipAdd').modal({backdrop: 'static', keyboard: false})  
                $('#odvSOBrowseShipAdd').modal('show');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Option Browse Shipping Address
        var oSOBrowseShipAddress    = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tSOWhereCons        = poDataFnc.tSOWhereCons;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var oOptionReturn       = {
                Title : ['document/purchaseinvoice/purchaseinvoice','tSOShipAddress'],
                Table : {Master:'TCNMAddress_L',PK:'FNAddSeqNo'},
                Join : {
                Table : ['TCNMProvince_L','TCNMDistrict_L','TCNMSubDistrict_L'],
                    On : [
                        "TCNMAddress_L.FTAddV1PvnCode = TCNMProvince_L.FTPvnCode AND TCNMProvince_L.FNLngID = "+nLangEdits,
                        "TCNMAddress_L.FTAddV1DstCode = TCNMDistrict_L.FTDstCode AND TCNMDistrict_L.FNLngID = "+nLangEdits,
                        "TCNMAddress_L.FTAddV1SubDist = TCNMSubDistrict_L.FTSudCode AND TCNMSubDistrict_L.FNLngID = "+nLangEdits
                    ]
                },
                Where : {
                    Condition : [tSOWhereCons]
                },
                GrideView:{
                    ColumnPathLang	: 'document/purchaseinvoice/purchaseinvoice',
                    ColumnKeyLang	: [
                        'tSOShipADDBch',
                        'tSOShipADDSeq',
                        'tSOShipADDV1No',
                        'tSOShipADDV1Soi',
                        'tSOShipADDV1Village',
                        'tSOShipADDV1Road',
                        'tSOShipADDV1SubDist',
                        'tSOShipADDV1DstCode',
                        'tSOShipADDV1PvnCode',
                        'tSOShipADDV1PostCode'
                    ],
                    DataColumns		: [
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
                    DataColumnsFormat : ['','','','','','','','','','','','','','',''],
                    ColumnsSize     : [''],
                    DisabledColumns	:[10,11,12,13,14],
                    Perpage			: 10,
                    WidthModal      : 50,
                    OrderBy			: ['TCNMAddress_L.FTAddRefCode ASC'],
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnCode,"TCNMAddress_L.FNAddSeqNo"],
                    Text		: [tInputReturnName,"TCNMAddress_L.FNAddSeqNo"],
                },
                NextFunc:{
                    FuncName    : tNextFuncName,
                    ArgReturn   : aArgReturn
                },
                BrowseLev : 1
            };
            return oOptionReturn;
        };

        // Event Browse Shipping Address
        $('#odvSOBrowseShipAdd #oliSOEditShipAddress').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tSOWhereCons    = "";
                if($("#oetSOFrmBchCode").val() != ""){
                    if($("#oetSOFrmMerCode").val() != ""){
                        if($("#oetSOFrmShpCode").val() != ""){
                            if($("#oetSOFrmPosCode").val() != ""){
                                // Address Ref POS
                                tSOWhereCons    +=  "AND FTAddGrpType = 6 AND FTAddRefCode = '"+$("#oetSOFrmPosCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                            }else{
                                // Address Ref SHOP
                                tSOWhereCons    +=  "AND FTAddGrpType = 4 AND FTAddRefCode = '"+$("#oetSOFrmShpCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                            }
                        }else{
                            // Address Ref BCH
                            tSOWhereCons        +=  "AND FTAddGrpType = 1 AND FTAddRefCode = '"+$("#oetSOFrmBchCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                        }
                    }else{
                        // Address Ref BCH
                        tSOWhereCons            +=  "AND FTAddGrpType = 1 AND FTAddRefCode = '"+$("#oetSOFrmBchCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                    }
                }
                // Call Option Modal
                window.oSOBrowseShipAddressOption   = undefined;
                oSOBrowseShipAddressOption          = oSOBrowseShipAddress({
                    'tReturnInputCode'  : 'ohdSOShipAddSeqNo',
                    'tReturnInputName'  : 'ohdSOShipAddSeqNo',
                    'tSOWhereCons'     : tSOWhereCons,
                    'tNextFuncName'     : 'JSvSOGetShipAddrData',
                    'aArgReturn'        : [
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
                        'FTAddV2Desc2']
                });
                $("#odvSOBrowseShipAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxBrowseData('oSOBrowseShipAddressOption');
            }else{
                $("#odvSOBrowseShipAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxShowMsgSessionExpired();
            }
        });

        //Functionality : Behind NextFunc Browse Shippinh Address
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSvSOGetShipAddrData(paInForCon){
            if(paInForCon !== "NULL") {
                var aDataReturn = JSON.parse(paInForCon);
                $("#ospSOShipAddAddV1No").text((aDataReturn[1] != "")      ? aDataReturn[1]    : '-');
                $("#ospSOShipAddV1Soi").text((aDataReturn[2] != "")        ? aDataReturn[2]    : '-');
                $("#ospSOShipAddV1Village").text((aDataReturn[3] != "")    ? aDataReturn[3]    : '-');
                $("#ospSOShipAddV1Road").text((aDataReturn[4] != "")       ? aDataReturn[4]    : '-');
                $("#ospSOShipAddV1SubDist").text((aDataReturn[5] != "")    ? aDataReturn[5]    : '-');
                $("#ospSOShipAddV1DstCode").text((aDataReturn[6] != "")    ? aDataReturn[6]    : '-');
                $("#ospSOShipAddV1PvnCode").text((aDataReturn[7] != "")    ? aDataReturn[7]    : '-');
                $("#ospSOShipAddV1PostCode").text((aDataReturn[8] != "")   ? aDataReturn[8]    : '-');
                $("#ospSOShipAddV2Desc1").text((aDataReturn[9] != "")      ? aDataReturn[9]    : '-');
                $("#ospSOShipAddV2Desc2").text((aDataReturn[10] != "")     ? aDataReturn[10]   : '-');
            }else{
                $("#ospSOShipAddAddV1No").text("-");
                $("#ospSOShipAddV1Soi").text("-");
                $("#ospSOShipAddV1Village").text("-");
                $("#ospSOShipAddV1Road").text("-");
                $("#ospSOShipAddV1SubDist").text("-");
                $("#ospSOShipAddV1DstCode").text("-");
                $("#ospSOShipAddV1PvnCode").text("-");
                $("#ospSOShipAddV1PostCode").text("-");
                $("#ospSOShipAddV2Desc1").text("-");
                $("#ospSOShipAddV2Desc2").text("-");
            }
            $("#odvSOBrowseShipAdd").modal("show");
        }

        //Functionality : Add Shiping Add To Input
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSnSOShipAddData(){
            var tSOShipAddSeqNoSelect   = $('#ohdSOShipAddSeqNo').val();
            $('#ohdSOFrmShipAdd').val(tSOShipAddSeqNoSelect);
            $("#odvSOBrowseShipAdd").modal("hide");
            $('.modal-backdrop').remove();
        }

    // ===========================================================================================================

    /** ============================================ Set Tex Address ============================================= */
        $('#obtSOFrmBrowseTaxAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('#odvSOBrowseTexAdd').modal({backdrop: 'static', keyboard: false})  
                $('#odvSOBrowseTexAdd').modal('show');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Option Browse Shipping Address
        var oSOBrowseTexAddress     = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tSOWhereCons        = poDataFnc.tSOWhereCons;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var oOptionReturn       = {
                Title   : ['document/purchaseinvoice/purchaseinvoice','tSOTexAddress'],
                Table   : {Master:'TCNMAddress_L',PK:'FNAddSeqNo'},
                Join    : {
                    Table   : ['TCNMProvince_L','TCNMDistrict_L','TCNMSubDistrict_L'],
                    On      : [
                        "TCNMAddress_L.FTAddV1PvnCode = TCNMProvince_L.FTPvnCode AND TCNMProvince_L.FNLngID = "+nLangEdits,
                        "TCNMAddress_L.FTAddV1DstCode = TCNMDistrict_L.FTDstCode AND TCNMDistrict_L.FNLngID = "+nLangEdits,
                        "TCNMAddress_L.FTAddV1SubDist = TCNMSubDistrict_L.FTSudCode AND TCNMSubDistrict_L.FNLngID = "+nLangEdits
                    ]
                },
                Where : {
                    Condition : [tSOWhereCons]
                },
                GrideView:{
                    ColumnPathLang	: 'document/purchaseinvoice/purchaseinvoice',
                    ColumnKeyLang	: [
                        'tSOTexADDBch',
                        'tSOTexADDSeq',
                        'tSOTexADDV1No',
                        'tSOTexADDV1Soi',
                        'tSOTexADDV1Village',
                        'tSOTexADDV1Road',
                        'tSOTexADDV1SubDist',
                        'tSOTexADDV1DstCode',
                        'tSOTexADDV1PvnCode',
                        'tSOTexADDV1PostCode'
                    ],
                    DataColumns		: [
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
                    DataColumnsFormat : ['','','','','','','','','','','','','','',''],
                    ColumnsSize     : [''],
                    DisabledColumns	:[10,11,12,13,14],
                    Perpage			: 10,
                    WidthModal      : 50,
                    OrderBy			: ['TCNMAddress_L.FTAddRefCode ASC'],
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnCode,"TCNMAddress_L.FNAddSeqNo"],
                    Text		: [tInputReturnName,"TCNMAddress_L.FNAddSeqNo"],
                },
                NextFunc:{
                    FuncName    : tNextFuncName,
                    ArgReturn   : aArgReturn
                },
                BrowseLev : 1
            };
            return oOptionReturn;
        };

        // Event Browse Shipping Address
        $('#odvSOBrowseTexAdd #oliSOEditTexAddress').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tSOWhereCons    = "AND FTAddGrpType = 1 AND FTAddRefCode = '"+$("#oetSOFrmBchCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                // Call Option Modal
                window.oSOBrowseTexAddressOption    = undefined;
                oSOBrowseTexAddressOption           = oSOBrowseTexAddress({
                    'tReturnInputCode'  : 'ohdSOTexAddSeqNo',
                    'tReturnInputName'  : 'ohdSOTexAddSeqNo',
                    'tSOWhereCons'     : tSOWhereCons,
                    'tNextFuncName'     : 'JSvSOGetTexAddrData',
                    'aArgReturn'        : [
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
                        'FTAddV2Desc2']
                });
                $("#odvSOBrowseTexAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxBrowseData('oSOBrowseTexAddressOption');
            }else{
                $("#odvSOBrowseTexAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxShowMsgSessionExpired();
            }
        });
        
        //Functionality : Behind NextFunc Browse Shippinh Address
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSvSOGetTexAddrData(paInForCon){
            if(paInForCon !== "NULL") {
                var aDataReturn = JSON.parse(paInForCon);
                $("#ospSOTexAddAddV1No").text((aDataReturn[1] != "")      ? aDataReturn[1]    : '-');
                $("#ospSOTexAddV1Soi").text((aDataReturn[2] != "")        ? aDataReturn[2]    : '-');
                $("#ospSOTexAddV1Village").text((aDataReturn[3] != "")    ? aDataReturn[3]    : '-');
                $("#ospSOTexAddV1Road").text((aDataReturn[4] != "")       ? aDataReturn[4]    : '-');
                $("#ospSOTexAddV1SubDist").text((aDataReturn[5] != "")    ? aDataReturn[5]    : '-');
                $("#ospSOTexAddV1DstCode").text((aDataReturn[6] != "")    ? aDataReturn[6]    : '-');
                $("#ospSOTexAddV1PvnCode").text((aDataReturn[7] != "")    ? aDataReturn[7]    : '-');
                $("#ospSOTexAddV1PostCode").text((aDataReturn[8] != "")   ? aDataReturn[8]    : '-');
                $("#ospSOTexAddV2Desc1").text((aDataReturn[9] != "")      ? aDataReturn[9]    : '-');
                $("#ospSOTexAddV2Desc2").text((aDataReturn[10] != "")     ? aDataReturn[10]   : '-');
            }else{
                $("#ospSOTexAddAddV1No").text("-");
                $("#ospSOTexAddV1Soi").text("-");
                $("#ospSOTexAddV1Village").text("-");
                $("#ospSOTexAddV1Road").text("-");
                $("#ospSOTexAddV1SubDist").text("-");
                $("#ospSOTexAddV1DstCode").text("-");
                $("#ospSOTexAddV1PvnCode").text("-");
                $("#ospSOTexAddV1PostCode").text("-");
                $("#ospSOTexAddV2Desc1").text("-");
                $("#ospSOTexAddV2Desc2").text("-");
            }
            $("#odvSOBrowseTexAdd").modal("show");
        }

        //Functionality : Add Shiping Add To Input
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSnSOTexAddData(){
            var tSOTexAddSeqNoSelect    = $('#ohdSOTexAddSeqNo').val();
            $('#ohdSOFrmTaxAdd').val(tSOTexAddSeqNoSelect);
            $("#odvSOBrowseTexAdd").modal("hide");
            $('.modal-backdrop').remove();
        }
    // ===========================================================================================================
    

    // Functionality: Check Status Document Process EQ And Call Back MQ
    // Parameters: Event Document Ready Load Page
    // Creator: 11/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: -
    // ReturnType: -
    function JSxSOChkStaDocCallModalMQ(){
        var nSOLangEdits        = nLangEdits;
        var tSOFrmBchCode       = $("#oetSOFrmBchCode").val();
        var tSOUsrApv           = $("#ohdSOApvCodeUsrLogin").val();
        var tSODocNo            = $("#oetSODocNo").val();
        var tSOPrefix           = "RESPPI";
        var tSOStaApv           = $("#ohdSOStaApv").val();
        var tSOStaPrcStk        = $("#ohdSOStaPrcStk").val();
        var tSOStaDelMQ         = $("#ohdSOStaDelMQ").val();
        var tSOQName            = tSOPrefix + "_" + tSODocNo + "_" + tSOUsrApv;
        var tSOTableName        = "TARTSoHD";
        var tSOFieldDocNo       = "FTXphDocNo";
        var tSOFieldStaApv      = "FTXphStaPrcStk";
        var tSOFieldStaDelMQ    = "FTXphStaDelMQ";

        // MQ Message Config
        var poDocConfig = {
            tLangCode     : nSOLangEdits,
            tUsrBchCode   : tSOFrmBchCode,
            tUsrApv       : tSOUsrApv,
            tDocNo        : tSODocNo,
            tPrefix       : tSOPrefix,
            tStaDelMQ     : tSOStaDelMQ,
            tStaApv       : tSOStaApv,
            tQName        : tSOQName
        };

       // RabbitMQ STOMP Config
        var poMqConfig = {
            host: "ws://" + oSTOMMQConfig.host + ":15674/ws",
            username: oSTOMMQConfig.user,
            password: oSTOMMQConfig.password,
            vHost: oSTOMMQConfig.vhost
        };
        
        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams   = {
            ptDocTableName      : tSOTableName,
            ptDocFieldDocNo     : tSOFieldDocNo,
            ptDocFieldStaApv    : tSOFieldStaApv,
            ptDocFieldStaDelMQ  : tSOFieldStaDelMQ,
            ptDocStaDelMQ       : tSOStaDelMQ,
            ptDocNo             : tSODocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: "JSvSOCallPageEditDoc",
            tCallPageList: "JSvSOCallPageList"
        };
        
        // Check Show Progress %
        if(tSODocNo != '' && (tSOStaApv == 2 || tSOStaPrcStk == 2)){
            FSxCMNRabbitMQMessage(poDocConfig,poMqConfig,poUpdateStaDelQnameParams,poCallback);
        }

        // Check Delete MQ SubScrib
        if(tSOStaApv == 1 && tSOStaPrcStk == 1 && tSOStaDelMQ == ""){
            var poDelQnameParams    = {
                ptPrefixQueueName   : tSOPrefix,
                ptBchCode           : tSOFrmBchCode,
                ptDocNo             : tSODocNo,
                ptUsrCode           : tSOUsrApv
            };
            FSxCMNRabbitMQDeleteQname(poDelQnameParams);
            FSxCMNRabbitMQUpdateStaDeleteQname(poUpdateStaDelQnameParams);
        }
    }
 
    $('#ocbSOApAll').click(function(){

        if($(this).is(':checked')==true){
             $('.ocbListItem').prop('checked',true);
        }else{
            $('.ocbListItem').prop('checked',false);
        }
    });

    //เลือกสินค้าตามคลัง
    $('#ocmSearchPDTByWah').change(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var tWahCode        = $(this).val();
            var tSODocNo        = $("#oetSODocNo").val();
            var tSOStaApv       = $("#ohdSOStaApv").val();
            var tSOStaDoc       = $("#ohdSOStaDoc").val();
            var nSOLastSeq      = $('#ohdSOLastSeq').val();
        
            $.ajax({
                type    : "POST",
                url     : "dcmSOPdtLoadTablePDT_STD",
                data: {
                    'ptSODocNo'             : tSODocNo,
                    'ptSOStaApv'            : tSOStaApv,
                    'ptSOStaDoc'            : tSOStaDoc,
                    'pnSOPageCurrent'       : 1,
                    'nSOLastSeq'            : nSOLastSeq,
                    'tWahCode'              : tWahCode
                },
                cache: false,
                Timeout: 0,
                success: function (oResult){
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == '1') {
                        $('#odvSODataPdtTableDTTempMonitor').html(aReturnData['tHTML']);
                        JCNxCloseLoading();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    
</script>