<style>
    .xWEJBoxFilter {
        border:1px solid #ccc !important;
        position:relative !important;
        padding:15px !important;
        margin-top:30px !important;
        padding-bottom:0px !important;
    }

    .xWEJBoxFilter .xWEJLabelFilter {
        position:absolute !important;
        top:-15px;left:15px !important;
        background: #fff !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    #odvConditonSearchEJ .panel-body{
        padding-top: 0 !important;
    }

</style>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <div class="panel panel-default">
            <div id="odvEJConditionPanel" class="panel-heading xCNPanelHeadColor">
                <label class="xCNTextDetail1"><?php echo language('sale/reprintej/reprintej','tEJPanelCondition');?></label>
            </div>
            <div id="odvConditonSearchEJ" class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <form action="javascript:void(0);" id="ofmEJConditionFilter">                        
                        <!-- Filter Condition Branch-->
                        <div id="odvEJFilterBranchAndShop" class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="xWEJBoxFilter">
                                    <label class="xCNLabelFrm xWEJLabelFilter"><?php echo language('sale/reprintej/reprintej','tEJFilterBranch');?></label>
                                    <div class="form-group">
                                        <?php
                                            // $tCheckBchCode  = "";
                                            // $tCheckBchName  = "";
                                            // $tEJDisableBrowseBranch = "";
                                            // if($this->session->userdata("tSesUsrLevel") == "BCH" || $this->session->userdata("tSesUsrLevel") == "SHP"){
                                            //     $tCheckBchCode  = $this->session->userdata('tSesUsrBchCodeDefault');
                                            //     $tCheckBchName  = $this->session->userdata('tSesUsrBchNameDefault');
                                            //     // เข้ามาในกรณีก็ต่อเมือ Session User Level เป็นระดับสาขา หรือ ระดับร้านค้า และ Session User Brach Code ต้องไม่เท่ากับค่าว่าง
                                            //     if(isset($tCheckBchCode) && !empty($tCheckBchCode)){
                                            //         $tEJDisableBrowseBranch = ' disabled';
                                            //     }
                                            // }
                                        ?>
                                        <div class="input-group">
                                            <input type='text' class='form-control xCNHide' id='oetEJBchCode' name='oetEJBchCode' maxlength='5' value="<?php echo @$this->session->userdata('tSesUsrBchCodeDefault');?>">
                                            <input
                                                type='text'
                                                class='form-control xWPointerEventNone'
                                                id='oetEJBchName'
                                                name='oetEJBchName'
                                                value="<?php echo @$this->session->userdata('tSesUsrBchNameDefault');?>"
                                                placeholder="<?php echo language('sale/reprintej/reprintej','tEJPacFilterBranch');?>"
                                                readonly
                                            >
                                            <span class='input-group-btn'>
                                                <button id='obtEJBrowseBranch' type='button' class='btn xCNBtnBrowseAddOn'>
                                                    <img class='xCNIconFind'>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if(!FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>">
                                        <?php
                                            $tCheckShopCode = "";
                                            $tCheckShopName = "";
                                            $tEJDisableBrowseShop   = "";
                                            if($this->session->userdata("tSesUsrLevel") == "SHP"){
                                                $tCheckShopCode = $this->session->userdata('tSesUsrShpCode');
                                                $tCheckShopName = $this->session->userdata('tSesUsrShpName');
                                                 // เข้ามาในกรณีก็ต่อเมือ Session User Level เป็นระดับร้านค้า และ Session User Shop Code ต้องไม่เท่ากับค่าว่าง
                                                if(isset($tCheckShopCode) && !empty($tCheckShopCode)){
                                                    $tEJDisableBrowseShop   = ' disabled';
                                                }
                                            }
                                        ?>
                                        <div class="input-group">
                                            <input type='text' class='form-control xCNHide' id='oetEJShopCode' name='oetEJShopCode' maxlength='5' value="<?php echo @$tCheckShopCode?>">
                                            <input
                                                type='text'
                                                class='form-control xWPointerEventNone'
                                                id='oetEJShopName'
                                                name='oetEJShopName'
                                                value="<?php echo @$tCheckShopName;?>"
                                                placeholder="<?php echo language('sale/reprintej/reprintej','tEJPacFilterShop');?>"
                                                readonly
                                            >
                                            <span class='input-group-btn'>
                                                <button id='obtEJBrowsShop' type='button' class='btn xCNBtnBrowseAddOn'<?php echo @$tEJDisableBrowseShop;?>>
                                                    <img class='xCNIconFind'>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Filter Condition Doc Date-->
                        <div id="odvEJFilterDocDate" class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="xWEJBoxFilter">
                                    <label class="xCNLabelFrm xWEJLabelFilter"><?php echo language('sale/reprintej/reprintej','tEJFilterDate');?></label>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class='xCNLabelFrm'><?php echo language('sale/reprintej/reprintej','tEJFilterDateFrom');?></label>
                                                <div class='input-group'>
                                                    <?php $tEJDateForm = date('Y-m-d');?>
                                                    <input type='text' class='form-control xCNDatePicker xCNInputMaskDate' id='oetEJDocDateFrom' name='oetEJDocDateFrom' value="<?php echo @$tEJDateForm;?>">
                                                    <span class='input-group-btn'>
                                                        <button id='obtEJBrowseDateFrom' type='button' class='btn xCNBtnDateTime'>
                                                            <img class='xCNIconCalendar'>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class='xCNLabelFrm'><?php echo language('sale/reprintej/reprintej','tEJFilterDateTo');?></label>
                                                <div class='input-group'>
                                                    <?php $tEJDateTo = date('Y-m-d');?>
                                                    <input type='text' class='form-control xCNDatePicker xCNInputMaskDate' id='oetEJDocDateTo' name='oetEJDocDateTo' value="<?php echo @$tEJDateTo;?>">
                                                    <span class='input-group-btn'>
                                                        <button id='obtEJBrowseDateTo' type='button' class='btn xCNBtnDateTime'>
                                                            <img class='xCNIconCalendar'>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Condition Document Type -->
                        <div id="odvEJFilterDocumentNo" class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="xWEJBoxFilter">
                                    <label class="xCNLabelFrm xWEJLabelFilter"><?php echo language('sale/reprintej/reprintej','tEJFilterDocumentType');?></label>
                                    <div class="form-group">
                                        <select class="form-control selectpicker" id="ocmEjDocumentType" name="ocmEjDocumentType">
                                            <!-- <option value=""><?php echo language('sale/reprintej/reprintej','tEJDocumentTypeXAll');?></option> -->
                                            <option value="S" selected><?php echo language('sale/reprintej/reprintej','tEJDocumentTypeXSale');?></option>
                                            <option value="RCV"><?php echo language('sale/reprintej/reprintej','tEJDocumentTypeXPay');?></option>
                                            <option value="SUM"><?php echo language('sale/reprintej/reprintej','tEJDocumentTypeXRoundOff');?></option>
                                            <option value="R"><?php echo language('sale/reprintej/reprintej','tEJDocumentTypeXRecive');?></option>
                                            <option value="BNK"><?php echo language('sale/reprintej/reprintej','tEJDocumentTypeXBNK');?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Condition Document No -->
                        <div id="odvEJFilterDocumentNo" class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="xWEJBoxFilter">
                                    <label class="xCNLabelFrm xWEJLabelFilter"><?php echo language('sale/reprintej/reprintej','tEJFilterDocument');?></label>
                                    <div id="odvFilterDocument" class="form-group">
                                        <label class="fancy-checkbox p-b-5">
                                            <input type="checkbox" id="ocbEJShipCodeUse"  name="ocbEJShipCodeUse">
                                            <span><?php echo language('sale/reprintej/reprintej','tEJFilterShipCodeUse');?></span>
                                        </label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide' id='oetEJSlipCode' name='oetEJSlipCode' maxlength='5'>
                                            <input
                                                type='text'
                                                class='form-control xWPointerEventNone'
                                                id='oetEJSlipName'
                                                name='oetEJSlipName'
                                                readonly
                                            >
                                            <span class='input-group-btn'>
                                                <button id='obtEJBrowseSlipCode' type='button' class='btn xCNBtnBrowseAddOn'>
                                                    <img class='xCNIconFind'>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class='xCNLabelFrm'><?php echo language('sale/reprintej/reprintej','tEJFilterSlipCodeFrom');?></label>
                                            <div class='input-group'>
                                                <input type='text' class='form-control xCNHide' id='oetEJSlipCodeFrom' name='oetEJSlipCodeFrom' maxlength='5'>
                                                <input
                                                    type='text'
                                                    class='form-control xWPointerEventNone'
                                                    id='oetEJSlipNameFrom'
                                                    name='oetEJSlipNameFrom'
                                                    placeholder="<?php echo language('sale/reprintej/reprintej','tEJFilterSlipCodeFrom');?>"
                                                    readonly
                                                >
                                                <span class='input-group-btn'>
                                                    <button id='obtEJBrowseSlipFrom' type='button' class='btn xCNBtnBrowseAddOn'>
                                                        <img class='xCNIconFind'>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class='xCNLabelFrm'><?php echo language('sale/reprintej/reprintej','tEJFilterSlipCodeTo');?></label>
                                            <div class='input-group'>
                                                <input type='text' class='form-control xCNHide' id='oetEJSlipCodeTo' name='oetEJSlipCodeTo' maxlength='5'>
                                                <input
                                                    type='text'
                                                    class='form-control xWPointerEventNone'
                                                    id='oetEJSlipNameTo'
                                                    name='oetEJSlipNameTo'
                                                    placeholder="<?php echo language('sale/reprintej/reprintej','tEJFilterSlipCodeTo');?>"
                                                    readonly
                                                >
                                                <span class='input-group-btn'>
                                                    <button id='obtEJBrowseSlipTo' type='button' class='btn xCNBtnBrowseAddOn'>
                                                        <img class='xCNIconFind'>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="odvBtnReprintEJFilter" class="row p-t-20">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 p-b-10">
                            <button type="button" id="obtRPEJRefreshView" class="btn btn-primary" style="font-size: 17px;width: 100%;">
                                <?php echo language('sale/reprintej/reprintej','tRPEJRefreshView') ?>
                            </button>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 p-b-10">
                            <button type="button" id="obtRPEJFilterSerch" class="btn btn-primary" style="font-size: 17px;width: 100%;">
                                <?php echo language('sale/reprintej/reprintej','tRPEJFilterSerch') ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
        <div class="panel panel-default" style="margin-bottom: 25px;">
            <div id="odvEJAbbrViewer" class="panel-heading xCNPanelHeadColor">
                <label class="xCNTextDetail1"><?php echo language('sale/reprintej/reprintej','tEJPanelAbbrViewer');?></label>
            </div>
            <div id="odvAbbrViewerData" class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<?php include "script/jReprintEJPageMainForm.php";?>