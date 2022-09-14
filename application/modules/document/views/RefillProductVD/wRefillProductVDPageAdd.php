<style>
	#odvLineStep {
		width           : 100%;
		height          : 20%;
		margin-top      : 40px;
		margin-bottom   : 20px;
	}

    #odvLinerStep {
		height          : 2px;
		width           : 99%;
		background      : #1d2530;
		border-radius   : 5px;
		margin          : auto;
		top             : 50%;
		transform       : translateY(-50%);
		position        : relative;
	}

	.xCNRefillVDCircle {
		width           : 20px;
		height          : 20px;
		background      : #ffffff;
		border-radius   : 15px;
		position        : absolute;
		top             : -9px;
		border          : 2px solid #1d2530;
		cursor          : pointer;
	}

	.xCNRefillVDCircle.active{
		background      : #1d2530;
	}

	.xCNRefillVDCircle .xCNRefillVDPopupSpan {
		width           : auto;
		height          : auto;
		padding         : 10px;
		white-space     : nowrap;
		color           : #1d2530;
		position        : absolute;
		top             : -36px;
		left            : -10px;
		transition      : all 0.1s ease-out;
	}
	.xCNRefillVDCircle.active .xCNRefillVDPopupSpan {
		font-weight     : 900;
	}
</style>

<?php
    if (isset($aDataDocHD) && $aDataDocHD['rtCode'] == "1") {
        $tTypePage              = 'PAGEEDIT';
        $tRVDRoute              = "docRVDRefillPDTVDEventEdit";
        $tRVDBchCode            = $aDataDocHD['raItems']['FTBchCode'];
        $tRVDBchName            = $aDataDocHD['raItems']['FTBchName'];
        $tRVDDocNo              = $aDataDocHD['raItems']['FTXthDocNo'];
        $dRVDDocDate            = date("Y-m-d",strtotime($aDataDocHD['raItems']['FDXthDocDate']));
        $dRVDDocTime            = date("H:i:s",strtotime($aDataDocHD['raItems']['FDXthDocDate']));
        $tRVDUsrNameCreateBy    = $aDataDocHD['raItems']['FTUsrName'];
        $tRVDStaDoc             = $aDataDocHD['raItems']['FTXthStaDoc'];
        $tRVDStaApv             = $aDataDocHD['raItems']['FTXthStaApv'];
        $tRVDStaPrcStk          = $aDataDocHD['raItems']['FTXthStaPrcStk'];
        $tRVDApvCode            = $aDataDocHD['raItems']['FTXthApvCode'];
        $tRVDUsrNameApv         = $aDataDocHD['raItems']['FTUsrNameApv'];
        $tRVDTrnRmk             = $aDataDocHD['raItems']['FTXthRmk'];
        $tCusTransferCode       = $aDataDocHD['raItems']['FTUsrCode'];
        $tCusTransferName       = $aDataDocHD['raItems']['NameKey'];
        $tWahTransferCode       = $aDataDocHD['raItems']['FTXthShipWhTo'];
        $tWahTransferName       = $aDataDocHD['raItems']['FTWahName'];
        $tWahTransferByCode     = $aDataDocHD['raItems']['FTViaCode'];
        $tWahTransferByName     = $aDataDocHD['raItems']['FTViaName'];
        $tTransferRefCode       = $aDataDocHD['raItems']['FTXthRefExt'];
        $tTransferRefIDCode     = $aDataDocHD['raItems']['FTXthRefInt'];
        $tRVDRsnName            = $aDataDocHD['raItems']['FTRsnName'];
        $tRVDRsnCode            = $aDataDocHD['raItems']['FTRsnCode'];
        $tFlagCheckSTK          = $aDataDocHD['raItems']['FTXthStaChkBal'];
    } else {
        $tTypePage              = 'PAGEADD';
        $tRVDRoute              = "docRVDRefillPDTVDEventAdd";
        $tRVDBchCode            = $this->session->userdata('tSesUsrBchCodeDefault');
        $tRVDBchName            = $this->session->userdata('tSesUsrBchNameDefault');
        $tRVDDocNo              = "";
        $dRVDDocDate            = date('Y-m-d');
        $dRVDDocTime            = date("H:i:s");
        $tRVDUsrNameCreateBy    = "-";
        $tRVDStaDoc             = "";
        $tRVDStaApv             = "";
        $tRVDStaPrcStk          = "";
        $tRVDApvCode            = "";
        $tRVDUsrNameApv         = "";
        $tRVDTrnRmk             = "";
        $tCusTransferCode       = "";
        $tCusTransferName       = "";
        $tWahTransferCode       = "";
        $tWahTransferName       = "";
        $tWahTransferByCode     = "";
        $tWahTransferByName     = "";
        $tTransferRefCode       = "";
        $tTransferRefIDCode     = "";
        $tRVDRsnName            = "";
        $tRVDRsnCode            = "";
        $tFlagCheckSTK          = "1";
    }
