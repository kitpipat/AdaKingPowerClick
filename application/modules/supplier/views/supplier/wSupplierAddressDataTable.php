<div class="row">
    <div class="col-md-12 col-sm-12">
        <br>   
        <table id="otbSplDataList" class="table table-striped">
            <thead>
                <tr>
                    <th nowarp class="text-center xCNTextBold" width="10%"><?php echo  language('supplier/supplier/supplier','tSPLTBNo')?></th>
                    <th nowarp class="text-center xCNTextBold" width="35%"><?php echo  language('supplier/supplier/supplier','tSPLTBAddName')?></th>
                    <th nowarp class="text-center xCNTextBold" width="30%"><?php echo  language('supplier/supplier/supplier','tCtrRmk')?></th>
                    <th nowarp class="text-center xCNTextBold" width="10%"><?php echo  language('supplier/supplier/supplier','tDelete')?></th>
                    <th nowarp class="text-center xCNTextBold" width="10%"><?php echo  language('supplier/supplier/supplier','tEdit')?></th>
                </tr>
            </thead>
            <tbody> 
                <?php 
                $tNum=0;
                if(@$aSplAddress['raItems']!=""){
                    foreach($aSplAddress['raItems'] as $tDataAddrrss){ ?>
                     
                        <tr class=" xCNTextDetail2 otrSupplier" id="otrSupplier" data-code="" data-name="">
                            <td  nowarp class="text-center"><?php echo ++$tNum; ?></td>
                            <td nowarp><?php echo $tDataAddrrss['FTAddName']?></td>
                            <td nowarp><?php echo $tDataAddrrss['FTAddRmk']?></td>
                            <td nowarp class="text-center">
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoSupplierAddressDel('<?php echo $tDataAddrrss['FTSplCode']?>','<?php echo $tDataAddrrss['FNAddSeqNo']?>','<?php echo $tDataAddrrss['FTAddName'] ;?>')">
                            </td>
                            <td nowarp class="text-center">
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageSupplierAddressEdit('<?php echo $tDataAddrrss['FTSplCode']?>','<?php echo $tDataAddrrss['FNAddSeqNo']?>')">
                            </td>
                        </tr>
                <?php }
                }else{?>
                            <tr class=" xCNTextDetail2 otrSupplier" id="otrSupplier" data-code="" data-name="">
                            <td  nowarp class="text-center" colspan="5"><?php echo  language('supplier/supplier/supplier','tSPLTBInvalidAdd')?></td>
                        </tr>
                <?php }?>
                <input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
                <input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">
            </tbody>
            
        </table>     
    </div>
</div>

<div class="modal fade" id="odvModalDelSupplier">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" onClick="JSoSupplierDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm')?>
                </button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel')?>
                </button>
            </div>
        </div>
    </div>
</div>