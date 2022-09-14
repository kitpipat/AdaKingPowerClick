<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbPriDT4CSTTable" class="table">
                <thead>
                    <tr>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4CSTUnit')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4CSTUnitFact')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4CSTDocNo')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4CSTDocType')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4CSTCustomerGrp')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4CSTDateStart')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4CSTDateEnd')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4CSTPriceRet')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4CSTPriceWhs')?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTViewMDPriDT4CSTPriceNet')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aPdtData4CST) && $aPdtData4CST['rtCode'] == 1):?>
                        <?php foreach($aPdtData4CST['raItems'] AS $nKey => $aPdt4CSTValue): ?>
                            <tr>
                                <td nowrap class="text-left"><?php echo $aPdt4CSTValue['rtPunName'];?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4CSTValue['rtUnitFact'],0);?></td>
                                <td nowrap class="text-left"><?php echo $aPdt4CSTValue['rtPghDocNo'];?></td>
                                <?php
                                    if($aPdt4CSTValue['rtPghDocType'] == 1){
                                        $tPdtDocType   = language('product/product/product','tPDTViewMDPriDTBasePrice');
                                    }else if($aPdt4CSTValue['rtPghDocType'] == 2){
                                        $tPdtDocType   = language('product/product/product','tPDTViewMDPriDTPriceOff');
                                    }else{
                                        $tPdtDocType    = "-";
                                    }
                                ?>
                                <td nowrap class="text-center"><?php echo $tPdtDocType;?></td>
                                <td nowrap class="text-left"><?php echo $aPdt4CSTValue['rtCstGrpName'];?></td>
                                <td nowrap class="text-center"><?php echo date("Y-m-d",strtotime($aPdt4CSTValue['rdPghDStart']));?></td>
                                <td nowrap class="text-center"><?php echo date("Y-m-d",strtotime($aPdt4CSTValue['rdPghDStop']));?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4CSTValue['rcPgdPriceRet'],$nDecimalNumberFM)?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4CSTValue['rcPgdPriceWhs'],$nDecimalNumberFM)?></td>
                                <td nowrap class="text-center"><?php echo number_format($aPdt4CSTValue['rcPgdPriceNet'],$nDecimalNumberFM)?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?php echo language('product/product/product','tPDTViewMDPriDT4CSTNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aPdtData4CST['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aPdtData4CST['rnCurrentPage']?> / <?php echo $aPdtData4CST['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPagePriceList btn-toolbar pull-right">
            <?php if($aPdtData4CST['rnCurrentPage'] == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPdtPriceListClickPage('previous')" class="btn btn-white btn-sm xWPDT4PDTPageClick" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php if(isset($aPdtData4CST) && $aPdtData4CST['rtCode'] == 1): ?>
                <?php for($i = max($aPdtData4CST['rnCurrentPage']-2, 1); $i <= max(0,min($aPdtData4CST['rnAllPage'],$aPdtData4CST['rnCurrentPage']+2)); $i++):?> 
                    <?php 
                        if($aPdtData4CST['rnCurrentPage'] == $i){ 
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

            <?php if($aPdtData4CST['rnCurrentPage'] >= $aPdtData4CST['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPdtPriceListClickPage('next')" class="btn btn-white btn-sm xWPDT4PDTPageClick" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>