?>
<form id="ofmRVDFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button style="display:none" type="submit" id="obtSubmitRVD" onclick="JSxRVDEventAddEdit('<?=$tRVDRoute?>')"></button>

    <input type="hidden" id="ohdBaseUrl"    name="ohdBaseUrl"       value="<?= base_url(); ?>">
    <input type="hidden" id="ohdRVDRoute"   name="ohdRVDRoute"      value="<?= $tRVDRoute; ?>">
    <input type="hidden" id="ohdRVDStaApv"  name="ohdRVDStaApv"     value="<?= $tRVDStaApv; ?>">
    <input type="hidden" id="ohdRVDStaDoc"  name="ohdRVDStaDoc"     value="<?= $tRVDStaDoc; ?>">
	<input type="hidden" id="ohdLangEdit"   name="ohdLangEdit"      value="<?= $this->session->userdata("tLangEdit"); ?>">

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDDocument'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvRVDDataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvRVDDataStatusInfo" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="xCNTitleFrom "><?= language('document/RefillProductVD/RefillProductVD', 'tRVDApproved'); ?></label>
                                </div>
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/RefillProductVD/RefillProductVD', 'tRVDDocNo'); ?></label>
                                <?php if (empty($tRVDDocNo)) : ?>
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbRVDStaAutoGenCode" name="ocbRVDStaAutoGenCode" maxlength="1" checked="true" value="1">
                                            <span><?= language('document/RefillProductVD/RefillProductVD', 'tRVDAutoGenCode'); ?></span>
                                        </label>
                                    </div>
                                <?php endif; ?>

                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input type="text" class="form-control xWTooltipsBT xCNInputWithoutSpcNotThai xCNInputWOthoutSingleQuote" id="oetRVDDocNo" name="oetRVDDocNo" maxlength="20" value="<?= $tRVDDocNo; ?>"
                                    data-validate-required="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDPlsEnterOrRunDocNo'); ?>"
                                    data-validate-duplicate="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDPlsDocNoDuplicate'); ?>"
                                    placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDDocNo'); ?>" style="pointer-events:none" readonly>
                                </div>

                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/RefillProductVD/RefillProductVD', 'tRVDDocDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetRVDDocDate" name="oetRVDDocDate" value="<?= $dRVDDocDate; ?>"
                                        data-validate-required="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDPlsEnterDocDate'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtRVDDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/RefillProductVD/RefillProductVD', 'tRVDDocTime'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNTimePicker xCNApvOrCanCelDisabled" id="oetRVDDocTime" name="oetRVDDocTime" value="<?= $dRVDDocTime; ?>"
                                        data-validate-required="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDPlsEnterDocTime'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtRVDDocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDCreateBy'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= $tRVDUsrNameCreateBy ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDTBStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= language('document/RefillProductVD/RefillProductVD', 'tRVDStaDoc' . $tRVDStaDoc); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= language('document/RefillProductVD/RefillProductVD', 'tRVDStaApv' . $tRVDStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- ผู้อนุมัติเอกสาร -->
                                <?php if (isset($tRVDDocNo) && !empty($tRVDDocNo)) : ?>
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdRVDApvCode" name="ohdRVDApvCode" maxlength="20" value="<?= $tRVDApvCode ?>">
                                                <label>
                                                    <?= (isset($tRVDUsrNameApv) && !empty($tRVDUsrNameApv)) ? $tRVDUsrNameApv : "-" ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel การขนส่ง -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDPanelTransport'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvRVDDataConditionTransport" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvRVDDataConditionTransport" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">

                                <!--สาขา-->
                                <script>
                                    var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                                    if( tUsrLevel != "HQ" ){
                                        var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
                                        if(tBchCount < 2){
                                            $('#obtBrowseBchTransfer').attr('disabled',true);
                                        }
                                    }
                                </script>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchBranch'); ?></label>
                                    <div class="input-group">
                                        <input name="oetRVDBchName" id="oetRVDBchName" class="form-control xCNApvOrCanCelDisabled" value="<?=$tRVDBchName ?>" type="text" readonly="" placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchBranch') ?>">
                                        <input name="oetRVDBchCode" id="oetRVDBchCode" value="<?= $tRVDBchCode ?>" class="form-control xCNHide" type="text">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseBchTransfer" type="button">
                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!--พนักงานขนส่ง / เติม-->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/RefillProductVD/RefillProductVD', 'tRVDCUSTransfer'); ?></label>
                                    <div class="input-group">
                                        <input name="oetRVDCusTransferName" id="oetRVDCusTransferName" class="form-control xCNApvOrCanCelDisabled" value="<?= $tCusTransferName ?>" type="text" readonly="" placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDCUSTransfer') ?>">
                                        <input name="oetRVDCusTransferCode" id="oetRVDCusTransferCode" value="<?= $tCusTransferCode ?>" class="form-control xCNHide" type="text">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseCusTransfer" type="button">
                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!--คลังรถขนส่ง-->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/RefillProductVD/RefillProductVD', 'tRVDWahTransfer'); ?></label>
                                    <div class="input-group">
                                        <input name="oetRVDWahTransferName" id="oetRVDWahTransferName" class="form-control xCNApvOrCanCelDisabled" value="<?= $tWahTransferName ?>" type="text" readonly="" placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDWahTransfer') ?>">
                                        <input name="oetRVDWahTransferCode" id="oetRVDWahTransferCode" value="<?= $tWahTransferCode ?>" class="form-control xCNHide" type="text">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseWahTransfer" type="button">
                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!--ขนส่งโดย-->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDWahTransferBy'); ?></label>
                                    <div class="input-group">
                                        <input name="oetRVDWahTransferByName" id="oetRVDWahTransferByName" class="form-control xCNApvOrCanCelDisabled" value="<?= $tWahTransferByName ?>" type="text" readonly="" placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDWahTransferBy') ?>">
                                        <input name="oetRVDWahTransferByCode" id="oetRVDWahTransferByCode" value="<?= $tWahTransferByCode ?>" class="form-control xCNHide" type="text">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseWahTransferBy" type="button">
                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!--เลขที่อ้างอิงขนส่ง-->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDWahTransferRefCode'); ?></label>
                                    <input name="oetRVDWahTransferRefCode" id="oetRVDWahTransferRefCode" class="form-control xCNApvOrCanCelDisabled" value="<?= $tTransferRefCode ?>" type="text" placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDWahTransferRefCode') ?>">
                                </div>

                                <!--เลขที่ใบขนส่ง-->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDWahTransferRefIDCode'); ?></label>
                                    <input name="oetRVDWahTransferRefIDCode" id="oetRVDWahTransferRefIDCode" class="form-control xCNApvOrCanCelDisabled" value="<?= $tTransferRefIDCode ?>" type="text" placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDWahTransferRefIDCode') ?>">
                                </div>

                                <!--อนุญาตให้เติมสินค้า โดยไม่สนใจ stock-->
                                <div class="form-group" style="display:none;">
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbRVDStaFullRefillPos" name="ocbRVDStaFullRefillPos" maxlength="1"
                                            <?=($tFlagCheckSTK == '1') ? "checked" : "" ?> >
                                            <span>ตรวจสอบสต็อกต้นทาง</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel อื่นๆ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDPanelETC'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvRVDDataConditionETC" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvRVDDataConditionETC" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">

                        <!--เลือกเหตุผล-->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDReason'); ?></label>
                            <div class="input-group">
                                <input name="oetRVDReasonName" id="oetRVDReasonName" class="form-control" value="<?=$tRVDRsnName?>" type="text" readonly=""
                                        placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDReason') ?>">
                                <input name="oetRVDReasonCode" id="oetRVDReasonCode" value="<?=$tRVDRsnCode?>" class="form-control xCNHide" type="text">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseRVDReason" type="button">
                                        <img src="<?= base_url().'/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- หมายเหตุ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDLabelFrmInfoOthRemark'); ?></label>
                            <textarea class="form-control xCNApvOrCanCelDisabled" id="otaRVDFrmInfoOthRmk" name="otaRVDFrmInfoOthRmk" rows="10" maxlength="200" style="resize: none;height:86px;"><?= $tRVDTrnRmk; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div class="row">
                <!-- ตารางสินค้า -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:200px;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">
                                <div style="margin-top: 10px;">

                                    <!--ตาราง-->
                                    <div class="row p-t-10" id="odvRVDDataPdtTableDTTemp">
                                        <div class="col-md-12">
                                            <div id="odvLineStep">
                                                <div id="odvLinerStep">
                                                    <div class="xCNRefillVDCircle active xCNRefillVDStep1" data-tab="odvRefillVDStep1" data-step="1" style="left: 0px;">
                                                        <div class="xCNRefillVDPopupSpan"><?=language('document/RefillProductVD/RefillProductVD', 'tTextStep1'); ?></div>
                                                    </div>
                                                    <div class="xCNRefillVDCircle xCNRefillVDStep2" data-tab="odvRefillVDStep2" data-step="2" style="left: 33%;">
                                                        <div class="xCNRefillVDPopupSpan"><?=language('document/RefillProductVD/RefillProductVD', 'tTextStep2'); ?></div>
                                                    </div>
                                                    <div class="xCNRefillVDCircle xCNRefillVDStep3" data-tab="odvRefillVDStep3" data-step="3" style="left: 66%;">
                                                        <div class="xCNRefillVDPopupSpan"><?=language('document/RefillProductVD/RefillProductVD', 'tTextStep3'); ?></div>
                                                    </div>
                                                    <div class="xCNRefillVDCircle xCNRefillVDStep4" data-tab="odvRefillVDStep4" data-step="4" style="left: 99%;">
                                                        <div class="xCNRefillVDPopupSpan" style="left:-100px;"><?=language('document/RefillProductVD/RefillProductVD', 'tTextStep4'); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <ul class="nav nav-tabs hidden">
                                                <li class="active"><a data-toggle="tab" href="#odvRefillVDStep1"></a></li>
                                                <li><a data-toggle="tab" href="#odvRefillVDStep2"></a></li>
                                                <li><a data-toggle="tab" href="#odvRefillVDStep3"></a></li>
                                                <li><a data-toggle="tab" href="#odvRefillVDStep4"></a></li>
                                            </ul>

                                            <div class="tab-content">
                                                <input type="hidden" id="ohdClickStep" value="1">

                                                <!-- Step Control -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNRefillBackStep" type="button" style="display: inline-block; width:150px;"> <?= language('sale/promotiontopup/promotiontopup', 'tBack'); ?></button>
                                                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNRefillNextStep" type="button" style="display: inline-block; width:150px;"> <?= language('sale/promotiontopup/promotiontopup', 'tNext'); ?></button>
                                                    </div>
                                                </div>

                                                <div id="odvRefillVDStep1" class="tab-pane fade in active">
                                                    <?php include('step/step1/wRefillVDStep1.php'); ?>
                                                </div>
                                                <div id="odvRefillVDStep2" class="tab-pane fade">
                                                    <?php include('step/step2/wRefillVDStep2.php'); ?>
                                                </div>
                                                <div id="odvRefillVDStep3" class="tab-pane fade">
                                                    <?php include('step/step3/wRefillVDStep3.php'); ?>
                                                </div>
                                                <div id="odvRefillVDStep4" class="tab-pane fade">
                                                    <?php include('step/step4/wRefillVDStep4.php'); ?>
                                                </div>
                                            </div>
                                        </div>
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

