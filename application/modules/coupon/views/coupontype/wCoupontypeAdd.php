<?php
// print_r($aResult['raItems']);
if($aResult['rtCode'] == "1"){
	$tCptCode = $aResult['raItems']['rtCptCode'];
	$tCptName = $aResult['raItems']['rtCptName'];
    $tCptStaUse = $aResult['raItems']['rtCptStaUse'];
    $tCptStaCouponType = $aResult['raItems']['rtCptType'];
    $tCptStaChk = $aResult['raItems']['rtCptStaChk'];
    $tCptStaChkHq = $aResult['raItems']['rtCptStaChkHQ'];
    $tCptRemark = $aResult['raItems']['rtCptRemark'];

    $tUsrAgnCode = $aResult['raItems']['rtAgnCode'];
    $tUsrAgnName = $aResult['raItems']['rtAgnName'];

	$tRoute = "CoupontypeEventEdit";

	//Event Control
	if(isset($aAlwEventVoucher)){
		if($aAlwEventVoucher['tAutStaFull'] == 1 || $aAlwEventVoucher['tAutStaEdit'] == 1){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
	}
	//Event Control
	
}else{
    $tCptCode = "";
	$tCptName = "";
    $tCptStaUse = "1";
    $tCptStaCouponType = "";
    $tCptStaChk = "";
    $tCptRemark = "";
    $tCptStaChkHq = "";
    $nAutStaEdit = 0; //Event Control
    
    $tUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
    $tUsrAgnName = $this->session->userdata("tSesUsrAgnName");
    
    $tRoute = "CoupontypeEventAdd";
}
?>
<input type="hidden" id="ohdVocAutStaEdit" value="<?=$nAutStaEdit?>">
    <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddCoupontype">
        <button style="display:none" type="submit" id="obtSubmitCoupontype" onclick="JSnAddEditCoutype('<?= $tRoute?>')"></button>
        <div class="panel-body" style="padding-top:20px !important;">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <button style="display:none" type="submit" id="obtSubmitPaymentMethod"></button>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('coupon/coupontype/coupontype','tCPTTBCode')?><?= language('coupon/coupontype/coupontype','tCPTTitle')?></label>
                        <div id="odvCoupontypeAutoGenCode" class="form-group">
                            <div id="odvCoupontypeAutoGenCode" class="form-group">
                                <div class="validate-input">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbCoupontypeAutoGenCode" name="ocbCoupontypeAutoGenCode" checked="true" value="1">
                                        <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                    <label>
                                </div> 
                            </div>
                        </div>

                        <div id="odvCoupontypeCodeForm" class="form-group">
                            <input type="hidden" id="ohdCheckDuplicateCptCode" name="ohdCheckDuplicateCptCode" value="1">  
                            <div class="validate-input">
                                <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                    maxlength="5" 
                                    id="oetCptCode" 
                                    name="oetCptCode"
                                    data-is-created="<?php echo $tCptCode;?>"
                                    placeholder="<?php echo language('coupon/coupontype/coupontype' ,'tCptValidCode')?>"
                                    value="<?php echo $tCptCode; ?>" 
                                    data-validate-required = "<?php echo language('coupon/coupontype/coupontype','tCPTValidCheckCode')?>"
                                    data-validate-dublicateCode = "<?php echo language('coupon/coupontype/coupontype','tCPTValidCheckCode')?>"
                                >
                            </div>
                        </div>

                         <!-- ชื่อประเภทคูปอง -->
                         <div class="form-group">
                             <div class="validate-input">
                                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('coupon/coupontype/coupontype','tCPTTBName')?></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    maxlength="100" 
                                    id="oetCptName" 
                                    name="oetCptName"
                                    placeholder="<?php echo language('coupon/coupontype/coupontype' ,'tCPTNameType')?>"
                                    value="<?php echo $tCptName;?>" 
                                    data-validate-required = "<?php echo language('coupon/coupontype/coupontype','tCptValidName')?>"
                                >
                             </div>
                         </div>

                        <!-- Agency -->
                        <div class="<?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main','tAgency')?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide" id="oetCPTUsrAgnCode"
                                        name="oetCPTUsrAgnCode" value="<?=@$tUsrAgnCode?>">
                                    <input type="text" class="form-control xWPointerEventNone" id="oetCPTUsrAgnName"
                                        name="oetCPTUsrAgnName"
                                        placeholder="<?php echo language('common/main/main','tAgency')?>"
                                        value="<?=@$tUsrAgnName?>" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtCPTUsrBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img
                                                src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- end Agency -->

                        <!-- ประเภทคูปอง -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('coupon/coupontype/coupontype','tCPTType');?></label>
                            <select  required  class="selectpicker form-control" id="ocmCptStatus" name="ocmCptStatus">
                                    <option value='1' <?php echo  (isset($tCptStaCouponType) && !empty($tCptStaCouponType) && $tCptStaCouponType == '1')? "selected":""?>>
                                        <?php echo language('coupon/coupontype/coupontype','tCPTCouponType1')?>
                                    </option>
                                    <option value='2' <?php echo  (isset($tCptStaCouponType) && !empty($tCptStaCouponType) && $tCptStaCouponType == '2')? "selected":""?>>
                                        <?php echo language('coupon/coupontype/coupontype','tCPTCouponType2')?>
                                    </option>
                            </select>
                        </div>

                        <!-- สถานะตรวจสอบคูปอง -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('coupon/coupontype/coupontype','tCPTStaChk');?></label>
                            <select  required  class="selectpicker form-control" id="ocmCptStatusChk" name="ocmCptStatusChk">
                                <option value='1' <?php echo  (isset($tCptStaChk) && !empty($tCptStaChk) && $tCptStaChk == '1')? "selected":""?>>
                                    <?php echo language('coupon/coupontype/coupontype','tCPTCouponChk1')?>
                                </option>
                                <option value='2' <?php echo  (isset($tCptStaChk) && !empty($tCptStaChk) && $tCptStaChk == '2')? "selected":""?>>
                                    <?php echo language('coupon/coupontype/coupontype','tCPTCouponChk2')?>
                                </option>
                            </select>
                        </div>

                        <!-- ใช้ตรวจสอบสาขา -->
                        <div class="form-group"> 
                            <label class="xCNLabelFrm"><?php echo language('coupon/coupontype/coupontype','tCPTStaChkHQ');?></label>
                            <select  required  class="selectpicker form-control" id="ocmCptStatusChkHq" name="ocmCptStatusChkHq">
                                <option value='2' <?php echo  (isset($tCptStaChkHq) && !empty($tCptStaChkHq) && $tCptStaChkHq == '2')? "selected":""?>>
                                    <?php echo language('coupon/coupontype/coupontype','tCPTCouponBch')?>
                                </option>
                                <option value='1' <?php echo  (isset($tCptStaChkHq) && !empty($tCptStaChkHq) && $tCptStaChkHq == '1')? "selected":""?>>
                                    <?php echo language('coupon/coupontype/coupontype','tCPTCouponHq')?>
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?php echo language('authen/department/department','tDPTRemark')?></label>
                                <textarea class="form-control" maxlength="100" rows="4" id="otaCptRemark" name="otaCptRemark"><?= $tCptRemark?></textarea>
                            </div>
                        </div>

                        <!-- สถาณะใช้งาน -->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <input 
                                type="checkbox" 
                                id="ocbCptcheck" 
                                name="ocbCptcheck"
                                <?php echo ($tCptStaUse == "1")?"checked":""; ?>  
                                value="1">
                                <span><?php echo language('coupon/coupontype/coupontype','tCptStaUse');?></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php include "script/jCoupontypeAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
    // ****************************************************
        // Create By Witsarut 25/10/2019
        $('#ocmCptStatus').selectpicker();
        $('#ocmCptStatusChk').selectpicker();
        $('#ocmCptStatusChkHq').selectpicker();
    // ****************************************************

    $(document).ready(function(){
        $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
        $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
        
        $('#oetVocExpired').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            startDate :'1900-01-01',
            disableTouchKeyboard : true,
            autoclose: true,
        });
        $('#oetVocExpired').click(function(event){
            $('#oetVocExpired').datepicker('show');
            event.preventDefault();
        });
        $('#obtVocExpired').click(function(event){
            $('#oetVocExpired').datepicker('show');
            event.preventDefault();
        });
    });

    //Lang Edit In Browse
    var nLangEdits = "<?=$this->session->userdata("tLangEdit")?>";
    //Set Option Browse -----------
    //Option Depart
    var oVocBrowseVot = {
        Title : ['coupon/coupontype/coupontype','tVOTTitle'],
        Table:{Master:'TFNMCouponType',PK:'FTCptCode'},
        Join :{
            Table:	['TFNMCouponType_L'],
            On:['TFNMCouponType_L.FTCptCode = TFNMCouponType.FTCptCode AND TFNMCouponType_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'promotion/voucher/vouchertype',
            ColumnKeyLang	: ['FTCptCode','FTCptName'],
            DataColumns		: ['TFNMCouponType.FTCptCode','TFNMCouponType_L.FTCptName'],
            ColumnsSize     : ['20%','80%'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TFNMCouponType.FTCptCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["ohdCptCode","TFNMCouponType.FTCptCode"],
            Text		: ["oetCptName","TFNMCouponType_L.FTCptName"],
        },
        BrowseLev : 1
    }
    //Event Browse
    $('#obtVocBrowseVot').click(function(){JCNxBrowseData('oVocBrowseVot');});
</script>