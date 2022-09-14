<style>
    fieldset.scheduler-border {
        border: 1px groove #ffffffa1 !important;
        padding: 0 20px 20px 20px !important;
        margin: 0 0 10px 0 !important;
    }

    legend.scheduler-border {
        text-align: left !important;
        width: auto;
        padding: 0 5px;
        border-bottom: none;
        font-weight: bold;
    }
</style>
<?php
$tSesUsrLevel   = $this->session->userdata('tSesUsrLevel');
$nSesUsrShpCount = $this->session->userdata("nSesUsrShpCount");
if (isset($aDataDocHD) && $aDataDocHD['rtCode'] == "1") {
    $tTWORoute              = "dcmTWOEventEdit";
    $tTWOCompCode           = $tCmpCode;
    $nTWOAutStaEdit         = 1;
    $tTWOStaApv             = $aDataDocHD['raItems']['FTXthStaApv'];
    $tTWOStaDoc             = $aDataDocHD['raItems']['FTXthStaDoc'];
    $tTWOStaPrcStk          = $aDataDocHD['raItems']['FTXthStaPrcStk'];
    $nTWOStaDocAct          = $aDataDocHD['raItems']['FNXthStaDocAct'];
    $tTWOStaDelMQ           = $aDataDocHD['raItems']['FTXthStaDelMQ'];
    $tTWOBchCode            = $aDataDocHD['raItems']['FTBchCode'];
    $tTWOBchName            = $aDataDocHD['raItems']['FTBchName'];
    $tTWODptCode            = $aDataDocHD['raItems']['FTDptCode'];
    $tTWOUsrCode            = $aDataDocHD['raItems']['FTXthApvCode'];
    $tTWODocNo              = $aDataDocHD['raItems']['FTXthDocNo'];
    $dTWODocDate            = date("Y-m-d", strtotime($aDataDocHD['raItems']['FDXthDocDate']));
    $dTWODocTime            = date("H:i:s", strtotime($aDataDocHD['raItems']['FDXthDocDate']));
    $tTWOCreateBy           = $aDataDocHD['raItems']['FTCreateBy'];
    $tTWOUsrNameCreateBy    = $aDataDocHD['raItems']['FTUsrName'];
    $tTWOApvCode            = $aDataDocHD['raItems']['FTXthApvCode'];
    $tTWOUsrNameApv         = $aDataDocHD['raItems']['FTUsrName'];
    $tTWODocType            = $aDataDocHD['raItems']['FNXthDocType'];
    $tTWORsnType            = $aDataDocHD['raItems']['FTXthRsnType'];
    $tTWOVATInOrEx          = $aDataDocHD['raItems']['FTXthVATInOrEx'];
    $tTWOMerCode            = $aDataDocHD['raItems']['FTXthMerCode'];
    $tTWOShopFrm            = $aDataDocHD['raItems']['FTXthShopFrm'];
    $tTWOShopTo             = $aDataDocHD['raItems']['FTXthShopTo'];
    $tTWOShopName           = $aDataDocHD['raItems']['FTShpName'];
    $tTWOShopNameTo         = $aDataDocHD['raItems']['ShpNameTo'];
    $tTWOWhFrm              = $aDataDocHD['raItems']['FTXthWhFrm'];
    $tTWOWhTo               = $aDataDocHD['raItems']['FTXthWhTo'];
    $tTWOWhName             = $aDataDocHD['raItems']['FTWahName'];
    $tTWOWhNameTo           = $aDataDocHD['raItems']['WahNameTo'];
    $tTWOPosFrm             = $aDataDocHD['raItems']['FTXthPosFrm'];
    $tTWOPosTo              = $aDataDocHD['raItems']['FTXthPosTo'];
    $tTWOSplCode            = $aDataDocHD['raItems']['FTSplCode'];
    $tTWOSplName            = $aDataDocHD['raItems']['FTSplName'];
    $tTWOOther              = $aDataDocHD['raItems']['FTXthOther'];
    $tTWORefExt             = $aDataDocHD['raItems']['FTXthRefExt'];
    $tTWORefExtDate         = $aDataDocHD['raItems']['FDXthRefExtDate'];
    $tTWORefInt             = $aDataDocHD['raItems']['FTXthRefInt'];
    $tTWORefIntDate         = $aDataDocHD['raItems']['FDXthRefIntDate'];
    $tTWODocPrint           = $aDataDocHD['raItems']['FNXthDocPrint'];
    $tTWORmk                = $aDataDocHD['raItems']['FTXthRmk'];
    $tTWORsnCode            = $aDataDocHD['raItems']['FTRsnCode'];
    $tTWORsnName            = $aDataDocHD['raItems']['FTRsnName'];
    $tTWOCtrName            = $aDataDocHDRef['raItems']['FTXthCtrName'];
    $dTWOXthTnfDate         = $aDataDocHDRef['raItems']['FDXthTnfDate'];
    $tTWOXthRefTnfID        = $aDataDocHDRef['raItems']['FTXthRefTnfID'];
    $tTWOXthRefVehID        = $aDataDocHDRef['raItems']['FTXthRefVehID'];
    $tTWOXthQtyAndTypeUnit  = $aDataDocHDRef['raItems']['FTXthQtyAndTypeUnit'];
    $nTWOXthShipAdd         = $aDataDocHDRef['raItems']['FNXthShipAdd'];
    $tTWOViaCode            = $aDataDocHDRef['raItems']['FTViaCode'];

    $tShpCode_FRM          = $aDataDocHD['raItems']['FTXthShopFrm'];
    $tShpName_FRM          = $aDataDocHD['raItems']['FTShpName'];
    $tShpCode_TO           = $aDataDocHD['raItems']['FTXthShopTo'];
    $tShpName_TO           = $aDataDocHD['raItems']['ShpNameTo'];

    // ที่อยู่สำหรับการจัดส่ง
    $tTWOSplShipAdd          = $aDataDocHDRef['raItems']['FNXthShipAdd'];
    $tTWOShipAddAddV1No      = (isset($aDataDocHDRef['raItems']['FTAddV1No']) && !empty($aDataDocHDRef['raItems']['FTAddV1No'])) ? $aDataDocHDRef['raItems']['FTAddV1No'] : "-";
    $tTWOShipAddV1Soi        = (isset($aDataDocHDRef['raItems']['FTAddV1Soi']) && !empty($aDataDocHDRef['raItems']['FTAddV1Soi'])) ? $aDataDocHDRef['raItems']['FTAddV1Soi'] : "-";
    $tTWOShipAddV1Village    = (isset($aDataDocHDRef['raItems']['FTAddV1Village']) && !empty($aDataDocHDRef['raItems']['FTAddV1Village'])) ? $aDataDocHDRef['raItems']['FTAddV1Village'] : "-";
    $tTWOShipAddV1Road       = (isset($aDataDocHDRef['raItems']['FTAddV1Road']) && !empty($aDataDocHDRef['raItems']['FTAddV1Road'])) ? $aDataDocHDRef['raItems']['FTAddV1Road'] : "-";
    $tTWOShipAddV1SubDist    = (isset($aDataDocHDRef['raItems']['FTAddV1SubDist']) && !empty($aDataDocHDRef['raItems']['FTSudName'])) ? $aDataDocHDRef['raItems']['FTSudName'] : "-";
    $tTWOShipAddV1DstCode    = (isset($aDataDocHDRef['raItems']['FTAddV1DstCode']) && !empty($aDataDocHDRef['raItems']['FTDstName'])) ? $aDataDocHDRef['raItems']['FTDstName'] : "-";
    $tTWOShipAddV1PvnCode    = (isset($aDataDocHDRef['raItems']['FTAddV1PvnCode']) && !empty($aDataDocHDRef['raItems']['FTPvnName'])) ? $aDataDocHDRef['raItems']['FTPvnName'] : "-";
    $tTWOShipAddV1PostCode   = (isset($aDataDocHDRef['raItems']['FTAddV1PostCode']) && !empty($aDataDocHDRef['raItems']['FTAddV1PostCode'])) ? $aDataDocHDRef['raItems']['FTAddV1PostCode'] : "-";
} else {
    $tTWORoute              = "dcmTWOEventAdd";
    $tTWOCompCode           = $tCmpCode;
    $nTWOAutStaEdit         = 0;
    $tTWOStaApv             = "";
    $tTWOStaDoc             = "";
    $tTWOStaPrcStk          = "";
    $nTWOStaDocAct          = "99";
    $tTWOStaDelMQ           = "";
    $tTWOBchCode            = $tBchCode;
    $tTWOBchName            = $tBchName;
    $tTWODptCode            = $tDptCode;
    $tTWOUsrCode            = $this->session->userdata('tSesUsername');
    $tTWODocNo              = "";
    $dTWODocDate            = "";
    $dTWODocTime            = date('H:i');
    $tTWOCreateBy           = $this->session->userdata('tSesUsrUsername');
    $tTWOUsrNameCreateBy    = $this->session->userdata('tSesUsrUsername');
    $tTWOApvCode            = "";
    $tTWOUsrNameApv         = "";
    $tTWODocType            = "";
    $tTWORsnType            = "";
    $tTWOVATInOrEx          = 1;
    $tTWOMerCode            = "";
    $tTWOShopFrm            = "";
    $tTWOShopTo             = "";
    $tTWOShopName           = "";
    $tTWOShopNameTo         = "";
    $tTWOWhFrm              = "";
    $tTWOWhTo               = "";
    $tTWOWhName             = "";
    $tTWOWhNameTo           = "";
    $tTWOPosFrm             = "";
    $tTWOPosTo              = "";
    $tTWOSplCode            = "";
    $tTWOSplName            = "";
    $tTWOOther              = "";
    $tTWORefExt             = "";
    $tTWORefExtDate         = "";
    $tTWORefInt             = "";
    $tTWORefIntDate         = "";
    $tTWODocPrint           = "";
    $tTWORmk                = "";
    $tTWORsnCode            = "";
    $tTWORsnName            = "";
    $tTWOUserBchCode        = $tBchCode;
    $tTWOUserBchName        = $tBchName;
    $tTWOCtrName            = "";
    $dTWOXthTnfDate         = "";
    $tTWOXthRefTnfID        = "";
    $tTWOXthRefVehID        = "";
    $tTWOXthQtyAndTypeUnit  = "";
    $nTWOXthShipAdd         = "";
    $tTWOViaCode            = "";

    // ที่อยู่สำหรับการจัดส่ง
    $tTWOSplShipAdd          = "";
    $tTWOShipAddAddV1No      = "-";
    $tTWOShipAddV1Soi        = "-";
    $tTWOShipAddV1Village    = "-";
    $tTWOShipAddV1Road       = "-";
    $tTWOShipAddV1SubDist    = "-";
    $tTWOShipAddV1DstCode    = "-";
    $tTWOShipAddV1PvnCode    = "-";
    $tTWOShipAddV1PostCode   = "-";

    if ($tSesUsrLevel == "HQ" || $tSesUsrLevel == "BCH") {
        $tWahCodeStart          = $this->session->userdata('tSesUsrWahCode');
        $tWahNameStart          = $this->session->userdata('tSesUsrWahName');
        $tShpCode_FRM           = '';
        $tShpName_FRM           = '';
        $tShpCode_TO            = '';
        $tShpName_TO            = '';
    } else if ($tSesUsrLevel == "SHP") {
        $tMchCode               = $this->session->userdata('tSesUsrMerCode');
        $tMchName               = $this->session->userdata('tSesUsrMerName');
        $tShpCode_FRM           = $this->session->userdata('tSesUsrShpCodeDefault');
        $tShpName_FRM           = $this->session->userdata('tSesUsrShpNameDefault');
        $tShpCode_TO            = $this->session->userdata('tSesUsrShpCodeDefault');
        $tShpName_TO            = $this->session->userdata('tSesUsrShpNameDefault');
    }
}

