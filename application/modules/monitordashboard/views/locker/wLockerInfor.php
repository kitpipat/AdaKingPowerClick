<link rel="stylesheet" href="<?php echo base_url();?>application/modules/monitordashboard/assets/css/globalcss/adaMDGeneral.css">
<style type= text/css>
    .xWTopicMenu {
        font-weight: bold;
        font-size: 30px !important;
    }

    .xWFrameBoxPanel{
        border: 1px solid #ccc;
        margin-top:30px;
    }
</style>
<input type="hidden" id="ohdDLKBaseURL"  name="ohdDLKBaseURL"   value="<?php echo base_url();?>">
<input type="hidden" id="ohdDLKLangEdit" name="ohdDLKLangEdit"  value="<?php echo $this->session->userdata("tLangEdit");?>">
<div class="container-fluid xCNPadding-20px">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <label class="xWTopicMenu"><?php echo language('monitordashboard/locker/dashboardlocker','tDLKTitleMenu');?></label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-right">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="xCNDisplay-inline-block">
                        <label class="xCNMargin-bottom-0px">
                            <?php echo language('monitordashboard/locker/dashboardlocker','tDLKDateData');?>
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="xWTopicChoice-DateBox xCNWidth-100per">
                        <div class="input-group xCNWidth-100per">
                            <input type="text" id="oetDateFillter" class="form-control xCNDatePicker xCNInputMaskDate xCNInput-Text" readonly value="<?php echo date("Y-m-d");?>">
                        </div>    
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                    <div class="xWTopicChoice-SelectBox">
                        <select class="selectpicker form-control" tabindex="-98" id="ocmWriteGraphCompare" name="ocmWriteGraphCompare" readonly>
                            <option value="1"><?php echo language('monitordashboard/locker/dashboardlocker','tDLKGraphInfoSale');?></option>
                            <option value="2"><?php echo language('monitordashboard/locker/dashboardlocker','tDLKGraphInventory');?></option>
                            <option value="3"><?php echo language('monitordashboard/locker/dashboardlocker','tDLKGraphVedding');?></option>
                            <option value="4"><?php echo language('monitordashboard/locker/dashboardlocker','tDLKGraphInventoryVD');?></option>
                            <option value="5" selected><?php echo language('monitordashboard/locker/dashboardlocker','tDLKGraphLocker');?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row panel xCNMargin-top-30px xCNPadding-bottom-10">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="row xCNClearMarginRow xWFrameBoxPanel xCNPadding-20px">
                <form id="ofmDLKFilterCodtion" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                    <div>
                        <label class=""><?php echo language('monitordashboard/locker/dashboardlocker','tDLKCoditionFilter');?></label>
                    </div>
                    <div class="form-group xCNWidth-100per">
                        <div class='input-group'>
                            <input type="text" class="form-control xCNHide xWInputBranch" id="oetDLKBchCodeOld"   name="oetDLKBchCodeOld" maxlength="5">
                            <input type="text" class="form-control xCNHide xWInputBranch" id="oetDLKBchCode"      name="oetDLKBchCode"    maxlength="5">
                            <input
                                type="text"
                                class="form-control xWPointerEventNone xWInputBranch"
                                id="oetDLKBchName"
                                name="oetDLKBchName"
                                placeholder="<?php echo language('monitordashboard/locker/dashboardlocker','tDLKFilterBranchPHD');?>"
                                data-validate-required="<?php echo language('monitordashboard/locker/dashboardlocker','tDLKFilterBranchVLD');?>"
                                readonly
                            >
                            <span class='input-group-btn'>
                                <button id='obtDLKBrowseBranch' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group xCNWidth-100per">
                        <div class='input-group'>
                            <input type="text" class="form-control xCNHide xWInputMerchant" id="oetDLKMerCodeOld" name="oetDLKMerCodeOld" maxlength="5">
                            <input type="text" class="form-control xCNHide xWInputMerchant" id="oetDLKMerCode" name="oetDLKMerCode" maxlength="5">
                            <input
                                type="text"
                                class="form-control xWPointerEventNone xWInputMerchant"
                                id="oetDLKMerName"
                                name="oetDLKMerName"
                                placeholder="<?php echo language('monitordashboard/locker/dashboardlocker','tDLKFilterMerchantPHD');?>"
                                data-validate-required="<?php echo language('monitordashboard/locker/dashboardlocker','tDLKFilterMerchantVLD');?>"
                                readonly
                            >
                            <span class='input-group-btn'>
                                <button id='obtDLKBrowseMerchant' type='button' class='btn xCNBtnBrowseAddOn' disabled><img class='xCNIconFind'></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group xCNWidth-100per">
                        <div class='input-group'>
                            <input type="text" class="form-control xCNHide xWInputShop" id="oetDLKShopCode"     name="oetDLKShopCode"       maxlength="5">
                            <input
                                type="text"
                                class="form-control xWPointerEventNone xWInputShop"
                                id="oetDLKShopName"
                                name="oetDLKShopName"
                                placeholder="<?php echo language('monitordashboard/locker/dashboardlocker','tDLKFilterShopPHD');?>"
                                data-validate-required="<?php echo language('monitordashboard/locker/dashboardlocker','tDLKFilterShopVLD');?>"
                                readonly
                            >
                            <span class='input-group-btn'>
                                <button id='obtDLKBrowseShop' type='button' class='btn xCNBtnBrowseAddOn' disabled><img class='xCNIconFind'></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div id="odvDLKDataShowListPos" class="row xCNClearMarginRow xWFrameBoxPanel xCNPadding-20px">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/monitordashboard/assets/src/locker/jLokerInfor.js"></script>