<div class="row">
    <?php if (@$oPrkList[0]->FNPmoID != ''): ?>
        <?php foreach ($oPrkList AS $aValue): ?>	
            <div class="col-md-3 col-sm-3 col-xs-12" style="position: relative; margin-bottom: 10px;">
                <div class="panel panel-default panel-profile m-b-0">
                    <?php if ($aValue->FTImgObj != ""): ?>
                        <div class="panel-heading" title="<?= language('ticket/park/park', 'tManage') ?>" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocation/<?= $aValue->FNPmoID ?>')" style="cursor: pointer; height: 200px; background-repeat: no-repeat; background-size: 100% 100%; background-image: url('<?= base_url() ?><?= $aValue->FTImgObj ?>');"></div>		
                    <?php else : ?>
                        <div class="panel-heading" title="<?= language('ticket/park/park', 'tManage') ?>" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocation/<?= $aValue->FNPmoID ?>')" style="cursor: pointer; height: 200px; background-repeat: no-repeat; background-size: 100% 100%; background-image: url('<?= base_url('application/modules/common/assets/images/Noimage.png') ?>')"></div>	
                    <?php endif ?>
                    <div class="panel-body text-center" style="padding-right: 10px; padding-left: 10px;">                
                        <h5 class="panel-title" style="height: 33px; overflow: hidden;"><?php if ($aValue->FTPmoName != ""): ?><?= $aValue->FTPmoName ?><?php else: ?><?= language('ticket/zone', 'tNoData') ?><?php endif ?></h5>         
                        <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                            <button class="btn btn-default xCNBTNPrimery pull-left" style="text-align: center; padding-left: 0 !important; padding-right: 0 !important; width: 45%;" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocation/<?= $aValue->FNPmoID ?>')">
                                <?= language('ticket/park/park', 'tManagelocations') ?>
                            </button>
                        <?php else: ?>
                            <button class="btn btn-default xCNBTNPrimery" style="text-align: center; padding-left: 0 !important; padding-right: 0 !important; width: 45%;" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocation/<?= $aValue->FNPmoID ?>')">
                                <?= language('ticket/park/park', 'tManagelocations') ?> 
                            </button>
                        <?php endif; ?>               
                        <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                            <button class="btn btn-danger xCNBTNDefult pull-right" style="width: 45%;" data-name="<?= $aValue->FTPmoName ?>" onclick="JSxPRKDel('<?= @$aValue->FNPmoID; ?>', this)">
                                <?= language('ticket/zone/zone', 'tDelete') ?>				
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>	
        <?php endforeach; ?>
    <?php else: ?>
        <div style="margin: auto; text-align: center; padding: 50px;">
            <?= language('ticket/user/user', 'tDataNotFound') ?>
        </div>
    <?php endif ?>
</div>