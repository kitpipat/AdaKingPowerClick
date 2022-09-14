<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbDOCCashTable">
        <thead>
            <tr>
                <th width="5%" class="text-center"><?php echo language('document/deposit/deposit', 'tTBNo'); ?></th>
                <th width="40%" class="text-left"><?php echo language('document/deposit/deposit', 'tReferenceDate'); ?></th>
                <th width="50%" class="text-right"><?php echo language('document/deposit/deposit', 'tAmountOfMoney'); ?></th>
                <th width="5%" class="text-center"><?php echo language('document/deposit/deposit', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <tr class="xCNTextDetail2 xCNDepositCashRow" data-seq-no="<?php echo $aValue['FNXtdSeqNo']; ?>">
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td class="text-left">
                            <input 
                            type="text" 
                            class="form-control xCNDatePicker xCNDepositCashRefDate xCNApvOrCanCelDisabledCash" 
                            id="oetDepositCashRefDate_<?php echo $key+1; ?>" 
                            name="oetDepositCashRefDate_<?php echo $key+1; ?>" 
                            value="<?php echo empty($aValue['FDBddRefDateForDeposit']) ? '' : date('Y-m-d', strtotime($aValue['FDBddRefDateForDeposit'])); ?>">
                        </td>
                        <td class="text-right">
                            <input 
                            type="text" 
                            class="xCNDepositCashRefAmt xCNInputNumericWithDecimal xCNApvOrCanCelDisabledCash text-right"
                            value="<?php echo number_format($aValue['FCBddRefAmtForDeposit'], 2, ".", ""); ?>">
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

<!-- Cash Total -->
<!-- <div class="row">
    <div class="col-md-7 text-left">
        <label class="xCNDepositCashTotalText xCNDepositTotalLabel xCNDepositLabelFullWidth"><?php echo $aCalInTmp['FTBddRefAmtCashTotalText']; ?></label>
    </div>
    <div class="col-md-5 text-right">
        <div class="xCNDepositLabelFullWidth">
            <label class="xCNDepositCashTotalLabel xCNDepositLabel pull-left"><?php echo language('document/deposit/deposit', 'tCashDepositTotal'); ?></label><label class="xCNDepositCashTotal xCNDepositTotalLabel xCNDepositLabelWidth"><?php echo $aCalInTmp['FCBddRefAmtCashTotal']; ?></label>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPage btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvDepositCashDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvDepositCashDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvDepositCashDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<?php include('script/jDepositCashDataTable.php'); ?>