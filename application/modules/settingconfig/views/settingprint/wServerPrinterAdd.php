<?php
if ($aResult['rtCode'] == "1") {
    $tSrvPriCode       = $aResult['raItems']['rtPrnSrvCode'];
    $tSrvPriName       = $aResult['raItems']['rtPrnSrvName'];
    $tSrvPriRmk        = $aResult['raItems']['rtPrnSrvRmk'];
    $tRoute         = "ServerPrinterEventEdit";
    $tSrvPriStaUse = $aResult['raItems']['rtPrnSrvStaUse'];
    $tSrvPriAgnCode   = $aResult['raItems']['rtPrnSrvAgnCode'];
    $tSrvPriAgnName   = $aResult['raItems']['rtPrnSrvAgnName'];

} else {
    $tSrvPriCode       = "";
    $tSrvPriName       = "";
    $tSrvPriRmk        = "";
    $tRoute         = "ServerPrinterEventAdd";
    $tSrvPriStaUse = 1;
    $tSrvPriAgnCode   = $this->session->userdata("tSesUsrAgnCode");
    $tSrvPriAgnName   = $this->session->userdata("tSesUsrAgnName");
}
?>
<!-- <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddSrvPri"> -->
<form id="ofmAddSrvPri" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">

    <button style="display:none" type="submit" id="obtSubmitSrvPri" onclick="JSnAddEditSrvPri('<?= $tRoute ?>')"></button>
    <input type="hidden" id="ohdSrvPriCountSpc" value="<?=$nCountSpc?>">
    <div class="panel-body">

        <?php
            if ($tRoute ==  "ServerPrinterEventAdd") {
                $tDisabled     = '';
                $tNameElmIDAgn = 'oimSrvPriBrowseAgn';
                $tMenuDisabled = "disabled xCNCloseTabNav";
                $tMenuToggle   = "false";
            } else {
                $tDisabled      = 'disabled';
                $tNameElmIDAgn  = 'oimSrvPriBrowseAgn';
                $tMenuDisabled = "";
                $tMenuToggle   = "tab";
            }
        ?>

        <div id="odvPdtRowNavMenu" class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="custom-tabs-line tabs-line-bottom left-aligned">
                    <ul class="nav" role="tablist">
                        <li id="oliSrvPriInfo1" class="xWMenu active xCNStaHideShow">
                            <a role="tab" data-toggle="tab" data-target="#odvSrvPriContentInfo1" aria-expanded="true">ข้อมูลทั่วไป</a>
                        </li>

                        <li id="oliSrvPriInfo2" class="xWMenu xWSubTab xCNStaHideShow <?=$tMenuDisabled?>">
                            <a role="tab" data-toggle="<?=$tMenuToggle?>" data-target="#odvSrvPriContentInfo2" aria-expanded="false">กำหนดรูปแบบการพิมพ์</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content">
            <div id="odvSrvPriContentInfo1" class="tab-pane fade active in">

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/settingprinter/settingprinter','tSPTBCode')?></label>
                            <div id="odvSrvPriAutoGenCode" class="form-group">
                                <div class="validate-input">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbSrvPriAutoGenCode" name="ocbSrvPriAutoGenCode" checked="true" value="1">
                                        <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div id="odvSrvPriCodeForm" class="form-group">
                                <input type="hidden" id="ohdCheckDuplicateSrvPriCode" name="ohdCheckDuplicateSrvPriCode" value="1">
                                <input type="hidden" id="ohdSrvPriCode" name="ohdSrvPriCode" value="<?= $tSrvPriCode; ?>">

                                <div class="validate-input">
                                    <input type="text" class="form-control xCNGenarateCodeTextInputValidate" 
                                    maxlength="5" 
                                    id="oetSrvPriCode" 
                                    name="oetSrvPriCode" 
                                    value="<?= $tSrvPriCode; ?>" 
                                    data-is-created="<?= $tSrvPriCode; ?>" 
                                    placeholder="<?php echo language('product/settingprinter/settingprinter','tSPTBCode')?>" 
                                    data-validate-required="<?php echo language('product/settingprinter/settingprinter','tSPValidSPCode')?>" 
                                    data-validate-dublicateCode="<?php echo language('product/settingprinter/settingprinter','tSPVldCodeDuplicate')?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-5">
                        
                        <!-- เพิ่ม AD Browser -->
                        <div class="form-group  <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide'; endif; ?>">
                            <label class="xCNLabelFrm"><?php echo language('product/settingprinter/settingprinter', 'tPRNAgency') ?></label>
                            <div class="input-group"><input type="text" class="form-control xCNHide" id="oetSrvPriAgnCode" name="oetSrvPriAgnCode" maxlength="10" value="<?= @$tSrvPriAgnCode; ?>">
                                <input type="text" class="form-control xWPointerEventNone" id="oetSrvPriAgnName" name="oetSrvPriAgnName" maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?>" value="<?= @$tSrvPriAgnName; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="<?= @$tNameElmIDAgn; ?>" type="button" class="btn xCNBtnBrowseAddOn" <?= @$tDisabled ?>>
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="validate-input" data-validate="<?php echo language('product/settingprinter/settingprinter','tSPTBName')?>">
                                <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/settingprinter/settingprinter','tSPTBName')?></label>
                                <input type="text" class="form-control" maxlength="100" id="oetSrvPriName" name="oetSrvPriName" placeholder="<?php echo language('product/settingprinter/settingprinter','tSPTBName')?>" autocomplete="off" value="<?= $tSrvPriName ?>" data-validate-required="<?php echo language('product/settingprinter/settingprinter','tSPValidSPName')?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="validate-input">
                                        <label class="xCNLabelFrm"><?= language('customer/customerGroup/customerGroup', 'tSPFrmSPRmk') ?></label>
                                        <textarea maxlength="100" rows="4" id="otaSrvPriRemark" name="otaSrvPriRemark"><?= $tSrvPriRmk ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <?php
                                if (isset($tSrvPriStaUse) && $tSrvPriStaUse == 1) {
                                    $tChecked   = 'checked';
                                } else {
                                    $tChecked   = '';
                                }
                                ?>
                                <input type="checkbox" id="ocbSrvPriStatusUse" name="ocbSrvPriStatusUse" <?php echo $tChecked; ?>>
                                <span> <?php echo language('common/main/main', 'tStaUse'); ?></span>
                            </label>
                        </div>

                    </div>
                </div>

            </div>

            <div id="odvSrvPriContentInfo2" class="tab-pane fade">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-10">
                        <label id="olbSrvPriSpcName" class="xCNLabelFrm xCNLinkClick" style="font-size: 22px !important;"></label>
                    </div>
                    <div class="col-md-2">
                        <button id="obtrSrvPriSpcAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                    </div>
                </div>
                <div id="odvSrvPriSpcContent"></div>
            </div>
        </div>



    </div>
</form>

<?php include "script/jServerPrinterAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>