$tTWOBchCompCode         = $tBchCompCode;
$tTWOBchCompName         = $tBchCompName;

$nLangEdit = $this->session->userdata("tLangEdit");
$tUsrApv = $this->session->userdata("tSesUsername");
$tUserLoginLevel = $this->session->userdata("tSesUsrLevel");
$bIsAddPage = empty($tTWOStaDoc) ? true : false;
$bIsApv = empty($tTWOStaApv) ? false : true;
$bIsCancel = ($tTWOStaDoc == "3") ? true : false;
$bIsApvOrCancel = ($bIsApv || $bIsCancel);
$bIsMultiBch = $this->session->userdata("nSesUsrBchCount") > 1;
$bIsShpEnabled = FCNbGetIsShpEnabled();
$bIsPacking = ($tTWOStaPrcStk != "" && $tTWOStaPrcStk != "1" ? true : false);
?>

<script>
    var nLangEdit = '<?php echo $nLangEdit; ?>';
    var tUsrApv = '<?php echo $tUsrApv; ?>';
    var tUserLoginLevel = '<?php echo $tUserLoginLevel; ?>';
    var bIsAddPage = <?php echo ($bIsAddPage) ? 'true' : 'false'; ?>;
    var bIsApv = <?php echo ($bIsApv) ? 'true' : 'false'; ?>;
    var bIsCancel = <?php echo ($bIsCancel) ? 'true' : 'false'; ?>;
    var bIsApvOrCancel = <?php echo ($bIsApvOrCancel) ? 'true' : 'false'; ?>;
    var tStaApv = '<?php echo $tTWOStaApv; ?>';
    var bIsMultiBch = <?php echo ($bIsMultiBch) ? 'true' : 'false'; ?>;
    var bIsShpEnabled = <?php echo ($bIsShpEnabled) ? 'true' : 'false'; ?>;
    var bIsPacking = <?php echo ($tTWOStaPrcStk != "" && $tTWOStaPrcStk != "1") ? 'true' : 'false'; ?>;
