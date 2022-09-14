<style>
    .dropdown-menu {
        z-index: 1048;
    }
</style>

<input id="oetRPTCRDStaBrowse" type="hidden" value="<?= $nBrowseType ?>">
<input id="oetRPTCRDCallBackOption" type="hidden" value="<?= $tBrowseOption ?>">

<div id="odvRPCMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNRPCVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li id="oliRPCTitle" onclick=""><?= language('reportcard/reportcard', 'tRPCTitle') ?></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNRPCBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageRPC">
        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-default" style="margin-bottom: 25px;"> 
                    <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                        <label class="xCNTextDetail1"><?php echo language('reportcard/reportcard', 'tSelectReport'); ?></label>
                    </div>
                    <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body xCNPDModlue" style="padding: 7px;">
                            <div class="table-responsive">
                                <table class="otbActive table table-striped">
                                    <tbody>
                                        <?php if (isset($aDataRPC) && !empty($aDataRPC)): ?>
                                            <?php foreach ($aDataRPC AS $key => $aValue) { ?>
                                                <tr>
                                                    <?php $nRun = $key + 1; ?>
                                                    <td class="xCNRPCSelect" role="tab" data-toggle="tab" data-rpccode="<?= $aValue['FTMnuCtlName'] ?>" aria-expanded="true"><?= $nRun . ". " . $aValue['FTMnuName'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        <?php else: ?>
                                            <tr class="text-center">
                                                <td><?php echo language('reportcard/reportcard', 'tRPCNotFoundPremissReport'); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="col-md-7">
                <div class="panel panel-default" style="margin-bottom: 25px;"> 
                    <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                        <label class="xCNTextDetail1"><?php echo language('reportcard/reportcard', 'tReportCondition'); ?></label>
                    </div>
                    <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body xCNPDModlue">
                            <input type="text" class="xCNHide" id="ohdSelectRPCCode" name="ohdSelectRPCCode">
                            <div class="tab-content">
                                <div  class="tab-pane fade active in" style="padding:10px;">
                                    <div id="odvBtnClearInputCondition" class="row" style="padding-bottom:15px">
                                        <div class="col-md-9">
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <button id="odvBtnClearFilterRpt" class="btn btn-primary" style="font-size:17px;width:100%;">
                                                <?php echo language('reportcard/reportcard', 'tRPCClearCons') ?>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- ====================== Condition ====================== -->
                                    <div class="row" id="odvYear">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCYearFrom'); ?></label>
                                                <select class="selectpicker form-control" id="oetRPCYearCode" name="oetRPCYearCode" maxlength="1">
                                                    <option value=''><?php echo language('reportcard/reportcard', 'tRPCOptionAll'); ?></option>
                                                    <?php foreach ($aSltYear AS $nKey => $aValue): ?>
                                                        <option value="<?php echo trim($aValue['rtSelected']) ?>"><?php echo $aValue['rtSelected'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>	
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCYearTo') ?></label>
                                                <select class="selectpicker form-control" id="oetRPCYearCodeTo" name="oetRPCYearCodeTo" maxlength="1">
                                                    <option value=''><?php echo language('reportcard/reportcard', 'tRPCOptionAll'); ?></option>
                                                    <?php foreach ($aSltYear AS $nKey => $aValue): ?>
                                                        <option value="<?php echo trim($aValue['rtSelected']) ?>"><?php echo $aValue['rtSelected'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>	
                                        </div>
                                    </div>
                                    <div class="row" id="odvBranch">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCBchFrom') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCBchCode" name="oetRPCBchCode" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCBchName" name="oetRPCBchName" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCBchTo') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCBchCodeTo" name="oetRPCBchCodeTo" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCBchNameTo" name="oetRPCBchNameTo" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseBranchTo" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvCrdType" style="display:none;">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdTypeFrom') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardTypeCode" name="oetRPCCardTypeCode" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardTypeName" name="oetRPCCardTypeName" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCardType" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdTypeTo') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardTypeCodeTo" name="oetRPCCardTypeCodeTo" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardTypeNameTo" name="oetRPCCardTypeNameTo" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCardTypeTo" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvCrdTypeOld">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdTypeOldFrom') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardTypeCodeOld" name="oetRPCCardTypeCodeOld" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardTypeNameOld" name="oetRPCCardTypeNameOld" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCardTypeOld" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdTypeOldTo') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardTypeCodeOldTo" name="oetRPCCardTypeCodeOldTo" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardTypeNameOldTo" name="oetRPCCardTypeNameOldTo" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCardTypeOldTo" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvCrdTypeNew">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdTypeNewFrom') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardTypeCodeNew" name="oetRPCCardTypeCodeNew" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardTypeNameNew" name="oetRPCCardTypeNameNew" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCardTypeNew" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdTypeNewTo') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardTypeCodeNewTo" name="oetRPCCardTypeCodeNewTo" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardTypeNameNewTo" name="oetRPCCardTypeNameNewTo" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCardTypeNewTo" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvPosCode">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCShopFrom') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCPosCode" name="oetRPCPosCode" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCPosName" name="oetRPCPosName" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowsePos" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCShopTo') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCPosCodeTo" name="oetRPCPosCodeTo" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCPosNameTo" name="oetRPCPosNameTo" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowsePosTo" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvCrd">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdFrom') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardCode" name="oetRPCCardCode" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardName" name="oetRPCCardName" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCard" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdTo') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardCodeTo" name="oetRPCCardCodeTo" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardNameTo" name="oetRPCCardNameTo" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCardTo" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvCrdOld">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdOldFrom') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardCodeOld" name="oetRPCCardCodeOld" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardNameOld" name="oetRPCCardNameOld" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCardOld" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdOldTo') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardCodeOldTo" name="oetRPCCardCodeOldTo" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardNameOldTo" name="oetRPCCardNameOldTo" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCardOldTo" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvCrdNew">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdNewFrom') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardCodeNew" name="oetRPCCardCodeNew" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardNameNew" name="oetRPCCardNameNew" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCardNew" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCCrdNewTo') ?></label>
                                                <div class="input-group">
                                                    <input class="form-control xCNHide xWRptConsCrdInput" id="oetRPCCardCodeNewTo" name="oetRPCCardCodeNewTo" maxlength="5" value="">
                                                    <input class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" id="oetRPCCardNameNewTo" name="oetRPCCardNameNewTo" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseCardToNew" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvEmployee">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCEmpCodeFrom') ?></label>
                                                <div class="input-group">
                                                    <input type="hidden" class="form-control xWRptConsCrdInput" id="oetRPCEmpCode" name="oetRPCEmpCode" maxlength="5" value="">
                                                    <input type="text" class="form-control xWPointerEventNone xWRptConsCrdInput" id="oetRPCEmpName" name="oetRPCEmpName" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseEmp" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCEmpCodeTo') ?></label>
                                                <div class="input-group">
                                                    <input type="hidden" class="form-control xWRptConsCrdInput" id="oetRPCEmpCodeTo" name="oetRPCEmpCodeTo" maxlength="5" value="">
                                                    <input type="text" class="form-control xWPointerEventNone xWRptConsCrdInput" id="oetRPCEmpNameTo" name="oetRPCEmpNameTo" value="" readonly="">
                                                    <span class="input-group-btn">
                                                        <button id="oimRPCBrowseEmpTo" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url() . 'application/assets/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvStaCard">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCStaCrdFrom') ?></label>
                                                <select class="selectpicker form-control" id="ocmRPCStaCard" name="ocmRPCStaCard" maxlength="1">
                                                    <option value=""><?= language('common/main', 'tCMNBlank-NA') ?></option>
                                                    <option value="1"><?= language('reportcard/reportcard', 'tRPCCardDetailStaActive1') ?></option>
                                                    <option value="2"><?= language('reportcard/reportcard', 'tRPCCardDetailStaActive2') ?></option>
                                                    <option value="3"><?= language('reportcard/reportcard', 'tRPCCardDetailStaActive3') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCStaCrdTo') ?></label>
                                                <select class="selectpicker form-control" id="ocmRPCStaCardTo" name="ocmRPCStaCardTo" maxlength="1">
                                                    <option value=""><?= language('common/main', 'tCMNBlank-NA') ?></option>
                                                    <option value="1"><?= language('reportcard/reportcard', 'tRPCCardDetailStaActive1') ?></option>
                                                    <option value="2"><?= language('reportcard/reportcard', 'tRPCCardDetailStaActive2') ?></option>
                                                    <option value="3"><?= language('reportcard/reportcard', 'tRPCCardDetailStaActive3') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvDate">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCDateFrom') ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xWRptConsCrdInput" id="oetRPCDocDate" name="oetRPCDocDate">
                                                    <span class="input-group-btn">
                                                        <button id="obtRPCDocDate" type="button" class="btn xCNBtnDateTime">
                                                            <img src="<?= base_url() . '/application/assets/icons/icons8-Calendar-100.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCDateTo') ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xWRptConsCrdInput" id="oetRPCDocDateTo" name="oetRPCDocDateTo">
                                                    <span class="input-group-btn">
                                                        <button id="obtRPCDocDateTo" type="button" class="btn xCNBtnDateTime">
                                                            <img src="<?= base_url() . '/application/assets/icons/icons8-Calendar-100.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvDateStart">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCDateStartFrom') ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xWRptConsCrdInput" id="oetRPCDateStart" name="oetRPCDateStart">
                                                    <span class="input-group-btn">
                                                        <button id="obtRPCDateStart" type="button" class="btn xCNBtnDateTime">
                                                            <img src="<?= base_url() . '/application/assets/icons/icons8-Calendar-100.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCDateStartTo') ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xWRptConsCrdInput" id="oetRPCDateStartTo" name="oetRPCDateStartTo">
                                                    <span class="input-group-btn">
                                                        <button id="obtRPCDateStartTo" type="button" class="btn xCNBtnDateTime">
                                                            <img src="<?= base_url() . '/application/assets/icons/icons8-Calendar-100.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="odvDateExpire">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCDateExpireFrom') ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xWRptConsCrdInput" id="oetRPCDateExpire" name="oetRPCDateExpire">
                                                    <span class="input-group-btn">
                                                        <button id="obtRPCDateExpire" type="button" class="btn xCNBtnDateTime">
                                                            <img src="<?= base_url() . '/application/assets/icons/icons8-Calendar-100.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('reportcard/reportcard', 'tRPCDateExpireTo') ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xWRptConsCrdInput" id="oetRPCDateExpireTo" name="oetRPCDateExpireTo">
                                                    <span class="input-group-btn">
                                                        <button id="obtRPCDateExpireTo" type="button" class="btn xCNBtnDateTime">
                                                            <img src="<?= base_url() . '/application/assets/icons/icons8-Calendar-100.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ====================== Button Process Report ====================== -->
                                    <?php
                                    if (isset($aDataRPC) && !empty($aDataRPC)) {
                                        $tBtnDisabledRPC = "";
                                    } else {
                                        $tBtnDisabledRPC = "disabled";
                                    }
                                    ?>
                                    <div id="odvBtnProcessRpt" class="row">
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <button <?php echo $tBtnDisabledRPC ?> type="button" id="obtRPCExportExcel" data-rpccode="" class="btn btn-primary" style="font-size: 17px;width: 100%;"><?php echo language('reportcard/reportcard', 'tExportExcel') ?></button>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <button <?php echo $tBtnDisabledRPC ?> type="button" id="obtRPCDownloadRpt" data-rpccode="" class="btn btn-primary" style="font-size: 17px;width: 100%;"><?php echo language('reportcard/reportcard', 'tDownloadPDF') ?></button>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <button <?php echo $tBtnDisabledRPC ?> type="button" id="obtRPCBeforePrint" data-rpccode="" class="btn btn-primary" style="font-size: 17px;width: 100%;"><?php echo language('reportcard/reportcard', 'tPrintPreview') ?></button>
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

