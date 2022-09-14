
<div id="odvModalPdtPriceDetail" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="min-width:1443.5px;margin:1.75rem auto;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard"><?php echo language('product/product/product','tPDTViewMDPriDTTitle');?></label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('product/product/product','tPDTViewMDPriDTCloseModal');?></button>   
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="panel-body" style="padding:10px">
                    <div id="odvPriceDetailPdtTitle" class="row">
                        <div id="odvModalPriDTPdtCode" class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
                            <label class="xWPdtModalTextFrm"><?php echo language('product/product/product','tPDTViewMDPriDTPdtCode');?> <span class="xWPdtModalTextFrmDt"><?php echo $tPriceDTPdtCode;?></span></label>
                        </div>
                        <div id="odvModalPriDTPdtName" class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
                        <label class="xWPdtModalTextFrm"><?php echo language('product/product/product','tPDTViewMDPriDTPdtName');?> <span class="xWPdtModalTextFrmDt"><?php echo $tPriceDTPdtName;?></span></label>
                        </div>
                    </div>
                    <div id="odvPriceDetailPdtFrmFilter" class="row">
                        <input type="hidden" id="ohdPriDTTabTableSlt" class="form-control" name="ohdPriDTTabTableSlt">
                        <div id="odvPdtUnitFilter" class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label class="xWPdtModalTextFrm"><?php echo language('product/product/product','tPDTViewMDPriDTPackSizeFilter');?></label>
                                <select id="ocmPdtPriDTFilterPriUnit" class="selectpicker form-control xWPdtSelectBox" name="ocmPdtPriDTFilterPriUnit" data-live-search="true">
                                    <option value=""><?php echo language('product/product/product','tPDTViewMDPriDTPackSizePace');?></option>
                                    <?php if(isset($aDataPriDTUnit) && $aDataPriDTUnit['rtCode'] == '1'):?>
                                        <?php foreach($aDataPriDTUnit['raItems'] AS $nKeys => $aPriDTUnit):?>
                                            <option value="<?php echo $aPriDTUnit['FTPunCode'];?>"><?php echo $aPriDTUnit['FTPunName'];?></option>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </select>
                            </div>
                        </div>
                        <div id="odvPdtPriTypeFilter" class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label class="xWPdtModalTextFrm"><?php echo language('product/product/product','tPdtViewMDPriDTPriceTypeFilter');?></label>
                                <select id="ocmPdtPriDTFilterPriType" class="selectpicker form-control xWPdtSelectBox" name="ocmPdtPriDTFilterPriType">
                                    <option value=""><?php echo language('product/product/product','tPDTViewMDPriDTPriceTypePace');?></option>
                                    <option value="1"><?php echo language('product/product/product','tPDTViewMDPriDTBasePrice');?></option>
                                    <option value="2"><?php echo language('product/product/product','tPDTViewMDPriDTPriceOff');?></option>
                                </select>
                            </div>
                        </div>
                        <div id="odvPdtCstGroupFilter" class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewMDPriDTCustomerGrpFilter')?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide" id="oetPdtPriDTCstGrpCode" name="oetPdtPriDTCstGrpCode">
                                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetPdtPriDTCstGrpName" name="oetPdtPriDTCstGrpName" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtBrowsePriDTCstGrp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="odvPdtZoneFilter" class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewMDPriDTZoneFilter')?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide" id="oetPdtPriDTZoneCode" name="oetPdtPriDTZoneCode">
                                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetPdtPriDTZoneName" name="oetPdtPriDTZoneName" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtBrowsePriDTZone" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="odvPdtBarnchFilter" class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewMDPriDTBranchFilter')?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide" id="oetPdtPriDTBchCode" name="oetPdtPriDTBchCode">
                                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetPdtPriDTBchName" name="oetPdtPriDTBchName" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtBrowsePriDTBranch" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="odvPdtAgencyFilter" class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewMDPriDTAGGFilter')?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide" id="oetPdtPriDTAGGCode" name="oetPdtPriDTAGGCode">
                                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetPdtPriDTAGGName" name="oetPdtPriDTAGGName" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtBrowsePriDTAgency" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="odvPdtDateStartFilter" class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label class="xWPdtModalTextFrm"><?php echo language('product/product/product','tPDTViewMDPriDTDateStartFilter');?></label>
                                <div class="input-group">
                                    <input type="text" id="ocmPdtPriDTFilterDateStart" class="form-control xWModalPriDTDate xCNInputMaskDate" name="ocmPdtPriDTFilterDateStart">
                                    <span class="input-group-btn">
                                        <button id="obtPdtPriDTFilterDateStart"  class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                    </span>
                                </div>
                            </div>   
                        </div>
                        <div id="odvPdtButtomClickFilter" class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group" style="padding-top:34px">
                                <button type="button" id="obtPdtPriDTSummitFilter" class="btn xCNBTNPrimery" style="width:70%"><?php echo language('product/product/product','tPDTViewMDPriDTSearch');?></button>
                            </div>
                        </div>
                    </div>
                    <div id="odvPriceDetailDataTabTable" class="row">
                        <div id="odvPdtPriDTNavTab" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                <ul class="nav" role="tablist">
                                    <li class="xWMenu xWPriDTTab active" data-menutype="PRI4PDT">
                                        <a role="tab" data-toggle="tab" data-target="#odvPriDT4PDTContent" aria-expanded="true"><?php echo language('product/product/product','tPDTViewMDPriDTTabMenu4PDT')?></a>
                                    </li>
                                    <li class="xWMenu xWPriDTTab" data-menutype="PRI4CST">
                                        <a role="tab" data-toggle="tab" data-target="#odvPriDT4CSTContent" aria-expanded="true"><?php echo language('product/product/product','tPDTViewMDPriDTTabMenu4CST')?></a>
                                    </li>
                                    <li class="xWMenu xWPriDTTab" data-menutype="PRI4ZNE">
                                        <a role="tab" data-toggle="tab" data-target="#odvPriDT4ZNEContent" aria-expanded="true"><?php echo language('product/product/product','tPDTViewMDPriDTTabMenu4ZNE')?></a>
                                    </li>
                                    <li class="xWMenu xWPriDTTab" data-menutype="PRI4BCH">
                                        <a role="tab" data-toggle="tab" data-target="#odvPriDT4BCHContent" aria-expanded="true"><?php echo language('product/product/product','tPDTViewMDPriDTTabMenu4BCH')?></a>
                                    </li>
                                    <li class="xWMenu xWPriDTTab" data-menutype="PRI4AGG">
                                        <a role="tab" data-toggle="tab" data-target="#odvPriDT4AGGContent" aria-expanded="true"><?php echo language('product/product/product','tPDTViewMDPriDTTabMenu4AGG')?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="odvPdtPriDTContentTab" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="tab-content">
                                <!-- Tab Content Product Price4Pdt -->
                                <div id="odvPriDT4PDTContent" class="tab-pane fade active in">
                                </div>
                                <!-- End Tab Content Product Price4Pdt -->

                                <!-- Tab Content Product Price4CST -->
                                <div id="odvPriDT4CSTContent" class="tab-pane fade">
                                </div>
                                <!-- End Tab Content Product Price4CST -->
                                
                                <!-- Tab Content Product Price4ZNE -->
                                <div id="odvPriDT4ZNEContent" class="tab-pane fade">
                                </div>
                                <!-- End Tab Content Product Price4ZNE -->
                                
                                <!-- Tab Content Product Price4BCH -->
                                <div id="odvPriDT4BCHContent" class="tab-pane fade">
                                </div>
                                <!-- End Tab Content Product Price4BCH -->

                                <!-- Tab Content Product Price4AGG -->
                                <div id="odvPriDT4AGGContent" class="tab-pane fade">
                                </div>
                                <!-- End Tab Content Product Price4AGG -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "script/jPdtPriceMain.php"; ?>