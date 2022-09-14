<?php
if($aResult['rtCode'] == "1"){
	$tCrdCode       = $aResult['raItems']['rtCrdCode'];
	$tBnkCode       = $aResult['raItems']['rtBnkCode'];
	$tBnkName       = $aResult['raItems']['rtBnkName'];
	$tCrdChgPer     = $aResult['raItems']['rtCrdChgPer'];
	$tCrdFmt        = $aResult['raItems']['rtCrdCrdFmt'];
	$tCrdName       = $aResult['raItems']['rtCrdName'];
	$tCrdRmk       	= $aResult['raItems']['rtCrdRmk'];
    $tRoute         = "creditcardEventEdit";
    // $tchecked1      = "checked";
    // $tchecked2      = "";
    // $tchecked3      = "";
    // $tchecked4      = "";
    // $tchecked5      = "";
    // $tchecked6      = "";
    // $tchecked7      = "";
    // $tchecked8      = "";
    // $tcheckImg      = "";
    // $tStyleImg      = "";
    
    $tUsrAgnCode        = $aResult['raItems']['rtAgnCode'];
    $tUsrAgnName        = $aResult['raItems']['rtAgnName'];
    $tImgObj            = $aResult['raItems']['rtImgObj'];


	//Event Control
	if(isset($aAlwEventCreditcard)){
		if($aAlwEventCreditcard['tAutStaFull'] == 1 || $aAlwEventCreditcard['tAutStaEdit'] == 1){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
    }
    
    //Event Control
    // if(isset($tImgName) && !empty($tImgName)){
    //     switch ($tImgName) {
    //         case 'blue406306.png':
    //                 $tchecked1 = 'checked';
    //                 $tcheckImg = "1";
    //                 $tStyleImg = "border-radius: 50%; width: 50%";
    //             break;    
    //         case 'blue406256.png';
    //                 $tchecked2 = 'checked';
    //                 $tcheckImg = "1";
    //                 $tStyleImg = "border-radius: 50%; width: 50%";
    //             break;
    //         case 'Brown4097583.png':
    //                 $tchecked3 = 'checked'; 
    //                 $tcheckImg = "1";
    //                 $tStyleImg = "border-radius: 50%; width: 50%";
    //             break;
    //         case 'green407354.png':
    //                 $tchecked4 = 'checked'; 
    //                 $tcheckImg = "1";
    //                 $tStyleImg = "border-radius: 50%; width: 50%";
    //             break;
    //         case 'orange402021.png':
    //                 $tchecked5 = 'checked';
    //                 $tcheckImg = "1";
    //                 $tStyleImg = "border-radius: 50%; width: 50%";
    //             break;
    //         case 'purple40506.png':
    //                 $tchecked6 = 'checked';
    //                 $tcheckImg = "1";
    //                 $tStyleImg = "border-radius: 50%; width: 50%";
    //             break;
    //         case 'red40303.png':
    //                 $tchecked7 = 'checked';
    //                 $tcheckImg = "1";
    //                 $tStyleImg = "border-radius: 50%; width: 50%";
    //         break;
    //         case 'black40811.png':
    //                 $tchecked8 = 'checked';
    //                 $tcheckImg = "1";
    //                 $tStyleImg = "border-radius: 50%; width: 50%";
    //         break;
    //     }
    // }
	
}else{
    $tCrdCode       = "";
    $tBnkCode       = "";
	$tBnkName       = "";
	$tCrdChgPer     = "";
	$tCrdFmt        = "";
	$tCrdName       = "";
	$tCrdRmk        = "";
    $tRoute         = "creditcardEventAdd";
    $tImgObj        = "";
    // $tchecked1      = "checked";
    // $tchecked2      = "";
    // $tchecked3      = "";
    // $tchecked4      = "";
    // $tchecked5      = "";
    // $tchecked6      = "";
    // $tchecked7      = "";
    // $tchecked8      = "";
    // $tcheckImg      = "";
    // $tStyleImg      = "";

    $tUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
    $tUsrAgnName = $this->session->userdata("tSesUsrAgnName");
	$nAutStaEdit = 0; //Event Control
}
// $ocheck = base_url().'application/modules/common/assets/images/icons/check.png';

$nDecimalShw = FCNxHGetOptionDecimalShow();

?>

<style type="text/css">

/* .xCNCustomRadios div {
  display: inline-block;
}
.xCNCustomRadios input[type="radio"] {
  display: none;
}
.xCNCustomRadios input[type="radio"] + label {
  color: #333;
  font-family: Arial, sans-serif;
  font-size: 14px;
}
.xCNCustomRadios input[type="radio"] + label span {
  width: 40px;
  height: 40px;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor: pointer;
  border-radius: 50%;
  border: 2px solid #FFFFFF;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
  background-repeat: no-repeat;
  background-position: center;
  text-align: center;
  line-height: 44px;
}
.xCNCustomRadios input[type="radio"] + label span img {
  opacity: 0;
  transition: all .3s ease;
}
.xCNCustomRadios input[type="radio"]#orbChecked01 + label span {
  background-image: url('application/modules/creditcard/assets/systemimg/creditcard/color/blue406306.png');
}
.xCNCustomRadios input[type="radio"]#orbChecked02 + label span {
  background-image: url('application/modules/creditcard/assets/systemimg/creditcard/color/blue406256.png');
}
.xCNCustomRadios input[type="radio"]#orbChecked03 + label span {
  background-image: url('application/modules/creditcard/assets/systemimg/creditcard/color/Brown4097583.png');
}
.xCNCustomRadios input[type="radio"]#orbChecked04 + label span {
  background-image: url('application/modules/creditcard/assets/systemimg/creditcard/color/green407354.png');
}
.xCNCustomRadios input[type="radio"]#orbChecked05 + label span {
  background-image: url('application/modules/creditcard/assets/systemimg/creditcard/color/orange402021.png');
}
.xCNCustomRadios input[type="radio"]#orbChecked06 + label span {
  background-image: url('application/modules/creditcard/assets/systemimg/creditcard/color/purple40506.png');
}
.xCNCustomRadios input[type="radio"]#orbChecked07 + label span {
  background-image: url('application/modules/creditcard/assets/systemimg/creditcard/color/red40303.png');
}
.xCNCustomRadios input[type="radio"]#orbChecked08 + label span {
  background-image: url('application/modules/creditcard/assets/systemimg/creditcard/color/black40811.png');
}
.xCNCustomRadios input[type="radio"]:checked + label span img {
  opacity: 1;
} */
</style>


<input type="hidden" id="ohdCdcAutStaEdit" value="<?=$nAutStaEdit?>">
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddCreditcard">
	<button style="display:none" type="submit" id="obtSubmitCreditcard" onclick="JSnAddEditCreditcard('<?php echo $tRoute?>')"></button>
    <input type="hidden" id="ohdCrdcheckImg" name="ohdCrdcheckImg" value="<?php echo @$tcheckImg;?>">
    <input type="hidden" id="ohdCrdImgObj" name="ohdCrdImgObj" value="<?php echo @$tImgObjAll;?>">

    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xs-4 col-sm-4">
                        <!-- <div class="upload-img" id="oImgUpload"> -->
                            <?php

                                // if ( isset($aPdtImgData) && !empty($aPdtImgData) ){
                                //     $tFirtImage = $aPdtImgData['raItems'][0]['FTImgObj'];
                                //     $aImgObj    = $aPdtImgData['raItems'];
                                // }else{
                                //     $tFirtImage = '';
                                //     $aImgObj    = '';
                                // }

                                echo FCNtHGetContentUploadImage(@$tImgObj,'CreditCard','1');
                                // echo FCNtHGetContentTumblrImage(@$aImgObj,'Product');
                                echo FCNtHGetContentChooseColor(@$tImgObj,'CreditCard');
                                // if(isset($tImgObjAll) && !empty($tImgObjAll)){
                                //     $tFullPatch = './application/modules/'.$tImgObjAll;
                                //     if (file_exists($tFullPatch)){
                                //         $tPatchImg = base_url().'/application/modules/'.$tImgObjAll;
                                //     }else{
                                //         $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                //     }
                                // }else{
                                //     $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                // }
                           
                                // // Check Image Name
                                // if(isset($tImgName) && !empty($tImgName)){
                                //     $tImageNameCrd   = $tImgName;
                                // }else{
                                //     $tImageNameCrd   = '';
                                // }
                            ?>      
                            <!-- <img id="oimImgMasterCrd" class="img-responsive xCNImgCenter xCNImgMasterCrd " style="width:100%;<?php echo $tStyleImg;?>" id="" src="<?php echo $tPatchImg;?>">
                        </div> -->
                        <!-- <div class="xCNUplodeImage">	
                            <input type="text" class="xCNHide" id="oetImgInputCrdOld"  name="oetImgInputCrdOld" value="<?php echo @$tImageNameCrd;?>">
                            <input type="text"  class="xCNHide" id="oetImgInputCrd" name="oetImgInputCrd" value="<?php echo @$tImageNameCrd;?>">
                            <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','Crd')">  <i class="fa fa-picture-o xCNImgButton"></i> <?php echo language('common/main/main','tSelectPic')?></button>
                        </div> -->
                      
                        <!-- <div class="col-xs-12 col-sm-12" style="margin-top:10%;">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('creditcard/creditcard/creditcard','tCDCTBONIMG')?></label>
                            <div class="xCNCustomRadios">
                                <div title="Blue">
                                    <input type="radio" id="orbChecked01" class="xCNCheckedORB" name="orbChecked" value="blue406306.png" data-name="blue406306.png"  <?php echo $tchecked1;?>>
                                    <label for="orbChecked01">
                                    <span>
                                        <img src="<?php echo $ocheck;?>" alt="Checked Icon" height="20" width="20"  alt="blue406306"/>
                                    </span>
                                    </label>
                                </div>

                                <div title="Blue">
                                    <input type="radio" id="orbChecked02" class="xCNCheckedORB"  data-name="blue406256.png" name="orbChecked"  value='blue406256.png' <?php echo $tchecked2;?>>
                                    <label for="orbChecked02">
                                    <span>
                                       <img src="<?php echo $ocheck;?>" alt="Checked Icon" height="20" width="20" alt="blue406256"/>
                                    </span>
                                    </label>
                                </div>
                                
                                <div title="Brown">
                                    <input type="radio" id="orbChecked03" name="orbChecked" class="xCNCheckedORB"  data-name="Brown4097583.png" value="Brown4097583.png" <?php echo $tchecked3;?>>
                                    <label for="orbChecked03">
                                    <span>
                                       <img src="<?php echo $ocheck;?>" alt="Checked Icon" height="20" width="20" />
                                    </span>
                                    </label>
                                </div>

                                <div title="Green">
                                    <input type="radio" id="orbChecked04" name="orbChecked" class="xCNCheckedORB"  data-name="green407354.png" value="green407354.png" <?php echo $tchecked4;?>>
                                    <label for="orbChecked04">
                                    <span>
                                       <img src="<?php echo $ocheck;?>" alt="Checked Icon" height="20" width="20" />
                                    </span>
                                    </label>
                                </div>

                                <div title="Orange">
                                    <input type="radio" id="orbChecked05" name="orbChecked" class="xCNCheckedORB"  data-name="orange402021.png" value="orange402021.png" <?php echo $tchecked5;?>>
                                    <label for="orbChecked05">
                                    <span>
                                       <img src="<?php echo $ocheck;?>" alt="Checked Icon" height="20" width="20" />
                                    </span>
                                    </label>
                                </div>

                                <div title="Purple">
                                    <input type="radio" id="orbChecked06" name="orbChecked" class="xCNCheckedORB"  data-name="purple40506.png" value="purple40506.png" <?php echo $tchecked6;?>>
                                    <label for="orbChecked06">
                                    <span>
                                       <img src="<?php echo $ocheck;?>" alt="Checked Icon" height="20" width="20" />
                                    </span>
                                    </label>
                                </div>

                                <div title="Red">
                                    <input type="radio" id="orbChecked07" name="orbChecked" class="xCNCheckedORB"  data-name="red40303.png" value="red40303.png" <?php echo $tchecked7;?>>
                                    <label for="orbChecked07">
                                    <span>
                                       <img src="<?php echo $ocheck;?>" alt="Checked Icon" height="20" width="20" />
                                    </span>
                                    </label>
                                </div>

                                <div title="Black">
                                    <input type="radio" id="orbChecked08" name="orbChecked" class="xCNCheckedORB"  data-name="black40811.png" value="black40811.png" <?php echo $tchecked8;?>>
                                    <label for="orbChecked08">
                                    <span>
                                       <img src="<?php echo $ocheck;?>" alt="Checked Icon" height="20" width="20" />
                                    </span>
                                    </label>
                                </div>

                            </div>
                        </div> -->
                    </div>
                    
                    <div class="col-xs-8 col-sm-8">

                        <!-- รหัสบัตรเคดิต --> 
                        <div class="col-xs-10 col-sm-10">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('creditcard/creditcard/creditcard','tCDCCode')?></label>
                                <div id="odvCreditcardAutoGenCode" class="form-group">
                                <div class="validate-input">
                                    <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbCreditcardAutoGenCode" name="ocbCreditcardAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>
                        <div id="odvCreditcardCodeForm" class="form-group">
                            <input type="hidden" id="ohdCheckDuplicateCrdCode" name="ohdCheckDuplicateCrdCode" value="1"> 
                                    <div class="validate-input">
                                    <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai" 
                                    maxlength="5" 
                                    id="oetCrdCode" 
                                    name="oetCrdCode"
                                    data-is-created="<?php echo $tCrdCode;?>"
                                    placeholder="<?= language('promotion/voucher/voucher','tVOCValidCode')?>"
                                    value="<?php echo $tCrdCode; ?>" 
                                    data-validate-required = "<?= language('creditcard/creditcard/creditcard','tCDCValidCheckCode')?>"
                                    data-validate-dublicateCode = "<?= language('creditcard/creditcard/creditcard','tCDCValidCheckCode')?>"
                                >
                                </div>
                            </div>
                        </div>
                        <!-- end รหัสบัตรเคดิต --> 
                        <!-- Agency -->
                        <div class="<?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main','tAgency')?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide" id="oetCDCUsrAgnCode"
                                        name="oetCDCUsrAgnCode" value="<?=@$tUsrAgnCode?>">
                                    <input type="text" class="form-control xWPointerEventNone" id="oetCDCUsrAgnName"
                                        name="oetCDCUsrAgnName"
                                        placeholder="<?php echo language('common/main/main','tAgency')?>"
                                        value="<?=@$tUsrAgnName?>" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtCDCUsrBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img
                                                src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- end Agency -->
                        <!-- ชื่อบัตรเคดิต -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('creditcard/creditcard/creditcard','tCDCName')?></label>
                                <input type="text" class="form-control" placeholder="<?php echo language('creditcard/creditcard/creditcard','tCDCName')?>" maxlength="100" id="oetCrdName" name="oetCrdName" value="<?= $tCrdName?>"
                                data-validate-required = "<?php echo  language('creditcard/creditcard/creditcard','tCDCValidNameCdc')?>"
                                >
                            </div>
                        <!-- end ชื่อบัตรเคดิต --> 
                        
                        <!-- ธนาคาร -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('creditcard/creditcard/creditcard','tCDCBank')?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="ohdBnkCode" name="ohdBnkCode" value="<?=$tBnkCode?>" data-validate="<?php echo  language('creditcard/creditcard/creditcard','tCDCValidBnkCode');?>">
                                        <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetBnkName" name="oetBnkName" value="<?=$tBnkName?>" data-validate="<?php echo  language('creditcard/creditcard/creditcard','tCDCValidBnkName');?>" readonly
                                        data-validate-required = "<?php echo  language('creditcard/creditcard/creditcard','tCDCValidBnkName')?>"
                                        >
                                    <span class="input-group-btn">
                                        <button id="obtBrowseBnk" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="  <?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        <!-- ธนาคาร -->

                        <!-- ชาร์จบัตรเครดิต เป็น% -->
                        <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('creditcard/creditcard/creditcard','tCDCChargingCard')?> %</label>
                                <input type="text" class="form-control xCNInputNumericWithDecimal" placeholder="<?php echo language('creditcard/creditcard/creditcard','tCDCChargingCard')?> %" maxlength="18" id="oetCrdChgPer" name="oetCrdChgPer" value="<?php if($tCrdChgPer != ''){ echo number_format(@$tCrdChgPer,$nDecimalShw); }else{ echo "";}?>">
                        </div>
                        <!-- end ชาร์จบัตรเครดิต เป็น% -->    
                        
                        <!-- Format การแสดงและบันทึกสำหรับบัตรเครดิต -->
                        <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('creditcard/creditcard/creditcard','tCDCFormat')?></label>
                                <input type="text" class="form-control" placeholder="<?php echo language('creditcard/creditcard/creditcard','tCDCFormat')?>" maxlength="18" id="oetCrdFmt" name="oetCrdFmt" value="<?php echo @$tCrdFmt;?>"> 
                        </div>
                        <!-- end Format การแสดงและบันทึกสำหรับบัตรเครดิต -->
                        
                        <!-- หมายเหตุ -->
                        <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('creditcard/creditcard/creditcard','tCDCRmk'); ?></label>
                                <textarea class="form-group" rows="4" placeholder="<?php echo language('creditcard/creditcard/creditcard','tCDCRmk'); ?>" maxlength="100" id="oetCrdRmk" name="oetCrdRmk" autocomplete="off"   placeholder="<?php echo language('payment/cardlogin/cardlogin','tCrdLRemark')?>"><?php echo @$tCrdRmk;?></textarea>
                        </div>
                        <!-- end หมายเหตุ -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jCreditcardAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>

//
// $( "#oetImgInputCrd" ).change(function() {
//   $(".xCNImgMasterCrd").css({ 'border-radius' : '', 'width' : '' });
// });

//
// $( ".xCNCheckedORB" ).change(function() {
//         let tName           = $(this).data('name'); 
//         let tbase_url       = '<?php echo base_url();?>application/modules/creditcard/assets/systemimg/creditcard/color/'+tName;
//         $(".xCNImgMasterCrd").css({ 'border-radius' : '', 'width' : '' });
//         $(".xCNImgMasterCrd").css({ 'border-radius' : '50%', 'width' : '50%' });
//         $(".xCNImgMasterCrd").attr("src",tbase_url);  
// });



//Set Lang Edit 
var nLangEdits = '<?=$this->session->userdata("tLangEdit")?>';
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
		Perpage			: 10,
		OrderBy			: ['TFNMBank.FDCreateOn DESC'],
		// SourceOrder		: "ASC"
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


$(document).ready(function () {
    var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';

    if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
        $('#obtCDCUsrBrowseAgency').attr("disabled", true);
        // $('#oimBrowseBranch').attr("disabled", true);
    }else{
        $('#obtCDCUsrBrowseAgency').attr("disabled", false);
    }
});

