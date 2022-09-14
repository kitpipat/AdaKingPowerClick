<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbDOCChequeTable">
        <thead>
            <tr>
                <th width="5%" class="text-center"><?php echo language('document/deposit/deposit', 'tTBNo'); ?></th>
                <th width="20%" class="text-left"><?php echo language('document/deposit/deposit', 'tReferenceChequeNumber'); ?></th>
                <th width="20%" class="text-left"><?php echo language('document/deposit/deposit', 'tBank'); ?></th>
                <th width="40%" class="text-right"><?php echo language('document/deposit/deposit', 'tAmountOfMoney'); ?></th>
                <th width="5%" class="text-center"><?php echo language('document/deposit/deposit', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <tr class="xCNTextDetail2 xCNDepositChequeRow" data-seq-no="<?php echo $aValue['FNXtdSeqNo']; ?>">
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td class="text-left">
                            <input 
                            type="text" 
                            readonly
                            class="form-control xCNDepositChequeRefNo xCNApvOrCanCelDisabledCheque" 
                            value="<?php echo $aValue['FTBddRefNoForDeposit']; ?>">
                        </td>
                        <td class="text-left">
                            <input 
                            type="text"
                            readonly 
                            class="form-control xCNDepositChequeBank xCNApvOrCanCelDisabledCheque" 
                            value="<?php echo $aValue['FTBddRefBnkNameForDeposit']; ?>">
                        </td>
                        <td class="text-right">
                            <input 
                            type="number" 
                            class="xCNDepositChequeRefAmt xCNInputNumericWithoutDecimal xCNApvOrCanCelDisabledCheque text-right"
                            value="<?php echo $aValue['FCBddRefAmtForDeposit']; ?>">
                        </td>
                        <td class="text-center">
                            <img class="xCNIconTable xCNIconDel" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<!-- Cheque Total -->
<div class="row">
    <div class="col-md-7 text-left">
        <label class="xCNDepositChequeTotalText xCNDepositTotalLabel xCNDepositLabelFullWidth"><?php echo $aCalInTmp['FTBddRefAmtChequeTotalText']; ?></label>
    </div>
    <div class="col-md-5 text-right">
        <div class="xCNDepositLabelFullWidth">
            <label class="xCNDepositCashTotalLabel xCNDepositLabel pull-left"><?php echo language('document/deposit/deposit', 'tChequeDepositTotal'); ?></label><label class="xCNDepositChequeTotal xCNDepositTotalLabel xCNDepositLabelWidth"><?php echo $aCalInTmp['FCBddRefAmtChequeTotal']; ?></label>
        </div>
        <div class="xCNDepositLabelFullWidth">
            <label class="xCNDepositCashTotalLabel xCNDepositLabel pull-left"><?php echo language('document/deposit/deposit', 'tDues'); ?></label><label class="xCNDepositChequeDuesTotal xCNDepositTotalLabel xCNDepositLabelWidth">0.00</label>
        </div>
        <div class="xCNDepositLabelFullWidth">
            <label class="xCNDepositCashTotalLabel xCNDepositLabel pull-left"><?php echo language('document/deposit/deposit', 'tTax'); ?></label><label class="xCNDepositChequeVatTotal xCNDepositTotalLabel xCNDepositLabelWidth">0.00</label>
        </div>
        <div class="xCNDepositLabelFullWidth">
            <label class="xCNDepositCashTotalLabel xCNDepositLabel pull-left"><?php echo language('document/deposit/deposit', 'tGrandTotal'); ?></label><label class="xCNDepositChequeTotal xCNDepositTotalLabel xCNDepositLabelWidth"><?php echo $aCalInTmp['FCBddRefAmtChequeTotal']; ?></label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPage btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvDepositChequeDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvDepositChequeDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvDepositChequeDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<?php include('script/jDepositChequeDataTable.php'); ?>