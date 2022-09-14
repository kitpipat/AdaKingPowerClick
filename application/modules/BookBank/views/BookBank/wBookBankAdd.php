<?php 
    $nDecimalShw = FCNxHGetOptionDecimalShow();

    // ตรวจสอบว่าเข้าหน้า Add หรือ edit
    if($aResult['rtCode'] == 1){

        $tBbkCode       = $aResult['raItems']['rtBbkCode'];
        $tBbkName       = $aResult['raItems']['rtBbkName'];
        $tBbkAccNo      = $aResult['raItems']['rtBbkAccNo'];
        $dBbkOpen       = $aResult['raItems']['rtBbkOpen'];
        $tBbkType       = $aResult['raItems']['rtBbkType'];
        $tBnkCode       = $aResult['raItems']['rtBnkCode'];
        $tBnkName       = $aResult['raItems']['rtBnkName'];
        $tBbkRmk        = $aResult['raItems']['rtBbkRmk'];
        $tStaActive     = $aResult['raItems']['rtBbkStaActive'];
        $tBbkBranch     = $aResult['raItems']['rtBbkBranch'];
        $dBbkUpd        = $aResult['raItems']['rtBbkUpd'];
        $tBbkBalance    = $aResult['raItems']['rtBbkBalance'];
        $tBchCode       = $aResult['raItems']['rtBchCode'];
        $tBchName       = $aResult['raItems']['rtBchName'];
        $tMerCode       = $aResult['raItems']['rtMerCode'];
        $tMerName       = $aResult['raItems']['rtMerName'];

        if($dBbkUpd != ""){
            $dNewBbkUpd = date("d/m/Y H:i:s", strtotime($dBbkUpd));
        }else{
            $dNewBbkUpd = date("d/m/Y H:i:s");
        }

        if($tBbkBalance != ""){
            $tBalance =  number_format($tBbkBalance,$nDecimalShw);
        }else{
            $tBalance =  "0.00";
        }

        $tRoute         = "BookBankEventEditContentDetail";

    }else{

        $tBbkCode       = "";
        $tBbkName       = "";
        $tBbkAccNo      = "";
        $tBbkType       = "";
        $tBnkCode       = "";
        $tBnkName       = "";
        $tBbkRmk        = "";
        $tStaActive     = "";
        $tBbkBranch     = "";
        $tBchCode       = "";
        $tBchName       = "";

        // if($this->session->userdata("tSesUsrLevel") != 'HQ'){
            $tBchCode       = $this->session->userdata("tSesUsrBchCodeDefault");
            $tBchName       = $this->session->userdata("tSesUsrBchNameDefault");
            
        // }
        $tMerCode       = "";
        $tMerName       = "";
        $tBalance       = "0.00";
        $dBbkOpen       = date('Y-m-d', strtotime('+1 year'));
        $dNewBbkUpd     = date("d/m/Y H:i:s");

        $tRoute         = "BookBankEventAddContentDetail";
    }
?>
<style>
    .xCNPanelBbkUpd{
        border-bottom:1px solid #cfcbcb8a !important;
        border-top:1px solid #cfcbcb8a !important;
        align-content: center;
        padding: 6px 0px 0px 0px;
    }
