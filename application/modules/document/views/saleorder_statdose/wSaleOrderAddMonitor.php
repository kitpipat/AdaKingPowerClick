<?php
    $tSesUsrLevel   = $this->session->userdata('tSesUsrLevel');
    if(isset($aDataDocHD) && $aDataDocHD['rtCode'] == '1'){
        $aDataDocHD             = @$aDataDocHD['raItems'];
        $aDataDocHDSpl          = @$aDataDocHDSpl['raItems'];
        $nLastSeq               = $aDataDocHD['LastSeq'];
        $tSORoute               = "dcmSOEventEdit_STD";
        $nSOAutStaEdit          = 1;
        $tSODocNo               = $aDataDocHD['FTXshDocNo'];
        $dSODocDate             = date("Y-m-d",strtotime($aDataDocHD['FDXshDocDate']));
        $dSODocTime             = date("h:i:s a",strtotime($aDataDocHD['FDXshDocDate']));
        $tSOCreateBy            = $aDataDocHD['FTCreateBy'];
        $tSOUsrNameCreateBy     = $aDataDocHD['FTCreateBy'];

        $tSOStaRefund           = $aDataDocHD['FTXshStaRefund'];
        $tSOStaDoc              = $aDataDocHD['FTXshStaDoc'];
        $tSOStaApv              = $aDataDocHD['FTXshStaApv'];
        $tSOStaPrcStk           = '';
        $tSOStaDelMQ            = '';
        $tSOStaPaid             = $aDataDocHD['FTXshStaPaid'];
        $tDepCode               = $aDataDocHD['FTDptCode'];
        $tDepName               = $aDataDocHD['FTDptName'];
        $tSOSesUsrBchCode       = $this->session->userdata("tSesUsrBchCode");
        $tSODptCode             = $aDataDocHD['FTDptCode'];
        $tSOUsrCode             = $this->session->userdata('tSesUsername');
        $tSOLangEdit            = $this->session->userdata("tLangEdit");

        $tSOApvCode             = $aDataDocHD['FTXshApvCode'];
        $tSOUsrNameApv          = $aDataDocHD['FTXshApvName'];
        $tSORefPoDoc            = "";
        $tSORefIntDoc           = $aDataDocHD['FTXshRefInt'];
        $dSORefIntDocDate       = $aDataDocHD['FDXshRefIntDate'];
        $tSORefExtDoc           = $aDataDocHD['FTXshRefExt'];
        $dSORefExtDocDate       = $aDataDocHD['FDXshRefExtDate'];

        $tSOBchCode             = $aDataDocHD['FTBchCode'];
        $tSOBchName             = $aDataDocHD['FTBchName'];
        $tSOUserBchCode         = $tUserBchCode;
        $tSOUserBchName         = $tUserBchName;
        $tSOBchCompCode         = $tBchCompCode;
        $tSOBchCompName         = $tBchCompName;

        $tSOMerCode             = $aDataDocHD['FTMerCode'];
        $tSOMerName             = $aDataDocHD['FTMerName'];
        $tSOShopType            = $aDataDocHD['FTShpType'];
        $tSOShopCode            = $aDataDocHD['FTShpCode'];
        $tSOShopName            = $aDataDocHD['FTShpName'];
        $tSOPosCode             = $aDataDocHD['FTPosCode'];
        $tSOPosName             = $aDataDocHD['FTPosName'];
        $tSOWahCode             = $aDataDocHD['FTWahCode'];
        $tSOWahName             = $aDataDocHD['FTWahName'];
        $nSOStaDocAct           = $aDataDocHD['FNXshStaDocAct'];
        $tSOFrmDocPrint         = $aDataDocHD['FNXshDocPrint'];
        $tSOFrmRmk              = $aDataDocHD['FTXshRmk'];
        $tSOSplCode             = '';
        $tSOSplName             = '';

        $tSOCmpRteCode          = $aDataDocHD['FTRteCode'];
        $cSORteFac              = $aDataDocHD['FCXshRteFac'];

        $tSOVatInOrEx           = $aDataDocHD['FTXshVATInOrEx'];
        $tSOSplPayMentType      = $aDataDocHD['FTXshCshOrCrd'];

        // ข้อมูลผู้จำหน่าย Supplier
        $tSOSplDstPaid          = $aDataDocHDSpl['FTXshDstPaid'];
        $tSOSplCrTerm           = $aDataDocHDSpl['FNXshCrTerm'];
        $dSOSplDueDate          = $aDataDocHDSpl['FDXshDueDate'];
        $dSOSplBillDue          = $aDataDocHDSpl['FDXshBillDue'];
        $tSOSplCtrName          = $aDataDocHDSpl['FTXshCtrName'];
        $dSOSplTnfDate          = $aDataDocHDSpl['FDXshTnfDate'];
        $tSOSplRefTnfID         = $aDataDocHDSpl['FTXshRefTnfID'];
        $tSOSplRefVehID         = $aDataDocHDSpl['FTXshRefVehID'];
        $tSOSplRefInvNo         = $aDataDocHDSpl['FTXshRefInvNo'];
        $tSOSplQtyAndTypeUnit   = $aDataDocHDSpl['FTXshQtyAndTypeUnit'];

        $tSOCstCode             = $aDataDocHD['FTCstCode'];
        $tSOCstCardID           = $aDataDocHD['FTXshCardID'];
        $tSOCstName             = $aDataDocHD['FTXshCstName'];
        $tSOCstTel              = $aDataDocHD['FTXshCstTel'];

        // ที่อยู่สำหรับการจัดส่ง
        $tSOSplShipAdd          = $aDataDocHDSpl['FNXshShipAdd'];
        $tSOShipAddAddV1No      = (isset($aDataDocHDSpl['FTXshShipAddNo']) && !empty($aDataDocHDSpl['FTXshShipAddNo']))? $aDataDocHDSpl['FTXshShipAddNo'] : "-";
        $tSOShipAddV1Soi        = (isset($aDataDocHDSpl['FTXshShipAddSoi']) && !empty($aDataDocHDSpl['FTXshShipAddSoi']))? $aDataDocHDSpl['FTXshShipAddSoi'] : "-";
        $tSOShipAddV1Village    = (isset($aDataDocHDSpl['FTXshShipAddVillage']) && !empty($aDataDocHDSpl['FTXshShipAddVillage']))? $aDataDocHDSpl['FTXshShipAddVillage'] : "-";
        $tSOShipAddV1Road       = (isset($aDataDocHDSpl['FTXshShipAddRoad']) && !empty($aDataDocHDSpl['FTXshShipAddRoad']))? $aDataDocHDSpl['FTXshShipAddRoad'] : "-";
        $tSOShipAddV1SubDist    = (isset($aDataDocHDSpl['FTXshShipSubDistrict']) && !empty($aDataDocHDSpl['FTXshShipSubDistrict']))? $aDataDocHDSpl['FTXshShipSubDistrict'] : "-";
        $tSOShipAddV1DstCode    = (isset($aDataDocHDSpl['FTXshShipDistrict']) && !empty($aDataDocHDSpl['FTXshShipDistrict']))? $aDataDocHDSpl['FTXshShipDistrict'] : "-";
        $tSOShipAddV1PvnCode    = (isset($aDataDocHDSpl['FTXshShipProvince']) && !empty($aDataDocHDSpl['FTXshShipProvince']))? $aDataDocHDSpl['FTXshShipProvince'] : "-";
        $tSOShipAddV1PostCode   = (isset($aDataDocHDSpl['FTXshShipPosCode']) && !empty($aDataDocHDSpl['FTXshShipPosCode']))? $aDataDocHDSpl['FTXshShipPosCode'] : "-";

        // ที่อยู่สำหรับการออกใบกำกับภาษี
        $tSOSplTaxAdd           = $aDataDocHDSpl['FNXshTaxAdd'];
        $tSOTexAddAddV1No       = (isset($aDataDocHDSpl['FTXshTaxAddNo']) && !empty($aDataDocHDSpl['FTXshTaxAddNo']))? $aDataDocHDSpl['FTXshTaxAddNo'] : "-";
        $tSOTexAddV1Soi         = (isset($aDataDocHDSpl['FTXshTaxAddSoi']) && !empty($aDataDocHDSpl['FTXshTaxAddSoi']))? $aDataDocHDSpl['FTXshTaxAddSoi'] : "-";
        $tSOTexAddV1Village     = (isset($aDataDocHDSpl['FTXshTaxAddVillage']) && !empty($aDataDocHDSpl['FTXshTaxAddVillage']))? $aDataDocHDSpl['FTXshTaxAddVillage'] : "-";
        $tSOTexAddV1Road        = (isset($aDataDocHDSpl['FTXshTaxAddRoad']) && !empty($aDataDocHDSpl['FTXshTaxAddRoad']))? $aDataDocHDSpl['FTXshTaxAddRoad'] : "-";
        $tSOTexAddV1SubDist     = (isset($aDataDocHDSpl['FTXshTaxSubDistrict']) && !empty($aDataDocHDSpl['FTXshTaxSubDistrict']))? $aDataDocHDSpl['FTXshTaxSubDistrict'] : "-";
        $tSOTexAddV1DstCode     = (isset($aDataDocHDSpl['FTXshTaxDistrict']) && !empty($aDataDocHDSpl['FTXshTaxDistrict']))? $aDataDocHDSpl['FTXshTaxDistrict'] : "-";
        $tSOTexAddV1PvnCode     = (isset($aDataDocHDSpl['FTXshTaxProvince']) && !empty($aDataDocHDSpl['FTXshTaxProvince']))? $aDataDocHDSpl['FTXshTaxProvince'] : "-";
        $tSOTexAddV1PostCode    = (isset($aDataDocHDSpl['FTXshTaxPosCode']) && !empty($aDataDocHDSpl['FTXshTaxPosCode']))? $aDataDocHDSpl['FTXshTaxPosCode'] : "-";

        $tSOUsrName               = $aDataDocHD['FTUsrName'];

        if(isset($aDataDocHD['FTImgObj']) && !empty($aDataDocHD['FTImgObj'])){
            $aValueImgExplode = explode('/modules/',$aDataDocHD['FTImgObj']);
            $tFullPatch = './application/modules/'.@$aValueImgExplode[1];
            if (file_exists($tFullPatch)){
                $tPatchPhoto = base_url().'application/modules/'.@$aValueImgExplode[1];
            }else{
                $tPatchPhoto = base_url().'application/modules/common/assets/images/Noimage.png';
            }
        }else{
            $tPatchPhoto = base_url().'application/modules/common/assets/images/Noimage.png';
        }


    }else{
        $tSORoute               = "dcmSOEventAdd_STD";
        $nSOAutStaEdit          = 0;
        $tSODocNo               = "";
        $dSODocDate             = "";
        $dSODocTime             = "";
        $tSOCreateBy            = $this->session->userdata('tSesUsrUsername');
        $tSOUsrNameCreateBy     = $this->session->userdata('tSesUsrUsername');
        $nLastSeq               = 0;
        $tSOStaRefund           = 1;
        $tSOStaDoc              = 1;
        $tSOStaApv              = NULL;
        $tSOStaPrcStk           = NULL;
        $tSOStaDelMQ            = NULL;
        $tSOStaPaid             = 1;

        $tSOSesUsrBchCode       = $this->session->userdata("tSesUsrBchCode");
        $tSODptCode             = $tDptCode;
        $tSOUsrCode             = $this->session->userdata('tSesUsername');
        $tSOLangEdit            = $this->session->userdata("tLangEdit");
        $tDepCode               = "";
        $tDepName               = "";
        $tSOApvCode             = "";
        $tSOUsrNameApv          = "";
        $tSORefPoDoc            = "";
        $tSORefIntDoc           = "";
        $dSORefIntDocDate       = "";
        $tSORefExtDoc           = "";
        $dSORefExtDocDate       = "";

        $tSOBchCode             = $tBchCode;
        $tSOBchName             = $tBchName;
        $tSOUserBchCode         = $tBchCode;
        $tSOUserBchName         = $tBchName;
        $tSOBchCompCode         = $tBchCompCode;
        $tSOBchCompName         = $tBchCompName;
        $tSOMerCode             = $tMerCode;
        $tSOMerName             = $tMerName;
        $tSOShopType            = $tShopType;
        $tSOShopCode            = $tShopCode;
        $tSOShopName            = $tShopName;
        $tSOPosCode             = "";
        $tSOPosName             = "";
        $tSOWahCode             = (!empty($aConfigSysWareHouse['FTSysWahCode']))? $aConfigSysWareHouse['FTSysWahCode'] : $tWahCode;
        $tSOWahName             = (!empty($aConfigSysWareHouse['FTSysWahName']))? $aConfigSysWareHouse['FTSysWahName'] : $tWahName;
        $nSOStaDocAct           = "";
        $tSOFrmDocPrint         = 0;
        $tSOFrmRmk              = "";
        $tSOSplCode             = "";
        $tSOSplName             = "";

        $tSOCmpRteCode          = $tCmpRteCode;
        $cSORteFac              = $cXthRteFac;

        $tSOVatInOrEx           = "";
        $tSOSplPayMentType      = "";

        // ข้อมูลผู้จำหน่าย Supplier
        $tSOSplDstPaid          = "";
        $tSOSplCrTerm           = "";
        $dSOSplDueDate          = "";
        $dSOSplBillDue          = "";
        $tSOSplCtrName          = "";
        $dSOSplTnfDate          = "";
        $tSOSplRefTnfID         = "";
        $tSOSplRefVehID         = "";
        $tSOSplRefInvNo         = "";
        $tSOSplQtyAndTypeUnit   = "";


        $tSOCstCode             = '';
        $tSOCstCardID           = '';
        $tSOCstName             = '';
        $tSOCstTel              = '';

        // ที่อยู่สำหรับการจัดส่ง
        $tSOSplShipAdd          = "";
        $tSOShipAddAddV1No      = "-";
        $tSOShipAddV1Soi        = "-";
        $tSOShipAddV1Village    = "-";
        $tSOShipAddV1Road       = "-";
        $tSOShipAddV1SubDist    = "-";
        $tSOShipAddV1DstCode    = "-";
        $tSOShipAddV1PvnCode    = "-";
        $tSOShipAddV1PostCode   = "-";

        // ที่อยู่สำหรับการออกใบกำกับภาษี
        $tSOSplTaxAdd           = "";
        $tSOTexAddAddV1No       = "-";
        $tSOTexAddV1Soi         = "-";
        $tSOTexAddV1Village     = "-";
        $tSOTexAddV1Road        = "-";
        $tSOTexAddV1SubDist     = "-";
        $tSOTexAddV1DstCode     = "-";
        $tSOTexAddV1PvnCode     = "-";
        $tSOTexAddV1PostCode    = "-";

        $tSOUsrName               = "";
        $tPatchPhoto              = "";
    }
