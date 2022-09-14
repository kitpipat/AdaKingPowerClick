<?php
$tRcvSpcCode    = $aRcvSpcCode['tRcvSpcCode'];
// $tRcvSpcName    = $aRcvSpcName['tRcvSpcName'];


// echo '<pre>';
// print_r($aResult);
// echo '</pre>';
// ตรวจสอบโหมดการทำงานว่าเป็น โหมดเพิ่มใหม่ หรือแก้ไข
// if ($aResult['rtCode'] == 1) {

//     $tRcvSpcRcvSeq          = $aResult['raItems']['FNRcvSeq'];
//     if (!empty($aResultConfig)) {
//         $tRcvFmtStaAlwCfg         =  $aResultConfig[0]['FTFmtStaAlwCfg'];
//     } else {
//         $tRcvFmtStaAlwCfg         =  99;
//     }


//     //route for edit
//     $tRoute             = "recivespcEventEdit";
// } else {

//     $tRcvFmtStaAlwCfg         = "";
//     //route for add
//     $tRoute             = "recivespcconfigEventAdd";

//     $tUserLevel = $this->session->userdata("tSesUsrLevel");



//     if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "BCH") {
//         $tRcvSpcAggCode = $this->session->userdata("tSesUsrAgnCode");
//         $tRcvSpcAggName = $this->session->userdata("tSesUsrAgnName");
//         $tRcvSpcBchCode = $this->session->userdata("tSesUsrBchCodeMulti");
//         $tRcvSpcBchName = $this->session->userdata("tSesUsrBchNameMulti");
//     } else {
//         $tRcvSpcAggCode = '';
//         $tRcvSpcAggName =     '';
//     }
// }


$tRcvFmtStaAlwCfg         = "";
//route for add
if ($rtCode == 1) {
    $tRoute             = "recivespcconfigEventEdit";
    $nFNRcvSeq = $nFNRcvSeq;
} else {
    $tRoute             = "recivespcconfigEventAdd";
    $nFNRcvSeq = '';
}


$tUserLevel = $this->session->userdata("tSesUsrLevel");



