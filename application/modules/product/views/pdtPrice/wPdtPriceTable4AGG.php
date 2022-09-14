<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbPriDT4AGGTable" class="table">
                <thead>
                    <tr>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4AGGUnit')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4AGGUnitFact')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4AGGDocNo')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4AGGDocType')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4AGGAgencyName')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4AGGDateStart')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4AGGDateEnd')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4AGGPriceRet')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4AGGPriceWhs')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4AGGPriceNet')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aPdtData4AGG) && $aPdtData4AGG['rtCode'] == 1): ?>
                        <?php foreach($aPdtData4AGG['raItems'] AS $nKey => $aPdt4AGGValue): ?>
                            <tr>
                                <td nowrap class="text-left"><?php echo $aPdt4AGGValue['rtPunName'];?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4AGGValue['rtUnitFact'],0);?></td>
                                <td nowrap class="text-left"><?php echo $aPdt4AGGValue['rtPghDocNo'];?></td>
                                <?php
                                    if($aPdt4AGGValue['rtPghDocType'] == 1){
                                        $tPdtDocType   = language('product/product/product','tPDTViewMDPriDTBasePrice');
                                    }else if($aPdt4AGGValue['rtPghDocType'] == 2){
                                        $tPdtDocType   = language('product/product/product','tPDTViewMDPriDTPriceOff');
                                    }else{
                                        $tPdtDocType    = "-";
                                    }
                                ?>
                                <td nowrap class="text-center"><?php echo $tPdtDocType;?></td>
                                <td nowrap class="text-left"><?php echo $aPdt4AGGValue['rtAggName'];?></td>
                                <td nowrap class="text-center"><?php echo date("Y-m-d",strtotime($aPdt4AGGValue['rdPghDStart']));?></td>
                                <td nowrap class="text-center"><?php echo date("Y-m-d",strtotime($aPdt4AGGValue['rdPghDStop']));?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4AGGValue['rcPgdPriceRet'],$nDecimalNumberFM)?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4AGGValue['rcPgdPriceWhs'],$nDecimalNumberFM)?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4AGGValue['rcPgdPriceNet'],$nDecimalNumberFM)?></td>
                            </tr>
                        <?php endforeach;?>
                    <?php else: ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?php echo language('product/product/product','tPDTViewMDPriDT4BCHNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aPdtData4AGG['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aPdtData4AGG['rnCurrentPage']?> / <?php echo $aPdtData4AGG['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPagePdtPrice4PDT btn-toolbar pull-right">
                <?php if($aPdtData4AGG['rnCurrentPage'] == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvPdtPriceListClickPage('previous')" class="btn btn-white btn-sm xWPDT4PDTPageClick" <?php echo $tDisabledLeft ?>>
                    <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
                </button>

                <?php if(isset($aPdtData4AGG) && $aPdtData4AGG['rtCode'] == 1): ?>
                    <?php for($i = max($aPdtData4AGG['rnCurrentPage']-2, 1); $i <= max(0,min($aPdtData4AGG['rnAllPage'],$aPdtData4AGG['rnCurrentPage']+2)); $i++):?> 
                        <?php 
                            if($aPdtData4AGG['rnCurrentPage'] == $i){ 
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

                <!-- PageNation Next -->
                <?php if($aPdtData4AGG['rnCurrentPage'] >= $aPdtData4AGG['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvPdtPriceListClickPage('next')" class="btn btn-white btn-sm xWPDT4PDTPageClick" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
                <!-- End PageNation Next -->
            </div>
    </div>
</div>