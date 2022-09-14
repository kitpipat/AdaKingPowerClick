<?php
    $tSesUsrLevel   = $this->session->userdata('tSesUsrLevel');
    if(isset($aDataDocHD) && $aDataDocHD['rtCode'] == '1'){
        // print_r($aDataDocHD['raItems']);
        $aDataDocHD             = @$aDataDocHD['raItems'];
        $aDataDocHDSpl          = @$aDataDocHDSpl['raItems'];

        $tRSRoute               = "dcmRSEventEdit";
        $nRSAutStaEdit          = 1;
        $tRSDocNo               = $aDataDocHD['FTXshDocNo'];
        $dRSDocDate             = date("Y-m-d",strtotime($aDataDocHD['FDXshDocDate']));
        $dRSDocTime             = date("H:i",strtotime($aDataDocHD['FDXshDocDate']));
        $tRSCreateBy            = $aDataDocHD['FTCreateBy'];
        $tRSUsrNameCreateBy     = $aDataDocHD['FTUsrName'];

        $tRSStaRefund           = $aDataDocHD['FTXshStaRefund'];
        $tRSStaDoc              = $aDataDocHD['FTXshStaDoc'];
        $tRSStaApv              = $aDataDocHD['FTXshStaApv'];
        $tRSStaPrcStk           = '';
        $tRSStaDelMQ            = '';
        $tRSStaPaid             = $aDataDocHD['FTXshStaPaid'];

        $tRSSesUsrBchCode       = $this->session->userdata("tSesUsrBchCode");
        $tRSDptCode             = $aDataDocHD['FTDptCode'];
        $tRSUsrCode             = $this->session->userdata('tSesUsername');
        $tRSLangEdit            = $this->session->userdata("tLangEdit");

        $tRSApvCode             = $aDataDocHD['FTXshApvCode'];
        $tRSUsrNameApv          = $aDataDocHD['FTXshApvName'];
        $tRSRefPoDoc            = "";
        $tRSRefIntDoc           = $aDataDocHD['FTXshRefInt'];
        $dRSRefIntDocDate       = $aDataDocHD['FDXshRefIntDate'];
        $tRSRefExtDoc           = $aDataDocHD['FTXshRefExt'];
        $dRSRefExtDocDate       = $aDataDocHD['FDXshRefExtDate'];
        $nRSStaRef              = $aDataDocHD['FNXshStaRef'];

        $tRSBchCode             = $aDataDocHD['FTBchCode'];
        $tRSBchName             = $aDataDocHD['FTBchName'];
        $tRSUserBchCode         = $tUserBchCode;
        $tRSUserBchName         = $tUserBchName;


        $tRSMerCode             = $aDataDocHD['FTMerCode'];
        $tRSMerName             = $aDataDocHD['FTMerName'];
        $tRSShopType            = $aDataDocHD['FTShpType'];
        $tRSShopCode            = $aDataDocHD['FTShpCode'];
        $tRSShopName            = $aDataDocHD['FTShpName'];
        $tRSPosCode             = $aDataDocHD['FTPosCode'];
        $tRSPosName             = $aDataDocHD['FTPosName'];
        $tRSWahCode             = $aDataDocHD['FTWahCode'];
        $tRSWahName             = $aDataDocHD['FTWahName'];
        $nRSStaDocAct           = $aDataDocHD['FNXshStaDocAct'];
        $tRSFrmDocPrint         = $aDataDocHD['FNXshDocPrint'];
        $tRSFrmRmk              = $aDataDocHD['FTXshRmk'];
        $tRSSplCode             = '';
        $tRSSplName             = '';

        $tRSCmpRteCode          = $aDataDocHD['FTRteCode'];
        $cRSRteFac              = $aDataDocHD['FCXshRteFac'];

        $tRSVatInOrEx           = $aDataDocHD['FTXshVATInOrEx'];
        $tRSSplPayMentType      = $aDataDocHD['FTXshCshOrCrd'];

        // ข้อมูลผู้จำหน่าย Supplier
        $tRSSplDstPaid          = $aDataDocHDSpl['FTXshDstPaid'];
        $tRSSplCrTerm           = $aDataDocHDSpl['FNXshCrTerm'];
        $dRSSplDueDate          = $aDataDocHDSpl['FDXshDueDate'];
        $dRSSplBillDue          = $aDataDocHDSpl['FDXshBillDue'];
        $tRSSplCtrName          = $aDataDocHDSpl['FTXshCtrName'];
        $dRSSplTnfDate          = $aDataDocHDSpl['FDXshTnfDate'];
        $tRSSplRefTnfID         = $aDataDocHDSpl['FTXshRefTnfID'];
        $tRSSplRefVehID         = $aDataDocHDSpl['FTXshRefVehID'];
        $tRSSplRefInvNo         = $aDataDocHDSpl['FTXshRefInvNo'];
        $tRSSplQtyAndTypeUnit   = $aDataDocHDSpl['FTXshQtyAndTypeUnit'];

        $tRSCstCode             = $aDataDocHD['FTCstCode'];
        $tRSCstCardID           = $aDataDocHD['FTXshCardID'];
        $tRSCstName             = $aDataDocHD['FTXshCstName'];
        $tRSCstTel              = $aDataDocHD['FTXshCstTel'];
        $tRSCstPplCode          = $aDataDocHD['FTPplCodeRet'];
        $tRSSpnName               = $aDataDocHD['rtSpnName'];
        // ที่อยู่สำหรับการจัดส่ง
        $tRSSplShipAdd          = $aDataDocHDSpl['FNXshShipAdd'];
        $tRSShipAddAddV1No      = (isset($aDataDocHDSpl['FTXshShipAddNo']) && !empty($aDataDocHDSpl['FTXshShipAddNo']))? $aDataDocHDSpl['FTXshShipAddNo'] : "-";
        $tRSShipAddV1Soi        = (isset($aDataDocHDSpl['FTXshShipAddRSi']) && !empty($aDataDocHDSpl['FTXshShipAddRSi']))? $aDataDocHDSpl['FTXshShipAddRSi'] : "-";
        $tRSShipAddV1Village    = (isset($aDataDocHDSpl['FTXshShipAddVillage']) && !empty($aDataDocHDSpl['FTXshShipAddVillage']))? $aDataDocHDSpl['FTXshShipAddVillage'] : "-";
        $tRSShipAddV1Road       = (isset($aDataDocHDSpl['FTXshShipAddRoad']) && !empty($aDataDocHDSpl['FTXshShipAddRoad']))? $aDataDocHDSpl['FTXshShipAddRoad'] : "-";
        $tRSShipAddV1SubDist    = (isset($aDataDocHDSpl['FTXshShipSubDistrict']) && !empty($aDataDocHDSpl['FTXshShipSubDistrict']))? $aDataDocHDSpl['FTXshShipSubDistrict'] : "-";
        $tRSShipAddV1DstCode    = (isset($aDataDocHDSpl['FTXshShipDistrict']) && !empty($aDataDocHDSpl['FTXshShipDistrict']))? $aDataDocHDSpl['FTXshShipDistrict'] : "-";
        $tRSShipAddV1PvnCode    = (isset($aDataDocHDSpl['FTXshShipProvince']) && !empty($aDataDocHDSpl['FTXshShipProvince']))? $aDataDocHDSpl['FTXshShipProvince'] : "-";
        $tRSShipAddV1PostCode   = (isset($aDataDocHDSpl['FTXshShipPosCode']) && !empty($aDataDocHDSpl['FTXshShipPosCode']))? $aDataDocHDSpl['FTXshShipPosCode'] : "-";

        // ที่อยู่สำหรับการออกใบกำกับภาษี
        $tRSSplTaxAdd           = $aDataDocHDSpl['FNXshTaxAdd'];
        $tRSTexAddAddV1No       = (isset($aDataDocHDSpl['FTXshTaxAddNo']) && !empty($aDataDocHDSpl['FTXshTaxAddNo']))? $aDataDocHDSpl['FTXshTaxAddNo'] : "-";
        $tRSTexAddV1Soi         = (isset($aDataDocHDSpl['FTXshTaxAddRSi']) && !empty($aDataDocHDSpl['FTXshTaxAddRSi']))? $aDataDocHDSpl['FTXshTaxAddRSi'] : "-";
        $tRSTexAddV1Village     = (isset($aDataDocHDSpl['FTXshTaxAddVillage']) && !empty($aDataDocHDSpl['FTXshTaxAddVillage']))? $aDataDocHDSpl['FTXshTaxAddVillage'] : "-";
        $tRSTexAddV1Road        = (isset($aDataDocHDSpl['FTXshTaxAddRoad']) && !empty($aDataDocHDSpl['FTXshTaxAddRoad']))? $aDataDocHDSpl['FTXshTaxAddRoad'] : "-";
        $tRSTexAddV1SubDist     = (isset($aDataDocHDSpl['FTXshTaxSubDistrict']) && !empty($aDataDocHDSpl['FTXshTaxSubDistrict']))? $aDataDocHDSpl['FTXshTaxSubDistrict'] : "-";
        $tRSTexAddV1DstCode     = (isset($aDataDocHDSpl['FTXshTaxDistrict']) && !empty($aDataDocHDSpl['FTXshTaxDistrict']))? $aDataDocHDSpl['FTXshTaxDistrict'] : "-";
        $tRSTexAddV1PvnCode     = (isset($aDataDocHDSpl['FTXshTaxProvince']) && !empty($aDataDocHDSpl['FTXshTaxProvince']))? $aDataDocHDSpl['FTXshTaxProvince'] : "-";
        $tRSTexAddV1PostCode    = (isset($aDataDocHDSpl['FTXshTaxPosCode']) && !empty($aDataDocHDSpl['FTXshTaxPosCode']))? $aDataDocHDSpl['FTXshTaxPosCode'] : "-";

        $tRSRsnCode             = $aDataDocHD['FTRsnCode'];
        $tRSRsnName             = $aDataDocHD['FTRsnName'];
        $tRSRcvCode             = $aDataDocHD['FTRcvCode'];
        $tRSRcvName             = $aDataDocHD['FTRcvName'];
    }else{
        $tRSRoute               = "dcmRSEventAdd";
        $nRSAutStaEdit          = 0;
        $tRSDocNo               = "";
        $dRSDocDate             = "";
        $dRSDocTime             = "";
        $tRSCreateBy            = $this->session->userdata('tSesUsrUsername');
        $tRSUsrNameCreateBy     = $this->session->userdata('tSesUsrUsername');
        $nRSStaRef              = 0;
        $tRSStaRefund           = 1;
        $tRSStaDoc              = 1;
        $tRSStaApv              = NULL;
        $tRSStaPrcStk           = NULL;
        $tRSStaDelMQ            = NULL;
        $tRSStaPaid             = 1;

        $tRSSesUsrBchCode       = $this->session->userdata("tSesUsrBchCode");
        $tRSDptCode             = $tDptCode;
        $tRSUsrCode             = $this->session->userdata('tSesUsername');
        $tRSLangEdit            = $this->session->userdata("tLangEdit");

        $tRSApvCode             = "";
        $tRSUsrNameApv          = "";
        $tRSRefPoDoc            = "";
        $tRSRefIntDoc           = "";
        $dRSRefIntDocDate       = "";
        $tRSRefExtDoc           = "";
        $dRSRefExtDocDate       = "";
        $tRSSpnName             = "";


        $tRSBchCode             = $tBchCode;
        $tRSBchName             = $tBchName;
        $tRSUserBchCode         = $tBchCode;
        $tRSUserBchName         = $tBchName;

        $tRSMerCode             = $tMerCode;
        $tRSMerName             = $tMerName;
        $tRSShopType            = $tShopType;
        $tRSShopCode            = $tShopCode;
        $tRSShopName            = $tShopName;
        $tRSPosCode             = "";
        $tRSPosName             = "";
        $tRSWahCode             = "";
        $tRSWahName             = "";
        $nRSStaDocAct           = "";
        $tRSFrmDocPrint         = 0;
        $tRSFrmRmk              = "";
        $tRSSplCode             = "";
        $tRSSplName             = "";

        $tRSCmpRteCode          = $tCmpRteCode;
        $cRSRteFac              = $cXthRteFac;

        $tRSVatInOrEx           = $tCmpRetInOrEx;
        $tRSSplPayMentType      = "";

        // ข้อมูลผู้จำหน่าย Supplier
        $tRSSplDstPaid          = "";
        $tRSSplCrTerm           = "";
        $dRSSplDueDate          = "";
        $dRSSplBillDue          = "";
        $tRSSplCtrName          = "";
        $dRSSplTnfDate          = "";
        $tRSSplRefTnfID         = "";
        $tRSSplRefVehID         = "";
        $tRSSplRefInvNo         = "";
        $tRSSplQtyAndTypeUnit   = "";


        $tRSCstCode             = '';
        $tRSCstCardID           = '';
        $tRSCstName             = '';
        $tRSCstTel              = '';
        $tRSCstPplCode          = '';
        // ที่อยู่สำหรับการจัดส่ง
        $tRSSplShipAdd          = "";
        $tRSShipAddAddV1No      = "-";
        $tRSShipAddV1Soi        = "-";
        $tRSShipAddV1Village    = "-";
        $tRSShipAddV1Road       = "-";
        $tRSShipAddV1SubDist    = "-";
        $tRSShipAddV1DstCode    = "-";
        $tRSShipAddV1PvnCode    = "-";
        $tRSShipAddV1PostCode   = "-";

        // ที่อยู่สำหรับการออกใบกำกับภาษี
        $tRSSplTaxAdd           = "";
        $tRSTexAddAddV1No       = "-";
        $tRSTexAddV1Soi         = "-";
        $tRSTexAddV1Village     = "-";
        $tRSTexAddV1Road        = "-";
        $tRSTexAddV1SubDist     = "-";
        $tRSTexAddV1DstCode     = "-";
        $tRSTexAddV1PvnCode     = "-";
        $tRSTexAddV1PostCode    = "-";
        $tRSRsnCode             = "";
        $tRSRsnName             = "";
        $tRSRcvCode             = "";
        $tRSRcvName             = "";
    }
    if(empty($tRSBchCode) && empty($tRSShopCode)){
        $tASTUserType   = "HQ";
    }else{
        if(!empty($tRSBchCode) && empty($tRSShopCode)){
            $tASTUserType   = "BCH";
        }else if( !empty($tRSBchCode) && !empty($tRSShopCode)){
            $tASTUserType   = "SHP";
        }else{
            $tASTUserType   = "";
        }
    }

    $nOptionDecimalSave = FCNxHGetOptionDecimalSave();
