<?php
    $tSesUsrLevel   = $this->session->userdata('tSesUsrLevel');
    $tUserBchName   = $this->session->userdata('tSesUsrBchNameDefault');
    $tUserBchCode   = $this->session->userdata('tSesUsrBchCodeDefault');
    if(isset($aDataDocHD) && $aDataDocHD['rtCode'] == '1'){
        $aDataDocHD             = @$aDataDocHD['raItems'];
        $tTRBRoute               = "docTRBEventEdit";
        $nTRBAutStaEdit          = 1;
        $tTRBDocNo               = $aDataDocHD['rtXthDocNo'];
        $dTRBDocDate             = date("Y-m-d",strtotime($aDataDocHD['rdXthDocDate']));
        $dTRBDocTime             = date("H:i",strtotime($aDataDocHD['rdXthDocDate']));
        $tTRBCreateBy            = $aDataDocHD['rtCreateBy'];
        $tTRBUsrNameCreateBy     = $aDataDocHD['rtUsrName'];

        $tTRBStaDoc              = $aDataDocHD['rtXthStaDoc'];
        $tTRBStaApv              = $aDataDocHD['rtXthStaApv'];
  

        $tTRBSesUsrBchCode       = $this->session->userdata("tSesUsrBchCodeDefault");
  
        $tTRBUsrCode             = $this->session->userdata('tSesUsername');
        $tTRBLangEdit            = $this->session->userdata("tLangEdit");

        $tTRBApvCode             = $aDataDocHD['rtXthApvCode'];
        $tTRBUsrNameApv          = $aDataDocHD['rtXthApvName'];
        $tTRBRefPoDoc            = "";
        $tTRBRefIntDoc           = $aDataDocHD['rtXthRefInt'];
        $dTRBRefIntDocDate       = $aDataDocHD['rdXthRefIntDate'];
        $tTRBRefExtDoc           = $aDataDocHD['rtXthRefExt'];
        $dTRBRefExtDocDate       = $aDataDocHD['rdXthRefExtDate'];
        
        $nTRBStaRef              = $aDataDocHD['rnXthStaRef'];

        $tTRBBchCode             = $aDataDocHD['rtBchCode'];
        $tTRBBchName             = $aDataDocHD['rtBchName'];
        $tTRBUserBchCode         = $tUserBchCode;
        $tTRBUserBchName         = $tUserBchName;


        $nTRBStaDocAct           = $aDataDocHD['rnXthStaDocAct'];
        $tTRBFrmDocPrint         = $aDataDocHD['rnXthDocPrint'];
        $tTRBFrmRmk              = $aDataDocHD['rtXthRmk'];

        $tTRBAgnCode             = $aDataDocHD['rtAgnCode'];
        $tTRBAgnName             = $aDataDocHD['rtAgnName'];

        $tTRBAgnCodeTo             = $aDataDocHD['rtAgnCodeTo'];
        $tTRBAgnNameTo             = $aDataDocHD['rtAgnNameTo'];
        $tTRBBchCodeTo             = $aDataDocHD['rtBchCodeTo'];
        $tTRBBchNameTo             = $aDataDocHD['rtBchNameTo'];
        $tTRBWahCodeTo             = $aDataDocHD['rtWahCodeTo'];
        $tTRBWahNameTo             = $aDataDocHD['rtWahNameTo'];
      
        $tTRBAgnCodeShip             = $aDataDocHD['rtAgnCodeShip'];
        $tTRBAgnNameShip             = $aDataDocHD['rtAgnNameShip'];
        $tTRBBchCodeShip             = $aDataDocHD['rtBchCodeShip'];
        $tTRBBchNameShip             = $aDataDocHD['rtBchNameShip'];
        $tTRBWahCodeShip             = $aDataDocHD['rtWahCodeShip'];
        $tTRBWahNameShip             = $aDataDocHD['rtWahNameShip'];


        $tTRBRsnCode             = $aDataDocHD['rtRsnCode'];
        $tTRBRsnName             = $aDataDocHD['rtRsnName'];

        

        $tTRBVatInOrEx           = 1;

        $nStaUploadFile         = 2;
        $nTRBStaDocAct           = $aDataDocHD['rnXthStaDocAct'];

    }else{
        $tTRBRoute               = "docTRBEventAdd";
        $nTRBAutStaEdit          = 0;
        $tTRBDocNo               = "";
        $dTRBDocDate             = "";
        $dTRBDocTime             = "";
        $tTRBCreateBy            = $this->session->userdata('tSesUsrUsername');
        $tTRBUsrNameCreateBy     = $this->session->userdata('tSesUsrUsername');
        $nTRBStaRef              = 0;
        $tTRBStaDoc              = 1;
        $tTRBStaApv              = NULL;
  

        $tTRBSesUsrBchCode       = $this->session->userdata("tSesUsrBchCodeDefault");
  
        $tTRBUsrCode             = $this->session->userdata('tSesUsername');
        $tTRBLangEdit            = $this->session->userdata("tLangEdit");

        $tTRBApvCode             = "";
        $tTRBUsrNameApv          = "";
        $tTRBRefPoDoc            = "";
        $tTRBRefIntDoc           = "";
        $dTRBRefIntDocDate       = "";
        $tTRBRefExtDoc           = "";
        $dTRBRefExtDocDate       = "";


        $tTRBBchCode             = $tBchCode;
        $tTRBBchName             = $tBchName;
        $tTRBUserBchCode         = $tBchCode;
        $tTRBUserBchName         = $tBchName;

        $tTRBAgnCode             = "";
        $tTRBAgnName             = "";

        $tTRBAgnCodeTo             = "";
        $tTRBAgnNameTo             = "";
        $tTRBBchCodeTo             = "";
        $tTRBBchNameTo             = "";
        $tTRBWahCodeTo             = "";
        $tTRBWahNameTo             = "";
      
        $tTRBAgnCodeShip             = "";
        $tTRBAgnNameShip             = "";
        $tTRBBchCodeShip             = "";
        $tTRBBchNameShip             = "";
        $tTRBWahCodeShip             = "";
        $tTRBWahNameShip             = "";


        $nTRBStaDocAct           = "";
        $tTRBFrmDocPrint         = "";
        $tTRBFrmRmk              = "";

        $tTRBRsnCode             = "";
        $tTRBRsnName             = "";

        $tTRBVatInOrEx           = $tCmpRetInOrEx;
        $tTRBSplPayMentType      = "";


        $nStaUploadFile         = 1;
        $nTRBStaDocAct           = "";
    }
    if(empty($tTRBBchCode) && empty($tTRBShopCode)){
        $tASTUserType   = "HQ";
    }else{
        if(!empty($tTRBBchCode) && empty($tTRBShopCode)){
            $tASTUserType   = "BCH";
        }else if( !empty($tTRBBchCode) && !empty($tTRBShopCode)){
            $tASTUserType   = "SHP";
        }else{
            $tASTUserType   = "";
        }
    }
