<?php
if($aCompData['rtCode']=='1'){
    $tRoute         = "companyEventEdit";
    $tCmpCode       = $aCompData['raItems']['rtCmpCode'];
    $tCmpName       = $aCompData['raItems']['rtCmpName'];
    $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
    $tBchName       = $aCompData['raItems']['rtCmpBchName'];
    $tCmpShop       = $aCompData['raItems']['rtCmpShop'];
    $tCmpDirector   = $aCompData['raItems']['rtCmpDirector'];
    $tCmpEmail      = $aCompData['raItems']['rtCmpEmail'];
    $tCmpFax        = $aCompData['raItems']['rtCmpFax'];
	$tCmpTel        = $aCompData['raItems']['rtCmpTel'];
	$tCmpVatCode	= $aCompData['raItems']['rtVatCodeUse'];
    $tCmpRetInOrEx  = $aCompData['raItems']['rtCmpRetInOrEx'];
    $tCmpWhsInOrEx  = $aCompData['raItems']['rtCmpWhsInOrEx'];
    $tRteCode    	= $aCompData['raItems']['rtCmpRteCode'];
    $tRteName    	= $aCompData['raItems']['rtCmpRteName'];
    $tVatCode       = $aVatList[0]['rtVatCode'];
    $tVatRate       = $aVatList[0]['rtVatRate'];
}else{
    $tRoute         = "companyEventAdd";
    $tCmpCode       = "";
    $tCmpName       = "";
    $tBchCode       = "";
    $tBchName       = "";
    $tCmpShop       = "";
    $tCmpDirector   = "";
    $tCmpEmail      = "";
    $tCmpFax        = "";
	$tCmpTel        = "";
	$tCmpVatCode	= "";
    $tCmpRetInOrEx  = "";
    $tCmpWhsInOrEx  = "";
    $tRteCode    	= "";
    $tRteName    	= "";
    $tVatCode       = "";
    $tVatRate       = "";
}
?>
<form id="ofmAddEditCompany" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" type="submit" id="obtEditCompany" onclick="JSnAddEditCompany()"></button>
    <input type="hidden" id="oetCmpRoute" name="oetCmpRoute" value="<?php echo @$tRoute;?>">
    <input type="hidden" id="oetCmpCode" name="oetCmpCode" value="<?php echo @$tCmpCode;?>">
    <div class="panel panel-headline">
        <div class="panel-body" style="padding-top:20px !important;">
            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                <ul class="nav" role="tablist">
                    <li class="nav-item  active" id="oliInforGeneralTap">
                        <a class="nav-link flat-buttons active" data-toggle="tab" href="#odvInforGeneralTap" role="tab" aria-expanded="false" onclick="JSxSetStsCerrentTap(1);">
                            <?php echo language('company/company/company', 'tPageAddTabNameGeneral');?> 
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row p-b-20" >
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="tab-content">
                    <div class="tab-pane active" id="odvInforGeneralTap" role="tabpanel" aria-expanded="true">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <?php echo FCNtHGetContentUploadImage(@$tImgObjAll,'Company');?>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <div class="row p-t-10 p-b-20">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPSecInfor') ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('company/company/company','tCMPName')?></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="oetCmpName"
                                            name="oetCmpName"
                                            maxlength="200"
                                            data-validate-required="<?php echo language('company/company/company','tValidCompName');?>"
                                            value="<?php echo @$tCmpName;?>"
                                        >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('company/company/company','tCMPBranch')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCmpBchCode" name="oetCmpBchCode" value="<?php echo @$tBchCode?>">
                                            <input
                                                type="text"
                                                class="form-control xWPointerEventNone"
                                                id="oetCmpBchName" name="oetCmpBchName"
                                                data-validate-required="<?php echo language('company/company/company','tValidCmpBranch');?>"
                                                value="<?php echo @$tBchName?>"
                                                readonly
                                            >
                                            <span class="input-group-btn">
                                                <button id="obtCmpBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 <?= !FCNbGetIsShpEnabled()? 'xCNHide' : ''; ?>">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPShop');?></label>
                                        <input type="text" class="form-control" maxlength="200" id="oetCmpShop" name="oetCmpShop" value="<?php echo @$tCmpShop;?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPDirector');?></label>
                                        <input type="text" class="form-control" id="oetCmpDirector" name="oetCmpDirector" maxlength="50" value="<?php echo @$tCmpDirector;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPTel');?></label>
                                        <input type="text" class="form-control" id="oetCmpTel" name="oetCmpTel" maxlength="50" value="<?php echo $tCmpTel;?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPFax');?></label>
                                        <input type="text" class="form-control" id="oetCmpFax" name="oetCmpFax" maxlength="50" value="<?php echo $tCmpFax;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPEmail');?></label>
                                        <input type="email" class="form-control" id="oetCmpEmail" name="oetCmpEmail" maxlength="50" value="<?php echo @$tCmpEmail ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row p-t-10 p-b-20">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPSecTax') ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPRetInOrEx');?></label>
                                        <select class="selectpicker form-control xCNComboSelect" id="ocmCmpRetInOrEx" name="ocmCmpRetInOrEx">
                                            <option value="1" <?php echo ($tCmpRetInOrEx == '1')?'Selected':''?>><?php echo language('company/company/company', 'tCMPInclusive');?></option>
                                            <option value="2" <?php echo ($tCmpRetInOrEx == '2')?'Selected':''?>><?php echo language('company/company/company', 'tCMPExclusive');?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <!-- <div class="form-group">
                                        <label class="xCNLabelFrm"><?php //echo language('company/company/company','tCMPWhsInOrEx')?></label>
                                        <select class="selectpicker form-control xCNComboSelect" id="ocmCmpWhsInOrEx" name="ocmCmpWhsInOrEx">
                                            <option value="1" <?php //echo ($tCmpWhsInOrEx == '1')?'Selected':''?>><?php //echo language('company/company/company','tCMPInclusive');?></option>
                                            <option value="2" <?php //echo ($tCmpWhsInOrEx == '2')?'Selected':''?>><?php //echo language('company/company/company','tCMPExclusive');?></option>
                                        </select>
                                    </div> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('company/company/company','tCMPVatRate')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetVatRateCode" name="oetVatRateCode" value="<?php echo @$tVatCode;?>">
                                            <input
                                                type="text"
                                                class="form-control xWPointerEventNone"
                                                id="oetVatRateName" name="oetVatRateName"
                                                data-validate-required="<?php echo language('company/company/company','tValidCmpVatRate');?>"
                                                value="<?php echo @$tVatRate;?>"
                                                readonly
                                            >
                                            <span class="input-group-btn">
                                                <button id="obtCmpBrowseVatRate" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('company/company/company','tCMPCurrency')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCmpRteCode" name="oetCmpRteCode" value="<?php echo @$tRteCode;?>">
                                            <input
                                                type="text"
                                                class="form-control xWPointerEventNone"
                                                id="oetCmpRteName" name="oetCmpRteName"
                                                data-validate-required="<?php echo language('company/company/company','tValidCmpCurrency');?>"
                                                value="<?php echo @$tRteName?>"
                                                readonly
                                            >
                                            <span class="input-group-btn">
                                                <button id="obtCmpBrowseCurrency" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                            </span>
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
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include 'script/jCompanyForm.php';?>