?>
<style>
.tableFixHead          { overflow-y: auto; height: 200px; }
.tableFixHead thead th { position: sticky; top: 0; z-index:1; }

/* Just common table stuff. Really. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#ffff; }

#otbBrowserBillHDList>tbody>tr:hover {
    cursor: pointer;
    background-color: #c6e6ff;
    color: #000000 !important;

}


#otbBrowserBillHDList>tbody>tr.active:hover>td, #otbBrowserBillHDList>tbody>tr.active:hover>th, #otbBrowserBillHDList>tbody>tr:hover>.active, #otbBrowserBillHDList>tbody>tr>td.active:hover, #otbBrowserBillHDList>tbody>tr>th.active:hover {
    background-color: #179bfd;
    color: #FFFFFF !important;
}

#otbBrowserBillHDList>thead>tr>td.active, #otbBrowserBillHDList>tbody>tr>td.active, #otbBrowserBillHDList>tfoot>tr>td.active, #otbBrowserBillHDList>thead>tr>th.active, #otbBrowserBillHDList>tbody>tr>th.active, #otbBrowserBillHDList>tfoot>tr>th.active, #otbBrowserBillHDList>thead>tr.active>td, #otbBrowserBillHDList>tbody>tr.active>td, #otbBrowserBillHDList>tfoot>tr.active>td, #otbBrowserBillHDList>thead>tr.active>th, #otbBrowserBillHDList>tbody>tr.active>th, #otbBrowserBillHDList>tfoot>tr.active>th {
    background-color: #179bfd;
    color: #FFFFFF !important;
}

</style>
<form id="ofmRSFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdRSPage" name="ohdRSPage" value="1">
    <input type="hidden" id="ohdOptDecimalShow" id="ohdOptDecimalShow" value="<?=$nOptDecimalShow?>">
    <input type="hidden" id="ohdOptDecimalSave" id="ohdOptDecimalSave" value="<?=$nOptionDecimalSave?>">
    <input type="hidden" id="ohdRSRoute" name="ohdRSRoute" value="<?php echo $tRSRoute;?>">
    <input type="hidden" id="ohdRSCheckClearValidate" name="ohdRSCheckClearValidate" value="0">
    <input type="hidden" id="ohdRSCheckSubmitByButton" name="ohdRSCheckSubmitByButton" value="0">
    <input type="hidden" id="ohdRSAutStaEdit" name="ohdRSAutStaEdit" value="<?php echo $nRSAutStaEdit;?>">
    <input type="hidden" id="ohdRSPplCodeBch" name="ohdRSPplCodeBch" value="<?php echo $tRSPplCode ?>">
    <input type="hidden" id="ohdRSPplCodeCst" name="ohdRSPplCodeCst" value="<?=$tRSCstPplCode?>">
    <input type="hidden" id="ohdRSStaRefund" name="ohdRSStaRefund" value="<?php echo $tRSStaRefund;?>">
    <input type="hidden" id="ohdRSStaDoc" name="ohdRSStaDoc" value="<?php echo $tRSStaDoc;?>">
    <input type="hidden" id="ohdRSStaApv" name="ohdRSStaApv" value="<?php echo $tRSStaApv;?>">
    <input type="hidden" id="ohdRSStaDelMQ" name="ohdRSStaDelMQ" value="<?php echo $tRSStaDelMQ; ?>">
    <input type="hidden" id="ohdRSStaPrcStk" name="ohdRSStaPrcStk" value="<?php echo $tRSStaPrcStk;?>">
    <input type="hidden" id="ohdRSStaPaid" name="ohdRSStaPaid" value="<?php echo $tRSStaPaid;?>">

    <input type="hidden" id="ohdRSSesUsrBchCode" name="ohdRSSesUsrBchCode" value="<?php echo $tRSSesUsrBchCode; ?>">
    <input type="hidden" id="ohdRSBchCode" name="ohdRSBchCode" value="<?php echo $tRSBchCode; ?>">
    <input type="hidden" id="ohdRSDptCode" name="ohdRSDptCode" value="<?php echo $tRSDptCode;?>">
    <input type="hidden" id="ohdRSUsrCode" name="ohdRSUsrCode" value="<?php echo $tRSUsrCode?>">
    <input type="hidden" id="ohdParameterBillHD" name="ohdParameterBillHD" value="">
    <input type="hidden" id="ohdParameterBillDT" name="ohdParameterBillDT" value="">
    <input type="hidden" id="ohdRSPosCode" name="ohdRSPosCode" value="">
    <input type="hidden" id="ohdRSShfCode" name="ohdRSShfCode" value="">

    <input type="hidden" id="ohdRSCmpRteCode" name="ohdRSCmpRteCode" value="<?php echo $tRSCmpRteCode;?>">
    <input type="hidden" id="ohdRSRteFac" name="ohdRSRteFac" value="<?php echo $cRSRteFac;?>">

    <input type="hidden" id="ohdRSApvCodeUsrLogin" name="ohdRSApvCodeUsrLogin" value="<?php echo $tRSUsrCode; ?>">
    <input type="hidden" id="ohdRSLangEdit" name="ohdRSLangEdit" value="<?php echo $tRSLangEdit; ?>">
    <input type="hidden" id="ohdRSOptAlwSaveQty" name="ohdRSOptAlwSaveQty" value="<?php echo $nOptDocSave?>">
    <input type="hidden" id="ohdRSOptScanSku" name="ohdRSOptScanSku" value="<?php echo $nOptScanSku?>">
    <input type="hidden" id="ohdRSVatRate" name="ohdRSVatRate" value="<?=$cVatRate?>">
    <input type="hidden" id="ohdRSCmpRetInOrEx" name="ohdRSCmpRetInOrEx" value="<?=$tCmpRetInOrEx?>">
    <input type="hidden" id="ohdSesSessionID" name="ohdSesSessionID" value="<?=$this->session->userdata('tSesSessionID')?>"  >
    <input type="hidden" id="ohdSesUsrLevel" name="ohdSesUsrLevel" value="<?=$this->session->userdata('tSesUsrLevel')?>"  >
    <input type="hidden" id="ohdSesUsrBchCom" name="ohdSesUsrBchCom" value="<?=$this->session->userdata('tSesUsrBchCom')?>"  >
    <input type="hidden" id="ohdRSValidatePdt" name="ohdRSValidatePdt" value="<?=language('document/returnsale/returnsale', 'tRSPleaseSeletedPDTIntoTable')?>">

    <button style="display:none" type="submit" id="obtRSSubmitDocument" onclick="JSxRSAddEditDocument()"></button>
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvRSHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmStatus'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvRSDataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvRSDataStatusInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="text-success xCNTitleFrom"><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmAppove');?></label>
                                </div>
                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/returnsale/returnsale','tRSLabelAutoGenCode'); ?></label>
                                <?php if(isset($tRSDocNo) && empty($tRSDocNo)):?>
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbRSStaAutoGenCode" name="ocbRSStaAutoGenCode" maxlength="1" checked="checked">
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmAutoGenCode');?></span>
                                    </label>
                                </div>
                                <?php endif;?>
                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input
                                        type="text"
                                        class="form-control xCNInputWithoutSpcNotThai xCNGenarateCodeTextInputValidate"
                                        id="oetRSDocNo"
                                        name="oetRSDocNo"
                                        maxlength="20"
                                        value="<?php echo $tRSDocNo;?>"
                                        data-validate-required="<?php echo language('document/returnsale/returnsale','tRSPlsEnterOrRunDocNo'); ?>"
                                        data-validate-duplicate="<?php echo language('document/returnsale/returnsale','tRSPlsDocNoDuplicate'); ?>"
                                        placeholder="<?php echo language('document/returnsale/returnsale','tRSLabelFrmDocNo');?>"
                                        style="pointer-events:none"
                                        readonly
                                    >
                                    <input type="hidden" id="ohdRSCheckDuplicateCode" name="ohdRSCheckDuplicateCode" value="2">
                                </div>
                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetRSDocDate"
                                            name="oetRSDocDate"
                                            value="<?php echo $dRSDocDate; ?>"
                                            data-validate-required="<?php echo language('document/returnsale/returnsale','tRSPlsEnterDocDate'); ?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtRSDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmDocTime');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNTimePicker xCNInputMaskTime"
                                            id="oetRSDocTime"
                                            name="oetRSDocTime"
                                            value="<?php echo $dRSDocTime; ?>"
                                            data-validate-required="<?php echo language('document/returnsale/returnsale', 'tRSPlsEnterDocTime');?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtRSDocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmCreateBy');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdRSCreateBy" name="ohdRSCreateBy" value="<?php echo $tRSCreateBy?>">
                                            <label><?php echo $tRSUsrNameCreateBy?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- พนักงานขาย -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale', 'tRSSalePerson'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo $tRSSpnName ?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <?php
                                                if($tRSRoute == "dcmRSEventAdd"){
                                                    $tRSLabelStaDoc  = language('document/returnsale/returnsale', 'tRSLabelFrmValStaDoc');
                                                }else{
                                                    $tRSLabelStaDoc  = language('document/returnsale/returnsale', 'tRSLabelFrmValStaDoc'.$tRSStaDoc);
                                                }
                                            ?>
                                            <label><?php echo $tRSLabelStaDoc;?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmValStaApv'.$tRSStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะประมวลผลเอกสาร -->
                                <!-- <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmStaPrcStk'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmValStaPrcStk'.$tRSStaPrcStk); ?></label>
                                        </div>
                                    </div>
                                </div> -->
                             <!-- สถานะอ้างอิงเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmStaRef'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">

                                            <label><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmStaRef'.$nRSStaRef); ?></label>

                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($tRSDocNo) && !empty($tRSDocNo)):?>
                                    <!-- ผู้อนุมัติเอกสาร -->
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdRSApvCode" name="ohdRSApvCode" maxlength="20" value="<?php echo $tRSApvCode?>">
                                                <label>
                                                    <?php echo (isset($tRSUsrNameApv) && !empty($tRSUsrNameApv))? $tRSUsrNameApv : "-" ?>
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



               <!-- Panel เงื่อนไขเอกสาร -->
               <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvRSConditionDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmConditionDoc'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvRSDataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvRSDataConditionDoc" class="xCNMenuPanelData panel-collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- Condition สาขา -->
                                <div class="form-group m-b-0">
                                    <?php
                                        $tRSDataInputBchCode   = "";
                                        $tRSDataInputBchName   = "";
                                        if($tRSRoute  == "dcmRSEventAdd"){
                                            $tRSDataInputBchCode    = $this->session->userdata('tSesUsrBchCodeDefault');
                                            $tRSDataInputBchName    = $this->session->userdata('tSesUsrBchNameDefault');
                                        }else{
                                            $tRSDataInputBchCode    = $tRSBchCode;
                                            $tRSDataInputBchName    = $tRSBchName;
                                        }
                                    ?>
                                <!--สาขา-->
                                <script>
                                    var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                                    if( tUsrLevel != "HQ" ){
                                        //BCH - SHP
                                        var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
                                        if(tBchCount < 2){
                                            $('#obtRSBrowseBCH').attr('disabled',true);
                                        }
                                    }
                                </script>
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmBranch')?></label>
												<div class="input-group">
													<input
														type="text"
														class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
														id="oetRSFrmBchCode"
														name="oetRSFrmBchCode"
														maxlength="5"
														value="<?php echo @$tRSDataInputBchCode?>"
													>
													<input
														type="text"
														class="form-control xWPointerEventNone"
														id="oetRSFrmBchName"
														name="oetRSFrmBchName"
														maxlength="100"
														placeholder="<?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmBranch')?>"
														value="<?php echo @$tRSDataInputBchName?>"
														readonly
													>
													<span class="input-group-btn xWConditionSearchPdt">
														<button id="obtBrowseTWOBCH" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt ">
															<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
														</button>
													</span>
												</div>
											</div>

                                </div>
                                <!-- Condition กลุ่มธุรกิจ -->
                                <div class="form-group" >
                                    <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmMerchant');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetRSFrmMerCode" name="oetRSFrmMerCode" maxlength="5" value="<?php echo $tRSMerCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetRSFrmMerName" name="oetRSFrmMerName" lavudate-label="<?php echo language('document/returnsale/returnsale', 'tRSFrmMerCode');?>" value="<?php echo $tRSMerName;?>" readonly>
                                        <?php
                                            $tDisabledBtnMerchant = "";
                                            if($tRSRoute == "dcmRSEventAdd"){
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
                                            <button id="obtRSBrowseMerchant" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnMerchant;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition ร้านค้า -->
                                <div class="form-group" >
                                    <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmShop');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetRSFrmShpCode" name="oetRSFrmShpCode" maxlength="5" value="<?php echo $tRSShopCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetRSFrmShpName" name="oetRSFrmShpName"  data-validate-required="<?php echo language('document/returnsale/returnsale', 'tRSFrmShpCode');?>" value="<?php echo $tRSShopName;?>" readonly>
                                        <?php
                                            $tDisabledBtnShop = "";
                                            if($tRSRoute == "dcmRSEventAdd"){
                                                // $tDisabledBtnShop   = "disabled";
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnShop   = "disabled";
                                                }else{
                                                    if(empty($tRSShopCode) && empty($tRSShopName)){
                                                        $tDisabledBtnShop   = "disabled";
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnShop;?>">
                                            <button id="obtRSBrowseShop" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnShop;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition เครื่องจุดขาย -->
                              <div class="form-group" >
                                    <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmPos');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetRSFrmPosCode" name="oetRSFrmPosCode" maxlength="5" value="<?php echo $tRSPosCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetRSFrmPosName" name="oetRSFrmPosName"  data-validate-required="<?php echo language('document/returnsale/returnsale', 'tRSFrmPosCode');?>" value="<?php echo $tRSPosName;?>" readonly>
                                        <?php
                                            $tDisabledBtnPos    = "";
                                            if($tRSRoute == "dcmRSEventAdd"){
                                                $tDisabledBtnPos    = "disabled";
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnPos    = "disabled";
                                                }else{
                                                    if(empty($tRSPosCode)){
                                                        $tDisabledBtnPos    = "disabled";
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnPos;?>">
                                            <button id="obtRSBrowsePos" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnPos;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition ลูกค้า -->
                                <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSCstCode');?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetRSFrmCstCode" name="oetRSFrmCstCode" value="<?php echo $tRSCstCode;?>">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="oetRSFrmCstName"
                                                    name="oetRSFrmCstName"
                                                    value="<?php echo $tRSCstName;?>"
                                                    placeholder="<?php echo language('document/returnsale/returnsale','tRSCstCode') ?>"
                                                    readonly
                                                >
                                                <span class="input-group-btn">
                                                    <button id="obtRSBrowseCustomer" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>



                            <!-- Condition ประเภทภาษี -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmSplInfoVatInOrEx');?></label>
                                            <div class="">
                                                    <select class="form-control xWConditionSearchPdt" name="ocmRSFrmSplInfoVatInOrEx" id="ocmRSFrmSplInfoVatInOrEx" >
                                                        <option value="1" <?php if($tRSVatInOrEx=='1'){ echo 'selected'; } ?>><?php echo language('document/returnsale/returnsale','tRSLabelFrmSplInfoVatInclusive');?></option>
                                                        <option value="2" <?php if($tRSVatInOrEx=='2'){ echo 'selected'; } ?>><?php echo language('document/returnsale/returnsale','tRSLabelFrmSplInfoVatExclusive');?></option>
                                                    </select>
                                            </div>
                                </div>

                                <!-- Condition ประเภทกาชำระเงิน -->
                                <div class="form-group">
                                <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('document/returnsale/returnsale','tRSLabelFrmSplInfoPaymentType');?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetRSRcvCode" name="oetRSRcvCode" value="<?=$tRSRcvCode?>">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="oetRSRcvName"
                                                    name="oetRSRcvName"
                                                    value="<?=$tRSRcvName?>"
                                                    placeholder="<?php echo language('document/returnsale/returnsale','tRSLabelFrmSplInfoPaymentType') ?>"
                                                    data-validate-required="กรุณาระบุประเภทการชำระเงิน"
                                                    readonly
                                                >
                                                <span class="input-group-btn">
                                                    <button id="obtRSBrowseRecive" type="button" class="xWConditionSearchPdt  btn xCNBtnBrowseAddOn" >
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                 </div>


                                                                 <!-- Condition คลังสินค้า -->
                                <div class="form-group" >
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('document/returnsale/returnsale','tRSLabelFrmWah');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetRSFrmWahCode" name="oetRSFrmWahCode" maxlength="5" value="<?php echo $tRSWahCode;?>">
                                        <input
                                            type="text"
                                            class="form-control xWPointerEventNone"
                                            id="oetRSFrmWahName"
                                            name="oetRSFrmWahName"
                                            value="<?php echo $tRSWahName;?>"
                                            data-validate-required="<?php echo language('document/returnsale/returnsale','tRSPlsEnterWah'); ?>"
                                            readonly
                                        >
                                        <?php
                                            $tDisabledBtnWah    = "";
                                            if($tRSRoute == "dcmRSEventAdd"){
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnWah    = "disabled";
                                                }
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnWah    = "disabled";
                                                }else{
                                                    if(!empty($tRSMerCode) && !empty($tRSShopCode) && !empty($tRSWahCode)){
                                                        $tDisabledBtnWah    = "";
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnWah;?>">
                                            <button id="obtRSBrowseWahouse" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnWah;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/returnsale/returnsale','tRSARPReson'); ?></label>
                                    <div class="input-group">
                                        <input class="form-control xCNHide" id="oetRSRsnCode" name="oetRSRsnCode" maxlength="5" value="<?=$tRSRsnCode?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetRSRsnName" name="oetRSRsnName" value="<?=$tRSRsnName?>" placeholder="<?php echo language('document/returnsale/returnsale','tRSARPReson'); ?>" readonly="" data-validate-required="กรุณาระบุเหตุผล">
                                        <span class="xWConditionSearchPdt input-group-btn">
                                            <button id="obtRSBrowseRsn" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
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
                <div id="odvRSInfoOther" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/returnsale/returnsale','tRSLabelFrmInfoOth');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvRSDataInfoOther" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvRSDataInfoOther" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                                <!-- สถานะความเคลื่อนไหว -->
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" value="1" id="ocbRSFrmInfoOthStaDocAct" name="ocbRSFrmInfoOthStaDocAct" maxlength="1" <?php echo ($nRSStaDocAct == '1' || empty($nRSStaDocAct)) ? 'checked' : ''; ?>>
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmInfoOthStaDocAct'); ?></span>
                                    </label>
                                </div>
                                <!-- สถานะอ้างอิง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmInfoOthRef');?></label>
                                    <select class="selectpicker form-control xWConditionSearchPdt" id="ocmRSFrmInfoOthRef" name="ocmRSFrmInfoOthRef" maxlength="1">
                                        <option value="0" <?php if($nRSStaRef==0){ echo 'selected'; } ?>><?php echo language('document/returnsale/returnsale','tRSLabelFrmInfoOthRef0');?></option>
                                        <option value="1" <?php if($nRSStaRef==1){ echo 'selected'; } ?>><?php echo language('document/returnsale/returnsale','tRSLabelFrmInfoOthRef1');?></option>
                                        <option value="2" <?php if($nRSStaRef==2){ echo 'selected'; } ?>><?php echo language('document/returnsale/returnsale','tRSLabelFrmInfoOthRef2');?></option>
                                    </select>
                                </div>
                                <!-- จำนวนครั้งที่พิมพ์ -->
                                <!-- <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmInfoOthDocPrint');?></label>
                                    <input
                                        type="text"
                                        class="form-control text-right"
                                        id="ocmRSFrmInfoOthDocPrint"
                                        name="ocmRSFrmInfoOthDocPrint"
                                        value="<?php echo $tRSFrmDocPrint;?>"
                                        readonly
                                    >
                                </div> -->
                                <!-- กรณีเพิ่มสินค้ารายการเดิม -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmInfoOthReAddPdt');?></label>
                                    <select class="form-control selectpicker xWConditionSearchPdt" id="ocmRSFrmInfoOthReAddPdt" name="ocmRSFrmInfoOthReAddPdt">
                                        <option value="1"><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmInfoOthReAddPdt1');?></option>
                                        <option value="2" selected><?php echo language('document/returnsale/returnsale', 'tRSLabelFrmInfoOthReAddPdt2');?></option>
                                    </select>
                                </div>
                                <!-- หมายเหตุ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSLabelFrmInfoOthRemark');?></label>
                                    <textarea
                                        class="form-control xWConditionSearchPdt"
                                        id="otaRSFrmInfoOthRmk"
                                        name="otaRSFrmInfoOthRmk"
                                        rows="10"
                                        maxlength="200"
                                        style="resize: none;height:86px;"
                                    ><?php echo $tRSFrmRmk?></textarea>
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
                <div id="odvRSDataPanelDetailPDT" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:500px;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">

                            <div class="row p-t-10">

                                 <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                       <!-- วันที่อ้างอิงเอกสาร -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSRefDocDate');?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control xCNDatePicker xCNInputMaskDate"
                                                    id="oetRSRefDocDate"
                                                    name="oetRSRefDocDate"
                                                    value="<?php echo $dRSRefIntDocDate; ?>"
                                                    data-validate-required="<?php echo language('document/returnsale/returnsale','tRSRefDocDate'); ?>"
                                                >
                                                <span class="input-group-btn">
                                                    <button id="obtRSRefDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                                </span>
                                            </div>
                                        </div>
                                 </div>


                                 <div class="col-lg-8 col-md-8 col-sm-8 xCNSelectTaxABB">
                                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/returnsale/returnsale', 'tRSRefDocNo'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetRSRefDocNo" maxlength="20" id="oetRSRefDocNo" value="<?=$tRSRefIntDoc?>" class="form-control xCNClearValue xWConditionSearchPdt" type="text" placeholder="<?= language('document/returnsale/returnsale', 'tRSRefDocNo') ?>" onkeypress="Javascript:if(event.keyCode==13) JSxRSFindBillSaleVDDocNo(this.value);">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled disabled" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/scanner2.png' ?>">
                                                        </button>
                                                    </span>
                                                    <!-- <input name="oetRSRefDocNo" id="oetRSRefDocNo" type="hidden"> -->
                                                </div>
                                            </div>

                                <div class="col-lg-1 col-md-1 col-sm-1">
                                                <span>
                                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled xWConditionSearchPdt" id="oetRSBrowsRefDocNo" type="button" style="float: right; margin-top: 25px;">
                                                        <img src="<?=base_url()?>/application/modules/common/assets/images/icons/find-24.png">
                                                    </button>
                                                </span>
                                            </div>

                            </div>


                                <div class="row p-t-10">

                                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="100"
                                                    id="oetRSFrmFilterPdtHTML"
                                                    name="oetRSFrmFilterPdtHTML"
                                                    placeholder="<?php echo language('document/returnsale/returnsale','tRSFrmFilterTablePdt');?>"
                                                    onkeyup="javascript:if(event.keyCode==13) JSvRSDOCFilterPdtInTableTemp()"
                                                >

                                            <input type="text" style="display:none;" class="form-control oetRSFrmSearchPdtHTML" id="oetRSInsertBarcode" autocomplete="off" name="oetRSInsertBarcode" maxlength="50" value="" onkeypress="Javascript:if(event.keyCode==13) JSxSearchFromBarcode(event,this);"  placeholder="เพิ่มสินค้าด้วยบาร์โค้ด หรือ รหัสสินค้า" >

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="100"
                                                    id="oetRSFrmSearchAndAddPdtHTML"
                                                    name="oetRSFrmSearchAndAddPdtHTML"
                                                    onkeyup="Javascript:if(event.keyCode==13) JSxRSChkConditionSearchAndAddPdt()"
                                                    placeholder="<?php echo language('document/returnsale/returnsale','tRSFrmSearchAndAddPdt');?>"
                                                    style="display:none;"
                                                    data-validate="<?php echo language('document/returnsale/returnsale','tRSMsgValidScanNotFoundBarCode');?>"
                                                >
                                                <span class="input-group-btn">
                                                    <div id="odvRSSearchAndScanBtnGrp" class="xCNDropDrownGroup input-group-append">
                                                            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                                            <i class="fa fa-filter" id="oeiRsIconFilter" style="width:20px;"></i>
                                                            <img style="display:none;width:20px;" id="oeiRsIconScan" src="<?=base_url()?>/application/modules/common/assets/images/icons/scanner2.png">
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li id="" class="">
                                                                <a class="xRsSelectTypeOption" data-toggle="" data-target="1" id="oatRsIconFilter" ><?php echo language('document/returnsale/returnsale','tRSFillterPdtData')?></a>
                                                                <a class="xRsSelectTypeOption" data-toggle="" data-target="2" id="oatRsIconScan" ><?php echo language('document/returnsale/returnsale','tRSScanCarCodePdt')?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>


                                            </div>
                                        </div>



                                    </div>



                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <!--ค้นหาจากบาร์โค๊ด-->
                                        <!-- <div class="form-group" style="width: 85%;">
                                            <input type="text" class="form-control" id="oetRSInsertBarcode" autocomplete="off" name="oetRSInsertBarcode" maxlength="50" value="" onkeypress="Javascript:if(event.keyCode==13) JSxSearchFromBarcode(event,this);"  placeholder="เพิ่มสินค้าด้วยบาร์โค้ด หรือ รหัสสินค้า" >
                                        </div> -->
                                        <div class="form-group">
                                        <div id="odvRSMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
                                                <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                                    <?php echo language('common/main/main','tCMNOption')?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li id="oliRSBtnDeleteMulti" class="disabled">
                                                        <a data-toggle="modal" data-target="#odvRSModalDelPdtInDTTempMultiple"><?php echo language('common/main/main','tDelAll')?></a>
                                                    </li>
                                                </ul>
                                                </div>
                                                </div>
                                        <!--เพิ่มสินค้าแบบปกติ-->
                                        <div class="form-group">
                                            <div style="position: absolute;right: 15px;top:-5px;">
                                                <button type="button" id="obtRSDocBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt">+</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row p-t-10" id="odvRSDataPdtTableDTTemp">

                                </div>
                          <!--ส่วนสรุปท้ายบิล-->
<div class="row" id="odvRowDataEndOfBill">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading mark-font" id="odvDataTextBath"></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left mark-font"><?=language('document/returnsale/returnsale','tRSTBVatRate');?></div>
                <div class="pull-right mark-font"><?=language('document/returnsale/returnsale','tRSTBAmountVat');?></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <ul class="list-group" id="oulDataListVat">
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?=language('document/returnsale/returnsale','tRSTBTotalValVat');?></label>
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
                        <label class="pull-left mark-font"><?=language('document/returnsale/returnsale','tRSTBSumFCXtdNet');?></label>
                        <input type="text" id="olbSumFCXtdNetAlwDis" style="display:none;"></label>
                        <label class="pull-right mark-font" id="olbSumFCXtdNet">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/returnsale/returnsale','tRSTBDisChg');?>
                            <button type="button" class="xCNBTNPrimeryDisChgPlus" onclick="JCNvRSMngDocDisChagHD(this)" style="float: right; margin-top: 3px; margin-left: 5px;">+</button>
                        </label>
                        <label class="pull-left" style="margin-left: 5px;" id="olbDisChgHD"></label>
                        <label class="pull-right" id="olbSumFCXtdAmt">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/returnsale/returnsale','tRSTBSumFCXtdNetAfHD');?></label>
                        <label class="pull-right" id="olbSumFCXtdNetAfHD">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/returnsale/returnsale','tRSTBSumFCXtdVat');?></label>
                        <label class="pull-right" id="olbSumFCXtdVat">0.00</label>
                        <input type="hidden" name="ohdSumFCXtdVat" id="ohdSumFCXtdVat" value="0.00">
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?=language('document/returnsale/returnsale','tRSTBFCXphGrand');?></label>
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


<!-- ================================================================== View Modal TexAddress Purchase Invoice  ================================================================== -->
    <div id="odvRSBrowseBillSaleVD" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 1050px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/returnsale/returnsale','tRSRefDocTitle'); ?></label>
                        </div>

                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                        <div class="input-group" style="padding-bottom: 20px;">
                            <input class="form-control xCNInpuTXOthoutSingleQuote" type="text" id="oetRSSearchDocument" name="oetRSSearchDocument" placeholder="กรอกคำค้นหา" autocomplete="off">
                            <span class="input-group-btn">
                                <button id="obtRSSerchDocument" type="button" class="btn xCNBtnDateTime"><img class="xCNIconSearch"></button>
                            </span>
                        </div>

                    </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 20px;">
                             <div class="tableFixHead table-responsive">
                                    <table id="otbBrowserBillHDList" class="table table-striped">
                                        <thead>
                                        <tr  class="xCNCenter">
                                        <th width="20%"><?php echo language('document/returnsale/returnsale','tRSTBBch');?></th>
                                        <th width="20%"><?php echo language('document/returnsale/returnsale','tRSLabelFrmPos');?></th>
                                        <th width="20%"><?php echo language('document/returnsale/returnsale','tRSRefDocNoColum');?></th>
                                        <th width="20%"><?php echo language('document/returnsale/returnsale','tRSRefDocDateColum');?></th>
                                        <th width="20%"><?php echo language('document/returnsale/returnsale','tRSCstCode');?></th>
                                        </tr>
                                        </thead>
                                        <tbody id="othDataTableSalHD">
                                        <tr>
                                        <td colspan="5" align="center"><?php echo language('document/returnsale/returnsale','tRSRefDocBillEmpty');?></td>

                                        </tr>

                                        </tbody>
                                    </table>
                                    </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 20px;">
                                    <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSRefDocVdDT');?></label>
                             <div class="tableFixHead table-responsive" >
                                    <table  class="table table-striped">
                                        <thead>
                                        <tr  class="xCNCenter">
                                        <th><?php echo language('document/returnsale/returnsale','tRSTable_choose');?></th>
                                        <th><?php echo language('document/returnsale/returnsale','tRSTable_pdtcode');?></th>
                                        <th><?php echo language('document/returnsale/returnsale','tRSTable_pdtname');?></th>
                                        <th><?php echo language('document/returnsale/returnsale','tRSTable_unit');?></th>
                                        <th><?php echo language('document/returnsale/returnsale','tRSTable_qty');?></th>
                                        <th><?php echo language('document/returnsale/returnsale','tRSTable_price');?></th>
                                        <th><?php echo language('document/returnsale/returnsale','tRSTable_discount');?></th>
                                        <th><?php echo language('document/returnsale/returnsale','tRSTable_grand');?></th>
                                        </tr>
                                        </thead>
                                        <tbody id="othDataTableSalVD">
                                        <tr>
                                        <td colspan="8" align="center"><?php echo language('document/returnsale/returnsale','tRSRefDocBillEmpty');?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                          <label class="fancy-checkbox ">
                                            <input type="checkbox" class="" name="ocbRSSelectPdtAll" id="ocbRSSelectPdtAll"  checked >
                                            <span class="">&nbsp;<?php echo language('document/returnsale/returnsale','tRSRefDocVdSelctAll');?></span>
                                        </label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnRSTexAddData()"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- ======================================================================== View Modal Appove Document  ======================================================================== -->
    <div id="odvRSModalAppoveDoc" class="modal fade">
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
                    <button onclick="JSxRSApproveDocument(true)" type="button" class="btn xCNBTNPrimery">
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
                    <button onclick="JSnRSCancelDocument(true)" type="button" class="btn xCNBTNPrimery">
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
    <div class="modal fade" id="odvRSOrderAdvTblColumns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <div class="modal-body" id="odvRSModalBodyAdvTable">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
                    <button id="obtRSSaveAdvTableColums" type="button" class="btn btn-primary"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- ============================================================== View Modal Delete Product In DT DocTemp Multiple  ============================================================ -->
    <div id="odvRSModalDelPdtInDTTempMultiple" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main','tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                    <input type="hidden" id="ohdConfirmRSDocNoDelete"   name="ohdConfirmRSDocNoDelete">
                    <input type="hidden" id="ohdConfirmRSSeqNoDelete"   name="ohdConfirmRSSeqNoDelete">
                    <input type="hidden" id="ohdConfirmRSPdtCodeDelete" name="ohdConfirmRSPdtCodeDelete">
                    <input type="hidden" id="ohdConfirmRSPunCodeDelete" name="ohdConfirmRSPunCodeDelete">

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
<div id="odvRSModalPleseselectCustomer" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tMessageAlert')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>กรุณาเลือกลูกค้า ก่อนเพิ่มสินค้า</p>
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
<div id="odvRSModalPDTNotFound" class="modal fade">
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

<!-- ======================================================================== Modal ไม่พบเลขที่เอกสาร ======================================================================== -->
<div id="odvRSModalBillNotFound" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tMessageAlert')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>ไม่พบข้อมูลเลขที่เอกสาร กรุณาลองใหม่อีกครั้ง</p>
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
<div id="odvRSModalPDTMoreOne" class="modal fade">
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
<div id="odvRSModalChangeBCH" class="modal fade">
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




<script src="<?php echo base_url('application/modules/common/assets/src/jThaiBath.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jReturnSaleAdd.php');?>
<?php include('dis_chg/wReturnSaleDisChgModal.php'); ?>


<script>

    //บังคับให้เลือกลูกค้า
    function JSxFocusInputCustomer(){
        $('#oetRSFrmCstName').focus();
    }

    function JSxNotFoundClose(){
        $('#oetRSInsertBarcode').focus();
    }

    //กดเลือกบาร์โค๊ด
    function JSxSearchFromBarcode(e,elem){
        var tValue = $(elem).val();
        if($('#oetRSFrmCstHNNumber').val() != ""){
            JSxCheckPinMenuClose();
            if(tValue.length === 0){

            }else{
                // JCNxOpenLoading();
                $('#oetRSInsertBarcode').attr('readonly',true);
                JCNSearchBarcodePdt(tValue);
                $('#oetRSInsertBarcode').val('');
            }
        }else{
            $('#odvRSModalPleseselectCustomer').modal('show');
            $('#oetRSInsertBarcode').val('');
        }
        e.preventDefault();
    }

    //ค้นหาบาร์โค๊ด
    function JCNSearchBarcodePdt(ptTextScan){
        var tRSSplCode = $('#oetRSFrmSplCode').val();
        if($('#ohdRSPplCodeCst').val()!=''){
            var tRSPplCode =$('#ohdRSPplCodeCst').val();
        }else{
            var tRSPplCode =$('#ohdRSPplCodeBch').val();
        }

        var aMulti = [];
        $.ajax({
            type: "POST",
            url : "BrowseDataPDTTableCallView",
            data: {
                aPriceType      : ['Price4Cst',tRSPplCode],
                NextFunc        : "",
                SPL             : $("#oetRSFrmSplCode").val(),
                BCH             : $("#oetRSFrmBchCode").val(),
                tInpSesSessionID : $('#ohdSesSessionID').val(),
                tInpUsrCode      : $('#ohdRSUsrCode').val(),
                tInpLangEdit     : $('#ohdRSLangEdit').val(),
                tInpSesUsrLevel  : $('#ohdSesUsrLevel').val(),
                tInpSesUsrBchCom : $('#ohdSesUsrBchCom').val(),
                tTextScan       : ptTextScan
            },
            cache   : false,
            timeout : 0,
            success : function(tResult){
                // $('#oetRSInsertBarcode').attr('readonly',false);
                JCNxCloseLoading();
                var oText = JSON.parse(tResult);
                if(oText == '800'){
                    $('#oetRSInsertBarcode').attr('readonly',false);
                    $('#odvRSModalPDTNotFound').modal('show');
                    $('#oetRSInsertBarcode').val('');
                }else{
                    if(oText.length > 1){

                        // พบสินค้ามีหลายบาร์โค้ด
                        $('#odvRSModalPDTMoreOne').modal('show');
                        $('#odvRSModalPDTMoreOne .xCNTablePDTMoreOne tbody').html('');
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
                            $('#odvRSModalPDTMoreOne .xCNTablePDTMoreOne tbody').append(tHTML);
                        }

                        //เลือกสินค้า
                        $('.xCNColumnPDTMoreOne').off();

                        //ดับเบิ้ลคลิก
                        $('.xCNColumnPDTMoreOne').on('dblclick',function(e){
                            $('#odvRSModalPDTMoreOne').modal('hide');
                            var tJSON = decodeURIComponent(escape(window.atob($(this).attr('data-information'))));
                            FSvRSAddPdtIntoDocDTTemp(tJSON); //Client
                            FSvRSAddBarcodeIntoDocDTTemp(tJSON);
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
                        FSvRSAddPdtIntoDocDTTemp(aNewReturn); //Client
                        // JCNxCloseLoading();
                        // $('#oetRSInsertBarcode').attr('readonly',false);
                        // $('#oetRSInsertBarcode').val('');
                        FSvRSAddBarcodeIntoDocDTTemp(aNewReturn); //Server
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
            $("#odvRSModalPDTMoreOne .xCNTablePDTMoreOne tbody .xCNActivePDT").each(function( index ) {
                var tJSON = decodeURIComponent(escape(window.atob($(this).attr('data-information'))));
                FSvRSAddPdtIntoDocDTTemp(tJSON);
                FSvRSAddBarcodeIntoDocDTTemp(tJSON);
            });
        }else{
            $('#oetRSInsertBarcode').attr('readonly',false);
            $('#oetRSInsertBarcode').val('');
        }
    }

    //หลังจากค้นหาเสร็จแล้ว
    function FSvRSAddBarcodeIntoDocDTTemp(ptPdtData){
        var nStaSession = 1;
        if (typeof nStaSession !== "undefined" && nStaSession == 1){
            // JCNxOpenLoading();
            var ptXthDocNoSend  = "";
            if ($("#ohdRSRoute").val() == "dcmRSEventEdit") {
                ptXthDocNoSend  = $("#oetRSDocNo").val();
            }
            var tRSVATInOrEx    = $('#ocmRSFrmSplInfoVatInOrEx').val();
            var tRSOptionAddPdt = $('#ocmRSFrmInfoOthReAddPdt').val();
            let tRSPplCodeBch   = $('#ohdRSPplCodeBch').val();
            let tRSPplCodeCst   = $('#ohdRSPplCodeCst').val();
            var nKey            = parseInt($('#otbRSDocPdtAdvTableList tr:last').attr('data-seqno'));

            $('#oetRSInsertBarcode').attr('readonly',false);
            $('#oetRSInsertBarcode').val('');

            $.ajax({
                type: "POST",
                url: "dcmRSAddPdtIntoDTDocTemp",
                data: {
                    'tSelectBCH'        : $('#oetRSFrmBchCode').val(),
                    'tRSDocNo'          : ptXthDocNoSend,
                    'tRSVATInOrEx'      : tRSVATInOrEx,
                    'tRSOptionAddPdt'   : tRSOptionAddPdt,
                    'tRSPdtData'        : ptPdtData,
                    'tRSPplCodeBch'     : tRSPplCodeBch,
                    'tRSPplCodeCst'     : tRSPplCodeCst,
                    'ohdSesSessionID'   : $('#ohdSesSessionID').val(),
                    'ohdRSUsrCode'        : $('#ohdRSUsrCode').val(),
                    'ohdRSLangEdit'       : $('#ohdRSLangEdit').val(),
                    'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
                    'ohdRSSesUsrBchCode'  : $('#ohdRSSesUsrBchCode').val(),
                    'tSeqNo'            : nKey
                },
                cache: false,
                timeout: 0,
                success: function (oResult){
                    // JSvRSLoadPdtDataTableHtml();
                  var aResult =  JSON.parse(oResult);

                    if(aResult['nStaEvent']==1){
                        JCNxCloseLoading();
                        // $('#oetRSInsertBarcode').attr('readonly',false);
                        // $('#oetRSInsertBarcode').val('');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // JCNxResponseError(jqXHR, textStatus, errorThrown);
                    FSvRSAddBarcodeIntoDocDTTemp(ptPdtData);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
</script>
