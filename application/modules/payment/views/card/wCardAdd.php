<?php
//Decimal Save
$tDecSave = FCNxHGetOptionDecimalSave();
$tDecShow = FCNxHGetOptionDecimalShow();

if (isset($nStaAddOrEdit) && $nStaAddOrEdit == 1) {
    $tRoute = "cardEventEdit";
    $tCrdCode = $aCrdData['raItems']['rtCrdCode'];
    $tCrdHolderID = $aCrdData['raItems']['rtCrdHolderID'];
    $tCrdRefID = $aCrdData['raItems']['rtCrdRefID'];
    $tCrdName = $aCrdData['raItems']['rtCrdName'];
    $tCrdCtyCode = $aCrdData['raItems']['rtCrdCtyCode'];
    $tCrdCtyName = $aCrdData['raItems']['rtCrdCtyName'];
    $tCrdStartDate = (!empty($aCrdData['raItems']['rtCrdStartDate'])) ? date("Y-m-d", strtotime($aCrdData['raItems']['rtCrdStartDate'])) : '';
    $tCrdExpireDate = (!empty($aCrdData['raItems']['rtCrdExpireDate'])) ? explode(" ", $aCrdData['raItems']['rtCrdExpireDate']) : array('');
    $tCrdExpireDate = $tCrdExpireDate[0];
    // $tCrdStaType = $aCrdData['raItems']['rtCrdStaType'];
    $tCrdStaActive = $aCrdData['raItems']['rtCrdStaActive'];
    // $tCrdStaLocate = $aCrdData['raItems']['rtCrdStaLocate'];
    $tCrdRmk = $aCrdData['raItems']['rtCrdRmk'];
    // $tCrdValue = number_format($aCrdData['raItems']['rtCrdValue'], $tDecShow);
    // $tCrdDeposit = number_format($aCrdData['raItems']['rtCrdDeposit'], $tDecShow);
    $tCrdStaShift = $aCrdData['raItems']['rtCrdStaShift'];
    $tCrdDepartmentCode = $aCrdData['raItems']['rtCrdDepartmentCode'];
    $tCrdDepartmentName = $aCrdData['raItems']['rtCrdDepartmentName'];

    $tCRDAgnCode = $aCrdData['raItems']['rtAgnCode'];
    $tCRDAgnName = $aCrdData['raItems']['rtAgnName'];

    $tDis = "readonly";
} else {
    $tRoute = "cardEventAdd";
    $tCrdCode = "";
    $tCrdHolderID = "";
    $tCrdRefID = "";
    $tCrdName = "";
    $tCrdCtyCode = "";
    $tCrdCtyName = "";
    $tCrdStartDate = "";
    $tCrdExpireDate = "";
    $tCrdStaType = "";
    $tCrdStaActive = "";
    $tCrdStaLocate = "";
    $tCrdRmk = "";
    $tCrdValue = "0.00";
    $tCrdDeposit = "0.00";
    $tCrdStaShift = "";
    $tCrdDepartmentCode = "";
    $tCrdDepartmentName = "";

    $tDis = "";

    $tCRDAgnCode = $tSesAgnCode;
    $tCRDAgnName = $tSesAgnName;
}
?>
<style>
    #odvPanelCrdValue {
        background-color: #f0f4f7;
        height: 200px;
    }
    #odvPanelCrdValue>.panel-heading>hr {
        margin-top: 0px;
        margin-bottom: 0px;
        border: 0;
        border-top: 1px solid #CCC;
    }
    #odvPanelCrdValue>.panel-body>label {
        font-size: 30px;
        font-weight: bold !important;
    }
    .xWCardActive {
        color: #007b00 !important;
        font-weight: bold;
        margin: 0;
    }
    .xWCardInActive {
        color: #7b7f7b !important;
        font-weight: bold;
        margin: 0;
    }
    .xWCardCancle {
        color: #f60a0a !important;
        font-weight: bold;
        margin: 0;
    }
    .xCNLabelTotalSum {
        font-size: 25px !important;
    }
    .xCNLabelTotalSumDeposit {
        font-size: 18px !important;
    }
    .xCNLabelTotalSumDepositUse {
        font-size: 20px !important;
        font-weight: bold;
    }
    .xCNLabelTotalSumAll {
        font-size: 30px !important;
    }
    .xMemBorderPoint {
        border: 2px solid #E0DDDD;
        /* padding:20px 80px;  */
        /* background:#67c8d7; */
        border-radius: 20px;
    }
