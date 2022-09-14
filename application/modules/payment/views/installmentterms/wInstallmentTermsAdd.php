<?php
if (isset($nStaAddOrEdit) && $nStaAddOrEdit == 1) {
    $tRoute         = "masInstallmentTermsEventEdit";
    $tStmCode       = $aStmData['raItems']['FTStmCode'];
    $tStmName       = $aStmData['raItems']['FTStmName'];
    $tStmRmk        = $aStmData['raItems']['FTStmRmk'];

    $tStmAgnCode    = $aStmData['raItems']['FTAgnCode'];
    $tStmAgnName    = $aStmData['raItems']['FTAgnName'];

    $tStmStaUnit    = $aStmData['raItems']['FTStmStaUnit'];
    $cStmLimit      = $aStmData['raItems']['FCStmLimit'];
    $nStmQty        = $aStmData['raItems']['FNStmQty'];
    $cStmRate       = $aStmData['raItems']['FCStmRate'];

    $tDisabledBorwseAgn = "disabled";
    $tMenuTabDisable 	= "";
    $tMenuTabToggle     = "tab";
} else {
    $tRoute         = "masInstallmentTermsEventAdd";
    $tStmCode       = "";
    $tStmName       = "";
    $tStmRmk        = "";

    $tStmAgnCode    = $this->session->userdata("tSesUsrAgnCode");
    $tStmAgnName    = $this->session->userdata("tSesUsrAgnName");

    $tStmStaUnit    = "1";
    $cStmLimit      = 0.00;
    $nStmQty        = 0;
    $cStmRate       = 0.00;

    $tSesUsrLevel = $this->session->userdata("tSesUsrLevel");
    if( $tSesUsrLevel != "HQ" ){
        $tDisabledBorwseAgn = "disabled";
    }else{
        $tDisabledBorwseAgn = "";
    }
    $tMenuTabDisable 	= " disabled xCNCloseTabNav";
    $tMenuTabToggle     = "false";

}



