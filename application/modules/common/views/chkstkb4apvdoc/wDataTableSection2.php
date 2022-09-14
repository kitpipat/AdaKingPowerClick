<h3><strong>รายการสินค้าที่สต๊อกไม่เพียงพอ</strong></h3>
<div class="table-responsive" style="max-height: 205px;">
    <table class="table table-striped" style="margin-bottom: 0px;">
        <thead>
            <tr>
                <th nowrap class="text-center" width="10%"><?= language('tool/loghistory','ลำดับ')?></th>
                <th nowrap class="text-center" width="20%"><?= language('tool/loghistory','รหัสสินค้า')?></th>
                <th nowrap class="text-center" width="25%"><?= language('tool/loghistory','ชื่อสินค้า')?></th>
                <th nowrap class="text-center" width="15%"><?= language('tool/loghistory','จำนวน')?></th>
                <th nowrap class="text-center" width="15%"><?= language('tool/loghistory','จำนวนคงเหลือ')?></th>
                <th nowrap class="text-center" width="15%"><?= language('tool/loghistory','จำนวนต้องการเพิ่ม')?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ( $nCode == 1 ){ ?>
                <?php foreach ($aItems as $nKey => $aValue) { ?>
                <tr>
                    <td nowrap class="text-center" style="vertical-align: middle;"><?=($nKey+1)?></td>
                    <td nowrap class="text-left" style="vertical-align: middle;"><?=$aValue['FTPdtCode']?></td>
                    <td nowrap class="text-left" style="vertical-align: middle;"><?=$aValue['FTPdtName']?></td>
                    <td nowrap class="text-right" style="vertical-align: middle;"><?=number_format($aValue['FCDTQty'], 2)?></td>
                    <td nowrap class="text-right" style="vertical-align: middle;"><?=number_format($aValue['FCStkQty'], 2)?></td>
                    <td nowrap class="text-right" style="vertical-align: middle;"><?=number_format($aValue['FCQtyDiff2'], 2)?></td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="100%" class="text-center"><?php echo language('bank/bank/bank','tBnkNoData'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>