</script>

<form id="ofmTransferwarehouseoutFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button style="display:none" type="submit" id="obtSubmitTransferwarehouseout" onclick="JSxTransferwarehouseoutEventAddEdit('<?= $tTWORoute ?>')"></button>

    <input type="hidden" id="ohdTWOCompCode" name="ohdTWOCompCode" value="<?= $tTWOCompCode; ?>">
    <input type="hidden" id="ohdBaseUrl" name="ohdBaseUrl" value="<?= base_url(); ?>">
    <input type="hidden" id="ohdTWORoute" name="ohdTWORoute" value="<?= $tTWORoute; ?>">
    <input type="hidden" id="ohdTWOCheckClearValidate" name="ohdTWOCheckClearValidate" value="0">
    <input type="hidden" id="ohdTWOCheckSubmitByButton" name="ohdTWOCheckSubmitByButton" value="0">
    <input type="hidden" id="ohdTWOAutStaEdit" name="ohdTWOAutStaEdit" value="<?= $nTWOAutStaEdit; ?>">
    <input type="hidden" id="ohdTWOStaApv" name="ohdTWOStaApv" value="<?= $tTWOStaApv; ?>">
    <input type="hidden" id="ohdTWOStaDoc" name="ohdTWOStaDoc" value="<?= $tTWOStaDoc; ?>">
    <input type="hidden" id="ohdTWOStaPrcStk" name="ohdTWOStaPrcStk" value="<?= $tTWOStaPrcStk; ?>">
    <input type="hidden" id="ohdTWOStaDelMQ" name="ohdTWOStaDelMQ" value="<?= $tTWOStaDelMQ; ?>">
    <input type="hidden" id="ohdTWOBchCode" name="ohdTWOBchCode" value="<?= $tTWOBchCode; ?>">
    <input type="hidden" id="ohdTWODptCode" name="ohdTWODptCode" value="<?= $tTWODptCode; ?>">
    <input type="hidden" id="ohdTWOUsrCode" name="ohdTWOUsrCode" value="<?= $tTWOUsrCode; ?>">
    <input type="hidden" id="ohdTWOApvCodeUsrLogin" name="ohdTWOApvCodeUsrLogin" value="<?= $tTWOUsrCode; ?>">
    <input type="hidden" id="ohdTWOLangEdit" name="ohdTWOLangEdit" value="<?= $this->session->userdata("tLangEdit"); ?>">
    <input type="hidden" id="ohdTWOFrmSplInfoVatInOrEx" name="ohdTWOFrmSplInfoVatInOrEx" value="<?= $tTWOVATInOrEx ?>">
    <input type="hidden" id="ohdTWOSesUsrLogin" name="ohdTWOSesUsrLogin" value="<?= $this->session->userdata('tSesUsername'); ?>">

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWODocument'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTWODataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWODataStatusInfo" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="xCNTitleFrom "><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOApproved'); ?></label>
                                </div>
                                <input type="hidden" value="0" id="ohdCheckTWOSubmitByButton" name="ohdCheckTWOSubmitByButton">
                                <input type="hidden" value="0" id="ohdCheckTWOClearValidate" name="ohdCheckTWOClearValidate">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWODocNo'); ?></label>
                                <?php if (empty($tTWODocNo)) : ?>
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbTWOStaAutoGenCode" name="ocbTWOStaAutoGenCode" maxlength="1" checked="true" value="1">
                                            <span><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTWOAutoGenCode'); ?></span>
                                        </label>
                                    </div>
                                <?php endif; ?>

                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input type="text" class="form-control xCNInputWithoutSpcNotThai xCNInputWOthoutSingleQuote" id="oetTWODocNo" name="oetTWODocNo" maxlength="20" value="<?= $tTWODocNo; ?>" data-validate-required="<?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOPlsEnterOrRunDocNo'); ?>" data-validate-duplicate="<?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOPlsDocNoDuplicate'); ?>" placeholder="<?= language('document/transferwarehouseout/transferwarehouseout', 'tTWODocNo'); ?>" style="pointer-events:none" readonly>
                                    <input type="hidden" id="ohdTWOCheckDuplicateCode" name="ohdTWOCheckDuplicateCode" value="2">
                                </div>

                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWODocDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTWODocDate" name="oetTWODocDate" value="<?= $dTWODocDate; ?>" data-validate-required="<?= language('document/transferwarehouseout/transferwarehouseout', 'tASTPlsEnterDocDate'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtTWODocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWODocTime'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNTimePicker" id="oetTWODocTime" name="oetTWODocTime" value="<?= $dTWODocTime; ?>" data-validate-required="<?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOPlsEnterDocTime'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtTWODocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOCreateBy'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdTWOCreateBy" name="ohdTWOCreateBy" value="<?= $tTWOCreateBy ?>">
                                            <label><?= $tTWOUsrNameCreateBy ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOTBStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOStaDoc' . $tTWOStaDoc); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOStaApv' . $tTWOStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะประมวลผลเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOStaPrcStk'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOStaPrcStk' . $tTWOStaPrcStk); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- ผู้อนุมัติเอกสาร -->
                                <?php if (isset($tTWODocNo) && !empty($tTWODocNo)) : ?>
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdTWOApvCode" name="ohdTWOApvCode" maxlength="20" value="<?= $tTWOApvCode ?>">
                                                <label>
                                                    <?php
                                                    if ($tTWOStaApv == 1 || $tTWOStaApv == 3) {
                                                        echo (isset($tTWOUsrNameApv) && !empty($tTWOUsrNameApv)) ? $tTWOUsrNameApv : "-";
                                                    } else {
                                                        echo "-";
                                                    }
                                                    ?>
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

            <!-- Panel เงื่อนไขเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOConditionDoc'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTWODataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWODataConditionDoc" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">


                            <script>
                                var tUsrLevel = '<?= $this->session->userdata('tSesUsrLevel') ?>';
                                if (tUsrLevel != "HQ") {
                                    //BCH - SHP
                                    var tBchCount = '<?= $this->session->userdata("nSesUsrBchCount") ?>';
                                    if (tBchCount < 2) {
                                        $('#obtBrowseTWOBCH').attr('disabled', true);
                                    }
                                }
                            </script>

                            <!--สาขา-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php
                                if ($tTWORoute == "dcmTWOEventAdd") {
                                    $tTWODataInputBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
                                    $tTWODataInputBchName = $this->session->userdata('tSesUsrBchNameDefault');
                                } else {
                                    $tTWODataInputBchCode    = $tTWOBchCode;
                                    $tTWODataInputBchName    = $tTWOBchName;
                                }
                                ?>

                                <div class="">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmBranch') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetSOFrmBchCode" name="oetSOFrmBchCode" maxlength="5" value="<?php echo $tTWODataInputBchCode; ?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetSOFrmBchName" name="oetSOFrmBchName" maxlength="100" placeholder="<?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmBranch') ?>" value="<?php echo $tTWODataInputBchName; ?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtBrowseTWOBCH" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
                                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <input type="hidden" id="ocmSelectTransferDocument" name="ocmSelectTransferDocument" value="">

                            <!--เงื่อนไขของประเภท รับโอน-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="odvTRNOut" class="row">
                                    <div class="col-lg-12">
                                        <label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOOrigin'); ?> : </label>
                                        <label><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOWahhouse'); ?></label>
                                    </div>

                                    <div class="col-lg-12">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOOrigin'); ?></legend>
                                            <!--เลือกร้านค้า - ต้นทาง-->
                                            <div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
                                                <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tShop'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTROutShpFromName" id="oetTROutShpFromName" class="form-control " value="<?= $tShpName_FRM ?>" type="text" readonly="" placeholder="<?= language('document/topupVending/topupVending', 'tShop') ?>">
                                                    <input name="oetTROutShpFromCode" id="oetTROutShpFromCode" class="form-control xCNHide" type="text" value="<?= $tShpCode_FRM ?>">
                                                    <?php
                                                    $tShpBtnDisabled = "";
                                                    if ($tSesUsrLevel != 'HQ') {
                                                        if ($tSesUsrLevel == "SHP") {
                                                            $tShpBtnDisabled = "disabled";
                                                        }
                                                    }
                                                    ?>

                                                    <span class="input-group-btn <?php echo $tShpBtnDisabled; ?>">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled <?php echo $tShpBtnDisabled; ?>" id="obtBrowseTROutFromShp" type="button" <?php echo $tShpBtnDisabled; ?>>
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <!--เลือกจุดขาย - ต้นทาง-->
                                            <!-- <div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
                                                <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tPos'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTROutPosFromName" id="oetTROutPosFromName" class="form-control " value="<?= $tTWOPosFrm ?>" type="text" readonly=""
                                                            placeholder="<?= language('document/topupVending/topupVending', 'tPos') ?>" >
                                                    <input name="oetTROutPosFromCode" id="oetTROutPosFromCode" value="<?= $tTWOPosFrm ?>" class="form-control xCNHide" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTROutFromPos" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div> -->

                                            <!--คลังสินค้า - ต้นทาง-->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOWahhouse'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTROutWahFromName" id="oetTROutWahFromName" class="form-control" value="<?= $tTWOWhName ?>" type="text" readonly="" placeholder="<?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOWahhouse') ?>">
                                                    <input name="oetTROutWahFromCode" id="oetTROutWahFromCode" value="<?= $tTWOWhFrm ?>" class="form-control xCNHide" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" <?php
                                                                                                                        if (!empty($tTWOPosFrm)) {
                                                                                                                            echo 'disabled';
                                                                                                                        }
                                                                                                                        ?> id="obtBrowseTROutFromWah" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>


                                        </fieldset>
                                    </div>

                                    <div class="col-lg-12">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOTo'); ?></legend>

                                            <div id="odvDocType_4">
                                                <!--เลือกร้านค้า - ปลายทาง-->
                                                <div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
                                                    <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tShop'); ?></label>
                                                    <div class="input-group">
                                                        <input name="oetTROutShpToName" id="oetTROutShpToName" class="form-control " value="<?= $tShpName_TO ?>" type="text" readonly="" placeholder="<?= language('document/topupVending/topupVending', 'tShop') ?>">
                                                        <input name="oetTROutShpToCode" id="oetTROutShpToCode" value="<?= $tShpCode_TO ?>" class="form-control xCNHide" type="text">
                                                        <?php
                                                        $tShpBtnDisabled = "";
                                                        if ($tSesUsrLevel != 'HQ') {
                                                            if ($tSesUsrLevel == "SHP") {
                                                                $tShpBtnDisabled = "disabled";
                                                            }
                                                        }

                                                        ?>


                                                        <span class="input-group-btn <?php echo $tShpBtnDisabled; ?>">
                                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled <?php echo $tShpBtnDisabled; ?>" id="obtBrowseTROutToShp" type="button" <?php echo $tShpBtnDisabled; ?>>
                                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>

                                                <!--เลือกจุดขาย - ปลายทาง-->
                                                <!-- <div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
                                                    <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tPos'); ?></label>
                                                    <div class="input-group">
                                                        <input name="oetTROutPosToName" id="oetTROutPosToName" class="form-control " value="<?= $tTWOPosTo ?>" type="text" readonly=""
                                                                placeholder="<?= language('document/topupVending/topupVending', 'tPos') ?>" >
                                                        <input name="oetTROutPosToCode" id="oetTROutPosToCode" value="<?= $tTWOPosTo ?>" class="form-control xCNHide" type="text">
                                                        <span class="input-group-btn">
                                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTROutToPos" type="button">
                                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div> -->

                                                <!--คลังสินค้า - ปลายทาง-->
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOWahhouse'); ?></label>
                                                    <div class="input-group">
                                                        <input name="oetTROutWahToName" id="oetTROutWahToName" class="form-control " value="<?= $tTWOWhNameTo ?>" type="text" readonly="" placeholder="<?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOWahhouse') ?>">
                                                        <input name="oetTROutWahToCode" id="oetTROutWahToCode" value="<?= $tTWOWhTo ?>" class="form-control xCNHide" type="text">
                                                        <span class="input-group-btn">
                                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTROutToWah" type="button">
                                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div id="odvDocType_2">
                                                <!--ประเภทของการรับเข้า-->
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOConditionIN'); ?></label>
                                                    <select class="selectpicker form-control" id="ocmSelectTransTypeIN" name="ocmSelectTransTypeIN">
                                                        <option value='' selected><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOConditionTo'); ?></option>
                                                        <option value='SPL'><?= language('document/transferwarehouseout/transferwarehouseout', 'tINSPL'); ?></option>
                                                        <option value='ETC'><?= language('document/transferwarehouseout/transferwarehouseout', 'tINETC'); ?></option>
                                                    </select>
                                                </div>

                                                <script>
                                                    $('#ocmSelectTransTypeIN').change(function() {
                                                        var tValue = $(this).val();
                                                        if (tValue == 'SPL') {
                                                            $('#odvINWhereSPL').css('display', 'block');
                                                            $('#odvINWhereETC').css('display', 'none');
                                                        } else if (tValue == 'ETC') {
                                                            $('#odvINWhereSPL').css('display', 'none');
                                                            $('#odvINWhereETC').css('display', 'block');
                                                        }
                                                    });
                                                </script>

                                                <div id="odvINWhereSPL" style="display:none">

                                                    <!--เลือกผู้จำหน่าย - รับเข้า - เงือนไขผู้จำหน่าย-->
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tTBSpl'); ?></label>
                                                        <div class="input-group">
                                                            <input name="oetTRINSplName" id="oetTRINSplName" class="form-control " value="<?= $tTWOSplName ?>" type="text" readonly="" placeholder="<?= language('document/topupVending/topupVending', 'tTBSpl') ?>">
                                                            <input name="oetTRINSplFromCode" id="oetTRINSplFromCode" value="<?= $tTWOSplCode ?>" class="form-control xCNHide" type="text">
                                                            <span class="input-group-btn">
                                                                <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTRINFromSpl" type="button">
                                                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!--เลือกร้านค้า - รับเข้า - เงือนไขผู้จำหน่าย-->
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tShop'); ?></label>
                                                        <div class="input-group">
                                                            <input name="oetTRINShpName" id="oetTRINShpName" class="form-control " value="<?= $tTWOShopNameTo ?>" type="text" readonly="" placeholder="<?= language('document/topupVending/topupVending', 'tShop') ?>">
                                                            <input name="oetTRINShpFromCode" id="oetTRINShpFromCode" value="<?= $tTWOShopTo ?>" class="form-control xCNHide" type="text">
                                                            <span class="input-group-btn">
                                                                <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTRINFromShp" type="button">
                                                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div id="odvINWhereETC" style="display:none">
                                                    <!--กรอกแหล่งอื่น - รับเข้า - เงือนไขแหล่งอื่น-->
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferwarehouseout/transferwarehouseout', 'tINETC'); ?></label>
                                                        <input type="text" class="form-control " id="oetTWOINEtc" name="oetTWOINEtc" value="<?= $tTWOOther ?>" maxlength="10">
                                                    </div>

                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>



            <!-- Panel การขนส่ง -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOPanelTransport'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTWODataConditionTransport" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWODataConditionTransport" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWCtrName'); ?></label>
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWOTransportCtrName" name="oetTWOTransportCtrName" value="<?= $tTWOCtrName ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWTnfDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTWOTransportTnfDate" name="oetTWOTransportTnfDate" placeholder="YYYY-MM-DD" value="<?= $dTWOXthTnfDate ?>">
                                        <span class="input-group-btn">
                                            <button id="obtTWOTnfDate" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?= base_url() . 'application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWRefTnfID'); ?></label>
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWOTransportRefTnfID" name="oetTWOTransportRefTnfID" value="<?= $tTWOXthRefTnfID ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWRefVehID'); ?></label>
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWOTransportRefVehID" name="oetTWOTransportRefVehID" value="<?= $tTWOXthRefVehID ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWQtyAndTypeUnit'); ?></label>
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWOTransportQtyAndTypeUnit" name="oetTWOTransportQtyAndTypeUnit" value="<?= $tTWOXthQtyAndTypeUnit ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tViaCode'); ?></label>
                                    <div class="input-group">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetTWOUpVendingViaName" name="oetTWOUpVendingViaName" value="<?php echo $tTWOViaCode ?>" readonly>
                                        <input type="text" class="input100 xCNHide xCNApvOrCanCelDisabled" id="oetTWOUpVendingViaCode" name="oetTWOUpVendingViaCode" value="<?php echo $tTWOViaCode ?>">
                                        <span class="input-group-btn">
                                            <button id="obtSearchShipVia" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
                                                <img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <input type="hidden" id="ohdTWOFrmShipAdd" name="ohdTWOFrmShipAdd" value="<?= $nTWOXthShipAdd ?>">
                                <button type="button" id="obtTWOFrmBrowseShipAdd" class="btn btn-primary" style="width:100%;">
                                    +&nbsp;<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOLabelFrmSplInfoShipAddress'); ?>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel อื่นๆ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOPanelETC'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTWODataConditionETC" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWODataConditionETC" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <!--เลือกเหตุผล-->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOReason'); ?></label>
                            <div class="input-group">
                                <input name="oetTWOReasonName" id="oetTWOReasonName" class="form-control" value="<?= $tTWORsnName ?>" type="text" readonly="" placeholder="<?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOReason') ?>">
                                <input name="oetTWOReasonCode" id="oetTWOReasonCode" value="<?= $tTWORsnCode ?>" class="form-control xCNHide" type="text">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTWOReason" type="button">
                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <!-- หมายเหตุ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOLabelFrmInfoOthRemark'); ?></label>
                            <textarea class="form-control xCNApvOrCanCelDisabled" id="otaTWOFrmInfoOthRmk" name="otaTWOFrmInfoOthRmk" rows="10" maxlength="200" style="resize: none;height:86px;"><?= $tTWORmk; ?></textarea>
                        </div>

                        <!-- จำนวนครั้งที่พิมพ์ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOLabelFrmInfoOthDocPrint'); ?></label>
                            <input type="text" class="form-control text-right" id="ocmTWOFrmInfoOthDocPrint" name="ocmTWOFrmInfoOthDocPrint" value="<?= $tTWODocPrint; ?>" readonly>
                        </div>

                        <!-- สถานะเคลื่อนไหว-->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <!-- <input type="checkbox" id="ocbTWOStaDocAct" name="ocbTWOStaDocAct" maxlength="1" value="1" <?php echo $nTWOStaDocAct == '' ? 'checked' : $nTWOStaDocAct == '1' ? 'checked' : '0'; ?>> -->
                                <input type="checkbox" value="1" id="ocbTWOStaDocAct" name="ocbTWOStaDocAct" maxlength="1" <?php if ($nTWOStaDocAct == 1 && $nTWOStaDocAct != 0) {
                                                                                                                                echo 'checked';
                                                                                                                            } else if ($nTWOStaDocAct == 99) {
                                                                                                                                echo 'checked';
                                                                                                                            }  ?>>
                                <span>&nbsp;</span>
                                <span class="xCNLabelFrm"><?= language('document/purchaseorder/purchaseorder', 'tTFWStaDocAct'); ?></span>
                            </label>
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
                                <div id="odvPdtRowNavMenu" class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                            <ul class="nav" role="tablist">

                                                <!-- ข้อมูลรถ -->
                                                <li id="odvCarInfo" class="xWMenu active xCNStaHideShow" data-menutype="MN" style="cursor: pointer;">
                                                    <a role="tab" data-toggle="tab" data-target="#odvTabProductList" aria-expanded="true"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOTabProductList') ?></a>
                                                </li>

                                                <!-- อ้างอิง -->
                                                <li id="odvJOBDataDocRefInfo" class="xWMenu xWSubTab xCNStaHideShow" data-menutype="FHN" style="cursor: pointer;">
                                                    <a role="tab" data-toggle="tab" data-target="#odvTWOContentHDDocRef" aria-expanded="false"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOTabDocDefList') ?></a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div id="odvTabProductList" class="tab-pane fade active in" style="padding: 0px !important;">
                                        <!--ค้นหา-->
                                        <div class="row p-t-15">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" maxlength="100" id="oetTWOFrmFilterPdtHTML" name="oetTWOFrmFilterPdtHTML" placeholder="<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOFrmFilterTablePdt'); ?>" onkeyup="javascript:if(event.keyCode==13) JSvTWODOCFilterPdtInTableTemp()">
                                                        <input type="text" class="form-control" maxlength="100" id="oetTWOFrmSearchAndAddPdtHTML" name="oetTWOFrmSearchAndAddPdtHTML" onkeyup="Javascript:if(event.keyCode==13) JSxTWOChkConditionSearchAndAddPdt()" placeholder="<?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOFrmSearchAndAddPdt'); ?>" style="display:none;" data-validate="<?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOMsgValidScanNotFoundBarCode'); ?>">
                                                        <span class="input-group-btn">
                                                            <div id="odvTWOSearchAndScanBtnGrp" class="xCNDropDrownGroup input-group-append">
                                                                <button id="obtTWOMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvTWODOCFilterPdtInTableTemp()">
                                                                    <i class="fa fa-search" style="width:20px;"></i>
                                                                </button>
                                                                <button id="obtTWOMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSxTWOChkConditionSearchAndAddPdt()">
                                                                    <i class="fa fa-search" style="width:20px;"></i>
                                                                </button>
                                                                <button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown" style="display:none;">
                                                                    <i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li>
                                                                        <a id="oliTWOMngPdtSearch"><label><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOFrmFilterTablePdt'); ?></label></a>
                                                                        <a id="oliTWOMngPdtScan"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWOFrmSearchAndAddPdt'); ?></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 text-right">
                                                <!-- <div id="odvTWOMngAdvTableList" class="btn-group xCNDropDrownGroup">
                                                    <button id="obtTWOAdvTablePdtDTTemp" type="button" class="btn xCNBTNMngTable m-r-20"><?= language('common/main/main', 'tModalAdvTable') ?></button>
                                                </div> -->
                                                <div id="odvTWOMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
                                                    <button type="button" class="btn xCNBTNMngTable xWDropdown" data-toggle="dropdown">
                                                        <?= language('common/main/main', 'tCMNOption') ?>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li id="oliTWOBtnDeleteMulti" class="disabled">
                                                            <a data-toggle="modal" data-target="#odvTWOModalDelPdtInDTTempMultiple"><?= language('common/main/main', 'tDelAll') ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                                <div class="form-group">
                                                    <div style="position: absolute;right: 15px;top:-5px;">
                                                        <button type="button" id="obtTWODocBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--ตาราง-->
                                        <div class="row p-t-10" id="odvTWODataPdtTableDTTemp"></div>
                                    </div>
                                    <!-- อ้างอิงเอกสาร -->
                                    <div id="odvTWOContentHDDocRef" class="tab-pane fade" style="padding: 0px !important;">
                                        <div class="row p-t-15">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                                <div style="margin-top:-2px;">
                                                    <button type="button" id="obtTWOAddDocRef" class="xCNBTNPrimeryPlus xCNDocBrowsePdt xCNHideWhenCancelOrApprove">+</button>
                                                </div>
                                            </div>
                                            <div id="odvTWOTableHDRef"></div>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- อ้างอิงเอกสาร -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- จบตารางสินค้า -->
            </div>
        </div>
    </div>


    <!-- =================================================================== View Modal Shipping Purchase Invoice  =================================================================== -->
    <div id="odvTWOBrowseShipAdd" class="modal fade">
        <div class="modal-dialog" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipAddress'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <!-- onclick="JSnPIShipAddData()" -->
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel panel-default" style="margin-bottom:5px;">
                                <div class="panel-heading xCNPanelHeadColor" style="padding-top:5px!important;padding-bottom:5px!important;">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNTextDetail1"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipAddInfo'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <a style="font-size:14px!important;color:#179bfd;">
                                                <i class="fa fa-pencil" id="oliPIEditShipAddress">&nbsp;<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipChange'); ?></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body xCNPDModlue">
                                    <input type="hidden" id="ohdTWOShipAddSeqNo" name="ohdTWOShipAddSeqNo" class="form-control">
                                    <?php $tTWOFormatAddressType = FCNaHAddressFormat('TCNMBranch'); //1 ที่อยู่ แบบแยก  ,2  แบบรวม
                                    ?>
                                    <?php if (!empty($tTWOFormatAddressType) && $tTWOFormatAddressType == '1') : ?>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1No'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWOShipAddAddV1No"><?php echo @$tTWOShipAddAddV1No; ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1Village'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWOShipAddV1Soi"><?php echo @$tTWOShipAddV1Soi; ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1Soi'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWOShipAddV1Village"><?php echo @$tTWOShipAddV1Village; ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1Road'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWOShipAddV1Road"><?php echo @$tTWOShipAddV1Road; ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1SubDist'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWOShipAddV1SubDist"><?php echo @$tTWOShipAddV1SubDist; ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1DstCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWOShipAddV1DstCode"><?php echo @$tTWOShipAddV1DstCode ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1PvnCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWOShipAddV1PvnCode"><?php echo @$tTWOShipAddV1PvnCode ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1PostCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWOShipAddV1PostCode"><?php echo @$tTWOShipAddV1PostCode; ?></label>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV2Desc1') ?></label><br>
                                                    <label id="ospTWOShipAddV2Desc1"><?php echo @$tTWOShipAddV2Desc1; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV2Desc2') ?></label><br>
                                                    <label id="ospTWOShipAddV2Desc2"><?php echo @$tTWOShipAddV2Desc2; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================================================================================================================================= -->

