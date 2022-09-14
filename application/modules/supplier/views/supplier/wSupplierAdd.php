<?php
    date_default_timezone_set("Asia/Bangkok");
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute             = "supplierEventEdit";
        @$aSplAddress       = $aSplDataAddress['raItems'];
        $tSplCode           = $aSplData['raItems']['rtSplCode'];
        $tSplName           = $aSplData['raItems']['rtSplName'];
        $tSplTel            = $aSplData['raItems']['rtSplTel'];
        $tSplEmail          = $aSplData['raItems']['rtSplEmail'];
        $tSplFax            = $aSplData['raItems']['rtSplFax'];
        $tSplSex            = $aSplData['raItems']['rtSplSex'];
        $tSplDob            = (!empty($aSplData['raItems']['rtSplDob']))? date("Y-m-d", strtotime($aSplData['raItems']['rtSplDob'])) : null;//
        $tSgpCode           = $aSplData['raItems']['rtSgpCode'];
        $tSgpName           = $aSplData['raItems']['rtSgpName'];
        $tStyCode           = $aSplData['raItems']['rtStyCode'];
        $tStyName           = $aSplData['raItems']['rtStyName'];
        $tSlvCode           = $aSplData['raItems']['rtSlvCode'];
        $tSlvName           = $aSplData['raItems']['rtSlvName'];
        $tVatCode           = $aSplData['raItems']['rtVatCode'];
        $tSplStaVATInOrEx   = $aSplData['raItems']['rtSplStaVATInOrEx'];
        $tSplDiscBillRet    = $aSplData['raItems']['rtSplDiscBillRet'];
        $tSplDiscBillWhs    = $aSplData['raItems']['rtSplDiscBillWhs'];
        $tSplDiscBillNet    = $aSplData['raItems']['rtSplDiscBillNet'];
        $tSplBusiness       = $aSplData['raItems']['rtSplBusiness'];
        $tSplStaBchOrHQ     = $aSplData['raItems']['rtSplStaBchOrHQ'];
        $tSplBchCode        = $aSplData['raItems']['rtSplBchCode'];
        $tSplStaActive      = $aSplData['raItems']['rtSplStaActive'];
        $tUsrCode           = $aSplData['raItems']['rtUsrCode'];
        $tSplCrTerm         = $aSplData['raItems']['rtSplCrTerm'];
        $tSplCrLimit        = number_format($aSplData['raItems']['rtSplCrLimit'],$nOptDecimalShow);
        $tSplDayCta         = $aSplData['raItems']['rtSplDayCta'];
        $tSplLastCta        = (!empty($aSplData['raItems']['rtSplLastCta']))? date("Y-m-d", strtotime($aSplData['raItems']['rtSplLastCta'])) : null;//
        $tSplLastPay        = (!empty($aSplData['raItems']['rtSplLastPay']))? date("Y-m-d", strtotime($aSplData['raItems']['rtSplLastPay'])) : null;//
        $tSplLimitRow       = $aSplData['raItems']['rtSplLimitRow'];
        $tSplLeadTime       = $aSplData['raItems']['rtSplLeadTime'];
        $tSplTspPaid        = $aSplData['raItems']['rtSplTspPaid'];
        $tViaCode           = $aSplData['raItems']['rtViaCode'];
        $tViaName           = $aSplData['raItems']['rtViaName'];
        $tSplApply          = $aSplData['raItems']['rtSplApply'];
        $tSplRefExCrdNo     = $aSplData['raItems']['rtSplRefExCrdNo'];
        $tSplCrdIssue       = (!empty($aSplData['raItems']['rtSplCrdIssue']))? date("Y-m-d", strtotime($aSplData['raItems']['rtSplCrdIssue'])) : null;//
        $tSplCrdExpire      = (!empty($aSplData['raItems']['rtSplCrdExpire']))? date("Y-m-d", strtotime($aSplData['raItems']['rtSplCrdExpire'])) : null;//
        $tSplPayRmk         = $aSplData['raItems']['rtSplPayRmk'];
        $tSplBillRmk        = $aSplData['raItems']['rtSplBillRmk'];
        $tSplViaRmk         = $aSplData['raItems']['rtSplViaRmk'];
        $tSplRmk            = $aSplData['raItems']['rtSplRmk'];
        $tAgnCode           = $aSplData['raItems']['FTAgnCode']; 
        $tAgnName           = $aSplData['raItems']['FTAgnName'];
    }else{
        $tRoute             = "supplierEventAdd";
        $tSplCode           = '';
        $tSplName           = '';
        $tSplTel            = '';
        $tSplEmail          = '';
        $tSplFax            = '';
        $tSplSex            = '';
        $tSplDob            = date('Y-m-d');
        $tSgpCode           = '';
        $tSgpName           = '';
        $tStyCode           = '';
        $tStyName           = '';
        $tSlvCode           = '';
        $tSlvName           = '';
        $tVatCode           = '';
        $tSplStaVATInOrEx   = '';
        $tSplDiscBillRet    = '';
        $tSplDiscBillWhs    = '';
        $tSplDiscBillNet    = '';
        $tSplBusiness       = '';
        $tSplStaBchOrHQ     = '';
        $tSplBchCode        = '';
        $tSplStaActive      = '';
        $tUsrCode           = '';
        $tSplCrTerm         = '';
        $tSplCrLimit        = number_format(0,$nOptDecimalShow);
        $tSplDayCta         = '';
        $tSplLastCta        = '';
        $tSplLastPay        = '';
        $tSplLimitRow       = '';
        $tSplLeadTime       = '';
        $tViaCode           = '';
        $tViaName           = '';
        $tSplTspPaid        = '';
        $tSplApply          = '';
        $tSplRefExCrdNo     = '';
        $tSplCrdIssue       = '';
        $tSplCrdExpire      = '';
        $tSplPayRmk         = '';
        $tSplBillRmk        = '';
        $tSplViaRmk         = '';
        $tSplRmk            = '';
        $tAgnCode           = $this->session->userdata("tSesUsrAgnCode");
        $tAgnName           = $this->session->userdata("tSesUsrAgnName");
    }

    if($nStaAddOrEdit == 99){
        $tDisabledTab = 'false';
    }else{
        $tDisabledTab = 'tab';
    }
