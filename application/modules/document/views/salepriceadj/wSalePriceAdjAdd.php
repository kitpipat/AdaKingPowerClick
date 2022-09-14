<?php
date_default_timezone_set("Asia/Bangkok");
if (isset($nStaAddOrEdit) && $nStaAddOrEdit == 1) {
    $tRoute         = "dcmSPAEventEdit";
    $tBchCode       = $aSpaData['raItems']['FTBchCode'];
    $tMerCode       = '';
    $tMerName       = $aSpaData['raItems']['FTMerName'];
    $tXphDocNo      = $aSpaData['raItems']['FTXphDocNo'];
    $tXphDocType    = $aSpaData['raItems']['FTXphDocType'];
    $tXphStaAdj     = $aSpaData['raItems']['FTXphStaAdj'];
    $dXphDocDate    = $aSpaData['raItems']['FDXphDocDate'];
    $tXphDocTime    = $aSpaData['raItems']['FTXphDocTime'];
    $tXphRefInt     = $aSpaData['raItems']['FTXphRefInt'];
    $dXphRefIntDate = $aSpaData['raItems']['FDXphRefIntDate'];
    $tXphName       = $aSpaData['raItems']['FTXphName'];
    $tPplCode       = $aSpaData['raItems']['FTPplCode'];
    $tPplName       = $aSpaData['raItems']['FTPplName'];
    $tAggCode       = '';
    $tAggName       = $aSpaData['raItems']['FTAggName'];
    $dXphDStart     = $aSpaData['raItems']['FDXphDStart'];
    $tXphTStart     = $aSpaData['raItems']['FTXphTStart'];
    $dXphDStop      = $aSpaData['raItems']['FDXphDStop'];
    $tXphTStop      = $aSpaData['raItems']['FTXphTStop'];
    $tXphPriType    = $aSpaData['raItems']['FTXphPriType'];
    $tXphStaDoc     = $aSpaData['raItems']['FTXphStaDoc'];
    $tXphStaPrcDoc  = $aSpaData['raItems']['FTXphStaPrcDoc'];
    $nXphStaDocAct  = $aSpaData['raItems']['FNXphStaDocAct'];
    $tUsrCode       = $aSpaData['raItems']['FTUsrCode'];
    $tXphUsrApv     = $aSpaData['raItems']['FTXphUsrApv'];
    $tXphStaApv     = $aSpaData['raItems']['FTXphStaApv'];   //เปลี่ยนจาก FTXphUsrApv เป็น FTXphStaApv เนื่องจากตอนแรกไม่มี ฟิลส์ FTXphStaApv [ Napat(Jame) 05-09-2019 ]
    $tXphZneTo      = '';
    $tXphZneToName  = $aSpaData['raItems']['FTZneName'];
    $tXphBchTo      = '';
    $tXphBchToName  = $aSpaData['raItems']['FTBchName'];
    $tXphRmk        = $aSpaData['raItems']['FTXphRmk'];
    $dLastUpdOn     = $aSpaData['raItems']['FDLastUpdOn'];
    $tLastUpdBy     = $aSpaData['raItems']['FTLastUpdBy'];
    $dCreateOn      = $aSpaData['raItems']['FDCreateOn'];
    $tCreateBy      = $aSpaData['raItems']['FTCreateBy'];
    $tUsrNameCreateBy = $aSpaData['raItems']['FTUsrName'];
    $tXphStaDelMQ   = $aSpaData['raItems']['FTXphStaDelMQ'];
    $tXphMerCode    = '';
    $tXphMerName    = $aSpaData['raItems']['FTMerName'];
    $nLngID         = $nLngID;

    $dXphDStopyear  = date('Y-m-d', strtotime("+1 year"));
    // Create By Witsarut 27/08/2019
    if (isset($aResList['raItems']['rtCmpCode'])) {
        $tCmpCode  = $aResList['raItems']['rtCmpCode'];
    } else {
        $tCmpCode  = '';
    }

    // Create By Witsarut 27/08/2019

    if ($tXphStaApv == "") {
        $tTextApv = language('document/salepriceadj/salepriceadj', 'tSpaXphUsrApv');
    } else {
        $tTextApv = language('document/salepriceadj/salepriceadj', 'tSpaXphUsrApv1');
    }
    $tAgnCode               = $this->session->userdata("tSesUsrAgnCode");
} else {

    $tRoute         = "dcmSPAEventAdd";
    $tBchCode       = "";
    $tMerCode       = "";
    $tMerName       = "";
    $tXphDocNo      = "";
    $tXphDocType    = "";
    $tXphStaAdj     = "";
    $dXphDocDate    = date('Y-m-d');
    $tXphDocTime    = date('H:i:s');
    $tXphRefInt     = "";
    $dXphRefIntDate = "";
    $tXphName       = "";
    $tPplCode       = "";
    $tPplName       = "";
    $tAggCode       = "";
    $tAggName       = "";
    $dXphDStart     = date('Y-m-d');
    $tXphTStart     = date('00:00:01');
    $dXphDStop      = date('Y-m-d', strtotime("+1 year"));
    $tXphTStop      = date('23:59:59');
    $tXphPriType    = "";
    $tXphStaDoc     = "N/A";
    $tXphStaPrcDoc  = "";
    $nXphStaDocAct  = "";
    $tUsrCode       = "";
    $tXphUsrApv     = "N/A";
    $tXphStaApv     = "";
    $tXphZneTo      = "";
    $tXphZneToName  = "";
    $tXphBchTo      = "";
    $tXphBchToName  = "";
    $tXphRmk        = "";
    $dLastUpdOn     = "";
    $tLastUpdBy     = "";
    $dCreateOn      = "";
    $tUsrNameCreateBy = $this->session->userdata('tSesUsrUsername');
    $tCreateBy        = $this->session->userdata("tSesUsername");
    $tXphStaDelMQ   = "";
    $nLngID         = "";
    $tTextApv       = language('document/salepriceadj/salepriceadj', 'tSpaXphUsrApv');
    $dXphDStopyear  = date('Y-m-d', strtotime("+1 year"));
    // Create By Witsarut 27/08/2019
    if (isset($aResList['raItems']['rtCmpCode'])) {
        $tCmpCode  = $aResList['raItems']['rtCmpCode'];
    } else {
        $tCmpCode  = '';
    }
    // Create By Witsarut 27/08/2019

    // if($this->session->userdata("tSesUsrLevel") == "BCH" || $this->session->userdata("tSesUsrLevel") == "SHP"){
    //     $tXphBchTo          = $this->session->userdata("tSesUsrBchCode");
    //     $tXphBchToName      = $this->session->userdata("tSesUsrBchName");
    // }
    // if($this->session->userdata("tSesUsrLevel") == "HQ"){
    //     $tXphBchTo          = FCNtGetBchInComp();
    //     $tXphBchToName      = FCNtGetBchNameInComp();
    // }

    $tXphMerCode = $this->session->userdata('tSesUsrMerCode');
    $tXphMerName = $this->session->userdata('tSesUsrMerName');
    $tAgnCode               = $this->session->userdata("tSesUsrAgnCode");
    $tSaleAdjBchCompCode      = $tBchCompCode;
    $tSaleAdjBchCompName      = $tBchCompName;
}