</style>
<div class="panel-body" style="padding-top:20px !important;">
    <div class="row">
        <div class="col-sm-12">
            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                <ul class="nav" role="tablist">
                <li id="oliBBKDetail" class="xCNSHPTab active" data-typetab="main" data-tabtitle="shpinfo">
                    <a role="tab" data-toggle="tab" data-target="#odvBBKContentDetail" aria-expanded="true">
                    <?php echo language('bookbank/bookbank/bookbank','tBBKTableGeneralInformation');?>
                    </a>
                </li>
                    <!-- <li id="oliBBKAccountActivity" class="xCNSHPTab" data-typetab="main" data-tabtitle="bbkActivity">
                        <a role="tab" data-toggle="tab" data-target="#odvBBKContentAccountActivity" aria-expanded="true">
                            <?php echo language('bookbank/bookbank/bookbank','tBBKTableAccountActivity');?>
                        </a>
                    </li> -->
                </ul>
            </div>
                <div class="tab-content">
                    <!-- Tab ข้อมูลทั่วไป -->
                    <div id="odvBBKContentDetail" class="tab-pane fade active in">
                        <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddBookbank">
                        <input id="ohdOldBchCode" name="ohdOldBchCode" type="hidden" value="<?php echo $tBchCode; ?>"><?php // Branch code เดิมที่กำลังจะแก้ไข ไว้อ้างอิงในคำสั่ง sql. 08/04/2020 surawat ?>
                        <input id="ohdOldBbkCode" name="ohdOldBbkCode" type="hidden" value="<?php echo $tBbkCode; ?>"><?php // Cheque code เดิมที่กำลังจะแก้ไข ไว้อ้างอิงในคำสั่ง sql. 08/04/2020 surawat ?>
                            <button style="display:none" type="submit" id="obtSubmitBookBank" onclick="JSnAddEditBookbank('<?php echo $tRoute; ?>');"></button>
                                <div class="row" style="margin-top:2%;padding:10px;">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding:0px;">
                                    <!-- Panel ยอกเงินคงเหลือ -->
                                    <div id="" class="panel panel-default">
                                        <div class="panel-collapse collapse in" role="tabpanel">
                                            <div class="panel-body" style="padding-bottom:15px;">
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-l-0 text-left">
                                                    <label class="xCNTextDetail1">
                                                       <h3><?php echo  language('bookbank/bookbank/bookbank', 'tBBKTableLatestBalance'); ?><h3>
                                                    </label>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                <?php if($tRoute == "BookBankEventAddContentDetail") :?>
                                                    <i class="fa fa-refresh xWDSHSALFilter"  aria-hidden="true" data-keyfilter="FBA"></i>
                                                <?php else:?>
                                                    <i class="fa fa-refresh xWDSHSALFilter" style="cursor: pointer !important;" onClick="JSvCallPageBookBankEdit('<?php echo $tBbkCode;?>','<?php echo $tBbkType; ?>','<?php echo $tStaActive;?>','<?php echo $tBchCode; ?>')" aria-hidden="true" data-keyfilter="FBA"></i>
                                                <?php endif;?>
                                                </div>
                                                <div class="text-right"style="margin-top:50px;"><h1><?php echo $tBalance; ?></h1></div>
                                                <div class="" style="margin-bottom:60px;"> 
                                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-l-0 text-left xCNPanelBbkUpd">
                                                        <label class="xCNTextDetail1"> <h3><?php echo  language('bookbank/bookbank/bookbank', 'tBBKTableLatestUpdate'); ?> </h3></label>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right xCNPanelBbkUpd" >
                                                        <label class="xCNTextDetail1"><?php echo $dNewBbkUpd;?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

                                <!-- รหัสสมุดบัญชี -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo  language('bookbank/bookbank/bookbank', 'tBBKTableBbkCode'); ?></label>
                                    <div id="odvBbkAutoGenCode" class="form-group">
                                        <div class="validate-input">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbBookbankAutoGenCode" name="ocbBookbankAutoGenCode" checked="true" value="1">
                                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="odvBbkCodeForm" class="form-group">
                                        <input type="hidden" id="ohdCheckDuplicateBbkCode" name="ohdCheckDuplicateBbkCode" value="1"> 
                                            <div class="validate-input">
                                            <input 
                                            type="text" 
                                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                            maxlength="5" 
                                            id="oetBbkCode" 
                                            name="oetBbkCode"
                                            value="<?php echo @$tBbkCode;?>"
                                            autocomplete="off"
                                            data-is-created="<?php echo @$tBbkCode;?>"
                                            placeholder="<?php echo  language('bookbank/bookbank/bookbank','tBBKTableBbkCode')?>"
                                            data-validate-required = "<?php echo  language('bookbank/bookbank/bookbank','tBBKValidCode')?>"
                                            data-validate-dublicateCode = "<?php echo  language('bookbank/bookbank/bookbank','tBBKValidCheckCode')?>"
                                            >
                                        </div>
                                    </div>
                                </div>
                                <!-- end รหัสสมุดบัญชี -->
                                
                                <!-- ชื่อบัญชีเงินฝาก -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo  language('bookbank/bookbank/bookbank', 'tBBKTableNameBookbank'); ?></label>
                                        <input class="form-control" type="text" name="oetBbkName" id="oetBbkName" value="<?php echo @$tBbkName; ?>" 
                                            maxlength="50"autocomplete="off" placeholder="<?php echo  language('bookbank/bookbank/bookbank', 'tBBKTableNameBookbank'); ?>"
                                            data-validate-required = "<?php echo  language('bookbank/bookbank/bookbank','tBBKValidName')?>"
                                        >
                                </div>
                                <!-- end ชื่อบัญชีเงินฝาก -->

                                <!-- เลขบัญชีเงิน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo  language('bookbank/bookbank/bookbank', 'tBBKTableAccountNumber'); ?></label>
                                        <input class="form-control" type="text" name="oetBbkAccNo" id="oetBbkAccNo" value="<?php echo @$tBbkAccNo; ?>" 
                                            maxlength="50"autocomplete="off" placeholder="<?php echo  language('bookbank/bookbank/bookbank', 'tBBKTableAccountNumber'); ?>"
                                            data-validate-required = "<?php echo  language('bookbank/bookbank/bookbank','tBBKValidID')?>"
                                    >
                                </div>
                                <!-- end เลขบัญชีเงิน -->

                                <!-- Browse สาขา -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('bookbank/bookbank/bookbank','tBBKTablebanch')?></label>
                                        <div class="input-group">
                                        <input  type="text" 
                                                class="form-control xCNHide" 
                                                id="oetBbkBchCode" 
                                                name="oetBbkBchCode" 
                                                value="<?php echo $tBchCode;?>"
                                                <?php echo !empty($tBchCode) ? 'readonly' : '' ; ?>
                                                >
                                        <input  type="text" 
                                                class="form-control xWPointerEventNone" 
                                                id="oetBbkBchName" 
                                                name="oetBbkBchName" 
                                                value="<?php echo $tBchName;?>" 
                                                data-validate-required = "<?php echo language('bookbank/bookbank/bookbank','tBBKValidBanch')?>"
                                                readonly>
                                        <span class="input-group-btn">
                                            <button id="obtBrowseBch" 
                                                    type="button" 
                                                    class="btn xCNBtnBrowseAddOn"
                                                >
                                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- end Browse สาขา -->

                                <!-- Browse กลุ่มธุรกิจ  -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('bookbank/bookbank/bookbank','tBBKTableMerChant')?></label>
                                        <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetBbkMerCode" name="oetBbkMerCode" value="<?php echo $tMerCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetBbkMerName" name="oetBbkMerName"  value="<?php echo $tMerName;?>"
                                        data-validate-required = "<?php echo language('bookbank/bookbank/bookbank','tBBKValidBanch')?>"
                                        readonly>
                                        <span class="input-group-btn">
                                            <button id="obtBrowseMer" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- end Browse กลุ่มธุรกิจ -->

                                <!-- ประเภทบัญชี -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('bookbank/bookbank/bookbank','tBBKTableType')?></label>
                                    <select class="selectpicker form-control" id="ocmBbkType" name="ocmBbkType" maxlength="1" readonly>
                                        <option value="1"><?php echo language('bookbank/bookbank/bookbank', 'tBBKTableType1') ?></option>
                                        <option value="2"><?php echo language('bookbank/bookbank/bookbank', 'tBBKTableType2') ?></option>
                                        <option value="3"><?php echo language('bookbank/bookbank/bookbank', 'tBBKTableType3') ?></option>
                                    </select>
                                </div>
                                <!-- end ประเภทบัญชี -->

                                <!-- ธนาคาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('bookbank/bookbank/bookbank','tBBKTableBank')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="ohdBnkCode" name="ohdBnkCode" value="<?php echo @$tBnkCode;?>">
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetBnkName" name="oetBnkName" value="<?php echo @$tBnkName;?>" readonly
                                            >
                                        <span class="input-group-btn">
                                        <button id="obtBrowseBnk" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="  <?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- end ธนาคาร -->

                                <!-- สาขาธนาคาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo  language('bookbank/bookbank/bookbank', 'tBBKTablebanchBank'); ?></label>
                                        <input class="form-control" type="text" name="oetBbkBranch" id="oetBbkBranch" value="<?php echo @$tBbkBranch; ?>" 
                                            maxlength="50"autocomplete="off" placeholder="<?php echo  language('bookbank/bookbank/bookbank', 'tBBKTablebanchBank'); ?>"
                                        >
                                </div>
                                <!-- end สาขาธนาคาร -->

                                <!-- วันที่เปิดบัญชี -->
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tShpStart')?></label>
                                                    <div class="input-group">
                                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center" id="oetBbkOpen" name="oetBbkOpen" value="<?php echo $dBbkOpen;?>" >
                                                        <span class="input-group-btn">
                                                            <button id="obtOpenStart" type="button" class="btn xCNBtnDateTime">
                                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end วันที่เปิดบัญชี -->

                                <!-- หมายเหตุ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('creditcard/creditcard/creditcard','tCDCRmk'); ?></label>
                                    <textarea class="form-group" rows="5" placeholder="<?php echo language('creditcard/creditcard/creditcard','tCDCRmk'); ?>" maxlength="100" id="oetBbkRmk" name="oetBbkRmk" autocomplete="off"   placeholder="<?php echo language('payment/cardlogin/cardlogin','tCrdLRemark')?>"><?php echo @$tBbkRmk;?></textarea>
                                </div>
                                <!-- end หมายเหตุ -->

                                <!-- ใช้งาน -->
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbStaActive" name="ocbStaActive" checked="true" value="1">
                                        <span> <?php echo language('bookbank/bookbank/bookbank', 'tBBKTableActivate1'); ?></span>
                                    </label> 
                                </div>
                                <!-- end ใช้งาน -->
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                <!-- end Tab ข้อมูลทั่วไป -->    
                        
                    <!-- Tab ความเคลื่อนไหวบัญชี -->
                    <div id="odvBBKContentAccountActivity" class="tab-pane fade">
                        222
                    </div>

                </div>

                </div>
            </div>
        </div>
    </div>
