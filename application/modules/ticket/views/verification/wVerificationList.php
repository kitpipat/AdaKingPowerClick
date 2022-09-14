<?php if (@$oVFNList[0]->FTShdDocNo != ''): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center"><?= language('ticket/verification/verification', 'tOrderNumber') ?></th>
                <th class="text-center"><?= language('ticket/verification/verification', 'tSlip') ?></th>
                <th class="text-center"><?= language('ticket/verification/verification', 'tBank') ?></th>
                <th class="text-center"><?= language('ticket/verification/verification', 'tBranch') ?></th>
                <th class="text-center"><?= language('ticket/verification/verification', 'tPaymentDate') ?></th>
                <th class="text-center"><?= language('ticket/verification/verification', 'tOrders') ?></th>
                <th class="text-center"><?= language('ticket/verification/verification', 'tReceipts') ?></th>
                <th class="text-center"><?= language('ticket/verification/verification', 'tName') ?></th>
                <th class="text-center"><?= language('ticket/verification/verification', 'tTelephoneNumber') ?></th>
                <?php if ($oAuthen['tAutStaAppv'] == '1'): ?>            
                    <th class="text-center"><?= language('ticket/verification/verification', 'tPaymentConfirmation') ?></th> 
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($oVFNList as $key => $oValue) : ?>	
                <tr>
                    <td><?= $oValue->FTShdDocNo ?></td>
                    <td class="text-center">
                        <?php
                        if(isset($oValue->FTImgObj) && !empty($oValue->FTImgObj)){
                            $tFullPatch = './application/modules/'.$oValue->FTImgObj;
                            if (file_exists($tFullPatch)){
                                $tPatchImg = base_url().'/application/modules/'.$oValue->FTImgObj;
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                            }
                        }else{
                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                        }
                        ?>
                        <input type="hidden" id="ohdImgObj<?= $oValue->FTShdDocNo ?>" value="<?=$tPatchImg?>">							
                        <img class="img-reponsive" src="<?=$tPatchImg?>" style="width:36px;"></td>
                        <input type="hidden" id="ohdShdDocNo<?= $oValue->FTShdDocNo ?>" value="<?= $oValue->FTShdDocNo ?>">
                        <input type="hidden" id="ohdBnkName<?= $oValue->FTShdDocNo ?>" value="<?= $oValue->FTBnkName ?>">
                        <input type="hidden" id="ohdPmoName<?= $oValue->FTShdDocNo ?>" value="<?= $oValue->FTPmoName ?>">
                        <input type="hidden" id="ohdShdDocDate<?= $oValue->FTShdDocNo ?>" value="<?= date("d-m-Y H:i", strtotime($oValue->FDShdDocDate)) ?>">
                        <input type="hidden" id="ohdFAmt<?= $oValue->FTShdDocNo ?>" value="<?= number_format($oValue->FCSrcNet, 2) ?>">
                        <input type="hidden" id="ohdAmt<?= $oValue->FTShdDocNo ?>" value="<?= number_format($oValue->FCSrcAmt, 2) ?>">
                        <input type="hidden" id="ohdCstName<?= $oValue->FTShdDocNo ?>" value="<?= $oValue->FTCstName ?>">
                        <input type="hidden" id="ohdCstTel<?= $oValue->FTShdDocNo ?>" value="<?= $oValue->FTCstTel ?>">
                        <input type="hidden" id="ohdCstKeyAccess<?= $oValue->FTShdDocNo ?>" value="<?= $oValue->FTCstKeyAccess ?>">
                        <input type="hidden" id="ohdCstEmail<?= $oValue->FTShdDocNo ?>" value="<?= $oValue->FTCstEmail ?>">
                    </td>
                    <td><?= $oValue->FTBnkName ?></td>
                    <td><?= $oValue->FTPmoName ?></td>
                    <td><?= date("d-m-Y H:i", strtotime($oValue->FDShdDocDate)) ?></td>
                    <td><?= number_format($oValue->FCSrcNet, 2) ?></td>
                    <td><?= number_format($oValue->FCSrcAmt, 2) ?></td>
                    <td><?= $oValue->FTCstName ?></td>
                    <td><?= $oValue->FTCstTel ?></td>
                    <?php if ($oAuthen['tAutStaAppv'] == '1'): ?>            
                        <td><a class="link-pop" onclick="FSxCheckVerification('<?= $oValue->FTShdDocNo ?>');"><i class="fa fa-cog"></i> <?= language('ticket/verification/verification', 'tPaymentManagement') ?></a></td>
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

<div id="oModalBankVerification" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?= language('ticket/verification/verification','tShowInfoGetPaid')?></label>
                    <div class="pull-right">
                    <?php if ($oAuthen['tAutStaAppv'] == '1'): ?>            
                    <button type="button" class="btn btn-default xCNBTNPrimery" onclick="FSxVerification('<?= $nPageNo ?>');"><span><?= language('ticket/verification/verification','tConfirm')?></span></button>
                    <?php endif;?>                    
                    <button type="button" class="btn btn-danger xCNBTNDefult" data-dismiss="modal"><span><?= language('ticket/verification/verification','tCancel')?></span></button>                     
                </div>
            </div>
        <div class="modal-body">                        
    <div class="row">                       
        <div class="col-md-3">
            <img class="img-reponsive" id="oImgObj" style="width: 100%;" src="<?php echo base_url('application/modules/common/assets/images/Noimage.png');?>">
                </div>
                    <div class="col-md-4">
                        <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tOrderNumber')?></label>
                                <input class="form-control" type="text" id="oetFTShdDocN" disabled="">
                        </div> 
                        <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tBank')?></label>
                                <input class="form-control" type="text" id="oetFTBnkName" disabled="">
                        </div>
                        <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tPaymentDate')?></label>
                                <input class="form-control" type="text" id="oetFDShdDocDate" disabled="">
                        </div>
                        <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tOrders')?></label>
                                <input class="form-control" type="text" id="oetFCSrcFAmt" disabled="">
                        </div>
                        <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tAmountActuallyEarned')?></label>
                                <input class="form-control xWDecimal" type="text" id="oetFCSrcNet">
                        </div>
                        <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tName')?></label>
                                <input class="form-control" type="text" id="oetFTCstName" disabled="">
                        </div>
                        </div>
             
                        <div class="col-md-4">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tBranch')?></label>
                            <input class="form-control" type="text" id="oetFTPmoName" disabled="">
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tReceipts')?></label>
                            <input class="form-control" type="text" id="oetFCSrcAmt" disabled="">
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tTelephoneNumber')?></label>
                            <input class="form-control" type="text" id="oetFTCstTel" disabled="">
                        </div>
                        <input type="hidden" id="ohdFTCstEmail">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>