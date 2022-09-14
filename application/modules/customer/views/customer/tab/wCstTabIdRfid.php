
    <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCustomerRfidForm">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTRfidCode')?></label>
                    <input 
                        type="text" 
                        id="oetAddRfidCode" 
                        name="oetAddRfidCode" 
                        placeholder="<?php echo language('customer/customer/customer','tCSTVAlidateRFIDCard');?>"
                        data-validate ="<?php echo language('customer/customer/customer','tCSTVAlidateRFIDCard');?>">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('customer/customer/customer','tCSTRfidName')?></label>
                    <input 
                        type="text" 
                        id="oetAddRfidName" 
                        name="oetAddRfidName" 
                       placeholder="<?php echo language('customer/customer/customer','tCSTVAlidateCardName');?>"
                        data-validate ="<?php echo language('customer/customer/customer','tCSTVAlidateCardName');?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="from-group" style="margin-top: 26px;float:right">
                    <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" onclick="JSxCSTRfidFormValidate();"><?=language('customer/customer/customer','tCSTAddCard')?></button>

                </div>
            </div>
        </div>
    </form>

    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCustomerRfidRecord">
        <button style="display:none" type="submit" id="obtSave_oliCstRfid" onclick="JSnCSTAddEditCustomerRfid()"></button>
        <button style="display:none" type="submit" id="obtCancel_oliCstRfid" onclick="JSnCSTCancelCustomerRfid()"></button>
        <input type="hidden" name="oetCstCode" id="oetCstCodeRfid" value="<?=$tCstCode?>">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <table class="table table-striped table-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th class="xCNTextBold text-left" style="width:42.5%;"><?= language('customer/customer/customer','tCSTRfidCode')?></th>
                            <th class="xCNTextBold text-left" style="width:42.5%;"><?= language('customer/customer/customer','tCSTRfidName')?></th>
                            <th class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customer/customer','tCSTDelete')?></th>
                            <th class="xCNTextBold text-center" style="width:10%;"><?= language('customer/customer/customer','tCSTEdit')?></th>
                        </tr>
                    </thead>
                    <tbody id="otbCstRfidContainer">
                    <?php if(@!empty($aResult['raRfid'])) : ?>
                        <?php foreach($aResult['raRfid'] as $rfidKey => $aRfidVal) : $rfidKey++;?>
                            <tr class="text-center xCNTextDetail2 otrCstRfid" id="<?=$rfidKey?>" id-name="RfidRow<?=$rfidKey?>">
                                <td class="text-left">
                                    <div class="validate-input" data-validated="Plese Insert RFID Code">
                                        <input 
                                            name="oetRfidCode<?=$rfidKey?>" 
                                            id="oetRfidCode<?=$rfidKey?>" 
                                            type="text" 
                                            class="xWRfid xWCstRfidCode input100 xCNTextDetail2" 
                                            value="<?=$aRfidVal['rtCstID']?>" 
                                            onkeyup="JSxCSTRfidCodeRecordValidate(this, event);"
                                            disabled="true">
                                    </div>
                                </td>
                                <td class="text-left">
                                    <div class="validate-input" data-validated="Plese Insert RFID Name">
                                        <input 
                                            name="oetRfidName<?=$rfidKey?>" 
                                            id="oetRfidName<?=$rfidKey?>" 
                                            type="text" 
                                            class="xWRfid xWCstRfidName input100 xCNTextDetail2" 
                                            value="<?=$aRfidVal['rtCrfName']?>"
                                            onkeyup="JSxCSTRfidNameRecordValidate(this, event);"
                                            disabled="true">
                                    </div>
                                </td>
                                <td>
                                    <img class="xCNIconTable xWCstRfidDelete" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSxCSTRfidDeleteOperator('<?=$aRfidVal['rtCstID']?>','<?=$aRfidVal['rtCstCode']?>','<?php echo language('common/main/main','tBCHYesOnNo');?>')">
                                </td>
                                <td>
                                    <img class="xCNIconTable xWCstRfidEdit" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSxCSTRfidEditOperator(this, event)">
                                    <img class="xCNIconTable hidden xWCstRfidSave xCNIconSave" onclick="JSxCSTRfidSaveOperator('<?=$aRfidVal['rtCstID']?>','<?=$aRfidVal['rtCstCode']?>','<?=$rfidKey?>')">
                                    <img class="xCNIconTable hidden xWCstRfidCancel xCNIconReback" onclick="JSxCSTRfidCancelOperator(this, event)">
                                </td>
                                <!-- <td><i style="display:block;text-align:center;" class="fa fa-trash-o fa-lg xWCstRfidDelete" onClick="JSxCSTRfidDeleteOperator(this, event)"></i></td> -->
                                <!-- <td>
                                    <i class="fa fa-pencil-square-o fa-lg xWCstRfidEdit" onclick="JSxCSTRfidEditOperator(this, event)"></i> 
                                    <i class="fa fa-floppy-o fa-lg hidden xWCstRfidSave" onclick="JSxCSTRfidSaveOperator(this, event)"></i> 
                                    <i class="fa fa-reply fa-lg hidden xWCstRfidCancel" onclick="JSxCSTRfidCancelOperator(this, event)"></i> 
                                </td> -->
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                            <tr id="otrNoRfidData"><td class='text-center xCNTextDetail2' colspan='4'><?php echo language('customer/customer/customer','tCSTNotfound');?></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <!--Modal Delete Single-->
    <div id="odvModalDeleteSingle2" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
        <div class="modal-dialog">
            <div class="modal-content text-left">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospConfirmDelete2"> - </span>
                    <input type='hidden' id="ohdConfirmIDDelete">
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelete2" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm')?></button>
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>


