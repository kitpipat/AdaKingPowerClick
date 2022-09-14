<?php if (@$oVFNList[0]->FTShdDocNo != ''): ?>
<div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center"><?= language('ticket/verification/verification','tOrderNumber')?></th>
                <th class="text-center"><?= language('ticket/verification/verification','tSlip')?></th>
                <th class="text-center"><?= language('ticket/verification/verification','tBank')?></th>
                <th class="text-center"><?= language('ticket/verification/verification','tBranch')?></th>
                <th class="text-center"><?= language('ticket/verification/verification','tPaymentDate')?></th>
                <th class="text-center"><?= language('ticket/verification/verification','tOrders')?></th>
                <th class="text-center"><?= language('ticket/verification/verification','tReceipts')?></th>
                <th class="text-center"><?= language('ticket/verification/verification','tAmountReceived')?></th>
                <th class="text-center"><?= language('ticket/verification/verification','tName')?></th>
                <?php if ($oAuthen['tAutStaCancel'] == '1'): ?>            
                    <th class="text-center"><?= language('ticket/verification/verification','tPaymentConfirmation')?></th> 
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
                        <input type="hidden" id="ohdSrcNet<?= $oValue->FTShdDocNo ?>" value="<?= number_format($oValue->FCSrcNet, 2) ?>">
                        <input type="hidden" id="ohdUsrName<?= $oValue->FTShdDocNo ?>" value="<?= $oValue->FTUsrName ?>">
                        <input type="hidden" id="ohdChkPay<?= $oValue->FTShdDocNo ?>" value="<?= date("d-m-Y H:i", strtotime($oValue->FDTxhChkPay)) ?>">
                    </td>
                    <td><?= $oValue->FTBnkName ?></td>
                    <td><?= $oValue->FTPmoName ?></td>
                    <td><?= date("d-m-Y H:i", strtotime($oValue->FDShdDocDate)) ?></td>
                    <td><?= number_format($oValue->FCSrcNet, 2) ?></td>
                    <td><?= number_format($oValue->FCSrcAmt, 2) ?></td>
                    <td><?= number_format($oValue->FCSrcNet, 2) ?></td>
                    <td class="text-center"><?= $oValue->FTCstName ?></td>
                    <?php if ($oAuthen['tAutStaCancel'] == '1'): ?>            
                        <td class="text-center"><a class="link-pop" onclick="FSxCheckCancellation('<?= $oValue->FTShdDocNo ?>');"><i class="fa fa-cog"></i> <?= language('ticket/verification/verification','tPaymentManagement')?></a></td>
                    <?php endif; ?>						
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>    
    <?php else: ?>
        <div style="margin: auto; text-align: center; padding: 50px;">
        <?= language('ticket/user/user', 'tDataNotFound') ?>
            </div>
            <?php endif ?>
            <script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/verification/jVerification.js"></script>
            <script type="text/javascript">
        $('.selectpicker').selectpicker();
    </script>
<div id="oModalTicketCancellation" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('ticket/verification/verification','tShowInfoGetPaid')?></label>
                    <div class="pull-right">
                    <?php 
                        if ($oAuthen['tAutStaCancel'] == '1'): ?>            
                    <button type="button" class="btn btn-default xCNBTNPrimery" onclick="FSxCallCancelTicket('<?= $nPageNo ?>');"><span><?= language('ticket/verification/verification','tSave')?></span></button>
                        <?php endif; ?>
                <button type="button" class="btn btn-danger xCNBTNDefult" data-dismiss="modal"><span><?= language('ticket/verification/verification','tCancel')?></span></button>                     
            </div>
        </div>
        <div class="modal-body">  
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <img class="img-reponsive" id="oImgObj" style="width: 100%;" src="<?php echo base_url('application/modules/common/assets/images/Noimage.png');?>">
                        </div>
                    <div class="col-md-4">
                <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tOrderNumber')?></label>
                        <input class="form-control" type="text" id="oetFTShdDocN" disabled="">
                        <span class="focus-input100"></span>
                </div>
                <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tBank')?></label>
                        <input class="form-control" type="text" id="oetFTBnkName" disabled="">
                        <span class="focus-input100"></span>
                </div>
                <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tPaymentDate')?></label>
                        <input class="form-control" type="text" id="oetFDShdDocDate" disabled="">
                        <span class="focus-input100"></span>
                </div>    
                <div class="form-group"> 
                        <span class="xCNLabelFrm"><?= language('ticket/verification/verification','tOrders')?></span>
                        <input class="form-control" type="text" id="oetFCSrcFAmt" disabled="">
                        <span class="focus-input100"></span>
                </div>
                <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tAmountActuallyEarned')?></label>
                        <input class="form-control" type="text" id="oetFCSrcNet" disabled="">
                        <span class="focus-input100"></span>
                </div>
                <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tExaminer')?></Label>
                        <input class="form-control" type="text" id="oetFTUsrName" disabled="">
                        <span class="focus-input100"></span>
                </div>
                <div class="from-group">    
                        <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tName')?></label>
                        <input class="form-control" type="text" id="oetFTCstName" disabled="">
                        <span class="focus-input100"></span> 
                </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('ticket/verification/verification','tReason')?></label>
                        <div>
                        <div class="form-input">
                        <select class="selectpicker form-control" id="ocmFTTxhRsnCode" name="ocmFTTxhRsnCode" style="width: 100%">
                        <option value=""><?= language('ticket/verification/verification','tIdentifyReason')?></option>
                        <?php foreach ($oRSN as $key => $oValue) :?>
                        <option value="<?=$oValue->FTRsnCode?>"><?=$oValue->FTRsnName?></option> 
                        <?php endforeach; ?>
                        </select>
                        </div>
                        <span class="focus-input100"></span>
                        </div>
                </div>
                <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tBranch')?></label>
                        <input class="form-control" type="text" id="oetFTPmoName" disabled="">
                        <span class="focus-input100"></span>
                </div>
                <div class="form-group">
                        <span class="xCNLabelFrm"><?= language('ticket/verification/verification','tReceipts')?></label>
                        <input class="form-control" type="text" id="oetFCSrcAmt" disabled="">
                        <span class="focus-input100"></span>
                </div>
                <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tCheckDate')?></label>
                        <input class="form-control" type="text" id="oetFDTxhChkPay" disabled="">
                        <span class="focus-input100"></span>
                </div>
                <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tTelephoneNumber')?></label>
                        <input class="form-control" type="text" id="oetFTCstTel" disabled="">
                        <span class="focus-input100"></span>
                </div>          
            </div>
        </div>
    </div>
</div>
</div>
</div>