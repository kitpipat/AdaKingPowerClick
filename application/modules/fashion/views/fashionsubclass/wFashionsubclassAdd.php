<?php
if ($aResult['rtCode'] == "1") {
    $tSCLCode       = $aResult['raItems']['FTSclCode'];
    $tSCLName       = $aResult['raItems']['FTSclName'];
    $tSCLAgnCode    = $aResult['raItems']['FTAgnCode'];
    $tSCLAgnName    = $aResult['raItems']['FTAgnName'];
    $tSCLRmk        = $aResult['raItems']['FTSclRmk'];
    $tSCLRoute      = "masSCLEventEdit";
} else {
    $tSCLCode       = '';
    $tSCLName       = '';
    $tSCLAgnCode    = '';
    $tSCLAgnName    = '';
    $tSCLRmk        = '';
    $tSCLRoute      = "masSCLEventAdd";

    if ( $this->session->userdata("tSesUsrLevel") != 'HQ') {
        $tSCLAgnCode = $this->session->userdata('tSesUsrAgnCode');
        $tSCLAgnName = $this->session->userdata('tSesUsrAgnName');
    }
}

?>
<div class="panel panel-headline">
    <div class="panel-body">
        <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmSCLAdd">
            <button style="display:none" type="submit" id="obtSCLSubmit" onclick="JSxSCLEventAddEdit('<?= $tSCLRoute ?>')"></button>
            <div class="panel-body" style="padding-top:20px !important;">
                <div class="row">
                    <div class="col-xs-12 col-md-5 col-lg-5">
                        <input type="hidden" class="input100 xCNHide" id="oetDepUsrLoginLevel" name="oetDepUsrLoginLevel" value="<?php echo $this->session->userdata("tSesUsrLoginLevel"); ?>">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('fashion/fashionsubclass/fashionsubclass', 'tSCLCode'); ?></label>
                        <div class="form-group" id="odvSCLAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbSCLAutoGenCode" name="ocbSCLAutoGenCode" checked="true" value="1">
                                    <span><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" id="ohdSCLCheckDuplicateCode" name="ohdSCLCheckDuplicateCode" value="1">
                            <div class="validate-input">
                                <input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="10" id="oetSclCode" name="oetSclCode" data-is-created="<?php echo $tSCLCode; ?>" placeholder="<?php echo language('fashion/fashionsubclass/fashionsubclass', 'tSCLCode'); ?>" autocomplete="off" value="<?php echo $tSCLCode; ?>" data-validate-required="<?php echo language('fashion/fashionsubclass/fashionsubclass', 'tSCLValidCode') ?>" data-validate-dublicateCode="<?php echo language('fashion/fashionsubclass/fashionsubclass', 'tSCLValidCodeDup'); ?>" readonly>
                            </div>
                        </div>

                        <!-- เพิ่ม AD Browser --> 
                        <div class="form-group  <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                            <label class="xCNLabelFrm"><?php echo language('fashion/fashionsubclass/fashionsubclass','tSCLAgency')?></label>
                            <div class="input-group"><input type="text" class="form-control xCNHide" id="oetSclAgnCode" name="oetSclAgnCode" maxlength="5" value="<?=$tSCLAgnCode;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetSclAgnName" name="oetSclAgnName"
                                maxlength="100"  placeholder = "<?php echo language('fashion/fashionsubclass/fashionsubclass','tSCLAgency');?>" value="<?=$tSCLAgnName;?>"readonly>
                                <span class="input-group-btn">
                                    <button id="obtSCLBrowseAgn" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('fashion/fashionsubclass/fashionsubclass', 'tSCLName'); ?></label>
                                <input type="text" class="form-control" maxlength="50" id="oetSclName" name="oetSclName" autocomplete="off" placeholder="<?php echo language('fashion/fashionsubclass/fashionsubclass', 'tSCLName'); ?>" value="<?php echo $tSCLName; ?>" data-validate-required="<?php echo language('fashion/fashionsubclass/fashionsubclass', 'tSCLValidName'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('product/pdtmodel/pdtmodel', 'tPMOFrmPmoRmk') ?></label>
                            <textarea class="form-control" maxlength="50" rows="4" id="otaSclRmk" name="otaSclRmk"><?=$tSCLRmk?></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include 'script/jFashionsubclassAdd.php'; ?>
