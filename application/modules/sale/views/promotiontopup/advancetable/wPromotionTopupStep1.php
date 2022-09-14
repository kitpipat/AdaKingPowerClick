<?php if(!$bIsApvOrCancel) { ?>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="xCNBTNPrimeryPlus pull-right" id="obtPTUStep1AddCardType" style="margin-bottom: 10px;">+</button>
            <!-- data-backdrop="static" 
            data-keyboard="false" 
            type="button" 
            data-toggle="modal" 
            data-target="#odvPTUAddCardTypeModal" -->
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div id="odvPTUDataTableStep1"></div>
    </div>
</div>

<!-- Begin Add/Edit Card Type -->
<div class="modal fade" id="odvPTUAddCardTypeModal"> <!--style="max-width: 1500px; margin: 1.75rem auto; width: 85%;"-->
    <div class="modal-dialog" style="width: 40%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/promotion/promotion', 'tPromotionGroup_Create'); ?></h5>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="btn-group pull-right" style="margin-bottom: 20px;">
                            <button type="button" class="btn xCNBTNDefult" data-dismiss="modal" style="margin-right:10px;">
                                <?php echo language('common/main/main', 'tCancel'); ?>
                            </button>
                            <button onclick="JSxPTUStep1AddEditCardType()" type="button" class="btn xCNBTNPrimery xCNAddPmtGroupModalCanCelDisabled">
                                <?php echo language('common/main/main', 'tSave'); ?>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- เลือกประเภทบัตร -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUTBCtyType'); ?></label>
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide" id="oetPTUAddCtyCode" name="oetPTUAddCtyCode" maxlength="5" value="">
                                <input class="form-control xWPointerEventNone" type="text" id="oetPTUAddCtyName" name="oetPTUAddCtyName" value="" readonly placeholder="<?php echo language('sale/promotiontopup/promotiontopup', 'tPTUTBCtyType'); ?>">
                                <span class="input-group-btn xWConditionSearchPdt">
                                    <button id="obtPTUBrowseCardType" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- เลือกประเภทบัตร --> 

                    <!-- กลุ่มร่วมรายการ -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tJoiningGroup'); ?></label>
                            <select class="selectpicker form-control" id="ocmPTUAddPmdStaType" name="ocmPTUAddPmdStaType">
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
<!-- End Add/Edit Card Type -->
    
<?php include_once('script/jPromotionTopupStep1.php'); ?>