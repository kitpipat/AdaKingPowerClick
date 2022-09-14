<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbPriDT4ZNETable" class="table">
                <thead>
                    <tr>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4ZNEUnit')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4ZNEUnitFact')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4ZNEDocNo')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4ZNEDocType')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4ZNEZoneName')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4ZNEDateStart')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4ZNEDateEnd')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4ZNEPriceRet')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4ZNEPriceWhs')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4ZNEPriceNet')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aPdtData4ZNE) && $aPdtData4ZNE['rtCode'] == 1): ?>
                        <?php foreach($aPdtData4ZNE['raItems'] AS $nKey => $aPdt4ZNEValue): ?>
                            <tr>
                                <td nowrap class="text-left"><?php echo $aPdt4ZNEValue['rtPunName'];?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4ZNEValue['rtUnitFact'],0);?></td>
                                <td nowrap class="text-left"><?php echo $aPdt4ZNEValue['rtPghDocNo'];?></td>
                                <?php
                                    if($aPdt4ZNEValue['rtPghDocType'] == 1){
                                        $tPdtDocType   = language('product/product/product','tPDTViewMDPriDTBasePrice');
                                    }else if($aPdt4ZNEValue['rtPghDocType'] == 2){
                                        $tPdtDocType   = language('product/product/product','tPDTViewMDPriDTPriceOff');
                                    }else{
                                        $tPdtDocType    = "-";
                                    }
                                ?>
                                <td nowrap class="text-center"><?php echo $tPdtDocType;?></td>
                                <td nowrap class="text-left"><?php echo $aPdt4ZNEValue['rtZneChainName'];?></td>
                                <td nowrap class="text-center"><?php echo date("Y-m-d",strtotime($aPdt4ZNEValue['rdPghDStart']));?></td>
                                <td nowrap class="text-center"><?php echo date("Y-m-d",strtotime($aPdt4ZNEValue['rdPghDStop']));?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4ZNEValue['rcPgdPriceRet'],$nDecimalNumberFM)?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4ZNEValue['rcPgdPriceWhs'],$nDecimalNumberFM)?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4ZNEValue['rcPgdPriceNet'],$nDecimalNumberFM)?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?php echo language('product/product/product','tPDTViewMDPriDT4ZNENotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aPdtData4ZNE['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aPdtData4ZNE['rnCurrentPage']?> / <?php echo $aPdtData4ZNE['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPagePriceList btn-toolbar pull-right">
            <?php if($aPdtData4ZNE['rnCurrentPage'] == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPdtPriceListClickPage('previous')" class="btn btn-white btn-sm xWPDT4PDTPageClick" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php if(isset($aPdtData4ZNE) && $aPdtData4ZNE['rtCode'] == 1): ?>
                <?php for($i = max($aPdtData4ZNE['rnCurrentPage']-2, 1); $i <= max(0,min($aPdtData4ZNE['rnAllPage'],$aPdtData4ZNE['rnCurrentPage']+2)); $i++):?> 
                    <?php 
                        if($aPdtData4ZNE['rnCurrentPage'] == $i){ 
                            $tActive = 'active'; 
                            $tDisPageNumber = 'disabled';
                        }else{ 
                            $tActive = '';
                            $tDisPageNumber = '';
                        }
                    ?>
                    <button onclick="JSvPdtPriceListClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php endfor; ?>
            <?php else: ?>
                <button onclick="JSvPdtPriceListClickPage('1')" type="button" class="btn xCNBTNNumPagenation active" disabled>1</button>
            <?php endif; ?>

            <?php if($aPdtData4ZNE['rnCurrentPage'] >= $aPdtData4ZNE['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPdtPriceListClickPage('next')" class="btn btn-white btn-sm xWPDT4PDTPageClick" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>