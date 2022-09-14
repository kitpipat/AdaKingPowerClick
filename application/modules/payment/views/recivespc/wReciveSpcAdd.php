<?php
$tRcvSpcCode    = $aRcvSpcCode['tRcvSpcCode'];
$tRcvSpcName    = $aRcvSpcName['tRcvSpcName'];


// echo '<pre>';
// print_r( $aResult['raItems']);
// echo '</pre>';
// ตรวจสอบโหมดการทำงานว่าเป็น โหมดเพิ่มใหม่ หรือแก้ไข
if ($aResult['rtCode'] == 1) {
    $tRcvSpcAppCodeOld         = $aResult['raItems']['FTAppCode'];
    $tRcvSpcRcvSeqOld          = $aResult['raItems']['FNRcvSeq'];
    $tRcvCodeOld               = $aResult['raItems']['FTRcvCode'];

    $tRcvSpcAppCode         = $aResult['raItems']['FTAppCode'];
    $tRcvSpcAppName         = $aResult['raItems']['FTAppName'];
    $tRcvSpcBchCode         = $aResult['raItems']['FTBchCode'];
    $tRcvSpcBchName         = $aResult['raItems']['FTBchName'];
    $tRcvSpcMerCode         = $aResult['raItems']['FTMerCode'];
    $tRcvSpcMerName         = $aResult['raItems']['FTMerName'];
    $tRcvSpcShpCode         = $aResult['raItems']['FTShpCode'];
    $tRcvSpcShpName         = $aResult['raItems']['FTShpName'];
    $tRcvSpcShpType         = $aResult['raItems']['FTShpType'];
    $tRcvSpcAggCode         = $aResult['raItems']['FTAggCode'];
    $tRcvSpcAggName         = $aResult['raItems']['FTAgnName'];
    $tRcvSpcPosCode         = $aResult['raItems']['FTPosCode'];
    $tRcvSpcPosName         = $aResult['raItems']['FTPosName'];
    $tRemark                = $aResult['raItems']['FTPdtRmk'];
    // $tRcvSpcStaAlwRet       = $aResult['raItems']['FTAppStaAlwRet'];
    // $tRcvSpcStaAlwCancel    = $aResult['raItems']['FTAppStaAlwCancel'];
    // $tRcvSpcStaPayLast      = $aResult['raItems']['FTAppStaPayLast'];
    $tRcvSpcRcvSeq          = $aResult['raItems']['FNRcvSeq'];
    if (!empty($aResultConfig)) {
        $tRcvFmtStaAlwCfg         =  $aResultConfig[0]['FTFmtStaAlwCfg'];
    } else {
        $tRcvFmtStaAlwCfg         =  99;
    }


    //route for edit
    $tRoute             = "recivespcEventEdit";
} else {
    $tRcvSpcAppCodeOld         = "";
    $tRcvSpcAppCode         = $this->session->userdata("tSesUsrAgnCode");
    $tRcvSpcAppName         = $this->session->userdata("tSesUsrAgnName");
    $tRcvSpcBchCode         = $this->session->userdata("tSesUsrBchCodeDefault");
    $tRcvSpcBchName         = $this->session->userdata("tSesUsrBchNameDefault");
    $tRcvSpcMerCode         = "";
    $tRcvSpcMerName         = "";
    $tRcvSpcShpCode         = "";
    $tRcvSpcShpName         = "";
    $tRcvSpcShpType         = "";
    // $tRcvSpcAggCode         = "";
    // $tRcvSpcAggName         = "";
    $tRemark                = "";
    // $tRcvSpcStaAlwRet       = "1";
    // $tRcvSpcStaAlwCancel    = "1";
    // $tRcvSpcStaPayLast      = "1";
    $tRcvSpcRcvSeq          = "";
    $tRcvFmtStaAlwCfg         = "";
    //route for add
    $tRoute             = "recivespcEventAdd";

    $tUserLevel = $this->session->userdata("tSesUsrLevel");



    if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel != "HQ") {
        $tRcvSpcAggCode = $this->session->userdata("tSesUsrAgnCode");
        $tRcvSpcAggName = $this->session->userdata("tSesUsrAgnName");
        $tRcvSpcBchCode ='';
        $tRcvSpcBchName ='';


        // $tUsrBchCodeDefult =  $this->session->userdata("tSesUsrBchCodeDefault");
        // $tUsrBchNameDefult = $this->session->userdata("tSesUsrBchNameDefault");
    } else {
        $tRcvSpcAggCode ='';
        $tRcvSpcAggName ='';
        $tRcvSpcBchCode ='';
        $tRcvSpcBchName ='';
    }

}


