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
if (isset($aDataDocHD) && $aDataDocHD['rtCode'] == "1") {
    $tTBIRoute              = "docTBIEventEdit";
    // $tTBICompCode           = $tCmpCode;
    $nTBIAutStaEdit         = 1;
    $tTBIStaApv             = $aDataDocHD['raItems']['FTXthStaApv'];
    $tTBIStaDoc             = $aDataDocHD['raItems']['FTXthStaDoc'];
    $tTBIStaPrcStk          = $aDataDocHD['raItems']['FTXthStaPrcStk'];
    $nTBIStaDocAct          = $aDataDocHD['raItems']['FNXthStaDocAct'];
    $tTBIStaDelMQ           = $aDataDocHD['raItems']['FTXthStaDelMQ'];
    $tTBIBchCode            = $aDataDocHD['raItems']['FTBchCode'];
    $tTBIBchName            = $aDataDocHD['raItems']['FTBchName'];
    $tTBIDptCode            = $aDataDocHD['raItems']['FTDptCode'];
    $tTBIUsrCode            = $aDataDocHD['raItems']['FTXthApvCode'];
    $tTBIDocNo              = $aDataDocHD['raItems']['FTXthDocNo'];
    $dTBIDocDate            = date("Y-m-d", strtotime($aDataDocHD['raItems']['FDXthDocDate']));
    $dTBIDocTime            = date("H:i:s", strtotime($aDataDocHD['raItems']['FDXthDocDate']));
    $tTBICreateBy           = $aDataDocHD['raItems']['FTCreateBy'];
    $tTBIUsrNameCreateBy    = $aDataDocHD['raItems']['FTUsrName'];
    $tTBIApvCode            = $aDataDocHD['raItems']['FTXthApvCode'];
    $tTBIUsrNameApv         = $aDataDocHD['raItems']['FTUsrName'];
    $tTBIDocType            = $aDataDocHD['raItems']['FNXthDocType'];
    // $tTBIRsnType            = $aDataDocHD['raItems']['FTXthTypRefFrm'];
    $tTBIVATInOrEx          = $aDataDocHD['raItems']['FTXthVATInOrEx'];
    // $tTBIMerCode            = $aDataDocHD['raItems']['FTXthMerCode'];

    $tTBIBchCodeFrm         = $aDataDocHD['raItems']['FTBchCodeFrom'];
    $tTBIBchNameFrm         = $aDataDocHD['raItems']['FTBchNameFrom'];

    $tTBIBchCodeTo          = $aDataDocHD['raItems']['FTBchCodeTo'];
    $tTBIBchNameTo          = $aDataDocHD['raItems']['FTBchNameTo'];

    // $tTBIShopFrm            = $aDataDocHD['raItems']['FTXthShopFrm'];
    // $tTBIShopTo             = $aDataDocHD['raItems']['FTXthShopTo'];
    // $tTBIShopName           = $aDataDocHD['raItems']['FTShpName'];
    // $tTBIShopNameTo          = $aDataDocHD['raItems']['ShpNameTo'];
    // $tTBIWhFrm              = $aDataDocHD['raItems']['FTXthWhFrm'];
    // $tTBIWhTo               = $aDataDocHD['raItems']['FTXthWhTo'];
    // $tTBIWhName             = $aDataDocHD['raItems']['FTWahName'];

    $tTBIWhCodeTo           = $aDataDocHD['raItems']['FTWahCodeTo'];
    $tTBIWhNameTo           = $aDataDocHD['raItems']['FTWahNameTo'];

    // $tTBIPosFrm             = $aDataDocHD['raItems']['FTXthPosFrm'];
    // $tTBIPosTo              = $aDataDocHD['raItems']['FTXthPosTo'];
    $tTBISplCode            = $aDataDocHD['raItems']['FTSplCode'];
    $tTBISplName            = $aDataDocHD['raItems']['FTSplName'];
    $tTBIOther              = $aDataDocHD['raItems']['FTXthOther'];
    $tTBIRefExt             = $aDataDocHD['raItems']['FTXthRefExt'];
    $tTBIRefExtDate         = $aDataDocHD['raItems']['FDXthRefExtDate'];
    $tTBIRefInt             = $aDataDocHD['raItems']['FTXthRefInt'];
    $tTBIRefIntDate         = $aDataDocHD['raItems']['FDXthRefIntDate'];
    $tTBIDocPrint           = $aDataDocHD['raItems']['FNXthDocPrint'];
    $tTBIRmk                = $aDataDocHD['raItems']['FTXthRmk'];
    $tTBIRsnCode            = $aDataDocHD['raItems']['FTRsnCode'];
    $tTBIRsnName            = $aDataDocHD['raItems']['FTRsnName'];

    $tTBICtrName            = $aDataDocHD['raItems']['FTXthCtrName'];
    $dTBITnfDate            = $aDataDocHD['raItems']['FDXthTnfDate'];
    $tTBIRefTnfID           = $aDataDocHD['raItems']['FTXthRefTnfID'];
    $tTBIRefVehID           = $aDataDocHD['raItems']['FTXthRefVehID'];
    $tTBIQtyAndTypeUnit     = $aDataDocHD['raItems']['FTXthQtyAndTypeUnit'];
    $nTBIShipAdd            = $aDataDocHD['raItems']['FNXthShipAdd'];
    $tTBIViaCode            = $aDataDocHD['raItems']['FTViaCode'];
    $tTBIViaName            = $aDataDocHD['raItems']['FTViaName'];


    $thRsnType              = $aDataDocHD['raItems']['FTXthRsnType'];
    $nStaUploadFile         = 2;
} else {
    $tTBIRoute              = "docTBIEventAdd";
    // $tTBICompCode           = $tCmpCode;
    $nTBIAutStaEdit         = 0;
    $tTBIStaApv             = "";
    $tTBIStaDoc             = "";
    $tTBIStaPrcStk          = "";
    $nTBIStaDocAct          = "1";
    $tTBIStaDelMQ           = "";
    $tTBIBchCode            = $this->session->userdata('tSesUsrBchCodeDefault');
    $tTBIBchName            = $this->session->userdata('tSesUsrBchNameDefault');
    $tTBIDptCode            = $tDptCode;
    $tTBIUsrCode            = $this->session->userdata('tSesUsername');
    $tTBIDocNo              = "";
    $dTBIDocDate            = "";
    $dTBIDocTime            = date('H:i');
    $tTBICreateBy           = $this->session->userdata('tSesUsrUsername');
    $tTBIUsrNameCreateBy    = $this->session->userdata('tSesUsrUsername');
    $tTBIApvCode            = "";
    $tTBIUsrNameApv         = "";
    $tTBIDocType            = "";
    // $tTBIRsnType            = "";
    $tTBIVATInOrEx          = 1;
    // $tTBIMerCode            = "";

    $tTBIBchCodeFrm         = "";
    $tTBIBchNameFrm         = "";
    $tTBIBchCodeTo          = $this->session->userdata('tSesUsrBchCodeDefault');
    $tTBIBchNameTo          = $this->session->userdata('tSesUsrBchNameDefault');

    // $tTBIShopFrm            = "";
    // $tTBIShopTo             = "";
    // $tTBIShopName           = "";
    // $tTBIShopNameTo         = "";
    // $tTBIWhFrm              = "";
    // $tTBIWhTo               = "";
    // $tTBIWhName             = "";

    $tTBIWhCodeTo           = "";
    $tTBIWhNameTo           = "";
    // $tTBIPosFrm             = "";
    // $tTBIPosTo              = "";
    $tTBISplCode            = "";
    $tTBISplName            = "";
    $tTBIOther              = "";
    $tTBIRefExt             = "";
    $tTBIRefExtDate         = "";
    $tTBIRefInt             = "";
    $tTBIRefIntDate         = "";
    $tTBIDocPrint           = "0";
    $tTBIRmk                = "";
    $tTBIRsnCode            = "";
    $tTBIRsnName            = "";

    $tTBICtrName            = "";
    $dTBITnfDate            = "";
    $tTBIRefTnfID           = "";
    $tTBIRefVehID           = "";
    $tTBIQtyAndTypeUnit     = "";
    $nTBIShipAdd            = "";
    $tTBIViaCode            = "";
    $tTBIViaName            = "";
    $thRsnType              = "3";
    $nStaUploadFile         = 1;
}

