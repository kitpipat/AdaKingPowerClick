<script type= text/javascript>
var nLangEdits              = '<?php echo $this->session->userdata("tLangEdit");?>';
var tUsrApv                 = '<?php echo $this->session->userdata("tSesUsername");?>';
var tUserBchCode            = '<?php echo $tUserBchCode;?>';
var tUserShpCode            = '<?php echo $tUserShpCode?>';
var tTXOMsgResaveDocument   = '<?php echo language('document/transferout/transferout','tTXOMsgResaveDocument') ?>';
var tTXOMsgSltShpViaAndSave = '<?php echo language('document/transferout/transferout','tTXOMsgSltShpViaAndSave') ?>';

var tTXOUserType    = "";
if(tUserBchCode === "" && tUserShpCode === ""){
    tTXOUserType   = "HQ";
}else{
    if(tUserBchCode !== "" && $tUserShpCode === ""){
        tTXOUserType   = "BCH";
    }else if(tUserBchCode !== "" && tUserShpCode !== ""){
        tTXOUserType   = "SHP";
    }
}

$(document).ready(function () {
    $('.selectpicker').selectpicker('refresh');

    $('.xCNDatePicker').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        enableOnReadonly: false,
        startDate :'1900-01-01',
        disableTouchKeyboard : true,
        autoclose: true
    });

    $('.xCNTimePicker').datetimepicker({
        format: 'LT'
    });

    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});

    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
    
    $(".xWConditionSearchPdt.disabled").attr("disabled","disabled");


    if($("#oetTXOBchCode").val() == ""){
        $("#obtTXOBrowseShipAdd").attr("disabled","disabled");
    }
    
    /** =================== Event Search Function ===================== */
        $('#oliTXOMngPdtScan').unbind().click(function(){
            //Hide
            $('#oetTXOSearchPdtHTML').hide();
            $('#obtTXOMngPdtIconSearch').hide();
            //Show
            $('#oetTXOScanPdtHTML').show();
            $('#obtTXOMngPdtIconScan').show();
        });
        $('#oliTXOMngPdtSearch').unbind().click(function(){
            //Hide
            $('#oetTXOScanPdtHTML').hide();
            $('#obtTXOMngPdtIconScan').hide();
            //Show
            $('#oetTXOSearchPdtHTML').show();
            $('#obtTXOMngPdtIconSearch').show();
        });
    /** =============================================================== */

    /** =================== Event Date Function  ====================== */
        $('#obtTXODocDate').unbind().click(function(){
            $('#oetTXODocDate').datepicker('show');
        });

        $('#obtTXODocTime').unbind().click(function(){
            $('#oetTXODocTime').datetimepicker('show');
        });

        $('#obtTXORefIntDate').unbind().click(function(){
            $('#oetTXORefIntDate').datepicker('show');
        });

        $('#obtTXORefExtDate').unbind().click(function(){
            $('#oetTXORefExtDate').datepicker('show');
        });

        $('#obtTXOTnfDate').unbind().click(function(){
            $('#oetTXOTnfDate').datepicker('show');
        });
    /** =============================================================== */
        
    /** ===================== Set Date Default ========================  */
        var dCurrentDate    = new Date();
        var tAmOrPm         = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
        var tCurrentTime    = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

        if($('#oetTXODocDate').val() == ''){
            $('#oetTXODocDate').datepicker("setDate",dCurrentDate); 
        }

        if($('#oetTXOTnfDate').val() == ''){
            $('#oetTXOTnfDate').datepicker("setDate",dCurrentDate);
        }

        if($('#oetTXODocTime').val()==''){
            $('#oetTXODocTime').val(tCurrentTime);
        }
    /** =============================================================== */

    /** ================== Check Box Auto GenCode ===================== */
        $('#ocbTXOStaAutoGenCode').on('change', function (e) {
            if($('#ocbTXOStaAutoGenCode').is(':checked')){
                $("#oetTXODocNo").val('');
                $("#oetTXODocNo").attr("readonly", true);
                $('#oetTXODocNo').closest(".form-group").css("cursor","not-allowed");
                $('#oetTXODocNo').css("pointer-events","none");
                $("#oetTXODocNo").attr("onfocus", "this.blur()");
                $('#ofmTXOFormAdd').removeClass('has-error');
                $('#ofmTXOFormAdd .form-group').closest('.form-group').removeClass("has-error");
                $('#ofmTXOFormAdd em').remove();
            }else{
                $('#oetTXODocNo').closest(".form-group").css("cursor","");
                $('#oetTXODocNo').css("pointer-events","");
                $('#oetTXODocNo').attr('readonly',false);
                $("#oetTXODocNo").removeAttr("onfocus");
            }
        });

    /** =============================================================== */

    $('#ostTXOVATInOrEx').on('change', function (e) {
        // คำนวนท้ายบิลใหม่
        JSvTXOLoadPdtDataTableHtml();
    });

    JSxTXOChkStaDocCallModalMQ();
});

var tTXOOldMchCkChange      = "";
var tTXOOldShpFromCkChange  = "";
var tTXOOldShpToCkChange    = "";