<script src="<?= base_url('application/assets/src/jReportcard.js') ?>"></script>

<script src="<?php echo base_url('application/assets/js/global/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/assets/src/jFormValidate.js') ?>"></script>

<script type="text/javascript">


    $('document').ready(function () {
        tRptCode = $('.otbActive .xCNRPCSelect').data('rpccode');
        $('.otbActive tr:first-child').addClass('active');
        JSxSelectReport(tRptCode)
    });

    $('#odvBtnClearFilterRpt').click(function () {
        JCNxOpenLoading();
        setTimeout(function () {
            $('.xWRptConsCrdInput').val('');
            $(".selectpicker").val('').selectpicker("refresh");
            JCNxCloseLoading();
        }, 500);
    });

    $('.selectpicker').selectpicker();

    var tBaseURL = '<?php echo base_url(); ?>';
    //Lang Edit In Browse
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;

    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    //Click ICON DATE
    //วันที่เอกสาร
    $('#obtRPCDocDate').click(function () {
        event.preventDefault();
        $('#oetRPCDocDate').datepicker('show');
    });
    $('#obtRPCDocDateTo').click(function () {
        event.preventDefault();
        $('#oetRPCDocDateTo').datepicker('show');
    });
    //วันที่เอกสาร
    //วันที่เริ่มต้น
    $('#obtRPCDateStart').click(function () {
        event.preventDefault();
        $('#oetRPCDateStart').datepicker('show');
    });
    $('#obtRPCDateStartTo').click(function () {
        event.preventDefault();
        $('#oetRPCDateStartTo').datepicker('show');
    });
    //วันที่เริ่มต้น
    //วันที่สิ้นสุด
    $('#obtRPCDateExpire').click(function () {
        event.preventDefault();
        $('#oetRPCDateExpire').datepicker('show');
    });
    $('#obtRPCDateExpireTo').click(function () {
        event.preventDefault();
        $('#oetRPCDateExpireTo').datepicker('show');
    });
    //วันที่สิ้นสุด
    //Click ICON DATE

    function JSxSelectReport(ptRptCode) {
        JCNxOpenLoading();
        $(".selectpicker").val('').selectpicker("refresh");
        $('#ohdSelectRPCCode').val(ptRptCode);
        $('.xWRptConsCrdInput').val('');
        switch (ptRptCode) {
            //รายงานข้อมูลการใช้บัตร/1
            case 'RptUseCard1':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').hide();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').hide();
                $('#odvStaCard').hide();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                $('#odvCrd').show();
                $('#odvDate').show();
                break;
                //รายงานตรวจสอบสถานะบัตร
            case 'RptCheckStatusCard':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').show();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').show();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').hide();
                $('#odvStaCard').show();
                $('#odvDate').show();
                $('#odvDateStart').show();
                $('#odvDateExpire').show();
                break;
                //รายงานโอนข้อมูลบัตร
            case 'RptTransferCardInfo':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').hide();
                $('#odvCrdTypeOld').show();
                $('#odvCrdTypeNew').show();
                $('#odvPosCode').hide();
                $('#odvCrd').hide();
                $('#odvCrdOld').show();
                $('#odvCrdNew').show();
                $('#odvEmployee').hide();
                $('#odvStaCard').hide();
                $('#odvDate').show();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                break;
                //รายงานการปรับมูลค่าเงินสดในบัตร
            case 'RptAdjustCashInCard':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').hide();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').show();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').hide();
                $('#odvStaCard').hide();
                $('#odvDate').show();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                break;
                //รายงานการล้างมูลค่าบัตรเพื่อกลับมาใช้งานใหม่
            case 'RptClearCardValueForReuse':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').show();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').show();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').hide();
                $('#odvStaCard').hide();
                $('#odvDate').show();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                break;
                //รายงานข้อมูลบัตรที่ไม่ใช้งาน
            case 'RptCardNoActive':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').show();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').show();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').hide();
                $('#odvStaCard').hide();
                $('#odvDate').hide();
                $('#odvDateStart').show();
                $('#odvDateExpire').show();
                break;
                //รายงานจำนวนรอบการใช้บัตร
            case 'RptCardTimesUsed':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').show();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').show();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').hide();
                $('#odvStaCard').hide();
                $('#odvDate').hide();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                break;
                //รายงานบัตรคงเหลือ
            case 'RptCardBalance':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').hide();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').hide();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').hide();
                $('#odvStaCard').show();
                $('#odvDate').show();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                break;
                //รายงานยอดสะสมบัตรหมดอายุ
            case 'RptCollectExpireCard':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').hide();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').hide();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').hide();
                $('#odvStaCard').hide();
                $('#odvDate').show();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                break;
                //รายงานรายการต้นงวดบัตรและเงินสด
            case 'RptCardPrinciple':
                $('#odvYear').show();
                $('#odvBranch').hide();
                $('#odvCrdType').show();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').hide();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').hide();
                $('#odvStaCard').hide();
                $('#odvDate').hide();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                break;
                //รายงานข้อมูลบัตร
            case 'RptCardDetail':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').show();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').show();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').hide();
                $('#odvStaCard').show();
                $('#odvDate').hide();
                $('#odvDateStart').show();
                $('#odvDateExpire').show();
                break;
                //รายงานตรวจสอบการเติมเงิน
            case 'RptCheckPrepaid':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').hide();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').show();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').hide();
                $('#odvStaCard').hide();
                $('#odvDate').show();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                break;

                //รายงานตรวจสอบข้อมูลการใช้บัตร/2 (User Request)
            case 'RptCheckCardUseInfo':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').hide();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').show();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').show();
                $('#odvStaCard').show();
                $('#odvDate').show();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                break;

                //รายงานตรวจสอบข้อมูลการใช้บัตร/2 (User Request)
            case 'RptTopUp':
                $('#odvYear').hide();
                $('#odvBranch').hide();
                $('#odvCrdType').hide();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrd').show();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvEmployee').show();
                $('#odvStaCard').show();
                $('#odvDate').show();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                break;

                //รายงานข้อมูลการใช้บัตร (User Request)
            case 'RptUseCard2':
                $('#odvYear').hide();
                $('#odvCrdType').hide();
                $('#odvCrdTypeOld').hide();
                $('#odvCrdTypeNew').hide();
                $('#odvPosCode').hide();
                $('#odvCrdOld').hide();
                $('#odvCrdNew').hide();
                $('#odvDateStart').hide();
                $('#odvDateExpire').hide();
                $('#odvBranch').show();
                $('#odvCrd').show();
                $('#odvEmployee').show();
                $('#odvStaCard').show();
                $('#odvDate').show();
                break;


            default:

        }
        JCNxCloseLoading();
    }

    //Select Report List แล้วจะเอา Code ไป ใส่ใน attr ของปุ่ม Excel , print
    $('.xCNRPCSelect').click(function () {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            //AddClass Active
            $('.otbActive tr').removeClass('active');
            $(this).parent().addClass('active');
            tRPCCode = $(this).data('rpccode');
            JSxSelectReport(tRPCCode)
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    //Click Btn Export Excel
    $('#obtRPCExportExcel').unbind('click');
    $('#obtRPCExportExcel').bind('click', function () {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JSvCheckExportExcel();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //Click Btn Before Print
    $('#obtRPCBeforePrint').unbind('click');
    $('#obtRPCBeforePrint').bind('click', function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JSvManageExportViewOrPdf('html');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    
    $('#obtRPCDownloadRpt').unbind('click');
    $('#obtRPCDownloadRpt').bind('click', function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            $("#odvOverLayContentForLongTimeLoading").css("display","block");
            JSvManageExportViewOrPdf('pdf');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //Function: ฟังก์ชั่นเรียกใช้งาน Export PDF,View รายงาน
    //Parameters:  Event ปุ่ม ดาวน์โหลด และ ปุ่ม แสดงตัวอย่างรายงาน
    //Creator: 22/11/2018 Wasin (YOSHI)
    //Return : windows open view
    //Return Type: view
    function JSvManageExportViewOrPdf(ptCallView) {
        JCNxOpenLoading();
        var tCallView = ptCallView;

        var tRPCCode = $('#ohdSelectRPCCode').val();

        var tYearCodeFrom = $('#oetRPCYearCode').val();
        var tYearCodeTo = $('#oetRPCYearCodeTo').val();

        var tBchCodeFrom = $('#oetRPCBchCode').val();
        var tBchNameFrom = $('#oetRPCBchName').val();
        var tBchCodeTo = $('#oetRPCBchCodeTo').val();
        var tBchNameTo = $('#oetRPCBchNameTo').val();

        var tCardTypeCodeFrom = $('#oetRPCCardTypeCode').val();
        var tCardTypeCodeTo = $('#oetRPCCardTypeCodeTo').val();
        var tCardTypeNameFrom = $('#oetRPCCardTypeName').val();
        var tCardTypeNameTo = $('#oetRPCCardTypeNameTo').val();

        var tCardTypeCodeOldFrom = $('#oetRPCCardTypeCodeOld').val();
        var tCardTypeCodeOldTo = $('#oetRPCCardTypeCodeOldTo').val();
        var tCardTypeNameOldFrom = $('#oetRPCCardTypeNameOld').val();
        var tCardTypeNameOldTo = $('#oetRPCCardTypeNameOldTo').val();

        var tCardTypeCodeNewFrom = $('#oetRPCCardTypeCodeNew').val();
        var tCardTypeCodeNewTo = $('#oetRPCCardTypeCodeNewTo').val();
        var tCardTypeNameNewFrom = $('#oetRPCCardTypeNameNew').val();
        var tCardTypeNameNewTo = $('#oetRPCCardTypeNameNewTo').val();

        var tPosCodeFrom = $('#oetRPCPosCode').val();
        var tPosCodeTo = $('#oetRPCPosCodeTo').val();

        var tCardCodeFrom = $('#oetRPCCardCode').val();
        var tCardCodeTo = $('#oetRPCCardCodeTo').val();

        var tEmpCodeFrom = $('#oetRPCEmpCode').val();
        var tEmpCodeTo = $('#oetRPCEmpCodeTo').val();

        var tStaCardFrom = $('#ocmRPCStaCard').val();
        var tStaCardTo = $('#ocmRPCStaCardTo').val();

        var tCardCodeOldFrom = $('#oetRPCCardCodeOld').val();
        var tCardCodeOldTo = $('#oetRPCCardCodeOldTo').val();

        var tCardCodeNewFrom = $('#oetRPCCardCodeNew').val();
        var tCardCodeNewTo = $('#oetRPCCardCodeNewTo').val();

        var tDocDateFrom = $('#oetRPCDocDate').val();
        var tDocDateTo = $('#oetRPCDocDateTo').val();

        var tDateStartFrom = $('#oetRPCDateStart').val();
        var tDateStartTo = $('#oetRPCDateStartTo').val();

        var tDateExpireFrom = $('#oetRPCDateExpire').val();
        var tDateExpireTo = $('#oetRPCDateExpireTo').val();

        if (tRPCCode != '') {
            $.ajax({
                type: "POST",
                url: "RPTCRDChkData" + tRPCCode,
                data: {
                    tRPCCode: tRPCCode,
                    /*ปี*/
                    tYearCodeFrom: tYearCodeFrom,
                    tYearCodeTo: tYearCodeTo,
                    /*สาขา*/
                    tBchCodeFrom: tBchCodeFrom,
                    tBchNameFrom: tBchNameFrom,
                    tBchCodeTo: tBchCodeTo,
                    tBchNameTo: tBchNameTo,
                    /*ประเภทบัตร*/
                    tCardTypeCodeFrom: tCardTypeCodeFrom,
                    tCardTypeCodeTo: tCardTypeCodeTo,
                    tCardTypeNameFrom: tCardTypeNameFrom,
                    tCardTypeNameTo: tCardTypeNameTo,
                    /*ประเภทบัตรเดิม*/
                    tCardTypeCodeOldFrom: tCardTypeCodeOldFrom,
                    tCardTypeCodeOldTo: tCardTypeCodeOldTo,
                    tCardTypeNameOldFrom: tCardTypeNameOldFrom,
                    tCardTypeNameOldTo: tCardTypeNameOldTo,
                    /*ประเภทบัตรใหม่*/
                    tCardTypeCodeNewFrom: tCardTypeCodeNewFrom,
                    tCardTypeCodeNewTo: tCardTypeCodeNewTo,
                    tCardTypeNameNewFrom: tCardTypeNameNewFrom,
                    tCardTypeNameNewTo: tCardTypeNameNewTo,
                    /*เลขเครื่องจุดขาย*/
                    tPosCodeFrom: tPosCodeFrom,
                    tPosCodeTo: tPosCodeTo,
                    /*เลขขัตร*/
                    tCardCodeFrom: tCardCodeFrom,
                    tCardCodeTo: tCardCodeTo,
                    /*รหัสพนักงาน*/
                    tEmpCodeFrom: tEmpCodeFrom,
                    tEmpCodeTo: tEmpCodeTo,
                    /*สถานะบัตร*/
                    tStaCardFrom: tStaCardFrom,
                    tStaCardTo: tStaCardTo,
                    /*เลขขัตรเก่า*/
                    tCardCodeOldFrom: tCardCodeOldFrom,
                    tCardCodeOldTo: tCardCodeOldTo,
                    /*เลขขัตรใหม่*/
                    tCardCodeNewFrom: tCardCodeNewFrom,
                    tCardCodeNewTo: tCardCodeNewTo,
                    /*วันที่*/
                    tDocDateFrom: tDocDateFrom,
                    tDocDateTo: tDocDateTo,
                    /*วันที่เริ่มต้น*/
                    tDateStartFrom: tDateStartFrom,
                    tDateStartTo: tDateStartTo,
                    /*วันที่เริ่มต้น*/
                    tDateExpireFrom: tDateExpireFrom,
                    tDateExpireTo: tDateExpireTo,
                },
                async: true,
                cache: false,
                timeout: 0,
                success: function (oResult) {
                    var oDataExportPDF = {
                        /** Call View Report Or Download */
                        'tCallView': tCallView,
                        'tRPCCode': tRPCCode,
                        /*ปี*/
                        'tYearCodeFrom': tYearCodeFrom,
                        'tYearCodeTo': tYearCodeTo,
                        /*สาขา*/
                        'tBchCodeFrom': tBchCodeFrom,
                        'tBchNameFrom': tBchNameFrom,
                        'tBchCodeTo': tBchCodeTo,
                        'tBchNaCmeTo': tBchNameTo,
                        /*ประเภทบัตร*/
                        'tCardTypeCodeFrom': tCardTypeCodeFrom,
                        'tCardTypeCodeTo': tCardTypeCodeTo,
                        'tCardTypeNameFrom': tCardTypeNameFrom,
                        'tCardTypeNameTo': tCardTypeNameTo,
                        /*ประเภทบัตรเดิม*/
                        'tCardTypeCodeOldFrom': tCardTypeCodeOldFrom,
                        'tCardTypeCodeOldTo': tCardTypeCodeOldTo,
                        'tCardTypeNameOldFrom': tCardTypeNameOldFrom,
                        'tCardTypeNameOldTo': tCardTypeNameOldTo,
                        /*ประเภทบัตรใหม่*/
                        'tCardTypeCodeNewFrom': tCardTypeCodeNewFrom,
                        'tCardTypeCodeNewTo': tCardTypeCodeNewTo,
                        'tCardTypeNameNewFrom': tCardTypeNameNewFrom,
                        'tCardTypeNameNewTo': tCardTypeNameNewTo,
                        /*เลขเครื่องจุดขาย*/
                        'tPosCodeFrom': tPosCodeFrom,
                        'tPosCodeTo': tPosCodeTo,
                        /*เลขขัตร*/
                        'tCardCodeFrom': tCardCodeFrom,
                        'tCardCodeTo': tCardCodeTo,
                        /*รหัสพนักงาน*/
                        'tEmpCodeFrom': tEmpCodeFrom,
                        'tEmpCodeTo': tEmpCodeTo,
                        /*สถานะบัตร*/
                        'tStaCardFrom': tStaCardFrom,
                        'tStaCardTo': tStaCardTo,
                        /*เลขขัตรเก่า*/
                        'tCardCodeOldFrom': tCardCodeOldFrom,
                        'tCardCodeOldTo': tCardCodeOldTo,
                        /*เลขขัตรใหม่*/
                        'tCardCodeNewFrom': tCardCodeNewFrom,
                        'tCardCodeNewTo': tCardCodeNewTo,
                        /*วันที่*/
                        'tDocDateFrom': tDocDateFrom,
                        'tDocDateTo': tDocDateTo,
                        /*วันที่เริ่มต้น*/
                        'tDateStartFrom': tDateStartFrom,
                        'tDateStartTo': tDateStartTo,
                        /*วันที่เริ่มต้น*/
                        'tDateExpireFrom': tDateExpireFrom,
                        'tDateExpireTo': tDateExpireTo,
                    };
                    var tJsonString = JSON.stringify(oDataExportPDF);
                    var tDataBase64 = window.btoa(encodeURI(tJsonString));
                    var aDataReturn = JSON.parse(oResult);
                    console.log(aDataReturn['tCountNumber']);
                    if(aDataReturn['tCountNumber'] != 0){
                        if(tCallView == 'html'){
                            JCNxCloseLoading();
                            // window.open("RPTCRDExportPDF"+tRPCCode+'?tdatacons='+tDataBase64+'&nStaOverLimin=0&nPage=1');
                            window.open("RPTCRDExportPDF"+tRPCCode+'?tdatacons='+tDataBase64,'?nStaOverLimin=0,importwindow',"toolbar=no,status=no,scrollbars=yes,resizable=yes,width=1280,height=768");
                        }else{
                            if(aDataReturn['tCountNumber'] <= 20000){
                                JCNxExportPdfReport(0);
                            }else{
                                JCNxCloseLoading();
                                FSxCMNSetMsgReportConfirmMessageDialog(aDataReturn['tCountNumber'],'JCNxExportPdfReport(1)');
                            }
                        }
                    }else{
                        JCNxCloseLoading();
                        FSvCMNSetMsgWarningDialog(aDataReturn['tMsgReportNotFound']);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            tMessage = 'กรุณาเลือกรายงาน';
            FSvCMNSetMsgWarningDialog(tMessage);
        }
    }

    //Function: ฟังก์ชั่นเรียกใช้งาน Export PDF
	//Parameters:  Function Condition Parameter
    //Creator: 05/04/2019 Wasin (Yoshi)
    //Return : Downlond File PDF
    //Return Type: -
    function JCNxExportPdfReport(pnStaOverLimit){
        var tYearCodeFrom = $('#oetRPCYearCode').val();
        var tYearCodeTo = $('#oetRPCYearCodeTo').val();

        var tBchCodeFrom = $('#oetRPCBchCode').val();
        var tBchNameFrom = $('#oetRPCBchName').val();
        var tBchCodeTo = $('#oetRPCBchCodeTo').val();
        var tBchNameTo = $('#oetRPCBchNameTo').val();

        var tCardTypeCodeFrom = $('#oetRPCCardTypeCode').val();
        var tCardTypeCodeTo = $('#oetRPCCardTypeCodeTo').val();
        var tCardTypeNameFrom = $('#oetRPCCardTypeName').val();
        var tCardTypeNameTo = $('#oetRPCCardTypeNameTo').val();

        var tCardTypeCodeOldFrom = $('#oetRPCCardTypeCodeOld').val();
        var tCardTypeCodeOldTo = $('#oetRPCCardTypeCodeOldTo').val();
        var tCardTypeNameOldFrom = $('#oetRPCCardTypeNameOld').val();
        var tCardTypeNameOldTo = $('#oetRPCCardTypeNameOldTo').val();

        var tCardTypeCodeNewFrom = $('#oetRPCCardTypeCodeNew').val();
        var tCardTypeCodeNewTo = $('#oetRPCCardTypeCodeNewTo').val();
        var tCardTypeNameNewFrom = $('#oetRPCCardTypeNameNew').val();
        var tCardTypeNameNewTo = $('#oetRPCCardTypeNameNewTo').val();

        var tPosCodeFrom = $('#oetRPCPosCode').val();
        var tPosCodeTo = $('#oetRPCPosCodeTo').val();

        var tCardCodeFrom = $('#oetRPCCardCode').val();
        var tCardCodeTo = $('#oetRPCCardCodeTo').val();

        var tEmpCodeFrom = $('#oetRPCEmpCode').val();
        var tEmpCodeTo = $('#oetRPCEmpCodeTo').val();

        var tStaCardFrom = $('#ocmRPCStaCard').val();
        var tStaCardTo = $('#ocmRPCStaCardTo').val();

        var tCardCodeOldFrom = $('#oetRPCCardCodeOld').val();
        var tCardCodeOldTo = $('#oetRPCCardCodeOldTo').val();

        var tCardCodeNewFrom = $('#oetRPCCardCodeNew').val();
        var tCardCodeNewTo = $('#oetRPCCardCodeNewTo').val();

        var tDocDateFrom = $('#oetRPCDocDate').val();
        var tDocDateTo = $('#oetRPCDocDateTo').val();

        var tDateStartFrom = $('#oetRPCDateStart').val();
        var tDateStartTo = $('#oetRPCDateStartTo').val();

        var tDateExpireFrom = $('#oetRPCDateExpire').val();
        var tDateExpireTo = $('#oetRPCDateExpireTo').val();
        var tRPCCode    = $('#ohdSelectRPCCode').val();

        var oDataExportPDF = {
            /** Call View Report Or Download */
            'tCallView': 'pdf',
            'tRPCCode': tRPCCode,
            /*ปี*/
            'tYearCodeFrom': tYearCodeFrom,
            'tYearCodeTo': tYearCodeTo,
            /*สาขา*/
            'tBchCodeFrom': tBchCodeFrom,
            'tBchNameFrom': tBchNameFrom,
            'tBchCodeTo': tBchCodeTo,
            'tBchNaCmeTo': tBchNameTo,
            /*ประเภทบัตร*/
            'tCardTypeCodeFrom': tCardTypeCodeFrom,
            'tCardTypeCodeTo': tCardTypeCodeTo,
            'tCardTypeNameFrom': tCardTypeNameFrom,
            'tCardTypeNameTo': tCardTypeNameTo,
            /*ประเภทบัตรเดิม*/
            'tCardTypeCodeOldFrom': tCardTypeCodeOldFrom,
            'tCardTypeCodeOldTo': tCardTypeCodeOldTo,
            'tCardTypeNameOldFrom': tCardTypeNameOldFrom,
            'tCardTypeNameOldTo': tCardTypeNameOldTo,
            /*ประเภทบัตรใหม่*/
            'tCardTypeCodeNewFrom': tCardTypeCodeNewFrom,
            'tCardTypeCodeNewTo': tCardTypeCodeNewTo,
            'tCardTypeNameNewFrom': tCardTypeNameNewFrom,
            'tCardTypeNameNewTo': tCardTypeNameNewTo,
            /*เลขเครื่องจุดขาย*/
            'tPosCodeFrom': tPosCodeFrom,
            'tPosCodeTo': tPosCodeTo,
            /*เลขขัตร*/
            'tCardCodeFrom': tCardCodeFrom,
            'tCardCodeTo': tCardCodeTo,
            /*รหัสพนักงาน*/
            'tEmpCodeFrom': tEmpCodeFrom,
            'tEmpCodeTo': tEmpCodeTo,
            /*สถานะบัตร*/
            'tStaCardFrom': tStaCardFrom,
            'tStaCardTo': tStaCardTo,
            /*เลขขัตรเก่า*/
            'tCardCodeOldFrom': tCardCodeOldFrom,
            'tCardCodeOldTo': tCardCodeOldTo,
            /*เลขขัตรใหม่*/
            'tCardCodeNewFrom': tCardCodeNewFrom,
            'tCardCodeNewTo': tCardCodeNewTo,
            /*วันที่*/
            'tDocDateFrom': tDocDateFrom,
            'tDocDateTo': tDocDateTo,
            /*วันที่เริ่มต้น*/
            'tDateStartFrom': tDateStartFrom,
            'tDateStartTo': tDateStartTo,
            /*วันที่เริ่มต้น*/
            'tDateExpireFrom': tDateExpireFrom,
            'tDateExpireTo': tDateExpireTo,
        };
        var tJsonString = JSON.stringify(oDataExportPDF);
        var tDataBase64 = window.btoa(encodeURI(tJsonString));
        JCNxOpenLoading();
        setTimeout(function(){
        
            $.ajax({
                type: "GET",
                async: false,
                url: "RPTCRDExportPDF" + tRPCCode + "?tdatacons=" + tDataBase64,
                data:{
                    'nStaOverLimin' : pnStaOverLimit
                },
                cache: false,
                Timeout: 0,
                success: function(tResult) {
                    try{
                        var oResult = JSON.parse(tResult);
                        console.log('RPTCRDExportPDF: ', oResult);
                        var $oObjectExport = $("<a>");
                        $oObjectExport.attr("href", oResult['tFileUrl']);
                        $("body").append($oObjectExport);
                        $oObjectExport.attr("download", oResult['tFileName']);
                        $oObjectExport[0].click();
                        $oObjectExport.remove();
                        JCNxCloseLoading();
                    }catch(err){}
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
        }, 100);
    }
    
    //Function: ฟังก์ชั่นเรียกใช้งาน Export PDF,View รายงาน
    //Parameters:  Event ปุ่ม ดาวน์โหลด และ ปุ่ม แสดงตัวอย่างรายงาน
    //Creator: 22/11/2018 Wasin (YOSHI)
    //Return : windows open view
    //Return Type: view
    function JSvManageExportViewOrPdf_(ptCallView) {
        JCNxOpenLoading();
        var tCallView = ptCallView;

        var tRPCCode = $('#ohdSelectRPCCode').val();

        var tYearCodeFrom = $('#oetRPCYearCode').val();
        var tYearCodeTo = $('#oetRPCYearCodeTo').val();

        var tBchCodeFrom = $('#oetRPCBchCode').val();
        var tBchNameFrom = $('#oetRPCBchName').val();
        var tBchCodeTo = $('#oetRPCBchCodeTo').val();
        var tBchNameTo = $('#oetRPCBchNameTo').val();

        var tCardTypeCodeFrom = $('#oetRPCCardTypeCode').val();
        var tCardTypeCodeTo = $('#oetRPCCardTypeCodeTo').val();
        var tCardTypeNameFrom = $('#oetRPCCardTypeName').val();
        var tCardTypeNameTo = $('#oetRPCCardTypeNameTo').val();

        var tCardTypeCodeOldFrom = $('#oetRPCCardTypeCodeOld').val();
        var tCardTypeCodeOldTo = $('#oetRPCCardTypeCodeOldTo').val();
        var tCardTypeNameOldFrom = $('#oetRPCCardTypeNameOld').val();
        var tCardTypeNameOldTo = $('#oetRPCCardTypeNameOldTo').val();

        var tCardTypeCodeNewFrom = $('#oetRPCCardTypeCodeNew').val();
        var tCardTypeCodeNewTo = $('#oetRPCCardTypeCodeNewTo').val();
        var tCardTypeNameNewFrom = $('#oetRPCCardTypeNameNew').val();
        var tCardTypeNameNewTo = $('#oetRPCCardTypeNameNewTo').val();

        var tPosCodeFrom = $('#oetRPCPosCode').val();
        var tPosCodeTo = $('#oetRPCPosCodeTo').val();

        var tCardCodeFrom = $('#oetRPCCardCode').val();
        var tCardCodeTo = $('#oetRPCCardCodeTo').val();

        var tEmpCodeFrom = $('#oetRPCEmpCode').val();
        var tEmpCodeTo = $('#oetRPCEmpCodeTo').val();

        var tStaCardFrom = $('#ocmRPCStaCard').val();
        var tStaCardTo = $('#ocmRPCStaCardTo').val();

        var tCardCodeOldFrom = $('#oetRPCCardCodeOld').val();
        var tCardCodeOldTo = $('#oetRPCCardCodeOldTo').val();

        var tCardCodeNewFrom = $('#oetRPCCardCodeNew').val();
        var tCardCodeNewTo = $('#oetRPCCardCodeNewTo').val();

        var tDocDateFrom = $('#oetRPCDocDate').val();
        var tDocDateTo = $('#oetRPCDocDateTo').val();

        var tDateStartFrom = $('#oetRPCDateStart').val();
        var tDateStartTo = $('#oetRPCDateStartTo').val();

        var tDateExpireFrom = $('#oetRPCDateExpire').val();
        var tDateExpireTo = $('#oetRPCDateExpireTo').val();

        if (tRPCCode != '') {
            $.ajax({
                type: "POST",
                url: "RPTCRDChkData" + tRPCCode,
                data: {
                    tRPCCode: tRPCCode,
                    /*ปี*/
                    tYearCodeFrom: tYearCodeFrom,
                    tYearCodeTo: tYearCodeTo,
                    /*สาขา*/
                    tBchCodeFrom: tBchCodeFrom,
                    tBchNameFrom: tBchNameFrom,
                    tBchCodeTo: tBchCodeTo,
                    tBchNameTo: tBchNameTo,
                    /*ประเภทบัตร*/
                    tCardTypeCodeFrom: tCardTypeCodeFrom,
                    tCardTypeCodeTo: tCardTypeCodeTo,
                    tCardTypeNameFrom: tCardTypeNameFrom,
                    tCardTypeNameTo: tCardTypeNameTo,
                    /*ประเภทบัตรเดิม*/
                    tCardTypeCodeOldFrom: tCardTypeCodeOldFrom,
                    tCardTypeCodeOldTo: tCardTypeCodeOldTo,
                    tCardTypeNameOldFrom: tCardTypeNameOldFrom,
                    tCardTypeNameOldTo: tCardTypeNameOldTo,
                    /*ประเภทบัตรใหม่*/
                    tCardTypeCodeNewFrom: tCardTypeCodeNewFrom,
                    tCardTypeCodeNewTo: tCardTypeCodeNewTo,
                    tCardTypeNameNewFrom: tCardTypeNameNewFrom,
                    tCardTypeNameNewTo: tCardTypeNameNewTo,
                    /*เลขเครื่องจุดขาย*/
                    tPosCodeFrom: tPosCodeFrom,
                    tPosCodeTo: tPosCodeTo,
                    /*เลขขัตร*/
                    tCardCodeFrom: tCardCodeFrom,
                    tCardCodeTo: tCardCodeTo,
                    /*รหัสพนักงาน*/
                    tEmpCodeFrom: tEmpCodeFrom,
                    tEmpCodeTo: tEmpCodeTo,
                    /*สถานะบัตร*/
                    tStaCardFrom: tStaCardFrom,
                    tStaCardTo: tStaCardTo,
                    /*เลขขัตรเก่า*/
                    tCardCodeOldFrom: tCardCodeOldFrom,
                    tCardCodeOldTo: tCardCodeOldTo,
                    /*เลขขัตรใหม่*/
                    tCardCodeNewFrom: tCardCodeNewFrom,
                    tCardCodeNewTo: tCardCodeNewTo,
                    /*วันที่*/
                    tDocDateFrom: tDocDateFrom,
                    tDocDateTo: tDocDateTo,
                    /*วันที่เริ่มต้น*/
                    tDateStartFrom: tDateStartFrom,
                    tDateStartTo: tDateStartTo,
                    /*วันที่เริ่มต้น*/
                    tDateExpireFrom: tDateExpireFrom,
                    tDateExpireTo: tDateExpireTo,
                },
                async: true,
                cache: false,
                timeout: 0,
                success: function (oResult) {
                    var oDataExportPDF = {
                        /** Call View Report Or Download */
                        'tCallView': tCallView,
                        'tRPCCode': tRPCCode,
                        /*ปี*/
                        'tYearCodeFrom': tYearCodeFrom,
                        'tYearCodeTo': tYearCodeTo,
                        /*สาขา*/
                        'tBchCodeFrom': tBchCodeFrom,
                        'tBchNameFrom': tBchNameFrom,
                        'tBchCodeTo': tBchCodeTo,
                        'tBchNaCmeTo': tBchNameTo,
                        /*ประเภทบัตร*/
                        'tCardTypeCodeFrom': tCardTypeCodeFrom,
                        'tCardTypeCodeTo': tCardTypeCodeTo,
                        'tCardTypeNameFrom': tCardTypeNameFrom,
                        'tCardTypeNameTo': tCardTypeNameTo,
                        /*ประเภทบัตรเดิม*/
                        'tCardTypeCodeOldFrom': tCardTypeCodeOldFrom,
                        'tCardTypeCodeOldTo': tCardTypeCodeOldTo,
                        'tCardTypeNameOldFrom': tCardTypeNameOldFrom,
                        'tCardTypeNameOldTo': tCardTypeNameOldTo,
                        /*ประเภทบัตรใหม่*/
                        'tCardTypeCodeNewFrom': tCardTypeCodeNewFrom,
                        'tCardTypeCodeNewTo': tCardTypeCodeNewTo,
                        'tCardTypeNameNewFrom': tCardTypeNameNewFrom,
                        'tCardTypeNameNewTo': tCardTypeNameNewTo,
                        /*เลขเครื่องจุดขาย*/
                        'tPosCodeFrom': tPosCodeFrom,
                        'tPosCodeTo': tPosCodeTo,
                        /*เลขขัตร*/
                        'tCardCodeFrom': tCardCodeFrom,
                        'tCardCodeTo': tCardCodeTo,
                        /*รหัสพนักงาน*/
                        'tEmpCodeFrom': tEmpCodeFrom,
                        'tEmpCodeTo': tEmpCodeTo,
                        /*สถานะบัตร*/
                        'tStaCardFrom': tStaCardFrom,
                        'tStaCardTo': tStaCardTo,
                        /*เลขขัตรเก่า*/
                        'tCardCodeOldFrom': tCardCodeOldFrom,
                        'tCardCodeOldTo': tCardCodeOldTo,
                        /*เลขขัตรใหม่*/
                        'tCardCodeNewFrom': tCardCodeNewFrom,
                        'tCardCodeNewTo': tCardCodeNewTo,
                        /*วันที่*/
                        'tDocDateFrom': tDocDateFrom,
                        'tDocDateTo': tDocDateTo,
                        /*วันที่เริ่มต้น*/
                        'tDateStartFrom': tDateStartFrom,
                        'tDateStartTo': tDateStartTo,
                        /*วันที่เริ่มต้น*/
                        'tDateExpireFrom': tDateExpireFrom,
                        'tDateExpireTo': tDateExpireTo,
                    };
                    var tJsonString = JSON.stringify(oDataExportPDF);
                    var tDataBase64 = window.btoa(encodeURI(tJsonString));
                    var aDataReturn = JSON.parse(oResult);
                    console.log(aDataReturn['tCountNumber']);
                    if(aDataReturn['tCountNumber'] != 0){
                        if(tCallView == 'html'){
                            JCNxCloseLoading();
                            window.open("RPTCRDExportPDF"+tRPCCode+'?tdatacons='+tDataBase64+'&nStaOverLimin=0&nPage=1');
                            // window.open("RPTCRDExportPDF"+tRPCCode+'?tdatacons='+tDataBase64,'?nStaOverLimin=0,importwindow',"toolbar=no,status=no,scrollbars=yes,resizable=yes,width=1280,height=768");
                        }else{
                            if(aDataReturn['tCountNumber'] <= 20000){
                                JCNxExportPdfReport();
                            }else{
                                JCNxCloseLoading();
                                FSxCMNSetMsgReportConfirmMessageDialog(aDataReturn['tCountNumber'],'JCNxExportPdfReport(20000)');
                            }
                        }
                    }else{
                        JCNxCloseLoading();
                        FSvCMNSetMsgWarningDialog(aDataReturn['tMsgReportNotFound']);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            tMessage = 'กรุณาเลือกรายงาน';
            FSvCMNSetMsgWarningDialog(tMessage);
        }
    }

    //Function: ฟังก์ชั่นเรียกใช้งาน Export PDF
	//Parameters:  Function Condition Parameter
    //Creator: 05/04/2019 Wasin (Yoshi)
    //Return : Downlond File PDF
    //Return Type: -
    function JCNxExportPdfReport_(pnStaOverLimit){
        var tCallView = ptCallView;
        $("#odvOverLayContentForLongTimeLoading").css("display","block");
        var tRPCCode = $('#ohdSelectRPCCode').val();

        var tYearCodeFrom = $('#oetRPCYearCode').val();
        var tYearCodeTo = $('#oetRPCYearCodeTo').val();

        var tBchCodeFrom = $('#oetRPCBchCode').val();
        var tBchNameFrom = $('#oetRPCBchName').val();
        var tBchCodeTo = $('#oetRPCBchCodeTo').val();
        var tBchNameTo = $('#oetRPCBchNameTo').val();

        var tCardTypeCodeFrom = $('#oetRPCCardTypeCode').val();
        var tCardTypeCodeTo = $('#oetRPCCardTypeCodeTo').val();
        var tCardTypeNameFrom = $('#oetRPCCardTypeName').val();
        var tCardTypeNameTo = $('#oetRPCCardTypeNameTo').val();

        var tCardTypeCodeOldFrom = $('#oetRPCCardTypeCodeOld').val();
        var tCardTypeCodeOldTo = $('#oetRPCCardTypeCodeOldTo').val();
        var tCardTypeNameOldFrom = $('#oetRPCCardTypeNameOld').val();
        var tCardTypeNameOldTo = $('#oetRPCCardTypeNameOldTo').val();

        var tCardTypeCodeNewFrom = $('#oetRPCCardTypeCodeNew').val();
        var tCardTypeCodeNewTo = $('#oetRPCCardTypeCodeNewTo').val();
        var tCardTypeNameNewFrom = $('#oetRPCCardTypeNameNew').val();
        var tCardTypeNameNewTo = $('#oetRPCCardTypeNameNewTo').val();

        var tPosCodeFrom = $('#oetRPCPosCode').val();
        var tPosCodeTo = $('#oetRPCPosCodeTo').val();

        var tCardCodeFrom = $('#oetRPCCardCode').val();
        var tCardCodeTo = $('#oetRPCCardCodeTo').val();

        var tEmpCodeFrom = $('#oetRPCEmpCode').val();
        var tEmpCodeTo = $('#oetRPCEmpCodeTo').val();

        var tStaCardFrom = $('#ocmRPCStaCard').val();
        var tStaCardTo = $('#ocmRPCStaCardTo').val();

        var tCardCodeOldFrom = $('#oetRPCCardCodeOld').val();
        var tCardCodeOldTo = $('#oetRPCCardCodeOldTo').val();

        var tCardCodeNewFrom = $('#oetRPCCardCodeNew').val();
        var tCardCodeNewTo = $('#oetRPCCardCodeNewTo').val();

        var tDocDateFrom = $('#oetRPCDocDate').val();
        var tDocDateTo = $('#oetRPCDocDateTo').val();

        var tDateStartFrom = $('#oetRPCDateStart').val();
        var tDateStartTo = $('#oetRPCDateStartTo').val();

        var tDateExpireFrom = $('#oetRPCDateExpire').val();
        var tDateExpireTo = $('#oetRPCDateExpireTo').val();


        if (tRPCCode != '') {

            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "RPTCRDExportPDF" + tRPCCode,
                data: {
                    tRPCCode: tRPCCode,
                    /*ปี*/
                    tYearCodeFrom: tYearCodeFrom,
                    tYearCodeTo: tYearCodeTo,
                    /*สาขา*/
                    tBchCodeFrom: tBchCodeFrom,
                    tBchNameFrom: tBchNameFrom,
                    tBchCodeTo: tBchCodeTo,
                    tBchNameTo: tBchNameTo,
                    /*ประเภทบัตร*/
                    tCardTypeCodeFrom: tCardTypeCodeFrom,
                    tCardTypeCodeTo: tCardTypeCodeTo,
                    tCardTypeNameFrom: tCardTypeNameFrom,
                    tCardTypeNameTo: tCardTypeNameTo,
                    /*ประเภทบัตรเดิม*/
                    tCardTypeCodeOldFrom: tCardTypeCodeOldFrom,
                    tCardTypeCodeOldTo: tCardTypeCodeOldTo,
                    tCardTypeNameOldFrom: tCardTypeNameOldFrom,
                    tCardTypeNameOldTo: tCardTypeNameOldTo,
                    /*ประเภทบัตรใหม่*/
                    tCardTypeCodeNewFrom: tCardTypeCodeNewFrom,
                    tCardTypeCodeNewTo: tCardTypeCodeNewTo,
                    tCardTypeNameNewFrom: tCardTypeNameNewFrom,
                    tCardTypeNameNewTo: tCardTypeNameNewTo,
                    /*เลขเครื่องจุดขาย*/
                    tPosCodeFrom: tPosCodeFrom,
                    tPosCodeTo: tPosCodeTo,
                    /*เลขขัตร*/
                    tCardCodeFrom: tCardCodeFrom,
                    tCardCodeTo: tCardCodeTo,
                    /*รหัสพนักงาน*/
                    tEmpCodeFrom: tEmpCodeFrom,
                    tEmpCodeTo: tEmpCodeTo,
                    /*สถานะบัตร*/
                    tStaCardFrom: tStaCardFrom,
                    tStaCardTo: tStaCardTo,
                    /*เลขขัตรเก่า*/
                    tCardCodeOldFrom: tCardCodeOldFrom,
                    tCardCodeOldTo: tCardCodeOldTo,
                    /*เลขขัตรใหม่*/
                    tCardCodeNewFrom: tCardCodeNewFrom,
                    tCardCodeNewTo: tCardCodeNewTo,
                    /*วันที่*/
                    tDocDateFrom: tDocDateFrom,
                    tDocDateTo: tDocDateTo,
                    /*วันที่เริ่มต้น*/
                    tDateStartFrom: tDateStartFrom,
                    tDateStartTo: tDateStartTo,
                    /*วันที่เริ่มต้น*/
                    tDateExpireFrom: tDateExpireFrom,
                    tDateExpireTo: tDateExpireTo,
                },
                cache: false,
                timeout: 0,
                async: true,
                success: function (oResult) {
                    var tMessage;
                    var aDataReturn = JSON.parse(oResult);
                    console.log('DATA: ', aDataReturn);

                    if(aDataReturn['tCountNumber'] != 0){

                        if (aDataReturn['nStaExport'] == 1) {
                            var tFileName = aDataReturn['tFileName'];
                            var tPathFolder = aDataReturn['tPathFolder'];

                            var $oObjectExport = $("<a>");
                            $oObjectExport.attr("href", tPathFolder + tFileName);
                            $("body").append($oObjectExport);
                            $oObjectExport.attr("download", tFileName);
                            $oObjectExport[0].click();
                            $oObjectExport.remove();
                        } else if (aDataReturn['nStaExport'] == 800) {
                            tMessage = aDataReturn['tMessage'];
                            FSvCMNSetMsgWarningDialog(tMessage);
                        } else {
                            tMessage = aDataReturn['tMessage'];
                            FSvCMNSetMsgErrorDialog(tMessage);
                        }
                        JCNxCloseLoading();

                    }else{
                        JCNxCloseLoading();
                        FSvCMNSetMsgWarningDialog(aDataReturn['tMsgReportNotFound']);
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            tMessage = 'กรุณาเลือกรายงาน';
            FSvCMNSetMsgWarningDialog(tMessage)
        }
    }
    
    //Function: ฟังก์ชั่นเรียกใช้งาน Check Export Excel
	//Parameters:  Function Condition Parameter
    //Creator: 13/06/2019 Piya 
    //Return : Downlond File Excel
    //Return Type: -
    function JSvCheckExportExcel() {
        try{
            JCNxOpenLoading();

            var tRPCCode = $('#ohdSelectRPCCode').val();

            var tYearCodeFrom = $('#oetRPCYearCode').val();
            var tYearCodeTo = $('#oetRPCYearCodeTo').val();

            var tBchCodeFrom = $('#oetRPCBchCode').val();
            var tBchNameFrom = $('#oetRPCBchName').val();
            var tBchCodeTo = $('#oetRPCBchCodeTo').val();
            var tBchNameTo = $('#oetRPCBchNameTo').val();

            var tCardTypeCodeFrom = $('#oetRPCCardTypeCode').val();
            var tCardTypeCodeTo = $('#oetRPCCardTypeCodeTo').val();
            var tCardTypeNameFrom = $('#oetRPCCardTypeName').val();
            var tCardTypeNameTo = $('#oetRPCCardTypeNameTo').val();

            var tCardTypeCodeOldFrom = $('#oetRPCCardTypeCodeOld').val();
            var tCardTypeCodeOldTo = $('#oetRPCCardTypeCodeOldTo').val();
            var tCardTypeNameOldFrom = $('#oetRPCCardTypeNameOld').val();
            var tCardTypeNameOldTo = $('#oetRPCCardTypeNameOldTo').val();

            var tCardTypeCodeNewFrom = $('#oetRPCCardTypeCodeNew').val();
            var tCardTypeCodeNewTo = $('#oetRPCCardTypeCodeNewTo').val();
            var tCardTypeNameNewFrom = $('#oetRPCCardTypeNameNew').val();
            var tCardTypeNameNewTo = $('#oetRPCCardTypeNameNewTo').val();

            var tPosCodeFrom = $('#oetRPCPosCode').val();
            var tPosCodeTo = $('#oetRPCPosCodeTo').val();

            var tCardCodeFrom = $('#oetRPCCardCode').val();
            var tCardCodeTo = $('#oetRPCCardCodeTo').val();

            var tEmpCodeFrom = $('#oetRPCEmpCode').val();
            var tEmpCodeTo = $('#oetRPCEmpCodeTo').val();

            var tStaCardFrom = $('#ocmRPCStaCard').val();
            var tStaCardTo = $('#ocmRPCStaCardTo').val();

            var tCardCodeOldFrom = $('#oetRPCCardCodeOld').val();
            var tCardCodeOldTo = $('#oetRPCCardCodeOldTo').val();

            var tCardCodeNewFrom = $('#oetRPCCardCodeNew').val();
            var tCardCodeNewTo = $('#oetRPCCardCodeNewTo').val();

            var tDocDateFrom = $('#oetRPCDocDate').val();
            var tDocDateTo = $('#oetRPCDocDateTo').val();

            var tDateStartFrom = $('#oetRPCDateStart').val();
            var tDateStartTo = $('#oetRPCDateStartTo').val();

            var tDateExpireFrom = $('#oetRPCDateExpire').val();
            var tDateExpireTo = $('#oetRPCDateExpireTo').val();

            if (tRPCCode != '') {
                $.ajax({
                    type: "POST",
                    url: "RPTCRDChkData" + tRPCCode,
                    data: {
                        tRPCCode: tRPCCode,
                        /*ปี*/
                        tYearCodeFrom: tYearCodeFrom,
                        tYearCodeTo: tYearCodeTo,
                        /*สาขา*/
                        tBchCodeFrom: tBchCodeFrom,
                        tBchNameFrom: tBchNameFrom,
                        tBchCodeTo: tBchCodeTo,
                        tBchNameTo: tBchNameTo,
                        /*ประเภทบัตร*/
                        tCardTypeCodeFrom: tCardTypeCodeFrom,
                        tCardTypeCodeTo: tCardTypeCodeTo,
                        tCardTypeNameFrom: tCardTypeNameFrom,
                        tCardTypeNameTo: tCardTypeNameTo,
                        /*ประเภทบัตรเดิม*/
                        tCardTypeCodeOldFrom: tCardTypeCodeOldFrom,
                        tCardTypeCodeOldTo: tCardTypeCodeOldTo,
                        tCardTypeNameOldFrom: tCardTypeNameOldFrom,
                        tCardTypeNameOldTo: tCardTypeNameOldTo,
                        /*ประเภทบัตรใหม่*/
                        tCardTypeCodeNewFrom: tCardTypeCodeNewFrom,
                        tCardTypeCodeNewTo: tCardTypeCodeNewTo,
                        tCardTypeNameNewFrom: tCardTypeNameNewFrom,
                        tCardTypeNameNewTo: tCardTypeNameNewTo,
                        /*เลขเครื่องจุดขาย*/
                        tPosCodeFrom: tPosCodeFrom,
                        tPosCodeTo: tPosCodeTo,
                        /*เลขขัตร*/
                        tCardCodeFrom: tCardCodeFrom,
                        tCardCodeTo: tCardCodeTo,
                        /*รหัสพนักงาน*/
                        tEmpCodeFrom: tEmpCodeFrom,
                        tEmpCodeTo: tEmpCodeTo,
                        /*สถานะบัตร*/
                        tStaCardFrom: tStaCardFrom,
                        tStaCardTo: tStaCardTo,
                        /*เลขขัตรเก่า*/
                        tCardCodeOldFrom: tCardCodeOldFrom,
                        tCardCodeOldTo: tCardCodeOldTo,
                        /*เลขขัตรใหม่*/
                        tCardCodeNewFrom: tCardCodeNewFrom,
                        tCardCodeNewTo: tCardCodeNewTo,
                        /*วันที่*/
                        tDocDateFrom: tDocDateFrom,
                        tDocDateTo: tDocDateTo,
                        /*วันที่เริ่มต้น*/
                        tDateStartFrom: tDateStartFrom,
                        tDateStartTo: tDateStartTo,
                        /*วันที่เริ่มต้น*/
                        tDateExpireFrom: tDateExpireFrom,
                        tDateExpireTo: tDateExpireTo,
                    },
                    async: true,
                    cache: false,
                    timeout: 0,
                    success: function (oResult) {
                        var aDataReturn = JSON.parse(oResult);
                        console.log(aDataReturn['tCountNumber']);
                        if(aDataReturn['tCountNumber'] != 0){
                            if(aDataReturn['tCountNumber'] <= 100000){
                                JCNxExportExcelReport();
                            }else{
                                JCNxCloseLoading();
                                FSxCMNSetMsgReporExceltConfirmMessageDialog(aDataReturn['tCountNumber'], 'JCNxExportExcelReport()');
                            }
                        }else{
                            JCNxCloseLoading();
                            FSvCMNSetMsgWarningDialog(aDataReturn['tMsgReportNotFound']);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                tMessage = 'กรุณาเลือกรายงาน';
                FSvCMNSetMsgWarningDialog(tMessage);
            }
        }catch(err){
            console.log('JSvCheckExportExcel Error: ', err);
        }    
    }
    
    //Function: ฟังก์ชั่นเรียกใช้งาน Export Excel
	//Parameters:  Function Condition Parameter
    //Creator: 13/06/2019 Piya 
    //Return : Downlond File Excel
    //Return Type: -
    function JCNxExportExcelReport(){
        try{
            $("#odvOverLayContentForLongTimeLoading").css("display", "block");
            var tRPCCode = $('#ohdSelectRPCCode').val();

            var tYearCodeFrom = $('#oetRPCYearCode').val();
            var tYearCodeTo = $('#oetRPCYearCodeTo').val();

            var tBchCodeFrom = $('#oetRPCBchCode').val();
            var tBchNameFrom = $('#oetRPCBchName').val();
            var tBchCodeTo = $('#oetRPCBchCodeTo').val();
            var tBchNameTo = $('#oetRPCBchNameTo').val();

            var tCardTypeCodeFrom = $('#oetRPCCardTypeCode').val();
            var tCardTypeCodeTo = $('#oetRPCCardTypeCodeTo').val();
            var tCardTypeNameFrom = $('#oetRPCCardTypeName').val();
            var tCardTypeNameTo = $('#oetRPCCardTypeNameTo').val();

            var tCardTypeCodeOldFrom = $('#oetRPCCardTypeCodeOld').val();
            var tCardTypeCodeOldTo = $('#oetRPCCardTypeCodeOldTo').val();
            var tCardTypeNameOldFrom = $('#oetRPCCardTypeNameOld').val();
            var tCardTypeNameOldTo = $('#oetRPCCardTypeNameOldTo').val();

            var tCardTypeCodeNewFrom = $('#oetRPCCardTypeCodeNew').val();
            var tCardTypeCodeNewTo = $('#oetRPCCardTypeCodeNewTo').val();
            var tCardTypeNameNewFrom = $('#oetRPCCardTypeNameNew').val();
            var tCardTypeNameNewTo = $('#oetRPCCardTypeNameNewTo').val();

            var tPosCodeFrom = $('#oetRPCPosCode').val();
            var tPosCodeTo = $('#oetRPCPosCodeTo').val();

            var tCardCodeFrom = $('#oetRPCCardCode').val();
            var tCardCodeTo = $('#oetRPCCardCodeTo').val();

            var tEmpCodeFrom = $('#oetRPCEmpCode').val();
            var tEmpCodeTo = $('#oetRPCEmpCodeTo').val();

            var tStaCardFrom = $('#ocmRPCStaCard').val();
            var tStaCardTo = $('#ocmRPCStaCardTo').val();

            var tCardCodeOldFrom = $('#oetRPCCardCodeOld').val();
            var tCardCodeOldTo = $('#oetRPCCardCodeOldTo').val();

            var tCardCodeNewFrom = $('#oetRPCCardCodeNew').val();
            var tCardCodeNewTo = $('#oetRPCCardCodeNewTo').val();

            var tDocDateFrom = $('#oetRPCDocDate').val();
            var tDocDateTo = $('#oetRPCDocDateTo').val();

            var tDateStartFrom = $('#oetRPCDateStart').val();
            var tDateStartTo = $('#oetRPCDateStartTo').val();

            var tDateExpireFrom = $('#oetRPCDateExpire').val();
            var tDateExpireTo = $('#oetRPCDateExpireTo').val();


            if (tRPCCode != '') {

                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "RPTCRDExportExcel" + tRPCCode,
                    data: {
                        tRPCCode: tRPCCode,
                        /*ปี*/
                        tYearCodeFrom: tYearCodeFrom,
                        tYearCodeTo: tYearCodeTo,
                        /*สาขา*/
                        tBchCodeFrom: tBchCodeFrom,
                        tBchNameFrom: tBchNameFrom,
                        tBchCodeTo: tBchCodeTo,
                        tBchNameTo: tBchNameTo,
                        /*ประเภทบัตร*/
                        tCardTypeCodeFrom: tCardTypeCodeFrom,
                        tCardTypeCodeTo: tCardTypeCodeTo,
                        tCardTypeNameFrom: tCardTypeNameFrom,
                        tCardTypeNameTo: tCardTypeNameTo,
                        /*ประเภทบัตรเดิม*/
                        tCardTypeCodeOldFrom: tCardTypeCodeOldFrom,
                        tCardTypeCodeOldTo: tCardTypeCodeOldTo,
                        tCardTypeNameOldFrom: tCardTypeNameOldFrom,
                        tCardTypeNameOldTo: tCardTypeNameOldTo,
                        /*ประเภทบัตรใหม่*/
                        tCardTypeCodeNewFrom: tCardTypeCodeNewFrom,
                        tCardTypeCodeNewTo: tCardTypeCodeNewTo,
                        tCardTypeNameNewFrom: tCardTypeNameNewFrom,
                        tCardTypeNameNewTo: tCardTypeNameNewTo,
                        /*เลขเครื่องจุดขาย*/
                        tPosCodeFrom: tPosCodeFrom,
                        tPosCodeTo: tPosCodeTo,
                        /*เลขขัตร*/
                        tCardCodeFrom: tCardCodeFrom,
                        tCardCodeTo: tCardCodeTo,
                        /*รหัสพนักงาน*/
                        tEmpCodeFrom: tEmpCodeFrom,
                        tEmpCodeTo: tEmpCodeTo,
                        /*สถานะบัตร*/
                        tStaCardFrom: tStaCardFrom,
                        tStaCardTo: tStaCardTo,
                        /*เลขขัตรเก่า*/
                        tCardCodeOldFrom: tCardCodeOldFrom,
                        tCardCodeOldTo: tCardCodeOldTo,
                        /*เลขขัตรใหม่*/
                        tCardCodeNewFrom: tCardCodeNewFrom,
                        tCardCodeNewTo: tCardCodeNewTo,
                        /*วันที่*/
                        tDocDateFrom: tDocDateFrom,
                        tDocDateTo: tDocDateTo,
                        /*วันที่เริ่มต้น*/
                        tDateStartFrom: tDateStartFrom,
                        tDateStartTo: tDateStartTo,
                        /*วันที่เริ่มต้น*/
                        tDateExpireFrom: tDateExpireFrom,
                        tDateExpireTo: tDateExpireTo,
                    },
                    cache: false,
                    timeout: 0,
                    async: true,
                    success: function (oResult) {
                        var tMessage;
                        var aDataReturn = JSON.parse(oResult);
                        console.log('DATA: ', aDataReturn);

                        if (aDataReturn['nStaExport'] == 1) {
                            var tFileName = aDataReturn['tFileName'];
                            var tPathFolder = aDataReturn['tPathFolder'];

                            var $oObjectExport = $("<a>");
                            $oObjectExport.attr("href", tPathFolder + tFileName);
                            $("body").append($oObjectExport);
                            $oObjectExport.attr("download", tFileName);
                            $oObjectExport[0].click();
                            $oObjectExport.remove();
                        } else if (aDataReturn['nStaExport'] == 800) {
                            tMessage = aDataReturn['tMessage'];
                            FSvCMNSetMsgWarningDialog(tMessage);
                        } else {
                            tMessage = aDataReturn['tMessage'];
                            FSvCMNSetMsgErrorDialog(tMessage);
                        }
                        JCNxCloseLoading();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                tMessage = 'กรุณาเลือกรายงาน';
                FSvCMNSetMsgWarningDialog(tMessage);
            }
        }catch(err){
            console.log('JCNxExportExcelReport Error: ', err);
        }
    }
    
    //Option Year เฉพาะ รายงานรายการต้นงวดบัตรและเงินสด
    var oRPCBrowseYear = {

        Title: ['common/main', 'tCMNYear'],
        Table: {Master: 'VCN_TFCTCrdPrinciple', PK: 'FTTxnYear'},
        Where: {
            Condition: [" AND VCN_TFCTCrdPrinciple.FNCtyLngID = " + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'common/main',
            ColumnKeyLang: ['tCMNYear'],
            ColumnsSize: ['100%'],
            WidthModal: 50,
            DataColumns: ['VCN_TFCTCrdPrinciple.FTTxnYear'],
            DataColumnsFormat: ['', ''],
            Perpage: 20,
            OrderBy: ['TCNMBranch_L.FTBchName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            StaSingItem: '1',
            Value: ["oetRPCYearCode", "VCN_TFCTCrdPrinciple.FTTxnYear"],
            Text: ["oetRPCYearName", "VCN_TFCTCrdPrinciple.FTTxnYear"],
        },
        RouteFrom: 'RPTCRD/0/0',
        RouteAddNew: '',
        BrowseLev: 1,
        DebugSQL: true
    };
//End Option Year เฉพาะ รายงานรายการต้นงวดบัตรและเงินสด

//Option Year To เฉพาะ รายงานรายการต้นงวดบัตรและเงินสด
    var oRPCBrowseYearTo = {

        Title: ['common/main', 'tCMNYear'],
        Table: {Master: 'VCN_TFCTCrdPrinciple', PK: 'FTTxnYear'},
        Where: {
            Condition: [" AND VCN_TFCTCrdPrinciple.FNCtyLngID = " + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'common/main',
            ColumnKeyLang: ['tCMNYear'],
            ColumnsSize: ['100%'],
            WidthModal: 50,
            DataColumns: ['VCN_TFCTCrdPrinciple.FTTxnYear'],
            DataColumnsFormat: ['', ''],
            Perpage: 20,
            OrderBy: ['TCNMBranch_L.FTBchName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            StaSingItem: '1',
            Value: ["oetRPCYearCodeTo", "VCN_TFCTCrdPrinciple.FTTxnYear"],
            Text: ["oetRPCYearNameTo", "VCN_TFCTCrdPrinciple.FTTxnYear"],
        },
        RouteFrom: 'RPTCRD/0/0',
        RouteAddNew: '',
        BrowseLev: 1
    };
//End Option Year To เฉพาะ รายงานรายการต้นงวดบัตรและเงินสด


//Option Branch
    var oRPCBrowseBranch = {

        Title: ['pos5/branch', 'tBCHTitle'],
        Table: {Master: 'TCNMBranch', PK: 'FTBchCode'},
        Join: {
            Table: ['TCNMBranch_L'],
            On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits, ]
        },
        GrideView: {
            ColumnPathLang: 'pos5/branch',
            ColumnKeyLang: ['tBCHCode', 'tBCHName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
            DataColumnsFormat: ['', ''],
            Perpage: 5,
            OrderBy: ['TCNMBranch.FTBchCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCBchCode", "TCNMBranch.FTBchCode"],
            Text: ["oetRPCBchName", "TCNMBranch_L.FTBchName"],
        },
        RouteFrom: 'RPTCRD/0/0',
        RouteAddNew: 'branch',
        BrowseLev: 1
    };
//End Option Branch

//Option Branch To
    var oRPCBrowseBranchTo = {

        Title: ['pos5/branch', 'tBCHTitle'],
        Table: {Master: 'TCNMBranch', PK: 'FTBchCode'},
        Join: {
            Table: ['TCNMBranch_L'],
            On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits, ]
        },
        GrideView: {
            ColumnPathLang: 'pos5/branch',
            ColumnKeyLang: ['tBCHCode', 'tBCHName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
            DataColumnsFormat: ['', ''],
            Perpage: 5,
            OrderBy: ['TCNMBranch.FTBchCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCBchCodeTo", "TCNMBranch.FTBchCode"],
            Text: ["oetRPCBchNameTo", "TCNMBranch_L.FTBchName"],
        },
        RouteFrom: 'RPTCRD/0/0',
        RouteAddNew: 'branch',
        BrowseLev: 1
    };
//End Option Branch To

//Option Card Type
    var oRPCBrowseCardType = {
        Title: ['pos5/cardtype', 'tCTYTitle'],
        Table: {Master: 'TFNMCardType', PK: 'FTCtyCode'},
        Join: {
            Table: ['TFNMCardType_L'],
            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdits]
        },
        Where: {
            // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
        },
        GrideView: {
            ColumnPathLang: 'pos5/cardtype',
            ColumnKeyLang: ['tCTYCode', 'tCTYName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 5,
            OrderBy: ['TFNMCardType.FTCtyCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetRPCCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        RouteAddNew: 'cardtype',
        BrowseLev: 1
    };
//End Option Card Type

//Option Card Type To
    var oRPCBrowseCardTypeTo = {
        Title: ['pos5/cardtype', 'tCTYTitle'],
        Table: {Master: 'TFNMCardType', PK: 'FTCtyCode'},
        Join: {
            Table: ['TFNMCardType_L'],
            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdits]
        },
        Where: {
            // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
        },
        GrideView: {
            ColumnPathLang: 'pos5/cardtype',
            ColumnKeyLang: ['tCTYCode', 'tCTYName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 5,
            OrderBy: ['TFNMCardType.FTCtyCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardTypeCodeTo", "TFNMCardType.FTCtyCode"],
            Text: ["oetRPCCardTypeNameTo", "TFNMCardType_L.FTCtyName"]
        },
        RouteAddNew: 'cardtype',
        BrowseLev: 1
    };
//End Option Card Type To

//Option Card Type Old
    var oRPCBrowseCardTypeOld = {
        Title: ['pos5/cardtype', 'tCTYTitle'],
        Table: {Master: 'TFNMCardType', PK: 'FTCtyCode'},
        Join: {
            Table: ['TFNMCardType_L'],
            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdits]
        },
        Where: {
            // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
        },
        GrideView: {
            ColumnPathLang: 'pos5/cardtype',
            ColumnKeyLang: ['tCTYCode', 'tCTYName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 5,
            OrderBy: ['TFNMCardType.FTCtyCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardTypeCodeOld", "TFNMCardType.FTCtyCode"],
            Text: ["oetRPCCardTypeNameOld", "TFNMCardType_L.FTCtyName"]
        },
        RouteAddNew: 'cardtype',
        BrowseLev: 1
    };
//End Option Card Type Old

//Option Card Type Old To
    var oRPCBrowseCardTypeOldTo = {
        Title: ['pos5/cardtype', 'tCTYTitle'],
        Table: {Master: 'TFNMCardType', PK: 'FTCtyCode'},
        Join: {
            Table: ['TFNMCardType_L'],
            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdits]
        },
        Where: {
            // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
        },
        GrideView: {
            ColumnPathLang: 'pos5/cardtype',
            ColumnKeyLang: ['tCTYCode', 'tCTYName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 5,
            OrderBy: ['TFNMCardType.FTCtyCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardTypeCodeOldTo", "TFNMCardType.FTCtyCode"],
            Text: ["oetRPCCardTypeNameOldTo", "TFNMCardType_L.FTCtyName"]
        },
        RouteAddNew: 'cardtype',
        BrowseLev: 1
    };
//End Option Card Type Old To

//Option Card Type Old
    var oRPCBrowseCardTypeNew = {
        Title: ['pos5/cardtype', 'tCTYTitle'],
        Table: {Master: 'TFNMCardType', PK: 'FTCtyCode'},
        Join: {
            Table: ['TFNMCardType_L'],
            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdits]
        },
        Where: {
            // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
        },
        GrideView: {
            ColumnPathLang: 'pos5/cardtype',
            ColumnKeyLang: ['tCTYCode', 'tCTYName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 5,
            OrderBy: ['TFNMCardType.FTCtyCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardTypeCodeNew", "TFNMCardType.FTCtyCode"],
            Text: ["oetRPCCardTypeNameNew", "TFNMCardType_L.FTCtyName"]
        },
        RouteAddNew: 'cardtype',
        BrowseLev: 1
    };
//End Option Card Type New

//Option Card Type New To
    var oRPCBrowseCardTypeNewTo = {
        Title: ['pos5/cardtype', 'tCTYTitle'],
        Table: {Master: 'TFNMCardType', PK: 'FTCtyCode'},
        Join: {
            Table: ['TFNMCardType_L'],
            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdits]
        },
        Where: {
            // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
        },
        GrideView: {
            ColumnPathLang: 'pos5/cardtype',
            ColumnKeyLang: ['tCTYCode', 'tCTYName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 5,
            OrderBy: ['TFNMCardType.FTCtyCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardTypeCodeNewTo", "TFNMCardType.FTCtyCode"],
            Text: ["oetRPCCardTypeNameNewTo", "TFNMCardType_L.FTCtyName"]
        },
        RouteAddNew: 'cardtype',
        BrowseLev: 1
    };
//End Option Card Type New To

//Option Card
    var oRPCBrowseCard = {
        Title: ['pos5/card', 'tCRDTitle'],
        Table: {Master: 'TFNMCard', PK: 'FTCrdCode'},
        Join: {
            Table: ['TFNMCard_L'],
            On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'pos5/card',
            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 500,
            OrderBy: ['TFNMCard.FTCrdCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardCode", "TFNMCard.FTCrdCode"],
            Text: ["oetRPCCardName", "TFNMCard_L.FTCrdCode"]
        },
        RouteAddNew: 'card',
        BrowseLev: 1
    };
//End Option Card

//Option Card To
    var oRPCBrowseCardTo = {
        Title: ['pos5/card', 'tCRDTitle'],
        Table: {Master: 'TFNMCard', PK: 'FTCrdCode'},
        Join: {
            Table: ['TFNMCard_L'],
            On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'pos5/card',
            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 500,
            OrderBy: ['TFNMCard.FTCrdCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardCodeTo", "TFNMCard.FTCrdCode"],
            Text: ["oetRPCCardNameTo", "TFNMCard_L.FTCrdCode"]
        },
        RouteAddNew: 'card',
        BrowseLev: 1
    };
//End Option Card To


//Option Card Old
    var oRPCBrowseCardOld = {
        Title: ['pos5/card', 'tCRDTitle'],
        Table: {Master: 'TFNMCard', PK: 'FTCrdCode'},
        Join: {
            Table: ['TFNMCard_L'],
            On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'pos5/card',
            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 500,
            OrderBy: ['TFNMCard.FTCrdCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardCodeOld", "TFNMCard.FTCrdCode"],
            Text: ["oetRPCCardNameOld", "TFNMCard_L.FTCrdCode"]
        },
        RouteAddNew: 'card',
        BrowseLev: 1
    };
//End Option Card Old

//Option Card To Old
    var oRPCBrowseCardOldTo = {
        Title: ['pos5/card', 'tCRDTitle'],
        Table: {Master: 'TFNMCard', PK: 'FTCrdCode'},
        Join: {
            Table: ['TFNMCard_L'],
            On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'pos5/card',
            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 500,
            OrderBy: ['TFNMCard.FTCrdCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardCodeOldTo", "TFNMCard.FTCrdCode"],
            Text: ["oetRPCCardNameOldTo", "TFNMCard_L.FTCrdCode"]
        },
        RouteAddNew: 'card',
        BrowseLev: 1
    };
//End Option Card To Old

//Option Card Old
    var oRPCBrowseCardNew = {
        Title: ['pos5/card', 'tCRDTitle'],
        Table: {Master: 'TFNMCard', PK: 'FTCrdCode'},
        Join: {
            Table: ['TFNMCard_L'],
            On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'pos5/card',
            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 500,
            OrderBy: ['TFNMCard.FTCrdCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardCodeNew", "TFNMCard.FTCrdCode"],
            Text: ["oetRPCCardNameNew", "TFNMCard_L.FTCrdCode"]
        },
        RouteAddNew: 'card',
        BrowseLev: 1
    };
//End Option Card Old

//Option Card To Old
    var oRPCBrowseCardToNew = {
        Title: ['pos5/card', 'tCRDTitle'],
        Table: {Master: 'TFNMCard', PK: 'FTCrdCode'},
        Join: {
            Table: ['TFNMCard_L'],
            On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'pos5/card',
            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 500,
            OrderBy: ['TFNMCard.FTCrdCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRPCCardCodeNewTo", "TFNMCard.FTCrdCode"],
            Text: ["oetRPCCardNameNewTo", "TFNMCard_L.FTCrdCode"]
        },
        RouteAddNew: 'card',
        BrowseLev: 1
    };
//End Option Card To Old


//Option Pos
    var oRPCBrowsePos = {
        Title: ['pos5/shop', 'tSHPTitle'],
        Table: {Master: 'TCNMShop', PK: 'FTShpCode'},
        Join: {
            Table: ['TCNMShop_L'],
            On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'pos5/shop',
            ColumnKeyLang: ['tSHPTBCode', 'tSHPTBName', ''],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 500,
            OrderBy: ['TCNMShop.FTShpCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            StaSingItem: '1',
            Value: ["oetRPCPosCode", "TCNMShop.FTShpCode"],
            Text: ["oetRPCPosName", "TCNMShop.FTShpCode"]
        }
    };
//End Option Pos


//Option Pos To
    var oRPCBrowsePosTo = {
        Title: ['pos5/shop', 'tSHPTitle'],
        Table: {Master: 'TCNMShop', PK: 'FTShpCode'},
        Join: {
            Table: ['TCNMShop_L'],
            On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'pos5/shop',
            ColumnKeyLang: ['tSHPTBCode', 'tSHPTBName', ''],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 500,
            OrderBy: ['TCNMShop.FTShpCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            StaSingItem: '1',
            Value: ["oetRPCPosCodeTo", "TCNMShop.FTShpCode"],
            Text: ["oetRPCPosNameTo", "TCNMShop.FTShpCode"]
        }
    };
//End Option Pos To


//Year Rpt 10
    $('#oimRPCBrowseYear').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseYear');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#oimRPCBrowseYearTo').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseYearTo');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

//Branch
    $('#oimRPCBrowseBranch').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseBranch');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#oimRPCBrowseBranchTo').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseBranchTo');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

//Card Type
    $('#oimRPCBrowseCardType').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCardType');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#oimRPCBrowseCardTypeTo').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCardTypeTo');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

//Card Type Old
    $('#oimRPCBrowseCardTypeOld').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCardTypeOld');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#oimRPCBrowseCardTypeOldTo').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCardTypeOldTo');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

//Card Type New
    $('#oimRPCBrowseCardTypeNew').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCardTypeNew');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#oimRPCBrowseCardTypeNewTo').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCardTypeNewTo');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

//POS
    $('#oimRPCBrowsePos').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowsePos');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#oimRPCBrowsePosTo').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowsePosTo');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

//Card
    $('#oimRPCBrowseCard').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCard');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#oimRPCBrowseCardTo').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCardTo');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

//Card Old
    $('#oimRPCBrowseCardOld').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCardOld');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#oimRPCBrowseCardOldTo').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCardOldTo');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

//Card New
    $('#oimRPCBrowseCardNew').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCardNew');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#oimRPCBrowseCardToNew').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxBrowseData('oRPCBrowseCardToNew');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    /** Option Browse Employee */
    var oRPCBrowseEmp = function (poReturnInput) {
        // Input Code/Name Return
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        // Option Modal Browse
        var oOptionReturn = {
            Title: ['pos5/card', 'tCRDHolderIDTiltle'],
            Table: {Master: 'TFNMCard', PK: 'FTCrdHolderID'},
            GrideView: {
                ColumnPathLang: 'pos5/card',
                ColumnKeyLang: ['tCRDHolderIDCode', ],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TFNMCard.FTCrdHolderID'],
                DisabledColumns: [],
                DataColumnsFormat: ['', ''],
                Perpage: 500,
                OrderBy: ['TFNMCard.FTCrdHolderID'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                StaSingItem: '1',
                Value: [tInputReturnCode, "TFNMCard.FTCrdHolderID"],
                Text: [tInputReturnName, "TFNMCard.FTCrdHolderID"]
            },
            RouteAddNew: '',
            BrowseLev: 1
            // DebugSQL : true
        };
        return oOptionReturn;
    };

//Employee From
    $('#oimRPCBrowseEmp').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            window.oRPCBrowseEmpOption = oRPCBrowseEmp({
                'tReturnInputCode': 'oetRPCEmpCode',
                'tReturnInputName': 'oetRPCEmpName'
            });
            JCNxBrowseData('oRPCBrowseEmpOption');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

//Employee To
    $('#oimRPCBrowseEmpTo').click(function (event) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
            window.oRPCBrowseEmpOption = oRPCBrowseEmp({
                'tReturnInputCode': 'oetRPCEmpCodeTo',
                'tReturnInputName': 'oetRPCEmpNameTo'
            });
            JCNxBrowseData('oRPCBrowseEmpOption');
            event.preventDefault();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

</script>
<script src="<?= base_url('application/assets/src/jReportcard.js') ?>"></script>




















