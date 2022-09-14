<script>
	$(function(){
		$("#oEditGate").validate({
			rules: {
				oetFTGteName: "required",
				ocmFNZneID: "required"
			},
			messages: {
				oetFTGteName: "",
				ocmFNZneID: ""
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
					url: "<?php echo base_url(); ?>EticketEditGateAjax",
					data: $("#oEditGate").serialize(),
					cache: false,
					success: function (msg) {
						var nDataId = $('.xWBtnSaveActive').data('id');
						if (nDataId == '1') {
							JSxCallPage('<?php echo base_url()?>EticketEditGateNew/<?php echo $nLocID; ?>/<?= $oShow[0]->FNGteID ?>');
						} else if(nDataId == '2') {
							JSxCallPage('<?= base_url()?>EticketAddGateNew/<?php echo $nLocID; ?>');
						} else if(nDataId == '3') {
							JSxCallPage('<?php echo base_url()?>EticketGateNew/<?php echo $nLocID; ?>');
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
		$('.selection-2').select2();
	});
</script>
		<div class="main-menu">
			<div class="xCNMrgNavMenu">
				<div class="row xCNavRow" style="width:inherit;">
					<div class="xCNBchVMaster">
						<div class="col-xs-8 col-md-8">
							<ol id="oliMenuNav" class="breadcrumb">
								<li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url();?>/EticketBranchNew')"><?= language('ticket/park/park', 'tBranchInformation') ?></li>
<<<<<<< HEAD
								<li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url();?>EticketLocationNew/<?= $oHeader[0]->FNPmoID ?>/<?= $oHeader[0]->FTBchName ?>')"><?= language('ticket/zone/zone', 'tManagelocations') ?></li>
=======
								<!-- <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url();?>EticketLocationNew/<?= $oHeader[0]->FNPmoID ?>/<?= $oHeader[0]->FTBchName ?>')"><?= language('ticket/zone/zone', 'tManagelocations') ?></li> -->
								<li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketEditBranch/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/zone/zone', 'tEditPark') ?></li>
>>>>>>> 81bf17ac4472cccb47e9b8a7fad9daddc4181c76
								<li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url()?>EticketGateNew/<?php echo $nLocID; ?>')"><?= language('ticket/gate/gate', 'tGateInformation') ?></li>
								<li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/gate/gate', 'tEditGate') ?></li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>


	<form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="oEditGate"> 

		<div class="main-content">
			<div class="panel panel-headline">
				<div style="padding:20px;">
					<div class="row">
						<div class="col-md-8">
						</div>
						<div class="col-md-4 text-right">
							<button type="button" onclick="JSxCallPage('<?php echo base_url()?>EticketGateNew/<?php echo $nLocID; ?>');" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
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
					
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="hidden" name="ohdFNLocID" id="ohdFNLocID" value="<?= $nLocID ?>">								
							<input type="hidden" name="ohdFNGteID" id="ohdFNGteID" value="<?= $oShow[0]->FNGteID ?>">		
							<div class="form-group">
								<div data-validate="<?= language('ticket/gate/gate', 'tPleaseSelectZone') ?>">
									<label class="xCNLabelFrm"><?= language('ticket/gate/gate', 'tSelectZone') ?></label>
									<select class="selectpicker form-control" id="ocmFNZneID" name="ocmFNZneID" title="<?= language('ticket/gate/gate', 'tSelectZone') ?>">
										<?php if ($oSlc[0]->FNZneID == "") : ?>
										<option value=""><?= language('ticket/gate/gate', 'tNoZoneFound') ?></option>
										<?php else : ?>
											<?php  foreach ($oSlc as $key => $tValue) : ?>
												<option value="<?= $tValue->FNZneID ?>" <?php if ($oShow[0]->FNZneID == $tValue->FNZneID) {echo 'selected="selected"';} ?>><?= $tValue->FTZneName ?></option>
											<?php  endforeach; ?>
										<?php  endif; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="xCNLabelFrm"><?= language('ticket/gate/gate', 'tNameGate') ?></label>
								<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTGteName" name="oetFTGteName" value="<?= $oShow[0]->FTGteName ?>">
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12"></div>
					</div>
				</div>
			</div>
		</div>

		</form> 

		<input type="hidden" value="<?php echo $nLocID; ?>" id="ohdGetLocID">
		<script>

			$('.selectpicker').selectpicker();

			function JSxMODHidden(){
				$('#odvModelData').slideToggle();
				setTimeout(function(){ 
					if ($('#odvModelData').css('display') == 'block') {				
						$('#ospSwitchPanelModel').html('<i class="fa fa-chevron-up" aria-hidden="true"></i>');
					} else if ($('#odvModelData').css('display') == 'none') {								
						$('#ospSwitchPanelModel').html('<i class="fa fa-chevron-down" aria-hidden="true"></i>');
					}
					
				}, 800);
				$('.xWNameSlider').toggleClass('xWshow');
			}
		</script>