<?php include "script/jBookBankAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>

  $('.selectpicker').selectpicker();

  $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
    
  $('#obtOpenStart').click(function(event){
        $('#oetBbkOpen').datepicker('show');
    });

//Set Lang Edit 
var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;

var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
var tWhere = "";
// $(document).ready(function () {

    // if(tUsrLevel == 'BCH' || tUsrLevel == 'SHP'){
    //     $('#obtBrowseMer').attr("disabled", true);
        // $('#oimBrowseBranch').attr("disabled", true);
    // }else{
    //     $('#obtBrowseMer').attr("disabled", false);
    // }
// });
if( nCountBch == 1 ){
    $('#obtBrowseBch').attr('disabled',true);
}
if(tUsrLevel != "HQ"){
    tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
}else{
    tWhere = "";
}

$('#obtBrowseBnk').click(function(e){
    e.preventDefault();
    var nStaSession  = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JSxCheckPinMenuClose();
        window.oBrowseBnkOption  = oCrdBrowseBnk({
            'tReturnInputCode'  : 'ohdBnkCode',
            'tReturnInputName'  : 'oetBnkName',
            'tParamsAgnCode'    : '<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>'
        });
        JCNxBrowseData('oBrowseBnkOption');
    }else{
        JCNxShowMsgSessionExpired();
    }
});