if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "BCH") {
    $tRcvSpcAggCode = $this->session->userdata("tSesUsrAgnCode");
    $tRcvSpcAggName = $this->session->userdata("tSesUsrAgnName");
    $tRcvSpcBchCode = $this->session->userdata("tSesUsrBchCodeMulti");
    $tRcvSpcBchName = $this->session->userdata("tSesUsrBchNameMulti");
} else {
    $tRcvSpcAggCode = '';
    $tRcvSpcAggName =     '';
}
// print_r($aResult['raItems']);
// print_r($aDataList); die();
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditRcvSpcCfg">
    <input type="hidden" id="ohdRcvSpcIsShpEnabled" value="<?= FCNbGetIsShpEnabled() ? 1 : 0; ?>">
    <input type="hidden" id="ohdTRoute" name="ohdTRoute" value="<?php echo @$tRoute; ?>">
    <input type="hidden" id="ohdRcvSpcCode" name="ohdRcvSpcCode" value="<?php echo @$tRcvSpcCode ?>">
    <!-- <input type="hidden" id="ohdRcvSpcAppCodeOld" name="ohdRcvSpcAppCodeOld" value="<?= $tRcvSpcAppCodeOld ?>"> -->

    <input type="hidden" id="ohdRcvSpcRcvSeq" name="ohdRcvSpcRcvSeq" value="<?php echo @$nFNRcvSeq ?>">
    <input type="hidden" id="ohdValidateDuplicate" name="ohdValidateDuplicate" value="0">

    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxRcvSpcGetConfig();"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnectionSettings') ?></label>
            <label class="xCNLabelFrm">
                <?php if ($rtCode == 1) { ?>
                    <label class="xCNLabelFrm" style="color: #aba9a9 !important;"> / <?php echo language('payment/recivespc/recivespc', 'tRcvSpcEdit') ?> </label>
                <?php } else { ?>
                    <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('payment/recivespc/recivespc', 'tRcvSpcAdd') ?> </label>
                <?php } ?>
        </div>

        <!--ปุ่มเพิ่ม-->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
            <button type="button" onclick="JSxRcvSpcGetConfig();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                <?php echo language('common/main/main', 'tCancel') ?>
            </button>
            <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtCrdloginSave" onclick="JSxRcvSpvCfgSaveAddEdit('<?= $tRoute ?>')"> <?php echo  language('common/main/main', 'tSave') ?></button>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <hr>
    </div>



    <!-- <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcSetPaymentType'); ?></label> -->

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <?php if ($nFNRcvSeq != '') {
                ?>
                    <label class="xCNLabelFrm">ประเภทการเชื่อมต่อ : <?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnection'); ?> <?php echo @$nFNRcvSeq; ?></label>  
                <?php  } ?>
                <table class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcNo'); ?></th>
                            <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcSetupList'); ?></th>
                            <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcUserConfiguration'); ?></th>
                            <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcReferenceValue'); ?></th>

                        </tr>
                    </thead>
                    <tbody id="odvRGPList">
                        <?php //if ($aResultConfigNum > 0) {
                        ?>
                        <?php //foreach ($aResultConfigValue as $key => $aValue) {
                        ?>
                        <!-- <tr>
                                        <input type="hidden" id="ohdFmtCode" name="ohdFmtCode[]" value="<?php echo $aValue['FTFmtCode']; ?>">
                                        <input type="hidden" id="ohdFNSysSeq<?= $key ?>" name="ohdFNSysSeq[]" value="<?php echo $aValue['FNSysSeq']; ?>">
                                        <input type="hidden" id="ohdFTSysKey<?= $key ?>" name="ohdFTSysKey[]" value="<?php echo $aValue['FTSysKey']; ?>">
                                        <td nowrap class="text-left xWTdBody"><?= $aValue['FNSysSeq']; ?></td>
                                        <td nowrap class="text-left xWTdBody"><?= $aValue['FTSysKey']; ?></td>
                                        <td nowrap class="text-left xWTdBody"><input id="oetFTSysStaUsrValue<?= $key ?>" class="form-control" type="input" name="oetFTSysStaUsrValue[]" value="<?php echo $aValue['FTSysStaUsrValue']; ?>"></td>
                                        <td nowrap class="text-left xWTdBody"><input id="oetFTSysStaUsrRef<?= $key ?>" class="form-control" type="input" name="oetFTSysStaUsrRef[]" value="<?php echo $aValue['FTSysStaUsrRef']; ?>"></td>
                                    </tr> -->
                        <?php //}
                        ?>
                        <?php //} else {
                        ?>
                        <?php if (!empty($aResultConfig)) { ?>
                            <?php foreach ($aResultConfig as $key => $aValue) {
                            ?>
                                <tr>
                                    <!-- <input type="hidden" id="ohdFmtCode" name="ohdFmtCode[]" value="<?php echo $aValue['FTFmtCode']; ?>"> -->
                                    <input type="hidden" id="ohdFNSysSeq<?= $key ?>" name="ohdFNSysSeq[]" value="<?php echo $aValue['FNSysSeq']; ?>">
                                    <input type="hidden" id="ohdFTSysKey<?= $key ?>" name="ohdFTSysKey[]" value="<?php echo $aValue['FTSysKey']; ?>">
                                    <td nowrap class="text-left xWTdBody"><?= $aValue['FNSysSeq']; ?></td>
                                    <td nowrap class="text-left xWTdBody"><?= $aValue['FTSysKey']; ?></td>
                                    <td nowrap class="text-left xWTdBody"><input id="oetFTSysStaUsrValue<?= $key ?>" class="form-control" type="input" name="oetFTSysStaUsrValue[]" value="<?php echo $aValue['FTSysStaUsrValue']; ?>"></td>
                                    <td nowrap class="text-left xWTdBody"><input id="oetFTSysStaUsrRef<?= $key ?>" class="form-control" type="input" name="oetFTSysStaUsrRef[]" value="<?php echo $aValue['FTSysStaUsrRef']; ?>"></td>
                                </tr>
                            <?php }
                            ?>
                        <?php } else { ?>

                            <td class='text-center xCNTextDetail2' colspan='4'><?= language('payment/recivespc/recivespc', 'tRcvForMatNotFoundData') ?></td>
                        <?php } ?>
                        <?php //}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</form>
<?php include "script/jReciveSpcCfgMain.php"; ?>
<link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/css/localcss/ada.component.css') ?>">
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>