$('#obtCDCUsrBrowseAgency').on('click',function(){
    var nStaSession  = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JSxCheckPinMenuClose();
        window.oUsrAgnOption       = undefined;
        oUsrAgnOption              = oUsrBrowseAgency({
            'tReturnInputCode'          : 'oetCDCUsrAgnCode',
            'tReturnInputName'          : 'oetCDCUsrAgnName',
            'aArgReturn'                : ['FTAgnCode','FTAgnName']
        });
        JCNxBrowseData('oUsrAgnOption');
    }else{
        JCNxShowMsgSessionExpired();
    }
});

// Browse AD
// Option Browse Merchant
var nLangEdits = "<?php echo $this->session->userdata("tLangEdit")?>";
var oUsrBrowseAgency = function(poReturnInputAgency){
    
    let tInputReturnAgnCode   = poReturnInputAgency.tReturnInputCode;
    let tInputReturnAgnName   = poReturnInputAgency.tReturnInputName;
    let tAgencyNextFunc       = poReturnInputAgency.tNextFuncName;
    let aAgencyArgReturn      = poReturnInputAgency.aArgReturn;

    // let tJoinBranch = " LEFT JOIN ( SELECT FTMerCode FROM TCNMBranch GROUP BY FTMerCode ) B ON TCNMMerchant.FTMerCode = B.FTMerCode ";
    // let tJoinShop   = " LEFT JOIN ( SELECT FTMerCode FROM TCNMShop GROUP BY FTMerCode ) S ON TCNMMerchant.FTMerCode = S.FTMerCode ";

    let oAgencyOptionReturn = {
        Title : ['authen/user/user','tBrowseAgnTitle'],
        Table :{Master:'TCNMAgency',PK:'FTAgnCode'},
        Join :{
            Table:	['TCNMAgency_L'],
            On:[' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits] //+ tJoinBranch + tJoinShop
        },
        // Where :{
        //     Condition : [" AND ( ISNULL(B.FTMerCode,'') != '' OR ISNULL(S.FTMerCode,'') != '') "]
        // },
        GrideView:{
            ColumnPathLang	: 'authen/user/user',
            ColumnKeyLang	: ['tBrowseAgnCode','tBrowseAgnName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns	    : ['TCNMAgency.FTAgnCode','TCNMAgency_L.FTAgnName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: [tInputReturnAgnCode,"TCNMAgency.FTAgnCode"],
            Text		: [tInputReturnAgnName,"TCNMAgency_L.FTAgnName"]
        },
        //DebugSQL: true,
    };
    return oAgencyOptionReturn;
}
</script>