var oCrdBrowseBnk = function(poReturnInput){
    var tInputReturnCode    = poReturnInput.tReturnInputCode;
    var tInputReturnName    = poReturnInput.tReturnInputName;
    var tParamsAgnCode      = poReturnInput.tParamsAgnCode
    var tWhereBnk           = "";

    if( tParamsAgnCode != "" ){
        tWhereBnk = " AND ( TFNMBank.FTAgnCode = '"+tParamsAgnCode+"' OR ISNULL(TFNMBank.FTAgnCode,'') = '' ) ";
    }

    var oOptionReturn = {
        Title : ['bank/bank/bank','tBNKTitle'],
        Table:{Master:'TFNMBank',PK:'FTBnkCode'},
        Join :{
            Table:	['TFNMBank_L'],
            On:['TFNMBank_L.FTBnkCode = TFNMBank.FTBnkCode AND TFNMBank_L.FNLngID = '+nLangEdits,]
        },
        Where : {
            Condition : [ tWhereBnk ]
        },
        GrideView:{
            ColumnPathLang	: 'bank/bank/bank',
            ColumnKeyLang	: ['tBNKCode', 'tBNKName'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TFNMBank.FTBnkCode','TFNMBank_L.FTBnkName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 10,
            OrderBy			: ['TFNMBank.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: [tInputReturnCode,"TFNMBank.FTBnkCode"],
            Text		: [tInputReturnName,"TFNMBank_L.FTBnkName"],
        },
        RouteAddNew : 'bankindex',
        BrowseLev : 0

    }
    return oOptionReturn;
}


// Option Branch
var oBrowseBch = {
        
        Title : ['company/branch/branch','tBCHTitle'],
        Table:{Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join :{
            Table:	['TCNMBranch_L'],
            On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
        },
        Where : {
                        Condition : [tWhere]
                    },
        GrideView:{
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBCHCode','tBCHName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['',''],
            Perpage			: 10,
            OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
            // SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetBbkBchCode","TCNMBranch.FTBchCode"],
            Text		: ["oetBbkBchName","TCNMBranch_L.FTBchName"],
        },
        RouteAddNew : 'branch',
        BrowseLev : 0

    }

// Option Merchant

var oBrowseMer = {
        Title : ['company/merchant/merchant','tMerchantTitle'],
        Table:{Master:'TCNMMerchant',PK:'FTMerCode'},
        Join :{
            Table:	['TCNMMerchant_L'],
            On:['TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'company/merchant/merchant',
            ColumnKeyLang	: ['tMerCode','tMerName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
            DataColumnsFormat : ['',''],
            Perpage			: 10,
            OrderBy			: ['TCNMMerchant.FDCreateOn DESC'],
            // SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetBbkMerCode","TCNMMerchant.FTMerCode"],
            Text		: ["oetBbkMerName","TCNMMerchant_L.FTMerName"],
        },
        RouteAddNew : 'merchant',
        BrowseLev : 0
    }


//Set Event Browse 
$('#obtBrowseBch').click(function(){JCNxBrowseData('oBrowseBch')});
$('#obtBrowseMer').click(function(){JCNxBrowseData('oBrowseMer')});

</script>
