<?php
    $tSesUsrLevel   = $this->session->userdata('tSesUsrLevel');
    if(isset($aDataDocHD) && $aDataDocHD['rtCode'] == '1'){
        // print_r($aDataDocHD['raItems']);
        $aDataDocHD             = @$aDataDocHD['raItems'];
        $aDataDocHDSpl          = @$aDataDocHDSpl['raItems'];

        $tPORoute               = "docPOEventEdit";
        $nPOAutStaEdit          = 1;
        $tPODocNo               = $aDataDocHD['FTXphDocNo'];
        $dPODocDate             = date("Y-m-d",strtotime($aDataDocHD['FDXphDocDate']));
        $dPODocTime             = date("H:i",strtotime($aDataDocHD['FDXphDocDate']));
        $tPOCreateBy            = $aDataDocHD['FTCreateBy'];
        $tPOUsrNameCreateBy     = $aDataDocHD['FTUsrName'];

        $tPOStaRefund           = $aDataDocHD['FTXphStaRefund'];
        $tPOStaDoc              = $aDataDocHD['FTXphStaDoc'];
        $tPOStaApv              = $aDataDocHD['FTXphStaApv'];
        $tPOStaPrcStk           = '';
        $tPOStaDelMQ            = '';
        $tPOStaPaid             = $aDataDocHD['FTXphStaPaid'];

        $tPOSesUsrBchCode       = $this->session->userdata("tSesUsrBchCodeDefault");
        $tPODptCode             = $aDataDocHD['FTDptCode'];
        $tPOUsrCode             = $this->session->userdata('tSesUsername');
        $tPOLangEdit            = $this->session->userdata("tLangEdit");

        $tPOApvCode             = $aDataDocHD['FTXphApvCode'];
        $tPOUsrNameApv          = $aDataDocHD['FTXphApvName'];
        $tPORefPoDoc            = "";
        $tPORefIntDoc           = $aDataDocHD['FTXphRefInt'];
        $dPORefIntDocDate       = $aDataDocHD['FDXphRefIntDate'];
        $tPORefExtDoc           = $aDataDocHD['FTXphRefExt'];
        $dPORefExtDocDate       = $aDataDocHD['FDXphRefExtDate'];
        $nPOStaRef              = $aDataDocHD['FNXphStaRef'];

        $tPOBchCode             = $aDataDocHD['FTBchCode'];
        $tPOBchName             = $aDataDocHD['FTBchName'];
        $tPOUserBchCode         = $tUserBchCode;
        $tPOUserBchName         = $tUserBchName;
        $tPOBchCompCode         = $tBchCompCode;
        $tPOBchCompName         = $tBchCompName;

        $tPOMerCode             = $aDataDocHD['FTMerCode'];
        $tPOMerName             = $aDataDocHD['FTMerName'];
        $tPOShopType            = $aDataDocHD['FTShpType'];
        $tPOShopCode            = $aDataDocHD['FTShpCode'];
        $tPOShopName            = $aDataDocHD['FTShpName'];

        $tPOWahCode             = $aDataDocHD['FTWahCode'];
        $tPOWahName             = $aDataDocHD['FTWahName'];
        $nPOStaDocAct           = $aDataDocHD['FNXphStaDocAct'];
        $tPOFrmDocPrint         = $aDataDocHD['FNXphDocPrint'];
        $tPOFrmRmk              = $aDataDocHD['FTXphRmk'];
        $tPOSplCode             = $aDataDocHD['FTSplCode'];
        $tPOSplName             = $aDataDocHD['FTSplName'];

        $tPOCmpRteCode          = $aDataDocHD['FTRteCode'];
        $cPORteFac              = $aDataDocHD['FCXphRteFac'];

        $tPOVatInOrEx           = $aDataDocHD['FTXphVATInOrEx'];
        $tPOSplPayMentType      = $aDataDocHD['FTXphCshOrCrd'];

        // ข้อมูลผู้จำหน่าย Supplier
        $tPOSplDstPaid          = $aDataDocHDSpl['FTXphDstPaid'];
        $tPOSplCrTerm           = $aDataDocHDSpl['FNXphCrTerm'];
        $dPOSplDueDate          = $aDataDocHDSpl['FDXphDueDate'];
        $dPOSplBillDue          = $aDataDocHDSpl['FDXphBillDue'];
        $tPOSplCtrName          = $aDataDocHDSpl['FTXphCtrName'];
        $dPOSplTnfDate          = $aDataDocHDSpl['FDXphTnfDate'];
        $tPOSplRefTnfID         = $aDataDocHDSpl['FTXphRefTnfID'];
        $tPOSplRefVehID         = $aDataDocHDSpl['FTXphRefVehID'];
        $tPOSplRefInvNo         = $aDataDocHDSpl['FTXphRefInvNo'];
        $tPOSplQtyAndTypeUnit   = $aDataDocHDSpl['FTXphQtyAndTypeUnit'];

        // ที่อยู่สำหรับการจัดส่ง
        $tPOSplShipAdd          = $aDataDocHDSpl['FNXphShipAdd'];
        $tPOShipAddAddV1No      = (isset($aDataDocHDSpl['FTXphShipAddNo']) && !empty($aDataDocHDSpl['FTXphShipAddNo']))? $aDataDocHDSpl['FTXphShipAddNo'] : "-";
        $tPOShipAddV1Soi        = (isset($aDataDocHDSpl['FTXphShipAddPoi']) && !empty($aDataDocHDSpl['FTXphShipAddPoi']))? $aDataDocHDSpl['FTXphShipAddPoi'] : "-";
        $tPOShipAddV1Village    = (isset($aDataDocHDSpl['FTXphShipAddVillage']) && !empty($aDataDocHDSpl['FTXphShipAddVillage']))? $aDataDocHDSpl['FTXphShipAddVillage'] : "-";
        $tPOShipAddV1Road       = (isset($aDataDocHDSpl['FTXphShipAddRoad']) && !empty($aDataDocHDSpl['FTXphShipAddRoad']))? $aDataDocHDSpl['FTXphShipAddRoad'] : "-";
        $tPOShipAddV1SubDist    = (isset($aDataDocHDSpl['FTXphShipSubDistrict']) && !empty($aDataDocHDSpl['FTXphShipSubDistrict']))? $aDataDocHDSpl['FTXphShipSubDistrict'] : "-";
        $tPOShipAddV1DstCode    = (isset($aDataDocHDSpl['FTXphShipDistrict']) && !empty($aDataDocHDSpl['FTXphShipDistrict']))? $aDataDocHDSpl['FTXphShipDistrict'] : "-";
        $tPOShipAddV1PvnCode    = (isset($aDataDocHDSpl['FTXphShipProvince']) && !empty($aDataDocHDSpl['FTXphShipProvince']))? $aDataDocHDSpl['FTXphShipProvince'] : "-";
        $tPOShipAddV1PostCode   = (isset($aDataDocHDSpl['FTXphShipPosCode']) && !empty($aDataDocHDSpl['FTXphShipPosCode']))? $aDataDocHDSpl['FTXphShipPosCode'] : "-";

        // ที่อยู่สำหรับการออกใบกำกับภาษี
        $tPOSplTaxAdd           = $aDataDocHDSpl['FNXphTaxAdd'];
        $tPOTexAddAddV1No       = (isset($aDataDocHDSpl['FTXphTaxAddNo']) && !empty($aDataDocHDSpl['FTXphTaxAddNo']))? $aDataDocHDSpl['FTXphTaxAddNo'] : "-";
        $tPOTexAddV1Soi         = (isset($aDataDocHDSpl['FTXphTaxAddPoi']) && !empty($aDataDocHDSpl['FTXphTaxAddPoi']))? $aDataDocHDSpl['FTXphTaxAddPoi'] : "-";
        $tPOTexAddV1Village     = (isset($aDataDocHDSpl['FTXphTaxAddVillage']) && !empty($aDataDocHDSpl['FTXphTaxAddVillage']))? $aDataDocHDSpl['FTXphTaxAddVillage'] : "-";
        $tPOTexAddV1Road        = (isset($aDataDocHDSpl['FTXphTaxAddRoad']) && !empty($aDataDocHDSpl['FTXphTaxAddRoad']))? $aDataDocHDSpl['FTXphTaxAddRoad'] : "-";
        $tPOTexAddV1SubDist     = (isset($aDataDocHDSpl['FTXphTaxSubDistrict']) && !empty($aDataDocHDSpl['FTXphTaxSubDistrict']))? $aDataDocHDSpl['FTXphTaxSubDistrict'] : "-";
        $tPOTexAddV1DstCode     = (isset($aDataDocHDSpl['FTXphTaxDistrict']) && !empty($aDataDocHDSpl['FTXphTaxDistrict']))? $aDataDocHDSpl['FTXphTaxDistrict'] : "-";
        $tPOTexAddV1PvnCode     = (isset($aDataDocHDSpl['FTXphTaxProvince']) && !empty($aDataDocHDSpl['FTXphTaxProvince']))? $aDataDocHDSpl['FTXphTaxProvince'] : "-";
        $tPOTexAddV1PostCode    = (isset($aDataDocHDSpl['FTXphTaxPosCode']) && !empty($aDataDocHDSpl['FTXphTaxPosCode']))? $aDataDocHDSpl['FTXphTaxPosCode'] : "-";

        $tPOVatCodeBySPL        = $aDetailSPL['FTVatCode'];
        $tPOVatRateBySPL        = $aDetailSPL['FCXpdVatRate'];

    }else{
        $tPORoute               = "docPOEventAdd";
        $nPOAutStaEdit          = 0;
        $tPODocNo               = "";
        $dPODocDate             = "";
        $dPODocTime             = "";
        $tPOCreateBy            = $this->session->userdata('tSesUsrUsername');
        $tPOUsrNameCreateBy     = $this->session->userdata('tSesUsrUsername');
        $nPOStaRef              = 0;
        $tPOStaRefund           = 1;
        $tPOStaDoc              = 1;
        $tPOStaApv              = NULL;
        $tPOStaPrcStk           = NULL;
        $tPOStaDelMQ            = NULL;
        $tPOStaPaid             = 1;

        $tPOSesUsrBchCode       = $this->session->userdata("tSesUsrBchCodeDefault");
        $tPODptCode             = $tDptCode;
        $tPOUsrCode             = $this->session->userdata('tSesUsername');
        $tPOLangEdit            = $this->session->userdata("tLangEdit");

        $tPOApvCode             = "";
        $tPOUsrNameApv          = "";
        $tPORefPoDoc            = "";
        $tPORefIntDoc           = "";
        $dPORefIntDocDate       = "";
        $tPORefExtDoc           = "";
        $dPORefExtDocDate       = "";


        $tPOBchCode             = $tBchCode;
        $tPOBchName             = $tBchName;
        $tPOUserBchCode         = $tBchCode;
        $tPOUserBchName         = $tBchName;
        $tPOBchCompCode         = $tBchCompCode;
        $tPOBchCompName         = $tBchCompName;
        $tPOMerCode             = $tMerCode;
        $tPOMerName             = $tMerName;
        $tPOShopType            = $tShopType;
        $tPOShopCode            = $tShopCode;
        $tPOShopName            = $tShopName;

        $tPOWahCode             = "";
        $tPOWahName             = "";
        $nPOStaDocAct           = "";
        $tPOFrmDocPrint         = 0;
        $tPOFrmRmk              = "";
        $tPOSplCode             = "";
        $tPOSplName             = "";

        $tPOCmpRteCode          = $tCmpRteCode;
        $cPORteFac              = $cXthRteFac;

        $tPOVatInOrEx           = $tCmpRetInOrEx;
        $tPOSplPayMentType      = "1";

        // ข้อมูลผู้จำหน่าย Supplier
        $tPOSplDstPaid          = "1";
        $tPOSplCrTerm           = "";
        $dPOSplDueDate          = "";
        $dPOSplBillDue          = "";
        $tPOSplCtrName          = "";
        $dPOSplTnfDate          = "";
        $tPOSplRefTnfID         = "";
        $tPOSplRefVehID         = "";
        $tPOSplRefInvNo         = "";
        $tPOSplQtyAndTypeUnit   = "";


        // ที่อยู่สำหรับการจัดส่ง
        $tPOSplShipAdd          = "";
        $tPOShipAddAddV1No      = "-";
        $tPOShipAddV1Soi        = "-";
        $tPOShipAddV1Village    = "-";
        $tPOShipAddV1Road       = "-";
        $tPOShipAddV1SubDist    = "-";
        $tPOShipAddV1DstCode    = "-";
        $tPOShipAddV1PvnCode    = "-";
        $tPOShipAddV1PostCode   = "-";

        // ที่อยู่สำหรับการออกใบกำกับภาษี
        $tPOSplTaxAdd           = "";
        $tPOTexAddAddV1No       = "-";
        $tPOTexAddV1Soi         = "-";
        $tPOTexAddV1Village     = "-";
        $tPOTexAddV1Road        = "-";
        $tPOTexAddV1SubDist     = "-";
        $tPOTexAddV1DstCode     = "-";
        $tPOTexAddV1PvnCode     = "-";
        $tPOTexAddV1PostCode    = "-";
        $tPOStaAlwPosCalSo   = "1";
        $tPOVatCodeBySPL        = "";
        $tPOVatRateBySPL        = "";
    }
    if(empty($tPOBchCode) && empty($tPOShopCode)){
        $tASTUserType   = "HQ";
    }else{
        if(!empty($tPOBchCode) && empty($tPOShopCode)){
            $tASTUserType   = "BCH";
        }else if( !empty($tPOBchCode) && !empty($tPOShopCode)){
            $tASTUserType   = "SHP";
        }else{
            $tASTUserType   = "";
        }
    }