?>

<style>
    #odvRowDataEndOfBill .panel-heading{
        padding-top     : 10px !important;
        padding-bottom  : 10px !important;
    }
    #odvRowDataEndOfBill .panel-body{
        padding-top     : 0px !important;
        padding-bottom  : 0px !important;
    }
    #odvRowDataEndOfBill .list-group-item {
        padding-left    : 0px !important;
        padding-right   : 0px !important;
        border          : 0px solid #ddd;
    }

</style>
<form id="ofmTRBFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdTRBPage" name="ohdTRBPage" value="1">
    <input type="hidden" id="ohdTRBStaaImport" name="ohdTRBStaaImport" value="0">
    <input type="hidden" id="ohdTRBFrmSplInfoVatInOrEx" name="ohdTRBFrmSplInfoVatInOrEx" value="<?=$tTRBVatInOrEx?>">
    <input type="hidden" id="ohdTRBRoute" name="ohdTRBRoute" value="<?php echo $tTRBRoute;?>">
    <input type="hidden" id="ohdTRBCheckClearValidate" name="ohdTRBCheckClearValidate" value="0">
    <input type="hidden" id="ohdTRBCheckSubmitByButton" name="ohdTRBCheckSubmitByButton" value="0">
    <input type="hidden" id="ohdTRBAutStaEdit" name="ohdTRBAutStaEdit" value="<?php echo $nTRBAutStaEdit;?>">
    <input type="hidden" id="ohdTRBODecimalShow" name="ohdTRBODecimalShow" value="<?=$nOptDecimalShow?>">
    <input type="hidden" id="ohdTRBStaDoc" name="ohdTRBStaDoc" value="<?php echo $tTRBStaDoc;?>">
    <input type="hidden" id="ohdTRBStaApv" name="ohdTRBStaApv" value="<?php echo $tTRBStaApv;?>">
    <input type="hidden" id="ohdTRBStaRef" name="ohdTRBStaRef" value="<?php echo $nTRBStaRef;?>">
    <input type="hidden" id="ohdTRBRefIntDoc" name="ohdTRBRefIntDoc" value="<?php echo $tTRBRefIntDoc;?>">

    <input type="hidden" id="ohdTRBSesUsrBchCode" name="ohdTRBSesUsrBchCode" value="<?php echo $tTRBSesUsrBchCode; ?>">
    <input type="hidden" id="ohdTRBBchCode" name="ohdTRBBchCode" value="<?php echo $tTRBBchCode; ?>">

    <input type="hidden" id="ohdTRBUsrCode" name="ohdTRBUsrCode" value="<?php echo $tTRBUsrCode?>">


    <input type="hidden" id="ohdTRBApvCodeUsrLogin" name="ohdTRBApvCodeUsrLogin" value="<?php echo $tTRBUsrCode; ?>">
    <input type="hidden" id="ohdTRBLangEdit" name="ohdTRBLangEdit" value="<?php echo $tTRBLangEdit; ?>">
    <input type="hidden" id="ohdTRBOptAlwSaveQty" name="ohdTRBOptAlwSaveQty" value="<?php echo $nOptDocSave?>">
    <input type="hidden" id="ohdSesSessionID" name="ohdSesSessionID" value="<?=$this->session->userdata('tSesSessionID')?>"  >
    <input type="hidden" id="ohdSesSessionName" name="ohdSesSessionName" value="<?=$this->session->userdata('tSesUsrUsername')?>"  >
    <input type="hidden" id="ohdSesUsrLevel" name="ohdSesUsrLevel" value="<?=$this->session->userdata('tSesUsrLevel')?>"  >
    <input type="hidden" id="ohdSesUsrBchCom" name="ohdSesUsrBchCom" value="<?=$this->session->userdata('tSesUsrBchCom')?>"  >
    <input type="hidden" id="ohdTRBValidatePdt" name="ohdTRBValidatePdt" value="<?=language('document/transferrequestbranch/transferrequestbranch', 'tTRBPleaseSeletedPDTIntoTable')?>">
    <input type="hidden" id="ohdTRBSubmitWithImp" name="ohdTRBSubmitWithImp" value="0">
    <input type="hidden" id="ohdTRBVATInOrEx" name="ohdTRBVATInOrEx" value="">
    <input type="hidden" id="ohdTRBPayType" name="ohdTRBPayType" value="">

    <input type="hidden" id="ohdTRBValidatePdtImp" name="ohdTRBValidatePdtImp" value="<?=language('document/transferrequestbranch/transferrequestbranch', 'tTRBNotFoundPdtCodeAndBarcodeImpList')?>">
    
    <button style="display:none" type="submit" id="obtTRBSubmitDocument" onclick="JSxTRBAddEditDocument()"></button>
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvTRBHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBDoucment'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvTRBDataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTRBDataStatusInfo" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="text-success xCNTitleFrom"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmAppove');?></label>
                                </div>
                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelFrmDocNo'); ?></label>
                                <?php if(isset($tTRBDocNo) && empty($tTRBDocNo)):?>
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbTRBStaAutoGenCode" name="ocbTRBStaAutoGenCode" maxlength="1" checked="checked">
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelFrmAutoGenCode');?></span>
                                    </label>
                                </div>
                                <?php endif;?>
                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input
                                        type="text"
                                        class="form-control xControlForm xCNGenarateCodeTextInputValidate xCNInputWithoutSpcNotThai"
                                        id="oetTRBDocNo"
                                        name="oetTRBDocNo"
                                        maxlength="20"
                                        value="<?php echo $tTRBDocNo;?>"
                                        data-validate-required="<?php echo language('document/purchaseorder/purchaseorder','tTRBPlsEnterOrRunDocNo'); ?>"
                                        data-validate-duplicate="<?php echo language('document/purchaseorder/purchaseorder','tTRBPlsDocNoDuplicate'); ?>"
                                        placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelFrmDocNo');?>"
                                        style="pointer-events:none"
                                        readonly
                                    >
                                    <input type="hidden" id="ohdTRBCheckDuplicateCode" name="ohdTRBCheckDuplicateCode" value="2">
                                </div>
                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelFrmDocDate');?></label>
                                    <div class="input-group">
                                        <?php if ($dTRBDocDate == '') {
                                            $dTRBDocDate = '';
                                        } ?>
                                        <input
                                            type="text"
                                            class="form-control xControlForm xCNDatePicker xCNInputMaskDate"
                                            id="oetTRBDocDate"
                                            name="oetTRBDocDate"
                                            value="<?php echo $dTRBDocDate; ?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtTRBDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelFrmDocTime');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xControlForm xCNTimePicker"
                                            id="oetTRBDocTime"
                                            name="oetTRBDocTime"
                                            value="<?php echo $dTRBDocTime; ?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtTRBDocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelFrmCreateBy');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdTRBCreateBy" name="ohdTRBCreateBy" value="<?php echo $tTRBCreateBy?>">
                                            <label><?php echo $tTRBUsrNameCreateBy?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelFrmStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <?php
                                                if($tTRBRoute == "docTRBEventAdd"){
                                                    $tTRBLabelStaDoc  = language('document/purchaseorder/purchaseorder', 'tPOLabelFrmValStaDoc');
                                                }else{
                                                    $tTRBLabelStaDoc  = language('document/purchaseorder/purchaseorder', 'tPOLabelFrmValStaDoc'.$tTRBStaDoc);
                                                }
                                            ?>
                                            <label><?php echo $tTRBLabelStaDoc;?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelFrmStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmValStaApv'.$tTRBStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>
                             <!-- สถานะอ้างอิงเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelFrmStaRef'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">

                                            <label><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmStaRef'.$nTRBStaRef); ?></label>

                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($tTRBDocNo) && !empty($tTRBDocNo)):?>
                                    <!-- ผู้อนุมัติเอกสาร -->
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelFrmApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdTRBApvCode" name="ohdTRBApvCode" maxlength="20" value="<?php echo $tTRBApvCode?>">
                                                <label>
                                                    <?php echo (isset($tTRBUsrNameApv) && !empty($tTRBUsrNameApv))? $tTRBUsrNameApv : "-" ?>
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
            
            <!-- Panel สาขาที่รับของ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvTRBReferenceDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabeAcpBch');?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvTRBDataReferenceDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTRBDataReferenceDoc" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-t-10">
                            <div class="form-group m-b-0">
                                    <?php
                                        $tTRBDataInputBchCode   = "";
                                        $tTRBDataInputBchName   = "";
                                        if($tTRBRoute  == "docTRBEventAdd"){
                                            $tTRBDataInputBchCode    = $this->session->userdata('tSesUsrBchCodeDefault');
                                            $tTRBDataInputBchName    = $this->session->userdata('tSesUsrBchNameDefault');
                                            $tDisabledBch = '';
                                        }else{
                                            $tTRBDataInputBchCode    = $tTRBBchCode;
                                            $tTRBDataInputBchName    = $tTRBBchName;
                                            $tDisabledBch = 'disabled';
                                        }
                                    ?>
                                <!--สาขา-->
                                <script>
                                    var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                                    if( tUsrLevel != "HQ" ){
                                        $('#oimTRBBrowseAgn').attr("disabled", true);
                                        $('#obtTRBBrowseBCH').attr('disabled',true);
                                    }
                                </script>
                                <!--Agn Browse-->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?></label>
                                    <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetTRBAgnCode" name="oetTRBAgnCode" maxlength="5" value="<?= @$tTRBAgnCode; ?>">
                                        <input  type="text" 
                                                class="form-control xControlForm xWPointerEventNone" 
                                                id="oetTRBAgnName" name="oetTRBAgnName" 
                                                maxlength="100" 
                                                placeholder="<?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?>" 
                                                value="<?= @$tTRBAgnName; ?>" 
                                                data-validate-required="<?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBPlsSelectAgn') ?>"
                                                readonly>
                                        <span class="input-group-btn">
                                            <button id="oimTRBBrowseAgn" type="button" class="btn xCNBtnBrowseAddOn" <?= @$tDisabledBch ?>>
                                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!--Agn Bch-->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelFrmBranch')?></label>
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control xControlForm xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                                                id="oetTRBFrmBchCode"
                                                name="oetTRBFrmBchCode"
                                                maxlength="5"
                                                value="<?php echo @$tTRBDataInputBchCode?>"
                                                data-bchcodeold = "<?php echo @$tTRBDataInputBchCode?>"
                                            >
                                            <input
                                                type="text"
                                                class="form-control xControlForm xWPointerEventNone"
                                                id="oetTRBFrmBchName"
                                                name="oetTRBFrmBchName"
                                                maxlength="100"
                                                placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelFrmBranch')?>"
                                                data-validate-required="<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsEnterBch'); ?>"
                                                value="<?php echo @$tTRBDataInputBchName?>"
                                                readonly
                                            >
                                            <span class="input-group-btn xWConditionSearchPdt">
                                                <button id="obtTRBBrowseBCH" type="button" class="btn xCNBtnBrowseAddOn" <?= @$tDisabledBch ?>>
                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                </div>

                                <!-- Ref Doc Int Browse -->
                                <div class="form-group" style="display:none;" >
                                    <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelRefDocInt');?></label>
                                    <div class="input-group">
                                        <input  
                                            type="text" 
                                            class="form-control xControlForm xWPointerEventNone" 
                                            id="oetTRBRefDocIntName" name="oetTRBRefDocIntName" 
                                            value="<?php echo $tTRBRefIntDoc ?>"
                                            placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelRefDocInt')?>" 
                                            readonly
                                        >
                                        <span class="xWConditionSearchPdt input-group-btn">
                                            <button id="obtTRBBrowseRefDocInt" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!-- Ref Doc Int Datepicker -->
                                <div class="form-group" style="display:none;">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelRefDocIntDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xControlForm xCNDatePicker xCNInputMaskDate"
                                            id="oetTRBRefIntDocDate"
                                            name="oetTRBRefIntDocDate"
                                            value="<?php echo $dTRBRefIntDocDate ?>"
                                            placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBPHDRefTSCode')?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtTRBBrowseRefIntDocDate" name="obtTRBBrowseRefIntDocDate" type="button" class="btn xCNDatePicker xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Ref Doc Ext input -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelRefDocExt');?></label>
                                    <input
                                        type="text"
                                        class="form-control xControlForm"
                                        id="oetTRBSplRefDocExt"
                                        name="oetTRBSplRefDocExt"
                                        maxlength="20"
                                        value="<?php echo $tTRBRefExtDoc;?>"
                                        placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelRefDocExt');?>"
                                    >
                                </div>

                                <!-- Ref Doc Ext Datepicker -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelRefDocExtDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xControlForm xCNDatePicker xCNInputMaskDate"
                                            id="oetTRBRefDocExtDate"
                                            name="oetTRBRefDocExtDate"
                                            value="<?php echo $dTRBRefExtDocDate;?>"
                                            placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPHDRefTSCode');?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtTRBRefDocExtDate" name="obtTRBRefDocExtDate" type="button" class="btn xCNDatePicker xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
      
                            </div>
                        </div>
                    </div>
                </div>
            </div>

               <!-- Panel ไปยังสาขา -->
               <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvTRBConditionDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabeAcpBchTo'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvTRBDataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTRBDataConditionDoc" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    
                            <div class="form-group m-b-0">
                    
                           
                                <!--Agn Browse-->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?></label>
                                    <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetTRBAgnCodeTo" name="oetTRBAgnCodeTo" maxlength="5" value="<?=$tTRBAgnCodeTo?>">
                                        <input  type="text" 
                                                class="form-control xControlForm xWPointerEventNone" 
                                                id="oetTRBAgnNameTo" name="oetTRBAgnNameTo" 
                                                maxlength="100" 
                                                placeholder="<?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?>" 
                                                value="<?=$tTRBAgnNameTo?>" 
                                                readonly>
                                        <span class="input-group-btn">
                                            <button id="oimTRBBrowseAgnTo" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!--Agn Bch-->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelFrmBranch')?></label>
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control xControlForm xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                                                id="oetTRBFrmBchCodeTo"
                                                name="oetTRBFrmBchCodeTo"
                                                maxlength="5"
                                                value="<?=$tTRBBchCodeTo?>"
                                               
                                            >
                                            <input
                                                type="text"
                                                class="form-control xControlForm xWPointerEventNone"
                                                id="oetTRBFrmBchNameTo"
                                                name="oetTRBFrmBchNameTo"
                                                maxlength="100"
                                                placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelFrmBranch')?>"
                                                data-validate-required="<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsEnterBch'); ?>"
                                                value="<?=$tTRBBchNameTo?>"
                                                readonly
                                            >
                                            <span class="input-group-btn xWConditionSearchPdt">
                                                <button id="obtTRBBrowseBCHTo" type="button" class="btn xCNBtnBrowseAddOn ">
                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                      
                                <!-- Condition คลังสินค้า -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelFrmWah');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xControlForm xCNHide" id="oetTRBFrmWahCodeTo" name="oetTRBFrmWahCodeTo" maxlength="5" value="<?=$tTRBWahCodeTo?>">
                                        <input
                                            type="text"
                                            class="form-control xControlForm xWPointerEventNone"
                                            id="oetTRBFrmWahNameTo"
                                            name="oetTRBFrmWahNameTo"
                                            value="<?=$tTRBWahNameTo?>"
                                            data-validate-required="<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsEnterWah'); ?>"
                                            placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelFrmWah');?>"
                                            readonly
                                        >
                                        <span class="xWConditionSearchPdt input-group-btn">
                                            <button id="obtTRBBrowseWahouseTo" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
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


            
               <!-- Panel สาขาปลายทาง -->
               <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvTRBConditionDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabeAcpBchShip'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvTRBDataConditionDocShip" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTRBDataConditionDocShip" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    
                            <div class="form-group m-b-0">
                            
                             
                                <!--Agn Browse-->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?></label>
                                    <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetTRBAgnCodeShip" name="oetTRBAgnCodeShip" maxlength="5" value="<?=$tTRBAgnCodeShip?>">
                                        <input  type="text" 
                                                class="form-control xControlForm xWPointerEventNone" 
                                                id="oetTRBAgnNameShip" name="oetTRBAgnNameShip" 
                                                maxlength="100" 
                                                placeholder="<?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?>" 
                                                value="<?=$tTRBAgnNameShip?>" 
                                                readonly>
                                        <span class="input-group-btn">
                                            <button id="oimTRBBrowseAgnShip" type="button" class="btn xCNBtnBrowseAddOn ">
                                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!--Agn Bch-->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelFrmBranch')?></label>
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control xControlForm xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                                                id="oetTRBFrmBchCodeShip"
                                                name="oetTRBFrmBchCodeShip"
                                                maxlength="5"
                                                value="<?=$tTRBBchCodeShip?>"
                                            >
                                            <input
                                                type="text"
                                                class="form-control xControlForm xWPointerEventNone"
                                                id="oetTRBFrmBchNameShip"
                                                name="oetTRBFrmBchNameShip"
                                                maxlength="100"
                                                placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBLabelFrmBranch')?>"
                                                data-validate-required="<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsEnterBch'); ?>"
                                                value="<?=$tTRBBchNameShip?>"
                                                readonly
                                            >
                                            <span class="input-group-btn xWConditionSearchPdt">
                                                <button id="obtTRBBrowseBCHShip" type="button" class="btn xCNBtnBrowseAddOn ">
                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                      
                                <!-- Condition คลังสินค้า -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelFrmWah');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xControlForm xCNHide" id="oetTRBFrmWahCodeShip" name="oetTRBFrmWahCodeShip" maxlength="5" value="<?=$tTRBWahCodeShip?>">
                                        <input
                                            type="text"
                                            class="form-control xControlForm xWPointerEventNone"
                                            id="oetTRBFrmWahNameShip"
                                            name="oetTRBFrmWahNameShip"
                                            value="<?=$tTRBWahNameShip?>"
                                            data-validate-required="<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsEnterWah'); ?>"
                                            placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBLabelFrmWah');?>"
                                            readonly
                                        >
                                        <span class="xWConditionSearchPdt input-group-btn">
                                            <button id="obtTRBBrowseWahouseShip" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
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
                <div id="odvTRBInfoOther" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/transferrequestbranch/transferrequestbranch','อื่นๆ');?></label>
                    <a class="xCNMenuplus " role="button" data-toggle="collapse"  href="#odvTRBDataInfoOther" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <?php
                    if($nTRBStaDocAct == '1' || $tTRBRoute == "docTRBEventAdd"){
                        $tCheckStatus = 'checked';
                    }else{
                        $tCheckStatus = '';
                    }
                ?>
                <div id="odvTRBDataInfoOther" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                                <!-- สถานะความเคลื่อนไหว -->
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" value="1" id="ocbTRBFrmInfoOthStaDocAct" name="ocbTRBFrmInfoOthStaDocAct" maxlength="1" <?php echo $tCheckStatus ?>>
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthStaDocAct'); ?></span>
                                    </label>
                                </div>
                                <!-- สถานะอ้างอิง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthRef');?></label>
                                    <select class="selectpicker xWTRBDisabledOnApv form-control xControlForm xWConditionSearchPdt" id="ocmTRBFrmInfoOthRef" name="ocmTRBFrmInfoOthRef" maxlength="1">
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
                                        class="form-control xControlForm text-right"
                                        id="ocmTRBFrmInfoOthDocPrint"
                                        name="ocmTRBFrmInfoOthDocPrint"
                                        value="<?php echo $tTRBFrmDocPrint;?>"
                                        readonly
                                    >
                                </div>
                                <!-- กรณีเพิ่มสินค้ารายการเดิม -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthReAddPdt');?></label>
                                    <select class="form-control xControlForm selectpicker xWTRBDisabledOnApv xWConditionSearchPdt" id="ocmTRBFrmInfoOthReAddPdt" name="ocmTRBFrmInfoOthReAddPdt">
                                        <option value="1" selected><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthReAddPdt1');?></option>
                                        <option value="2"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthReAddPdt2');?></option>
                                    </select>
                                </div>
                            <!-- เหตุผล -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubReason'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="input100 xCNHide" id="oetTRBReasonCode" name="oetTRBReasonCode" value="<?=$tTRBRsnCode?>">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetTRBReasonName" name="oetTRBReasonName" value="<?=$tTRBRsnName?>" readonly data-validate-required="<?php echo language('document/adjuststocksub/adjuststocksub', 'tASTPlsEnterRsnCode'); ?>">
                                        <span class="input-group-btn xWConditionSearchPdt">
                                            <button id="obtTRBBrowseReason" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                                <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- เหตุผล -->

                                <!-- หมายเหตุ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmInfoOthRemark');?></label>
                                    <textarea
                                        class="form-control"
                                        id="otaTRBFrmInfoOthRmk"
                                        name="otaTRBFrmInfoOthRmk"
                                        rows="10"
                                        maxlength="200"
                                        style="resize: none;height:86px;"
                                    ><?php echo $tTRBFrmRmk?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel ไฟลแนบ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvSOReferenceDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/saleorder/saleorder', 'ไฟล์แนบ'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvSODataFile" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvSODataFile" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="odvTRBShowDataTable">


                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    let oSOCallDataTableFile = {
                        ptElementID: 'odvTRBShowDataTable',
                        ptBchCode: $('#oetTRBFrmBchCode').val(),
                        ptDocNo: $('#oetTRBDocNo').val(),
                        ptDocKey: 'TCNTPdtReqBchHD',
                        ptSessionID: '<?= $this->session->userdata("tSesSessionID") ?>',
                        pnEvent: <?= $nStaUploadFile ?>,
                        ptCallBackFunct: 'JSxSoCallBackUploadFile'
                    }
                    JCNxUPFCallDataTable(oSOCallDataTableFile);
                </script>
            </div>
        </div>

        <div class="col-sm-9 col-md-9 col-lg-9">
            <div class="row">
                <!-- ตารางรายการสินค้า -->
                <div id="odvTRBDataPanelDetailPDT" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                            <ul class="nav" role="tablist">
                                                <!-- สินค้า -->
                                                <li class="xWMenu active xCNStaHideShow" style="cursor:pointer;">
                                                    <a role="tab" data-toggle="tab" data-target="#odvTRBContentProduct" aria-expanded="true"><?= language('document/document/document', 'ข้อมูลสินค้า') ?></a>
                                                </li>
                                                <!-- อ้างอิง -->
                                                <li class="xWMenu xWSubTab xCNStaHideShow" style="cursor:pointer;">
                                                    <a role="tab" data-toggle="tab" data-target="#odvTRBContentHDDocRef" aria-expanded="false"><?= language('document/document/document', 'เอกสารอ้างอิง') ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content">
                        
                                    <!-- แท็บสินค้า -->
                                    <div id="odvTRBContentProduct" class="tab-pane fade active in" style="padding: 0px !important;">
                                        <!-- Search PDT -->
                                        <div class="row p-t-15">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchPdtHTML" name="oetSearchPdtHTML" onkeyup="JSvTRBCSearchPdtHTML()" placeholder="<?=language('common/main/main','tPlaceholder');?>">
                                                        <span class="input-group-btn">
                                                            <button id="oimMngPdtIconSearch" class="btn xCNBtnSearch" type="button" onclick="JSvTRBCSearchPdtHTML()">
                                                                <img class="xCNIconBrowse" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
                                                <div class="row">
                                                    <!--ตัวเลือก-->
                                                    <div id="odvTRBMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
                                                        <button type="button" class="btn xCNBTNMngTable xWConditionSearchPdt" data-toggle="dropdown">
                                                            <?php echo language('common/main/main','tCMNOption')?>
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li id="oliTRBBtnDeleteMulti">
                                                                <a data-toggle="modal" data-target="#odvTRBModalDelPdtInDTTempMultiple"><?php echo language('common/main/main','tDelAll')?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <!--ค้นหาจากบาร์โค๊ด-->
                                                <div class="form-group" style="width: 85%;">
                                                    <input type="text" class="form-control xControlForm" id="oetTRBInsertBarcode" autocomplete="off" name="oetTRBInsertBarcode" maxlength="50" value="" onkeypress="Javascript:if(event.keyCode==13) JSxSearchFromBarcode(event,this);"  placeholder="เพิ่มสินค้าด้วยบาร์โค้ด หรือ รหัสสินค้า" >
                                                </div>

                                                <!--เพิ่มสินค้าแบบปกติ-->
                                                <div class="form-group">
                                                    <div style="position: absolute;right: 15px;top:-5px;">
                                                        <button type="button" id="obtTRBDocBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt xCNHideWhenCancelOrApprove">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Search PDT -->

                                        <!-- DataTable PDT DT -->
                                        <div class="row p-t-10" id="odvTRBDataPdtTableDTTemp"></div>
                                        <!-- DataTable PDT DT -->

                                        <!-- แท็บจำนวนขอโอนรวมทั้งสิ้น -->
                                        <div class="odvRowDataEndOfBill" id="odvRowDataEndOfBill">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <label class="pull-left mark-font"><?=language('document/purchaseorder/purchaseorder','จำนวนขอโอนรวมทั้งสิ้น');?></label>
                                                    <label class="pull-right mark-font"><span class="mark-font xShowQtyFooter">0</span> <?=language('document/document/document','tDocItemsList');?></label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- แท็บจำนวนขอโอนรวมทั้งสิ้น -->
                                    </div>
                                    <!-- แท็บสินค้า -->

                                    <!-- แท็บอ้างอิงเอกสาร -->
                                    <div id="odvTRBContentHDDocRef" class="tab-pane fade" style="padding: 0px !important;">
                                        <div class="row p-t-15">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                                <div style="margin-top:-2px;">
                                                    <button type="button" id="obtTRBAddDocRef" class="xCNBTNPrimeryPlus xCNDocBrowsePdt xCNHideWhenCancelOrApprove">+</button>
                                                </div>
                                            </div>
                                            <div id="odvTRBTableHDRef"></div>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- แท็บอ้างอิงเอกสาร -->
                                
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- ตารางรายการสินค้า -->
            </div>
        </div>
    </div>
