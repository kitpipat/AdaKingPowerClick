<?php
if ($aResult['rtCode'] == "1") {
    $tRcvCode                   = $aResult['raItems']['rtRcvCode'];
    $tRcvName                   = $aResult['raItems']['rtRcvName'];
    $tRcvRemark                 = $aResult['raItems']['rtRcvRmk'];
    $tRcvchecked                = $aResult['raItems']['rtRcvStatus'];



    $tSelected                  = $aResult['rtSelected'];

    $tFmtCode                   = $aResult['raItems']['rtFmtCode'];
    $tFmtName                   = $aResult['raItems']['FTFmtName'];

    $tEdtCode                   = $aResult['raItems']['rtEdcCode'];
    $tEdtName                   = $aResult['raItems']['FTEdcName'];

    $tCptCode                   = $aResult['raItems']['FTRcvRefDoc'];
    $tCptName                   = $aResult['raItems']['FTCpnName'];

    $tRcvSpcStaAlwRet           = $aResult['raItems']['FTAppStaAlwRet'];
    $tRcvSpcStaAlwCancel        = $aResult['raItems']['FTAppStaAlwCancel'];
    $tRcvSpcStaPayLast          = $aResult['raItems']['FTAppStaPayLast'];
    $tRcvStaAlwAccPoint         = $aResult['raItems']['FTRcvStaAlwAccPoint'];
    $tRcvStaAlwDrawer           = $aResult['raItems']['FTRcvStaAlwDrawer'];
    $tRcvStaReason              = $aResult['raItems']['FTRcvStaReason'];

    $tRcvSpcStaAlwCfg           = $aResult['raItems']['FTFmtStaAlwCfg'];

    $tRcvQtySlip                = $aResult['raItems']['FNRcvQtySlip'];
    $tRcvRefExt                 = $aResult['raItems']['FTRcvRefExt'];
    $tRcvStaCshOrCrd            = $aResult['raItems']['FTRcvStaCshOrCrd'];

    $tRoute                     = "reciveEventEdit";

    $tUsrAgnCode                = $aResult['raItems']['rtAgnCode'];
    $tUsrAgnName                = $aResult['raItems']['rtAgnName'];
    $tRcvStaShwSum              = $aResult['raItems']['FTRcvStaShwSum'];
    //Event Control
    if (isset($aAlwEventRecive)) {
        if ($aAlwEventRecive['tAutStaFull'] == 1 || $aAlwEventRecive['tAutStaEdit'] == 1) {
            $nAutStaEdit = 1;
        } else {
            $nAutStaEdit = 0;
        }
    } else {
        $nAutStaEdit = 0;
    }
    //Event Control
} else {
    $tRcvCode                   = "";
    $tRcvName                   = "";
    $tRcvRemark                 = "";
    $tRcvchecked                = "";
    $tImgObj                    = "";
    $tRcvQtySlip                = "";
    $tRcvRefExt                 = "";
    $tRcvStaCshOrCrd            = "";

    $tRcvSpcStaAlwRet           = "1";
    $tRcvSpcStaAlwCancel        = "1";
    $tRcvSpcStaPayLast          = "1";
    $tRcvStaAlwAccPoint         = "1";
    $tRcvStaAlwDrawer           = "1";
    $tRcvStaReason              = "1";

    $tFmtCode                   = "";
    $tFmtName                   = "";
    $tEdtCode                   = "";
    $tEdtName                   = "";
    $tRcvSpcStaAlwCfg           = "";
    $tCptCode                   = "";
    $tCptName                   = "";

    $tSelected      = $aResult['rtSelected'];
    $tRoute         = "reciveEventAdd";
    $nAutStaEdit = 0; //Event Control

    $tUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
    $tUsrAgnName = $this->session->userdata("tSesUsrAgnName");
    $tRcvStaShwSum              = "1";
}
$dDatenow = date("Y/m/d");

?>


