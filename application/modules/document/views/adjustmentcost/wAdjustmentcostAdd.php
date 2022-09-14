<?php
if (isset($aDataDocHD) && $aDataDocHD['rtCode'] == "1") {
    $tADCRoute              = "docADCEventEdit";
    $tADCDocNo              = $aDataDocHD['raItems']['FTXchDocNo'];
    $dADCDocDate            = $aDataDocHD['raItems']['FDXchDocDate'];
    $dADCDocTime            = $aDataDocHD['raItems']['FTXchDocTime'];
    $tADCCreateBy           = $aDataDocHD['raItems']['FTUsrNameCreate'];
    $tADCStaDoc             = $aDataDocHD['raItems']['FTXchStaDoc'];
    $tADCStaApv             = $aDataDocHD['raItems']['FTXchStaApv'];
    $tADCApvCode            = $aDataDocHD['raItems']['FTXchApvCode'];
    $tADCBchCode            = $aDataDocHD['raItems']['FTBchCode'];
    $tADCBchName            = $aDataDocHD['raItems']['FTBchName'];
    $tADCAffect             = $aDataDocHD['raItems']['FDXchAffect'];
    $tADCDptCode            = $aDataDocHD['raItems']['FTDptCode'];
    $tADCDptName            = $aDataDocHD['raItems']['FTDptName'];
    $tADCUsrCodeCreateBy    = $aDataDocHD['raItems']['FTCreateBy'];
    $tADCDocType            = $aDataDocHD['raItems']['FNXchDocType'];
    $tADCRefInt             = $aDataDocHD['raItems']['FTXchRefInt'];
    $tADCRefIntDate         = $aDataDocHD['raItems']['FDXchRefIntDate'];
    $tADCRmk                = $aDataDocHD['raItems']['FTXchRmk'];
    $tADCUsrNameApv         = $aDataDocHD['raItems']['FTUsrNameApv'];
} else {
    $tADCRoute              = "docADCEventAdd";
    $tADCDocNo              = '';
    $dADCDocDate            = '';
    $dADCDocTime            = date('H:i');
    $tADCCreateBy           = $this->session->userdata('tSesUsrUsername');
    $tADCStaDoc             = '';
    $tADCStaApv             = '';
    $tADCApvCode            = $this->session->userdata('tSesUserCode');
    $tADCBchCode            = $this->session->userdata("tSesUsrBchCodeDefault");
    $tADCBchName            = $this->session->userdata("tSesUsrBchNameDefault");
    $tADCAffect             = '';
    $tADCDptCode            = $this->session->userdata("tSesUsrDptCode");
    $tADCDptName            = $this->session->userdata("tSesUsrDptName");
    $tADCUsrCodeCreateBy    = $this->session->userdata('tSesUserCode');
    $tADCDocType            = '';
    $tADCRefInt             = '';
    $tADCRefIntDate         = '';
    $tADCRmk                = '';
    $tADCUsrNameApv         = $this->session->userdata('tSesUsrUsername');
}
$tASTUserType = $this->session->userdata("tSesUsrLevel");
?>
<form id="ofmADCFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdADCCountDocRemark" name="ohdADCCountDocRemark" value="0">
    <input type="hidden" id="ohdADCPdtDupCode" name="ohdADCPdtDupCode" value="">
    <input type="hidden" id="ohdADCRoute" name="ohdADCRoute" value="<?php echo $tADCRoute ?>">
    <input type="hidden" id="ohdADCDocNo" name="ohdADCDocNo" value="<?php echo $tADCDocNo ?>">
    <input type="hidden" id="ohdADCStaApv" name="ohdADCStaApv" value="<?php echo $tADCStaApv ?>">
    <input type="hidden" id="ohdADCStaDoc" name="ohdADCStaDoc" value="<?php echo $tADCStaDoc ?>">
    <input type="hidden" id="ohdADCUsrApvMQ" name="ohdADCUsrApvMQ" value="<?php echo $this->session->userdata('tSesUserCode') ?>">
    <input type="hidden" id="ohdADCUsrApv" name="ohdADCUsrApv" value="<?php echo $tADCApvCode ?>">
    <input type="hidden" id="ohdADCLang" name="ohdADCLang" value="<?php echo $this->session->userdata("tLangEdit"); ?>">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvADCHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCDocument'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvADCDataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvADCDataStatusInfo" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="xCNTitleFrom "><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCApproved'); ?></label>
                                </div>
                                <input type="hidden" value="0" id="ohdCheckADCSubmitByButton" name="ohdCheckADCSubmitByButton">
                                <input type="hidden" value="0" id="ohdCheckADCClearValidate" name="ohdCheckADCClearValidate">

                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCDocNo'); ?></label>
                                <?php if (empty($tADCDocNo)) : ?>
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbADCStaAutoGenCode" name="ocbADCStaAutoGenCode" maxlength="1" checked="true" value="1">
                                            <span class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAutoGenCode'); ?></span>
                                        </label>
                                    </div>
                                <?php endif; ?>

                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input type="text" class="form-control xWTooltipsBT xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetADCDocNo" name="oetADCDocNo" maxlength="20" value="<?php echo $tADCDocNo; ?>" data-validate-required="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCPlsEnterOrRunDocNo'); ?>" data-validate-duplicate="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCPlsDocNoDuplicate'); ?>" placeholder="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCDocNo'); ?>" style="pointer-events:none" readonly>
                                    <input type="hidden" id="ohdADCCheckDuplicateCode" name="ohdADCCheckDuplicateCode" value="2">
                                </div>

                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCDocDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetADCDocDate" name="oetADCDocDate" value="<?php echo $dADCDocDate; ?>" data-validate-required="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCPlsEnterDocDate'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtADCDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCDocTime'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNTimePicker" id="oetADCDocTime" name="oetADCDocTime" value="<?php echo $dADCDocTime; ?>" data-validate-required="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCPlsEnterDocTime'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtADCDocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCCreateBy'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdADCCreateBy" name="ohdADCCreateBy" value="<?php echo $tADCCreateBy ?>">
                                            <label><?php echo $tADCCreateBy ?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCTBStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCStaDoc' . $tADCStaDoc); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCTBStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCStaApv' . $tADCStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <?php if (isset($tADCDocNo) && !empty($tADCDocNo)) : ?>
                                    <!-- ผู้อนุมัติเอกสาร -->
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdADCApvCode" name="ohdADCApvCode" maxlength="20" value="<?php echo $tADCApvCode ?>">
                                                <label>
                                                    <?php echo (isset($tADCUsrNameApv) && !empty($tADCUsrNameApv)) ? $tADCUsrNameApv : "-"; ?>
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

            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCConditionDoc'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvADCWarehouse" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvADCWarehouse" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body xCNPDModlue">
                        <?php
                        if ($this->session->userdata("tSesUsrLevel") != "HQ") {
                            if ($this->session->userdata("nSesUsrBchCount") <= 1) {
                                $tBrowseBchDisabled = 'disabled';
                            } else {
                                $tBrowseBchDisabled = '';
                            }
                        } else {
                            $tBrowseBchDisabled = '';
                        }
                        ?>
                        <!-- สาขา -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCBranch'); ?></label>
                            <div class="input-group" style="width:100%;">
                                <input type="text" class="input100 xCNHide" id="ohdADCBchCode" name="ohdADCBchCode" value="<?php echo $tADCBchCode; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="ohdADCBchName" name="ohdADCBchName" value="<?php echo $tADCBchName; ?>" readonly placeholder="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCBranch'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtADCBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn" <?php echo $tBrowseBchDisabled; ?>>
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png'; ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <!-- วันที่มีผล -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCEffectiveDate'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetADCEffectiveDate" name="oetADCEffectiveDate" value="<?php echo $tADCAffect; ?>" data-validate-required="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCPlsEffectiveDate'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtADCEffectiveDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>

                        <div style="border:1px solid #ccc;position:relative;padding:15px;margin-top:30px;">
                            <label class="xCNLabelFrm" style="position:absolute;top:-15px;left:15px;
								background: #fff;
								padding-left: 10px;
								padding-right: 10px;"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCLabelFrmHead'); ?></label>


                            <!-- ใบซื้อสินค้า -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input xCNRadioPrint" type="radio" name="ocbADCPurchase" id="ocbADCPurchase" value="1" checked>
                                <label class="form-check-label" for="ocbADCPurchase">&nbsp;<?= language('document/adjustmentcost/adjustmentcost', 'tADCCbPurchase'); ?></label>
                            </div>

                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCPurchase'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="xCNHide" id="ohdADCPurchaseCode" name="ohdADCPurchaseCode" maxlength="5" value="">
                                    <input class="form-control xWPointerEventNone" type="text" id="oetADCPurchaseName" name="oetADCPurchaseName" value="" readonly placeholder="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCPurchase'); ?>">
                                    <span class="input-group-btn">
                                        <button id="obtADCPurchase" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png'; ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <!-- ใบซื้อสินค้า -->

                            <div class="form-check form-check-inline">
                                <input class="form-check-input xCNRadioPrint" type="radio" name="ocbADCAddDoc" id="ocbADCAddDoc" value="1">
                                <label class="form-check-label" for="ocbADCAddDoc">&nbsp;<?= language('document/adjustmentcost/adjustmentcost', 'tADCCbAddDoc'); ?></label>
                            </div>

                            <!-- เอกสารการรับเข้า -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAddDoc'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="xCNHide" id="ohdADCAddDocCode" name="ohdADCAddDocCode" maxlength="5" value="">
                                    <input class="form-control xWPointerEventNone" type="text" id="oetADCAddDocName" name="oetADCAddDocName" value="" readonly placeholder="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAddDoc'); ?>">
                                    <span class="input-group-btn">
                                        <button id="obtADCAddDoc" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <!-- เอกสารการรับเข้า -->

                        </div>
                        <div class="row">
                            <div class="col-md-6 pull-right">
                                <button type="button" id="obtImportPDTInCN" class="btn btn-primary xCNApvOrCanCelDisabled" style="width:100%; font-size: 17px; margin-top: 10px;"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCImpPDT'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvADCHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCReference'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvADCDataGeneralInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvADCDataGeneralInfo" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body xCNPDModlue">
                        <!-- วันที่เอกสารภายใน -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCRefInt'); ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSpc" id="oetADCRefInt" name="oetADCRefInt" maxlength="20" value="<?php echo $tADCRefInt; ?>">
                                </div>
                            </div>
                        </div>
                        <!-- วันที่เอกสารภายใน -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCRefIntDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetADCRefIntDate" name="oetADCRefIntDate" value="<?php echo $tADCRefIntDate; ?>">
                                        <span class="input-group-btn">
                                            <button id="obtADCRefIntDate" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/icons8-Calendar-100.png'; ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default" style="margin-bottom: 60px;">
                <div id="odvADCHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCOther'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvOther" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvOther" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body xCNPDModlue">

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCNote'); ?></label>
                            <textarea class="form-control xCNInputWithoutSpc" id="otaADCRmk" name="otaADCRmk" maxlength="200"><?php echo $tADCRmk ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div class="row">
                <!-- ตารางรายการนับสินค้า -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:200px;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" maxlength="100" id="oetADCSearchPdtHTML" name="oetADCSearchPdtHTML" onkeyup="JSxADCSearch()" placeholder="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCSearchPdt'); ?>">
                                                <input style="display:none;" type="text" class="form-control" maxlength="100" id="oetADCScanPdtHTML" name="oetADCScanPdtHTML" onkeyup="Javascript:if(event.keyCode==13) JSxADCSearch()" placeholder="<?php echo language('document/adjustmentcost/adjustmentcost', 'tASTScanPdt'); ?>" data-validate="<?php echo language('document/adjustmentcost/adjustmentcost', 'tASTScanPdtNotFound'); ?>">
                                                <span class="input-group-btn">
                                                    <div id="odvADCSearchBtnGrp" class="xCNDropDrownGroup input-group-append">
                                                        <button id="obtADCMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan">
                                                            <img class="xCNIconSearch" style="width:20px;">
                                                        </button>
                                                        <button id="obtADCMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;">
                                                            <img class="xCNIconScanner" style="width:20px;">
                                                        </button>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="right">
                                            <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                                                <button type="button" class="btn xCNBTNMngTable xCNImportBtn" onclick="JSxOpenImportForm()">
                                                    <?= language('common/main/main', 'tImport') ?>
                                                </button>
                                            </div>
                                            <div id="odvADCDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
                                                <button type="button" class="btn xCNBTNMngTable xWBtnDelPdt" data-toggle="dropdown">
                                                    <?= language('common/main/main', 'tCMNOption') ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li id="oliADCBtnDeleteMulti" class="disabled">
                                                        <a data-toggle="modal" data-target="#odvTWIModalDelPdtInDTTempMultiple"><?= language('common/main/main', 'tDelAll') ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button <?php if (!empty($tADCStaApv) || $tADCStaDoc == 3) {
                                                            echo "disabled";
                                                        }
                                                        ?> id="obtADCFilterDataCondition" type="button" class="btn btn-primary xWASTDisabledOnApv" style="font-size: 16px;"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCFilterCondition'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="odvADCPdtTablePanal" style="padding: 15px;">
                                    <div class="table-responsive">
                                        <table class="table xWPdtTableFont" id="otbDOCPdtTable">
                                            <thead>
                                                <tr class="xCNCenter">
                                                    <th><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCSelectDelete'); ?></th>
                                                    <th><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCOrder'); ?></th>
                                                    <th nowrap title="รหัสสินค้า">
                                                        <?php echo language('document/adjustmentcost/adjustmentcost', 'tADCPdtCode'); ?></th>
                                                    <th nowrap title="ชื่อสินค้า">
                                                        <?php echo language('document/adjustmentcost/adjustmentcost', 'tADCPdtName'); ?> </th>
                                                    <th nowrap title="บาร์โค้ด" class="hidden">
                                                        <?php echo language('document/adjustmentcost/adjustmentcost', 'บาร์โค้ด'); ?> </th>
                                                    <th nowrap title="หน่วยสินค้า">
                                                        <?php echo language('document/adjustmentcost/adjustmentcost', 'tADCPdtUnit'); ?> </th>
                                                    <th class="text-right" nowrap title="ต้นทุนเดิม">
                                                        <?php echo language('document/adjustmentcost/adjustmentcost', 'tADCOldCost'); ?> </th>
                                                    <th class="text-right" nowrap title="ผลต่าง">
                                                        <?php echo language('document/adjustmentcost/adjustmentcost', 'tADCDiffCost'); ?> </th>
                                                    <th class="text-right"  nowrap title="ต้นทุนใหม่">
                                                        <?php echo language('document/adjustmentcost/adjustmentcost', 'tADCNewCost'); ?> </th>
                                                    <th class="text-left xWRemark hidden" nowrap title="หมายเหตุ">
                                                        <?php echo language('document/adjustmentcost/adjustmentcost', 'หมายเหตุ'); ?> </th>
                                                    <th><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCDelete'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="odvADCTable">

                                            </tbody>
                                        </table>
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

