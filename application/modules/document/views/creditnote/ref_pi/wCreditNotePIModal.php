<div class="modal fade" id="odvCreditNotePIPanel" style="max-width: 1700px; margin: 1.75rem auto; width: 85%;">
    <div class="modal-dialog" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block">อ้างอิงเอกสาร: ใบรับของใบซื้อสินค้า / บริการ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Ref PI HD Table -->
                <div class="row">
                    <div class="col-md-9"><div id="odvCreditNoteRefPIHDTable"></div></div>
                    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmCreditNoteRefPIHDForm">                    
                        <div class="col-md-3">
                            <label class="xCNLabelFrm xWFont-size-30px"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'เงื่อนไขการค้นหา'); ?></label>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tCreditNoteTBStaApv'); ?></label>
                                <select class="selectpicker form-control" id="ocmStaApv" name="ocmStaApv" onchange="JSxCreditNotePIHDList(1);">
                                    <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                                    <option value='1'><?php echo language('common/main/main', 'tStaDocApv'); ?></option>
                                    <option value='2'><?php echo language('common/main/main', 'tStaDocPendingApv'); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'สถานะอ้างอิง'); ?></label>
                                <select class="selectpicker form-control" id="ocmStaRef" name="ocmStaRef" onchange="JSxCreditNotePIHDList(1);">
                                    <option value='0' selected="true"><?php echo language('common/main/main', 'tAll'); ?></option>
                                    <option value='1'><?php echo language('common/main/main', 'ไม่เคยอ้างอิง'); ?></option>
                                    <option value='2'><?php echo language('common/main/main', 'อ้างอิงบางส่วน'); ?></option>
                                    <option value='3'><?php echo language('common/main/main', 'อ้างอิงหมดแล้ว'); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'สถานะเคลื่อนไหว'); ?></label>
                                <select class="selectpicker form-control" id="ocmStaDocAct" name="ocmStaDocAct" onchange="JSxCreditNotePIHDList(1);">
                                    <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                                    <option value='1'><?php echo language('common/main/main', 'เคลื่อนไหว'); ?></option>
                                    <option value='2'><?php echo language('common/main/main', 'ไม่เคลื่อนไหว'); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'สถานะเอกสาร'); ?></label>
                                <select class="selectpicker form-control" id="ocmStaDoc" name="ocmStaDoc" onchange="JSxCreditNotePIHDList(1);">
                                    <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                                    <option value='1'><?php echo language('common/main/main', 'สมบูรณ์'); ?></option>
                                    <option value='2'><?php echo language('common/main/main', 'ไม่สมบูรณ์'); ?></option>
                                    <option value='3'><?php echo language('common/main/main', 'ยกเลิก'); ?></option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Ref PI HD Table -->
                
                <!-- Ref PI DT Table -->
                <div class="row">
                    <div class="col-md-12"><div id="odvCreditNoteRefPIDTTable"></div></div>
                </div>
                <!-- Ref PI DT Table -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'ยกเลิก'); ?>
                </button>
                <button onclick="JSxCreditNoteAddPdtFromPIToDTTemp()" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'ตกลง'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php include('script/jCreditNotePIModal.php'); ?>








