</style>
<div class="panel-body">
    <div class="row">
        <div class="col-md-12">
            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                <ul class="nav" role="tablist">
                    <!-- ข้อมูลทั่วไป -->
                    <li id="oliUsrloginDetail" class="xWMenu active" data-menutype="DT">
                        <a role="tab" data-toggle="tab" data-target="#odvCrdloginContentInfoDT" aria-expanded="true"><?php echo language('authen/user/user', 'tTabNormal') ?></a>
                    </li>
                    <!---ข้อมูลล็อกอิน-->
                    <!-- Witsarut Add 10/08/2019 14: 00 -->
                    <!-- ตรวจสอบโหมดการเรียก Page
                                ถ้าเป็นโหมดเพิ่ม ($aResult['rtCode'] == '99') ให้ปิด Tab ข้อมูลล็อกอิน
                                ถ้าเป็นโหมดแก้ไข ($aResult['rtCode'] = 1) ให้เปิด Tab ข้อมูลล็อกอิน
                            -->
                    <?php if ($nStaAddOrEdit == '99') { ?>
                        <li id="oliCrdlogin" class="xWMenu xWSubTab disabled" data-menutype="Log">
                            <a role="tab" aria-expanded="true"><?php echo language('payment/cardlogin/cardlogin', 'tDetailLogin') ?></a>
                        </li>
                        <li id="oliCardHis" class="xWMenu xWSubTab disabled" data-menutype="Log" onclick="javascript:;">
                            <a role="tab" aria-expanded="true"><?php echo language('payment/cardlogin/cardlogin', 'tCardUsageHistory') ?></a>
                        </li>
                    <?php } else { ?>
                        <li id="oliCrdlogin" class="xWMenu xWSubTab" data-menutype="Log" onclick="JSxCrdloginGetContent();">
                            <a role="tab" data-toggle="tab" data-target="#odvCrdloginData" aria-expanded="true"><?php echo language('payment/cardlogin/cardlogin', 'tDetailLogin') ?></a>
                        </li>
                        <li id="oliCardHis" class="xWMenu xWSubTab" data-menutype="Log" onclick="JSxGetCardHisDataTable()">
                            <a role="tab" data-toggle="tab" data-target="#odvCardHis" aria-expanded="true"><?php echo language('payment/card/card', 'tCardUsageHistory') ?></a>
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
                <div id="odvCrdloginContentInfoDT" class="tab-pane fade active in">
                    <form class="validate-form" method="post" id="ofmAddCard">
                        <button type="submit" class="xCNHide" id="obtSubmitCard" onclick="JSoAddEditCard('<?php echo $tRoute ?>')"></button>
                        <div class="panel-body" style="padding-top:20px !important;">
                            <div class="row">
                                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                    <?php echo FCNtHGetContentUploadImage(@$tImgObjPath, 'Card', '1');?>
                                </div>
                                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                                    <?php //if($nFCMemRefGrand!='' && $nPointActive!=''){
                                    if (isset($nStaAddOrEdit) && $nStaAddOrEdit == 1) {
                                        $TotalAmount            = $aSumTotalCard[0]['TotalAmount'];
                                        $TotalUse               = $aSumTotalCard[0]['TotalUse'];
                                        $TotalDepositCrd        = $aSumTotalCard[0]['TotalDepositCrd'];
                                        if($TotalDepositCrd == '' || $TotalDepositCrd == null || $TotalDepositCrd == 0){
                                            $TotalDepositCrd    = $aCrdData['raItems']['rtDepositType'];
                                        }else{
                                            $TotalDepositCrd    = $TotalDepositCrd;
                                        }
                                    } else {
                                        $TotalAmount            = '0.00';
                                        $TotalUse               = '0.00';
                                        $TotalDepositCrd        = '0.00';
                                    }
                                    ?>
                                    <div class="col-xl-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- <div class="col-xl-12 col-sm-1 col-md-1 col-lg-1"> -->
                                        <!-- </div> -->
                                        <div class="col-xl-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group xMemBorderPoint">
                                                <div style="padding-left:10px;"><label class="xCNLabelFrm" style="font-size: 25px !important;"><?php echo language('payment/card/card', 'tCardTotalAmount') ?></label></div>
                                                <div class="text-right !important;" style="padding-right:10px;"> <label class="xCNLabelFrm" style="font-size: 40px !important;"> <?= number_format($TotalAmount, 2) ?></label></div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group xMemBorderPoint">
                                                <div style="padding-left:10px;"><label class="xCNLabelFrm" style="font-size: 25px !important;"><?php echo language('payment/card/card', 'tCardTotalDepositCrd') ?></label></div>
                                                <div class="text-right !important;" style="padding-right:10px;"> <label class="xCNLabelFrm" style="font-size: 40px !important;"> <?= number_format($TotalDepositCrd, 2) ?></label></div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group xMemBorderPoint">
                                                <div style="padding-left:10px;"><label class="xCNLabelFrm" style="font-size: 25px !important;"><?php echo language('payment/card/card', 'tCardTotalUse') ?></label></div>
                                                <div class="text-right !important;" style="padding-right:10px;"> <label class="xCNLabelFrm" style="font-size: 40px !important;"> <?= number_format($TotalUse, 2) ?></label></div>
                                            </div>
                                        </div>

                                        <!-- <div class="col-xl-12 col-sm-1 col-md-1 col-lg-1"> -->
                                        <!-- </div> -->
                                        <?php //}
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>

                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('payment/card/card', 'tCRDFrmCrdCode') ?></label>
                                    <div class="form-group" id="odvCardAutoGenCode">
                                        <div class="validate-input">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbCardAutoGenCode" name="ocbCardAutoGenCode" checked="true" value="1">
                                                <span><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div id="odvCardCodeForm" class="form-group">
                                        <input type="hidden" id="ohdCheckDuplicateCrdCode" name="ohdCheckDuplicateCrdCode" value="1">
                                        <!-- <input type="text" id="ohdCrdCode" name="ohdCrdCode" value="<?php echo $tCrdCode; ?>"> -->
                                        <div class="validate-input">
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="10" id="oetCrdCode" name="oetCrdCode" data-is-created="<?php echo $tCrdCode; ?>" placeholder="<?php echo language('payment/card/card', 'tCRDFrmCrdCode') ?>" value="<?php echo $tCrdCode; ?>" data-validate-required="<?php echo language('payment/card/card', 'tCRDValidCardCode') ?>" data-validate-dublicateCode="<?php echo language('payment/card/card', 'tCRDValidCodeDup') ?>">
                                        </div>
                                    </div>

                                    <?php
                                    if ($tRoute == "cardEventAdd") {
                                        $tCRDAgnCode   = $tSesAgnCode;
                                        $tCRDAgnName   = $tSesAgnName;
                                        $tDisabled     = '';
                                        $tNameElmIDAgn = 'oimBrowseAgn';
                                    } else {
                                        $tCRDAgnCode    = $tCRDAgnCode;
                                        $tCRDAgnName    = $tCRDAgnName;
                                        $tDisabled      = 'disabled';
                                        $tNameElmIDAgn  = '';
                                    }
                                    ?>

                                    <!-- Brower Add Agn -->
                                    <div class="form-group <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide';
                                                            endif; ?>">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('payment/card/card', 'tCRDAgency') ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCrdAgnCode" name="oetCrdAgnCode" value="<?php echo $tCRDAgnCode; ?>" data-validate="<?php echo  language('payment/card/card', 'tCRDValiDepartment'); ?>">
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCrdAgnName" name="oetCrdAgnName" value="<?php echo $tCRDAgnName; ?>" data-validate-required="<?php echo language('payment/card/card', 'tCRDValidDepartmentName') ?>" readonly>
                                            <span class="input-group-btn">
                                                <button id="<?= @$tNameElmIDAgn; ?>" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>">
                                                    <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="validate-input">
                                            <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDFrmCrdHolderID') ?></label>
                                            <input type="text" class="form-control" maxlength="30" id="oetCrdHolderID" name="oetCrdHolderID" value="<?php echo $tCrdHolderID; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDFrmCrdRefID') ?></label>
                                        <input type="text" class="form-control" maxlength="30" id="oetCrdRefID" name="oetCrdRefID" value="<?php echo $tCrdRefID; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDFrmCrdName') ?></label>
                                        <input type="text" class="form-control" maxlength="200" id="oetCrdName" name="oetCrdName" value="<?php echo $tCrdName; ?>">
                                    </div>
                                    <!--Department-->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDDepartment') ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCrdDepartment" name="oetCrdDepartment" value="<?php echo $tCrdDepartmentCode; ?>">
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCrdDepartmentName" name="oetCrdDepartmentName" value="<?php echo $tCrdDepartmentName; ?>" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtBrowseDepartment" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <!--End Department-->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('payment/card/card', 'tCRDFrmCtyCode') ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCrdCtyCode" name="oetCrdCtyCode" value="<?php echo $tCrdCtyCode; ?>" data-validate="<?php echo  language('payment/card/card', 'tCRDValidCardTypeCode'); ?>">
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCrdCtyName" name="oetCrdCtyName" value="<?php echo $tCrdCtyName ?>" data-validate="<?php echo  language('payment/card/card', 'tCRDValidCardTypeName'); ?>" readonly data-validate-required="<?php echo language('payment/card/card', 'tCRDValidCrdCtyName') ?>">
                                            <span class="input-group-btn">
                                                <button id="obtBrowseCardType" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDFrmCrdDeposit') ?></label>
                                        <input type="text" class="form-control xCNInputNumericWithDecimal text-right" id="oetCrdDeposit" name="oetCrdDeposit" onclick="JCNdValidateComma('oetCrdDeposit',3,'FC');" onfocusout="JCNdValidatelength8Decimal('oetCrdDeposit','FC',3,'<?php echo $tDecShow ?>')" value="<?php echo number_format($TotalDepositCrd, 2); ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDFrmCrdStartDate') ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetCrdStartDate" name="oetCrdStartDate" autocomplete="off" value="<?php echo $tCrdStartDate; ?>" data-validate="<?php echo language('payment/card/card', 'tCRDValidCardStartDate') ?>">
                                            <span class="input-group-btn">
                                                <button id="obtCrdStartDate" type="button" class="btn xCNBtnDateTime">
                                                    <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDFrmCrdExpireDate') ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetCrdExpireDate" name="oetCrdExpireDate" autocomplete="off" value="<?php echo $tCrdExpireDate; ?>">
                                            <span class="input-group-btn">
                                                <button id="obtCrdExpireDate" type="button" class="btn xCNBtnDateTime">
                                                    <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDFrmCrdStaType') ?></label>
                                                <select class="selectpicker form-control xCNSelectBox" id="ocmCrdStaType" name="ocmCrdStaType" onchange="JSxChkUseCrdStaType()">
                                                    <option value='2' <?php echo ($tCrdStaType == 2) ? 'selected' : '' ?>><?php echo language('payment/card/card', 'tCRDFrmCrdStaTypeDefault') ?></option>
                                                    <option value='1' <?php echo ($tCrdStaType == 1) ? 'selected' : '' ?>><?php echo language('payment/card/card', 'tCRDFrmCrdStaTypeNormal') ?></option>
                                                </select>
                                            </div> -->
                                    <!-- สถานะ เบิกใช้งานบัตร -->
                                    <!-- <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDFrmCrdStaLocate') ?></label>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                                        <label class="fancy-radio xCNRadioMain">
                                                            <input type="radio" id="ocbCrdStaLocateUse" name="ordCrdStaLocate" value="1" <?php echo ($tCrdStaLocate == 1) ? 'checked' : ''; ?> disabled>
                                                            <span><i></i> <?php echo language('payment/card/card', 'tCRDFrmCrdStaLocUseNewWord') ?></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                                        <label class="fancy-radio xCNRadioMain">
                                                            <input type="radio" id="ocbCrdStaLocateUnUse" name="ordCrdStaLocate" value="2" <?php echo ($tCrdStaLocate == 2) ? 'checked' : ''; ?> disabled>
                                                            <span><i></i> <?php echo language('payment/card/card', 'tCRDFrmCrdStaLocUnUseNewWord') ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> -->

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDFrmCrdStaActive') ?></label>
                                        <select required class="selectpicker form-control xCNSelectBox" id="ocmCrdStaAct" name="ocmCrdStaAct" data-live-search="true">
                                            <option value='1' <?php echo (isset($tCrdStaActive) && !empty($tCrdStaActive) && $tCrdStaActive == '1') ? "selected" : "" ?>>
                                                <?php echo language('payment/card/card', 'tCRDFrmCrdActive') ?>
                                            </option>
                                            <option value='2' <?php echo (isset($tCrdStaActive) && !empty($tCrdStaActive) && $tCrdStaActive == '2') ? "selected" : "" ?>>
                                                <?php echo language('payment/card/card', 'tCRDFrmCrdInactive') ?>
                                            </option>
                                            <option value='3' <?php echo (isset($tCrdStaActive) && !empty($tCrdStaActive) && $tCrdStaActive == '3') ? "selected" : "" ?>>
                                                <?php echo language('payment/card/card', 'tCRDFrmCrdCancel') ?>
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDFrmCrdRmk') ?></label>
                                        <textarea class="form-control" maxlength="100" rows="4" id="otaCrdRmk" name="otaCrdRmk"><?php echo $tCrdRmk; ?></textarea>
                                    </div>
                                </div>
                                <!-- <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                            <div id="odvPanelCrdValue" class="panel-headline">
                                                    <div class="panel-heading text-left">
                                                        <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tCRDFrmCrdValue') ?></label>
                                                        <hr>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
                                                            <label class="xCNLabelTotalSumDeposit"> <?php echo language('payment/card/card', 'tCRDFrmCrd') ?> : </label>
                                                        </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                            <label class="xCNLabelTotalSum "><?php echo $tCrdValue; ?></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
                                                            <label class="xCNLabelTotalSumDeposit"> <?php echo language('payment/card/card', 'tCRDFrmCrdDeposit') ?> : </label>
                                                        </div>

                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                            <label class="xCNLabelTotalSum"><?php echo $tCrdDeposit; ?></label>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    if ((str_replace(',', '', $tCrdValue) - str_replace(',', '', $tCrdDeposit)) < 0) {
                                                        $tCrdDeposit = number_format(0, $tDecShow);
                                                    } else {
                                                        $tCrdDeposit = str_replace(',', '', $tCrdValue) - str_replace(',', '', $tCrdDeposit);
                                                    }
                                                    ?>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
                                                            <label class="xCNLabelTotalSumDepositUse"> <?php echo language('payment/card/card', 'tCRDFrmCrdUse') ?> : </label>
                                                        </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                            <label class="xCNLabelTotalSumAll"> <?php echo number_format($tCrdDeposit, 2); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                            </div>


                        </div>
                    </form>
                </div>

                <!-- Tab CardLogin  -->
                <div id="odvCrdloginData" class="tab-pane fade"></div>

                <!-- History Card -->
                <div id="odvCardHis" class="tab-pane fade">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tBranch'); ?></label>
                                <?php
                                    $tBchCodeDef = $this->session->userdata('tSesUsrBchCodeDefault');
                                    $tBchNameDef = $this->session->userdata('tSesUsrBchNameDefault');
                                ?>
                                <div class="input-group">
                                    <input type="text" class="input100 xCNHide" id="oetCrdHisBchCode" name="oetCrdHisBchCode" maxlength="5" value="<?php echo $tBchCodeDef; ?>">
                                    <input class="form-control xWPointerEventNone" type="text" id="oetCrdHisBchName" name="oetCrdHisBchName" readonly="" value="<?php echo $tBchNameDef; ?>">
                                    <span class="input-group-btn xWConditionSearchPdt">
                                        <button id="obtCrdHisBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('payment/card/card', 'tDate'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetCrdHisDate" name="oetCrdHisDate" autocomplete="off" value="" maxlength="10">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn xCNBtnDateTime" onclick="$('#oetCrdHisDate').trigger('focus');">
                                            <img src="<?php echo base_url('application/modules/common/assets/images/icons/icons8-Calendar-100.png'); ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                            <div class="form-group pull-right">
                                <label class="xCNLabelFrm">&nbsp;</label>
                                <div class="input-group">
                                    <a class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxGetCardHisDataTable()"><?php echo language('payment/card/card', 'tSearch'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div id="odvCardHisDataTalbleContainer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "script/jCardAdd.php"; ?>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