<div class="modal fade" id="odvADCFilterDataCondition">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead"><label class="xCNTextModalHeard"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCFilterTitle'); ?></label></div>
            <div class="modal-body">
                <div class="xCNTabCondition">
                    <label class="xCNTabConditionHeader xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCFilterTitleProduct'); ?></label>
                    <!-- Browse Pdt -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- จากรหัสสินค้า -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCFilterCodeFrom'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="input100 xCNHide" id="oetADCFilterPdtCodeFrom" name="oetADCFilterPdtCodeFrom" value="">
                                    <input class="form-control xWPointerEventNone" type="text" id="oetADCFilterPdtNameFrom" name="oetADCFilterPdtCodeName" value="" readonly="">
                                    <span class="input-group-btn xWConditionSearchPdt">
                                        <button id="obtADCBrowseFilterProductFrom" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                            <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <!-- จากรหัสสินค้า -->
                        </div>
                        <div class="col-md-6">
                            <!-- ถึงรหัสสินค้า -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCFilterCodeTo'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="input100 xCNHide" id="oetADCFilterPdtCodeTo" name="oetADCFilterPdtCodeTo" value="">
                                    <input class="form-control xWPointerEventNone" type="text" id="oetADCFilterPdtNameTo" name="oetADCFilterPdtNameTo" value="" readonly="">
                                    <span class="input-group-btn xWConditionSearchPdt">
                                        <button id="obtADCBrowseFilterProductTo" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                            <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <!-- ถึงรหัสสินค้า -->
                        </div>
                    </div>
                    <!-- Browse Pdt -->
                </div>

                <div class="xCNTabCondition">
                    <label class="xCNTabConditionHeader xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCFilterTitleBarcode'); ?></label>
                    <!-- Browse Barcode -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- จากรหัสบาร์โค้ด -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCFilterCodeFrom'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="input100 xCNHide" id="oetADCFilterBarCodeFrom" name="oetADCFilterBarCodeFrom" value="">
                                    <input class="form-control xWPointerEventNone" type="text" id="oetADCFilterBarCodeNameFrom" name="oetADCFilterBarCodeNameFrom" value="" readonly="">
                                    <span class="input-group-btn xWConditionSearchPdt">
                                        <button id="obtADCBrowseFilterBarCodeFrom" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                            <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <!-- จากรหัสบาร์โค้ด -->
                        </div>
                        <div class="col-md-6">
                            <!-- ถึงรหัสบาร์โค้ด -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCFilterCodeTo'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="input100 xCNHide" id="oetADCFilterBarCodeCodeTo" name="oetADCFilterBarCodeCodeTo" value="">
                                    <input class="form-control xWPointerEventNone" type="text" id="oetADCFilterBarCodeNameTo" name="oetADCFilterBarCodeNameTo" value="" readonly="">
                                    <span class="input-group-btn xWConditionSearchPdt">
                                        <button id="obtADCBrowseFilterBarCodeTo" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                            <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <!-- ถึงรหัสบาร์โค้ด -->
                        </div>
                    </div>
                    <!-- Browse Barcode -->
                </div>
            </div>
            <div class="modal-footer">
                <button id="obtADCConfirmFilter" type="button" class="btn xCNBTNPrimery"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubBtnFilterConfirm'); ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel'); ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="odvADCPopupCancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/adjuststock/adjuststock', 'tASTCanDoc'); ?></label>
            </div>
            <div class="modal-body">
                <p id="obpMsgApv"><?php echo language('document/adjuststock/adjuststock', 'tASTDocRemoveCantEdit'); ?></p>
                <p><strong><?php echo language('document/adjuststock/adjuststock', 'tASTCancel'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSnADCCancelDoc(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>


<div id="odvADCModalAppoveDoc" class="modal fade xCNModalApprove">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main', 'tApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('common/main/main', 'tMainApproveStatus'); ?></p>
                <ul>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus1'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus2'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus3'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus4'); ?></li>
                </ul>
                <p><?php echo language('common/main/main', 'tMainApproveStatus5'); ?></p>
                <p><strong><?php echo language('common/main/main', 'tMainApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxADCApproveDocument(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================================================================================================================== -->

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include('script/jAdjustmentcostAdd.php'); ?>