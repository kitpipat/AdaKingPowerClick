<?php
    if($aDataDocHD['rtCode'] == "1"){
        $tTXORoute  = "dcmTXOEventEdit";
        if(isset($aAlwEvent)){
            if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaEdit'] == 1){
                $nTXOAutStaEdit = 1;
            }else{
                $nTXOAutStaEdit = 0;
            }
        }else{
            $nTXOAutStaEdit = 0;
        }
        
        $tTXODocNo              = $aDataDocHD['raItems']['FTXthDocNo'];
        $dTXODocDate            = $aDataDocHD['raItems']['FDXthDocDate'];
        $dTXODocTime            = $aDataDocHD['raItems']['FTXthDocTime'];
        $tTXOCreateBy           = $aDataDocHD['raItems']['FTCreateBy'];
        $tTXOStaDoc             = $aDataDocHD['raItems']['FTXthStaDoc'];
        $tTXOStaApv             = $aDataDocHD['raItems']['FTXthStaApv'];
        $tTXOApvCode            = $aDataDocHD['raItems']['FTXthApvCode'];
        $tTXOStaPrcStk          = $aDataDocHD['raItems']['FTXthStaPrcStk'];
        $tTXOStaDelMQ           = $aDataDocHD['raItems']['FTXthStaDelMQ'];
        $tTXOSesUsrBchCode      = $this->session->userdata("tSesUsrBchCode");

        $tTXOBchCode            = $aDataDocHD['raItems']['FTBchCode'];
        $tTXOBchName            = $aDataDocHD['raItems']['FTBchName'];
        
	    $tTXOMchCode            = $aDataDocHD['raItems']['FTXthMerCode'];
        $tTXOMchName            = $aDataDocHD['raItems']['FTMerName'];
       
        $tTXOShpTypeFrom        = $aDataDocHD['raItems']['FTShpTypeFrm'];
        $tTXOShpTypeTo          = $aDataDocHD['raItems']['FTShpTypeTo'];

        $tTXOShpCodeFrom        = $aDataDocHD['raItems']['FTXthShopFrm'];
        $tTXOShpNameFrom        = $aDataDocHD['raItems']['FTShpNameFrm'];
        $tTXOShpCodeTo          = $aDataDocHD['raItems']['FTXthShopTo'];
        $tTXOShpNameTo          = $aDataDocHD['raItems']['FTShpNameTo'];

        $tTXOPosCodeFrom        = $aDataDocHD['raItems']['FTPosCodeF'];
	    $tTXOPosNameFrom        = $aDataDocHD['raItems']['FTPosComNameF'];
	    $tTXOPosCodeTo          = $aDataDocHD['raItems']['FTPosCodeT'];
	    $tTXOPosNameTo          = $aDataDocHD['raItems']['FTPosComNameT'];

        $tTXOWahCodeFrom        = $aDataDocHD['raItems']['FTXthWhFrm'];
	    $tTXOWahNameFrom        = $aDataDocHD['raItems']['FTWahNameFrm'];
	    $tTXOWahCodeTo          = $aDataDocHD['raItems']['FTXthWhTo'];
	    $tTXOWahNameTo          = $aDataDocHD['raItems']['FTWahNameTo'];

        $tTXORefExt             = $aDataDocHD['raItems']['FTXthRefExt'];
	    $dTXORefExtDate 	    = $aDataDocHD['raItems']['FDXthRefExtDate'];
        $tTXORefInt             = $aDataDocHD['raItems']['FTXthRefInt'];
        $dTXORefIntDate         = $aDataDocHD['raItems']['FDXthRefIntDate'];

        $nTXOStaDocAct 		    = $aDataDocHD['raItems']['FNXthStaDocAct'];
        $tTXOStaRef		   	    = $aDataDocHD['raItems']['FNXthStaRef'];
        $nTXODocPrint 		    = $aDataDocHD['raItems']['FNXthDocPrint'];
        $tTXORmk                = $aDataDocHD['raItems']['FTXthRmk'];
        $tTXOVATInOrEx 		    = $aDataDocHD['raItems']['FTXthVATInOrEx'];

        $tTXODptCode            = $aDataDocHD['raItems']['FTDptCode'];
        $tTXODptName            = $aDataDocHD['raItems']['FTDptName'];
        $tTXOUsrCode            = $aDataDocHD['raItems']['FTUsrCode'];
        $tTXOUsrNameCreateBy    = $aDataDocHD['raItems']['FTUsrName'];
        $tTXOUsrNameApv         = $aDataDocHD['raItems']['FTUsrNameApv'];

        $cTXOVat                = $aDataDocHD['raItems']['FCXthVat'];
        $cTXOVatable 			= $aDataDocHD['raItems']['FCXthVatable'];
        $tTXODocType            = $tTXODocType;
        $tTXOLangEdit           = $this->session->userdata("tLangEdit");

        $tUserBchCode           = $tUserBchCode;
        $tUserBchName           = "";
        $tUserMchCode           = $tUserMchCode;
        $tUserMchName           = "";
        $tUserShpCode           = $tUserShpCode;
        $tUserShpName           = "";
        $tUserWahCode           = "";
        $tUserWahName           = "";


        // การจัดส่ง
        $tTXOCtrName            = $aDataDocHDRef['raItems']['FTXthCtrName'];
        $dTXOTnfDate            = $aDataDocHDRef['raItems']['FDXthTnfDate'];
        $tTXORefTnfID           = $aDataDocHDRef['raItems']['FTXthRefTnfID'];
        $tTXOViaCode            = $aDataDocHDRef['raItems']['FTViaCode'];
        $tTXOViaName            = $aDataDocHDRef['raItems']['FTViaName'];
        $tTXORefVehID 		    = $aDataDocHDRef['raItems']['FTXthRefVehID'];
        $tTXOQtyAndTypeUnit	    = $aDataDocHDRef['raItems']['FTXthQtyAndTypeUnit'];
        $tTXOShipAdd            = $aDataDocHDRef['raItems']['FNXthShipAdd'];

        $tTXOAddSeqNo           = $aDataDocHDRef["raItems"]["FNAddSeqNo"];
        $tTXOAddV1No            = $aDataDocHDRef["raItems"]["FTAddV1No"];
        $tTXOAddV1Soi           = $aDataDocHDRef["raItems"]["FTAddV1Soi"];
        $tTXOAddV1Village       = $aDataDocHDRef["raItems"]["FTAddV1Village"];
        $tTXOAddV1Road          = $aDataDocHDRef["raItems"]["FTAddV1Road"];
        $tTXOSudName            = $aDataDocHDRef["raItems"]["FTSudName"];
        $tTXODstName            = $aDataDocHDRef["raItems"]["FTDstName"];
        $tTXOPvnName            = $aDataDocHDRef["raItems"]["FTPvnName"];
        $tTXOAddV1PostCode      = $aDataDocHDRef["raItems"]["FTAddV1PostCode"];
        $tTXOAddV2Desc1         = $aDataDocHDRef["raItems"]["FTAddV2Desc1"];
        $tTXOAddV2Desc2         = $aDataDocHDRef["raItems"]["FTAddV2Desc2"];
    }else{
        $tTXORoute              = "dcmTXOEventAdd";
        $tTXODocNo              = "";
        $dTXODocDate            = "";
        $dTXODocTime            = "";
        $tTXOCreateBy           = $this->session->userdata('tSesUsrUsername');
        $tTXOStaDoc             = "";
        $tTXOStaApv             = "";
        $tTXOApvCode            = "";
        $tTXOStaPrcStk          = "";
        $tTXOStaDelMQ           = "";
        $tTXOSesUsrBchCode      = $this->session->userdata("tSesUsrBchCode");
        
        $tTXOBchCode            = $tBchCode;
        $tTXOBchName            = $tBchName;

        $tTXOMchCode            = $tMchCode;
        $tTXOMchName            = $tMchName;



        $tTXOShpTypeFrom        = $tShpType;
        $tTXOShpTypeTo          = $tShpType;

        $tTXOShpCodeFrom        = $tShpCodeFrom;
        $tTXOShpNameFrom        = $tShpNameFrom;
        $tTXOShpCodeTo          = $tShpCodeTo;
        $tTXOShpNameTo          = $tShpNameTo;

        $tTXOPosCodeFrom        = "";
	    $tTXOPosNameFrom        = "";
	    $tTXOPosCodeTo          = "";
	    $tTXOPosNameTo          = "";

        $tTXOWahCodeFrom        = $tWahCodeFrom;
        $tTXOWahNameFrom        = $tWahNameFrom;
        $tTXOWahCodeTo          = $tWahCodeTo;
        $tTXOWahNameTo          = $tWahNameTo;

        $tTXORefExt             = "";
	    $dTXORefExtDate 	    = "";
        $tTXORefInt             = "";
        $dTXORefIntDate         = "";

        
        $nTXOStaDocAct 		    = "";
        $tTXOStaRef		   	    = "";
        $nTXODocPrint 		    = "";
        $tTXORmk                = "";
        $tTXOVATInOrEx 		    = "";
        
        $tTXODptCode            = $tDptCode; 
        $tTXODptName            = $this->session->userdata("tSesUsrDptName"); 
        $tTXOUsrCode            = $this->session->userdata('tSesUsername');
        $tTXOUsrNameCreateBy    = $this->session->userdata('tSesUsrUsername');
        $tTXOUsrNameApv         = "";
        $cTXOVat                = "";
        $cTXOVatable 			= "";
        $nTXOAutStaEdit         = 0;
        $tTXODocType            = $tTXODocType;
        $tTXOLangEdit           = $this->session->userdata("tLangEdit");

        $tBchCompCode           = $tBchCompCode;
        $tBchCompName           = $tBchCompName;

        $tUserBchCode           = $tBchCode;
        $tUserBchName           = $tBchName;
        $tUserMchCode           = $tMchCode;
        $tUserMchName           = $tMchName;
        $tUserShpCode           = $tShpCodeFrom;
        $tUserShpName           = $tShpNameFrom;
        $tUserShpType           = $tShpType;
        $tUserWahCode           = $tWahCodeFrom;
        $tUserWahName           = $tWahNameFrom;

        // การจัดส่ง
        $tTXOCtrName            = "";
        $dTXOTnfDate            = "";
        $tTXORefTnfID           = "";
        $tTXOViaCode            = "";
        $tTXOViaName            = "";
        $tTXORefVehID 		    = "";
        $tTXOQtyAndTypeUnit	    = "";
        $tTXOShipAdd            = "";	

        $tTXOAddSeqNo           = "-";
        $tTXOAddV1No            = "-";
        $tTXOAddV1Soi           = "-";
        $tTXOAddV1Village       = "-";
        $tTXOAddV1Road          = "-";
        $tTXOSudName            = "-";
        $tTXODstName            = "-";
        $tTXOPvnName            = "-";
        $tTXOAddV1PostCode      = "-";
        $tTXOAddV2Desc1         = "";
        $tTXOAddV2Desc2         = "";
    }

    $tTXOUserType   = "";
    if(empty($tUserBchCode) && empty($tUserShpCode)){
        $tTXOUserType   = "HQ";
    }else{
        if(!empty($tUserBchCode) && empty($tUserShpCode)){
            $tTXOUserType   = "BCH";
        }else if( !empty($tUserBchCode) && !empty($tUserShpCode)){
            $tTXOUserType   = "SHP";
        }else{
            $tTXOUserType   = "";
        }
    }
