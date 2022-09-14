<style>
div.a {
  position: relative;
  width: 100%;
  height: 11px;
}

</style>
<?php
    if(isset($aDataDocHD) && $aDataDocHD['rtCode'] == '1'){
        $tRDHRoute        = "dcmRDHEventEdit";

        $tRDHDocNo          = $aDataDocHD['raItems']['FTRdhDocNo'];
        $dRDHDocDate        = $aDataDocHD['raItems']['FDRdhDocDate'];
        $dRDHDocTime        = date("h:i:s a",strtotime($aDataDocHD['raItems']['FDRdhDocDate']));
       
    
        $tRdhName           = $aDataDocHD['raItems']['FTRdhName'];
        $tRdhNameSlip       = $aDataDocHD['raItems']['FTRdhNameSlip'];

        $tRdhDocType        = $aDataDocHD['raItems']['FTRdhDocType'];
        $tRdhCalType        = $aDataDocHD['raItems']['FTRdhCalType'];

        $dRdhDStart         = $aDataDocHD['raItems']['FDRdhDStart'];
        $dRdhDStop          = $aDataDocHD['raItems']['FDRdhDStop'];
        $dRdhTStart         = explode(' ',$aDataDocHD['raItems']['FDRdhTStart']);
        $dRdhTStop          = explode(' ',$aDataDocHD['raItems']['FDRdhTStop']);

        // User Branch Ana Shop
        $tRDHUsrBchCode     = $aDataDocHD['raItems']['FTBchCode'];
        $tRDHUsrBchName     = $aDataDocHD['raItems']['FTBchName'];

        // Status Document
        $tRDHStaDoc         = $aDataDocHD['raItems']['FTRdhStaDoc'];
        $tRDHStaApv         = $aDataDocHD['raItems']['FTRdhStaApv'];
        $tRDHStaPrcDoc      = $aDataDocHD['raItems']['FTRdhStaPrcDoc'];
        $tRDHStaClosed      = $aDataDocHD['raItems']['FTRdhStaClosed'];

        $nRdhStaOnTopPmt    = $aDataDocHD['raItems']['FTRdhStaOnTopPmt'];
        $nRdhLimitQty       = $aDataDocHD['raItems']['FNRdhLimitQty'];
        $tRDHFrmRDHStaDocAct      = $aDataDocHD['raItems']['FNRdhStaDocAct'];
        $tRdhRefAccCode    =  $aDataDocHD['raItems']['FTRdhRefAccCode'];

        // User Create And User Appove
        $tRDHUsrNameCreateBy    = ($aDataDocHD['raItems']['FTUserNameCreate'] != "")? $aDataDocHD['raItems']['FTUserNameCreate'] : 'N/A';
    }else{
        $tRDHRoute          = "dcmRDHEventAdd";

        $tRDHDocNo          = "";
        $dRDHDocDate        = "";
        $dRDHDocTime        = date('H:i');

        $tRdhName           = "";
        $tRdhNameSlip       = "";

        $tRdhDocType     = "";
        $tRdhCalType    = "";

        $dRdhDStart   = date('Y-m-d');
        $dRdhDStop    = date('Y-m-d');
        $dRdhTStart[1]   = "00:00:00";
        $dRdhTStop[1]    = "23:59:59";

        // User Branch Ana Shop
        $tRDHUsrBchCode     = $this->session->userdata('tSesUsrBchCodeDefault');
        $tRDHUsrBchName     = $this->session->userdata('tSesUsrBchNameDefault');

        // Status Document
        $tRDHStaDoc         = 1;
        $tRDHStaApv         = '';
        $tRDHStaPrcDoc      = '';
        $tRDHStaDelMQ       = '';
        $tRDHStaClosed      = '';
        // User Create And User Appove
        $tRDHUsrNameCreateBy    = 'N/A';

        $nRdhStaOnTopPmt    = "1";
        $nRdhLimitQty       = 0;
        $tRDHFrmRDHStaDocAct      = "1";
        $tRdhRefAccCode = "";
    }
  $nDecimalShow =  FCNxHGetOptionDecimalShow();
