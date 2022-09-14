<?php
$tUserAgnCode = '';
$tUserAgnName = '';

$tUserBchCode = '';
$tUserBchName = '';

$tUserMchCode = '';
$tUserMchName = '';

$tUserShpCode = '';
$tUserShpName = '';

if ($this->session->userdata('tSesUsrLevel') == 'BCH' || $this->session->userdata('tSesUsrLevel') == 'SHP') {
    $tUserAgnCode = $this->session->userdata('tSesUsrAgnCode');
    $tUserAgnName = $this->session->userdata('tSesUsrAgnName');

    $tUserBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
    $tUserBchName = $this->session->userdata('tSesUsrBchNameDefault');

    $tUserMchCode = $this->session->userdata('tSesUsrMerCode');
    $tUserMchName = $this->session->userdata('tSesUsrMerName');
}

if ($this->session->userdata('tSesUsrLevel') == 'SHP') {
    $tUserShpCode = $this->session->userdata('tSesUsrShpCodeDefault');
    $tUserShpName = $this->session->userdata('tSesUsrShpNameDefault');
}
?>

<div class="row">
    <div class="col-md-12 xCNPromotionStep4TablePriceGroupConditionContainer">
        <!--Section : เงื่อนไขพิเศษ - กลุ่มราคา-->
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tSpecialConditions_PriceGroup'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue">
                    <?php if (!$bIsApvOrCancel) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="xCNBTNPrimeryPlus pull-right" id="obtPromotionStep4AddPriceGroupConditionBtn" onclick="JSxPromotionStep4BrowsePriceGroup()" style="margin-bottom: 10px;">+</button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="xCNPromotionStep4TablePriceGroupCondition"></div>
                    <input type="hidden" id="ohdPromotionStep4PriceGroupCodeTmp" name="ohdPromotionStep4PriceGroupCodeTmp">
                    <input type="hidden" id="ohdPromotionStep4PriceGroupNameTmp" name="ohdPromotionStep4PriceGroupNameTmp">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 xCNPromotionStep4TableGroupBuyWithBranchConditionContainer">
        <!--Section : เงื่อนไขพิเศษ - สาขา-->
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tSpecialConditions_Branch'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue">
                    <?php if (!$bIsApvOrCancel) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="xCNBTNPrimeryPlus pull-right" id="obtPromotionStep4AddBranchConditionBtn" onclick="JSxPromotionStep4AddBchConditionPanel()" style="margin-bottom: 10px;">+</button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="xCNPromotionStep4TableBranchCondition"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 xCNPromotionStep4TableGroupBuyWithChanelConditionContainer">
        <!--Section : เงื่อนไขพิเศษ - ช่องทางการขาย-->
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tPMTChnSpc'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue">
                    <?php if (!$bIsApvOrCancel) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="xCNBTNPrimeryPlus pull-right" id="obtPromotionStep4AddChanelConditionBtn" onclick="JSxPromotionStep4AddChnConditionPanel()" style="margin-bottom: 10px;">+</button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="xCNPromotionStep4TableChanelCondition"></div>
                    <input type="hidden" id="oetPromotionStep4ChnCode" name="oetPromotionStep4ChnCode">
                    <input type="hidden" id="oetPromotionStep4ChnName" name="oetPromotionStep4ChnName">
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 xCNPromotionStep4TableCstLevConditionContainer">
        <!--Section : เงื่อนไขพิเศษ - ระดับลูกค้า-->
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tSpecialConditions_CstLev'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue">
                    <?php if (!$bIsApvOrCancel) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="xCNBTNPrimeryPlus pull-right" id="obtPromotionStep4AddCstLevConditionBtn" onclick="JSxPromotionStep4BrowseCstLev()" style="margin-bottom: 10px;">+</button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="xCNPromotionStep4TableCstLevCondition"></div>
                    <input type="hidden" id="ohdPromotionStep4CstLevCodeTmp" name="ohdPromotionStep4CstLevCodeTmp">
                    <input type="hidden" id="ohdPromotionStep4CstLevNameTmp" name="ohdPromotionStep4CstLevNameTmp">
                </div>
            </div>
        </div>
    </div>

    <!--Section : เงื่อนไขพิเศษ - โปรโมชั่นซ้อน-->
    <!-- <div class="col-md-12 xCNPromotionStep4TableGroupBuyWithPromotionOnPromotionConditionContainer">
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tSpecialConditions_PromotionOnPromotion'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue">
                    <?php if(!$bIsApvOrCancel) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="xCNBTNPrimeryPlus pull-right" id="obtPromotionStep4AddPromotionOnPromotionConditionBtn" onclick="JSxPromotionStep4AddPnpConditionPanel()" style="margin-bottom: 10px;">+</button>
                            </div>
                        </div>
                    <?php } ?>    
                    <div class="xCNPromotionStep4TablePromotionOnPromotionCondition"></div>
                    <input type="hidden" id="oetPromotionStep4PnpCode" name="oetPromotionStep4PnpCode">
                    <input type="hidden" id="oetPromotionStep4PnpName" name="oetPromotionStep4PnpName">
                </div>
            </div>
        </div>
    </div> -->

