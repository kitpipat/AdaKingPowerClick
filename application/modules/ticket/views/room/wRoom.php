<div class="row">
	<div class="xCNBCMenu xWHeaderMenu">
		<div class="row">
			<div class="col-md-12">
				<h5> <a onclick="JSxCallPage('<?php echo base_url();?>/model')"><?= language('ticket/zone/zone', 'tInformation', 'สาขา') ?></a> / 
				<a onclick="JSxCallPage('<?php echo base_url();?>Location/<?= $oHeader[0]->FNPmoID ?>/<?= $oHeader[0]->FTPmoName ?>')"><?= $oHeader[0]->FTPmoName ?></a> / 
				<a onclick="JSxCallPage('<?php echo base_url();?>Zone/<?= $oHeader[0]->FNLocID ?>')"><?= language('ticket/zone/zone', 'tManagelocations') ?></a> / <?= $oZne[0]->FTZneName ?></h5>
			</div>
		</div>
	</div>
	<div class="main-content">
		<div class="container-fluid">
			<div class="row xWLocation" id="odvModelData">
				<div class="col-md-3">	
					<?php
                        if(isset($oHeader[0]->FTImgObj) && !empty($oHeader[0]->FTImgObj)){
                            $tFullPatch = './application/modules/common/assets/system/systemimage/'.$oHeader[0]->FTImgObj;
                            if (file_exists($tFullPatch)){
                                $tPatchImg = base_url().'/application/modules/common/assets/system/systemimage/'.$oHeader[0]->FTImgObj;
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/5,3.png';
                            }
                        }else{
                            $tPatchImg = base_url().'application/modules/common/assets/images/5,3.png';
                        }
                    ?>
					<img class="img-reponsive" src="<?=$tPatchImg;?>">
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
					<button class="btn btn-default" onclick="JSxCallPage('<?php echo base_url();?>Level/<?= $oHeader[0]->FNLocID ?>')">
						<?= language('ticket/zone/zone', 'tLevel') ?>
					</button>
					<button class="btn btn-default" style="border-color: #000;" onclick="JSxCallPage('<?php echo base_url();?>Zone/<?= $oHeader[0]->FNLocID ?>')">
						<?= language('ticket/zone/zone', 'tZone') ?>
					</button>
					<button class="btn btn-default" onclick="JSxCallPage('<?php echo base_url();?>Gate/<?= $oHeader[0]->FNLocID ?>')">
						<?= language('ticket/zone/zone', 'tGate') ?>
					</button>
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
		</div>
	</div>
		<hr>
		<div class="xWwrapBox">
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">				
							<?php if ($oAuthen[0]->FTGadStaAlwW == '1'): ?>
								<button type="button" class="btn btn-outline-primary pull-right" onclick="javascipt: JSxCallPageResult('<?= base_url()?>AddRoom/<?php echo $nLocID; ?>/<?php echo $nZneID; ?>','.xWwrapBox');">+ <?= language('ticket/zone/zone', 'tAddData') ?></button>
							<?php endif; ?>	
							<h4>
								<?= language('ticket/room/room', 'tRoominformation') ?>
							</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<div class="input-group">
								<input type="text" id="oetSCHFTRoomName" onkeypress="javascript: if (event.keyCode == 13) {event.preventDefault(); JSxRoomCount();}" name="oetSCHFTRoomName" class="form-control" placeholder="<?= language('ticket/room/room', 'tSearchRoom') ?>">
								<span class="input-group-btn">
									<button class="btn btn-default btn_search" style="padding: 6px 15px;" onclick="JSxRoomCount();" type="button">
										<i class="fa fa-search"></i>
									</button>
								</span>
							</div>
						</div>
						<div class="col-md-4"></div>
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