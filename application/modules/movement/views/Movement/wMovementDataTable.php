<?php
if ($aDataList['rtCode'] == '1') {
    $nCurrentPage = $aDataList['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
?>

<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?= $nCurrentPage; ?>">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBOrder') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBPdtCode') ?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBPdtName') ?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBDate') ?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBDocNo') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBWaHouse') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBMonthEnd') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBIn') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBOut') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBSale') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBReturn') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBUpdate') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement', 'tMMTBTreasury') ?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) {  ?>
                            <tr class="xCNTextDetail2 otrReason" id="otrReason<?= $key ?>" data-code="<?= $aValue['FTPdtCode'] ?>" data-name="<?= $aValue['FTPdtName'] ?>">
                                <td nowrap class="text-center" style="text-align: center;"><?= $aValue['rtRowID'] ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTPdtCode'] ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTPdtName'] ?></td>
                                <td nowrap class="text-center"><?=date_format(date_create($aValue['FDStkDate']),'Y-m-d H:i:s') ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTStkDocNo'] ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTWahName'] ?></td>
                                <td nowrap class="text-right"><?php echo number_format($aValue['FCStkMonthEnd'], $nOptDecimalShow); ?></td>
                                <td nowrap class="text-right"><?php echo number_format($aValue['FCStkIN'], $nOptDecimalShow); ?></td>
                                <td nowrap class="text-right"><?php echo number_format($aValue['FCStkOUT'], $nOptDecimalShow); ?></td>
                                <td nowrap class="text-right"><?php echo number_format($aValue['FCStkSale'], $nOptDecimalShow); ?></td>
                                <td nowrap class="text-right"><?php echo number_format($aValue['FCStkReturn'], $nOptDecimalShow); ?></td>
                                <td nowrap class="text-right"><?php echo number_format($aValue['FCStkAdjust'], $nOptDecimalShow); ?></td>
                                <td nowrap class="text-right"><?php echo number_format($aValue['FCStkQtyInWah'], $nOptDecimalShow); ?></td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='13' style="text-align: center;"><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row" style="margin-bottom:10px;">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageReasonGrp btn-toolbar pull-right">
            <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button id="obtMmtFirstPage" data-ngotopage="1" onclick="JSvClickPage(1)" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i><i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <button id="obtMmtPreviousPage" data-ngotopage="<?= $nCurrentPage - 1; ?>" onclick="JSvClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage + 2)); $i++) { ?>
                <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ -->
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <button onclick="JSvClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button id="obtMmtNextPage" data-ngotopage="<?= $nCurrentPage + 1; ?>" onclick="JSvClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
            <button id="obtMmtLastPage" data-ngotopage="<?= $aDataList['rnAllPage']; ?>" onclick="JSvClickPage(<?= $aDataList['rnAllPage']; ?>)" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i><i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>