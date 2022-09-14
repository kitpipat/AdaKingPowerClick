<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage   = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbSOTblDataDocHDList" class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <th nowrap class="xCNTextBold"><?php echo language('document/purchaseorder/purchaseorder','tPOLabelFrmBranch')?></th>
						<th nowrap class="xCNTextBold"><?php echo language('document/purchaseorder/purchaseorder','tPOTBDocNo')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/purchaseorder/purchaseorder','tPOTBDocDate')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/purchaseorder/purchaseorder','tPOTBStaDoc')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue): ?>
                            <?php
                                $tTRDocNo    = $aValue['FTXthDocNo'];
                                $tTRBchCode  = $aValue['FTBchCode'];

                                //FTXthStaDoc
                                if ($aValue['FTXthStaDoc'] == 3) {
                                    $tClassStaDoc = 'text-danger';
                                    $tStaDoc = language('common/main/main', 'tStaDoc3');
                                } else if ($aValue['FTXthStaApv'] == 1) {
                                    $tClassStaDoc = 'text-success';
                                    $tStaDoc = language('common/main/main', 'tStaDoc1');
                                } else {
                                    $tClassStaDoc = 'text-warning';
                                    $tStaDoc = language('common/main/main', 'tStaDoc');
                                }

                                 //FTXthStaDoc
                                 if($aValue['FNXthStaRef'] == 2){
                                    $tClassStaRef = 'text-success';
                                }else if($aValue['FNXthStaRef'] == 1){
                                    $tClassStaRef = 'text-warning';
                                }else if($aValue['FNXthStaRef'] == 0){
                                    $tClassStaRef = 'text-danger';
                                }

                                $tClassPrcStk = 'text-success';
                                $bIsApvOrCancel = ($aValue['FTXthStaApv'] == 1 || $aValue['FTXthStaApv'] == 2) || ($aValue['FTXthStaDoc'] == 3 );

                                $aDateDoc = explode("/",$aValue['FDXthDocDate']);
                                $tDateDoc = $aDateDoc[2].'-'.$aDateDoc[1].'-'.$aDateDoc[0];

                            ?>
                            <tr style="cursor:pointer;" class="text-center xCNTextDetail2 xWPIDocItems xDocuemntRefInt"
                                    id="otrPurchaseInvoiceRefInt<?php echo $nKey?>"
                                    data-docno="<?=$aValue['FTXthDocNo']?>"
                                    data-docdate="<?=$tDateDoc?>"
                                    data-bchcode="<?=$tTRBchCode?>"
                                    data-vatinroex="<?=$aValue['FTXthVATInOrEx']?>"
                                  

                                    data-bchfrm="<?=$aValue['FTXthBchFrm']?>"
                                    data-bchnamefrm="<?=$aValue['FTXthBchNameFrm']?>"
                                    data-wahfrm="<?=$aValue['FTXthWhFrm']?>"
                                    data-wahnamefrm="<?=$aValue['FTXthWhNameFrm']?>"
                                    data-bchto="<?=$aValue['FTXthBchTo']?>"
                                    data-bchnameto="<?=$aValue['FTXthBchNameTo']?>"
                                    data-wahto="<?=$aValue['FTXthWhTo']?>"
                                    data-wahnameto="<?=$aValue['FTXthWhNameTo']?>"
                            >

                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTBchName']))? $aValue['FTBchName']   : '-' ?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTXthDocNo']))? $aValue['FTXthDocNo'] : '-' ?></td>
                                <td nowrap class="text-center"><?php echo (!empty($aValue['FDXthDocDate']))? $aValue['FDXthDocDate'] : '-' ?></td>
                                <td nowrap class="text-left">
                                    <label class="xCNTDTextStatus <?php echo $tClassStaDoc;?>">
                                        <?php echo $tStaDoc ?>
                                    </label>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPIPageDataTable btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvIVRefIntClickPageList('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php
                    if($nPage == $i){
                        $tActive = 'active';
                        $tDisPageNumber = 'disabled';
                    }else{
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvIVRefIntClickPageList('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvIVRefIntClickPageList('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="">
    <div id="odvRefIntDocDetail"></div>
</div>

<?php include('script/jTransferBchOutRefDocDataTable.php')?>
