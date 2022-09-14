<script>
	$(document).ready(function () {
		$(".xWAddTimeTable").validate({
			rules: {
				oetFTTmhName: "required"
			},
			messages: {
				oetFTTmhName: "",
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
                                $('.xCNOverlay').show();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>EticketTimeTable/AddTimeTableAjax",
					data: $(".xWAddTimeTable").serialize(),
					cache: false,
					success: function (msg) {
						var nDataId = $('.xWBtnSaveActive').data('id');
						if (nDataId == '1') {
							JSxCallPage('<?php echo base_url()?>EticketTimeTable/EditTimeTable/'+msg);
						} else if(nDataId == '2') {
							JSxCallPage('<?= base_url()?>EticketTimeTable/AddTimeTable');
						} else if(nDataId == '3') {
							JSxCallPage('<?php echo base_url('EticketTimeTable')?>');
						}
                                                $('.xCNOverlay').hide();
					},
					error: function (data) {
						console.log(data);
                                                $('.xCNOverlay').hide();
					}
				});
				return false;
			}
		});   
		$('[title]').tooltip();
	});
</script>
<form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" class="xWAddTimeTable">
	<div class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="xCNBchVMaster">
					<div class="col-xs-8 col-md-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url('EticketTimeTable')?>')"><?= language('ticket/timetable/timetable', 'tTimeTableInformation') ?></li>
							<li class="xCNLinkClick"><?= language('ticket/timetable/timetable', 'tAddTimeTable') ?></li>
						</ol>
					</div>
					<div class="col-xs-12 col-md-4 text-right p-r-0">
						<button type="button" onclick="JSxCallPage('<?php echo base_url('EticketTimeTable')?>')" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
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

	<div class="main-content">
		<div class="panel panel-headline">
			<div class="panel-heading">
				<div class="row">			
					<div class="col-md-8 col-sm-4 col-xs-12">
						<div class="form-group" >
							<label class="xCNLabelFrm"><?= language('ticket/timetable/timetable', 'tNameTimeTable') ?></label>
							<input type="text" class="form-control" id="oetFTTmhName" name="oetFTTmhName" data-validate="<?= language('ticket/timetable/timetable', 'tPleaseEnterNameTimeTable') ?>">
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tRemarks') ?></label>				
							<textarea class="form-control" maxlength="100" id="otaFTTmhRmk" name="otaFTTmhRmk"></textarea>
						</div>
						<div class="form-group">
							<label class="pull-left" style="font-weight: normal;">
								<input type="checkbox" checked="checked" value="1" style="float: left; margin-right: 5px;" name="ocbFTTmhStaActive"> <?= language('ticket/timetable/timetable', 'tOpening') ?>
							</label>
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12"></div>
				</div>
			</div>
		</div>
	</div>
		
</form>