/** ======================================== Option Browse Modal ======================================== */
    // // Option Modal สาขา
    // var oTXOBrowseBranch    = function(poDataFnc){
    //     var tInputReturnCode    = poDataFnc.tReturnInputCode;
    //     var tInputReturnName    = poDataFnc.tReturnInputName;
    //     var tNextFunchName      = poDataFnc.tNextFuncName;
    //     var aArgReturn          = poDataFnc.aArgReturn;
    //     var oOptionReturn       = {
    //         Title : ['company/branch/branch','tBCHTitle'],
    //         Table : {Master:'TCNMBranch',PK:'FTBchCode'},
    //         Join :{
    //             Table: ['TCNMBranch_L'],
    //             On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
    //         },
    //         GrideView : {
    //             ColumnPathLang  : 'company/branch/branch',
    //             ColumnKeyLang	: ['tBCHCode','tBCHName'],
    //             ColumnsSize     : ['15%','75%'],
    //             WidthModal      : 50,
    //             DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
    //             DataColumnsFormat : ['',''],
    //             DisabledColumns	: [],
    //             Perpage			: 5,
    //             OrderBy			: ['TCNMBranch_L.FTBchName'],
    //             SourceOrder		: "ASC"
    //         },
    //         CallBack:{
    //             ReturnType	: 'S',
    //             Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
    //             Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
    //         },
    //         NextFunc:{
    //             FuncName    : tNextFunchName,
    //             ArgReturn   : aArgReturn
    //         },
    //         RouteAddNew : 'branch',
    //         BrowseLev   : nStaTXOBrowseType
    //     };
    //     return oOptionReturn;
    // }

    // Option Modal กลุ่มร้านค้า
    var oTXOBrowseMerChant  = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tTXOBchCode         = poDataFnc.tTXOBchCode;
        var tNextFunchName      = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;
        var oOptionReturn       = {
            Title : ['company/warehouse/warehouse','tWAHBwsMchTitle'],
            Table : {Master:'TCNMMerchant',PK:'FTMerCode'},
            Join : {
                Table : ['TCNMMerchant_L'],
                On : ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits]
            },
            Where : {
                Condition : ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '"+tTXOBchCode+"') != 0"]
            },
            GrideView : {
                ColumnPathLang	: 'company/warehouse/warehouse',
                ColumnKeyLang	: ['tWAHBwsMchCode','tWAHBwsMchNme'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
                DataColumnsFormat : ['',''],
                Perpage			: 5,
                OrderBy			: ['TCNMMerchant.FTMerCode'],
                SourceOrder		: "ASC"
            },
            CallBack : {
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMMerchant.FTMerCode"],
                Text		: [tInputReturnName,"TCNMMerchant_L.FTMerName"],
            },
            NextFunc : {
                FuncName    : tNextFunchName,
                ArgReturn   : aArgReturn
            },
            BrowseLev : nStaTXOBrowseType
        };
        return oOptionReturn;
    }

    // Option Modal ร้านค้า
    var oTXOBrowseShop      = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tTXOWhereCons       = poDataFnc.tTXOWhereCons;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;
        var oOptionReturn       = {
            Title : ['company/shop/shop','tSHPTitle'],
            Table : {Master:'TCNMShop',PK:'FTShpCode'},
            Join : {
                Table:	['TCNMShop_L','TCNMWaHouse_L'],
                On:['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                    'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= '+nLangEdits
                ]
            },
            Where : {
                Condition : [tTXOWhereCons]
            },
            GrideView:{
                ColumnPathLang	    : 'company/branch/branch',
                ColumnKeyLang	    : ['tBCHCode','tBCHName'],
                ColumnsSize         : ['25%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName','TCNMShop.FTWahCode','TCNMWaHouse_L.FTWahName','TCNMShop.FTShpType','TCNMShop.FTBchCode'],
                DataColumnsFormat   : ['','','','','',''],
                DisabledColumns	    :[2,3,4,5],
                Perpage			    : 5,
                OrderBy			    : ['TCNMShop_L.FTShpName'],
                SourceOrder		    : "ASC"
            },
            CallBack : {
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMShop.FTShpCode"],
                Text		: [tInputReturnName,"TCNMShop_L.FTShpName"],
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            BrowseLev : nStaTXOBrowseType
        };
        return oOptionReturn;
    }

    // Option Modal เครื่องจุดขาย
    var oTXOBrowsePos       = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tTXOWhereCons       = poDataFnc.tTXOWhereCons;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;
        var oOptionReturn       = {
            Title : ['pos/posshop/posshop','tPshTBPosCode'],
            Table : {Master:'TVDMPosShop',PK:'FTPosCode'},
            Join : {
                Table :	['TCNMPos','TCNMPosLastNo','TCNMWaHouse','TCNMWaHouse_L'],
                On : ['TVDMPosShop.FTPosCode = TCNMPos.FTPosCode',
                    'TVDMPosShop.FTPosCode = TCNMPosLastNo.FTPosCode',
                    'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTWahStaType = 6',
                    'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= '+nLangEdits
                ]
            },
            Where : {
                Condition : [tTXOWhereCons]
            },
            GrideView:{
                ColumnPathLang	: 'pos/posshop/posshop',
                ColumnKeyLang	: ['tPshBRWShopTBCode','tPshBRWPosTBName'],
                ColumnsSize     : ['25%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TVDMPosShop.FTPosCode','TCNMPosLastNo.FTPosComName','TVDMPosShop.FTShpCode','TVDMPosShop.FTBchCode','TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat : ['','','','','',''],
                DisabledColumns	:[2,3,4,5],
                Perpage			: 5,
                OrderBy			: ['TVDMPosShop.FTPosCode'],
                SourceOrder		: "ASC"
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TVDMPosShop.FTPosCode"],
                Text		: [tInputReturnName,"TCNMPosLastNo.FTPosComName"],
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            BrowseLev : nStaTXOBrowseType
        };
        return oOptionReturn;
    }

    // Option Modal คลังสินค้า
    var oTXOBrowseWah       = function (poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;
        var tTXOWhereCons       = poDataFnc.tTXOWhereCons;
        var aTXOJoinTable       = poDataFnc.aTXOJoinTable;
        var aTXOJoinOnTable     = poDataFnc.aTXOJoinOnTable;

        var oOptionReturn       = {
            Title : ['company/warehouse/warehouse','tWAHTitle'],
            Table : {Master:'TCNMWaHouse',PK:'FTWahCode'},
            Join :{
                Table   : aTXOJoinTable,
                On      : aTXOJoinOnTable
            },
            Where : {
                Condition : [tTXOWhereCons]
            },
            GrideView:{
                ColumnPathLang	    : 'company/warehouse/warehouse',
                ColumnKeyLang	    : ['tWahCode','tWahName'],
                DataColumns		    : ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat   : ['',''],
                ColumnsSize         : ['15%','75%'],
                Perpage			    : 5,
                WidthModal          : 50,
                OrderBy			    : ['TCNMWaHouse_L.FTWahName'],
                SourceOrder		    : "ASC"
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMWaHouse.FTWahCode"],
                Text		: [tInputReturnName,"TCNMWaHouse_L.FTWahName"],
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            BrowseLev : nStaTXOBrowseType
        };
        return oOptionReturn;
    }
    
    // Option Modal Shp Via การขนส่ง
    var oTXOBrowseShpVia    = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var oOptionReturn       = {
            Title: ['document/transferout/transferout', 'tTXOShipViaModalTitle'],
            Table: {Master: 'TCNMShipVia',PK: 'FTViaCode'},
            Join: {
				Table: ['TCNMShipVia_L'],
				On: ["TCNMShipVia.FTViaCode = TCNMShipVia_L.FTViaCode AND TCNMShipVia_L.FNLngID = " + nLangEdits]
			},
            GrideView: {
				ColumnPathLang: 'document/transferout/transferout',
				ColumnKeyLang: ['tTXOShipViaCode', 'tTXOShipViaName'],
				DataColumns: ['TCNMShipVia.FTViaCode', 'TCNMShipVia_L.FTViaName'],
				DataColumnsFormat: ['', ''],
				ColumnsSize: [''],
				Perpage: 10,
				WidthModal: 50,
				OrderBy: ['TCNMShipVia.FTViaCode'],
				SourceOrder: "ASC"
            },
            CallBack: {
				ReturnType: 'S',
				Value: [tInputReturnCode,"TCNMShipVia.FTViaCode"],
				Text: [tInputReturnName, "TCNMShipVia_L.FTViaName"],
			},
            BrowseLev : nStaTXOBrowseType
        };
        return oOptionReturn;
    }



/** ===================================================================================================== */

/** ========================================= Event Browse Modal ======================================== */
    // // Event Browse สาขา
    // $('#obtTXOBrowseBch').unbind().click(function(){
    //     var nStaSession = JCNxFuncChkSessionExpired();
    //     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
    //         window.oTXOBrowseBranchOption   = undefined;
    //         oTXOBrowseBranchOption  = oTXOBrowseBranch({
    //             'tReturnInputCode'  : 'oetTXOBchCode',
    //             'tReturnInputName'  : 'oetTXOBchName',
    //             'tNextFuncName'     : 'JSxTXOSetSeqConditionBch',
    //             'aArgReturn'        : ['FTBchCode','FTBchName']
    //         });
    //         JCNxBrowseData('oTXOBrowseBranchOption');
    //     }else{
    //         JCNxShowMsgSessionExpired();
    //     }
    // });

    // Event Browse กลุ่มร้านค้า/ผู้ประกอบการ
    $('#obtTXOBrowseMch').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            tTXOOldMchCkChange  = $('#oetTXOMchCode').val();
            var tTXOBchCode     = $('#oetTXOBchCode').val();
            window.oTXOBrowseMerChantOption = undefined;
            oTXOBrowseMerChantOption    = oTXOBrowseMerChant({
                'tReturnInputCode'  : 'oetTXOMchCode',
                'tReturnInputName'  : 'oetTXOMchName',
                'tTXOBchCode'       : tTXOBchCode,
                'tNextFuncName'     : 'JSxTXOSetSeqConditionMerChant',
                'aArgReturn'        : ['FTMerCode','FTMerName'],
            });
            JCNxBrowseData('oTXOBrowseMerChantOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse ร้านค้าต้นทาง
    $('#obtTXOBrowseShpFrom').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            // Set Condition Ware Modal
            tTXOOldShpFromCkChange  = $("#obtTXOBrowseShpFrom").val();
            var tTXOWhereCons   = "AND TCNMShop.FTBchCode = '"+$("#oetTXOBchCode").val()+"' AND TCNMShop.FTMerCode = '"+$("#oetTXOMchCode").val()+"'";
            if($("#oetTXOShpCodeTo").val() != "" && $("#oetTXOWahCodeTo").val() != ""){
                if($($($($("#obtTXOBrowsePosTo").parent()).parent()).parent()).hasClass("xCNHide")){
                    if($($($($("#obtTXOBrowsePosFrom").parent()).parent()).parent()).hasClass("xCNHide")){
                        if($("#oetTXOWahCodeFrom").val()!=""){
                            tTXOWhereCons   += " AND TCNMShop.FTShpCode != '"+$("#oetTXOShpCodeTo").val()+"'";
                        }
                    }
                }
            }

            // Call Option Modal
            window.oTXOBrowseShopFrmOption  = undefined;
            oTXOBrowseShopFrmOption = oTXOBrowseShop({
                'tReturnInputCode'  : 'oetTXOShpCodeFrom',
                'tReturnInputName'  : 'oetTXOShpNameFrom',
                'tTXOWhereCons'     : tTXOWhereCons,
                'tNextFuncName'     : 'JSxTXOSetSeqConditionShopFrom',
                'aArgReturn'        : ['FTBchCode','FTShpCode','FTShpType','FTWahCode','FTWahName']
            });
            JCNxBrowseData('oTXOBrowseShopFrmOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse ร้านค้าปลายทาง
    $('#obtTXOBrowseShpTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tTXOWhereCons   = "AND TCNMShop.FTBchCode = '"+$("#oetTXOBchCode").val()+"' AND TCNMShop.FTMerCode = '"+$("#oetTXOMchCode").val()+"'";
            if($("#oetTXOShpCodeFrom").val()!="" && $("#oetTXOWahCodeFrom").val()!=""){
                if($($($($("#obtTXOBrowsePosFrom").parent()).parent()).parent()).hasClass("xCNHide")){
                    if($($($($("#obtTXOBrowsePosTo").parent()).parent()).parent()).hasClass("xCNHide")){
                        if($("#oetTXOWahCodeTo").val()!=""){
                            tTXOWhereCons   += " AND TCNMShop.FTShpCode != '"+$("#oetTXOShpCodeFrom").val()+"'";
                        }
                    }
                }
            }

            // Call Option Modal
            window.oTXOBrowseShopToOption   = undefined; 
            oTXOBrowseShopToOption  = oTXOBrowseShop({
                'tReturnInputCode'  : 'oetTXOShpCodeTo',
                'tReturnInputName'  : 'oetTXOShpNameTo',
                'tTXOWhereCons'     : tTXOWhereCons,
                'tNextFuncName'     : 'JSxTXOSetSeqConditionShopTo',
                'aArgReturn'        : ['FTBchCode','FTShpCode','FTShpType','FTWahCode','FTWahName']
            });
            JCNxBrowseData('oTXOBrowseShopToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse เครื่องจุดขายเริ่มต้น
    $('#obtTXOBrowsePosFrom').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tTXOWhereCons   = "AND TVDMPosShop.FTShpCode = '"+$("#oetTXOShpCodeFrom").val()+"' AND TVDMPosShop.FTBchCode = '"+$("#oetTXOBchCode").val()+"'";
            if($("#oetTXOShpCodeTo").val() != ""){
                if($("#oetTXOShpCodeFrom").val() == $("#oetTXOShpCodeTo").val()){
                    if($("#oetTXOPosCodeTo").val() != ""){
                        tTXOWhereCons   += " AND TVDMPosShop.FTPosCode != '"+$("#oetTXOPosCodeTo").val()+"'";
                    }
                }
            }

            // Call Option Modal
            window.oTXOBrowsePosFrmOption   = undefined;
            oTXOBrowsePosFrmOption  = oTXOBrowsePos({
                'tReturnInputCode'  : 'oetTXOPosCodeFrom',
                'tReturnInputName'  : 'oetTXOPosNameFrom',
                'tTXOWhereCons'     : tTXOWhereCons,
                'tNextFuncName'     : 'JSxTXOSetSeqConditionPosFrom',
                'aArgReturn'        : ['FTBchCode','FTShpCode','FTPosCode','FTWahCode','FTWahName']
            });
            JCNxBrowseData('oTXOBrowsePosFrmOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse เครื่องจุดขายปลายทาง
    $('#obtTXOBrowsePosTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tTXOWhereCons = "AND TVDMPosShop.FTShpCode = '"+$("#oetTXOShpCodeTo").val()+"' AND TVDMPosShop.FTBchCode = '"+$("#oetTXOBchCode").val()+"'";
            if($("#oetTXOShpCodeFrom").val() != ""){
                if($("#oetTXOShpCodeTo").val() == $("#oetTXOShpCodeFrom").val()){
                    if($("#oetTXOPosCodeFrom").val() != ""){
                        tTXOWhereCons += " AND TVDMPosShop.FTPosCode NOT IN ('"+$("#oetTXOPosCodeFrom").val()+"')";
                    }
                }
            }

            // Call Option Modal
            window.oTXOBrowsePosToOption    = undefined;
            oTXOBrowsePosToOption   = oTXOBrowsePos({
                'tReturnInputCode'  : 'oetTXOPosCodeTo',
                'tReturnInputName'  : 'oetTXOPosNameTo',
                'tTXOWhereCons'     : tTXOWhereCons,
                'tNextFuncName'     : 'JSxTXOSetSeqConditionPosTo',
                'aArgReturn'        : ['FTBchCode','FTShpCode','FTPosCode','FTWahCode','FTWahName']
            });
            JCNxBrowseData('oTXOBrowsePosToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse คลังสินค้าต้นทาง
    $('#obtTXOBrowseWahFrom').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            if($("#oetTXOBchCode").val() != "" && $("#oetTXOShpCodeFrom").val() == "" && $("#oetTXOPosCodeFrom").val() == ""){
                // เช็คในกรณีเลือกเฉพาะคลังสาขา
                var aTXOJoinTable   = ['TCNMWaHouse_L'];
                var aTXOJoinOnTable = ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits,]
                var tTXOWhereCons   = "AND TCNMWaHouse.FTWahStaType IN (1,2)";
                if($("#oetTXOWahCodeTo").val() != ""){
                    tTXOWhereCons   += " AND TCNMWaHouse.FTWahCode NOT IN ('"+$("#oetTXOWahCodeTo").val()+"')";
                }
            }else if($("#oetTXOBchCode").val() != "" && $("#oetTXOShpCodeFrom").val() != "" && $("#oetTXOPosCodeFrom").val() == ""){
                // เช็คในกรณีเลิอกสาขากลับร้านค้า โดนดึงมาเฉพาะคลังของร้านค้า
                var aTXOJoinTable   = ['TCNMWaHouse_L','TCNMShop'];
                var aTXOJoinOnTable = [
                    "TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID = "+nLangEdits,
                    "TCNMWaHouse.FTWahCode = TCNMShop.FTWahCode AND TCNMShop.FTBchCode = '"+$("#oetTXOBchCode").val()+"' AND TCNMShop.FTShpCode = '"+$("#oetTXOShpCodeFrom").val()+"'"
                ];
                var tTXOWhereCons = "AND (TCNMShop.FTBchCode != '' AND TCNMShop.FTShpCode != '') AND (TCNMShop.FTBchCode IS NOT NULL AND TCNMShop.FTShpCode IS NOT NULL)";
            }else{}

            // Call Option Modal
            window.oTXOBrowseWahFrmOption   = undefined;
            oTXOBrowseWahFrmOption  = oTXOBrowseWah({
                'tReturnInputCode'  : 'oetTXOWahCodeFrom',
                'tReturnInputName'  : 'oetTXOWahNameFrom',
                'tTXOWhereCons'     : tTXOWhereCons,
                'tNextFuncName'     : 'JSxTXOSetSeqConditionWahFrom',
                'aTXOJoinTable'     : aTXOJoinTable,
                'aTXOJoinOnTable'   : aTXOJoinOnTable,
                'aArgReturn'        : []
            });
            JCNxBrowseData('oTXOBrowseWahFrmOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse คลังสินค้าปลายทาง
    $('#obtTXOBrowseWahTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            if($("#oetTXOBchCode").val() != "" && $("#oetTXOShpCodeTo").val() == "" && $("#oetTXOPosCodeTo").val() == ""){
                // เช็คในกรณีเลือกเฉพาะคลังสาขา
                var aTXOJoinTable   = ['TCNMWaHouse_L'];
                var aTXOJoinOnTable = ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits];
                var tTXOWhereCons   = "AND TCNMWaHouse.FTWahStaType IN (1,2)";
                if($("#oetTXOWahCodeFrom").val()!=""){
                    tTXOWhereCons   += " AND TCNMWaHouse.FTWahCode NOT IN ('"+$("#oetTXOWahCodeFrom").val()+"')";
                }
            }else if($("#oetTXOBchCode").val() != "" && $("#oetTXOShpCodeTo").val() != "" && $("#oetTXOPosCodeTo").val() == ""){
                // เช็คในกรณีเลิอกสาขากลับร้านค้า โดนดึงมาเฉพาะคลังของร้านค้า
                var aTXOJoinTable   = ['TCNMWaHouse_L','TCNMShop'];
                var aTXOJoinOnTable = [
                    "TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID = "+nLangEdits,
                    "TCNMWaHouse.FTWahCode = TCNMShop.FTWahCode AND TCNMShop.FTBchCode = '"+$("#oetTXOBchCode").val()+"' AND TCNMShop.FTShpCode = '"+$("#oetTXOShpCodeTo").val()+"'"
                ];
                var tTXOWhereCons   = "AND (TCNMShop.FTBchCode != '' AND TCNMShop.FTShpCode != '') AND (TCNMShop.FTBchCode IS NOT NULL AND TCNMShop.FTShpCode IS NOT NULL)";
            }else{}

            // Call Option Modal
            window.oTXOBrowseWahToOption    = undefined;
            oTXOBrowseWahToOption   = oTXOBrowseWah({
                'tReturnInputCode'  : 'oetTXOWahCodeTo',
                'tReturnInputName'  : 'oetTXOWahNameTo',
                'tTXOWhereCons'     : tTXOWhereCons,
                'tNextFuncName'     : 'JSxTXOSetSeqConditionWahTo',
                'aTXOJoinTable'     : aTXOJoinTable,
                'aTXOJoinOnTable'   : aTXOJoinOnTable,
                'aArgReturn'        : []
            });
            JCNxBrowseData('oTXOBrowseWahToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Via Code รหัสการขนส่ง
    $('#obtTXOBrowseShipVia').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oTXOBrowseShpViaOption   = undefined;
            oTXOBrowseShpViaOption  = oTXOBrowseShpVia({
                'tReturnInputCode'  : 'oetTXOViaCode',
                'tReturnInputName'  : 'oetTXOViaName',
            });
            JCNxBrowseData('oTXOBrowseShpViaOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

/** ===================================================================================================== */

/** =================================== Function NextFunc Browse Modal ================================== */

    //Functionality : Function Behind NextFunc สาขา
    //Parameters : Event Next Func Modal
    //Creator : 09/05/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
    // function JSxTXOSetSeqConditionBch(paInForCon) {
    //     // Set Disabled And Clear Input ร้านค้า
    //     $("#oetTXOShpCodeFrom").val("");
    //     $("#oetTXOShpNameFrom").val("");
    //     $($("#obtTXOBrowseShpFrom").parent()).addClass("disabled");
    //     $($("#obtTXOBrowseShpFrom").parent()).attr("disabled", "disabled");
    //     $("#obtTXOBrowseShpFrom").addClass("disabled");
    //     $("#obtTXOBrowseShpFrom").attr("disabled", "disabled");

    //     $("#oetTXOShpCodeTo").val("");
    //     $("#oetTXOShpNameTo").val("");
    //     $($("#obtTXOBrowseShpTo").parent()).addClass("disabled");
    //     $($("#obtTXOBrowseShpTo").parent()).attr("disabled", "disabled");
    //     $("#obtTXOBrowseShpTo").addClass("disabled");
    //     $("#obtTXOBrowseShpTo").attr("disabled", "disabled");

    //     // Set Disabled And Clear Input เครื่องจุดขาย
    //     $("#oetTXOPosCodeFrom").val("");
    //     $("#oetTXOPosNameFrom").val("");
    //     $($($($("#obtTXOBrowsePosFrom").parent()).parent()).parent()).addClass("xCNHide");
    //     $($("#obtTXOBrowsePosFrom").parent()).addClass("disabled");
    //     $($("#obtTXOBrowsePosFrom").parent()).attr("disabled", "disabled");
    //     $("#obtTXOBrowsePosFrom").addClass("disabled");
    //     $("#obtTXOBrowsePosFrom").attr("disabled", "disabled");

    //     $("#oetTXOPosCodeTo").val("");
    //     $("#oetTXOPosNameTo").val("");
    //     $($($($("#obtTXOBrowsePosTo").parent()).parent()).parent()).addClass("xCNHide");
    //     $($("#obtTXOBrowsePosTo").parent()).addClass("disabled");
    //     $($("#obtTXOBrowsePosTo").parent()).attr("disabled", "disabled");
    //     $("#obtTXOBrowsePosTo").addClass("disabled");
    //     $("#obtTXOBrowsePosTo").attr("disabled", "disabled");

    //     // Clear Value Input Other
    //     $("#oetTXOMchCode").val("");
    //     $("#oetTXOMchName").val("");
    //     $("#oetTXOWahCodeFrom").val("");
    //     $("#oetTXOWahNameFrom").val("");
    //     $("#ohdWahCodeEnd").val("");
    //     $("#oetWahNameEnd").val("");

    //     // Cheack BranchCode And Open Input Browse Modal
    //     if($("#oetTXOBchCode").val() != ""){
    //         // Remove Disabled Add Product
    //         $("#obtTXODocBrowsePdt").removeAttr("disabled");
    //         $("#obtTXODocBrowsePdt").removeClass("disabled");
    //         $("#obtTXODocBrowsePdt").css("opacity","");
    //         $("#obtTXODocBrowsePdt").css("cursor","");

    //         // Remove Disabled กลุ่มร้านค้า
    //         $($("#obtTXOBrowseMch").parent()).removeClass("disabled");
    //         $($("#obtTXOBrowseMch").parent()).removeAttr("disabled");
    //         $("#obtTXOBrowseMch").removeClass("disabled");
    //         $("#obtTXOBrowseMch").removeAttr("disabled");
    //         // Remove Disabled คลังสินค้า
    //         $($("#obtTXOBrowseWahFrom").parent()).removeClass("disabled");
    //         $($("#obtTXOBrowseWahFrom").parent()).removeAttr("disabled", "disabled");
    //         $("#obtTXOBrowseWahFrom").removeClass("disabled");
    //         $("#obtTXOBrowseWahFrom").removeAttr("disabled", "disabled");

    //         $($("#obtTXOBrowseWahTo").parent()).removeClass("disabled");
    //         $($("#obtTXOBrowseWahTo").parent()).removeAttr("disabled", "disabled");
    //         $("#obtTXOBrowseWahTo").removeClass("disabled");
    //         $("#obtTXOBrowseWahTo").removeAttr("disabled", "disabled");
    //     }else{
    //         $("#obtTXODocBrowsePdt").attr("disabled","disabled");
    //         $("#obtTXODocBrowsePdt").css("opacity","0.4");
    //         $("#obtTXODocBrowsePdt").css("cursor","not-allowed");

    //         // Add Disabled กลุ่มร้านค้า
    //         $($("#obtTXOBrowseMch").parent()).addClass("disabled");
    //         $($("#obtTXOBrowseMch").parent()).attr("disabled");
    //         $("#obtTXOBrowseMch").addClass("disabled");
    //         $("#obtTXOBrowseMch").attr("disabled");

    //         // Add Disabled คลังสินค้า
    //         $($("#obtTXOBrowseWahFrom").parent()).addClass("disabled");
    //         $($("#obtTXOBrowseWahFrom").parent()).attr("disabled", "disabled");
    //         $("#obtTXOBrowseWahFrom").addClass("disabled");
    //         $("#obtTXOBrowseWahFrom").attr("disabled", "disabled");

    //         $($("#obtTXOBrowseWahTo").parent()).addClass("disabled");
    //         $($("#obtTXOBrowseWahTo").parent()).attr("disabled", "disabled");
    //         $("#obtTXOBrowseWahTo").addClass("disabled");
    //         $("#obtTXOBrowseWahTo").attr("disabled", "disabled");
    //     }
        
    //     // Cheack BranchCode And Open Button Transfer Ship
    //     if ($("#oetTXOBchCode").val() != "" || $("#oetTXOMchCode").val() != "" || $("#oetTXOShpCodeTo").val() != "" || $("#oetTXOPosCodeTo").val() != "") {
    //         $("#obtTXOBrowseShipAdd").removeAttr("disabled");
    //     } else {
    //         $("#obtTXOBrowseShipAdd").attr("disabled", "disabled");
    //     }
    // }

    //Functionality : Function Behind NextFunc กลุ่มร้านค้า
    //Parameters : Event Next Func Modal
    //Creator : 09/05/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
    function JSxTXOSetSeqConditionMerChant(paInForCon) {
        if (tTXOOldMchCkChange != $("#oetTXOMchCode").val()) {
            // เครื่องจุดขาย
            $($($($("#obtTXOBrowsePosFrom").parent()).parent()).parent()).addClass("xCNHide");
            $($("#obtTXOBrowsePosFrom").parent()).addClass("disabled");
            $($("#obtTXOBrowsePosFrom").parent()).attr("disabled", "disabled");
            $("#obtTXOBrowsePosFrom").addClass("disabled");
            $("#obtTXOBrowsePosFrom").attr("disabled", "disabled");

            $($($($("#obtTXOBrowsePosTo").parent()).parent()).parent()).addClass("xCNHide");
            $($("#obtTXOBrowsePosTo").parent()).addClass("disabled");
            $($("#obtTXOBrowsePosTo").parent()).attr("disabled", "disabled");
            $("#obtTXOBrowsePosTo").addClass("disabled");
            $("#obtTXOBrowsePosTo").attr("disabled", "disabled");

            if($("#oetTXOMchCode").val() != "") {
                // Remove Class Disabled Button Browse Shop From
                $($("#obtTXOBrowseShpFrom").parent()).removeClass("disabled");
                $($("#obtTXOBrowseShpFrom").parent()).removeAttr("disabled");
                $("#obtTXOBrowseShpFrom").removeClass("disabled");
                $("#obtTXOBrowseShpFrom").removeAttr("disabled");

                // Remove Class Disabled Button Browse Shop To
                $($("#obtTXOBrowseShpTo").parent()).removeClass("disabled");
                $($("#obtTXOBrowseShpTo").parent()).removeAttr("disabled");
                $("#obtTXOBrowseShpTo").removeClass("disabled");
                $("#obtTXOBrowseShpTo").removeAttr("disabled");

                // Add Class Disabled Button Browse Warehouse From
                $($("#obtTXOBrowseWahFrom").parent()).addClass("disabled");
                $($("#obtTXOBrowseWahFrom").parent()).attr("disabled", "disabled");
                $("#obtTXOBrowseWahFrom").addClass("disabled");
                $("#obtTXOBrowseWahFrom").attr("disabled", "disabled");

                // Add Class Disabled Button Browse Warehouse To
                $($("#obtTXOBrowseWahTo").parent()).addClass("disabled");
                $($("#obtTXOBrowseWahTo").parent()).attr("disabled", "disabled");
                $("#obtTXOBrowseWahTo").addClass("disabled");
                $("#obtTXOBrowseWahTo").attr("disabled", "disabled");

            }else{
                // Add Class Disabled Button Browse Shop From
                $($("#obtTXOBrowseShpFrom").parent()).addClass("disabled");
                $($("#obtTXOBrowseShpFrom").parent()).attr("disabled", "disabled");
                $("#obtTXOBrowseShpFrom").addClass("disabled");
                $("#obtTXOBrowseShpFrom").attr("disabled", "disabled");

                // Add Class Disabled Button Browse Shop To
                $($("#obtTXOBrowseShpTo").parent()).addClass("disabled");
                $($("#obtTXOBrowseShpTo").parent()).attr("disabled", "disabled");
                $("#obtTXOBrowseShpTo").addClass("disabled");
                $("#obtTXOBrowseShpTo").attr("disabled", "disabled");

                // Remove Class Disabled Button Browse Warehouse From
                $($("#obtTXOBrowseWahFrom").parent()).removeClass("disabled");
                $($("#obtTXOBrowseWahFrom").parent()).removeAttr("disabled", "disabled");
                $("#obtTXOBrowseWahFrom").removeClass("disabled");
                $("#obtTXOBrowseWahFrom").removeAttr("disabled", "disabled");

                // Remove Class Disabled Button Browse Warehouse To
                $($("#obtTXOBrowseWahTo").parent()).removeClass("disabled");
                $($("#obtTXOBrowseWahTo").parent()).removeAttr("disabled", "disabled");
                $("#obtTXOBrowseWahTo").removeClass("disabled");
                $("#obtTXOBrowseWahTo").removeAttr("disabled", "disabled");
            }

            // Clear Value Input Shop From
            $("#oetTXOShpCodeFrom").val("");
            $("#oetTXOShpNameFrom").val("");
            // Clear Value Input Shop To
            $("#oetTXOOldShpCodeTo").val("");
            $("#oetTXOOldShpNameTo").val("");
            // Clear Value Input Pos From
            $("#oetTXOPosCodeFrom").val("");
            $("#oetTXOPosNameFrom").val("");
            // Clear Value Input Pos To
            $("#oetTXOPosCodeTo").val("");
            $("#oetTXOPosNameTo").val("");
            // Clear Value Input Wah From
            $("#oetTXOWahCodeFrom").val("");
            $("#oetTXOWahNameFrom").val("");
            // Clear Value Input Wah To
            $("#oetTXOWahCodeTo").val("");
            $("#oetTXOWahNameTo").val("");
            
            tTXOOldMchCkChange = "";

            if($("#ohdTXOShipAddSeqNo").val() != "" && $("#otbTXODocPdtTable .xCNDOCPdtItem").length == 0) {
                // ข้อมูลที่อยู่สำหรับจัดส่งเดิมจะถูกเคลียร์ โปรดทำการระบุข้อมูลที่อยู่สำหรับจัดส่งใหม่
                FSvCMNSetMsgWarningDialog("<p><?php echo language('document/transferout/transferout','tTXOMsgWarningShipAddChange1');?></p>");

            }else if($("#otbTXODocPdtTable .xCNDOCPdtItem").length != 0 && $("#ohdTXOShipAddSeqNo").val() == ""){
                // รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนกลุ่มร้านค้าสำหรับจัดส่งสินค้าใหม่
                FSvCMNSetMsgWarningDialog("<p><?php echo language('document/transferout/transferout','tTXOMsgWarningShipAddChange2');?></p>");

            }else if($("#otbTXODocPdtTable .xCNDOCPdtItem").length != 0 && $("#ohdTXOShipAddSeqNo").val() != "") {
                // ที่อยู่สำหรับจัดส่งและรายการสินค้าที่ท่านเพิ่มไปแล้ว จะถูกล้างค่าเมื่อท่านเปลี่ยนกลุ่มร้านค้าสำหรับจัดส่งใหม่
                FSvCMNSetMsgWarningDialog("<p><?php echo language('document/transferout/transferout','tTXOMsgWarningShipAddChange3');?></p>");
            }
            
            if($("#ohdTXOShipAddSeqNo").val() != "") {
                $("#ospTXOShipAddAddV1No").text("-");
                $("#ospTXOShipAddV1Soi").text("-");
                $("#ospTXOShipAddV1Village").text("-");
                $("#ospTXOShipAddV1Road").text("-");
                $("#ospTXOShipAddV1SubDist").text("-");
                $("#osptXOShipAddV1DstCode").text("-");
                $("#ospTXOShipAddV1PvnCode").text("-");
                $("#ospTXOShipAddV1PostCode").text("-");
                $("#ospTXOShipAddV2Desc1").text("-");
                $("#ospTXOShipAddV2Desc2").text("-");
                $("#ohdTXOShipAddSeqNo").val("");
            }
            
            if($("#otbTXODocPdtTable .xCNDOCPdtItem").length != 0) {

                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmTXOClearDataDocTemp",
                    data: {
                        'ptTXODocType'  : tTXODocType,
                        'ptTXODocNo'    : $("#oetTXODocNo").val(),
                    },
                    cache: false,
                    timeout: 0,
                    success: function (oResult){
                        var aDataReturn = JSON.parse(oResult);
                        if(aDataReturn['nStaReturn'] == 1){
                            JSvTXOLoadPdtDataTableHtml();
                            JCNxCloseLoading();
                        }else{
                            var tMessageError = aDataReturn['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                            JCNxCloseLoading();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }

            if ($("#oetTXOBchCode").val() != "" || $("#oetTXOMchCode").val() != "" || $("#oetTXOOldShpCodeTo").val() != "" || $("#oetTXOPosCodeTo").val() != "") {
                $("#obtTXOBrowseShipAdd").removeAttr("disabled");
            }else{
                $("#obtTXOBrowseShipAdd").attr("disabled", "disabled");
            }
            tTXOOldMchCkChange = "";
        }
    }

    //Functionality : Function Behind NextFunc ร้านค้าต้นทาง
    //Parameters : Event Next Func Modal
    //Creator : 09/05/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
    function JSxTXOSetSeqConditionShopFrom(paInForCon){
        if(tTXOOldShpFromCkChange != $("#oetTXOShpCodeFrom").val()){
            $("#oetTXOPosCodeFrom").val("");
            $("#oetTXOPosNameFrom").val("");
            $("#oetTXOWahCodeFrom").val("");
            $("#oetTXOWahNameFrom").val("");
            tTXOOldShpFromCkChange = "";

            if($("#otbTXODocPdtTable .xCNDOCPdtItem").length != 0){
                // รายการสินค้าที่ท่านเพิ่มไปแล้วจะถูกล้างค่าทิ้ง เมื่อท่านเปลี่ยนร้านค้าต้นทางสำหรับจัดส่งสินค้าใหม่
                FSvCMNSetMsgWarningDialog("<p><?php echo language('document/transferout/transferout','tTXOMsgWarningShipAddChangShpFrom');?></p>");
            }
            if($("#otbTXODocPdtTable .xCNDOCPdtItem").length != 0){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmTXOClearDataDocTemp",
                    data: {
                        'ptTXODocType'  : tTXODocType,
                        'ptTXODocNo'    : $("#oetTXODocNo").val(),
                    },
                    cache: false,
                    timeout: 0,
                    success: function (oResult){
                        var aDataReturn = JSON.parse(oResult);
                        if(aDataReturn['nStaReturn'] == 1){
                            JSvTXOLoadPdtDataTableHtml();
                            JCNxCloseLoading();
                        }else{
                            var tMessageError = aDataReturn['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                            JCNxCloseLoading();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }

            if($("#oetTXOShpCodeFrom").val() != "") {
                var aDataInForCon   = JSON.parse(paInForCon);
                var tShopType       = aDataInForCon[2];
                if (tShopType == '4') {
                    // Remove Class Disabled Button เครื่องจุดขายต้นทาง
                    $($($($("#obtTXOBrowsePosFrom").parent()).parent()).parent()).removeClass("xCNHide");
                    // Remove Class Disable Button เครื่องจุดขายต้นทาง
                    $($("#obtTXOBrowsePosFrom").parent()).removeClass("disabled");
                    $($("#obtTXOBrowsePosFrom").parent()).removeAttr("disabled");
                    $("#obtTXOBrowsePosFrom").removeClass("disabled");
                    $("#obtTXOBrowsePosFrom").removeAttr("disabled");
                    // Remove Class Disable Button คลังสินค้าต้นทาง
                    $($("#obtTXOBrowseWahFrom").parent()).removeClass("disabled");
                    $($("#obtTXOBrowseWahFrom").parent()).removeAttr("disabled", "disabled");
                    $("#obtTXOBrowseWahFrom").removeClass("disabled");
                    $("#obtTXOBrowseWahFrom").removeAttr("disabled", "disabled");
                }else{
                    // Add Class Disabled Button เครื่องจุดขายต้นทาง
                    $($($($("#obtTXOBrowsePosFrom").parent()).parent()).parent()).addClass("xCNHide");
                    // Add Class Disabled Button เครื่องจุดขายต้นทาง
                    $($("#obtTXOBrowsePosFrom").parent()).addClass("disabled");
                    $($("#obtTXOBrowsePosFrom").parent()).attr("disabled", "disabled");
                    $("#obtTXOBrowsePosFrom").addClass("disabled");
                    $("#obtTXOBrowsePosFrom").attr("disabled", "disabled");

                    $("#oetTXOWahCodeFrom").val(aDataInForCon[3]);
                    $("#oetTXOWahNameFrom").val(aDataInForCon[4]);
                    // Add Class Disabled Button คลังสินค้าต้นทาง
                    $($("#obtTXOBrowseWahFrom").parent()).addClass("disabled");
                    $($("#obtTXOBrowseWahFrom").parent()).attr("disabled", "disabled");
                    $("#obtTXOBrowseWahFrom").addClass("disabled");
                    $("#obtTXOBrowseWahFrom").attr("disabled", "disabled");
                }

                if($("#oetTXOOldShpCodeTo").val() != ""){
                    if($("#oetTXOShpCodeFrom").val() == $("#oetTXOShpCodeTo").val()){
                        if($("#oetTXOPosCodeTo").val() == "" && $("#oetTXOWahCodeTo").val() != ""){
                            // Add Class Disabled Button คลังสินค้าต้นทาง
                            $($("#obtTXOBrowseWahFrom").parent()).addClass("disabled");
                            $($("#obtTXOBrowseWahFrom").parent()).attr("disabled", "disabled");
                            $("#obtTXOBrowseWahFrom").addClass("disabled");
                            $("#obtTXOBrowseWahFrom").attr("disabled", "disabled");
                        }
                    }
                }
            }else{
                // Add Class Disabled Button เครื่องจุดขายต้นทาง
                $($($($("#obtTXOBrowsePosFrom").parent()).parent()).parent()).addClass("xCNHide");

                // Add Class Disabled Button เครื่องจุดขายต้นทาง
                $($("#obtTXOBrowsePosFrom").parent()).addClass("disabled");
                $($("#obtTXOBrowsePosFrom").parent()).attr("disabled", "disabled");
                $("#obtTXOBrowsePosFrom").addClass("disabled");
                $("#obtTXOBrowsePosFrom").attr("disabled", "disabled");

                if($("#oetTXOBchCode").val() == "") {
                    // Add Class Disable Button คลังสินค้าต้นทาง
                    $($("#obtTXOBrowseWahFrom").parent()).addClass("disabled");
                    $($("#obtTXOBrowseWahFrom").parent()).attr("disabled", "disabled");
                    $("#obtTXOBrowseWahFrom").addClass("disabled");
                    $("#obtTXOBrowseWahFrom").attr("disabled", "disabled");
                }else{
                    if ($("#oetTXOMchCode").val() != "") {
                        // Add Class Disable Button คลังสินค้าต้นทาง
                        $($("#obtTXOBrowseWahFrom").parent()).addClass("disabled");
                        $($("#obtTXOBrowseWahFrom").parent()).attr("disabled", "disabled");
                        $("#obtTXOBrowseWahFrom").addClass("disabled");
                        $("#obtTXOBrowseWahFrom").attr("disabled", "disabled");
                    } else {
                        // Remove Class Disable Button คลังสินค้าต้นทาง
                        $($("#obtTXOBrowseWahFrom").parent()).removeClass("disabled");
                        $($("#obtTXOBrowseWahFrom").parent()).removeAttr("disabled", "disabled");
                        $("#obtTXOBrowseWahFrom").removeClass("disabled");
                        $("#obtTXOBrowseWahFrom").removeAttr("disabled", "disabled");
                    }
                }
            }
            
            if ($("#oetTXOBchCode").val() != "" || $("#oetTXOMchCode").val() != "" || $("#oetTXOOldShpCodeTo").val() != "" || $("#oetTXOPosCodeTo").val() != "") {
                $("#obtTXOBrowseShipAdd").removeAttr("disabled");
            }else{
                $("#obtTXOBrowseShipAdd").attr("disabled", "disabled");
            }
            tTXOOldShpFromCkChange = "";
        }
    }

    //Functionality : Function Behind NextFunc ร้านค้าปลายทาง
    //Parameters : Event Next Func Modal
    //Creator : 09/05/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
    function JSxTXOSetSeqConditionShopTo(paInForCon){
        if(tTXOOldShpToCkChange != $("#oetTXOShpCodeTo").val()){
            $("#oetTXOPosCodeTo").val("");
            $("#oetTXOPosNameTo").val("");
            $("#oetTXOWahCodeTo").val("");
            $("#oetTXOWahNameTo").val("");
            tTXOOldShpToCkChange    = "";

            if($("#oetTXOShpCodeTo").val() != "") {
                var aDataInForCon   = JSON.parse(paInForCon);
                var tShopType       = aDataInForCon[2];
                if(tShopType == '4'){
                    // Remove Class Hide Input เครื่องจุดขายปลายทาง
                    $($($($("#obtTXOBrowsePosTo").parent()).parent()).parent()).removeClass("xCNHide");

                    // Remove Class Disabled เครื่องจุดขายปลายทาง
                    $($("#obtTXOBrowsePosTo").parent()).removeClass("disabled");
                    $($("#obtTXOBrowsePosTo").parent()).removeAttr("disabled");
                    $("#obtTXOBrowsePosTo").removeClass("disabled");
                    $("#obtTXOBrowsePosTo").removeAttr("disabled");

                    // Remove Class Disabled คลังสินค้าปลายทาง
                    $($("#obtTXOBrowseWahTo").parent()).removeClass("disabled");
                    $($("#obtTXOBrowseWahTo").parent()).removeAttr("disabled", "disabled");
                    $("#obtTXOBrowseWahTo").removeClass("disabled");
                    $("#obtTXOBrowseWahTo").removeAttr("disabled", "disabled");
                }else{
                    // Hide Input เครื่องจุดขายปลายทาง
                    $($($($("#obtTXOBrowsePosTo").parent()).parent()).parent()).addClass("xCNHide");

                    // Add Class Disable Button เครื่องจุดขายปลายทาง
                    $($("#obtTXOBrowsePosTo").parent()).addClass("disabled");
                    $($("#obtTXOBrowsePosTo").parent()).attr("disabled", "disabled");
                    $("#obtTXOBrowsePosTo").addClass("disabled");
                    $("#obtTXOBrowsePosTo").attr("disabled", "disabled");

                    $("#oetTXOWahCodeTo").val(aDataInForCon[3]);
                    $("#oetTXOWahNameTo").val(aDataInForCon[4]);

                    // Add Class Disable Button คลังสินค้าปลายทาง
                    $($("#obtTXOBrowseWahTo").parent()).addClass("disabled");
                    $($("#obtTXOBrowseWahTo").parent()).attr("disabled", "disabled");
                    $("#obtTXOBrowseWahTo").addClass("disabled");
                    $("#obtTXOBrowseWahTo").attr("disabled", "disabled");
                }

                if($("#oetTXOShpCodeFrom").val() != ""){
                    if($("#oetTXOShpCodeFrom").val() == $("#oetTXOShpCodeTo").val()){
                        if($("#oetTXOPosCodeFrom").val() == "" && $("#oetTXOWahCodeFrom").val() != ""){
                            // Add Class Disabled Button คลังสินค้าปลายทาง
                            $($("#obtTXOBrowseWahTo").parent()).addClass("disabled");
                            $($("#obtTXOBrowseWahTo").parent()).attr("disabled", "disabled");
                            $("#obtTXOBrowseWahTo").addClass("disabled");
                            $("#obtTXOBrowseWahTo").attr("disabled", "disabled");
                        }
                    }
                }
            }else{
                // Add Class Hide Input เครื่องจุดขายปลายทาง
                $($($($("#obtTXOBrowsePosTo").parent()).parent()).parent()).addClass("xCNHide");

                // Add Class Disabled Button เครื่องจุดขายปลายทาง
                $($("#obtTXOBrowsePosTo").parent()).addClass("disabled");
                $($("#obtTXOBrowsePosTo").parent()).attr("disabled", "disabled");
                $("#obtTXOBrowsePosTo").addClass("disabled");
                $("#obtTXOBrowsePosTo").attr("disabled", "disabled");

                if($("#oetTXOBchCode").val() == "") {
                    // Add Class Disabled Button คลังสินค้าปลายทาง
                    $($("#obtTXOBrowseWahTo").parent()).addClass("disabled");
                    $($("#obtTXOBrowseWahTo").parent()).attr("disabled", "disabled");
                    $("#obtTXOBrowseWahTo").addClass("disabled");
                    $("#obtTXOBrowseWahTo").attr("disabled", "disabled");
                }else{
                    if($("#oetTXOMchCode").val() != ""){
                        // Add Class Disabled Button คลังสินค้าปลายทาง
                        $($("#obtTXOBrowseWahTo").parent()).addClass("disabled");
                        $($("#obtTXOBrowseWahTo").parent()).attr("disabled", "disabled");
                        $("#obtTXOBrowseWahTo").addClass("disabled");
                        $("#obtTXOBrowseWahTo").attr("disabled", "disabled");
                    }else{
                         // Remove Class Disabled Button คลังสินค้าปลายทาง
                        $($("#obtTXOBrowseWahTo").parent()).removeClass("disabled");
                        $($("#obtTXOBrowseWahTo").parent()).removeAttr("disabled", "disabled");
                        $("#obtTXOBrowseWahTo").removeClass("disabled");
                        $("#obtTXOBrowseWahTo").removeAttr("disabled", "disabled");
                    }
                }
            }

            if ($("#oetTXOBchCode").val() != "" || $("#oetTXOMchCode").val() != "" || $("#oetTXOOldShpCodeTo").val() != "" || $("#oetTXOPosCodeTo").val() != "") {
                $("#obtTXOBrowseShipAdd").removeAttr("disabled");
            }else{
                $("#obtTXOBrowseShipAdd").attr("disabled", "disabled");
            }

            if($("#ohdTXOShipAddSeqNo").val() != ""){
                // ข้อมูลที่อยู่สำหรับจัดส่งเดิมจะถูกเคลียร์ โปรดทำการระบุข้อมูลที่อยู่สำหรับจัดส่งใหม่
                FSvCMNSetMsgWarningDialog("<p><?php echo language('document/transferout/transferout','tTXOMsgWarningShipAddChange1');?></p>");
            }

            if($("#ohdTXOShipAddSeqNo").val() != ""){
                $("#ospTXOShipAddAddV1No").text("-");
                $("#ospTXOShipAddV1Soi").text("-");
                $("#ospTXOShipAddV1Village").text("-");
                $("#ospTXOShipAddV1Road").text("-");
                $("#ospTXOShipAddV1SubDist").text("-");
                $("#ospTXOShipAddV1DstCode").text("-");
                $("#ospTXOShipAddV1PvnCode").text("-");
                $("#ospTXOShipAddV1PostCode").text("-");
                $("#ospTXOShipAddV2Desc1").text("-");
                $("#ospTXOShipAddV2Desc2").text("-");
                $("#ohdTXOShipAddSeqNo").val("");
            }
            tTXOOldShpToCkChange    = "";
        }
    }

    //Functionality : Function Behind NextFunc เครื่องจุดขายต้นทาง
    //Parameters : Event Next Func Modal
    //Creator : 09/05/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
    function JSxTXOSetSeqConditionPosFrom(paInForCon){
        // Clear Input Value
        $("#oetTXOWahCodeFrom").val("");
        $("#oetTXOWahNameFrom").val("");

        if ($("#oetTXOPosCodeFrom").val() != "") {
            var aDataInForCon = JSON.parse(paInForCon);
            $("#oetTXOWahCodeFrom").val(aDataInForCon[3]);
            $("#oetTXOWahNameFrom").val(aDataInForCon[4]);

            // Add Class Disabled Buttom คลังสินค้าต้นทาง
            $($("#obtTXOBrowseWahFrom").parent()).addClass("disabled");
            $($("#obtTXOBrowseWahFrom").parent()).attr("disabled", "disabled");
            $("#obtTXOBrowseWahFrom").addClass("disabled");
            $("#obtTXOBrowseWahFrom").attr("disabled", "disabled");

            if ($("#oetTXOShpCodeFrom").val() == $("#oetTXOShpCodeTo").val()) {
                if (!$($($($("#obtTXOBrowsePosTo").parent()).parent()).parent()).hasClass("xCNHide")) {
                    if ($("#oetTXOPosCodeTo").val() == "") {
                        // Remove Class Disabled Buttom คลังสินค้าปลายทาง
                        $($("#obtTXOBrowseWahTo").parent()).removeClass("disabled");
                        $($("#obtTXOBrowseWahTo").parent()).removeAttr("disabled", "disabled");
                        $("#obtTXOBrowseWahTo").removeClass("disabled");
                        $("#obtTXOBrowseWahTo").removeAttr("disabled", "disabled");
                    }
                }
            }
        }else{
            // Remove Class Disabled Buttom คลังสินค้าต้นทาง
            $($("#obtTXOBrowseWahFrom").parent()).removeClass("disabled");
            $($("#obtTXOBrowseWahFrom").parent()).removeAttr("disabled", "disabled");
            $("#obtTXOBrowseWahFrom").removeClass("disabled");
            $("#obtTXOBrowseWahFrom").removeAttr("disabled", "disabled");

            if (!$($($($("#obtTXOBrowsePosTo").parent()).parent()).parent()).hasClass("xCNHide")) {
                if ($("#oetTXOPosCodeTo").val() == "" && $("#oetTXOWahCodeTo").val() != "") {
                    // Add Class Disabled Buttom คลังสินค้าต้นทาง
                    $($("#obtTXOBrowseWahFrom").parent()).addClass("disabled");
                    $($("#obtTXOBrowseWahFrom").parent()).attr("disabled", "disabled");
                    $("#obtTXOBrowseWahFrom").addClass("disabled");
                    $("#obtTXOBrowseWahFrom").attr("disabled", "disabled");
                }
            }
        }

        if($("#oetTXOBchCode").val() != "" || $("#oetTXOMchCode").val() != "" || $("#oetTXOShpCodeTo").val() != "" || $("#oetTXOPosCodeTo").val() != ""){
            $("#obtTXOBrowseShipAdd").removeAttr("disabled");
        }else{
            $("#obtTXOBrowseShipAdd").attr("disabled", "disabled");
        }
    }

    //Functionality : Function Behind NextFunc เครื่องจุดขายปลายทาง
    //Parameters : Event Next Func Modal
    //Creator : 10/05/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
    function JSxTXOSetSeqConditionPosTo(paInForCon){
        $("#oetTXOWahCodeTo").val("");
        $("#oetTXOWahNameTo").val("");

        if($("#oetTXOPosCodeTo").val() != ""){
            var aDataInForCon = JSON.parse(paInForCon);
            $("#oetTXOWahCodeTo").val(aDataInForCon[3]);
            $("#oetTXOWahNameTo").val(aDataInForCon[4]);

            // Add Class Disabled Input คลังสินค้าปลายทาง
            $($("#obtTXOBrowseWahTo").parent()).addClass("disabled");
            $($("#obtTXOBrowseWahTo").parent()).attr("disabled", "disabled");
            $("#obtTXOBrowseWahTo").addClass("disabled");
            $("#obtTXOBrowseWahTo").attr("disabled", "disabled");
            
            if($("#oetTXOShpCodeFrom").val() == $("#oetTXOShpCodeTo").val()) {
                if(!$($($($("#obtTXOBrowsePosFrom").parent()).parent()).parent()).hasClass("xCNHide")) {
                    if($("#oetTXOPosCodeFrom").val() == "") {
                        // Remove Class Disabled Button คลังสินค้าต้นทาง
                        $($("#obtTXOBrowseWahFrom").parent()).removeClass("disabled");
                        $($("#obtTXOBrowseWahFrom").parent()).removeAttr("disabled", "disabled");
                        $("#obtTXOBrowseWahFrom").removeClass("disabled");
                        $("#obtTXOBrowseWahFrom").removeAttr("disabled", "disabled");
                    }
                }
            }
        }else{
            // Remove Class Disabled Input คลังสินค้าปลายทาง
            $($("#obtTXOBrowseWahTo").parent()).removeClass("disabled");
            $($("#obtTXOBrowseWahTo").parent()).removeAttr("disabled", "disabled");
            $("#obtTXOBrowseWahTo").removeClass("disabled");
            $("#obtTXOBrowseWahTo").removeAttr("disabled", "disabled");
            if(!$($($($("#obtTXOBrowsePosFrom").parent()).parent()).parent()).hasClass("xCNHide")){
                if($("#oetTXOPosCodeFrom").val() == "" && $("#oetTXOWahCodeFrom").val() != "") {
                    // Add Class Disabled Input คลังสินค้าปลายทาง
                    $($("#obtTXOBrowseWahTo").parent()).addClass("disabled");
                    $($("#obtTXOBrowseWahTo").parent()).attr("disabled", "disabled");
                    $("#obtTXOBrowseWahTo").addClass("disabled");
                    $("#obtTXOBrowseWahTo").attr("disabled", "disabled");
                }
            }
        }

        if($("#oetTXOBchCode").val() != "" || $("#oetTXOMchCode").val() != "" || $("#oetTXOShpCodeTo").val() != "" || $("#oetTXOPosCodeTo").val() != ""){
            $("#obtTXOBrowseShipAdd").removeAttr("disabled");
        }else{
            $("#obtTXOBrowseShipAdd").attr("disabled", "disabled");
        }

        if($("#ohdTXOShipAddSeqNo").val() != "" && $("#otbTXODocPdtTable .xCNDOCPdtItem").length == 0){
            // ข้อมูลที่อยู่สำหรับจัดส่งเดิมจะถูกเคลียร์ โปรดทำการระบุข้อมูลที่อยู่สำหรับจัดส่งใหม่
            FSvCMNSetMsgWarningDialog("<p><?php echo language('document/transferout/transferout','tTXOMsgWarningShipAddChange1');?></p>");
        }

        if ($("#ohdTXOShipAddSeqNo").val() != "") {
            $("#ospTXOShipAddAddV1No").text("-");
            $("#ospTXOShipAddV1Soi").text("-");
            $("#ospTXOShipAddV1Village").text("-");
            $("#ospTXOShipAddV1Road").text("-");
            $("#ospTXOShipAddV1SubDist").text("-");
            $("#ospTXOShipAddV1DstCode").text("-");
            $("#ospTXOShipAddV1PvnCode").text("-");
            $("#ospTXOShipAddV1PostCode").text("-");
            $("#ospTXOShipAddV2Desc1").text("-");
            $("#ospTXOShipAddV2Desc2").text("-");
            $("#ohdTXOShipAddSeqNo").val("");
        }
    }

    //Functionality : Function Behind NextFunc คลังสินค้าต้นทาง
    //Parameters : Event Next Func Modal
    //Creator : 10/05/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
    function JSxTXOSetSeqConditionWahFrom(paInForCon){
        if($("#oetTXOShpCodeTo").val() != "") {
            if($("#oetTXOShpCodeFrom").val() == $("#oetTXOShpCodeTo").val()){
                if(!$($($($("#obtTXOBrowsePosTo").parent()).parent()).parent()).hasClass("xCNHide")){
                    if ($("#oetTXOPosCodeTo").val() == "" && $("#oetTXOWahCodeTo").val() == "") {
                        // Add Class Disable Buttom Browse คลังสินค้าปลายทาง
                        $($("#obtTXOBrowseWahTo").parent()).addClass("disabled");
                        $($("#obtTXOBrowseWahTo").parent()).attr("disabled", "disabled");
                        $("#obtTXOBrowseWahTo").addClass("disabled");
                        $("#obtTXOBrowseWahTo").attr("disabled", "disabled");

                        if ($("#oetTXOPosCodeFrom").val() == "" && $("#oetTXOWahCodeFrom").val() == "") {
                            // Remove Class Disable Buttom Browse คลังสินค้าปลายทาง
                            $($("#obtTXOBrowseWahTo").parent()).removeClass("disabled");
                            $($("#obtTXOBrowseWahTo").parent()).removeAttr("disabled", "disabled");
                            $("#obtTXOBrowseWahTo").removeClass("disabled");
                            $("#obtTXOBrowseWahTo").removeAttr("disabled", "disabled");
                        }
                    }
                }
            }
        }

        if($("#oetTXOBchCode").val() != "" || $("#oetTXOMchCode").val() != "" || $("#oetTXOShpCodeTo").val() != "" || $("#oetTXOPosCodeTo").val() != ""){
            $("#obtTXOBrowseShipAdd").removeAttr("disabled");
        }else{
            $("#obtTXOBrowseShipAdd").attr("disabled", "disabled");
        }
    }

    //Functionality : Function Behind NextFunc คลังสินค้าปลายทาง
    //Parameters : Event Next Func Modal
    //Creator : 10/05/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
    function JSxTXOSetSeqConditionWahTo(paInForCon){
        if ($("#oetTXOShpCodeFrom").val() != "") {
            if ($("#oetTXOShpCodeFrom").val() == $("#oetTXOShpCodeTo").val()) {
                if (!$($($($("#obtTXOBrowseShpFrom").parent()).parent()).parent()).hasClass("xCNHide")) {
                    if ($("#oetTXOPosCodeFrom").val() == "" && $("#oetTXOWahCodeFrom").val() == "") {
                        // Add Class Disabled Buttom Browse คลังสินค้าต้นทาง
                        $($("#obtTXOBrowseWahFrom").parent()).addClass("disabled");
                        $($("#obtTXOBrowseWahFrom").parent()).attr("disabled", "disabled");
                        $("#obtTXOBrowseWahFrom").addClass("disabled");
                        $("#obtTXOBrowseWahFrom").attr("disabled", "disabled");
                        if ($("#oetTXOPosCodeTo").val() == "" && $("#oetTXOWahCodeTo").val() == "") {
                            // Remove Class Disabled Buttom Browse คลังสินค้าต้นทาง
                            $($("#obtTXOBrowseWahFrom").parent()).removeClass("disabled");
                            $($("#obtTXOBrowseWahFrom").parent()).removeAttr("disabled", "disabled");
                            $("#obtTXOBrowseWahFrom").removeClass("disabled");
                            $("#obtTXOBrowseWahFrom").removeAttr("disabled", "disabled");
                        }
                    }
                }
            }
        }

        if($("#oetTXOBchCode").val() != "" || $("#oetTXOMchCode").val() != "" || $("#oetTXOShpCodeTo").val() != "" || $("#oetTXOPosCodeTo").val() != ""){
            $("#obtTXOBrowseShipAdd").removeAttr("disabled");
        }else{
            $("#obtTXOBrowseShipAdd").attr("disabled", "disabled");
        }
    }

/** ===================================================================================================== */

/** ======================================= Set Shipping Address ======================================== */
    $('#obtTXOBrowseShipAdd').unbind().click(function(){
        $("#odvTXOBrowseShipAdd").modal("show");
    });

    var oTXOBrowseShpAddr   = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tTXOWhereCons       = poDataFnc.tTXOWhereCons;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;
        var oOptionReturn       = {
            Title : ['document/transferout/transferout','tTXOBrowseADDTitle'],
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
                Condition : [tTXOWhereCons]
            },
            GrideView:{
                ColumnPathLang	: 'document/purchaseorder/purchaseorder',
                ColumnKeyLang	: [
                    'tTXOBrowseADDBch',
                    'tTXOBrowseADDSeq',
                    'tTXOBrowseADDV1No',
                    'tTXOBrowseADDV1Soi',
                    'tTXOBrowseADDV1Village',
                    'tTXOBrowseADDV1Road',
                    'tTXOBrowseADDV1SubDist',
                    'tTXOBrowseADDV1DstCode',
                    'tTXOBrowseADDV1PvnCode',
                    'tTXOBrowseADDV1PostCode'
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
                OrderBy			: ['TCNMAddress_L.FTAddRefCode'],
                SourceOrder		: "ASC"
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
            BrowseLev : nStaTXOBrowseType
        };
        return oOptionReturn;
    }


    $('#oliTXOEditShipAddr').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

            var tTXOWhereCons = "";
            if($("#oetTXOBchCode").val() != ""){
                if($("#oetTXOMchCode").val() != ""){
                    if($("#oetTXOShpCodeTo").val() != ""){
                        if($("#oetTXOPosCodeTo").val() != ""){
                            // Address Ref POS
                            tTXOWhereCons   +=  "AND FTAddGrpType = 6 AND FTAddRefCode = '"+$("#oetTXOPosCodeTo").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                        }else{
                            // Address Ref SHOP
                            tTXOWhereCons   +=  "AND FTAddGrpType = 4 AND FTAddRefCode = '"+$("#oetTXOShpCodeTo").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                        }
                    }else{
                        // Address Ref BCH
                        tTXOWhereCons   +=  "AND FTAddGrpType = 1 AND FTAddRefCode = '"+$("#oetTXOBchCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                    }
                }else{
                    // Address Ref BCH
                    tTXOWhereCons   +=  "AND FTAddGrpType = 1 AND FTAddRefCode = '"+$("#oetTXOBchCode").val()+"' AND TCNMAddress_L.FNLngID = "+nLangEdits;
                }
            }
            // Call Option Modal
            window.oTXOBrowseShpAddrOption  = undefined;
            oTXOBrowseShpAddrOption         = oTXOBrowseShpAddr({
                'tReturnInputCode'  : 'ohdTXOShipAddSeqNo',
                'tReturnInputName'  : 'ohdTXOShipAddSeqNo',
                'tTXOWhereCons'     : tTXOWhereCons,
                'tNextFuncName'     : 'JSvTXOGetShipAddrData',
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
            $("#odvTXOBrowseShipAdd").modal("hide");
            JCNxBrowseData('oTXOBrowseShpAddrOption');
        }else{
            $("#odvTXOBrowseShipAdd").modal("hide");
            JCNxShowMsgSessionExpired();
        }
    });

    //Functionality : Behind NextFunc Browse Shippinh Address
    //Parameters : Event Next Func Modal
    //Creator : 14/05/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
    function JSvTXOGetShipAddrData(paInForCon){
        if(paInForCon !== "NULL") {
            var aDataReturn = JSON.parse(paInForCon);
            $("#ospTXOShipAddAddV1No").text((aDataReturn[1] != "")      ? aDataReturn[1]    : '-');
            $("#ospTXOShipAddV1Soi").text((aDataReturn[2] != "")        ? aDataReturn[2]    : '-');
            $("#ospTXOShipAddV1Village").text((aDataReturn[3] != "")    ? aDataReturn[3]    : '-');
            $("#ospTXOShipAddV1Road").text((aDataReturn[4] != "")       ? aDataReturn[4]    : '-');
            $("#ospTXOShipAddV1SubDist").text((aDataReturn[5] != "")    ? aDataReturn[5]    : '-');
            $("#ospTXOShipAddV1DstCode").text((aDataReturn[6] != "")    ? aDataReturn[6]    : '-');
            $("#ospTXOShipAddV1PvnCode").text((aDataReturn[7] != "")    ? aDataReturn[7]    : '-');
            $("#ospTXOShipAddV1PostCode").text((aDataReturn[8] != "")   ? aDataReturn[8]    : '-');
            $("#ospTXOShipAddV2Desc1").text((aDataReturn[9] != "")      ? aDataReturn[9]    : '-');
            $("#ospTXOShipAddV2Desc2").text((aDataReturn[10] != "")     ? aDataReturn[10]   : '-');
        }else{
            $("#ospTXOShipAddAddV1No").text("-");
            $("#ospTXOShipAddV1Soi").text("-");
            $("#ospTXOShipAddV1Village").text("-");
            $("#ospTXOShipAddV1Road").text("-");
            $("#ospTXOShipAddV1SubDist").text("-");
            $("#ospTXOShipAddV1DstCode").text("-");
            $("#ospTXOShipAddV1PvnCode").text("-");
            $("#ospTXOShipAddV1PostCode").text("-");
            $("#ospTXOShipAddV2Desc1").text("-");
            $("#ospTXOShipAddV2Desc2").text("-");
        }
        $("#odvTXOBrowseShipAdd").modal("show");
    }

    //Functionality : Add Shiping Add To Input
    //Parameters : Event Next Func Modal
    //Creator : 15/05/2019 Wasin(Yoshi)
    //Return : Set Value And Controll Input
    //Return Type : -
    function JSnTXOAddShipAdd(){
        var tTXOShipAddSeqNoSelect  = $('#ohdTXOShipAddSeqNo').val();
        $('#ohdTXOShipAdd').val(tTXOShipAddSeqNoSelect);
        $('#odvTXOBrowseShipAdd').modal('toggle');
    }

    
/** ===================================================================================================== */

/** =============================== Manage Product Advance Table Colums  ================================ */
    $('#oliTXOMngPdtColum').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxTXOOpenColumnFormSet();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#odvTXOOrderAdvTblColumns #obtTXOSaveAdvTableColums').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxTXOSaveColumnShow();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //Functionality : Call Advnced Table 
    //Parameters : Event Next Func Modal
    //Creator : 15/05/2019 Wasin(Yoshi)
    //Return : Open Modal Manage Colums Show
    //Return Type : -
    function JSxTXOOpenColumnFormSet(){
        $.ajax({
            type: "POST",
            url: "dcmTXOAdvanceTableShowColList",
            data: {'tTXODocType' : tTXODocType},
            cache: false,
            Timeout: 0,
            success: function (oResult) {
                var aDataReturn = JSON.parse(oResult);
                if(aDataReturn['nStaEvent'] == '1'){
                    var tViewTableShowCollist = aDataReturn['tViewTableShowCollist'];
                    $('#odvTXOOrderAdvTblColumns .modal-body').html(tViewTableShowCollist);
                    $('#odvTXOOrderAdvTblColumns').modal({backdrop: 'static', keyboard: false})  
                    $("#odvTXOOrderAdvTblColumns").modal({ show: true });
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
    //Creator : 15/05/2019 Wasin(Yoshi)
    //Return : Open Modal Manage Colums Show
    //Return Type : -
    function JSxTXOSaveColumnShow(){
        // คอลัมน์ที่เลือกให้แสดง
        var aTXOColShowSet = [];
        $("#odvTXOOrderAdvTblColumns .xWTXOInputColStaShow:checked").each(function(){
            aTXOColShowSet.push($(this).data("id"));
        });

        // คอลัมน์ทั้งหมด
        var aTXOColShowAllList = [];
        $("#odvTXOOrderAdvTblColumns .xWTXOInputColStaShow").each(function () {
            aTXOColShowAllList.push($(this).data("id"));
        });

        // ชื่อคอลัมน์ทั้งหมดในกรณีมีการแก้ไขชื่อคอลัมน์ที่แสดง
        var aTXOColumnLabelName = [];
        $("#odvTXOOrderAdvTblColumns .xWTXOLabelColumnName").each(function () {
            aTXOColumnLabelName.push($(this).text());
        });

        // สถานะย้อนกลับค่าเริ่มต้น
        var nTXOStaSetDef;
        if($("#odvTXOOrderAdvTblColumns #ocbTXOSetDefAdvTable").is(":checked")) {
            nTXOStaSetDef   = 1;
        } else {
            nTXOStaSetDef   = 0;
        }

        $.ajax({
            type: "POST",
            url: "dcmTXOAdvanceTableShowColSave",
            data: {
                'tTXODocType'           : tTXODocType,
                'nTXOStaSetDef'         : nTXOStaSetDef,
                'aTXOColShowSet'        : aTXOColShowSet,
                'aTXOColShowAllList'    : aTXOColShowAllList,
                'aTXOColumnLabelName'   : aTXOColumnLabelName
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                $("#odvTXOOrderAdvTblColumns").modal("hide");
                $(".modal-backdrop").remove();
                JSvTXOLoadPdtDataTableHtml();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }
/** ===================================================================================================== */

/** =================================== Manage Product To Table DTTemp  ================================= */
    $('#obtTXODocBrowsePdt').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxTXOBrowsePdt();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Functionality: Browse Product Add Into Table DTTemp
    // Parameters: Event Click Browse Buttom
    // Creator: 16/05/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxTXOBrowsePdt(){
        var tTXOBchcode     = $('#oetTXOBchCode').val();
        var tTXOMchCode     = $('#oetTXOMchCode').val();
        var tTXOShpCodeFrom = $('#oetTXOShpCodeFrom').val();
        var tTXOShpCodeTo   = $('#oetTXOShpCodeTo').val();
        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                Qualitysearch   : ["NAMEPDT","CODEPDT"],
                PriceType       : ["Cost", "tCN_Cost", "PDTTWO", "1"],
                SelectTier      : ["Barcode"],
                ShowCountRecord : 10,
                NextFunc        : "JSvTXOPDTAddPdtIntoTableDT",
                ReturnType      : "M",
                BCH : [tTXOBchcode,tTXOBchcode],
                SHP : [tTXOShpCodeFrom,tTXOShpCodeFrom],
            },
            cache : false,
            timeout : 0,
            success: function (tResult) {
                //remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                $("#odvModalDOCPDT #odvModalsectionBodyPDT").html(tResult);
                $("#odvModalDOCPDT").modal({ backdrop: "static", keyboard: false });
                $("#odvModalDOCPDT").modal({ show: true });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Functionality: Add Pdt Tot Table DtTemp
    // Parameters: Event NextFunc Modal Product
    // Creator: 16/05/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSvTXOPDTAddPdtIntoTableDT(poPdtDataReturn){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            // JCNxOpenLoading();
            var tTXODocNo           = $("#oetTXODocNo").val();
            var tTXOBchCode         = $("#oetTXOBchCode").val();
            var tTXOVATInOrEx       = $("#ostTXOVATInOrEx").val();
            var tTXOOptionAddPdt    = $("#ocmTXOOptionAddPdt").val();
            $.ajax({
                type: "POST",
                url: "dcmTXOAddPdtIntoTableDTTmp",
                data: {
                    'ptTXODocType'          : tTXODocType,
                    'ptTXODocNo'            : tTXODocNo,
                    'ptTXOBchCode'          : tTXOBchCode,
                    'ptTXOVATInOrEx'        : tTXOVATInOrEx,
                    'ptTXOOptionAddPdt'     : tTXOOptionAddPdt,
                    'poTXOPdtDataReturn'    : poPdtDataReturn
                },
                cache: false,
                timeout: 0,
                success: function (oResult) {
                    JSvTXOLoadPdtDataTableHtml();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality: Edit Product In Dt Temp
    // Parameters: Event Click Button Edit
    // Creator: 17/05/2019 Wasin(Yoshi)
    // Return: Edit Inline In DT Temp
    // ReturnType: -
    function JSxTXOEditRowDTTmp(event){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tTXOEditSeqNo   = $(event).closest('.xCNDOCPdtItem').data('seqno');
            $("#otbTXODocPdtTable .xWShowInLine" + tTXOEditSeqNo).addClass("xCNHide");
            $("#otbTXODocPdtTable .xWEditInLine" + tTXOEditSeqNo).removeClass("xCNHide");
            $(event).parent().empty().append(
                $("<img>")
                .attr("class","xCNIconTable")
                .attr("title", "Save")
                .attr("src",tBaseURL+'/application/modules/common/assets/images/icons/save.png')
                .unbind()
                .click(function(){
                    JSxTXOSaveRowDTTmp(this);
                })
            );
            $("#otbTXODocPdtTable .xCNIconTable[title='Edit']").addClass('xCNDisabled').attr("onclick", "").unbind("click");
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality: Save Product IN Dt Temp
    // Parameters: Event Click Button Edit
    // Creator: 17/05/2019 Wasin(Yoshi)
    // Return: Save Inline In DT Temp
    // ReturnType: -
    function JSxTXOSaveRowDTTmp(event){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JCNxOpenLoading();
            var tTXODocNo       = $("#oetTXODocNo").val();
            var tTXOUsrBchCode  = $("#ohdTXOSesUsrBchCode").val();
            var tTXOPdtSeqNo    = $(event).closest('.xCNDOCPdtItem').data('seqno');
            var nTXOPdtValQty   = $(event).closest('.xCNDOCPdtItem').find("#ohdFCXtdQty"+tTXOPdtSeqNo).val();
            var aField = [];
            var aValue = [];
            $("#otbTXODocPdtTable .xWValueEditInLine" + tTXOPdtSeqNo).each(function (index) {
                tValue  = $(this).val();
                tField  = $(this).attr("data-field");
                $(".xWShowValue" + tField + tTXOPdtSeqNo).text(tValue);
                aField.push(tField);
                aValue.push(tValue);
            });
            $.ajax({
                type: "POST",
                url: "dcmTXOEditPdtIntoTableDTTmp",
                data: {
                    'ptTXODocType'      : tTXODocType,
                    'ptTXODocNo'        : tTXODocNo,
                    'ptTXOEditSeqNo'    : tTXOPdtSeqNo,
                    'paTXOFieldData'    : aField,
                    'paTXOValueData'    : aValue
                },
                cache: false,
                timeout: 0,
                success: function(oResult){
                    var aDataReturn = JSON.parse(oResult);
                    if(aDataReturn['nStaEvent'] == '1'){
                        JSvTXOLoadPdtDataTableHtml();
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
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality: Delete Product In Dt Temp
    // Parameters: Event Click Button Del
    // Creator: 17/05/2019 Wasin(Yoshi)
    // Return: Delete Product In Table DT Temp
    // ReturnType: -
    function JSxTXORemoveRowDTTmp(event){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var tTXODocNo       = $('#oetTXODocNo').val();
            var tTXOPdtCode     = $(event).closest('.xCNDOCPdtItem').data('pdtcode');
            var tTXOPdtSeqNo    = $(event).closest('.xCNDOCPdtItem').data('seqno');
            $.ajax({
                type: "POST",
                url: "dcmTXORemovePdtInDTTmp",
                data: {
                    'ptTXODocNo'    : tTXODocNo,
                    'ptTXOPdtCode'  : tTXOPdtCode,
                    'ptTXOPdtSeqNo' : tTXOPdtSeqNo
                },
                cache: false,
                timeout: 0,
                success: function (oResult) {
                    var aDataReturn = JSON.parse(oResult);
                    if(aDataReturn['nStaEvent'] == '1'){
                        JSvTXOLoadPdtDataTableHtml();
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
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality: Delete Mutiple Product In Dt Temp
    // Parameters: Event Click Button Del
    // Creator: 17/05/2019 Wasin(Yoshi)
    // Return: Delete Product In Table DT Temp
    // ReturnType: -
    function JSxTXORemoveMultiRowDTTmp(){
        var tTXOSeqNo   = $("#odvTXOModalDelPdtDTTemp #ohdTXOConfirmSeqDelete").val();
        var tTXODocNo   = $("#oetTXODocNo").val();
        // Seq No
        var tTXOTextSeq         = tTXOSeqNo.substring(0,tTXOSeqNo.length - 2);
        var aTXOSeqSplit        = tTXOTextSeq.split(" , ");
        var aTXOSeqSplitlength  = aTXOSeqSplit.length
        var aTXOSeqData         = [];
        for($i = 0; $i < aTXOSeqSplitlength; $i++){
            aTXOSeqData.push(aTXOSeqSplit[$i]);
        }

        if(aTXOSeqSplitlength > 1){
            localStorage.StaDeleteArray = "1";
            $.ajax({
                type: "POST",
                url: "dcmTXORemoveMultiPdtInDTTmp",
                data: {
                    'tTXODocType'   : tTXODocType,
                    'tTXODocNo'     : tTXODocNo,
                    'aTXOSeqData'   : aTXOSeqData
                },
                success: function (oResult){
                    setTimeout(function () {
                        $("#odvTXOModalDelPdtDTTemp").modal("hide");
                        $("#odvTXOModalDelPdtDTTemp #ospConfirmDelete").text($("#oetTextComfirmDeleteSingle").val());
                        $("#odvTXOModalDelPdtDTTemp #ohdTXOConfirmSeqDelete").val("");
                        $("#odvTXOModalDelPdtDTTemp #ohdTXOConfirmPdtDelete").val("");
                        $("#ohdTXOConfirmPdtDelete #ohdTXOConfirmPunDelete").val("");
                        $("#ohdTXOConfirmPdtDelete #ohdTXOConfirmDocDelete").val("");
                        localStorage.removeItem("LocalItemDataDelDtTemp");
                        $(".obtChoose").hide();
                        $(".modal-backdrop").remove();
                        JSvTXOLoadPdtDataTableHtml();
                    }, 1000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            localStorage.StaDeleteArray = "0";
            return false;
        }
    }


/** ===================================================================================================== */

// Functionality: Check Status Document Process EQ And Call Back MQ
// Parameters: Event Document Ready Load Page
// Creator: 29/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JSxTXOChkStaDocCallModalMQ(){
    // Switch DocType Valiable Document
    switch(tTXODocType){
        case 'WAH':
            var tTXOLangCode        = nLangEdits;
            var tTXOUsrBchCode      = $("#ohdTXOBchCode").val();
            var tTXOUsrApv          = $("#ohdTXOApvCodeUsrLogin").val();
            var tTXODocNo           = $("#oetTXODocNo").val();
            var tTXOPrefix          = "RESTWO";
            var tTXOStaApv          = $("#ohdTXOStaApv").val();
            var tTXOStaPrcStk       = $("#ohdTXOStaPrcStk").val();
            var tTXOStaDelMQ        = $("#ohdTXOStaDelMQ").val();
            var tTXOQName           = tTXOPrefix + "_" + tTXODocNo + "_" + tTXOUsrApv;
            var tTXOTableName       = "TCNTPdtTwoHD";
            var tTXOFieldDocNo      = "FTXthDocNo";
            var tTXOFieldStaApv     = "FTXthStaPrcStk";
            var tTXOFieldStaDelMQ   = "FTXthStaDelMQ";
        break;
        case 'BCH':

        break;
    }

    // MQ Message Config
    var poDocConfig = {
        tLangCode     : tTXOLangCode,
        tUsrBchCode   : tTXOUsrBchCode,
        tUsrApv       : tTXOUsrApv,
        tDocNo        : tTXODocNo,
        tPrefix       : tTXOPrefix,
        tStaDelMQ     : tTXOStaDelMQ,
        tStaApv       : tTXOStaApv,
        tQName        : tTXOQName
    };

    // RabbitMQ STOMP Config
    var poMqConfig = {
        host: 'ws://202.44.55.94:15674/ws',
        username: 'adasoft',
        password: 'adasoft',
        vHost: 'AdaPosV5.0'
    };

    // Update Status For Delete Qname Parameter
    var poUpdateStaDelQnameParams   = {
        ptDocTableName      : tTXOTableName,
        ptDocFieldDocNo     : tTXOFieldDocNo,
        ptDocFieldStaApv    : tTXOFieldStaApv,
        ptDocFieldStaDelMQ  : tTXOFieldStaDelMQ,
        ptDocStaDelMQ       : tTXOStaDelMQ,
        ptDocNo             : tTXODocNo
    };

    // Callback Page Control(function)
    var poCallback = {
        tCallPageEdit : "JSvTXOCallPageEdit",
        tCallPageList : "JSvTXOCallPageList"
    };

    // Check Show Progress %
    if(tTXODocNo != '' && (tTXOStaApv == 2 || tTXOStaPrcStk == 2)){
        FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
    }

    // Check Delete MQ SubScrib
    if(tTXOStaApv == 1 && tTXOStaPrcStk == 1 && tTXOStaDelMQ == ''){
        var poDelQnameParams    = {
            ptPrefixQueueName   : tTXOPrefix,
            ptBchCode           : tTXOUsrBchCode,
            ptDocNo             : tTXODocNo,
            ptUsrCode           : tTXOUsrApv
        };
        FSxCMNRabbitMQDeleteQname(poDelQnameParams);
        FSxCMNRabbitMQUpdateStaDeleteQname(poUpdateStaDelQnameParams);
    }
}



</script>