$bIsApv         = empty($tTBIStaApv) ? false : true;
$bIsCancel      = ($tTBIStaDoc == "3") ? true : false;
$bIsApvOrCancel = ($bIsApv || $bIsCancel);
$bIsAddPage = empty($tTBIDocNo) ? true : false;
?>
<form id="ofmTransferreceiptFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button style="display:none" type="submit" id="obtSubmitTransferreceipt" onclick="JSxTransferreceiptEventAddEdit('<?= $tTBIRoute ?>')"></button>

    <input type="hidden" id="ohdBaseUrl" name="ohdBaseUrl" value="<?= base_url(); ?>">
    <input type="hidden" id="ohdTBIRoute" name="ohdTBIRoute" value="<?= $tTBIRoute; ?>">
    <input type="hidden" id="ohdTBICheckClearValidate" name="ohdTBICheckClearValidate" value="0">
    <input type="hidden" id="ohdTBICheckSubmitByButton" name="ohdTBICheckSubmitByButton" value="0">
    <input type="hidden" id="ohdTBIAutStaEdit" name="ohdTBIAutStaEdit" value="<?= $nTBIAutStaEdit; ?>">
    <input type="hidden" id="ohdTBIStaApv" name="ohdTBIStaApv" value="<?= $tTBIStaApv; ?>">
    <input type="hidden" id="ohdTBIStaDoc" name="ohdTBIStaDoc" value="<?= $tTBIStaDoc; ?>">
    <input type="hidden" id="ohdTBIStaPrcStk" name="ohdTBIStaPrcStk" value="<?= $tTBIStaPrcStk; ?>">
    <input type="hidden" id="ohdTBIStaDelMQ" name="ohdTBIStaDelMQ" value="<?= $tTBIStaDelMQ; ?>">
    <input type="hidden" id="ohdTBISesUsrBchCode" name="ohdTBISesUsrBchCode" value="<?= $this->session->userdata("tSesUsrBchCode"); ?>">
    <input type="hidden" id="ohdTBIBchCode" name="ohdTBIBchCode" value="<?= $tTBIBchCode; ?>">
    <input type="hidden" id="ohdTBIDptCode" name="ohdTBIDptCode" value="<?= $tTBIDptCode; ?>">
    <input type="hidden" id="ohdTBIUsrCode" name="ohdTBIUsrCode" value="<?= $tTBIUsrCode; ?>">
    <input type="hidden" id="ohdTBIApvCodeUsrLogin" name="ohdTBIApvCodeUsrLogin" value="<?= $tTBIUsrCode; ?>">
    <input type="hidden" id="ohdTBILangEdit" name="ohdTBILangEdit" value="<?= $this->session->userdata("tLangEdit"); ?>">
    <input type="hidden" id="ohdTBIFrmSplInfoVatInOrEx" name="ohdTBIFrmSplInfoVatInOrEx" value="<?= $tTBIVATInOrEx ?>">
    <input type="hidden" id="ohdTBIFrmDocType" name="ohdTBIFrmDocType" value="<?= $tTBIDocType ?>">

    <!-- ข้อมูลสำหรับ Browse Product -->
    <input type="hidden" id="ohdTBIUsrLevel" name="ohdTBIUsrLevel" value="<?= $this->session->userdata("tSesUsrLevel"); ?>">
    <input type="hidden" id="ohdTBIShpCode" name="ohdTBIShpCode" value="<?= $this->session->userdata("tSesUsrShpCodeDefault"); ?>">
    <input type="hidden" id="ohdTBIMerCode" name="ohdTBIMerCode" value="<?= $this->session->userdata("tSesUsrMerCode"); ?>">




    <input type="hidden" name="tRefIntDocNo" id="tRefIntDocNo" />
    <input type="hidden" name="tRefIntDocDate" id="tRefIntDocDate" />
    <input type="hidden" name="tRefIntBchCode" id="tRefIntBchCode" />
    <input type="hidden" name="oetTransferBchOutXthBchFrmCode" id="oetTransferBchOutXthBchFrmCode" />
    <input type="hidden" name="oetTransferBchOutXthBchFrmName" id="oetTransferBchOutXthBchFrmName" />
    <input type="hidden" name="oetTransferBchOutXthWhFrmCode" id="oetTransferBchOutXthWhFrmCode" />
    <input type="hidden" name="oetTransferBchOutXthWhFrmName" id="oetTransferBchOutXthWhFrmName" />
    <input type="hidden" name="oetTransferBchOutXthBchToCode" id="oetTransferBchOutXthBchToCode" />
    <input type="hidden" name="oetTransferBchOutXthBchToName" id="oetTransferBchOutXthBchToName" />
    <input type="hidden" name="oetTransferBchOutXthWhToCode" id="oetTransferBchOutXthWhToCode" />
    <input type="hidden" name="oetTransferBchOutXthWhToName" id="oetTransferBchOutXthWhToName" />
    <div class="row">
        <div class="col-md-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIDocument'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTBIDataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTBIDataStatusInfo" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="xCNTitleFrom "><?php echo language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIApproved'); ?></label>
                                </div>
                                <input type="hidden" value="0" id="ohdCheckTBISubmitByButton" name="ohdCheckTBISubmitByButton">
                                <input type="hidden" value="0" id="ohdCheckTBIClearValidate" name="ohdCheckTBIClearValidate">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIDocNo'); ?></label>
                                <?php if (empty($tTBIDocNo)) : ?>
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbTBIStaAutoGenCode" name="ocbTBIStaAutoGenCode" maxlength="1" checked="true" value="1">
                                            <span><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTBIAutoGenCode'); ?></span>
                                        </label>
                                    </div>
                                <?php endif; ?>

                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input type="text" class="form-control xWTooltipsBT xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetTBIDocNo" name="oetTBIDocNo" maxlength="20" value="<?= $tTBIDocNo; ?>" data-validate="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIPlsEnterOrRunDocNo'); ?>" data-validate-duplicate="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIPlsDocNoDuplicate'); ?>" placeholder="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIDocNo'); ?>" style="pointer-events:none" readonly>
                                    <input type="hidden" id="ohdTBICheckDuplicateCode" name="ohdTBICheckDuplicateCode" value="2">
                                </div>

                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIDocDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTBIDocDate" name="oetTBIDocDate" value="<?= $dTBIDocDate; ?>" data-validate-required="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tASTPlsEnterDocDate'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtTBIDocDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIDocTime'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNTimePicker" id="oetTBIDocTime" name="oetTBIDocTime" value="<?= $dTBIDocTime; ?>" data-validate-required="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIPlsEnterDocTime'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtTBIDocTime" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBICreateBy'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdTBICreateBy" name="ohdTBICreateBy" value="<?= $tTBICreateBy ?>">
                                            <label><?= $tTBIUsrNameCreateBy ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBITBStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIStaDoc' . $tTBIStaDoc); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transfer_branch_out/transfer_branch_out', 'tTBStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIStaApv' . $tTBIStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- ผู้อนุมัติเอกสาร -->
                                <?php if (isset($tTBIDocNo) && !empty($tTBIDocNo)) : ?>
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdTBIApvCode" name="ohdTBIApvCode" maxlength="20" value="<?= $tTBIApvCode ?>">
                                                <label>
                                                    <?php echo (isset($tTBIUsrNameApv) && !empty($tTBIUsrNameApv)) ? $tTBIUsrNameApv : "-" ?>
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
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIConditionDoc'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTBIDataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTBIDataConditionDoc" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <!--สาขา-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/transfer_branch_out/transfer_branch_out', 'tTBBchCreate') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetTBIBchCode" name="oetTBIBchCode" maxlength="5" value="<?php echo @$tTBIBchCode ?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetTBIBchName" name="oetTBIBchName" maxlength="50" placeholder="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBranch') ?>" value="<?php echo @$tTBIBchName ?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtBrowseTBIBch" type="button" class="btn xCNBtnBrowseAddOn" <?php if ($tTBIRoute == 'docTBIEventEdit') {
                                                                                                                            echo 'disabled';
                                                                                                                        }
                                                                                                                        ?>>
                                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!--เงื่อนไขของประเภท รับโอน-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIOrigin'); ?></legend>

                                            <!--เงื่อนไขของประเภท รับโอน-->
                                            <div id="odvTBI_5" class="row" style="display:none;">
                                                <!--เลือก เอกสารอ้างอิง-->
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" hidden>
                                                    <div class="form-group" >
                                                        <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBrowsDocTBO') ?></label>
                                                        <div class="input-group">
                                                            <input name="oetTBIRefIntDoc" id="oetTBIRefIntDoc" class="form-control xCNClearValue" value="<?= $tTBIRefInt ?>" type="text" readonly="" data-validate="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIPlsEnterRefIntFrom') ?>" placeholder="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBrowsDocTBO') ?>">
                                                            <span class="input-group-btn">
                                                                <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="oetTBIDocReferBrows" type="button">
                                                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--แสดง สาขาต้นทาง-->
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'tBCH'); ?></label>
                                                        <input type="text" class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetTBIBchCodeFrom" name="oetTBIBchCodeFrom" maxlength="5" value="<?php echo @$tTBIBchCodeFrm ?>">
                                                        <input name="oetTBIBchNameFrom" id="oetTBIBchNameFrom" class="form-control xCNClearValue" value="<?= $tTBIBchNameFrm ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBranch') ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!--เงื่อนไขของประเภท รับเข้า-->
                                            <div id="odvTBI_1" class="row" style="display:none;">

                                                <!--ประเภทของการรับเข้า-->
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIConditionIN'); ?></label>
                                                        <select class="selectpicker form-control" id="ocmSelectTransTypeIN" name="ocmSelectTransTypeIN">
                                                            <!-- <option value='0' selected><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIConditionTo'); ?></option> -->
                                                            <option value='3' <?php if ($tTBISplName != null) {
                                                                                    echo "selected";
                                                                                } ?>><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tINSPL'); ?></option>
                                                            <option value='4' <?php if ($tTBIOther != null) {
                                                                                    echo "selected";
                                                                                } ?>><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tINETC'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <script>
                                                    //$('#ocmSelectTransTypeIN').val(<?php echo $thRsnType; ?>).change();
                                                    $('#ocmSelectTransTypeIN').change(function() {
                                                        var tValue = $(this).val();
                                                        if (tValue == 3) {
                                                            $('#odvINWhereSPL').css('display', 'block');
                                                            $('#odvINWhereETC').css('display', 'none');
                                                        } else if (tValue == 4) {
                                                            $('#odvINWhereSPL').css('display', 'none');
                                                            $('#odvINWhereETC').css('display', 'block');
                                                        }
                                                    });
                                                </script>

                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div id="odvINWhereSPL" style="display:none;">

                                                        <!--เลือกผู้จำหน่าย - รับเข้า - เงือนไขผู้จำหน่าย-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('supplier/supplier/supplier', 'tSPLTitle'); ?></label>
                                                            <div class="input-group">
                                                                <input name="oetTBISplName" id="oetTBISplName" class="form-control xCNClearValue" value="<?= $tTBISplName ?>" type="text" readonly="" data-validate="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIPlsEnterSplFrom'); ?>" placeholder="<?= language('supplier/supplier/supplier', 'tSPLTitle') ?>">
                                                                <input name="oetTBISplCode" id="oetTBISplCode" value="<?= $tTBISplCode ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                                <span class="input-group-btn">
                                                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtTBIBrowseSpl" type="button">
                                                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div id="odvINWhereETC" style="display:none;">
                                                        <!--กรอกแหล่งอื่น - รับเข้า - เงือนไขแหล่งอื่น-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tINETC'); ?></label>
                                                            <input type="text" class="form-control xCNClearValue" id="oetTBIINEtc" name="oetTBIINEtc" value="<?= $tTBIOther ?>" maxlength="100" data-validate="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIPlsEntertOtherFrom'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-lg-12">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBITo'); ?></legend>
                                            <?php if ($this->session->userdata('nSesUsrBchCount') == 1) { ?>
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBranch') ?></label>

                                                    <input name="oetTBIBchCodeTo" id="oetTBIBchCodeTo" class="form-control xCNHide" value="<?= $tTBIBchCodeTo; ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBranch') ?>">
                                                    <input name="oetTBIBchNameTo" id="oetTBIBchNameTo" class="form-control" value="<?= $tTBIBchNameTo ?>" type="text" readonly="">

                                                </div>
                                            <?php } else { ?>
                                                <!-- แสดง สาขาปลายทาง -->
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBranch') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetTBIBchCodeTo" name="oetTBIBchCodeTo" maxlength="5" value="<?php echo @$tTBIBchCodeTo ?>">
                                                        <input type="text" class="form-control xWPointerEventNone" id="oetTBIBchNameTo" name="oetTBIBchNameTo" maxlength="100" placeholder="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBranch') ?>" value="<?php echo @$tTBIBchNameTo ?>" readonly>
                                                        <span class="input-group-btn">
                                                            <button id="obtBrowseTWOBCHTo" data-btn="TOBCH" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
                                                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- <div class="form-group">
                                                <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBranch') ?></label>
                                                <input name="oetTBIBchCodeTo" id="oetTBIBchCodeTo" class="form-control xCNHide" value="<?= $tTBIBchCodeTo; ?>" type="text" readonly=""
                                                       placeholder="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBranch') ?>" >
                                                <input name="oetTBIBchNameTo" id="oetTBIBchNameTo" class="form-control" value="<?= $tTBIBchNameTo ?>" type="text" readonly="" >
                                            </div> -->

                                            <!-- เลือก คลังสินค้าปลายทาง -->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIWarehouse') ?></label>
                                                <div class="input-group">
                                                    <input name="oetTBIWahNameTo" id="oetTBIWahNameTo" class="form-control" value="<?= $tTBIWhNameTo; ?>" type="text" readonly="" data-validate="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIPlsEnterWahTo') ?>" placeholder="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBITablePDTWah') ?>">
                                                    <input name="oetTBIWahCodeTo" id="oetTBIWahCodeTo" value="<?= $tTBIWhCodeTo; ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtTBIBrowseWahTo" type="button" data-btn="TOWAH">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
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

            <!-- Panel อ้างอิง -->
            <div class="panel panel-default" hidden style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIPanelRef'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTBIDataConditionREF" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTBIDataConditionREF" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <!-- อ้างอิงเลขที่เอกสารภายนอก -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/saleorder/saleorder', 'tSOLabelFrmRefExtDoc'); ?></label>
                            <input type="text" class="form-control " id="oetTBIRefExtDoc" name="oetTBIRefExtDoc" value="<?= $tTBIRefExt ?>">
                        </div>
                        <!-- วันที่เอกสารภายนอก -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/saleorder/saleorder', 'tSOLabelFrmRefExtDocDate'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate " id="oetTBIRefExtDocDate" name="oetTBIRefExtDocDate" placeholder="YYYY-MM-DD" value="<?= $tTBIRefExtDate ?>">
                                <span class="input-group-btn">
                                    <button id="obtTBIBrowseRefExtDocDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled"><img class="xCNIconCalendar"></button>
                                </span>
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
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTBITransportCtrName" name="oetTBITransportCtrName" value="<?= $tTBICtrName; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWTnfDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTBITransportTnfDate" name="oetTBITransportTnfDate" placeholder="YYYY-MM-DD" value="<?= $dTBITnfDate; ?>">
                                        <span class="input-group-btn">
                                            <button id="obtTWOTnfDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
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
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTBITransportRefTnfID" name="oetTBITransportRefTnfID" value="<?= $tTBIRefTnfID; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWRefVehID'); ?></label>
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTBITransportRefVehID" name="oetTBITransportRefVehID" value="<?= $tTBIRefVehID; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWQtyAndTypeUnit'); ?></label>
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTBITransportQtyAndTypeUnit" name="oetTBITransportQtyAndTypeUnit" value="<?= $tTBIQtyAndTypeUnit; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tViaCode'); ?></label>
                                    <div class="input-group">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetTBIUpVendingViaName" name="oetTBIUpVendingViaName" value="<?= $tTBIViaName; ?>" readonly>
                                        <input type="text" class="input100 xCNHide xCNApvOrCanCelDisabled" id="oetTBIUpVendingViaCode" name="oetTBIUpVendingViaCode" value="<?= $tTBIViaCode; ?>">
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
                                <input type="hidden" id="ohdTBIFrmShipAdd" name="ohdTBIFrmShipAdd" value="<?= $nTBIShipAdd; ?>">
                                <button type="button" id="obtTBIFrmBrowseShipAdd" class="btn btn-primary xCNApvOrCanCelDisabled" style="width:100%;">
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
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIPanelETC'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTBIDataConditionETC" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTBIDataConditionETC" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <!--เลือกเหตุผล-->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIReason'); ?></label>
                            <div class="input-group">
                                <input name="oetTBIReasonName" id="oetTBIReasonName" class="form-control" value="<?= $tTBIRsnName ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIReason') ?>">
                                <input name="oetTBIReasonCode" id="oetTBIReasonCode" value="<?= $tTBIRsnCode ?>" class="form-control xCNHide" type="text">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTBIReason" type="button">
                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <!-- หมายเหตุ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmInfoOthRemark'); ?></label>
                            <textarea class="form-control " id="otaTBIFrmInfoOthRmk" name="otaTBIFrmInfoOthRmk" rows="10" maxlength="200" style="resize: none;height:86px;"><?php echo $tTBIRmk; ?></textarea>
                        </div>

                        <!-- จำนวนครั้งที่พิมพ์ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmInfoOthDocPrint'); ?></label>
                            <input type="text" class="form-control text-right" id="ocmTBIFrmInfoOthDocPrint" name="ocmTBIFrmInfoOthDocPrint" value="<?= $tTBIDocPrint; ?>" readonly>
                        </div>

                        <!-- สถานะเคลื่อนไหว-->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbTBIStaDocAct" name="ocbTBIStaDocAct" maxlength="1" value="1" <?php echo empty($nTBIStaDocAct) ? '' : 'checked'; ?>>
                                <span>&nbsp;</span>
                                <span class="xCNLabelFrm"><?= language('document/purchaseorder/purchaseorder', 'tTFWStaDocAct'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Panel ไฟลแนบ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                    <div id="odvSOReferenceDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                        <label class="xCNTextDetail1"><?php echo language('document/saleorder/saleorder', 'ไฟล์แนบ'); ?></label>
                        <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvSODataFile" aria-expanded="true">
                            <i class="fa fa-plus xCNPlus"></i>
                        </a>
                    </div>
                    <div id="odvSODataFile" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="odvDOShowDataTable">


                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        let oSOCallDataTableFile = {
                            ptElementID: 'odvDOShowDataTable',
                            ptBchCode: $('#oetTBIBchCode').val(),
                            ptDocNo: $('#oetTBIDocNo').val(),
                            ptDocKey: 'TCNTPdtTbiHD',
                            ptSessionID: '<?= $this->session->userdata("tSesSessionID") ?>',
                            pnEvent: <?= $nStaUploadFile ?>,
                            ptCallBackFunct: 'JSxSoCallBackUploadFile'
                        }
                        JCNxUPFCallDataTable(oSOCallDataTableFile);
                    </script>
                </div>
        </div>
        <!--Panel ตารางฝั่งขวา-->
        <div class="col-md-9" id="odvRightPanal">
          <div class="panel panel-default xCNTransferBchOutPdtContainer" style="margin-bottom: 25px;">
            <div class="panel-collapse collapse in" role="tabpanel">
              <div class="panel-body xCNPDModlue">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="custom-tabs-line tabs-line-bottom left-aligned">
                      <ul class="nav" role="tablist">

                        <!-- สินค้า -->
                        <li class="xWMenu active xCNStaHideShow" style="cursor:pointer;">
                          <a role="tab" data-toggle="tab" data-target="#odvTBIContentProduct" aria-expanded="true"><?= language('document/document/document', 'ข้อมูลสินค้า') ?></a>
                        </li>

                        <!-- อ้างอิง -->
                        <li class="xWMenu xWSubTab xCNStaHideShow" style="cursor:pointer;">
                          <a role="tab" data-toggle="tab" data-target="#odvTBIContentHDDocRef" aria-expanded="false"><?= language('document/document/document', 'เอกสารอ้างอิง') ?></a>
                        </li>

                      </ul>
                    </div>
                  </div>
                </div>
                <div class="tab-content">
                  <!--รายการสินค้า-->
                  <div id="odvTBIContentProduct" class="tab-pane fade active in" style="padding: 0px !important;">
                    <div class="row p-t-0">
                      <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                          <div class="panel-body">
                              <div>
                                  <!--ค้นหา-->
                                  <div class="row p-t-10">
                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                          <div class="form-group">
                                              <div class="input-group">
                                                  <input type="text" class="form-control" maxlength="100" id="oetTBIFrmFilterPdtHTML" name="oetTBIFrmFilterPdtHTML" placeholder="<?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIFrmFilterTablePdt'); ?>" onkeyup="javascript:if(event.keyCode==13) JSvTBIDOCFilterPdtInTableTemp()">
                                                  <input type="text" class="form-control" maxlength="100" id="oetTBIFrmSearchAndAddPdtHTML" name="oetTBIFrmSearchAndAddPdtHTML" onkeyup="Javascript:if(event.keyCode==13) JSxTBIChkConditionSearchAndAddPdt()" placeholder="<?= language('document/purchaseinvoice/purchaseinvoice', 'tPIFrmSearchAndAddPdt'); ?>" style="display:none;" data-validate="<?= language('document/purchaseinvoice/purchaseinvoice', 'tPIMsgValidScanNotFoundBarCode'); ?>">
                                                  <span class="input-group-btn">
                                                      <div id="odvTBISearchAndScanBtnGrp" class="xCNDropDrownGroup input-group-append">
                                                          <button id="obtTBIMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvTBIDOCFilterPdtInTableTemp()">
                                                              <img src="<?php echo  base_url('application/modules/common/assets/images/icons/search-24.png'); ?>" style="width:20px;">
                                                          </button>
                                                          <button id="obtTBIMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSxTBIChkConditionSearchAndAddPdt()">
                                                              <img src="<?php echo  base_url('application/modules/common/assets/images/icons/search-24.png'); ?>" style="width:20px;">
                                                          </button>
                                                          <button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown" style="display:none;">
                                                              <i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
                                                          </button>
                                                          <ul class="dropdown-menu" role="menu">
                                                              <li>
                                                                  <a id="oliTBIMngPdtSearch"><label><?= language('document/purchaseinvoice/purchaseinvoice', 'tPIFrmFilterTablePdt'); ?></label></a>
                                                                  <a id="oliTBIMngPdtScan"><?= language('document/purchaseinvoice/purchaseinvoice', 'tPIFrmSearchAndAddPdt'); ?></a>
                                                              </li>
                                                          </ul>
                                                      </div>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-12 <?php echo (!$bIsApvOrCancel) ? 'col-sm-5 col-md-5 col-lg-5' : 'col-sm-6 col-md-6 col-lg-6'; ?> text-right">
                                          <div id="odvTBIMngAdvTableList" class="btn-group xCNDropDrownGroup" style="display:none;">
                                              <button id="obtTBIAdvTablePdtDTTemp" type="button" class="btn xCNBTNMngTable <?php echo (!$bIsApvOrCancel) ? 'm-r-20' : ''; ?>"><?= language('common/main/main', 'tModalAdvTable') ?></button>
                                          </div>
                                          <?php if (!$bIsApvOrCancel) { ?>
                                              <div id="odvTBIMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
                                                  <button type="button" class="btn xCNBTNMngTable xWDropdown" data-toggle="dropdown">
                                                      <?= language('common/main/main', 'tCMNOption') ?>
                                                      <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu" role="menu">
                                                      <li id="oliTBIBtnDeleteMulti" class="disabled">
                                                          <a data-toggle="modal" data-target="#odvTBIModalDelPdtInDTTempMultiple"><?= language('common/main/main', 'tDelAll') ?></a>
                                                      </li>
                                                  </ul>
                                              </div>
                                          <?php } ?>
                                      </div>
                                      <?php if (!$bIsApvOrCancel) { ?>
                                          <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                              <div class="form-group">
                                                  <div style="position: absolute;right: 15px;">
                                                      <button type="button" id="obtTBIDocBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt">+</button>
                                                  </div>
                                              </div>
                                          </div>
                                      <?php } ?>
                                  </div>

                                  <!--ตาราง-->
                                  <div class="row" id="odvTBIDataPdtTableDTTemp"></div>
                                  <!-- <?  // include('wTransferreceiptbranchEndOfBill.php');
                                          ?> -->
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                  <!--รายการสินค้า-->
                  <!-- อ้างอิงเอกสาร -->
    							<div id="odvTBIContentHDDocRef" class="tab-pane fade" style="padding: 0px !important;">
    								<div class="row p-t-15">
    									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
    										<div style="margin-top:-2px;">
    											<button type="button" id="obtTBIAddDocRef" class="xCNBTNPrimeryPlus xCNDocBrowsePdt xCNHideWhenCancelOrApprove">+</button>
    										</div>
    									</div>
    									<div id="odvTBITableHDRef"></div>
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
    </div>

    <!-- View Modal Shipping Purchase Invoice -->
    <div id="odvTWOBrowseShipAdd" class="modal fade">
        <div class="modal-dialog" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipAddress'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnPIShipAddData()"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
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
                                            <a style="font-size:14px!important;color:#1866ae;">
                                                <i class="fa fa-pencil" id="oliPIEditShipAddress">&nbsp;<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipChange'); ?></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body xCNPDModlue">
                                    <input type="hidden" id="ohdTBIShipAddSeqNo" name="ohdTBIShipAddSeqNo" class="form-control">
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
</form>

<!-- Modal Advance Table Product DT Temp -->
<div class="modal fade" id="odvTBIOrderAdvTblColumns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <div class="modal-body" id="odvTBIModalBodyAdvTable">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= language('common/main/main', 'tModalAdvClose'); ?></button>
                <button id="obtTBISaveAdvTableColums" type="button" class="btn btn-primary"><?= language('common/main/main', 'tModalAdvSave'); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- View Modal Appove Document -->
<div id="odvTBIModalAppoveDoc" class="modal fade xCNModalApprove">
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
                <button id="obtTBIConfirmApprDoc" type="button" class="btn xCNBTNPrimery"><?= language('common/main/main', 'tModalConfirm'); ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel'); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- กรณีคลังสินค้าต้นทาง ปลายทางว่าง -->
<div class="modal fade" id="odvTBIModalWahIsEmpty">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tConditionISEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span id="ospWahIsEmpty"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tWahDocumentISEmptyDetail') ?></span>
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

<!-- กรณีไม่ได้เลือกประเภทเอกสาร -->
<div class="modal fade" id="odvTBIModalTypeIsEmpty">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tConditionISEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span id="ospTypeIsEmpty"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTypeDocumentISEmptyDetail') ?></span>
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

<!-- ลบสินค้าแบบหลายตัว -->
<div id="odvTBIModalDelPdtInDTTempMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type="hidden" id="ohdConfirmTBIDocNoDelete" name="ohdConfirmTBIDocNoDelete">
                <input type="hidden" id="ohdConfirmTBISeqNoDelete" name="ohdConfirmTBISeqNoDelete">
                <input type="hidden" id="ohdConfirmTBIPdtCodeDelete" name="ohdConfirmTBIPdtCodeDelete">
                <input type="hidden" id="ohdConfirmTBIPunCodeDelete" name="ohdConfirmTBIPunCodeDelete">

            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ยกเลิกเอกสาร -->
<div class="modal fade" id="odvTBIPopupCancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/document/document', 'tDocDocumentCancel') ?></label>
            </div>
            <div class="modal-body">
                <p id="obpMsgApv"><strong><?= language('common/main/main', 'tDocCancelAlert2') ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxTBITransferReceiptDocCancel(true)" type="button" class="btn xCNBTNPrimery">
                    <?= language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ลบสินค้าแบบหลายตัว -->
<div id="odvTBIModalPDTCN" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tImportPDT') ?></label>
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

<!-- กรณีไม่มีสินค้าใน Tmp -->
<div id="odvTBIModalPleaseSelectPDT" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tConditionPDTEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tConditionPDTEmptyDetail') ?></span>
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

<!-- กรณีไม่อ้างอิงเอกสาร -->
<div id="odvTBIModalPleaseSelectLef" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tConditionPDTEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tConditionRefEmptyDetail') ?></span>
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
<!-- ===========================================  อ้างอิงเอกสารภายใน (ภายใน หรือ ภายนอก) =========================================== -->
<div id="odvTBIModalAddDocRef" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="ofmTBIFormAddDocRef" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'อ้างอิงเอกสาร') ?></label>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control xCNHide" id="oetTBIRefDocNoOld" name="oetTBIRefDocNoOld">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'ประเภทการอ้างอิงเอกสาร'); ?></label>
                                <select class="selectpicker form-control" id="ocbTBIRefType" name="ocbTBIRefType">
                                    <option value="1" selected><?php echo language('common/main/main', 'อ้างอิงภายใน'); ?></option>
                                    <option value="3"><?php echo language('common/main/main', 'อ้างอิงภายนอก'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefInt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'เอกสาร'); ?></label>
                                <select class="selectpicker form-control" id="ocbTBIRefDoc" name="ocbTBIRefDoc">
                                    <option value="1" selected><?php echo language('common/main/main', 'ใบจ่ายโอน - สาขา'); ?></option>
                                    <!-- <option value="2"><?php echo language('common/main/main', 'ใบจ่ายโอน'); ?></option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefInt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง') ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetTBIDocRefInt" name="oetTBIDocRefInt" maxlength="20" value="">
                                    <input type="text" class="form-control xWPointerEventNone" id="oetTBIDocRefIntName" name="oetTBIDocRefIntName" maxlength="20" placeholder="<?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง') ?>" value="" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtTBIBrowseRefDoc" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefExt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง'); ?></label>
                                <input type="text" class="form-control" id="oetTBIRefDocNo" name="oetTBIRefDocNo" placeholder="<?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง'); ?>" maxlength="20" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/document/document', 'วันที่เอกสารอ้างอิง'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTBIRefDocDate" name="oetTBIRefDocDate" placeholder="YYYY-MM-DD" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button id="obtTBIRefDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefExt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'ค่าอ้างอิง'); ?></label>
                                <input type="text" class="form-control" id="oetTBIRefKey" name="oetTBIRefKey" placeholder="<?php echo language('common/main/main', 'ค่าอ้างอิง'); ?>" maxlength="10" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="obtTBIConfirmAddDocRef" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="submit"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- =========================================== อ้างอิงเอกสารภายใน ======================================= -->