</form>
<!-- =====================================================================  Modal Advance Table Product DT Temp ==================================================================-->
<div class="modal fade" id="odvTWOOrderAdvTblColumns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?= language('common/main/main', 'tModalAdvTable'); ?></label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body" id="odvTWOModalBodyAdvTable">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= language('common/main/main', 'tModalAdvClose'); ?></button>
                <button id="obtTWOSaveAdvTableColums" type="button" class="btn btn-primary"><?= language('common/main/main', 'tModalAdvSave'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================================================================================================================================= -->

<!-- ================================================================= View Modal Appove Document ================================================================= -->
<div id="odvTWOModalAppoveDoc" class="modal fade xCNModalApprove">
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
                <button id="obtTWOConfirmApprDoc" type="button" class="btn xCNBTNPrimery"><?= language('common/main/main', 'tModalConfirm'); ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================================================================================================================== -->

<!-- ================================================================= กรณีคลังสินค้าต้นทาง ปลายทางว่าง ================================================================= -->
<div class="modal fade" id="odvWTIModalWahIsEmpty">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transferwarehouseout/transferwarehouseout', 'tConditionISEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span id="ospWahIsEmpty"><?= language('document/transferwarehouseout/transferwarehouseout', 'tWahDocumentISEmptyDetail') ?></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalConfirm'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================================================================================================================== -->

<!-- ================================================================= กรณีไม่ได้เลือกประเภทเอกสาร ================================================================= -->
<div class="modal fade" id="odvWTIModalTypeIsEmpty">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transferwarehouseout/transferwarehouseout', 'tConditionISEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span id="ospTypeIsEmpty"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTypeDocumentISEmptyDetail') ?></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalConfirm'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================================================================================================================== -->

<!-- ============================================================== ลบสินค้าแบบหลายตัว  ============================================================ -->
<div id="odvTWOModalDelPdtInDTTempMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type="hidden" id="ohdConfirmTWODocNoDelete" name="ohdConfirmTWODocNoDelete">
                <input type="hidden" id="ohdConfirmTWOSeqNoDelete" name="ohdConfirmTWOSeqNoDelete">
                <input type="hidden" id="ohdConfirmTWOPdtCodeDelete" name="ohdConfirmTWOPdtCodeDelete">
                <input type="hidden" id="ohdConfirmTWOPunCodeDelete" name="ohdConfirmTWOPunCodeDelete">

            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================================================================================================================================= -->

<!-- ============================================================== ยกเลิกเอกสาร ============================================================== -->
<div class="modal fade" id="odvTWOPopupCancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/document/document', 'tDocDocumentCancel') ?></label>
            </div>
            <div class="modal-body">
                <p id="obpMsgApv"><strong><?= language('common/main/main', 'tDocCancelAlert2') ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxTWOTransferwarehouseoutDocCancel(true)" type="button" class="btn xCNBTNPrimery">
                    <?= language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ========================================================================================================================================== -->

<!-- ============================================================== ลบสินค้าแบบหลายตัว  ============================================================ -->
<div id="odvTWOModalPDTCN" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transferwarehouseout/transferwarehouseout', 'tImportPDT') ?></label>
            </div>
            <div class="modal-body" id="odvPDTInCN">

            </div>
            <div class="modal-footer">
                <button id="osmConfirmPDTCN" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================================================================================================================================= -->

<!--- ============================================================== กรณีไม่มีสินค้าใน Tmp  ============================================================ -->
<div id="odvWTIModalPleaseSelectPDT" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transferwarehouseout/transferwarehouseout', 'tConditionPDTEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span><?= language('document/transferwarehouseout/transferwarehouseout', 'tConditionPDTEmptyDetail') ?></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalConfirm'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================================================================================================================================= -->
<!-- =========================================== อ้างอิงเอกสารภายใน ======================================= -->
<div id="odvTransferBchOutBchModalRefIntDoc" class="modal fade" tabindex="2" role="dialog">
    <div class="modal-dialog" role="document" style="width: 1200px;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transfer_branch_out/transfer_branch_out', 'อ้างอิงเอกสารภายใน') ?></label>
            </div>
            <div class="modal-body">
                <div class="row" id="odvTransferBchOutBchFromRefIntDoc"></div>
            </div>
            <div class="modal-footer">
                <button id="obtConfirmRefDocInt" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>


<!-- ===========================================  อ้างอิงเอกสารภายใน (ภายใน หรือ ภายนอก) =========================================== -->
<div id="odvTWOModalAddDocRef" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="ofmTWOFormAddDocRef" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'อ้างอิงเอกสาร') ?></label>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control xCNHide" id="oetTWORefDocNoOld" name="oetTWORefDocNoOld">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'ประเภทการอ้างอิงเอกสาร'); ?></label>
                                <select class="selectpicker form-control" id="ocbTWORefType" name="ocbTWORefType">
                                    <option value="1" selected><?php echo language('common/main/main', 'อ้างอิงภายใน'); ?></option>
                                    <option value="3"><?php echo language('common/main/main', 'อ้างอิงภายนอก'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefInt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'เอกสาร'); ?></label>
                                <select class="selectpicker form-control" id="ocbTWORefDoc" name="ocbTWORefDoc">
                                    <option value="1" selected><?php echo language('common/main/main', 'ใบขอโอน - สาขา'); ?></option>
                                    <!-- <option value="2"><?php echo language('common/main/main', 'ใบสั่งงาน'); ?></option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefInt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง') ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetTWODocRefInt" name="oetTWODocRefInt" maxlength="20" value="">
                                    <input type="text" class="form-control xWPointerEventNone" id="oetTWODocRefIntName" name="oetTWODocRefIntName" maxlength="20" placeholder="<?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง') ?>" value="" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtTWOBrowseRefDoc" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefExt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง'); ?></label>
                                <input type="text" class="form-control" id="oetTWORefDocNo" name="oetTWORefDocNo" placeholder="<?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง'); ?>" maxlength="20" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/document/document', 'วันที่เอกสารอ้างอิง'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTWORefDocDate" name="oetTWORefDocDate" placeholder="YYYY-MM-DD" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button id="obtTWORefDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefExt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'ค่าอ้างอิง'); ?></label>
                                <input type="text" class="form-control" id="oetTWORefKey" name="oetTWORefKey" placeholder="<?php echo language('common/main/main', 'ค่าอ้างอิง'); ?>" maxlength="10" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="obtTWOConfirmAddDocRef" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="submit"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include('script/jTransferwarehouseoutAdd.php'); ?>
