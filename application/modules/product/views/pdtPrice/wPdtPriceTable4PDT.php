<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbPriDT4PDTTable" class="table">
                <thead>
                    <tr>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4PDTUnit')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4PDTUnitFact')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4PDTDocNo')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4PDTDocType')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4PDTDateStart')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4PDTDateEnd')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4PDTPriceRet')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4PDTPriceWhs')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4PDTPriceNet')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aPdtData4PDT) && $aPdtData4PDT['rtCode'] == 1):?>
                        <?php foreach($aPdtData4PDT['raItems'] AS $nKey => $aPdt4PDTValue): ?>
                            <tr>
                                <td nowrap class="text-left"><?php echo $aPdt4PDTValue['rtPunName'];?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4PDTValue['rtUnitFact'],0);?></td>
                                <td nowrap class="text-left"><?php echo $aPdt4PDTValue['rtPghDocNo'];?></td>
                                <?php
                                    if($aPdt4PDTValue['rtPghDocType'] == 1){
                                        $tPdtDocType   = language('product/product/product','tPDTViewMDPriDTBasePrice');
                                    }else if($aPdt4PDTValue['rtPghDocType'] == 2){
                                        $tPdtDocType   = language('product/product/product','tPDTViewMDPriDTPriceOff');
                                    }else{
                                        $tPdtDocType    = "-";
                                    }
                                ?>
                                <td nowrap class="text-center"><?php echo $tPdtDocType;?></td>
                                <td nowrap class="text-center"><?php echo date("Y-m-d",strtotime($aPdt4PDTValue['rdPghDStart']));?></td>
                                <td nowrap class="text-center"><?php echo date("Y-m-d",strtotime($aPdt4PDTValue['rdPghDStop']));?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4PDTValue['rcPgdPriceRet'],$nDecimalNumberFM)?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4PDTValue['rcPgdPriceWhs'],$nDecimalNumberFM)?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4PDTValue['rcPgdPriceNet'],$nDecimalNumberFM)?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?php echo language('product/product/product','tPDTViewMDPriDT4PDTNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aPdtData4PDT['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aPdtData4PDT['rnCurrentPage']?> / <?php echo $aPdtData4PDT['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPagePriceList btn-toolbar pull-right">
            <?php if($aPdtData4PDT['rnCurrentPage'] == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPdtPriceListClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php if(isset($aPdtData4PDT) && $aPdtData4PDT['rtCode'] == 1): ?>
                <?php for($i = max($aPdtData4PDT['rnCurrentPage']-2, 1); $i <= max(0,min($aPdtData4PDT['rnAllPage'],$aPdtData4PDT['rnCurrentPage']+2)); $i++):?> 
                    <?php 
                        if($aPdtData4PDT['rnCurrentPage'] == $i){ 
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
            

            <?php if($aPdtData4PDT['rnCurrentPage'] >= $aPdtData4PDT['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPdtPriceListClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>