?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmStmAdd">
    <button style="display:none" type="submit" id="obtStmSubmit" onclick="JSoStmAddEdit('<?= $tRoute ?>')"></button>
    <div>
        <!-- เพิ่มมาใหม่ -->
        <div class="panel panel-body" style="padding-top:20px !important;">

            <div id="odvStmNavMenu" class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="custom-tabs-line tabs-line-bottom left-aligned">
                        <ul class="nav" role="tablist">

                            <!-- เงื่อนไขการผ่อนชำระ -->
                            <li id="oliStmContent1" class="xWMenu active xCNStaHideShow">
                                <a role="tab" data-toggle="tab" data-target="#odvStmContent1" aria-expanded="true"><?php echo language('payment/installmentterms/installmentterms', 'tSTMTab1') ?></a>
                            </li>

                            <!-- บัตรเครดิตที่รองรับ -->
                            <li id="oliStmContent2" class="xWMenu xWSubTab xCNStaHideShow <?=$tMenuTabDisable?>">
                                <a role="tab" data-toggle="<?=$tMenuTabToggle?>" data-target="#odvStmContent2" aria-expanded="false"><?php echo language('payment/installmentterms/installmentterms', 'tSTMSptCreditCards') ?></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-content">

                <div id="odvStmContent1" class="tab-pane fade active in">
                    <div class="row">
                        <div class="col-xs-12 col-md-5 col-lg-5">

                            <div class="form-group">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('payment/installmentterms/installmentterms', 'tSTMFrmStmCode') ?></label>
                                <div class="">
                                    <div class="form-group" id="odvStmAutoGenCode">

                                        <label class="fancy-checkbox">
                                            <input type="hidden" id="ohdStmCheckDuplicateCode" name="ohdStmCheckDuplicateCode" value="1">
                                            <input type="checkbox" id="ocbStmAutoGenCode" name="ocbStmAutoGenCode" checked="true" value="1">
                                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                        </label>

                                    </div>

                                    <input type="text" class="form-control xCNGenarateCodeTextInputValidate" maxlength="5" id="oetStmCode" name="oetStmCode" placeholder="<?php echo language('payment/installmentterms/installmentterms', 'tSTMFrmPlacName') ?>" value="<?php echo $tStmCode ?>" data-is-created="<?php echo $tStmCode; ?>" data-validate-required="<?php echo language('payment/installmentterms/installmentterms', 'tSTMValidCode') ?>" data-validate-dublicateCode="<?php echo language('payment/installmentterms/installmentterms', 'tSTMValidCodeDup'); ?>" autocomplete="off">
                                    <span class="input-group-btn">
                                    </span>
                                </div>
                            </div>

                            <!-- เพิ่ม AD Browser -->
                            <div class="form-group  <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                                <label class="xCNLabelFrm"><?php echo language('payment/banknote/banknote','tBNTAgency')?></label>
                                <div class="input-group"><input type="text" class="form-control xCNHide" id="oetStmAgnCode" name="oetStmAgnCode" maxlength="5" value="<?=$tStmAgnCode;?>">
                                <input type="text" class="form-control xWPointerEventNone" id="oetStmAgnName" name="oetStmAgnName"
                                    maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tTBAgency')?>" value="<?=$tStmAgnName;?>"readonly>
                                    <span class="input-group-btn">
                                        <button id="obtStmBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn" <?=$tDisabledBorwseAgn?> >
                                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('payment/installmentterms/installmentterms', 'tSTMName') ?></label> <!-- เปลี่ยนชื่อ Class -->
                                <input type="text" class="form-control" maxlength="100" placeholder="<?php echo language('payment/installmentterms/installmentterms', 'tSTMName') ?>" id="oetStmName" name="oetStmName" value="<?= $tStmName ?>" data-validate-required="<?= language('payment/installmentterms/installmentterms', 'tSTMValidName') ?>" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('payment/installmentterms/installmentterms', 'tSTMMinimumBalance') ?></label>
                                <input type="text" class="form-control text-right xCNInputNumericWithDecimal" maxlength="18" placeholder="<?php echo language('payment/installmentterms/installmentterms', 'tSTMMinimumBalance') ?>" id="oetStmLimit" name="oetStmLimit" value="<?=number_format($cStmLimit,$nOptDecimalShow,'.','')?>" autocomplete="off" >
                            </div>

                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('payment/installmentterms/installmentterms', 'tSTMNumInstallments') ?></label>
                                <input type="text" class="form-control text-right xCNInputNumericWithDecimal" maxlength="18" placeholder="<?php echo language('payment/installmentterms/installmentterms', 'tSTMNumInstallments') ?>" id="oetStmQty" name="oetStmQty" value="<?=number_format($nStmQty,$nOptDecimalShow,'.','')?>" autocomplete="off" >
                            </div>

                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('payment/installmentterms/installmentterms', 'tSTMStaUnit');?></label>
                                <select class="selectpicker form-control" id="ocmStmStaUnit" name="ocmStmStaUnit" value="<?=$tStmStaUnit;?>">
                                    <option value="1" <?php echo (!empty($tStmStaUnit) && $tStmStaUnit == '1')? 'selected' : '';?>><?=language('payment/installmentterms/installmentterms', 'tSTMStaUnit1')?></option>
                                    <option value="2" <?php echo (!empty($tStmStaUnit) && $tStmStaUnit == '2')? 'selected' : '';?>><?=language('payment/installmentterms/installmentterms', 'tSTMStaUnit2')?></option>
                                    <option value="3" <?php echo (!empty($tStmStaUnit) && $tStmStaUnit == '3')? 'selected' : '';?>><?=language('payment/installmentterms/installmentterms', 'tSTMStaUnit3')?></option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('payment/installmentterms/installmentterms', 'tSTMRate') ?></label>
                                <input type="text" class="form-control text-right xCNInputNumericWithDecimal" maxlength="18" placeholder="<?php echo language('payment/installmentterms/installmentterms', 'tSTMRate') ?>" id="oetStmRate" name="oetStmRate" value="<?=number_format($cStmRate,$nOptDecimalShow,'.','')?>" autocomplete="off" >
                            </div>

                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('payment/installmentterms/installmentterms', 'tSTMFrmStmRmk') ?></label>
                                <textarea class="form-control " maxlength="100" rows="4" id="otaStmRmk" name="otaStmRmk"><?= $tStmRmk ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="odvStmContent2" class="tab-pane fade">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                            <div class="row">
                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9" style="margin-bottom:10px;">
                                    <label class="xCNLabelFrm xCNLinkClick" style="font-size: 22px !important;"><?=language('payment/installmentterms/installmentterms', 'tSTMName')?> : <?=$tStmName?> </label>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-right" style="margin-bottom:10px;">
                                    <button id="obtStmAddSub" class="xCNBTNPrimeryPlus" type="button">+</button>
                                </div>
                            </div>

                            <div id="odvStmSubContentDataTable"></div>

                        </div>
                    <div>
                </div>

            </div>

        </div>
    </div>
</form>

<?php include 'script/jInstallmentTermsAdd.php'; ?>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>