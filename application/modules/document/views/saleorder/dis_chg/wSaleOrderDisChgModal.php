<input type="hidden" id="ohdSODisChgType">
<div class="modal fade" id="odvSODisChgPanel" style="max-width: 1500px; margin: 1.75rem auto; width: 85%;">
    <div class="modal-dialog" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title xWPIDisChgHeadPanel" style="display:inline-block"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="btn-group pull-right" style="margin-bottom: 20px; width: 300px;">
                            <button 
                                type="button" 
                                id="obtSOAddDisChg" 
                                class="btn xCNBTNPrimery pull-right" 
                                onclick="JCNvSOAddDisChgRow()" 
                                style="width: 100%;"><?php echo language('document/saleorder/saleorder','tSOMDAddEditDisChg') ?></button>
                        </div>
                    </div>
                </div>
                <!-- Ref DisChg HD Table -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div id="odvSODisChgHDTable"></div>
                    </div>
                </div>
                <!-- Ref DisChg DT Table -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div id="odvSODisChgDTTable"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main','tCancel');?>
                </button>
                <button onclick="JSxSODisChgSave()" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main','tCMNOK');?>
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/html" id="oscSOTrBodyTemplate">
    <tr class="xWPIDisChgTrTag">
        <input type="hidden" class="xWPIDisChgCreatedAt">
        <td nowrap class="text-center"><label class="xWPIDisChgIndex"></label></td>
        <td nowrap class="text-right"><label class="xWPIDisChgBeforeDisChg">{cBeforeDisChg}</label></td>
        <td nowrap class="text-right"><label class="xWPIDisChgValue">{cDisChgValue}</label></td>
        <td nowrap class="text-right"><label class="xWPIDisChgAfterDisChg">{cAfterDisChg}</label></td>
        <td nowrap style="padding-left: 5px !important;">
            <div class="form-group" style="margin-bottom: 0px !important;">
                <select class="dischgselectpicker form-control xWPIDisChgType" onchange="JSxSOCalcDisChg(this); JCNxSODisChgSetCreateAt(this);">
                    <option value='1' selected="true"><?php echo language('common/main/main','tCMNBahtdiscount');?></option>
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
                    xCNInputNumericWithDecimal xWPIDisChgNum" 
                    onchange="JSxSOCalcDisChg(this); JCNxSODisChgSetCreateAt(this)"
                    onkeyup="javascript:if(event.keyCode==13) JSxSOCalcDisChg(this); JCNxSODisChgSetCreateAt(this)"
                    type="text">
            </div>
        </td>
        <td nowrap class="text-center">
            <label class="xCNTextLink">
                <img class="xCNIconTable xWPIDisChgRemoveIcon" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSxSOResetDisChgRemoveRow(this)">
            </label>
        </td>
    </tr>
</script>
<?php include('script/jSaleorderDisChgModal.php'); ?>