?>
<style>
.wizard {
    /* margin: 20px auto; */
    background: #fff;
}

    .wizard .nav-tabs {
        position: relative;
        /* margin: 40px auto; */
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }

.connecting-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    width: 77%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 55%;
    z-index: 1;
}

.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #555555;
    cursor: default;
    border: 0;
    border-bottom-color: transparent;
}

span.round-tab {
    width: 20px;
    height: 20px;
    line-height: 33px;
    display: inline-block;
    border-radius: 100px;
    background: #d6d6d6;
    border: 2px solid #e0e0e0;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 25px;
}
span.round-tab span{
    color:#555555;
}
.wizard li.active span.round-tab {
    background: #fff;
    border: 2px solid #1D2530;
    
}
.wizard li.active span.round-tab i{
    color: #555555;
}

span.round-tab:hover {
    color: #333;
    border: 2px solid #333;
}

.wizard .nav-tabs > li {
    width: 25%;
}

.wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: #1D2530;
    transition: 0.1s ease-in-out;
}

/* .wizard li.active:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 1;
    margin: 0 auto;
    bottom: 0px;
    border: 10px solid transparent;
    border-bottom-color: #1D2530;
} */

.wizard .nav-tabs > li a {
    width: 20px;
    height: 11px;
    border-radius: 100%;
    position: relative;
    padding: 0;
}

    .wizard .nav-tabs > li a:hover {
        background: transparent;
    }

.wizard .tab-pane {
    position: relative;
    padding-top: 5px;
}

.wizard h3 {
    margin-top: 0;
}

@media( max-width : 585px ) {

    .wizard {
        width: 90%;
        height: auto !important;
    }

    span.round-tab {
        font-size: 16px;
        width: 20px;
        height: 20px;
        line-height: 20px;
    }

    .wizard .nav-tabs > li a {
        width: 20px;
        height: 20px;
        line-height: 20px;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 35%;
    }
}

  
</style>
<input type="text" class="xCNHide" id="oetRDHBchCodeMulti" name="oetRDHBchCodeMulti" value="<?php if($this->session->userdata('tSesUsrLevel')!='HQ') { echo str_replace("'","",$this->session->userdata('tSesUsrBchCodeMulti')); } ?>">
<input type="hidden" id="ohdRDHMsgNotFoundCpt"  name="ohdRDHMsgNotFoundCpt" value="<?php echo language('document/conditionredeem/conditionredeem','tTextMsgNotFoundCpt');?>">
<input type="hidden" id="ohdRDHMsgNotFoundDT"   name="ohdRDHMsgNotFoundDT"  value="<?php echo language('document/conditionredeem/conditionredeem','tRdhMsgNotFoundDT');?>">
<input type="hidden" id="ohdRDHValidatePromotionRedeem"  name="ohdRDHValidatePromotionRedeem" value="<?php echo language('document/conditionredeem/conditionredeem','tRDHValidatePromotionRedeem');?>"
    validateGrpNamePdt = "<?php echo language('document/conditionredeem/conditionredeem','tRDHvalidateGrpNamePdt');?>"
    validateGrpCondition = "<?php echo language('document/conditionredeem/conditionredeem','tRDHvalidateGrpCondition');?>"
    validateRdhRefCode = "<?php echo language('document/conditionredeem/conditionredeem','tRDHvalidateRdhRefCode');?>"
    validateRdhUsePoint = "<?php echo language('document/conditionredeem/conditionredeem','tRDHvalidateRdhUsePoint');?>"
    validateRdhMoney  = "<?php echo language('document/conditionredeem/conditionredeem','tRDHvalidateRdhMoney');?>"
    validateRdhLimitBill = "<?php echo language('document/conditionredeem/conditionredeem','tRDHvalidateRdhLimitBill');?>"