<div id="odvTransferBchOutBchModalRefIntDoc" class="modal fade" tabindex="2" role="dialog">
    <div class="modal-dialog" role="document" style="width: 1200px;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?=language('document/transfer_branch_out/transfer_branch_out','อ้างอิงเอกสารภายใน')?></label>
            </div>
            <div class="modal-body">
                <div class="row" id="odvTransferBchOutBchFromRefIntDoc"></div>
            </div>
            <div class="modal-footer">
                <button id="obtConfirmRefDocInt" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include('script/jTransferReceiptbranchAdd.php'); ?>

<script type="text/javascript">
    $(function() {
        var tValue = $('#ocmSelectTransTypeIN').val();
        if (tValue == 3) {
            $('#odvINWhereSPL').css('display', 'block');
            $('#odvINWhereETC').css('display', 'none');
        } else if (tValue == 4) {
            $('#odvINWhereSPL').css('display', 'none');
            $('#odvINWhereETC').css('display', 'block');
        }
    });
    //Ref เอกสาร
    function JSxCallPageTransferBchOutRefIntDoc(){
          var tBCHCode = $('#oetTBIBchCode').val();
          var tBCHName = $('#oetTBIBchName').val();



          JCNxOpenLoading();
          $.ajax({
              type: "POST",
              url: "docTBITransferBchOutRefIntDoc",
              data: {
                  'tBCHCode'      : tBCHCode,
                  'tBCHName'      : tBCHName,
              },
              cache: false,
              Timeout: 0,
              success: function (oResult){
                  JCNxCloseLoading();
                  $('#odvTransferBchOutBchModalRefIntDoc #odvTransferBchOutBchFromRefIntDoc').html(oResult);

          // $('#odvTBOModalAddDocRef').modal('hide');
          setTimeout(function(){
            $('#odvTransferBchOutBchModalRefIntDoc').modal({backdrop : 'static' , show : true});
          }, 500);

              },
              error: function (jqXHR, textStatus, errorThrown) {
                  JCNxResponseError(jqXHR, textStatus, errorThrown);
              }
          });
      }
      //กดยืนยัน Ref เอกสารใบรับของ
      $('#obtConfirmRefDocInt').click(function(){
        var tRefIntDocNo    =  $('.xDocuemntRefInt.active').data('docno');
        var tRefIntDocDate  =  $('.xDocuemntRefInt.active').data('docdate');
        // var tRefIntBchCode  =  $('.xDocuemntRefInt.active').data('bchcode');
        // var aSeqNo 			=  $('.ocbRefIntDocDT:checked').map(function(elm){ return $(this).val(); }).get();

        //ถ้าไม่เลือกเอกสารอ้างอิงมา
        if( tRefIntDocNo != undefined ){

          // var tSplStaVATInOrEx =  $('.xDocuemntRefInt.active').data('vatinroex');
          // var cSplCrLimit      =  $('.xDocuemntRefInt.active').data('crtrem');
          // var nSplCrTerm       =  $('.xDocuemntRefInt.active').data('crlimit');
          // var tSplCode         =  $('.xDocuemntRefInt.active').data('splcode');
          // var tSplName         =  $('.xDocuemntRefInt.active').data('splname');
          // var tSPlPaidType     =  $('.xDocuemntRefInt.active').data('dstpain');
          // var tVatcode         =  $('.xDocuemntRefInt.active').data('vatcode');
          // var nVatrate         =  $('.xDocuemntRefInt.active').data('vatrate');

          // var poParams = {
          // 	FTSplCode           : tSplCode,
          // 	FTSplName           : tSplName,
          // 	FTSplStaVATInOrEx   : tSplStaVATInOrEx,
          // 	FTRefIntDocNo       : tRefIntDocNo,
          // 	FTRefIntDocDate     : tRefIntDocDate,
          // 	FNXphCrTerm         : nSplCrTerm
          // };

          //อ้างอิงเอกสารภายใน
          $('#oetTBIDocRefInt').val(tRefIntDocNo);
          $('#oetTBIDocRefIntName').val(tRefIntDocNo);
          $('#oetTBIRefIntDoc').val(tRefIntDocNo);

          //วันที่อ้างอิงเอกสารใน
          $('#oetTBIRefDocDate').val(tRefIntDocDate).datepicker("refresh");

          $('#obtTBIConfirmAddDocRef').attr('disabled',false);

          // JCNxOpenLoading();
          // $.ajax({
          // 	type    : "POST",
          // 	url     : "docTransferBchOutRefIntDocInsertDTToTemp",
          // 	data    : {
          // 		'tTransferBchOutDocNo'          : $('#oetTransferBchOutDocNo').val(),
          // 		'tTransferBchOutFrmBchCode'     : $('#oetTransferBchOutBchCode').val(),
          // 		'tRefIntDocNo'      			: tRefIntDocNo,
          // 		'tRefIntBchCode'    			: tRefIntBchCode,
          // 		'tSplStaVATInOrEx'  			: tSplStaVATInOrEx,
          // 		'aSeqNo'            			: aSeqNo
          // 	},
          // 	cache: false,
          // 	Timeout: 0,
          // 	success: function (oResult){
          // 		//โหลดสินค้าใน Temp
          // 		JSxTransferBchOutGetPdtInTmp();
          // 		JCNxCloseLoading();
          // 	},
          // 	error: function (jqXHR, textStatus, errorThrown) {
          // 		JCNxResponseError(jqXHR, textStatus, errorThrown);
          // 	}
          // });

        }else{
          //อ้างอิงเอกสารภายใน
          $('#oetTBIDocRefInt').val('');
          $('#oetTBIDocRefIntName').val('');

          //วันที่อ้างอิงเอกสารใน
          $('#oetTBIRefDocDate').val('').datepicker("refresh");
        }

        // setTimeout(function(){
        // 	$('#odvTBOModalAddDocRef').modal('show');
        // }, 500);

      });
</script>
