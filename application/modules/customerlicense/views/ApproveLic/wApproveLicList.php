<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
			<div class="col-xs-4 col-md-2 col-lg-2">
				<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegDate')?></label>
					<div class="input-group">
						<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oedAPCLicStart" name="oedAPCLicStart" value="<?=date('Y-m-d')?>" autocomplete="off" >
							<span class="input-group-btn">
							<button id="otbAPCLicStart" type="button" class="btn xCNBtnDateTime">
								<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-4 col-md-3 col-lg-3">
				<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCSTSearch')?></label>
					<div class="form-group">
						<input type="text" class="form-control" id="oetAPCKeyword" name="oetAPCKeyword" autocomplete="off" placeholder="<?= language('common/main/main','tPlaceholder')?>" >
						 
					</div>
				</div>
			</div>
		
			<div class="col-xs-4 col-md-5 col-lg-5 text-left" style="margin-top:22px;">
            <button id="" class="btn xCNBTNPrimery" type="button" style="width: 120px;" onclick="JSvAPCApproveLicGetDataTable()"><?= language('customerlicense/customerlicense/customerlicense','tRegStaFindData')?></button>
			</div>
		</div>
    </div>
    <div class="panel-body">
        <!--- Data Table -->
        <section id="ostDataApproveLic"></section>
        <!-- End DataTable-->
    </div>
</div>




<div class="modal fade" id="odvModalDelCustomer">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main', 'tModalDelete')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <span id="ospConfirmDelete"></span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" onClick="JSnCSTDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                        <?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>
<script>

// DATE
$('#otbAPCLicStart').click(function(){
event.preventDefault();
$('#oedAPCLicStart').datepicker('show');
});
//เนลแก้ไขให้เลือกวันที่น้อยกว่าวันปัจจุบัน
$('.xCNDatePicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    startDate:'1900-01-01',
});


</script>