// print_r($aResult['raItems']);
// print_r($aDataList); die();
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditRcvSpc">
    <input type="hidden" id="ohdRcvSpcIsShpEnabled" value="<?= FCNbGetIsShpEnabled() ? 1 : 0; ?>">
    <input type="hidden" id="ohdTRoute" name="ohdTRoute" value="<?php echo @$tRoute; ?>">
    <input type="hidden" id="ohdRcvSpcCode" name="ohdRcvSpcCode" value="<?php echo @$tRcvSpcCode ?>">
    <input type="hidden" id="ohdRcvSpcAppCodeOld" name="ohdRcvSpcAppCodeOld" value="<?= $tRcvSpcAppCodeOld ?>">

    <input type="hidden" id="ohdRcvSpcRcvSeq" name="ohdRcvSpcRcvSeq" value="<?php echo @$tRcvSpcRcvSeq ?>">
    <input type="hidden" id="ohdValidateDuplicate" name="ohdValidateDuplicate" value="0">


    <input type="hidden" id="ohdRcvSpcAppCode" name="ohdRcvSpcAppCode" value="<?php echo @$tRcvSpcAppCode ?>">
    <input type="hidden" id="ohdRcvSpcBchCode" name="ohdRcvSpcBchCode" value="<?php echo @$tRcvSpcBchCode ?>">
    <input type="hidden" id="ohdRcvSpcMerCode" name="ohdRcvSpcMerCode" value="<?php echo @$tRcvSpcMerCode ?>">
    <input type="hidden" id="ohdRcvSpcShpCode" name="ohdRcvSpcShpCode" value="<?php echo @$tRcvSpcShpCode ?>">
    <input type="hidden" id="ohdRcvSpcAggCode" name="ohdRcvSpcAggCode" value="<?php echo @$tRcvSpcAggCode ?>">
    <input type="hidden" id="ohdRcvSpcPosCode" name="ohdRcvSpcPosCode" value="<?php echo @$tRcvSpcPosCode ?>">

    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNLabelFrm" style="color: #1866ae !important; cursor:pointer;" onclick="JSxRcvSpcGetContent();"><?php echo language('payment/recivespc/recivespc', 'tDetailManagepayment') ?></label>
            <label class="xCNLabelFrm">
                <?php if ($aResult['rtCode'] == 1) { ?>
                    <label class="xCNLabelFrm" style="color: #aba9a9 !important;"> / <?php echo language('payment/recivespc/recivespc', 'tRcvSpcEdit') ?> </label>
                <?php } else { ?>
                    <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('payment/recivespc/recivespc', 'tRcvSpcAdd') ?> </label>
                <?php } ?>
        </div>

        <!--ปุ่มเพิ่ม-->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
            <button type="button" onclick="JSxRcvSpcGetContent();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                <?php echo language('common/main/main', 'tCancel') ?>
            </button>
            <button type="submit" style="background-color: rgb(23, 155, 253); color: white;" class="btn" id="obtCrdloginSave" onclick="JSxRcvSpvSaveAddEdit('<?= $tRoute ?>')"> <?php echo  language('common/main/main', 'tSave') ?></button>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <hr>
    </div>
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- รหัสประเภทการชำระเงิน -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcPaymentCategoryID'); ?></label>
                <input type="text" class="form-control" id="oetRcvSpcCode" name="oetRcvSpcCode" value="<?php echo $tRcvSpcCode; ?>" readonly="readonly">
                <!-- <div class="input-group">
                </div> -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- ชื่อประเภทการชำระเงิน -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcPaymentCategoryName'); ?></label>
                <input type="text" class="form-control" id="oetRcvSpcName" name="oetRcvSpcName" value="<?php echo $tRcvSpcName; ?>" readonly="readonly">
                <!-- <div class="input-group">

                </div> -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- ระบบบัตร -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBrwApp'); ?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcAppCode" name="oetRcvSpcAppCode" value="<?php echo @$tRcvSpcAppCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcAppName" name="oetRcvSpcAppName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdersystem'); ?>" value="<?php echo @$tRcvSpcAppName; ?>" data-validate="<?php echo  language('payment/recivespc/recivespc', 'tRCVSPCValidName'); ?>" readonly>
                    <span class="input-group-btn">
                        <!-- <button id="oimRcvSpcBrowseApp" type="button" class="btn xCNBtnBrowseAddOn" <?= $aResult['rtCode'] == 1 ? 'disabled' : ''; ?>><img class="xCNIconFind"></button> -->
                        <button id="oimRcvSpcBrowseApp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="ohdRcvSpc">
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- กลุ่มตัวแทน -->
            <div class="form-group <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBrwAgg'); ?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcAggCode" name="oetRcvSpcAggCode" value="<?php echo @$tRcvSpcAggCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcAggName" name="oetRcvSpcAggName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdeAgg'); ?>" value="<?php echo @$tRcvSpcAggName; ?>" readonly>
                    <span class="input-group-btn">
                        <button id="oimRcvSpcBrowseAgg" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="ohdRcvAgg">
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- สาขา -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBrwBch'); ?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcBchCode" name="oetRcvSpcBchCode" value="<?php echo @$tRcvSpcBchCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcBchName" name="oetRcvSpcBchName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdeBch'); ?>" value="<?php echo @$tRcvSpcBchName; ?>" data-validate="<?php echo  language('payment/recivespc/recivespc', 'tRCVSPCValidBchName'); ?>" readonly>
                    <span class="input-group-btn">
                        <button id="oimRcvSpcBrowseBch" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="ohdRcvSpcBch">
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- กลุ่มธุรกิจ -->
            <div class="form-group <?php if( !FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBrwMer'); ?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcMerCode" name="oetRcvSpcMerCode" value="<?php echo @$tRcvSpcMerCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcMerName" name="oetRcvSpcMerName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdeMer'); ?>" value="<?php echo @$tRcvSpcMerName; ?>" readonly>
                    <span class="input-group-btn">
                        <button id="oimRcvSpcBrowseMer" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="ohdRcvSpcMer">
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- ร้านค้า -->
            <div class="form-group <?php if( !FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBrwShp'); ?></label>
                <div class="input-group">

                    <input type="text" class="form-control xCNHide" id="ohdRcvSpcShpType" name="ohdRcvSpcShpType" value="<?php echo @$tRcvSpcShpType; ?>">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcShpCode" name="oetRcvSpcShpCode" value="<?php echo @$tRcvSpcShpCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcShpName" name="oetRcvSpcShpName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdeShp'); ?>" value="<?php echo @$tRcvSpcShpName; ?>" data-validate="<?php echo  language('payment/recivespc/recivespc', 'tRCVSPCValidShpName'); ?>" readonly>
                    <span class="input-group-btn">
                        <button id="oimRcvSpcBrowseShp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- <input type="hidden" id="ohdRcvSpcShp"> -->
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- จุดขาย -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdePos'); ?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcPosCode" name="oetRcvSpcPosCode" value="<?php echo @$tRcvSpcPosCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcPosName" name="oetRcvSpcPosName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdePos'); ?>" value="<?php echo @$tRcvSpcPosName; ?>" readonly>
                    <span class="input-group-btn">
                        <button id="oimRcvSpcBrowsePos" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- การเชื่อมต่อ -->
    <?php

    // if (!empty($aResultConfig)) {
    if ($nResultConfig > 0) {
    ?>
        <div class="row" id="odvRcvSpcConfigChk">
            <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnection'); ?></label>
                    <select class="form-control" id="oetRcvSpcConfig" name="oetRcvSpcConfig">
                        <?php
                        foreach ($aResultConfigSelect as $aVale) { ?>
                            <option value="<?php echo $aVale['FNRcvSeq']; ?>" <?php if ($aVale['FNRcvSeq'] ==  $tRcvSpcRcvSeq) {
                                                                                    echo 'selected';
                                                                                } ?>><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnection'); ?> <?php echo $aVale['FNRcvSeq']; ?></option>
                        <?php  } ?>
                    </select>
                </div>
            </div>
        </div>
    <?php }
    ?>
    <!-- หมายเหตุ -->
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?= language('payment/cardlogin/cardlogin', 'tCrdLRemark'); ?></label>
                <textarea class="form-group" rows="4" maxlength="50" id="oetRcvSpcRemark" name="oetRcvSpcRemark" autocomplete="off" placeholder="<?php echo language('payment/cardlogin/cardlogin', 'tCrdLRemark') ?>"><?php echo @$tRemark; ?></textarea>
            </div>
        </div>
    </div>