<script src="<?php echo base_url('application\modules\common\assets\js\jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js'); ?>"></script>


<script>
    //Ref เอกสาร
    function JSxCallPageTransferWareHouseOutRefIntDoc() {
        var tBCHCode = $('#oetTransferWareHouseOutBchCode').val()
        var tBCHName = $('#oetTransferWareHouseOutBchName').val()



        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docTransferBchOutRefIntDoc",
            data: {
                'tBCHCode': tBCHCode,
                'tBCHName': tBCHName,
            },
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                JCNxCloseLoading();
                $('#odvTransferBchOutBchModalRefIntDoc #odvTransferBchOutBchFromRefIntDoc').html(oResult);

                // $('#odvTBOModalAddDocRef').modal('hide');
                setTimeout(function() {
                    $('#odvTransferBchOutBchModalRefIntDoc').modal({
                        backdrop: 'static',
                        show: true
                    });
                }, 500);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //กดยืนยัน Ref เอกสารใบรับของ
    $('#obtConfirmRefDocInt').click(function() {
        var tRefIntDocNo = $('.xDocuemntRefInt.active').data('docno');
        var tRefIntDocDate = $('.xDocuemntRefInt.active').data('docdate');


        //ถ้าไม่เลือกเอกสารอ้างอิงมา
        if (tRefIntDocNo != undefined) {

            //อ้างอิงเอกสารภายใน
            $('#oetTBODocRefInt').val(tRefIntDocNo);
            $('#oetTBODocRefIntName').val(tRefIntDocNo);

            //วันที่อ้างอิงเอกสารใน
            $('#oetTBORefDocDate').val(tRefIntDocDate).datepicker("refresh");


        } else {
            //อ้างอิงเอกสารภายใน
            $('#oetTBODocRefInt').val('');
            $('#oetTBODocRefIntName').val('');

            //วันที่อ้างอิงเอกสารใน
            $('#oetTBORefDocDate').val('').datepicker("refresh");
        }

    });
</script>