</form>

<!-- ======================================================================== View Modal Appove Document  ======================================================================== -->
    <div id="odvTRBModalAppoveDoc" class="modal fade">
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
                    <button onclick="JSxTRBApproveDocument(true)" type="button" class="btn xCNBTNPrimery">
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
    <div class="modal fade" id="odvTRBPopupCancel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBCancelDoc')?></label>
                </div>
                <div class="modal-body">
                    <p id="obpMsgApv"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBCancelDocWarnning')?></p>
                    <p><strong><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBCancelDocConfrim')?></strong></p>
                </div>
                <div class="modal-footer">
                    <button onclick="JSnTRBCancelDocument(true)" type="button" class="btn xCNBTNPrimery">
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
    <div class="modal fade" id="odvTRBOrderAdvTblColumns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <div class="modal-body" id="odvTRBModalBodyAdvTable">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
                    <button id="obtTRBSaveAdvTableColums" type="button" class="btn btn-primary"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- ============================================================== View Modal Delete Product In DT DocTemp Multiple  ============================================================ -->
    <div id="odvTRBModalDelPdtInDTTempMultiple" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main','tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                    <input type="hidden" id="ohdConfirmTRBDocNoDelete"   name="ohdConfirmTRBDocNoDelete">
                    <input type="hidden" id="ohdConfirmTRBSeqNoDelete"   name="ohdConfirmTRBSeqNoDelete">
                    <input type="hidden" id="ohdConfirmTRBPdtCodeDelete" name="ohdConfirmTRBPdtCodeDelete">
                    <input type="hidden" id="ohdConfirmTRBPunCodeDelete" name="ohdConfirmTRBPunCodeDelete">

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
    <div id="odvTRBModalPleseselectSPL" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tMessageAlert')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBSplNotFound')?></p>
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
    <div id="odvTRBModalPDTNotFound" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tMessageAlert')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPdtNotFound')?></p>
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
<div id="odvTRBModalPDTMoreOne" class="modal fade">
        <div class="modal-dialog" role="document" style="width: 85%; margin: 1.75rem auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBSelectPdt')?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JCNxConfirmPDTMoreOne(1)" data-dismiss="modal"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBChoose')?></button>
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" onclick="JCNxConfirmPDTMoreOne(2)" data-dismiss="modal"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBClose')?></button>
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
<div id="odvTRBModalChangeBCH" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tMessageAlert')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBBchNotFound')?></p>
                </div>
                <div class="modal-footer">
                    <button type="button"  data-dismiss="modal" id="obtChangeBCH" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm');?></button>
                    <button type="button"  data-dismiss="modal" class="btn xCNBTNDefult"><?php echo language('common/main/main', 'tModalCancel');?></button>
                </div>
            </div>
        </div>
    </div>
