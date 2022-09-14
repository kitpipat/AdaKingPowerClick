<?php
    $tSesUsrLevel   = $this->session->userdata('tSesUsrLevel');
    if(isset($aDataDocHD) && $aDataDocHD['rtCode'] == "1"){ 
        $tPORoute              = "dcmPOEventEdit";
        $tPODocNo              = "";
        $dPODocDate            = "";
        $dPODocTime            = "";
        $tPOCreateBy           = "";
        $tPOUsrNameCreateBy    = "";
        $tPOStaDoc             = "";
        $tPOStaApv             = "";
        $tPOStaPrcStk          = "";
        $tPOApvCode            = "";
        $tPOUsrNameApv         = "";
    }else{
        $tPORoute              = "dcmPOEventAdd";
        $tPODocNo              = "";
        $dPODocDate            = "";
        $dPODocTime            = "";
        $tPOCreateBy           = "";
        $tPOUsrNameCreateBy    = "";
        $tPOStaDoc             = "";
        $tPOStaApv             = "";
        $tPOStaPrcStk          = "";
        $tPOApvCode            = "";
        $tPOUsrNameApv         = "";
    }
?>

<form id="ofmPOFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button style="display:none" type="submit" id="obtSubmitPO" onclick="JSxPOEventAddEdit('<?=$tPORoute?>')"></button>

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?=language('document/purchaseorderNew/purchaseorderNew', 'tPODocument'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvPODataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPODataStatusInfo" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="xCNTitleFrom "><?=language('document/purchaseorderNew/purchaseorderNew', 'tPOApproved'); ?></label>
                                </div>
                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?=language('document/purchaseorderNew/purchaseorderNew', 'tPODocNo'); ?></label>
                                <?php if(empty($tPODocNo)):?>
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbPOStaAutoGenCode" name="ocbPOStaAutoGenCode" maxlength="1" checked="true" value="1">
                                            <span><?=language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tPOAutoGenCode'); ?></span>
                                        </label>
                                    </div>
                                <?php endif;?>

                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input 
                                        type="text"
                                        class="form-control xWTooltipsBT"
                                        id="oetPODocNo"
                                        name="oetPODocNo"
                                        maxlength="20"
                                        value="<?=$tPODocNo;?>"
                                        data-validate-required="<?=language('document/purchaseorderNew/purchaseorderNew', 'tPOPlsEnterOrRunDocNo'); ?>"
                                        data-validate-duplicate="<?=language('document/purchaseorderNew/purchaseorderNew', 'tPOPlsDocNoDuplicate'); ?>"
                                        placeholder="<?=language('document/purchaseorderNew/purchaseorderNew','tPODocNo');?>"
                                        style="pointer-events:none"
                                        readonly
                                    >
                                    <input type="hidden" id="ohdPOCheckDuplicateCode" name="ohdPOCheckDuplicateCode" value="2">
                                </div>

                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?=language('document/purchaseorderNew/purchaseorderNew','tPODocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetPODocDate"
                                            name="oetPODocDate"
                                            value="<?=$dPODocDate;?>"
                                            data-validate-required="<?=language('document/purchaseorderNew/purchaseorderNew', 'tASTPlsEnterDocDate');?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPODocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?=language('document/purchaseorderNew/purchaseorderNew', 'tPODocTime');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNTimePicker"
                                            id="oetPODocTime"
                                            name="oetPODocTime"
                                            value="<?=$dPODocTime;?>"
                                            data-validate-required="<?=language('document/purchaseorderNew/purchaseorderNew', 'tPOPlsEnterDocTime');?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPODocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?=language('document/purchaseorderNew/purchaseorderNew','tPOCreateBy'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdPOCreateBy" name="ohdPOCreateBy" value="<?=$tPOCreateBy?>">
                                            <label><?=$tPOUsrNameCreateBy?></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?=language('document/purchaseorderNew/purchaseorderNew','tPOTBStaDoc');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?=language('document/purchaseorderNew/purchaseorderNew','tPOStaDoc'.$tPOStaDoc);?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?=language('document/purchaseorderNew/purchaseorderNew','tPOStaApv');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?=language('document/purchaseorderNew/purchaseorderNew','tPOStaApv'.$tPOStaApv);?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะประมวลผลเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?=language('document/purchaseorderNew/purchaseorderNew','tPOStaPrcStk');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?=language('document/purchaseorderNew/purchaseorderNew','tPOStaPrcStk'.$tPOStaPrcStk);?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- ผู้อนุมัติเอกสาร -->   
                                <?php if(isset($tPODocNo) && !empty($tPODocNo)):?>
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?=language('document/purchaseorderNew/purchaseorderNew', 'tPOApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdPOApvCode" name="ohdPOApvCode" maxlength="20" value="<?=$tPOApvCode?>">
                                                <label>
                                                    <?=(isset($tPOUsrNameApv) && !empty($tPOUsrNameApv))? $tPOUsrNameApv : "-" ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel เงื่อนไขเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?=language('document/purchaseorderNew/purchaseorderNew','tPOConditionDoc');?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvPODataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPODataConditionDoc" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel ผู้จำหน่าย -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?=language('document/purchaseorderNew/purchaseorderNew','tPOSpl');?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvPODataConditionSPL" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPODataConditionSPL" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?=language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoVatInOrEx');?></label>
                                    <select class="selectpicker form-control" id="ocmVatInOrEx" name="ocmVatInOrEx" maxlength="1">
                                        <option value="1"><?=language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoVatInclusive');?></option>
                                        <option value="2"><?=language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoVatExclusive');?></option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>       

        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div class="row">
                <!-- ตารางสินค้า -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-collapse collapse in" role="tabpanel">
                            <div class="panel-body">
                                <div class="row" style="margin-top: 10px;">

                                    <!--ผู้จำหน่าย-->
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNHide" id="oetPOSplCode" name="oetPOSplCode" value="">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="oetPOSplName"
                                                        name="oetPOSplName"
                                                        value=""
                                                        placeholder="<?=language('document/purchaseorderNew/purchaseorderNew','tPOSpl') ?>"
                                                        readonly
                                                    >
                                                    <span class="input-group-btn">
                                                        <button id="obtPOBrowseSupplier" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img class="xCNIconFind">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--ค้นหา-->
                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 text-right">
                                                <div id="odvPOMngAdvTableList" class="btn-group xCNDropDrownGroup">
                                                    <button id="obtPOAdvTablePdtDTTemp" type="button" class="btn xCNBTNMngTable m-r-20"><?=language('common/main/main', 'tModalAdvTable') ?></button>
                                                </div>
                                                <div id="odvPOMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
                                                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                                        <?=language('common/main/main','tCMNOption')?>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li id="oliPOBtnDeleteMulti" class="disabled">
                                                            <a data-toggle="modal" data-target="#odvPOModalDelPdtInDTTempMultiple"><?=language('common/main/main','tDelAll')?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                                <div class="form-group">
                                                    <div style="position: absolute;right: 15px;top:-5px;">
                                                        <button type="button" id="obtPODocBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--ตาราง-->
                                    <div class="col-lg-12" id="odvPODataPdtTableDTTemp"  style="margin-top: 10px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- จบตารางสินค้า -->
            </div>    
        </div>
    </div>
</form>

<!-- ================================================================= View Modal Appove Document ================================================================= -->
<!-- <div id="odvPOModalAppoveDoc" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main','tApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?=language('common/main/main','tMainApproveStatus'); ?></p>
                    <ul>
                        <li><?=language('common/main/main','tMainApproveStatus1'); ?></li>
                        <li><?=language('common/main/main','tMainApproveStatus2'); ?></li>
                        <li><?=language('common/main/main','tMainApproveStatus3'); ?></li>
                        <li><?=language('common/main/main','tMainApproveStatus4'); ?></li>
                    </ul>
                <p><?=language('common/main/main','tMainApproveStatus5'); ?></p>
                <p><strong><?=language('common/main/main','tMainApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button  id="obtPOConfirmApprDoc" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel'); ?></button>
            </div>
        </div>
    </div>
</div> -->
<!-- ============================================================================================================================================================== -->

<!-- ================================================================= กรณีคลังสินค้าต้นทาง ปลายทางว่าง ================================================================= -->
<!-- <div class="modal fade" id="odvWTIModalWahIsEmpty">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/purchaseorderNew/purchaseorderNew', 'tConditionISEmpty')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
						<span id="ospWahIsEmpty"><?=language('document/purchaseorderNew/purchaseorderNew', 'tWahDocumentISEmptyDetail')?></span>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div> -->
<!-- ============================================================================================================================================================== -->

<!-- ================================================================= กรณีไม่ได้เลือกประเภทเอกสาร ================================================================= -->
<!-- <div class="modal fade" id="odvWTIModalTypeIsEmpty">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/purchaseorderNew/purchaseorderNew', 'tConditionISEmpty')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
						<span id="ospTypeIsEmpty"><?=language('document/purchaseorderNew/purchaseorderNew', 'tTypeDocumentISEmptyDetail')?></span>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div> -->
<!-- ============================================================================================================================================================== -->

<!-- ============================================================== ยกเลิกเอกสาร ============================================================== -->
<!-- <div class="modal fade" id="odvPOPopupCancel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document','tDocDocumentCancel')?></label>
			</div>
			<div class="modal-body">
                <p id="obpMsgApv"><strong><?=language('common/main/main','tDocCancelAlert2')?></strong></p>
			</div>
			<div class="modal-footer">
                <button onclick="JSxTRNTransferReceiptDocCancel(true)" type="button" class="btn xCNBTNPrimery">
                    <?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div> -->
<!-- ========================================================================================================================================== -->

<script src="<?=base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?=base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jPOAdd.php'); ?>