>  
<form id="ofmConditionRedeemAddEditForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdRDHRouteEvent"  name="ohdRDHRouteEvent" value="<?php echo @$tRDHRoute;?>">  
    <input type="hidden" id="ohdRDHDocNo"       name="ohdRDHDocNo"      value="<?php echo @$tRDHDocNo;?>">
    <!-- <input type="hidden" id="ohdRDHUsrBchCode"  name="ohdRDHUsrBchCode" value="<?php echo @$tRDHUsrBchCode;?>"> -->
    <!-- Status Document -->
    <input type="hidden" id="ohdRDHStaDoc"      name="ohdRDHStaDoc"     value="<?php echo @$tRDHStaDoc;?>">
    <input type="hidden" id="ohdRDHStaApv"      name="ohdRDHStaApv"     value="<?php echo @$tRDHStaApv;?>">
    <input type="hidden" id="ohdRDHStaPrcDoc"   name="ohdRDHStaPrcDoc"  value="<?php echo @$tRDHStaPrcDoc;?>">
    <input type="hidden" id="ohdRDHUsrIsAgnLevel"   name="ohdRDHUsrIsAgnLevel"  value="<?php echo FCNbUsrIsAgnLevel();?>">
    <input type="hidden" id="ohdRDHSesUsrLevel"   name="ohdRDHSesUsrLevel"  value="<?php echo $this->session->userdata('tSesUsrLevel');?>">
    
    <button style="display:none" type="submit" id="obtRDHSubmitDocument" onclick="JSxRDHAddEditDocument()"></button>
    <div class="row">
        <div class="col-md-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvRDHHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/conditionredeem/conditionredeem', 'tRDHLabelInfoDocument'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvRDHDataInfoDocument" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvRDHDataInfoDocument" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="text-success xCNTitleFrom"><?php echo language('document/conditionredeem/conditionredeem','tRDHLabelFrmAppove');?></label>
                                </div>
                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/conditionredeem/conditionredeem','tRDHLabelAutoGenCode'); ?></label>
                                <?php if(isset($tRDHDocNo) && empty($tRDHDocNo)):?>
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbRDHStaAutoGenCode" name="ocbRDHStaAutoGenCode" maxlength="1" checked="checked">
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHLabelFrmAutoGenCode');?></span>
                                    </label>
                                </div>
                                <?php endif;?>
                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input
                                        type="text"
                                        class="form-control xCNGenarateCodeTextInputValidate xCNInputWithoutSpcNotThai"
                                        id="oetRDHDocNo"
                                        name="oetRDHDocNo"
                                        maxlength="20"
                                        value="<?php echo @$tRDHDocNo;?>"
                                        data-validate-required="<?php echo language('document/conditionredeem/conditionredeem','tRDHPlsEnterOrRunDocNo'); ?>"
                                        data-validate-duplicate="<?php echo language('document/conditionredeem/conditionredeem','tRDHPlsDocNoDuplicate'); ?>"
                                        placeholder="<?php echo language('document/conditionredeem/conditionredeem','tRDHLabelFrmDocNo');?>"
                                        style="pointer-events:none"
                                        readonly
                                    >
                                    <input type="hidden" id="ohdRDHCheckDuplicateCode" name="ohdRDHCheckDuplicateCode" value="2">
                                </div>
                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHLabelFrmDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate xCNInputWhenStaCancelDoc"
                                            id="oetRDHDocDate"
                                            name="oetRDHDocDate"
                                            value="<?php echo @$dRDHDocDate; ?>"
                                            data-validate-required="<?php echo language('document/conditionredeem/conditionredeem','tRDHPlsEnterDocDate'); ?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtRDHDocDate" type="button" class="btn xCNBtnDateTime xCNInputWhenStaCancelDoc"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem', 'tRDHLabelFrmDocTime');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNTimePicker xCNInputMaskTime xCNInputWhenStaCancelDoc"
                                            id="oetRDHDocTime"
                                            name="oetRDHDocTime"
                                            value="<?php echo @$dRDHDocTime; ?>"
                                            data-validate-required="<?php echo language('document/conditionredeem/conditionredeem', 'tRDHPlsEnterDocTime');?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtRDHDocTime" type="button" class="btn xCNBtnDateTime xCNInputWhenStaCancelDoc"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHLabelFrmCreateBy');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdRDHCreateBy" name="ohdRDHCreateBy" value="<?php echo @$tRDHCreateBy;?>">
                                            <label><?php echo @$tRDHUsrNameCreateBy;?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem', 'tRDHLabelFrmStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <?php
                                                if($tRDHRoute == "dcmRDHEventAdd"){
                                                    $tRDHLabelStaDoc    = language('document/conditionredeem/conditionredeem', 'tRDHLabelFrmValStaDoc');
                                                }else{
                                                    $tRDHLabelStaDoc    = language('document/conditionredeem/conditionredeem', 'tRDHLabelFrmValStaDoc'.@$tRDHStaDoc); 
                                                }
                                            ?>
                                            <label><?php echo $tRDHLabelStaDoc;?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem', 'tRDHLabelFrmStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/conditionredeem/conditionredeem', 'tRDHLabelFrmValStaApv'.@$tRDHStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                               	<!-- สาขา -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhBchName'); ?></label>
							<span>

									<div class="form-group">
										
										<div class="input-group">
											<input
												type="text"
												class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
												id="ohdRDHUsrBchCode"
												name="ohdRDHUsrBchCode"
												maxlength="5"
												value="<?=$tRDHUsrBchCode?>"
											>
											<input
												type="text"
												class="form-control xWPointerEventNone"
												id="ohdRDHUsrBchName"
												name="ohdRDHUsrBchName"
												maxlength="100"
												placeholder="<?php echo language('company/shop/shop','tSHPValishopBranch')?>"
												value="<?=$tRDHUsrBchName?>"
												readonly
											>
											<span class="input-group-btn">
												<button id="oimBrowseBch" type="button" class="btn xCNBtnBrowseAddOn"
                                                <?php if($tRDHRoute == 'dcmRDHEventEdit'){
                                                        echo 'disabled';   
                                                }
                                                    ?>
                                                >
													<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
												</button>
											</span>
										</div>
									</div>
                                    </div>
										
                            <!-- ชื่อโปรโมชั่นแลกแต้ม -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/conditionredeem/conditionredeem','tRDHName');?></label>
                                <input
                                    type="text"
                                    class="form-control xCNInputWhenStaCancelDoc"
                                    id="oetRDHName"
                                    name="oetRDHName"
                                    placeholder="<?php echo language('document/conditionredeem/conditionredeem',' ');?>"
                                    value="<?=$tRdhName?>"
                                >
                            </div>
                        <!-- ชื่อโปรโมชั่นแลกแต้มแบบย่อ -->
                        <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHNickName');?></label>
                                <input
                                    type="text"
                                    class="form-control xCNInputWhenStaCancelDoc"
                                    id="oetRDHNameSlip"
                                    name="oetRDHNameSlip"
                                    placeholder="<?php echo language('document/conditionredeem/conditionredeem',' ');?>"
                                    value="<?=$tRdhNameSlip?>"
                                    maxlength = "25"
                                >
                            </div>
                         <!-- รหัสอ้างอิงบัญชีของแต้ม -->
                          <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHRefAccCode');?></label>
                                <input
                                    type="text"
                                    class="form-control xCNInputWhenStaCancelDoc"
                                    id="oetRDHRefAccCode"
                                    name="oetRDHRefAccCode"
                                    placeholder="<?php echo language('document/conditionredeem/conditionredeem','tRDHRefAccCode');?>"
                                    value="<?=$tRdhRefAccCode?>"
                                >
                            </div>
 
                            <!-- Condition ประเภทเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tRdhDocType');?></label>
                                    <select class="selectpicker form-control xCNInputWhenStaCancelDoc" id="ocmRDHDocType" name="ocmRDHDocType" >
                                        <option value="1" <?php if($tRdhDocType==1 ){ $nSeletValue = 1; echo 'selected'; } ?>><?php echo language('document/couponsetup/couponsetup','tRDHTypeRedeemPoint'); ?></option>
                                        <option value="2" <?php if($tRdhDocType==2 ){ $nSeletValue = 2; echo 'selected'; } ?>><?php echo language('document/couponsetup/couponsetup','tRDHTypeRedeemDiscount'); ?></option>    
                                    </select>
                                    <?php if($tRDHRoute == 'dcmRDHEventEdit'):?>
                                        <script type="text/javascript">
                                                    var nSeletValue = '<?=$nSeletValue?>';
                                                    $('#ocmRDHDocType').val(nSeletValue).change();
                                        </script>
                                    <?php endif;?>
                                </div>

                        <!-- Condition ประเภทการคำนวณ -->
                        <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tRDHCalType');?></label>
                                    <select class="selectpicker form-control xCNInputWhenStaCancelDoc" id="ocmRDHCalType" name="ocmRDHCalType" >
                                        <option value="1" <?php if($tRdhCalType==1){ echo 'selected'; } ?>><?php echo language('document/couponsetup/couponsetup','tRDHCalTypeRedeemDiscount'); ?></option>
                                        <option value="2" <?php if($tRdhCalType==2){ echo 'selected'; } ?>><?php echo language('document/couponsetup/couponsetup','tRDHCalTypeRedeemCoupon'); ?></option>
                                    </select>
                                    <?php if($tRDHRoute == 'dcmRDHEventEdit'):?>
                                        <script type="text/javascript">
                                                    // var nSeletValue = '<?=$nSeletValue?>';
                                                    // $('#ocmRDHCalType').val(nSeletValue).change();
                                        </script>
                                    <?php endif;?>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel เงื่อนไข -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvRDHConditionDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/conditionredeem/conditionredeem', 'tRDHLabelFrmConditionDoc'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvRDHDataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvRDHDataConditionDoc" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body" style="padding-top: 0px !important">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-t-20">
               
					
                                <!-- Condition วันที่เริ่มใช้งาน / วันที่สิ้นสุด -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhDate');?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control xCNDatePicker xCNInputMaskDate xCNInputWhenStaCancelDoc "
                                                    id="oetRDHFrmRDHDateStart"
                                                    name="oetRDHFrmRDHDateStart"
                                                    value="<?php echo @$dRdhDStart;?>"
                                                    placeholder="<?php echo language('document/conditionredeem/conditionredeem','tRdhDateStrat');?>"
                                                >
                                                <span class="input-group-btn">
                                                    <button id="obtRDHFrmDateStart" type="button" class="btn xCNBtnDateTime xCNInputWhenStaCancelDoc"><img class="xCNIconCalendar"></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem',' ');?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control xCNDatePicker xCNInputMaskDate xCNInputWhenStaCancelDoc "
                                                    id="oetRDHFrmRDHDateStop"
                                                    name="oetRDHFrmRDHDateStop"
                                                    value="<?php echo @$dRdhDStop;?>"
                                                    placeholder="<?php echo language('document/conditionredeem/conditionredeem','tRdhDateTo');?>"
                                                >
                                                <span class="input-group-btn">
                                                    <button id="obtRDHFrmDateStop" type="button" class="btn xCNBtnDateTime xCNInputWhenStaCancelDoc"><img class="xCNIconCalendar"></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- Condition เวลาเริ่มใช้งาน / เวลาที่สิ้นสุด -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhTime');?></label>
                                            <input
                                                type="text"
                                                class="form-control xCNTimePicker xCNInputMaskTime xCNInputWhenStaCancelDoc "
                                                id="oetRDHFrmRDHTimeStart"
                                                name="oetRDHFrmRDHTimeStart"
                                                value="<?php echo $dRdhTStart[1];?>"
                                                placeholder="<?php echo language('document/conditionredeem/conditionredeem','tRdhTimeStrat');?>"
                                            >
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem',' ');?></label>
                                            <input
                                                type="text"
                                                class="form-control xCNTimePicker xCNInputMaskTime xCNInputWhenStaCancelDoc "
                                                id="oetRDHFrmRDHTimeStop"
                                                name="oetRDHFrmRDHTimeStop"
                                                value="<?php echo $dRdhTStop[1];?>"
                                                placeholder="<?php echo language('document/conditionredeem/conditionredeem','tRdhTimeTo');?>"
                                            >
                                        </div>
                                    </div>
                                </div>
                         
                         
                                <!-- Condition จำนวนครั้งที่อนุญาต / บิล -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhLimitTimeQty');?></label>
                                    <input
                                        type="text"
                                        class="form-control xCNInputNumericWithDecimal xCNInputWhenStaCancelDoc text-right"
                                        id="oetRDHLimitQty"
                                        name="oetRDHLimitQty"
                                        placeholder="<?php echo language('document/conditionredeem/conditionredeem',' ');?>"
                                        value="<?php echo @$nRdhLimitQty;?>"
                                    >
                                </div>


                                <!-- Condition คำนวนรวมสินค้าโปรโมชั่น -->
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <?php
                                            if($nRdhStaOnTopPmt == 1){
                                                $tChecked   = 'checked';
                                            }else{
                                                $tChecked   = '';
                                            }
                                        ?>
                                        <input
                                            type="checkbox"
                                            id="oetRDHStaOnTopPmt"
                                            name="oetRDHStaOnTopPmt"
                                            <?php echo $tChecked;?>
                                        >
                                        <span> <?php echo language('document/conditionredeem/conditionredeem','tRdhStaOnTopPmt');?></span>
                                    </label>
                                </div>


            


                                           <!-- Condition หยุดรายการชั่วคราว -->
                                           <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <?php
                                            if($tRDHStaClosed == 1){
                                                $tChecked   = 'checked';
                                            }else{
                                                $tChecked   = '';
                                            }
                                        ?>
                                        <input
                                            type="checkbox"
                                            id="oetRDHFrmRDHStaClosed"
                                            name="oetRDHFrmRDHStaClosed"
                                            <?php echo $tChecked;?>
                                        >
                                        <span> <?php echo language('document/conditionredeem/conditionredeem','tRdhStaClosed');?></span>
                                    </label>
                                </div>

                                               <!-- Condition เคลื่อนไหว -->
                                               <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <?php
                                            if($tRDHFrmRDHStaDocAct == 1){
                                                $tChecked   = 'checked';
                                            }else{
                                                $tChecked   = '';
                                            }
                                        ?>
                                        <input
                                            type="checkbox"
                                            id="oetRDHFrmRDHStaDocAct"
                                            name="oetRDHFrmRDHStaDocAct"
                                            <?php echo $tChecked;?>
                                        >
                                        <span> <?php echo language('document/conditionredeem/conditionredeem','tRdhStaDocAct');?></span>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-9">
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <input type="hidden" name="ohdRDHNowTab" id="ohdRDHNowTab" value="1">
                            <div class="col-md-12 wizard">
                                <div id="odvPromotionLine" style="width: 100%;">
                                <ul class="nav nav-tabs xWPromotionLine" role="tablist" style="border-bottom:2px solid #d6d6d6;">
                                
                                        <li role="presentation" id="oliTab_step1" class="active oliTab_step">
                                            <label id="olbTab_step1"  class="olbTab_step" style="font-weight: bold"><?php echo language('document/conditionredeem/conditionredeem','tRdhPdtGrpCreate');?></label>
                                            <a href="#step1" data-toggle="tab" aria-controls="step1" step="1" role="tab" title="<?php echo language('document/conditionredeem/conditionredeem','tRdhPdtGrpCreate');?>">
                                                <span class='round-tab' id="ospTab_step1" style="border: 2px solid #111;left: -1px;top: -1px;"></span>
                                            </a>
                                        </li>                                


                                        <li role="presentation" id="oliTab_step2" class="disabled oliTab_step">
                                            <label  id="olbTab_step2"  class="olbTab_step" style="font-weight: bold;margin-left: 28%;white-space: nowrap;"><?php echo language('document/conditionredeem/conditionredeem','tRdhPdtGrpCondition');?></label>
                                                <a  style="position: absolute;right: 68%;width: 17px;height: 22px;" href="#step2" data-toggle="tab" aria-controls="step2" step="2" role="tab" title="<?php echo language('document/conditionredeem/conditionredeem','tRdhPdtGrpCondition');?>">
                                                    <span class="round-tab" id="ospTab_step2" style="border: 2px solid #d6d6d6;"></span>
                                                </a>
                                        </li>


                                        <li role="presentation" id="oliTab_step3" class="disabled oliTab_step">
                                            <label  id="olbTab_step3" class="olbTab_step" style="font-weight: bold;margin-left: 61%;white-space: nowrap;"><?php echo language('document/conditionredeem/conditionredeem','tRdhConditionCr');?></label>
                                            <a style="position: absolute;right: 34%;width: 17px;height: 22px;" href="#step3" data-toggle="tab" aria-controls="step3" step="3" role="tab" title="<?php echo language('document/conditionredeem/conditionredeem','tRdhConditionCr');?>">
                                                <span class="round-tab" id="ospTab_step3" style="border: 2px solid #d6d6d6;"></span>
                                            </a>
                                        </li>


                                        <li role="presentation" id="oliTab_step4" class="disabled oliTab_step">
                                            <label  id="olbTab_step4"  class="olbTab_step" style="font-weight: bold;margin-left: 69%;white-space: nowrap;"><?php echo language('document/conditionredeem/conditionredeem','tRdhReCheckConfrim');?></label>
                                                <a style="position: absolute;right: 0;width: 17px;height: 22px;" href="#complete" data-toggle="tab" aria-controls="step4" step="4" role="tab" title="<?php echo language('document/conditionredeem/conditionredeem','tRdhReCheckConfrim');?>">
                                                    <span class="round-tab" id="ospTab_step4" style="border: 2px solid #d6d6d6;"></span>
                                                </a>   
                                        </li>
                                    </ul>
                                </div>
                            
                         	    <!-- Step Control -->
								<div class="row">
									<div class="col-md-12" style="padding-top:20px !important;">
										<button id="obtRDHBackStepDoc" disabled class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNPromotionBackStep prev-step" type="button" style="display: inline-block; width:120px;"> <?php echo language('document/promotion/promotion', 'tBack'); ?></button>
                                        <button id="obtRDHNextStepDoc" class="btn xCNBTNPrimery xCNBTNPrimery2Btn next-step" type="button" style="display: inline-block; width:120px;"> <?php echo language('document/conditionredeem/conditionredeem', 'tRdhBtnNext'); ?></button> 
                                    </div>
								</div>

                                <div  class="tab-content" style="padding-top:20px;">
                                    <div class="tab-pane active" role="tabpanel" id="step1" style="padding-left:0px; padding-right:0px;">
                                        <?php include "tab/wCondetionRedeemPdt.php"; ?>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="step2" style="padding-left:0px; padding-right:0px;">
                                        <?php include "tab/wConditionRedeemGrp.php"; ?>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="step3" style="padding-left:0px; padding-right:0px;">
                                        <?php include "tab/wConditionRedeemCR.php"; ?>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="complete" style="padding-left:0px; padding-right:0px;">
                                        <?php include "tab/wConditionRedeemFinal.php"; ?>
                                    </div>
                                </div>

                            </div>
                        </div>                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- =================================================== Modal Create Coupon =================================================== --> 
<div id="odvRDHAppendModalCreateHtml">
</div>
<!-- ================================================== Modal Confirm Appove ================================================== --> 
<div id="odvRDHModalAppoveDoc" class="modal fade xCNModalApprove">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main','tApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('common/main/main','tMainApproveStatus'); ?></p>
                    <ul>
                        <li><?php echo language('common/main/main','tMainApproveStatus1'); ?></li>
                        <li><?php echo language('common/main/main','tMainApproveStatus2'); ?></li>
                        <li><?php echo language('common/main/main','tMainApproveStatus3'); ?></li>
                        <li><?php echo language('common/main/main','tMainApproveStatus4'); ?></li>
                    </ul>
                <p><?php echo language('common/main/main','tMainApproveStatus5'); ?></p>
                <p><strong><?php echo language('common/main/main','tMainApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxRDHApproveDocument(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>


<?php include('script/jConditionRedeemPageForm.php');?>