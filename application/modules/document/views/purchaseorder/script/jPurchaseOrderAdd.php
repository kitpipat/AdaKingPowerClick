<script type="text/javascript">
    var nLangEdits        = '<?php echo $this->session->userdata("tLangEdit");?>';
    var tUsrApvName       = '<?php echo $this->session->userdata("tSesUsername");?>';
    var tSesUsrLevel      = '<?php echo $this->session->userdata('tSesUsrLevel');?>';
    var tUserBchCode      = '<?php echo $this->session->userdata("tSesUsrBchCode");?>';
    var tUserBchName      = '<?php echo $this->session->userdata("tSesUsrBchName");?>';
    var tUserWahCode      = '<?php echo $this->session->userdata("tSesUsrWahCode");?>';
    var tUserWahName      = '<?php echo $this->session->userdata("tSesUsrWahName");?>';
    var tRoute                 = $('#ohdPORoute').val();
    var tPOSesSessionID        = $("#ohdSesSessionID").val();
    $(document).ready(function(){

        // if(tUserBchCode != ''){
        //     $('#oetPOFrmBchCode').val(tUserBchCode);
        //     $('#oetPOFrmBchName').val(tUserBchName);
        //     $('#obtPOBrowseBCH').attr("disabled","disabled");
        // }
        if(tUserWahCode != '' && tRoute == 'docPOEventAdd'){
            $('#oetPOFrmWahCode').val(tUserWahCode);
            $('#oetPOFrmWahName').val(tUserWahName);
        }

        $('.selectpicker').selectpicker('refresh');

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });

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


        $('#obtPODocBrowsePdt').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                if($('#oetPOFrmSplCode').val()!=""){
                JSxCheckPinMenuClose();
                JCNvPOBrowsePdt();
                }else{
                    $('#odvPOModalPleseselectSPL').modal('show');
                }
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        if($('#oetPOFrmBchCode').val() == ""){
            $("#obtPOFrmBrowseTaxAdd").attr("disabled","disabled");
        }

        /** =================== Event Search Function ===================== */
            $('#oliPOMngPdtScan').unbind().click(function(){
                var tPOSplCode  = $('#oetPOFrmSplCode').val();
                if(typeof(tPOSplCode) !== undefined && tPOSplCode !== ''){
                    //Hide
                    $('#oetPOFrmFilterPdtHTML').hide();
                    $('#obtPOMngPdtIconSearch').hide();
                    
                    //Show
                    $('#oetPOFrmSearchAndAddPdtHTML').show();
                    $('#obtPOMngPdtIconScan').show();
                }else{
                    var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
            });
            $('#oliPOMngPdtSearch').unbind().click(function(){
                //Hide
                $('#oetPOFrmSearchAndAddPdtHTML').hide();
                $('#obtPOMngPdtIconScan').hide();
                //Show
                $('#oetPOFrmFilterPdtHTML').show();
                $('#obtPOMngPdtIconSearch').show();
            });
        /** =============================================================== */

        /** ===================== Set Date Autometic Doc ========================  */
            var dCurrentDate    = new Date();
            var tAmOrPm         = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
            var tCurrentTime    = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

            if($('#oetPODocDate').val() == ''){
                $('#oetPODocDate').datepicker("setDate",dCurrentDate); 
            }

            if($('#oetPODocTime').val() == ''){
                $('#oetPODocTime').val(tCurrentTime);
            }
        /** =============================================================== */

        /** =================== Event Date Function  ====================== */
            $('#obtPODocDate').unbind().click(function(){
                $('#oetPODocDate').datepicker('show');
            });

            $('#obtPODocTime').unbind().click(function(){
                $('#oetPODocTime').datetimepicker('show');
            });

            $('#obtPOBrowseRefIntDocDate').unbind().click(function(){
                $('#oetPORefIntDocDate').datepicker('show');
            });

            $('#obtPOBrowseRefExtDocDate').unbind().click(function(){
                $('#oetPORefExtDocDate').datepicker('show');
            });

            $('#obtPOFrmSplInfoDueDate').unbind().click(function(){
                $('#oetPOFrmSplInfoDueDate').datepicker('show');
            });

            $('#obtPOFrmSplInfoBillDue').unbind().click(function(){
                $('#oetPOFrmSplInfoBillDue').datepicker('show');
            });

            $('#obtPOFrmSplInfoTnfDate').unbind().click(function(){
                $('#oetPOFrmSplInfoTnfDate').datepicker('show');
            });
        /** =============================================================== */

        /** ================== Check Box Auto GenCode ===================== */
            $('#ocbPOStaAutoGenCode').on('change', function (e) {
                if($('#ocbPOStaAutoGenCode').is(':checked')){
                    $("#oetPODocNo").val('');
                    $("#oetPODocNo").attr("readonly", true);
                    $('#oetPODocNo').closest(".form-group").css("cursor","not-allowed");
                    $('#oetPODocNo').css("pointer-events","none");
                    $("#oetPODocNo").attr("onfocus", "this.blur()");
                    $('#ofmPOFormAdd').removeClass('has-error');
                    $('#ofmPOFormAdd .form-group').closest('.form-group').removeClass("has-error");
                    $('#ofmPOFormAdd em').remove();
                }else{
                    $('#oetPODocNo').closest(".form-group").css("cursor","");
                    $('#oetPODocNo').css("pointer-events","");
                    $('#oetPODocNo').attr('readonly',false);
                    $("#oetPODocNo").removeAttr("onfocus");
                }
            });
        /** =============================================================== */

        $('#ocmPOFrmSplInfoVatInOrEx').on('change', function (e) {
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                // JSvPOLoadPdtDataTableHtml();
                JSvPOCallEndOfBill();
                // JCNxCloseLoading();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });


     var  tPOStaApv =  $('#ohdPOStaApv').val();
       
     if(tPOStaApv==2 || tPOStaApv==1){
   
        $('#obtPODocBrowsePdt').hide();
        $('#obtPOPrintDoc').hide();
        $('#obtPOCancelDoc').hide();
        $('#obtPOApproveDoc').hide();
        $('#odvPOBtnGrpSave').hide();
        // $('.xCNIconTable').addClass('xCNIconDel');
        // $('.xCNIconTable').addClass('xCNDocDisabled');
        // $('.ocbListItem').attr('disabled',true);

        $('#oetPOInsertBarcode').hide();
     }

        // JSxPOChkStaDocCallModalMQ();

    });
 
    // ========================================== Brows Option Conditon ===========================================
        // ตัวแปร Option Browse Modal กลุ่มธุรกิจ
        var oMerchantOption = function(poDataFnc){
            var tPOBchCode          = poDataFnc.tPOBchCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";
            
            // สถานะกลุ่มธุรกิจต้องใช้งานเท่านั้น
            tWhereModal += " AND (TCNMMerchant.FTMerStaActive = 1)";

            // เช็คเงื่อนไขแสดงกลุ่มธุรกิจเฉพาะสาขาตัวเอง
            if(typeof(tPOBchCode) != undefined && tPOBchCode != ""){
                tWhereModal += " AND ((SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '"+tPOBchCode+"') != 0)";
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
                BrowseLev: nPOStaBrowseType
            };
            return oOptionReturn;
        }
        
        // ตัวแปร Option Browse Modal ร้านค้า
        var oShopOption     = function(poDataFnc){
            var tPOBchCode          = poDataFnc.tPOBchCode;
            var tPOMerCode          = poDataFnc.tPOMerCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";

            // สถานะร้านค้าใช้งาน
            tWhereModal += " AND (TCNMShop.FTShpStaActive = 1)";

            // เช็คเงื่อนไขแสดงร้านค้าในสาขาตัวเอง
            if(typeof(tPOBchCode) != undefined && tPOBchCode != ""){
                tWhereModal += " AND ((TCNMShop.FTBchCode = '"+tPOBchCode+"') AND TCNMShop.FTShpType  != 5)"
            }

            // เช็คเงื่อนไขแสดงร้านค้าในกลุ่มธุรกิจตัวเอง
            if(typeof(tPOMerCode) != undefined && tPOMerCode != ""){
                tWhereModal += " AND ((TCNMShop.FTMerCode = '"+tPOMerCode+"') AND TCNMShop.FTShpType  != 5)";

            }

            // ตัวแปร ออฟชั่นในการ Return
            var oOptionReturn   = {
                Title: ["company/shop/shop","tSHPTitle"],
                Table: {Master:"TCNMShop",PK:"FTShpCode"},
                Join: {
                    Table: ['TCNMShop_L'],
                    On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                        
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
                    DataColumns         : ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName','TCNMShop.FTShpType','TCNMShop.FTBchCode'],
                    DataColumnsFormat   : ['','','',''],
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
                BrowseLev : nPOStaBrowseType
            };
            return oOptionReturn;
        }

        // ตัวแปร Option Browse Modal เครื่องจุดขาย
        var oPosOption      = function(poDataFnc){
            var tPOBchCode          = poDataFnc.tPOBchCode;
            var tPOShpCode          = poDataFnc.tPOShpCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tWhereModal         = "";

            // สถานะเครื่องจุดขายต้องใช้งาน
            tWhereModal +=  " AND (TVDMPosShop.FTPshStaUse  = 1)";

            // เช็คเงื่อนไขแสดงร้านค้าในสาขาตัวเอง
            if(typeof(tPOBchCode) != undefined && tPOBchCode != ""){
                tWhereModal += " AND (TVDMPosShop.FTBchCode = '"+tPOBchCode+"') ";
            }

            // เช็คเงื่อนไขแสดงร้านค้าในร้านค้าตัวเอง
            if(typeof(tPOShpCode) != undefined && tPOShpCode != ""){
                tWhereModal += " AND (TVDMPosShop.FTShpCode = '"+tPOShpCode+"')";
            }

            // ตัวแปร ออฟชั่นในการ Return
            var oOptionReturn   = {
                Title: ["pos/posshop/posshop","tPshTitle"],
                Table: { Master:'TVDMPosShop', PK:'FTPosCode' },
                Join: {
                    Table: ['TCNMPos_L','TCNMWaHouse', 'TCNMWaHouse_L'],
                    On: [
                        "TCNMPos_L.FTPosCode = TVDMPosShop.FTPosCode AND TCNMPos_L.FtBchCode = TVDMPosShop.FTBchCode",
                        "TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TVDMPosShop.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse.FTWahStaType = 6",
                        "TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode=TCNMWaHouse_L.FTBchCode  AND TCNMWaHouse_L.FNLngID = '"+nLangEdits+"'"
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
                    DataColumns: ['TVDMPosShop.FTPosCode','TCNMPos_L.FTPosName','TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                    DataColumnsFormat : ['', ''],
                    DisabledColumns: [2,3],
                    Perpage: 5,
                    OrderBy: ['TVDMPosShop.FTPosCode ASC'],
                },
                CallBack: {
                    ReturnType  : 'S',
                    Value       : [tInputReturnCode,"TVDMPosShop.FTPosCode"],
                    Text        : [tInputReturnName,"TVDMPosShop.FTPosName"]
                },
                NextFunc: {
                    FuncName    : tNextFuncName,
                    ArgReturn   : aArgReturn
                },
                RouteAddNew: 'salemachine',
                BrowseLev : nPOStaBrowseType
            };
            return oOptionReturn;
        }

        // ตัวแปร Option Browse Modal คลังสินค้า
        var oWahOption      = function(poDataFnc){
            var tPOBchCode          = poDataFnc.tPOBchCode;
            var tPOShpCode          = poDataFnc.tPOShpCode;
            var tPOPosCode          = poDataFnc.tPOPosCode;
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;


        
            if(tPOShpCode  != ""){
            var oOptionReturn = {
            Title   : ['company/shop/shop','tSHPWah'],
            Table   : {Master:'TCNMShpWah',PK:'FTWahCode'},
            Join    : {
                Table   : ['TCNMWaHouse_L' , 'TCNMWaHouse'],
                On      : [
                            'TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMShpWah.FTBchCode  AND TCNMWaHouse_L.FNLngID = '+nLangEdits,
                            'TCNMShpWah.FTWahCode =  TCNMWaHouse.FTWahCode AND  TCNMShpWah.FTBchCode = TCNMWaHouse.FTBchCode '
                            ]
            },
            Where : {
                Condition : [" AND TCNMWaHouse.FTWahStaType = 4 AND TCNMShpWah.FTShpCode = '" + tPOShpCode + "' AND TCNMShpWah.FTBchCode = '"+ tPOBchCode + "' "]
            },
            GrideView : {
                ColumnPathLang  : 'company/shop/shop',
                ColumnKeyLang   : ['tWahCode','tWahName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns     : ['TCNMShpWah.FTWahCode','TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat : ['',''],
                Perpage         : 10,
                OrderBy   : ['TCNMWaHouse_L.FTWahName'],
                SourceOrder  : "ASC"
            },
            CallBack : {
                ReturnType : 'S',
                Value  : ["oetTROutWahFromCode","TCNMShpWah.FTWahCode"],
                Text  : ["oetTROutWahFromName","TCNMWaHouse_L.FTWahName"],
            }
           }
        }else
        if(tPOShpCode == ""){
            var oOptionReturn   = {
                Title: ["company/warehouse/warehouse","tWAHTitle"],
                Table: { Master:"TCNMWaHouse", PK:"FTWahCode"},
                Join: {
                    Table: ["TCNMWaHouse_L"],
                    On: ["TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode=TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '"+nLangEdits+"'"]
                },
                Where: {
                    Condition : [" AND (TCNMWaHouse.FTWahStaType IN (1,2,5) AND  TCNMWaHouse.FTBchCode='"+tPOBchCode+"')"]
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
                BrowseLev : nPOStaBrowseType
            }
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
            var nPODecimalShow   = $('#ohdPOODecimalShow').val();
            
            if( tParamsAgnCode != "" ){
                tWhereAgency = " AND ( TCNMSpl.FTAgnCode = '"+tParamsAgnCode+"' OR ISNULL(TCNMSpl.FTAgnCode,'') = '' ) ";
            }else{
                tWhereAgency = "";
            }

            var oOptionReturn       = {
                Title: ['supplier/supplier/supplier', 'tSPLTitle'],
                Table: {Master:'TCNMSpl', PK:'FTSplCode'},
                Join: {
                    Table: ['TCNMSpl_L', 'TCNMSplCredit', 'TCNMVatRate'],
                    On: [
                        'TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = '+nLangEdits,
                        'TCNMSpl_L.FTSplCode = TCNMSplCredit.FTSplCode',
                        'TCNMSpl.FTVatCode = TCNMVatRate.FTVatCode'
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
                    DataColumns: ['TCNMSpl.FTSplCode', 'TCNMSpl_L.FTSplName', 'TCNMSplCredit.FNSplCrTerm', 'CAST(TCNMSplCredit.FCSplCrLimit AS NUMERIC(18,'+nPODecimalShow+')) AS FCSplCrLimit', 'TCNMSpl.FTSplStaVATInOrEx', 'TCNMSplCredit.FTSplTspPaid','TCNMVatRate.FTVatCode','TCNMVatRate.FCVatRate'],
                    DataColumnsFormat: ['',''],
                    DisabledColumns: [2, 3, 4, 5 , 6 , 7],
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
                BrowseLev: nPOStaBrowseType
            };
            return oOptionReturn;
        }

    // ============================================================================================================

    // ========================================== Brows Event Conditon ===========================================
        // Event Browse Merchant
        $('#obtPOBrowseMerchant').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPOBrowseMerchantOption  = undefined;
                oPOBrowseMerchantOption         = oMerchantOption({
                    'tPOBchCode'        : $('#oetPOFrmBchCode').val(),
                    'tReturnInputCode'  : 'oetPOFrmMerCode',
                    'tReturnInputName'  : 'oetPOFrmMerName',
                    'tNextFuncName'     : 'JSxPOSetConditionMerchant',
                    'aArgReturn'        : ['FTMerCode','FTMerName'],
                });
                JCNxBrowseData('oPOBrowseMerchantOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        
        // Event Browse Shop
        $('#obtPOBrowseShop').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPOBrowseShopOption  = undefined;
                oPOBrowseShopOption         = oShopOption({
                    'tPOBchCode'        : $('#oetPOFrmBchCode').val(),
                    'tPOMerCode'        : $('#oetPOFrmMerCode').val(),
                    'tReturnInputCode'  : 'oetPOFrmShpCode',
                    'tReturnInputName'  : 'oetPOFrmShpName',
                    'tNextFuncName'     : 'JSxPOSetConditionShop',
                    'aArgReturn'        : ['FTBchCode','FTShpType','FTShpCode','FTShpName']
                });
                JCNxBrowseData('oPOBrowseShopOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Browse Pos
        $('#obtPOBrowsePos').unbind().click(function(){
            // alert(111);
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPOBrowsePosOption   = undefined;
                oPOBrowsePosOption          = oPosOption({
                    'tPOBchCode'        : $('#oetPOFrmBchCode').val(),
                    'tPOShpCode'        : $('#oetPOFrmShpCode').val(),
                    'tReturnInputCode'  : 'oetPOFrmPosCode',
                    'tReturnInputName'  : 'oetPOFrmPosName',
                    'tNextFuncName'     : 'JSxPOSetConditionPos',
                    'aArgReturn'        : ['FTPosCode','FTWahCode','FTWahName']
                });
                JCNxBrowseData('oPOBrowsePosOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Browse Warehouse
        $('#obtPOBrowseWahouse').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPOBrowseWahOption   = undefined;
                oPOBrowseWahOption          = oWahOption({
                    'tPOBchCode'        : $('#oetPOFrmBchCode').val(),
                    'tPOShpCode'        : $('#oetPOFrmShpCode').val(),
                    'tPOPosCode'        : $('#oetPOFrmWahCode').val(),
                    'tReturnInputCode'  : 'oetPOFrmWahCode',
                    'tReturnInputName'  : 'oetPOFrmWahName',
                    'tNextFuncName'     : 'JSxPOSetConditionWahouse',
                    'aArgReturn'        : []
                });
                JCNxBrowseData('oPOBrowseWahOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Browse Supplier
        $('#obtPOBrowseSupplier').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPOBrowseSplOption   = undefined;
                oPOBrowseSplOption          = oSplOption({
                    'tParamsAgnCode'    : '<?=$this->session->userdata("tSesUsrAgnCode")?>',
                    'tReturnInputCode'  : 'oetPOFrmSplCode',
                    'tReturnInputName'  : 'oetPOFrmSplName',
                    'tNextFuncName'     : 'JSxPOSetConditionAfterSelectSpl',
                    'aArgReturn'        : ['FNSplCrTerm', 'FCSplCrLimit', 'FTSplStaVATInOrEx', 'FTSplTspPaid', 'FTSplCode', 'FTSplName', 'FTVatCode', 'FCVatRate']
                });
                JCNxBrowseData('oPOBrowseSplOption');
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
        function JSxPOSetConditionMerchant(poDataNextFunc){
            var aDataNextFunc,tPOMerCode,tPOMerName;
            if(typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL"){
                aDataNextFunc   = JSON.parse(poDataNextFunc);
                tPOMerCode      = aDataNextFunc[0];
                tPOMerName      = aDataNextFunc[1];
            }
            
            let tPOBchCode  = $('#oetPOFrmBchCode').val();
            let tPOMchCode  = $('#oetPOFrmMerCode').val();
            let tPOMchName  = $('#oetPOFrmMerName').val();
            let tPOShopCode = $('#oetPOFrmShpCode').val();
            let tPOShopName = $('#oetPOFrmShpName').val();
            let tPOPosCode  = $('#oetPOFrmPosCode').val();
            let tPOPosName  = $('#oetPOFrmPosName').val();
            let tPOWahCode  = $('#oetPOFrmWahCode').val();
            let tPOWahName  = $('#oetPOFrmWahName').val();

            let nCountDataInTable = $('#otbPODocPdtAdvTableList tbody .xWPdtItem').length;
            
            if(nCountDataInTable > 0 && tPOMchCode != "" && tPOShopCode != "" && tPOWahCode != ""){
                // รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนกลุ่มธุรกิจ
                var tTextMssage    = '<?php echo language('document/purchaseorder/purchaseorder','tPOMsgNotiChangeMerchantClearDocTemp');?>';
                FSvCMNSetMsgWarningDialog("<p>"+tTextMssage+"</p>");
                
                // Event CLick Close Massage And Delete Temp
                $('#odvModalWanning .xWBtnOK').click(function(evn){
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "docPOClearDataDocTemp",
                        data: {
                            'ptPODocNo' : $("#oetPODocNo").val()
                        },
                        cache: false,
                        success: function (oResult){
                            var aDataReturn     = JSON.parse(oResult);
                            var tMessageError   = aDataReturn['tStaMessg'];
                            switch(aDataReturn['nStaReturn']){
                                case 1:
                                    JSvPOLoadPdtDataTableHtml();
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

            $('#obtPOBrowseShop').attr('disabled', true);
            $('#obtPOBrowsePos').attr('disabled', true);
            // $('#obtPOBrowseWahouse').attr('disabled', true);
            
            if(tSesUsrLevel == 'HQ' || tSesUsrLevel == 'BCH'){
                if((tPOMchCode == "" && tPOMchName == "") && (tPOShopCode == "" && tPOShopName == "") && (tPOPosCode == "" && tPOPosName == "" )) {
                    $('#obtPOBrowseWahouse').attr('disabled', false).removeClass('disabled');

                }else{
                    $('#obtPOBrowseShop').attr('disabled',false).removeClass('disabled');
                    // $('#obtPOBrowseWahouse').attr('disabled', true).addClass('disabled');
                }

                $('#oetPOFrmShpCode,#oetPOFrmShpName').val('');
                $('#oetPOFrmPosCode,#oetPOFrmPosName').val('');
                $('#oetPOFrmWahCode,#oetPOFrmWahName').val('');
            }
        }

        // Functionality : Function Behind NextFunc ร้านค้า
        // Parameter : Event Next Func Modal
        // Create : 26/06/2019 Wasin(Yoshi)
        // Return : Set value And Control Input
        // Return Type : -
        function JSxPOSetConditionShop(poDataNextFunc){
            var aDataNextFunc,tPOBchCode,tPOShpType,tPOShpCode,tPOShpName,tPOWahCode,tPOWahName;
            if(typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL"){
                aDataNextFunc   = JSON.parse(poDataNextFunc);
                tPOBchCode      = aDataNextFunc[0];
                tPOShpType      = aDataNextFunc[1];
                tPOShpCode      = aDataNextFunc[2];
                tPOShpName      = aDataNextFunc[3];
      
            }else{
                $('#oetPOFrmWahCode,#oetPOFrmWahName').val('');
            }

            let tPODataBchCode  = $('#oetPOFrmBchCode').val();
            let tPODataMchCode  = $('#oetPOFrmMerCode').val();
            let tPODataMchName  = $('#oetPOFrmMerName').val();
            let tPODataShopCode = $('#oetPOFrmShpCode').val();
            let tPODataShopName = $('#oetPOFrmShpName').val();
            let tPODataPosCode  = $('#oetPOFrmPosCode').val();
            let tPODataPosName  = $('#oetPOFrmPosName').val();
      

            let nCountDataInTable = $('#otbPODocPdtAdvTableList tbody .xWPdtItem').length;
            if(nCountDataInTable > 0 && tPODataMchCode != "" && tPODataShopCode != "" && tPODataWahCode != ""){
                // Show Modal Notification Found Data In Table Doctemp Behide Change Shop 
                FSvCMNSetMsgWarningDialog("<p>รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนร้านค้าใหม่</p>");
                
                // Event CLick Close Massage And Delete Temp
                $('#odvModalWanning .xWBtnOK').click(function(evn){
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "docPOClearDataDocTemp",
                        data: {
                            'ptPODocNo' : $("#oetPODocNo").val()
                        },
                        cache: false,
                        success: function (oResult){
                            var aDataReturn     = JSON.parse(oResult);
                            var tMessageError   = aDataReturn['tStaMessg'];
                            switch(aDataReturn['nStaReturn']){
                                case 1:
                                    JSvPOLoadPdtDataTableHtml();
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
                if(typeof(tPOShpName) != undefined && tPOShpName != ''){
                    // if(tPOShpType == 4){
                        $('#obtPOBrowsePos').attr('disabled',false).removeClass('disabled');
                        // $('#obtPOBrowseWahouse').attr('disabled',true).addClass('disabled');
                        // $('#oetPOFrmWahCode').val(tPOWahCode);
                        // $('#oetPOFrmWahName').val(tPOWahName);
                    // }else{
                        // $('#oetPOFrmWahCode').val(tPOWahCode);
                        // $('#oetPOFrmWahName').val(tPOWahName);
                        // $('#obtPOBrowsePos').attr('disabled',true).addClass('disabled');
                        // $('#obtPOBrowseWahouse').attr('disabled',true).addClass('disabled');
                    // }
                }else{
                    $('#obtPOBrowsePos').attr('disabled',true).addClass('disabled');
                    $('#oetPOFrmWahCode,#oetPOFrmWahName').val('');
                }
                $('#oetPOFrmPosCode,#oetPOFrmPosName').val('');
            }

        }

        // Functionality : Function Behind NextFunc เครื่องจุดขาย
        // Parameter : Event Next Func Modal
        // Create : 26/06/2019 Wasin(Yoshi)
        // Return : Set value And Control Input
        // Return Type : -
        function JSxPOSetConditionPos(poDataNextFunc){
    
            var aDataNextFunc,tPOBchCode,tPOShpCode,tPOPosCode,tPOWahCode,tPOWahName;
            if(typeof(poDataNextFunc) != undefined && poDataNextFunc != "NULL"){
                aDataNextFunc   = JSON.parse(poDataNextFunc);
                // tPOBchCode      = aDataNextFunc[0];
                // tPOShpCode      = aDataNextFunc[1];
                tPOPosCode      = aDataNextFunc[0];
                tPOWahCode      = aDataNextFunc[1];
                tPOWahName      = aDataNextFunc[2];
                $('#oetPOFrmWahCode').val(tPOWahCode);
                $('#oetPOFrmWahName').val(tPOWahName);
                $('#obtPOBrowsePos').attr('disabled',false).removeClass('disabled');
                $('#obtPOBrowseWahouse').attr('disabled',true).addClass('disabled');
            }else{
                $('#oetPOFrmPosCode,#oetPOFrmPosCode').val('');
                // $('#oetPOFrmWahCode').val('');
                // $('#oetPOFrmWahName').val('');
                return;
            }
            // $('#obtPOBrowseWahouse').attr('disabled',true).addClass('disabled');
            // $('#obtPOBrowseWahouse').attr('disabled',false).removeClass('disabled');
       
        }

        // Functionality : Function Behind NextFunc Supllier
        // Parameter : Event Next Func Modal
        // Create : 01/07/2019 Wasin(Yoshi)
        // Return : -
        // Return Type : -
        function JSxPOSetConditionAfterSelectSpl(poDataNextFunc){
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
                JSxPOSetPanelSupplierData(poParams);
            }
        }


        // Functionality : Posecc AddDisTmpCst
        // Parameters : FTCstDiscRet
        // Creator : 18/02/2020 Nattakit(Nale)
        // Return : -
        // Return Type : -
        function JSxPOPocessAddDisTmpCst(rtCstDiscRet){
            $.ajax({
                type: "POST",
                url: "docPOPocessAddDisTmpCst",
                
                data : {
                    tCstDiscRet : rtCstDiscRet,
                    tBchCode    : $('#oetPOFrmBchCode').val(),
                    tDocNo      : $('#oetPODocNo').val(),
                    tVatInOrEx  : $('#ocmPOFrmSplInfoVatInOrEx').val(), // 1: รวมใน, 2: แยกนอก
                    },
                cache: false,
                Timeout: 0,
                success: function (oResult) {
                    var aDataReturn = JSON.parse(oResult);
                    if(aDataReturn['nStaEvent'] == '1'){
                        JSvPOLoadPdtDataTableHtml();
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




        // Functionality : ฟังก์ชั่นเซทข้อมูล ผู้จำหน่าย
        // Parameter : Event Next Func Modal
        // Create : 01/07/2019 Wasin(Yoshi)
        // Return : -
        // Return Type : -
        function JSxPOSetPanelSupplierData(poParams){
            // Reset Panel เป็นค่าเริ่มต้น
            $("#ocmPOFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            $("#ocmPOFrmSplInfoPaymentType.selectpicker").val("2").selectpicker("refresh");
            $("#ocmPOFrmSplInfoDstPaid.selectpicker").val("1").selectpicker("refresh");
            $("#oetPOFrmSplInfoCrTerm").val("");

            // ประเภทภาษี
            if(poParams.FTSplStaVATInOrEx === "1"){
                // รวมใน
                $("#ocmPOFrmSplInfoVatInOrEx.selectpicker").val("1").selectpicker("refresh");
            }else{
                // แยกนอก
                $("#ocmPOFrmSplInfoVatInOrEx.selectpicker").val("2").selectpicker("refresh");
            }

            // ประเภทชำระเงิน
            if(poParams.FCSplCrLimit > 0){
                // เงินเชื่อ
                $("#ocmPOFrmSplInfoPaymentType.selectpicker").val("2").selectpicker("refresh");
            }else{
                // เงินสด
                $("#ocmPOFrmSplInfoPaymentType.selectpicker").val("1").selectpicker("refresh");
            }

            // การชำระเงิน
            if(poParams.FTSplTspPaid === "1"){ // ต้นทาง
                $("#ocmPOFrmSplInfoDstPaid.selectpicker").val("1").selectpicker("refresh");
            }else{ // ปลายทาง
                $("#ocmPOFrmSplInfoDstPaid.selectpicker").val("2").selectpicker("refresh");
            }
            
            // ระยะเครดิต
            $("#oetPOFrmSplInfoCrTerm").val(poParams.FNSplCrTerm);

            // Vat จาก SPL
            $('#ohdPOFrmSplVatCode').val(poParams.FTVatCode);
            $('#ohdPOFrmSplVatRate').val(poParams.FCVatRate);

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
                url: "dcmPOChangeSPLAffectNewVAT",
                data: {
                    'tBCHCode'      : $('#oetPOFrmBchCode').val(),
                    'tPODocNo'      : $("#oetPODocNo").val(),
                    'tVatCode'      : tVatCode,
                    'tVatRate'      : tVatRate
                },
                cache: false,
                Timeout: 0,
                success: function (oResult){
                    //JSvPILoadPdtDataTableHtml(1)
                     JSvPOCallEndOfBill();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }

    // ===========================================================================================================

    /** ================================== Manage Product Advance Table Colums  ================================== */
        // Event Call Modal Show Option Advance Product Doc DT Tabel
        $('#obtPOAdvTablePdtDTTemp').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxPOOpenColumnFormSet();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });


        $('#odvPOOrderAdvTblColumns #obtPOSaveAdvTableColums').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxPOSaveColumnShow();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Functionality : Call Advnced Table 
        // Parameters : Event Next Func Modal
        // Creator : 01/07/2019 Wasin(Yoshi)
        // Return : Open Modal Manage Colums Show
        // Return Type : -
        function JSxPOOpenColumnFormSet(){
            $.ajax({
                type: "POST",
                url: "docPOAdvanceTableShowColList",
                cache: false,
                Timeout: 0,
                success: function (oResult) {
                    var aDataReturn = JSON.parse(oResult);
                    if(aDataReturn['nStaEvent'] == '1'){
                        var tViewTableShowCollist   = aDataReturn['tViewTableShowCollist'];
                        $('#odvPOOrderAdvTblColumns .modal-body').html(tViewTableShowCollist);
                        $('#odvPOOrderAdvTblColumns').modal({backdrop: 'static', keyboard: false})  
                        $("#odvPOOrderAdvTblColumns").modal({ show: true });
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
        function JSxPOSaveColumnShow(){
            // คอลัมน์ที่เลือกให้แสดง
            var aPOColShowSet = [];
            $("#odvPOOrderAdvTblColumns .xWPIInputColStaShow:checked").each(function(){
                aPOColShowSet.push($(this).data("id"));
            });

            // คอลัมน์ทั้งหมด
            var aPOColShowAllList = [];
            $("#odvPOOrderAdvTblColumns .xWPIInputColStaShow").each(function () {
                aPOColShowAllList.push($(this).data("id"));
            });

            // ชื่อคอลัมน์ทั้งหมดในกรณีมีการแก้ไขชื่อคอลัมน์ที่แสดง
            var aPOColumnLabelName = [];
            $("#odvPOOrderAdvTblColumns .xWPILabelColumnName").each(function () {
                aPOColumnLabelName.push($(this).text());
            });

            // สถานะย้อนกลับค่าเริ่มต้น
            var nPOStaSetDef;
            if($("#odvPOOrderAdvTblColumns #ocbPOSetDefAdvTable").is(":checked")) {
                nPOStaSetDef   = 1;
            } else {
                nPOStaSetDef   = 0;
            }

            $.ajax({
                type: "POST",
                url: "docPOAdvanceTableShowColSave",
                data: {
                    'pnPOStaSetDef'         : nPOStaSetDef,
                    'paPOColShowSet'        : aPOColShowSet,
                    'paPOColShowAllList'    : aPOColShowAllList,
                    'paPOColumnLabelName'   : aPOColumnLabelName
                },
                cache: false,
                Timeout: 0,
                success: function (oResult){
                    $("#odvPOOrderAdvTblColumns").modal("hide");
                    $(".modal-backdrop").remove();
                    JSvPOLoadPdtDataTableHtml();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    // ===========================================================================================================

    /** ========================================= Set Shipping Address =========================================== */
        $('#obtPOFrmBrowseShipAdd').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('#odvPOBrowseShipAdd').modal({backdrop: 'static', keyboard: false})  
                $('#odvPOBrowseShipAdd').modal('show');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Option Browse Shipping Address
        var oPOBrowseShipAddress    = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tPOWhereCons        = poDataFnc.tPOWhereCons;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var oOptionReturn       = {
                Title : ['document/purchaseorder/purchaseorder','tPOShipAddress'],
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
                    Condition : [tPOWhereCons]
                },
                GrideView:{
                    ColumnPathLang	: 'document/purchaseorder/purchaseorder',
                    ColumnKeyLang	: [
                        'tPOShipADDBch',
                        'tPOShipADDSeq',
                        'tPOShipADDV1No',
                        'tPOShipADDV1Soi',
                        'tPOShipADDV1Village',
                        'tPOShipADDV1Road',
                        'tPOShipADDV1SubDist',
                        'tPOShipADDV1DstCode',
                        'tPOShipADDV1PvnCode',
                        'tPOShipADDV1PostCode'
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
        $('#odvPOBrowseShipAdd #oliPOEditShipAddress').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tPOWhereCons    = "";
                if($("#oetPOFrmBchCode").val() != ""){
                    if($("#oetPOFrmMerCode").val() != ""){
                        if($("#oetPOFrmShpCode").val() != ""){
                            if($("#oetPOFrmPosCode").val() != ""){
                                // Address Ref POS
                                tPOWhereCons    +=  "AND FTAddGrpType = 6 AND FTAddRefCode = '"+$("#oetPOFrmPosCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                            }else{
                                // Address Ref SHOP
                                tPOWhereCons    +=  "AND FTAddGrpType = 4 AND FTAddRefCode = '"+$("#oetPOFrmShpCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                            }
                        }else{
                            // Address Ref BCH
                            tPOWhereCons        +=  "AND FTAddGrpType = 1 AND FTAddRefCode = '"+$("#oetPOFrmBchCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                        }
                    }else{
                        // Address Ref BCH
                        tPOWhereCons            +=  "AND FTAddGrpType = 1 AND FTAddRefCode = '"+$("#oetPOFrmBchCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                    }
                }
                // Call Option Modal
                window.oPOBrowseShipAddressOption   = undefined;
                oPOBrowseShipAddressOption          = oPOBrowseShipAddress({
                    'tReturnInputCode'  : 'ohdPOShipAddSeqNo',
                    'tReturnInputName'  : 'ohdPOShipAddSeqNo',
                    'tPOWhereCons'     : tPOWhereCons,
                    'tNextFuncName'     : 'JSvPOGetShipAddrData',
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
                $("#odvPOBrowseShipAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxBrowseData('oPOBrowseShipAddressOption');
            }else{
                $("#odvPOBrowseShipAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxShowMsgSessionExpired();
            }
        });

        //Functionality : Behind NextFunc Browse Shippinh Address
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSvPOGetShipAddrData(paInForCon){
            if(paInForCon !== "NULL") {
                var aDataReturn = JSON.parse(paInForCon);
                $("#ospPOShipAddAddV1No").text((aDataReturn[1] != "")      ? aDataReturn[1]    : '-');
                $("#ospPOShipAddV1Soi").text((aDataReturn[2] != "")        ? aDataReturn[2]    : '-');
                $("#ospPOShipAddV1Village").text((aDataReturn[3] != "")    ? aDataReturn[3]    : '-');
                $("#ospPOShipAddV1Road").text((aDataReturn[4] != "")       ? aDataReturn[4]    : '-');
                $("#ospPOShipAddV1SubDist").text((aDataReturn[5] != "")    ? aDataReturn[5]    : '-');
                $("#ospPOShipAddV1DstCode").text((aDataReturn[6] != "")    ? aDataReturn[6]    : '-');
                $("#ospPOShipAddV1PvnCode").text((aDataReturn[7] != "")    ? aDataReturn[7]    : '-');
                $("#ospPOShipAddV1PostCode").text((aDataReturn[8] != "")   ? aDataReturn[8]    : '-');
                $("#ospPOShipAddV2Desc1").text((aDataReturn[9] != "")      ? aDataReturn[9]    : '-');
                $("#ospPOShipAddV2Desc2").text((aDataReturn[10] != "")     ? aDataReturn[10]   : '-');
            }else{
                $("#ospPOShipAddAddV1No").text("-");
                $("#ospPOShipAddV1Soi").text("-");
                $("#ospPOShipAddV1Village").text("-");
                $("#ospPOShipAddV1Road").text("-");
                $("#ospPOShipAddV1SubDist").text("-");
                $("#ospPOShipAddV1DstCode").text("-");
                $("#ospPOShipAddV1PvnCode").text("-");
                $("#ospPOShipAddV1PostCode").text("-");
                $("#ospPOShipAddV2Desc1").text("-");
                $("#ospPOShipAddV2Desc2").text("-");
            }
            $("#odvPOBrowseShipAdd").modal("show");
        }

        //Functionality : Add Shiping Add To Input
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSnPOShipAddData(){
            var tPOShipAddSeqNoSelect   = $('#ohdPOShipAddSeqNo').val();
            $('#ohdPOFrmShipAdd').val(tPOShipAddSeqNoSelect);
            $("#odvPOBrowseShipAdd").modal("hide");
            $('.modal-backdrop').remove();
        }

    // ===========================================================================================================

    /** ============================================ Set Tex Address ============================================= */
        $('#obtPOFrmBrowseTaxAdd').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('#odvPOBrowseTexAdd').modal({backdrop: 'static', keyboard: false})  
                $('#odvPOBrowseTexAdd').modal('show');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Option Browse Shipping Address
        var oPOBrowseTexAddress     = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tPOWhereCons        = poDataFnc.tPOWhereCons;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var oOptionReturn       = {
                Title   : ['document/purchaseorder/purchaseorder','tPOTexAddress'],
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
                    Condition : [tPOWhereCons]
                },
                GrideView:{
                    ColumnPathLang	: 'document/purchaseorder/purchaseorder',
                    ColumnKeyLang	: [
                        'tPOTexADDBch',
                        'tPOTexADDSeq',
                        'tPOTexADDV1No',
                        'tPOTexADDV1Soi',
                        'tPOTexADDV1Village',
                        'tPOTexADDV1Road',
                        'tPOTexADDV1SubDist',
                        'tPOTexADDV1DstCode',
                        'tPOTexADDV1PvnCode',
                        'tPOTexADDV1PostCode'
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
        $('#odvPOBrowseTexAdd #oliPOEditTexAddress').unbind().click(function(){
            // var nStaSession = JCNxFuncChkSessionExpired();
            var nStaSession = 1;
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tPOWhereCons    = "AND FTAddGrpType = 1 AND FTAddRefCode = '"+$("#oetPOFrmBchCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                // Call Option Modal
                window.oPOBrowseTexAddressOption    = undefined;
                oPOBrowseTexAddressOption           = oPOBrowseTexAddress({
                    'tReturnInputCode'  : 'ohdPOTexAddSeqNo',
                    'tReturnInputName'  : 'ohdPOTexAddSeqNo',
                    'tPOWhereCons'     : tPOWhereCons,
                    'tNextFuncName'     : 'JSvPOGetTexAddrData',
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
                $("#odvPOBrowseTexAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxBrowseData('oPOBrowseTexAddressOption');
            }else{
                $("#odvPOBrowseTexAdd").modal("hide");
                $('.modal-backdrop').remove();
                JCNxShowMsgSessionExpired();
            }
        });
        
        //Functionality : Behind NextFunc Browse Shippinh Address
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSvPOGetTexAddrData(paInForCon){
            if(paInForCon !== "NULL") {
                var aDataReturn = JSON.parse(paInForCon);
                $("#ospPOTexAddAddV1No").text((aDataReturn[1] != "")      ? aDataReturn[1]    : '-');
                $("#ospPOTexAddV1Soi").text((aDataReturn[2] != "")        ? aDataReturn[2]    : '-');
                $("#ospPOTexAddV1Village").text((aDataReturn[3] != "")    ? aDataReturn[3]    : '-');
                $("#ospPOTexAddV1Road").text((aDataReturn[4] != "")       ? aDataReturn[4]    : '-');
                $("#ospPOTexAddV1SubDist").text((aDataReturn[5] != "")    ? aDataReturn[5]    : '-');
                $("#ospPOTexAddV1DstCode").text((aDataReturn[6] != "")    ? aDataReturn[6]    : '-');
                $("#ospPOTexAddV1PvnCode").text((aDataReturn[7] != "")    ? aDataReturn[7]    : '-');
                $("#ospPOTexAddV1PostCode").text((aDataReturn[8] != "")   ? aDataReturn[8]    : '-');
                $("#ospPOTexAddV2Desc1").text((aDataReturn[9] != "")      ? aDataReturn[9]    : '-');
                $("#ospPOTexAddV2Desc2").text((aDataReturn[10] != "")     ? aDataReturn[10]   : '-');
            }else{
                $("#ospPOTexAddAddV1No").text("-");
                $("#ospPOTexAddV1Soi").text("-");
                $("#ospPOTexAddV1Village").text("-");
                $("#ospPOTexAddV1Road").text("-");
                $("#ospPOTexAddV1SubDist").text("-");
                $("#ospPOTexAddV1DstCode").text("-");
                $("#ospPOTexAddV1PvnCode").text("-");
                $("#ospPOTexAddV1PostCode").text("-");
                $("#ospPOTexAddV2Desc1").text("-");
                $("#ospPOTexAddV2Desc2").text("-");
            }
            $("#odvPOBrowseTexAdd").modal("show");
        }

        //Functionality : Add Shiping Add To Input
        //Parameters : Event Next Func Modal
        //Creator : 04/07/2019 Wasin(Yoshi)
        //Return : Set Value And Controll Input
        //Return Type : -
        function JSnPOTexAddData(){
            var tPOTexAddSeqNoSelect    = $('#ohdPOTexAddSeqNo').val();
            $('#ohdPOFrmTaxAdd').val(tPOTexAddSeqNoSelect);
            $("#odvPOBrowseTexAdd").modal("hide");
            $('.modal-backdrop').remove();
        }
    // ===========================================================================================================
    

    // Functionality: Check Status Document Process EQ And Call Back MQ
    // Parameters: Event Document Ready Load Page
    // Creator: 11/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: -
    // ReturnType: -
    function JSxPOChkStaDocCallModalMQ(){
        var nPOLangEdits        = nLangEdits;
        var tPOFrmBchCode       = $("#oetPOFrmBchCode").val();
        var tPOUsrApv           = $("#ohdPOApvCodeUsrLogin").val();
        var tPODocNo            = $("#oetPODocNo").val();
        var tPOPrefix           = "RESPPI";
        var tPOStaApv           = $("#ohdPOStaApv").val();
        var tPOStaPrcStk        = $("#ohdPOStaPrcStk").val();
        var tPOStaDelMQ         = $("#ohdPOStaDelMQ").val();
        var tPOQName            = tPOPrefix + "_" + tPODocNo + "_" + tPOUsrApv;
        var tPOTableName        = "TARTPoHD";
        var tPOFieldDocNo       = "FTXphDocNo";
        var tPOFieldStaApv      = "FTXphStaPrcStk";
        var tPOFieldStaDelMQ    = "FTXphStaDelMQ";

        // MQ Message Config
        var poDocConfig = {
            tLangCode     : nPOLangEdits,
            tUsrBchCode   : tPOFrmBchCode,
            tUsrApv       : tPOUsrApv,
            tDocNo        : tPODocNo,
            tPrefix       : tPOPrefix,
            tStaDelMQ     : tPOStaDelMQ,
            tStaApv       : tPOStaApv,
            tQName        : tPOQName
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
            ptDocTableName      : tPOTableName,
            ptDocFieldDocNo     : tPOFieldDocNo,
            ptDocFieldStaApv    : tPOFieldStaApv,
            ptDocFieldStaDelMQ  : tPOFieldStaDelMQ,
            ptDocStaDelMQ       : tPOStaDelMQ,
            ptDocNo             : tPODocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: "JSvPOCallPageEditDoc",
            tCallPageList: "JSvPOCallPageList"
        };
        
        // Check Show Progress %
        if(tPODocNo != '' && (tPOStaApv == 2 || tPOStaPrcStk == 2)){
            FSxCMNRabbitMQMessage(poDocConfig,poMqConfig,poUpdateStaDelQnameParams,poCallback);
        }

        // Check Delete MQ SubScrib
        if(tPOStaApv == 1 && tPOStaPrcStk == 1 && tPOStaDelMQ == ""){
            var poDelQnameParams    = {
                ptPrefixQueueName   : tPOPrefix,
                ptBchCode           : tPOFrmBchCode,
                ptDocNo             : tPODocNo,
                ptUsrCode           : tPOUsrApv
            };
            FSxCMNRabbitMQDeleteQname(poDelQnameParams);
            FSxCMNRabbitMQUpdateStaDeleteQname(poUpdateStaDelQnameParams);
        }
    }
        
    /**
     * Functionality : Print Document
     * Parameters : -
     * Creator : 28/08/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */    
    function JSxPOPrintDoc(){
        var aInfor = [
            {"Lang"         : '<?php echo FCNaHGetLangEdit(); ?>'}, // Lang ID
            {"ComCode"      : '<?php echo FCNtGetCompanyCode(); ?>'}, // Company Code
            {"BranchCode"   : '<?php echo FCNtGetAddressBranch($tPOBchCode); ?>'}, // สาขาที่ออกเอกสาร
            {"DocCode"      : '<?php echo $tPODocNo; ?>'}, // เลขที่เอกสาร
            {"DocBchCode"   : '<?=$tPOBchCode;?>'}
        ];
        var tGrandText = $('#odvDataTextBath').text();
        window.open("<?php echo base_url(); ?>formreport/Frm_SQL_SMBillPO?infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText, '_blank');
    }        



function JSxPOClearDTTmp(ptDataDisTmp){
    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "docPOClearDataDocTemp",
                        data: {
                            'ptPODocNo' : $("#oetPODocNo").val()
                        },
                        cache: false,
                        success: function (oResult){
                            var aDataReturn     = JSON.parse(oResult);
                            var tMessageError   = aDataReturn['tStaMessg'];
                            switch(aDataReturn['nStaReturn']){
                                case 1:
                                    if(ptDataDisTmp!='' && ptDataDisTmp!=null && ptDataDisTmp!=' '){
                                           
                                            JSxPOPocessAddDisTmpCst(ptDataDisTmp);
                                        }else{
                                     JSvPOLoadPdtDataTableHtml();
                                    JCNxCloseLoading();
                                        }
                           
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
}

    $('#obtPOBrowseBCH').click(function(){ 
        // JCNxBrowseData('oBrowse_BCH'); 

        var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oPOBrowseBranchOption  = undefined;
                oPOBrowseBranchOption         = oBranchOption({
                    'tReturnInputCode'  : 'oetPOFrmBchCode',
                    'tReturnInputName'  : 'oetPOFrmBchName',
                    'tNextFuncName'     : 'JSxSetDefauleWahouse',
                    'aArgReturn'        : ['FTBchCode','FTBchName','FTWahCode','FTWahName'],
                });
                JCNxBrowseData('oPOBrowseBranchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }

    });


      // ========================================== Brows Option Conditon ===========================================
        // ตัวแปร Option Browse Modal สาขา
        var oBranchOption = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;

            tUsrLevel = "<?=$this->session->userdata('tSesUsrLevel')?>";
            tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
            tSQLWhere = "";
            if(tUsrLevel != "HQ"){
                tSQLWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
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
                    Condition : [tSQLWhere]
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
                CallBack: {
                    ReturnType  : 'S',
                    Value       : [tInputReturnCode, "TCNMBranch.FTBchCode"],
                    Text        : [tInputReturnName, "TCNMBranch_L.FTBchName"]
                },
                NextFunc: {
                    FuncName    : tNextFuncName,
                    ArgReturn   : aArgReturn
                },
                RouteAddNew: 'branch',
                BrowseLev: 1
            };
            return oOptionReturn;
        }



    
    function JSxSetDefauleWahouse(ptData){
        if(ptData == '' || ptData == 'NULL'){
            $('#oetPOFrmWahCode').val('');
            $('#oetPOFrmWahName').val('');
        }else{
            var tResult = JSON.parse(ptData);
            //เช็คค่าเก่ากับค่าใหม่ ก่อนจะเเจ้งเตือนให้ล้างค่า
            if($('#oetPOFrmBchCode').data('bchcodeold') == tResult[0]){
               
            }else{
                nRowCount = $('#otbPODocPdtAdvTableList >tbody >tr').length;
                if(nRowCount > 1){
                    if($('#otbPODocPdtAdvTableList >tbody >tr > td').hasClass('xWPITextNotfoundDataPdtTable') == true){
                        $('#oetPOFrmBchCode').val(tResult[0]);
                        $('#oetPOFrmBchName').val(tResult[1]);
                    }else{
                        //แจ้งเตือนว่ามีการเปลี่ยนค่า
                        $('#odvPOModalChangeBCH').modal('show');
                        $('#obtChangeBCH').on("click",function() {
                            JCNxOpenLoading();
                            $.ajax({
                                type: "POST",
                                url: "docPOClearDataDocTemp",
                                data: {
                                    'ptPODocNo' : $("#oetPODocNo").val()
                                },
                                cache: false,
                                Timeout: 0,
                                success: function (oResult){
                                    JSvPOLoadPdtDataTableHtml();
                                    $('#oetPOFrmBchCode').val(tResult[0]);
                                    $('#oetPOFrmBchName').val(tResult[1]);
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                                }
                            });
                        });
                    }
                }
            }

            $('#oetPOFrmWahCode').val(tResult[2]);
            $('#oetPOFrmWahName').val(tResult[3]);
        }
    }



        /*===== Begin Import Excel =========================================================*/
        function JSxOpenImportForm(){
            if($('#oetPOFrmSplCode').val()!=""){
                var tNameModule = 'purchaseorder';
                var tTypeModule = 'document';
                var tAfterRoute = 'JSxImportExcelCallback'; // call func
                var tFlagClearTmp = '1' // null = ไม่สนใจ 1 = ลบหมดเเล้วเพิ่มใหม่ 2 = เพิ่มต่อเนื่อง
                var tDocumentNo = $("#oetPODocNo").val();
                var tPOFrmBchCode = $("#oetPOFrmBchCode").val();
                var nSplVatRate = $('#ohdPOFrmSplVatRate').val();
                var tSplVatCode = $('#ohdPOFrmSplVatCode').val();

                var aPackdata = {
                'tNameModule' : tNameModule,
                'tTypeModule' : tTypeModule,
                'tAfterRoute' : tAfterRoute,
                'tFlagClearTmp' : tFlagClearTmp,
                'tDocumentNo' : tDocumentNo,
                'tFrmBchCode' : tPOFrmBchCode,
                'nSplVatRate' : nSplVatRate,
                'tSplVatCode' : tSplVatCode,
                };

                JSxImportPopUp(aPackdata);
                }else{
                    $('#odvPOModalPleseselectSPL').modal('show');
                }
        }

        function JSxImportExcelCallback(aDataResult){
            JCNxOpenLoading();
            JSvPOCallEndOfBill();
            $('#ohdPOStaImport').val(1);
        }
        /*===== End Import Excel ===========================================================*/

        //ConfirmImport SaveTo DT
        $('#obtPOImportConfirm').unbind().click(function(){
            JCNxOpenLoading();
                $('#ohdPOSubmitWithImp').val(1);
                JSxPOSetStatusClickSubmit(1);
                $('#obtPOSubmitDocument').click();

        });
</script>