</div>

<!-- Begin Add เงื่อนไขพิเศษ - สาขา -->
<div class="modal fade col-md-4" id="odvPromotionStep4AddBchConditionPanel" style="max-width: 1500px; margin: 1.75rem auto;">
    <div class="modal-dialog" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/promotion/promotion', 'tSpecialConditions_Branch'); ?></h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="row" style="margin-bottom: 20px; margin-top: 20px;">

                    <div class="col-md-12 col-lg-12 <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                        <!-- ตัวแทนขาย Agency -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tLabel20'); ?></label>
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide xCNApvOrCanCelDisabled" id="oetPromotionStep4AgencyCode" name="oetPromotionStep4AgencyCode" maxlength="5" value="<?php echo $tUserAgnCode; ?>">
                                <input class="form-control xWPointerEventNone xCNApvOrCanCelDisabled" type="text" id="oetPromotionStep4AgencyName" name="oetPromotionStep4AgencyName" value="<?php echo $tUserAgnName; ?>" readonly>
                                <span class="input-group-btn xWConditionSearchPdt">
                                    <button id="obtPromotionStep4BrowseAgency" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
                                        <img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- ตัวแทนขาย Agency -->
                    </div>

                    <div class="col-md-12 col-lg-12">
                        <!-- จากสาขา -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tBCH'); ?></label>
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide xCNApvOrCanCelDisabled" id="oetPromotionStep4BchCode" name="oetPromotionStep4BchCode" maxlength="5" value="<?php echo $tUserBchCode; ?>">
                                <input class="form-control xWPointerEventNone xCNApvOrCanCelDisabled" type="text" id="oetPromotionStep4BchName" name="oetPromotionStep4BchName" value="<?php echo $tUserBchName; ?>" readonly>
                                <span class="input-group-btn xWConditionSearchPdt">
                                    <button id="obtPromotionStep4BrowseBch" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
                                        <img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- จากสาขา -->
                    </div>

                    <?php if ($bIsShpEnabled) { ?>
                        <div class="col-md-12 col-lg-12">
                            <!-- จากกลุ่มร้านค้า -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tLabel19'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="input100 xCNHide xCNApvOrCanCelDisabled" id="oetPromotionStep4MerchantCode" name="oetPromotionStep4MerchantCode" maxlength="5" value="<?php echo $tUserMchCode; ?>">
                                    <input class="form-control xWPointerEventNone xCNApvOrCanCelDisabled" type="text" id="oetPromotionStep4MerchantName" name="oetPromotionStep4MerchantName" value="<?php echo $tUserMchName; ?>" readonly>
                                    <span class="input-group-btn xWConditionSearchPdt">
                                        <button id="obtPromotionStep4BrowseMer" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
                                            <img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                                <input type="text" class="input100 xCNHide" id="oetPromotionStep4WahInShopCode" name="oetPromotionStep4WahInShopCode" maxlength="5" value="">
                            </div>
                            <!-- จากกลุ่มร้านค้า -->
                        </div>

                        <div class="col-md-12 col-lg-12">
                            <!-- จากร้านค้า -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tShop'); ?></label>
                                <div class="input-group">
                                    <input class="form-control xCNHide xCNApvOrCanCelDisabled" id="oetPromotionStep4ShopCode" name="oetPromotionStep4ShopCode" maxlength="5" value="<?php echo $tUserShpCode; ?>">
                                    <input type="text" class="form-control xWPointerEventNone xCNApvOrCanCelDisabled" id="oetPromotionStep4ShopName" name="oetPromotionStep4ShopName" value="<?php echo $tUserShpName; ?>" readonly>
                                    <span class="xWConDisDocument input-group-btn">
                                        <button id="obtPromotionStep4BrowseShp" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled"><img class="xCNIconFind"></button>
                                    </span>
                                </div>
                            </div>
                            <!-- จากร้านค้า -->
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="btn-group pull-right" style="margin-bottom: 20px;">
                            <button type="button" class="btn xCNBTNDefult" data-dismiss="modal" style="margin-right:10px;">
                                <?php echo language('common/main/main', 'tCancel'); ?>
                            </button>
                            <button onclick="JSvPromotionStep4InsertPdtPmtHDBchToTemp()" type="button" class="btn xCNBTNPrimery">
                                <?php echo language('common/main/main', 'tSave'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer"></div> -->
        </div>
    </div>
</div>
<!-- Begin Add เงื่อนไขพิเศษ - สาขา -->

<?php include_once('script/jStep4.php'); ?>