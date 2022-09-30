<?php
    if(isset($aDataDocHD) && $aDataDocHD['rtCode'] == '1'){
        $tCPHRoute        = "dcmCouponSetupEventEdit";

        $tCPHDocNo          = $aDataDocHD['raItems']['FTCphDocNo'];
        $dCPHDocDate        = $aDataDocHD['raItems']['FDCphDocDate'];
        $dCPHDocTime        = date("h:i:s a",strtotime($aDataDocHD['raItems']['FDCphDocDate']));
        $tCPHCptCode        = $aDataDocHD['raItems']['FTCptCode'];
        $tCPHCptName        = $aDataDocHD['raItems']['FTCptName'];
        $tCPHCpnName        = $aDataDocHD['raItems']['FTCpnName'];
        $tCPHCpnMsg1        = $aDataDocHD['raItems']['FTCpnMsg1'];
        $tCPHCpnMsg2        = $aDataDocHD['raItems']['FTCpnMsg2'];
        $tCPHCphDisType     = $aDataDocHD['raItems']['FTCphDisType'];
        $tCPHCphDisValue    = $aDataDocHD['raItems']['FCCphDisValue'];
        $tCPHCphDateStart   = $aDataDocHD['raItems']['FDCphDateStart'];
        $tCPHCphDateStop    = $aDataDocHD['raItems']['FDCphDateStop'];
        $tCPHCphTimeStart   = $aDataDocHD['raItems']['FTCphTimeStart'];
        $tCPHCphTimeStop    = $aDataDocHD['raItems']['FTCphTimeStop'];
        $tCPHCpnCond        = $aDataDocHD['raItems']['FTCpnCond'];
        $tCPHStaChkMember   = $aDataDocHD['raItems']['FTStaChkMember'];

        $tCPHPplCode        = $aDataDocHD['raItems']['FTPplCode'];
        $tCPHPplName        = $aDataDocHD['raItems']['FTPplName'];
        // User Branch Ana Shop
        $tCPHUsrBchCode     = $aDataDocHD['raItems']['FTBchCode'];
        $tCPHUsrBchName     = $aDataDocHD['raItems']['FTBchName'];

        // Status Document
        $tCPHStaDoc         = $aDataDocHD['raItems']['FTCphStaDoc'];
        $tCPHStaApv         = $aDataDocHD['raItems']['FTCphStaApv'];
        $tCPHStaPrcDoc      = $aDataDocHD['raItems']['FTCphStaPrcDoc'];
        $tCPHStaDelMQ       = $aDataDocHD['raItems']['FTCphStaDelMQ'];
        $tCPHStaClosed      = $aDataDocHD['raItems']['FTCphStaClosed'];

        $nCphLimitUsePerBill  = $aDataDocHD['raItems']['FNCphLimitUsePerBill'];
        $tCphStaOnTopPmt      = $aDataDocHD['raItems']['FTCphStaOnTopPmt'];
        $tCphRefAccCode       = $aDataDocHD['raItems']['FTCphRefAccCode'];
        $tCphMinValue         = $aDataDocHD['raItems']['FCCphMinValue'];

        // User Create And User Appove
        $tCPHUsrNameCreateBy    = ($aDataDocHD['raItems']['FTUserNameCreate'] != "")? $aDataDocHD['raItems']['FTUserNameCreate'] : 'N/A';
    }else{
        $tCPHRoute          = "dcmCouponSetupEventAdd";

        $tCPHDocNo          = "";
        $dCPHDocDate        = "";
        $dCPHDocTime        = "";
        $tCPHCptCode        = "";
        $tCPHCptName        = "";
        $tCPHCpnName        = "";
        $tCPHCpnMsg1        = "";
        $tCPHCpnMsg2        = "";
        $tCPHCphDisType     = "";
        $tCPHCphDisValue    = "";
        $tCPHCphDateStart   = date('Y-m-d');
        $tCPHCphDateStop    = date('Y-m-d');
        $tCPHCphTimeStart   = "00:00:00";
        $tCPHCphTimeStop    = "23:59:00";
        $tCPHCpdAlwMaxUse   = "";
        $tCPHCpnCond        = "";
        $tCPHStaChkMember   = "";
        $tCPHPplCode        = "";
        $tCPHPplName        = "";
        // User Branch Ana Shop
        $tCPHUsrBchCode     = $this->session->userdata('tSesUsrBchCodeDefault');
        $tCPHUsrBchName     = $this->session->userdata('tSesUsrBchNameDefault');

        // Status Document
        $tCPHStaDoc         = 1;
        $tCPHStaApv         = '';
        $tCPHStaPrcDoc      = '';
        $tCPHStaDelMQ       = '';
        $tCPHStaClosed      = 1;
        // User Create And User Appove
        $tCPHUsrNameCreateBy    = 'N/A';
        $nCphLimitUsePerBill = 0;
        $tCphStaOnTopPmt = 1;
        $tCphRefAccCode = '';
        $tCphMinValue = 0;
    }
?>
<input type="text" class="xCNHide" id="oetCPHBchCodeMulti" name="oetCPHBchCodeMulti" value="<?php if($this->session->userdata('tSesUsrLevel')!='HQ') { echo str_replace("'","",$this->session->userdata('tSesUsrBchCodeMulti')); } ?>">
<input type="hidden" id="ohdCPHMsgNotFoundCpt"  name="ohdCPHMsgNotFoundCpt" value="<?php echo language('document/couponsetup/couponsetup','tTextMsgNotFoundCpt');?>">
<input type="hidden" id="ohdCPHMsgNotFoundDT"   name="ohdCPHMsgNotFoundDT"  value="<?php echo language('document/couponsetup/couponsetup','tTextMsgNotFoundDT');?>">

<form id="ofmCouponSetupAddEditForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdCPHRouteEvent"  name="ohdCPHRouteEvent" value="<?php echo @$tCPHRoute;?>">
    <input type="hidden" id="ohdCPHDocNo"       name="ohdCPHDocNo"      value="<?php echo @$tCPHDocNo;?>">
    <input type="hidden" id="ohdCPHSesUsrBchCount"  name="ohdCPHSesUsrBchCount" value="<?php echo $this->session->userdata('nSesUsrBchCount');?>">
    <!-- Status Document -->
    <input type="hidden" id="ohdbUsrIsAgnLevel" name="ohdbUsrIsAgnLevel" value="<?=FCNbUsrIsAgnLevel()?>" >
    <input type="hidden" id="ohdCPHStaDoc"      name="ohdCPHStaDoc"     value="<?php echo @$tCPHStaDoc;?>">
    <input type="hidden" id="ohdCPHStaApv"      name="ohdCPHStaApv"     value="<?php echo @$tCPHStaApv;?>">
    <input type="hidden" id="ohdCPHStaPrcDoc"   name="ohdCPHStaPrcDoc"  value="<?php echo @$tCPHStaPrcDoc;?>">
    <input type="hidden" id="ohdCPHStaDelMQ"    name="ohdCPHStaDelMQ"   value="<?php echo @$tCPHStaDelMQ;?>">
    <button style="display:none" type="submit" id="obtCPHSubmitDocument" onclick="JSxCPHAddEditDocument()"></button>
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvCPHHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/couponsetup/couponsetup', 'tCPHLabelInfoDocument'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCPHDataInfoDocument" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvCPHDataInfoDocument" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="text-success xCNTitleFrom"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmAppove');?></label>
                                </div>
                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/couponsetup/couponsetup','tCPHLabelAutoGenCode'); ?></label>
                                <?php if(isset($tCPHDocNo) && empty($tCPHDocNo)):?>
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbCPHStaAutoGenCode" name="ocbCPHStaAutoGenCode" maxlength="1" checked="checked">
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmAutoGenCode');?></span>
                                    </label>
                                </div>
                                <?php endif;?>
                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input
                                        type="text"
                                        class="form-control xCNGenarateCodeTextInputValidate xCNInputWithoutSpcNotThai"
                                        id="oetCPHDocNo"
                                        name="oetCPHDocNo"
                                        maxlength="20"
                                        value="<?php echo @$tCPHDocNo;?>"
                                        data-validate-required="<?php echo language('document/couponsetup/couponsetup','tCPHPlsEnterOrRunDocNo'); ?>"
                                        data-validate-duplicate="<?php echo language('document/couponsetup/couponsetup','tCPHPlsDocNoDuplicate'); ?>"
                                        placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmDocNo');?>"
                                        style="pointer-events:none"
                                        readonly
                                    >
                                    <input type="hidden" id="ohdCPHCheckDuplicateCode" name="ohdCPHCheckDuplicateCode" value="2">
                                </div>
                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate xCNInputWhenStaCancelDoc"
                                            id="oetCPHDocDate"
                                            name="oetCPHDocDate"
                                            value="<?php echo @$dCPHDocDate; ?>"
                                            data-validate-required="<?php echo language('document/couponsetup/couponsetup','tCPHPlsEnterDocDate'); ?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtCPHDocDate" type="button" class="btn xCNBtnDateTime xCNInputWhenStaCancelDoc"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup', 'tCPHLabelFrmDocTime');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNTimePicker xCNInputMaskTime xCNInputWhenStaCancelDoc"
                                            id="oetCPHDocTime"
                                            name="oetCPHDocTime"
                                            value="<?php echo @$dCPHDocTime; ?>"
                                            data-validate-required="<?php echo language('document/couponsetup/couponsetup', 'tCPHPlsEnterDocTime');?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtCPHDocTime" type="button" class="btn xCNBtnDateTime xCNInputWhenStaCancelDoc"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCreateBy');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdCPHCreateBy" name="ohdCPHCreateBy" value="<?php echo @$tCPHCreateBy;?>">
                                            <label><?php echo @$tCPHUsrNameCreateBy;?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup', 'tCPHLabelFrmStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <?php
                                                if($tCPHRoute == "dcmCouponSetupEventAdd"){
                                                    $tCPHLabelStaDoc    = language('document/couponsetup/couponsetup', 'tCPHLabelFrmValStaDoc');
                                                }else{
                                                    $tCPHLabelStaDoc    = language('document/couponsetup/couponsetup', 'tCPHLabelFrmValStaDoc'.@$tCPHStaDoc);
                                                }
                                            ?>
                                            <label><?php echo $tCPHLabelStaDoc;?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup', 'tCPHLabelFrmStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/couponsetup/couponsetup', 'tCPHLabelFrmValStaApv'.@$tCPHStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel เงื่อนไข -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvCPHConditionDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/couponsetup/couponsetup', 'tCPHLabelFrmConditionDoc'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvCPHDataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvCPHDataConditionDoc" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body" style="padding-top: 0px !important">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-t-20">

                                          	<!-- สาขา -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchTitle'); ?></label>
							<span>

									<div class="form-group">

										<div class="input-group">
											<input
												type="text"
												class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
												id="ohdCPHUsrBchCode"
												name="ohdCPHUsrBchCode"
												maxlength="5"
												value="<?=$tCPHUsrBchCode?>"
											>
											<input
												type="text"
												class="form-control xWPointerEventNone"
												id="ohdCPHUsrBchName"
												name="ohdCPHUsrBchName"
												maxlength="100"
												placeholder="<?php echo language('company/shop/shop','tSHPValishopBranch')?>"
												value="<?=$tCPHUsrBchName?>"
												readonly
											>
											<span class="input-group-btn">
												<button id="oimBrowseBch" type="button" class="btn xCNBtnBrowseAddOn"
                                                    <?php
                                                        if($tCPHRoute == 'dcmCouponSetupEventEdit'){
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



                                <!-- Condition ประเภทคูปอง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCptCode');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetCPHFrmCptCode" name="oetCPHFrmCptCode" maxlength="5" value="<?php echo @$tCPHCptCode;?>">
                                        <input
                                            type="text"
                                            class="form-control xWPointerEventNone"
                                            id="oetCPHFrmCptName"
                                            name="oetCPHFrmCptName"
                                            value="<?php echo @$tCPHCptName;?>"
                                            placeholder="<?php echo language('document/couponsetup/couponsetup', 'tCPHLabelFrmCouponType');?>"
                                            readonly
                                        >
                                        <span class="xWConditionSearchPdt input-group-btn">
                                            <button id="obtCPHBrowseCouponType" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn xCNInputWhenStaCancelDoc">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition ชื่อคูปอง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCptName');?></label>
                                    <input
                                        type="text"
                                        class="form-control xCNInputWhenStaCancelDoc"
                                        id="oetCPHFrmCpnName"
                                        name="oetCPHFrmCpnName"
                                        maxlength="250"
                                        placeholder="<?php echo language('document/couponsetup/couponsetup', 'tCPHLabelFrmCouponName');?>"
                                        value="<?php echo @$tCPHCpnName;?>"
                                    >
                                </div>
                                     <!-- Condition รหัสอ้างอิงบัญชีคูปอง  -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCphRefAccCode');?></label>
                                    <input
                                        type="text"
                                        class="form-control xCNInputWhenStaCancelDoc"
                                        id="oetCphRefAccCode"
                                        name="oetCphRefAccCode"
                                        maxlength="20"
                                        placeholder="<?php echo language('document/couponsetup/couponsetup', 'tCphRefAccCode');?>"
                                        value="<?php echo @$tCphRefAccCode; ?>"
                                    >
                                </div>
                                <!-- Condition ข้อความบนคูปองบรรทัดที่ 1 -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCpnMsg1');?></label>
                                    <input
                                        type="text"
                                        class="form-control xCNInputWhenStaCancelDoc"
                                        id="oetCPHFrmCpnMsg1"
                                        name="oetCPHFrmCpnMsg1"
                                        maxlength="100"
                                        placeholder="<?php echo language('document/couponsetup/couponsetup', 'tCPHLabelFrmCouponMsg1');?>"
                                        value="<?php echo @$tCPHCpnMsg1;?>"
                                    >
                                </div>
                                <!-- Condition ข้อความบนคูปองบรรทัดที่ 2 -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCpnMsg2');?></label>
                                    <input
                                        type="text"
                                        class="form-control xCNInputWhenStaCancelDoc"
                                        id="oetCPHFrmCpnMsg2"
                                        name="oetCPHFrmCpnMsg2"
                                        maxlength="100"
                                        placeholder="<?php echo language('document/couponsetup/couponsetup', 'tCPHLabelFrmCouponMsg2');?>"
                                        value="<?php echo @$tCPHCpnMsg2;?>"
                                    >
                                </div>
                                <!-- Condition ประส่วนลด -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCphDisType');?></label>
                                    <select class="selectpicker form-control xCNInputWhenStaCancelDoc" id="ostCPHFrmCphDisType" name="ostCPHFrmCphDisType" value="<?php echo $tCPHCphDisType;?>">
                                        <option value="1"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCouponDisType1'); ?></option>
                                        <option value="2"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCouponDisType2'); ?></option>
                                        <option value="3"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCouponDisType3'); ?></option>
                                    </select>
                                    <?php if($tCPHRoute == 'dcmCouponSetupEventEdit'):?>
                                        <script type="text/javascript">
                                            let tCPHCphDisType  = '<?php echo $tCPHCphDisType; ?>';
                                            if(tCPHCphDisType != undefined ||tCPHCphDisType != ''){
                                                $('#ostCPHFrmCphDisType').val(tCPHCphDisType).selectpicker('refresh');
                                            }
                                        </script>
                                    <?php endif;?>
                                </div>

                            <!-- Condition มูลค่า -->
                            <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCphDisValue');?></label>
                                    <input
                                        type="text"
                                        class="form-control xCNInputNumericWithDecimal xCNInputMaskCurrency xCNInputWhenStaCancelDoc text-right"
                                        id="oetCPHFrmCphDisValue"
                                        name="oetCPHFrmCphDisValue"
                                        placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCouponDisValue');?>"
                                        value="<?php echo @$tCPHCphDisValue;?>"
                                    >
                                </div>
                                        <div class='form-group'>
                                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDCstPriTitle')?></label>
                                            <div class='input-group'>
                                                <input type='text' class='form-control xCNHide xWCPHAllInput' id='oetCPHHDCstPriCode' name='oetCPHHDCstPriCode' maxlength='5' value="<?php echo $tCPHPplCode;?>" validatedata = "<?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDCstPriSelect')?>">
                                                <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetCPHHDCstPriName' name='oetCPHHDCstPriName' value="<?php echo $tCPHPplName;?>" readonly>
                                                <span class='input-group-btn'>
                                                    <button id='obtCPHBrowseHDCstPri' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                </span>
                                            </div>
                                        </div>



                                <!-- Condition วันที่เริ่มใช้งาน / วันที่สิ้นสุด -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCphDateStart');?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control xCNDatePicker xCNInputMaskDate xCNInputWhenStaCancelDoc text-center"
                                                    id="oetCPHFrmCphDateStart"
                                                    name="oetCPHFrmCphDateStart"
                                                    value="<?php echo @$tCPHCphDateStart;?>"
                                                    placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCouponDateStart');?>"
                                                >
                                                <span class="input-group-btn">
                                                    <button id="obtCPHFrmDateStart" type="button" class="btn xCNBtnDateTime xCNInputWhenStaCancelDoc"><img class="xCNIconCalendar"></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCphDateStop');?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control xCNDatePicker xCNInputMaskDate xCNInputWhenStaCancelDoc text-center"
                                                    id="oetCPHFrmCphDateStop"
                                                    name="oetCPHFrmCphDateStop"
                                                    value="<?php echo @$tCPHCphDateStop;?>"
                                                    placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCouponDateStop');?>"
                                                >
                                                <span class="input-group-btn">
                                                    <button id="obtCPHFrmDateStop" type="button" class="btn xCNBtnDateTime xCNInputWhenStaCancelDoc"><img class="xCNIconCalendar"></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Condition เวลาเริ่มใช้งาน / เวลาที่สิ้นสุด -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCphTimeStart');?></label>
                                            <input
                                                type="text"
                                                class="form-control xCNTimePicker xCNInputMaskTime xCNInputWhenStaCancelDoc text-center"
                                                id="oetCPHFrmCphTimeStart"
                                                name="oetCPHFrmCphTimeStart"
                                                value="<?php echo @$tCPHCphTimeStart;?>"
                                                placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCouponTimeStart');?>"
                                            >
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCphTimeStop');?></label>
                                            <input
                                                type="text"
                                                class="form-control xCNTimePicker xCNInputMaskTime xCNInputWhenStaCancelDoc text-center"
                                                id="oetCPHFrmCphTimeStop"
                                                name="oetCPHFrmCphTimeStop"
                                                value="<?php echo @$tCPHCphTimeStop;?>"
                                                placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCouponTimeStop');?>"
                                            >
                                        </div>
                                    </div>
                                </div>
                                    <!-- Condition ยอดต่ำสุดที่สามารถใช้ได้ -->
                            <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCphMinValue');?></label>
                                    <input
                                        type="text"
                                        class="form-control xCNInputNumericWithDecimal xCNInputMaskCurrency xCNInputWhenStaCancelDoc text-right"
                                        id="oetCphMinValue"
                                        name="oetCphMinValue"
                                        placeholder="<?php echo language('document/couponsetup/couponsetup','tCphMinValue');?>"
                                        value="<?php echo @$tCphMinValue;?>"
                                    >
                                </div>

                      <!-- Condition จำกัดจำนวนใช้ต่อบิล -->
                       <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCphLimitUsePerBill');?></label>
                                    <input
                                        type="text"
                                        class="form-control xCNInputNumericWithDecimal xCNInputMaskCurrency xCNInputWhenStaCancelDoc text-right"
                                        id="oetCphLimitUsePerBill"
                                        name="oetCphLimitUsePerBill"
                                        placeholder="<?php echo language('document/couponsetup/couponsetup','tCphLimitUsePerBill');?>"
                                        value="<?php echo @$nCphLimitUsePerBill;?>"
                                    >
                                </div>

                                <!-- Condition เงื่อนไขแสดงบนคูปอง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCpnCond');?></label>
                                    <textarea
                                        class="form-control xCNInputWhenStaCancelDoc"
                                        id="oetCPHFrmCpnCond"
                                        name="oetCPHFrmCpnCond"
                                        rows="2"
                                        maxlength="250"
                                        placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCouponCond');?>"
                                    ><?php echo @$tCPHCpnCond;?></textarea>
                                </div>

                                <!-- Condition อนุญาตคำนวณรวมโปรโมชั่น -->
                                          <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <?php
                                            if($tCphStaOnTopPmt == 1){
                                                $tChecked   = 'checked';
                                            }else{
                                                $tChecked   = '';
                                            }
                                        ?>
                                        <input
                                            type="checkbox"
                                            id="ocbCphStaOnTopPmt"
                                            name="ocbCphStaOnTopPmt"
                                            <?php echo $tChecked;?>
                                            value="1"
                                        >
                                        <span> <?php echo language('document/couponsetup/couponsetup','tCphStaOnTopPmt');?></span>
                                    </label>
                                </div>

                                <!-- Condition สถานะตรวจสอบลูกค้า -->
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <?php
                                            if(isset($tCPHStaChkMember) && $tCPHStaChkMember == 1){
                                                $tChecked   = 'checked';
                                            }else{
                                                $tChecked   = '';
                                            }
                                        ?>
                                        <input
                                            type="checkbox"
                                            id="oetCPHFrmCphStaChkMember"
                                            name="oetCPHFrmCphStaChkMember"
                                            <?php echo $tChecked;?>
                                        >
                                        <span> <?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCouponStaChkMember');?></span>
                                    </label>
                                </div>

                                <!-- Condition สถานะหยุดใช้งาน -->
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <?php
                                            if(isset($tCPHStaClosed) && $tCPHStaClosed == 2){
                                                $tChecked   = 'checked';
                                            }else{
                                                $tChecked   = '';
                                            }
                                        ?>
                                        <input
                                            type="checkbox"
                                            id="oetCPHFrmCphStaClosed"
                                            name="oetCPHFrmCphStaClosed"
                                            <?php echo $tChecked;?>
                                        >
                                        <span> <?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCouponStaClosed');?></span>
                                    </label>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel กำหนดพิเศษ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvCPHSettingSpecial" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/couponsetup/couponsetup', 'tCPHLabelFrmSettingSpecial'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvCPHDataSettingSpecial" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvCPHDataSettingSpecial" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body" style="padding-top: 0px !important">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                <div class="row">
                                      <div id="odvNavMenu" class="col-xl-12 col-lg-12">
                                         <ul class="nav" role="tablist" data-typetab="main" data-tabtitle="cstinfo">
                                        <li id="oliCouponHDBch" class="xWMenu active">
                                            <a
                                                role="tab"
                                                data-toggle="tab"
                                                data-target="#odvTabCouponHDBch"

                                                aria-expanded="true"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchTitle')?></a>
                                        </li>
                                        <li id="oliCouponHDCstPri" class="xWMenu" data-typetab="main" data-tabtitle="cstinfo2">
                                            <a
                                                role="tab"
                                                data-toggle="tab"
                                                data-target="#odvTabCouponHDCstPri"

                                                aria-expanded="false"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDCstPriTitle')?></a>
                                        </li>
                                        <li id="oliCouponHDPdt" class="xWMenu" data-typetab="main" data-tabtitle="cstinfo2">
                                            <a
                                                role="tab"
                                                data-toggle="tab"
                                                data-target="#odvTabCouponHDPdt"

                                                aria-expanded="false"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDPdtTitle')?></a>
                                        </li>
                                    </ul>
                                    </div>
                                  </div>
                                </div>


                             <div class="tab-content">

                            <?php include "tab/wCouponHDBch.php"; ?>
                            <?php include "tab/wCouponHDCstPri.php"; ?>
                            <?php include "tab/wCouponHDPdt.php"; ?>

                            </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <div class="row">
                <!-- ตารางรายการคูปอง -->
                <div id="odvCPHDataPanelDetail" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom: 25px;">
                        <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                            <label class="xCNTextDetail1"><?php echo language('document/couponsetup/couponsetup','tCPHLabelDataDetail'); ?></label>
                        </div>
                        <div class="panel-collapse collapse in" role="tabpanel">
                            <div class="panel-body">
                                <div class="row p-t-10">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input
                                                    class="form-control xCNInpuTXOthoutSingleQuote"
                                                    type="text"
                                                    id="oetCPHSearchDataDT"
                                                    name="oetCPHSearchDataDT"
                                                    placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHSearchDataDT')?>"
                                                    autocomplete="off"
                                                >
                                                <span class="input-group-btn">
                                                    <button id="obtCPHSearchDataDT" type="button" class="btn xCNBtnDateTime"><img class="xCNIconSearch"></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                                        <div class="form-group">
                                            <div style="position: absolute;right: 15px;top:-5px;">
                                                <button type="button" id="obtCPHAddCouponDT" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-t-10" id="odvCPHDataDetailDT">
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
<div id="odvCPHAppendModalCreateHtml">
</div>
<!-- ================================================== Modal Confirm Appove ================================================== -->
<div id="odvCPHModalAppoveDoc" class="modal fade xCNModalApprove">
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
                <button onclick="JSxCPHApproveDocument(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvCPHCouponHDBch" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('document/couponsetup/couponsetup','tCPHTabCouponHDBchSelect')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input  type="hidden" name="ohdCPHcouponModalTypeInclude" id="ohdCPHcouponModalTypeInclude">
                <div class='row'>

                    <div class='col-lg-12'>
                        <div class='form-group <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide'; endif; ?>'>
                            <label class="xCNLabelFrm"><?=language('document/couponsetup/couponsetup','tCPHAgency')?></label>
                            <div class='input-group'>
                                <input type='text' class='form-control xCNHide xWCPHAllInput' id='oetCPHAgnCodeTo' name='oetCPHAgnCodeTo' value="<?=$this->session->userdata('tSesUsrAgnCode')?>" maxlength='5'>
                                <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetCPHAgnNameTo' name='oetCPHAgnNameTo'  value="<?=$this->session->userdata('tSesUsrAgnName')?>" readonly>
                                <span class='input-group-btn'>
                                    <button id='obtCPHBrowseAgnTo' type='button' class='btn xCNBtnBrowseAddOn' <?php    if($this->session->userdata('tSesUsrLevel')!='HQ'){ echo 'disabled'; } ?>><img class='xCNIconFind'></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class='col-lg-12'>
                        <div class='form-group'>
                            <label class="xCNLabelFrm"><?=language('company/branch/branch','tBCHTitle')?></label>
                            <div class='input-group'>
                                <input type='text' class='form-control xCNHide xWCPHAllInput' id='oetCPHBchCodeTo' name='oetCPHBchCodeTo' maxlength='5'>
                                <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetCPHBchNameTo' name='oetCPHBchNameTo' readonly>
                                <span class='input-group-btn'>
                                    <button id='obtCPHBrowseBchTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                </span>
                            </div>
                        </div>
                    </div>

                            <div class='col-lg-12'  <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : '' ?>>
                                <div class='form-group'>
                                <label class="xCNLabelFrm"><?=language('company/branch/branch','tMerchantTitle')?></label>
                                    <div class='input-group'>
                                        <input type='text' class='form-control xCNHide xWCPHAllInput' id='oetCPHMerCodeTo' name='oetCPHMerCodeTo' maxlength='5'>
                                        <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetCPHMerNameTo' name='oetCPHMerNameTo' readonly>
                                        <span class='input-group-btn'>
                                            <button id='obtCPHBrowseMerTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        <div class='col-lg-12' <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : '' ?> >
                            <div class='form-group'>
                            <label class="xCNLabelFrm"><?=language('company/branch/branch','tSHPTitle')?></label>
                                <div class='input-group'>
                                    <input type='text' class='form-control xCNHide xWCPHAllInput' id='oetCPHShpCodeTo' name='oetCPHShpCodeTo' maxlength='5'>
                                    <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetCPHShpNameTo' name='oetCPHShpNameTo' readonly>
                                    <span class='input-group-btn'>
                                        <button id='obtCPHBrowseShpTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

            </div>
            <div class="modal-footer">
                <button type="button"  class="btn xCNBTNPrimery" id="obtCPHCouponSelectBch" ><?=language('common/main/main','tModalAdvChoose')?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main','tModalAdvClose')?></button>
            </div>
        </div>
    </div>
</div>

<!-- ===================================================== Modal Delete Document Multiple ================================ -->
<div id="odvCPHModalStopCoupon" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalWarning') ?></label>
            </div>
            <div class="modal-body">
                <span class="xCNTextModal ospCPHModalStopCoupon" ><?=language('document/couponsetup/couponsetup','tDetailStopCoupon'); ?></span>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" onclick="JSxModalConfirmStopCoupon()" data-dismiss="modal"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal" onclick="JSxModalCancleStopCoupon()"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/html" id="oscCPHTemplateModalCreate">
    <style>
        .xWBoxFilter {
            border:1px solid #ccc !important;
            position:relative !important;
            padding:15px !important;
            margin-top:30px !important;
            padding-bottom:0px !important;
        }

        .xWBoxFilter .xWLabelFilter {
            position:absolute !important;
            top:-15px;left:15px !important;
            background: #fff !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
    </style>
    <div id="odvCPHFormAddCoupon" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/couponsetup/couponsetup','tCPHCreateCoupon');?></label>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmCPHModalCreateCouponForm">
                            <button style="display:none" type="submit" id="obtCPHSubmitFromSaveCondition" onclick="JSxCPHEventCreateCouponDT()"></button>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <?php echo FCNtHGetContentUploadImage('','Coupon'); ?>
                                    <!-- <div id="odvCPHModalCouponImage">
                                        <?php
                                            $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                        ?>
                                        <img id="oimImgMasterCPHModalCoupon" class="img-responsive xCNImgCenter" src="<?php echo @$tPatchImg;?>">
                                    </div>
                                    <div class="xCNUplodeImage">
                                        <input type="text" class="xCNHide" id="oetImgInputCPHModalCouponOld"  name="oetImgInputCPHModalCouponOld">
                                        <input type="text" class="xCNHide" id="oetImgInputCPHModalCoupon"     name="oetImgInputCPHModalCoupon">
                                        <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','CPHModalCoupon')">
                                            <i class="fa fa-picture-o xCNImgButton"></i> <?php echo language('common/main/main','tSelectPic')?>
                                        </button>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <select class="xWCPHModalSelect form-control" id="ostCPHModalCouponTypeCreate" name="ostCPHModalCouponTypeCreate">
                                                        <option value="1"><?php echo language('document/couponsetup/couponsetup','tCPHModalCouponTypeCreate1');?></option>
                                                        <option value="2"><?php echo language('document/couponsetup/couponsetup','tCPHModalCouponTypeCreate2');?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="odvCPHModalCouponTypeCreate1" class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="oetCPHModalFileShowName" name="oetCPHModalFileShowName" placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHSltFile');?>" readonly="">
                                                        <input
                                                            type="file"
                                                            class="form-control"
                                                            style="visibility: hidden; position: absolute;"
                                                            id="oetCPHModalFileInport"
                                                            name="oetCPHModalFileInport"
                                                            onchange="JSxCPHModalFuncImportFile(this, event)"
                                                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                        >
                                                        <span class="input-group-btn">
                                                            <button id="obtFile" type="button" class="btn btn-primary" onclick="$('#oetCPHModalFileInport').click()">
                                                                <?php echo language('document/couponsetup/couponsetup','tCPHModalCouponChooseFile');?>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="odvCPHModalCouponTypeCreate2" class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <select class="xWCPHModalSelect form-control" id="ostCPHModalCouponCreateMng" name="ostCPHModalCouponCreateMng">
                                                        <option value="1"><?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCreateMng1');?></option>
                                                        <option value="2"><?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCreateMng2');?></option>
                                                    </select>
                                                </div>
                                                <div id="odvCPHModalCouponCreateMng1" class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <select class="xWCPHModalSelect form-control" id="ostCPHModalCouponCreateMng1Bar" name="ostCPHModalCouponCreateMng1Bar">
                                                            <option value="1"><?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCreateMng1Bar1');?></option>
                                                            <option value="2"><?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCreateMng1Bar2');?></option>
                                                            <option value="3"><?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCreateMng1Bar3');?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="odvCPHModalCouponCreateMng2" class="row" style="display:none;">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <select class="xWCPHModalSelect form-control" id="ostCPHModalCouponCreateMng2Bar" name="ostCPHModalCouponCreateMng2Bar">
                                                            <option value="1"><?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCreateMng2Bar1');?></option>
                                                            <option value="2"><?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCreateMng2Bar2');?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="odvCPHModalInputCreateCoupon" class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="xWBoxFilter">
                                            <label class="xCNLabelFrm xWLabelFilter"><?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCouponSetAutoGenBar');?></label>

                                            <div id="odvCPHModalFormBarWidth" class="form-group xWCPHModalInputCreateCoupon">
                                                <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelModalCouponWidth');?></label>
                                                <input type="number" clas="form-control" id="oetCPHModalInputBarWidth" name="oetCPHModalInputBarWidth" placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHModalCouponWidth');?>" required>
                                            </div>

                                            <div id="odvCPHModalFormBarPrefix" class="form-group xWCPHModalInputCreateCoupon">
                                                <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelModalCouponText');?></label>
                                                <input type="text" clas="form-control" id="oetCPHModalInputBarPrefix" name="oetCPHModalInputBarPrefix" placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHModalCouponText');?>" required>
                                            </div>

                                            <div id="odvCPHModalFormBarStartCode" class="form-group xWCPHModalInputCreateCoupon">
                                                <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelModalCouponCodeStart');?></label>
                                                <input type="text" clas="form-control" id="oetCPHModalInputBarStartCode" name="oetCPHModalInputBarStartCode" placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCodeStart');?>" required>
                                            </div>

                                            <div id="odvCPHModalFormBarQty" class="form-group xWCPHModalInputCreateCoupon">
                                                <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelModalCouponQty');?></label>
                                                <input type="number" clas="form-control" id="oetCPHModalInputBarQty" name="oetCPHModalInputBarQty" placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHModalCouponQty');?>" required>
                                            </div>

                                            <div id="odvCPHModalFormCouponCode" class="form-group xWCPHModalInputCreateCoupon">
                                                <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelModalCouponCode');?></label>
                                                <input type="text" clas="form-control" id="oetCPHModalInputCouponCode" name="oetCPHModalInputCouponCode" placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCode');?>" required>
                                            </div>

                                            <div id="odvCPHModalFormBarHisQtyUse" class="form-group xWCPHModalInputCreateCoupon">
                                                <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHLabelModalCouponMaxUse');?></label>
                                                <input type="number" clas="form-control" id="oetCPHModalInputBarHisQtyUse" name="oetCPHModalInputBarHisQtyUse" placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHModalCouponMaxUse');?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <a id="obtCPHModalDownloadTemplate" class="btn"
                                style="font-size: 17px; width:100%;background-color:transparent;border-color:#3ec73e;color:#3ec73e !important;font-weight: bold;"
                                target="_blank"
                                href="<?php echo base_url().'application/modules/document/assets/carddocfile/Temp_Coupon.xlsx';?>"
                            >
                                <?php echo language('document/couponsetup/couponsetup','tCPHModalCouponDownloadTemplate');?>
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCanel');?></button>
                            <button id="obtCPHSaveCreateCoupon" type="button" class="btn btn-primary" onclick="JSoCPHModalSaveCreateCoupon()">
                                <?php echo language('document/couponsetup/couponsetup','tCPHModalCouponCreate');?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<script type="text/html" id="oscCPHTemplateDataDetailDT">
    <tr
        class="xWCPHDataDetailItems"
        data-imageold="{tImgCPHCouponOld}"
        data-imagenew="{tImgCPHCouponNew}"
        data-cpdbarcpn="{tTextCpdBarCpn}"
    >
        <td nowrap class="text-center xWCPHNumberSeq">{nKeyNumber}</td>
        <td nowrap class="text-let">{tTextCpdBarCpn}</td>
        <td nowrap>
            <input type="text" class="form-control text-right xWCpdAlwMaxUse xCNInputWhenStaCancelDoc xCNInputWhenStaCancelDoc" value="{tTextCpdAlwMaxUse}">
        </td>
        <td nowrap class="text-center">
            <label class="xCNTextLink">
                <img class="xCNIconTable xWCPHRemoveDetailTD" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSxCPHDeleteRowDTItems(this)">
            </label>
        </td>
    </tr>
</script>

<?php include('script/jCouponSetupPageForm.php');?>

<script>

    function JSnCHPCheckDuplicationRowHDBch(paData){

        let nLenIn = $('input[name^="ohdCPHCouponIncludeBchCode["]').length
        let aEchDataIn = JSxCreateArray(nLenIn,4);
        //Include
        $('input[name^="ohdCPHCouponIncludeAgnCode["]').each(function(index){
            let tAgnCode = $(this).val();
            aEchDataIn[index][0]=tAgnCode;
        });
        $('input[name^="ohdCPHCouponIncludeBchCode["]').each(function(index){
            let tBchCode = $(this).val();
            aEchDataIn[index][1]=tBchCode;
        });
        $('input[name^="ohdCPHCouponIncludeMerCode["]').each(function(index){
            let tMerCode = $(this).val();
            aEchDataIn[index][2]=tMerCode;
        });
        $('input[name^="ohdCPHCouponIncludeShpCode["]').each(function(index){
            let tShpCode = $(this).val();
            aEchDataIn[index][3]=tShpCode;
        });

        let nLenEx = $('input[name^="ohdCPHCouponExcludeBchCode["]').length
        let aEchDataEx = JSxCreateArray(nLenEx,4);
        //Exclude
        $('input[name^="ohdCPHCouponExcludeAgnCode["]').each(function(index){
            let tAgnCode = $(this).val();
            aEchDataEx[index][0]=tAgnCode;
        });
        $('input[name^="ohdCPHCouponExcludeBchCode["]').each(function(index){
            let tBchCode = $(this).val();
            aEchDataEx[index][1]=tBchCode;
        });
        $('input[name^="ohdCPHCouponExcludeMerCode["]').each(function(index){
            let tMerCode = $(this).val();
            aEchDataEx[index][2]=tMerCode;
        });
        $('input[name^="ohdCPHCouponExcludeShpCode["]').each(function(index){
            let tShpCode = $(this).val();
            aEchDataEx[index][3]=tShpCode;
        });

        // console.log("aEchDataIn",aEchDataIn);
        // console.log("aEchDataEx",aEchDataEx);

        let nAproveAppend = 0;
        for(i=0;i<aEchDataIn.length;i++){
            if(aEchDataIn[i][0]==paData.tCPHAgnCodeTo && aEchDataIn[i][1]==paData.tCPHBchCodeTo && aEchDataIn[i][2]==paData.tCPHMerCodeTo && aEchDataIn[i][3]==paData.tCPHShpCodeTo){
                nAproveAppend++;
            }
        }
        for(i=0;i<aEchDataEx.length;i++){
            if(aEchDataIn[i][0]==paData.tCPHAgnCodeTo && aEchDataEx[i][1]==paData.tCPHBchCodeTo && aEchDataEx[i][2]==paData.tCPHMerCodeTo && aEchDataEx[i][3]==paData.tCPHShpCodeTo){
                nAproveAppend++;
            }
        }
        // console.log(nAproveAppend);
        return nAproveAppend;
    }

    $('#obtCPHCouponSelectBch').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tCouponModalTypeInclude = $('#ohdCPHcouponModalTypeInclude').val();
                var tCPHAgnCodeTo           = $('#oetCPHAgnCodeTo').val();
                var tCPHAgnNameTo           = $('#oetCPHAgnNameTo').val();
                var tCPHBchCodeTo           = $('#oetCPHBchCodeTo').val();
                var tCPHBchNameTo           = $('#oetCPHBchNameTo').val();
                var tCPHMerCodeTo           = $('#oetCPHMerCodeTo').val();
                var tCPHMerNameTo           = $('#oetCPHMerNameTo').val();
                var tCPHShpCodeTo           = $('#oetCPHShpCodeTo').val();
                var tCPHShpNameTo           = $('#oetCPHShpNameTo').val();
                
                // if(tCPHAgnCodeTo!=''){
                    let aData = {
                        tCPHAgnCodeTo:tCPHAgnCodeTo,
                        tCPHAgnNameTo:tCPHAgnNameTo,
                        tCPHBchCodeTo:tCPHBchCodeTo,
                        tCPHBchNameTo:tCPHBchNameTo,
                        tCPHMerCodeTo:tCPHMerCodeTo,
                        tCPHMerNameTo:tCPHMerNameTo,
                        tCPHShpCodeTo:tCPHShpCodeTo,
                        tCPHShpNameTo:tCPHShpNameTo,
                    }

                    let nAproveSta = JSnCHPCheckDuplicationRowHDBch(aData);

                    if(nAproveSta==0){

                        if(tCouponModalTypeInclude==1){
                            JSxConsNextFuncBrowseBchInclude(aData);
                        }else{
                            JSxConsNextFuncBrowseBchExclude(aData);
                        }

                        $("#odvCPHCouponHDBch").modal('hide');
                    }else{
                        alert('Data Select Duplicate.');
                    }
                // }else{
                //     alert('Please Select Branch.');
                // }

            }
    });


    $('#obtCPHBrowseAgnTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oCPHAgencyOptionTo   = undefined;
            oCPHAgencyOptionTo          = oCPHAgencyOption({
                'tReturnInputCode'  : 'oetCPHAgnCodeTo',
                'tReturnInputName'  : 'oetCPHAgnNameTo',

            });
            JCNxBrowseData('oCPHAgencyOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    $('#obtCPHBrowseBchTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oCPHBranchOptionTo   = undefined;
            oCPHBranchOptionTo          = oCPHBranchOption({
                'tReturnInputCode'  : 'oetCPHBchCodeTo',
                'tReturnInputName'  : 'oetCPHBchNameTo',

            });
            JCNxBrowseData('oCPHBranchOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtCPHBrowseMerTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oCPHMerChantOptionTo = undefined;
            oCPHMerChantOptionTo        = oCPHMerChantOption({
                'tReturnInputCode'  : 'oetCPHMerCodeTo',
                'tReturnInputName'  : 'oetCPHMerNameTo',
                'tNextFuncName'     : 'JSxCPHConsNextFuncBrowseMerChant',
                'aArgReturn'        : ['FTMerCode','FTMerName']
            });
            JCNxBrowseData('oCPHMerChantOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtCPHBrowseShpTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu

            let tCPHBranchForm  = $('#oetCPHBchCodeTo').val();
            let tCPHBranchTo    = $('#oetCPHBchCodeTo').val();
            window.oCPHShopOptionTo = undefined;
            oCPHShopOptionTo        = oCPHShopOption({
                'tReturnInputCode'  : 'oetCPHShpCodeTo',
                'tReturnInputName'  : 'oetCPHShpNameTo',
                'tCPHBranchForm'    : tCPHBranchForm,
                'tCPHBranchTo'      : tCPHBranchTo,
                'tNextFuncName'     : 'JSxCPHConsNextFuncBrowseShp',
                'aArgReturn'        : ['FTShpCode','FTShpName']
            });
            JCNxBrowseData('oCPHShopOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //เลือกสาขา
    var oCPHAgencyOption = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tBchCodeWhere = poReturnInput.tBchCodeWhere;

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
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMAgency.FTAgnCode"],
                Text: [tInputReturnName, "TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew: 'agency',
            BrowseLev: 0,
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionAgn',
                ArgReturn: ['FTAgnCode']
            }
        }
        return oOptionReturn;
    }

    function JSxClearBrowseConditionAgn(ptData) {
        // aData = JSON.parse(ptData);
        if (ptData != '' || ptData != 'NULL') {

            $('#oetCPHBchCodeTo').val('');
            $('#oetCPHBchNameTo').val('');
            $('#oetCPHShpCodeTo').val('');
            $('#oetCPHShpNameTo').val('');
            $('#oetCPHMerCodeTo').val('');
            $('#oetCPHMerNameTo').val('');

        }
    }

    var oCPHBranchOption = function(poCPHReturnInputBch){
        let tCPHNextFuncNameBch    = poCPHReturnInputBch.tNextFuncName;
        let aCPHArgReturnBch       = poCPHReturnInputBch.aArgReturn;
        let tCPHInputReturnCodeBch = poCPHReturnInputBch.tReturnInputCode;
        let tCPHInputReturnNameBch = poCPHReturnInputBch.tReturnInputName;

        var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
        var tCPHAgnCodeTo = $('#oetCPHAgnCodeTo').val();
        var tMerCode = $('#oetCPHMerCodeTo').val();
        var tWhere = "";

        if(nCountBch == 1){
            $('#obtCPHBrowseBchTo').attr('disabled',true);
        }
        if(tUsrLevel != "HQ"){
            if(tCPHAgnCodeTo!=''){
                tWhere += " AND TCNMBranch.FTAgnCode  ='"+tCPHAgnCodeTo+"' ";
            }else{
                tWhere += " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
            }

        }else{
            tWhere += "";
            if(tCPHAgnCodeTo!=''){
                tWhere += " AND TCNMBranch.FTAgnCode  ='"+tCPHAgnCodeTo+"' ";
            }
        }

        // if(tMerCode!=''){
        //     tWhere += " AND TCNMBranch.FTMerCode = '"+tMerCode+"' ";
        // }


        let oCPHOptionReturnBch    = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table:{Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table:	['TCNMBranch_L'],
                On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
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
                OrderBy			: ['TCNMBranch_L.FTBchCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tCPHInputReturnCodeBch,"TCNMBranch.FTBchCode"],
                Text		: [tCPHInputReturnNameBch,"TCNMBranch_L.FTBchName"]
            },

            RouteAddNew: 'branch',
            BrowseLev: 0
        };
        return oCPHOptionReturnBch;
    };

    // Browse Merchant Option
    var oCPHMerChantOption  = function(poReturnInputMer){
        let tMerInputReturnCode = poReturnInputMer.tReturnInputCode;
        let tMerInputReturnName = poReturnInputMer.tReturnInputName;
        let tMerNextFuncName    = poReturnInputMer.tNextFuncName;
        let aMerArgReturn       = poReturnInputMer.aArgReturn;
        let oMerOptionReturn    = {
            Title: ['company/merchant/merchant','tMerchantTitle'],
            Table: {Master:'TCNMMerchant',PK:'FTMerCode'},
            Join: {
                Table: ['TCNMMerchant_L'],
                On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits]
            },
            GrideView: {
                ColumnPathLang	: 'company/merchant/merchant',
                ColumnKeyLang	: ['tMerCode','tMerName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
                DataColumnsFormat : ['',''],
                Perpage			: 5,
                OrderBy			: ['TCNMMerchant.FTMerCode ASC'],
            },
            CallBack: {
                ReturnType	: 'S',
                Value		: [tMerInputReturnCode,"TCNMMerchant.FTMerCode"],
                Text		: [tMerInputReturnName,"TCNMMerchant_L.FTMerName"],
            },
            NextFunc : {
                FuncName    : tMerNextFuncName,
                ArgReturn   : aMerArgReturn
            },
            RouteAddNew: 'merchant',
            BrowseLev: 0,
        };
        return oMerOptionReturn;
    }

    // Browse Shop Option
    var oCPHShopOption = function(poReturnInputShp){
            let tShpNextFuncName        = poReturnInputShp.tNextFuncName;
            let aShpArgReturn           = poReturnInputShp.aArgReturn;
            let tShpInputReturnCode     = poReturnInputShp.tReturnInputCode;
            let tShpInputReturnName     = poReturnInputShp.tReturnInputName;

            let tShpCPHBranchForm       = poReturnInputShp.tCPHBranchForm;
            let tShpCPHBranchTo         = poReturnInputShp.tCPHBranchTo;
            let tShpWhereShop           = "";
            let tShpWhereShopAndBch     = "";

            // Case Report Type POS,VD,LK

                    // Report Pos (รานงานการขาย)
                    // tShpWhereShop       = " AND (TCNMShop.FTShpStaActive = 1) AND (TCNMShop.FTShpType = 1)";
                    // tShpWhereShopAndBch = " AND ((TCNMShop.FTBchCode BETWEEN "+tShpCPHBranchForm+" AND "+tShpCPHBranchTo+") OR (TCNMShop.FTBchCode BETWEEN "+tShpCPHBranchTo+" AND "+tShpCPHBranchForm+"))";

                    // Report Pos (รานงานการขาย) + Report Vending (รานงานตู้ขายสินค้า)
                    tShpWhereShop       = " AND (TCNMShop.FTShpStaActive = 1)";
                    tShpWhereShopAndBch = " AND ((TCNMShop.FTBchCode BETWEEN "+tShpCPHBranchForm+" AND "+tShpCPHBranchTo+") OR (TCNMShop.FTBchCode BETWEEN "+tShpCPHBranchTo+" AND "+tShpCPHBranchForm+"))";

            if(typeof tShpCPHBranchForm === 'undefined'  && typeof tShpCPHBranchTo === 'undefined'){
                // แสดงข้อมูล ร้านค้าทั้งหมดตามประเภทของรายงาน
                var oShopOptionReturn       = {
                    Title   : ['company/shop/shop','tSHPTitle'],
                    Table   : {Master:'TCNMShop', PK:'FTShpCode'},
                    Join    : {
                        Table   : ['TCNMShop_L', 'TCNMBranch_L'],
                        On      : [
                            'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                            'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
                        ]
                    },
                    Where :{
                        Condition : [tShpWhereShop]
                    },
                    GrideView:{
                        ColumnPathLang	: 'company/shop/shop',
                        ColumnKeyLang	: ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
                        ColumnsSize     : ['15%','15%','75%'],
                        WidthModal      : 50,
                        DataColumns		: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                        DataColumnsFormat : ['','',''],
                        Perpage			: 10,
                        OrderBy			: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                    },
                    CallBack:{
                        ReturnType	: 'S',
                        Value		: [tShpInputReturnCode,"TCNMShop.FTShpCode"],
                        Text		: [tShpInputReturnName,"TCNMShop_L.FTShpName"]
                    },
                    NextFunc : {
                        FuncName    : tShpNextFuncName,
                        ArgReturn   : aShpArgReturn
                    },
                    RouteAddNew: 'shop',
                    BrowseLev: 0
                };
            }else{
                if(tShpCPHBranchForm == "" && tShpCPHBranchTo == ""){
                    // แสดงข้อมูล ร้านค้าทั้งหมดตามประเภทของรายงาน
                    var oShopOptionReturn   = {
                        Title   : ['company/shop/shop','tSHPTitle'],
                        Table   : {Master:'TCNMShop', PK:'FTShpCode'},
                        Join    : {
                            Table   : ['TCNMShop_L', 'TCNMBranch_L'],
                            On      : [
                                'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                                'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
                            ]
                        },
                        Where :{
                            Condition : [tShpWhereShop]
                        },
                        GrideView:{
                            ColumnPathLang	: 'company/shop/shop',
                            ColumnKeyLang	: ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
                            ColumnsSize     : ['15%','15%','75%'],
                            WidthModal      : 50,
                            DataColumns		: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                            DataColumnsFormat : ['','',''],
                            Perpage			: 10,
                            OrderBy			: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                        },
                        CallBack:{
                            ReturnType	: 'S',
                            Value		: [tShpInputReturnCode,"TCNMShop.FTShpCode"],
                            Text		: [tShpInputReturnName,"TCNMShop_L.FTShpName"]
                        },
                        NextFunc : {
                            FuncName    : tShpNextFuncName,
                            ArgReturn   : aShpArgReturn
                        },
                        RouteAddNew: 'shop',
                        BrowseLev: 0
                    };
                }else{
                    // แสดงข้อมูลร้านค้า ตามสาขาที่เลือกไว้
                    var oShopOptionReturn   = {
                        Title   : ['company/shop/shop','tSHPTitle'],
                        Table   : {Master:'TCNMShop', PK:'FTShpCode'},
                        Join    : {
                            Table   : ['TCNMShop_L', 'TCNMBranch_L'],
                            On      : [
                                'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                                'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
                            ]
                        },
                        Where :{
                            Condition : [tShpWhereShop+tShpWhereShopAndBch]
                        },
                        GrideView:{
                            ColumnPathLang	: 'company/shop/shop',
                            ColumnKeyLang	: ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
                            ColumnsSize     : ['15%','15%','75%'],
                            WidthModal      : 50,
                            DataColumns		: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                            DataColumnsFormat : ['','',''],
                            Perpage			: 10,
                            OrderBy			: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                        },
                        CallBack:{
                            ReturnType	: 'S',
                            Value		: [tShpInputReturnCode,"TCNMShop.FTShpCode"],
                            Text		: [tShpInputReturnName,"TCNMShop_L.FTShpName"]
                        },
                        NextFunc : {
                            FuncName    : tShpNextFuncName,
                            ArgReturn   : aShpArgReturn
                        },
                        RouteAddNew: 'shop',
                        BrowseLev: 0
                    }
                }
            }
            return oShopOptionReturn;
        };



        /*===== Begin Event Next Function Browse ========================================== */
        // Functionality : Next Function Branch And Check Data Shop And Clear Data
        // Parameter : Event Next Func Modal
        // Create : 30/09/2019 Wasin(Yoshi)
        // update : 03/10/2019 Saharat(Golf)
        // Return : Clear Velues Data
        // Return Type : -
        function JSxCPHConsNextFuncBrowseBch(poDataNextFunc){
            if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
                let aDataNextFunc   = JSON.parse(poDataNextFunc);
                tBchCode      = aDataNextFunc[0];
                tBchName      = aDataNextFunc[1];
            }

            // ประกาศตัวแปร สาขา
            var tCPHBchCodeTo,tCPHBchNameTo
            tCPHBchCodeTo   = $('#oetCPHBchCodeTo').val();
            tCPHBchNameTo   = $('#oetCPHBchNameTo').val();

            // เช็คข้อมูลถ้ามีการ Browse จากสาขา ให้ default ถึงสาขา เป็นข้อมูลเดียวกัน
            if((typeof(tCPHBchCodeTo) !== 'undefined' && tCPHBchCodeTo == "")){
                $('#oetCPHBchCodeTo').val(tBchCode);
                $('#oetCPHBchNameTo').val(tBchName);
            }


            var tCPHShopCodeTo
            tCPHShopCodeTo      = $('#oetCPHShpCodeTo').val();
            if( (typeof(tCPHShopCodeTo) !== 'undefined' && tCPHShopCodeTo != "")){
                $('#oetCPHShpCodeTo').val('');
                $('#oetCPHShpNameTo').val('');
            }
        }

        // Functionality : Next Function Shop And Check Data Pos And Clear Data
        // Parameter : Event Next Func Modal
        // Create : 30/09/2019 Wasin(Yoshi)
        // update : 03/10/2019 Sahart(Golf)
        // Return : Clear Velues Data
        // Return Type : -
        function JSxCPHConsNextFuncBrowseShp(poDataNextFunc){

            if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
                let aDataNextFunc   = JSON.parse(poDataNextFunc);
                tShpCode = aDataNextFunc[0];
                tShpName = aDataNextFunc[1];
            }

            // ประกาศตัวแปร ร้านค้า
            var tCPHShpCodeTo,tCPHShpNameTo

            tCPHShpCodeTo   = $('#oetCPHShpCodeTo').val();
            tCPHShpNameTo   = $('#oetCPHShpNameTo').val();

            // เช็คข้อมูลถ้ามีการ Browse จากร้านค้า ให้ default ถึงร้านค้า เป็นข้อมูลเดียวกัน
            if((typeof(tCPHShpCodeTo) !== 'undefined' && tCPHShpCodeTo == "")){
                $('#oetCPHShpCodeTo').val(tShpCode);
                $('#oetCPHShpNameTo').val(tShpName);
            }



            var tCPHPosCodeTo

            tCPHPosCodeTo   = $('#oetCPHPosCodeTo').val();
            if((typeof(tCPHPosCodeTo) !== 'undefined' && tCPHPosCodeTo != "")){

                $('#oetCPHPosCodeTo').val('');
                $('#oetCPHPosNameTo').val('');
            }


            // ประกาศตัวแปร ร้านค้าที่โอน
            var tCPHShpTCodeTo   = $('#oetCPHShpTCodeTo').val();
            var tCPHShpTNameTo   = $('#oetCPHShpTNameTo').val();

            // เช็คข้อมูลถ้ามีการ Browse จากร้านค้าที่โอน ให้ default ถึงร้านค้าที่โอน เป็นข้อมูลเดียวกัน
            if((typeof(tCPHShpTCodeTo) !== 'undefined' && tCPHShpTCodeTo == "")){
                $('#oetCPHShpTCodeTo').val(tShpCode);
                $('#oetCPHShpTNameTo').val(tShpName);
            }



            // ประกาศตัวแปร ร้านค้าที่รับโอน
            var tCPHShpRCodeTo   = $('#oetCPHShpRCodeTo').val();
            var tCPHShpRNameTo   = $('#oetCPHShpRNameTo').val();

            // เช็คข้อมูลถ้ามีการ Browse จากร้านค้าที่รับโอน ให้ default ถึงร้านค้าที่รับโอน เป็นข้อมูลเดียวกัน
            if((typeof(tCPHShpRCodeTo) !== 'undefined' && tCPHShpRCodeTo == "")){
                $('#oetCPHShpRCodeTo').val(tShpCode);
                $('#oetCPHShpRNameTo').val(tShpName);
            }


        }


        // Functionality : Next Function MerChant And Check Data
        // Parameter : Event Next Func Modal
        // Create : 04/10/2019 Saharat(Golf)
        // Return : Clear Velues Data
        // Return Type : -
        function  JSxCPHConsNextFuncBrowseMerChant(poDataNextFunc){

            if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
                let aDataNextFunc   = JSON.parse(poDataNextFunc);
                tMerCode      = aDataNextFunc[0];
                tMerName      = aDataNextFunc[1];
            }

            // ประกาศตัวแปร กลุ่มธุรกิจ
            var tCPHMerCodeTo,tCPHPdtNameTo
            tCPHMerCodeTo   = $('#oetCPHMerCodeTo').val();
            tCPHMerNameTo   = $('#oetCPHMerNameTo').val();

            // เช็คข้อมูลถ้ามีการ Browse จากกลุ่มธุรกิจ ให้ default ถึงกลุ่มธุรกิจ เป็นข้อมูลเดียวกัน
            if( (typeof(tCPHMerCodeTo) !== 'undefined' && tCPHMerCodeTo == "")){
                $('#oetCPHMerCodeTo').val(tMerCode);
                $('#oetCPHMerNameTo').val(tMerName);
            }


    }

    $('#obtTabCouponHDBchInclude').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            $('#oetCPHBchCodeTo').val('');
            $('#oetCPHBchNameTo').val('');
            $('#oetCPHMerCodeTo').val('');
            $('#oetCPHMerNameTo').val('');
            $('#oetCPHShpCodeTo').val('');
            $('#oetCPHShpNameTo').val('');
            $('#ohdCPHcouponModalTypeInclude').val(1);
            $("#odvCPHCouponHDBch").modal({backdrop: "static", keyboard: false});
             $("#odvCPHCouponHDBch").modal({show: true});
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtTabCouponHDBchExclude').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            $('#oetCPHBchCodeTo').val('');
            $('#oetCPHBchNameTo').val('');
            $('#oetCPHMerCodeTo').val('');
            $('#oetCPHMerNameTo').val('');
            $('#oetCPHShpCodeTo').val('');
            $('#oetCPHShpNameTo').val('');
            $('#ohdCPHcouponModalTypeInclude').val(2);
            $("#odvCPHCouponHDBch").modal({backdrop: "static", keyboard: false});
            $("#odvCPHCouponHDBch").modal({show: true});
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Functionality :
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxConsNextFuncBrowseBchInclude(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
            var i = Date.now();
            var tMarkUp ="";
                tMarkUp +="<tr class='otrInclude' id='otrCPHcouponIncludeBch"+i+"'>";
                tMarkUp +="<td>";
                tMarkUp +="<input type='hidden' name='ohdCPHCouponIncludeAgnCode["+i+"]' class='ohdCPHCouponIncludeAgnCode' value='"+poDataNextFunc.tCPHAgnCodeTo+"'>";
                tMarkUp +="<input type='hidden' name='ohdCPHCouponIncludeBchCode["+i+"]' class='ohdCPHCouponIncludeBchCode' value='"+poDataNextFunc.tCPHBchCodeTo+"'>";
                tMarkUp +="<input type='hidden' name='ohdCPHCouponIncludeMerCode["+i+"]' class='ohdCPHCouponIncludeMerCode' value='"+poDataNextFunc.tCPHMerCodeTo+"'>";
                tMarkUp +="<input type='hidden' name='ohdCPHCouponIncludeShpCode["+i+"]' class='ohdCPHCouponIncludeShpCode' value='"+poDataNextFunc.tCPHShpCodeTo+"'>";
                tMarkUp +=poDataNextFunc.tCPHAgnNameTo+"</td>";
                tMarkUp +="<td>"+poDataNextFunc.tCPHBchNameTo+"</td>";
                tMarkUp +="<td>"+poDataNextFunc.tCPHMerNameTo+"</td>";
                tMarkUp +="<td>"+poDataNextFunc.tCPHShpNameTo+"</td>";
                tMarkUp +="<td align='center'><img onclick='JSxCPHcouponRemoveTRIncludeBch("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                tMarkUp +="</tr>";
            $('#otbCouponHDBchInclude').append(tMarkUp);
        }
    }

    function JSxCPHcouponRemoveTRIncludeBch(ptCode){
        $('#otrCPHcouponIncludeBch'+ptCode).remove();
    }

    // Functionality :
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxConsNextFuncBrowseBchExclude(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
        //   var  aCPHCouponExcludeBchCode = $('#ohdCPHCouponExcludeBchCode').val().split(",");
        //   var  aCPHCouponExcludeBchName = $('#ohdCPHCouponExcludeBchName').val().split(",");

        var i = Date.now();

          var tMarkUp ="";
                    tMarkUp +="<tr class='otrExclude' id='otrCPHcouponExcludeBch"+i+"'>";
                    tMarkUp +="<td>";
                    tMarkUp +="<input type='hidden' name='ohdCPHCouponExcludeAgnCode["+i+"]' class='ohdCPHCouponExcludeAgnCode' value='"+poDataNextFunc.tCPHAgnCodeTo+"'>";
                    tMarkUp +="<input type='hidden' name='ohdCPHCouponExcludeBchCode["+i+"]' class='ohdCPHCouponExcludeBchCode' value='"+poDataNextFunc.tCPHBchCodeTo+"'>";
                    tMarkUp +="<input type='hidden' name='ohdCPHCouponExcludeMerCode["+i+"]' class='ohdCPHCouponExcludeMerCode' value='"+poDataNextFunc.tCPHMerCodeTo+"'>";
                    tMarkUp +="<input type='hidden' name='ohdCPHCouponExcludeShpCode["+i+"]' class='ohdCPHCouponExcludeShpCode' value='"+poDataNextFunc.tCPHShpCodeTo+"'>";
                    tMarkUp +=poDataNextFunc.tCPHAgnNameTo+"</td>";
                    tMarkUp +="<td>"+poDataNextFunc.tCPHBchNameTo+"</td>";
                    tMarkUp +="<td>"+poDataNextFunc.tCPHMerNameTo+"</td>";
                    tMarkUp +="<td>"+poDataNextFunc.tCPHShpNameTo+"</td>";
                    tMarkUp +="<td align='center'><img onclick='JSxCPHcouponRemoveTRExcludeBch("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                    tMarkUp +="</tr>";


                $('#otbCouponHDBchExclude').append(tMarkUp);
        }
    }

    function JSxCPHcouponRemoveTRExcludeBch(ptCode){
        $('#otrCPHcouponExcludeBch'+ptCode).remove();
    }

    //หยุดการใช้คูปอง - ปุ่มยกเลิก
    function JSxModalCancleStopCoupon(){
        if( $('input[name="oetCPHFrmCphStaClosed"]:checked').val() == 'on'){
            $('#oetCPHFrmCphStaClosed').prop('checked',false);
        }else{
            $('#oetCPHFrmCphStaClosed').prop('checked',true);
        }
    }

    //หยุดการใช้คูปอง - ปุ่มตกลง
    function JSxModalConfirmStopCoupon(){
        if( $('input[name="oetCPHFrmCphStaClosed"]:checked').val() == 'on'){
            $('#oetCPHFrmCphStaClosed').prop('checked',true);
        }else{
            $('#oetCPHFrmCphStaClosed').prop('checked',false);
        }
        JSxCPHChangStatusAfApv();
    }
</script>