$aParams = [
    "aFieldName" => ['FTBchCode', 'FTPosCode'],
    "tUserSessionID" => "1234",
    "tTableName" => "TCNMPos"
];
// FCNnMasTmpChkCodeMultiDupInDB($aParams);

$aParams = [
    "aFieldName" => ['FTPdtCode', 'FTPunCode'],
    "tUserSessionID" => "0000120200710085938",
    "tTableName" => "TCNMPdtPackSize"
];
// FCNnDocTmpChkCodeMultiInDB($aParams);
$nDecimalShow =  FCNxHGetOptionDecimalShow();


$tUsrLevel 				= $this->session->userdata('tSesUsrLevel');
if($tUsrLevel == 'SHP'){
    $tUserMchCode 			= $this->session->userdata('tSesUsrMerCode');
    $tUserMchName 			= $this->session->userdata('tSesUsrMerName');
}else{
    $tUserMchCode 			= "";
    $tUserMchName 			= "";
}

if($tUsrLevel == 'SHP'){
    $tUserShpCode 			= $this->session->userdata('tSesUsrShpCodeDefault');
    $tUserShpName 			= $this->session->userdata('tSesUsrShpNameDefault');
}else{
    $tUserShpCode 			= "";
    $tUserShpName 			= "";
}

$tWahCodeFrom 			= "";
$tWahNameFrom 			= "";

$tUserBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
$tUserBchName = $this->session->userdata('tSesUsrBchNameDefault');
?>


