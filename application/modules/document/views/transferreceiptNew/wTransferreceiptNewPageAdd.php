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
    $tTWIRoute              = "dcmTWIEventEdit";
    $tTWICompCode           = $tCmpCode;
    $nTWIAutStaEdit         = 1;
    $tTWIStaApv             = $aDataDocHD['raItems']['FTXthStaApv'];
    $tTWIStaDoc             = $aDataDocHD['raItems']['FTXthStaDoc'];
    $tTWIStaPrcStk          = $aDataDocHD['raItems']['FTXthStaPrcStk'];
    $nTWIStaDocAct          = $aDataDocHD['raItems']['FNXthStaDocAct'];
    $tTWIStaDelMQ           = $aDataDocHD['raItems']['FTXthStaDelMQ'];
    $tTWIBchCode            = $aDataDocHD['raItems']['FTBchCode'];
    $tTWIBchName            = $aDataDocHD['raItems']['FTBchName'];
    $tTWIDptCode            = $aDataDocHD['raItems']['FTDptCode'];
    $tTWIUsrCode            = $aDataDocHD['raItems']['FTXthApvCode'];
    $tTWIDocNo              = $aDataDocHD['raItems']['FTXthDocNo'];
    $dTWIDocDate            = date("Y-m-d", strtotime($aDataDocHD['raItems']['FDXthDocDate']));
    $dTWIDocTime            = date("H:i:s", strtotime($aDataDocHD['raItems']['FDXthDocDate']));
    $tTWICreateBy           = $aDataDocHD['raItems']['FTCreateBy'];
    $tTWIUsrNameCreateBy    = $aDataDocHD['raItems']['FTUsrName'];
    $tTWIApvCode            = $aDataDocHD['raItems']['FTXthApvCode'];
    $tTWIDocType            = $aDataDocHD['raItems']['FNXthDocType'];
    $tTWIRsnType            = $aDataDocHD['raItems']['FTXthTypRefFrm'];
    $tTWIVATInOrEx          = $aDataDocHD['raItems']['FTXthVATInOrEx'];
    $tTWIMerCode            = $aDataDocHD['raItems']['FTXthMerCode'];
    $tTWIShopFrm            = $aDataDocHD['raItems']['FTXthShopFrm'];
    $tTWIShopTo             = $aDataDocHD['raItems']['FTXthShopTo'];
    $tTWIShopName           = $aDataDocHD['raItems']['FTShpName'];
    $tTWIShopNameTo          = $aDataDocHD['raItems']['ShpNameTo'];
    $tTWIWhFrm              = $aDataDocHD['raItems']['FTXthWhFrm'];
    $tTWIWhTo               = $aDataDocHD['raItems']['FTXthWhTo'];
    $tTWIWhName             = $aDataDocHD['raItems']['FTWahName'];
    $tTWIWhNameTo           = $aDataDocHD['raItems']['WahNameTo'];
    $tTWIPosFrm             = $aDataDocHD['raItems']['FTXthPosFrm'];
    $tTWIPosTo              = $aDataDocHD['raItems']['FTXthPosTo'];
    $tTWIPosNameFrm         = $aDataDocHD['raItems']['FTXthPosNameFrm'];
    $tTWIPosNameTo          = $aDataDocHD['raItems']['FTXthPosNameTo'];
    $tTWISplCode            = $aDataDocHD['raItems']['FTSplCode'];
    $tTWISplName            = $aDataDocHD['raItems']['FTSplName'];
    $tTWIOther              = $aDataDocHD['raItems']['FTXthOther'];
    $tTWIRefExt             = $aDataDocHD['raItems']['FTXthRefExt'];
    $tTWIRefExtDate         = $aDataDocHD['raItems']['FDXthRefExtDate'];
    $tTWIRefInt             = $aDataDocHD['raItems']['FTXthRefInt'];
    $tTWIRefIntDate         = $aDataDocHD['raItems']['FDXthRefIntDate'];
    $tTWIDocPrint           = $aDataDocHD['raItems']['FNXthDocPrint'];
    $tTWIRmk                = $aDataDocHD['raItems']['FTXthRmk'];
    $tTWIRsnCode            = $aDataDocHD['raItems']['FTRsnCode'];
    $tTWIRsnName            = $aDataDocHD['raItems']['FTRsnName'];

    $tTWIBchCompCode        = $aDataDocHD['raItems']['FTBchCode'];
    $tTWIBchCompName        = $aDataDocHD['raItems']['FTBchName'];
    $tTWIUserBchName        = $aDataDocHD['raItems']['FTBchName'];





    // ที่อยู่สำหรับการจัดส่ง
    if (!empty($aDataDocHDRef['raItems'])) {
        $tTWIthCtrName            = $aDataDocHDRef['raItems']['FTXthCtrName'];
        $dTWIXthTnfDate         = $aDataDocHDRef['raItems']['FDXthTnfDate'];
        $tTWIXthRefTnfID        = $aDataDocHDRef['raItems']['FTXthRefTnfID'];
        $tTWIXthRefVehID        = $aDataDocHDRef['raItems']['FTXthRefVehID'];
        $tTWIXthQtyAndTypeUnit  = $aDataDocHDRef['raItems']['FTXthQtyAndTypeUnit'];
        $nTWIXthShipAdd         = $aDataDocHDRef['raItems']['FNXthShipAdd'];
        $tTWIViaCode            = $aDataDocHDRef['raItems']['FTViaCode'];


        $tTWISplShipAdd          = $aDataDocHDRef['raItems']['FNXthShipAdd'];
        $tTWIShipAddAddV1No      = (isset($aDataDocHDRef['raItems']['FTAddV1No']) && !empty($aDataDocHDRef['raItems']['FTAddV1No'])) ? $aDataDocHDRef['raItems']['FTAddV1No'] : "-";
        $tTWIShipAddV1Soi        = (isset($aDataDocHDRef['raItems']['FTAddV1Soi']) && !empty($aDataDocHDRef['raItems']['FTAddV1Soi'])) ? $aDataDocHDRef['raItems']['FTAddV1Soi'] : "-";
        $tTWIShipAddV1Village    = (isset($aDataDocHDRef['raItems']['FTAddV1Village']) && !empty($aDataDocHDRef['raItems']['FTAddV1Village'])) ? $aDataDocHDRef['raItems']['FTAddV1Village'] : "-";
        $tTWIShipAddV1Road       = (isset($aDataDocHDRef['raItems']['FTAddV1Road']) && !empty($aDataDocHDRef['raItems']['FTAddV1Road'])) ? $aDataDocHDRef['raItems']['FTAddV1Road'] : "-";
        $tTWIShipAddV1SubDist    = (isset($aDataDocHDRef['raItems']['FTAddV1SubDist']) && !empty($aDataDocHDRef['raItems']['FTSudName'])) ? $aDataDocHDRef['raItems']['FTSudName'] : "-";
        $tTWIShipAddV1DstCode    = (isset($aDataDocHDRef['raItems']['FTAddV1DstCode']) && !empty($aDataDocHDRef['raItems']['FTDstName'])) ? $aDataDocHDRef['raItems']['FTDstName'] : "-";
        $tTWIShipAddV1PvnCode    = (isset($aDataDocHDRef['raItems']['FTAddV1PvnCode']) && !empty($aDataDocHDRef['raItems']['FTPvnName'])) ? $aDataDocHDRef['raItems']['FTPvnName'] : "-";
        $tTWIShipAddV1PostCode   = (isset($aDataDocHDRef['raItems']['FTAddV1PostCode']) && !empty($aDataDocHDRef['raItems']['FTAddV1PostCode'])) ? $aDataDocHDRef['raItems']['FTAddV1PostCode'] : "-";
    } else {

        $tTWIthCtrName            = "";
        $dTWIXthTnfDate           = "";
        $tTWIXthRefTnfID          = "";
        $tTWIXthRefVehID          = "";
        $tTWIXthQtyAndTypeUnit    = "";
        $nTWIXthShipAdd           = "";
        $tTWIViaCode              = "";


        $tTWISplShipAdd          = "";
        $tTWIShipAddAddV1No      = "-";
        $tTWIShipAddV1Soi        = "-";
        $tTWIShipAddV1Village    = "-";
        $tTWIShipAddV1Road       = "-";
        $tTWIShipAddV1SubDist    = "-";
        $tTWIShipAddV1DstCode    = "-";
        $tTWIShipAddV1PvnCode    = "-";
        $tTWIShipAddV1PostCode   = "-";
    }
} else {
    $tTWIRoute              = "dcmTWIEventAdd";
    $tTWICompCode           = $tCmpCode;
    $nTWIAutStaEdit         = 0;
    $tTWIStaApv             = "";
    $tTWIStaDoc             = "";
    $tTWIStaPrcStk          = "";
    $nTWIStaDocAct          = "99";
    $tTWIStaDelMQ           = "";
    $tTWIBchCode            = $this->session->userdata('tSesUsrBchCodeDefault');
    $tTWIBchName            = $this->session->userdata('tSesUsrBchNameDefault');
    $tTWIDptCode            = $tDptCode;
    $tTWIUsrCode            = $this->session->userdata('tSesUsername');
    $tTWIDocNo              = "";
    $dTWIDocDate            = "";
    $dTWIDocTime            = date('H:i');
    $tTWICreateBy           = $this->session->userdata('tSesUsrUsername');
    $tTWIUsrNameCreateBy    = $this->session->userdata('tSesUsrUsername');
    $tTWIApvCode            = "";
    $tTWIUsrNameApv         = "";
    $tTWIDocType            = "";
    $tTWIRsnType            = "";
    $tTWIVATInOrEx          = 1;
    $tTWIMerCode            = "";
    $tTWIShopFrm            = "";
    $tTWIShopTo             = "";
    $tTWIShopName           = "";
    $tTWIShopNameTo         = "";
    $tTWIWhFrm              = "";
    $tTWIWhTo               = "";
    $tTWIWhName             = "";
    $tTWIWhNameTo           = "";
    $tTWIPosFrm             = "";
    $tTWIPosTo              = "";
    $tTWIPosNameFrm         = "";
    $tTWIPosNameTo          = "";
    $tTWISplCode            = "";
    $tTWISplName            = "";
    $tTWIOther              = "";
    $tTWIRefExt             = "";
    $tTWIRefExtDate         = "";
    $tTWIRefInt             = "";
    $tTWIRefIntDate         = "";
    $tTWIDocPrint           = "";
    $tTWIRmk                = "";
    $tTWIRsnCode            = "";
    $tTWIRsnName            = "";
    $tTWIUserBchCode        = $this->session->userdata('tSesUsrBchCodeDefault');
    $tTWIUserBchName        = $this->session->userdata('tSesUsrBchNameDefault');

    $tTWIBchCompCode         = $this->session->userdata('tSesUsrBchCodeDefault');
    $tTWIBchCompName         = $this->session->userdata('tSesUsrBchNameDefault');

    $tTWIthCtrName            = "";
    $dTWIXthTnfDate           = "";
    $tTWIXthRefTnfID          = "";
    $tTWIXthRefVehID          = "";
    $tTWIXthQtyAndTypeUnit    = "";
    $nTWIXthShipAdd           = "";
    $tTWIViaCode              = "";

    // ที่อยู่สำหรับการจัดส่ง
    $tTWISplShipAdd          = "";
    $tTWIShipAddAddV1No      = "-";
    $tTWIShipAddV1Soi        = "-";
    $tTWIShipAddV1Village    = "-";
    $tTWIShipAddV1Road       = "-";
    $tTWIShipAddV1SubDist    = "-";
    $tTWIShipAddV1DstCode    = "-";
    $tTWIShipAddV1PvnCode    = "-";
    $tTWIShipAddV1PostCode   = "-";
}
?>
<form id="ofmTransferreceiptFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button style="display:none" type="submit" id="obtSubmitTransferreceipt" onclick="JSxTransferreceiptEventAddEdit('<?= $tTWIRoute ?>')"></button>

    <input type="hidden" id="ohdTWICompCode" name="ohdTWICompCode" value="<?= $tTWICompCode; ?>">
    <input type="hidden" id="ohdBaseUrl" name="ohdBaseUrl" value="<?= base_url(); ?>">
    <input type="hidden" id="ohdTWIRoute" name="ohdTWIRoute" value="<?= $tTWIRoute; ?>">
    <input type="hidden" id="ohdTWICheckClearValidate" name="ohdTWICheckClearValidate" value="0">
    <input type="hidden" id="ohdTWICheckSubmitByButton" name="ohdTWICheckSubmitByButton" value="0">
    <input type="hidden" id="ohdTWIAutStaEdit" name="ohdTWIAutStaEdit" value="<?= $nTWIAutStaEdit; ?>">
    <input type="hidden" id="ohdTWIStaApv" name="ohdTWIStaApv" value="<?= $tTWIStaApv; ?>">
    <input type="hidden" id="ohdTWIStaDoc" name="ohdTWIStaDoc" value="<?= $tTWIStaDoc; ?>">
    <input type="hidden" id="ohdTWIStaPrcStk" name="ohdTWIStaPrcStk" value="<?= $tTWIStaPrcStk; ?>">
    <input type="hidden" id="ohdTWIStaDelMQ" name="ohdTWIStaDelMQ" value="<?= $tTWIStaDelMQ; ?>">
    <input type="hidden" id="ohdTWISesUsrBchCode" name="ohdTWISesUsrBchCode" value="<?= $this->session->userdata('tSesUsrBchCodeDefault'); ?>">
    <input type="hidden" id="ohdTWIBchCode" name="ohdTWIBchCode" value="<?= $tTWIBchCode; ?>">
    <input type="hidden" id="ohdTWIDptCode" name="ohdTWIDptCode" value="<?= $tTWIDptCode; ?>">
    <input type="hidden" id="ohdTWIUsrCode" name="ohdTWIUsrCode" value="<?= $tTWIUsrCode; ?>">
    <input type="hidden" id="ohdTWIApvCodeUsrLogin" name="ohdTWIApvCodeUsrLogin" value="<?= $tTWIUsrCode; ?>">
    <input type="hidden" id="ohdTWILangEdit" name="ohdTWILangEdit" value="<?= $this->session->userdata("tLangEdit"); ?>">
    <input type="hidden" id="ohdTWIFrmSplInfoVatInOrEx" name="ohdTWIFrmSplInfoVatInOrEx" value="<?= $tTWIVATInOrEx ?>">

    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIDocument'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTWIDataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataStatusInfo" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="xCNTitleFrom "><?php echo language('document/transferreceiptNew/transferreceiptNew', 'tTWIApproved'); ?></label>
                                </div>
                                <input type="hidden" value="0" id="ohdCheckTWISubmitByButton" name="ohdCheckTWISubmitByButton">
                                <input type="hidden" value="0" id="ohdCheckTWIClearValidate" name="ohdCheckTWIClearValidate">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/transferreceiptNew/transferreceiptNew', 'tTWIDocNo'); ?></label>
                                <?php if (empty($tTWIDocNo)) : ?>
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbTWIStaAutoGenCode" name="ocbTWIStaAutoGenCode" maxlength="1" checked="true" value="1">
                                            <span><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTWIAutoGenCode'); ?></span>
                                        </label>
                                    </div>
                                <?php endif; ?>

                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input type="text" class="form-control xWTooltipsBT xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetTWIDocNo" name="oetTWIDocNo" maxlength="20" value="<?= $tTWIDocNo; ?>" data-validate-required="<?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIPlsEnterOrRunDocNo'); ?>" data-validate-duplicate="<?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIPlsDocNoDuplicate'); ?>" placeholder="<?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIDocNo'); ?>" style="pointer-events:none" readonly>
                                    <input type="hidden" id="ohdTWICheckDuplicateCode" name="ohdTWICheckDuplicateCode" value="2">
                                </div>

                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIDocDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTWIDocDate" name="oetTWIDocDate" value="<?= $dTWIDocDate; ?>" data-validate-required="<?= language('document/transferreceiptNew/transferreceiptNew', 'tASTPlsEnterDocDate'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtTWIDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIDocTime'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNTimePicker" id="oetTWIDocTime" name="oetTWIDocTime" value="<?= $dTWIDocTime; ?>" data-validate-required="<?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIPlsEnterDocTime'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtTWIDocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWICreateBy'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdTWICreateBy" name="ohdTWICreateBy" value="<?= $tTWICreateBy ?>">
                                            <label><?= $tTWIUsrNameCreateBy ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWITBStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIStaDoc' . $tTWIStaDoc); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIStaApv' . $tTWIStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะประมวลผลเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIStaPrcStk'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIStaPrcStk' . $tTWIStaPrcStk); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- ผู้อนุมัติเอกสาร -->
                                <?php if (isset($tTWIDocNo) && !empty($tTWIDocNo)) : ?>
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdTWIApvCode" name="ohdTWIApvCode" maxlength="20" value="<?= $tTWIApvCode ?>">
                                                <label>
                                                    <?php 
                                                        if($tTWIStaApv == 1 || $tTWIStaApv == 3){
                                                            echo (isset($tTWIUsrNameApv) && !empty($tTWIUsrNameApv)) ? $tTWIUsrNameApv : "-";
                                                        }else{
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
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIConditionDoc'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTWIDataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataConditionDoc" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">

                            <!--สาขา-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                <!--เลือกสาขา-->

                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch'); ?></label>
                                    <div class="input-group">
                                        <input name="oetTWIFrmBchName" id="oetTWIFrmBchName" class="form-control" value="<?= $tTWIBchCompName ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch') ?>">
                                        <input name="oetSOFrmBchCode" id="oetSOFrmBchCode" value="<?= $tTWIBchCompCode ?>" class="form-control xCNHide xCNClearValue" type="text">
                                        <span class="input-group-btn">
                                            <?php if ($tTWIRoute == "dcmTWIEventEdit") {
                                                $tDis = 'disabled';
                                            } else {
                                                $tDis = '';
                                            } ?>
                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTWOBCH" type="button" <?= $tDis ?>>
                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>


                                <script>
                                    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit"); ?>';
                                    var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
                                    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
                                    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
                                    var tWhere = "";

                                    if (nCountBch == 1) {
                                        $('#obtBrowseTWOBCH').attr('disabled', true);
                                    }
                                    if (tUsrLevel != "HQ") {
                                        tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";
                                    } else {
                                        tWhere = "";
                                    }

                                    var oBrowse_BCH = {
                                        Title: ['company/branch/branch', 'tBCHTitle'],
                                        Table: {
                                            Master: 'TCNMBranch',
                                            PK: 'FTBchCode',
                                            PKName: 'FTBchName'
                                        },
                                        Join: {
                                            Table: ['TCNMBranch_L', 'TCNMWaHouse_L'],
                                            On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID =' + nLangEdits,
                                                'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID =' + nLangEdits,
                                            ]
                                        },
                                        Where: {
                                            Condition: [tWhere]
                                        },
                                        GrideView: {
                                            ColumnPathLang: 'company/branch/branch',
                                            ColumnKeyLang: ['tBCHCode', 'tBCHName', ''],
                                            ColumnsSize: ['15%', '75%', ''],
                                            WidthModal: 50,
                                            DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName', 'TCNMWaHouse_L.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                                            DataColumnsFormat: ['', ''],
                                            DisabledColumns: [2, 3],
                                            Perpage: 10,
                                            OrderBy: ['TCNMBranch.FDCreateOn DESC'],
                                            // SourceOrder		: "ASC"
                                        },
                                        CallBack: {
                                            ReturnType: 'S',
                                            Value: ["oetSOFrmBchCode", "TCNMBranch.FTBchCode"],
                                            Text: ["oetTWIFrmBchName", "TCNMBranch_L.FTBchName"],
                                        },
                                        NextFunc: {
                                            FuncName: 'JSxSetDefauleWahouse',
                                            ArgReturn: ['FTWahCode', 'FTWahName']
                                        }
                                    }
                                    $('#obtBrowseTWOBCH').click(function() {
                                        JCNxBrowseData('oBrowse_BCH');
                                    });

                                    function JSxSetDefauleWahouse(ptData) {
                                        if (ptData == '' || ptData == 'NULL') {
                                            $('#oetTROutWahToName').val('');
                                            $('#oetTROutWahToCode').val('');
                                        } else {
                                            var tResult = JSON.parse(ptData);
                                            $('#oetTROutWahToName').val(tResult[1]);
                                            $('#oetTROutWahToCode').val(tResult[0]);
                                        }
                                    }

                                    var tSesWahCode = '<?php echo $this->session->userdata("tSesUsrWahCode"); ?>';
                                    var tSesWahName = '<?php echo $this->session->userdata("tSesUsrWahName"); ?>';
                                    // $('#oetTROutWahToName').val(tSesWahName);
                                    // $('#oetTROutWahToCode').val(tSesWahCode);
                                </script>
                            </div>

                            <!--เงื่อนไขของประเภท รับโอน-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="odvTRNOut" class="row" style="display:none;">
                                    <!-- <div class="col-lg-12">
                                        <label class="xCNLabelFrm"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIOrigin'); ?> : </label>
                                        <label><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIWahhouse'); ?></label>
                                    </div> -->

                                    <div class="col-lg-12">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIOrigin'); ?></legend>
                                            <!--เลือกร้านค้า - ต้นทาง-->
                                            <div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
                                                <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tShop'); ?></label>
                                                <div class="input-group">
                                                    <?php if ($this->session->userdata("tSesUsrLevel") == 'SHP') {
                                                        $tTWIShopName   = $this->session->userdata("tSesUsrShpName");
                                                        $tTWIShopFrm    = $this->session->userdata("tSesUsrShpCode");
                                                    } ?>
                                                    <script>
                                                        if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'SHP') {
                                                            $('#obtBrowseTROutFromShp').attr('disabled', true);
                                                            $('#obtBrowseTROutFromPos').attr('disabled', false);
                                                        }
                                                    </script>

                                                    <input name="oetTROutShpFromName" id="oetTROutShpFromName" class="form-control xCNClearValue" value="<?= $tTWIShopName ?>" type="text" readonly="" placeholder="<?= language('document/topupVending/topupVending', 'tShop') ?>">
                                                    <input name="oetTROutShpFromCode" id="oetTROutShpFromCode" class="form-control xCNHide xCNClearValue" type="text" value="<?= $tTWIShopFrm ?>">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTROutFromShp" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <!--เลือกจุดขาย - ต้นทาง-->
                                            <div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
                                                <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tPos'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTROutPosFromName" id="oetTROutPosFromName" class="form-control xCNClearValue" value="<?= $tTWIPosNameFrm ?>" type="text" readonly="" placeholder="<?= language('document/topupVending/topupVending', 'tPos') ?>">
                                                    <input name="oetTROutPosFromCode" id="oetTROutPosFromCode" value="<?= $tTWIPosFrm ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTROutFromPos" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <!--อ้างอิงเอกสารใบจ่ายโอน-->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBrowsDocTBO') ?></label>
                                                <div class="input-group">
                                                    <input name="oetTWIRefIntDocNo" id="oetTWIRefIntDocNo" class="form-control xCNClearValue" value="<?= $tTWIRefInt; ?>" type="text" readonly="" data-validate="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIPlsEnterRefIntFrom') ?>" placeholder="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBrowsDocTBO') ?>">
                                                    <input name="oetTWIRefIntDocCode" id="oetTWIRefIntDocCode" value="<?= $tTWIWhFrm ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="oetTWIDocReferBrows" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <!--คลังสินค้า - ต้นทาง-->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIWahhouse'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTROutWahFromName" id="oetTROutWahFromName" class="form-control xCNClearValue" value="<?= $tTWIWhName ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIWahhouse') ?>">
                                                    <input name="oetTROutWahFromCode" id="oetTROutWahFromCode" value="<?= $tTWIWhFrm ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTROutFromWah" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <!--นำสินค้าเข้า-->
                                            <div class="row">
                                                <div class="col-md-6 pull-right">
                                                    <button type="button" id="obtImportPDTInCN" class="btn btn-primary xCNApvOrCanCelDisabled" style="width:100%; font-size: 17px; margin-top: 10px;"><?= language('document/transferreceiptNew/transferreceiptNew', 'tImportPDT') ?></button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-lg-12">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWITo'); ?></legend>

                                            <!--เลือกร้านค้า - ปลายทาง-->
                                            <div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
                                                <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tShop'); ?></label>
                                                <div class="input-group">

                                                    <?php if ($this->session->userdata("tSesUsrLevel") == 'SHP') {
                                                        $tTWIShopNameTo     = $this->session->userdata("tSesUsrShpName");
                                                        $tTWIShopTo         = $this->session->userdata("tSesUsrShpCode");
                                                    } ?>
                                                    <script>
                                                        if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'SHP') {
                                                            $('#obtBrowseTROutToShp').attr('disabled', true);
                                                        }
                                                    </script>

                                                    <input name="oetTROutShpToName" id="oetTROutShpToName" class="form-control xCNClearValue" value="<?= $tTWIShopNameTo ?>" type="text" readonly="" placeholder="<?= language('document/topupVending/topupVending', 'tShop') ?>">
                                                    <input name="oetTROutShpToCode" id="oetTROutShpToCode" value="<?= $tTWIShopTo ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTROutToShp" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <!--เลือกจุดขาย - ปลายทาง-->
                                            <div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
                                                <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tPos'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTROutPosToName" id="oetTROutPosToName" class="form-control xCNClearValue" value="<?= $tTWIPosNameTo ?>" type="text" readonly="" placeholder="<?= language('document/topupVending/topupVending', 'tPos') ?>">
                                                    <input name="oetTROutPosToCode" id="oetTROutPosToCode" value="<?= $tTWIPosTo ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTROutToPos" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <!--คลังสินค้า - ปลายทาง-->

                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIWahhouse'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTROutWahToName" id="oetTROutWahToName" class="form-control xCNClearValue" value="<?= $tTWIWhNameTo ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIWahhouse') ?>">
                                                    <input name="oetTROutWahToCode" id="oetTROutWahToCode" value="<?= $tTWIWhTo ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTROutToWah" type="button">
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
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIPanelRef'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTWIDataConditionREF" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataConditionREF" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <!-- อ้างอิงเลขที่เอกสารภายใน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/saleorder/saleorder', 'tSOLabelFrmRefIntDoc'); ?></label>
                            <input type="text" class="form-control xCNApvOrCanCelDisabled" id="oetTWIRefIntDoc" name="oetTWIRefIntDoc" maxlength="20" value="<?= $tTWIRefInt ?>">
                        </div>
                        <!-- วันที่อ้างอิงเลขที่เอกสารภายใน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmRefIntDocDate'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTWIRefIntDocDate" name="oetTWIRefIntDocDate" placeholder="YYYY-MM-DD" value="<?= $tTWIRefIntDate ?>">
                                <span class="input-group-btn">
                                    <button id="obtTWIBrowseRefIntDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                        <!-- อ้างอิงเลขที่เอกสารภายนอก -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/saleorder/saleorder', 'tSOLabelFrmRefExtDoc'); ?></label>
                            <input type="text" class="form-control xCNApvOrCanCelDisabled" id="oetTWIRefExtDoc" name="oetTWIRefExtDoc" value="<?= $tTWIRefExt ?>">
                        </div>
                        <!-- วันที่เอกสารภายนอก -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/saleorder/saleorder', 'tSOLabelFrmRefExtDocDate'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTWIRefExtDocDate" name="oetTWIRefExtDocDate" placeholder="YYYY-MM-DD" value="<?= $tTWIRefExtDate ?>">
                                <span class="input-group-btn">
                                    <button id="obtTWIBrowseRefExtDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel การขนส่ง -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWIPanelTransport'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTWIDataConditionTransport" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataConditionTransport" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWCtrName'); ?></label>
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWITransportCtrName" name="oetTWITransportCtrName" value="<?= $tTWIthCtrName ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWTnfDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTWITransportTnfDate" name="oetTWITransportTnfDate" placeholder="YYYY-MM-DD" value="<?= $dTWIXthTnfDate ?>">
                                        <span class="input-group-btn">
                                            <button id="obtTWITnfDate" type="button" class="btn xCNBtnDateTime">
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
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWITransportRefTnfID" name="oetTWITransportRefTnfID" value="<?= $tTWIXthRefTnfID ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWRefVehID'); ?></label>
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWITransportRefVehID" name="oetTWITransportRefVehID" value="<?= $tTWIXthRefVehID ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWQtyAndTypeUnit'); ?></label>
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWITransportQtyAndTypeUnit" name="oetTWITransportQtyAndTypeUnit" value="<?= $tTWIXthQtyAndTypeUnit ?>">
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/transferwarehouseout/transferwarehouseout', 'tTWITransportNumber'); ?></label>
                                    <input type="text" class="form-control xCNInputWOthoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWTransportNumber" name="oetTWIRefTransportNumber" value="<?= $tTWIViaCode ?>">
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tViaCode'); ?></label>
                                    <div class="input-group">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetTWIUpVendingViaName" name="oetTWIUpVendingViaName" value="<?php echo $tTWIViaCode ?>" readonly>
                                        <input type="text" class="input100 xCNHide xCNApvOrCanCelDisabled" id="oetTWIUpVendingViaCode" name="oetTWIUpVendingViaCode" value="<?php echo $tTWIViaCode ?>">
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
                                <input type="hidden" id="ohdTWIFrmShipAdd" name="ohdTWIFrmShipAdd" value="<?= $nTWIXthShipAdd ?>">
                                <button type="button" id="obtTWIFrmBrowseShipAdd" class="btn btn-primary" style="width:100%;">
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
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIPanelETC'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTWIDataConditionETC" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataConditionETC" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <!--เลือกเหตุผล-->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIReason'); ?></label>
                            <div class="input-group">
                                <input name="oetTWIReasonName" id="oetTWIReasonName" class="form-control" value="<?= $tTWIRsnName ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptNew/transferreceiptNew', 'tTWIReason') ?>">
                                <input name="oetTWIReasonCode" id="oetTWIReasonCode" value="<?= $tTWIRsnCode ?>" class="form-control xCNHide" type="text">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTWIReason" type="button">
                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <!-- หมายเหตุ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmInfoOthRemark'); ?></label>
                            <textarea class="form-control xCNApvOrCanCelDisabled" id="otaTWIFrmInfoOthRmk" name="otaTWIFrmInfoOthRmk" rows="10" maxlength="200" style="resize: none;height:86px;"><?= $tTWIRmk; ?></textarea>

                        </div>

                        <!-- จำนวนครั้งที่พิมพ์ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmInfoOthDocPrint'); ?></label>
                            <input type="text" class="form-control text-right" id="ocmTWIFrmInfoOthDocPrint" name="ocmTWIFrmInfoOthDocPrint" value="<?= $tTWIDocPrint; ?>" readonly>
                        </div>

                        <!-- สถานะเคลื่อนไหว-->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <!-- <input type="checkbox" id="ocbTWIStaDocAct" name="ocbTWIStaDocAct" maxlength="1" value="1" <?php echo $nTWIStaDocAct == '' ? 'checked' : ($nTWIStaDocAct == '1' ? 'checked' : '0'); ?>> -->
                                <input type="checkbox" value="1" id="ocbTWIStaDocAct" name="ocbTWIStaDocAct" maxlength="1" <?php if ($nTWIStaDocAct == 1 && $nTWIStaDocAct != 0) {
                                                                                                                                echo 'checked';
                                                                                                                            } else if ($nTWIStaDocAct == 99) {
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

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <div class="row">
                <!-- ตารางสินค้า -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:200px;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">
                                <div style="margin-top: 10px;">
                                    <!--ค้นหา-->
                                    <div class="row p-t-10">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" maxlength="100" id="oetTWIFrmFilterPdtHTML" name="oetTWIFrmFilterPdtHTML" placeholder="<?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIFrmFilterTablePdt'); ?>" onkeyup="javascript:if(event.keyCode==13) JSvTWIDOCFilterPdtInTableTemp()">
                                                    <input type="text" class="form-control" maxlength="100" id="oetTWIFrmSearchAndAddPdtHTML" name="oetTWIFrmSearchAndAddPdtHTML" onkeyup="Javascript:if(event.keyCode==13) JSxTWIChkConditionSearchAndAddPdt()" placeholder="<?= language('document/purchaseinvoice/purchaseinvoice', 'tPIFrmSearchAndAddPdt'); ?>" style="display:none;">
                                                    <span class="input-group-btn">
                                                        <div id="odvTWISearchAndScanBtnGrp" class="xCNDropDrownGroup input-group-append">
                                                            <button id="obtTWIMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvTWIDOCFilterPdtInTableTemp()">
                                                                <i class="fa fa-search" style="width:20px;"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu">
                                                                <li>
                                                                    <a id="oliTWIMngPdtSearch"><label><?= language('document/purchaseinvoice/purchaseinvoice', 'tPIFrmFilterTablePdt'); ?></label></a>
                                                                    <a id="oliTWIMngPdtScan"><?= language('document/purchaseinvoice/purchaseinvoice', 'tPIFrmSearchAndAddPdt'); ?></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 text-right">
                                            <div id="odvTWIMngAdvTableList" class="btn-group xCNDropDrownGroup">
                                                <button id="obtTWIAdvTablePdtDTTemp" type="button" class="btn xCNBTNMngTable m-r-20"><?= language('common/main/main', 'tModalAdvTable') ?></button>
                                            </div>
                                            <div id="odvTWIMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
                                                <button type="button" class="btn xCNBTNMngTable xWDropdown" data-toggle="dropdown">
                                                    <?= language('common/main/main', 'tCMNOption') ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li id="oliTWIBtnDeleteMulti" class="disabled">
                                                        <a data-toggle="modal" data-target="#odvTWIModalDelPdtInDTTempMultiple"><?= language('common/main/main', 'tDelAll') ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                            <div class="form-group">
                                                <div style="position: absolute;right: 15px;top:-5px;">
                                                    <button type="button" id="obtTWIDocBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--ตาราง-->
                                    <div class="row p-t-10" id="odvTWIDataPdtTableDTTemp"></div>
                                    <!-- <?php include('wTransferreceiptNewEndOfBill.php'); ?> -->
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
    <div id="odvTWIBrowseShipAdd" class="modal fade">
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
                                            <a style="font-size:14px!important;color:#179bfd;">
                                                <i class="fa fa-pencil" id="oliPIEditShipAddress">&nbsp;<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipChange'); ?></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body xCNPDModlue">
                                    <input type="hidden" id="ohdTWIShipAddSeqNo" name="ohdTWIShipAddSeqNo" class="form-control">
                                    <?php $tTWIFormatAddressType = FCNaHAddressFormat('TCNMBranch'); //1 ที่อยู่ แบบแยก  ,2  แบบรวม 
                                    ?>
                                    <?php if (!empty($tTWIFormatAddressType) && $tTWIFormatAddressType == '1') : ?>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1No'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWIShipAddAddV1No"><?php echo @$tTWIShipAddAddV1No; ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1Village'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWIShipAddV1Soi"><?php echo @$tTWIShipAddV1Soi; ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1Soi'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWIShipAddV1Village"><?php echo @$tTWIShipAddV1Village; ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1Road'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWIShipAddV1Road"><?php echo @$tTWIShipAddV1Road; ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1SubDist'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWIShipAddV1SubDist"><?php echo @$tTWIShipAddV1SubDist; ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1DstCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWIShipAddV1DstCode"><?php echo @$tTWIShipAddV1DstCode ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1PvnCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWIShipAddV1PvnCode"><?php echo @$tTWIShipAddV1PvnCode ?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV1PostCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTWIShipAddV1PostCode"><?php echo @$tTWIShipAddV1PostCode; ?></label>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV2Desc1') ?></label><br>
                                                    <label id="ospTWIShipAddV2Desc1"><?php echo @$tTWIShipAddV2Desc1; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipADDV2Desc2') ?></label><br>
                                                    <label id="ospTWIShipAddV2Desc2"><?php echo @$tTWIShipAddV2Desc2; ?></label>
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
<div class="modal fade" id="odvTWIOrderAdvTblColumns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <div class="modal-body" id="odvTWIModalBodyAdvTable">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= language('common/main/main', 'tModalAdvClose'); ?></button>
                <button id="obtTWISaveAdvTableColums" type="button" class="btn btn-primary"><?= language('common/main/main', 'tModalAdvSave'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================================================================================================================================= -->

<!-- ================================================================= View Modal Appove Document ================================================================= -->
<div id="odvTWIModalAppoveDoc" class="modal fade xCNModalApprove">
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
                <button id="obtTWIConfirmApprDoc" type="button" class="btn xCNBTNPrimery"><?= language('common/main/main', 'tModalConfirm'); ?></button>
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
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptNew/transferreceiptNew', 'tConditionISEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span id="ospWahIsEmpty"><?= language('document/transferreceiptNew/transferreceiptNew', 'tWahDocumentISEmptyDetail') ?></span>
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
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptNew/transferreceiptNew', 'tConditionISEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span id="ospTypeIsEmpty"><?= language('document/transferreceiptNew/transferreceiptNew', 'tTypeDocumentISEmptyDetail') ?></span>
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
<div id="odvTWIModalDelPdtInDTTempMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type="hidden" id="ohdConfirmTWIDocNoDelete" name="ohdConfirmTWIDocNoDelete">
                <input type="hidden" id="ohdConfirmTWISeqNoDelete" name="ohdConfirmTWISeqNoDelete">
                <input type="hidden" id="ohdConfirmTWIPdtCodeDelete" name="ohdConfirmTWIPdtCodeDelete">
                <input type="hidden" id="ohdConfirmTWIPunCodeDelete" name="ohdConfirmTWIPunCodeDelete">

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
<div class="modal fade" id="odvTWIPopupCancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/document/document', 'tDocDocumentCancel') ?></label>
            </div>
            <div class="modal-body">
                <p id="obpMsgApv"><strong><?= language('common/main/main', 'tDocCancelAlert2') ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxTRNTransferReceiptDocCancel(true)" type="button" class="btn xCNBTNPrimery">
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
<div id="odvTWIModalPDTCN" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptNew/transferreceiptNew', 'tImportPDT') ?></label>
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
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptNew/transferreceiptNew', 'tConditionPDTEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span><?= language('document/transferreceiptNew/transferreceiptNew', 'tConditionPDTEmptyDetail') ?></span>
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


<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include('script/jTransferReceiptAdd.php'); ?>