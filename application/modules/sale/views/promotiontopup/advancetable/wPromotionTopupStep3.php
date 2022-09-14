<?php if(!$bIsApvOrCancel) { ?>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="xCNBTNPrimeryPlus pull-right" id="obtPTUStep3AddHDBch" style="margin-bottom: 10px;">+</button>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div id="odvPTUDataTableStep3"></div>
    </div>
</div>


<!-- Begin Add/Edit HDBch -->
<div class="modal fade" id="odvPTUAddHDBchModal">
    <div class="modal-dialog" style="width: 40%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/promotion/promotion', 'tPTUTitleModalHDBch'); ?></h5>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="btn-group pull-right" style="margin-bottom: 20px;">
                            <button type="button" class="btn xCNBTNDefult" data-dismiss="modal" style="margin-right:10px;">
                                <?php echo language('common/main/main', 'tCancel'); ?>
                            </button>
                            <button onclick="JSxPTUStep3AddEditHDBch()" type="button" class="btn xCNBTNPrimery xCNAddPmtGroupModalCanCelDisabled">
                                <?php echo language('common/main/main', 'tSave'); ?>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <input type="text" class="input100 xCNHide" id="oetPTUHDBchSeqNo" name="oetPTUHDBchSeqNo">

                    <!-- เลือกตัวแทนขาย --> 
                    <div class="col-md-12" <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?> >
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUStep3Agency'); ?></label>
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide" id="oetPTUHDBchAgnCode" name="oetPTUHDBchAgnCode" maxlength="10" value="">
                                <input class="form-control xWPointerEventNone" type="text" id="oetPTUHDBchAgnName" name="oetPTUHDBchAgnName" value="" readonly placeholder="<?php echo language('sale/promotiontopup/promotiontopup', 'tPTUStep3Agency'); ?>">
                                <span class="input-group-btn xWConditionSearchPdt">
                                    <button id="obtPTUHDBchBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- เลือกตัวแทนขาย --> 

                    <!-- เลือกสาขา -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tBCH'); ?></label>
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide" id="oetPTUHDBchBchCode" name="oetPTUHDBchBchCode" maxlength="5" value="">
                                <input class="form-control xWPointerEventNone" type="text" id="oetPTUHDBchBchName" name="oetPTUHDBchBchName" value="" readonly placeholder="<?php echo language('sale/promotiontopup/promotiontopup', 'tBCH'); ?>">
                                <span class="input-group-btn xWConditionSearchPdt">
                                    <button id="obtPTUHDBchBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- เลือกสาขา --> 

                    <!-- Lat Update : Napat(Jame) 21/12/2020 -->
                    <!-- ISSUE 248 https://docs.google.com/spreadsheets/d/1kxqKnlY_UzqnXRbrxoGaPCsvhDgo5_oKF2geROuii4U/edit#gid=1971626505 -->
                    <!-- ให้เหลือแค่ Browse AD กับ Browse สาขาก่อนเบื้องต้น -->

                    <!-- เลือกกลุ่มธุรกิจ -->
                    <!-- <div class="col-md-12 <?php if( !FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tBusinessGroup'); ?></label>
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide" id="oetPTUHDBchMerCode" name="oetPTUHDBchMerCode" maxlength="5" value="">
                                <input class="form-control xWPointerEventNone" type="text" id="oetPTUHDBchMerName" name="oetPTUHDBchMerName" value="" readonly placeholder="<?php echo language('sale/promotiontopup/promotiontopup', 'tBusinessGroup'); ?>">
                                <span class="input-group-btn xWConditionSearchPdt">
                                    <button id="obtPTUHDBchBrowseMerchant" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div> -->
                    <!-- เลือกกลุ่มธุรกิจ --> 

                    <!-- เลือกร้านค้า -->
                    <!-- <div class="col-md-12 <?php if( !FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tTBShp'); ?></label>
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide" id="oetPTUHDBchShpCode" name="oetPTUHDBchShpCode" maxlength="5" value="">
                                <input class="form-control xWPointerEventNone" type="text" id="oetPTUHDBchShpName" name="oetPTUHDBchShpName" value="" readonly placeholder="<?php echo language('sale/promotiontopup/promotiontopup', 'tTBShp'); ?>">
                                <span class="input-group-btn xWConditionSearchPdt">
                                    <button id="obtPTUHDBchBrowseShop" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div> -->
                    <!-- เลือกร้านค้า --> 

                    <!-- กลุ่มร่วมรายการ -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tJoiningGroup'); ?></label>
                            <select class="selectpicker form-control" id="ocmPTUAddPmhStaType" name="ocmPTUAddPmhStaType">
                                <option value="1"><?=language('sale/promotiontopup/promotiontopup', 'tStaType1');?></option>
                                <option value="2"><?=language('sale/promotiontopup/promotiontopup', 'tStaType2');?></option>
                            </select>
                        </div>
                    </div>
                    <!-- กลุ่มร่วมรายการ --> 

                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Add/Edit HDBch -->
    
<?php include_once('script/jPromotionTopupStep3.php'); ?>