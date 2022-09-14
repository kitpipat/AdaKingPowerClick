	<div class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="xCNBchVMaster">
					<div class="col-xs-8 col-md-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketBranchNew')" ><?= language('ticket/park/park', 'tBranchInformation') ?></li>
							<li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocationNew/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/zone/zone', 'tManagelocations') ?></li>
							<li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketZoneNew/<?= $nLocID ?>')"><?= language('ticket/zone/zone', 'tZoneInformation') ?></li>
							<li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/zone/zone', 'tRoomInformation') ?></li>
							</ol>
					</div>
					<div class="col-xs-12 col-md-4 text-right p-r-0">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="panel panel-headline">
			<div style="padding:20px;">	
				<div class="row xWLocation" id="odvModelData">
					<div class="col-md-3">		
						<?php if ($oHeader[0]->FTImgObj != ""): ?>
						<img class="img-reponsive" src="<?=base_url()?><?= $oHeader[0]->FTImgObj ?>">
						<?php else : ?>
							<img class="img-reponsive"	src="<?php echo base_url('application/modules/common/assets/images/5,3.png');?>">
						<?php endif ?>
					</div>
					<div class="col-md-5">
						<div>
							<b>
								<?php if($oHeader[0]->FTLocName): ?>
									<?= $oHeader[0]->FTLocName ?>
									<?php else: ?>
										<?= language('ticket/zone/zone', 'tNoData') ?>
									<?php endif; ?>
								</b> 
								<br>
								<div class="xWLocation-Detail">
									<?= language('ticket/zone/zone', 'tAmountLimit') ?>      <?php echo $oHeader[0]->FNLocLimit; ?> <?= language('ticket/zone/zone', 'tPersons') ?><br>
									<?= language('ticket/zone/zone', 'tOpeninghours') ?>      <?php echo $oHeader[0]->FTLocTimeOpening; ?> - <?php echo $oHeader[0]->FTLocTimeClosing; ?><br>      
									<?= language('ticket/zone/zone', 'tLocation') ?>            <?php if (@$oArea) : ?>
									<?php foreach(@$oArea AS $aValue): ?>
										<?php echo $aValue->FTPvnName .' - ' . $aValue->FTDstName; ?>
										<br>
									<?php endforeach; ?> 
								<?php endif ?>
							</div>
						</div>
					</div>
					<div class="col-md-4" style="text-align: right">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-xs-6 col-sm-6">
						<div class="xWNameSlider"><?= $oHeader[0]->FTLocName ?></div>
					</div>
					<div class="col-md-6 col-xs-6 col-sm-6 text-right" onclick="JSxMODHidden()">
						<span id="ospSwitchPanelModel">
							<i class="fa fa-chevron-up" aria-hidden="true"></i>
						</span>
					</div>
				</div>
				<hr>
				<div class="xWwrapBox">
					<div class="row">
						<div class="col-md-12">	
							<button class="xCNBTNPrimeryPlus" type="button" onclick="javascipt: JSxCallPageResult('<?= base_url()?>AddRoom/<?php echo $nLocID; ?>/<?php echo $nZneID; ?>','.xWwrapBox');">+</button>
							<!-- <button type="button" class="btn btn-outline-primary pull-right" onclick="javascipt: JSxCallPageResult('<?= base_url()?>AddRoom/<?php echo $nLocID; ?>/<?php echo $nZneID; ?>','.xWwrapBox');">+ <?= language('ticket/zone/zone', 'tAddData') ?></button> -->
							<h4>
								<?= language('ticket/room/room', 'tRoominformation') ?>
							</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
								<label class="xCNLabelFrm"><?= language('ticket/room/room', 'tSearchRoom') ?></label>
								<div class="input-group">
									<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSCHFTRoomName" name="oetSCHFTRoomName" onkeyup="javascript: if (event.keyCode == 13) {event.preventDefault();JSxRoomCount();}" value="">
									<span class="input-group-btn">
										<button class="btn xCNBtnSearch" type="button" onclick="JSxRoomCount()">
											<img onclick="JSxRoomCount();" class="xCNIconBrowse" src="<?=base_url();?>application/modules/common/assets/icons/search-24.png">
										</button>
									</span>
								</div>
							</div>
						</div>
					
					</div>
					<hr>
					<div id="oResultRoom"></div>       
					<div class="row">
						<div class="col-md-4 text-left grid-resultpage">
							<?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalRecordRoom"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a	class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActiveRoom">0</span> / <span id="ospTotalPageRoom">0</span></a>
						</div>
						<div class="col-md-8 text-right xWGridFooter xWBoxLocPark">
							<button type="button" id="oPreviousPage" onclick="return JSxRoomPreviousPage();" class="btn btn-default" data-toggle="tooltip" data-placement="left" data-original-title="Tooltip on left">
								<i class="fa fa-angle-left"></i> <?= language('ticket/zone/zone', 'tPrevious') ?>
							</button>
							<button type="button" id="oForwardPage" onclick="return JSxRoomForwardPage();"	class="btn btn-default" data-toggle="tooltip" data-placement="left"	data-original-title="Tooltip on left">
								<?= language('ticket/zone/zone', 'tForward') ?> <i class="fa fa-angle-right"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" value="<?php echo $nLocID; ?>" id="ohdGetLocID">
	<input type="hidden" value="<?php echo $nZneID; ?>" id="ohdGetZneID">
	<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/room/jRoom.js"></script>
	<script>
		window.onload = JSxRoomCount();
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