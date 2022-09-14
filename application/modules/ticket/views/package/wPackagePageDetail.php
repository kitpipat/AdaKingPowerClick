	<!-- รายละเอียดแพ็คเกจ  -->
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="xCNBchVMaster">
				<div class="col-xs-8 col-md-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo Base_url()?>/EticketPackage')"><?= language('ticket/package/package', 'tPkg_Package') ?></li>
						<li class="xCNLinkClick"><?=$oPkgDetail[0]->FTPkgName?></li>
						<input type="text" class="hidden" id="oetHidePckID" value="<?=$oPkgDetail[0]->FNPkgID?>">
					</ol>
				</div>
				<div class="col-xs-12 col-md-4 text-right p-r-0">
				</div>
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="panel panel-headline">
			<div class="panel-heading">		
				<div class="row">
					<div class="col-lg-12" style="padding-top: 10px; padding-bottom: 20px; margin-bottom: 10px; border-bottom: 1px solid #e3e3e3;">
						<div class="row xWPackage" id="odvHeaderPkgDetailPanal" style="display:none">
							<div class="col-md-12">
								<div class="col-md-3">
									<?php
										if(isset($oPkgDetail[0]->FTImgObj) && !empty($oPkgDetail[0]->FTImgObj)){
											$tFullPatch = './application/modules/common/assets/system/systemimage/'.$oPkgDetail[0]->FTImgObj;
											if (file_exists($tFullPatch)){
												$tPatchImg = base_url().'/application/modules/common/assets/system/systemimage/'.$oPkgDetail[0]->FTImgObj;
											}else{
												$tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
											}
										}else{
											$tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
										}
									?>
									<img id="xWimg-Package" src="<?= $tPatchImg ?>" style="width:100%;" >
								</div>
								<div class="col-md-4">
									<div> 
										<b><?=$oPkgDetail[0]->FTPkgName?></b><br>
										<div class="xWLocation-Detail">
													<?= language('ticket/package/package', 'tPkg_DateUse')?> <?=$oPkgDetail[0]->FDPkgStartChkIn?> - <?=$oPkgDetail[0]->FDPkgStopChkIn?><br>
													<?= language('ticket/package/package', 'tPkg_MaxPark')?> <?=$oPkgDetail[0]->FNPkgMaxPark?> <br>      
													<?= language('ticket/package/package', 'tPkg_ProductGroup')?> <?=$oPkgDetail[0]->FTTcgName?> <?= language('ticket/package/package', 'tPkg_CanChkIn')?> <?=$oPkgDetail[0]->FNPkgMaxChkIn?><br>  
										</div>                       
									</div>                                                        
								</div>
								<div class="col-md-4">
									<div> 
										<p style="margin: 0px 0 0px;"><?=language('ticket/package/package', 'tPkg_PackagePkgType'.$oPkgDetail[0]->FTPkgType)?>  
									
										</p>
										<p style="margin: 0px 0 0px;">
											<?= language('ticket/package/package', 'tPkg_Type')?> <?=language('ticket/package/package', 'tPkg_PackageStaLimitType'.$oPkgDetail[0]->FTPkgStaLimitType)?>  
										</p>
									</div>                                                        
								</div>
								<div class="col-md-1" style="text-align:right">           
									<button class="btn btn-primary" onclick="JSxCallPageEditPkg('<?=$oPkgDetail[0]->FNPkgID?>');"> <i class="fa fa-pencil"></i> <?= language('ticket/package/package', 'tPkg_Edit')?></button>                 
								</div> 
							</div>           
						</div>
						
						<div class="row">
							<div class="col-md-8">
								<a class="xWPkgNameSlider" style="display: block;" onclick="JSxCallPageEditPkg('<?=$oPkgDetail[0]->FNPkgID?>');" style="cursor:pointer"><?=$oPkgDetail[0]->FTPkgName?></a>
							</div>
							<div class="col-md-4 text-right">
								<div class="col-md-12 text-right" >
									<span onclick="JSxPKGSlide()">			
										<span id="ospSwitchPanelModel">
											<i class="fa fa-chevron-down" aria-hidden="true"></i>
										</span>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="odvPkgDetailPanal" style="">
				<!-- 	Content HTML  -->
				</div>
			</div>
		</div>
	</div>

<script>

// $('#oliTabPkgModel').click();
function JSxPKGSlide(){

	$('#odvHeaderPkgDetailPanal').slideToggle();
	setTimeout(function(){
		if ($('#odvHeaderPkgDetailPanal').css('display') == 'block') {
			
			$('#ospSwitchPanelModel').html('<i class="fa fa-chevron-up" aria-hidden="true"></i>');
		} else if ($('#odvHeaderPkgDetailPanal').css('display') == 'none') {
		
			$('#ospSwitchPanelModel').html('<i class="fa fa-chevron-down" aria-hidden="true"></i>');
		}
		
	}, 500);
	$('.xWPkgNameSlider').toggleClass('xWNameSliderShow');
}

</script>