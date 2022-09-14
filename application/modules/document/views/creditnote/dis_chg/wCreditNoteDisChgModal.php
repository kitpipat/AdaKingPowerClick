<input type="hidden" id="ohdCreditNoteDisChgType">
<div class="modal fade" id="odvCreditNoteDisChgPanel" style="max-width: 1500px; margin: 1.75rem auto; width: 85%;">
    <div class="modal-dialog" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title xWCreditNoteDisChgHeadPanel" style="display:inline-block"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!--div class="col-lg-4">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'ประเภท'); ?></label>
                            <select class="selectpicker form-control" id="ocmCreditNoteDisChgSelectType" name="ocmCreditNoteDisChgSelectType">
                                <option value='1' selected="true"><?php echo language('common/main/main', 'ลดบาท'); ?></option>
                                <option value='2'><?php echo language('common/main/main', 'ลด %'); ?></option>
                                <option value='3'><?php echo language('common/main/main', 'ชาร์จบาท'); ?></option>
                                <option value='4'><?php echo language('common/main/main', 'ชาร์ท %'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/creditnote/creditnote', 'มูลค่า'); ?></label>
                            <input class="form-control xCNInputNumericWithDecimal" type="text" id="oetCreditNoteDisChgInitNum" name="oetCreditNoteDisChgInitNum">
                        </div>
                    </div-->
                    <div class="col-lg-12">
                        <div class="btn-group pull-right" style="margin-bottom: 20px; width: 300px;">
                            <button 
                                type="button" 
                                id="obtCreditNoteAddDisChg" 
                                class="btn xCNBTNPrimery pull-right" 
                                onclick="JCNvCreditNoteAddDisChgRow()" 
                                style="width: 100%;"><?php echo language('common/main/main','tCMNAddDiscount');?></button>
                        </div>
                    </div>
                </div>
                <!-- Ref DisChg HD Table -->
                <div class="row">
                    <div class="col-md-12"><div id="odvCreditNoteDisChgHDTable"></div></div>
                </div>
                <!-- Ref DisChg HD Table -->
                
                <!-- Ref DisChg DT Table -->
                <div class="row">
                    <div class="col-md-12"><div id="odvCreditNoteDisChgDTTable"></div></div>
                </div>
                <!-- Ref DisChg DT Table -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tCancel'); ?>
                </button>
                <button onclick="JSxCreditNoteDisChgSave()" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tCMNOK'); ?>
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Update lang for disChg -->
<!-- Create By Witsarut 07/01/2020 -->
<input type="hidden" id="oetDiscountcharg" value="<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIAdvDiscountcharging')?>">
<input type="hidden" id="oetDiscountcharginglist" value="<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIAdvDiscountcharginglist');?>">

<script type="text/html" id="oscCreditNoteTrNotFoundTemplate">
    <tr id="otrCreditNoteDisChgDTNotFound"><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
</script>

<script type="text/html" id="oscCreditNoteTrBodyTemplate"> 
    <tr class="xWCreditNoteDisChgTrTag">
        <input type="hidden" class="xWCreditNoteDisChgCreatedAt" value="{tCreatedAt}">
        <td nowrap class="text-center"><label class="xWCreditNoteDisChgIndex"></label></td>
        <td nowrap class="text-right"><label class="xWCreditNoteDisChgBeforeDisChg">{cBeforeDisChg}</label></td>
        <td nowrap class="text-right"><label class="xWCreditNoteDisChgValue">{cDisChgValue}</label></td>
        <td nowrap class="text-right"><label class="xWCreditNoteDisChgAfterDisChg">{cAfterDisChg}</label></td>
        <td nowrap style="padding-left: 5px !important;">
            <div class="form-group" style="margin-bottom: 0px !important;">
                <select class="dischgselectpicker form-control xWCreditNoteDisChgType" onchange="JSxCreditNoteCalcDisChg(this);">
                    <option value='1' selected="true"><?php echo language('common/main/main', 'tCMNBahtdiscount'); ?></option>
                    <option value='2'><?php echo language('common/main/main', 'tCMNDiscount'); ?> %</option>
                    <option value='3'><?php echo language('common/main/main', 'tCMNBahtCharger'); ?></option>
                    <option value='4'><?php echo language('common/main/main', 'tCMNCharger'); ?> %</option>
                </select>
            </div>
        </td>
        <td nowrap style="padding-left: 5px !important;">
            <div class="form-group" style="margin-bottom: 0px !important;">
                <input 
                    class="form-control 
                    xCNInputNumericWithDecimal xWCreditNoteDisChgNum" 
                    onchange="JSxCreditNoteCalcDisChg(this);"
                    onkeyup="javascript:if(event.keyCode==13) JSxCreditNoteCalcDisChg(this);"
                    type="text">
            </div>
        </td>
        <td nowrap class="text-center">
            <label class="xCNTextLink">
                <img class="xCNIconTable xWCreditNoteDisChgRemoveIcon" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSxCreditNoteResetDisChgRemoveRow(this)">
            </label>
        </td>
    </tr>


</script>

<?php include('script/jCreditNoteDisChgModal.php'); ?>





































































































































