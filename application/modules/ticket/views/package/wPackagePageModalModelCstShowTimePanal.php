<div class="row">
    <div class="col-md-12">
        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_TimeTable') ?></label>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-control" id=odvPkgLocTimeTableHDPanal style="overflow-x:hidden;overflow-y:auto;border-color: rgb(238, 238, 238); border-style: solid; border-width: 2px;">
                        <?php if (isset($oLocTimeTableHD[0]->FNTmhID)): ?>
                            <?php foreach ($oLocTimeTableHD AS $aValue): ?>  
                                <div class="row" style="padding:5px; margin-right: -15px;">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="col-md-1 col-xs-1 xCNRemovePadding">
                                            <?= $aValue->FNTmhID ?> 
                                        </div>	
                                        <div class="col-md-9 col-xs-9 xCNRemovePadding">
                                            <?= $aValue->FTTmhName ?>
                                        </div>
                                        <div class="col-md-2 col-xs-2 text-right xCNRemovePadding">
                                            <?php if ($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
                                            <i class="fa fa-list " style="font-size: 15px;" onclick="JSxPkgViewDetailLocShowTime('<?= $aValue->FNTmhID ?> ');"></i> &nbsp;
                                            <i class="fa fa-plus-square" style="font-size: 15px;" onclick="JSxPkgAddLocShowTime('<?= $aValue->FNTmhID ?>');"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12 col-xs-12" style="padding-left: 0; padding-right: 0; margin-top: 5px;">
                <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_ShowTime') ?></label> 
                    <div class="xCNModPanal" id="odvPkgLocShowTimePanal" style="overflow-x:hidden;overflow-y:auto;border-color: rgb(238, 238, 238); border-style: solid; border-width: 2px;">
                        <div class="row">
                            <div class="col-md-12 col-xs-12" style="background: #eeeeee;">
                                <div class="col-md-1 col-xs-1 xCNRemovePadding">
                                    <?= language('ticket/package/package', 'tPkg_Round') ?>
                                </div>	
                                <div class="col-md-4 col-xs-4 xCNRemovePadding">
                                    <?= language('ticket/package/package', 'tName') ?>
                                </div>
                                <div class="col-md-3 col-xs-3 xCNRemovePadding">
                                    <?= language('ticket/package/package', 'tPkg_RoundStartsFromDate') ?>
                                </div>
                                <div class="col-md-3 col-xs-3 xCNRemovePadding">
                                    <?= language('ticket/package/package', 'tPkg_RoundToDate') ?>
                                </div>
                                <div class="col-md-4 col-xs-4 text-right xCNRemovePadding">
                                </div>
                            </div>
                        </div>
                        <?php if (isset($oLocShwTime[0]->FNEvnID)): ?>
                            <?php foreach ($oLocShwTime AS $aValue): ?>  
                                <div class="row" style="padding:5px;">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="col-md-1 col-xs-1 xCNRemovePadding">
                                            <?= $aValue->FNTmhID ?> 
                                        </div>	
                                        <div class="col-md-4 col-xs-4 xCNRemovePadding">
                                            <?= $aValue->FTTmhName ?>
                                        </div>
                                        <div class="col-md-3 col-xs-3 xCNRemovePadding">
                                            <?= $aValue->FDShwStartDate ?> 
                                            <?= $aValue->FTShwStartTime ?> 
                                        </div>
                                        <div class="col-md-3 col-xs-3 xCNRemovePadding">
                                            <?= $aValue->FDShwEndDate ?> 
                                            <?= $aValue->FTShwEndTime ?> 
                                        </div>
                                        <div class="col-md-1 col-xs-1 text-right xCNRemovePadding">
                                            <?php if ($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
                                                <i class="fa fa-times" style="font-size: 20px;" onclick="JSxPkgDelLocShowTime('<?= $aValue->FNEvnID ?>', '<?= $aValue->FNLocID ?>', '<?= $aValue->FNTmhID ?>');"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </div>       
                </div>
            </div>
        </div>
    </div>
</div>     







   <!-- 
<div class="row">
 <div class="col-lg-12 xWpage-body" style="padding-left: 0; padding-right: 0;">
        <div class="row" style="margin-top:5px;" style="padding-left: 0; padding-right: 0;">
            <div class="col-md-12 col-xs-12" style="padding-left: 0; padding-right: 0;">
                <?= language('ticket/package/package', 'tPkg_TimeTable') ?>5555+
                <div style="margin-top:5px;">
                    <div class="form-control xCNModPanal" id=odvPkgLocTimeTableHDPanal style="overflow-x:hidden;overflow-y:auto;border-color: rgb(238, 238, 238); border-style: solid; border-width: 2px;">
                        <?php if (isset($oLocTimeTableHD[0]->FNTmhID)): ?>
                            <?php foreach ($oLocTimeTableHD AS $aValue): ?>  
                                <div class="row" style="padding:5px; margin-right: -15px;">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="col-md-1 col-xs-1 xCNRemovePadding">
                                            <?= $aValue->FNTmhID ?> 
                                        </div>	
                                        <div class="col-md-9 col-xs-9 xCNRemovePadding">
                                            <?= $aValue->FTTmhName ?>
                                        </div>
                                        <div class="col-md-2 col-xs-2 text-right xCNRemovePadding">
                                            <?php if ($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
                                            <i class="fa fa-list " style="font-size: 15px;" onclick="JSxPkgViewDetailLocShowTime('<?= $aValue->FNTmhID ?> ');"></i> &nbsp; <i class="fa fa-plus-square" style="font-size: 15px;" onclick="JSxPkgAddLocShowTime('<?= $aValue->FNTmhID ?>');"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
       </div> -->
<!--
        <div class="row">
            <div class="col-md-12 col-xs-12" style="padding-left: 0; padding-right: 0;">
                <?= language('ticket/package/package', 'tPkg_ShowTime') ?> 
                <div style="margin-top:5px;">
                    <div class="xCNModPanal" id="odvPkgLocShowTimePanal" style="overflow-x:hidden;overflow-y:auto;border-color: rgb(238, 238, 238); border-style: solid; border-width: 2px;">
                        <div class="row">
                            <div class="col-md-12 col-xs-12" style="background: #eeeeee;">
                                <div class="col-md-1 col-xs-1 xCNRemovePadding">
                                    <?= language('ticket/package/package', 'tPkg_Round') ?>
                                </div>	
                                <div class="col-md-4 col-xs-4 xCNRemovePadding">
                                    <?= language('ticket/package/package', 'tName') ?>
                                </div>
                                <div class="col-md-3 col-xs-3 xCNRemovePadding">
                                    <?= language('ticket/package/package', 'tPkg_RoundStartsFromDate') ?>
                                </div>
                                <div class="col-md-3 col-xs-3 xCNRemovePadding">
                                    <?= language('ticket/package/package', 'tPkg_RoundToDate') ?>
                                </div>
                                <div class="col-md-4 col-xs-4 text-right xCNRemovePadding">
                                </div>
                            </div>
                        </div>
                        <?php if (isset($oLocShwTime[0]->FNEvnID)): ?>
                            <?php foreach ($oLocShwTime AS $aValue): ?>  
                                <div class="row" style="padding:5px;">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="col-md-1 col-xs-1 xCNRemovePadding">
                                            <?= $aValue->FNTmhID ?> 
                                        </div>	
                                        <div class="col-md-4 col-xs-4 xCNRemovePadding">
                                            <?= $aValue->FTTmhName ?>
                                        </div>
                                        <div class="col-md-3 col-xs-3 xCNRemovePadding">
                                            <?= $aValue->FDShwStartDate ?> 
                                            <?= $aValue->FTShwStartTime ?> 
                                        </div>
                                        <div class="col-md-3 col-xs-3 xCNRemovePadding">
                                            <?= $aValue->FDShwEndDate ?> 
                                            <?= $aValue->FTShwEndTime ?> 
                                        </div>
                                        <div class="col-md-1 col-xs-1 text-right xCNRemovePadding">
                                            <?php if ($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
                                                <i class="fa fa-times" style="font-size: 20px;" onclick="JSxPkgDelLocShowTime('<?= $aValue->FNEvnID ?>', '<?= $aValue->FNLocID ?>', '<?= $aValue->FNTmhID ?>');"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> -->

<script>

    $('#odvPkgLocTimeTableHDPanal').css('height', '90px');
    $('#odvPkgLocShowTimePanal').css('height', '90px');

</script>
