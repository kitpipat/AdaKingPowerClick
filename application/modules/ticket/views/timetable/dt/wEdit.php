<script>
	$(document).ready(function () {
		//Btn Datetime Click
		$('#obtFTTmdStartTime').click(function(){
            event.preventDefault();
            $('#oetFTTmdStartTime').datetimepicker('show');
		});

		$('#obtFTTmdEndTime').click(function(){
            event.preventDefault();
            $('#oetFTTmdEndTime').datetimepicker('show');
		});
		//Btn Datetime Click

		$(".xWEditTimeTableDT").validate({
			rules: {
				oetFTTmdName: "required",
				oetFTTmdStartTime: "required",
				oetFTTmdEndTime: "required",
			},
			messages: {
				oetFTTmdName: "",
				oetFTTmdStartTime: "",
				oetFTTmdEndTime: "",
			},
			errorClass: "alert-validate",
			validClass: "",
			highlight: function (element, errorClass, validClass) {
				$(element).parent('.validate-input').addClass(errorClass).removeClass(validClass);
				$(element).parent().parent('.validate-input').addClass(errorClass).removeClass(validClass);       
			},
			unhighlight: function (element, errorClass, validClass) {
				$(element).parent('.validate-input').removeClass(errorClass).addClass(validClass);
				$(element).parent().parent('.validate-input').removeClass(errorClass).addClass(validClass);
			},
			submitHandler: function (form) {
				$('button[type=submit]').attr('disabled', true);
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>EticketTimeTable/EditTimeTableDTAjax",
					data: $(".xWEditTimeTableDT").serialize(),
					cache: false,
					success: function (msg) {
                                            console.log(msg);
                                            
						if (parseInt(msg) != 0) {
							var nDataId = $('.xWBtnSaveActive').data('id');
							if (nDataId == '1') {
								JSxCallPage('<?php echo base_url()?>EticketTimeTable/EditTimeTableDT/<?= $oShow[0]->FNTmdID; ?>/<?= $nFNTmhID ?>');
							} else if(nDataId == '2') {
								JSxCallPage('<?= base_url()?>EticketTimeTable/AddTimeTableDT/<?= $nFNTmhID ?>');
							} else if(nDataId == '3') {
								JSxCallPage('<?php echo base_url('EticketTimeTableDT')?>/<?= $nFNTmhID ?>');
							}
						} else {
							 $('.xWBtnGrpSaveLeft').prop("disabled", false);
							 bootbox.alert({
								title: '<?= language('ticket/timetable/timetable', 'tWarning') ?>',
								message: '<?= language('ticket/timetable/timetable', 'tThisPeriodCanNotBeUsed') ?>',
								callback: function () {
									$('.bootbox').modal('hide');
								}
							});
						}						
					},
					error: function (data) {
						console.log(data);
					}
				});
				return false;
			}
		});   
		$('#oetFTTmdStartTime').datetimepicker({
			format : 'HH:mm',
			locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
		});
		$('#oetFTTmdEndTime').datetimepicker({
			format : 'HH:mm',
			locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
		});
		$('[title]').tooltip();
	});
</script>
<form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" class="xWEditTimeTableDT">
	<div class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="xCNBchVMaster">
					<div class="col-xs-8 col-md-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url('EticketTimeTable')?>')"><?= language('ticket/timetable/timetable', 'tTimeTableInformation') ?></li>
							<li class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url('EticketTimeTableDT')?>/<?= $nFNTmhID ?>')"><?= language('ticket/timetable/timetable', 'tShowInformation') ?></li>
							<li class="xCNLinkClick"><?= language('ticket/timetable/timetable', 'tEditShow') ?></li>
						</ol>
					</div>
					<div class="col-xs-12 col-md-4 text-right p-r-0">
						<button type="button" onclick="JSxCallPage('<?php echo base_url('EticketTimeTableDT')?>/<?= $nFNTmhID ?>')" class="btn btn-default xCNBTNDefult"><?= language('ticket/user/user', 'tCancel') ?></button>
						<div class="btn-group">
							<button class="btn btn-default xWBtnGrpSaveLeft" type="submit"><?= language('ticket/user/user', 'tSave') ?></button>
							<button type="button" class="btn btn-default xWBtnGrpSaveRight dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu xWDrpDwnMenuMargLft">
								<li class="xWolibtnsave1 xWBtnSaveActive" data-id="1" onclick="JSvChangeBtnSaveAction(1)"><a href="#"><?=language('common/main/main', 'tCMNSaveAndView')?></a></li>
								<li class="xWolibtnsave2" data-id="2" onclick="JSvChangeBtnSaveAction(2)"><a href="#"><?=language('common/main/main', 'tCMNSaveAndNew')?></a></li>
								<li class="xWolibtnsave3" data-id="3" onclick="JSvChangeBtnSaveAction(3)"><a href="#"><?=language('common/main/main', 'tCMNSaveAndBack')?></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		

	<input type="hidden" name="ohdFNTmdID" id="ohdFNTmdID" value="<?= $oShow[0]->FNTmdID; ?>" />		
	<input type="hidden" name="ohdFNTmhID" id="ohdFNTmhID" value="<?= $oShow[0]->FNTmhID; ?>" />		
	<div class="main-content">
		<div class="panel panel-headline">
					<div class="panel-heading">
				<div class="row">			
					<div class="col-md-4 col-sm-4 col-xs-12">
						<div class="form-group" >
							<label class="xCNLabelFrm"><?= language('ticket/timetable/timetable', 'tShowName') ?></label>
							<input type="text" class="form-control" id="oetFTTmdName" name="oetFTTmdName" data-validate="<?= language('ticket/timetable/timetable', 'tPleaseEnterShowName') ?>" value="<?= $oShow[0]->FTTmdName; ?>">
						</div>

						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('ticket/timetable/timetable', 'tShowFrom') ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetFTTmdStartTime" name="oetFTTmdStartTime" value="<?= $oShow[0]->FTTmdStartTime; ?>" data-validate="<?= language('ticket/timetable/timetable', 'tPleaseEnterShowFrom') ?>">
								<span class="input-group-btn">
									<button id="obtFTTmdStartTime" type="button" class="btn xCNBtnDateTime">
										<img src="<?= base_url(); ?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
									</button>
								</span>
							</div>
						</div>

						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('ticket/timetable/timetable', 'tShowTo') ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetFTTmdEndTime" name="oetFTTmdEndTime" value="<?= $oShow[0]->FTTmdEndTime; ?>" data-validate="<?= language('ticket/timetable/timetable', 'tPleaseEnterShowTo') ?>">
								<span class="input-group-btn">
									<button id="obtFTTmdEndTime" type="button" class="btn xCNBtnDateTime">
										<img src="<?= base_url(); ?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
									</button>
								</span>
							</div>
						</div>			
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12"></div>
				</div>			
			</div>		
		</div>	
	</div>			
</form>