<!-- อนุมัติเอกสาร -->
<div id="odvRVDModalAppoveDoc" class="modal fade xCNModalApprove">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?= language('common/main/main', 'tApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?= language('common/main/main', 'tMainApproveStatus'); ?></p>
                <ul>
                    <li><?= language('common/main/main', 'tMainApproveStatus1'); ?></li>
                    <li><?= language('common/main/main', 'tMainApproveStatus2'); ?></li>
                    <li><?= language('common/main/main', 'tMainApproveStatus3'); ?></li>
                    <li><?= language('common/main/main', 'tMainApproveStatus4'); ?></li>
                </ul>
                <p><?= language('common/main/main', 'tMainApproveStatus5'); ?></p>
                <p><strong><?= language('common/main/main', 'tMainApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxRVDApprovedDocument(true,true)" type="button" class="btn xCNBTNPrimery">
                    <?= language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- อนุมัติ progress split ตามเอกสาร -->
<div class="modal fade" id="odvProgressSplit" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?= language('common/main/main', 'tApproveTheDocument'); ?></label>
			</div>
			<div class="modal-body">
                <input type="hidden" name="ohdDocumentprintTopup" id="ohdDocumentprintTopup">
				<div id="odvProgressSplitContent"></div>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal" onclick="JSvRVDCallPageList(); JSvRVDPrintDocumentTopup();">
                    <?=language('common/main/main', 'tCMNPrint')?>
				</button>
				<button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal" onclick="JSvRVDCallPageList();">
                    <?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!-- ยกเลิกเอกสาร -->
<div id="odvRVDPopupCancel" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/document/document', 'tDocDocumentCancel') ?></label>
            </div>
            <div class="modal-body">
                <p id="obpMsgApv"><strong><?= language('common/main/main', 'tDocCancelAlert2') ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSvRVDCancleDocument(true)" type="button" class="btn xCNBTNPrimery">
                    <?= language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ต้องกดดูให้ครบทุกแท็บ -->
<div class="modal fade" id="odvRecheckFullTab" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document', 'tDocStawarning') ?></label>
			</div>
			<div class="modal-body">
				<p><?=language('document/RefillProductVD/RefillProductVD', 'tTextRecheckFullTab'); ?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal" onclick="JSxRVDBackToStep1()">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!-- มีสินค้าไม่เพียงพอสำหรับ pos -->
<div class="modal fade" id="odvRVDAVGPDT" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document', 'tDocStawarning') ?></label>
			</div>
			<div class="modal-body">
                <p>จำนวนสินค้าไม่สามารถเติมให้เต็มสำหรับทุกตู้ขาย กดยืนยันเพื่อเป็นการเติมแบบเฉลี่ยทุกตู้ขาย </p>
                <p>(ดูรายละเอียดการเฉลี่ยที่แท็บกำหนดสินค้า)</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal" onclick="JSxRVDApprovedDocument(true,'PASS')">
					<?=language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<!-- ไม่มีสินค้าเอาเข้า step 1 -->
<div class="modal fade" id="odvPDTInStep1IsEmpty" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document', 'tDocStawarning') ?></label>
			</div>
			<div class="modal-body">
				<p><?=language('document/RefillProductVD/RefillProductVD', 'tTextPDTInStep1IsEmpty'); ?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal" onclick="JSxRVDBackToStep1()">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!-- ไม่มีสินค้าเอาเข้า step 2 -->
<div class="modal fade" id="odvPDTInStep2IsEmpty" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document', 'tDocStawarning') ?></label>
			</div>
			<div class="modal-body">
				<p><?=language('document/RefillProductVD/RefillProductVD', 'tTextPDTInStep2IsEmpty'); ?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal" onclick="JSxRVDBackToStep2()">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<?php include('script/jRefillProductVDAdd.php'); ?>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
