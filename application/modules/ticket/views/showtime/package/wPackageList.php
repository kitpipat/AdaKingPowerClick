<div class="xCNMrgNavMenu">
    <div class="row xCNavRow" style="width:inherit;">
        <div class="xCNBchVMaster">
            <div class="col-xs-8 col-md-8">
                <ol id="oliMenuNav" class="breadcrumb">
                    <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketEvent')"><?= language('ticket/event/event', 'tEventInformation') ?></li>
                        <li class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketShowTime/<?php echo $nEvnID; ?>')"><?= language('ticket/event/event', 'tManageEvents') ?></li>
                        <li class="xCNLinkClick"><?= language('ticket/event/event', 'tPackageList') ?></li>
                        </ol>
                            </div>
                                <div class="col-xs-12 col-md-4 text-right p-r-0">
                                    <div class="demo-button xCNBtngroup">
                                    <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                                <?php if ($oEvent[0]->FDEvnFinish != ''): ?>
                                    <?php if (date("Ymd") >= date("Ymd", strtotime($oEvent[0]->FDEvnFinish))): ?>				
                                    <?php else: ?>
                                        <button type="button" class="xCNBTNPrimeryPlus" onclick="javascipt: JSxCallPage('<?php echo base_url(); ?>EticketShowTimeAddPackage/<?php echo $nEvnID; ?>/<?php echo $nLocID; ?>');">+<?= language('ticket/event/event', 'tAddPackage') ?></button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button type="button" class="xCNBTNPrimeryPlus" onclick="javascipt: JSxCallPage('<?php echo base_url(); ?>EticketShowTimeAddPackage/<?php echo $nEvnID; ?>/<?php echo $nLocID; ?>');">+</button>
                                <?php endif; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        <div class="main-content">
            <div class="panel panel-headline">
                <div class="panel-heading">   
                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tPackageList') ?></label>  
                    <div>  
                        <?php if (@$oPackageList[0]->FNPkgID != ""): ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="xCNTextBold text-center" style="width:5%;text-align:center;"><?= language('ticket/zone/zone', 'tNo') ?></th>
                                        <th class="text-center"><?= language('ticket/zone/zone', 'tName') ?></th>
                                        <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('ticket/zone/zone', 'tDelete') ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                            <tbody>
                                <?php foreach ($oPackageList AS $key => $oValue): ?>
                                    <?php $tNumber = $key + 1; ?>
                                        <tr>
                                            <td scope="row" class="text-center"><?php echo $tNumber; ?></td>
                                            <td>
                                            <?php echo $oValue->FTPkgName; ?>
                                            </td>
                                            <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                                            <td class="text-center">
                                            <a href="#" onclick="FSxCSHTDelPackage('<?= $oValue->FNPkgID; ?>', '<?= $nEvnID; ?>', '<?= $nLocID; ?>');">
                                            <img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/delete.png'?>">				
                                                    </a>
                                                </td>
                                            <?php endif; ?>								
                                        </tr>
                                    <?php endforeach; ?>			
                                </tbody>
                            </table>
                        <?php else: ?>	
                            <div style="margin: auto; text-align: center; padding: 50px;">
                                <?= language('ticket/user/user', 'tDataNotFound') ?>
                            </div>								
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        	
<!-- Load Lang Eticket -->
<?php if ($_SESSION['lang'] == 'en'):?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jEN.js"></script>
<?php else:?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jTH.js"></script>
<?php endif?>
  
<input type="hidden" value="<?php echo $nEvnID; ?>" id="ohdGetEventId">
<script type="text/javascript" src="<?php echo base_url('application/modules/ticket/assets/src/showtime/jShowTime.js'); ?>"></script>