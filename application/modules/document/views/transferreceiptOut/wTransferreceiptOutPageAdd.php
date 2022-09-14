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
$tAgnCode               = $this->session->userdata("tSesUsrAgnCode");
$tSesUsrLevel = $this->session->userdata('tSesUsrLevel');
if (isset($aDataDocHD) && $aDataDocHD['rtCode'] == "1") {
    $tTWIRoute = "dcmTXOOutEventEdit";
    $tTWICompCode = $tCmpCode;
    $nTWIAutStaEdit = 1;
    $tTWIStaApv = $aDataDocHD['raItems']['FTXthStaApv'];
    $tTWIStaDoc = $aDataDocHD['raItems']['FTXthStaDoc'];
    $tTWIStaPrcStk = $aDataDocHD['raItems']['FTXthStaPrcStk'];
    $nTWIStaDocAct = $aDataDocHD['raItems']['FNXthStaDocAct'];
    $tTWIStaDelMQ = $aDataDocHD['raItems']['FTXthStaDelMQ'];
    $tTWIBchCode = $aDataDocHD['raItems']['FTBchCode'];
    $tTWIBchName = $aDataDocHD['raItems']['FTBchName'];
    $tTWIDptCode = $aDataDocHD['raItems']['FTDptCode'];
    $tTWIUsrCode = $aDataDocHD['raItems']['FTXthApvCode'];
    $tTWIDocNo = $aDataDocHD['raItems']['FTXthDocNo'];
    $dTWIDocDate = date("Y-m-d", strtotime($aDataDocHD['raItems']['FDXthDocDate']));
    $dTWIDocTime = date("H:i:s", strtotime($aDataDocHD['raItems']['FDXthDocDate']));
    $tTWICreateBy = $aDataDocHD['raItems']['FTCreateBy'];
    $tTWIUsrNameCreateBy = $aDataDocHD['raItems']['FTUsrName'];
    $tTWIUsrNameApv = $aDataDocHD['raItems']['FTUsrName'];
    $tTWIApvCode = $aDataDocHD['raItems']['FTXthApvCode'];
    $tTWIDocType = $aDataDocHD['raItems']['FNXthDocType'];
    $tTWIRsnType = $aDataDocHD['raItems']['FTXthRsnType'];
    $tTWIVATInOrEx = $aDataDocHD['raItems']['FTXthVATInOrEx'];
    $tTWIMerCode = $aDataDocHD['raItems']['FTXthMerCode'];
    $tTWIShopFrm = $aDataDocHD['raItems']['FTXthShopFrm'];
    $tTWIShopCodeTo = $aDataDocHD['raItems']['FTXthShopTo'];
    $tTWIShopName = $aDataDocHD['raItems']['FTShpName'];
    $tTWIShopNameTo = $aDataDocHD['raItems']['ShpNameTo'];
    $tTWIWhFrm = $aDataDocHD['raItems']['FTXthWhFrm'];
    $tTWIWhTo = $aDataDocHD['raItems']['FTXthWhTo'];
    $tTWIWhName = $aDataDocHD['raItems']['FTWahName'];
    $tTWIWhNameTo = $aDataDocHD['raItems']['WahNameTo'];
    $tTWIPosFrm = $aDataDocHD['raItems']['FTXthPosFrm'];
    $tTWIPosTo = $aDataDocHD['raItems']['FTXthPosTo'];
    $tTWISplCode = $aDataDocHD['raItems']['FTSplCode'];
    $tTWISplName = $aDataDocHD['raItems']['FTSplName'];
    $tTWICusCode = $aDataDocHD['raItems']['FTCstCode'];
    $tTWICusName = $aDataDocHD['raItems']['FTCstName'];
    $tTWIOther = $aDataDocHD['raItems']['FTXthOther'];
    //$tTWIRefExt = $aDataDocHD['raItems']['FTXthRefExt'];
    //$tTWIRefExtDate = $aDataDocHD['raItems']['FDXthRefExtDate'];
    //$tTWIRefInt = $aDataDocHD['raItems']['FTXthRefInt'];
    //$tTWIRefIntDate = $aDataDocHD['raItems']['FDXthRefIntDate'];
    $tTWIDocPrint = $aDataDocHD['raItems']['FNXthDocPrint'];
    $tTWIRmk = $aDataDocHD['raItems']['FTXthRmk'];
    $tTWIRsnCode = $aDataDocHD['raItems']['FTRsnCode'];
    $tTWIRsnName = $aDataDocHD['raItems']['FTRsnName'];
    $nStaUploadFile         = 2;

    $tTWIBchCompCode = $aDataDocHD['raItems']['FTBchCode'];
    $tTWIBchCompName = $aDataDocHD['raItems']['FTBchName'];
    $tTWIUserBchName = $aDataDocHD['raItems']['FTBchName'];
} else {
    $tTWIRoute = "dcmTXOOutEventAdd";
    $tTWICompCode = $tCmpCode;
    $nTWIAutStaEdit = 0;
    $tTWIStaApv = "";
    $tTWIStaDoc = "";
    $tTWIStaPrcStk = "";
    $nTWIStaDocAct = "99";
    $tTWIStaDelMQ = "";
    $tTWIBchCode = $tBchCompCode;
    $tTWIBchName = $tBchName;
    $tTWIDptCode = $tDptCode;
    $tTWIUsrCode = $this->session->userdata('tSesUsername');
    $tTWIDocNo = "";
    $dTWIDocDate = "";
    $dTWIDocTime = date('H:i');
    $tTWICreateBy = $this->session->userdata('tSesUsrUsername');
    $tTWIUsrNameCreateBy = $this->session->userdata('tSesUsrUsername');
    $tTWIApvCode = "";
    $tTWIUsrNameApv = "";
    $tTWIDocType = "";
    $tTWIRsnType = "";
    $tTWIVATInOrEx = 1;
    $tTWIMerCode = "";
    $tTWIShopFrm = "";
    $tTWIShopCodeTo = "";
    $tTWIShopName = "";
    $tTWIShopNameTo = "";
    $tTWIWhFrm = "";
    $tTWIWhTo = "";
    $tTWIWhName = "";
    $tTWIWhNameTo = "";
    $tTWIPosFrm = "";
    $tTWIPosTo = "";
    $tTWISplCode = "";
    $tTWISplName = "";
    $tTWICusCode = "";
    $tTWICusName = "";
    $tTWIOther = "";
    $tTWIRefExt = "";
    $tTWIRefExtDate = "";
    $tTWIRefInt = "";
    $tTWIRefIntDate = "";
    $tTWIDocPrint = "";
    $tTWIRmk = "";
    $tTWIRsnCode = "";
    $tTWIRsnName = "";
    $tTWIUserBchCode = $tBchCode;
    $tTWIUserBchName = $tBchName;
    $nStaUploadFile         = 1;
    $tTWIBchCompCode = $this->session->userdata('tSesUsrBchCodeDefault');
    $tTWIBchCompName = $this->session->userdata('tSesUsrBchNameDefault');
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
    <input type="hidden" id="ohdTWISesUsrBchCode" name="ohdTWISesUsrBchCode" value="<?= $this->session->userdata("tSesUsrBchCode"); ?>">
    <input type="hidden" id="ohdTWIBchCode" name="ohdTWIBchCode" value="<?= $tTWIBchCode; ?>">
    <input type="hidden" id="ohdTWIDptCode" name="ohdTWIDptCode" value="<?= $tTWIDptCode; ?>">
    <input type="hidden" id="ohdTWIUsrCode" name="ohdTWIUsrCode" value="<?= $tTWIUsrCode; ?>">
    <input type="hidden" id="ohdTWIApvCodeUsrLogin" name="ohdTWIApvCodeUsrLogin" value="<?= $tTWIUsrCode; ?>">
    <input type="hidden" id="ohdTWILangEdit" name="ohdTWILangEdit" value="<?= $this->session->userdata("tLangEdit"); ?>">
    <input type="hidden" id="ohdTWIFrmSplInfoVatInOrEx" name="ohdTWIFrmSplInfoVatInOrEx" value="<?= $tTWIVATInOrEx ?>">
    <input type="hidden" id="ohdTWISesUsrLogin" name="ohdTWISesUsrLogin" value="<?=$this->session->userdata('tSesUsername');?>">



    <div class="row">
        <div class="col-md-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIDocument'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTWIDataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataStatusInfo" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="xCNTitleFrom "><?php echo language('document/transferreceiptOut/transferreceiptOut', 'tTWIApproved'); ?></label>
                                </div>
                                <input type="hidden" value="0" id="ohdCheckTWISubmitByButton" name="ohdCheckTWISubmitByButton">
                                <input type="hidden" value="0" id="ohdCheckTWIClearValidate" name="ohdCheckTWIClearValidate">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/transferreceiptOut/transferreceiptOut', 'tTWIDocNo'); ?></label>
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
                                    <input type="text" class="form-control xWTooltipsBT xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetTWIDocNo" name="oetTWIDocNo" maxlength="20" value="<?= $tTWIDocNo; ?>" data-validate-required="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIPlsEnterOrRunDocNo'); ?>" data-validate-duplicate="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIPlsDocNoDuplicate'); ?>" placeholder="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIDocNo'); ?>" style="pointer-events:none" readonly>
                                    <input type="hidden" id="ohdTWICheckDuplicateCode" name="ohdTWICheckDuplicateCode" value="2">
                                </div>

                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIDocDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTWIDocDate" name="oetTWIDocDate" value="<?= $dTWIDocDate; ?>" data-validate-required="<?= language('document/transferreceiptOut/transferreceiptOut', 'tASTPlsEnterDocDate'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtTWIDocDate" type="button" class="btn xCNBtnDateTime xCNControllDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIDocTime'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNTimePicker" id="oetTWIDocTime" name="oetTWIDocTime" value="<?= $dTWIDocTime; ?>" data-validate-required="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIPlsEnterDocTime'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtTWIDocTime" type="button" class="btn xCNBtnDateTime xCNControllDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWICreateBy'); ?></label>
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
                                            <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITBStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIStaDoc' . $tTWIStaDoc); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    if ($tTWIStaDoc == 3) {
                                        $tNewProcess =  language('document/adjustmentcost/adjustmentcost', 'tADCStaDoc3'); //ยกเลิก
                                        $tClassStaDoc = 'text-danger';
                                    } else {
                                        if ($tTWIStaApv == 1) {
                                            $tNewProcess =  language('document/adjustmentcost/adjustmentcost', 'tADCStaApv1'); //อนุมัติแล้ว
                                            $tClassStaDoc = 'text-success';
                                        } else {
                                            $tNewProcess = language('document/adjustmentcost/adjustmentcost', 'tADCStaApv'); //รออนุมัติ
                                            $tClassStaDoc = 'text-warning';
                                        }
                                    }

                                    if ($tTWIStaPrcStk == 1) {
                                        $tClassPrcStk = 'text-success';
                                    } else if ($tTWIStaPrcStk == 2) {
                                        $tClassPrcStk = 'text-warning';
                                    } else if ($tTWIStaPrcStk == '') {
                                        $tClassPrcStk = 'text-warning';
                                    } else {
                                        $tClassPrcStk = "";
                                    }
                                ?>

                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/document/document', 'tDocStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right <?= $tClassStaDoc ?>">
                                            <label><?= $tNewProcess; ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะประมวลผลเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIStaPrcStk'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right <?=$tClassPrcStk?>">
                                            <label><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIStaPrcStk' . $tTWIStaPrcStk); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- ผู้อนุมัติเอกสาร -->
                                <?php if (isset($tTWIDocNo) && !empty($tTWIDocNo)) : ?>
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIApvBy'); ?></label>
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
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIConditionDoc'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTWIDataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataConditionDoc" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">

                            <!--สาขา-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php if ($tSesUsrLevel != "HQ") { ?>
                                    <?php $tTWIDataInputBchCode    = $tTWIBchCompCode; ?>
                                    <!-- <?php $tTWIDataInputBchName    =  $tTWIBchCompName; ?>
                                    <input class="form-control xCNHide" id="oetSOFrmBchCode" name="oetSOFrmBchCode" maxlength="5" value="<?= $tTWIDataInputBchCode; ?>">
                                    <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch'); ?></label>
                                    <label>&nbsp;: <?= $tTWIDataInputBchName; ?></label> -->

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch'); ?></label>
                                        <div class="input-group">
                                            <input name="oetTWOFrmBchName" id="oetTWOFrmBchName" class="form-control" value="<?= $tTWIDataInputBchName ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch') ?>">
                                            <input name="oetSOFrmBchCode" id="oetSOFrmBchCode" value="<?= $tTWIDataInputBchCode ?>" class="form-control xCNHide xCNClearValue" type="text">
                                            <span class="input-group-btn">
                                                <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTWOBCH" type="button">
                                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                <?php } else { ?>
                                    <!--เลือกสาขา-->
                                    <?php $tTWIDataInputBchCode    = $tTWIBchCompCode; ?>
                                    <?php $tTWIDataInputBchName    = $tTWIBchCompName; ?>
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch'); ?></label>
                                        <div class="input-group">
                                            <input name="oetTWOFrmBchName" id="oetTWOFrmBchName" class="form-control" value="<?= $tTWIDataInputBchName ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch') ?>">
                                            <input name="oetSOFrmBchCode" id="oetSOFrmBchCode" value="<?= $tTWIDataInputBchCode ?>" class="form-control xCNHide xCNClearValue" type="text">
                                            <span class="input-group-btn">
                                                <?php if ($tTWIRoute == "dcmTXOOutEventEdit") {
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
                                <?php } ?>

                                <script>
                                    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit"); ?>';

                                    var tLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';
                                    var tBchMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
                                    var tWhere = "";
                                    if (tLevel != "HQ") {
                                        tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchMulti + ") ";
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
                                        },
                                        CallBack: {
                                            ReturnType: 'S',
                                            Value: ["oetSOFrmBchCode", "TCNMBranch.FTBchCode"],
                                            Text: ["oetTWOFrmBchName", "TCNMBranch_L.FTBchName"],
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
                                            $('#oetTRINWahNameTo').val('');
                                            $('#oetTRINWahCodeTo').val('');
                                            $('#oetTRINWahEtcName').val('');
                                            $('#oetTRINWahEtcCode').val('');
                                        } else {
                                            var tResult = JSON.parse(ptData);
                                            $('#oetTRINWahNameTo').val(tResult[1]);
                                            $('#oetTRINWahCodeTo').val(tResult[0]);
                                            $('#oetTRINWahEtcName').val(tResult[1]);
                                            $('#oetTRINWahEtcCode').val(tResult[0]);
                                        }
                                    }
                                    <?php if ($aDataDocHD['rtCode'] != "1") { ?>
                                        var tSesWahCode = '<?php echo $this->session->userdata("tSesUsrWahCode"); ?>';
                                        var tSesWahName = '<?php echo $this->session->userdata("tSesUsrWahName"); ?>';
                                        $('#oetTRINWahNameTo').val(tSesWahName);
                                        $('#oetTRINWahCodeTo').val(tSesWahCode);
                                        $('#oetTRINWahEtcName').val(tSesWahName);
                                        $('#oetTRINWahEtcCode').val(tSesWahCode);
                                    <?php } ?>
                                </script>
                            </div>


                            <!--เงื่อนไขของประเภท รับเข้า-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="odvTRNIn" class="row" style="display:none;">

                                    <!--ประเภทของการรับเข้า-->
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIConditionIN'); ?></label>
                                            <select class="selectpicker form-control" id="ocmSelectTransTypeIN" name="ocmSelectTransTypeIN">
                                                <option value='SPL'><?= language('document/transferreceiptOut/transferreceiptOut', 'tINSPL'); ?></option>
                                                <option value='CUS'><?= language('document/transferreceiptOut/transferreceiptOut', 'tINCUS'); ?></option>
                                                <option value='ETC'><?= language('document/transferreceiptOut/transferreceiptOut', 'tINETC'); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <script>
                                        $('#odvINWhereSPL').css('display', 'block');
                                        $('#odvINWhereCUS').css('display', 'none');
                                        $('#odvINWhereETC').css('display', 'none');

                                        $('#ocmSelectTransTypeIN').change(function() {
                                            var tValue = $(this).val();
                                            if (tValue == 'SPL') {
                                                $('#odvINWhereSPL').css('display', 'block');
                                                $('#odvINWhereCUS').css('display', 'none');
                                                $('#odvINWhereETC').css('display', 'none');
                                            }else if (tValue == 'CUS') {
                                                $('#odvINWhereSPL').css('display', 'none');
                                                $('#odvINWhereCUS').css('display', 'block');
                                                $('#odvINWhereETC').css('display', 'none');
                                            }else if (tValue == 'ETC') {
                                                $('#odvINWhereSPL').css('display', 'none');
                                                $('#odvINWhereCUS').css('display', 'none');
                                                $('#odvINWhereETC').css('display', 'block');
                                            }
                                        });
                                    </script>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div id="odvINWhereSPL" style="display:none;">

                                            <!-- เลือกผู้จำหน่าย -->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tTBSpl'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTRINSplName" id="oetTRINSplName" class="form-control xCNClearValue" value="<?= $tTWISplName ?>" type="text" readonly="" placeholder="<?= language('document/topupVending/topupVending', 'tTBSpl') ?>">
                                                    <input name="oetTRINSplCode" id="oetTRINSplCode" value="<?= $tTWISplCode ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTRINFromSpl" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- เลือกร้านค้า ปลายทาง-->
                                            <div id="odvINtore" style="display:none;">
                                                <div class="form-group <?php echo (!FCNbGetIsShpEnabled()) ? 'xCNHide' : ''; ?>">
                                                    <label class="xCNLabelFrm" ><?= language('document/topupVending/topupVending', 'tShop'); ?></label>
                                                    <div class="input-group">
                                                        <script>
                                                            if ('<?= $this->session->userdata("tSesUsrLevel") ?>' == 'SHP') {
                                                                $('#obtBrowseTRINFromShp').attr('disabled', true);
                                                            }
                                                        </script>
                                                        <input name="oetTRINShpNameTo" id="oetTRINShpNameTo" type="hidden" class="form-control xCNClearValue" value="<?= $tTWIShopNameTo ?>" type="text" readonly="" placeholder="<?= language('document/topupVending/topupVending', 'tShop') ?>">
                                                        <input name="oetTRINShpCodeTo" id="oetTRINShpCodeTo" type="hidden" value="<?= $tTWIShopCodeTo ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                        <span class="input-group-btn">
                                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTRINFromShp" type="button ">
                                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- เลือกคลังสินค้า ปลายทาง -->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIWahhouse'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTRINWahNameTo" id="oetTRINWahNameTo" class="form-control xCNClearValue" value="<?= $tTWIWhNameTo ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIWahhouse') ?>">
                                                    <input name="oetTRINWahCodeTo" id="oetTRINWahCodeTo" value="<?= $tTWIWhTo ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTRINFromWah" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- เลือกลูกค้า -->
                                       <div id="odvINWhereCUS" style="display:none;">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tINCUS'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTRINCusName" id="oetTRINCusName" class="form-control xCNClearValue" value="<?= $tTWICusName ?>" type="text" readonly="" placeholder="<?= language('document/topupVending/topupVending', 'tINCUS') ?>">
                                                    <input name="oetTRINCusCode" id="oetTRINCusCode" value="<?= $tTWISplCode ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTRINFromCus" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--เลือกคลังสินค้า - รับเข้า - เงือนไขแหล่งอื่น-->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIWahhouse'); ?></label>
                                                    <div class="input-group">
                                                        <input name="oetTRINWahEtcName" id="oetTRINWahEtcName" class="form-control xCNClearValue" value="<?= $tTWIWhNameTo ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIWahhouse') ?>">
                                                        <input name="oetTRINWahEtcCode" id="oetTRINWahEtcCode" value="<?= $tTWIWhTo ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                            <span class="input-group-btn">
                                                                 <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTRINEtcWah" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                 </button>
                                                            </span>
                                                    </div>
                                            </div>
                                        </div>

                                        <div id="odvINWhereETC" style="display:none;">
                                            <!--กรอกแหล่งอื่น - รับเข้า - เงือนไขแหล่งอื่น-->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tINETC'); ?></label>
                                                <input type="text" class="form-control xCNClearValue" id="oetTWIINEtc" name="oetTWIINEtc" value="<?= $tTWIOther ?>" maxlength="100">
                                            </div>

                                            <!--เลือกคลังสินค้า - รับเข้า - เงือนไขแหล่งอื่น-->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIWahhouse'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTRINWahEtcNameETC" id="oetTRINWahEtcNameETC" class="form-control xCNClearValue" value="<?= $tTWIWhNameTo ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIWahhouse') ?>">
                                                    <input name="oetTRINWahEtcCodeETC" id="oetTRINWahEtcCodeETC" value="<?= $tTWIWhTo ?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTRINEtcWah2" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
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


            <!-- Panel การขนส่ง -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIPanelTransport'); ?></label>
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
                                    <input type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWITransportCtrName" name="oetTWITransportCtrName" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWTnfDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTWITransportTnfDate" name="oetTWITransportTnfDate" value="">
                                        <span class="input-group-btn">
                                            <button id="obtTWITnfDate" type="button" class="btn xCNBtnDateTime xCNControllDateTime">
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
                                    <input type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWITransportRefTnfID" name="oetTWITransportRefTnfID" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWRefVehID'); ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWITransportRefVehID" name="oetTWITransportRefVehID" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWQtyAndTypeUnit'); ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWITransportQtyAndTypeUnit" name="oetTWITransportQtyAndTypeUnit" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITransportAddress'); ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWITransportAddress" name="oetTWITransportAddress" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITransportNumber'); ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTWTransportNumber" name="oetTWIRefTransportNumber" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel อื่นๆ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIPanelETC'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTWIDataConditionETC" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataConditionETC" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <!--เลือกเหตุผล-->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIReason'); ?></label>
                            <div class="input-group">
                                <input name="oetTWIReasonName" id="oetTWIReasonName" class="form-control" value="<?= $tTWIRsnName ?>" type="text" readonly="" placeholder="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWIReason') ?>">
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
                            <textarea class="form-control" id="otaTWIFrmInfoOthRmk"  name="otaTWIFrmInfoOthRmk" rows="5" maxlength="200"><?= $tTWIRmk;?></textarea>
                        </div>

                        <!-- จำนวนครั้งที่พิมพ์ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmInfoOthDocPrint'); ?></label>
                            <input type="text" class="form-control text-right" id="ocmTWIFrmInfoOthDocPrint" name="ocmTWIFrmInfoOthDocPrint" value="<?= $tTWIDocPrint; ?>" readonly>
                        </div>

                        <!-- สถานะเคลื่อนไหว-->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <!-- <input type="checkbox" id="ocbTWIStaDocAct" name="ocbTWIStaDocAct" maxlength="1" value="1" <?php echo $nTWIStaDocAct == '' ? 'checked' : $nTWIStaDocAct == '1' ? 'checked' : '0'; ?>> -->
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
                    var oSOCallDataTableFile = {
                        ptElementID : 'odvDOShowDataTable',
                        ptBchCode   : $('#oetSOFrmBchCode').val(),
                        ptDocNo     : $('#oetTWIDocNo').val(),
                        ptDocKey    : 'TCNTPdtTwiHD',
                        ptSessionID : '<?= $this->session->userdata("tSesSessionID") ?>',
                        pnEvent     : <?= $nStaUploadFile ?>,
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
                          <a role="tab" data-toggle="tab" data-target="#odvTSOContentProduct" aria-expanded="true"><?= language('document/document/document', 'ข้อมูลสินค้า') ?></a>
                        </li>

                        <!-- อ้างอิง -->
                        <li class="xWMenu xWSubTab xCNStaHideShow" style="cursor:pointer;">
                          <a role="tab" data-toggle="tab" data-target="#odvTSOContentHDDocRef" aria-expanded="false"><?= language('document/document/document', 'เอกสารอ้างอิง') ?></a>
                        </li>

                      </ul>
                    </div>
                  </div>
                </div>


                <div class="tab-content">
                  <div id="odvTSOContentProduct" class="tab-pane fade active in" style="padding: 0px !important;">
                    <div class="row p-t-15">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <!-- ตารางสินค้า -->
                        <div style="margin-top: 0px;">
                            <!--ค้นหา-->
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="">
                                        <div class="input-group">
                                            <input type="text" class="form-control" maxlength="100" id="oetTWIFrmFilterPdtHTML" name="oetTWIFrmFilterPdtHTML" placeholder="<?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIFrmFilterTablePdt'); ?>" onkeyup="javascript:if(event.keyCode==13) JSvTWIDOCFilterPdtInTableTemp()">
                                            <span class="input-group-btn">
                                                <button id="obtTWIMngPdtIconSearch" type="button" class="btn xCNBtnDateTime" onclick="JSvTWIDOCFilterPdtInTableTemp()">
                                                    <img class="xCNIconSearch">
                                                </button>
                                            </span>
                                            <!-- <span class="input-group-btn">
                                                <div id="odvTWISearchAndScanBtnGrp" class="xCNDropDrownGroup input-group-append">
                                                    <button id="obtTWIMngPdtIconSearch" type="button" class="btn xCNBtnDateTime xCNControllDateTime" onclick="JSvTWIDOCFilterPdtInTableTemp()">
                                                        <i class="fa fa-search" style="width:20px;"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a id="oliTWIMngPdtSearch"><label><?= language('document/purchaseinvoice/purchaseinvoice', 'tPIFrmFilterTablePdt'); ?></label></a>
                                                            <a id="oliTWIMngPdtScan"><?= language('document/purchaseinvoice/purchaseinvoice', 'tPIFrmSearchAndAddPdt'); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </span> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 text-right">
                                    <!-- <div id="odvTWIMngAdvTableList" class="btn-group xCNDropDrownGroup">
                                        <button id="obtTWIAdvTablePdtDTTemp" type="button" class="btn xCNBTNMngTable m-r-20"><?= language('common/main/main', 'tModalAdvTable') ?></button>
                                    </div> -->
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
                            <!-- <?php include('wTransferreceiptOutEndOfBill.php'); ?> -->
                        </div>
                        <!-- จบตารางสินค้า -->
                      </div>

                    </div>
                  </div>
                  <div id="odvTSOContentHDDocRef" class="tab-pane fade" style="padding: 0px !important;">
                    <div class="row p-t-15">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                        <div style="margin-top:-2px;">
                          <button type="button" id="obtTSOAddDocRef" class="xCNBTNPrimeryPlus ">+</button>
                        </div>
                      </div>
                      <div id="odvTWITableHDRef"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>




    </div>
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
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptOut/transferreceiptOut', 'tConditionISEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span id="ospWahIsEmpty"><?= language('document/transferreceiptOut/transferreceiptOut', 'tWahDocumentISEmptyDetail') ?></span>
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
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptOut/transferreceiptOut', 'tConditionISEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span id="ospTypeIsEmpty"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTypeDocumentISEmptyDetail') ?></span>
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
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptOut/transferreceiptOut', 'tImportPDT') ?></label>
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
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptOut/transferreceiptOut', 'tConditionPDTEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span><?= language('document/transferreceiptOut/transferreceiptOut', 'tConditionPDTEmptyDetail') ?></span>
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

<!--- ============================================================== กรณีไม่มีสินค้าใน Tmp  ============================================================ -->
<div id="odvWTIModalPleaseSelectRef" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/transferreceiptOut/transferreceiptOut', 'tConditionRefEmpty') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <span><?= language('document/transferreceiptOut/transferreceiptOut', 'tConditionRefEmptyDetail') ?></span>
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

<!-- ===========================================  อ้างอิงเอกสารภายใน (ภายใน หรือ ภายนอก) =========================================== -->
<div id="odvTSOModalAddDocRef" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="ofmTSOFormAddDocRef" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'อ้างอิงเอกสาร') ?></label>
                    <input type="hidden" name="oetTWIRefDocNoOld" id="oetTWIRefDocNoOld" value="">
                </div>
                <div class="modal-body">
                  <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('common/main/main', 'ประเภทการอ้างอิงเอกสาร'); ?></label>
                            <select class="selectpicker form-control" id="ocbTWIRefType" name="ocbTWIRefType">
                                <option value="1" selected><?php echo language('common/main/main', 'อ้างอิงภายใน'); ?></option>
                                <option value="3"><?php echo language('common/main/main', 'อ้างอิงภายนอก'); ?></option>
                            </select>
                        </div>
                        <div id="odvTSOTypeRefTypeIn">
                          <!-- อ้างอิงเลขที่เอกสารภายใน -->
                          <div class="form-group">
                              <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('document/saleorder/saleorder', 'tSOLabelFrmRefDoc'); ?></label>
                              <input type="text" class="form-control xCNApvOrCanCelDisabled" placeholder="<?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง'); ?>" id="oetTWIRefIntDoc" name="oetTWIRefIntDoc" maxlength="20" value="">
                          </div>
                          <!-- วันที่อ้างอิงเลขที่เอกสารภายใน -->
                          <div class="form-group">
                              <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmRefDocDate'); ?></label>
                              <div class="input-group">
                                  <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTWIRefIntDocDate" name="oetTWIRefIntDocDate" placeholder="YYYY-MM-DD" value="">
                                  <span class="input-group-btn">
                                      <button id="obtTWIBrowseRefIntDocDate" type="button" class="btn xCNBtnDateTime xCNControllDateTime"><img class="xCNIconCalendar"></button>
                                  </span>
                              </div>
                          </div>

                        </div>
                        <div id="odvTSOTypeRefTypeOut">
                          <!-- อ้างอิงเลขที่เอกสารภายนอก -->
                          <div class="form-group">
                              <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('document/saleorder/saleorder', 'tSOLabelFrmRefDoc'); ?></label>
                              <input type="text" class="form-control xCNApvOrCanCelDisabled" placeholder="<?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง'); ?>" id="oetTWIRefExtDoc" name="oetTWIRefExtDoc" value="">
                          </div>
                          <!-- วันที่เอกสารภายนอก -->
                          <div class="form-group">
                              <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('document/saleorder/saleorder', 'tSOLabelFrmRefDocDate'); ?></label>
                              <div class="input-group">
                                  <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTWIRefExtDocDate" name="oetTWIRefExtDocDate" placeholder="YYYY-MM-DD" value="">
                                  <span class="input-group-btn">
                                      <button id="obtTWIBrowseRefExtDocDate" type="button" class="btn xCNBtnDateTime xCNControllDateTime"><img class="xCNIconCalendar"></button>
                                  </span>
                              </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('common/main/main', 'ค่าอ้างอิง'); ?></label>
                            <input type="text" class="form-control" id="oetTWIRefKey" name="oetTWIRefKey" placeholder="<?php echo language('common/main/main', 'ค่าอ้างอิง'); ?>" maxlength="10" autocomplete="off">
                        </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="obtTBOConfirmAddDocRef" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="submit"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application\modules\common\assets\src\jFormValidate.js'); ?>"></script>
<?php include('script/jTransferReceiptAdd.php'); ?>
