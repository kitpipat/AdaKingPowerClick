<input type="hidden" id="ohdPkgStaPrcDoc" value="<?= $oPkgDetail[0]->FTPkgStaPrcDoc?>">
<div class="row">
	<div class="col-lg-12 xCNBCMenu xWHeaderMenu">
		<div class="row">
			<div class="col-md-8">
				<h5> <a onclick="JSxCallPageModelAndPdtPanal('<?= $nPkgID ?>')"><?= language('ticket/package/package', 'tPkg_Model')?> / <?= language('ticket/package/package', 'tPkg_SpacialPrice')?> </a> / <label id="olaPdtNameHeader" style="font-weight:normal;"><?=$tZneName?></label></h5>
				<input type="text" class="hidden" id="oetHidePgpGrpID" value="<?=$nPpkID?>">
			</div>
			<div class="col-md-4 text-right">
			
			</div>
		</div>
	</div>
</div>
<div class="row">
		<div class="nav-tab-pills-image">
			<ul class="nav nav-tabs" role="tablist">
                 <li class="nav-item" id="oliTabPkgPriDOW" onclick="FSxCallPagePkgPriByDOW('<?=$oPkgDetail[0]->FNPkgID?>','<?=$nPpkID?>');">
                      <a class="nav-link flat-buttons" id="olaTabPkgPriDOW" data-toggle="tab" href="#odvTabPkgPriDOW" role="tab" aria-expanded="false">
                          	<?= language('ticket/package/package', 'tPkg_PriceByDOW')?>
                      </a>
                 </li>
                 <li class="nav-item" id="oliTabPkgPriHoliday" onclick="FSxCallPagePkgSpcPriByHLD('<?=$oPkgDetail[0]->FNPkgID?>','<?=$nPpkID?>');">
                      <a class="nav-link flat-buttons" id="olaTabPkgPriHoliday" data-toggle="tab" href="#odvTabPkgPriHoliday" role="tab" aria-expanded="false">
                          	<?= language('ticket/package/package', 'tPkg_PriceByHLD')?>
                      </a>
                 </li>
                 <li class="nav-item" id="oliTabPkgPriBooking" onclick="FSxCallPagePkgPriByBKG('<?=$oPkgDetail[0]->FNPkgID?>','<?=$nPpkID?>');">
                      <a class="nav-link flat-buttons" id="olaTabPkgPriBooking" data-toggle="tab" href="#odvTabPkgPriBooking" role="tab" aria-expanded="false">
                          	<?= language('ticket/package/package', 'tPkg_PriceByBKG')?>
                      </a>
                 </li>
            </ul>
            
            <div class="tab-content xWGrpPriHeight">
            	<div class="tab-pane active" id="odvTabPkgPriDOW" role="tabpanel" aria-expanded="true" style="overflow: hidden;margin-top:10px;" >
            		<div id="odvTabPkgPriDOWPanal">
            			<!-- Product HTML -->
            		</div>
			    <!--<div id="odvTabBottomByDOWPanal" style="position: absolute;bottom: 40px;right: 40px;">
						
						<button type="submit" class="btn btn-outline-primary" onclick="JSxClickGotoTabHLD();">ต่อไป</button>
            		</div>-->
            	</div>
            	<div class="tab-pane active" id="odvTabPkgPriHoliday" role="tabpanel" aria-expanded="true" style="overflow: hidden;margin-top:10px;" >
            		<div id="odvTabPkgPriHLDPanal">
            			<!-- Product HTML -->
            		</div>
            		<!--<div id="odvTabBottomByHLDPanal" style="position: absolute;bottom: 40px;right: 40px;">
						<button type="submit" class="btn btn-outline-primary" onclick="JSxClickGotoTabBKG();">ต่อไป</button>
            		</div>-->
            	</div>
            	<div class="tab-pane active" id="odvTabPkgPriBooking" role="tabpanel" aria-expanded="true" style="overflow: hidden;margin-top:10px;" >
            		<div id="odvTabPkgPriBKGPanal">
            			<!-- Product HTML -->
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

		$('#odvTabGrpPriSpcPriByDOWPanal').css('height',nHeight);
		
	}

</script>