<div class="panel-body">
    <div class="row">
        <div class="col-md-4">
            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                <ul class="nav" role="tablist">
                    <!-- ข้อมูลทั่วไป -->
                    <li id="oliRcvSpcDetail" class="xWMenu active" data-menutype="DT">
                        <a data-toggle="tab" data-target="#odvRcvSpcContentInfoDT" aria-expanded="true"><?php echo language('payment/recivespc/recivespc', 'tTabNormal') ?></a>
                    </li>
                    <!---ข้อมูล Tab จัดการวิธีการชำระเงิน-->
                    <!-- Witsarut Add 27/11/2019 -->
                    <!-- ตรวจสอบโหมดการเรียก Page
                            ถ้าเป็นโหมดเพิ่ม ($aResult['rtCode'] == '99') ให้ปิด Tab จัดการวิธีการชำระเงิน 
                            ถ้าเป็นโหมดแก้ไข ($aResult['rtCode'] = 1) ให้เปิด Tab จัดการวิธีการชำระเงิน 
                        -->
                    <?php
                    if ($aResult['rtCode'] == '99') {
                    ?>
                        <li id="oliRcvSpcConfig" class="xWSubTab disabled" data-menutype="Cfg">
                            <a role="tab" aria-expanded="true"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnectionSettings') ?></a>
                        </li>
                    <?php } else { ?>
                        <?php if ($tRcvSpcStaAlwCfg  == 1) { ?>
                            <li id="oliRcvSpcConfig" class="xWMenu xWSubTab" data-menutype="Cfg" onclick="JSxRcvSpcGetConfig();">
                                <a role="tab" data-toggle="tab" data-target="#odvRcvSpcConfig" aria-expanded="true"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnectionSettings') ?></a>
                            </li>
                        <?php } else {
                        } ?>
                    <?php } ?>
                    <?php
                    if ($aResult['rtCode'] == '99') {
                    ?>
                        <li id="oliRcvSpc" class="xWSubTab disabled" data-menutype="Log">
                            <a role="tab" aria-expanded="true"><?php echo language('payment/recivespc/recivespc', 'tManagepayment') ?></a>
                        </li>
                    <?php } else { ?>
                        <li id="oliRcvSpc" class="xWMenu xWSubTab" data-menutype="Log" onclick="JSxRcvSpcGetContent();">
                            <a role="tab" data-toggle="tab" data-target="#odvRcvSpcData" aria-expanded="true"><?php echo language('payment/recivespc/recivespc', 'tManagepayment') ?></a>
                        </li>
                    <?php } ?>


                </ul>
            </div>
        </div>
    </div>

    <div id="odvPdtRowContentMenu" class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Tab Content Detail -->
            <div class="tab-content">
                <div id="odvRcvSpcContentInfoDT" class="tab-pane fade active in">
                    <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddRecive">
                        <input type="hidden" id='ohdtRcvSpcStaAlwCfg' name="ohdtRcvSpcStaAlwCfg" value="<?php echo $tRcvSpcStaAlwCfg; ?>">
                        <input type="hidden" id='ohdtFmtCodeOld' name="ohdtFmtCodeOld" value="<?php echo $tFmtCode; ?>">
                        <input type="hidden" id='ohdDatenow' name="ohdDatenow" value="<?php echo $dDatenow; ?>">
                        <button style="display:none" type="submit" id="obtSubmitRecive" onclick="JSnAddEditRecive('<?= $tRoute ?>')"></button>
                        <div class="panel-body" style="padding-top:20px !important;">
                            <div class="row">
                                <div class="col-xs-12 col-md-4 col-lg-4">
                                        <?php echo FCNtHGetContentUploadImage(@$tImgObjAll, 'Rate');?>
                                </div>

                                <div class="col-xs-12 col-md-8 col-lg-8">
                                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('payment/recive/recive', 'tRCVCode') ?></label>
                                    <!-- สร้าางรหัสอัตโนมัติ -->
                                    <div id="odvReciveAutoGenCode" class="form-group">
                                        <div class="validate-input">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbReciveAutoGenCode" name="ocbReciveAutoGenCode" checked="true" value="1">
                                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- รหัสประเภทชำระเงิน -->
                                    <div id="odvReciveCodeForm" class="form-group">
                                        <input type="hidden" id="ohdCheckDuplicateRcvCode" name="ohdCheckDuplicateRcvCode" value="1">
                                        <div class="validate-input">
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" maxlength="5" id="oetRcvCode" name="oetRcvCode" autocomplete="off" data-is-created="<?php echo $tRcvCode; ?>" placeholder="<?= language('promotion/voucher/voucher', 'tRCVCode') ?>" value="<?php echo $tRcvCode; ?>" data-validate-required="<?php echo language('payment/recive/recive', 'tRCVValidCode') ?>" data-validate-dublicateCode="<?php echo language('payment/recive/recive', 'tRCVValidCodeDup'); ?>">
                                        </div>
                                    </div>

                                    <!-- ชื่อประเภทชำระเงิน-->
                                    <div class="form-group">
                                        <div class="validate-input">
                                            <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('payment/recive/recive', 'tRCVName') ?><?= language('payment/recive/recive', 'tRCVTitle') ?></label>
                                            <input type="text" class="form-control" maxlength="50" id="oetRcvName" name="oetRcvName" placeholder="<?= language('payment/recive/recive', 'tRCVName') ?><?= language('payment/recive/recive', 'tRCVTitle') ?>" autocomplete="off" value="<?php echo $tRcvName; ?>" data-validate-required="<?php echo language('payment/recive/recive', 'tRCVValidName') ?>">
                                        </div>
                                    </div>

                                    <!-- อ้างอิงรูปแบบ -->
                                    <div id="odvRcvFmtName" class="form-group">
                                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('payment/recive/recive', 'tRCVFormat') ?></label>
                                        <div class="input-group">

                                            <input type="text" autocomplete="off" class="form-control xCNHide" id="oetRcvFormatCode" name="oetRcvFormatCode" value="<?php echo $tFmtCode; ?>" >
                                            <div class="validate-input">
                                                <input type="text" class="form-control xWPointerEventNone" id="oetRcvFormatName" name="oetRcvFormatName" placeholder="" value="<?php echo $tFmtName; ?>" data-validate-required="<?php echo language('payment/recive/recive', 'tRCVValidFormatName') ?>" readonly>
                                            </div>
                                            <span class="input-group-btn">
                                                <button id="oimRcvFormatBrowse" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Browse คูปองเงินสด -->
                                    <div id="odvRcvCouponName" class="form-group">
                                        <label class="xCNLabelFrm"><?= language('payment/recive/recive', 'tRCVCoupon') ?></label>
                                        <div class="input-group">

                                            <input type="text" autocomplete="off" class="form-control xCNHide" id="oetRcvCouponCode" name="oetRcvCouponCode" value="<?php echo $tCptCode?>" >
                                            <div class="validate-input">
                                                <input type="text" class="form-control xWPointerEventNone" id="oetRcvCouponName" name="oetRcvCouponName" placeholder="" value="<?php echo $tCptName?>" readonly>
                                            </div>
                                            <span class="input-group-btn">
                                                <button id="oimRcvCouponBrowse" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                            </span>
                                        </div>

                                    </div>

                                    <!-- อ้างอิงเครื่องอ่านบัตรอิเล็กทรอนิกส์ -->
                                    <div id="odvRcvFmtName" class="form-group">
                                        <label class="xCNLabelFrm"><?= language('payment/recive/recive', 'tRCVReadCard') ?></label>
                                        <div class="input-group">

                                            <input type="text" autocomplete="off" class="form-control xCNHide" id="oetRcvReadCardCode" name="oetRcvReadCardCode" value="<?php echo $tEdtCode; ?>" >
                                            <div class="validate-input">
                                                <input type="text" class="form-control xWPointerEventNone" id="oetRcvReadCardName" name="oetRcvReadCardName" placeholder="" value="<?php echo $tEdtName; ?>" readonly>
                                            </div>
                                            <span class="input-group-btn">
                                                <button id="oimRcvElectronicBrowse" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                            </span>
                                        </div>
                                    </div>

                                <!-- Agency -->
                                <div class="<?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                                    <div class="form-group">
                                        <label
                                            class="xCNLabelFrm"><?php echo language('common/main/main','tAgency')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetRCVUsrAgnCode"
                                                name="oetRCVUsrAgnCode" value="<?=@$tUsrAgnCode?>">
                                            <input type="text" class="form-control xWPointerEventNone" id="oetRCVUsrAgnName"
                                                name="oetRCVUsrAgnName"
                                                placeholder="<?php echo language('common/main/main','tAgency')?>"
                                                value="<?=@$tUsrAgnName?>" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtRCVUsrBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img
                                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- end Agency -->

                                <!-- จำนวนสำเนาใบเสร็จ -->
                                <div class="form-group">
                                    <div class="validate-input">
                                        <label class="xCNLabelFrm"><?= language('payment/recive/recive', 'tRCVNumCopyReceipt') ?></label>
                                        <input type="text" class="form-control" maxlength="50" id="oetRCVNumCopyReceipt" name="oetRCVNumCopyReceipt" placeholder="<?= language('payment/recive/recive', 'tRCVNumCopyReceipt') ?>" autocomplete="off" value="<?php echo $tRcvQtySlip;?>" >
                                    </div>
                                </div>

                                <!-- รหัสอ้างอิงภายนอก -->
                                <div class="form-group">
                                    <div class="validate-input">
                                        <label class="xCNLabelFrm"> <?= language('payment/recive/recive', 'tRCVExtRefCode') ?></label>
                                        <input type="text" class="form-control" maxlength="5" id="oetRcvExtRefCode" name="oetRcvExtRefCode" placeholder="<?= language('payment/recive/recive', 'tRCVExtRefCode') ?>" autocomplete="off" value="<?php echo $tRcvRefExt;?>" >
                                    </div>
                                </div>

                                <!-- สถานะแสดงตามประเภทชำระ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('payment/recive/recive', 'tRCVStaPayType') ?></label>
                                    <select class="selectpicker form-control" id="ocbRcvStaPayType" name="ocbRcvStaPayType" maxlength="1">
                                        <option value="1"<?php if ($tRcvStaCshOrCrd == 1) {
                                                                echo "selected";
                                                            } ?>><?= language('payment/recive/recive', 'tRCVCash') ?></option>
                                        <option value="2"<?php if ($tRcvStaCshOrCrd == 2) {
                                                                echo "selected";
                                                            } ?>><?= language('payment/recive/recive', 'tRCVCredit') ?></option>
                                        <option value="3"<?php if ($tRcvStaCshOrCrd == 3) {
                                                                echo "selected";
                                                            } ?>><?= language('payment/recive/recive', 'tRCVBoth') ?></option>
                                    </select>
                                </div>

                                <!-- สถานะการแสดงหน้าสรุปยอดเงิน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('payment/recive/recive', 'tRCVStaShwSum') ?></label>
                                    <select class="selectpicker form-control" id="ocbRcvStaShwSum" name="ocbRcvStaShwSum" maxlength="1">
                                        <option value="1" <?=($tRcvStaShwSum == '1' ? "selected" : "")?> ><?= language('payment/recive/recive', 'tRCVStaShwSum1') ?></option>
                                        <option value="2" <?=($tRcvStaShwSum == '2' ? "selected" : "")?> ><?= language('payment/recive/recive', 'tRCVStaShwSum2') ?></option>
                                        <option value="3" <?=($tRcvStaShwSum == '3' ? "selected" : "")?> ><?= language('payment/recive/recive', 'tRCVStaShwSum3') ?></option>
                                    </select>
                                </div>

                                <!-- สถานะ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('payment/recive/recive', 'tRCVStatus') ?></label>
                                    <select class="selectpicker form-control" id="ocbRcvStatus" name="ocbRcvStatus" maxlength="1">
                                        <!-- <option value=""><?= language('common/main/main', 'tCMNBlank-NA') ?></option> -->
                                        <option value="1" <?php if ($tRcvchecked == 1) {
                                                                echo "selected";
                                                            } ?>><?= language('company/branch/branch', 'tBCHStaActive1') ?></option>
                                        <option value="2" <?php if ($tRcvchecked == 2) {
                                                                echo "selected";
                                                            } ?>><?= language('company/branch/branch', 'tBCHStaActive2') ?></option>
                                    </select>
                                </div>

                                <!-- หมายเหตุ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('payment/recive/recive', 'tRCVRemark') ?></label>
                                    <textarea class="form-control" maxlength="100" rows="4" id="otaRcvRemark" name="otaRcvRemark"><?= $tRcvRemark ?></textarea>
                                </div>

                                <!-- สถานะทำรายการคืน    -->
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 row">
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <?php
                                            if (isset($tRcvSpcStaAlwRet) && $tRcvSpcStaAlwRet == 1) {
                                                $tCheckedStaAlwRet  = 'checked';
                                            } else {
                                                $tCheckedStaAlwRet  = '';
                                            }
                                            ?>
                                            <input type="checkbox" id="ocbRcvSpcStaAlwRet" name="ocbRcvSpcStaAlwRet" <?php echo $tCheckedStaAlwRet; ?>>
                                            <span> <?php echo language('payment/recivespc/recivespc', 'tRcvSpcStaAlwRet'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- สถานะยกเลิกรายการ -->
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 row">
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <?php
                                            if (isset($tRcvSpcStaAlwCancel) && $tRcvSpcStaAlwCancel == 1) {
                                                $tCheckedStaAlwCancel   = 'checked';
                                            } else {
                                                $tCheckedStaAlwCancel   = '';
                                            }
                                            ?>
                                            <input type="checkbox" id="ocbRcvSpcStaAlwCancel" name="ocbRcvSpcStaAlwCancel" <?php echo $tCheckedStaAlwCancel; ?>>
                                            <span> <?php echo language('payment/recivespc/recivespc', 'tRcvSpcStaAlwCancel'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- สถานะอนุญาตให้มีรายการอื่นต่อท้าย -->
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 row">
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <?php
                                            if (isset($tRcvSpcStaPayLast) && $tRcvSpcStaPayLast == 1) {
                                                $tCheckedStaPayLast = 'checked';
                                            } else {
                                                $tCheckedStaPayLast = '';
                                            }
                                            ?>
                                            <input type="checkbox" id="ocbRcvSpcStaPayLast" name="ocbRcvSpcStaPayLast" <?php echo $tCheckedStaPayLast; ?>>
                                            <span> <?php echo language('payment/recivespc/recivespc', 'tRcvSpcStaPayLast'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- สถานะอนุญาตให้สะสมแต้ม -->
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 row">
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <?php
                                            if (isset($tRcvStaAlwAccPoint) && $tRcvStaAlwAccPoint == 1) {
                                                $tCheckedRcvStaAlwAccPoint = 'checked';
                                            } else {
                                                $tCheckedRcvStaAlwAccPoint = '';
                                            }
                                            ?>
                                            <input type="checkbox" id="ocbRcvSpcStaAlwAccPoint" name="ocbRcvSpcStaAlwAccPoint" <?php echo $tCheckedRcvStaAlwAccPoint; ?>>
                                            <span> <?php echo language('payment/recivespc/recivespc', 'tRcvSpcStaAlwAccPoint'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- สถานะอนุญาตเปิดลิ้นชัก-->
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 row">
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <?php
                                            if (isset($tRcvStaAlwDrawer) && $tRcvStaAlwDrawer == 1) {
                                                $tCheckedRcvStaAlwDrawer = 'checked';
                                            } else {
                                                $tCheckedRcvStaAlwDrawer = '';
                                            }
                                            ?>
                                            <input type="checkbox" id="ocbRcvSpcStaOpnDrawer" name="ocbRcvSpcStaOpnDrawer" <?php echo $tCheckedRcvStaAlwDrawer; ?>>
                                            <span> <?php echo language('payment/recivespc/recivespc', 'tRcvSpcStaOpnDrawer'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- สถานะระบุเหตุผลชำระ -->
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 row">
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <?php
                                            if (isset($tRcvStaReason) && $tRcvStaReason == 1) {
                                                $tCheckedRcvStaReason = 'checked';
                                            } else {
                                                $tCheckedRcvStaReason = '';
                                            }
                                            ?>
                                            <input type="checkbox" id="ocbRcvSpcIdcReaPayment" name="ocbRcvSpcIdcReaPayment" <?php echo $tCheckedRcvStaReason; ?>>
                                            <span> <?php echo language('payment/recivespc/recivespc', 'tRcvSpcIdcReaPayment'); ?></span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <!-- Tab ReciveSpc -->
                <div id="odvRcvSpcData" class="tab-pane fade"></div>

                <!-- Tab ReciveSpcConfig -->
                <div id="odvRcvSpcConfig" class="tab-pane fade"></div>

            </div>
        </div>
    </div>
</div>
</div>

<?php include 'script/jReciveAdd.php'; ?>

<!-- div Dropdownbox -->
<div id="dropDownSelect1"></div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<script type="text/javascript">
    $('.selectpicker').selectpicker();
    $(".selection-2").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });

    $('.xWTooltipsBT').tooltip({
        'placement': 'bottom'
    });
    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });
    
</script>