?>
<form id="ofmPOFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdPOPage" name="ohdPOPage" value="1">
    <input type="hidden" id="ohdPOStaImport" name="ohdPOStaImport" value="0">
    <input type="hidden" id="ohdPORoute" name="ohdPORoute" value="<?php echo $tPORoute;?>">
    <input type="hidden" id="ohdPOCheckClearValidate" name="ohdPOCheckClearValidate" value="0">
    <input type="hidden" id="ohdPOCheckSubmitByButton" name="ohdPOCheckSubmitByButton" value="0">
    <input type="hidden" id="ohdPOAutStaEdit" name="ohdPOAutStaEdit" value="<?php echo $nPOAutStaEdit;?>">
    <input type="hidden" id="ohdPOODecimalShow" name="ohdPOODecimalShow" value="<?=$nOptDecimalShow?>">
    <input type="hidden" id="ohdPOStaRefund" name="ohdPOStaRefund" value="<?php echo $tPOStaRefund;?>">
    <input type="hidden" id="ohdPOStaDoc" name="ohdPOStaDoc" value="<?php echo $tPOStaDoc;?>">
    <input type="hidden" id="ohdPOStaApv" name="ohdPOStaApv" value="<?php echo $tPOStaApv;?>">
    <input type="hidden" id="ohdPOStaDelMQ" name="ohdPOStaDelMQ" value="<?php echo $tPOStaDelMQ; ?>">
    <input type="hidden" id="ohdPOStaPrcStk" name="ohdPOStaPrcStk" value="<?php echo $tPOStaPrcStk;?>">
    <input type="hidden" id="ohdPOStaPaid" name="ohdPOStaPaid" value="<?php echo $tPOStaPaid;?>">

    <input type="hidden" id="ohdPOSesUsrBchCode" name="ohdPOSesUsrBchCode" value="<?php echo $tPOSesUsrBchCode; ?>">
    <input type="hidden" id="ohdPOBchCode" name="ohdPOBchCode" value="<?php echo $tPOBchCode; ?>">
    <input type="hidden" id="ohdPODptCode" name="ohdPODptCode" value="<?php echo $tPODptCode;?>">
    <input type="hidden" id="ohdPOUsrCode" name="ohdPOUsrCode" value="<?php echo $tPOUsrCode?>">

    <input type="hidden" id="ohdPOCmpRteCode" name="ohdPOCmpRteCode" value="<?php echo $tPOCmpRteCode;?>">
    <input type="hidden" id="ohdPORteFac" name="ohdPORteFac" value="<?php echo $cPORteFac;?>">

    <input type="hidden" id="ohdPOApvCodeUsrLogin" name="ohdPOApvCodeUsrLogin" value="<?php echo $tPOUsrCode; ?>">
    <input type="hidden" id="ohdPOLangEdit" name="ohdPOLangEdit" value="<?php echo $tPOLangEdit; ?>">
    <input type="hidden" id="ohdPOOptAlwSaveQty" name="ohdPOOptAlwSaveQty" value="<?php echo $nOptDocSave?>">
    <input type="hidden" id="ohdPOOptScanSku" name="ohdPOOptScanSku" value="<?php echo $nOptScanSku?>">
    <input type="hidden" id="ohdPOVatRate" name="ohdPOVatRate" value="<?=$cVatRate?>">
    <input type="hidden" id="ohdPOCmpRetInOrEx" name="ohdPOCmpRetInOrEx" value="<?=$tCmpRetInOrEx?>">
    <input type="hidden" id="ohdSesSessionID" name="ohdSesSessionID" value="<?=$this->session->userdata('tSesSessionID')?>"  >
    <input type="hidden" id="ohdSesUsrLevel" name="ohdSesUsrLevel" value="<?=$this->session->userdata('tSesUsrLevel')?>"  >
    <input type="hidden" id="ohdSesUsrBchCom" name="ohdSesUsrBchCom" value="<?=$this->session->userdata('tSesUsrBchCom')?>"  >
    <input type="hidden" id="ohdPOValidatePdt" name="ohdPOValidatePdt" value="<?=language('document/purchaseorder/purchaseorder', 'tPOPleaseSeletedPDTIntoTable')?>">
    <input type="hidden" id="ohdPOSubmitWithImp" name="ohdPOSubmitWithImp" value="0">

    <input type="hidden" id="ohdPOValidatePdtImp" name="ohdPOValidatePdtImp" value="<?=language('document/purchaseorder/purchaseorder', 'tPONotFoundPdtCodeAndBarcodeImpList')?>">
    
    <button style="display:none" type="submit" id="obtPOSubmitDocument" onclick="JSxPOAddEditDocument()"></button>
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPOHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmStatus'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvPODataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPODataStatusInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="text-success xCNTitleFrom"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmAppove');?></label>
                                </div>
                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/purchaseorder/purchaseorder','tPOLabelAutoGenCode'); ?></label>
                                <?php if(isset($tPODocNo) && empty($tPODocNo)):?>
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbPOStaAutoGenCode" name="ocbPOStaAutoGenCode" maxlength="1" checked="checked">
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmAutoGenCode');?></span>
                                    </label>
                                </div>
                                <?php endif;?>
                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input
                                        type="text"
                                        class="form-control xCNGenarateCodeTextInputValidate xCNInputWithoutSpcNotThai"
                                        id="oetPODocNo"
                                        name="oetPODocNo"
                                        maxlength="20"
                                        value="<?php echo $tPODocNo;?>"
                                        data-validate-required="<?php echo language('document/purchaseorder/purchaseorder','tPOPlsEnterOrRunDocNo'); ?>"
                                        data-validate-duplicate="<?php echo language('document/purchaseorder/purchaseorder','tPOPlsDocNoDuplicate'); ?>"
                                        placeholder="<?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmDocNo');?>"
                                        style="pointer-events:none"
                                        readonly
                                    >
                                    <input type="hidden" id="ohdPOCheckDuplicateCode" name="ohdPOCheckDuplicateCode" value="2">
                                </div>
                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetPODocDate"
                                            name="oetPODocDate"
                                            value="<?php echo $dPODocDate; ?>"
                                            data-validate-required="<?php echo language('document/purchaseorder/purchaseorder','tPOPlsEnterDocDate'); ?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPODocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmDocTime');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNTimePicker xCNInputMaskTime"
                                            id="oetPODocTime"
                                            name="oetPODocTime"
                                            value="<?php echo $dPODocTime; ?>"
                                            data-validate-required="<?php echo language('document/purchaseorder/purchaseorder', 'tPOPlsEnterDocTime');?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPODocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmCreateBy');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdPOCreateBy" name="ohdPOCreateBy" value="<?php echo $tPOCreateBy?>">
                                            <label><?php echo $tPOUsrNameCreateBy?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <?php
                                                if($tPORoute == "docPOEventAdd"){
                                                    $tPOLabelStaDoc  = language('document/purchaseorder/purchaseorder', 'tPOLabelFrmValStaDoc');
                                                }else{
                                                    $tPOLabelStaDoc  = language('document/purchaseorder/purchaseorder', 'tPOLabelFrmValStaDoc'.$tPOStaDoc);
                                                }
                                            ?>
                                            <label><?php echo $tPOLabelStaDoc;?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmValStaApv'.$tPOStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะประมวลผลเอกสาร -->
                                <!-- <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmStaPrcStk'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmValStaPrcStk'.$tPOStaPrcStk); ?></label>
                                        </div>
                                    </div>
                                </div> -->
                             <!-- สถานะอ้างอิงเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmStaRef'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">

                                            <label><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmStaRef'.$nPOStaRef); ?></label>

                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($tPODocNo) && !empty($tPODocNo)):?>
                                    <!-- ผู้อนุมัติเอกสาร -->
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdPOApvCode" name="ohdPOApvCode" maxlength="20" value="<?php echo $tPOApvCode?>">
                                                <label>
                                                    <?php echo (isset($tPOUsrNameApv) && !empty($tPOUsrNameApv))? $tPOUsrNameApv : "-" ?>
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



            <!-- Panel ข้อมูลอ้างอิง -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPOReferenceDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmReference');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPODataReferenceDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPODataReferenceDoc" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-t-10">
                                <!-- อ้างอิงเลขที่เอกสารใบขอซื้อ -->
                                <div class="form-group xCNHide">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmRefPo');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetPORefPoDoc"
                                        name="oetPORefPoDoc"
                                        maxlength="20"
                                        value="<?php echo $tPORefPoDoc;?>"
                                    >
                                </div>
                                <!-- อ้างอิงเลขที่เอกสารภายใน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmRefIntDoc');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetPORefIntDoc"
                                        name="oetPORefIntDoc"
                                        maxlength="20"
                                        value="<?php echo $tPORefIntDoc;?>"
                                    >
                                </div>
                                <!-- วันที่อ้างอิงเลขที่เอกสารภายใน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmRefIntDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetPORefIntDocDate"
                                            name="oetPORefIntDocDate"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dPORefIntDocDate;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPOBrowseRefIntDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- อ้างอิงเลขที่เอกสารภายนอก -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmRefExtDoc');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetPORefExtDoc"
                                        name="oetPORefExtDoc"
                                        value="<?php echo $tPORefExtDoc;?>"
                                    >
                                </div>
                                <!-- วันที่เอกสารภายนอก -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmRefExtDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetPORefExtDocDate"
                                            name="oetPORefExtDocDate"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dPORefExtDocDate;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPOBrowseRefExtDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
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
                <div id="odvPOConditionDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmConditionDoc'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPODataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPODataConditionDoc" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- Condition สาขา -->
                                <div class="form-group m-b-0">
                                    <?php
                                        $tPODataInputBchCode   = "";
                                        $tPODataInputBchName   = "";
                                        if($tPORoute  == "docPOEventAdd"){
                                            $tPODataInputBchCode    = $this->session->userdata('tSesUsrBchCodeDefault');
                                            $tPODataInputBchName    = $this->session->userdata('tSesUsrBchNameDefault');
                                            $tDisabledBch = '';
                                        }else{
                                            $tPODataInputBchCode    = $tPOBchCode;
                                            $tPODataInputBchName    = $tPOBchName;
                                            $tDisabledBch = 'disabled';
                                        }
                                    ?>
                                <!--สาขา-->
                                <script>
                                    var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                                    if( tUsrLevel != "HQ" ){
                                        //BCH - SHP
                                        var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
                                        if(tBchCount < 2){
                                            $('#obtPOBrowseBCH').attr('disabled',true);
                                        }
                                    }
                                </script>
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmBranch')?></label>
												<div class="input-group">
													<input
														type="text"
														class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
														id="oetPOFrmBchCode"
														name="oetPOFrmBchCode"
														maxlength="5"
														value="<?php echo @$tPODataInputBchCode?>"
                                                        data-bchcodeold = "<?php echo @$tPODataInputBchCode?>"
													>
													<input
														type="text"
														class="form-control xWPointerEventNone"
														id="oetPOFrmBchName"
														name="oetPOFrmBchName"
														maxlength="100"
														placeholder="<?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmBranch')?>"
														value="<?php echo @$tPODataInputBchName?>"
														readonly
													>
													<span class="input-group-btn xWConditionSearchPdt">
														<button id="obtPOBrowseBCH" type="button" class="btn xCNBtnBrowseAddOn "    <?=$tDisabledBch?>>
															<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
														</button>
													</span>
												</div>
											</div>

                                </div>
                                <!-- Condition กลุ่มธุรกิจ -->
                                <div class="form-group <?php if( !FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>" >
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmMerchant');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetPOFrmMerCode" name="oetPOFrmMerCode" maxlength="5" value="<?php echo $tPOMerCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetPOFrmMerName" name="oetPOFrmMerName" lavudate-label="<?php echo language('document/purchaseorder/purchaseorder', 'tPOFrmMerCode');?>" value="<?php echo $tPOMerName;?>" readonly>
                                        <?php
                                            $tDisabledBtnMerchant = "";
                                            if($tPORoute == "docPOEventAdd"){
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
                                            <button id="obtPOBrowseMerchant" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnMerchant;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition ร้านค้า -->
                                <div class="form-group <?php if( !FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>" >
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmShop');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetPOFrmShpCode" name="oetPOFrmShpCode" maxlength="5" value="<?php echo $tPOShopCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetPOFrmShpName" name="oetPOFrmShpName" lavudate-label="<?php echo language('document/purchaseorder/purchaseorder', 'tPOFrmShpCode');?>" value="<?php echo $tPOShopName;?>" readonly>
                                        <?php
                                            $tDisabledBtnShop = "";
                                            if($tPORoute == "docPOEventAdd"){
                                                $tDisabledBtnShop   = "disabled";
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnShop   = "disabled";
                                                }else{
                                                    if(empty($tPOShopCode) && empty($tPOShopName)){
                                                        $tDisabledBtnShop   = "disabled";
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnShop;?>">
                                            <button id="obtPOBrowseShop" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnShop;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition เครื่องจุดขาย -->
                              <div class="form-group" style="display:none">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmPos');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetPOFrmPosCode" name="oetPOFrmPosCode" maxlength="5" value="<?php  //$tPOPosCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetPOFrmPosName" name="oetPOFrmPosName" lavudate-label="<?php echo language('document/purchaseorder/purchaseorder', 'tPOFrmPosCode');?>" value="<?php //$tPOPosCode;?>" readonly>
                                        <?php
                                            $tDisabledBtnPos    = "";
                                            if($tPORoute == "docPOEventAdd"){
                                                $tDisabledBtnPos    = "disabled";
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnPos    = "disabled";
                                                }else{
                                                    if(empty($tPOPosCode)){
                                                        $tDisabledBtnPos    = "disabled";
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnPos;?>">
                                            <button id="obtPOBrowsePos" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnPos;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition คลังสินค้า -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmWah');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetPOFrmWahCode" name="oetPOFrmWahCode" maxlength="5" value="<?php echo $tPOWahCode;?>">
                                        <input
                                            type="text"
                                            class="form-control xWPointerEventNone"
                                            id="oetPOFrmWahName"
                                            name="oetPOFrmWahName"
                                            value="<?php echo $tPOWahName;?>"
                                            data-validate-required="<?php echo language('document/purchaseorder/purchaseorder','tPOPlsEnterWah'); ?>"
                                            readonly
                                        >
                                        <?php
                                            $tDisabledBtnWah    = "";
                                            if($tPORoute == "docPOEventAdd"){
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnWah    = "disabled";
                                                }
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnWah    = "disabled";
                                                }else{
                                                    if(!empty($tPOMerCode) && !empty($tPOShopCode) && !empty($tPOWahCode)){
                                                        $tDisabledBtnWah    = "disabled";
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnWah;?>">
                                            <button id="obtPOBrowseWahouse" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnWah;?>">
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


            <!-- Panel Supplier Info -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPISupplierInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoDoc');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPIDataSupplierInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPIDataSupplierInfo" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div id="odvRowPanelSplInfo" class="row"  style="max-height:350px;overflow-x:auto">
                            <div class="col-xs-12 col-sm-12 col-col-md-12 col-lg-12">
                                <!-- ประเภทภาษี -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoVatInOrEx');?></label>
                                    <?php
                                        switch($tPOVatInOrEx){
                                            case '1':
                                                $tOptionVatIn   = "selected";
                                                $tOptionVatEx   = "";
                                            break;
                                            case '2':
                                                $tOptionVatIn   = "";
                                                $tOptionVatEx   = "selected";
                                            break;
                                            default:
                                                $tOptionVatIn   = "selected";
                                                $tOptionVatEx   = "";
                                        }
                                    ?>
                                    <select class="selectpicker form-control xWPIDisabledOnApv xWConditionSearchPdt" id="ocmPOFrmSplInfoVatInOrEx" name="ocmPOFrmSplInfoVatInOrEx" maxlength="1">
                                        <option value="1" <?php echo @$tOptionVatIn;?>><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoVatInclusive');?></option>
                                        <option value="2" <?php echo @$tOptionVatEx;?>><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoVatExclusive');?></option>
                                    </select>
                                </div>
                                <input type="hidden" id="ohdPOFrmSplVatRate" name="ohdPOFrmSplVatRate" value="<?=$tPOVatRateBySPL?>">
                                <input type="hidden" id="ohdPOFrmSplVatCode" name="ohdPOFrmSplVatCode" value="<?=$tPOVatCodeBySPL?>">

                                <!-- ประเภทการชำระ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoPaymentType');?></label>
                                    <select class="selectpicker form-control xWPIDisabledOnApv xWConditionSearchPdt" id="ocmPOFrmSplInfoPaymentType" name="ocmPOFrmSplInfoPaymentType" maxlength="1" value="<?php echo $tPOSplPayMentType;?>">
                                        <option value="1" <?php if($tPOSplPayMentType=='1'){ echo 'selected'; } ?>><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoPaymentType1');?></option>
                                        <option value="2" <?php if($tPOSplPayMentType=='2'){ echo 'selected'; } ?>><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoPaymentType2');?></option>
                                    </select>
                                </div>
                                <!-- วิธีการชำระเงิน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoDstPaid');?></label>
                                    <select class="selectpicker form-control xWPIDisabledOnApv xWConditionSearchPdt" id="ocmPOFrmSplInfoDstPaid" name="ocmPOFrmSplInfoDstPaid" maxlength="1" value="<?php echo $tPOSplDstPaid;?>">
                                        <option value="1" <?php if($tPOSplDstPaid=='1'){ echo 'selected'; } ?>><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoDstPaid1');?></option>
                                        <option value="2" <?php if($tPOSplDstPaid=='2'){ echo 'selected'; } ?>><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoDstPaid2');?></option>
                                    </select>
                                </div>
                                <!-- ระยะเครดิต -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoCrTerm');?></label>
                                    <input
                                        type="text"
                                        class="form-control text-right xCNInputNumericWithoutDecimal xWPIDisabledOnApv xWConditionSearchPdt"
                                        id="oetPOFrmSplInfoCrTerm"
                                        name="oetPOFrmSplInfoCrTerm"
                                        value="<?php echo $tPOSplCrTerm;?>"
                                    >
                                </div>
                                <!-- วันครบกำหนดชำระเงิน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoDueDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate xWConditionSearchPdt"
                                            id="oetPOFrmSplInfoDueDate"
                                            name="oetPOFrmSplInfoDueDate"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dPOSplDueDate;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPOFrmSplInfoDueDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- วันวางบิล -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoBillDue');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate xWConditionSearchPdt"
                                            id="oetPOFrmSplInfoBillDue"
                                            name="oetPOFrmSplInfoBillDue"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dPOSplBillDue;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPOFrmSplInfoBillDue" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- วันที่ขนส่ง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoTnfDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate xWConditionSearchPdt"
                                            id="oetPOFrmSplInfoTnfDate"
                                            name="oetPOFrmSplInfoTnfDate"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dPOSplTnfDate;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPOFrmSplInfoTnfDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ชื่อผู้ติดต่อ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoCtrName');?></label>
                                    <input
                                        type="text"
                                        class="form-control xWPIDisabledOnApv xWConditionSearchPdt"
                                        id="oetPOFrmSplInfoCtrName"
                                        name="oetPOFrmSplInfoCtrName"
                                        value="<?php echo $tPOSplCtrName;?>"
                                    >
                                </div>
                                <!-- เลขที่ขนส่ง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoRefTnfID');?></label>
                                    <input
                                        type="text"
                                        class="form-control xWPIDisabledOnApv xWConditionSearchPdt"
                                        id="oetPOFrmSplInfoRefTnfID"
                                        name="oetPOFrmSplInfoRefTnfID"
                                        value="<?php echo $tPOSplRefTnfID;?>"
                                    >
                                </div>
                                <!-- อ้างอิงเลขที่ขนส่ง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoRefVehID');?></label>
                                    <input
                                        type="text"
                                        class="form-control xWPIDisabledOnApv xWConditionSearchPdt"
                                        id="oetPOFrmSplInfoRefVehID"
                                        name="oetPOFrmSplInfoRefVehID"
                                        value="<?php echo $tPOSplRefVehID;?>"
                                    >
                                </div>
                                <!-- เลขที่บัญชีราคาสินค้า -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoRefInvNo');?></label>
                                    <input
                                        type="text"
                                        class="form-control xWPIDisabledOnApv xWConditionSearchPdt"
                                        id="oetPOFrmSplInfoRefInvNo"
                                        name="oetPOFrmSplInfoRefInvNo"
                                        value="<?php echo $tPOSplRefInvNo;?>"
                                    >
                                </div>
                                <!-- จำนวนและลักษณะหีบห่อ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoQtyAndTypeUnit');?></label>
                                    <input
                                        type="text"
                                        class="form-control xWPIDisabledOnApv xWConditionSearchPdt"
                                        id="oetPOFrmSplInfoQtyAndTypeUnit"
                                        name="oetPOFrmSplInfoQtyAndTypeUnit"
                                        value="<?php echo $tPOSplQtyAndTypeUnit;?>"
                                    >
                                </div>
                            </div>
                        </div>


                        <div id="odvRowPanelBtnGrpSplInfo" class="row" style="padding-top:20px;">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <input type="hidden" id="ohdPOFrmShipAdd" name="ohdPOFrmShipAdd" value="<?php echo $tPOSplShipAdd;?>">
                                <button type="button" id="obtPOFrmBrowseShipAdd" class="btn btn-primary xWPIDisabledOnApv" style="width:100%;">
                                    +&nbsp;<?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoShipAddress');?>
                                </button>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <input type="hidden" id="ohdPOFrmTaxAdd" name="ohdPOFrmTaxAdd" value="<?php echo $tPOSplTaxAdd;?>">
                                <button type="button" id="obtPOFrmBrowseTaxAdd" class="btn btn-primary xWPIDisabledOnApv" style="width:100%;">
                                    +&nbsp;<?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmSplInfoTaxAddress');?>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Panel อืนๆ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPOInfoOther" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOth');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPODataInfoOther" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPODataInfoOther" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                                <!-- สถานะความเคลื่อนไหว -->
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" value="1" id="ocbPOFrmInfoOthStaDocAct" name="ocbPOFrmInfoOthStaDocAct" maxlength="1" <?php echo ($nPOStaDocAct == '1' || empty($nPOStaDocAct)) ? 'checked' : ''; ?>>
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthStaDocAct'); ?></span>
                                    </label>
                                </div>
                                <!-- สถานะอ้างอิง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthRef');?></label>
                                    <select class="selectpicker form-control" id="ocmPOFrmInfoOthRef" name="ocmPOFrmInfoOthRef" maxlength="1">
                                        <option value="0" selected><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthRef0');?></option>
                                        <option value="1"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthRef1');?></option>
                                        <option value="2"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthRef2');?></option>
                                    </select>
                                </div>
                                <!-- จำนวนครั้งที่พิมพ์ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthDocPrint');?></label>
                                    <input
                                        type="text"
                                        class="form-control text-right"
                                        id="ocmPOFrmInfoOthDocPrint"
                                        name="ocmPOFrmInfoOthDocPrint"
                                        value="<?php echo $tPOFrmDocPrint;?>"
                                        readonly
                                    >
                                </div>
                                <!-- กรณีเพิ่มสินค้ารายการเดิม -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthReAddPdt');?></label>
                                    <select class="form-control selectpicker" id="ocmPOFrmInfoOthReAddPdt" name="ocmPOFrmInfoOthReAddPdt">
                                        <option value="1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthReAddPdt1');?></option>
                                        <option value="2" selected><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthReAddPdt2');?></option>
                                    </select>
                                </div>
                                <!-- หมายเหตุ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthRemark');?></label>
                                    <textarea
                                        class="form-control xWConditionSearchPdt"
                                        id="otaPOFrmInfoOthRmk"
                                        name="otaPOFrmInfoOthRmk"
                                        rows="10"
                                        maxlength="200"
                                        style="resize: none;height:86px;"
                                    ><?php echo $tPOFrmRmk?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div class="row">
                <!-- ตารางรายการสินค้า -->
                <div id="odvPODataPanelDetailPDT" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:500px;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">
                                <div class="row p-t-10">
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOTBSpl');?></label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetPOFrmSplCode" name="oetPOFrmSplCode" value="<?php echo $tPOSplCode;?>">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="oetPOFrmSplName"
                                                    name="oetPOFrmSplName"
                                                    value="<?php echo $tPOSplName;?>"
                                                    placeholder="<?php echo language('document/purchaseorder/purchaseorder','tPOMsgValidSplCode') ?>"
                                                    readonly
                                                >
                                                <span class="input-group-btn">
                                                    <button id="obtPOBrowseSupplier" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-t-10">

                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="100"
                                                    id="oetPOFrmFilterPdtHTML"
                                                    name="oetPOFrmFilterPdtHTML"
                                                    placeholder="<?php echo language('document/purchaseorder/purchaseorder','tPOFrmFilterTablePdt');?>"
                                                    onkeyup="javascript:if(event.keyCode==13) JSvPODOCFilterPdtInTableTemp()"
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="100"
                                                    id="oetPOFrmSearchAndAddPdtHTML"
                                                    name="oetPOFrmSearchAndAddPdtHTML"
                                                    onkeyup="Javascript:if(event.keyCode==13) JSxPOChkConditionSearchAndAddPdt()"
                                                    placeholder="<?php echo language('document/purchaseorder/purchaseorder','tPOFrmSearchAndAddPdt');?>"
                                                    style="display:none;"
                                                    data-validate="<?php echo language('document/purchaseorder/purchaseorder','tPOMsgValidScanNotFoundBarCode');?>"
                                                >
                                                <span class="input-group-btn">
                                                    <div id="odvPOSearchAndScanBtnGrp" class="xCNDropDrownGroup input-group-append">
                                                        <button id="obtPOMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvPODOCFilterPdtInTableTemp()">
                                                            <i class="fa fa-filter" style="width:20px;"></i>
                                                        </button>
                                                        <!-- <button id="obtPOMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSxPOChkConditionSearchAndAddPdt()">
                                                            <i class="fa fa-search" style="width:20px;"></i>
                                                        </button>
                                                        <button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown" style="display:none;">
                                                            <i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
                                                        </button> -->
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a id="oliPOMngPdtSearch"><label><?php echo language('document/purchaseorder/purchaseorder','tPOFrmFilterTablePdt'); ?></label></a>
                                                                <a id="oliPOMngPdtScan"><?php echo language('document/purchaseorder/purchaseorder','tPOFrmSearchAndAddPdt'); ?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">

                                        <div class="row">

                                            <!--นำเข้า-->
                                            <div id="odvPOMngAdvTableList" class="btn-group xCNDropDrownGroup">
                                                <button type="button" class="btn xCNBTNMngTable xCNImportBtn xWConditionSearchPdt" style="margin-right:10px;" onclick="JSxOpenImportForm()">
                                                    <?= language('common/main/main', 'tImport') ?>
                                                </button>
                                            </div>
                                            <!--ตัวเลือก-->
                                            <div id="odvPOMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
                                                <button type="button" class="btn xCNBTNMngTable xWConditionSearchPdt" data-toggle="dropdown">
                                                    <?php echo language('common/main/main','tCMNOption')?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li id="oliPOBtnDeleteMulti" class="disabled">
                                                        <a data-toggle="modal" data-target="#odvPOModalDelPdtInDTTempMultiple"><?php echo language('common/main/main','tDelAll')?></a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <!--ค้นหาจากบาร์โค๊ด-->
                                        <div class="form-group" style="width: 85%;">
                                            <input type="text" class="form-control" id="oetPOInsertBarcode" autocomplete="off" name="oetPOInsertBarcode" maxlength="50" value="" onkeypress="Javascript:if(event.keyCode==13) JSxSearchFromBarcode(event,this);"  placeholder="เพิ่มสินค้าด้วยบาร์โค้ด หรือ รหัสสินค้า" >
                                        </div>

                                        <!--เพิ่มสินค้าแบบปกติ-->
                                        <div class="form-group">
                                            <div style="position: absolute;right: 15px;top:-5px;">
                                                <button type="button" id="obtPODocBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt">+</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row p-t-10" id="odvPODataPdtTableDTTemp">

                                </div>
                          <!--ส่วนสรุปท้ายบิล-->
<div class="row" id="odvRowDataEndOfBill">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading mark-font" id="odvDataTextBath"></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left mark-font"><?=language('document/purchaseorder/purchaseorder','tPOTBVatRate');?></div>
                <div class="pull-right mark-font"><?=language('document/purchaseorder/purchaseorder','tPOTBAmountVat');?></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <ul class="list-group" id="oulDataListVat">
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?=language('document/purchaseorder/purchaseorder','tPOTBTotalValVat');?></label>
                <label class="pull-right mark-font" id="olbVatSum">0.00</label>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- End Of Bill -->
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <label class="pull-left mark-font"><?=language('document/purchaseorder/purchaseorder','tPOTBSumFCXtdNet');?></label>
                        <input type="text" id="olbSumFCXtdNetAlwDis" style="display:none;"></label>
                        <label class="pull-right mark-font" id="olbSumFCXtdNet">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/purchaseorder/purchaseorder','tPOTBDisChg');?>
                            <button type="button" class="xCNBTNPrimeryDisChgPlus" onclick="JCNvPOMngDocDisChagHD(this)" style="float: right; margin-top: 3px; margin-left: 5px;">+</button>
                        </label>
                        <label class="pull-left" style="margin-left: 5px;" id="olbDisChgHD"></label>
                        <label class="pull-right" id="olbSumFCXtdAmt">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/purchaseorder/purchaseorder','tPOTBSumFCXtdNetAfHD');?></label>
                        <label class="pull-right" id="olbSumFCXtdNetAfHD">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/purchaseorder/purchaseorder','tPOTBSumFCXtdVat');?></label>
                        <label class="pull-right" id="olbSumFCXtdVat">0.00</label>
                        <input type="hidden" name="ohdSumFCXtdVat" id="ohdSumFCXtdVat" value="0.00">
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?=language('document/purchaseorder/purchaseorder','tPOTBFCXphGrand');?></label>
                <label class="pull-right mark-font" id="olbCalFCXphGrand">0.00</label>
                <div class="clearfix"></div>
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
    </div>
</form>

<!-- =================================================================== View Modal Shipping Purchase Invoice  =================================================================== -->
    <div id="odvPOBrowseShipAdd" class="modal fade">
        <div class="modal-dialog" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/purchaseorder/purchaseorder','tPOShipAddress'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnPOShipAddData()"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel panel-default" style="margin-bottom:5px;">
                                <div class="panel-heading" style="padding-top:5px!important;padding-bottom:5px!important;">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOShipAddInfo');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <a style="font-size:14px!important;color:#179bfd;">
                                                <i class="fa fa-pencil" id="oliPOEditShipAddress">&nbsp;<?php echo language('document/purchaseorder/purchaseorder','tPOShipChange');?></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body xCNPDModlue">
                                    <input type="hidden" id="ohdPOShipAddSeqNo" class="form-control">
                                    <?php $tPOFormatAddressType = FCNaHAddressFormat('TCNMBranch'); //1 ที่อยู่ แบบแยก  ,2  แบบรวม ?>
                                    <?php if(!empty($tPOFormatAddressType) && $tPOFormatAddressType == '1'): ?>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOShipADDV1No');?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOShipAddAddV1No"><?php echo @$tPOShipAddAddV1No;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOShipADDV1Village');?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOShipAddV1Soi"><?php echo @$tPOShipAddV1Soi;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOShipADDV1Soi'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOShipAddV1Village"><?php echo @$tPOShipAddV1Village;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOShipADDV1Road'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOShipAddV1Road"><?php echo @$tPOShipAddV1Road;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOShipADDV1SubDist'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOShipAddV1SubDist"><?php echo @$tPOShipAddV1SubDist;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOShipADDV1DstCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOShipAddV1DstCode"><?php echo @$tPOShipAddV1DstCode?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOShipADDV1PvnCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOShipAddV1PvnCode"><?php echo @$tPOShipAddV1PvnCode?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOShipADDV1PostCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOShipAddV1PostCode"><?php echo @$tPOShipAddV1PostCode;?></label>
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOShipADDV2Desc1')?></label><br>
                                                    <label id="ospPOShipAddV2Desc1"><?php echo @$tPOShipAddV2Desc1;?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOShipADDV2Desc2')?></label><br>
                                                    <label id="ospPOShipAddV2Desc2"><?php echo @$tPOShipAddV2Desc2;?></label>
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
    <div id="odvPOBrowseTexAdd" class="modal fade">
        <div class="modal-dialog" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/purchaseorder/purchaseorder','tPOTexAddress'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnPOTexAddData()"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel panel-default" style="margin-bottom:5px;">
                                <div class="panel-heading" style="padding-top:5px!important;padding-bottom:5px!important;">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTexAddInfo');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <a style="font-size:14px!important;color:#179bfd;">
                                                <i class="fa fa-pencil" id="oliPOEditTexAddress">&nbsp;<?php echo language('document/purchaseorder/purchaseorder','tPOTexChange');?></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body xCNPDModlue">
                                    <input type="hidden" id="ohdPOTexAddSeqNo" class="form-control">
                                    <?php $tPOFormatAddressType = FCNaHAddressFormat('TCNMBranch'); //1 ที่อยู่ แบบแยก  ,2  แบบรวม ?>
                                    <?php if(!empty($tPOFormatAddressType) && $tPOFormatAddressType == '1'): ?>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTexADDV1No');?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOTexAddAddV1No"><?php echo @$tPOTexAddAddV1No;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTexADDV1Village');?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOTexAddV1Soi"><?php echo @$tPOTexAddV1Soi;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTexADDV1Soi'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOTexAddV1Village"><?php echo @$tPOTexAddV1Village;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTexADDV1Road'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOTexAddV1Road"><?php echo @$tPOTexAddV1Road;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTexADDV1SubDist'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOTexAddV1SubDist"><?php echo @$tPOTexAddV1SubDist;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTexADDV1DstCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOTexAddV1DstCode"><?php echo @$tPOTexAddV1DstCode?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTexADDV1PvnCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOTexAddV1PvnCode"><?php echo @$tPOTexAddV1PvnCode?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTexADDV1PostCode'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPOTexAddV1PostCode"><?php echo @$tPOTexAddV1PostCode;?></label>
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOTexADDV2Desc1')?></label><br>
                                                    <label id="ospPOTexAddV2Desc1"><?php echo @$tPOTexAddV2Desc1;?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOTexADDV2Desc2')?></label><br>
                                                    <label id="ospPOTexAddV2Desc2"><?php echo @$tPOTexAddV2Desc2;?></label>
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

<!-- ======================================================================== View Modal Appove Document  ======================================================================== -->
    <div id="odvPOModalAppoveDoc" class="modal fade">
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
                    <button onclick="JSxPOApproveDocument(true)" type="button" class="btn xCNBTNPrimery">
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
                    <button onclick="JSnPOCancelDocument(true)" type="button" class="btn xCNBTNPrimery">
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
    <div class="modal fade" id="odvPOOrderAdvTblColumns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <div class="modal-body" id="odvPOModalBodyAdvTable">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
                    <button id="obtPOSaveAdvTableColums" type="button" class="btn btn-primary"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- ============================================================== View Modal Delete Product In DT DocTemp Multiple  ============================================================ -->
    <div id="odvPOModalDelPdtInDTTempMultiple" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main','tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                    <input type="hidden" id="ohdConfirmPODocNoDelete"   name="ohdConfirmPODocNoDelete">
                    <input type="hidden" id="ohdConfirmPOSeqNoDelete"   name="ohdConfirmPOSeqNoDelete">
                    <input type="hidden" id="ohdConfirmPOPdtCodeDelete" name="ohdConfirmPOPdtCodeDelete">
                    <input type="hidden" id="ohdConfirmPOPunCodeDelete" name="ohdConfirmPOPunCodeDelete">

                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- ======================================================================== Modal ไม่พบลูกค้า   ======================================================================== -->
<div id="odvPOModalPleseselectSPL" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tMessageAlert')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>กรุณาเลือกผู้จำหน่าย ก่อนเพิ่มสินค้า</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn xCNBTNPrimery" data-dismiss="modal" onclick="JSxFocusInputCustomer();">
                        <?=language('common/main/main', 'tCMNOK')?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- ======================================================================== Modal ไม่พบรหัสสินค้า ======================================================================== -->
<div id="odvPOModalPDTNotFound" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tMessageAlert')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>ไม่พบข้อมูลสินค้า กรุณาลองใหม่อีกครั้ง</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn xCNBTNPrimery" data-dismiss="modal" onclick="JSxNotFoundClose();" >
                        <?=language('common/main/main', 'tCMNOK')?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- ======================================================================== พบสินค้ามากกว่าหนึ่งตัว ======================================================================== -->
<div id="odvPOModalPDTMoreOne" class="modal fade">
        <div class="modal-dialog" role="document" style="width: 85%; margin: 1.75rem auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;">กรุณาเลือกสินค้า</label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JCNxConfirmPDTMoreOne(1)" data-dismiss="modal">เลือก</button>
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" onclick="JCNxConfirmPDTMoreOne(2)" data-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <table class="table table-striped xCNTablePDTMoreOne">
                        <thead>
                            <tr>
                                <th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('common/main/main', 'tModalcodePDT')?></th>
                                <th class="xCNTextBold" style="text-align:center; width:160px;"><?=language('common/main/main', 'tModalnamePDT')?></th>
                                <th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('common/main/main', 'tModalPriceUnit')?></th>
                                <th class="xCNTextBold" style="text-align:center; width:160px;"><?=language('common/main/main', 'tModalbarcodePDT')?></th>
                                <th class="xCNTextBold" style="text-align:center; width:120px;">ขายปลีก</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- ======================================================================== Modal ไม่พบรหัสสินค้า ======================================================================== -->
<div id="odvPOModalChangeBCH" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tMessageAlert')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>มีการเปลี่ยนแปลงสาขา สินค้าที่ทำรายการไว้ จะถูกล้างหมด กดยืนยันเพื่อเปลี่ยนแปลงสาขา ? </p>
                </div>
                <div class="modal-footer">
                    <button type="button"  data-dismiss="modal" id="obtChangeBCH" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm');?></button>
                    <button type="button"  data-dismiss="modal" class="btn xCNBTNDefult"><?php echo language('common/main/main', 'ยกเลิก');?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->



<!-- ======================================================================== Modal ไม่พบรหัสสินค้า ======================================================================== -->
<div id="odvPOModalImpackImportExcel" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tMessageAlert')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>ข้อมูลบางรายการไม่สมบูรณ์</p>
                    <p>&nbsp;&nbsp;&nbsp;กดยืนยัน เพื่อทำการบันทึกข้อมูล ระบบจะทำการบันทึกเฉพาะรายการที่สมบูรณ์เท่านั้น </p>
                    <p>&nbsp;&nbsp;&nbsp;กดยกเลิก เพื่อกลับไปตรวจสอบ</p>
                </div>
                <div class="modal-footer">
                    <button type="button"  data-dismiss="modal" id="obtPOImportConfirm" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm');?></button>
                    <button type="button"  data-dismiss="modal" class="btn xCNBTNDefult"><?php echo language('common/main/main', 'ยกเลิก');?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->



<script src="<?php echo base_url('application/modules/common/assets/src/jThaiBath.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jPurchaseOrderAdd.php');?>
<?php include('dis_chg/wPurchaseOrderDisChgModal.php'); ?>


<script>

    //บังคับให้เลือกลูกค้า
    function JSxFocusInputCustomer(){
        $('#oetPOFrmCstName').focus();
    }

    function JSxNotFoundClose(){
        $('#oetPOInsertBarcode').focus();
    }

    //กดเลือกบาร์โค๊ด
    function JSxSearchFromBarcode(e,elem){
        var tValue = $(elem).val();
        if($('#oetPOFrmSplName').val() != ""){
            JSxCheckPinMenuClose();
            if(tValue.length === 0){

            }else{
                // JCNxOpenLoading();
                $('#oetPOInsertBarcode').attr('readonly',true);
                JCNSearchBarcodePdt(tValue);
                $('#oetPOInsertBarcode').val('');
            }
        }else{
            $('#odvPOModalPleseselectSPL').modal('show');
            $('#oetPOInsertBarcode').val('');
        }
        e.preventDefault();
    }

    //ค้นหาบาร์โค๊ด
    function JCNSearchBarcodePdt(ptTextScan){

        var tWhereCondition = "";
        // if( tPISplCode != "" ){
        //     tWhereCondition = " AND FTPdtSetOrSN IN('1','2') ";
        // }

        var aMulti = [];
        $.ajax({
            type: "POST",
            url : "BrowseDataPDTTableCallView",
            data: {
                // aPriceType      : ['Price4Cst',tPOPplCode],
                aPriceType: ["Cost","tCN_Cost","Company","1"],
                NextFunc        : "",
                SPL             : $("#oetPOFrmSplCode").val(),
                BCH             : $("#oetPOFrmBchCode").val(),
                tInpSesSessionID : $('#ohdSesSessionID').val(),
                tInpUsrCode      : $('#ohdPOUsrCode').val(),
                tInpLangEdit     : $('#ohdPOLangEdit').val(),
                tInpSesUsrLevel  : $('#ohdSesUsrLevel').val(),
                tInpSesUsrBchCom : $('#ohdSesUsrBchCom').val(),
                Where            : [tWhereCondition],
                tTextScan       : ptTextScan
            },
            cache   : false,
            timeout : 0,
            success : function(tResult){
                // $('#oetPOInsertBarcode').attr('readonly',false);
                JCNxCloseLoading();
                var oText = JSON.parse(tResult);
                if(oText == '800'){
                    $('#oetPOInsertBarcode').attr('readonly',false);
                    $('#odvPOModalPDTNotFound').modal('show');
                    $('#oetPOInsertBarcode').val('');
                }else{
                    if(oText.length > 1){

                        // พบสินค้ามีหลายบาร์โค้ด
                        $('#odvPOModalPDTMoreOne').modal('show');
                        $('#odvPOModalPDTMoreOne .xCNTablePDTMoreOne tbody').html('');
                        for(i=0; i<oText.length; i++){
                            var aNewReturn      = JSON.stringify(oText[i]);
                            var tTest = "["+aNewReturn+"]";
                            var oEncodePackData = window.btoa(unescape(encodeURIComponent(tTest)));
                            var tHTML = "<tr class='xCNColumnPDTMoreOne"+i+" xCNColumnPDTMoreOne' data-information='"+oEncodePackData+"' style='cursor: pointer;'>";
                                tHTML += "<td>"+oText[i].pnPdtCode+"</td>";
                                tHTML += "<td>"+oText[i].packData.PDTName+"</td>";
                                tHTML += "<td>"+oText[i].packData.PUNName+"</td>";
                                tHTML += "<td>"+oText[i].ptBarCode+"</td>";
                                tHTML += "<td class='xCNTextRight' style='text-align: right;'>"+oText[i].packData.PriceRet+"</td>";
                                tHTML += "</tr>";
                            $('#odvPOModalPDTMoreOne .xCNTablePDTMoreOne tbody').append(tHTML);
                        }

                        //เลือกสินค้า
                        $('.xCNColumnPDTMoreOne').off();

                        //ดับเบิ้ลคลิก
                        $('.xCNColumnPDTMoreOne').on('dblclick',function(e){
                            $('#odvPOModalPDTMoreOne').modal('hide');
                            var tJSON = decodeURIComponent(escape(window.atob($(this).attr('data-information'))));
                            FSvPOAddPdtIntoDocDTTemp(tJSON); //Client
                            FSvPOAddBarcodeIntoDocDTTemp(tJSON);
                        });

                        //คลิกได้เลย
                        $('.xCNColumnPDTMoreOne').on('click',function(e){
                            //เลือกสินค้าแบบหลายตัว
                                // var tCheck = $(this).hasClass('xCNActivePDT');
                                // if($(this).hasClass('xCNActivePDT')){
                                //     //เอาออก
                                //     $(this).removeClass('xCNActivePDT');
                                //     $(this).children().attr('style', 'background-color:transparent !important; color:#232C3D !important');
                                // }else{
                                //     //เลือก
                                //     $(this).addClass('xCNActivePDT');
                                //     $(this).children().attr('style', 'background-color:#179bfd !important; color:#FFF !important');
                                // }

                            //เลือกสินค้าแบบตัวเดียว
                            $('.xCNColumnPDTMoreOne').removeClass('xCNActivePDT');
                            $('.xCNColumnPDTMoreOne').children().attr('style', 'background-color:transparent !important; color:#232C3D !important;');
                            $('.xCNColumnPDTMoreOne').children(':last-child').css('text-align','right');

                            $(this).addClass('xCNActivePDT');
                            $(this).children().attr('style', 'background-color:#179bfd !important; color:#FFF !important;');
                            $(this).children().last().css('text-align','right');
                        });
                    }else{
                        //มีตัวเดียว
                        var aNewReturn  = JSON.stringify(oText);
                        console.log('aNewReturn: '+aNewReturn);
                        // var aNewReturn  = '[{"pnPdtCode":"00009","ptBarCode":"ca2020010003","ptPunCode":"00001","packData":{"SHP":null,"BCH":null,"PDTCode":"00009","PDTName":"ขนม_03","PUNCode":"00001","Barcode":"ca2020010003","PUNName":"ขวด","PriceRet":"17.00","PriceWhs":"0.00","PriceNet":"0.00","IMAGE":"D:/xampp/htdocs/Moshi-Moshi/application/modules/product/assets/systemimg/product/00009/Img200128172902CEHHRSS.jpg","LOCSEQ":"","Remark":"ขนม_03","CookTime":0,"CookHeat":0}}]';
                        FSvPOAddPdtIntoDocDTTemp(aNewReturn); //Client
                        // JCNxCloseLoading();
                        // $('#oetPOInsertBarcode').attr('readonly',false);
                        // $('#oetPOInsertBarcode').val('');
                        FSvPOAddBarcodeIntoDocDTTemp(aNewReturn); //Server
                    }
                }
            },
            error: function (jqXHR,textStatus,errorThrown){
                // JCNxResponseError(jqXHR,textStatus,errorThrown);
                JCNSearchBarcodePdt(ptTextScan);
            }
        });
    }

    //เลือกสินค้า กรณีพบมากกว่าหนึ่งตัว
    function JCNxConfirmPDTMoreOne($ptType){
        if($ptType == 1){
            $("#odvPOModalPDTMoreOne .xCNTablePDTMoreOne tbody .xCNActivePDT").each(function( index ) {
                var tJSON = decodeURIComponent(escape(window.atob($(this).attr('data-information'))));
                FSvPOAddPdtIntoDocDTTemp(tJSON);
                FSvPOAddBarcodeIntoDocDTTemp(tJSON);
            });
        }else{
            $('#oetPOInsertBarcode').attr('readonly',false);
            $('#oetPOInsertBarcode').val('');
        }
    }

    //หลังจากค้นหาเสร็จแล้ว
    function FSvPOAddBarcodeIntoDocDTTemp(ptPdtData){
        var nStaSession = 1;
        if (typeof nStaSession !== "undefined" && nStaSession == 1){
            // JCNxOpenLoading();
            var ptXthDocNoSend  = "";
            if ($("#ohdPORoute").val() == "docPOEventEdit") {
                ptXthDocNoSend  = $("#oetPODocNo").val();
            }
            var tPOVATInOrEx    = $('#ocmPOFrmSplInfoVatInOrEx').val();
            var tPOOptionAddPdt = $('#ocmPOFrmInfoOthReAddPdt').val();
            let tPOPplCodeBch   = $('#ohdPOPplCodeBch').val();
            let tPOPplCodeCst   = $('#ohdPOPplCodeCst').val();
            var nKey            = parseInt($('#otbPODocPdtAdvTableList tr:last').attr('data-seqno'));

            $('#oetPOInsertBarcode').attr('readonly',false);
            $('#oetPOInsertBarcode').val('');

            $.ajax({
                type: "POST",
                url: "docPOAddPdtIntoDTDocTemp",
                data: {
                    'tSelectBCH'        : $('#oetPOFrmBchCode').val(),
                    'tPODocNo'          : ptXthDocNoSend,
                    'tPOVATInOrEx'      : tPOVATInOrEx,
                    'tPOOptionAddPdt'   : tPOOptionAddPdt,
                    'tPOPdtData'        : ptPdtData,
                    'tPOPplCodeBch'     : tPOPplCodeBch,
                    'tPOPplCodeCst'     : tPOPplCodeCst,
                    'ohdSesSessionID'   : $('#ohdSesSessionID').val(),
                    'ohdPOUsrCode'        : $('#ohdPOUsrCode').val(),
                    'ohdPOLangEdit'       : $('#ohdPOLangEdit').val(),
                    'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
                    'ohdPOSesUsrBchCode'  : $('#ohdPOSesUsrBchCode').val(),
                    'tSeqNo'              : nKey,
                    'nVatRate'            : $('#ohdPOFrmSplVatRate').val(),
                    'nVatCode'            : $('#ohdPOFrmSplVatCode').val()
                },
                cache: false,
                timeout: 0,
                success: function (oResult){
                    // JSvPOLoadPdtDataTableHtml();
                  var aResult =  JSON.parse(oResult);

                    if(aResult['nStaEvent']==1){
                        JCNxCloseLoading();
                        // $('#oetPOInsertBarcode').attr('readonly',false);
                        // $('#oetPOInsertBarcode').val('');
                        if(tPOOptionAddPdt=='1'){
                            JSvPOCallEndOfBill();
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // JCNxResponseError(jqXHR, textStatus, errorThrown);
                    FSvPOAddBarcodeIntoDocDTTemp(ptPdtData);
                }
            });
        }else{
            JCNxphowMsgSessionExpired();
        }
    }
</script>
