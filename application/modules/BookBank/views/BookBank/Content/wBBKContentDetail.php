
<style>
    .xCNPanelBbkUpd{
        border-bottom:1px solid #cfcbcb8a !important;
        border-top:1px solid #cfcbcb8a !important;
        align-content: center;
        padding: 6px 0px 0px 0px;
    }
</style>


<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddBookbank">
<button style="display:none" type="submit" id="obtSubmitBookBank" onclick="JSnAddEditBookbank('BookBankEventAddContentDetail');"></button>
<div class="row" style="margin-top:2%;padding:10px;">

    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding:0px;">
        <!-- Panel ยอกเงินคงเหลือ -->
        <div id="" class="panel panel-default">
            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body" style="padding-bottom:15px;">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-l-0 text-left">
                        <label class="xCNTextDetail1">ยอดเงินคงเหลือล่าสุด</label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                        <i class="fa fa-refresh xWDSHSALFilter" aria-hidden="true" data-keyfilter="FBA"></i>
                    </div>
                    <div class="text-right"style="margin-top:50px;"><h1>0.00</h1></div>
                    <div class="" style="margin-bottom:60px;"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-l-0 text-left xCNPanelBbkUpd">
                            <label class="xCNTextDetail1">ปรับปรุงล่าสุด</label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right xCNPanelBbkUpd" >
                            <label class="xCNTextDetail1">30/01/2020 18:00:00</label>
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
                        <div id="odvAgnAutoGenCode" class="form-group">
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
                                value=""
                                autocomplete="off"
                                data-is-created=""
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
                    <input class="form-control" type="text" name="oetBbkAccNo" id="oetBbkAccNo" value="<?php echo @$tBbkName; ?>" 
                     maxlength="50"autocomplete="off" placeholder="<?php echo  language('bookbank/bookbank/bookbank', 'tBBKTableAccountNumber'); ?>"
                    data-validate-required = "<?php echo  language('bookbank/bookbank/bookbank','tBBKValidID')?>"
                    >
        </div>
        <!-- end เลขบัญชีเงิน -->

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
                    <label class="xCNLabelFrm"> <?= language('bookbank/bookbank/bookbank','tBBKTableBank')?></label>
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
                    <input class="form-control" type="text" name="oetBbkBranch" id="oetBbkBranch" value="<?php echo @$tBbkName; ?>" 
                     maxlength="50"autocomplete="off" placeholder="<?php echo  language('bookbank/bookbank/bookbank', 'tBBKTablebanchBank'); ?>"
                    >
        </div>
        <!-- end สาขาธนาคาร -->

        <!-- วันที่เปิดบัญชี -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tShpStart')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center" id="oetBbkOpen" name="oetBbkOpen" value="" >
                            <span class="input-group-btn">
                                <button id="obtOpenStart" type="button" class="btn xCNBtnDateTime">
                                <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        <!-- end วันที่เปิดบัญชี -->

        <!-- หมายเหตุ -->
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('creditcard/creditcard/creditcard','tCDCRmk'); ?></label>
            <textarea class="form-group" rows="5" placeholder="<?php echo language('creditcard/creditcard/creditcard','tCDCRmk'); ?>" maxlength="100" id="oetBbkRmk" name="oetBbkRmk" autocomplete="off"   placeholder="<?php echo language('payment/cardlogin/cardlogin','tCrdLRemark')?>"><?php echo @$tCrdRmk;?></textarea>
        </div>
        <!-- end หมายเหตุ -->

        <!-- ใช้งาน -->
        <div class="form-group">
            <label class="fancy-checkbox">
                <input type="checkbox" id="ocbStaActive" name="ocbStaActive" checked="true" value="1">
                <span> <?php echo language('bookbank/bookbank/bookbank', 'tBBKTableUse'); ?></span>
            </label> 
        </div>
        <!-- end ใช้งาน -->
            
        </div>
    </div>
</div>
<?php include "script/jBookBankContent.php"; ?>
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
//Option Branch
var oCrdBrowseBnk = {

	Title : ['bank/bank/bank','tBNKTitle'],
	Table:{Master:'TFNMBank',PK:'FTBnkCode'},
	Join :{
		Table:	['TFNMBank_L'],
		On:['TFNMBank_L.FTBnkCode = TFNMBank.FTBnkCode AND TFNMBank_L.FNLngID = '+nLangEdits,]
	},
	GrideView:{
		ColumnPathLang	: 'bank/bank/bank',
		ColumnKeyLang	: ['tBNKCode','tBNKName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TFNMBank.FTBnkCode','TFNMBank_L.FTBnkName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TFNMBank_L.FTBnkName'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["ohdBnkCode","TFNMBank.FTBnkCode"],
		Text		: ["oetBnkName","TFNMBank_L.FTBnkName"],
	},
	RouteAddNew : 'bankindex',
	BrowseLev : nStaCdcBrowseType
}
//Set Event Browse 
$('#obtBrowseBnk').click(function(){JCNxBrowseData('oCrdBrowseBnk');});

</script>


