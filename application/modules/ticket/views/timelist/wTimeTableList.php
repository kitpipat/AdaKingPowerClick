<table class="table table-striped">
    <thead>
        <tr>
            <th style="width: 50px;"><?= language('ticket/zone/zone', 'tNo') ?></th>
            <th><?= language('ticket/zone/zone', 'tName') ?></th>
            <th><?= language('ticket/event/event', 'tDateFrom') ?></th>
            <th><?= language('ticket/event/event', 'tDateTo') ?></th>
            <th><?= language('ticket/event/event', 'tDoorOpeningPeriodBeforeShow') ?><?= language('ticket/event/event', 'tMinute') ?></th>
            <th><?= language('ticket/event/event', 'tDuration') ?><?= language('ticket/event/event', 'tMinute') ?></th>
            <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                <th class="xCNTextBold" style="width:6%;text-align:center;"><?= language('ticket/zone/zone', 'tDelete') ?></th>
            <?php endif; ?>
            <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                <th class="xCNTextBold" style="width:6%;text-align:center;"><?= language('ticket/zone/zone', 'tEdit') ?></th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (@$oList[0]->FNTmhID == ""): ?>	
            <tr><th colspan="8"><div style="text-align: center; padding: 20px;"><?= language('ticket/user/user', 'tDataNotFound') ?></div></th></tr>						
        <?php else: ?>	
            <?php foreach ($oList as $key => $oValue): ?>
                <?php $n = $key + 1; ?>	
                <tr>
                    <td scope="row"><?= $oValue->RowID ?></td>
                    <td>
                        <a onclick="JSxTLTSTModalShow('<?= $oValue->FNTmhID ?>');" data-toggle="modal" data-target="#oModalShowTimeST" style="cursor: pointer;"> <img class="xCNIconTable"  src="<?php echo base_url().'application/modules/common/assets/images/icons/icons8-Search-100.png'?>"> <?= $oValue->FTTmhName; ?></a>
                    </td>
                    <td>
                        <?= date("d-m-Y", strtotime($oValue->FDShwStartDate)); ?>
                    </td>
                    <td>
                        <?php if ($oValue->FDShwEndDate != ""): ?>
                            <?= date("d-m-Y", strtotime($oValue->FDShwEndDate)); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= (int)$oValue->FNShwCallB4Start; ?>
                    </td>
                    <td>
                        <?= (int)$oValue->FNShwDuration; ?>
                    </td>
                    <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                        <td class="text-center">
                            <img class="xCNIconTable"  src="<?php echo base_url().'application/modules/common/assets/images/icons/delete.png'?>" onclick="JSxTLTDelTimeTableST('<?= $oValue->FNEvnID; ?>', '<?= $oValue->FNLocID; ?>', '<?= $oValue->FNTmhID; ?>', '<?= date("Y-m-d", strtotime($oValue->FDShwStartDate)); ?>', '<?= date("Y-m-d", strtotime($oValue->FDShwEndDate)); ?>', '<?= $oValue->FTTmhName; ?>');">	
                        </td>
                    <?php endif; ?>
                    <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                        <td class="text-center">
                        <img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/edit.png'?>" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketTimeTable/EditTimeTableST/<?= $oValue->FNEvnID; ?>/<?= $oValue->FNLocID; ?>/<?= $oValue->FNTmhID; ?>');")">
                           
                        </td>
                    <?php endif; ?>
                </tr>	
            <?php endforeach; ?>
        <?php endif; ?>	
    </tbody>
</table> 
<div class="modal fade" id="oModalShowTimeST" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="z-index:2000; margin-top: 60px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h5 class="modal-title" id="myModalLabel"><?= language('ticket/event/event', 'tShowTime') ?></h5>
            </div>
            <div class="modal-body">
                <div id="oDivModalShowTimeST"></div> 
            </div>
        </div>
    </div>
</div>                  		