</form>
<?php /*include "script/jReciveSpcMain.php";*/ ?>
<link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/css/localcss/ada.component.css') ?>">
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>


<script>
    $(document).ready(function() {
        var tRcvSpcStaAlwCfg = $('#ohdtRcvSpcStaAlwCfg').val();
        // alert(tRcvSpcStaAlwCfg)
        $('#odvRcvSpcConfigChk').hide();
        $("#oetRcvSpcConfig").attr("disabled", true);
        if (tRcvSpcStaAlwCfg == 1) {
            $('#odvRcvSpcConfigChk').show();
            $("#oetRcvSpcConfig").attr("disabled", false);


        }
    });

    var tUsrLevel = '<?= $this->session->userdata('tSesUsrLevel') ?>';
    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";

    if (tUsrLevel == 'HQ') {
        // $("#oimRcvSpcBrowseBch").attr("disabled", true); //สาขา
        // $("#oimRcvSpcBrowseMer").attr("disabled", true); //ธุรกิจ
        $("#oimRcvSpcBrowseShp").attr("disabled", true);
        $("#oimRcvSpcBrowsePos").attr("disabled", true);
    } else {
        $("#oimRcvSpcBrowseAgg").attr("disabled", true); //ตัวแทน
        // $("#oimRcvSpcBrowseMer").attr("disabled", true); //ธุรกิจ
        $("#oimRcvSpcBrowseShp").attr("disabled", true); //ร้านค้า
        $("#oimRcvSpcBrowsePos").attr("disabled", true); //จุดขาย

        if(nCountBch == 1){
            $("#oimRcvSpcBrowseBch").attr("disabled", true); //สาขา
        }
    }

    $("#obtRcvSpcBrowseObj").attr("disabled", true);

    if ($('#oetRcvSpcBchCode').val() != '') {
        $("#oimRcvSpcBrowseMer").attr("disabled", false);
        $("#oimRcvSpcBrowseShp").attr("disabled", false);
        $("#oimRcvSpcBrowsePos").attr("disabled", false);
    }

    // if ( $('#oetRcvSpcBchCode').val() != '' ) {
    //     $("#oimRcvSpcBrowseShp").attr("disabled", false);
    // }

    // if ( $('#oetRcvSpcBchCode').val() != '' ) {
    //     $("#oimRcvSpcBrowsePos").attr("disabled", false);
    // }

    if( $('#oetRcvSpcAppCode').val() != '' ){
        $("#obtRcvSpcBrowseObj").attr("disabled", false);
    }

    // *******************************************************************************
    // ระบบ
    $('#oimRcvSpcBrowseApp').click(function() {
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowsetSysApp');
    });

    
    // หน้าจอ
    $('#obtRcvSpcBrowseObj').click(function() {
        JSxCheckPinMenuClose();
        oRcvSpcBrowseObjectOption = oBrowseObject({
            'tRcvSpcAppCode': $('#oetRcvSpcAppCode').val()
        });
        JCNxBrowseData('oRcvSpcBrowseObjectOption');
    });

    //สาขา
    $('#oimRcvSpcBrowseBch').click(function() {
        JSxCheckPinMenuClose();
        oRcvSpcBrwOption = oBrowseBranch({
            'tHiddenRcvSpc': $('#ohdRcvAgg').val()
        });
        JCNxBrowseData('oRcvSpcBrwOption');
    });

    // กลุ่มธุรกิจ
    $('#oimRcvSpcBrowseMer').click(function() {
        JSxCheckPinMenuClose();
        oRcvSpcBchBrwOption = oBrowseMer({
            'tHiddenRcvSpcMer': $('#ohdRcvSpcBch').val()
        });
        JCNxBrowseData('oRcvSpcBchBrwOption');
    });

    // ร้านค้า
    $('#oimRcvSpcBrowseShp').click(function() {
        JSxCheckPinMenuClose();
        oRcvSpcMerBrwOption = oBrowseShop({
            'tHiddenRcvSpcShp': $('#ohdRcvSpcMer').val()
        });
        JCNxBrowseData('oRcvSpcMerBrwOption');
    });

    // กลุ่มตัวแทน
    $('#oimRcvSpcBrowseAgg').click(function() {
        JSxCheckPinMenuClose();
        oRcvSpcShpBrwOption = oBrowseAgg({
            'tHiddenRcvSpcAgg': $('#ohdRcvSpc').val()
        });
        JCNxBrowseData('oRcvSpcShpBrwOption');
    });

    // จุดขาย
    $('#oimRcvSpcBrowsePos').click(function() {
        JSxCheckPinMenuClose();
        oRcvSpcShpBrwOption = oBrowsePos({
            'tHiddenRcvSpcPos': $('#ohdRcvSpcPos').val()
        });
        JCNxBrowseData('oRcvSpcShpBrwOption');
    });

    // ระบบ
    var oBrowsetSysApp = {
        Title: ['payment/recivespc/recivespc', 'tBrowseAppTitle'],
        Table: {
            Master: 'TSysApp',
            PK: 'FTAppCode'
        },
        Join: {
            Table: ['TSysApp_L'],
            On: ['TSysApp_L.FTAppCode = TSysApp.FTAppCode AND TSysApp_L.FNLngID =' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'payment/recivespc/recivespc',
            ColumnKeyLang: ['tBrowseAppCode', 'tBrowseAppName'],
            ColumnsSize: ['15%', '75%'],
            DataColumns: ['TSysApp.FTAppCode', 'TSysApp_L.FTAppName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TSysApp.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRcvSpcAppCode", "TSysApp.FTAppCode"],
            Text: ["oetRcvSpcAppName", "TSysApp_L.FTAppName"]
        },
        NextFunc: {
            FuncName: 'JSxNextFuncRcvSpcApp',
            ArgReturn: ['FTAppCode']
        },
    };

    function JSxNextFuncRcvSpcApp(paDataReturn){
        if( paDataReturn != 'NULL' ){
            $('#obtRcvSpcBrowseObj').attr('disabled',false);
        }else{
            $('#obtRcvSpcBrowseObj').attr('disabled',true);
        }

        $('#oetRcvSpcObjCode').val('');
        $('#oetRcvSpcObjName').val('');

        // $("#oimRcvSpcBrowseAgg").attr("disabled", true);  //ตัวแทน
        // $("#oimRcvSpcBrowseBch").attr("disabled", true);  //สาขา
        // $("#oimRcvSpcBrowseMer").attr("disabled", true);  //ธุรกิจ
        // $("#oimRcvSpcBrowseShp").attr("disabled", true);
        // $("#oimRcvSpcBrowsePos").attr("disabled", true);
        // // console.log('JSxNextFuncRcvSpc Clear Data');
        // // console.log(paDataReturn);
        // if(paDataReturn != 'NULL'){
        //     var aRcvSpc = JSON.parse(paDataReturn);
        //     $("#oimRcvSpcBrowseAgg").attr("disabled",false);
        //     $('#ohdRcvSpc').val(aRcvSpc[0]);
        // } else {
        //     $('#ohdRcvSpc').val('');
        // }

        // $('#oetRcvSpcBchCode').val('');
        // $('#oetRcvSpcBchName').val('');

        // $('#oetRcvSpcMerCode').val('');
        // $('#oetRcvSpcMerName').val('');

        // $('#oetRcvSpcShpCode').val('');
        // $('#oetRcvSpcShpName').val('');

        // $('#oetRcvSpcAggCode').val('');
        // $('#oetRcvSpcAggName').val('');
    }

    

    // หน้าจอ
    var oBrowseObject = function(poDataFnc) {
        var tRcvSpcAppCode = poDataFnc.tRcvSpcAppCode;
        var tWhere = '';

        if ( tRcvSpcAppCode != '' ) {
            tWhere += " AND TCNSListObj.FTAppode = '"+tRcvSpcAppCode+"' "
        }

        var oOptionReturn = {
            Title: ['payment/recivespc/recivespc', 'tRCVSpcObj'],
            Table: {
                Master: 'TCNSListObj',
                PK: 'FTObjCode'
            },
            Join: {
                Table: ['TCNSListObj_L'],
                On: ['TCNSListObj_L.FTObjCode = TCNSListObj.FTObjCode AND TCNSListObj_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [ tWhere ]
            },
            GrideView: {
                ColumnPathLang: 'payment/recivespc/recivespc',
                ColumnKeyLang: ['tRCVSpcObjCode', 'tRCVSpcObjName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNSListObj.FTObjCode', 'TCNSListObj_L.FTObjName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNSListObj.FTObjCode ASC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetRcvSpcObjCode", "TCNSListObj.FTObjCode"],
                Text: ["oetRcvSpcObjName", "TCNSListObj_L.FTObjName"]
            },
            // NextFunc: {
            //     FuncName: 'JSxNextFuncRcvSpcBch',
            //     ArgReturn: ['FTObjCode']
            // },
        };
        return oOptionReturn;
    }

    // สาขา
    var oBrowseBranch = function(poDataFnc) {
        var tWhereModal = poDataFnc.tHiddenRcvSpc;
        var tWhere = '';
        var nAggCode = $('#oetRcvSpcAggCode').val();
        if (nAggCode != '') {
            tWhere = ' AND TCNMBranch.FTAgnCode = ' + nAggCode + ' '
        }

        var oOptionReturn = {
            Title: ['authen/user/user', 'tBrowseBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: ['AND 1=1 ' + tWhere + ' ']
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FTBchCode DESC'],
                // SourceOrder	: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetRcvSpcBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetRcvSpcBchName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxNextFuncRcvSpcBch',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: nStaRcvBrowseType
        };
        return oOptionReturn;
    }

    function JSxNextFuncRcvSpcBch(paDataReturn) {
        if (paDataReturn != 'NULL') {
            var aRcvSpcBch = JSON.parse(paDataReturn);
            
            $('#ohdRcvSpcBch').val(aRcvSpcBch[0]);

            // if ($('#ohdRcvSpcIsShpEnabled').val() == '0') {
            //     $("#oimRcvSpcBrowseAgg").attr("disabled", false);
            // }
            // if ($('#oetRcvSpcMerCode').val() != '') {
            //     $("#oimRcvSpcBrowseShp").attr("disabled", false);
            // }

            $("#oimRcvSpcBrowseShp").attr("disabled", false); // หลังเลือกสาขาให้เปิด browse shop
            $('#oimRcvSpcBrowsePos').attr("disabled", false); // หลังเลือกสาขาให้เปิด browse pos
        } else {

            $("#oimRcvSpcBrowseShp").attr("disabled", true); // ถ้ายกเลิกการเลือกสาขาให้ปิด browse shop
            $('#oimRcvSpcBrowsePos').attr("disabled", true); // ถ้ายกเลิกการเลือกสาขาให้ปิด browse pos

            $('#ohdRcvSpcBch').val('');
        }

        $('#oetRcvSpcShpCode').val('');
        $('#oetRcvSpcShpName').val('');

        $('#oetRcvSpcPosCode').val('');
        $('#oetRcvSpcPosName').val('');

    }

    // Option กลุ่มธุรกิจ
    var oBrowseMer = function(poDataFnc) {
        var tWhereModal = poDataFnc.tHiddenRcvSpcMer;
        var tWhere = "";
        var nBchCode = $('#oetRcvSpcBchCode').val();

        // if(nBchCode != '')
        // if (typeof(nBchCode) != undefined && nBchCode != "") {
        //     tWhere += " AND ((SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '" + nBchCode + "') != 0)";
        // }
        var oOptionReturn = {
            Title: ['company/merchant/merchant', 'tMerchantTitle'],
            Table: {
                Master: 'TCNMMerchant',
                PK: 'FTMerCode'
            },
            Join: {
                Table: ['TCNMMerchant_L'],
                On: ['TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits, ]
            },
            Where: {
                Condition: [tWhere]
            },
            GrideView: {
                ColumnPathLang: 'company/merchant/merchant',
                ColumnKeyLang: ['tMerCode', 'tMerName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                DataColumnsFormat: ['', ''],
                // Perpage			: 5,
                // OrderBy			: ['TCNMMerchant_L.FTMerName'],
                // SourceOrder		: "ASC"
                Perpage: 10,
                OrderBy: ['TCNMMerchant.FDCreateOn DESC'],

            },
            // DebugSQL: true,
            CallBack: {
                ReturnType: 'S',
                Value: ["oetRcvSpcMerCode", "TCNMMerchant.FTMerCode"],
                Text: ["oetRcvSpcMerName", "TCNMMerchant_L.FTMerName"],
            },
            NextFunc: {
                FuncName: 'JSxNextFuncRcvSpcMer',
                ArgReturn: ['FTMerCode']
            },
            // RouteFrom : 'shop',
            RouteAddNew: 'merchant',
            BrowseLev: nStaRcvBrowseType
        };
        return oOptionReturn;
    }

    function JSxNextFuncRcvSpcMer(paDataReturn) {
        $("#oimRcvSpcBrowseShp").attr("disabled", true);
        // $("#oimRcvSpcBrowseAgg").attr("disabled", true);
        if (paDataReturn != 'NULL') {
            var aRcvSpcMer = JSON.parse(paDataReturn);
            $("#oimRcvSpcBrowseShp").attr("disabled", false);
            $('#ohdRcvSpcMer').val(aRcvSpcMer[0]);
        } else {
            $('#ohdRcvSpcMer').val('');
            $("#oimRcvSpcBrowsePos").attr("disabled", true);
        }

        $('#oetRcvSpcShpCode').val('');
        $('#oetRcvSpcShpName').val('');

        $('#oetRcvSpcPosCode').val('');
        $('#oetRcvSpcPosName').val('');

        // $('#oetRcvSpcAggCode').val('');
        // $('#oetRcvSpcAggName').val('');

    }

    //ร้านค้า
    var oBrowseShop = function(poDataFnc) {
        var tWhereModal = poDataFnc.tHiddenRcvSpcShp;
        var nBchCode = $('#oetRcvSpcBchCode').val();
        var nMerCode = $('#oetRcvSpcMerCode').val();
        var tWhereBchCode = '';
        var tWhereMerCode = '';
        if (nBchCode != '') {
            tWhereBchCode = ' AND TCNMShop.FTBchCode = ' + nBchCode + ' '
        }

        if (nMerCode != '') {
            tWhereMerCode = ' AND TCNMShop.FTMerCode = ' + nMerCode + ' '
        }
        var oOptionReturn = {
            Title: ['authen/user/user', 'tBrowseSHPTitle'],
            Table: {
                Master: 'TCNMShop',
                PK: 'FTShpCode'
            },
            Join: {
                Table: ['TCNMShop_L'],
                On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: ['AND 1=1 ' + tWhereBchCode + tWhereMerCode + ' ']
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseSHPCode', 'tBrowseSHPName'],
                ColumnsSize: ['10%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTShpType'],
                DisabledColumns: [2],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMShop.FDCreateOn DESC'],
                // OrderBy			: ['TCNMShop.FTShpCode'],
                // SourceOrder		: "ASC"
            },
            //  DebugSQL: true,
            CallBack: {
                StaSingItem: '1',
                ReturnType: 'S',
                Value: ["oetRcvSpcShpCode", "TCNMShop.FTShpCode"],
                Text: ["oetRcvSpcShpName", "TCNMShop_L.FTShpName"]
            },
            NextFunc: {
                FuncName: 'JSxNextFuncRcvSpcShp',
                ArgReturn: ['FTShpCode', 'FTShpType']
            },
            // RouteAddNew: 'shop',
            // BrowseLev: nStaRcvBrowseType
        };
        return oOptionReturn;
    }
    // var nShpType = '';

    function JSxNextFuncRcvSpcShp(paDataReturn) {

        $("#oimRcvSpcBrowsePos").attr("disabled", true);
        if (paDataReturn != 'NULL') {
            var aRcvSpcShp = JSON.parse(paDataReturn);
            $("#oimRcvSpcBrowsePos").attr("disabled", false);
            $('#ohdRcvSpcShp').val(aRcvSpcShp[0]);

            $('#ohdRcvSpcShpType').val(aRcvSpcShp[1]);
            // alert(nShpType);
        } else {
            $('#ohdRcvSpcShp').val('');
        }
        $('#oetRcvSpcPosCode').val('');
        $('#oetRcvSpcPosName').val('');


    }

    // *******************************************************************************



    //กลุ่มตัวแทน
    var oBrowseAgg = function(poDataFnc) {
        var tWhereModal = poDataFnc.tHiddenRcvSpcAgg;
        var oOptionReturn = {
            Title: ['payment/recivespc/recivespc', 'tBrowseAggGrp'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID =' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'payment/recivespc/recivespc',
                ColumnKeyLang: ['tBrowseAggCode', 'tBrowseAggName'],
                ColumnsSize: ['15%', '75%'],
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMAgency.FDCreateOn DESC'],
                // SourceOrder	: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetRcvSpcAggCode", "TCNMAgency.FTAgnCode"],
                Text: ["oetRcvSpcAggName", "TCNMAgency_L.FTAgnName"]
            },
            NextFunc: {
                FuncName: 'JSxNextFuncRcvAgg',
                ArgReturn: ['FTAgnCode']
            },
        };
        return oOptionReturn;
    }

    function JSxNextFuncRcvAgg(paDataReturn) {
        $("#oimRcvSpcBrowseBch").attr("disabled", true); //สาขา
        $("#oimRcvSpcBrowseMer").attr("disabled", true); //ธุรกิจ
        $("#oimRcvSpcBrowseShp").attr("disabled", true);
        $("#oimRcvSpcBrowsePos").attr("disabled", true);
        // console.log('JSxNextFuncRcvSpc Clear Data');
        // console.log(paDataReturn);
        if (paDataReturn != 'NULL') {
            var aRcvSpc = JSON.parse(paDataReturn);
            $("#oimRcvSpcBrowseBch").attr("disabled", false);
            $('#ohdRcvAgg').val(aRcvSpc[0]);
        } else {
            $('#ohdRcvAgg').val('');
        }

        $('#oetRcvSpcBchCode').val('');
        $('#oetRcvSpcBchName').val('');

        $('#oetRcvSpcMerCode').val('');
        $('#oetRcvSpcMerName').val('');

        $('#oetRcvSpcShpCode').val('');
        $('#oetRcvSpcShpName').val('');

    }

    // Browse Pos (เครื่องจุดขาย) 
    var oBrowsePos = function(poDataFnc) {
        var tWhereModal = poDataFnc.tHiddenRcvSpcPos;
        var nBchCode = $('#oetRcvSpcBchCode').val();
        var nShpCode = $('#oetRcvSpcShpCode').val();
        var tWhereBch = '';
        var tWhereShp = '';
        var nShpType = $('#ohdRcvSpcShpType').val();
        // alert(nShpType)

        if (nShpCode != '' && nBchCode != '') {
            if (nShpType == 4) {
                if (nBchCode != '') {
                    tWhereBch = ' AND TCNMPos.FTBchCode = ' + nBchCode + ' '
                }
                var oOptionReturn = {
                    Title: ['company/warehouse/warehouse', 'tSalemachinePOS'],
                    Table: {
                        Master: 'TCNMPos',
                        PK: 'FTPosCode'
                    },
                    Join: {
                        Table: ['TCNMPos_L'],
                        On: ['TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos.FTBchCode = TCNMPos_L.FTBchCode AND TCNMPos_L.FNLngID =' + nLangEdits]
                    },
                    Where: {
                        Condition: ["AND 1 = '1' " + tWhereBch]
                    },
                    GrideView: {
                        ColumnPathLang: 'pos/salemachine/salemachine',
                        ColumnKeyLang: ['tPOSCode', 'tPOSName'],
                        ColumnsSize: ['15%', '75%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMPos.FTPosCode', 'TCNMPos_L.FTPosName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 5,
                        OrderBy: ['TCNMPos.FTPosCode'],
                        SourceOrder: "ASC"
                    },
                    // DebugSQL: true,
                    CallBack: {
                        ReturnType: 'S',
                        Value: ["oetRcvSpcPosCode", "TCNMPos.FTPosCode"],
                        Text: ["oetRcvSpcPosName", "TCNMPos_L.FTPosName"],
                    },
                    // RouteAddNew: 'salemachine',
                    // BrowseLev: nStaZneBrowseType
                };
            } else if (nShpType == 5) {
                if (nBchCode != '') {
                    tWhereBch = ' AND TRTMShopPos.FTBchCode = ' + nBchCode + ' '
                }
                var oOptionReturn = {
                    Title: ['company/warehouse/warehouse', 'tSalemachinePOS'],
                    Table: {
                        Master: 'TRTMShopPos',
                        PK: 'FTPosCode'
                    },
                    Join: {
                        Table: ['TCNMPos_L'],
                        On: ['TCNMPos_L.FTPosCode = TRTMShopPos.FTPosCode AND TRTMShopPos.FTBchCode = TCNMPos_L.FTBchCode AND TCNMPos_L.FNLngID =' + nLangEdits]
                    },
                    Where: {
                        Condition: ["AND 1 = '1' " + tWhereBch]
                    },
                    GrideView: {
                        ColumnPathLang: 'pos/salemachine/salemachine',
                        ColumnKeyLang: ['tPOSCode', 'tPOSName'],
                        ColumnsSize: ['15%', '75%'],
                        WidthModal: 50,
                        DataColumns: ['TRTMShopPos.FTPosCode', 'TCNMPos_L.FTPosName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 5,
                        OrderBy: ['TRTMShopPos.FTPosCode'],
                        SourceOrder: "ASC"
                    },
                    // DebugSQL: true,
                    CallBack: {
                        ReturnType: 'S',
                        Value: ["oetRcvSpcPosCode", "TRTMShopPos.FTPosCode"],
                        Text: ["oetRcvSpcPosName", "TCNMPos_L.FTPosName"],
                    },
                    // RouteAddNew: 'salemachine',
                    // BrowseLev: nStaZneBrowseType
                };
            } else {
                if (nBchCode != '') {
                    tWhereBch = ' AND TCNMPos.FTBchCode = ' + nBchCode + ' '
                }
                var oOptionReturn = {
                    Title: ['company/warehouse/warehouse', 'tSalemachinePOS'],
                    Table: {
                        Master: 'TCNMPos',
                        PK: 'FTPosCode'
                    },
                    Join: {
                        Table: ['TCNMPos_L'],
                        On: ['TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos.FTBchCode = TCNMPos_L.FTBchCode AND TCNMPos_L.FNLngID =' + nLangEdits]
                    },
                    Where: {
                        Condition: ["AND 1 = '1' " + tWhereBch]
                    },
                    GrideView: {
                        ColumnPathLang: 'pos/salemachine/salemachine',
                        ColumnKeyLang: ['tPOSCode', 'tPOSName'],
                        ColumnsSize: ['15%', '75%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMPos.FTPosCode', 'TCNMPos_L.FTPosName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 5,
                        OrderBy: ['TCNMPos.FTPosCode'],
                        SourceOrder: "ASC"
                    },
                    // DebugSQL: true,
                    CallBack: {
                        ReturnType: 'S',
                        Value: ["oetRcvSpcPosCode", "TCNMPos.FTPosCode"],
                        Text: ["oetRcvSpcPosName", "TCNMPos_L.FTPosName"],
                    },
                    // RouteAddNew: 'salemachine',
                    // BrowseLev: nStaZneBrowseType
                };
            }
        } else {
            if (nBchCode != '') {
                tWhereBch = ' AND TCNMPos.FTBchCode = ' + nBchCode + ' '
            }
            var oOptionReturn = {
                Title: ['company/warehouse/warehouse', 'tSalemachinePOS'],
                Table: {
                    Master: 'TCNMPos',
                    PK: 'FTPosCode'
                },
                Join: {
                    Table: ['TCNMPos_L'],
                    On: ['TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos.FTBchCode = TCNMPos_L.FTBchCode AND TCNMPos_L.FNLngID =' + nLangEdits]
                },
                Where: {
                    Condition: ["AND 1 = '1' " + tWhereBch]
                },
                GrideView: {
                    ColumnPathLang: 'pos/salemachine/salemachine',
                    ColumnKeyLang: ['tPOSCode', 'tPOSName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMPos.FTPosCode', 'TCNMPos_L.FTPosName'],
                    DataColumnsFormat: ['', ''],
                    Perpage: 5,
                    OrderBy: ['TCNMPos.FTPosCode'],
                    SourceOrder: "ASC"
                },
                // DebugSQL: true,
                CallBack: {
                    ReturnType: 'S',
                    Value: ["oetRcvSpcPosCode", "TCNMPos.FTPosCode"],
                    Text: ["oetRcvSpcPosName", "TCNMPos_L.FTPosName"],
                },
                // RouteAddNew: 'salemachine',
                // BrowseLev: nStaZneBrowseType
            };
        }


        return oOptionReturn;
    }

    //Functionality : Add Data Agency Add/Edit  
    //Parameters : from ofmAddEditCrdLogin
    //Creator : 04/07/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSxRcvSpvSaveAddEdit(ptRoute) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // console.log([$('#oetRcvSpcAppCode').val(), $('#oetRcvSpcBchCode').val()]);
            $('#ofmAddEditRcvSpc').validate().destroy();
            $('#ofmAddEditRcvSpc').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    // oetRcvSpcAppName: {
                    //     "required": {}
                    // },
                },
                messages: {
                    // oetRcvSpcAppName: {
                    //     "required": $('#oetRcvSpcAppName').attr('data-validate'),
                    // }
                },
                errorElement: "em",
                errorPlacement: function(error, element) {
                    error.addClass("help-block");
                    if (element.prop("type") === "checkbox") {
                        error.appendTo(element.parent("label"));
                    } else {
                        var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                        if (tCheck == 0) {
                            error.appendTo(element.closest('.form-group')).trigger('change');
                        }
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                },
                submitHandler: function(form) {
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: ptRoute,
                        data: $('#ofmAddEditRcvSpc').serialize(),
                        catch: false,
                        timeout: 0,
                        success: function(tResult) {
                            // console.log(tResult);
                            var aData = JSON.parse(tResult);
                            if (aData["nStaEvent"] == 1) {
                                JSxRcvSpcGetContent();
                                JCNxCloseLoading();
                            } else if (aData["nStaEvent"] == 900) {
                                JCNxCloseLoading();
                                var tMsgErrorFunction = aData['tStaMessg'];
                                FSvCMNSetMsgErrorDialog('<p class="text-left">' + tMsgErrorFunction + '</p>');
                            } else {
                                var tMsgErrorFunction = aData['tStaMessg'];
                                FSvCMNSetMsgErrorDialog('<p class="text-left">' + tMsgErrorFunction + '</p>');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                },
            });
        }
    }

</script>
