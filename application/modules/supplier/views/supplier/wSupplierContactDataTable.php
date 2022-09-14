<div class="row">
    <div class="col-md-12 col-sm-12">
        <br>   
        <table id="otbSplDataList" class="table table-striped">
            <thead>
                <tr>
                    <th nowarp class="text-center xCNTextBold" width="10%"><?php echo  language('supplier/supplier/supplier','tSPLTBNo')?></th>
                    <th nowarp class="text-center xCNTextBold" width="20%"><?php echo  language('supplier/supplier/supplier','tSPLTBConName')?></th>
                    <th nowarp class="text-center xCNTextBold" width="20%"><?php echo  language('supplier/supplier/supplier','tSPLTBConMail')?></th>
                    <th nowarp class="text-center xCNTextBold" width="15%"><?php echo  language('supplier/supplier/supplier','tSPLTBConTel')?></th>
                    <th nowarp class="text-center xCNTextBold" width="15%"><?php echo  language('supplier/supplier/supplier','tSPLTBConFax')?></th>
                    <th nowarp class="text-center xCNTextBold" width="10%"><?php echo  language('supplier/supplier/supplier','tDelete')?></th>
                    <th nowarp class="text-center xCNTextBold" width="10%"><?php echo  language('supplier/supplier/supplier','tEdit')?></th>
                </tr>
            </thead>
            <tbody> 
                <?php 
                $tNum=0;
                if(@$aSplContact['raItems']!=""){
                    foreach($aSplContact['raItems'] as $tDataContact){ ?>
                     
                        <tr class=" xCNTextDetail2 otrSupplier" id="otrSupplier" data-code="" data-name="">
                            <td  nowarp class="text-center"><?php echo ++$tNum; ?></td>
                            <td nowarp><?php echo $tDataContact['FTCtrName']?></td>
                            <td nowarp><?php echo $tDataContact['FTCtrEmail']?></td>
                            <td nowarp><?php echo $tDataContact['FTCtrTel']?></td>
                            <td nowarp><?php echo $tDataContact['FTCtrFax']?></td>
                            <td nowarp class="text-center">
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoSupplierContactDel('<?php echo $tDataContact['FTSplCode']?>','<?php echo $tDataContact['FNCtrSeq']?>','<?php echo $tDataContact['FTCtrName'] ;?>')">
                            </td>
                            <td nowarp class="text-center">
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageSupplierContactEdit('<?php echo $tDataContact['FTSplCode']?>','<?php echo $tDataContact['FNCtrSeq']?>')">
                            </td>
                        </tr>
                <?php }
                }else{?>
                            <tr class=" xCNTextDetail2 otrSupplier" id="otrSupplier" data-code="" data-name="">
                            <td  nowarp class="text-center" colspan="7"><?php echo  language('supplier/supplier/supplier','tSPLTBInvalidCon')?></td>
                        </tr>
                <?php }?>
                <input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
                <input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">
            </tbody>
            
        </table>     
    </div>
</div>

<div class="modal fade" id="odvModalDelContact">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDeleteContact" class="xCNTextModal"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirmContact" onClick="JSoSupplierDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm')?>
                </button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel')?>
                </button>
            </div>
        </div>
    </div>
</div>