?>
<style>
    .xWConsBox {
        border: 1px solid #ccc;
        position: relative;
        padding: 15px;
        margin-top: 30px;
    }
    .xWConsBox > label {
        position:absolute;top: -15px;left:15px;
        background: #fff;
        padding-left: 10px;
        padding-right: 10px;
    }
</style>
<form id="ofmTXOFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdTXORoute" name="ohdTXORoute" value="<?php echo $tTXORoute; ?>">
    <input type="hidden" id="ohdTXODocType" name="ohdTXODocType" value="<?php echo $tTXODocType;?>">
    <input type="hidden" id="ohdTXOCheckClearValidate" name="ohdTXOCheckClearValidate" value="0">
    <input type="hidden" id="ohdTXOCheckSubmitByButton" name="ohdTXOCheckSubmitByButton" value="0">
    <input type="hidden" id="ohdTXOAutStaEdit" name="ohdTXOAutStaEdit" value="<?php echo $nTXOAutStaEdit; ?>">

    <input type="hidden" id="ohdTXOStaApv" name="ohdTXOStaApv" value="<?php echo $tTXOStaApv; ?>">
    <input type="hidden" id="ohdTXOStaDoc" name="ohdTXOStaDoc" value="<?php echo $tTXOStaDoc; ?>">
	<input type="hidden" id="ohdTXOStaPrcStk" name="ohdTXOStaPrcStk" value="<?php echo $tTXOStaPrcStk; ?>">
	<input type="hidden" id="ohdTXOStaDelMQ" name="ohdTXOStaDelMQ" value="<?php echo $tTXOStaDelMQ; ?>">
    <input type="hidden" id="ohdTXOSesUsrBchCode" name="ohdTXOSesUsrBchCode" value="<?php echo $tTXOSesUsrBchCode; ?>">
    <input type="hidden" id="ohdTXOBchCode" name="ohdTXOBchCode" value="<?php echo $tTXOBchCode; ?>">
    <input type="hidden" id="ohdTXODptCode" name="ohdTXODptCode" value="<?php echo $tTXODptCode;?>">
    <input type="hidden" id="ohdTXOUsrCode" name="ohdTXOUsrCode" value="<?php echo $tTXOUsrCode?>">
    <input type="hidden" id="ohdTXOApvCodeUsrLogin" name="ohdTXOApvCodeUsrLogin" value="<?php echo $tTXOUsrCode; ?>">
    <input type="hidden" id="ohdTXOLangEdit" name="ohdTXOLangEdit" value="<?php echo $tTXOLangEdit; ?>">
    <input type="hidden" id="ohdTXOOptAlwSavQty" name="ohdTXOOptAlwSavQty" value="<?php echo $nOptDocSave?>">
    <input type="hidden" id="ohdTXOOptScanSku" name="ohdTXOOptScanSku" value="<?php echo $nOptScanSku?>">


    <button style="display:none" type="submit" id="obtSubmitTXO" onclick="JSxTXOAddEditDocument()"></button>
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvTXOHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/transferout/transferout', 'tTXOStatus'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvTXODataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTXODataStatusInfo" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="xCNTitleFrom "><?php echo language('document/transferout/transferout', 'tTXOApproved'); ?></label>
                                </div>
                                <?php if(empty($tTXODocNo)):?>
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbTXOStaAutoGenCode" name="ocbTXOStaAutoGenCode" maxlength="1" checked="checked">
                                            <span>&nbsp;</span>
                                            <span class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOAutoGenCode'); ?></span>
                                        </label>
                                    </div>
                                <?php endif;?>

                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input 
                                        type="text"
                                        class="form-control xWTooltipsBT"
                                        id="oetTXODocNo"
                                        name="oetTXODocNo"
                                        maxlength="20"
                                        value="<?php echo $tTXODocNo; ?>"
                                        data-validate-required="<?php echo language('document/transferout/transferout','tTXOPlsEnterOrRunDocNo'); ?>"
                                        data-validate-duplicate="<?php echo language('document/transferout/transferout','tTXOPlsDocNoDuplicate'); ?>"
                                        placeholder="<?php echo language('document/transferout/transferout','tTXODocNo');?>"
                                        style="pointer-events:none"
                                        readonly
                                    >
                                    <input type="hidden" id="ohdTXOCheckDuplicateCode" name="ohdTXOCheckDuplicateCode" value="2">
                                </div>

                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXODocDate'); ?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetTXODocDate"
                                            name="oetTXODocDate"
                                            value="<?php echo $dTXODocDate; ?>"
                                            data-validate-required="<?php echo language('document/transferout/transferout', 'tTXOPlsEnterDocDate'); ?>"
                                            
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtTXODocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXODocTime'); ?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNTimePicker"
                                            id="oetTXODocTime"
                                            name="oetTXODocTime"
                                            value="<?php echo $dTXODocTime; ?>"
                                            data-validate-required="<?php echo language('document/transferout/transferout', 'tTXOPlsEnterDocTime');?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtTXODocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOCreateBy'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdTXOCreateBy" name="ohdTXOCreateBy" value="<?php echo $tTXOCreateBy?>">
                                            <label><?php echo $tTXOUsrNameCreateBy?></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOTBStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/transferout/transferout', 'tTXOStaDoc'.$tTXOStaDoc); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOTBStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/transferout/transferout', 'tTXOStaApv'.$tTXOStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะประมวลผลเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOTBStaPrc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/transferout/transferout', 'tTXOStaPrcStk'.$tTXOStaPrcStk); ?></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if(isset($tTXODocNo) && !empty($tTXODocNo)):?>
                                    <!-- ผู้อนุมัติเอกสาร -->
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdTXOApvCode" name="ohdTXOApvCode" maxlength="20" value="<?php echo $tTXOApvCode?>">
                                                <label>
                                                    <?php echo (isset($tTXOUsrNameApv) && !empty($tTXOUsrNameApv))? $tTXOUsrNameApv : "-" ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Condition เอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvTXOConditionDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/transferout/transferout', 'tTXOTnfCondition'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvTXODataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTXODataConditionDoc" class="panel-collapse collapse in" role="tabpanel">
                    <?php switch($tTXODocType): 
                        case 'WAH': ?>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Condition สาขา -->
                                        <div class="form-group">
                                            <?php
                                                if($tTXORoute  == "dcmTXOEventAdd"){
                                                    if($tTXOUserType == "HQ"){
                                                        $tTXODataInputBchCode   = $tBchCompCode;

                                                    }else{
                                                        $tTXODataInputBchCode   = $tUserBchCode; 
                                                    }
                                                }else{
                                                    $tTXODataInputBchCode   = $tTXOBchCode;
                                                }
                                            ?>
                                            <input class="form-control xCNHide" id="oetTXOBchCode" name="oetTXOBchCode" maxlength="5" value="<?php echo $tTXODataInputBchCode;?>">
                                        </div>

                                        <!-- Condition กลุ่มร้านค้า -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOMerchant'); ?></label>
                                            <div class="input-group">
                                                <?php
                                                    if($tTXORoute == "dcmTXOEventAdd"){
                                                        if($tTXOUserType == "SHP"){
                                                            $tTXODataInputMchCode   = $tUserMchCode; 
                                                            $tTXODataInputMchName   = $tUserMchName; 
                                                        }else{
                                                            $tTXODataInputMchCode   = $tTXOMchCode;
                                                            $tTXODataInputMchName   = $tTXOMchName;
                                                        }
                                                    }else{
                                                        $tTXODataInputMchCode   = $tTXOMchCode;
                                                        $tTXODataInputMchName   = $tTXOMchName;
                                                    }
                                                ?>
                                                <input
                                                    class="form-control xCNHide"
                                                    id="oetTXOMchCode"
                                                    name="oetTXOMchCode"
                                                    maxlength="5"
                                                    value="<?php echo $tTXODataInputMchCode;?>"
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control xWPointerEventNone"
                                                    id="oetTXOMchName"
                                                    name="oetTXOMchName"
                                                    value="<?php echo $tTXODataInputMchName;?>"
                                                    readonly
                                                >
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="obtTXOBrowseMch" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Condition ต้นทาง -->
                                        <div class="xWConsBox">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOConsSource'); ?></label>
                                            <!-- Start ร้านค้าต้นทาง -->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOShop'); ?></label>
                                                <div class="input-group">
                                                    <?php
                                                        $tTXOInputDataShpCodeFrm    = '';
                                                        $tTXOInputDataShpNameFrm    = '';
                                                        if($tTXORoute == "dcmTXOEventAdd"){
                                                            if($tTXOUserType == "SHP"){
                                                                $tTXOInputDataShpCodeFrm    = $tUserShpCode;
                                                                $tTXOInputDataShpNameFrm    = $tUserShpName;
                                                            }
                                                        }else{
                                                            $tTXOInputDataShpCodeFrm    = $tTXOShpCodeFrom;
                                                            $tTXOInputDataShpNameFrm    = $tTXOShpNameFrom;
                                                        }
                                                    ?>
                                                    <input class="form-control xCNHide" id="oetTXOShpCodeFrom" name="oetTXOShpCodeFrom" maxlength="5" value="<?php echo $tTXOInputDataShpCodeFrm;?>">
                                                    <input type="text" class="form-control xWPointerEventNone" id="oetTXOShpNameFrom" name="oetTXOShpNameFrom" value="<?php echo $tTXOInputDataShpNameFrm;?>" readonly>
                                                    <?php
                                                        if($tTXORoute   ==  "dcmTXOEventAdd"){
                                                            $tShopFromDisabled  = 'disabled';
                                                        }else{
                                                            if(empty($tTXOMchCode)){
                                                                $tShopFromDisabled  = 'disabled';
                                                            }else{
                                                                $tShopFromDisabled  = '';
                                                            }
                                                        }
                                                    ?>
                                                    <span class="xWConditionSearchPdt input-group-btn <?php echo $tShopFromDisabled;?>">
                                                        <button id="obtTXOBrowseShpFrom" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tShopFromDisabled;?>">
                                                            <img class="xCNIconFind">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Start เครื่องจุดขายต้นทาง -->
                                            <?php
                                                $tTXOPosFromHide       = "";
                                                $tTXOPosFromeDisabled  = "";
                                                if($tTXORoute   ==  "dcmTXOEventAdd"){
                                                    if($tTXOUserType == 'SHP'){
                                                        if($tUserShpType != "4"){
                                                            $tTXOPosFromHide        = 'xCNHide';
                                                            $tTXOPosFromeDisabled   = 'disabled';
                                                        }
                                                    }else{
                                                        $tTXOPosFromHide        = 'xCNHide';
                                                        $tTXOPosFromeDisabled   = 'disabled';
                                                    }
                                                }else{
                                                    if(empty($tTXOPosCodeFrom)){
                                                        if($tTXOShpTypeFrom !=  "4"){
                                                            $tTXOPosFromHide        = 'xCNHide';
                                                            $tTXOPosFromeDisabled   = 'disabled';
                                                        }
                                                    }
                                                }
                                            ?>
                                            <div class="form-group <?php echo $tTXOPosFromHide;?>">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOPos');?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide" id="oetTXOPosCodeFrom" name="oetTXOPosCodeFrom" maxlength="5">
                                                    <input type="text" class="form-control xWPointerEventNone" id="oetTXOPosNameFrom" name="oetTXOPosNameFrom" readonly>
                                                    <span class="xWConditionSearchPdt input-group-btn <?php echo $tTXOPosFromeDisabled;?>">
                                                        <button id="obtTXOBrowsePosFrom" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tTXOPosFromeDisabled;?>">
                                                            <img class="xCNIconFind">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Start คลังสินค้าต้นทาง -->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOWarehouseFrom');?></label>
                                                <div class="input-group">
                                                    <?php
                                                        $tTXODataWahCodeFrm = "";
                                                        $tTXODataWahNameFrm = "";
                                                        if($tTXORoute == "dcmTXOEventAdd"){
                                                            if($tTXOUserType == "SHP"){
                                                                $tTXODataWahCodeFrm = $tUserWahCode;
                                                                $tTXODataWahNameFrm = $tUserWahName;
                                                            }
                                                        }else{
                                                            $tTXODataWahCodeFrm = $tTXOWahCodeFrom;
                                                            $tTXODataWahNameFrm = $tTXOWahNameFrom;
                                                        }
                                                    ?>
                                                    <input type="text" class="form-control xCNHide" id="oetTXOWahCodeFrom" name="oetTXOWahCodeFrom" maxlength="5" value="<?php echo $tTXODataWahCodeFrm;?>">
                                                    <input
                                                        type="text"
                                                        class="form-control xWPointerEventNone"
                                                        id="oetTXOWahNameFrom"
                                                        name="oetTXOWahNameFrom"
                                                        value="<?php echo $tTXODataWahNameFrm;?>"
                                                        data-validate-required="<?php echo language('document/transferout/transferout', 'tTXOPlsEnterWahFrom');?>"
                                                        readonly
                                                    >
                                                    <?php
                                                        $tConsWahFromDisabled = '';
                                                        if($tTXORoute == "dcmTXOEventAdd"){
                                                            if($tTXOUserType == 'HQ'){
                                                                $tConsWahFromDisabled   = "";
                                                            }
                                                        }else{
                                                            if($tTXOBchCode == "" || ($tTXOShpNameFrom != "" || $tTXOPosCodeFrom != "")){
                                                                if(!empty($tTXOPosCodeFrom)){
                                                                    if(!empty($tTXOWahNameFrom)){
                                                                        $tConsWahFromDisabled = "'disabled';";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <span class="input-group-btn <?php echo $tConsWahFromDisabled;?>">
                                                        <button id="obtTXOBrowseWahFrom" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tConsWahFromDisabled;?>">
                                                            <img class="xCNIconFind">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Condition ปลายทาง -->
                                        <div class="xWConsBox">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOConsDestination'); ?></label>
                                            <!-- Start ร้านค้าปลายทาง -->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOShop'); ?></label>
                                                <div class="input-group">
                                                    <?php
                                                        $tTXOInputDataShpCodeTo = '';
                                                        $tTXOInputDataShpNameTo = '';
                                                        if($tTXORoute == "dcmTXOEventAdd"){
                                                            if($tTXOUserType == "SHP"){
                                                                $tTXOInputDataShpCodeTo = "";
                                                            }
                                                        }else{
                                                            $tTXOInputDataShpCodeTo = $tTXOShpCodeTo;
                                                            $tTXOInputDataShpNameTo = $tTXOShpNameTo;
                                                        }
                                                    ?>
                                                    <input class="form-control xCNHide" id="oetTXOOldShpCodeTo" name="oetTXOOldShpCodeTo" maxlength="5" value="<?php echo $tTXOInputDataShpCodeTo;?>">
                                                    <input class="form-control xCNHide" id="oetTXOShpCodeTo" name="oetTXOShpCodeTo" maxlength="5" value="<?php echo $tTXOInputDataShpCodeTo;?>">
                                                    <input type="text" class="form-control xWPointerEventNone" id="oetTXOShpNameTo" name="oetTXOShpNameTo" value="<?php echo $tTXOInputDataShpNameTo;?>" readonly>
                                                    <?php
                                                        $tShopToDisabled    = "";
                                                        if($tTXORoute == "dcmTXOEventAdd"){
                                                            $tShopToDisabled = "disabled";
                                                        }else{
                                                            if($tTXOMchCode == ""){
                                                                $tShopToDisabled = "disabled";
                                                            }
                                                        }
                                                    ?>
                                                    <span class="xWConditionSearchPdt input-group-btn <?php echo $tShopToDisabled;?>">
                                                        <button id="obtTXOBrowseShpTo" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tShopToDisabled;?>">
                                                            <img class="xCNIconFind">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                                
                                            <!-- Start เครื่องจุดขายปลายทาง -->
                                            <?php
                                                $tTXOPosToHide      = "";
                                                $tTXOPosToDisabled  = "";
                                                if($tTXORoute == "dcmTXOEventAdd"){
                                                    $tTXOPosToHide      = "xCNHide";
                                                    $tTXOPosToDisabled  = "disabled";
                                                }else{
                                                    if($tTXOPosCodeTo == ""){
                                                        if($tTXOShpTypeTo != "4"){
                                                            $tTXOPosToHide      = "xCNHide";
                                                            $tTXOPosToDisabled  = "disabled";
                                                        }
                                                    }
                                                }
                                            ?>
                                            <div class="form-group <?php echo $tTXOPosToHide;?>">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOPos');?></label>
                                                <div class="input-group">
                                                    <?php
                                                        $tTXODataInputPosCodeTo = "";
                                                        $tTXODataInputPosNameTo = "";
                                                        if($tTXORoute != "dcmTXOEventAdd"){
                                                            $tTXODataInputPosCodeTo = $tTXOPosCodeTo;
                                                            $tTXODataInputPosNameTo = $tTXOPosNameTo;
                                                        }
                                                    ?>
                                                    <input class="form-control xCNHide" id="oetTXOOldPosCodeTo" name="oetTXOOldPosCodeTo" maxlength="5" value="<?php echo $tTXODataInputPosCodeTo;?>">
                                                    <input class="form-control xCNHide" id="oetTXOPosCodeTo" name="oetTXOPosCodeTo" maxlength="5" value="<?php echo $tTXODataInputPosCodeTo;?>">
                                                    <input type="text" class="form-control xWPointerEventNone" id="oetTXOPosNameTo" name="oetTXOPosNameTo" value="<?php echo $tTXODataInputPosNameTo;?>" readonly>
                                                    <span class="xWConditionSearchPdt input-group-btn <?php echo $tTXOPosToDisabled;?>">
                                                        <button id="obtTXOBrowsePosTo" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tTXOPosToDisabled;?>">
                                                            <img class="xCNIconFind">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Start คลังสินค้าปลายทาง -->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOWarehouseTo');?></label>
                                                <div class="input-group">
                                                    <?php
                                                        $tTXODataInputWahCodeTo = "";
                                                        $tTXODataInputWahNameTo = "";
                                                        if($tTXORoute != "dcmTXOEventAdd"){
                                                            $tTXODataInputWahCodeTo = $tTXOWahCodeTo;
                                                            $tTXODataInputWahNameTo = $tTXOWahNameTo;
                                                        }
                                                    ?>
                                                    <input type="text" class="input100 xCNHide" id="oetTXOWahCodeTo" name="oetTXOWahCodeTo" maxlength="5" value="<?php echo $tTXODataInputWahCodeTo;?>">
                                                    <input
                                                        type="text"
                                                        class="form-control xWPointerEventNone"
                                                        id="oetTXOWahNameTo"
                                                        name="oetTXOWahNameTo"
                                                        value="<?php echo $tTXODataInputWahNameTo;?>"
                                                        data-validate-required="<?php echo language('document/transferout/transferout', 'tTXOPlsEnterWahTo');?>"
                                                        readonly
                                                    >
                                                    <?php
                                                        $tConsWahToDisabled = "";
                                                        if($tTXORoute == "dcmTXOEventAdd"){
                                                            if($tTXOUserType == 'HQ' || $tTXOUserType == 'SHP'){
                                                                $tConsWahToDisabled = "";
                                                            }
                                                        }else{
                                                            if($tTXOBchCode == "" || ($tTXOShpNameTo != "" || $tTXOPosCodeTo != "")){
                                                                if(!empty($tTXOPosCodeTo)){
                                                                    if(!empty($tTXOWahNameTo)){
                                                                        $tConsWahToDisabled = "disabled";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <span class="input-group-btn <?php echo $tConsWahToDisabled;?>">
                                                        <button id="obtTXOBrowseWahTo" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tConsWahToDisabled;?>">
                                                            <img class="xCNIconFind">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php break; ?>
                        <?php case 'BCH':?>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Condition ต้นทาง -->
                                        <div class="xWConsBox">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout','tTXOConsSource'); ?></label>
                                            <!-- สาขาต้นทาง -->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout','tTXOBranchFrom'); ?></label>
                                                <?php
                                                    $tTXODataInputBchCode   = "";
                                                    $tTXODataInputBchName   = "";
                                                    if($tTXORoute == "dcmTXOEventAdd"){
                                                        if($tTXOUserType == "HQ"){
                                                            $tTXODataInputBchCode   = $tBchCompCode;
                                                            $tTXODataInputBchName   = $tBchCompName;
                                                        }else{
                                                            $tTXODataInputBchCode   = $tUserBchCode;
                                                            $tTXODataInputBchName   = $tUserBchName;
                                                        }
                                                    }else{
                                                        $tTXODataInputBchCode   = $tTXOBchCodeFrom;
                                                        $tTXODataInputBchName   = $tTXOBchNameFrom;
                                                    }
                                                ?>
                                                <input type="text" class="form-control xCNHide" id="oetTXOBchCodeFrom" name="oetTXOBchCodeFrom" value="<?php echo $tTXODataInputBchCode;?>">
                                                <input type="text" class="form-control" id="oetTXOBchNameFrom" name="oetTXOBchNameFrom" value="<?php echo $tTXODataInputBchName;?>" readonly>
                                            </div>
                                            <!-- คลังต้นทาง  -->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOWarehouseFrom');?></label>
                                                <div class="input-group">
                                                    <?php
                                                        $tTXODataWahCodeFrm = "";
                                                        $tTXODataWahNameFrm = "";
                                                        if($tTXORoute == "dcmTXOEventAdd"){
                                                            if($tTXOUserType == "SHP"){
                                                                $tTXODataWahCodeFrm = $tUserWahCode;
                                                                $tTXODataWahNameFrm = $tUserWahName;
                                                            }
                                                        }else{
                                                            $tTXODataWahCodeFrm = $tTXOWahCodeFrom;
                                                            $tTXODataWahNameFrm = $tTXOWahNameFrom;
                                                        }
                                                    ?>

                                                    <input type="text" class="form-control xCNHide" id="oetTXOWahCodeFrom" name="oetTXOWahCodeFrom" maxlength="5" value="<?php echo $tTXODataWahCodeFrm;?>">
                                                    <input
                                                        type="text"
                                                        class="form-control xWPointerEventNone"
                                                        id="oetTXOWahNameFrom"
                                                        name="oetTXOWahNameFrom"
                                                        value="<?php echo $tTXODataWahNameFrm;?>"
                                                        data-validate-required="<?php echo language('document/transferout/transferout', 'tTXOPlsEnterWahFrom');?>"
                                                        readonly
                                                    >
                                                    <span class="input-group-btn">
                                                        <button id="obtTXOBrowseWahFrom" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                            <img class="xCNIconFind">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Condition ปลายทาง -->
                                        <div class="xWConsBox">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOConsDestination'); ?></label>
                                            <!-- สาขาปลายทาง -->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOBranchTo'); ?></label>
                                                <div class="input-group">
                                                    <?php
                                                        $tTXODataBchCodeTo  = "";
                                                        $tTXODataBchNameTo  = "";
                                                        if($tTXORoute != "dcmTXOEventAdd"){
                                                            $tTXODataBchCodeTo  = $tTXOBchCodeTo;
                                                            $tTXODataBchNameTo  = $tTXOBchNameTo;
                                                        }
                                                    ?>
                                                    <input class="form-control xCNHide" id="oetTXOOldBchCodeTo" name="oetTXOOldBchCodeTo" maxlength="5" value="<?php echo $tTXODataBchCodeTo;?>">
                                                    <input class="form-control xCNHide" id="oetTXOBchCodeTo" name="oetTXOBchCodeTo" maxlength="5" value="<?php echo $tTXODataBchCodeTo;?>">
                                                    <input
                                                        type="text"
                                                        class="form-control xWPointerEventNone"
                                                        id="oetTXOBchNameTo"
                                                        name="oetTXOWahNameTo"
                                                        value="<?php echo $tTXODataBchNameTo;?>"
                                                        data-validate-required="<?php echo language('document/transferout/transferout', 'tTXOPlsEnterBranch');?>"
                                                        readonly
                                                    >
                                                    <span class="input-group-btn">
                                                        <button id="obtTXOBrowseBchTo" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                            <img class="xCNIconFind">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- คลังปลายทาง -->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOWarehouseTo');?></label>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php break; ?>
                        
                    <?php endswitch; ?>
                </div>
            </div>

            <!-- Panel ข้อมูลอ้างอิง -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvTXOReferenceDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/transferout/transferout', 'tTXOReference'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvTXODataReferenceDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTXODataReferenceDoc" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- เลขที่อ้างอิงเอกสารภายใน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXORefInt'); ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSpc" id="oetTXORefInt" name="oetTXORefInt" maxlength="20" value="<?php echo $tTXORefExt;?>">
                                </div>

                                <!-- วันที่เอกสารภายใน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXORefIntDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTXORefIntDate" name="oetTXORefIntDate" value="<?php echo $dTXORefIntDate;?>">
                                        <span class="input-group-btn">
                                            <button id="obtTXORefIntDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- เลขที่อ้างอิงเอกสารภายนอก -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXORefExt'); ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSpc" id="oetTXORefExt" name="oetTXORefExt" maxlength="20" value="<?php echo $tTXORefExt;?>">
                                </div>

                                <!-- วันที่เอกสารภายนอก -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXORefExtDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTXORefExtDate" name="oetTXORefExtDate" value="<?php echo $dTXORefExtDate?>">
                                        <span class="input-group-btn">
                                            <button id="obtTXORefExtDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel การข่นส่ง -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvTXOTransportationDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/transferout/transferout', 'tTXOTransportation'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTXODataTransportationDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTXODataTransportationDoc" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- ชื่อผู้ติดต่อ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOCtrName'); ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSpc" id="oetTXOCtrName" name="oetTXOCtrName" maxlength="20" value="<?php echo $tTXOCtrName;?>">
                                </div>
                                <!-- วันที่ขนส่ง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOTnfDate'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTXOTnfDate" name="oetTXOTnfDate" value="<?php echo $dTXOTnfDate;?>">
                                        <span class="input-group-btn">
                                            <button id="obtTXOTnfDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- อ้างอิงเลขที่ใบขนส่ง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXORefTnfID'); ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetTXORefTnfID" name="oetTXORefTnfID" value="<?php echo $tTXORefTnfID?>">
                                </div>
                                <!-- ขนส่งโดย -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOViaCode'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetTXOViaCode" name="oetTXOViaCode" value="<?php echo $tTXOViaCode;?>">
                                        <input 
                                            type="text"
                                            class="form-control xWPointerEventNone"
                                            id="oetTXOViaName"
                                            name="oetTXOViaName"
                                            value="<?php echo $tTXOViaName;?>"
                                            data-validate-required="<?php echo language('document/transferout/transferout','tTXOMsgPlsAddShpVia');?>"
                                            readonly
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtTXOBrowseShipVia" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- อ้างอิงเลขที่ยานพาหนะขนส่ง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXORefVehID'); ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetTXORefVehID" name="oetTXORefVehID" value="<?php echo $tTXORefVehID?>">
                                </div>
                                <!-- ลักษณะหีบห่อ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOQtyAndTypeUnit'); ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetTXOQtyAndTypeUnit" name="oetTXOQtyAndTypeUnit" value="<?php echo $tTXOQtyAndTypeUnit?>">
                                </div>
                                <!-- ที่อยู๋สำหรับจัดส่ง -->
                                <div class="form-group">
                                    <input type="hidden" id="ohdTXOShipAdd" name="ohdTXOShipAdd" value="<?php echo $tTXOShipAdd;?>">
                                    <button type="button" id="obtTXOBrowseShipAdd" class="btn btn-primary" style="font-size: 17px;">+ <?php echo language('document/transferout/transferout', 'tTXOShipAddress'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel อื่นๆ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvTXOOtherDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/transferout/transferout', 'tTXOOther');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTXODataOtherDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTXODataOtherDoc" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- สถานะเคลื่อนไหว -->
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input
                                            type="checkbox"
                                            id="ocbTXOStaDocAct"
                                            name="ocbTXOStaDocAct"
                                            maxlength="1"
                                            <?php echo $nTXOStaDocAct == '' ? 'checked' : $nTXOStaDocAct == '1' ? 'checked' : '0'; ?>
                                        >
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOStaDocAct'); ?></span>
                                    </label>
                                </div>
                                <!-- ประเภทภาษี -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOVATInOrEx'); ?></label>
                                    <input type="text" class="xCNHide" id="ohdTXOVATInOrEx" name="ohdTXOVATInOrEx" value="<?php echo $tTXOVATInOrEx ?>">
                                    <select class="form-control selectpicker" id="ostTXOVATInOrEx" name="ostTXOVATInOrEx" maxlength="1" value="<?php echo $tTXOVATInOrEx ?>">
                                        <option value="1"><?php echo language('document/transferout/transferout', 'tTXOVATIn'); ?></option>
                                        <option value="2"><?php echo language('document/transferout/transferout', 'tTXOVATEx'); ?></option>
                                    </select>
                                </div>
                                <!-- สถานะอ้างอิง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOStaRef'); ?></label>
                                    <input type="hidden" id="ohdTXOStaRef" name="ohdTXOStaRef" value="<?php echo $tTXOStaRef?>">
                                    <select class="form-control selectpicker" id="ostTXOStaRef" name="ostTXOStaRef" maxlength="1" value="<?php echo $tTXOStaRef?>">
                                        <option value="1"><?php echo language('document/transferout/transferout', 'tTXOStaRef0'); ?></option>
                                        <option value="2"><?php echo language('document/transferout/transferout', 'tTXOStaRef1'); ?></option>
                                        <option value="3"><?php echo language('document/transferout/transferout', 'tTXOStaRef2'); ?></option>
                                    </select>
                                </div>
                                <!-- จำนวนครั้งที่พิมพ์ / ครั้ง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXODocPrint'); ?></label>
                                    <input
                                        type="text"
                                        class="form-control xCNInputWithoutSpc"
                                        maxlength="100"
                                        id="oetTXODocPrint"
                                        name="oetTXODocPrint"
                                        maxlength="1"
                                        value="<?php echo $nTXODocPrint?>"
                                    >
                                </div>
                                <!-- หมายเหตุ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXORemark'); ?></label>
                                    <textarea class="form-control" id="otaTXORmk" name="otaTXORmk" rows="10" maxlength="200" style="resize: none;height:86px;"><?php echo $tTXORmk?></textarea>
                                </div>
                                <!-- ตัวเลือกในการเพิ่มรายการสินค้าจากเมนูสแกนสินค้าในหน้าเอกสาร * กรณีเพิ่มสินค้าเดิม -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOOptionAddPdt'); ?></label>
                                    <select class="form-control selectpicker" id="ocmTXOOptionAddPdt" name="ocmTXOOptionAddPdt">
                                        <option value="1"><?php echo language('document/transferout/transferout', 'tTXOOptionAddPdtAddNumPdt');?></option>
                                        <option value="2"><?php echo language('document/transferout/transferout', 'tTXOOptionAddPdtAddNewRow');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <div class="row">
                <!-- ตารางรายการสินค้า -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:200px;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="100"
                                                    id="oetTXOSearchPdtHTML"
                                                    name="oetTXOSearchPdtHTML"
                                                    onkeyup="JSvTXOSearchPdtHTML()"
                                                    placeholder="<?php echo language('document/transferout/transferout', 'tTXOSearchPdt');?>"
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="100"
                                                    id="oetTXOScanPdtHTML"
                                                    name="oetTXOScanPdtHTML"
                                                    onkeyup="Javascript:if(event.keyCode==13) JSvTXOScanPdtHTML()"
                                                    placeholder="<?php echo language('document/transferout/transferout', 'tTXOScanPdt'); ?>"
                                                    style="display:none;"
                                                    data-validate="ไม่พบข้อมูลที่แสกน"
                                                >
                                                <span class="input-group-btn">
                                                    <div id="odvTXOSearchBtnGrp" class="xCNDropDrownGroup input-group-append">
                                                        <button id="obtTXOMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvTXOSearchPdtHTML()">
                                                            <img class="xCNIconSearch" style="width:20px;">
                                                        </button>
                                                        <button id="obtTXOMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSvTXOScanPdtHTML()">
                                                            <img class="xCNIconScanner" style="width:20px;">
                                                        </button>
                                                        <button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown">
                                                            <i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a id="oliTXOMngPdtSearch"><label><?php echo language('document/transferout/transferout', 'tTXOSearchPdt'); ?></label></a>
                                                                <a id="oliTXOMngPdtScan"><?php echo language('document/transferout/transferout', 'tTXOScanPdt'); ?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>   
                                            </div>    
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                        <div id="odvTXOMngAdvPdtDataTable" class="btn-group xCNDropDrownGroup right">
                                            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                                <?php echo language('common/main/main','tCMNOption')?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li id="oliTXOMngPdtColum">
                                                    <a ><?php echo language('common/main/main','tModalAdvMngTable')?></a>
                                                </li>
                                                <li id="oliTXODelPdtDT" class="disabled">
                                                    <a data-toggle="modal" data-target="#odvTXOModalDelPdtDTTemp"><?php echo language('common/main/main','tDelAll')?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                        <div class="form-group">
                                            <div style="position: absolute;right: 15px;top:-5px;">
                                                <button
                                                    type="button"
                                                    id="obtTXODocBrowsePdt"
                                                    class="xCNBTNPrimeryPlus xCNDocBrowsePdt"
                                                >+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="odvTXOPdtTablePanal">
                                </div>
                                <div class="row" id="odvTXOPdtTablePanalDataHide">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="odvTXOVatTableData" class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                </div>
                <div id="odvTXOCalcLastBillSetText" class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                </div>
            </div>
        </div>
    </div>
</form>

<!-- =================================================================== View Modal TransferOut =================================================================== -->
    <div id="odvTXOBrowseShipAdd" class="modal fade">
        <div class="modal-dialog" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/transferout/transferout','tTXOShipAddress'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnTXOAddShipAdd()"><?php echo language('common/main/main', 'tModalConfirm')?></button>  
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
                                            <label class="xCNTextDetail1"><?php echo language('document/transferout/transferout', 'tTXOAddInfo');?></label> 
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <a style="font-size:14px!important;color:#179bfd;">
                                                <i class="fa fa-pencil" id="oliTXOEditShipAddr">&nbsp;<?php echo language('document/transferout/transferout','tTXOChange');?></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body xCNPDModlue">
                                    <input type="hidden" id="ohdTXOShipAddSeqNo" class="form-control">
                                    <?php $tTXOFormatAddressType    = FCNaHAddressFormat('TCNMBranch'); //1 ที่อยู่ แบบแยก  ,2  แบบรวม ?>
                                    <?php if(!empty($tTXOFormatAddressType) && $tTXOFormatAddressType == '1'): ?>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOBrowseADDV1No');?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTXOShipAddAddV1No"><?php echo $tTXOAddV1No;?></label> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOBrowseADDV1Village');?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTXOShipAddV1Soi"><?php echo $tTXOAddV1Soi;?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOBrowseADDV1Soi'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTXOShipAddV1Village"><?php echo $tTXOAddV1Village;?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOBrowseADDV1Road'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTXOShipAddV1Road"><?php echo $tTXOAddV1Road;?></label> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOBrowseADDV1SubDist'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTXOShipAddV1SubDist"><?php echo $tTXOAddV1SubDist;?></label> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOBrowseADDV1DstCode'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTXOShipAddV1DstCode"><?php echo $tTXOAddV1DstCode?></label> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOBrowseADDV1PvnCode'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTXOShipAddV1PvnCode"><?php echo $tTXOAddV1PvnCode?></label> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOBrowseADDV1PostCode'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospTXOShipAddV1PostCode"><?php echo $tTXOAddV1PostCode;?></label> 
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout','tTXOBrowseADDV2Desc1')?></label><br>
                                                    <label id="ospTXOShipAddV2Desc1" name="ospShipAddV2Desc1"><?php echo $tTXOAddV2Desc1;?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout','tTXOBrowseADDV2Desc2')?></label><br>
                                                    <label id="ospTXOShipAddV2Desc2" name="ospShipAddV2Desc2"><?php echo $tTXOAddV2Desc2;?></label>
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
<!-- ============================================================================================================================================================== -->

<!-- ================================================================== View Modal Advance Table ================================================================== -->
    <div class="modal fade" id="odvTXOOrderAdvTblColumns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <div class="modal-body" id="odvTXOModalBodyAdvTable">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
                    <button id="obtTXOSaveAdvTableColums" type="button" class="btn btn-primary"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================== -->

<!-- ================================================================= View Modal Appove Document ================================================================= -->
    <div id="odvTXOModalAppoveDoc" class="modal fade xCNModalApprove">
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
                    <button onclick="JSxTXOApproveDocument(true)" type="button" class="btn xCNBTNPrimery">
                        <?php echo language('common/main/main', 'tModalConfirm'); ?>
                    </button>
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                        <?php echo language('common/main/main', 'tModalCancel'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================== -->

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php
    switch($tTXODocType){
        case 'WAH':
            include('script/jTransferoutWahAdd.php');
        break;
        case 'BCH':
            include('script/jTransferoutBchAdd.php');
        break;
    }
?>
