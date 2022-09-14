<?php if (@$oDOFList[0]->FNLdoID != ''): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style=" width: 50px; "><?= language('ticket/zone/zone', 'tNo') ?></th>
                <th><?= language('ticket/dayoff/dayoff', 'tDayoff') ?></th>
                <th><?= language('ticket/dayoff/dayoff', 'tDescription') ?></th>
                <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                    <th><?= language('ticket/zone/zone', 'tDelete') ?></th>
                <?php endif; ?>
                <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                    <th><?= language('ticket/zone/zone', 'tEdit') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>		
            <?php foreach ($oDOFList as $key => $tValue) : ?>	
                <tr>
                    <td scope="row"><?= $tValue->RowID ?></td>
                    <td>
                        <?= date("d-m-Y", strtotime($tValue->FDLdoDateFrm)) ?> - <?= date("d-m-Y", strtotime($tValue->FDLdoDateTo)) ?>
                    </td>
                    <td><?= $tValue->FTLdoRmk ?></td>	
                    <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                        <td class="text-center" style=" width: 70px; ">
                            <img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/delete.png" onclick="JSxDOFDel('<?= $tValue->FNLdoID ?>', '<?= date("d-m-Y", strtotime($tValue->FDLdoDateFrm)) ?> - <?= date("d-m-Y", strtotime($tValue->FDLdoDateTo)) ?>')">
                        </td>
                    <?php endif; ?>
                    <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                        <td class="text-center" style=" width: 70px; ">
                            <img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/edit.png" onclick="JSxCallPage('<?php echo base_url() ?>EticketLocDayOffEditNew/<?= $tValue->FNLocID ?>/<?= $tValue->FNLdoID ?>');">
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach ?>		
        </tbody>
    </table>
<?php else: ?>
    <div style="margin: auto; text-align: center; padding: 50px;">
        <?= language('ticket/user/user', 'tDataNotFound') ?>
    </div>	
<?php endif ?>