?>
<style>
    #odvPanelSplValue{
        background-color: #f0f4f7;
        height: 120px;
    }
    #odvPanelSplValue > .panel-heading > hr{
        margin-top: 0px;
        margin-bottom: 0px;
        border: 0;
        border-top: 1px solid #CCC;
        margin-right: -20px;
    }
    #odvPanelSplValue > .panel-body > label {
        font-size: 30px !important;
        font-weight: bold !important;
    }

    .xWsupplierActive {
        color: #007b00 !important;
        font-weight: bold;
        margin: 0;
    }
    .xWsupplierInActive {
        color: #7b7f7b !important;
        font-weight: bold;
        margin: 0;
    }
    .xWsupplierCancle {
        color: #f60a0a !important;
        font-weight: bold;
        margin: 0;
    }
    .xWSTopPaddingTapManage{
        padding-top: 0px;

    }
    .xWActionSubMenu {
        margin-top: 10px;
    }
    .xWActionSubMenu button:last-child {
        margin-right: 5px;
    }
</style>
    <input type="hidden" name="ohdSupcode" id="ohdSupcode" value="<?php echo $tSplCode; ?>"/>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddsupplier3">
                    <?php echo FCNtHGetContentUploadImage(@$tImgObjAll, 'Supplier');?>
                </form>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <div class="row">
                    <div class=">col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="custom-tabs-line tabs-line-bottom left-aligned">
                            <div class="row">
                                <ul class="nav" role="tablist">
                                    <li id="" class="active" onclick="JSxSelectTabSpl('Info1')">
                                        <a class="xCNMenuTab" role="tab" data-toggle="tab" data-menutype="Info"  data-target="#odvInfo1" aria-expanded="true"><?php echo language('supplier/supplier/supplier','tInfo1')?></a>
                                    </li>
                                    <li id="" class="xWDisTab" onclick="JSxSelectTabSpl('Info2')">
                                        <a class="xCNMenuTab" role="tab" data-toggle="<?=$tDisabledTab;?>" data-menutype="Info2"  data-target="#odvInfo2" aria-expanded="false"><?php echo language('supplier/supplier/supplier','tInfo2')?></a>
                                    </li>
                                    <li id="" class="xWDisTab" onclick="JSxSelectTabSpl('Contact')">
                                        <a class="xCNMenuTab" role="tab" data-toggle="<?=$tDisabledTab;?>" data-menutype="InfoContact"  data-target="#odvContact" aria-expanded="false"><?php echo language('supplier/supplier/supplier','tContact')?></a>
                                    </li>
                                    <li id="" class="xWDisTab" onclick="JSxSelectTabSpl('Address')">
                                        <a class="xCNMenuTab" role="tab" data-toggle="<?=$tDisabledTab;?>" data-menutype="InfoAddr"  data-target="#odvAddress" aria-expanded="false"><?php echo language('supplier/supplier/supplier','tAddress')?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>   
                <div class="row">
                    <div class="tab-content">
                    <!-- tab 1 ข้อมูลทั่วไป 1 -->
                    <div id="odvInfo1" class="tab-pane fade active in">
                        
                        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddsupplier1">
                            <!-- <input type="text" class="xCNHide" id="oetImgInputSupplier"     name="oetImgInputSupplier"      value="<?php echo @$tImgName;?>">
                            <input type="text" class="xCNHide" id="oetImgInputSupplierOld"  name="oetImgInputSupplierOld"   value="<?php echo @$tImgName;?>">
                            <input type="hidden" id="oetImgInputsupplier" name="oetImgInputsupplier"> -->
                                <button style="display:none" type="submit" id="obtSubmitsupplier" onclick="JSoAddEditSupplier('<?php echo $tRoute?>')"></button>
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                    <!-- <div id="odvSplCodeForm" class="form-group"> -->
                                        <div  class="form-group">
                                            <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('supplier/supplier/supplier','tCode')?></label>
                                            <div class="">
                                            <div id="odvSupplierAutoGenCode" class="form-group">
                                                <label class="fancy-checkbox">
                                                    <input type="hidden" id="ohdCheckDuplicateSpl" name="ohdCheckDuplicateSpl" value="1">  
                                                    <input type="checkbox" id="ocbSplAutoGenCode" name="ocbSplAutoGenCode" checked="true" value="1">
                                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                                </label>
                                            </div>
                                                <input type="text"
                                                class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                                                placeholder="<?php echo  language('supplier/supplier/supplier','tCode');?>" 
                                                maxlength="20" id="oetSplCode" name="oetSplCode" 
                                                data-is-created="<?php echo $tSplCode;?>"
                                                value="<?php echo $tSplCode; ?>"
                                                data-validate-required="<?php echo  language('supplier/supplier/supplier','tValidSplCode');?>"
                                                data-validate-dublicateCode = "<?php echo  language('supplier/supplier/supplier','tValidDublicate');?>">
                                                <span class="input-group-btn">
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('supplier/supplier/supplier','tName')?></label>
                                            <input type="text" class="form-control" maxlength="100" id="oetSplName" 
                                            placeholder="<?php echo language('supplier/supplier/supplier','tName')?>"
                                            autocomplete="off"
                                            name="oetSplName" value="<?php echo $tSplName; ?>"  data-validate-required="<?php echo  language('supplier/supplier/supplier','tValidName');?>">
                                        </div>
                                    </div>
                                </div>
  
                                <div class="row <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?=language('supplier/supplier/supplier','tAGNName')?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetSplAgnCode" name="oetSplAgnCode" value="<?=$tAgnCode;?>">
                                                <input type="text" class="form-control xWPointerEventNone" id="oetSplAgnName" name="oetSplAgnName" placeholder="<?=language('supplier/supplier/supplier','tAGNName')?>" value="<?=$tAgnName;?>" readonly>
                                                <span class="input-group-btn">
                                                    <script>    
                                                        //ถ้าเป็น BCH + SHP จะไม่สามารถเลือกได้
                                                        var tStaUsrLevel = '<?=$this->session->userdata("tSesUsrLevel");?>';
                                                        if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
                                                            $('#obtSplBrowseAgency').attr("disabled", true);
                                                        }
                                                    </script>
                                                    <button id="obtSplBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img src="<?= base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tBirthday')?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center" maxlength="10" id="oetSplDob" name="oetSplDob" autocomplete="off" value="<?php echo $tSplDob;?>" data-validate="<?php echo  language('supplier/supplier/supplier','tSplDob');?>">
                                                <span class="input-group-btn">
                                                    <button id="obtSplDob" type="button" class="btn xCNBtnDateTime">
                                                        <img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <label class="fancy-radio xCNRadioMain">
                                                        <input type="radio" id="ocbSplSexMen" name="ordSplSex" value="1" <?php echo ($tSplSex == 1 || empty($tSplSex) || $nStaAddOrEdit == 99) ? 'checked':'';?>>
                                                        <span><i></i> <?php echo language('supplier/supplier/supplier','tMen')?></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <label class="fancy-radio xCNRadioMain">
                                                        <input type="radio" id="ocbSplSexWomen" name="ordSplSex" value="2" <?php echo ($tSplSex == 2) ? 'checked':'';?>>
                                                        <span><i></i> <?php echo language('supplier/supplier/supplier','tWomen')?></span>
                                                    </label>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm active"><?php echo language('supplier/supplier/supplier','tTel')?></label>
                                            <input type="text" class="form-control xCNInputNumericWithoutDecimal" id="oetSplTel" maxlength="15" 
                                            placeholder="<?php echo language('supplier/supplier/supplier','tTel')?>"
                                            autocomplete="off"
                                            name="oetSplTel" value="<?php echo $tSplTel; ?>" data-validate="<?php echo language('supplier/supplier/supplier','tTel')?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm active"><?php echo language('supplier/supplier/supplier','tFax')?></label>
                                            <input type="text" class="form-control xCNInputNumericWithoutDecimal" id="oetSplFax" maxlength="15" 
                                            placeholder="<?php echo language('supplier/supplier/supplier','tFax')?>"
                                            autocomplete="off"
                                            name="oetSplFax" value="<?php echo $tSplFax; ?>" data-validate="<?php echo language('supplier/supplier/supplier','tFax')?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tEmail')?></label>
                                            <input type="email" class="form-control " maxlength="50" id="oemtSplEmail" value="<?php echo $tSplEmail;?>" name="oemtSplEmail" data-validate-email="<?php echo language('supplier/supplier/supplier','tValidEmail')?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tDiscBillRet')?></label>
                                                    <input type="text" class="form-control text-right xCNInputNumericWithoutDecimal" maxlength="3" id="oenSplDiscBillRet" 
                                                    name="oenSplDiscBillRet" value="<?php echo $tSplDiscBillRet;?>" 
                                                    placeholder="0.00"
                                                    max="100" min="1" data-validate="<?php echo language('supplier/supplier/supplier','tDiscBillRet')?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tSplDiscBillWhs')?></label>
                                                    <input type="text" class="form-control text-right xCNInputNumericWithoutDecimal" maxlength="3" id="oenSplDiscBillWhs" name="oenSplDiscBillWhs" 
                                                    placeholder="0.00"
                                                    value="<?php echo $tSplDiscBillWhs;?>" max="100" min="1" data-validate="<?php echo language('supplier/supplier/supplier','tSplDiscBillWhs')?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tSplDiscBillNet')?></label>
                                                    <input type="text" class="form-control text-right xCNInputNumericWithoutDecimal" maxlength="3" id="oenSplDiscBillNet" name="oenSplDiscBillNet" 
                                                    placeholder="0.00"
                                                    value="<?php echo $tSplDiscBillNet;?>" max="100" min="1" data-validate="<?php echo language('supplier/supplier/supplier','tSplDiscBillNet')?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <label class="fancy-radio xCNRadioMain">
                                                        <input type="radio" id="ordSplBusinessPerson" name="ordSplBusiness" value="1" <?php echo ($tSplBusiness == 1 || $nStaAddOrEdit == 99)? 'checked':'';?>>
                                                        <span><i></i> <?php echo language('supplier/supplier/supplier','tPerson')?></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <label class="fancy-radio xCNRadioMain">
                                                        <input type="radio" id="ordSplBusinessCorporate" name="ordSplBusiness" value="2" <?php echo ($tSplBusiness == 2)? 'checked':'';?>>
                                                        <span><i></i> <?php echo language('supplier/supplier/supplier','tCorporate')?></span>
                                                    </label>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm">&nbsp;</label>
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbSplStaBchOrHQ" name="ocbSplStaBchOrHQ" value="1" <?php echo $tSplStaBchOrHQ == 1 ? 'checked' : '';?>>
                                                <span> <?php echo language('supplier/supplier/supplier','tHeadquarters')?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tBranch')?></label>
                                            <input type="text" class="form-control supplierEventEdit " maxlength="20" id="oetSplBchCode" name="oetSplBchCode" 
                                            placeholder="<?php echo language('supplier/supplier/supplier','tBranch')?>"
                                            autocomplete="off"
                                            value="<?php echo $tSplBchCode; ?>"  data-validate="<?php echo  language('supplier/supplier/supplier','tBranch');?>">
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <label class="fancy-radio xCNRadioMain">
                                                    <input type="radio" id="ordSplStaVATInOrExInclusive" name="ordSplStaVATInOrEx" value="1" <?php echo ($tSplStaVATInOrEx == 1 || empty($tSplStaVATInOrEx) || $nStaAddOrEdit == 99)? 'checked':'';?>>
                                                    <span><i></i> <?php echo language('supplier/supplier/supplier','tInclusive')?></span>
                                                </label>
                                            </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <label class="fancy-radio xCNRadioMain">
                                                        <input type="radio" id="ordSplStaVATInOrExExclusive" name="ordSplStaVATInOrEx" value="2" <?php echo ($tSplStaVATInOrEx == 2)? 'checked':'';?>>
                                                        <span><i></i> <?php echo language('supplier/supplier/supplier','tExclusive')?></span>
                                                    </label>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tVat')?></label>
                                        <select class="selectpicker form-control xCNSelectBox" id="ocmVatRate" name="ocmVatRate" data-live-search="true">
                                            <?php for($i=0; $i<FCNnHSizeOf($aVatRate['FTVatCode']); $i++){ ?>
                                                <?php $Selected = ($aVatRate['FTVatCode'][$i] == $tVatCode)? 'Selected':''?>
                                                <option value="<?php echo $aVatRate['FTVatCode'][$i]?>" <?php echo $Selected?>>
                                                    <?php echo number_format($aVatRate['FCVatRate'][$i],2)?> % 
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm">&nbsp;</label>
                                            <?php
                                                if(isset($tRoute) && $tRoute == "supplierEventEdit"){
                                                    if(isset($tSplStaActive ) && $tSplStaActive == 1){
                                                        $tSplDisableStaActive   = ' checked';
                                                    }else{
                                                        $tSplDisableStaActive   = '';
                                                    }
                                                }else{
                                                    $tSplDisableStaActive   = 'checked';
                                                }
                                            ?>
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbSplStaActive" name="ocbSplStaActive"<?php echo @$tSplDisableStaActive;?>>
                                                <span>&nbsp;<?php echo language('supplier/supplier/supplier','tStaContact')?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tResponsible')?></label>
                                            <input type="text" class="form-control" maxlength="20" id="oetUsrCode" name="oetUsrCode"
                                            placeholder="<?php echo language('supplier/supplier/supplier','tResponsible')?>"
                                            autocomplete="off"
                                            value="<?php echo $tUsrCode; ?>"  data-validate="<?php echo  language('supplier/supplier/supplier','tResponsible');?>">
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('company/smartlockerSize/smartlockerSize','tSMSSizeRemark'); ?></label>
                                            <textarea class="form-group" rows="4" maxlength="100" id="oetSplRmk" name="oetSplRmk" autocomplete="off"><?php echo $tSplRmk; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end tab 1  -->

                    <!-- tab 2 ข้อมูลทั่วไป 2 -->
                    <div id="odvInfo2" class="tab-pane" role="tabpanel">
                        
                        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddsupplier2">
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tSplGroup')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetSgpCode" name="oetSgpCode" value="<?php echo $tSgpCode;?>">
                                            <input type="text" class="form-control" id="oetSgpName" name="oetSgpName" value="<?php echo $tSgpName;?>" data-validate="<?php echo language('supplier/supplier/supplier','tSplGroup')?>" required="" readonly="">
                                            <span class="input-group-btn">
                                                <button id="obtBrowseSgp" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img class="xCNIconFind">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tSplType')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetStyCode" name="oetStyCode" value="<?php echo $tStyCode;?>">
                                            <input type="text" class="form-control" id="oetStyName" name="oetStyName" value="<?php echo $tStyName;?>" data-validate="<?php echo language('supplier/supplier/supplier','tSplType')?>" readonly="">
                                            <span class="input-group-btn">
                                                <button id="obtBrowseSty" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img class="xCNIconFind">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tSplLevel')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetSlvCode" name="oetSlvCode" value="<?php echo $tSlvCode;?>">
                                            <input type="text" class="form-control" id="oetSlvName" name="oetSlvName" value="<?php echo $tSlvName;?>" data-validate="<?php echo language('supplier/supplier/supplier','tSplLevel')?>"readonly="">
                                            <span class="input-group-btn">
                                                <button id="obtBrowseSlv" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img class="xCNIconFind">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-12 ">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm active"><?php echo language('supplier/supplier/supplier','tTermCredit')?></label>
                                        <input type="text" class="form-control xCNInputNumericWithoutDecimal" id="oetDateCredit" maxlength="15" name="oetDateCredit" value="<?php echo $tSplCrTerm; ?>"  style="text-align:right">
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-12">
                                        <br>
                                        <label class="xCNLabelFrm" style="float:left"><?php echo language('supplier/supplier/supplier','tCreditDate')?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm active"><?php echo language('supplier/supplier/supplier','tCreditLimit')?></label>
                                        <input type="text" class="form-control xCNInputNumericWithDecimal text-right" id="oetCredit" name="oetCredit" value="<?php echo $tSplCrLimit; ?>">
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                    <!-- end tab 2 -->

                    <!-- tab 3 ที่อยู่-->
                    <?php  if($tRoute == "supplierEventEdit"){ ?>
                    <div id="odvAddress" class="tab-pane" role="tabpanel">
                 
                        <label id="olaTitleAddress" class="xCNLabelFrm xCNLinkClick" onclick="JSxAddressDatatable($('#ohdSupcode').val())"><?php echo language('supplier/supplier/supplier','tTitleSplAdd')?></label>
                        <label style="display:none;" id="olaTitleAdd" class="xCNLabelFrm"><?php echo ' / '.language('supplier/supplier/supplier','tTitleSplAddAddress')?></label>
                        <label style="display:none;" id="olaTitleEdit" class="xCNLabelFrm"><?php echo ' / '.language('supplier/supplier/supplier','tTitleSplEditAddress')?></label>
                        <button id ="obtAddAddress" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageSupplierCallpageAddAddress()">+</button>
                        <div id="odvContentAddress">
                                
                        </div>
                        <script> 
                            $(document).ready(function(){
                              
                                    var tSplCode = $('#ohdSupcode').val();
                                    JSxAddressDatatable(tSplCode);
                              
                            });
                            //step 1 autoload JS
                            //step 2 jS ajax 
                            //step 3 ajax load table first
                            //step 4 เอามา เปะ odvContentAddress
                        </script>
                    </div>
                    <!-- end tab 3 -->

                    <!-- tab 4 ข้อมูลผู้ติดต่อ-->
                    <div id="odvContact" class="tab-pane" role="tabpanel">

                        <label id="olaTitleContr" class="xCNLabelFrm xCNLinkClick" onclick="JSxContactDatatable($('#ohdSupcode').val())"><?php echo language('supplier/supplier/supplier','tTitleSplContr')?></label>
                            <label style="display:none;" id="olaTitleAddContr" class="xCNLabelFrm"><?php echo ' / '.language('supplier/supplier/supplier','tTitleSplAddContr')?></label>
                            <label style="display:none;" id="olaTitleEditContr" class="xCNLabelFrm"><?php echo ' / '.language('supplier/supplier/supplier','tTitleSplEditContr')?></label>
                            <button id ="obtAddContr" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageAddContact()">+</button>    
                                <div id="odvContentContact">

                                </div>
                                <script>
                                $(document).ready(function(){
                                  
                                    var tSplCode = $('#ohdSupcode').val();
                                    JSxContactDatatable(tSplCode);
                                });
                      
                                //step 1 autoload JS
                                //step 2 jS ajax 
                                //step 3 ajax load table first
                                //step 4 เอามา เปะ odvContentAddress
                            </script>
                    </div>
                    <?php } ?>
                    <!-- end tab 4 -->


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>   


<script type="text/javascript">

	$('.xWBtnHide').show();
	$('.xCNMenuTab').click(function() {
        var tMenuType = $(this).data('menutype');
		if (tMenuType == 'InfoContact' || tMenuType == 'InfoAddr') {
            $('.xWBtnHide').hide();
		} else {
            $('.xWBtnHide').show();
		}
	});


    // $('#odvBtnAddEdit').hasClass('active');
    function JSxSelectTabSpl(ptNameDiv){
        switch(ptNameDiv) {
            case 'Info1':
                $('#odvBtnAddEdit').show();
                break;
            case 'Info2':
                $('#odvBtnAddEdit').show();
                break;
            case 'Address':
                $('#odvBtnAddEdit').show();
                break;
            case 'Member':
                $('#odvBtnAddEdit').show();
                break;
            case 'Contact':
                $('#odvBtnAddEdit').show();
                break;
            case 'Product':
                $('#odvBtnAddEdit').hide();
                break;
            case 'Credit':
                $('#odvBtnAddEdit').show();
                break;
        }
    }

    
    // $("#odvBtnAddEdit").click(function(){
    //     $("#odvBtnAddEdit").each(function(){
    //         bClassAct = $(this).hasClass('active');
    //         if(bClassAct === true)
    //         alert()
    //     });
    // });
    var nLangEdits      = <?php echo $this->session->userdata("tLangEdit");?>;
    var nStaAddOrEdit   = <?php echo $nStaAddOrEdit;?>;
    $(document).ready(function(){
        if(nStaAddOrEdit === 99){
            // $('#ocbSplStaLocateUse').prop("checked", true);
            // $('.xWDisTab').attr('disabled');
            $('.xWDisTab').addClass('disabled');
        }else{
            // JSvCallPageSplAddressList();
            // JSvCallPageSplContactList();
            // JSvCallPageSplProductList();

        }

        $('.xCNSelectBox').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            startDate :'1900-01-01',
            disableTouchKeyboard : true,
            autoclose: true,
        });
        $('#obtSplDob').click(function(event){
            $('#oetSplDob').datepicker('show');
            event.preventDefault();
        });

        $('#obtRegisterDate').click(function(event){
            $('#oetSplApply').datepicker('show');
            event.preventDefault();
        });
        $('#obtSplCrdIssue').click(function(event){
            $('#oetSplCrdIssue').datepicker('show');
            event.preventDefault();
        });
        $('#obtSplCrdExpire').click(function(event){
            $('#oetSplCrdExpire').datepicker('show');
            event.preventDefault();
        });


        $('#obtSplLastCta').click(function(event){
            $('#oetSplLastCta').datepicker('show');
            event.preventDefault();
        });
        $('#obtSplLastPay').click(function(event){
            $('#oetSplLastPay').datepicker('show');
            event.preventDefault();
        });

    });

    //เลือกตัวแทนขาย
    $('#obtSplBrowseAgency').off('click');
    $('#obtSplBrowseAgency').on('click',function(){
        var nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oSPLAgnOption        = undefined;
            oSPLAgnOption               = oSPLBrowseAgency({
                'tReturnInputCode'          : 'oetSplAgnCode',
                'tReturnInputName'          : 'oetSplAgnName',
                'tNextFuncName'             : 'JSxSPLNextFuncBrowseAgency',
                'aArgReturn'                : ['FTAgnCode','FTAgnName']
            });
            JCNxBrowseData('oSPLAgnOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oSPLBrowseAgency = function(poReturnInputAgency){
        let tInputReturnAgnCode   = poReturnInputAgency.tReturnInputCode;
        let tInputReturnAgnName   = poReturnInputAgency.tReturnInputName;
        let tAgencyNextFunc       = poReturnInputAgency.tNextFuncName;
        let aAgencyArgReturn      = poReturnInputAgency.aArgReturn;

        let oAgencyOptionReturn = {
            Title : ['authen/user/user','tBrowseAgnTitle'],
            Table :{Master:'TCNMAgency',PK:'FTAgnCode'},
            Join :{
                Table:	['TCNMAgency_L'],
                On:[' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'authen/user/user',
                ColumnKeyLang	: ['tBrowseAgnCode','tBrowseAgnName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns	    : ['TCNMAgency.FTAgnCode','TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            NextFunc : {
                FuncName  : tAgencyNextFunc, 
                ArgReturn : aAgencyArgReturn
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnAgnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnAgnName,"TCNMAgency_L.FTAgnName"]
            },
            //DebugSQL: true,
        };
        return oAgencyOptionReturn;
    }

    //หลังจากเลือก AGN
    function JSxSPLNextFuncBrowseAgency(){
        //ไม่ทำอะไร
    }

    var oSgp = {
        Title : ['supplier/supplier/supplier','tSplGroup'],
        Table:{Master:'TCNMSplGrp',PK:'FTSgpCode'},
        Join :{
            Table:	['TCNMSplGrp_L'],
            On:['TCNMSplGrp.FTSgpCode = TCNMSplGrp_L.FTSgpCode AND TCNMSplGrp_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'supplier/supplier/supplier',
            ColumnKeyLang	: ['tCode','tName'],
            DataColumns		: ['TCNMSplGrp.FTSgpCode','TCNMSplGrp_L.FTSgpName'],
            Perpage			: 10,
            OrderBy		    : ['TCNMSplGrp.FDCreateOn DESC'],

        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetSgpCode","TCNMSplGrp.FTSgpCode"],
            Text		: ["oetSgpName","TCNMSplGrp_L.FTSgpName"],
        },
        RouteAddNew : 'groupsupplier',
        BrowseLev : nStaSplBrowseType
    }
    $('#obtBrowseSgp').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hide Pin Menu
            JCNxBrowseData('oSgp');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oSty = {
        Title : ['supplier/supplier/supplier','tSplType'],
        Table:{Master:'TCNMSplType',PK:'FTStyCode'},
        Join :{
            Table:	['TCNMSplType_L'],
            On:['TCNMSplType.FTStyCode = TCNMSplType_L.FTStyCode AND TCNMSplType_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'supplier/supplier/supplier',
            ColumnKeyLang	: ['tCode','tName'],
            DataColumns		: ['TCNMSplType.FTStyCode','TCNMSplType_L.FTStyName'],
            Perpage			: 10,
            OrderBy		    : ['TCNMSplType.FDCreateOn DESC'],

        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetStyCode","TCNMSplType.FTStyCode"],
            Text		: ["oetStyName","TCNMSplType_L.FTStyName"],
        },
        RouteAddNew : 'suppliertype',
        BrowseLev : nStaSplBrowseType
    }
    $('#obtBrowseSty').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hide Pin Menu
            JCNxBrowseData('oSty');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oSlv = {
        Title : ['supplier/supplier/supplier','tSplLevel'],
        Table:{Master:'TCNMSplLev',PK:'FTSlvCode'},
        Join :{
            Table:	['TCNMSplLev_L'],
            On:['TCNMSplLev.FTSlvCode = TCNMSplLev_L.FTSlvCode AND TCNMSplLev_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'supplier/supplier/supplier',
            ColumnKeyLang	: ['tCode','tName'],
            DataColumns		: ['TCNMSplLev.FTSlvCode','TCNMSplLev_L.FTSlvName'],
            Perpage			: 10,
            OrderBy		    : ['TCNMSplLev.FDCreateOn DESC'],

        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetSlvCode","TCNMSplLev.FTSlvCode"],
            Text		: ["oetSlvName","TCNMSplLev_L.FTSlvName"],
        },
        RouteAddNew : 'supplierlev',
        BrowseLev : nStaSplBrowseType
    }
    $('#obtBrowseSlv').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hide Pin Menu
            JCNxBrowseData('oSlv');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    var oVia = {
        Title : ['supplier/supplier/supplier','tFormatTransport'],
        Table:{Master:'TCNMShipVia',PK:'FTViaCode'},
        Join :{
            Table:	['TCNMShipVia_L'],
            On:['TCNMShipVia.FTViaCode = TCNMShipVia_L.FTViaCode AND TCNMShipVia_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'supplier/supplier/supplier',
            ColumnKeyLang	: ['tCode','tName'],
            DataColumns		: ['TCNMShipVia.FTViaCode','TCNMShipVia_L.FTViaName'],
            Perpage			: 10,
            OrderBy			: ['TCNMShipVia.FTViaCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetViaCode","TCNMShipVia.FTViaCode"],
            Text		: ["oetViaName","TCNMShipVia_L.FTViaName"],
        },
        RouteAddNew : 'shipvia',
        BrowseLev : nStaSplBrowseType
    }
    $('#obtViaCode').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hide Pin Menu
            JCNxBrowseData('oVia');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });





</script>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>


<!-- <script src="<?php echo base_url('application/assets/js/global/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/assets/src/pos5/jSplAddress.js')?>"></script>
<script src="<?= base_url('application/assets/src/pos5/jSplContact.js')?>"></script>
<script src="<?= base_url('application/assets/src/pos5/jSplProduct.js')?>"></script> -->
<?php include "script/jSupplierAdd.php"; ?> 