<input type="hidden" id="ohdDateStop" value="<?php echo $dXphDStopyear; ?>">
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddSpa">
    <input type="hidden" id="ohdBaseUrl" name="ohdBaseUrl" value="<?php echo base_url(); ?>">
    <input type="text" class="xCNHide" id="oetLangCode" value="<?= $nLngID ?>">
    <input type="text" class="xCNHide" id="oetUsrCode" name="oetUsrCode" value="<?= $tUsrCode ?>">
    <input type="text" class="xCNHide" id="oetSPAFitstPdtCode" name="oetSPAFitstPdtCode" value="">
    <input type="text" class="xCNHide" id="oetBchCodeMulti" name="oetBchCodeMulti" value="<?php if ($this->session->userdata('tSesUsrLevel') != 'HQ') {
                                                                                                echo str_replace("'", "", $this->session->userdata('tSesUsrBchCodeMulti'));
                                                                                            } ?>">
    <input type="text" class="xCNHide" id="ohdCompCode" name="ohdCompCode" value="<?= $tCmpCode ?>">
    <input type="text" class="xCNHide" id="oetStaPrcDoc" name="oetStaPrcDoc" value="<?= $tXphStaPrcDoc ?>">
    <input type="text" class="xCNHide" id="oetStaDelQname" name="oetStaDelQname" value="<?= $tXphStaDelMQ; ?>">
    <input type="text" class="xCNHide" id="oetXthApvCodeUsrLogin" name="oetXthApvCodeUsrLogin" maxlength="20" value="<?php echo $this->session->userdata('tSesUsername'); ?>">
    <input type="text" class="xCNHide" id="ohdLangEdit" name="ohdLangEdit" maxlength="1" value="<?php echo $this->session->userdata("tLangEdit"); ?>">
    <input type="text" class="xCNHide" id="ohdXphStaApv" name="ohdXphStaApv" value="<?= $tXphStaApv ?>">
    <input type="hidden" class="xCNHide" id="nDecimalShow" name="nDecimalShow" value="<?= $nDecimalShow ?>">
    <input type="hidden" id="ohdTextValidate" validatedateimpact="<?php echo language('document/salepriceadj/salepriceadj', 'tSpaValidDateStrImpact'); ?>" validatepdrcode="<?php echo language('document/salepriceadj/salepriceadj', 'tSpaValidXphPdtCode'); ?>" validatevalue="<?php echo language('document/salepriceadj/salepriceadj', 'tSpaValidXphPdtValue'); ?>">

    <button style="display:none" type="submit" id="obtSubmitSpa" onclick="JSoAddEditSpa('<?= $tRoute ?>')"></button>
    <div class="row">
        <div class="col-md-4">

            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/salepriceadj/salepriceadj', 'tSpaADDDocTitle'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvDataDoc" class="panel-collapse collapse in" role="tabpanel" style="margin-top:10px;">
                    <div class="panel-body xCNPDModlue">

                        <div class="form-group xWAutoGenerate">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbStaAutoGenCode" name="ocbStaAutoGenCode" maxlength="1" checked>
                                <span class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDAutoGen'); ?></span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphDocNo'); ?></label>
                            <input type="text" class="form-control xCNGenarateCodeTextInputValidate xCNInputWithoutSpcNotThai" id="oetXphDocNo" name="oetXphDocNo" maxlength="20" value="<?= $tXphDocNo; ?>" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tSpaValidXphDocNo'); ?>" placeholder="<?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphDocNo'); ?>">
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphDocDate'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXphDocDate" name="oetXphDocDate" autocomplete="off" value="<?= $dXphDocDate; ?>" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tSpaValidXphDocDate'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtXphDocDate" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphDocTime'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNTimePicker xCNInputMaskDate" id="oetXphDocTime" name="oetXphDocTime" autocomplete="off" value="<?= $tXphDocTime; ?>" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tSpaValidXphDocTime'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtXphDocTime" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDCreateBy'); ?></label>
                            </div>
                            <div class="col-md-6 text-right">
                                <input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?= $tCreateBy ?>">
                                <label><?= $tUsrNameCreateBy ?></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="xCNLabelFrm"><?php echo language('document/salepriceadj/salepriceadj', 'tSpaADDXphStaDoc'); ?></label>
                            </div>
                            <div class="col-md-6 text-right">
                                <input type="text" class="xCNHide" id="oetStaDoc" name="oetStaDoc" value="<?= $tXphStaDoc ?>">
                                <label><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphStaDocn' . $tXphStaDoc); ?></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="xCNLabelFrm"><?php echo language('document/salepriceadj/salepriceadj', 'tTBSpaXphUsrApv'); ?></label>
                            </div>
                            <div class="col-md-6 text-right">
                                <input type="text" class="xCNHide" id="oetStaApv" name="oetStaApv" value="<?= $tXphStaApv ?>">
                                <input type="text" class="xCNHide" id="oetUsrApv" name="oetUsrApv" value="<?= $tXphUsrApv ?>">
                                <label><?= $tTextApv ?></label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/salepriceadj/salepriceadj', 'tSpaADDConditionsTitle'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataConditions" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvDataConditions" class="panel-collapse collapse in" role="tabpanel" style="margin-top:10px;">
                    <div class="panel-body xCNPDModlue">
                        <!-- Add Browser Branch -->
                        <!-- Condition สาขา -->
                        <?php
                        $tSaleAdjDataInputBchCode   = "";
                        $tSaleAdjDataInputBchName   = "";
                        if ($tRoute  == "dcmSPAEventAdd") {
                            $tSaleAdjDataInputBchCode   = $tBchCompCode;
                            $tSaleAdjDataInputBchName   = $tBchCompName;
                            $tDisabled  = '';
                            $tNameElmID = 'obtBrowseSaleAdjBCH';
                        } else {
                            $tSaleAdjDataInputBchCode       = $tBchCode;
                            $tSaleAdjDataInputBchName       = $tXphBchToName;
                            $tDisabled  = 'disabled';
                            $tNameElmID = '';
                        }
                        ?>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/salepriceadj/salepriceadj', 'tSpaBRWBranch'); ?></label>
                            <div class="input-group">
                                <input type="text" class="orm-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetBchCode" name="oetBchCode" maxlength="5" value="<?php echo $tSaleAdjDataInputBchCode; ?>">
                                <input type="text" class="form-control xWPointerEventNone" id="oetSaleAdjBchName" name="oetSaleAdjBchName" maxlength="100" placeholder="<?php echo language('document/salepriceadj/salepriceadj', 'tSpaBRWBranch'); ?>" value="<?php echo $tSaleAdjDataInputBchName; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="<?= @$tNameElmID ?>" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>">
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <!-- <script>
                            var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                            if( tUsrLevel == "SHP" ){
                                var tSHPCount = '<?=$this->session->userdata("nSesUsrShpCount");?>';
                                if(tSHPCount < 2){
                                    $('#obtPIBrowseShop').attr('disabled',true);
                                }

                                $('#oetSalePriceShpCode').val('<?=$this->session->userdata("tSesUsrShpCodeDefault");?>');
                                $('#oetSalePriceShpName').val('<?=$this->session->userdata("tSesUsrShpNameDefault");?>');
                            }
                        </script>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tShop'); ?></label>
                            <div class="input-group">
                                <input name="oetSalePriceShpName" id="oetSalePriceShpName" class="form-control" value="<?php echo $tUserShpName; ?>" type="text" readonly="" placeholder="<?= language('document/salepriceadj/salepriceadj', 'tSpaBRWShop') ?>" data-validate-required="<?= language('document/topupvending/topupvending', 'tTopUpVendingShpValidate') ?>">
                                <input name="oetSalePriceShpCode" id="oetSalePriceShpCode" value="<?php echo $tUserShpCode; ?>" class="form-control xCNHide" type="text">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>" id="obtBrowseWithoutVendingShp" type="button">
                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div> -->


                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphDocType'); ?></label>
                            <select class="selectpicker form-control" id="ocmXphDocType" name="ocmXphDocType" maxlength="1" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tSpaValidXphDocType'); ?>">
                                <!-- <option value=""><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphDocType') ?></option> -->
                                <option value="1" <?= $tXphDocType == "1" ? "selected" : ""; ?>><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphDocType1') ?></option>
                                <option value="2" <?= $tXphDocType == "2" ? "selected" : ""; ?>><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphDocType2') ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphStaAdj'); ?></label>
                            <select class="selectpicker form-control" id="ocmXphStaAdj" name="ocmXphStaAdj" maxlength="1" onchange="JSxCheckValue(value);" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tSpaValidXphStaAdj'); ?>">
                                <!-- <option value=""><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphStaAdj') ?></option> -->
                                <option id="optStaAdj1" value="1" <?= $tXphStaAdj == "1" ? "selected" : ""; ?>><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphStaAdj1') ?></option>
                                <option id="optStaAdj2" value="2" <?= $tXphStaAdj == "2" ? "selected" : ""; ?>><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphStaAdj2') ?></option>
                                <option id="optStaAdj3" value="3" <?= $tXphStaAdj == "3" ? "selected" : ""; ?>><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphStaAdj3') ?></option>
                                <option id="optStaAdj4" value="4" <?= $tXphStaAdj == "4" ? "selected" : ""; ?>><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphStaAdj4') ?></option>
                                <option id="optStaAdj5" value="5" <?= $tXphStaAdj == "5" ? "selected" : ""; ?>><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphStaAdj5') ?></option>
                            </select>
                        </div>


                        <div class="row">
                            <div class="col-xs-5 col-md-4 col-lg-4">
                                <div class="form-group form-inline">
                                    <div class="input-group" style="margin-right:0px;width:100%;">
                                        <input type="hidden" id="ohdValueType1" value="<?php echo language('document/salepriceadj/salepriceadj', 'tSpaADDValueType1') ?>">
                                        <input type="hidden" id="ohdValueType2" value="<?php echo language('document/salepriceadj/salepriceadj', 'tSpaADDValueType2') ?>">
                                        <input type="text" class="form-control" id="oetValue" name="oetValue" placeholder="<?= language('document/salepriceadj/salepriceadj', 'tSpaADDValue') ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                        <span class="input-group-btn">
                                            <button type="button" id="ospValueType" class="btn xCNBtnBrowseAddOn" style="font-size:17px;font-weight:bold;"><?php echo language('document/salepriceadj/salepriceadj', 'tSpaADDValueType2') ?></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-5 col-md-4 col-lg-4 xCNHide" style="margin-right:0px; margin-left:0px; padding-left:0px; padding-right:0px;">
                                <select class="selectpicker form-control" id="ocmChangePrice" name="ocmChangePrice" maxlength="1">
                                    <option value="1" selected><?= language('document/salepriceadj/salepriceadj', 'tPdtPriTBAdjustAll') ?></option>
                                    <option value="2"><?= language('document/salepriceadj/salepriceadj', 'tPdtPriTBPriceRet') ?></option>
                                    <option value="3"><?= language('document/salepriceadj/salepriceadj', 'tPdtPriTBPriceWhs') ?></option>
                                    <option value="4"><?= language('document/salepriceadj/salepriceadj', 'tPdtPriTBPriceNet') ?></option>
                                </select>
                            </div>

                            <div class="col-xs-2 col-md-4 col-lg-4" style="margin-right:0px;margin-left:0px;text-align: center;">
                                <button type="button" id="obtAdjAll" class="btn btn-primary" style="width:100%;font-size: 17px;padding-left:10px;padding-right:10px;padding-top:5px;padding-bottom:2px;"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDBtnAdjAll') ?></button>
                            </div>
                        </div>


                        <input type="hidden" id="ohdBranchSalePrice" name="ohdBranchSalePrice" value="<?= $this->session->userdata('tSesUsrBchCom') ?>">
                        <!-- <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphBchTo'); ?></label>
                            <div class="input-group">
                                <input name="oetXphBchTo" id="oetXphBchTo" class="form-control xCNHide" value="<?= $tXphBchTo ?>">
                                <input name="oetBchName" id="oetBchName" class="form-control xWPointerEventNone xWRptConsCrdInput"  type="text" readonly="" value="<?= $tXphBchToName ?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="btnBrowseBranch" type="button" <?php
                                                                                                                if ($this->session->userdata("tSesUsrLevel") == "BCH" || $this->session->userdata("tSesUsrLevel") == "SHP") {
                                                                                                                    echo "disabled";
                                                                                                                } else {
                                                                                                                    if ($tCmpCode == '' || !FCNtGetBchInComp()) {
                                                                                                                        echo "disabled";
                                                                                                                    }
                                                                                                                } ?>>
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div> -->

                        <!-- <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant', 'tMerchantTitle') ?></label>
                            <div class="input-group">
                                <input name="oetXphMerCode" id="oetXphMerCode" class="form-control xCNHide" value="<?= $tXphMerCode ?>">
                                <input name="oetMerName" id="oetMerName" class="form-control xWPointerEventNone xWRptConsCrdInput"  type="text" readonly="" value="<?= $tXphMerName ?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="btnBrowseMerChrant" type="button" <?php
                                                                                                                if ($this->session->userdata("tSesUsrLevel") == "SHP") {
                                                                                                                    echo "disabled";
                                                                                                                } else {
                                                                                                                    if ($tCmpCode == '' || !FCNtGetBchInComp()) {
                                                                                                                        echo "disabled";
                                                                                                                    }
                                                                                                                } ?>>
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div> -->
                        <!-- <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphZneTo'); ?></label>
                            <div class="input-group">
                                <input name="oetZneChain" id="oetZneChain" class="form-control xCNHide" value="<?= $tXphZneTo ?>">
                                <input name="oetZneName" id="oetZneName" class="form-control xWPointerEventNone xWRptConsCrdInput"  type="text" readonly="" value="<?= $tXphZneToName ?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="btnBrowseZone" type="button">
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div> -->

                        <!-- <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDMerChante'); ?></label>
                            <div class="input-group">
                                <input name="oetMerCode" id="oetMerCode" class="form-control xCNHide" value="<?= $tMerCode ?>">
                                <input name="oetMerName" id="oetMerName" class="form-control xWPointerEventNone xWRptConsCrdInput"  type="text" readonly="" value="<?= $tMerName ?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="btnBrowseMerchant" type="button">
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDPplCode'); ?></label>
                            <div class="input-group">
                                <input name="oetPplCode" id="oetPplCode" class="form-control xCNHide" value="<?= $tPplCode ?>">
                                <input name="oetPplName" id="oetPplName" class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" readonly="" value="<?= $tPplName ?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="btnBrowsePdtPriList" type="button" <?php
                                                                                                                    if ($tCmpCode == '' || !FCNtGetBchInComp()) {
                                                                                                                        echo "disabled";
                                                                                                                    }
                                                                                                                    ?>>
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphDStart'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xWRelationshipDate" id="oetXphDStart" name="oetXphDStart" autocomplete="off" value="<?= $dXphDStart; ?>" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tSpaValidXphDStart'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtXphDStart" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-6">
                                <div class="form-group" id="odvXphDStop">
                                    <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphDStop'); ?></label>
                                    <div class="input-group">
                                        <input type="hidden" id="oetCheckDate" name="oetCheckDate" value="">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xWRelationshipDate" id="oetXphDStop" name="oetXphDStop" autocomplete="off" value="<?= $dXphDStop; ?>" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tSpaValidXphDStop'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtXphDStop" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphTStart'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNTimePicker xCNInputMaskDate" id="oetXphTStart" name="oetXphTStart" autocomplete="off" value="<?= $tXphTStart; ?>" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tSpaValidXphTStart'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtXphTStart" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-6">
                                <div class="form-group" id="odvXphTStop">
                                    <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphTStop'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNTimePicker xCNInputMaskDate" id="oetXphTStop" name="oetXphTStop" autocomplete="off" value="<?= $tXphTStop; ?>" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tSpaValidXphTStop'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtXphTStop" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/salepriceadj/salepriceadj', 'tSpaADDDocRefTitle'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataRef" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvDataRef" class="panel-collapse collapse" role="tabpanel" style="margin-top:10px;">
                    <div class="panel-body xCNPDModlue">

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphName'); ?></label>
                            <input class="form-control" type="text" id="oetXphName" name="oetXphName" value="<?= $tXphName ?>">
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphRefInt'); ?></label>
                            <input class="form-control" type="text" id="oetXphRefInt" name="oetXphRefInt" value="<?= $tXphRefInt ?>">
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphRefIntDate'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXphRefIntDate" name="oetXphRefIntDate" autocomplete="off" value="<?= $dXphRefIntDate ?>">
                                <span class="input-group-btn">
                                    <button id="obtXphRefIntDate" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/salepriceadj/salepriceadj', 'tSpaADDOtherTitle'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataOther" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvDataOther" class="panel-collapse collapse" role="tabpanel" style="margin-top:10px;">
                    <div class="panel-body xCNPDModlue">

                        <!-- <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDAggCode'); ?></label>
                            <div class="input-group">
                                <input name="oetAggCode" id="oetAggCode" class="form-control xCNHide" value="<?= $tAggCode ?>">
                                <input name="oetAggName" id="oetAggName" class="form-control xWPointerEventNone xWRptConsCrdInput"  type="text" readonly="" value="<?= $tAggName ?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="btnBrowseAgency" type="button">
                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div> -->

                        <div class="form-group">

                            <input type="hidden" id="ocmXphPriType" name="ocmXphPriType" value="1">

                            <!--
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphPriType'); ?></label>
                            <select class="selectpicker form-control" id="ocmXphPriType" name="ocmXphPriType" maxlength="1">
                                <option value="1" <?= $tXphPriType == "1" ? "selected" : ""; ?>><?= language('document/salepriceadj/salepriceadj', 'tPdtPriTBPriceRet'); ?></option>
                                <option value="2" <?= $tXphPriType == "2" ? "selected" : ""; ?>><?= language('document/salepriceadj/salepriceadj', 'tPdtPriTBPriceWhs'); ?></option>
                                <option value="3" <?= $tXphPriType == "3" ? "selected" : ""; ?>><?= language('document/salepriceadj/salepriceadj', 'tPdtPriTBPriceNet'); ?></option>
                            </select>-->
                        </div>

                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <input type="checkbox" class="ocbListItem" id="ocbXphStaDocAct" name="ocbXphStaDocAct" maxlength="1" value="1" <?= $nXphStaDocAct == '' ? 'checked' : $nXphStaDocAct == '1' ? 'checked' : '0'; ?>>
                                <span class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphStaDocAct'); ?></span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/salepriceadj/salepriceadj', 'tSpaADDXphRmk'); ?></label>
                            <textarea class="form-control" maxlength="100" rows="4" id="otaXphRmk" name="otaXphRmk"><?= $tXphRmk ?></textarea>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/salepriceadj/salepriceadj', 'tSpaTitlePdtPriList'); ?></label>
                </div>
                <div id="odvDataOther" class="panel-collapse collapse in" role="tabpanel" style="margin-top:10px;">
                    <div class="panel-body xCNPDModlue">

                        <div class="row">
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/pdtsize/pdtsize', 'tPSZSearch') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="oetSearchSpaPdtPri" name="oetSearchSpaPdtPri" placeholder="<?php echo language('product/pdtsize/pdtsize', 'tPSZSearch') ?>">
                                        <span class="input-group-btn">
                                            <button id="oimSearchSpaPdtPri" class="btn xCNBtnSearch" type="button">
                                                <img class="xCNIconAddOn" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/search-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-8 col-lg-8 text-right" style="margin-top:25px;">
                                <div class="form-group">
                                    <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                                        <button type="button" class="btn xCNBTNMngTable xCNImportBtn" style="margin-right:10px;" onclick="JSxOpenImportForm()">
                                            <?= language('common/main/main', 'tImport') ?>
                                        </button>
                                    </div>
                                    <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                                        <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                            <?php echo language('common/main/main', 'tCMNOption') ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li id="oliBtnDeleteAll" class="disabled">
                                                <a href="javascript:;" data-toggle="modal" data-target="#odvModalDelSpaPdtPri"><?php echo language('common/main/main', 'tDelAll') ?></a>
                                            </li>
                                            <li id="oliBtnMngTable">
                                                <a href="javascript:;" onclick="JSxOpenColumnFormSet()"><?php echo language('common/main/main', 'tModalAdvTable') ?></a>
                                            </li>
                                        </ul>
                                    </div>

                                    <input type="text" class="form-control" style="display: inline;width: 250px;margin-left: 10px;" id="oetSPAInsertScan" autocomplete="off" name="oetSPAInsertScan" maxlength="50" value="" onkeypress="Javascript:if(event.keyCode==13) JSxSPASearchFromBarcode(this);"  placeholder="<?php echo language('document/document/document','tDocScanBarPdt')?>" >
                                    <button id="obtAddPdt" name="obtAddPdt" class="xCNBTNPrimeryPlus" type="button" style="margin-left:10px;margin-top: 0px;">+</button>
                                </div>
                            </div>
                        </div>

                        <section id="ostDataPdtPri"></section>

                    </div>
                </div>
            </div>

        </div>

    </div>
</form>

<div class="modal fade xCNModalApprove" id="odvSPAPopupApv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main', 'tApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('common/main/main', 'tMainApproveStatus'); ?></p>
                <ul>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus1'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus2'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus3'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus4'); ?></li>
                </ul>
                <p><?php echo language('common/main/main', 'tMainApproveStatus5'); ?></p>
                <p><strong><?php echo language('common/main/main', 'tMainApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button id="obtSalePriAdjPopupApvConfirm" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<?php include('script/jSalePriceAdjAdd.php') ?>
