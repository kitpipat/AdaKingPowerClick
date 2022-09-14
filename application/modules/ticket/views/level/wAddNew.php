<script>
	$(function () {
		$("#oAddFloor").validate({			
			rules: {
				oetFTLevName: "required"
			},
			messages: {
				oetFTLevName: "",
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
					url: "<?php echo base_url(); ?>EticketAddLevelAjax",
					data: $("#oAddFloor").serialize(),
					cache: false,
					success: function (msg) {   
						var nDataId = $('.xWBtnSaveActive').data('id');
						if (nDataId == '1') {
							JSxCallPage('<?= base_url()?>EticketEditLevelNew/<?= $nLocID ?>/'+msg);
						} else if(nDataId == '2') {
							JSxCallPage('<?= base_url()?>EticketAddLevelNew/<?php echo $nLocID; ?>');
						} else if(nDataId == '3') {
							JSxCallPage('<?php echo base_url()?>EticketLevelNew/<?php echo $nLocID; ?>');
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

	<div class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="xCNBchVMaster">
					<div class="col-xs-8 col-md-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<li  class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketBranchNew')" ><?= language('ticket/park/park', 'tBranchInformation') ?></li>
							<!-- <li  class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocationNew/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/zone/zone', 'tManagelocations') ?></li> -->
							<li  class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url() ?>EticketEditBranch/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/park/park', 'tEditPark') ?></li> 
							<li  class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url()?>EticketLevelNew/<?php echo $nLocID; ?>')"><?= language('ticket/level/level', 'tLevelInformation') ?></li>
							<li  class="xCNLinkClick"><?= language('ticket/level/level', 'tAddLevel') ?></li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>

	<form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="oAddFloor">
		<div class="main-content">
			<div class="panel panel-headline">
				<div class="panel-heading">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-8">
							</div>
							<div class="col-md-4 text-right">
								<button type="button" onclick="JSxCallPage('<?php echo base_url()?>EticketLevelNew/<?php echo $nLocID; ?>')" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
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
								<div class="form-group">
									<label class="xCNLabelFrm"><?= language('ticket/level/level', 'tNameLevel') ?></label>
									<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTLevName" name="oetFTLevName">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>      


	<input type="hidden" value="<?php echo $nLocID; ?>" id="ohdGetLocID">
	<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/level/jLevel.js"></script>
	<script>
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