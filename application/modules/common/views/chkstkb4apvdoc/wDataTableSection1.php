<h3><strong>เอกสารรอการอนุมัติ</strong></h3>
<div class="table-responsive" style="max-height: 205px;">
    <table class="table table-striped" style="margin-bottom: 0px;">
        <thead>
            <tr>
                <th nowrap class="text-center" width="10%"><?= language('tool/loghistory','ลำดับ')?></th>
                <th nowrap class="text-center" width="20%"><?= language('tool/loghistory','ประเภทเอกสาร')?></th>
                <th nowrap class="text-center" width="10%"><?= language('tool/loghistory','วันที่เอกสาร')?></th>
                <th nowrap class="text-center" width="30%"><?= language('tool/loghistory','เลขที่เอกสาร')?></th>
                <th nowrap class="text-center" width="30%"><?= language('tool/loghistory','ผู้สร้างเอกสาร')?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ( $nCode == 1 ){ ?>
                <?php foreach ($aItems as $nKey => $aValue) { ?>
                <tr>
                    <td nowrap class="text-center" style="vertical-align: middle;"><?=($nKey+1)?></td>
                    <td nowrap class="text-left" style="vertical-align: middle;"><?=$aValue['FTXthDocType']?></td>
                    <td nowrap class="text-center" style="vertical-align: middle;"><?=date_format(new DateTime($aValue['FDXthDocDate']),"d/m/Y")?></td>
                    <td nowrap class="text-left" style="vertical-align: middle;"><?=$aValue['FTXthDocNo']?></td>
                    <td nowrap class="text-left" style="vertical-align: middle;"><?=$aValue['FTUsrName']?></td>
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
<hr>