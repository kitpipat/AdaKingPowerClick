<script type="text/javascript">

    var nLangEdits      = '<?php echo $this->session->userdata("tLangEdit");?>';
    var tUsrApvName     = '<?php echo $this->session->userdata("tSesUsername");?>';
    var tSesUsrLevel    = '<?php echo $this->session->userdata('tSesUsrLevel');?>';
    var tUserBchCode    = '<?php echo $this->session->userdata("tSesUsrBchCodeDefault");?>';
    var tUserBchName    = '<?php echo $this->session->userdata("tSesUsrBchNameDefault");?>';
    var tUserWahCode    = '<?php echo $this->session->userdata("tSesUsrWahCode");?>';
    var tUserWahName    = '<?php echo $this->session->userdata("tSesUsrWahName");?>';
    var tRoute          =  $('#ohdPIRoute').val();
    var tStaApv         =  $('#ohdPIStaApv').val();

    $(document).ready(function(){
        $('.selectpicker').selectpicker('refresh');

        if( tStaApv == '1' ){
            $(".xWPIDisabledOnApv").attr("disabled",true);
        }

        if(tUserWahCode != '' && tRoute == 'dcmPIEventAdd'){
            $('#oetPIFrmWahCode').val(tUserWahCode);
            $('#oetPIFrmWahName').val(tUserWahName);
        }

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });

        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm:ss',
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


        $('#obtPIDocBrowsePdt').unbind().click(function(){
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                if($('#oetPIFrmSplCode').val()!=""){
                    JSxCheckPinMenuClose();
                    JCNvPIBrowsePdt();
                }else{
                    $('#odvPIModalPleseselectCustomer').modal('show');
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        if($('#oetPIFrmBchCode').val() == ""){
            $("#obtPIFrmBrowseTaxAdd").attr("disabled","disabled");
        }

        /** =================== Event Search Function ===================== */
            $('#oliPIMngPdtScan').unbind().click(function(){
                var tPISplCode  = $('#oetPIFrmSplCode').val();
                if(typeof(tPISplCode) !== undefined && tPISplCode !== ''){
                    //Hide
                    $('#oetPIFrmFilterPdtHTML').hide();
                    $('#obtPIMngPdtIconSearch').hide();

                    //Show
                    $('#oetPIFrmSearchAndAddPdtHTML').show();
                    $('#obtPIMngPdtIconScan').show();
                }else{
                    var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
            });
            $('#oliPIMngPdtSearch').unbind().click(function(){
                //Hide
                $('#oetPIFrmSearchAndAddPdtHTML').hide();
                $('#obtPIMngPdtIconScan').hide();
                //Show
                $('#oetPIFrmFilterPdtHTML').show();
                $('#obtPIMngPdtIconSearch').show();
            });
        /** =============================================================== */

        /** ===================== Set Date Autometic Doc ========================  */
            var dCurrentDate    = new Date();
            var tAmOrPm         = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
            var tCurrentTime    = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

            if($('#oetPIDocDate').val() == ''){
                $('#oetPIDocDate').datepicker("setDate",dCurrentDate);
            }

            if($('#oetPIDocTime').val() == ''){
                $('#oetPIDocTime').val(tCurrentTime);
            }
        /** =============================================================== */

        /** =================== Event Date Function  ====================== */
            $('#obtPIDocDate').unbind().click(function(){
                $('#oetPIDocDate').datepicker('show');
            });

            $('#obtPIDocTime').unbind().click(function(){
                $('#oetPIDocTime').datetimepicker('show');
            });

            $('#obtPIBrowseRefIntDocDate').unbind().click(function(){
                $('#oetPIRefIntDocDate').datepicker('show');
            });

            $('#obtPIBrowseRefExtDocDate').unbind().click(function(){
                $('#oetPIRefExtDocDate').datepicker('show');
            });

            $('#obtPIFrmSplInfoDueDate').unbind().click(function(){
                $('#oetPIFrmSplInfoDueDate').datepicker('show');
            });

            $('#obtPIFrmSplInfoBillDue').unbind().click(function(){
                $('#oetPIFrmSplInfoBillDue').datepicker('show');
            });

            $('#obtPIFrmSplInfoTnfDate').unbind().click(function(){
                $('#oetPIFrmSplInfoTnfDate').datepicker('show');
            });
        /** =============================================================== */

        /** ================== Check Box Auto GenCode ===================== */
            $('#ocbPIStaAutoGenCode').on('change', function (e) {
                if($('#ocbPIStaAutoGenCode').is(':checked')){
                    $("#oetPIDocNo").val('');
                    $("#oetPIDocNo").attr("readonly", true);
                    $('#oetPIDocNo').closest(".form-group").css("cursor","not-allowed");
                    $('#oetPIDocNo').css("pointer-events","none");
                    $("#oetPIDocNo").attr("onfocus", "this.blur()");
                    $('#ofmPIFormAdd').removeClass('has-error');
                    $('#ofmPIFormAdd .form-group').closest('.form-group').removeClass("has-error");
                    $('#ofmPIFormAdd em').remove();
                }else{
                    $('#oetPIDocNo').closest(".form-group").css("cursor","");
                    $('#oetPIDocNo').css("pointer-events","");
                    $('#oetPIDocNo').attr('readonly',false);
                    $("#oetPIDocNo").removeAttr("onfocus");
                }
            });
        /** =============================================================== */

        // $('#ocmPIFrmSplInfoVatInOrEx').on('change', function (e) {
        //     var nStaSession = JCNxFuncChkSessionExpired();
        //     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        //         JCNxOpenLoading();
        //         JSvPILoadPdtDataTableHtml();
        //     }else{
        //         JCNxShowMsgSessionExpired();
        //     }
        // });

        JSxPIChkStaDocCallModalMQ();

    });

    // ========================================== Brows Option Conditon ===========================================
        // ตัวแปร Option Browse Modal กลุ่มธุรกิจ
        var oMerchantOption = function(poDataFnc){
            var tPIBchCode          = poDataFnc.tPIBchCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";

            // สถานะกลุ่มธุรกิจต้องใช้งานเท่านั้น
            tWhereModal += " AND (TCNMMerchant.FTMerStaActive = 1)";

            // เช็คเงื่อนไขแสดงกลุ่มธุรกิจเฉพาะสาขาตัวเอง
            // if(typeof(tPIBchCode) != undefined && tPIBchCode != ""){
            //     tWhereModal += " AND ((SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '"+tPIBchCode+"') != 0) ";
            // }

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
                    Perpage			: 10,
                    OrderBy			: ['TCNMMerchant.FDCreateOn DESC'],
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
                BrowseLev: nPIStaPIBrowseType,
                // DebugSQL: true
            };
            return oOptionReturn;
        }

        // ตัวแปร Option Browse Modal ร้านค้า
        var oShopOption     = function(poDataFnc){
            var tPIBchCode          = poDataFnc.tPIBchCode;
            var tPIMerCode          = poDataFnc.tPIMerCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";

            // สถานะร้านค้าใช้งาน
            tWhereModal += " AND TCNMShop.FTShpStaActive = '1' ";

            // เช็คเงื่อนไขแสดงร้านค้าในสาขาตัวเอง
            if(typeof(tPIBchCode) != undefined && tPIBchCode != ""){
                tWhereModal += " AND TCNMShop.FTBchCode = '"+tPIBchCode+"' ";
            }

            // เช็คเงื่อนไขแสดงร้านค้าในกลุ่มธุรกิจตัวเอง
            if(typeof(tPIMerCode) != undefined && tPIMerCode != ""){
                tWhereModal += " AND TCNMShop.FTMerCode = '"+tPIMerCode+"' ";
            }

            tWhereModal += " AND TCNMShop.FTShpType NOT IN ('4','5') "

            tSHP        = "<?=$this->session->userdata("tSesUsrShpCodeMulti");?>";
            tSHPCount   = '<?=$this->session->userdata("nSesUsrShpCount");?>';
            if(tSHPCount < 2){
                tWhereModal += " ";
            }else{
                tWhereModal += " AND TCNMShop.FTShpCode IN ("+tSHP+")";
            }

            // ตัวแปร ออฟชั่นในการ Return
            var oOptionReturn   = {
                Title: ["company/shop/shop","tSHPTitle_POS"],
                Table: {Master:"TCNMShop",PK:"FTShpCode"},
                Join: {
                    Table: ['TCNMShop_L','TCNMWaHouse_L'],
                    On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                        'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMShop.FTBchCode AND TCNMWaHouse_L.FNLngID= '+nLangEdits
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
                    OrderBy			    : ['TCNMShop.FDCreateOn DESC'],
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
                BrowseLev : nPIStaPIBrowseType,
                // DebugSQL: true
            };
            return oOptionReturn;
        }

        // ตัวแปร Option Browse Modal เครื่องจุดขาย
        var oPosOption      = function(poDataFnc){
            var tPIBchCode          = poDataFnc.tPIBchCode;
            var tPIShpCode          = poDataFnc.tPIShpCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";

            // สถานะเครื่องจุดขายต้องใช้งาน
            tWhereModal +=  " AND (TCNMPos.FTPosStaUse  = 1)";

            // เช็คเงื่อนไขแสดงร้านค้าในสาขาตัวเอง
            if(typeof(tPIBchCode) != undefined && tPIBchCode != ""){
                tWhereModal += " AND ((TVDMPosShop.FTBchCode = '"+tPIBchCode+"') AND TVDMPosShop.FTPshStaUse = 1)";
            }

            // เช็คเงื่อนไขแสดงร้านค้าในร้านค้าตัวเอง
            if(typeof(tPIShpCode) != undefined && tPIShpCode != ""){
                tWhereModal += " AND ((TVDMPosShop.FTShpCode = '"+tPIShpCode+"') AND TVDMPosShop.FTPshStaUse = 1)";
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
                    Perpage: 10,
                    OrderBy: ['TVDMPosShop.FDCreateOn DESC'],
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
                BrowseLev : nPIStaPIBrowseType
            };
            return oOptionReturn;
        }

        // ตัวแปร Option Browse Modal คลังสินค้า
        var oWahOption      = function(poDataFnc){
            var tPIShpCode          = poDataFnc.tPIShpCode;
            var tPIPosCode          = poDataFnc.tPIPosCode;
            var tPIBchCode          = poDataFnc.tPIBchCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";

            if(tPIBchCode != ""){
                tWhereModal += " AND TCNMWaHouse.FTBchCode='"+tPIBchCode+"' ";
                tWhereModal += " AND TCNMShpWah.FTWahCode IS NULL ";
            }

            //ไม่เอาคลังเครื่องจุดขาย
            tWhereModal += " AND (TCNMWaHouse.FTWahStaType NOT IN (6))";

            // Where คลังของ สาขา
            /*if(tPIShpCode == "" && tPIPosCode == ""){
                tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (1,2,5))";
            }*/

            // Where คลังของ ร้านค้า
            /*if(tPIShpCode  != "" && tPIPosCode == ""){
                tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (4))";
                tWhereModal += " AND (TCNMWaHouse.FTWahRefCode = '"+tPIShpCode+"')";
            }*/

            // Where คลังของ เครื่องจุดขาย
            /*if(tPIShpCode  != "" && tPIPosCode != ""){
                tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (6))";
                tWhereModal += " AND (TCNMWaHouse.FTWahRefCode = '"+tPIPosCode+"')";
            }*/

            var oOptionReturn   = {
                Title: ["company/warehouse/warehouse","tWAHTitle"],
                Table: { Master:"TCNMWaHouse", PK:"FTWahCode"},
                Join: {
                    Table: ["TCNMWaHouse_L","TCNMShpWah"],
                    On: [
                        " TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '"+nLangEdits+"' ",
                        " TCNMWaHouse.FTBchCode = TCNMShpWah.FTBchCode AND TCNMWaHouse.FTWahCode = TCNMShpWah.FTWahCode "
                    ]
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
                    Perpage: 10,
                    WidthModal: 50,
                    OrderBy: ['TCNMWaHouse.FDCreateOn DESC'],
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
                BrowseLev : nPIStaPIBrowseType,
                // DebugSQL : true
            }
            return oOptionReturn;
        }

        // ตัวแปร Option Browse Modal คลังสินค้า
        var oShopWahOption      = function(poDataFnc){
            var tPIShpCode          = poDataFnc.tPIShpCode;
            var tPIPosCode          = poDataFnc.tPIPosCode;
            var tPIBchCode          = poDataFnc.tPIBchCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";

            if(tPIBchCode!=""){
                tWhereModal += " AND TCNMShpWah.FTBchCode='"+tPIBchCode+" '";
            }

            // Where คลังของ สาขา
            if(tPIShpCode == "" && tPIPosCode == ""){
                tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (1,2,5))";
            }

            // Where คลังของ ร้านค้า
            // if(tPIShpCode  != "" && tPIPosCode == ""){
            //     tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (4))";
            //     tWhereModal += " AND (TCNMShpWah.FTShpCode = '"+tPIShpCode+"')";
            // }

            // Where คลังของ เครื่องจุดขาย
            if(tPIShpCode  != ""){
                // tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (4))";
                tWhereModal += " AND (TCNMShpWah.FTShpCode = '"+tPIShpCode+"')";
            }


            var oOptionReturn = {
                Title   : ['company/shop/shop','tSHPWah'],
                Table   : {Master:'TCNMShpWah',PK:'FTWahCode'},
                Join    : {
                    Table   : ['TCNMWaHouse','TCNMWaHouse_L'],
                    On      : [
                    'TCNMShpWah.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMShpWah.FTBchCode = TCNMWaHouse.FTBchCode ',
                    'TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode  AND TCNMWaHouse_L.FNLngID = '+nLangEdits,]
                },
                Where : {
                    Condition : [tWhereModal]
                },
                GrideView : {
                    ColumnPathLang  : 'company/shop/shop',
                    ColumnKeyLang   : ['tWahCode','tWahName'],
                    ColumnsSize     : ['15%','75%'],
                    WidthModal      : 50,
                    DataColumns     : ['TCNMShpWah.FTWahCode','TCNMWaHouse_L.FTWahName'],
                    DataColumnsFormat : ['',''],
                    Perpage         : 10,
                    OrderBy   : ['TCNMWaHouse.FDCreateOn DESC'],
                },
                CallBack : {
                    ReturnType : 'S',
                    Value  : [tInputReturnCode,"TCNMShpWah.FTWahCode"],
                    Text  : [tInputReturnName,"TCNMWaHouse_L.FTWahName"],
                },
                // DebugSQL : true
            }

            return oOptionReturn;
        }

        // ตัวแปร Option Browse Modal ตัวแทนจำหน่าย
        var oSplOption      = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tParamsAgnCode      = poDataFnc.tParamsAgnCode;

            var tWhereAgency = '';
            if( tParamsAgnCode != "" ){
                tWhereAgency = " AND ( TCNMSpl.FTAgnCode = '"+tParamsAgnCode+"' OR ISNULL(TCNMSpl.FTAgnCode,'') = '' ) ";
            }else {
                tWhereAgency = "";
            }

            var oOptionReturn       = {
                Title: ['supplier/supplier/supplier', 'tSPLTitle'],
                Table: {Master:'TCNMSpl', PK:'FTSplCode'},
                Join: {
                    Table: ['TCNMSpl_L', 'TCNMSplCredit' , 'VCN_VatActive'],
                    On: [
                        'TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = '+nLangEdits,
                        'TCNMSpl_L.FTSplCode = TCNMSplCredit.FTSplCode',
                        'TCNMSpl.FTVatCode = VCN_VatActive.FTVatCode'
                    ]
                },
                Where:{
                    Condition : [ " AND TCNMSpl.FTSplStaActive = '1' " + tWhereAgency ]
                },
                GrideView:{
                    ColumnPathLang: 'supplier/supplier/supplier',
                    ColumnKeyLang: ['tSPLTBCode', 'tSPLTBName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMSpl.FTSplCode', 'TCNMSpl_L.FTSplName', 'TCNMSplCredit.FNSplCrTerm', 'TCNMSplCredit.FCSplCrLimit', 'TCNMSpl.FTSplStaVATInOrEx', 'TCNMSplCredit.FTSplTspPaid','VCN_VatActive.FTVatCode','VCN_VatActive.FCVatRate'],
                    DataColumnsFormat: ['',''],
                    DisabledColumns: [2, 3, 4, 5 , 6 , 7],
                    Perpage: 10,
                    OrderBy: ['TCNMSpl.FDCreateOn DESC']
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
                BrowseLev: nPIStaPIBrowseType,
                // DebugSQL: true
            };
            return oOptionReturn;
        }

    // ========================================== Brows Event Conditon ===========================================
        // Event Browse Merchant
        $('#obtPIBrowseMerchant').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPIBrowseMerchantOption  = undefined;
                oPIBrowseMerchantOption         = oMerchantOption({
                    'tPIBchCode'        : $('#oetPIFrmBchCode').val(),
                    'tReturnInputCode'  : 'oetPIFrmMerCode',
                    'tReturnInputName'  : 'oetPIFrmMerName',
                    'tNextFuncName'     : 'JSxPISetConditionMerchant',
                    'aArgReturn'        : ['FTMerCode','FTMerName'],
                });
                JCNxBrowseData('oPIBrowseMerchantOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Browse Shop
        $('#obtPIBrowseShop').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPIBrowseShopOption  = undefined;
                oPIBrowseShopOption         = oShopOption({
                    'tPIBchCode'        : $('#oetPIFrmBchCode').val(),
                    'tPIMerCode'        : $('#oetPIFrmMerCode').val(),
                    'tReturnInputCode'  : 'oetPIFrmShpCode',
                    'tReturnInputName'  : 'oetPIFrmShpName',
                    'tNextFuncName'     : 'JSxPISetConditionShop',
                    'aArgReturn'        : ['FTBchCode','FTShpType','FTShpCode','FTShpName','FTWahCode','FTWahName']
                });
                JCNxBrowseData('oPIBrowseShopOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Browse Pos
        $('#obtPIBrowsePos').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPIBrowsePosOption   = undefined;
                oPIBrowsePosOption          = oPosOption({
                    'tPIBchCode'        : $('#oetPIFrmBchCode').val(),
                    'tPIShpCode'        : $('#oetPIFrmShpCode').val(),
                    'tReturnInputCode'  : 'oetPIFrmPosCode',
                    'tReturnInputName'  : 'oetPIFrmPosName',
                    'tNextFuncName'     : 'JSxPISetConditionPos',
                    'aArgReturn'        : ['FTBchCode','FTShpCode','FTPosCode','FTWahCode','FTWahName']
                });
                JCNxBrowseData('oPIBrowsePosOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Browse Warehouse
        $('#obtPIBrowseWahouse').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPIBrowseWahOption   = undefined;
                if($('#oetPIFrmBchCode').val()!='' && $('#oetPIFrmShpCode').val()!=''){
                    oPIBrowseWahOption          = oShopWahOption({
                        'tPIShpCode'        : $('#oetPIFrmShpCode').val(),
                        'tPIPosCode'        : $('#oetPIFrmWahCode').val(),
                        'tPIBchCode'        : $('#oetPIFrmBchCode').val(),
                        'tReturnInputCode'  : 'oetPIFrmWahCode',
                        'tReturnInputName'  : 'oetPIFrmWahName',
                        'tNextFuncName'     : 'JSxPISetConditionWahouse',
                        'aArgReturn'        : []
                    });
                }else if($('#oetPIFrmBchCode').val()!=''){
                    oPIBrowseWahOption          = oWahOption({
                        'tPIShpCode'        : $('#oetPIFrmShpCode').val(),
                        'tPIPosCode'        : $('#oetPIFrmWahCode').val(),
                        'tPIBchCode'        : $('#oetPIFrmBchCode').val(),
                        'tReturnInputCode'  : 'oetPIFrmWahCode',
                        'tReturnInputName'  : 'oetPIFrmWahName',
                        'tNextFuncName'     : 'JSxPISetConditionWahouse',
                        'aArgReturn'        : []
                    });
                }

                JCNxBrowseData('oPIBrowseWahOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Browse Supplier
        $('#obtPIBrowseSupplier').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPIBrowseSplOption   = undefined;
                oPIBrowseSplOption          = oSplOption({
                    'tParamsAgnCode'    : '<?=$this->session->userdata("tSesUsrAgnCode")?>',
                    'tReturnInputCode'  : 'oetPIFrmSplCode',
                    'tReturnInputName'  : 'oetPIFrmSplName',
                    'tNextFuncName'     : 'JSxPISetConditionAfterSelectSpl',
                    'aArgReturn'        : ['FNSplCrTerm', 'FCSplCrLimit', 'FTSplStaVATInOrEx', 'FTSplTspPaid', 'FTSplCode', 'FTSplName', 'FTVatCode', 'FCVatRate']
                });
                JCNxBrowseData('oPIBrowseSplOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });


    // ====================================== Function NextFunc Browse Modal =====================================
        // Functionality : Function Behind NextFunc กลุ่มธุรกิจ
        // Parameter : Event Next Func Modal
        // Create : 26/06/2019 Wasin(Yoshi)
        // Return : Set value And Control Input
        // Return Type : -
        function JSxPISetConditionMerchant(poDataNextFunc){
            var aDataNextFunc,tPIMerCode,tPIMerName;
            if(typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL"){
                aDataNextFunc   = JSON.parse(poDataNextFunc);
                tPIMerCode      = aDataNextFunc[0];
                tPIMerName      = aDataNextFunc[1];
            }

            let tPIBchCode  = $('#oetPIFrmBchCode').val();
            let tPIMchCode  = $('#oetPIFrmMerCode').val();
            let tPIMchName  = $('#oetPIFrmMerName').val();
            let tPIShopCode = $('#oetPIFrmShpCode').val();
            let tPIShopName = $('#oetPIFrmShpName').val();
            let tPIPosCode  = $('#oetPIFrmPosCode').val();
            let tPIPosName  = $('#oetPIFrmPosName').val();
            let tPIWahCode  = $('#oetPIFrmWahCode').val();
            let tPIWahName  = $('#oetPIFrmWahName').val();

            let nCountDataInTable = $('#otbPIDocPdtAdvTableList tbody .xWPdtItem').length;

            if(nCountDataInTable > 0 && tPIMchCode != "" && tPIShopCode != "" && tPIWahCode != ""){
                // รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนกลุ่มธุรกิจ
                var tTextMssage    = '<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIMsgNotiChangeMerchantClearDocTemp');?>';
                FSvCMNSetMsgWarningDialog("<p>"+tTextMssage+"</p>");

                // Event CLick Close Massage And Delete Temp
                $('#odvModalWanning .xWBtnOK').click(function(evn){
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "dcmPIClearDataDocTemp",
                        data: {
                            'ptPIDocNo' : $("#oetPIDocNo").val()
                        },
                        cache: false,
                        success: function (oResult){
                            var aDataReturn     = JSON.parse(oResult);
                            var tMessageError   = aDataReturn['tStaMessg'];
                            switch(aDataReturn['nStaReturn']){
                                case 1:
                                    JSvPILoadPdtDataTableHtml();
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

            // $('#obtPIBrowseShop').attr('disabled', true);
            // $('#obtPIBrowsePos').attr('disabled', true);

            if(tSesUsrLevel == 'HQ' || tSesUsrLevel == 'BCH'){
                // if((tPIMchCode == "" && tPIMchName == "") && (tPIShopCode == "" && tPIShopName == "") && (tPIPosCode == "" && tPIPosName == "" )) {
                //     $('#obtPIBrowseWahouse').attr('disabled', false).removeClass('disabled');

                // }else{
                //     $('#obtPIBrowseShop').attr('disabled',false).removeClass('disabled');
                // }

                $('#oetPIFrmShpCode,#oetPIFrmShpName').val('');
                $('#oetPIFrmPosCode,#oetPIFrmPosName').val('');
                $('#oetPIFrmWahCode,#oetPIFrmWahName').val('');
            }
        }

        // Functionality : Function Behind NextFunc ร้านค้า
        // Parameter : Event Next Func Modal
        // Create : 26/06/2019 Wasin(Yoshi)
        // Return : Set value And Control Input
        // Return Type : -
        function JSxPISetConditionShop(poDataNextFunc){
            var aDataNextFunc,tPIBchCode,tPIShpType,tPIShpCode,tPIShpName,tPIWahCode,tPIWahName;
            if(typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL"){
                aDataNextFunc   = JSON.parse(poDataNextFunc);
                tPIBchCode      = aDataNextFunc[0];
                tPIShpType      = aDataNextFunc[1];
                tPIShpCode      = aDataNextFunc[2];
                tPIShpName      = aDataNextFunc[3];
                tPIWahCode      = aDataNextFunc[4];
                tPIWahName      = aDataNextFunc[5];
            }else{
                $('#oetPIFrmWahCode,#oetPIFrmWahName').val('');
            }

            let tPIDataBchCode  = $('#oetPIFrmBchCode').val();
            let tPIDataMchCode  = $('#oetPIFrmMerCode').val();
            let tPIDataMchName  = $('#oetPIFrmMerName').val();
            let tPIDataShopCode = $('#oetPIFrmShpCode').val();
            let tPIDataShopName = $('#oetPIFrmShpName').val();
            let tPIDataPosCode  = $('#oetPIFrmPosCode').val();
            let tPIDataPosName  = $('#oetPIFrmPosName').val();
            let tPIDataWahCode  = $('#oetPIFrmWahCode').val();
            let tPIDataWahName  = $('#oetPIFrmWahName').val();

            let nCountDataInTable = $('#otbPIDocPdtAdvTableList tbody .xWPdtItem').length;
            if(nCountDataInTable > 0 && tPIDataMchCode != "" && tPIDataShopCode != "" && tPIDataWahCode != ""){
                // Show Modal Notification Found Data In Table Doctemp Behide Change Shop
                FSvCMNSetMsgWarningDialog("<p>รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนร้านค้าใหม่</p>");

                // Event CLick Close Massage And Delete Temp
                $('#odvModalWanning .xWBtnOK').click(function(evn){
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "dcmPIClearDataDocTemp",
                        data: {
                            'ptPIDocNo' : $("#oetPIDocNo").val()
                        },
                        cache: false,
                        success: function (oResult){
                            var aDataReturn     = JSON.parse(oResult);
                            var tMessageError   = aDataReturn['tStaMessg'];
                            switch(aDataReturn['nStaReturn']){
                                case 1:
                                    JSvPILoadPdtDataTableHtml();
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
                if(typeof(tPIShpName) != undefined && tPIShpName != ''){
                    if(tPIShpType == 4){
                        $('#obtPIBrowsePos').attr('disabled',false).removeClass('disabled');
                        // $('#obtPIBrowseWahouse').attr('disabled',true).addClass('disabled');
                        // $('#oetPIFrmWahCode').val(tPIWahCode);
                        // $('#oetPIFrmWahName').val(tPIWahName);
                    }else{
                        // $('#oetPIFrmWahCode').val(tPIWahCode);
                        // $('#oetPIFrmWahName').val(tPIWahName);
                        $('#obtPIBrowsePos').attr('disabled',true).addClass('disabled');
                        // $('#obtPIBrowseWahouse').attr('disabled',true).addClass('disabled');
                    }
                }else{
                    $('#oetPIFrmWahCode,#oetPIFrmWahName').val('');
                }
                $('#oetPIFrmPosCode,#oetPIFrmPosName').val('');
            }

            $('#oetPIFrmWahName,#oetPIFrmWahCode').val('');
        }

        // Functionality : Function Behind NextFunc เครื่องจุดขาย
        // Parameter : Event Next Func Modal
        // Create : 26/06/2019 Wasin(Yoshi)
        // Return : Set value And Control Input
        // Return Type : -
        function JSxPISetConditionPos(poDataNextFunc){
            var aDataNextFunc,tPIBchCode,tPIShpCode,tPIPosCode,tPIWahCode,tPIWahName;
            if(typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL"){
                aDataNextFunc   = JSON.parse(poDataNextFunc);
                tPIBchCode      = aDataNextFunc[0];
                tPIShpCode      = aDataNextFunc[1];
                tPIPosCode      = aDataNextFunc[2];
                tPIWahCode      = aDataNextFunc[3];
                tPIWahName      = aDataNextFunc[4];
                $('#oetPIFrmWahCode').val(tPIWahCode);
                $('#oetPIFrmWahName').val(tPIWahName);
                $('#obtPIBrowsePos').attr('disabled',false).removeClass('disabled');
            }else{
                $('#oetPIFrmPosCode,#oetPIFrmPosCode').val('');
                $('#oetPIFrmWahCode').val('');
                $('#oetPIFrmWahName').val('');
                return;
            }

        }

        // Functionality : Function Behind NextFunc Supllier
        // Parameter : Event Next Func Modal
        // Create : 01/07/2019 Wasin(Yoshi)
        // Return : -
        // Return Type : -
        function JSxPISetConditionAfterSelectSpl(poDataNextFunc){
            var aData;
            if (poDataNextFunc  != "NULL") {
                aData = JSON.parse(poDataNextFunc);
                var poParams = {
                    FNSplCrTerm         : aData[0],
                    FCSplCrLimit        : aData[1],
                    FTSplStaVATInOrEx   : aData[2],
                    FTSplTspPaid        : aData[3],
                    FTSplCode           : aData[4],
                    FTSplName           : aData[5],
                    FTVatCode           : aData[6],
                    FCVatRate           : aData[7]
                };
                JSxPISetPanelSupplierData(poParams);
            }
        }

        // Functionality : ฟังก์ชั่นเซทข้อมูล ผู้จำหน่าย
        // Parameter : Event Next Func Modal
        // Create : 01/07/2019 Wasin(Yoshi)
        // Return : -
        // Return Type : -
        function JSxPISetPanelSupplierData(poParams){
            // Reset Panel เป็นค่าเริ่มต้น
            $("#ocmPIFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            $("#ocmPIFrmSplInfoPaymentType.selectpicker").val("2").selectpicker("refresh");
            $("#ocmPIFrmSplInfoDstPaid.selectpicker").val("1").selectpicker("refresh");
            $("#oetPIFrmSplInfoCrTerm").val("");

            // ประเภทภาษี
            if(poParams.FTSplStaVATInOrEx === "1"){
                // รวมใน
                $("#ocmPIFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            }else{
                // แยกนอก
                $("#ocmPIFrmSplInfoVatInOrEx.selectpicker").val("2").selectpicker("refresh");
            }

            // ประเภทชำระเงิน
            if(poParams.FCSplCrLimit > 0){
                // เงินเชื่อ
                $("#ocmPIFrmSplInfoPaymentType.selectpicker").val("2").selectpicker("refresh");
            }else{
                // เงินสด
                $("#ocmPIFrmSplInfoPaymentType.selectpicker").val("1").selectpicker("refresh");
            }

            // การชำระเงิน
            if(poParams.FTSplTspPaid === "1"){ // ต้นทาง
                $("#ocmPIFrmSplInfoDstPaid.selectpicker").val("1").selectpicker("refresh");
            }else{ // ปลายทาง
                $("#ocmPIFrmSplInfoDstPaid.selectpicker").val("2").selectpicker("refresh");
            }

            // ระยะเครดิต
            $("#oetPIFrmSplInfoCrTerm").val(poParams.FNSplCrTerm);

            // Vat จาก SPL
            $('#ohdPIFrmSplVatCode').val(poParams.FTVatCode);
            $('#ohdPIFrmSplVatRate').val(poParams.FCVatRate);

            //เปลี่ยน VAT
            var tVatCode = poParams.FTVatCode;
            var tVatRate = poParams.FCVatRate;
            JSxChangeVatBySPL(tVatCode,tVatRate);
        }

        //ทุกครั้งที่เปลี่ยน SPL ต้องเกิดการคำนวณ VAT ใหม่ที่อยู่ในสินค้า
        function JSxChangeVatBySPL(tVatCode,tVatRate){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "dcmPIChangeSPLAffectNewVAT",
                data: {
                    'tBCHCode'      : $('#oetPIFrmBchCode').val(),
                    'tPIDocNo'      : $("#oetPIDocNo").val(),
                    'tVatCode'      : tVatCode,
                    'tVatRate'      : tVatRate
                },
                cache: false,
                Timeout: 0,
                success: function (oResult){
                    JSvPILoadPdtDataTableHtml(1)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }


    /** ================================== Manage Product Advance Table Colums  ================================== */
        // Event Call Modal Show Option Advance Product Doc DT Tabel
        $('#obtPIAdvTablePdtDTTemp').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxPIOpenColumnFormSet();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });


        $('#odvPIOrderAdvTblColumns #obtPISaveAdvTableColums').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxPISaveColumnShow();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Functionality : Call Advnced Table
        // Parameters : Event Next Func Modal
        // Creator : 01/07/2019 Wasin(Yoshi)
        // Return : Open Modal Manage Colums Show
        // Return Type : -
        function JSxPIOpenColumnFormSet(){
            $.ajax({
                type: "POST",
                url: "dcmPIAdvanceTableShowColList",
                cache: false,
                Timeout: 0,
                success: function (oResult) {
                    var aDataReturn = JSON.parse(oResult);
                    if(aDataReturn['nStaEvent'] == '1'){
                        var tViewTableShowCollist   = aDataReturn['tViewTableShowCollist'];
                        $('#odvPIOrderAdvTblColumns .modal-body').html(tViewTableShowCollist);
                        $('#odvPIOrderAdvTblColumns').modal({backdrop: 'static', keyboard: false})
                        $("#odvPIOrderAdvTblColumns").modal({ show: true });
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
        function JSxPISaveColumnShow(){
            // คอลัมน์ที่เลือกให้แสดง
            var aPIColShowSet = [];
            $("#odvPIOrderAdvTblColumns .xWPIInputColStaShow:checked").each(function(){
                aPIColShowSet.push($(this).data("id"));
            });

            // คอลัมน์ทั้งหมด
            var aPIColShowAllList = [];
            $("#odvPIOrderAdvTblColumns .xWPIInputColStaShow").each(function () {
                aPIColShowAllList.push($(this).data("id"));
            });

            // ชื่อคอลัมน์ทั้งหมดในกรณีมีการแก้ไขชื่อคอลัมน์ที่แสดง
            var aPIColumnLabelName = [];
            $("#odvPIOrderAdvTblColumns .xWPILabelColumnName").each(function () {
                aPIColumnLabelName.push($(this).text());
            });

            // สถานะย้อนกลับค่าเริ่มต้น
            var nPIStaSetDef;
            if($("#odvPIOrderAdvTblColumns #ocbPISetDefAdvTable").is(":checked")) {
                nPIStaSetDef   = 1;
            } else {
                nPIStaSetDef   = 0;
            }

            $.ajax({
                type: "POST",
                url: "dcmPIAdvanceTableShowColSave",
                data: {
                    'pnPIStaSetDef'         : nPIStaSetDef,
                    'paPIColShowSet'        : aPIColShowSet,
                    'paPIColShowAllList'    : aPIColShowAllList,
                    'paPIColumnLabelName'   : aPIColumnLabelName
                },
                cache: false,
                Timeout: 0,
                success: function (oResult){
                    $("#odvPIOrderAdvTblColumns").modal("hide");
                    $(".modal-backdrop").remove();
                    JSvPILoadPdtDataTableHtml();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    // ===========================================================================================================

    /** ========================================= Set Shipping Address =========================================== */
        $('#obtPIFrmBrowseShipAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('#odvPIBrowseShipAdd').modal({backdrop: 'static', keyboard: false})
                $('#odvPIBrowseShipAdd').modal('show');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Option Browse Shipping Address
        var oPIBrowseShipAddress    = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tPIWhereCons        = poDataFnc.tPIWhereCons;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var oOptionReturn       = {
                Title : ['document/purchaseinvoice/purchaseinvoice','tPIShipAddress'],
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
                    Condition : [tPIWhereCons]
                },
                GrideView:{
                    ColumnPathLang	: 'document/purchaseinvoice/purchaseinvoice',
                    ColumnKeyLang	: [
                        'tPIShipADDBch',
                        'tPIShipADDSeq',
                        'tPIShipADDV1No',
                        'tPIShipADDV1Soi',
                        'tPIShipADDV1Village',
                        'tPIShipADDV1Road',
                        'tPIShipADDV1SubDist',
                        'tPIShipADDV1DstCode',
                        'tPIShipADDV1PvnCode',
                        'tPIShipADDV1PostCode'
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
                    OrderBy			: ['TCNMAddress_L.FDCreateOn DESC'],
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
        $('#odvPIBrowseShipAdd #oliPIEditShipAddress').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tPIWhereCons    = "";
                if($("#oetPIFrmBchCode").val() != ""){
                    if($("#oetPIFrmMerCode").val() != ""){
                        if($("#oetPIFrmShpCode").val() != ""){
                            if($("#oetPIFrmPosCode").val() != ""){
                                // Address Ref POS
                                tPIWhereCons    +=  "AND FTAddGrpType = 6 AND FTAddRefCode = '"+$("#oetPIFrmPosCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                            }else{
                                // Address Ref SHOP
                                tPIWhereCons    +=  "AND FTAddGrpType = 4 AND FTAddRefCode = '"+$("#oetPIFrmShpCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                            }
                        }else{
                            // Address Ref BCH
                            tPIWhereCons        +=  "AND FTAddGrpType = 1 AND FTAddRefCode = '"+$("#oetPIFrmBchCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                        }
                    }else{
                        // Address Ref BCH
                        tPIWhereCons            +=  "AND FTAddGrpType = 1 AND FTAddRefCode = '"+$("#oetPIFrmBchCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                    }
                }
                // Call Option Modal
                window.oPIBrowseShipAddressOption   = undefined;
                oPIBrowseShipAddressOption          = oPIBrowseShipAddress({
                    'tReturnInputCode'  : 'ohdPIShipAddSeqNo',
                    'tReturnInputName'  : 'ohdPIShipAddSeqNo',
                    'tPIWhereCons'     : tPIWhereCons,
                    'tNextFuncName'     : 'JSvPIGetShipAddrData',
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
                $("#odvPIBrowseShipAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxBrowseData('oPIBrowseShipAddressOption');
            }else{
                $("#odvPIBrowseShipAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxShowMsgSessionExpired();
            }
        });

        //Functionality : Behind NextFunc Browse Shippinh Address
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSvPIGetShipAddrData(paInForCon){
            if(paInForCon !== "NULL") {
                var aDataReturn = JSON.parse(paInForCon);
                $("#ospPIShipAddAddV1No").text((aDataReturn[1] != "")      ? aDataReturn[1]    : '-');
                $("#ospPIShipAddV1Soi").text((aDataReturn[2] != "")        ? aDataReturn[2]    : '-');
                $("#ospPIShipAddV1Village").text((aDataReturn[3] != "")    ? aDataReturn[3]    : '-');
                $("#ospPIShipAddV1Road").text((aDataReturn[4] != "")       ? aDataReturn[4]    : '-');
                $("#ospPIShipAddV1SubDist").text((aDataReturn[5] != "")    ? aDataReturn[5]    : '-');
                $("#ospPIShipAddV1DstCode").text((aDataReturn[6] != "")    ? aDataReturn[6]    : '-');
                $("#ospPIShipAddV1PvnCode").text((aDataReturn[7] != "")    ? aDataReturn[7]    : '-');
                $("#ospPIShipAddV1PostCode").text((aDataReturn[8] != "")   ? aDataReturn[8]    : '-');
                $("#ospPIShipAddV2Desc1").text((aDataReturn[9] != "")      ? aDataReturn[9]    : '-');
                $("#ospPIShipAddV2Desc2").text((aDataReturn[10] != "")     ? aDataReturn[10]   : '-');
            }else{
                $("#ospPIShipAddAddV1No").text("-");
                $("#ospPIShipAddV1Soi").text("-");
                $("#ospPIShipAddV1Village").text("-");
                $("#ospPIShipAddV1Road").text("-");
                $("#ospPIShipAddV1SubDist").text("-");
                $("#ospPIShipAddV1DstCode").text("-");
                $("#ospPIShipAddV1PvnCode").text("-");
                $("#ospPIShipAddV1PostCode").text("-");
                $("#ospPIShipAddV2Desc1").text("-");
                $("#ospPIShipAddV2Desc2").text("-");
            }
            $("#odvPIBrowseShipAdd").modal("show");
        }

        //Functionality : Add Shiping Add To Input
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSnPIShipAddData(){
            var tPIShipAddSeqNoSelect   = $('#ohdPIShipAddSeqNo').val();
            $('#ohdPIFrmShipAdd').val(tPIShipAddSeqNoSelect);
            $("#odvPIBrowseShipAdd").modal("hide");
            $('.modal-backdrop').remove();
        }

    // ===========================================================================================================

    /** ============================================ Set Tex Address ============================================= */
        $('#obtPIFrmBrowseTaxAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('#odvPIBrowseTexAdd').modal({backdrop: 'static', keyboard: false})
                $('#odvPIBrowseTexAdd').modal('show');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Option Browse Shipping Address
        var oPIBrowseTexAddress     = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tPIWhereCons        = poDataFnc.tPIWhereCons;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var oOptionReturn       = {
                Title   : ['document/purchaseinvoice/purchaseinvoice','tPITexAddress'],
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
                    Condition : [tPIWhereCons]
                },
                GrideView:{
                    ColumnPathLang	: 'document/purchaseinvoice/purchaseinvoice',
                    ColumnKeyLang	: [
                        'tPITexADDBch',
                        'tPITexADDSeq',
                        'tPITexADDV1No',
                        'tPITexADDV1Soi',
                        'tPITexADDV1Village',
                        'tPITexADDV1Road',
                        'tPITexADDV1SubDist',
                        'tPITexADDV1DstCode',
                        'tPITexADDV1PvnCode',
                        'tPITexADDV1PostCode'
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
                    OrderBy			: ['TCNMAddress_L.FDCreateOn DESC'],
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
        $('#odvPIBrowseTexAdd #oliPIEditTexAddress').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tPIWhereCons    = "AND FTAddGrpType = 1 AND FTAddRefCode = '"+$("#oetPIFrmBchCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                // Call Option Modal
                window.oPIBrowseTexAddressOption    = undefined;
                oPIBrowseTexAddressOption           = oPIBrowseTexAddress({
                    'tReturnInputCode'  : 'ohdPITexAddSeqNo',
                    'tReturnInputName'  : 'ohdPITexAddSeqNo',
                    'tPIWhereCons'     : tPIWhereCons,
                    'tNextFuncName'     : 'JSvPIGetTexAddrData',
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
                $("#odvPIBrowseTexAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxBrowseData('oPIBrowseTexAddressOption');
            }else{
                $("#odvPIBrowseTexAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxShowMsgSessionExpired();
            }
        });

        //Functionality : Behind NextFunc Browse Shippinh Address
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSvPIGetTexAddrData(paInForCon){
            if(paInForCon !== "NULL") {
                var aDataReturn = JSON.parse(paInForCon);
                $("#ospPITexAddAddV1No").text((aDataReturn[1] != "")      ? aDataReturn[1]    : '-');
                $("#ospPITexAddV1Soi").text((aDataReturn[2] != "")        ? aDataReturn[2]    : '-');
                $("#ospPITexAddV1Village").text((aDataReturn[3] != "")    ? aDataReturn[3]    : '-');
                $("#ospPITexAddV1Road").text((aDataReturn[4] != "")       ? aDataReturn[4]    : '-');
                $("#ospPITexAddV1SubDist").text((aDataReturn[5] != "")    ? aDataReturn[5]    : '-');
                $("#ospPITexAddV1DstCode").text((aDataReturn[6] != "")    ? aDataReturn[6]    : '-');
                $("#ospPITexAddV1PvnCode").text((aDataReturn[7] != "")    ? aDataReturn[7]    : '-');
                $("#ospPITexAddV1PostCode").text((aDataReturn[8] != "")   ? aDataReturn[8]    : '-');
                $("#ospPITexAddV2Desc1").text((aDataReturn[9] != "")      ? aDataReturn[9]    : '-');
                $("#ospPITexAddV2Desc2").text((aDataReturn[10] != "")     ? aDataReturn[10]   : '-');
            }else{
                $("#ospPITexAddAddV1No").text("-");
                $("#ospPITexAddV1Soi").text("-");
                $("#ospPITexAddV1Village").text("-");
                $("#ospPITexAddV1Road").text("-");
                $("#ospPITexAddV1SubDist").text("-");
                $("#ospPITexAddV1DstCode").text("-");
                $("#ospPITexAddV1PvnCode").text("-");
                $("#ospPITexAddV1PostCode").text("-");
                $("#ospPITexAddV2Desc1").text("-");
                $("#ospPITexAddV2Desc2").text("-");
            }
            $("#odvPIBrowseTexAdd").modal("show");
        }

        //Functionality : Add Shiping Add To Input
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSnPITexAddData(){
            var tPITexAddSeqNoSelect    = $('#ohdPITexAddSeqNo').val();
            $('#ohdPIFrmTaxAdd').val(tPITexAddSeqNoSelect);
            $("#odvPIBrowseTexAdd").modal("hide");
            $('.modal-backdrop').remove();
        }
    // ===========================================================================================================
    // Functionality: Check Status Document Process EQ And Call Back MQ
    // Parameters: Event Document Ready Load Page
    // Creator: 11/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: -
    // ReturnType: -
    function JSxPIChkStaDocCallModalMQ(){
        var nPILangEdits        = nLangEdits;
        var tPIFrmBchCode       = $("#oetPIFrmBchCode").val();
        var tPIUsrApv           = $("#ohdPIApvCodeUsrLogin").val();
        var tPIDocNo            = $("#oetPIDocNo").val();
        var tPIPrefix           = "RESPPI";
        var tPIStaApv           = $("#ohdPIStaApv").val();
        var tPIStaPrcStk        = $("#ohdPIStaPrcStk").val();
        var tPIStaDelMQ         = $("#ohdPIStaDelMQ").val();
        var tPIQName            = tPIPrefix + "_" + tPIDocNo + "_" + tPIUsrApv;
        var tPITableName        = "TAPTPiHD";
        var tPIFieldDocNo       = "FTXphDocNo";
        var tPIFieldStaApv      = "FTXphStaPrcStk";
        var tPIFieldStaDelMQ    = "FTXphStaDelMQ";

        // MQ Message Config
        var poDocConfig = {
            tLangCode     : nPILangEdits,
            tUsrBchCode   : tPIFrmBchCode,
            tUsrApv       : tPIUsrApv,
            tDocNo        : tPIDocNo,
            tPrefix       : tPIPrefix,
            tStaDelMQ     : tPIStaDelMQ,
            tStaApv       : tPIStaApv,
            tQName        : tPIQName
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
            ptDocTableName      : tPITableName,
            ptDocFieldDocNo     : tPIFieldDocNo,
            ptDocFieldStaApv    : tPIFieldStaApv,
            ptDocFieldStaDelMQ  : tPIFieldStaDelMQ,
            ptDocStaDelMQ       : tPIStaDelMQ,
            ptDocNo             : tPIDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: "JSvPICallPageEditDoc",
            tCallPageList: "JSvPICallPageList"
        };

        // Check Show Progress %
        if(tPIDocNo != '' && (tPIStaApv == 2 || tPIStaPrcStk == 2)){
            FSxCMNRabbitMQMessage(poDocConfig,poMqConfig,poUpdateStaDelQnameParams,poCallback);
        }

        // Check Delete MQ SubScrib
        if(tPIStaApv == 1 && tPIStaPrcStk == 1 && tPIStaDelMQ == ""){
            var poDelQnameParams    = {
                ptPrefixQueueName   : tPIPrefix,
                ptBchCode           : tPIFrmBchCode,
                ptDocNo             : tPIDocNo,
                ptUsrCode           : tPIUsrApv
            };
            FSxCMNRabbitMQDeleteQname(poDelQnameParams);
            FSxCMNRabbitMQUpdateStaDeleteQname(poUpdateStaDelQnameParams);
        }
    }

    //Call Report
    function JSxPIPrintDoc(){
        var aInfor = [
            {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'},
            {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'},
            {"BranchCode"   : '<?=FCNtGetAddressBranch($tPIBchCode); ?>'},
            {"DocCode"      : '<?=$tPIDocNo; ?>'}, // เลขที่เอกสาร
            {"DocBchCode"   : '<?=$tPIBchCode;?>'}
        ];

        var tGrandText = $('#odvPIDataTextBath').text();
        window.open("<?=base_url(); ?>formreport/Frm_SQL_SMBillPi?infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText, '_blank');
    }

    tUsrLevel = "<?=$this->session->userdata('tSesUsrLevel')?>";
    tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    tSQLWhere = "";
    if(tUsrLevel != "HQ"){
        tSQLWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
    }

    $('#obtBrowseTWOBCH').click(function(){ JCNxBrowseData('oBrowse_BCH'); });
    var oBrowse_BCH = {
        Title   : ['company/branch/branch','tBCHTitle'],
        Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join    : {
            Table   : ['TCNMBranch_L','TCNMWaHouse_L'],
            On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID ='+nLangEdits,
                        'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID ='+nLangEdits,
            ]
        },
        Where: {
            Condition: [tSQLWhere]
        },
        GrideView:{
            ColumnPathLang : 'company/branch/branch',
            ColumnKeyLang : ['tBCHCode','tBCHName',''],
            ColumnsSize     : ['15%','75%',''],
            WidthModal      : 50,
            DataColumns  : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMWaHouse_L.FTWahCode','TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat : ['',''],
            DisabledColumns   : [2,3],
            Perpage   : 10,
            OrderBy   : ['TCNMBranch.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType : 'S',
            Value  : ["oetPIFrmBchCode","TCNMBranch.FTBchCode"],
            Text  : ["oetPIFrmBchName","TCNMBranch_L.FTBchName"],
        },
        NextFunc    :   {
            FuncName    :   'JSxSetDefauleWahouse',
            ArgReturn   :   ['FTWahCode','FTWahName']
        }
    }

    function JSxSetDefauleWahouse(ptData){

        $('#oetPIFrmWahCode').val('');
        $('#oetPIFrmWahName').val('');

        $('#oetPIFrmMerCode').val('');
        $('#oetPIFrmMerName').val('');

        $('#oetPIFrmShpCode').val('');
        $('#oetPIFrmShpName').val('');

        if(ptData == '' || ptData == 'NULL'){
            $('#obtPIBrowseShop').attr("disabled",true);
            $('#obtPIBrowseWahouse').attr("disabled",true);
        }else{
            var tResult = JSON.parse(ptData);
            $('#oetPIFrmWahCode').val(tResult[0]);
            $('#oetPIFrmWahName').val(tResult[1]);

            $('#obtPIBrowseShop').attr("disabled",false);
            $('#obtPIBrowseWahouse').attr("disabled",false);
        }
    }

    /*===== Begin Import Excel =========================================================*/
    function JSxOpenImportForm(){
        if($('#oetPIFrmSplCode').val()!=""){
            var tNameModule     = 'purchaseinvoice';
            var tTypeModule     = 'document';
            var tAfterRoute     = 'JSxImportExcelCallback'; // call func
            var tFlagClearTmp   = '1' // null = ไม่สนใจ 1 = ลบหมดเเล้วเพิ่มใหม่ 2 = เพิ่มต่อเนื่อง
            var tDocumentNo = $("#oetPIDocNo").val();
            var tPIFrmBchCode = $("#oetPIFrmBchCode").val();
            var nSplVatRate = $('#ohdPIFrmSplVatRate').val();
            var tSplVatCode = $('#ohdPIFrmSplVatCode').val();
            var aPackdata = {
                'tNameModule'   : tNameModule,
                'tTypeModule'   : tTypeModule,
                'tAfterRoute'   : tAfterRoute,
                'tFlagClearTmp' : tFlagClearTmp,
                'tDocumentNo' : tDocumentNo,
                'tFrmBchCode' : tPIFrmBchCode,
                'nSplVatRate' : nSplVatRate,
                'tSplVatCode' : tSplVatCode,
            };

                JSxImportPopUp(aPackdata);
        }else{
            $('#odvPIModalPleseselectCustomer').modal('show');
        }
    }

    function JSxImportExcelCallback(ptDataCallBack){
        // console.log(ptDataCallBack);


        JCNxOpenLoading();
        JSvPICallEndOfBill();
        $('#ohdPIStaImport').val(1);
        var oJSONPdt = JSON.parse(ptDataCallBack);
        
        var aPdtDupBarCallBackFunction = oJSONPdt['aPdtDupBarCallBackFunction'];
  
        // console.log("length",aPdtDupBarCallBackFunction.length);
        if(aPdtDupBarCallBackFunction.length>0){
            for(var i=0;i<aPdtDupBarCallBackFunction.length;i++){
                $('#ohdWiatScanBarCode'+aPdtDupBarCallBackFunction[i].ptBarCode).remove();
                var tMarkUp = '<input type="hidden" class="ohdWiatScanBarCode" id="ohdWiatScanBarCode'+aPdtDupBarCallBackFunction[i].ptBarCode+'" value="'+aPdtDupBarCallBackFunction[i].ptBarCode+'" >';
                var tMarkUpPri = '<input type="hidden" class="ohdWiatScanPriceBarCode" id="ohdWiatScanPriceBarCode'+aPdtDupBarCallBackFunction[i].ptBarCode+'" value="'+aPdtDupBarCallBackFunction[i].pcPrice+'" >';
                $('#odvPIDataPanelDetailPDT').append(tMarkUp);
                $('#odvPIDataPanelDetailPDT').append(tMarkUpPri);
            }
        }
    
        // console.log("tMarkUp",tMarkUp);
  
        var oOptionForFashion = {
                'bListItemAll'  : false,
                'tSpcControl'  : 0,
                'tNextFunc' : 'FSvPIPDTAddPdtIntoTableDT'
            }
        JSxCheckProductSerialandFashion(oJSONPdt['aPdtCallBackFunction'],oOptionForFashion,'insert');

    }


//open Browse PO Doc
$('#obtPIBrowsePODoc').click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) != 'undefined' && nStaSession == 1) {
        window.oSMPBrowsePODoc = oBrowsePODoc({
            'tReturnInputCode': 'oetPIRefIntDocOld',
            'tReturnInputName': 'oetPIRefIntDocOld',
        });
        JCNxBrowseData('oSMPBrowsePODoc');

    } else {
        JCNxShowMsgSessionExpired();
    }
});

//Browse PO
var oBrowsePODoc = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;
    var tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var tWhereCondition = '';
    if (tSesUsrLevel != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
        tWhereCondition += " AND TAPTPoHD.FTBchCode IN ("+tBchMulti+") ";
    }

    var oSMPBrowsePODoc = {
        Title: ['document/purchaseorder/purchaseorder','tPOTitleMenu'],
        Table: {
            Master: 'TAPTPoHD',
            PK: 'FTXphDocNo'
        },
        Join: {
            Table: ['TCNMBranch_L','TCNMUser_L','TCNMSpl_L'],
            On: [
                'TAPTPoHD.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID =' + nLangEdits,
                'TAPTPoHD.FTCreateBy = TCNMUser_L.FTUsrCode AND TAPTPoHD.FTXphApvCode = TCNMUser_L.FTUsrCode AND TCNMUser_L.FNLngID = ' + nLangEdits,
                'TAPTPoHD.FTSplCode = TCNMSpl_L.FTSplCode AND TCNMSpl_L.FNLngID = ' + nLangEdits
            ]
        },
        Where: {
            Condition: [ 
                " AND TAPTPoHD.FNXphStaDocAct = 1 AND TAPTPoHD.FTXphStaApv = '1' ",
                " AND TAPTPoHD.FTXphDocNo NOT IN (SELECT FTXphRefInt FROM TAPTPIHD WITH(NOLOCK) WHERE ISNULL(FTXphRefInt,'') != '') ", //ไม่เอาใบ PO ที่เคยถูก Ref แล้ว
                tWhereCondition 
            ]
        },
        GrideView: {
            ColumnPathLang: 'document/purchaseorder/purchaseorder',
            ColumnKeyLang: ['tPOTBDocNo','tPOTBBchCreate','tPOTBCreateBy','tPOTBDocDate'],
            WidthModal: 50,
            DataColumns: ['TAPTPoHD.FTXphDocNo', 'TCNMBranch_L.FTBchName','TCNMUser_L.FTUsrName','TAPTPoHD.FDXphDocDate','TAPTPoHD.FTSplCode','TCNMSpl_L.FTSplName'],
            DataColumnsFormat: ['', '','','Date:0','',''],
            DisabledColumns: [4,5],
            Perpage: 10,
            OrderBy: ['TAPTPoHD.FDCreateOn DESC,TAPTPoHD.FTXphDocNo DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TAPTPoHD.FTXphDocNo"],
            Text: [tInputReturnName, "TAPTPoHD.FTXphDocNo"]
        },
        NextFunc: {
            FuncName: 'FSxPINextFuncPODoc',
            ArgReturn: ['FDXphDocDate','FTXphDocNo','FTSplCode','FTSplName']
        },
    };
    return oSMPBrowsePODoc;
}


//Functionality: NextFunc
//Creator: 26/03/2021 Sooksanti(Non)
//Last Update: 05/04/2021 Napat(Jame) เพิ่มการดึง SplCode และ ดึงสินค้าจาก PO
//Return: -
function FSxPINextFuncPODoc(poDataNextFunc) {
    if (typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL") {
        let nChkPdtInTable = $('.xWPdtItem').length;
        if( nChkPdtInTable > 0 ){
            let tMsgWarning = '<?=language('document/purchaseinvoice/purchaseinvoice', 'tPIMsgClearPdt');?>';
            FSvCMNSetMsgWarningDialog(tMsgWarning,'FSxPIMovePODTToDocTmp',poDataNextFunc);
            $("#odvModalWanning button.xCNBTNDefult2Btn.xWBtnCancel").show();
            $("#odvModalWanning button.xCNBTNDefult2Btn.xWBtnCancel").off('click').on('click',function(){
                let tRefIntDo = $('#oetPIRefIntDoc').val();
                $('#oetPIRefIntDocOld').val(tRefIntDo);
            });
        }else{
            FSxPIMovePODTToDocTmp(poDataNextFunc);
        }
    }
}

// Create By : Napat(Jame) 07/04/2021
//ReturnType: 0:DocDate, 1:DocNo, 2:SplCode, 3:SplName
function FSxPIMovePODTToDocTmp(poDataNextFunc){
    JCNxOpenLoading();
    var aDataNextFunc = JSON.parse(poDataNextFunc);
    $('#oetPIRefIntDocDate').datepicker("setDate", new Date(aDataNextFunc[0]));
    $('#oetPIRefIntDocDate').datepicker('update');

    $('#oetPIRefIntDoc').val(aDataNextFunc[1]);
    $('#oetPIRefIntDocName').val(aDataNextFunc[1]);

    $('#oetPIFrmSplCode').val(aDataNextFunc[2]);
    $('#oetPIFrmSplName').val(aDataNextFunc[3]);

    var ptXthDocNoSend  = "";
    if ($("#ohdPIRoute").val() == "dcmPIEventEdit") {
        ptXthDocNoSend = $('#oetPIDocNo').val();
    }

    var tPIVATInOrEx    = $('#ocmPIFrmSplInfoVatInOrEx').val();
    var tPIOptionAddPdt = $('#ocmPIFrmInfoOthReAddPdt').val();

    $('#oetPIInsertBarcode').attr('readonly',false);
    $('#oetPIInsertBarcode').val('');

    $.ajax({
        type : "POST",
        url: "dcmPIMovePODTToDocTmp",
        data:{
            'tPODocNo'            : aDataNextFunc[1],
            'tBCHCode'            : $('#oetPIFrmBchCode').val(),
            'tPIDocNo'            : ptXthDocNoSend,
            'tPIVATInOrEx'        : tPIVATInOrEx,
            'tPIOptionAddPdt'     : tPIOptionAddPdt,
            'ohdSesSessionID'     : $('#ohdSesSessionID').val(),
            'ohdPIUsrCode'        : $('#ohdPIUsrCode').val(),
            'ohdPILangEdit'       : $('#ohdPILangEdit').val(),
            'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
            'ohdPISesUsrBchCode'  : $('#ohdPISesUsrBchCode').val(),
            'nVatRate'            : $('#ohdPIFrmSplVatRate').val(),
            'nVatCode'            : $('#ohdPIFrmSplVatCode').val()
        },
        cache: false,
        timeout: 0,
        success: function(oResult){
            var aResult = JSON.parse(oResult);
            if(aResult['nStaEvent'] == 1){
                JSvPILoadPdtDataTableHtml();
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
