<!-- Filter -->
<section>
    <div class="col-md-3 col-xs-3 col-sm-3">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmBranch')?></label>
                <div class="input-group">
                    <input
                        type="text"
                        class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                        id="oetTransferBchOutRefIntBchCode"
                        name="oetTransferBchOutRefIntBchCode"
                        maxlength="5"
                        value="<?=$tBCHCode?>"
                    >
                    <input
                        type="text"
                        class="form-control xWPointerEventNone"
                        id="oetTransferBchOutRefIntBchName"
                        name="oetTransferBchOutRefIntBchName"
                        maxlength="100"
                        value="<?=$tBCHName?>"
                        readonly
                    >
                    <span class="input-group-btn xWConditionSearchPdt">
                        <button id="obtTransferBchOutBrowseBchRefIntDoc" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- เลขที่เอกสาร -->
    <div class="col-md-2 col-xs-2 col-sm-2">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocNo')?></label>
                <input
                    type="text"
                    class="form-control"
                    id="oetTransferBchOutRefIntDocNo"
                    name="oetTransferBchOutRefIntDocNo"
                    maxlength="100"
                    value=""
                    placeholder="<?php echo language('document/document/document', 'tDocNo')?>"
                >
            </div>
        </div>
    </div>
    <!-- วันที่เอกสารเริ่ม -->
    <div class="col-md-2 col-xs-2 col-sm-2">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocDateFrom')?></label>
                    <div class="input-group">
                    <input
                        type="text"
                        class="form-control xCNDatePicker xCNInputMaskDate"
                        id="oetTransferBchOutRefIntDocDateFrm"
                        name="oetTransferBchOutRefIntDocDateFrm"
                        placeholder="YYYY-MM-DD"
                        value=""
                    >
                    <span class="input-group-btn">
                        <button id="obtTransferBchOutBrowseRefExtDocDateFrm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- วันที่เอกสารสิ้นสุด -->
    <div class="col-md-2 col-xs-2 col-sm-2">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocDateTo')?></label>
                <div class="input-group">
                    <input
                        type="text"
                        class="form-control xCNDatePicker xCNInputMaskDate"
                        id="oetTransferBchOutRefIntDocDateTo"
                        name="oetTransferBchOutRefIntDocDateTo"
                        placeholder="YYYY-MM-DD"
                        value=""
                    >
                    <span class="input-group-btn">
                        <button id="obtTransferBchOutBrowseRefExtDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- สถานะเอกสาร -->
    <div class="col-md-2 col-xs-2 col-sm-2">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('document/document/document','tDocStaDoc');?></label>
            <select class="selectpicker form-control  " id="oetTransferBchOutRefIntStaDoc" name="oetTransferBchOutRefIntStaDoc" maxlength="1" value="<?php echo $tDOSplPayMentType;?>">
                <option value="1" ><?php echo language('document/document/document','tDocStaProApv1');?></option>
                <option value="2" ><?php echo language('document/document/document','tDocStaProApv');?></option>
                <option value="3" ><?php echo language('document/document/document','tDocStaProDoc3');?></option>
            </select>
        </div>
    </div>
                
    <!-- ปุ่มค้นหา -->
    <div class="col-md-1 col-xs-1 col-sm-1" style="padding-top: 24px;">
        <button id="obtRefIntDocFilter" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" ><?= language('document/document/document', 'tDocBtnFilter')?></button>
    </div>
</section>
<!-- Document -->
<section>
    <div id="odvRefIntDocHDDataTable"></div>
</section>
<!-- Items -->
<section>
    <div id="odvRefIntDocDTDataTable"></div>
</section>

<?php include('script/jTransferBchOutRefDoc.php');?>