<!-- =========================================== อ้างอิงเอกสารภายใน ============================================= -->
<div id="odvTRBModalRefIntDoc" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 1200px;">
        <div class="modal-content">

            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/purchaseorder/purchaseorder','tPORefIntDocPrsTital')?></label>
            </div>

            <div class="modal-body">
                <div class="row" id="odvTRBFromRefIntDoc">
           
                </div>
            </div>

            <div class="modal-footer">
                <button id="obtConfirmRefDocInt" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>

        </div>
    </div>
</div>

<!-- =========================================== ไม่พบคลังสินค้า ============================================= -->
<div id="odvTRBModalWahNoFound" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBWahNotFound')?></label>
            </div>

            <div class="modal-body">
                <p><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBPlsSelectWah')?></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
                    <?=language('common/main/main', 'tCMNOK')?>
                </button>
            </div>

        </div>
    </div>
</div>
<!-- ============================================================================================================================================================================= -->


<script src="<?php echo base_url('application/modules/common/assets/src/jThaiBath.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jTransferRequestBranchAdd.php');?>
<?php //include("script/jTransferRequestBranchPdtAdvTableData.php");?>


<script>
    //บังคับให้เลือกลูกค้า
    function JSxFocusInputCustomer(){
        $('#oetTRBFrmCstName').focus();
    }

    //ค้นหาสินค้าใน temp
    function JSvTRBCSearchPdtHTML() {
        var value = $("#oetSearchPdtHTML").val().toLowerCase();
        $("#otbTRBDocPdtAdvTableList tbody tr ").filter(function () {
            tText = $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    }

    function JSxNotFoundClose() {
        $('#oetTRBInsertBarcode').focus();
    }

    //กดเลือกบาร์โค๊ด
    function JSxSearchFromBarcode(e,elem){
        var tValue = $(elem).val();
       
            JSxCheckPinMenuClose();
            if(tValue.length === 0){

            }else{
                // JCNxOpenLoading();
                $('#oetTRBInsertBarcode').attr('readonly',true);
                JCNSearchBarcodePdt(tValue);
                $('#oetTRBInsertBarcode').val('');
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
                // aPriceType      : ['Price4Cst',tDOPplCode],
                aPriceType: ["Cost","tCN_Cost","Company","1"],
                NextFunc        : "",
                SPL             : $("#oetTRBFrmSplCode").val(),
                BCH             : $("#oetTRBFrmBchCode").val(),
                tInpSesSessionID : $('#ohdSesSessionID').val(),
                tInpUsrCode      : $('#ohdTRBUsrCode').val(),
                tInpLangEdit     : $('#ohdTRBLangEdit').val(),
                tInpSesUsrLevel  : $('#ohdSesUsrLevel').val(),
                tInpSesUsrBchCom : $('#ohdSesUsrBchCom').val(),
                Where            : [tWhereCondition],
                tTextScan       : ptTextScan
            },
            cache   : false,
            timeout : 0,
            success : function(tResult){
                // $('#oetTRBInsertBarcode').attr('readonly',false);
                JCNxCloseLoading();
                var oText = JSON.parse(tResult);
                if(oText == '800'){
                    $('#oetTRBInsertBarcode').attr('readonly',false);
                    $('#odvTRBModalPDTNotFound').modal('show');
                    $('#oetTRBInsertBarcode').val('');
                }else{
                    if(oText.length > 1){

                        // พบสินค้ามีหลายบาร์โค้ด
                        $('#odvTRBModalPDTMoreOne').modal('show');
                        $('#odvTRBModalPDTMoreOne .xCNTablePDTMoreOne tbody').html('');
                        for(i=0; i<oText.length; i++){
                            var aNewReturn      = JSON.stringify(oText[i]);
                            var tTest = "["+aNewReturn+"]";
                            var oEncodePackData = window.btoa(unescape(encodeURIComponent(tTest)));
                            var tHTML = "<tr class='xCNColumnPDTMoreOne"+i+" xCNColumnPDTMoreOne' data-information='"+oEncodePackData+"' style='cursor: pointer;'>";
                                tHTML += "<td>"+oText[i].pnPdtCode+"</td>";
                                tHTML += "<td>"+oText[i].packData.PDTName+"</td>";
                                tHTML += "<td>"+oText[i].packData.PUNName+"</td>";
                                tHTML += "<td>"+oText[i].ptBarCode+"</td>";
                                tHTML += "</tr>";
                            $('#odvTRBModalPDTMoreOne .xCNTablePDTMoreOne tbody').append(tHTML);
                        }

                        //เลือกสินค้า
                        $('.xCNColumnPDTMoreOne').off();

                        //ดับเบิ้ลคลิก
                        $('.xCNColumnPDTMoreOne').on('dblclick',function(e){
                            $('#odvTRBModalPDTMoreOne').modal('hide');
                            var tJSON = decodeURIComponent(escape(window.atob($(this).attr('data-information'))));
                            FSvTRBAddPdtIntoDocDTTemp(tJSON); //Client
                            FSvTRBAddBarcodeIntoDocDTTemp(tJSON);
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
                                //     $(this).children().attr('style', 'background-color:#1866ae !important; color:#FFF !important');
                                // }

                            //เลือกสินค้าแบบตัวเดียว
                            $('.xCNColumnPDTMoreOne').removeClass('xCNActivePDT');
                            $('.xCNColumnPDTMoreOne').children().attr('style', 'background-color:transparent !important; color:#232C3D !important;');
                            $('.xCNColumnPDTMoreOne').children(':last-child').css('text-align','right');

                            $(this).addClass('xCNActivePDT');
                            $(this).children().attr('style', 'background-color:#1866ae !important; color:#FFF !important;');
                            $(this).children().last().css('text-align','right');
                        });
                    }else{
                        //มีตัวเดียว
                        var aNewReturn  = JSON.stringify(oText);
                        console.log('aNewReturn: '+aNewReturn);
                        // var aNewReturn  = '[{"pnPdtCode":"00009","ptBarCode":"ca2020010003","ptPunCode":"00001","packData":{"SHP":null,"BCH":null,"PDTCode":"00009","PDTName":"ขนม_03","PUNCode":"00001","Barcode":"ca2020010003","PUNName":"ขวด","PriceRet":"17.00","PriceWhs":"0.00","PriceNet":"0.00","IMAGE":"D:/xampp/htdocs/Moshi-Moshi/application/modules/product/assets/systemimg/product/00009/Img200128172902CEHHRSS.jpg","LOCSEQ":"","Remark":"ขนม_03","CookTime":0,"CookHeat":0}}]';
                        FSvTRBAddPdtIntoDocDTTemp(aNewReturn); //Client
                        // JCNxCloseLoading();
                        // $('#oetTRBInsertBarcode').attr('readonly',false);
                        // $('#oetTRBInsertBarcode').val('');
                        FSvTRBAddBarcodeIntoDocDTTemp(aNewReturn); //Server
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
            $("#odvTRBModalPDTMoreOne .xCNTablePDTMoreOne tbody .xCNActivePDT").each(function( index ) {
                var tJSON = decodeURIComponent(escape(window.atob($(this).attr('data-information'))));
                FSvTRBAddPdtIntoDocDTTemp(tJSON);
                FSvTRBAddBarcodeIntoDocDTTemp(tJSON);
            });
        }else{
            $('#oetTRBInsertBarcode').attr('readonly',false);
            $('#oetTRBInsertBarcode').val('');
        }
    }

    //หลังจากค้นหาเสร็จแล้ว
    function FSvTRBAddBarcodeIntoDocDTTemp(ptPdtData){
        var nStaSession = 1;
        if (typeof nStaSession !== "undefined" && nStaSession == 1){
            // JCNxOpenLoading();
            var ptXthDocNoSend  = "";
            if ($("#ohdTRBRoute").val() == "docTRBEventEdit") {
                ptXthDocNoSend  = $("#oetTRBDocNo").val();
            }
            var tTRBOptionAddPdt = $('#ocmTRBFrmInfoOthReAddPdt').val();
            var nKey            = parseInt($('#otbTRBDocPdtAdvTableList tr:last').attr('data-seqno'));

            $('#oetTRBInsertBarcode').attr('readonly',false);
            $('#oetTRBInsertBarcode').val('');

            $.ajax({
                type: "POST",
                url: "docTRBAddPdtIntoDTDocTemp",
                data: {
                    'tSelectBCH'        : $('#oetTRBFrmBchCode').val(),
                    'tTRBDocNo'          : ptXthDocNoSend,
                    'tTRBOptionAddPdt'   : tTRBOptionAddPdt,
                    'tTRBPdtData'        : ptPdtData,
                    'ohdSesSessionID'   : $('#ohdSesSessionID').val(),
                    'ohdTRBUsrCode'        : $('#ohdTRBUsrCode').val(),
                    'ohdTRBLangEdit'       : $('#ohdTRBLangEdit').val(),
                    'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
                    'ohdTRBSesUsrBchCode'  : $('#ohdTRBSesUsrBchCode').val(),
                    'tSeqNo'              : nKey,
                    'nVatRate'            : $('#ohdTRBFrmSplVatRate').val(),
                    'nVatCode'            : $('#ohdTRBFrmSplVatCode').val()
                },
                cache: false,
                timeout: 0,
                success: function (oResult){
                    // JSvTRBLoadPdtDataTableHtml();
                  var aResult =  JSON.parse(oResult);

                    if(aResult['nStaEvent']==1){
                        JCNxCloseLoading();
                        // $('#oetTRBInsertBarcode').attr('readonly',false);
                        // $('#oetTRBInsertBarcode').val('');
                        // if(tDOOptionAddPdt=='1'){
                        //     JSvTRBCallEndOfBill();
                        // }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    // FSvTRBAddBarcodeIntoDocDTTemp(ptPdtData);
                }
            });
        }else{
            JCNxthowMsgSessionExpired();
        }
    }
</script>
