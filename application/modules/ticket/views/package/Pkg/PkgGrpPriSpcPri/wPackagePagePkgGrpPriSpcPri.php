<input type="hidden" id="ohdPkgStaPrcDoc" value="<?= $oPkgDetail[0]->FTPkgStaPrcDoc?>">
<div class="row">
	<div class="col-lg-12 xCNBCMenu xWHeaderMenu">
		<div class="row">
			<div class="col-md-8">
				<?php if($nStaPage != '2'):?>
					<h5> <a onclick="JSxCallPagePkgSpcPriByGrp('<?= $nPkgID ?>','<?= $nPpkID ?>','<?= $tZneName ?>')"><?= language('ticket/package/package', 'tPkg_PriceByGroup')?> / <?= $tZneName ?> / <?= language('ticket/package/package', 'tPkg_SpacialPrice')?> </a> / <label id="olaPdtNameHeader" style="font-weight:normal;"><?=$tGrpName?></label></h5>
				<?php else: ?>
					<!--asd -->
					<h5><a onclick="JSnClickPdtPanal('<?= $nPkgID ?>')"><?= language('ticket/package/package', 'tPkg_Product')?>  / <?= $tZneName ?></a> / <a onclick="JSxPkgCallPagePdtGrpPri('<?= $nPpkID ?>','<?= $tZneName ?>')"><?= language('ticket/package/package', 'tPkg_GrpSpcPri')?></a> / <label id="olaPdtNameHeader" style="font-weight:normal;"><?=$tGrpName?></label></h5>
				<?php endif; ?>
				
				<input type="text" class="hidden" id="oetHidePgpGrpID" value="<?=$nPgpGrpID?>">
			</div>
			<div class="col-md-4 text-right">
				
			</div>
		</div>
	</div>
</div>
<div class="row">
		<div class="nav-tab-pills-image">
			<ul class="nav nav-tabs" role="tablist">
                 <li class="nav-item" id="oliTabGrpPriSpcPriByDOW" onclick="FSxCallPageGrpPriSpcPriByDOW('<?= $nPkgID ?>','<?= $nPgpGrpID ?>')">
                      <a class="nav-link flat-buttons active" id="olaTabGrpPriSpcPriByDOW" data-toggle="tab" href="#odvTabSpcPriByDOW" role="tab" aria-expanded="false">
                          	<?= language('ticket/package/package', 'tPkg_PriceByDOW')?>
                      </a>
                 </li>
                 <li class="nav-item" id="oliTabGrpPriSpcPriByHLD" onclick="FSxCallPageGrpPriSpcPriByHLD('<?= $nPkgID ?>','<?= $nPgpGrpID ?>')">
                      <a class="nav-link flat-buttons" id="olaTabGrpPriSpcPriByHLD" data-toggle="tab" href="#odvTabSpcPriByHLD" role="tab" aria-expanded="false">
                          	<?= language('ticket/package/package', 'tPkg_PriceByHLD')?>
                      </a>
                 </li>
                 <li class="nav-item" id="oliTabGrpPriSpcPriByBKG" onclick="FSxCallPageGrpPriSpcPriByBKG('<?= $nPkgID ?>','<?= $nPgpGrpID ?>')">
                      <a class="nav-link flat-buttons" id="olaTabGrpPriSpcPriByBKG" data-toggle="tab" href="#odvTabSpcPriByBKG" role="tab" aria-expanded="false">
                          	<?= language('ticket/package/package', 'tPkg_PriceByBKG')?>
                      </a>
                 </li>
            </ul>
            
            <div class="tab-content xWGrpPriHeight">
            	<div class="tab-pane active" id="odvTabSpcPriByDOW" role="tabpanel" aria-expanded="true" style="overflow: hidden;margin-top:10px;" >
            		<div id="odvTabGrpPriSpcPriByDOWPanal">
						<!-- Model HTML -->
            		</div>
            		<div id="odvTabBottomByDOWPanal" style="position: absolute;bottom: 15px;right: 40px;">
						<!-- Footter HTML -->
						<button type="submit" class="btn btn-outline-primary btn-primary" onclick="JSxClickGotoTabHLD();">
							<label class="xCNLabelColorWhite"><?= language('ticket/package/package', 'tPkg_Next')?></label>
						</button>
            		</div>
            	</div>
            	<div class="tab-pane active" id="odvTabSpcPriByHLD" role="tabpanel" aria-expanded="true" style="overflow: hidden;margin-top:10px;" >
            		<div id="odvTabGrpPriSpcPriByHLDPanal">
            			<!-- Product HTML -->
            		</div>
            		<div id="odvTabBottomByHLDPanal" style="position: absolute;bottom: 15px;right: 40px;">
						<!-- Footter HTML -->
						<button type="submit" class="btn btn-outline-primary btn-primary" onclick="JSxClickGotoTabBKG();">
							<label class="xCNLabelColorWhite"><?= language('ticket/package/package', 'tPkg_Next')?></label>
						</button>
            		</div>
            	</div>
            	<div class="tab-pane " id="odvTabSpcPriByBKG" role="tabpanel" aria-expanded="true" style="overflow: hidden;margin-top:10px;" >
            		<div id="odvTabGrpPriSpcPriByBKGPanal">
            			<!-- Product HTML -->
            		</div>
            		<div id="odvTabBottomByBKGPanal" style="position: absolute;bottom: 20px;right: 40px;">
						<!-- Footter HTML -->
						<button type="submit" class="btn btn-outline-primary btn-primary" onclick="JSxCallPagePkgDetail(<?=$nPkgID?>);">
							<label class="xCNLabelColorWhite"><?= language('ticket/package/package', 'tPkg_Done')?></label>
						</button>
            		</div>
            	</div>
            </div>
		</div>
</div>
<script>
	nStaPrcDoc = $('#ohdPkgStaPrcDoc').val();
	
	if(nStaPrcDoc != ''){
		nHeight = $(window).height()-247;
// 		$('.xWGrpPriHeight').css('height',nHeight)
		$('.xWPKGSearchPanal').css('display','none');
	}else{
		nHeight = $(window).height()-365;
// 		$('.xWGrpPriHeight').css('height',nHeight);
		$('.xWPKGSearchPanal').css('display','block');

		$('#odvTabGrpPriSpcPriByDOWPanal').css('height',nHeight-200);
		
	}
</script>

