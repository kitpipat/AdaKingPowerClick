<input type="hidden" id="ohdPkgStaPrcDoc" value="<?= $oPkgDetail[0]->FTPkgStaPrcDoc?>">
<div class="row">
	<div class="col-lg-12 xCNBCMenu xWHeaderMenu">
		<div class="row">
			<div class="col-md-8">
				<span onclick="JSnClickPdtPanal('<?= $nPkgID ?>')"><?= language('ticket/package/package', 'tPkg_Product')?></span>  / <label id="olaPdtNameHeader" style="font-weight:normal;"></label>
				<input type="text" class="hidden" id="oetHidePkgPdtID" value="<?= $nPkgPdtID ?>">
			</div>
			<div class="col-md-4 text-right">
				
			</div>
		</div>
	</div>
</div>


<div class="main-content">
        <div class="container-fluid">
<div class="row">
		<div class="nav-tab-pills-image">
			<ul class="nav nav-tabs" role="tablist">
                 <li class="nav-item  active" id="oliTabPdtSpcPriByWeek" onclick="FSxCallPagePdtPriSpcPriByDOW('<?= $nPkgID ?>','<?= $nPkgPdtID ?>')">
                      <a class="nav-link flat-buttons active" id="olaTabPdtPriSpcPriByDOW" data-toggle="tab" href="#odvTabSpcPriByDOW" role="tab" aria-expanded="false">
                          	<?= language('ticket/package/package', 'tPkg_PriceByDOW')?>
                      </a>
                 </li>
                 <li class="nav-item" id="oliTabPdtSpcPriByHLD" onclick="FSxCallPagePdtPriSpcPriByHLD('<?= $nPkgID ?>','<?= $nPkgPdtID ?>')">
                      <a class="nav-link flat-buttons" id="olaTabPdtPriSpcPriByHLD" data-toggle="tab" href="#odvTabSpcPriByHLD" role="tab" aria-expanded="false">
                          	<?= language('ticket/package/package', 'tPkg_PriceByHLD')?>
                      </a>
                 </li>
                 <li class="nav-item" id="oliTabPdtSpcPriByBKG" onclick="FSxCallPagePdtPriSpcPriByBKG('<?= $nPkgID ?>','<?= $nPkgPdtID ?>')">
                      <a class="nav-link flat-buttons" id="olaTabPdtPriSpcPriByBKG" data-toggle="tab" href="#odvTabSpcPriByBKG" role="tab" aria-expanded="false">
                          	<?= language('ticket/package/package', 'tPkg_PriceByBKG')?>
                      </a>
                 </li>
            </ul>
            
            <div class="tab-content xWPdtPriHeight">
            	<div class="tab-pane active" id="odvTabSpcPriByDOW" role="tabpanel" aria-expanded="true" style="overflow: hidden;margin-top:10px;" >
            		<div id="odvTabPdtPriSpcPriByDOWPanal">
						<!-- Model HTML -->
            		</div>
            	</div>
            	<div class="tab-pane" id="odvTabSpcPriByHLD" role="tabpanel" aria-expanded="true" style="overflow: hidden;margin-top:10px;" >
            		<div id="odvTabSpcPriByHLDPanal">
            			<!-- Product HTML -->
            		</div>
            	</div>
            	<div class="tab-pane" id="odvTabSpcPriByBKG" role="tabpanel" aria-expanded="true" style="overflow: hidden;margin-top:10px;" >
            		<div id="odvTabSpcPriByBKGPanal">
            			<!-- Product HTML -->
            		</div>
            	</div>
            </div>
		</div>
</div>
</div>
</div>

<script>

	nStaPrcDoc = $('#ohdPkgStaPrcDoc').val();
	
	if(nStaPrcDoc != ''){
		nHeight = $(window).height()-247;
// 		$('.xWPdtPriHeight').css('height',nHeight)
		$('.xWPKGSearchPanal').css('display','none');
	}else{
		nHeight = $(window).height()-365;
// 		$('.xWPdtPriHeight').css('height',nHeight);
		$('.xWPKGSearchPanal').css('display','block');

		$('#odvTabPdtPriSpcPriByDOWPanal').css('height',nHeight);
		
	}



</script>