?>
<form id="ofmSOFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdSOPage" name="ohdSOPage" value="2">
    <input type="hidden" id="ohdSOPatchPhoto" name="ohdSOPatchPhoto" value="<?php echo @$tPatchPhoto;?>">
    <input type="hidden" id="oetSOFrmPosCode" name="oetSOFrmPosCode" value="<?php echo $tSOPosCode;?>">
    <input type="hidden" id="ohdSORoute" name="ohdSORoute" value="<?php echo $tSORoute;?>">
    <input type="hidden" id="ohdSOCheckClearValidate" name="ohdSOCheckClearValidate" value="0">
    <input type="hidden" id="ohdSOCheckSubmitByButton" name="ohdSOCheckSubmitByButton" value="0">
    <input type="hidden" id="ohdSOAutStaEdit" name="ohdSOAutStaEdit" value="<?php echo $nSOAutStaEdit;?>">
    <input type="hidden" id="ohdSOLastSeq" name="ohdSOLastSeq" value="<?php echo $nLastSeq;?>">
    <input type="hidden" id="ohdSOSecondTimeCountDonw" name="ohdSOSecondTimeCountDonw" value="<?php echo $nSecondTimeCountDonw;?>">
    <input type="hidden" id="ohdSOStaRefund" name="ohdSOStaRefund" value="<?php echo $tSOStaRefund;?>">
    <input type="hidden" id="ohdSOStaDoc" name="ohdSOStaDoc" value="<?php echo $tSOStaDoc;?>">
    <input type="hidden" id="ohdSOStaApv" name="ohdSOStaApv" value="<?php echo $tSOStaApv;?>">
    <input type="hidden" id="ohdSOStaDelMQ" name="ohdSOStaDelMQ" value="<?php echo $tSOStaDelMQ; ?>">
    <input type="hidden" id="ohdSOStaPrcStk" name="ohdSOStaPrcStk" value="<?php echo $tSOStaPrcStk;?>">
    <input type="hidden" id="ohdSOStaPaid" name="ohdSOStaPaid" value="<?php echo $tSOStaPaid;?>">

    <input type="hidden" id="ohdSOSesUsrBchCode" name="ohdSOSesUsrBchCode" value="<?php echo $tSOSesUsrBchCode; ?>">
    <input type="hidden" id="ohdSOBchCode" name="ohdSOBchCode" value="<?php echo $tSOBchCode; ?>">
    <input type="hidden" id="ohdSODptCode" name="ohdSODptCode" value="<?php echo $tSODptCode;?>">
    <input type="hidden" id="ohdSOUsrCode" name="ohdSOUsrCode" value="<?php echo $tSOUsrCode?>">
    <input type="hidden" id="oetDepCode" name="oetDepCode" maxlength="5" value="<?php echo @$tDepCode?>">
	<input type="hidden" id="oetDepName" name="oetDepName" maxlength="100" value="<?php echo @$tDepName?>" readonly>
    <input type="hidden" id="ohdSOPosCode" name="ohdSOPosCode" value="">
    <input type="hidden" id="ohdSOShfCode" name="ohdSOShfCode" value="">

    <input type="hidden" id="ohdSOCmpRteCode" name="ohdSOCmpRteCode" value="<?php echo $tSOCmpRteCode;?>">
    <input type="hidden" id="ohdSORteFac" name="ohdSORteFac" value="<?php echo $cSORteFac;?>">

    <input type="hidden" id="ohdSOApvCodeUsrLogin" name="ohdSOApvCodeUsrLogin" value="<?php echo $tSOUsrCode; ?>">
    <input type="hidden" id="ohdSOLangEdit" name="ohdSOLangEdit" value="<?php echo $tSOLangEdit; ?>">
    <input type="hidden" id="ohdSOOptAlwSaveQty" name="ohdSOOptAlwSaveQty" value="<?php echo $nOptDocSave?>">
    <input type="hidden" id="ohdSOOptScanSku" name="ohdSOOptScanSku" value="<?php echo $nOptScanSku?>">

    <input type="hidden" id="ohdSOtiemNotApr" name="ohdSOtiemNotApr" value="">
    <button style="display:none" type="submit" id="obtSOSubmitDocument" onclick="JSxSOAddEditDocument()"></button>

    <div class="row">
        <div class="col-xs12- col-sm-5 col-md-5 col-lg-5">
            <!-- Panel Customer Info -->
            <div class="panel panel-default"  style="margin-bottom:25px;position:relative;min-height:80px;" >
                <div class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-col-md-12 col-lg-12">
                            <div class="col-xs-4 col-sm-4 col-col-md-4 col-lg-4">
                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelAutoGenCode'); ?></label>
                                    <br><?=$tSODocNo?>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-col-md-4 col-lg-4">
                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmDocDate');?></label>
                                <br><?=date('d/m/Y',strtotime($dSODocDate))?>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-col-md-4 col-lg-4">
                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOTBCreateBy');?></label>
                                <br><?=$tSOUsrName?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <!-- Panel Customer Info -->
            <div class="panel panel-default"  style="margin-bottom:25px;position:relative;min-height:80px;" >
                <div class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-col-md-12 col-lg-12">
                            <div class="col-xs-3 col-sm-3 col-col-md-3 col-lg-3">
                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOARPCstCode'); ?></label>
                                    <br><?=$tSOCstCode?>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-col-md-4 col-lg-4">
                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOARPCstName');?></label>
                                <br><?=$tSOCstName?>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-col-md-3 col-lg-3">
                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOARPCreOrCash');?></label>
                                <br><?php if($tSOSplPayMentType==1){ echo language('document/saleorder/saleorder','tSOLabelFrmSplInfoPaymentType1'); }else{ echo language('document/saleorder/saleorder','tSOLabelFrmSplInfoPaymentType2'); } ?>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-col-md-2 col-lg-2">
                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmCsttel');?></label>
                                <br><?=$tSOCstTel?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  style="display:none">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvSOHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmStatus'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvSODataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvSODataStatusInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="text-success xCNTitleFrom"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmAppove');?></label>
                                </div>
                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/saleorder/saleorder','tSOLabelAutoGenCode'); ?></label>
                                <?php if(isset($tSODocNo) && empty($tSODocNo)):?>
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbSOStaAutoGenCode" name="ocbSOStaAutoGenCode" maxlength="1" checked="checked">
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmAutoGenCode');?></span>
                                    </label>
                                </div>
                                <?php endif;?>
                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input
                                        type="text"
                                        class="form-control xCNGenarateCodeTextInputValidate xCNInputWithoutSpcNotThai"
                                        id="oetSODocNo"
                                        name="oetSODocNo"
                                        maxlength="20"
                                        value="<?php echo $tSODocNo;?>"
                                        data-validate-required="<?php echo language('document/saleorder/saleorder','tSOPlsEnterOrRunDocNo'); ?>"
                                        data-validate-duplicate="<?php echo language('document/saleorder/saleorder','tSOPlsDocNoDuplicate'); ?>"
                                        placeholder="<?php echo language('document/saleorder/saleorder','tSOLabelFrmDocNo');?>"
                                        style="pointer-events:none"
                                        readonly
                                    >
                                    <input type="hidden" id="ohdSOCheckDuplicateCode" name="ohdSOCheckDuplicateCode" value="2">
                                </div>
                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetSODocDate"
                                            name="oetSODocDate"
                                            value="<?php echo $dSODocDate; ?>"
                                            data-validate-required="<?php echo language('document/saleorder/saleorder','tSOPlsEnterDocDate'); ?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtSODocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmDocTime');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNTimePicker xCNInputMaskTime"
                                            id="oetSODocTime"
                                            name="oetSODocTime"
                                            value="<?php echo $dSODocTime; ?>"
                                            data-validate-required="<?php echo language('document/saleorder/saleorder', 'tSOPlsEnterDocTime');?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtSODocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmCreateBy');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdSOCreateBy" name="ohdSOCreateBy" value="<?php echo $tSOCreateBy?>">
                                            <label><?php echo $tSOUsrNameCreateBy?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <?php
                                                if($tSORoute == "dcmSOEventAdd_STD"){
                                                    $tSOLabelStaDoc  = language('document/saleorder/saleorder', 'tSOLabelFrmValStaDoc');
                                                }else{
                                                    $tSOLabelStaDoc  = language('document/saleorder/saleorder', 'tSOLabelFrmValStaDoc'.$tSOStaDoc);
                                                }
                                            ?>
                                            <label><?php echo $tSOLabelStaDoc;?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmValStaApv'.$tSOStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะประมวลผลเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmStaPrcStk'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmValStaPrcStk'.$tSOStaPrcStk); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <?php if(isset($tSODocNo) && !empty($tSODocNo)):?>
                                    <!-- ผู้อนุมัติเอกสาร -->
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdSOApvCode" name="ohdSOApvCode" maxlength="20" value="<?php echo $tSOApvCode?>">
                                                <label>
                                                    <?php echo (isset($tSOUsrNameApv) && !empty($tSOUsrNameApv))? $tSOUsrNameApv : "-" ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Customer Info -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvSOCustomerInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('customer/customer/customer','tCSTTitle');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvSODataCustomerInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvSODataCustomerInfo" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div id="odvRowPanelSplInfo" class="row"  style="max-height:350px;overflow-x:auto">
                        <input  type="hidden" id="ocmSOFrmSplInfoVatInOrEx" name="ocmSOFrmSplInfoVatInOrEx" value="1">
                            <div class="col-xs-12 col-sm-12 col-col-md-12 col-lg-12">


                                <!-- HN Number -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmCstHNNumber');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetSOFrmCstHNNumber"
                                        name="oetSOFrmCstHNNumber"
                                        value="<?php echo $tSOCstCode;?>"
                                        lavudate-label="<?=language('document/saleorder/saleorder','tSOCstHNNumber')?>"
                                    >
                                </div>


                               <!-- ID card code -->
                                 <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmCstCtzID');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetSOFrmCstCtzID"
                                        name="oetSOFrmCstCtzID"
                                        value="<?php echo $tSOCstCardID;?>"
                                    >
                                </div>


                            <!-- Cst Name -->
                            <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmCstName');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetSOFrmCustomerName"
                                        name="oetSOFrmCustomerName"
                                        value="<?php echo $tSOCstName;?>"
                                    >
                                </div>

                                                           <!-- Cst Name -->
                            <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmCsttel');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetSOFrmCstTel"
                                        name="oetSOFrmCstTel"
                                        value="<?php echo $tSOCstTel;?>"
                                    >
                                </div>


                                     <!-- ประเภทการชำระ -->
                                     <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoPaymentType');?></label>
                                    <select class="selectpicker form-control" id="ocmSOFrmSplInfoPaymentType" name="ocmSOFrmSplInfoPaymentType" maxlength="1" >
                                        <option value="1" <?php if($tSOSplPayMentType==1){ echo 'selected'; } ?>><?php echo language('document/saleorder/saleorder','tSOLabelFrmSplInfoPaymentType1');?></option>
                                        <option value="2"  <?php if($tSOSplPayMentType==2){ echo 'selected'; } ?>><?php echo language('document/saleorder/saleorder','tSOLabelFrmSplInfoPaymentType2');?></option>
                                    </select>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Panel ข้อมูลอ้างอิง -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvSOReferenceDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmReference');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvSODataReferenceDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvSODataReferenceDoc" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-t-10">
                                <!-- อ้างอิงเลขที่เอกสารใบขอซื้อ -->
                                <div class="form-group xCNHide">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmRefPo');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetSORefPoDoc"
                                        name="oetSORefPoDoc"
                                        maxlength="20"
                                        value="<?php echo $tSORefPoDoc;?>"
                                    >
                                </div>
                                <!-- อ้างอิงเลขที่เอกสารภายใน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmRefIntDoc');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetSORefIntDoc"
                                        name="oetSORefIntDoc"
                                        maxlength="20"
                                        value="<?php echo $tSORefIntDoc;?>"
                                    >
                                </div>
                                <!-- วันที่อ้างอิงเลขที่เอกสารภายใน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmRefIntDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetSORefIntDocDate"
                                            name="oetSORefIntDocDate"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dSORefIntDocDate;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtSOBrowseRefIntDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- อ้างอิงเลขที่เอกสารภายนอก -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmRefExtDoc');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetSORefExtDoc"
                                        name="oetSORefExtDoc"
                                        value="<?php echo $tSORefExtDoc;?>"
                                    >
                                </div>
                                <!-- วันที่เอกสารภายนอก -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmRefExtDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetSORefExtDocDate"
                                            name="oetSORefExtDocDate"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dSORefExtDocDate;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtSOBrowseRefExtDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel เงื่อนไขเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvSOConditionDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmConditionDoc'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvSODataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvSODataConditionDoc" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- Condition สาขา -->
                                <div class="form-group m-b-0">
                                    <?php
                                        if($tSORoute == "dcmSOEventAdd_STD"){
                                            if($tSesUsrLevel == "HQ"){
                                                $tSODataInputBchCode    = $tSOBchCompCode;
                                                $tSODataInputBchName    = $tSOBchCompName;
                                            }else{
                                                $tSODataInputBchCode    = $tSOUserBchCode;
                                                $tSODataInputBchName    = $tSOUserBchName;
                                            }
                                        }else{
                                            $tSODataInputBchCode    = $tSOBchCode;
                                            $tSODataInputBchName    = $tSOBchName;
                                        }
                                    ?>
                                    <input class="form-control xCNHide" id="oetSOFrmBchCode" name="oetSOFrmBchCode" maxlength="5" value="<?php echo $tSODataInputBchCode;?>">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmBranch');?></label>
                                    <label>&nbsp;<?php echo $tSODataInputBchName;?></label>
                                </div>
                                <!-- Condition กลุ่มธุรกิจ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmMerchant');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetSOFrmMerCode" name="oetSOFrmMerCode" maxlength="5" value="<?php echo $tSOMerCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetSOFrmMerName" name="oetSOFrmMerName" value="<?php echo $tSOMerName;?>" readonly>
                                        <?php
                                            $tDisabledBtnMerchant = "";
                                            if($tSORoute == "dcmSOEventAdd_STD"){
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnMerchant = "disabled";
                                                }
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnMerchant = "disabled";
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnMerchant;?>">
                                            <button id="obtSOBrowseMerchant" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnMerchant;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition ร้านค้า -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmShop');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetSOFrmShpCode" name="oetSOFrmShpCode" maxlength="5" value="<?php echo $tSOShopCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetSOFrmShpName" name="oetSOFrmShpName" value="<?php echo $tSOShopName;?>" readonly>
                                        <?php
                                            $tDisabledBtnShop = "";
                                            if($tSORoute == "dcmSOEventAdd_STD"){
                                                $tDisabledBtnShop   = "disabled";
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnShop   = "disabled";
                                                }else{
                                                    if(empty($tSOShopCode) && empty($tSOShopName)){
                                                        $tDisabledBtnShop   = "disabled";
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnShop;?>">
                                            <button id="obtSOBrowseShop" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnShop;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition เครื่องจุดขาย -->
                                <!-- <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmPos');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetSOFrmPosCode" name="oetSOFrmPosCode" maxlength="5" value="<?php echo $tSOPosCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetSOFrmPosName" name="oetSOFrmPosName" value="<?php echo $tSOPosName;?>" readonly>
                                        <?php
                                            $tDisabledBtnPos    = "";
                                            if($tSORoute == "dcmSOEventAdd_STD"){
                                                $tDisabledBtnPos    = "disabled";
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnPos    = "disabled";
                                                }else{
                                                    if(empty($tSOPosCode)){
                                                        $tDisabledBtnPos    = "disabled";
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnPos;?>">
                                            <button id="obtSOBrowsePos" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnPos;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div> -->
                                <!-- Condition คลังสินค้า -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('document/saleorder/saleorder','tSOLabelFrmWah');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetSOFrmWahCode" name="oetSOFrmWahCode" maxlength="5" value="<?php echo $tSOWahCode;?>">
                                        <input
                                            type="text"
                                            class="form-control xWPointerEventNone"
                                            id="oetSOFrmWahName"
                                            name="oetSOFrmWahName"
                                            value="<?php echo $tSOWahName;?>"
                                            data-validate-required="<?php echo language('document/saleorder/saleorder','tSOPlsEnterWah'); ?>"
                                            readonly
                                        >
                                        <?php
                                            $tDisabledBtnWah    = "";
                                            if($tSORoute == "dcmSOEventAdd_STD"){
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnWah    = "disabled";
                                                }
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnWah    = "disabled";
                                                }else{
                                                    if(!empty($tSOMerCode) && !empty($tSOShopCode) && !empty($tSOWahCode)){
                                                        $tDisabledBtnWah    = "disabled";
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnWah;?>">
                                            <button id="obtSOBrowseWahouse" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnWah;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel อืนๆ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvSOInfoOther" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/saleorder/saleorder','tSOLabelFrmInfoOth');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvSODataInfoOther" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvSODataInfoOther" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                                <!-- สถานะความเคลื่อนไหว -->
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" value="1" id="ocbSOFrmInfoOthStaDocAct" name="ocbSOFrmInfoOthStaDocAct" maxlength="1" <?php echo ($nSOStaDocAct == '1' || empty($nSOStaDocAct)) ? 'checked' : ''; ?>>
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmInfoOthStaDocAct'); ?></span>
                                    </label>
                                </div>
                                <!-- สถานะอ้างอิง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmInfoOthRef');?></label>
                                    <select class="selectpicker form-control" id="ocmSOFrmInfoOthRef" name="ocmSOFrmInfoOthRef" maxlength="1">
                                        <option value="0" selected><?php echo language('document/saleorder/saleorder','tSOLabelFrmInfoOthRef0');?></option>
                                        <option value="1"><?php echo language('document/saleorder/saleorder','tSOLabelFrmInfoOthRef1');?></option>
                                        <option value="2"><?php echo language('document/saleorder/saleorder','tSOLabelFrmInfoOthRef2');?></option>
                                    </select>
                                </div>
                                <!-- จำนวนครั้งที่พิมพ์ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmInfoOthDocPrint');?></label>
                                    <input
                                        type="text"
                                        class="form-control text-right"
                                        id="ocmSOFrmInfoOthDocPrint"
                                        name="ocmSOFrmInfoOthDocPrint"
                                        value="<?php echo $tSOFrmDocPrint;?>"
                                        readonly
                                    >
                                </div>
                                <!-- กรณีเพิ่มสินค้ารายการเดิม -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOLabelFrmInfoOthReAddPdt');?></label>
                                    <select class="form-control selectpicker" id="ocmSOFrmInfoOthReAddPdt" name="ocmSOFrmInfoOthReAddPdt">
                                        <option value="1" selected><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmInfoOthReAddPdt1');?></option>
                                        <option value="2"><?php echo language('document/saleorder/saleorder', 'tSOLabelFrmInfoOthReAddPdt2');?></option>
                                    </select>
                                </div>
                                <!-- หมายเหตุ -->
                                <div class="form-group">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <!-- ตารางรายการสินค้า -->
                <div id="odvSODataPanelDetailPDT" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">
                                <!--ไม่ใช่-->
                                <div class="row p-t-10" style="display:none">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetSOFrmCstCode" name="oetSOFrmCstCode" value="<?php echo $tSOCstCode;?>">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="oetSOFrmCstName"
                                                    name="oetSOFrmCstName"
                                                    value="<?php echo $tSOCstName;?>"
                                                    placeholder="<?php echo language('document/saleorder/saleorder','tSOCstCode') ?>"
                                                    readonly
                                                >
                                                <span class="input-group-btn">
                                                    <button id="obtSOBrowseCustomer" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-t-10" style="display:none">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="100"
                                                    id="oetSOFrmFilterPdtHTML"
                                                    name="oetSOFrmFilterPdtHTML"
                                                    placeholder="<?php echo language('document/saleorder/saleorder','tSOFrmFilterTablePdt');?>"
                                                    onkeyup="javascript:if(event.keyCode==13) JSvSODOCFilterPdtInTableTemp()"
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="100"
                                                    id="oetSOFrmSearchAndAddPdtHTML"
                                                    name="oetSOFrmSearchAndAddPdtHTML"
                                                    onkeyup="Javascript:if(event.keyCode==13) JSxSOChkConditionSearchAndAddPdt()"
                                                    placeholder="<?php echo language('document/saleorder/saleorder','tSOFrmSearchAndAddPdt');?>"
                                                    style="display:none;"
                                                    data-validate="<?php echo language('document/saleorder/saleorder','tSOMsgValidScanNotFoundBarCode');?>"
                                                >
                                                <span class="input-group-btn">
                                                    <div id="odvSOSearchAndScanBtnGrp" class="xCNDropDrownGroup input-group-append">
                                                        <button id="obtSOMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvSODOCFilterPdtInTableTemp()">
                                                            <i class="fa fa-filter" style="width:20px;"></i>
                                                        </button>
                                                        <button id="obtSOMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSxSOChkConditionSearchAndAddPdt()">
                                                            <i class="fa fa-search" style="width:20px;"></i>
                                                        </button>
                                                        <button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown" style="display:none;">
                                                            <i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a id="oliSOMngPdtSearch"><label><?php echo language('document/saleorder/saleorder','tSOFrmFilterTablePdt'); ?></label></a>
                                                                <a id="oliSOMngPdtScan"><?php echo language('document/saleorder/saleorder','tSOFrmSearchAndAddPdt'); ?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 text-right">
                                        <div id="odvSOMngAdvTableList" class="btn-group xCNDropDrownGroup">
                                            <button id="obtSOAdvTablePdtDTTemp" type="button" class="btn xCNBTNMngTable m-r-20"><?php echo language('common/main/main', 'tModalAdvTable') ?></button>
                                        </div>
                                        <div id="odvSOMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
                                            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                                <?php echo language('common/main/main','tCMNOption')?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li id="oliSOBtnDeleteMulti" class="disabled">
                                                    <a data-toggle="modal" data-target="#odvSOModalDelPdtInDTTempMultiple"><?php echo language('common/main/main','tDelAll')?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                        <div class="form-group">
                                            <div style="position: absolute;right: 15px;top:-5px;">
                                                <button type="button" id="obtSODocBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--ค้นหาตามคลัง-->
                                <div class="row p-t-10" id="odvSOSearchByWahouse" style="display:none;">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div style="margin:0px 0px 10px 0px;">
                                            <label class="xCNLabelFrm"><?=language('document/saleorder/saleorder','tSearchWahouseByPDT');?></label>
                                            <select class="selectpicker form-control" id="ocmSearchPDTByWah" name="ocmSearchPDTByWah" maxlength="1">
                                                <option value="" selected><?=language('document/saleorder/saleorder','tSearchWahouseSelectedAll');?></option>
                                                <?php for($i=0; $i<FCNnHSizeOf($aWahINLayout); $i++){ ?>
                                                    <option value="<?=$aWahINLayout[$i]['FTWahCode'];?>"><?=$aWahINLayout[$i]['FTWahName'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--ตารางสินค้า-->
                                <div class="row p-t-10" id="odvSODataPdtTableDTTempMonitor"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="odvSaleOrderEndOfBillMonitor" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     <div class="panel panel-default" style="margin-bottom:25px;position:relative;">
                         <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                             <?php include('wSaleOrderEndOfBillMonitor.php');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =================================================================== View Modal Shipping Purchase Invoice  =================================================================== -->
    <div id="odvSOBrowseShipAdd" class="modal fade">
        <div class="modal-dialog" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/saleorder/saleorder','tSOShipAddress'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnSOShipAddData()"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
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
                                            <label class="xCNTextDetail1"><?php echo language('document/saleorder/saleorder', 'tSOShipAddInfo');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <a style="font-size:14px!important;color:#179bfd;">
                                                <i class="fa fa-pencil" id="oliSOEditShipAddress">&nbsp;<?php echo language('document/saleorder/saleorder','tSOShipChange');?></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body xCNPDModlue">
                                    <input type="hidden" id="ohdSOShipAddSeqNo" class="form-control">
                                    <?php $tSOFormatAddressType = FCNaHAddressFormat('TCNMBranch'); //1 ที่อยู่ แบบแยก  ,2  แบบรวม ?>
                                    <?php if(!empty($tSOFormatAddressType) && $tSOFormatAddressType == '1'): ?>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOShipADDV1No');?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOShipAddAddV1No"><?php echo @$tSOShipAddAddV1No;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOShipADDV1Village');?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOShipAddV1Soi"><?php echo @$tSOShipAddV1Soi;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOShipADDV1Soi'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOShipAddV1Village"><?php echo @$tSOShipAddV1Village;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOShipADDV1Road'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOShipAddV1Road"><?php echo @$tSOShipAddV1Road;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOShipADDV1SubDist'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOShipAddV1SubDist"><?php echo @$tSOShipAddV1SubDist;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOShipADDV1DstCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOShipAddV1DstCode"><?php echo @$tSOShipAddV1DstCode?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOShipADDV1PvnCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOShipAddV1PvnCode"><?php echo @$tSOShipAddV1PvnCode?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOShipADDV1PostCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOShipAddV1PostCode"><?php echo @$tSOShipAddV1PostCode;?></label>
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOShipADDV2Desc1')?></label><br>
                                                    <label id="ospSOShipAddV2Desc1"><?php echo @$tSOShipAddV2Desc1;?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOShipADDV2Desc2')?></label><br>
                                                    <label id="ospSOShipAddV2Desc2"><?php echo @$tSOShipAddV2Desc2;?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================================================================================================================================= -->

    <!-- ================================================================== View Modal TexAddress Purchase Invoice  ================================================================== -->
    <div id="odvSOBrowseTexAdd" class="modal fade">
        <div class="modal-dialog" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/saleorder/saleorder','tSOTexAddress'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnSOTexAddData()"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
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
                                            <label class="xCNTextDetail1"><?php echo language('document/saleorder/saleorder', 'tSOTexAddInfo');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <a style="font-size:14px!important;color:#179bfd;">
                                                <i class="fa fa-pencil" id="oliSOEditTexAddress">&nbsp;<?php echo language('document/saleorder/saleorder','tSOTexChange');?></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body xCNPDModlue">
                                    <input type="hidden" id="ohdSOTexAddSeqNo" class="form-control">
                                    <?php $tSOFormatAddressType = FCNaHAddressFormat('TCNMBranch'); //1 ที่อยู่ แบบแยก  ,2  แบบรวม ?>
                                    <?php if(!empty($tSOFormatAddressType) && $tSOFormatAddressType == '1'): ?>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOTexADDV1No');?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOTexAddAddV1No"><?php echo @$tSOTexAddAddV1No;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOTexADDV1Village');?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOTexAddV1Soi"><?php echo @$tSOTexAddV1Soi;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOTexADDV1Soi'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOTexAddV1Village"><?php echo @$tSOTexAddV1Village;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOTexADDV1Road'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOTexAddV1Road"><?php echo @$tSOTexAddV1Road;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOTexADDV1SubDist'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOTexAddV1SubDist"><?php echo @$tSOTexAddV1SubDist;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOTexADDV1DstCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOTexAddV1DstCode"><?php echo @$tSOTexAddV1DstCode?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOTexADDV1PvnCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOTexAddV1PvnCode"><?php echo @$tSOTexAddV1PvnCode?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder', 'tSOTexADDV1PostCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospSOTexAddV1PostCode"><?php echo @$tSOTexAddV1PostCode;?></label>
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOTexADDV2Desc1')?></label><br>
                                                    <label id="ospSOTexAddV2Desc1"><?php echo @$tSOTexAddV2Desc1;?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/saleorder/saleorder','tSOTexADDV2Desc2')?></label><br>
                                                    <label id="ospSOTexAddV2Desc2"><?php echo @$tSOTexAddV2Desc2;?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

    <!-- ======================================================================== View Modal Appove Document  ======================================================================== -->
    <div id="odvSOModalAppoveDocTxn" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main','tApproveTheDocument'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table border="0" width="100%">
                         <tr class="" style=" border-bottom: 1px solid #C6C4C1; border-top: 1px solid #C6C4C1;">
                            <td><b><?php echo language('common/main/main', 'tSOARPType'); ?></b></td>
                            <td><b><?php echo language('common/main/main', 'tSOARPLevel'); ?></b></td>
                            <td><b><?php echo language('common/main/main', 'tSOARPUser'); ?></b></td>
                            <td align="right"><b><?php echo language('common/main/main', 'tSOARPStatus'); ?></b></td>
                         </tr>
                         <?php  if(!empty($aDataSOTnx)){
                             $nCeckLast = 0;
                             $nNumApv=0;
                             $stlye="";
                                foreach($aDataSOTnx as $aData){

                                    if(empty($aData['FTDatUsrApv'])){
                                        $nCeckLast++;

                                        if($nCeckLast==1){
                                            $stlye="font-weight: bold;";
                                        }else{
                                            $stlye="";
                                        }
                                    }else{
                                        $nNumApv++;
                                    }
                          ?>
                         <tr style="<?=$stlye?>">
                            <td><?php echo $aData['FTDapName']; ?></td>
                            <td><?php
                            if($nCeckLast<1){
                                     echo '<i style="color:green" class="fa fa-check"></i> ';
                                }else if($nCeckLast==1){
                                    echo '<i style="color:#F79704" class="fa fa-user"></i> ';
                                }else if($nCeckLast>1){
                                      echo '<i style="color:red" class="fa fa-times"></i> ';
                                    }
                            if(!empty($aData['FTRolName'])){ echo  $aData['FTRolName']; }else{ echo 'ALL'; }

                            ?></td>
                            <td><?php echo $aData['FTUsrName']; ?></td>
                            <td align="right"><?php  if(!empty($aData['FTDatUsrApv'])){ echo '<span style="color:green">'.language('document/saleorder/saleorder','tSOStaApv1').'</span>'; }else{  echo '<span style="color:#F79704">'.language('document/saleorder/saleorder','tSOStaApv').'</span>'; } ?></td>
                         </tr>
                            <?php
                              }
                            }
                         ?>
                    </table>
                     <textarea   class="form-control" rows="4"
                      id="otaSOInfoOthRmkAprov"
                    name="otaSOInfoOthRmkAprov"
                    placeholder="หมายเหตุ" style="margin-top:10px; margin-bottom: 10px;"></textarea>
                     <div style="font-weight: bold;"><?php echo '<span style="color:green">'.language('document/saleorder/saleorder','tSOStaApv1'); ?> <?=$nNumApv?>/<?=FCNnHSizeOf($aDataSOTnx)?> </span></div>

                </div>
                <div class="modal-footer">
                    <button   id="obtSOApproveDoc"  type="button" class="btn xCNBTNPrimery">
                        <?php echo language('common/main/main', 'tModalConfirm'); ?>
                    </button>
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                        <?php echo language('common/main/main', 'tModalCancel'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================================================================================================================================= -->


    <!-- ======================================================================== View Modal Appove Document  ======================================================================== -->
    <div id="odvSOModalAppoveDoc" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main','tApproveTheDocument'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo language('common/main/main','tMainApproveStatus'); ?></p>
                        <ul>
                            <li><?php echo language('common/main/main','tMainApproveStatus1'); ?></li>
                            <li><?php echo language('common/main/main','tMainApproveStatus2'); ?></li>
                            <li><?php echo language('common/main/main','tMainApproveStatus3'); ?></li>
                            <li><?php echo language('common/main/main','tMainApproveStatus4'); ?></li>
                        </ul>
                    <p><?php echo language('common/main/main','tMainApproveStatus5'); ?></p>
                    <p><strong><?php echo language('common/main/main','tMainApproveStatus6'); ?></strong></p>
                </div>
                <div class="modal-footer">
                    <button onclick="JSxSOApproveDocument(true)" type="button" class="btn xCNBTNPrimery">
                        <?php echo language('common/main/main', 'tModalConfirm'); ?>
                    </button>
                    <button onclick="JSxSOCancelApproveDocument(true)" type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                        <?php echo language('common/main/main', 'tModalCancel'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================================================================================================================================= -->

    <!-- ======================================================================== View Modal Reject Document  ======================================================================== -->
    <div class="modal fade" id="odvPurchaseInviocePopupReject">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard">ปฏิเสธเอกสาร</label>
                </div>
                <div class="modal-body">
                    <p id="obpMsgApv">เอกสารใบนี้ทำการประมวลปฏิเสธแล้ว สถานะเอกสารจะกลับไปเป็น "รอพยาบาลถ่ายรูปสินค้า" อีกครั้ง</p>
                    <p><strong>คุณต้องการที่จะปฏิเสธเอกสารนี้หรือไม่?</strong></p>
                </div>
                <div class="modal-footer">
                    <button onclick="JSnSORejectDocument(true)" type="button" class="btn xCNBTNPrimery">
                        <?php echo language('common/main/main', 'tModalConfirm'); ?>
                    </button>
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                        <?php echo language('common/main/main', 'tModalCancel'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================================================================================================================================= -->


    <!-- ======================================================================== View Modal Cancel Document  ======================================================================== -->
    <div class="modal fade" id="odvPurchaseInviocePopupCancel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard">ยกเลิกเอกสาร</label>
                </div>
                <div class="modal-body">
                    <p id="obpMsgApv">เอกสารใบนี้ทำการประมวลผล หรือยกเลิกแล้ว ไม่สามารถแก้ไขได้</p>
                    <p><strong>คุณต้องการที่จะยกเลิกเอกสารนี้หรือไม่?</strong></p>
                </div>
                <div class="modal-footer">
                    <button onclick="JSnSOCancelDocument(true)" type="button" class="btn xCNBTNPrimery">
                        <?php echo language('common/main/main', 'tModalConfirm'); ?>
                    </button>
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                        <?php echo language('common/main/main', 'tModalCancel'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================================================================================================================================= -->

    <!-- =====================================================================  Modal Advance Table Product DT Temp ==================================================================-->
    <div class="modal fade" id="odvSOOrderAdvTblColumns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('common/main/main', 'tModalAdvTable'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="odvSOModalBodyAdvTable">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
                    <button id="obtSOSaveAdvTableColums" type="button" class="btn btn-primary"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================================================================================================================================= -->

    <!-- ============================================================== View Modal Delete Product In DT DocTemp Multiple  ============================================================ -->
    <div id="odvSOModalDelPdtInDTTempMultiple" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main','tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                    <input type="hidden" id="ohdConfirmSODocNoDelete"   name="ohdConfirmSODocNoDelete">
                    <input type="hidden" id="ohdConfirmSOSeqNoDelete"   name="ohdConfirmSOSeqNoDelete">
                    <input type="hidden" id="ohdConfirmSOPdtCodeDelete" name="ohdConfirmSOPdtCodeDelete">
                    <input type="hidden" id="ohdConfirmSOPunCodeDelete" name="ohdConfirmSOPunCodeDelete">

                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================================================================================================================================= -->

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<?php include('dis_chg/wSaleOrderDisChgModal.php'); ?>
<?php include('script/jSaleOrderAddMonitor.php');?>
